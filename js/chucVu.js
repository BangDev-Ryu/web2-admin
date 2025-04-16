$(document).ready(function () {
    let currentPage = 1;
    const limit = 6;

    let searchValue = "";

    function loadChucVus(page, searchValue) {
        let data = { 
            action: "listChucVu", 
            page: page, 
            limit: limit,
        };

        if (searchValue && searchValue.trim() !== "") {
            data.action = "listSanPhamBySearch";
            data.search = searchValue;
        }

        $.ajax({
            url: "./controller/chucVu.controller.php",
            type: "GET",
            data: data,
            dataType: "json",
            success: function (response) {
                renderChucVu(response.chucVus);
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
            loadProducts(page, searchValue); 
        });
    }

    loadChucVus(currentPage, searchValue);


    ///////////////////////////////////////// MODAL /////////////////////////////////////////
    
    const chucVuModal = $("#chucVuModal");
    
    // Đóng modal 
    $(".close, .cancel-btn").click(function() {
        chucVuModal.hide();
    });

    const chucVuModule = [
        "Trang chủ",
        "Sản phẩm",
        "Đơn hàng",
        "Thể loại",
        "Chủ đề",
        "Tài khoản",
        "Chức vụ",
        "Phiếu nhập",
        "Nhà cung cấp",
        "Khuyến mãi",
    ];

    function renderQuyen() {
        for (let i = 0; i < chucVuModule.length; i++) {
            let row = `
                <tr> 
                    <td>${chucVuModule[i]}</td>
                    <td><input type="checkbox" data-id="${i*4 + 1}"></td>
                    <td><input type="checkbox" data-id="${i*4 + 2}"></td>
                    <td><input type="checkbox" data-id="${i*4 + 3}"></td>
                    <td><input type="checkbox" data-id="${i*4 + 4}"></td>
                </tr>
            `;
            $("#quyenList").append(row);
        }
    }

    $("#addChucVu").click(function() {
        $("#modalTitle").text("Thêm chức vụ");
        renderQuyen();
        chucVuModal.show();
    });

    $("editChucVu").click(function() {
        const id = $(this).data("id");
        $("#modalTitle").text("Sửa chức vụ");
        renderQuyen();
        chucVuModal.show();
    })

    $("#chucVuForm").submit(function(event) {
        event.preventDefault(); 

        // const formData = $(this).serializeArray();
        const data = {};
        // formData.forEach(item => {
        //     data[item.name] = item.value;
        // });
        data.role_name = $("#chucVu-name").val();
        data.role_description = $("#chucVu-description").val();

        // Lấy tất cả các checkbox đã được check và map thành mảng data-id
        const checkedPermissions = $("#quyenList input[type='checkbox']:checked").map(function() {
            return $(this).data('id');
        }).get();

        // Thêm danh sách quyền vào object data
        data.quyens = checkedPermissions;

        console.log("Form data:", data);
        console.log(checkedPermissions);

        $.ajax({
            url: "./controller/chucVu.controller.php",
            type: "POST",
            data: { action: "addChucVu", ...data },
            success: function(response) {
                alert("Thêm chức vụ thành công!");
                chucVuModal.hide();
                loadChucVus(currentPage, searchValue); 
            },
            error: function(xhr, status, error) {
                console.error("Lỗi AJAX:", error);
                console.error("Trạng thái:", status);
                console.error("Phản hồi từ server:", xhr.responseText);
            }
        });
    })
})

function renderChucVu(chucVus) {
    $("#chucVuList").html("");
    if (chucVus && chucVus.length > 0) {
        chucVus.forEach(cv => {
            let row = `
                <tr> 
                    <td>${cv.id}</td>
                    <td>${cv.role_name}</td>
                    <td>${cv.role_description}</td>
                    <td>
                        <button id="editChucVu" class="btn edit-btn" data-id="${cv.id}">Sửa</button>
                        <button id="deleteChucVu" class="btn delete-btn" data-id="${cv.id}">Xóa</button>
                    </td>
                </tr>
            `;
            $("#chucVuList").append(row);
        });
    } else {
        $("#chucVuList").append('<tr><td colspan="4">Không tìm thấy kết quả</td></tr>');
    }
}

