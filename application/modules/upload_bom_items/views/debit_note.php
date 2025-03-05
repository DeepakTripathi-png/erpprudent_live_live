<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title><?php echo $title ?> | <?php echo project_name; ?> </title>
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
  <script src="https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js"></script>
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
  .border-bottom{
    border-bottom: 1px solid #dddddd;
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
                    <i class="fa fa-bars font-blue"></i>
                    <span class="caption-subject bold uppercase">
                      <?php echo (isset($bp_code) && !empty($bp_code)) ? '(#' . $bp_code . ')' : '' ?> <?php echo $title; ?></span>
                    </div>
                  </div>
                  <div class="portlet-body">
                    <input type="hidden" name="project_id" id="project_id_data" value="<?php echo $project_id; ?>">
                    <input type="hidden" name="po_number" id="po_number_val" value="<?php echo $po_number; ?>">
                    <input type="hidden" name="type" id="type_val" value="<?php echo $type; ?>">
                    <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

                    <div class="row mb-5" id="project_dropdown">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label">Select Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                          <input type="text" class="form-control allprojects" id="project_id" name="project_id" placeholder="Select Project Code" required>
                          <span id="projlaoding"></span>
                        </div>
                      </div>

                    </div>

                    <table width="100%" id="return_memo_list" class="table table-striped table-bordered table-hover ">
                      <thead>
                        <tr>
                          <th scope="col" style="vertical-align: top;">Sr.no</th>
                          <th scope="col" style="vertical-align: top;">BP Code</th>
                          <th scope="col" style="vertical-align: top;">PO Number</th>
                          <th scope="col" style="vertical-align: top;">DC Number</th>
                          <th scope="col" style="vertical-align: top;">Total Amount</th>
                          <th scope="col" style="vertical-align: top;">Advance Amount</th>
                          <th scope="col" style="vertical-align: top;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // pr($data);
                        if (count($data) > 0) {

                          foreach ($data as $key => $value) {  ?>
                            <td><?php echo $key + 1 ?></td>
                            <td><?php echo !empty($value['bp_code']) ? $value['bp_code'] : '-' ?></td>
                            <td><?php echo !empty($value['po_number']) ? $value['po_number'] : '-' ?></td>
                            <td><?php echo !empty($value['vdc_number']) ? $value['vdc_number'] : '-' ?></td>
                            <td><?php echo !empty($value['total_amount']) ? number_format($value['total_amount'],2,".","") : '0.00' ?></td>
                            <td><?php echo !empty($value['advance_payment']) ? number_format($value['advance_payment'],2,".","") : '0.00' ?></td>

                            <td>

                              <a href="javascript:void(0);"
                              title="Download Debit Note"
                              data-project-id="<?php echo $value['project_id']; ?>"
                              data-vdc-id="<?php echo $value['vdc_id']; ?>"
                              class="download-debit-note"
                              style="margin-right: 8px;">
                              <i class="fa fa-download" style="color:#000; font-size:15px;"></i>
                            </a>

                            <a class="Invoice"
                            href="generate_debit_note_pdf?vdc_id=<?php echo $value['vdc_id']; ?>&project_id=<?php echo $value['project_id']; ?>"
                            data-project_id="<?php echo base64_encode($value['project_id']); ?>"
                            style="margin-right: 8px;">
                            <i class="fa fa-file-text" style="color:#000; font-size:15px;"></i>
                          </a>


                          <a class=" openview" href="javascript:void(0);" data-project_id="<?php echo base64_encode($value['project_id']); ?>" data-boq_code="" data-type="<?php echo $type; ?>" data-status="" data-id="<?php echo $value['vdc_number']; ?>" style="margin-right: 8px;">VIEW</a>

                        </td>
                        

                      </tr>
                    <?php }
                  }else{?>
                    <!--<tr class="text-center" colspan="13"> No data Found </tr>-->
                  <?php	}
                  ?>
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
<script src="<?php echo base_url();?>js/debit_note.js" type="text/javascript"></script>

<script>
jQuery(document).ready(function() {
  Metronic.init(); // init metronic core components
  Layout.init();
  ComponentsPickers.init();
});
</script>

</body>
</html>
