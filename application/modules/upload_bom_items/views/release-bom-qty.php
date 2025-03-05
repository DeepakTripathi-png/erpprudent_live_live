<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>BOM Release Quantity | <?php echo project_name; ?> </title>
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
    <link href="<?php echo base_url();?>assets/global/css/components-rounded.css?<?php echo date('Y-m-d H:i:s');?>" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/global/css/plugins.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>assets/admin/layout4/css/layout.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>/assets/admin/layout4/css/light.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/site/css/validationEngine.jquery.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/createp.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <style>
        
        .sub-table {
            background: #a3c6df!important;
        }
        .green {
            color: #FFFFFF!important;
            background-color: #26a69a!important;
            border: none!important;
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
        .color-red {
            color:red;
            font-weight: 600;
        }
        .buttons-page-length {
            display: none!important;
        }
        .has-error{
            border: 1px solid #a94442;
        }
    </style>
    </head>
<body class="page-header-fixed page-sidebar-closed-hide-logo">
    <?php $this->load->view('common/header');?>
    <div class="clearfix">
    </div>
    <div class="page-container">
        <?php $this->load->view('common/sidebar');?>
        <div class="page-content-wrapper">
            <div class="page-content">
                     <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption font-blue">
                                    <i class="fa fa-bars font-blue"></i>
                                    <span class="caption-subject bold uppercase"><?php echo(isset($bp_code) && !empty($bp_code))?'(#'.$bp_code.')':''?> BOM Release Quantity</span>
                                </div>
                            </div>
                            <div class="portlet-body form" style="margin-top:3rem;">
                           
                            <div class="tab-content">
                                <input type="hidden" id="project_id" value="<?php echo base64_encode($project_id); ?>">
                                <input type="hidden" id="schedule_type" value="<?php echo $schedule_type; ?>">
                                <input type="hidden" id="schedule_release" value="<?php echo $schedule_release; ?>">
                                <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

                                <div class="portlet-body form">
                                    <div class="tab-content">
                                        <?php if($schedule_type== 'A') { ?>
                                            <table width="100%" id="pboqscha" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sr.no</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">BOQ<br>Sr No</th>
                                                        <th scope="col" style="min-width:250px;width:250px;vertical-align: top;">Item Description</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Unit</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Release <br> Sch<br>Qty</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Build<br>Qty</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Rate <br> Basic</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Build<br> Amount<br>(Basic)</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">GST<br> Rate(%)</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">GST<br> Amount</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Build<br> Amount<br>(GST)</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <!-- <tfoot class="operable_a_footer" style="display:none;">
                                                    <tr>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgn_amount_with_gst']) && !empty($sch_a_total_data['total_dsgn_amount_with_gst']))?'':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgn_amount_with_gst']) && !empty($sch_a_total_data['total_dsgn_amount_with_gst']))?'':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgn_amount_with_gst']) && !empty($sch_a_total_data['total_dsgn_amount_with_gst']))?'':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgn_amount_with_gst']) && !empty($sch_a_total_data['total_dsgn_amount_with_gst']))?'Grand Total':''; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_sch_qty']) && !empty($sch_a_total_data['total_sch_qty']))?$sch_a_total_data['total_sch_qty']:'0'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgnqty']) && !empty($sch_a_total_data['total_dsgnqty']))?$sch_a_total_data['total_dsgnqty']:'0'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_basic_rate']) && !empty($sch_a_total_data['total_basic_rate']))?sprintf('%0.2f', $sch_a_total_data['total_basic_rate']):'0.00'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgn_amount']) && !empty($sch_a_total_data['total_dsgn_amount']))?sprintf('%0.2f', $sch_a_total_data['total_dsgn_amount']):'0.00'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgn_gst_amount']) && !empty($sch_a_total_data['total_dsgn_gst_amount']))?sprintf('%0.2f', $sch_a_total_data['total_dsgn_gst_amount']):'0.00'; ?></th>
                                                        <th style="text-align:right;font-weight: 600;"><?php echo (isset($sch_a_total_data['total_dsgn_amount_with_gst']) && !empty($sch_a_total_data['total_dsgn_amount_with_gst']))?sprintf('%0.2f', $sch_a_total_data['total_dsgn_amount_with_gst']):'0.00'; ?></th>
                                                    </tr>
                                                </tfoot> -->
                                            </table>
                                            <p id="invaliderrorid" style="padding:0px;font-size: 12px;color:#a94442;"></p>
                                            <p id="invaliderrorid1" style="padding:0px;font-size: 12px;color:#a94442;"></p>
                                        <?php } else if($schedule_type== 'B') {?>
                                            <form action="release_schedule_quantity" enctype="multipart/form-data" id="release_schedule_quantity" method="post" class="horizontal-form">
                                                <input type="hidden" name="project_id" id="project_id" value="<?php echo base64_encode($project_id); ?>">
                                                <input type="hidden" id="schedule_type" name="schedule_type" value="<?php echo $schedule_type; ?>">
                                                <table width="100%" id="pboqschb" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sr.no</th>
                                                            <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">BOQ <br>Sr No</th>
                                                            <th scope="col" style="min-width:250px;width:250px;vertical-align: top;">Item Description</th>
                                                            <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Unit</th>
                                                            <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sch<br> Qty</th>
                                                            <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Variation<br>Qty</th>
                                                            <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Avl. Release<br>Qty</th>
                                                            <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Release<br>Qty</th>
                                                            <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                                <p id="invaliderrorid" style="padding:0px;font-size: 12px;color:#a94442;"></p>
                                                <div class="form-actions right">
                                                    <button type="button" class="btn btn-danger cancel" onclick="location.href = '<?php echo base_url(); ?>upload-bom-items';" title="click To Cancel"> Cancel</button>
                                                    <button type="submit" class="btn green common_save" title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> Send to Approval</button>
                                                </div>  
                                            </form>
                                            <?php } else if($schedule_type== 'B-') { ?>

                                            <form action="release_schedule_b_negative_quantity" enctype="multipart/form-data" id="release_schedule_b_negative_quantity" method="post" class="horizontal-form">
                                                <input type="hidden" name="project_id" id="project_id" value="<?php echo base64_encode($project_id); ?>">
                                                <input type="hidden" id="schedule_type" name="schedule_type" value="<?php echo $schedule_type; ?>">
                                                <table width="100%" id="pboqschbn" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sr.no</th>
                                                            <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">BOQ <br>Sr No</th>
                                                            <th scope="col" style="min-width:250px;width:250px;vertical-align: top;">Item Description</th>
                                                            <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Unit</th>
                                                            <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sch<br> Qty</th>
                                                            <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Variation<br>Qty</th>
                                                            <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Avl. Release<br>Qty</th>
                                                            <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Release<br>Qty</th>
                                                            <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                                <p id="invaliderrorid" style="padding:0px;font-size: 12px;color:#a94442;"></p>
                                                <p id="invaliderrorid1" style="padding:0px;font-size: 12px;color:#a94442;"></p>
                                                <p id="invaliderrorid2" style="padding:0px;font-size: 12px;color:#a94442;"></p>
                                                <div class="form-actions right">
                                                    <button type="button" class="btn btn-danger cancel" onclick="location.href = '<?php echo base_url(); ?>upload-bom-items';" title="click To Cancel"> Cancel</button>
                                                    <button type="submit" class="btn green common_save" title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> Send to Approval</button>
                                                </div>  
                                            </form>

                                        <?php } else if($schedule_type== 'C') { ?>   
                                            <form action="release_schedule_quantity" enctype="multipart/form-data" id="release_schedule_quantity" method="post" class="horizontal-form">
                                            <input type="hidden" name="project_id" id="project_id" value="<?php echo base64_encode($project_id); ?>">
                                            <input type="hidden" id="schedule_type" name="schedule_type" value="<?php echo $schedule_type; ?>">
                                            <table width="100%" id="pboqschc" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Sr.no</th>
                                                        <th scope="col" style="min-width:80px;width:80px;vertical-align: top;">BOQ<br>Sr No</th>
                                                        <th scope="col" style="min-width:250px;width:250px;vertical-align: top;">Item Description</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Unit</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Build<br>Qty</th>
                                                        <th scope="col" style="min-width:30px;width:30px;vertical-align: top;">Release<br>Qty</th>
                                                        <th scope="col" style="min-width:10px;width:10px;vertical-align: top;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                            <p id="invaliderrorid" style="padding:0px;font-size: 12px;color:#a94442;"></p>
                                            <div class="form-actions right">
                                                <button type="button" class="btn btn-danger cancel" onclick="location.href = '<?php echo base_url(); ?>upload-bom-items';" title="click To Cancel"> Cancel</button>
                                                <button type="submit" class="btn green common_save" title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> Send to Approval</button>
                                            </div>
                                            </form>
                                        <?php } else { ?>
                                             <p style="margin-top:20px;">BOQ Operable Scheduled Not Found!!</p>
                                        <?php } ?>   

                                        <hr/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <a download="somedata.xls" href="#" onclick="return ExcellentExport.excel(this, 'pboqscha', 'Sheet Name Here');">Export to Excel</a> -->

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
    <script src="<?php echo base_url();?>js/common.js?<?php echo date('Y-m-d H:i:s');?>" type="text/javascript"></script>
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
    <script src="<?php echo base_url();?>js/bom-release-qty.js?<?php echo date('Y-m-d H:i:s');?>" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/excellentexport@3.4.3/dist/excellentexport.min.js"></script>
    <script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); 
        ComponentsPickers.init();
    });
    </script>
    
</body>
</html>