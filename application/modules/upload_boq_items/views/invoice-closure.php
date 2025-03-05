<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Invoice Closure | <?php echo project_name; ?> </title>
    <base href="<?php echo base_url();?>">
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
    <link href="<?php echo base_url();?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/css/components-rounded.css?<?php echo date('Y-m-d H:i:s');?>" id="style_components" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/admin/layout4/css/layout.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>/assets/admin/layout4/css/light.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/site/css/validationEngine.jquery.css" rel="stylesheet">
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo "> 
    <?php $this->load->view('common/header');?> 
    <div class="clearfix"> </div>
    <div class="page-container"> 
        <?php $this->load->view('common/sidebar');?> 
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption font-blue"> <i class="fa fa-plus-circle font-blue"></i> <span class="caption-subject bold uppercase"><?php if(isset($tax_invc_no) && !empty($tax_invc_no)){ echo '(#'.$tax_invc_no.')'; } ?> Invoice Closure</span> </div>
                                </div>
                                <div class="portlet-body form">
                                    <form action="save_invoice_closure" id="save_invoice_closure" class="horizontal-form" method="post" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title"> Statutory Deductions </h4>
                                            </div>
                                            <input type="hidden" name="tax_invc_id" value="<?php echo (isset($tax_invc_id) && !empty($tax_invc_id)) ? $tax_invc_id : '0' ?>">
                                            <div class="panel-body">
                                                <div class="row"><div class="col-md-12"><label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">GTDS</label></div></div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>GTDS Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                 <i class="fa"></i>
                                                                 <input type="text" class="form-control " name="gtds_amount" id="gtds_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="GTDS Amount" value="<?php echo (isset($gtds_amount) && !empty($gtds_amount)) ? $gtds_amount : '0.00' ?>" max="<?php echo (isset($gtds_amount) && !empty($gtds_amount)) ? $gtds_amount : '0.00' ?>" min="<?php echo (isset($gtds_amount) && !empty($gtds_amount)) ? $gtds_amount : '0.00' ?>" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                										<div class="form-group">
                											<label class="">Confirmation Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                												<input type="text" name="gtds_confirm_date" id="gtds_confirm_date" class="form-control" readonly="" placeholder="Confirmation Date" value="<?php echo (isset($tax_invc_data->gtds_confirm_date) && !empty($tax_invc_data->gtds_confirm_date) && $tax_invc_data->gtds_confirm_date!='0000-00-00') ? date('d-m-Y',strtotime($tax_invc_data->gtds_confirm_date)) : '' ?>">		
                												<span class="input-group-btn">
                													<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                												</span>
                											</div>
                										</div> 
                									</div>
                                                    <div class="col-md-3">
                										<div class="form-group">
                											<label class="">Return Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                												<input type="text" name="gtds_return_date" id="gtds_return_date" class="form-control" readonly="" placeholder="Return Date" value="<?php echo (isset($tax_invc_data->gtds_return_date) && !empty($tax_invc_data->gtds_return_date) && $tax_invc_data->gtds_return_date!='0000-00-00') ? date('d-m-Y',strtotime($tax_invc_data->gtds_return_date)) : '' ?>">		
                												<span class="input-group-btn">
                													<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                												</span>
                											</div>
                										</div> 
                									</div>
                									<div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Upload Document <?php echo (isset($tax_invc_data->gtds_doc) && !empty($tax_invc_data->gtds_doc)) ? '': '<span class="require" aria-required="true" style="color:#a94442">*</span>' ?></label><br>
                                                            <input type="file" name="gtds_doc" id="gtds_doc" class="gtds_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" <?php echo (isset($tax_invc_data->gtds_doc) && !empty($tax_invc_data->gtds_doc)) ? '': 'required' ?>>
                                                            <span id="gtds_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                            <?php if(isset($tax_invc_data->gtds_doc) && !empty($tax_invc_data->gtds_doc)){ ?>
                                                            <a href="<?php echo base_url();?>uploads/invoice_closure/<?php echo $tax_invc_data->gtds_doc; ?>" download>Download</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row"><div class="col-md-12"><label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">TDS</label></div></div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>TDS Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                 <i class="fa"></i>
                                                                 <input type="text" class="form-control " name="it_tds_amount" id="it_tds_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="TDS Amount" value="<?php echo (isset($it_tds_amount) && !empty($it_tds_amount)) ? $it_tds_amount : '0.00' ?>" max="<?php echo (isset($it_tds_amount) && !empty($it_tds_amount)) ? $it_tds_amount : '0.00' ?>" min="<?php echo (isset($it_tds_amount) && !empty($it_tds_amount)) ? $it_tds_amount : '0.00' ?>" required readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                										<div class="form-group">
                											<label class="">26AS Confirmation Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                												<input type="text" name="it_tds_confirm_date" id="it_tds_confirm_date" class="form-control" readonly="" placeholder="Confirmation Date" value="<?php echo (isset($tax_invc_data->it_tds_confirm_date) && !empty($tax_invc_data->it_tds_confirm_date) && $tax_invc_data->it_tds_confirm_date!='0000-00-00') ? date('d-m-Y',strtotime($tax_invc_data->it_tds_confirm_date)) : '' ?>">		
                												<span class="input-group-btn">
                													<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                												</span>
                											</div>
                										</div> 
                									</div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Upload Document <?php echo (isset($tax_invc_data->it_tds_doc) && !empty($tax_invc_data->it_tds_doc)) ? '': '<span class="require" aria-required="true" style="color:#a94442">*</span>' ?></label><br>
                                                            <input type="file" name="it_tds_doc" id="it_tds_doc" class="it_tds_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" <?php echo (isset($tax_invc_data->it_tds_doc) && !empty($tax_invc_data->it_tds_doc)) ? '': 'required' ?>>
                                                            <span id="it_tds_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                            <?php if(isset($tax_invc_data->it_tds_doc) && !empty($tax_invc_data->it_tds_doc)){ ?>
                                                            <a href="<?php echo base_url();?>uploads/invoice_closure/<?php echo $tax_invc_data->it_tds_doc; ?>" download>Download</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row"><div class="col-md-12"><label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">Any Other Deduction</label></div></div>
                                                <?php if(isset($other_tax_data) && !empty($other_tax_data)){ ?>
                                                      <?php $i=0;foreach($other_tax_data as $key){ ?>
                                                        <?php if($i == 0){ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Tax Deduction Description</label>
                                                                    <div class="input-icon right">
                                                                         <i class="fa"></i>
                                                                         <input type="text" class="form-control " name="tax_deduction_desc[]" id="tax_deduction_desc<?php echo $i; ?>" value="<?php echo (isset($key->tax_deduction_desc) && !empty($key->tax_deduction_desc)) ? $key->tax_deduction_desc : '-' ?>" readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Tax Deduction Amount</label>
                                                                    <div class="input-icon right">
                                                                         <i class="fa"></i>
                                                                        <input type="text" class="form-control" id="tax_deduction_amt<?php echo $i; ?>" name="tax_deduction_amt[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($key->tax_deduction_amt) && !empty($key->tax_deduction_amt)) ? $key->tax_deduction_amt : '0.00' ?>" readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }else{ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-icon right">
                                                                         <i class="fa"></i>
                                                                         <input type="text" class="form-control " name="tax_deduction_desc[]" id="tax_deduction_desc<?php echo $i; ?>" value="<?php echo (isset($key->tax_deduction_desc) && !empty($key->tax_deduction_desc)) ? $key->tax_deduction_desc : '-' ?>" readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-icon right">
                                                                         <i class="fa"></i>
                                                                        <input type="text" class="form-control" id="tax_deduction_amt<?php echo $i; ?>" name="tax_deduction_amt[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($key->tax_deduction_amt) && !empty($key->tax_deduction_amt)) ? $key->tax_deduction_amt : '0.00' ?>" max="<?php echo (isset($key->tax_deduction_amt) && !empty($key->tax_deduction_amt)) ? $key->tax_deduction_amt : '0.00' ?>" min="<?php echo (isset($key->tax_deduction_amt) && !empty($key->tax_deduction_amt)) ? $key->tax_deduction_amt : '0.00' ?>" readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } $i++;} ?> 
                                                        <div class="row">
                                                            <div class="col-md-3">
                        										<div class="form-group">
                        											<label class="">Confirmation Date</label>
                        											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                        												<input type="text" name="other_tds_confirm_date" id="other_tds_confirm_date" class="form-control" readonly="" placeholder="Confirmation Date" value="<?php echo (isset($tax_invc_data->other_tds_confirm_date) && !empty($tax_invc_data->other_tds_confirm_date) && $tax_invc_data->other_tds_confirm_date!='0000-00-00') ? date('d-m-Y',strtotime($tax_invc_data->other_tds_confirm_date)) : '' ?>">		
                        												<span class="input-group-btn">
                        													<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                        												</span>
                        											</div>
                        										</div> 
                        									</div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Upload Document</label><br>
                                                                    <input type="file" name="other_tds_doc" id="other_tds_doc" class="other_tds_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                                                                    <span id="other_tds_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                                    <?php if(isset($tax_invc_data->other_tds_doc) && !empty($tax_invc_data->other_tds_doc)){ ?>
                                                                    <a href="<?php echo base_url();?>uploads/invoice_closure/<?php echo $tax_invc_data->other_tds_doc; ?>" download>Download</a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }else{ ?>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Amount</label>
                                                                    <div class="input-icon right">
                                                                         <i class="fa"></i>
                                                                        <input type="text" class="form-control" id="tax_deduction_amt" name="tax_deduction_amt" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="0.00" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                        										<div class="form-group">
                        											<label class="">Confirmation Date</label>
                        											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                        												<input type="text" name="other_tds_confirm_date" id="other_tds_confirm_date" class="form-control" readonly="" placeholder="Confirmation Date" value="<?php echo (isset($tax_invc_data->other_tds_confirm_date) && !empty($tax_invc_data->other_tds_confirm_date) && $tax_invc_data->other_tds_confirm_date!='0000-00-00') ? date('d-m-Y',strtotime($tax_invc_data->other_tds_confirm_date)) : '' ?>">		
                        												<span class="input-group-btn">
                        													<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                        												</span>
                        											</div>
                        										</div> 
                        									</div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Upload Document</label><br>
                                                                    <input type="file" name="other_tds_doc" id="other_tds_doc" class="other_tds_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                                                                    <span id="other_tds_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                                    <?php if(isset($tax_invc_data->other_tds_doc) && !empty($tax_invc_data->other_tds_doc)){ ?>
                                                                    <a href="<?php echo base_url();?>uploads/invoice_closure/<?php echo $tax_invc_data->other_tds_doc; ?>" download>Download</a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">Refundable </h4>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row"><div class="col-md-12"><label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">Security Deposit Retention Amount</label></div></div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                                <div class="input-icon right">
                                                                     <i class="fa"></i>
                                                                     <input type="text" class="form-control " name="security_deposit_retn_amount" id="security_deposit_retn_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  value="<?php echo (isset($security_deposit_retn_amount) && !empty($security_deposit_retn_amount)) ? $security_deposit_retn_amount : '0.00' ?>" min="<?php echo (isset($security_deposit_retn_amount) && !empty($security_deposit_retn_amount)) ? $security_deposit_retn_amount : '0.00' ?>" max="<?php echo (isset($security_deposit_retn_amount) && !empty($security_deposit_retn_amount)) ? $security_deposit_retn_amount : '0.00' ?>" required readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                    										<div class="form-group">
                    											<label class="">Bank Credit Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                    											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                    												<input type="text" name="statutory_deductions_date" id="statutory_deductions_date" class="form-control" readonly="" placeholder="Bank Credit Date" value="<?php echo (isset($tax_invc_data->statutory_deductions_date) && !empty($tax_invc_data->statutory_deductions_date) && $tax_invc_data->statutory_deductions_date!='0000-00-00') ? date('d-m-Y',strtotime($tax_invc_data->statutory_deductions_date)) : '' ?>">		
                    												<span class="input-group-btn">
                    													<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                    												</span>
                    											</div>
                    										</div> 
                    									</div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Upload Document <?php echo (isset($tax_invc_data->statutory_deductions_doc) && !empty($tax_invc_data->statutory_deductions_doc)) ? '': '<span class="require" aria-required="true" style="color:#a94442">*</span>' ?></label><br>
                                                                <input type="file" name="statutory_deductions_doc" id="statutory_deductions_doc" class="statutory_deductions_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" <?php echo (isset($tax_invc_data->statutory_deductions_doc) && !empty($tax_invc_data->statutory_deductions_doc)) ? '': 'required' ?>>
                                                                <span id="statutory_deductions_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                                <?php if(isset($tax_invc_data->statutory_deductions_doc) && !empty($tax_invc_data->statutory_deductions_doc)){ ?>
                                                                <a href="<?php echo base_url();?>uploads/invoice_closure/<?php echo $tax_invc_data->statutory_deductions_doc; ?>" download>Download</a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row"><div class="col-md-12"><label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">Any Other Deposit Amount</label></div></div>
                                                    <?php if(isset($other_deposit_data) && !empty($other_deposit_data)){ ?>
                                                      <?php $i=0;foreach($other_deposit_data as $key){ ?>
                                                        <?php if($i == 0){ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Deposit Description</label>
                                                                    <div class="input-icon right">
                                                                         <i class="fa"></i>
                                                                         <input type="text" class="form-control " name="deposit_desc[]" id="deposit_desc<?php echo $i; ?>" value="<?php echo (isset($key->deposit_desc) && !empty($key->deposit_desc)) ? $key->deposit_desc : '-' ?>" readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Deposit Amount</label>
                                                                    <div class="input-icon right">
                                                                         <i class="fa"></i>
                                                                        <input type="text" class="form-control" id="deposit_amount<?php echo $i; ?>" name="deposit_amount[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($key->deposit_amount) && !empty($key->deposit_amount)) ? $key->deposit_amount : '0.00' ?>" max="<?php echo (isset($key->deposit_amount) && !empty($key->deposit_amount)) ? $key->deposit_amount : '0.00' ?>" min="<?php echo (isset($key->deposit_amount) && !empty($key->deposit_amount)) ? $key->deposit_amount : '0.00' ?>" readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }else{ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-icon right">
                                                                         <i class="fa"></i>
                                                                         <input type="text" class="form-control " name="deposit_desc[]" id="deposit_desc<?php echo $i; ?>" value="<?php echo (isset($key->deposit_desc) && !empty($key->deposit_desc)) ? $key->deposit_desc : '-' ?>" readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-icon right">
                                                                         <i class="fa"></i>
                                                                        <input type="text" class="form-control" id="deposit_amount<?php echo $i; ?>" name="deposit_amount[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($key->deposit_amount) && !empty($key->deposit_amount)) ? $key->deposit_amount : '0.00' ?>" max="<?php echo (isset($key->deposit_amount) && !empty($key->deposit_amount)) ? $key->deposit_amount : '0.00' ?>" min="<?php echo (isset($key->deposit_amount) && !empty($key->deposit_amount)) ? $key->deposit_amount : '0.00' ?>" readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } $i++;} ?> 
                                                        <div class="row">
                                                            <div class="col-md-3">
                        										<div class="form-group">
                        											<label class="">Bank Credit Date</label>
                        											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                        												<input type="text" name="deposit_confirm_date" id="deposit_confirm_date" class="form-control" readonly="" placeholder="Bank Credit Date" value="<?php echo (isset($tax_invc_data->deposit_confirm_date) && !empty($tax_invc_data->deposit_confirm_date) && $tax_invc_data->deposit_confirm_date!='0000-00-00') ? date('d-m-Y',strtotime($tax_invc_data->deposit_confirm_date)) : '' ?>">		
                        												<span class="input-group-btn">
                        													<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                        												</span>
                        											</div>
                        										</div> 
                        									</div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Upload Document</label><br>
                                                                    <input type="file" name="deposit_confirm_doc" id="deposit_confirm_doc" class="deposit_confirm_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                                                                    <span id="deposit_confirm_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                                    <?php if(isset($tax_invc_data->deposit_confirm_doc) && !empty($tax_invc_data->deposit_confirm_doc)){ ?>
                                                                    <a href="<?php echo base_url();?>uploads/invoice_closure/<?php echo $tax_invc_data->deposit_confirm_doc; ?>" download>Download</a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }else{ ?>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Amount</label>
                                                                    <div class="input-icon right">
                                                                         <i class="fa"></i>
                                                                        <input type="text" class="form-control" id="deposit_amount" name="deposit_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="0.00" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                        										<div class="form-group">
                        											<label class="">Bank Credit Date</label>
                        											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                        												<input type="text" name="deposit_confirm_date" id="deposit_confirm_date" class="form-control" readonly="" placeholder="Bank Credit Date" value="<?php echo (isset($tax_invc_data->deposit_confirm_date) && !empty($tax_invc_data->deposit_confirm_date) && $tax_invc_data->deposit_confirm_date!='0000-00-00') ? date('d-m-Y',strtotime($tax_invc_data->deposit_confirm_date)) : '' ?>">		
                        												<span class="input-group-btn">
                        													<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                        												</span>
                        											</div>
                        										</div> 
                        									</div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Upload Document</label><br>
                                                                    <input type="file" name="deposit_confirm_doc" id="deposit_confirm_doc" class="deposit_confirm_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                                                                    <span id="deposit_confirm_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                                    <?php if(isset($tax_invc_data->deposit_confirm_doc) && !empty($tax_invc_data->deposit_confirm_doc)){ ?>
                                                                    <a href="<?php echo base_url();?>uploads/invoice_closure/<?php echo $tax_invc_data->deposit_confirm_doc; ?>" download>Download</a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="row"><div class="col-md-12"><label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">Withheld Amount</label></div></div>
                                                    <?php if(isset($withheld_data) && !empty($withheld_data)){ ?>
                                                      <?php $i=0;foreach($withheld_data as $key){ ?>
                                                        <?php if($i == 0){ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Deposit Description</label>
                                                                    <div class="input-icon right">
                                                                         <i class="fa"></i>
                                                                         <input type="text" class="form-control " name="withheld_desc[]" id="withheld_desc<?php echo $i; ?>" value="<?php echo (isset($key->withheld_desc) && !empty($key->withheld_desc)) ? $key->withheld_desc : '-' ?>" readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Deposit Amount</label>
                                                                    <div class="input-icon right">
                                                                         <i class="fa"></i>
                                                                        <input type="text" class="form-control" id="withheld_amt<?php echo $i; ?>" name="withheld_amt[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($key->withheld_amt) && !empty($key->withheld_amt)) ? $key->withheld_amt : '0.00' ?>" max="<?php echo (isset($key->withheld_amt) && !empty($key->withheld_amt)) ? $key->withheld_amt : '0.00' ?>" min="<?php echo (isset($key->withheld_amt) && !empty($key->withheld_amt)) ? $key->withheld_amt : '0.00' ?>" readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }else{ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-icon right">
                                                                         <i class="fa"></i>
                                                                         <input type="text" class="form-control " name="withheld_desc[]" id="withheld_desc<?php echo $i; ?>" value="<?php echo (isset($key->withheld_desc) && !empty($key->withheld_desc)) ? $key->withheld_desc : '-' ?>" readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="input-icon right">
                                                                         <i class="fa"></i>
                                                                        <input type="text" class="form-control" id="withheld_amt<?php echo $i; ?>" name="withheld_amt[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($key->withheld_amt) && !empty($key->withheld_amt)) ? $key->withheld_amt : '0.00' ?>" max="<?php echo (isset($key->withheld_amt) && !empty($key->withheld_amt)) ? $key->withheld_amt : '0.00' ?>" min="<?php echo (isset($key->withheld_amt) && !empty($key->withheld_amt)) ? $key->withheld_amt : '0.00' ?>" readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } $i++;} ?> 
                                                        <div class="row">
                                                            <div class="col-md-3">
                        										<div class="form-group">
                        											<label class="">Bank Credit Date</label>
                        											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                        												<input type="text" name="withheld_confirm_date" id="withheld_confirm_date" class="form-control" readonly="" placeholder="Bank Credit Date" value="<?php echo (isset($tax_invc_data->withheld_confirm_date) && !empty($tax_invc_data->withheld_confirm_date) && $tax_invc_data->withheld_confirm_date!='0000-00-00') ? date('d-m-Y',strtotime($tax_invc_data->withheld_confirm_date)) : '' ?>">		
                        												<span class="input-group-btn">
                        													<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                        												</span>
                        											</div>
                        										</div> 
                        									</div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Upload Document</label><br>
                                                                    <input type="file" name="withheld_confirm_doc" id="withheld_confirm_doc" class="withheld_confirm_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                                                                    <span id="withheld_confirm_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                                    <?php if(isset($tax_invc_data->withheld_confirm_doc) && !empty($tax_invc_data->withheld_confirm_doc)){ ?>
                                                                    <a href="<?php echo base_url();?>uploads/invoice_closure/<?php echo $tax_invc_data->withheld_confirm_doc; ?>" download>Download</a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }else{ ?>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Amount</label>
                                                                    <div class="input-icon right">
                                                                         <i class="fa"></i>
                                                                        <input type="text" class="form-control" id="withheld_amt" name="withheld_amt" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="0.00" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                        										<div class="form-group">
                        											<label class="">Bank Credit Date</label>
                        											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                        												<input type="text" name="withheld_confirm_date" id="withheld_confirm_date" class="form-control" readonly="" placeholder="Bank Credit Date" value="<?php echo (isset($tax_invc_data->withheld_confirm_date) && !empty($tax_invc_data->withheld_confirm_date) && $tax_invc_data->withheld_confirm_date!='0000-00-00') ? date('d-m-Y',strtotime($tax_invc_data->withheld_confirm_date)) : '' ?>">		
                        												<span class="input-group-btn">
                        													<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                        												</span>
                        											</div>
                        										</div> 
                        									</div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Upload Document</label><br>
                                                                    <input type="file" name="withheld_confirm_doc" id="withheld_confirm_doc" class="withheld_confirm_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                                                                    <span id="withheld_confirm_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                                    <?php if(isset($tax_invc_data->withheld_confirm_doc) && !empty($tax_invc_data->withheld_confirm_doc)){ ?>
                                                                    <a href="<?php echo base_url();?>uploads/invoice_closure/<?php echo $tax_invc_data->withheld_confirm_doc; ?>" download>Download</a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">Any other Deposit / Deduction Confirmation </h4>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Upload Any other Deposit / Deduction Confirmation Document</label><br>
                                                                <input type="file" name="upload_anydepo_doc" id="upload_anydepo_doc" class="upload_anydepo_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                                                                <span id="upload_anydepo_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                                <?php if(isset($tax_invc_data->upload_anydepo_doc) && !empty($tax_invc_data->upload_anydepo_doc)){ ?>
                                                                <a href="<?php echo base_url();?>uploads/invoice_closure/<?php echo $tax_invc_data->upload_anydepo_doc; ?>" download>Download</a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                    
                                        </div>
                                        <?php if(isset($tax_invc->invoice_closure) && !empty($tax_invc->invoice_closure) && $tax_invc->invoice_closure == 'N') { ?>
                                            <div class="form-actions right"> <a href="<?php echo base_url();?>create-tax-invoice" class="btn blue" style="float: left;">Back</a> <button type="button" class="btn btn-danger cancel clearData" title="click To Cancel"> Cancel</button> <button type="submit" class="btn green common_save" title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> Save</button></div>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <?php $this->load->view('common/footer');?> <script src="<?php echo base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/select2/select2.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/admin/pages/scripts/components-pickers.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url()?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/datatables/table-advanced.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/lib/jquery.form.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine.js"></script>
    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine-en.js"></script>
    <script src="<?php echo base_url();?>js/common.js?<?php echo date('Y-m-d H:i:s'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/user.js?<?php echo date('Y-m-d H:i:s'); ?>" type="text/javascript"></script>
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