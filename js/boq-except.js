var project_id = $('#project_id').val().trim(); 
var base_url = $('#base_url').val().trim();
var download_title = 'BOQ Exceptional Approval';
$('#boqexceptlist').DataTable({
            "scrollX": true,
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

                                "columns": [0,1,2,3,4,5,6,7,8]

                            },

                            "footer": true

                        },

                        // {

                        //     "extend": 'csv',

                        //     "title": download_title,

                        //     "exportOptions": {

                        //         "columns": [0,1,2,3,4,5,6,7,8]

                        //     },

                        //     "footer": true

                        // },

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

                "sEmptyTable": "No BOQ Exceptional Approval Available!"

            },

            "bDestroy" : true,

            "bInfo" : false,

            "ordering": true,

            "searching":true,

            "paging": true,

            "iDisplayLength": 25,

            "deferRender": true,

            "responsive": false,

            "processing": true,

            "serverSide": false,


            "order": [],


            "ajax": {

                "url": base_url+"get_boq_exceptional_list",

                "type": "POST",

                "data":{project_id:project_id}

            },

            "columnDefs": [{ 
                "targets": [0,2,3,4,5,6,7,8,9],
                "orderable": false
            },
        { 
            "targets": [4],
            "className": "text-right"
        }]
    });

$(document).on('change', '#project_id', function() {
        var project_id = $(this).val();
        var billable = $('#billable').val();
        if(project_id){
            $('#displayBoqItems').show();
            var table = $('#boqitmdisplay').DataTable({
                "bAutoWidth": false,
                "oLanguage": {
                    "sEmptyTable": "No BOQ Items Available to Send for BOQ Exceptional Approval"
                },
                "bDestroy" : true,
                "bInfo" : false,
                    "ordering": false,
                    "searching":false,
                    "paging": false,
                    "deferRender": true,
                    "responsive": false,
                    "processing": true,
                    "serverSide": false,
                    "order": [],
                    "ajax": {
                        "url": base_url+"get_boq_exceptional_by_project",
                        "type": "POST",
                        "data":{project_id:project_id,billable:billable},
                        'dataSrc':function(result) {
                          //  console.log(result.boq_without_bom);
                            if(result.boq_without_bom && result.boq_without_bom!='' && result.boq_without_bom.length >= 0) {
                                const boqCode = result.boq_without_bom.join(',')
                                // console.log(boqCode);
                                $('#invaliderrorid').html('BOM Items is not available for BOQ Sr No ('+boqCode+' )');
                            } else {
                                $('#invaliderrorid').html('');
                            }
                           return result.data;  
                        },
                    },
                    "columnDefs": [{ 
                        "targets": [0],
                        "orderable": false
                    }]
                });

                if(billable == 'Y'){
                    $.ajax({
                        url:base_url+'get_boq_exceptional_amount', 
                        data:{project_id:project_id},          
                        type:'POST',  
                        dataType:'json', 
                        success: function(result)
                        { 
                            $('#PO_taxable_amt').val(result.PO_taxable_amt);
                            $('#gst_amount').val(result.gst_amount);
                            $('#po_final_amount').val(result.po_final_amount);
                            if(parseFloat(result.gst_rate) > 0){
                            $("#gst_rate").select2("val", result.gst_rate);
                            }else{
                            $("#gst_rate").select2("val", 'composite');
                            }
                        }
                    });
                }
            }
        });

$(document).on('change', '#billable', function() {

            var billable = $(this).val();

            var project_id = $('#project_id').val();

            if(project_id){

                $('#displayBoqItems').show();

                var table = $('#boqitmdisplay').DataTable({
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sEmptyTable": "No BOQ Items Available to Send for BOQ Exceptional Approval"
                        },

                	    "bDestroy" : true,
                	    "bInfo" : false,
                	    "ordering": false,
                	    "searching":false,
                	    "paging": false,
                		"deferRender": true,
                        "responsive": false,
                        "processing": true,
                		"serverSide": false,
                        "order": [],
                        "ajax": {
                            "url": base_url+"get_boq_exceptional_by_project",
                            "type": "POST",
                            "data":{project_id:project_id,billable:billable},
                            'dataSrc':function(result) {
                            if(result.boq_without_bom && result.boq_without_bom!='' && result.boq_without_bom.length >= 0) {
                                const boqCode = result.boq_without_bom.join(',')
                                $('#invaliderrorid').html('BOM Items is not available for BOQ Sr No ('+boqCode+' )');
                            } else {
                                $('#invaliderrorid').html('');
                            }
                            return result.data;  
                            },
                        },
                        "columnDefs": [{ 
                            "targets": [0],
                            "orderable": false
                        }]
                    });

                if(billable == 'Y'){
                    $.ajax({
                        url:base_url+'get_boq_exceptional_amount', 
                        data:{project_id:project_id},          
                        type:'POST',  
                        dataType:'json', 
                        success: function(result)
                        { 
                            $('#PO_taxable_amt').val(result.PO_taxable_amt);
                            $('#gst_amount').val(result.gst_amount);
                            $('#po_final_amount').val(result.po_final_amount);
                            if(parseFloat(result.gst_rate) > 0){
                            $("#gst_rate").select2("val", result.gst_rate);
                            }else{
                            $("#gst_rate").select2("val", 'composite');
                            }
                        }
                    });
                }
            }
        });