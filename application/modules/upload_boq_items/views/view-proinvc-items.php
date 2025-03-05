 <div id="ViewProformaInvoiceItemList">
     <input type="hidden" id="proforma_id" value="<?php echo base64_encode($proforma_id); ?>">
     <input type="hidden" id="proforma_no" value="<?php echo $proforma_no; ?>">
     <table width="100%" id="proinvcitemlistview" class="table table-striped table-bordered table-hover">
         <thead>
             <tr>
                 <th style="min-width: 30px;width:30px;font-size:13px;">Sr No</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">BOQ Sr No</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">HSN/SAC Code</th>
                 <th style="min-width: 350px;width:350px;font-size:13px;">Item Description</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Unit</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Qty</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Rate</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Amount</th>
             </tr>
         </thead>
         <tbody></tbody>
         <tfoot class="proinvoicefooter" style="display:none;">
                <tr style="text-align:right;font-weight:600;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">Sub Amount</td>
                    <td class="text-right" id="sub_total"><?php echo $sub_total; ?></td>
                </tr>
                <tr style="text-align:right;font-weight:600;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">GST Amount</td>
                 
                    <td class="text-right" id="gst_amount"><?php echo $gst_amount; ?></td>
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
                <tr style="text-align:right;font-weight:600;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">Addition Amount</td>
                    <td class="text-right" id="total_amount"><?php echo $auto_round_value; ?></td>
                </tr>
                <tr style="text-align:right;font-weight:600;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">Final Toal Amount</td>
                    <td class="text-right" id="total_amount"><?php echo $total_amount + $auto_round_value; ?></td>
                </tr>
                <?php 
                // pr($proforma_data->billing_type);
                if(!empty($proforma_data->billing_type) && $proforma_data->billing_type != null ){?>
                <tr style="text-align:right;font-weight:600;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">Total Billing Split Up Amount</td>
                    <td id="total_type_amount" style="text-align: right;font-weight:600;">
                        <?php
                        $billing_type_value = (isset($proforma_data->billing_type_value) && !empty($proforma_data->billing_type_value)) ? $proforma_data->billing_type_value : 0;
                        echo (isset($total_amount) && !empty($total_amount)) ?  number_format($total_amount*$billing_type_value/100, 2, '.', '') : '0.00' ;
                        
                        ?></td>
                </tr>
                <?php }?>
                
            </tfoot>
     </table>
 </div>
 <style>
    
     .text-right{
        text-align:end !important;
    }
    .modal-footer {
         display: none;
     }

     .modal-dialog {
         width: 80%;
     }
    
 </style>
 <script>
     var proforma_id = $('#proforma_id').val().trim();
     var proforma_no = $('#proforma_no').val().trim();
     var recordsPerPage = 10; 
     var download_title = proforma_no+' Proforma Invoice BOQ Item';
     $('#proinvcitemlistview').DataTable({
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
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7]
                            },
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
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7]
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
                                "columns": [0,1,2,3,4,5,6,7]
                            },
                            "footer": true
                        },
                        {
                            "extend": 'print',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7]
                            },
                            "footer": true
                        }
                    ],
                    "oLanguage": {
                "sEmptyTable": "No BOQ Items Available!"
            },
         "bDestroy": true,
         "paging": true,
         "iDisplayLength": 25,
         "deferRender": true,
         "responsive": true,
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
             "url": "<?php echo base_url('project_proinvc_items'); ?>",
             "type": "POST",
             "data": {
                 proforma_id: proforma_id
             }
         },
         "columnDefs": [{ 
            "targets": [0,2,3,4,5,6,7],
            "orderable": false,
        },
        { 
            "targets": [5,6,7],
            "className": 'text-right'
        }],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api();
            if (api.page.info().page === (api.page.info().pages - 1)) {
                $('.proinvoicefooter').show();
            }else{
                $('.proinvoicefooter').hide();
            }
        }


     });
 </script>