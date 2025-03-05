<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo(isset($update_user_id) && !empty($update_user_id))?'Update':'Add'?> Team Member | <?php echo project_name; ?> </title>
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
        <style>.has-errorp{border: 1px solid #a94442;}</style>
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
                            <div class="caption font-blue"> <i class="fa fa-plus-circle font-blue"></i> <span class="caption-subject bold uppercase"><?php echo(isset($update_user_id) && !empty($update_user_id))?'Update':'Add'?> Team Member</span> </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="save_user" id="save_user" class="horizontal-form" method="post" enctype="multipart/form-data">
                                <div class="form-body">
                                    <input type="hidden" name="update_user_id" id="update_user_id" value="<?php echo(isset($update_user_id) && !empty($update_user_id))?$update_user_id:'0'?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Employee No. <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                <div class="input-icon right"><i class="fa"></i>
                                                <input type="text" class="form-control duplicate" name="emp_no" data-tbl="tbl_user" data-p_key="user_id" data-where="emp_no" rel="<?php echo(isset($update_user_id) && !empty($update_user_id))?$update_user_id:'0'?>" value="<?php echo(isset($user_data->emp_no) && !empty($user_data->emp_no))?$user_data->emp_no:''?>" placeholder="Employee No." required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="">Role <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                <div class="input-icon">
                                                    <select class="form-control select2me" name="role_id" required>
                                                        <option value="">Select</option>
                                                        <?php if(isset($role_data) && !empty($role_data)){
                                                            foreach ($role_data as $key){ ?>
                                                            <option value="<?php echo $key->role_id?>" <?php echo (isset($user_data->role_id) && !empty($user_data->role_id) && ($user_data->role_id==$key->role_id))?'selected="selected"':'';?>><?php echo $key->role_name;?></option>
                                                            <?php } } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="">Date of Joining <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
                                                    <input type="text" name="joining_date" id="joining_date" class="form-control" readonly="" placeholder="Date of Joining" value="<?php echo(isset($user_data->joining_date) && !empty($user_data->joining_date))?date("d-F-Y", strtotime($user_data->joining_date)):''?>">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">Part A – Personal Details</h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group"> 
                                                    <label class="">Name <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                    <div class="input-icon"> 
                                                    <select class="form-control select2me" name="name_type" required>
                                                        <option value="Mrs" <?php echo (isset($user_data->name_type) && !empty($user_data->name_type) && ($user_data->name_type=='Mrs'))?'selected="selected"':'';?>>Mrs</option>
                                                        <option value="Ms" <?php echo (isset($user_data->name_type) && !empty($user_data->name_type) && ($user_data->name_type=='Ms'))?'selected="selected"':'';?>>Ms</option>
                                                        <option value="Mr" <?php echo (isset($user_data->name_type) && !empty($user_data->name_type) && ($user_data->name_type=='Mr'))?'selected="selected"':'';?>>Mr</option>
                                                    </select> 
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>First Name <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right"><i class="fa"></i>
                                                        <input type="text" class="form-control " name="fullname" value="<?php echo(isset($user_data->fullname) && !empty($user_data->fullname))?$user_data->fullname:''?>" placeholder="First Name" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Middle Name <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right"><i class="fa"></i>
                                                        <input type="text" class="form-control " name="m_name" value="<?php echo(isset($user_data->m_name) && !empty($user_data->m_name))?$user_data->m_name:''?>" placeholder="Middle Name" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Surname <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right"><i class="fa"></i>
                                                        <input type="text" class="form-control " name="s_name" value="<?php echo(isset($user_data->s_name) && !empty($user_data->s_name))?$user_data->s_name:''?>" placeholder="Surname" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group"> 
                                                    <label class="">Blood Group <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                    <div class="input-icon"> 
                                                    <select class="form-control select2me" name="blood_group" required>
                                                        <option value="">--Select--</option>
                                                        <option value="A+" <?php echo (isset($user_data->blood_group) && !empty($user_data->blood_group) && ($user_data->blood_group=='A+'))?'selected="selected"':'';?>>A+</option>
                                                        <option value="A-" <?php echo (isset($user_data->blood_group) && !empty($user_data->blood_group) && ($user_data->blood_group=='A-'))?'selected="selected"':'';?>>A-</option>
                                                        <option value="B+" <?php echo (isset($user_data->blood_group) && !empty($user_data->blood_group) && ($user_data->blood_group=='B+'))?'selected="selected"':'';?>>B+</option>
                                                        <option value="B-" <?php echo (isset($user_data->blood_group) && !empty($user_data->blood_group) && ($user_data->blood_group=='B-'))?'selected="selected"':'';?>>B-</option>
                                                        <option value="O+" <?php echo (isset($user_data->blood_group) && !empty($user_data->blood_group) && ($user_data->blood_group=='O+'))?'selected="selected"':'';?>>O+</option>
                                                        <option value="O-" <?php echo (isset($user_data->blood_group) && !empty($user_data->blood_group) && ($user_data->blood_group=='O-'))?'selected="selected"':'';?>>O-</option>
                                                        <option value="AB+" <?php echo (isset($user_data->blood_group) && !empty($user_data->blood_group) && ($user_data->blood_group=='AB+'))?'selected="selected"':'';?>>AB+</option>
                                                        <option value="AB-" <?php echo (isset($user_data->blood_group) && !empty($user_data->blood_group) && ($user_data->blood_group=='AB-'))?'selected="selected"':'';?>>AB-</option>
                                                    </select> 
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Tel. No. <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right"><i class="fa"></i>
                                                        <input type="text" class="form-control duplicate" name="mobile" data-tbl="tbl_user" data-p_key="user_id" data-where="mobile" rel="<?php echo(isset($update_user_id) && !empty($update_user_id))?$update_user_id:'0'?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($user_data->mobile) && !empty($user_data->mobile))?$user_data->mobile:''?>" placeholder="Tel. No." required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="">Date of Birth <span class="required" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
                                                            <input type="text" name="dob" id="dob" class="form-control" readonly="" placeholder="Date of Birth" value="<?php echo(isset($user_data->dob) && !empty($user_data->dob))?$user_data->dob:''?>">
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                                            </span>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group"> 
                                                    <label>Marital Status <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                    <div class="input-icon"> 
                                                    <select class="form-control select2me" name="marital_status" required>
                                                        <option value="">--Select--</option>
                                                        <option value="Married"  <?php echo (isset($user_data->marital_status) && !empty($user_data->marital_status) && ($user_data->marital_status=="Married"))?'selected="selected"':'';?>>Married</option>
                                                        <option value="Unmarried" <?php echo (isset($user_data->marital_status) && !empty($user_data->marital_status) && ($user_data->marital_status=="Unmarried"))?'selected="selected"':'';?>>Unmarried</option>
                                                        <option value="Divorced" <?php echo (isset($user_data->marital_status) && !empty($user_data->marital_status) && ($user_data->marital_status=="Divorced"))?'selected="selected"':'';?>>Divorced</option>
                                                    </select> 
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="">Local Home Address <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <textarea rows="2" type="text" class="form-control" name="home_addr" id="home_addr" placeholder="Local Home Address" required><?php echo(isset($user_data->home_addr) && !empty($user_data->home_addr))?$user_data->home_addr:''?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="">Native Place Address <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <textarea rows="2" type="text" class="form-control" name="native_addr" id="native_addr" placeholder="Native Place Address" required><?php echo(isset($user_data->native_addr) && !empty($user_data->native_addr))?$user_data->native_addr:''?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="<?php echo(isset($user_data->home_addr_proof) && !empty($user_data->home_addr_proof))?'':'control-label' ?>">Local Home Address Proof <br> (Electricity bill, Rent Agreement, Aadhaar) <?php echo(isset($user_data->home_addr_proof) && !empty($user_data->home_addr_proof))?'':'<span class="require" aria-required="true" style="color:#a94442">*</span>' ?></label>
                                                            <input type="file" name="home_addr_proof" id="home_addr_proof" class="home_addr_proof" <?php echo(isset($user_data->home_addr_proof) && !empty($user_data->home_addr_proof))?'':'required' ?> />
                                                            <?php if(isset($user_data->home_addr_proof) && !empty($user_data->home_addr_proof)){ ?>
                                                            <a href="<?php echo base_url();?>uploads/home_addr_proof/<?php echo $user_data->home_addr_proof; ?>" download>Download</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="<?php echo(isset($user_data->native_addr_proof) && !empty($user_data->native_addr_proof))?'':'control-label' ?>">Native Place Address Proof <br> (Electricity bill, Rent Agreement, Aadhaar) <?php echo(isset($user_data->native_addr_proof) && !empty($user_data->native_addr_proof))?'':'<span class="require" aria-required="true" style="color:#a94442">*</span>' ?></label>
                                                            <input type="file" name="native_addr_proof" id="native_addr_proof" class="native_addr_proof" <?php echo(isset($user_data->native_addr_proof) && !empty($user_data->native_addr_proof))?'':'required' ?> />
                                                            <?php if(isset($user_data->native_addr_proof) && !empty($user_data->native_addr_proof)){ ?>
                                                            <a href="<?php echo base_url();?>uploads/native_addr_proof/<?php echo $user_data->native_addr_proof; ?>" download>Download</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="">Emergency Contact Details <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <textarea rows="2" type="text" class="form-control" name="emergency_contact" id="emergency_contact" placeholder="Emergency Contact Details" required><?php echo(isset($user_data->emergency_contact) && !empty($user_data->emergency_contact))?$user_data->emergency_contact:''?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>How long have you lived at this address? <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group"> 
                                                        <select class="form-control select2me" name="lived_days">
                                                            <?php for($i=0;$i<=60;$i++){ ?>
                                                            <?php if($i > 1){ ?>
                                                            <option value="<?php echo $i; ?>"  <?php echo (isset($user_data->lived_days) && !empty($user_data->lived_days) && ($user_data->lived_days==$i))?'selected="selected"':'';?>><?php echo $i; ?> Years</option>
                                                            <?php }else{ ?>
                                                            <option value="<?php echo $i; ?>"  <?php echo (isset($user_data->lived_days) && !empty($user_data->lived_days) && ($user_data->lived_days==$i))?'selected="selected"':'';?>><?php echo $i; ?> Year</option>
                                                            <?php } ?>
                                                            <?php } ?>
                                                        </select> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="">2nd Local Address for correspondence <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <textarea rows="2" type="text" class="form-control" name="local_addr" id="local_addr" placeholder="2nd Local Address for correspondence" required><?php echo(isset($user_data->local_addr) && !empty($user_data->local_addr))?$user_data->local_addr:''?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="">Permanent Address <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right"><i class="fa"></i>
                                                            <textarea rows="2" type="text" class="form-control" name="perm_addr" id="perm_addr" placeholder="Permanent Address" required><?php echo(isset($user_data->perm_addr) && !empty($user_data->perm_addr))?$user_data->perm_addr:''?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="<?php echo(isset($user_data->local_addr_proof) && !empty($user_data->local_addr_proof))?'':'control-label' ?>">2nd Local Address for correspondence Proof <br> (C/o address of relatives will) <?php echo(isset($user_data->local_addr_proof) && !empty($user_data->local_addr_proof))?'':'<span class="require" aria-required="true" style="color:#a94442">*</span>' ?></label>
                                                            <input type="file" name="local_addr_proof" id="local_addr_proof" class="local_addr_proof" <?php echo(isset($user_data->local_addr_proof) && !empty($user_data->local_addr_proof))?'':'required' ?>/>
                                                            <?php if(isset($user_data->local_addr_proof) && !empty($user_data->local_addr_proof)){ ?>
                                                            <a href="<?php echo base_url();?>uploads/local_addr_proof/<?php echo $user_data->local_addr_proof; ?>" download>Download</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="<?php echo(isset($user_data->perm_addr_proof) && !empty($user_data->perm_addr_proof))?'':'control-label' ?>">Permanent Address Proof <br> (Electricity bill, Rent Agreement, Aadhaar)  <?php echo(isset($user_data->perm_addr_proof) && !empty($user_data->perm_addr_proof))?'':'<span class="require" aria-required="true" style="color:#a94442">*</span>' ?></label>
                                                            <input type="file" name="perm_addr_proof" id="perm_addr_proof" class="perm_addr_proof" <?php echo(isset($user_data->perm_addr_proof) && !empty($user_data->perm_addr_proof))?'':'required' ?> />
                                                            <?php if(isset($user_data->perm_addr_proof) && !empty($user_data->perm_addr_proof)){ ?>
                                                            <a href="<?php echo base_url();?>uploads/perm_addr_proof/<?php echo $user_data->perm_addr_proof; ?>" download>Download</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="">Tel. No. 1 <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control " name="mobile1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($user_data->mobile1) && !empty($user_data->mobile1))?$user_data->mobile1:''?>" placeholder="Tel. No. 1" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="">Tel. No. 2 <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control " name="mobile2" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo(isset($user_data->mobile2) && !empty($user_data->mobile2))?$user_data->mobile2:''?>" placeholder="Tel. No. 2" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label class="">Email address 1 <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                 <input type="email" class="form-control " name="email" value="<?php echo(isset($user_data->email) && !empty($user_data->email))?$user_data->email:''?>" placeholder="Email address 1" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label class="">Email address 2 <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                 <input type="email" class="form-control " name="email1" value="<?php echo(isset($user_data->email1) && !empty($user_data->email1))?$user_data->email1:''?>" placeholder="Email address 2" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-md-3">

                                                        <div class="form-group">

                                                            <label class="">Nationality <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                 <input type="text" class="form-control " name="nationality" value="<?php echo(isset($user_data->nationality) && !empty($user_data->nationality))?$user_data->nationality:''?>" placeholder="Nationality" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-3">

                                                        <div class="form-group">

                                                            <label class="">Religion <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                 <input type="text" class="form-control " name="religion" value="<?php echo(isset($user_data->religion) && !empty($user_data->religion))?$user_data->religion:''?>" placeholder="Religion" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-4">

                                                        <div class="form-group">

                                                            <label class="">Language known <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                 <input type="text" class="form-control " name="language" value="<?php echo(isset($user_data->language) && !empty($user_data->language))?$user_data->language:''?>" placeholder="Language Known" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-2">

                                                        <div class="form-group">

                                                            <label class="">Mother Tongue <span class="require" aria-required="true" style="color:#a94442">*</span></label>

                                                            <div class="input-icon right">

                                                                 <i class="fa"></i>

                                                                 <input type="text" class="form-control " name="mother_tongue" value="<?php echo(isset($user_data->mother_tongue) && !empty($user_data->mother_tongue))?$user_data->mother_tongue:''?>" placeholder="Mother Tongue" required>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="">Driving License No.</label>
                                                            <div class="input-icon right"><i class="fa"></i>
                                                            <input type="text" class="form-control " name="drive_lic_no" value="<?php echo(isset($user_data->drive_lic_no) && !empty($user_data->drive_lic_no))?$user_data->drive_lic_no:''?>" placeholder="Driving License No.">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Validity Date </label>
                                                            <div class="input-group date date1"  data-date-format="dd-MM-yyyy">
                                                                <input type="text" name="drive_lic_date" id="drive_lic_date" class="form-control" readonly="" placeholder="Validity Date" value="<?php echo(isset($user_data->drive_lic_date) && !empty($user_data->drive_lic_date))?$user_data->drive_lic_date:''?>">
                                                                <span class="input-group-btn">
                                                                    <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                									    <div class="form-group">
                									        <label class="<?php echo(isset($user_data->drive_lic_proof) && !empty($user_data->drive_lic_proof))?'':'control-label' ?>">Driving License Proof</label>
                									        <input type="file" name="drive_lic_proof" id="drive_lic_proof" class="drive_lic_proof">
                									        <?php if(isset($user_data->drive_lic_proof) && !empty($user_data->drive_lic_proof)){ ?>
                                                            <a href="<?php echo base_url();?>uploads/drive_lic_proof/<?php echo $user_data->drive_lic_proof; ?>" download>Download</a>
                                                            <?php } ?>
                                                        </div>
                									 </div>
                								</div>
                								<div class="row">
                								    <div class="col-md-3">
                								        <div class="form-group">
                								            <label class="">Passport No.</label>
                								            <div class="input-icon right"><i class="fa"></i>
                								            <input type="text" class="form-control " name="passport_no" value="<?php echo(isset($user_data->passport_no) && !empty($user_data->passport_no))?$user_data->passport_no:''?>" placeholder="Passport No.">
                								            </div>
                								        </div>
                								    </div>
                								    <div class="col-md-3">
                								        <div class="form-group">
                								            <label class="">Date of Issue</label>
                								            <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-MM-yyyy">
                								                <input type="text" name="passport_date" id="passport_date" class="form-control" readonly="" placeholder="Date of Issue" value="<?php echo(isset($user_data->passport_date) && !empty($user_data->passport_date))?$user_data->passport_date:''?>">
                								                <span class="input-group-btn">
                								                    <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                								                </span>
                								            </div>
                								        </div> 
                								    </div>
                								    <div class="col-md-3">
                								        <div class="form-group">
                								            <label class="">Place of Issue</label>
                								            <div class="input-icon right"><i class="fa"></i>
                								            <input type="text" class="form-control " name="passport_place" value="<?php echo(isset($user_data->passport_place) && !empty($user_data->passport_place))?$user_data->passport_place:''?>" placeholder="Place of Issue">
                								            </div>
                								        </div>
                								    </div>
                								    <div class="col-md-3">
                								        <div class="form-group">
                								            <label class="">Expiry Date</label>
                								            <div class="input-group date date1" data-date-format="dd-MM-yyyy">
                								                <input type="text" name="passport_expiry" id="passport_expiry" class="form-control" readonly="" placeholder="Expiry Date" value="<?php echo(isset($user_data->passport_expiry) && !empty($user_data->passport_expiry))?$user_data->passport_expiry:''?>">		
                								                <span class="input-group-btn">
                								                    <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                								                </span>
                								            </div>
                								        </div> 
                								    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Passport Proof</label>
                                                            <input type="file" name="passport_proof" id="passport_proof" class="passport_proof"/>
                                                            <?php if(isset($user_data->passport_proof) && !empty($user_data->passport_proof)){ ?>
                                                            <a href="<?php echo base_url();?>uploads/passport_proof/<?php echo $user_data->passport_proof; ?>" download>Download</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="">Income-tax PAN <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" class="form-control " name="pan_no" value="<?php echo(isset($user_data->pan_no) && !empty($user_data->pan_no))?$user_data->pan_no:''?>" placeholder="Income-tax PAN" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="<?php echo(isset($user_data->pan_proof) && !empty($user_data->pan_proof))?'':'control-label' ?>">Income-tax PAN Proof <?php echo(isset($user_data->pan_proof) && !empty($user_data->pan_proof))?'':'<span class="require" aria-required="true" style="color:#a94442">*</span>' ?></label>
                                                            <input type="file" name="pan_proof" id="pan_proof" class="pan_proof" <?php echo(isset($user_data->pan_proof) && !empty($user_data->pan_proof))?'':'required' ?> />
                                                            <?php if(isset($user_data->pan_proof) && !empty($user_data->pan_proof)){ ?>
                                                            <a href="<?php echo base_url();?>uploads/pan_proof/<?php echo $user_data->pan_proof; ?>" download>Download</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Bank Name <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right"><i class="fa"></i>
                                                            <input type="text" class="form-control " name="bank_name" value="<?php echo(isset($user_data->bank_name) && !empty($user_data->bank_name))?$user_data->bank_name:''?>" placeholder="Bank Name" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Branch Name <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right"><i class="fa"></i>
                                                            <input type="text" class="form-control " name="branch_name" value="<?php echo(isset($user_data->branch_name) && !empty($user_data->branch_name))?$user_data->branch_name:''?>" placeholder="Branch Name" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Account No <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right"><i class="fa"></i>
                                                            <input type="text" class="form-control " name="acc_no" value="<?php echo(isset($user_data->acc_no) && !empty($user_data->acc_no))?$user_data->acc_no:''?>" placeholder="Account No" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="15" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row"> 
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>IFSC Code <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                            <div class="input-icon right"><i class="fa"></i>
                                                            <input type="text" class="form-control " name="ifsc_code" value="<?php echo(isset($user_data->ifsc_code) && !empty($user_data->ifsc_code))?$user_data->ifsc_code:''?>" placeholder="IFSC Code" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="<?php echo(isset($user_data->bank_acc_proof) && !empty($user_data->bank_acc_proof))?'':'control-label' ?>">Bank Account Proof <?php echo(isset($user_data->bank_acc_proof) && !empty($user_data->bank_acc_proof))?'':'<span class="require" aria-required="true" style="color:#a94442">*</span>' ?></label>
                                                            <input type="file" name="bank_acc_proof" id="bank_acc_proof" class="bank_acc_proof" <?php echo(isset($user_data->bank_acc_proof) && !empty($user_data->bank_acc_proof))?'':'required' ?> />
                                                            <?php if(isset($user_data->bank_acc_proof) && !empty($user_data->bank_acc_proof)){ ?>
                                                            <a href="<?php echo base_url();?>uploads/bank_acc_proof/<?php echo $user_data->bank_acc_proof; ?>" download>Download</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Part B – Family Background</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table width="100%" id="familytbl" class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th style="min-width: 30px;width:30px;">Relation <span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                    <th style="min-width: 150px;width:150px;">Name <span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                    <th style="min-width: 120px;width:120px;">DOB <span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                    <th style="min-width: 50px;width:50px;">Age <span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                    <th style="min-width: 150px;width:150px;">Education <span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                    <th style="min-width: 100px;width:100px;">Occupation <span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                    <th style="min-width: 10px;width:10px;">-</th>
                                                                </tr>
                                                            </thead>
                                                        <tbody>
                                                            <?php if(isset($user_family) && !empty($user_family)){
                                                                $f=0;foreach($user_family as $key){ ?>
                                                                <?php if($f > 0){ ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control" name="relation[]" id="relation<?php echo $f; ?>" value="<?php echo(isset($key->relation) && !empty($key->relation))?$key->relation:''; ?>" placeholder="Select" readonly="">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="f_name[]" id="f_name<?php echo $f; ?>" value="<?php echo(isset($key->f_name) && !empty($key->f_name))?$key->f_name:''; ?>" placeholder="Name" readonly="">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="f_dob[]" id="f_dob<?php echo $f; ?>" value="<?php echo(isset($key->f_dob) && !empty($key->f_dob))?date('d-m-Y',strtotime($key->f_dob)):''; ?>" placeholder="DOB" readonly="">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="f_age[]" value="<?php echo(isset($key->f_age) && !empty($key->f_age))?$key->f_age:''; ?>" id="f_age<?php echo $f; ?>" placeholder="Age" readonly="">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="f_education[]" value="<?php echo(isset($key->f_education) && !empty($key->f_education))?$key->f_education:''; ?>" id="f_education<?php echo $f; ?>" placeholder="Education" readonly="">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="f_occup[]" id="f_occup<?php echo $f; ?>" value="<?php echo(isset($key->f_occup) && !empty($key->f_occup))?$key->f_occup:''; ?>" placeholder="Occupation" readonly="">
                                                                    </td>
                                                                    <td>
                                                                        <div class="addDeleteButton">
                                                                            <span class="tooltips deleteFRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;">
                                                                                <i class="fa fa-trash-o"></i>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                           <?php $f++;} ?>
                                                                <?php if(isset($user_family[0]) && !empty($user_family[0])){ ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group"> 
                                                                        <select class="form-control invalidferror" name="relation[]" id="relation0" style="font-size: 13px;" required>
                                                                            <option value="">--Select--</option>
                                                                            <option value="Father" <?php echo(isset($user_family[0]->relation) && !empty($user_family[0]->relation) && $user_family[0]->relation == 'Father')?'selected':''; ?>>Father</option>
                                                                            <option value="Mother" <?php echo(isset($user_family[0]->relation) && !empty($user_family[0]->relation) && $user_family[0]->relation == 'Mother')?'selected':''; ?>>Mother</option>
                                                                            <option value="Sister" <?php echo(isset($user_family[0]->relation) && !empty($user_family[0]->relation) && $user_family[0]->relation == 'Sister')?'selected':''; ?>>Sister(s)</option>
                                                                            <option value="Brother" <?php echo(isset($user_family[0]->relation) && !empty($user_family[0]->relation) && $user_family[0]->relation == 'Brother')?'selected':''; ?>>Brother(s)</option>
                                                                            <option value="Spouse" <?php echo(isset($user_family[0]->relation) && !empty($user_family[0]->relation) && $user_family[0]->relation == 'Spouse')?'selected':''; ?>>Spouse</option>
                                                                            <option value="Children" <?php echo(isset($user_family[0]->relation) && !empty($user_family[0]->relation) && $user_family[0]->relation == 'Children')?'selected':''; ?>>Children</option>
                                                                        </select> 
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                        <input type="text" class="form-control" name="f_name[]" id="f_name0" value="<?php echo(isset($user_family[0]->f_name) && !empty($user_family[0]->f_name))?$user_family[0]->f_name:''; ?>" placeholder="Name" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                        <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                                                                            <input type="text" name="f_dob[]" id="f_dob0" value="<?php echo(isset($user_family[0]->f_dob) && !empty($user_family[0]->f_dob))?date('d-m-Y',strtotime($user_family[0]->f_dob)):''; ?>" class="form-control" readonly="" required placeholder="DOB">
                                                                            <span class="input-group-btn"><button class="btn default" type="button">
                                                                                <span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span>
                                                                                <i class="fa fa-calendar"></i></button>
                                                                            </span>
                                                                        </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                        <input type="text" class="form-control" name="f_age[]" value="<?php echo(isset($user_family[0]->f_age) && !empty($user_family[0]->f_age))?$user_family[0]->f_age:''; ?>" id="f_age0" placeholder="Age" readonly="" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control" name="f_education[]" value="<?php echo(isset($user_family[0]->f_education) && !empty($user_family[0]->f_education))?$user_family[0]->f_education:''; ?>" id="f_education0" placeholder="Education" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                        <input type="text" class="form-control" name="f_occup[]" id="f_occup0" value="<?php echo(isset($user_family[0]->f_occup) && !empty($user_family[0]->f_occup))?$user_family[0]->f_occup:''; ?>" placeholder="Occupation" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="addDeleteButton">
                                                                            <span class="tooltips addFRow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                                <?php }else{ ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group"> 
                                                                        <select class="form-control invalidferror" name="relation[]" id="relation0" required style="font-size: 13px;">
                                                                            <option value="">--Select--</option>
                                                                            <option value="Father">Father</option>
                                                                            <option value="Mother">Mother</option>
                                                                            <option value="Sister">Sister(s)</option>
                                                                            <option value="Brother">Brother(s)</option>
                                                                            <option value="Spouse">Spouse</option>
                                                                            <option value="Children">Children</option>
                                                                        </select> 
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                        <input  type="text" class="form-control invalidferror" name="f_name[]" id="f_name0" placeholder="Name"  style="font-size: 13px;" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                        <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                                                                            <input type="text" name="f_dob[]" id="f_dob0" class="form-control invalidferror" readonly="" required placeholder="DOB"  style="font-size: 13px;">
                                                                            <span class="input-group-btn">
                                                                                <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                                                            </span>
                                                                        </div>
                                                                        </div>
                                                                    </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                    <input type="number" class="form-control invalidferror" name="f_age[]" id="f_age0" placeholder="Age" maxlength="3" min="1"  style="font-size: 13px;" readonly required>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                    <input type="text" class="form-control invalidferror" name="f_education[]" id="f_education0" placeholder="Education"  style="font-size: 13px;" required>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                    <input type="text" class="form-control invalidferror" name="f_occup[]" id="f_occup0" placeholder="Occupation"  style="font-size: 13px;" required>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="addDeleteButton">
                                                                        <span class="tooltips addFRow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                           <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <p id="invalidferrorid" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Part C – Educational Details (List in reverse order starting from highest/professional qualification to X Std.)</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table width="100%" id="edutabel" class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th style="min-width: 150px;width:150px;">Name of School/College/<br>University <span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                    <th style="min-width: 115px;width:115px;">Year of <br> Passing <span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                    <th style="min-width: 30px;width:30px;">Degree/ <br> Diploma <span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                    <th style="min-width: 200px;width:200px;">Specialized <br> Subject <span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                    <th style="min-width: 30px;width:30px;">Percentage <br>Obtained <span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                    <th style="min-width: 10px;width:10px;">-</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if(isset($user_education) && !empty($user_education)){ ?>
                                                                <?php $e=0;foreach($user_education as $key){ ?>
                                                                <?php if($e>0){ ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control invalideduerror" name="college[]" id="college<?php echo $e; ?>" placeholder="Name of School/College/University" value="<?php echo(isset($key->college) && !empty($key->college))?$key->college:''; ?>" id="f_age<?php echo $f; ?>" readonly = "" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control invalideduerror" id="passing_year<?php echo $e; ?>" name="passing_year[]" value="<?php echo(isset($key->passing_year) && !empty($key->passing_year))?date('d-m-Y',strtotime($key->passing_year)):''; ?>" placeholder="Year of Passing" readonly = "" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control invalideduerror" id="degree_diploma<?php echo $e; ?>" name="degree_diploma[]" value="<?php echo(isset($key->degree_diploma) && !empty($key->degree_diploma))?$key->degree_diploma:''; ?>" placeholder="Degree/Diploma" readonly = "" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control invalideduerror" id="special_sub<?php echo $e; ?>" name="special_sub[]" value="<?php echo(isset($key->special_sub) && !empty($key->special_sub))?$key->special_sub:''; ?>" placeholder="Specialized Subject" readonly = "" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control invalideduerror" id="percent_obtain<?php echo $e; ?>" name="percent_obtain[]" value="<?php echo(isset($key->percent_obtain) && !empty($key->percent_obtain))?$key->percent_obtain:''; ?>" placeholder="Percentage Obtained" readonly = "" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="addDeleteButton"><span class="tooltips deleteduRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span></div>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                                <?php $e++; } ?>
                                                                <?php if(isset($user_education[0]) && !empty($user_education[0])){ ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control invalideduerror" name="college[]" id="college0" placeholder="Name of School/College/University" value="<?php echo(isset($user_education[0]->college) && !empty($user_education[0]->college))?$user_education[0]->college:''; ?>" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                        <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                                                                            <input type="text" name="passing_year[]" id="passing_year0" class="form-control invalideduerror" readonly="" placeholder="Year of Passing"  value="<?php echo(isset($user_education[0]->passing_year) && !empty($user_education[0]->passing_year))?$user_education[0]->passing_year:''; ?>" style="font-size: 13px;" required>
                                                                            <span class="input-group-btn">
                                                                                <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                                                            </span>
                                                                        </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control invalideduerror" id="degree_diploma0" name="degree_diploma[]" value="<?php echo(isset($user_education[0]->degree_diploma) && !empty($user_education[0]->degree_diploma))?$user_education[0]->degree_diploma:''; ?>" placeholder="Degree/Diploma" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control invalideduerror" id="special_sub0" name="special_sub[]" value="<?php echo(isset($user_education[0]->special_sub) && !empty($user_education[0]->special_sub))?$user_education[0]->special_sub:''; ?>" placeholder="Specialized Subject" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control invalideduerror" id="percent_obtain0" name="percent_obtain[]" value="<?php echo(isset($user_education[0]->percent_obtain) && !empty($user_education[0]->percent_obtain))?$user_education[0]->percent_obtain:''; ?>" placeholder="Percentage Obtained" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="addDeleteButton">
                                                                            <span class="tooltips addedurow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                                <?php }else{ ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control invalideduerror" name="college[]" id="college0" placeholder="Name of School/College/University" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                        <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                                                                            <input type="text" name="passing_year[]" id="passing_year0" class="form-control invalideduerror" readonly="" placeholder="Year of Passing"  style="font-size: 13px;">
                                                                            <span class="input-group-btn">
                                                                                <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                                                            </span>
                                                                        </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control invalideduerror" id="degree_diploma0" name="degree_diploma[]" placeholder="Degree/Diploma" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control invalideduerror" id="special_sub0" name="special_sub[]" placeholder="Specialized Subject" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control invalideduerror" id="percent_obtain0" name="percent_obtain[]" placeholder="Percentage Obtained" required>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="addDeleteButton">
                                                                            <span class="tooltips addedurow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                        </table>
                                                        <p id="invalideduerrorid" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">Part D – Employment History (Starting from Present Employment)</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table width="100%" id="emptble" class="table table-striped table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="min-width: 150px;width:150px;">Position Held <span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                        <th style="min-width: 80px;width:80px;">From <span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                        <th style="min-width: 80px;width:80px;">To <span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                        <th style="min-width: 200px;width:200px;">Employer <br> (Name, address and contact nos.) <span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                        <th style="min-width: 200px;width:200px;">Main Responsibilities<span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                        <th style="min-width: 50px;width:50px;">Cost to Company<span class="require" aria-required="true" style="color:#a94442">*</span></th>
                                                                        <th style="min-width: 10px;width:10px;">-</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                if(isset($user_emphistory) && !empty($user_emphistory)){
                                                                    $eh = 0; foreach($user_emphistory as $key){ ?>
                                                                        <?php if($eh > 0){ ?>
                                                                            <tr>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control invalidemperror" name="position[]" id="position<?php echo $eh; ?>" value="<?php echo(isset($key->position) && !empty($key->position))?$key->position:''; ?>" placeholder="Position Held" readonly="" required>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control invalidemperror" id="from<?php echo $eh; ?>" name="from[]" value="<?php echo(isset($key->from) && !empty($key->from))?date('d-m-Y',strtotime($key->from)):''; ?>" placeholder="From" readonly="" required>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control invalidemperror" id="to<?php echo $eh; ?>" name="to[]" value="<?php echo(isset($key->to) && !empty($key->to))?date('d-m-Y',strtotime($key->to)):''; ?>" placeholder="To" readonly="" required>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control invalidemperror" id="employer_details<?php echo $eh; ?>" name="employer_details[]" id="employer_details" value="<?php echo(isset($key->employer) && !empty($key->employer))?$key->employer:''; ?>" placeholder="Employer (Name, address and contact nos.)" readonly="" required>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control invalidemperror" name="responsibilities[]" id="responsibilities<?php echo $eh; ?>" value="<?php echo(isset($key->responsibilities) && !empty($key->responsibilities))?$key->responsibilities:''; ?>" placeholder="Main Responsibilities" readonly="" required>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control invalidemperror" id="cost_to_company<?php echo $eh; ?>" name="cost_to_company[]" value="<?php echo(isset($key->ctc) && !empty($key->ctc))?$key->ctc:''; ?>" placeholder="Cost to Company" readonly="" required>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="addDeleteButton">
                                                                                    <span class="tooltips addempRow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>
                                                                                </div>
                                                                            </td>
                                                                        </tr>   
                                                                       <?php }
                                                                    $eh++;} ?>
                                                                    <?php if(isset($user_emphistory[0]) && !empty($user_emphistory[0])){ ?>
                                                                            <tr>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control invalidemperror" name="position[]" id="position0" value="<?php echo(isset($user_emphistory[0]->position) && !empty($user_emphistory[0]->position))?$user_emphistory[0]->position:''; ?>" placeholder="Position Held" required>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                                                                                    <input type="text" name="from[]" id="from0" class="form-control invalidemperror" value="<?php echo(isset($user_emphistory[0]->from) && !empty($user_emphistory[0]->from))?$user_emphistory[0]->from:''; ?>" readonly="" placeholder="From"  style="font-size: 13px;">
                                                                                    <span class="input-group-btn">
                                                                                        <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                                                                    </span>
                                                                                </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                                                                                    <input type="text" name="to[]" id="to0" class="form-control invalidemperror" readonly="" value="<?php echo(isset($user_emphistory[0]->to) && !empty($user_emphistory[0]->to))?$user_emphistory[0]->to:''; ?>" placeholder="To"  style="font-size: 13px;">
                                                                                    <span class="input-group-btn">
                                                                                        <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                                                                    </span>
                                                                                </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control invalidemperror" id="employer_details0" name="employer_details[]" id="employer_details" value="<?php echo(isset($user_emphistory[0]->employer) && !empty($user_emphistory[0]->employer))?$user_emphistory[0]->employer:''; ?>" placeholder="Employer (Name, address and contact nos.)" required>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control invalidemperror" name="responsibilities[]" id="responsibilities0" value="<?php echo(isset($user_emphistory[0]->responsibilities) && !empty($user_emphistory[0]->responsibilities))?$user_emphistory[0]->responsibilities:''; ?>" placeholder="Main Responsibilities" required>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control invalidemperror" id="cost_to_company0" name="cost_to_company[]" value="<?php echo(isset($user_emphistory[0]->ctc) && !empty($user_emphistory[0]->ctc))?$user_emphistory[0]->ctc:''; ?>" placeholder="Cost to Company" required>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="addDeleteButton">
                                                                                    <span class="tooltips addempRow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>
                                                                                </div>
                                                                            </td>
                                                                        </tr>  
                                                                        <?php } ?>
                                                                        <?php }else{ ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control invalidemperror" name="position[]" id="position0" placeholder="Position Held" required>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                            <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                                                                                <input type="text" name="from[]" id="from0" class="form-control invalidemperror" readonly="" placeholder="From"  style="font-size: 13px;">
                                                                                <span class="input-group-btn">
                                                                                    <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                                                                </span>
                                                                            </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                            <div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">
                                                                                <input type="text" name="to[]" id="to0" class="form-control invalidemperror" readonly="" placeholder="To"  style="font-size: 13px;">
                                                                                <span class="input-group-btn">
                                                                                    <button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>
                                                                                </span>
                                                                            </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control invalidemperror" id="employer_details0" name="employer_details[]" id="employer_details" placeholder="Employer (Name, address and contact nos.)" required>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control invalidemperror" name="responsibilities[]" id="responsibilities0" placeholder="Main Responsibilities" required>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control invalidemperror" id="cost_to_company0" name="cost_to_company[]" placeholder="Cost to Company" required>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="addDeleteButton">
                                                                                <span class="tooltips addempRow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>
                                                                            </div>
                                                                        </td>
                                                                    </tr>    
                                                                <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        <p id="invalidemperrorid" style="padding: 0 10px;font-size: 12px;color:#a94442;"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group"> <label class="">Username <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                <div class="input-icon right"> <i class="fa"></i> <input type="text" class="form-control duplicate" name="username" id="user_id" data-tbl="tbl_user" data-p_key="user_id" data-where="username" rel="<?php echo(isset($update_user_id) && !empty($update_user_id))?$update_user_id:'0'?>" value="<?php echo(isset($user_data->username) && !empty($user_data->username))?$user_data->username:''?>" placeholder="Username"> </div>
                                                </div>
                                            </div>
                                            <?php if(isset($user_data->user_id) && !empty($user_data->user_id)){ }else{ ?>
                                            <div class="col-md-4">
                                                <div class="form-group"> <label class="">Password <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                <div class="input-icon right"> <i class="fa"></i> <input type="Password" class="form-control" id="user_pass" name="password" value="<?php echo(isset($user_data->password) && !empty($user_data->password))?$user_data->password:''?>" placeholder="Password"> </div>
                                            </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group"> <label class="">Confirm Password <span class="require" aria-required="true" style="color:#a94442">*</span></label>
                                                <div class="input-icon right"> <i class="fa"></i> <input type="Password" class="form-control" name="cpassword" value="<?php echo(isset($user_data->password) && !empty($user_data->password))?$user_data->password:''?>" placeholder="Confirm Password"> </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-actions right"> <a href="<?php echo base_url();?>user-list" class="btn blue" style="float: left;">Back</a> <button type="button" class="btn btn-danger cancel clearData" title="click To Cancel"> Clear</button> <button type="submit" class="btn green common_save" title="click To Save" rel="<?php echo(isset($user_data->user_id) && !empty($user_data->user_id))?$user_data->user_id:''?>"><i class="fa fa-dot-circle-o"></i> <?php if(isset($user_data->user_id) && !empty($user_data->user_id)) {echo 'Update';} else { echo 'Save'; }?></button> </div>
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

    </script>



</body>



</html>