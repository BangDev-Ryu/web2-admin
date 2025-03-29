$(document).ready(function () {
    let currentPage = 1;
    const limit = 8;

    function loadTheLoais(page) {
        $.ajax({
            url: "./controller/theLoai.controller.php",
            type: "GET",
            data: { action: "listTheLoai", page: page, limit: limit },
            dataType: "json",
            success: function (response) {
                $("#theLoaiList").html("");
                response.theLoais.forEach(theLoai => {
                    let row = `
                        <tr>
                            <td>${theLoai.id}</td>
                            <td>${theLoai.name}</td>
                            <td>${theLoai.description}</td>
                            <td>${theLoai.trangthai_name}</td>
                            <td>
                                <button class="btn edit-btn" data-id="${theLoai.id}">Sửa</button>
                                <button class="btn delete-btn" data-id="${theLoai.id}">Xóa</button>
                            </td>
                        </tr>
                    `;
                    $("#theLoaiList").append(row);
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
            loadTheLoais(page);
        });
    }

    // Xử lý tìm kiếm
    let searchTimeout;
    $("#searchCategory").on("input", function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadTheLoais(1);
        }, 500);
    });

    loadTheLoais(currentPage);
});