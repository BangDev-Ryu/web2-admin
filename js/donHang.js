$(document).ready(function () {
    let currentPage = 1;
    let currentStatus = "chuaXuLy"; 
    const limit = 6;

    function loadDonHangs(page, status) {
        let data = {
            action: 'listDonHang',
            status: status,
            page: page,
            limit: limit
        }

        $.ajax({
            url: "./controller/donHang.controller.php",
            type: "GET",
            data: data,
            dataType: "json",
            success: function (response) {
                renderDonHang(response.donHangs);
                renderPagination(response.totalPages, page);
            },
            error: function (xhr, status, error) {
                console.error("Lỗi AJAX:", error);
                console.error("Trạng thái:", status);
                console.error("Phản hồi từ server:", xhr.responseText);
            }
        })
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
            loadDonHangs(page, currentStatus); 
        });
    }

    loadDonHangs(currentPage, currentStatus);

    ////////////////////////////////////// TAB TRANG THAI //////////////////////////////////////
    $(".tab-item[data-status='chuaXuLy']").addClass("active");
    $(".tab-item").click(function() {
        $('.tab-item').removeClass('active');
        $(this).addClass('active');

        currentStatus = $(this).data("status");
        currentPage = 1; 
        loadDonHangs(currentPage, currentStatus); 
    })
    
})

function renderDonHang(donHangs) {
    $("#donHangList").html("");
    if (donHangs && donHangs.length > 0) {
        donHangs.forEach(dh => {
            let row = `
                <tr> 
                    <td>${dh.id}</td>
                    <td>${dh.nguoidung_name}</td>
                    <td>${dh.address}</td>
                    <td>${dh.city}</td>
                    <td>${dh.district}</td>
                    <td>${dh.ward}</td>
                    <td>${dh.order_date}</td>
                    <td>${dh.total_amount}</td>
                    <td>${dh.payment}</td>
                    <td>${dh.khuyenmai_name}</td>
                    
                    <td>
                        <button id="detailDonHang" class="btn edit-btn" data-id="${dh.id}">Chi tiết</button>
                    </td>
                </tr>
            `;
            $("#donHangList").append(row);
        });
    } else {
        $("#donHangList").append('<tr><td colspan="11">Không tìm thấy kết quả</td></tr>');
    }
}