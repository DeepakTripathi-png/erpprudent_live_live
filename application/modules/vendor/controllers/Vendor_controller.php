<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_controller extends Base_Controller
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
    public function vendor_list($id=NULL)
    {
        $data['vendor_data'] =$this->common_model->fetchDataASC('tbl_vendor','vendor_id');
        $data['director_data'] =$this->common_model->fetchDataASC('tbl_vendor_director','vendor_id',$id);

        foreach($data['vendor_data'] as $vendor ){
            $vendorid =$vendor->vendor_id;
            $director_name = [];
            $director_contactno = [];
            foreach($data['director_data'] as $director){
                 if ($vendor->vendor_id == $director->vendor_id) {
                    $director_name[] = $director->name_of_dir_part;
                    $director_contactno[] = $director->dir_part_contact_no;
                }



            }
            $comma_separated_director_name = implode(',', $director_name);
                $comma_separated_director_contactno = implode(',', $director_contactno);


            $vendor->comma_separated_director_name = $comma_separated_director_name;
            $vendor->comma_separated_director_contactno = $comma_separated_director_contactno;


        }

        $this->load->view('vendor-list',$data);

    }
	public function add_vendor()
    {
				$data['category_data'] =$this->common_model->fetchDataASC('tbl_category','category_id');

        $this->load->view('add-vendor',$data);
    }
    public function edit_vendor($id=NULL)
    {
        $data['vendor_data']=$this->common_model->selectDetailsWhr('tbl_vendor','vendor_id',$id);
        $data['director_data']=$this->common_model->selectDetailsWhere('tbl_vendor_director','vendor_id',$id);
        $data['region_data']=$this->common_model->selectDetailsWhere('tbl_vendor_region','vendor_id',$id);
        $data['references_data']=$this->common_model->selectDetailsWhere('tbl_vendor_references','vendor_id',$id);
				$data['category_data'] =$this->common_model->fetchDataASC('tbl_category','category_id');
        $this->load->view('add-vendor',$data);
    }
    public function save_vendor()
    {
			// print_r($this->input->post('category_id'));
			// exit;
        $user_id=$this->session->userdata('user_id');
        $id=$this->input->post('id');
        $name_of_company =$this->input->post('name_of_company');
        if(isset($name_of_company) && !empty($name_of_company)) {$name_of_company=trim($name_of_company); } else {$name_of_company=''; }
        $business_type =$this->input->post('business_type');
        if(isset($business_type) && !empty($business_type)) {$business_type=trim($business_type); } else {$business_type=''; }

		$category_id =$this->input->post('category_id');
        if(isset($category_id) && !empty($category_id)) {$category_id=implode(',', $category_id ); } else {$category_id=''; }

        $name_of_dir_part =$this->input->post('name_of_dir_part');
        if(isset($name_of_dir_part) && !empty($name_of_dir_part)) {$name_of_dir_part=$name_of_dir_part; } else {$name_of_dir_part=''; }
        $dir_part_contact_no =$this->input->post('dir_part_contact_no');
        if(isset($dir_part_contact_no) && !empty($dir_part_contact_no)) {$dir_part_contact_no=$dir_part_contact_no; } else {$dir_part_contact_no=''; }
        $dir_part_contact_address =$this->input->post('dir_part_contact_address');
        if(isset($dir_part_contact_address) && !empty($dir_part_contact_address)) {$dir_part_contact_address=$dir_part_contact_address; } else {$dir_part_contact_address=''; }
        $dir_cin_act_reng_nos =$this->input->post('dir_cin_act_reng_nos');
        if(isset($dir_cin_act_reng_nos) && !empty($dir_cin_act_reng_nos)) {$dir_cin_act_reng_nos=trim($dir_cin_act_reng_nos); } else {$dir_cin_act_reng_nos=''; }
        $reg_house_building_no =$this->input->post('reg_house_building_no');
        if(isset($reg_house_building_no) && !empty($reg_house_building_no)) {$reg_house_building_no=trim($reg_house_building_no); } else {$reg_house_building_no=''; }
        $reg_street =$this->input->post('reg_street');
        if(isset($reg_street) && !empty($reg_street)) {$reg_street=trim($reg_street); } else {$reg_street=''; }
        $reg_city_post_code =$this->input->post('reg_city_post_code');
        if(isset($reg_city_post_code) && !empty($reg_city_post_code)) {$reg_city_post_code=trim($reg_city_post_code); } else {$reg_city_post_code=''; }
        $reg_state =$this->input->post('reg_state');
        if(isset($reg_state) && !empty($reg_state)) {$reg_state=trim($reg_state); } else {$reg_state=''; }
        $reg_country =$this->input->post('reg_country');
        if(isset($reg_country) && !empty($reg_country)) {$reg_country=trim($reg_country); } else {$reg_country=''; }
        $corporate_house_building_no =$this->input->post('corporate_house_building_no');
        if(isset($corporate_house_building_no) && !empty($corporate_house_building_no)) {$corporate_house_building_no=trim($corporate_house_building_no); } else {$corporate_house_building_no=''; }
        $corporate_street =$this->input->post('corporate_street');
        if(isset($corporate_street) && !empty($corporate_street)) {$corporate_street=trim($corporate_street); } else {$corporate_street=''; }
        $corporate_city_post_code =$this->input->post('corporate_city_post_code');
        if(isset($corporate_city_post_code) && !empty($corporate_city_post_code)) {$corporate_city_post_code=trim($corporate_city_post_code); } else {$corporate_city_post_code=''; }
        $corporate_state =$this->input->post('corporate_state');
        if(isset($corporate_state) && !empty($corporate_state)) {$corporate_state=trim($corporate_state); } else {$corporate_state=''; }
        $corporate_country =$this->input->post('corporate_country');
        if(isset($corporate_country) && !empty($corporate_country)) {$corporate_country=trim($corporate_country); } else {$corporate_country=''; }
        $contact_person_name =$this->input->post('contact_person_name');
        if(isset($contact_person_name) && !empty($contact_person_name)) {$contact_person_name=trim($contact_person_name); } else {$contact_person_name=''; }
        $telephone_incl_ext =$this->input->post('telephone_incl_ext');
        if(isset($telephone_incl_ext) && !empty($telephone_incl_ext)) {$telephone_incl_ext=trim($telephone_incl_ext); } else {$telephone_incl_ext=''; }
        $comm_mobile_phone =$this->input->post('comm_mobile_phone');
        if(isset($comm_mobile_phone) && !empty($comm_mobile_phone)) {$comm_mobile_phone=trim($comm_mobile_phone); } else {$comm_mobile_phone=''; }
        $comm_fax =$this->input->post('comm_fax');
        if(isset($comm_fax) && !empty($comm_fax)) {$comm_fax=trim($comm_fax); } else {$comm_fax=''; }
        $comm_email =$this->input->post('comm_email');
        if(isset($comm_email) && !empty($comm_email)) {$comm_email=trim($comm_email); } else {$comm_email=''; }
        $stand_communication_method =$this->input->post('stand_communication_method');
        if(isset($stand_communication_method) && !empty($stand_communication_method)) {$stand_communication_method=trim($stand_communication_method); } else {$stand_communication_method=''; }
        $gst_registration_no =$this->input->post('gst_registration_no');
        if(isset($gst_registration_no) && !empty($gst_registration_no)) {$gst_registration_no=trim($gst_registration_no); } else {$gst_registration_no=''; }
        $pan_number =$this->input->post('pan_number');
        if(isset($pan_number) && !empty($pan_number)) {$pan_number=trim($pan_number); } else {$pan_number=''; }
        $tan_number =$this->input->post('tan_number');
        if(isset($tan_number) && !empty($tan_number)) {$tan_number=trim($tan_number); } else {$tan_number=''; }
        $pf_number =$this->input->post('pf_number');
        if(isset($pf_number) && !empty($pf_number)) {$pf_number=trim($pf_number); } else {$pf_number=''; }
        $esic_number =$this->input->post('esic_number');
        if(isset($esic_number) && !empty($esic_number)) {$esic_number=trim($esic_number); } else {$esic_number=''; }
        $any_other =$this->input->post('any_other');
        if(isset($any_other) && !empty($any_other)) {$any_other=trim($any_other); } else {$any_other=''; }
        // $bank_key =$this->input->post('bank_key');
        // if(isset($bank_key) && !empty($bank_key)) {$bank_key=trim($bank_key); } else {$bank_key=''; }
        $bank_acc_no_vendor =$this->input->post('bank_acc_no_vendor');
        if(isset($bank_acc_no_vendor) && !empty($bank_acc_no_vendor)) {$bank_acc_no_vendor=trim($bank_acc_no_vendor); } else {$bank_acc_no_vendor=''; }
        $name_of_bank =$this->input->post('name_of_bank');
        if(isset($name_of_bank) && !empty($name_of_bank)) {$name_of_bank=trim($name_of_bank); } else {$name_of_bank=''; }
        $name_of_branch =$this->input->post('name_of_branch');
        if(isset($name_of_branch) && !empty($name_of_branch)) {$name_of_branch=trim($name_of_branch); } else {$name_of_branch=''; }
        $bank_ifsc_code =$this->input->post('bank_ifsc_code');
        if(isset($bank_ifsc_code) && !empty($bank_ifsc_code)) {$bank_ifsc_code=trim($bank_ifsc_code); } else {$bank_ifsc_code=''; }
        $bank_branch_code =$this->input->post('bank_branch_code');
        if(isset($bank_branch_code) && !empty($bank_branch_code)) {$bank_branch_code=trim($bank_branch_code); } else {$bank_branch_code=''; }
        $bank_address =$this->input->post('bank_address');
        if(isset($bank_address) && !empty($bank_address)) {$bank_address=trim($bank_address); } else {$bank_address=''; }
        $bank_city =$this->input->post('bank_city');
        if(isset($bank_city) && !empty($bank_city)) {$bank_city=trim($bank_city); } else {$bank_city=''; }
        $swift_code =$this->input->post('swift_code');
        if(isset($swift_code) && !empty($swift_code)) {$swift_code=trim($swift_code); } else {$swift_code=''; }
        // $micr_cheque_no_of_cheque =$this->input->post('micr_cheque_no_of_cheque');
        // if(isset($micr_cheque_no_of_cheque) && !empty($micr_cheque_no_of_cheque)) {$micr_cheque_no_of_cheque=trim($micr_cheque_no_of_cheque); } else {$micr_cheque_no_of_cheque=''; }
        $tele_no_of_bank =$this->input->post('tele_no_of_bank');
        if(isset($tele_no_of_bank) && !empty($tele_no_of_bank)) {$tele_no_of_bank=trim($tele_no_of_bank); } else {$tele_no_of_bank=''; }
        $fax_no_of_bank =$this->input->post('fax_no_of_bank');
        if(isset($fax_no_of_bank) && !empty($fax_no_of_bank)) {$fax_no_of_bank=trim($fax_no_of_bank); } else {$fax_no_of_bank=''; }
        $bank_type_of_account =$this->input->post('bank_type_of_account');
        if(isset($bank_type_of_account) && !empty($bank_type_of_account)) {$bank_type_of_account=trim($bank_type_of_account); } else {$bank_type_of_account=''; }
        $bank_region =$this->input->post('bank_region');
        if(isset($bank_region) && !empty($bank_region)) {$bank_region=trim($bank_region); } else {$bank_region=''; }
        $bank_large_customers =$this->input->post('bank_large_customers');
        if(isset($bank_large_customers) && !empty($bank_large_customers)) {$bank_large_customers=trim($bank_large_customers); } else {$bank_large_customers=''; }
        $bank_for_office_purpose =$this->input->post('bank_for_office_purpose');
        if(isset($bank_for_office_purpose) && !empty($bank_for_office_purpose)) {$bank_for_office_purpose=trim($bank_for_office_purpose); } else {$bank_for_office_purpose=''; }
        $region_name = $this->input->post('region_name');
        if(isset($region_name) && !empty($region_name)) {$region_name = $region_name; } else {$region_name=''; }
        $region_person = $this->input->post('region_person');
        if(isset($region_person) && !empty($region_person)) {$region_person = $region_person; } else {$region_person=''; }
        $ref_vendor_emp_frd =$this->input->post('ref_vendor_emp_frd');
        if(isset($ref_vendor_emp_frd) && !empty($ref_vendor_emp_frd)) {$ref_vendor_emp_frd=trim($ref_vendor_emp_frd); } else {$ref_vendor_emp_frd=''; }

        $references = $this->input->post('references');
        if(isset($references) && !empty($references)) {$references = $references; } else {$references=''; }
        $reference_name = $this->input->post('reference_name');
        if(isset($reference_name) && !empty($reference_name)) {$reference_name = $reference_name; } else {$reference_name=''; }


        $upload_gst_certificate_file ='';
        $errormsg='';
        if(isset($id) && !empty($id)){
            $vendor_data=$this->common_model->selectDetailsWhr('tbl_vendor','vendor_id',$id);
        }
            if(isset($vendor_data) && !empty($vendor_data)){
                if(isset($_FILES['upload_gst_certificate_file']['name'])){
                    $upload_gst_certificate_file = $_FILES['upload_gst_certificate_file']['name']; //here [] name attribute
                    $upload_gst_certificate_fileImg = array('upload_path' =>'./uploads/gst_certificate_doc/',
                             'fieldname' => 'upload_gst_certificate_file',
                               'encrypt_name' => TRUE,
                               'overwrite' => FALSE,
                             'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                    $upload_gst_certificate_file_img = $this->imageupload->image_upload($upload_gst_certificate_fileImg);
                    $errormsg= $this->upload->display_errors();
                    if(isset($upload_gst_certificate_file_img) && !empty($upload_gst_certificate_file_img))
                    {
                      $upload_gst_certificate_fileData = $this->upload->data();
                      $upload_gst_certificate_file = $upload_gst_certificate_fileData['file_name'];
                    }
                  }else{
                      if(isset($vendor_data->upload_gst_certificate_file) && !empty($vendor_data->upload_gst_certificate_file)) {
                          $upload_gst_certificate_file = $vendor_data->upload_gst_certificate_file;
                      }
                  }

                if(isset($upload_gst_certificate_file) && !empty($upload_gst_certificate_file)) {$upload_gst_certificate_file = $upload_gst_certificate_file; } else {$upload_gst_certificate_file=''; }
            }else{
                if(isset($_FILES['upload_gst_certificate_file']['name']))//Code for to take image from form and check isset
                {
                $upload_gst_certificate_file = $_FILES['upload_gst_certificate_file']['name']; //here [] name attribute
                $upload_gst_certificate_fileImg = array('upload_path' =>'./uploads/gst_certificate_doc/',
                        'fieldname' => 'upload_gst_certificate_file',
                            'encrypt_name' => TRUE,
                            'overwrite' => FALSE,
                        'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                $upload_gst_certificate_file_img = $this->imageupload->image_upload($upload_gst_certificate_fileImg);
                $errormsg= $this->upload->display_errors();
                if(isset($upload_gst_certificate_file_img) && !empty($upload_gst_certificate_file_img))
                {
                    $upload_gst_certificate_fileData = $this->upload->data();
                    $upload_gst_certificate_file = $upload_gst_certificate_fileData['file_name'];
                }
                }else{
                    $upload_gst_certificate_file = $this->input->post('hidden_upload_gst_certificate_file');
                    if(isset($upload_gst_certificate_file) && !empty($upload_gst_certificate_file)) {$upload_gst_certificate_file = $upload_gst_certificate_file; } else {$upload_gst_certificate_file=''; }
                }
                if(isset($upload_gst_certificate_file) && !empty($upload_gst_certificate_file)) {$upload_gst_certificate_file = $upload_gst_certificate_file; } else {$upload_gst_certificate_file=''; }

            }


            //upload_shop_act_license_file
                $upload_shop_act_license_file ='';
                $errormsg='';

                if(isset($vendor_data) && !empty($vendor_data)){
                    if(isset($_FILES['upload_shop_act_license_file']['name'])){
                        $upload_shop_act_license_file = $_FILES['upload_shop_act_license_file']['name']; //here [] name attribute
                        $upload_shop_act_license_fileImg = array('upload_path' =>'./uploads/shop_act_license_doc/',
                                'fieldname' => 'upload_shop_act_license_file',
                                'encrypt_name' => TRUE,
                                'overwrite' => FALSE,
                                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                        $upload_shop_act_license_file_img = $this->imageupload->image_upload($upload_shop_act_license_fileImg);
                        $errormsg= $this->upload->display_errors();
                        if(isset($upload_shop_act_license_file_img) && !empty($upload_shop_act_license_file_img))
                        {
                        $upload_shop_act_license_fileData = $this->upload->data();
                        $upload_shop_act_license_file = $upload_shop_act_license_fileData['file_name'];
                        }
                    }else{
                        if(isset($vendor_data->upload_shop_act_license_file) && !empty($vendor_data->upload_shop_act_license_file)) {
                            $upload_shop_act_license_file = $vendor_data->upload_shop_act_license_file;
                        }
                    }

                    if(isset($upload_shop_act_license_file) && !empty($upload_shop_act_license_file)) {$upload_shop_act_license_file = $upload_shop_act_license_file; } else {$upload_shop_act_license_file=''; }
                }else{
                if(isset($_FILES['upload_shop_act_license_file']['name']))
                {
                    $upload_shop_act_license_file = $_FILES['upload_shop_act_license_file']['name'];
                    $upload_shop_act_license_fileImg = array('upload_path' =>'./uploads/shop_act_license_doc/',
                            'fieldname' => 'upload_shop_act_license_file',
                                'encrypt_name' => TRUE,
                                'overwrite' => FALSE,
                            'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                    $upload_shop_act_license_file_img = $this->imageupload->image_upload($upload_shop_act_license_fileImg);
                    $errormsg= $this->upload->display_errors();
                    if(isset($upload_shop_act_license_file_img) && !empty($upload_shop_act_license_file_img))
                    {
                    $upload_shop_act_license_fileData = $this->upload->data();
                    $upload_shop_act_license_file = $upload_shop_act_license_fileData['file_name'];
                    }
                }else{
                    $upload_shop_act_license_file = $this->input->post('hidden_upload_shop_act_license_file');
                    if(isset($upload_shop_act_license_file) && !empty($upload_shop_act_license_file)) {$upload_shop_act_license_file = $upload_shop_act_license_file; } else {$upload_shop_act_license_file=''; }
                }
                if(isset($upload_shop_act_license_file) && !empty($upload_shop_act_license_file)) {$upload_shop_act_license_file = $upload_shop_act_license_file; } else {$upload_shop_act_license_file=''; }

                }



       //upload_cancel_cheque_file
        $upload_cancel_cheque_file ='';
        $errormsg='';
        if(isset($vendor_data) && !empty($vendor_data)){
            if(isset($_FILES['upload_cancel_cheque_file']['name'])){
                $upload_cancel_cheque_file = $_FILES['upload_cancel_cheque_file']['name']; //here [] name attribute
                $upload_cancel_cheque_fileImg = array('upload_path' =>'./uploads/vendor_bank_document/',
                        'fieldname' => 'upload_cancel_cheque_file',
                        'encrypt_name' => TRUE,
                        'overwrite' => FALSE,
                        'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                $upload_cancel_cheque_file_img = $this->imageupload->image_upload($upload_cancel_cheque_fileImg);
                $errormsg= $this->upload->display_errors();
                if(isset($upload_cancel_cheque_file_img) && !empty($upload_cancel_cheque_file_img))
                {
                $upload_cancel_cheque_fileData = $this->upload->data();
                $upload_cancel_cheque_file = $upload_cancel_cheque_fileData['file_name'];
                }
            }else{
                if(isset($vendor_data->upload_cancel_cheque_file) && !empty($vendor_data->upload_cancel_cheque_file)) {
                    $upload_cancel_cheque_file = $vendor_data->upload_cancel_cheque_file;
                }
            }

            if(isset($upload_cancel_cheque_file) && !empty($upload_cancel_cheque_file)) {$upload_cancel_cheque_file = $upload_cancel_cheque_file; } else {$upload_cancel_cheque_file=''; }
        }else{
        if(isset($_FILES['upload_cancel_cheque_file']['name']))//Code for to take image from form and check isset
        {
          $upload_cancel_cheque_file = $_FILES['upload_cancel_cheque_file']['name']; //here [] name attribute
          $upload_cancel_cheque_fileImg = array('upload_path' =>'./uploads/vendor_bank_document/',
                   'fieldname' => 'upload_cancel_cheque_file',
                     'encrypt_name' => TRUE,
                     'overwrite' => FALSE,
                   'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
          $upload_cancel_cheque_file_img = $this->imageupload->image_upload($upload_cancel_cheque_fileImg);
          $errormsg= $this->upload->display_errors();
          if(isset($upload_cancel_cheque_file_img) && !empty($upload_cancel_cheque_file_img))
          {
            $upload_cancel_cheque_fileData = $this->upload->data();
            $upload_cancel_cheque_file = $upload_cancel_cheque_fileData['file_name'];
          }
        }else{
            $upload_cancel_cheque_file = $this->input->post('hidden_upload_cancel_cheque_file');
            if(isset($upload_cancel_cheque_file) && !empty($upload_cancel_cheque_file)) {$upload_cancel_cheque_file = $upload_cancel_cheque_file; } else {$upload_cancel_cheque_file=''; }
        }
        if(isset($upload_cancel_cheque_file) && !empty($upload_cancel_cheque_file)) {$upload_cancel_cheque_file = $upload_cancel_cheque_file; } else {$upload_cancel_cheque_file=''; }
    }
        $data = array(
            'name_of_company' =>$name_of_company,
            'business_type' =>$business_type,
            'category_id' =>$category_id,

            // 'name_of_dir_part' =>$name_of_dir_part,
            // 'dir_part_contact_no' =>$dir_part_contact_no,
            // 'dir_part_contact_address' =>$dir_part_contact_address,
            'dir_cin_act_reng_nos' =>$dir_cin_act_reng_nos,
            'upload_gst_certificate_file' =>$upload_gst_certificate_file,
            'upload_shop_act_license_file' =>$upload_shop_act_license_file,
            'reg_house_building_no' =>$reg_house_building_no,
            'reg_street' =>$reg_street,
            'reg_city_post_code' =>$reg_city_post_code,
            'reg_state' =>$reg_state,
            'reg_country' =>$reg_country,
            'corporate_house_building_no' =>$corporate_house_building_no,
            'corporate_street' =>$corporate_street,
            'corporate_city_post_code' =>$corporate_city_post_code,
            'corporate_state' =>$corporate_state,
            'corporate_country' =>$corporate_country,
            'contact_person_name' =>$contact_person_name,
            'telephone_incl_ext' =>$telephone_incl_ext,
            'comm_mobile_phone' =>$comm_mobile_phone,
            'comm_fax' =>$comm_fax,
            'comm_email' =>$comm_email,
            'stand_communication_method' =>$stand_communication_method,
            'gst_registration_no' =>$gst_registration_no,
            'pan_number' =>$pan_number,
            'tan_number' =>$tan_number,
            'pf_number' =>$pf_number,
            'esic_number' =>$esic_number,
            'any_other' =>$any_other,
            // 'bank_key' =>$bank_key,
            'bank_acc_no_vendor' =>$bank_acc_no_vendor,
            'name_of_bank' =>$name_of_bank,
            'name_of_branch' =>$name_of_branch,
            'bank_ifsc_code' =>$bank_ifsc_code,
            'bank_branch_code' =>$bank_branch_code,
            'bank_address' =>$bank_address,
            'bank_city' =>$bank_city,
            'swift_code' =>$swift_code,
            // 'micr_cheque_no_of_cheque' =>$micr_cheque_no_of_cheque,
            'tele_no_of_bank' =>$tele_no_of_bank,
            'fax_no_of_bank' =>$fax_no_of_bank,
            'bank_type_of_account' =>$bank_type_of_account,
            'bank_region' =>$bank_region,
            'bank_large_customers' =>$bank_large_customers,
            'bank_for_office_purpose' =>$bank_for_office_purpose,
            'upload_cancel_cheque_file' =>$upload_cancel_cheque_file,

            'ref_vendor_emp_frd' =>$ref_vendor_emp_frd
        );
				// echo "<pre>";
				// print_r($data);
				// exit;
        if(isset($id) && !empty($id))
        {
            $data['modified_by']=$user_id;
            $data['modified_on']=date('Y-m-d H:i:s');
            $vendor_id=$this->common_model->updateDetails('tbl_vendor','vendor_id',$id,$data);

            if(empty($name_of_dir_part) || empty($dir_part_contact_no) || empty($dir_part_contact_address)){
                $error = 'Y';
                $error_message = 'Please enter director required details!';
            }
            if($name_of_dir_part && $dir_part_contact_no && $dir_part_contact_address){
                $save_dir_data = array();
                 for($i = 0;$i<count($name_of_dir_part);$i++) {
                    if (!empty($name_of_dir_part[$i]) && !empty($dir_part_contact_no[$i]) && !empty($dir_part_contact_address[$i])) {

                     $save_dir_data[] = array('vendor_id'=>$vendor_id,'name_of_dir_part'=>trim($name_of_dir_part[$i]),
                     'dir_part_contact_no'=>trim($dir_part_contact_no[$i]),'dir_part_contact_address'=>trim($dir_part_contact_address[$i]));
                    }
                    }
                 if(isset($save_dir_data) && !empty($save_dir_data)){
                    $this->admin_model->deleteOldVendordirectorData($vendor_id);
                    $this->common_model->SaveMultiData('tbl_vendor_director',$save_dir_data);
                }
            }

            if(empty($region_name) || empty($region_person)){
                $error = 'Y';
                $error_message = 'Please enter region required details!';
            }
            if($region_name && $region_person){
                 $save_region_data = array();
                 for($i = 0;$i<count($region_name);$i++) {
                    if (!empty($region_name[$i]) && !empty($region_person[$i]) ) {

                     $save_region_data[] = array('vendor_id'=>$vendor_id,'region_name'=>$region_name[$i],
                     'region_person'=>$region_person[$i]);
                    }
                 }
                 if(isset($save_region_data) && !empty($save_region_data)){
                    $this->admin_model->deleteOldVendorregionData($vendor_id);
                   $this->common_model->SaveMultiData('tbl_vendor_region',$save_region_data);
                }
            }


            if(empty($references) || empty($reference_name)){
                $error = 'Y';
                $error_message = 'Please enter references required details!';
            }
            if($references && $reference_name){

                 $save_references_data = array();
                 for($i = 0;$i<count($references);$i++) {
                    if (!empty($references[$i]) && !empty($reference_name[$i]) ) {

                     $save_references_data[] = array('vendor_id'=>$vendor_id,'references'=>$references[$i],
                     'name'=>$reference_name[$i]);
                    }
                 }

                 if(isset($save_references_data) && !empty($save_references_data)){
                    $this->admin_model->deletereferencesData($vendor_id);
                   $result = $this->common_model->SaveMultiData('tbl_vendor_references',$save_references_data);
                }
            }
						// echo "<pre>";
						// print_r($result);
						// exit;
            if($result)
            {
                $this->json->jsonReturn(array(
                    'valid'=>TRUE,
                    'msg'=>'<div class="alert modify alert-info"><strong>Welldone!</strong> Vendor Details Updated Successfully.</div>',
										'redirect' => base_url().'vendor-list'
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
            $vendor_id=$this->common_model->addData('tbl_vendor',$data);

            if(isset($vendor_id) && !empty($vendor_id)){
                if($name_of_dir_part && $dir_part_contact_no && $dir_part_contact_address){
                    $save_company_details_data = array();
                    for($i = 0;$i<count($name_of_dir_part);$i++) {
                        if(isset($name_of_dir_part[$i]) && !empty($name_of_dir_part[$i])
                        && isset($dir_part_contact_no[$i]) && !empty($dir_part_contact_no[$i])
                        && isset($dir_part_contact_address[$i]) && !empty($dir_part_contact_address[$i])){
                        $save_company_details_data[] = array('vendor_id'=>$vendor_id,'name_of_dir_part'=>trim($name_of_dir_part[$i]),
                        'dir_part_contact_no'=>trim($dir_part_contact_no[$i]),'dir_part_contact_address'=>trim($dir_part_contact_address[$i]));
                    }
                    }
                    if(isset($save_company_details_data) && !empty($save_company_details_data)){
                      $this->common_model->SaveMultiData('tbl_vendor_director',$save_company_details_data);
                    }
                }
            }
            if(isset($vendor_id) && !empty($vendor_id)){
                if($region_name && $region_person){
                    $save_region_data = array();
                    for($i = 0;$i<count($region_name);$i++) {
                        if(isset($region_name[$i]) && !empty($region_name[$i])
                        && isset($region_person[$i]) && !empty($region_person[$i])){
                        $save_region_data[] = array('vendor_id'=>$vendor_id,'region_name'=>$region_name[$i],
                        'region_person'=>$region_person[$i]);
                    }
                    }
                    if(isset($save_region_data) && !empty($save_region_data)){
                       $this->common_model->SaveMultiData('tbl_vendor_region',$save_region_data);
                    }
                }
            }

        
            if(isset($vendor_id) && !empty($vendor_id)){
               
                if($references && $reference_name){
                    $save_references_data = array();
                    for($i = 0;$i<count($references);$i++) {
                        if(isset($references[$i]) && !empty($references[$i])
                        && isset($reference_name[$i]) && !empty($reference_name[$i])){
                        $save_references_data[] = array('vendor_id'=>$vendor_id,'references'=>$references[$i],
                        'name'=>$reference_name[$i]);
                    }
                    }
                    
                    if(isset($save_references_data) && !empty($save_references_data)){
                        $result = $this->common_model->SaveMultiData('tbl_vendor_references',$save_references_data);
                    }
                }
            }

            if($vendor_id)

            {
                $this->json->jsonReturn(array(
                    'valid'=>TRUE,
                    'msg'=>'<div class="alert modify alert-info"><strong>Welldone!</strong> Vendor Details Saved Successfully.</div>',
                     'redirect' => base_url().'add-vendor'
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
}
