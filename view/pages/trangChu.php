<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/actions.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/modal.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/home.css?v=<?php echo time(); ?>">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./js/trangChu.js?v=<?php echo time(); ?>"></script>
</head>
<body>
    <div class="page-content">
        <div class="stats-header">
            <div class="date-range">
                <div class="form-group">
                    <label for="startDate">Từ ngày:</label>
                    <input type="date" id="startDate">
                </div>
                <div class="form-group">
                    <label for="endDate">Đến ngày:</label>
                    <input type="date" id="endDate">
                </div>
            </div>

            <div class="stats-type">
                <div class="form-group">
                    <label for="statsType">Loại thống kê:</label>
                    <select id="statsType">
                        <option value="top5customers">Top 5 khách hàng tiềm năng</option>
                    </select>
                </div>
            </div>

            <button id="generateStats" class="btn stats-btn">
                <i class="fa-solid fa-chart-column"></i>
                <span>Thống kê</span>
            </button>
        </div>

        <div class="stats-content">
            <div class="chart-container">
                <canvas id="statsChart"></canvas>
            </div>
        </div>

        <div class="stats-table">
            <h3>Chi tiết thống kê</h3>
            <div class="table-content">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên khách hàng</th>
                            <th>Tổng chi tiêu</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="customerList">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" id="donHangNguoiDungModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Danh sách đơn hàng</h2>
            <div class="table-content">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Thanh toán</th>
                            <th>Khuyến mãi</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="donHangNguoiDungList">
                    </tbody>
                </table>
            </div>
            <div class="modal-actions">
                <button class="btn" id="closeDonHangModal">Đóng</button>
            </div>
        </div>
    </div>

    <div class="modal" id="CTDonHangModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Chi tiết đơn hàng</h2>
            <div class="table-content">
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody id="CTDonHangList">
                    </tbody>
                </table>
            </div>
            <div class="modal-actions">
                <button class="btn" id="closeCTDonHangModal">Đóng</button>
            </div>
        </div>
    </div>
</body>
</html>