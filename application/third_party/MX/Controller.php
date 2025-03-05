<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright	Copyright (c) 2015 Wiredesignz
 * @version 	5.5
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Controller 
{
	public $autoload = array();
	
	public function __construct() 
	{
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class." MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;	
		
		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);	
		
		/* autoload module items */
		$this->load->_autoloader($this->autoload);
	}
	
	public function __get($class) 
	{
		return CI::$APP->$class;
	}
	/*-------------------------------------------------------------------------------------------------------------------
	Author 	: Rahul Darbeshwar																Date: 30 Mar 17
	Purpose : removed extra space from the post array
	-------------------------------------------------------------------------------------------------------------------*/
	protected function trimPostData($postData, $postKey = FALSE)
	{
		foreach ($postData as $key => $val)
		{
			if(isset($postData[$key]) && ($postData[$key] != '') && isset($val))
			{
				if(is_array($val) && !empty($val))
					$this->trimPostData($val, $key);
				else{
					if(isset($postKey) && !empty($postKey))
        				$_POST[$postKey][$key] = trim(preg_replace('/\s{2,}/',' ', $val));
					else
        				$_POST[$key] = trim(preg_replace('/\s{2,}/',' ', $val));
				}
			}
		}
	}
	/*
	-------------------------------------------------------------------------------------------------------------------
	Author 	: Sumit Darbeshwar																Date: 30 Mar 17
	-------------------------------------------------------------------------------------------------------------------
	Purpose: to notify users with the multiple ways sms, email, system notifications etc
	*/
	protected function _defaultFields(&$fields,$update=false){
		$user=0;
		$this->load->module('user_mgmt/auth_api');
		$user_data=$this->auth_api->_getUser();
		if(!isset($user_data['user_id'])){
			$user=0;
		}
		else{
			$user=$user_data['user_id'];
		}
		if(!$update){
			
			$fields['inserted_by']=$user;
			$fields['inserted_on']=date('Y-m-d H:i:s');
		}
		$fields['modified_by']=$user;
		$fields['modified_on']=date('Y-m-d H:i:s');
	}
	/*
	-------------------------------------------------------------------------------------------------------------------
	Author 	: Sumit Darbeshwar																Date: 30 Mar 17
	-------------------------------------------------------------------------------------------------------------------
	Purpose: check the array and insert as per template
	$template=array('user_id'=>'','template'=>'','display'=>'Y');// standard fields to be used fro all array members
	$dataArray=array(array('template'=>90),array('template'=>90),array('template'=>90));
	OR
	$dataArray=array('template'=>90);
	*/
	protected function _defaultInsertFields($template,&$dataArray)
	{
		if(isset($template)&&is_array($template)){
			foreach ($dataArray as $key => &$data) {
				if(is_array($data)){
					$this->_defaultInsertFields($template,$data);
				}else{
					$this->setDefaultFields($dataArray,$template);
				}
			}
		}else{
			return FALSE;
		}
	}
	/*
	-------------------------------------------------------------------------------------------------------------------
	Author 	: Sumit Darbeshwar																Date: 30 Mar 17
	-------------------------------------------------------------------------------------------------------------------
	Purpose: checks indiviual entry and if its missing sets it 
	*/
	private function setDefaultFields(&$dataArray,&$template)
	{


		foreach ($template as $key => $value) {
			if(!isset($dataArray[$key]))
			{
				$dataArray[$key]=$value;	
			}
		}
	}
	/*
	-------------------------------------------------------------
	Author 	: Sumit Darbeshwar				Date: 17 Jun 16
	-------------------------------------------------------------
	Purpose: it will encrypt using hashids encryption
	ToDo:
	*/	
	protected function encryptArray($array)
	{
		$this->load->module('hashids');
		return $this->hashids->arrayEnD($array,'encrypt');
	}
	/*
	-------------------------------------------------------------
	Author 	: Sumit Darbeshwar				Date: 17 Jun 16
	-------------------------------------------------------------
	Purpose: it will decrypt using hashids decryption else keep
	as it is
	ToDo:
	*/	
	protected function decryptArray($array){
		$this->load->module('hashids');
		return $this->hashids->arrayEnD($array,'decrypt');
	}
		/*
	-------------------------------------------------------------
	Author 	: Sumit Darbeshwar				Date: 24-04-17
	-------------------------------------------------------------
	Purpose: to keep extra fields and keep required fields 
	ToDo:
	*/
	protected function _sliceExtraFields($template=FALSE,$collection=FALSE){
		if($template==TRUE && $collection==TRUE)
		{
			if((count($collection) != count($collection, COUNT_RECURSIVE)))
			{
				array_walk($collection, array($this,'_checkSlice'),$template);
				$this->_defaultInsertFields($template,$collection);
			}
			else
			{
				$this->_checkSlice($collection,FALSE,$template);
				$this->_defaultInsertFields($template,$collection);
			}
			return $collection;
		}else{
			return $collection;
		}
	}
	/*
	-------------------------------------------------------------
	Author 	: Sumit Darbeshwar				Date: 24-04-17
	-------------------------------------------------------------
	Purpose: Check single array's each element if its not exists in template it removes from the array
	ToDo:
	*/
	private function _checkSlice(&$singleArray,$key,$template){
		foreach ($singleArray as $singleArrayKey => $value) {
			if(!isset($template[$singleArrayKey])){
				# check if this field is exit inthe template or else unset it
				unset($singleArray[$singleArrayKey]);
			}
		}
		$template_keys=array_keys($template);
		/*$singleArray = array_replace(array_flip($template_keys), $singleArray);*/
		$singleArray = array_replace($template , $singleArray);

		return $singleArray;
	}
	/*
	--------------------------------------------------------------------------------------------------------------
		AUTHOR :Mahadev Mandole											Date:26-05-2017
		Description:
	--------------------------------------------------------------------------------------------------------------
	*/
	public function generateToken()
	{
		$randomString=$this->createRandomeString();
		$pass_plain = substr($randomString, 0,6) ;	
		return $pass_plain;
	}
	
	private function createRandomeString(){
		return bin2hex(openssl_random_pseudo_bytes(4));
	}	
}