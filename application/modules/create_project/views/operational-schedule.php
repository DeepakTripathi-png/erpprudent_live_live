<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>BOQ Operable Scheduled View | <?php echo project_name; ?> </title>
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
    <style>
        .boq-operation-schedule {
            border: 0!important;
        }
        .boq-operation-schedule-tab a {
            padding: 8px 10px!important;
        }
        .boq-operation-schedule-tab li:not(.title-tab):after {
            height: unset;
        }

        .green {
            color: #FFFFFF!important;
            background-color: #26a69a!important;
            border: none!important;
        }
    </style>
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
                                    <span class="caption-subject bold uppercase"><?php echo(isset($bp_code) && !empty($bp_code))?'(#'.$bp_code.')':''?> BOQ Operable Schedule View</span>
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
                                    	<a role="presentation" href="<?php echo base_url(); ?>view-boq/<?php echo base64_encode($project_id); ?>" class="cm menu-item boq-view">BOQ View</a>
                                    	<a role="presentation" href="<?php echo base_url(); ?>view-boq-exceptional-approval/<?php echo base64_encode($project_id); ?>" class="cm menu-item view-boq-exceptional-approval">BOQ Exceptional Approval</a>
                                    	<a role="presentation" href="<?php echo base_url(); ?>operational-scheduled/<?php echo base64_encode($project_id); ?>" class="cm menu-item menu-item-active boq-operational-view">BOQ Operable Schedule View</a>
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
                                <input type="hidden" id="project_id" value="<?php echo base64_encode($project_id); ?>">
                                <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                                <div role="tabpanel" class="tab-pane active" id="view-boq">
                                <div class="portlet-body form">
                                    <?php if(isset($boq_transaction_cnt) && $boq_transaction_cnt!='no'){ ?>
                                    <table width="100%" id="grandtotal" class="table table-striped table-bordered table-hover">
            							<thead style="background:#F58631;color:#fff;">
            								<tr>
            									<th scope="col" style="vertical-align: top;"></th>
            									<th scope="col" style="vertical-align: top;font-weight: 500;">Schedule A with GST</th>
            								    <th scope="col" style="vertical-align: top;font-weight: 500;">Schedule B positive with GST</th>
            								    <th scope="col" style="vertical-align: top;font-weight: 500;">Schedule B Negative with GST</th>
            									<th scope="col" style="vertical-align: top;font-weight: 500;">Schedule C with GST</th>
            									<th scope="col" style="vertical-align: top;font-weight: 500;">Grand Total A+B+C</th>
            								    <th scope="col" style="vertical-align: top;font-weight: 500;">BOQ View Grand Total</th>
            								</tr>
            							</thead>
            							<tbody>
            							    <tr>
                                                <td style="vertical-align: center;font-weight: 600;">Item wise</td>
            							        <!-- <td style="vertical-align: center;font-weight: 600;">Grand Total</td> -->
            							        <td style="vertical-align: top;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgn_amount_with_gst']) && !empty($sch_a_total_data['total_dsgn_amount_with_gst']))?sprintf('%0.2f', $sch_a_total_data['total_dsgn_amount_with_gst']):'0.00'; ?></td>
            							        <td style="vertical-align: top;font-weight: 600;"><?php echo (isset($sch_b_total_data['total_dsgn_amount_with_gst']) && !empty($sch_b_total_data['total_dsgn_amount_with_gst']))?sprintf('%0.2f', $sch_b_total_data['total_dsgn_amount_with_gst']):'0.00'; ?></td>
            							        <td style="vertical-align: top;font-weight: 600;"><?php echo (isset($sch_bn_total_data['total_dsgn_amount_with_gst']) && !empty($sch_bn_total_data['total_dsgn_amount_with_gst']))?sprintf('%0.2f', $sch_bn_total_data['total_dsgn_amount_with_gst']):'0.00'; ?></td>
            							        <td style="vertical-align: top;font-weight: 600;"><?php echo (isset($sch_c_total_data['total_dsgn_amount_with_gst']) && !empty($sch_c_total_data['total_dsgn_amount_with_gst']))?sprintf('%0.2f', $sch_c_total_data['total_dsgn_amount_with_gst']):'0.00'; ?></td>
            							        <td style="vertical-align: top;font-weight: 600;">
            							            <?php $sch_a_total = (isset($sch_a_total_data['total_dsgn_amount_with_gst']) && !empty($sch_a_total_data['total_dsgn_amount_with_gst']))?$sch_a_total_data['total_dsgn_amount_with_gst']:'0.00'; ?>
            							            <?php $sch_b_total = (isset($sch_b_total_data['total_dsgn_amount_with_gst']) && !empty($sch_b_total_data['total_dsgn_amount_with_gst']))?$sch_b_total_data['total_dsgn_amount_with_gst']:'0.00'; ?>
            							            <?php $sch_bn_total = (isset($sch_bn_total_data['total_dsgn_amount_with_gst']) && !empty($sch_bn_total_data['total_dsgn_amount_with_gst']))?$sch_bn_total_data['total_dsgn_amount_with_gst']:'0.00'; ?>
            							            <?php $sch_c_total = (isset($sch_c_total_data['total_dsgn_amount_with_gst']) && !empty($sch_c_total_data['total_dsgn_amount_with_gst']))?$sch_c_total_data['total_dsgn_amount_with_gst']:'0.00'; ?>
            							            <?php $totalall = $sch_a_total+$sch_b_total+$sch_bn_total+$sch_c_total; echo sprintf('%0.2f',$totalall);?>
            							        </td>
            							        <td style="vertical-align: top;font-weight: 600;"><?php echo (isset($totalData['total_dsgn_amount_with_gst']) && !empty($totalData['total_dsgn_amount_with_gst']))?sprintf('%0.2f', $totalData['total_dsgn_amount_with_gst']):'0.00'; ?></td>
            							    </tr>
                                            <?php
                                                $sch_b_total_val_wise = 0;
                                                $ea_total_positive = (isset($ea_total_positive) && !empty($ea_total_positive))?$ea_total_positive:'0.00';
                                                $ea_total_nagative = (isset($ea_total_nagative) && !empty($ea_total_nagative))?$ea_total_nagative:'0.00';
                                                $schedule_total = (isset($schedule_total) && !empty($schedule_total))?$schedule_total:'0.00';
                                                $sch_b_total_value_wise = $schedule_total - $ea_total_nagative;
                                                $total_value_w = $sch_a_total + $sch_b_total_value_wise + $sch_bn_total;
                                                $grand_total_v_wise = $sch_b_total_value_wise + $ea_total_positive + $sch_c_total;
                                                $total_sc_b_value = $sch_b_total - $ea_total_positive;
                                                $sc_a_total_value = $sch_a_total + $total_sc_b_value + $sch_bn_total;
                                                ?>
                                            <tr>
                                                <td style="vertical-align: center;font-weight: 600;">Value wise</td>
            							        <td style="vertical-align: top;font-weight: 600;"><?php  echo sprintf('%0.2f',$sc_a_total_value); ?></td>
                                                <td style="vertical-align: top;font-weight: 600;"><?php  echo sprintf('%0.2f',$ea_total_positive); ?></td>
                                                <td style="vertical-align: center;font-weight: 600;"><?php  echo sprintf('%0.2f',$ea_total_nagative); ?></td>
                                                <td style="vertical-align: top;font-weight: 600;"><?php echo (isset($sch_c_total_data['total_dsgn_amount_with_gst']) && !empty($sch_c_total_data['total_dsgn_amount_with_gst']))?sprintf('%0.2f', $sch_c_total_data['total_dsgn_amount_with_gst']):'0.00'; ?></td>
                                                <td style="vertical-align: top;font-weight: 600;"><?php  echo sprintf('%0.2f',$totalall); ?></td>
                                                <td style="vertical-align: top;font-weight: 600;"></td>
            							    </tr>
            							</tbody>
            						</table>
                                    
                                    <ul class="nav nav-tabs boq-operation-schedule-tab" id="myTab" role="tablist">
                                        <li class="nav-item active" role="presentation">
                                            <a class="nav-link border-0 boq-operation-schedule" data-toggle="tab" data-tab-index="1" href="#view_operable_schedule_a">View Operable Schedule A :</a>
                                        </li>
                                        <li class="nav-item border-0" role="presentation">
                                            <a class="nav-link boq-operation-schedule"  data-toggle="tab" data-tab-index="2" href="#view_operable_schedule_b_positive">View Operable Schedule B Positive :</a>
                                        </li>
                                        <li class="nav-item border-0" role="presentation">
                                            <a class="nav-link boq-operation-schedule" data-toggle="tab" data-tab-index="3" href="#view_operable_schedule_b_negative">View Operable Schedule B Negative :</a>
                                        </li>
                                        <li class="nav-item border-0" role="presentation">
                                            <a class="nav-link boq-operation-schedule" data-toggle="tab" data-tab-index="4" href="#view_operable_schedule_c">View Operable Schedule C :</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane  active" id="view_operable_schedule_a" role="tabpanel">
                                        <!-- <p style="padding: 7px 10px;background:#26a69a;color:#fff;font-size: 13px;font-weight: 500;">View Operable Schedule A : </p> -->
                                            <table width="100%" id="pboqscha" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sr.no</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">BOQ<br>Sr No</th>
                                                        <th scope="col" style="min-width:250px;width:250px;vertical-align: top;">Item Description</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Unit</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sch<br>Qty</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Build<br>Qty</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Rate <br> Basic</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Build<br> Amount<br>(Basic)</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">GST<br> Rate(%)</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">GST<br> Amount</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Build<br> Amount<br>(GST)</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot class="operable_a_footer" style="display:none;">
                                                <tr>
                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgn_amount_with_gst']) && !empty($sch_a_total_data['total_dsgn_amount_with_gst']))?'':''; ?></th>
                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgn_amount_with_gst']) && !empty($sch_a_total_data['total_dsgn_amount_with_gst']))?'':''; ?></th>
                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgn_amount_with_gst']) && !empty($sch_a_total_data['total_dsgn_amount_with_gst']))?'':''; ?></th>
                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgn_amount_with_gst']) && !empty($sch_a_total_data['total_dsgn_amount_with_gst']))?'Grand Total':''; ?></th>
                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_sch_qty']) && !empty($sch_a_total_data['total_sch_qty']))?$sch_a_total_data['total_sch_qty']:'0'; ?></th>
                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgnqty']) && !empty($sch_a_total_data['total_dsgnqty']))?$sch_a_total_data['total_dsgnqty']:'0'; ?></th>
                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_basic_rate']) && !empty($sch_a_total_data['total_basic_rate']))?sprintf('%0.2f', $sch_a_total_data['total_basic_rate']):'0.00'; ?></th>
                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgn_amount']) && !empty($sch_a_total_data['total_dsgn_amount']))?sprintf('%0.2f', $sch_a_total_data['total_dsgn_amount']):'0.00'; ?></th>
                                                <th style="text-align:right;font-weight: 600;"></th>
                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgn_gst_amount']) && !empty($sch_a_total_data['total_dsgn_gst_amount']))?sprintf('%0.2f', $sch_a_total_data['total_dsgn_gst_amount']):'0.00'; ?></th>
                                                <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgn_amount_with_gst']) && !empty($sch_a_total_data['total_dsgn_amount_with_gst']))?sprintf('%0.2f', $sch_a_total_data['total_dsgn_amount_with_gst']):'0.00'; ?></th>
                                            </tr>
                                                </tfoot>
                                            </table>
                                            <hr/>
                                        </div>
                                        <div class="tab-pane fade" id="view_operable_schedule_b_positive" role="tabpanel">
                                        <!-- <p style="padding: 7px 10px;background:#26a69a;color:#fff;font-size: 13px;font-weight: 500;">View Operable Schedule B Positive : </p> -->
                                            <table width="100%" id="pboqschb" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sr.no</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">BOQ <br>Sr No</th>
                                                        <th scope="col" style="min-width:250px;width:250px;vertical-align: top;">Item Description</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Unit</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sch<br> Qty</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Variation<br>Qty</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Build<br>Qty</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Rate <br> Basic</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Build<br> Amount<br>(Basic)</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">GST<br> Rate(%)</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">GST<br> Amount</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Build<br> Amount<br>(GST)</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot class="operable_b_footer" style="display:none;">
                                                    <tr>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_b_total_data['total_dsgn_amount_with_gst']) && !empty($sch_b_total_data['total_dsgn_amount_with_gst']))?'':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_b_total_data['total_dsgn_amount_with_gst']) && !empty($sch_b_total_data['total_dsgn_amount_with_gst']))?'':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_b_total_data['total_dsgn_amount_with_gst']) && !empty($sch_b_total_data['total_dsgn_amount_with_gst']))?'':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_b_total_data['total_dsgn_amount_with_gst']) && !empty($sch_b_total_data['total_dsgn_amount_with_gst']))?'Grand Total':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_b_total_data['total_sch_qty']) && !empty($sch_b_total_data['total_sch_qty']))?$sch_b_total_data['total_sch_qty']:'0'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_b_total_data['total_positive_var']) && !empty($sch_b_total_data['total_positive_var']))?$sch_b_total_data['total_positive_var']:'0'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_b_total_data['total_dsgnqty']) && !empty($sch_b_total_data['total_dsgnqty']))?$sch_b_total_data['total_dsgnqty']:'0'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_b_total_data['total_basic_rate']) && !empty($sch_b_total_data['total_basic_rate']))?sprintf('%0.2f', $sch_b_total_data['total_basic_rate']):'0.00'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_b_total_data['total_dsgn_amount']) && !empty($sch_b_total_data['total_dsgn_amount']))?sprintf('%0.2f', $sch_b_total_data['total_dsgn_amount']):'0.00'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_b_total_data['total_dsgn_gst_amount']) && !empty($sch_b_total_data['total_dsgn_gst_amount']))?sprintf('%0.2f', $sch_b_total_data['total_dsgn_gst_amount']):'0.00'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_b_total_data['total_dsgn_amount_with_gst']) && !empty($sch_b_total_data['total_dsgn_amount_with_gst']))?sprintf('%0.2f', $sch_b_total_data['total_dsgn_amount_with_gst']):'0.00'; ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <hr/>
                                        </div>

                                        <div class="tab-pane fade" id="view_operable_schedule_b_negative" role="tabpanel">
                                        <!-- <p style="padding: 7px 10px;background:#26a69a;color:#fff;font-size: 13px;font-weight: 500;">View Operable Schedule B Negative : </p> -->
                                            <table width="100%" id="pboqschbn" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sr.no</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">BOQ<br>Sr No</th>
                                                        <th scope="col" style="min-width:250px;width:250px;vertical-align: top;">Item Description</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Unit</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sch<br>Qty</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Variation<br>Qty</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Build<br>Qty</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Rate <br> Basic</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Build<br> Amount<br>(Basic)</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">GST<br> Rate(%)</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">GST<br> Amount</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Build<br> Amount<br>(GST)</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot class="operable_bn_footer" style="display:none;">
                                                    <tr>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_bn_total_data['total_dsgn_amount_with_gst']) && !empty($sch_bn_total_data['total_dsgn_amount_with_gst']))?'':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_bn_total_data['total_dsgn_amount_with_gst']) && !empty($sch_bn_total_data['total_dsgn_amount_with_gst']))?'':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_bn_total_data['total_dsgn_amount_with_gst']) && !empty($sch_bn_total_data['total_dsgn_amount_with_gst']))?'':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_bn_total_data['total_dsgn_amount_with_gst']) && !empty($sch_bn_total_data['total_dsgn_amount_with_gst']))?'Grand Total':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_bn_total_data['total_sch_qty']) && !empty($sch_bn_total_data['total_sch_qty']))?$sch_bn_total_data['total_sch_qty']:'0'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_bn_total_data['total_negative_var']) && !empty($sch_bn_total_data['total_negative_var']))?$sch_bn_total_data['total_negative_var']:'0'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_bn_total_data['total_dsgnqty']) && !empty($sch_bn_total_data['total_dsgnqty']))?$sch_bn_total_data['total_dsgnqty']:'0'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_bn_total_data['total_basic_rate']) && !empty($sch_bn_total_data['total_basic_rate']))?sprintf('%0.2f', $sch_bn_total_data['total_basic_rate']):'0.00'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_bn_total_data['total_dsgn_amount']) && !empty($sch_bn_total_data['total_dsgn_amount']))?sprintf('%0.2f', $sch_bn_total_data['total_dsgn_amount']):'0.00'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_bn_total_data['total_dsgn_gst_amount']) && !empty($sch_bn_total_data['total_dsgn_gst_amount']))?sprintf('%0.2f', $sch_bn_total_data['total_dsgn_gst_amount']):'0.00'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_bn_total_data['total_dsgn_amount_with_gst']) && !empty($sch_bn_total_data['total_dsgn_amount_with_gst']))?sprintf('%0.2f', $sch_bn_total_data['total_dsgn_amount_with_gst']):'0.00'; ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <p id="invaliderrorid" style="padding:0px;font-size: 12px;color:#a94442;"></p>
                                            <hr/>
                                        </div>
                                        <div class="tab-pane fade" id="view_operable_schedule_c" role="tabpanel">
                                            <!-- <p style="padding: 7px 10px;background:#26a69a;color:#fff;font-size: 13px;font-weight: 500;">View Operable Schedule C : </p> -->
                                            <table width="100%" id="pboqschc" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sr.no</th>
                                                        <th scope="col" style="min-width:80px;width:80px;vertical-align: top;">BOQ<br>Sr No</th>
                                                        <th scope="col" style="min-width:250px;width:250px;vertical-align: top;">Item Description</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Unit</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Build<br>Qty</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Rate <br> Basic</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Build<br> Amount<br>(Basic)</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">GST<br> Rate(%)</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">GST<br> Amount</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Build<br> Amount<br>(GST)</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot class="operable_c_footer" style="display:none;">
                                                    <tr>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_c_total_data['total_dsgn_amount_with_gst']) && !empty($sch_c_total_data['total_dsgn_amount_with_gst']))?'':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_c_total_data['total_dsgn_amount_with_gst']) && !empty($sch_c_total_data['total_dsgn_amount_with_gst']))?'':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_c_total_data['total_dsgn_amount_with_gst']) && !empty($sch_c_total_data['total_dsgn_amount_with_gst']))?'':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_c_total_data['total_dsgn_amount_with_gst']) && !empty($sch_c_total_data['total_dsgn_amount_with_gst']))?'Grand Total':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_c_total_data['total_dsgnqty']) && !empty($sch_c_total_data['total_dsgnqty']))?$sch_c_total_data['total_dsgnqty']:'0'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_c_total_data['total_basic_rate']) && !empty($sch_c_total_data['total_basic_rate']))?sprintf('%0.2f', $sch_c_total_data['total_basic_rate']):'0.00'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_c_total_data['total_dsgn_amount']) && !empty($sch_c_total_data['total_dsgn_amount']))?sprintf('%0.2f', $sch_c_total_data['total_dsgn_amount']):'0.00'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_c_total_data['total_dsgn_gst_amount']) && !empty($sch_c_total_data['total_dsgn_gst_amount']))?sprintf('%0.2f', $sch_c_total_data['total_dsgn_gst_amount']):'0.00'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_c_total_data['total_dsgn_amount_with_gst']) && !empty($sch_c_total_data['total_dsgn_amount_with_gst']))?sprintf('%0.2f', $sch_c_total_data['total_dsgn_amount_with_gst']):'0.00'; ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                        
                                <?php  }else{  ?>
                                <p style="margin-top:20px;">BOQ Operable Scheduled Not Found!!</p>
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
    <script src="<?php echo base_url();?>js/operational-schedule.js?<?php echo date('Y-m-d H:i:s');?>" type="text/javascript"></script>
    <script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); 
        ComponentsPickers.init();
    });
    </script>
</body>
</html>