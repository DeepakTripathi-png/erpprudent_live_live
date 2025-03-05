<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8"/>
      <title> Goods Received Notes | <?php echo project_name; ?> </title>
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
         .pt-2{
         padding-top: 10px;
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
                 
            
                  
               </div>
               <div class="portlet-body">
                  <input type="hidden" id="msg" value="<?php echo $msg;?>">
                  <?php if($msg != ""){?>
               <div class="alert alert-warning" role="alert">
               <b><?php echo $msg;?></b>
               </div>
               <?php }?>

               <?php if (isset($total_dc_amount, $total_advance_payment) && ($total_dc_amount - $total_advance_payment <= 0) && $msg != "") { ?>
               <div class="alert alert-warning advance_payment_not_greater" role="alert">
               <b>Cannot create GRN because the Advance Payment Amount is greater than the GRN Amount.</b>
               </div>
               <?php }?>

                  <div class="alert-container hide">
                  </div>
                  <div class="row form_data">
                    
                     <div class="col-md-12">
                        <div class="portlet light">
                           <div class="portlet-title">
                              <div class="caption font-blue">
                                 <i class="fa fa-plus-circle font-blue"></i>
                                 <span class="caption-subject bold uppercase">Goods Received Notes</span>
                              </div>
                           </div>
                           <input type="hidden" id="dc_data" value="<?php echo $dc_data->vdc_number;?>">
                           <input type="hidden" id="dc_count" value="<?php echo count($dc_item_data);?>">
                           <form action="javascript:void(0)" enctype="multipart/form-data" id="grn_update_form" method="post" style="display: none">
                      
                              <div class="row" style="border-bottom:1px solid #c5bcbc7d;">
                              <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="bp_code" id="edit_project_name" placeholder=" Project Code" required readonly value="<?php echo $project_data->bp_code;?>">
                                       <input type="hidden" class="form-control" id="edit_project_id" name="project_id" placeholder=" Project Code"  readonly >
                                       <input type="hidden" class="form-control" id="grn_id_edit" name="grn_id" placeholder=""  readonly >
                                       <input type="hidden" class="form-control" id="transaction_id_edit" name="transaction_id" placeholder=""  readonly >
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">Po Number <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="po_number" id="edit_po_number" placeholder=" Po Number" required readonly >
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">DC Number<span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="dc_number" id="edit_dc_number" placeholder="DC Number" required readonly >
                                    </div>
                                 </div>
                                 
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">GRN Amount <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control dc_amount_edit"  name="dc_amount" id="edit_dc_amount" placeholder="GRN Amount" required readonly >
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">Advance Payment <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="advance_payment" id="edit_advance_payment" placeholder="Advance Payment" required readonly value="0.00">
                                    </div>
                                 </div>
                                 <div class="col-md-3 hide">
                                    <div class="form-group">
                                       <label class="control-label">Total Payment <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="total_amount" id="edit_total_amount"  required readonly value="0.00">
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">Invoice Amount<span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="invoice_amount"  id="edit_invoice_amount" required readonly >
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">Invoice Number<span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="invoice_number" id="edit_invoice_number" placeholder="Invoice Number" required readonly>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">Invoice Date<span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="date" class="form-control"  name="invoice_date" id="edit_invoice_date" required readonly>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Attachement <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="file"  name="attachement" id="edit_attachement" >
                                       <input type="hidden" id="hidden_attachement" name="hidden_attachement" value="">
                                       <div class="download_attachement"></div>
                                    </div>
                                 </div>

                                

                                 
                              </div>

                              <br>
                           <p> <b>Tax Deduction</b>
                           <div class="col-md-6" style="padding-left:0px">
                            <div class="form-group">
                              <label class="">IT TDS (%) <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                             
                              <select class="form-select form-control" aria-label="Default select example" name="it_ids_percentage" id="edit_it_ids_percentage"  >
                                <option value="">Select</option>
                                <option value="0" >0%</option>
                                <option value="1" >1%</option>
                                <option value="2" >2%</option>
                                <option value="3" >3%</option>
                                <option value="4" >4%</option>
                                <option value="5" >5%</option>
                            </select>

                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">IT TDS Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="it_ids_amount" id="edit_it_ids_amount" value="0.00" placeholder="IT TDS Amount" readonly>
                             
                            </div>
                          </div>
                          <div class="col-md-6" style="padding-left:0px">
                            <div class="form-group">
                              <!-- Replace gtds to tcs -->
                              <label class="">TCS % <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                            
                              <select class="form-select form-control" aria-label="Default select example" name="tcs_percenatge" id="edit_tcs_percenatge" >
                                <option value="">Select</option>
                                <option value="0" >0%</option>
                                <option value="1" >1%</option>
                                <option value="2" >2%</option>
                                <option value="3" >3%</option>
                                <option value="4" >4%</option>
                                <option value="5" >5%</option>
                              </select>
                              </div>
                            </div>
                         
                          <div class="col-md-6">
                            <div class="form-group">
                              <!-- Replace gtds to tcs -->
                              <label class="">TCS Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="tcs_amount" id="edit_tcs_amount" value="0.00"  placeholder="TCS Amount" readonly>
                            </div>
                          </div>
                        
                        <hr>
                        <p> <b>Any Other Tax Deduction</b>
                        </p>
                        <div class="row tax-deduction-block">
                       
                        <div class="tax-deduction-row " data-name="edit_tax_data">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="">Tax Deduction Description <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                <input type="text" class="form-control" name="tax_deduction_description[]"    placeholder="Tax Deduction Description" >
                              </div>
                            </div>

                            <div class="col-md-5">
                              <div class="form-group">
                                <label class="">Tax Deduction Amount  <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                <input type="text" class="form-control onlyNumericInput tax_deduction_amount edit_tax_deduction_amount" name="tax_deduction_amount[]" value="0.00"  placeholder="Tax Deduction Amount">
                              </div>
                            </div>
                            <div class="col-md-1">
                              <div class="form-group">
                                <br> <button type="button" class="add-tax-deduction" data-name="edit-tax-data">Add</button>
                              </div>
                            </div>
                          </div>
                         
                          
                        </div>
                       
                        
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Total Amount After Deduction </label>
                              <input type="text" class="form-control onlyNumericInput" name="total_amount_with_deduction"  id="edit_total_amount_with_deduction" value="0.00"  readonly>
                            </div>
                          </div>
                          </div>



                              <div id="displayPOItems" style="width: 100%;overflow-x: auto;">
                                 <table width="100%" id="edit_bomgrnitmdisplay" class="table table-striped table-bordered table-hover" style="margin-top:15px;">
                                    <thead>
                                       <tr>
                                          <th style="min-width: 50px;width:50px;">Sr. No.</th>
                                          <th style="min-width: 50px;width:50px;">BOM Sr. No.</th>
                                          <th style="min-width: 100px;width:100px;">Item Description</th>
                                          <th style="min-width: 80px;width:80px;">Unit</th>
                                          <th style="min-width: 80px;width:80px;">Make</th>
                                          <th style="min-width: 80px;width:80px;">Model</th>
                                          <th style="min-width: 80px;width:80px;">Po Qty</th>
                                          <th style="min-width: 80px;width:80px;">DC Qty (In Good Condition) </th>
                                          <!-- <th style="min-width: 80px;width:80px;">Available Qty for GRN </th> -->
                                          <th style="min-width: 80px;width:80px;">Basic Rate</th>
                                          <th style="min-width: 80px;width:80px;">GST</th>
                                          <th style="min-width: 80px;width:80px;">Amount</th>

                                       </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                 </table>
                                 <p id="invaliderrorid" style="padding: 10px 0px;font-size: 12px;color:#a94442;"></p>
                              </div>
                              <div class="form-actions right">
                                 <!--<button type="button" class="btn btn-danger cancel clearData" title="click To Cancel"> Cancel</button>-->
                                 <button type="button" class="btn btn-danger cancel" onclick="location.href = 'vendor_delivery_challan';" title="click To Cancel"> Cancel</button>
                                 <button type="submit" class="btn green " title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> Update</button>
                              </div>
                           </form>


                           <!-- Add GRN Form -->

                           <form action="javascript:void(0)" enctype="multipart/form-data" id="grn_form" method="post">
                              <div class="row" style="border-bottom:1px solid #c5bcbc7d;">
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="bp_code" placeholder=" Project Code" required readonly value="<?php echo $project_data->bp_code;?>">
                                       <input type="hidden" class="form-control" id="project_id" name="project_id" placeholder=" Project Code"  readonly value="<?php echo $project_data->project_id;?>">
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">Po Number <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="po_number" placeholder=" Po Number" required readonly value="<?php echo $po_details->po_number;?>">
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">DC Number<span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="dc_number" placeholder="DC Number" required readonly value="<?php echo $dc_data->vdc_number;?>">
                                    </div>
                                 </div>
                                 
                                 

                                 
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">GRN Amount <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control dc_amount_add"  name="dc_amount" id="dc_amount" placeholder="GRN Amount" required readonly value="<?php echo number_format($total_dc_amount,2, '.', ''); ?>">
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">Advance Payment <span class="required" aria-required="true" style="color:#a94442"> <?php if($advance_payement_done == "YES") {?> <a href="#" data-toggle="tooltip" title="<?php echo $advance_payement_msg;?>!"><i class="fa fa-info-circle"></i><?php }?>
                                       </a></span></label>
                                       <input type="text" class="form-control"  name="advance_payment" placeholder="Advance Payment" required readonly value="<?php echo number_format($total_advance_payment,2, '.', ''); ?>">
                                    </div>
                                 </div>
                                 <div class="col-md-3 hide">
                                    <div class="form-group">
                                       <label class="control-label">Total Payment <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="total_amount" id="total_amount" placeholder="Total Payment" required readonly value="<?php echo number_format($total_dc_amount - $total_advance_payment,2, '.', ''); ?>">
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">Invoice Amount<span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="invoice_amount"  required placeholder="Invoice Amount">
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">Invoice Number<span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="invoice_number" placeholder="Invoice Number" required >
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="control-label">Invoice Date<span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="date" class="form-control"  name="invoice_date"  required >
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Attachement <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="file"  name="attachement" id="attachement" >
                                    </div>
                                 </div>
                              </div>

                           <br>
                           <p> <b>Tax Deduction</b>
                           <div class="col-md-6" style="padding-left:0px">
                            <div class="form-group">
                              <label class="">IT TDS (%) <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                             
                              <select class="form-select form-control" aria-label="Default select example" name="it_ids_percentage" id="it_ids_percentage"  >
                                <option value="">Select</option>
                                <option value="0" >0%</option>
                                <option value="1" >1%</option>
                                <option value="2" >2%</option>
                                <option value="3" >3%</option>
                                <option value="4" >4%</option>
                                <option value="5" >5%</option>
                            </select>

                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">IT TDS Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="it_ids_amount" id="it_ids_amount" value="0.00" placeholder="IT TDS Amount" readonly>
                              <input type="hidden" class="form-control onlyNumericInput"  id="it_ids_amount_data" value="0.00" placeholder="IT TDS Amount" readonly>
                            </div>
                          </div>
                          <div class="col-md-6" style="padding-left:0px">
                            <div class="form-group">
                              <!-- Replace gtds to tcs -->
                              <label class="">TCS % <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                            
                              <select class="form-select form-control" aria-label="Default select example" name="tcs_percenatge" id="tcs_percenatge" >
                                <option value="">Select</option>
                                <option value="0" >0%</option>
                                <option value="1" >1%</option>
                                <option value="2" >2%</option>
                                <option value="3" >3%</option>
                                <option value="4" >4%</option>
                                <option value="5" >5%</option>
                              </select>
                              </div>
                            </div>
                         
                          <div class="col-md-6">
                            <div class="form-group">
                              <!-- Replace gtds to tcs -->
                              <label class="">TCS Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                              <input type="text" class="form-control onlyNumericInput" name="tcs_amount" id="tcs_amount" value="0.00"  placeholder="TCS Amount" readonly>
                            </div>
                          </div>
                        
                        <hr>
                        <p> <b>Any Other Tax Deduction</b>
                        </p>
                        <div class="row tax-deduction-block">
                          
                          
                        <div class="tax-deduction-row" data-name="add_tax_data">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="">Tax Deduction Description <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                <input type="text" class="form-control" name="tax_deduction_description[]"    placeholder="Tax Deduction Description" >
                              </div>
                            </div>

                            <div class="col-md-5">
                              <div class="form-group">
                                <label class="">Tax Deduction Amount  <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                <input type="text" class="form-control onlyNumericInput tax_deduction_amount add_tax_deduction_amount" name="tax_deduction_amount[]" value="0.00"  placeholder="Tax Deduction Amount">
                              </div>
                            </div>
                            <div class="col-md-1">
                              <div class="form-group">
                                <br> <button type="button" class="add-tax-deduction" data-name="add-tax-data">Add</button>
                              </div>
                            </div>
                          </div>
                         
                          
                        </div>
                       
                        
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="">Total Amount After Deduction </label>
                              <input type="text" class="form-control onlyNumericInput" name="total_amount_with_deduction"  id="total_amount_with_deduction" value="0.00"  readonly>
                            </div>
                          </div>
                          </div>


                              <div id="displayPOItems" style="width: 100%;overflow-x: auto;">
                                 <table width="100%" id="bomindentitmdisplay" class="table table-striped table-bordered table-hover" style="margin-top:15px;">
                                    <thead>
                                       <tr>
                                          <th style="min-width: 50px;width:50px;">Sr. No.</th>
                                          <th style="min-width: 50px;width:50px;">BOM Sr. No.</th>
                                          <th style="min-width: 100px;width:100px;">Item Description</th>
                                          <th style="min-width: 80px;width:80px;">Unit</th>
                                          <th style="min-width: 80px;width:80px;">Make</th>
                                          <th style="min-width: 80px;width:80px;">Model</th>
                                          <th style="min-width: 80px;width:80px;">Po Qty</th>
                                          <th style="min-width: 80px;width:80px;">DC Qty (In Good Condition) </th>
                                          <th style="min-width: 80px;width:80px;display:none">Available Qty for GRN </th>
                                          <th style="min-width: 80px;width:80px;">Basic Rate</th>
                                          <th style="min-width: 80px;width:80px;">GST</th>
                                          <th style="min-width: 80px;width:80px;">Amount</th>
                                          <!-- <th style="min-width: 80px;width:80px;">Action</th> -->
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       // pr(count($dc_item_data),1);
                                          if (count($dc_item_data) > 0) {
                                            foreach ($dc_item_data as $key=> $item): ?>

                                           
                                       <tr class="odd">
                                          <td>
                                             <input type="text" class="form-control invaliderror" name="sr_no[]" value="<?= $key+1 ?>" placeholder="Sr.No" style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td>
                                             <input type="hidden" class="js-boq_code" name="boq_code[]" value="<?= $item['boq_code'] ?>" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>
                                             <input type="hidden"  name="hsn_sac_code[]" value="<?= $item['hsn_code'] ?>"  style="font-size: 12px;width:100%" readonly>
                                             <input type="text" class="form-control  js-bom_sr_no" name="bom_code[]" value="<?= $item['bom_code'] ?>" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td>
                                             <input type="text" class="form-control " name="bom_item_description[]" value="<?= $item['item_description'] ?>" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td>
                                             <input type="text" class="form-control " name="bom_unit[]" value="<?= $item['unit'] ?>" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td>
                                             <!--<select  class="form-control bom_make"  name="bom_make[]"><?php echo $item['make_opt']; ?></select>-->
                                             <input type="text" class="form-control " name="bom_make[]" value="<?= $item['make'] ?>" placeholder="Model" style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td>
                                             <!--<select  class="form-control bom_model"  name="bom_model[]"><?php echo $item['model_opt']; ?></select>-->
                                              <input type="text" class="form-control " name="bom_model[]" value="<?= $item['model'] ?>" placeholder="Model" style="font-size: 12px;width:100%" readonly> 
                                          </td>
                                          <td>
                                             <input type="text" class="form-control  po-avilable-stock" name="bom_po_stock[]" value="<?= $item['po_qty'] ?>" placeholder="Available Qty" style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td>
                                             <input type="text" class="form-control  js-requires-dc-qty" name="bom_dc_stock[]" value="<?= $item['good_condition_qty'] ?>" placeholder="Required Qty" style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td style="display:none">
                                             <input type="text" class="form-control  js-requires-grn-qty onlyNumericInput" name="bom_grn_stock[]"   value="<?= $item['good_condition_qty'] ?>" placeholder="Required Qty" style="font-size: 12px;width:100%" >
                                          </td>
                                         
                                          <td>
                                             <input type="text" class="form-control  js-po-basic_rate "  name="basic_rate[]" value="<?= $item['basic_rate'] ?>" placeholder="Required Qty" style="font-size: 12px;width:100%" readonly>
                                             <!-- <input type="hidden" class="form-control  basic_rate "  name="basic_rate[]" value="<?= $item['veriable_rate'] ?>" placeholder="Required Qty" style="font-size: 12px;width:100%" readonly> -->
                                          </td>
                                          <td>
                                             <input type="text" class="form-control " name="bom_gst[]" value="<?= $item['gst'] ?>" placeholder="Required gst" style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td >
                                             <input type="text" class="form-control "  name="amount[]" value="<?= $item['total_amount'] ?>" placeholder="Required Qty" style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <!-- <td>
                                             <div class="addDeleteButton"><span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span></div>
                                          </td> -->
                                       </tr>
                                       <?php endforeach;
                                          }else{?>
                                       <tr>
                                          <td colspan="11" style="text-align: center;">No data Available</td>
                                       </tr>
                                       <?php  }
                                          ?>
                                    </tbody>
                                 </table>
                                 
                              </div>
                              <div class="form-actions right">
                                 <!--<button type="button" class="btn btn-danger cancel clearData" title="click To Cancel"> Cancel</button>-->
                                 <button type="button" class="btn btn-danger cancel" onclick="location.href = 'vendor_delivery_challan';" title="click To Cancel"> Cancel</button>
                                 <?php if (isset($total_dc_amount, $total_advance_payment) && ($total_dc_amount - $total_advance_payment > 0)) { ?>
                                 <button type="submit" class="btn green " title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> Save</button>
                                 <?php }else{?>
                                    <button type="submit" class="btn green " title="click To Save" rel="0" disabled><i class="fa fa-dot-circle-o"></i> Save</button>
                                    <?php } ?>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="portlet light">
                           <div class="portlet-title">
                              <div class="caption font-blue">
                                 <i class="fa fa-bars font-blue"></i>
                                 <span class="caption-subject bold uppercase"> Goods Received Notes</span>
                              </div>
                           </div>
                           <div class="portlet-body">
                              <input type="hidden" name="project_id" id="project_id" >
                              <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                              <table width="100%" id="grn_list" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                    <th scope="col" style="vertical-align: top;">Sr.no</th>
                                    <th scope="col" style="vertical-align: top;">BP Code</th>
                                    <th scope="col" style="vertical-align: top;">PO No.</th>
                                    <th scope="col" style="vertical-align: top;">GRN No</th>
                                    <!--<th scope="col" style="vertical-align: top;">DC Qty (In Good Condition)</th>-->
                                    <th scope="col" style="vertical-align: top;">Amount</th>
                                    <th scope="col" style="vertical-align: top;">CreatedBy</th>
                                    <th scope="col" style="vertical-align: top;">ApprovedBy</th>
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
      <style>
         label.error{
         display: unset;
         }
      </style>
      <script src="<?php echo base_url();?>js/goods_received_note.js" type="text/javascript"></script>
      <script type="text/javascript">
         var page_type = 'goods_received_note';
         var purchase_order_number = <?php echo json_encode(isset($po_details) && isset($po_details->po_number) ? $po_details->po_number : ''); ?>;

      </script>
      <script>
         jQuery(document).ready(function() {
           Metronic.init(); // init metronic core components
           Layout.init();
           ComponentsPickers.init();
         });
      </script>
   </body>
</html>
