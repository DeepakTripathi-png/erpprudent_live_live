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
                                    <?php
                                    $paymentreceiptno=0;
                                    if(isset($payment_receipt_data[0]->payment_receipt_no) && !empty($payment_receipt_data[0]->payment_receipt_no)){
                                    if(strlen($payment_receipt_data[0]->payment_receipt_no) > 4){
                        			    $paymentreceiptno = $payment_receipt_data[0]->payment_receipt_no;
                        			}else{
                        			    $paymentreceiptno = sprintf('%04d',$payment_receipt_data[0]->payment_receipt_no);
                        			}
                        			}
                                    ?>
                                    <div class="caption font-blue"> <i class="fa fa-plus-circle font-blue"></i> <span class="caption-subject bold uppercase"><?php if(isset($paymentreceiptno) && !empty($paymentreceiptno)){ echo '(#'.$paymentreceiptno.')'; } ?> Payment Receipt Details</span> </div>
                                </div>
                                <div class="portlet-body form">
                                    <div class="form-body">
                                            <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title"></h4>
                                            </div>
                                            <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-3">
            										<div class="form-group">
            											<label class="">Payment Date</label>
            											<input type="text" class="form-control" id="payment_date" value="<?php echo (isset($payment_receipt_data[0]->payment_date) && !empty($payment_receipt_data[0]->payment_date)) ? date('d-m-Y',strtotime($payment_receipt_data[0]->payment_date)) : '-' ?>" readonly>
            										</div> 
            									</div>
            									<div class="col-md-3">
            										<div class="form-group">
            											<label class="">Payment Account</label>
            											<input type="text" class="form-control" id="bank_acc_no" value="<?php echo (isset($payment_receipt_data[0]->bank_acc_no) && !empty($payment_receipt_data[0]->bank_acc_no)) ? $payment_receipt_data[0]->bank_acc_no : '-' ?>" readonly>
            										</div> 
            									</div>
            									<div class="col-md-6">
            										<div class="form-group">
            											<label class="">Payment Amount Received</label>
            											<input type="text" class="form-control" id="payment_received_amount" value="<?php echo (isset($payment_receipt_data[0]->payment_received_amount) && !empty($payment_receipt_data[0]->payment_received_amount)) ? $payment_receipt_data[0]->payment_received_amount : '0.00' ?>" readonly>
            										</div> 
            									</div>
            									</div>
            									<div class="row">
            									<div class="col-md-3">
            										<div class="form-group">
            											<label class="">Invoice Date </label>
            											<input type="text" class="form-control" id="invoice_date" value="<?php echo (isset($tax_invc_date) && !empty($tax_invc_date)) ? date('d-m-Y',strtotime($tax_invc_date)) : '-' ?>" readonly>
            										</div> 
            									</div>
            									<div class="col-md-3">
            										<div class="form-group">
            											<label class="">Invoice No </label>
            											<input type="text" class="form-control" id="invoice_no" value="<?php echo (isset($tax_invc_no) && !empty($tax_invc_no)) ? $tax_invc_no : '-' ?>" readonly>
            										</div> 
            									</div>
            									<div class="col-md-6">
            										<div class="form-group">
            											<label class="">Invoice Amount </label>
            											<input type="text" class="form-control" id="invoice_amount" value="<?php echo (isset($invoice_amount) && !empty($invoice_amount)) ? $invoice_amount : '0.00' ?>" readonly>
            										</div> 
            									</div>
            								</div>
                                            <div class="row">
                                                <div class="col-md-6">
            										<div class="form-group">
            											<label class="">Client Name </label>
            											<input type="text" class="form-control" id="client_name" value="<?php echo (isset($payment_receipt_data[0]->client_name) && !empty($payment_receipt_data[0]->client_name)) ? $payment_receipt_data[0]->client_name : '0.00' ?>" readonly>
            										</div> 
            									</div>
            								    <div class="col-md-6">
            										<div class="form-group">
            											<label class="">Remark </label>
            											<input type="text" class="form-control" id="remark" value="<?php echo (isset($payment_receipt_data[0]->remark) && !empty($payment_receipt_data[0]->remark)) ? $payment_receipt_data[0]->remark : '-' ?>" readonly>
            										</div> 
            									</div>
            								</div>
                                            <div class="row">
                                                <div class="col-md-3">
            										<div class="form-group">
            											<label class="">Contract Deposit (EMD) <br>Received </label>
            											<input type="text" class="form-control" id="contarct_deposit_emd_rec" value="<?php echo (isset($payment_receipt_data[0]->contarct_deposit_emd_rec) && !empty($payment_receipt_data[0]->contarct_deposit_emd_rec)) ? $payment_receipt_data[0]->contarct_deposit_emd_rec : 'No' ?>" readonly>
            										</div> 
            									</div>
            									<div class="col-md-3">
            										<div class="form-group">
            											<label class="">Contract Deposit (ASD) <br>Received </label>
            											<input type="text" class="form-control" id="contarct_deposit_asd_rec" value="<?php echo (isset($payment_receipt_data[0]->contarct_deposit_asc_rec) && !empty($payment_receipt_data[0]->contarct_deposit_asc_rec)) ? $payment_receipt_data[0]->contarct_deposit_asc_rec : 'No' ?>" readonly>
            										</div> 
            									</div>
                                            </div>
                                            <?php if(isset($payment_receipt_data[0]->contarct_deposit_emd_rec) && !empty($payment_receipt_data[0]->contarct_deposit_emd_rec) && $payment_receipt_data[0]->contarct_deposit_emd_rec == 'Yes'){ ?>
                                            <div class="row">
                                                <div class="col-md-3">
                									<div class="form-group">
                									<label class="">Received Amount (EMD)</label>
                									<input type="text" class="form-control" id="received_amt" value="<?php echo (isset($payment_receipt_data[0]->received_amt) && !empty($payment_receipt_data[0]->received_amt)) ? $payment_receipt_data[0]->received_amt : '0.00' ?>" readonly>
                									</div> 
                								</div>
                								<div class="col-md-3">
                									<div class="form-group">
                										<label class="">Payment Date (EMD)</label>
                										<input type="text" class="form-control" id="emd_payment_date" value="<?php echo (isset($payment_receipt_data[0]->emd_payment_date) && !empty($payment_receipt_data[0]->emd_payment_date)) ? date('d-m-Y',strtotime($payment_receipt_data[0]->emd_payment_date)) : '' ?>" readonly>
                									</div> 
                								</div>
                								<div class="col-md-3">
                									<div class="form-group">
                									<label class="">Document Upload (EMD)</label>
                									<a href="<?php echo base_url();?>uploads/recipt/<?php echo (isset($payment_receipt_data[0]->emd_doc) && !empty($payment_receipt_data[0]->emd_doc)) ? $payment_receipt_data[0]->emd_doc : '' ?>" download>Download</a>
                									</div> 
                								</div>
                							</div>
                							<?php } ?>
                                            <?php if(isset($payment_receipt_data[0]->contarct_deposit_asc_rec) && !empty($payment_receipt_data[0]->contarct_deposit_asc_rec) && $payment_receipt_data[0]->contarct_deposit_asc_rec == 'Yes'){ ?>
                                            <div class="row">
                                                <div class="col-md-3">
                									<div class="form-group">
                									<label class="">Received Amount (ASD)</label>
                									<input type="text" class="form-control" id="asd_received_amount" value="<?php echo (isset($payment_receipt_data[0]->asd_received_amount) && !empty($payment_receipt_data[0]->asd_received_amount)) ? $payment_receipt_data[0]->asd_received_amount : '0.00' ?>" readonly>
                									</div> 
                								</div>
                								<div class="col-md-3">
                									<div class="form-group">
                										<label class="">Payment Date (ASD)</label>
                										<input type="text" class="form-control" id="asd_payment_date" value="<?php echo (isset($payment_receipt_data[0]->asd_payment_date) && !empty($payment_receipt_data[0]->asd_payment_date)) ? date('d-m-Y',strtotime($payment_receipt_data[0]->asd_payment_date)) : '' ?>" readonly>
                									</div> 
                								</div>
                								<div class="col-md-3">
                									<div class="form-group">
                									<label class="">Document Upload (ASD)</label>
                									<a href="<?php echo base_url();?>uploads/recipt/<?php echo (isset($payment_receipt_data[0]->asd_doc) && !empty($payment_receipt_data[0]->asd_doc)) ? $payment_receipt_data[0]->asd_doc : '' ?>" download>Download</a>
                									</div> 
                								</div>
                							</div>
                							<?php } ?>
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
                    									<label class="">IT TDS Amount</label>
                    									<input type="text" class="form-control" id="it_tds_amount" value="<?php echo (isset($payment_receipt_data[0]->it_tds_amount) && !empty($payment_receipt_data[0]->it_tds_amount)) ? $payment_receipt_data[0]->it_tds_amount : '0.00' ?>" readonly>
                    									</div> 
                    								</div>
                    								<div class="col-md-6">
                    									<div class="form-group">
                    									<label class="">GTDS Amount</label>
                    									<input type="text" class="form-control" id="gtds_amount" value="<?php echo (isset($payment_receipt_data[0]->gtds_amount) && !empty($payment_receipt_data[0]->gtds_amount)) ? $payment_receipt_data[0]->gtds_amount : '0.00' ?>" readonly>
                    									</div> 
                    								</div>
                    							</div>
                                                <hr style="margin: 10px 0;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">Any Other Tax Deduction</label>
                                                    </div>
                                                </div>
                                                <?php if(isset($other_tax_data) && !empty($other_tax_data)) { ?>
                                                    <?php $i=0;foreach($other_tax_data as $key) { ?>
                                                        <?php if($i==0){ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<label class="">Tax Deduction Description</label>
                            									<input type="text" class="form-control" id="tax_deduction_desc<?php echo $i; ?>" value="<?php echo (isset($key->tax_deduction_desc) && !empty($key->tax_deduction_desc)) ? $key->tax_deduction_desc : '-' ?>" readonly>
                            									</div> 
                            								</div>   
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<label class="">Tax Deduction Amount</label>
                            									<input type="text" class="form-control" id="tax_deduction_amt<?php echo $i; ?>" value="<?php echo (isset($key->tax_deduction_amt) && !empty($key->tax_deduction_amt)) ? $key->tax_deduction_amt : '0.00' ?>" readonly>
                            									</div> 
                            								</div>   
                                                        </div>
                                                    <?php }else{ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<input type="text" class="form-control" id="tax_deduction_desc<?php echo $i; ?>" value="<?php echo (isset($key->tax_deduction_desc) && !empty($key->tax_deduction_desc)) ? $key->tax_deduction_desc : '-' ?>" readonly>
                            									</div> 
                            								</div>   
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<input type="text" class="form-control" id="tax_deduction_amt<?php echo $i; ?>" value="<?php echo (isset($key->tax_deduction_amt) && !empty($key->tax_deduction_amt)) ? $key->tax_deduction_amt : '0.00' ?>" readonly>
                            									</div> 
                            								</div>   
                                                        </div>
                                                    <?php } $i++; } ?>
                                                <?php }else{ ?>
                                                <p>No Any Other Tax Deduction Found!</p>
                                                <?php } ?>
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
                            							<label class="">Security Deposit Retention Amount</label>
                            							<input type="text" class="form-control" id="security_deposit_retn_amount" value="<?php echo (isset($payment_receipt_data[0]->security_deposit_retn_amount) && !empty($payment_receipt_data[0]->security_deposit_retn_amount)) ? $payment_receipt_data[0]->security_deposit_retn_amount : '0.00' ?>" readonly>
                            							</div> 
                            						</div>   
                                                </div>
                                                <hr style="margin: 10px 0;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">Any Other Deposit</label>
                                                    </div>
                                                </div>
                                                <?php if(isset($deposit_data) && !empty($deposit_data)) { ?>
                                                    <?php $i=0;foreach($deposit_data as $key) { ?>
                                                        <?php if($i==0){ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<label class="">Deposit Description</label>
                            									<input type="text" class="form-control" id="deposit_desc<?php echo $i; ?>" value="<?php echo (isset($key->deposit_desc) && !empty($key->deposit_desc)) ? $key->deposit_desc : '-' ?>" readonly>
                            									</div> 
                            								</div>   
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<label class="">Deposit Amount</label>
                            									<input type="text" class="form-control" id="deposit_amount<?php echo $i; ?>" value="<?php echo (isset($key->deposit_amount) && !empty($key->deposit_amount)) ? $key->deposit_amount : '0.00' ?>" readonly>
                            									</div> 
                            								</div>   
                                                        </div>
                                                    <?php }else{ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<input type="text" class="form-control" id="deposit_desc<?php echo $i; ?>" value="<?php echo (isset($key->deposit_desc) && !empty($key->deposit_desc)) ? $key->deposit_desc : '-' ?>" readonly>
                            									</div> 
                            								</div>   
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<input type="text" class="form-control" id="deposit_amount<?php echo $i; ?>" value="<?php echo (isset($key->deposit_amount) && !empty($key->deposit_amount)) ? $key->deposit_amount : '0.00' ?>" readonly>
                            									</div> 
                            								</div>   
                                                        </div>
                                                    <?php } $i++; } ?>
                                                <?php }else{ ?>
                                                <p>No Any Other Deposit Found!</p>
                                                <?php } ?>
                                                <hr style="margin: 10px 0;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">Withheld</label>
                                                    </div>
                                                </div>
                                                <?php if(isset($withheld_data) && !empty($withheld_data)) { ?>
                                                    <?php $i=0;foreach($withheld_data as $key) { ?>
                                                        <?php if($i==0){ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<label class="">Withheld Description</label>
                            									<input type="text" class="form-control" id="withheld_desc<?php echo $i; ?>" value="<?php echo (isset($key->withheld_desc) && !empty($key->withheld_desc)) ? $key->withheld_desc : '-' ?>" readonly>
                            									</div> 
                            								</div>   
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<label class="">Withheld Amount</label>
                            									<input type="text" class="form-control" id="withheld_amt<?php echo $i; ?>" value="<?php echo (isset($key->withheld_amt) && !empty($key->withheld_amt)) ? $key->withheld_amt : '0.00' ?>" readonly>
                            									</div> 
                            								</div>   
                                                        </div>
                                                    <?php }else{ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<input type="text" class="form-control" id="withheld_desc<?php echo $i; ?>" value="<?php echo (isset($key->withheld_desc) && !empty($key->withheld_desc)) ? $key->withheld_desc : '-' ?>" readonly>
                            									</div> 
                            								</div>   
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<input type="text" class="form-control" id="withheld_amt<?php echo $i; ?>" value="<?php echo (isset($key->withheld_amt) && !empty($key->withheld_amt)) ? $key->withheld_amt : '0.00' ?>" readonly>
                            									</div> 
                            								</div>   
                                                        </div>
                                                    <?php } $i++; } ?>
                                                <?php }else{ ?>
                                                <p>No Withheld Found!</p>
                                                <?php } ?>
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
                            							<label class="">Labour Cess</label>
                            							<input type="text" class="form-control" id="labour_cess" value="<?php echo (isset($payment_receipt_data[0]->labour_cess) && !empty($payment_receipt_data[0]->labour_cess)) ? $payment_receipt_data[0]->labour_cess : '-' ?>" readonly>
                            							</div> 
                            						</div>   
                                                    <div class="col-md-6">
                            							<div class="form-group">
                            							<label class="">Debit Note / Credit Note / LD</label>
                            							<input type="text" class="form-control" id="debit_note" value="<?php echo (isset($payment_receipt_data[0]->debit_note) && !empty($payment_receipt_data[0]->debit_note)) ? $payment_receipt_data[0]->debit_note : '-' ?>" readonly>
                            							</div> 
                            						</div>   
                                                </div>
                                                <hr style="margin: 10px 0;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">Any Other Cess</label>
                                                    </div>
                                                </div>
                                                <?php if(isset($cess_data) && !empty($cess_data)) { ?>
                                                    <?php $i=0;foreach($cess_data as $key) { ?>
                                                        <?php if($i==0){ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<label class="">Cess Description</label>
                            									<input type="text" class="form-control" id="other_cess_desc<?php echo $i; ?>" value="<?php echo (isset($key->other_cess_desc) && !empty($key->other_cess_desc)) ? $key->other_cess_desc : '-' ?>" readonly>
                            									</div> 
                            								</div>   
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<label class="">Cess Amount</label>
                            									<input type="text" class="form-control" id="other_cess_amt<?php echo $i; ?>" value="<?php echo (isset($key->other_cess_amt) && !empty($key->other_cess_amt)) ? $key->other_cess_amt : '0.00' ?>" readonly>
                            									</div> 
                            								</div>   
                                                        </div>
                                                    <?php }else{ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<input type="text" class="form-control" id="other_cess_desc<?php echo $i; ?>" value="<?php echo (isset($key->other_cess_desc) && !empty($key->other_cess_desc)) ? $key->other_cess_desc : '-' ?>" readonly>
                            									</div> 
                            								</div>   
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<input type="text" class="form-control" id="withheld_amt<?php echo $i; ?>" value="<?php echo (isset($key->other_cess_amt) && !empty($key->other_cess_amt)) ? $key->other_cess_amt : '0.00' ?>" readonly>
                            									</div> 
                            								</div>   
                                                        </div>
                                                    <?php } $i++; } ?>
                                                <?php }else{ ?>
                                                <p>No Any Other Cess Found!</p>
                                                <?php } ?>
                                                <hr style="margin: 10px 0;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label style="font-weight: 600;font-size: 14px;margin-bottom:10px;">Any Other Deductions</label>
                                                    </div>
                                                </div>
                                                <?php if(isset($deduction_data) && !empty($deduction_data)) { ?>
                                                    <?php $i=0;foreach($deduction_data as $key) { ?>
                                                        <?php if($i==0){ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<label class="">Deduction Description</label>
                            									<input type="text" class="form-control" id="deduction_desc<?php echo $i; ?>" value="<?php echo (isset($key->deduction_desc) && !empty($key->deduction_desc)) ? $key->deduction_desc : '-' ?>" readonly>
                            									</div> 
                            								</div>   
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<label class="">Deduction Amount</label>
                            									<input type="text" class="form-control" id="deduction_amt<?php echo $i; ?>" value="<?php echo (isset($key->deduction_amt) && !empty($key->deduction_amt)) ? $key->deduction_amt : '0.00' ?>" readonly>
                            									</div> 
                            								</div>   
                                                        </div>
                                                    <?php }else{ ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<input type="text" class="form-control" id="deduction_desc<?php echo $i; ?>" value="<?php echo (isset($key->deduction_desc) && !empty($key->deduction_desc)) ? $key->deduction_desc : '-' ?>" readonly>
                            									</div> 
                            								</div>   
                                                            <div class="col-md-6">
                            									<div class="form-group">
                            									<input type="text" class="form-control" id="deduction_amt<?php echo $i; ?>" value="<?php echo (isset($key->deduction_amt) && !empty($key->deduction_amt)) ? $key->deduction_amt : '0.00' ?>" readonly>
                            									</div> 
                            								</div>   
                                                        </div>
                                                    <?php } $i++; } ?>
                                                <?php }else{ ?>
                                                <p>No Any Other Deductions Found!</p>
                                                <?php } ?>
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
            											<label class="">Payment Receipt Copy Received </label>
            											<input type="text" class="form-control" id="payment_advice_received" value="<?php echo (isset($payment_receipt_data[0]->payment_advice_received) && !empty($payment_receipt_data[0]->payment_advice_received)) ? $payment_receipt_data[0]->payment_advice_received : 'No' ?>" readonly>
            										</div> 
            									</div>
                                                <?php if(isset($payment_receipt_data[0]->payment_advice_received) && !empty($payment_receipt_data[0]->payment_advice_received) && $payment_receipt_data[0]->payment_advice_received == 'Yes'){ ?>
                                                <div class="col-md-4">
            										<div class="form-group">
            											<label class="">Payment Receipt Copy Received Date </label>
            											<input type="text" class="form-control" id="payment_advice_received_date" value="<?php echo (isset($payment_receipt_data[0]->payment_advice_received_date) && !empty($payment_receipt_data[0]->payment_advice_received_date)) ? date('d-m-Y',strtotime($payment_receipt_data[0]->payment_advice_received_date)) : '-' ?>" readonly>
            										</div> 
            									</div>
                                                <div class="col-md-4">
            										<div class="form-group">
            											<label class="">Upload Payment Receipt Document </label>
            											<a href="<?php echo base_url(); ?>uploads/recipt/<?php echo (isset($payment_receipt_data[0]->payment_advice_doc) && !empty($payment_receipt_data[0]->payment_advice_doc)) ? $payment_receipt_data[0]->payment_advice_doc : '-' ?>" download>Download</a>
            										</div> 
            									</div>
                                                <?php } ?>
                                            </div>
                                            </div>
                                            </div>
                                            <div class="form-actions right"> <a href="<?php echo base_url();?>create-tax-invoice" class="btn blue" style="float: left;">Back</a></div>
                                    
                                        </div>
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