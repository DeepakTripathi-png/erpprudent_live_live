<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compliance_controller extends Base_Controller 
{
	public function __construct()
  	{
	    parent::__construct();
	    $this->clear_cache();  
        date_default_timezone_set("Asia/Kolkata"); 
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 2000);
        $value = base_url();
        setcookie("multicare",$value, time()+3600*24,'/'); 
	    $this->load->model('common_model');
        $this->load->model('admin_model');
        error_reporting(E_ALL & ~E_NOTICE);
    }
    public function clear_cache()
    {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }
    public function add_or_view_compliance() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','add-or-view-compliance');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_add = 'N';
                    $submenu_dataa=$this->common_model->selectDetailsWhr('tbl_submenu','action','Add_View_Compliance');
                    if(isset($submenu_dataa->submenu_id) && !empty($submenu_dataa->submenu_id)){
                        $asubmenu_id = $submenu_dataa->submenu_id;
                        $check_permissiona=$this->admin_model->check_permission($asubmenu_id,$logrole_id);
                        if(isset($check_permissiona) && !empty($check_permissiona)){
                            $check_permission_add = 'Y';
                        }
                    }
                    $data['check_permission_add'] = $check_permission_add;
                    $this->load->view('add-or-view-compliance', $data);
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
    public function pending_compliance() 
    {
        $this->load->view('pending-compliance');
    }
    public function pending_compliance_list_display() 
		{
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$data = $row = array();
		$i = $_POST['start'];
		$allCount = 0;
		$countFiltered = 0;
		$data[0] = array('1','GSTR-1A','April 2023','');
		$data[1] = array('2','TDS','April 2023','');
		$data[2] = array('3','Professional Tax (PT)','April 2023','');
		$data[3] = array('4','Provident Fund (PF)','May 2023','');
		$data[4] = array('5','GSTR-1A','May 2023','');
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }

    public function Add_View_Compliance(){
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','Add_View_Compliance');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $error = 'N';
                    $error_message = '';
                    $user_id = $this->session->userdata('user_id');
                    if(isset($user_id) && empty($user_id)){
                    $error = 'Y';
                    $error_message = 'Please loggedin!';
                    }
                    if(isset($user_id)&& !empty($user_id)){
                        $updated_by = $user_id;
                        $month = $this->input->post('month');
                        $year = $this->input->post('year');
                        if(isset($month) && empty($month)){
                        $error = 'Y';
                        $error_message = 'Please select month!';
                        }
                        if(isset($year) && empty($year)){
                        $error = 'Y';
                        $error_message = 'Please select year!';
                        }
                        $comdata = $this->common_model->selectMultiDataForcom('tbl_compliance','month','year',$month,$year);
                        $gstr_1a_confirmation_date = $this->input->post('gstr_1a_confirmation_date');
                        $proof_tax_confirmation_date = $this->input->post('proof_tax_confirmation_date');
                        $gstr_3b_confirmation_date = $this->input->post('gstr_3b_confirmation_date');
                        $pro_fund_confirmation_date = $this->input->post('pro_fund_confirmation_date');
                        $tds_confirmation_date = $this->input->post('tds_confirmation_dates');
                        $esic_confirmation_date = $this->input->post('esic_confirmation_date');
                        
                        if(isset($gstr_1a_confirmation_date) && empty($gstr_1a_confirmation_date)
                        && isset($proof_tax_confirmation_date) && empty($proof_tax_confirmation_date)
                        && isset($gstr_3b_confirmation_date) && empty($gstr_3b_confirmation_date)
                        && isset($pro_fund_confirmation_date) && empty($pro_fund_confirmation_date)
                        && isset($tds_confirmation_date) && empty($tds_confirmation_date)
                        && isset($esic_confirmation_date) && empty($esic_confirmation_date)){
                        $error = 'Y';
                        $error_message = 'Please enter at least one confirmation date and document!';
                        }
                        $gstr_1a_confirm_date = '';
                        $upload_gtds_doc = '';
                        if(isset($gstr_1a_confirmation_date) && !empty($gstr_1a_confirmation_date)){
                            $gstr_1a_confirm_date = date('Y-m-d',strtotime($gstr_1a_confirmation_date));
                            if(isset($_FILES['upload_gtds_docs']['name']) && !empty($_FILES['upload_gtds_docs']['name'])){
                                $upload_gtds_doc = $_FILES['upload_gtds_docs']['name'];
                                $upload_gtds_doc_fileImg = array(
                                    'upload_path' =>'./uploads/compliance_upload/',
                                    'fieldname' => 'upload_gtds_docs',
                                    'encrypt_name' => TRUE,        
                                    'overwrite' => FALSE,
                                    'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG');
                                $upload_gtds_doc_fileImg = $this->imageupload->image_upload($upload_gtds_doc_fileImg);
                                $errormsg= $this->upload->display_errors();
                                if(isset($upload_gtds_doc_fileImg) && !empty($upload_gtds_doc_fileImg)){
                                    $upload_gtds_doc_fileData = $this->upload->data();      
                                    $upload_gtds_doc = $upload_gtds_doc_fileData['file_name'];
                                }
                            }elseif(isset($comdata[0]->gstr_1a_doc) && !empty($comdata[0]->gstr_1a_doc)){
                                $upload_gtds_doc = $comdata[0]->gstr_1a_doc;
                            }
                        }
                        $gstr_3b_confirm_date = '';
                        $upload_gstr_3b_doc = '';
                        if(isset($gstr_3b_confirmation_date) && !empty($gstr_3b_confirmation_date)){
                            $gstr_3b_confirm_date = date('Y-m-d',strtotime($gstr_3b_confirmation_date));
                                if(isset($_FILES['gstr_3b_doc']['name']) && !empty($_FILES['gstr_3b_doc']['name'])){
                                    $upload_gstr_3b_doc = $_FILES['gstr_3b_doc']['name'];
                                    $upload_gstr_3b_doc_fileImg = array(
                                        'upload_path' =>'./uploads/compliance_upload/',
                                        'fieldname' => 'gstr_3b_doc',
                                        'encrypt_name' => TRUE,        
                                        'overwrite' => FALSE,
                                        'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG');
                                    $upload_gstr_3b_doc_fileImg = $this->imageupload->image_upload($upload_gstr_3b_doc_fileImg);
                                    $errormsg= $this->upload->display_errors();
                                    if(isset($upload_gstr_3b_doc_fileImg) && !empty($upload_gstr_3b_doc_fileImg)){
                                        $upload_gstr_3b_doc_fileData = $this->upload->data();      
                                        $upload_gstr_3b_doc = $upload_gstr_3b_doc_fileData['file_name'];
                                    }
                                }elseif(isset($comdata[0]->gstr_3b_doc) && !empty($comdata[0]->gstr_3b_doc)){
                                    $upload_gstr_3b_doc = $comdata[0]->gstr_3b_doc;
                                }
                        }
                        $tds_confirm_date = '';
                        $upload_tds_doc = '';
                        if(isset($tds_confirmation_date) && !empty($tds_confirmation_date)){
                                $tds_confirm_date = date('Y-m-d',strtotime($tds_confirmation_date));
                                if(isset($_FILES['tds_doc']['name']) && !empty($_FILES['tds_doc']['name'])){
                                    $upload_tds_doc = $_FILES['tds_doc']['name'];
                                    $upload_tds_doc_fileImg = array(
                                        'upload_path' =>'./uploads/compliance_upload/',
                                        'fieldname' => 'tds_doc',
                                        'encrypt_name' => TRUE,        
                                        'overwrite' => FALSE,
                                        'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG');
                                    $upload_tds_doc_fileImg = $this->imageupload->image_upload($upload_tds_doc_fileImg);
                                    $errormsg= $this->upload->display_errors();
                                    if(isset($upload_tds_doc_fileImg) && !empty($upload_tds_doc_fileImg)){
                                        $upload_tds_doc_fileData = $this->upload->data();      
                                        $upload_tds_doc = $upload_tds_doc_fileData['file_name'];
                                    }
                                }elseif(isset($comdata[0]->tds_doc) && !empty($comdata[0]->tds_doc)){
                                    $upload_tds_doc = $comdata[0]->tds_doc;
                                }
                        }
                        $proof_tax_confirm_date = '';
                        $upload_proof_tax_doc = '';
                        if(isset($proof_tax_confirmation_date) && !empty($proof_tax_confirmation_date)){
                                $proof_tax_confirm_date = date('Y-m-d',strtotime($proof_tax_confirmation_date));
                                if(isset($_FILES['proof_tax_doc']['name']) && !empty($_FILES['proof_tax_doc']['name'])){
                                    $upload_proof_tax_doc = $_FILES['proof_tax_doc']['name'];
                                    $upload_proof_tax_doc_fileImg = array(
                                        'upload_path' =>'./uploads/compliance_upload/',
                                        'fieldname' => 'proof_tax_doc',
                                        'encrypt_name' => TRUE,        
                                        'overwrite' => FALSE,
                                        'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG');
                                    $upload_proof_tax_doc_fileImg = $this->imageupload->image_upload($upload_proof_tax_doc_fileImg);
                                    $errormsg= $this->upload->display_errors();
                                    if(isset($upload_proof_tax_doc_fileImg) && !empty($upload_proof_tax_doc_fileImg)){
                                        $upload_proof_tax_doc_fileData = $this->upload->data();      
                                        $upload_proof_tax_doc = $upload_proof_tax_doc_fileData['file_name'];
                                    }
                                }elseif(isset($comdata[0]->proof_tax_doc) && !empty($comdata[0]->proof_tax_doc)){
                                    $upload_proof_tax_doc = $comdata[0]->proof_tax_doc;
                                }
                        }
                        $pro_fund_confirm_date = '';
                        $upload_pro_fund_doc = '';
                        if(isset($pro_fund_confirmation_date) && !empty($pro_fund_confirmation_date)){
                                $pro_fund_confirm_date = date('Y-m-d',strtotime($pro_fund_confirmation_date));
                                if(isset($_FILES['pro_fund_doc']['name']) && !empty($_FILES['pro_fund_doc']['name'])){
                                    $upload_pro_fund_doc = $_FILES['pro_fund_doc']['name'];
                                    $upload_pro_fund_doc_fileImg = array(
                                        'upload_path' =>'./uploads/compliance_upload/',
                                        'fieldname' => 'pro_fund_doc',
                                        'encrypt_name' => TRUE,        
                                        'overwrite' => FALSE,
                                        'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG');
                                    $upload_pro_fund_doc_fileImg = $this->imageupload->image_upload($upload_pro_fund_doc_fileImg);
                                    $errormsg= $this->upload->display_errors();
                                    if(isset($upload_pro_fund_doc_fileImg) && !empty($upload_pro_fund_doc_fileImg)){
                                        $upload_pro_fund_doc_fileData = $this->upload->data();      
                                        $upload_pro_fund_doc = $upload_pro_fund_doc_fileData['file_name'];
                                    }
                                }elseif(isset($comdata[0]->pro_fund_doc) && !empty($comdata[0]->pro_fund_doc)){
                                    $upload_pro_fund_doc = $comdata[0]->pro_fund_doc;
                                }
                        }
                        $esic_confirm_date = '';
                        $upload_esic_doc = '';
                        if(isset($esic_confirmation_date) && !empty($esic_confirmation_date)){
                                $esic_confirm_date = date('Y-m-d',strtotime($esic_confirmation_date));
                                if(isset($_FILES['esic_doc']['name']) && !empty($_FILES['esic_doc']['name'])){
                                    $upload_esic_doc = $_FILES['esic_doc']['name'];
                                    $upload_esic_doc_fileImg = array(
                                        'upload_path' =>'./uploads/compliance_upload/',
                                        'fieldname' => 'esic_doc',
                                        'encrypt_name' => TRUE,        
                                        'overwrite' => FALSE,
                                        'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG');
                                    $upload_esic_doc_fileImg = $this->imageupload->image_upload($upload_esic_doc_fileImg);
                                    $errormsg= $this->upload->display_errors();
                                    if(isset($upload_esic_doc_fileImg) && !empty($upload_esic_doc_fileImg)){
                                        $upload_esic_doc_fileData = $this->upload->data();      
                                        $upload_esic_doc = $upload_esic_doc_fileData['file_name'];
                                    }
                                }elseif(isset($comdata[0]->esic_doc) && !empty($comdata[0]->esic_doc)){
                                    $upload_esic_doc = $comdata[0]->esic_doc;
                                }
                        }
                        if($error == 'N'){
                            if(isset($comdata) && !empty($comdata)){
                                if(isset($gstr_1a_confirmation_date) && !empty($gstr_1a_confirmation_date)){
                                    if(isset($_FILES['upload_gtds_docs']['name']) && empty($_FILES['upload_gtds_docs']['name'])
                                    && isset($comdata[0]->gstr_1a_doc) && empty($comdata[0]->gstr_1a_doc)){
                                        $error = 'Y';
                                        $error_message = 'Please upload GSTR-1A Confirmation Document!';
                                    }else{
                                        if(isset($gstr_1a_confirm_date) && !empty($gstr_1a_confirm_date)
                                        && isset($upload_gtds_doc) && !empty($upload_gtds_doc)){
                                        $updatearr1 = array("gstr_1a_confirm_date" => $gstr_1a_confirm_date,"gstr_1a_doc" => $upload_gtds_doc,'updated_by'=>$updated_by,'updated_date'=>date('Y-m-d H:i:s'));
                                        $this->common_model->updateDetailscomp('tbl_compliance','month',$month,'year',$year,$updatearr1);
                                        }
                                    }
                                }else{
                                    $updatearr1 = array("gstr_1a_confirm_date" => '',"gstr_1a_doc" => '','updated_by'=>$updated_by,'updated_date'=>date('Y-m-d H:i:s'));
                                    $this->common_model->updateDetailscomp('tbl_compliance','month',$month,'year',$year,$updatearr1);
                                }
                                if(isset($proof_tax_confirmation_date) && !empty($proof_tax_confirmation_date)){
                                    if(isset($_FILES['proof_tax_doc']['name']) && empty($_FILES['proof_tax_doc']['name'])
                                    && isset($comdata[0]->proof_tax_doc) && empty($comdata[0]->proof_tax_doc)){
                                        $error = 'Y';
                                        $error_message = 'Please upload Professional Tax (PT) Confirmation Document!';
                                    }else{
                                        if(isset($proof_tax_confirm_date) && !empty($proof_tax_confirm_date)
                                        && isset($upload_proof_tax_doc) && !empty($upload_proof_tax_doc)){
                                        $updatearr2 = array("proof_tax_confirm_date" => $proof_tax_confirm_date,"proof_tax_doc" => $upload_proof_tax_doc,'updated_by'=>$updated_by,'updated_date'=>date('Y-m-d H:i:s'));
                                        $this->common_model->updateDetailscomp('tbl_compliance','month',$month,'year',$year,$updatearr2);
                                        }
                                    }
                                }else{
                                    $updatearr2 = array("proof_tax_confirm_date" => '',"proof_tax_doc" => '','updated_by'=>$updated_by,'updated_date'=>date('Y-m-d H:i:s'));
                                    $this->common_model->updateDetailscomp('tbl_compliance','month',$month,'year',$year,$updatearr2);
                                }
                                if(isset($gstr_3b_confirmation_date) && !empty($gstr_3b_confirmation_date)){
                                    if(isset($_FILES['gstr_3b_doc']['name']) && empty($_FILES['gstr_3b_doc']['name'])
                                    && isset($comdata[0]->gstr_3b_doc) && empty($comdata[0]->gstr_3b_doc)){
                                        $error = 'Y';
                                        $error_message = 'Please upload GSTR-3B Confirmation Document!';
                                    }else{
                                        if(isset($gstr_3b_confirm_date) && !empty($gstr_3b_confirm_date)
                                        && isset($upload_gstr_3b_doc) && !empty($upload_gstr_3b_doc)){
                                        $updatearr3 = array("gstr_3b_confirm_date" => $gstr_3b_confirm_date,"gstr_3b_doc" => $upload_gstr_3b_doc,'updated_by'=>$updated_by,'updated_date'=>date('Y-m-d H:i:s'));
                                        $this->common_model->updateDetailscomp('tbl_compliance','month',$month,'year',$year,$updatearr3);
                                        }
                                    }
                                }else{
                                    $updatearr3 = array("gstr_3b_confirm_date" => '',"gstr_3b_doc" => '','updated_by'=>$updated_by,'updated_date'=>date('Y-m-d H:i:s'));
                                    $this->common_model->updateDetailscomp('tbl_compliance','month',$month,'year',$year,$updatearr3);
                                }
                                if(isset($pro_fund_confirmation_date) && !empty($pro_fund_confirmation_date)){
                                    if(isset($_FILES['pro_fund_doc']['name']) && empty($_FILES['pro_fund_doc']['name'])
                                    && isset($comdata[0]->pro_fund_doc) && empty($comdata[0]->pro_fund_doc)){
                                        $error = 'Y';
                                        $error_message = 'Please upload Provident Fund (PF) Confirmation Document!';
                                    }else{
                                        if(isset($pro_fund_confirm_date) && !empty($pro_fund_confirm_date)
                                        && isset($upload_pro_fund_doc) && !empty($upload_pro_fund_doc)){
                                        $updatearr4 = array("pro_fund_confirm_date" => $pro_fund_confirm_date,"pro_fund_doc" => $upload_pro_fund_doc,'updated_by'=>$updated_by,'updated_date'=>date('Y-m-d H:i:s'));
                                        $this->common_model->updateDetailscomp('tbl_compliance','month',$month,'year',$year,$updatearr4);
                                        }
                                    }
                                }else{
                                    $updatearr4 = array("pro_fund_confirm_date" => '',"pro_fund_doc" => '','updated_by'=>$updated_by,'updated_date'=>date('Y-m-d H:i:s'));
                                    $this->common_model->updateDetailscomp('tbl_compliance','month',$month,'year',$year,$updatearr4);
                                }
                                if(isset($tds_confirmation_date) && !empty($tds_confirmation_date)){
                                    if(isset($_FILES['tds_doc']['name']) && empty($_FILES['tds_doc']['name'])
                                    && isset($comdata[0]->tds_doc) && empty($comdata[0]->tds_doc)){
                                        $error = 'Y';
                                        $error_message = 'Please upload TDS Confirmation Document!';
                                    }else{
                                        if(isset($tds_confirm_date) && !empty($tds_confirm_date)
                                        && isset($upload_tds_doc) && !empty($upload_tds_doc)){
                                        $updatearr5 = array("tds_confirm_date" => $tds_confirm_date,"tds_doc" => $upload_tds_doc,'updated_by'=>$updated_by,'updated_date'=>date('Y-m-d H:i:s'));
                                        $this->common_model->updateDetailscomp('tbl_compliance','month',$month,'year',$year,$updatearr5);
                                        }
                                    }
                                }else{
                                    $updatearr5 = array("tds_confirm_date" => '',"tds_doc" => '','updated_by'=>$updated_by,'updated_date'=>date('Y-m-d H:i:s'));
                                    $this->common_model->updateDetailscomp('tbl_compliance','month',$month,'year',$year,$updatearr5);
                                }
                                if(isset($esic_confirmation_date) && !empty($esic_confirmation_date)){
                                    if(isset($_FILES['esic_doc']['name']) && empty($_FILES['esic_doc']['name'])
                                    && isset($comdata[0]->esic_doc) && empty($comdata[0]->esic_doc)){
                                        $error = 'Y';
                                        $error_message = 'Please upload ESIC Confirmation Document!';
                                    }else{
                                        if(isset($esic_confirm_date) && !empty($esic_confirm_date)
                                            && isset($upload_esic_doc) && !empty($upload_esic_doc)){
                                            $updatearr6 = array("esic_confirm_date" => $esic_confirm_date,"esic_doc" => $upload_esic_doc,'updated_by'=>$updated_by,'updated_date'=>date('Y-m-d H:i:s'));
                                            $this->common_model->updateDetailscomp('tbl_compliance','month',$month,'year',$year,$updatearr6);
                                        }
                                    }
                                }else{
                                    $updatearr6 = array("esic_confirm_date" => '',"esic_doc" => '','updated_by'=>$updated_by,'updated_date'=>date('Y-m-d H:i:s'));
                                    $this->common_model->updateDetailscomp('tbl_compliance','month',$month,'year',$year,$updatearr6);
                                }
                                if($error == 'N'){
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE,
                                        'msg'=>'<div class="alert modify alert-info">Compliance Details Saved Successfully!</div>',
                                        'redirect' => base_url().'add-or-view-compliance'
                                    ));
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                                    ));
                                }
                            }else{
                                if(isset($gstr_1a_confirmation_date) && !empty($gstr_1a_confirmation_date)){
                                    if(isset($_FILES['upload_gtds_docs']['name']) && empty($_FILES['upload_gtds_docs']['name'])){
                                        $error = 'Y';
                                        $error_message = 'Please upload GSTR-1A Confirmation Document!';
                                    }
                                }
                                if(isset($proof_tax_confirmation_date) && !empty($proof_tax_confirmation_date)){
                                    if(isset($_FILES['proof_tax_doc']['name']) && empty($_FILES['proof_tax_doc']['name'])){
                                        $error = 'Y';
                                        $error_message = 'Please upload Professional Tax (PT) Confirmation Document!';
                                    }
                                }
                                if(isset($gstr_3b_confirmation_date) && !empty($gstr_3b_confirmation_date)){
                                    if(isset($_FILES['gstr_3b_doc']['name']) && empty($_FILES['gstr_3b_doc']['name'])){
                                        $error = 'Y';
                                        $error_message = 'Please upload GSTR-3B Confirmation Document!';
                                    }
                                }
                                if(isset($pro_fund_confirmation_date) && !empty($pro_fund_confirmation_date)){
                                    if(isset($_FILES['pro_fund_doc']['name']) && empty($_FILES['pro_fund_doc']['name'])){
                                        $error = 'Y';
                                        $error_message = 'Please upload Provident Fund (PF) Confirmation Document!';
                                    }
                                }
                                if(isset($tds_confirmation_date) && !empty($tds_confirmation_date)){
                                    if(isset($_FILES['tds_doc']['name']) && empty($_FILES['tds_doc']['name'])){
                                        $error = 'Y';
                                        $error_message = 'Please upload TDS Confirmation Document!';
                                    }
                                }
                                if(isset($esic_confirmation_date) && !empty($esic_confirmation_date)){
                                    if(isset($_FILES['esic_doc']['name']) && empty($_FILES['esic_doc']['name'])){
                                        $error = 'Y';
                                        $error_message = 'Please upload ESIC Confirmation Document!';
                                    }
                                }
                                $save_array = array(
                                    "month" => $month,
                                    "year" => $year,
                                    "gstr_1a_confirm_date" => $gstr_1a_confirm_date,
                                    "gstr_1a_doc" => $upload_gtds_doc,
                                    "gstr_3b_confirm_date" => $gstr_3b_confirm_date,
                                    "gstr_3b_doc" => $upload_gstr_3b_doc,
                                    "tds_confirm_date" => $tds_confirm_date,
                                    "tds_doc" => $upload_tds_doc,
                                    "proof_tax_confirm_date" => $proof_tax_confirm_date,
                                    "proof_tax_doc" => $upload_proof_tax_doc,
                                    "pro_fund_confirm_date" => $pro_fund_confirm_date,
                                    "pro_fund_doc" => $upload_pro_fund_doc,
                                    "esic_confirm_date" => $esic_confirm_date,
                                    "esic_doc" => $upload_esic_doc,
                                    "created_by" => $user_id,
                                    "created_at" => date('Y-m-d H:i:s')
                                );
                                if($error == "N"){
                                    if(isset($save_array) && !empty($save_array)){
                                        $this->common_model->addData('tbl_compliance',$save_array);
                                        $this->json->jsonReturn(array(
                                            'valid'=>TRUE,
                                            'msg'=>'<div class="alert modify alert-info">Compliance Details Saved Successfully!</div>',
                                            'redirect' => base_url().'add-or-view-compliance'
                                        ));    
                                    }else{
                                        $this->json->jsonReturn(array(
                                            'valid'=>FALSE,
                                            'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Compliance Details!!</div>'
                                        ));    
                                    }
                            
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                                    ));
                                }
                        }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                            ));
                        }
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                        ));
                    }
                }else{
                    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger">You have no Permission!!</div>'
                    ));
                }
            }else{
                $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger">You have no Permission!!</div>'
                ));
            }
		}else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">You have no Permission!!</div>'
            ));
        }
        
    }



