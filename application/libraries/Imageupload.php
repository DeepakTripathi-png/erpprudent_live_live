<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imageupload
{

	function _construct() 
	{
	    $CI =& get_instance();     
		$CI->load->database();     
		$CI->load->library("session");
		$array = array(); 
	}
	function image_upload($array)
    {
    	
    	/*  DUMMY
		 $array = array ('upload_path'=>'./folder_name/',
						'max_width'=>'2024',
						'max_height'=>'1000',
						'overwrite'=>'TRUE',
						'fieldname'=>'input_field_name',
						'resize'=>TRUE,
						'resize_image_path'=>'./folder_path_of_resized_img',
						'thumb_marker'=>'_/!/@/#/$',
						'resize_width'=>'xx px',
						'resize_height'=>'xx px',
						'rename_image'=>TRUE,
						'rename_name'=>'new_name'
						);
						
		 $this->imageupload->image_upload($array); 
		 */
				
    	$data_file = array();
    
    	$CI =& get_instance();     
		$CI->load->database();     
		$CI->load->library("session");
    	$uploadpath=$array['upload_path']; //compulsary
		$max_width=isset($array['max_width'])?$array['max_width']:FALSE;
		$max_height=isset($array['max_height'])?$array['max_height']:FALSE;
		$overwrite=isset($array['overwrite'])?$array['overwrite']:FALSE;
		$fieldname = isset($array['fieldname'])?$array['fieldname']:'';//compulsary
		$resize = isset($array['resize'])?$array['resize']:FALSE;
		$resize_image_path = isset($array['resize_image_path'])?$array['resize_image_path']:'';//compulsary if resized
		$thumb_marker = isset($array['thumb_marker'])?$array['thumb_marker']:'';
		$resize_width=isset($array['resize_width'])?$array['resize_width']:FALSE;//compulsary if resized
		$resize_height=isset($array['resize_height'])?$array['resize_height']:FALSE;//compulsary if resized
		$rename=isset($array['rename_image'])?$array['rename_image']:FALSE;
		$en_name=isset($array['encrypt_name'])?$array['encrypt_name']:FALSE;
		$rename_name=isset($array['rename_name'])?$array['rename_name']:'';//compulsary if renamed
		
		
		
		$config['upload_path'] = $uploadpath;
		$config['allowed_types'] = '*';
		$config['max_width']  = $max_width;
		$config['max_height']  =$max_height;
		$config['overwrite']  = $overwrite;
		$config['encrypt_name'] = $en_name;
		$CI->load->library('upload', $config);
		//$CI->upload->overwrite = true;
		$CI->upload->initialize($config);
		if ($CI->upload->do_upload($fieldname))
		{
			$data_file =  $CI->upload->data(); 
			if($resize == TRUE)
			{
				$config['image_library'] = 'gd2';
				$config['quality']='100%';
				$config['source_image'] = $data_file['full_path'];
				$config['new_image']=$resize_image_path.$data_file['file_name'];
				$config['maintain_ratio'] = TRUE;
				$config['create_thumb']=true;
				$config['thumb_marker']=$thumb_marker;  
				$config['width'] = $resize_width;
				$config['height'] = $resize_height;
				$CI->load->library('image_lib', $config);
				$CI->image_lib->initialize($config);
				$CI->image_lib->resize();
			}
			if($rename == TRUE)
			{
				
				$newname=$rename_name.$data_file['file_ext'];				
				$new_name_path = $uploadpath.$newname;				
				$old_name_path = $uploadpath.$data_file['file_name'];
				@unlink($new_name_path);
				if(rename($old_name_path,$new_name_path))
				{					
					if($resize == TRUE)
					{
						$resize_newname=$rename_name.$data_file['file_ext'];
						$resize_new_name_path = $resize_image_path.$newname;
						$resize_old_name_path = $resize_image_path.$data_file['file_name'];
						if(rename($old_name_path,$new_name_path))
						{
							return TRUE;
						}
					}
					else
					{
						return TRUE;
					}
				}
			}
			else
			{
				return TRUE;
			}
			
		}
		else
		{
			return FALSE;
		}
    }
}


/************************************** Get Information About Uploaded File ********************************************

		$iecImg = array(
					'upload_path' =>'./uploads/unit/',
					'fieldname' => 'unit_iec_code_img',
					'encrypt_name' => TRUE,			   
					'overwrite' => FALSE 
				  );
				
		$iec_code = $this->imageupload->image_upload($iecImg);


		[file_name] => User-Executive-Green-icon.png
	    [file_type] => image/png
	    [file_path] => F:/wamp/www/FAMS/uploads/unit/
	    [full_path] => F:/wamp/www/FAMS/uploads/unit/User-Executive-Green-icon.png
	    [raw_name] => User-Executive-Green-icon
	    [orig_name] => User-Executive-Green-icon.png
	    [client_name] => User-Executive-Green-icon.png
	    [file_ext] => .png
	    [file_size] => 14.62
	    [is_image] => 1
	    [image_width] => 256
	    [image_height] => 256
	    [image_type] => png
	    [image_size_str] => width="256" height="256"


	    $iecData['file_name']  O/P uploaded file name with extension

		$logo1='';
				if(isset($_FILES['e_brochure_file']['name']))//Code for to take image from form and check isset
				{
					$logo1=$_FILES['e_brochure_file']['name']; //here [] name attribute
					$logoImg = array('upload_path' =>'./uploads/e_brochure_file/',
									 'fieldname' => 'e_brochure_file',
								     'encrypt_name' => FALSE,			   
								     'overwrite' => FALSE,
								     'allowed_types' => 'png|PNG|jpg|JPG|jpeg|JPEG'
								    );
					$logo_img = $this->imageupload->image_upload($logoImg);
				        
				        if(isset($logo_img) && !empty($logo_img))
				        {
				          $logoData = $this->upload->data();      
				          $logo1 = $logoData['file_name'];
				        }
				}
				else
				{
					$logo1=$this->input->post('hidden_e_brochure_file');
				}

************************************************************************************************************************/