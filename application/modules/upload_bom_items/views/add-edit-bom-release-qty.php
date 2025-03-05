<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title> Release Quantity | <?php echo project_name; ?> </title>
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
                                        <span class="caption-subject bold uppercase"> Release Quantity </span>
                                    </div>
                                </div>
                                <?php if (isset($bom_items_data) && !empty($bom_items_data)) { ?>
                                    <div class="portlet-body form">
                                            <form action="save_bom_release_qty_edit_item" enctype="multipart/form-data" id="save_bom_release_qty_edit_item" method="post" class="horizontal-form">
                                                <input type="hidden" name="bom_boq_sr_no" id="bom_boq_sr_no" value="<?php echo (isset($boq_code) && !empty($boq_code)) ? $boq_code : '0' ?>">
                                                <input type="hidden" id="project_id" name="project_id" value="<?php echo (isset($project_id) && !empty($project_id)) ? $project_id : '0' ?>">
                                                <input type="hidden" id="transaction_id" name="transaction_id" value="<?php echo(isset($transaction_id) && !empty($transaction_id)) ? $transaction_id:'0'?>">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Select Project <span class="required" aria-required="true" style="color:red">*</span></label>
                                                                <input type="text" class="form-control" readonly value="<?php echo (isset($project_data->bp_code) && !empty($project_data->bp_code)) ? $project_data->bp_code . ' (' . $project_data->customer_name . ')' : '0' ?>" name="project_name" placeholder="Select Project Code" required>
                                                                <span id="projlaoding"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="displayBOMItems" style="margin-top:15px;">

                                                        <table class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th style="min-width: 80px;width:80px;">Sr.no</th>
                                                                    <th style="min-width: 40px;width:40px;">BOQ <br>Sr No</th>
                                                                    <th style="min-width: 200px;width:200px;">Item Description</th>
                                                                    <th style="min-width: 40px;width:40px;">Unit</th>
                                                                    <th style="min-width: 40px;width:40px;">Sch <br> Qty</th>
                                                                    <th style="min-width: 40px;width:40px;">Variation <br> Rate</th>
                                                                    <th style="min-width: 40px;width:40px;">Avl. Release <br> Qty</th>
                                                                    <th style="min-width: 40px;width:40px;">Release <br> Qty</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderror" id="sr_no" name="sr_no" value="1" style="font-size: 12px;" readonly="">
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" class="form-control invaliderror js-boq_sr_no" id="boq_sr_no" name="boq_sr_no" value="<?php echo (isset($boq_items_data->boq_code) && !empty($boq_items_data->boq_code)) ? $boq_items_data->boq_code : '-' ?>" style="font-size: 12px;" readonly="">
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" class="form-control invaliderror" id="boq_item_description" name="boq_item_description" value="<?php echo (isset($boq_items_data->item_description) && !empty($boq_items_data->item_description)) ? $boq_items_data->item_description : '-' ?>" style="font-size: 12px;" readonly="">
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" class="form-control invaliderror" id="boq_unit" name="boq_unit" value="<?php echo (isset($boq_items_data->unit) && !empty($boq_items_data->unit)) ? $boq_items_data->unit : '-' ?>" style="font-size: 12px;" readonly="">
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" class="form-control invaliderror" id="boq_sch_qty" name="boq_sch_qty" value="<?php echo (isset($scheduled_qty) && !empty($scheduled_qty)) ? $scheduled_qty : '-' ?>" style="font-size: 12px;" readonly="">
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" class="form-control invaliderror" id="boq_var_qty" name="boq_var_qty" value="<?php echo (isset($var_qty) && !empty($var_qty)) ? '+'.$var_qty : '-' ?>" style="font-size: 12px;" readonly="">
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" class="form-control invaliderror" id="boq_avl_qty" name="boq_avl_qty" value="<?php echo (isset($avl_release_qty) && !empty($avl_release_qty)) ?  '+'.$avl_release_qty : '-' ?>" style="font-size: 12px;" readonly="">
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" class="form-control invaliderror js-release_qty-b" id="boq_rel_qty" name="boq_rel_qty" value="<?php echo (isset($released_pending) && !empty($released_pending)) ? $released_pending : '-' ?>" style="font-size: 12px;">
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="8">
                                                                    <table width="100%" id="bomitmdisplay" class="table table-striped table-bordered table-hover">
                                                            <thead style="background:#26a69a;color:#fff;font-weight:400;">
                                                                <tr>
                                                                    <th style="min-width: 80px;width:80px;">BOM Sr.No.</th>
                                                                    <th style="min-width: 40px;width:40px;">HSN Code</th>
                                                                    <th style="min-width: 200px;width:200px;">BOM Item Description</th>
                                                                    <th style="min-width: 40px;width:40px;">Make</th>
                                                                    <th style="min-width: 40px;width:40px;">Model</th>
                                                                    <th style="min-width: 40px;width:40px;">Unit</th>
                                                                    <th style="min-width: 40px;width:40px;">Release Quantity</th>
                                                                    <th style="min-width: 40px;width:40px;">Basic Rate</th>
                                                                    <th style="min-width: 40px;width:40px;">GST (%)</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <?php if (isset($bom_items_data) && !empty($bom_items_data)) {
                                                                    $i = 0;
                                                                    
                                                                    foreach ($bom_items_data as $key) { ?>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="text" class="form-control invaliderror" id="bom_code<?php echo $i; ?>" name="bom_code[]" value="<?php echo (isset($key->bom_code) && !empty($key->bom_code)) ? $key->bom_code : '-' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>

                                                                            <td>
                                                                                <input type="text" class="form-control invaliderror" id="bom_hsn_sac_code<?php echo $i; ?>" name="bom_hsn_sac_code[]" value="<?php echo (isset($key->hsn_sac_code) && !empty($key->hsn_sac_code)) ? $key->hsn_sac_code : '-' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>

                                                                            <td>
                                                                                <input type="text" class="form-control invaliderror" id="bom_item_description<?php echo $i; ?>" name="bom_item_description[]" value="<?php echo (isset($key->item_description) && !empty($key->item_description)) ? $key->item_description : '' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>

                                                                            <td>
                                                                                <input type="text" class="form-control invaliderror" id="bom_item_make<?php echo $i; ?>" name="bom_item_make[]" value="<?php echo (isset($key->make) && !empty($key->make)) ? $key->make : '' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>

                                                                            <td>
                                                                                <input type="text" class="form-control invaliderror" id="bom_item_model<?php echo $i; ?>" name="bom_item_model[]" value="<?php echo (isset($key->model) && !empty($key->model)) ? $key->model : '' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>

                                                                            <td>
                                                                                <input type="text" class="form-control invaliderror" id="bom_unit<?php echo $i; ?>" name="bom_unit[]" value="<?php echo (isset($key->unit) && !empty($key->unit)) ? $key->unit : '0' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>

                                                                            <td>
                                                                                <input type="hidden" class="form-control invaliderror bom_ratio" name="bom_ratio[]" id="bom_ratio<?php echo $i; ?>"  value="<?php echo (isset($key->bom_ratio) && !empty($key->bom_ratio)) ? $key->bom_ratio : '0' ?>" >
                                                                                <input type="text" class="form-control invaliderror bom_release_avl_qty " id="bom_released_qty<?php echo $i; ?>" name="bom_released_qty[]" value="<?php echo (isset($key->released_quantity) && !empty($key->released_quantity)) ? $key->released_quantity : '0' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>

                                                                            <td>
                                                                                <input type="text" class="form-control invaliderror" id="bom_rate_basic<?php echo $i; ?>" name="bom_rate_basic[]" value="<?php echo (isset($key->rate_basic) && !empty($key->rate_basic)) ? $key->rate_basic : '0' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>

                                                                            <td>
                                                                                <input type="text" class="form-control invaliderror" id="bom_gst<?php echo $i; ?>" name="bom_gst[]" value="<?php echo (isset($key->gst) && !empty($key->gst)) ? $key->gst : '0' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>
                                                                          
                                                                        </tr>

                                                                <?php $i++;
                                                                    }
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                                    </td>

                                                                </tr>
                                                            </tbody>

                                                        </table>

                                                       

                                                        <p id="invaliderrorid" style="padding:0px;font-size: 12px;color:#a94442;"></p>
                                                        <p id="invaliderrorexceptdiv" style="padding:0px;font-size: 12px;color:#a94442;"></p>
                                                    </div>

                                                </div>

                                                <div class="form-actions right">
                                                    <button type="button" class="btn btn-danger cancel" onclick="location.href = '<?php echo base_url(); ?>add-bom-items';" title="click To Cancel"> Cancel</button>
                                                    <button type="submit" class="btn green common_save" title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> Send to Approval</button>
                                                </div>

                                            </form>
                                        </div>
                                
                                <?php } else { ?>
                                    <div class="portlet-body form">
                                    <form action="save_bom_item_details" enctype="multipart/form-data" id="save_bom_item_details"  method="post" class="horizontal-form">
                                        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-5">
            										<div class="form-group">
            											<label class="control-label">Select Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            											<input type="text" class="form-control allprojects" id="project_id" name="project_id" placeholder="Select Project Code" required>
            											<span id="projlaoding"></span>
            									    </div>
            									</div>
            								</div>

                                            <div id="displayBoqItems" style="display:none;">
                                                <table width="100%" id="boqitmdisplay" class="table table-striped table-bordered table-hover" style="margin-top:15px;">
                                                    <thead>
                                                        <tr>
                                                            <th style="min-width: 50px;width:50px;">BOQ Sr No</th>
                                                            <!-- <th style="min-width: 50px;width:50px;">HSN/SAC Code</th> -->
                                                            <th style="min-width: 100px;width:100px;">Item Description</th>
                                                            <th style="min-width: 80px;width:80px;">Unit</th>
                                                            <th style="min-width: 50px;width:50px;">Sche. Qty</th>
                                                            <th style="min-width: 50px;width:50px;">Dsgn. Qty</th>
                                                            <th style="min-width: 50px;width:50px;">Build Qty</th>
                                                            <th style="min-width: 100px;width:100px;">Rate Basic</th>
                                                            <th style="min-width: 50px;width:50px;">GST %</th>
                                                            <th style="min-width: 50px;width:50px;">Amount</th>
                                                            <th style="min-width: 50px;width:50px;">Non-Sche</th>
                                                            <th style="min-width: 10px;width:10px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <p id="invaliderrorid" style="padding: 10px 0px;font-size: 12px;color:#a94442;"></p>
                                            </div>

                                        </div>
                                            <div class="form-actions right">
                                                <button type="button" class="btn btn-danger cancel clearData" title="click To Cancel"> Cancel</button>                          
                                                <button type="submit" class="btn green common_save" title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i>  Send to Approval</button>
                                            </div>
                                        </form>
                                    </div>
                                <?php }  ?>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption font-blue">
                                        <i class="fa fa-bars font-blue"></i>
                                        <span class="caption-subject bold uppercase">BOM Release Quantity Item List</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                      <table width="100%" id="pbomreleaselist" class="table table-striped table-bordered table-hover">
            							<thead>
            								<tr>
                                                <th scope="col" style="vertical-align: top;">Sr.no</th>
                                                <th scope="col" style="vertical-align: top;">BOQ<br>Sr No</th>
                                                <th scope="col" style="vertical-align: top;">BP Code</th>
                                                <th scope="col" style="vertical-align: top;">HSN Code</th>
                                                <th scope="col" style="vertical-align: top;">BOQ Item Description</th>
                                                <th scope="col" style="vertical-align: top;">Unit</th>
                                                <th scope="col" style="vertical-align: top;">Pending <br>Release Qty</th>
                                                <th scope="col" style="vertical-align: top;">Approved <br>Release Qty</th>
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
    <script src="<?php echo base_url();?>js/add-edit-release.js?<?php echo date('Ymd H:i:s'); ?>" type="text/javascript"></script>
    <script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); 
        ComponentsPickers.init();
    });
    </script>
</body>
</html>