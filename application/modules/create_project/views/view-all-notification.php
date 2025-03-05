<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>All Notification | <?php echo project_name; ?> </title>
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
    <link href="<?php echo base_url();?>assets/global/css/components-rounded.css?<?php echo date('Y-m-d H:i:s');?>" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/css/plugins.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/admin/layout4/css/layout.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>/assets/admin/layout4/css/light.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/site/css/validationEngine.jquery.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/createp.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>
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
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption font-blue">
                                    <i class="fa fa-bars font-blue"></i>
                                    <span class="caption-subject bold uppercase"><?php echo(isset($bp_code) && !empty($bp_code) && !empty($project_id))?'(#'.$bp_code.') All Notification':'All Notification'?></span>
                                </div>
                                <?php if(isset($project_id) && !empty($project_id)){ ?>
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
    						    <?php } ?>
                            </div>
                            <div class="portlet-body form">
                            <?php if(isset($project_id) && !empty($project_id)){ ?>
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
                                        <a role="presentation" href="<?php echo base_url(); ?>project-details/<?php echo base64_encode($project_id); ?>" class="cm menu-item">OEF Details</a>
                                        <a role="presentation" href="<?php echo base_url(); ?>boq-transaction/<?php echo base64_encode($project_id); ?>" class="cm menu-item">BOQ Transactions</a>
                                    	<a role="presentation" href="<?php echo base_url(); ?>view-boq/<?php echo base64_encode($project_id); ?>" class="cm menu-item">BOQ View</a>
                                    	<a role="presentation" href="<?php echo base_url(); ?>view-boq-exceptional-approval/<?php echo base64_encode($project_id); ?>" class="cm menu-item view-boq-exceptional-approval">BOQ Exceptional Approval</a>
                                    	<a role="presentation" href="<?php echo base_url(); ?>operational-scheduled/<?php echo base64_encode($project_id); ?>" class="cm menu-item">BOQ Operable Schedule View</a>
                                    	<a role="presentation" href="<?php echo base_url(); ?>delivery-challan/<?php echo base64_encode($project_id); ?>" class="cm menu-item">Client Delivery Challan</a>
                                    	<!--<a role="presentation" href="<?php echo base_url(); ?>warehouse/<?php echo base64_encode($project_id); ?>" class="cm menu-item">Warehouse</a>-->
                                    	<a role="presentation" href="<?php echo base_url(); ?>installed-wip/<?php echo base64_encode($project_id); ?>" class="cm menu-item">Installed WIP</a>
                                    	<a role="presentation" href="<?php echo base_url(); ?>provisional-wip/<?php echo base64_encode($project_id); ?>" class="cm menu-item">Provisional WIP</a>
                                    	<a role="presentation" href="<?php echo base_url(); ?>proforma-invoice/<?php echo base64_encode($project_id); ?>" class="cm menu-item">Proforma Invoice</a>
                                    	<a role="presentation" href="<?php echo base_url(); ?>tax-invoice/<?php echo base64_encode($project_id); ?>" class="cm menu-item">Tax Invoice</a>
                                    	<a role="presentation" href="<?php echo base_url(); ?>approval-waiting/<?php echo base64_encode($project_id); ?>" class="cm menu-item">Waiting for Approval</a>
                                    	<a role="presentation" href="<?php echo base_url(); ?>wip-status/<?php echo base64_encode($project_id); ?>" class="cm menu-item">WIP Status</a>
                                        </div>
                                    </div>
                                </nav>
                            <?php } ?>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="view-project-notification">
                                <input type="hidden" id="project_id" value="<?php echo base64_encode($project_id); ?>">
                                <div class="portlet-body form">
                                    <table width="100%" id="allnotification" class="table table-striped table-bordered table-hover">
            							<thead>
            								<tr>
            									<th scope="col" style="min-width:50px;width:50px;">Sr.no</th>
            									<th scope="col" style="min-width:350px;width:350px;">Notification</th>
            								    <th scope="col" style="min-width:150px;width:150px;">Created On</th>
            									<th scope="col" style="min-width:10px;width:10px;">Action</th>
            								</tr>
            							</thead>
            							<tbody> 
            					    </table>
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
    <script src="<?php echo base_url();?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript" ></script>
    <script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js" type="text/javascript" ></script>
    <script src="<?php echo base_url();?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/lib/jquery.form.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine.js"></script>
    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine-en.js"></script>
    <script src="<?php echo base_url();?>js/common.js?<?php echo date('Y-m-d H:i:s');?>" type="text/javascript"></script>
    <script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); 
        ComponentsPickers.init();
    });
    var project_id = $('#project_id').val().trim(); 
    $('#allnotification').dataTable({
	    // Processing indicator
		"lengthMenu": [25, 50, 75, 100, 125,150],
		"paging": true,
		 "iDisplayLength": 25,
         "deferRender": true,
         "responsive": true,
        "processing": true,
		"serverSide": true,
        // Initial no order.
        "order": [],
		
        // Load data from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('notification_list'); ?>",
            "type": "POST",
            "data":{project_id:project_id}
        },
		
        //Set column definition initialisation properties
        "columnDefs": [{ 
            "targets": [0],
            "orderable": false
        }]
    } );
    </script>
</body>
</html>