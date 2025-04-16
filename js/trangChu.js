$(document).ready(function() {
    const today = new Date();
    const thirtyDaysAgo = new Date();
    thirtyDaysAgo.setDate(today.getDate() - 30);
    
    $("#startDate").val(thirtyDaysAgo.toISOString().split('T')[0]);
    $("#endDate").val(today.toISOString().split('T')[0]);

    // Khởi tạo biểu đồ
    const ctx = document.getElementById('statsChart').getContext('2d');
    let statsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Tổng chi tiêu',
                data: [],
                backgroundColor: '#4CAF50',
                borderColor: '#45a049',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(value);
                        }
                    }
                },
                x: {
                    ticks: {
                        callback: function(value, index) {
                            const customer = this.chart.data.customers[index];
                            return ['ID: ' + customer.id, customer.name];
                        }
                    }
                }
            }
        }
    });

    // Xử lý nút thống kê
    $("#generateStats").click(function() {
        const startDate = $("#startDate").val();
        const endDate = $("#endDate").val();

        if(!startDate || !endDate) {
            alert("Vui lòng chọn khoảng thời gian");
            return;
        }

        if(new Date(startDate) > new Date(endDate)) {
            alert("Ngày bắt đầu phải nhỏ hơn ngày kết thúc");
            return;
        }

        $.ajax({
            url: "./controller/donHang.controller.php",
            type: "GET",
            data: {
                action: "getTop5NguoiDungs",
                startDate: startDate,
                endDate: endDate
            },
            dataType: "json",
            success: function(response) {
                statsChart.data.customers = response.customers;
                
                statsChart.data.labels = response.customers.map(c => c.name);
                statsChart.data.datasets[0].data = response.customers.map(c => c.total_spending);
                statsChart.update();

                // Cập nhật bảng
                $("#customerList").html("");
                response.customers.forEach(customer => {
                    const row = `
                        <tr>
                            <td>${customer.id}</td>
                            <td>${customer.name}</td>
                            <td>${formatCurrency(customer.total_spending)}</td>
                            <td>
                                <button class="btn btn-detail" data-id="${customer.id}">
                                    Xem
                                </button>
                            </td>
                        </tr>
                    `;
                    $("#customerList").append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error("Lỗi khi tải dữ liệu:", error);
            }
        });
    });

    function formatCurrency(value) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(value);
    }

    const donHangNguoiDungModal = $("#donHangNguoiDungModal");
    const CTDonHangModal = $("#CTDonHangModal");

    // Đóng modal handlers
    $(".close, #closeDonHangModal").click(function() {
        donHangNguoiDungModal.hide();
    });
    
    $(".close, #closeCTDonHangModal").click(function() {
        CTDonHangModal.hide();
    });
    
    $(document).on("click", ".btn-detail", function() {
        const nguoiDungId = $(this).data("id");
        const startDate = $("#startDate").val();
        const endDate = $("#endDate").val();
        
        $.ajax({
            url: "./controller/donHang.controller.php",
            type: "GET",
            data: {
                action: "getDonHangNguoiDung",
                nguoiDungId: nguoiDungId,
                startDate: startDate,
                endDate: endDate
            },
            dataType: "json",
            success: function(response) {
                donHangNguoiDungModal.show();
                renderCustomerOrders(response.orders);
            }
        });
    });

    $(document).on("click", ".order-detail-btn", function() {
        const orderId = $(this).data("id");
        
        $.ajax({
            url: "./controller/donHang.controller.php",
            type: "GET",
            data: {
                action: "listCTDonHang",
                id: orderId
            },
            dataType: "json",
            success: function(response) {
                CTDonHangModal.show();
                renderOrderDetail(response.ctDonHangs);
                
            }
        });
    });

    function renderCustomerOrders(orders) {
        $("#donHangNguoiDungList").html("");
        if (orders && orders.length > 0) {
            orders.forEach(order => {
                const row = `
                    <tr>
                        <td>${order.id}</td>
                        <td>${order.order_date}</td>
                        <td>${formatCurrency(order.total_amount)}</td>
                        <td>${order.payment}</td>
                        <td>${order.khuyenmai_name || 'Không có'}</td>
                        <td>
                            <button class="btn edit-btn order-detail-btn" data-id="${order.id}">
                                Chi tiết
                            </button>
                        </td>
                    </tr>
                `;
                $("#donHangNguoiDungList").append(row);
            });
        } else {
            $("#donHangNguoiDungList").append('<tr><td colspan="6">Không có đơn hàng</td></tr>');
        }
    }

    function renderOrderDetail(details) {
        $("#CTDonHangList").html("");
        if (details && details.length > 0) {
            details.forEach(detail => {
                const row = `
                    <tr>
                        <td>${detail.sanpham_name}</td>
                        <td>${detail.quantity}</td>
                        <td>${formatCurrency(detail.price)}</td>
                    </tr>
                `;
                $("#CTDonHangList").append(row);
            });
        } else {
            $("#CTDonHangList").append('<tr><td colspan="3">Không có chi tiết đơn hàng</td></tr>');
        }
    }
});