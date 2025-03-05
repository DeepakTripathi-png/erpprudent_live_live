<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Upload BOM Items | <?php echo project_name; ?> </title>
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
    <link href="<?php echo base_url();?>assets/global/css/components-rounded.css?<?php echo date('Y-m-d H:i:s'); ?>" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/css/plugins.css?<?php echo date('Y-m-d H:i:s'); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/admin/layout4/css/layout.css?<?php echo date('Y-m-d H:i:s'); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>/assets/admin/layout4/css/light.css?<?php echo date('Y-m-d H:i:s'); ?>" rel="stylesheet" type="text/css"/>
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
        .w150{
            width:150px;
        }
        .w400{
            width:400px;
        }
        .dataTables_filter{
            float:right;
        }

        .has-error .select2-container .select2-choice, .has-error .select2-container .select2-choices {
            border-color: red;
        }

        [type="file"] + label {
            background: #f15d22;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            display: inline-block;
            font-family: 'Poppins', sans-serif;
            font-size: inherit;
            font-weight: 600;
            margin-bottom: 1rem;
            outline: none;
            padding: 5px;
            position: relative;
            transition: all 0.3s;
            vertical-align: middle;
            &:hover {
                background-color: darken(#f15d22, 10%);
            }
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
                         <?php if(isset($check_permission_update) && $check_permission_update == 'Y'){ ?>
                            
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption font-blue">
                                        <i class="fa fa-plus-circle font-blue"></i>
                                        <span class="caption-subject bold uppercase"> Upload BOM Items</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form action="publish_bom_items_bulk_upload" enctype="multipart/form-data" id="publish_bom_items_bulk_upload"  method="post" class="horizontal-form">

                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="agent_id">Select Project <span class="required" aria-required="true" style="color:red">*</span></label>
                                                    <input type="text" class="form-control allprojects" id="project_id" name="project_id" placeholder="Select Project Code" required>
                                                    <span id="projlaoding"></span>
                                                    <div id="bomUploadLimit" style="display: none;margin-top:5px;color:red">(Note:-You can't upload file. If you want to add items then please go in to Add Edit BOM items menu.)</div>
                                                </div>
            								</div>

            								<div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Import BOM Items Excel <span class="require" aria-required="true" style="color:red">*</span></label><br>
                                                        <input type="file" name="bom_excel_file" id="bom_excel_file" class="bom_excel_file">
                                                        <span style="color:#d44;">(Note-Please import only .xls or xlsx Excel File )</span><br>
                                                        <span style="font-size: 14px; text-decoration: underline;"> <a href="<?php echo base_url();?>uploads/sample_excel/bom_items_excel.xlsx" target="_blank">Download Sample</a></span>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions right">
                                            <button type="submit" class="btn green common_save" title="click To Save" rel="0"><i class="fa fa-upload"></i> Upload </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        <?php }else{ ?>
                        <input type="hidden" name="project_id" id="project_id" value="0">
                        <?php } ?>
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption font-blue">
                                        <i class="fa fa-bars font-blue"></i>
                                        <span class="caption-subject bold uppercase">BOM Item List</span>
                                    </div>
                                </div>

                                <div class="portlet-body">
                                    <table width="100%" id="pbomlist" class="table table-striped table-bordered table-hover">
            							<thead>
            								<tr>
            									<th scope="col" style="vertical-align: top;">Sr.no</th>
            								    <th scope="col" style="vertical-align: top;">BOQ<br>Sr No</th>
            									<th scope="col" style="vertical-align: top;">BP Code</th>
                                                <th scope="col" style="vertical-align: top;">HNS Code</th>
            								    <th scope="col" style="vertical-align: top;">BOQ Item Description</th>
            									<th scope="col" style="vertical-align: top;">Unit</th>
            									<th scope="col" style="vertical-align: top;">Build Qty</th>
            									<th scope="col" style="vertical-align: top;">Status</th>
            									<th scope="col" style="vertical-align: top;">Action</th>
            								</tr>
            							</thead>
            							<tbody> </tbody>
            					    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
    <?php $this->load->view('common/footer');?>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/select2/select2.min.js" type="text/javascript" ></script>
    <script src="<?php echo base_url();?>assets/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
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
    <script src="<?php echo base_url();?>js/bom-item-upload.js?<?php echo date('Ymd H:i:s'); ?>" type="text/javascript"></script>
    <script>

    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); 
        ComponentsPickers.init();
    });
    </script>
</body>
</html>