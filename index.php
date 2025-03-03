<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <?php 
        include_once("./view/sidebar.php");
    ?>
    <div id="content">
        <?php
            // trang chủ mặc định
            include_once("./view/pages/trangChu.php");
        ?>
    </div>
    
</body>
</html>