<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8"/>

    <title>View BOQ | <?php echo project_name; ?> </title>

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

    <link href="<?php echo base_url();?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url();?>assets/global/css/components-rounded.css?<?php echo date('Y-m-d H:i:s');?>" id="style_components" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>assets/global/css/plugins.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>assets/admin/layout4/css/layout.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>/assets/admin/layout4/css/light.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url(); ?>assets/site/css/validationEngine.jquery.css" rel="stylesheet">

    <link href="<?php echo base_url();?>assets/css/createp.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>

    

    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap.min.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css" rel="stylesheet" />

    </head>

<body class="page-header-fixed page-sidebar-closed-hide-logo">

    <?php $this->load->view('common/header');?>

    <div class="clearfix">

    </div>

    <div class="page-container">

        <?php $this->load->view('common/sidebar');?>

        <div class="page-content-wrapper">

            <div class="page-content">

                     <div class="row">

                    <div class="col-md-12">

                        <?php $this->load->view('tab'); ?>

                        <div class="portlet light">

                            <div class="portlet-title">

                                <div class="caption font-blue">

                                    <i class="fa fa-bars font-blue"></i>

                                    <span class="caption-subject bold uppercase"><?php echo(isset($bp_code) && !empty($bp_code))?'(#'.$bp_code.')':''?> View BOQ</span>

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

                                        <a role="presentation" href="<?php echo base_url(); ?>project-details/<?php echo base64_encode($project_id); ?>" class="cm menu-item project-details">OEF Details</a>

                                        <a role="presentation" href="<?php echo base_url(); ?>boq-transaction/<?php echo base64_encode($project_id); ?>" class="cm menu-item boq-transaction">BOQ Transactions</a>

                                    	<a role="presentation" href="<?php echo base_url(); ?>view-boq/<?php echo base64_encode($project_id); ?>" class="cm menu-item menu-item-active boq-view">BOQ View</a>

                                    	<a role="presentation" href="<?php echo base_url(); ?>view-boq-exceptional-approval/<?php echo base64_encode($project_id); ?>" class="cm menu-item view-boq-exceptional-approval">BOQ Exceptional Approval</a>

                                    	<a role="presentation" href="<?php echo base_url(); ?>operational-scheduled/<?php echo base64_encode($project_id); ?>" class="cm menu-item boq-operational-view">BOQ Operable Scheduled View</a>

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

                                <div role="tabpanel" class="tab-pane active" id="view-boq">

                                <input type="hidden" id="project_id" value="<?php echo base64_encode($project_id); ?>">

                                <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

                                <div class="portlet-body form">

                                    <?php if(isset($boq_transaction_cnt) && $boq_transaction_cnt!='no'){ ?>

                                    <div class="row">

                                        <div class="col-md-2">

                                            <div class="form-group">

                                                <select class="form-control" name="filter" id="filter">

                                                    <option value="original">Original</option>

                                                    <option value="calculated">Calculated</option>

                                                </select>

                                                </div>

                                            </div>

                                            <div class="col-md-2" id="calculatedfiler"></div>

                                    </div>

                                    <div id="originalpboqviewdiv">

                                    <table width="100%" id="originalpboqview" class="table table-striped table-bordered table-hover" style="text-align: left;">

            							<thead>

            								<tr>

            									<th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sr.no</th>

            									<th scope="col" style="min-width:50px;width:50px;vertical-align: top;">BOQ <br>Sr No</th>

            									<th scope="col" style="min-width:250px;width:250px;vertical-align: top;">Item Description</th>

            									<th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Unit</th>

            									<th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Sch.<br> Qty</th>

            								    <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Rate <br> Basic</th>

            									<th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Sch.<br> Amount<br>(Basic)</th>

            								    <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">GST<br> Rate(%)</th>

            								    <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">GST<br> Amount</th>

            								    <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Sch.<br>Amount<br>(GST)</th>

            								    </tr>

            							</thead>

            							<tbody></tbody>

            							<tfoot class="origfooter">

                                            <tr>

                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($totalData['total_sch_amount_with_gst']) && !empty($totalData['total_sch_amount_with_gst']))?'':''; ?></th>

                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($totalData['total_sch_amount_with_gst']) && !empty($totalData['total_sch_amount_with_gst']))?'':''; ?></th>

                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($totalData['total_sch_amount_with_gst']) && !empty($totalData['total_sch_amount_with_gst']))?'':''; ?></th>

                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($totalData['total_sch_amount_with_gst']) && !empty($totalData['total_sch_amount_with_gst']))?'Grand Total':''; ?></th>

                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($totalData['total_sch_qty']) && !empty($totalData['total_sch_qty']))?$totalData['total_sch_qty']:''; ?></th>

                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($totalData['total_basic_rate']) && !empty($totalData['total_basic_rate']))?sprintf('%0.2f', $totalData['total_basic_rate']):''; ?></th>

                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($totalData['total_sch_amount']) && !empty($totalData['total_sch_amount']))?sprintf('%0.2f', $totalData['total_sch_amount']):''; ?></th>

                                                <th style="text-align:right;font-weight: 600;"></th>

                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($totalData['total_sch_gst_amount']) && !empty($totalData['total_sch_gst_amount']))?sprintf('%0.2f', $totalData['total_sch_gst_amount']):''; ?></th>

                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($totalData['total_sch_amount_with_gst']) && !empty($totalData['total_sch_amount_with_gst']))?sprintf('%0.2f', $totalData['total_sch_amount_with_gst']):''; ?></th>

                                            </tr>

                                        </tfoot>

            					    </table>

            					    </div>

            					    <div id="calwithoutgstpboqviewdiv" style="display:none;">

            					    <table width="100%" id="calwithoutgstpboqview" class="table table-striped table-bordered table-hover" style="text-align: left;">

            							<thead>

            								<tr>

            									<th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sr.no</th>

            									<th scope="col" style="min-width:30px;width:30px;vertical-align: top;">BOQ<br>Sr No</th>

            									<th scope="col" style="min-width:250px;width:250px;vertical-align: top;">Item Description</th>

            									<th scope="col" style="min-width:20px;width:20px;vertical-align: top;">Unit</th>

            									<th scope="col" style="min-width:20px;width:20px;vertical-align: top;">Sch.<br> Qty</th>

            									<th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Ori.Dsgn<br>Qty</th>

            									<th scope="col" style="min-width:20px;width:20px;vertical-align: top;">Build<br>Qty</th>

            									<th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Rate <br> Basic</th>

            									<th scope="col" style="min-width:20px;width:20px;vertical-align: top;">(+)ve<br>Var</th>

            									<th scope="col" style="min-width:20px;width:20px;vertical-align: top;">(-)ve<br>Var</th>

            									<th scope="col" style="min-width:20px;width:20px;vertical-align: top;">EA <br>Qty</th>

            									<th scope="col" style="min-width:20px;width:20px;vertical-align: top;">EA<br>Amt</th>

            									<th scope="col" style="min-width:20px;width:20px;vertical-align: top;">Sch.<br>Amt</th>

            									<th scope="col" style="min-width:20px;width:20px;vertical-align: top;">(+)ve<br>Var Amt</th>

            								    <th scope="col" style="min-width:20px;width:20px;vertical-align: top;">(-)ve<br>Var Amt</th>

            								    <th scope="col" style="min-width:20px;width:20px;vertical-align: top;">Build<br>Amt</th>

            								    <th scope="col" style="min-width:20px;width:20px;vertical-align: top;">NS<br>Item Amt</th>

            								    <th scope="col" style="min-width:20px;width:20px;vertical-align: top;">Final <br>Contract Amt</th>

            								</tr>

            							</thead>

            							<tbody></tbody>

            							<tfoot class="withoutgstfooter">

                                            <tr>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgn_amount']) && !empty($totalData['total_dsgn_amount']))?'':''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgn_amount']) && !empty($totalData['total_dsgn_amount']))?'':''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgn_amount']) && !empty($totalData['total_dsgn_amount']))?'':''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgn_amount']) && !empty($totalData['total_dsgn_amount']))?'Grand Total':''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_sch_qty']) && !empty($totalData['total_sch_qty']))?$totalData['total_sch_qty']:''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgnqty']) && !empty($totalData['total_dsgnqty']))?$totalData['total_dsgnqty']:''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgnqty']) && !empty($totalData['total_dsgnqty']))?$totalData['total_dsgnqty']:''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_basic_rate']) && !empty($totalData['total_basic_rate']))?sprintf('%0.2f', $totalData['total_basic_rate']):''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalPosData['qty']) && !empty($totalPosData['qty']))?$totalPosData['qty']:''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalNegData['qty']) && !empty($totalNegData['qty']))?$totalNegData['qty']:''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalPosData['qty']) && !empty($totalPosData['qty']))?$totalPosData['qty']:''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalPosData['amount']) && !empty($totalPosData['amount']))?sprintf('%0.2f', $totalPosData['amount']):''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_sch_amount']) && !empty($totalData['total_sch_amount']))?sprintf('%0.2f', $totalData['total_sch_amount']):''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalPosData['amount']) && !empty($totalPosData['amount']))?sprintf('%0.2f', $totalPosData['amount']):''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_negative_var_amount']) && !empty($totalData['total_negative_var_amount']))?sprintf('%0.2f', $totalData['total_negative_var_amount']):''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgn_amount']) && !empty($totalData['total_dsgn_amount']))?sprintf('%0.2f', $totalData['total_dsgn_amount']):''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_non_sch_amount']) && !empty($totalData['total_non_sch_amount']))?sprintf('%0.2f', $totalData['total_non_sch_amount']):''; ?></th>

                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgn_amount']) && !empty($totalData['total_dsgn_amount']))?sprintf('%0.2f', $totalData['total_dsgn_amount']):''; ?></th>

                                            </tr>

                                        </tfoot>

            					    </table>

            					    </div>

            					    <div id="calwithgstpboqviewdiv" style="display:none;">

            					    <table width="100%" id="calwithgstpboqview" class="table table-striped table-bordered table-hover" style="text-align: left;">

            							<thead>

            								<tr>

            									<th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sr.no</th>

            									<th scope="col" style="min-width:30px;width:30px;vertical-align: top;">BOQ<br>Sr No</th>

            									<th scope="col" style="min-width:250px;width:250px;vertical-align: top;">Item Description</th>

            									<th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Unit</th>

            									<th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Sch.<br>Qty</th>

            									<th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Ori.Dsgn<br>Qty</th>

            									<th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Build<br>Qty</th>

            									<th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Rate <br> Basic</th>

            									<th scope="col" style="min-width:10px;width:10px;vertical-align: top;">(+)ve<br>Var</th>

            									<th scope="col" style="min-width:10px;width:10px;vertical-align: top;">(-)ve<br>Var</th>

            									<th scope="col" style="min-width:10px;width:10px;vertical-align: top;">EA<br>Qty</th>

            									<th scope="col" style="min-width:10px;width:10px;vertical-align: top;">EA<br>Amount</th>

            									<th scope="col" style="min-width:10px;width:10px;vertical-align: top;">EA Amount<br>(GST)</th>

            									<th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Sch.<br>Amount</th>

            									<th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Sch.Amount<br>(GST)</th>

            									<th scope="col" style="min-width:10px;width:10px;vertical-align: top;">(+)ve<br>Var Amount</th>

            								    <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">(+)ve Var<br>Amount<br>(GST)</th>

            								    <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">(-)ve Var<br>Amount</th>

            								    <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">(-)ve Var<br>Amount<br>(GST)</th>

            								    <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Build<br>Amount</th>

            								    <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Build<br>Amount<br>(GST)</th>

            								    <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">NS Item<br>Amount</th>

            								    <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">NS Item<br>Amount<br>(GST)</th>

            								    <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Final<br>Contract<br>Amount</th>

            								    <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">GST<br> Rate(%)</th>

            								    <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">GST<br> Amount</th>

            								    <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Final<br>Contract <br>Amount<br>(GST)</th>

            								</tr>

            							</thead>

            							<tbody></tbody>

            							<tfoot class="withgstfooter">
                                            <tr>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgn_amount']) && !empty($totalData['total_dsgn_amount']))?'':''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgn_amount']) && !empty($totalData['total_dsgn_amount']))?'':''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgn_amount']) && !empty($totalData['total_dsgn_amount']))?'':''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgn_amount']) && !empty($totalData['total_dsgn_amount']))?'Grand Total':''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_sch_qty']) && !empty($totalData['total_sch_qty']))?$totalData['total_sch_qty']:''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgnqty']) && !empty($totalData['total_dsgnqty']))?$totalData['total_dsgnqty']:''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgnqty']) && !empty($totalData['total_dsgnqty']))?$totalData['total_dsgnqty']:''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_basic_rate']) && !empty($totalData['total_basic_rate']))?sprintf('%0.2f', $totalData['total_basic_rate']):''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalPosData['qty']) && !empty($totalPosData['qty']))?$totalPosData['qty']:''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalNegData['qty']) && !empty($totalNegData['qty']))?$totalNegData['qty']:''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalPosData['qty']) && !empty($totalPosData['qty']))?$totalPosData['qty']:''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalPosData['amount']) && !empty($totalPosData['amount']))?sprintf('%0.2f', $totalPosData['amount']):''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalPosData['amount_gst']) && !empty($totalPosData['amount_gst']))?sprintf('%0.2f', $totalPosData['amount_gst']):''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_sch_amount']) && !empty($totalData['total_sch_amount']))?sprintf('%0.2f', $totalData['total_sch_amount']):''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_sch_amount_with_gst']) && !empty($totalData['total_sch_amount_with_gst']))?sprintf('%0.2f', $totalData['total_sch_amount_with_gst']):''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalPosData['amount']) && !empty($totalPosData['amount']))?sprintf('%0.2f', $totalPosData['amount']):''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalPosData['amount_gst']) && !empty($totalPosData['amount_gst']))?sprintf('%0.2f', $totalPosData['amount_gst']):''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_negative_var_amount']) && !empty($totalData['total_negative_var_amount']))?sprintf('%0.2f', $totalData['total_negative_var_amount']):''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_negative_var_gst_amount']) && !empty($totalData['total_negative_var_gst_amount']))?sprintf('%0.2f', $totalData['total_negative_var_gst_amount']):''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgn_amount']) && !empty($totalData['total_dsgn_amount']))?sprintf('%0.2f', $totalData['total_dsgn_amount']):''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgn_amount_with_gst']) && !empty($totalData['total_dsgn_amount_with_gst']))?sprintf('%0.2f', $totalData['total_dsgn_amount_with_gst']):''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_non_sch_amount']) && !empty($totalData['total_non_sch_amount']))?sprintf('%0.2f', $totalData['total_non_sch_amount']):''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_non_sch_gst_amount']) && !empty($totalData['total_non_sch_gst_amount']))?sprintf('%0.2f', $totalData['total_non_sch_gst_amount']):''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgn_amount']) && !empty($totalData['total_dsgn_amount']))?sprintf('%0.2f', $totalData['total_dsgn_amount']):''; ?></th>
                                                <th class="text-right" style="font-weight:600;"></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData    ['total_dsgn_gst_amount']) && !empty($totalData['total_dsgn_gst_amount']))?sprintf('%0.2f', $totalData['total_dsgn_gst_amount']):''; ?></th>
                                                <th class="text-right" style="font-weight:600;"><?php echo (isset($totalData['total_dsgn_amount_with_gst']) && !empty($totalData['total_dsgn_amount_with_gst']))?sprintf('%0.2f', $totalData['total_dsgn_amount_with_gst']):''; ?></th>
                                            </tr>
                                        </tfoot>
            					    

            					    </table>

            					    </div>

            					    <?php }else{ ?>

            					    <p style="margin-top:20px;">BOQ View Not Found!!</p>

                                    <?php } ?>

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

    <script src="<?php echo base_url();?>js/common.js?<?php echo date('Y-m-d H:i:s');?>" type="text/javascript"></script>

    

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

    <script src="<?php echo base_url();?>js/boq-view.js?<?php echo date('Y-m-d H:i:s');?>" type="text/javascript"></script>

    <script>

    jQuery(document).ready(function() {

        Metronic.init(); // init metronic core components

        Layout.init(); 

        ComponentsPickers.init();

    });

    </script>

</body>

</html>