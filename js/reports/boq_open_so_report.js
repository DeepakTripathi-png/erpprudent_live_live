$( document ).ready(function() {
    page.init();
});
var table = '';
var download_title = "pending_po_list";
var pdf_title = "Pending Po List";
const page = {
    init: function(){
        this.dataTable();
        this.initiateMoredetails();
    },
    dataTable: function(){
        var data = {};
        table = $("#voucher_list").DataTable({
      "dom": 'Bfrtip',
      "lengthMenu": [
        [10,25, 50, 75, 100, 125,150, -1],
        [ '10 rows','25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
      ],
      "buttons": [
        'pageLength',
        {
          "extend": 'copy',
          "title": download_title,
          "exportOptions": {
            "columns": [0,1,2,3,4,5,6,7,8]
          },
          "footer": true
        },
        {
          "extend": 'excel',
          "title": download_title,
          "exportOptions": {
            "columns": [0,1,2,3,4,5,6,7,8]
          },
          "footer": true,
        },
        {
          "extend": 'pdf',
          "title": download_title,
          "exportOptions": {
            "columns": [0,1,2,3,4,5,6,7,8]
          },
          "footer": true
        },
        {
          "extend": 'print',
          "title": download_title,
          "exportOptions": {
            "columns": [0,1,2,3,4,5,6,7,8]
          },
          "footer": true
        }
      ],
      "oLanguage": {
        "sEmptyTable": "No Voucher System Data Found!"
      },
      orderCellsTop: false,
            lengthMenu: page_length_arr,
            // "sDom":is_top_searching_enable,
            columns: column_details,
            processing: false,
            serverSide: is_serverSide,
            sordering: true,
            searching: is_searching_enable,
            ordering: is_ordering,
            bSort: true,
            orderMulti: false,
            pagingType: "full_numbers",
            // scrollCollapse: true,
            scrollX: true,
            scrollY: true,
            paging: is_paging_enable,
            fixedHeader: false,
            info: true,
            autoWidth: true,
            lengthChange: true,

            order: [],
            ajax: {
                data: {'search':data},    
                url: "get_boq_open_so_report_data",
                type: "POST",
            }, 
            columnDefs: [{ sortable: false, targets: 0 }],
    });
        $('.dataTables_length').find('label').contents().filter(function() {
            return this.nodeType === 3; // Filter out text nodes
        }).remove();
        setTimeout(function(){
        	$(".dataTables_length select").select2({
	            minimumResultsForSearch: Infinity
	        });
        },1000)
        
    },
    initiateMoredetails: function(){
    	$(document).on("click",".openMoreDetails",function(){
    		var project_id = $(this).attr("project_id");
    		let that = $(this);
    		$.ajax({
	            type: "POST",
	            url: "extend_table_row",
	            data: {project_id:project_id,type:"boq_open_so_report"},
	            success: function (response) {
	                var responseObject = JSON.parse(response);
	                $(that).parents("tr").after(responseObject.html);
	                $(that).html("Close Detail").removeClass("openMoreDetails").addClass("closeMoreDetails")
	            },
	            error: function (error) {
	                console.error("Error:", error);
	            },
	        });
    	})
    	$(document).on("click",".closeMoreDetails",function(){
    		console.log("ok")
    		 $(this).parents("tr").next(".extented_row").remove();
    		 $(this).addClass("openMoreDetails").removeClass("closeMoreDetails").html("More Detail")
    	});
    }
    
}
