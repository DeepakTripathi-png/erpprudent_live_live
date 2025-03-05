var project_id = $('#project_id').val().trim(); 
var base_url = $('#base_url').val().trim();
var download_title = 'Indent BOM Item List';
var recordsPerPage = 10; 

 var pbomindentlist = $('#pbomindentlist').DataTable({
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
        "sEmptyTable": "No Indent Request!"
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
        "url": base_url+"get_indent_request_list?project_id="+$('#project_id').val(),
        "type": "GET",
        "data":{project_id:project_id}
    },
    // "columnDefs": [{ 
    //     "targets": [0,2,3,4,5,6,7,8,9],
    //     "orderable": false
    // },
    // { 
    //     "targets": [4],
    //     "className": "text-right"
    // }]
});


$(document).on('change', '#project_id', function() {
    var project_id = $(this).val();
   // console.log(project_id);
    // var billable = $('#billable').val();
    if(project_id){
        $('#displayBomIndentItems,#bomIndentRemark').show();
        var table = $('#bomindentitmdisplay').DataTable({
            "bAutoWidth": false,
            "oLanguage": {
                "sEmptyTable": "No BOM Indent Items Available to Send for Approval"
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
                    "url": base_url+"get_bom_indent_item_by_project",
                    "type": "POST",
                    "data":{project_id:project_id},
                    'dataSrc':function(result) {
                          //  console.log(result.boq_without_bom);
                            if(result.indent_approval_pending && result.indent_approval_pending!='' && result.indent_approval_pending.length >= 0) {
                                const bomCode = result.indent_approval_pending.join(',')
                                // console.log(boqCode);
                                $('#invaliderrorid').html('Indent Quantity Pending for BOM Sr No ('+bomCode+' )');
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
            var url = base_url + "get_indent_request_list";
			// url += "?project_id=" + project_id;
			pbomindentlist.ajax.url(url).load();
        }

});


$(document).on('click','.editRecordIndent', function(){
    var project_id = $(this).attr('data-project-id');
    var url = $(this).attr('rev');
    var id = $(this).attr('rel');
    $.ajax({
        url : completeURL(url),
        type : 'POST',
        dataType : 'html',
        data:{project_id:project_id,id:id},
        success:function(data)
        {          
            $('html, body').animate({scrollTop:0});
            $('.form').html($(data).find('.form').html());
        },
        complete:function(){
            Layout.init();
            Metronic.init(); // init metronic core components
            Layout.init();
        }
    }); 
});







    //$(function() {
        
    // $(document).on('keyup','.js-required-qty',function(){

    //     var $this = $(this);
    //     var qty = parseFloat($this.val());
    //         console.log('dd');
    //     if(qty > 0) {
    //         var boq_sr_no = $this.closest('tr').find('.js-boq_sr_no').val();
    //         var url = 'check_boq_avl_release_qty';
    
    //         $.ajax({
    //             type:'POST',
    //             url:completeURL(url), 
    //             dataType:'json',
    //             data:{project_id:project_id,boq_code:boq_sr_no},
    //             success:function(result){
    //                 var avl_relase_qty = parseInt(result);
    //                 if(qty < 0){
    //                     $('#invaliderrorid').html('Release Quantity must be greater than 0!');
    //                     $this.val('');
    //                 } else if(qty > avl_relase_qty) {
    //                     $('#invaliderrorid').html('Release Quantity must be less than or equal to Avl.Release Qty '+avl_relase_qty+'');
    //                     $this.val(avl_relase_qty);
    //                     calculateReleaseQuantity($this);
    //                 } else {
    //                     $(this).removeClass('has-error');
    //                     $('#invaliderrorid').html('');
    //                     calculateReleaseQuantity($this);
    //                 }
    //             }
    //         });
    //     } else {
    //         $('#invaliderrorid').html('Release Quantity must be greater than 0!');
    //         $this.val('');
    //         // calculateReleaseQuantity($this);
    //     }
    // });
// });


   // $(function() {
        
    $(document).on('keyup','.js-required-qty-indent',function(){
         //console.log('fff');
        var $this = $(this);
        var qty = parseFloat($this.val());
            // console.log('dd');
        if(qty > 0) {
            var bom_sr_no = $this.closest('tr').find('.js-bom_sr_no').val();
            var max_qty_allow = $this.closest('tr').find('.js-req_qty').val();
            var url = 'check_bom_indent_qty';
            var project_id = $("#project_id").val();
            if(qty > max_qty_allow){
                $('#invaliderrorid').html('Indent Quantity must be less than or equal to Available Qty '+max_qty_allow+'');
                $this.val(max_qty_allow);
            } else {
                $('#invaliderrorid').html('');
            } 
        } else {
          //  console.log('ffdddd');
            $('#invaliderrorid').html('');
            // $this.val('');
            // calculateReleaseQuantity($this);
        }
    });
// });








$('#pbomindentlist tbody').on('click','.openview', function () {

    $(this).text(function(i, text){
        return text === "CLOSE" ? "VIEW" : "CLOSE";
    });

     var transaction_id = $(this).attr('data-id');
    // var transaction_type = $(this).attr('data-type');
    // var is_first_upload = $(this).attr('data-fid');

    var project_id = $(this).attr('data-project_id');
    var boq_code = $(this).attr('data-boq_code');
    var transaction_type = $(this).attr('data-type');
    var status_txt = $(this).attr('data-status');
  
    var filter = 'original'; 
    // $('#originalpboqviewdiv'+transaction_id).show();
    // $('#originalpboqviewdiv'+transaction_id).show();
    var tr = $(this).closest('tr');
    var row = pbomindentlist.row(tr);
   // console.log(table_bom);

   if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
    }else{
        var divwidth = $("#bomtranslist").width();
        var divminwidth = divwidth - 20;
        var filterhtml='';
        var headtxt='';
        download_title = 'BOM - Waiting for Approval';
        
        if(transaction_type == 'bom_upload'){
            download_title = 'Waiting for Approval (BOM Upload)';
        } else if (transaction_type == 'indent_request') {
            download_title = 'Indent Request';
        }

        var actionhtml='';
        var actionhtmlfooter='';

        var html = '<div class="portlet-body form" id="displayed'+boq_code+'">'
        +'<div class="displayFlx" style="margin-bottom: 15px;display:flex;">'
        +filterhtml
        +'<div class="col-md" id="calculatedfiler'+boq_code+'"></div>'
        +'</div>'
        +'<div id="originalpbomviewdiv'+boq_code+'"><div class="table-responsive">'
        +'<table width="100%" id="originalpbomview'+boq_code+'" class="table table-striped table-bordered table-hover" style="text-align: left;">'
        +'<thead style="background:#26a69a;color:#fff;font-weight:400;">'
        +'<tr>'
        +'<th scope="col" style="vertical-align: top;">Sr.no</th>'
        +'<th scope="col" style="vertical-align: top;">BOM Sr. No</th>'
        +'<th scope="col" style="vertical-align: top;">HNS Code</th>'
        +'<th scope="col" style="vertical-align: top;">Item Name</th>'
        +'<th scope="col" style="vertical-align: top;">Make</th>'
        +'<th scope="col" style="vertical-align: top;">Model</th>'
        +'<th scope="col" style="vertical-align: top;">Unit</th>'
        +'<th scope="col" style="vertical-align: top;text-align:right;">Quantity</th>'
        +'<th scope="col" style="vertical-align: top;text-align:right;">Rate Basic</th>'
        +'<th scope="col" style="vertical-align: top;text-align:right;">GST (%)</th>'
        +'<th scope="col" style="vertical-align: top;text-align:right;">Amount</th>'
        +'<th scope="col" style="vertical-align: top;text-align:right;">Status</th>'
        +actionhtml
        +'</tr>'
        +'</thead>'
        +'<tbody></tbody>'
        +'</table></div></div>';
        row.child(html).show();
        tr.addClass('shown');
        $('.dt-hasChild').next().css('background','#f5f5f5');
        $('.dt-hasChild').next().css('box-shadow','inset 0 0 0 9999px rgba(0, 0, 0, 0.075)');

        var table2 = $('#originalpbomview'+boq_code).DataTable({
            "dom": 'Bfrtip',
            scrollY: 400,
            scrollX: true,
            scroller: true,
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; // Calculate the current page
                var indexOnPage = iDisplayIndexFull % recordsPerPage; // Calculate the index on the current page
                var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;

                $("td:eq(0)", nRow).text(serialNumber); // Update the first cell content
                aData[0] = serialNumber; // Update the underlying data
            },
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
            "ajax": {
                "url": base_url+"project_bom_trans_list_display",
                "type": "POST",
                "data":{project_id:project_id,filter:filter,transaction_id:transaction_id,transaction_type:transaction_type,boq_code:boq_code,status_txt:status_txt}
            },
            
            "columnDefs": [{ 
                "targets": [0,3,4,5],
                "orderable": false
            },
            { 
                "targets": [6,7,8,9],
                "orderable": false,
                "className": "text-right"
            }],
        });
        new $.fn.dataTable.FixedHeader( table2 );
    }
});