public function compliance_list(){
    $user_id = $this->session->userData('user_id');
    if(isset($user_id) && !empty($user_id)){
		$data = $row = array();
		$memData = $this->admin_model->compliance_data($_POST);
		$allCount = $this->admin_model->countcompliance_data();
		$countFiltered = $this->admin_model->compliance_dataListFiltered($_POST);
        
        $i = $_POST['start'];
		foreach($memData as $member){
            
            $i++;
            if(isset($member->month) && !empty($member->month)) { $month = $member->month; }else { $month = '-'; }
            if(isset($member->gstr_1a_confirm_date) && !empty($member->gstr_1a_confirm_date) && $member->gstr_1a_confirm_date !='0000-00-00') { $gstr_1a = date('d-m-Y',strtotime($member->gstr_1a_confirm_date)); }else { $gstr_1a = '-'; }
			if(isset($member->gstr_3b_confirm_date) && !empty($member->gstr_3b_confirm_date) && $member->gstr_3b_confirm_date !='0000-00-00') { $gstr_3b = date('d-m-Y',strtotime($member->gstr_3b_confirm_date)); }else { $gstr_3b = '-'; }
			if(isset($member->tds_confirm_date) && !empty($member->tds_confirm_date) && $member->tds_confirm_date !='0000-00-00') { $tds_date = date('d-m-Y',strtotime($member->tds_confirm_date)); }else { $tds_date = '-'; }
			if(isset($member->proof_tax_confirm_date) && !empty($member->proof_tax_confirm_date) && $member->proof_tax_confirm_date !='0000-00-00') { $proof_tax_date = date('d-m-Y',strtotime($member->proof_tax_confirm_date)); }else { $proof_tax_date = '-'; }
			if(isset($member->pro_fund_confirm_date) && !empty($member->pro_fund_confirm_date) && $member->pro_fund_confirm_date !='0000-00-00') { $pf_fund_date = date('d-m-Y',strtotime($member->pro_fund_confirm_date)); }else { $pf_fund_date = '-'; }
			if(isset($member->esic_confirm_date) && !empty($member->esic_confirm_date) && $member->esic_confirm_date !='0000-00-00') { $esic_date = $member->esic_confirm_date; }else { $esic_date = '-'; }
            if(isset($member->gstr_1a_doc) && !empty($member->gstr_1a_doc)) { $gstr_1a_doc = '<a href="'.base_url().'uploads/compliance_upload/'.$member->gstr_1a_doc.'" download="">Download</a>'; }else { $gstr_1a_doc = '-'; }
            if(isset($member->gstr_3b_doc) && !empty($member->gstr_3b_doc)) { $gstr_3b_doc = '<a href="'.base_url().'uploads/compliance_upload/'.$member->gstr_3b_doc.'" download="">Download</a>'; }else { $gstr_3b_doc = '-'; }
            if(isset($member->tds_doc) && !empty($member->tds_doc)) { 
                $tds_doc = '<a href="'.base_url().'uploads/compliance_upload/'.$member->tds_doc.'" download="">Download</a>';
            }else{
                $tds_doc = '-'; 
            }
			if(isset($member->proof_tax_doc) && !empty($member->proof_tax_doc)) { 
                $proof_tax_doc = '<a href="'.base_url().'uploads/compliance_upload/'.$member->proof_tax_doc.'" download="">Download</a>';
            }else{
                $proof_tax_doc = '-'; 
            }
			if(isset($member->pro_fund_doc) && !empty($member->pro_fund_doc)) { 
                $pro_fund_doc = '<a href="'.base_url().'uploads/compliance_upload/'.$member->pro_fund_doc.'" download="">Download</a>';
            }else{
                $pro_fund_doc = '-'; 
            }
			if(isset($member->esic_doc) && !empty($member->esic_doc)) { 
                $esic_doc = '<a href="'.base_url().'uploads/compliance_upload/'.$member->esic_doc.'" download="">Download</a>';
            }else{
                $esic_doc = '-'; 
            }
            if(isset($member->created_at) && !empty($member->created_at)) { $created_on = $member->created_at; }else { $created_on = '-'; }
			$htmlp = '<a class="popup_save" href="javascript:void(0);" rev="view_dcpwip_items" rel="'.$member->id.'" data-title="(#'.$member->id.') Provisional WIP Item List" data-status="allow" style="margin-top:10px;"><span class="md-click-circle md-click-animate" style="height: 97px; width: 97px; top: -38.5312px; left: 29.4896px;"></span> '.$member->id.'</a>';
			$data[] = array(
			$i,
            $month,
            $gstr_1a,
            $gstr_3b,
            $tds_date,
            $proof_tax_date,
            $pf_fund_date,
            $esic_date,
            $gstr_1a_doc,
            $gstr_3b_doc,
            $tds_doc,
            $proof_tax_doc,
            $pro_fund_doc,
            $esic_doc,
			$created_on,
			$html
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
	}
}

public function view_compliance(){
    $user_id = $this->session->userData('user_id');
    $error = 'N';
    $error_message = '';
    if(isset($user_id) && empty($user_id)){
    $error = 'Y';
    $error_message = 'Please loggedin!';
    }
    if(isset($user_id) && !empty($user_id)){
        $month = $this->input->post('month');
        if(isset($month) && empty($month)){
        $error = 'Y';
        $error_message = 'Please select month!';
        }
        $year = $this->input->post('year');
        if(isset($year) && empty($year)){
        $error = 'Y';
        $error_message = 'Please select year!';
        }
        if($error == 'N'){
            $comdata = $this->common_model->selectMultiDataForcom('tbl_compliance','month','year',$month,$year);
            if(isset($comdata) && !empty($comdata)){
            if(isset($comdata[0]->gstr_1a_confirm_date) && !empty($comdata[0]->gstr_1a_confirm_date) && $comdata[0]->gstr_1a_confirm_date !='0000-00-00') { $comdata[0]->gstr_1a_confirm_date = date('d-m-Y',strtotime($comdata[0]->gstr_1a_confirm_date)); }
			if(isset($comdata[0]->gstr_3b_confirm_date) && !empty($comdata[0]->gstr_3b_confirm_date) && $comdata[0]->gstr_3b_confirm_date !='0000-00-00') { $comdata[0]->gstr_3b_confirm_date = date('d-m-Y',strtotime($comdata[0]->gstr_3b_confirm_date)); }
			if(isset($comdata[0]->tds_confirm_date) && !empty($comdata[0]->tds_confirm_date) && $comdata[0]->tds_confirm_date !='0000-00-00') { $comdata[0]->tds_confirm_date = date('d-m-Y',strtotime($comdata[0]->tds_confirm_date)); }
			if(isset($comdata[0]->proof_tax_confirm_date) && !empty($comdata[0]->proof_tax_confirm_date) && $comdata[0]->proof_tax_confirm_date !='0000-00-00') { $comdata[0]->proof_tax_confirm_date = date('d-m-Y',strtotime($comdata[0]->proof_tax_confirm_date)); }
			if(isset($comdata[0]->pro_fund_confirm_date) && !empty($comdata[0]->pro_fund_confirm_date) && $comdata[0]->pro_fund_confirm_date !='0000-00-00') { $comdata[0]->pro_fund_confirm_date = date('d-m-Y',strtotime($comdata[0]->pro_fund_confirm_date)); }
			if(isset($comdata[0]->esic_confirm_date) && !empty($comdata[0]->esic_confirm_date) && $comdata[0]->esic_confirm_date !='0000-00-00') { $comdata[0]->esic_confirm_date = date('d-m-Y',strtotime($comdata[0]->esic_confirm_date)); }
            
            $data['comdata'] = $comdata;
            $this->json->jsonReturn(array(
                'valid'=>TRUE,
                'data' => $data
            ));
            }else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">No data found</div>'
            ));
        }
        }else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
            ));
        }
    }else{
        $this->json->jsonReturn(array(
            'valid'=>FALSE,
            'msg'=>'<div class="alert modify alert-danger">Invalid LoggedIn!!</div>'
        ));
    }
}
    
}