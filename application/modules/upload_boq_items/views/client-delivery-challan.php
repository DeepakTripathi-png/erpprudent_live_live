<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Client Delivery Challan | <?php echo project_name; ?> </title>
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
        .has-error-p{
            border: 1px solid #a94442;
        }
        .has-error-d{
            border: 1px solid #a94442;
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
                                        <span class="caption-subject bold uppercase"> Add Client Delivery Challan</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form action="<?php echo (isset($delivery_challan_data->challan_id) && !empty($delivery_challan_data->challan_id)) ? 'update_client_dc_details' : 'save_client_dc_details' ?>" enctype="multipart/form-data" id="<?php echo (isset($delivery_challan_data->challan_id) && !empty($delivery_challan_data->challan_id)) ? 'update_client_dc_details' : 'save_client_dc_details' ?>"  method="post" class="horizontal-form">
                                        <input type="hidden" class="form-control" id="challan_id" name="challan_id" value="<?php echo (isset($delivery_challan_data->challan_id) && !empty($delivery_challan_data->challan_id)) ? $delivery_challan_data->challan_id : '0' ?>">
            							<div class="form-body">
                                            <div class="row">
                                                <?php if(isset($delivery_challan_data->c_type) && !empty($delivery_challan_data->c_type) && $delivery_challan_data->c_type == 'delivery_challan'){ ?>
                                                <div class="col-md-4">
            										<div class="form-groupp">
            											<label class="control-label">Challan Type <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            											<input type="hidden" class="form-control" id="c_type" name="c_type" value="delivery_challan">
            											<input type="text" class="form-control" id="c_typetxt" name="c_typetxt" value="Delivery Challan" readonly>
            										</div>
            									</div>
            									<?php }elseif(isset($delivery_challan_data->c_type) && !empty($delivery_challan_data->c_type) && $delivery_challan_data->c_type == 'delivery_challan_invoice'){ ?>
                                                <div class="col-md-4">
            										<div class="form-groupp">
            											<label class="control-label">Challan Type <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            											<input type="hidden" class="form-control" id="c_type" name="c_type" value="delivery_challan_invoice">
            											<input type="text" class="form-control" id="c_typetxt" name="c_typetxt" value="Delivery Challan Cum Invoice" readonly>
            										</div>
            									</div>
            									<?php }else{ ?>
            									<div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="">Challan Type <span class="require" aria-required="true" style="color:#a94442;">*</span></label>
                                                        <select class="form-control select2me" name="c_type" style="padding-left:0px !important;" id="c_type" required>
                                                            <option value="delivery_challan" <?php echo (isset($delivery_challan_data->c_type) && !empty($delivery_challan_data->c_type) && ($delivery_challan_data->c_type=='delivery_challan'))?'selected="selected"':'';?>>Delivery Challan</option>
                                                            <option value="delivery_challan_invoice" <?php echo (isset($delivery_challan_data->c_type) && !empty($delivery_challan_data->c_type) && ($delivery_challan_data->c_type=='delivery_challan_invoice'))?'selected="selected"':'';?>>Delivery Challan Cum Invoice</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <?php if(isset($delivery_challan_data->project_id) && !empty($delivery_challan_data->project_id)){ ?>
                                                <div class="col-md-5">
            										<div class="form-groupp">
            											<label class="control-label">Select Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            											<input type="hidden" class="form-control" id="project_id" name="project_id" value="<?php echo (isset($delivery_challan_data->project_id) && !empty($delivery_challan_data->project_id)) ? $delivery_challan_data->project_id : '' ?>">
            											<input type="text" class="form-control" id="bp_code" name="bp_code" value="<?php echo (isset($delivery_challan_data->bp_code) && !empty($delivery_challan_data->bp_code)) ? $delivery_challan_data->bp_code : '' ?> <?php echo (isset($delivery_challan_data->customer_name) && !empty($delivery_challan_data->customer_name)) ? ' ('.$delivery_challan_data->customer_name.')' : '' ?>" required readonly>
            										</div>
            									</div>
            									<?php }else{ ?>
                                                <div class="col-md-5">
            										<div class="form-groupp">
            											<label class="control-label">Select Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            											<input type="text" class="form-control allprojects" id="project_id" name="project_id" placeholder="Select Project Code" required>
            											<span id="projlaoding"></span>
            									    </div>
            									</div>
            									<?php } ?>
            									<?php if(isset($delivery_challan_items_data[0]->gst_type) && !empty($delivery_challan_items_data[0]->gst_type) && $delivery_challan_items_data[0]->gst_type == 'no'){ ?>
            									<?php }elseif(isset($delivery_challan_items_data[0]->gst_type) && !empty($delivery_challan_items_data[0]->gst_type) && $delivery_challan_items_data[0]->gst_type == 'intra-state'){ ?>
            									<div class="col-md-3">
            										<div class="form-groupp">
            											<label class="control-label">Billing Type <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            											<input type="hidden" class="form-control" id="gst_type" name="gst_type" value="cgst_sgst">
            											<input type="text" class="form-control" id="gst_type_txtx" name="gst_type_txtx" value="Intra-State" readonly>
            										</div>
            									</div>
            									<?php }elseif(isset($delivery_challan_items_data[0]->gst_type) && !empty($delivery_challan_items_data[0]->gst_type) && $delivery_challan_items_data[0]->gst_type == 'inter-state'){ ?>
            									<div class="col-md-3">
            										<div class="form-groupp">
            											<label class="control-label">Billing Type <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            											<input type="hidden" class="form-control" id="gst_type" name="gst_type" value="igst">
            											<input type="text" class="form-control" id="gst_type_txtx" name="gst_type_txtx" value="Inter-State" readonly>
            										</div>
            									</div>
            									<?php }else{ ?>
            										<div class="col-md-3"  id="bill_type_div" style="display: none;">
                                                        <div class="form-group">
                                                            <label class="">Billing Type <span class="require" aria-required="true" style="color:#a94442;">*</span></label>
                                                            <select class="form-control select2me" name="gst_type" style="padding-left:0px !important;" id="gst_type" required>
                                                                <option value="cgst_sgst" <?php echo (isset($delivery_challan_items_data[0]->gst_type) && !empty($delivery_challan_items_data[0]->gst_type) && ($delivery_challan_items_data[0]->gst_type=='intra-state'))?'selected="selected"':'';?>>Intra-State</option>
                                                                <option value="igst" <?php echo (isset($delivery_challan_items_data[0]->gst_type) && !empty($delivery_challan_items_data[0]->gst_type) && ($delivery_challan_items_data[0]->gst_type=='inter-state'))?'selected="selected"':'';?>>Inter-State</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php } ?>
            								</div>
            								<hr>
            								<?php if(isset($delivery_challan_data->c_type) && !empty($delivery_challan_data->c_type) && $delivery_challan_data->c_type == 'delivery_challan_invoice'){ ?>
            								<div class="row"><div class="col-md-12"><h3 id ="challan_name" style="text-align:center;margin: 0 0 20px 0px;font-weight: 600;font-size: 20px;">DELIVERY CHALLAN CUM INVOICE</h3></div></div>
            								<?php }else{ ?>
            								<div class="row"><div class="col-md-12"><h3 id ="challan_name" style="text-align:center;margin: 0 0 20px 0px;font-weight: 600;font-size: 20px;">DELIVERY CHALLAN</h3></div></div>
            								<?php } ?>
            								<div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="">Work Order On</label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" name="workorderon" id="workorderon" placeholder="Work Order On" value="<?php echo (isset($delivery_challan_data->workorderon) && !empty($delivery_challan_data->workorderon)) ? $delivery_challan_data->workorderon : '' ?>" readonly required="">
                                                        </div>
                                                    </div>
                                                </div>
            								    <!--<div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="">Delivery Challan No <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" name="dc_no" id="dc_no" placeholder="Delivery Challan No" value="<?php echo (isset($delivery_challan_data->dc_no) && !empty($delivery_challan_data->dc_no)) ? $delivery_challan_data->dc_no : '' ?>" required="">
                                                        </div>
                                                    </div>
                                                </div>-->
            								    <div class="col-md-3">
            										<div class="form-group">
            											<label class="">Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
            												<input type="text" name="dccdate" id="dccdate" class="form-control" readonly="" value='<?php echo (isset($delivery_challan_data->dccdate) && !empty($delivery_challan_data->dccdate)) ? $delivery_challan_data->dccdate : date('Y-m-d') ?>' placeholder="Date">		
            												<span class="input-group-btn">
            													<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            												</span>
            											</div>
            										</div> 
            									</div>
            								    <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="">Supplier's Ref <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" name="suppliers_ref" id="suppliers_ref" placeholder="Supplier's Ref" value="<?php echo (isset($delivery_challan_data->suppliers_ref) && !empty($delivery_challan_data->suppliers_ref)) ? $delivery_challan_data->suppliers_ref : '' ?>" required="">
                                                        </div>
                                                    </div>
                                                </div>
            								</div>
            								<div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="">Address <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <textarea rows="2" type="text" class="form-control" name="registered_address" id="registered_address" placeholder="Address" readonly required><?php echo (isset($delivery_challan_data->registered_address) && !empty($delivery_challan_data->registered_address)) ? $delivery_challan_data->registered_address : '' ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
            								    <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="">Buyer's Order Ref <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" name="buyer_order_ref" id="buyer_order_ref" value="<?php echo (isset($delivery_challan_data->buyer_order_ref) && !empty($delivery_challan_data->buyer_order_ref)) ? $delivery_challan_data->buyer_order_ref : '' ?>" readonly  placeholder="Buyer's Order Ref" required="">
                                                        </div>
                                                    </div>
                                                </div>
            								    <div class="col-md-3">
            										<div class="form-group">
            											<label class="">Dated <span class="require" aria-required="true" style="color:#a94442">*</span></label>
            											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
            												<input type="text" name="dcc_dated" id="dcc_dated" class="form-control" readonly="" placeholder="Dated" value="<?php echo (isset($delivery_challan_data->dcc_dated) && !empty($delivery_challan_data->dcc_dated)) ? $delivery_challan_data->dcc_dated : '' ?>">		
            												<span class="input-group-btn">
            													<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            												</span>
            											</div>
            										</div> 
            									</div>
            								    <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="">Other Reference/s' <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" name="other_ref" id="other_ref" value="<?php echo (isset($delivery_challan_data->other_ref) && !empty($delivery_challan_data->other_ref)) ? $delivery_challan_data->other_ref : '' ?>" placeholder="Other Reference/s'" required="">
                                                        </div>
                                                    </div>
                                                </div>
            								</div>
            								<div class="row">
            								    <?php if(isset($delivery_challan_data->project_id) && !empty($delivery_challan_data->project_id)){ ?>
            								        <?php if(isset($consignee_data) && !empty($consignee_data)){ ?>
            								            <div class="col-md-3">
                                                        <div class="form-group" id="consigneechange">
                                                        <label class="">Consignee <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <select class="form-control select2me" name="consignee" style="padding-left:0px !important;" id="consignee" required>
                                                            <option>--Select--</option>
                                                            <?php foreach($consignee_data as $key) { ?>
            								                <option value="<?php echo (isset($key->id) && !empty($key->id)) ? $key->id : '0' ?>" <?php echo (isset($delivery_challan_data->consignee) && !empty($delivery_challan_data->consignee) && ($delivery_challan_data->consignee==$key->id))?'selected="selected"':'';?>><?php echo (isset($key->consignee_name) && !empty($key->consignee_name)) ? $key->consignee_name : '0' ?></option>
            								                <?php } ?>
            								            </select>
            								            </div>
            								            </div>
            								        <?php }else{ ?>
            								        <div class="col-md-3">
                                                        <div class="form-group" id="consigneechange">
                                                            <label class="">Consignee <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <select class="form-control select2me" name="consignee" style="padding-left:0px !important;" id="consignee" required>
                                                            <option>--Select--</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
            								    <?php }else{ ?>
            								    <div class="col-md-3">
                                                    <div class="form-group" id="consigneechange">
                                                        <label class="">Consignee <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <select class="form-control select2me" name="consignee" style="padding-left:0px !important;" id="consignee" required>
                                                        <option>--Select--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="">GST Number<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" name="gst_number" id="gst_number" value="<?php echo (isset($delivery_challan_data->gst_number) && !empty($delivery_challan_data->gst_number)) ? $delivery_challan_data->gst_number : '' ?>" placeholder="GST Number" required="">
                                                        </div>
                                                    </div>
                                                </div>
            								    <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="">Buyer (Other than Consignee) <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" name="consignee_buyer" id="consignee_buyer" value="<?php echo (isset($delivery_challan_data->consignee_buyer) && !empty($delivery_challan_data->consignee_buyer)) ? $delivery_challan_data->consignee_buyer : '' ?>" placeholder="Buyer (Other than Consignee)" required="">
                                                        </div>
                                                    </div>
                                                </div>
            								   
            								</div>
            								<div class="row">
            								    <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="">Dispatch Document No <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" name="dispatch_document_no" id="dispatch_document_no" value="<?php echo (isset($delivery_challan_data->dispatch_document_no) && !empty($delivery_challan_data->dispatch_document_no)) ? $delivery_challan_data->dispatch_document_no : '' ?>" placeholder="Dispatch Document No" required="">
                                                        </div>
                                                    </div>
                                                </div>
            								    <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="">Destination <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" name="destination" id="destination" value="<?php echo (isset($delivery_challan_data->destination) && !empty($delivery_challan_data->destination)) ? $delivery_challan_data->destination : '' ?>" placeholder="Destination" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                    <label class="">Site Address <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <textarea rows="2" type="text" readonly  class="form-control" name="site_address" id="site_address" placeholder="Site Address" required><?php echo (isset($delivery_challan_data->site_address) && !empty($delivery_challan_data->site_address)) ? $delivery_challan_data->site_address : '' ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
            								    <div class="col-md-3">
                                                    <div class="form-group">
                                                    <label class="">Buyer Site Address <span class="require" readonly  aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <textarea rows="2" type="text" class="form-control" name="buyer_site_address" id="buyer_registered_address" placeholder="Buyer Site Address" required><?php echo (isset($delivery_challan_data->buyer_site_address) && !empty($delivery_challan_data->buyer_site_address)) ? $delivery_challan_data->buyer_site_address : '' ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
            								</div>
            								<div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="">Dispatch Through <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" name="dispatch_through" id="dispatch_through" value="<?php echo (isset($delivery_challan_data->dispatch_through) && !empty($delivery_challan_data->dispatch_through)) ? $delivery_challan_data->dispatch_through : '' ?>" placeholder="Dispatch Document No" required="">
                                                        </div>
                                                    </div>
                                                </div>
            								    <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="">Terms of Delivery <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <textarea rows="2" type="text" class="form-control" name="terms_of_delivery" id="terms_of_delivery" placeholder="Terms of Delivery" required><?php echo (isset($delivery_challan_data->terms_of_delivery) && !empty($delivery_challan_data->terms_of_delivery)) ? $delivery_challan_data->terms_of_delivery : '' ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
            								</div>
            								<?php if(isset($delivery_challan_data->c_type) && !empty($delivery_challan_data->c_type) && $delivery_challan_data->c_type == 'delivery_challan'){ ?>
            								    <div id="displayDCCDivExist">
                                                    <table width="100%" id="displayDCCTableExist" class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                            <th style="min-width: 50px;width:50px;">BOQ Sr No</th>
                                                            <th style="min-width: 50px;width:105px;">HSN/SAC Code</th>
                                                            <th style="min-width: 150px;width:150px;">Item Description</th>
                                                            <th style="min-width: 30px; width: 50.2px;">Unit</th>
                                                            <th style="min-width: 50px;width:40px;">Qty</th>
                                                            <th style="min-width: 10px;width:10px;">-</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(isset($delivery_challan_items_data) && !empty($delivery_challan_items_data)){ ?>
                                                                <?php $i=0;foreach($delivery_challan_items_data as $key){ $class = 'odd'; if($i%2==0){ $class='even'; }?>
                                                                <tr role="row" class="<?php echo $class; ?>">
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrordcc_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="boq_code[]" style="font-size: 12px;" value="<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" readonly>
                                                                        <input type="hidden" name="challan_itemid[]" value="<?php echo (isset($key->challan_itemid) && !empty($key->challan_itemid)) ? $key->challan_itemid : '0' ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrordcc_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="hsn_sac_code[]" style="font-size: 12px;" value="<?php echo (isset($key->hsn_sac_code) && !empty($key->hsn_sac_code)) ? $key->hsn_sac_code : '' ?>" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrordcc_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="item_description[]" style="font-size: 12px;" value="<?php echo (isset($key->item_description) && !empty($key->item_description)) ? $key->item_description : '' ?>" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrordcc_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="unit[]" style="font-size: 12px;" value="<?php echo (isset($key->unit) && !empty($key->unit)) ? $key->unit : '' ?>" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" class="form-control checkqtyvalid invalidqty_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?> invaliderrordcc_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="qty[]" data-id="<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>"  data-pid="<?php echo (isset($delivery_challan_data->project_id) && !empty($delivery_challan_data->project_id)) ? $delivery_challan_data->project_id : '0' ?>" data-cid="<?php echo (isset($delivery_challan_data->challan_id) && !empty($delivery_challan_data->challan_id)) ? $delivery_challan_data->challan_id : '0' ?>" style="font-size: 12px;" value="<?php echo (isset($key->qty) && !empty($key->qty)) ? $key->qty : '' ?>">
                                                                        <input type="hidden" name="rate[]" value="<?php echo (isset($key->rate) && !empty($key->rate)) ? $key->rate : '0' ?>">
                                                                        <input type="hidden" name="total_rate[]" value="<?php echo (isset($key->rate) && !empty($key->rate) && $key->qty > 0) ? $key->rate * $key->qty : '0' ?>">
                                                                    </td>
                                                                    <td>
                                                                        <div class="addDeleteButton">
                                                                            <span class="tooltips deleteDccWIRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;">
                                                                                <i class="fa fa-trash-o"></i></span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php $i++;} }  ?>
                                                            <tr role="row" class="odd">
                                                                <td>
                                                                    <input type="text" class="form-control invaliderrordcc" id="dcwi_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control invaliderrordcc" id="dcwi_hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control invaliderrordcc" id="dcwi_item_description" placeholder="Item Description" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control invaliderrordcc" id="dcwi_unit" placeholder="Unit" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="number" min="1" class="form-control invaliderrordcc" id="dcwi_qty" placeholder="Qty" style="font-size: 12px;">
                                                                    <input type="hidden" id="dcwi_rate"><input type="hidden" id="dcwi_total_rate">
                                                                </td>
                                                                <td>
                                                                    <div class="addDeleteButton">
                                                                        <span class="tooltips addDccWIRow" data-placement="top" data-original-title="Add" style="cursor: pointer;">
                                                                            <i class="fa fa-plus" style="color:#000"></i></span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <p id="invaliderrordccid" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>
                                                </div>
                                            <?php }elseif(isset($delivery_challan_data->c_type) && !empty($delivery_challan_data->c_type) && $delivery_challan_data->c_type == 'delivery_challan_invoice'
                                                    && isset($delivery_challan_items_data[0]->gst_type) && !empty($delivery_challan_items_data[0]->gst_type) && $delivery_challan_items_data[0]->gst_type == 'intra-state'){ ?>
                                                <div id="displayDCCInvccgstExist">
                                                    <table width="100%" id="displayDCCInvccgstTableExist" class="table table-striped table-bordered table-hover">
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
                                                        <?php if(isset($delivery_challan_items_data) && !empty($delivery_challan_items_data)){ ?>
                                                            <?php $i=0;
                                                                $dcwi_sub_total2 = 0;
                                                                $dcwi2_cgst_total = 0;
                                                                $dcwi2_sgst_total = 0;
                                                                $dcwi_igst_final2 = 0;
                                                                foreach($delivery_challan_items_data as $key){ $class = 'odd'; if($i%2==0){ $class='even'; }?>
                                                                <?php 
                                                                $taxable_amount = (isset($key->taxable_amount) && !empty($key->taxable_amount)) ? $key->taxable_amount : 0;
                                                                $sgst_amount = (isset($key->sgst_amount) && !empty($key->sgst_amount)) ? $key->sgst_amount : 0;
                                                                $cgst_amount = (isset($key->cgst_amount) && !empty($key->cgst_amount)) ? $key->cgst_amount : 0;
                                                                $itotal_amount = 0; 
                                                                $itotal_amount = $taxable_amount + $cgst_amount + $sgst_amount; 
                                                                $dcwi_sub_total2 += $taxable_amount;
                                                                $dcwi2_cgst_total += $cgst_amount;
                                                                $dcwi2_sgst_total += $sgst_amount;
                                                                $dcwi_igst_final2 += $itotal_amount;
                                                                ?>
                                                                <tr role="row" class="<?php echo $class; ?>">
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorintra_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="cboq_code[]" value="<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" readonly="" style="font-size: 12px;">
                                                                        <input type="hidden" name="challan_itemid_intra[]" value="<?php echo (isset($key->challan_itemid) && !empty($key->challan_itemid)) ? $key->challan_itemid : '0' ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorintra_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="chsn_sac_code[]" value="<?php echo (isset($key->hsn_sac_code) && !empty($key->hsn_sac_code)) ? $key->hsn_sac_code : '' ?>" readonly="" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorintra_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="citem_description[]" value="<?php echo (isset($key->item_description) && !empty($key->item_description)) ? $key->item_description : '' ?>" readonly="" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorintra_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="cunit[]" value="<?php echo (isset($key->unit) && !empty($key->unit)) ? $key->unit : '' ?>" readonly="" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control checkqtyvalidintra invalidintraqty_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>  invaliderrorintra_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="cqty[]" value="<?php echo (isset($key->qty) && !empty($key->qty)) ? $key->qty : '0' ?>" data-id="<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>"  data-pid="<?php echo (isset($delivery_challan_data->project_id) && !empty($delivery_challan_data->project_id)) ? $delivery_challan_data->project_id : '0' ?>" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorintra_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="crate[]" value="<?php echo (isset($key->rate) && !empty($key->rate)) ? $key->rate : '0.00' ?>" readonly="" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorintra_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="ctaxable_amount[]" value="<?php echo (isset($key->taxable_amount) && !empty($key->taxable_amount)) ? $key->taxable_amount : '0.00' ?>" readonly="" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorintra_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="sgst[]" value="<?php echo (isset($key->sgst) && !empty($key->sgst)) ? $key->sgst : '0.00' ?>" readonly="" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorintra_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="sgst_amount[]" value="<?php echo (isset($key->sgst_amount) && !empty($key->sgst_amount)) ? $key->sgst_amount : '0.00' ?>" readonly="" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorintra_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="cgst[]" value="<?php echo (isset($key->cgst) && !empty($key->cgst)) ? $key->cgst : '0.00' ?>" readonly="" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorintra_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="cgst_amount[]" value="<?php echo (isset($key->cgst_amount) && !empty($key->cgst_amount)) ? $key->cgst_amount : '0.00' ?>"  readonly=""  style="font-size: 12px;">
                                                                        <input type="hidden" name="itotal_amount[]" value="<?php echo (isset($itotal_amount) && !empty($itotal_amount)) ? $itotal_amount: 0; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <div class="addDeleteButton">
                                                                            <span class="tooltips deleteDccITIRowIntra" data-placement="top" data-original-title="Remove" style="cursor: pointer;">
                                                                                <i class="fa fa-trash-o"></i></span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php $i++;} } ?>
                                                            <tr role="row" class="odd">
                                                                <td>
                                                                    <input type="text" class="form-control invaliderrordcc2" id="dcwi2_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control invaliderrordcc2" id="dcwi2_hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control invaliderrordcc2" id="dcwi2_item_description" placeholder="Item Description" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control invaliderrordcc2" id="dcwi2_unit" placeholder="Unit" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="number" min="1" class="form-control invaliderrordcc2" id="dcwi2_qty" placeholder="Qty" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="number" min="1" class="form-control invaliderrordcc2" id="dcwi2_rate" placeholder="Rate" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="number" min="1" class="form-control invaliderrordcc2" id="dcwi2_total_rate" placeholder="Total" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="number" min="1" class="form-control invaliderrordcc2" id="dcwi2_sgst" placeholder="SGST" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="number" min="1" class="form-control invaliderrordcc2" id="dcwi2_sgst_amount" placeholder="SGST Amount" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="number" min="1" class="form-control invaliderrordcc2" id="dcwi2_cgst" placeholder="CGST" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="number" min="1" class="form-control invaliderrordcc2" id="dcwi2_cgst_amount" placeholder="CGST Amount" style="font-size: 12px;">
                                                                    <input type="hidden" id="dcwi2_itotal_amount">
                                                                </td>
                                                                <td>
                                                                    <div class="addDeleteButton">
                                                                        <span class="tooltips addDccTIRowIntra" data-placement="top" data-original-title="Add" style="cursor: pointer;">
                                                                            <i class="fa fa-plus" style="color:#000"></i></span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Sub Total</span></td>
                                                            <td id="dcwi_sub_total2" style="text-align: right;font-weight:600;"><?php echo (isset($dcwi_sub_total2) && !empty($dcwi_sub_total2)) ? $dcwi_sub_total2: 0.00; ?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr> 
                                                         <tr>
                                                            <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">CGST Amount</span></td>
                                                            <td id="dcwi2_cgst_total" style="text-align: right;font-weight:600;"><?php echo (isset($dcwi2_cgst_total) && !empty($dcwi2_cgst_total)) ? $dcwi2_cgst_total: 0.00; ?></td>
                                                            <td></td> 
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">SGST Amount</span></td>
                                                            <td id="dcwi2_sgst_total" style="text-align: right;font-weight:600;"><?php echo (isset($dcwi2_sgst_total) && !empty($dcwi2_sgst_total)) ? $dcwi2_sgst_total: 0.00; ?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Total Amount of This Invoice</span></td>
                                                            <td id="dcwi_igst_final2" style="text-align: right;font-weight:600;"><?php echo (isset($dcwi_igst_final2) && !empty($dcwi_igst_final2)) ? $dcwi_igst_final2: 0.00; ?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <p id="invaliderrordccid2" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>
                                            </div>    
            								<?php }elseif(isset($delivery_challan_data->c_type) && !empty($delivery_challan_data->c_type) && $delivery_challan_data->c_type == 'delivery_challan_invoice'
                                                    && isset($delivery_challan_items_data[0]->gst_type) && !empty($delivery_challan_items_data[0]->gst_type) && $delivery_challan_items_data[0]->gst_type == 'inter-state'){ ?>
                                                    <div id="displayDCCInvcExist">
                                                        <table width="100%" id="displayDCCInvcTableExist" class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                            <th style="min-width: 50px;width:50px;">BOQ Sr No</th>
                                                                    <th style="min-width: 50px;width:105px;">HSN/SAC Code</th>
                                                                    <th style="min-width: 150px;width:150px;">Item Description</th>
                                                                    <th style="min-width: 50px; width:50px; ">Unit</th>
                                                                    <th style="min-width: 50px;width:50px;">Qty</th>
                                                                    <th style="min-width: 60px;width:60px;">Rate</th>
                                                                    <th style="min-width: 50px;width:50px;">Taxable Amt</th>
                                                                    <th style="min-width: 50px;width:50px;">IGST%</th>
                                                                    <th style="min-width: 50px;width:50px;">IGST Amt</th>
                                                                    <th style="min-width: 5px;width:5px;">-</th>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                $dcwi_sub_total1=0;
                                                                $dcwi1_igst=0;
                                                                $dcwi_igst_final = 0;
                                                                if(isset($delivery_challan_items_data) && !empty($delivery_challan_items_data)){ ?>
                                                                <?php $i=0;foreach($delivery_challan_items_data as $key){ $class = 'odd'; if($i%2==0){ $class='even'; }?>
                                                                <?php 
                                                                $taxable_amount = (isset($key->taxable_amount) && !empty($key->taxable_amount)) ? $key->taxable_amount : 0;
                                                                $gst = (isset($key->gst) && !empty($key->gst)) ? $key->gst : 0;
                                                                $gst_amount = 0; 
                                                                $gst_amount = $taxable_amount * ($gst/100); 
                                                                $itotal_amount = 0; 
                                                                $itotal_amount = $taxable_amount + $gst_amount; 
                                                                $dcwi_sub_total1 += $taxable_amount;
                                                                $dcwi1_igst += $gst_amount;
                                                                $dcwi_igst_final += $itotal_amount;
                                                                ?>
                                                                <tr role="row" class="<?php echo $class; ?>">
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorinter_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="iboq_code[]" value="<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" readonly="" style="font-size: 12px;">
                                                                        <input type="hidden" name="challan_itemid_inter[]" value="<?php echo (isset($key->challan_itemid) && !empty($key->challan_itemid)) ? $key->challan_itemid : '0' ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorinter_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="hsn_sac_code[]" value="<?php echo (isset($key->hsn_sac_code) && !empty($key->hsn_sac_code)) ? $key->hsn_sac_code : '' ?>" readonly="" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorinter_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="item_description[]" value="<?php echo (isset($key->item_description) && !empty($key->item_description)) ? $key->item_description : '' ?>" readonly="" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorinter_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="unit[]" value="<?php echo (isset($key->unit) && !empty($key->unit)) ? $key->unit : '' ?>" readonly="" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control checkqtyvalidinter invalidinterqty_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?> invaliderrorinter_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="qty[]" value="<?php echo (isset($key->qty) && !empty($key->qty)) ? $key->qty : '0' ?>" data-id="<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>"  data-pid="<?php echo (isset($delivery_challan_data->project_id) && !empty($delivery_challan_data->project_id)) ? $delivery_challan_data->project_id : '0' ?>" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorinter_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="rate[]" value="<?php echo (isset($key->rate) && !empty($key->rate)) ? $key->rate : '0.00' ?>" readonly="" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorinter_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="itaxable_amount[]" value="<?php echo (isset($key->taxable_amount) && !empty($key->taxable_amount)) ? $key->taxable_amount : '0.00' ?>" readonly="" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorinter_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="gst[]" value="<?php echo (isset($key->gst) && !empty($key->gst)) ? $key->gst : '0.00' ?>" readonly="" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrorinter_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '' ?>" name="itotal_amount[]" value="<?php echo (isset($itotal_amount) && !empty($itotal_amount)) ? $itotal_amount : '0.00' ?>" readonly="" style="font-size: 12px;">
                                                                        <input type="hidden" class="form-control" name="gst_amount[]" value="<?php echo (isset($gst_amount) && !empty($gst_amount)) ? $gst_amount : '0.00' ?>" readonly="" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <div class="addDeleteButton">
                                                                            <span class="tooltips deleteDccITIRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;">
                                                                                <i class="fa fa-trash-o"></i></span>
                                                                        </div>
                                                                    </td>
                                                                    </tr>
                                                                <?php $i++;} }  ?>
                                                                <tr role="row" class="odd">
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrordcc1" id="dcwi1_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrordcc1" id="dcwi1_hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrordcc1" id="dcwi1_item_description" placeholder="Item Description" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderrordcc1" id="dcwi1_unit" placeholder="Unit" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" min="1" class="form-control invaliderrordcc1" id="dcwi1_qty" placeholder="Qty" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" min="1" class="form-control invaliderrordcc1" id="dcwi1_rate" placeholder="Rate" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" min="1" class="form-control invaliderrordcc1" id="dcwi1_total_rate" placeholder="Total" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" min="1" class="form-control invaliderrordcc1" id="dcwi1_gst" placeholder="GST" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" min="1" class="form-control invaliderrordcc1" id="dcwi1_itotal_amount" placeholder="Total Amount" style="font-size: 12px;" readonly="">
                                                                        <input type="hidden" id="dcwi1_gst_amount">
                                                                    </td>
                                                                    <td>
                                                                        <div class="addDeleteButton">
                                                                            <span class="tooltips addDccTIRow" data-placement="top" data-original-title="Add" style="cursor: pointer;">
                                                                                <i class="fa fa-plus" style="color:#000"></i></span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Sub Total</span></td>
                                                                    <td id="dcwi_sub_total1" style="text-align: right;font-weight:600;"><?php echo (isset($dcwi_sub_total1) && !empty($dcwi_sub_total1)) ? $dcwi_sub_total1 : '0.00' ?></td>
                                                                    <td></td> 
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">IGST</span></td>
                                                                    <td id="dcwi1_igst" style="text-align: right;font-weight:600;"><?php echo (isset($dcwi1_igst) && !empty($dcwi1_igst)) ? $dcwi1_igst : '0.00' ?></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Total Amount of This Invoice</span></td>
                                                                    <td id="dcwi_igst_final" style="text-align: right;font-weight:600;"><?php echo (isset($dcwi_igst_final) && !empty($dcwi_igst_final)) ? $dcwi_igst_final : '0.00' ?></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                        <p id="invaliderrordccid1" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>
                                                    </div>
                                              <?php }else{ ?>
            								    <div id="displayDCCDiv" style="display:none;">
                                                    <table width="100%" id="displayDCCTable" class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                            <th style="min-width: 50px;width:50px;">BOQ Sr No</th>
                                                            <th style="min-width: 50px;width:105px;">HSN/SAC Code</th>
                                                            <th style="min-width: 150px;width:150px;">Item Description</th>
                                                            <th style="min-width: 30px; width: 50.2px; ">Unit</th>
                                                            <th style="min-width: 50px;width:40px;">Qty</th>
                                                            <th style="min-width: 10px;width:10px;">-</th>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                    <p id="invaliderrordccid" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>
                                                </div>
                                            <?php } ?>
            								<div id="displayDCCInvc" style="display:none;">
                                                <table width="100%" id="displayDCCInvcTable" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                    <th style="min-width: 50px;width:50px;">BOQ Sr No</th>
                                                            <th style="min-width: 50px;width:105px;">HSN/SAC Code</th>
                                                            <th style="min-width: 150px;width:150px;">Item Description</th>
                                                            <th style="min-width: 50px; width:50px; ">Unit</th>
                                                            <th style="min-width: 50px;width:50px;">Qty</th>
                                                            <th style="min-width: 60px;width:60px;">Rate</th>
                                                            <th style="min-width: 50px;width:50px;">Taxable Amt</th>
                                                            <th style="min-width: 50px;width:50px;">IGST%</th>
                                                            <th style="min-width: 50px;width:50px;">IGST Amt</th>
                                                            <th style="min-width: 5px;width:5px;">-</th>
                                                    </thead>
                                                    <tbody></tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Sub Total</span></td>
                                                            <td id="dcwi_sub_total1" style="text-align: right;font-weight:600;"></td>
                                                            <td></td> 
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">IGST</span></td>
                                                            <td id="dcwi1_igst" style="text-align: right;font-weight:600;"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Total Amount of This Invoice</span></td>
                                                            <td id="dcwi_igst_final" style="text-align: right;font-weight:600;"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <p id="invaliderrordccid1" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>
                                            </div>
                                            <!-- //table for cgst and sgst -->
                                            <div id="displayDCCInvccgst" style="display:none;">
                                                <table width="100%" id="displayDCCInvccgstTable" class="table table-striped table-bordered table-hover">
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
                                                    <tbody></tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Sub Total</span></td>
                                                            <td id="dcwi_sub_total2" style="text-align: right;font-weight:600;"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr> 
                                                         <tr>
                                                            <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">CGST Amount</span></td>
                                                            <td id="dcwi2_cgst_total" style="text-align: right;font-weight:600;"></td>
                                                            <td></td> 
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">SGST Amount</span></td>
                                                            <td id="dcwi2_sgst_total" style="text-align: right;font-weight:600;"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="1" colspan="6" style="text-align: right;"><span style="font-weight:600;">Total Amount of This Invoice</span></td>
                                                            <td id="dcwi_igst_final2" style="text-align: right;font-weight:600;"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <p id="invaliderrordccid2" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>
                                            </div>
                                        </div>
                                        <div class="form-actions right">
                                            <button type="button" class="btn btn-danger cancel clearData" title="click To Cancel"> Cancel</button>                          
                                            <button type="submit" class="btn green common_save" title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> Save</button>
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
                                        <span class="caption-subject bold uppercase">Client Delivery Challan List</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                      <table width="100%" id="dcclist" class="table table-striped table-bordered table-hover" style="">
            							<thead>
            								<tr>
            									<th scope="col">Sr.no</th>
            									<th scope="col" style="min-with:110px;width:110px;">DC No</th>
            								    <th scope="col" style="min-with:80px;width:80px;">Challan Type</th>
            								    <th scope="col">BP Code</th>
            								    <th scope="col">Consign Name</th>
            								    <th scope="col">CreatedBy</th>
            								    <th scope="col">ApprovedBy</th>
            								    <th scope="col">Status</th>
            								    <th scope="col">CreatedOn</th>
            									<th scope="col" style="min-width:80px;width:80px;">Action</th>
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
    <script src="<?php echo base_url();?>js/client-dc.js?<?php echo date('Ymd H:i:s'); ?>" type="text/javascript"></script>
    <script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); 
        ComponentsPickers.init();
    });
</script>
</body>
</html>