<?php if(count($pending_parts) > 0){?>

<p id="invaliderrorid" style="padding: 10px 0px;font-size: 12px;color:#a94442;">

   Vendor Delivery Challan Quantity Pending for BOM Sr No  ('<?php

      echo implode(",", $pending_parts);

   ?>')                                    </p>

   

<?php } ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8"/>
      <title> Vendor Delivery Challan | <?php echo project_name; ?> </title>
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
                   <?php if(count($pending_parts) > 0){?>

                                    <b>

                                      Vendor Delivery Challan Quantity Pending for BOM Sr No - <?php

                                        echo implode(",", $pending_parts);

                                       ?> </b>

                                       
    <?php }else{ ?>
    <b>This Vendor Delivery Challan has already been added. No further action is required.</b>
                                    <?php } ?>
                  
               </div>
               <div class="portlet-body">
                  <div class="alert-container hide">
                  </div>
                  <div class="row vdc_form_data">
                     <input type="hidden" id="vdc_po" value="<?php echo $common_data['po_number'];?>">
                     <input type="hidden" id="vdc_po_count" value="<?php echo count($po_items);?>">
                     <div class="col-md-12">
                        <div class="portlet light">
                           <div class="portlet-title">
                              <div class="caption font-blue">
                                 <i class="fa fa-plus-circle font-blue"></i>
                                 <span class="caption-subject bold uppercase">Vendor Delivery Challan</span>
                              </div>
                           </div>
                           <form action="javascript:void(0)" enctype="multipart/form-data" id="vendor_delivery_challan_update_form" method="post" style="display: none">
                              <input type="hidden" class="form-control" id="vdc_id" name="vdc_id"  readonly value="">
                              <input type="hidden" class="form-control" id="transaction_id" name="transaction_id"  readonly value="">
                              <div class="row" style="border-bottom:1px solid #c5bcbc7d;">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label class="control-label">Select Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="bp_code" id="bp_code_edit" placeholder="Select Project Code"  readonly value="">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label class="control-label">Select Vendor Category <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  id="category_name_edit" name="category_name" placeholder="Select Vendor category" readonly value="" >

                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label class="control-label">Select Vendor Name <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  id="vendor_name_edit" name="vendor_name" placeholder="Select Vendor " readonly value="" >
                                    </div>
                                 </div>
                              </div>
                              <div class="row pt-2" style="border-bottom:1px solid #c5bcbc7d;">
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Issued On</label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" class="form-control" name="work_order_on" id="work_order_on_edit" placeholder="Work Order On" value="" readonly >
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                                          <input type="text" name="dc_date" id="dc_date_edit" class="form-control" readonly placeholder="Date">
                                          <span class="input-group-btn">
                                          <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3" >
                                    <div class="form-group">
                                       <label class="">Purchase Order number <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" class="form-control" name="po_number" id="po_number_edit" value=""  placeholder="Purchase Order Number"  readonly>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Purchase Order Date <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-group date" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                                          <input type="text" name="po_date" id="po_date_edit" class="form-control" readonly placeholder="Dated" value="">
                                          <span class="input-group-btn">
                                          <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Vendor Invoice No. </label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" class="form-control" name="suppliers_ref" id="suppliers_ref_edit" placeholder="Vendor Invoice No." readonly >
                                       </div>
                                    </div>
                                 </div>
                                 
                                 
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Vendor E way Bill No. <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" class="form-control" name="e_way_number" id="e_way_number_edit"  placeholder="Vendor E way Bill No." readonly>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">GST Number<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" class="form-control" name="gst_number" id="gst_number_edit"  placeholder="GST Number" readonly>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Vendor DC No. <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" class="form-control" name="dispatch_document_no" id="dispatch_document_no_edit"  placeholder="Vendor DC No." readonly>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3 hide">
                                    <div class="form-group">
                                       <label class="">Destination <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" class="form-control" name="destination" id="destination_edit"  placeholder="Destination" readonly>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3" >
                                    <div class="form-group">
                                       <label class="">Address <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <textarea rows="2" type="text" class="form-control" name="registered_address" id="registered_address_edit" placeholder="Address" readonly required></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Site Address <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <textarea rows="2" type="text" readonly class="form-control" name="site_address" id="site_address_edit" placeholder="Site Address" readonly></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Dispatch Through <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <textarea rows="2" type="text" readonly class="form-control" name="dispatch_through" id="dispatch_through_edit" placeholder="Dispatch Through" readonly></textarea>
                                      
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Terms of Delivery <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <textarea rows="2" type="text" class="form-control" name="terms_of_delivery" id="terms_of_delivery_edit" placeholder="Terms of Delivery" readonly></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Vendor DC or Eway Challan <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="file"  name="attachement" id="attachement_edit"  placeholder="Vendor DC No." >
                                          <input type="hidden" id="hidden_attachement" name="hidden_attachement" value="">
                                          <div class="download_attachement"></div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div id="displayPOItems" style="width: 100%;overflow-x: auto;">
                                 <table width="100%" id="bomindentitmdisplay_edit" class="table table-striped table-bordered table-hover" style="margin-top:15px;">
                                    <thead>
                                       <tr>
                                          <th style="min-width: 50px;width:50px;">Sr. No.</th>
                                          <th style="min-width: 50px;width:50px;">BOM Sr. No.</th>
                                          <th style="min-width: 100px;width:100px;">Item Description</th>
                                          <th style="min-width: 80px;width:80px;">Unit</th>
                                          <th style="min-width: 80px;width:80px;">Make</th>
                                          <th style="min-width: 80px;width:80px;">Model</th>
                                          <th style="min-width: 80px;width:80px;">Po Qty</th>
                                          <th style="min-width: 80px;width:80px;">DC Qty</th>
                                          <th style="min-width: 80px;width:80px;">Good <br> condition</th>
                                          <th style="min-width: 80px;width:80px;">Bad <br>condition</th>
                                          <th class="hide" style="min-width: 80px;width:80px;">Basic Rate</th>
                                          <th class="hide" style="min-width: 80px;width:80px;">GST</th>
                                          <th class="" style="min-width: 80px;width:80px;">Amount</th>

                                       </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                 </table>
                                 <p id="invaliderrorid" style="padding: 10px 0px;font-size: 12px;color:#a94442;"></p>
                              </div>
                              <div class="form-actions right">
                                 <button type="button" class="btn btn-danger cancel clearData" title="click To Cancel"> Cancel</button>
                                 <button type="submit" class="btn green " title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> Update</button>
                              </div>
                           </form>
                           <form action="javascript:void(0)" enctype="multipart/form-data" id="vendor_delivery_challan_form" method="post">
                              <div class="row" style="border-bottom:1px solid #c5bcbc7d;">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label class="control-label">Select Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="bp_code" placeholder="Select Project Code" required readonly value="<?php echo $project_data->bp_code;?>">
                                       <input type="hidden" class="form-control" id="project_id" name="project_id" placeholder="Select Project Code"  readonly value="<?php echo $project_data->project_id;?>">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label class="control-label">Select Vendor Category <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="category_name" placeholder="Select Vendor category" readonly value="<?php echo $category_data->category_name;?>" required>
                                       <input type="hidden" class="form-control"  name="vendor_category_id" placeholder="Select Vendor category" readonly value="<?php echo $category_data->category_id;?>" required>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label class="control-label">Select Vendor Name <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <input type="text" class="form-control"  name="vendor_name" placeholder="Select Vendor " readonly value="<?php echo $vendor_data->name_of_company;?>" required>
                                       <input type="hidden" class="form-control"  name="vendor_id" placeholder="Select Vendor " readonly value="<?php echo $vendor_data->vendor_id;?>" required>
                                    </div>
                                 </div>
                              </div>
                              <div class="row pt-2" style="border-bottom:1px solid #c5bcbc7d;">
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Issued On</label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" class="form-control" name="work_order_on" id="work_order_on" placeholder="Work Order On" value="<?php echo $project_data->work_order_on;?>" readonly >
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                                          <input type="text" name="dc_date" id="dc_date" class="form-control" readonly placeholder="Date"  value="<?php echo $dc_date; ?>" <?php if($dc_date !=""){echo 'readonly';} ?>>
                                          <span class="input-group-btn">
                                          <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3" >
                                    <div class="form-group">
                                       <label class="">Purchase Order number <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" class="form-control" name="po_number" id="po_number" value="<?php echo (isset($po_details[0]->po_number) && !empty($po_details[0]->po_number)) ? $po_details[0]->po_number : '' ?>"  placeholder="Purchase Order Number"  readonly>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Purchase Order Date <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-group date" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                                          <input type="text" name="po_date" id="po_date" class="form-control" readonly placeholder="Dated" value="<?php echo (isset($po_details[0]->created_on) && !empty($po_details[0]->created_on)) ? date('d-m-Y', strtotime($po_details[0]->created_on)) : '';?>">
                                          <span class="input-group-btn">
                                          <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                      <!-- After the client  changes, suppliers_ref was renamed to Vendor Invoice No.. -->
                                       <label class="">Vendor Invoice No. </label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" class="form-control" name="suppliers_ref" id="suppliers_ref" placeholder="Vendor Invoice No." value="<?php echo $suppliers_ref; ?>" <?php if($suppliers_ref !=""){echo 'readonly';} ?>  >
                                       </div>
                                    </div>
                                 </div>
                                 
                                 
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Vendor E way Bill No. <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" class="form-control" name="e_way_number" id="e_way_number"  placeholder="Vendor E way Bill No." value="<?php echo $e_way_number; ?>" <?php if($e_way_number !=""){echo 'readonly';} ?>>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">GST Number<span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" class="form-control" name="gst_number" id="gst_number"  placeholder="GST Number" value="<?php echo $gst_number; ?>" <?php if($gst_number !=""){echo 'readonly';} ?>>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <!-- After the client  changes, dispatch_document_no was renamed to Vendor DC No. -->
                                       <label class="">Vendor DC No. <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" class="form-control" name="dispatch_document_no" id="dispatch_document_no"  placeholder="Vendor DC No." value="<?php echo $dispatch_document_no; ?>" <?php if($dispatch_document_no !=""){echo 'readonly';} ?>>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3 hide">
                                    <div class="form-group">
                                       <label class="">Destination <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="text" class="form-control" name="destination" id="destination"  placeholder="Destination" >
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3" >
                                    <div class="form-group">
                                       <label class="">Address <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <textarea rows="2" type="text" class="form-control" name="registered_address" id="registered_address" placeholder="Address" readonly required><?php echo $project_data->client_po_addr;?></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Site Address <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <textarea rows="2" type="text" readonly class="form-control" name="site_address" id="site_address" placeholder="Site Address" > <?php echo $project_data->site_address;?></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Dispatch Through <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <textarea rows="2" type="text"  class="form-control" name="dispatch_through" id="dispatch_through" placeholder="Dispatch Through"  <?php if($dispatch_through !=""){echo 'readonly';} ?>> <?php echo $dispatch_through; ?> </textarea>
                                       
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Terms of Delivery <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <textarea rows="2" type="text" class="form-control" name="terms_of_delivery" id="terms_of_delivery" placeholder="Terms of Delivery"  <?php if($terms_of_delivery !=""){echo 'readonly';} ?>> <?php echo $terms_of_delivery ; ?></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3 hide">
                                    <div class="form-group">
                                       <label class="">Advance Payment</label>
                                       <div class="input-icon right">
                                          <input type="text" class="form-control" id="total_advance_payment" name="total_advance_payment" value="<?php echo $total_advance_payment; ?>" placeholder="" readonly>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label class="">Vendor DC or Eway Challan <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                       <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input type="file"  name="attachement" id="attachement"  placeholder="Vendor DC No." >
                                       </div>
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
                                          <th style="min-width: 80px;width:80px;">DC Qty</th>
                                          <th style="min-width: 80px;width:80px;">Good <br> condition</th>
                                          <th style="min-width: 80px;width:80px;">Bad <br>condition</th>
                                          <th class="hide" style="min-width: 80px;width:80px;">Basic Rate</th>
                                          <th class="hide" style="min-width: 80px;width:80px;">GST</th>
                                          <th class="hide" style="min-width: 80px;width:80px;">Amount</th>
                                          <th style="min-width: 80px;width:80px;">Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                          if (count($po_items) > 0) {
                                            foreach ($po_items as  $key => $item): ?>
                                       <tr class="odd">
                                          <td>
                                             <input type="text" class="form-control invaliderror" name="sr_no[]" value="<?= $key+1 ?>" placeholder="Sr.No" style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td>
                                             <input type="hidden" class="js-req_qty" name="req_qty[]" value="<?= $item['req_qty'] ?>" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>
                                             <input type="hidden" class="js-boq_code" name="boq_code[]" value="<?= $item['boq_code'] ?>" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>
                                             <input type="hidden"  name="hsn_sac_code[]" value="<?= $item['hsn_sac_code'] ?>"  style="font-size: 12px;width:100%" readonly>
                                             <input type="text" class="form-control  js-bom_sr_no" name="bom_code[]" value="<?= $item['bom_code'] ?>" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td>
                                             <input type="text" class="form-control " name="bom_item_description[]" value="<?= $item['bom_item_description'] ?>" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td>
                                             <input type="text" class="form-control " name="bom_unit[]" value="<?= $item['bom_unit'] ?>" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td>
                                             <select  class="form-control bom_make"  name="bom_make[]"><?php echo $item['make_opt']; ?></select>
                                          </td>
                                          <td>
                                             <select  class="form-control bom_model"  name="bom_model[]"><?php echo $item['model_opt']; ?></select>
                                             <!-- <input type="text" class="form-control " name="bom_model[]" value="<?= $item['bom_model'] ?>" placeholder="Model" style="font-size: 12px;width:100%" readonly> -->
                                          </td>
                                          <td>
                                             <input type="text" class="form-control  po-avilable-stock" name="bom_po_stock[]" value="<?= $item['bom_po_stock'] ?>" placeholder="Available Qty" style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td>
                                             <input type="text" class="form-control  js-requires-dc-qty" name="bom_dc_stock[]" value="<?= $item['bom_dc_stock'] ?>" placeholder="Required Qty" style="font-size: 12px;width:100%">
                                          </td>
                                          <td>
                                             <input type="text" class="form-control" name="bom_good_condition[]" value="<?= $item['bom_dc_stock'] ?>" placeholder="Good Condition Qty" style="font-size: 12px;width:100%">
                                          </td>
                                          <td>
                                             <input type="text" class="form-control" name="bom_bad_condition[]" value="0" placeholder="Bad Condition Qty" style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td class="hide">
                                             <input type="text" class="form-control  js-po-basic_rate "  name="rate_basic[]" value="<?= $item['rate_basic'] ?>" placeholder="Required Qty" style="font-size: 12px;width:100%" >
                                             <input type="hidden" class="form-control  basic_rate "  name="basic_rate[]" value="<?= $item['rate_basic'] ?>" placeholder="Required Qty" style="font-size: 12px;width:100%" >
                                          </td>
                                          <td class="hide">
                                             <input type="text" class="form-control " name="bom_gst[]" value="<?= $item['bom_gst'] ?>" placeholder="Required gst" style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td class="hide">
                                             <input type="text" class="form-control amount"  name="amount[]" value="<?= $item['amount'] ?>" placeholder="Required Qty" style="font-size: 12px;width:100%" readonly>
                                          </td>
                                          <td>
                                             <div class="addDeleteButton"><span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span></div>
                                          </td>
                                       </tr>
                                       <?php endforeach;
                                          }else{?>
                                       <tr>
                                          <td colspan="14" style="text-align: center;">No data Available</td>
                                       </tr>
                                       <?php  }
                                          ?>
                                    </tbody>
                                 </table>
                                 <?php if(count($pending_parts) > 0){?>

                                    <p id="invaliderrorid" style="padding: 10px 0px;font-size: 12px;color:#a94442;">

                                      Vendor Delivery Challan Quantity Pending for BOM Sr No  ('<?php

                                        echo implode(",", $pending_parts);

                                       ?>')                                    </p>

                                    <?php } ?>
                              </div>
                              <div class="form-actions right">
                                 <button type="button" class="btn btn-danger cancel clearData" title="click To Cancel"> Cancel</button>
                                 <button type="submit" class="btn green " title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> Save</button>
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
                                 <span class="caption-subject bold uppercase"><?php echo (isset($bp_code) && !empty($bp_code)) ? '(#' . $bp_code . ')' : '' ?> Vendor Delivery Challan</span>
                              </div>
                           </div>


                           <div class="merge-vdc hide">
                      
                           <!-- Button trigger modal -->
                           <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModal">
                              Merge VDC
                           </button>

                           <!-- Modal -->
                           <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                              <div class="modal-content">
                                 <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLabel">Merge Vendor Delivery Challan</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                 </button>
                                 </div>
                                 <div class="modal-body vdc-merege-body">
                                    
                                 <div class="container-fluid">
                                 
                                 <div class="row" style="padding-bottom:10px">
                                    <div class="col-xs-6">
                                       <label>Select PO Number</label>
                                       <select id="po_number_select" class="form-select form-control form-select-sm" aria-label=".form-select-sm example">
                                          <option>Select PO Number</option>
                                          <?php foreach($po_list as $key => $val) { ?>
                                             <option value="<?php echo $val['po_number']; ?>"><?php echo $val['po_number']; ?></option>
                                          <?php } ?>
                                       </select>
                                    </div>
                                    <div class="col-xs-6">
                                       <!-- Add any content here if needed -->
                                    </div>
                                 </div>
                                 
                              <form action="javascript:void(0)" enctype="multipart/form-data" id="vendor_delivery_challan_merege_form" method="post" >

                                 <div class="row" style="border-top: 1px solid #dddddd; padding-top: 10px;"id="checkbox-container" class="container-fluid">
                               
                            
                              </div>
                              <div class="merging_data" style="display:none">
                              <table class="table table-bordered">
                              <thead>
                                 <tr>
                                    <th scope="col">#</th>
                                    <!-- <th scope="col">DC Number</th> -->
                                    <th scope="col">Bom Code</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Rate</th>
                                    <th scope="col">GST</th>
                                    <th scope="col">Amount</th>
                                 </tr>
                              </thead>
                              <tbody id="table-body">
                              
                              </tbody>
                           </table>
                           </div>


                              </div>


                                 </div>
                                 <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary vdc_merege_close" data-dismiss="modal">Close</button>
                                 <button type="submit" class="btn btn-primary vdc_merege_save" disabled>Save</button>
                                 </div>
                              </div>
                           </div>
                           </div>

                            </form>

                           </div>



                           <div class="portlet-body">
                              <input type="hidden" name="project_id" id="project_id" >
                              <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                              <table width="100%" id="vendor_dc_list" class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr>
                                       <th scope="col" style="vertical-align: top;">Sr.no</th>
                                       <th scope="col" style="vertical-align: top;">BP Code</th>
                                       <th scope="col" style="vertical-align: top;">DC No.</th>
                                       <th scope="col" style="vertical-align: top;">Challan Type</th>
                                       <th scope="col" style="vertical-align: top;">PO No.</th>
                                       <th scope="col" style="vertical-align: top;">DC Amount</th>
                                       <th scope="col" style="vertical-align: top;">CreatedBy</th>
                                       <th scope="col" style="vertical-align: top;">ApprovedBy</th>
                                       <th scope="col" style="vertical-align: top;">Status</th>
                                       <th scope="col" style="vertical-align: top;">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 </tbody>
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
      <script type="text/javascript">
         var page_type = 'vendor_delivery_challan';
         var po_number = '<?php echo $po_number; ?>';
      </script>
      <script src="<?php echo base_url();?>js/vendor-dc.js" type="text/javascript"></script>
      
      <script>
         jQuery(document).ready(function() {
           Metronic.init(); // init metronic core components
           Layout.init();
           ComponentsPickers.init();
         });
      </script>
   </body>
</html>
