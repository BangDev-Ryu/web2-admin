$(document).ready(function () {
    let currentPage = 1;
    let currentStatus = "chuaXuLy"; 
    const limit = 6;
    let originalProducts = [];

    function loadPhieuNhaps(page, status) {
        let data = {
            action: 'listPhieuNhap',
            status: status,
            page: page,
            limit: limit
        }

        $.ajax({
            url: "./controller/phieuNhap.controller.php",
            type: "GET",
            data: data,
            dataType: "json",
            success: function (response) {
                renderPhieuNhap(response.phieuNhaps);
                renderPagination(response.totalPages, page);
            },
            error: function (xhr, status, error) {
                console.error("Lỗi AJAX:", error);
                console.error("Trạng thái:", status);
                console.error("Phản hồi từ server:", xhr.responseText);
            }
        })
    }

    function renderPagination(totalPages, currentPage) {
        $("#pagination").html("");

        if (currentPage > 1) {
            $("#pagination").append(
                `<button class="page-btn prev-btn" data-page="${currentPage - 1}"> < </button>`
            );
        }

        const maxVisiblePages = 4;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

        if (endPage - startPage < maxVisiblePages - 1) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        for (let i = startPage; i <= endPage; i++) {
            const isActive = i === currentPage ? "active" : "";
            $("#pagination").append(
                `<button class="page-btn ${isActive}" data-page="${i}">${i}</button>`
            );
        }

        if (currentPage < totalPages) {
            $("#pagination").append(
                `<button class="page-btn next-btn" data-page="${currentPage + 1}"> > </button>`
            );
        }

        $(".page-btn").click(function () {
            const page = $(this).data("page");
            loadPhieuNhaps(page, currentStatus); 
        });
    }

    loadPhieuNhaps(currentPage, currentStatus);

    ////////////////////////////////////// TAB TRANG THAI //////////////////////////////////////
    $(".tab-item[data-status='chuaXuLy']").addClass("active");
    $(".tab-item").click(function() {
        $('.tab-item').removeClass('active');
        $(this).addClass('active');

        currentStatus = $(this).data("status");
        currentPage = 1; 
        loadPhieuNhaps(currentPage, currentStatus); 
    })


    ////////////////////////////////////// MODAL //////////////////////////////////////
    const phieuNhapModal = $("#phieuNhapModal");

    $(".close, #closeModal").click(function() {
        phieuNhapModal.hide();
    });

    $(document).on("click", "#addPhieuNhap", function () {
        phieuNhapModal.show();
        loadSanPhams();
        loadNhaCungCap();
        setCurrentDate();
    })

    // Xử lý thanh range lợi nhuận
    $("#sanPhamProfit").on("input", function() {
        const value = $(this).val();
        $("#profitValue").text(value + "%");
    });

    // Load danh sách sản phẩm khi mở modal thêm phiếu nhập
    function loadSanPhams() {
        $.ajax({
            url: "./controller/sanPham.controller.php",
            type: "GET",
            data: { 
                action: "listAllSanPham"
            },
            dataType: "json",
            success: function(response) {
                originalProducts = response.products; // Lưu danh sách gốc
                renderSanPhamTable(originalProducts);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function loadNhaCungCap() {
        $.ajax({
            url: "./controller/nhaCungCap.controller.php",
            type: "GET",
            data: { action: "listAllNhaCungCap" },
            dataType: "json",
            success: function(response) {
                $("#nhaCungCap").html("");
                $("#nhaCungCap").append(`<option value="">Chọn nhà cung cấp</option>`);
                response.nhaCungCaps.forEach(ncc => {
                    $("#nhaCungCap").append(`<option value="${ncc.id}">${ncc.name}</option>`);
                });
            }
        });
    }

    function setCurrentDate() {
        const now = new Date();
        const dateStr = now.toLocaleDateString('vi-VN', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
        });
        $("#ngayTao").text(dateStr);
    }

    let searchTimeout;
    $("#searchSanPhamTable").on("input", function() {
        clearTimeout(searchTimeout);
        const searchValue = $(this).val().toLowerCase().trim();

        searchTimeout = setTimeout(() => {
            if (!searchValue) {
                renderSanPhamTable(originalProducts);
                return;
            }

            const filteredProducts = originalProducts.filter(product => 
                product.id.toString().toLowerCase().includes(searchValue) ||
                product.name.toLowerCase().includes(searchValue)
            );

            renderSanPhamTable(filteredProducts);
        }, 300);
    });

    let selectedProduct = null; // Biến lưu sản phẩm được chọn

    // chọn sản phẩm trong bảng
    $(document).on("click", "#sanPhamTable tbody tr", function() {
        $("#sanPhamTable tbody tr").removeClass("selected");
        $(this).addClass("selected");
        selectedProduct = {
            id: $(this).data("id"),
            name: $(this).find("td:nth-child(2)").text(),
            price: parseInt($(this).find("td:nth-child(3)").text().replace(/[^\d]/g, '')),
            stock: parseInt($(this).find("td:nth-child(4)").text())
        };
    });

    // thêm sản phẩm
    $("#addSanPham").click(function() {
        if (!selectedProduct) {
            alert("Vui lòng chọn sản phẩm!");
            return;
        }

        const quantity = parseInt($("#sanPhamQuantity").val());
        const profit = parseInt($("#sanPhamProfit").val());
        
        if (quantity <= 0) {
            alert("Số lượng phải lớn hơn 0!");
            return;
        }

        if (quantity > selectedProduct.stock) {
            alert("Số lượng vượt quá số lượng tồn!");
            return;
        }

        // Kiểm tra sản phẩm đã tồn tại
        const existingRow = $(`#ctPhieuNhapList tr[data-id="${selectedProduct.id}"]`);
        
        if (existingRow.length > 0) {
            // Nếu sản phẩm đã tồn tại
            const currentQuantity = parseInt(existingRow.find("td:nth-child(3)").text());
            const newQuantity = currentQuantity + quantity;
            
            // Cập nhật số lượng và lợi nhuận
            existingRow.find("td:nth-child(3)").text(newQuantity);
            existingRow.find("td:nth-child(5)").text(profit + "%");
        } else {
            // Nếu là sản phẩm mới
            const newRow = `
                <tr data-id="${selectedProduct.id}">
                    <td>${selectedProduct.id}</td>
                    <td>${selectedProduct.name}</td>
                    <td>${quantity}</td>
                    <td>${formatCurrency(selectedProduct.price)}</td>
                    <td>${profit}%</td>
                    <td>
                        <button class="btn delete-ctpn-btn">
                            Xóa
                        </button>
                    </td>
                </tr>
            `;
            $("#ctPhieuNhapList").append(newRow);
        }

        updateTongTien();

        // Reset các giá trị
        selectedProduct = null;
        $("#sanPhamTable tbody tr").removeClass("selected");
        $("#sanPhamQuantity").val(1);
        $("#sanPhamProfit").val(0);
        $("#profitValue").text("0%");
    });

    //xóa chi tiết phiếu nhập
    $(document).on("click", ".delete-ctpn-btn", function() {
        $(this).closest("tr").remove();
        updateTongTien();
    });

    function updateTongTien() {
        let total = 0;
        $("#ctPhieuNhapList tr").each(function() {
            const price = parseInt($(this).find("td:nth-child(4)").text().replace(/[^\d]/g, ''));
            const quantity = parseInt($(this).find("td:nth-child(3)").text());
            total += price * quantity;
        });
        $("#tongTien").text(formatCurrency(total));
    }
})

function renderPhieuNhap(phieuNhaps) {
    $("#phieuNhapList").html("");
    if (phieuNhaps && phieuNhaps.length > 0) {
        phieuNhaps.forEach(pn => {
            let row = `
                <tr> 
                    <td>${pn.id}</td>
                    <td>${pn.nhacungcap_nam}</td>
                    <td>${pn.nguoidung_name}</td>
                    <td>${pn.date}</td>
                    <td>${pn.total_amount}</td>
                    
                    <td>
                        <button id="detailPhieuNhap" class="btn edit-btn" data-id="${pn.id}">Chi tiết</button>
                    </td>
                </tr>
            `;
            $("#phieuNhapList").append(row);
        });
    } else {
        $("#phieuNhapList").append('<tr><td colspan="6">Không tìm thấy kết quả</td></tr>');
    }
}

function renderSanPhamTable(products) {
    $("#sanPhamList").html("");
    console.log("Products:", products); // Kiểm tra dữ liệu
    if (products && products.length > 0) {
        products.forEach(sp => {
            let row = `
                <tr data-id="${sp.id}"> 
                    <td>${sp.id}</td>
                    <td>${sp.name}</td>
                    <td>${formatCurrency(sp.selling_price)}</td>
                    <td>${sp.stock_quantity}</td>
                </tr>
            `;
            $("#sanPhamList").append(row);
            console.log("Row added:", row); // Kiểm tra từng dòng được thêm vào
        });
    }
    console.log("Table content:", $("#sanPhamList").html()); // Kiểm tra nội dung cuối cùng
}

function formatCurrency(value) {
    return parseInt(value).toLocaleString('vi-VN') + 'đ';
}

