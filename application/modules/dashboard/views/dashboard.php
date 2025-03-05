<!DOCTYPE html>

<html lang="en" class="no-js">

<!--<![endif]-->

<!-- BEGIN HEAD -->

<head>

    <meta charset="utf-8"/>

    <title>Dashboard | <?php echo project_name; ?> </title>

    <base href="<?php echo base_url(); ?>" >

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta content="width=device-width, initial-scale=1" name="viewport"/>

    <meta content="" name="description"/>

    <meta content="" name="author"/>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">

    <link href="<?php echo base_url();?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>

    <!----- PAGE CSS------->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/global/plugins/select2/select2.css"/>

    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url();?>assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>

    <!----- COMMON CSS------->

    <link href="<?php echo base_url();?>/assets/global/css/components-md.css?<?php echo date('Y-m-d H:i:s');?>" id="style_components" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>/assets/global/css/plugins-md.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>/assets/admin/layout4/css/layout.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url();?>/assets/admin/layout4/css/light.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>

    <link href="<?php echo base_url(); ?>assets/site/css/validationEngine.jquery.css" rel="stylesheet">

    <link href="<?php echo base_url();?>/assets/admin/layout/css/custom.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>

<style>

.border-left-primary {

    border-left: 0.25rem solid #4e73df!important;

}

.border-left-grey {

    border-left: 0.25rem solid #808080!important;

}

.border-left-purple {

    border-left: 0.25rem solid #800080!important;

}

.border-left-red {

    border-left: 0.25rem solid #D32D41!important;

}

.border-left-dark-red {

    border-left: 0.25rem solid #AC3E31!important;

}





.pb-2, .py-2 {

    padding-bottom: 0.5rem!important;

}

.pt-2, .py-2 {

    padding-top: 0.5rem!important;

}

.shadow {

    box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;

}

.border-left-success {

    border-left: 0.25rem solid #1cc88a!important;

}

.border-left-info {

    border-left: 0.25rem solid #36b9cc!important;

}

.border-left-warning {

    border-left: 0.25rem solid #f6c23e!important;

}

.text-warning {

    color: #f6c23e!important;

}

.border-left-orange {

    border-left: 0.25rem solid #8B4000!important;

}

.text-orange {

    color: #8B4000!important;

}

.border-left-red {

    border-left: 0.25rem solid #C70039!important;

}

.text-red {

    color: #C70039!important;

}

.text-dark-red {

    color: #AC3E31!important;

}

.border-left-light-blue {

    border-left: 0.25rem solid #4CB5F5!important;

}

.text-light-blue {

    color: #4CB5F5!important;

}

.border-left-oblue {

    border-left: 0.25rem solid #00BEC7!important;

}

.text-oblue {

    color: #00BEC7!important;

}

.border-left-orange-light {

    border-left: 0.25rem solid #FF5733!important;

}

.text-orange-light {

    color: #FF5733!important;

}

.no-gutters>.col, .no-gutters>[class*=col-] {

    padding-right: 0;

    padding-left: 0;

}

.text-gray-300 {

    color: #dddfeb!important;

}

.mr-2, .mx-2 {

    margin-right: 0.5rem !important;

}

.col {

    flex-basis: 0;

    flex-grow: 1;

    max-width: 100%;

}

.col-auto {

    flex: 0 0 auto;

    width: auto;

    max-width: 100%;

}

.h-100 {

    height: 100%!important;

}

.card-body {

    flex: 1 1 auto;

    min-height: 1px;

    padding: 1.25rem;

}

.text-xs {

    font-size: 1.1rem;

    text-transform: capitalize;

}

.text-xs-h {

    font-size: 1.2rem;

    text-transform: capitalize;

}

.text-gray-800 {

    color: #5a5c69!important;

}

.text-primary {

    color: #4e73df!important;

}

.text-purple {

    color: #800080!important;

}

.text-red {

    color: #D32D41!important;

}



.font-weight-bold {

    font-weight: 600!important;

}

