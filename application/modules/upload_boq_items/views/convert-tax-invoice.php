<form action="convert_tax_invoice_details" enctype="multipart/form-data" id="popup_save"  method="post" class="horizontal-form">
    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
    <input type="hidden" name="proforma_id" id="proforma_id" value="<?php echo base64_encode($proforma_id);?>">
    <div class="form-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tax Invoice No <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                    <input type="text" class="form-control" id="tax_invc_no" name="tax_invc_no" placeholder="Tax Invoice No" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="">Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                    <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                        <input type="text" name="tax_invc_date" id="tax_invc_date" class="form-control" readonly="" placeholder="Select Tax Invoice Date">
                        <span class="input-group-btn">
                            <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</form>
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>
<script>
    if (jQuery().datepicker) {
            $('.date1').datepicker({
                orientation: "right",
                autoclose: true,
            });
        }
</script>
            						