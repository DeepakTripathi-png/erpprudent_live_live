<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Add Installed WIP | <?php echo project_name; ?> </title>
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
    .statusselect{
        outline: unset;
        cursor: pointer;
        font-size: 13px;
        padding: 3px 5px;
        margin-top: 5px;
    }
    .statusselectoption{
        outline: unset;
        cursor: pointer;
        font-size: 13px;
    }
        .dataTables_filter{
            float:right;
        }
        .has-error-p{
            border: 1px solid #a94442;
        }
        .has-error-d{
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
                    <?php if(isset($check_permission_update) && $check_permission_update == 'Y'){ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption font-blue">
                                        <i class="fa fa-plus-circle font-blue"></i>
                                        <span class="caption-subject bold uppercase"> Add Installed WIP</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form action="<?php echo (isset($iwip_data->i_wip_id) && !empty($iwip_data->i_wip_id)) ? 'update_installed_wip_details' : 'save_installed_wip_details' ?>" enctype="multipart/form-data" id="<?php echo (isset($iwip_data->i_wip_no) && !empty($iwip_data->i_wip_no)) ? 'update_installed_wip_details' : 'save_installed_wip_details' ?>"  method="post" class="horizontal-form">
                                        <input type="hidden" name="wip_type" id="wip_type" value="installed">
                                        <input type="hidden" name="update_i_wip_id" id="update_i_wip_id" value="<?php echo (isset($iwip_data->i_wip_id) && !empty($iwip_data->i_wip_id)) ? $iwip_data->i_wip_id : '0' ?>">
                                        <div class="form-body">
                                            <div class="row">
                                                <?php if(isset($iwip_data->project_id) && !empty($iwip_data->project_id)){ ?>
                                                	<div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="">Select Project <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="hidden" name="project_id" id="project_id" value="<?php echo (isset($iwip_data->project_id) && !empty($iwip_data->project_id)) ? $iwip_data->project_id : '0' ?>">
                                                                <input type="text" class="form-control" name="bp_code" id="bp_code" value="<?php echo (isset($iwip_data->bp_code) && !empty($iwip_data->bp_code)) ? $iwip_data->bp_code : '' ?> <?php echo (isset($iwip_data->customer_name) && !empty($iwip_data->customer_name)) ? ' ('.$iwip_data->customer_name.')' : '' ?>" required="" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                								<?php }else{ ?>
                                                <div class="col-md-5">
            										<div class="form-groupp">
            											<label class="control-label">Select Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
            											<input type="text" class="form-control allprojects" id="project_id" name="project_id" placeholder="Select Project Code" required>
            											<span id="projlaoding"></span>
            									    </div>
            									</div>
            									<?php } ?>
            									<!--<div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="">Installed WIP No <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" name="installed_wip_no" id="installed_wip_no" value="<?php echo (isset($iwip_data->i_wip_no) && !empty($iwip_data->i_wip_no)) ? $iwip_data->i_wip_no : '' ?>" placeholder="Installed WIP No" required="">
                                                        </div>
                                                    </div>
                                                </div>-->
            								</div>
            								<?php if(isset($iwip_data) && !empty($iwip_data)){ ?>
            								    <?php if(isset($iwip_items_data) && !empty($iwip_items_data)){ ?>
            								        <div id="displayVcIWIPItemExist">
                                                        <table width="100%" id="clientdciwipitemexistdisplay" class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th style="min-width: 50px;width:50px;">BOQ Sr No</th>
                                                                    <th style="min-width: 50px;width:50px;">HSN/SAC Code</th>
                                                                    <th style="min-width: 150px;width:150px;">Item Description</th>
                                                                    <th style="min-width: 80px;width:80px;">Unit</th>
                                                                    <th style="min-width: 50px;width:50px;">Stock Qty</th>
                                                                    <th style="min-width: 50px;width:50px;">Installed Qty</th>
                                                                    <th style="min-width: 10px;width:10px;">-</th>
                                                                </tr>
                                                            </thead>
                                                            <tboady>
                                                                <?php 
                                                                $CI =& get_instance();
                                                                $CI->load->model('admin_model');
                                                                ?>
                                                                <?php $i=0;foreach($iwip_items_data as $key){ $class="odd"; if($i%2==0){ $class="even"; }else{ $class="odd"; }?>
                                                                    <?php 
                                                                    $avl_stock = 0;
                                                                    if(isset($iwip_data->project_id) && !empty($iwip_data->project_id) && isset($key->boq_code) && !empty($key->boq_code)){
                                                                        $avl_stock = $this->common_model->getDCApprovedQty($iwip_data->project_id,$key->boq_code);
                                                                        if(isset($avl_stock) && !empty($avl_stock)){ 
                                                                            $avl_stock = $avl_stock;
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <tr role="row" class="<?php echo $class; ?>">
                                                                        <td>
                                                                            
                                                                            <input type="hidden" name="rate_basic[]" value="<?php echo (isset($key->rate_basic) && !empty($key->rate_basic)) ? $key->rate_basic : '0' ?>">
                                                                            <input type="hidden" name="i_wip_itemid[]" value="<?php echo (isset($key->i_wip_itemid) && !empty($key->i_wip_itemid)) ? $key->i_wip_itemid : '0' ?>">
                                                                            <input type="text" class="form-control update_invaliderror_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="boq_code[]" value="<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" readonly="" style="font-size: 12px;">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="form-control update_invaliderror_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="hsn_sac_code[]" value="<?php echo (isset($key->hsn_sac_code) && !empty($key->hsn_sac_code)) ? $key->hsn_sac_code : '0' ?>" readonly="" style="font-size: 12px;">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="form-control update_invaliderror_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="item_description[]" value="<?php echo (isset($key->item_description) && !empty($key->item_description)) ? $key->item_description : '0' ?>" readonly="" style="font-size: 12px;">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="form-control update_invaliderror_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="unit[]" value="<?php echo (isset($key->unit) && !empty($key->unit)) ? $key->unit : '0' ?>" readonly="" style="font-size: 12px;">
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control update_invaliderror_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="avl_qty[]" value="<?php echo (isset($avl_stock) && !empty($avl_stock)) ? $avl_stock : '0' ?>" readonly="" style="font-size: 12px;">
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control checkinstalledqty check_installed_qty_validation" data-max="<?php echo (isset($key->installed_qty) && !empty($key->installed_qty)) ? $key->installed_qty : '0' ?>" name="installed_qty[]" data-id="<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" data-pid="<?php echo (isset($iwip_data->project_id) && !empty($iwip_data->project_id)) ? $iwip_data->project_id : '0' ?>" value="<?php echo (isset($key->installed_qty) && !empty($key->installed_qty)) ? $key->installed_qty : '0' ?>" <?php echo (isset($key->installed_qty) && !empty($key->installed_qty) && $avl_stock > 0 && $avl_stock >= $key->installed_qty) ? $key->installed_qty : 'readonly' ?> style="font-size: 12px;">
                                                                        </td>
                                                                        <!--<td>-->
                                                                        <!--    <input type="number" class="form-control checkinstalledqty invalid_installed_qty_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?> update_invaliderror_<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" name="installed_qty[]" data-id="<?php echo (isset($key->boq_code) && !empty($key->boq_code)) ? $key->boq_code : '0' ?>" data-pid="<?php echo (isset($iwip_data->project_id) && !empty($iwip_data->project_id)) ? $iwip_data->project_id : '0' ?>" value="<?php echo (isset($key->installed_qty) && !empty($key->installed_qty)) ? $key->installed_qty : '0' ?>" <?php echo (isset($key->installed_qty) && !empty($key->installed_qty) && $avl_stock > 0 && $avl_stock >= $key->installed_qty) ? $key->installed_qty : 'readonly' ?> style="font-size: 12px;">-->
                                                                        <!--</td>-->
                                                                        <td>
                                                                            <div class="addDeleteButton">
                                                                                <span class="tooltips deletedciwipRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;">
                                                                                    <i class="fa fa-trash-o"></i></span>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php $i++;} ?>
                                                                    <tr role="row" class="odd">
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderror" id="wdc_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderror" id="wdc_hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderror" id="wdc_item_description" placeholder="Item Description" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control invaliderror" id="wdc_unit" placeholder="Unit" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" min="1" class="form-control invaliderror" id="wdc_avl_qty" placeholder="Avl. Qty" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" min="1" class="form-control invaliderror" id="wdc_installed_qty" placeholder="Installed Qty" style="font-size: 12px;">
                                                                    </td>
                                                                    <td>
                                                                        <div class="addDeleteButton"><span class="tooltips addDCIWIPRow" data-placement="top" data-original-title="Add" style="cursor: pointer;">
                                                                            <i class="fa fa-plus" style="color:#000"></i></span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tboady>
                                                        </table>
                                                        <p id="invaliderrorid" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>
                                                    </div>
                                                <?php }else{ ?>
                                                    <div id="displayVcIWIPItem" style="display:none;">
                                                    <table width="100%" id="clientdciwipitemdisplay" class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th style="min-width: 50px;width:50px">BOQ Sr No</th>
                                                                <th style="min-width: 50px;width:50px;">HSN/SAC Code</th>
                                                                <th style="min-width: 150px;width:150px;">Item Description</th>
                                                                <th style="min-width: 80px;width:80px;">Unit</th>
                                                                <th style="min-width: 50px;width:50px;">Stock Qty</th>
                                                                <th style="min-width: 50px;width:50px;">Installed Qty</th>
                                                                <th style="min-width: 10px;width:10px;">-</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                    <p id="invaliderrorid" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>
                                                </div>
                                                <?php } ?>
            								<?php }else{ ?>
                                            <div id="displayVcIWIPItem" style="display:none;">
                                                <table width="100%" id="clientdciwipitemdisplay" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="min-width: 50px;width:50px;">BOQ Sr No</th>
                                                            <th style="min-width: 50px;width:50px;">HSN/SAC Code</th>
                                                            <th style="min-width: 150px;width:150px;">Item Description</th>
                                                            <th style="min-width: 80px;width:80px;">Unit</th>
                                                            <th style="min-width: 50px;width:50px;">Stock Qty</th>
                                                            <th style="min-width: 50px;width:50px;">Installed Qty</th>
                                                            <th style="min-width: 10px;width:10px;">-</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <p id="invaliderrorid" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-actions right">
                                            <button type="button" class="btn btn-danger cancel clearData" title="click To Cancel"> Cancel</button>                          
                                            <button type="submit" class="btn green common_save" title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> <?php echo (isset($iwip_data->i_wip_id) && !empty($iwip_data->i_wip_id)) ? 'Update' : 'Save' ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }else{ ?>
                    <input type="hidden" name="project_id" id="project_id" value="0">
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption font-blue">
                                        <i class="fa fa-bars font-blue"></i>
                                        <span class="caption-subject bold uppercase">Installed WIP List</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                      <table width="100%" id="iwiplist" class="table table-striped table-bordered table-hover" style="font-size:12px;">
            							<thead>
            								<tr>
            									<th scope="col">Sr.no</th>
            									<th scope="col">I-WIP No</th>
            									<th scope="col">BP Code</th>
            								    <th scope="col">Cust. Name</th>
            								    <th scope="col">Status</th>
            								    <th scope="col">Created On</th>
            									<th scope="col">Action</th>
            								</tr>
            							</thead>
            							<tbody></tbody> 
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
    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
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
    <script src="<?php echo base_url();?>js/installed.js?<?php echo date('Ymd H:i:s'); ?>" type="text/javascript"></script>
    <script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); 
        ComponentsPickers.init();
       
    });
    });
    </script>
</body>
</html>