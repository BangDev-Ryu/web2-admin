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
                console.log(response.taiKhoans);
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

        if(searchValue === "") {
            loadTaiKhoans(currentPage, searchValue, filterData);
            return;
        }
        
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
            data: { action: "listChucVu", type: "taiKhoan" },
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
        $("#loaiTKFilter").val(0); // TỚI ĐÂY
        $("#trangThaiFilter").val(0);
        $("#chucVuFilter").val(0);

    });
    
    $("#applyFilter").click(function() {
        filterData = {
            type_account: $("#loaiTKFilter").val()  === "2" ? "" : $("#loaiTKFilter").val(),
            chucvu_id: $("#chucVuFilter").val(),
            trangthai_id: $("#trangThaiFilter").val(),
        };
        currentPage = 1; 
        searchValue = "";

        loadTaiKhoans(currentPage, searchValue, filterData);
    });


    const  taiKhoanModal = $("#taiKhoanModal");

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
        $.ajax({
            url: "./controller/chucVu.controller.php",
            type: "GET",
            data: { action: "listChucVu", type: "taiKhoan" },
            dataType: "json",
            success: function(response) {
                $("#chucvu_id").html("");
                response.chucVus.forEach(cv => {
                    $("#chucvu_id").append(`<option value="${cv.id}">${cv.role_name}</option>`);
                });
            }
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
        taiKhoanModal.show();
    });

    // Nút sửa tài khoản
    $(document).on("click", ".edit-btn", function () {
        const id = $(this).data("id");
        $.ajax({
            url: "./controller/taiKhoan.controller.php",
            type: "GET",
            data: { action: "getTaiKhoan", id: id },
            dataType: "json",
            success: function (response) {
                taiKhoanModal.show();
                $("#modalTitle").text("Sửa Tài Khoản");
                $("#taiKhoanId").val(response.taiKhoan.id);
                $("#fullname").val(response.taiKhoan.fullname);
                $("#username").val(response.taiKhoan.username);
                $("#password").val(""); // Không hiển thị mật khẩu
                $("#chucvu_id").val(response.taiKhoan.chucvu_id);
                $("#email").val(response.taiKhoan.email)
                $("#phone").val(response.taiKhoan.phone);
                $("#date_of_birth").val(response.taiKhoan.date_of_birth);    
                $("#trangthai_id").val(response.taiKhoan.trangthai_id);
                $("#type_account").val(response.taiKhoan.type_account);
                $("#imagePreview").attr("src", response.taiKhoan.picture);

                loadChucVu();
                loadTrangThai();
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

    // Submit form thêm/sửa tài khoản
    $("#taiKhoanForm").submit(function (e) {
        e.preventDefault();
        let formData = new FormData();
        formData.append("action", $("#taiKhoanId").val() ? "updateTaiKhoan" : "addTaiKhoan");
        formData.append("id", $("#taiKhoanId").val());
        formData.append("fullname", $("#fullname").val());
        formData.append("username", $("#username").val());
        formData.append("password", $("#password").val());
        formData.append("email", $("#email").val());
        formData.append("phone", $("#phone").val());
        formData.append("taiKhoan_id", $("#taiKhoanId").val());
        formData.append("date_of_birth", $("#date_of_birth").val());
        formData.append("chucvu_id", $("#chucvu_id").val());
        formData.append("trangthai_id", $("#trangthai_id").val());
        formData.append("type_account", $("#type_account").val());

        const imageFile = $("#picture")[0].files[0];
        if (imageFile) {
            // data.img = imageFile;
            // data.image_url = "";
            formData.append("img", imageFile);
            formData.append("picture", "");
        } 
        else if ($("#imagePreview").attr("src")) {
            // Nếu không có file mới, giữ lại ảnh cũ
            // data.image_url = $("#imagePreview").attr("src");
            formData.append("pictuce", data.picture);
        }
        console.log(formData);

        $.ajax({
            url: "./controller/taiKhoan.controller.php",
            type: "POST",
            data: formData,
            processData: false, 
            contentType: false, 
            success: function (response) {
                taiKhoanModal.hide();
                loadTaiKhoans(currentPage, searchValue);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Nút xóa tài khoản
    $(document).on("click", ".delete-btn", function() {
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
                    loadTheLoais(currentPage);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
});

function renderTaiKhoan(taiKhoans) {
    $("#taiKhoanList").html("");
    if (taiKhoans && taiKhoans.length > 0) {
        taiKhoans.forEach(taiKhoan => {
            let row = `
                <tr>
                    <td>${taiKhoan.id}</td>
                    <td><img src="${taiKhoan.picture}" alt="User Image" width="60"></td>
                    <td>${taiKhoan.fullname}</td>
                    <td>${taiKhoan.username}</td>
                    <td>${taiKhoan.email}</td>
                    <td>${taiKhoan.phone}</td>
                    <td>${taiKhoan.date_of_birth}</td>
                    <td>${taiKhoan.chucvu}</td>
                    <td>${taiKhoan.role_name}</td>
                    <td>${taiKhoan.trangthai_name}</td>
                    <td>${taiKhoan.created_at}</td>x
                    <td>
                        <button id="editTaiKhoan" class="btn edit-btn" data-id="${taiKhoan.id}">Sửa</button>
                        <button id="deleteTaiKhoan" class="btn delete-btn" data-id="${taiKhoan.id}">Xóa</button>
                    </td>
                </tr>
            `;
            $("#taiKhoanList").append(row);
        });
} else {
    $("#taiKhoanList").append("<tr><td colspan='12'>Không có dữ liệu</td></tr>");
    }   
}
