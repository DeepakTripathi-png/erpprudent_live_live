<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Authentication
{
 
	function _construct() 
	{
	    $CI =& get_instance();
	    $CI->load->database('database');
		$CI->load->library("session");
	}
	
	function chk_login()
	{
		
		$CI =& get_instance();
		$user = $CI->session->userdata('user_id');
		return ($user) ? $user : false;
	}
	function login($username,$password,$roleId) 
	{     
		$CI =& get_instance();  	

		if(isset($roleId) && !empty($roleId) && ($roleId==2))
		{
			$condition = array('inst_code' => $username, 'password' => $password, 'status'=>'Active');
			$CI->db->where($condition);
	    	$query = $CI->db->get_where("tbl_institute");	
		}
		else
		{
			
			$CI->db->where('username',$username)->where('password',$password)->where('display','Y')->where('user_status','Active');
	    	$query = $CI->db->get_where("tbl_user");
		} 

		// var_dump($query->num_rows());
	    // exit;
		if($query->num_rows()!=1)
		{   
			return false;
		}     
		else 
		{
			if(isset($roleId) && !empty($roleId) && ($roleId==2))
			{
				$CI->session->set_userdata("inst_id",$query->row()->inst_id);		 
				$CI->session->set_userdata("role_id",$query->row()->role_id);
				$CI->session->set_userdata("user_name",$query->row()->inst_name);
				$CI->session->set_userdata("mobile", $query->row()->contact);
				$CI->session->set_userdata("email", $query->row()->email);	
				$CI->session->set_userdata("ISlogin", true);         
				$CI->session->sess_expire_on_close = TRUE;
			}
			else	
			{
				$CI->session->set_userdata("username", $query->row()->username);
				$CI->session->set_userdata("fullname", $query->row()->fullname);
				$CI->session->set_userdata("mobile", $query->row()->mobile);
				$CI->session->set_userdata("email", $query->row()->email);
				$CI->session->set_userdata("user_id", $query->row()->user_id);
				$CI->session->set_userdata("role_id", $query->row()->role_id);	
		 		$CI->session->set_userdata("ISlogin", true);
			}		
			return true;     
		}
	}
	function admin_logout() 
	{	     
		$CI =& get_instance();
		$CI->session->unset_userdata("id");
		$CI->session->unset_userdata("full_name");
		$CI->session->unset_userdata("word_count");
		$CI->session->unset_userdata("email");
		$CI->session->unset_userdata("user_id");
		$CI->session->unset_userdata("role_id");
		$CI->session->unset_userdata("ISlogin");
	}
} ?>