.mb-1, .my-1 {

    margin-bottom: 0.25rem!important;

}

.align-items-center {

    align-items: center!important;

}

.no-gutters {

    margin-right: 0;

    margin-left: 0;

}

.card {

    position: relative;

    display: flex;

    flex-direction: column;

    min-width: 0;

    word-wrap: break-word;

    background-color: #fff;

    background-clip: border-box;

    border: 1px solid #e3e6f0;

    border-radius: 0.35rem;

}

.no-gutters {

    display: flex;

    flex-wrap: wrap;

}
.stopPaymentList{
    padding: 10px;
    background: #e6c2ad;
    margin: 10px 5px 10px 0px;
    border-radius: 10px;
}

.notification-container {
    max-height: 300px;          /* Fixed height for scrolling */
    overflow-y: auto;           /* Enable vertical scrolling */
}

.notification-container::-webkit-scrollbar {
    width: 6px;                 /* Set scrollbar width */
}

.notification-container::-webkit-scrollbar-track {
    background: #f1f1f1;        /* Scrollbar track color */
}

.notification-container::-webkit-scrollbar-thumb {
    background-color: #888;     /* Scrollbar thumb color */
    border-radius: 10px;        /* Rounded corners */
}

.notification-container::-webkit-scrollbar-thumb:hover {
    background: #555;           /* Darker on hover */
}

.notiList {
    
    margin: 10px 5px 10px 0px;
   
}

</style>

</head>

