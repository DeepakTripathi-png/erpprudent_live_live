<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title>Type of Expense | <?php echo project_name; ?> </title>
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
  <style>
  .error{
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
  .pt-2{
    padding-top: 10px;
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
                    <span class="caption-subject bold uppercase">Type of expense</span>
                  </div>
                </div>
                <div class="portlet-body form">
                  <div class="alert-container hide">
                  </div>
                  <form action="javascript:void(0)" enctype="multipart/form-data" id="save_head" method="post" class="horizontal-form">
                    <div class="form-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Head <span class="require" aria-required="true" style="color:red">*</span></label>
                            <div class="input-icon right">
                              <i class="fa"></i>
                              <input type="text" class="form-control" name="head_name"  id="head_name"  placeholder="Enter head name">
                              <input type="hidden" class="form-control" name="head_id"  id="head_id"  >
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6 hide">
                          <div class="form-group">
                            <label class="control-label">Voucher Type <span class="require" aria-required="true" style="color:red">*</span></label>
                            <div class="input-icon right">
                              <i class="fa"></i>
                              <select class="form-select form-control" name="voucher_type" id="voucher_type" aria-label="Default select example">
                                <option value="">Select Voucher Type</option>
                                <option value="Office Expense">Office Expense</option>
                                <option value="Project Expense">Project Expense</option>

                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Is this an asset? <span class="require" aria-required="true" style="color:red">*</span></label>
                            <div class="d-flex align-items-center">
                              <div class="form-check form-check-inline me-2">
                                <input class="form-check-input" type="radio" name="is_asset" id="inlineRadio1" value="Yes">
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_asset" id="inlineRadio2" value="No">
                                <label class="form-check-label" for="inlineRadio2">No</label>
                              </div>
                            </div>
                          </div>
                        </div>



                      </div>
                    </div>
                    <div class="form-actions right">
                      <!-- <a href="<?php echo base_url();?>category_list" class="btn blue" style="float: left;">Back</a> -->
                      <button type="button" class="btn btn-danger cancel clearData" title="click To Cancel"> Cancel</button>
                      <button type="submit" class="btn green common_save" title="click To Save" rel=""><i class="fa fa-dot-circle-o"></i> Save</button>
                      <!-- <button type="submit" class="btn green common_save" title="click To Save" rel="<?php echo(isset($category_data->category_id) && !empty($category_data->category_id))?$category_data->category_id:''?>"><i class="fa fa-dot-circle-o"></i> <?php if(isset($category_data->category_id) && !empty($category_data->category_id)) {echo 'Update';} else { echo 'Save'; }?></button> -->
                    </div>
                  </form>
                </div>

                <div class="portlet-body">
                  <table class="table table-striped table-bordered table-hover" id="head_list">
                    <thead>
                      <tr>
                        <th class="font-blue-madison bold" style="width:10%;">Sr. No.</th>
                        <th class="font-blue-madison bold"> Head </th>
                        <th class="font-blue-madison bold"> Assest </th>
                        <th class="font-blue-madison bold" style="text-align: center;"> Action </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(isset($data) && !empty($data))
                      { $i = 1;
                        foreach ($data as $val)
                        {?>
                          <tr>
                            <td>
                              <?php echo $i++; ?>
                            </td>
                            <td>
                              <?php echo(isset($val['head']) && !empty($val['head']))?$val['head']:'';?>
                            </td>
                            <td>
                              <?php echo(isset($val['is_asset']) && !empty($val['is_asset']))?$val['is_asset']:'';?>
                            </td>

                            <td style="text-align: center; vertical-align: middle;">

                              <a href="javascript:;" class="edit tooltips editRecord" rel="<?php echo(isset($val['head_id']) && !empty($val['head_id']))?$val['head_id']:'';?>" title="Edit Head" rev="edit_head"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>


                              &nbsp;<a href="javascript:;" class="delete tooltips deleteRecord" rel="<?php echo(isset($val['head_id']) && !empty($val['head_id']))?$val['head_id']:'';?>" title="Delete Head" rev="delete_head"><i class="fa fa-trash-o" style="color:#a94442; font-size: 15px;"></i></a>

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
  <script src="<?php echo base_url(); ?>js/head.js"></script>
  <script>
  jQuery(document).ready(function() {
    Metronic.init(); // init metronic core components
    Layout.init();
    ComponentsPickers.init();
    // TableAdvanced.init();
  });
  </script>
</body>
</html>
