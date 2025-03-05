var project_id = $('#project_id').val().trim(); 
var base_url = $('#base_url').val().trim();
var download_title_a = 'Operable Schedule A';
var download_title_b = 'Operable Schedule B Positive';
var download_title_bn = 'Operable Schedule B Negative';
var download_title_c = 'Operable Schedule C';
var schedule_type = $('#schedule_type').val(); 
var schedule_release = $('#schedule_release').val(); 

if (schedule_type == 'A') {
    var pboqsch = $('#pboqscha').DataTable({
        "scrollX": true,
        "dom": 'Bfrtip',
        scrollY: 480,
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
                "title": download_title_a,
                "footer": true
            },
            {
                "extend": 'excel',
                "title": download_title_a,
                "footer": true,
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row c[r^="C"]', sheet).each( function () {
                        $(this).attr( 's', '55' );
                    });
                }
            },
            {
                "extend": 'pdf',
                "title": download_title_a,
                "footer": true
            },
            {
                "extend": 'print',
                "title": download_title_a,
                "footer": true
            },
            {
                'text': 'Submit Release Qty',
                'className': 'btn-release green js-release-bom-a-qty',
                "footer": true
            },
           
        ],
        "paging": true,
        "iDisplayLength": 25,
        "deferRender": true,
        "responsive": false,
        "processing": true,
        "serverSide": true,
       // "order": [],
        order: [[1, 'asc']],
        // Load data from an Ajax source
        "ajax": {
            "url": base_url+"boq_scha_list_display_for_bom_release_qty",
            "type": "POST",
            "data":{project_id:project_id},
            'dataSrc':function(result) {
                var buttons = pboqsch.buttons(['.js-release-bom-a-qty']);
                if(result.boq_without_bom && result.boq_without_bom!='' && result.boq_without_bom.length >= 0) {
                    const boqCodeWithoutBOM = result.boq_without_bom.join(',')
                    $('#invaliderrorid').html('BOM Items is not available for BOQ Sr No ('+boqCodeWithoutBOM+' )');
                    buttons.disable();
                } else {
                    $('#invaliderrorid').html('');
                }
                if(result.data.length === 0) {
                    buttons.disable();
                }
                if(result.boq_exceptional_design && result.boq_exceptional_design!='' && result.boq_exceptional_design >= 0) {
                    $('#invaliderrorid1').html(''+result.boq_exceptional_pending+' BOQ Exceptional Approval Pending!');
                    buttons.disable();
                } else {
                    $('#invaliderrorid1').html('');
                }

                if(result.boq_exceptional_ea && result.boq_exceptional_ea!='' && result.boq_exceptional_ea >= 0) {
                    $('#invaliderrorid1').html(''+result.boq_exceptional_ea+' BOQ Exceptional Approval Pending!');
                    buttons.disable();
                } else {
                    $('#invaliderrorid1').html('');
                }

                return result.data;  
            },
        },
         "columnDefs": [{ 
            "targets": [0,3,4,5],
            "orderable": false
        },
        { 
            "targets": [4,5,6,7,8,9,10],
            "orderable": false,
            "className": "text-right"
        }],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api();
            if (api.page.info().page === (api.page.info().pages - 1)) {
                $('.operable_a_footer').show();
            }else{
                $('.operable_a_footer').hide();
            }
        },
        initComplete: function () {
            pboqsch.rows().every(function () {
                var row = this;
                var rowData = row.data();
                // Check if subTableData is not empty
                if (rowData.subTableData && Object.keys(rowData.subTableData).length > 0) {
                    var tr = row.node();
                    var html = generate_table(rowData);
                    row.child(html).show();
                    $(tr).addClass('shown ');
                    $('.dt-hasChild').next().css('background','#f5f5f5');
                    $('.dt-hasChild').next().css('box-shadow','inset 0 0 0 9999px rgba(0, 0, 0, 0.075)');
                    $('.dt-hasChild').next().addClass('sub-table');
                    $('.sub-table > td ').css('padding', '0');
                    
                }
            });
        },
    });
     if(schedule_release =='yes') {pboqsch.buttons('.js-release-bom-a-qty').disable();}
} else if(schedule_type == 'B') {
    var pboqschb = $('#pboqschb').DataTable({
        "scrollX": true,
        scrollY: 600,
        scrollX: true,
        scroller: true,
        searching: false,
        fixedHeader: {
            header: true,
            footer: true
        },
        "dom": 'Bfrt',
        // "dom": 'Bfrtip',
        // "lengthMenu": [
        //     [25, 50, 75, 100, 125,150, -1],
        //     [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
        // ],
        "buttons": [
            'pageLength',
            // {
            //     "extend": 'copy',
            //     "title": download_title_b,
            //     "footer": true
            // },
            // {
            //     "extend": 'csv',
            //     "title": download_title_b,
            //     "footer": true
            // },
            // {
            //     "extend": 'excel',
            //     "title": download_title_b,
            //     "footer": true,
            //     customize: function(xlsx) {
            //         var sheet = xlsx.xl.worksheets['sheet1.xml'];
            //         $('row c[r^="C"]', sheet).each( function () {
            //             $(this).attr( 's', '55' );
            //         });
            //     }
            // },
            // {
            //     "extend": 'pdf',
            //     "title": download_title_b,
            //     "footer": true
            // },
            // {
            //     "extend": 'print',
            //     "title": download_title_b,
            //     "footer": true
            // },
            // {
            //     'text': 'Release Qty',
            //     'className': 'btn-release green js-release-qty',
            //     "footer": true,
            //     attr:  {
            //         type: 'B',
            //     }
            // },
         
        ],
        // Processing indicator
            "paging": false,
            "iDisplayLength": -1,
            "deferRender": true,
            "lengthChange": false,
            "responsive": false,
            "processing": true,
            "serverSide": true,
            // Initial no order.
            // "order": [],
          //  order: [[1, 'asc']],
            // Load data from an Ajax source
            "ajax": {
                "url": base_url+"boq_schb_list_display_for_bom_release_qty",
                "type": "POST",
                "data":{project_id:project_id},
                'dataSrc':function(result) {
                    //  console.log(result.boq_without_bom);
                      if(result.boq_approval_pending && result.boq_approval_pending!='' && result.boq_approval_pending.length >= 0) {
                          const boqCode = result.boq_approval_pending.join(',')
                          // console.log(boqCode);
                          $('#invaliderrorid').html('Release Quantity Pending for BOQ Sr No ('+boqCode+' )');
                      } else {
                          $('#invaliderrorid').html('');
                      }
                     return result.data;  
                  },
            },
            // "columnDefs": [{ 
            //      "targets": [0,3,4,5],
            //     "orderable": false
            // },
            // { 
            //     "targets": [4,5,6,7,8,9,10,11],
            //     "orderable": false,
            //     "className": "text-right"
            // }
            // ],
            // "footerCallback": function (row, data, start, end, display) {
            //     var api = this.api();
            //     if (api.page.info().page === (api.page.info().pages - 1)) {
            //         $('.operable_b_footer').show();
            //     }else{
            //         $('.operable_b_footer').hide();
            //     }
            // },
            initComplete: function () {
                pboqschb.rows().every(function () {
                    var row = this;
                    var rowData = row.data();
                    // Check if subTableData is not empty
                    if (rowData.subTableData && Object.keys(rowData.subTableData).length > 0) {
                        var tr = row.node();
                        var html = generate_table(rowData);
                        row.child(html).show();
                        $(tr).addClass('shown ');
                        $('.dt-hasChild').next().css('background','#f5f5f5');
                        $('.dt-hasChild').next().css('box-shadow','inset 0 0 0 9999px rgba(0, 0, 0, 0.075)');
                        $('.dt-hasChild').next().addClass('sub-table');
                        $('.sub-table > td ').css('padding', '0');
                        
                    }
                });
            },
    });
} else if(schedule_type == 'B-') {
    var pboqschb = $('#pboqschbn').DataTable({
        "scrollX": true,
        scrollY: 600,
        scrollX: true,
        scroller: true,
        searching: false,
        fixedHeader: {
            header: true,
            footer: true
        },
        "dom": 'Bfrt',
        "buttons": [
            'pageLength',
        ],
        // Processing indicator
            "paging": false,
            "iDisplayLength": -1,
            "deferRender": true,
            "lengthChange": false,
            "responsive": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": base_url+"boq_schbn_list_display_for_bom_release_qty",
                "type": "POST",
                "data":{project_id:project_id},
                'dataSrc':function(result) {
                      
                    if(result.boq_approval_pending && result.boq_approval_pending!='' && result.boq_approval_pending.length >= 0) {
                        const boqCode = result.boq_approval_pending.join(',')
                        $('#invaliderrorid').html('Release Quantity Pending for BOQ Sr No ('+boqCode+' )');
                    } else{
                        $('#invaliderrorid').html('');
                    }

                    if (result.boq_without_bom && result.boq_without_bom!='' && result.boq_without_bom.length >= 0) {
                        const boqCode = result.boq_without_bom.join(',')
                        $('#invaliderrorid1').html('BOM Items is not available for BOQ Sr No ('+boqCode+' )');
                    } else {
                        $('#invaliderrorid1').html('');
                    }

                    if (result.boq_ex_app_pending && result.boq_ex_app_pending!='' && result.boq_ex_app_pending.length >= 0) {
                        const boqCode = result.boq_ex_app_pending.join(',')
                        $('#invaliderrorid2').html('BOQ Exceptinal Pending for BOQ Sr No ('+boqCode+' )');
                    } else {
                        $('#invaliderrorid2').html('');
                    }

                     return result.data;  
                  },
            },
            initComplete: function () {
                pboqschb.rows().every(function () {
                    var row = this;
                    var rowData = row.data();
                    // Check if subTableData is not empty
                    if (rowData.subTableData && Object.keys(rowData.subTableData).length > 0) {
                        var tr = row.node();
                        var html = generate_table(rowData);
                        row.child(html).show();
                        $(tr).addClass('shown ');
                        $('.dt-hasChild').next().css('background','#f5f5f5');
                        $('.dt-hasChild').next().css('box-shadow','inset 0 0 0 9999px rgba(0, 0, 0, 0.075)');
                        $('.dt-hasChild').next().addClass('sub-table');
                        $('.sub-table > td ').css('padding', '0');
                        
                    }
                });
            },
    });
} else if (schedule_type == 'C') {
    
    var pboqschc = $('#pboqschc').DataTable({
        "scrollX": true,
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
                "title": download_title_c,
                "footer": true
            },
            // {
            //     "extend": 'csv',
            //     "title": download_title_c,
            //     "footer": true
            // },
            {
                "extend": 'excel',
                "title": download_title_c,
                "footer": true,
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row c[r^="C"]', sheet).each( function () {
                        $(this).attr( 's', '55' );
                    });
                }
            },
            {
                "extend": 'pdf',
                "title": download_title_c,
                "footer": true
            },
            {
                "extend": 'print',
                "title": download_title_c,
                "footer": true
            },
            // {
            //     'text': 'Release Qty',
            //     'className': 'btn-release green js-release-qty',
            //     "footer": true,
            //     attr:  {
            //         type: 'C',
            //     }
            // },
        ],
        "paging": true,
             "iDisplayLength": 25,
             "deferRender": true,
             "responsive": false,
            "processing": true,
            "serverSide": true,
            // Initial no order.
          //  "order": [],
          order: [[1, 'asc']],
            // Load data from an Ajax source
            "ajax": {
                "url": base_url+"boq_schc_list_display_for_bom_release_qty",
                "type": "POST",
                "data":{project_id:project_id},
                'dataSrc':function(result) {
                    if(result.boq_approval_pending && result.boq_approval_pending!='' && result.boq_approval_pending.length >= 0) {
                        const boqCode = result.boq_approval_pending.join(',')
                        $('#invaliderrorid').html('Release Quantity Pending for BOQ Sr No ('+boqCode+' )');
                    } else {
                        $('#invaliderrorid').html('');
                    }

                    if(result.boq_without_bom && result.boq_without_bom!='' && result.boq_without_bom.length >= 0) {
                        const boqCodeWithoutBOM = result.boq_without_bom.join(',')
                        $('#invaliderrorid').html('BOM Items is not available for BOQ Sr No ('+boqCodeWithoutBOM+' )');
                    } else {
                        $('#invaliderrorid').html('');
                    }

                    return result.data;  
                },
                
            },
            // "columnDefs": [{ 
            //      "targets": [0,3,4,5],
            //     "orderable": false
            // },
            // { 
            //     "targets": [4,5,6,7,8,9],
            //     "orderable": false,
            //     "className": "text-right"
            // }],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();
                if (api.page.info().page === (api.page.info().pages - 1)) {
                    $('.operable_c_footer').show();
                }else{
                    $('.operable_c_footer').hide();
                }
            },
            initComplete: function () {
                pboqschc.rows().every(function () {
                    var row = this;
                    var rowData = row.data();
                    // Check if subTableData is not empty
                    if (rowData.subTableData && Object.keys(rowData.subTableData).length > 0) {
                        var tr = row.node();
                        var html = generate_table(rowData);
                        row.child(html).show();
                        $(tr).addClass('shown');
                        $('.dt-hasChild').next().css('background','#f5f5f5');
                        $('.dt-hasChild').next().css('box-shadow','inset 0 0 0 9999px rgba(0, 0, 0, 0.075)');
                        $('.dt-hasChild').next().addClass('sub-table');
                        $('.sub-table > td ').css('padding', '0');
                    }
                });
            },
    });
}

