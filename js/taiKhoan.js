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
});