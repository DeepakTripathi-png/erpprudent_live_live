<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title> Purchase Proforma Invoice | <?php echo project_name; ?> </title>
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
            <div class="alert alert-warning hide">
                <?php if(count($pending_parts) > 0){?>
                        <p><strong>Warning!</strong>
                          Purchase Proforma Invoice Quantity Pending for BOM Sr No ('<?php
                            echo implode(",", $pending_parts);
                           ?>')
                           is pending.
                        </p>
                        <?php }else{ ?>
                        
            <strong>Warning!</strong> No BOM Items Available.
            <?php } ?>
          </div>
          <div class="row ppi_data">
                <input type="hidden" id="ppi" value="<?php echo $common_data['po_number'];?>">
                  <input type="hidden" id="ppi_count" value="<?php echo count($po_items);?>">
            <div class="col-md-12">
              <div class="portlet light">
                <div class="portlet-title">
                  <div class="caption font-blue">
                    <i class="fa fa-plus-circle font-blue"></i>
                    <span class="caption-subject bold uppercase">Purchase Proforma Invoice</span>
                  </div>
                </div>
                <div class="edit_po_form portlet-body form " style="display:none;">
                  <form action="edit_save_pi_request" enctype="multipart/form-data" id="edit_save_pi_request"  method="post" class="horizontal-form">
                    <input type="hidden" name="base_url" id="edit_base_url" value="<?php echo base_url();?>">
                    <input type="hidden" name="transaction_id" id="transaction_id_edit" value="">
                    <input type="hidden" name="performa_id" id="performa_id_edit" value="">
                    <input type="hidden" name="edit_terms_and_condition_val" id="edit_terms_and_condition_val" value="">

                    <div class="form-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label">Select Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                            <input type="text" class="form-control " id="edit_project_id" name="project_id" placeholder="Select Project Code" readonly>
                            <span id="projlaoding"></span>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label">Select Vendor Category <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                            <input type="text" class="form-control " id="edit_category" name="vendor_category_id" placeholder="Select Vendor category" readonly>
                            <span id="vCategoryLaoding"></span>
                          </div>

                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label">Select Vendor Name <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                            <input type="text" class="form-control allVendor" id="edit_vendor_id" name="vendor_id" placeholder="Select Vendor " readonly>
                            <span id="vendorLaoding"></span>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label">Address </label>
                            <input type="text" class="form-control " id="edit_address" name="address"  readonly>
                          </div>
                        </div>
                        <div class="col-md-4 ">
                          <div class="form-group">
                            <label class="control-label">GST No </label>
                            <input type="text" class="form-control " id="edit_gst_number" name="gst_number" readonly>
                          </div>
                        </div>
                        <div class="col-md-4 ">
                          <div class="form-group">
                            <label class="control-label">PO Number </label>
                            <input type="text" class="form-control " id="edit_po_number" name="po_number" readonly>
                          </div>
                        </div>

                      </div>

                      <div id="editDisplayPOItems" style="width: 100%;overflow-x: auto;" >
                        <table width="100%" id="Editbomindentitmdisplay" class="table table-striped table-bordered table-hover" style="margin-top:15px;">
                          <thead>
                            <tr>
                              <th style="min-width: 50px;width:50px;">Sr. No.</th>
                              <th style="min-width: 50px;width:50px;">BOM Sr. No.</th>
                              <th style="min-width: 100px;width:100px;">Item Description</th>
                              <th style="min-width: 80px;width:80px;">Unit</th>
                              <th style="min-width: 80px;width:80px;">Make</th>
                              <th style="min-width: 80px;width:80px;">Model</th>
                              <th style="min-width: 80px;width:80px;">Available For PO</th>
                              <th style="min-width: 80px;width:80px;">Qty</th>
                              <th style="min-width: 80px;width:80px;">Basic Rate</th>
                              <th style="min-width: 80px;width:80px;">GST</th>
                              <th style="min-width: 80px;width:80px;">Amount</th>
                            </tr>
                          </thead>
                        </table>
                        <p id="editinvaliderrorid" style="padding: 10px 0px;font-size: 12px;color:#a94442;"></p>
                      </div>

                    </div>

                    <div class="form-actions">
                      <div class="col-md-12" id="displayTnC">
                        <label class="control-label">Terms and Condition</label>
                        <textarea class="form-control" name="edit_terms_and_condition" id="edit_terms_and_condition" placeholder="Terms And Condition" rows="4"></textarea>
                      </div>
                      <div class="col-md-3" id="displayPORemark">
                        <label class="control-label">Remark</label>
                        <input type="text" class="form-control" name="edit_remark" id="edit_remark" placeholder="Remark" value="">
                      </div>
                      <div class="col-md-1 hide" id="displayPOAttachment">
                        <div class="form-group">
                          <label class="control-label">Attachment (If Any)</label><br>
                          <input type="file" name="boq_excel_file" id="attachment" class="attachment">
                          <br>
                        </div>
                      </div>

                      <div class="col-md-3" >
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end right" style="position: relative !important;top: 20px !important;left: 230% !important;">
                          <!--<button type="button" class="btn btn-danger cancel clearData" title="Click To Cancel">Cancel</button>-->
                          <!--<button type="button" class="btn btn-danger cancel clearData" title="Click To Cancel" onclick="window.location.href='create_purchase_order'">Cancel</button>-->
                         <a href="create_purchase_order" class="btn btn-danger cancel clearData" title="Click To Cancel">Cancel</a>
                          <button type="submit" class="btn green common_save" title="Click To Save" rel="0">
                            <i class="fa fa-dot-circle-o"></i> Send to Approval
                          </button>
                        </div>
                      </div>
                    </div>

                  </form>
                </div> 

                <div class="portlet-body form add_po_form">
                  <form action="save_proforma_invovce" enctype="multipart/form-data" id="save_proforma_invovce"  method="post" class="horizontal-form">
                    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                    <input type="hidden" name="po_number" id="po_number" value="<?php echo $common_data['po_number']; ?>">
                    <input type="hidden" name="transaction_id" id="transaction_id" value="<?php echo $common_data['transaction_id']; ?>">
                    <input type="hidden" class="form-control" id="project_id_val" name="project_id_val"  value="<?php echo $common_data['project_id']; ?>">
                    <input type="hidden" name="terms_and_condition_val" id="terms_and_condition_val" value="">
                    <div class="form-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label">Select Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                            <input type="text" class="form-control" id="project_id" name="project_id" placeholder="Select Project Code" required readonly value="<?php echo $project_data->bp_code;?>">
                            <span id="projlaoding"></span>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label">Select Vendor Category <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                            <input type="text" class="form-control"  name="vendor_category_id" placeholder="Select Vendor category" readonly value="<?php echo $category_data->category_name;?>" required>
                            <span id="vCategoryLaoding"></span>
                          </div>

                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label">Select Vendor Name <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                            <input type="text" class="form-control"  name="vendor_id" placeholder="Select Vendor " readonly value="<?php echo $vendor_data->name_of_company;?>" required>
                            <span id="vendorLaoding"></span>
                          </div>
                        </div>
                        <div class="col-md-4 vendor-details">
                          <div class="form-group">
                            <label class="control-label">Address </label>
                            <input type="text" class="form-control " id="address" name="address"  value="<?php echo $vendor_data->reg_house_building_no." ".$vendor_data->reg_street." ".$vendor_data->reg_city_post_code." ".$vendor_data->reg_state;?>"  readonly>
                          </div>
                        </div>
                        <div class="col-md-4 vendor-details">
                          <div class="form-group">
                            <label class="control-label">GST No </label>
                            <input type="text" class="form-control " id="gst_number" name="gst_number" value="<?php echo $vendor_data->gst_registration_no;?>"   readonly>
                          </div>
                        </div>
                        <div class="col-md-4 vendor-details">
                          <div class="form-group">
                            <label class="control-label">PO Number </label>
                            <input type="text" class="form-control " id="po_number" name="po_number" value="<?php echo $common_data['po_number'];?>"  readonly>
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
                              <th style="min-width: 80px;width:80px;">Available Qty</th>
                              <th style="min-width: 80px;width:80px;">Qty</th>
                              <th style="min-width: 80px;width:80px;">Basic Rate</th>
                              <th style="min-width: 80px;width:80px;">GST</th>
                              <th style="min-width: 80px;width:80px;">Amount</th>

                            </tr>
                          </thead>
                          <tbody>

                            <?php
                              if (count($po_items) > 0) {
                            foreach ($po_items as $item): ?>
                              <tr class="odd">
                                <td>
                                  <input type="text" class="form-control invaliderror" name="sr_no[]" value="<?= $item['sr_no'] ?>" placeholder="Sr.No" style="font-size: 12px;width:100%" readonly="">
                                </td>
                                <td>
                                  <input type="hidden" class="js-req_qty" name="req_qty[]" value="<?= $item['req_qty'] ?>" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly="">
                                  <input type="hidden" class="js-boq_code" name="boq_code[]" value="<?= $item['boq_code'] ?>" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly="">
                                  <input type="hidden"  name="hsn_sac_code[]" value="<?= $item['hsn_sac_code'] ?>"  style="font-size: 12px;width:100%" readonly="">
                                  <input type="text" class="form-control  js-bom_sr_no" name="bom_code[]" value="<?= $item['bom_code'] ?>" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly="">
                                </td>
                                <td>
                                  <input type="text" class="form-control " name="bom_item_description[]" value="<?= $item['bom_item_description'] ?>" placeholder="Item Description" style="font-size: 12px;width:100%" readonly="">
                                </td>
                                <td>
                                  <input type="text" class="form-control " name="bom_unit[]" value="<?= $item['bom_unit'] ?>" placeholder="Item Description" style="font-size: 12px;width:100%" readonly="">
                                </td>
                                <td>
                                  <select  class="form-control bom_make"  name="bom_make[]"><?php echo $item['make_opt']; ?></select>
                                </td>
                                <td>
                                <select  class="form-control bom_model"  name="bom_model[]"><?php echo $item['model_opt']; ?></select>
                                  <!-- <input type="text" class="form-control " name="bom_model[]" value="<?= $item['bom_model'] ?>" placeholder="Model" style="font-size: 12px;width:100%" readonly=""> -->
                                </td>
                                <td>
                                  <input type="text" class="form-control  po-avilable-stock" name="bom_avl_stock[]" value="<?= $item['bom_avl_stock'] ?>" placeholder="Available Qty" style="font-size: 12px;width:100%" readonly="">
                                </td>
                                <td>
                                  <input type="text" class="form-control  js-requires-po-qty" name="bom_req_stock[]" value="<?= $item['bom_req_stock'] ?>" placeholder="Required Qty" style="font-size: 12px;width:100%">
                                </td>
                                <td>
                                  <input type="text" class="form-control  js-po-basic_rate "  name="rate_basic[]" value="<?= $item['rate_basic'] ?>" placeholder="Required Qty" style="font-size: 12px;width:100%" >
                                  <input type="hidden" class="form-control  basic_rate "  name="basic_rate[]" value="<?= $item['rate_basic'] ?>" placeholder="Required Qty" style="font-size: 12px;width:100%" >
                                </td>
                                <td>
                                  <input type="text" class="form-control " name="bom_gst[]" value="<?= $item['bom_gst'] ?>" placeholder="Required gst" style="font-size: 12px;width:100%" readonly="">
                                </td>
                                <td>
                                  <input type="text" class="form-control " id="js-required-qty" name="amount[]" value="<?= $item['amount'] ?>" placeholder="Required Qty" style="font-size: 12px;width:100%" readonly="">
                                </td>
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
                        <?php if(count($pending_parts) > 0){?>
                        <p id="invaliderrorid" style="padding: 10px 0px;font-size: 12px;color:#a94442;">
                          Purchase Proforma Invoice Quantity Pending for BOM Sr No ('<?php
                            echo implode(",", $pending_parts);
                           ?>')
                           is pending
                        </p>
                        <?php } ?>
                      </div>

                    </div>

                    <div class="form-actions">
                      <div class="col-md-12" id="displayTnC">
                        <label class="control-label">Terms and Condition</label>
                        <textarea class="form-control" name="terms_and_condition" placeholder="Terms And Condition" rows="4" id="terms_and_condition"><?php echo $common_data['terms_and_condition'];?></textarea>
                      </div>
                      <div class="col-md-3" id="displayPORemark">
                        <label class="control-label">Remark</label>
                        <input type="text" class="form-control" name="remark" placeholder="Remark" value="<?php echo $common_data['remark'];?>">
                      </div>
                      <div class="col-md-1 hide" id="displayPOAttachment">
                        <div class="form-group">
                          <label class="control-label">Attachment (If Any)</label><br>
                          <input type="file" name="boq_excel_file" id="attachment" class="attachment">
                          <br>
                        </div>
                      </div>

                      <div class="col-md-3" >
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end right" style="position: relative !important;top: 20px !important;left: 230% !important;">
                          <!--<button type="button" class="btn btn-danger cancel clearData" title="Click To Cancel">Cancel</button>-->
                           <a href="create_purchase_order" class="btn btn-danger cancel clearData" title="Click To Cancel">Cancel</a>
                          <button type="submit" class="btn green common_save" title="Click To Save" rel="0">
                            <i class="fa fa-dot-circle-o"></i> Send to Approval
                          </button>
                        </div>
                      </div>
                    </div>

                  </form>
                </div>


              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="portlet light">
                <div class="portlet-title">
                  <div class="caption font-blue">
                    <i class="fa fa-bars font-blue"></i>
                    <span class="caption-subject bold uppercase">Purchase Proforma Invoice</span>
                  </div>
                </div>
                <div class="portlet-body">
                  <table width="100%" id="purchaseOrderlist" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="col" style="vertical-align: top;">Sr.no</th>
                        <th scope="col" style="vertical-align: top;">PO No.</th>
                        <th scope="col" style="vertical-align: top;">PI No.</th>
                        <th scope="col" style="vertical-align: top;">BP Code</th>
                        <th scope="col" style="vertical-align: top;">Vendor Name</th>
                        <th scope="col" style="vertical-align: top;">PI Amount</th>
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

    <script src="<?php echo base_url();?>js/vendor-proforma-invoice.js?" type="text/javascript"></script>
    <script type="text/javascript">
    var page_type = 'vendor_proforma_invoice';

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
