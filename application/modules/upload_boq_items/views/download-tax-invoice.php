<div class="clsof text-center">
    <a href="<?php echo base_url(); ?>download_tax_invoice_format_1/<?php echo(isset($tax_invc_id) && !empty($tax_invc_id))?base64_encode($tax_invc_id):'0'?>" class="btn green" title="click To Download Tax Invoice Format 1" rel="0"><i class="fa fa-download" download></i> Download Tax Invoice Format 1</a>
    <a href="<?php echo base_url(); ?>download_tax_invoice_format_2/<?php echo(isset($tax_invc_id) && !empty($tax_invc_id))?base64_encode($tax_invc_id):'0'?>" class="btn green" title="click To Download Tax Invoice Format 2" rel="0" style="margin-top:15px;"><i class="fa fa-download" download></i> Download Tax Invoice Format 2</a>
</div>
<style>
    .modal-footer{
        display:none;
    }
    .modal-dialog{
        width:25%;
    }
    .modal-title{
    font-size: 12px;
    font-weight: 600;
    }
</style>