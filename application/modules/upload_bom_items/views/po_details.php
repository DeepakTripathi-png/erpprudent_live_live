<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title> Purchase Order Details | <?php echo project_name; ?> </title>
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
  .alert-container{
    position: fixed;
    z-index: 9;
    width: 100%;
  }
  .alert-container .alert{
    width: 84%;
    /* margin: 0 auto; */
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
    <div class="portlet-body">         
    <div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-blue">
                    <i class="fa fa-plus-circle font-blue"></i>
                    <span class="caption-subject bold uppercase">Purchase Order Details (<?php echo $project_data->bp_code?>)</span>
                </div>
            </div>

            <div class="row">
            <div class="col-md-3">
                   BP Code : <span><b><?php echo $project_data->bp_code?></b></span>
                </div>
                <div class="col-md-3">
                   Po Number : <span><b><?php echo $po_details[0]->po_number?></b></span>
                </div>
                <div class="col-md-3">
                    Po Date : <span><b><?php echo $po_details[0]->created_on?></b></span>
                </div>
                <div class="col-md-3">
                 Category  : <span><b><?php echo $category_data->category_name?></b></span>
                </div>
               
            </div>
            <hr>
            <div class="row mt-2">
            <div class="col-md-3">
                Vendor Name  : <span><b><?php echo $vendor_data->name_of_company?></b></span>
                </div>
                <div class="col-md-3">
                GST Number: <span><b><?php echo $vendor_data->gst_registration_no?></b></span>
                </div>
                <div class="col-md-6">
                Vendor Address  : <span><b><?php echo $vendor_data->reg_house_building_no.", ". $vendor_data->reg_street .", ". $vendor_data->reg_state.", ". $vendor_data->reg_country?></b></span>
                </div>
                <!-- <div class="col-md-2">
                Total VDC Created  : <span><b>3</b></span>
                </div>   -->
            </div>
            <hr>
            <div class="row mt-2">
            <div class="col-md-6">
                <span><b>Terms and condition  : </b></span><br>
                <?php echo $po_details[0]->terms_and_condition?>
                </div>
            <!--<div class="col-md-3">-->
                
            <!--    PO Amount  : <span><b><?php echo $total_po_amount;?></b></span>-->
            <!--    </div>-->
            <!--    <div class="col-md-3">-->
            <!--    Advance Amount  : <span><b>-->
            <!--      <?php echo $total_advance_amount;?>-->
                  
            <!--    </b></span>-->
            <!--    </div>-->
               
            </div>
            <hr>
            <div id="editDisplayPOItems" style="width: 100%;overflow-x: auto;">
                <table width="100%" id="po_items" class="table table-striped table-bordered table-hover" style="margin-top:15px;">
                  <thead>
                    <tr>
                      <th style="min-width: 50px;width:50px;">Sr. No.</th>
                      <th style="min-width: 50px;width:50px;">BOM Code.</th>
                      <th style="min-width: 100px;width:100px;">Item Description</th>
                      <!--<th style="min-width: 80px;width:80px;">Origin Purchase Order QTY</th>-->
                      <th style="min-width: 80px;width:80px;">Purchase Order QTY</th>
                      <th style="min-width: 80px;width:80px;">Delivery Challan QTY</th>
                      <th style="min-width: 80px;width:80px;">Fore Close QTY</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
$counter = 1;
foreach ($po_item_details as $po) { ?>
    <tr>
        <td><?= $counter++; ?></td>
        <td><?= $po['bom_code']; ?></td>
        <td><?= $po['item_description']; ?></td>
        <!--<td><?= $po['original_po']; ?></td>-->
        <td><?= $po['po_qty']; ?></td>
        <td><?= $po['dc_qty']; ?></td>
        <td><?= $po['fc_qty']; ?></td>
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



<script>
jQuery(document).ready(function() {
  Metronic.init(); // init metronic core components
  Layout.init();
  ComponentsPickers.init();
  $('#po_items').DataTable({
        // Optional configurations for customizing the table
        "paging": true,         // Enable pagination
        "searching": true,      // Enable search functionality
        "ordering": true,       // Enable column ordering
        "info": true,           // Show table info (showing entries)
        "autoWidth": false,     // Disable auto width adjustment
        "pageLength": 10,       // Default number of rows per page
        "lengthMenu": [5, 10, 25, 50],  // Dropdown options for pagination size
        "columnDefs": [
            { "orderable": false, "targets": 0 }  // Disable ordering on Sr. No. column
        ]
    });
});
</script>
</body>
</html>
