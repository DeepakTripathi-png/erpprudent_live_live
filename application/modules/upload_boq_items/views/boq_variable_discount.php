<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title>BOQ Variable Discount | <?php echo project_name; ?> </title>
      <base href="<?php echo base_url(); ?>">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url(); ?>assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>assets/global/css/components-rounded.css?<?php echo date('Ymd H:i:s'); ?>" id="style_components" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>assets/global/css/plugins.css?<?php echo date('Ymd H:i:s'); ?>" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>assets/admin/layout4/css/layout.css?<?php echo date('Ymd H:i:s'); ?>" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>/assets/admin/layout4/css/light.css?<?php echo date('Ymd H:i:s'); ?>" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>assets/site/css/validationEngine.jquery.css" rel="stylesheet">
      <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css" rel="stylesheet" />
      <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
      <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />
      <link href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap.min.css" rel="stylesheet" />
      <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css" rel="stylesheet" />
      <style type="text/css">
         .statusselect {
         outline: unset;
         cursor: pointer;
         font-size: 13px;
         padding: 3px 5px;
         margin-top: 5px;
         }
         .statusselectoption {
         outline: unset;
         cursor: pointer;
         font-size: 13px;
         }
         .dataTables_filter {
         float: right;
         }
         .has-error-d {
         border: 1px solid #a94442;
         }
         table.dataTable thead>tr>th.sorting_asc,
         table.dataTable thead>tr>th.sorting_desc,
         table.dataTable thead>tr>th.sorting,
         table.dataTable thead>tr>td.sorting_asc,
         table.dataTable thead>tr>td.sorting_desc,
         table.dataTable thead>tr>td.sorting {
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
         form .error {
            color: #ff0000;
        }
      </style>
   </head>
   <body class="page-header-fixed page-sidebar-closed-hide-logo ">
      <?php $this->load->view('common/header'); ?>
      <div class="clearfix"> </div>
      <div class="page-container">
         <?php $this->load->view('common/sidebar'); ?>
         <div class="page-content-wrapper">
            <div class="page-content">
               <div class="portlet-body">
                  <?php if (isset($check_permission_update) && $check_permission_update == 'Y') { ?>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="portlet light">
                           <div class="portlet-title">
                              <div class="caption font-blue">
                                 <i class="fa fa-plus-circle font-blue"></i>
                                 <span class="caption-subject bold uppercase"> BOQ Variable Discount</span>
                              </div>
                           </div>
                           <div class="portlet-body form">
                              <form action="save_boq_variable_discount" enctype="multipart/form-data" id="save_boq_variable_discount" method="post" class="horizontal-form">
                                 <?php if (isset($variable_discount_items_data) && !empty($variable_discount_items_data)) { ?>
                                    <input type="hidden" name="boq_items_id" value="<?php echo(isset($variable_discount_items_data[0]->boq_items_id) && !empty($variable_discount_items_data[0]->boq_items_id))?$variable_discount_items_data[0]->boq_items_id:'0'?>" id="boq_items_id">
                                    <input type="hidden" name="is_edit" value="<?php echo(isset($variable_discount_items_data[0]->variable_discount_tid) && !empty($variable_discount_items_data[0]->variable_discount_tid))?$variable_discount_items_data[0]->variable_discount_tid:'0'?>">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Select Project <span class="required" aria-required="true" style="color:red">*</span></label>
                                                            <input type="text"  class="form-control" readonly value="<?php echo(isset($project_data->bp_code) && !empty($project_data->bp_code))?$project_data->bp_code.' ('.$project_data->customer_name.')':'0'?>"  name="project_name" placeholder="Select Project Code" required>
                                                            <input type="hidden" class="form-control" id="project_id" name="project_id" value="<?php echo(isset($variable_discount_items_data[0]->project_id) && !empty($variable_discount_items_data[0]->project_id))?$variable_discount_items_data[0]->project_id:'0'?>">
                                                            <span id="projlaoding"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Select BOQ Items <span class="required" aria-required="true" style="color:red">*</span></label>
                                                            <input type="text" class="form-control" readonly value="<?php echo(isset($boq_items_data->boq_code) && !empty($boq_items_data->boq_code))?$boq_items_data->boq_code.' ('.$boq_items_data->item_description.')':'0'?>"  name="" placeholder="Select Project Code" required>
                                                            <input type="hidden" id="boq_items" name="boq_items" placeholder="" value="<?php echo(isset($boq_items_data->boq_code) && !empty($boq_items_data->boq_code))?$boq_items_data->boq_code:'0'?>" required>
                                                            <span id="projlaoding"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="agent_id">Basic Rate <span class="required" aria-required="true" style="color:red">*</span></label>
                                                            <input type="text" class="form-control" readonly placeholder="Basic Rate" value="<?php echo(isset($boq_items_data->rate_basic) && !empty($boq_items_data->rate_basic))?$boq_items_data->rate_basic:'0'?>" name="basic_rate" id="basic_rate"  readonly>
                                                            <span id="projlaoding"></span>
                                                        </div>
                                                    </div> 
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <div id="displayBoqItems" style="margin-top:15px;">
                                                    
                                                    <div class="mt-2" style="margin-top: 1rem;margin-bottom: 1rem;">
                                                        <h5 style="font-weight:600;">Add Variable Discount Rate</h5>
                                                    </div>
                                                    <table width="100%" id="boqitmdiscountdisplay" class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th style="min-width: 80px;width:200px;">From Quantity</th>
                                                                <th style="min-width: 200px;width:200px;">To Quantity</th>
                                                                <th style="min-width: 40px;width:200px;">Base Rates</th>
                                                                <th style="min-width: 40px;width:100px;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php if(isset($variable_discount_items_data) && !empty($variable_discount_items_data)){ $i=0;foreach($variable_discount_items_data as $key){ ?>
                                                            <tr role="row" class="odd">
                                                                <td>
                                                                    <input type="number" class="form-control" id="variable_disc_from<?php echo $i; ?>"  value="<?php echo(isset($key->from_quantity) && !empty($key->from_quantity))?$key->from_quantity:'-'?>" name="variable_disc_from[]" placeholder="From Quantity" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control" id="variable_disc_to<?php echo $i; ?>" value="<?php echo(isset($key->to_quantity) && !empty($key->to_quantity))?$key->to_quantity:'-'?>" name="variable_disc_to[]" placeholder="To Quantity" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control" id="variable_disc_base_rate<?php echo $i; ?>" value="<?php echo(isset($key->rate_basic) && !empty($key->rate_basic))?$key->rate_basic:'-'?>" name="variable_disc_base_rate[]" placeholder="Base Rates" style="font-size: 12px;">
                                                                </td>    
                                                                
                                                                <td style="text-align: center;vertical-align: middle;"><div class="addDeleteButton"><span class="tooltips deleteParticularRow tr<?php echo $i; ?>" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span></div></td>
                                                              
                                                            </tr>
                                                            <?php $i++;} } ?>
                                                            <tr role="row" class="odd">
                                                                <td>
                                                                    <input type="number" class="form-control invaliderrorexcept" id="variable_disc_from" name="variable_disc_from[]" placeholder="From Quantity" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control invaliderrorexcept" id="variable_disc_to" name="variable_disc_to[]" placeholder="To Quantity" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control invaliderrorexcept" id="variable_disc_base_rate" name="variable_disc_base_rate[]" placeholder="Base Rates" style="font-size: 12px;">
                                                                </td>    
                                                                
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    <div class="addDeleteButton">
                                                                        <span class="tooltips addVariableDiscountData" data-placement="top" data-original-title="Add" style="cursor: pointer;">
                                                                            <i class="fa fa-plus" style="color:#000"></i></span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                    </div>

                                                </div>
                                            </div>
                                    <?php } else { ?>
                                    <input type="hidden" name="boq_items_id" value="" id="boq_items_id">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Select Project <span class="required" aria-required="true" style="color:red">*</span></label>
                                                            <input type="text" class="form-control allprojectsdiscount" id="project_id" name="project_id" placeholder="Select Project Code" required>
                                                            <span id="projlaoding"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Select BOQ Items <span class="required" aria-required="true" style="color:red">*</span></label>
                                                            <input type="text" class="form-control allitems" id="boq_items" name="boq_items" placeholder="Select BOQ Items" required>
                                                            <span id="projlaoding"></span>
                                                            <span class="boq-valid-item error" style="display:none">BOQ Variable Discount approval is pending!</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="agent_id">Basic Rate <span class="required" aria-required="true" style="color:red">*</span></label>
                                                            <input type="text" class="form-control" placeholder="Basic Rate" name="basic_rate" id="basic_rate"  readonly>
                                                            <span id="projlaoding"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <div id="displayBoqItems" style="margin-top:15px;">
                                                    
                                                    <div class="mt-2" style="margin-top: 1rem;margin-bottom: 1rem;">
                                                        <h5 style="font-weight:600;">Add Variable Discount Rate</h5>
                                                    </div>
                                                    <table width="100%" id="boqitmdiscountdisplay" class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th style="min-width: 80px;width:200px;">From Quantity</th>
                                                                <th style="min-width: 200px;width:200px;">To Quantity</th>
                                                                <th style="min-width: 40px;width:200px;">Base Rates</th>
                                                                <th style="min-width: 40px;width:100px;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        
                                                            <tr role="row" class="odd">
                                                                <td>
                                                                    <input type="number" class="form-control invaliderrorexcept" id="variable_disc_from" name="variable_disc_from[]" placeholder="From Quantity" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control invaliderrorexcept" id="variable_disc_to" name="variable_disc_to[]" placeholder="To Quantity" style="font-size: 12px;">
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control invaliderrorexcept" id="variable_disc_base_rate" name="variable_disc_base_rate[]" placeholder="Base Rates" style="font-size: 12px;">
                                                                </td>    
                                                                
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    <div class="addDeleteButton">
                                                                        <span class="tooltips addVariableDiscountData" data-placement="top" data-original-title="Add" style="cursor: pointer;">
                                                                            <i class="fa fa-plus" style="color:#000"></i></span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    </div>
                                                    </div>

                                                </div>
                                            </div>
                                 <?php } ?>
                                 <div class="form-actions right">
                                    <button type="button" class="btn btn-danger cancel" onclick="location.href = '<?php echo base_url(); ?>boq-variable-discount';" title="click To Cancel"> Cancel</button>
                                    <button type="button" name="submit_btn" class="btn green variable_discount_save" title="click To Save" rel="0">Sent to Approval</button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php } else { ?>
                  <input type="hidden" name="project_id" id="project_id" value="0">
                  <?php } ?>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption font-blue">
                                    <i class="fa fa-bars font-blue"></i>
                                    <span class="caption-subject bold uppercase">BOQ Variable Discount List</span>
                                </div>
                            </div>
                           <div class="portlet-body">
                                <table width="100%" id="boqvariabledisclist" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="vertical-align: top;">BOQ<br>Sr No</th>
                                            <th scope="col" style="vertical-align: top;">BP Code</th>
                                            <th scope="col" style="vertical-align: top;">Item Description</th>
                                            <th scope="col" style="vertical-align: top;width:100px;">Action</th>
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
      <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
      <?php $this->load->view('common/footer'); ?>
      <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/select2/select2.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/admin/pages/scripts/components-pickers.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/additional-methods.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/lib/jquery.form.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine.js"></script>
      <script src="<?php echo base_url(); ?>assets/site/js/jquery.validationEngine-en.js"></script>
      <script src="<?php echo base_url(); ?>js/common.js?<?php echo date('Ymd H:i:s'); ?>" type="text/javascript"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>
      <!-- <script src="<?php echo base_url(); ?>js/select2pagination.js?<?php echo date('Ymd H:i:s'); ?>"></script> -->
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
      <!-- <script src="<?php echo base_url(); ?>js/boq-except.js?<?php echo date('Ymd H:i:s'); ?>"></script> -->
      <script src="<?php echo base_url(); ?>js/variable-discount.js?<?php echo date('Ymd H:i:s'); ?>"></script>
      <script>
         jQuery(document).ready(function() {
         
             Metronic.init(); // init metronic core components
         
             Layout.init();
         
             ComponentsPickers.init();
         
         });
      </script>
   </body>
</html>