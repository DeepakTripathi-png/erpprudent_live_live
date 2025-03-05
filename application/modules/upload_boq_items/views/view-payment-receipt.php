 <div id="TaxInvoicePaymentReceiptList">
    <input type="hidden" id="tax_invc_id" value="<?php echo base64_encode($tax_invc_id); ?>">
    <div class="row" style="margin-bottom: 25px;">
        <div class="col-md-12" style="font-size: 16px;font-weight: 600;margin-bottom: 5px;"><?php echo (isset($tax_invc_no) && !empty($tax_invc_no)) ? '#'.$tax_invc_no.' Payment Receipts' : '' ?></div>
    </div>
    <table width="100%" id="taxinvcpaymentRclist" class="table table-striped table-bordered table-hover">
        <thead>
             <tr>
                 <th style="min-width: 30px;width:30px;font-size:13px;">Sr No</th>
                 <th style="min-width: 80px;width:80px;font-size:13px;">Receipt No</th>
                 <th style="min-width: 80px;width:80px;font-size:13px;">Client Name</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Payment Account</th>
                 <th style="min-width: 150px;width:150px;font-size:13px;">Amount Received</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Payment Date</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Created Date</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Created By</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<style>
    .modal-footer{
        display:none;
    }
    .modal-dialog{
        width:80%;
    }
</style>
<script>
    var tax_invc_id = $('#tax_invc_id').val().trim(); 
    $('#taxinvcpaymentRclist').dataTable({
	    "bDestroy" : true,
	    "paging": true,
		"iDisplayLength": 10,
        "deferRender": true,
        "responsive": true,
        "processing": true,
		"serverSide": true,
        "order": [],
		"ajax": {
            "url": "<?php echo base_url('project_taxinvc_payment_receipts'); ?>",
            "type": "POST",
            "data":{tax_invc_id:tax_invc_id}
        },
        "columnDefs": [{ 
            "targets": [0],
            "orderable": false
        }]
    });
</script>