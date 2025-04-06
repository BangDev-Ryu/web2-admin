$(document).ready(function () {
    let currentPage = 1;
    const limit = 6;
    let searchValue = ""; 
    let filterData = null;

    function loadProducts(page, searchValue, filterData) {
        let data = { 
            action: "listSanPham", 
            page: page, 
            limit: limit,
            search: searchValue 
        };

        if (filterData) {
            data = {...data, ...filterData};
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
            loadProducts(page, searchValue); 
        });
    }

    loadProducts(currentPage, searchValue);

    // Tìm kiếm
    let searchTimeout;

    $("#searchProduct").on("input", function() {
        searchValue = $(this).val().trim();
        
        clearTimeout(searchTimeout);
        
        currentPage = 1; // Reset về trang 1 khi tìm kiếm

        if (searchValue === "") {
            loadProducts(currentPage, searchValue);
            return;
        }

        searchTimeout = setTimeout(() => {
            loadProducts(currentPage, searchValue);
        }, 300);
    });



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

    // Reset filter
    $("#resetFilter").click(function() {
        minPriceRange.val(0);
        maxPriceRange.val(10000000);
        updatePriceRanges();
        $("#categoryFilter").val("");
        $("#statusFilter").val("");
        $("#startDate").val("");
        $("#endDate").val("");
    });

    // Apply filter
    $("#applyFilter").click(function() {
        const filterData = {
            minPrice: minPriceRange.val(),
            maxPrice: maxPriceRange.val(),
            category: $("#categoryFilter").val(),
            status: $("#statusFilter").val(),
            startDate: $("#startDate").val(),
            endDate: $("#endDate").val()
        };

        currentPage = 1; 
        console.log(filterData);
        // loadProducts(currentPage, searchValue, filterData);
    });

    // Xử lý modal
    const sanPhamModal = $("#sanPhamModal");
    
    // Đóng modal 
    $(".close, .cancel-btn").click(function() {
        sanPhamModal.hide();
    });

    // Load danh sách thể loại
    function loadTheLoai() {
        $.ajax({
            url: "./controller/theLoai.controller.php",
            type: "GET",
            data: { action: "listTheLoai" },
            dataType: "json",
            success: function(response) {
                $("#sanPham-theLoai").html("");
                response.theLoais.forEach(tl => {
                    $("#sanPham-theLoai").append(`<option value="${tl.id}">${tl.name}</option>`);
                });
            }
        });
    }

    // Load danh sách trạng thái
    function loadTrangThai() {
        $.ajax({
            url: "./controller/trangThai.controller.php",
            type: "GET",
            data: { action: "listTrangThai", type: "sanPham" },
            dataType: "json",
            success: function(response) {
                $("#sanPham-trangThai").html("");
                response.trangThais.forEach(tt => {
                    $("#sanPham-trangThai").append(`<option value="${tt.id}">${tt.name}</option>`);
                });
            }
        });
    }

    // Nút thêm sản phẩm
    $("#addProduct").click(function() {
        $("#modalTitle").text("Thêm Sản Phẩm");
        $("#sanPhamForm")[0].reset();
        $("#sanPhamId").val("");
        $("#imagePreview").attr("src", "");
        loadTheLoai();
        loadTrangThai();
        sanPhamModal.show();
    });

    // Nút sửa sản phẩm
    $(document).on("click", ".edit-btn", function() {
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
                $("#sanPham-price").val(response.sanPham.selling_price);
                $("#sanPham-quantity").val(response.sanPham.stock_quantity);
                $("#sanPham-warranty").val(response.sanPham.warranty_days);
                $("#imagePreview").attr("src", response.sanPham.image_url);
                $("#image-base64").val(""); 
                
                loadTheLoai();
                loadTrangThai();
                
                setTimeout(() => {
                    $("#sanPham-theLoai").val(response.sanPham.theloai_id);
                    $("#sanPham-trangThai").val(response.sanPham.trangthai_id);
                }, 50);
            }
        });
    });

    // Preview ảnh khi chọn file
    $("#sanPham-image").change(function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#imagePreview").attr("src", e.target.result);
                $("#image-base64").val(e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // Submit form thêm/sửa
    $("#sanPhamForm").submit(function(e) {
        e.preventDefault();
        const now = new Date().toISOString().slice(0, 19).replace('T', ' ');
        
        const data = {
            id: $("#sanPhamId").val(),
            name: $("#sanPham-name").val(),
            description: $("#sanPham-description").val(),
            selling_price: $("#sanPham-price").val(),
            stock_quantity: $("#sanPham-quantity").val(),
            theloai_id: $("#sanPham-theLoai").val(),
            trangthai_id: $("#sanPham-trangThai").val(),
            warranty_days: $("#sanPham-warranty").val(),
            image_url: $("#image-base64").val() || $("#imagePreview").attr("src"), 
            updated_at: now,
            action: $("#sanPhamId").val() ? "updateSanPham" : "addSanPham"
        };

        $.ajax({
            url: "./controller/sanPham.controller.php",
            type: "POST",
            data: data,
            success: function(response) {
                sanPhamModal.hide();
                loadProducts(currentPage, searchValue);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});

function renderSanPham(products) {
    $("#productList").html("");
    if (products && products.length > 0) {
        products.forEach(product => {
            let row = `
                <tr> 
                    <td>${product.id}</td>
                    <td><img src="${product.image_url}" alt="Product Image" width="60"></td>
                    <td>${product.name}</td>
                    <td>${product.selling_price}</td>
                    <td>${product.stock_quantity}</td>
                    <td>${product.theloai_name}</td>
                    <td>${product.trangthai_name}</td>
                    <td>${product.updated_at}</td>
                    <td>
                        <button class="btn edit-btn" data-id="${product.id}">Sửa</button>
                        <button class="btn delete-btn" data-id="${product.id}">Xóa</button>
                    </td>
                </tr>
            `;
            $("#productList").append(row);
        });
    } else {
        $("#productList").append('<tr><td colspan="9">Không tìm thấy kết quả</td></tr>');
    }
}

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