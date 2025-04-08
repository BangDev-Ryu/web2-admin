$(document).ready(function () {
    let currentPage = 1;
    const limit = 6;
    let searchValue = ""; 


    function loadNhaCungCaps(page, searchValue, filterData) {
        let data = { 
            action: "listNhaCungCap", 
            page: page, 
            limit: limit,
            search: searchValue 
        };

        if (filterData) {
            data = {...data, ...filterData};
        }

        $.ajax({
            url: "./controller/nhaCungCap.controller.php",
            type: "GET",
            data: data,
            dataType: "json",
            success: function (response) {
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
            loadNhaCungCaps(page, searchValue); 
        });
    }

    loadNhaCungCaps(currentPage, searchValue);

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
                            <button class="btn edit-btn" data-id="${ncc.id}">Sửa</button>
                            <button class="btn delete-btn" data-id="${ncc.id}">Xóa</button>
                        </td>
                    </tr>
                `;
                $("#nhaCungCapList").append(row);
            });
        } else {
            $("#nhaCungCapList").append('<tr><td colspan="9">Không tìm thấy kết quả</td></tr>');
        }
    }


    let searchTimeout;
 
    $("#searchNhaCungCap").on("input", function () {
       const searchValue = $(this).val().trim();
       clearTimeout(searchTimeout);
       currentPage = 1;
   
       if (searchValue === "") {
           loadNhaCungCaps(currentPage, searchValue);
           return;
       }
   
       searchTimeout = setTimeout(() => {
           loadNhaCungCaps(currentPage, searchValue);
       }, 300);
   });


     // Xử lý modal
     const nhaCungCapModal = $("#nhaCungCapModal");
     //const deleteModal = $("#deleteModal");
    // let deleteId = null;
 
     // Đóng modal 
     $(".close, .cancel-btn").click(function() {
         nhaCungCapModal.hide();
         //deleteModal.hide();
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
         $.ajax({
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
     $(document).on("click", "#editNhaCungCap", function() {
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
                $("#nhaCungCap-trangThai").val(response.nhaCungCap.trangThai);
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
                 loadNhaCungCaps(currentPage);
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
                 url: "./controller/nhaCungCap.controller.php",
                 type: "POST",
                 data: { action: "deleteNhaCungCap", id: deleteId },
                 success: function(response) {
                     deleteModal.hide();
                     loadNhaCungCaps(currentPage);
                 },
                 error: function(xhr, status, error) {
                     console.error(error);
                 }
             });
         }
     });
 
    
});