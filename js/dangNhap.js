$(document).ready(function() {
    // Đổi từ submit form sang click button
    $("#loginBtn").click(function(e) {
        const username = $("#username").val().trim();
        const password = $("#password").val().trim();

        if (!username || !password) {
            $("#error-message").text("Vui lòng không để trống tên đăng nhập và mật khẩu!");
            return;
        }

        $.ajax({
            url: "../../controller/dangNhap.controller.php",
            type: "POST",
            data: {
                action: "login",
                username: username,
                password: password
            },
            success: function(response) {
                const result = JSON.parse(response);
                if (result.success) {
                    localStorage.setItem('currentPage', 'welcome');
                    window.location.href = "../../index.php?page=welcome";
                } else {
                    $("#error-message")
                        .text(result.message || "Đăng nhập thất bại")
                        .removeClass("success-message");
                }
            },
            error: function() {
                $("#error-message").text("Có lỗi xảy ra trong quá trình đăng nhập");
            }
        });
    });

    // Cho phép người dùng nhấn Enter để đăng nhập
    $(document).keypress(function(e) {
        if(e.which == 13) { // 13 là mã phím Enter
            $("#loginBtn").click();
        }
    });

    $('input').on('input', function() {
        $("#error-message").text('').removeClass("success-message");
    });
});