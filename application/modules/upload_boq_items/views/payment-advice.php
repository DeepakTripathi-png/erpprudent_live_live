<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8" />

    <title>Payment Receipt | <?php echo project_name; ?> </title>

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

    <style>

        .adbtn {

            padding: 2px 6px;

            background: #26a69a;

            color: #fff;

            border-radius: 50%;

            width: 20px;

            font-size: 7px;

            height: 20px;

            cursor: pointer;

            margin: 25px auto;

        }

       .txdd{

            padding: 2px 6px;

            background: #26a69a;

            color: #fff;

            border-radius: 50%;

            width: 20px;

            font-size: 7px;

            height: 20px;

            cursor: pointer;

            margin: 25px auto;

        }

       .desadd{

            padding: 2px 6px;

            background: #26a69a;

            color: #fff;

            border-radius: 50%;

            width: 20px;

            font-size: 7px;

            height: 20px;

            cursor: pointer;

            margin: 25px auto;

        }

       .withhdadbtn{

            padding: 2px 6px;

            background: #26a69a;

            color: #fff;

            border-radius: 50%;

            width: 20px;

            font-size: 7px;

            height: 20px;

            cursor: pointer;

            margin: 25px auto;

        }

       .cdadbtn{

            padding: 2px 6px;

            background: #26a69a;

            color: #fff;

            border-radius: 50%;

            width: 20px;

            font-size: 7px;

            height: 20px;

            cursor: pointer;

            margin: 25px auto;

        }

       .dedescadbtn{

            padding: 2px 6px;

            background: #26a69a;

            color: #fff;

            border-radius: 50%;

            width: 20px;

            font-size: 7px;

            height: 20px;

            cursor: pointer;

            margin: 25px auto;

        }



        .ddrmbtn{

            padding: 2px 6px;

            background: #a94442;

            color: #fff;

            border-radius: 50%;

            width: 20px;

            font-size: 7px;

            height: 20px;

            cursor: pointer;

            margin: 5px auto;

        }

        .wdrmbtn{

            padding: 2px 6px;

            background: #a94442;

            color: #fff;

            border-radius: 50%;

            width: 20px;

            font-size: 7px;

            height: 20px;

            cursor: pointer;

            margin: 5px auto;

        }

        .cesrmbtn{

            padding: 2px 6px;

            background: #a94442;

            color: #fff;

            border-radius: 50%;

            width: 20px;

            font-size: 7px;

            height: 20px;

            cursor: pointer;

            margin: 5px auto;

        }

        .desdecrmbtn{

            padding: 2px 6px;

            background: #a94442;

            color: #fff;

            border-radius: 50%;

            width: 20px;

            font-size: 7px;

            height: 20px;

            cursor: pointer;

            margin: 5px auto;

        }

        .rmbtnss{

            padding: 2px 6px;

            background: #a94442;

            color: #fff;

            border-radius: 50%;

            width: 20px;

            font-size: 7px;

            height: 20px;

            cursor: pointer;

            margin: 5px auto;

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

                    <div class="row">

                        <div class="col-md-12">

                            <div class="portlet light">

                                <div class="portlet-title">

                                    <div class="caption font-blue"> <i class="fa fa-plus-circle font-blue"></i> <span class="caption-subject bold uppercase"><?php if(isset($tax_invc_no) && !empty($tax_invc_no)){ echo '(#'.$tax_invc_no.')'; } ?> Payment Receipt</span> </div>

                                </div>

                                <div class="portlet-body form">

                                    <form action="save_payment_advice" id="save_payment_advice" class="horizontal-form" method="post" enctype="multipart/form-data">

                                        <div class="form-body">

                                            <div class="panel panel-default">

                                            <div class="panel-heading">

                                                <h4 class="panel-title"></h4>

                                            </div>

                                            <div class="panel-body">

                                            <input type="hidden" name="received_payment" id="received_payment" value="<?php echo (isset($received_payment) && !empty($received_payment)) ? $received_payment : '0.00' ?>">

            								<div class="row">

                                                <div class="col-md-3">

            										<div class="form-group">

            											<label class="">Payment Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>

            											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">

            												<input type="text" name="payment_date" id="payment_date" class="form-control" readonly="" placeholder="Payment Date" >		

            												<span class="input-group-btn">

            													<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>

            												</span>

            											</div>

            										</div> 

            									</div>

            									<!--<div class="col-md-3">

                                                        <div class="form-group">

                                                            <label class="">Payment Account <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <select class="form-control select2me" name="payment_account_name" id="payment_account_name" required>

                                                                <option value="">--Select--</option>

                                                                <option value="1">Payment Account 1</option>

                                                                <option value="2">Payment Account 2</option>

                                                                <option value="3">Payment Account 3</option>

                                                            </select>

                                                        </div>

                                                </div>-->

            									<div class="col-md-3">

                                                        <div class="form-group">

                                                            <label class="">Payment Account <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <select class="form-control select2me" name="bank_acc_no" id="bank_acc_no" required>

                                                                <option value="0">--Select--</option>

                                                               <option value="018011300001395/Janakalyan Sahakari Bank Ltd (Prudent Controls)">018011300001395/Janakalyan Sahakari Bank Ltd (Prudent Controls)</option>
                                                                <option value="3736008730003259/Punjab National Bank (Prudent Controls)">3736008730003259/Punjab National Bank (Prudent Controls)</option>
                                                                <option value="CA\1395/Janaklyan Sahakari Bank (Prudent Controls)">CA\1395/Janaklyan Sahakari Bank (Prudent Controls)</option>
                                                                <option value="5651000009667/Union Bank of India (Prudent Controls)">5651000009667/Union Bank of India (Prudent Controls)</option>
                                                                <option value="1199385225148537/Standard Chartered Bank (Prudent Controls)">1199385225148537/Standard Chartered Bank (Prudent Controls)</option>
                                                                <option value="510101000653135/Union Bank of India (Prudent Controls)">510101000653135/Union Bank of India (Prudent Controls)</option>

                                                                <option value="018013500000016/Janakalyan Sahakari Bank Ltd (Prudent EPC)">018013500000016/Janakalyan Sahakari Bank Ltd (Prudent EPC)</option>
                                                                <option value="3736008730003213/Punjab National Bank (Prudent EPC)">3736008730003213/Punjab National Bank (Prudent EPC)</option>
                                                                <option value="16431012000831/Punjab National Bank (Prudent EPC)">16431012000831/Punjab National Bank (Prudent EPC)</option>
                                                                <option value="2301/114/Janta Sahakari Bank Ltd (Prudent EPC)">2301/114/Janta Sahakari Bank Ltd (Prudent EPC)</option>
                                                                <option value="018011300001389/Jankalyan Sahakari Bank (Prudent EPC)">018011300001389/Jankalyan Sahakari Bank (Prudent EPC)</option>

                                                            </select>

                                                        </div>

                                                </div>



                                                <input type="hidden" name="tax_invc_id" value="<?php echo (isset($tax_invc_id) && !empty($tax_invc_id)) ? $tax_invc_id : '' ?>">

            									<div class="col-md-6">

                                                    <div class="form-group">

                                                        <label>Bank Credit Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                        <div class="input-icon right">

                                                             <i class="fa"></i>

                                                             <input type="text" class="form-control payment_received_amount_chk" data-type="payment_received_amount" id="payment_received_amount" name="payment_received_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Payment Amount Received" value="<?php echo (isset($payment_pay) && !empty($payment_pay)) ? $payment_pay : '0.00' ?>" data-id="<?php echo (isset($tax_invc_id) && !empty($tax_invc_id)) ? $tax_invc_id : '0' ?>" max="<?php echo (isset($payment_pay) && !empty($payment_pay)) ? $payment_pay : '0.00' ?>" required>

                                                        </div>

                                                    </div>

                                                </div>

                                                </div>

            									<div class="row">

            									<div class="col-md-3">

            										<div class="form-group">

            											<label class="">Invoice Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            											<input type="text" name="invoice_date" id="invoice_date" class="form-control" readonly="" placeholder="Invoice Date" value="<?php if(isset($tax_invc_date) && !empty($tax_invc_date)){ echo date('d-m-Y',strtotime($tax_invc_date)); } ?>">		


            											<!--<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">-->

            											<!--	<input type="text" name="invoice_date" id="invoice_date" class="form-control" readonly="" placeholder="Invoice Date" value="<?php if(isset($tax_invc_date) && !empty($tax_invc_date)){ echo date('d-m-Y',strtotime($tax_invc_date)); } ?>">		-->

            											<!--	<span class="input-group-btn">-->

            											<!--		<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>-->

            											<!--	</span>-->

            											<!--</div>-->

            										</div> 

            									</div>

            									<div class="col-md-3">

                                                    <div class="form-group">

                                                        <label>Invoice No <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                        <div class="input-icon right">

                                                             <i class="fa"></i>

                                                             <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Invoice No" value="<?php if(isset($tax_invc_no) && !empty($tax_invc_no)){ echo $tax_invc_no; } ?>" readonly>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="col-md-6">

                                                    <div class="form-group">

                                                        <label>Invoice Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                        <div class="input-icon right">

                                                             <i class="fa"></i>

                                                             <input type="text" class="form-control " id="invoice_amount" name="invoice_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  value="<?php if(isset($total_amount) && !empty($total_amount)){ echo $total_amount; } ?>"  placeholder="Invoice Amount" required readonly>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-md-6">

                                                    <div class="form-group">

                                                        <label>Client Name <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                        <div class="input-icon right">

                                                             <i class="fa"></i>

                                                             <input type="text" class="form-control " id="client_name" name="client_name" value="<?php if(isset($customer_name) && !empty($customer_name)){ echo $customer_name; } ?>" readonly>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="col-md-6">

                                                    <div class="form-group">

                                                        <label>Remark</label>

                                                        <div class="input-icon right">

                                                             <i class="fa"></i>

                                                             <input type="text" class="form-control " id="remark" name="remark" placeholder="Remark">

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-md-3">

                                                        <div class="form-group">

                                                            <label class="">Contract Deposit (EMD) <br>Received <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="dflx">

                                                            <input type="radio" name="contarct_deposit_emd_rec" id="contarct_deposit_emd_rec_yes" class="contarct_deposit_emd_recclass" value="Yes" required><span style="padding: 0 10px 0px 5px;">Yes</span>

                                                            <input type="radio" name="contarct_deposit_emd_rec" id="contarct_deposit_emd_rec_no" class="contarct_deposit_emd_recclass" value="No" checked required><span style="padding: 0 10px 0px 5px;">No</span>

                                                            </div>

                                                        </div>

                                                </div>

                                                <div class="col-md-3">

                                                        <div class="form-group">

                                                            <label class="">Contract Deposit (ASD) <br>Received <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="dflx">

                                                            <input type="radio" name="contarct_deposit_asd_rec" id="contarct_deposit_asd_rec_yes" class="contarct_deposit_asd_rec_class" value="Yes" required><span style="padding: 0 10px 0px 5px;">Yes</span>

                                                            <input type="radio" name="contarct_deposit_asd_rec" id="contarct_deposit_asd_rec_no" class="contarct_deposit_asd_rec_class" value="No" checked required><span style="padding: 0 10px 0px 5px;">No</span>

                                                            </div>

                                                        </div>

                                                </div>

                                            </div>

                                            <div id="contarct_deposit_emd_div"></div>

                                            <div id="contarct_deposit_asd_div"></div>

                                            </div>

                                            </div>

                                            <div class="panel panel-default">

                                            <div class="panel-heading">

                                                <h4 class="panel-title">Statutory Deductions</h4>

                                            </div>

                                            <div class="panel-body">

                                                <div class="row">

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label>IT TDS Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                <input type="text" class="form-control payment_received_amount_chk" data-type="it_tds_amount" id="it_tds_amount" name="it_tds_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="IT TDS Amount" value="0" data-id="<?php echo (isset($tax_invc_id) && !empty($tax_invc_id)) ? $tax_invc_id : '0' ?>" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label>GTDS Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                <input type="text" class="form-control payment_received_amount_chk" data-type="gtds_amount" id="gtds_amount" name="gtds_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="GTDS Amount" value="0" data-id="<?php echo (isset($tax_invc_id) && !empty($tax_invc_id)) ? $tax_invc_id : '0' ?>" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <hr style="margin: 10px 0;">

                                                <div class="row">

                                                    <div class="col-md-12">

                                                        <label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">Any Other Tax Deduction</label>

                                                    </div>

                                                </div>

                                                <div id="tax_ded_des" style="font-size: 12px;color:#F3565D;margin-bottom: 10px;"></div>

                                                <div class="row">

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label>Tax Deduction Description </label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                 <input type="text" class="form-control " name="tax_deduction_desc[]" id="tax_deduction_desc" placeholder="Tax Deduction Description">

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-5">

                                                        <div class="form-group">

                                                            <label>Tax Deduction Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                <input type="text" class="form-control tax_deduction_amt payment_received_amount_chk" data-type="tax_deduction_amt" id="tax_deduction_amt" name="tax_deduction_amt[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Tax Deduction Amount" value="0" data-id="<?php echo (isset($tax_invc_id) && !empty($tax_invc_id)) ? $tax_invc_id : '0' ?>" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-1"><div class="txdd"><i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i></div></div>

                                                </div>

                                                <div id="addtxdd"></div>

                                            </div>

                                            </div>

                                            <div class="panel panel-default">

                                            <div class="panel-heading">

                                                <h4 class="panel-title">Refundables</h4>

                                            </div>

                                            <div class="panel-body">

                                                <div class="row">

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label>Security Deposit Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                 <input type="text" class="form-control payment_received_amount_chk" data-type="security_deposit_retn_amount" id="security_deposit_retn_amount" name="security_deposit_retn_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Security Deposit Retention Amount" value="0" data-id="<?php echo (isset($tax_invc_id) && !empty($tax_invc_id)) ? $tax_invc_id : '0' ?>" max="<?php echo (isset($payment_pay) && !empty($payment_pay)) ? $payment_pay : '0.00' ?>" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">
                                                            <div class="form-group">
                                                            <label>Retational Amount </label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control payment_received_amount_chk" data-type="retenstion_amount" id="retenstion_amount" name="retenstion_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Retational Amount" value="<?php echo (isset($retenstion_amount) && !empty($retenstion_amount)) ? $retenstion_amount : '0' ?>" data-id="<?php echo (isset($tax_invc_id) && !empty($tax_invc_id)) ? $tax_invc_id : '0' ?>" max="<?php echo (isset($payment_pay) && !empty($payment_pay)) ? $payment_pay : '0.00' ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <hr style="margin: 10px 0;">

                                                <div class="row">

                                                    <div class="col-md-12">

                                                        <label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">Any Other Deposit</label>

                                                    </div>

                                                </div>

                                                <div id="depo_des_error" style="font-size: 12px;color:#F3565D;margin-bottom: 10px;"></div>

                                                <div class="row">

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label>Deposit Description </label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                 <input type="text" class="form-control " name="deposit_desc[]" id="deposit_desc" placeholder="Deposit Description">

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-5">

                                                        <div class="form-group">

                                                            <label>Deposit Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                <input type="text" class="form-control deposit_amount payment_received_amount_chk" data-type="deposit_amount" id="deposit_amount" name="deposit_amount[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Deposit Amount" value="0" data-id="<?php echo (isset($tax_invc_id) && !empty($tax_invc_id)) ? $tax_invc_id : '0' ?>" max="<?php echo (isset($payment_pay) && !empty($payment_pay)) ? $payment_pay : '0.00' ?>" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-1"><div class="desadd"><i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i></div></div>

                                                </div>

                                                <div id="deposesc"></div>

                                                <hr style="margin: 10px 0;">

                                                <div class="row">

                                                    <div class="col-md-12">

                                                        <label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">Withheld</label>

                                                    </div>

                                                </div>

                                                <div id="with_held_error" style="font-size: 12px;color:#F3565D;margin-bottom: 10px;"></div>

                                                <div class="row">

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label>Withheld Description <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                 <input type="text" class="form-control " name="withheld_desc[]" id="withheld_desc" placeholder="Withheld Description">

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-5">

                                                        <div class="form-group">

                                                            <label>Withheld Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                <input type="text" class="form-control withheld_amt payment_received_amount_chk" data-type="withheld_amt" id="withheld_amt" name="withheld_amt[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Withheld Amount" value="0" data-id="<?php echo (isset($tax_invc_id) && !empty($tax_invc_id)) ? $tax_invc_id : '0' ?>" max="<?php echo (isset($payment_pay) && !empty($payment_pay)) ? $payment_pay : '0.00' ?>" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-1"><div class="withhdadbtn"><i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i></div></div>

                                                </div>



                                                <div id="rowwithheld"></div>

                                                

                                            </div>

                                            </div>

                                            <div class="panel panel-default">

                                            <div class="panel-heading">

                                                <h4 class="panel-title">Non-Refundables</h4>

                                            </div>

                                            <div class="panel-body">

                                                <div class="row">

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label>Labour Cess <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                <input type="text" class="form-control payment_received_amount_chk" data-type="labour_cess" id="labour_cess" name="labour_cess" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Labour Cess" value="0" data-id="<?php echo (isset($tax_invc_id) && !empty($tax_invc_id)) ? $tax_invc_id : '0' ?>" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label>Debit Note / Credit Note / LD </label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                 <input type="text" class="form-control " name="debit_note" id="debit_note"  placeholder="Debit Note / Credit Note / LD">

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <hr style="margin: 10px 0;">

                                                <div class="row">

                                                    <div class="col-md-12">

                                                        <label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">Any Other Cess</label>

                                                    </div>

                                                </div>

                                                <div id="cess_desc_error" style="font-size: 12px;color:#F3565D;margin-bottom: 10px;"></div>

                                                <div class="row">

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label>Cess Description </label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                 <input type="text" class="form-control " name="other_cess_desc[]" id="other_cess_desc" placeholder="Cess Description" >

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-5">

                                                        <div class="form-group">

                                                            <label>Cess Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                <input type="text" class="form-control other_cess_amt payment_received_amount_chk" data-type="other_cess_amt" id="other_cess_amt" name="other_cess_amt[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Cess Amount" value="0" data-id="<?php echo (isset($tax_invc_id) && !empty($tax_invc_id)) ? $tax_invc_id : '0' ?>" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-1"><div class="cdadbtn"><i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i></div></div>

                                                </div>

                                                <div id="rowcess"></div>

                                                <hr style="margin: 10px 0;">

                                                <div class="row">

                                                    <div class="col-md-12">

                                                        <label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">Any Other Deductions</label>

                                                    </div>

                                                </div>

                                                <div id="ded_descp_error" style="font-size: 12px;color:#F3565D;margin-bottom: 10px;"></div>

                                                <div class="row">

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label>Deduction Description </label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                 <input type="text" class="form-control " name="deduction_desc[]" id="deduction_desc" placeholder="Deduction Description">

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-5">

                                                        <div class="form-group">

                                                            <label>Deduction Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                    <input type="text" class="form-control deduction_amt payment_received_amount_chk" data-type="deduction_amt" id="deduction_amt" name="deduction_amt[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Deduction Amount" value="0" data-id="<?php echo (isset($tax_invc_id) && !empty($tax_invc_id)) ? $tax_invc_id : '0' ?>" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-1"><div class="dedescadbtn"><i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i></div></div>

                                                </div>

                                                <div id="newaddded"></div>

                                            </div>

                                            </div>

                                            <div class="panel panel-default">

                                            <div class="panel-heading">

                                                <h4 class="panel-title"></h4>

                                            </div>

                                            <div class="panel-body">

                                            <div class="row">

                                                <div class="col-md-4">

                                                        <div class="form-group">

                                                            <label class="">Payment Receipt Copy Received <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="dflx">

                                                            <input type="radio" name="payment_advice_received" id="payment_advice_received_yes" class="payment_advice_receivedcclass" value="Yes" checked required><span style="padding: 0 10px 0px 5px;">Yes</span>

                                                            <input type="radio" name="payment_advice_received" id="payment_advice_received_no" class="payment_advice_receivedcclass" value="No" required><span style="padding: 0 10px 0px 5px;">No</span>

                                                            </div>

                                                        </div>

                                                </div>

                                                <div class="col-md-4" id="payment_advice_received_date_d">

            										<div class="form-group">

            											<label class="">Payment Receipt Copy Received Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>

            											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">

            												<input type="text" name="payment_advice_received_date" id="payment_advice_received_date" class="form-control" readonly="" placeholder="Payment Advice Copy Received Date" >		

            												<span class="input-group-btn">

            													<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>

            												</span>

            											</div>

            										</div> 

            									</div>

            									<div class="col-md-4" id="payment_advice_doc_d">

                                                        <div class="form-group">

                                                            <label class="control-label">Upload Payment Receipt Document <span class="require" aria-required="true" style="color:#a94442">*</span></label><br>

                                                            <input type="file" name="payment_advice_doc" id="payment_advice_doc" class="payment_advice_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />

                                                            <span id="payment_advice_doc_error" style="font-size: 12px;color:#a94442;"></span>

                                                        </div>

                                                </div>

                                                

                                            </div>

                                            </div>

                                            </div>

                                        </div>

                                        <div class="form-actions right"> <a href="<?php echo base_url();?>create-tax-invoice" class="btn blue" style="float: left;">Back</a> <button type="button" class="btn btn-danger cancel clearData" title="click To Cancel"> Cancel</button> <button type="submit" class="btn green common_save" title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> Save</button></div>

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