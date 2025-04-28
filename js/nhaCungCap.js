$(document).ready(function () {
    let currentPage = 1;
    const limit = 6;
    let searchValue = ""; 
    let filterData = {};

    function loadNhaCungCaps(page, searchValue, filterData) {
        let data = { 
            action: "listNhaCungCap", 
            page: page, 
            limit: limit,
        };

        if (searchValue && searchValue.trim() !== "") {
            data.action = "listNhaCungCapBySearch";
            data.search = searchValue;
        }

        if (filterData && Object.keys(filterData).length > 0) {
            data.action = "listNhaCungCapByFilter";
            data.filter = filterData;
        }

        $.ajax({
            url: "./controller/nhaCungCap.controller.php",
            type: "GET",
            data: data,
            dataType: "json",
            success: function (response) {
                console.log("Dữ liệu sau khi lọc:", response);


                console.log("Danh sách nhà cung cấp:", response.nhaCungCaps);
                renderNhaCungCap(response.nhaCungCaps);
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
            loadNhaCungCaps(page, searchValue, filterData); 
        });
    }

    loadNhaCungCaps(currentPage, searchValue, filterData);

    

    function loadTrangThaiFilter() {
        $.ajax({
            url: "./controller/trangThai.controller.php",
            type: "GET",
            data: { action: "listTrangThai", type: "khac" },
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

    loadTrangThaiFilter();

     // Reset filter
    $("#resetFilter").click(function() {
        $("#trangThaiFilter").val(0);
    });

    // Apply filter
    $("#applyFilter").click(function() {
        filterData.trangthai_id = $("#trangThaiFilter").val(); 
        currentPage = 1; 
        searchValue = "";

        loadNhaCungCaps(currentPage, searchValue, filterData);
    });


    let searchTimeout;
 
    $("#searchNhaCungCap").on("input", function () {
       const searchValue = $(this).val().trim();
       clearTimeout(searchTimeout);
       currentPage = 1;
       filterData= {};
   
       if (searchValue === "") {
           loadNhaCungCaps(currentPage, searchValue, filterData);
           return;
       }
   
       searchTimeout = setTimeout(() => {
           loadNhaCungCaps(currentPage, searchValue, filterData);
       }, 300);
   });


    // Xử lý modal
    const nhaCungCapModal = $("#nhaCungCapModal");
    const deleteModal = $("#deleteModal");
    let deleteId = null;

    // Đóng modal 
    $(".close, .cancel-btn").click(function() {
        nhaCungCapModal.hide();
        deleteModal.hide();
    });

    // Nút thêm nhà cung cấp
    $("#addNhaCungCap").click(function() {
        $("#modalTitle").text("Thêm nhà cung cấp");
        $("#nhaCungCapForm")[0].reset();
        $("#nhaCungCapId").val("");
        loadTrangThai();
        nhaCungCapModal.show();
    });
 
     // Load danh sách trạng thái
    function loadTrangThai() {
        return $.ajax({
            url: "./controller/trangThai.controller.php",
            type: "GET",
            data: { action: "listTrangThai", type: "khac" },
            dataType: "json",
            success: function(response) {
                $("#nhaCungCap-trangThai").html("");
                response.trangThais.forEach(tt => {
                    $("#nhaCungCap-trangThai").append(`<option value="${tt.id}">${tt.name}</option>`);
                });
            }
        });
    }
 
     // Nút sửa 
    $(document).on("click", ".editNhaCungCap", function() {
        const id = $(this).data("id");
        $.ajax({
            url: "./controller/nhaCungCap.controller.php",
            type: "GET",
            data: { action: "getNhaCungCap", id: id },
            dataType: "json",
            success: function(response) {
                nhaCungCapModal.show();
                console.log(response);
                $("#modalTitle").text("Sửa nhà cung cấp");
                $("#nhaCungCapId").val(response.nhaCungCap.id);
                $("#nhaCungCap-name").val(response.nhaCungCap.name);
                $("#nhaCungCap-contact-person").val(response.nhaCungCap.contact_person);
                $("#nhaCungCap-contact-email").val(response.nhaCungCap.contact_email);
                $("#nhaCungCap-contact-phone").val(response.nhaCungCap.contact_phone);
                $("#nhaCungCap-address").val(response.nhaCungCap.address);
                loadTrangThai();
                setTimeout(() => {
                    $("#nhaCungCap-trangThai").val(response.nhaCungCap.trangthai_id);
                }, 50)
            }
        });
    });
 
    // Submit form thêm/sửa
    $("#nhaCungCapForm").submit(function(e) {
        e.preventDefault();
        const data = {
            id: $("#nhaCungCapId").val(),
            name: $("#nhaCungCap-name").val(),
            contact_person: $("#contact-person").val(),
            contact_email: $("#contact-email").val(),
            contact_phone: $("#contact-phone").val(),
            address: $("#address").val(),
            trangthai_id: $("#nhaCungCap-trangThai").val(),
            action: $("#nhaCungCapId").val() ? "updateNhaCungCap" : "addNhaCungCap"
        };

        $.ajax({
            url: "./controller/nhaCungCap.controller.php",
            type: "POST",
            data: data,
            success: function(response) {
                nhaCungCapModal.hide();
                loadNhaCungCaps(currentPage, searchValue, filterData);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Nút xóa 
    $(document).on("click", ".deleteNhaCungCap", function() {
        deleteId = $(this).data("id");
        deleteModal.show();
    });
 
    // Xác nhận xóa
    $("#confirmDelete").click(function() {
        if (deleteId) {
            $.ajax({
                url: "./controller/nhaCungCap.controller.php",
                type: "POST",
                data: { action: "deleteNhaCungCap", id: deleteId },
                success: function(response) {
                    deleteModal.hide();
                    loadNhaCungCaps(currentPage, searchValue, filterData);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

    ////////////////////////////////////////// CHECK QUYEN //////////////////////////////////////////
    function checkQuyenNhaCungCap() {
        $("#addNhaCungCap").hide();
        $(".editNhaCungCap").hide();
        $(".deleteNhaCungCap").hide();

        $.ajax({
            url: "./controller/quyen.controller.php",
            type: "GET",
            data: { action: "checkQuyen" },
            dataType: "json",
            success: function(response) {
                if (response.success && response.quyens) {
                    response.quyens.forEach(function(quyen) {
                        switch(quyen) {
                            case 34:
                                $("#addNhaCungCap").show();
                                break;
                            case 35:
                                $(".editNhaCungCap").show();
                                break;
                            case 36:
                                $(".deleteNhaCungCap").show();
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

    checkQuyenNhaCungCap();
 
    function renderNhaCungCap(nhaCungCaps) {
        $("#nhaCungCapList").html("");
        if (nhaCungCaps && nhaCungCaps.length > 0) {
            nhaCungCaps.forEach(ncc => {
                let row = `
                    <tr> 
                        <td>${ncc.id}</td>
                        <td>${ncc.name}</td>
                        <td>${ncc.contact_person}</td>
                        <td>${ncc.contact_email}</td>
                        <td>${ncc.contact_phone}</td>
                        <td>${ncc.address}</td>
                        <td>${ncc.trangthai_name}</td>
                        <td>
                            <button class="btn edit-btn editNhaCungCap" data-id="${ncc.id}">Sửa</button>
                            <button class="btn delete-btn deleteNhaCungCap" data-id="${ncc.id}">Xóa</button>
                        </td>
                    </tr>
                `;
                $("#nhaCungCapList").append(row);
            });
            checkQuyenNhaCungCap();
        } else {
            $("#nhaCungCapList").append('<tr><td colspan="9">Không tìm thấy kết quả</td></tr>');
        }
    }
});