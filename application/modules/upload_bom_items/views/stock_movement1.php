<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title> Stock Movement | <?php echo project_name; ?> </title>
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
                    <span class="caption-subject bold uppercase">Stock Movement</span>
                  </div>
                </div>
           

                <div class="portlet-body form add_stock_movement_form">
                
                <div class="alert-container hide">
                </div>

                  <form action="javascript:void(0)" enctype="multipart/form-data" id="save_stock_movement_form"  method="post" class="horizontal-form">
                    <div class="form-body">
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                          <label class="control-label">From Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                          <select  class="form-control allProjectDropDown" id="form_project_id" name="form_project_id">
                              <option>Select Project</option>
                          </select>
                       
                          </div>

                          
                        </div>
                         <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label">PO No <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                          <select  class="form-control " id="project_po" name="project_po">
                              <option value="">Select PO No</option>
                          </select>
                        </div>
                      </div>
                       <div class="col-md-3">
                      <div class="form-group">
                          <label class="control-label">VDC NO <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                          <select  class="form-control " id="project_vdc_no" name="project_vdc_no">
                              <option value="">Select VDC NO</option>
                          </select>
                        </div>
                      </div>
                       <div class="col-md-3">
                      <div class="form-group">
                          <label class="control-label">Bom Items <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                          <select  class="form-control " id="project_bom_item" name="project_bom_item">
                              <option value="">Select Bom Items</option>
                          </select>
                        </div>
                      </div>


                    

                      <div id="displayStockMovementItems" style="width: 100%;overflow-x: auto;">
                        <table width="100%" id="stockMovementItems" class="table table-striped table-bordered table-hover" style="    margin-top: 15px;margin-left: 16px;width: 98%;">
                          <thead>
                            <tr>
                              <th style="min-width: 50px;width:50px;">Sr. No.</th>
                              <th style="min-width: 50px;width:50px;">BOM Sr. No.</th>
                              <th style="min-width: 100px;width:100px;">Item Description</th>
                              <th style="min-width: 100px;width:50px;">HSN Code</th>
                              <th style="min-width: 80px;width:80px;">Unit</th>
                              <th style="min-width: 80px;width:80px;">Make</th>
                              <th style="min-width: 80px;width:80px;">Model</th>
                              <th style="min-width: 80px;width:80px;">DC Qty(Good Condition)</th>
                              <th style="min-width: 80px;width:80px;">Qty</th>
                              <th style="min-width: 80px;width:80px;display:none; ">Basic Rate</th>
                              <th style="min-width: 80px;width:80px;display:none;">GST</th>
                              <th style="min-width: 80px;width:80px;display:none;">Amount</th>
                              <th style="min-width: 10px;width:10px;">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                              <tr>
                                <td colspan="13" class="text-center">No Stock data found.</td>
                              </tr>
                          </tbody>
                        </table>
                        <p id="invaliderrorid" style="padding: 10px 0px;font-size: 12px;color:#a94442;" class="hide"></p>
                        <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label">To Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                          <select  class="form-control " id="to_project_id" name="to_project_id">
                              <option>Select Project</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="control-label">BOM Code <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                          <select  class="form-control " id="to_project_bom_code" name="to_project_bom_code">
                              <option value="">Select BOM Code</option>
                          </select>
                        </div>
                      </div>
                       <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label">Bom Code description<span class="required" aria-required="true" style="color:#a94442">*</span></label>
                          <input type="text" class="form-control"  id="bom_code_description" readonly placeholder="Bom Code description">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label class="control-label">Stock Movement Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                          <input type="date" class="form-control" name="stock_date" id="stock_date" readonly>
                        </div>
                      </div>
                      </div>
                    </div>
                      

                    <div class="form-actions"> 
                      <div class="col-md-3" >
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end right" style="position: relative !important;top: 23px;">
                          <button type="button" class="btn btn-danger cancel clearData" title="Click To Cancel">Cancel</button>
                          <button type="submit" class="btn green common_save" title="Click To Save" rel="0">
                            <i class="fa fa-dot-circle-o"></i> Save
                          </button>
                        </div>
                      </div>
                    </div>
                    </div>
                   


                  </form>

                  <form action="javascript:void(0)" enctype="multipart/form-data" id="update_stock_movement_form"  method="post" class="horizontal-form " style="display: none;">
                    <div class="form-body">
                      <div class="row">
                        <div class="col-md-4">
                        <div class="form-group">
                        <label class="control-label">From Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <input type="text" name="from_project" readonly class="form-control" id="update_from_project">
                        <input type="hidden" name="stock_movement_id" readonly class="form-control" id="update_stock_movement_id">
                       
                      </div>
                          
                        </div>

                        <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label">PO No <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                          <input type="text" name="po_number" readonly class="form-control" id="update_po_number">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label">VDC NO <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                          <input type="text" name="vdc_number" readonly class="form-control" id="update_vdc_number">
                        </div>
                      </div>


                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label">To Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                          <input type="text" name="to_project" readonly class="form-control" id="update_to_project">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label">BOM Code <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                          <input type="text" name="bom_Code" readonly class="form-control" id="update_bom_Code">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label">Stock Movement Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                          <input type="text" name="stock_movement_date" readonly class="form-control" id="update_stock_movement_date">
                        </div>
                      </div>

                      </div>

                      <div id="displayStockMovementUpdateItems" style="width: 100%;overflow-x: auto;">
                        <table width="100%" id="stockMovementUpdateItems" class="table table-striped table-bordered table-hover" style="margin-top:15px;">
                          <thead>
                            <tr>
                              <th style="min-width: 50px;width:50px;">Sr. No.</th>
                              <th style="min-width: 50px;width:50px;">BOM Sr. No.</th>
                              <th style="min-width: 100px;width:100px;">Item Description</th>
                              <th style="min-width: 100px;width:50px;">HSN Code</th>
                              <th style="min-width: 80px;width:80px;">Unit</th>
                              <th style="min-width: 80px;width:80px;">Make</th>
                              <th style="min-width: 80px;width:80px;">Model</th>
                              <th style="min-width: 80px;width:80px;">DC Qty(Good Condition)</th>
                              <th style="min-width: 80px;width:80px;">Qty</th>
                              <th style="min-width: 80px;width:80px;display:none; ">Basic Rate</th>
                              <th style="min-width: 80px;width:80px;display:none;">GST</th>
                              <th style="min-width: 80px;width:80px;display:none;">Amount</th>
                              <th style="min-width: 10px;width:10px;">Action</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                        <p id="invaliderrorid" style="padding: 10px 0px;font-size: 12px;color:#a94442;"></p>
                      </div>

                    </div>

                    <div class="form-actions"> 
                      <div class="col-md-3" >
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end right" style="position: relative !important;top: 23px;">
                          <button type="button" class="btn btn-danger cancel clearData" title="Click To Cancel" onclick="location.reload();">Cancel</button>
                          <button type="submit" class="btn green common_save" title="Click To Save" rel="0">
                            <i class="fa fa-dot-circle-o"></i> Save
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
                    <span class="caption-subject bold uppercase">Stock Movement List</span>
                  </div>
                </div>
                <div class="portlet-body">
                  <table width="100%" id="stockMovementlist" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="col" style="vertical-align: top;">Sr.no</th>
                        <th scope="col" style="vertical-align: top;">SM No.</th>
                        <th scope="col" style="vertical-align: top;">To Project</th>
                        <th scope="col" style="vertical-align: top;">Form Project</th>
                        <th scope="col" style="vertical-align: top;">Total Movement QTY</th>
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

    <script src="<?php echo base_url();?>js/stock_movement.js?" type="text/javascript"></script>

  <script>
  jQuery(document).ready(function() {
    Metronic.init(); // init metronic core components
    Layout.init();
    ComponentsPickers.init();
  });
</script>
</body>
</html>
