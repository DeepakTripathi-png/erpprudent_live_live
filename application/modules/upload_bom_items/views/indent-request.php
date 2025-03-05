<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title> Indent Request | <?php echo project_name; ?> </title>
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
                                        <span class="caption-subject bold uppercase"> Indent Request</span>
                                    </div>
                                </div>
                                <?php if (isset($bom_items_data) && !empty($bom_items_data)) { ?>
                                    <div class="portlet-body form">
                                            <form action="save_edit_indent_item" enctype="multipart/form-data" id="save_edit_indent_item" method="post" class="horizontal-form">
                                                <!-- <input type="hidden" name="bom_boq_sr_no" id="bom_boq_sr_no" value="<?php echo (isset($boq_code) && !empty($boq_code)) ? $boq_code : '0' ?>"> -->
                                                <input type="hidden" id="project_id" name="project_id" value="<?php echo (isset($project_id) && !empty($project_id)) ? $project_id : '0' ?>">
                                                <input type="hidden" id="transaction_id" name="transaction_id" value="<?php echo(isset($bom_items_data[0]->transaction_id) && !empty($bom_items_data[0]->transaction_id)) ? $bom_items_data[0]->transaction_id:'0'?>">
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

                                                    <div id="displayIndentBOMItems" style="margin-top:15px;">

                                                        <table width="100%" id="bomitmIndentdisplay" class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th style="min-width: 80px;width:80px;">Sr.No.</th>
                                                                    <th style="min-width: 80px;width:80px;">BOM Sr.No.</th>
                                                                    <th style="min-width: 200px;width:200px;">Item Description</th>
                                                                    <th style="min-width: 40px;width:40px;">Unit</th>
                                                                    <th style="min-width: 40px;width:40px;">Make</th>
                                                                    <th style="min-width: 40px;width:40px;">Model</th>
                                                                    <th style="min-width: 40px;width:40px;">Available Qty</th>
                                                                    <th style="min-width: 40px;width:40px;">Required Qty</th>
                                                                    <!-- <th style="min-width: 10px;width:10px;">-</th> -->
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if (isset($bom_items_data) && !empty($bom_items_data)) {
                                                                    $i = 1;
                                                                    foreach ($bom_items_data as $key) { ?>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="text" class="form-control invaliderror" id="sr_no<?php echo $i; ?>" name="sr_no[]" value="<?php echo (isset($i) && !empty($i)) ? $i : '-' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control invaliderror" id="boq_code<?php echo $i; ?>" name="boq_code[]" value="<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '-' ?>">
                                                                                <input type="text" class="form-control invaliderror" id="bom_code<?php echo $i; ?>" name="bom_code[]" value="<?php echo (isset($key->bom_code) && !empty($key->bom_code)) ? $key->bom_code : '-' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>

                                                                            <td>
                                                                                <input type="text" class="form-control invaliderror" id="bom_item_description<?php echo $i; ?>" name="bom_item_description[]" value="<?php echo (isset($key->item_description) && !empty($key->item_description)) ? $key->item_description : '' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>

                                                                            <td>
                                                                                <input type="text" class="form-control invaliderror" id="bom_unit<?php echo $i; ?>" name="bom_unit[]" value="<?php echo (isset($key->unit) && !empty($key->unit)) ? $key->unit : '0' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>

                                                                            <td>
                                                                                <input type="text" class="form-control invaliderror" id="bom_item_make<?php echo $i; ?>" name="bom_item_make[]" value="<?php echo (isset($key->make) && !empty($key->make)) ? $key->make : '' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>

                                                                            <td>
                                                                                <input type="text" class="form-control invaliderror" id="bom_item_model<?php echo $i; ?>" name="bom_item_model[]" value="<?php echo (isset($key->model) && !empty($key->model)) ? $key->model : '' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>

                                                                            <td>
                                                                                <input type="text" class="form-control invaliderror" id="bom_avl_qty<?php echo $i; ?>" name="bom_avl_qty[]" value="<?php echo (isset($key->indent_quantity) && !empty($key->indent_quantity)) ? $key->indent_quantity : '0' ?>" style="font-size: 12px;" readonly="">
                                                                            </td>

                                                                            <td>
                                                                                <input type="text" class="form-control invaliderror" id="bom_req_stock<?php echo $i; ?>" name="bom_req_stock[]" value="<?php echo (isset($key->indent_quantity) && !empty($key->indent_quantity)) ? $key->indent_quantity : '0' ?>" style="font-size: 12px;">
                                                                            </td>

                                                                           
                                                                            <!-- <td>
                                                                                <div class="addDeleteButton"><span class="tooltips deleteParticularRow tr<?php echo $i; ?>" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span></div>
                                                                            </td> -->
                                                                        </tr>

                                                                <?php $i++;
                                                                    }
                                                                } ?>
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
                                    <form action="save_indent_request" enctype="multipart/form-data" id="save_indent_request"  method="post" class="horizontal-form">
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

                                            <div id="displayBomIndentItems" style="display:none;">
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
                                                            <th style="min-width: 80px;width:80px;">Required Qty</th>
                                                            <th style="min-width: 10px;width:10px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <p id="invaliderrorid" style="padding: 10px 0px;font-size: 12px;color:#a94442;"></p>
                                            </div>

                                        </div>
                                            <div class="form-actions right">

                                                <div class="col-md-5" id="bomIndentRemark" style="display:none;">
                                                    <input type="text" class="form-control" name="remark" placeholder="Remark" value="">
            									</div>
                                               
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
                                        <span class="caption-subject bold uppercase">Indent BOM Item List</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                      <table width="100%" id="pbomindentlist" class="table table-striped table-bordered table-hover">
            							<thead>
            								<tr>
                                                <th scope="col" style="vertical-align: top;">Sr.no</th>
                                                <th scope="col" style="vertical-align: top;">Events</th>
                                                <th scope="col" style="vertical-align: top;">BP Code</th>
                                                <th scope="col" style="vertical-align: top;">Amount</th>
                                                <th scope="col" style="vertical-align: top;">CreatedBy</th>
                                                <th scope="col" style="vertical-align: top;">ApprovedBy</th>
                                                <th scope="col" style="vertical-align: top;">Status</th>
                                                <th scope="col" style="vertical-align: top;">CreatedOn</th>
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
    <script src="<?php echo base_url();?>js/indent-request.js?<?php echo date('Ymd H:i:s'); ?>" type="text/javascript"></script>
    <script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); 
        ComponentsPickers.init();
    });
    </script>
</body>
</html>