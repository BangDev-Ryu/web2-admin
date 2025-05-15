$(document).ready(function () {
    let currentPage = 1;
    const limit = 6;
    let searchValue = ""; 
    let filterData = {};

    function loadTheLoais(page, searchValue, filterData) {
        let data = { 
            action: "listTheLoai", 
            page: page, 
            limit: limit,
        };

        if (searchValue && searchValue.trim() !== "") {
            data.action = "listTheLoaiBySearch";
            data.search = searchValue;
        }

        if (filterData && Object.keys(filterData).length > 0) {
            data.action = "listTheLoaiByFilter";
            data.filter = filterData;
        }

        $.ajax({
            url: "./controller/theLoai.controller.php",
            type: "GET",
            data: data,
            dataType: "json",
            success: function (response) {
                console.log("Dữ liệu sau khi lọc:", response);


                console.log("Danh sách nhà cung cấp:", response.theLoais);
                renderTheLoai(response.theLoais);
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
            loadTheLoais(page, searchValue, filterData); 
        });
    }

    loadTheLoais(currentPage, searchValue, filterData);

    

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


    function loadTrangThai() {
        return $.ajax({
            url: "./controller/trangThai.controller.php",
            type: "GET",
            data: { action: "listTrangThai", type: "khac" },
            dataType: "json",
            success: function(response) {
                $("#theLoai-trangThai").html("");
                response.trangThais.forEach(tt => {
                    $("#theLoai-trangThai").append(`<option value="${tt.id}">${tt.name}</option>`);
                });
            }
        });
    }
     // Reset filter
     $("#resetFilter").click(function() {
        $("#trangThaiFilter").val(0);
    });

    // Apply filter
    $("#applyFilter").click(function() {
        filterData.trangthai_id = $("#trangThaiFilter").val(); 
        currentPage = 1; 
        searchValue = "";

        loadTheLoais(currentPage, searchValue, filterData);
    });


    let searchTimeout;
 
    $("#searchTheLoai").on("input", function () {
       const searchValue = $(this).val().trim();
       clearTimeout(searchTimeout);
       currentPage = 1;
       filterData= {};
   
       if (searchValue === "") {
           loadTheLoais(currentPage, searchValue, filterData);
           return;
       }
   
       searchTimeout = setTimeout(() => {
           loadTheLoais(currentPage, searchValue, filterData);
       }, 300);
   });


    // Xử lý modal
    const theLoaiModal = $("#theLoaiModal");
    const deleteModal = $("#deleteModal");
    let deleteId = null;

    // Đóng modal 
    $(".close, .cancel-btn").click(function() {
        theLoaiModal.hide();
        deleteModal.hide();
    });

    // Nút thêm thể loại
    $("#addTheLoai").click(function() {
        $("#modalTitle").text("Thêm Thể Loại");
        $("#theLoaiForm")[0].reset();
        $("#theLoaiId").val("");
        loadTrangThai();
        theLoaiModal.show();
    });


    // Nút sửa thể loại
    $(document).on("click", ".editTheLoai", function() {
        const id = $(this).data("id");
        $.ajax({
            url: "./controller/theLoai.controller.php",
            type: "GET",
            data: { action: "getTheLoai", id: id },
            dataType: "json",
            success: function(response) {
                theLoaiModal.show();
                $("#modalTitle").text("Sửa thể loại");
                $("#theLoaiId").val(response.theLoai.id);
                $("#theLoai-name").val(response.theLoai.name);
                $("#theLoai-description").val(response.theLoai.description);
                // loadTrangThai();
                // setTimeout(() => {
                //     $("#theLoai-trangThai").val(response.theLoai.trangthai_id);
                // }, 50)
            },

        });
    });

    // Submit form thêm/sửa
    $("#theLoaiForm").submit(function(e) {
        e.preventDefault();
        const data = {
            id: $("#theLoaiId").val(),
            name: $("#theLoai-name").val(),
            description: $("#theLoai-description").val(),
            // trangthai_id: $("#theLoai-trangThai").val(),
            action: $("#theLoaiId").val() ? "updateTheLoai" : "addTheLoai"
        };

        $.ajax({
            url: "./controller/theLoai.controller.php",
            type: "POST",
            data: data,
            success: function(response) {
                theLoaiModal.hide();
                loadTheLoais(currentPage, searchValue, filterData);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Nút xóa thể loại
    $(document).on("click", ".deleteTheLoai", function() {
        deleteId = $(this).data("id");
        deleteModal.show();
    });

    // Xác nhận xóa
    $("#confirmDeleteTheLoai").click(function() {
        if (deleteId) {
            $.ajax({
                url: "./controller/theLoai.controller.php",
                type: "POST",
                data: { action: "deleteTheLoai", id: deleteId },
                success: function(response) {
                    deleteModal.hide();
                    loadTheLoais(currentPage, searchValue, filterData);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
                
            });
        }
    });

    ////////////////////////////////////////// CHECK QUYEN //////////////////////////////////////////
    function checkQuyenTheLoai() {
        $("#addTheLoai").hide();
        $(".editTheLoai").hide();
        $(".deleteTheLoai").hide();

        $.ajax({
            url: "./controller/quyen.controller.php",
            type: "GET",
            data: { action: "checkQuyen" },
            dataType: "json",
            success: function(response) {
                if (response.success && response.quyens) {
                    response.quyens.forEach(function(quyen) {
                        switch(quyen) {
                            case 14:
                                $("#addTheLoai").show();
                                break;
                            case 15:
                                $(".editTheLoai").show();
                                break;
                            case 16:
                                $(".deleteTheLoai").show();
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

    checkQuyenTheLoai();
    
    function renderTheLoai(theLoais) {
        $("#theLoaiList").html("");
        if (theLoais && theLoais.length > 0) {
            theLoais.forEach(tl => {
                let row = `
                    <tr> 
                        <td>${tl.id}</td>
                        <td>${tl.name}</td>
                        <td>${tl.description}</td>
                        <td>
                            <button class="btn edit-btn editTheLoai" data-id="${tl.id}">Sửa</button>
                            <button class="btn delete-btn deleteTheLoai" data-id="${tl.id}">Xóa</button>
                        </td>
                    </tr>
                `;
                $("#theLoaiList").append(row);
            });
            checkQuyenTheLoai();
        } else {
            $("#theLoaiList").append('<tr><td colspan="9">Không tìm thấy kết quả</td></tr>');
        }
    }

});