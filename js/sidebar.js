$(document).ready(function() {
    // Lưu page hiện tại vào localStorage khi chuyển trang
    $('.nav-link').click(function(e) {
        e.preventDefault();
        var page = $(this).data("page");
        localStorage.setItem('currentPage', page);
        
        $('.nav-link').removeClass('active');
        $(this).addClass('active');        
        loadPage(page);
    });

    // Khi load lại trang, kiểm tra localStorage
    function checkCurrentPage() {
        const currentPage = localStorage.getItem('currentPage');
        if(currentPage) {
            // Active menu tương ứng
            $('.nav-link').removeClass('active');
            $(`.nav-link[data-page="${currentPage}"]`).addClass('active');
            
            // Load nội dung trang
            loadPage(currentPage);
        } else {
            // Nếu không có page trong localStorage, load trang chủ
            $('.nav-link[data-page="trangChu"]').addClass('active');
            loadPage('trangChu');
        }
    }

    // Kiểm tra quyền và load trang khi khởi tạo
    checkQuyenSideBar();
    checkCurrentPage();

    // Xử lý logout
    $('#logoutBtn').click(function(e) {
        e.preventDefault();
        // Clear localStorage khi logout
        localStorage.clear();
        
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
            },
            error: function(error) {
                $('#content').html('<h1>Trang không hợp lệ: ' + error + '</h1>');
            }
        });
    }

    function checkQuyenSideBar() {
        $(".item[data-id='1']").hide();
        $(".item[data-id='5']").hide();
        $(".item[data-id='9']").hide();
        $(".item[data-id='13']").hide();
        $(".item[data-id='17']").hide();
        $(".item[data-id='21']").hide();
        $(".item[data-id='25']").hide();
        $(".item[data-id='29']").hide();
        $(".item[data-id='33']").hide();
        $(".item[data-id='37']").hide();

        $.ajax({
            url: "./controller/quyen.controller.php",
            type: "GET",
            data: { action: "checkQuyenSideBar" },
            dataType: "json",
            success: function(response) {
                response.quyens.forEach(function(quyen) {
                    $(".item[data-id='" + quyen.id + "']").show();
                });
            },
            error: function(xhr, status, error) {
                console.error("Lỗi AJAX:", error);
            }
        });
    }
});