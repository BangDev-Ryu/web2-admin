$(document).ready(function() {
    $('.nav-link[data-page="trangChu"]').addClass('active');
    
    // Khởi tạo biến để theo dõi trang hiện tại
    let currentPage = '';
    
    $('.nav-link').click(function(e) {
        e.preventDefault();
        var page = $(this).data("page");
        
        // Kiểm tra nếu đang ở trang hiện tại thì không load lại
        if (currentPage === page) {
            return;
        }
        
        $('.nav-link').removeClass('active');
        $(this).addClass('active');        
        loadPage(page);
    });

    $('#logoutBtn').click(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: './controller/dangNhap.controller.php',
            type: 'POST',
            data: {
                action: 'logout'
            },
            success: function() {
                window.location.href = './view/pages/dangNhap.php';
            },
            error: function() {
                alert('Có lỗi xảy ra khi đăng xuất');
            }
        });
    });

    function loadPage(page) {
        $.ajax({
            url: "./controller/loadpage.controller.php", 
            type: 'GET',
            data: {page: page},
            success: function(data) {
                $('#content').html(data);
                history.pushState({page: page}, "", "?page=" + page);
                currentPage = page; // Cập nhật trang hiện tại
            },
            error: function(error) {
                $('#content').html('<h1>Trang không hợp lệ: ' + error + '</h1>');
            }
        });
    }
});