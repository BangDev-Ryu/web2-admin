$(document).ready(function () {
    let currentPage = 1;
    const limit = 6;
    let searchValue = ""; 
    let filterData = {};


    function loadKhuyenMais(page, searchValue, filterData) {
        let data = { 
            action: "listKhuyenMai", 
            page: page, 
            limit: limit,
        };

        if (searchValue && searchValue.trim() !== "") {
            data.action = "listKhuyenMaiBySearch";
            data.search = searchValue;
        }

        if (filterData && Object.keys(filterData).length > 0) {
            data.action = "listKhuyenMaiByFilter";
            data.filter = filterData;
        }

        $.ajax({
            url: "./controller/khuyenMai.controller.php",
            type: "GET",
            data: data,
            dataType: "json",
            success: function (response) {
                renderKhuyenMai(response.khuyenMais);
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
            loadKhuyenMais(page, searchValue, filterData); 
        });
    }

    loadKhuyenMais(currentPage, searchValue);


    function renderKhuyenMai(khuyenMais) {
        $("#khuyenMaiList").html("");
        if (khuyenMais && khuyenMais.length > 0) {
            khuyenMais.forEach(km => {
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
            $("#khuyenMaiList").append('<tr><td colspan="9">Không tìm thấy kết quả</td></tr>');
            return;
        }
    }

    const minProfitRange = $("#minProfitRange");
    const maxProfitRange = $("#maxProfitRange");
    const minProfitValue = $("#minProfitValue");
    const maxProfitValue = $("#maxProfitValue");

    function formatProfit(value) {
        return parseInt(value).toLocaleString('vi-VN') + 'đ';
    }

    function updateProfitRanges() {
        let minVal = parseInt(minProfitRange.val());
        let maxVal = parseInt(maxProfitRange.val());

        if (minVal >= maxVal) {
            minVal = Math.max(0, maxVal - 10000); 
            minProfitRange.val(minVal);
        }

        minProfitValue.text(formatProfit(minVal));
        maxProfitValue.text(formatProfit(maxVal));
    }

    minProfitRange.on("input", function() {
        updateProfitRanges();
    });

    maxProfitRange.on("input", function() {
        updateProfitRanges();
    });

    $("#resetFilter").click(function() {
        filterDate = {};
        minProfitRange.val(0);
        maxProfitRange.val(10000000);
        updateProfitRanges();
    });

    // Apply filter
    $("#applyFilter").click(function() {
        filterData = {
            min_Profit: minProfitRange.val(),
            max_Profit: maxProfitRange.val(),
        };

        currentPage = 1; 
        searchValue = "";

        loadKhuyenMais(currentPage, searchValue, filterData);
    });

    

    let searchTimeout;
 
    $("#searchKhuyenMai").on("input", function () {
    searchValue = $(this).val().trim();
    clearTimeout(searchTimeout);
    currentPage = 1;
   
        if (searchValue === "") {
           loadKhuyenMais(currentPage, searchValue, filterData);
           return;
        }
   
       searchTimeout = setTimeout(() => {
           loadKhuyenMais(currentPage, searchValue, filterData);
       }, 300);
   });
    


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
 
 
     
     $(document).on("click", ".edit-btn", function() {
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
             code: $("#khuyenMai-code").val(),
             profit: $("#khuyenMai-profit").val(),
             type: $("#khuyenMai-type").val(),
             startDate: $("#startDate").val(),
             endDate: $("#endDate").val(),
             action: $("#khuyenMaiId").val() ? "updateKhuyenMai" : "addKhuyenMai"
         };


    

 
         $.ajax({
             url: "./controller/khuyenMai.controller.php",
             type: "POST",
             data: data,
             success: function(response) {
                 khuyenMaiModal.hide();
                 loadKhuyenMais(currentPage);
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
                 url: "./controller/khuyenMai.controller.php",
                 type: "POST",
                 data: { action: "deleteKhuyenMai", id: deleteId },
                 success: function(response) {
                     deleteModal.hide();
                     loadKhuyenMais(currentPage, searchValue, filterData);
                     alert("Xóa khuyến mãi thành công!");
                 },
                 error: function(xhr, status, error) {
                     console.error(error);
                     alert("Xóa khuyến mãi thất bại. Vui lòng thử lại.");
                 }
             });
         }
     });

    })