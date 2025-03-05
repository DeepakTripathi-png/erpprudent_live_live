<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title>Tax Invoice | <?php echo project_name; ?> </title>
    <base href="<?php echo base_url(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/css/components-rounded.css?<?php echo date('Ymd H:i:s'); ?>" id="style_components" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/css/plugins.css?<?php echo date('Ymd H:i:s'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/admin/layout4/css/layout.css?<?php echo date('Ymd H:i:s'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>/assets/admin/layout4/css/light.css?<?php echo date('Ymd H:i:s'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/site/css/validationEngine.jquery.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <style type="text/css">
    .statusselect{
        outline: unset;
        cursor: pointer;
        font-size: 13px;
        padding: 3px 5px;
        margin-top: 5px;
    }

    .statusselectoption{
        outline: unset;
        cursor: pointer;
        font-size: 13px;
    }

    .dataTables_filter {
        float: right;
    }

    .has-error-p {
        border: 1px solid #a94442;

    }

    table.dataTable thead>tr>th.sorting_asc,
    table.dataTable thead>tr>th.sorting_desc,
    table.dataTable thead>tr>th.sorting,
    table.dataTable thead>tr>td.sorting_asc,
    table.dataTable thead>tr>td.sorting_desc,
    table.dataTable thead>tr>td.sorting {
        padding-right: 19px;
    }

    .table-scrollable {
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        border: 1px solid #dddddd;
        margin: 10px 0 !important;
    }

    .dflx {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
    }
    </style>
</head>



<body class="page-header-fixed page-sidebar-closed-hide-logo ">
    <?php $this->load->view('common/header'); ?>
    <div class="clearfix"> </div>
    <div class="page-container">
        <?php $this->load->view('common/sidebar'); ?>
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="portlet-body">
                    
                    <?php if(isset($check_permission_update) && $check_permission_update == 'Y'){ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light" style="display:none;">
                                <div class="portlet-title">
                                    <div class="caption font-blue">
                                        <i class="fa fa-plus-circle font-blue"></i>
                                        <span class="caption-subject bold uppercase"> Create Tax Invoice</span>
                                    </div>
                                </div>

                                <div class="portlet-body form">
                                    <form action="<?php echo (isset($tax_invoice_data->tax_invc_id) && !empty($tax_invoice_data->tax_invc_id)) ? 'update_tax_invoice_details' : 'save_tax_invoice_details' ?>" enctype="multipart/form-data" id="<?php echo (isset($tax_invoice_data->tax_invc_id) && !empty($tax_invoice_data->tax_invc_id)) ? 'update_tax_invoice_details' : 'save_tax_invoice_details' ?>" method="post" class="horizontal-form">
                                        <input type="hidden" name="update_tax_invc_id" id="update_tax_invc_id" value="<?php echo (isset($tax_invoice_data->tax_invc_id) && !empty($tax_invoice_data->tax_invc_id)) ? $tax_invoice_data->tax_invc_id : '0' ?>">
                                        <div class="form-body">
                                            <div class="row">
                                                <?php if(isset($tax_invoice_items_data[0]->gst_type) && !empty($tax_invoice_items_data[0]->gst_type)){ ?>
                                                	<div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="">Billing Type <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="hidden" name="gst_type" id="gst_type" value="<?php echo (isset($tax_invoice_items_data[0]->gst_type) && !empty($tax_invoice_items_data[0]->gst_type) && $tax_invoice_items_data[0]->gst_type == 'intra-state') ? 'cgst_sgst' : 'igst' ?>">
                                                                <input type="text" class="form-control" name="gst_type_txt" id="gst_type_txt" value="<?php echo (isset($tax_invoice_items_data[0]->gst_type) && !empty($tax_invoice_items_data[0]->gst_type) && $tax_invoice_items_data[0]->gst_type == 'intra-state') ? 'Intra-State' : 'Inter-State' ?>" required="" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                								<?php }else{ ?>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="">Billing Type <span class="require" aria-required="true" style="color:#a94442;">*</span></label>
                                                        <select class="form-control select2me" name="gst_type" style="padding-left:0px !important;" id="gst_type" required>
                                                            <option value="cgst_sgst">Intra-State</option>
                                                            <option value="igst">Inter-State</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php } ?>

                                                <?php if(isset($tax_invoice_data->project_id) && !empty($tax_invoice_data->project_id)){ ?>
                                                	<div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="">Select Project <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="hidden" name="project_id" id="project_id" value="<?php echo (isset($tax_invoice_data->project_id) && !empty($tax_invoice_data->project_id)) ? $tax_invoice_data->project_id : '0' ?>">
                                                                <input type="text" class="form-control" name="bp_code" id="bp_code" value="<?php echo (isset($tax_invoice_data->bp_code) && !empty($tax_invoice_data->bp_code)) ? $tax_invoice_data->bp_code : '' ?> <?php echo (isset($tax_invoice_data->customer_name) && !empty($tax_invoice_data->customer_name)) ? ' ('.$tax_invoice_data->customer_name.')' : '' ?>" required="" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                								<?php }else{ ?>
                								<div class="col-md-6">
            										<div class="form-groupp">
            											<label class="control-label">Select Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            											<input type="text" class="form-control allprojects" id="project_id" name="project_id" placeholder="Select Project Code" required>
            											<span id="projlaoding"></span>
            									    </div>
            									</div>
            									<?php } ?>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="">Invoice Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                                                            <input type="text" name="invoice_date" id="invoice_date" value="<?php echo(isset($tax_invoice_data->tax_invc_date) && !empty($tax_invoice_data->tax_invc_date))?date('d-m-Y',strtotime($tax_invoice_data->tax_invc_date)):''?>" class="form-control" readonly="" placeholder="Tax Invoice Date">
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php if(isset($tax_invoice_data) && !empty($tax_invoice_data)){ ?>
            								    <?php if(isset($tax_invoice_items_data) && !empty($tax_invoice_items_data)){ ?>
            								        <?php if(isset($tax_invoice_items_data[0]->gst_type) && !empty($tax_invoice_items_data[0]->gst_type) && $tax_invoice_items_data[0]->gst_type == 'inter-state'){ ?>
            								            <div id="displayProformaInvcExist">
                                                            <table width="100%" id="proformainvcexistdisplay" class="table table-striped table-bordered table-hover">
                                                                <thead>
                                                                <th style="min-width: 50px;width:50px;">BOQ Sr No</th>
                                                                        <th style="min-width: 50px;width:105px;">HSN/SAC Code</th>
                                                                        <th style="min-width: 150px;width:150px;">Item Description</th>
                                                                        <th style="min-width: 30px; width: 50.2px; ">Unit</th>
                                                                        <th style="min-width: 50px;width:40px;">Qty</th>
                                                                        <th style="min-width: 80px;width:80px;">Rate</th>
                                                                        <th style="min-width: 50px;width:50px;">Taxable Amount</th>
                                                                        <th style="min-width: 50px;width:50px;">IGST%</th>
                                                                        <th style="min-width: 50px;width:50px;">IGST Amt</th>
                                                                        <th style="min-width: 10px;width:10px;">-</th>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $proforma_sub_total=0; $proforma_total_gst=0; $proforma_igst_final=0; $i=0;foreach($tax_invoice_items_data as $key){ $class="odd"; if($i%2==0){ $class="even"; }else{ $class="odd"; } ?>
                                                                        <?php $gst_amount  = (isset($key->gst_amount) && !empty($key->gst_amount)) ? $key->gst_amount : '0'; ?>
                            								            <?php $taxable_amount  = (isset($key->taxable_amount) && !empty($key->taxable_amount)) ? $key->taxable_amount : '0'; 
                            								                    $proforma_itotal_amount=0; $proforma_itotal_amount = $taxable_amount + $gst_amount ;
                            								                    $proforma_sub_total += $taxable_amount;
                            								                    $proforma_total_gst += $gst_amount;
                            								                    $proforma_igst_final += $proforma_itotal_amount;
                            								            ?>

                            								            <tr role="row" class="<?php echo $class; ?>">
                            								                <td>
                            								                    <input type="hidden" name="tax_invc_itemid[]" value="<?php echo (isset($key->tax_invc_itemid) && !empty($key->tax_invc_itemid)) ? $key->tax_invc_itemid : '0' ?>">
                            								                    <input type="text" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_boq_code[]" value="<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" readonly="" style="font-size: 12px;">
                            								                </td>

                            								                <td>
                            								                    <input type="text" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_hsn_sac_code[]" value="<?php echo (isset($key->hsn_sac_code) && !empty($key->hsn_sac_code)) ? $key->hsn_sac_code : '0' ?>" readonly="" style="font-size: 12px;">
                            								                </td>

                            								                <td>
                            								                    <input type="text" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_item_description[]" value="<?php echo (isset($key->item_description) && !empty($key->item_description)) ? $key->item_description : '0' ?>" readonly="" style="font-size: 12px;">
                            								                </td>

                            								                <td>
                            								                    <input type="text" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_unit[]" value="<?php echo (isset($key->unit) && !empty($key->unit)) ? $key->unit : '0' ?>" readonly="" style="font-size: 12px;">
                            								                </td>

                            								                <td>
                            								                    <input type="number" class="form-control checktaxinvoiceqty invalidqtytaxinvoiceerror_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?> invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_qty[]" value="<?php echo (isset($key->qty) && !empty($key->qty)) ? $key->qty : '0' ?>"  data-id="<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>"  data-pid="<?php echo (isset($tax_invoice_data->project_id) && !empty($tax_invoice_data->project_id)) ? $tax_invoice_data->project_id : '0' ?>" data-cid="<?php echo (isset($tax_invoice_data->convertid) && !empty($tax_invoice_data->convertid)) ? $tax_invoice_data->convertid : '0' ?>" style="font-size: 12px;">
                            								                </td>

                            								                <td>
                            								                    <input type="number" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_rate[]" id="proforma_rate_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" value="<?php echo (isset($key->rate) && !empty($key->rate)) ? $key->rate : '0' ?>" readonly="" style="font-size: 12px;">
                            								                </td>

                            								                <td>
                            								                    <input type="number" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_itaxable_amount[]" id="proforma_itaxable_amount_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" value="<?php echo (isset($key->taxable_amount) && !empty($key->taxable_amount)) ? $key->taxable_amount : '0' ?>" readonly="" style="font-size: 12px;">
                            								                </td>

                            								                <td>
                            								                    <input type="number" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_gst[]" id="proforma_gst_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" value="<?php echo (isset($key->gst) && !empty($key->gst)) ? $key->gst : '0' ?>" readonly="" style="font-size: 12px;">
                            								                </td>

                            								                <td>
                            								                    <input type="number" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_itotal_amount[]" id="proforma_itotal_amount_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" value="<?php echo (isset($proforma_itotal_amount) && !empty($proforma_itotal_amount)) ? $proforma_itotal_amount : '0' ?>" readonly="" style="font-size: 12px;">
                            								                    <input type="hidden" class="form-control" name="proforma_gst_amount[]" id="proforma_gst_amount_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" value="<?php echo (isset($key->gst_amount) && !empty($key->gst_amount)) ? $key->gst_amount : '0' ?>" readonly="" style="font-size: 12px;">
                            								                </td>

                            								                <td>

                            								                    <div class="addDeleteButton">
                            								                        <span class="tooltips deletePerfomaInvcRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;">
                            								                            <i class="fa fa-trash-o"></i></span>
                            								                    </div>
                            								                </td>
                            								            </tr>
                            								        <?php $i++; } ?>
                            								        <tr role="row" class="odd"><td><input type="text" class="form-control invaliderrorpro" id="taxinvoice_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;"></td><td><input type="text" class="form-control invaliderrorpro" id="proforma_hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;"></td><td><input type="text" class="form-control invaliderrorpro" id="proforma_item_description" placeholder="Item Description" style="font-size: 12px;"></td><td><input type="text" class="form-control invaliderrorpro" id="proforma_unit" placeholder="Unit" style="font-size: 12px;"></td><td><input type="number" min="1" class="form-control invaliderrorpro" id="proforma_qty" placeholder="Qty" style="font-size: 12px;"></td><td><input type="number" min="1" class="form-control invaliderrorpro" id="proforma_rate" placeholder="Rate" style="font-size: 12px;"></td><td><input type="number" min="1" class="form-control invaliderrorpro" id="proforma_itaxable_amount" placeholder="Tax" style="font-size: 12px;" readonly=""></td><td><input type="number" min="1" class="form-control invaliderrorpro" id="proforma_gst" placeholder="GST" style="font-size: 12px;"></td><td><input type="number" min="1" class="form-control invaliderrorpro" id="proforma_itotal_amount" placeholder="TotalAmount" style="font-size: 12px;" readonly=""><input type="hidden" id="proforma_gst_amount" value="0"></td><td><div class="addDeleteButton"><span class="tooltips addTaxInvoiceRow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span></div></td></tr>
                            								    </tbody>

                                                                <tfoot>
                                                                    <tr>
                                                                        <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Sub Total</span></td>
                                                                        <td id="proforma_sub_total" style="text-align: right;font-weight:600;"><?php echo (isset($proforma_sub_total) && !empty($proforma_sub_total)) ? $proforma_sub_total : '0.00' ?></td>
                                                                        <td></td> 
                                                                        <td></td>
                                                                        <td></td>
                                                                     </tr>

                                                                    <tr>
                                                                        <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">IGST</span></td>
                                                                        <td id="proforma_total_gst" style="text-align: right;font-weight:600;"><?php echo (isset($proforma_total_gst) && !empty($proforma_total_gst)) ? $proforma_total_gst : '0.00' ?></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Total Amount of This Invoice</span></td>
                                                                        <td id="proforma_igst_final" style="text-align: right;font-weight:600;"><?php echo (isset($proforma_igst_final) && !empty($proforma_igst_final)) ? $proforma_igst_final : '0.00' ?></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                            <p id="invaliderrorprod" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>
                                                        </div>
            								        <?php }else{ ?>

            								            <div id="displayperfomaInvccgstExist">

                                                            <table width="100%" id="taxperfomadisplaysgstsexist" class="table table-striped table-bordered table-hover">

                                                                <thead>

                                                                    <tr>

                                                                        <th style="min-width: 50px;width:50px;">BOQ Sr No</th>

                                                                        <th style="min-width: 50px;width:100px;">HSN/SAC Code</th>

                                                                        <th style="min-width: 150px;width:150px;">Item Description</th>

                                                                        <th style="min-width: 30px;width:40px;">Unit</th>

                                                                        <th style="min-width: 50px;width:40px;">Qty</th>

                                                                        <th style="min-width: 80px;width:80px;">Rate</th>

                                                                        <th style="min-width: 50px;width:100px;">Taxable Amount</th>

                                                                        <th style="min-width: 30px;width:40px;">SGST%</th>

                                                                        <th style="min-width: 50px;width:50px;">SGST Amt</th>

                                                                        <th style="min-width: 30px;width:40px;">CGST%</th>

                                                                        <th style="min-width: 50px;width:50px;">CGST Amt</th>

                                                                        <th style="min-width: 10px;width:10px;">-</th>

                                                                    </tr>

                                                                </thead>

                                                                <tbody>

                                                                    <?php $proforma_sub_total1 = 0; $proforma_cgst_total1 = 0; $proforma_sgst_total1=0; $proforma_final1 = 0;

                                                                    $i=0;foreach($tax_invoice_items_data as $key){ $class="odd"; if($i%2==0){ $class="even"; }else{ $class="odd"; } ?>

                            								            <?php 

                            								            $taxable_amount=0;

                            								            $taxable_amount = (isset($key->taxable_amount) && !empty($key->taxable_amount)) ? $key->taxable_amount : '0';

                            								            $sgst_amount=0;

                            								            $sgst_amount = (isset($key->sgst_amount) && !empty($key->sgst_amount)) ? $key->sgst_amount : '0';

                            								            $cgst_amount=0;

                            								            $cgst_amount = (isset($key->cgst_amount) && !empty($key->cgst_amount)) ? $key->cgst_amount : '0';

                            								            $itotal_amount = 0;

                            								            $itotal_amount = $taxable_amount + $sgst_amount + $cgst_amount;

                            								            $proforma_sub_total1 += $taxable_amount;

                            								            $proforma_cgst_total1 += $cgst_amount;

                            								            $proforma_sgst_total1 += $sgst_amount;

                            								            $proforma_final1 += $itotal_amount;

                            								            ?>

                            								            <tr role="row" class="<?php echo $class; ?>">

                            								                <td>

                            								                    <input type="hidden" name="tax_invc_itemid[]" value="<?php echo (isset($key->tax_invc_itemid) && !empty($key->tax_invc_itemid)) ? $key->tax_invc_itemid : '0' ?>">

                            								                    <input type="text" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_boq_code_v[]" value="<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" readonly="" style="font-size: 12px;">

                            								                </td>

                            								                <td>

                            								                    <input type="text" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_hsn_sac_code[]" value="<?php echo (isset($key->hsn_sac_code) && !empty($key->hsn_sac_code)) ? $key->hsn_sac_code : '0' ?>" readonly="" style="font-size: 12px;">

                            								                </td>

                            								                <td>

                            								                    <input type="text" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_item_description[]" value="<?php echo (isset($key->item_description) && !empty($key->item_description)) ? $key->item_description : '0' ?>" readonly="" style="font-size: 12px;">

                            								                </td>

                            								                <td>

                            								                    <input type="text" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_unit[]" value="<?php echo (isset($key->unit) && !empty($key->unit)) ? $key->unit : '0' ?>" readonly="" style="font-size: 12px;">

                            								                </td>

                            								                <td>

                            								                    <input type="number" class="form-control checktaxinvoiceqty invalidqtytaxinvoiceerror_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?> invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_qty[]" value="<?php echo (isset($key->qty) && !empty($key->qty)) ? $key->qty : '0' ?>" data-id="<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>"  data-pid="<?php echo (isset($tax_invoice_data->project_id) && !empty($tax_invoice_data->project_id)) ? $tax_invoice_data->project_id : '0' ?>" data-cid="<?php echo (isset($tax_invoice_data->convertid) && !empty($tax_invoice_data->convertid)) ? $tax_invoice_data->convertid : '0' ?>" style="font-size: 12px;">

                            								                </td>

                            								                <td>

                            								                    <input type="number" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_rate[]" id="proforma_rate_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" value="<?php echo (isset($key->rate) && !empty($key->rate)) ? $key->rate : '0' ?>" readonly="" style="font-size: 12px;">

                            								                </td>

                            								                <td>

                            								                    <input type="number" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_itaxable_amount[]" id="proforma_itaxable_amount_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" value="<?php echo (isset($key->taxable_amount) && !empty($key->taxable_amount)) ? $key->taxable_amount : '0' ?>" readonly="" style="font-size: 12px;">

                            								                </td>

                            								                <td>

                            								                    <input type="number" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_sgst[]" id="proforma_sgst_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" value="<?php echo (isset($key->sgst) && !empty($key->sgst)) ? $key->sgst : '0' ?>" readonly="" style="font-size: 12px;">

                            								                </td>

                            								                <td>

                            								                    <input type="number" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_sgst_amount[]" id="proforma_sgst_amount_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" value="<?php echo (isset($key->sgst_amount) && !empty($key->sgst_amount)) ? $key->sgst_amount : '0' ?>" readonly="" style="font-size: 12px;">

                            								                </td>

                            								                <td>

                            								                    <input type="number" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_cgst[]"  id="proforma_cgst_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" value="<?php echo (isset($key->cgst) && !empty($key->cgst)) ? $key->cgst : '0' ?>" readonly="" style="font-size: 12px;">

                            								                </td>

                            								                <td>

                            								                    <input type="number" class="form-control invalidqtytaxinvoice_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="proforma_cgst_amount[]"  id="proforma_cgst_amount_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" value="<?php echo (isset($key->cgst_amount) && !empty($key->cgst_amount)) ? $key->cgst_amount : '0' ?>" readonly="" style="font-size: 12px;">

                            								                </td>

                            								                <td>

                            								                    <div class="addDeleteButton">

                            								                        <span class="tooltips deletePerfomaInvcRow1" data-placement="top" data-original-title="Remove" style="cursor: pointer;">

                            								                            <i class="fa fa-trash-o"></i></span>

                            								                    </div>

                            								                </td>

                            								            </tr>

                            								        <?php $i++; } ?>

                            								        <tr role="row" class="odd">

                            								            <td>

                            								                <input type="text" class="form-control invaliderrorpro1" id="taxinvoice_boq_code1" placeholder="BOQ Sr No" style="font-size: 12px;">

                            								            </td>

                            								            <td>

                            								                <input type="text" class="form-control invaliderrorpro1" id="proforma_hsn_sac_code1" placeholder="HSN/SAC Code" style="font-size: 12px;">

                            								            </td>

                            								            <td>

                            								                <input type="text" class="form-control invaliderrorpro1" id="proforma_item_description1" placeholder="Item Description" style="font-size: 12px;">

                            								            </td>

                            								            <td>

                            								                <input type="text" class="form-control invaliderrorpro1" id="proforma_unit1" placeholder="Unit" style="font-size: 12px;">

                            								            </td>

                            								            <td>

                            								                <input type="number" min="1" class="form-control invaliderrorpro1" id="proforma_qty1" placeholder="Qty" style="font-size: 12px;">

                            								            </td>

                            								            <td>

                            								                <input type="number" min="1" class="form-control invaliderrorpro1" id="proforma_rate1" placeholder="Rate" style="font-size: 12px;">

                            								            </td>

                            								            <td>

                            								                <input type="number" min="1" class="form-control invaliderrorpro1" id="proforma_itaxable_amount1" placeholder="Tax" style="font-size: 12px;" readonly="">

                            								            </td>

                            								            <td>

                            								                <input type="number" min="1" class="form-control invaliderrorpro1" id="proforma_sgst1" placeholder="SGST" style="font-size: 12px;">

                            								            </td>

                            								            <td>

                            								                <input type="number" min="1" readonly="" class="form-control invaliderrorpro1" id="proforma_sgst_amount1" placeholder="Amount" style="font-size: 12px;">

                            								            </td>

                            								            <td>

                            								                <input type="number" min="1" class="form-control invaliderrorpro1" id="proforma_cgst1" placeholder="CGST" style="font-size: 12px;">

                            								            </td>

                            								            <td>

                            								                <input type="number" min="1" readonly="" class="form-control invaliderrorpro1" id="proforma_cgst_amount1" placeholder="Amount" style="font-size: 12px;">

                            								            </td>

                            								            <td>

                            								                <div class="addDeleteButton">

                            								                    <span class="tooltips addTaxInvoiceRow1" data-placement="top" data-original-title="Add" style="cursor: pointer;">

                            								                    <i class="fa fa-plus" style="color:#000"></i></span>

                            								                </div>

                            								            </td>

                            								        </tr>

                            								    </tbody>

                                                                <tfoot>

                                                                    <tr>

                                                                        <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Sub Total</span></td>

                                                                        <td id="proforma_sub_total1" style="text-align: right;font-weight:600;"><?php echo (isset($proforma_sub_total1) && !empty($proforma_sub_total1)) ? $proforma_sub_total1 : '0.00' ?></td>

                                                                        <td></td>

                                                                        <td></td>

                                                                        <td></td>

                                                                        <td></td>

                                                                        <td></td>

                                                                    </tr> 

                                                                    <tr>

                                                                        <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">CGST Amount</span></td>

                                                                        <td id="proforma_cgst_total1" style="text-align: right;font-weight:600;"><?php echo (isset($proforma_cgst_total1) && !empty($proforma_cgst_total1)) ? $proforma_cgst_total1 : '0.00' ?></td>

                                                                        <td></td> 

                                                                        <td></td>

                                                                        <td></td>

                                                                        <td></td>

                                                                        <td></td>

                                                                    </tr>

                                                                    <tr>

                                                                        <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">SGST Amount</span></td>

                                                                        <td id="proforma_sgst_total1" style="text-align: right;font-weight:600;"><?php echo (isset($proforma_sgst_total1) && !empty($proforma_sgst_total1)) ? $proforma_sgst_total1 : '0.00' ?></td>

                                                                        <td></td>

                                                                        <td></td>

                                                                        <td></td>

                                                                        <td></td>

                                                                        <td></td>

                                                                    </tr>

                                                                    <tr>

                                                                        <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Total Amount of This Invoice</span></td>

                                                                        <td id="proforma_final1" style="text-align: right;font-weight:600;"><?php echo (isset($proforma_final1) && !empty($proforma_final1)) ? $proforma_final1 : '0.00' ?></td>

                                                                        <td></td>

                                                                        <td></td>

                                                                        <td></td>

                                                                        <td></td>

                                                                        <td></td>

                                                                    </tr>

                                                                </tfoot>

                                                            </table>

                                                            <p id="invaliderrorprod1" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>

                                                        </div>

            								        <?php } ?>

            								        <?php }else{ ?>

            								        <div id="displayProformaInvc" style="display:none;">

                                                        <table width="100%" id="proformainvcdisplay" class="table table-striped table-bordered table-hover">

                                                            <thead>

                                                            <th style="min-width: 50px;width:50px;">BOQ Sr No</th>

                                                                    <th style="min-width: 50px;width:105px;">HSN/SAC Code</th>

                                                                    <th style="min-width: 150px;width:150px;">Item Description</th>

                                                                    <th style="min-width: 30px; width: 50.2px; ">Unit</th>

                                                                    <th style="min-width: 50px;width:40px;">Qty</th>

                                                                    <th style="min-width: 80px;width:80px;">Rate</th>

                                                                    <th style="min-width: 50px;width:50px;">Taxable Amount</th>

                                                                    <th style="min-width: 50px;width:50px;">IGST%</th>

                                                                    <th style="min-width: 50px;width:50px;">IGST Amt</th>

                                                                    <!-- <th style="min-width: 50px;width:50px;">Total Amount</th> -->

                                                                    <th style="min-width: 10px;width:10px;">-</th>

                                                            </thead>

                                                            <tbody></tbody>

                                                            <tfoot>

                                                                <tr>

                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Sub Total</span></td>

                                                                    <td id="proforma_sub_total" style="text-align: right;font-weight:600;"></td>

                                                                    <td></td> 

                                                                    <td></td>

                                                                    <td></td>

                                                                 </tr>

                                                                <tr>

                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">IGST</span></td>

                                                                    <td id="proforma_total_gst" style="text-align: right;font-weight:600;"></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                </tr>

                                                                <tr>

                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Total Amount of This Invoice</span></td>

                                                                    <td id="proforma_igst_final" style="text-align: right;font-weight:600;"></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                </tr>

                                                            </tfoot>

                                                        </table>

                                                        <p id="invaliderrorprod" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>

                                                    </div>

                                                    <div id="displayperfomaInvccgst" style="display:none;">

                                                        <table width="100%" id="taxperfomadisplaysgsts" class="table table-striped table-bordered table-hover">

                                                            <thead>

                                                                <tr>

                                                                    <th style="min-width: 50px;width:50px;">BOQ Sr No</th>

                                                                    <th style="min-width: 50px;width:100px;">HSN/SAC Code</th>

                                                                    <th style="min-width: 150px;width:150px;">Item Description</th>

                                                                    <th style="min-width: 30px;width:40px;">Unit</th>

                                                                    <th style="min-width: 50px;width:40px;">Qty</th>

                                                                    <th style="min-width: 80px;width:80px;">Rate</th>

                                                                    <th style="min-width: 50px;width:100px;">Taxable Amount</th>

                                                                    <th style="min-width: 30px;width:40px;">SGST%</th>

                                                                    <th style="min-width: 50px;width:50px;">SGST Amt</th>

                                                                    <th style="min-width: 30px;width:40px;">CGST%</th>

                                                                    <th style="min-width: 50px;width:50px;">CGST Amt</th>

                                                                    <!-- <th style="min-width: 50px;width:50px;">Total Amount</th> -->

                                                                    <th style="min-width: 10px;width:10px;">-</th>

                                                                </tr>

                                                            </thead>

                                                            <tbody></tbody>

                                                            <tfoot>

                                                                <tr>

                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Sub Total</span></td>

                                                                    <td id="proforma_sub_total1" style="text-align: right;font-weight:600;"></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                </tr> 

                                                                <tr>

                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">CGST Amount</span></td>

                                                                    <td id="proforma_cgst_total1" style="text-align: right;font-weight:600;"></td>

                                                                    <td></td> 

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                </tr>

                                                                <tr>

                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">SGST Amount</span></td>

                                                                    <td id="proforma_sgst_total1" style="text-align: right;font-weight:600;"></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                </tr>

                                                                <tr>

                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Total Amount of This Invoice</span></td>

                                                                    <td id="proforma_final1" style="text-align: right;font-weight:600;"></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                </tr>

                                                            </tfoot>

                                                        </table>

                                                        <p id="invaliderrorprod1" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>

                                                    </div>

                                                <?php } ?>

            								    <?php }else{ ?>

            								        <div id="displayProformaInvc" style="display:none;">

                                                        <table width="100%" id="proformainvcdisplay" class="table table-striped table-bordered table-hover">

                                                            <thead>

                                                            <th style="min-width: 50px;width:50px;">BOQ Sr No</th>

                                                                    <th style="min-width: 50px;width:105px;">HSN/SAC Code</th>

                                                                    <th style="min-width: 150px;width:150px;">Item Description</th>

                                                                    <th style="min-width: 30px; width: 50.2px; ">Unit</th>

                                                                    <th style="min-width: 50px;width:40px;">Qty</th>

                                                                    <th style="min-width: 80px;width:80px;">Rate</th>

                                                                    <th style="min-width: 50px;width:50px;">Taxable Amount</th>

                                                                    <th style="min-width: 50px;width:50px;">IGST%</th>

                                                                    <th style="min-width: 50px;width:50px;">IGST Amt</th>

                                                                    <!-- <th style="min-width: 50px;width:50px;">Total Amount</th> -->

                                                                    <th style="min-width: 10px;width:10px;">-</th>

                                                            </thead>

                                                            <tbody></tbody>

                                                            <tfoot>

                                                                <tr>

                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Sub Total</span></td>

                                                                    <td id="proforma_sub_total" style="text-align: right;font-weight:600;"></td>

                                                                    <td></td> 

                                                                    <td></td>

                                                                    <td></td>

                                                                 </tr>

                                                                <tr>

                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">IGST</span></td>

                                                                    <td id="proforma_total_gst" style="text-align: right;font-weight:600;"></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                </tr>

                                                                <tr>

                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Total Amount of This Invoice</span></td>

                                                                    <td id="proforma_igst_final" style="text-align: right;font-weight:600;"></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                </tr>

                                                            </tfoot>

                                                        </table>

                                                        <p id="invaliderrorprod" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>

                                                    </div>

                                                    <div id="displayperfomaInvccgst" style="display:none;">

                                                        <table width="100%" id="taxperfomadisplaysgsts" class="table table-striped table-bordered table-hover">

                                                            <thead>

                                                                <tr>

                                                                    <th style="min-width: 50px;width:50px;">BOQ Sr No</th>

                                                                    <th style="min-width: 50px;width:100px;">HSN/SAC Code</th>

                                                                    <th style="min-width: 150px;width:150px;">Item Description</th>

                                                                    <th style="min-width: 30px;width:40px;">Unit</th>

                                                                    <th style="min-width: 50px;width:40px;">Qty</th>

                                                                    <th style="min-width: 80px;width:80px;">Rate</th>

                                                                    <th style="min-width: 50px;width:100px;">Taxable Amount</th>

                                                                    <th style="min-width: 30px;width:40px;">SGST%</th>

                                                                    <th style="min-width: 50px;width:50px;">SGST Amt</th>

                                                                    <th style="min-width: 30px;width:40px;">CGST%</th>

                                                                    <th style="min-width: 50px;width:50px;">CGST Amt</th>

                                                                    <!-- <th style="min-width: 50px;width:50px;">Total Amount</th> -->

                                                                    <th style="min-width: 10px;width:10px;">-</th>

                                                                </tr>

                                                            </thead>

                                                            <tbody></tbody>

                                                            <tfoot>

                                                                <tr>

                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Sub Total</span></td>

                                                                    <td id="proforma_sub_total1" style="text-align: right;font-weight:600;"></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                </tr> 

                                                                <tr>

                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">CGST Amount</span></td>

                                                                    <td id="proforma_cgst_total1" style="text-align: right;font-weight:600;"></td>

                                                                    <td></td> 

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                </tr>

                                                                <tr>

                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">SGST Amount</span></td>

                                                                    <td id="proforma_sgst_total1" style="text-align: right;font-weight:600;"></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                </tr>

                                                                <tr>

                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Total Amount of This Invoice</span></td>

                                                                    <td id="proforma_final1" style="text-align: right;font-weight:600;"></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                    <td></td>

                                                                </tr>

                                                            </tfoot>

                                                        </table>

                                                        <p id="invaliderrorprod1" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>

                                                    </div>

                                                <?php } ?>

                                        </div>

                                        <div class="form-actions right">

                                            <button type="button" class="btn btn-danger cancel clearData" title="click To Cancel"> Cancel</button>

                                            <button type="submit" class="btn green common_save" title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> <?php echo (isset($tax_invoice_data->tax_invc_id) && !empty($tax_invoice_data->tax_invc_id)) ? 'Update' : 'Save' ?></button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                    <?php }else{ ?>

                    <input type="hidden" name="project_id" id="project_id" value="0">

                    <?php } ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption font-blue">
                                        <i class="fa fa-bars font-blue"></i>
                                        <span class="caption-subject bold uppercase">Tax Invoice List</span>
                                    </div>
                                </div>

                                <div class="portlet-body">
                                    <table width="100%" id="taxInvclist" class="table table-striped table-bordered table-hover" style="">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Sr.no</th>
                                                <th scope="col" style="min-width:50px;width:50px;vertical-align: top;">Tax <br> Invoice No</th>
                                                <th scope="col" style="min-width:50px;width:50px;vertical-align: top;">BP Code</th>
                                                <th scope="col" style="min-width:100px;width:100px;vertical-align: top;">Customer <br>Name</th>
                                                <th scope="col" style="min-width:50px;width:50px;vertical-align: top;">Status</th>
                                                <th scope="col" style="min-width:130px;width:130px;vertical-align: top;">Created On</th>
                                                <th scope="col" style="min-width:50px;width:50px;vertical-align: top;">Invoice <br>Amount</th>
                                                <th scope="col" style="min-width:50px;width:50px;vertical-align: top;">Reciept <br>Amount</th>
                                                <th scope="col" style="min-width:50px;width:50px;vertical-align: top;">Non Refundables <br> Amount</th>
                                                <th scope="col" style="min-width:50px;width:50px;vertical-align: top;">Payment <br>Received</th>
                                                <th scope="col" style="min-width:50px;width:50px;vertical-align: top;">Balance <br>Payment</th>
                                                <th scope="col" style="min-width:50px;width:50px;vertical-align: top;">Invoice <br>Closure</th>
                                                <th scope="col" style="min-width:140px;width:140px;vertical-align: top;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">

    <?php $this->load->view('common/footer'); ?>

    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/global/plugins/select2/select2.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/admin/pages/scripts/components-pickers.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/additional-methods.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/lib/jquery.form.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine.js"></script>

    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine-en.js"></script>

    <script src="<?php echo base_url(); ?>js/common.js?<?php echo date('Ymd H:i:s'); ?>" type="text/javascript"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>

    <script src="<?php echo base_url(); ?>js/select2pagination.js?<?php echo date('Ymd H:i:s'); ?>"></script>

    

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script src="<?php echo base_url(); ?>js/tax-invc.js?<?php echo date('Ymd H:i:s'); ?>"></script>

    <script>

        jQuery(document).ready(function() {

            Metronic.init(); // init metronic core components

            Layout.init();

            ComponentsPickers.init();

        });

    </script>

</body>



</html>