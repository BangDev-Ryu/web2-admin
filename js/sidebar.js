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
            url: "./view/pages/" + page + ".php",
            type: 'GET',
            success: function(data) {
                $('#content').html(data);
                history.pushState(null, "", "index.php?page=" + page);
            },
            error: function(xhr, status, error) {
                $('#content').html('<h1>Có lỗi xảy ra: ' + error + '</h1>');
            }
        });
    }
});