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
            loadChucVus(page, searchValue); 
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
        $("#quyenList").html("");
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
        $(`input[data-id="2"]`).attr("disabled", true);
        $(`input[data-id="3"]`).attr("disabled", true);
        $(`input[data-id="4"]`).attr("disabled", true);

        $(`input[data-id="10"]`).attr("disabled", true);
        $(`input[data-id="12"]`).attr("disabled", true);

        $(`input[data-id="32"]`).attr("disabled", true);

    }

    $("#addChucVu").click(function() {
        $("#modalTitle").text("Thêm chức vụ");
        chucVuModal.show();
        renderQuyen();
        $("#chucVuId").val("");
        $(`input[type="checkbox"]`).prop('checked', false);
        $("#chucVu-name").val("");
        $("#chucVu-description").val("");
    });

    $(document).on("click", ".editChucVu", function() {
        const id = $(this).data("id");
        
        // Clear dữ liệu cũ
        $("#quyenList").empty();
        
        $.ajax({
            url: "./controller/chucVu.controller.php",
            type: "GET",
            data: { 
                action: "getChucVu",
                id: id 
            },
            dataType: "json",
            success: function(response) {
                $("#modalTitle").text("Sửa chức vụ");
                $("#chucVuId").val(response.chucVu.id);
                $("#chucVu-name").val(response.chucVu.role_name);
                $("#chucVu-description").val(response.chucVu.role_description);
                
                // Render quyền và check các quyền đã có
                renderQuyen();
                response.quyens.forEach(q => {
                    $(`input[data-id="${q.quyen_id}"]`).prop('checked', true);
                });
                
                chucVuModal.show();
            }
        });
    });

    $("#chucVuForm").submit(function(event) {
        event.preventDefault();

        const data = {
            id: $("#chucVuId").val(),
            role_name: $("#chucVu-name").val(),
            role_description: $("#chucVu-description").val()
        };

        // Lấy danh sách quyền đã check
        const checkedPermissions = $("#quyenList input[type='checkbox']:checked").map(function() {
            return $(this).data('id');
        }).get();

        data.quyens = checkedPermissions;

        const action = $("#chucVuId").val() ? "updateChucVu" : "addChucVu";

        console.log($("#chucVuId").val());
        $.ajax({
            url: "./controller/chucVu.controller.php", 
            type: "POST",
            data: { action: action, ...data },
            dataType: "json",
            success: function(response) {
                
                alert(action === "addChucVu" ? "Thêm chức vụ thành công!" : "Cập nhật chức vụ thành công!");
                chucVuModal.hide();
                loadChucVus(currentPage, searchValue);
              
            },
            error: function(xhr, status, error) {
                console.error("Lỗi AJAX:", error);
                alert("Có lỗi xảy ra!");
            }
        });
    })

    ////////////////////////////////////////// CHECK QUYEN //////////////////////////////////////////

    function checkQuyenChucVu() {
        $("#addChucVu").hide();
        $(".editChucVu").hide();
        $(".deleteChucVu").hide();

        $.ajax({
            url: "./controller/quyen.controller.php",
            type: "GET",
            data: { action: "checkQuyen" },
            dataType: "json",
            success: function(response) {
                if (response.success && response.quyens) {
                    response.quyens.forEach(function(quyen) {
                        switch(quyen) {
                            case 26:
                                $("#addChucVu").show();
                                break;
                            case 27:
                                $(".editChucVu").show();
                                break;
                            case 28:
                                $(".deleteChucVu").show();
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
                            <button class="btn edit-btn editChucVu" data-id="${cv.id}">Sửa</button>
                            <button class="btn delete-btn deleteChucVu" data-id="${cv.id}">Xóa</button>
                        </td>
                    </tr>
                `;
                $("#chucVuList").append(row);
            });
        } else {
            $("#chucVuList").append('<tr><td colspan="4">Không tìm thấy kết quả</td></tr>');
        }
    }
})


