$(document).ready(function() {
    var base_url = $('#base_url').val().trim();
    var download_title = 'BOQ Item List';
    var recordsPerPage = 10; 
    var BoqItemdataTable = $('#pboqlist').DataTable({
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
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14]
                            },
                            "footer": true
                        },
                        // {
                        //     "extend": 'csv',
                        //     "title": download_title,
                        //     "exportOptions": {
                        //         "columns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14]
                        //     },
                        //     "footer": true
                        // },
                        {
                            "extend": 'excel',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14]
                            },
                            "footer": true,
                            customize: function(xlsx) {
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                $('row c[r^="D"]', sheet).each( function () {
                                    $(this).attr( 's', '55' );
                                });
                            }
                        },
                        {
                            "extend": 'pdf',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14]
                            },
                            "footer": true
                        },
                        {
                            "extend": 'print',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14]
                            },
                            "footer": true
                        }
                    ],
            	    "bAutoWidth": false,
            	    "oLanguage": {
            "sEmptyTable": "No BOQ Items Available!"
        },
        "paging": true,
		"iDisplayLength": 25,
        "deferRender": true,
        "responsive": true,
        "processing": true,
		"serverSide": false,
        "order": [[1, 'asc']],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; 
            var indexOnPage = iDisplayIndexFull % recordsPerPage;
            var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;

            $("td:eq(0)", nRow).text(serialNumber);
            aData[0] = serialNumber;
        },
		"ajax": {
            "url": base_url+"project_boq_item_list",
            "type": "POST",
            "data": {
                "project_id": $('#project_id').val()
            },
            dataSrc:function(result) {
                if(result.BOQUploadTransaction && result.BOQUploadTransaction!='' && result.BOQUploadTransaction >= 2) {
                    $("#boqUploadLimit").show();
                    $("#boq_excel_file").prop('disabled', true);
                } else {
                    $("#boqUploadLimit").hide();
                    $("#boq_excel_file").prop('disabled', false)
                }
               
                return result.data;  
            }
        },
		"columnDefs": [{ 
            "targets": [0,2,3,4,5,6,7,8,9,10,11],
            "orderable": false
        },
        { 
            "targets": [1,2],
            "className": "w150"
        },
        { 
            "targets": [3],
            "className": "w400"
        },
        { 
            "targets": [0,1,2,3,4,10],
            "className": "text-left"
        },
        { 
            "targets": [5,6,7,8,9],
            "className": "text-right"
        },
        { 
            "targets": [11],
            "className": "w40"
        }]
    });
    new $.fn.dataTable.FixedHeader(BoqItemdataTable);
    $(document).on('change', '#project_id', function() {
        var project_id = $(this).val();
        if(project_id){
            var url = base_url+"project_boq_item_list";
            url += "?project_id=" + project_id;
            BoqItemdataTable.ajax.url(url).load();
        }
    });
});
    