<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>OEF List | <?php echo project_name; ?> </title>
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
     <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <style type="text/css">
        table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting {
            padding-right: 19px;
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
                                    <span class="caption-subject bold uppercase"> OEF List </span>
                                </div>
                                <div class="actions tools">
                                    <?php if(isset($check_permission_create) && $check_permission_create == 'Y'){ ?>
                                    <a href="<?php echo base_url();?>create-project" class="btn blue btn-sm" style="height:28px ;"><i class="fa fa-plus-circle "></i> CREATE NEW OEF</a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <table width="100%" id="plist" class="table table-striped table-bordered table-hover">
        							<thead>
        									<tr>
        									<th scope="col" style="min-width:30px;width:30px;">Sr.no</th>
        									<th scope="col" style="min-width:30px;width:30px;">BP Code</th>
        									<th scope="col" style="min-width:30px;width:30px;">PO/LOI No</th>
        									<th scope="col" style="min-width:150px;width:150px;">Customer Details</th>
        									<th scope="col" style="min-width:150px;width:150px;">Registered Address</th>
        									<th scope="col" style="min-width:80px;width:80px;">Status</th>
        									<th scope="col" style="min-width:30px;width:30px;">CreatedBy</th>
        									<th scope="col" style="min-width:120px;width:120px;">CreatedOn</th>
        									<th scope="col" style="min-width:90px;width:90px;">Action</th>
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
    <script src="<?php echo base_url();?>js/common.js?<?php echo date('Y-m-d H:i:s');?>" type="text/javascript"></script>
    <script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); 
        ComponentsPickers.init();
    });
    var download_title = 'OEF List';
    $('#plist').DataTable({
	// Processing indicator
		"scrollX": true,
		"dom": 'Bfrtip',
                    "lengthMenu": [
                        [25, 50, 75, 100, 125,150, -1],
                        [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
                    ],
                    "buttons": [
                        'pageLength',
                        {
                            "extend": 'copy',
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7]
                            },
                            "title": download_title,
                            "footer": true
                        },
                       
                        {
                            "extend": 'excel',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7]
                            },
                            "footer": true
                        },
                        {
                            "extend": 'pdf',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7]
                            },
                            "footer": true
                        },
                        {
                            "extend": 'print',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7]
                            },
                            "footer": true
                        }
                    ],
            	    "bAutoWidth": false,
        "lengthMenu": [25, 50, 75, 100, 125,150],
		"paging": true,
		 "iDisplayLength": 25,
         "deferRender": true,
         "responsive": false,
        "processing": true,
		"serverSide": true,
        // Initial no order.
        "order": [],
		
        // Load data from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('project_list_display'); ?>",
            "type": "POST"
        },
		
        //Set column definition initialisation properties
        "columnDefs": [{ 
            "targets": [0,1,2,3,4,5,6,7,8],
            "orderable": false
        }]
    } );
    </script>
</body>
</html>