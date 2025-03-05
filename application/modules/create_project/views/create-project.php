<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Create OEF | <?php echo project_name; ?> </title>
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
  <link href="<?php echo base_url(); ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/global/css/components-rounded.css?<?php echo date('Y-m-d H:i:s'); ?>" id="style_components" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/global/css/plugins.css?<?php echo date('Y-m-d H:i:s'); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/admin/layout4/css/layout.css?<?php echo date('Y-m-d H:i:s'); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>/assets/admin/layout4/css/light.css?<?php echo date('Y-m-d H:i:s'); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/site/css/validationEngine.jquery.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/createp.css?<?php echo date('Y-m-d H:i:s'); ?>" rel="stylesheet">
</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo ">
  <?php $this->load->view('common/header'); ?>
  <div class="clearfix"> </div>
  <div class="page-container">
    <?php $this->load->view('common/sidebar'); ?>
    <div class="page-content-wrapper">
      <div class="page-content">
        <div class="row">
          <div class="col-md-12">
            <div class="portlet light">
              <div class="portlet-title">
                <div class="caption font-blue">
                  <i class="fa fa-plus-circle font-blue"></i>
                  <span class="caption-subject bold uppercase">Create OEF</span>
                </div>
              </div>
              <div class="portlet-body form">
                <?php echo $this->session->flashdata('message'); ?>
                <form action="save_create_project" enctype="multipart/form-data" id="save_create_project" method="post" class="horizontal-form">
                  <div class="form-body">
                    <div class="alert alert-danger display-none" id="error_alert" style="display:none;background-color: #F3565D;border-color: #f13e64;color: white;">
                      <button class="close" data-dismiss="alert"></button>Please enter required (*) fields.
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title"> Customer Details </h4>
                      </div>
                      <div class="panel-body">
                        <input type="hidden" name="emd_converted_deposit" id="emd_paid_status_id_value" value="N">
                        <input type="hidden" name="asd_converted_deposit" id="asd_paid_status_id_value" value="N">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Business Head <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <select class="form-control select2me" name="business_head" id="business_head" required>
                                <option value="">--Select--</option>
                                <?php if (isset($business_user) && !empty($business_user)) {
                                  foreach ($business_user as $key) { ?>
                                    <option value="<?php echo $key->user_id ?>"><?php echo $key->fullname.' '.$key->m_name.' '.$key->s_name; ?></option>
                                  <?php } } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="">Project Manager <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                <select class="form-control select2me" name="manager_head" id="manager_head" required>
                                  <option value="">--Select--</option>
                                  <?php if (isset($project_user) && !empty($project_user)) {
                                    foreach ($project_user as $key) { ?>
                                      <option value="<?php echo $key->user_id ?>"><?php echo $key->fullname.' '.$key->m_name.' '.$key->s_name; ?></option>
                                    <?php } } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Customer Name <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="Customer Name" required>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">BP Code <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="bp_code" id="bp_code" placeholder="BP Code" required>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="">PO/LOI No<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control " name="po_loi_no" id="po_loi_no" placeholder="PO/LOI No">
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="">PO/LOI Date<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                                    <input type="text" name="po_loi_received_data" id="po_loi_received_data" class="form-control" readonly="" placeholder="Select PO/LOI Date" >
                                    <span class="input-group-btn">
                                      <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                    </span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Upload PO/LOI Document </label>
                                  <input type="file" name="po_loi_doc" id="po_loi_doc" class="po_loi_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Registered Address <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <textarea rows="2" type="text" class="form-control" name="registered_address" id="registered_address" placeholder="Registered Address"></textarea>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Client PO Address<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <textarea rows="2" type="text" class="form-control" name="client_po_addr" id="client_po_addr" placeholder="Client PO Address"></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Our Address on PO<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <textarea rows="2" type="text" class="form-control" name="our_address_on_po" id="our_address_on_po" placeholder="Our Address on PO"></textarea>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="">Name of Work<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <textarea rows="2" type="text" class="form-control" name="name_of_work" id="name_of_work" placeholder="Name of Work"></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label class="">Work Order On <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <select class="form-control select2me" name="work_order_on" id="work_order_on">
                                    <option value="">--Select--</option>
                                    <option value="Prudent EPC" <?php echo (isset($create_project_data->work_order_on) && !empty($create_project_data->work_order_on) && ($create_project_data->work_order_on == 'Prudent EPC')) ? 'selected="selected"' : ''; ?>>Prudent EPC</option>
                                    <option value="Prudent Controls" <?php echo (isset($create_project_data->work_order_on) && !empty($create_project_data->work_order_on) && ($create_project_data->work_order_on == 'Prudent Controls')) ? 'selected="selected"' : ''; ?>>Prudent Controls</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Site Address<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <textarea rows="2" type="text" class="form-control" name="site_address" id="site_address" placeholder="Site Address"></textarea>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="">Taxable Amount<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="taxable_amount" id="taxable_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Taxable Amount" >
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="">GST Rate<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <select class="form-control select2me" name="gst_rate" id="gst_rate">
                                    <option value="">--Select--</option>
                                    <option value="5">5%</option>
                                    <option value="12">12%</option>
                                    <option value="18">18%</option>
                                    <option value="28">28%</option>
                                    <option value="composite">Composite</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="">GST Amount<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control " name="gst_amount" id="gst_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  placeholder="GST Amount">
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="">Total Amount<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="total_amount" id="total_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Total Amount">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group dflx">
                                  <input type="checkbox" name="emd_paid" id="emd_paid" value="Y">
                                  <label class="" style="padding: 0 5px;">EMD<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group dflx">
                                  <input type="checkbox" name="asd_paid" id="asd_paid" value="Y">
                                  <label class="" style="padding:0 5px;">ASD<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group dflx">
                                  <input type="checkbox" name="performance_paid" id="performance_paid" value="Y">
                                  <label class="" style="padding:0 5px;">Performance Guarantee/Bond<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                </div>
                              </div>
                            </div>
                            <div id="ifemdpaiddiv" style="margin-bottom:10px;"></div>
                            <div id="ifasdpaiddiv" style="margin-bottom:10px;"></div>
                            <div id="ifperformancepaiddiv"></div>
                            <div id="apperdi"></div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="">Security Deposit Retention(%)<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control " name="security_deposite_num" id="security_deposite_num" data-id="sec_deposite" id="security_deposite_num" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="3" min="1" max="100" placeholder="Security Deposite Retention(%)">
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="">Warranty Period <br> (Months)<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control " name="warranty_period" data-id="warranty_period" id="warranty_period" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Warranty Period">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title"> Key Persons of Customer </h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Billing Related <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="billing_related" id="billing_related" placeholder="Billing Related">
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">PO Related<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control " name="po_related" id="po_related" placeholder="PO Related">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Execution Related<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="execution_related" id="execution_related" placeholder="Execution Related">
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Engineer In-charge<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control " name="engineer_in_charge" id="engineer_in_charge" placeholder="Engineer In-charge">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Completion Period (Months)<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="completion_period" id="completion_period" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Completion Period">
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Client GST No<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control " name="gst_no" id="gst_no" placeholder="Client GST No">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Price inclusive of AMC<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="dflx">
                                    <input type="radio" name="price_inslusive_of_amc" id="price_inslusive_of_amc_yes" value="Yes"><span style="padding: 0 10px 0px 5px;">Yes</span>
                                    <input type="radio" name="price_inslusive_of_amc" id="price_inslusive_of_amc_no" value="No" checked><span style="padding: 0 10px 0px 5px;">No</span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Is billing Inter-State<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="dflx">
                                    <input type="radio" name="is_billing_inter_state" id="is_billing_inter_state_yes" value="Yes"><span style="padding: 0 10px 0px 5px;">Yes</span>
                                    <input type="radio" name="is_billing_inter_state" id="is_billing_inter_state_no" value="No" checked><span style="padding: 0 10px 0px 5px;">No</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row ifpros"></div>
                            <div class="row">
                              <div class="col-md-12">
                                <label class="" style="font-size:14px;font-weight:600;">Consignee Details<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                <p id="consignee_error" style="color: #a94442;"></p>
                              </div>
                            </div>
                            <div id="consineeDetailDisplayed"></div>
                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="">Consignee Name<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right"><i class="fa"></i>
                                    <input type="text" class="form-control" name="consignee_name[]" id="consignee_name0" placeholder="Consignee Name">
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="">Delivery Address<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right"><i class="fa"></i>
                                    <textarea type="text" class="form-control" name="delivery_address[]" id="delivery_address0" placeholder="Delivery Address"></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="">GST Number<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right"><i class="fa"></i>
                                    <input type="text" class="form-control" name="gst_types[]" id="gst_types0" placeholder="GST Number">
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-1">
                                <div class="add_consignee"><i class="fa fa-plus" aria-hidden="true"  style="font-size:10px;"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title"> Insurance Required </h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label class="">Insurance Required<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="dflx">
                                    <input type="radio" name="insurance_req" id="insurance_yes" value="Yes"><span style="padding: 0 10px 0px 5px;">Yes</span>
                                    <input type="radio" name="insurance_req" id="insurance_no" value="No" checked><span style="padding: 0 10px 0px 5px;">No</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <span id="insurance_req_err" style="font-size:12px;color:#a94442;"></span>
                            <div class="insurancereqdiv" id="insurancereqdiv"></div>
                            <div id="nsuranceRequiredApp"></div>
                            <div class="row agreementprepared">
                              <div class="col-md-5">
                                <div class="form-group">
                                  <label class="">Agreement Prepared<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="dflx">
                                    <input type="radio" name="agreement_prepared" id="agreement_prepared_yes" value="Yes"><span style="padding: 0 10px 0px 5px;">Yes</span>
                                    <input type="radio" name="agreement_prepared" id="agreement_prepared_no" value="No" checked><span style="padding: 0 10px 0px 5px;">No</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Penalty Clause<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <textarea rows="2" type="text" class="form-control" name="penalty_clause" id="penalty_clause" placeholder="Penalty Clause"></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label">Upload Penalty Clause</label><br>
                                  <input type="file" name="penalty_clause_file" id="penalty_clause_file" class="penalty_clause_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />
                                  <span id="penalty_clause_file_error" style="font-size: 12px;color:#a94442;"></span>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Power of Attorney<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <textarea rows="2" type="text" class="form-control" name="power_of_attorney" id="power_of_attorney" placeholder="Power of Attorney"></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label">Upload Power of Attorney</label><br>
                                  <input type="file" name="power_of_attorney_file" id="power_of_attorney_file" class="power_of_attorney_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />
                                  <span id="power_of_attorney_file_error" style="font-size: 12px;color:#a94442;"></span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title"> Pre-dispatch Requisites </h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-md-2">
                                <div class="form-group dflx">
                                  <input type="checkbox" name="sample" id="sample" value="Y"> <label class="" style="padding:0 5px;">Sample </label>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group dflx">
                                  <input type="checkbox" name="prototype" id="prototype" value="Y"> <label class="" style="padding:0 5px;">Prototype</label>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group dflx">
                                  <input type="checkbox" name="inspection" id="inspection" value="Y"> <label class="" style="padding:0 5px;">Inspection </label>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group dflx">
                                  <input type="checkbox" name="fat" id="fat" value="Y"> <label class="" style="padding:0 5px;">FAT</label>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group dflx">
                                  <input type="checkbox" name="sat" id="sat" value="Y"> <label class="" style="padding:0 5px;">SAT</label>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group dflx">
                                  <input type="checkbox" name="test_report" id="test_report" value="Y"> <label class="" style="padding:0 5px;">Test Report</label>
                                </div>
                              </div>
                            </div>
                            <div id="didetlsa"></div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Payment Terms</label>
                                  <div class="dflx">
                                    <input type="radio" name="payment_terms" id="si"   value="S&I"  checked><span style="padding: 0 10px 0px 5px;">S&I</span>
                                    <input type="radio" name="payment_terms"  id="SITC" value="SITC"><span style="padding: 0 10px 0px 5px;">SITC</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="panel panel-default" id="billing_split_up" style="display: none;">
                          <div class="panel-heading">
                            <h4 class="panel-title">Billing Split Up Details </h4>
                          </div>
                          <div class="panel-body">
                            <p style="color:#a94442;font-size:12px;">Note * : Billing Split Up must be equal to 100%</p>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Supply(%) <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control tcl" name="bill_split_supply" id="bill_split_supply" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($create_project_data->bill_split_supply) && !empty($create_project_data->bill_split_supply)) ? $create_project_data->bill_split_supply : '' ?>" maxlength="3" min="0" max="100" placeholder="Supply(%) ">
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Installation(%) <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control tcl" name="bill_installation" id="bill_installation" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($create_project_data->bill_installation) && !empty($create_project_data->bill_installation)) ? $create_project_data->bill_installation : '' ?>" maxlength="3" min="0" max="100" placeholder="Installation(%)">
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Testing & Commissioning(%) <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control tcl" name="testing_commissioning" id="testing_commissioning" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($create_project_data->testing_commissioning) && !empty($create_project_data->testing_commissioning)) ? $create_project_data->testing_commissioning : '' ?>" maxlength="3" min="0" max="100" placeholder="Testing & Commissioning(%) ">
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Handover(%) <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control tcl" name="bill_handover" id="bill_handover" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="3" min="0" max="100" value="<?php echo (isset($create_project_data->bill_handover) && !empty($create_project_data->bill_handover)) ? $create_project_data->bill_handover : '' ?>" placeholder="Handover(%)">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title"> Additional Details </h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Invoice to be submitted on customer website<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="dflx">
                                    <input type="radio" name="invoice_submitted" id="invoice_submitted_yes" value="Yes"><span style="padding: 0 10px 0px 5px;">Yes</span>
                                    <input type="radio" name="invoice_submitted" id="invoice_submitted_no" value="No" checked><span style="padding: 0 10px 0px 5px;">No</span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Invoice to be sent on different address<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="dflx">
                                    <input type="radio" name="invoice_submitted_address" id="invoice_submitted_address_yes" value="Yes"><span style="padding: 0 10px 0px 5px;">Yes</span>
                                    <input type="radio" name="invoice_submitted_address" id="invoice_submitted_address_no" value="No" checked><span style="padding: 0 10px 0px 5px;">No</span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">ESIC Required<span class="require" aria-required="true" style="color:#a94442">*</span></label><br>
                                  <div class="dflx">
                                    <input type="radio" name="esic_required" id="esicYes" value="Yes"><span style="padding: 0 10px 0px 5px;">Yes</span>
                                    <input type="radio" name="esic_required" id="esicNo" value="No" checked><span style="padding: 0 10px 0px 5px;">No</span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">PF Required<span class="require" aria-required="true" style="color:#a94442">*</span></label><br>
                                  <div class="dflx">
                                    <input type="radio" name="pf_required" id="pfYes" value="Yes"><span style="padding: 0 10px 0px 5px;">Yes</span>
                                    <input type="radio" name="pf_required" id="pfNo" value="No" checked><span style="padding: 0 10px 0px 5px;">No</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row" id="daddde"></div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Payment Terms<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="any_other_details" placeholder="Payment Terms">
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="">Payment Terms Document</label>
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="file" class="" name="payment_terms_document" value="" >
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title">Attachments</h4>
                          </div>
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label">Project Completion Schedule Upload </label><br>
                                  <input type="file" name="upload_projectcmpl_doc_file" id="upload_projectcmpl_doc_file" class="upload_projectcmpl_doc_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />
                                  <span id="upload_projectcmpl_doc_file_error" style="font-size: 12px;color:#a94442;"></span>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label">Project Design Report Upload</label><br>
                                  <input type="file" name="upload_projectdesig_doc_file" id="upload_projectdesig_doc_file" class="upload_projectdesig_doc_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />
                                  <span id="upload_projectdesig_doc_file_error" style="font-size: 12px;color:#a94442;"></span>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label">Project Cash Flow Upload</label><br>
                                  <input type="file" name="upload_projectcashflw_doc_file" id="upload_projectcashflw_doc_file" class="upload_projectcashflw_doc_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />
                                  <span id="upload_projectcashflw_doc_file_error" style="font-size: 12px;color:#a94442;"></span>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="control-label">Project Investment Schedule Upload</label><br>
                                  <input type="file" name="upload_projectinvstsch_doc_file" id="upload_projectinvstsch_doc_file" class="upload_projectinvstsch_doc_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />
                                  <span id="upload_projectinvstsch_doc_file_error" style="font-size: 12px;color:#a94442;"></span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-actions right">
                        <a href="<?php echo base_url(); ?>create-project-list" class="btn blue" style="float: left;">Back</a>
                        <a href="<?php echo base_url(); ?>create-project" class="btn btn-danger cancel" title="click To Clear"> Clear</a>
                        <button type="submit" class="btn orange pssave" title="click To Save" rel="<?php echo (isset($create_project_data->create_project_id) && !empty($create_project_data->create_project_id)) ? $create_project_data->create_project_id : '' ?>"><i class="fa fa-dot-circle-o"></i> Save as Draft</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
      <script src="<?php echo base_url(); ?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/datatables/table-advanced.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/additional-methods.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/lib/jquery.form.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine.js"></script>
      <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine-en.js"></script>
      <script src="<?php echo base_url(); ?>js/common.js?<?php echo date('Y-m-d H:i:s'); ?>" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>js/addproject.js?<?php echo date('Y-m-d H:i:s'); ?>" type="text/javascript"></script>
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
