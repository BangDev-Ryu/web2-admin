$(document).ready(function () {
    let currentPage = 1;
    const limit = 8;

    function loadNhaCungCaps(page) {
        $.ajax({
            url: "./controller/nhaCungCap.controller.php",
            type: "GET",
            data: { action: "listNhaCungCap", page: page, limit: limit },
            dataType: "json",
            success: function (response) {
                $("#nhaCungCapList").html("");
                response.nhaCungCaps.forEach(ncc => {
                    let row = `
                        <tr> 
                            <td>${ncc.id}</td>
                            <td>${ncc.name}</td>
                            <td>${ncc.contact_person}</td>
                            <td>${ncc.contact_email}</td>
                            <td>${ncc.contact_phone}</td>
                            <td>${ncc.address}</td>
                            <td>${ncc.trangthai_name}</td>
                            <td>
                                <button class="btn edit-btn" data-id="${ncc.id}">Sửa</button>
                                <button class="btn delete-btn" data-id="${ncc.id}">Xóa</button>
                            </td>
                        </tr>
                    `;
                    $("#nhaCungCapList").append(row);
                });

                // Render pagination
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
            loadNhaCungCaps(page);
        });
    }

    loadNhaCungCaps(currentPage);
});