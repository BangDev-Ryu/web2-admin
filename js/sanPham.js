$(document).ready(function () {
    let currentPage = 1;
    const limit = 6;

    let searchValue = ""; // giá trị ô input tìm kiếm
    let filterData = {}; // các thuộc tính lọc

    function loadProducts(page, searchValue, filterData) {
        let data = { 
            action: "listSanPham", 
            page: page, 
            limit: limit,
        };

        if (searchValue && searchValue.trim() !== "") {
            data.action = "listSanPhamBySearch";
            data.search = searchValue;
        }

        if (filterData && Object.keys(filterData).length > 0) {
            data.action = "listSanPhamByFilter";
            data.filter = filterData;
        }

        $.ajax({
            url: "./controller/sanPham.controller.php",
            type: "GET",
            data: data,
            dataType: "json",
            success: function (response) {
                renderSanPham(response.products);
                renderPagination(response.totalPages, page);
            },
            error: function (xhr, status, error) {
                console.error("Lỗi AJAX:", error);
                console.error("Trạng thái:", status);
                console.error("Phản hồi từ server:", xhr.responseText);
            }
        });
    }

    ///////////////////////////////////////// PAGINATION /////////////////////////////////////////
    
    function renderPagination(totalPages, currentPage) {
        $("#pagination").html("");

        if (currentPage > 1) {
            $("#pagination").append(
                `<button class="page-btn prev-btn" data-page="${currentPage - 1}"> < </button>`
            );
        }

        const maxVisiblePages = 4;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

        if (endPage - startPage < maxVisiblePages - 1) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        for (let i = startPage; i <= endPage; i++) {
            const isActive = i === currentPage ? "active" : "";
            $("#pagination").append(
                `<button class="page-btn ${isActive}" data-page="${i}">${i}</button>`
            );
        }

        if (currentPage < totalPages) {
            $("#pagination").append(
                `<button class="page-btn next-btn" data-page="${currentPage + 1}"> > </button>`
            );
        }

        $(".page-btn").click(function () {
            const page = $(this).data("page");
            loadProducts(page, searchValue, filterData); 
        });
    }

    loadProducts(currentPage, searchValue);

    ///////////////////////////////////////// SEARCH /////////////////////////////////////////

    // Tìm kiếm
    let searchTimeout;

    $("#searchProduct").on("input", function() {
        searchValue = $(this).val().trim();
        
        clearTimeout(searchTimeout);
        
        currentPage = 1; // Reset về trang 1 khi tìm kiếm
        filterData = {}; // Reset filter khi tìm kiếm

        if (searchValue === "") {
            loadProducts(currentPage, searchValue, filterData);
            return;
        }

        searchTimeout = setTimeout(() => {
            loadProducts(currentPage, searchValue, filterData);
        }, 300);
    });

    ///////////////////////////////////////// FILTER /////////////////////////////////////////

    // Xử lý thanh range giá
    const minPriceRange = $("#minPriceRange");
    const maxPriceRange = $("#maxPriceRange");
    const minPriceValue = $("#minPriceValue");
    const maxPriceValue = $("#maxPriceValue");

    function formatPrice(value) {
        return parseInt(value).toLocaleString('vi-VN') + 'đ';
    }

    function updatePriceRanges() {
        let minVal = parseInt(minPriceRange.val());
        let maxVal = parseInt(maxPriceRange.val());

        if (minVal >= maxVal && minVal >= 100000) {
            minVal = maxVal - 100000; 
            minPriceRange.val(minVal);
        }

        minPriceValue.text(formatPrice(minVal));
        maxPriceValue.text(formatPrice(maxVal));
    }

    minPriceRange.on("input", function() {
        updatePriceRanges();
    });

    maxPriceRange.on("input", function() {
        updatePriceRanges();
    });

    // xử lý select chủ đề và trạng thái
    function loadChuDeFilter() {
        $.ajax({
            url: "./controller/chuDe.controller.php",
            type: "GET",
            data: { action: "listAllChuDe" },
            dataType: "json",
            success: function(response) {
                $("#chuDeFilter").html("");
                $("#chuDeFilter").append(`<option value="0">Tất cả</option>`);
                response.chuDes.forEach(cd => {
                    $("#chuDeFilter").append(`<option value="${cd.id}">${cd.name}</option>`);
                });
            }
        });
    }

    function loadTheLoaiFilter() {
        $.ajax({
            url: "./controller/theLoai.controller.php",
            type: "GET",
            data: { action: "listAllTheLoai" },
            dataType: "json",
            success: function(response) {
                $("#theLoaiFilter").html("");
                $("#theLoaiFilter").append(`<option value="0">Tất cả</option>`);
                response.theLoais.forEach(tl => {
                    $("#theLoaiFilter").append(`<option value="${tl.id}">${tl.name}</option>`);
                });
            }
        });
    }


    loadChuDeFilter();
    loadTheLoaiFilter();

    // Reset filter
    $("#resetFilter").click(function() {
        minPriceRange.val(0);
        maxPriceRange.val(10000000);
        updatePriceRanges();
        $("#chuDeFilter").val(0);
        $("#theLoaiFilter").val(0);
        
    });

    // Apply filter
    $("#applyFilter").click(function() {
        filterData = {
            min_price: minPriceRange.val(),
            max_price: maxPriceRange.val(),
            chude_id: $("#chuDeFilter").val(),
            theloai_id: $("#theLoaiFilter").val(),
            
        };

        currentPage = 1; 
        searchValue = "";

        loadProducts(currentPage, searchValue, filterData);
    });

    ///////////////////////////////////////// MODAL /////////////////////////////////////////

    // Xử lý modal
    const sanPhamModal = $("#sanPhamModal");
    
    // Đóng modal 
    $(".close, .cancel-btn").click(function() {
        sanPhamModal.hide();
    });

    // Load danh sách chủ đề
    function loadChuDe() {
        $.ajax({
            url: "./controller/chuDe.controller.php",
            type: "GET",
            data: { action: "listAllChuDe" },
            dataType: "json",
            success: function(response) {
                $("#sanPham-chuDe").html("");
                response.chuDes.forEach(cd => {
                    $("#sanPham-chuDe").append(`<option value="${cd.id}">${cd.name}</option>`);
                });
            }
        });
    }


    // Nút thêm sản phẩm
    $("#addProduct").click(function() {
        $("#modalTitle").text("Thêm Sản Phẩm");
        $("#sanPhamForm")[0].reset();
        $("#sanPhamId").val("");
        $("#sanPham-quantity").attr("disabled", true);
        $("#sanPham-quantity").val(0);
        $("#imagePreview").attr("src", "");
        loadChuDe();
        sanPhamModal.show();
    });

    // Nút sửa sản phẩm
    $(document).on("click", ".editProduct", function() {
        const id = $(this).data("id");
        $.ajax({
            url: "./controller/sanPham.controller.php",
            type: "GET",
            data: { action: "getSanPham", id: id },
            dataType: "json",
            success: function(response) {
                sanPhamModal.show();
                $("#modalTitle").text("Sửa Sản Phẩm");
                $("#sanPhamId").val(response.sanPham.id);
                $("#sanPham-name").val(response.sanPham.name);
                $("#sanPham-description").val(response.sanPham.description);
                // Hiển thị giá gốc không định dạng cho input
                $("#sanPham-price").val(parseInt(response.sanPham.selling_price));
                $("#sanPham-quantity").attr("disabled", true);
                $("#sanPham-quantity").val(response.sanPham.stock_quantity);
                $("#imagePreview").attr("src", response.sanPham.image_url);
                
                loadChuDe();
                
                setTimeout(() => {
                    $("#sanPham-chuDe").val(response.sanPham.chude_id);
                }, 50);
            }
        });
    });

    // Preview ảnh khi chọn file
    $("#picture").change(function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#picture").attr("src", e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // Submit form thêm/sửa
    $("#sanPhamForm").submit(function(e) {
        e.preventDefault();
        const now = new Date().toISOString().slice(0, 19).replace('T', ' ');
        
        let formData = new FormData();
        formData.append("action", $("#sanPhamId").val() ? "updateSanPham" : "addSanPham");
        formData.append("id", $("#sanPhamId").val());
        formData.append("name", $("#sanPham-name").val());
        formData.append("description", $("#sanPham-description").val());
        formData.append("selling_price", $("#sanPham-price").val());
        formData.append("stock_quantity", $("#sanPham-quantity").val());
        formData.append("chude_id", $("#sanPham-chuDe").val());
        formData.append("updated_at", now);

        // const data = {
        //     id: $("#sanPhamId").val(),
        //     name: $("#sanPham-name").val(),
        //     description: $("#sanPham-description").val(),
        //     selling_price: $("#sanPham-price").val(),
        //     stock_quantity: $("#sanPham-quantity").val(),
        //     theloai_id: $("#sanPham-theLoai").val(),
        //     trangthai_id: $("#sanPham-trangThai").val(),
        //     warranty_days: $("#sanPham-warranty").val(),
        //     updated_at: now,
        //     action: $("#sanPhamId").val() ? "updateSanPham" : "addSanPham"
        // };

        // Thêm file ảnh nếu có
        const imageFile = $("#sanPham-image")[0].files[0];
        if (imageFile) {
            // data.img = imageFile;
            // data.image_url = "";
            formData.append("img", imageFile);
            formData.append("image_url", "");
        } 
        else if ($("#imagePreview").attr("src")) {
            // Nếu không có file mới, giữ lại ảnh cũ
            // data.image_url = $("#imagePreview").attr("src");
            formData.append("image_url", data.image_url);
        }
        console.log(formData);

        $.ajax({
            url: "./controller/sanPham.controller.php",
            type: "POST",
            data: formData,
            processData: false, 
            contentType: false, 
            success: function(response) {
                sanPhamModal.hide();
                loadProducts(currentPage, searchValue);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    const deleteModal = $("#deleteModal");
    let deleteId = null;

    $(document).on("click", ".cancel-btn", function() {
        deleteModal.hide();
    });

    // Nút xóa sản phẩm
    $(document).on("click", ".deleteProduct", function() {
        deleteId = $(this).data("id");
        deleteModal.show();
    });

    // Xác nhận xóa
    $("#confirmDeleteSanPham").click(function() {
        if (deleteId) {
            $.ajax({
                url: "./controller/sanPham.controller.php",
                type: "POST",
                dataType: "json",
                data: { 
                    action: "deleteSanPham", 
                    id: deleteId 
                },
                success: function(response) {
                    deleteModal.hide();
                    loadProducts(currentPage, searchValue, filterData);
                    alert("Xóa sản phẩm thành công!");
                    
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert("Có lỗi xảy ra khi xóa sản phẩm!");
                }
            });
        }
    });

    ////////////////////////////////////////// CHECK QUYEN //////////////////////////////////////////
    function checkQuyenSanPham() {
        $("#addProduct").hide();
        $(".editProduct").hide();
        $(".deleteProduct").hide();

        $.ajax({
            url: "./controller/quyen.controller.php",
            type: "GET",
            data: { action: "checkQuyen" },
            dataType: "json",
            success: function(response) {
                if (response.success && response.quyens) {
                    response.quyens.forEach(function(quyen) {
                        switch(quyen) {
                            case 6:
                                $("#addProduct").show();
                                break;
                            case 7:
                                $(".editProduct").show();
                                break;
                            case 8:
                                $(".deleteProduct").show();
                                break;
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Lỗi AJAX:", error);
            }
        });
    }

    checkQuyenSanPham();

    // Thêm hàm format currency cho hiển thị
    function formatCurrency(value) {
        return parseInt(value).toLocaleString('vi-VN') + 'đ';
    }

    // Chỉnh sửa phần renderSanPham
    function renderSanPham(products) {
        $("#productList").html("");
        if (products && products.length > 0) {
            products.forEach(product => {
                let row = `
                    <tr data-id="${product.id}"> 
                        <td>${product.id}</td>
                        <td><img src="${product.image_url}" alt="Product Image" width="60"></td>
                        <td>${product.name}</td>
                        <td>${formatCurrency(product.selling_price)}</td>
                        <td>${product.stock_quantity}</td>
                        <td>${product.theloai_name}</td>
                        <td>${product.chude_name}</td>
                        <td>
                            <button class="btn edit-btn editProduct" data-id="${product.id}">Sửa</button>
                            <button class="btn delete-btn deleteProduct" data-id="${product.id}">Xóa</button>
                        </td>
                    </tr>
                `;
                $("#productList").append(row);
            });
            
            checkQuyenSanPham();
        } else {
            $("#productList").append('<tr><td colspan="9">Không tìm thấy kết quả</td></tr>');
        }
    }

    
});


// function getRandomColor() {
//     var letters = '0123456789ABCDEF';
//     var color = '#';
//     for (var i = 0; i < 6; i++) {
//       color += letters[Math.floor(Math.random() * 16)];
//     }
//     return color;
// }

// setInterval(function() {
//     document.querySelector('.table-content').style.boxShadow = "0px 8px 24px" + getRandomColor();
// }, 200)