function generate_table(rowData) {
//    console.log(rowData);
    // var boq_code = rowData.boq_code;
    let number = Math.floor(Math.random() * 1000000);

    var html = '<hr>';
    var html = '<div class="portlet-body" id="displayed' + number + '">'
    + '<div class="displayFlx" style="display:flex;">'
    + '<div class="col-md" id="calculatedfiler' + number + '"></div>'
    + '</div>'
    + '<div id="originalpbomviewdiv' + number + '"><div class="table-responsive">'
    + '<table width="100%" id="originalpbomview' + number + '" class="table table-striped table-bordered table-hover" style="margin-bottom:0;text-align: left;">'
    + '<thead style="background:#26a69a;color:#fff;font-weight:400;">'
    + '<tr>'
    + '<th scope="col" style="vertical-align: top;">BOM Sr.No.</th>'
    + '<th scope="col" style="vertical-align: top;">HNS Code</th>'
    + '<th scope="col" style="vertical-align: top;">BOM Item Description</th>'
    + '<th scope="col" style="vertical-align: top;">Make</th>'
    + '<th scope="col" style="vertical-align: top;">Model</th>'
    + '<th scope="col" style="vertical-align: top;">Unit</th>'
    + '<th scope="col" style="vertical-align: top;">Avl Release Qty</th>'
    + '<th scope="col" style="vertical-align: top;">Basic Rate</th>'
    + '<th scope="col" style="vertical-align: top;">GST (%)</th>'
    + '<th scope="col" style="vertical-align: top;">Amount</th>'
    // + '<th scope="col" style="vertical-align: top;text-align:right;">Action</th>'
    + '</tr>'
    + '</thead>'

        // Loop through subTableData and add rows to the sub-table
    for (var i = 0; i < rowData.subTableData.length; i++) {
        var subRowData = rowData.subTableData[i];
        html += '<tr>';
        for (var j = 0; j < subRowData.length; j++) {
            html += '<td>' + subRowData[j] + '</td>';
        }
        html += '</tr>';
    }
    html += '</tbody>'
    + '</table></div></div><hr style="margin: 5px 0;border:0;">';
    return html;
}

