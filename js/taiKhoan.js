$(document).ready(function () {
    let currentPage = 1;
    const limit = 8;

    function loadTaiKhoans(page) {
        $.ajax({
            url: "./controller/taiKhoan.controller.php",
            type: "GET",
            data: { action: "listTaiKhoan", page: page, limit: limit },
            dataType: "json",
            success: function (response) {
                $("#taiKhoanList").html("");
                response.taiKhoans.forEach(taiKhoan => {
                    let row = `
                        <tr>
                            <td>${taiKhoan.taiKhoan_id}</td>
                            <td><img src="${taiKhoan.picture}" alt="User Image" width="60"></td>
                            <td>${taiKhoan.fullname}</td>
                            <td>${taiKhoan.username}</td>
                            <td>${taiKhoan.email}</td>
                            <td>${taiKhoan.phone}</td>
                            <td>${taiKhoan.date_of_birth}</td>
                            <td>${taiKhoan.chucvu}</td>
                            <td>${taiKhoan.role_name}</td>
                            <td>${taiKhoan.trangthai_name}</td>
                            <td>${taiKhoan.created_at}</td>
                            <td>
                                <button id="editTaiKhoan" class="btn edit-btn" data-id="${taiKhoan.taiKhoan_id}">Sửa</button>
                                <button id="deleteTaiKhoan" class="btn delete-btn" data-id="${taiKhoan.taiKhoan_id}">Xóa</button>
                            </td>
                        </tr>
                    `;
                    $("#taiKhoanList").append(row);
                });

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
            loadTaiKhoans(page);
        });
    }

    loadTaiKhoans(currentPage);

    const  taiKhoanModal = $("#taiKhoanModal");
    const deleteModal = $("#deleteModal");
    let deleteId = null;

    // Đóng modal 
    $(".close, .cancel-btn").click(function() {
        taiKhoanModal.hide();
        deleteModal.hide();
    });

    function loadTrangThai() {
        $.ajax({
            url: "./controller/trangThai.controller.php",
            type: "GET",
            data: { action: "listTrangThai", type: "taiKhoan" },
            dataType: "json",
            success: function(response) {
                $("#trangthai_id").html("");
                response.trangThais.forEach(tt => {
                    $("#trangthai_id").append(`<option value="${tt.id}">${tt.name}</option>`);
                });
            }
        });
    }

    function loadChucVu() {
        $.ajax({
            url: "./controller/chucVu.controller.php",
            type: "GET",
            data: { action: "listChucVu", type: "taiKhoan" },
            dataType: "json",
            success: function(response) {
                $("#chucvu_id").html("");
                response.chucVus.forEach(cv => {
                    $("#chucvu_id").append(`<option value="${cv.id}">${cv.role_name}</option>`);
                });
            }
        });
    }
    
    // Nút thêm tài khoản
    $("#addTaiKhoan").click(function () {
        $("#modalTitle").text("Thêm Tài Khoản");
        $("#taiKhoanForm")[0].reset();
        $("#taiKhoanId").val("");
        $("#taiKhoanModal").show();
        loadTrangThai();
        loadChucVu();
    });

    // Nút sửa tài khoản
    $(document).on("click", ".edit-btn", function () {
        const id = $(this).data("id");
        $.ajax({
            url: "./controller/taiKhoan.controller.php",
            type: "GET",
            data: { action: "getTaiKhoan", id: id },
            dataType: "json",
            success: function (response) {
                $("#modalTitle").text("Sửa Tài Khoản");
                $("#taiKhoanId").val(response.taiKhoan.id);
                $("#username").val(response.taiKhoan.username);
                $("#password").val(""); // Không hiển thị mật khẩu
                $("#trangthai_id").val(response.taiKhoan.trangthai_id);
                $("#type_account").val(response.taiKhoan.type_account);
                $("#taiKhoanModal").show();
            },
        });
    });

    // Submit form thêm/sửa tài khoản
    $("#taiKhoanForm").submit(function (e) {
        e.preventDefault();
        const data = {
            id: $("#taiKhoanId").val(),
            username: $("#username").val(),
            password: $("#password").val(),
            trangthai_id: $("#trangthai_id").val(),
            type_account: $("#type_account").val(),
            action: $("#taiKhoanId").val() ? "updateTaiKhoan" : "addTaiKhoan",
        };

        $.ajax({
            url: "./controller/taiKhoan.controller.php",
            type: "POST",
            data: data,
            success: function (response) {
                $("#taiKhoanModal").hide();
                loadTaiKhoans(currentPage);
            },
        });
    });

    // Nút xóa tài khoản
    $(document).on("click", ".delete-btn", function() {
        deleteId = $(this).data("id");
        deleteModal.show();
    });

    // Xác nhận xóa
    $("#confirmDelete").click(function() {
        if (deleteId) {
            $.ajax({
                url: "./controller/taiKhoan.controller.php",
                type: "POST",
                data: { action: "deleteTaiKhoan", id: deleteId },
                success: function(response) {
                    deleteModal.hide();
                    loadTheLoais(currentPage);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

});