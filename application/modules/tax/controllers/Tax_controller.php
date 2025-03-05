<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_controller extends Base_Controller 
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
	public function tax_list()
	{
		$data['tax_data']=$this->common_model->fetchDataDesc('tbl_tax','tax_id');
		$this->load->view('tax-list',$data);
	}
    public function add_tax()
	{
		$this->load->view('add-tax');
	}
	public function save_tax()
	{
		$user_id=$this->session->userdata('user_id');
		$id=$this->input->post('id');
		$tax_name =$this->input->post('tax_name');
		$percentage_tax =$this->input->post('percentage_tax');
		$data = array('tax_name'=>$tax_name, 'percentage_tax'=>$percentage_tax);
		if(isset($id) && !empty($id))
		{
			$data['modified_by']=$user_id;
			$data['modified_on']=date('Y-m-d H:i:s');
			$result=$this->common_model->updateDetails('tbl_tax','tax_id',$id,$data);
			if($result)
			{
				$this->json->jsonReturn(array(
					'valid'=>TRUE,
					'msg'=>'<div class="alert modify alert-info"><strong>Welldone!</strong> Tax Details Updated Successfully.</div>'
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
			$result=$this->common_model->addData('tbl_tax',$data);
			if($result)
			{
				$this->json->jsonReturn(array(
					'valid'=>TRUE,
					'msg'=>'<div class="alert modify alert-info"><strong>Welldone!</strong> Tax Details Saved Successfully.</div>',
					 'redirect' => base_url().'tax-list'
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
	public function edit_tax()
	{
		$id=$this->input->post('id');
		$data['tax_data']=$this->common_model->selectDetailsWhr('tbl_tax','tax_id',$id);
		$this->load->view('add-tax',$data);   
	}
}
