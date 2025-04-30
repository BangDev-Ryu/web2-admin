$(document).ready(function () {
    const locations = [
        {
          city: "Hà Nội",
          districts: [
            {
              district: "Quận Ba Đình",
              wards: [
                "Cống Vị",
                "Điện Biên",
                "Đội Cấn",
                "Giảng Võ",
                "Kim Mã",
                "Liễu Giai",
                "Ngọc Hà",
                "Ngọc Khánh",
                "Nguyễn Trung Trực",
                "Phúc Xá",
                "Quán Thánh",
                "Thành Công",
                "Trúc Bạch",
                "Vĩnh Phúc",
              ],
            },
            {
              district: "Quận Hoàn Kiếm",
              wards: [
                "Chương Dương Độ",
                "Cửa Đông",
                "Cửa Nam",
                "Đồng Xuân",
                "Hàng Bạc",
                "Hàng Bài",
                "Hàng Bồ",
                "Hàng Bông",
                "Hàng Buồm",
                "Hàng Đào",
                "Hàng Gai",
                "Hàng Mã",
                "Hàng Trống",
                "Lý Thái Tổ",
                "Phan Chu Trinh",
                "Phúc Tân",
                "Tràng Tiền",
                "Trần Hưng Đạo",
              ],
            },
            {
              district: "Quận Đống Đa",
              wards: [
                "Cát Linh",
                "Giảng Võ",
                "Hàng Bột",
                "Khâm Thiên",
                "Khương Thượng",
                "Kim Liên",
                "Láng Hạ",
                "Láng Thượng",
                "Nam Đồng",
                "Ngã Tư Sở",
                "Ô Chợ Dừa",
                "Phương Liên",
                "Phương Mai",
                "Quang Trung",
                "Quốc Tử Giám",
                "Thịnh Quang",
                "Thổ Quan",
                "Trung Liệt",
                "Trung Phụng",
                "Trung Tự",
                "Văn Chương",
                "Văn Miếu",
              ],
            },
            {
              district: "Quận Hai Bà Trưng",
              wards: [
                "Bạch Đằng",
                "Bách Khoa",
                "Bạch Mai",
                "Cầu Dền",
                "Đống Mác",
                "Đồng Nhân",
                "Đồng Tâm",
                "Đồng Xuân",
                "Lê Đại Hành",
                "Minh Khai",
                "Nguyễn Du",
                "Phạm Đình Hổ",
                "Phố Huế",
                "Quỳnh Lôi",
                "Quỳnh Mai",
                "Thanh Lương",
                "Thanh Nhàn",
                "Trương Định",
                "Vĩnh Tuy",
              ],
            },
            {
              district: "Quận Thanh Xuân",
              wards: [
                "Hạ Đình",
                "Khương Đình",
                "Khương Mai",
                "Khương Trung",
                "Nhân Chính",
                "Phương Liệt",
                "Thanh Xuân Bắc",
                "Thanh Xuân Nam",
                "Thanh Xuân Trung",
                "Thượng Đình",
              ],
            },
            {
              district: "Quận Tây Hồ",
              wards: [
                "Bưởi",
                "Nhật Tân",
                "Phú Thượng",
                "Quảng An",
                "Thụy Khuê",
                "Tứ Liên",
                "Xuân La",
                "Yên Phụ",
              ],
            },
            {
              district: "Quận Cầu Giấy",
              wards: [
                "Dịch Vọng",
                "Dịch Vọng Hậu",
                "Mai Dịch",
                "Nghĩa Đô",
                "Nghĩa Tân",
                "Quan Hoa",
                "Trung Hòa",
                "Yên Hòa",
              ],
            },
            {
              district: "Quận Hoàng Mai",
              wards: [
                "Đại Kim",
                "Định Công",
                "Giáp Bát",
                "Hoàng Liệt",
                "Hoàng Văn Thụ",
                "Lĩnh Nam",
                "Mai Động",
                "Tân Mai",
                "Thanh Trì",
                "Thịnh Liệt",
                "Trần Phú",
                "Tương Mai",
                "Vĩnh Hưng",
                "Yên Sở",
              ],
            },
            {
              district: "Quận Long Biên",
              wards: [
                "Bồ Đề",
                "Cự Khối",
                "Đức Giang",
                "Gia Thụy",
                "Giang Biên",
                "Long Biên",
                "Ngọc Lâm",
                "Ngọc Thụy",
                "Phúc Đồng",
                "Phúc Lợi",
                "Sài Đồng",
                "Thạch Bàn",
                "Thượng Thanh",
                "Việt Hưng",
              ],
            },
            {
              district: "Quận Nam Từ Liêm",
              wards: [
                "Cầu Diễn",
                "Đại Mỗ",
                "Mễ Trì",
                "Mỹ Đình 1",
                "Mỹ Đình 2",
                "Phú Đô",
                "Phương Canh",
                "Tây Mỗ",
                "Trung Văn",
                "Xuân Phương",
              ],
            },
            {
              district: "Quận Bắc Từ Liêm",
              wards: [
                "Cổ Nhuế 1",
                "Cổ Nhuế 2",
                "Đông Ngạc",
                "Đức Thắng",
                "Liên Mạc",
                "Minh Khai",
                "Phú Diễn",
                "Phúc Diễn",
                "Tây Tựu",
                "Thượng Cát",
                "Thụy Phương",
                "Xuân Đỉnh",
                "Xuân Tảo",
              ],
            },
            {
              district: "Huyện Gia Lâm",
              wards: [
                "Cát Quế",
                "Đặng Xá",
                "Đa Tốn",
                "Đình Xuyên",
                "Dương Hà",
                "Dương Quang",
                "Dương Xá",
                "Kim Lan",
                "Kim Sơn",
                "Lệ Chi",
                "Ninh Hiệp",
                "Phù Đổng",
                "Phú Thị",
                "Trâu Quỳ",
                "Yên Thường",
                "Yên Viên",
              ],
            },
            {
              district: "Huyện Đông Anh",
              wards: [
                "Bắc Hồng",
                "Cổ Loa",
                "Dục Tú",
                "Đại Mạch",
                "Đông Hội",
                "Hải Bối",
                "Kim Chung",
                "Kim Nỗ",
                "Liên Hà",
                "Mai Lâm",
                "Nguyên Khê",
                "Tàm Xá",
                "Thụy Lâm",
                "Tiên Dương",
                "Uy Nỗ",
                "Vân Hà",
                "Vân Nội",
                "Việt Hùng",
                "Vĩnh Ngọc",
                "Võng La",
                "Xuân Canh",
                "Xuân Nộn",
              ],
            },
            {
              district: "Huyện Sóc Sơn",
              wards: [
                "Bắc Sơn",
                "Đông Xuân",
                "Hiền Ninh",
                "Hồng Kỳ",
                "Kim Lũ",
                "Mai Đình",
                "Minh Phú",
                "Minh Trí",
                "Nam Sơn",
                "Phù Linh",
                "Phú Cường",
                "Phú Minh",
                "Phủ Lỗ",
                "Quang Tiến",
                "Tân Dân",
                "Tân Hưng",
                "Thụy Hương",
                "Tiên Dược",
                "Trung Giã",
                "Việt Long",
                "Xuân Giang",
                "Xuân Thu",
              ],
            },
            {
              district: "Huyện Thanh Trì",
              wards: [
                "Đại Áng",
                "Đông Mỹ",
                "Duyên Hà",
                "Hữu Hòa",
                "Liên Ninh",
                "Ngọc Hồi",
                "Tả Thanh Oai",
                "Tam Hiệp",
                "Tân Triều",
                "Thanh Liệt",
                "Tứ Hiệp",
                "Vạn Phúc",
                "Vĩnh Quỳnh",
                "Yên Mỹ",
              ],
            },
            {
              district: "Huyện Thường Tín",
              wards: [
                "Dũng Tiến",
                "Hà Hồi",
                "Hiền Giang",
                "Hòa Bình",
                "Hồng Vân",
                "Khánh Hà",
                "Liên Phương",
                "Minh Cường",
                "Nghiêm Xuyên",
                "Nguyễn Trãi",
                "Nhị Khê",
                "Ninh Sở",
                "Quất Động",
                "Thắng Lợi",
                "Thống Nhất",
                "Thư Phú",
                "Tô Hiệu",
                "Tự Nhiên",
                "Vạn Điểm",
                "Vân Tảo",
                "Văn Bình",
                "Văn Phú",
                "Văn Tự",
                "Vân Tử",
                "Vũ Lăng",
                "Xà Cầu",
                "Duyên Thái",
              ],
            },
          ],
        },
        {
          city: "Hồ Chí Minh",
          districts: [
            {
              district: "Quận 1",
              wards: [
                "Bến Nghé",
                "Bến Thành",
                "Cầu Kho",
                "Cầu Ông Lãnh",
                "Cô Giang",
                "Nguyễn Thái Bình",
                "Phạm Ngũ Lão",
              ],
            },
            {
              district: "Quận 2",
              wards: [
                "Thảo Điền",
                "An Phú",
                "An Khánh",
                "Bình An",
                "Bình Trưng Đông",
                "Bình Trưng Tây",
                "Cát Lái",
                "Thạnh Mỹ Lợi",
              ],
            },
            {
              district: "Quận 3",
              wards: [
                "Phường 1",
                "Phường 2",
                "Phường 3",
                "Phường 4",
                "Phường 5",
                "Phường 6",
                "Phường 7",
                "Phường 8",
                "Phường 9",
                "Phường 10",
              ],
            },
            {
              district: "Quận 4",
              wards: [
                "Phường 1",
                "Phường 2",
                "Phường 3",
                "Phường 4",
                "Phường 5",
                "Phường 6",
                "Phường 8",
                "Phường 9",
              ],
            },
            {
              district: "Quận 5",
              wards: [
                "Phường 1",
                "Phường 2",
                "Phường 3",
                "Phường 4",
                "Phường 5",
                "Phường 6",
                "Phường 7",
                "Phường 8",
              ],
            },
            {
              district: "Quận 6",
              wards: [
                "Phường 1",
                "Phường 2",
                "Phường 3",
                "Phường 4",
                "Phường 5",
                "Phường 6",
                "Phường 7",
                "Phường 8",
              ],
            },
            {
              district: "Quận 7",
              wards: [
                "Tân Thuận Đông",
                "Tân Thuận Tây",
                "Tân Kiểng",
                "Tân Hưng",
                "Bình Thuận",
                "Phú Mỹ",
                "Tân Phong",
                "Tân Quy",
              ],
            },
            {
              district: "Quận 8",
              wards: [
                "Phường 1",
                "Phường 2",
                "Phường 3",
                "Phường 4",
                "Phường 5",
                "Phường 6",
                "Phường 7",
                "Phường 8",
              ],
            },
            {
              district: "Quận 9",
              wards: [
                "Long Bình",
                "Long Phước",
                "Long Thạnh Mỹ",
                "Long Trường",
                "Phước Bình",
                "Phước Long A",
                "Phước Long B",
              ],
            },
            {
              district: "Quận 10",
              wards: [
                "Phường 1",
                "Phường 2",
                "Phường 3",
                "Phường 4",
                "Phường 5",
                "Phường 6",
                "Phường 7",
                "Phường 8",
              ],
            },
            {
              district: "Quận 11",
              wards: [
                "Phường 1",
                "Phường 2",
                "Phường 3",
                "Phường 4",
                "Phường 5",
                "Phường 6",
                "Phường 7",
                "Phường 8",
              ],
            },
            {
              district: "Quận 12",
              wards: [
                "Thạnh Xuân",
                "Thạnh Lộc",
                "Thới An",
                "Tân Chánh Hiệp",
                "An Phú Đông",
                "Tân Thới Hiệp",
                "Tân Hưng Thuận",
              ],
            },
            {
              district: "Tân Bình",
              wards: [
                "Phường 1",
                "Phường 2",
                "Phường 3",
                "Phường 4",
                "Phường 5",
                "Phường 6",
                "Phường 7",
                "Phường 8",
              ],
            },
            {
              district: "Tân Phú",
              wards: [
                "Hiệp Tân",
                "Hòa Thạnh",
                "Phú Thọ Hòa",
                "Phú Thạnh",
                "Phú Trung",
                "Sơn Kỳ",
                "Tân Qúy",
                "Tân Sơn Nhì",
              ],
            },
            {
              district: "Bình Thạnh",
              wards: [
                "Phường 1",
                "Phường 2",
                "Phường 3",
                "Phường 4",
                "Phường 5",
                "Phường 6",
                "Phường 7",
                "Phường 8",
              ],
            },
            {
              district: "Gò Vấp",
              wards: [
                "Phường 1",
                "Phường 2",
                "Phường 3",
                "Phường 4",
                "Phường 5",
                "Phường 6",
                "Phường 7",
                "Phường 8",
              ],
            },
            {
              district: "Phú Nhuận",
              wards: [
                "Phường 1",
                "Phường 2",
                "Phường 3",
                "Phường 4",
                "Phường 5",
                "Phường 6",
                "Phường 7",
                "Phường 8",
              ],
            },
            {
              district: "Thủ Đức",
              wards: [
                "Bình Chiểu",
                "Bình Thọ",
                "Hiệp Bình Chánh",
                "Hiệp Bình Phước",
                "Linh Chiểu",
                "Linh Đông",
                "Linh Tây",
                "Linh Trung",
              ],
            },
          ],
        },
    ];
    let currentPage = 1;
    let currentStatus = "chuaXuLy"; 
    const limit = 6;

    let filterData = {};

    function loadDonHangs(page, status) {
        let data = {
            action: 'listDonHang',
            status: status,
            page: page,
            limit: limit
        }

        // Add filter data if exists
        if(Object.keys(filterData).length > 0) {
            data.action = 'listDonHangByFilter';
            data.filter = filterData;
        }

        $.ajax({
            url: "./controller/donHang.controller.php",
            type: "GET", 
            data: data,
            dataType: "json",
            success: function (response) {
                renderDonHang(response.donHangs);
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
            loadDonHangs(page, currentStatus); 
        });
    }

    loadDonHangs(currentPage, currentStatus);

    ////////////////////////////////////// TAB TRANG THAI //////////////////////////////////////
    
    $(".tab-item[data-status='chuaXuLy']").addClass("active");
    $(".tab-item").click(function() {
        $('.tab-item').removeClass('active');
        $(this).addClass('active');

        currentStatus = $(this).data("status");
        currentPage = 1; 
        loadDonHangs(currentPage, currentStatus); 
    })

    ////////////////////////////////////// MODAL CHI TIET //////////////////////////////////////
    
    const donHangModal = $("#donHangModal");
    
    $(".close, #closeModal").click(function() {
        donHangModal.hide();
    });

    $(document).on("click", ".detail-btn", function(e) {
        const donHangId = $(this).data("id");
        $.ajax({
            url: "./controller/donHang.controller.php",
            type: "GET",
            data: {
                action: 'listCTDonHang',
                id: donHangId
            },
            dataType: "json",
            success: function(response) {
                $("#updateDonHang").data("id", donHangId);
                
                if (currentStatus === "daGiao" || currentStatus === "daHuy") {
                    $("#updateDonHang").hide();
                } else {
                    $("#updateDonHang").show();
                }
                
                donHangModal.show();
                renderChiTietDonHang(response.ctDonHangs);
            },
            error: function(xhr, status, error) {
                console.error("Lỗi AJAX:", error);
            }
        });
    });

    // duyệt đơn hàng
    $(document).on("click", "#updateDonHang", function() {
        const donHangId = $(this).data("id");  // Lấy id từ chính button duyệt

        $.ajax({
            url: "./controller/donHang.controller.php",
            type: "POST",
            data: {
                action: 'updateStatusDonHang',
                id: donHangId,
                status: currentStatus
            },
            success: function(response) {
                donHangModal.hide();
                setTimeout(() => {
                    loadDonHangs(currentPage, currentStatus); 
                }, 100);
            },
            error: function(xhr, status, error) {
                console.error("Lỗi AJAX:", error);
                console.error("Trạng thái:", status);
                console.error("Phản hồi từ server:", xhr.responseText);
            }
        });
    });

    ////////////////////////////////////////// CHECK QUYEN //////////////////////////////////////////
    function checkQuyenDonHang() {
        $("#updateDonHang").hide();

        $.ajax({
            url: "./controller/quyen.controller.php",
            type: "GET",
            data: { action: "checkQuyen" },
            dataType: "json",
            success: function(response) {
                if (response.success && response.quyens) {
                    response.quyens.forEach(function(quyen) {
                        switch(quyen) {
                            case 11:
                                $("#updateDonHang").show();
                                break;
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Lỗi AJAX:", error);
            }
        });
    }

    checkQuyenDonHang();

    ////////////////////////////////////// FILTER /////////////////////////////////////////
    
    // Populate initial city select
    $("#thanhPhoFilter").html('<option value="">Tất cả</option>');
    locations.forEach(location => {
        $("#thanhPhoFilter").append(`<option value="${location.city}">${location.city}</option>`);
    });

    // Handle city change
    $("#thanhPhoFilter").change(function() {
        const selectedCity = $(this).val();
        
        // Reset district and ward
        $("#quanFilter").html('<option value="">Tất cả</option>');
        $("#huyenPhuongFilter").html('<option value="">Tất cả</option>');
        
        if(selectedCity) {
            const cityData = locations.find(loc => loc.city === selectedCity);
            if(cityData) {
                cityData.districts.forEach(district => {
                    $("#quanFilter").append(`<option value="${district.district}">${district.district}</option>`);
                });
            }
        }
    });

    // Handle district change 
    $("#quanFilter").change(function() {
        const selectedCity = $("#thanhPhoFilter").val();
        const selectedDistrict = $(this).val();
        
        // Reset ward
        $("#huyenPhuongFilter").html('<option value="">Tất cả</option>');
        
        if(selectedCity && selectedDistrict) {
            const cityData = locations.find(loc => loc.city === selectedCity);
            if(cityData) {
                const districtData = cityData.districts.find(d => d.district === selectedDistrict);
                if(districtData) {
                    districtData.wards.forEach(ward => {
                        $("#huyenPhuongFilter").append(`<option value="${ward}">${ward}</option>`);
                    });
                }
            }
        }
    });

    // Reset filter
    $("#resetFilter").click(function() {
        $("#thanhPhoFilter").val("");
        $("#quanFilter").html('<option value="">Tất cả</option>');
        $("#huyenPhuongFilter").html('<option value="">Tất cả</option>');
        $("#startDate").val("");
        $("#endDate").val("");
        filterData = {};
        currentPage = 1;
        loadDonHangs(currentPage, currentStatus);
    });

    // Apply filter
    $("#applyFilter").click(function() {
        const startDate = $("#startDate").val();
        const endDate = $("#endDate").val();

        if(startDate && endDate && new Date(startDate) > new Date(endDate)) {
            alert("Ngày bắt đầu phải nhỏ hơn ngày kết thúc");
            return;
        }

        filterData = {
            city: $("#thanhPhoFilter").val(),
            district: $("#quanFilter").val(), 
            ward: $("#huyenPhuongFilter").val(),
            start_date: startDate,
            end_date: endDate
        };

        currentPage = 1;
        loadDonHangs(currentPage, currentStatus);
    });
})

function formatCurrency(value) {
    return parseInt(value).toLocaleString('vi-VN') + 'đ';
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-EN', {
        month: '2-digit', 
        day: '2-digit',
        year: 'numeric',
    });
}

function renderDonHang(donHangs) {
    $("#donHangList").html("");
    if (donHangs && donHangs.length > 0) {
        donHangs.forEach(dh => {
            let row = `
                <tr> 
                    <td>${dh.id}</td>
                    <td>${dh.nguoidung_name}</td>
                    <td>${dh.address}</td>
                    <td>${dh.city}</td>
                    <td>${dh.district}</td>
                    <td>${dh.ward}</td>
                    <td>${formatDate(dh.order_date)}</td>
                    <td>${formatCurrency(dh.total_amount)}</td>
                    <td>${dh.payment}</td>
                    <td>${dh.khuyenmai_name}</td>
                    <td>
                        <button class="btn edit-btn detail-btn" data-id="${dh.id}">Chi tiết</button>
                    </td>
                </tr>
            `;
            $("#donHangList").append(row);
        });
    } else {
        $("#donHangList").append('<tr><td colspan="11">Không tìm thấy kết quả</td></tr>');
    }
}

function renderChiTietDonHang(ctDonHangs) {
    $("#ctDonHangList").html("");
    if (ctDonHangs && ctDonHangs.length > 0) {
        ctDonHangs.forEach(ct => {
            let row = `
                <tr> 
                    <td>${ct.sanpham_name}</td>
                    <td>${ct.quantity}</td>
                    <td>${formatCurrency(ct.price)}</td>
                </tr>
            `;
            $("#ctDonHangList").append(row);
        });
    } else {
        $("#ctDonHangList").append('<tr><td colspan="3">Không tìm thấy kết quả</td></tr>');
    }
    
}