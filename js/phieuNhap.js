$(document).ready(function () {
    let currentPage = 1;
    let currentStatus = "chuaXuLy"; 
    const limit = 6;

    function loadPhieuNhaps(page, status) {
        let data = {
            action: 'listPhieuNhap',
            status: status,
            page: page,
            limit: limit
        }

        $.ajax({
            url: "./controller/phieuNhap.controller.php",
            type: "GET",
            data: data,
            dataType: "json",
            success: function (response) {
                renderPhieuNhap(response.phieuNhaps);
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
            loadPhieuNhaps(page, currentStatus); 
        });
    }

    loadPhieuNhaps(currentPage, currentStatus);

    ////////////////////////////////////// TAB TRANG THAI //////////////////////////////////////
    $(".tab-item[data-status='chuaXuLy']").addClass("active");
    $(".tab-item").click(function() {
        $('.tab-item').removeClass('active');
        $(this).addClass('active');

        currentStatus = $(this).data("status");
        currentPage = 1; 
        loadPhieuNhaps(currentPage, currentStatus); 
    })
    
})

function renderPhieuNhap(phieuNhaps) {
    $("#phieuNhapList").html("");
    if (phieuNhaps && phieuNhaps.length > 0) {
        phieuNhaps.forEach(pn => {
            let row = `
                <tr> 
                    <td>${pn.id}</td>
                    <td>${pn.nhacungcap_nam}</td>
                    <td>${pn.nguoidung_name}</td>
                    <td>${pn.date}</td>
                    <td>${pn.total_amount}</td>
                    
                    <td>
                        <button id="detailPhieuNhap" class="btn edit-btn" data-id="${pn.id}">Chi tiết</button>
                    </td>
                </tr>
            `;
            $("#phieuNhapList").append(row);
        });
    } else {
        $("#phieuNhapList").append('<tr><td colspan="6">Không tìm thấy kết quả</td></tr>');
    }
}