<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Base_Controller {
	public function __construct()
  	{
	    parent::__construct(); 
        date_default_timezone_set("Asia/Kolkata"); 
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 2000);
        $value = base_url();
        setcookie("trackigo",$value, time()+3600*24,'/'); 
    }

	public function index()
    {
        if($this->authentication->chk_login())
        {
            redirect('dashboard');
        }
        else
        {
            $this->load->view('login');
        }
    }
     public function chk_login(){ 

        
        $username=$this->input->post('username');
        $password=$this->input->post('password');
        $roleId = $this->input->post('roleId');
        $valid = false;
        if (!isset($username) or strlen($username) == 0){
            $error = 'Please enter your user name.';
        }
        elseif (!isset($password) or strlen($password) == 0){
            $error = 'Please enter your password.';
        }
        else{
            // print_r($this->input->post());
       
            $valid=$this->authentication->login($username,$password,$roleId);
            if (!$valid) $error = 'Wrong user/password, please try again.';
        }
        if ($valid==true){   
            $role_id = $this->session->userdata("role_id"); 
            if($role_id==2)
            {    
                $data=array(
                    'valid' => TRUE,
                    'redirect' => base_url().'dashboard'
                );
            }
            else
            {
                $data=array(
                    'valid' => TRUE,
                    'redirect' => base_url().'dashboard'
                );
            }
        }
        else{
            $data=array(
                'valid' => FALSE,
                'msg' => $error
            );
        }
        $this->json->jsonReturn($data);
    }

    public function logout()
    {
        $this->authentication->logout();
        $role_id = $this->session->userdata("role_id"); 
        redirect('login');
    }
    public function admin_logout()
    {
        $this->authentication->admin_logout();
        $role_id = $this->session->userdata("role_id"); 
        redirect('login');
    }
}