$(document).on('click', '.openBomview', function() {
	$(this).text(function(i, text){
		return text === "VIEW" ? " CLOSE" : "VIEW";
	});
    var id = $(this).closest('tr').next('tr').find('table').toggleClass('d-none');
});


$(".js-release-bom-a-qty").click(function() {
    bootbox.dialog({
        message: 'Are you sure you want to Release Schedule A Quantity',
        title: 'BOM Release Quantity', 
        buttons: { 
            success: {
                label: "Submit",
                className: "btn-success",
                callback: function() {
                    if (project_id) {
                        var url = 'release_schedule_a_quantity';
                        $.ajax({
                            url : completeURL(url),
                            type : 'POST',
                            dataType : 'json',
                            data:{project_id:project_id,'type':'schedule_a'},
                            success:function(data){       
                                bootbox.alert(data.msg, function() {
                                    window.location.href = data.redirect;
                                });    
                            },
                            complete:function(){
                            }
                        }); 
                    }
                }
            },
            danger: {
                label: "Cancel",
                className: "btn-danger",
                callback: function() { }
            } 
        }
    });
});

$(document).on('keyup', '.js-release_qty', function() {
    var $this = $(this);
    var qty = parseFloat($this.val());
    
    if(qty > 0) {

        var boq_sr_no = $this.closest('tr').find('.js-boq_sr_no').val();
        var url = 'check_boq_avl_release_qty';

        $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:{project_id:project_id,boq_code:boq_sr_no},
            success:function(result){
                var avl_relase_qty = parseInt(result);
                if(qty < 0){
                    $('#invaliderrorid').html('Release Quantity must be greater than 0!');
                    $this.val('');
                } else if(qty > avl_relase_qty) {
                    $('#invaliderrorid').html('Release Quantity must be less than or equal to Avl.Release Qty '+avl_relase_qty+'');
                    $this.val(avl_relase_qty);
                    calculateReleaseQuantity($this);
                } else {
                    $(this).removeClass('has-error');
                    $('#invaliderrorid').html('');
                    calculateReleaseQuantity($this);
                }
            }
        });
    } else {
        $('#invaliderrorid').html('Release Quantity must be greater than 0!');
        $this.val('');
        // calculateReleaseQuantity($this);
    }
});

