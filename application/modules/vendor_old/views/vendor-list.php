<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8"/>

    <title>Vendor List | <?php echo project_name; ?> </title>

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

                                    <span class="caption-subject bold uppercase"> Vendor List </span>

                                </div>

                                <div class="actions tools">

                                    <a href="<?php echo base_url();?>add-vendor" class="btn blue btn-sm" style="height:28px ;"><i class="fa fa-plus-circle "></i> ADD NEW VENDOR</a>

                                </div>

                            </div>

                            <div class="portlet-body form">

                                <table class="table table-striped table-bordered table-hover masterTable">

                                    <thead>

                                        <tr>

                                            <th class="font-blue-madison bold" style="width: 9%;text-align: center;"> Sr. No</th>

                                            <th class="font-blue-madison bold"> Company Details </th>

                                            <th class="font-blue-madison bold"> Details of Director/Partners </th>

                                            <th class="font-blue-madison bold"> Communication Details</th>

                                            <th class="font-blue-madison bold" style="text-align: center;width: 9%;"> Action </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php if(isset($vendor_data) && !empty($vendor_data))

                                        { $i = 1;

                                            foreach ($vendor_data as $key)

                                            {?>

                                                <tr>

                                                    <td style="text-align: center;"><?php echo $i++; ?></td>

                                                    <td>

                                                        <b>Name : </b> <?php echo(isset($key->name_of_company) && !empty($key->name_of_company))?$key->name_of_company:'';?> <br>

                                                        <b>Type : </b> <?php echo(isset($key->business_type) && !empty($key->business_type))?$key->business_type:'';?>

                                                    </td>

                                                    <td>

                                                        <b>Name : </b> <?php echo (isset($key->comma_separated_director_name) && !empty($key->comma_separated_director_name)) ? $key->comma_separated_director_name : ''; ?> <br>

                                                        <b>Contact No. : </b> <?php echo (isset($key->comma_separated_director_contactno) && !empty($key->comma_separated_director_contactno)) ? $key->comma_separated_director_contactno : ''; ?> <br>

                                                        <b>CIN No / Shop Act No : </b> <?php echo(isset($key->dir_cin_act_reng_nos) && !empty($key->dir_cin_act_reng_nos))?$key->dir_cin_act_reng_nos:'';?> 

                                                    </td>

                                                    <td>

                                                        <b>Name : </b> <?php echo(isset($key->contact_person_name) && !empty($key->contact_person_name))?$key->contact_person_name:'';?> <br>

                                                        <b>Contact No. : </b> <?php echo(isset($key->comm_mobile_phone) && !empty($key->comm_mobile_phone))?$key->comm_mobile_phone:'';?> <br>

                                                        <b>Email : </b> <?php echo(isset($key->comm_email) && !empty($key->comm_email))?$key->comm_email:'';?> <br>

                                                    </td>

                                                    <td style="text-align: center; vertical-align: middle;">

                                                        <a href="<?php echo base_url(); ?>edit-vendor/<?php echo(isset($key->vendor_id) && !empty($key->vendor_id))?$key->vendor_id:'';?>" class="edit tooltips " title="Edit Vendor"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>

                                                    </td>

                                                </tr>

                                            <?php }

                                        }?>

                                    </tbody>

                                </table>

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