$(document).ready(function () {
    let currentPage = 1;
    const limit = 8;

    function loadKhuyenMais(page) {
        $.ajax({
            url: "./controller/khuyenMai.controller.php",
            type: "GET",
            data: { action: "listKhuyenMai", page: page, limit: limit },
            dataType: "json",
            success: function (response) {
                console.log(response)
                $("#khuyenMaiList").html("");
                response.khuyenMais.forEach(km => {
                    let row = `
                        <tr> 
                            <td>${km.id}</td>
                            <td>${km.name}</td>
                            <td>${km.code}</td>
                            <td>${km.profit}</td>
                            <td>${km.type}</td>
                            <td>${km.startDate}</td>
                            <td>${km.endDate}</td>
                            <td>
                                <button id = "editKhuyenMai" class="btn edit-btn" data-id="${km.id}">Sửa</button>
                                <button id = "deleteKhuyenMai" class="btn delete-btn" data-id="${km.id}">Xóa</button>
                            </td>
                        </tr>
                    `;
                    $("#khuyenMaiList").append(row);
                });

                // Render pagination
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
            loadNhaCungCaps(page);
        });
    }

    loadKhuyenMais(currentPage);




     // Xử lý modal
     const khuyenMaiModal = $("#khuyenMaiModal");
     const deleteModal = $("#deleteModal");
     let deleteId = null;
 
     // Đóng modal 
     $(".close, .cancel-btn").click(function() {
         khuyenMaiModal.hide();
         deleteModal.hide();
     });
 
     
     $("#addKhuyenMai").click(function() {
         $("#modalTitle").text("Thêm khuyến mãi");
         $("#khuyenMaiForm")[0].reset();
         $("#khuyenMaiId").val("");
         khuyenMaiModal.show();
     });
 
 
     
     $(document).on("click", "#editKhuyenMai", function() {
         const id = $(this).data("id");
         $.ajax({
             url: "./controller/khuyenMai.controller.php",
             type: "GET",
             data: { action: "getKhuyenMai", id: id },
             dataType: "json",
             success: function(response) {
                khuyenMaiModal.show();
                console.log(response);
                $("#modalTitle").text("Sửa khuyến mãi");
                $("#khuyenMaiId").val(response.khuyenMai.id);
                $("#khuyenMai-name").val(response.khuyenMai.name);
                $("#khuyenMai-code").val(response.khuyenMai.code);
                $("#khuyenMai-profit").val(response.khuyenMai.profit);
                $("#khuyenMai-type").val(response.khuyenMai.type);
                $("#khuyenMai-startDate").val(response.khuyenMai.startDate);
                $("#khuyenMai-endDate").val(response.khuyenMai.endDate);
                setTimeout(() => {
                    $("#khuyenMai-startDate").val(response.khuyenMai.startDate);
                    $("#khuyenMai-endDate").val(response.khuyenMai.endDate);
                }, 50)
             }
         });
     });
 
     // Submit form thêm/sửa
     $("#khuyenMaiForm").submit(function(e) {
         e.preventDefault();
         const data = {
             id: $("#khuyenMaiId").val(),
             name: $("#khuyenMai-name").val(),
             code: $("#code").val(),
             profit: $("#profit").val(),
             type: $("#type").val(),
             startDate: $("#startDate").val(),
             endDate: $("#endDate").val(),
             action: $("#khuyenMaiId").val() ? "updateKhuyenMai" : "addKhuyenMai"
         };

            const datetimeRegex = /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/;
        if (!datetimeRegex.test(data.startDate) || !datetimeRegex.test(data.endDate)) {
            alert("Ngày bắt đầu/kết thúc sai định dạng. Vui lòng nhập lại!");
            return;
}

 
         $.ajax({
             url: "./controller/khuyenMai.controller.php",
             type: "POST",
             data: data,
             success: function(response) {
                 khuyenMaiModal.hide();
                 loadKhuyenMais(currentPage);
                 alert("Lưu khuyến mãi thành công!");
             },
             error: function(xhr, status, error) {
                 console.error(error);
                 alert("Lưu khuyến mãi thất bại. Vui lòng thử lại.");
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
                 url: "./controller/khuyenMai.controller.php",
                 type: "POST",
                 data: { action: "deleteKhuyenMai", id: deleteId },
                 success: function(response) {
                     deleteModal.hide();
                     loadKhuyenMais(currentPage);
                     alert("Xóa khuyến mãi thành công!");
                 },
                 error: function(xhr, status, error) {
                     console.error(error);
                     alert("Xóa khuyến mãi thất bại. Vui lòng thử lại.");
                 }
             });
         }
     });
 
     // dùng timeout để debounce
     let searchTimeout;
     // tìm kiếm 
     $("#searchKhuyenMai").on("input", function() {
         const searchValue = $("#searchKhuyenMai").val().trim();
         clearTimeout(searchTimeout);
         
         if (searchValue === "") {
             loadKhuyenMais(currentPage);
             return;
         }
 
         searchTimeout = setTimeout(() => {
             $.ajax({
                 url: "./controller/khuyenMai.controller.php",
                 type: "GET",
                 data: { 
                     action: "searchKhuyenMai",
                     search: searchValue 
                 },
                 dataType: "json",
                 success: function(response) {
                     $("#khuyenMaiList").html("");
                     if (response.khuyenMais && response.khuyenMais.length > 0) {
                         response.khuyenMais.forEach(km => {
                             let row = `
                                 <tr>
                                     <td>${km.id}</td>
                                     <td>${km.name}</td>
                                     <td>${km.code}</td>
                                     <td>${km.profit}</td>
                                     <td>${km.type}</td>
                                     <td>${km.startDate}</td>
                                     <td>${km.endDate}</td>
                                     <td>
                                         <button class="btn edit-btn" data-id="${km.id}">Sửa</button>
                                         <button class="btn delete-btn" data-id="${km.id}">Xóa</button>
                                     </td>
                                 </tr>
                             `;
                             $("#khuyenMaiList").append(row);
                         });
                     } else {
                         $("#khuyenMaiList").append('<tr><td colspan="5">Không tìm thấy kết quả</td></tr>');
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