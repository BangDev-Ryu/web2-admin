<?php
    require_once '../../model/connect.php';
    $db = new connectDB();

    // Thiết lập phân trang
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10; // Số sản phẩm mỗi trang
    $offset = ($current_page - 1) * $limit;

    // Lấy tổng số sản phẩm
    $total = $db->totalByCondition('sanpham', '', '1=1', []);
    $total_pages = ceil($total / $limit);

    // Lấy danh sách sản phẩm theo limit và offset
    $sql = "SELECT * FROM sanpham LIMIT ? OFFSET ?";
    $products = $db->executePrepared($sql, [$limit, $offset]);

    // Tính toán phạm vi số trang hiển thị
    $range = 2; // Số trang hiển thị mỗi bên
    $start_page = max($current_page - $range, 1);
    $end_page = min($current_page + $range, $total_pages);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/sanPham.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="table-content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá nhập</th>
                    <th>Giá bán</th>
                    <th>Số lượng</th>
                    <th>Thể loại</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                if ($products->num_rows > 0) {
                    while($row = $products->fetch_assoc()) { 
                ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><img src="<?php echo "#"; ?>" alt="Product Image" width="50"></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo number_format($row['import_price']); ?></td>
                        <td><?php echo number_format($row['selling_price']); ?></td>
                        <td><?php echo $row['stock_quantity']; ?></td>
                        <td><?php echo $row['theloai_id']; ?></td>
                        <td><?php echo $row['trangthai_id']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['updated_at'])); ?></td>
                        <td>
                            <a href="#" class="btn-edit">Sửa</a>
                            <a href="#" class="btn-delete">Xóa</a>
                        </td>
                    </tr>
                <?php 
                    }
                } else {
                ?>
                    <tr>
                        <td colspan="10">Không có sản phẩm nào</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Thêm phần phân trang vào trước </body> -->
    <div class="pagination">
        <?php if ($total_pages > 1): ?>
            <!-- Nút Previous -->
            <?php if ($current_page > 1): ?>
                <a href="?page=<?php echo $current_page-1 ?>" class="page-link">&laquo; Trước</a>
            <?php endif; ?>

            <!-- Các số trang -->
            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                <?php if ($i == $current_page): ?>
                    <span class="page-link active"><?php echo $i ?></span>
                <?php else: ?>
                    <a href="?page=<?php echo $i ?>" class="page-link"><?php echo $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <!-- Nút Next -->
            <?php if ($current_page < $total_pages): ?>
                <a href="?page=<?php echo $current_page+1 ?>" class="page-link">Sau &raquo;</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
    $db->close();
?>