function calculateReleaseQuantity(triggerElement) {
    var bomTableRow =  $(triggerElement).closest('tr');
    var quantity = $(bomTableRow).find('.js-avl_release_qty').val();
    var releaseQuantity = $(bomTableRow).find('.js-release_qty').val();
  
    var parsedQuantity = parseFloat(quantity);
    var tableCells = $(triggerElement).closest('tr').next('tr').find('table tbody');
    
    // console.log(quantity);
    // console.log(parsedQuantity);

    tableCells.find('.bom_release_avl_qty').each(function() {
        var originalAvailableQuantity = $(this).closest('tr').find('.bom_original_avl_qty').val();
        var bomRatio = $(this).closest('tr').find('.bom_ratio').val();

        var  bomGST = $(this).closest('tr').find('.js-bom-gst').val();
        var  bomRateBasic = $(this).closest('tr').find('.js-bom-rate-basic').val();

        var releaseAvailableQuantity = parseFloat($(this).val());
        var totalReleaseQuantity = parseFloat(bomRatio) * parseFloat(releaseQuantity);
        totalReleaseQuantity = totalReleaseQuantity.toFixed(2); // Round to two decimal points

        if (bomGST > 0) {
            var totalAmount = bomRateBasic * totalReleaseQuantity;
            var gstAmount = 0;
            // console.log(bomGST);
            if (totalAmount > 0 && bomGST > 0) {
                gstAmount = totalAmount * (bomGST / 100);
            }
            var finalAmount = totalAmount + gstAmount;
        } else {
            var finalAmount = 0;
        }
        $(this).closest('tr').find('.js-bom-amount').val(finalAmount.toFixed(2));
        $(this).val(totalReleaseQuantity);
    });
}

$(document).on('click','.delete_bom_qty',function(){
    if($(this).closest('tr').next('tr').hasClass('sub-table') == true) {
        $(this).closest('tr').next('tr').remove();
    }
    $(this).closest('tr').remove();
});

