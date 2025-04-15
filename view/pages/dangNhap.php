<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Login</title>
    <link rel="stylesheet" href="login-style.css">
</head>
<body>

<div class="login-container">
    <form action="login.php" method="post">
        <h2>LOGIN</h2>

        <label for="username">USERNAME</label>
        <input type="text" name="username" id="username" required>

        <label for="password">PASSWORD</label>
        <div class="password-wrapper">
            <input type="password" name="password" id="password" required>
            <span class="toggle-password" onclick="togglePassword()">o</span>
        </div>

        <button type="submit" class="login-btn">Login</button>
    </form>
</div>

<script>
function togglePassword() {
    var input = document.getElementById("password");
    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}
</script>

</body>
</html>
