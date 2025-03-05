<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_controller extends Base_Controller
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
		$this->load->model('admin_model');


	}
	public function add_category()
	{
		$loguser_id = $this->session->userData('user_id');
			$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
			$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','add_category');
			if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
				$submenu_id = $submenu_data->submenu_id;
				$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
				if(isset($check_permission) && !empty($check_permission)){
					$id = $this->input->post('id');
					$data['category_data']=$this->common_model->fetchDataDesc('tbl_category','category_id');
					$this->load->view('add-category');
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

	public function category_list()
	{
		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
			$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','category_list');
			if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
				$submenu_id = $submenu_data->submenu_id;
				$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
				if(isset($check_permission) && !empty($check_permission)){
					$check_permission_add = 'N';
					$submenu_dataa=$this->common_model->selectDetailsWhr('tbl_submenu','action','add_category');
					if(isset($submenu_dataa->submenu_id) && !empty($submenu_dataa->submenu_id)){
						$asubmenu_id = $submenu_dataa->submenu_id;
						$check_permissiona=$this->admin_model->check_permission($asubmenu_id,$logrole_id);
						if(isset($check_permissiona) && !empty($check_permissiona)){
							$check_permission_add = 'Y';
						}
					}
					$check_permission_update = 'N';
					$submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_category');
					if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
						$usubmenu_id = $submenu_datau->submenu_id;
						$check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
						if(isset($check_permissionu) && !empty($check_permissionu)){
							$check_permission_update = 'Y';
						}
					}
					$check_permission_delete = 'N';
					$submenu_datad=$this->common_model->selectDetailsWhr('tbl_submenu','action','delete_category');
					if(isset($submenu_datad->submenu_id) && !empty($submenu_datad->submenu_id)){
						// pr($submenu_datad,1);
						$dsubmenu_id = $submenu_datau->submenu_id;
						$check_permissiond=$this->admin_model->check_permission($dsubmenu_id,$logrole_id);
						if(isset($check_permissiond) && !empty($check_permissiond)){
							$check_permission_delete = 'Y';
						}
					}
					$data['check_permission_update'] = $check_permission_update;
					$data['check_permission_add'] = $check_permission_add;
					$data['check_permission_delete'] = $check_permission_delete;

					$data['category_data']=$this->common_model->fetchDataDesc('tbl_category','category_id');
					$this->load->view('category-list',$data);
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
	public function save_category()
	{
		$user_id=$this->session->userdata('user_id');
		$id=$this->input->post('id');
		$category_name =$this->input->post('category_name');
		$data = array('category_name'=>$category_name);
		if(isset($id) && !empty($id))
		{
			$data['modified_by']=$user_id;
			$data['modified_on']=date('Y-m-d H:i:s');
			$result=$this->common_model->updateDetails('tbl_category','category_id',$id,$data);
			if($result)
			{
				$this->json->jsonReturn(array(
					'valid'=>TRUE,
					'msg'=>'<div class="alert modify alert-success">category Details Updated Successfully!</div>',
					'redirect' => base_url().'category_list'
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
			$result=$this->common_model->addData('tbl_category',$data);
			if($result)
			{
				$this->json->jsonReturn(array(
					'valid'=>TRUE,
					'msg'=>'<div class="alert modify alert-success"><strong>Welldone!</strong>Category Details Saved Successfully.</div>',
					'redirect' => base_url().'category_list'
				));

			}
			else
			{
				$this->json->jsonReturn(array(
					'valid'=>FALSE,
					'msg'=>'<div class="alert modify alert-danger"><strong>Oops!</strong>Something Went Wrong.</div>'
				));
			}
		}
	}
	public function edit_category()
	{
		$id=$this->input->post('id');
		$data['category_data']=$this->common_model->selectDetailsWhr('tbl_category','category_id',$id);
		$this->load->view('add-category',$data);
	}
	public function delete_category()
	{
		// pr($_POST,1);
		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		$submenu_datad=$this->common_model->selectDetailsWhr('tbl_submenu','action','delete_category');

		if(isset($submenu_datad->submenu_id) && !empty($submenu_datad->submenu_id)){
			$dsubmenu_id = $submenu_datad->submenu_id;
			$check_permissiond=$this->admin_model->check_permission($dsubmenu_id,$logrole_id);
			if(isset($check_permissiond) && !empty($check_permissiond)){
				$id=$this->input->post('id');
				$data=array('display'=>'N');
				$result=$this->common_model->updateDetails('tbl_category','category_id',$id,$data);
				// pr($result,1);
				if($result)
				{
					$this->json->jsonReturn(array(
						'valid'=>TRUE,
						'msg'=>'<div class="alert modify alert-success"><strong>Welldone!</strong> Record Deleted Successfully.</div>'
					));
				}
				else
				{
					$this->json->jsonReturn(array(
						'valid'=>FALSE,
						'msg'=>'<div class="alert modify alert-danger"><strong>Oops! </strong> Something Went Wrong.</div>'
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

}