<body class="page-md page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">

    <?php $this->load->view('common/header'); ?>

    <div class="clearfix"></div>

    <div class="page-container">

        <?php $this->load->view('common/sidebar'); ?> 

        <div class="page-content-wrapper">

            <div class="page-content">

                <div class="row" id="flashdata">

                    <div class="col-md-12"><?php echo $this->session->flashdata('message'); ?></div>

                </div>

                <div class="row">

                    <div class="col-xl-8 col-md-8 mb-12">

                    <div class="row">

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-success shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-success text-uppercase mb-1 w90">Order AMT</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-inr fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w50">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">FY Till Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> <?php echo(isset($order_amount_fy) && !empty($order_amount_fy))?number_format($order_amount_fy):'0'?></div>

                                        </div>

                                    </div>

                                    <div class="divider"></div>

                                    <div class="row no-gutters align-items-center w50">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">Current Month</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> <?php echo(isset($order_amount_cm) && !empty($order_amount_cm))?number_format($order_amount_cm):'0'?></div>

                                        </div>

                                        

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-primary shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-primary text-uppercase mb-1 w90">Billing Amount</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-file fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w50">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">FY Till Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> <?php echo(isset($billing_amount_fy) && !empty($billing_amount_fy))?number_format($billing_amount_fy):'0'?></div>

                                        </div>

                                    </div>

                                    <div class="divider"></div>

                                    <div class="row no-gutters align-items-center w50">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">Current Month</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> <?php echo(isset($billing_amount_cm) && !empty($billing_amount_cm))?number_format($billing_amount_cm):'0'?></div>

                                        </div>

                                        

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row" style="padding-top:20px;">

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-warning shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-warning text-uppercase mb-1 w90">Payment Overdue</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-inr fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w100">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">As On Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> <?php echo(isset($payment_overdue_amt) && !empty($payment_overdue_amt))?number_format($payment_overdue_amt):'0'?></div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-orange-light shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-orange-light text-uppercase mb-1 w90">Collections Amount</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-inr fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w50">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">FY Till Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> <?php echo(isset($collection_amount_fy) && !empty($collection_amount_fy))?number_format($collection_amount_fy):'0'?></div>

                                        </div>

                                    </div>

                                    <div class="divider"></div>

                                    <div class="row no-gutters align-items-center w50">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">Current Month</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> <?php echo(isset($collection_amount_cm) && !empty($collection_amount_cm))?number_format($collection_amount_cm):'0'?></div>

                                        </div>

                                        

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row" style="padding-top:20px;">

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-success shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-success text-uppercase mb-1 w90">Stock Amount</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-inr fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w100">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">As On Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> 1,00,000</div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-purple shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-purple text-uppercase mb-1 w90">WIP Amount</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-inr fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w100">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">As on Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> 1,00,000</div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row" style="padding-top:20px;">

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-primary shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-primary text-uppercase mb-1 w90">Proforma Invoice Amount</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-file fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w50">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">FY Till Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> <?php echo(isset($proforma_amount_fy) && !empty($proforma_amount_fy))?number_format($proforma_amount_fy):'0'?></div>

                                        </div>

                                    </div>

                                    <div class="divider"></div>

                                    <div class="row no-gutters align-items-center w50">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">Current Month</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> <?php echo(isset($proforma_amount_cm) && !empty($proforma_amount_cm))?number_format($collection_amount_fy):'0'?></div>

                                        </div>

                                        

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-red shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-red text-uppercase mb-1 w90">Indirect Cost Amount Paid</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-inr fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w50">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">FY Till Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> 1,00,000</div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row" style="padding-top:20px;">

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-dark-red shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-dark-red text-uppercase mb-1 w90">Payable Overdue</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-inr fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w100">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">As On Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> 1,00,000</div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-warning shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-warning text-uppercase mb-1 w90">Voucher Payable Count & Amount</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-inr fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w100">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">As On Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> 1,00,000</div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row" style="padding-top:20px;">

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-light-blue shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-light-blue text-uppercase mb-1 w90">Incentive Payable Count & Amount</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-inr fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w100">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">As On Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> 1,00,000</div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-purple shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-purple text-uppercase mb-1 w90">Operator Salary Payable Amount</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-inr fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w100">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">FY Till Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> 1,00,000</div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row" style="padding-top:20px;">

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-light-blue shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-light-blue text-uppercase mb-1 w90">Direct Cost Amount Paid</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-inr fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w100">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">FY Till Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> 1,00,000</div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-success shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-success text-uppercase mb-1 w90">Deposits</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-inr fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w100">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">As on Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> <?php echo(isset($deposite_amount) && !empty($deposite_amount))?number_format($deposite_amount):'0'?></div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row" style="padding-top:20px;">

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-purple shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-purple text-uppercase mb-1 w90">Retention</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-inr fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w100">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">As on Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> <?php echo(isset($retention_amt) && !empty($retention_amt))?number_format($retention_amt):'0'?></div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-orange-light shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-orange-light text-uppercase mb-1 w90">Bank Guarantee In Force</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-inr fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w100">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">As on Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> <?php echo(isset($bank_guarantee_amt) && !empty($bank_guarantee_amt))?number_format($bank_guarantee_amt):'0'?></div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row" style="padding-top:20px;">

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-success shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-success text-uppercase mb-1 w90">Loan Account Balance</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-inr fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w100">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">As on Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;"><i class="fa fa-inr" style="font-weight: 400 !important;font-size: smaller;"></i> 1,00,000</div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-red shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-red text-uppercase mb-1 w90">Action Required</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-tasks fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w100">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">As on Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;">34</div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row" style="padding-top:20px;">

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-red shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-red text-uppercase mb-1 w90">Action Not Taken</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-tasks fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w100">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">As on Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;">30</div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-xl-6 col-md-6 mb-6">

                            <div class="card border-left-primary shadow h-100 py-2">

                                <div class="card-body-db">

                                    <div class="w100 ptb10 dflex">

                                        <div class="text-xs-h font-weight-bold text-primary text-uppercase mb-1 w90">Compliance</div>

                                        <div class="col-auto w10">

                                            <i class="fa fa-file fa-2x text-gray-300"></i>

                                        </div>

                                    </div>

                                    <div class="dflex">

                                    <div class="row no-gutters align-items-center w100">

                                        <div class="col mr-2">

                                            <div class="text-xs font-weight-bold cmgreyclr text-uppercase mb-1">As on Date</div>

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-weight: 400 !important;font-size: smaller;">100</div>

                                        </div>

                                    </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    </div>

                    <div class="col-xl-4 col-md-4 mb-4">

                            <div class="card border-left-grey shadow h-100 py-2">

                                <div class="card-body">

                                    <div class="profilephoto text-center">

                                    <img alt="" class="img-circle" src="https://trackigo.in/prudent/assets/admin/layout4/img/default.png" width="80px" height="80px">    

                                    </div>

                                    <div class="userName text-center">User Name</div>

                                    <div class="userAddr text-center"><i class="fa fa-map-marker" aria-hidden="true"></i> Pune, Maharashtra</div>

                                    <div class="useraction row">

                                        <div class="col-md-6">

                                            <div class="userViewProfile">View Profile</div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="userEditProfile">Edit Profile</div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="card border-left-grey shadow h-100 py-2" style="margin-top:10px;">

                                <div class="card-body">

                                    <div class="dflex">

                                        <div class="w80" style="font-weight: 600;">Notifications</div>

                                        <div class="w20" style="color:#5b9bd1;font-size:12px;cursor:pointer;">View All</div>

                                    </div>
                                    <div class="notification-container" style="max-height: 450px; overflow-y: auto;">
                                    <div class="notiList dflex">

                                        <div class="notiDetails w100">

                                            <div class="notTile">Lorem Ipsum is simply dummy text</div>

                                            <div class="notTxt">Lorem Ipsum is simply dummy textLorem Ipsum is simply dummy text</div>

                                        </div>

                                    </div>

                                    <div class="notiList dflex">

                                        <div class="notiDetails w100">

                                            <div class="notTile">Lorem Ipsum is simply dummy text</div>

                                            <div class="notTxt">Lorem Ipsum is simply dummy textLorem Ipsum is simply dummy text</div>

                                        </div>

                                    </div>

                                    <div class="notiList dflex">

                                        <div class="notiDetails w100">

                                            <div class="notTile">Lorem Ipsum is simply dummy text</div>

                                            <div class="notTxt">Lorem Ipsum is simply dummy textLorem Ipsum is simply dummy text</div>

                                        </div>

                                    </div>

                                    <div class="notiList dflex">

                                        <div class="notiDetails w100">

                                            <div class="notTile">Lorem Ipsum is simply dummy text</div>

                                            <div class="notTxt">Lorem Ipsum is simply dummy textLorem Ipsum is simply dummy text</div>

                                        </div>

                                    </div>

                                    <div class="notiList dflex">

                                        <div class="notiDetails w100">

                                            <div class="notTile">Lorem Ipsum is simply dummy text</div>

                                            <div class="notTxt">Lorem Ipsum is simply dummy textLorem Ipsum is simply dummy text</div>

                                        </div>

                                    </div>

                                    <div class="notiList dflex">

                                        <div class="notiDetails w100">

                                            <div class="notTile">Lorem Ipsum is simply dummy text</div>

                                            <div class="notTxt">Lorem Ipsum is simply dummy textLorem Ipsum is simply dummy text</div>

                                        </div>

                                    </div>

                                    <div class="notiList dflex">

                                        <div class="notiDetails w100">

                                            <div class="notTile">Lorem Ipsum is simply dummy text</div>

                                            <div class="notTxt">Lorem Ipsum is simply dummy textLorem Ipsum is simply dummy text</div>

                                        </div>

                                    </div>

                                    <div class="notiList dflex">

                                        <div class="notiDetails w100">

                                            <div class="notTile">Lorem Ipsum is simply dummy text</div>

                                            <div class="notTxt">Lorem Ipsum is simply dummy textLorem Ipsum is simply dummy text</div>

                                        </div>

                                    </div>

                                    <div class="notiList dflex">

                                        <div class="notiDetails w100">

                                            <div class="notTile">Lorem Ipsum is simply dummy text</div>

                                            <div class="notTxt">Lorem Ipsum is simply dummy textLorem Ipsum is simply dummy text</div>

                                        </div>

                                    </div>

                                    <div class="notiList dflex">

                                        <div class="notiDetails w100">

                                            <div class="notTile">Lorem Ipsum is simply dummy text</div>

                                            <div class="notTxt">Lorem Ipsum is simply dummy textLorem Ipsum is simply dummy text</div>

                                        </div>

                                    </div>

                                </div>
                                </div>

                            </div>

                            <div class="card border-left-grey shadow h-100 py-2" style="margin-top:10px;">

