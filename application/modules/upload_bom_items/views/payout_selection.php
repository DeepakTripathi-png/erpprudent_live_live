<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Payout | <?php echo project_name; ?></title>
        <base href="<?php echo base_url(); ?>" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet" />
        <link href="<?php echo base_url();?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/css/components-rounded.css?<?php echo date('Ymd H:i:s'); ?>" id="style_components" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/css/plugins.css?<?php echo date('Ymd H:i:s'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/admin/layout4/css/layout.css?<?php echo date('Ymd H:i:s'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>/assets/admin/layout4/css/light.css?<?php echo date('Ymd H:i:s'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/site/css/validationEngine.jquery.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js"></script>
        <link href="<?php echo base_url(); ?>assets/css/createp.css?<?php echo date('Y-m-d H:i:s'); ?>" rel="stylesheet" type="text/css" />

        <style type="text/css">
            table.dataTable thead th,
            table.dataTable thead td {
                padding: 10px 15px !important;
                border-bottom: 0px solid #111;
                text-align: left;
                font-weight: 600;
            }
            .dataTables_filter {
                float: right;
            }
            .has-error {
                border: 1px solid #a94442;
            }
            table.dataTable thead > tr > th.sorting_asc,
            table.dataTable thead > tr > th.sorting_desc,
            table.dataTable thead > tr > th.sorting,
            table.dataTable thead > tr > td.sorting_asc,
            table.dataTable thead > tr > td.sorting_desc,
            table.dataTable thead > tr > td.sorting {
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
                vertical-align: middle !important;
                text-align: center;
            }
            .d-none {
                display: none;
            }
            .w70 {
                width: 70px;
            }
            .w400 {
                width: 400px;
            }
            .w40 {
                width: 40px;
            }
            .border-bottom {
                border-bottom: 1px solid #dddddd;
            }
            .error {
                color: red;
            }

            .alert-container {
                position: fixed;
                z-index: 9;
                width: 50%; /* You can adjust this as per your need */
                left: 50%;
                top: 10%;
                border: 1px solid #80808060;
                transform: translateX(-50%);
                background-color: #ffffff; /* White background */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Shadow effect */
                padding: 15px;
                border-radius: 4px;
                animation: slideDown 1s ease-out forwards;
                text-align: center;
            }

            @keyframes slideDown {
                0% {
                    top: -100px;
                    opacity: 0;
                }
                100% {
                    top: 12%; /* Final position */
                    opacity: 1;
                }
            }

            .alert-container .alert {
                margin-bottom: 0px;
                font-weight: 600;
            }
            .alert {
                font-weight: 600;
            }
            .pt-2 {
                padding-top: 10px;
            }
            input[type="file"] + .error {
                color: red !important;
                font-weight: 500 !important;
                background: none !important;
            }
            #voucher_form .col-md-4 {
                height: 92px;
            }
            .form-check-inline {
                margin-right: 10px;
            }
            .hide {
                display: none;
            }

            .show {
                display: block;
            }

        </style>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo">
        <?php $this->load->view('common/header');?>
        <div class="clearfix"></div>
        <div class="page-container">
            <?php $this->load->view('common/sidebar');?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="portlet-body">
                    <div class="alert-container hide"></div>
                        <div class="portlet-body">
                            <div class="col-md-12">
                                <div class="portlet light">
                                    <div class="portlet-title">
                                        <div class="caption font-blue">
                                            <i class="fa fa-bars font-blue"></i>
                                            <span class="caption-subject bold uppercase"> Payout Selection</span>
                                        </div>
                                        
                                    </div>
                                    <div class="form-actions" >
                                    <label for="payout_selection">Account Number</label>
                                    <select id="account_number" class="form-control" name="account_number" style="width: 30%;">
                                        <option value="">-- Select --</option>
                                        <option value="018011300001395/Janakalyan Sahakari Bank Ltd (Prudent Controls)">018011300001395/Janakalyan Sahakari Bank Ltd (Prudent Controls)</option>
                                        <option value="3736008730003259/Punjab National Bank (Prudent Controls)">3736008730003259/Punjab National Bank (Prudent Controls)</option>
                                        <option value="CA\1395/Janaklyan Sahakari Bank (Prudent Controls)">CA\1395/Janaklyan Sahakari Bank (Prudent Controls)</option>
                                        <option value="5651000009667/Union Bank of India (Prudent Controls)">5651000009667/Union Bank of India (Prudent Controls)</option>
                                        <option value="1199385225148537/Standard Chartered Bank (Prudent Controls)">1199385225148537/Standard Chartered Bank (Prudent Controls)</option>
                                        <option value="510101000653135/Union Bank of India (Prudent Controls)">510101000653135/Union Bank of India (Prudent Controls)</option>

                                        <option value="018013500000016/Janakalyan Sahakari Bank Ltd (Prudent EPC)">018013500000016/Janakalyan Sahakari Bank Ltd (Prudent EPC)</option>
                                        <option value="3736008730003213/Punjab National Bank (Prudent EPC)">3736008730003213/Punjab National Bank (Prudent EPC)</option>
                                        <option value="16431012000831/Punjab National Bank (Prudent EPC)">16431012000831/Punjab National Bank (Prudent EPC)</option>
                                        <option value="2301/114/Janta Sahakari Bank Ltd (Prudent EPC)">2301/114/Janta Sahakari Bank Ltd (Prudent EPC)</option>
                                        <option value="018011300001389/Jankalyan Sahakari Bank (Prudent EPC)">018011300001389/Jankalyan Sahakari Bank (Prudent EPC)</option>
                                    </select>
                                    <br>
                                    </div>
                                    <table width="100%" id="payout_selection_list" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="vertical-align: top; text-align: center;">Select Payout</th>
                                                <th scope="col" style="vertical-align: top; text-align: center;">BP Code</th>
                                                <th scope="col" style="vertical-align: top; text-align: center;">Payout Number</th>
                                                <th scope="col" style="vertical-align: top; text-align: center;">Po Number </th>
                                                <th scope="col" style="vertical-align: top; text-align: center;">Amount</th>
                                                <th scope="col" style="vertical-align: top; text-align: center;">Payment Date</th>
                                                <th scope="col" style="vertical-align: top; text-align: center;">Status</th>
                                                <th scope="col" style="vertical-align: top; text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <hr>
                                    <div class="po_info">
                                      
                                    </div>
                                    <hr>
                                    <div class="form-actions" >
                                        <button type="submit" class="btn btn-success bank-payment" title="Click To Save"><i class="fa fa-dot-circle-o"></i> Bank Payment</button>
                                    </div>
                                </div>
                                </div>
                            </div>

                                <div class="portlet-body">
                            <div class="col-md-12">
                                <div class="portlet light">
                                    <div class="portlet-title">
                                        <div class="caption font-blue">
                                            <i class="fa fa-bars font-blue"></i>
                                            <span class="caption-subject bold uppercase"> Payout Selection</span>
                                        </div>
                                        
                                    </div>

                                    <table width="100%" id="payout_selection_data" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="vertical-align: top; text-align: center;">BP Code</th>
                                                <th scope="col" style="vertical-align: top; text-align: center;">Payout Number</th>
                                                <th scope="col" style="vertical-align: top; text-align: center;">Po Number </th>
                                                <th scope="col" style="vertical-align: top; text-align: center;">GRN Number</th>
                                                <th scope="col" style="vertical-align: top; text-align: center;">Total Amount</th>
                                                <th scope="col" style="vertical-align: top; text-align: center;">Account Number</th>
                                                <th scope="col" style="vertical-align: top; text-align: center;">Payment Date</th>
                                                <!-- <th scope="col" style="vertical-align: top; text-align: center;">Status</th>
                                                <th scope="col" style="vertical-align: top; text-align: center;">Action</th> -->
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
        <?php $this->load->view('common/footer');?>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/scripts/metronic.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/select2/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/admin/pages/scripts/components-pickers.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
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
        <script src="<?php echo base_url();?>js/payout.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>js/payout_selection.js" type="text/javascript"></script>

        <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core components
                Layout.init();
                ComponentsPickers.init();
            });
        </script>
    </body>
</html>
