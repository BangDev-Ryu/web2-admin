$(document).ready(function () {
    let currentPage = 1;
    const limit = 8;

    function loadTheLoais(page) {
        $.ajax({
            url: "./controller/theLoai.controller.php",
            type: "GET",
            data: { action: "listTheLoai", page: page, limit: limit },
            dataType: "json",
            success: function (response) {
                $("#theLoaiList").html("");
                response.theLoais.forEach(theLoai => {
                    let row = `
                        <tr>
                            <td>${theLoai.id}</td>
                            <td>${theLoai.name}</td>
                            <td>${theLoai.description}</td>
                            <td>${theLoai.trangthai_name}</td>
                            <td>
                                <button id="editTheLoai" class="btn edit-btn" data-id="${theLoai.id}">Sửa</button>
                                <button id="deleteTheLoai" class="btn delete-btn" data-id="${theLoai.id}">Xóa</button>
                            </td>
                        </tr>
                    `;
                    $("#theLoaiList").append(row);
                });

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
            loadTheLoais(page);
        });
    }

    loadTheLoais(currentPage);

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

    // Load danh sách trạng thái
    function loadTrangThai() {
        $.ajax({
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

    // Nút sửa thể loại
    $(document).on("click", "#editTheLoai", function() {
        const id = $(this).data("id");
        $.ajax({
            url: "./controller/theLoai.controller.php",
            type: "GET",
            data: { action: "getTheLoai", id: id },
            dataType: "json",
            success: function(response) {
                theLoaiModal.show();
                console.log(response);
                $("#modalTitle").text("Sửa Thể Loại");
                $("#theLoaiId").val(response.theLoai.id);
                $("#theLoai-name").val(response.theLoai.name);
                $("#theLoai-description").val(response.theLoai.description);
                loadTrangThai();
                setTimeout(() => {
                    $("#theLoai-trangThai").val(response.theLoai.trangthai_id);
                }, 50)
            }
        });
    });

    // Submit form thêm/sửa
    $("#theLoaiForm").submit(function(e) {
        e.preventDefault();
        const data = {
            id: $("#theLoaiId").val(),
            name: $("#theLoai-name").val(),
            description: $("#theLoai-description").val(),
            trangthai_id: $("#theLoai-trangThai").val(),
            action: $("#theLoaiId").val() ? "updateTheLoai" : "addTheLoai"
        };

        $.ajax({
            url: "./controller/theLoai.controller.php",
            type: "POST",
            data: data,
            success: function(response) {
                theLoaiModal.hide();
                loadTheLoais(currentPage);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Nút xóa thể loại
    $(document).on("click", ".delete-btn", function() {
        deleteId = $(this).data("id");
        deleteModal.show();
    });

    // Xác nhận xóa
    $("#confirmDelete").click(function() {
        if (deleteId) {
            $.ajax({
                url: "./controller/theLoai.controller.php",
                type: "POST",
                data: { action: "deleteTheLoai", id: deleteId },
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

    // dùng timeout để debounce
    let searchTimeout;

    $("#searchTheLoai").on("input", function() {
        const searchValue = $("#searchTheLoai").val().trim();
        clearTimeout(searchTimeout);
        
        if (searchValue === "") {
            loadTheLoais(currentPage);
            return;
        }

        searchTimeout = setTimeout(() => {
            $.ajax({
                url: "./controller/theLoai.controller.php",
                type: "GET",
                data: { 
                    action: "searchTheLoai",
                    search: searchValue 
                },
                dataType: "json",
                success: function(response) {
                    $("#theLoaiList").html("");
                    if (response.theLoais && response.theLoais.length > 0) {
                        response.theLoais.forEach(theLoai => {
                            let row = `
                                <tr>
                                    <td>${theLoai.id}</td>
                                    <td>${theLoai.name}</td>
                                    <td>${theLoai.description}</td>
                                    <td>${theLoai.trangthai_name}</td>
                                    <td>
                                        <button id="editTheLoai" class="btn edit-btn" data-id="${theLoai.id}">Sửa</button>
                                        <button id="deleteTheLoai" class="btn delete-btn" data-id="${theLoai.id}">Xóa</button>
                                    </td>
                                </tr>
                            `;
                            $("#theLoaiList").append(row);
                        });
                    } else {
                        $("#theLoaiList").append('<tr><td colspan="5">Không tìm thấy kết quả</td></tr>');
                    }
                    // sẽ chỉnh sau
                    $("#pagination").html("");
                },
                error: function(xhr, status, error) {
                    console.error("Lỗi tìm kiếm:", error);
                }
            });
        }, 300);
    });
});