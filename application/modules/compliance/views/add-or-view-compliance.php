<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Add / View Compliance | <?php echo project_name; ?> </title>
    <base href="<?php echo base_url();?>">
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
    <link href="<?php echo base_url();?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/css/components-rounded.css?<?php echo date('Y-m-d H:i:s');?>" id="style_components" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/admin/layout4/css/layout.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>/assets/admin/layout4/css/light.css?<?php echo date('Y-m-d H:i:s');?>" rel="stylesheet" type="text/css" />
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
                    <?php if(isset($check_permission_add) && $check_permission_add == 'Y'){ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption font-blue"> <i class="fa fa-plus-circle font-blue"></i> <span class="caption-subject bold uppercase">Add / View Compliance</span> </div>
                                </div>
                                <div class="portlet-body form">
                                    <form action="Add_View_Compliance" id="Add_View_Compliance" class="horizontal-form" method="post" enctype="multipart/form-data">
                                        <div class="form-body">

                                            <div class="row" style="display:flex;">

                                            <div class="col-md-4" >
                                                        <div class="form-group">
                                                            <select class="form-control select2me" name="year" id="year" required>
                                                                <option value="">--Select Year--</option>
                                                                <option value="2023">2023</option>
                                                                <option value="2024">2024</option>
                                                              
                                                            </select>
                                                        </div>
                                                    </div>
                                                   

                                                   
                                                <div class="col-md-4" id="akl" style="display: none;">
                                                        <div class="form-group">
                                                            <select class="form-control select2me" name="month" id="month" required>
                                                                <option value="">--Select Month--</option>
                                                                <option value="January">January</option>
                                                                <option value="February">February</option>
                                                                <option value="March">March</option>
                                                                <option value="April">April</option>
                                                                <option value="May">May</option>
                                                                <option value="June">June</option>
                                                                <option value="July">July</option>
                                                                <option value="August">August</option>
                                                                <option value="September">September</option>
                                                                <option value="October">October</option>
                                                                <option value="November">November</option>
                                                                <option value="December">December</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="row">
                                                    <div class="col-md-3">
                										<div class="form-group">
                											<label class="">GSTR-1A Confirmation Date <span class="required gstr_1a_confirmation_datespan" aria-required="true" style="color:#a94442"></span></label>
                											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                                                             
                												<input type="text" name="gstr_1a_confirmation_date" 
                                                                value="<?php echo(isset($comdata->gstr_1a_confirmation_date) && !empty($comdata->gstr_1a_confirmation_date))?$comdata->gstr_1a_confirmation_date:'';?>"
                                                                id="gstr_1a_confirmation_date" class="form-control" readonly="" placeholder="GSTR-1A Confirmation Date"  >		
                												<span class="input-group-btn">
                													<button class="btn default" id="gstr_1a_confirmation_date_btn" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                												</span>
                											</div>
                										</div> 
                									</div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Upload Document <span class="require upload_gtds_docsspan" aria-required="true" style="color:#a94442"></span></label><br>
                                                            <input type="file" name="upload_gtds_docs" id="upload_gtds_docs"  class="upload_gtds_docs" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                                                            <span id="upload_gtds_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                            <a href="" id="upload_gtds_docs_dn" style="display: none;"  download="">Download</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                										<div class="form-group">
                											<label class="">Professional Tax (PT) Confirmation Date <span class="required proof_tax_confirmation_datespan" aria-required="true" style="color:#a94442"></span></label>
                											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                												<input type="text" name="proof_tax_confirmation_date" id="proof_tax_confirmation_date" class="form-control"  readonly="" placeholder="Professional Tax (PT) Confirmation Date" >		
                												<span class="input-group-btn">
                													<button class="btn default" id="proof_tax_confirmation_date_btn" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                												</span>
                											</div>
                										</div> 
                									</div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Upload Document <span class="require proof_tax_docspan" aria-required="true" style="color:#a94442"></span></label><br>
                                                            <input type="file" name="proof_tax_doc" id="proof_tax_doc" class="upload_gtds_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                                                            <span id="upload_gtds_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                            <a   id="proof_tax_doc_dn" style="display: none;" href="" download="">Download</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                										<div class="form-group">
                											<label class="">GSTR-3B Confirmation Date <span class="required gstr_3b_confirmation_datespan" aria-required="true" style="color:#a94442"></span></label>
                											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                												<input type="text" name="gstr_3b_confirmation_date" id="gstr_3b_confirmation_date" class="form-control" readonly="" placeholder="GSTR-1A Confirmation Date"  >		
                												<span class="input-group-btn">
                													<button class="btn default" id="gstr_3b_confirmation_date_btn" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                												</span>
                											</div>
                										</div> 
                									</div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Upload Document <span class="require gstr_3b_docspan" aria-required="true" style="color:#a94442"></span></label><br>
                                                            <input type="file" name="gstr_3b_doc" id="gstr_3b_doc" class="upload_gtds_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" >
                                                            <span id="upload_gtds_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                            <a   id="gstr_3b_doc_dn" style="display: none;" href="" download="">Download</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                										<div class="form-group">
                											<label class="">Provident Fund (PF) Confirmation Date <span class="required pro_fund_confirmation_datespan" aria-required="true" style="color:#a94442"></span></label>
                											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                												<input type="text" name="pro_fund_confirmation_date" id="pro_fund_confirmation_date" class="form-control" readonly=""  placeholder="Provident Fund (PF) Confirmation Date" >		
                												<span class="input-group-btn">
                													<button class="btn default" id="pro_fund_confirmation_date_btn" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                												</span>
                											</div>
                										</div> 
                									</div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Upload Document <span class="require pro_fund_docspan" aria-required="true" style="color:#a94442"></span></label><br>
                                                            <input type="file" name="pro_fund_doc" id="pro_fund_doc" class="upload_gtds_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" >
                                                            <span id="upload_gtds_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                            <a   id="pro_fund_doc_dn" style="display: none;" href="" download="">Download</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-3">
                										<div class="form-group">
                											<label class="">TDS Confirmation Date <span class="required tds_confirmation_datesspan" aria-required="true" style="color:#a94442"></span></label>
                											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                												<input type="text" name="tds_confirmation_dates" id="tds_confirmation_dates" class="form-control" readonly="" placeholder="TDS Confirmation Date">		
                												<span class="input-group-btn">
                													<button class="btn default" id="tds_confirmation_dates_btn" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                												</span>
                											</div>
                										</div> 
                									</div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Upload Document <span class="require tds_docspan" aria-required="true" style="color:#a94442"></span></label><br>
                                                            <input type="file" name="tds_doc" id="tds_doc" class="upload_gtds_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" >
                                                            <span id="upload_gtds_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                            <a   id="tds_doc_dn" style="display: none;" href="" download="">Download</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                										<div class="form-group">
                											<label class="">ESIC Confirmation Date <span class="required esic_confirmation_datespan" aria-required="true" style="color:#a94442"></span></label>
                											<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                												<input type="text" name="esic_confirmation_date" id="esic_confirmation_date" class="form-control" readonly="" placeholder="ESIC Confirmation Date" >		
                												<span class="input-group-btn">
                													<button class="btn default" id="esic_confirmation_date_btn" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                												</span>
                											</div>
                										</div> 
                									</div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Upload Document <span class="require esic_docspan" aria-required="true" style="color:#a94442"></span></label><br>
                                                            <input type="file" name="esic_doc" id="esic_doc" class="upload_gtds_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" >
                                                            <span id="upload_gtds_doc_error" style="font-size: 12px;color:#a94442;"></span>
                                                            <a   id="esic_doc_dn" style="display: none;" href="" download="">Download</a>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="form-actions right"> <a href="<?php echo base_url();?>create-tax-invoice" class="btn blue" style="float: left;">Back</a> <button type="button" class="btn btn-danger cancel clearData" title="click To Cancel"> Cancel</button> <button type="submit" class="btn green common_save" title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> Save</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption font-blue">
                                        <i class="fa fa-bars font-blue"></i>
                                        <span class="caption-subject bold uppercase">COMPLIANCE LIST</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                      <table width="100%" id="pwiplist" class="table table-striped table-bordered table-hover" style="font-size:12px;">
            							<thead>
            								<tr>
            									<th scope="col">Sr.no</th>
            									<th scope="col">Month</th>
            									<th scope="col" style="min-width:60px;width:60px;">GSTR-1A Date</th>
            									<th scope="col" style="min-width:60px;width:60px;">GSTR-3B Date</th>
            									<th scope="col" style="min-width:60px;width:60px;">TDS Date</th>
            								    <th scope="col" style="min-width:60px;width:60px;">PT Date</th>
            								    <th scope="col" style="min-width:60px;width:60px;">PF Date</th>
            								    <th scope="col" style="min-width:60px;width:60px;">ESIC Date</th>
            								    <th scope="col" style="min-width:50px;width:50px;">GSTR-1A Doc</th>
            								    <th scope="col" style="min-width:50px;width:50px;">GSTR-3B Doc</th>
            								    <th scope="col" style="min-width:50px;width:50px;">TDS Doc</th>
            								    <th scope="col" style="min-width:50px;width:50px;">PT Doc</th>
            								    <th scope="col" style="min-width:50px;width:50px;">PF Doc</th>
            								    <th scope="col" style="min-width:50px;width:50px;">ESIC  Doc</th>
            								    <th scope="col">Created On</th>
            									<th scope="col">Action</th>
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
    </div> <?php $this->load->view('common/footer');?> <script src="<?php echo base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
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
    <script src="<?php echo base_url();?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/datatables/table-advanced.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/lib/jquery.form.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine.js"></script>
    <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine-en.js"></script>
    <script src="<?php echo base_url();?>js/common.js?<?php echo date('Y-m-d H:i:s'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/user.js?<?php echo date('Y-m-d H:i:s'); ?>" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core components
            Layout.init(); 
            ComponentsPickers.init();
            TableAdvanced.init();
        });
        $('#month').change(function (e) { 
            var month =  $(this).val();
            var year =  $('#year').val();
            if(year && month){
                $.ajax({
                    type: "POST",
                    "url": "<?php echo base_url('view_compliance'); ?>",
                    data:{year : year,month : month},
                    success: function (response) {
                        if(response.valid){
                            console.log(response.data.comdata[0]);
                            if(response.data.comdata[0].gstr_1a_confirm_date !=='' && response.data.comdata[0].gstr_1a_confirm_date !== '0000-00-00'){
                                $('#gstr_1a_confirmation_date').val(response.data.comdata[0].gstr_1a_confirm_date);
                                $('#upload_gtds_docs_dn').show();
                                $('#gstr_1a_confirmation_date_btn').prop('disabled', true);
                                if(response.data.comdata[0].gstr_1a_doc !== ''){
                                $('#upload_gtds_docs_dn').attr("href","<?php echo base_url('uploads/compliance_upload/'); ?>" + response.data.comdata[0].gstr_1a_doc);
                                }
                            }
                            if(response.data.comdata[0].gstr_3b_confirm_date !== '' && response.data.comdata[0].gstr_3b_confirm_date !== '0000-00-00'){
                                $('#gstr_3b_confirmation_date').val(response.data.comdata[0].gstr_3b_confirm_date);
                                $('#gstr_3b_doc_dn').show();
                                $('#gstr_3b_confirmation_date_btn').prop('disabled', true);
                                if(response.data.comdata[0].gstr_3b_doc !== ''){
                                $('#gstr_3b_doc_dn').attr("href","<?php echo base_url('uploads/compliance_upload/'); ?>" + response.data.comdata[0].gstr_3b_doc);
                                }
                            }
                            if(response.data.comdata[0].tds_confirm_date !=='' && response.data.comdata[0].tds_confirm_date !== '0000-00-00'){
                                $('#tds_confirmation_dates').val(response.data.comdata[0].tds_confirm_date);
                                $('#tds_doc_dn').show();
                                $('#tds_confirmation_dates_btn').prop('disabled', true);
                                if(response.data.comdata[0].tds_doc !== ''){
                                $('#tds_doc_dn').attr("href","<?php echo base_url('uploads/compliance_upload/'); ?>" + response.data.comdata[0].tds_doc);
                                }
                            }
                            if(response.data.comdata[0].proof_tax_confirm_date !=='' && response.data.comdata[0].proof_tax_confirm_date !== '0000-00-00'){
                                $('#proof_tax_confirmation_date').val(response.data.comdata[0].proof_tax_confirm_date);
                                $('#proof_tax_doc_dn').show();
                                $('#proof_tax_confirmation_date_btn').prop('disabled', true);
                                if(response.data.comdata[0].proof_tax_doc !== ''){
                                $('#proof_tax_doc_dn').attr("href","<?php echo base_url('uploads/compliance_upload/'); ?>" + response.data.comdata[0].proof_tax_doc);
                                }
                            }
                            if(response.data.comdata[0].pro_fund_confirm_date !=='' && response.data.comdata[0].pro_fund_confirm_date !== '0000-00-00'){
                                $('#pro_fund_confirmation_date').val(response.data.comdata[0].pro_fund_confirm_date);
                                $('#pro_fund_doc_dn').show();
                                $('#pro_fund_confirmation_date_btn').prop('disabled', true);
                                if(response.data.comdata[0].pro_fund_doc !== ''){
                                $('#pro_fund_doc_dn').attr("href","<?php echo base_url('uploads/compliance_upload/'); ?>" + response.data.comdata[0].pro_fund_doc);
                                }
                            }
                            if(response.data.comdata[0].esic_confirm_date !=='' && response.data.comdata[0].esic_confirm_date !== '0000-00-00'){
                                $('#esic_confirmation_date').val(response.data.comdata[0].esic_confirm_date);
                                $('#esic_doc_dn').show();
                                $('#esic_doc_btn').prop('disabled', true);
                                if(response.data.comdata[0].esic_doc !== ''){
                                $('#esic_doc_dn').attr("href","<?php echo base_url('uploads/compliance_upload/'); ?>" + response.data.comdata[0].esic_doc);
                                }
                            }
                        }else{
                            $('#gstr_1a_confirmation_date').val('');
                            $('#upload_gtds_docs_dn').hide();
                            $('#upload_gtds_docs').show();
                            $('#gstr_1a_confirmation_date_btn').prop('disabled', false);
                            $('#gstr_3b_confirmation_date').val('');
                            $('#gstr_3b_doc_dn').hide();
                            $('#gstr_3b_doc').show();
                            $('#gstr_3b_confirmation_date_btn').prop('disabled', false);
                            $('#tds_confirmation_dates').val('');
                            $('#tds_doc_dn').hide();
                            $('#tds_doc').show();
                            $('#tds_confirmation_dates_btn').prop('disabled', false);
                            $('#proof_tax_confirmation_date').val('');
                            $('#proof_tax_doc_dn').hide();
                            $('#proof_tax_doc').show();
                            $('#proof_tax_confirmation_date_btn').prop('disabled', false);
                            $('#pro_fund_confirmation_date').val('');
                            $('#pro_fund_doc_dn').hide();
                            $('#pro_fund_doc').show();
                            $('#pro_fund_confirmation_date_btn').prop('disabled', false);
                            $('#esic_confirmation_date').val('');

                            $('#esic_doc_dn').hide();
                            $('#esic_doc').show();
                            $('#esic_doc_btn').prop('disabled', false);
                            $("#esic_doc").prop('required',false);
                            $("#esic_doc").val('');
                            $("#gstr_3b_doc").val('');
                            $("#upload_gtds_docs").val('');
                            $("#tds_doc").val('');
                            $("#pro_fund_doc").val('');
                            $("#proof_tax_doc").val('');
                            $("#pro_fund_doc").prop('required',false);
                            $("#proof_tax_doc").prop('required',false);
                            $("#tds_doc").prop('required',false);
                            $("#upload_gtds_docs").prop('required',false);
                            $("#gstr_3b_doc").prop('required',false);
                            $("#esic_confirmation_date").prop('required',false);
                            $("#pro_fund_confirmation_date").prop('required',false);
                            $("#proof_tax_confirmation_date").prop('required',false);
                            $("#tds_confirmation_dates").prop('required',false);
                            $("#gstr_3b_confirmation_date").prop('required',false);
                            $("#gstr_1a_confirmation_date").prop('required',false);
                        }
                    }
                });
           }
        });
        $('#year').change(function (e) { 
            var month =  $('#month').val();
            var year =  $('#year').val();
            if(year){
               $('#akl').show();
            }else{
                $('#akl').hide();
            }
            if(year && month){
                $.ajax({
                    type: "POST",
                    "url": "<?php echo base_url('view_compliance'); ?>",
                    data: {year : year,month : month},
                    success: function (response) {
                        if(response.valid){
                            console.log(response.data.comdata[0]);
                            if(response.data.comdata[0].gstr_1a_confirm_date !=='' && response.data.comdata[0].gstr_1a_confirm_date !== '0000-00-00'){
                                $('#gstr_1a_confirmation_date').val(response.data.comdata[0].gstr_1a_confirm_date);
                                $('#upload_gtds_docs_dn').show();
                                $('#gstr_1a_confirmation_date_btn').prop('disabled', true);
                                if(response.data.comdata[0].gstr_1a_doc !== ''){
                                $('#upload_gtds_docs_dn').attr("href","<?php echo base_url('uploads/compliance_upload/'); ?>" + response.data.comdata[0].gstr_1a_doc);
                                }
                            }
                            if(response.data.comdata[0].gstr_3b_confirm_date !== '' && response.data.comdata[0].gstr_3b_confirm_date !== '0000-00-00'){
                                $('#gstr_3b_confirmation_date').val(response.data.comdata[0].gstr_3b_confirm_date);
                                $('#gstr_3b_doc_dn').show();
                                $('#gstr_3b_confirmation_date_btn').prop('disabled', true);
                                if(response.data.comdata[0].gstr_3b_doc !== ''){
                                $('#gstr_3b_doc_dn').attr("href","<?php echo base_url('uploads/compliance_upload/'); ?>" + response.data.comdata[0].gstr_3b_doc);
                                }
                            }
                            if(response.data.comdata[0].tds_confirm_date !=='' && response.data.comdata[0].tds_confirm_date !== '0000-00-00'){
                                $('#tds_confirmation_dates').val(response.data.comdata[0].tds_confirm_date);
                                $('#tds_doc_dn').show();
                                $('#tds_confirmation_dates_btn').prop('disabled', true);
                                if(response.data.comdata[0].tds_doc !== ''){
                                $('#tds_doc_dn').attr("href","<?php echo base_url('uploads/compliance_upload/'); ?>" + response.data.comdata[0].tds_doc);
                                }
                            }
                            if(response.data.comdata[0].proof_tax_confirm_date !=='' && response.data.comdata[0].proof_tax_confirm_date !== '0000-00-00'){
                                $('#proof_tax_confirmation_date').val(response.data.comdata[0].proof_tax_confirm_date);
                                $('#proof_tax_doc_dn').show();
                                $('#proof_tax_confirmation_date_btn').prop('disabled', true);
                                if(response.data.comdata[0].proof_tax_doc !== ''){
                                $('#proof_tax_doc_dn').attr("href","<?php echo base_url('uploads/compliance_upload/'); ?>" + response.data.comdata[0].proof_tax_doc);
                                }
                            }
                            if(response.data.comdata[0].pro_fund_confirm_date !=='' && response.data.comdata[0].pro_fund_confirm_date !== '0000-00-00'){
                                $('#pro_fund_confirmation_date').val(response.data.comdata[0].pro_fund_confirm_date);
                                $('#pro_fund_doc_dn').show();
                                $('#pro_fund_confirmation_date_btn').prop('disabled', true);
                                if(response.data.comdata[0].pro_fund_doc !== ''){
                                $('#pro_fund_doc_dn').attr("href","<?php echo base_url('uploads/compliance_upload/'); ?>" + response.data.comdata[0].pro_fund_doc);
                                }
                            }
                            if(response.data.comdata[0].esic_confirm_date !=='' && response.data.comdata[0].esic_confirm_date !== '0000-00-00'){
                                $('#esic_confirmation_date').val(response.data.comdata[0].esic_confirm_date);
                                $('#esic_doc_dn').show();
                                $('#esic_doc_btn').prop('disabled', true);
                                if(response.data.comdata[0].esic_doc !== ''){
                                $('#esic_doc_dn').attr("href","<?php echo base_url('uploads/compliance_upload/'); ?>" + response.data.comdata[0].esic_doc);
                                }
                            }
                        }else{
                            $('#gstr_1a_confirmation_date').val('');
                            $('#upload_gtds_docs_dn').hide();
                            $('#upload_gtds_docs').show();
                            $('#gstr_1a_confirmation_date_btn').prop('disabled', false);
                            $('#gstr_3b_confirmation_date').val('');
                            $('#gstr_3b_doc_dn').hide();
                            $('#gstr_3b_doc').show();
                            $('#gstr_3b_confirmation_date_btn').prop('disabled', false);
                            $('#tds_confirmation_dates').val('');
                            $('#tds_doc_dn').hide();
                            $('#tds_doc').show();
                            $('#tds_confirmation_dates_btn').prop('disabled', false);
                            $('#proof_tax_confirmation_date').val('');
                            $('#proof_tax_doc_dn').hide();
                            $('#proof_tax_doc').show();
                            $('#proof_tax_confirmation_date_btn').prop('disabled', false);
                            $('#pro_fund_confirmation_date').val('');
                            $('#pro_fund_doc_dn').hide();
                            $('#pro_fund_doc').show();
                            $('#pro_fund_confirmation_date_btn').prop('disabled', false);
                            $('#esic_confirmation_date').val('');

                            $('#esic_doc_dn').hide();
                            $('#esic_doc').show();
                            $('#esic_doc_btn').prop('disabled', false);

                            $("#esic_doc").prop('required',false);
                            $("#pro_fund_doc").prop('required',false);
                            $("#proof_tax_doc").prop('required',false);
                            $("#tds_doc").prop('required',false);
                            $("#upload_gtds_docs").prop('required',false);
                            $("#gstr_3b_doc").prop('required',false);

                            $("#esic_doc").val('');
                            $("#gstr_3b_doc").val('');
                            $("#upload_gtds_docs").val('');
                            $("#tds_doc").val('');
                            $("#pro_fund_doc").val('');
                            $("#proof_tax_doc").val('');

                            $("#esic_confirmation_date").prop('required',false);
                            $("#pro_fund_confirmation_date").prop('required',false);
                            $("#proof_tax_confirmation_date").prop('required',false);
                            $("#tds_confirmation_dates").prop('required',false);
                            $("#gstr_3b_confirmation_date").prop('required',false);
                            $("#gstr_1a_confirmation_date").prop('required',false);
                        }
                    }
               });
           }
        });
        
        jQuery(document).ready(function() {
            var gstr_1a_confirma_date = $('#gstr_1a_confirmation_date').val().trim();
            if(gstr_1a_confirma_date !== '' && gstr_1a_confirma_date !== '0000-00-00') {
                $("#upload_gtds_docs").prop('required',true);
                $("#upload_gtds_docs").closest('.form-group').addClass('has-error');
                $(".upload_gtds_docsspan").html('*');
            }else{
                $("#upload_gtds_docs").prop('required',false);
                $("#upload_gtds_docs").closest('.form-group').removeClass('has-error');
                $(".upload_gtds_docsspan").html('');
            }
            var gstr_3b_confirm_date = $('#gstr_3b_confirmation_date').val().trim();
            if(gstr_3b_confirm_date !== '' && gstr_3b_confirm_date !== '0000-00-00') {
                $("#gstr_3b_doc").prop('required',true);
                $("#gstr_3b_doc").closest('.form-group').addClass('has-error');
                $(".gstr_3b_docspan").html('*');
            }else{
                $("#gstr_3b_doc").prop('required',false);
                $("#gstr_3b_doc").closest('.form-group').removeClass('has-error');
                $(".gstr_3b_docspan").html('');
            }
            var tds_confirm_date = $('#tds_confirmation_dates').val().trim();
            if(tds_confirm_date !== '' && tds_confirm_date !== '0000-00-00') {
                $("#tds_doc").prop('required',true);
                $("#tds_doc").closest('.form-group').addClass('has-error');
                $(".tds_docspan").html('*');
            }else{
                $("#tds_doc").prop('required',false);
                $("#tds_doc").closest('.form-group').removeClass('has-error');
                $(".tds_docspan").html('');
            }
            var proof_tax_confirm_date = $('#proof_tax_confirmation_date').val().trim();
            if(proof_tax_confirm_date !== '' && proof_tax_confirm_date !== '0000-00-00') {
                $("#proof_tax_doc").prop('required',true);
                $("#proof_tax_doc").closest('.form-group').addClass('has-error');
                $(".proof_tax_docspan").html('*');
            }else{
                $("#proof_tax_doc").prop('required',false);
                $("#proof_tax_doc").closest('.form-group').removeClass('has-error');
                $(".proof_tax_docspan").html('');
            }
            var pro_fund_confirmation_date = $('#pro_fund_confirmation_date').val().trim();
            if(pro_fund_confirmation_date !== '' && pro_fund_confirmation_date !== '0000-00-00') {
                $("#pro_fund_doc").prop('required',true);
                $("#pro_fund_doc").closest('.form-group').addClass('has-error');
                $(".pro_fund_docspan").html('*');
            }else{
                $("#pro_fund_doc").prop('required',false);
                $("#pro_fund_doc").closest('.form-group').removeClass('has-error');
                $(".pro_fund_docspan").html('');
            }
            var esic_confirmation_date = $('#esic_confirmation_date').val().trim();
            if(esic_confirmation_date !== '' && esic_confirmation_date !== '0000-00-00') {
                $("#esic_doc").prop('required',true);
                $("#esic_doc").closest('.form-group').addClass('has-error');
                $(".esic_docspan").html('*');
            }else{
                $("#esic_doc").prop('required',false);
                $("#esic_doc").closest('.form-group').removeClass('has-error');
                $(".esic_docspan").html('');
            }
        });
        $('#gstr_1a_confirmation_date').change(function() {
            if($(this).val() !== '' && $(this).val() !== '0000-00-00') {
                $("#upload_gtds_docs").prop('required',true);
                $("#upload_gtds_docs").closest('.form-group').addClass('has-error');
                $(".upload_gtds_docsspan").html('*');
            }else{
                $("#upload_gtds_docs").prop('required',false);
                $("#upload_gtds_docs_dn").hide();
                $("#upload_gtds_docs").closest('.form-group').removeClass('has-error');
                $(".upload_gtds_docsspan").html('');
            }
        });
        $('#gstr_3b_confirmation_date').change(function() {
            if($(this).val() !== '' && $(this).val() !== '0000-00-00') {
                $("#gstr_3b_doc").prop('required',true);
                $("#gstr_3b_doc").closest('.form-group').addClass('has-error');
                $(".gstr_3b_docspan").html('*');
            }else{
                $("#gstr_3b_doc").prop('required',false);
                $('#gstr_3b_doc_dn').hide();
                $("#gstr_3b_doc").closest('.form-group').removeClass('has-error');
                $(".gstr_3b_docspan").html('');
            }
        });
        $('#tds_confirmation_dates').change(function() {
            if($(this).val() !== '' && $(this).val() !== '0000-00-00') {
                $("#tds_doc").prop('required',true);
                $("#tds_doc").closest('.form-group').addClass('has-error');
                $(".tds_docspan").html('*');
            }else{
                $("#tds_doc").prop('required',false);
                $('#tds_doc_dn').hide();
                $("#tds_doc").closest('.form-group').removeClass('has-error');
                $(".tds_docspan").html('');
            }
        });
        $('#proof_tax_confirmation_date').change(function() {
            if($(this).val() !== '' && $(this).val() !== '0000-00-00') {
                $("#proof_tax_doc").prop('required',true);
                $("#proof_tax_doc").closest('.form-group').addClass('has-error');
                $(".proof_tax_docspan").html('*');
            }else{
                $("#proof_tax_doc").prop('required',false);
                $('#proof_tax_doc_dn').hide();
                $("#proof_tax_doc").closest('.form-group').removeClass('has-error');
                $(".proof_tax_docspan").html('');
            }
        });
        $('#pro_fund_confirmation_date').change(function() {
            if($(this).val() !== '' && $(this).val() !== '0000-00-00') {
                $("#pro_fund_doc").prop('required',true);
                $("#pro_fund_doc").closest('.form-group').addClass('has-error');
                $(".pro_fund_docspan").html('*');
            }else{
                $("#pro_fund_doc").prop('required',false);
                $('#pro_fund_doc_dn').hide();
                $("#pro_fund_doc").closest('.form-group').removeClass('has-error');
                $(".pro_fund_docspan").html('');
            }
        });
        $('#pro_fund_doc').on('change', function() {
            if($(this).val() !== '') {
                $("#pro_fund_doc").closest('.form-group').removeClass('has-error');
                $(".pro_fund_docspan").html('');
                if($("#pro_fund_confirmation_date").val() =='' || $("#pro_fund_confirmation_date").val() == '0000-00-00'){
                    $("#pro_fund_confirmation_date").prop('required',true);
                    $("#pro_fund_confirmation_date").closest('.form-group').addClass('has-error');
                    $(".pro_fund_confirmation_datespan").html('*');
                }else{
                    $("#pro_fund_confirmation_date").prop('required',false);
                    $("#pro_fund_confirmation_date").closest('.form-group').removeClass('has-error');
                    $(".pro_fund_confirmation_datespan").html('');
                }
            }else{
                $("#pro_fund_confirmation_date").prop('required',false);
                $("#pro_fund_confirmation_date").closest('.form-group').removeClass('has-error');
                $(".pro_fund_confirmation_datespan").html('');
            }
        });
        $('#esic_confirmation_date').change(function() {
            if($(this).val() !== '' && $(this).val() !== '0000-00-00') {
                $("#esic_doc").prop('required',true);
                $("#esic_doc").closest('.form-group').addClass('has-error');
                $(".esic_docspan").html('*');
            }else{
                $("#esic_doc").prop('required',false);
                $('#esic_doc_dn').hide();
                $("#esic_doc").closest('.form-group').removeClass('has-error');
                $(".esic_docspan").html('');
            }
        });
        $('#esic_doc').on('change', function() {
            if($(this).val() !== '') {
                $("#esic_doc").closest('.form-group').removeClass('has-error');
                $(".esic_docspan").html('');
                if($("#esic_confirmation_date").val() =='' || $("#esic_confirmation_date").val() == '0000-00-00'){
                    $("#esic_confirmation_date").prop('required',true);
                    $("#esic_confirmation_date").closest('.form-group').addClass('has-error');
                    $(".esic_confirmation_datespan").html('*');
                }else{
                    $("#esic_confirmation_date").prop('required',false);
                    $("#esic_confirmation_date").closest('.form-group').removeClass('has-error');
                    $(".esic_confirmation_datespan").html('');
                }
            }else{
                $("#esic_confirmation_date").prop('required',false);
                $("#esic_confirmation_date").closest('.form-group').removeClass('has-error');
                $(".esic_confirmation_datespan").html('');
            }
        });
        $('#upload_gtds_docs').on('change', function() {
            if($(this).val() !== '') {
                $("#upload_gtds_docs").closest('.form-group').removeClass('has-error');
                $(".upload_gtds_docsspan").html('');
                if($("#gstr_1a_confirmation_date").val() =='' || $("#gstr_1a_confirmation_date").val() == '0000-00-00'){
                    $("#gstr_1a_confirmation_date").prop('required',true);
                    $("#gstr_1a_confirmation_date").closest('.form-group').addClass('has-error');
                    $(".gstr_1a_confirmation_datespan").html('*');
                }else{
                    $("#gstr_1a_confirmation_date").prop('required',false);
                    $("#gstr_1a_confirmation_date").closest('.form-group').removeClass('has-error');
                    $(".gstr_1a_confirmation_datespan").html('');
                }
            }else{
                $("#gstr_1a_confirmation_date").prop('required',false);
                $("#gstr_1a_confirmation_date").closest('.form-group').removeClass('has-error');
                $(".gstr_1a_confirmation_datespan").html('');
            }
        });
        $('#gstr_3b_doc').on('change', function() {
            if($(this).val() !== '') {
                $("#gstr_3b_doc").closest('.form-group').removeClass('has-error');
                $(".gstr_3b_docspan").html('');
                if($("#gstr_3b_confirmation_date").val() =='' || $("#gstr_3b_confirmation_date").val() == '0000-00-00'){
                    $("#gstr_3b_confirmation_date").prop('required',true);
                    $("#gstr_3b_confirmation_date").closest('.form-group').addClass('has-error');
                    $(".gstr_3b_confirmation_datespan").html('*');
                }else{
                    $("#gstr_3b_confirmation_date").prop('required',false);
                    $("#gstr_3b_confirmation_date").closest('.form-group').removeClass('has-error');
                    $(".gstr_3b_confirmation_datespan").html('');
                }
            }else{
                $("#gstr_3b_confirmation_date").prop('required',false);
                $("#gstr_3b_confirmation_date").closest('.form-group').removeClass('has-error');
                $(".gstr_3b_confirmation_datespan").html('');
            }
        });
        $('#tds_doc').on('change', function() {
            if($(this).val() !== '') {
                $("#tds_doc").closest('.form-group').removeClass('has-error');
                $(".tds_docspan").html('');
                if($("#tds_confirmation_dates").val() =='' || $("#tds_confirmation_dates").val() == '0000-00-00'){
                    $("#tds_confirmation_dates").prop('required',true);
                    $("#tds_confirmation_dates").closest('.form-group').addClass('has-error');
                    $(".tds_confirmation_datesspan").html('*');
                }else{
                    $("#tds_confirmation_dates").prop('required',false);
                    $("#tds_confirmation_dates").closest('.form-group').removeClass('has-error');
                    $(".tds_confirmation_datesspan").html('');
                }
            }else{
                $("#tds_confirmation_dates").prop('required',false);
                $("#tds_confirmation_dates").closest('.form-group').removeClass('has-error');
                $(".tds_confirmation_datesspan").html('');
            }
        });
        $('#proof_tax_doc').on('change', function() {
            if($(this).val() !== '') {
                $("#proof_tax_doc").closest('.form-group').removeClass('has-error');
                $(".proof_tax_docspan").html('');
                if($("#proof_tax_confirmation_date").val() =='' || $("#proof_tax_confirmation_date").val() == '0000-00-00'){
                    $("#proof_tax_confirmation_date").prop('required',true);
                    $("#proof_tax_confirmation_date").closest('.form-group').addClass('has-error');
                    $(".proof_tax_confirmation_datespan").html('*');
                }else{
                    $("#proof_tax_confirmation_date").prop('required',false);
                    $("#proof_tax_confirmation_date").closest('.form-group').removeClass('has-error');
                    $(".proof_tax_confirmation_datespan").html('');
                }
            }else{
                $("#proof_tax_confirmation_date").prop('required',false);
                $("#proof_tax_confirmation_date").closest('.form-group').removeClass('has-error');
                $(".proof_tax_confirmation_datespan").html('');
            }
        });
    $('#pwiplist').dataTable({
	    "paging": true,
		 "iDisplayLength": 10,
         "deferRender": true,
         "responsive": true,
        "processing": true,
		"serverSide": true,
        // Initial no order.
        "order": [],
		
        // Load data from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('compliance_list'); ?>",
            "type": "POST"
        },
		
        //Set column definition initialisation properties
        "columnDefs": [{ 
            "targets": [0],
            "orderable": false
        }]
    } );
    </script>
</body>

</html>