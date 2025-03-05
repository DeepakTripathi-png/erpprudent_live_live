<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8"/>

    <title>BOQ Exceptional Approval | <?php echo project_name; ?> </title>

    <base href="<?php echo base_url(); ?>" >

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">

    <link href="<?php echo base_url();?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="<?php echo base_url();?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">

    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <link href="<?php echo base_url();?>assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url();?>assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url();?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url();?>assets/global/css/components-rounded.css?<?php echo date('Ymd H:i:s'); ?>" id="style_components" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>assets/global/css/plugins.css?<?php echo date('Ymd H:i:s'); ?>" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>assets/admin/layout4/css/layout.css?<?php echo date('Ymd H:i:s'); ?>" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>/assets/admin/layout4/css/light.css?<?php echo date('Ymd H:i:s'); ?>" rel="stylesheet" type="text/css"/>

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

        .dataTables_filter{

            float:right;

        }

        .has-error-d{

            border:1px solid #a94442;

        }

        table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting {

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

    <?php $this->load->view('common/header');?>

    <div class="clearfix"> </div>

    <div class="page-container">

        <?php $this->load->view('common/sidebar');?>

        <div class="page-content-wrapper">

            <div class="page-content">

                <div class="portlet-body">

                    <?php if(isset($check_permission_update) && $check_permission_update == 'Y'){ ?>

                    <div class="row">

                        <div class="col-md-12">

                            <div class="portlet light">

                                <div class="portlet-title">

                                    <div class="caption font-blue">

                                        <i class="fa fa-plus-circle font-blue"></i>

                                        <span class="caption-subject bold uppercase"> BOQ EXCEPTIONAL APPROVAL</span>

                                    </div>

                                </div>

                                <div class="portlet-body form">

                                    <form action="save_boq_exceptional_approval" enctype="multipart/form-data" id="save_boq_exceptional_approval"  method="post" class="horizontal-form">

                                        <?php if(isset($exceptional_data) && !empty($exceptional_data)){ ?>

                                        <div class="form-body">

                                            <div class="row">

                                                <div class="col-md-3">

            										<div class="form-groupp">

            											<label class="control-label">Select Type <span class="required" aria-required="true" style="color:#a94442">*</span></label>

            											<input type="hidden" class="form-control" id="billable" name="billable" value="<?php echo(isset($exceptional_data[0]->billable) && !empty($exceptional_data[0]->billable) && $exceptional_data[0]->billable == 'Y')?'Y':'N'?>">

            											<input type="text" class="form-control" id="billable_txt" name="billable_txt" value="<?php echo(isset($exceptional_data[0]->billable) && !empty($exceptional_data[0]->billable) && $exceptional_data[0]->billable == 'Y')?'Billable':'Non Billable'?>" readonly>

            										</div>

            									</div>

            								    <div class="col-md-5">

            										<div class="form-groupp">

            											<label class="control-label">Select Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>

            											<input type="hidden" class="form-control" id="exceptional_id" name="exceptional_id" value="<?php echo(isset($exceptional_data[0]->exceptional_id) && !empty($exceptional_data[0]->exceptional_id))?$exceptional_data[0]->exceptional_id:'0'?>">

            											<input type="hidden" class="form-control" id="project_id" name="project_id" value="<?php echo(isset($exceptional_data[0]->project_id) && !empty($exceptional_data[0]->project_id))?$exceptional_data[0]->project_id:'0'?>">

            											<input type="text" class="form-control" id="bp_code" name="bp_code" value="<?php echo(isset($exceptional_data[0]->bp_code) && !empty($exceptional_data[0]->bp_code))?$exceptional_data[0]->bp_code:''?><?php echo(isset($exceptional_data[0]->customer_name) && !empty($exceptional_data[0]->customer_name))?' ('.$exceptional_data[0]->customer_name.')':''?>" readonly>

            										</div>

            									</div>

            								</div>

                                            <div id="displayBoqItems" style="margin-top:15px;">

                                                <table width="100%" id="boqitmdisplay" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="min-width: 80px;width:80px;">BOQ Sr No</th>
                                                            <th style="min-width: 200px;width:200px;">Item Description</th>
                                                            <th style="min-width: 40px;width:40px;">Sche. Qty</th>
                                                            <th style="min-width: 40px;width:40px;">Dsgn. Qty</th>
                                                            <th style="min-width: 40px;width:40px;">Build Qty</th>
                                                            <th style="min-width: 40px;width:40px;">EA Qty</th>
                                                            <th style="min-width: 40px;width:40px;">Non-Sche</th>
                                                            <th style="min-width: 10px;width:10px;">-</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php if(isset($exceptional_items_data) && !empty($exceptional_items_data)){ $i=0;foreach($exceptional_items_data as $key){ ?>
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" name="boq_items_id[]" value="<?php echo(isset($key->boq_items_id) && !empty($key->boq_items_id))?$key->boq_items_id:'0'?>">
                                                                <input type="text" class="form-control invaliderror" id="boq_code<?php echo $i; ?>" name="boq_code[]" value="<?php echo(isset($key->boq_code) && !empty($key->boq_code))?$key->boq_code:'-'?>" style="font-size: 12px;" readonly="">
                                                            </td>    
                                                            <td>
                                                                <input type="text" class="form-control invaliderror" id="item_description<?php echo $i; ?>" name="item_description[]" value="<?php echo(isset($key->item_description) && !empty($key->item_description))?$key->item_description:'-'?>" style="font-size: 12px;" readonly="">
                                                            </td>    

                                                            <td>
                                                                <input type="number" class="form-control invaliderror" id="scheduled_qty<?php echo $i; ?>" name="scheduled_qty[]" value="<?php echo(isset($key->scheduled_qty) && !empty($key->scheduled_qty))?$key->scheduled_qty:'0'?>" style="font-size: 12px;" readonly="">
                                                            </td>    

                                                            <td>
                                                                <input type="number" class="form-control invaliderror" id="ea_design_qty<?php echo $i; ?>" name="ea_design_qty[]" value="<?php echo(isset($key->design_qty) && !empty($key->design_qty))?$key->design_qty:'0'?>" style="font-size: 12px;" readonly="">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control invaliderror" id="o_design_qty<?php echo $i; ?>" name="o_design_qty[]" value="<?php echo(isset($key->o_design_qty) && !empty($key->o_design_qty))?$key->o_design_qty:'0'?>" style="font-size: 12px;" readonly="">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control invaliderror" id="ea_qty<?php echo $i; ?>" name="ea_qty[]" value="<?php echo(isset($key->EA_qty) && !empty($key->EA_qty))?$key->EA_qty:'0'?>" style="font-size: 12px;" readonly="">
                                                                <input type="hidden" name="design_qty[]" value="<?php echo(isset($key->design_qty) && !empty($key->design_qty))?$key->design_qty:'0'?>">
                                                                <input type="hidden" name="o_design_qty[]" value="<?php echo(isset($key->o_design_qty) && !empty($key->o_design_qty))?$key->o_design_qty:'0'?>">
                                                                <input type="hidden" name="hsn_sac_code[]" value="<?php echo(isset($key->hsn_sac_code) && !empty($key->hsn_sac_code))?$key->hsn_sac_code:''?>">
                                                                <input type="hidden" name="unit[]" value="<?php echo(isset($key->unit) && !empty($key->unit))?$key->unit:''?>">
                                                                <input type="hidden" name="rate_basic[]" value="<?php echo(isset($key->rate_basic) && !empty($key->rate_basic))?$key->rate_basic:'0'?>">
                                                                <input type="hidden" name="gst[]" value="<?php echo(isset($key->gst) && !empty($key->gst))?$key->gst:'0'?>">
                                                                <input type="hidden" name="taxable_amount[]" value="<?php echo(isset($key->rate_basic) && !empty($key->rate_basic))?$key->EA_qty * $key->rate_basic:'0'?>">
                                                                <input type="hidden" name="gst_amount[]" value="<?php echo(isset($key->gst) && !empty($key->gst))?($key->EA_qty * $key->rate_basic) * ($key->gst/100):'0'?>">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control invaliderror" id="non_schedule<?php echo $i; ?>" name="non_schedule[]" value="<?php echo(isset($key->non_schedule) && !empty($key->non_schedule) && $key->non_schedule =='Y')?'Yes':'No'?>" style="font-size: 12px;" readonly="">
                                                            </td>
                                                            <td><div class="addDeleteButton"><span class="tooltips deleteBoqExceptnRow tr<?php echo $i; ?>" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span></div></td>
                                                        </tr>

                                                        <?php $i++;} } ?>

                                                        <tr role="row" class="odd">
                                                            <td>
                                                                <input type="hidden" id="except_boq_items_id">
                                                                <input type="text" class="form-control invaliderrorexcept" id="except_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;">
                                                            </td>

                                                            <td>
                                                                <input type="text" class="form-control invaliderrorexcept" id="except_item_description" placeholder="Item Description" style="font-size: 12px;" readonly="">
                                                            </td>

                                                            <td>
                                                                <input type="number" class="form-control invaliderrorexcept" id="except_scheduled_qty" placeholder="Sche. Qty" style="font-size: 12px;" readonly="">
                                                            </td>    

                                                            <td>
                                                                <input type="number" class="form-control invaliderrorexcept" id="except_or_design_qty" placeholder="Design Qty" style="font-size: 12px;" readonly="">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control invaliderrorexcept" id="except_ea_design_qty" placeholder="Build Qty" style="font-size: 12px;" readonly="">
                                                            </td>

                                                            <td>
                                                                <input type="number" class="form-control invaliderrorexcept" id="except_ea_qty" placeholder="EA Qty" style="font-size: 12px;">
                                                                <input type="hidden" id="except_design_qty"><input type="hidden" id="except_hsn_sac_code">
                                                                <input type="hidden" id="except_unit"><input type="hidden" id="except_rate_basic"><input type="hidden" id="except_gst">
                                                                <input type="hidden" id="except_o_design_qty">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control invaliderrorexcept" id="except_non_schedule" placeholder="Yes/No" style="font-size: 12px;" readonly="">
                                                            </td>

                                                            <td>

                                                                <div class="addDeleteButton">
                                                                    <span class="tooltips addBOQExceptionalData" data-placement="top" data-original-title="Add" style="cursor: pointer;">
                                                                        <i class="fa fa-plus" style="color:#000"></i></span>
                                                                </div>

                                                            </td>

                                                        </tr>

                                                    </tbody>

                                                </table>

                                                <p id="invaliderrorid" style="padding:0px;font-size: 12px;color:#a94442;"></p>

                                                <p id="invaliderrorexceptdiv" style="padding:0px;font-size: 12px;color:#a94442;"></p>

                                                <div class="row">

            								        <div class="col-md-3">

            								            <div class="form-group">

                                                            <label class="">Variation PO Taxable Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                <i class="fa"></i>

                                                                <input type="text" class="form-control" name="PO_taxable_amt" id="PO_taxable_amt" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Variation PO Taxable Amount" value="<?php echo(isset($exceptional_data[0]->PO_taxable_amt) && !empty($exceptional_data[0]->PO_taxable_amt))?$exceptional_data[0]->PO_taxable_amt:'0'?>" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-3">

                                                        <div class="form-group">

                                                            <label class="">GST Rate <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <select class="form-control select2me" name="gst_rate" id="gst_rate" required>

                                                                <option value="">--Select--</option>

                                                                <option value="5" <?php echo (isset($exceptional_data[0]->gst_rate) && !empty($exceptional_data[0]->gst_rate) && ($exceptional_data[0]->gst_rate=='5'))?'selected="selected"':'';?>>5%</option>

                                                                <option value="12" <?php echo (isset($exceptional_data[0]->gst_rate) && !empty($exceptional_data[0]->gst_rate) && ($exceptional_data[0]->gst_rate=='12'))?'selected="selected"':'';?>>12%</option>

                                                                <option value="18" <?php echo (isset($exceptional_data[0]->gst_rate) && !empty($exceptional_data[0]->gst_rate) && ($exceptional_data[0]->gst_rate=='18'))?'selected="selected"':'';?>>18%</option>

                                                                <option value="28" <?php echo (isset($exceptional_data[0]->gst_rate) && !empty($exceptional_data[0]->gst_rate) && ($exceptional_data[0]->gst_rate=='28'))?'selected="selected"':'';?>>28%</option>

                                                                <option value="composite" <?php echo (isset($exceptional_data[0]->gst_rate) && !empty($exceptional_data[0]->gst_rate) && ($exceptional_data[0]->gst_rate=='composite'))?'selected="selected"':'';?>>Composite</option>

                                                            </select>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-3">

                                                        <div class="form-group">

                                                            <label class="">GST Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                <i class="fa"></i>

                                                                <input type="text" class="form-control" name="gst_amount" id="gst_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="GST Amount" value="<?php echo(isset($exceptional_data[0]->gst_amount) && !empty($exceptional_data[0]->gst_amount))?$exceptional_data[0]->gst_amount:'0'?>" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-3">

                                                        <div class="form-group">

                                                            <label class="">Total Variation PO Amount <span id="dn_doc_span" class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                <i class="fa"></i>

                                                                <input type="text" class="form-control" name="po_final_amount" id="po_final_amount" placeholder="Total Variation PO Amount" value="<?php echo(isset($exceptional_data[0]->po_final_amount) && !empty($exceptional_data[0]->po_final_amount))?$exceptional_data[0]->po_final_amount:'0'?>" required>

                                                            </div>

                                                        </div>

            								        </div>

            								    </div>

            								    <div class="row">

            								        <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label class="control-label">Upload Variation PO</label><br>

                                                            <input type="file" name="po_doc" id="po_doc" class="po_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />

                                                            <span id="penalty_clause_file_error" style="font-size: 12px;color:#a94442;"></span>

                                                            <span id="dn_doc"></span>

                                                            <?php echo(isset($exceptional_data[0]->po_doc) && !empty($exceptional_data[0]->po_doc))?'<a href="'.base_url().'uploads/variation_po/'.$exceptional_data[0]->po_doc.'" download>Download</a>':''?>

                                                        </div>

                                                    </div>

            								    </div>

            								</div>

                                        </div>

                                        <?php }else{ ?> 

                                        <div class="form-body">

                                            <div class="row">

                                                <div class="col-md-3">

                                                        <div class="form-group">

                                                            <label class="">Select Type <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <select class="form-control select2me" name="billable" id="billable" required>

                                                                <option value="Y" <?php echo(isset($exceptional_data[0]->billable) && !empty($exceptional_data[0]->billable) && $exceptional_data[0]->billable == 'Y')?'selected="selected"':''?>>Billable</option>

                                                                <option value="N" <?php echo(isset($exceptional_data[0]->billable) && !empty($exceptional_data[0]->billable) && $exceptional_data[0]->billable == 'N')?'selected="selected"':''?>>Non Billable</option>

                                                            </select>

                                                        </div>

                                                </div>

                                                <div class="col-md-5">

            										<div class="form-groupp">

            											<label class="control-label">Select Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>

            											<input type="text" class="form-control allprojects" id="project_id" name="project_id" placeholder="Select Project Code" required>

            											<span id="projlaoding"></span>

            									    </div>

            									</div>

            								</div>

                                            <div id="displayBoqItems" style="display:none;">

                                                <table width="100%" id="boqitmdisplay" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="min-width: 80px;width:80px;">BOQ Sr No</th>
                                                            <th style="min-width: 200px;width:200px;">Item Description</th>
                                                            <th style="min-width: 40px;width:40px;">Sche. Qty</th>
                                                            <th style="min-width: 40px;width:40px;">Dsgn. Qty</th>
                                                            <th style="min-width: 40px;width:40px;">Build Qty</th>
                                                            <th style="min-width: 40px;width:40px;">EA Qty</th>
                                                            <th style="min-width: 40px;width:40px;">Non-Sche</th>
                                                            <th style="min-width: 10px;width:10px;">-</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <p id="invaliderrorid" style="padding:0px;font-size: 12px;color:#a94442;"></p>
                                                <p id="invaliderrorexceptdiv" style="padding:0px;font-size: 12px;color:#a94442;"></p>
                                                <div class="row">
            								        <div class="col-md-3">
            								            <div class="form-group">
                                                            <label class="">Variation PO Taxable Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="PO_taxable_amt" id="PO_taxable_amt" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Variation PO Taxable Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">GST Rate <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <select class="form-control select2me" name="gst_rate" id="gst_rate" required>
                                                                <option value="">--Select--</option>
                                                                <option value="5" <?php echo (isset($create_project_data->gst_rate) && !empty($create_project_data->gst_rate) && ($create_project_data->gst_rate=='5'))?'selected="selected"':'';?>>5%</option>
                                                                <option value="12" <?php echo (isset($create_project_data->gst_rate) && !empty($create_project_data->gst_rate) && ($create_project_data->gst_rate=='12'))?'selected="selected"':'';?>>12%</option>
                                                                <option value="18" <?php echo (isset($create_project_data->gst_rate) && !empty($create_project_data->gst_rate) && ($create_project_data->gst_rate=='18'))?'selected="selected"':'';?>>18%</option>
                                                                <option value="28" <?php echo (isset($create_project_data->gst_rate) && !empty($create_project_data->gst_rate) && ($create_project_data->gst_rate=='28'))?'selected="selected"':'';?>>28%</option>
                                                                <option value="composite" <?php echo (isset($create_project_data->gst_rate) && !empty($create_project_data->gst_rate) && ($create_project_data->gst_rate=='composite'))?'selected="selected"':'';?>>Composite</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">GST Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="gst_amount" id="gst_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="GST Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Total Variation PO Amount <span id="dn_doc_span" class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="po_final_amount" id="po_final_amount" placeholder="Total Variation PO Amount" required>
                                                            </div>
                                                        </div>
            								        </div>
            								    </div>

            								    <div class="row">

            								        <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label class="control-label">Upload Variation PO</label><br>

                                                            <input type="file" name="po_doc" id="po_doc" class="po_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />

                                                            <span id="penalty_clause_file_error" style="font-size: 12px;color:#a94442;"></span>

                                                            <span id="dn_doc"></span>

                                                        </div>

                                                    </div>

            								    </div>

            								</div>

                                        </div>

                                        <?php } ?>

                                        <div class="form-actions right">

                                            <button type="button" class="btn btn-danger cancel" onclick="location.href = '<?php echo base_url();?>boq-exceptional-approval';" title="click To Cancel"> Cancel</button>                          

                                            <button type="submit" class="btn green common_save" title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> Send to Approval</button>

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

                                        <span class="caption-subject bold uppercase">BOQ EXCEPTIONAL APPROVAL List</span>

                                    </div>

                                </div>

                                <div class="portlet-body">

                                      <table width="100%" id="boqexceptlist" class="table table-striped table-bordered table-hover">

            							<thead>

            								<tr>

            									<th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sr.no</th>

            									<th scope="col" style="min-width:100px;width:100px;vertical-align: top;">EA No.</th>

                                                <th scope="col" style="min-width:100px;width:100px;vertical-align: top;">Events</th>

            									<th scope="col" style="min-width:30px;width:30px;vertical-align: top;">EA Type</th>

            								    <th scope="col" style="min-width:100px;width:100px;vertical-align: top;">BP Code</th>

            									<th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Amount</th>

            									<th scope="col" style="min-width:30px;width:30px;vertical-align: top;">CreatedBy</th>

            									<th scope="col" style="min-width:30px;width:30px;vertical-align: top;">ApprovedBy</th>

            									<th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Status</th>

            									<th scope="col" style="min-width:30px;width:30px;vertical-align: top;">CreatedOn</th>

            									<th scope="col" style="min-width:80px;width:80px;vertical-align: top;">Action</th>

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

    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">

    <?php $this->load->view('common/footer');?>

    <script src="<?php echo base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/scripts/metronic.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/select2/select2.min.js" type="text/javascript" ></script>

    <script src="<?php echo base_url();?>assets/admin/pages/scripts/components-pickers.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript" ></script>

    <script src="<?php echo base_url()?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript" ></script>

    <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>

    <script src="<?php echo base_url();?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/lib/jquery.form.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine.js"></script>

    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine-en.js"></script>

    <script src="<?php echo base_url();?>js/common.js?<?php echo date('Ymd H:i:s'); ?>" type="text/javascript"></script>

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

    <script src="<?php echo base_url(); ?>js/boq-except.js?<?php echo date('Ymd H:i:s'); ?>"></script>

    <script>

    jQuery(document).ready(function() {

        Metronic.init(); // init metronic core components

        Layout.init(); 

        ComponentsPickers.init();

    });

    </script>

</body>

</html>