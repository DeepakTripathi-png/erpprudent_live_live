<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Tax Master | <?php echo project_name; ?> </title>
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
    <link href="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/css/components-rounded.css?<?php echo date('Y-m-d H:i:s');?>" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/admin/layout4/css/layout.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>/assets/admin/layout4/css/light.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/site/css/validationEngine.jquery.css" rel="stylesheet">
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
                                        <span class="caption-subject bold uppercase"> Tax Master</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form action="save_tax" enctype="multipart/form-data" id="save_tax"  method="post" class="horizontal-form">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Tax Name <span class="require" aria-required="true" style="color:red">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control duplicate" name="tax_name" id="tax_id" data-tbl="tbl_tax" data-p_key="tax_id" data-where="tax_name" rel="0" value="<?php echo(isset($tax_data->tax_name) && !empty($tax_data->tax_name))?$tax_data->tax_name:''?>" placeholder="Tax name" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Percentage of Tax <span class="require" aria-required="true" style="color:red">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control " name="percentage_tax" value="<?php echo(isset($tax_data->percentage_tax) && !empty($tax_data->percentage_tax))?$tax_data->percentage_tax:''?>" placeholder="Percentage of Tax" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions right">
                                            <a href="<?php echo base_url();?>tax-list" class="btn blue" style="float: left;">Back</a>
                                            <button type="button" class="btn btn-danger cancel clearData" title="click To Cancel"> Cancel</button>                          
                                            <button type="submit" class="btn green common_save" title="click To Save" rel="<?php echo(isset($tax_data->tax_id) && !empty($tax_data->tax_id))?$tax_data->tax_id:''?>"><i class="fa fa-dot-circle-o"></i> <?php if(isset($tax_data->tax_id) && !empty($tax_data->tax_id)) {echo 'Update';} else { echo 'Save'; }?></button>
                                        </div>
                                    </form>
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
    <script src="<?php echo base_url();?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript" ></script>
    <script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js" type="text/javascript" ></script>
    <script src="<?php echo base_url();?>assets/global/plugins/datatables/table-advanced.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/lib/jquery.form.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine.js"></script>
    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine-en.js"></script>
    <script src="<?php echo base_url();?>js/common.js" type="text/javascript"></script>
    <script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); 
        ComponentsPickers.init();
        TableAdvanced.init();
    });
    </script>
</body>
</html>