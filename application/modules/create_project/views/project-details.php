<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="utf-8" />

  <title>OEF Details | <?php echo project_name; ?> </title>

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

            <?php $this->load->view('tab'); ?>

            <div class="tab-content">
              <div class="portlet light">
                <div class="portlet-title">

                  <div class="caption font-blue">

                    <i class="fa fa-bars font-blue"></i>

                    <span class="caption-subject bold uppercase"><?php echo(isset($project_data->bp_code) && !empty($project_data->bp_code))?'(#'.$project_data->bp_code.')':''?> OEF Details</span>

                  </div>

                  <div class="actions" style="display: inline-flex;">

                    <div class="page-header navbar" style="height:10px;min-height:10px;">

                      <div class="page-top">

                        <div class="top-menu">

                          <ul class="nav navbar-nav pull-right">

                            <li class="separator hide">

                            </li>

                            <li class="dropdown dropdown-extended dropdown-dark dropdown-notification" id="header_notification_bar" style="height:auto;">

                              <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" data-original-title="Reminder" title="Reminder" style="background: #fff;padding: 0 10px;">

                                <i class="fa fa-calendar"></i>

                                <span class="badge badge-default"><?php echo (isset($reminder_data) && !empty($reminder_data))?count($reminder_data):'0'; ?></span>

                              </a>

                              <ul class="dropdown-menu">

                                <?php if(isset($reminder_data) && !empty($reminder_data)){ ?>

                                  <li class="external">

                                    <h3>You have <strong><?php echo (isset($reminder_data) && !empty($reminder_data))?count($reminder_data):'0'; ?> pending</strong> Reminder</h3>

                                    <a href="<?php echo base_url(); ?>view-all-reminder/<?php echo base64_encode($project_id); ?>">view all</a>

                                  </li>

                                  <li>

                                    <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">

                                      <?php foreach($reminder_data as $key){

                                        $datetime = $this->common_model->time_elapsed_string($key->created_date, true).PHP_EOL; ?>

                                        <li>

                                          <a href="javascript:;">

                                            <div class="details" style="display: flex;justify-content: flex-start;align-items: center;">

                                              <div class="">

                                                <span class="label label-sm label-icon label-success" style="padding: 2px;"><?php echo (isset($key->icon) && !empty($key->icon))?$key->icon:''; ?></span>

                                              </div>

                                              <div class="">

                                                <?php echo (isset($key->notification) && !empty($key->notification))?$key->notification:''; ?>

                                                <p class="timep"><?php echo (isset($datetime) && !empty($datetime))?$datetime:'0'; ?></p>

                                              </div>

                                            </div>

                                          </a>

                                        </li>

                                      <?php } ?>

                                    </ul>

                                  </li>

                                <?php }else{ ?>

                                  <li class="external">

                                    <h3><strong>No Reminder Found!</strong></h3>

                                    <a href="<?php echo base_url(); ?>view-all-reminder/<?php echo base64_encode($project_id); ?>">view all</a>

                                  </li>

                                <?php } ?>

                              </ul>

                            </li>

                            <li class="dropdown dropdown-extended dropdown-dark dropdown-notification" id="header_notification_bar" style="height:auto;">

                              <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" data-original-title="Notification" title="Notification" style="background: #fff;padding: 0 10px;">

                                <i class="icon-bell"></i>

                                <span class="badge badge-default"><?php echo (isset($notification_data) && !empty($notification_data))?count($notification_data):'0'; ?></span>

                              </a>

                              <ul class="dropdown-menu">

                                <?php if(isset($notification_data) && !empty($notification_data)){ ?>

                                  <li class="external">

                                    <h3>You have <strong><?php echo (isset($notification_data) && !empty($notification_data))?count($notification_data):'0'; ?> pending</strong> Notification</h3>

                                    <a href="<?php echo base_url(); ?>view-all-notification/<?php echo base64_encode($project_id); ?>">view all</a>

                                  </li>

                                  <li>

                                    <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">

                                      <?php foreach($notification_data as $key){

                                        $datetime = $this->common_model->time_elapsed_string($key->created_date, true).PHP_EOL; ?>

                                        <li>

                                          <a href="javascript:;">

                                            <div class="details" style="display: flex;justify-content: flex-start;align-items: center;">

                                              <div class="">

                                                <span class="label label-sm label-icon label-success" style="padding: 2px;"><?php echo (isset($key->icon) && !empty($key->icon))?$key->icon:''; ?></span>

                                              </div>

                                              <div class="">

                                                <?php echo (isset($key->notification) && !empty($key->notification))?$key->notification:''; ?>

                                                <p class="timep"><?php echo (isset($datetime) && !empty($datetime))?$datetime:'0'; ?></p>

                                              </div>

                                            </div>

                                          </a>

                                        </li>

                                      <?php } ?>

                                    </ul>

                                  </li>

                                <?php }else{ ?>

                                  <li class="external">

                                    <h3><strong>No Notification Received!</strong></h3>

                                    <a href="<?php echo base_url(); ?>view-all-notification/<?php echo base64_encode($project_id); ?>">view all</a>

                                  </li>

                                <?php } ?>

                              </ul>

                            </li>



                          </ul>

                        </div>

                      </div>

                    </div>

                  </div>

                </div>

                <div class="portlet-body form">

                  <nav id="menu-container" class="arrow">

                    <div id="btn-nav-previous" style="fill: #5b9bd1">

                      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"

                      viewBox="0 0 24 24">

                      <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />

                      <path d="M0 0h24v24H0z" fill="none" /></svg>

                    </div>

                    <div id="btn-nav-next">

                      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"

                      viewBox="0 0 24 24">

                      <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />

                      <path d="M0 0h24v24H0z" fill="none" /></svg>

                    </div>

                    <div class="menu-inner-box">

                      <div class="menu">

                        <a role="presentation" href="<?php echo base_url(); ?>project-details/<?php echo base64_encode($project_id); ?>" class="cm menu-item menu-item-active project-details">OEF Details</a>

                        <a role="presentation" href="<?php echo base_url(); ?>boq-transaction/<?php echo base64_encode($project_id); ?>" class="cm menu-item boq-transaction">BOQ Transactions</a>

                        <a role="presentation" href="<?php echo base_url(); ?>view-boq/<?php echo base64_encode($project_id); ?>" class="cm menu-item boq-view">BOQ View</a>

                        <a role="presentation" href="<?php echo base_url(); ?>view-boq-exceptional-approval/<?php echo base64_encode($project_id); ?>" class="cm menu-item view-boq-exceptional-approval">BOQ Exceptional Approval</a>

                        <a role="presentation" href="<?php echo base_url(); ?>operational-scheduled/<?php echo base64_encode($project_id); ?>" class="cm menu-item boq-operational-view">BOQ Operable Schedule View</a>

                        <a role="presentation" href="<?php echo base_url(); ?>delivery-challan/<?php echo base64_encode($project_id); ?>" class="cm menu-item delivery-challan">Client Delivery Challan</a>

                        <!--<a role="presentation" href="<?php echo base_url(); ?>warehouse/<?php echo base64_encode($project_id); ?>" class="cm menu-item virtual-stock">Warehouse</a>-->

                        <a role="presentation" href="<?php echo base_url(); ?>installed-wip/<?php echo base64_encode($project_id); ?>" class="cm menu-item installed-wip">Installed WIP</a>

                        <a role="presentation" href="<?php echo base_url(); ?>provisional-wip/<?php echo base64_encode($project_id); ?>" class="cm menu-item provisional-wip">Provisional WIP</a>

                        <a role="presentation" href="<?php echo base_url(); ?>proforma-invoice/<?php echo base64_encode($project_id); ?>" class="cm menu-item proforma-invoice">Proforma Invoice</a>

                        <a role="presentation" href="<?php echo base_url(); ?>tax-invoice/<?php echo base64_encode($project_id); ?>" class="cm menu-item tax-invoice">Tax Invoice</a>

                        <a role="presentation" href="<?php echo base_url(); ?>approval-waiting/<?php echo base64_encode($project_id); ?>" class="cm menu-item waiting-approval">Waiting for Approval</a>

                        <a role="presentation" href="<?php echo base_url(); ?>wip-status/<?php echo base64_encode($project_id); ?>" class="cm menu-item wip-status">WIP Status</a>

                      </div>

                    </div>

                  </nav>

                  <div class="tab-content">

                    <div role="tabpanel" class="tab-pane active" id="project-details">

                      <form action="update_create_project" enctype="multipart/form-data" id="update_create_project" method="post" class="horizontal-form">

                        <div class="form-body">

                          <div class="alert alert-danger display-none" id="error_alert" style="display:none;background-color: #F3565D;border-color: #f13e64;color: white;">

                            <button class="close" data-dismiss="alert"></button>Please enter required (*) fields.

                          </div>

                          <div class="panel panel-default">

                            <div class="panel-heading">

                              <h4 class="panel-title"> Customer Details </h4>

                            </div>

                            <div class="panel-body">

                              <input type="hidden" name="update_project_id" value="<?php echo (isset($project_data->project_id) && !empty($project_data->project_id)) ? $project_data->project_id : '0' ?>">

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

                                          <option value="<?php echo $key->user_id ?>" <?php echo (isset($project_data->business_head) && !empty($project_data->business_head) && ($project_data->business_head==$key->user_id))?'selected="selected"':'';?>><?php echo $key->fullname.' '.$key->m_name.' '.$key->s_name; ?></option>

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

                                            <option value="<?php echo $key->user_id ?>" <?php echo (isset($project_data->manager_head) && !empty($project_data->manager_head) && ($project_data->manager_head==$key->user_id))?'selected="selected"':'';?>><?php echo $key->fullname.' '.$key->m_name.' '.$key->s_name; ?></option>

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

                                          <input type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo (isset($project_data->customer_name) && !empty($project_data->customer_name)) ? $project_data->customer_name : '' ?>" placeholder="Customer Name" required>

                                        </div>

                                      </div>

                                    </div>

                                    <div class="col-md-6">

                                      <div class="form-group">

                                        <label class="">BP Code <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <input type="text" class="form-control" name="bp_code" id="bp_code" value="<?php echo (isset($project_data->bp_code) && !empty($project_data->bp_code)) ? $project_data->bp_code : '' ?>" placeholder="BP Code" required>

                                        </div>

                                      </div>

                                    </div>

                                  </div>

                                  <div class="row">

                                    <div class="col-md-3">

                                      <div class="form-group">

                                        <label class="">PO/LOI No <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <input type="text" class="form-control " name="po_loi_no" id="po_loi_no" value="<?php echo (isset($project_data->po_loi_no) && !empty($project_data->po_loi_no)) ? $project_data->po_loi_no : '' ?>" placeholder="PO/LOI No">

                                        </div>

                                      </div>

                                    </div>

                                    <div class="col-md-3">

                                      <div class="form-group">

                                        <label class="">PO/LOI Date <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">

                                          <input type="text" name="po_loi_received_data" id="po_loi_received_data" class="form-control" readonly="" placeholder="Select PO/LOI Date" value="<?php echo (isset($project_data->po_loi_received_data) && !empty($project_data->po_loi_received_data)) ? $project_data->po_loi_received_data : '' ?>">

                                          <span class="input-group-btn">

                                            <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>

                                          </span>

                                        </div>

                                      </div>

                                    </div>

                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label>Upload PO/LOI  Document </label>
                                        <input type="file" name="po_loi_doc" id="po_loi_doc" class="po_loi_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />
                                        <?php if(isset($project_data->po_loi_doc) && !empty($project_data->po_loi_doc)){ ?>

                                          <a href="<?php echo base_url(); ?>uploads/document_upload/<?php echo $project_data->po_loi_doc; ?>" download>Download</a>

                                        <?php } ?>
                                        <input type="hidden" name="hidden_po_loi_doc" value="<?php echo $project_data->po_loi_doc; ?>">
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">

                                    <div class="col-md-6">

                                      <div class="form-group">

                                        <label class="">Registered Address <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <textarea rows="2" type="text" class="form-control" name="registered_address" id="registered_address" placeholder="Registered Address"><?php echo (isset($project_data->registered_address) && !empty($project_data->registered_address)) ? $project_data->registered_address : '' ?></textarea>

                                        </div>

                                      </div>

                                    </div>



                                    <div class="col-md-6">

                                      <div class="form-group">

                                        <label class="">Client PO Address <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <textarea rows="2" type="text" class="form-control" name="client_po_addr" id="client_po_addr" placeholder="Client PO Address"><?php echo (isset($project_data->client_po_addr) && !empty($project_data->client_po_addr)) ? $project_data->client_po_addr : '' ?></textarea>

                                        </div>

                                      </div>

                                    </div>

                                    <div class="col-md-6">

                                      <div class="form-group">

                                        <label class="">Our Address on PO <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <textarea rows="2" type="text" class="form-control" name="our_address_on_po" id="our_address_on_po" placeholder="Our Address on PO"><?php echo (isset($project_data->our_address_on_po) && !empty($project_data->our_address_on_po)) ? $project_data->our_address_on_po : '' ?></textarea>

                                        </div>

                                      </div>

                                    </div>

                                  </div>

                                  <div class="row">

                                    <div class="col-md-4">

                                      <div class="form-group">

                                        <label class="">Name of Work <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <textarea rows="2" type="text" class="form-control" name="name_of_work" id="name_of_work" placeholder="Name of Work"><?php echo (isset($project_data->name_of_work) && !empty($project_data->name_of_work)) ? $project_data->name_of_work : '' ?></textarea>

                                        </div>

                                      </div>

                                    </div>

                                    <div class="col-md-2">

                                      <div class="form-group">

                                        <label class="">Work Order On <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <select class="form-control select2me" name="work_order_on" id="work_order_on">

                                          <option value="">--Select--</option>

                                          <option value="Prudent EPC" <?php echo (isset($project_data->work_order_on) && !empty($project_data->work_order_on) && ($project_data->work_order_on == 'Prudent EPC')) ? 'selected="selected"' : ''; ?>>Prudent EPC</option>

                                          <option value="Prudent Controls" <?php echo (isset($project_data->work_order_on) && !empty($project_data->work_order_on) && ($project_data->work_order_on == 'Prudent Controls')) ? 'selected="selected"' : ''; ?>>Prudent Controls</option>

                                        </select>

                                      </div>

                                    </div>

                                    <div class="col-md-6">

                                      <div class="form-group">

                                        <label class="">Site Address <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <textarea rows="2" type="text" class="form-control" name="site_address" id="site_address" placeholder="Site Address"><?php echo (isset($project_data->site_address) && !empty($project_data->site_address)) ? $project_data->site_address : '' ?></textarea>

                                        </div>

                                      </div>

                                    </div>

                                  </div>

                                  <div class="row">

                                    <div class="col-md-3">

                                      <div class="form-group">

                                        <label class="">Taxable Amount <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <input type="text" class="form-control" name="taxable_amount" id="taxable_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($project_data->taxable_amount) && !empty($project_data->taxable_amount)) ? $project_data->taxable_amount : '' ?>" placeholder="Taxable Amount">

                                        </div>

                                      </div>

                                    </div>

                                    <div class="col-md-3">

                                      <div class="form-group">

                                        <label class="">GST Rate <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <select class="form-control select2me" name="gst_rate" id="gst_rate">

                                          <option value="">--Select--</option>

                                          <option value="5" <?php echo (isset($project_data->gst_rate) && !empty($project_data->gst_rate) && ($project_data->gst_rate == '5')) ? 'selected="selected"' : ''; ?>>5%</option>

                                          <option value="12" <?php echo (isset($project_data->gst_rate) && !empty($project_data->gst_rate) && ($project_data->gst_rate == '12')) ? 'selected="selected"' : ''; ?>>12%</option>

                                          <option value="18" <?php echo (isset($project_data->gst_rate) && !empty($project_data->gst_rate) && ($project_data->gst_rate == '18')) ? 'selected="selected"' : ''; ?>>18%</option>

                                          <option value="28" <?php echo (isset($project_data->gst_rate) && !empty($project_data->gst_rate) && ($project_data->gst_rate == '28')) ? 'selected="selected"' : ''; ?>>28%</option>

                                          <option value="composite" <?php echo (isset($project_data->gst_rate) && !empty($project_data->gst_rate) && ($project_data->gst_rate == 'composite')) ? 'selected="selected"' : ''; ?>>Composite</option>

                                        </select>

                                      </div>

                                    </div>

                                    <div class="col-md-3">

                                      <div class="form-group">

                                        <label class="">GST Amount <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <input type="text" class="form-control " name="gst_amount" id="gst_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($project_data->gst_amount) && !empty($project_data->gst_amount)) ? $project_data->gst_amount : '' ?>" placeholder="GST Amount">

                                        </div>

                                      </div>

                                    </div>

                                    <div class="col-md-3">

                                      <div class="form-group">

                                        <label class="">Total Amount <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <input type="text" class="form-control" name="total_amount" id="total_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($project_data->total_amount) && !empty($project_data->total_amount)) ? $project_data->total_amount : '' ?>" placeholder="Total Amount">

                                        </div>

                                      </div>

                                    </div>

                                  </div>

                                  <div class="row">

                                    <div class="col-md-3">

                                      <div class="form-group dflx">

                                        <input type="checkbox" name="emd_paid" id="emd_paid" value="Y" <?php echo (isset($project_data->emd_paid) && !empty($project_data->emd_paid) && ($project_data->emd_paid == 'Y')) ? 'checked' : '' ?>>

                                        <label class="" style="padding: 0 5px;">EMD</label>

                                      </div>

                                    </div>

                                    <div class="col-md-3">

                                      <div class="form-group dflx">

                                        <input type="checkbox" name="asd_paid" id="asd_paid" value="Y" <?php echo (isset($project_data->asd_paid) && !empty($project_data->asd_paid) && ($project_data->asd_paid == 'Y')) ? 'checked' : '' ?>>

                                        <label class="" style="padding:0 5px;">ASD</label>

                                      </div>

                                    </div>

                                    <div class="col-md-6">

                                      <div class="form-group dflx">

                                        <input type="checkbox" name="performance_paid" id="performance_paid" value="Y" <?php echo (isset($project_data->performance_paid) && !empty($project_data->performance_paid) && ($project_data->performance_paid == 'Y')) ? 'checked' : '' ?>>

                                        <label class="" style="padding:0 5px;">Performance Guarantee/Bond</label>

                                      </div>

                                    </div>

                                  </div>

                                  <?php if(isset($project_data->emd_paid) && !empty($project_data->emd_paid) && $project_data->emd_paid=='Y'){ ?>

                                    <div id="ifemdpaiddiv" style="margin-bottom:10px;">

                                      <div class="row ifemdpaid">

                                        <div class="col-md-3">

                                          <div class="form-group">

                                            <label class="">EMD Amount <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <div class="input-icon right"><i class="fa"></i>

                                              <input type="number" class="form-control " name="emd_paid_num" id="emd_paid_num" placeholder="EMD Amount" value="<?php echo (isset($project_data->emd_paid_num) && !empty($project_data->emd_paid_num)) ? $project_data->emd_paid_num : '' ?>">

                                            </div>

                                          </div>

                                        </div>

                                        <div class="col-md-3">

                                          <div class="form-group">

                                            <label class="control-label">EMD Paid <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <div class="dflx">

                                              <input type="radio" name="emd_paid_status" id="emd_paid_status_yes" class="emd_paid_status_div" value="Yes" <?php echo (isset($project_data->emd_paid_status) && !empty($project_data->emd_paid_status) && $project_data->emd_paid_status == 'Y') ? 'checked=""': '' ?>>

                                              <span style="padding: 0 10px 0px 5px;">Yes</span>

                                              <input type="radio" name="emd_paid_status" id="emd_paid_status_no" class="emd_paid_status_div" value="No" <?php echo (isset($project_data->emd_paid_status) && !empty($project_data->emd_paid_status) && $project_data->emd_paid_status == 'N') ? 'checked=""': '' ?>>

                                              <span style="padding: 0 10px 0px 5px;">No</span>

                                            </div>

                                          </div>

                                        </div>

                                        <div class="col-md-3">

                                          <div class="form-group">

                                            <label class="control-label">Upload EMD Paid <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <?php if(isset($project_data->upload_emd_paid_file) && !empty($project_data->upload_emd_paid_file)){ ?>

                                              <br><input type="file" name="upload_emd_paid_file" id="upload_emd_paid_file" class="upload_emd_paid_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf"><span id="upload_emd_paid_file_error" style="font-size: 12px;color:#a94442;"></span>

                                              <a href="<?php echo base_url(); ?>uploads/emd_paid_document/<?php echo $project_data->upload_emd_paid_file; ?>" download>Download</a>

                                            <?php }else{ ?>

                                              <br><input type="file" name="upload_emd_paid_file" id="upload_emd_paid_file" class="upload_emd_paid_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" required><span id="upload_emd_paid_file_error" style="font-size: 12px;color:#a94442;"></span>

                                            <?php } ?>

                                          </div>

                                        </div>

                                        <div class="col-md-3">

                                          <div class="form-group">

                                            <label class="">Payment Mode <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <select class="form-control select2me" name="emd_payment_mode" id="emd_payment_mode">

                                              <option value="">Select</option>

                                              <option value="Bank Transfer" <?php echo (isset($project_data->emd_payment_mode) && !empty($project_data->emd_payment_mode) && ($project_data->emd_payment_mode=='Bank Transfer'))?'selected="selected"':'';?>>Bank Transfer</option>

                                              <option value="Fixed Deposit" <?php echo (isset($project_data->emd_payment_mode) && !empty($project_data->emd_payment_mode) && ($project_data->emd_payment_mode=='Fixed Deposit'))?'selected="selected"':'';?>>Fixed Deposit</option>

                                              <option value="Demand Draft" <?php echo (isset($project_data->emd_payment_mode) && !empty($project_data->emd_payment_mode) && ($project_data->emd_payment_mode=='Demand Draft'))?'selected="selected"':'';?>>Demand Draft</option>
                                              <option value="Bank Guarantee" <?php echo (isset($project_data->emd_payment_mode) && !empty($project_data->emd_payment_mode) && ($project_data->emd_payment_mode=='Bank Guarantee'))?'selected="selected"':'';?>>Bank Guarantee</option>

                                            </select>

                                          </div>

                                        </div>

                                        <div class="col-md-3" id="ccd_div"></div>

                                      </div>

                                    </div>

                                  <?php }else{ ?>

                                    <div id="ifemdpaiddiv" style="margin-bottom:10px;"></div>

                                  <?php } ?>

                                  <?php if(isset($project_data->asd_paid) && !empty($project_data->asd_paid) && $project_data->asd_paid=='Y'){ ?>

                                    <div id="ifasdpaiddiv" style="margin-bottom:10px;">

                                      <div class="row ifemdpaid">

                                        <div class="col-md-3">

                                          <div class="form-group">

                                            <label class="">ASD Amount <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <div class="input-icon right"><i class="fa"></i>

                                              <input type="number" class="form-control " name="asd_paid_num" id="asd_paid_num" placeholder="ASD Amount" value="<?php echo (isset($project_data->asd_paid_num) && !empty($project_data->asd_paid_num)) ? $project_data->asd_paid_num : '' ?>">

                                            </div>

                                          </div>

                                        </div>

                                        <div class="col-md-3">

                                          <div class="form-group">

                                            <label class="control-label">ASD Paid <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <div class="dflx">

                                              <input type="radio" name="asd_paid_status" id="asd_paid_status_yes" class="asd_paid_status_div" value="Yes" <?php echo (isset($project_data->asd_paid_status) && !empty($project_data->asd_paid_status) && $project_data->asd_paid_status == 'Y') ? 'checked=""': '' ?>>

                                              <span style="padding: 0 10px 0px 5px;">Yes</span>

                                              <input type="radio" name="asd_paid_status" id="asd_paid_status_no" class="asd_paid_status_div" value="No" <?php echo (isset($project_data->asd_paid_status) && !empty($project_data->asd_paid_status) && $project_data->asd_paid_status == 'N') ? 'checked=""': '' ?>>

                                              <span style="padding: 0 10px 0px 5px;">No</span>

                                            </div>

                                          </div>

                                        </div>

                                        <div class="col-md-3">

                                          <div class="form-group">

                                            <label class="control-label">Upload ASD Paid <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <?php if(isset($project_data->upload_asd_paid_file) && !empty($project_data->upload_asd_paid_file)){ ?>

                                              <br><input type="file" name="upload_asd_paid_file" id="upload_asd_paid_file" class="upload_asd_paid_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf"><span id="upload_emd_paid_file_error" style="font-size: 12px;color:#a94442;"></span>

                                              <a href="<?php echo base_url(); ?>uploads/asd_paid_document/<?php echo $project_data->upload_asd_paid_file; ?>" download>Download</a>

                                            <?php }else{ ?>

                                              <br><input type="file" name="upload_asd_paid_file" id="upload_asd_paid_file" class="upload_asd_paid_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" required><span id="upload_emd_paid_file_error" style="font-size: 12px;color:#a94442;"></span>

                                            <?php }?>

                                          </div>

                                        </div>

                                        <div class="col-md-3">

                                          <div class="form-group">

                                            <label class="">Payment Mode <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <select class="form-control select2me" name="asd_payment_mode" id="asd_payment_mode">

                                              <option value="">Select</option>

                                              <option value="Bank Transfer" <?php echo (isset($project_data->asd_payment_mode) && !empty($project_data->asd_payment_mode) && ($project_data->asd_payment_mode=='Bank Transfer'))?'selected="selected"':'';?>>Bank Transfer</option>
                                              <option value="Fixed Deposit" <?php echo (isset($project_data->asd_payment_mode) && !empty($project_data->asd_payment_mode) && ($project_data->asd_payment_mode=='Fixed Deposit'))?'selected="selected"':'';?>>Fixed Deposit</option>
                                              <option value="Demand Draft" <?php echo (isset($project_data->asd_payment_mode) && !empty($project_data->asd_payment_mode) && ($project_data->asd_payment_mode=='Demand Draft'))?'selected="selected"':'';?>>Demand Draft</option>
                                              <option value="Bank Guarantee" <?php echo (isset($project_data->asd_payment_mode) && !empty($project_data->asd_payment_mode) && ($project_data->asd_payment_mode=='Bank Guarantee'))?'selected="selected"':'';?>>Bank Guarantee</option>

                                            </select>

                                          </div>

                                        </div>

                                        <div class="col-md-3" id="asdccd_div"></div>

                                      </div>

                                    </div>

                                  <?php }else{ ?>

                                    <div id="ifasdpaiddiv" style="margin-bottom:10px;"></div>

                                  <?php } ?>

                                  <?php if(isset($project_data->performance_paid) && !empty($project_data->performance_paid) && $project_data->performance_paid=='Y'){ ?>

                                    <div id="ifperformancepaiddiv">

                                      <div class="row ifperformancepaid">

                                        <div class="col-md-3">

                                          <div class="form-group">

                                            <label class="">Performance Guarantee/Bond Amount <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <div class="input-icon right"><i class="fa"></i>

                                              <input type="number" class="form-control" name="performance_guarantee_num" id="performance_guarantee_num" placeholder="Performance Guarantee/Bond Amount" value="<?php echo (isset($project_data->performance_guarantee_num) && !empty($project_data->performance_guarantee_num)) ? $project_data->performance_guarantee_num : '' ?>">

                                            </div>

                                          </div>

                                        </div>

                                        <div class="col-md-3">

                                          <div class="form-group">

                                            <label class="control-label">Performance Guarantee/Bond Paid <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <div class="dflx">

                                              <input type="radio" name="per_paid_status" id="per_paid_status_yes" value="Yes" <?php echo (isset($project_data->per_paid_status) && !empty($project_data->per_paid_status) && $project_data->per_paid_status == 'Y') ? 'checked=""': '' ?>>

                                              <span style="padding: 0 10px 0px 5px;">Yes</span>

                                              <input type="radio" name="per_paid_status" id="per_paid_status_no" value="No" <?php echo (isset($project_data->per_paid_status) && !empty($project_data->per_paid_status) && $project_data->per_paid_status == 'N') ? 'checked=""': '' ?>>

                                              <span style="padding: 0 10px 0px 5px;">No</span>

                                            </div>

                                          </div>

                                        </div>

                                        <div class="col-md-3">

                                          <div class="form-group">

                                            <label class="">Performance Guarantee/Bond Validity (Months) <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <div class="input-icon right"><i class="fa"></i>

                                              <input type="number" class="form-control " name="pbg_validity" id="pbg_validity" placeholder="PBG Validity" value="<?php echo (isset($project_data->pbg_validity) && !empty($project_data->pbg_validity)) ? $project_data->pbg_validity : '' ?>">

                                            </div>

                                          </div>

                                        </div>

                                        <div class="col-md-3">

                                          <div class="form-group">

                                            <label class="">Payment Mode <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <select class="form-control select2me" name="per_payment_mode" id="per_payment_mode">

                                              <option value="">Select</option>

                                              <option value="bank_transder" <?php echo (isset($project_data->per_payment_mode) && !empty($project_data->per_payment_mode) && ($project_data->per_payment_mode=='bank_transder'))?'selected="selected"':'';?>>Bank Transfer</option>

                                              <option value="fixed_deposite" <?php echo (isset($project_data->per_payment_mode) && !empty($project_data->per_payment_mode) && ($project_data->per_payment_mode=='fixed_deposite'))?'selected="selected"':'';?>>Fixed Deposit</option>

                                              <option value="demand_draft" <?php echo (isset($project_data->per_payment_mode) && !empty($project_data->per_payment_mode) && ($project_data->per_payment_mode=='demand_draft'))?'selected="selected"':'';?>>Demand Draft</option>

                                              <option value="bank_guarantee" <?php echo (isset($project_data->per_payment_mode) && !empty($project_data->per_payment_mode) && ($project_data->per_payment_mode=='bank_guarantee'))?'selected="selected"':'';?>>Bank Guarantee</option>
                                              <option value="other" <?php echo (isset($project_data->per_payment_mode) && !empty($project_data->per_payment_mode) && ($project_data->per_payment_mode=='other'))?'selected="selected"':'';?>>Other</option>
                                              <option value="remark" <?php echo (isset($project_data->per_payment_mode) && !empty($project_data->per_payment_mode) && ($project_data->per_payment_mode=='remark'))?'selected="selected"':'';?>>Remark</option>

                                            </select>

                                          </div>

                                        </div>

                                      </div>

                                    </div>

                                    <div id="apperdi">

                                      <div class="row">

                                        <div class="col-md-3 ifperformancepaid">

                                          <div class="form-group">

                                            <label class="control-label">Upload Draft Bond Document <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <?php if(isset($project_data->draft_performance_paid_file) && !empty($project_data->draft_performance_paid_file)){ ?>

                                              <br><input type="file" name="draft_performance_paid_file" id="draft_performance_paid_file" class="draft_performance_paid_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">

                                              <a href="<?php echo base_url(); ?>uploads/performance_gaurantee_document/<?php echo $project_data->draft_performance_paid_file; ?>" download>Download</a>

                                            <?php }else{ ?>

                                              <br><input type="file" name="draft_performance_paid_file" id="draft_performance_paid_file" class="draft_performance_paid_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" required>

                                            <?php } ?>

                                          </div>

                                        </div>

                                        <div class="col-md-3 ifperformancepaid">

                                          <div class="form-group">

                                            <label class="control-label">Upload Final Bond Document</label>

                                            <br><input type="file" name="final_performance_paid_file" id="final_performance_paid_file" class="final_performance_paid_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">

                                            <span id="final_performance_paid_file_error" style="font-size: 12px;color:#a94442;"></span>

                                            <?php if(isset($project_data->final_performance_paid_file) && !empty($project_data->final_performance_paid_file)){ ?>

                                              <a href="<?php echo base_url(); ?>uploads/performance_gaurantee_document/<?php echo $project_data->final_performance_paid_file; ?>" download>Download</a>

                                            <?php } ?>

                                          </div>

                                        </div>

                                        <div class="col-md-3">

                                          <div class="form-group">

                                            <label class="">PG Amount <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <div class="input-icon right"><i class="fa"></i>

                                              <input type="number" class="form-control " name="pg_amount" id="pg_amount" placeholder="PG Amount" value="<?php echo (isset($project_data->pg_amount) && !empty($project_data->pg_amount)) ? $project_data->pg_amount : '' ?>">

                                            </div>

                                          </div>

                                        </div>

                                        <?php if(isset($project_data->per_payment_mode) && !empty($project_data->per_payment_mode) && $project_data->per_payment_mode == 'bank_guarantee'){ ?>

                                          <div class="col-md-3" id="sd_pbg_fd">

                                            <div class="form-group">

                                              <label class="">Form of PG <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                              <div class="input-icon right"><i class="fa"></i>

                                                <input type="text" class="form-control " name="sd_pbg_fd" id="sd_pbg_fd" placeholder="PBG/FD/DD/ONLINE" value="<?php echo (isset($project_data->sd_pbg_fd) && !empty($project_data->sd_pbg_fd)) ? $project_data->sd_pbg_fd : '' ?>">

                                              </div>

                                            </div>

                                          </div>

                                        <?php } ?>

                                      </div>

                                    </div>

                                  <?php }else{ ?>

                                    <div id="ifperformancepaiddiv"></div>

                                  <?php } ?>

                                  <div id="apperdi"></div>

                                  <div class="row">

                                    <div class="col-md-3">

                                      <div class="form-group">

                                        <label class="">Security Deposit Retention(%) <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <input type="text" class="form-control " name="security_deposite_num" id="security_deposite_num" data-id="sec_deposite" id="security_deposite_num" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($project_data->security_deposite_num) && !empty($project_data->security_deposite_num)) ? $project_data->security_deposite_num : '' ?>" placeholder="Security Deposite Retention(%)">

                                        </div>

                                      </div>

                                    </div>

                                    <div class="col-md-3">

                                      <div class="form-group">

                                        <label class="">Warranty Period <br> (Months) <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <input type="text" class="form-control " name="warranty_period" data-id="warranty_period" id="warranty_period" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($project_data->warranty_period) && !empty($project_data->warranty_period)) ? $project_data->warranty_period : '' ?>" placeholder="Warranty Period">

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

                                        <label class="">Billing Related <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <input type="text" class="form-control" name="billing_related" id="billing_related" value="<?php echo (isset($project_data->billing_related) && !empty($project_data->billing_related)) ? $project_data->billing_related : '' ?>" placeholder="Billing Related">

                                        </div>

                                      </div>

                                    </div>

                                    <div class="col-md-6">

                                      <div class="form-group">

                                        <label class="">PO Related <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <input type="text" class="form-control " name="po_related" id="po_related" value="<?php echo (isset($project_data->po_related) && !empty($project_data->po_related)) ? $project_data->po_related : '' ?>" placeholder="PO Related">

                                        </div>

                                      </div>

                                    </div>

                                  </div>

                                  <div class="row">

                                    <div class="col-md-6">

                                      <div class="form-group">

                                        <label class="">Execution Related <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <input type="text" class="form-control" name="execution_related" id="execution_related" value="<?php echo (isset($project_data->execution_related) && !empty($project_data->execution_related)) ? $project_data->execution_related : '' ?>" placeholder="Execution Related">

                                        </div>

                                      </div>

                                    </div>

                                    <div class="col-md-6">

                                      <div class="form-group">

                                        <label class="">Engineer In-charge <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <input type="text" class="form-control " name="engineer_in_charge" id="engineer_in_charge" value="<?php echo (isset($project_data->engineer_in_charge) && !empty($project_data->engineer_in_charge)) ? $project_data->engineer_in_charge : '' ?>" placeholder="Engineer In-charge">

                                        </div>

                                      </div>

                                    </div>

                                  </div>

                                  <div class="row">

                                    <div class="col-md-6">

                                      <div class="form-group">

                                        <label class="">Completion Period (Months) <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <input type="text" class="form-control" name="completion_period" id="completion_period" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($project_data->completion_period) && !empty($project_data->completion_period)) ? $project_data->completion_period : '' ?>" placeholder="Completion Period">

                                        </div>

                                      </div>

                                    </div>

                                    <div class="col-md-6">

                                      <div class="form-group">

                                        <label class="">Client GST No <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="input-icon right">

                                          <i class="fa"></i>

                                          <input type="text" class="form-control " name="gst_no" id="gst_no" value="<?php echo (isset($project_data->gst_no) && !empty($project_data->gst_no)) ? $project_data->gst_no : '' ?>" placeholder="Client GST No">

                                        </div>

                                      </div>

                                    </div>

                                  </div>

                                  <div class="row">

                                    <div class="col-md-6">

                                      <div class="form-group">

                                        <label class="">Price inclusive of AMC <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="dflx">

                                          <input type="radio" name="price_inslusive_of_amc" id="price_inslusive_of_amc_yes" value="Yes" <?php echo (isset($project_data->price_inslusive_of_amc) && !empty($project_data->price_inslusive_of_amc) && $project_data->price_inslusive_of_amc == 'Y') ? 'checked=""': '' ?>><span style="padding: 0 10px 0px 5px;">Yes</span>

                                          <input type="radio" name="price_inslusive_of_amc" id="price_inslusive_of_amc_no" value="No" <?php echo (isset($project_data->price_inslusive_of_amc) && !empty($project_data->price_inslusive_of_amc) && $project_data->price_inslusive_of_amc == 'N') ? 'checked=""': '' ?>><span style="padding: 0 10px 0px 5px;">No</span>

                                        </div>

                                      </div>

                                    </div>

                                    <div class="col-md-6">

                                      <div class="form-group">

                                        <label class="">Is billing Inter-State <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                        <div class="dflx">

                                          <input type="radio" name="is_billing_inter_state" id="is_billing_inter_state_yes" value="Yes" <?php echo (isset($project_data->is_billing_inter_state) && !empty($project_data->is_billing_inter_state) && $project_data->is_billing_inter_state == 'Y') ? 'checked=""': '' ?>><span style="padding: 0 10px 0px 5px;">Yes</span>

                                          <input type="radio" name="is_billing_inter_state" id="is_billing_inter_state_no" value="No" <?php echo (isset($project_data->is_billing_inter_state) && !empty($project_data->is_billing_inter_state) && $project_data->is_billing_inter_state == 'N') ? 'checked=""': '' ?>><span style="padding: 0 10px 0px 5px;">No</span>

                                        </div>

                                      </div>

                                    </div>

                                  </div>

                                  <div class="row ifpros">

                                    <?php if(isset($project_data->is_billing_inter_state) && !empty($project_data->is_billing_inter_state) && $project_data->is_billing_inter_state == 'Y'){ ?>

                                      <!--<div class="col-md-6 ifinterstateYes">-->

                                      <!--    <div class="form-group billingaddrsdiv">-->

                                      <!--        <label class="">Billing Address <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>-->

                                      <!--        <div class="input-icon right"><i class="fa"></i>-->

                                      <!--        <textarea rows="2" type="text" class="form-control" name="billing_address" id="billing_address" placeholder="Billing Address"><?php echo (isset($project_data->billing_address) && !empty($project_data->billing_address)) ? $project_data->billing_address : '' ?></textarea>-->

                                      <!--    </div>-->

                                      <!--    <div class="dflx">-->

                                      <!--        <input type="checkbox" name="bill_same_as_reg_addr" id="bill_same_as_reg_addr" value="checked">-->

                                      <!--        <label class="" style="padding:0 5px;font-size: 12px;">Same as Registered Address</label>-->

                                      <!--    </div><span class="billingaddrserror" style="font-size: 11px;color: #a94442;"></span>-->

                                      <!--    </div>-->

                                      <!--</div>-->

                                      <div class="col-md-6 ifinterstateYes">

                                        <div class="form-group billingaddrsdiv">

                                          <label class="">Billing Address <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                          <div class="input-icon right"><i class="fa"></i>

                                            <textarea rows="2" type="text" class="form-control" name="billing_address" id="billing_address" placeholder="Billing Address" <?php echo (isset($project_data->bill_same_as_reg_addr) && !empty($project_data->bill_same_as_reg_addr) && $project_data->bill_same_as_reg_addr == 'checked') ? 'readonly' : ''; ?>><?php echo (isset($project_data->billing_address) && !empty($project_data->billing_address)) ? $project_data->billing_address : '' ?></textarea>

                                          </div>

                                          <div class="dflx">

                                            <!-- <input type="checkbox" name="bill_same_as_reg_addr" id="bill_same_as_reg_addr" value="checked"> -->

                                            <input type="checkbox" name="bill_same_as_reg_addr" id="bill_same_as_reg_addr" value="<?php echo $project_data->bill_same_as_reg_addr;?>" <?php echo (isset($project_data->bill_same_as_reg_addr) && !empty($project_data->bill_same_as_reg_addr) && $project_data->bill_same_as_reg_addr == 'checked') ? 'checked' : ''; ?>>

                                            <label class="" style="padding:0 5px;font-size: 12px;">Same as Registered Address</label>

                                          </div><span class="billingaddrserror" style="font-size: 11px;color: #a94442;"></span>

                                        </div>

                                      </div>

                                    <?php } ?>

                                    <?php if(isset($project_data->price_inslusive_of_amc) && !empty($project_data->price_inslusive_of_amc) && $project_data->price_inslusive_of_amc == 'Y'){ ?>

                                      <div class="col-md-6 ifpriceAMCYes">

                                        <div class="form-group">

                                          <label class="">AMC Applicable After (Months) <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                          <div class="input-icon right"><i class="fa"></i>

                                            <input type="number" class="form-control" name="amc_applicable_after" id="amc_applicable_after" placeholder="AMC applicable after " value="<?php echo (isset($project_data->amc_applicable_after) && !empty($project_data->amc_applicable_after)) ? $project_data->amc_applicable_after : '' ?>">

                                          </div>

                                        </div>

                                      </div>

                                    <?php } ?>

                                  </div>

                                  <div class="row">

                                    <div class="col-md-12">

                                      <label class="" style="font-size:14px;font-weight:600;">Consignee Details </label>

                                      <p id="consignee_error" style="color: #a94442;"></p>

                                    </div>

                                  </div>

                                  <div id="consineeDetailDisplayed"></div>

                                  <?php if(isset($consignee_data) && !empty($consignee_data)){ ?>

                                    <?php $i=0;foreach($consignee_data as $key){ ?>

                                      <div class="row">

                                        <div class="col-md-4">

                                          <div class="form-group">

                                            <label class="">Consignee Name <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <div class="input-icon right"><i class="fa"></i>

                                              <input type="text" class="form-control" name="consignee_name[]" id="consignee_name<?php echo $i;?>" placeholder="Consignee Name" value="<?php echo (isset($key->consignee_name) && !empty($key->consignee_name)) ? $key->consignee_name : '' ?>">

                                            </div>

                                          </div>

                                        </div>

                                        <div class="col-md-4">

                                          <div class="form-group">

                                            <label class="">Delivery Address <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <div class="input-icon right"><i class="fa"></i>

                                              <textarea type="text" class="form-control" name="delivery_address[]" id="delivery_address<?php echo $i;?>" placeholder="Delivery Address"><?php echo (isset($key->delivery_address) && !empty($key->delivery_address)) ? $key->delivery_address : '' ?></textarea>

                                            </div>

                                          </div>

                                        </div>

                                        <div class="col-md-3">

                                          <div class="form-group">

                                            <label class="">GST Number <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <div class="input-icon right"><i class="fa"></i>

                                              <input type="text" class="form-control" name="gst_types[]" id="gst_types<?php echo $i;?>" placeholder="GST Number" value="<?php echo (isset($key->gst_number) && !empty($key->gst_number)) ? $key->gst_number : '' ?>">

                                            </div>

                                          </div>

                                        </div>

                                        <?php if($i==0){ ?>

                                          <div class="col-md-1">

                                            <div class="add_consignee"><i class="fa fa-plus" aria-hidden="true"  style="font-size:10px;"></i></div>

                                          </div>

                                        <?php }else{ ?>

                                          <div class="col-md-1">

                                            <div class="rmbtnss"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>

                                          </div>

                                        <?php } ?>

                                      </div>

                                      <?php $i++;} ?>

                                    <?php }else{ ?>

                                      <div class="row">

                                        <div class="col-md-4">

                                          <div class="form-group">

                                            <label class="">Consignee Name <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <div class="input-icon right"><i class="fa"></i>

                                              <input type="text" class="form-control" name="consignee_name[]" id="consignee_name0" placeholder="Consignee Name">

                                            </div>

                                          </div>

                                        </div>

                                        <div class="col-md-4">

                                          <div class="form-group">

                                            <label class="">Delivery Address <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <div class="input-icon right"><i class="fa"></i>

                                              <textarea type="text" class="form-control" name="delivery_address[]" id="delivery_address0" placeholder="Delivery Address"></textarea>

                                            </div>

                                          </div>

                                        </div>

                                        <div class="col-md-3">

                                          <div class="form-group">

                                            <label class="">GST Number <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <div class="input-icon right"><i class="fa"></i>

                                              <input type="text" class="form-control" name="gst_types[]" id="gst_types0" placeholder="GST Number">

                                            </div>

                                          </div>

                                        </div>

                                        <div class="col-md-1">

                                          <div class="add_consignee"><i class="fa fa-plus" aria-hidden="true"  style="font-size:10px;"></i></div>

                                        </div>

                                      </div>

                                    <?php } ?>

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

                                          <label class="">Insurance Required <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                          <div class="dflx">

                                            <input type="radio" name="insurance_req" id="insurance_yes" value="Yes" <?php echo (isset($project_data->insurance_req) && !empty($project_data->insurance_req) && $project_data->insurance_req == 'Y') ? 'checked=""': '' ?>><span style="padding: 0 10px 0px 5px;">Yes</span>

                                            <input type="radio" name="insurance_req" id="insurance_no" value="No" <?php echo (isset($project_data->insurance_req) && !empty($project_data->insurance_req) && $project_data->insurance_req == 'N') ? 'checked=""': '' ?>><span style="padding: 0 10px 0px 5px;">No</span>

                                          </div>

                                        </div>

                                      </div>

                                    </div>

                                    <span id="insurance_req_err" style="font-size:12px;color:#a94442;"></span>

                                    <div class="insurancereqdiv" id="insurancereqdiv">

                                      <?php if(isset($project_data->insurance_req) && !empty($project_data->insurance_req) && $project_data->insurance_req == 'Y'){ ?>

                                        <div class="row dflxd insurance_req_div">

                                          <div class="col-md-6">

                                            <div class="form-group">

                                              <label class="">Insurance Details <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                              <div class="input-icon right"><i class="fa"></i>

                                                <textarea rows="2" type="text" class="form-control" name="insurance_remark[]" id="insurance_remark1" placeholder="Insurance Details"></textarea>

                                              </div>

                                            </div>

                                          </div>

                                          <div class="col-md-3">

                                            <div class="form-group">

                                              <label class="">Insurance up to <br> which date <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                              <div class="input-icon right"><i class="fa"></i>

                                                <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-viewmode="years">

                                                  <input type="text" name="insurance_up_to_date[]" id="insurance_up_to_date1" class="form-control" placeholder="dd-mm-yyyy" readonly="">

                                                  <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>

                                                </div>

                                              </div>

                                            </div>

                                          </div>

                                          <div class="col-md-3">

                                            <div class="form-group"><label class="">Amount Of Risk <br> Coverage <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                              <div class="input-icon right"><i class="fa"></i>

                                                <input type="number" class="form-control " name="amount_of_risk_cov[]" id="amount_of_risk_cov1" placeholder="Amount Of Risk Coverage">

                                              </div>

                                            </div>

                                          </div>

                                          <div class="col-md-3">

                                            <div class="form-group"><label class="">Upload Insurance <br> Documment</label>

                                              <input type="file" name="insurance_required_doc[]" id="insurance_required_doc1" class="insurance_required_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">

                                            </div>

                                          </div>

                                          <div class="col-md-1">

                                            <div class="adbtn"><i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i></div>

                                          </div>

                                        </div>

                                      <?php } ?>

                                    </div>

                                    <div id="nsuranceRequiredApp">

                                      <?php if(isset($insurance_data) && !empty($insurance_data)){ ?>

                                        <?php foreach($insurance_data as $key){ ?>

                                          <div class="row dflxd">

                                            <div class="col-md-6">

                                              <div class="form-group">

                                                <div class="input-icon right"><i class="fa"></i>

                                                  <textarea type="text" class="form-control " name="insurance_remark[]" id="insurance_remark3" readonly="">Insurance Details *</textarea>

                                                </div>

                                              </div>

                                            </div>

                                            <div class="col-md-3">

                                              <div class="form-group">

                                                <input type="text" class="form-control " name="insurance_up_to_date[]" id="insurance_up_to_date3" value="04-08-2023" readonly="">

                                              </div>

                                            </div>

                                            <div class="col-md-3">

                                              <div class="form-group">

                                                <div class="input-icon right"><i class="fa"></i>

                                                  <input type="text" class="form-control " name="amount_of_risk_cov[]" id="amount_of_risk_cov3" placeholder="Amount Of Risk Coverage" value="12" readonly="">

                                                </div>

                                              </div>

                                            </div>

                                            <div class="col-md-3">

                                              <div class="form-group">

                                                <input type="file" name="insurance_required_doc[]" id="insurance_required_doc3" class="insurance_required_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" value="C:\fakepath\PI-1_PROFORMA_INVOICE_FORMAR_1 (1).xls">

                                              </div>

                                            </div>

                                            <div class="col-md-1">

                                              <div class="rmbtn">

                                                <i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i>

                                              </div>

                                            </div>

                                          </div>

                                        <?php } ?>

                                      <?php } ?>

                                    </div>

                                    <div class="row agreementprepared">

                                      <div class="col-md-5">

                                        <div class="form-group">

                                          <label class="">Agreement Prepared <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                          <div class="dflx">

                                            <input type="radio" name="agreement_prepared" id="agreement_prepared_yes" value="Yes" <?php echo (isset($project_data->agreement_prepared) && !empty($project_data->agreement_prepared) && $project_data->agreement_prepared == 'Y') ? 'checked=""': '' ?>><span style="padding: 0 10px 0px 5px;">Yes</span>

                                            <input type="radio" name="agreement_prepared" id="agreement_prepared_no" value="No" <?php echo (isset($project_data->agreement_prepared) && !empty($project_data->agreement_prepared) && $project_data->agreement_prepared == 'N') ? 'checked=""': '' ?>><span style="padding: 0 10px 0px 5px;">No</span>

                                          </div>

                                        </div>

                                      </div>

                                      <?php if(isset($project_data->agreement_prepared) && !empty($project_data->agreement_prepared) && $project_data->agreement_prepared == 'Y'){ ?>

                                        <div class="col-md-3 aggupload">

                                          <div class="form-group">

                                            <label class="control-label">Draft Agreement Document Upload <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                            <?php if(isset($project_data->draft_doc_file) && !empty($project_data->draft_doc_file)){ ?>

                                              <br><input type="file" name="upload_draft_doc_file" id="upload_draft_doc_file" class="upload_draft_doc_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">

                                              <a href="<?php echo base_url(); ?>uploads/agreement_prepared/<?php echo $project_data->draft_doc_file; ?>" download>Download</a>

                                            <?php }else{ ?>

                                              <br><input type="file" name="upload_draft_doc_file" id="upload_draft_doc_file" class="upload_draft_doc_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" required>

                                            <?php } ?>


                                          </div>

                                        </div>

                                        <div class="col-md-3 aggupload">

                                          <div class="form-group">

                                            <label class="control-label">Signed Agreement Document Upload</label>

                                            <br><input type="file" name="upload_sign_doc_file" id="upload_sign_doc_file" class="upload_sign_doc_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">

                                            <span id="upload_sign_doc_file_error" style="font-size: 12px;color:#a94442;"></span>

                                            <?php if(isset($project_data->sign_doc_file) && !empty($project_data->sign_doc_file)){ ?>

                                              <a href="<?php echo base_url(); ?>uploads/agreement_prepared/<?php echo $project_data->sign_doc_file; ?>" download>Download</a>

                                            <?php } ?>

                                          </div>

                                        </div>

                                      <?php } ?>
                                      <input type="hidden" name="hidden_upload_sign_doc_file" value="<?php echo $project_data->sign_doc_file; ?>">

                                    </div>

                                    <div class="row">

                                      <div class="col-md-6">

                                        <div class="form-group">

                                          <label class="">Penalty Clause <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                          <div class="input-icon right">

                                            <i class="fa"></i>

                                            <textarea rows="2" type="text" class="form-control" name="penalty_clause" id="penalty_clause" placeholder="Penalty Clause"><?php echo (isset($project_data->penalty_clause) && !empty($project_data->penalty_clause)) ? $project_data->penalty_clause : '' ?></textarea>

                                          </div>

                                        </div>

                                      </div>

                                      <div class="col-md-6">

                                        <div class="form-group">

                                          <label class="control-label">Upload Penalty Clause</label><br>

                                          <input type="file" name="penalty_clause_file" id="penalty_clause_file" class="penalty_clause_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />

                                          <span id="penalty_clause_file_error" style="font-size: 12px;color:#a94442;"></span>

                                          <?php if(isset($project_data->penalty_clause_file) && !empty($project_data->penalty_clause_file)){ ?>

                                            <a href="<?php echo base_url(); ?>uploads/document_upload/<?php echo $project_data->penalty_clause_file; ?>" download>Download</a>

                                          <?php } ?>

                                        </div>

                                      </div>

                                    </div>

                                    <div class="row">

                                      <div class="col-md-6">

                                        <div class="form-group">

                                          <label class="">Power of Attorney <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                          <div class="input-icon right">

                                            <i class="fa"></i>

                                            <textarea rows="2" type="text" class="form-control" name="power_of_attorney" id="power_of_attorney" placeholder="Power of Attorney"><?php echo (isset($project_data->power_of_attorney) && !empty($project_data->power_of_attorney)) ? $project_data->power_of_attorney : '' ?></textarea>

                                          </div>

                                        </div>

                                      </div>

                                      <div class="col-md-6">

                                        <div class="form-group">

                                          <label class="control-label">Upload Power of Attorney</label><br>

                                          <input type="file" name="power_of_attorney_file" id="power_of_attorney_file" class="power_of_attorney_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />

                                          <span id="power_of_attorney_file_error" style="font-size: 12px;color:#a94442;"></span>

                                          <?php if(isset($project_data->power_of_attorney_file) && !empty($project_data->power_of_attorney_file)){ ?>

                                            <a href="<?php echo base_url(); ?>uploads/document_upload/<?php echo $project_data->power_of_attorney_file; ?>" download>Download</a>

                                          <?php } ?>

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

                                          <input type="checkbox" name="sample" id="sample" value="Y" <?php echo (isset($project_data->sample) && !empty($project_data->sample) && ($project_data->sample == 'Y')) ? 'checked' : '' ?>> <label class="" style="padding:0 5px;">Sample </label>

                                        </div>

                                      </div>

                                      <div class="col-md-2">

                                        <div class="form-group dflx">

                                          <input type="checkbox" name="prototype" id="prototype" value="Y" <?php echo (isset($project_data->prototype) && !empty($project_data->prototype) && ($project_data->prototype == 'Y')) ? 'checked' : '' ?>> <label class="" style="padding:0 5px;">Prototype</label>

                                        </div>

                                      </div>

                                      <div class="col-md-2">

                                        <div class="form-group dflx">

                                          <input type="checkbox" name="inspection" id="inspection" value="Y" <?php echo (isset($project_data->inspection) && !empty($project_data->inspection) && ($project_data->inspection == 'Y')) ? 'checked' : '' ?>> <label class="" style="padding:0 5px;">Inspection </label>

                                        </div>

                                      </div>

                                      <div class="col-md-2">

                                        <div class="form-group dflx">

                                          <input type="checkbox" name="fat" id="fat" value="Y" <?php echo (isset($project_data->fat) && !empty($project_data->fat) && ($project_data->fat == 'Y')) ? 'checked' : '' ?>> <label class="" style="padding:0 5px;">FAT</label>

                                        </div>

                                      </div>

                                      <div class="col-md-2">

                                        <div class="form-group dflx">

                                          <input type="checkbox" name="sat" id="sat" value="Y" <?php echo (isset($project_data->sat) && !empty($project_data->sat) && ($project_data->sat == 'Y')) ? 'checked' : '' ?>> <label class="" style="padding:0 5px;">SAT</label>

                                        </div>

                                      </div>
                                      <div class="col-md-2">
                                        <div class="form-group dflx">
                                          <input type="checkbox" name="test_report" id="test_report" value="Y" <?php echo (isset($project_data->test_report) && !empty($project_data->test_report) && ($project_data->test_report == 'Y')) ? 'checked' : '' ?>> <label class="" style="padding:0 5px;">Test Report</label>
                                        </div>
                                      </div>

                                    </div>

                                    <div id="didetlsa">

                                      <?php if(isset($project_data->sample) && !empty($project_data->sample) && $project_data->sample == 'Y'){ ?>

                                        <?php if(isset($sample_data) && !empty($sample_data)){ ?>

                                          <hr style="margin: 15px 0;">

                                          <?php $i=1;foreach($sample_data as $key){ ?>

                                            <div class="row dvsample">

                                              <div class="col-md-4">

                                                <?php if($i==1){ ?>

                                                  <label class="">Sample </label>

                                                  <span id="appsamplederror" style="font-size:12px;color:#a94442;"></span>

                                                <?php } ?>

                                              </div>

                                              <div class="col-md-8">

                                                <div style="display:flex;">

                                                  <div class="form-group" style="width: 90%;">

                                                    <div class="input-icon right"><i class="fa"></i>

                                                      <input type="hidden" id="smcnt" value="<?php echo count($sample_data); ?>">

                                                      <input type="text" class="form-control" name="sample_text[]" id="sample_text<?php echo $i; ?>" value="<?php echo (isset($key->sample) && !empty($key->sample)) ? $key->sample : '' ?>" placeholder="Sample">

                                                    </div>

                                                  </div>

                                                  <?php if($i==1){ ?>

                                                    <div class="" style="width: 10%;">

                                                      <div class="adsamplebtn">

                                                        <i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i>

                                                      </div>

                                                    </div>

                                                  <?php }else{ ?>

                                                    <div class="" style="width: 10%;">

                                                      <div class="rmsamplebtn" data-id="<?php echo $i; ?>">

                                                        <i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i>

                                                      </div>

                                                    </div>

                                                  <?php } ?>

                                                </div>

                                              </div>

                                            </div>

                                            <?php $i++;} ?>

                                            <div class="adsampled" id="adsampled"></div>

                                          <?php } ?>

                                        <?php } ?>

                                        <?php if(isset($project_data->prototype) && !empty($project_data->prototype) && $project_data->prototype == 'Y'){ ?>

                                          <?php if(isset($prototype_data) && !empty($prototype_data)){ ?>

                                            <hr style="margin: 15px 0;">

                                            <?php $i=1;foreach($prototype_data as $key){ ?>

                                              <div class="row dvprototype">

                                                <div class="col-md-4">

                                                  <?php if($i==1){ ?>

                                                    <label class="">Prototype </label>

                                                    <span id="adprotoderror" style="font-size:12px;color:#a94442;"></span>

                                                  <?php } ?>

                                                </div>

                                                <div class="col-md-8">

                                                  <div style="display:flex;">

                                                    <div class="form-group" style="width: 90%;">

                                                      <div class="input-icon right"><i class="fa"></i>

                                                        <input type="hidden" id="prcnt" value="<?php echo count($prototype_data); ?>">

                                                        <input type="text" class="form-control" name="prototype_text[]" id="prototype_text<?php echo $i; ?>" placeholder="Prototype" value="<?php echo (isset($key->prototype) && !empty($key->prototype)) ? $key->prototype : '' ?>">

                                                      </div>

                                                    </div>

                                                    <?php if($i==1){ ?>

                                                      <div class="" style="width: 10%;">

                                                        <div class="adsprotobtn"><i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i></div>

                                                      </div>

                                                    <?php }else{ ?>

                                                      <div class="rmprotobtn" data-id="<?php echo $i; ?>"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>

                                                    <?php } ?>

                                                  </div>

                                                </div>

                                              </div>

                                              <?php $i++;} ?>

                                              <div class="adprotod" id="adprotod"></div>

                                            <?php } ?>

                                          <?php } ?>

                                          <?php if(isset($project_data->inspection) && !empty($project_data->inspection) && $project_data->inspection == 'Y'){ ?>

                                            <?php if(isset($inspection_data) && !empty($inspection_data)){ ?>

                                              <hr style="margin: 15px 0;">

                                              <?php $i=1;foreach($inspection_data as $key){ ?>

                                                <div class="row dvinspectiontype">

                                                  <div class="col-md-4">

                                                    <?php if($i==1){ ?>

                                                      <label class="">Inspection </label>

                                                      <span id="adinspecerror" style="font-size:12px;color:#a94442;"></span>

                                                    <?php } ?>

                                                  </div>

                                                  <div class="col-md-8">

                                                    <div style="display:flex;">

                                                      <div class="form-group" style="width: 90%;">

                                                        <div class="input-icon right"><i class="fa"></i>

                                                          <input type="hidden" id="smcnt" value="<?php echo count($inspection_data); ?>">

                                                          <input type="text" class="form-control" name="inspection_text[]" id="inspection_text<?php echo $i; ?>" placeholder="Inspection" value="<?php echo (isset($key->inspection) && !empty($key->inspection)) ? $key->inspection : '' ?>">

                                                        </div>

                                                      </div>

                                                      <?php if($i==1){ ?>

                                                        <div class="" style="width: 10%;">

                                                          <div class="adinspectionbtn">

                                                            <i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i>

                                                          </div>

                                                        </div>

                                                      <?php }else{ ?>

                                                        <div class="" style="width: 10%;">

                                                          <div class="rminspectionbtn" data-id="<?php echo $i; ?>"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>

                                                        </div>

                                                      <?php } ?>

                                                    </div>

                                                  </div>

                                                </div>

                                                <?php $i++;} ?>

                                                <div class="adinspectiond" id="adinspectiond"></div>

                                              <?php } ?>

                                            <?php } ?>

                                            <?php if(isset($project_data->fat) && !empty($project_data->fat) && $project_data->fat == 'Y'){ ?>

                                              <?php if(isset($fat_data) && !empty($fat_data)){ ?>

                                                <hr style="margin: 15px 0;">

                                                <?php $i=1;foreach($fat_data as $key){ ?>

                                                  <div class="row dvfat">

                                                    <div class="col-md-4">

                                                      <?php if($i==0){ ?>

                                                        <label class="">FAT </label>

                                                        <span id="appfatderror" style="font-size:12px;color:#a94442;"></span>

                                                      <?php } ?>

                                                    </div>

                                                    <div class="col-md-8">

                                                      <div style="display:flex;">

                                                        <div class="form-group" style="width: 90%;">

                                                          <div class="input-icon right"><i class="fa"></i>

                                                            <input type="hidden" id="prcnt" value="<?php echo count($fat_data); ?>">

                                                            <input type="text" class="form-control" name="fat_text[]" id="fat_text<?php echo $i; ?>" placeholder="FAT" value="<?php echo (isset($key->fat) && !empty($key->fat)) ? $key->fat : '' ?>">

                                                          </div>

                                                        </div>

                                                        <?php if($i==0){ ?>

                                                          <div class="" style="width: 10%;">

                                                            <div class="adfatbtn">

                                                              <i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i>

                                                            </div>

                                                          </div>

                                                        <?php }else{ ?>

                                                          <div class="" style="width: 10%;">

                                                            <div class="rmfatbtn" data-id="<?php echo $i; ?>"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>

                                                          </div>

                                                        <?php } ?>

                                                      </div>

                                                    </div>

                                                  </div>

                                                  <?php $i++; } ?>

                                                <?php } ?>

                                                <div class="appfatd" id="appfatd"></div>

                                              <?php } ?>

                                              <?php if(isset($project_data->sat) && !empty($project_data->sat) && $project_data->sat == 'Y'){ ?>

                                                <?php if(isset($sat_data) && !empty($sat_data)){ ?>

                                                  <hr style="margin: 15px 0;">

                                                  <?php $i=1;foreach($sat_data as $key){ ?>

                                                    <div class="row dvsat">

                                                      <div class="col-md-4">

                                                        <?php if($i==1){ ?>

                                                          <label class="">SAT </label>

                                                          <span id="appsatderror" style="font-size:12px;color:#a94442;"></span>

                                                        <?php } ?>

                                                      </div>

                                                      <div class="col-md-8">

                                                        <div style="display:flex;">

                                                          <div class="form-group" style="width: 90%;">

                                                            <div class="input-icon right"><i class="fa"></i>

                                                              <input type="hidden" id="stcnt" value="<?php echo count($sat_data); ?>">

                                                              <input type="text" class="form-control" name="sat_text[]" id="sat_text<?php echo $i; ?>" placeholder="SAT" value="<?php echo (isset($key->sat) && !empty($key->sat)) ? $key->sat : '' ?>">

                                                            </div>

                                                          </div>

                                                          <?php if($i==1){ ?>

                                                            <div class="" style="width: 10%;">

                                                              <div class="adsatbtn"><i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i></div>

                                                            </div>

                                                          <?php }else{ ?>

                                                            <div class="" style="width: 10%;">

                                                              <div class="rmsatbtn" data-id="<?php echo $i; ?>"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>

                                                            </div>

                                                          <?php } ?>

                                                        </div>

                                                      </div>

                                                    </div>

                                                    <?php $i++;} ?>

                                                    <div class="appsatd" id="appsatd"></div>

                                                  <?php } ?>

                                                <?php } ?>

                                                <?php
                                                // pr($project_data->test_report);
                                                 if(isset($project_data->test_report) && !empty($project_data->test_report) && $project_data->test_report == 'Y'){ ?>

                                                  <?php if(isset($test_report_data) && !empty($test_report_data)){ ?>

                                                    <hr style="margin: 15px 0;">

                                                    <?php $i=1; foreach($test_report_data as $key){ ?>

                                                      <div class="row dvtest_report">

                                                        <div class="col-md-4">

                                                          <?php if($i==1){ ?>

                                                            <label class="">Test Report</label>

                                                            <span id="test_report_error" style="font-size:12px;color:#a94442;"></span>

                                                          <?php } ?>

                                                        </div>

                                                        <div class="col-md-8" id="pro<?php echo $i; ?>">

                                                          <div style="display:flex;">

                                                            <div class="form-group" style="width: 90%;">

                                                              <div class="input-icon right"><i class="fa"></i>

                                                                <input type="hidden" id="trcnt" value="<?php echo count($test_report_data); ?>">

                                                                <input type="text" class="form-control" name="test_report_text[]" id="test_report_text<?php echo $i; ?>" placeholder="Test Report" value="<?php echo (isset($key->test_report) && !empty($key->test_report)) ? $key->test_report : '' ?>">

                                                              </div>

                                                            </div>

                                                            <?php if($i==1){ ?>

                                                              <div class="" style="width: 10%;">

                                                                <div class="adtestreportbtn"><i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i></div>

                                                              </div>

                                                            <?php } else { ?>

                                                              <div class="" style="width: 10%;">

                                                                <div class="rmtestreportbtn" data-id="<?php echo $i; ?>"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>

                                                              </div>

                                                            <?php } ?>

                                                          </div>

                                                        </div>

                                                      </div>

                                                      <?php $i++; } ?>

                                                      <div class="adtest_report" id="adtest_report"></div>

                                                    <?php } ?>

                                                  <?php } ?>


                                                </div>

                                                <div class="row">

                                                  <div class="col-md-6">

                                                    <div class="form-group">

                                                      <label class="">Payment Terms <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                                      <div class="dflx">

                                                        <input type="radio" name="payment_terms" id="si" value="S&I" <?php echo (isset($project_data->payment_terms) && !empty($project_data->payment_terms) && ($project_data->payment_terms == 'S&I')) ? 'checked' : '' ?>><span style="padding: 0 10px 0px 5px;">S&I</span>
                                                        <input type="radio" name="payment_terms" id="SITC" value="SITC" <?php echo (isset($project_data->payment_terms) && !empty($project_data->payment_terms) && ($project_data->payment_terms == 'SITC')) ? 'checked' : '' ?>><span style="padding: 0 10px 0px 5px;">SITC</span>

                                                      </div>

                                                    </div>

                                                  </div>

                                                </div>

                                              </div>

                                            </div>

                                            <div class="panel panel-default" id="billing_split_up" <?php echo (isset($project_data->payment_terms) && !empty($project_data->payment_terms) && ($project_data->payment_terms == 'SITC')) ? 'style="display: block;"' : 'style="display: none;"' ?>>

                                              <div class="panel-heading">

                                                <h4 class="panel-title">Billing Split Up Details </h4>

                                              </div>

                                              <div class="panel-body">

                                                <p style="color:#a94442;font-size:12px;">Note * : Billing Split Up must be equal to 100%</p>

                                                <div class="row">

                                                  <div class="col-md-6">

                                                    <div class="form-group">

                                                      <label class="">Supply(%) <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                                      <div class="input-icon right">

                                                        <i class="fa"></i>

                                                        <input type="text" class="form-control tcl" name="bill_split_supply" id="bill_split_supply" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($project_data->bill_split_supply) && !empty($project_data->bill_split_supply)) ? $project_data->bill_split_supply : '' ?>" maxlength="3" min="0" max="100" placeholder="Supply(%) ">

                                                      </div>

                                                    </div>

                                                  </div>

                                                  <div class="col-md-6">

                                                    <div class="form-group">

                                                      <label class="">Installation(%) <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                                      <div class="input-icon right">

                                                        <i class="fa"></i>

                                                        <input type="text" class="form-control tcl" name="bill_installation" id="bill_installation" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($project_data->bill_installation) && !empty($project_data->bill_installation)) ? $project_data->bill_installation : '' ?>" maxlength="3" min="0" max="100" placeholder="Installation(%)">

                                                      </div>

                                                    </div>

                                                  </div>

                                                  <div class="col-md-6">

                                                    <div class="form-group">

                                                      <label class="">Testing & Commissioning(%) <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                                      <div class="input-icon right">

                                                        <i class="fa"></i>

                                                        <input type="text" class="form-control tcl" name="testing_commissioning" id="testing_commissioning" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo (isset($project_data->testing_commissioning) && !empty($project_data->testing_commissioning)) ? $project_data->testing_commissioning : '' ?>" maxlength="3" min="0" max="100" placeholder="Testing & Commissioning(%) ">

                                                      </div>

                                                    </div>

                                                  </div>

                                                  <div class="col-md-6">

                                                    <div class="form-group">

                                                      <label class="">Handover(%) <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                                      <div class="input-icon right">

                                                        <i class="fa"></i>

                                                        <input type="text" class="form-control tcl" name="bill_handover" id="bill_handover" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="3" min="0" max="100" value="<?php echo (isset($project_data->bill_handover) && !empty($project_data->bill_handover)) ? $project_data->bill_handover : '' ?>" placeholder="Handover(%)">

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

                                                      <label class="">Invoice to be submitted on customer website <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                                      <div class="dflx">

                                                        <input type="radio" name="invoice_submitted" id="invoice_submitted_yes" value="Yes" <?php echo (isset($project_data->invoice_submitted) && !empty($project_data->invoice_submitted) && ($project_data->invoice_submitted == 'Y')) ? 'checked' : '' ?>><span style="padding: 0 10px 0px 5px;">Yes</span>

                                                        <input type="radio" name="invoice_submitted" id="invoice_submitted_no" value="No" <?php echo (isset($project_data->invoice_submitted) && !empty($project_data->invoice_submitted) && ($project_data->invoice_submitted == 'N')) ? 'checked' : '' ?>><span style="padding: 0 10px 0px 5px;">No</span>

                                                      </div>

                                                    </div>

                                                  </div>

                                                  <div class="col-md-6">

                                                    <div class="form-group">

                                                      <label class="">Invoice to be sent on different address <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                                      <div class="dflx">

                                                        <input type="radio" name="invoice_submitted_address" id="invoice_submitted_address_yes" value="Yes" <?php echo (isset($project_data->invoice_submitted_address) && !empty($project_data->invoice_submitted_address) && ($project_data->invoice_submitted_address == 'Y')) ? 'checked' : '' ?>><span style="padding: 0 10px 0px 5px;">Yes</span>

                                                        <input type="radio" name="invoice_submitted_address" id="invoice_submitted_address_no" value="No" <?php echo (isset($project_data->invoice_submitted_address) && !empty($project_data->invoice_submitted_address) && ($project_data->invoice_submitted_address == 'N')) ? 'checked' : '' ?>><span style="padding: 0 10px 0px 5px;">No</span>

                                                      </div>

                                                    </div>

                                                  </div>

                                                  <div class="col-md-6">

                                                    <div class="form-group">

                                                      <label class="">ESIC Required <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label><br>

                                                      <div class="dflx">

                                                        <input type="radio" name="esic_required" id="esicYes" value="Yes" <?php echo (isset($project_data->esic_required) && !empty($project_data->esic_required) && ($project_data->esic_required == 'Y')) ? 'checked' : '' ?>><span style="padding: 0 10px 0px 5px;">Yes</span>

                                                        <input type="radio" name="esic_required" id="esicNo" value="No" <?php echo (isset($project_data->esic_required) && !empty($project_data->esic_required) && ($project_data->esic_required == 'N')) ? 'checked' : '' ?>><span style="padding: 0 10px 0px 5px;">No</span>

                                                      </div>

                                                    </div>

                                                  </div>

                                                  <div class="col-md-6">

                                                    <div class="form-group">

                                                      <label class="">PF Required <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label><br>

                                                      <div class="dflx">

                                                        <input type="radio" name="pf_required" id="pfYes" value="Yes" <?php echo (isset($project_data->pf_required) && !empty($project_data->pf_required) && ($project_data->pf_required == 'Y')) ? 'checked' : '' ?>><span style="padding: 0 10px 0px 5px;">Yes</span>

                                                        <input type="radio" name="pf_required" id="pfNo" value="No" <?php echo (isset($project_data->pf_required) && !empty($project_data->pf_required) && ($project_data->pf_required == 'N')) ? 'checked' : '' ?>><span style="padding: 0 10px 0px 5px;">No</span>

                                                      </div>

                                                    </div>

                                                  </div>

                                                </div>

                                                <div class="row" id="daddde">

                                                  <?php if(isset($project_data->invoice_submitted) && !empty($project_data->invoice_submitted) && $project_data->invoice_submitted == 'Y'){ ?>

                                                    <div class="col-md-6 ifinvoicesubmittedYes">

                                                      <div class="form-group">

                                                        <label class="">Invoice to be submitted on customer website <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                                        <div class="input-icon right">

                                                          <i class="fa"></i><input type="text" class="form-control" name="invoice_submitted_text" id="invoice_submitted_text" placeholder="Invoice to be submitted on customer website" value="<?php echo (isset($project_data->invoice_submitted_text) && !empty($project_data->invoice_submitted_text)) ? $project_data->invoice_submitted_text : '' ?>">

                                                        </div>

                                                      </div>

                                                    </div>

                                                  <?php } ?>

                                                  <?php if(isset($project_data->invoice_submitted_address) && !empty($project_data->invoice_submitted_address) && $project_data->invoice_submitted_address == 'Y'){ ?>

                                                    <div class="col-md-6 ifinvoicesubmittedaddYes">

                                                      <div class="form-group">

                                                        <label class="">Invoice to be sent on different address <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                                        <div class="input-icon right">

                                                          <i class="fa"></i>

                                                          <textarea rows="2" type="text" class="form-control" name="invoice_submitted_address_text" id="invoice_submitted_address_text" placeholder="Invoice to be sent on different address"><?php echo (isset($project_data->invoice_submitted_address_text) && !empty($project_data->invoice_submitted_address_text)) ? $project_data->invoice_submitted_address_text : '' ?></textarea>

                                                        </div>

                                                      </div>

                                                    </div>

                                                  <?php } ?>

                                                  <?php if(isset($project_data->esic_required) && !empty($project_data->esic_required) && $project_data->esic_required == 'Y'){ ?>

                                                    <div class="col-md-6 ifesicrequiredYes">

                                                      <div class="form-group">

                                                        <label class="">ESIC Required <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                                        <div class="input-icon right">

                                                          <i class="fa"></i><input type="text" class="form-control" name="esic_required_text" id="esic_required_text" placeholder="ESIC Required" value="<?php echo (isset($project_data->esic_required_text) && !empty($project_data->esic_required_text)) ? $project_data->esic_required_text : '' ?>">

                                                        </div>

                                                      </div>

                                                    </div>

                                                  <?php } ?>

                                                  <?php if(isset($project_data->pf_required) && !empty($project_data->pf_required) && $project_data->pf_required == 'Y'){ ?>

                                                    <div class="col-md-6 ifepfrequiredYes">

                                                      <div class="form-group">

                                                        <label class="">PF Required <span class="require required_icon" aria-required="true" style="color:#a94442"></span></label>

                                                        <div class="input-icon right">

                                                          <i class="fa"></i>

                                                          <input type="text" class="form-control" name="pf_required_text" id="pf_required_text" placeholder="PF Required" value="<?php echo (isset($project_data->pf_required_text) && !empty($project_data->pf_required_text)) ? $project_data->pf_required_text : '' ?>">

                                                        </div>

                                                      </div>

                                                    </div>

                                                  <?php } ?>

                                                </div>

                                                <div class="row">

                                                  <div class="col-md-6">

                                                    <div class="form-group">

                                                      <label class="">Payment Terms</label>

                                                      <div class="input-icon right">

                                                        <i class="fa"></i>

                                                        <input type="text" class="form-control" name="any_other_details" value="<?php echo (isset($project_data->any_other_details) && !empty($project_data->any_other_details)) ? $project_data->any_other_details : '' ?>" placeholder="Payment Terms">

                                                      </div>

                                                    </div>

                                                  </div>
                                                  <div class="col-md-6">

                                                    <div class="form-group">

                                                      <label class="">Payment Terms Document</label>

                                                      <div class="input-icon right">

                                                        <i class="fa"></i>

                                                        <input type="file" class="" name="payment_terms_document" value="" >

                                                        <?php
                                                        if(isset($project_data->payment_terms_document) && !empty($project_data->payment_terms_document)){ ?>

                                                          <a href="<?php echo base_url(); ?>uploads/document_upload/<?php echo $project_data->payment_terms_document; ?>" download>Download</a>

                                                        <?php } ?>
                                                        <input type="hidden" name="hidden_payment_terms_document" value="<?php echo $project_data->payment_terms_document; ?>">

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

                                                      <?php if(isset($project_data->projectcmpl_doc_file) && !empty($project_data->projectcmpl_doc_file)){ ?>

                                                        <a href="<?php echo base_url(); ?>uploads/document_upload/<?php echo $project_data->projectcmpl_doc_file; ?>" download>Download</a>

                                                      <?php } ?>

                                                    </div>

                                                  </div>

                                                  <div class="col-md-6">

                                                    <div class="form-group">

                                                      <label class="control-label">Project Design Report Upload</label><br>

                                                      <input type="file" name="upload_projectdesig_doc_file" id="upload_projectdesig_doc_file" class="upload_projectdesig_doc_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />

                                                      <span id="upload_projectdesig_doc_file_error" style="font-size: 12px;color:#a94442;"></span>

                                                      <?php if(isset($project_data->projectdesig_doc_file) && !empty($project_data->projectdesig_doc_file)){ ?>

                                                        <a href="<?php echo base_url(); ?>uploads/document_upload/<?php echo $project_data->projectdesig_doc_file; ?>" download>Download</a>

                                                      <?php } ?>

                                                    </div>

                                                  </div>

                                                  <div class="col-md-6">

                                                    <div class="form-group">

                                                      <label class="control-label">Project Cash Flow Upload</label><br>

                                                      <input type="file" name="upload_projectcashflw_doc_file" id="upload_projectcashflw_doc_file" class="upload_projectcashflw_doc_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />

                                                      <span id="upload_projectcashflw_doc_file_error" style="font-size: 12px;color:#a94442;"></span>

                                                      <?php if(isset($project_data->projectcashflw_doc_file) && !empty($project_data->projectcashflw_doc_file)){ ?>

                                                        <a href="<?php echo base_url(); ?>uploads/document_upload/<?php echo $project_data->projectcashflw_doc_file; ?>" download>Download</a>

                                                      <?php } ?>

                                                    </div>

                                                  </div>

                                                  <div class="col-md-6">

                                                    <div class="form-group">

                                                      <label class="control-label">Project Investment Schedule Upload</label><br>

                                                      <input type="file" name="upload_projectinvstsch_doc_file" id="upload_projectinvstsch_doc_file" class="upload_projectinvstsch_doc_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />

                                                      <span id="upload_projectinvstsch_doc_file_error" style="font-size: 12px;color:#a94442;"></span>

                                                      <?php if(isset($project_data->projectinvstsch_doc_file) && !empty($project_data->projectinvstsch_doc_file)){ ?>

                                                        <a href="<?php echo base_url(); ?>uploads/document_upload/<?php echo $project_data->projectinvstsch_doc_file; ?>" download>Download</a>

                                                      <?php } ?>

                                                    </div>

                                                  </div>

                                                </div>

                                              </div>

                                            </div>

                                          </div>

                                          <div class="form-actions right">

                                            <a href="<?php echo base_url(); ?>create-project-list" class="btn blue" style="float: left;">Back</a>

                                            <?php if(isset($check_permission_status) && !empty($check_permission_status) && $check_permission_status == 'Y'

                                            && isset($project_data->status) && !empty($project_data->status) && $project_data->status != 'Y'){ ?>

                                              <button type="submit" formnovalidate="formnovalidate" name="psupdate" id="psupdate" class="btn orange psupdate" title="click To Save as Draft" rel="<?php echo (isset($project_data->project_id) && !empty($project_data->project_id)) ? $project_data->project_id : '' ?>"><i class="fa fa-dot-circle-o"></i> Save as Draft</button>

                                              <button type="submit" name="psupdatesubmit" id="psupdatesubmit" class="btn green psupdatesubmit" title="click To Submit" rel="<?php echo (isset($project_data->project_id) && !empty($project_data->project_id)) ? $project_data->project_id : '' ?>"><i class="fa fa-dot-circle-o"></i> Submit</button>

                                            <?php } ?>

                                          </div>

                                        </form>

                                      </div>

                                    </div>

                                  </div>
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
