$(document).ready(function() {
    $("#loginForm").submit(function(e) {
        e.preventDefault();
        
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
                window.location.href = "../../index.php";
                const result = JSON.parse(response);
                if (result.success) {
                } else {
                    $("#error-message")
                        .text(result.message || "Đăng nhập thất bại")
                        .removeClass("success-message");
                }
                // try {
                // } catch (e) {
                //     $("#error-message").text("Có lỗi xảy ra khi xử lý dữ liệu");
                // }
            },
            error: function() {
                $("#error-message").text("Có lỗi xảy ra trong quá trình đăng nhập");
            }
        });
    });

    // Xóa thông báo lỗi khi người dùng nhập
    $('input').on('input', function() {
        $("#error-message").text('').removeClass("success-message");
    });
});