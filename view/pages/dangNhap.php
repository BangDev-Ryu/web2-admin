<?php
session_start();

// Nếu đã đăng nhập thì chuyển về trang chủ
if(isset($_SESSION['usernameAdmin'])) {
    header('Location: ../../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../../css/login.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <!-- <i class="fas fa-user-shield"></i> -->
            <h2>ADMIN LOGIN</h2>
        </div>

        <form id="loginForm">
            <div id="error-message" class="error-message"></div>

            <div class="input-group">
                <div class="input-field">
                    <label for="username">Username</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" id="username" required>
                    </div>
                </div>

                <div class="input-field">
                    <label for="password">Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" required>
                        <span class="toggle-password">
                            <!-- <i class="fas fa-eye"></i>  -->
                        </span>
                    </div>
                </div>
            </div>

            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt"></i>
                Login
            </button>
        </form>
    </div>

    <script src="../../js/dangNhap.js"></script>
</body>
</html>
