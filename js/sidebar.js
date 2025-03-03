$(document).ready(function() {
    $('.nav-link[data-page="trangChu"]').addClass('active');
    
    $('.nav-link').click(function(e) {
        e.preventDefault();
        var page = $(this).attr('href');
        
        $('.nav-link').removeClass('active');
        
        $(this).addClass('active');        
        loadPage(page);
    });

    function loadPage(page) {
        $.ajax({
            url: page,
            type: 'GET',
            success: function(data) {
                $('#content').html(data);
            },
            error: function(xhr, status, error) {
                $('#content').html('<h2>Có lỗi xảy ra: ' + error + '</h2>');
            }
        });
    }
});