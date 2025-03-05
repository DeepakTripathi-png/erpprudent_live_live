<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title> Payment Receipt | <?php echo project_name; ?> </title>
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
  .hide{
    display: none;
  }
  .show{
    display: block;
  }
  .error{
    color: red;
  }
 
  .alert-container {
    position: fixed;
    z-index: 9;
    width: 50%; /* You can adjust this as per your need */
    left: 50%;
    top: 10%;
    border: 1px solid #80808060;
    transform: translateX(-50%);
    background-color: #ffffff; /* White background */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Shadow effect */
    padding: 15px;
    border-radius: 4px;
    animation: slideDown 1s ease-out forwards;
    text-align: center;
}

@keyframes slideDown {
    0% {
        top: -100px;
        opacity: 0;
    }
    100% {
        top: 12%; /* Final position */
        opacity: 1;
    }
}

.alert-container .alert {
  margin-bottom: 0px;
    font-weight: 600;
}
.alert {
  
    font-weight: 600;
}
  label.error{
    display: unset;
  }
  </style>
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo">
  <?php $this->load->view('common/header');?>
  <div class="clearfix"> </div>
  <div class="page-container">

    <?php $this->load->view('common/sidebar');?>
    <div class="page-content-wrapper">

      <div class="page-content">
        <div class="alert alert-warning payment_receipt_exit_msg hide" role="alert">
          <b>This payment receipt has already been added. No further action is required.</b>
        </div>
        <div class="portlet-body">
          <div class="alert-container hide">

          </div>


          <div class="row">
            <div class="col-md-12">
              <div class="portlet light">

                <div class="portlet-title">
                  <div class="caption font-blue">
                    <i class="fa fa-plus-circle font-blue"></i>
                    <span class="caption-subject bold uppercase">Payment Receipt</span>
                  </div>
                </div>
                <form action="javascript:void(0)" enctype="multipart/form-data" id="payment_receipt_form" method="post">

                  <div class="portlet-body form">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title"> Payment Details </h4>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">Project Name <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control" name="project_name" id="project_name" value="<?php echo $ppi_data->project_name;?>" placeholder="Project Name" readonly>
                              <input type="hidden" class="form-control" name="project_id" id="project_id" value="<?php echo $ppi_data->project_id;?>" placeholder="Project Name" readonly>
                              <input type="hidden" class="form-control" name="ppi_id" id="ppi_id" value="<?php echo $ppi_data->proforma_id;?>" placeholder="Project Name" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">Payment Date <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="date" class="form-control" name="payment_date" id="payment_date" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['payment_date'];}?>" placeholder="Payment Date" >
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">Payment Account <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control" name="payment_account" id="payment_account" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['payment_account'];}else{echo $vendor_data->bank_acc_no_vendor;}?>" placeholder="Payment account"  readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">Vendor Name <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control" name="vendor_name" id="vendor_name" value="<?php echo $vendor_data->name_of_company;?>" placeholder="Vendor Name" readonly>
                              <input type="hidden" class="form-control" name="vendor_id" id="vendor_id" value="<?php echo $vendor_data->vendor_id;?>" placeholder="Vendor Name" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">Invoice Date <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control" name="invoice_date" id="invoice_date" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['invoice_date'];}else{echo $ppi_data->invoice_date;}?>" placeholder="Invoice Date" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">Invoice Number <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control" name="invoice_number" id="invoice_number" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['invoice_number'];}else{echo $ppi_data->proforma_no;}?>" placeholder="Invoice Number" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">Payment With GST <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                              <div class="dflx">
                                <div class="form-check form-check-inline me-3">
                                  <input class="form-check-input" type="radio" name="payment_with_gst" value="Yes"
                                  <?php if (isset($pr_data) && !empty($pr_data) && $pr_data[0]['payment_with_gst'] == "Yes") { echo "checked"; } ?>>
                                  <label class="form-check-label" for="inlineRadio1">Yes</label>

                                </div>
                                <div class="form-check form-check-inline" style="padding-left: 10px;">
                                  <input class="form-check-input" type="radio" name="payment_with_gst" value="No"
                                  <?php if ((isset($pr_data) && !empty($pr_data) && $pr_data[0]['payment_with_gst'] == "No") || !isset($pr_data[0]['payment_with_gst']))   { echo "checked"; } ?>>
                                  <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">Advance Payment (%) <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control" name="advance_payment_percent" id="advance_payment_percent" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['advance_payment_percent'];}else{echo $advance_payment_percent;}?>" placeholder="Advance Payment" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">Payment (%)<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control" name="payment_percent" id="payment_percent" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['payment_percent'];}else{echo $payment_percent;}?>" placeholder="Payment" >
                              <input type="hidden" class="form-control" id="hidden_payment_percent" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $payment_percent;}else{echo $payment_percent;}?>" placeholder="Payment" >
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">PPI Amount (Inclusive GST) <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="invoice_amount" id="invoice_amount" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['invoice_amount'];}else{echo $invoice_amount;}?>" placeholder="Basic amount" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">PPI Basic Amount  <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="invoice_amount_without_gst" id="invoice_amount_without_gst" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['invoice_amount_without_gst'];}else{echo $invoice_amount_without_gst;}?>" placeholder="Basic amount" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">Payment Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="payment_amount" id="payment_amount" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['payment_amount'];}else{echo $payment_amount;}?>" placeholder="Payment Amount" readonly>
                              <input type="hidden" class="form-control" id="hidden_payment_amount" value="<?php echo $payment_amount;?>" placeholder="Payment amount" readonly>
                              <!-- <input type="hidden" class="form-control" id="hidden_payment_amount_without_gst" value="<?php echo $invoice_amount_without_gst;?>" placeholder="GST amount" readonly> -->

                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">GST Amount  <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="gst_amount" id="gst_amount" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['gst_amount'];}else{echo $gst_amount;}?>" placeholder="Payment Amount" readonly>
                              <input type="hidden" class="form-control" id="hidden_gst_amount" value="<?php echo $gst_amount;?>" placeholder="GST amount" readonly>
                              <input type="hidden" id="hidden_gst_rate" value="">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">Total Payable Amount  <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                               <input type="text" class="form-control onlyNumericInput"  id="total_payable_amount_val" value="0.00" placeholder="" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">Payment Mode <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <select class="form-control" id="payment_mode" name="payment_mode">
                                  <option value="">Select Payment Mode</option>
                                  <!--<option value="Credit Card" <?php if(isset($pr_data) && $pr_data[0]['payment_mode'] == 'Credit Card') echo 'selected'; ?>>Credit Card</option>-->
                                  <option value="Debit Card" <?php if(isset($pr_data) && $pr_data[0]['payment_mode'] == 'Debit Card') echo 'selected'; ?>>Debit Card</option>
                                  <option value="Bank Transfer" <?php if(isset($pr_data) && $pr_data[0]['payment_mode'] == 'Bank Transfer') echo 'selected'; ?>>Bank Transfer(UPI/NFT/RTGS)</option>
                                  <option value="Cash" <?php if(isset($pr_data) && $pr_data[0]['payment_mode'] == 'Cash') echo 'selected'; ?>>Cash</option>
                                  <option value="PDC" <?php if(isset($pr_data) && $pr_data[0]['payment_mode'] == 'PDC') echo 'selected'; ?>>PDC</option>
                              </select>


                            </div>
                          </div>
                          <div class="col-md-4 <?php if(isset($pr_data) && $pr_data[0]['payment_mode'] != 'PDC'){echo "hide";}?>" id="check_number_field">
                            <div class="form-group">
                              <label class="">Check Number  <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                               <input type="text" class="form-control"  id="check_number" name="check_number" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['check_number'];}?>"  placeholder="Enter Check Number" >
                            </div>
                          </div>
                          <div class="col-md-4 <?php if(isset($pr_data) && $pr_data[0]['payment_mode'] != 'PDC'){echo "hide";}?>" id="pdc_date_field">
                            <div class="form-group">
                              <label class="">PDC Date  <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                               <input type="date" class="form-control"  id="pdc_date"  name="pdc_date"   value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['pdc_date'];}?>" >
                            </div>
                          </div>

                          <div class="col-md-4 <?php if($statutory_deductions_radio == "No"){echo "hide";} ?>">
                            <div class="form-group">
                              <label class="">Do you Want Statutory Deductions?<span class="require" aria-required="true" style="color:#a94442">*</span></label>

                              <div class="dflx">
                                <div class="form-check form-check-inline me-3">
                                  <input class="form-check-input" type="radio" name="statutory_deductions_radio" value="Yes" <?php if($statutory_deductions_radio == "Yes"){echo "checked";} ?>>
                                  <label class="form-check-label" for="inlineRadio1">Yes</label>

                                </div>
                                <div class="form-check form-check-inline" style="padding-left: 10px;">
                                <input class="form-check-input" type="radio" name="statutory_deductions_radio" value="No"  <?php if($statutory_deductions_radio == "No"){echo "checked";} ?>>
                                <label class="form-check-label" for="inlineRadio1">NO</label>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="portlet-body form">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title"> Statutory Deductions </h4>
                      </div>
                      <div class="panel-body">
                        <!--<div class="row">-->
                        <!--  <div class="col-md-6">-->
                        <!--    <div class="form-group">-->
                        <!--      <label class="">IT TDS Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>-->
                        <!--      <input type="text" class="form-control onlyNumericInput" name="it_ids_amount" id="it_ids_amount" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['it_ids_amount'];}?>" placeholder="IT TDS Amount">-->
                        <!--    </div>-->
                        <!--  </div>-->
                        <!--  <div class="col-md-6">-->
                        <!--    <div class="form-group">-->
                              <!-- Replace gtds to tcs -->
                        <!--      <label class="">TCS Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>-->
                        <!--      <input type="text" class="form-control onlyNumericInput" name="gtds_amount" id="gtds_amount" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['gtds_amount'];}?>" placeholder="TCS Amount">-->
                        <!--    </div>-->
                        <!--  </div>-->
                        <!--</div>-->
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">IT TDS (%) <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                             
                              <select class="form-select form-control" aria-label="Default select example" name="it_ids_percentage" id="it_ids_percentage"  <?php if($statutory_deductions_radio == "No"){echo "disabled";} ?>>
                                <option value="">Select</option>
                                <option value="0" <?php if ((isset($pr_data) && $pr_data[0]['it_ids_percentage'] == "0") || $pr_added_data['it_ids_percentage'] == "0") { echo "selected"; } ?>>0%</option>
                                <option value="1" <?php if ((isset($pr_data) && $pr_data[0]['it_ids_percentage'] == "1")  || $pr_added_data['it_ids_percentage'] == "1") { echo "selected"; } ?>>1%</option>
                                <option value="2" <?php if ((isset($pr_data) && $pr_data[0]['it_ids_percentage'] == "2")  || $pr_added_data['it_ids_percentage'] == "2") { echo "selected"; } ?>>2%</option>
                                <option value="3" <?php if ((isset($pr_data) && $pr_data[0]['it_ids_percentage'] == "3") || $pr_added_data['it_ids_percentage'] == "3") { echo "selected"; } ?>>3%</option>
                                <option value="4" <?php if ((isset($pr_data) && $pr_data[0]['it_ids_percentage'] == "4")  || $pr_added_data['it_ids_percentage'] == "4") { echo "selected"; } ?>>4%</option>
                                <option value="5" <?php if ((isset($pr_data) && $pr_data[0]['it_ids_percentage'] == "5") || $pr_added_data['it_ids_percentage'] == "5") { echo "selected"; } ?>>5%</option>
                            </select>

                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">IT TDS Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="it_ids_amount" id="it_ids_amount" value="<?php if((isset($pr_data) && !empty($pr_data) )){echo $pr_data[0]['it_ids_amount'];}else if(isset($pr_added_data['it_ids_amount'])){echo $pr_added_data['it_ids_amount'];}else{echo "0.00";}?>" placeholder="IT TDS Amount" readonly>
                              <input type="hidden" class="form-control onlyNumericInput"  id="it_ids_amount_data" value="<?php if((isset($pr_data) && !empty($pr_data) )){echo $pr_data[0]['it_ids_amount'];}else if(isset($pr_added_data['it_ids_amount'])){echo $pr_added_data['it_ids_amount'];}else{echo "0.00";}?>" placeholder="IT TDS Amount" readonly>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <!-- Replace gtds to tcs -->
                              <label class="">TCS % <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                            
                              <select class="form-select form-control" aria-label="Default select example" name="gtds_percenatge" id="gtds_percenatge" <?php if($statutory_deductions_radio == "No"){echo "disabled";} ?>>
                                <option value="">Select</option>
                                <option value="0" <?php if ((isset($pr_data) && $pr_data[0]['gtds_percenatge'] == "0") ||  $pr_added_data['gtds_percenatge'] == "0") { echo "selected"; } ?>>0%</option>
                                <option value="1" <?php if ((isset($pr_data) && $pr_data[0]['gtds_percenatge'] == "1") ||  $pr_added_data['gtds_percenatge'] == "1") { echo "selected"; } ?>>1%</option>
                                <option value="2" <?php if ((isset($pr_data) && $pr_data[0]['gtds_percenatge'] == "2") ||  $pr_added_data['gtds_percenatge'] == "2") { echo "selected"; } ?>>2%</option>
                                <option value="3" <?php if ((isset($pr_data) && $pr_data[0]['gtds_percenatge'] == "3") ||  $pr_added_data['gtds_percenatge'] == "3") { echo "selected"; } ?>>3%</option>
                                <option value="4" <?php if ((isset($pr_data) && $pr_data[0]['gtds_percenatge'] == "4") ||  $pr_added_data['gtds_percenatge'] == "4") { echo "selected"; } ?>>4%</option>
                                <option value="5" <?php if ((isset($pr_data) && $pr_data[0]['gtds_percenatge'] == "5") ||  $pr_added_data['gtds_percenatge'] == "5") { echo "selected"; } ?>>5%</option>
                              </select>

                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <!-- Replace gtds to tcs -->
                              <label class="">TCS Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="gtds_amount" id="gtds_amount" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['gtds_amount'];}else if(isset($pr_added_data['it_ids_amount'])){echo $pr_added_data['gtds_amount'];}else{echo "0.00";}?>" placeholder="TCS Amount" readonly>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <p> <b>Any Other Tax Deduction</b>
                        </p>
                        <div class="row tax-deduction-block">
                          <?php
                          if(count($payment_receipt_deduction_data) > 0){
                           foreach ($payment_receipt_deduction_data as $key => $value) { ?>
                            <div class="tax-deduction-row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="">Tax Deduction Description <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                <input type="text" class="form-control" name="tax_deduction_description[]"  value="<?php echo $value['tax_deduction_description'];?>"  placeholder="Tax Deduction Description" >
                              </div>
                            </div>

                            <div class="col-md-5">
                              <div class="form-group">
                                <label class="">Tax Deduction Amount  <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                <input type="text" class="form-control onlyNumericInput tax_deduction_amount" name="tax_deduction_amount[]"  value="<?php echo $value['tax_deduction_amount'];?>" placeholder="Tax Deduction Amount">
                              </div>
                            </div>
                            <?php if($key > 0){ ?>
                           <div class="col-md-1">
                              <div class="form-group">
                                <br> <button type="button" class="remove-tax-deduction">Remove</button>
                              </div>
                           </div>
                           <?php }else{ ?>
                            <div class="col-md-1">
                              <div class="form-group">
                                <br> <button type="button" class="add-tax-deduction">Add</button>
                              </div>
                           </div>
                           </div>
                            <?php } ?>
                          <?php }
                        } else { ?>
                        <div class="tax-deduction-row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="">Tax Deduction Description <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                <input type="text" class="form-control" name="tax_deduction_description[]"  value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['tax_deduction_description'];}?>"  placeholder="Tax Deduction Description" >
                              </div>
                            </div>

                            <div class="col-md-5">
                              <div class="form-group">
                                <label class="">Tax Deduction Amount  <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                <input type="text" class="form-control onlyNumericInput tax_deduction_amount" name="tax_deduction_amount[]"  value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['tax_deduction_amount'];}?>" placeholder="Tax Deduction Amount">
                              </div>
                            </div>
                            <div class="col-md-1">
                              <div class="form-group">
                                <br> <button type="button" class="add-tax-deduction">Add</button>
                              </div>
                            </div>
                          </div>
                         
                          <?php }
                          ?>
                        </div>
                       
                        
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Total Amount After Deduction </label>
                              <input type="text" class="form-control onlyNumericInput" name="total_amount_with_deduction"  id="total_amount_with_deduction" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['total_amount_with_deduction'];}?>" readonly>
                            </div>
                          </div>
                          </div>
                          </div>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="portlet-body form hide">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title"> REFUNDABLE </h4>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Security Deposit Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="security_deposit_amount" id="security_deposit_amount" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['security_deposit_amount'];}?>" placeholder="Security Deposit Amount" >
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Retention Amount  <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="retention_amount" id="retention_amount" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['retention_amount'];}?>" placeholder="Retention Amount">
                            </div>
                          </div>
                        </div>
                        <hr>
                        <p> <b>Any Other Deposit</b>
                        </p>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Deposit Description <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control" name="deposit_description" id="deposit_description" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['deposit_description'];}?>" placeholder="Deposit Description" >
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Deposit Amount  <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="deposit_amount" id="deposit_amount" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['deposit_amount'];}?>" placeholder="Deposit Amount" >
                            </div>
                          </div>
                        </div>
                        <hr>
                        <p> <b>Withheld</b>
                        </p>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Withheld Description <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control" name="withheld_description" id="withheld_description" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['withheld_description'];}?>"  placeholder="Withheld Description">
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Withheld Amount  <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="withheld_amount" id="withheld_amount" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['withheld_amount'];}?>" placeholder="Withheld Amount" >
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="portlet-body form hide">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">NON - REFUNDABLE </h4>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Lebour Cess <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control" name="lebour_cess" id="lebour_cess" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['lebour_cess'];}?>" placeholder="Lebour Cess" >
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Debit Note / Credit Note / LD   <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control" name="debit_credit_note" id="debit_credit_note" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['debit_credit_note'];}?>" placeholder="Debit Note / Credit Note / LD" >
                            </div>
                          </div>
                        </div>
                        <hr>
                        <p> <b>Any Other Deposit</b>
                        </p>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Cess Description <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control" name="cess_description" id="cess_description" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['cess_description'];}?>" placeholder="Cess Description" >
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Cess Amount  <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="cess_amount" id="cess_amount" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['cess_amount'];}?>" placeholder="Cess Amount">
                            </div>
                          </div>
                        </div>
                        <hr>
                        <p> <b>Any Other Deductions</b>
                        </p>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Deduction Description <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control" name="deduction_description" id="deduction_description" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['deduction_description'];}?>" placeholder="Deduction Description">
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Deduction Amount  <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="deduction_amount" id="deduction_amount" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['deduction_amount'];}?>" placeholder="Deduction Amount">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="portlet-body form">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title"> Payment Copy Details </h4>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">Payment Copy Available <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                              <div class="dflx">
                                <div class="form-check form-check-inline me-3">
                                  <input class="form-check-input" type="radio" name="payment_copy" value="Yes"
                                  <?php if (isset($pr_data) && !empty($pr_data) && $pr_data[0]['payment_copy'] == "Yes") { echo "checked"; } ?>>
                                  <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline" style="padding-left: 10px;">
                                  <input class="form-check-input" type="radio" name="payment_copy" value="No"
                                  <?php if (isset($pr_data) && !empty($pr_data) && $pr_data[0]['payment_copy'] == "No") { echo "checked"; } ?>>
                                  <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="">Payment Copy Date <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="date" class="form-control" name="payment_copy_date" id="payment_copy_date" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['payment_date'];}?>"  placeholder="Payment Date">

                              <!-- <div class="input-group date date1"  data-date-format="dd-mm-yyyy">
                                <input type="text" class="form-control" name="payment_copy_date" id="payment_copy_date" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['payment_date'];}?>"  placeholder="Payment Date" readonly>
                                <span class="input-group-btn">
                                  <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                </span>
                              </div> -->
                            </div>
                            </div>
                           <div class="col-md-4 <?php if(isset($pr_data) && !empty($pr_data) && !empty($pr_data[0]['payment_document'])){ echo "show";}else{echo "hide";} ?>" id="payment_document_div">
                             
                              <div class="form-group">
                                <label class="">Upload Payment Document </label>
                                <input type="file" name="payment_document" id="payment_document">
                                <?php if(isset($pr_data) && !empty($pr_data) && !empty($pr_data[0]['payment_document'])){ ?>

                                  <a href="<?php echo base_url(); ?>uploads/payment_receipts/<?php echo $pr_data[0]['payment_document']; ?>" download>Download</a>
                                  <input type="hidden" name="hidden_payment_document" value="<?php echo $pr_data[0]['payment_document']; ?>">
                                <?php } ?>

                              </div>
                            </div>

                          </div>
                        </div>
                      </div>

                      <div class="form-actions pb-5">
                        <a href="vendor_proforma_invoice" class="btn blue" style="float: left;">Back</a>
                        <div class="" style="position: absolute;right: 34px;">
                          <button type="button" class="btn btn-danger cancel" onclick="location.href = 'vendor_proforma_invoice';" title="click To Cancel"> Cancel</button>
                          <input type="hidden" name="mode" value="<?php if(isset($pr_data) && !empty($pr_data)){echo "update";}else{echo "add";}?>">
                          <input type="hidden" name="pr_id" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['pr_id'];}else{echo "";}?>" id="pr_id_value">
                          <input type="hidden" name="transaction_id" value="<?php if(isset($pr_data) && !empty($pr_data)){echo $pr_data[0]['transaction_id'];}else{echo "";}?>">
                          <button type="submit"  class="btn green psupdatesubmit" title="click To Submit"><i class="fa fa-dot-circle-o"></i> Submit</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>


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
<script src="https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script src="<?php echo base_url();?>js/payment_receipt.js?" type="text/javascript"></script>

<script>
jQuery(document).ready(function() {
  Metronic.init(); // init metronic core components
  Layout.init();
  ComponentsPickers.init();
});
</script>
</body>
</html>
