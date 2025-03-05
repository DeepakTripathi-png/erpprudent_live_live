<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Project Closure | <?php echo project_name; ?> </title>
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
    <link href="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/css/components-rounded.css?<?php echo date('Y-m-d H:i:s'); ?>" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/css/plugins.css?<?php echo date('Y-m-d H:i:s'); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/admin/layout4/css/layout.css?<?php echo date('Y-m-d H:i:s'); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>/assets/admin/layout4/css/light.css?<?php echo date('Y-m-d H:i:s'); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/site/css/validationEngine.jquery.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/createp.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet">
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo ">
    <?php $this->load->view('common/header');?>
    <div class="clearfix"> </div>
    <div class="page-container">
        <?php $this->load->view('common/sidebar');?>
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption font-blue">
                                    <i class="fa fa-plus-circle font-blue"></i>
                                    <span class="caption-subject bold uppercase"> <?php echo(isset($bp_code) && !empty($bp_code))?'(#'.$bp_code.')':''?> Project Closure</span>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <form action="save_project_closure" enctype="multipart/form-data" id="save_project_closure" method="post" class="horizontal-form">
                                    <div class="form-body">
                                        <div class="alert alert-danger display-none" id="error_alert" style="display:none;background-color: #F3565D;border-color: #f13e64;color: white;">
                                            <button class="close" data-dismiss="alert"></button>Please enter required (*) fields.
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Project Details </h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="">Customer Name <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo(isset($create_project_data->customer_name) && !empty($create_project_data->customer_name))?$create_project_data->customer_name:''?>" placeholder="Customer Name" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="">BP Code <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="bp_code" id="bp_code" value="<?php echo(isset($create_project_data->bp_code) && !empty($create_project_data->bp_code))?$create_project_data->bp_code:''?>" placeholder="BP Code" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">PO/LOI No <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control " name="po_loi_no" id="po_loi_no" value="<?php echo(isset($create_project_data->po_loi_no) && !empty($create_project_data->po_loi_no))?$create_project_data->po_loi_no:''?>" placeholder="PO/LOI No" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
            											<div class="form-group">
            												<label class="">PO/LOI Received Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            												<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
            													<input type="text" name="po_loi_received_data" id="po_loi_received_data" class="form-control" readonly="" placeholder="Select PO/LOI Received Date" value="<?php echo(isset($create_project_data->po_loi_received_data) && !empty($create_project_data->po_loi_received_data))?$create_project_data->po_loi_received_data:''?>">		
            													<span class="input-group-btn">
            														<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            													</span>
            												</div>
            											</div> 
            										</div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="">Name of Work <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <textarea rows="2" type="text" class="form-control" name="name_of_work" id="name_of_work" placeholder="Name of Work" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Executive Person <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <select class="form-control select2me" name="work_order_on" id="work_order_on" required>
                                                                <option value="">--Select--</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Sales Person <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <select class="form-control select2me" name="sales_person" id="sales_person" required>
                                                                <option value="">--Select--</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Customer Contact Person <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <input type="text" class="form-control " name="po_loi_no" id="po_loi_no"  placeholder="Customer Contact Person" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Original (Schedule A) <br>PO Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <input type="text" class="form-control " name="po_loi_no" id="po_loi_no"  placeholder="Original (Schedule A) PO Amount" value="309877" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Final (Schedule A) <br>PO Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <input type="text" class="form-control " name="po_loi_no" id="po_loi_no"  placeholder="Final (Schedule A) PO Amount" value="309877" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Variation PO Received <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="dflx">
                                                            <input type="radio" name="variation_po_received" id="variation_po_received_yes" value="Yes" required><span style="padding: 0 10px 0px 5px;">Yes</span>
                                                            <input type="radio" name="variation_po_received" id="variation_po_received_no" value="No"  checked required><span style="padding: 0 10px 0px 5px;">No</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Variation (Schedule B) <br> PO Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <input type="text" class="form-control " name="po_loi_no" id="po_loi_no"  placeholder="Variation (Schedule B) PO Amount" value="309877" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Variation Item (Schedule B) Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <input type="text" class="form-control " name="po_loi_no" id="po_loi_no"  placeholder="Variation Item (Schedule B) Amount" value="309877" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">NS Item (Schedule C) Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <input type="text" class="form-control " name="po_loi_no" id="po_loi_no"  placeholder="NS Item (Schedule C) Amount" value="309877" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Project Final Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <input type="text" class="form-control " name="po_loi_no" id="po_loi_no"  placeholder="Project Final Amount" value="309877" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Exceptional Approval Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <input type="text" class="form-control " name="po_loi_no" id="po_loi_no"  placeholder="Exceptional Approval Amount" value="309877" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Exceptional Approval Count <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <input type="text" class="form-control " name="po_loi_no" id="po_loi_no"  placeholder="Exceptional Approval Count" value="30" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Payment Advice Received <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="dflx">
                                                            <input type="radio" name="payment_advice_received" id="payment_advice_received_yes" value="Yes" required><span style="padding: 0 10px 0px 5px;">Yes</span>
                                                            <input type="radio" name="payment_advice_received" id="payment_advice_received_no" value="No"  checked required><span style="padding: 0 10px 0px 5px;">No</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
            											<div class="form-group">
            												<label class="">Bank Guarantee Valid Upto <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            												<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
            													<input type="text" name="bank_guarantee_date" id="bank_guarantee_date" class="form-control" readonly="" placeholder="Select Bank Guarantee Valid Upto" value="<?php echo(isset($create_project_data->po_loi_received_data) && !empty($create_project_data->po_loi_received_data))?$create_project_data->po_loi_received_data:''?>">		
            													<span class="input-group-btn">
            														<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            													</span>
            												</div>
            											</div> 
            										</div>
                                                    <div class="col-md-3">
            											<div class="form-group">
            												<label class="">Commencement Date (Date of 1st BOQ Upload) <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            												<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
            													<input type="text" name="bank_guarantee_date" id="bank_guarantee_date" class="form-control" readonly="" placeholder="Select Commencement Date" value="<?php echo(isset($create_project_data->po_loi_received_data) && !empty($create_project_data->po_loi_received_data))?$create_project_data->po_loi_received_data:''?>">		
            													<span class="input-group-btn">
            														<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            													</span>
            												</div>
            											</div> 
            										</div>
                                                    <div class="col-md-3">
            											<div class="form-group">
            												<label class="">Completion Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            												<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
            													<input type="text" name="bank_guarantee_date" id="bank_guarantee_date" class="form-control" readonly="" placeholder="Select Completion Date" value="<?php echo date('d-m-Y'); ?>">		
            													<span class="input-group-btn">
            														<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            													</span>
            												</div>
            											</div> 
            										</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
            											<div class="form-group">
            												<label class="">Actual Completion Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            												<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
            													<input type="text" name="completion_date" id="completion_date" class="form-control" readonly="" placeholder="Select Actual Completion Date" value="<?php echo(isset($create_project_data->po_loi_received_data) && !empty($create_project_data->po_loi_received_data))?$create_project_data->po_loi_received_data:''?>">		
            													<span class="input-group-btn">
            														<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            													</span>
            												</div>
            											</div> 
            										</div>
                                                    <div class="col-md-3">
            											<div class="form-group">
            												<label class="">Actual Completion Period <br> as per OEF <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            												<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
            													<input type="text" name="completion_date" id="completion_date" class="form-control" readonly="" placeholder="Select Actual Completion Period as per OEF" value="<?php echo(isset($create_project_data->po_loi_received_data) && !empty($create_project_data->po_loi_received_data))?$create_project_data->po_loi_received_data:''?>">		
            													<span class="input-group-btn">
            														<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            													</span>
            												</div>
            											</div> 
            										</div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Actual Completion Period <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <input type="text" class="form-control " name="po_loi_no" id="po_loi_no"  placeholder="Actual Completion Period">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Completion Certificate <br>Received <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="dflx">
                                                            <input type="radio" name="completion_cerf_received" id="completion_cerf_received_yes" class="completion_cerf_received" value="Yes" required><span style="padding: 0 10px 0px 5px;">Yes</span>
                                                            <input type="radio" name="completion_cerf_received" id="completion_cerf_received_no" class="completion_cerf_received" value="No"  checked required><span style="padding: 0 10px 0px 5px;">No</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="completioncerfreceivedyes">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">PBG Returned to Bank <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="dflx">
                                                            <input type="radio" name="pbg_returned_bank" id="pbg_returned_bank_yes" class="pbg_returned_bank" value="Yes" required><span style="padding: 0 10px 0px 5px;">Yes</span>
                                                            <input type="radio" name="pbg_returned_bank" id="pbg_returned_bank_no" class="pbg_returned_bank" value="No"  checked required><span style="padding: 0 10px 0px 5px;">No</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
            											<div class="form-group">
            												<label class="">PBG Amount Confirmation <br> Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            												<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
            													<input type="text" name="completion_date" id="completion_date" class="form-control" readonly="" placeholder="Select PBG Amount Confirmation Date" value="<?php echo(isset($create_project_data->po_loi_received_data) && !empty($create_project_data->po_loi_received_data))?$create_project_data->po_loi_received_data:''?>">		
            													<span class="input-group-btn">
            														<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            													</span>
            												</div>
            											</div> 
            										</div>
            										<div class="col-md-3">
                                                        <div class="form-group">
                                                        <label>Upload PBG Confirmation Document <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <input type="file" name="emd_doc" id="emd_doc" class="emd_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">SD BG Deposited to Our <br> Account <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="dflx">
                                                            <input type="radio" name="sdbg_deposite_our_acc_yes" id="sdbg_deposite_our_acc_yes" class="sdbg_deposite_our_acc_yes" value="Yes" required><span style="padding: 0 10px 0px 5px;">Yes</span>
                                                            <input type="radio" name="sdbg_deposite_our_acc_yes" id="sdbg_deposite_our_acc_no" class="sdbg_deposite_our_acc_yes" value="No"  checked required><span style="padding: 0 10px 0px 5px;">No</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
            											<div class="form-group">
            												<label class="">SD BG Confirmation Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            												<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
            													<input type="text" name="completion_date" id="completion_date" class="form-control" readonly="" placeholder="Select SD BG Confirmation Date" value="<?php echo(isset($create_project_data->po_loi_received_data) && !empty($create_project_data->po_loi_received_data))?$create_project_data->po_loi_received_data:''?>">		
            													<span class="input-group-btn">
            														<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            													</span>
            												</div>
            											</div> 
            										</div>
            										<div class="col-md-3">
                                                        <div class="form-group">
                                                        <label>Upload SD BG Confirmation Document <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <input type="file" name="emd_doc" id="emd_doc" class="emd_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />
                                                        </div>
                                                    </div>
                                                
            										
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Project Summary</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row"><div class="col-md-12"><label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">EMD</label></div></div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Amount <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="EMD Amount" value="302981" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Mode of Payment <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" placeholder="Mode of Payment" value="Bank Transfer" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
            											<div class="form-group">
            												<label class="">Due Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            												<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
            													<input type="text" name="completion_date" id="completion_date" class="form-control" readonly="" placeholder="Select Due Date" value="<?php echo date('d-m-Y'); ?>">		
            													<span class="input-group-btn">
            														<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            													</span>
            												</div>
            											</div> 
            										</div>
            										<div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Remark <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <textarea type="text" class="form-control" name="emd_amount" id="emd_amount"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row"><div class="col-md-12"><label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">ASD</label></div></div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Amount <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="EMD Amount" value="302981" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Mode of Payment <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" placeholder="Mode of Payment" value="Bank Transfer" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
            											<div class="form-group">
            												<label class="">Due Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            												<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
            													<input type="text" name="completion_date" id="completion_date" class="form-control" readonly="" placeholder="Select Due Date" value="<?php echo date('d-m-Y'); ?>">		
            													<span class="input-group-btn">
            														<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            													</span>
            												</div>
            											</div> 
            										</div>
            										<div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Remark <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <textarea type="text" class="form-control" name="emd_amount" id="emd_amount"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row"><div class="col-md-12"><label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">SD Retention</label></div></div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Amount <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="EMD Amount" value="302981" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Mode of Payment <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" placeholder="Mode of Payment" value="Bank Transfer" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
            											<div class="form-group">
            												<label class="">Due Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            												<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
            													<input type="text" name="completion_date" id="completion_date" class="form-control" readonly="" placeholder="Select Due Date" value="<?php echo date('d-m-Y'); ?>">		
            													<span class="input-group-btn">
            														<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            													</span>
            												</div>
            											</div> 
            										</div>
            										<div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Remark <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <textarea type="text" class="form-control" name="emd_amount" id="emd_amount"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row"><div class="col-md-12"><label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">Invoice/s</label></div></div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Invoice Amount <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Invoice Amount" value="302981" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">SD Amount <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="SD Amount" value="302981" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">IT-TDS Amount <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="IT-TDS Amount" value="302981" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">GTDS Amount <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="GTDS Amount" value="302981" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">GST Recoverable Amount <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="GST Recoverable Amount" value="302981" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Withheld Amount <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Withheld Amount" value="302981" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Mode of Payment <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" placeholder="Mode of Payment" value="Bank Transfer" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Payment Advice Received <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" placeholder="Payment Advice Received" value="No" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
            											<div class="form-group">
            												<label class="">Due On <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            												<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
            													<input type="text" name="completion_date" id="completion_date" class="form-control" readonly="" placeholder="Select Due On" value="<?php echo date('d-m-Y'); ?>">		
            													<span class="input-group-btn">
            														<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            													</span>
            												</div>
            											</div> 
            										</div>
            										<div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Remark <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <textarea type="text" class="form-control" name="emd_amount" id="emd_amount"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Schedule A</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">Schedule A Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="Schedule A Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">SD Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="SD Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">IT-TDS Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="IT-TDS Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">TDS-SGST Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="TDS-SGST Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">TDS-CGST Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="TDS-CGST Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">TDS-IGST Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="TDS-IGST Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">GST Recoverable Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="GST Recoverable Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">Withheld Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="Withheld Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">From</label>
                                                            <select class="form-control select2me" name="sales_person" id="sales_person" required>
                                                            <option value="">--Select--</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
            											<div class="form-group">
            												<label class="">Due On</label>
            												<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
            													<input type="text" name="due_on_date" id="due_on_date" class="form-control" readonly="" placeholder="Select Due On Date" value="<?php echo(isset($create_project_data->po_loi_received_data) && !empty($create_project_data->po_loi_received_data))?$create_project_data->po_loi_received_data:''?>">		
            													<span class="input-group-btn">
            														<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            													</span>
            												</div>
            											</div> 
            										</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Schedule B</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">Schedule B Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="Schedule B Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">SD Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="SD Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">IT-TDS Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="IT-TDS Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">TDS-SGST Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="TDS-SGST Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">TDS-CGST Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="TDS-CGST Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">TDS-IGST Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="TDS-IGST Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">GST Recoverable Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="GST Recoverable Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">Withheld Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="Withheld Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">From</label>
                                                            <select class="form-control select2me" name="sales_person" id="sales_person" required>
                                                            <option value="">--Select--</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
            											<div class="form-group">
            												<label class="">Due On</label>
            												<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
            													<input type="text" name="due_on_date" id="due_on_date" class="form-control" readonly="" placeholder="Select Due On Date" value="<?php echo(isset($create_project_data->po_loi_received_data) && !empty($create_project_data->po_loi_received_data))?$create_project_data->po_loi_received_data:''?>">		
            													<span class="input-group-btn">
            														<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            													</span>
            												</div>
            											</div> 
            										</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Schedule C</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">Schedule C Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="Schedule C Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">SD Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="SD Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">IT-TDS Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="IT-TDS Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">TDS-SGST Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="TDS-SGST Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">TDS-CGST Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="TDS-CGST Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">TDS-IGST Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="TDS-IGST Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">GST Recoverable Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="GST Recoverable Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">Withheld Amount</label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control" name="emd_amount" id="emd_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($create_project_data->taxable_amount) && !empty($create_project_data->taxable_amount))?$create_project_data->taxable_amount:''?>" placeholder="Withheld Amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="">From</label>
                                                            <select class="form-control select2me" name="sales_person" id="sales_person" required>
                                                            <option value="">--Select--</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
            											<div class="form-group">
            												<label class="">Due On</label>
            												<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
            													<input type="text" name="due_on_date" id="due_on_date" class="form-control" readonly="" placeholder="Select Due On Date" value="<?php echo(isset($create_project_data->po_loi_received_data) && !empty($create_project_data->po_loi_received_data))?$create_project_data->po_loi_received_data:''?>">		
            													<span class="input-group-btn">
            														<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
            													</span>
            												</div>
            											</div> 
            										</div>
                                                </div>
                                            </div>
                                        </div>-->
                                    </div>
                                    <div class="form-actions right">
                                        <a href="<?php echo base_url();?>create-project-list" class="btn blue" style="float: left;">Back</a>
                                        <button type="button" class="btn btn-danger cancel clearData" title="click To Cancel"> Cancel</button>                          
                                        <button type="submit" class="btn green pssave" title="click To Save" rel="<?php echo(isset($create_project_data->create_project_id) && !empty($create_project_data->create_project_id))?$create_project_data->create_project_id:''?>"><i class="fa fa-dot-circle-o"></i> <?php if(isset($create_project_data->create_project_id) && !empty($create_project_data->create_project_id)) {echo 'Update';} else { echo 'Save'; }?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script src="<?php echo base_url();?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript" ></script>
    <script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js" type="text/javascript" ></script>
    <script src="<?php echo base_url();?>assets/global/plugins/datatables/table-advanced.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/lib/jquery.form.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine.js"></script>
    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine-en.js"></script>
    <script src="<?php echo base_url();?>js/common.js?<?php echo date('Y-m-d H:i:s'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/addproject.js?<?php echo date('Y-m-d H:i:s'); ?>" type="text/javascript"></script>
    <script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); 
        ComponentsPickers.init();
        TableAdvanced.init();
    });
    </script>
</body>
</html>