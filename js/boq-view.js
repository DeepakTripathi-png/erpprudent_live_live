var project_id = $('#project_id').val().trim(); 
var base_url = $('#base_url').val().trim(); 
var recordsPerPage = 10; 
$(document).on("change","#filter", function(){
        var filter = $(this).val();
        var download_title = 'BOQ View';
        if(filter == 'original'){
            download_title = 'BOQ View Original';
            $('#calwithoutgstpboqviewdiv').hide();
            $('#calwithgstpboqviewdiv').hide();
            $('#originalpboqviewdiv').show();
            $('#originalpboqview').DataTable({
    	       "scrollX": true,
    	       "dom": 'Bfrtip',
               scrollY: 400,
               scrollX: true,
               scroller: true,
               fixedHeader: {
                   header: true,
                   footer: true
               },
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
                "bDestroy" : true,
    	        "paging": true,
    		    "iDisplayLength": 25,
                "deferRender": true,
                "responsive": false,
                "processing": true,
    		    "serverSide": false,
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; 
                    var indexOnPage = iDisplayIndexFull % recordsPerPage; 
                    var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;
    
                    $("td:eq(0)", nRow).text(serialNumber); 
                    aData[0] = serialNumber; 
                },
                "order": [[1, 'asc']],
    		    "ajax": {
                    "url": base_url+"project_boq_list_display",
                    "type": "POST",
                    "data":{project_id:project_id,filter:filter}
                },
    		    "columnDefs": [{ 
                    "targets": [0,2,4,5],
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
                        $('.origfooter').show();
                    }else{
                        $('.origfooter').hide();
                    }
                }
            });
        }else{
            var calculatedfiler = 'without_gst';
            download_title = 'BOQ View without GST';
            $('#calwithoutgstpboqviewdiv').show();
            $('#calwithgstpboqviewdiv').hide();
            $('#originalpboqviewdiv').hide();
            $('#calwithoutgstpboqview').DataTable({
        	   "scrollX": true,
        	   "dom": 'Bfrtip',
               scrollY: 400,
               scrollX: true,
               scroller: true,
               fixedHeader: {
                   header: true,
                   footer: true
               },
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
                "bDestroy" : true,
        	   "paging": true,
        		"iDisplayLength": 25,
                "deferRender": true,
                "responsive": false,
                "processing": true,
                "serverSide": false,
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; 
                    var indexOnPage = iDisplayIndexFull % recordsPerPage; 
                    var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;
    
                    $("td:eq(0)", nRow).text(serialNumber); 
                    aData[0] = serialNumber; 
                },
                "order": [[1, 'asc']],
        		"ajax": {
                    "url": base_url+"project_boq_list_display",
                    "type": "POST",
                    "data":{project_id:project_id,filter:filter,calculatedfiler:calculatedfiler}
                },
        		"columnDefs": [{ 
                    "targets": [0,2,4,5],
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
                        $('.withoutgstfooter').show();
                    }else{
                        $('.withoutgstfooter').hide();
                    }
                }
            });  
        }
    });
    $(document).on("change","#calculatedfiler", function(){
        var filter = 'calculated';
        var calculatedfiler = $(this).val();
        if(calculatedfiler == 'without_gst'){
            download_title = 'BOQ View without GST';
            $('#calwithoutgstpboqviewdiv').show();
            $('#calwithgstpboqviewdiv').hide();
            $('#originalpboqviewdiv').hide();
            $('#calwithoutgstpboqview').DataTable({
        	        "scrollX": true,
        	        "dom": 'Bfrtip',
                    scrollY: 400,
                    scrollX: true,
                    scroller: true,
                    fixedHeader: {
                        header: true,
                        footer: true
                    },
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
                    "bDestroy" : true,
        	        "paging": true,
        		    "iDisplayLength": 25,
                    "deferRender": true,
                    "responsive": false,
                    "processing": true,
        		    "serverSide": false,
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; 
                    var indexOnPage = iDisplayIndexFull % recordsPerPage; 
                    var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;
    
                    $("td:eq(0)", nRow).text(serialNumber); 
                    aData[0] = serialNumber; 
                },
                    "order": [[1, 'asc']],
        		    "ajax": {
                        "url": base_url+"project_boq_list_display",
                        "type": "POST",
                        "data":{project_id:project_id,filter:filter,calculatedfiler:calculatedfiler}
                    },
        		    "columnDefs": [{ 
                        "targets": [0,2,4,5],
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
                            $('.withoutgstfooter').show();
                        }else{
                            $('.withoutgstfooter').hide();
                        }
                    }
            });
            return false;
        }else{
            download_title = 'BOQ View with GST';
            $('#calwithoutgstpboqviewdiv').hide();
            $('#calwithgstpboqviewdiv').show();
            $('#originalpboqviewdiv').hide();
            $('#calwithgstpboqview').DataTable({
        	        "scrollX": true,
        	        "dom": 'Bfrtip',
                    scrollY: 400,
                    scrollX: true,
                    scroller: true,
                    fixedHeader: {
                        header: true,
                        footer: true
                    },
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
                    "bDestroy" : true,
        	        "paging": true,
        		    "iDisplayLength": 25,
                    "deferRender": true,
                    "responsive": false,
                    "processing": true,
                    "serverSide": false,
                    "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; 
                        var indexOnPage = iDisplayIndexFull % recordsPerPage; 
                        var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;
        
                        $("td:eq(0)", nRow).text(serialNumber); 
                        aData[0] = serialNumber; 
                    },
                    "order": [[1, 'asc']],
        		    "ajax": {
                        "url": base_url+"project_boq_list_display",
                        "type": "POST",
                        "data":{project_id:project_id,filter:filter,calculatedfiler:calculatedfiler}
                    },
        		    "columnDefs": [{ 
                        "targets": [0,2,4,5],
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
                            $('.withgstfooter').show();
                        }else{
                            $('.withgstfooter').hide();
                        }
                    }
            }); 
            return false;
        }
    });
    var filter = 'original'; 
    download_title = 'BOQ View Original';
    $('#calwithoutgstpboqviewdiv').hide();
    $('#calwithgstpboqviewdiv').hide();
    $('#originalpboqviewdiv').show();
    $('#originalpboqview').DataTable({
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
                "bDestroy" : true,
	   "paging": true,
		"iDisplayLength": 25,
        "deferRender": true,
        "responsive": false,
        "processing": true,
        "serverSide": false,
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; 
            var indexOnPage = iDisplayIndexFull % recordsPerPage; 
            var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;

            $("td:eq(0)", nRow).text(serialNumber); 
            aData[0] = serialNumber; 
        },
        scrollY: 400,
        scrollX: true,
        scroller: true,
        fixedHeader: {
            header: true,
            footer: true
        },
        "order": [[1, 'asc']],
		"ajax": {
            "url": base_url+"project_boq_list_display",
            "type": "POST",
            "data":{project_id:project_id,filter:filter}
        },
		"columnDefs": [{ 
                    "targets": [0,2,4,5],
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
                        $('.origfooter').show();
                    }else{
                        $('.origfooter').hide();
                    }
                }
    });
    