<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title> Purchase Order | <?php echo project_name; ?> </title>
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
                  <div class="caption font-blue">
                    <i class="fa fa-plus-circle font-blue"></i>
                    <span class="caption-subject bold uppercase">Purchase Order</span>
                  </div>
                </div>
                <div class="edit_po_form portlet-body form " style="display:none;">
                  <form action="edit_save_po_request" enctype="multipart/form-data" id="edit_save_po_request"  method="post" class="horizontal-form">
                    <input type="hidden" name="base_url" id="edit_base_url" value="<?php echo base_url();?>">
                    <input type="hidden" name="transaction_id" id="transaction_id_edit" value="">

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

                      <div id="editDisplayPOItems" style="width: 100%;overflow-x: auto;">
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
                        <div class="col-md-4 form-group " id="displayPOAdvanceAmount">
                        <label class="control-label">Advance Amount (%) <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <input type="text" class="form-control onlyNumericInput" name="advance_amount" id="edit_advance_amount" placeholder="Advance amount" required>
                      </div>
                      <div class="col-md-3" id="displayPORemark">
                        <label class="control-label">Remark</label>
                        <input type="text" class="form-control" name="remark" placeholder="Remark" value="">
                      </div>
                      

                      <div class="col-md-3" >
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end right" style="position: relative !important;top: 23px;">
                          <button type="button" class="btn btn-danger cancel clearData" title="Click To Cancel">Cancel</button>
                          <button type="submit" class="btn green common_save" title="Click To Save" rel="0">
                            <i class="fa fa-dot-circle-o"></i> Send to Approval
                          </button>
                        </div>
                      </div>
                    </div>

                  </form>
                </div>

                <div class="portlet-body form add_po_form">
                  <form action="save_po_request" enctype="multipart/form-data" id="save_po_request"  method="post" class="horizontal-form">
                    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                    <input type="hidden" name="terms_and_condition_val" id="terms_and_condition_val" value="">
                    <div class="form-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label">Select Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                            <input type="text" class="form-control allprojects" id="project_id" name="project_id" placeholder="Select Project Code" required>
                            <span id="projlaoding"></span>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label">Select Vendor Category <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                            <input type="text" class="form-control allVendorCategory" id="category" name="vendor_category_id" placeholder="Select Vendor category" required>
                            <span id="vCategoryLaoding"></span>
                          </div>

                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label">Select Vendor Name <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                            <input type="text" class="form-control allVendor" id="vendor_id" name="vendor_id" placeholder="Select Vendor " required>
                            <span id="vendorLaoding"></span>
                          </div>
                        </div>
                        <div class="col-md-4 vendor-details">
                          <div class="form-group">
                            <label class="control-label">Address </label>
                            <input type="text" class="form-control " id="address" name="address"  readonly>
                          </div>
                        </div>
                        <div class="col-md-4 vendor-details">
                          <div class="form-group">
                            <label class="control-label">GST No </label>
                            <input type="text" class="form-control " id="gst_number" name="gst_number" readonly>
                          </div>
                        </div>
                        <div class="col-md-4 vendor-details">
                          <div class="form-group">
                            <label class="control-label">PO Number </label>
                            <input type="text" class="form-control " id="po_number" name="po_number" readonly>
                          </div>
                        </div>

                      </div>

                      <div id="displayPOItems" style="display:none;width: 100%;overflow-x: auto;">
                        <table width="100%" id="bomindentitmdisplay" class="table table-striped table-bordered table-hover" style="margin-top:15px;">
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
                              <th style="min-width: 10px;width:10px;">Action</th>
                            </tr>
                          </thead>
                        </table>
                        <p id="invaliderrorid" style="padding: 10px 0px;font-size: 12px;color:#a94442;"></p>
                      </div>

                    </div>

                    <div class="form-actions">
                        <div class="col-md-12" id="displayTnC">
                        <label class="control-label">Terms and Condition</label>
                        <textarea class="form-control" name="terms_and_condition" placeholder="Terms And Condition" rows="7" id="terms_and_condition">
1. Price Ex. Mumbai
2. Payment Terms: 30 Days from dispatch of material
3. Delivery Immediate
4. Product Warranties: - 1 year
5. Test Certifiate to be provided along with mateiral
6. Supply/Service done without PO will be on vendor Rissk,
7. Invoice & Payment Related Email shall be mark to - projects@prudentepc.com
                        </textarea>
                        <br>
                      </div>
                      <div class="col-md-4 form-group mt-2" id="displayPOAdvanceAmount">
                        <label class="control-label">Advance Amount (%) <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <input type="text" class="form-control onlyNumericInput" name="advance_amount" placeholder="Advance amount" required>
                      </div>
                      <div class="col-md-3" id="displayPORemark">
                        <label class="control-label">Remark</label>
                        <input type="text" class="form-control" name="remark" placeholder="Remark" value="">
                      </div>
                      
                      
                      <div class="col-md-3" >
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end right" style="position: relative !important;top: 23px;">
                          <button type="button" class="btn btn-danger cancel clearData" title="Click To Cancel">Cancel</button>
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
                    <span class="caption-subject bold uppercase">Purchase Order</span>
                  </div>
                </div>
                <div class="portlet-body">
                  <table width="100%" id="purchaseOrderlist" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="col" style="vertical-align: top;">Sr.no</th>
                        <th scope="col" style="vertical-align: top;">PO No.</th>
                        <th scope="col" style="vertical-align: top;">BP Code</th>
                        <th scope="col" style="vertical-align: top;">Vendor Name</th>
                        <th scope="col" style="vertical-align: top;">PO Amount</th>
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

    <script src="<?php echo base_url();?>js/purchase-order.js?" type="text/javascript"></script>
    <script type="text/javascript">
    var page_type = 'create_pruchase_order';

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
