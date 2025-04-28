$(document).ready(function () {
    let currentPage = 1;
    const limit = 6;
    let searchValue = ""; 
    let filterData = {};

    function loadChuDes(page, searchValue, filterData) {
        let data = { 
            action: "listChuDe", 
            page: page, 
            limit: limit,
        };

        if (searchValue && searchValue.trim() !== "") {
            data.action = "listChuDeBySearch";
            data.search = searchValue;
        }

        if (filterData && Object.keys(filterData).length > 0) {
            data.action = "listChuDeByFilter";
            data.filter = filterData;
        }

        $.ajax({
            url: "./controller/chuDe.controller.php",
            type: "GET",
            data: data,
            dataType: "json",
            success: function (response) {
                console.log("Dữ liệu sau khi lọc:", response);

                renderChuDe(response.chuDes);
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
            loadChuDes(page, searchValue, filterData); 
        });
    }

    loadChuDes(currentPage, searchValue, filterData);

    

    function loadTheLoaiFilter() {
        $.ajax({
            url: "./controller/theLoai.controller.php",
            type: "GET",
            data: { action: "listTheLoai", type: "khac" },
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

    function loadTrangThaiFilter() {
        $.ajax({
            url: "./controller/trangThai.controller.php",
            type: "GET",
            data: { action: "listTrangThai", type: "khac" },
            dataType: "json",
            success: function(response) {
                $("#trangThaiFilter").html("");
                $("#trangThaiFilter").append(`<option value="0">Tất cả</option>`);
                response.trangThais.forEach(tt => {
                    $("#trangThaiFilter").append(`<option value="${tt.id}">${tt.name}</option>`);
                });
            }
        });
    } 

    loadTrangThaiFilter();
    loadTheLoaiFilter();

    // Reset filter
    $("#resetFilter").click(function() {
        $("#theLoaiFilter").val(0);
        $("#trangThaiFilter").val(0);
    });

    // Apply filter
    $("#applyFilter").click(function() {
        filterData= {
            theloai_id: $("#theLoaiFilter").val(),
            trangthai_id : $("#trangThaiFilter").val()
        };
        currentPage = 1; 
        searchValue = "";

        loadChuDes(currentPage, searchValue, filterData);
    });


    let searchTimeout;
 
    $("#searchChuDe").on("input", function () {
        searchValue = $(this).val().trim();
       clearTimeout(searchTimeout);
       currentPage = 1;
       filterData= {};
   
        if (searchValue === "") {
            loadChuDes(currentPage, searchValue, filterData);
            return;
        }
   
        searchTimeout = setTimeout(() => {
            loadChuDes(currentPage, searchValue, filterData);
        }, 300);
   });


    // Xử lý modal
    const chuDeModal = $("#chuDeModal");
    const deleteModal = $("#deleteModal");
    let deleteId = null;

    // Đóng modal 
    $(".close, .cancel-btn").click(function() {
        chuDeModal.hide();
        deleteModal.hide();
    });

    // Nút thêm chủ đề
    $("#addChuDe").click(function() {
        $("#modalTitle").text("Thêm nhà cung cấp");
        $("#chuDeForm")[0].reset();
        $("#chuDeId").val("");
        loadTheLoai();
        loadTrangThai();
        chuDeModal.show();
    });

    function loadTheLoai() {
        return $.ajax({
            url: "./controller/theLoai.controller.php",
            type: "GET",
            data: { action: "listTheLoai", type: "khac" },
            dataType: "json",
            success: function(response) {
                $("#chuDe-theLoai").html("");
                response.theLoais.forEach(tl => {
                    $("#chuDe-theLoai").append(`<option value="${tl.id}">${tl.name}</option>`);
                });
            }
        });
    }
 
    // Load danh sách trạng thái
    function loadTrangThai() {
        return $.ajax({
            url: "./controller/trangThai.controller.php",
            type: "GET",
            data: { action: "listTrangThai", type: "khac" },
            dataType: "json",
            success: function(response) {
                $("#chuDe-trangThai").html("");
                response.trangThais.forEach(tt => {
                    $("#chuDe-trangThai").append(`<option value="${tt.id}">${tt.name}</option>`);
                });
            }
        });
    }
 
    // Nút sửa 
    $(document).on("click", ".editChuDe", function() {
        const id = $(this).data("id");
        $.ajax({
            url: "./controller/chuDe.controller.php",
            type: "GET",
            data: { action: "getChuDe", id: id },
            dataType: "json",
            success: function(response) {
            chuDeModal.show();
            console.log(response);
            $("#modalTitle").text("Sửa chủ đề");
            $("#chuDeId").val(response.chuDe.id);
            $("#chuDe-name").val(response.chuDe.name);
            loadTheLoai();
            loadTrangThai();
            setTimeout(() => {
                $("#chuDe-theLoai").val(response.chuDe.theloai_id);
                $("#chuDe-trangThai").val(response.chuDe.trangthai_id);
            }, 50)
            }
        });
    });

    // Submit form thêm/sửa
    $("#chuDeForm").submit(function(e) {
        e.preventDefault();
        const data = {
            id: $("#chuDeId").val(),
            name: $("#chuDe-name").val(),
            theloai_id: $("#chuDe-theLoai").val(),
            trangthai_id: $("#chuDe-trangThai").val(),
            action: $("#chuDeId").val() ? "updateChuDe" : "addChuDe"
        };

        $.ajax({
            url: "./controller/chuDe.controller.php",
            type: "POST",
            data: data,
            success: function(response) {
                chuDeModal.hide();
                loadChuDes(currentPage, searchValue, filterData);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
 
    // Nút xóa 
    $(document).on("click", ".deleteChude", function() {
        deleteId = $(this).data("id");
        deleteModal.show();
    });

    // Xác nhận xóa
    $("#confirmDelete").click(function() {
        if (deleteId) {
            $.ajax({
                url: "./controller/chuDe.controller.php",
                type: "POST",
                data: { action: "deleteChuDe", id: deleteId },
                success: function(response) {
                    deleteModal.hide();
                    loadChuDes(currentPage, searchValue, filterData);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

    ////////////////////////////////////////// CHECK QUYEN //////////////////////////////////////////
    function checkQuyenChuDe() {
        $("#addChuDe").hide();
        $(".editChuDe").hide();
        $(".deleteChude").hide();

        $.ajax({
            url: "./controller/quyen.controller.php",
            type: "GET",
            data: { action: "checkQuyen" },
            dataType: "json",
            success: function(response) {
                if (response.success && response.quyens) {
                    response.quyens.forEach(function(quyen) {
                        switch(quyen) {
                            case 18:
                                $("#addChuDe").show();
                                break;
                            case 19:
                                $(".editChuDe").show();
                                break;
                            case 20:
                                $(".deleteChude").show();
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

    checkQuyenChuDe();
 
    function renderChuDe(chuDes) {
        $("#chuDeList").html("");
        if (chuDes && chuDes.length > 0) {
            chuDes.forEach(cd => {
                let row = `
                    <tr> 
                        <td>${cd.id}</td>
                        <td>${cd.name}</td>
                        <td>${cd.theloai_name}</td>
                        <td>${cd.trangthai_name}</td>
                        <td>
                            <button class="btn edit-btn editChuDe" data-id="${cd.id}">Sửa</button>
                            <button class="btn delete-btn deleteChude" data-id="${cd.id}">Xóa</button>
                        </td>
                    </tr>
                `;
                $("#chuDeList").append(row);
            });
            checkQuyenChuDe();
        } else {
            $("#chuDeList").append('<tr><td colspan="9">Không tìm thấy kết quả</td></tr>');
        }
    }
});