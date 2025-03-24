$(document).ready(function() {
    $('.nav-link[data-page="trangChu"]').addClass('active');
    
    $('.nav-link').click(function(e) {
        e.preventDefault();
        var page = $(this).data("page");
        
        $('.nav-link').removeClass('active');
        
        $(this).addClass('active');        
        loadPage(page);
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
});