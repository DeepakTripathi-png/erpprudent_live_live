<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_controller extends Base_Controller 
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
	public function unit_list()
	{
		$data['unit_data']=$this->common_model->fetchDataDesc('tbl_unit','unit_id');
		$this->load->view('unit-list',$data);
	}
    public function add_unit()
	{
		$this->load->view('add-unit');
	}
	public function save_unit()
	{
		$user_id=$this->session->userdata('user_id');
		$id=$this->input->post('id');
		$unit_name =$this->input->post('unit_name');
		$prefix_name =$this->input->post('prefix_name');
		$data = array('unit_name'=>$unit_name, 'prefix_name'=>$prefix_name);
		if(isset($id) && !empty($id))
		{
			$data['modified_by']=$user_id;
			$data['modified_on']=date('Y-m-d H:i:s');
			$result=$this->common_model->updateDetails('tbl_unit','unit_id',$id,$data);
			if($result)
			{
				$this->json->jsonReturn(array(
					'valid'=>TRUE,
					'msg'=>'<div class="alert modify alert-info"><strong>Welldone!</strong> Unit Details Updated Successfully.</div>'
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
			$result=$this->common_model->addData('tbl_unit',$data);
			if($result)
			{
				$this->json->jsonReturn(array(
					'valid'=>TRUE,
					'msg'=>'<div class="alert modify alert-info"><strong>Welldone!</strong> Unit Details Saved Successfully.</div>',
					 'redirect' => base_url().'unit-list'
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
	public function edit_unit()
	{
		$id=$this->input->post('id');
		$data['single_unit']=$this->common_model->selectDetailsWhr('tbl_unit','unit_id',$id);
		$this->load->view('add-unit',$data);   
	}
}
