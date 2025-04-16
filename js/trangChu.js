$(document).ready(function() {
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
                    beginAtZero: true
                }
            }
        }
    });

    // Xử lý nút thống kê
    $("#generateStats").click(function() {
        const startDate = $("#startDate").val();
        const endDate = $("#endDate").val();
        const statsType = $("#statsType").val();

        if(!startDate || !endDate) {
            alert("Vui lòng chọn khoảng thời gian");
            return;
        }

        $.ajax({
            url: "./controller/thongKe.controller.php",
            type: "GET",
            data: {
                action: "getTop5Customers",
                startDate: startDate,
                endDate: endDate
            },
            dataType: "json",
            success: function(response) {
                // Cập nhật biểu đồ
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
                                    Chi tiết
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
});