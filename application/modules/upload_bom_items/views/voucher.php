<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title>Voucher System | <?php echo project_name; ?> </title>
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
  <script src="https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js"></script>
  <link href="<?php echo base_url(); ?>assets/css/createp.css?<?php echo date('Y-m-d H:i:s'); ?>" rel="stylesheet" type="text/css" />

  <style type="text/css">
  table.dataTable thead th, table.dataTable thead td {
    padding: 10px 15px !important;
    border-bottom: 0px solid #111;
    text-align: left;
    font-weight: 600;
  }
  .dataTables_filter{
    float:right;
  }
  .has-error{
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
  .align {
    vertical-align: middle!important;
    text-align: center;
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
  .border-bottom{
    border-bottom: 1px solid #dddddd;
  }
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
input[type="file"] + .error {
    color: red !important;
    font-weight: 500 !important;
    background: none !important;
}
#voucher_form .col-md-4{
  height: 92px;
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
                    <i class="fa fa-bars font-blue"></i>
                    <span class="caption-subject bold uppercase"><?php echo (isset($bp_code) && !empty($bp_code)) ? '(#' . $bp_code . ')' : '' ?> Budget System</span>
                  </div>
                </div>

                <div class="portlet-body">

                <div class="alert-container hide">
                </div>

                <form action="javascript:void(0)" enctype="multipart/form-data" id="voucher_form" method="post">
        
                  <input type="hidden" name="voucher_id"  value="">
                  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">


                  <div class="row mb-5">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Budget Type <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <select class="form-control" aria-label="Default select example" id="voucher_type" name="voucher_type">
                            <option value=""> select Budget Type</option>
                            <option value="Office Expense">Office Budget</option>
                            <option value="Project Expense">Project Budget</option>
                        </select>
                      </div>
                    </div>
                  </div>
                
                  <div class="row mb-5 project_expense hide" id="project_dropdown">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Select Project <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <select  class="form-control allProjectDropDown" id="project_id" name="project_id">
                            <option value="">Select Project</option>
                        </select>
                        <!--<input type="text" class="form-control allprojects" id="project_id" name="project_id" placeholder="Select Project Code" required>-->
                        <!--<span id="projlaoding"></span>-->
                      </div>
                    </div>

                    <div class="col-md-4 hide">
                      <div class="form-group">
                        <label class="control-label">Head/Type Of Expense  <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <select class="form-control" aria-label="Default select example"  name="p_head" id="p_head_drop">
                            <option value="">Select Head/Type Of Expense</option>
                            <?php foreach ($project_expense_head as $key => $value) { ?>
                              <option value="<?php echo $value['head'] ?>"><?php echo $value['head'] ?></option>
                            <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 po_number_block">
                      <div class="form-group">
                        <label class="control-label">Po Number </label>
                        <select class="form-control" aria-label="Default select example"  name="po_number" id="po_number">
                            <option value="">Select Po Number</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Bom Code <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <select class="form-control" aria-label="Default select example"  name="bom_code" id="bom_code">
                            <option value="">Select Bom Code</option>
                            <!-- <?php foreach ($bom_project_expense as $key => $value) { 
                              if(!in_array($value['bpe_id'],$pending_bom_project_expense)){
                            ?>
                              <option value="<?php echo $value['bpe_id'] ?>" data-type="bom_project_expense"><?php echo $value['bom_code'] ?></option>
                            <?php 
                              } 
                            }
                            ?> -->
                        </select>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Description <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <input type="text" class="form-control "   id="description" name="description" placeholder="Enter Rate" readonly>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">QTY <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <input type="text" class="form-control onlyNumericInput" name="p_qty" id="qty" data-max="0">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Rate <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <input type="text" class="form-control onlyNumericInput" name="p_rate" id="rate" readonly>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Amount <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <input type="text" class="form-control onlyNumericInput" name="p_amount" id="amount" data-max="0" readonly>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Budget Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <input type="date" class="form-control" name="p_voucher_date" placeholder="0.00" required>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Attachment </label>
                        <input type="file"  name="p_attachment">
                        <input type="hidden" name="hidden_p_attachment" value="">
                      </div>
                    </div>

                  </div>

                  <for class="row mb-5 office_expense hide">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Head/Type Of Expense  <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <!-- <input type="text" class="form-control "  name="o_head" placeholder="Enter Head" required> -->
                        <select class="form-control" aria-label="Default select example"  name="o_head" id="o_head_drop">
                            <option value="">Select Head/Type Of Expense</option>
                            </select>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Amount <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <input type="text" class="form-control onlyNumericInput" name="o_amount" placeholder="0.00" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Financial Year<span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <select class="form-control" aria-label="Default select example"  name="financial_year" id="financial_year">
                            <option value="">Select financial Year</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Budget Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                        <input type="date" class="form-control" name="o_voucher_date"  required>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Attachment </label>
                        <input type="file"  name="o_attachment">
                        <input type="hidden" name="hidden_o_attachment" >
                      </div>
                    </div>
                  
                  </div>

                  <div class="form-actions" style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-danger cancel" onclick="location.href = 'voucher';" title="click To Cancel"> Cancel</button>
                        <button type="submit" class="btn green " title="click To Save" rel="0"><i class="fa fa-dot-circle-o"></i> Save</button>
                    </div>
                </form>
                <hr>

                  <table width="100%" id="voucher_list" class="table table-striped table-bordered table-hover ">
                    <thead>
                      <tr>
                        <th scope="col" style="vertical-align: top;">Sr.no</th>
                        <th scope="col" style="vertical-align: top;">Budget System Type</th>
                        <th scope="col" style="vertical-align: top;">BP Code</th>
                        <th scope="col" style="vertical-align: top;">Type Expense / Head</th>
                        <th scope="col" style="vertical-align: top;">Qty</th>
                        <th scope="col" style="vertical-align: top;">Rate</th>
                        <th scope="col" style="vertical-align: top;">Amount</th>
                        <th scope="col" style="vertical-align: top;">Budget Date</th>
                        <th scope="col" style="vertical-align: top;">Status </th>
                        <th scope="col" style="vertical-align: top;">Action</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      if (count($data) > 0) {
                        foreach ($data as $key => $value) {  ?>
                          <tr>
                            <th><?php echo $key + 1 ?></th>
                           <?php if($value['type'] == 'Transfer'){
                               $type = "- (Stock Movement)";
                           }else{
                               $type = "";
                           }
                           ?>
                            <td><?php echo !empty($value['voucher_type']) ? $value['voucher_type'].$type : '-' ?></td>
                            <td><?php echo !empty($value['bp_code']) ? $value['bp_code'] : '-' ?></td>
                            <td><?php echo !empty($value['head']) ? $value['head'].' ('.$value['financial_year'].")" : '-' ?></td>
                            <td><?php echo !empty($value['qty']) ? $value['qty'] : '-' ?></td>
                            <td><?php echo !empty($value['rate']) ? $value['rate'] : '-' ?></td>
                            <td><?php echo !empty($value['amount']) ? $value['amount'] : '-' ?></td>
                            <td><?php echo !empty($value['voucher_date']) ? $value['voucher_date'] : '-' ?></td>
                            <td>
                          
                              <?php
                              if (!empty($value['status'])) {
                                if ($value['status'] == 'approved') {
                                  echo '<span style="color:green;font-weight:600;">Approved</span>';
                                } elseif ($value['status'] == 'pending') {
                                  echo '<span style="color:orange;font-weight:600;">Pending</span>';
                                } elseif ($value['status'] == 'reject') {
                                  echo '<span style="color:red;font-weight:600;">Rejected</span>';
                                }
                              } else {
                                echo '-';
                              }
                              ?>
                            </td>
                            <td>
                            <a href="javascript:void(0);" title="Download Voucher"
                           data-voucher-id="<?php echo $value['voucher_id']; ?>"
                           class="download-voucher-excel"
                           style="margin-right: 8px;">
                            <i class="fa fa-download" style="color:#000; font-size:15px;"></i>
                        </a>
                        <?php
                        $open_doc_url = $this->config->item("base_url") . "generate_voucher_pdf?voucher_id=" . $value['voucher_id'] ;
                        ?>
                        <a class="voucher"
                           href="<?php echo $open_doc_url; ?>"
                           data-voucher-id="<?php echo $value['voucher_id']; ?>"
                           style="margin-right: 8px;">
                           <i class="fa fa-file-text" style="color:#000; font-size:15px;"></i>
                        </a>
                            <?php
                              if (!empty($value['status'])) {
                                if ($value['status'] == 'reject') { ?>
                                <a href="javascript:;" 
                                    class="edit_voucher_data tooltips" 
                                    title="Edit Record" 
                                    data-voucher-id="<?php echo $value['voucher_id']; ?>" 
                                    rev="edit_voucher_data" 
                                    data-project_id="<?php echo base64_encode($value['project_id']); ?>"  
                                    data-original-title="Edit Record">
                                    <i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i>
                                </a>

                                 <?php }} ?>

                            <?php
                              if (!empty($value['status'])) {
                                if ($value['status'] != 'approved') { ?>
                            <select class="statusselectbom approve_voucher_data" 
                        id="statusselect<?php echo $value['voucher_id']; ?>" 
                        rel="<?php echo $value['voucher_id']; ?>" 
                        rev="approve_voucher_data" 
                        data-project_id="<?php echo base64_encode($value['project_id']); ?>" 
                        data-voucher-id="<?php echo $value['voucher_id']; ?>">
                    <option class="statusselectoption" value="pending" <?php echo ($value['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option class="statusselectoption" value="approved" <?php echo ($value['status'] == 'approved') ? 'selected' : ''; ?>>Approve</option>
                    <option class="statusselectoption" value="reject" <?php echo ($value['status'] == 'reject') ? 'selected' : ''; ?>>Reject</option>
                </select>
                <?php }} ?>
             </td>
                          </tr>
                        <?php }
                      }
                        ?>
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
    <script src="<?php echo base_url();?>js/voucher.js" type="text/javascript"></script>

    <script>
    jQuery(document).ready(function() {
      Metronic.init(); // init metronic core components
      Layout.init();
      ComponentsPickers.init();
    });
    </script>

  </body>
  </html>
