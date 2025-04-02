$(document).ready(function () {
    let currentPage = 1;
    const limit = 6;
    let searchValue = ""; 

    // Sửa lại hàm loadProducts để hỗ trợ tìm kiếm
    function loadProducts(page, searchValue, filterData = null) {
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

        currentPage = 1; // Reset về trang 1 khi filter
        loadProducts(currentPage, searchValue, filterData);
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