<?php

defined('BASEPATH') or exit('No direct script access allowed');



class User_controller extends Base_Controller

{

	public function __construct()

	{

		parent::__construct();

		date_default_timezone_set("Asia/Kolkata");

		ini_set('memory_limit', '1024M');

		ini_set('max_execution_time', 2000);

		$value = base_url();

		setcookie("multicare", $value, time() + 3600 * 24, '/');

		$this->load->model('common_model');

		$this->load->model('admin_model');

		$this->load->model('user_model');
	}

	public function user_list() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','user-list');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_add = 'N';
                    $submenu_dataa=$this->common_model->selectDetailsWhr('tbl_submenu','action','add-user');
                    if(isset($submenu_dataa->submenu_id) && !empty($submenu_dataa->submenu_id)){
                        $asubmenu_id = $submenu_dataa->submenu_id;
                        $check_permissiona=$this->admin_model->check_permission($asubmenu_id,$logrole_id);
                        if(isset($check_permissiona) && !empty($check_permissiona)){
                            $check_permission_add = 'Y';
                        }
                    }
                    $check_permission_update = 'N';
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_user');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                    $check_permission_delete = 'N';
                    $submenu_datad=$this->common_model->selectDetailsWhr('tbl_submenu','action','delete_user');
                    if(isset($submenu_datad->submenu_id) && !empty($submenu_datad->submenu_id)){
                        $dsubmenu_id = $submenu_datau->submenu_id;
                        $check_permissiond=$this->admin_model->check_permission($dsubmenu_id,$logrole_id);
                        if(isset($check_permissiond) && !empty($check_permissiond)){
                            $check_permission_delete = 'Y';
                        }
                    }
                    $data['check_permission_update'] = $check_permission_update;
                    $data['check_permission_add'] = $check_permission_add;
                    $data['check_permission_delete'] = $check_permission_delete;
                    $data['user_data'] = $this->user_model->user_details();
		            $this->load->view('user-list', $data);
                }else{
        		    $this->session->set_flashdata('message', '<div class="alert alert-danger">You have no Permission!!</div>');
				    redirect(base_url().'dashboard');  
        	    }
            }else{
        	    $this->session->set_flashdata('message', '<div class="alert alert-danger">You have no Permission!!</div>');
				redirect(base_url().'dashboard');  
        	}
		}else{
        	$this->session->set_flashdata('message', '<div class="alert alert-danger">You have no Permission!!</div>');
			redirect(base_url().'dashboard');  
        }
        
    }
    public function add_user() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','add-user');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $data['role_data'] = $this->common_model->fetchDataDesc('tbl_role', 'role_id');
                    $data['designation_data'] = $this->common_model->fetchDataDesc('tbl_designation', 'designation_id');
            		$data['role_data'] = $this->common_model->fetchDataDesc('tbl_role', 'role_id');
            		$this->load->view('add-user', $data);
                }else{
        		    $this->session->set_flashdata('message', '<div class="alert alert-danger">You have no Permission!!</div>');
				    redirect(base_url().'dashboard');  
        	    }
            }else{
        	    $this->session->set_flashdata('message', '<div class="alert alert-danger">You have no Permission!!</div>');
				redirect(base_url().'dashboard');  
        	}
		}else{
        	$this->session->set_flashdata('message', '<div class="alert alert-danger">You have no Permission!!</div>');
			redirect(base_url().'dashboard');  
        }
        
    }

	public function save_user(){
	    $update_user_id = $this->input->post('update_user_id');
		if(isset($update_user_id) && !empty($update_user_id)){
            $update_user_data = $this->common_model->selectDetailsWhere('tbl_user', 'user_id',$update_user_id);
        }
        $user_id = $this->session->userdata('user_id');
		$error = 'N';
		$error_message = '';
		if(isset($user_id) && empty($user_id)){
            $error = 'Y';
            $error_message = 'Please loggedin!';
        }
		$emp_no = $this->input->post('emp_no');
		if(isset($emp_no) && empty($emp_no)){
            $error = 'Y';
            $error_message = 'Please enter Employee No!';
        }else{
            if(isset($update_user_id) && empty($update_user_id)){
                $emp_no_data = $this->common_model->selectDetailsWhere('tbl_user', 'emp_no',$emp_no);
                if(isset($emp_no_data) && !empty($emp_no_data)){
                    $error = 'Y';
                    $error_message = 'Employee No Already Exist!';
                }
            }else{
                $emp_no_data = $this->common_model->selectDetailsWhere('tbl_user', 'emp_no',$emp_no);
                if(isset($emp_no_data[0]->user_id) && !empty($emp_no_data[0]->user_id) && $emp_no_data[0]->user_id!=$update_user_id){
                    $error = 'Y';
                    $error_message = 'Employee No Already Exist!';
                }
            }
		}
		$role_id = $this->input->post('role_id');
		if(isset($role_id) && empty($role_id)){
            $error = 'Y';
            $error_message = 'Please select Role!';
        }
		$joining_date = $this->input->post('joining_date');
		if(isset($joining_date) && empty($joining_date)){
            $error = 'Y';
            $error_message = 'Please enter Date of Joining!';
        }else{
            $joining_date = date('Y-m-d',strtotime($joining_date));
        }
        $name_type = $this->input->post('name_type');
		if(isset($name_type) && empty($name_type)){
            $error = 'Y';
            $error_message = 'Please enter Name!';
        }
        $fullname = $this->input->post('fullname');
		if(isset($fullname) && empty($fullname)){
            $error = 'Y';
            $error_message = 'Please enter First Name!';
        }
		$m_name = $this->input->post('m_name');
		if(isset($m_name) && empty($m_name)){
            $error = 'Y';
            $error_message = 'Please enter Middle Name!';
        }
		$s_name = $this->input->post('s_name');
		if(isset($s_name) && empty($s_name)){
            $error = 'Y';
            $error_message = 'Please enter Surname!';
        }
		$blood_group = $this->input->post('blood_group');
		if(isset($blood_group) && empty($blood_group)){
            $error = 'Y';
            $error_message = 'Please enter Blood Group!';
        }
		$mobile = $this->input->post('mobile');
		if(isset($mobile) && empty($mobile)){
            $error = 'Y';
            $error_message = 'Please enter Tel. No!';
        }else{
            if(isset($update_user_id) && empty($update_user_id)){
            $user_mbdata = $this->common_model->selectDetailsWhere('tbl_user', 'mobile',$mobile);
            if(isset($user_mbdata) && !empty($user_mbdata)){
                $error = 'Y';
                $error_message = 'Tel. No. Already Exist!';
            }
            }else{
                $user_mbdata = $this->common_model->selectDetailsWhere('tbl_user', 'mobile',$mobile);
                if(isset($user_mbdata[0]->user_id) && !empty($user_mbdata[0]->user_id) && $user_mbdata[0]->user_id!=$update_user_id){
                    $error = 'Y';
                    $error_message = 'Tel. No. Already Exist!';
                }
            }
        }
        $dob = $this->input->post('dob');
		if(isset($dob) && empty($dob)){
            $error = 'Y';
            $error_message = 'Please enter Date of Birth!';
        }else{
            $dob = date('Y-m-d',strtotime($dob));
        }
        $marital_status = $this->input->post('marital_status');
		if(isset($marital_status) && empty($marital_status)){
            $error = 'Y';
            $error_message = 'Please enter Marital Status!';
        }
		$home_addr = $this->input->post('home_addr');
		if(isset($home_addr) && empty($home_addr)){
            $error = 'Y';
            $error_message = 'Please enter Local Home Address!';
        }
        $native_addr = $this->input->post('native_addr');
		if(isset($native_addr) && empty($native_addr)){
            $error = 'Y';
            $error_message = 'Please enter Native Place Address!';
        }
        $emergency_contact = $this->input->post('emergency_contact');
        if(isset($emergency_contact) && empty($emergency_contact)){
            $error = 'Y';
            $error_message = 'Please enter Emergency Contact Details!';
        }
		$lived_days = $this->input->post('lived_days');
		if(isset($lived_days) && empty($lived_days)){
            $lived_days = 0;
        }
        $local_addr = $this->input->post('local_addr');
        if(isset($local_addr) && empty($local_addr)){
            $error = 'Y';
            $error_message = 'Please enter 2nd Local Address for correspondence!';
        }
        $perm_addr = $this->input->post('perm_addr');
        if(isset($perm_addr) && empty($perm_addr)){
            $error = 'Y';
            $error_message = 'Please enter Permanent Address!';
        }
		$mobile1 = $this->input->post('mobile1');
		if(isset($mobile1) && empty($mobile1)){
            $error = 'Y';
            $error_message = 'Please enter Tel. No. 1!';
        }
		$mobile2 = $this->input->post('mobile2');
		if(isset($mobile2) && empty($mobile2)){
            $error = 'Y';
            $error_message = 'Please enter Tel. No. 2!';
        }
		$email = $this->input->post('email');
		if(isset($email) && empty($email)){
            $error = 'Y';
            $error_message = 'Please enter Email address 1!';
        }
        $email1 = $this->input->post('email1');
		if(isset($email1) && empty($email1)){
            $error = 'Y';
            $error_message = 'Please enter Email address 2!';
        }
		$nationality = $this->input->post('nationality');
		if(isset($nationality) && empty($nationality)){
            $error = 'Y';
            $error_message = 'Please enter Nationality!';
        }
		$religion = $this->input->post('religion');
		if(isset($religion) && empty($religion)){
            $error = 'Y';
            $error_message = 'Please enter Religion!';
        }
		$language = $this->input->post('language');
		if(isset($language) && empty($language)){
            $error = 'Y';
            $error_message = 'Please enter Language known!';
        }
		$mother_tongue = $this->input->post('mother_tongue');
		if(isset($mother_tongue) && empty($mother_tongue)){
            $error = 'Y';
            $error_message = 'Please enter Mother Tongue!';
        }
		$drive_lic_no = $this->input->post('drive_lic_no');
		if(isset($drive_lic_no) && empty($drive_lic_no)){
            $drive_lic_no = '';
        }
		$drive_lic_date = $this->input->post('drive_lic_date');
		if(isset($drive_lic_date) && empty($drive_lic_date)){
            $drive_lic_date = '';
        }else{
            $drive_lic_date = date('Y-m-d',strtotime($drive_lic_date));
        }
        $passport_no = $this->input->post('passport_no');
		if(isset($passport_no) && empty($passport_no)){
            $passport_no = '';
        }
		$passport_date = $this->input->post('passport_date');
		if(isset($passport_date) && empty($passport_date)){
            $passport_date = '';
        }else{
            $passport_date = date('Y-m-d',strtotime($passport_date));
        }
		$passport_place = $this->input->post('passport_place');
		if(isset($passport_place) && empty($passport_place)){
            $passport_place = '';
        }
		$passport_expiry = $this->input->post('passport_expiry');
		if(isset($passport_expiry) && empty($passport_expiry)){
            $passport_expiry = '';
        }else{
           $passport_expiry = date('Y-m-d',strtotime($passport_expiry)); 
        }
		$pan_no = $this->input->post('pan_no');
		if(isset($pan_no) && empty($pan_no)){
            $error = 'Y';
            $error_message = 'Please enter Income-tax PAN!';
        }
		$bank_name = $this->input->post('bank_name');
		if(isset($bank_name) && empty($bank_name)){
            $error = 'Y';
            $error_message = 'Please enter Bank Name!';
        }
        $branch_name = $this->input->post('branch_name');
		if(isset($branch_name) && empty($branch_name)){
            $error = 'Y';
            $error_message = 'Please enter Bank Branch Name!';
        }
        $acc_no = $this->input->post('acc_no');
		if(isset($acc_no) && empty($acc_no)){
            $error = 'Y';
            $error_message = 'Please enter Bank Account No!';
        }
        $ifsc_code = $this->input->post('ifsc_code');
		if(isset($ifsc_code) && empty($ifsc_code)){
            $error = 'Y';
            $error_message = 'Please enter Bank IFSC Code!';
        }
        $username = $this->input->post('username');
        if(isset($username) && empty($username)){
            $error = 'Y';
            $error_message = 'Please enter Username!';
        }else{
            if(isset($username) && !empty($username) && strlen($username) < 5){
                $error = 'Y';
                $error_message = 'Username length should be greater than 5!';
            }else{
            if(isset($update_user_id) && empty($update_user_id)){
                $user_data = $this->common_model->selectDetailsWhere('tbl_user', 'username',$username);
                if(isset($user_data) && !empty($user_data)){
                    $error = 'Y';
                    $error_message = 'Username Already Exist!';
                }
            }else{
                $user_data = $this->common_model->selectDetailsWhere('tbl_user', 'username',$username);
                if(isset($user_data[0]->user_id) && !empty($user_data[0]->user_id) && $user_data[0]->user_id!=$update_user_id){
                    $error = 'Y';
                    $error_message = 'Username Already Exist!';
                }
            }
            }
        }
        $password = $this->input->post('password');
        $cpassword = $this->input->post('cpassword');
        if(isset($password) && empty($password) && isset($cpassword) && empty($cpassword)){
            $error = 'Y';
            $error_message = 'Please enter Password!';
        }elseif(isset($password) && empty($password) && isset($cpassword) && !empty($cpassword)){
            $error = 'Y';
            $error_message = 'Please enter Password!';
        }elseif(isset($password) && !empty($password) && isset($cpassword) && empty($cpassword)){
            $error = 'Y';
            $error_message = 'Please enter Confirm Password!';
        }elseif(isset($password) && !empty($password) && isset($cpassword) && !empty($cpassword) && $cpassword !=$password){
            $error = 'Y';
            $error_message = 'Please enter Password and Confirm Password must be equal!';
        }
        
        $relation = $this->input->post('relation');
		if(isset($relation) && empty($relation)){
            $error = 'Y';
            $error_message = 'Please enter Relation in Family Background!';
        }
        $f_name = $this->input->post('f_name');
		if(isset($f_name) && empty($f_name)){
            $error = 'Y';
            $error_message = 'Please enter Name in Family Background!';
        }
        $f_dob = $this->input->post('f_dob');
		if(isset($f_dob) && empty($f_dob)){
            $error = 'Y';
            $error_message = 'Please enter DOB in Family Background!';
        }
        $f_age = $this->input->post('f_age');
		if(isset($f_age) && empty($f_age)){
            $error = 'Y';
            $error_message = 'Please enter Age in Family Background!';
        }
        $f_education = $this->input->post('f_education');
		if(isset($f_education) && empty($f_education)){
            $error = 'Y';
            $error_message = 'Please enter Education in Family Background!';
        }
        $f_occup = $this->input->post('f_occup');
		if(isset($f_occup) && empty($f_occup)){
            $error = 'Y';
            $error_message = 'Please enter Occupation in Family Background!';
        }
        if(isset($relation) && !empty($relation) && isset($f_name) && !empty($f_name) &&
        isset($f_dob) && !empty($f_dob) && isset($f_age) && !empty($f_age) && 
        isset($f_education) && !empty($f_education) && isset($f_occup) && !empty($f_occup)){
        }else{
            $error = 'Y';
            $error_message = 'Please enter valid Family Background!';
        }
        $college = $this->input->post('college');
		if(isset($college) && empty($college)){
            $error = 'Y';
            $error_message = 'Please enter Name of School/College/University in Educational Details!';
        }
        $passing_year = $this->input->post('passing_year');
		if(isset($passing_year) && empty($passing_year)){
            $error = 'Y';
            $error_message = 'Please enter Year of Passing in Educational Details!';
        }
        $degree_diploma = $this->input->post('degree_diploma');
		if(isset($degree_diploma) && empty($degree_diploma)){
            $error = 'Y';
            $error_message = 'Please enter Degree/Diploma in Educational Details!';
        }
        $special_sub = $this->input->post('special_sub');
		if(isset($special_sub) && empty($special_sub)){
            $error = 'Y';
            $error_message = 'Please enter Specialized Subject in Educational Details!';
        }
        $percent_obtain = $this->input->post('percent_obtain');
		if(isset($percent_obtain) && empty($percent_obtain)){
            $error = 'Y';
            $error_message = 'Please enter Specialized Percentage Obtained in Educational Details!';
        }
        if(isset($college) && !empty($college) && isset($passing_year) && !empty($passing_year) &&
        isset($degree_diploma) && !empty($degree_diploma) && isset($special_sub) && !empty($special_sub) && 
        isset($percent_obtain) && !empty($percent_obtain)){
            
        }else{
            $error = 'Y';
            $error_message = 'Please enter valid Educational Details!';
        }
		$position = $this->input->post('position');
		if(isset($position) && empty($position)){
            $error = 'Y';
            $error_message = 'Please enter Position Held in Employment History!';
        }
        $from = $this->input->post('from');
		if(isset($from) && empty($from)){
            $error = 'Y';
            $error_message = 'Please enter From Date in Employment History!';
        }
        $to = $this->input->post('to');
		if(isset($to) && empty($to)){
            $error = 'Y';
            $error_message = 'Please enter To Date in Employment History!';
        }
        $employer_details = $this->input->post('employer_details');
		if(isset($employer_details) && empty($employer_details)){
            $error = 'Y';
            $error_message = 'Please enter Employer Details in Employment History!';
        }
        $responsibilities = $this->input->post('responsibilities');
		if(isset($responsibilities) && empty($responsibilities)){
            $error = 'Y';
            $error_message = 'Please enter Main Responsibilities in Employment History!';
        }
        $cost_to_company = $this->input->post('cost_to_company');
		if(isset($cost_to_company) && empty($cost_to_company)){
            $error = 'Y';
            $error_message = 'Please enter Cost to Company in Employment History!';
        }
        if(isset($position) && !empty($position) && isset($from) && !empty($from) &&
        isset($to) && !empty($to) && isset($employer_details) && !empty($employer_details) && 
        isset($responsibilities) && !empty($responsibilities) && isset($cost_to_company) && !empty($cost_to_company)){
            
        }else{
            $error = 'Y';
            $error_message = 'Please enter valid Employment History!';
        }
        $home_addr_proof_file = '';
        if(isset($_FILES['home_addr_proof']['name']) && !empty($_FILES['home_addr_proof']['name'])){
            $home_addr_proof = $_FILES['home_addr_proof']['name'];
            $home_addr_proof_fileImg = array('upload_path' =>'./uploads/home_addr_proof/',
                'fieldname' => 'home_addr_proof',
                'encrypt_name' => TRUE,        
                'overwrite' => FALSE,
                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
            $home_addr_proof_file_img = $this->imageupload->image_upload($home_addr_proof_fileImg);
            $errormsg= $this->upload->display_errors();
            if(isset($home_addr_proof_file_img) && !empty($home_addr_proof_file_img)){
                $home_addr_proof_fileData = $this->upload->data();      
                $home_addr_proof_file = $home_addr_proof_fileData['file_name'];
            }
        }else{
            if(isset($update_user_id) && !empty($update_user_id)){
                if(isset($update_user_data[0]->home_addr_proof) && !empty($update_user_data[0]->home_addr_proof)){
                $home_addr_proof_file = $update_user_data[0]->home_addr_proof;
                }
            }
        }
		if(isset($home_addr_proof_file) && empty($home_addr_proof_file)){
            $error = 'Y';
            $error_message = 'Please upload Local Home Address Proof!';
        }
        $native_addr_proof_file = '';
        if(isset($_FILES['native_addr_proof']['name']) && !empty($_FILES['native_addr_proof']['name'])){
            $native_addr_proof = $_FILES['native_addr_proof']['name'];
            $native_addr_proof_fileImg = array('upload_path' =>'./uploads/native_addr_proof/',
                'fieldname' => 'native_addr_proof',
                'encrypt_name' => TRUE,        
                'overwrite' => FALSE,
                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
            $native_addr_proof_file_img = $this->imageupload->image_upload($native_addr_proof_fileImg);
            $errormsg= $this->upload->display_errors();
            if(isset($native_addr_proof_file_img) && !empty($native_addr_proof_file_img)){
                $native_addr_proof_fileData = $this->upload->data();      
                $native_addr_proof_file = $native_addr_proof_fileData['file_name'];
            }
        }else{
            if(isset($update_user_id) && !empty($update_user_id)){
                if(isset($update_user_data[0]->native_addr_proof) && !empty($update_user_data[0]->native_addr_proof)){
                $native_addr_proof_file = $update_user_data[0]->native_addr_proof;
                }
            }
        }
        if(isset($native_addr_proof_file) && empty($native_addr_proof_file)){
            $error = 'Y';
            $error_message = 'Please upload Native Place Address Proof!';
        }
        $local_addr_proof_file = '';
        if(isset($_FILES['local_addr_proof']['name']) && !empty($_FILES['local_addr_proof']['name'])){
            $local_addr_proof = $_FILES['local_addr_proof']['name'];
            $local_addr_proof_fileImg = array('upload_path' =>'./uploads/local_addr_proof/',
                'fieldname' => 'local_addr_proof',
                'encrypt_name' => TRUE,        
                'overwrite' => FALSE,
                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
            $local_addr_proof_file_img = $this->imageupload->image_upload($local_addr_proof_fileImg);
            $errormsg= $this->upload->display_errors();
            if(isset($local_addr_proof_file_img) && !empty($local_addr_proof_file_img)){
                $local_addr_proof_fileData = $this->upload->data();      
                $local_addr_proof_file = $local_addr_proof_fileData['file_name'];
            }
        }else{
            if(isset($update_user_id) && !empty($update_user_id)){
                if(isset($update_user_data[0]->local_addr_proof) && !empty($update_user_data[0]->local_addr_proof)){
                $local_addr_proof_file = $update_user_data[0]->local_addr_proof;
                }
            }
        }
        if(isset($local_addr_proof_file) && empty($local_addr_proof_file)){
            $error = 'Y';
            $error_message = 'Please upload 2nd Local Address for correspondence Proof!';
        }
        $perm_addr_proof_file = '';
        if(isset($_FILES['perm_addr_proof']['name']) && !empty($_FILES['perm_addr_proof']['name'])){
            $perm_addr_proof = $_FILES['perm_addr_proof']['name'];
            $perm_addr_proof_fileImg = array('upload_path' =>'./uploads/perm_addr_proof/',
                'fieldname' => 'perm_addr_proof',
                'encrypt_name' => TRUE,        
                'overwrite' => FALSE,
                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
            $perm_addr_proof_file_img = $this->imageupload->image_upload($perm_addr_proof_fileImg);
            $errormsg= $this->upload->display_errors();
            if(isset($perm_addr_proof_file_img) && !empty($perm_addr_proof_file_img)){
                $perm_addr_proof_fileData = $this->upload->data();      
                $perm_addr_proof_file = $perm_addr_proof_fileData['file_name'];
            }
        }else{
            if(isset($update_user_id) && !empty($update_user_id)){
                if(isset($update_user_data[0]->perm_addr_proof) && !empty($update_user_data[0]->perm_addr_proof)){
                $perm_addr_proof_file = $update_user_data[0]->perm_addr_proof;
                }
            }
        }
        if(isset($perm_addr_proof_file) && empty($perm_addr_proof_file)){
            $error = 'Y';
            $error_message = 'Please upload Permanent Address Proof!';
        }
        $passport_proof_file = '';
        if(isset($_FILES['passport_proof']['name']) && !empty($_FILES['passport_proof']['name'])){
            $passport_proof = $_FILES['passport_proof']['name'];
            $passport_proof_fileImg = array('upload_path' =>'./uploads/passport_proof/',
                'fieldname' => 'passport_proof',
                'encrypt_name' => TRUE,        
                'overwrite' => FALSE,
                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
            $passport_proof_file_img = $this->imageupload->image_upload($passport_proof_fileImg);
            $errormsg= $this->upload->display_errors();
            if(isset($passport_proof_file_img) && !empty($passport_proof_file_img)){
                $passport_proof_fileData = $this->upload->data();      
                $passport_proof_file = $passport_proof_fileData['file_name'];
            }
        }else{
            if(isset($update_user_id) && !empty($update_user_id)){
                if(isset($update_user_data[0]->passport_proof) && !empty($update_user_data[0]->passport_proof)){
                $passport_proof_file = $update_user_data[0]->passport_proof;
                }
            }
        }
        $pan_proof_file = '';
        if(isset($_FILES['pan_proof']['name']) && !empty($_FILES['pan_proof']['name'])){
            $pan_proof = $_FILES['pan_proof']['name'];
            $pan_proof_fileImg = array('upload_path' =>'./uploads/pan_proof/',
                'fieldname' => 'pan_proof',
                'encrypt_name' => TRUE,        
                'overwrite' => FALSE,
                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
            $pan_proof_file_img = $this->imageupload->image_upload($pan_proof_fileImg);
            $errormsg= $this->upload->display_errors();
            if(isset($pan_proof_file_img) && !empty($pan_proof_file_img)){
                $pan_proof_fileData = $this->upload->data();      
                $pan_proof_file = $pan_proof_fileData['file_name'];
            }
        }else{
            if(isset($update_user_id) && !empty($update_user_id)){
                if(isset($update_user_data[0]->pan_proof) && !empty($update_user_data[0]->pan_proof)){
                $pan_proof_file = $update_user_data[0]->pan_proof;
                }
            }
        }
        if(isset($pan_proof_file) && empty($pan_proof_file)){
            $error = 'Y';
            $error_message = 'Please upload Income-tax PAN Proof!';
        }
        $drive_lic_proof_file = '';
        if(isset($_FILES['drive_lic_proof']['name']) && !empty($_FILES['drive_lic_proof']['name'])){
            $drive_lic_proof = $_FILES['drive_lic_proof']['name'];
            $drive_lic_proof_fileImg = array('upload_path' =>'./uploads/drive_lic_proof/',
                'fieldname' => 'drive_lic_proof',
                'encrypt_name' => TRUE,        
                'overwrite' => FALSE,
                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
            $drive_lic_proof_file_img = $this->imageupload->image_upload($drive_lic_proof_fileImg);
            $errormsg= $this->upload->display_errors();
            if(isset($drive_lic_proof_file_img) && !empty($drive_lic_proof_file_img)){
                $drive_lic_proof_fileData = $this->upload->data();      
                $drive_lic_proof_file = $drive_lic_proof_fileData['file_name'];
            }
        }else{
            if(isset($update_user_id) && !empty($update_user_id)){
                if(isset($update_user_data[0]->drive_lic_proof) && !empty($update_user_data[0]->drive_lic_proof)){
                $drive_lic_proof_file = $update_user_data[0]->drive_lic_proof;
                }
            }
        }
        $bank_acc_proof_file = '';
        if(isset($_FILES['bank_acc_proof']['name']) && !empty($_FILES['bank_acc_proof']['name'])){
            $bank_acc_proof = $_FILES['bank_acc_proof']['name'];
            $bank_acc_proof_fileImg = array('upload_path' =>'./uploads/bank_acc_proof/',
                'fieldname' => 'bank_acc_proof',
                'encrypt_name' => TRUE,        
                'overwrite' => FALSE,
                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
            $bank_acc_proof_file_img = $this->imageupload->image_upload($bank_acc_proof_fileImg);
            $errormsg= $this->upload->display_errors();
            if(isset($bank_acc_proof_file_img) && !empty($bank_acc_proof_file_img)){
                $bank_acc_proof_fileData = $this->upload->data();      
                $bank_acc_proof_file = $bank_acc_proof_fileData['file_name'];
            }
        }else{
            if(isset($update_user_id) && !empty($update_user_id)){
                if(isset($update_user_data[0]->bank_acc_proof) && !empty($update_user_data[0]->bank_acc_proof)){
                $bank_acc_proof_file = $update_user_data[0]->bank_acc_proof;
                }
            }
        }
        if(isset($bank_acc_proof_file) && empty($bank_acc_proof_file)){
            $error = 'Y';
            $error_message = 'Please upload Bank Account Proof! ';
        }
        if($error == 'N'){
            $user_save_data = array('role_id'=>$role_id,'name_type'=>$name_type,'fullname'=>$fullname,'m_name'=>$m_name,
    		's_name'=>$s_name,'email'=>$email,'mobile'=>$mobile,'username'=>$username,'city'=>'','pincode'=>'','address'=>$home_addr,
    		'user_image'=>'','blood_group'=>$blood_group,'dob'=>$dob,'marital_status'=>$marital_status,
    		'home_addr'=>$home_addr,'native_addr'=>$native_addr,'emergency_contact'=>$emergency_contact,'lived_days'=>$lived_days,
    		'local_addr'=>$local_addr,'perm_addr'=>$perm_addr,'mobile1'=>$mobile1,'mobile2'=>$mobile2,'email1'=>$email1, 'nationality'=>$nationality, 
    		'religion'=>$religion, 'language'=>$language,'mother_tongue'=>$mother_tongue,'drive_lic_no'=>$drive_lic_no, 'drive_lic_date'=>$drive_lic_date,
    		'passport_no'=>$passport_no,'passport_date'=>$passport_date, 'passport_place'=>$passport_place, 'passport_expiry'=>$passport_expiry, 'pan_no'=>$pan_no,
    		'bank_name'=>$bank_name, 'branch_name'=>$branch_name, 'acc_no'=>$acc_no, 'ifsc_code'=>$ifsc_code,'bank_acc_proof'=>$bank_acc_proof_file,
    		'home_addr_proof'=>$home_addr_proof_file, 'native_addr_proof'=>$native_addr_proof_file, 
    		'local_addr_proof'=>$local_addr_proof_file, 'perm_addr_proof'=>$perm_addr_proof_file, 'drive_lic_proof'=>$drive_lic_proof_file,
    		'passport_proof'=>$passport_proof_file, 'pan_proof'=>$pan_proof_file, 'emp_no'=>$emp_no, 'joining_date'=>$joining_date);
    		
    		$update_user_id = $this->input->post('update_user_id');
		    if(isset($update_user_id) && !empty($update_user_id)){ 
		        $loguser_id = $this->session->userData('user_id');
		        $logrole_id = $this->session->userData('role_id');
		        if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		            $submenu_dataa=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_user');
                        if(isset($submenu_dataa->submenu_id) && !empty($submenu_dataa->submenu_id)){
                            $asubmenu_id = $submenu_dataa->submenu_id;
                            $check_permissiona=$this->admin_model->check_permission($asubmenu_id,$logrole_id);
                            if(isset($check_permissiona) && !empty($check_permissiona)){
                                $user_save_data['modified_on'] = date('Y-m-d H:i:s');
                		        $user_save_data['modified_by'] = $user_id;
                		        $this->common_model->updateDetails('tbl_user', 'user_id', $update_user_id, $user_save_data);
                		        $whr = array('user_id'=>$update_user_id);
                		        $this->common_model->deleteRowWhere('tbl_user_family',$whr);
                		        $this->common_model->deleteRowWhere('tbl_user_education',$whr);
                		        $this->common_model->deleteRowWhere('tbl_user_emphistory',$whr);
                		        $save_user_family_arr = array();
                                if(isset($relation) && !empty($relation) && isset($f_name) && !empty($f_name) &&
                                isset($f_dob) && !empty($f_dob) && isset($f_age) && !empty($f_age) && 
                                isset($f_education) && !empty($f_education) && isset($f_occup) && !empty($f_occup)){
                                    for($i=0;$i<count($relation);$i++){
                                        if(isset($relation[$i]) && !empty($relation[$i])) { $relation_s = $relation[$i]; }else { $relation_s = ''; }
                                        if(isset($f_name[$i]) && !empty($f_name[$i])) { $f_name_s = $f_name[$i]; }else { $f_name_s = ''; }  
                                        if(isset($f_dob[$i]) && !empty($f_dob[$i])) { $f_dob_s = date('Y-m-d',strtotime($f_dob[$i])); }else { $f_dob_s = ''; }  
                                        if(isset($f_age[$i]) && !empty($f_age[$i])) { $f_age_s = $f_age[$i]; }else { $f_age_s = ''; }  
                                        if(isset($f_education[$i]) && !empty($f_education[$i])) { $f_education_s = $f_education[$i]; }else { $f_education_s = ''; }  
                                        if(isset($f_occup[$i]) && !empty($f_occup[$i])) { $f_occup_s = $f_occup[$i]; }else { $f_occup_s = ''; } 
                                        if(isset($relation_s) && !empty($relation_s) && isset($f_name_s) && !empty($f_name_s) &&
                                        isset($f_dob_s) && !empty($f_dob_s) && isset($f_age_s) && !empty($f_age_s) && 
                                        isset($f_education_s) && !empty($f_education_s) && isset($f_occup_s) && !empty($f_occup_s)){
                                            $save_user_family_arr[] = array('relation'=>$relation_s,'f_name'=>$f_name_s,'f_dob'=>$f_dob_s,
                                            'f_age'=>$f_age_s,'f_education'=>$f_education_s,'f_occup'=>$f_occup_s,'user_id'=>$update_user_id);
                                        }
                                    }
                                }
                                if(isset($save_user_family_arr) && !empty($save_user_family_arr)){
                                    $this->common_model->SaveMultiData('tbl_user_family',$save_user_family_arr);
                                }
                                $save_user_education_arr = array();
                                if(isset($college) && !empty($college) && isset($passing_year) && !empty($passing_year) &&
                                isset($degree_diploma) && !empty($degree_diploma) && isset($special_sub) && !empty($special_sub) && 
                                isset($percent_obtain) && !empty($percent_obtain)){
                                    for($i=0;$i<count($college);$i++){
                                        if(isset($college[$i]) && !empty($college[$i])) { $college_s = $college[$i]; }else { $college_s = ''; }
                                        if(isset($passing_year[$i]) && !empty($passing_year[$i])) { $passing_year_s = date('Y-m-d',strtotime($passing_year[$i])); }else { $passing_year_s = ''; }  
                                        if(isset($degree_diploma[$i]) && !empty($degree_diploma[$i])) { $degree_diploma_s = $degree_diploma[$i]; }else { $degree_diploma_s = ''; }  
                                        if(isset($special_sub[$i]) && !empty($special_sub[$i])) { $special_sub_s = $special_sub[$i]; }else { $special_sub_s = ''; }  
                                        if(isset($percent_obtain[$i]) && !empty($percent_obtain[$i])) { $percent_obtain_s = $percent_obtain[$i]; }else { $percent_obtain_s = ''; }  
                                           
                                           if(isset($college_s) && !empty($college_s) && isset($passing_year_s) && !empty($passing_year_s) &&
                                            isset($degree_diploma_s) && !empty($degree_diploma_s) && isset($special_sub_s) && !empty($special_sub_s) && 
                                            isset($percent_obtain_s) && !empty($percent_obtain_s)){
                                            $save_user_education_arr[] = array('user_id'=>$update_user_id,'college'=>$college_s,'passing_year'=>$passing_year_s,
                                            'degree_diploma'=>$degree_diploma_s, 'special_sub'=>$special_sub_s, 'percent_obtain'=>$percent_obtain_s);
                                            }
                                        }
                                }
                                if(isset($save_user_education_arr) && !empty($save_user_education_arr)){
                                    $this->common_model->SaveMultiData('tbl_user_education',$save_user_education_arr);
                                }
                                    
                                $save_user_employee_arr = array();
                                if(isset($position) && !empty($position) && isset($from) && !empty($from) &&
                                isset($to) && !empty($to) && isset($employer_details) && !empty($employer_details) && 
                                isset($responsibilities) && !empty($responsibilities) && isset($cost_to_company) && !empty($cost_to_company)){
                                    for($i=0;$i<count($position);$i++){
                                        if(isset($position[$i]) && !empty($position[$i])) { $position_s = $position[$i]; }else { $position_s = ''; }
                                        if(isset($from[$i]) && !empty($from[$i])) { $from_s = date('Y-m-d',strtotime($from[$i])); }else { $from_s = ''; }  
                                        if(isset($to[$i]) && !empty($to[$i])) { $to_s = date('Y-m-d',strtotime($to[$i])); }else { $to_s = ''; }  
                                        if(isset($employer_details[$i]) && !empty($employer_details[$i])) { $employer_details_s = $employer_details[$i]; }else { $employer_details_s = ''; }  
                                        if(isset($responsibilities[$i]) && !empty($responsibilities[$i])) { $responsibilities_s = $responsibilities[$i]; }else { $responsibilities_s = ''; }  
                                        if(isset($cost_to_company[$i]) && !empty($cost_to_company[$i])) { $cost_to_company_s = $cost_to_company[$i]; }else { $cost_to_company_s = ''; }  
                                           
                                        if(isset($position_s) && !empty($position_s) && isset($from_s) && !empty($from_s) &&
                                        isset($to_s) && !empty($to_s) && isset($employer_details_s) && !empty($employer_details_s) && 
                                        isset($responsibilities_s) && !empty($responsibilities_s) && isset($cost_to_company_s) && !empty($cost_to_company_s)){
                                        $save_user_employee_arr[] = array('user_id'=>$update_user_id, 'position'=>$position_s,'from'=>$from_s,
                                        'to'=>$to_s,'employer'=>$employer_details_s, 'responsibilities'=>$responsibilities_s, 'ctc'=>$cost_to_company_s);
                                        }
                                    }
                                }
                                if(isset($save_user_employee_arr) && !empty($save_user_employee_arr)){
                                    $this->common_model->SaveMultiData('tbl_user_emphistory',$save_user_employee_arr);
                                }
                                $this->json->jsonReturn(array(
                                    'valid'=>TRUE,
                                    'msg'=>'<div class="alert modify alert-info">Team Member Details Saved Successfully!</div>',
                                    'redirect' => base_url().'user-list'
                                ));
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid' => FALSE,
                                    'msg' => '<div class="alert modify alert-danger">You have no Permission!!</div>'
                                ));
                            }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid' => FALSE,
                                'msg' => '<div class="alert modify alert-danger">You have no Permission!!</div>'
                            ));
                        }
		        }else{
		            $this->json->jsonReturn(array(
                        'valid' => FALSE,
                        'msg' => '<div class="alert modify alert-danger">You have no Permission!!</div>'
                    ));
		        }
                
		    }else{
		        $loguser_id = $this->session->userData('user_id');
		        $logrole_id = $this->session->userData('role_id');
		        if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		            $submenu_dataa=$this->common_model->selectDetailsWhr('tbl_submenu','action','add-user');
                        if(isset($submenu_dataa->submenu_id) && !empty($submenu_dataa->submenu_id)){
                            $asubmenu_id = $submenu_dataa->submenu_id;
                            $check_permissiona=$this->admin_model->check_permission($asubmenu_id,$logrole_id);
                            if(isset($check_permissiona) && !empty($check_permissiona)){
                                $user_save_data['created_on'] = date('Y-m-d H:i:s');
                		        $user_save_data['created_by'] = $user_id;
                		        $user_save_data['user_status'] = 'Active';
                		        $user_save_data['password'] = $password;
                		        $save_id = $this->common_model->addData('tbl_user',$user_save_data);
                		        if(isset($save_id) && !empty($save_id)){
                		            $save_user_family_arr = array();
                                    if(isset($relation) && !empty($relation) && isset($f_name) && !empty($f_name) &&
                                    isset($f_dob) && !empty($f_dob) && isset($f_age) && !empty($f_age) && 
                                    isset($f_education) && !empty($f_education) && isset($f_occup) && !empty($f_occup)){
                                        for($i=0;$i<count($relation);$i++){
                                           if(isset($relation[$i]) && !empty($relation[$i])) { $relation_s = $relation[$i]; }else { $relation_s = ''; }
                                           if(isset($f_name[$i]) && !empty($f_name[$i])) { $f_name_s = $f_name[$i]; }else { $f_name_s = ''; }  
                                           if(isset($f_dob[$i]) && !empty($f_dob[$i])) { $f_dob_s = date('Y-m-d',strtotime($f_dob[$i])); }else { $f_dob_s = ''; }  
                                           if(isset($f_age[$i]) && !empty($f_age[$i])) { $f_age_s = $f_age[$i]; }else { $f_age_s = ''; }  
                                           if(isset($f_education[$i]) && !empty($f_education[$i])) { $f_education_s = $f_education[$i]; }else { $f_education_s = ''; }  
                                           if(isset($f_occup[$i]) && !empty($f_occup[$i])) { $f_occup_s = $f_occup[$i]; }else { $f_occup_s = ''; } 
                                           if(isset($relation_s) && !empty($relation_s) && isset($f_name_s) && !empty($f_name_s) &&
                                            isset($f_dob_s) && !empty($f_dob_s) && isset($f_age_s) && !empty($f_age_s) && 
                                            isset($f_education_s) && !empty($f_education_s) && isset($f_occup_s) && !empty($f_occup_s)){
                                            $save_user_family_arr[] = array('relation'=>$relation_s,'f_name'=>$f_name_s,'f_dob'=>$f_dob_s,
                                            'f_age'=>$f_age_s,'f_education'=>$f_education_s,'f_occup'=>$f_occup_s,'user_id'=>$save_id);
                                            }
                                        }
                                    }
                                    if(isset($save_user_family_arr) && !empty($save_user_family_arr)){
                                        $this->common_model->SaveMultiData('tbl_user_family',$save_user_family_arr);
                                    }
                                    
                                    $save_user_education_arr = array();
                                    if(isset($college) && !empty($college) && isset($passing_year) && !empty($passing_year) &&
                                    isset($degree_diploma) && !empty($degree_diploma) && isset($special_sub) && !empty($special_sub) && 
                                    isset($percent_obtain) && !empty($percent_obtain)){
                                        for($i=0;$i<count($college);$i++){
                                           if(isset($college[$i]) && !empty($college[$i])) { $college_s = $college[$i]; }else { $college_s = ''; }
                                           if(isset($passing_year[$i]) && !empty($passing_year[$i])) { $passing_year_s = date('Y-m-d',strtotime($passing_year[$i])); }else { $passing_year_s = ''; }  
                                           if(isset($degree_diploma[$i]) && !empty($degree_diploma[$i])) { $degree_diploma_s = $degree_diploma[$i]; }else { $degree_diploma_s = ''; }  
                                           if(isset($special_sub[$i]) && !empty($special_sub[$i])) { $special_sub_s = $special_sub[$i]; }else { $special_sub_s = ''; }  
                                           if(isset($percent_obtain[$i]) && !empty($percent_obtain[$i])) { $percent_obtain_s = $percent_obtain[$i]; }else { $percent_obtain_s = ''; }  
                                           
                                           if(isset($college_s) && !empty($college_s) && isset($passing_year_s) && !empty($passing_year_s) &&
                                            isset($degree_diploma_s) && !empty($degree_diploma_s) && isset($special_sub_s) && !empty($special_sub_s) && 
                                            isset($percent_obtain_s) && !empty($percent_obtain_s)){
                                            $save_user_education_arr[] = array('user_id'=>$save_id,'college'=>$college_s,'passing_year'=>$passing_year_s,
                                            'degree_diploma'=>$degree_diploma_s, 'special_sub'=>$special_sub_s, 'percent_obtain'=>$percent_obtain_s);
                                            }
                                        }
                                    }
                                    if(isset($save_user_education_arr) && !empty($save_user_education_arr)){
                                        $this->common_model->SaveMultiData('tbl_user_education',$save_user_education_arr);
                                    }
                                    
                                    $save_user_employee_arr = array();
                                    if(isset($position) && !empty($position) && isset($from) && !empty($from) &&
                                    isset($to) && !empty($to) && isset($employer_details) && !empty($employer_details) && 
                                    isset($responsibilities) && !empty($responsibilities) && isset($cost_to_company) && !empty($cost_to_company)){
                                        for($i=0;$i<count($position);$i++){
                                           if(isset($position[$i]) && !empty($position[$i])) { $position_s = $position[$i]; }else { $position_s = ''; }
                                           if(isset($from[$i]) && !empty($from[$i])) { $from_s = date('Y-m-d',strtotime($from[$i])); }else { $from_s = ''; }  
                                           if(isset($to[$i]) && !empty($to[$i])) { $to_s = date('Y-m-d',strtotime($to[$i])); }else { $to_s = ''; }  
                                           if(isset($employer_details[$i]) && !empty($employer_details[$i])) { $employer_details_s = $employer_details[$i]; }else { $employer_details_s = ''; }  
                                           if(isset($responsibilities[$i]) && !empty($responsibilities[$i])) { $responsibilities_s = $responsibilities[$i]; }else { $responsibilities_s = ''; }  
                                           if(isset($cost_to_company[$i]) && !empty($cost_to_company[$i])) { $cost_to_company_s = $cost_to_company[$i]; }else { $cost_to_company_s = ''; }  
                                           
                                           if(isset($position_s) && !empty($position_s) && isset($from_s) && !empty($from_s) &&
                                            isset($to_s) && !empty($to_s) && isset($employer_details_s) && !empty($employer_details_s) && 
                                            isset($responsibilities_s) && !empty($responsibilities_s) && isset($cost_to_company_s) && !empty($cost_to_company_s)){
                                            $save_user_employee_arr[] = array('user_id'=>$save_id, 'position'=>$position_s,'from'=>$from_s,
                                            'to'=>$to_s,'employer'=>$employer_details_s, 'responsibilities'=>$responsibilities_s, 'ctc'=>$cost_to_company_s);
                                            }
                                        }
                                    }
                                    if(isset($save_user_employee_arr) && !empty($save_user_employee_arr)){
                                        $this->common_model->SaveMultiData('tbl_user_emphistory',$save_user_employee_arr);
                                    }
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE,
                                        'msg'=>'<div class="alert modify alert-info">Team Member Details Saved Successfully!</div>',
                                        'redirect' => base_url().'user-list'
                                    )); 
                		        }else{
                		           $this->json->jsonReturn(array(
                                        'valid' => FALSE,
                                        'msg' => '<div class="alert modify alert-danger">Something went to wrong!</div>'
                                    )); 
                		        }
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid' => FALSE,
                                    'msg' => '<div class="alert modify alert-danger">You have no Permission!!</div>'
                                ));
                            }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid' => FALSE,
                                'msg' => '<div class="alert modify alert-danger">You have no Permission!!</div>'
                            ));
                        }
		        }else{
		            $this->json->jsonReturn(array(
                        'valid' => FALSE,
                        'msg' => '<div class="alert modify alert-danger">You have no Permission!!</div>'
                    ));
		        }
                            
                
		    }
        }else{
            $this->json->jsonReturn(array(
                'valid' => FALSE,
                'msg' => '<div class="alert modify alert-danger">'.$error_message.'</div>'
            ));
        }
    }

	public function edit_user($id){
	    $id = $this->uri->segment(2);
	    if(isset($id) && !empty($id)){
	        $id = base64_decode($id);
	    }else{
	        $id = 0;
	    }
	    $data['role_data'] = $this->common_model->fetchDataDesc('tbl_role', 'role_id');
	    $data['user_education'] = $this->common_model->selectDetailsWhereAll('tbl_user_education', 'user_id',$id);
		$data['user_emphistory'] = $this->common_model->selectDetailsWhereAll('tbl_user_emphistory', 'user_id',$id);
		$data['user_family'] = $this->common_model->selectDetailsWhereAll('tbl_user_family','user_id',$id);
		$data['user_data'] = $this->user_model->edit_user_details($id);
		$data['update_user_id'] = $id;
		$this->load->view('add-user', $data);
	}

	public function delete_user()

	{

		$id = $this->input->post('id');

		$data = array('display' => 'N');

		$result = $this->common_model->updateDetails('tbl_user', 'user_id', $id, $data);

		if ($result) {

			$this->json->jsonReturn(array(

				'valid' => TRUE,

				'msg' => '<div class="alert modify alert-info"><strong>Welldone!</strong> Data Deleted Successfully.</div>'

			));
		} else {

			$this->json->jsonReturn(array(

				'valid' => FALSE,

				'msg' => '<div class="alert modify alert-danger"><strong>Oops!</strong> Something Went Wrong.</div>'

			));
		}
	}

	public function active_user_status()

	{

		$id = $this->input->post('id');

		$data = array('user_status' => 'Active');

		$result = $this->common_model->updateDetails('tbl_user', 'user_id', $id, $data);

		// echo $this->db->last_query(); die;

		if ($result) {

			$this->json->jsonReturn(array(

				'valid' => TRUE,

				'msg' => '<div class="alert modify alert-info"><strong>Welldone!</strong>User Status Changed Successfully!</div>'

			));
		} else {

			$this->json->jsonReturn(array(

				'valid' => FALSE,

				'msg' => '<div class="alert modify alert-danger"><strong>Error</strong> While User Status Changing!</div>'

			));
		}
	}

	public function block_user_status()

	{

		$id = $this->input->post('id');

		$data = array('user_status' => 'Block');

		$result = $this->common_model->updateDetails('tbl_user', 'user_id', $id, $data);

		if ($result) {

			$this->json->jsonReturn(array(

				'valid' => TRUE,

				'msg' => '<div class="alert modify alert-info"><strong>Welldone!</strong>User Status Changed Successfully!</div>'

			));
		} else {

			$this->json->jsonReturn(array(

				'valid' => FALSE,

				'msg' => '<div class="alert modify alert-danger"><strong>Error</strong> While User Status Changing!</div>'

			));
		}
	}
}
