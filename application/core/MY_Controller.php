<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Base_Controller extends MX_Controller 
{
	protected $site_title="";
 	function __construct()
    {
        parent::__construct();
 		date_default_timezone_set('Asia/Kolkata');
        (isset($_POST))?$this->trimPostData($_POST):'';
        $this->brand_name="Hashtag";
	}

	/*
	-------------------------------------------------------------------------------------------------------------------
	Author 	: Sumit Darbeshwar																Date: 30 Mar 17
	-------------------------------------------------------------------------------------------------------------------
	Purpose: to notify users with the multiple ways sms, email, system notifications etc
	$details:array(
			'email'=>array(
				array('to'=>'email@gmail.com','msg'=>'text',attachments=>array('fileone.txt','file2.txt')),
				array('to'=>'email@gmail.com','msg'=>'text',attachments=>array('fileone.txt','file2.txt'))
			)
			'sms'=>array(
				array('mobile_no'=>'8149585982','msg'=>"text"),
				array('mobile_no'=>'8149585982','msg'=>"text")
			)
	);
	------OR---
	$details:array(
			'email'=>array('to'=>'email@gmail.com','msg'=>'text',attach=>array('fileone.txt','file2.txt')),
			'sms'=>array('to'=>'8149585982','msg'=>"text")
	);
	*/
	protected function notify($details)
	{
		log_message('error',print_r($details,TRUE));
		if(isset($details['email']) && is_array($details['email'])){
			$this->load->module('mail');
			if( isset($details['email']) && 
				is_array($details['email']) && 
				(count($details['email']) != count($details['email'], COUNT_RECURSIVE) ))
			{
				array_walk($details['email'], function($item,$key){
					$this->mail->send($item);
				});
			}
			else
			{
				$state=$this->mail->send($details['email']);
			}
		}

		if(isset($details['sms']) && is_array($details['sms'])){
			$this->load->module('sms/smscontroller');
			if(is_array($details['sms']) && (count($details['sms']) != count($details['sms'], COUNT_RECURSIVE))){
				array_walk($details['sms'], function($item,$key){
				/*$options=array('mobile_no'=>$item['mobile_no'], 'message'=>$item['msg']);*/
					$this->smscontroller->send($item);
				});
			}else if(is_array($details['sms']) && (count($details['sms']) == count($details['sms'], COUNT_RECURSIVE))){
				$this->smscontroller->send($details['sms']);
			}
			
		}
	} 
	/*
	-------------------------------------------------------------------------------------------------------------------
	Author 	: Sumit Darbeshwar																Date: 30 Mar 17
	-------------------------------------------------------------------------------------------------------------------
	Purpose: to notify users with the multiple ways sms, email, system notifications, keeps eye on the events and auto
	send information to admin
	$details=array(
		'type'=>'ERROR'| INFO |
		'msg'=>'text message' 
	)
	*/
	protected function monitor($details)
	{
		$this->config->load('mail/email', TRUE);
		$email_setting=$this->config->item('email');
		array_walk_recursive($details, function($item,$key){
			if(isset($item['type'])){
					$type=$item['type'];
					$options=array('to'=>$email_setting[$type],
								'subject'=>$type.' Auto email from the system ',
								'msg'=>$item['msg'],
								'attach'=>FALSE);
							$this->send->email($options);

			}
		});
	}

	/*
	---------------------------------------------------------------
	AUTHOR :Mahadev Mandole					Date:1-04-2017
	Description:
	----------------------------------------------------------------
	*/
	public function _setValidationRules($details,$tablename)
	{
		$this->load->config('validation_config',TRUE);
		$validation_rules= $this->config->item('validation_config');
		$error_array=array();
		$result=array();
		if (isset($validation_rules[$tablename]) && !empty($validation_rules[$tablename])) 
		{
			if(isset($details) && !empty($details) && isset($details[0]) && is_array($details[0]))
			{
				foreach ($details as $key => $record) 
				{
					$this->form_validation->set_error_delimiters('',',');
			        $this->form_validation->set_data($record);
			        $this->form_validation->set_rules($validation_rules[$tablename]);
			        $error_array[]=$this->form_validation->run();
				}
			}
			else
			{
				$this->form_validation->set_error_delimiters('',',');
			    $this->form_validation->set_data($details);
			    $this->form_validation->set_rules($validation_rules[$tablename]);
			    $error_array[]=$this->form_validation->run();
			}
			if (in_array(false,$error_array)) 
			{
				$result=array('state'=>FALSE,'errors'=>validation_errors());
		    }
		    else
		    { $result=array('state'=>TRUE,'errors'=>''); }
		}
		else { $result=array('state'=>FALSE,'errors'=>'No rules exist for given data!'); }
	    return $result;
	}
	/*-----------------------------------------------------------
		Author 	: Rupali Bora				Date: 07-04-2017
		Purpose: return version number
	-------------------------------------------------------------*/
	public function _getVersion()
	{
		$this->load->model('template/template_model');
        $version_no = $this->template_model->_getLatestVersionNo();
        if($version_no)
        	return $version_no;
        else
        	return false;
	}

	
}
 