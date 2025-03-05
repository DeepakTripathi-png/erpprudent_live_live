<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Designation_controller extends Base_Controller 
{
	public function __construct()
  	{
	    parent::__construct();
	    date_default_timezone_set("Asia/Kolkata"); 
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 2000);
        $value = base_url();
        setcookie("multicare",$value, time()+3600*24,'/'); 
	    $this->load->model('common_model');
    }
	public function designation_list()
	{
		$data['designation_data']=$this->common_model->fetchDataDesc('tbl_designation','designation_id');
		$this->load->view('designation-list',$data);
	}
    public function add_designation()
	{
		$this->load->view('add-designation');
	}
	public function save_designation()
	{
		$user_id=$this->session->userdata('user_id');
		$id=$this->input->post('id');
		$designation_name =$this->input->post('designation_name');
		$designation_desc =$this->input->post('designation_desc');
		$data = array('designation_name'=>$designation_name, 'designation_desc'=>$designation_desc);
		if(isset($id) && !empty($id))
		{
			$data['modified_by']=$user_id;
			$data['modified_on']=date('Y-m-d H:i:s');
			$result=$this->common_model->updateDetails('tbl_designation','designation_id',$id,$data);
			if($result)
			{
				$this->json->jsonReturn(array(
					'valid'=>TRUE,
					'msg'=>'<div class="alert modify alert-info"><strong>Welldone!</strong> Designation Details Updated Successfully.</div>'
				));
			}
			else
			{
				$this->json->jsonReturn(array(
					'valid'=>FALSE,
					'msg'=>'<div class="alert modify alert-danger"><strong>Oops!</strong> Something Went Wrong.</div>'
				));
			}
		}
		else
		{
			$data['created_by']=$user_id;
            $data['created_on']=date('Y-m-d H:i:s');
			$result=$this->common_model->addData('tbl_designation',$data);
			if($result)
			{
				$this->json->jsonReturn(array(
					'valid'=>TRUE,
					'msg'=>'<div class="alert modify alert-info"><strong>Welldone!</strong> Designation Details Saved Successfully.</div>',
					 'redirect' => base_url().'designation-list'
				));

			}
			else
			{
				$this->json->jsonReturn(array(
					'valid'=>FALSE,
					'msg'=>'<div class="alert modify alert-danger"><strong>Oops!</strong> Something Went Wrong.</div>'
				));
			}
		}
	}
	public function edit_designation()
	{
		$id=$this->input->post('id');
		$data['designation_data']=$this->common_model->selectDetailsWhr('tbl_designation','designation_id',$id);
		$this->load->view('add-designation',$data);   
	}
}
