$(document).ready(function () {
    let currentPage = 1;
    const limit = 6;

    let searchValue = "";
    let filterData = {};

    function loadTaiKhoans(page, searchValue, filterData) {
        let data = {
            action: "listTaiKhoan", 
            page: page, 
            limit: limit,
        };

        if (searchValue && searchValue.trim() !== "") {
            data.action = "listTaiKhoanBySearch";
            data.search = searchValue;
        }
        
        if (filterData && Object.keys(filterData).length > 0) {
            data.action = "listTaiKhoanByFilter";
            data.filter = filterData;
        }

        $.ajax({
            url: "./controller/taiKhoan.controller.php",
            type: "GET",
            data: data,
            dataType: "json",
            success: function (response) {
                console.log("Search Results:", response); // Thêm log để debug
                renderTaiKhoan(response.taiKhoans);
                renderPagination(response.totalPages, page);
            },
            error: function (xhr, status, error) {
                console.error("Lỗi AJAX:", error);
                console.error("Trạng thái:", status);
                console.error("Phản hồi từ server:", xhr.responseText);
            }
        });
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
            loadTaiKhoans(page, searchValue, filterData);
        });
    }

    loadTaiKhoans(currentPage, searchValue);

    let searchTimeout;

    $("#searchTaiKhoan").on("input", function () {
        searchValue = $(this).val().trim();
        clearTimeout(searchTimeout);
        currentPage = 1;
        filterData = {};

        // Reset các filter khi tìm kiếm
        $("#loaiTKFilter").val(2);
        $("#trangThaiFilter").val(0);
        $("#chucVuFilter").val(0);

        searchTimeout = setTimeout(function () {
            loadTaiKhoans(currentPage, searchValue, filterData);
        }, 300);
    });

    function loadTrangThaiFilter() {
        $.ajax({
            url: "./controller/trangThai.controller.php",
            type: "GET",
            data: { action: "listTrangThai", type: "taiKhoan" },
            dataType: "json",
            success: function(response) {
                $("#trangThaiFilter").html("");
                $("#trangThaiFilter").append(`<option value="0">Tất cả</option>`);
                response.trangThais.forEach(tt => {
                    $("#trangThaiFilter").append(`<option value="${tt.id}">${tt.name}</option>`);
                });
            }
        });
    } 

    function loadChucVuFilter() {
        $.ajax({
            url: "./controller/chucVu.controller.php",
            type: "GET",
            data: { action: "listAllChucVu" },
            dataType: "json",
            success: function(response) {
                $("#chucVuFilter").html("");
                $("#chucVuFilter").append(`<option value="0">Tất cả</option>`);
                response.chucVus.forEach(cv => {
                    $("#chucVuFilter").append(`<option value="${cv.id}">${cv.role_name}</option>`);
                });
            }
        });
    }

    loadTrangThaiFilter();
    loadChucVuFilter(); 

    $("#resetFilter").click(function() {
        $("#loaiTKFilter").val(0);
        $("#trangThaiFilter").val(0);
        $("#chucVuFilter").val(0);
    });
    
    $("#applyFilter").click(function() {
        filterData = {
            type_account: $("#loaiTKFilter").val() === "2" ? "" : $("#loaiTKFilter").val(),
            chucvu_id: $("#chucVuFilter").val() === "0" ? "" : $("#chucVuFilter").val(),
            trangthai_id: $("#trangThaiFilter").val() === "0" ? "" : $("#trangThaiFilter").val(),
        };
        currentPage = 1; 
        searchValue = "";

        loadTaiKhoans(currentPage, searchValue, filterData);
    });

    const taiKhoanModal = $("#taiKhoanModal");

    // Đóng modal 
    $(".close, .cancel-btn").click(function() {
        taiKhoanModal.hide();
    });

    function loadTrangThai() {
        $.ajax({
            url: "./controller/trangThai.controller.php",
            type: "GET",
            data: { action: "listTrangThai", type: "taiKhoan" },
            dataType: "json",
            success: function(response) {
                $("#trangthai_id").html("");
                response.trangThais.forEach(tt => {
                    $("#trangthai_id").append(`<option value="${tt.id}">${tt.name}</option>`);
                });
            }
        });
    }

    function loadChucVu() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "./controller/chucVu.controller.php",
                type: "GET",
                data: { action: "listAllChucVu" },
                dataType: "json",
                success: function(response) {
                    $("#chucvu_id").html("");
                    response.chucVus.forEach(cv => {
                        $("#chucvu_id").append(`<option value="${cv.id}">${cv.role_name}</option>`);
                    });
                    resolve();
                },
                error: function(error) {
                    reject(error);
                }
            });
        });
    }
    
    // Nút thêm tài khoản
    $("#addTaiKhoan").click(function () {
        $("#modalTitle").text("Thêm Tài Khoản");
        $("#taiKhoanForm")[0].reset();
        $("#taiKhoanId").val("");
        $("#imagePreview").attr("src", "");
        loadTrangThai();
        loadChucVu();
        $("#email").attr("disabled", false);
        $("#username").attr("disabled", false);  
        taiKhoanModal.show();
    });

    // Nút sửa tài khoản
    $(document).on("click", ".editTaiKhoan", function () {
        const id = $(this).data("id");

        $.ajax({
            url: "./controller/taiKhoan.controller.php",
            type: "GET",
            data: { action: "getTaiKhoanById", id: id },
            dataType: "json",
            success: function (response) {
                taiKhoanModal.show();
                $("#modalTitle").text("Sửa Tài Khoản");
                
                // Load chức vụ và trạng thái trước
                loadChucVu().then(() => {
                    $("#taiKhoanId").val(response.taiKhoan.id);
                    $("#fullname").val(response.taiKhoan.fullname);
                    $("#username").val(response.taiKhoan.username); 
                    $("#password").val("");
                    $("#chucvu_id").val(response.taiKhoan.chucvu_id);
                    $("#email").val(response.taiKhoan.email)
                    $("#phone").val(response.taiKhoan.phone);
                    $("#date_of_birth").val(response.taiKhoan.date_of_birth);    
                    $("#type_account").val(response.taiKhoan.type_account);
                    $("#imagePreview").attr("src", response.taiKhoan.picture);
                });

                loadTrangThai();
                $("#email").attr("disabled", true);
                $("#username").attr("disabled", true);  
            },
        });
    });

    $("#picture").change(function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#imagePreview").attr("src", e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    $("#date_of_birth").change(function() {
        const selectedDate = new Date($(this).val());
        const today = new Date();
        
        if(selectedDate > today) {
            alert("Ngày sinh không hợp lệ.");
            $(this).val("");
        }
    });

    $("#username").on("input", function() {
        let value = $(this).val();
        // Loại bỏ dấu và ký tự đặc biệt
        value = value.normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-zA-Z0-9]/g, '');
        $(this).val(value);
    });

    // Submit form thêm/sửa tài khoản
    $("#taiKhoanForm").submit(function (e) {
        e.preventDefault();
        
        const username = $("#username").val();
        if (username.includes(' ') || /[^a-zA-Z0-9]/.test(username)) {
            alert("Tên đăng nhập không hợp lệ.");
            return;
        }

        const dateOfBirth = new Date($("#date_of_birth").val());
        const today = new Date();
        
        if(dateOfBirth > today) {
            alert("Ngày sinh không hợp lệ.");
            return;
        }
        
        let formData = new FormData();
        formData.append("action", $("#taiKhoanId").val() ? "updateTaiKhoan" : "addTaiKhoan");
        formData.append("id", $("#taiKhoanId").val());
        formData.append("fullname", $("#fullname").val());
        formData.append("username", $("#username").val());
        
        // Chỉ gửi password nếu đang thêm mới hoặc có nhập password mới
        const password = $("#password").val();
        if (!$("#taiKhoanId").val() || password.trim() !== "") {
            formData.append("password", password);
        }

        formData.append("email", $("#email").val());
        formData.append("phone", $("#phone").val());
        formData.append("taiKhoan_id", $("#taiKhoanId").val());
        formData.append("date_of_birth", $("#date_of_birth").val());
        formData.append("chucvu_id", $("#chucvu_id").val());
        formData.append("type_account", $("#type_account").val());

        const imageFile = $("#picture")[0].files[0];
        if (imageFile) {
            formData.append("img", imageFile);
            formData.append("picture", "");
        } 
        else if ($("#imagePreview").attr("src")) {
            formData.append("picture", $("#imagePreview").attr("src"));
        }
        else {
            formData.append("picture", "./assets/img/user-img/user_default.png");
        }
        console.log(formData);

        $.ajax({
            url: "./controller/taiKhoan.controller.php",
            type: "POST",
            data: formData,
            processData: false, 
            contentType: false, 
            success: function (response) {
                let result = JSON.parse(response);
                if (!result.success && result.errors) {
                    // Hiển thị lỗi
                    alert(result.errors.join('\n'));
                    return;
                }
                
                taiKhoanModal.hide();
                loadTaiKhoans(currentPage, searchValue);
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert("Có lỗi xảy ra khi xử lý yêu cầu");
            }
        });
    });

    const deleteModal = $("#deleteModal");
    let deleteId = null;

    $(document).on("click", ".cancel-btn", function() {
        deleteModal.hide();
    });
    // Nút xóa tài khoản
    $(document).on("click", ".deleteTaiKhoan", function() {
        deleteId = $(this).data("id");
        deleteModal.show();
    });

    // Xác nhận xóa
    $("#confirmDelete").click(function() {
        if (deleteId) {
            $.ajax({
                url: "./controller/taiKhoan.controller.php",
                type: "POST",
                data: { action: "deleteTaiKhoan", id: deleteId },
                success: function(response) {
                    deleteModal.hide();
                    loadTaiKhoans(currentPage, searchValue, filterData);
                    alert("Xóa tài khoản thành công!");
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert("Có lỗi xảy ra khi xóa tài khoản!");
                }
            });
        }
    });

    const lockModal = $("#lockModal");
    let lockId = null;

    $(document).on("click", ".cancel-btn", function() {
        lockModal.hide();
    });

    $(document).on("click", ".lockTaiKhoan", function() {
        lockId = $(this).data("id");
        const status = $(this).data("status");
        
        if (status == 3) {
            $("#lockModalTitle").text("Xác nhận mở khóa");
            $("#lockModalMessage").text("Bạn có chắc chắn muốn mở khóa tài khoản này?");
            $("#confirmLock").text("Mở khóa").removeClass("confirm-lock-btn").addClass("confirm-unlock-btn");
        } else {
            $("#lockModalTitle").text("Xác nhận khóa");
            $("#lockModalMessage").text("Bạn có chắc chắn muốn khóa tài khoản này?");
            $("#confirmLock").text("Khóa").removeClass("confirm-unlock-btn").addClass("confirm-lock-btn");
        }
        
        lockModal.show();
    });

    $("#confirmLock").click(function() {
        if (lockId) {
            const action = $("#confirmLock").hasClass("confirm-unlock-btn") ? "unlockTaiKhoan" : "lockTaiKhoan";
            $.ajax({
                url: "./controller/taiKhoan.controller.php",
                type: "POST",
                data: { 
                    action: action, 
                    id: lockId,
                    trangthai_id: action === "unlockTaiKhoan" ? 1 : 3 
                },
                success: function(response) {
                    lockModal.hide();
                    loadTaiKhoans(currentPage, searchValue, filterData);
                    alert(action === "unlockTaiKhoan" ? "Mở khóa tài khoản thành công!" : "Khóa tài khoản thành công!");
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert("Có lỗi xảy ra khi xử lý yêu cầu!");
                }
            });
        }
    });

    ////////////////////////////////////////// CHECK QUYEN //////////////////////////////////////////
    function checkQuyenTaiKhoan() {
        $("#addTaiKhoan").hide();
        $(".editTaiKhoan").hide();
        $(".deleteTaiKhoan").hide();
        $(".lockTaiKhoan").hide();

        $.ajax({
            url: "./controller/quyen.controller.php",
            type: "GET",
            data: { action: "checkQuyen" },
            dataType: "json",
            success: function(response) {
                if (response.success && response.quyens) {
                    response.quyens.forEach(function(quyen) {
                        switch(quyen) {
                            case 22:
                                $("#addTaiKhoan").show();
                                break;
                            case 23:
                                $(".editTaiKhoan").show();
                                break;
                            case 24:
                                $(".deleteTaiKhoan").show();
                                $(".lockTaiKhoan").show();
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

    checkQuyenTaiKhoan();

    function renderTaiKhoan(taiKhoans) {
        $("#taiKhoanList").html("");
        if (taiKhoans && taiKhoans.length > 0) {
            taiKhoans.forEach(taiKhoan => {
                let actionButton = '';
                if (taiKhoan.trangthai_id == 3) {
                    actionButton = `<button class="btn unlock-btn lockTaiKhoan" data-id="${taiKhoan.id}" data-status="3">Mở khóa</button>`;
                } else if (taiKhoan.trangthai_id == 1) {
                    actionButton = `<button class="btn lock-btn lockTaiKhoan" data-id="${taiKhoan.id}" data-status="1">Khóa</button>`;
                }

                let row = `
                    <tr>
                        <td>${taiKhoan.id}</td>
                        <td><img src="${taiKhoan.picture}" alt="User Image" width="60"></td>
                        <td>${taiKhoan.fullname}</td>
                        <td>${taiKhoan.username}</td>
                        <td>${taiKhoan.email}</td>
                        <td>${taiKhoan.phone}</td>
                        <td>${formatDate(taiKhoan.date_of_birth)}</td>
                        <td>${taiKhoan.chucvu}</td>
                        <td>${taiKhoan.role_name}</td>
                        <td>${taiKhoan.trangthai_name}</td>
                        <td>
                            <button class="btn edit-btn editTaiKhoan" data-id="${taiKhoan.id}">Sửa</button>
                            <button class="btn delete-btn deleteTaiKhoan" data-id="${taiKhoan.id}">Xóa</button>
                            ${actionButton}
                        </td>
                    </tr>
                `;
                $("#taiKhoanList").append(row);
            });
            checkQuyenTaiKhoan();
        } else {
            $("#taiKhoanList").append("<tr><td colspan='12'>Không có dữ liệu</td></tr>");
        }   
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-EN', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        });
    }
});