<div class="card-body">

    <div class="dflex">

        <div class="w80" style="font-weight: 600;">Stop Payment</div>

        <!--<div class="w20" style="color:#5b9bd1;font-size:12px;cursor:pointer;">View All</div>-->

    </div>
    <div class="notification-container" style="max-height: 450px; overflow-y: auto;">
    <?php if(count($stop_payment_vendor) > 0){ 
                                        foreach ($stop_payment_vendor as $key => $value) { ?>
                                        <div class="stopPaymentList dflex">
                                            <div class="notiDetails w100">
                                                <div class="notTxt">Stop Payment has been initiated/issued for <b><?php echo $value['vendor_name']; ?></b></div>
                                            </div>
                                        </div>
                                    <?php  }
                                        } else { ?>
                                            <div class=" dflex" style="padding: 14px;margin: auto;text-align: center;">
                                                <div class=" w100">
                                                    <?php echo '<div class="notTxt">No Stop Payment Found.</div>'; ?>
                                                 </div>
                                            </div>
                                    <?php } ?>

    </div>

</div>

</div>

                        </div>

                </div>

            </div>

        </div>

    </div>

    <?php $this->load->view('common/footer'); ?>

    <!-- END FOOTER -->

    <script type="text/javascript" src="<?php echo base_url();?>/assets/global/plugins/jquery.min.js" ></script>

    <script type="text/javascript" src="<?php echo base_url();?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" ></script>

    <script type="text/javascript" src="<?php echo base_url();?>/assets/global/plugins/uniform/jquery.uniform.min.js" ></script>

    <script type="text/javascript" src="<?php echo base_url();?>/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" ></script>

    <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-multiselect/js/components-bootstrap-multiselect.js" type="text/javascript"></script>

    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.js"></script>

    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/jquery-validation/lib/jquery.form.js"></script>

    <!-- COMMON LEVEL js -->

    <script type="text/javascript" src="<?php echo base_url();?>/assets/global/scripts/metronic.js" ></script>

    <script type="text/javascript" src="<?php echo base_url();?>/assets/admin/layout4/scripts/layout.js" ></script>

    <script type="text/javascript" src="<?php echo base_url();?>assets/global/plugins/bootbox/bootbox.min.js"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>

    <script src="<?php echo base_url();?>assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/select2/select2.min.js" type="text/javascript" ></script>

    <script>

    jQuery(document).ready(function() {    

        Metronic.init(); // init metronic core componets

        Layout.init(); // init layout

        Demo.init(); // init demo features

        // Index.init(); // init index page

        Tasks.initDashboardWidget(); // init tash dashboard widget 

        $('#flashdata').delay(2000).fadeOut('slow');

    });

    $(document).ready(function() {
        var p_url = $("#p_url").val();
        $(".p_search_boq_item").select2({
            minimumInputLength: 4,
            ajax: {
            url: p_url + 'get_all_item_list',
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                term: term,
                type: $("#p_search_type").val(), 
                };
            },
            results: function (data) {
                return {
                results: data.users
                };
            }
            }
        });
        
        $('#p_search_type').select2({
            minimumResultsForSearch: -1
        });

        $(document).on("change", "#p_search_type", function () {
            var project_id = $(this).val();
            if (project_id) {
                $(".p_search_boq_item").select2("val", "");
            }
        });
    });

    </script>

</body>

</html>