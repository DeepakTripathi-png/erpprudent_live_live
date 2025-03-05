<div class="clsof text-center">
    <a href="<?php echo base_url(); ?>download_proforma_invoice_format_1/<?php echo(isset($proforma_id) && !empty($proforma_id))?base64_encode($proforma_id):'0'?>" class="btn green" title="click To Download Proforma Invoice Format 1" rel="0"><i class="fa fa-download" download></i> Download Proforma Invoice Format 1</a>
    <a href="<?php echo base_url(); ?>download_proforma_invoice_format_2/<?php echo(isset($proforma_id) && !empty($proforma_id))?base64_encode($proforma_id):'0'?>" class="btn green" title="click To Download Proforma Invoice Format 2" rel="0" style="margin-top:15px;"><i class="fa fa-download" download></i> Download Proforma Invoice Format 2</a>
</div>
<style>
    .modal-footer{
        display:none;
    }
    .modal-dialog{
        width:30%;
    }
    .modal-title{
    font-size: 12px;
    font-weight: 600;
    }
</style>