<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_controller extends Base_Controller 
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
	    $this->load->model('role_model');
	    
    }
	public function add_role() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','add-role');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $id = $this->input->post('id');
            		$data['role_data']=$this->common_model->fetchDataDesc('tbl_role','role_id');
            		$this->load->view('add-role');
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
	
    public function role_list() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','role-list');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_add = 'N';
                    $submenu_dataa=$this->common_model->selectDetailsWhr('tbl_submenu','action','add-role');
                    if(isset($submenu_dataa->submenu_id) && !empty($submenu_dataa->submenu_id)){
                        $asubmenu_id = $submenu_dataa->submenu_id;
                        $check_permissiona=$this->admin_model->check_permission($asubmenu_id,$logrole_id);
                        if(isset($check_permissiona) && !empty($check_permissiona)){
                            $check_permission_add = 'Y';
                        }
                    }
                    $check_permission_update = 'N';
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_role');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                    $check_permission_delete = 'N';
                    $submenu_datad=$this->common_model->selectDetailsWhr('tbl_submenu','action','delete_role');
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
                    $data['role_data']=$this->common_model->fetchDataDesc('tbl_role','role_id');
		            $this->load->view('role-list',$data);
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
	public function save_role()
	{
		$user_id=$this->session->userdata('user_id');
		$id=$this->input->post('id');
		$role_name =$this->input->post('role_name');
		$role_desc =$this->input->post('role_desc');
		$data = array('role_name'=>$role_name, 'role_desc'=>$role_desc);
		if(isset($id) && !empty($id))
		{
			$data['modified_by']=$user_id;
			$data['modified_on']=date('Y-m-d H:i:s');
			$result=$this->common_model->updateDetails('tbl_role','role_id',$id,$data);
			if($result)
			{
				$this->json->jsonReturn(array(
                    'valid'=>TRUE,
                    'msg'=>'<div class="alert modify alert-success">Role Details Updated Successfully!</div>',
                    'redirect' => base_url().'role-management'
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
			$result=$this->common_model->addData('tbl_role',$data);
			if($result)
			{
				$this->json->jsonReturn(array(
					'valid'=>TRUE,
					'msg'=>'<div class="alert modify alert-success"><strong>Welldone!</strong> Role Details Saved Successfully.</div>',
					 'redirect' => base_url().'role-list'
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
	public function edit_role()
	{
		$id=$this->input->post('id');
		$data['role_data']=$this->common_model->selectDetailsWhr('tbl_role','role_id',$id);
		$this->load->view('add-role',$data);   
	}
	public function delete_role()
	{   
	    $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		$submenu_datad=$this->common_model->selectDetailsWhr('tbl_submenu','action','delete_role');
        if(isset($submenu_datad->submenu_id) && !empty($submenu_datad->submenu_id)){
            $dsubmenu_id = $submenu_datau->submenu_id;
            $check_permissiond=$this->admin_model->check_permission($dsubmenu_id,$logrole_id);
            if(isset($check_permissiond) && !empty($check_permissiond)){
                $id=$this->input->post('id');
        		$data=array('display'=>'N');
        		$result=$this->common_model->updateDetails('tbl_role','role_id',$id,$data);
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
	public function role_management() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','role-management');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $data['role_data']=$this->common_model->fetchDataDesc('tbl_role','role_id');
                    $this->load->view('role-management',$data);
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
	public function fetch_role_config()
	{
		$role_id=$this->input->post('id');
		$data['role_menu_data']=$this->role_model->seperate_menu_list('role',$role_id);
		$data['role_manage_menu_data']=$this->role_model->seperate_menu_list('role_manage',$role_id);
		$data['users_menu_data']=$this->role_model->seperate_menu_list('users',$role_id);
		$data['oef_menu_data']=$this->role_model->seperate_menu_list('oef',$role_id);
		$data['boq_menu_data']=$this->role_model->seperate_menu_list('boq',$role_id);
		$data['boq_exceptional_menu_data']=$this->role_model->seperate_menu_list('boq_exceptional',$role_id);
		$data['boq_variable_disc_data']=$this->role_model->seperate_menu_list('boq_variable',$role_id);
		$data['dc_menu_data']=$this->role_model->seperate_menu_list('client_delivery_challan',$role_id);
		$data['iwip_menu_data']=$this->role_model->seperate_menu_list('installed_wip',$role_id);
		$data['pwip_menu_data']=$this->role_model->seperate_menu_list('provisional_wip',$role_id);
		$data['pinvoice_menu_data']=$this->role_model->seperate_menu_list('proforma_invc',$role_id);
		$data['tinvoice_menu_data']=$this->role_model->seperate_menu_list('tax_invc',$role_id);
		$data['payment_recpt_menu_data']=$this->role_model->seperate_menu_list('payment_recpt',$role_id);
		$data['invoive_closure_menu_data']=$this->role_model->seperate_menu_list('invoive_closure',$role_id);
		$data['project_closure_menu_data']=$this->role_model->seperate_menu_list('project_closure',$role_id);
		$data['compliance_menu_data']=$this->role_model->seperate_menu_list('compliance',$role_id);
		$data['reports_menu_data']=$this->role_model->seperate_menu_list('reports',$role_id);
		$data['bom_menu_data']=$this->role_model->seperate_menu_list('bom',$role_id);
		$data['vendor_data']=$this->role_model->seperate_menu_list('vendor',$role_id);
		
		$view=$this->load->view('prev_table',$data,true);
        $this->json->jsonReturn(array(
            'valid'=>true,
            'view'=>$view
        ));
	}
	public function save_role_config()
    {
		

        $role_id=$this->input->post('name_of_role');
        $submenu=$this->input->post('submenu');
		
        $result = $this->role_model->save_role_config($role_id,$submenu);

        
        if($result)
        {
            $this->json->jsonReturn(array(
                'valid'=>TRUE,
                'msg'=>'<div class="alert modify alert-success"> Role Configuration Saved Successfully!</div>',
                'redirect' => base_url().'role-management'
            ));
        }
        else
        {
            $this->json->jsonReturn(array(
                'valid'=>TRUE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Saving Role Configuration Details.</div>'
            ));
        } 
    }
}
