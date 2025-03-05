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
                    <span class="caption-subject bold uppercase"><?php echo (isset($bp_code) && !empty($bp_code)) ? '(#' . $bp_code . ')' : '' ?> Payment Receipt</span>
                  </div>
                </div>
                <div class="portlet-body">
                  <input type="hidden" name="project_id" id="project_id" value="">
                  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

                  <table width="100%" id="payment_receipt_list" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="col" style="vertical-align: top;">Sr.no</th>
                        <th scope="col" style="vertical-align: top;">PO No.</th>
                        <th scope="col" style="vertical-align: top;">PI No.</th>
                        <th scope="col" style="vertical-align: top;">BP Code</th>
                        <th scope="col" style="vertical-align: top;">Vendor Name</th>
                        <th scope="col" style="vertical-align: top;">PPI Amount</th>
                        <th scope="col" style="vertical-align: top;">PR Amount</th>
                        <th scope="col" style="vertical-align: top;">CreatedBy</th>
                        <th scope="col" style="vertical-align: top;">ApprovedBy</th>
                        <th scope="col" style="vertical-align: top;">Status</th>
                        <th scope="col" style="vertical-align: top;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // pr($payment_receipt_data,1);
                      foreach ($payment_receipt_data as $key => $value) {  ?>
                        <tr>
                          <th><?php echo $key + 1 ?></th>
                          <td><?php echo !empty($value['po_number']) ? $value['po_number'] : '-' ?></td>
                          <td><?php echo !empty($value['invoice_number']) ? $value['invoice_number'] : '-' ?></td>
                          <td><?php echo !empty($value['project_name']) ? $value['project_name'] : '-' ?></td>
                          <td><?php echo !empty($value['vendor_name']) ? $value['vendor_name'] : '-' ?></td>
                          <td><?php echo !empty($value['invoice_amount']) ? $value['invoice_amount'] : '-' ?></td>
                          <td><?php echo !empty($value['payment_amount']) ? $value['payment_amount'] : '-' ?></td>
                          <td><?php echo !empty($value['created_by']) ? $value['created_by'] : '-' ?></td>
                          <td><?php echo !empty($value['approved_by']) ? $value['approved_by'] : '-' ?></td>
                          <td>
                            <?php
                            if (!empty($value['status'])) {
                              if ($value['status'] == 'approved') {
                                echo '<span style="color:green;font-weight:600;">Approved</span>';
                              } elseif ($value['status'] == 'pending') {
                                echo '<span style="color:orange;font-weight:600;">Pending</span>';
                              } elseif ($value['status'] == 'reject') {
                                echo '<span style="color:red;font-weight:600;">Rejected</span>
                                <a href="'.base_url().'payment_receipt?ppi='.base64_encode($value['ppi_id']).'&&pr_id='.base64_encode($value['pr_id']).'" class="editRecordPR tooltips" title="Edit Record" data-original-title="Edit Record">
                                <i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i>
                                </a>';
                              }
                            } else {
                              echo '-';
                            }
                            ?>
                          </td>
                          <td><a class="openpaymentview" href="javascript:void(0);"  data-id="<?php echo $value['ppi_id'];  ?>">VIEW</a></td>

                        </tr>
                      <?php } ?>
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
  <!-- <script src="<?php echo base_url(); ?>js/select2pagination.js?<?php echo date('Ymd H:i:s'); ?>"></script> -->

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
  <script src="<?php echo base_url();?>js/payment_receipt_listing.js" type="text/javascript"></script>
  <script type="text/javascript">
  var page_type = 'payment_receipt';
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
