$(document).ready(function () {
    let currentPage = 1;
    const limit = 8;

    function loadProducts(page) {
        $.ajax({
            url: "./controller/sanPham.controller.php",
            type: "GET",
            data: { action: "list", page: page, limit: limit },
            dataType: "json",
            success: function (response) {
                $("#productList").html("");
                response.products.forEach(product => {
                    let row = `
                        <tr> 
                            <td>${product.id}</td>
                            <td><img src="${product.image_url}" alt="Product Image" width="60"></td>
                            <td>${product.name}</td>
                            <td>${product.selling_price}</td>
                            <td>${product.stock_quantity}</td>
                            <td>${product.theloai_id}</td>
                            <td>${product.trangthai_id}</td>
                            <td>${product.updated_at}</td>
                            <td>
                                <button class="btn edit-btn" data-id="${product.id}">Sửa</button>
                                <button class="btn delete-btn" data-id="${product.id}">Xóa</button>
                            </td>
                        </tr>
                    `;
                    $("#productList").append(row);
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
            loadProducts(page);
        });
    }

    loadProducts(currentPage);
});