var project_id = $('#project_id').val().trim(); 
var base_url = $('#base_url').val().trim(); 
var download_title = 'BOQ Transactions';
  var recordsPerPage = 10; 
var table = $('#boqtranslist').DataTable({
	    "dom": 'Bfrtip',
                    "lengthMenu": [
                        [25, 50, 75, 100, 125,150, -1],
                        [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
                    ],
                    "buttons": [
                        'pageLength',
                        {
                            "extend": 'copy',
                            "title": download_title,
                            "exportOptions": {
                               "columns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13]
                            },
                            "footer": true
                        },
                        // {
                        //     "extend": 'csv',
                        //     "title": download_title,
                        //     "exportOptions": {
                        //         "columns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13]
                        //     },
                        //     "footer": true
                        // },
                        {
                            "extend": 'excel',
                            "title": download_title,
                            "exportOptions": {
                               "columns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13]
                            },
                            customize: function(xlsx) {
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                $('row c[r^="C"]', sheet).each( function () {
                                    $(this).attr( 's', '55' );
                                });
                            },
                            "footer": true
                        },
                        {
                            "extend": 'pdf',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13]
                            },
                            "footer": true
                        },
                        {
                            "extend": 'print',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13]
                            },
                            "footer": true
                        }
                    ],
            	    "scrollX": true,
	    "bAutoWidth": false,
	    "oLanguage": {
            "sEmptyTable": "No BOQ Transactions Available!"
        },
        "bDestroy" : true,
        "ordering": true,
        "searching":true,
        "paging": true,
        "iDisplayLength": 25,
        "deferRender": true,
        "responsive": false,
        "processing": true,
        "serverSide": false,
        "order": [[1, 'asc']],
     

            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; // Calculate the current page
                var indexOnPage = iDisplayIndexFull % recordsPerPage; // Calculate the index on the current page
                var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;

                $("td:eq(0)", nRow).text(serialNumber); // Update the first cell content
                aData[0] = serialNumber; // Update the underlying data
            },
        // Load data from an Ajax source
        "ajax": {
            "url": base_url+"get_boq_transaction_list",
            "type": "POST",
            "data":{project_id:project_id}
        },
		
        //Set column definition initialisation properties
        "columnDefs": [{ 
            "targets": [0,1,8],
            "orderable": false
        },
        { 
            "targets": [8],
            "className": "details-control"
        }]
    });
    $(document).ready(function() {
        $(document).on("change",".filter", function(){
            var filter = $(this).val();
            var transaction_id = $(this).attr('data-id');
            var transaction_type = $(this).attr('data-type');
            var recordsPerPage = 10; 
            download_title = 'BOQ Transactions';
            if(filter == 'calculated'){
            var html = '<div class="form-group">'
                +'<select class="form-control calculatedfiler" name="calculatedfiler" id="calculatedfiler'+transaction_id+'" data-id="'+transaction_id+'" data-type="'+transaction_type+'">'
                +'<option value="without_gst" data-id="'+transaction_id+'" data-type="'+transaction_type+'">Without GST</option>'
                +'<option value="with_gst" data-id="'+transaction_id+'" data-type="'+transaction_type+'">With GST</option>'
                +'</select></div>';
                $('#calculatedfiler'+transaction_id).html(html);    
            }else{
                $('#calculatedfiler'+transaction_id).html('');    
            }
            if(filter == 'original'){
                if(transaction_type =='boq_exceptional_appr'){
                    download_title = 'BOQ Transactions (BOQ Exceptional Approval)';
                }else if(transaction_type == 'boq_upload' || transaction_type == 'add_edit_boq'){
                    download_title = 'BOQ Transactions (BOQ Upload)';
                }
                $('#calwithoutgstpboqviewdiv'+transaction_id).hide();
                $('#calwithgstpboqviewdiv'+transaction_id).hide();
                $('#originalpboqviewdiv'+transaction_id).show();
                var otable = $('#originalpboqview'+transaction_id).DataTable({
        	        "dom": 'Bfrtip',
                    "lengthMenu": [
                        [25, 50, 75, 100, 125,150, -1],
                        [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
                    ],
                    "buttons": [
                        'pageLength',
                        {
                            "extend": 'copy',
                            "title": download_title,
                            "footer": true
                        },
                        // {
                        //     "extend": 'csv',
                        //     "title": download_title,
                        //     "footer": true
                        // },
                        {
                            "extend": 'excel',
                            "title": download_title,
                            "footer": true,
                            customize: function(xlsx) {
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                $('row c[r^="C"]', sheet).each( function () {
                                    $(this).attr( 's', '55' );
                                });
                            },
                        },
                        {
                            "extend": 'pdf',
                            "title": download_title,
                            "footer": true
                        },
                        {
                            "extend": 'print',
                            "title": download_title,
                            "footer": true
                        }
                    ],
            	    "bAutoWidth": false,
        	        "bDestroy" : true,
        	        "paging": true,
        		    "iDisplayLength": 25,
                    "deferRender": true,
                    "responsive": true,
                    "processing": true,
                    "serverSide": false,
                    "order": [[1, 'asc']],
                 
            
                        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                            var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; // Calculate the current page
                            var indexOnPage = iDisplayIndexFull % recordsPerPage; // Calculate the index on the current page
                            var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;
            
                            $("td:eq(0)", nRow).text(serialNumber); // Update the first cell content
                            aData[0] = serialNumber; // Update the underlying data
                        },
        		    "ajax": {
                        "url": base_url+"project_boq_trans_list_display",
                        "type": "POST",
                        "data":{project_id:project_id,filter:filter,transaction_id:transaction_id,transaction_type:transaction_type}
                    },
        		    "columnDefs": [{ 
                        "targets": [0,3,4,5],
                        "orderable": false
                    },
                    { 
                        "targets": [4,5,6,7,8,9],
                        "orderable": false,
                        "className": "text-right"
                    }],
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api();
                        if (api.page.info().page === (api.page.info().pages - 1)) {
                            $('.origfooter'+transaction_id).show();
                        }else{
                            $('.origfooter'+transaction_id).hide();
                        }
                    }
                });
                new $.fn.dataTable.FixedHeader( otable );
            }else{
                var calculatedfiler = 'without_gst';
                var recordsPerPage = 10;
                if(transaction_type =='boq_exceptional_appr'){
                    download_title = 'BOQ Transactions (BOQ Exceptional Approval)';
                }else if(transaction_type == 'boq_upload' || transaction_type == 'add_edit_boq'){
                    download_title = 'BOQ Transactions (BOQ Upload Without GST)';
                }
                $('#calwithoutgstpboqviewdiv'+transaction_id).show();
                $('#calwithgstpboqviewdiv'+transaction_id).hide();
                $('#originalpboqviewdiv'+transaction_id).hide();
                var caltable = $('#calwithoutgstpboqview'+transaction_id).DataTable({
                    "dom": 'Bfrtip',
                    "lengthMenu": [
                        [25, 50, 75, 100, 125,150, -1],
                        [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
                    ],
                    "buttons": [
                        'pageLength',
                        {
                            "extend": 'copy',
                            "title": download_title,
                            "footer": true
                        },
                        // {
                        //     "extend": 'csv',
                        //     "title": download_title,
                        //     "footer": true
                        // },
                        {
                            "extend": 'excel',
                            "title": download_title,
                            "footer": true,
                            customize: function(xlsx) {
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                $('row c[r^="C"]', sheet).each( function () {
                                    $(this).attr( 's', '55' );
                                });
                            },
                        },
                        {
                            "extend": 'pdf',
                            "title": download_title,
                            "footer": true
                        },
                        {
                            "extend": 'print',
                            "title": download_title,
                            "footer": true
                        }
                    ],
            	    "bAutoWidth": false,
                    "bDestroy" : true,
            	   "paging": true,
            		"iDisplayLength": 25,
                    "deferRender": true,
                    "responsive": false,
                    "processing": true,
            		"serverSide": false,
        "order": [[1, 'asc']],
     

            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; // Calculate the current page
                var indexOnPage = iDisplayIndexFull % recordsPerPage; // Calculate the index on the current page
                var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;

                $("td:eq(0)", nRow).text(serialNumber); // Update the first cell content
                aData[0] = serialNumber; // Update the underlying data
            },
            		"ajax": {
                        "url": base_url+"project_boq_trans_list_display",
                        "type": "POST",
                        "data":{project_id:project_id,filter:filter,calculatedfiler:calculatedfiler,transaction_id:transaction_id,transaction_type:transaction_type}
                    },
            		"columnDefs": [{ 
                        "targets": [0,3,4,5],
                        "orderable": false
                    },
                    { 
                        "targets": [4,5,6,7,8,9,10,11,12,13,14,15,16,17],
                        "orderable": false,
                        "className": "text-right"
                    }],
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api();
                        if (api.page.info().page === (api.page.info().pages - 1)) {
                            $('.withoutgstfooter'+transaction_id).show();
                        }else{
                            $('.withoutgstfooter'+transaction_id).hide();
                        }
                    }
                });
                new $.fn.dataTable.FixedHeader( caltable );
            }
        });
        $(document).on("change",".calculatedfiler", function(){
            var filter = 'calculated';
            var recordsPerPage = 10;
            var calculatedfiler = $(this).val();
            var transaction_id = $(this).attr('data-id');
            var transaction_type = $(this).attr('data-type');
            download_title = 'BOQ Transactions';
            if(calculatedfiler == 'without_gst'){
                if(transaction_type =='boq_exceptional_appr'){
                    download_title = 'BOQ Transactions (BOQ Exceptional Approval)';
                }else if(transaction_type == 'boq_upload' || transaction_type == 'add_edit_boq'){
                    download_title = 'BOQ Transactions (BOQ Upload Without GST)';
                }
                $('#calwithoutgstpboqviewdiv'+transaction_id).show();
                $('#calwithgstpboqviewdiv'+transaction_id).hide();
                $('#originalpboqviewdiv'+transaction_id).hide();
                var tTable = $('#calwithoutgstpboqview'+transaction_id).DataTable({
                        "dom": 'Bfrtip',
                        "lengthMenu": [
                            [25, 50, 75, 100, 125,150, -1],
                            [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
                        ],
                        "buttons": [
                            'pageLength',
                            {
                                "extend": 'copy',
                                "title": download_title,
                                "footer": true
                            },
                            // {
                            //     "extend": 'csv',
                            //     "title": download_title,
                            //     "footer": true
                            // },
                            {
                                "extend": 'excel',
                                "title": download_title,
                                "footer": true,
                                customize: function(xlsx) {
                                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                    $('row c[r^="C"]', sheet).each( function () {
                                        $(this).attr( 's', '55' );
                                    });
                                },
                            },
                            {
                                "extend": 'pdf',
                                "title": download_title,
                                "footer": true
                            },
                            {
                                "extend": 'print',
                                "title": download_title,
                                "footer": true
                            }
                        ],
                	    "bAutoWidth": false,
                        "bDestroy" : true,
            	        "paging": true,
            		    "iDisplayLength": 25,
                        "deferRender": true,
                        "responsive": false,
                        "processing": true,
                        "serverSide": false,
                        "order": [[1, 'asc']],
                     
                
                            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                                var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; // Calculate the current page
                                var indexOnPage = iDisplayIndexFull % recordsPerPage; // Calculate the index on the current page
                                var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;
                
                                $("td:eq(0)", nRow).text(serialNumber); // Update the first cell content
                                aData[0] = serialNumber; // Update the underlying data
                            },
            		    "ajax": {
                            "url": base_url+"project_boq_trans_list_display",
                            "type": "POST",
                            "data":{project_id:project_id,filter:filter,calculatedfiler:calculatedfiler,transaction_id:transaction_id,transaction_type:transaction_type}
                        },
            		    "columnDefs": [{ 
                            "targets": [0,3,4,5],
                            "orderable": false
                        },
                        { 
                            "targets": [4,5,6,7,8,9,10,11,12,13,14,15,16,17],
                            "orderable": false,
                            "className": "text-right"
                        }],
                       "footerCallback": function (row, data, start, end, display) {
                            var api = this.api();
                            if (api.page.info().page === (api.page.info().pages - 1)) {
                                $('.withoutgstfooter'+transaction_id).show();
                            }else{
                                $('.withoutgstfooter'+transaction_id).hide();
                            }
                        }
                });
                new $.fn.dataTable.FixedHeader( tTable );
                return false;
            }else{
                if(transaction_type =='boq_exceptional_appr'){
                    download_title = 'BOQ Transactions (BOQ Exceptional Approval)';
                }else if(transaction_type == 'boq_upload' || transaction_type == 'add_edit_boq'){
                    download_title = 'BOQ Transactions (BOQ Upload With GST)';
                }
                $('#calwithoutgstpboqviewdiv'+transaction_id).hide();
                $('#calwithgstpboqviewdiv'+transaction_id).show();
                $('#originalpboqviewdiv'+transaction_id).hide();
                var ttTable = $('#calwithgstpboqview'+transaction_id).DataTable({
                        "dom": 'Bfrtip',
                        "lengthMenu": [
                            [25, 50, 75, 100, 125,150, -1],
                            [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
                        ],
                        "buttons": [
                        'pageLength',
                            {
                                "extend": 'copy',
                                "title": download_title,
                                "footer": true
                            },
                            // {
                            //     "extend": 'csv',
                            //     "title": download_title,
                            //     "footer": true
                            // },
                            {
                                "extend": 'excel',
                                "title": download_title,
                                "footer": true,
                                customize: function(xlsx) {
                                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                    $('row c[r^="C"]', sheet).each( function () {
                                        $(this).attr( 's', '55' );
                                    });
                                },
                            },
                            {
                                "extend": 'pdf',
                                "title": download_title,
                                "footer": true
                            },
                            {
                                "extend": 'print',
                                "title": download_title,
                                "footer": true
                            }
                        ],
                	    "bAutoWidth": false,
                        "bDestroy" : true,
            	        "paging": true,
            		    "iDisplayLength": 25,
                        "deferRender": true,
                        "responsive": false,
                        "processing": true,
                        "serverSide": false,
                        "order": [[1, 'asc']],
                     
                
                            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                                var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; // Calculate the current page
                                var indexOnPage = iDisplayIndexFull % recordsPerPage; // Calculate the index on the current page
                                var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;
                
                                $("td:eq(0)", nRow).text(serialNumber); // Update the first cell content
                                aData[0] = serialNumber; // Update the underlying data
                            },
            		    "ajax": {
                            "url": base_url+"project_boq_trans_list_display",
                            "type": "POST",
                            "data":{project_id:project_id,filter:filter,calculatedfiler:calculatedfiler,transaction_id:transaction_id,transaction_type:transaction_type}
                        },
            		    "columnDefs": [{ 
                            "targets": [0,3,4,5],
                            "orderable": false
                        },
                        { 
                            "targets": [4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26],
                            "orderable": false,
                            "className": "text-right"
                        }],
                       "footerCallback": function (row, data, start, end, display) {
                            var api = this.api();
                            if (api.page.info().page === (api.page.info().pages - 1)) {
                                $('.withgstfooter'+transaction_id).show();
                            }else{
                                $('.withgstfooter'+transaction_id).hide();
                            }
                        }
                }); 
                new $.fn.dataTable.FixedHeader( ttTable );
                return false;
            }
        });
        
        $('#boqtranslist tbody').on('click','.openview', function () {
            $(this).text(function(i, text){
                  return text === "CLOSE" ? "VIEW" : "CLOSE";
            });
            var transaction_id = $(this).attr('data-id');
            var transaction_type = $(this).attr('data-type');
            var filter = 'original'; 
            var is_first_upload = $(this).attr('data-fid');
            $('#calwithoutgstpboqviewdiv'+transaction_id).hide();
            $('#calwithgstpboqviewdiv'+transaction_id).hide();
            $('#originalpboqviewdiv'+transaction_id).show();
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            var totalOriQty=0;
            var totalBasicRate=0;
            var totalOriAmount=0;
            var totalOriGstRate=0;
            var totalOriGstAmount=0;
            var totalOriAmountGST=0;
            var totalDesignQty=0;
            var totalODesignQty=0;
            var totalNegQty=0;
            var totalPosQty=0;
            var totalEaAmount=0;
            var totalEaAmountGST = 0;
            var totalNegAmount = 0;
            var totalNegAmountGST=0;
            var totalDsgnAmount=0;
            var totalDsgnAmountGST=0;
            var totalNSAmountGST=0;
            var totalNSAmount=0;
            var totalDsgnGSTAmount=0;
            var totalEaGSTAmount=0;
            var totalUdsgnQty = 0;
            var totalUdsgnAmount = 0;
            var totalUdsgnAmountGST = 0;
            var totalUdsgnGSTAmount = 0;
            $.ajax({
                    'async': false,
                    'type': "POST",
                    'global': false,
                    'dataType': 'json',
                    'url': base_url+"get_boq_item_amount",
                    'data': {filter:filter,transaction_id:transaction_id,transaction_type:transaction_type,project_id:project_id},
                    'success': function (result) {
                        if(result.totalOriQty !== '' && typeof result.totalOriQty !== "undefined"){
                            totalOriQty = result.totalOriQty;
                        }
                        if(result.totalBasicRate !== '' && typeof result.totalBasicRate !== "undefined"){
                            totalBasicRate = Math.abs(result.totalBasicRate).toFixed(2);
                        }
                        if(result.totalOriAmount !== '' && typeof result.totalOriAmount !== "undefined"){
                            totalOriAmount = Math.abs(result.totalOriAmount).toFixed(2);
                        }
                        if(result.totalOriGstRate !== '' && typeof result.totalOriGstRate !== "undefined"){
                            totalOriGstRate = Math.abs(result.totalOriGstRate).toFixed(2);
                        }
                        if(result.totalOriGstAmount !== '' && typeof result.totalOriGstAmount !== "undefined"){
                            totalOriGstAmount = Math.abs(result.totalOriGstAmount).toFixed(2);
                        }
                        if(result.totalOriAmountGST !== '' && typeof result.totalOriAmountGST !== "undefined"){
                            totalOriAmountGST = Math.abs(result.totalOriAmountGST).toFixed(2);
                        }
                        if(result.totalDesignQty !== '' && typeof result.totalDesignQty !== "undefined"){
                            totalDesignQty = result.totalDesignQty;
                        }
                        if(result.totalODesignQty !== '' && typeof result.totalODesignQty !== "undefined"){
                            totalODesignQty = result.totalODesignQty;
                        }
                        if(result.totalPosQty !== '' && typeof result.totalPosQty !== "undefined"){
                            totalPosQty = result.totalPosQty;
                        }
                        if(result.totalNegQty !== '' && typeof result.totalNegQty !== "undefined"){
                            totalNegQty = result.totalNegQty;
                        }
                        if(result.totalEaAmount !== '' && typeof result.totalEaAmount !== "undefined"){
                            totalEaAmount = Math.abs(result.totalEaAmount).toFixed(2);
                        }
                        if(result.totalEaAmountGST !== '' && typeof result.totalEaAmountGST !== "undefined"){
                            totalEaAmountGST = Math.abs(result.totalEaAmountGST).toFixed(2);
                        }
                        if(result.totalNegAmount !== '' && typeof result.totalNegAmount !== "undefined"){
                            totalNegAmount = Math.abs(result.totalNegAmount).toFixed(2);
                        }
                        if(result.totalNegAmountGST !== '' && typeof result.totalNegAmountGST !== "undefined"){
                            totalNegAmountGST = Math.abs(result.totalNegAmountGST).toFixed(2);
                        }
                        if(result.totalDsgnAmount !== '' && typeof result.totalDsgnAmount !== "undefined"){
                            totalDsgnAmount = Math.abs(result.totalDsgnAmount).toFixed(2);
                        }
                        if(result.totalDsgnAmountGST !== '' && typeof result.totalDsgnAmountGST !== "undefined"){
                            totalDsgnAmountGST = Math.abs(result.totalDsgnAmountGST).toFixed(2);
                        }
                        if(result.totalNSAmount !== '' && typeof result.totalNSAmount !== "undefined"){
                            totalNSAmount = Math.abs(result.totalNSAmount).toFixed(2);
                        }
                        if(result.totalNSAmountGST !== '' && typeof result.totalNSAmountGST !== "undefined"){
                            totalNSAmountGST = Math.abs(result.totalNSAmountGST).toFixed(2);
                        }
                        if(result.totalDsgnGSTAmount !== '' && typeof result.totalDsgnGSTAmount !== "undefined"){
                            totalDsgnGSTAmount = Math.abs(result.totalDsgnGSTAmount).toFixed(2);
                        }
                        if(result.totalEaGSTAmount !== '' && typeof result.totalEaGSTAmount !== "undefined"){
                            totalEaGSTAmount = Math.abs(result.totalEaGSTAmount).toFixed(2);
                        }
                        if(result.totalUdsgnQty !== '' && typeof result.totalUdsgnQty !== "undefined"){
                            totalUdsgnQty = result.totalUdsgnQty;
                        }
                        if(result.totalUdsgnAmount !== '' && typeof result.totalUdsgnAmount !== "undefined"){
                            totalUdsgnAmount = Math.abs(result.totalUdsgnAmount).toFixed(2);
                        }
                        if(result.totalUdsgnAmountGST !== '' && typeof result.totalUdsgnAmountGST !== "undefined"){
                            totalUdsgnAmountGST = Math.abs(result.totalUdsgnAmountGST).toFixed(2);
                        }
                        if(result.totalUdsgnGSTAmount !== '' && typeof result.totalUdsgnGSTAmount !== "undefined"){
                            totalUdsgnGSTAmount = Math.abs(result.totalUdsgnGSTAmount).toFixed(2);
                        }
                        
                        

                        
                    }
            });
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            }else{
                var divwidth = $("#boqtranslist").width();
                var divminwidth = divwidth - 20;
                var filterhtml='';
                var headtxt='';
                var oriQTy=0;
                var oriAmt=0;
                var oriAmtGST=0;
                var oriGSTAmt=0;
                download_title = 'BOQ Transactions';
                if(transaction_type =='boq_exceptional_appr'){
                    download_title = 'BOQ Transactions (BOQ Exceptional Approval)';
                    headtxt = 'EA';
                    oriQTy = totalPosQty; 
                    oriAmt = totalEaAmount;
                    oriAmtGST = totalEaAmountGST; 
                    oriGSTAmt = totalEaGSTAmount; 
                }else if(transaction_type == 'boq_upload' || transaction_type == 'add_edit_boq'){
                    download_title = 'BOQ Transactions (BOQ Upload)';
                    if(is_first_upload !=1){
                        headtxt = 'Dsgn';
                        oriQTy = totalUdsgnQty; 
                        oriAmt = totalUdsgnAmount; 
                        oriAmtGST = totalUdsgnGSTAmount; 
                        oriGSTAmt = totalUdsgnAmountGST; 
                    }else{
                        headtxt = 'Sch.';
                        oriQTy = totalOriQty; 
                        oriAmt = totalOriAmount; 
                        oriAmtGST = totalOriAmountGST; 
                        oriGSTAmt = totalOriGstAmount; 
                    }
                }
                /*if(transaction_type == 'boq_upload' || transaction_type == 'add_edit_boq'){
                if(is_first_upload !=1){
                    filterhtml='<div class="col-md" style="margin-right:10px;">'
                    +'<div class="form-group">'
                    +'<select class="form-control filter" name="filter" id="filter'+transaction_id+'" data-id="'+transaction_id+'"  data-type="'+transaction_type+'">'
                    +'<option value="original" data-id="'+transaction_id+'" data-type="'+transaction_type+'">Original</option>'
                    +'<option value="calculated" data-id="'+transaction_id+'" data-type="'+transaction_type+'">Calculated</option>'
                    +'</select>'
                    +'</div>'
                    +'</div>';
                }
                }*/
                var html = '<div class="portlet-body form" id="displayed'+transaction_id+'">'
                +'<div class="displayFlx" style="margin-bottom: 15px;display:flex;">'
                +filterhtml
                +'<div class="col-md" id="calculatedfiler'+transaction_id+'"></div>'
                +'</div>'
                +'<div id="originalpboqviewdiv'+transaction_id+'"><div class="table-responsive">'
                +'<table width="100%" id="originalpboqview'+transaction_id+'" class="table table-striped table-bordered table-hover" style="text-align: left;">'
                +'<thead style="background:#26a69a;color:#fff;font-weight:400;">'
                +'<tr>'
                +'<th scope="col" style="vertical-align: top;">Sr.no</th>'
                +'<th scope="col" style="vertical-align: top;">BOQ <br>Sr No</th>'
                +'<th scope="col" style="vertical-align: top;">Item Description</th>'
                +'<th scope="col" style="vertical-align: top;">Unit</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;">'+headtxt+'<br> Qty</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;">Rate <br> Basic</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;">'+headtxt+'<br> Amount<br>(Basic)</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;">GST<br> Rate(%)</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;">GST<br> Amount</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;">'+headtxt+'<br> Amount (GST)</th>'
                +'</tr>'
                +'</thead>'
                +'<tbody></tbody>'
                +'<tfoot class="origfooter'+transaction_id+'" style="display:none;">'
                +'<tr>'
                +'<th style="text-align:right;font-weight:600;"></th>'
                +'<th style="text-align:right;font-weight:600;"></th>'
                +'<th style="text-align:right;font-weight:600;"></th>'
                +'<th style="text-align:right;font-weight:600;">Grand Total</th>'
                +'<th style="text-align:right;font-weight:600;">'+oriQTy+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalBasicRate+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+oriAmt+'</th>'
                +'<th style="text-align:right;font-weight:600;"></th>'
                +'<th style="text-align:right;font-weight:600;">'+oriGSTAmt+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+oriAmtGST+'</th>'
                +'</tr>'
                +'</tfoot></table></div></div>'
                +'<div id="calwithoutgstpboqviewdiv'+transaction_id+'" style="display:none;"><div class="table-responsive-p" style="width:100%;max-width:'+divminwidth+'px;overflow-x:scroll;">'
                +'<table width="100%" id="calwithoutgstpboqview'+transaction_id+'" class="table table-striped table-bordered table-hover" style="text-align: left;">'
                +'<thead style="background:#26a69a;color:#fff;font-weight:400;">'
                +'<tr>'
                +'<th scope="col" style="vertical-align: top;">Sr.no</th>'
                +'<th scope="col" style="vertical-align: top;">BOQ<br>Sr No</th>'
                +'<th scope="col" style="vertical-align: top;">Item Description</th>'
                +'<th scope="col" style="vertical-align: top;">Unit</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Sch.<br> Qty</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Ori.Dsgn<br>Qty</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Build<br>Qty</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Rate <br> Basic</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">(+)ve<br>Var</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">(-)ve<br>Var</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">EA <br>Qty</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">EA<br>Amt</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Sch. Amt</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">(+)ve<br>Var Amt</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">(-)ve<br>Var Amt</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Build Amt</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">NS Item Amt</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Final<br>Contract Amt</th>'
                +'</tr>'
                +'</thead>'
                +'<tbody></tbody>'
                +'<tfoot class="withoutgstfooter'+transaction_id+'">'
                +'<tr>'
                +'<th style="text-align:right;font-weight:600;"></th>'
                +'<th style="text-align:right;font-weight:600;"></th>'
                +'<th style="text-align:right;font-weight:600;"></th>'
                +'<th style="text-align:right;font-weight:600;">Grand Total</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalOriQty+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalODesignQty+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalDesignQty+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalBasicRate+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalPosQty+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalNegQty+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalPosQty+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalEaAmount+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalOriAmount+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalEaAmount+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalNegAmount+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalDsgnAmount+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalNSAmount+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalDsgnAmount+'</th>'
                +'</tr>'
                +'</tfoot>'
                +'</table>'
                +'</div></div>'
                +'<div id="calwithgstpboqviewdiv'+transaction_id+'" style="display:none;"><div class="table-responsive-p" style="width:100%;max-width:'+divminwidth+'px;overflow-x:scroll;">'
                +'<table width="100%" id="calwithgstpboqview'+transaction_id+'" class="table table-striped table-bordered table-hover" style="text-align: left;">'
                +'<thead style="background:#26a69a;color:#fff;font-weight:400;">'
                +'<tr>'
                +'<th scope="col" style="vertical-align: top;">Sr.no</th>'
                +'<th scope="col" style="vertical-align: top;">BOQ<br>Sr No</th>'
                +'<th scope="col" style="vertical-align: top;">Item Description</th>'
                +'<th scope="col" style="vertical-align: top;">Unit</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Sch.<br>Qty</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Ori.Dsgn<br>Qty</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Build<br>Qty</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Rate <br> Basic</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">(+)ve<br>Var</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">(-)ve<br>Var</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">EA<br>Qty</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">EA Amount</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">EA <br>Amount<br>(GST)</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Sch.<br> Amount</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Sch.<br>Amount<br>(GST)</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">(+)ve <br>Var Amount</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">(+)ve <br>Var Amount(GST)</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">(-)ve <br>Var Amount</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">(-)ve <br>Var Amount(GST)</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Build<br>Amount</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Build<br>Amount<br>(GST)</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">NS Item<br>Amount</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">NS Item<br>Amount<br>(GST)</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Final <br>Contract Amount</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">GST Rate(%)</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">GST Amount</th>'
                +'<th scope="col" style="vertical-align: top;text-align:right;"">Final Contract <br>Amount(GST)</th>'
                +'</tr>'
                +'</thead>'
                +'<tbody></tbody>'
                +'<tfoot class="withgstfooter'+transaction_id+'">'
                +'<tr>'
                +'<th style="text-align:right;font-weight:600;"></th>'
                +'<th style="text-align:right;font-weight:600;"></th>'
                +'<th style="text-align:right;font-weight:600;"></th>'
                +'<th style="text-align:right;font-weight:600;">Grand Total</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalOriQty+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalODesignQty+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalDesignQty+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalBasicRate+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalPosQty+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalNegQty+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalPosQty+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalEaAmount+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalEaAmountGST+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalOriAmount+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalOriAmountGST+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalEaAmount+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalEaAmountGST+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalNegAmount+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalNegAmountGST+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalDsgnAmount+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalDsgnAmountGST+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalNSAmount+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalNSAmountGST+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalDsgnAmount+'</th>'
                +'<th style="text-align:right;font-weight:600;"></th>'
                +'<th style="text-align:right;font-weight:600;">'+totalDsgnGSTAmount+'</th>'
                +'<th style="text-align:right;font-weight:600;">'+totalDsgnAmountGST+'</th>'
                +'</tr>'
                +'</tfoot>'
                +'</table></div>'
                +'</div></div>';
                row.child(html).show();
                tr.addClass('shown');
                $('.dt-hasChild').next().css('background','#f5f5f5');
                $('.dt-hasChild').next().css('box-shadow','inset 0 0 0 9999px rgba(0, 0, 0, 0.075)');
                var table1 = $('#originalpboqview'+transaction_id).DataTable({
                    "bAutoWidth": false,
            	    "lengthMenu": [25, 50, 75, 100, 125,150],
                    "bDestroy" : true,
            	    "paging": true,
            		"iDisplayLength": 25,
                    "deferRender": true,
                    "responsive": true,
                    "processing": true,
            		"serverSide": false,
                 "order": [[1, 'asc']],
     

            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; // Calculate the current page
                var indexOnPage = iDisplayIndexFull % recordsPerPage; // Calculate the index on the current page
                var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;

                $("td:eq(0)", nRow).text(serialNumber); // Update the first cell content
                aData[0] = serialNumber; // Update the underlying data
            },
                    scrollY: 400,
                    scrollX: true,
                    scroller: true,
                    fixedHeader: {
                        header: true,
                        footer: true
                    },
            		"dom": 'Bfrtip',
                    "lengthMenu": [
                        [25, 50, 75, 100, 125,150, -1],
                        [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
                    ],
                    "buttons": [
                        'pageLength',
                        {
                            "extend": 'copy',
                            "title": download_title,
                            "footer": true
                        },
                        // {
                        //     "extend": 'csv',
                        //     "title": download_title,
                        //     "footer": true
                        // },
                        {
                            "extend": 'excel',
                            "title": download_title,
                            "footer": true,
                            customize: function(xlsx) {
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                $('row c[r^="C"]', sheet).each( function () {
                                    $(this).attr( 's', '55' );
                                });
                            },
                        },
                        {
                            "extend": 'pdf',
                            "title": download_title,
                            "footer": true
                        },
                        {
                            "extend": 'print',
                            "title": download_title,
                            "footer": true
                        }
                    ],
            	    "ajax": {
                        "url": base_url+"project_boq_trans_list_display",
                        "type": "POST",
                        "data":{project_id:project_id,filter:filter,transaction_id:transaction_id,transaction_type:transaction_type}
                    },
            		"columnDefs": [{ 
                                "targets": [0,3,4,5],
                                "orderable": false
                            },
                            { 
                                "targets": [4,5,6,7,8,9],
                                "orderable": false,
                                "className": "text-right"
                            }],
                            "footerCallback": function (row, data, start, end, display) {
                                var api = this.api();
                                if (api.page.info().page === (api.page.info().pages - 1)) {
                                    $('.origfooter'+transaction_id).show();
                                }else{
                                    $('.origfooter'+transaction_id).hide();
                                }
                            }
                });
                new $.fn.dataTable.FixedHeader( table1 );
            }
            
        });
    });
    
    