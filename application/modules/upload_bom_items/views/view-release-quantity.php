<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title> Release Quantity | <?php echo project_name; ?> </title>
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
    <link href="<?php echo base_url(); ?>assets/css/createp.css?<?php echo date('Y-m-d H:i:s'); ?>" rel="stylesheet" type="text/css" />

    <style type="text/css">
        table.dataTable thead th, table.dataTable thead td {
            padding: 10px 15px !important;
            border-bottom: 0px solid #111;
            text-align: left;
            font-weight: 600;
        }
        .dataTables_filter{
            float:right;
        }
        .has-error{
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
        .align {
            vertical-align: middle!important;
            text-align: center;
        }
        .d-none {
            display: none;
        }
        .w70{
            width:70px;
        }
        .w400{
            width:400px;
        }
        .w40{
            width:40px;
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
                <!-- <div class="portlet-body"> -->
                    <div class="row">
                        <div class="col-md-12">
                             <?php $this->load->view('create_project/tab', array('type' => '2')); ?>
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption font-blue">
                                        <i class="fa fa-bars font-blue"></i>
                                        <span class="caption-subject bold uppercase"><?php echo (isset($bp_code) && !empty($bp_code)) ? '(#' . $bp_code . ')' : '' ?> BOM Release Quantity Item List</span>
                                    </div>
                                </div>

                                
                                <div class="portlet-body">
                                <nav id="menu-container" class="arrow">
                                    <div id="btn-nav-previous" style="fill: #5b9bd1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                            <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
                                            <path d="M0 0h24v24H0z" fill="none" />
                                        </svg>
                                    </div>

                                    <div id="btn-nav-next">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                            <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
                                            <path d="M0 0h24v24H0z" fill="none" />
                                        </svg>
                                    </div>

                                    <div class="menu-inner-box">
                                        <div class="menu" style="text-align:left;">
                                            <input type="hidden" name="project_id" id="project_id" value="<?php echo $id; ?>">
                                            <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                                            <a role="presentation" href="<?php echo base_url(); ?>view-bom/<?php echo $project_id_encode; ?>" class="cm menu-item">BOM View</a>
                                            <a role="presentation" href="<?php echo base_url(); ?>view-bom-release-quantity/<?php echo $project_id_encode; ?>" class="cm menu-item menu-item-active">Release Quantity</a>
                                            <a role="presentation" href="<?php echo base_url(); ?>view-indent-request/<?php echo $project_id_encode; ?>" class="cm menu-item">Indent Request</a>
                                            <a role="presentation" href="<?php echo base_url(); ?>view-purchase-order/<?php echo $project_id_encode; ?>" class="cm menu-item ">Purchase Order</a>
                                            <a role="presentation" href="<?php echo base_url(); ?>view_vendor_proforma_invoice/<?php echo $project_id_encode; ?>" class="cm menu-item">Purchase Proforma Invoice</a>
                                            <a role="presentation" href="<?php echo base_url(); ?>view_ppi_payment_receipt/<?php echo $project_id_encode; ?>" class="cm menu-item">Payment Receipt</a>
                                            <a role="presentation" href="<?php echo base_url(); ?>view-vendor-delivery-challan/<?php echo $project_id_encode; ?>" class="cm menu-item">Vendor Delivery Challan</a>
                                             <a role="presentation" href="<?php echo base_url(); ?>view-grn/<?php echo $project_id_encode; ?>" class="cm menu-item">Goods Received Notes</a> 
                                            <a role="presentation" href="<?php echo base_url(); ?>view-fore-close/<?php echo $project_id_encode; ?>" class="cm menu-item">Fore Close</a>
                                            <a role="presentation" href="<?php echo base_url(); ?>bom-approval-waiting/<?php echo $project_id_encode; ?>" class="cm menu-item">Waiting for Approval</a>
                                        </div>
                                    </div>
                                </nav>
                                      <table width="100%" id="pbomreleaselist" class="table table-striped table-bordered table-hover">
            							<thead>
            								<tr>
                                                <th scope="col" style="vertical-align: top;">Sr.no</th>
                                                <th scope="col" style="vertical-align: top;">BOQ<br>Sr No</th>
                                                <th scope="col" style="vertical-align: top;">BP Code</th>
                                                <th scope="col" style="vertical-align: top;">HSN Code</th>
                                                <th scope="col" style="vertical-align: top;">BOQ Item Description</th>
                                                <th scope="col" style="vertical-align: top;">Unit</th>
                                                <th scope="col" style="vertical-align: top;">Pending <br>Release Qty</th>
                                                <th scope="col" style="vertical-align: top;">Approved <br>Release Qty</th>
                                                <th scope="col" style="vertical-align: top;">Status</th>
                                                <th scope="col" style="vertical-align: top;">Action</th>
            								</tr>
            							</thead>
            							<tbody> 
            					    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
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
    <script src="<?php echo base_url();?>js/add-edit-release.js?<?php echo date('Ymd H:i:s'); ?>" type="text/javascript"></script>
    <script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); 
        ComponentsPickers.init();
    });
    </script>
</body>
</html>