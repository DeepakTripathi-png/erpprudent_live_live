<div id="TaxInvoiceItemList">
    <input type="hidden" id="var_project_id" value="<?php echo base64_encode($project_id); ?>">
    <input type="hidden" id="variable_discount_tid" value="<?php echo $variable_discount_tid; ?>">
    <table width="100%" id="vardiscitemlist" class="table table-striped table-bordered table-hover">
        <thead>
             <tr>
                 <th style="min-width: 30px;width:30px;font-size:13px;">From Quantity</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">To Quantity</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Basic Rate</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Status</th>
                 <!-- <th style="min-width: 50px;width:50px;font-size:13px;">Action</th> -->
                
            </tr>
        </thead>
        <tbody></tbody>
         <!-- <tfoot class="taxinvoicefooter" style="display:none;">
            <tr style="text-align:right;font-weight:600;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td  class="text-right">Sub Total</td>
                <td  class="text-right" id="sub_total"><?php echo $sub_total; ?></td>
            </tr>
            <tr style="text-align:right;font-weight:600;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right">GST Amount</td>
                <td  class="text-right" id="gst_amount"><?php echo $gst_amount; ?></td>
            </tr>
            <tr style="text-align:right;font-weight:600;">
                 <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right">Total Amount</td>
                <td class="text-right" id="total_amount"><?php echo $total_amount; ?></td>
            </tr>
        </tfoot> -->
    </table>
</div>
<style>
    .text-right{
        text-align:end !important;
    }
    .modal-footer{
        display:none;
    }
    .modal-dialog{
        width:80%;
    }
</style>
<script>
    var var_project_id = $('#var_project_id').val().trim(); 
    var variable_discount_tid = $('#variable_discount_tid').val().trim(); 
    var recordsPerPage = 10; 

    var download_title = variable_discount_tid+' Varaible Discount BOQ Item';
    $('#vardiscitemlist').DataTable({
	    "bAutoWidth": false,
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
                            // "exportOptions": {
                            //     "columns": [0,1,2,3,4,5,6,7]
                            // },
                            "footer": true
                        },
                        // {
                        //     "extend": 'csv',
                        //     "title": download_title,
                        //     "exportOptions": {
                        //         "columns": [0,1,2,3,4,5,6,7]
                        //     },
                        //     "footer": true
                        // },
                        {
                            "extend": 'excel',
                            "title": download_title,
                            // "exportOptions": {
                            //     "columns": [0,1,2,3,4,5,6,7]
                            // },
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
                            // "exportOptions": {
                            //     "columns": [0,1,2,3,4,5,6,7]
                            // },
                            "footer": true
                        },
                        {
                            "extend": 'print',
                            "title": download_title,
                            // "exportOptions": {
                            //     "columns": [0,1,2,3,4,5,6,7]
                            // },
                            "footer": true
                        }
                    ],
                    "oLanguage": {
                "sEmptyTable": "No BOQ Items Available!"
            },
         "bDestroy" : true,
	    "paging": true,
		"iDisplayLength": 25,
        "deferRender": true,
        "responsive": true,
        "processing": true,
		"serverSide": false,
        // "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //             var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; 
        //             var indexOnPage = iDisplayIndexFull % recordsPerPage; 
        //             var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;
    
        //             $("td:eq(0)", nRow).text(serialNumber); 
        //             aData[0] = serialNumber; 
        //         },
        "order": [[1, 'asc']],
		"ajax": {
            "url": "<?php echo base_url('project_variable_discount_item'); ?>",
            "type": "POST",
            "data":{project_id:var_project_id,variable_discount_tid:variable_discount_tid}
        },
        // "columnDefs": [{ 
        //     "targets": [0,2,3,4,5,6,7],
        //     "orderable": false,
        // },
        // { 
        //     "targets": [5,6,7],
        //     "className": 'text-right'
        // }],
        // "footerCallback": function (row, data, start, end, display) {
        //     var api = this.api();
        //     if (api.page.info().page === (api.page.info().pages - 1)) {
        //         $('.taxinvoicefooter').show();
        //     }else{
        //         $('.taxinvoicefooter').hide();
        //     }
        // }
    });
</script>