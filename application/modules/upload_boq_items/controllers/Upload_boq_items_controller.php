<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_boq_items_controller extends Base_Controller 
{
	public function __construct()
  	{
	    parent::__construct();
	    $this->clear_cache();  
        date_default_timezone_set("Asia/Kolkata"); 
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 2000);
        $value = base_url();
        setcookie("multicare",$value, time()+3600*24,'/'); 
	    $this->load->model('common_model');
        $this->load->model('admin_model');
        $this->load->library('excel');
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    }
    
    public function clear_cache()
    {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }
    public function invoice_closure() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_invoice_closure');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $id = $this->uri->segment(2);
                    if(isset($id) && !empty($id)){
                    $id = base64_decode($id);
                    }
                    
                    $final_received_payment = 0;
                    $received_payment = $this->admin_model->get_invoice_received_payment($id);
                    if(isset($received_payment) && !empty($received_payment) && $received_payment > 0){
                    $received_payment = $received_payment;
                    }else{
                    $received_payment = 0;
                    }
                    //Statutory Deductions
                    $statutory_deductions = 0;
                    $it_tds_amount = $this->admin_model->get_invoice_it_tds_amount($id);
                    if(isset($it_tds_amount) && !empty($it_tds_amount) && $it_tds_amount > 0){
                    $it_tds_amount = $it_tds_amount;
                    }else{
                    $it_tds_amount = 0;
                    }
                    $gtds_amount = $this->admin_model->get_invoice_gtds_amount($id);
                    if(isset($gtds_amount) && !empty($gtds_amount) && $gtds_amount > 0){
                    $gtds_amount = $gtds_amount;
                    }else{
                    $gtds_amount = 0;
                    }
                    $other_tax_deduction_amount = $this->admin_model->get_invoice_other_tax_deduction($id);
                    if(isset($other_tax_deduction_amount) && !empty($other_tax_deduction_amount) && $other_tax_deduction_amount > 0){
                    $other_tax_deduction_amount = $other_tax_deduction_amount;
                    }else{
                    $other_tax_deduction_amount = 0;
                    }
                    $statutory_deductions = $it_tds_amount + $gtds_amount + $other_tax_deduction_amount;
                    
                    //Refundables
                    $security_deposit_retn_amount = $this->admin_model->get_invoice_security_deposit_retn_amount($id);
                    if(isset($security_deposit_retn_amount) && !empty($security_deposit_retn_amount) && $security_deposit_retn_amount > 0){
                    $security_deposit_retn_amount = $security_deposit_retn_amount;
                    }else{
                    $security_deposit_retn_amount = 0;
                    }
                    $other_deposit_amount = $this->admin_model->get_invoice_other_deposit($id);
                    if(isset($other_deposit_amount) && !empty($other_deposit_amount) && $other_deposit_amount > 0){
                    $other_deposit_amount = $other_deposit_amount;
                    }else{
                    $other_deposit_amount = 0;
                    }
                    $withheld_amount = $this->admin_model->get_invoice_withheld($id);
                    if(isset($withheld_amount) && !empty($withheld_amount) && $withheld_amount > 0){
                    $withheld_amount = $withheld_amount;
                    }else{
                    $withheld_amount = 0;
                    }
                    $refundables = $security_deposit_retn_amount + $other_deposit_amount + $withheld_amount;
                    
                    //Non-Refundables
                    $labour_cess_amount = $this->admin_model->get_invoice_labour_cess($id);
                    if(isset($labour_cess_amount) && !empty($labour_cess_amount) && $labour_cess_amount > 0){
                    $labour_cess_amount = $labour_cess_amount;
                    }else{
                    $labour_cess_amount = 0;
                    }
                    $other_cess_amount = $this->admin_model->get_invoice_other_cess($id);
                    if(isset($other_cess_amount) && !empty($other_cess_amount) && $other_cess_amount > 0){
                    $other_cess_amount = $other_cess_amount;
                    }else{
                    $other_cess_amount = 0;
                    }
                    $other_deductions_amount = $this->admin_model->get_invoice_other_deductions($id);
                    if(isset($other_deductions_amount) && !empty($other_deductions_amount) && $other_deductions_amount > 0){
                    $other_deductions_amount = $other_deductions_amount;
                    }else{
                    $other_deductions_amount = 0;
                    }
                    $nonrefundables = $labour_cess_amount + $other_cess_amount + $other_deductions_amount;
                    $final_received_payment = $received_payment + $nonrefundables + $refundables + $statutory_deductions;
                    
                    $tax_invc_data = $this->admin_model->get_invoice_no($id);
                    $total_amount = $this->admin_model->get_invoice_amount($id);
                    $data ['tax_invc_id'] = $id;
                    $data['tax_invc_data'] = $tax_invc_data;
                    $data['received_payment'] = $final_received_payment;
                    if($final_received_payment <= $total_amount){
                    $data['payment_pay'] = $total_amount - $final_received_payment;
                    }

                    $tax_invc = $this->common_model->selectDetailsWhr('tbl_tax_invc','tax_invc_id',$id);
                    
                    $data['gtds_amount'] = $gtds_amount;
                    $data['it_tds_amount'] = $it_tds_amount;
                    $data['security_deposit_retn_amount'] = $security_deposit_retn_amount;
                    $data['other_tax_data'] = $this->admin_model->getInvoiceClouserOtherDeductions('tbl_any_o_tax',$id);
                    $data['other_deposit_data'] = $this->admin_model->getInvoiceClouserOtherDeductions('tbl_any_o_deposit',$id);
                    $data['withheld_data'] = $this->admin_model->getInvoiceClouserOtherDeductions('tbl_withheld',$id);
                    $data['tax_invc'] = $tax_invc;
                    
                   
                    // echo '<pre>';
                    // print_r($data);die;


                    $this->load->view('invoice-closure',$data);
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
    public function payment_receipt() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_payment_advice');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $id = $this->uri->segment(2);
                    if(isset($id) && !empty($id)){
                    $id = base64_decode($id);
                    }
                    $final_received_payment = 0;
                    $received_payment = $this->admin_model->get_invoice_received_payment($id);
                    if(isset($received_payment) && !empty($received_payment) && $received_payment > 0){
                    $received_payment = $received_payment;
                    }else{
                    $received_payment = 0;
                    }
                    //Statutory Deductions
                    $statutory_deductions = 0;
                    $it_tds_amount = $this->admin_model->get_invoice_it_tds_amount($id);
                    if(isset($it_tds_amount) && !empty($it_tds_amount) && $it_tds_amount > 0){
                    $it_tds_amount = $it_tds_amount;
                    }else{
                    $it_tds_amount = 0;
                    }
                    $gtds_amount = $this->admin_model->get_invoice_gtds_amount($id);
                    if(isset($gtds_amount) && !empty($gtds_amount) && $gtds_amount > 0){
                    $gtds_amount = $gtds_amount;
                    }else{
                    $gtds_amount = 0;
                    }
                    $other_tax_deduction_amount = $this->admin_model->get_invoice_other_tax_deduction($id);
                    if(isset($other_tax_deduction_amount) && !empty($other_tax_deduction_amount) && $other_tax_deduction_amount > 0){
                    $other_tax_deduction_amount = $other_tax_deduction_amount;
                    }else{
                    $other_tax_deduction_amount = 0;
                    }
                    $statutory_deductions = $it_tds_amount + $gtds_amount + $other_tax_deduction_amount;
                    
                    //Refundables
                    $security_deposit_retn_amount = $this->admin_model->get_invoice_security_deposit_retn_amount($id);
                    if(isset($security_deposit_retn_amount) && !empty($security_deposit_retn_amount) && $security_deposit_retn_amount > 0){
                    $security_deposit_retn_amount = $security_deposit_retn_amount;
                    }else{
                    $security_deposit_retn_amount = 0;
                    }

                    $retenstion_amount = $this->admin_model->get_invoice_retn_amount($id);
                    if(isset($retenstion_amount) && !empty($retenstion_amount) && $retenstion_amount > 0){
                    $retenstion_amount = $retenstion_amount;
                    }else{
                    $retenstion_amount = 0;
                    }
                  

                    $other_deposit_amount = $this->admin_model->get_invoice_other_deposit($id);
                    if(isset($other_deposit_amount) && !empty($other_deposit_amount) && $other_deposit_amount > 0){
                    $other_deposit_amount = $other_deposit_amount;
                    }else{
                    $other_deposit_amount = 0;
                    }
                    $withheld_amount = $this->admin_model->get_invoice_withheld($id);
                    if(isset($withheld_amount) && !empty($withheld_amount) && $withheld_amount > 0){
                    $withheld_amount = $withheld_amount;
                    }else{
                    $withheld_amount = 0;
                    }
                    $refundables = $security_deposit_retn_amount + $other_deposit_amount + $withheld_amount;
                    
                    //Non-Refundables
                    $labour_cess_amount = $this->admin_model->get_invoice_labour_cess($id);
                    if(isset($labour_cess_amount) && !empty($labour_cess_amount) && $labour_cess_amount > 0){
                    $labour_cess_amount = $labour_cess_amount;
                    }else{
                    $labour_cess_amount = 0;
                    }
                    $other_cess_amount = $this->admin_model->get_invoice_other_cess($id);
                    if(isset($other_cess_amount) && !empty($other_cess_amount) && $other_cess_amount > 0){
                    $other_cess_amount = $other_cess_amount;
                    }else{
                    $other_cess_amount = 0;
                    }
                    $other_deductions_amount = $this->admin_model->get_invoice_other_deductions($id);
                    if(isset($other_deductions_amount) && !empty($other_deductions_amount) && $other_deductions_amount > 0){
                    $other_deductions_amount = $other_deductions_amount;
                    }else{
                    $other_deductions_amount = 0;
                    }
                    $nonrefundables = $labour_cess_amount + $other_cess_amount + $other_deductions_amount;
                    $final_received_payment = $received_payment + $nonrefundables + $statutory_deductions + $refundables;
                    
                    $tax_invc_no = $this->admin_model->get_invoice_no($id)->tax_invc_no;
                    $tax_invc_date = $this->admin_model->get_invoice_no($id)->tax_invc_date;
                    // $total_amount = $this->admin_model->get_invoice_amount($id);
                   
                    $tax_invc = $this->common_model->selectDetailsWhr('tbl_tax_invc','tax_invc_id',$id);
                    $performa_invc = $this->common_model->selectDetailsWhr('tbl_proforma_invc','proforma_id',$tax_invc->convertid);
                    $tax_invc_item = $this->common_model->selectDetailsWhereAll('tbl_tax_invc_items','tax_invc_id',$id);
                    // pr($tax_invc_item);
                    $sub_total = 0;
                    $total_amount = 0 ;
                    $gst_amount = 0 ;
                    if(isset($tax_invc_item) && !empty($tax_invc_item)){
                    foreach($tax_invc_item as $member){
                        if($member->gst_type == 'intra-state'){
                          
                            $gst_rate = $member->sgst + $member->cgst;
                             $gst_amount = ($member->taxable_amount * $gst_rate) / 100;
                            $sub_total += $member->taxable_amount;
                           
                            $total_amount += $member->taxable_amount + $gst_amount;
                           
                        }else{
                           
                            $member->gst_amount = ($member->taxable_amount * $member->gst) / 100;
                        $sub_total += $member->taxable_amount;
                        $gst_amount += $member->gst_amount;
                        $total_amount += $member->taxable_amount + $member->gst_amount;
                        }
                      
                    }
                    }
                    $total_amount = $total_amount + $performa_invc->auto_round_value;
                    $customer_name = $this->admin_model->get_project_detail($id);
                    $data ['tax_invc_id'] = $id;
                    $data ['total_amount'] = sprintf('%0.2f', $total_amount);
                    // $data ['total_amount'] = sprintf('%0.2f', $invoice_amount);
                    $data['tax_invc_no'] = $tax_invc_no;
                    $data['retenstion_amount'] = $retenstion_amount;
                    $data['tax_invc_date'] = $tax_invc_date;
                    $data['customer_name'] = $customer_name;
                    $data['received_payment'] = sprintf('%0.2f', $final_received_payment);
                    if($final_received_payment <= $total_amount){
                    $data['payment_pay'] = sprintf('%0.2f', ($total_amount - $final_received_payment));
                    }
                    // echo "<pre>";
                    // print_r($data);die;
                    $this->load->view('payment-advice',$data);
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
    public function boq_exceptional_approval() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','boq-exceptional-approval');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_update = 'N';
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_boq_exceptional_approval');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                    $data['check_permission_update'] = $check_permission_update;
                    $this->load->view('boq-exceptional-approval',$data);
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
    
    public function get_dc_item_by_project() 
		{
		$project_id = $this->input->post('project_id');
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		
		$data = $row = $newarr = $datad = array();
		$boq_code_d = '<input type="text" class="form-control invaliderror" id="dc_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;width:100%">';
		$hsn_sac_code_d = '<input type="text" class="form-control invaliderror" id="hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;width:100%">';
		$item_description_d = '<input type="text" class="form-control invaliderror" id="item_description" placeholder="Item Description" style="font-size: 12px;width:100%">';
		$unit_d = '<input type="text" class="form-control invaliderror" id="unit" placeholder="Unit" style="font-size: 12px;width:100%">';
		$avl_qty_d = '<input type="number" min="1" class="form-control invaliderror" id="avl_qty" placeholder="Avl. Qty" style="font-size: 12px;width:100%">';
		$stock_qty_d = '<input type="number" min="1" class="form-control invaliderror" id="stock_qty" placeholder="Stock Qty" style="font-size: 12px;width:100%">';
		
		$action_d = '';
		$action_d .='<div class="addDeleteButton">';
		$action_d .='<span class="tooltips addDCVSRow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>';
		$action_d .='</div>';
		
		$datad[] = array(
		    $boq_code_d,
			$hsn_sac_code_d,
			$item_description_d,
			$unit_d,
			$avl_qty_d,
			$stock_qty_d,
			$action_d
		);	
		if(isset($data) && !empty($data)){
        $newarr = array_merge($data,$datad);   
        }else{
        $newarr = $datad;   
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $newarr,
        );
        echo json_encode($output);
		}

    }
    public function get_dcpwip_item_by_project() 
		{
		$project_id = $this->input->post('project_id');
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		
		$data = $row = $newarr = $datad = array();
		$boq_code_d = '<input type="hidden" id="wdc_boq_items_id" value="0"><input type="text" class="form-control invaliderror" id="wpdc_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;width:100%">';
		$hsn_sac_code_d = '<input type="text" class="form-control invaliderror" id="wdc_hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;width:100%">';
		$item_description_d = '<input type="text" class="form-control invaliderror" id="wdc_item_description" placeholder="Item Description" style="font-size: 12px;width:100%">';
		$unit_d = '<input type="text" class="form-control invaliderror" id="wdc_unit" placeholder="Unit" style="font-size: 12px;width:100%">';
		$avl_qty_d = '<input type="number" min="1" class="form-control invaliderror" id="wdc_avl_qty" placeholder="Stock Qty" style="font-size: 12px;width:100%">';
		$installed_qty_d = '<input type="number" min="1" class="form-control invaliderror" id="wdc_prov_qty" placeholder="Prov. Qty" style="font-size: 12px;width:100%"><input type="hidden" id="wdc_rate_basic">';
		
		$action_d = '';
		$action_d .='<div class="addDeleteButton">';
		$action_d .='<span class="tooltips addDCPWIPRow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>';
		$action_d .='</div>';
		
		$datad[] = array(
		    $boq_code_d,
			$hsn_sac_code_d,
			$item_description_d,
			$unit_d,
			$avl_qty_d,
			$installed_qty_d,
			$action_d
		);	
		if(isset($data) && !empty($data)){
        $newarr = array_merge($data,$datad);   
        }else{
        $newarr = $datad;   
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $newarr,
        );
        echo json_encode($output);
		}

    }
    public function get_dciwip_item_by_project() 
		{
		$project_id = $this->input->post('project_id');
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		
		$data = $row = $newarr = $datad = array();
		$boq_code_d = '<input type="hidden" id="wdc_boq_items_id" value="0"><input type="text" class="form-control invaliderror" id="wdc_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;width:100%">';
		$hsn_sac_code_d = '<input type="text" class="form-control invaliderror" id="wdc_hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;width:100%">';
		$item_description_d = '<input type="text" class="form-control invaliderror" id="wdc_item_description" placeholder="Item Description" style="font-size: 12px;width:100%">';
		$unit_d = '<input type="text" class="form-control invaliderror" id="wdc_unit" placeholder="Unit" style="font-size: 12px;width:100%">';
		$avl_qty_d = '<input type="number" min="1" class="form-control invaliderror" id="wdc_avl_qty" placeholder="Avl. Qty" style="font-size: 12px;width:100%">';
		$installed_qty_d = '<input type="number" min="1" class="form-control invaliderror" id="wdc_installed_qty" placeholder="Installed Qty" style="font-size: 12px;width:100%"><input type="hidden" id="wdc_rate_basic">';
		
		$action_d = '';
		$action_d .='<div class="addDeleteButton">';
		$action_d .='<span class="tooltips addDCIWIPRow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>';
		$action_d .='</div>';
		
		$datad[] = array(
		    $boq_code_d,
			$hsn_sac_code_d,
			$item_description_d,
			$unit_d,
			$avl_qty_d,
			$installed_qty_d,
			$action_d
		);	
		if(isset($data) && !empty($data)){
        $newarr = array_merge($data,$datad);   
        }else{
        $newarr = $datad;   
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $newarr,
        );
        echo json_encode($output);
		}

    }
    
    public function get_install_prov_by_project() 
		{
		$project_id = $this->input->post('project_id');
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		
		$data = $row = $newarr = $datad = array();
		$boq_code_d = '<input type="text" class="form-control invaliderror" id="dc_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;width:100%">';
		$hsn_sac_code_d = '<input type="text" class="form-control invaliderror" id="hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;width:100%">';
		$item_description_d = '<input type="text" class="form-control invaliderror" id="item_description" placeholder="Item Description" style="font-size: 12px;width:100%">';
		$unit_d = '<input type="text" class="form-control invaliderror" id="unit" placeholder="Unit" style="font-size: 12px;width:100%">';
		$qty_d = '<input type="number" min="1" class="form-control invaliderror" id="qty" placeholder="Qty" style="font-size: 12px;width:100%">';
		$rate_d = '<input type="number" min="1" class="form-control invaliderror" id="rate" placeholder="Rate" style="font-size: 12px;width:100%">';
		$amount_d = '<input type="number" min="1" class="form-control invaliderror" id="amount" placeholder="Amount" style="font-size: 12px;width:100%" readonly>';
		
		$action_d = '';
		$action_d .='<div class="addDeleteButton">';
		$action_d .='<span class="tooltips addProformaInvcRow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>';
		$action_d .='</div>';
		
		$datad[] = array(
		    $boq_code_d,
			$hsn_sac_code_d,
			$item_description_d,
			$unit_d,
			$qty_d,
			$rate_d,
			$amount_d,
			$action_d
		);	
		if(isset($data) && !empty($data)){
        $newarr = array_merge($data,$datad);   
        }else{
        $newarr = $datad;   
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $newarr,
        );
        echo json_encode($output);
		}

    }
    public function get_proforma_by_project() 
		{
		$project_id = $this->input->post('project_id');
		$gst_type = $this->input->post('gst_type');
        $user_id = $this->session->userData('user_id');
         
        if($gst_type == 'igst'){

            if(isset($user_id) && !empty($user_id)){
		
                $data = $row = $newarr = $datad = array();
                $boq_code_d = '<input type="text" class="form-control invaliderror" id="idc_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;width:100%">';
                $hsn_sac_code_d = '<input type="text" class="form-control invaliderror" id="hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;width:100%">';
                $item_description_d = '<input type="text" class="form-control invaliderror" id="item_description" placeholder="Item Description" style="font-size: 12px;width:100%">';
                $unit_d = '<input type="text" class="form-control invaliderror" id="unit" placeholder="Unit" style="font-size: 12px;width:100%">';
                $qty_d = '<input type="number" min="1" class="form-control invaliderror" id="qty" placeholder="Qty" style="font-size: 12px;width:100%">';
                $rate_d = '<input type="number" min="1" class="form-control invaliderror" id="rate" placeholder="Rate" style="font-size: 12px;width:100%">';
                $taxable_a = '<input type="number" min="1" class="form-control invaliderror" id="itaxable_amount" placeholder="Tax" style="font-size: 12px;width:100%" readonly>';
                $gst = '<input type="number" min="1" readonly class="form-control invaliderror" id="gst" placeholder="GST" style="font-size: 12px;width:100%">';
                // $amount_d = '<input type="number" min="1" class="form-control invaliderror" id="amount" placeholder="Amount" style="font-size: 12px;width:100%">';
                
                $total_amount = '<input type="number" min="1" class="form-control invaliderror" id="itotal_amount" placeholder="TotalAmount" style="font-size: 12px;width:100%" readonly>';
                
                $action_d = '';
                $action_d .='<div class="addDeleteButton">';
                $action_d .='<span class="tooltips addTaxInvcRow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>';
                $action_d .='</div>';
                
                $datad[] = array(
                    $boq_code_d,
                    $hsn_sac_code_d,
                    $item_description_d,
                    $unit_d,
                    $qty_d,
                    $rate_d,
                    $taxable_a,
                    $gst,
                    // $amount_d,
                   
                    $total_amount,
                    $action_d
                );	
                if(isset($data) && !empty($data)){
                $newarr = array_merge($data,$datad);   
                }else{
                $newarr = $datad;   
                }
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $allCount,
                    "recordsFiltered" => $countFiltered,
                    "data" => $newarr,
                );
                echo json_encode($output);
                }


        }else{


            $data = $row = $newarr = $datad = array();
            $boq_code_d = '<input type="text" class="form-control invaliderror" id="cdc_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;width:100%">';
            $hsn_sac_code_d = '<input type="text" class="form-control invaliderror" id="chsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;width:100%">';
            $item_description_d = '<input type="text" class="form-control invaliderror" id="citem_description" placeholder="Item Description" style="font-size: 12px;width:100%">';
            $unit_d = '<input type="text" class="form-control invaliderror" id="cunit" placeholder="Unit" style="font-size: 12px;width:100%">';
            $qty_d = '<input type="number" min="1" class="form-control invaliderror" id="cqty" placeholder="Qty" style="font-size: 12px;width:100%">';
            $rate_d = '<input type="number" min="1" class="form-control invaliderror" id="crate" placeholder="Rate" style="font-size: 12px;width:100%">';
            $taxable_a = '<input type="number" min="1" class="form-control invaliderror" id="ctaxable_amount" placeholder="Tax" style="font-size: 12px;width:100%" readonly>';
            $sgst = '<input type="number" readonly min="1" class="form-control invaliderror" id="sgst" placeholder="SGST" style="font-size: 12px;width:100%">';
            $sgst_amount = '<input type="number" min="1" readonly class="form-control invaliderror" id="sgst_amount" placeholder="Amount" style="font-size: 12px;width:100%">';
            $cgst = '<input type="number" min="1" readonly class="form-control invaliderror" id="cgst" placeholder="CGST" style="font-size: 12px;width:100%">';
            $cgst_amount = '<input type="number" min="1" readonly class="form-control invaliderror" id="cgst_amount" placeholder="Amount" style="font-size: 12px;width:100%">';
            
            // $total_amount = '<input type="number" min="1" class="form-control invaliderror" id="total_amount" placeholder="TotalAmount" style="font-size: 12px;width:100%" readonly>';
            
            $action_d = '';
            $action_d .='<div class="addDeleteButton">';
            $action_d .='<span class="tooltips addTaxInvcRow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>';
            $action_d .='</div>';
            
            $datad[] = array(
                $boq_code_d,
                $hsn_sac_code_d,
                $item_description_d,
                $unit_d,
                $qty_d,
                $rate_d,
                $taxable_a,
                $sgst,
                $sgst_amount,
                $cgst,
                $cgst_amount,
                // $amount_d,
               
              //  $total_amount,
                $action_d
            );	
            if(isset($data) && !empty($data)){
            $newarr = array_merge($data,$datad);   
            }else{
            $newarr = $datad;   
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $allCount,
                "recordsFiltered" => $countFiltered,
                "data" => $newarr,
            );
            echo json_encode($output);
            }
        }
    public function get_tax_invoice_by_projects(){
		$project_id = $this->input->post('project_id');
		$gst_type = $this->input->post('gst_type');
        $user_id = $this->session->userData('user_id');
        if($gst_type == 'igst'){
            if(isset($user_id) && !empty($user_id)){
                $data = $row = $newarr = $datad = array();
                $boq_code_d = '<input type="hidden" id="proforma_from" value=""><input type="text" class="form-control invaliderrorpro" id="taxinvoice_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;width:100%">';
                $hsn_sac_code_d = '<input type="text" class="form-control invaliderrorpro" id="proforma_hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;width:100%">';
                $item_description_d = '<input type="text" class="form-control invaliderrorpro" id="proforma_item_description" placeholder="Item Description" style="font-size: 12px;width:100%">';
                $unit_d = '<input type="text" class="form-control invaliderrorpro" id="proforma_unit" placeholder="Unit" style="font-size: 12px;width:100%">';
                $qty_d = '<input type="number" min="1" class="form-control invaliderrorpro" id="proforma_qty" placeholder="Qty" style="font-size: 12px;width:100%">';
                $rate_d = '<input type="number" min="1" class="form-control invaliderrorpro" id="proforma_rate" placeholder="Rate" style="font-size: 12px;width:100%">';
                $taxable_a = '<input type="number" min="1" class="form-control invaliderrorpro" id="proforma_itaxable_amount" placeholder="Tax" style="font-size: 12px;width:100%" readonly>';
                $gst = '<input type="number" min="1" class="form-control invaliderrorpro" id="proforma_gst" placeholder="GST" style="font-size: 12px;width:100%">';
                $total_amount = '<input type="number" min="1" class="form-control invaliderrorpro" id="proforma_itotal_amount" placeholder="TotalAmount" style="font-size: 12px;width:100%" readonly><input type="hidden" id="proforma_gst_amount" value="0">';
                $action_d = '';
                $action_d .='<div class="addDeleteButton">';
                $action_d .='<span class="tooltips addTaxInvoiceRow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>';
                $action_d .='</div>';
                $datad[] = array(
                    $boq_code_d,
                    $hsn_sac_code_d,
                    $item_description_d,
                    $unit_d,
                    $qty_d,
                    $rate_d,
                    $taxable_a,
                    $gst,
                    $total_amount,
                    $action_d
                );	
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $allCount,
                    "recordsFiltered" => $countFiltered,
                    "data" => $datad,
                );
                echo json_encode($output);
            }
        }else{
            if(isset($user_id) && !empty($user_id)){
                $data = $row = $newarr = $datad = array();
                $boq_code_d = '<input type="hidden" id="proforma_from1" value=""><input type="text" class="form-control invaliderrorpro1" id="taxinvoice_boq_code1" placeholder="BOQ Sr No" style="font-size: 12px;width:100%">';
                $hsn_sac_code_d = '<input type="text" class="form-control invaliderrorpro1" id="proforma_hsn_sac_code1" placeholder="HSN/SAC Code" style="font-size: 12px;width:100%">';
                $item_description_d = '<input type="text" class="form-control invaliderrorpro1" id="proforma_item_description1" placeholder="Item Description" style="font-size: 12px;width:100%">';
                $unit_d = '<input type="text" class="form-control invaliderrorpro1" id="proforma_unit1" placeholder="Unit" style="font-size: 12px;width:100%">';
                $qty_d = '<input type="number" min="1" class="form-control invaliderrorpro1" id="proforma_qty1" placeholder="Qty" style="font-size: 12px;width:100%">';
                $rate_d = '<input type="number" min="1" class="form-control invaliderrorpro1" id="proforma_rate1" placeholder="Rate" style="font-size: 12px;width:100%">';
                $taxable_a = '<input type="number" min="1" class="form-control invaliderrorpro1" id="proforma_itaxable_amount1" placeholder="Tax" style="font-size: 12px;width:100%" readonly>';
                $sgst = '<input type="number"  min="1" class="form-control invaliderrorpro1" id="proforma_sgst1" placeholder="SGST" style="font-size: 12px;width:100%">';
                $sgst_amount = '<input type="number" min="1" readonly class="form-control invaliderrorpro1" id="proforma_sgst_amount1" placeholder="Amount" style="font-size: 12px;width:100%">';
                $cgst = '<input type="number" min="1"  class="form-control invaliderrorpro1" id="proforma_cgst1" placeholder="CGST" style="font-size: 12px;width:100%">';
                $cgst_amount = '<input type="number" min="1" readonly class="form-control invaliderrorpro1" id="proforma_cgst_amount1" placeholder="Amount" style="font-size: 12px;width:100%">';
                
                $action_d = '';
                $action_d .='<div class="addDeleteButton">';
                $action_d .='<span class="tooltips addTaxInvoiceRow1" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>';
                $action_d .='</div>';
                $datad[] = array(
                    $boq_code_d,
                    $hsn_sac_code_d,
                    $item_description_d,
                    $unit_d,
                    $qty_d,
                    $rate_d,
                    $taxable_a,
                    $sgst,
                    $sgst_amount,
                    $cgst,
                    $cgst_amount,
                    $action_d
                );	
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $allCount,
                    "recordsFiltered" => $countFiltered,
                    "data" => $datad,
                );
                echo json_encode($output);
            }
        }
		    
	}
	public function get_proforma_by_projects(){
        //error_reporting(E_ALL ^ E_NOTICE);  

		$project_id = $this->input->post('project_id');
		$gst_type = $this->input->post('gst_type');
        $user_id = $this->session->userData('user_id');
        $project_data=$this->common_model->selectDetailsWhr('tbl_projects','project_id',$project_id);

        $payment_terms = isset($project_data->payment_terms) ? $project_data->payment_terms :'';
        $bill_split_supply = isset($project_data->bill_split_supply) ? $project_data->bill_split_supply :'';
        $bill_installation = isset($project_data->bill_installation) ? $project_data->bill_installation :''; 
        $testing_commissioning = isset($project_data->testing_commissioning) ? $project_data->testing_commissioning : '';
        $bill_handover = isset($project_data->bill_handover) ? $project_data->bill_handover : '';


        // $this->common_model->get_billing_split_up_by_project();

        $proforma_invc = $this->common_model->selectDetailsWhereAllDY('tbl_proforma_invc', 'project_id',$project_id);

        $billing_type_arr = array();
        foreach($proforma_invc as $proforma) {
            if(isset($proforma->billing_type) && !empty($proforma->billing_type)) { $billing_type = $proforma->billing_type; }else { $billing_type = ''; }
            $billing_type_arr[] = $billing_type;
        }
      
        if($gst_type == 'igst'){
            if(isset($user_id) && !empty($user_id)){
                $data = $row = $newarr = $datad = array();
                $boq_code_d = '<input type="hidden" id="proforma_from" value=""><input type="text" class="form-control invaliderrorpro" id="proforma_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;width:100%">';
                $hsn_sac_code_d = '<input type="text" class="form-control invaliderrorpro" id="proforma_hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;width:100%">';
                $item_description_d = '<input type="text" class="form-control invaliderrorpro" id="proforma_item_description" placeholder="Item Description" style="font-size: 12px;width:100%">';
                $unit_d = '<input type="text" class="form-control invaliderrorpro" id="proforma_unit" placeholder="Unit" style="font-size: 12px;width:100%">';
                $qty_d = '<input type="number" min="1" class="form-control invaliderrorpro" id="proforma_qty" placeholder="Qty" style="font-size: 12px;width:100%">';
                $rate_d = '<input type="number" min="1" class="form-control invaliderrorpro" id="proforma_rate" placeholder="Rate" style="font-size: 12px;width:100%">';
                $taxable_a = '<input type="number" min="1" class="form-control invaliderrorpro" id="proforma_itaxable_amount" placeholder="Tax" style="font-size: 12px;width:100%" readonly>';
                $gst = '<input type="number" min="1" class="form-control invaliderrorpro" id="proforma_gst" placeholder="GST" style="font-size: 12px;width:100%">';
                $total_amount = '<input type="number" min="1" class="form-control invaliderrorpro" id="proforma_itotal_amount" placeholder="TotalAmount" style="font-size: 12px;width:100%" readonly><input type="hidden" id="proforma_gst_amount" value="0">';
                $action_d = '';
                $action_d .='<div class="addDeleteButton">';
                $action_d .='<span class="tooltips addPerfomaInvcRow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>';
                $action_d .='</div>';
                $datad[] = array(
                    $boq_code_d,
                    $hsn_sac_code_d,
                    $item_description_d,
                    $unit_d,
                    $qty_d,
                    $rate_d,
                    $taxable_a,
                    $gst,
                    $total_amount,
                    $action_d
                );	
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $allCount,
                    "recordsFiltered" => $countFiltered,
                    "data" => $datad,
                    'billing_split' => compact('payment_terms','bill_split_supply','bill_installation','testing_commissioning','bill_handover','billing_type_arr'),
                );
                echo json_encode($output);
            }
        }else{
            if(isset($user_id) && !empty($user_id)){
                $data = $row = $newarr = $datad = array();
                $boq_code_d = '<input type="hidden" id="proforma_from1" value=""><input type="text" class="form-control invaliderrorpro1" id="proforma_boq_code1" placeholder="BOQ Sr No" style="font-size: 12px;width:100%">';
                $hsn_sac_code_d = '<input type="text" class="form-control invaliderrorpro1" id="proforma_hsn_sac_code1" placeholder="HSN/SAC Code" style="font-size: 12px;width:100%">';
                $item_description_d = '<input type="text" class="form-control invaliderrorpro1" id="proforma_item_description1" placeholder="Item Description" style="font-size: 12px;width:100%">';
                $unit_d = '<input type="text" class="form-control invaliderrorpro1" id="proforma_unit1" placeholder="Unit" style="font-size: 12px;width:100%">';
                $qty_d = '<input type="number" min="1" class="form-control invaliderrorpro1" id="proforma_qty1" placeholder="Qty" style="font-size: 12px;width:100%">';
                $rate_d = '<input type="number" min="1" class="form-control invaliderrorpro1" id="proforma_rate1" placeholder="Rate" style="font-size: 12px;width:100%">';
                $taxable_a = '<input type="number" min="1" class="form-control invaliderrorpro1" id="proforma_itaxable_amount1" placeholder="Tax" style="font-size: 12px;width:100%" readonly>';
                $sgst = '<input type="number"  min="1" class="form-control invaliderrorpro1" id="proforma_sgst1" placeholder="SGST" style="font-size: 12px;width:100%">';
                $sgst_amount = '<input type="number" min="1" readonly class="form-control invaliderrorpro1" id="proforma_sgst_amount1" placeholder="Amount" style="font-size: 12px;width:100%">';
                $cgst = '<input type="number" min="1"  class="form-control invaliderrorpro1" id="proforma_cgst1" placeholder="CGST" style="font-size: 12px;width:100%">';
                $cgst_amount = '<input type="number" min="1" readonly class="form-control invaliderrorpro1" id="proforma_cgst_amount1" placeholder="Amount" style="font-size: 12px;width:100%">';
                
                $action_d = '';
                $action_d .='<div class="addDeleteButton">';
                $action_d .='<span class="tooltips addPerfomaInvcRow1" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>';
                $action_d .='</div>';
                $datad[] = array(
                    $boq_code_d,
                    $hsn_sac_code_d,
                    $item_description_d,
                    $unit_d,
                    $qty_d,
                    $rate_d,
                    $taxable_a,
                    $sgst,
                    $sgst_amount,
                    $cgst,
                    $cgst_amount,
                    $action_d
                );	
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $allCount,
                    "recordsFiltered" => $countFiltered,
                    "data" => $datad,
                    'billing_split' => compact('payment_terms','bill_split_supply','bill_installation','testing_commissioning','bill_handover','billing_type_arr'),
                );
                echo json_encode($output);
            }
        }
		    
	}
	public function get_boq_dc_stock_qty(){
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $avl_stock = 0;
        if(isset($project_id) && !empty($project_id) && isset($boq_code) && !empty($boq_code)){
            $get_boq_avl_stock = $this->admin_model->check_stock_details($project_id,$boq_code);
            if(isset($get_boq_avl_stock) && !empty($get_boq_avl_stock)){
                if(isset($get_boq_avl_stock->dc_stock)){
                    $avl_stock = $get_boq_avl_stock->dc_stock;    
                }elseif(isset($get_boq_avl_stock->avl_stock) && !empty($get_boq_avl_stock->avl_stock) && $get_boq_avl_stock->avl_stock > 0){
                    $avl_stock = $get_boq_avl_stock->avl_stock;    
                }
            }else{
                if(isset($project_id) && !empty($project_id) && isset($boq_code) && !empty($boq_code)){
                    $total_stock = $this->admin_model->get_boq_final_qty($project_id,$boq_code);
                    if(isset($total_stock) && !empty($total_stock) && $total_stock > 0){
                        $avl_stock = $total_stock;    
                    }
                }
            }
        }
        echo $avl_stock;
	}
	public function get_boq_final_qty(){
        $qty=0;
        $project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        if(isset($project_id) && !empty($boq_code) && isset($boq_code) && !empty($boq_code)){
        $qty = $this->admin_model->get_boq_final_qty($project_id,$boq_code);
        }
        echo $qty;
    }
    public function get_boq_old_dc_qty(){
        $qty=0;
        $project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $challan_id = $this->input->post('challan_id');
        if(isset($project_id) && !empty($boq_code) && isset($boq_code) && !empty($boq_code)
        && isset($challan_id) && !empty($challan_id)){
        $qty = $this->admin_model->get_boq_old_dc_qty($project_id,$boq_code,$challan_id);
        }
        echo $qty;
    }
    
    public function get_boq_dc_reject_stock(){
        $qty=0;
        $project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        if(isset($project_id) && !empty($boq_code) && isset($boq_code) && !empty($boq_code)){
        $qty = $this->admin_model->get_boq_dc_reject_stock($project_id,$boq_code);
        }
        echo $qty;
    }
    public function get_boq_installed_provisional_qty(){
        $qty=0;
        $project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        if(isset($project_id) && !empty($boq_code) && isset($boq_code) && !empty($boq_code)){
        $qty = $this->admin_model->get_boq_installed_provisional_qty($project_id,$boq_code);
        }
        echo $qty;
    }
	public function get_client_dc_by_project() 
	{
		$project_id = $this->input->post('project_id');
        $gst_type = $this->input->post('gst_type');
        $c_type = $this->input->post('c_type');
        $user_id = $this->session->userData('user_id');
        $project_detail = $this->admin_model->get_project_item_details($project_id);
        $consinee_item = $this->common_model->selectAllconsineeWhr('tbl_deliv_challan_consignee','project_id',$project_id);
	    $data = $row = $newarr = $datad = array();
        if(isset($c_type) && !empty($c_type) && $c_type == 'delivery_challan'){
	        $boq_code_d = '<input type="hidden" id="dcwi_boq_items_id" value="0"><input type="text" class="form-control invaliderrordcc" id="dcwi_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;width:100%;">';
            $hsn_sac_code_d = '<input type="text" class="form-control invaliderrordcc" id="dcwi_hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;width:100%;">';
            $item_description_d = '<input type="text" class="form-control invaliderrordcc" id="dcwi_item_description" placeholder="Item Description" style="font-size: 12px;width:100%;">';
            $unit_d = '<input type="text" class="form-control invaliderrordcc" id="dcwi_unit" placeholder="Unit" style="font-size: 12px;width:100%;">';
            $qty_d = '<input type="number" min="1" class="form-control invaliderrordcc" id="dcwi_qty" placeholder="Qty" style="font-size: 12px;width:100%;"><input type="hidden" id="dcwi_rate"><input type="hidden" id="dcwi_total_rate">';
            $action_d = '';
            $action_d .='<div class="addDeleteButton">';
            $action_d .='<span class="tooltips addDccWIRow" data-placement="top" data-original-title="Add" style="cursor: pointer;width:100%;"><i class="fa fa-plus" style="color:#000"></i></span>';
            $action_d .='</div>';
            $newarr[] = array(
                $boq_code_d,
                $hsn_sac_code_d,
                $item_description_d,
                $unit_d,
                $qty_d,
                //$rate_d,
                //$totalamount_d,
                $action_d
            );	
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $allCount,
                "recordsFiltered" => $countFiltered,
                "data" => $newarr,
                "project_detail" => $project_detail,
                "consinee_item" => $consinee_item,
            );
            echo json_encode($output);
        }else{
            if($gst_type == 'igst'){
                $boq_code_d = '<input type="hidden" id="dcwi1_boq_items_id" value="0"><input type="text" class="form-control invaliderrordcc1" id="dcwi1_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;width:100%;">';
                $hsn_sac_code_d = '<input type="text" class="form-control invaliderrordcc1" id="dcwi1_hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;width:100%;">';
                $item_description_d = '<input type="text" class="form-control invaliderrordcc1" id="dcwi1_item_description" placeholder="Item Description" style="font-size: 12px;width:100%;">';
                $unit_d = '<input type="text" class="form-control invaliderrordcc1" id="dcwi1_unit" placeholder="Unit" style="font-size: 12px;width:100%;">';
                $qty_d = '<input type="number" min="1" class="form-control invaliderrordcc1" id="dcwi1_qty" placeholder="Qty" style="font-size: 12px;width:100%;">';
                $rate_d = '<input type="number" min="1" class="form-control invaliderrordcc1" id="dcwi1_rate" placeholder="Rate" style="font-size: 12px;width:100%;">';
                $total_rate_d = '<input type="number" min="1" class="form-control invaliderrordcc1" id="dcwi1_total_rate" placeholder="Total" style="font-size: 12px;width:100%;">';
                $gst_d = '<input type="number" min="1" class="form-control invaliderrordcc1" id="dcwi1_gst" placeholder="GST" style="font-size: 12px;width:100%;">';
                $totalamount_d = '<input type="number" min="1" class="form-control invaliderrordcc1" id="dcwi1_itotal_amount" placeholder="Total Amount" style="font-size: 12px;width:100%;" readonly>
                <input type="hidden" id="dcwi1_gst_amount">';
                $action_d = '';
                $action_d .='<div class="addDeleteButton">';
                $action_d .='<span class="tooltips addDccTIRow" data-placement="top" data-original-title="Add" style="cursor: pointer;width:100%;"><i class="fa fa-plus" style="color:#000"></i></span>';
                $action_d .='</div>';
                $newarr[] = array(
                    $boq_code_d,
                    $hsn_sac_code_d,
                    $item_description_d,
                    $unit_d,
                    $qty_d,
                    $rate_d,
                    $total_rate_d,
                    $gst_d,
                    $totalamount_d,
                    $action_d
                );	
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $allCount,
                    "recordsFiltered" => $countFiltered,
                    "data" => $newarr,
                    "project_detail" => $project_detail,
                    "consinee_item" => $consinee_item,
                );
                echo json_encode($output);
            }else{
                $boq_code_d = '<input type="hidden" id="dcwi2_boq_items_id" value="0"><input type="text" class="form-control invaliderrordcc2" id="dcwi2_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;width:100%;">';
                $hsn_sac_code_d = '<input type="text" class="form-control invaliderrordcc2" id="dcwi2_hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;width:100%;">';
                $item_description_d = '<input type="text" class="form-control invaliderrordcc2" id="dcwi2_item_description" placeholder="Item Description" style="font-size: 12px;width:100%;">';
                $unit_d = '<input type="text" class="form-control invaliderrordcc2" id="dcwi2_unit" placeholder="Unit" style="font-size: 12px;width:100%;">';
                $qty_d = '<input type="number" min="1" class="form-control invaliderrordcc2" id="dcwi2_qty" placeholder="Qty" style="font-size: 12px;width:100%;">';
                $rate_d = '<input type="number" min="1" class="form-control invaliderrordcc2" id="dcwi2_rate" placeholder="Rate" style="font-size: 12px;width:100%;">';
                $total_rate_d = '<input type="number" min="1" class="form-control invaliderrordcc2" id="dcwi2_total_rate" placeholder="Total" style="font-size: 12px;width:100%;">';
                $sgst_d = '<input type="number" min="1" class="form-control invaliderrordcc2" id="dcwi2_sgst" placeholder="SGST" style="font-size: 12px;width:100%;">';
                $sgstamt_d = '<input type="number" min="1" class="form-control invaliderrordcc2" id="dcwi2_sgst_amount" placeholder="SGST Amount" style="font-size: 12px;width:100%;">';
                $cgst_d = '<input type="number" min="1" class="form-control invaliderrordcc2" id="dcwi2_cgst" placeholder="CGST" style="font-size: 12px;width:100%;">';
                $cgstamt_d = '<input type="number" min="1" class="form-control invaliderrordcc2" id="dcwi2_cgst_amount" placeholder="CGST Amount" style="font-size: 12px;width:100%;"><input type="hidden" id="dcwi2_itotal_amount">';
                $action_d = '';
                $action_d .='<div class="addDeleteButton">';
                $action_d .='<span class="tooltips addDccTIRowIntra" data-placement="top" data-original-title="Add" style="cursor: pointer;width:100%;"><i class="fa fa-plus" style="color:#000"></i></span>';
                $action_d .='</div>';
                $newarr[] = array(
                    $boq_code_d,
                    $hsn_sac_code_d,
                    $item_description_d,
                    $unit_d,
                    $qty_d,
                    $rate_d,
                    $total_rate_d,
                    $sgst_d,
                    $sgstamt_d,
                    $cgst_d,
                    $cgstamt_d,
                    $action_d
                );	
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $allCount,
                    "recordsFiltered" => $countFiltered,
                    "data" => $newarr,
                    "project_detail" => $project_detail,
                    "consinee_item" => $consinee_item,
                );
                echo json_encode($output);
            }
	    }
    }
    
    
    public function check_boq_exceptional_approval(){
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $cnt = 0;
        if(isset($project_id) && !empty($project_id) && isset($boq_code) && !empty($boq_code)){
    		$check_pending_req = $this->admin_model->pending_boq_exceptional_item($project_id,$boq_code);
            if(isset($check_pending_req) && !empty($check_pending_req)){
                $cnt = 1;    
            }
        }
        echo $cnt;
	}
	public function get_stock_details(){
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $res = '';
        if(isset($project_id) && !empty($project_id) && isset($boq_code) && !empty($boq_code)){
    		$BOQStockArr=$this->admin_model->check_stock_details($project_id,$boq_code);
    		if(isset($BOQStockArr) && !empty($BOQStockArr)){
                $res = json_encode($BOQStockArr);
            }
        }
        echo $res;
	}
	public function get_last_design_qty(){
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $last_design_qty = 0;
        if(isset($project_id) && !empty($project_id) && isset($boq_code) && !empty($boq_code)){
    		$get_last_design_qty = $this->admin_model->get_boq_item_details($project_id,$boq_code);
            if(isset($get_last_design_qty->design_qty) && !empty($get_last_design_qty->design_qty) && $get_last_design_qty->design_qty > 0){
                $last_design_qty = $get_last_design_qty->design_qty;    
            }
        }
        echo $last_design_qty;
	}
	
	public function get_boq_dc_stock(){
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $avl_stock = 0;
        if(isset($project_id) && !empty($project_id) && isset($boq_code) && !empty($boq_code)){
            $avl_stock = $this->common_model->getDCApprovedQty($project_id,$boq_code);
        }
        echo $avl_stock;
	}
    public function get_boq_proforma_stock(){
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $avl_stock = 0;
        if(isset($project_id) && !empty($project_id) && isset($boq_code) && !empty($boq_code)){
            $avl_stock = $this->common_model->getProformaApprovedQty($project_id,$boq_code);
        }
        echo $avl_stock;
	}
	public function get_boq_tax_stock(){
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $avl_stock = 0;
        if(isset($project_id) && !empty($project_id) && isset($boq_code) && !empty($boq_code)){
            $avl_stock = $this->common_model->getTaxInvApprovedQty($project_id,$boq_code);
        }
        echo $avl_stock;
	}
    public function get_boq_stock(){
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $avl_stock = 0;
        if(isset($project_id) && !empty($project_id) && isset($boq_code) && !empty($boq_code)){
            $avl_stock = $this->common_model->getTotalApprovedQty($project_id,$boq_code);
        }
        echo $avl_stock;
	}
    public function get_boq_avl_stock(){
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $avl_stock = 0;
        if(isset($project_id) && !empty($project_id) && isset($boq_code) && !empty($boq_code)){
            $get_boq_avl_stock = $this->admin_model->check_stock_details($project_id,$boq_code);
            if(isset($get_boq_avl_stock) && !empty($get_boq_avl_stock)){
                if(isset($get_boq_avl_stock->avl_stock) && !empty($get_boq_avl_stock->avl_stock) && $get_boq_avl_stock->avl_stock > 0){
                    $avl_stock = $get_boq_avl_stock->avl_stock;    
                }elseif(isset($get_boq_avl_stock->provisional) && !empty($get_boq_avl_stock->provisional) && $get_boq_avl_stock->provisional > 0){
                    $avl_stock = 'provisional-'.$get_boq_avl_stock->provisional;    
                }
            }else{
                if(isset($project_id) && !empty($project_id) && isset($boq_code) && !empty($boq_code)){
                    $total_stock = $this->admin_model->get_boq_final_qty($project_id,$boq_code);
                    if(isset($total_stock) && !empty($total_stock) && $total_stock > 0){
                        $avl_stock = $total_stock;    
                    }
                }
            }
        }
        echo $avl_stock;
	}
    
	public function get_boq_item_by_project() 
		{
		$project_id = $this->input->post('project_id');
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		
		$data = $row = $newarr = $datad = array();
		$boq_code_d = '<input type="text" class="form-control invaliderror"  id="boq_code" placeholder="BOQ Sr No" style="font-size: 12px;width:100%">';
		$hsn_sac_code_d = '<input type="text" class="form-control invaliderror"  id="hsn_sac_code" placeholder="HSN/SAC Code" style="font-size: 12px;width:100%">';
		$item_description_d = '<input type="text" class="form-control invaliderror"  id="item_description" placeholder="Item Description" style="font-size: 12px;width:100%">';
		$unit_d = '<input type="text" class="form-control invaliderror"  id="unit" placeholder="Unit" style="font-size: 12px;width:100%">';
		$scheduled_qty_d = '<input type="number" min="1" class="form-control invaliderror"  id="scheduled_qty" placeholder="Sche. Qty" style="font-size: 12px;width:100%">';
		$design_qty_d = '<input type="number" min="1" class="form-control invaliderror"  id="design_qty" placeholder="Des. Qty" style="font-size: 12px;width:100%">';
		$rate_basic_d = '<input type="number" min="1" class="form-control invaliderror"  id="rate_basic" placeholder="Rate Basic" style="font-size: 12px;width:100%">';
		$gst_d = '<input type="number" min="0" class="form-control invaliderror"  id="gst" placeholder="GST %" style="font-size: 12px;width:100%">';
			
		$non_schedule_d = '<div class="dflx">';
		$non_schedule_d .='<input type="radio" name="non_schedule_r" id="non_schedule_yes" value="Y"><span style="padding: 1px 5px 0px 5px;">Y</span>';
		$non_schedule_d .='<input type="radio" name="non_schedule_r" id="non_schedule_no" value="N" checked><span style="padding: 1px 0px 0px 5px;">N</span>';
		$non_schedule_d .='</div>';
			
		$action_d = '';
		$action_d .='<div class="addDeleteButton">';
		$action_d .='<span class="tooltips addDynaRow" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span>';
		$action_d .='</div>';
		
		$datad[] = array(
		    $boq_code_d,
			$hsn_sac_code_d,
			$item_description_d,
			$unit_d,
			$scheduled_qty_d,
			$design_qty_d,
			$rate_basic_d,
			$gst_d,
			$non_schedule_d,
			$action_d
		);	
		if(isset($data) && !empty($data)){
        $newarr = array_merge($data,$datad);   
        }else{
        $newarr = $datad;   
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $newarr,
        );
        echo json_encode($output);
		}

    }
    
    public function get_boq_exceptional_by_project() {

    $project_idpost = $this->input->post('project_id');
    if(isset($project_idpost) && !empty($project_idpost)){
        $project_id = $project_idpost;
    }else{
        $project_id = 0;
    }

    $billable = $this->input->post('billable');
    if(isset($billable) && !empty($billable) && $billable == 'Y'){
        $billable = $billable;
    }else{
        $billable = 'N';
    }

    $user_id = $this->session->userData('user_id');
    if(isset($user_id) && !empty($user_id)){
    $data = $new_entry_arr = array();
    $memData = $this->admin_model->getBOQExceptItemListRows($_POST,$project_id);
    $allCount = $this->admin_model->countBOQExceptItemListAll($project_id);
    $countFiltered = $this->admin_model->countBOQExceptItemListFiltered($_POST,$project_id);

    $project_id_arr = $boq_code_arr = array();

    if(isset($memData) && !empty($memData)){
        foreach($memData as $member){
            if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = ''; }
            if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = 0; }
            if(!empty($boq_code) && !empty($project_id)){
                $project_id_arr[] = $project_id;
                $boq_code_arr[] = $boq_code;
            }
        }
    }

    $BOQStockArr = array();
    if(isset($project_id_arr) && !empty($project_id_arr) && isset($boq_code_arr) && !empty($boq_code_arr)){
        $project_ids = "'" . implode ( "', '", $project_id_arr ) . "'";
        $boq_codes = "'" . implode ( "', '", $boq_code_arr ) . "'";
        $BOQStockArr=$this->common_model->getBOQStockBulkDetails($project_ids,$boq_codes);
    }

    $i = $_POST['start'];
    $boq_code_dn = '<input type="hidden" id="except_boq_items_id"><input type="text" class="form-control invaliderrorexcept"  id="except_boq_code" placeholder="BOQ Sr No" style="font-size: 12px;width:100%;">';
    $item_description_dn = '<input type="text" class="form-control invaliderrorexcept"  id="except_item_description" placeholder="Item Description" style="font-size: 12px;width:100%;" readonly>';
    $ea_qty_dn = '<input type="number" class="form-control invaliderrorexcept"  id="except_ea_qty" placeholder="EA Qty" style="font-size: 12px;width:100%;">';
    $design_qty_dn = '<input type="number" min="1" class="form-control invaliderrorexcept"  id="except_ea_design_qty" placeholder="Build Qty" style="font-size: 12px;width:100%;" readonly>';
    $sch_qty_dn = '<input type="number" min="1" class="form-control invaliderrorexcept"  id="except_scheduled_qty" placeholder="Sche. Qty" style="font-size: 12px;width:100%;" readonly>
    <input type="hidden" id="except_design_qty"><input type="hidden" id="except_hsn_sac_code"><input type="hidden" id="except_unit">
    <input type="hidden" id="except_rate_basic"><input type="hidden" id="except_gst">
    <input type="hidden" id="except_o_design_qty">
    <input type="hidden" id="except_released_approved" value="">
    ';
    
    $ns_dn = '<input type="text" class="form-control invaliderrorexcept"  id="except_non_schedule" placeholder="Yes/No" style="font-size: 12px;width:100%;" readonly>';
    $action_dn ='<div class="addDeleteButton"><span class="tooltips addBOQExceptionalData" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span></div>';
    $or_design_qty_dn = '<input type="number" min="1" class="form-control invaliderrorexcept"  id="except_or_design_qty" placeholder="Design Qty" style="font-size: 12px;width:100%;" readonly>';
    $new_entry_arr[] = array($boq_code_dn,$item_description_dn,$sch_qty_dn,$or_design_qty_dn,$design_qty_dn,$ea_qty_dn,$ns_dn,$action_dn);

    $boq_without_bom = array();
    
    // echo "<pre>";
    // print_r($memData);die;
    foreach($memData as $member){
        $i++;
        $boq_code_d = '';
        $item_description_d = '';
        $ea_qty_d = '';
        $ns_d = '';
        $action_d = '';
        $sche_qty_d='';
        $design_qty_d='';
        if(isset($member->id) && !empty($member->id)) { $id = $member->id; }else { $id = 0; }
        if(isset($member->EA_qty) && !empty($member->EA_qty)) { $EA_qty = $member->EA_qty; }else { $EA_qty = 0; }
        if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
        if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = ''; }
        if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $hsn_sac_code = $member->hsn_sac_code; }else { $hsn_sac_code = ''; }
        if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = ''; }
        if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = 0; }
        if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = 0; }
        if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $boq_items_id = $member->boq_items_id; }else { $boq_items_id = 0; }
        if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = 0; }
        if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = 0; }
        if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = 0; }
        if(isset($member->o_design_qty) && !empty($member->o_design_qty)) { $o_design_qty = $member->o_design_qty; }else { $o_design_qty = 0; }
        if(isset($member->non_schedule) && !empty($member->non_schedule) && $member->non_schedule == 'Y') { $non_schedule = 'Yes'; }else { $non_schedule = 'No'; }
        if(isset($member->except_type) && !empty($member->except_type)) { $except_type = $member->except_type; }else { $except_type = 'positive'; }
        $taxable_amount = 0;
        $taxable_amount = $EA_qty * $rate_basic;
        $gst_amount = 0;
        if($gst > 0){
            $gst_amount = $taxable_amount * ($gst/100);
        }

        if(!empty($boq_items_id)){
            $boq_items_id = $boq_items_id;    
        }else{
            $boq_items_id = 0;
            if(isset($project_id) && !empty($project_id)
            && isset($boq_code) && !empty($boq_code)){
                $boqItemData = $this->admin_model->get_approved_boq_item_details($project_id,$boq_code);
                if(isset($boqItemData->boq_items_id) && !empty($boqItemData->boq_items_id)){
                    $boq_items_id = $boqItemData->boq_items_id;     
                }
            }
        }

        $build_qty = 0; 
        if(isset($BOQStockArr[$project_id.'-'.$boq_code]) && !empty($BOQStockArr[$project_id.'-'.$boq_code])){
            $dc_stock=0;
            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['dc_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['dc_stock']) 
            && $BOQStockArr[$project_id.'-'.$boq_code]['dc_stock'] > 0){
                $dc_stock = $BOQStockArr[$project_id.'-'.$boq_code]['dc_stock'];
            }
            if($dc_stock >= $EA_qty){
                $build_qty = $dc_stock;    
            }
        }

        $boq_code_d .= '<input type="hidden" name="boq_items_id[]" value="'.$boq_items_id.'"><input type="text" class="form-control invaliderror"  name="boq_code[]" value="'.$boq_code.'" placeholder="BOQ Sr No" style="font-size: 12px;width:100%" readonly>';
        $item_description_d .= '<input type="text" class="form-control invaliderror"  name="item_description[]" value="'.$item_description.'" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>';
        $ea_qty_d .= '<input type="number" class="form-control invaliderror" name="ea_qty[]" value="'.$EA_qty.'" placeholder="EA Qty" style="font-size: 12px;width:100%" readonly>';
        $ns_d .= '<input type="text" class="form-control invaliderror" name="non_schedule[]" value="'.$non_schedule.'" placeholder="Yes/No" style="font-size: 12px;width:100%" readonly>';
        $sche_qty_d .= '<input type="number" class="form-control invaliderror" name="scheduled_qty[]" value="'.$scheduled_qty.'" placeholder="Sche. Qty" style="font-size: 12px;width:100%" readonly>';
        $design_qty_d .= '<input type="number" class="form-control invaliderror" name="ea_design_qty[]" value="'.$build_qty.'" placeholder="Design Qty" style="font-size: 12px;width:100%" readonly>
        <input type="hidden" name="design_qty[]" value="'.$design_qty.'"><input type="hidden" name="hsn_sac_code[]" value="'.$hsn_sac_code.'"><input type="hidden" name="unit[]" value="'.$unit.'">
        <input type="hidden" name="rate_basic[]" value="'.$rate_basic.'"><input type="hidden" name="gst[]" value="'.$gst.'">
        <input type="hidden" name="taxable_amount[]" value="'.$taxable_amount.'"><input type="hidden" name="gst_amount[]" value="'.$gst_amount.'">';
        $action_d .='<div class="addDeleteButton">';
        $action_d .='<span class="tooltips deleteBoqExceptnRow tr'.$i.'" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>';
        $action_d .='</div>';
        $o_design_qty ='<input type="text" class="form-control" name="o_design_qty[]" value="'.$o_design_qty.'" readonly style="font-size: 12px;width:100%"></td>';
        
        
        $bom_item_count = $this->admin_model->boq_exceptional_bom_item($project_id,$boq_code);
       
        if($bom_item_count  > 0 || $except_type =='ns_yes') {
            $data[] = array(
                $boq_code_d,
                $item_description_d,
                $sche_qty_d,
                $o_design_qty,
                $design_qty_d,
                $ea_qty_d,
                $ns_d,
                $action_d
            );	
        } else {
            $boq_without_bom[] = $boq_code;
        }
    }

    if(isset($billable) && !empty($billable) && $billable == 'Y'){
        if(isset($data) && !empty($data)){
            $data_new = array_merge($data,$new_entry_arr);
        }else{
            $data_new = $new_entry_arr;
        }
    }else{
        $data_new = $new_entry_arr;
    }

    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $allCount,
        "recordsFiltered" => $countFiltered,
        "data" => $data_new,
        'boq_without_bom' => $boq_without_bom

    );

    echo json_encode($output);

    }
    
    }
    
    public function project_boq_exceptional_items() 
		{
		$exceptional_id = $this->input->post('exceptional_id');
		if(isset($exceptional_id) && !empty($exceptional_id)){
            $exceptional_id = base64_decode($exceptional_id);
        }else{
            $exceptional_id = 0;
        }
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$data = array();
		$memData = $this->admin_model->getSendBOQExceptItemListRows($_POST,$exceptional_id);
		$allCount = $this->admin_model->countSendBOQExceptItemListAll($exceptional_id);
		$countFiltered = $this->admin_model->countSendBOQExceptItemListFiltered($_POST,$exceptional_id);
		$i = $_POST['start'];
    
		foreach($memData as $member){
            $i++;
            if(isset($member->id) && !empty($member->id)) { $id = $member->id; }else { $id = '-'; }
            if(isset($member->EA_qty) && !empty($member->EA_qty)) { $EA_qty = $member->EA_qty; }else { $EA_qty = '0'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description =$member->item_description; }else { $item_description = '-'; }
            if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
            if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '0'; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = 0; }
            if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = '0'; }

            $oprableAmount = 0;
			$oprableAmount =abs($EA_qty * $rate_basic);
            $gst_amount=0;
			if($oprableAmount > 0 && $gst > 0){
			$gst_amount =  $oprableAmount * ($gst/100);   
			}
			$oprableAmountGST=0;
			$oprableAmountGST = $gst_amount + $oprableAmount;
            $data[] = array(
                $i,
    		    $boq_code,
    			$item_description,
                $unit,
                $EA_qty,
                sprintf('%0.2f', $rate_basic),
                // sprintf('%0.2f', $oprableAmount),
                sprintf('%0.2f', $gst),
                sprintf('%0.2f', $gst_amount),
                sprintf('%0.2f', $oprableAmountGST)

    		);	
		}
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }

 public function get_consignee_list(){
    $project_id = $this->input->post('project_id');
    echo '<label class="">Consignee <span class="require" aria-required="true" style="color:#a94442">*</span></label>';
    echo '<select class="form-control select2me" name="consignee" style="padding-left:0px !important;" id="consignee" required>';
    echo '<option vaue="">--Select--</option>';
    if(isset($project_id) && !empty($project_id)){
        $consignee_list = $this->admin_model->get_consignee_list($project_id);
        if(isset($consignee_list) && !empty($consignee_list)){
            foreach($consignee_list as $key){
                if(isset($key['consignee_name']) && !empty($key['consignee_name'])){
                echo '<option value="'.$key['id'].'">'.$key['consignee_name'].'</option>';
                }
            }
        }
    }
    echo '</select>';
 }
 public function get_consignee_detail(){
    $c_id = $this->input->post('consignee_id');
    $res = array();
    $detail = $this->admin_model->get_consinee_details($c_id);
    if($detail){
        $res['gst_number'] = $detail->gst_number;
        $res['delivery_address'] = $detail->delivery_address;
        echo json_encode($res);
    }
 }
 public function getFinalContractamount($filter,$transaction_id,$transaction_type,$project_id,$status_txt){
    if(isset($project_id) && !empty($project_id)){
        $project_id = $project_id;
    }else{
        $project_id = 0;
    }
    if(isset($status_txt) && !empty($status_txt)){
        $status_txt = $status_txt;
    }else{
        $status_txt = '';
    }
    $res = array();
    if(isset($filter) && !empty($filter) && isset($transaction_id) && !empty($transaction_id) 
    && isset($transaction_type) && !empty($transaction_type) && isset($project_id) && !empty($project_id)){
    $detail = $this->admin_model->get_boq_item_amount($filter,$transaction_id,$transaction_type,$project_id,$status_txt);
    if($detail){
        if(isset($detail['total_dc_withgst_amt']) && !empty($detail['total_dc_withgst_amt']) && $detail['total_dc_withgst_amt'] > 0){
            $res['totalDcAmountGST'] = $detail['total_dc_withgst_amt'];    
        }else{
            $res['totalDcAmountGST'] = 0;    
        }
        if(isset($detail['total_udsgn_qty']) && !empty($detail['total_udsgn_qty']) && $detail['total_udsgn_qty'] > 0){
            $res['totalUdsgnQty'] = $detail['total_udsgn_qty'];    
        }else{
            $res['totalUdsgnQty'] = 0;    
        }
        if(isset($detail['total_udsgn_amt']) && !empty($detail['total_udsgn_amt']) && $detail['total_udsgn_amt'] > 0){
            $res['totalUdsgnAmount'] = $detail['total_udsgn_amt'];    
        }else{
            $res['totalUdsgnAmount'] = 0;    
        }
        if(isset($detail['total_udsgn_amt_gst']) && !empty($detail['total_udsgn_amt_gst']) && $detail['total_udsgn_amt_gst'] > 0){
            $res['totalUdsgnAmountGST'] = $detail['total_udsgn_amt_gst'];    
        }else{
            $res['totalUdsgnAmountGST'] = 0;    
        }
        if(isset($detail['total_udsgn_withgst_amt']) && !empty($detail['total_udsgn_withgst_amt']) && $detail['total_udsgn_withgst_amt'] > 0){
            $res['totalUdsgnGSTAmount'] = $detail['total_udsgn_withgst_amt'];    
        }else{
            $res['totalUdsgnGSTAmount'] = 0;    
        }
        if(isset($detail['total_sch_qty']) && !empty($detail['total_sch_qty']) && $detail['total_sch_qty'] > 0){
            $res['totalOriQty'] = $detail['total_sch_qty'];    
        }else{
            $res['totalOriQty'] = 0;    
        }
        if(isset($detail['total_basic_rate']) && !empty($detail['total_basic_rate']) && $detail['total_basic_rate'] > 0){
            $res['totalBasicRate'] = sprintf('%0.2f', $detail['total_basic_rate']);    
        }else{
            $res['totalBasicRate'] = 0;    
        }
        if(isset($detail['total_sch_amount']) && !empty($detail['total_sch_amount']) && $detail['total_sch_amount'] > 0){
            $res['totalOriAmount'] = sprintf('%0.2f', $detail['total_sch_amount']);    
        }else{
            $res['totalOriAmount'] = 0;    
        }
        if(isset($detail['total_gst_rate']) && !empty($detail['total_gst_rate']) && $detail['total_gst_rate'] > 0){
            $res['totalOriGstRate'] = sprintf('%0.2f', $detail['total_gst_rate']);    
        }else{
            $res['totalOriGstRate'] = 0;    
        }
        if(isset($detail['total_sch_gst_amount']) && !empty($detail['total_sch_gst_amount']) && $detail['total_sch_gst_amount'] > 0){
            $res['totalOriGstAmount'] = sprintf('%0.2f', $detail['total_sch_gst_amount']);    
        }else{
            $res['totalOriGstAmount'] = 0;    
        }
        if(isset($detail['total_sch_amount_with_gst']) && !empty($detail['total_sch_amount_with_gst']) && $detail['total_sch_amount_with_gst'] > 0){
            $res['totalOriAmountGST'] = sprintf('%0.2f', $detail['total_sch_amount_with_gst']);    
        }else{
            $res['totalOriAmountGST'] = 0;    
        }
        if(isset($detail['total_dsgnqty']) && !empty($detail['total_dsgnqty']) && $detail['total_dsgnqty'] > 0){
            $res['totalDesignQty'] = $detail['total_dsgnqty'];    
        }else{
            $res['totalDesignQty'] = 0;    
        }
        if(isset($detail['total_odsgnqty']) && !empty($detail['total_odsgnqty']) && $detail['total_odsgnqty'] > 0){
            $res['totalODesignQty'] = $detail['total_odsgnqty'];    
        }else{
            $res['totalODesignQty'] = 0;    
        }
        // pr($res);
        if($transaction_type == 'boq_upload'  || $transaction_type == 'add_edit_boq'){
            $detailPosVariation = $this->admin_model->get_boq_item_variation_data('pos_variation',$transaction_id,$transaction_type,$project_id,$status_txt);
            if(isset($detailPosVariation['qty']) && !empty($detailPosVariation['qty']) && $detailPosVariation['qty'] > 0){
                $res['totalPosQty'] = $detailPosVariation['qty'];    
            }else{
                $res['totalPosQty'] = 0;    
            }
            if(isset($detailPosVariation['amount']) && !empty($detailPosVariation['amount']) && $detailPosVariation['amount'] > 0){
                $res['totalEaAmount'] = sprintf('%0.2f', $detailPosVariation['amount']);    
            }else{
                $res['totalEaAmount'] = 0;    
            }
            if(isset($detailPosVariation['amount_gst']) && !empty($detailPosVariation['amount_gst']) && $detailPosVariation['amount_gst'] > 0){
                $res['totalEaAmountGST'] = sprintf('%0.2f', $detailPosVariation['amount_gst']);    
            }else{
                $res['totalEaAmountGST'] = 0;    
            }
            $res['totalEaGSTAmount'] = 0;    
        }elseif($transaction_type == 'boq_exceptional_appr'){
            if(isset($detail['total_EA_qty']) && !empty($detail['total_EA_qty'])){
                $res['totalPosQty'] = $detail['total_EA_qty'];    
            }else{
                $res['totalPosQty'] = 0;    
            }
            if(isset($detail['total_ea_amount']) && !empty($detail['total_ea_amount'])){
                $res['totalEaAmount'] = sprintf('%0.2f', $detail['total_ea_amount']);    
            }else{
                $res['totalEaAmount'] = 0;    
            }
            if(isset($detail['total_ea_gst_amount']) && !empty($detail['total_ea_gst_amount'])){
                $res['totalEaGSTAmount'] = sprintf('%0.2f', $detail['total_ea_gst_amount']);    
            }else{
                $res['totalEaGSTAmount'] = 0;    
            }
            if(isset($detail['total_ea_amount_with_gst']) && !empty($detail['total_ea_amount_with_gst'])){
                $res['totalEaAmountGST'] = sprintf('%0.2f', $detail['total_ea_amount_with_gst']);    
            }else{
                $res['totalEaAmountGST'] = 0;    
            }
        }
        $detailNegVariation = $this->admin_model->get_boq_item_variation_data('neg_variation',$transaction_id,$transaction_type,$project_id,$status_txt);
        if(isset($detailNegVariation['qty']) && !empty($detailNegVariation['qty']) && $detailNegVariation['qty'] > 0){
            $res['totalNegQty'] = $detailNegVariation['qty'];    
        }else{
            $res['totalNegQty'] = 0;    
        }
        if(isset($detailNegVariation['amount']) && !empty($detailNegVariation['amount']) && $detailNegVariation['amount'] > 0){
            $res['totalNegAmount'] = sprintf('%0.2f', $detailNegVariation['amount']);    
        }else{
            $res['totalNegAmount'] = 0;    
        }
        if(isset($detailNegVariation['amount_gst']) && !empty($detailNegVariation['amount_gst']) && $detailNegVariation['amount_gst'] > 0){
            $res['totalNegAmountGST'] = sprintf('%0.2f', $detailNegVariation['amount_gst']);    
        }else{
            $res['totalNegAmountGST'] = 0;    
        }
        if(isset($detail['total_dsgn_amount']) && !empty($detail['total_dsgn_amount']) && $detail['total_dsgn_amount'] > 0){
            $res['totalDsgnAmount'] = sprintf('%0.2f', $detail['total_dsgn_amount']);    
        }else{
            $res['totalDsgnAmount'] = 0;    
        }
        if(isset($detail['total_dsgn_amount_with_gst']) && !empty($detail['total_dsgn_amount_with_gst']) && $detail['total_dsgn_amount_with_gst'] > 0){
            $res['totalDsgnAmountGST'] = sprintf('%0.2f', $detail['total_dsgn_amount_with_gst']);    
        }else{
            $res['totalDsgnAmountGST'] = 0;    
        }
        if(isset($detail['total_non_sch_amount']) && !empty($detail['total_non_sch_amount']) && $detail['total_non_sch_amount'] > 0){
            $res['totalNSAmount'] = sprintf('%0.2f', $detail['total_non_sch_amount']);    
        }else{
            $res['totalNSAmount'] = 0;    
        }
        if(isset($detail['total_non_sch_gst_amount']) && !empty($detail['total_non_sch_gst_amount']) && $detail['total_non_sch_gst_amount'] > 0){
            $res['totalNSAmountGST'] = sprintf('%0.2f', $detail['total_non_sch_gst_amount']);    
        }else{
            $res['totalNSAmountGST'] = 0;    
        }
        if(isset($detail['total_dsgn_gst_amount']) && !empty($detail['total_dsgn_gst_amount']) && $detail['total_dsgn_gst_amount'] > 0){
            $res['totalDsgnGSTAmount'] = sprintf('%0.2f', $detail['total_dsgn_gst_amount']);    
        }else{
            $res['totalDsgnGSTAmount'] = 0;    
        }
        
    }
    }
    return $res;
 }
 public function get_boq_item_amount(){
    $filter = $this->input->post('filter');
    $transaction_id = $this->input->post('transaction_id');
    $transaction_type = $this->input->post('transaction_type');
    $project_id = $this->input->post('project_id');
    if(isset($project_id) && !empty($project_id)){
        $project_id = base64_decode($project_id);
    }else{
        $project_id = 0;
    }
    $status_txt = $this->input->post('status_txt');
    if(isset($status_txt) && !empty($status_txt)){
        $status_txt = $status_txt;
    }else{
        $status_txt = '';
    }
    $res = array();
    if(isset($filter) && !empty($filter) && isset($transaction_id) && !empty($transaction_id) 
    && isset($transaction_type) && !empty($transaction_type) && isset($project_id) && !empty($project_id)){
    $detail = $this->admin_model->get_boq_item_amount($filter,$transaction_id,$transaction_type,$project_id,$status_txt);
    
    if($detail){
        if(isset($detail['total_udsgn_qty']) && !empty($detail['total_udsgn_qty']) && $detail['total_udsgn_qty'] > 0){
            $res['totalUdsgnQty'] = $detail['total_udsgn_qty'];    
        }else{
            $res['totalUdsgnQty'] = 0;    
        }
        if(isset($detail['total_udsgn_amt']) && !empty($detail['total_udsgn_amt']) && $detail['total_udsgn_amt'] > 0){
            $res['totalUdsgnAmount'] = $detail['total_udsgn_amt'];    
        }else{
            $res['totalUdsgnAmount'] = 0;    
        }
        if(isset($detail['total_udsgn_amt_gst']) && !empty($detail['total_udsgn_amt_gst']) && $detail['total_udsgn_amt_gst'] > 0){
            $res['totalUdsgnAmountGST'] = $detail['total_udsgn_amt_gst'];    
        }else{
            $res['totalUdsgnAmountGST'] = 0;    
        }
        if(isset($detail['total_udsgn_withgst_amt']) && !empty($detail['total_udsgn_withgst_amt']) && $detail['total_udsgn_withgst_amt'] > 0){
            $res['totalUdsgnGSTAmount'] = $detail['total_udsgn_withgst_amt'];    
        }else{
            $res['totalUdsgnGSTAmount'] = 0;    
        }
        if(isset($detail['total_sch_qty']) && !empty($detail['total_sch_qty']) && $detail['total_sch_qty'] > 0){
            $res['totalOriQty'] = $detail['total_sch_qty'];    
        }else{
            $res['totalOriQty'] = 0;    
        }
        if(isset($detail['total_basic_rate']) && !empty($detail['total_basic_rate']) && $detail['total_basic_rate'] > 0){
            $res['totalBasicRate'] = sprintf('%0.2f', $detail['total_basic_rate']);    
        }else{
            $res['totalBasicRate'] = 0;    
        }
        if(isset($detail['total_sch_amount']) && !empty($detail['total_sch_amount']) && $detail['total_sch_amount'] > 0){
            $res['totalOriAmount'] = sprintf('%0.2f', $detail['total_sch_amount']);    
        }else{
            $res['totalOriAmount'] = 0;    
        }
        if(isset($detail['total_gst_rate']) && !empty($detail['total_gst_rate']) && $detail['total_gst_rate'] > 0){
            $res['totalOriGstRate'] = sprintf('%0.2f', $detail['total_gst_rate']);    
        }else{
            $res['totalOriGstRate'] = 0;    
        }
        if(isset($detail['total_sch_gst_amount']) && !empty($detail['total_sch_gst_amount']) && $detail['total_sch_gst_amount'] > 0){
            $res['totalOriGstAmount'] = sprintf('%0.2f', $detail['total_sch_gst_amount']);    
        }else{
            $res['totalOriGstAmount'] = 0;    
        }
        if(isset($detail['total_sch_amount_with_gst']) && !empty($detail['total_sch_amount_with_gst']) && $detail['total_sch_amount_with_gst'] > 0){
            $res['totalOriAmountGST'] = sprintf('%0.2f', $detail['total_sch_amount_with_gst']);    
        }else{
            $res['totalOriAmountGST'] = 0;    
        }
        if(isset($detail['total_dsgnqty']) && !empty($detail['total_dsgnqty']) && $detail['total_dsgnqty'] > 0){
            $res['totalDesignQty'] = $detail['total_dsgnqty'];    
        }else{
            $res['totalDesignQty'] = 0;    
        }
        if(isset($detail['total_odsgnqty']) && !empty($detail['total_odsgnqty']) && $detail['total_odsgnqty'] > 0){
            $res['totalODesignQty'] = $detail['total_odsgnqty'];    
        }else{
            $res['totalODesignQty'] = 0;    
        }
        if($transaction_type == 'boq_upload'  || $transaction_type == 'add_edit_boq'){
            $detailPosVariation = $this->admin_model->get_boq_item_variation_data('pos_variation',$transaction_id,$transaction_type,$project_id,$status_txt);
            if(isset($detailPosVariation['qty']) && !empty($detailPosVariation['qty']) && $detailPosVariation['qty'] > 0){
                $res['totalPosQty'] = $detailPosVariation['qty'];    
            }else{
                $res['totalPosQty'] = 0;    
            }
            if(isset($detailPosVariation['amount']) && !empty($detailPosVariation['amount']) && $detailPosVariation['amount'] > 0){
                $res['totalEaAmount'] = sprintf('%0.2f', $detailPosVariation['amount']);    
            }else{
                $res['totalEaAmount'] = 0;    
            }
            if(isset($detailPosVariation['amount_gst']) && !empty($detailPosVariation['amount_gst']) && $detailPosVariation['amount_gst'] > 0){
                $res['totalEaAmountGST'] = sprintf('%0.2f', $detailPosVariation['amount_gst']);    
            }else{
                $res['totalEaAmountGST'] = 0;    
            }
            $res['totalEaGSTAmount'] = 0;    
        }elseif($transaction_type == 'boq_exceptional_appr'){
            if(isset($detail['total_EA_qty']) && !empty($detail['total_EA_qty'])){
                $res['totalPosQty'] = $detail['total_EA_qty'];    
            }else{
                $res['totalPosQty'] = 0;    
            }
            if(isset($detail['total_ea_amount']) && !empty($detail['total_ea_amount'])){
                $res['totalEaAmount'] = sprintf('%0.2f', $detail['total_ea_amount']);    
            }else{
                $res['totalEaAmount'] = 0;    
            }
            if(isset($detail['total_ea_gst_amount']) && !empty($detail['total_ea_gst_amount'])){
                $res['totalEaGSTAmount'] = sprintf('%0.2f', $detail['total_ea_gst_amount']);    
            }else{
                $res['totalEaGSTAmount'] = 0;    
            }
            if(isset($detail['total_ea_amount_with_gst']) && !empty($detail['total_ea_amount_with_gst'])){
                $res['totalEaAmountGST'] = sprintf('%0.2f', $detail['total_ea_amount_with_gst']);    
            }else{
                $res['totalEaAmountGST'] = 0;    
            }
        }
        $detailNegVariation = $this->admin_model->get_boq_item_variation_data('neg_variation',$transaction_id,$transaction_type,$project_id,$status_txt);
        if(isset($detailNegVariation['qty']) && !empty($detailNegVariation['qty']) && $detailNegVariation['qty'] > 0){
            $res['totalNegQty'] = $detailNegVariation['qty'];    
        }else{
            $res['totalNegQty'] = 0;    
        }
        if(isset($detailNegVariation['amount']) && !empty($detailNegVariation['amount']) && $detailNegVariation['amount'] > 0){
            $res['totalNegAmount'] = sprintf('%0.2f', $detailNegVariation['amount']);    
        }else{
            $res['totalNegAmount'] = 0;    
        }
        if(isset($detailNegVariation['amount_gst']) && !empty($detailNegVariation['amount_gst']) && $detailNegVariation['amount_gst'] > 0){
            $res['totalNegAmountGST'] = sprintf('%0.2f', $detailNegVariation['amount_gst']);    
        }else{
            $res['totalNegAmountGST'] = 0;    
        }
        if(isset($detail['total_dsgn_amount']) && !empty($detail['total_dsgn_amount']) && $detail['total_dsgn_amount'] > 0){
            $res['totalDsgnAmount'] = sprintf('%0.2f', $detail['total_dsgn_amount']);    
        }else{
            $res['totalDsgnAmount'] = 0;    
        }
        if(isset($detail['total_dsgn_amount_with_gst']) && !empty($detail['total_dsgn_amount_with_gst']) && $detail['total_dsgn_amount_with_gst'] > 0){
            $res['totalDsgnAmountGST'] = sprintf('%0.2f', $detail['total_dsgn_amount_with_gst']);    
        }else{
            $res['totalDsgnAmountGST'] = 0;    
        }
        if(isset($detail['total_non_sch_amount']) && !empty($detail['total_non_sch_amount']) && $detail['total_non_sch_amount'] > 0){
            $res['totalNSAmount'] = sprintf('%0.2f', $detail['total_non_sch_amount']);    
        }else{
            $res['totalNSAmount'] = 0;    
        }
        if(isset($detail['total_non_sch_gst_amount']) && !empty($detail['total_non_sch_gst_amount']) && $detail['total_non_sch_gst_amount'] > 0){
            $res['totalNSAmountGST'] = sprintf('%0.2f', $detail['total_non_sch_gst_amount']);    
        }else{
            $res['totalNSAmountGST'] = 0;    
        }
        if(isset($detail['total_dsgn_gst_amount']) && !empty($detail['total_dsgn_gst_amount']) && $detail['total_dsgn_gst_amount'] > 0){
            $res['totalDsgnGSTAmount'] = sprintf('%0.2f', $detail['total_dsgn_gst_amount']);    
        }else{
            $res['totalDsgnGSTAmount'] = 0;    
        }
        
    }
    }
    echo json_encode($res);
 }
 

    
	public function get_approved_boq_item_details() 
		{
		$res = array();
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)
		&& isset($project_id) && !empty($project_id)
		&& isset($boq_code) && !empty($boq_code)){
		$member = $this->admin_model->get_approved_boq_item_details($project_id,$boq_code);
		if(isset($member) && !empty($member)){
		    if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $res['boq_items_id'] = $member->boq_items_id; }else { $res['boq_items_id'] = '0'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $res['project_id'] = $member->project_id; }else { $res['project_id'] = '0'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $res['boq_code'] = $member->boq_code; }else { $res['boq_code'] = ''; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $res['hsn_sac_code'] = $member->hsn_sac_code; }else { $res['hsn_sac_code'] = ''; }
			if(isset($member->item_description) && !empty($member->item_description)) { $res['item_description'] = $member->item_description; }else { $res['item_description'] = ''; }
			if(isset($member->unit) && !empty($member->unit)) { $res['unit'] = $member->unit; }else { $res['unit'] = ''; }
			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $res['scheduled_qty'] = $member->scheduled_qty; }else { $res['scheduled_qty'] = ''; }
			if(isset($member->design_qty) && !empty($member->design_qty)) { $res['design_qty'] = $member->design_qty; }else { $res['design_qty'] = '0'; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $res['rate_basic'] = $member->rate_basic; }else { $res['rate_basic'] = '0'; }
			if(isset($member->gst) && !empty($member->gst)) { $res['gst'] = $member->gst; }else { $res['gst'] = '0'; }
			if(isset($member->non_schedule) && !empty($member->non_schedule)) { $res['non_schedule'] = $member->non_schedule; }else { $res['non_schedule'] = 'N'; }
		}
		}
		echo json_encode($res);
	}
	public function get_boq_item_details() 
		{
		$res = array();
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)
		&& isset($project_id) && !empty($project_id)
		&& isset($boq_code) && !empty($boq_code)){
		$member = $this->admin_model->get_boq_item_details($project_id,$boq_code);
		$project_detail = $this->admin_model->get_project_item_details($project_id);
        
		if(isset($member) && !empty($member)){
		    if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $res['boq_items_id'] = $member->boq_items_id; }else { $res['boq_items_id'] = '0'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $res['project_id'] = $member->project_id; }else { $res['project_id'] = '0'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $res['boq_code'] = $member->boq_code; }else { $res['boq_code'] = ''; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $res['hsn_sac_code'] = $member->hsn_sac_code; }else { $res['hsn_sac_code'] = ''; }
			if(isset($member->item_description) && !empty($member->item_description)) { $res['item_description'] = $member->item_description; }else { $res['item_description'] = ''; }
			if(isset($member->unit) && !empty($member->unit)) { $res['unit'] = $member->unit; }else { $res['unit'] = ''; }
			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $res['scheduled_qty'] = $member->scheduled_qty; }else { $res['scheduled_qty'] = ''; }
			if(isset($member->design_qty) && !empty($member->design_qty)) { $res['design_qty'] = $member->design_qty; }else { $res['design_qty'] = '0'; }
            if(isset($member->o_design_qty) && !empty($member->o_design_qty)) { $res['o_design_qty'] = $member->o_design_qty; }else { $res['o_design_qty'] = '0'; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $res['rate_basic'] = $member->rate_basic; }else { $res['rate_basic'] = '0'; }
			if(isset($member->gst) && !empty($member->gst)) { $res['gst'] = $member->gst; }else { $res['gst'] = '0'; }
			if(isset($member->non_schedule) && !empty($member->non_schedule)) { $res['non_schedule'] = $member->non_schedule; }else { $res['non_schedule'] = 'N'; }
			if(isset($member->status) && !empty($member->status)) { $res['boq_status'] = $member->status; }else { $res['boq_status'] = 'N'; }
		}
		}
		echo json_encode($res);
	}
	public function get_boq_exceptional_item() 
		{
		$res = array();
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)
		&& isset($project_id) && !empty($project_id)
		&& isset($boq_code) && !empty($boq_code)){
		$member = $this->admin_model->get_boq_exceptional_item($project_id,$boq_code);
		if(isset($member) && !empty($member)){
		    if(isset($member->id) && !empty($member->id)) { $res['id'] = $member->id; }else { $res['id'] = '0'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $res['project_id'] = $member->project_id; }else { $res['project_id'] = '0'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $res['boq_code'] = $member->boq_code; }else { $res['boq_code'] = ''; }
			if(isset($member->item_description) && !empty($member->item_description)) { $res['item_description'] = $member->item_description; }else { $res['item_description'] = ''; }
			if(isset($member->EA_qty) && !empty($member->EA_qty)) { $res['ea_qty'] = $member->EA_qty; }else { $res['ea_qty'] = '0'; }
		}
		}
		echo json_encode($res);
	}
	
	public function get_dcip_boq_item_details() 
		{
		$res = array();
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)
		&& isset($project_id) && !empty($project_id)
		&& isset($boq_code) && !empty($boq_code)){
		$member = $this->admin_model->get_dcip_boq_item_details($project_id,$boq_code);
		if(isset($member) && !empty($member)){
		    if(isset($member->challan_itemid) && !empty($member->challan_itemid)) { $res['challan_itemid'] = $member->challan_itemid; }else { $res['challan_itemid'] = '0'; }
			if(isset($member->challan_id) && !empty($member->challan_id)) { $res['challan_id'] = $member->challan_id; }else { $res['challan_id'] = '0'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $res['boq_code'] = $member->boq_code; }else { $res['boq_code'] = ''; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $res['hsn_sac_code'] = $member->hsn_sac_code; }else { $res['hsn_sac_code'] = ''; }
			if(isset($member->item_description) && !empty($member->item_description)) { $res['item_description'] = $member->item_description; }else { $res['item_description'] = ''; }
			if(isset($member->unit) && !empty($member->unit)) { $res['unit'] = $member->unit; }else { $res['unit'] = ''; }
			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $res['scheduled_qty'] = $member->scheduled_qty; }else { $res['scheduled_qty'] = ''; }
			if(isset($member->design_qty) && !empty($member->design_qty)) { $res['design_qty'] = $member->design_qty; }else { $res['design_qty'] = '0'; }
			if(isset($member->received_qty) && !empty($member->received_qty)) { $res['received_qty'] = $member->received_qty; }else { $res['received_qty'] = '0'; }
		 }
		}
		echo json_encode($res);
	}
	public function get_dc_boq_item_details() 
		{
		$res = array();
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)
		&& isset($project_id) && !empty($project_id)
		&& isset($boq_code) && !empty($boq_code)){
		$member = $this->admin_model->get_dc_boq_item_details($project_id,$boq_code);
                  
		if(isset($member) && !empty($member)){
		    if(isset($member->challan_itemid) && !empty($member->challan_itemid)) { $res['challan_itemid'] = $member->challan_itemid; }else { $res['challan_itemid'] = '0'; }
			if(isset($member->challan_id) && !empty($member->challan_id)) { $res['challan_id'] = $member->challan_id; }else { $res['challan_id'] = '0'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $res['boq_code'] = $member->boq_code; }else { $res['boq_code'] = ''; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $res['hsn_sac_code'] = $member->hsn_sac_code; }else { $res['hsn_sac_code'] = ''; }
			if(isset($member->item_description) && !empty($member->item_description)) { $res['item_description'] = $member->item_description; }else { $res['item_description'] = ''; }
			if(isset($member->unit) && !empty($member->unit)) { $res['unit'] = $member->unit; }else { $res['unit'] = ''; }
			if(isset($member->qty) && !empty($member->qty)) { $res['qty'] = $member->qty; }else { $res['qty'] = ''; }
			if(isset($member->status) && !empty($member->status)) { $res['boq_status'] = $member->status; }else { $res['boq_status'] = 'pending'; }
		}
		}
		echo json_encode($res);
	}
	public function get_wip_boq_item() 
		{
		$res = array();
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $wip_type = $this->input->post('wip_type');
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)
		&& isset($project_id) && !empty($project_id)
		&& isset($boq_code) && !empty($boq_code)){
		$member = $this->admin_model->get_wip_boq_item($project_id,$boq_code,$wip_type);
        if(isset($member) && !empty($member)){
		    if(isset($member->boq_code) && !empty($member->boq_code)) { $res['boq_code'] = $member->boq_code; }else { $res['boq_code'] = ''; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $res['hsn_sac_code'] = $member->hsn_sac_code; }else { $res['hsn_sac_code'] = ''; }
			if(isset($member->item_description) && !empty($member->item_description)) { $res['item_description'] = $member->item_description; }else { $res['item_description'] = ''; }
			if(isset($member->unit) && !empty($member->unit)) { $res['unit'] = $member->unit; }else { $res['unit'] = ''; }
			if(isset($member->status) && !empty($member->status)) { $res['boq_status'] = $member->status; }else { $res['boq_status'] = 'pending'; }
		}
		}
		echo json_encode($res);
	}
	public function get_wip_boq_item_details() 
		{
		$res = array();
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)
		&& isset($project_id) && !empty($project_id)
		&& isset($boq_code) && !empty($boq_code)){
		$member = $this->admin_model->get_wip_boq_item_details($project_id,$boq_code);
		if(isset($member) && !empty($member)){
		    if(isset($member->challan_itemid) && !empty($member->challan_itemid)) { $res['challan_itemid'] = $member->challan_itemid; }else { $res['challan_itemid'] = '0'; }
			if(isset($member->challan_id) && !empty($member->challan_id)) { $res['challan_id'] = $member->challan_id; }else { $res['challan_id'] = '0'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $res['boq_code'] = $member->boq_code; }else { $res['boq_code'] = ''; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $res['hsn_sac_code'] = $member->hsn_sac_code; }else { $res['hsn_sac_code'] = ''; }
			if(isset($member->item_description) && !empty($member->item_description)) { $res['item_description'] = $member->item_description; }else { $res['item_description'] = ''; }
			if(isset($member->unit) && !empty($member->unit)) { $res['unit'] = $member->unit; }else { $res['unit'] = ''; }
			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $res['scheduled_qty'] = $member->scheduled_qty; }else { $res['scheduled_qty'] = ''; }
			if(isset($member->design_qty) && !empty($member->design_qty)) { $res['design_qty'] = $member->design_qty; }else { $res['design_qty'] = '0'; }
			if(isset($member->received_qty) && !empty($member->received_qty)) { $res['received_qty'] = $member->received_qty; }else { $res['received_qty'] = '0'; }
		 }
		}
		echo json_encode($res);
	}
	public function get_proforma_boq_item_details() 
		{
		$res = array();
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)
		&& isset($project_id) && !empty($project_id)
		&& isset($boq_code) && !empty($boq_code)){
		$member = $this->admin_model->get_proforma_boq_item_details($project_id,$boq_code);
// 		 pr($member,1);
		if(isset($member) && !empty($member)){
		    if(isset($member->proforma_itemid) && !empty($member->proforma_itemid)) { $res['challan_itemid'] = $member->proforma_itemid; }else { $res['challan_itemid'] = '0'; }
			if(isset($member->proforma_id) && !empty($member->proforma_id)) { $res['challan_id'] = $member->proforma_id; }else { $res['challan_id'] = '0'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $res['boq_code'] = $member->boq_code; }else { $res['boq_code'] = ''; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $res['hsn_sac_code'] = $member->hsn_sac_code; }else { $res['hsn_sac_code'] = ''; }
			if(isset($member->item_description) && !empty($member->item_description)) { $res['item_description'] = $member->item_description; }else { $res['item_description'] = ''; }
			if(isset($member->unit) && !empty($member->unit)) { $res['unit'] = $member->unit; }else { $res['unit'] = ''; }
			if(isset($member->qty) && !empty($member->qty)) { $res['qty'] = $member->qty; }else { $res['qty'] = ''; }
			if(isset($member->rate) && !empty($member->rate)) { $res['rate'] = $member->rate; }else { $res['rate'] = '0'; }
			if(isset($member->rate) && !empty($member->rate)) { $res['amount'] = $member->qty * $member->rate; }else { $res['amount'] = '0'; }
		    if(isset($member->status) && !empty($member->status)) { $res['boq_status'] = $member->status; }else { $res['boq_status'] = 'pending'; }
		}
		}
		echo json_encode($res);
	}
	public function get_tax_boq_item_details() 
		{
		$res = array();
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)
		&& isset($project_id) && !empty($project_id)
		&& isset($boq_code) && !empty($boq_code)){
		$member = $this->admin_model->get_tax_boq_item_details($project_id,$boq_code);
		if(isset($member) && !empty($member)){
		    if(isset($member->proforma_itemid) && !empty($member->proforma_itemid)) { $res['challan_itemid'] = $member->proforma_itemid; }else { $res['challan_itemid'] = '0'; }
			if(isset($member->proforma_id) && !empty($member->proforma_id)) { $res['challan_id'] = $member->proforma_id; }else { $res['challan_id'] = '0'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $res['boq_code'] = $member->boq_code; }else { $res['boq_code'] = ''; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $res['hsn_sac_code'] = $member->hsn_sac_code; }else { $res['hsn_sac_code'] = ''; }
			if(isset($member->item_description) && !empty($member->item_description)) { $res['item_description'] = $member->item_description; }else { $res['item_description'] = ''; }
			if(isset($member->unit) && !empty($member->unit)) { $res['unit'] = $member->unit; }else { $res['unit'] = ''; }
			if(isset($member->qty) && !empty($member->qty)) { $res['qty'] = $member->qty; }else { $res['qty'] = ''; }
			if(isset($member->rate) && !empty($member->rate)) { $res['rate'] = $member->rate; }else { $res['rate'] = '0'; }
			if(isset($member->rate) && !empty($member->rate)) { $res['amount'] = $member->qty * $member->rate; }else { $res['amount'] = '0'; }
		    if(isset($member->status) && !empty($member->status)) { $res['boq_status'] = $member->status; }else { $res['boq_status'] = 'pending'; }
		}
		}
		echo json_encode($res);
	}
	
    

    public function project_taxinvc_payment_receipts() 
	{
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$tax_invc_id = $this->input->post('tax_invc_id');
        if(isset($tax_invc_id) && !empty($tax_invc_id)){
            $tax_invc_id = base64_decode($tax_invc_id);
        }else{
            $tax_invc_id = 0;
        }
		$data = $row = array();
		$memData = $this->admin_model->getTaxInvcPRCListRows($_POST,$tax_invc_id);
		$allCount = $this->admin_model->countTaxInvcPRCListAll($tax_invc_id);
		$countFiltered = $this->admin_model->countTaxInvcPRCListFiltered($_POST,$tax_invc_id);
        $i = $_POST['start'];
        foreach($memData as $member){
            $i++;
            if(isset($member->id) && !empty($member->id)) { $id = $member->id; }else { $id = '-'; }
			if(isset($member->payment_receipt_no) && !empty($member->payment_receipt_no)) { $payment_receipt_no = $member->payment_receipt_no; }else { $payment_receipt_no = '-'; }
			if(isset($member->tax_incv_id) && !empty($member->tax_incv_id)) { $tax_incv_id = $member->tax_incv_id; }else { $tax_incv_id = '-'; }
			if(isset($member->payment_date) && !empty($member->payment_date)) { $payment_date = date('d-m-Y',strtotime($member->payment_date)); }else { $payment_date = '-'; }
			if(isset($member->bank_acc_no) && !empty($member->bank_acc_no)) { $bank_acc_no = $member->bank_acc_no; }else { $bank_acc_no = '0'; }
			if(isset($member->payment_received_amount) && !empty($member->payment_received_amount)) { $payment_received_amount = $member->payment_received_amount; }else { $payment_received_amount = 0; }
			if(isset($member->client_name) && !empty($member->client_name)) { $client_name = $member->client_name; }else { $client_name = '-'; }
			if(isset($member->remark) && !empty($member->remark)) { $remark = $member->remark; }else { $remark = '-'; }
			if(isset($member->created_date) && !empty($member->created_date)) { $created_date = $member->created_date; }else { $created_date = '-'; }
			if(isset($member->created_by_name) && !empty($member->created_by_name)) { $created_by_name = $member->created_by_name; }else { $created_by_name = '-'; }
			if(strlen($payment_receipt_no) > 4){
			    $paymentreceiptno = $payment_receipt_no;
			}else{
			    $paymentreceiptno = sprintf('%04d',$payment_receipt_no);
			}
			$final_received_payment = 0;
            $received_payment = $this->admin_model->get_receipt_received_payment($id);
            if(isset($received_payment) && !empty($received_payment) && $received_payment > 0){
            $received_payment = $received_payment;
            }else{
            $received_payment = 0;
            }
            //Statutory Deductions
            $statutory_deductions = 0;
            $it_tds_amount = $this->admin_model->get_receipt_it_tds_amount($id);
            if(isset($it_tds_amount) && !empty($it_tds_amount) && $it_tds_amount > 0){
            $it_tds_amount = $it_tds_amount;
            }else{
            $it_tds_amount = 0;
            }
            $gtds_amount = $this->admin_model->get_receipt_gtds_amount($id);
            if(isset($gtds_amount) && !empty($gtds_amount) && $gtds_amount > 0){
            $gtds_amount = $gtds_amount;
            }else{
            $gtds_amount = 0;
            }
            $other_tax_deduction_amount = $this->admin_model->get_receipt_other_tax_deduction($id);
            if(isset($other_tax_deduction_amount) && !empty($other_tax_deduction_amount) && $other_tax_deduction_amount > 0){
            $other_tax_deduction_amount = $other_tax_deduction_amount;
            }else{
            $other_tax_deduction_amount = 0;
            }
            $statutory_deductions = $it_tds_amount + $gtds_amount + $other_tax_deduction_amount;
            
            //Refundables
            $security_deposit_retn_amount = $this->admin_model->get_receipt_security_deposit_retn_amount($id);
            if(isset($security_deposit_retn_amount) && !empty($security_deposit_retn_amount) && $security_deposit_retn_amount > 0){
            $security_deposit_retn_amount = $security_deposit_retn_amount;
            }else{
            $security_deposit_retn_amount = 0;
            }
            $other_deposit_amount = $this->admin_model->get_receipt_other_deposit($id);
            if(isset($other_deposit_amount) && !empty($other_deposit_amount) && $other_deposit_amount > 0){
            $other_deposit_amount = $other_deposit_amount;
            }else{
            $other_deposit_amount = 0;
            }
            $withheld_amount = $this->admin_model->get_receipt_withheld($id);
            if(isset($withheld_amount) && !empty($withheld_amount) && $withheld_amount > 0){
            $withheld_amount = $withheld_amount;
            }else{
            $withheld_amount = 0;
            }
            $refundables = $security_deposit_retn_amount + $other_deposit_amount + $withheld_amount;
            
            //Non-Refundables
            $labour_cess_amount = $this->admin_model->get_receipt_labour_cess($id);
            if(isset($labour_cess_amount) && !empty($labour_cess_amount) && $labour_cess_amount > 0){
            $labour_cess_amount = $labour_cess_amount;
            }else{
            $labour_cess_amount = 0;
            }
            $other_cess_amount = $this->admin_model->get_receipt_other_cess($id);
            if(isset($other_cess_amount) && !empty($other_cess_amount) && $other_cess_amount > 0){
            $other_cess_amount = $other_cess_amount;
            }else{
            $other_cess_amount = 0;
            }
            $other_deductions_amount = $this->admin_model->get_receipt_other_deductions($id);
            if(isset($other_deductions_amount) && !empty($other_deductions_amount) && $other_deductions_amount > 0){
            $other_deductions_amount = $other_deductions_amount;
            }else{
            $other_deductions_amount = 0;
            }
            $nonrefundables = $labour_cess_amount + $other_cess_amount + $other_deductions_amount;
            $final_received_payment = $received_payment + $nonrefundables + $statutory_deductions;
            
			$html='';
			$html .='<a href="'.base_url().'payment-receipt-details/'.base64_encode($id).'">#'.$paymentreceiptno.'</a>';
			
			$data[] = array(
			$i,
			$html,
			$client_name,
			$bank_acc_no,
			sprintf('%0.2f', $final_received_payment),
			$payment_date,
			$created_date,
			$created_by_name
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data
        );
        echo json_encode($output);
		}

    }
    public function project_taxinvc_items() 
		{
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$tax_invc_id = $this->input->post('tax_invc_id');
        if(isset($tax_invc_id) && !empty($tax_invc_id)){
            $tax_invc_id = base64_decode($tax_invc_id);
        }else{
            $tax_invc_id = 0;
        }
		$data = $row = array();
		$memData = $this->admin_model->getTaxInvcItemListRows($_POST,$tax_invc_id);
		$allCount = $this->admin_model->countTaxInvcItemListAll($tax_invc_id);
		$countFiltered = $this->admin_model->countTaxInvcItemListFiltered($_POST,$tax_invc_id);
        $i = $_POST['start'];
        $sub_total = 0;
        $total_amount = 0 ;
        $gst_amount = 0 ;
        // pr($memData);
		foreach($memData as $member){
            $i++;

            // if($member->gst_type == 'intra-state'){
            //     $total_amount += $member->taxable_amount + $member->sgst_amount + $member->cgst_amount;
            //     $gst_amount += $member->sgst_amount + $member->cgst_amount;
            //     $sub_total += $member->taxable_amount;
            //     $gst_type = "CGST_SGST";
                
            // }else{
            //     $total_amount += $member->taxable_amount + $member->gst_amount;
            //     $gst_amount += $member->gst_amount;
            //     $gst_type = "IGST";
            //     $sub_total += $member->taxable_amount;
  
            // }
           $member->gst_amount = ($member->taxable_amount * $member->gst) / 100;
            $new_sub_total += $member->taxable_amount;
            $new_gst_amount += $member->gst_amount;
            $new_total_amount += $member->taxable_amount + $member->gst_amount;
            
        
          
                
            if(isset($member->tax_invc_id) && !empty($member->tax_invc_id)) { $tax_invc_id = $member->tax_invc_id; }else { $tax_invc_id = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $hsn_sac_code = $member->hsn_sac_code; }else { $hsn_sac_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description =$member->item_description; }else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '0'; }
			if(isset($member->qty) && !empty($member->qty)) { $qty = $member->qty; }else { $qty = 0; }
			if(isset($member->rate) && !empty($member->rate)) { $rate = $member->rate; }else { $rate = 0; }
			$amount = 0;
			$amount = $qty * $rate;
			$data[] = array(
			$i,
			$boq_code,
			$hsn_sac_code,
			$item_description,
			$unit,
			$qty,
			sprintf('%0.2f', $rate),
			sprintf('%0.2f', $amount)
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
            // "total_amount" => sprintf('%0.2f', $total_amount),
            "total_amount" => sprintf('%0.2f', $new_total_amount),
            // "gst_amount" => sprintf('%0.2f', $gst_amount),
            "gst_amount" => sprintf('%0.2f', $new_gst_amount),
            "gst_type" =>   $gst_type,
            // "sub_total" =>   sprintf('%0.2f', $sub_total)
            "sub_total" =>   sprintf('%0.2f', $new_sub_total)
        );
            // pr($output);
        echo json_encode($output);
		}

    }
    public function project_proinvc_items() 
		{
		  
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$proforma_id = $this->input->post('proforma_id');
	
        
        if(isset($proforma_id) && !empty($proforma_id)){
            $proforma_id = base64_decode($proforma_id);
        }else{
            $proforma_id = 0;
        }
       
		$data = $row = array();
		$memData = $this->admin_model->getProInvcItemListRows($_POST,$proforma_id);
		$allCount = $this->admin_model->countProInvcItemListAll($proforma_id);
		$countFiltered = $this->admin_model->countProInvcItemListFiltered($_POST,$proforma_id);
        $i = $_POST['start'];
        $sub_total = 0;
        $total_amount = 0 ;
        $gst_amount = 0 ;

        $proforma_invc = $this->common_model->selectDetailsWhr('tbl_proforma_invc', 'proforma_id',$proforma_id);
        // pr($proforma_invc);
        if(isset($proforma_invc->project_id) && !empty($proforma_invc->project_id)) { $project_id = $proforma_invc->project_id; }else { $project_id = '-'; }
        if(isset($proforma_invc->billing_type) && !empty($proforma_invc->billing_type)) { $billing_type = $proforma_invc->billing_type; }else { $billing_type = '-'; }

        $project_data=$this->common_model->selectDetailsWhr('tbl_projects','project_id',$project_id);

        $payment_terms = isset($project_data->payment_terms) ? $project_data->payment_terms :'';
        $bill_split_supply = isset($project_data->bill_split_supply) ? $project_data->bill_split_supply :'';
        $bill_installation = isset($project_data->bill_installation) ? $project_data->bill_installation :''; 
        $testing_commissioning = isset($project_data->testing_commissioning) ? $project_data->testing_commissioning : '';
        $bill_handover = isset($project_data->bill_handover) ? $project_data->bill_handover : '';
        
        // echo "<pre>";
        // print_r($project_data);die;
		foreach($memData as $member){
            $i++;
            if($member->gst_type == 'intra-state'){
                // pr("intra-state");
                
                $total_amount += $member->taxable_amount + $member->sgst_amount + $member->cgst_amount;
                $gst_amount += $member->sgst_amount + $member->cgst_amount;
                $sub_total += $member->taxable_amount;
                $gst_type = "CGST_SGST";
                // pr($gst_amount);
            }else{
                //  pr("intra");
                $total_amount += $member->taxable_amount + $member->gst_amount;
                $gst_amount += $member->gst_amount;
                $gst_type = "IGST";
                $sub_total += $member->taxable_amount;
  
            }
            if(isset($member->proforma_id) && !empty($member->proforma_id)) { $proforma_id = $member->proforma_id; }else { $proforma_id = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $hsn_sac_code = $member->hsn_sac_code; }else { $hsn_sac_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description =$member->item_description; }else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '0'; }
			if(isset($member->qty) && !empty($member->qty)) { $qty = $member->qty; }else { $qty = 0; }
			if(isset($member->rate) && !empty($member->rate)) { $rate = $member->rate; }else { $rate = 0; }
            if(isset($member->taxable_amount) && !empty($member->taxable_amount)) { $taxable_amount = $member->taxable_amount; }else { $taxable_amount = 0; }

			$amount = 0;

            if($payment_terms == 'SITC') {
                $amount = $taxable_amount;
            } else {
                $amount = $qty * $rate;
            }

			$data[] = array(
			$i,
			$boq_code,
			$hsn_sac_code,
			$item_description,
			$unit,
			$qty,
            $rate,
            $amount
			// sprintf('%0.2f', $rate),
			// sprintf('%0.2f', $amount)
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
            "total_amount" => sprintf('%0.2f', $total_amount),
            "gst_amount" => sprintf('%0.2f', $gst_amount),
            "gst_type" =>   $gst_type,
            "sub_total" =>   sprintf('%0.2f', $sub_total),
            "auto_round_value" =>   sprintf('%0.2f', $proforma_invc->auto_round_value)
        );
        // pr($output,1);
        echo json_encode($output);
		}

    }
    
    public function get_boq_exceptional_amount() 
		{
		$res = array();
		$PO_taxable_amt = 0;
		$gst_rate = 0;
		$ttl_gst_amount = 0;
		$po_final_amount = 0;
		$po_doc = '';
		$gst_rate_arr = array(5,12,18,28);
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
    		$project_id = $this->input->post('project_id');
            if(isset($project_id) && !empty($project_id)){
                $memData = $this->admin_model->getBOQExceptItemListRows($_POST,$project_id);
		        if(isset($memData) && !empty($memData)){
                    foreach($memData as $member){
                        if(isset($member->EA_qty) && !empty($member->EA_qty)) { $EA_qty = $member->EA_qty; }else { $EA_qty = 0; }
                        if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = 0; }
                        if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = 0; }
                        $taxable_amount = 0;
                        $taxable_amount = abs($EA_qty) * $rate_basic;
                        $PO_taxable_amt += $taxable_amount;
                        $gst_rate += $gst;
                        $gst_amount = 0;
                        if($gst > 0){
                            $gst_amount = $taxable_amount * ($gst/100);
                        }
                        $ttl_gst_amount += $gst_amount;
                    }
		        }
		    }
        }
        $res['PO_taxable_amt'] = sprintf('%0.2f', $PO_taxable_amt);
        if(in_array($gst_rate,$gst_rate_arr)){
	    $res['gst_rate'] = $gst_rate;
        }else{
        $res['gst_rate'] = 'composite';
        }
	    $res['gst_amount'] = sprintf('%0.2f', $ttl_gst_amount);
	    $res['po_final_amount'] = sprintf('%0.2f', ($PO_taxable_amt + $ttl_gst_amount));
	    echo json_encode($res);
	}
	public function getFinancialYear() {
        $currentMonth = date('n');
        $currentYear = date('Y');
        
        if ($currentMonth >= 4) {
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        } else {
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        }
    
        return ($startYear % 100) . '-' . substr($endYear, -2);
    }

    public function compareById($a, $b) {
        if ($a->id == $b->id) {
            return 0;
        }
        return ($a->id < $b->id) ? -1 : 1;
    }
    
    public function get_boq_transaction_list() {
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$project_idpost = $this->input->post('project_id');
        if(isset($project_idpost) && !empty($project_idpost)){
            $project_idpost = base64_decode($project_idpost);
        }else{
            $project_idpost = 0;
        }
        $status_txtpost = $this->input->post('status_txt');
        if(isset($status_txtpost) && !empty($status_txtpost)){
            $status_txt = $status_txtpost;
        }else{
            $status_txt = '';
        }
        $check_permission_approved = 'N';
		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approve_boq_exceptional_approval');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_approved = 'Y';
                }
            }
		}
		$check_permission_dcapprove = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_delivery_challan');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_dcapprove = 'Y';
                }
            }
		}
		$data = $row = array();
		$memData = $this->admin_model->getBOQTransactionItemListRows($_POST,$project_idpost,$status_txt);
		$allCount = $this->admin_model->countBOQTransactionItemListAll($project_idpost,$status_txt);
		$countFiltered = $this->admin_model->countBOQTransactionItemListFiltered($_POST,$project_idpost,$status_txt);
		$getFinancialYear = $this->getFinancialYear();
        if(empty($status_txt)) {
            usort($memData, array($this,'compareById'));
        }
        $FinalContractTotalNew = 0;
        $i = $_POST['start'];
        foreach($memData as $member){
            $i++;
            if(isset($member->id) && !empty($member->id)) { $id = $member->id; }else { $id = '0'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '0'; }
			if(isset($member->event_name) && !empty($member->event_name)) { $event_name = $member->event_name; }else { $event_name = '-'; }
			if(isset($member->event_type) && !empty($member->event_type)) { $event_type = $member->event_type; }else { $event_type = '-'; }
			if(isset($member->display) && !empty($member->display)) { $display = $member->display; }else { $display = '-'; }
			if(isset($member->created_date) && !empty($member->created_date)) { $created_at = $member->created_date; }else { $created_at = '-'; }
			if(isset($member->created_by) && !empty($member->created_by)) { $created_by = $member->created_by; }else { $created_by = '-'; }
			if(isset($member->updated_date) && !empty($member->updated_date)) { $updated_at = $member->updated_date; }else { $updated_at = '-'; }
			if(isset($member->updated_by) && !empty($member->updated_by)) { $updated_by = $member->updated_by; }else { $updated_by = '-'; }
			if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = '-'; }
			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '-'; }
			if(isset($member->created_by_rolename) && !empty($member->created_by_rolename)) { $created_by_rolename = '<br>('.$member->created_by_rolename.')'; }else { $created_by_rolename = ''; }
			if(isset($member->approved_by_rolename) && !empty($member->approved_by_rolename)) { $approved_by_rolename = '<br>('.$member->approved_by_rolename.')'; }else { $approved_by_rolename = ''; }
			if(isset($member->created_by_name) && !empty($member->created_by_name)) { $created_by_name = $member->created_by_name.''.$created_by_rolename; }else { $created_by_name = '-'; }
			if(isset($member->approved_by_name) && !empty($member->approved_by_name)) { $approved_by_name = $member->approved_by_name.''.$approved_by_rolename; }else { $approved_by_name = '-'; }
			if(isset($member->exceptional_no) && !empty($member->exceptional_no)) { $exceptional_no = $member->exceptional_no; }else { $exceptional_no = '-'; }
			if(isset($member->exceptional_id) && !empty($member->exceptional_id)) { $exceptional_id = $member->exceptional_id; }else { $exceptional_id = 0; }
			if(isset($member->is_first_upload) && !empty($member->is_first_upload)) { $is_first_upload = $member->is_first_upload; }else { $is_first_upload = 0; }
            if(isset($member->variable_discount_id) && !empty($member->variable_discount_id)) { $variable_discount_id = $member->variable_discount_id; }else { $variable_discount_id = 0; }
			
			$FinalContractTotal = 0;
			$filter = 'original';
			$FinalContractamount = $this->getFinalContractamount($filter,$id,$event_type,$project_id,$status_txt);
            
			if($event_type == 'boq_upload' || $event_type == 'add_edit_boq'){
			    if($is_first_upload != 1){
        			if(isset($FinalContractamount['totalUdsgnGSTAmount']) && !empty($FinalContractamount['totalUdsgnGSTAmount'])){
        			    $FinalContractTotal = abs($FinalContractamount['totalUdsgnGSTAmount']);    
                    }   
			    }else{
			    	if(isset($FinalContractamount['totalOriAmountGST']) && !empty($FinalContractamount['totalOriAmountGST'])){
        			    $FinalContractTotal = abs($FinalContractamount['totalOriAmountGST']);    
        			}
			    }
			}elseif($event_type == 'add_dc'){
			    if(isset($FinalContractamount['totalDcAmountGST']) && !empty($FinalContractamount['totalDcAmountGST'])){
        	        $FinalContractTotal = abs($FinalContractamount['totalDcAmountGST']) ;    
        		}
			}else{
				if(isset($FinalContractamount['totalEaAmountGST']) && !empty($FinalContractamount['totalEaAmountGST'])){
    			    $FinalContractTotal = abs($FinalContractamount['totalEaAmountGST']);    
    			}
			}

            if(empty($status_txt)) {
                $boqSchAmount = 0;
                $boqDsgAmount = 0;
                $addBoqAmount = 0;
                $totalEaPositive = 0;
                $totalEaNagative = 0;
                $totalEaNs = 0;
                if($event_type == 'boq_upload' && $is_first_upload == 1){
                    if(isset($FinalContractamount['totalOriAmountGST']) && !empty($FinalContractamount['totalOriAmountGST'])){
                        $boqSchAmount = abs($FinalContractamount['totalOriAmountGST']);
                        $FinalContractTotalNew = $boqSchAmount;
                    }
                } else if($event_type == 'boq_upload' && $is_first_upload != 1) {
                    if(isset($FinalContractamount['totalUdsgnGSTAmount']) && !empty($FinalContractamount['totalUdsgnGSTAmount'])){
                        $boqDsgAmount = abs($FinalContractamount['totalUdsgnGSTAmount']);
                        $FinalContractTotalNew = $boqSchAmount;    
                    }
                } else if($event_type == 'add_edit_boq' && $is_first_upload != 1) {
                    if(isset($FinalContractamount['totalUdsgnGSTAmount']) && !empty($FinalContractamount['totalUdsgnGSTAmount'])){
                        $addBoqAmount = abs($FinalContractamount['totalUdsgnGSTAmount']);
                       
                    }
                } else {
                    $totalEaNS = 0;
                    $totalEaNagative = 0;
                    $totalEaPositive = 0;
                } 
    
                if($event_type == 'boq_exceptional_appr') {
                    $exceptionalData = $this->admin_model->getBoqExceptionalType($project_id,$id);
                    if(isset($exceptionalData->except_type) && !empty($exceptionalData->except_type)) { $except_type = $exceptionalData->except_type; }else { $except_type = ''; }
                    if($except_type == 'positive'){
                        if(isset($FinalContractamount['totalEaAmountGST']) && !empty($FinalContractamount['totalEaAmountGST'])){
                            $totalEaPositive = abs($FinalContractamount['totalEaAmountGST']);
                            $FinalContractTotalNew += $totalEaPositive;    
    
                        }
                    } else if($except_type == 'negative') {
                        if(isset($FinalContractamount['totalEaAmountGST']) && !empty($FinalContractamount['totalEaAmountGST'])){
                            $totalEaNagative = abs($FinalContractamount['totalEaAmountGST']);
                            $FinalContractTotalNew -= $totalEaNagative;    
                        }
                    } else if($except_type == 'ns_yes') {
                        if(isset($FinalContractamount['totalEaAmountGST']) && !empty($FinalContractamount['totalEaAmountGST'])){
                            $totalEaNS = abs($FinalContractamount['totalEaAmountGST']);
                            $FinalContractTotalNew += $totalEaNS;
                        } 
                    }
                }
                if($event_type == 'boq_upload' || $event_type == 'add_edit_boq') {
                    if(isset($FinalContractamount['totalOriAmountGST']) && !empty($FinalContractamount['totalOriAmountGST'])){
                        $FinalContractTotalNew = abs($FinalContractamount['totalOriAmountGST']);
                        // pr('boq_upload');
                    }   
                }
            }
           
			if($event_type == 'boq_upload'){
			$event_type_name = 'BOQ Upload';    
			}elseif($event_type == 'add_edit_boq'){
			$event_type_name = 'Add BOQ';    
			}else{
			$event_type_name = $exceptional_no;    
			}
			$action_status='';
			if($status == 'approved'){
			$action_status .='<span style="color:green;font-weight:600;">Approved</span>';
			}elseif($status == 'reject'){
			$action_status .='<span style="color:red;font-weight:600;">Rejected</span>';
			}else{
			$action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
			}
			$action = '';
			
            if(isset($exceptional_id) && !empty($exceptional_id) && $event_type == 'add_dc'){
                $action .= '<a class="popup_save" href="javascript:void(0);" rev="view_dcc_items" rel="'.$exceptional_id.'" data-title="(#'.$exceptional_no.') Delivery Challan" data-status="allow" style="margin-top:10px;"><span class="md-click-circle md-click-animate" style="height: 97px; width: 97px; top: -38.5312px; left: 29.4896px;"></span>VIEW</a>';
            }else if(isset($variable_discount_id) && !empty($variable_discount_id) && $event_type == 'boq_variable_discount'){
                $action .= '<a class="popup_save" href="javascript:void(0);" rev="view_variable_discount_items" project_id="'.$project_id.'" rel="'.$variable_discount_id.'" data-title="(#'.$variable_discount_id.') Variable Discount" data-status="allow" style="margin-top:10px;"><span class="md-click-circle md-click-animate" style="height: 97px; width: 97px; top: -38.5312px; left: 29.4896px;"></span>VIEW</a>';
            }else{
                $action .='<a class="openview" href="javascript:void(0);" data-fid="'.$is_first_upload.'" data-id="'.$id.'"  data-type="'.$event_type.'">VIEW</a>';
            }


			if($status =='pending' && !empty($exceptional_id) && $event_type == 'boq_exceptional_appr'){
			    if($check_permission_approved == 'Y'){
			        $action .='&nbsp;&nbsp;&nbsp;<select class="statusselect" id="statusselect'.$exceptional_id.'" rev="approve_boq_exceptional_approval" rel="'.$exceptional_id.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
			    }
			}elseif($status =='reject' && !empty($exceptional_id) && $event_type == 'boq_exceptional_appr'){
			    if($check_permission_approved == 'Y'){
			        $action .='&nbsp;&nbsp;&nbsp;<select class="statusselect" id="statusselect'.$exceptional_id.'" rev="approve_boq_exceptional_approval" rel="'.$exceptional_id.'"><option class="statusselectoption" value="reject">Reject</option><option class="statusselectoption" value="approved">Approve</option></select>';
			    }
			}elseif($status =='pending' && !empty($exceptional_id) && $event_type == 'add_dc'){
    			if($check_permission_dcapprove == 'Y'){
    			$action .='&nbsp;&nbsp;&nbsp;<select class="statusselect" id="statusselect'.$exceptional_id.'" rev="approved_delivery_challan" rel="'.$exceptional_id.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
    			}
			}elseif($status =='reject' && !empty($exceptional_id) && $event_type == 'add_dc'){
			    if($check_permission_dcapprove == 'Y'){
    			$action .='&nbsp;&nbsp;&nbsp;<select class="statusselect" id="statusselect'.$exceptional_id.'" rev="approved_delivery_challan" rel="'.$exceptional_id.'"><option class="statusselectoption" value="reject">Reject</option><option class="statusselectoption" value="approved">Approve</option></select>';
			    }
			}elseif($status =='pending' && !empty($variable_discount_id) && $event_type == 'boq_variable_discount') {
                if($check_permission_approved == 'Y'){
			        $action .='&nbsp;&nbsp;&nbsp;<select class="statusselect" id="statusselect'.$variable_discount_id.'" rev="approve_boq_variable_discount" rel="'.$variable_discount_id.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
			    }
            }

            if(empty($status_txt)) {
                if(isset($project_idpost) && !empty($project_idpost)){
                    $data[] = array(
                    $i,
                    $bp_code,
                    $event_name,
                    $event_type_name,
                    sprintf('%0.2f', $boqSchAmount),
                    sprintf('%0.2f', $boqDsgAmount),
                    sprintf('%0.2f', $addBoqAmount),
                    sprintf('%0.2f', $totalEaPositive),
                    sprintf('%0.2f', $totalEaNagative),
                    sprintf('%0.2f', $totalEaNS),
                    sprintf('%0.2f', $FinalContractTotalNew),
                    // sprintf('%0.2f', $FinalContractTotal),
                    $created_by_name,
                    $approved_by_name,
                    $created_at,
                    $action);
                    $column0 = array_column($data, 0);
                    array_multisort($column0, SORT_DESC, $data);
                }
            } else {
                if(isset($project_idpost) && !empty($project_idpost)){
                    $data[] = array(
                    $i,
                    $bp_code,
                    $event_name,
                    $event_type_name,
                    sprintf('%0.2f', $FinalContractTotal),
                    $created_by_name,
                    $approved_by_name,
                    $created_at,
                    $action);
                }
            }
		}
        // echo "<pre>";
        // print_r($data);die;
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    
    public function get_boq_exceptional_list() 
		{
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$project_idpost = $this->input->post('project_id');
        if(isset($project_idpost) && !empty($project_idpost)){
            $project_idpost = base64_decode($project_idpost);
        }else{
            $project_idpost = 0;
        }
        $check_permission_approved = 'N';
		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approve_boq_exceptional_approval');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_approved = 'Y';
                }
            }
		}
		$check_permission_edit = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_boq_exceptional_approval');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_edit = 'Y';
                }
            }
		}
		$data = $row = array();
		$memData = $this->admin_model->getBOQExceptionalItemListRows($_POST,$project_idpost);
		$allCount = $this->admin_model->countBOQExceptionalItemListAll($project_idpost);
		$countFiltered = $this->admin_model->countBOQExceptionalItemListFiltered($_POST,$project_idpost);
		$getFinancialYear = $this->getFinancialYear();
        $i = $_POST['start'];
        // pr($memData);
        // $uniqueData = [];
        // $seenKeys = [];
        
        // foreach ($memData as $item) {
        //     $key = $item->exceptional_no . '-' . $item->except_type;
            
        //     if (!isset($seenKeys[$key])) {
        //         $seenKeys[$key] = true;
        //         $uniqueData[] = $item;
        //     }
        // }
        $uniqueData = [];
        $seenIds = [];
        
        foreach ($memData as $item) {
            if (!in_array($item->exceptional_id, $seenIds)) {
                $seenIds[] = $item->exceptional_id;
                $uniqueData[] = $item;
            }
        }

        $memData = $uniqueData;
		foreach($memData as $member){
            $i++;
            if(isset($member->exceptional_id) && !empty($member->exceptional_id)) { $exceptional_id = $member->exceptional_id; }else { $exceptional_id = '0'; }
			if(isset($member->name_of_work) && !empty($member->name_of_work)) { $name_of_work = $member->name_of_work; }else { $name_of_work = '-'; }
            if(isset($member->event_name) && !empty($member->event_name)) { $event_name = $member->event_name; }else { $event_name = '-'; }
			if(isset($member->customer_name) && !empty($member->customer_name)) { $customer_name = $member->customer_name; }else { $customer_name = '-'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
			if(isset($member->PO_taxable_amt) && !empty($member->PO_taxable_amt)) { $PO_taxable_amt = $member->PO_taxable_amt; }else { $PO_taxable_amt = '-'; }
			if(isset($member->gst_rate) && !empty($member->gst_rate)) { $gst_rate = $member->gst_rate; }else { $gst_rate = '-'; }
			if(isset($member->gst_amount) && !empty($member->gst_amount)) { $gst_amount = $member->gst_amount; }else { $gst_amount = '-'; }
			if(isset($member->po_final_amount) && !empty($member->po_final_amount)) { $po_final_amount = $member->po_final_amount; }else { $po_final_amount = '0'; }
			if(isset($member->po_doc) && !empty($member->po_doc)) { $po_doc = $member->po_doc; }else { $po_doc = '-'; }
			if(isset($member->display) && !empty($member->display)) { $display = $member->display; }else { $display = '-'; }
			if(isset($member->created_at) && !empty($member->created_at)) { $created_at = $member->created_at; }else { $created_at = '-'; }
			if(isset($member->created_by) && !empty($member->created_by)) { $created_by = $member->created_by; }else { $created_by = '-'; }
			if(isset($member->updated_at) && !empty($member->updated_at)) { $updated_at = $member->updated_at; }else { $updated_at = '-'; }
			if(isset($member->updated_by) && !empty($member->updated_by)) { $updated_by = $member->updated_by; }else { $updated_by = '-'; }
			if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = '-'; }
			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '-'; }
			if(isset($member->created_by_rolename) && !empty($member->created_by_rolename)) { $created_by_rolename = '<br>('.$member->created_by_rolename.')'; }else { $created_by_rolename = ''; }
			if(isset($member->approved_by_rolename) && !empty($member->approved_by_rolename)) { $approved_by_rolename = '<br>('.$member->approved_by_rolename.')'; }else { $approved_by_rolename = ''; }
			if(isset($member->created_by_name) && !empty($member->created_by_name)) { $created_by_name = $member->created_by_name.''.$created_by_rolename; }else { $created_by_name = '-'; }
			if(isset($member->approved_by_name) && !empty($member->approved_by_name)) { $approved_by_name = $member->approved_by_name.''.$approved_by_rolename; }else { $approved_by_name = '-'; }
			if(isset($member->billable) && !empty($member->billable) && $member->billable == 'Y') { $billable = 'Billable'; }else { $billable = 'Non Billable'; }
			if(isset($member->exceptional_no) && !empty($member->exceptional_no)) { $exceptional_no = $member->exceptional_no; }else { $exceptional_no = '-'; }
			if(isset($member->transaction_id) && !empty($member->transaction_id)) { $transaction_id = $member->transaction_id; }else { $transaction_id = 0; }
			if(isset($member->except_type) && !empty($member->except_type)) { $except_type = $member->except_type; }else { $except_type = 0; }
			
			$FinalContractTotal = 0;
			$filter = 'original';
			$event_type = 'boq_exceptional_appr';
			$status_txt='';
			if($status == 'pending'){
			$status_txt = 'pending';    
			}
			$FinalContractamount = $this->getFinalContractamount($filter,$transaction_id,$event_type,$project_id,$status_txt);
			if(isset($FinalContractamount['totalEaAmountGST']) && !empty($FinalContractamount['totalEaAmountGST'])){
    	        $FinalContractTotal = abs($FinalContractamount['totalEaAmountGST']);    
    		}
    		$FinalContractTotalAmt = $po_final_amount;
    		if($except_type == 'negative'){
    		    $FinalContractTotalAmt = $FinalContractTotal; 
                $event_name = "Negative BOQ Exceptional Approval";
    		} else if($except_type == 'positive') {
                $FinalContractTotalAmt = $FinalContractTotal;
                $event_name = "Positive BOQ Exceptional Approval";
            } else if($except_type == 'ns_yes') {
                $FinalContractTotalAmt = $FinalContractTotal;
                $event_name = "NS BOQ Exceptional Approval";
            }
			$action_status='';
			if($status == 'approved'){
			$action_status .='<span style="color:green;font-weight:600;">Approved</span>';
			}elseif($status == 'reject'){
			$action_status .='<span style="color:red;font-weight:600;">Rejected</span>';
			}else{
			$action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
			}
			if(strlen($exceptional_id) > 4){
			    $exceptionalid = 'EA-'.$exceptional_id.'/'.$getFinancialYear;
			}else{
			    $exceptionalid = 'EA-'.sprintf('%02d',$member->exceptional_id).'/'.$getFinancialYear;
			}
// 			$exceptionalid_html = '<a class="popup_save" href="javascript:void(0);" rev="view_boq_exceptional_items" rel="'.$exceptional_id.'" data-title="(#'.$exceptionalid.') BOQ Exceptionl Approval Item List" data-status="allow" style="margin-top:10px;">'.$exceptional_no.'</a>';
			$exceptionalid_html = '<a class="popup_save" href="javascript:void(0);" rev="view_boq_exceptional_items" rel="'.$exceptional_id.'" data-title="(#'.$exceptionalid.') BOQ Exceptionl Approval Item List" data-status="allow" style="margin-top:10px;">'.$exceptionalid.'</a>';
			
			$action = '';
			if(isset($member->po_doc) && !empty($member->po_doc)) {
			    $action .='&nbsp;&nbsp;&nbsp;<a href="'.base_url().'uploads/variation_po/'.$po_doc.'" download><i class="fa fa-download" style="color:#000; font-size:15px;"></i></a>&nbsp;&nbsp;&nbsp;';
			}
			if($status =='pending'){
			    if($check_permission_approved == 'Y'){
			        $action .='<select class="statusselect" id="statusselect'.$exceptional_id.'" rev="approve_boq_exceptional_approval" rel="'.$exceptional_id.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
			    }
			}elseif($status =='reject'){
			    if($check_permission_edit == 'Y'){
			        $action .='<a href="javascript:;" class="editRecord tooltips" rel="'.$exceptional_id.'" title="Edit Record" rev="edit_boq_exceptional_approval" data-original-title="Edit Record"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';
			    }
			    if($check_permission_approved == 'Y'){
			        $action .='&nbsp;&nbsp;&nbsp;<select class="statusselect" id="statusselect'.$exceptional_id.'" rev="approve_boq_exceptional_approval" rel="'.$exceptional_id.'"><option class="statusselectoption" value="reject">Reject</option><option class="statusselectoption" value="approved">Approve</option></select>';
			    }
			}
			if(isset($project_idpost) && !empty($project_idpost)){
				$data[] = array(
    			$i,
    			$exceptionalid_html,
               $event_name,
    			$billable,
    			$bp_code,
    			sprintf('%0.2f', $FinalContractTotalAmt),
    			$created_by_name,
    			$approved_by_name,
    			$created_at);
            }else{
				$data[] = array(
    			$i,
    			$exceptionalid_html,
                $event_name,
    			$billable,
    			$bp_code,
    			sprintf('%0.2f', $FinalContractTotalAmt),
    			$created_by_name,
    			$approved_by_name,
    			$action_status,
    			$created_at,
    			$action);
            }
		}
        $output = array(
            "draw" => $_POST['draw'],
            // "recordsTotal" => $allCount,
            "recordsTotal" => count($data),
            // "recordsFiltered" => $countFiltered,
            "recordsFiltered" => count($data),
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    public function delete_boq_details()
    {  
        $update_stock_arr=array();
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_datad=$this->common_model->selectDetailsWhr('tbl_submenu','action','delete_boq_details');
            if(isset($submenu_datad->submenu_id) && !empty($submenu_datad->submenu_id)){
                $submenu_idd = $submenu_datad->submenu_id;
                $check_permissiond=$this->admin_model->check_permission($submenu_idd,$logrole_id);
                if(isset($check_permissiond) && !empty($check_permissiond)){
                    $boq_items_id = $this->input->post('id');
                    if(isset($boq_items_id) && !empty($boq_items_id)){
                        $boq_items_id = $boq_items_id;
                    }else{
                        $boq_items_id = 0;
                    }
                    $boq_items_data=$this->common_model->selectDetailsWhr('tbl_boq_items','boq_items_id',$boq_items_id);
                    if(isset($boq_items_data) && !empty($boq_items_data)){
                        if(isset($boq_items_data->status) && !empty($boq_items_data->status) && $boq_items_data->status == 'N'){
                            $data = array('display'=>'N','deleted_by'=>$user_id,'deleted_date'=>date('Y-m-d H:i:s'));
                            $result = $this->common_model->updateDetails('tbl_boq_items','boq_items_id',$boq_items_id,$data);
                            if($result){
                                $this->json->jsonReturn(array(
                                    'valid'=>TRUE,
                                    'msg'=>'<div class="alert modify alert-success"><strong></strong> BOQ Item Details Remove Successfully!</div>'
                                ));
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Removing BOQ Item Details !</div>'
                                ));
                            }
                        }elseif(isset($boq_items_data->status) && !empty($boq_items_data->status) && $boq_items_data->status == 'Y'
                        && isset($boq_items_data->design_qty) && $boq_items_data->design_qty == 0){
                            $data = array('display'=>'N','deleted_by'=>$user_id,'deleted_date'=>date('Y-m-d H:i:s'));
                            $result = $this->common_model->updateDetails('tbl_boq_items','boq_items_id',$boq_items_id,$data);
                            if($result){
                                $this->json->jsonReturn(array(
                                    'valid'=>TRUE,
                                    'msg'=>'<div class="alert modify alert-success"><strong></strong> BOQ Item Details Remove Successfully!</div>'
                                ));
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Removing BOQ Item Details !</div>'
                                ));
                            }
                        }else{
                            if(isset($boq_items_data->project_id) && !empty($boq_items_data->project_id) 
                            && isset($boq_items_data->boq_code) && !empty($boq_items_data->boq_code)
                            && isset($boq_items_data->boq_items_id) && !empty($boq_items_data->boq_items_id)){
                                if(isset($boq_items_data->design_qty) && $boq_items_data->design_qty > 0){
                                    $checkDCCreated = $this->common_model->selectDetailsWhr('tbl_deliv_challan_items','boq_items_id',$boq_items_data->boq_items_id);
                                    if(isset($checkDCCreated) && !empty($checkDCCreated)){
                                        $this->json->jsonReturn(array(
                                            'valid'=>FALSE,
                                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> Can not remove BOQ Item Details! Client Delivery Challan is exist for this BOQ Item!</div>'
                                        ));
                                    }else{
                                        $checkBOQExceptional = $this->common_model->selectDetailsWhr('tbl_boq_exceptional','boq_items_id',$boq_items_data->boq_items_id);
                                        if(isset($checkBOQExceptional->status) && !empty($checkBOQExceptional->status) && $checkBOQExceptional->status == 'approved'){
                                            $this->json->jsonReturn(array(
                                                'valid'=>FALSE,
                                                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> Can not remove BOQ Item Details! BOQ Exceptional is approved for this BOQ Item!</div>'
                                            ));
                                        }else{
                                            if(isset($checkBOQExceptional) && !empty($checkBOQExceptional)){
                                            $this->admin_model->deleteBOQExceptionalItem($boq_items_data->boq_items_id,$boq_items_data->boq_items_id,$boq_items_data->project_id,$boq_items_data->boq_code);
                                            }else{
                                            $this->admin_model->deleteBOQExceptionalItem($boq_items_data->boq_items_id,0,$boq_items_data->project_id,$boq_items_data->boq_code);
                                            }
                                            $check_stock_details = $this->admin_model->check_stock_details($boq_items_data->project_id,$boq_items_data->boq_code);
                                            if(isset($check_stock_details) && !empty($check_stock_details)){
                                                $total_stock = 0;
                                                $total_stock_val = 0;
                                                $dc_total_stock = 0;
                                                $dc_total_stock_val = 0;
                                                $dc_stock = 0;
                                                $dc_stock_val = 0;
                                                $avl_stock=0;
                                                $avl_stock_val=0;
                                                if(isset($check_stock_details->total_stock) && !empty($check_stock_details->total_stock) 
                                                && $check_stock_details->total_stock > 0){
                                                    $total_stock = $check_stock_details->total_stock;
                                                }
                                                if(isset($check_stock_details->dc_total_stock) && !empty($check_stock_details->dc_total_stock) 
                                                && $check_stock_details->dc_total_stock > 0){
                                                    $dc_total_stock = $check_stock_details->dc_total_stock;
                                                }
                                                if(isset($check_stock_details->dc_stock) && !empty($check_stock_details->dc_stock) 
                                                && $check_stock_details->dc_stock > 0){
                                                    $dc_stock = $check_stock_details->dc_stock;
                                                }
                                                if(isset($check_stock_details->avl_stock) && !empty($check_stock_details->avl_stock) 
                                                && $check_stock_details->avl_stock > 0){
                                                    $avl_stock = $check_stock_details->avl_stock;
                                                }
                                                
                                                $minus_qty = 0;
                                                $getPrevBOQQty = 0;
                                                $getPrevBOQQty = $this->admin_model->getBOQPreviousQty($boq_items_data->boq_items_id,$boq_items_data->project_id,$boq_items_data->boq_code);
                                                if(isset($getPrevBOQQty) && !empty($getPrevBOQQty)){
                                                    if($boq_items_data->design_qty >= $getPrevBOQQty){
                                                        $minus_qty = $boq_items_data->design_qty - $getPrevBOQQty; 
                                                        if($total_stock >= $minus_qty && $minus_qty > 0){
                                                            $total_stock_val = $total_stock - $minus_qty;
                                                            $update_stock_arr = array('total_stock'=>$total_stock_val,'updated_by'=>$loguser_id,'updated_date'=>date('Y-m-d H:i:s'));    
                                                        }
                                                    }     
                                                }else{
                                                    $total_stock_val = 0;
                                                    $dc_total_stock_val = 0;
                                                    $dc_stock_val = 0;
                                                    $update_stock_arr = array('total_stock'=>$total_stock_val,'dc_total_stock'=>$dc_total_stock_val,
                                                    'dc_stock'=>$dc_stock_val,'avl_stock'=>0,'updated_by'=>$loguser_id,'updated_date'=>date('Y-m-d H:i:s'));    
                                                }
                                            }
                                            if(isset($update_stock_arr) && !empty($update_stock_arr)){
                                                $this->common_model->updateBOQStockDetails($update_stock_arr,$boq_items_data->project_id,$boq_items_data->boq_code);
                                            }
                                            $data = array('display'=>'N','deleted_by'=>$user_id,'deleted_date'=>date('Y-m-d H:i:s'));
                                            $result = $this->common_model->updateDetails('tbl_boq_items','boq_items_id',$boq_items_id,$data);
                                            if($result){
                                                $this->json->jsonReturn(array(
                                                    'valid'=>TRUE,
                                                    'msg'=>'<div class="alert modify alert-success">BOQ Item Details Remove Successfully!</div>'
                                                ));
                                            }else{
                                                $this->json->jsonReturn(array(
                                                    'valid'=>FALSE,
                                                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Removing BOQ Item Details !</div>'
                                                ));
                                            }
                                        }
                                    }
                                }else{
                                    $data = array('display'=>'N','deleted_by'=>$user_id,'deleted_date'=>date('Y-m-d H:i:s'));
                                    $result = $this->common_model->updateDetails('tbl_boq_items','boq_items_id',$boq_items_id,$data);
                                    if($result){
                                        $this->json->jsonReturn(array(
                                            'valid'=>TRUE,
                                            'msg'=>'<div class="alert modify alert-success"><strong></strong> BOQ Item Details Remove Successfully!</div>'
                                        ));
                                    }else{
                                        $this->json->jsonReturn(array(
                                            'valid'=>FALSE,
                                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Removing BOQ Item Details !</div>'
                                        ));
                                    }
                                }
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> Invalid BOQ Item Details !</div>'
                                ));
                            }
                        }
                        
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Removing BOQ Item Details !</div>'
                        ));
                    }
                }else{
                    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!!</div>'
                    ));
                }
            }else{
                $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!!</div>'
                ));
            }
        }else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!!</div>'
            ));
        }
    }
    public function delete_boq_exceptional_approval()
    {  
        $exceptional_id = $this->input->post('id');
        $data = array('display'=>'N','deleted_by'=>$user_id,'deleted_date'=>date('Y-m-d H:i:s'));
        $result = $this->common_model->updateDetails('tbl_boq_exceptional','exceptional_id',$exceptional_id,$data);
        if($result)
        {
            $this->json->jsonReturn(array(
                'valid'=>TRUE,
                'msg'=>'<div class="alert modify alert-success"><strong></strong> BOQ Exceptional Approval Details Remove Successfully!</div>'
            ));
        }
        else
        {
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Removing BOQ Exceptional Approval Details !</div>'
            ));
        }
    }
    public function approved_tax_invoice()
    {  
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_tax_invoice');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $update_stock_arr = array();
                    $user_id = $this->session->userData('user_id');
            		if(isset($user_id) && !empty($user_id)){
            		$tax_invc_id = $this->input->post('id');
                    $status = $this->input->post('status');
                    $TaxInvoiceDetails = $this->common_model->selectDetailsWhr('tbl_tax_invc','tax_invc_id',$tax_invc_id);
                    if(isset($TaxInvoiceDetails) && !empty($TaxInvoiceDetails) && isset($status) && !empty($status)){ 
                    if(isset($TaxInvoiceDetails->status) && !empty($TaxInvoiceDetails->status) && $TaxInvoiceDetails->status!='approved'){   
                        $project_id = 0;
                        if(isset($TaxInvoiceDetails->project_id) && !empty($TaxInvoiceDetails->project_id)){   
                            $project_id = $TaxInvoiceDetails->project_id;
                        }
                        $tax_invoice_items = $this->common_model->selectDetailsWhereAllDY('tbl_tax_invc_items', 'tax_invc_id',$tax_invc_id);
                        if(isset($tax_invoice_items) && !empty($tax_invoice_items)){
                            $project_id_arr = $boq_code_arr = array();
                            foreach($tax_invoice_items as $key){
                                if(isset($project_id) && !empty($project_id) && isset($key->boq_code) && !empty($key->boq_code)){
                                    $project_id_arr[] = $project_id;
                                    $boq_code_arr[] = $key->boq_code;
                                }
                            }
                            $BOQStockArr = array();
                            if(isset($project_id_arr) && !empty($project_id_arr) && isset($boq_code_arr) && !empty($boq_code_arr)){
                                $project_ids = "'" . implode ( "', '", $project_id_arr ) . "'";
                                $boq_codes = "'" . implode ( "', '", $boq_code_arr ) . "'";
                                $BOQStockArr=$this->common_model->getBOQStockBulkDetails($project_ids,$boq_codes);
                            }
                            foreach($tax_invoice_items as $key){
                                if(isset($project_id) && !empty($project_id) && isset($key->boq_code) && !empty($key->boq_code)){
                                    $tax_from = '';
                                    if(isset($key->tax_from) && !empty($key->tax_from)){
                                        $tax_from = $key->tax_from;    
                                    }
                                    $boq_code = $key->boq_code;
                                    if(isset($BOQStockArr[$project_id.'-'.$boq_code]) && !empty($BOQStockArr[$project_id.'-'.$boq_code])){
                                        if($tax_from == 'installed_stock'){
                                            $installed=0;
                                            $installed_val=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['installed']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['installed']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['installed'] > 0){
                                                $installed = $BOQStockArr[$project_id.'-'.$boq_code]['installed'];
                                            }
                                            $tax_invoice_stock=0;
                                            $tax_invoice_stock_val=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['tax_invoice_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['tax_invoice_stock']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['tax_invoice_stock'] > 0){
                                                $tax_invoice_stock = $BOQStockArr[$project_id.'-'.$boq_code]['tax_invoice_stock'];
                                            }
                                            $qty=0;
                                            if(isset($key->qty) && !empty($key->qty) && $key->qty > 0){
                                                $qty = $key->qty;    
                                            }
                                            if(isset($status) && !empty($status) && $status == 'approved'){
                                                if(isset($installed) && !empty($installed) && $installed > 0 && $qty > 0 && $installed >= $qty){
                                                    $tax_invoice_stock_val = $tax_invoice_stock + $qty;
                                                    $installed_val = $installed - $qty;
                                                    $update_stock_arr[] = array('boq_code'=>$key->boq_code,'tax_invoice_stock'=>$tax_invoice_stock_val,
                                                    'installed'=>$installed_val,'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));
                                                }
                                            }
                                        }elseif($tax_from == 'provisional_stock'){
                                            $provisional=0;
                                            $provisional_val=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['provisional']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['provisional']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['provisional'] > 0){
                                                $provisional = $BOQStockArr[$project_id.'-'.$boq_code]['provisional'];
                                            }
                                            $tax_invoice_stock=0;
                                            $tax_invoice_stock_val=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['tax_invoice_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['tax_invoice_stock']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['tax_invoice_stock'] > 0){
                                                $tax_invoice_stock = $BOQStockArr[$project_id.'-'.$boq_code]['tax_invoice_stock'];
                                            }
                                            $qty=0;
                                            if(isset($key->qty) && !empty($key->qty) && $key->qty > 0){
                                                $qty = $key->qty;    
                                            }
                                            if(isset($status) && !empty($status) && $status == 'approved'){
                                                if(isset($provisional) && !empty($provisional) && $provisional > 0 && $qty > 0 && $provisional >= $qty){
                                                    $tax_invoice_stock_val = $tax_invoice_stock + $qty;
                                                    $provisional_val = $provisional - $qty;
                                                    $update_stock_arr[] = array('boq_code'=>$key->boq_code,'tax_invoice_stock'=>$tax_invoice_stock_val,
                                                    'provisional'=>$provisional_val,'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));
                                                }
                                            }
                                        }elseif($tax_from == 'both'){
                                            $installed=0;
                                            $installed_val=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['installed']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['installed']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['installed'] > 0){
                                                $installed = $BOQStockArr[$project_id.'-'.$boq_code]['installed'];
                                            }
                                            $provisional=0;
                                            $provisional_val=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['provisional']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['provisional']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['provisional'] > 0){
                                                $provisional = $BOQStockArr[$project_id.'-'.$boq_code]['provisional'];
                                            }
                                            $tax_invoice_stock=0;
                                            $tax_invoice_stock_val=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['tax_invoice_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['tax_invoice_stock']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['tax_invoice_stock'] > 0){
                                                $tax_invoice_stock = $BOQStockArr[$project_id.'-'.$boq_code]['tax_invoice_stock'];
                                            }
                                            $final_qty = 0;
                                            $final_qty = $installed + $provisional;
                                            $qty=0;
                                            if(isset($key->qty) && !empty($key->qty) && $key->qty > 0){
                                                $qty = $key->qty;    
                                            }
                                            if(isset($status) && !empty($status) && $status == 'approved'){
                                                if(isset($final_qty) && !empty($final_qty) && $final_qty > 0 && $qty > 0 && $final_qty >= $qty){
                                                    $remaining_qty = 0;
                                                    if($qty >= $installed){
                                                        $remaining_qty = $qty - $installed;     
                                                    }
                                                    if($provisional >= $remaining_qty){
                                                        $provisional_val = $provisional - $remaining_qty;
                                                    }
                                                    $tax_invoice_stock_val = $tax_invoice_stock + $qty;
                                                    $update_stock_arr[] = array('boq_code'=>$key->boq_code,'tax_invoice_stock'=>$tax_invoice_stock_val,
                                                    'installed'=>0,'provisional'=>$provisional_val,'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));
                                                }
                                            }
                                        }
                                    }
                                }    
                            }
                            if(isset($TaxInvoiceDetails->convertid) && empty($TaxInvoiceDetails->convertid)
                            && isset($status) && !empty($status) && $status == 'approved'){
                                if(isset($update_stock_arr) && !empty($update_stock_arr) && $project_id > 0){
                                    $this->common_model->updateBOQInstallStock($update_stock_arr,$project_id);
                                    $data = array('status'=>$status,'approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
                                    $datap = array('status'=>$status);
                                    $this->common_model->updateDetails('tbl_tax_invc','tax_invc_id',$tax_invc_id,$data);
                                    $this->common_model->updateDetails('tbl_tax_invc_items','tax_invc_id',$tax_invc_id,$datap);
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE, 
                                        'msg'=>'<div class="alert modify alert-success">Tax Invoice Status Changed Successfully!</div>'
                                    ));
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> Tax Invoice Items out of stock!!</div>'
                                    ));
                                }
                            }elseif(isset($TaxInvoiceDetails->convertid) && !empty($TaxInvoiceDetails->convertid)
                            && isset($status) && !empty($status) && $status == 'approved'){
                                $data = array('status'=>$status,'approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
                                $datap = array('status'=>$status);
                                $this->common_model->updateDetails('tbl_tax_invc','tax_invc_id',$tax_invc_id,$data);
                                $this->common_model->updateDetails('tbl_tax_invc_items','tax_invc_id',$tax_invc_id,$datap);
                                $this->json->jsonReturn(array(
                                    'valid'=>TRUE, 
                                    'msg'=>'<div class="alert modify alert-success">Tax Invoice Status Changed Successfully!</div>'
                                ));
                            }elseif(isset($status) && !empty($status) &&  ($status == 'pending' || $status == 'reject')){
                                $data = array('status'=>$status,'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));
                                $datap = array('status'=>$status);
                                $this->common_model->updateDetails('tbl_tax_invc','tax_invc_id',$tax_invc_id,$data);
                                $this->common_model->updateDetails('tbl_tax_invc_items','tax_invc_id',$tax_invc_id,$datap);
                                $this->json->jsonReturn(array(
                                    'valid'=>TRUE, 
                                    'msg'=>'<div class="alert modify alert-success">Tax Invoice Status Changed Successfully!</div>'
                                ));
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Tax Invoice Status!!</div>'
                                ));
                            }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> Tax Invoice Items not found!!</div>'
                            ));
                        }
                    }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Tax Invoice Status !</div>'
                            ));
                        }
                    }
                    else
                    {
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Tax Invoice Status !</div>'
                        ));
                    }
            		}
                    else
                    {
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Tax Invoice Status !</div>'
                        ));
                    }
                }else{
                    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!!</div>'
                    ));
                }
            }else{
                $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!!</div>'
                ));
            }
        }else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!!</div>'
            ));
        }
        
    }
    public function approved_proforma_invoice_old()
    {  
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$proforma_id = $this->input->post('id');
        $data = array('status'=>'Approved','approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
        $data1 = array('status'=>'Approved');
        $result = $this->common_model->updateDetails('tbl_proforma_invc','proforma_id',$proforma_id,$data);
        $result = $this->common_model->updateDetails('tbl_proforma_invc_items','proforma_id',$proforma_id,$data1);
        if($result)
        {
            $this->json->jsonReturn(array(
                'valid'=>TRUE, 
                'msg'=>'<div class="alert modify alert-success"><strong></strong> Proforma Invoice Approved Successfully!</div>'
            ));
        }
        else
        {
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Approved Proforma Invoice!</div>'
            ));
        }
		}
        else
        {
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Approved Proforma Invoice!</div>'
            ));
        }
    }
    
    public function approved_boq_details()
    {  
        $save_stock_arr = $update_stock_arr = $save_exceptional_arr = array();
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_boq_details');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $boq_items_id = $this->input->post('id');
                    if(isset($boq_items_id) && !empty($boq_items_id) && $boq_items_id > 0){
                    $boq_items_id = $boq_items_id;    
                    }else{
                    $boq_items_id = 0;
                    }
                    $boq_items_data=$this->common_model->selectDetailsWhr('tbl_boq_items','boq_items_id',$boq_items_id);
                    if(isset($boq_items_data) && !empty($boq_items_data)){
                        if(isset($boq_items_data->status) && !empty($boq_items_data->status) && $boq_items_data->status !='approved'){
                        if(isset($boq_items_data->boq_items_id) && !empty($boq_items_data->boq_items_id)) { $boq_items_id = $boq_items_data->boq_items_id; }else { $boq_items_id = 0; }			
                        if(isset($boq_items_data->project_id) && !empty($boq_items_data->project_id)) { $project_id = $boq_items_data->project_id; }else { $project_id = 0; }			
                        if(isset($boq_items_data->boq_code) && !empty($boq_items_data->boq_code)) { $boq_code = $boq_items_data->boq_code; }else { $boq_code = ''; }			
                        if(isset($boq_items_data->hsn_sac_code) && !empty($boq_items_data->hsn_sac_code)) { $hsn_sac_code = $boq_items_data->hsn_sac_code; }else { $hsn_sac_code = ''; }			
                        if(isset($boq_items_data->item_description) && !empty($boq_items_data->item_description)) { $item_description = $boq_items_data->item_description; }else { $item_description = ''; }			
                        if(isset($boq_items_data->unit) && !empty($boq_items_data->unit)) { $unit = $boq_items_data->unit; }else { $unit = ''; }			
                        if(isset($boq_items_data->rate_basic) && !empty($boq_items_data->rate_basic)) { $rate_basic = $boq_items_data->rate_basic; }else { $rate_basic = 0; }			
                        if(isset($boq_items_data->gst) && !empty($boq_items_data->gst)) { $gst = $boq_items_data->gst; }else { $gst = 0; }			
                        if(isset($boq_items_data->scheduled_qty) && !empty($boq_items_data->scheduled_qty)) { $scheduled_qty = $boq_items_data->scheduled_qty; }else { $scheduled_qty = 0; }			
                        if(isset($boq_items_data->o_design_qty) && !empty($boq_items_data->o_design_qty)) { $o_design_qty = $boq_items_data->o_design_qty; }else { $o_design_qty = 0; }			
                        if(isset($boq_items_data->upload_design_qty) && !empty($boq_items_data->upload_design_qty)) { $design_qty = $boq_items_data->upload_design_qty; }else { $design_qty = 0; }			
                        if(isset($boq_items_data->non_schedule) && !empty($boq_items_data->non_schedule)) { $non_schedule = $boq_items_data->non_schedule; }else { $non_schedule = 'N'; }			
                        if(isset($boq_items_data->transaction_id) && !empty($boq_items_data->transaction_id)) { $transaction_id = $boq_items_data->transaction_id; }else { $transaction_id = 0; }			
                        if(isset($boq_items_data->design_qty) && !empty($boq_items_data->design_qty)) { $chk_design_qty = $boq_items_data->design_qty; }else { $chk_design_qty = 0; }			
                            
                        //check BOQ Exceptional Pending
                        $BOQPendingExceptional = $this->admin_model->getBOQPendingExceptional($project_id,$boq_code);
                        if(isset($BOQPendingExceptional) && empty($BOQPendingExceptional)){
                            
                            //get last approved boq item design qty
                            $last_design_qty = 0;
                            $last_boq_item_data = $this->admin_model->get_approved_boq_item_details($project_id,$boq_code);
                            if(isset($last_boq_item_data->design_qty) && !empty($last_boq_item_data->design_qty)){
                                $last_design_qty = $last_boq_item_data->design_qty;
                            }
                            $ea_qty = 0;
                            if($last_design_qty == 0){
                                $ea_qty = $design_qty - $scheduled_qty;   
                            }elseif($last_design_qty > 0){
                                if($design_qty > $last_design_qty){
                                    $ea_qty = $design_qty - $last_design_qty;    
                                }else{
                                    $ea_qty = $design_qty - $scheduled_qty;    
                                }    
                            }
                            $except_type='';
                            if($ea_qty > 0 && $non_schedule == 'N'){ //positive EA
                                $except_type = 'positive';
                            }elseif($ea_qty < 0){ //negative EA
                                $except_type = 'negative';
                            }elseif($ea_qty > 0 && $non_schedule == 'Y'){ //NS EA
                                $except_type = 'ns_yes';
                            }
                            if(isset($except_type) && !empty($except_type) && $design_qty > 0){
                                $save_exceptional_arr = array('exceptional_id'=>0,'boq_items_id'=>$boq_items_id,
                                'project_id'=>$project_id,'boq_code'=>$boq_code,'hsn_sac_code'=>$hsn_sac_code,
                                'item_description'=>$item_description,'unit'=>$unit,
                                'scheduled_qty'=>$scheduled_qty,'o_design_qty'=>$o_design_qty,'design_qty'=>$design_qty,
                                'non_schedule'=>$non_schedule,'rate_basic'=>$rate_basic,'gst'=>$gst,'EA_qty'=>$ea_qty,
                                'PO_taxable_amt'=>0,'gst_rate'=>0,'gst_amount'=>0,'po_final_amount'=>0,'po_doc'=>'','display'=>'Y',
                                'created_at'=>date('Y-m-d H:i:s'), 'created_by'=>$loguser_id,'billable'=>'Y','except_type'=>$except_type);
                            }
                            $check_stock_details = $this->admin_model->check_stock_details($boq_items_data->project_id,$boq_items_data->boq_code);
                            if(isset($check_stock_details) && empty($check_stock_details) && $chk_design_qty > 0){
                                if($chk_design_qty > $scheduled_qty){
                                    $save_stock_arr = array('project_id'=>$boq_items_data->project_id,'boq_code'=>$boq_items_data->boq_code,
                                    'total_stock'=>$scheduled_qty,'dc_total_stock'=>$scheduled_qty,'dc_stock'=>$scheduled_qty,
                                    'updated_by'=>$loguser_id,'updated_date'=>date('Y-m-d H:i:s'));  
                                }else{
                                    $save_stock_arr = array('project_id'=>$boq_items_data->project_id,'boq_code'=>$boq_items_data->boq_code,
                                    'total_stock'=>$chk_design_qty,'dc_total_stock'=>$chk_design_qty,'dc_stock'=>$chk_design_qty,
                                    'updated_by'=>$loguser_id,'updated_date'=>date('Y-m-d H:i:s'));  
                                }
                            }
                            if(isset($save_exceptional_arr) && !empty($save_exceptional_arr)){
                                $this->common_model->addData('tbl_boq_exceptional',$save_exceptional_arr);
                            }
                            if(isset($save_stock_arr) && !empty($save_stock_arr)){
                                $this->common_model->addData('tbl_boq_stock',$save_stock_arr);
                            }
                            $data = array('status'=>'Y','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
                            $this->common_model->updateDetails('tbl_boq_items','boq_items_id',$boq_items_id,$data);
                            if(isset($transaction_id) && !empty($transaction_id) && $transaction_id > 0){
                            $dataTrans = array('status'=>'approved','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
                            $this->common_model->updateDetails('tbl_boq_transactions','id',$transaction_id,$dataTrans);
                            }
                            $this->json->jsonReturn(array(
                                'valid'=>TRUE, 
                                'msg'=>'<div class="alert modify alert-success">BOQ Item Details Details Approved Successfully!</div>'
                            ));
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> BOQ Exceptional Approval Pending for this BOQ Item!!</div>'
                            ));
                        }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> BOQ Item Already Approved!!</div>'
                            )); 
                        }
                    }else{
                       $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> Invalid BOQ Item Details!!</div>'
                        )); 
                    }
                }else{
        		    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
                    ));
        		}
            }else{
        		$this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
                ));
        	}
		}else{
        	$this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
            ));
        }
    }
    public function approved_installed_wip()
    {  
        // pr($_POST);
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_installed_wip');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $update_stock_arr = array();
                    $user_id = $this->session->userData('user_id');
            		if(isset($user_id) && !empty($user_id)){
            		$i_wip_id = $this->input->post('id');
                    $status = $this->input->post('status');
                    $InstalledWIPDetails = $this->common_model->selectDetailsWhr('tbl_installed_wip','i_wip_id',$i_wip_id);
                    if(isset($InstalledWIPDetails) && !empty($InstalledWIPDetails) && isset($status) && !empty($status)){ 
                    if(isset($InstalledWIPDetails->status) && !empty($InstalledWIPDetails->status) && $InstalledWIPDetails->status!='approved'){   
                        $project_id = 0;
                        if(isset($InstalledWIPDetails->project_id) && !empty($InstalledWIPDetails->project_id)){   
                            $project_id = $InstalledWIPDetails->project_id;
                        }
                        $install_wip_items = $this->common_model->selectDetailsWhereAllDY('tbl_install_wip_items', 'i_wip_id',$i_wip_id);
                        if(isset($install_wip_items) && !empty($install_wip_items)){
                            $project_id_arr = $boq_code_arr = array();
                            foreach($install_wip_items as $key){
                                if(isset($project_id) && !empty($project_id) && isset($key->boq_code) && !empty($key->boq_code)){
                                    $project_id_arr[] = $project_id;
                                    $boq_code_arr[] = $key->boq_code;
                                }
                            }
                            $BOQStockArr = array();
                            if(isset($project_id_arr) && !empty($project_id_arr) && isset($boq_code_arr) && !empty($boq_code_arr)){
                                $project_ids = "'" . implode ( "', '", $project_id_arr ) . "'";
                                $boq_codes = "'" . implode ( "', '", $boq_code_arr ) . "'";
                                $BOQStockArr=$this->common_model->getBOQStockBulkDetails($project_ids,$boq_codes);
                            }
                            foreach($install_wip_items as $key){
                                if(isset($project_id) && !empty($project_id) && isset($key->boq_code) && !empty($key->boq_code)){
                                    $boq_code = $key->boq_code;
                                    if(isset($BOQStockArr[$project_id.'-'.$boq_code]) && !empty($BOQStockArr[$project_id.'-'.$boq_code])){
                                        $installed_stock_val = 0;
                                        $installed_stock = 0;
                                        if(isset($BOQStockArr[$project_id.'-'.$boq_code]['installed']) && $BOQStockArr[$project_id.'-'.$boq_code]['installed'] >= 0){
                                            $installed_stock = $BOQStockArr[$project_id.'-'.$boq_code]['installed'];
                                        }
                                        $total_installed_val = 0;
                                        $total_installed = 0;
                                        if(isset($BOQStockArr[$project_id.'-'.$boq_code]['total_installed']) && $BOQStockArr[$project_id.'-'.$boq_code]['total_installed'] >= 0){
                                            $total_installed = $BOQStockArr[$project_id.'-'.$boq_code]['total_installed'];
                                        }
                                        $dc_approved=0;
                                        $dc_approved_val=0;
                                        if(isset($BOQStockArr[$project_id.'-'.$boq_code]['dc_approved']) && $BOQStockArr[$project_id.'-'.$boq_code]['dc_approved'] >= 0){
                                            $dc_approved = $BOQStockArr[$project_id.'-'.$boq_code]['dc_approved'];
                                        }
                                        $installed_qty = 0;
                                        if(isset($key->installed_qty) && !empty($key->installed_qty) && $key->installed_qty > 0){
                                            $installed_qty = $key->installed_qty;
                                        }
                                        //   pr($dc_approved);
                                        //     pr($installed_qty,1);
                                        if(isset($status) && !empty($status) && $status == 'approved'){
                                            if(isset($dc_approved)  && $dc_approved >= $installed_qty && $installed_qty > 0){
                                                $total_installed_val = $total_installed + $installed_qty;
                                                $installed_stock_val = $installed_stock + $installed_qty;
                                                $dc_approved_val = $dc_approved - $installed_qty;
                                                $update_stock_arr[] = array('boq_code'=>$key->boq_code,'total_installed'=>$total_installed_val,'installed'=>$installed_stock_val,
                                                'dc_approved'=>$dc_approved_val,'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));
                                            }
                                         
                                        }
                                    }
                                }    
                            }
                            // pr($update_stock_arr,1);
                            if(isset($status) && !empty($status) && $status == 'approved'){
                                 if(isset($update_stock_arr)  && $project_id > 0){
                                // if(isset($update_stock_arr) && !empty($update_stock_arr) && $project_id > 0){
                                    $data = array('status'=>$status,'approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
                                    $datap = array('status'=>$status);
                                    $this->common_model->updateDetails('tbl_installed_wip','i_wip_id',$i_wip_id,$data);
                                    $this->common_model->updateDetails('tbl_install_wip_items','i_wip_id',$i_wip_id,$datap);
                                    $this->common_model->updateBOQInstallStock($update_stock_arr,$project_id);
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE,
                                        'msg'=>'<div class="alert modify alert-success">Installed WIP Status Changed Successfully!</div>'
                                    ));
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> Stock not Available! While Change Installed WIP Status !</div>'
                                    ));
                                }
                            }elseif(isset($status) && !empty($status) && ($status == 'pending' || $status == 'reject')){
                                $data = array('status'=>$status,'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));
                                $datap = array('status'=>$status);
                                $this->common_model->updateDetails('tbl_installed_wip','i_wip_id',$i_wip_id,$data);
                                $this->common_model->updateDetails('tbl_install_wip_items','i_wip_id',$i_wip_id,$datap);
                                $this->json->jsonReturn(array(
                                    'valid'=>TRUE,
                                    'msg'=>'<div class="alert modify alert-success">Installed WIP Status Changed Successfully!</div>'
                                ));
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Installed WIP Status !</div>'
                                ));
                            }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Installed WIP Status !</div>'
                            ));
                        }
                    }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Installed WIP Status !</div>'
                            ));
                        }
                    }
                    else
                    {
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Installed WIP Status !</div>'
                        ));
                    }
            		}
                    else
                    {
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Installed WIP Status !</div>'
                        ));
                    }
                }else{
        		    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
                    ));
        		}
            }else{
    		    $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
                ));
    		}
		}else{
		    $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
            ));
		}
		
    }
    public function approved_delivery_challan()
    {  
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_delivery_challan');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $update_stock_arr = array();
                    $user_id = $this->session->userData('user_id');
            		if(isset($user_id) && !empty($user_id)){
            		$challan_id = $this->input->post('id');
                    $status = $this->input->post('status');
                    $dccDetails = $this->admin_model->getDCCDetails($challan_id);
                    if(isset($dccDetails) && !empty($dccDetails) && isset($status) && !empty($status)){ 
                    $existstatus = $this->admin_model->getDccStatusID($challan_id);
                    if(isset($existstatus) && !empty($existstatus) && $existstatus!='approved'){   
                        $project_id = 0;
                        if(isset($dccDetails->project_id) && !empty($dccDetails->project_id)){   
                            $project_id = $dccDetails->project_id;
                        }
                        if(isset($dccDetails->transaction_id) && !empty($dccDetails->transaction_id)){
                                if(isset($status) && !empty($status) && $status == 'approved'){
                                    $Transdata = array('status'=>$status,'approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
                                }else{
                                    $Transdata = array('status'=>$status,'approved_by'=>0,'approved_date'=>'',
                                    'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));
                                }
                                $this->common_model->updateDetails('tbl_boq_transactions','id',$dccDetails->transaction_id,$Transdata);
                            }
                        if(isset($status) && !empty($status) && $status == 'approved'){
                            $deliv_challan_items = $this->common_model->selectDetailsWhereAllDY('tbl_deliv_challan_items', 'challan_id',$challan_id);
                            if(isset($deliv_challan_items) && !empty($deliv_challan_items)){
                                $project_id_arr = $boq_code_arr = array();
                                foreach($deliv_challan_items as $key){
                                    if(isset($project_id) && !empty($project_id) && isset($key->boq_code) && !empty($key->boq_code)){
                                        $project_id_arr[] = $project_id;
                                        $boq_code_arr[] = $key->boq_code;
                                    }
                                }
                                $BOQStockArr = array();
                                if(isset($project_id_arr) && !empty($project_id_arr) && isset($boq_code_arr) && !empty($boq_code_arr)){
                                    $project_ids = "'" . implode ( "', '", $project_id_arr ) . "'";
                                    $boq_codes = "'" . implode ( "', '", $boq_code_arr ) . "'";
                                    $BOQStockArr=$this->common_model->getBOQStockBulkDetails($project_ids,$boq_codes);
                                }
                                foreach($deliv_challan_items as $key){
                                    if(isset($project_id) && !empty($project_id) && isset($key->boq_code) && !empty($key->boq_code)){
                                        $boq_code = $key->boq_code;
                                        if(isset($BOQStockArr[$project_id.'-'.$boq_code]) && !empty($BOQStockArr[$project_id.'-'.$boq_code])){
                                            $dc_approved_val = 0;
                                            $dc_approved = 0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['dc_approved']) && $BOQStockArr[$project_id.'-'.$boq_code]['dc_approved'] >= 0){
                                                $dc_approved = $BOQStockArr[$project_id.'-'.$boq_code]['dc_approved'];
                                            }
                                            $dc_stock_val = 0;
                                            $dc_stock = 0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['dc_stock']) && $BOQStockArr[$project_id.'-'.$boq_code]['dc_stock'] >= 0){
                                                $dc_stock = $BOQStockArr[$project_id.'-'.$boq_code]['dc_stock'];
                                            }
                                            $qty = 0;
                                            if(isset($key->qty) && !empty($key->qty) && $key->qty > 0){
                                                $qty = $key->qty;
                                            } 
                                            if($qty > 0 && $dc_stock >= $qty){
                                                $dc_approved_val = $dc_approved + $qty;
                                                $dc_stock_val = $dc_stock - $qty;
                                            }
                                            $update_stock_arr[] = array('boq_code'=>$key->boq_code,'dc_approved'=>$dc_approved_val,
                                            'dc_stock'=>$dc_stock_val,'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));
                                        }
                                    }    
                                }
                                if(isset($update_stock_arr) && !empty($update_stock_arr)){
                                    $this->common_model->updateBOQInstallStock($update_stock_arr,$project_id);
                                    $data = array('status'=>$status,'approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
                                    $datap = array('status'=>$status);
                                    $result = $this->common_model->updateDetails('tbl_delivery_challan','challan_id',$challan_id,$data);
                                    $result = $this->common_model->updateDetails('tbl_deliv_challan_items','challan_id',$challan_id,$datap);
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE, 
                                        'msg'=>'<div class="alert modify alert-success">Client Delivery Challan Status Changed Successfully!</div>'
                                    ));
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> Stock not Available!</div>'
                                    ));
                                }
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Client Delivery Challan Status !</div>'
                                ));
                            }
                        }elseif(isset($status) && !empty($status) && ($status == 'pending' || $status == 'reject')){
                            $data = array('status'=>$status,'approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
                            $datap = array('status'=>$status);
                            $result = $this->common_model->updateDetails('tbl_delivery_challan','challan_id',$challan_id,$data);
                            $result = $this->common_model->updateDetails('tbl_deliv_challan_items','challan_id',$challan_id,$datap);
                            $this->json->jsonReturn(array(
                                'valid'=>TRUE, 
                                'msg'=>'<div class="alert modify alert-success">Client Delivery Challan Status Changed Successfully!</div>'
                            ));
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Client Delivery Challan Status!</div>'
                            ));
                        }
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Client Delivery Challan Status!</div>'
                        ));
                    }
                }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Client Delivery Challan Status!</div>'
                        ));
                    }
            		}
                    else
                    {
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Client Delivery Challan Status !</div>'
                        ));
                    }
                }else{
        		    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!!</div>'
                    ));
        		}
            }else{
    		    $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!!</div>'
                ));
    		}
		}else{
		    $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!!</div>'
            ));
		}
		
    }
    
    
    public function approved_provisional_wip()
    {  
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_provisional_wip');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $update_stock_arr = array();
                    $user_id = $this->session->userData('user_id');
            		if(isset($user_id) && !empty($user_id)){
            		$p_wip_id = $this->input->post('id');
                    $status = $this->input->post('status');
                    $ProvisionalWIPDetails = $this->common_model->selectDetailsWhr('tbl_provisional_wip','p_wip_id',$p_wip_id);
                    if(isset($ProvisionalWIPDetails) && !empty($ProvisionalWIPDetails) && isset($status) && !empty($status)){ 
                        if(isset($ProvisionalWIPDetails->status) && !empty($ProvisionalWIPDetails->status) && $ProvisionalWIPDetails->status!='approved'){   
                            $project_id = 0;
                            if(isset($ProvisionalWIPDetails->project_id) && !empty($ProvisionalWIPDetails->project_id)){   
                                $project_id = $ProvisionalWIPDetails->project_id;
                            }
                            $prov_wip_items = $this->common_model->selectDetailsWhereAllDY('tbl_prov_wip_items', 'p_wip_id',$p_wip_id);
                            if(isset($prov_wip_items) && !empty($prov_wip_items)){
                                $project_id_arr = $boq_code_arr = array();
                                foreach($prov_wip_items as $key){
                                    if(isset($project_id) && !empty($project_id) && isset($key->boq_code) && !empty($key->boq_code)){
                                        $project_id_arr[] = $project_id;
                                        $boq_code_arr[] = $key->boq_code;
                                    }
                                }
                                $BOQStockArr = array();
                                if(isset($project_id_arr) && !empty($project_id_arr) && isset($boq_code_arr) && !empty($boq_code_arr)){
                                    $project_ids = "'" . implode ( "', '", $project_id_arr ) . "'";
                                    $boq_codes = "'" . implode ( "', '", $boq_code_arr ) . "'";
                                    $BOQStockArr=$this->common_model->getBOQStockBulkDetails($project_ids,$boq_codes);
                                }
                                foreach($prov_wip_items as $key){
                                    if(isset($project_id) && !empty($project_id) && isset($key->boq_code) && !empty($key->boq_code)){
                                        $boq_code = $key->boq_code;
                                        if(isset($BOQStockArr[$project_id.'-'.$boq_code]) && !empty($BOQStockArr[$project_id.'-'.$boq_code])){
                                            /*$dc_approved = 0;
                                            $dc_approved_val = 0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['dc_approved']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['dc_approved']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['dc_approved'] > 0){
                                                $dc_approved = $BOQStockArr[$project_id.'-'.$boq_code]['dc_approved'];
                                            }*/
                                            $total_stock = 0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['total_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['total_stock']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['total_stock'] > 0){
                                                $total_stock = $BOQStockArr[$project_id.'-'.$boq_code]['total_stock'];
                                            }
                                            $total_installed = 0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['total_installed']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['total_installed']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['total_installed'] > 0){
                                                $total_installed = $BOQStockArr[$project_id.'-'.$boq_code]['total_installed'];
                                            }
                                            $provisional = 0;
                                            $provisional_val = 0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['provisional']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['provisional']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['provisional'] > 0){
                                                $provisional = $BOQStockArr[$project_id.'-'.$boq_code]['provisional'];
                                            }
                                            $total_provisional = 0;
                                            $total_provisional_val = 0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['total_provisional']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['total_provisional']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['total_provisional'] > 0){
                                                $total_provisional = $BOQStockArr[$project_id.'-'.$boq_code]['total_provisional'];
                                            }
                                            $prov_qty=0;
                                            if(isset($key->prov_qty) && !empty($key->prov_qty) && $key->prov_qty > 0){
                                                $prov_qty = $key->prov_qty;
                                            }
                                            $prov_pending_qty = 0;
                                            if(isset($total_stock) && $total_stock > 0){
                                                if($total_stock > ($total_installed + $total_provisional)){
                                                    $prov_pending_qty = $total_stock - ($total_installed + $total_provisional);    
                                                }    
                                            }
                                            if(isset($status) && !empty($status) && $status == 'approved'){
                                                if(isset($prov_pending_qty) && !empty($prov_pending_qty) && $prov_pending_qty > 0 && $prov_qty > 0 && $prov_pending_qty >= $prov_qty){
                                                    $provisional_val = $provisional + $prov_qty;
                                                    $total_provisional_val = $total_provisional + $prov_qty;
                                                    $update_stock_arr[] = array('boq_code'=>$key->boq_code,'provisional'=>$provisional_val,'total_provisional'=>$total_provisional_val,
                                                    'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));
                                                }
                                            }
                                        }
                                    }    
                                }
                                if(isset($status) && !empty($status) && $status == 'approved'){
                                    if(isset($update_stock_arr) && !empty($update_stock_arr) && $project_id > 0){
                                        $data = array('status'=>$status,'approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
                                        $datap = array('status'=>$status);
                                        $this->common_model->updateDetails('tbl_provisional_wip','p_wip_id',$p_wip_id,$data);
                                        $this->common_model->updateDetails('tbl_prov_wip_items','p_wip_id',$p_wip_id,$datap);
                                        $this->common_model->updateBOQInstallStock($update_stock_arr,$project_id);
                                        $this->json->jsonReturn(array(
                                            'valid'=>TRUE,
                                            'msg'=>'<div class="alert modify alert-success">Provisional WIP Status Changed Successfully!</div>'
                                        ));
                                    }else{
                                        $this->json->jsonReturn(array(
                                            'valid'=>FALSE,
                                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> Stock not Available! While Change Provisional WIP Status !</div>'
                                        ));
                                    }
                                }elseif(isset($status) && !empty($status) && ($status == 'pending' || $status == 'reject')){
                                    $data = array('status'=>$status,'approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
                                    $datap = array('status'=>$status);
                                    $this->common_model->updateDetails('tbl_provisional_wip','p_wip_id',$p_wip_id,$data);
                                    $this->common_model->updateDetails('tbl_prov_wip_items','p_wip_id',$p_wip_id,$datap);
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Provisional WIP Status !</div>'
                                    ));
                                }
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Provisional WIP Status !</div>'
                                ));
                            }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> Provisional WIP Already Approved!</div>'
                            ));
                        }
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Provisional WIP Status !</div>'
                        ));
                    }
            		}else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Provisional WIP Status !</div>'
                        ));
                    }
                }else{
        		    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!!</div>'
                    ));
        		}
            }else{
    		    $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!!</div>'
                ));
    		}
		}else{
		    $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!!</div>'
            ));
		}
    }
    public function approved_proforma_invoice()
    {  
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_proforma_invoice');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $update_stock_arr = array();
                    $user_id = $this->session->userData('user_id');
            		if(isset($user_id) && !empty($user_id)){
            		$proforma_id = $this->input->post('id');
                    $status = $this->input->post('status');
                    $ProformaDetails = $this->common_model->selectDetailsWhr('tbl_proforma_invc','proforma_id',$proforma_id);
                    if(isset($ProformaDetails) && !empty($ProformaDetails) && isset($status) && !empty($status)){ 
                    if(isset($ProformaDetails->status) && !empty($ProformaDetails->status) && $ProformaDetails->status!='approved'){   
                        $project_id = 0;
                        if(isset($ProformaDetails->project_id) && !empty($ProformaDetails->project_id)){   
                            $project_id = $ProformaDetails->project_id;
                        }
                        $proforma_items = $this->common_model->selectDetailsWhereAllDY('tbl_proforma_invc_items', 'proforma_id',$proforma_id);
                        if(isset($proforma_items) && !empty($proforma_items)){
                            $project_id_arr = $boq_code_arr = array();
                            foreach($proforma_items as $key){
                                if(isset($project_id) && !empty($project_id) && isset($key->boq_code) && !empty($key->boq_code)){
                                    $project_id_arr[] = $project_id;
                                    $boq_code_arr[] = $key->boq_code;
                                }
                            }
                            $BOQStockArr = array();
                            if(isset($project_id_arr) && !empty($project_id_arr) && isset($boq_code_arr) && !empty($boq_code_arr)){
                                $project_ids = "'" . implode ( "', '", $project_id_arr ) . "'";
                                $boq_codes = "'" . implode ( "', '", $boq_code_arr ) . "'";
                                $BOQStockArr=$this->common_model->getBOQStockBulkDetails($project_ids,$boq_codes);
                            }
                            foreach($proforma_items as $key){
                                if(isset($project_id) && !empty($project_id) && isset($key->boq_code) && !empty($key->boq_code)){
                                    $boq_code = $key->boq_code;
                                    $proforma_from = '';
                                    if(isset($key->proforma_from) && !empty($key->proforma_from)){
                                    $proforma_from = $key->proforma_from;     
                                    }
                                    if(isset($BOQStockArr[$project_id.'-'.$boq_code]) && !empty($BOQStockArr[$project_id.'-'.$boq_code])){
                                        if($proforma_from == 'installed_stock'){
                                            $installed=0;
                                            $installed_val=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['installed']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['installed']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['installed'] > 0){
                                                $installed = $BOQStockArr[$project_id.'-'.$boq_code]['installed'];
                                            }
                                            $proforma_stock=0;
                                            $proforma_stock_val=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['proforma_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['proforma_stock']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['proforma_stock'] > 0){
                                                $proforma_stock = $BOQStockArr[$project_id.'-'.$boq_code]['proforma_stock'];
                                            }
                                            $total_stock=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['total_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['total_stock']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['total_stock'] > 0){
                                                $total_stock = $BOQStockArr[$project_id.'-'.$boq_code]['total_stock'];
                                            }
                                            $qty=0;
                                            if(isset($key->qty) && !empty($key->qty) && $key->qty > 0){
                                                $qty = $key->qty;    
                                            }
                                            if(isset($status) && !empty($status) && $status == 'approved'){
                                                if($total_stock > $proforma_stock){
                                                if(isset($installed) && !empty($installed) && $installed > 0 && $qty > 0 && $installed >= $qty){
                                                    $proforma_stock_val = $proforma_stock + $qty;
                                                    $installed_val = $installed - $qty;
                                                    $update_stock_arr[] = array('boq_code'=>$key->boq_code,'proforma_stock'=>$proforma_stock_val,
                                                    'installed'=>$installed_val,'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));
                                                }
                                                }
                                            }
                                        }elseif($proforma_from == 'provisional_stock'){
                                            $provisional=0;
                                            $provisional_val=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['provisional']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['provisional']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['provisional'] > 0){
                                                $provisional = $BOQStockArr[$project_id.'-'.$boq_code]['provisional'];
                                            }
                                            $proforma_stock=0;
                                            $proforma_stock_val=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['proforma_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['proforma_stock']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['proforma_stock'] > 0){
                                                $proforma_stock = $BOQStockArr[$project_id.'-'.$boq_code]['proforma_stock'];
                                            }
                                            $total_stock=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['total_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['total_stock']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['total_stock'] > 0){
                                                $total_stock = $BOQStockArr[$project_id.'-'.$boq_code]['total_stock'];
                                            }
                                            $qty=0;
                                            if(isset($key->qty) && !empty($key->qty) && $key->qty > 0){
                                                $qty = $key->qty;    
                                            }
                                            if(isset($status) && !empty($status) && $status == 'approved'){
                                                if($total_stock > $proforma_stock){
                                                if(isset($provisional) && !empty($provisional) && $provisional > 0 && $qty > 0 && $provisional >= $qty){
                                                    $proforma_stock_val = $proforma_stock + $qty;
                                                    $provisional_val = $provisional - $qty;
                                                    $update_stock_arr[] = array('boq_code'=>$key->boq_code,'proforma_stock'=>$proforma_stock_val,
                                                    'provisional'=>$provisional_val,'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));
                                                }
                                                }
                                            }
                                        }elseif($proforma_from == 'both'){
                                            $installed=0;
                                            $installed_val=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['installed']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['installed']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['installed'] > 0){
                                                $installed = $BOQStockArr[$project_id.'-'.$boq_code]['installed'];
                                            }
                                            
                                            $provisional=0;
                                            $provisional_val=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['provisional']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['provisional']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['provisional'] > 0){
                                                $provisional = $BOQStockArr[$project_id.'-'.$boq_code]['provisional'];
                                            }
                                            
                                            $proforma_stock=0;
                                            $proforma_stock_val=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['proforma_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['proforma_stock']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['proforma_stock'] > 0){
                                                $proforma_stock = $BOQStockArr[$project_id.'-'.$boq_code]['proforma_stock'];
                                            }
                                            $total_stock=0;
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]['total_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['total_stock']) 
                                            && $BOQStockArr[$project_id.'-'.$boq_code]['total_stock'] > 0){
                                                $total_stock = $BOQStockArr[$project_id.'-'.$boq_code]['total_stock'];
                                            }
                                            $final_qty=0;
                                            $final_qty = $installed + $provisional;  
                                            $qty=0;
                                            if(isset($key->qty) && !empty($key->qty) && $key->qty > 0){
                                                $qty = $key->qty;    
                                            }
                                            if(isset($status) && !empty($status) && $status == 'approved'){
                                                if($total_stock > $proforma_stock){
                                                if(isset($final_qty) && !empty($final_qty) && $final_qty > 0 && $qty > 0 && $final_qty >= $qty){
                                                    $remaining_qty = 0;
                                                    if($qty >= $installed){
                                                        $remaining_qty = $qty - $installed;      
                                                    }
                                                    if($provisional >= $remaining_qty){
                                                        $provisional_val = $provisional - $remaining_qty;      
                                                    }
                                                    $proforma_stock_val = $proforma_stock + $qty;
                                                    $update_stock_arr[] = array('boq_code'=>$key->boq_code,'proforma_stock'=>$proforma_stock_val,'installed'=>0,
                                                    'provisional'=>$provisional_val,'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));
                                                }
                                                }
                                            }
                                        }
                                    }
                                }    
                            }
                            if(isset($status) && !empty($status) && $status == 'approved'){
                                if(isset($update_stock_arr) && !empty($update_stock_arr) && $project_id > 0){
                                    $this->common_model->updateBOQInstallStock($update_stock_arr,$project_id);
                                    $data = array('status'=>$status,'approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
                                    $datap = array('status'=>$status);
                                    $result = $this->common_model->updateDetails('tbl_proforma_invc','proforma_id',$proforma_id,$data);
                                    $result = $this->common_model->updateDetails('tbl_proforma_invc_items','proforma_id',$proforma_id,$datap);
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE, 
                                        'msg'=>'<div class="alert modify alert-success">Proforma Invoice Status Changed Successfully!</div>'
                                    ));
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> Proforma Invoice Items out of stock!!</div>'
                                    ));
                                }
                            }elseif(isset($status) && !empty($status) && ($status == 'pending' || $status == 'reject')){
                                $data = array('status'=>$status,'approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
                                $datap = array('status'=>$status);
                                $result = $this->common_model->updateDetails('tbl_proforma_invc','proforma_id',$proforma_id,$data);
                                $result = $this->common_model->updateDetails('tbl_proforma_invc_items','proforma_id',$proforma_id,$datap);
                                $this->json->jsonReturn(array(
                                    'valid'=>TRUE, 
                                    'msg'=>'<div class="alert modify alert-success">Proforma Invoice Status Changed Successfully!</div>'
                                ));
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Proforma Invoice Status!!</div>'
                                ));
                            }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> Proforma Invoice Items not found!!</div>'
                            ));
                        }
                    }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Proforma Invoice Status !</div>'
                            ));
                        }
                    }
                    else
                    {
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Proforma Invoice Status !</div>'
                        ));
                    }
            		}
                    else
                    {
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Change Proforma Invoice Status !</div>'
                        ));
                    }
                }else{
        		    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!!</div>'
                    ));
        		}
            }else{
    		    $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!!</div>'
                ));
    		}
        }else{
		    $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!!</div>'
            ));
		}
        
    }
    
    
    public function approve_boq_exceptional_approval()
    {  
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
        
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approve_boq_exceptional_approval');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $update_stock_arr = $updateNewBOQItemArr = $save_stock_arr = $updateDesignQtyArr = array();
                    $user_id = $this->session->userData('user_id');
            		if(isset($user_id) && !empty($user_id)){
            		$exceptional_id = $this->input->post('id');
                    $status = $this->input->post('status');
                    $exceptionalDetails = $this->admin_model->getExceptionalDetails($exceptional_id);
                 
                    if(isset($exceptionalDetails) && !empty($exceptionalDetails) && isset($status) && !empty($status)){ 
                    $existstatus = $this->admin_model->getExceptionalStatusID($exceptional_id);
                    if(isset($existstatus) && !empty($existstatus) && $existstatus!='approved'){   
                        $project_id = 0;
                        $project_id = $this->admin_model->getExceptionalProjectID($exceptional_id);
                        if(isset($project_id) && !empty($project_id)){   
                            $project_id = $project_id;
                        }
                        if(isset($exceptionalDetails[0]->transaction_id) && !empty($exceptionalDetails[0]->transaction_id)){
                            if(isset($status) && !empty($status) && $status == 'approved'){
                                $Transdata = array('status'=>$status,'approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
                            }else{
                                $Transdata = array('status'=>$status,'approved_by'=>0,'approved_date'=>'',
                                'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));
                            }
                            $this->common_model->updateDetails('tbl_boq_transactions','id',$exceptionalDetails[0]->transaction_id,$Transdata);
                        }
                            $boq_items_id_arr = $project_id_arr = $boq_code_arr = array();
                            foreach($exceptionalDetails as $getExceptionalDetails){
                                if(isset($getExceptionalDetails->boq_items_id) && !empty($getExceptionalDetails->boq_items_id) 
                                && $getExceptionalDetails->boq_items_id > 0){
                                    $boq_items_id_arr[] = $getExceptionalDetails->boq_items_id;     
                                }
                                if(isset($getExceptionalDetails->project_id) && !empty($getExceptionalDetails->project_id) 
                                && isset($getExceptionalDetails->boq_code) && !empty($getExceptionalDetails->boq_code)){
                                    $project_id_arr[] = $getExceptionalDetails->project_id;     
                                    $boq_code_arr[] = $getExceptionalDetails->boq_code;     
                                }
                            }
                            $boqItemsData = array();
                            if(isset($boq_items_id_arr) && !empty($boq_items_id_arr)){
                                $boq_items_ids = implode(',',$boq_items_id_arr);
                                $boqItemsData=$this->common_model->getBOQItemBulkDetails($boq_items_ids);
                            }
                            $BOQStockArr = array();
                            if(isset($project_id_arr) && !empty($project_id_arr) && isset($boq_code_arr) && !empty($boq_code_arr)){
                                $project_ids = "'" . implode ( "', '", $project_id_arr ) . "'";
                                $boq_codes = "'" . implode ( "', '", $boq_code_arr ) . "'";
                                $BOQStockArr=$this->common_model->getBOQStockBulkDetails($project_ids,$boq_codes);
                            }
                            //check stock available
                            $allowed='Y';
                            foreach($exceptionalDetails as $getExceptionalDetails){
                                if(isset($getExceptionalDetails->project_id) && !empty($getExceptionalDetails->project_id) 
                                && isset($getExceptionalDetails->boq_code) && !empty($getExceptionalDetails->boq_code)){
                                    $project_id = $getExceptionalDetails->project_id;
                                    $boq_code = $getExceptionalDetails->boq_code;
                                    
                                    if(isset($BOQStockArr[$project_id.'-'.$boq_code]) && !empty($BOQStockArr[$project_id.'-'.$boq_code])){
                                        $dc_stock=0;
                                        if(isset($BOQStockArr[$project_id.'-'.$boq_code]['dc_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['dc_stock']) 
                                        && $BOQStockArr[$project_id.'-'.$boq_code]['dc_stock'] > 0){
                                            $dc_stock = $BOQStockArr[$project_id.'-'.$boq_code]['dc_stock'];
                                        }
                                        if(isset($getExceptionalDetails->EA_qty) && !empty($getExceptionalDetails->EA_qty) 
                                        && $getExceptionalDetails->EA_qty < 0){
                                            if($dc_stock < abs($getExceptionalDetails->EA_qty)){
                                                $allowed='N';    
                                            }
                                        }
                                    }else{
                                        if(isset($getExceptionalDetails->scheduled_qty) && !empty($getExceptionalDetails->scheduled_qty) 
                                        && $getExceptionalDetails->scheduled_qty < abs($getExceptionalDetails->EA_qty) && $getExceptionalDetails->EA_qty < 0){
                                            $allowed='N';    
                                        }
                                    }
                                }
                            }
                            if(isset($status) && !empty($status) && $status == 'approved'){
                                $NewBOQItemArr = array();

                                foreach($exceptionalDetails as $getExceptionalDetails){
                                    $project_id = $getExceptionalDetails->project_id;
                                    $boq_code = $getExceptionalDetails->boq_code;
                                    if(isset($project_id) && !empty($project_id)
                                    && isset($boq_code) && !empty($boq_code)){
                                        $update_qty=0;
                                        if(isset($getExceptionalDetails->EA_qty) && !empty($getExceptionalDetails->EA_qty) 
                                        && $getExceptionalDetails->EA_qty > 0){
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]) && !empty($BOQStockArr[$project_id.'-'.$boq_code])){
                                                $dc_stock=0;
                                                if(isset($BOQStockArr[$project_id.'-'.$boq_code]['dc_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['dc_stock']) 
                                                && $BOQStockArr[$project_id.'-'.$boq_code]['dc_stock'] > 0){
                                                    $dc_stock = $BOQStockArr[$project_id.'-'.$boq_code]['dc_stock'];
                                                }
                                                $update_qty = $dc_stock + $getExceptionalDetails->EA_qty;
                                            }else{
                                                $update_qty = $getExceptionalDetails->scheduled_qty + $getExceptionalDetails->EA_qty;
                                            }
                                        }elseif(isset($getExceptionalDetails->EA_qty) && !empty($getExceptionalDetails->EA_qty) 
                                        && $getExceptionalDetails->EA_qty < 0){
                                            // check stock available
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]) && !empty($BOQStockArr[$project_id.'-'.$boq_code])){
                                                $dc_stock=0;
                                                if(isset($BOQStockArr[$project_id.'-'.$boq_code]['dc_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['dc_stock']) 
                                                && $BOQStockArr[$project_id.'-'.$boq_code]['dc_stock'] > 0){
                                                    $dc_stock = $BOQStockArr[$project_id.'-'.$boq_code]['dc_stock'];
                                                }
                                                if($dc_stock >= abs($getExceptionalDetails->EA_qty)){
                                                    $update_qty = $dc_stock - abs($getExceptionalDetails->EA_qty);    
                                                }
                                            }else{
                                                if(isset($getExceptionalDetails->scheduled_qty) && !empty($getExceptionalDetails->scheduled_qty) 
                                                && $getExceptionalDetails->scheduled_qty >= abs($getExceptionalDetails->EA_qty)){
                                                    $update_qty = $getExceptionalDetails->scheduled_qty - abs($getExceptionalDetails->EA_qty);
                                                }
                                            }
                                        }
                                        if(isset($getExceptionalDetails->newAdd) && !empty($getExceptionalDetails->newAdd) 
                                        && $getExceptionalDetails->newAdd == 1){
                                            if(isset($update_qty) && $update_qty >= 0 && $getExceptionalDetails->billable == 'Y'){
                                                if(isset($getExceptionalDetails->boq_items_id) && !empty($getExceptionalDetails->boq_items_id) 
                                                && $getExceptionalDetails->boq_items_id > 0){
                                                    $boq_items_id = $getExceptionalDetails->boq_items_id;    
                                                }else{
                                                    $boq_items_id = 0;
                                                }
                                                if(isset($boqItemsData[$boq_items_id]) && !empty($boqItemsData[$boq_items_id])){
                                                    $boqItemsData[$boq_items_id]['steps'] = 0;
                                                    $boqItemsData[$boq_items_id]['created_on'] = date('Y-m-d H:i:s');
                                                    $boqItemsData[$boq_items_id]['created_by'] = $user_id;
                                                    $boqItemsData[$boq_items_id]['approved_date'] = date('Y-m-d H:i:s');
                                                    $boqItemsData[$boq_items_id]['approved_by'] = $user_id;
                                                    $boqItemsData[$boq_items_id]['addFromEA'] = 1;
                                                    $boqItemsData[$boq_items_id]['status'] = 'Y';
                                                    $boqItemsData[$boq_items_id]['design_qty'] = $update_qty;
                                                    $NewBOQItemArr[] = $boqItemsData[$boq_items_id]; 
                                                }
                                            }
                                        }
                                        if($getExceptionalDetails->billable == 'Y' && $update_qty >= 0){
                                            if(isset($getExceptionalDetails->boq_items_id) && !empty($getExceptionalDetails->boq_items_id) 
                                            && $getExceptionalDetails->boq_items_id > 0){
                                                $boq_items_id = $getExceptionalDetails->boq_items_id;    
                                            }else{
                                                $boq_items_id = 0;
                                            }
                                            if(isset($boqItemsData[$boq_items_id]) && !empty($boqItemsData[$boq_items_id])){
                                                $updateDesignQtyArr[] = array('boq_items_id'=>$boq_items_id,'design_qty'=>$update_qty,
                                                'modified_by'=>$user_id, 'modified_on'=>date('Y-m-d H:i:s'));
                                            }
                                            if(isset($BOQStockArr[$project_id.'-'.$boq_code]) && !empty($BOQStockArr[$project_id.'-'.$boq_code])){
                                                $total_stock=0;
                                                $total_stock_val = 0;
                                                if(isset($BOQStockArr[$project_id.'-'.$boq_code]['total_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['total_stock']) 
                                                && $BOQStockArr[$project_id.'-'.$boq_code]['total_stock'] > 0){
                                                    $total_stock = $BOQStockArr[$project_id.'-'.$boq_code]['total_stock'];
                                                }
                                                if($getExceptionalDetails->EA_qty > 0){
                                                    $total_stock_val = $total_stock + $getExceptionalDetails->EA_qty;  
                                                }elseif($getExceptionalDetails->EA_qty < 0){
                                                    $total_stock_val = $total_stock - abs($getExceptionalDetails->EA_qty);  
                                                }
                                                
                                                $dc_total_stock=0;
                                                $dc_total_stock_val=0;
                                                if(isset($BOQStockArr[$project_id.'-'.$boq_code]['dc_total_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['dc_total_stock']) 
                                                && $BOQStockArr[$project_id.'-'.$boq_code]['dc_total_stock'] > 0){
                                                    $dc_total_stock = $BOQStockArr[$project_id.'-'.$boq_code]['dc_total_stock'];
                                                }
                                                if($getExceptionalDetails->EA_qty > 0){
                                                    $dc_total_stock_val = $dc_total_stock + $getExceptionalDetails->EA_qty;
                                                }elseif($getExceptionalDetails->EA_qty < 0){
                                                    $dc_total_stock_val = $dc_total_stock - abs($getExceptionalDetails->EA_qty);
                                                }
                                             
                                                $dc_stock=0;
                                                $dc_stock_val=0;
                                                if(isset($BOQStockArr[$project_id.'-'.$boq_code]['dc_stock']) && !empty($BOQStockArr[$project_id.'-'.$boq_code]['dc_stock']) 
                                                && $BOQStockArr[$project_id.'-'.$boq_code]['dc_stock'] > 0){
                                                    $dc_stock = $BOQStockArr[$project_id.'-'.$boq_code]['dc_stock'];
                                                }
                                                if($getExceptionalDetails->EA_qty > 0){
                                                    $dc_stock_val = $dc_stock + $getExceptionalDetails->EA_qty;
                                                }elseif($getExceptionalDetails->EA_qty < 0){
                                                    $dc_stock_val = $dc_stock - abs($getExceptionalDetails->EA_qty);
                                                }
                                                $update_stock_arr[] = array('boq_code'=>$boq_code,'total_stock'=>$total_stock_val,
                                                'dc_total_stock'=>$dc_total_stock_val,'dc_stock'=>$dc_stock_val,'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));  
                                            }else{
                                                $save_stock_arr[] = array('project_id'=>$project_id,'boq_code'=>$boq_code,
                                                'total_stock'=>$update_qty,'dc_total_stock'=>$update_qty,'dc_stock'=>$update_qty,
                                                'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));  
                                            }
                                        }
                                    }
                                    
                                    $qr_array = array('project_id' =>$project_id,'boq_code'=>$boq_code,'transaction_id' => $exceptionalDetails[0]->transaction_id);
                                    $bom_items_data = $this->common_model->selectDetailsWhereArr('tbl_bom_exceptional',$qr_array);

                                    foreach($bom_items_data as $bom_data) {

                                        if(isset($bom_data->id) && !empty($bom_data->id)) { $bom_exep_id = $bom_data->id; }else { $bom_exep_id = ''; }
                                        if(isset($bom_data->bom_code) && !empty($bom_data->bom_code)) { $bom_code = $bom_data->bom_code; }else { $bom_code = ''; }
                                        if(isset($bom_data->qty) && !empty($bom_data->qty)) { $bom_qty = $bom_data->qty; }else { $qty = ''; }
                                        if(isset($bom_data->transaction_id) && !empty($bom_data->transaction_id)) { $t_id = $bom_data->transaction_id; }else { $t_id = ''; }

                                        $check_bom_stock_details = $this->admin_model->check_bom_stock_details($project_id,$boq_code,$bom_code);
                                       
                                        if(isset($check_bom_stock_details) && !empty($check_bom_stock_details)) {

                                        if(isset($check_bom_stock_details->total_stock) && !empty($check_bom_stock_details->total_stock)) { $bom_total_stock = $check_bom_stock_details->total_stock; }else { $bom_total_stock = 0; }
                                        if(isset($check_bom_stock_details->dc_total_stock) && !empty($check_bom_stock_details->dc_total_stock)) { $bom_dc_total_stock = $check_bom_stock_details->dc_total_stock; }else { $bom_dc_total_stock = 0; }
                                        if(isset($check_bom_stock_details->dc_stock) && !empty($check_bom_stock_details->dc_stock)) { $bom_dc_stock = $check_bom_stock_details->dc_stock; }else { $bom_dc_stock = 0; }
                                        if(isset($check_bom_stock_details->release_stock) && !empty($check_bom_stock_details->release_stock)) { $bom_release_stock = $check_bom_stock_details->release_stock; }else { $bom_release_stock = 0; }

                                        if($bom_qty > 0){
                                            $updated_total_stock = $bom_total_stock + $bom_qty;
                                            $updated_dc_total_stock = $bom_dc_total_stock + $bom_qty;
                                            $updated_dc_stock = $bom_dc_stock + $bom_qty;
                                            $updated_release_total_stock = $bom_release_stock + $bom_qty;
                                        }elseif($bom_qty < 0) {
                                            $updated_total_stock = $bom_total_stock - abs($bom_qty);
                                            $updated_dc_total_stock = $bom_dc_total_stock - abs($bom_qty);
                                            $updated_dc_stock = $bom_dc_stock - abs($bom_qty);
                                            $updated_release_total_stock = $bom_release_stock - abs($bom_qty);
                                        }

                                        $update_bom_stock_arr[] = array(
                                            'boq_code'=>$boq_code,
                                            'bom_code'=>$bom_code,
                                            'total_stock'=> $updated_total_stock,
                                            'dc_total_stock'=>$updated_dc_total_stock,
                                            'dc_stock'=>$updated_dc_stock,
                                            'release_stock'=>$updated_release_total_stock,
                                            'updated_by'=>$loguser_id,
                                            'updated_date'=>date('Y-m-d H:i:s')
                                        );

                                        $existData = $this->admin_model->get_bom_item_details($project_id, $bom_code,$boq_code);
                                        if (isset($existData) && !empty($existData)) {


                                            if (isset($existData->design_qty) && !empty($existData->design_qty) && $existData->design_qty > 0) {
                                                $design_qty = $existData->design_qty;    
                                            }
                                            if (isset($existData->upload_design_qty) && !empty($existData->upload_design_qty) && $existData->upload_design_qty > 0) {
                                                $upload_design_qty = $existData->upload_design_qty;    
                                            }

                                            if (isset($existData->bom_ratio) && !empty($existData->bom_ratio) && $existData->bom_ratio > 0) {
                                                $bom_ratio = $existData->bom_ratio;    
                                            }

                                            if (isset($existData->status) && !empty($existData->status) && $existData->status == 'approved') {
                                                
                                                if($bom_qty > 0){
                                                    $upload_design_qty_total = $upload_design_qty + $bom_qty;
                                                }elseif($bom_qty < 0) {
                                                    $upload_design_qty_total = $upload_design_qty - abs($bom_qty);
                                                }


                                                $save_arr[] = array(
                                                    'project_id'=>$project_id,
                                                    'bom_code'=>$bom_code,
                                                    'boq_code'=>$boq_code,
                                                    'hsn_sac_code'=>$existData->hsn_sac_code,
                                                    'item_description'=>$existData->item_description,
                                                    'unit'=>$existData->unit,
                                                    'scheduled_qty'=>$existData->scheduled_qty,
                                                    'o_design_qty'=>$existData->design_qty,
                                                    'design_qty'=>$upload_design_qty_total,
                                                    'upload_design_qty'=> $upload_design_qty_total,
                                                    'make'=>$existData->make,
                                                    'model'=>$existData->model,
                                                    'rate_basic'=>$existData->rate_basic,
                                                    'gst'=>$existData->gst,
                                                    'non_schedule'=> 'Y',
                                                    'created_by'=>$user_id,
                                                    'bom_ratio' => $bom_ratio,
                                                    'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,
                                                    'modified_on'=>date('Y-m-d H:i:s'),
                                                    'steps'=> $existData->steps + 1,
                                                    'addFromEA' => $t_id,
                                                    'status'=>'approved'
                                                );
                                            } 
                                        } 

                                        if(isset($update_bom_stock_arr) && !empty($update_bom_stock_arr)){
                                            $this->common_model->updateBOMStock($update_bom_stock_arr,$project_id,$boq_code);
                                        }

                                        $bom_excep_data = array('status'=>'approved','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
                                        $this->common_model->updateDetails('tbl_bom_exceptional','id',$bom_exep_id,$bom_excep_data);

                                        } 
                                    }
                                }

                                if(isset($save_arr) && !empty($save_arr)){
                                    $this->common_model->SaveMultiData('tbl_bom_items',$save_arr);
                                }

                                if($allowed == 'Y'){
                                    $data = array('status'=>$status,'approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
                                    $result = $this->common_model->updateDetails('tbl_boq_exceptional','exceptional_id',$exceptional_id,$data);
                                    if($result){
                                    if(isset($update_stock_arr) && !empty($update_stock_arr)){
                                        $this->common_model->updateBOQInstallStock($update_stock_arr,$project_id);
                                    }
                                    if(isset($save_stock_arr) && !empty($save_stock_arr)){
                                        $this->common_model->SaveMultiData('tbl_boq_stock',$save_stock_arr);
            					    }
                                    if(isset($updateDesignQtyArr) && !empty($updateDesignQtyArr)){
                                        $this->admin_model->updateMultiData('tbl_boq_items',$updateDesignQtyArr,'boq_items_id');
                                    }
                                    
                                    if(isset($NewBOQItemArr) && !empty($NewBOQItemArr)){
                                        $this->common_model->SaveMultiData('tbl_boq_items',$NewBOQItemArr);
            					    }
            					    if($status == 'approved'){
                                        $this->json->jsonReturn(array(
                                            'valid'=>TRUE, 
                                            'msg'=>'<div class="alert modify alert-success">BOQ Exceptional Approval Details Approved Successfully!</div>'
                                        ));
                                    }else{
                                        $this->json->jsonReturn(array(
                                            'valid'=>TRUE, 
                                            'msg'=>'<div class="alert modify alert-success">BOQ Exceptional Approval Details Rejected Successfully!</div>'
                                        ));
                                    }
                                    }else{
                                        $this->json->jsonReturn(array(
                                            'valid'=>FALSE,
                                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Approve BOQ Exceptional Approval Details !</div>'
                                        ));
                                    }
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE, 
                                        'msg'=>'<div class="alert modify alert-danger">Stock not available!</div>'
                                    ));
                                }
                            }elseif(isset($status) && !empty($status) && $status == 'reject'){
                                $data = array('status'=>$status,'approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
                                $result = $this->common_model->updateDetails('tbl_boq_exceptional','exceptional_id',$exceptional_id,$data);
                                if($result){
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE, 
                                        'msg'=>'<div class="alert modify alert-success">BOQ Exceptional Approval Details Rejected Successfully!</div>'
                                    ));
                                    
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Approve BOQ Exceptional Approval Details !</div>'
                                    ));
                                }    
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Approve BOQ Exceptional Approval Details !</div>'
                                ));
                            }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Approve BOQ Exceptional Approval Details !</div>'
                            ));
                        }
                    }
                    else
                    {
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Approved BOQ Exceptional Approval Details !</div>'
                        ));
                    }
            		}
                    else
                    {
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Approved BOQ Exceptional Approval Details !</div>'
                        ));
                    }
                }else{
                    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!</div>'
                    ));
                }
            }else{
                $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!</div>'
                ));
            }
		}else{
		    $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> Please LoggedIn!</div>'
            ));
		}
    }
    public function project_dcpwip_list_p() 
		{
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$project_id = $this->input->post('project_id');
        if(isset($project_id) && !empty($project_id)){
            $project_id = base64_decode($project_id);
        }else{
            $project_id = 0;
        }
		$data = $row = array();
		$memData = $this->admin_model->getDCPWIPItemListRows($_POST,$project_id);
		$allCount = $this->admin_model->countDCPWIPItemListAll($project_id);
		$countFiltered = $this->admin_model->countDCPWIPItemListFiltered($_POST,$project_id);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->p_wip_no) && !empty($member->p_wip_no)) { $p_wip_no = $member->p_wip_no; }else { $p_wip_no = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $hsn_sac_code = $member->hsn_sac_code; }else { $hsn_sac_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '0'; }
			if(isset($member->avl_qty) && !empty($member->avl_qty)) { $avl_qty = $member->avl_qty; }else { $avl_qty = '-'; }
			if(isset($member->prov_qty) && !empty($member->prov_qty)) { $prov_qty = $member->prov_qty; }else { $prov_qty = '-'; }
			
			$data[] = array(
			$i,
			$boq_code,
			$boq_code,
			$item_description,
			$prov_qty
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    public function project_dcpwip_items() 
		{
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$p_wip_no = $this->input->post('p_wip_no');
        if(isset($p_wip_no) && !empty($p_wip_no)){
            $p_wip_no = base64_decode($p_wip_no);
        }else{
            $p_wip_no = 0;
        }
		$data = $row = array();
		$memData = $this->admin_model->getDCPWIPItemListRows($_POST,$p_wip_no);
		$allCount = $this->admin_model->countDCPWIPItemListAll($p_wip_no);
		$countFiltered = $this->admin_model->countDCPWIPItemListFiltered($_POST,$p_wip_no);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->p_wip_no) && !empty($member->p_wip_no)) { $p_wip_no = $member->p_wip_no; }else { $p_wip_no = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $hsn_sac_code = $member->hsn_sac_code; }else { $hsn_sac_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description =$member->item_description; }else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '0'; }
			if(isset($member->avl_qty) && !empty($member->avl_qty)) { $avl_qty = $member->avl_qty; }else { $avl_qty = '-'; }
			if(isset($member->prov_qty) && !empty($member->prov_qty)) { $prov_qty = $member->prov_qty; }else { $prov_qty = 0; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = 0; }
			$prov_amount = 0;
			$prov_amount = $prov_qty * $rate_basic;
			$data[] = array(
			$i,
			$boq_code,
			$hsn_sac_code,
			$item_description,
			$unit,
			$avl_qty,
			$prov_qty,
			sprintf('%0.2f', $prov_amount)
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    public function project_dciwip_items() 
		{
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$i_wip_no = $this->input->post('i_wip_no');
        if(isset($i_wip_no) && !empty($i_wip_no)){
            $i_wip_no = base64_decode($i_wip_no);
        }else{
            $i_wip_no = 0;
        }
		$data = $row = array();
		$memData = $this->admin_model->getDCIWIPItemListRows($_POST,$i_wip_no);
		$allCount = $this->admin_model->countDCIWIPItemListAll($i_wip_no);
		$countFiltered = $this->admin_model->countDCIWIPItemListFiltered($_POST,$i_wip_no);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->i_wip_no) && !empty($member->i_wip_no)) { $i_wip_no = $member->i_wip_no; }else { $i_wip_no = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $hsn_sac_code = $member->hsn_sac_code; }else { $hsn_sac_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '0'; }
			if(isset($member->avl_qty) && !empty($member->avl_qty)) { $avl_qty = $member->avl_qty; }else { $avl_qty = '-'; }
			if(isset($member->installed_qty) && !empty($member->installed_qty)) { $installed_qty = $member->installed_qty; }else { $installed_qty = 0; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = 0; }
			$installed_amount = 0;
			$installed_amount = $installed_qty * $rate_basic;
			
			$data[] = array(
			$i,
			$boq_code,
			$hsn_sac_code,
			$item_description,
			$unit,
			$avl_qty,
			$installed_qty,
			sprintf('%0.2f', $installed_amount)
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    public function project_dciwip_list_p() 
		{
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$project_id = $this->input->post('project_id');
        if(isset($project_id) && !empty($project_id)){
            $project_id = base64_decode($project_id);
        }else{
            $project_id = 0;
        }
		$data = $row = array();
		$memData = $this->admin_model->getDCIWIPItemListRows($_POST,$project_id);
		$allCount = $this->admin_model->countDCIWIPItemListAll($project_id);
		$countFiltered = $this->admin_model->countDCIWIPItemListFiltered($_POST,$project_id);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->i_wip_no) && !empty($member->i_wip_no)) { $i_wip_no = $member->i_wip_no; }else { $i_wip_no = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $hsn_sac_code = $member->hsn_sac_code; }else { $hsn_sac_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '0'; }
			if(isset($member->avl_qty) && !empty($member->avl_qty)) { $avl_qty = $member->avl_qty; }else { $avl_qty = '-'; }
			if(isset($member->installed_qty) && !empty($member->installed_qty)) { $installed_qty = $member->installed_qty; }else { $installed_qty = '-'; }
			
			$data[] = array(
			$i,
			$boq_code,
			$hsn_sac_code,
			$item_description,
			$unit,
			$avl_qty,
			$installed_qty
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    public function project_dcpwip_list() 
		{
		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$project_idp = $this->input->post('project_id');
        if(isset($project_idp) && !empty($project_idp)){
            $project_idp = base64_decode($project_idp);
        }else{
            $project_idp = 0;
        }
        $check_permission_edit = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_provisional_wip');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_edit = 'Y';
                }
            }
		}
		$check_permission_approve = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_provisional_wip');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_approve = 'Y';
                }
            }
		}
		
		$data = $row = array();
		$memData = $this->admin_model->getDCPWIPListRows($_POST,$project_idp);
		$allCount = $this->admin_model->countDCPWIPListAll($project_idp);
		$countFiltered = $this->admin_model->countDCPWIPListFiltered($_POST,$project_idp);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->p_wip_id) && !empty($member->p_wip_id)) { $p_wip_id = $member->p_wip_id; }else { $p_wip_id = '-'; }
			if(isset($member->p_wip_no) && !empty($member->p_wip_no)) { $p_wip_no = $member->p_wip_no; }else { $p_wip_no = '-'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
			if(isset($member->customer_name) && !empty($member->customer_name)) { $customer_name = $member->customer_name; }else { $customer_name = '-'; }
			if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = 'pending'; }
			if(isset($member->created_on) && !empty($member->created_on)) { $created_on = $member->created_on; }else { $created_on = '-'; }
			
			$html = '';
			//$html .= '<a href="javascript:;" class="edit tooltips" rel="'.$p_wip_id.'" title="Edit Provisional WIP" rev="edit_provisional_wip" data-original-title="Edit Installed WIP"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';
			//$html .= '&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="edit tooltips" rel="'.$p_wip_id.'" title="Delete Provisional WIP" rev="delete_provisional_wip" data-original-title="Delete Installed WIP"><i class="fa fa-trash" style="color:#a94442; font-size: 15px;"></i></a>';
			//if($status !='Approved'){
			//$html .= '&nbsp;&nbsp;&nbsp;<a class="btn btn-success btn-xs active_link_cmn" href="javascript:void(0);" rev="approved_provisional_wip" rel="'.$p_wip_id.'" title="Click here to Approved Record" data-status="Y">Approve</a>';
			//}
			$htmlp = '<a class="popup_save" href="javascript:void(0);" rev="view_dcpwip_items" rel="'.$p_wip_id.'" data-title="(#'.$p_wip_no.') Provisional WIP Item List" data-status="allow" style="margin-top:10px;"><span class="md-click-circle md-click-animate" style="height: 97px; width: 97px; top: -38.5312px; left: 29.4896px;"></span> '.$p_wip_no.'</a>';
			if($status =='pending'){
			if($check_permission_approve == 'Y'){
			$html .='<select class="statusselect" id="statusselect'.$p_wip_id.'" rev="approved_provisional_wip" rel="'.$p_wip_id.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
			}
			}elseif($status =='reject'){
			if($check_permission_edit == 'Y'){
			$html .='&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="editRecord tooltips" rel="'.$p_wip_id.'" title="Edit Record" rev="edit_provisional_wip" data-original-title="Edit Record"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';
			}
			if($check_permission_approve == 'Y'){
			$html .='&nbsp;&nbsp;&nbsp;<select class="statusselect" id="statusselect'.$p_wip_id.'" rev="approved_provisional_wip" rel="'.$p_wip_id.'"><option class="statusselectoption" value="reject">Reject</option><option class="statusselectoption" value="approved">Approve</option></select>';
			}
			}
			$action_status='';
			if($status == 'approved'){
			$action_status .='<span style="color:green;font-weight:600;">Approved</span>';
			}elseif($status == 'reject'){
			$action_status .='<span style="color:red;font-weight:600;">Rejected</span>';
			}else{
			$action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
			}
			if(isset($project_idp) && !empty($project_idp)){
			$data[] = array(
			$i,
			$htmlp,
			$bp_code,
			$customer_name,
			$action_status,
			$created_on);
			}else{
			$data[] = array(
			$i,
			$htmlp,
			$bp_code,
			$customer_name,
			$action_status,
			$created_on,
			$html
			);
			}
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    public function project_dcvs_items() 
		{
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$vs_id = $this->input->post('vs_id');
        if(isset($vs_id) && !empty($vs_id)){
            $vs_id = base64_decode($vs_id);
        }else{
            $vs_id = 0;
        }
		$data = $row = array();
		$memData = $this->admin_model->getDCVSItemListRows($_POST,$vs_id);
		$allCount = $this->admin_model->countDCVSItemListAll($vs_id);
		$countFiltered = $this->admin_model->countDCVSItemListFiltered($_POST,$vs_id);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->vs_id) && !empty($member->vs_id)) { $vs_id = $member->vs_id; }else { $vs_id = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $hsn_sac_code = $member->hsn_sac_code; }else { $hsn_sac_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '0'; }
			if(isset($member->avl_qty) && !empty($member->avl_qty)) { $avl_qty = $member->avl_qty; }else { $avl_qty = '-'; }
			if(isset($member->stock_qty) && !empty($member->stock_qty)) { $stock_qty = $member->stock_qty; }else { $stock_qty = '-'; }
			
			$data[] = array(
			$i,
			$boq_code,
			$hsn_sac_code,
			$item_description,
			$unit,
			$avl_qty,
			$stock_qty
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    
    public function project_dcc_list_p() 
		{
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$project_id = $this->input->post('project_id');
        if(isset($project_id) && !empty($project_id)){
            $project_id = base64_decode($project_id);
        }else{
            $project_id = 0;
        }
		$data = $row = array();
		$memData = $this->admin_model->getDCCItemListRows($_POST,$project_id);
		$allCount = $this->admin_model->countDCCItemListAll($project_id);
		$countFiltered = $this->admin_model->countDCCItemListFiltered($_POST,$project_id);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->challan_id) && !empty($member->challan_id)) { $challan_id = $member->challan_id; }else { $challan_id = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $hsn_sac_code = $member->hsn_sac_code; }else { $hsn_sac_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '0'; }
			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = '-'; }
			if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '-'; }
			if(isset($member->received_qty) && !empty($member->received_qty)) { $received_qty = $member->received_qty; }else { $received_qty = '-'; }
			
			$data[] = array(
			$i,
			$boq_code,
			$boq_code,
			$item_description,
			$received_qty
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    public function project_dcc_items() 
		{
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$challan_id = $this->input->post('challan_id');
        if(isset($challan_id) && !empty($challan_id)){
            $challan_id = base64_decode($challan_id);
        }else{
            $challan_id = 0;
        }
		$data = $row = array();
		$memData = $this->admin_model->getDCCItemListRows($_POST,$challan_id);
		$allCount = $this->admin_model->countDCCItemListAll($challan_id);
		$countFiltered = $this->admin_model->countDCCItemListFiltered($_POST,$challan_id);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->challan_id) && !empty($member->challan_id)) { $challan_id = $member->challan_id; }else { $challan_id = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $hsn_sac_code = $member->hsn_sac_code; }else { $hsn_sac_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '0'; }
			if(isset($member->qty) && !empty($member->qty)) { $received_qty = $member->qty; }else { $received_qty = '0'; }
			$project_id = 0;
			$delivery_challan = $this->common_model->selectDetailsWhr('tbl_delivery_challan','challan_id',$challan_id);
            if(isset($delivery_challan->project_id) && !empty($delivery_challan->project_id)){
                $project_id = $delivery_challan->project_id;
            }
			$design_qty=0;
			$design_qty = $this->admin_model->get_design_qty($project_id,$boq_code);
		    if(isset($design_qty) && !empty($design_qty)) { $design_qty = $design_qty; }else { $design_qty = '0'; }
			$data[] = array(
			$i,
			$boq_code,
			$hsn_sac_code,
			$item_description,
			$unit,
			$design_qty,
			$received_qty
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    
    public function project_dciwip_list() 
		{
		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$project_idp = $this->input->post('project_id');
        if(isset($project_idp) && !empty($project_idp)){
            $project_idp = base64_decode($project_idp);
        }else{
            $project_idp = 0;
        }
        $check_permission_edit = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_installed_wip');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_edit = 'Y';
                }
            }
		}
		$check_permission_approve = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_installed_wip');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_approve = 'Y';
                }
            }
		}
		$data = $row = array();
		$memData = $this->admin_model->getDCIWIPListRows($_POST,$project_idp);
		$allCount = $this->admin_model->countDCIWIPListAll($project_idp);
		$countFiltered = $this->admin_model->countDCIWIPListFiltered($_POST,$project_idp);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->i_wip_id) && !empty($member->i_wip_id)) { $i_wip_id = $member->i_wip_id; }else { $i_wip_id = '-'; }
			if(isset($member->i_wip_no) && !empty($member->i_wip_no)) { $i_wip_no = $member->i_wip_no; }else { $i_wip_no = '-'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
			if(isset($member->customer_name) && !empty($member->customer_name)) { $customer_name = $member->customer_name; }else { $customer_name = '-'; }
			if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = 'pending'; }
			if(isset($member->created_on) && !empty($member->created_on)) { $created_on = $member->created_on; }else { $created_on = '-'; }
			$html = '';
			//$html .= '<a href="javascript:;" class="edit tooltips" rel="'.$i_wip_id.'" title="Edit Installed WIP" rev="edit_provisional_wip" data-original-title="Edit Installed WIP"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';
			//$html .= '&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="edit tooltips" rel="'.$i_wip_id.'" title="Delete Installed WIP" rev="delete_provisional_wip" data-original-title="Delete Installed WIP"><i class="fa fa-trash" style="color:#a94442; font-size: 15px;"></i></a>';
			//if($status !='Approved'){
			//$html .= '&nbsp;&nbsp;&nbsp;<a class="btn btn-success btn-xs active_link_cmn" href="javascript:void(0);" rev="approved_installed_wip" rel="'.$i_wip_id.'" title="Click here to Approved Record" data-status="Y">Approve</a>';
			//}
			$htmlp = '<a class="popup_save" href="javascript:void(0);" rev="view_dciwip_items" rel="'.$i_wip_id.'" data-title="(#'.$i_wip_no.') Installed WIP Item List" data-status="allow" style="margin-top:10px;"><span class="md-click-circle md-click-animate" style="height: 97px; width: 97px; top: -38.5312px; left: 29.4896px;"></span> '.$i_wip_no.'</a>';
			if($status =='pending'){
			    if($check_permission_approve == 'Y'){
			        $html .='<select class="statusselect" id="statusselect'.$i_wip_id.'" rev="approved_installed_wip" rel="'.$i_wip_id.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
			    }
			}elseif($status =='reject'){
			if($check_permission_edit == 'Y'){
			    $html .='&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="editRecord tooltips" rel="'.$i_wip_id.'" title="Edit Record" rev="edit_installed_wip" data-original-title="Edit Record"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';
			}
			if($check_permission_approve == 'Y'){
			    $html .='&nbsp;&nbsp;&nbsp;<select class="statusselect" id="statusselect'.$i_wip_id.'" rev="approved_installed_wip" rel="'.$i_wip_id.'"><option class="statusselectoption" value="reject">Reject</option><option class="statusselectoption" value="approved">Approve</option></select>';
			}
			}
			$action_status='';
			if($status == 'approved'){
			$action_status .='<span style="color:green;font-weight:600;">Approved</span>';
			}elseif($status == 'reject'){
			$action_status .='<span style="color:red;font-weight:600;">Rejected</span>';
			}else{
			$action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
			}
			if(isset($project_idp) && !empty($project_idp)){
			$data[] = array(
			$i,
			$htmlp,
			$bp_code,
			$customer_name,
			$action_status,
			$created_on);
			}else{
			$data[] = array(
			$i,
			$htmlp,
			$bp_code,
			$customer_name,
			$action_status,
			$created_on,
			$html
			);
			}
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    public function project_dcvs_list() 
		{
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$project_id = $this->input->post('project_id');
        if(isset($project_id) && !empty($project_id)){
            $project_id = base64_decode($project_id);
        }else{
            $project_id = 0;
        }
		$data = $row = array();
		$memData = $this->admin_model->getDCVSListRows($_POST,$project_id);
		$allCount = $this->admin_model->countDCVSListAll($project_id);
		$countFiltered = $this->admin_model->countDCVSListFiltered($_POST,$project_id);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->vs_id) && !empty($member->vs_id)) { $vs_id = $member->vs_id; }else { $vs_id = '-'; }
			if(isset($member->vs_no) && !empty($member->vs_no)) { $vs_no = $member->vs_no; }else { $vs_no = '-'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
			if(isset($member->customer_name) && !empty($member->customer_name)) { $customer_name = $member->customer_name; }else { $customer_name = '-'; }
			if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = 'pending'; }
			if(isset($member->created_on) && !empty($member->created_on)) { $created_on = $member->created_on; }else { $created_on = '-'; }
			$htmlp = '<a class="popup_save" href="javascript:void(0);" rev="view_dcvs_items" rel="'.$vs_id.'" data-title="(#'.$vs_no.') Warehouse Item List" data-status="allow" style="margin-top:10px;"><span class="md-click-circle md-click-animate" style="height: 97px; width: 97px; top: -38.5312px; left: 29.4896px;"></span> '.$vs_no.'</a>';
			$html = '';
			$html .= '<a href="javascript:;" class="edit tooltips" rel="'.$vs_id.'" title="Edit Warehouse" rev="edit_virtual_stock" data-original-title="Edit Warehouse"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';
			$html .= '&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="edit tooltips" rel="'.$vs_id.'" title="Delete Warehouse" rev="delete_virtual_stock" data-original-title="Delete Warehouse"><i class="fa fa-trash" style="color:#a94442; font-size: 15px;"></i></a>';
			$html .= '&nbsp;&nbsp;&nbsp;<a class="btn btn-success btn-xs active_link_cmn" href="javascript:void(0);" rev="approved_proforma_invoice" rel="'.$proforma_id.'" title="Click here to Approved Record" data-status="Y">Approve</a>';
			
			$data[] = array(
			$i,
			$htmlp,
			$bp_code,
			$customer_name,
			$status,
			$created_on,
			$html
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    
    public function project_proformaInvc_list() 
		{
		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$project_idp = $this->input->post('project_id');
        if(isset($project_idp) && !empty($project_idp)){
            $project_idp = base64_decode($project_idp);
        }else{
            $project_idp = 0;
        }
        $check_permission_edit = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_proforma_invoice');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_edit = 'Y';
                }
            }
		}
		$check_permission_approve = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_proforma_invoice');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_approve = 'Y';
                }
            }
		}
		$check_permission_convert = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','convert_to_tax_invoice');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_convert = 'Y';
                }
            }
		}
		$data = $row = array();
		$memData = $this->admin_model->getPROINVCListRows($_POST,$project_idp);
		$allCount = $this->admin_model->countPROINVCListAll($project_idp);
		$countFiltered = $this->admin_model->countPROINVCListFiltered($_POST,$project_idp);
        $i = $_POST['start'];
        
        // echo "<pre>";
        // print_r($memData);die;
		foreach($memData as $member){
            $i++;
            if(isset($member->proforma_id) && !empty($member->proforma_id)) { $proforma_id = $member->proforma_id; }else { $proforma_id = '0'; }
			if(isset($member->proforma_no) && !empty($member->proforma_no)) { $proforma_no = $member->proforma_no; }else { $proforma_no = '-'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
			if(isset($member->customer_name) && !empty($member->customer_name)) { $customer_name = $member->customer_name; }else { $customer_name = '-'; }
			if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = 'pending'; }
			if(isset($member->created_on) && !empty($member->created_on)) { $created_on = $member->created_on; }else { $created_on = '-'; }
            if(isset($member->payment_terms) && !empty($member->payment_terms)) { $payment_terms = $member->payment_terms; }else { $payment_terms = '-'; }
            if(isset($member->billing_type) && !empty($member->billing_type)) { $billing_type = $member->billing_type; }else { $billing_type = ''; }

            $billing_type_txt = '';
            if($billing_type =='supply') {
                $billing_type_txt = 'Supply';
            } else if($billing_type =='installation') {
                $billing_type_txt = 'Installation';
            } else if($billing_type =='testing_commissioning') {
                $billing_type_txt = 'Testing & Commissioning';
            } else if($billing_type =='handover') {
                $billing_type_txt = 'Handover';
            }

			if(isset($member->Converted) && !empty($member->Converted)) { $Converted = ($member->Converted == 'Y') ? 'Yes' : 'No'; }else { $Converted = '-'; }
            
			$htmlp = '';
			$htmlp = '<a class="popup_save" href="javascript:void(0);" rev="view_proforma_invoice_items" rel="'.$proforma_id.'" data-title="(#'.$proforma_no.') Proforma Invoice Item List" data-status="allow" style="margin-top:10px;"><span class="md-click-circle md-click-animate" style="height: 97px; width: 97px; top: -38.5312px; left: 29.4896px;"></span> '.$proforma_no.'</a>';
			$html = '';
			$html .= '<a class="popup_save" href="javascript:void(0);" rev="download_proforma_invoice" rel="'.$proforma_id.'" data-title="(#'.$proforma_no.') Download Proforma Invoice" data-status="allow"><i class="fa fa-download" style="color:#000; font-size:15px;"></i></a>&nbsp;&nbsp;&nbsp;';
			if($status =='pending'){
			if($check_permission_approve == 'Y'){
			$html .='<select class="statusselect" id="statusselect'.$proforma_id.'" rev="approved_proforma_invoice" rel="'.$proforma_id.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
			}
			}elseif($status =='reject'){
			if($check_permission_edit == 'Y'){
			$html .='&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="editRecord tooltips" rel="'.$proforma_id.'" title="Edit Record" rev="edit_proforma_invoice" data-original-title="Edit Record"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';
			}
			if($check_permission_approve == 'Y'){
			$html .='&nbsp;&nbsp;&nbsp;<select class="statusselect" id="statusselect'.$proforma_id.'" rev="approved_proforma_invoice" rel="'.$proforma_id.'"><option class="statusselectoption" value="reject">Reject</option><option class="statusselectoption" value="approved">Approve</option></select>';
			}
			}
			if($member->status == 'approved'){
			if($member->Converted == 'N'){
			if($check_permission_convert == 'Y'){
			$html .= '&nbsp;&nbsp;&nbsp;<a class="popup_save" href="javascript:void(0);" rev="convert_to_tax_invoice" rel="'.$proforma_id.'" title="(#'.$proforma_no.') Convert to Tax Invoice" data-status="allow"><img src="'.base_url().'uploads/images/tax_icon.jpg" width="20px" height="20px"></a>';
			}
			}
			}
			$action_status='';
			if($status == 'approved'){
			$action_status .='<span style="color:green;font-weight:600;">Approved</span>';
			}elseif($status == 'reject'){
			$action_status .='<span style="color:red;font-weight:600;">Rejected</span>';
			}else{
			$action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
			}
			
			if(isset($project_idp) && !empty($project_idp)){
			$data[] = array(
			$i,
			$htmlp,
			$bp_code,
            $payment_terms,
            $billing_type_txt,
			$customer_name,
			$action_status,
            $Converted,
			$created_on);
			}else{
			$data[] = array(
			$i,
			$htmlp,
			$bp_code,
            $payment_terms,
            $billing_type_txt,
			$customer_name,
			$action_status,
            $Converted,
			$created_on,
			$html
			);
			}
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    
    public function edit_tax_invoice(){
        $check_permission_update = 'N';
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','create-tax-invoice');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_tax_invoice');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                }
            }
		}
		$id = $this->input->post('id');
        $data['check_permission_update'] = $check_permission_update;
        $data['tax_invoice_data'] = $this->common_model->selectDetailsWhr('view_tax_invc','tax_invc_id',$id);
        $data['tax_invoice_items_data'] = $this->common_model->selectDetailsWhereAllDY('tbl_tax_invc_items', 'tax_invc_id',$id);
        $this->load->view('create-tax-invoice',$data);
    }
//     public function edit_proforma_invoice(){
//         $check_permission_update = 'N';
//         $loguser_id = $this->session->userData('user_id');
// 		$logrole_id = $this->session->userData('role_id');
// 		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
// 		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','create-proforma-invoice');
//             if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
//                 $submenu_id = $submenu_data->submenu_id;
//                 $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
//                 if(isset($check_permission) && !empty($check_permission)){
//                     $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_proforma_invoice');
//                     if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
//                         $usubmenu_id = $submenu_datau->submenu_id;
//                         $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
//                         if(isset($check_permissionu) && !empty($check_permissionu)){
//                             $check_permission_update = 'Y';
//                         }
//                     }
//                 }
//             }
// 		}
//         $id = $this->input->post('id');
//         $data['check_permission_update'] = $check_permission_update;
//         $data['proforma_data'] = $this->common_model->selectDetailsWhr('view_proforma_invc','proforma_id',$id);
//         $proforma_items_data = $this->common_model->selectDetailsWhereAllDY('tbl_proforma_invc_items', 'proforma_id',$id);
//         $project_id = (isset($data['proforma_data']->project_id) && !empty($data['proforma_data']->project_id))? $data['proforma_data']->project_id:'';
//         $billing_type = (isset($data['proforma_data']->billing_type) && !empty($data['proforma_data']->billing_type))? $data['proforma_data']->billing_type:'';
//         $billing_type_value = (isset($data['proforma_data']->billing_type_value) && !empty($data['proforma_data']->billing_type_value))? $data['proforma_data']->billing_type_value:0;

//         $project_data = $this->common_model->selectDetailsWhr('tbl_projects','project_id',$project_id);

//         $payment_terms = isset($project_data->payment_terms) ? $project_data->payment_terms :'';
//         $bill_split_supply = isset($project_data->bill_split_supply) ? $project_data->bill_split_supply :'';
//         $bill_installation = isset($project_data->bill_installation) ? $project_data->bill_installation :''; 
//         $testing_commissioning = isset($project_data->testing_commissioning) ? $project_data->testing_commissioning : '';
//         $bill_handover = isset($project_data->bill_handover) ? $project_data->bill_handover : '';
       
       
//         if(!empty($billing_type) && isset($billing_type)) {
//             $bill_per = array('bill_split_supply','bill_installation','testing_commissioning','bill_handover');
//             foreach($proforma_items_data as $key => $value) {
//                 if($payment_terms == 'SITC') {
//                     $rate = (isset($value->rate) && !empty($value->rate))? $value->rate:'';
//                     $qty = (isset($value->qty) && !empty($value->qty))? $value->qty:'';
//                     $taxable_amount = $this->calculated_bil_split($rate,$qty,$billing_type,$billing_type_value);
//                     $proforma_items_data[$key]->taxable_amount = $taxable_amount;
//                 } 
//             }
//         }    
       
//         $data['billing_split'] = compact('payment_terms','bill_split_supply','bill_installation','testing_commissioning','bill_handover','billing_type_arr');
//         $data['proforma_items_data'] = $proforma_items_data;    
//         // echo "<pre>";
//         // print_r($data);die;
//         // pr($data,1);
//         $this->load->view('create-proforma-invoice',$data);
//     }
// public function edit_proforma_invoice(){
//         $check_permission_update = 'N';
//         $loguser_id = $this->session->userData('user_id');
// 		$logrole_id = $this->session->userData('role_id');
// 		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
// 		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','create-proforma-invoice');
//             if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
//                 $submenu_id = $submenu_data->submenu_id;
//                 $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
//                 if(isset($check_permission) && !empty($check_permission)){
//                     $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_proforma_invoice');
//                     if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
//                         $usubmenu_id = $submenu_datau->submenu_id;
//                         $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
//                         if(isset($check_permissionu) && !empty($check_permissionu)){
//                             $check_permission_update = 'Y';
//                         }
//                     }
//                 }
//             }
// 		}
//         $id = $this->input->post('id');
//         $data['check_permission_update'] = $check_permission_update;
//         $data['proforma_data'] = $this->common_model->selectDetailsWhr('view_proforma_invc','proforma_id',$id);
//         $proforma_items_data = $this->common_model->selectDetailsWhereAllDY('tbl_proforma_invc_items', 'proforma_id',$id);
//         $project_id = (isset($data['proforma_data']->project_id) && !empty($data['proforma_data']->project_id))? $data['proforma_data']->project_id:'';
//         $billing_type = (isset($data['proforma_data']->billing_type) && !empty($data['proforma_data']->billing_type))? $data['proforma_data']->billing_type:'';
//         $billing_type_value = (isset($data['proforma_data']->billing_type_value) && !empty($data['proforma_data']->billing_type_value))? $data['proforma_data']->billing_type_value:0;

//         $project_data = $this->common_model->selectDetailsWhr('tbl_projects','project_id',$project_id);

//         $payment_terms = isset($project_data->payment_terms) ? $project_data->payment_terms :'';
//         $bill_split_supply = isset($project_data->bill_split_supply) ? $project_data->bill_split_supply :'';
//         $bill_installation = isset($project_data->bill_installation) ? $project_data->bill_installation :''; 
//         $testing_commissioning = isset($project_data->testing_commissioning) ? $project_data->testing_commissioning : '';
//         $bill_handover = isset($project_data->bill_handover) ? $project_data->bill_handover : '';
       
       
//         if(!empty($billing_type) && isset($billing_type)) {
//             $bill_per = array('bill_split_supply','bill_installation','testing_commissioning','bill_handover');
//             foreach($proforma_items_data as $key => $value) {
//                 if($payment_terms == 'SITC') {
//                     $rate = (isset($value->rate) && !empty($value->rate))? $value->rate:'';
//                     $qty = (isset($value->qty) && !empty($value->qty))? $value->qty:'';
//                     $taxable_amount = $this->calculated_bil_split($rate,$qty,$billing_type,$billing_type_value);
//                     $proforma_items_data[$key]->taxable_amount = $taxable_amount;
//                 } 
//             }
//         }    
       
//         $data['billing_split'] = compact('payment_terms','bill_split_supply','bill_installation','testing_commissioning','bill_handover','billing_type_arr');
//         $data['proforma_items_data'] = $proforma_items_data;    
//         // echo "<pre>";
//         // print_r($data);die;
//         $data['proforma_data']->auto_round_val = 0;
//         if($data['proforma_data']->auto_round_enable == "Yes"){
//             if(strpos($data['proforma_data']->auto_round_value, "-") !== false){
//                 $data['proforma_data']->auto_round_off_type = "Minus";
//                 $data['proforma_data']->auto_round_val = $data['proforma_data']->auto_round_value;

//             }else{
//                 $data['proforma_data']->auto_round_val = $data['proforma_data']->auto_round_value;
//             }
//         }
        

//         $data['proforma_data']->auto_round_value = abs($data['proforma_data']->auto_round_value);
//         $this->load->view('create-proforma-invoice',$data);
//     }

public function edit_proforma_invoice(){
        $check_permission_update = 'N';
        $loguser_id = $this->session->userData('user_id');
        $logrole_id = $this->session->userData('role_id');
        if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
            $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','create-proforma-invoice');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_proforma_invoice');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                }
            }
        }
        $id = $this->input->post('id');
        $data['check_permission_update'] = $check_permission_update;
        $data['proforma_data'] = $this->common_model->selectDetailsWhr('view_proforma_invc','proforma_id',$id);
        $proforma_items_data = $this->common_model->selectDetailsWhereAllDY('tbl_proforma_invc_items', 'proforma_id',$id);
        $project_id = (isset($data['proforma_data']->project_id) && !empty($data['proforma_data']->project_id))? $data['proforma_data']->project_id:'';
        $billing_type = (isset($data['proforma_data']->billing_type) && !empty($data['proforma_data']->billing_type))? $data['proforma_data']->billing_type:'';
        $billing_type_value = (isset($data['proforma_data']->billing_type_value) && !empty($data['proforma_data']->billing_type_value))? $data['proforma_data']->billing_type_value:0;

        $project_data = $this->common_model->selectDetailsWhr('tbl_projects','project_id',$project_id);

        $payment_terms = isset($project_data->payment_terms) ? $project_data->payment_terms :'';
        $bill_split_supply = isset($project_data->bill_split_supply) ? $project_data->bill_split_supply :'';
        $bill_installation = isset($project_data->bill_installation) ? $project_data->bill_installation :''; 
        $testing_commissioning = isset($project_data->testing_commissioning) ? $project_data->testing_commissioning : '';
        $bill_handover = isset($project_data->bill_handover) ? $project_data->bill_handover : '';
       
       
        if(!empty($billing_type) && isset($billing_type)) {
            $bill_per = array('bill_split_supply','bill_installation','testing_commissioning','bill_handover');
            foreach($proforma_items_data as $key => $value) {
                if($payment_terms == 'SITC') {
                    $rate = (isset($value->rate) && !empty($value->rate))? $value->rate:'';
                    $qty = (isset($value->qty) && !empty($value->qty))? $value->qty:'';
                    $taxable_amount = $this->calculated_bil_split($rate,$qty,$billing_type,$billing_type_value);
                    $proforma_items_data[$key]->taxable_amount = $taxable_amount;
                } 
            }
        }    
       
        $data['billing_split'] = compact('payment_terms','bill_split_supply','bill_installation','testing_commissioning','bill_handover','billing_type_arr');
        $data['proforma_items_data'] = $proforma_items_data;    
        // echo "<pre>";
        // print_r($data);die;
        $data['proforma_data']->auto_round_val = 0;
        if(strpos($data['proforma_data']->auto_round_value, "-") !== false){
            $data['proforma_data']->auto_round_off_type = "Minus";
            $data['proforma_data']->auto_round_val = $data['proforma_data']->auto_round_value;

        }else{
            $data['proforma_data']->auto_round_val = $data['proforma_data']->auto_round_value;
        }
        
        $data['proforma_data']->auto_round_value = abs($data['proforma_data']->auto_round_value);
        $data['billing_type'] = "No";
        if($data['billing_split']['payment_terms'] !== '' &&  $data['billing_split']['payment_terms']!== null && $data['billing_split']['payment_terms'] =='SITC'){
            $data['billing_type'] = "Yes";
        }
        $this->load->view('create-proforma-invoice',$data);
    }


    function calculated_bil_split($rate_basic, $final_qty,$billing_split_up,$billing_per) {
        $proforma_itaxable_amount = 0;

        if ($billing_split_up == 'supply' && false) {
            $supply_per = $billing_per;
            $supply_per_amount = floatval($rate_basic) * floatval($supply_per) / 100;
            $amount = floatval($final_qty) * floatval($supply_per_amount);
            $proforma_itaxable_amount = number_format($amount, 2, '.', '');
        } elseif ($billing_split_up == 'installation' && false) {
            $installation_per = $billing_per;
            $installation_per_amount = floatval($rate_basic) * floatval($installation_per) / 100;
            $amount = floatval($final_qty) * floatval($installation_per_amount);
            $proforma_itaxable_amount = number_format($amount, 2, '.', '');
        } elseif ($billing_split_up == 'testing_commissioning' && false) {
            $test_comminss_per = $billing_per;
            $test_comminss_per_amount = floatval($rate_basic) * floatval($test_comminss_per) / 100;
            $amount = floatval($final_qty) * floatval($test_comminss_per_amount);
            $proforma_itaxable_amount = number_format($amount, 2, '.', '');
        } elseif ($billing_split_up == 'handover' && false) {
            $handover_per = $billing_per;
            $handover_per_amount = floatval($rate_basic) * floatval($handover_per) / 100;
            $amount = floatval($final_qty) * floatval($handover_per_amount);
            $proforma_itaxable_amount = number_format($amount, 2, '.', '');
        } else {
            $amount = floatval($final_qty) * floatval($rate_basic);
            $proforma_itaxable_amount = number_format($amount, 2, '.', '');
        }

        return $proforma_itaxable_amount;
    }


    public function edit_boq_exceptional_approval(){
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','boq-exceptional-approval');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_update = 'N';
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_boq_exceptional_approval');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                    
                }
            }
		}
        $id = $this->input->post('id');
        $data['exceptional_data'] = $this->common_model->selectDetailsWhereAllDY('view_boq_exceptional', 'exceptional_id',$id);
        $data['exceptional_items_data'] = $this->common_model->selectDetailsWhereAllDY('tbl_boq_exceptional', 'exceptional_id',$id);
        $data['check_permission_update'] = $check_permission_update;
        $this->load->view('boq-exceptional-approval',$data);
    }
    public function edit_delivery_challan(){
        $check_permission_update = 'N';
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','client-delivery-challan');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_delivery_challan');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                }
            }
		}
        $id = $this->input->post('id');
        $data['check_permission_update'] = $check_permission_update;
        $data['delivery_challan_data'] = $this->common_model->selectDetailsWhr('view_dcc','challan_id',$id);
        $data['delivery_challan_items_data'] = $this->common_model->selectDetailsWhereAllDY('tbl_deliv_challan_items', 'challan_id',$id);
        $project_id = (isset($data['delivery_challan_data']->project_id) && !empty($data['delivery_challan_data']->project_id)) ? $data['delivery_challan_data']->project_id : '0';
        $data['consignee_data'] = $this->common_model->selectDetailsWhereAllDY('tbl_deliv_challan_consignee', 'project_id',$project_id);
        $this->load->view('client-delivery-challan',$data);
    }
    public function edit_provisional_wip(){
        $check_permission_update = 'N';
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','add-provisional-wip');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_provisional_wip');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                }
            }
		}
		$id = $this->input->post('id');
        $data['check_permission_update'] = $check_permission_update;
        $data['pwip_data'] = $this->common_model->selectDetailsWhr('view_dcpwip','p_wip_id',$id);
        $data['pwip_items_data'] = $this->common_model->selectDetailsWhereAllDY('tbl_prov_wip_items', 'p_wip_id',$id);
        $this->load->view('add-provisional-wip',$data);
    }
    public function edit_installed_wip(){
        $check_permission_update = 'N';
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','add-installed-wip');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_installed_wip');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                }
            }
		}
        $id = $this->input->post('id');
        $data['check_permission_update'] = $check_permission_update;
        $data['iwip_data'] = $this->common_model->selectDetailsWhr('view_dciwip','i_wip_id',$id);
        $data['iwip_items_data'] = $this->common_model->selectDetailsWhereAllDY('tbl_install_wip_items', 'i_wip_id',$id);
        $this->load->view('add-installed-wip',$data);
    }

    
    public function project_taxInvc_list() 
		{
		  //  ini_set('display_errors', 1);
    //         ini_set('display_startup_errors', 1);
    //         error_reporting(E_ALL);
		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$project_idp = $this->input->post('project_id');
        if(isset($project_idp) && !empty($project_idp)){
            $project_idp = base64_decode($project_idp);
        }else{
            $project_idp = 0;
        }
        $check_permission_edit = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_tax_invoice');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_edit = 'Y';
                }
            }
		}
		$check_permission_approve = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_tax_invoice');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_approve = 'Y';
                }
            }
		}
		$check_permission_view = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','view_payment_receipt');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_view = 'Y';
                }
            }
		}
		$check_permission_save = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_payment_advice');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_save = 'Y';
                }
            }
		}
		$check_permission_saveic = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_invoice_closure');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_saveic = 'Y';
                }
            }
		}
		
		$data = $row = array();
		$memData = $this->admin_model->getTAXINVCListRows($_POST,$project_idp);
		$allCount = $this->admin_model->countTAXINVCListAll($project_idp);
		$countFiltered = $this->admin_model->countTAXINVCListFiltered($_POST,$project_idp);
        $i = $_POST['start'];
        
        // echo "<pre>";
        // print_r($memData);die;
		foreach($memData as $member){
            $i++;
            if(isset($member->tax_invc_id) && !empty($member->tax_invc_id)) { $tax_invc_id = $member->tax_invc_id; }else { $tax_invc_id = '0'; }
			if(isset($member->tax_invc_no) && !empty($member->tax_invc_no)) { $tax_invc_no = $member->tax_invc_no; }else { $tax_invc_no = '-'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
			if(isset($member->customer_name) && !empty($member->customer_name)) { $customer_name = $member->customer_name; }else { $customer_name = '-'; }
			if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = 'pending'; }
			if(isset($member->created_on) && !empty($member->created_on)) { $created_on = $member->created_on; }else { $created_on = '-'; }
            if(isset($member->invoice_closure) && !empty($member->invoice_closure)) { $invoice_closure = $member->invoice_closure; }else { $invoice_closure = '-'; }
			

			$final_received_payment = 0;
            $received_payment = $this->admin_model->get_invoice_received_payment($tax_invc_id);
            if(isset($received_payment) && !empty($received_payment) && $received_payment > 0){
            $received_payment = $received_payment;
            }else{
            $received_payment = 0;
            }
            //Statutory Deductions
            $statutory_deductions = 0;
            $it_tds_amount = $this->admin_model->get_invoice_it_tds_amount($tax_invc_id);
            if(isset($it_tds_amount) && !empty($it_tds_amount) && $it_tds_amount > 0){
            $it_tds_amount = $it_tds_amount;
            }else{
            $it_tds_amount = 0;
            }
            $gtds_amount = $this->admin_model->get_invoice_gtds_amount($tax_invc_id);
            if(isset($gtds_amount) && !empty($gtds_amount) && $gtds_amount > 0){
            $gtds_amount = $gtds_amount;
            }else{
            $gtds_amount = 0;
            }
            $other_tax_deduction_amount = $this->admin_model->get_invoice_other_tax_deduction($tax_invc_id);
            if(isset($other_tax_deduction_amount) && !empty($other_tax_deduction_amount) && $other_tax_deduction_amount > 0){
            $other_tax_deduction_amount = $other_tax_deduction_amount;
            }else{
            $other_tax_deduction_amount = 0;
            }
            $statutory_deductions = $it_tds_amount + $gtds_amount + $other_tax_deduction_amount;
            
            //Refundables
            $security_deposit_retn_amount = $this->admin_model->get_invoice_security_deposit_retn_amount($tax_invc_id);
            if(isset($security_deposit_retn_amount) && !empty($security_deposit_retn_amount) && $security_deposit_retn_amount > 0){
            $security_deposit_retn_amount = $security_deposit_retn_amount;
            }else{
            $security_deposit_retn_amount = 0;
            }

            $retenstion_amount = $this->admin_model->get_invoice_retn_amount($tax_invc_id);
            if(isset($retenstion_amount) && !empty($retenstion_amount) && $retenstion_amount > 0){
            $retenstion_amount = $retenstion_amount;
            }else{
            $retenstion_amount = 0;
            }

            $other_deposit_amount = $this->admin_model->get_invoice_other_deposit($tax_invc_id);
            if(isset($other_deposit_amount) && !empty($other_deposit_amount) && $other_deposit_amount > 0){
            $other_deposit_amount = $other_deposit_amount;
            }else{
            $other_deposit_amount = 0;
            }
            $withheld_amount = $this->admin_model->get_invoice_withheld($tax_invc_id);
            if(isset($withheld_amount) && !empty($withheld_amount) && $withheld_amount > 0){
            $withheld_amount = $withheld_amount;
            }else{
            $withheld_amount = 0;
            }
            $refundables = $security_deposit_retn_amount + $other_deposit_amount + $withheld_amount + $retenstion_amount;
            
            //Reciept Amount => REFUNDABLES SD + Retention +  WithHeld + TAX CREDITS + BANK CREDIT AMOUNT + BANK CREDIT AMOUNT 
            // $reciept_amount = $refundables + $statutory_deductions + $received_payment;
            
             $payment_receipt_data = $this->admin_model->get_payment_receipt_bank_credit_data($tax_invc_id);
            //  pr($this->db->last_query(),1);
            //  pr($payment_receipt_data);
            //  pr("ok",1);
             $reciept_amount = $payment_receipt_data[0]['payment_received_amount'];
            // echo $received_payment;die;
            //Non-Refundables
            $labour_cess_amount = $this->admin_model->get_invoice_labour_cess($tax_invc_id);
            if(isset($labour_cess_amount) && !empty($labour_cess_amount) && $labour_cess_amount > 0){
            $labour_cess_amount = $labour_cess_amount;
            }else{
            $labour_cess_amount = 0;
            }
            $other_cess_amount = $this->admin_model->get_invoice_other_cess($tax_invc_id);
            if(isset($other_cess_amount) && !empty($other_cess_amount) && $other_cess_amount > 0){
            $other_cess_amount = $other_cess_amount;
            }else{
            $other_cess_amount = 0;
            }
            $other_deductions_amount = $this->admin_model->get_invoice_other_deductions($tax_invc_id);
            if(isset($other_deductions_amount) && !empty($other_deductions_amount) && $other_deductions_amount > 0){
            $other_deductions_amount = $other_deductions_amount;
            }else{
            $other_deductions_amount = 0;
            }
            $nonrefundables =  $statutory_deductions + $labour_cess_amount + $other_cess_amount + $other_deductions_amount;
            // $final_received_payment = $received_payment + $nonrefundables + $statutory_deductions;
            $final_received_payment = $reciept_amount+ $statutory_deductions + $labour_cess_amount + $other_cess_amount + $other_deductions_amount;
            
            // $invoice_amount = $this->admin_model->get_invoice_amount($tax_invc_id);
            // if(isset($invoice_amount) && !empty($invoice_amount) && $invoice_amount > 0){
            // $invoice_amount = sprintf('%0.2f', $invoice_amount);
            // }else{
            // $invoice_amount = 0.00;
            // }
            
            $tax_invc = $this->common_model->selectDetailsWhr('tbl_tax_invc','tax_invc_id',$tax_invc_id);
            $performa_invc = $this->common_model->selectDetailsWhr('tbl_proforma_invc','proforma_id',$tax_invc->convertid);
            $tax_invc_item = $this->common_model->selectDetailsWhereAll('tbl_tax_invc_items','tax_invc_id',$tax_invc_id);
            // pr($tax_invc_item);
            $sub_total = 0;
            $total_amount = 0 ;
            $gst_amount = 0 ;
            if(isset($tax_invc_item) && !empty($tax_invc_item)){
            foreach($tax_invc_item as $member){
                if($member->gst_type == 'intra-state'){
                  
                    $gst_rate = $member->sgst + $member->cgst;
                     $gst_amount = ($member->taxable_amount * $gst_rate) / 100;
                    $sub_total += $member->taxable_amount;
                   
                    $total_amount += $member->taxable_amount + $gst_amount;
                   
                }else{
                   
                    $member->gst_amount = ($member->taxable_amount * $member->gst) / 100;
                $sub_total += $member->taxable_amount;
                $gst_amount += $member->gst_amount;
                $total_amount += $member->taxable_amount + $member->gst_amount;
                }
              
            }
            }
            $invoice_amount = $total_amount + $performa_invc->auto_round_value;
            
            
            $rec = 0;
            if($invoice_amount >= $final_received_payment){
            $rec =  $invoice_amount - $final_received_payment;   
            }

           
            // // echo $refundables;die;
            // if($i == 4) {
            //     // echo $invoice_amount;
            //     // echo "<br>";
            //     echo $refundables;
            //     echo "<br>";
            //     echo $rec;
            //     die;
            // }

            $rec -= $refundables;
            if(isset($rec) && !empty($rec) && $rec > 0){
            $rec = sprintf('%0.2f', $rec);
            }else{
            $rec = 0.00;
            }

           

            $html_cs ='';
            if(isset($invoice_closure) && !empty($invoice_closure) && $invoice_closure == 'Y'){
                $html_cs .= '<span style="color:green;font-weight:600;">YES</span>';
            } else if(isset($invoice_closure) && !empty($invoice_closure) && $invoice_closure == 'N') {
                $html_cs .= '<span style="color:orange;font-weight:600;">NO</span>';
            }


			$htmlp = '';
			$htmlp = '<a class="popup_save" href="javascript:void(0);" rev="view_tax_invoice_items" rel="'.$tax_invc_id.'" data-title="(#'.$tax_invc_no.') Tax Invoice Item List" data-status="allow" style="margin-top:10px;"><span class="md-click-circle md-click-animate" style="height: 97px; width: 97px; top: -38.5312px; left: 29.4896px;"></span> '.$tax_invc_no.'</a>';
			
			$html = '';
			$html .= '&nbsp;&nbsp;&nbsp;<a class="popup_save" href="javascript:void(0);" rev="download_tax_invoice" rel="'.$tax_invc_id.'" data-title="(#'.$tax_invc_no.') Download Tax Invoice" data-status="allow"><i class="fa fa-download" style="color:#000; font-size:15px;"></i></a>';
			if($status =='pending'){
			if($check_permission_approve == 'Y'){
			$html .='<br><select class="statusselect" id="statusselect'.$tax_invc_id.'" rev="approved_tax_invoice" rel="'.$tax_invc_id.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
			}
			}elseif($status =='reject'){
			if($check_permission_edit == 'Y'){
			$html .='&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="editRecord tooltips" rel="'.$tax_invc_id.'" title="Edit Record" rev="edit_tax_invoice" data-original-title="Edit Record"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';
			}
			if($check_permission_approve == 'Y'){
			$html .='&nbsp;&nbsp;&nbsp;<br><select class="statusselect" id="statusselect'.$tax_invc_id.'" rev="approved_tax_invoice" rel="'.$tax_invc_id.'"><option class="statusselectoption" value="reject">Reject</option><option class="statusselectoption" value="approved">Approve</option></select>';
			}
			}
			$action_status='';
			if($status == 'approved'){
			if($final_received_payment < $invoice_amount){
			    if($check_permission_save == 'Y'){
                    if($rec != 0.00) {
			            $html .= '&nbsp;&nbsp;&nbsp;<a href="'.base_url().'payment-receipt/'.base64_encode($tax_invc_id).'" title="Payment Receipt"><img src="'.base_url().'uploads/images/tax_invoice_2.png" width="20px" height="20px"></a>';
                    }
                }
			}
			if($check_permission_saveic == 'Y'){
                if($rec  <=  0.00 || $rec == 0.00) {
                    $html .= '&nbsp;&nbsp;&nbsp;<a href="'.base_url().'invoice-closure/'.base64_encode($tax_invc_id).'" title="Invoice Closure"><img src="'.base_url().'uploads/images/tax_invoice_1.png" width="20px" height="20px"></a>';
                }
			}
			$action_status .='<span style="color:green;font-weight:600;">Approved</span>';
			}elseif($status == 'reject'){
			$action_status .='<span style="color:red;font-weight:600;">Rejected</span>';
			}else{
			$action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
			}
			$htmlv = '';
			if($check_permission_view == 'Y'){

                if($final_received_payment > 0){
                    $html .= '<br><a class="btn btn-info btn-xs popup_save" href="javascript:void(0);" rev="view_payment_receipt" rel="'.$tax_invc_id.'" data-title="(#'.$tax_invc_no.') Tax Invoice Payment Receipts" data-status="allow" style="margin-top:10px;">Payment Receipt</a>';
                }

                if($final_received_payment > 0){
                    $htmlv .= '<a class="btn btn-info btn-xs popup_save" href="javascript:void(0);" rev="view_payment_receipt" rel="'.$tax_invc_id.'" data-title="(#'.$tax_invc_no.') Tax Invoice Payment Receipts" data-status="allow">Payment Receipt</a>';
                }
		    }
			if(isset($project_idp) && !empty($project_idp)){
			$data[] = array(
			$i,
			$htmlp,
			$bp_code,
			$customer_name,
			$action_status,
			$created_on,
			sprintf('%0.2f', $invoice_amount),
            sprintf('%0.2f', $reciept_amount),
            sprintf('%0.2f', $nonrefundables),
            sprintf('%0.2f', $final_received_payment),
// 			$rec,
            sprintf('%0.2f', $invoice_amount - $final_received_payment),
			$html_cs,$htmlv);
			}else{
			$data[] = array(
			$i,
			$htmlp,
			$bp_code,
			$customer_name,
			$action_status,
			$created_on,
			sprintf('%0.2f', $invoice_amount),
            sprintf('%0.2f', $reciept_amount),
            sprintf('%0.2f', $nonrefundables),
            sprintf('%0.2f', $final_received_payment),
// 			$rec,
            sprintf('%0.2f', $invoice_amount - $final_received_payment),
            $html_cs,
			$html
			);
			}
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    public function project_dcc_list() 
		{
		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$project_id_p = $this->input->post('project_id');
        if(isset($project_id_p) && !empty($project_id_p)){
            $project_id_p = base64_decode($project_id_p);
        }else{
            $project_id_p = 0;
        }
        $check_permission_edit = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_delivery_challan');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_edit = 'Y';
                }
            }
		}
		$check_permission_approve = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_delivery_challan');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_approve = 'Y';
                }
            }
		}
		$data = $row = array();
		$memData = $this->admin_model->getDCCListRows($_POST,$project_id_p);
		$allCount = $this->admin_model->countDCCListAll($project_id_p);
		$countFiltered = $this->admin_model->countDCCListFiltered($_POST,$project_id_p);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->challan_id) && !empty($member->challan_id)) { $challan_id = $member->challan_id; }else { $challan_id = '-'; }
			if(isset($member->dc_no) && !empty($member->dc_no)) { $dc_no = $member->dc_no; }else { $dc_no = '-'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
			if(isset($member->customer_name) && !empty($member->customer_name)) { $customer_name = $member->customer_name; }else { $customer_name = '-'; }
			if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = 'pending'; }
			if(isset($member->created_on) && !empty($member->created_on)) { $created_on = $member->created_on; }else { $created_on = '-'; }
			if(isset($member->consignee_name) && !empty($member->consignee_name)) { $consignee_name = $member->consignee_name; }else { $consignee_name = '-'; }
			if(isset($member->c_type) && !empty($member->c_type) && $member->c_type == 'delivery_challan') { $c_type = 'Delivery Challan'; }else { $c_type = 'Delivery Challan CUM Invoice'; }
			if(isset($member->created_by_rolename) && !empty($member->created_by_rolename)) { $created_by_rolename = '<br>('.$member->created_by_rolename.')'; }else { $created_by_rolename = ''; }
			if(isset($member->approved_by_rolename) && !empty($member->approved_by_rolename)) { $approved_by_rolename = '<br>('.$member->approved_by_rolename.')'; }else { $approved_by_rolename = ''; }
			if(isset($member->created_by_name) && !empty($member->created_by_name)) { $created_by_name = $member->created_by_name.''.$created_by_rolename; }else { $created_by_name = '-'; }
			if(isset($member->approved_by_name) && !empty($member->approved_by_name)) { $approved_by_name = $member->approved_by_name.''.$approved_by_rolename; }else { $approved_by_name = '-'; }
			$action_status='';
			if($status == 'approved'){
			$action_status .='<span style="color:green;font-weight:600;">Approved</span>';
			}elseif($status == 'reject'){
			$action_status .='<span style="color:red;font-weight:600;">Rejected</span>';
			}else{
			$action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
			}
			$htmlp = '<a class="popup_save" href="javascript:void(0);" rev="view_dcc_items" rel="'.$challan_id.'" data-title="(#'.$dc_no.') Delivery Challan" data-status="allow" style="margin-top:10px;"><span class="md-click-circle md-click-animate" style="height: 97px; width: 97px; top: -38.5312px; left: 29.4896px;"></span> '.$dc_no.'</a>';
			
			$html = '';
			//$html .= '<a href="javascript:;" class="edit tooltips" rel="'.$challan_id.'" title="Edit Delivery Challan" rev="edit_delivery_challan" data-original-title="Edit Proforma Invoice"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';
			$html .= '&nbsp;&nbsp;&nbsp;<a href="'.base_url().'download_delivery_challan_note/'.base64_encode($challan_id).'" class="edit tooltips" rel="'.$challan_id.'" title="Download Delivery Challan" rev="download_proforma_invoice" data-original-title="Download Delivery Challan" download><i class="fa fa-download" style="color:#000; font-size:15px;"></i></a>';
			//$html .= '&nbsp;&nbsp;&nbsp;<a href="'.base_url().'uploads/sample_excel/client_delivery_challan.xlsx" class="edit tooltips" rel="'.$challan_id.'" title="Print Delivery Challan" rev="download_proforma_invoice" data-original-title="Print Delivery Challan" download><i class="fa fa-print" style="color:#000; font-size:15px;"></i></a>';
			if($status !='approved'){
			//$html .= '&nbsp;&nbsp;&nbsp;<a class="btn btn-success btn-xs active_link_cmn" href="javascript:void(0);" rev="approved_delivery_challan" rel="'.$challan_id.'" title="Click here to Approved Record" data-status="Y">Approve</a>';
			}
			if($status =='pending'){
			if($check_permission_approve == 'Y'){
			$html .='<select class="statusselect" id="statusselect'.$challan_id.'" rev="approved_delivery_challan" rel="'.$challan_id.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
			}
			}elseif($status =='reject'){
			    if($check_permission_edit == 'Y'){
			        $html .='&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="editRecord tooltips" rel="'.$challan_id.'" title="Edit Record" rev="edit_delivery_challan" data-original-title="Edit Record"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';
			    }
			    if($check_permission_approve == 'Y'){
    			$html .='&nbsp;&nbsp;&nbsp;<select class="statusselect" id="statusselect'.$challan_id.'" rev="approved_delivery_challan" rel="'.$challan_id.'"><option class="statusselectoption" value="reject">Reject</option><option class="statusselectoption" value="approved">Approve</option></select>';
			    }
			}
			if(isset($project_id_p) && !empty($project_id_p)){
			$data[] = array(
			$i,
			$htmlp,
			$c_type,
			//$bp_code,
			//$customer_name,
			$consignee_name,
			$created_by_name,
			$approved_by_name,
			$action_status,
			$created_on);
			}else{
			$data[] = array(
			$i,
			$htmlp,
			$c_type,
			$bp_code,
			//$customer_name,
			$consignee_name,
			$created_by_name,
			$approved_by_name,
			$action_status,
			$created_on,
			$html
			);
			}
        }
        // pr($data,1);
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    
    
    public function view_tax_invoice_items()   
    {   
      $tax_invc_id = $this->input->post('id');
	  $tax_invc = $this->common_model->selectDetailsWhr('tbl_tax_invc','tax_invc_id',$tax_invc_id);
	 
	   $performa_invc = $this->common_model->selectDetailsWhr('tbl_proforma_invc','proforma_id',$tax_invc->convertid);
	   // pr($performa_invc);
      if(isset($tax_invc) && !empty($tax_invc)){
      $data['tax_invc_id'] = $tax_invc_id;
      $data['tax_invc_no'] = $tax_invc->tax_invc_no;
	  }else{
	  $data['tax_invc_id'] = $tax_invc_id;
      $data['tax_invc_no'] = '';
	  }
        $memData = $this->admin_model->getTaxInvcItemListRows($_POST,$tax_invc_id);
	    $sub_total = 0;
        $total_amount = 0 ;
        $gst_amount = 0 ;
        if(isset($memData) && !empty($memData)){
		foreach($memData as $member){
            if($member->gst_type == 'intra-state'){
                // pr($member);
                $gst_rate = $member->sgst + $member->cgst;
                 $gst_amount = ($member->taxable_amount * $gst_rate) / 100;
                $sub_total += $member->taxable_amount;
               
                $total_amount += $member->taxable_amount + $gst_amount;
                // $total_amount += $member->taxable_amount + $member->sgst_amount + $member->cgst_amount;
                // $gst_amount += $member->sgst_amount + $member->cgst_amount;
                // $sub_total += $member->taxable_amount;
            }else{
                // $total_amount += $member->taxable_amount + $member->gst_amount;
                // $gst_amount += $member->gst_amount;
                // $sub_total += $member->taxable_amount;
                $member->gst_amount = ($member->taxable_amount * $member->gst) / 100;
            $sub_total += $member->taxable_amount;
            $gst_amount += $member->gst_amount;
            $total_amount += $member->taxable_amount + $member->gst_amount;
            }
            //  $member->gst_amount = ($member->taxable_amount * $member->gst) / 100;
            // $new_sub_total += $member->taxable_amount;
            // $new_gst_amount += $member->gst_amount;
            // $new_total_amount += $member->taxable_amount + $member->gst_amount;
		}
        }
	  $data['sub_total'] = sprintf('%0.2f', $sub_total);
	  $data['total_amount'] = sprintf('%0.2f', $total_amount);
	  $data['gst_amount'] = sprintf('%0.2f', $gst_amount);
	  $data['auto_round_value'] = sprintf('%0.2f', $performa_invc->auto_round_value);

	  $view = $this->load->view('view-taxinvc-items',$data,TRUE);
      $this->json->jsonReturn(array('view'=>$view));
    }
    public function view_payment_receipt()   
    {   
        $tax_invc_id = $this->input->post('id');
	    $data['tax_invc_id'] = $tax_invc_id;
	   /* $received_payment = $this->admin_model->get_invoice_received_payment($tax_invc_id);
        if(isset($received_payment) && !empty($received_payment) && $received_payment > 0){
            $received_payment = sprintf('%0.2f', $received_payment);
        }else{
            $received_payment = 0.00;
        }
        $invoice_amount = $this->admin_model->get_invoice_amount($tax_invc_id);
        if(isset($invoice_amount) && !empty($invoice_amount) && $invoice_amount > 0){
            $invoice_amount = sprintf('%0.2f', $invoice_amount);
        }else{
            $invoice_amount = 0.00;
        }
        $rec = 0;
        if($invoice_amount >= $received_payment){
            $rec =  $invoice_amount - $received_payment;   
        }
        if(isset($rec) && !empty($rec) && $rec > 0){
            $rec = sprintf('%0.2f', $rec);
        }else{
            $rec = 0.00;
        }
        $data['invoice_amount'] = sprintf('%0.2f', $invoice_amount);
	    $data['received_payment'] = sprintf('%0.2f', $received_payment);
	    $data['balance_amount'] = $rec;
	    $tax_invc_no = $this->admin_model->get_invoice_no($tax_invc_id)->tax_invc_no;
        $tax_invc_date = $this->admin_model->get_invoice_no($tax_invc_id)->tax_invc_date;
        $data['tax_invc_no'] = $tax_invc_no;
	    $data['tax_invc_date'] = $tax_invc_date;*/
	    $view = $this->load->view('view-payment-receipt',$data,TRUE);
        $this->json->jsonReturn(array('view'=>$view));
    }
    
    public function view_proforma_invoice_items()   
    {   
      $proforma_id = $this->input->post('id');
	  $performa_invc = $this->common_model->selectDetailsWhr('tbl_proforma_invc','proforma_id',$proforma_id);
      if(isset($performa_invc) && !empty($performa_invc)){
      $data['proforma_id'] = $proforma_id;
	  $data['proforma_no'] = $performa_invc->proforma_no;
	  }else{
	  $data['proforma_id'] = $proforma_id;
	  $data['proforma_no'] = '';
	  }
	    $memData = $this->admin_model->getProInvcItemListRows($_POST,$proforma_id);
		$sub_total = 0;
        $total_amount = 0 ;
        $gst_amount = 0 ;
        if(isset($memData) && !empty($memData)){
            // pr($memData);
		foreach($memData as $member){
            if($member->gst_type == 'intra-state'){
                $total_amount += $member->taxable_amount + $member->sgst_amount + $member->cgst_amount;
                $gst_amount += $member->sgst_amount + $member->cgst_amount;
                $sub_total += $member->taxable_amount;
            }else{
                // $total_amount += $member->taxable_amount + $member->gst_amount;
                // $gst_amount += $member->gst_amount;
                // $sub_total += $member->taxable_amount;
                $sub_total += $member->taxable_amount;
                 $gst_rate = $member->gst;
                $gst_amount = ($sub_total * $gst_rate) / 100; // Calculate GST
                $total_amount = $sub_total + $gst_amount;
            }
		}

//         foreach($memData as $member){
//              $sub_total += $member->taxable_amount;
//              $gst_rate = $member->gst;
//             $gst_amount = ($sub_total * $gst_rate) / 100; // Calculate GST
//             $total_amount = $sub_total + $gst_amount;
// 		}

       
        }
        // pr($performa_invc,1);
      $data['proforma_data'] = $performa_invc;
	  $data['sub_total'] = sprintf('%0.2f', $sub_total);
	  $data['total_amount'] = sprintf('%0.2f', $total_amount);
	  $data['gst_amount'] = sprintf('%0.2f', $gst_amount);
	  $data['auto_round_value'] = sprintf('%0.2f', $performa_invc->auto_round_value);
	  $view = $this->load->view('view-proinvc-items',$data,TRUE);
      $this->json->jsonReturn(array('view'=>$view));
    }
    public function convert_to_tax_invoice()   
    {   
        $proforma_id = $this->input->post('id');
	    $data['proforma_id'] = $proforma_id;
        $performa_invc = $this->common_model->selectDetailsWhr('tbl_proforma_invc','proforma_id',$proforma_id);
        if(isset($performa_invc) && !empty($performa_invc)){
            if(isset($performa_invc->Converted) &&  $performa_invc->Converted == 'Y'){
                $this->json->jsonReturn(array(
                    'valid'=>TRUE,
                    'msg'=>'<div class="alert modify alert-success">Already Converted!</div>'
                )); 
            }elseif(isset($performa_invc->status) &&  $performa_invc->status != 'approved'){
                $this->json->jsonReturn(array(
                    'valid'=>TRUE,
                    'msg'=>'<div class="alert modify alert-success">Please approve proforma invoice!</div>'
                )); 
            }else{
                $view = $this->load->view('convert-tax-invoice',$data,TRUE);
                $this->json->jsonReturn(array('view'=>$view));
            }
        }else{
            $this->json->jsonReturn(array(
                'valid'=>TRUE,
                'msg'=>'<div class="alert modify alert-success">Invalid Proforma Invoice Details!</div>'
            )); 
        }
    }
    public function convert_tax_invoice_details()   
    {   
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','convert_to_tax_invoice');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $error = 'N';
                    $error_message = '';
                    $user_id = $this->session->userdata('user_id');
                    if(isset($user_id) && empty($user_id)){
                        $error = 'Y';
                        $error_message = 'Please loggedin!';
                    }
                    $proforma_id = $this->input->post('proforma_id');
                    if(isset($proforma_id) && !empty($proforma_id)){
                    $proforma_id = base64_decode($proforma_id);
                    }
                    if(isset($proforma_id) && empty($proforma_id)){
                        $error = 'Y';
                        $error_message = 'Invalid Proforma Details!';
                    }
                    $tax_invc_date = $this->input->post('tax_invc_date');
                    if(isset($tax_invc_date) && !empty($tax_invc_date)){
                    $tax_invc_date = date('Y-m-d',strtotime($tax_invc_date));
                    }
                    if(isset($tax_invc_date) && empty($tax_invc_date)){
                        $error = 'Y';
                        $error_message = 'Please enter Tax Invoice Date!';
                    }
                    $tax_invc_no = $this->input->post('tax_invc_no');
                    if(isset($tax_invc_no) && empty($tax_invc_no)){
                        $error = 'Y';
                        $error_message = 'Please enter Tax Invoice No!';
                    }
                    $taxAlreadyExist = $this->common_model->selectDetailsWhr('tbl_tax_invc','tax_invc_no',$tax_invc_no);
                    if(isset($taxAlreadyExist) && !empty($taxAlreadyExist)){
                        $error = 'Y';
                        $error_message = 'Tax Invoice No Already Exist!';
                    }
                    $performa_invc = $this->common_model->selectDetailsWhr('tbl_proforma_invc','proforma_id',$proforma_id);
                    if(isset($performa_invc) && empty($performa_invc)){
                        $error = 'Y';
                        $error_message = 'Invalid Proforma Details!';
                    }
                    $performa_invc_item = $this->common_model->selectAllWhr('tbl_proforma_invc_items','proforma_id',$proforma_id);
                    if(isset($performa_invc_item) && empty($performa_invc_item)){
                        $error = 'Y';
                        $error_message = 'Invalid Proforma Item Details!';
                    }
                    $save_tax_arr = $tax_invc_items_arr = $update_minus_stock_arr = array();
                    if($error == 'N'){
                        if(isset($performa_invc) && !empty($performa_invc) && isset($performa_invc_item) && !empty($performa_invc_item)){
                            if(isset($performa_invc->Converted) && !empty($performa_invc->Converted) && $performa_invc->Converted == 'N'){
                                if(isset($performa_invc->status) && !empty($performa_invc->status) && $performa_invc->status == 'approved'){
                                        if(isset($performa_invc->project_id) && !empty($performa_invc->project_id)){
                                            $save_tax_arr = array('project_id'=>$performa_invc->project_id,'tax_invc_no'=>$tax_invc_no, 
                                            'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),
                                            'display'=>'Y','status'=>'pending', 'tax_invc_date'=>$tax_invc_date,'convertid'=>$proforma_id);
                                            $tax_invc_id = $this->common_model->addData('tbl_tax_invc',$save_tax_arr);
                                            if(isset($tax_invc_id) && !empty($tax_invc_id)){
                                                $tax_invc_items_arr = $this->admin_model->getProformaInvoiceItems($proforma_id,$user_id,$tax_invc_id);
                                                if(isset($tax_invc_items_arr) && !empty($tax_invc_items_arr)){
                                                    $this->common_model->SaveMultiData('tbl_tax_invc_items',$tax_invc_items_arr);
                                                    $update_arr = array('Converted'=>'Y');
                                                    $result = $this->common_model->updateDetails('tbl_proforma_invc', 'proforma_id', $proforma_id,$update_arr);
                                                        foreach($tax_invc_items_arr as $key){
                                                             if(isset($performa_invc->project_id) && !empty($performa_invc->project_id) && isset($key['boq_code']) && !empty($key['boq_code'])){
                                                                $check_stock_details = $this->admin_model->check_stock_details($performa_invc->project_id,$key['boq_code']);
                                                                if(isset($check_stock_details) && !empty($check_stock_details)){
                                                                    $qty=0;
                                                                    if(isset($key['qty']) && !empty($key['qty']) 
                                                                    && $key['qty'] > 0){
                                                                        $qty = $key['qty'];
                                                                    }
                                                                    $tax_invoice_stock=0;
                                                                    if(isset($check_stock_details->tax_invoice_stock) && !empty($check_stock_details->tax_invoice_stock) 
                                                                    && $check_stock_details->tax_invoice_stock > 0){
                                                                        $tax_invoice_stock = $check_stock_details->tax_invoice_stock;
                                                                    }
                                                                    $tax_invoice_stock_val = 0;
                                                                    if($tax_invoice_stock >= $qty){
                                                                        $tax_invoice_stock_val = $tax_invoice_stock - $qty;   
                                                                        $update_minus_stock_arr[] = array('boq_code'=>$key['boq_code'],
                                                                        'tax_invoice_stock'=>$tax_invoice_stock_val,'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s')); 
                                                                    }
                                                                    
                                                                }
                                                             }
                                                        }
                                                    if($result){
                                                        if(isset($update_minus_stock_arr) && !empty($update_minus_stock_arr) && $performa_invc->project_id > 0){
                                                            $this->common_model->updateBOQInstallStock($update_minus_stock_arr,$performa_invc->project_id);
                                                        }
                                                       $this->json->jsonReturn(array(
                                                           'valid'=>TRUE,
                                                           'msg'=>'<div class="alert modify alert-success">Proforma Invoice Converted to Tax Invoice Successfully!</div>',
                                                           'redirect' => base_url().'create-proforma-invoice'
                                                       )); 
                                                    }else{
                                                        $this->json->jsonReturn(array(  
                                            			    'valid'=>FALSE,
                                            				'msg'=>'<div class="alert modify alert-danger">Error! While Convert Proforma Invoice!</div>'
                                            			));
                                                    }
                                                }else{
                                                    $this->json->jsonReturn(array(  
                                        			    'valid'=>FALSE,
                                        				'msg'=>'<div class="alert modify alert-danger">Error! While Convert Proforma Invoice!</div>'
                                        			));
                                                }
                                            }else{
                                                $this->json->jsonReturn(array(  
                                    			    'valid'=>FALSE,
                                    				'msg'=>'<div class="alert modify alert-danger">Error! While Convert Proforma Invoice!</div>'
                                    			));
                                            }
                                        }else{
                                            $this->json->jsonReturn(array(  
                            			        'valid'=>FALSE,
                            				    'msg'=>'<div class="alert modify alert-danger">Error! While Convert Proforma Invoice!</div>'
                            			    ));
                                        }
                                }else{
                                        $this->json->jsonReturn(array(  
                        			        'valid'=>FALSE,
                        				    'msg'=>'<div class="alert modify alert-danger">Error! Please Approved Proforma Invoice!</div>'
                        			    ));
                                    }
                            }else{
                                $this->json->jsonReturn(array(  
                    			    'valid'=>FALSE,
                    				'msg'=>'<div class="alert modify alert-danger">Error! Proforma Invoice Already Converted!</div>'
                    			));
                            }
                        }else{
                            $this->json->jsonReturn(array(  
                    		    'valid'=>FALSE,
                    			'msg'=>'<div class="alert modify alert-danger">Error! While Convert Proforma Invoice!</div>'
                    		));
                        }
                    }else{
                        $this->json->jsonReturn(array(  
                    		'valid'=>FALSE,
                    		'msg'=>'<div class="alert modify alert-danger">Error! '.$error_message.'</div>'
                    	));
                    }    
                }else{
                    $this->json->jsonReturn(array(
                        'valid'=>TRUE,
                        'msg'=>'<div class="alert modify alert-success">You have no Permission!!</div>'
                    )); 
                }
            }else{
                $this->json->jsonReturn(array(
                    'valid'=>TRUE,
                    'msg'=>'<div class="alert modify alert-success">You have no Permission!!</div>'
                ));
            }
        }else{
            $this->json->jsonReturn(array(
                'valid'=>TRUE,
                'msg'=>'<div class="alert modify alert-success">You have no Permission!!</div>'
            ));
        }
        
    }
    
    public function view_dcc_items()   
    {   
        $challan_id = $this->input->post('id');
	    $data['challan_id'] = $challan_id;
	    $dc_items_data = $this->common_model->selectDetailsWhereAllDY('tbl_deliv_challan_items', 'challan_id',$challan_id);
        $data['dc_items_data'] = $dc_items_data;
        $dc_data = $this->common_model->selectDetailsWhr('view_dcc','challan_id',$challan_id);
        $data['dc_data'] = $dc_data;
        $consigneeid =  (isset($dc_data->consignee) && !empty($dc_data->consignee))?$dc_data->consignee:'0';
	    $consignee_data = $this->common_model->selectDetailsWhereAllDY('tbl_deliv_challan_consignee', 'id',$consigneeid);
        $data['consignee_data'] = $consignee_data;
        // pr($data,1);
        $view = $this->load->view('view-dc-items',$data,TRUE);
        $this->json->jsonReturn(array('view'=>$view));
    }
    public function download_tax_invoice()   
    {   
      $tax_invc_id = $this->input->post('id');
	  $data['tax_invc_id'] = $tax_invc_id;
      $view = $this->load->view('download-tax-invoice',$data,TRUE);
      $this->json->jsonReturn(array('view'=>$view));
    }
    public function download_tax_invoice_format_1()    
    {
        $type="tax";
        $tax_invc_id = $this->uri->segment(2);
        if(isset($tax_invc_id) && !empty($tax_invc_id)){
        $tax_invc_id = base64_decode($tax_invc_id);
        }
        $tax_invc_data = $this->admin_model->get_invoice_no($tax_invc_id);
        $tax_invc_items_data = $this->common_model->selectDetailsWhereAllDY('tbl_tax_invc_items', 'tax_invc_id',$tax_invc_id);
        $tax_invc_items_hsn_data = $this->admin_model->get_invoice_hsn_data('tbl_tax_invc_items', $tax_invc_id);
        $this->excel->invoice_format_1($tax_invc_data,$tax_invc_items_data,$tax_invc_items_hsn_data,$type); 
	}
	public function download_tax_invoice_format_2()    
    {
        $type="tax";
        $tax_invc_id = $this->uri->segment(2);
        if(isset($tax_invc_id) && !empty($tax_invc_id)){
        $tax_invc_id = base64_decode($tax_invc_id);
        }
        $tax_invc_data = $this->admin_model->get_invoice_no($tax_invc_id);
        $tax_invc_items_data = $this->common_model->selectDetailsWhereAllDY('tbl_tax_invc_items', 'tax_invc_id',$tax_invc_id);
        $this->excel->invoice_format($tax_invc_data,$tax_invc_items_data,$type); 
	}
	public function download_proforma_invoice_format_2()    
    {
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);
        $type="proforma";
        $proforma_id = $this->uri->segment(2);
        if(isset($proforma_id) && !empty($proforma_id)){
        $proforma_id = base64_decode($proforma_id);
        }
        $proforma_invc_data = $this->admin_model->get_proforma_invoice_details($proforma_id);
        $proforma_invc_items_data = $this->common_model->selectDetailsWhereAllDY('tbl_proforma_invc_items', 'proforma_id',$proforma_id);
        $this->excel->invoice_format($proforma_invc_data,$proforma_invc_items_data,$type); 
	}
	public function download_proforma_invoice_format_1()    
    {
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);
        $type="proforma";
        $proforma_id = $this->uri->segment(2);
        if(isset($proforma_id) && !empty($proforma_id)){
        $proforma_id = base64_decode($proforma_id);
        }
        $proforma_invc_data = $this->admin_model->get_proforma_invoice_details($proforma_id);
        $proforma_invc_items_data = $this->common_model->selectDetailsWhereAllDY('tbl_proforma_invc_items', 'proforma_id',$proforma_id);
        $proforma_invc_items_hsn_data = $this->admin_model->get_invoice_hsn_data('tbl_proforma_invc_items', $proforma_id);
        $this->excel->invoice_format_1($proforma_invc_data,$proforma_invc_items_data,$proforma_invc_items_hsn_data,$type); 
	}
	public function download_delivery_challan_note()    
    {
        
    
        $challan_id = $this->uri->segment(2);
        if(isset($challan_id) && !empty($challan_id)){
        $challan_id = base64_decode($challan_id);
        }
        
        $delivery_challan_data = $this->common_model->selectDetailsWhereAllDY('tbl_delivery_challan', 'challan_id',$challan_id);
        $delivery_challan_items_data = $this->common_model->selectDetailsWhereAllDY('tbl_deliv_challan_items', 'challan_id',$challan_id);
        
        $consigneeid =  (isset($delivery_challan_data[0]->consignee) && !empty($delivery_challan_data[0]->consignee))?$delivery_challan_data[0]->consignee:'0';
	    $consignee_data = $this->common_model->selectDetailsWhereAllDY('tbl_deliv_challan_consignee', 'id',$consigneeid);
        $this->excel->delivery_challan_note($delivery_challan_data,$delivery_challan_items_data,$consignee_data); 
        
	}
    public function download_proforma_invoice()   
    {   
      $proforma_id = $this->input->post('id');
	  $data['proforma_id'] = $proforma_id;
      $view = $this->load->view('download-proforma-invoice',$data,TRUE);
      $this->json->jsonReturn(array('view'=>$view));
    }
    public function view_dcvs_items()   
    {   
      $vs_id = $this->input->post('id');
	  $data['vs_id'] = $vs_id;
      $view = $this->load->view('view-dcvs-items',$data,TRUE);
      $this->json->jsonReturn(array('view'=>$view));
    }
    public function view_dciwip_items()   
    {   
      $i_wip_no = $this->input->post('id');
	  $iwip_data=$this->common_model->selectDetailsWhr('tbl_installed_wip','i_wip_id',$i_wip_no);
      if(isset($iwip_data) && !empty($iwip_data)){
        $data['i_wip_no'] = $i_wip_no;
        $data['view_i_wip_no'] = $iwip_data->i_wip_no;
      }else{
        $data['i_wip_no'] = $i_wip_no;
        $data['view_i_wip_no'] = '';
      }
      $view = $this->load->view('view-dciwip-items',$data,TRUE);
      $this->json->jsonReturn(array('view'=>$view));
    }
    public function view_dcpwip_items()   
    {   
      $p_wip_no = $this->input->post('id');
	  $p_data=$this->common_model->selectDetailsWhr('tbl_provisional_wip','p_wip_id',$p_wip_no);
      if(isset($p_data) && !empty($p_data)){
        $data['p_wip_no'] = $p_wip_no;
        $data['view_p_wip_no'] = $p_data->p_wip_no;
      }else{
        $data['p_wip_no'] = $p_wip_no;
        $data['view_p_wip_no'] = '';
      }
      $view = $this->load->view('view-dcpwip-items',$data,TRUE);
      $this->json->jsonReturn(array('view'=>$view));
    }
    public function view_boq_exceptional_items()   
    {   
      $exceptional_id = $this->input->post('id');
	  $exceptionalDetails = $this->admin_model->getExceptionalDetails($exceptional_id);
      if(isset($exceptionalDetails) && !empty($exceptionalDetails)){
      $data['exceptional_id'] = $exceptional_id;
      $data['view_exceptional_no'] = $exceptionalDetails[0]->exceptional_no;
      }else{
      $data['exceptional_id'] = $exceptional_id;
      $data['view_exceptional_no'] = '';
      }
      $view = $this->load->view('view-boq-exceptional-items',$data,TRUE);
      $this->json->jsonReturn(array('view'=>$view));
    }
    
    
    public function boq_transaction_display() 
		{
		$boq_transaction_cnt = $this->input->post('boq_transaction_cnt');
        $project_id = $this->input->post('project_id');
        if(isset($project_id) && !empty($project_id)){
        $project_id = base64_decode($project_id);
        }
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$data = $row = array();
		$memData = $this->admin_model->getBOQTransListRows($_POST,$boq_transaction_cnt,$project_id);
		$allCount = $this->admin_model->countBOQTransListAll($boq_transaction_cnt,$project_id);
		$countFiltered = $this->admin_model->countBOQTransListFiltered($_POST,$boq_transaction_cnt,$project_id);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $boq_items_id = $member->boq_items_id; }else { $boq_items_id = '-'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '-'; }
			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = '0'; }
			if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = '0'; }
			if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = '0'; }
			if(isset($member->non_schedule) && !empty($member->non_schedule)) { $non_schedule = $member->non_schedule; }else { $non_schedule = 'N'; }
			if(isset($member->status) && !empty($member->status) && $status == 'Y') { $status = 'Approved'; }else { $status = 'Not Approved'; }
			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
			if(isset($member->o_design_qty) && !empty($member->o_design_qty)) { $o_design_qty = $member->o_design_qty; }else { $o_design_qty = '0'; }
			$data[] = array(
			$i,
			$bp_code,
			$boq_code,
			$item_description,
			$unit,
			$scheduled_qty,
			$o_design_qty,
			$design_qty,
			$rate_basic,
			$gst,
			$non_schedule
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    public function project_boq_item_list() 
	{
            $projectId = $_GET['project_id'];
            if(isset($projectId) && !empty($projectId)){
                $project_id =$projectId;
                $checkBOQUploadTransaction = $this->admin_model->checkBOQUploadTransactionCount($project_id);
            }else{
                $project_id = null;
                $checkBOQUploadTransaction = 0;
            }
           
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$data = $row = array();
        $check_permission_status = 'N';
		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_boq_details');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_status = 'Y';
                }
            }
		}
		$check_permission_delete = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_datad=$this->common_model->selectDetailsWhr('tbl_submenu','action','delete_boq_details');
            if(isset($submenu_datad->submenu_id) && !empty($submenu_datad->submenu_id)){
                $submenu_idd = $submenu_datad->submenu_id;
                $check_permissiond=$this->admin_model->check_permission($submenu_idd,$logrole_id);
                if(isset($check_permissiond) && !empty($check_permissiond)){
                    $check_permission_delete = 'Y';
                }
            }
		}
		$memData = $this->admin_model->getBOQListRows($_POST,$project_id);
		$allCount = $this->admin_model->countBOQListAll();
		$countFiltered = $this->admin_model->countBOQListFiltered($_POST,$projectId);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $boq_items_id = $member->boq_items_id; }else { $boq_items_id = '0'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description =$member->item_description;}else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '-'; }
			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = '0'; }
			if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = '0'; }
			if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = '0'; }
			if(isset($member->non_schedule) && !empty($member->non_schedule)) { $non_schedule = $member->non_schedule; }else { $non_schedule = 'N'; }
			if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = 'N'; }
			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
			if(isset($member->o_design_qty) && !empty($member->o_design_qty)) { $o_design_qty = $member->o_design_qty; }else { $o_design_qty = '0'; }
			if(isset($member->created_by_rolename) && !empty($member->created_by_rolename)) { $created_by_rolename = ' ('.$member->created_by_rolename.')'; }else { $created_by_rolename = ''; }
			if(isset($member->created_by_name) && !empty($member->created_by_name)) { $created_by_name = $member->created_by_name.''.$created_by_rolename; }else { $created_by_name = '-'; }
			if(isset($member->approved_by_rolename) && !empty($member->approved_by_rolename)) { $approved_by_rolename = ' ('.$member->approved_by_rolename.')'; }else { $approved_by_rolename = ''; }
			if(isset($member->approved_by_name) && !empty($member->approved_by_name)) { $approved_by_name = $member->approved_by_name.''.$approved_by_rolename; }else { $approved_by_name = '-'; }
			if(isset($member->created_on) && !empty($member->created_on)) { $created_on = $member->created_on; }else { $created_on = ''; }
			$action_status='';
			if($status == 'Y'){
			$action_status .='<span style="color:green;font-weight:600;">Approved</span>';
			}else{
			$action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
			}
			$non_schedule_txt='NS';
			if($non_schedule == 'N'){
			$non_schedule_txt ='Sch';
			}
			$html = '';
			if($check_permission_delete == 'Y'){
			$html.='<a href="javascript:;" class="delete tooltips deleteRecord" rel="'.$boq_items_id.'" title="" rev="delete_boq_details" data-original-title="Delete Role"><i class="fa fa-trash-o" style="color:#a94442; font-size: 15px;"></i></a>';
			}
			if($status == 'N' && $check_permission_status == 'Y'){
			$html .='&nbsp;&nbsp;&nbsp;<a class="btn btn-success btn-xs active_link_cmn" href="javascript:void(0);" rev="approved_boq_details" rel="'.$boq_items_id.'" title="Click here to Approved Record" data-status="Y">Approve</a>';
			}
			$data[] = array(
			$i,
			$boq_code,
			$bp_code,
			$item_description,
			$unit,
			$scheduled_qty,
			$design_qty,
			$design_qty,
			$rate_basic,
			$gst,
			$non_schedule_txt,
			$action_status,
			$created_by_name,
			$approved_by_name,
			$created_on,
			$html
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
            'BOQUploadTransaction'=>$checkBOQUploadTransaction,
        );
        echo json_encode($output);
		}

    }
    public function boq_scha_list_display() 
		{
		$project_id = $this->input->post('project_id');
        if(isset($project_id) && !empty($project_id)){
        $project_id = base64_decode($project_id);
        }
        $type='operable_a';
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$data = $row = array();
		$memData = $this->admin_model->getBOQOperListRows($_POST,$project_id,$type);
		$allCount = $this->admin_model->countBOQOperListAll($project_id,$type);
		$countFiltered = $this->admin_model->countBOQOperListFiltered($_POST,$project_id,$type);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $boq_items_id = $member->boq_items_id; }else { $boq_items_id = '-'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '-'; }
			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = '0'; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = '0'; }
			if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = '0'; }
			if(isset($member->non_schedule) && !empty($member->non_schedule)) { $non_schedule = $member->non_schedule; }else { $non_schedule = 'N'; }
			if(isset($member->status) && !empty($member->status) && $status == 'Y') { $status = 'Approved'; }else { $status = 'Not Approved'; }
			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
            if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }

			// $design_qty = $this->admin_model->get_design_qty($project_id,$boq_code);
		    // if(isset($design_qty) && !empty($design_qty)) { $design_qty = $design_qty; }else { $design_qty = '0'; }
			
			$oprableAmount = 0;
			$oprableAmount = $rate_basic * $design_qty;
			$gst_amount=0;
			if($oprableAmount > 0 && $gst > 0){
			$gst_amount =  $oprableAmount * ($gst/100);   
			}
			$oprableAmountGST=0;
			$oprableAmountGST = $gst_amount + $oprableAmount;
			$data[] = array(
			$i,
			//$bp_code,
			$boq_code,
			$item_description,
			$unit,
			$scheduled_qty,
			$design_qty,
			$rate_basic,
			sprintf('%0.2f', $oprableAmount),
			sprintf('%0.2f', $gst),
			sprintf('%0.2f', $gst_amount),
			sprintf('%0.2f', $oprableAmountGST)
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    
    public function boq_schc_list_display() 
		{
		$project_id = $this->input->post('project_id');
        if(isset($project_id) && !empty($project_id)){
        $project_id = base64_decode($project_id);
        }
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$data = $row = array();
		$memData = $this->admin_model->getBOQCListRows($_POST,$project_id);
		$allCount = $this->admin_model->countBOQCListAll($project_id);
		$countFiltered = $this->admin_model->countBOQCListFiltered($_POST,$project_id);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $boq_items_id = $member->boq_items_id; }else { $boq_items_id = '-'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '-'; }
			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = '0'; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = '0'; }
			if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = '0'; }
			if(isset($member->non_schedule) && !empty($member->non_schedule)) { $non_schedule = $member->non_schedule; }else { $non_schedule = 'N'; }
			if(isset($member->status) && !empty($member->status) && $status == 'Y') { $status = 'Approved'; }else { $status = 'Not Approved'; }
			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
			if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
			$oprableAmount = 0;
			$oprableAmount = $design_qty * $rate_basic;
			$gst_amount=0;
			if($gst > 0 && $oprableAmount > 0){
			$gst_amount = $oprableAmount * ($gst/100); 
			}
			$oprableAmountGST = $gst_amount + $oprableAmount;
			$data[] = array(
			$i,
			//$bp_code,
			$boq_code,
			$item_description,
			$unit,
			$design_qty,
			$rate_basic,
			sprintf('%0.2f', $oprableAmount),
			sprintf('%0.2f', $gst),
			sprintf('%0.2f', $gst_amount),
			sprintf('%0.2f', $oprableAmountGST)
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    public function boq_schb_list_display() 
		{
		$project_id = $this->input->post('project_id');
        if(isset($project_id) && !empty($project_id)){
        $project_id = base64_decode($project_id);
        }
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$data = $row = array();
		$memData = $this->admin_model->getBOQOperListRows($_POST,$project_id,'B_pos');
		$allCount = $this->admin_model->countBOQOperListAll($project_id,'B_pos');
		$countFiltered = $this->admin_model->countBOQOperListFiltered($_POST,$project_id,'B_pos');
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
		    if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $boq_items_id = $member->boq_items_id; }else { $boq_items_id = '-'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '-'; }
			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = '0'; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = '0'; }
			if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = '0'; }
			if(isset($member->non_schedule) && !empty($member->non_schedule)) { $non_schedule = $member->non_schedule; }else { $non_schedule = 'N'; }
			if(isset($member->status) && !empty($member->status) && $status == 'Y') { $status = 'Approved'; }else { $status = 'Not Approved'; }
			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
			if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
			$var_qty = 0;
			$var_qty = $design_qty - $scheduled_qty;  
			$oprableAmount = 0;
			$oprableAmount = $design_qty * $rate_basic;
			$gst_amount=0;
			if($gst > 0 && $oprableAmount > 0){
			$gst_amount = $oprableAmount * ($gst/100); 
			}
			$oprableAmountGST = $gst_amount + $oprableAmount;
			$data[] = array(
			$i,
			//$bp_code,
			$boq_code,
			$item_description,
			$unit,
			$scheduled_qty,
			'+'.$var_qty,
			$design_qty,
			$rate_basic,
			sprintf('%0.2f', $oprableAmount),
			sprintf('%0.2f', $gst),
			sprintf('%0.2f', $gst_amount),
			sprintf('%0.2f', $oprableAmountGST)
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    public function boq_schbn_list_display() 
		{
		$project_id = $this->input->post('project_id');
        if(isset($project_id) && !empty($project_id)){
        $project_id = base64_decode($project_id);
        }
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$data = $row = array();
    $memData = $this->admin_model->getBOQOperListRows($_POST,$project_id,'B_nav');
		$allCount = $this->admin_model->countBOQOperListAll($project_id,'B_nav');
		$countFiltered = $this->admin_model->countBOQOperListFiltered($_POST,$project_id,'B_nav');
        $i = $_POST['start'];
        $boq_pending = array();
        $countFiltered = 0;
		foreach($memData as $member){
            $i++;
            if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $boq_items_id = $member->boq_items_id; }else { $boq_items_id = '-'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '-'; }
			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = '0'; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = '0'; }
			if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = '0'; }
			if(isset($member->non_schedule) && !empty($member->non_schedule)) { $non_schedule = $member->non_schedule; }else { $non_schedule = 'N'; }
			if(isset($member->status) && !empty($member->status) && $status == 'Y') { $status = 'Approved'; }else { $status = 'Not Approved'; }
			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
			if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
			
			$qty = 0;
			$qty = $design_qty - $scheduled_qty;    
			$var_qty = 0;
			$var_qty = $scheduled_qty - $design_qty;  
			
			$oprableAmount = 0;
			$oprableAmount = $rate_basic * $design_qty;
			$gst_amount=0;
			if($oprableAmount > 0 && $gst > 0){
			$gst_amount =  $oprableAmount * ($gst/100);   
			}
			$oprableAmountGST=0;
			$oprableAmountGST = $gst_amount + $oprableAmount;
			
            $boqExceptional = $this->admin_model->getBOQPendingExceptional($project_id,$boq_code);

            if(empty($boqExceptional)) {
                
                $countFiltered++;

                $data[] = array(
                    $i,
                    //$bp_code,
                    $boq_code,
                    $item_description,
                    $unit,
                    $scheduled_qty,
                    '-'.$var_qty,
                    $design_qty,
                    $rate_basic,
                    sprintf('%0.2f', $oprableAmount),
                    sprintf('%0.2f', $gst),
                    sprintf('%0.2f', $gst_amount),
                    sprintf('%0.2f', $oprableAmountGST)
                );
            } else {
                $boq_pending[] = $boq_code;
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
            'boq_approval_pending' => $boq_pending,
        );
        echo json_encode($output);
		}

    }
    public function server_info() {
        echo phpinfo();
    }
    public function project_boq_trans_list_display() 
		{
		$transaction_id = $this->input->post('transaction_id');
        if(isset($transaction_id) && !empty($transaction_id)){
        $transaction_id = $transaction_id;
        }
        $transaction_type = $this->input->post('transaction_type');
        if(isset($transaction_type) && !empty($transaction_type)){
        $transaction_type = $transaction_type;
        }
        $project_id = $this->input->post('project_id');
        if(isset($project_id) && !empty($project_id)){
        $project_id = base64_decode($project_id);
        }
        $filter = $this->input->post('filter');
        if(isset($filter) && !empty($filter)){
        $filter = $filter;
        }else{
        $filter = 'original';    
        }
        $calculatedfiler = $this->input->post('calculatedfiler');
        if(isset($calculatedfiler) && !empty($calculatedfiler)){
        $calculatedfiler = $calculatedfiler;
        }else{
        $calculatedfiler = 'without_gst';    
        }
        $status_txtpost = $this->input->post('status_txt');
        if(isset($status_txtpost) && !empty($status_txtpost)){
            $status_txt = $status_txtpost;
        }else{
            $status_txt = '';
        }
        $check_permission_status = 'N';
		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_boq_details');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_status = 'Y';
                }
            }
		}
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
    		$data = $row = array();
    		$is_first_upload = 0;
    		if($transaction_type == 'boq_upload' || $transaction_type == 'add_edit_boq'){
        		$memData = $this->admin_model->getViewBOQTransListRows($_POST,$project_id,$transaction_id,$status_txt);
        		$allCount = $this->admin_model->countViewBOQTransListAll($project_id,$transaction_id,$status_txt);
        		$countFiltered = $this->admin_model->countViewBOQTransListFiltered($_POST,$project_id,$transaction_id,$status_txt);
        		$trans_data=$this->common_model->selectDetailsWhr('tbl_boq_transactions','id',$transaction_id);
        		if(isset($trans_data->is_first_upload) && !empty($trans_data->is_first_upload)){
        		    $is_first_upload = 1;
        		}
        	}elseif($transaction_type == 'boq_exceptional_appr'){
        		$memData = $this->admin_model->getBOQExceptnlViewListRows($_POST,$project_id,$transaction_id,$status_txt);
        		$allCount = $this->admin_model->countBOQExceptnlViewListAll($project_id,$transaction_id,$status_txt);
        		$countFiltered = $this->admin_model->countBOQExceptnlViewListFiltered($_POST,$project_id,$transaction_id,$status_txt);
            }
            $i = $_POST['start'];
            $unique_arr = [];
            $boq_code_arr = [];
        	foreach($memData as $member){
                    if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $boq_items_id = $member->boq_items_id; }else { $boq_items_id = '-'; }
        			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
        			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
        			if(isset($member->item_description) && !empty($member->item_description)) { $item_description =$member->item_description; }else { $item_description = '-'; }
        			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '-'; }
        			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = '0'; }
        			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = '0'; }
        			if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = '0'; }
        			if(isset($member->non_schedule) && !empty($member->non_schedule)) { $non_schedule = $member->non_schedule; }else { $non_schedule = 'N'; }
        			if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = 'N'; }
        			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
        			if(isset($member->is_billing_inter_state) && !empty($member->is_billing_inter_state)) { $is_billing_inter_state = $member->is_billing_inter_state; }else { $is_billing_inter_state = 'N'; }
        			if(isset($member->o_design_qty) && !empty($member->o_design_qty)) { $o_design_qty = $member->o_design_qty; }else { $o_design_qty = '0'; }
        			if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
        			if(isset($member->display) && !empty($member->display)) { $display = $member->display; }else { $display = 'N'; }
        			if(isset($member->EA_qty) && !empty($member->EA_qty)) { $EA_qty = $member->EA_qty; }else { $EA_qty = 0; }
        			if(isset($member->upload_design_qty) && !empty($member->upload_design_qty)) { $upload_design_qty = $member->upload_design_qty; }else { $upload_design_qty = 0; }
        			if(in_array($boq_code,$boq_code_arr)){
        			    continue;
        			}
        			$i++;
        			array_push($boq_code_arr,$boq_code);
        			$action_status='';
        			if($status == 'Y'){
        			$action_status .='<span style="color:green;font-weight:600;">Approved</span>';
        			if($display == 'N'){
        			$action_status .='<br><span style="color:red;font-weight:600;">Deleted</span>';
        			}
        			}else{
        			$action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
        			if($display == 'N'){
        			$action_status .='<br><span style="color:red;font-weight:600;">Deleted</span>';
        			}
        			}
        			$positive_var = 0;
        			$negative_var = 0;
        			if($design_qty >= $scheduled_qty){
        			    $positive_var = $design_qty - $scheduled_qty;
        			}else{
        			    $negative_var = $scheduled_qty - $design_qty;       
        			}
        			$dqty=0;
        			$dqty_amount = 0;
        			if($is_first_upload == 1){
        			    $dqty =  $scheduled_qty;
        			    $dqty_amount = $dqty * $rate_basic;
        			}else{
        			     $dqty = $upload_design_qty;
        			     $dqty_amount = $upload_design_qty * $rate_basic;
        			}
        			$positive_var_amount = 0;
        			$negative_var_amount = 0;
        			$scheduled_amount = 0;
        			$design_amount = 0;
        			$non_sch_amount = 0;
        			$ea_amount=0;
        		    $positive_var_amount = $positive_var * $rate_basic;
        		    $negative_var_amount = $negative_var * $rate_basic;
        			$scheduled_amount = $scheduled_qty * $rate_basic;
        			$ea_amount = $EA_qty * $rate_basic;
        			$design_amount = $design_qty * $rate_basic;
        			if($non_schedule == 'Y'){
        			    $non_sch_amount = $design_qty * $rate_basic;
        			}
        			$positive_var_amount_gst = 0;
        			$scheduled_amount_gst = 0;
        			$scheduled_gst_amount = 0;
        			$negative_var_amount_gst = 0;
        			$design_amount_gst = 0;
        			$non_sch_amount_gst = 0;
        			$design_gst_amount = 0;
        			$ea_gst_amount=0;
        			$ea_amount_gst=0;
        			if($gst > 0){
        			    $positive_var_amount_gst = $positive_var_amount + ($positive_var_amount * ($gst/100));    
        			    $scheduled_amount_gst = $scheduled_amount + ($scheduled_amount * ($gst/100)); 
        			    $scheduled_gst_amount = $scheduled_amount * ($gst/100); 
        			    $ea_amount_gst = $ea_amount + ($ea_amount * ($gst/100)); 
        			    $ea_gst_amount = $ea_amount * ($gst/100); 
        			    $negative_var_amount_gst = $negative_var_amount + ($negative_var_amount * ($gst/100)); 
        			    $design_amount_gst = $design_amount + ($design_amount * ($gst/100)); 
        			    $non_sch_amount_gst = $non_sch_amount + ($non_sch_amount * ($gst/100)); 
        			    $design_gst_amount = $design_amount * ($gst/100); 
        			    $dqty_amount_gst = $dqty_amount + ($dqty_amount * ($gst/100)); 
        			    $dqty_gst_amount = $dqty_amount * ($gst/100); 
        			}
        			$html='';
        			if($status == 'N' && $check_permission_status == 'Y'){
                        $html .='&nbsp;&nbsp;&nbsp;<a class="btn btn-success btn-xs active_link_wt_approve" href="javascript:void(0);" rev="approved_boq_details" rel="'.$boq_items_id.'" title="Click here to Approved Record" data-status="Y">Approve</a>';
        			    //$html .='&nbsp;&nbsp;&nbsp;<a class="btn btn-success btn-xs active_link_cmn" href="javascript:void(0);" rev="approved_boq_details" rel="'.$boq_items_id.'" title="Click here to Approved Record" data-status="Y">Approve</a>';
        			}
        			
        			if($filter == 'original'){
        			    if($transaction_type == 'boq_upload' || $transaction_type == 'add_edit_boq'){
        			        if($check_permission_status == 'Y' && !empty($status_txt)){
            			    $data[] = array(
                			$i,
                			$boq_code,
                			$item_description,
                			$unit,
                			$dqty,
                			$rate_basic,
                			sprintf('%0.2f', $dqty_amount),
                			$gst,
                			sprintf('%0.2f', $dqty_gst_amount),
                			sprintf('%0.2f', $dqty_amount_gst),
                			$html);
            			    }else{
        			        $data[] = array(
                			$i,
                			$boq_code,
                			$item_description,
                			$unit,
                			$dqty,
                			$rate_basic,
                			sprintf('%0.2f', $dqty_amount),
                			$gst,
                			sprintf('%0.2f', $dqty_gst_amount),
                			sprintf('%0.2f', $dqty_amount_gst));
            			}
        			    }elseif($transaction_type=='boq_exceptional_appr'){

                            $bom_subtable_data =  $this->get_bom_item_subtable_data_ea_approval($project_id,$boq_code,$EA_qty,$transaction_id);
                            $unique_arr = [];
                            $bom_subtable_data_unique = [];
                            foreach($bom_subtable_data['bom_data'] as $keys=>$vales){
                                if(!in_array($vales[0],$unique_arr)){
                                    array_push($bom_subtable_data_unique,$vales);
                                    array_push($unique_arr,$vales[0]);
                                }
                            }
                            
                            $bom_subtable = $bom_subtable_data_unique;
                            $count = $bom_subtable_data['count'];

        			        if($check_permission_status == 'Y' && !empty($status_txt)){
                                $bom_view='';
                                //$bom_view .='<a class="openBomview" href="javascript:void(0);" data-project_id="'.base64_encode($project_id).'" data-boq_code="'.$boq_code.'">Close</a>';

                			    $data[] = array(
                    			$i,
                    			$boq_code,
                    			$item_description,
                    			$unit,
                    			$EA_qty,
                    			$rate_basic,
                    			sprintf('%0.2f', abs($ea_amount)),
                    			$gst,
                    			sprintf('%0.2f', abs($ea_gst_amount)),
                    			sprintf('%0.2f', abs($ea_amount_gst)),
                                $bom_view,
                                'subTableData' => $bom_subtable,
                                );
                			 }else{
            			        $data[] = array(
                    			$i,
                    			$boq_code,
                    			$item_description,
                    			$unit,
                    			$EA_qty,
                    			$rate_basic,
                    			sprintf('%0.2f', abs($ea_amount)),
                    			$gst,
                    			sprintf('%0.2f', abs($ea_gst_amount)),
                    			sprintf('%0.2f', abs($ea_amount_gst)));
                			}
        			    }
        			}else{
        			    if($calculatedfiler == 'without_gst' && $filter == 'calculated'){
        			        $data[] = array(
                			$i,
                			$boq_code,
                			$item_description,
                			$unit,
                			$scheduled_qty,
                			$o_design_qty,
                			$design_qty,
                			$rate_basic,
                			$positive_var,
                			$negative_var,
                			$positive_var,
                			sprintf('%0.2f', $positive_var_amount),
                			sprintf('%0.2f', $scheduled_amount),
                			sprintf('%0.2f', $positive_var_amount),
                			sprintf('%0.2f', $negative_var_amount),
                			sprintf('%0.2f', $design_amount),
                			sprintf('%0.2f', $non_sch_amount),
                			sprintf('%0.2f', $design_amount));
        			    }else{
        			        $data[] = array(
                			$i,
                			$boq_code,
                			$item_description,
                			$unit,
                			$scheduled_qty,
                			$o_design_qty,
                			$design_qty,
                			$rate_basic,
                			$positive_var,
                			$negative_var,
                			$positive_var,
                			sprintf('%0.2f', $positive_var_amount),
                			sprintf('%0.2f', $positive_var_amount_gst),
                			sprintf('%0.2f', $scheduled_amount),
                			sprintf('%0.2f', $scheduled_amount_gst),
                			sprintf('%0.2f', $positive_var_amount),
                			sprintf('%0.2f', $positive_var_amount_gst),
                			sprintf('%0.2f', $negative_var_amount),
                			sprintf('%0.2f', $negative_var_amount_gst),
                			sprintf('%0.2f', $design_amount),
                			sprintf('%0.2f', $design_amount_gst),
                			sprintf('%0.2f', $non_sch_amount),
                			sprintf('%0.2f', $non_sch_amount_gst),
                			sprintf('%0.2f', $design_amount),
                			$gst,
                			sprintf('%0.2f', $design_gst_amount),
                			sprintf('%0.2f', $design_amount_gst)
                			);       
        			    }
            		}
                }
                // pr($data);
                // $uniqueData = [];
                // $seenKeys = [];
                
                // foreach ($data as $item) {
                //     if (!in_array($item[1], $seenKeys)) {
                //         $uniqueData[] = $item;
                //         $seenKeys[] = $item[1];
                //     }
                // }
                $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $allCount,
                    "recordsFiltered" => $countFiltered,
                    "data" => $data,
                    // "data" => $uniqueData,
                );
                echo json_encode($output);
        	
		}

    }

    public function get_bom_item_subtable_data_ea_approval($project_id,$boq_code,$EA_qty, $transaction_id) {
        $qr_array = array('project_id' =>$project_id,'boq_code'=>$boq_code);
        $bom_items_data = $this->common_model->selectDetailsWhereArrBom('tbl_bom_items',$qr_array);
        // echo "<pre>";
        // print_r($bom_items_data);die;

        $bom_data = array();
        if(isset($bom_items_data) && !empty($bom_items_data)){
            foreach ($bom_items_data as $key => $bom_items) {
                if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }
                if(isset($bom_items->hsn_sac_code) && !empty($bom_items->hsn_sac_code)) { $bom_hsn_sac_code = $bom_items->hsn_sac_code; }else { $bom_hsn_sac_code = ''; }
                if(isset($bom_items->item_description) && !empty($bom_items->item_description)) { $bom_item_description = $bom_items->item_description; }else { $bom_item_description = ''; }
                if(isset($bom_items->unit) && !empty($bom_items->unit)) { $bom_unit = $bom_items->unit; }else { $bom_unit = ''; }
                if(isset($bom_items->design_qty) && !empty($bom_items->design_qty)) { $bom_design_qty = $bom_items->design_qty; }else { $bom_design_qty = ''; }
                if(isset($bom_items->rate_basic) && !empty($bom_items->rate_basic)) { $bom_rate_basic = $bom_items->rate_basic; }else { $bom_rate_basic = ''; }
                if(isset($bom_items->gst) && !empty($bom_items->gst)) { $bom_gst = $bom_items->gst; }else { $bom_gst = ''; }

                if(isset($bom_items->make) && !empty($bom_items->make)) { $make = $bom_items->make; }else { $make = ''; }
                if(isset($bom_items->model) && !empty($bom_items->model)) { $model = $bom_items->model; }else { $model = ''; }

                if(isset($bom_items->bom_ratio) && !empty($bom_items->bom_ratio)) { $bom_ratio = $bom_items->bom_ratio; }else { $bom_ratio = ''; }

                //$ea_stock = $this->common_model->get_bom_exceptional_stock_data($project_id, $boq_code, $bom_code, $transaction_id);

                // if(!empty($ea_stock) && isset($ea_stock)) {
                //     $total_stock_db = $ea_stock['qty'];
                //     $total_stock = $total_stock_db;
                // } else {
                //     $total_stock = 0;  
                // }

                $total_stock_cal = $bom_ratio * $EA_qty; 
                $total_stock = sprintf('%0.2f',$total_stock_cal);

                $html_d ="";
                $html_d.='<a href="javascript:;" class="delete tooltips " rel="" title="" rev="delete_boq_details" data-original-title="Delete Role"><i class="fa fa-trash-o" style="color:#a94442; font-size: 15px;"></i></a>';
                
                if($bom_gst > 0){
                    $total_amount = ($bom_rate_basic * $total_stock);
                    $gst_amount = 0;
                    if($total_amount > 0 && $bom_gst > 0){
                        $gst_amount =  $total_amount * ($bom_gst/100);   
                    }
                    $final_amount = $total_amount + $gst_amount;
                } else {
                    $final_amount = 0;
                }

                // $bom_sr_no_d = '<input type="text" class="form-control invaliderror" name="bom_code[]"   value="'.$bom_code.'" placeholder="BOM Sr.No." style="font-size: 12px;width:100%" readonly>';
                // $bom_hsn_code_d = '<input type="text" class="form-control invaliderror" name="bom_hsn_code[]"   value="'.$bom_hsn_sac_code.'" placeholder="HNS Code" style="font-size: 12px;width:100%" readonly>';
                // $item_description_d = '<input type="text" class="form-control invaliderror" name="bom_item_description[]"   value="'.$bom_item_description.'" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>';
                // $make_d = '<input type="text" class="form-control invaliderror" name="make[]" value="'.$make.'" placeholder="Make" style="font-size: 12px;width:100%" readonly>';
                // $model_d = '<input type="text" class="form-control invaliderror" name="model[]" value="'.$model.'" placeholder="Model" style="font-size: 12px;width:100%" readonly>';
                // $bom_unit_d = '<input type="text" class="form-control invaliderror"  name="bom_unit[]"  value="'.$bom_unit.'" placeholder="Unit" style="font-size: 12px;width:100%" readonly>';
                // $release_qty_d = '<input type="hidden" class="form-control invaliderror bom_original_avl_qty" name="bom_original_avl_qty[]"  value="'.$total_stock.'" placeholder="Release Qty" style="font-size: 12px;width:100%" readonly>
                // <input type="text" class="form-control invaliderror bom_release_avl_qty color-red" name="bom_release_qty[]"  value="'.$total_stock.'" placeholder="Release Qty" style="font-size: 12px;width:100%" readonly>';
                // $bom_rate_basic_d = '<input type="text" class="form-control invaliderror js-bom-rate-basic" name="bom_rate_basic[]"  value="'.$bom_rate_basic.'" placeholder="Basic Rate" style="font-size: 12px;width:100%" readonly>';
                // $bom_gst_d = '<input type="text" class="form-control invaliderror js-bom-gst" name="bom_gst[]" value="'.$bom_gst.'" placeholder="Basic Rate" style="font-size: 12px;width:100%" readonly>';
                // $amount_d = '<input type="text" class="form-control invaliderror js-bom-amount" name="bom_amount[]"  value="'.sprintf('%0.2f', $final_amount).'" placeholder="Basic Rate" style="font-size: 12px;width:100%" readonly>';

                // $bom_data[] = array(
                //     $bom_sr_no_d,
                //     $bom_hsn_code_d,
                //     $item_description_d,
                //     $make_d,
                //     $model_d,
                //     $bom_unit_d,
                //     $release_qty_d,
                //     $bom_rate_basic_d,
                //     $bom_gst_d,
                //     $amount_d,
                // );	
                $bom_data[] = array(
                    $bom_code,
                    $bom_hsn_sac_code,
                    $bom_item_description,
                    $make,
                    $model,
                    $bom_unit,
                    $total_stock,
                    $bom_rate_basic,
                    $bom_gst,
                    sprintf('%0.2f', $final_amount),
                );	
            }
        }
        return  array(
            'bom_data' => $bom_data,
            'count' => count($bom_data)
        );
    }
    public function project_boq_list_display() 
		{
		$project_id = $this->input->post('project_id');
        if(isset($project_id) && !empty($project_id)){
        $project_id = base64_decode($project_id);
        }
        $filter = $this->input->post('filter');
        if(isset($filter) && !empty($filter)){
        $filter = $filter;
        }else{
        $filter = 'original';    
        }
        $calculatedfiler = $this->input->post('calculatedfiler');
        if(isset($calculatedfiler) && !empty($calculatedfiler)){
        $calculatedfiler = $calculatedfiler;
        }else{
        $calculatedfiler = 'without_gst';    
        }
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$data = $row = array();
		$transaction_id=0;
		$memData = $this->admin_model->getViewBOQListRows($_POST,$project_id,$transaction_id);
		$allCount = $this->admin_model->countViewBOQListAll($project_id,$transaction_id);
		$countFiltered = $this->admin_model->countViewBOQListFiltered($_POST,$project_id,$transaction_id);
        $i = $_POST['start'];
		foreach($memData as $member){
            $i++;
            if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $boq_items_id = $member->boq_items_id; }else { $boq_items_id = '-'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '-'; }
			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = '0'; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = '0'; }
			if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = '0'; }
			if(isset($member->non_schedule) && !empty($member->non_schedule)) { $non_schedule = $member->non_schedule; }else { $non_schedule = 'N'; }
			if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = 'N'; }
			if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
			if(isset($member->is_billing_inter_state) && !empty($member->is_billing_inter_state)) { $is_billing_inter_state = $member->is_billing_inter_state; }else { $is_billing_inter_state = 'N'; }
			if(isset($member->o_design_qty) && !empty($member->o_design_qty)) { $o_design_qty = $member->o_design_qty; }else { $o_design_qty = '0'; }
			if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
			if(isset($member->display) && !empty($member->display)) { $display = $member->display; }else { $display = 'N'; }
			$action_status='';
			if($status == 'Y'){
			$action_status .='<span style="color:green;font-weight:600;">Approved</span>';
			if($display == 'N'){
			$action_status .='<br><span style="color:red;font-weight:600;">Deleted</span>';
			}
			}else{
			$action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
			if($display == 'N'){
			$action_status .='<br><span style="color:red;font-weight:600;">Deleted</span>';
			}
			}
			$positive_var = 0;
			$negative_var = 0;
			if($design_qty >= $scheduled_qty){
			    $positive_var = $design_qty - $scheduled_qty;
			}else{
			    $negative_var = $scheduled_qty - $design_qty;       
			}
			$positive_var_amount = 0;
			$negative_var_amount = 0;
			$scheduled_amount = 0;
			$design_amount = 0;
			$non_sch_amount = 0;
		    $positive_var_amount = $positive_var * $rate_basic;
		    $negative_var_amount = $negative_var * $rate_basic;
			$scheduled_amount = $scheduled_qty * $rate_basic;
			$design_amount = $design_qty * $rate_basic;
			if($non_schedule == 'Y'){
			    $non_sch_amount = $design_qty * $rate_basic;
			}
			$positive_var_amount_gst = 0;
			$scheduled_amount_gst = 0;
			$scheduled_gst_amount = 0;
			$negative_var_amount_gst = 0;
			$design_amount_gst = 0;
			$non_sch_amount_gst = 0;
			$design_gst_amount = 0;
			if($gst > 0){
			    $positive_var_amount_gst = $positive_var_amount + ($positive_var_amount * ($gst/100));    
			    $scheduled_amount_gst = $scheduled_amount + ($scheduled_amount * ($gst/100)); 
			    $scheduled_gst_amount = $scheduled_amount * ($gst/100); 
			    $negative_var_amount_gst = $negative_var_amount + ($negative_var_amount * ($gst/100)); 
			    $design_amount_gst = $design_amount + ($design_amount * ($gst/100)); 
			    $non_sch_amount_gst = $non_sch_amount + ($non_sch_amount * ($gst/100)); 
			    $design_gst_amount = $design_amount * ($gst/100); 
			}
			if($filter == 'original'){
			    $data[] = array(
    			$i,
    			$boq_code,
    			$item_description,
    			$unit,
    			$scheduled_qty,
    			$rate_basic,
    			sprintf('%0.2f', $scheduled_amount),
    			$gst,
    			sprintf('%0.2f', $scheduled_gst_amount),
    			sprintf('%0.2f', $scheduled_amount_gst));
			}else{
			    if($calculatedfiler == 'without_gst' && $filter == 'calculated'){
			        $data[] = array(
        			$i,
        			$boq_code,
        			$item_description,
        			$unit,
        			$scheduled_qty,
        			$design_qty,
        			$design_qty,
        			$rate_basic,
        			$positive_var,
        			$negative_var,
        			$positive_var,
        			sprintf('%0.2f', $positive_var_amount),
        			sprintf('%0.2f', $scheduled_amount),
        			sprintf('%0.2f', $positive_var_amount),
        			sprintf('%0.2f', $negative_var_amount),
        			sprintf('%0.2f', $design_amount),
        			sprintf('%0.2f', $non_sch_amount),
        			sprintf('%0.2f', $design_amount));
			    }else{
			        $data[] = array(
        			$i,
        			$boq_code,
        			$item_description,
        			$unit,
        			$scheduled_qty,
        			$design_qty,
        			$design_qty,
        			$rate_basic,
        			$positive_var,
        			$negative_var,
        			$positive_var,
        			sprintf('%0.2f', $positive_var_amount),
        			sprintf('%0.2f', $positive_var_amount_gst),
        			sprintf('%0.2f', $scheduled_amount),
        			sprintf('%0.2f', $scheduled_amount_gst),
        			sprintf('%0.2f', $positive_var_amount),
        			sprintf('%0.2f', $positive_var_amount_gst),
        			sprintf('%0.2f', $negative_var_amount),
        			sprintf('%0.2f', $negative_var_amount_gst),
        			sprintf('%0.2f', $design_amount),
        			sprintf('%0.2f', $design_amount_gst),
        			sprintf('%0.2f', $non_sch_amount),
        			sprintf('%0.2f', $non_sch_amount_gst),
        			sprintf('%0.2f', $design_amount),
        			$gst,
        			sprintf('%0.2f', $design_gst_amount),
        			sprintf('%0.2f', $design_amount_gst)
        			);       
			    }
    		}
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    public function publish_boq_items_bulk_upload() {
        $project_id = $this->input->post('project_id');
        $user_id = $this->session->userData("user_id");
		if(isset($user_id) && !empty($user_id)){
    		if(isset($project_id) && !empty($project_id)){
    		    $steps = $this->admin_model->getTotalBoqTransactionCnt($project_id);
    		    if(isset($steps) && $steps !='no'){
    		        $steps = $steps + 1;
    		    }else{
    		        $steps = 0;
    		    }
                if(isset($_FILES['boq_excel_file']['name']))//Code for to take image from form and check isset
                {
                    $boq_excel_file=$_FILES['boq_excel_file']['name']; //here [] name attribute
                    $arr_boq_excel_file = array('upload_path' =>'./uploads/boq_excel_file/',
                        'fieldname' => 'boq_excel_file',
                        'encrypt_name' => TRUE,        
                        'overwrite' => FALSE,
                        'allowed_types' => '*' );
                    $arr_boq_excel_file = $this->imageupload->image_upload($arr_boq_excel_file);
                    $error= $this->upload->display_errors();
                    if(isset($arr_boq_excel_file) && !empty($arr_boq_excel_file)) {
                        $userData = $this->upload->data(); 
                        $category_img = $userData['file_name'];
                    }
                    $path = $_FILES["boq_excel_file"]["tmp_name"];
                    require_once APPPATH . "/third_party/PHPExcel.php";
                    $inputFileName = $path;
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName);
                        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                        $flag = true;
                        $i=0;
        				$inserdata = array();
                       
                        foreach ($allDataInSheet as $value) {
                            if($flag){
                                $flag =false;
                                continue;
                            }
                                
                            
                            if(isset($value['A']) && !empty($value['A'])) { $boq_code = $value['A']; }else { $boq_code = '0'; }
                			if(isset($value['B']) && !empty($value['B'])) { $hsn_sac_code = $value['B']; }else { $hsn_sac_code = '0'; }
                			if(isset($value['C']) && !empty($value['C'])) { $item_description = $value['C']; }else { $item_description = ''; }
                			if(isset($value['D']) && !empty($value['D'])) { $unit = $value['D']; }else { $unit = ''; }
                			if(isset($value['E']) && !empty($value['E'])) { $scheduled_qty = $value['E']; }else { $scheduled_qty = '0'; }
                			if(isset($value['F']) && !empty($value['F'])) { $design_qty = $value['F']; }else { $design_qty = '0'; }
                			if(isset($value['G']) && !empty($value['G'])) { $rate_basic = str_replace(',', '', $value['G']); }else { $rate_basic = '0'; }
                			if(isset($value['H']) && !empty($value['H'])) { $gst = $value['H']; }else { $gst = '0'; }
                			if(isset($value['I']) && !empty($value['I']) && ($value['I'] == 'Y' || strtolower($value['I']) == 'yes')) { $non_schedule = 'Y'; }else { $non_schedule = 'N'; }
                			if(!empty($boq_code) && !empty($project_id)){
                			    //check boq exceptional approval pending
                			    $checkboqexceptn = $this->admin_model->getBOQPendingExceptional($project_id,$boq_code);
                			    if(isset($checkboqexceptn) && empty($checkboqexceptn)){
                			        $chkstatus='Y';
                			        $o_design_qty = $design_qty;
                			        $exist_design_qty = $design_qty;
                			        $boq_item_details = $this->admin_model->get_boq_item_details($project_id,$boq_code);
                			        if(isset($boq_item_details) && !empty($boq_item_details)){
                			            if(isset($boq_item_details->status) && !empty($boq_item_details->status) && $boq_item_details->status == 'N'){
                			                $chkstatus = 'N';
                			            }
                			            if(isset($boq_item_details->o_design_qty) && !empty($boq_item_details->o_design_qty)
                			            && $boq_item_details->o_design_qty > 0 && $boq_item_details->status == 'Y'){
                			                $o_design_qty = $boq_item_details->o_design_qty;
                			            }
                			            if($design_qty != $scheduled_qty){
                			                if(isset($boq_item_details->design_qty) && $boq_item_details->status == 'Y'){
                			                    $exist_design_qty = $boq_item_details->design_qty;
                			                }
                			            }
                			        }
                			        // check BOQ Item approval pending
                			        if($chkstatus == 'Y'){
                        			    $inserdata[$i]['project_id'] = $project_id;
                                        $inserdata[$i]['boq_code'] = $boq_code;
                                        $inserdata[$i]['hsn_sac_code'] =  $hsn_sac_code;
                    					$inserdata[$i]['item_description'] =  $item_description;
                    					$inserdata[$i]['unit'] =  $unit;
                    					$inserdata[$i]['scheduled_qty'] =  $scheduled_qty;
                    					$inserdata[$i]['design_qty'] =  $exist_design_qty;
                    					$inserdata[$i]['upload_design_qty'] =  $design_qty;
                    					$inserdata[$i]['rate_basic'] =  $rate_basic;
                    					$inserdata[$i]['gst'] =  $gst;
                    					$inserdata[$i]['non_schedule'] =  $non_schedule;
                    					$inserdata[$i]['created_by'] =  $user_id;
                    					$inserdata[$i]['created_on'] =  date('Y-m-d H:i:s');
                    					$inserdata[$i]['modified_by'] =  $user_id;
                    					$inserdata[$i]['modified_on'] =  date('Y-m-d H:i:s');
                    					$inserdata[$i]['steps'] =  $steps;
                    					$inserdata[$i]['o_design_qty'] =  $o_design_qty;
                    					$inserdata[$i]['status'] =  'N';
                    					$i++;
                			        }
                                }
            				}
        				}
                    } catch (Exception $e) {
                       die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                                . '": ' .$e->getMessage());
                    }
                        if(isset($inserdata) && !empty($inserdata)) {
                                $event_name = 'Design BOQ Upload';
                                $is_first_upload = 0;
                        		$checkBOQUploadTransaction = $this->admin_model->checkBOQUploadTransaction($project_id);
                        		if(isset($checkBOQUploadTransaction) && empty($checkBOQUploadTransaction)){
                        		$event_name = 'Sch. BOQ Upload';
                        		$is_first_upload = 1;
                        		}
        					    $BOQTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,
        					    'event_type'=>'boq_upload','created_date'=>date('Y-m-d H:i:s'),'created_by'=>$user_id,
        					    'updated_by'=>$user_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending',
        					    'is_first_upload'=>$is_first_upload);
        					    $transaction_id = $this->common_model->addData('tbl_boq_transactions',$BOQTransArr);
        					    if($transaction_id > 0){
        					        foreach($inserdata as $key => $csm){
                        				$inserdata[$key]['transaction_id'] = $transaction_id;
                        			}
            						$result = $this->common_model->SaveMultiData('tbl_boq_items',$inserdata);
            						if($result) {
                						$this->json->jsonReturn(array(  
                							'valid'=>TRUE,
                							'msg'=>'<div class="alert modify alert-success">BOQ Items Uploaded Successfully!</div>',
                							'redirect' => base_url().'upload-boq-items'
                						));
            						}else{
                						 $this->json->jsonReturn(array(  
                							'valid'=>FALSE,
                							'msg'=>'<div class="alert modify alert-danger">Error! While Uploading Data empty!</div>'
                						));
                					}
        					    }else{
            						 $this->json->jsonReturn(array(  
            							'valid'=>FALSE,
            							'msg'=>'<div class="alert modify alert-danger">Error! While Uploading Data empty!</div>'
            						));
            					}
        					}else{
        						 $this->json->jsonReturn(array(  
        							'valid'=>FALSE,
        							'msg'=>'<div class="alert modify alert-danger">Error! While Uploading Data empty!</div>'
        						));
        					}
                }else{
                    $this->json->jsonReturn(array(  
        				'valid'=>FALSE,
        				'msg'=>'<div class="alert modify alert-danger">Error! While Uploading Data empty!</div>'
        			));
                }
            }else{
    		    $this->json->jsonReturn(array(  
        			'valid'=>FALSE,
        			'msg'=>'<div class="alert modify alert-danger">Please select project!</div>'
        		));
    		}    
		}else{
		    $this->json->jsonReturn(array(  
        		'valid'=>FALSE,
        		'msg'=>'<div class="alert modify alert-danger">Please loggedin!</div>'
        	));
		}
    }
    public function get_all_project_list(){
        $user_id=$this->session->userData("user_id");
        $res = array();
        $project_data = $this->admin_model->getApprovedProjectList();
        if(isset($project_data) && !empty($project_data) && isset($user_id) && !empty($user_id)){
            $i=0;
            foreach($project_data as $key){
                $res[$i]['id']  = $key->project_id;
                // $res[$i]['text']  = $key->bp_code.' ('.$key->customer_name.')';
                  $res[$i]['text']  = $key->bp_code.' ('.$key->payment_terms.", ".$key->customer_name.')';
                $i++;
            }
        }
        echo json_encode(array("users"=>$res));
    }

    public function get_all_item_list(){
        $user_id=$this->session->userData("user_id");
        $term = trim($this->input->post('term'));
        $type = trim($this->input->post('type'));

        $res = array();
        $project_data = $this->admin_model->getApprovedProjectItem($term,$type);
        if(isset($project_data) && !empty($project_data) && isset($user_id) && !empty($user_id)){
            $i=0;
            
            foreach($project_data as $key){
                if ($type == 1) {
                    $result_format = $key->customer_name.' '.$key->bp_code.' | '.$key->client_boq_sr_no.'/'.''.$key->boq_code.' | '.$key->item_description;
                } else {
                    $result_format = $key->item_description.' | '.$key->customer_name.' | '.$key->rate_basic.' | '.$key->boq_code;
                }
                $res[$i]['id']  = $key->project_id;
                $res[$i]['text']  = $result_format;
                $i++;
            }
        }
        echo json_encode(array("users"=>$res));
    }

    
    public function get_boq_items_list(){
        $user_id=$this->session->userData("user_id");
        $project_id = $this->input->get("id");
        $res = array();
        $project_data = $this->admin_model->getBoqItemsList($project_id);
        if(isset($project_data) && !empty($project_data) && isset($user_id) && !empty($user_id)){
            $i=0;
            foreach($project_data as $key){
                $res[$i]['id']  = $key->boq_code;
                $res[$i]['text']  = $key->boq_code.' — ('.$key->item_description.')';
                $res[$i]['rate_basic']  = $key->rate_basic;
                $i++;
            }
        }
        echo json_encode(array("users"=>$res));
    }

    public function boq_variable_discount() {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','upload-boq-items');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_update = 'N';
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','publish_boq_items_bulk_upload');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                    $data['check_permission_update'] = $check_permission_update;
                    $this->load->view('boq_variable_discount',$data);
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

    public function project_boq_discount_item_list() {
        $projectId = $_GET['project_id'];
        if(isset($projectId) && !empty($projectId)){
            $project_id =$projectId;
        }else{
            $project_id = null;
        }
       
        $user_id = $this->session->userData('user_id');
        if(isset($user_id) && !empty($user_id)){
        $data = $row = array();
        $check_permission_status = 'N';
        $loguser_id = $this->session->userData('user_id');
        $logrole_id = $this->session->userData('role_id');
        if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
            $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_boq_details');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_status = 'Y';
                }
            }
        }
        $check_permission_delete = 'N';
        if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
            $submenu_datad=$this->common_model->selectDetailsWhr('tbl_submenu','action','delete_boq_details');
            if(isset($submenu_datad->submenu_id) && !empty($submenu_datad->submenu_id)){
                $submenu_idd = $submenu_datad->submenu_id;
                $check_permissiond=$this->admin_model->check_permission($submenu_idd,$logrole_id);
                if(isset($check_permissiond) && !empty($check_permissiond)){
                    $check_permission_delete = 'Y';
                }
            }
        }
        $check_permission_approved = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approve_boq_variable_discount');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_approved = 'Y';
                }
            }
		}
		$check_permission_edit = 'N';
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_boq_variable_discount');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_edit = 'Y';
                }
            }
		}

        $memData = $this->admin_model->getBOQListRows($_POST,$project_id);
        $allCount = $this->admin_model->countBOQListAll();
        $countFiltered = $this->admin_model->countBOQListFiltered($_POST,$projectId);
        $i = $_POST['start'];
        foreach($memData as $member){
            $i++;
            if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $boq_items_id = $member->boq_items_id; }else { $boq_items_id = '0'; }
            if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
            if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
            if(isset($member->item_description) && !empty($member->item_description)) { $item_description =$member->item_description;}else { $item_description = '-'; }
            if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '-'; }
            if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = '0'; }
            if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
            if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = '0'; }
            if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = '0'; }
            if(isset($member->non_schedule) && !empty($member->non_schedule)) { $non_schedule = $member->non_schedule; }else { $non_schedule = 'N'; }
            if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = 'N'; }
            if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
            if(isset($member->o_design_qty) && !empty($member->o_design_qty)) { $o_design_qty = $member->o_design_qty; }else { $o_design_qty = '0'; }
            if(isset($member->created_by_rolename) && !empty($member->created_by_rolename)) { $created_by_rolename = ' ('.$member->created_by_rolename.')'; }else { $created_by_rolename = ''; }
            if(isset($member->created_by_name) && !empty($member->created_by_name)) { $created_by_name = $member->created_by_name.''.$created_by_rolename; }else { $created_by_name = '-'; }
            if(isset($member->approved_by_rolename) && !empty($member->approved_by_rolename)) { $approved_by_rolename = ' ('.$member->approved_by_rolename.')'; }else { $approved_by_rolename = ''; }
            if(isset($member->approved_by_name) && !empty($member->approved_by_name)) { $approved_by_name = $member->approved_by_name.''.$approved_by_rolename; }else { $approved_by_name = '-'; }
            if(isset($member->created_on) && !empty($member->created_on)) { $created_on = $member->created_on; }else { $created_on = ''; }
            $action_status='';
            if($status == 'Y'){
            $action_status .='<span style="color:green;font-weight:600;">Approved</span>';
            }else{
            $action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
            }
            $non_schedule_txt='NS';
            if($non_schedule == 'Y'){
            $non_schedule_txt .='Sch';
            }
            $html = '';
            // if($check_permission_delete == 'Y'){
            // $html.='<a href="javascript:;" class="delete tooltips deleteRecord" rel="'.$boq_items_id.'" title="" rev="delete_boq_details" data-original-title="Delete Role"><i class="fa fa-trash-o" style="color:#a94442; font-size: 15px;"></i></a>';
            // }
            // if($status == 'N' && $check_permission_status == 'Y'){
            // $html .='&nbsp;&nbsp;&nbsp;<a class="btn btn-success btn-xs active_link_cmn" href="javascript:void(0);" rev="approved_boq_details" rel="'.$boq_items_id.'" title="Click here to Approved Record" data-status="Y">Approve</a>';
            // }
            $varDisc = $this->admin_model->checkVariableDiscount($boq_code,$project_id);
            $count = count($varDisc);
            $action ='';
            if($varDisc[0]->status =='pending'){
			    // if($check_permission_status == 'Y'){
			    //     $html .='<select class="statusselect" id="statusselect'.$varDisc[0]->variable_discount_tid.'" rev="approve_boq_exceptional_approval" rel="'.$varDisc[0]->variable_discount_tid.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
			    // }
			}elseif($varDisc[0]->status =='reject'){
			    if($check_permission_edit == 'Y'){
			        $html .='<a href="javascript:;" class="editRecord tooltips" rel="'.$varDisc[0]->variable_discount_tid.'" title="Edit Record" rev="edit_boq_variable_discount_approval" data-original-title="Edit Record"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';
			    }
			    // if($check_permission_approved == 'Y'){
			    //     $html .='&nbsp;&nbsp;&nbsp;<select class="statusselect" id="statusselect'.$varDisc[0]->variable_discount_tid.'" rev="approve_boq_exceptional_approval" rel="'.$varDisc[0]->variable_discount_tid.'"><option class="statusselectoption" value="reject">Reject</option><option class="statusselectoption" value="approved">Approve</option></select>';
			    // }
			}
            $html.='&nbsp;<a href="javascript:;" class="popup_var_discount tooltips" rev="view_variable_discount_items" rel="'.$varDisc[0]->variable_discount_tid.'" project_id="'.$project_id.'" title="" data-original-title="Delete Role">View Discount Rate </a>';
           
            
            if($count > 0) {
                $data[] = array(
                //$i,
                $boq_code,
                $bp_code,
                $item_description,
                //$unit,
                // $scheduled_qty,
                // $design_qty,
                // $design_qty,
                // $rate_basic,
                // $gst,
                // $non_schedule_txt,
                // $action_status,
                // $created_by_name,
                // $approved_by_name,
                // $created_on,
                $html
                );
            }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
        }
    }

    public function view_variable_discount_items() {
        $variable_discount_tid = $this->input->post('id');
        $project_id = $this->input->post('project_id');
	  $data['variable_discount_tid'] = $variable_discount_tid;
	  $data['project_id'] = $project_id;
	  $view = $this->load->view('view-variable-discount-items',$data,TRUE);
      $this->json->jsonReturn(array('view'=>$view));
    }

    public function project_variable_discount_item() {
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$p_id = $this->input->post('project_id');
        $variable_discount_tid = $this->input->post('variable_discount_tid');
        if(isset($p_id) && !empty($p_id)){
            $project_id = base64_decode($p_id);
        }else{
            $project_id = 0;
        }
        
        $check_permission_approve = 'N';
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
        if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
            $submenu_datad=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_variable_discount');
            if(isset($submenu_datad->submenu_id) && !empty($submenu_datad->submenu_id)){
                $submenu_idd = $submenu_datad->submenu_id;
                $check_permissiond=$this->admin_model->check_permission($submenu_idd,$logrole_id);
                if(isset($check_permissiond) && !empty($check_permissiond)){
                    $check_permission_approve = 'Y';
                }
            }
        }
        
		$data = $row = array();
		$memData = $this->admin_model->getVariableDiscItemListRows($_POST,$project_id,$variable_discount_tid);
		$allCount = $this->admin_model->countVariableDiscItemListAll($project_id,$variable_discount_tid);
		$countFiltered = $this->admin_model->countVariableDiscItemListFiltered($_POST,$project_id,$variable_discount_tid);
        // echo "<pre>";
        // print_r($memData);die;
        $i = $_POST['start'];
        $sub_total = 0;
        $total_amount = 0 ;
        $gst_amount = 0 ;
		foreach($memData as $member){
            $i++;
            if(isset($member->from_quantity) && !empty($member->from_quantity)) { $from_quantity = $member->from_quantity; }else { $from_quantity = '-'; }
			if(isset($member->to_quantity) && !empty($member->to_quantity)) { $to_quantity = $member->to_quantity; }else { $to_quantity = '-'; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = '-'; }
            if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = '-'; }
            if(isset($member->id) && !empty($member->id)) { $id = $member->id; }else { $id = '-'; }
            $action_status='';
            $html ='';
            if($status == 'approved'){
                $action_status .='<span style="color:green;font-weight:600;">Approved</span>';
            }else{
                $action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
            }
            
			$data[] = array(
                $from_quantity,
                $to_quantity,
                $rate_basic,
                $action_status,
			);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}
    }   

    public function save_boq_variable_discount() 
    {
        $save_arr = array();
        $project_id = $this->input->post('project_id');
        if(isset($project_id) && !empty($project_id)){
            
            $error = 'N';
            $error_message = '';
            $user_id = $this->session->userdata('user_id');
            if(isset($user_id) && empty($user_id)){
            $error = 'Y';
            $error_message = 'Please loggedin!';
            }
            $boq_items = $this->input->post('boq_items');
            if(isset($boq_items) && !empty($boq_items)) {$boq_items = $boq_items; } else {$boq_items=''; }
            if(isset($boq_items) && empty($boq_items)){
            $error = 'Y';
            $error_message = 'Please Select BOQ Item!';
            }
            
            $variable_disc_from = $this->input->post('variable_disc_from');
            // if(isset($variable_disc_from) && !empty($variable_disc_from)) {$variable_disc_from = $variable_disc_from; } else {$variable_disc_from=''; }
            // if(isset($variable_disc_from) && empty($variable_disc_from)){
            // $error = 'Y';
            // $error_message = 'Please enter From Quantity!';
            // }
            $variable_disc_to = $this->input->post('variable_disc_to');
            // if(isset($variable_disc_to) && !empty($variable_disc_to)) {$variable_disc_to = $variable_disc_to; } else {$variable_disc_to=''; }
            // if(isset($variable_disc_to) && empty($variable_disc_to)){
            // $error = 'Y';
            // $error_message = 'Please enter To Quantity!';
            // }
            $variable_disc_base_rate = $this->input->post('variable_disc_base_rate');
            // if(isset($variable_disc_base_rate) && !empty($variable_disc_base_rate)) {$variable_disc_base_rate = $variable_disc_base_rate; } else {$variable_disc_base_rate=''; }
            // if(isset($variable_disc_base_rate) && empty($variable_disc_base_rate)){
            // $error = 'Y';
            // $error_message = 'Please enter Base Rates!';
            // }
            $boq_items_id = $this->input->post('boq_items_id');
            // if(isset($boq_items_id) && !empty($boq_items_id)) {$boq_items_id = $boq_items_id; } else {$boq_items_id=''; }
            // if(isset($boq_items_id) && empty($boq_items_id)){
            // $error = 'Y';
            // $error_message = 'Please Select BOQ Item!';
            // }
            $is_edit = $this->input->post('is_edit');
            if(isset($is_edit) && !empty($is_edit)) {$is_edit_s = $is_edit; } else {$is_edit_s=''; }
            if(empty($is_edit_s)) {
                $variable_discount_tid = $this->common_model->getLastInc('VD');
                if(isset($variable_discount_tid) && !empty($variable_discount_tid)){
                    $inc_id = $variable_discount_tid + 1;
                } else {
                    $inc_id = 1;
                }
            } else {
                $inc_id = $is_edit;
            }
            
            
            if(isset($boq_items) && empty($boq_items)
            && isset($variable_disc_from) && empty($variable_disc_from)
            && isset($variable_disc_to) && empty($variable_disc_to)
            && isset($variable_disc_base_rate) && empty($variable_disc_base_rate)){
                $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger">Please Enter BOQ  Variable Discount Details!!</div>'
                ));    
            }else{
                if($error == 'N'){
                    if(isset($boq_items) && !empty($boq_items)){
                        
                      if(!empty($is_edit_s)) {
                        $this->admin_model->deleteBOQVariableDiscountById($is_edit_s);
                      }

                        for($i=0;$i<count($variable_disc_from);$i++){
                            if(!empty($variable_disc_from[$i])) {
                                if(isset($variable_disc_from[$i]) && !empty($variable_disc_from[$i])) {$variable_disc_from_s = $variable_disc_from[$i]; } else {$variable_disc_from_s=''; }
                                if(isset($variable_disc_to[$i]) && !empty($variable_disc_to[$i])) {$variable_disc_to_s = $variable_disc_to[$i]; } else { $variable_disc_to_s=''; }
                                if(isset($variable_disc_base_rate[$i]) && !empty($variable_disc_base_rate[$i])) {$variable_disc_base_rate_s = $variable_disc_base_rate[$i]; } else {$variable_disc_base_rate_s=''; }
                                $save_arr[] = array('project_id'=>$project_id,'boq_items_id'=>$boq_items_id,'variable_discount_tid'=>$inc_id,'boq_code'=>$boq_items,'from_quantity'=>$variable_disc_from_s,
                                'to_quantity'=>$variable_disc_to_s,'rate_basic'=>$variable_disc_base_rate_s,'created_by'=>$user_id,'created_at' =>date('Y-m-d H:i:s'),'updated_at' =>date('Y-m-d H:i:s'));
                            }
                        }
                    }
                    if(isset($save_arr) && !empty($save_arr)){
                            $this->common_model->SaveMultiData('tbl_variable_discount',$save_arr);

                            if(!empty($is_edit_s)) {
                                $dataTrans = array('status'=>'pending','approved_by'=>'','approved_date'=>'','updated_by'=>$user_id);
                                $this->common_model->updateDetails('tbl_boq_transactions','variable_discount_id',$is_edit_s,$dataTrans);
                            }
                            if(empty($is_edit_s)) {
                                $event_name  = "Variable Discount Approval";
                                $BOQTransArr = array('project_id'=>$project_id,'variable_discount_id'=>$inc_id,'event_name'=>$event_name,
                                'event_type'=>'boq_variable_discount','created_date'=>date('Y-m-d H:i:s'),'created_by'=>$user_id,
                                'updated_by'=>$user_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending');
                                $transaction_id = $this->common_model->addData('tbl_boq_transactions',$BOQTransArr);
                            }
                            $this->json->jsonReturn(array(
                                'valid'=>TRUE,
                                'msg'=>'<div class="alert modify alert-success">BOQ Variable Discount Items Saved Successfully!</div>',
                                'redirect' => base_url().'boq-variable-discount'
                            ));
                    } else {
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">Please Enter Valid BOQ Items Details!!</div>'
                        ));    
                    }
                } else {
                    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                    ));
                }
            }
        }else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
            ));    
        }
    }

    public function approve_boq_variable_discount() {

        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approve_boq_variable_discount');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $user_id = $this->session->userData('user_id');

            		$variable_discount_id = $this->input->post('id');
                    $status = $this->input->post('status');
                    $allowed = 'Y';
                    if($allowed == 'Y'){
                        $data = array('status'=>$status,'approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
                        $result = $this->common_model->updateDetails('tbl_variable_discount','variable_discount_tid',$variable_discount_id,$data);
                        if($result){

                            if(isset($status) && !empty($status) && $status == 'approved'){
                                $Transdata = array('status'=>$status,'approved_by'=>$user_id,'approved_date'=>date('Y-m-d H:i:s'));
                            }else{
                                $Transdata = array('status'=>$status,'approved_by'=>0,'approved_date'=>'',
                                'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));
                            }
                            $this->common_model->updateDetails('tbl_boq_transactions','variable_discount_id',$variable_discount_id,$Transdata);
                       
                        if($status == 'approved'){
                            $this->json->jsonReturn(array(
                                'valid'=>TRUE, 
                                'msg'=>'<div class="alert modify alert-success">BOQ Variable Discount Approved Successfully!</div>'
                            ));
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>TRUE, 
                                'msg'=>'<div class="alert modify alert-success">BOQ Variable Discount Rejected Successfully!</div>'
                            ));
                        }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Approve Variable Discount Details !</div>'
                            ));
                        }
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE, 
                            'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Approve Variable Discount Details !</div>'
                        ));
                    }

                }else{
                    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!</div>'
                    ));
                }
            }else{
                $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no Permission!</div>'
                ));
            }
		}else{
		    $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> Please LoggedIn!</div>'
            ));
		}
    }

    public function edit_boq_variable_discount_approval(){
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','boq-variable-discount');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_update = 'N';
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_boq_variable_discount_approval');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                    
                }
            }
		}
        $id = $this->input->post('id');
        $variable_discount_items_data = $this->common_model->selectDetailsWhereAllDY('tbl_variable_discount', 'variable_discount_tid',$id);
        $project_id = $variable_discount_items_data[0]->project_id;
        $boq_items_id = $variable_discount_items_data[0]->boq_items_id;
        $project_data=$this->common_model->selectDetailsWhr('tbl_projects','project_id',$project_id);
        $boq_items_data=$this->common_model->selectDetailsWhr('tbl_boq_items','boq_items_id',$boq_items_id);
        $data['variable_discount_items_data'] = $variable_discount_items_data;
        $data['check_permission_update'] = $check_permission_update;
        $data['project_data'] = $project_data;
        $data['boq_items_data'] = $boq_items_data;

        // echo "<pre>";
        // print_r($boq_items_data);die;
        $this->load->view('boq_variable_discount',$data);
    }

    public function get_boq_item_details_for_variable_discount() 
		{
		$res = array();
		$project_id = $this->input->post('project_id');
        $boq_code = $this->input->post('boq_code');
        $user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)
		&& isset($project_id) && !empty($project_id)
		&& isset($boq_code) && !empty($boq_code)){
		$member = $this->admin_model->get_boq_item_details($project_id,$boq_code);
		$project_detail = $this->admin_model->get_project_item_details($project_id);
        $varDisc = $this->admin_model->checkVariableDiscount($boq_code,$project_id);
        $count = count($varDisc);
        $is_exist = '';
        if($count > 0) {
            $is_exist = 'Y';
        } else {
            $is_exist = 'N';
        }
		if(isset($member) && !empty($member)){
		    if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $res['boq_items_id'] = $member->boq_items_id; }else { $res['boq_items_id'] = '0'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $res['project_id'] = $member->project_id; }else { $res['project_id'] = '0'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $res['boq_code'] = $member->boq_code; }else { $res['boq_code'] = ''; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $res['hsn_sac_code'] = $member->hsn_sac_code; }else { $res['hsn_sac_code'] = ''; }
			if(isset($member->item_description) && !empty($member->item_description)) { $res['item_description'] = $member->item_description; }else { $res['item_description'] = ''; }
			if(isset($member->unit) && !empty($member->unit)) { $res['unit'] = $member->unit; }else { $res['unit'] = ''; }
			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $res['scheduled_qty'] = $member->scheduled_qty; }else { $res['scheduled_qty'] = ''; }
			if(isset($member->design_qty) && !empty($member->design_qty)) { $res['design_qty'] = $member->design_qty; }else { $res['design_qty'] = '0'; }
            if(isset($member->o_design_qty) && !empty($member->o_design_qty)) { $res['o_design_qty'] = $member->o_design_qty; }else { $res['o_design_qty'] = '0'; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $res['rate_basic'] = $member->rate_basic; }else { $res['rate_basic'] = '0'; }
			if(isset($member->gst) && !empty($member->gst)) { $res['gst'] = $member->gst; }else { $res['gst'] = '0'; }
			if(isset($member->non_schedule) && !empty($member->non_schedule)) { $res['non_schedule'] = $member->non_schedule; }else { $res['non_schedule'] = 'N'; }
			if(isset($member->status) && !empty($member->status)) { $res['boq_status'] = $member->status; }else { $res['boq_status'] = 'N'; }
            if(isset($is_exist) && !empty($is_exist)) { $res['is_exist'] = $is_exist; }else { $is_exist = ''; }
		}
		}
		echo json_encode($res);
	}


	public function upload_boq_items() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','upload-boq-items');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_update = 'N';
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','publish_boq_items_bulk_upload');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                    $data['check_permission_update'] = $check_permission_update;
                    $this->load->view('upload-boq-items',$data);
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
	public function upload_boq_items_file()
    {
        if($_FILES['file']['name'] != '')
        {
            $test =explode(".", $_FILES['file']['name']);
            $extension = end($test);
            $name = rand(100000000, 999999999) . '.' . $extension;
            $location = './uploads/upload_boq_file/'.$name;
            move_uploaded_file($_FILES['file']['tmp_name'], $location);
            $file_path = base_url().'uploads/upload_boq_file/'.$name;
            echo $name;
        }
    }
    public function save_boq_file_dataold()
    {
    	$user_id = $this->session->userdata('user_id');
        if(isset($user_id) && !empty($user_id)){
            $project_id = $this->input->post('project_id');
            if(isset($project_id) && !empty($project_id)){
                $boq_code_r = $this->input->post('boq_code_r');
                if(isset($boq_code_r) && !empty($boq_code_r)) {$boq_code_r = trim($boq_code_r); } else {$boq_code_r = ''; }
                $hsn_sac_code_r = $this->input->post('hsn_sac_code_r');
                if(isset($hsn_sac_code_r) && !empty($hsn_sac_code_r)) {$hsn_sac_code_r = trim($hsn_sac_code_r); } else {$hsn_sac_code_r = ''; }
                $item_description_r = $this->input->post('item_description_r');
                if(isset($item_description_r) && !empty($item_description_r)) {$item_description_r = trim($item_description_r); } else {$item_description_r = ''; }
                $item_description_r = $this->input->post('item_description_r');
                if(isset($item_description_r) && !empty($item_description_r)) {$item_description_r = trim($item_description_r); } else {$item_description_r = ''; }
                
            }else{
                
            }
        }else{
            
        }
        $id = $this->input->post('id');
        $project_code =$this->input->post('project_code');
        $boq_code =$this->input->post('boq_code');
        $boq_item_file =$this->input->post('boq_item_file');
    }
    public function save_client_dc_details() 
    {
        
        $save_arr = array();
        $project_id = $this->input->post('project_id');
        //$dc_no = $this->input->post('dc_no');
        $getPrifixData = $this->common_model->getPrifixData('DC');
        if(isset($getPrifixData) && !empty($getPrifixData)){
            $prefix_name = $getPrifixData['prefix_name'];   
            $financial_year = $getPrifixData['financial_year'];   
        }else{
            $prefix_name = 'DC';
            $financial_year = $this->getFinancialYear();
        }
        $getLastFinancialYear = $this->common_model->getLastFinancialYear('DC');
        $challan_no = 1;
        $getLastInc = $this->common_model->getLastInc('DC');
        // if($getLastFinancialYear == $financial_year){
        //     if(isset($getLastInc) && !empty($getLastInc)){
        //         $challan_no = $getLastInc + 1;    
        //     }
        // }
        $challan_no = intval($getLastInc) + 1;
       
        if(strlen($challan_no) > 4){
            $dc_no = $prefix_name.'-'.$challan_no.'/'.$financial_year;
        }else{
            $dc_no = $prefix_name.'-'.sprintf('%02d',$challan_no).'/'.$financial_year;
        }
      
        $c_type = $this->input->post('c_type');
        $gst_number = $this->input->post('gst_number');
        $gst_type = $this->input->post('gst_type');
        if(isset($gst_type) && !empty($gst_type) && $gst_type == 'cgst_sgst'){
        $gst_type_txt = 'intra-state';    
        }elseif(isset($gst_type) && !empty($gst_type) && $gst_type == 'igst'){
        $gst_type_txt = 'inter-state';    
        }else{
        $gst_type_txt = 'no';    
        }
        $workorderon = $this->input->post('workorderon');
        $dccdate = $this->input->post('dccdate');
        if(isset($dccdate) && !empty($dccdate)){
        $dccdate = date('Y-m-d',strtotime($dccdate));    
        }
        $suppliers_ref = $this->input->post('suppliers_ref');
        $registered_address = $this->input->post('registered_address');
        $buyer_order_ref = $this->input->post('buyer_order_ref');
        $dcc_dated = $this->input->post('dcc_dated');
        if(isset($dcc_dated) && !empty($dcc_dated)){
        $dcc_dated = date('Y-m-d',strtotime($dcc_dated));    
        }
        $other_ref = $this->input->post('other_ref');
        $consignee = $this->input->post('consignee');
        $consignee_buyer = $this->input->post('consignee_buyer');
        $dispatch_document_no = $this->input->post('dispatch_document_no');
        $destination = $this->input->post('destination');
        $site_address = $this->input->post('site_address');
        $buyer_site_address = $this->input->post('buyer_site_address');
        $dispatch_through = $this->input->post('dispatch_through');
        $terms_of_delivery = $this->input->post('terms_of_delivery');
        if(isset($project_id) && !empty($project_id) && isset($dc_no) && !empty($dc_no)){
            $delivery_challan = $this->common_model->selectDetailsWhr('tbl_delivery_challan','dc_no',$dc_no);
            if(isset($delivery_challan) && empty($delivery_challan)){
                if(isset($c_type) && !empty($c_type) && $c_type == 'delivery_challan'){
                    $error = 'N';
                    $error_message = '';
                    $user_id = $this->session->userdata('user_id');
                    if(isset($user_id) && empty($user_id)){
                        $error = 'Y';
                        $error_message = 'Please loggedin!';
                    }
                    $boq_code = $this->input->post('boq_code');
                    if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                    if(isset($boq_code) && empty($boq_code)){
                          $error = 'Y';
                          $error_message = 'Please enter BOQ Sr No!';
                    }
                    $hsn_sac_code = $this->input->post('hsn_sac_code');
                    if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                    if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                        $error = 'Y';
                        $error_message = 'Please enter HSN/SAC Code!';
                    }
                    $item_description = $this->input->post('item_description');
                    if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                    if(isset($item_description) && empty($item_description)){
                        $error = 'Y';
                        $error_message = 'Please enter Item Description!';
                    }
                    $unit = $this->input->post('unit');
                    if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                    if(isset($unit) && empty($unit)){
                        $error = 'Y';
                        $error_message = 'Please enter Unit!';
                    }
                    $qty = $this->input->post('qty');
                    if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
                    if(isset($qty) && empty($qty)){
                        $error = 'Y';
                        $error_message = 'Please enter Qty!';
                    }
                    $rate = $this->input->post('rate');
                    if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
                    if(isset($rate) && empty($rate)){
                        $error = 'Y';
                        $error_message = 'Please enter Rate!';
                    }
                    $taxable_amount = $this->input->post('total_rate');
                    if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
                    if(isset($taxable_amount) && empty($taxable_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter total amount!';
                    }
                    if(isset($boq_code) && !empty($boq_code)
                      && isset($hsn_sac_code) && !empty($hsn_sac_code)
                      && isset($item_description) && !empty($item_description)
                      && isset($unit) && !empty($unit)
                      && isset($qty) && !empty($qty)
                      && isset($rate) && !empty($rate)){
                          
                      }else{
                        $error = 'Y';
                        $error_message = 'Please enter BOQ Details!';
                      }
                      $save_arr = $update_stock_arr = $update_arr = $update_item_arr = $update_stock_arr_up = array();
                      if($error == 'N'){
                        if(isset($boq_code) && !empty($boq_code)){
                            $main_arr = array('project_id'=>$project_id,'dc_no'=>$dc_no,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'workorderon' => $workorderon,'dccdate'=> $dccdate,'c_type' => $c_type,'gst_number' => $gst_number,
                            'suppliers_ref'=> $suppliers_ref,'registered_address'=> $registered_address,'buyer_order_ref'=> $buyer_order_ref, 'dcc_dated' => $dcc_dated,'other_ref' => $other_ref, 'consignee' => $consignee,'consignee_buyer' => $consignee_buyer,'destination'=>$destination,'site_address'=> $site_address,'buyer_site_address' => $buyer_site_address, 'dispatch_through' => $dispatch_through,'terms_of_delivery' => $terms_of_delivery, 'dispatch_document_no'=> $dispatch_document_no, 
                            'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending','challan_no'=>$challan_no);
                            $challan_id = $this->common_model->addData('tbl_delivery_challan',$main_arr);
                            if($challan_id){
                                $event_name = 'Client Delivery Challan';
                                $BOQTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,'exceptional_no'=>$dc_no,
                                'exceptional_id'=>$challan_id,'event_type'=>'add_dc','created_date'=>date('Y-m-d H:i:s'),
                                'created_by'=>$user_id,'updated_by'=>$user_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending',
                                'approved_by'=>0,'approved_date'=>'');
                                $transaction_id = $this->common_model->addData('tbl_boq_transactions',$BOQTransArr);
                                if(isset($transaction_id) && !empty($transaction_id)){
                                    $updateTransarr = array('transaction_id'=>$transaction_id);
                                    $this->common_model->updateDetails('tbl_delivery_challan','challan_id',$challan_id,$updateTransarr);
                                }
                                $boq_items_id = $this->input->post('boq_items_id');
                                for($i=0;$i<count($boq_code);$i++){
                                    if(isset($boq_items_id[$i]) && !empty($boq_items_id[$i])) {$boq_items_id_s = $boq_items_id[$i]; } else {$boq_items_id_s=0; }
                                    if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                    if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                    if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                    if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                    if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
                                    if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
                                    if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
                                        
                                    if(isset($boq_code_s) && !empty($boq_code_s)
                                    && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                    && isset($item_description_s) && !empty($item_description_s)
                                    && isset($unit_s) && !empty($unit_s)
                                    && isset($qty_s) && !empty($qty_s)
                                    && isset($rate_s) && !empty($rate_s)
                                    && isset($taxable_amount_s) && !empty($taxable_amount_s)){
                                    $save_arr[] = array('challan_id'=>$challan_id,'boq_items_id'=>$boq_items_id_s,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                    'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s,'taxable_amount' =>$taxable_amount_s,'gst_type' => 'no',
                                    'sgst' => 0,'cgst' => 0,'sgst_amount' => 0,'cgst_amount' => 0,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));    
                                        }
                                    }
                                }
                        }
                        if(isset($save_arr) && !empty($save_arr)){
                            $this->common_model->SaveMultiData('tbl_deliv_challan_items',$save_arr);
                            $this->json->jsonReturn(array(
                                'valid'=>TRUE,
                                'msg'=>'<div class="alert modify alert-success">Delivery Challan Details Saved Successfully!</div>',
                                'redirect' => base_url().'client-delivery-challan'
                            ));    
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Delivery Challan Details!!</div>'
                            ));    
                        }
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                        ));
                    }
                }else{
                   if($gst_type == 'cgst_sgst'){
                       $update_stock_arr2 = array();
                        $error = 'N';
                        $error_message = '';
                        $user_id = $this->session->userdata('user_id');
                        if(isset($user_id) && empty($user_id)){
                        $error = 'Y';
                        $error_message = 'Please loggedin!';
                        }
                        $boq_code = $this->input->post('cboq_code');
                         if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                         if(isset($boq_code) && empty($boq_code)){
                          $error = 'Y';
                          $error_message = 'Please enter BOQ Sr No!';
                        }
                        $hsn_sac_code = $this->input->post('chsn_sac_code');
                        if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                        if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                        $error = 'Y';
                        $error_message = 'Please enter HSN/SAC Code!';
                        }
                        $item_description = $this->input->post('citem_description');
                        if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                        if(isset($item_description) && empty($item_description)){
                        $error = 'Y';
                        $error_message = 'Please enter Item Description!';
                        }
                        $unit = $this->input->post('cunit');
                        if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                        if(isset($unit) && empty($unit)){
                        $error = 'Y';
                        $error_message = 'Please enter Unit!';
                        }
                        $qty = $this->input->post('cqty');
                        if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
                        if(isset($qty) && empty($qty)){
                        $error = 'Y';
                        $error_message = 'Please enter Qty!';
                        }
                        $rate = $this->input->post('crate');
                        if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
                        if(isset($rate) && empty($rate)){
                        $error = 'Y';
                        $error_message = 'Please enter Rate!';
                        }
                        $taxable_amount = $this->input->post('ctaxable_amount');
                        if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
                        if(isset($taxable_amount) && empty($taxable_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter taxable amount!';
                        }
    
                        $sgst = $this->input->post('sgst');
                        if(isset($sgst) && !empty($sgst)) {$sgst = $sgst; } else {$sgst=''; }
                        if(isset($sgst) && empty($sgst)){
                        $error = 'Y';
                        $error_message = 'Please enter sgst!';
                        }
                        $cgst = $this->input->post('cgst');
                        if(isset($cgst) && !empty($cgst)) {$cgst = $cgst; } else {$cgst=''; }
                        if(isset($cgst) && empty($cgst)){
                        $error = 'Y';
                        $error_message = 'Please enter cgst!';
                        }
    
                        $cgst_amount = $this->input->post('cgst_amount');
                        if(isset($cgst_amount) && !empty($cgst_amount)) {$cgst_amount = $cgst_amount; } else {$cgst_amount=''; }
                        if(isset($cgst_amount) && empty($cgst_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter cgst amount!';
                        }
                        $sgst_amount = $this->input->post('sgst_amount');
                        if(isset($sgst_amount) && !empty($sgst_amount)) {$sgst_amount = $sgst_amount; } else {$sgst_amount=''; }
                        if(isset($sgst_amount) && empty($sgst_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter sgst amount!';
                        }
                       
    
                        if(isset($boq_code) && empty($boq_code)
                      && isset($hsn_sac_code) && empty($hsn_sac_code)
                      && isset($item_description) && empty($item_description)
                      && isset($unit) && empty($unit)
                      && isset($qty) && empty($qty)
                      && isset($rate) && empty($rate)
                      && isset($taxable_amount) && empty($taxable_amount)
                      && isset($sgst) && empty($sgst)
                      && isset($cgst) && empty($cgst)
                      && isset($cgst_amount) && empty($cgst_amount)
                      && isset($sgst_amount) && empty($sgst_amount)
                      )
                      {
                          $this->json->jsonReturn(array(
                              'valid'=>FALSE,
                              'msg'=>'<div class="alert modify alert-danger">Please Enter Delivery Challan Details!!</div>'
                          ));    
                      }else{
                          if($error == 'N'){
                              if(isset($boq_code) && !empty($boq_code)){
                                $main_arr = array('project_id'=>$project_id,'dc_no'=>$dc_no,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'workorderon' => $workorderon,'dccdate'=> $dccdate,'c_type' => $c_type,'gst_number' => $gst_number,
                                'suppliers_ref'=> $suppliers_ref,'registered_address'=> $registered_address,'buyer_order_ref'=> $buyer_order_ref, 'dcc_dated' => $dcc_dated,'other_ref' => $other_ref, 'consignee' => $consignee,'consignee_buyer' => $consignee_buyer,'destination'=>$destination,'site_address'=> $site_address,'buyer_site_address' => $buyer_site_address, 'dispatch_through' => $dispatch_through,'terms_of_delivery' => $terms_of_delivery, 'dispatch_document_no'=> $dispatch_document_no, 
                                'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending','challan_no'=>$challan_no);
                                $challan_id = $this->common_model->addData('tbl_delivery_challan',$main_arr);
                            if($challan_id){
                                $boq_items_id = $this->input->post('boq_items_id');
                                for($i=0;$i<count($boq_code);$i++){
                                    if(isset($boq_items_id[$i]) && !empty($boq_items_id[$i])) {$boq_items_id_s = $boq_items_id[$i]; } else {$boq_items_id_s=0; }
                                    if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                    if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                    if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                    if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                    if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
                                    if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
                                    if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
                                    if(isset($sgst[$i]) && !empty($sgst[$i])) {$sgst_s = $sgst[$i]; } else {$sgst_s=0; }            
                                    if(isset($cgst[$i]) && !empty($cgst[$i])) {$cgst_s = $cgst[$i]; } else {$cgst_s=0; }            
                                    if(isset($cgst_amount[$i]) && !empty($cgst_amount[$i])) {$cgst_amount_s = $cgst_amount[$i]; } else {$cgst_amount_s=0; }            
                                    if(isset($sgst_amount[$i]) && !empty($sgst_amount[$i])) {$sgst_amount_s = $sgst_amount[$i]; } else {$sgst_amount_s=0; }            
                                    if(isset($gst_type) && !empty($gst_type)) {$gst_type_s = 'intra-state'; } else {$gst_type_s= ''; }            
                                    
                                    if(isset($boq_code_s) && !empty($boq_code_s)
                                    && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                    && isset($item_description_s) && !empty($item_description_s)
                                    && isset($unit_s) && !empty($unit_s)
                                    && isset($qty_s) && !empty($qty_s)
                                    && isset($rate_s) && !empty($rate_s)
                                    && isset($taxable_amount_s) && !empty($taxable_amount_s)
                                    && isset($cgst_s) && !empty($cgst_s)
                                    && isset($sgst_s) && !empty($sgst_s)
                                    && isset($cgst_amount_s) && !empty($cgst_amount_s)
                                    && isset($gst_type_s) && !empty($gst_type_s)
                                    && isset($sgst_amount_s) && !empty($sgst_amount_s)){
                                        $save_arr[] = array('challan_id'=>$challan_id,'boq_items_id'=>$boq_items_id_s,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                        'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s,'taxable_amount' =>$taxable_amount_s,'gst_type' => 'intra-state',
                                        'sgst' => $sgst_s,'cgst' => $cgst_s,
                                        'sgst_amount' => $sgst_amount_s,'cgst_amount' => $cgst_amount_s,
                                        'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));  
                                    }
                                }
                            }
                        }
                        if(isset($save_arr) && !empty($save_arr)){
                            $this->common_model->SaveMultiData('tbl_deliv_challan_items',$save_arr);
                            $this->json->jsonReturn(array(
                                'valid'=>TRUE,
                                'msg'=>'<div class="alert modify alert-success">Delivery Challan Details Saved Successfully!</div>',
                                'redirect' => base_url().'client-delivery-challan'
                            ));    
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Delivery Challan Details!!</div>'
                            ));    
                        }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                            ));
                          }
                        }
    
    
        
    
                     }
                     else{
                        $update_stock_arr1 = array();
                        $error = 'N';
                        $error_message = '';
                        $user_id = $this->session->userdata('user_id');
                        if(isset($user_id) && empty($user_id)){
                        $error = 'Y';
                        $error_message = 'Please loggedin!';
                        }
                        $boq_code = $this->input->post('iboq_code');
                        if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                        if(isset($boq_code) && empty($boq_code)){
                        $error = 'Y';
                        $error_message = 'Please enter BOQ Sr No!';
                        }
                        $hsn_sac_code = $this->input->post('hsn_sac_code');
                        if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                        if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                        $error = 'Y';
                        $error_message = 'Please enter HSN/SAC Code!';
                        }
                        $item_description = $this->input->post('item_description');
                        if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                        if(isset($item_description) && empty($item_description)){
                        $error = 'Y';
                        $error_message = 'Please enter Item Description!';
                        }
                        $unit = $this->input->post('unit');
                        if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                        if(isset($unit) && empty($unit)){
                        $error = 'Y';
                        $error_message = 'Please enter Unit!';
                        }
                        $qty = $this->input->post('qty');
                        if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
                        if(isset($qty) && empty($qty)){
                        $error = 'Y';
                        $error_message = 'Please enter Qty!';
                        }
                        $rate = $this->input->post('rate');
                        if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
                        if(isset($rate) && empty($rate)){
                        $error = 'Y';
                        $error_message = 'Please enter Rate!';
                        }
                        $taxable_amount = $this->input->post('itaxable_amount');
                        if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
                        if(isset($taxable_amount) && empty($taxable_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter taxable amount!';
                        }
    
                        $gst = $this->input->post('gst');
                        if(isset($gst) && !empty($gst)) {$gst = $gst; } else {$gst=''; }
                        if(isset($gst) && empty($gst)){
                        $error = 'Y';
                        $error_message = 'Please enter gst!';
                        }
                        $gst_amount = $this->input->post('itotal_amount');
                        if(isset($gst_amount) && !empty($gst_amount)) {$gst_amount = $gst_amount; } else {$gst_amount=''; }
                        if(isset($gst_amount) && empty($gst_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter gst amount!';
                        }
    
                        if(isset($boq_code) && empty($boq_code)
                        && isset($hsn_sac_code) && empty($hsn_sac_code)
                        && isset($item_description) && empty($item_description)
                        && isset($unit) && empty($unit)
                        && isset($qty) && empty($qty)
                        && isset($rate) && empty($rate)
                        && isset($taxable_amount) && empty($taxable_amount)
                        && isset($gst) && empty($gst)
                        && isset($gst_amount) && empty($gst_amount)
                        ){
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">Please Enter Delivery Challan Details!!</div>'
                            ));    
                        }else{
                            if($error == 'N'){
                                if(isset($boq_code) && !empty($boq_code)){
                                    $main_arr = array('project_id'=>$project_id,'dc_no'=>$dc_no,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'workorderon' => $workorderon,'dccdate'=> $dccdate,'suppliers_ref'=> $suppliers_ref,'registered_address'=> $registered_address,'c_type' => $c_type,'buyer_order_ref'=> $buyer_order_ref, 'dcc_dated' => $dcc_dated,'other_ref' => $other_ref, 'consignee' => $consignee,'consignee_buyer' => $consignee_buyer,'destination'=>$destination,'site_address'=> $site_address,'buyer_site_address' => $buyer_site_address, 'dispatch_through' => $dispatch_through,'terms_of_delivery' => $terms_of_delivery, 'dispatch_document_no'=> $dispatch_document_no, 
                                    'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending','challan_no'=>$challan_no);
                                    $challan_id = $this->common_model->addData('tbl_delivery_challan',$main_arr);
                                    if($challan_id){
                                        $boq_items_id = $this->input->post('boq_items_id');
                                        for($i=0;$i<count($boq_code);$i++){
                                            if(isset($boq_items_id[$i]) && !empty($boq_items_id[$i])) {$boq_items_id_s = $boq_items_id[$i]; } else {$boq_items_id_s=0; }
                                            if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                            if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                            if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                            if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                            if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
                                            if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
                                            if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
                                            if(isset($gst[$i]) && !empty($gst[$i])) {$gst_s = $gst[$i]; } else {$gst_s=0; }            
                                            if(isset($gst_amount[$i]) && !empty($gst_amount[$i])) {$gst_amount_s = $gst_amount[$i]; } else {$gst_amount_s=0; }     
                                            if(isset($gst_type) && !empty($gst_type)) {$gst_type_s = 'inter-state'; } else {$gst_type_s= ''; }         
                                            
                                            if(isset($boq_code_s) && !empty($boq_code_s)
                                            && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                            && isset($item_description_s) && !empty($item_description_s)
                                            && isset($unit_s) && !empty($unit_s)
                                            && isset($qty_s) && !empty($qty_s)
                                            && isset($rate_s) && !empty($rate_s)
                                            && isset($taxable_amount_s) && !empty($taxable_amount_s)
                                            && isset($gst_s) && !empty($gst_s)
                                            && isset($gst_type_s) && !empty($gst_type_s)
                                            && isset($gst_amount_s) && !empty($gst_amount_s)){
                                                $save_arr[] = array('challan_id'=>$challan_id,'boq_items_id'=>$boq_items_id_s,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                                'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s
                                                ,'gst'=>$gst_s,'taxable_amount'=>$taxable_amount_s,
                                                'gst_amount' => $gst_amount_s,'gst_type'=>'inter-state',
                                                'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));
                                            }
                                        }
                                    }
                                }
                                if(isset($save_arr) && !empty($save_arr)){
                                    $this->common_model->SaveMultiData('tbl_deliv_challan_items',$save_arr);
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE,
                                        'msg'=>'<div class="alert modify alert-success">Delivery Details Saved Successfully!</div>',
                                        'redirect' => base_url().'client-delivery-challan'
                                    ));    
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Delivery Challan Detail!!</div>'
                                    ));    
                                }
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                                ));
                            }
                        }
    
                     } 
                }
            }else{
                $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger">Client delivery challan no already exist!</div>'
                ));    
            }
        }else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
            ));    
        }
    }
    public function update_client_dc_details() 
    {
        
        $save_arr = array();
        $project_id = $this->input->post('project_id');
        //$dc_no = $this->input->post('dc_no');
        $c_type = $this->input->post('c_type');
        $gst_number = $this->input->post('gst_number');
        $gst_type = $this->input->post('gst_type');
        if(isset($gst_type) && !empty($gst_type) && $gst_type == 'cgst_sgst'){
        $gst_type_txt = 'intra-state';    
        }elseif(isset($gst_type) && !empty($gst_type) && $gst_type == 'igst'){
        $gst_type_txt = 'inter-state';    
        }else{
        $gst_type_txt = 'no';    
        }
        $workorderon = $this->input->post('workorderon');
        $dccdate = $this->input->post('dccdate');
        if(isset($dccdate) && !empty($dccdate)){
        $dccdate = date('Y-m-d',strtotime($dccdate));    
        }
        $suppliers_ref = $this->input->post('suppliers_ref');
        $registered_address = $this->input->post('registered_address');
        $buyer_order_ref = $this->input->post('buyer_order_ref');
        $dcc_dated = $this->input->post('dcc_dated');
        if(isset($dcc_dated) && !empty($dcc_dated)){
        $dcc_dated = date('Y-m-d',strtotime($dcc_dated));    
        }
        $other_ref = $this->input->post('other_ref');
        $consignee = $this->input->post('consignee');
        $consignee_buyer = $this->input->post('consignee_buyer');
        $dispatch_document_no = $this->input->post('dispatch_document_no');
        $destination = $this->input->post('destination');
        $site_address = $this->input->post('site_address');
        $buyer_site_address = $this->input->post('buyer_site_address');
        $dispatch_through = $this->input->post('dispatch_through');
        $terms_of_delivery = $this->input->post('terms_of_delivery');
        if(isset($project_id) && !empty($project_id)){
            $upchallan_id = $this->input->post('challan_id');
            if(isset($upchallan_id) && !empty($upchallan_id)) {$upchallan_id = $upchallan_id; } else {$upchallan_id='0'; }
            $delivery_challan = $this->common_model->selectDetailsWhr('tbl_delivery_challan','challan_id',$upchallan_id);
            if(isset($delivery_challan) && !empty($delivery_challan)){
                $dc_no='';
                if(isset($delivery_challan->dc_no) && !empty($delivery_challan->dc_no)){
                    $dc_no = $delivery_challan->dc_no;     
                }
                if(isset($c_type) && !empty($c_type) && $c_type == 'delivery_challan'){
                    $error = 'N';
                    $error_message = '';
                    $user_id = $this->session->userdata('user_id');
                    if(isset($user_id) && empty($user_id)){
                        $error = 'Y';
                        $error_message = 'Please loggedin!';
                    }
                    $boq_code = $this->input->post('boq_code');
                    if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                    if(isset($boq_code) && empty($boq_code)){
                          $error = 'Y';
                          $error_message = 'Please enter BOQ Sr No!';
                    }
                    $hsn_sac_code = $this->input->post('hsn_sac_code');
                    if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                    if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                        $error = 'Y';
                        $error_message = 'Please enter HSN/SAC Code!';
                    }
                    $item_description = $this->input->post('item_description');
                    if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                    if(isset($item_description) && empty($item_description)){
                        $error = 'Y';
                        $error_message = 'Please enter Item Description!';
                    }
                    $unit = $this->input->post('unit');
                    if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                    if(isset($unit) && empty($unit)){
                        $error = 'Y';
                        $error_message = 'Please enter Unit!';
                    }
                    $qty = $this->input->post('qty');
                    if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
                    if(isset($qty) && empty($qty)){
                        $error = 'Y';
                        $error_message = 'Please enter Qty!';
                    }
                    $rate = $this->input->post('rate');
                    if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
                    if(isset($rate) && empty($rate)){
                        $error = 'Y';
                        $error_message = 'Please enter Rate!';
                    }
                    $taxable_amount = $this->input->post('total_rate');
                    if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
                    if(isset($taxable_amount) && empty($taxable_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter total amount!';
                    }
                    if(isset($boq_code) && !empty($boq_code)
                      && isset($hsn_sac_code) && !empty($hsn_sac_code)
                      && isset($item_description) && !empty($item_description)
                      && isset($unit) && !empty($unit)
                      && isset($qty) && !empty($qty)
                      && isset($rate) && !empty($rate)){
                      }else{
                        $error = 'Y';
                        $error_message = 'Please enter BOQ Details!';
                      }
                    $save_arr = $update_stock_arr = $update_arr = $update_item_arr = $update_stock_arr_up = array();
                    if($error == 'N'){
                        if(isset($boq_code) && !empty($boq_code)){
                            $update_arr = array('workorderon' => $workorderon,'dccdate'=> $dccdate,'c_type' => $c_type,
                            'gst_number' => $gst_number,'suppliers_ref'=> $suppliers_ref,'registered_address'=> $registered_address,
                            'buyer_order_ref'=> $buyer_order_ref, 'dcc_dated' => $dcc_dated,'other_ref' => $other_ref, 'consignee' => $consignee,
                            'consignee_buyer' => $consignee_buyer,'destination'=>$destination,'site_address'=> $site_address,
                            'buyer_site_address' => $buyer_site_address, 'dispatch_through' => $dispatch_through,
                            'terms_of_delivery' => $terms_of_delivery, 'dispatch_document_no'=> $dispatch_document_no, 
                            'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending');
                            $result = $this->common_model->updateDetails('tbl_delivery_challan','challan_id',$upchallan_id,$update_arr);
                            $challan_itemid = $this->input->post('challan_itemid');
                            for($i=0;$i<count($boq_code);$i++){
                                if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
                                if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
                                if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
                                if(isset($challan_itemid[$i]) && !empty($challan_itemid[$i])) {$challan_itemid_s = $challan_itemid[$i]; } else {$challan_itemid_s=0; }            
                                
                                if(isset($boq_code_s) && !empty($boq_code_s)
                                && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                && isset($item_description_s) && !empty($item_description_s)
                                && isset($unit_s) && !empty($unit_s)
                                && isset($qty_s) && !empty($qty_s)
                                && isset($rate_s) && !empty($rate_s)
                                && isset($taxable_amount_s) && !empty($taxable_amount_s)){
                                
                                $delete_boq_arr[] = $boq_code_s;
                                $update_item_arr[] = array('challan_id'=>$upchallan_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s,'taxable_amount' =>$taxable_amount_s,'gst_type' => 'no',
                                'sgst' => 0,'cgst' => 0,'sgst_amount' => 0,'cgst_amount' => 0,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));    
                                }
                            }
                            if(isset($delete_boq_arr) && !empty($delete_boq_arr) && $upchallan_id >0){
                                $this->admin_model->deleteBOQDCCOldItemById($delete_boq_arr,$upchallan_id);
                            }
                            if(isset($update_item_arr) && !empty($update_item_arr) && $project_id >0){
                                $this->common_model->SaveMultiData('tbl_deliv_challan_items',$update_item_arr);
                                $this->json->jsonReturn(array(
                                    'valid'=>TRUE,
                                    'msg'=>'<div class="alert modify alert-success"> Client Delivery Challan Details Saved Successfully!</div>',
                                    'redirect' => base_url().'client-delivery-challan'
                                ));    
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Client Delivery Challan Detailvcs!!</div>'
                                ));    
                            }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">Invalid Client delivery challan!</div>'
                            ));
                        }
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                        ));
                    }
                }else{
                    if(isset($c_type) && !empty($c_type) && $c_type != 'delivery_challan' && $gst_type_txt == 'intra-state'){
                        $error = 'N';
                        $error_message = '';
                        $user_id = $this->session->userdata('user_id');
                        if(isset($user_id) && empty($user_id)){
                            $error = 'Y';
                            $error_message = 'Please loggedin!';
                        }
                        $boq_code = $this->input->post('cboq_code');
                        if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                        if(isset($boq_code) && empty($boq_code)){
                              $error = 'Y';
                              $error_message = 'Please enter BOQ Sr No!';
                        }
                        $hsn_sac_code = $this->input->post('chsn_sac_code');
                        if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                        if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                            $error = 'Y';
                            $error_message = 'Please enter HSN/SAC Code!';
                        }
                        $item_description = $this->input->post('citem_description');
                        if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                        if(isset($item_description) && empty($item_description)){
                            $error = 'Y';
                            $error_message = 'Please enter Item Description!';
                        }
                        $unit = $this->input->post('cunit');
                        if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                        if(isset($unit) && empty($unit)){
                            $error = 'Y';
                            $error_message = 'Please enter Unit!';
                        }
                        $qty = $this->input->post('cqty');
                        if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
                        if(isset($qty) && empty($qty)){
                            $error = 'Y';
                            $error_message = 'Please enter Qty!';
                        }
                        $rate = $this->input->post('crate');
                        if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
                        if(isset($rate) && empty($rate)){
                            $error = 'Y';
                            $error_message = 'Please enter Rate!';
                        }
                        $taxable_amount = $this->input->post('ctaxable_amount');
                        if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
                        if(isset($taxable_amount) && empty($taxable_amount)){
                            $error = 'Y';
                            $error_message = 'Please enter total amount!';
                        }
                        $sgst = $this->input->post('sgst');
                        if(isset($sgst) && !empty($sgst)) {$sgst = $sgst; } else {$sgst=0; }
                        $sgst_amount = $this->input->post('sgst_amount');
                        if(isset($sgst_amount) && !empty($sgst_amount)) {$sgst_amount = $sgst_amount; } else {$sgst_amount=0; }
                        
                        $cgst = $this->input->post('cgst');
                        if(isset($cgst) && !empty($cgst)) {$cgst = $cgst; } else {$cgst=0; }
                        $cgst_amount = $this->input->post('cgst_amount');
                        if(isset($cgst_amount) && !empty($cgst_amount)) {$cgst_amount = $cgst_amount; } else {$cgst_amount=0; }
                        
                        if(isset($boq_code) && !empty($boq_code)
                          && isset($hsn_sac_code) && !empty($hsn_sac_code)
                          && isset($item_description) && !empty($item_description)
                          && isset($unit) && !empty($unit)
                          && isset($qty) && !empty($qty)
                          && isset($rate) && !empty($rate)){
                          }else{
                            $error = 'Y';
                            $error_message = 'Please enter BOQ Details!';
                          }
                        $save_arr = $update_stock_arr = $update_arr = $update_item_arr = $update_stock_arr_up = array();
                        if($error == 'N'){
                            if(isset($boq_code) && !empty($boq_code)){
                                $update_arr = array('workorderon' => $workorderon,'dccdate'=> $dccdate,'c_type' => $c_type,
                                'gst_number' => $gst_number,'suppliers_ref'=> $suppliers_ref,'registered_address'=> $registered_address,
                                'buyer_order_ref'=> $buyer_order_ref, 'dcc_dated' => $dcc_dated,'other_ref' => $other_ref, 'consignee' => $consignee,
                                'consignee_buyer' => $consignee_buyer,'destination'=>$destination,'site_address'=> $site_address,
                                'buyer_site_address' => $buyer_site_address, 'dispatch_through' => $dispatch_through,
                                'terms_of_delivery' => $terms_of_delivery, 'dispatch_document_no'=> $dispatch_document_no, 
                                'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending');
                                $result = $this->common_model->updateDetails('tbl_delivery_challan','challan_id',$upchallan_id,$update_arr);
                                $challan_itemid = $this->input->post('challan_itemid');
                                for($i=0;$i<count($boq_code);$i++){
                                    if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                    if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                    if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                    if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                    if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
                                    if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
                                    if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
                                    if(isset($challan_itemid[$i]) && !empty($challan_itemid[$i])) {$challan_itemid_s = $challan_itemid[$i]; } else {$challan_itemid_s=0; }            
                                    if(isset($sgst[$i]) && !empty($sgst[$i])) {$sgst_s = $sgst[$i]; } else {$sgst_s=0; }            
                                    if(isset($sgst_amount[$i]) && !empty($sgst_amount[$i])) {$sgst_amount_s = $sgst_amount[$i]; } else {$sgst_amount_s=0; }            
                                    if(isset($cgst[$i]) && !empty($cgst[$i])) {$cgst_s = $cgst[$i]; } else {$cgst_s=0; }            
                                    if(isset($cgst_amount[$i]) && !empty($cgst_amount[$i])) {$cgst_amount_s = $cgst_amount[$i]; } else {$cgst_amount_s=0; }            
                                    
                                    if(isset($boq_code_s) && !empty($boq_code_s)
                                    && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                    && isset($item_description_s) && !empty($item_description_s)
                                    && isset($unit_s) && !empty($unit_s)
                                    && isset($qty_s) && !empty($qty_s)
                                    && isset($rate_s) && !empty($rate_s)
                                    && isset($taxable_amount_s) && !empty($taxable_amount_s)){
                                    
                                    $delete_boq_arr[] = $boq_code_s;
                                    $update_item_arr[] = array('challan_id'=>$upchallan_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,
                                    'item_description'=>$item_description_s,'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s,'taxable_amount' =>$taxable_amount_s,
                                    'gst_type' => 'intra-state','gst'=>0,'gst_amount'=>0,'sgst' => $sgst_s,'cgst' => $cgst_s,'sgst_amount' => $sgst_amount_s,'cgst_amount' => $cgst_amount_s,
                                    'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));    
                                    }
                                }
                                if(isset($delete_boq_arr) && !empty($delete_boq_arr) && $upchallan_id >0){
                                    $this->admin_model->deleteBOQDCCOldItemById($delete_boq_arr,$upchallan_id);
                                }
                                if(isset($update_item_arr) && !empty($update_item_arr) && $project_id >0){
                                    $this->common_model->SaveMultiData('tbl_deliv_challan_items',$update_item_arr);
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE,
                                        'msg'=>'<div class="alert modify alert-success"> Client Delivery Challan Details Saved Successfully!</div>',
                                        'redirect' => base_url().'client-delivery-challan'
                                    ));    
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Client Delivery Challan Detailvcs!!</div>'
                                    ));    
                                }
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger">Invalid Client delivery challan!</div>'
                                ));
                            }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                            ));
                        }    
                    }elseif(isset($c_type) && !empty($c_type) && $c_type != 'delivery_challan' && $gst_type_txt == 'inter-state'){
                        $error = 'N';
                        $error_message = '';
                        $user_id = $this->session->userdata('user_id');
                        if(isset($user_id) && empty($user_id)){
                            $error = 'Y';
                            $error_message = 'Please loggedin!';
                        }
                        $boq_code = $this->input->post('iboq_code');
                        if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                        if(isset($boq_code) && empty($boq_code)){
                              $error = 'Y';
                              $error_message = 'Please enter BOQ Sr No!';
                        }
                        $hsn_sac_code = $this->input->post('hsn_sac_code');
                        if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                        if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                            $error = 'Y';
                            $error_message = 'Please enter HSN/SAC Code!';
                        }
                        $item_description = $this->input->post('item_description');
                        if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                        if(isset($item_description) && empty($item_description)){
                            $error = 'Y';
                            $error_message = 'Please enter Item Description!';
                        }
                        $unit = $this->input->post('unit');
                        if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                        if(isset($unit) && empty($unit)){
                            $error = 'Y';
                            $error_message = 'Please enter Unit!';
                        }
                        $qty = $this->input->post('qty');
                        if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
                        if(isset($qty) && empty($qty)){
                            $error = 'Y';
                            $error_message = 'Please enter Qty!';
                        }
                        $rate = $this->input->post('rate');
                        if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
                        if(isset($rate) && empty($rate)){
                            $error = 'Y';
                            $error_message = 'Please enter Rate!';
                        }
                        $taxable_amount = $this->input->post('itaxable_amount');
                        if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
                        if(isset($taxable_amount) && empty($taxable_amount)){
                            $error = 'Y';
                            $error_message = 'Please enter total amount!';
                        }
                        $gst = $this->input->post('gst');
                        if(isset($gst) && !empty($gst)) {$gst = $gst; } else {$gst=0; }
                        $gst_amount = $this->input->post('gst_amount');
                        if(isset($gst_amount) && !empty($gst_amount)) {$gst_amount = $gst_amount; } else {$gst_amount=0; }
                        
                        if(isset($boq_code) && !empty($boq_code)
                          && isset($hsn_sac_code) && !empty($hsn_sac_code)
                          && isset($item_description) && !empty($item_description)
                          && isset($unit) && !empty($unit)
                          && isset($qty) && !empty($qty)
                          && isset($rate) && !empty($rate)){
                          }else{
                            $error = 'Y';
                            $error_message = 'Please enter BOQ Details!';
                          }
                        $save_arr = $update_stock_arr = $update_arr = $update_item_arr = $update_stock_arr_up = array();
                        if($error == 'N'){
                            if(isset($boq_code) && !empty($boq_code)){
                                $update_arr = array('workorderon' => $workorderon,'dccdate'=> $dccdate,'c_type' => $c_type,
                                'gst_number' => $gst_number,'suppliers_ref'=> $suppliers_ref,'registered_address'=> $registered_address,
                                'buyer_order_ref'=> $buyer_order_ref, 'dcc_dated' => $dcc_dated,'other_ref' => $other_ref, 'consignee' => $consignee,
                                'consignee_buyer' => $consignee_buyer,'destination'=>$destination,'site_address'=> $site_address,
                                'buyer_site_address' => $buyer_site_address, 'dispatch_through' => $dispatch_through,
                                'terms_of_delivery' => $terms_of_delivery, 'dispatch_document_no'=> $dispatch_document_no, 
                                'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending');
                                $result = $this->common_model->updateDetails('tbl_delivery_challan','challan_id',$upchallan_id,$update_arr);
                                $challan_itemid = $this->input->post('challan_itemid');
                                for($i=0;$i<count($boq_code);$i++){
                                    if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                    if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                    if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                    if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                    if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
                                    if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
                                    if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
                                    if(isset($challan_itemid[$i]) && !empty($challan_itemid[$i])) {$challan_itemid_s = $challan_itemid[$i]; } else {$challan_itemid_s=0; }            
                                    if(isset($gst[$i]) && !empty($gst[$i])) {$gst_s = $gst[$i]; } else {$gst_s=0; }            
                                    if(isset($gst_amount[$i]) && !empty($gst_amount[$i])) {$gst_amount_s = $gst_amount[$i]; } else {$gst_amount_s=0; }            
                                    
                                    if(isset($boq_code_s) && !empty($boq_code_s)
                                    && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                    && isset($item_description_s) && !empty($item_description_s)
                                    && isset($unit_s) && !empty($unit_s)
                                    && isset($qty_s) && !empty($qty_s)
                                    && isset($rate_s) && !empty($rate_s)
                                    && isset($taxable_amount_s) && !empty($taxable_amount_s)){
                                    
                                    $delete_boq_arr[] = $boq_code_s;
                                    $update_item_arr[] = array('challan_id'=>$upchallan_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,
                                    'item_description'=>$item_description_s,'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s,'taxable_amount' =>$taxable_amount_s,
                                    'gst_type' => 'inter-state','gst'=>$gst_s,'gst_amount'=>$gst_amount_s,'sgst' => 0,'cgst' => 0,'sgst_amount' => 0,'cgst_amount' => 0,
                                    'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));    
                            }
                                }
                                if(isset($delete_boq_arr) && !empty($delete_boq_arr) && $upchallan_id >0){
                                    $this->admin_model->deleteBOQDCCOldItemById($delete_boq_arr,$upchallan_id);
                                }
                                if(isset($update_item_arr) && !empty($update_item_arr) && $project_id >0){
                                    $this->common_model->SaveMultiData('tbl_deliv_challan_items',$update_item_arr);
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE,
                                        'msg'=>'<div class="alert modify alert-success"> Client Delivery Challan Details Saved Successfully!</div>',
                                        'redirect' => base_url().'client-delivery-challan'
                                    ));    
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Client Delivery Challan Detailvcs!!</div>'
                                    ));    
                                }
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger">Invalid Client delivery challan!</div>'
                                ));
                            }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                            ));
                        }    
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">Invalid Client delivery challan!</div>'
                        ));    
                    }    
                }
            }else{
                $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger">Invalid Client delivery challan!</div>'
                ));    
            }
        }else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
            ));    
        }
    }
    
    public function save_provisional_wip_details() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_provisional_wip_details');
            if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                $usubmenu_id = $submenu_datau->submenu_id;
                $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                if(isset($check_permissionu) && !empty($check_permissionu)){
                    $save_arr = array();
                    $project_id = $this->input->post('project_id');
                    //$p_wip_no = $this->input->post('prov_wip_no');
                    $getPrifixData = $this->common_model->getPrifixData('PWIP');
                    if(isset($getPrifixData) && !empty($getPrifixData)){
                        $prefix_name = $getPrifixData['prefix_name'];   
                        $financial_year = $getPrifixData['financial_year'];   
                    }else{
                        $prefix_name = 'PWIP';
                        $financial_year = $this->getFinancialYear();
                    }
                    $getLastFinancialYear = $this->common_model->getLastFinancialYear('PWIP');
                    $p_wip_inc = 1;
                    $getLastInc = $this->common_model->getLastInc('PWIP');
                    // if($getLastFinancialYear == $financial_year){
                    //     if(isset($getLastInc) && !empty($getLastInc)){
                    //         $p_wip_inc = $getLastInc + 1;    
                    //     }
                    // }
                     $p_wip_inc = $getLastInc + 1; 
                    if(strlen($p_wip_inc) > 4){
                        $p_wip_no = $prefix_name.'-'.$p_wip_inc.'/'.$financial_year;
                    }else{
                        $p_wip_no = $prefix_name.'-'.sprintf('%02d',$p_wip_inc).'/'.$financial_year;
                    }
                    if(isset($project_id) && !empty($project_id) && isset($p_wip_no) && !empty($p_wip_no)){
                        $provisional_wip = $this->common_model->selectDetailsWhr('tbl_provisional_wip','p_wip_no',$p_wip_no);
                        if(isset($provisional_wip) && empty($provisional_wip)){
                        $error = 'N';
                        $error_message = '';
                        $user_id = $this->session->userdata('user_id');
                        if(isset($user_id) && empty($user_id)){
                        $error = 'Y';
                        $error_message = 'Please loggedin!';
                        }
                        $boq_code = $this->input->post('boq_code');
                        if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                        if(isset($boq_code) && empty($boq_code)){
                        $error = 'Y';
                        $error_message = 'Please enter BOQ Sr No!';
                        }
                        $hsn_sac_code = $this->input->post('hsn_sac_code');
                        if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                        if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                        $error = 'Y';
                        $error_message = 'Please enter HSN/SAC Code!';
                        }
                        $item_description = $this->input->post('item_description');
                        if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                        if(isset($item_description) && empty($item_description)){
                        $error = 'Y';
                        $error_message = 'Please enter Item Description!';
                        }
                        $unit = $this->input->post('unit');
                        if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                        if(isset($unit) && empty($unit)){
                        $error = 'Y';
                        $error_message = 'Please enter Unit!';
                        }
                        $avl_qty = $this->input->post('avl_qty');
                        if(isset($avl_qty) && !empty($avl_qty)) {$avl_qty = $avl_qty; } else {$avl_qty=''; }
                        if(isset($avl_qty) && empty($avl_qty)){
                        $error = 'Y';
                        $error_message = 'Please enter Avl Qty!';
                        }
                        $prov_qty = $this->input->post('prov_qty');
                        if(isset($prov_qty) && !empty($prov_qty)) {$prov_qty = $prov_qty; } else {$prov_qty=''; }
                        if(isset($prov_qty) && empty($prov_qty)){
                        $error = 'Y';
                        $error_message = 'Please enter Provisional Qty!';
                        }
                        if(isset($boq_code) && empty($boq_code)
                        && isset($hsn_sac_code) && empty($hsn_sac_code)
                        && isset($item_description) && empty($item_description)
                        && isset($unit) && empty($unit)
                        && isset($avl_qty) && empty($avl_qty)
                        && isset($prov_qty) && empty($prov_qty)){
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">Please Enter Provisional WIP Details!!</div>'
                            ));    
                        }else{
                            if($error == 'N'){
                                if(isset($boq_code) && !empty($boq_code)){
                                    $event_name = 'Provisional WIP';
                                    $BOQTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,'exceptional_no'=>$p_wip_no,
                                    'exceptional_id'=>0,'event_type'=>'pwip','created_date'=>date('Y-m-d H:i:s'),
                                    'created_by'=>$user_id,'updated_by'=>$user_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending',
                                    'approved_by'=>0,'approved_date'=>'');
                                    $transaction_id = $this->common_model->addData('tbl_boq_transactions',$BOQTransArr);
                                    if($transaction_id){
                                    $main_arr = array('project_id'=>$project_id,'p_wip_no'=>$p_wip_no,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),
                                    'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending','p_wip_inc'=>$p_wip_inc,
                                    'transaction_id'=>$transaction_id);
                                    $p_wip_id = $this->common_model->addData('tbl_provisional_wip',$main_arr);
                                    if($p_wip_id){
                                        $rate_basic = $this->input->post('rate_basic');
                                        for($i=0;$i<count($boq_code);$i++){
                                            if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                            if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                            if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                            if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                            if(isset($avl_qty[$i]) && !empty($avl_qty[$i])) {$avl_qty_s = $avl_qty[$i]; } else {$avl_qty_s=''; }            
                                            if(isset($prov_qty[$i]) && !empty($prov_qty[$i])) {$prov_qty_s = $prov_qty[$i]; } else {$prov_qty_s=0; }            
                                            if(isset($rate_basic[$i]) && !empty($rate_basic[$i])) {$rate_basic_s = $rate_basic[$i]; } else {$rate_basic_s=0; }            
                                            
                                            if(isset($boq_code_s) && !empty($boq_code_s)
                                            && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                            && isset($item_description_s) && !empty($item_description_s)
                                            && isset($unit_s) && !empty($unit_s)
                                            && isset($avl_qty_s) && !empty($avl_qty_s)
                                            && isset($prov_qty_s) && !empty($prov_qty_s)){
                                                $save_arr[] = array('p_wip_id'=>$p_wip_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                                'unit'=>$unit_s,'avl_qty'=>$avl_qty_s,'prov_qty'=>$prov_qty_s,'rate_basic'=>$rate_basic_s,
                                                'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s')); 
                                            }
                                        }
                                    }
                                    }
                                }
                                if(isset($save_arr) && !empty($save_arr)){
                                    $this->common_model->SaveMultiData('tbl_prov_wip_items',$save_arr);
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE,
                                        'msg'=>'<div class="alert modify alert-success">Provisional WIP Details Saved Successfully!</div>',
                                        'redirect' => base_url().'add-provisional-wip'
                                    ));    
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Provisional WIP!!</div>'
                                    ));    
                                }
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                                ));
                            }
                        }
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">Provisional WIP no already exist!</div>'
                        ));    
                    }
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
                        ));    
                    }
                }else{
        		     $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger">You have no permission!!</div>'
                    ));
        		}
            }else{
    		     $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger">You have no permission!!</div>'
                ));
    		}
		}else{
		     $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">You have no permission!!</div>'
            ));
		}
		
    }
    
    public function update_tax_invoice_details() 
    {
        $save_arr = $update_boq_stock_arr = $update_boq_stock_arr1 = $delete_boq_arr = array();
        $project_id = $this->input->post('project_id');
        $tax_invc_no = $this->input->post('tax_invoice_no');
        $gst_type = $this->input->post('gst_type');
        $invoice_date = $this->input->post('invoice_date');
        $tax_invc_id = $this->input->post('update_tax_invc_id');
        if(isset($project_id) && !empty($project_id) && isset($tax_invc_id) && !empty($tax_invc_id)){
            $tax_invc = $this->common_model->selectDetailsWhr('tbl_tax_invc','tax_invc_id',$tax_invc_id);
            if(isset($tax_invc) && !empty($tax_invc)){
                $tax_invc_no_exist = $this->admin_model->check_exist_wip_no('tax_invoice',$proforma_id,$proforma_no);
                if(isset($tax_invc_no_exist) && empty($tax_invc_no_exist)){
                    if($gst_type == 'cgst_sgst'){
                        $error = 'N';
                        $error_message = '';
                        $user_id = $this->session->userdata('user_id');
                        if(isset($user_id) && empty($user_id)){
                        $error = 'Y';
                        $error_message = 'Please loggedin!';
                        }
                        
                        $invoice_date = $this->input->post('invoice_date');
                        if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
                        if(isset($invoice_date) && empty($invoice_date)){
                          $error = 'Y';
                          $error_message = 'Please enter Tax Invoice Date!';
                        }
                        $boq_code = $this->input->post('proforma_boq_code_v');
                         if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                         if(isset($boq_code) && empty($boq_code)){
                          $error = 'Y';
                          $error_message = 'Please enter BOQ Sr No!';
                        }
                        $hsn_sac_code = $this->input->post('proforma_hsn_sac_code');
                        if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                        if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                        $error = 'Y';
                        $error_message = 'Please enter HSN/SAC Code!';
                        }
                        $item_description = $this->input->post('proforma_item_description');
                        if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                        if(isset($item_description) && empty($item_description)){
                        $error = 'Y';
                        $error_message = 'Please enter Item Description!';
                        }
                        $unit = $this->input->post('proforma_unit');
                        if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                        if(isset($unit) && empty($unit)){
                        $error = 'Y';
                        $error_message = 'Please enter Unit!';
                        }
                        $qty = $this->input->post('proforma_qty');
                        if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
                        if(isset($qty) && empty($qty)){
                        $error = 'Y';
                        $error_message = 'Please enter Qty!';
                        }
                        $rate = $this->input->post('proforma_rate');
                        if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
                        if(isset($rate) && empty($rate)){
                        $error = 'Y';
                        $error_message = 'Please enter Rate!';
                        }
                        $taxable_amount = $this->input->post('proforma_itaxable_amount');
                        if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
                        if(isset($taxable_amount) && empty($taxable_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter taxable amount!';
                        }
                        $sgst = $this->input->post('proforma_sgst');
                        if(isset($sgst) && !empty($sgst)) {$sgst = $sgst; } else {$sgst=''; }
                        if(isset($sgst) && empty($sgst)){
                        $error = 'Y';
                        $error_message = 'Please enter sgst!';
                        }
                        $cgst = $this->input->post('proforma_cgst');
                        if(isset($cgst) && !empty($cgst)) {$cgst = $cgst; } else {$cgst=''; }
                        if(isset($cgst) && empty($cgst)){
                        $error = 'Y';
                        $error_message = 'Please enter cgst!';
                        }
                        $cgst_amount = $this->input->post('proforma_cgst_amount');
                        if(isset($cgst_amount) && !empty($cgst_amount)) {$cgst_amount = $cgst_amount; } else {$cgst_amount=''; }
                        if(isset($cgst_amount) && empty($cgst_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter cgst amount!';
                        }
                        $sgst_amount = $this->input->post('proforma_sgst_amount');
                        if(isset($sgst_amount) && !empty($sgst_amount)) {$sgst_amount = $sgst_amount; } else {$sgst_amount=''; }
                        if(isset($sgst_amount) && empty($sgst_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter sgst amount!';
                        }
                        if(isset($boq_code) && empty($boq_code)
                        && isset($hsn_sac_code) && empty($hsn_sac_code)
                        && isset($item_description) && empty($item_description)
                        && isset($unit) && empty($unit)
                        && isset($qty) && empty($qty)
                        && isset($rate) && empty($rate)
                        && isset($taxable_amount) && empty($taxable_amount)
                        && isset($sgst) && empty($sgst)
                        && isset($cgst) && empty($cgst)
                        && isset($cgst_amount) && empty($cgst_amount)
                        && isset($sgst_amount) && empty($sgst_amount))
                        {
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">Please Enter Tax Invoice Details!!</div>'
                            ));    
                    }else{
                        if($error == 'N'){
                            if(isset($boq_code) && !empty($boq_code)){
                                if($tax_invc_id){
                                $tax_invc_itemid = $this->input->post('tax_invc_itemid');
                                for($i=0;$i<count($boq_code);$i++){
                                    if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                    if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                    if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                    if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                    if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
                                    if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
                                    if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
                                    if(isset($sgst[$i]) && !empty($sgst[$i])) {$sgst_s = $sgst[$i]; } else {$sgst_s=0; }            
                                    if(isset($cgst[$i]) && !empty($cgst[$i])) {$cgst_s = $cgst[$i]; } else {$cgst_s=0; }            
                                    if(isset($cgst_amount[$i]) && !empty($cgst_amount[$i])) {$cgst_amount_s = $cgst_amount[$i]; } else {$cgst_amount_s=0; }            
                                    if(isset($sgst_amount[$i]) && !empty($sgst_amount[$i])) {$sgst_amount_s = $sgst_amount[$i]; } else {$sgst_amount_s=0; }            
                                    if(isset($gst_type) && !empty($gst_type)) {$gst_type_s = 'intra-state'; } else {$gst_type_s= ''; }            
                                    if(isset($tax_invc_itemid[$i]) && !empty($tax_invc_itemid[$i])) {$tax_invc_itemid_s = $tax_invc_itemid[$i]; } else {$tax_invc_itemid_s=0; }            
                                    
                                    if(isset($boq_code_s) && !empty($boq_code_s)
                                    && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                    && isset($item_description_s) && !empty($item_description_s)
                                    && isset($unit_s) && !empty($unit_s)
                                    && isset($qty_s) && !empty($qty_s)
                                    && isset($rate_s) && !empty($rate_s)
                                    && isset($taxable_amount_s) && !empty($taxable_amount_s)
                                    && isset($cgst_s) && !empty($cgst_s)
                                    && isset($sgst_s) && !empty($sgst_s)
                                    && isset($cgst_amount_s) && !empty($cgst_amount_s)
                                    && isset($gst_type_s) && !empty($gst_type_s)
                                    && isset($sgst_amount_s) && !empty($sgst_amount_s)){
                                    if(isset($boq_code_s) && !empty($boq_code_s) && isset($project_id) && !empty($project_id)){
                                            $delete_boq_arr[] = $boq_code_s;
                                            $save_arr[] = array('tax_invc_id'=>$tax_invc_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                            'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s,'taxable_amount' =>$taxable_amount_s,'gst_type' => $gst_type_s,
                                            'sgst' => $sgst_s,'cgst' => $cgst_s,
                                            'sgst_amount' => $sgst_amount_s,'cgst_amount' => $cgst_amount_s,
                                            'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s')); 
                                    }
                                    }
                                }
                            }
                        }
                        if(isset($save_arr) && !empty($save_arr)){
                            if(isset($delete_boq_arr) && !empty($delete_boq_arr)){
                                $this->admin_model->deleteBOQTaxInvOldItemById($delete_boq_arr,$tax_invc_id);
                            }
                            $main_arr = array('tax_invc_date'=>$invoice_date,
                            'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),
                            'display'=>'Y','status'=>'pending');
                            $this->common_model->updateDetails('tbl_tax_invc', 'tax_invc_id', $tax_invc_id,$main_arr);
                            $this->common_model->SaveMultiData('tbl_tax_invc_items',$save_arr);
                            $this->json->jsonReturn(array(
                                'valid'=>TRUE,
                                'msg'=>'<div class="alert modify alert-success">Tax Invoice Details Saved Successfully!</div>',
                                'redirect' => base_url().'create-tax-invoice'
                            ));    
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Tax Invoice!!</div>'
                            ));    
                        }
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                        ));
                    }
                }
                    }else{
                        $error = 'N';
                        $error_message = '';
                        $user_id = $this->session->userdata('user_id');
                        if(isset($user_id) && empty($user_id)){
                        $error = 'Y';
                        $error_message = 'Please loggedin!';
                        }
                        $invoice_date = $this->input->post('invoice_date');
                        if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
                        if(isset($invoice_date) && empty($invoice_date)){
                          $error = 'Y';
                          $error_message = 'Please enter Tax Invoice Date!';
                        }
                        $boq_code = $this->input->post('proforma_boq_code');
                        if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                        if(isset($boq_code) && empty($boq_code)){
                        $error = 'Y';
                        $error_message = 'Please enter BOQ Sr No!';
                        }
                        $hsn_sac_code = $this->input->post('proforma_hsn_sac_code');
                        if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                        if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                        $error = 'Y';
                        $error_message = 'Please enter HSN/SAC Code!';
                        }
                        $item_description = $this->input->post('proforma_item_description');
                        if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                        if(isset($item_description) && empty($item_description)){
                        $error = 'Y';
                        $error_message = 'Please enter Item Description!';
                        }
                        $unit = $this->input->post('proforma_unit');
                        if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                        if(isset($unit) && empty($unit)){
                        $error = 'Y';
                        $error_message = 'Please enter Unit!';
                        }
                        $qty = $this->input->post('proforma_qty');
                        if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
                        if(isset($qty) && empty($qty)){
                        $error = 'Y';
                        $error_message = 'Please enter Qty!';
                        }
                        $rate = $this->input->post('proforma_rate');
                        if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
                        if(isset($rate) && empty($rate)){
                        $error = 'Y';
                        $error_message = 'Please enter Rate!';
                        }
                        $taxable_amount = $this->input->post('proforma_itaxable_amount');
                        if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
                        if(isset($taxable_amount) && empty($taxable_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter taxable amount!';
                        }
                        $gst = $this->input->post('proforma_gst');
                        if(isset($gst) && !empty($gst)) {$gst = $gst; } else {$gst=''; }
                        if(isset($gst) && empty($gst)){
                        $error = 'Y';
                        $error_message = 'Please enter gst!';
                        }
                        $gst_amount = $this->input->post('proforma_itotal_amount');
                        if(isset($gst_amount) && !empty($gst_amount)) {$gst_amount = $gst_amount; } else {$gst_amount=''; }
                        if(isset($gst_amount) && empty($gst_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter gst amount!';
                        }
    
                        if(isset($boq_code) && empty($boq_code)
                        && isset($hsn_sac_code) && empty($hsn_sac_code)
                        && isset($item_description) && empty($item_description)
                        && isset($unit) && empty($unit)
                        && isset($qty) && empty($qty)
                        && isset($rate) && empty($rate)
                        && isset($taxable_amount) && empty($taxable_amount)
                        && isset($gst) && empty($gst)
                        && isset($gst_amount) && empty($gst_amount)
                        ){
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">Please Enter Tax Invoice Details!!</div>'
                            ));    
                        }else{
                            if($error == 'N'){
                                if(isset($boq_code) && !empty($boq_code)){
                                    $main_arr = array('project_id'=>$project_id,'tax_invc_date'=>$invoice_date,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),
                                    'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending');
                                    if($tax_invc_id){
                                        $tax_invc_itemid = $this->input->post('tax_invc_itemid');
                                        for($i=0;$i<count($boq_code);$i++){
                                            if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                            if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                            if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                            if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                            if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
                                            if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
                                            if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
                                            if(isset($gst[$i]) && !empty($gst[$i])) {$gst_s = $gst[$i]; } else {$gst_s=0; }            
                                            if(isset($gst_amount[$i]) && !empty($gst_amount[$i])) {$gst_amount_s = $gst_amount[$i]; } else {$gst_amount_s=0; }     
                                            if(isset($gst_type) && !empty($gst_type)) {$gst_type_s = 'inter-state'; } else {$gst_type_s= ''; }         
                                            if(isset($tax_invc_itemid[$i]) && !empty($tax_invc_itemid[$i])) {$tax_invc_itemid_s = $tax_invc_itemid[$i]; } else {$tax_invc_itemid_s=0; }     
                                            
                                            if(isset($boq_code_s) && !empty($boq_code_s)
                                            && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                            && isset($item_description_s) && !empty($item_description_s)
                                            && isset($unit_s) && !empty($unit_s)
                                            && isset($qty_s) && !empty($qty_s)
                                            && isset($rate_s) && !empty($rate_s)
                                            && isset($taxable_amount_s) && !empty($taxable_amount_s)
                                            && isset($gst_s) && !empty($gst_s)
                                            && isset($gst_type_s) && !empty($gst_type_s)
                                            && isset($gst_amount_s) && !empty($gst_amount_s)){
                                                if(isset($boq_code_s) && !empty($boq_code_s) && isset($project_id) && !empty($project_id)){
                                                    $delete_boq_arr[] = $boq_code_s;
                                                    $save_arr[] = array('tax_invc_id'=>$tax_invc_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                                    'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s
                                                    ,'gst'=>$gst_s,'taxable_amount'=>$taxable_amount_s,
                                                    'gst_amount' => $gst_amount_s,'gst_type'=>$gst_type_s,
                                                    'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s')); 
                                                }
                                            }
                                        }
                                    }
                                }
                                if(isset($save_arr) && !empty($save_arr)){
                                    if(isset($delete_boq_arr) && !empty($delete_boq_arr)){
                                        $this->admin_model->deleteBOQTaxInvOldItemById($delete_boq_arr,$tax_invc_id);
                                    }
                                    $main_arr = array('tax_invc_date'=>$invoice_date,
                                    'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),
                                    'display'=>'Y','status'=>'pending');
                                    $this->common_model->updateDetails('tbl_tax_invc', 'tax_invc_id', $tax_invc_id,$main_arr);
                                    $this->common_model->SaveMultiData('tbl_tax_invc_items',$save_arr);
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE,
                                        'msg'=>'<div class="alert modify alert-success">Tax Invoice Details Saved Successfully!</div>',
                                        'redirect' => base_url().'create-tax-invoice'
                                    ));    
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Tax Invoice!!</div>'
                                    ));    
                                }
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                                ));
                            }
                        }
    
                     }
                }else{
                    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger">Tax Invoice No Already Exist!</div>'
                    ));    
                }
            }else{
                $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger">Invalid Tax Invoice!</div>'
                ));    
            }
        }else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
            ));    
        }
    }
    public function save_tax_invoice_details() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_tax_invoice_details');
            if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                $usubmenu_id = $submenu_datau->submenu_id;
                $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                if(isset($check_permissionu) && !empty($check_permissionu)){
                    $save_arr = $update_boq_stock_arr = $update_boq_stock_arr1 = array();
                    $project_id = $this->input->post('project_id');
                    //$tax_invc_no = $this->input->post('tax_invoice_no');
                    $getPrifixData = $this->common_model->getPrifixData('TAX');
                    if(isset($getPrifixData) && !empty($getPrifixData)){
                        $prefix_name = $getPrifixData['prefix_name'];   
                        $financial_year = $getPrifixData['financial_year'];   
                    }else{
                        $prefix_name = 'TAX';
                        $financial_year = $this->getFinancialYear();
                    }
                    $getLastFinancialYear = $this->common_model->getLastFinancialYear('TAX');
                    $tax_invc_inc = 1;
                    $getLastInc = $this->common_model->getLastInc('TAX');
                    if($getLastFinancialYear == $financial_year){
                        if(isset($getLastInc) && !empty($getLastInc)){
                            $tax_invc_inc = $getLastInc + 1;    
                        }
                    }
                    if(strlen($tax_invc_inc) > 4){
                        $tax_invc_no = $prefix_name.'-'.$tax_invc_inc.'/'.$financial_year;
                    }else{
                        $tax_invc_no = $prefix_name.'-'.sprintf('%02d',$tax_invc_inc).'/'.$financial_year;
                    }
                    $gst_type = $this->input->post('gst_type');
                    $invoice_date = $this->input->post('invoice_date');
                    if(isset($project_id) && !empty($project_id) && isset($tax_invc_no) && !empty($tax_invc_no)){
                        $tax_invc = $this->common_model->selectDetailsWhr('tbl_tax_invc','tax_invc_no',$tax_invc_no);
                        if(isset($tax_invc) && empty($tax_invc)){
                             if($gst_type == 'cgst_sgst'){
                                $error = 'N';
                                $error_message = '';
                                $user_id = $this->session->userdata('user_id');
                                if(isset($user_id) && empty($user_id)){
                                $error = 'Y';
                                $error_message = 'Please loggedin!';
                                }
                                $tax_invoice_no = $tax_invc_no;
                                if(isset($tax_invoice_no) && !empty($tax_invoice_no)) {$tax_invoice_no = $tax_invoice_no; } else {$tax_invoice_no=''; }
                                if(isset($tax_invoice_no) && empty($tax_invoice_no)){
                                  $error = 'Y';
                                  $error_message = 'Please enter Tax Invoice No!';
                                }
                                $invoice_date = $this->input->post('invoice_date');
                                if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
                                if(isset($invoice_date) && empty($invoice_date)){
                                  $error = 'Y';
                                  $error_message = 'Please enter Tax Invoice Date!';
                                }
                                $boq_code = $this->input->post('proforma_boq_code_v');
                                 if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                                 if(isset($boq_code) && empty($boq_code)){
                                  $error = 'Y';
                                  $error_message = 'Please enter BOQ Sr No!';
                                }
                                $hsn_sac_code = $this->input->post('proforma_hsn_sac_code');
                                if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                                if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                                $error = 'Y';
                                $error_message = 'Please enter HSN/SAC Code!';
                                }
                                $item_description = $this->input->post('proforma_item_description');
                                if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                                if(isset($item_description) && empty($item_description)){
                                $error = 'Y';
                                $error_message = 'Please enter Item Description!';
                                }
                                $unit = $this->input->post('proforma_unit');
                                if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                                if(isset($unit) && empty($unit)){
                                $error = 'Y';
                                $error_message = 'Please enter Unit!';
                                }
                                $qty = $this->input->post('proforma_qty');
                                if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
                                if(isset($qty) && empty($qty)){
                                $error = 'Y';
                                $error_message = 'Please enter Qty!';
                                }
                                $rate = $this->input->post('proforma_rate');
                                if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
                                if(isset($rate) && empty($rate)){
                                $error = 'Y';
                                $error_message = 'Please enter Rate!';
                                }
                                $taxable_amount = $this->input->post('proforma_itaxable_amount');
                                if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
                                if(isset($taxable_amount) && empty($taxable_amount)){
                                $error = 'Y';
                                $error_message = 'Please enter taxable amount!';
                                }
                                $sgst = $this->input->post('proforma_sgst');
                                if(isset($sgst) && !empty($sgst)) {$sgst = $sgst; } else {$sgst=''; }
                                if(isset($sgst) && empty($sgst)){
                                $error = 'Y';
                                $error_message = 'Please enter sgst!';
                                }
                                $cgst = $this->input->post('proforma_cgst');
                                if(isset($cgst) && !empty($cgst)) {$cgst = $cgst; } else {$cgst=''; }
                                if(isset($cgst) && empty($cgst)){
                                $error = 'Y';
                                $error_message = 'Please enter cgst!';
                                }
                                $cgst_amount = $this->input->post('proforma_cgst_amount');
                                if(isset($cgst_amount) && !empty($cgst_amount)) {$cgst_amount = $cgst_amount; } else {$cgst_amount=''; }
                                if(isset($cgst_amount) && empty($cgst_amount)){
                                $error = 'Y';
                                $error_message = 'Please enter cgst amount!';
                                }
                                $sgst_amount = $this->input->post('proforma_sgst_amount');
                                if(isset($sgst_amount) && !empty($sgst_amount)) {$sgst_amount = $sgst_amount; } else {$sgst_amount=''; }
                                if(isset($sgst_amount) && empty($sgst_amount)){
                                $error = 'Y';
                                $error_message = 'Please enter sgst amount!';
                                }
                                if(isset($boq_code) && empty($boq_code)
                        && isset($hsn_sac_code) && empty($hsn_sac_code)
                        && isset($item_description) && empty($item_description)
                        && isset($unit) && empty($unit)
                        && isset($qty) && empty($qty)
                        && isset($rate) && empty($rate)
                        && isset($taxable_amount) && empty($taxable_amount)
                        && isset($sgst) && empty($sgst)
                        && isset($cgst) && empty($cgst)
                        && isset($cgst_amount) && empty($cgst_amount)
                        && isset($sgst_amount) && empty($sgst_amount)
                        )
                        {
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">Please Enter Tax Invoice Details!!</div>'
                            ));    
                        }else{
                            if($error == 'N'){
                                if(isset($boq_code) && !empty($boq_code)){
                                    $event_name = 'Tax Invoice';
                                    $BOQTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,'exceptional_no'=>$tax_invoice_no,
                                    'exceptional_id'=>0,'event_type'=>'tax_invc','created_date'=>date('Y-m-d H:i:s'),
                                    'created_by'=>$user_id,'updated_by'=>$user_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending',
                                    'approved_by'=>0,'approved_date'=>'');
                                    $transaction_id = $this->common_model->addData('tbl_boq_transactions',$BOQTransArr);
                                    if($transaction_id){
                                    $main_arr = array('project_id'=>$project_id,'tax_invc_no'=>$tax_invoice_no,'tax_invc_date'=>$invoice_date,
                                    'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),
                                    'display'=>'Y','status'=>'pending','tax_invc_inc'=>$tax_invc_inc,'transaction_id'=>$transaction_id);
                                    $tax_invc_id = $this->common_model->addData('tbl_tax_invc',$main_arr);
                                    $proforma_from = $this->input->post('proforma_from');
                                    if($tax_invc_id){
                                        for($i=0;$i<count($boq_code);$i++){
                                            if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                            if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                            if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                            if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                            if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
                                            if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
                                            if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
                                            if(isset($sgst[$i]) && !empty($sgst[$i])) {$sgst_s = $sgst[$i]; } else {$sgst_s=0; }            
                                            if(isset($cgst[$i]) && !empty($cgst[$i])) {$cgst_s = $cgst[$i]; } else {$cgst_s=0; }            
                                            if(isset($cgst_amount[$i]) && !empty($cgst_amount[$i])) {$cgst_amount_s = $cgst_amount[$i]; } else {$cgst_amount_s=0; }            
                                            if(isset($sgst_amount[$i]) && !empty($sgst_amount[$i])) {$sgst_amount_s = $sgst_amount[$i]; } else {$sgst_amount_s=0; }            
                                            if(isset($gst_type) && !empty($gst_type)) {$gst_type_s = 'intra-state'; } else {$gst_type_s= ''; }            
                                            if(isset($proforma_from[$i]) && !empty($proforma_from[$i])) {$proforma_from_s = $proforma_from[$i]; } else {$proforma_from_s=''; }            
                                            
                                            if(isset($boq_code_s) && !empty($boq_code_s)
                                            && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                            && isset($item_description_s) && !empty($item_description_s)
                                            && isset($unit_s) && !empty($unit_s)
                                            && isset($qty_s) && !empty($qty_s)
                                            && isset($rate_s) && !empty($rate_s)
                                            && isset($taxable_amount_s) && !empty($taxable_amount_s)
                                            && isset($cgst_s) && !empty($cgst_s)
                                            && isset($sgst_s) && !empty($sgst_s)
                                            && isset($cgst_amount_s) && !empty($cgst_amount_s)
                                            && isset($gst_type_s) && !empty($gst_type_s)
                                            && isset($sgst_amount_s) && !empty($sgst_amount_s)){
                                                $save_arr[] = array('tax_invc_id'=>$tax_invc_id,'tax_from'=>$proforma_from_s,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                                'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s,'taxable_amount' =>$taxable_amount_s,'gst_type' => $gst_type_s,
                                                'sgst' => $sgst_s,'cgst' => $cgst_s,
                                                'sgst_amount' => $sgst_amount_s,'cgst_amount' => $cgst_amount_s,
                                                'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s')); 
                                            }
                                        }
                                    }
                                    }
                                }
                                if(isset($save_arr) && !empty($save_arr)){
                                    $this->common_model->SaveMultiData('tbl_tax_invc_items',$save_arr);
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE,
                                        'msg'=>'<div class="alert modify alert-success">Tax Invoice Details Saved Successfully!</div>',
                                        'redirect' => base_url().'create-tax-invoice'
                                    ));    
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Tax Invoice!!</div>'
                                    ));    
                                }
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                                ));
                            }
                        }
                    }else{
                                $error = 'N';
                                $error_message = '';
                                $user_id = $this->session->userdata('user_id');
                                if(isset($user_id) && empty($user_id)){
                                $error = 'Y';
                                $error_message = 'Please loggedin!';
                                }
                                $tax_invoice_no = $tax_invc_no;
                                if(isset($tax_invoice_no) && !empty($tax_invoice_no)) {$tax_invoice_no = $tax_invoice_no; } else {$tax_invoice_no=''; }
                                if(isset($tax_invoice_no) && empty($tax_invoice_no)){
                                  $error = 'Y';
                                  $error_message = 'Please enter Tax Invoice No!';
                                }
                                $invoice_date = $this->input->post('invoice_date');
                                if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
                                if(isset($invoice_date) && empty($invoice_date)){
                                  $error = 'Y';
                                  $error_message = 'Please enter Tax Invoice Date!';
                                }
                                $boq_code = $this->input->post('proforma_boq_code');
                                if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                                if(isset($boq_code) && empty($boq_code)){
                                $error = 'Y';
                                $error_message = 'Please enter BOQ Sr No!';
                                }
                                $hsn_sac_code = $this->input->post('proforma_hsn_sac_code');
                                if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                                if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                                $error = 'Y';
                                $error_message = 'Please enter HSN/SAC Code!';
                                }
                                $item_description = $this->input->post('proforma_item_description');
                                if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                                if(isset($item_description) && empty($item_description)){
                                $error = 'Y';
                                $error_message = 'Please enter Item Description!';
                                }
                                $unit = $this->input->post('proforma_unit');
                                if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                                if(isset($unit) && empty($unit)){
                                $error = 'Y';
                                $error_message = 'Please enter Unit!';
                                }
                                $qty = $this->input->post('proforma_qty');
                                if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
                                if(isset($qty) && empty($qty)){
                                $error = 'Y';
                                $error_message = 'Please enter Qty!';
                                }
                                $rate = $this->input->post('proforma_rate');
                                if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
                                if(isset($rate) && empty($rate)){
                                $error = 'Y';
                                $error_message = 'Please enter Rate!';
                                }
                                $taxable_amount = $this->input->post('proforma_itaxable_amount');
                                if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
                                if(isset($taxable_amount) && empty($taxable_amount)){
                                $error = 'Y';
                                $error_message = 'Please enter taxable amount!';
                                }
                                $gst = $this->input->post('proforma_gst');
                                if(isset($gst) && !empty($gst)) {$gst = $gst; } else {$gst=''; }
                                if(isset($gst) && empty($gst)){
                                $error = 'Y';
                                $error_message = 'Please enter gst!';
                                }
                                $gst_amount = $this->input->post('proforma_itotal_amount');
                                if(isset($gst_amount) && !empty($gst_amount)) {$gst_amount = $gst_amount; } else {$gst_amount=''; }
                                if(isset($gst_amount) && empty($gst_amount)){
                                $error = 'Y';
                                $error_message = 'Please enter gst amount!';
                                }
            
                                if(isset($boq_code) && empty($boq_code)
                                && isset($hsn_sac_code) && empty($hsn_sac_code)
                                && isset($item_description) && empty($item_description)
                                && isset($unit) && empty($unit)
                                && isset($qty) && empty($qty)
                                && isset($rate) && empty($rate)
                                && isset($taxable_amount) && empty($taxable_amount)
                                && isset($gst) && empty($gst)
                                && isset($gst_amount) && empty($gst_amount)
                                ){
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger">Please Enter Tax Invoice Details!!</div>'
                                    ));    
                                }else{
                                    if($error == 'N'){
                                        if(isset($boq_code) && !empty($boq_code)){
                                            $main_arr = array('project_id'=>$project_id,'tax_invc_no'=>$tax_invoice_no,'tax_invc_date'=>$invoice_date,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),
                                            'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending','tax_invc_inc'=>$tax_invc_inc);
                                            $tax_invc_id = $this->common_model->addData('tbl_tax_invc',$main_arr);
                                            if($tax_invc_id){
                                                for($i=0;$i<count($boq_code);$i++){
                                                    if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                                    if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                                    if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                                    if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                                    if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
                                                    if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
                                                    if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
                                                    if(isset($gst[$i]) && !empty($gst[$i])) {$gst_s = $gst[$i]; } else {$gst_s=0; }            
                                                    if(isset($gst_amount[$i]) && !empty($gst_amount[$i])) {$gst_amount_s = $gst_amount[$i]; } else {$gst_amount_s=0; }     
                                                    if(isset($gst_type) && !empty($gst_type)) {$gst_type_s = 'inter-state'; } else {$gst_type_s= ''; }         
                                                    
                                                    if(isset($boq_code_s) && !empty($boq_code_s)
                                                    && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                                    && isset($item_description_s) && !empty($item_description_s)
                                                    && isset($unit_s) && !empty($unit_s)
                                                    && isset($qty_s) && !empty($qty_s)
                                                    && isset($rate_s) && !empty($rate_s)
                                                    && isset($taxable_amount_s) && !empty($taxable_amount_s)
                                                    && isset($gst_s) && !empty($gst_s)
                                                    && isset($gst_type_s) && !empty($gst_type_s)
                                                    && isset($gst_amount_s) && !empty($gst_amount_s)
                                                    ){
                                                        $save_arr[] = array('tax_invc_id'=>$tax_invc_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                                        'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s
                                                        ,'gst'=>$gst_s,'taxable_amount'=>$taxable_amount_s,
                                                        'gst_amount' => $gst_amount_s,'gst_type'=>$gst_type_s,
                                                        'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s')); 
                                                        
                                                        
                                                    }
                                                }
                                            }
                                        }
                                        if(isset($save_arr) && !empty($save_arr)){
                                            $this->common_model->SaveMultiData('tbl_tax_invc_items',$save_arr);
                                            $this->json->jsonReturn(array(
                                                'valid'=>TRUE,
                                                'msg'=>'<div class="alert modify alert-success">Tax Invoice Details Saved Successfully!</div>',
                                                'redirect' => base_url().'create-tax-invoice'
                                            ));    
                                        }else{
                                            $this->json->jsonReturn(array(
                                                'valid'=>FALSE,
                                                'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Tax Invoice!!</div>'
                                            ));    
                                        }
                                    }else{
                                        $this->json->jsonReturn(array(
                                            'valid'=>FALSE,
                                            'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                                        ));
                                    }
                                }
            
                             }
            
            
                       
                      // here
                       
            
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">Tax Invoice no already exist!</div>'
                        ));    
                    }
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
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
		}else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">You have no Permission!!</div>'
            ));
        }
		
    }
//     public function update_proforma_invoice_details() 
//     {
//         $save_arr = array();
//         $update_boq_stock_arr = array();
//         $update_boq_stock_arr1 = array();
//         $delete_boq_arr = array();
//         $project_id = $this->input->post('project_id');
//         $invoice_date = $this->input->post('invoice_date');
//         $gst_type = $this->input->post('gst_type');
//         $proforma_id = $this->input->post('update_proforma_id');
//         if(isset($project_id) && !empty($project_id) && isset($invoice_date) && !empty($invoice_date)
//           && isset($proforma_id) && !empty($proforma_id)){
//             $proforma_invc = $this->common_model->selectDetailsWhr('tbl_proforma_invc','proforma_id',$proforma_id);
//             if(isset($proforma_invc) && !empty($proforma_invc)){
//                 if($gst_type == 'cgst_sgst'){
//                     $error = 'N';
//                     $error_message = '';
//                     $user_id = $this->session->userdata('user_id');
//                     if(isset($user_id) && empty($user_id)){
//                     $error = 'Y';
//                     $error_message = 'Please loggedin!';
//                     }
//                     if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
//                     $boq_code = $this->input->post('proforma_boq_code_v');
//                      if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
//                      if(isset($boq_code) && empty($boq_code)){
//                       $error = 'Y';
//                       $error_message = 'Please enter BOQ Sr No!';
//                     }
//                     $hsn_sac_code = $this->input->post('proforma_hsn_sac_code');
//                     if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
//                     if(isset($hsn_sac_code) && empty($hsn_sac_code)){
//                     $error = 'Y';
//                     $error_message = 'Please enter HSN/SAC Code!';
//                     }
//                     $item_description = $this->input->post('proforma_item_description');
//                     if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
//                     if(isset($item_description) && empty($item_description)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Item Description!';
//                     }
//                     $unit = $this->input->post('proforma_unit');
//                     if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
//                     if(isset($unit) && empty($unit)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Unit!';
//                     }
//                     $qty = $this->input->post('proforma_qty');
//                     if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
//                     if(isset($qty) && empty($qty)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Qty!';
//                     }
//                     $rate = $this->input->post('proforma_rate');
//                     if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
//                     if(isset($rate) && empty($rate)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Rate!';
//                     }
//                     $taxable_amount = $this->input->post('proforma_itaxable_amount');
//                     if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
//                     if(isset($taxable_amount) && empty($taxable_amount)){
//                     $error = 'Y';
//                     $error_message = 'Please enter taxable amount!';
//                     }

//                     $sgst = $this->input->post('proforma_sgst');
//                     if(isset($sgst) && !empty($sgst)) {$sgst = $sgst; } else {$sgst=''; }
//                     if(isset($sgst) && empty($sgst)){
//                     $error = 'Y';
//                     $error_message = 'Please enter sgst!';
//                     }
//                     $cgst = $this->input->post('proforma_cgst');
//                     if(isset($cgst) && !empty($cgst)) {$cgst = $cgst; } else {$cgst=''; }
//                     if(isset($cgst) && empty($cgst)){
//                     $error = 'Y';
//                     $error_message = 'Please enter cgst!';
//                     }
//                     $cgst_amount = $this->input->post('proforma_cgst_amount');
//                     if(isset($cgst_amount) && !empty($cgst_amount)) {$cgst_amount = $cgst_amount; } else {$cgst_amount=''; }
//                     if(isset($cgst_amount) && empty($cgst_amount)){
//                     $error = 'Y';
//                     $error_message = 'Please enter cgst amount!';
//                     }
//                     $sgst_amount = $this->input->post('proforma_sgst_amount');
//                     if(isset($sgst_amount) && !empty($sgst_amount)) {$sgst_amount = $sgst_amount; } else {$sgst_amount=''; }
//                     if(isset($sgst_amount) && empty($sgst_amount)){
//                     $error = 'Y';
//                     $error_message = 'Please enter sgst amount!';
//                     }
//                     if(isset($boq_code) && empty($boq_code)
//                     && isset($hsn_sac_code) && empty($hsn_sac_code)
//                     && isset($item_description) && empty($item_description)
//                     && isset($unit) && empty($unit)
//                     && isset($qty) && empty($qty)
//                     && isset($rate) && empty($rate)
//                     && isset($taxable_amount) && empty($taxable_amount)
//                     && isset($sgst) && empty($sgst)
//                     && isset($cgst) && empty($cgst)
//                     && isset($cgst_amount) && empty($cgst_amount)
//                     && isset($sgst_amount) && empty($sgst_amount)){
//                       $this->json->jsonReturn(array(
//                           'valid'=>FALSE,
//                           'msg'=>'<div class="alert modify alert-danger">Please Enter Proforma Invoice Details!!</div>'
//                       ));    
//                   }else{
//                       if($error == 'N'){
//                             $project_billing_type_value = $this->input->post('project_billing_type_value');
//                             $billing_type_value = 0;
//                             if($project_billing_type_value > 0){
//                                 $billing_type_value = $project_billing_type_value;
//                             }
//                             $project_billing_type = $this->input->post('project_billing_type') != "" ? $this->input->post('project_billing_type') : "";
//                             if(isset($boq_code) && !empty($boq_code)){
//                                 if($proforma_id){
//                                 $proforma_itemid = $this->input->post('proforma_itemid');
//                                 $proforma_from = $this->input->post('proforma_from');
//                                 for($i=0;$i<count($boq_code);$i++){
//                                 if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
//                                 if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
//                                 if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
//                                 if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
//                                 if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
//                                 if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
//                                 if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
//                                 if(isset($sgst[$i]) && !empty($sgst[$i])) {$sgst_s = $sgst[$i]; } else {$sgst_s=0; }            
//                                 if(isset($cgst[$i]) && !empty($cgst[$i])) {$cgst_s = $cgst[$i]; } else {$cgst_s=0; }            
//                                 if(isset($cgst_amount[$i]) && !empty($cgst_amount[$i])) {$cgst_amount_s = $cgst_amount[$i]; } else {$cgst_amount_s=0; }            
//                                 if(isset($sgst_amount[$i]) && !empty($sgst_amount[$i])) {$sgst_amount_s = $sgst_amount[$i]; } else {$sgst_amount_s=0; }            
//                                 if(isset($proforma_from[$i]) && !empty($proforma_from[$i])) {$proforma_from_s = $proforma_from[$i]; } else {$proforma_from_s=0; }            
                                
//                                 $gst_type_s = 'intra-state';
//                                 if(isset($proforma_itemid[$i]) && !empty($proforma_itemid[$i])) {$proforma_itemid_s = $proforma_itemid[$i]; } else {$proforma_itemid_s=0; }            
                                
//                                 if(isset($boq_code_s) && !empty($boq_code_s)
//                                 && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
//                                 && isset($item_description_s) && !empty($item_description_s)
//                                 && isset($unit_s) && !empty($unit_s)
//                                 && isset($qty_s) && !empty($qty_s)
//                                 && isset($rate_s) && !empty($rate_s)
//                                 && isset($taxable_amount_s) && !empty($taxable_amount_s)
//                                 && isset($cgst_s) && !empty($cgst_s)
//                                 && isset($sgst_s) && !empty($sgst_s)
//                                 && isset($cgst_amount_s) && !empty($cgst_amount_s)
//                                 && isset($gst_type_s) && !empty($gst_type_s)
//                                 && isset($sgst_amount_s) && !empty($sgst_amount_s)){
//                                     if(isset($boq_code_s) && !empty($boq_code_s) && isset($project_id) && !empty($project_id)){
//                                         $delete_boq_arr[] = $boq_code_s;
//                                         $save_arr[] = array('proforma_id'=>$proforma_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
//                                         'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s,'taxable_amount' =>$taxable_amount_s,'gst_type' => $gst_type_s,
//                                         'sgst' => $sgst_s,'cgst' => $cgst_s,
//                                         'sgst_amount' => $sgst_amount_s,'cgst_amount' => $cgst_amount_s,'proforma_from'=>$proforma_from_s,
//                                         'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));
//                                     }
//                                 }
//                             }
//                             }
//                             }
//                         if(isset($save_arr) && !empty($save_arr)){
//                             if(isset($delete_boq_arr) && !empty($delete_boq_arr)){
//                                 $this->admin_model->deleteBOQProformaOldItemById($delete_boq_arr,$proforma_id);
//                             }
//                             if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
//                             $main_arr = array('invoice_date'=>$invoice_date,
//                             'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending','billing_type_value'=>$billing_type_value,'billing_type'=>$project_billing_type);
//                             $this->common_model->updateDetails('tbl_proforma_invc', 'proforma_id', $proforma_id,$main_arr);
//                             $this->common_model->SaveMultiData('tbl_proforma_invc_items',$save_arr);
//                             $this->json->jsonReturn(array(
//                                 'valid'=>TRUE,
//                                 'msg'=>'<div class="alert modify alert-success">Perfoma Invoice Details Saved Successfully!</div>',
//                                 'redirect' => base_url().'create-proforma-invoice'
//                             ));    
//                         }else{
//                             $this->json->jsonReturn(array(
//                                 'valid'=>FALSE,
//                                 'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Perfoma Invoice!!</div>'
//                             ));    
//                         }
//                     }else{
//                         $this->json->jsonReturn(array(
//                             'valid'=>FALSE,
//                             'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
//                         ));
//                       }
//                     }
//                 }else{
//                     $error = 'N';
//                     $error_message = '';
//                     $user_id = $this->session->userdata('user_id');
//                     if(isset($user_id) && empty($user_id)){
//                     $error = 'Y';
//                     $error_message = 'Please loggedin!';
//                     }
//                     $boq_code = $this->input->post('proforma_boq_code');
//                     if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
//                     if(isset($boq_code) && empty($boq_code)){
//                     $error = 'Y';
//                     $error_message = 'Please enter BOQ Sr No!';
//                     }
//                     $hsn_sac_code = $this->input->post('proforma_hsn_sac_code');
//                     if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
//                     if(isset($hsn_sac_code) && empty($hsn_sac_code)){
//                     $error = 'Y';
//                     $error_message = 'Please enter HSN/SAC Code!';
//                     }
//                     $item_description = $this->input->post('proforma_item_description');
//                     if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
//                     if(isset($item_description) && empty($item_description)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Item Description!';
//                     }
//                     $unit = $this->input->post('proforma_unit');
//                     if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
//                     if(isset($unit) && empty($unit)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Unit!';
//                     }
//                     $qty = $this->input->post('proforma_qty');
//                     if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
//                     if(isset($qty) && empty($qty)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Qty!';
//                     }
//                     $rate = $this->input->post('proforma_rate');
//                     if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
//                     if(isset($rate) && empty($rate)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Rate!';
//                     }
//                     $taxable_amount = $this->input->post('proforma_itaxable_amount');
//                     if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
//                     if(isset($taxable_amount) && empty($taxable_amount)){
//                     $error = 'Y';
//                     $error_message = 'Please enter taxable amount!';
//                     }

//                     $gst = $this->input->post('proforma_gst');
//                     if(isset($gst) && !empty($gst)) {$gst = $gst; } else {$gst=''; }
//                     if(isset($gst) && empty($gst)){
//                     $error = 'Y';
//                     $error_message = 'Please enter gst!';
//                     }
//                     $gst_amount = $this->input->post('proforma_itotal_amount');
//                     if(isset($gst_amount) && !empty($gst_amount)) {$gst_amount = $gst_amount; } else {$gst_amount=''; }
//                     if(isset($gst_amount) && empty($gst_amount)){
//                     $error = 'Y';
//                     $error_message = 'Please enter gst amount!';
//                     }

//                     if(isset($boq_code) && empty($boq_code)
//                     && isset($hsn_sac_code) && empty($hsn_sac_code)
//                     && isset($item_description) && empty($item_description)
//                     && isset($unit) && empty($unit)
//                     && isset($qty) && empty($qty)
//                     && isset($rate) && empty($rate)
//                     && isset($taxable_amount) && empty($taxable_amount)
//                     && isset($gst) && empty($gst)
//                     && isset($gst_amount) && empty($gst_amount)
//                     ){
//                         $this->json->jsonReturn(array(
//                             'valid'=>FALSE,
//                             'msg'=>'<div class="alert modify alert-danger">Please Enter Proforma Invoice Details!!</div>'
//                         ));    
//                     }else{
//                         if($error == 'N'){
//                             if(isset($boq_code) && !empty($boq_code)){
//                                 $main_arr = array('project_id'=>$project_id,'invoice_date'=>$invoice_date,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),
//                                 'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending');
//                                 if($proforma_id){
//                                     $proforma_itemid = $this->input->post('proforma_itemid');
//                                     $proforma_from = $this->input->post('proforma_from');
//                                     for($i=0;$i<count($boq_code);$i++){
//                                         if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
//                                         if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
//                                         if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
//                                         if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
//                                         if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
//                                         if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
//                                         if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
//                                         if(isset($gst[$i]) && !empty($gst[$i])) {$gst_s = $gst[$i]; } else {$gst_s=0; }            
//                                         if(isset($gst_amount[$i]) && !empty($gst_amount[$i])) {$gst_amount_s = $gst_amount[$i]; } else {$gst_amount_s=0; }     
//                                         if(isset($proforma_from[$i]) && !empty($proforma_from[$i])) {$proforma_from_s = $proforma_from[$i]; } else {$proforma_from_s=0; }     
//                                         $gst_type_s = 'inter-state';
//                                         if(isset($proforma_itemid[$i]) && !empty($proforma_itemid[$i])) {$proforma_itemid_s = $proforma_itemid[$i]; } else {$proforma_itemid_s=0; }     
                                        
//                                         if(isset($boq_code_s) && !empty($boq_code_s)
//                                         && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
//                                         && isset($item_description_s) && !empty($item_description_s)
//                                         && isset($unit_s) && !empty($unit_s)
//                                         && isset($qty_s) && !empty($qty_s)
//                                         && isset($rate_s) && !empty($rate_s)
//                                         && isset($taxable_amount_s) && !empty($taxable_amount_s)
//                                         && isset($gst_s) && !empty($gst_s)
//                                         && isset($gst_type_s) && !empty($gst_type_s)
//                                         && isset($gst_amount_s) && !empty($gst_amount_s)){
//                                             if(isset($boq_code_s) && !empty($boq_code_s) && isset($project_id) && !empty($project_id)){
//                                                 $delete_boq_arr[] = $boq_code_s;
//                                                 $save_arr[] = array('proforma_id'=>$proforma_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
//                                                 'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s
//                                                 ,'gst'=>$gst_s,'taxable_amount'=>$taxable_amount_s,
//                                                 'gst_amount' => $gst_amount_s,'gst_type'=>$gst_type_s,'proforma_from'=>$proforma_from_s,
//                                                 'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));
//                                             }
//                                         }
//                                     }
//                                 }
//                             }
//                             if(isset($save_arr) && !empty($save_arr)){
//                                 if(isset($delete_boq_arr) && !empty($delete_boq_arr)){
//                                     $this->admin_model->deleteBOQProformaOldItemById($delete_boq_arr,$proforma_id);
//                                 }
//                                 if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
//                                 $main_arr = array('invoice_date'=>$invoice_date,
//                                 'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending');
//                                 $this->common_model->updateDetails('tbl_proforma_invc', 'proforma_id', $proforma_id,$main_arr);
//                                 $this->common_model->SaveMultiData('tbl_proforma_invc_items',$save_arr);
//                                 $this->json->jsonReturn(array(
//                                     'valid'=>TRUE,
//                                     'msg'=>'<div class="alert modify alert-success">Perfoma Invoice Details Saved Successfully!</div>',
//                                     'redirect' => base_url().'create-proforma-invoice'
//                                 ));    
//                             }else{
//                                 $this->json->jsonReturn(array(
//                                     'valid'=>FALSE,
//                                     'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Proforma Invoice!!</div>'
//                                 ));    
//                             }
//                         }else{
//                             $this->json->jsonReturn(array(
//                                 'valid'=>FALSE,
//                                 'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
//                             ));
//                         }
//                     }

//                  }
//             }else{
//                 $this->json->jsonReturn(array(
//                     'valid'=>FALSE,
//                     'msg'=>'<div class="alert modify alert-danger">Invalid Proforma Invoice!</div>'
//                 ));    
//             }
//         }else{
//             $this->json->jsonReturn(array(
//                 'valid'=>FALSE,
//                 'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
//             ));    
//         }
//     }


// public function update_proforma_invoice_details() 
//     {
//         $auto_round_off_enable = $this->input->post('auto_round_off_enable');
//         $auto_round_off_type = $this->input->post('auto_round_off_type');
//         $auto_round_off_value = $this->input->post('auto_round_off_value');
//         $auto_round_value = 0 ;
//         $auto_round_enable = "No";
//         if($auto_round_off_enable == "Yes" && $auto_round_off_value > 0){
//             $auto_round_value = $auto_round_off_type == "Add" ? "+".$auto_round_off_value : "-".$auto_round_off_value; 
//             $auto_round_enable = "Yes";
//         }

//         $save_arr = array();
//         $update_boq_stock_arr = array();
//         $update_boq_stock_arr1 = array();
//         $delete_boq_arr = array();
//         $project_id = $this->input->post('project_id');
//         $invoice_date = $this->input->post('invoice_date');
//         $gst_type = $this->input->post('gst_type');
//         $proforma_id = $this->input->post('update_proforma_id');
//         if(isset($project_id) && !empty($project_id) && isset($invoice_date) && !empty($invoice_date)
//           && isset($proforma_id) && !empty($proforma_id)){
//             $proforma_invc = $this->common_model->selectDetailsWhr('tbl_proforma_invc','proforma_id',$proforma_id);
//             if(isset($proforma_invc) && !empty($proforma_invc)){
//                 if($gst_type == 'cgst_sgst'){
//                     $error = 'N';
//                     $error_message = '';
//                     $user_id = $this->session->userdata('user_id');
//                     if(isset($user_id) && empty($user_id)){
//                     $error = 'Y';
//                     $error_message = 'Please loggedin!';
//                     }
//                     if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
//                     $boq_code = $this->input->post('proforma_boq_code_v');
//                      if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
//                      if(isset($boq_code) && empty($boq_code)){
//                       $error = 'Y';
//                       $error_message = 'Please enter BOQ Sr No!';
//                     }
//                     $hsn_sac_code = $this->input->post('proforma_hsn_sac_code');
//                     if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
//                     if(isset($hsn_sac_code) && empty($hsn_sac_code)){
//                     $error = 'Y';
//                     $error_message = 'Please enter HSN/SAC Code!';
//                     }
//                     $item_description = $this->input->post('proforma_item_description');
//                     if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
//                     if(isset($item_description) && empty($item_description)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Item Description!';
//                     }
//                     $unit = $this->input->post('proforma_unit');
//                     if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
//                     if(isset($unit) && empty($unit)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Unit!';
//                     }
//                     $qty = $this->input->post('proforma_qty');
//                     if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
//                     if(isset($qty) && empty($qty)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Qty!';
//                     }
//                     $rate = $this->input->post('proforma_rate');
//                     if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
//                     if(isset($rate) && empty($rate)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Rate!';
//                     }
//                     $taxable_amount = $this->input->post('proforma_itaxable_amount');
//                     if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
//                     if(isset($taxable_amount) && empty($taxable_amount)){
//                     $error = 'Y';
//                     $error_message = 'Please enter taxable amount!';
//                     }

//                     $sgst = $this->input->post('proforma_sgst');
//                     if(isset($sgst) && !empty($sgst)) {$sgst = $sgst; } else {$sgst=''; }
//                     if(isset($sgst) && empty($sgst)){
//                     $error = 'Y';
//                     $error_message = 'Please enter sgst!';
//                     }
//                     $cgst = $this->input->post('proforma_cgst');
//                     if(isset($cgst) && !empty($cgst)) {$cgst = $cgst; } else {$cgst=''; }
//                     if(isset($cgst) && empty($cgst)){
//                     $error = 'Y';
//                     $error_message = 'Please enter cgst!';
//                     }
//                     $cgst_amount = $this->input->post('proforma_cgst_amount');
//                     if(isset($cgst_amount) && !empty($cgst_amount)) {$cgst_amount = $cgst_amount; } else {$cgst_amount=''; }
//                     if(isset($cgst_amount) && empty($cgst_amount)){
//                     $error = 'Y';
//                     $error_message = 'Please enter cgst amount!';
//                     }
//                     $sgst_amount = $this->input->post('proforma_sgst_amount');
//                     if(isset($sgst_amount) && !empty($sgst_amount)) {$sgst_amount = $sgst_amount; } else {$sgst_amount=''; }
//                     if(isset($sgst_amount) && empty($sgst_amount)){
//                     $error = 'Y';
//                     $error_message = 'Please enter sgst amount!';
//                     }
//                     if(isset($boq_code) && empty($boq_code)
//                     && isset($hsn_sac_code) && empty($hsn_sac_code)
//                     && isset($item_description) && empty($item_description)
//                     && isset($unit) && empty($unit)
//                     && isset($qty) && empty($qty)
//                     && isset($rate) && empty($rate)
//                     && isset($taxable_amount) && empty($taxable_amount)
//                     && isset($sgst) && empty($sgst)
//                     && isset($cgst) && empty($cgst)
//                     && isset($cgst_amount) && empty($cgst_amount)
//                     && isset($sgst_amount) && empty($sgst_amount)){
//                       $this->json->jsonReturn(array(
//                           'valid'=>FALSE,
//                           'msg'=>'<div class="alert modify alert-danger">Please Enter Proforma Invoice Details!!</div>'
//                       ));    
//                   }else{
//                       if($error == 'N'){
//                             $project_billing_type_value = $this->input->post('project_billing_type_value');
//                             $billing_type_value = 0;
//                             if($project_billing_type_value > 0){
//                                 $billing_type_value = $project_billing_type_value;
//                             }
//                             $project_billing_type = $this->input->post('project_billing_type') != "" ? $this->input->post('project_billing_type') : "";
//                             if(isset($boq_code) && !empty($boq_code)){
//                                 if($proforma_id){
//                                 $proforma_itemid = $this->input->post('proforma_itemid');
//                                 $proforma_from = $this->input->post('proforma_from');
//                                 for($i=0;$i<count($boq_code);$i++){
//                                 if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
//                                 if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
//                                 if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
//                                 if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
//                                 if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
//                                 if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
//                                 if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
//                                 if(isset($sgst[$i]) && !empty($sgst[$i])) {$sgst_s = $sgst[$i]; } else {$sgst_s=0; }            
//                                 if(isset($cgst[$i]) && !empty($cgst[$i])) {$cgst_s = $cgst[$i]; } else {$cgst_s=0; }            
//                                 if(isset($cgst_amount[$i]) && !empty($cgst_amount[$i])) {$cgst_amount_s = $cgst_amount[$i]; } else {$cgst_amount_s=0; }            
//                                 if(isset($sgst_amount[$i]) && !empty($sgst_amount[$i])) {$sgst_amount_s = $sgst_amount[$i]; } else {$sgst_amount_s=0; }            
//                                 if(isset($proforma_from[$i]) && !empty($proforma_from[$i])) {$proforma_from_s = $proforma_from[$i]; } else {$proforma_from_s=0; }            
                                
//                                 $gst_type_s = 'intra-state';
//                                 if(isset($proforma_itemid[$i]) && !empty($proforma_itemid[$i])) {$proforma_itemid_s = $proforma_itemid[$i]; } else {$proforma_itemid_s=0; }            
                                
//                                 if(isset($boq_code_s) && !empty($boq_code_s)
//                                 && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
//                                 && isset($item_description_s) && !empty($item_description_s)
//                                 && isset($unit_s) && !empty($unit_s)
//                                 && isset($qty_s) && !empty($qty_s)
//                                 && isset($rate_s) && !empty($rate_s)
//                                 && isset($taxable_amount_s) && !empty($taxable_amount_s)
//                                 && isset($cgst_s) && !empty($cgst_s)
//                                 && isset($sgst_s) && !empty($sgst_s)
//                                 && isset($cgst_amount_s) && !empty($cgst_amount_s)
//                                 && isset($gst_type_s) && !empty($gst_type_s)
//                                 && isset($sgst_amount_s) && !empty($sgst_amount_s)){
//                                     if(isset($boq_code_s) && !empty($boq_code_s) && isset($project_id) && !empty($project_id)){
//                                         $delete_boq_arr[] = $boq_code_s;
//                                         $save_arr[] = array('proforma_id'=>$proforma_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
//                                         'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s,'taxable_amount' =>$taxable_amount_s,'gst_type' => $gst_type_s,
//                                         'sgst' => $sgst_s,'cgst' => $cgst_s,
//                                         'sgst_amount' => $sgst_amount_s,'cgst_amount' => $cgst_amount_s,'proforma_from'=>$proforma_from_s,
//                                         'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));
//                                     }
//                                 }
//                             }
//                             }
//                             }

//                         if(isset($save_arr) && !empty($save_arr)){
//                             if(isset($delete_boq_arr) && !empty($delete_boq_arr)){
//                                 $this->admin_model->deleteBOQProformaOldItemById($delete_boq_arr,$proforma_id);
//                             }
//                             if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
//                             $main_arr = array('invoice_date'=>$invoice_date,
//                             'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending','billing_type_value'=>$billing_type_value,'billing_type'=>$project_billing_type,"auto_round_value"=>$auto_round_value,"auto_round_enable" => $auto_round_enable);
//                             $this->common_model->updateDetails('tbl_proforma_invc', 'proforma_id', $proforma_id,$main_arr);
//                             $this->common_model->SaveMultiData('tbl_proforma_invc_items',$save_arr);

//                             $this->json->jsonReturn(array(
//                                 'valid'=>TRUE,
//                                 'msg'=>'<div class="alert modify alert-success">Perfoma Invoice Details Saved Successfully!</div>',
//                                 'redirect' => base_url().'create-proforma-invoice'
//                             ));    
//                         }else{
//                             $this->json->jsonReturn(array(
//                                 'valid'=>FALSE,
//                                 'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Perfoma Invoice!!</div>'
//                             ));    
//                         }
//                     }else{
//                         $this->json->jsonReturn(array(
//                             'valid'=>FALSE,
//                             'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
//                         ));
//                       }
//                     }
//                 }else{
//                     $error = 'N';
//                     $error_message = '';
//                     $user_id = $this->session->userdata('user_id');
//                     if(isset($user_id) && empty($user_id)){
//                     $error = 'Y';
//                     $error_message = 'Please loggedin!';
//                     }
//                     $boq_code = $this->input->post('proforma_boq_code');
//                     if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
//                     if(isset($boq_code) && empty($boq_code)){
//                     $error = 'Y';
//                     $error_message = 'Please enter BOQ Sr No!';
//                     }
//                     $hsn_sac_code = $this->input->post('proforma_hsn_sac_code');
//                     if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
//                     if(isset($hsn_sac_code) && empty($hsn_sac_code)){
//                     $error = 'Y';
//                     $error_message = 'Please enter HSN/SAC Code!';
//                     }
//                     $item_description = $this->input->post('proforma_item_description');
//                     if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
//                     if(isset($item_description) && empty($item_description)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Item Description!';
//                     }
//                     $unit = $this->input->post('proforma_unit');
//                     if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
//                     if(isset($unit) && empty($unit)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Unit!';
//                     }
//                     $qty = $this->input->post('proforma_qty');
//                     if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
//                     if(isset($qty) && empty($qty)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Qty!';
//                     }
//                     $rate = $this->input->post('proforma_rate');
//                     if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
//                     if(isset($rate) && empty($rate)){
//                     $error = 'Y';
//                     $error_message = 'Please enter Rate!';
//                     }
//                     $taxable_amount = $this->input->post('proforma_itaxable_amount');
//                     if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
//                     if(isset($taxable_amount) && empty($taxable_amount)){
//                     $error = 'Y';
//                     $error_message = 'Please enter taxable amount!';
//                     }

//                     $gst = $this->input->post('proforma_gst');
//                     if(isset($gst) && !empty($gst)) {$gst = $gst; } else {$gst=''; }
//                     if(isset($gst) && empty($gst)){
//                     $error = 'Y';
//                     $error_message = 'Please enter gst!';
//                     }
//                     $gst_amount = $this->input->post('proforma_itotal_amount');
//                     if(isset($gst_amount) && !empty($gst_amount)) {$gst_amount = $gst_amount; } else {$gst_amount=''; }
//                     if(isset($gst_amount) && empty($gst_amount)){
//                     $error = 'Y';
//                     $error_message = 'Please enter gst amount!';
//                     }

//                     if(isset($boq_code) && empty($boq_code)
//                     && isset($hsn_sac_code) && empty($hsn_sac_code)
//                     && isset($item_description) && empty($item_description)
//                     && isset($unit) && empty($unit)
//                     && isset($qty) && empty($qty)
//                     && isset($rate) && empty($rate)
//                     && isset($taxable_amount) && empty($taxable_amount)
//                     && isset($gst) && empty($gst)
//                     && isset($gst_amount) && empty($gst_amount)
//                     ){
//                         $this->json->jsonReturn(array(
//                             'valid'=>FALSE,
//                             'msg'=>'<div class="alert modify alert-danger">Please Enter Proforma Invoice Details!!</div>'
//                         ));    
//                     }else{
//                         if($error == 'N'){
//                             if(isset($boq_code) && !empty($boq_code)){
//                                 $main_arr = array('project_id'=>$project_id,'invoice_date'=>$invoice_date,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),
//                                 'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending');
//                                 if($proforma_id){
//                                     $proforma_itemid = $this->input->post('proforma_itemid');
//                                     $proforma_from = $this->input->post('proforma_from');
//                                     for($i=0;$i<count($boq_code);$i++){
//                                         if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
//                                         if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
//                                         if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
//                                         if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
//                                         if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
//                                         if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
//                                         if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
//                                         if(isset($gst[$i]) && !empty($gst[$i])) {$gst_s = $gst[$i]; } else {$gst_s=0; }            
//                                         if(isset($gst_amount[$i]) && !empty($gst_amount[$i])) {$gst_amount_s = $gst_amount[$i]; } else {$gst_amount_s=0; }     
//                                         if(isset($proforma_from[$i]) && !empty($proforma_from[$i])) {$proforma_from_s = $proforma_from[$i]; } else {$proforma_from_s=0; }     
//                                         $gst_type_s = 'inter-state';
//                                         if(isset($proforma_itemid[$i]) && !empty($proforma_itemid[$i])) {$proforma_itemid_s = $proforma_itemid[$i]; } else {$proforma_itemid_s=0; }     
                                        
//                                         if(isset($boq_code_s) && !empty($boq_code_s)
//                                         && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
//                                         && isset($item_description_s) && !empty($item_description_s)
//                                         && isset($unit_s) && !empty($unit_s)
//                                         && isset($qty_s) && !empty($qty_s)
//                                         && isset($rate_s) && !empty($rate_s)
//                                         && isset($taxable_amount_s) && !empty($taxable_amount_s)
//                                         && isset($gst_s) && !empty($gst_s)
//                                         && isset($gst_type_s) && !empty($gst_type_s)
//                                         && isset($gst_amount_s) && !empty($gst_amount_s)){
//                                             if(isset($boq_code_s) && !empty($boq_code_s) && isset($project_id) && !empty($project_id)){
//                                                 $delete_boq_arr[] = $boq_code_s;
//                                                 $save_arr[] = array('proforma_id'=>$proforma_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
//                                                 'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s
//                                                 ,'gst'=>$gst_s,'taxable_amount'=>$taxable_amount_s,
//                                                 'gst_amount' => $gst_amount_s,'gst_type'=>$gst_type_s,'proforma_from'=>$proforma_from_s,
//                                                 'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));
//                                             }
//                                         }
//                                     }
//                                 }
//                             }
//                             if(isset($save_arr) && !empty($save_arr)){
//                                 if(isset($delete_boq_arr) && !empty($delete_boq_arr)){
//                                     $this->admin_model->deleteBOQProformaOldItemById($delete_boq_arr,$proforma_id);
//                                 }
//                                 if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
//                                 $main_arr = array('invoice_date'=>$invoice_date,
//                                 'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending',"auto_round_value"=>$auto_round_value,"auto_round_enable" => $auto_round_enable);
//                                 $this->common_model->updateDetails('tbl_proforma_invc', 'proforma_id', $proforma_id,$main_arr);
//                                 $this->common_model->SaveMultiData('tbl_proforma_invc_items',$save_arr);
//                                 $this->json->jsonReturn(array(
//                                     'valid'=>TRUE,
//                                     'msg'=>'<div class="alert modify alert-success">Perfoma Invoice Details Saved Successfully!</div>',
//                                     'redirect' => base_url().'create-proforma-invoice'
//                                 ));    
//                             }else{
//                                 $this->json->jsonReturn(array(
//                                     'valid'=>FALSE,
//                                     'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Proforma Invoice!!</div>'
//                                 ));    
//                             }
//                         }else{
//                             $this->json->jsonReturn(array(
//                                 'valid'=>FALSE,
//                                 'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
//                             ));
//                         }
//                     }

//                  }
//             }else{
//                 $this->json->jsonReturn(array(
//                     'valid'=>FALSE,
//                     'msg'=>'<div class="alert modify alert-danger">Invalid Proforma Invoice!</div>'
//                 ));    
//             }
//         }else{
//             $this->json->jsonReturn(array(
//                 'valid'=>FALSE,
//                 'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
//             ));    
//         }
//     }
    
    public function update_proforma_invoice_details() 
        {
           $auto_round_off_enable = $this->input->post('auto_round_off_enable')  != null &&  $this->input->post('auto_round_off_enable')  != "" ? $this->input->post('auto_round_off_enable')  != null : "No";
            $auto_round_off_type = $this->input->post('auto_round_off_type');
            $auto_round_off_value = $this->input->post('auto_round_off_value');
            $auto_round_value = 0 ;
            if($auto_round_off_value > 0){
                $auto_round_value = $auto_round_off_type == "Add" ? "+".$auto_round_off_value : "-".$auto_round_off_value;
            }
            $auto_round_enable = $auto_round_off_enable;

            $save_arr = array();
            $update_boq_stock_arr = array();
            $update_boq_stock_arr1 = array();
            $delete_boq_arr = array();
            $project_id = $this->input->post('project_id');
            $invoice_date = $this->input->post('invoice_date');
            $gst_type = $this->input->post('gst_type');
            $proforma_id = $this->input->post('update_proforma_id');
            if(isset($project_id) && !empty($project_id) && isset($invoice_date) && !empty($invoice_date)
              && isset($proforma_id) && !empty($proforma_id)){
                $proforma_invc = $this->common_model->selectDetailsWhr('tbl_proforma_invc','proforma_id',$proforma_id);
                if(isset($proforma_invc) && !empty($proforma_invc)){
                    if($gst_type == 'cgst_sgst'){
                        $error = 'N';
                        $error_message = '';
                        $user_id = $this->session->userdata('user_id');
                        if(isset($user_id) && empty($user_id)){
                        $error = 'Y';
                        $error_message = 'Please loggedin!';
                        }
                        if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
                        $boq_code = $this->input->post('proforma_boq_code_v');
                         if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                         if(isset($boq_code) && empty($boq_code)){
                          $error = 'Y';
                          $error_message = 'Please enter BOQ Sr No!';
                        }
                        $hsn_sac_code = $this->input->post('proforma_hsn_sac_code');
                        if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                        if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                        $error = 'Y';
                        $error_message = 'Please enter HSN/SAC Code!';
                        }
                        $item_description = $this->input->post('proforma_item_description');
                        if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                        if(isset($item_description) && empty($item_description)){
                        $error = 'Y';
                        $error_message = 'Please enter Item Description!';
                        }
                        $unit = $this->input->post('proforma_unit');
                        if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                        if(isset($unit) && empty($unit)){
                        $error = 'Y';
                        $error_message = 'Please enter Unit!';
                        }
                        $qty = $this->input->post('proforma_qty');
                        if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
                        if(isset($qty) && empty($qty)){
                        $error = 'Y';
                        $error_message = 'Please enter Qty!';
                        }
                        $rate = $this->input->post('proforma_rate');
                        if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
                        if(isset($rate) && empty($rate)){
                        $error = 'Y';
                        $error_message = 'Please enter Rate!';
                        }
                        $taxable_amount = $this->input->post('proforma_itaxable_amount');
                        if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
                        if(isset($taxable_amount) && empty($taxable_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter taxable amount!';
                        }

                        $sgst = $this->input->post('proforma_sgst');
                        if(isset($sgst) && !empty($sgst)) {$sgst = $sgst; } else {$sgst=''; }
                        if(isset($sgst) && empty($sgst)){
                        $error = 'Y';
                        $error_message = 'Please enter sgst!';
                        }
                        $cgst = $this->input->post('proforma_cgst');
                        if(isset($cgst) && !empty($cgst)) {$cgst = $cgst; } else {$cgst=''; }
                        if(isset($cgst) && empty($cgst)){
                        $error = 'Y';
                        $error_message = 'Please enter cgst!';
                        }
                        $cgst_amount = $this->input->post('proforma_cgst_amount');
                        if(isset($cgst_amount) && !empty($cgst_amount)) {$cgst_amount = $cgst_amount; } else {$cgst_amount=''; }
                        if(isset($cgst_amount) && empty($cgst_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter cgst amount!';
                        }
                        $sgst_amount = $this->input->post('proforma_sgst_amount');
                        if(isset($sgst_amount) && !empty($sgst_amount)) {$sgst_amount = $sgst_amount; } else {$sgst_amount=''; }
                        if(isset($sgst_amount) && empty($sgst_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter sgst amount!';
                        }
                        if(isset($boq_code) && empty($boq_code)
                        && isset($hsn_sac_code) && empty($hsn_sac_code)
                        && isset($item_description) && empty($item_description)
                        && isset($unit) && empty($unit)
                        && isset($qty) && empty($qty)
                        && isset($rate) && empty($rate)
                        && isset($taxable_amount) && empty($taxable_amount)
                        && isset($sgst) && empty($sgst)
                        && isset($cgst) && empty($cgst)
                        && isset($cgst_amount) && empty($cgst_amount)
                        && isset($sgst_amount) && empty($sgst_amount)){
                          $this->json->jsonReturn(array(
                              'valid'=>FALSE,
                              'msg'=>'<div class="alert modify alert-danger">Please Enter Proforma Invoice Details!!</div>'
                          ));    
                      }else{
                          if($error == 'N'){
                                $project_billing_type_value = $this->input->post('project_billing_type_value');
                                $billing_type_value = 0;
                                if($project_billing_type_value > 0){
                                    $billing_type_value = $project_billing_type_value;
                                }
                                $project_billing_type = $this->input->post('project_billing_type') != "" ? $this->input->post('project_billing_type') : "";
                                if(isset($boq_code) && !empty($boq_code)){
                                    if($proforma_id){
                                    $proforma_itemid = $this->input->post('proforma_itemid');
                                    $proforma_from = $this->input->post('proforma_from');
                                    for($i=0;$i<count($boq_code);$i++){
                                    if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                    if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                    if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                    if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                    if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
                                    if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
                                    if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
                                    if(isset($sgst[$i]) && !empty($sgst[$i])) {$sgst_s = $sgst[$i]; } else {$sgst_s=0; }            
                                    if(isset($cgst[$i]) && !empty($cgst[$i])) {$cgst_s = $cgst[$i]; } else {$cgst_s=0; }            
                                    if(isset($cgst_amount[$i]) && !empty($cgst_amount[$i])) {$cgst_amount_s = $cgst_amount[$i]; } else {$cgst_amount_s=0; }            
                                    if(isset($sgst_amount[$i]) && !empty($sgst_amount[$i])) {$sgst_amount_s = $sgst_amount[$i]; } else {$sgst_amount_s=0; }            
                                    if(isset($proforma_from[$i]) && !empty($proforma_from[$i])) {$proforma_from_s = $proforma_from[$i]; } else {$proforma_from_s=0; }            
                                    
                                    $gst_type_s = 'intra-state';
                                    if(isset($proforma_itemid[$i]) && !empty($proforma_itemid[$i])) {$proforma_itemid_s = $proforma_itemid[$i]; } else {$proforma_itemid_s=0; }            
                                    
                                    if(isset($boq_code_s) && !empty($boq_code_s)
                                    && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                    && isset($item_description_s) && !empty($item_description_s)
                                    && isset($unit_s) && !empty($unit_s)
                                    && isset($qty_s) && !empty($qty_s)
                                    && isset($rate_s) && !empty($rate_s)
                                    && isset($taxable_amount_s) && !empty($taxable_amount_s)
                                    && isset($cgst_s) && !empty($cgst_s)
                                    && isset($sgst_s) && !empty($sgst_s)
                                    && isset($cgst_amount_s) && !empty($cgst_amount_s)
                                    && isset($gst_type_s) && !empty($gst_type_s)
                                    && isset($sgst_amount_s) && !empty($sgst_amount_s)){
                                        if(isset($boq_code_s) && !empty($boq_code_s) && isset($project_id) && !empty($project_id)){
                                            $delete_boq_arr[] = $boq_code_s;
                                            $save_arr[] = array('proforma_id'=>$proforma_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                            'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s,'taxable_amount' =>$taxable_amount_s,'gst_type' => $gst_type_s,
                                            'sgst' => $sgst_s,'cgst' => $cgst_s,
                                            'sgst_amount' => $sgst_amount_s,'cgst_amount' => $cgst_amount_s,'proforma_from'=>$proforma_from_s,
                                            'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));
                                        }
                                    }
                                }
                                }
                                }

                            if(isset($save_arr) && !empty($save_arr)){
                                if(isset($delete_boq_arr) && !empty($delete_boq_arr)){
                                    $this->admin_model->deleteBOQProformaOldItemById($delete_boq_arr,$proforma_id);
                                }
                                if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
                                $main_arr = array('invoice_date'=>$invoice_date,
                                'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending','billing_type_value'=>$billing_type_value,'billing_type'=>$project_billing_type,"auto_round_value"=>$auto_round_value,"auto_round_enable" => $auto_round_enable);
                                $this->common_model->updateDetails('tbl_proforma_invc', 'proforma_id', $proforma_id,$main_arr);
                                $this->common_model->SaveMultiData('tbl_proforma_invc_items',$save_arr);

                                $this->json->jsonReturn(array(
                                    'valid'=>TRUE,
                                    'msg'=>'<div class="alert modify alert-success">Perfoma Invoice Details Saved Successfully!</div>',
                                    'redirect' => base_url().'create-proforma-invoice'
                                ));    
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Perfoma Invoice!!</div>'
                                ));    
                            }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                            ));
                          }
                        }
                    }else{
                        $error = 'N';
                        $error_message = '';
                        $user_id = $this->session->userdata('user_id');
                        if(isset($user_id) && empty($user_id)){
                        $error = 'Y';
                        $error_message = 'Please loggedin!';
                        }
                        $boq_code = $this->input->post('proforma_boq_code');
                        if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                        if(isset($boq_code) && empty($boq_code)){
                        $error = 'Y';
                        $error_message = 'Please enter BOQ Sr No!';
                        }
                        $hsn_sac_code = $this->input->post('proforma_hsn_sac_code');
                        if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                        if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                        $error = 'Y';
                        $error_message = 'Please enter HSN/SAC Code!';
                        }
                        $item_description = $this->input->post('proforma_item_description');
                        if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                        if(isset($item_description) && empty($item_description)){
                        $error = 'Y';
                        $error_message = 'Please enter Item Description!';
                        }
                        $unit = $this->input->post('proforma_unit');
                        if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                        if(isset($unit) && empty($unit)){
                        $error = 'Y';
                        $error_message = 'Please enter Unit!';
                        }
                        $qty = $this->input->post('proforma_qty');
                        if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
                        if(isset($qty) && empty($qty)){
                        $error = 'Y';
                        $error_message = 'Please enter Qty!';
                        }
                        $rate = $this->input->post('proforma_rate');
                        if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
                        if(isset($rate) && empty($rate)){
                        $error = 'Y';
                        $error_message = 'Please enter Rate!';
                        }
                        $taxable_amount = $this->input->post('proforma_itaxable_amount');
                        if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
                        if(isset($taxable_amount) && empty($taxable_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter taxable amount!';
                        }

                        $gst = $this->input->post('proforma_gst');
                        if(isset($gst) && !empty($gst)) {$gst = $gst; } else {$gst=''; }
                        if(isset($gst) && empty($gst)){
                        $error = 'Y';
                        $error_message = 'Please enter gst!';
                        }
                        $gst_amount = $this->input->post('proforma_itotal_amount');
                        if(isset($gst_amount) && !empty($gst_amount)) {$gst_amount = $gst_amount; } else {$gst_amount=''; }
                        if(isset($gst_amount) && empty($gst_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter gst amount!';
                        }

                        if(isset($boq_code) && empty($boq_code)
                        && isset($hsn_sac_code) && empty($hsn_sac_code)
                        && isset($item_description) && empty($item_description)
                        && isset($unit) && empty($unit)
                        && isset($qty) && empty($qty)
                        && isset($rate) && empty($rate)
                        && isset($taxable_amount) && empty($taxable_amount)
                        && isset($gst) && empty($gst)
                        && isset($gst_amount) && empty($gst_amount)
                        ){
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">Please Enter Proforma Invoice Details!!</div>'
                            ));    
                        }else{
                            if($error == 'N'){
                                if(isset($boq_code) && !empty($boq_code)){
                                    $main_arr = array('project_id'=>$project_id,'invoice_date'=>$invoice_date,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),
                                    'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending');
                                    if($proforma_id){
                                        $proforma_itemid = $this->input->post('proforma_itemid');
                                        $proforma_from = $this->input->post('proforma_from');
                                        for($i=0;$i<count($boq_code);$i++){
                                            if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                            if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                            if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                            if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                            if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
                                            if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
                                            if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
                                            if(isset($gst[$i]) && !empty($gst[$i])) {$gst_s = $gst[$i]; } else {$gst_s=0; }            
                                            if(isset($gst_amount[$i]) && !empty($gst_amount[$i])) {$gst_amount_s = $gst_amount[$i]; } else {$gst_amount_s=0; }     
                                            if(isset($proforma_from[$i]) && !empty($proforma_from[$i])) {$proforma_from_s = $proforma_from[$i]; } else {$proforma_from_s=0; }     
                                            $gst_type_s = 'inter-state';
                                            if(isset($proforma_itemid[$i]) && !empty($proforma_itemid[$i])) {$proforma_itemid_s = $proforma_itemid[$i]; } else {$proforma_itemid_s=0; }     
                                            
                                            if(isset($boq_code_s) && !empty($boq_code_s)
                                            && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                            && isset($item_description_s) && !empty($item_description_s)
                                            && isset($unit_s) && !empty($unit_s)
                                            && isset($qty_s) && !empty($qty_s)
                                            && isset($rate_s) && !empty($rate_s)
                                            && isset($taxable_amount_s) && !empty($taxable_amount_s)
                                            && isset($gst_s) && !empty($gst_s)
                                            && isset($gst_type_s) && !empty($gst_type_s)
                                            && isset($gst_amount_s) && !empty($gst_amount_s)){
                                                if(isset($boq_code_s) && !empty($boq_code_s) && isset($project_id) && !empty($project_id)){
                                                    $delete_boq_arr[] = $boq_code_s;
                                                    $save_arr[] = array('proforma_id'=>$proforma_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                                    'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s
                                                    ,'gst'=>$gst_s,'taxable_amount'=>$taxable_amount_s,
                                                    'gst_amount' => $gst_amount_s,'gst_type'=>$gst_type_s,'proforma_from'=>$proforma_from_s,
                                                    'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));
                                                }
                                            }
                                        }
                                    }
                                }
                                if(isset($save_arr) && !empty($save_arr)){
                                    if(isset($delete_boq_arr) && !empty($delete_boq_arr)){
                                        $this->admin_model->deleteBOQProformaOldItemById($delete_boq_arr,$proforma_id);
                                    }
                                    if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
                                    $main_arr = array('invoice_date'=>$invoice_date,
                                    'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending',"auto_round_value"=>$auto_round_value,"auto_round_enable" => $auto_round_enable);
                                    $this->common_model->updateDetails('tbl_proforma_invc', 'proforma_id', $proforma_id,$main_arr);
                                    $this->common_model->SaveMultiData('tbl_proforma_invc_items',$save_arr);
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE,
                                        'msg'=>'<div class="alert modify alert-success">Perfoma Invoice Details Saved Successfully!</div>',
                                        'redirect' => base_url().'create-proforma-invoice'
                                    ));    
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Proforma Invoice!!</div>'
                                    ));    
                                }
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                                ));
                            }
                        }

                     }
                }else{
                    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger">Invalid Proforma Invoice!</div>'
                    ));    
                }
            }else{
                $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
                ));    
            }
        }
    
    


// public function save_proforma_invoice_details() 
//         {
            
//             $auto_round_off_enable = $this->input->post('auto_round_off_enable')  != null &&  $this->input->post('auto_round_off_enable')  != "" ? $this->input->post('auto_round_off_enable')  != null : "No";
//             $auto_round_off_type = $this->input->post('auto_round_off_type');
//             $auto_round_off_value = $this->input->post('auto_round_off_value');
//             $auto_round_value = 0 ;
//             if($auto_round_off_value > 0){
//                 $auto_round_value = $auto_round_off_type == "Add" ? "+".$auto_round_off_value : "-".$auto_round_off_value;
//             }
//             $auto_round_enable = $auto_round_off_enable;
//             $loguser_id = $this->session->userData('user_id');
//             $logrole_id = $this->session->userData('role_id');
//             if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
//                 $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_proforma_invoice_details');
//                 if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
//                     $usubmenu_id = $submenu_datau->submenu_id;
//                     $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
//                     if(isset($check_permissionu) && !empty($check_permissionu)){
//                         $save_arr = array();
//                         $update_boq_stock_arr = array();
//                         $update_boq_stock_arr1 = array();

//                         $project_id = $this->input->post('project_id');
//                         //$proforma_no = $this->input->post('proforma_invoice_no');
//                         $getPrifixData = $this->common_model->getPrifixData('PROFORMA');
//                         if(isset($getPrifixData) && !empty($getPrifixData)){
//                             $prefix_name = $getPrifixData['prefix_name'];   
//                             $financial_year = $getPrifixData['financial_year'];   
//                         }else{
//                             $prefix_name = 'PRO';
//                             $financial_year = $this->getFinancialYear();
//                         }
//                         // $getLastFinancialYear = $this->common_model->getLastFinancialYear('PROFORMA');
//                         $proforma_inc = 1;
//                         $getLastInc = $this->common_model->getLastInc('PROFORMA');
//                         // if($getLastFinancialYear == $financial_year){
//                         //     if(isset($getLastInc) && !empty($getLastInc)){
//                         //         $proforma_inc = $getLastInc + 1;    
//                         //     }
//                         // }
//                          $proforma_inc = $getLastInc + 1; 
//                         if(strlen($proforma_inc) > 4){
//                             $proforma_no = $prefix_name.'-'.$proforma_inc.'/'.$financial_year;
//                         }else{
//                             $proforma_no = $prefix_name.'-'.sprintf('%02d',$proforma_inc).'/'.$financial_year;
//                         }
//                         $invoice_date = $this->input->post('invoice_date');
//                         $gst_type = $this->input->post('gst_type');
//                         $project_billing_type = $this->input->post('project_billing_type');
//                         if(isset($project_billing_type) && !empty($project_billing_type)) {$project_billing_type = $project_billing_type; } else {$project_billing_type=''; }
//                         // if(isset($project_billing_type) && empty($project_billing_type)){
//                         // $error = 'Y';
//                         // $error_message = 'Please Select Billing Type!';
//                         // }
//                         $project_billing_type_value = $this->input->post('project_billing_type_value');
//                                     $billing_type_value = 0;
//                                     if($project_billing_type_value > 0){
//                                         $billing_type_value = $project_billing_type_value;
//                                     }

//                         if(isset($project_id) && !empty($project_id) && isset($proforma_no) && !empty($proforma_no) && isset($invoice_date) && !empty($invoice_date)){
//                             $proforma_invc = $this->common_model->selectDetailsWhr('tbl_proforma_invc','proforma_no',$proforma_no);
//                             if(isset($proforma_invc) && empty($proforma_invc)){
//                                 if($gst_type == 'cgst_sgst'){
//                                     $error = 'N';
//                                     $error_message = '';
//                                     $user_id = $this->session->userdata('user_id');
//                                     if(isset($user_id) && empty($user_id)){
//                                     $error = 'Y';
//                                     $error_message = 'Please loggedin!';
//                                     }
//                                     $boq_code = $this->input->post('proforma_boq_code_v');
//                                      if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
//                                      if(isset($boq_code) && empty($boq_code)){
//                                       $error = 'Y';
//                                       $error_message = 'Please enter BOQ Sr No!';
//                                     }
//                                     $hsn_sac_code = $this->input->post('proforma_hsn_sac_code');
//                                     if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
//                                     if(isset($hsn_sac_code) && empty($hsn_sac_code)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter HSN/SAC Code!';
//                                     }
//                                     $item_description = $this->input->post('proforma_item_description');
//                                     if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
//                                     if(isset($item_description) && empty($item_description)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter Item Description!';
//                                     }
//                                     $unit = $this->input->post('proforma_unit');
//                                     if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
//                                     if(isset($unit) && empty($unit)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter Unit!';
//                                     }
//                                     $qty = $this->input->post('proforma_qty');
//                                     if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
//                                     if(isset($qty) && empty($qty)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter Qty!';
//                                     }
//                                     $rate = $this->input->post('proforma_rate');
//                                     if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
//                                     if(isset($rate) && empty($rate)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter Rate!';
//                                     }
//                                     $taxable_amount = $this->input->post('proforma_itaxable_amount');
//                                     if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
//                                     if(isset($taxable_amount) && empty($taxable_amount)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter taxable amount!';
//                                     }
                
//                                     $sgst = $this->input->post('proforma_sgst');
//                                     if(isset($sgst) && !empty($sgst)) {$sgst = $sgst; } else {$sgst=''; }
//                                     if(isset($sgst) && empty($sgst)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter sgst!';
//                                     }
//                                     $cgst = $this->input->post('proforma_cgst');
//                                     if(isset($cgst) && !empty($cgst)) {$cgst = $cgst; } else {$cgst=''; }
//                                     if(isset($cgst) && empty($cgst)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter cgst!';
//                                     }
//                                     $cgst_amount = $this->input->post('proforma_cgst_amount');
//                                     if(isset($cgst_amount) && !empty($cgst_amount)) {$cgst_amount = $cgst_amount; } else {$cgst_amount=''; }
//                                     if(isset($cgst_amount) && empty($cgst_amount)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter cgst amount!';
//                                     }
//                                     $sgst_amount = $this->input->post('proforma_sgst_amount');
//                                     if(isset($sgst_amount) && !empty($sgst_amount)) {$sgst_amount = $sgst_amount; } else {$sgst_amount=''; }
//                                     if(isset($sgst_amount) && empty($sgst_amount)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter sgst amount!';
//                                     }
//                                     $project_billing_type_value = $this->input->post('project_billing_type_value');
//                                     $billing_type_value = 0;
//                                     if($project_billing_type_value > 0){
//                                         $billing_type_value = $project_billing_type_value;
//                                     }
                                   
//                                     // if(isset($project_billing_type) && empty($project_billing_type)){
//                                     //     $this->json->jsonReturn(array(
//                                     //         'valid'=>FALSE,
//                                     //         'msg'=>'<div class="alert modify alert-danger">Please Select Billing Type!</div>'
//                                     //     )); 
//                                     // }else
//                                     if(isset($boq_code) && empty($boq_code)
//                                   && isset($hsn_sac_code) && empty($hsn_sac_code)
//                                   && isset($item_description) && empty($item_description)
//                                   && isset($unit) && empty($unit)
//                                   && isset($qty) && empty($qty)
//                                   && isset($rate) && empty($rate)
//                                   && isset($taxable_amount) && empty($taxable_amount)
//                                   && isset($sgst) && empty($sgst)
//                                   && isset($cgst) && empty($cgst)
//                                   && isset($cgst_amount) && empty($cgst_amount)
//                                   && isset($sgst_amount) && empty($sgst_amount))
//                                   {
//                                       $this->json->jsonReturn(array(
//                                           'valid'=>FALSE,
//                                           'msg'=>'<div class="alert modify alert-danger">Please Enter Proforma Invoice Details!!</div>'
//                                       ));    
//                                   }else{
//                                       if($error == 'N'){
//                                         if(isset($boq_code) && !empty($boq_code)){
//                                         if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
                                        
//                                         $event_name = 'Proforma Invoice';
//                                         $BOQTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,'exceptional_no'=>$proforma_no,
//                                         'exceptional_id'=>0,'event_type'=>'proforma_invc','created_date'=>date('Y-m-d H:i:s'),
//                                         'created_by'=>$user_id,'updated_by'=>$user_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending',
//                                         'approved_by'=>0,'approved_date'=>'');
//                                         $transaction_id = $this->common_model->addData('tbl_boq_transactions',$BOQTransArr);
//                                         if($transaction_id){
//                                         $main_arr = array('project_id'=>$project_id,'proforma_no'=>$proforma_no,'billing_type'=>$project_billing_type,'invoice_date'=>$invoice_date,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),
//                                         'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending','proforma_inc'=>$proforma_inc,
//                                         'transaction_id'=>$transaction_id,'billing_type_value'=>$billing_type_value,"auto_round_value"=>$auto_round_value,"auto_round_enable" => $auto_round_enable);
//                                         $tax_invc_id = $this->common_model->addData('tbl_proforma_invc',$main_arr);
//                                         $proforma_from = $this->input->post('proforma_from');
//                                         if($tax_invc_id){
//                                             for($i=0;$i<count($boq_code);$i++){
//                                                 if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
//                                                 if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
//                                                 if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
//                                                 if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
//                                                 if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
//                                                 if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
//                                                 if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
//                                                 if(isset($sgst[$i]) && !empty($sgst[$i])) {$sgst_s = $sgst[$i]; } else {$sgst_s=0; }            
//                                                 if(isset($cgst[$i]) && !empty($cgst[$i])) {$cgst_s = $cgst[$i]; } else {$cgst_s=0; }            
//                                                 if(isset($cgst_amount[$i]) && !empty($cgst_amount[$i])) {$cgst_amount_s = $cgst_amount[$i]; } else {$cgst_amount_s=0; }            
//                                                 if(isset($sgst_amount[$i]) && !empty($sgst_amount[$i])) {$sgst_amount_s = $sgst_amount[$i]; } else {$sgst_amount_s=0; }            
//                                                 if(isset($gst_type) && !empty($gst_type)) {$gst_type_s = 'intra-state'; } else {$gst_type_s= ''; }            
//                                                 if(isset($proforma_from[$i]) && !empty($proforma_from[$i])) {$proforma_from_s = $proforma_from[$i]; } else {$proforma_from_s=''; }            
                                                
//                                                 if(isset($boq_code_s) && !empty($boq_code_s)
//                                                 && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
//                                                 && isset($item_description_s) && !empty($item_description_s)
//                                                 && isset($unit_s) && !empty($unit_s)
//                                                 && isset($qty_s) && !empty($qty_s)
//                                                 && isset($rate_s) && !empty($rate_s)
//                                                 && isset($taxable_amount_s) && !empty($taxable_amount_s)
//                                                 && isset($cgst_s) && !empty($cgst_s)
//                                                 && isset($sgst_s) && !empty($sgst_s)
//                                                 && isset($cgst_amount_s) && !empty($cgst_amount_s)
//                                                 && isset($gst_type_s) && !empty($gst_type_s)
//                                                 && isset($sgst_amount_s) && !empty($sgst_amount_s)){
//                                                     $save_arr[] = array('proforma_id'=>$tax_invc_id,'proforma_from'=>$proforma_from_s,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
//                                                     'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s,'taxable_amount' =>$taxable_amount_s,'gst_type' => $gst_type_s,
//                                                     'sgst' => $sgst_s,'cgst' => $cgst_s,
//                                                     'sgst_amount' => $sgst_amount_s,'cgst_amount' => $cgst_amount_s,
//                                                     'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));   
//                                                 }
//                                             }
//                                         }
//                                         }
//                                     }
//                                     if(isset($save_arr) && !empty($save_arr)){
//                                         $this->common_model->SaveMultiData('tbl_proforma_invc_items',$save_arr);
//                                         $this->json->jsonReturn(array(
//                                             'valid'=>TRUE,
//                                             'msg'=>'<div class="alert modify alert-success">Perfoma Invoice Details Saved Successfully!</div>',
//                                             'redirect' => base_url().'create-proforma-invoice'
//                                         ));    
//                                     }else{
//                                         $this->json->jsonReturn(array(
//                                             'valid'=>FALSE,
//                                             'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Perfoma Invoice!!</div>'
//                                         ));    
//                                     }
//                                     }else{
//                                         $this->json->jsonReturn(array(
//                                             'valid'=>FALSE,
//                                             'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
//                                         ));
//                                       }
//                                     }
                
                
                    
                
//                                  }
//                                  else{
//                                     $error = 'N';
//                                     $error_message = '';
//                                     $user_id = $this->session->userdata('user_id');
//                                     if(isset($user_id) && empty($user_id)){
//                                     $error = 'Y';
//                                     $error_message = 'Please loggedin!';
//                                     }
//                                     $boq_code = $this->input->post('proforma_boq_code');
//                                     if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
//                                     if(isset($boq_code) && empty($boq_code)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter BOQ Sr No!';
//                                     }
//                                     $hsn_sac_code = $this->input->post('proforma_hsn_sac_code');
//                                     if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
//                                     if(isset($hsn_sac_code) && empty($hsn_sac_code)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter HSN/SAC Code!';
//                                     }
//                                     $item_description = $this->input->post('proforma_item_description');
//                                     if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
//                                     if(isset($item_description) && empty($item_description)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter Item Description!';
//                                     }
//                                     $unit = $this->input->post('proforma_unit');
//                                     if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
//                                     if(isset($unit) && empty($unit)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter Unit!';
//                                     }
//                                     $qty = $this->input->post('proforma_qty');
//                                     if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
//                                     if(isset($qty) && empty($qty)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter Qty!';
//                                     }
//                                     $rate = $this->input->post('proforma_rate');
//                                     if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
//                                     if(isset($rate) && empty($rate)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter Rate!';
//                                     }
//                                     $taxable_amount = $this->input->post('proforma_itaxable_amount');
//                                     if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
//                                     if(isset($taxable_amount) && empty($taxable_amount)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter taxable amount!';
//                                     }
                
//                                     $gst = $this->input->post('proforma_gst');
//                                     if(isset($gst) && !empty($gst)) {$gst = $gst; } else {$gst=''; }
//                                     if(isset($gst) && empty($gst)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter gst!';
//                                     }
//                                     $gst_amount = $this->input->post('proforma_itotal_amount');
//                                     if(isset($gst_amount) && !empty($gst_amount)) {$gst_amount = $gst_amount; } else {$gst_amount=''; }
//                                     if(isset($gst_amount) && empty($gst_amount)){
//                                     $error = 'Y';
//                                     $error_message = 'Please enter gst amount!';
//                                     }
                                    
                                    
//                                     $project_billing_type = $this->input->post('project_billing_type');
//                                     if(isset($project_billing_type) && !empty($project_billing_type)) {$project_billing_type = $project_billing_type; } else {$project_billing_type=''; }
//                                     if(isset($project_billing_type) && empty($project_billing_type)){
//                                     $error = 'Y';
//                                     $error_message = 'Please Select Billing Type!';
//                                     }
                
//                                     if(isset($boq_code) && empty($boq_code)
//                                     && isset($hsn_sac_code) && empty($hsn_sac_code)
//                                     && isset($item_description) && empty($item_description)
//                                     && isset($unit) && empty($unit)
//                                     && isset($qty) && empty($qty)
//                                     && isset($rate) && empty($rate)
//                                     && isset($taxable_amount) && empty($taxable_amount)
//                                     && isset($gst) && empty($gst)
//                                     && isset($gst_amount) && empty($gst_amount)
//                                     ){
//                                         $this->json->jsonReturn(array(
//                                             'valid'=>FALSE,
//                                             'msg'=>'<div class="alert modify alert-danger">Please Enter Proforma Invoice Details!!</div>'
//                                         ));    
//                                     }else{
//                                         if($error == 'N'){
//                                             if(isset($boq_code) && !empty($boq_code)){
//                                               if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
//                                                  $main_arr = array('project_id'=>$project_id,'proforma_no'=>$proforma_no,'billing_type'=>$project_billing_type,'billing_type_value'=>$billing_type_value,'invoice_date'=>$invoice_date,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),
//                                                 'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending','proforma_inc'=>$proforma_inc,"auto_round_value"=>$auto_round_value,"auto_round_enable" => $auto_round_enable);
//                                                 $tax_invc_id = $this->common_model->addData('tbl_proforma_invc',$main_arr);
//                                                 if($tax_invc_id){
//                                                     $proforma_from = $this->input->post('proforma_from');
//                                                     for($i=0;$i<count($boq_code);$i++){
//                                                         if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
//                                                         if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
//                                                         if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
//                                                         if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
//                                                         if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
//                                                         if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
//                                                         if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
//                                                         if(isset($gst[$i]) && !empty($gst[$i])) {$gst_s = $gst[$i]; } else {$gst_s=0; }            
//                                                         if(isset($gst_amount[$i]) && !empty($gst_amount[$i])) {$gst_amount_s = $gst_amount[$i]; } else {$gst_amount_s=0; }     
//                                                         if(isset($gst_type) && !empty($gst_type)) {$gst_type_s = 'inter-state'; } else {$gst_type_s= ''; }         
//                                                         if(isset($proforma_from[$i]) && !empty($proforma_from[$i])) {$proforma_from_s = $proforma_from[$i]; } else {$proforma_from_s=0; }     
                                                        
//                                                         if(isset($boq_code_s) && !empty($boq_code_s)
//                                                         && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
//                                                         && isset($item_description_s) && !empty($item_description_s)
//                                                         && isset($unit_s) && !empty($unit_s)
//                                                         && isset($qty_s) && !empty($qty_s)
//                                                         && isset($rate_s) && !empty($rate_s)
//                                                         && isset($taxable_amount_s) && !empty($taxable_amount_s)
//                                                         && isset($gst_s) && !empty($gst_s)
//                                                         && isset($gst_type_s) && !empty($gst_type_s)
//                                                         && isset($gst_amount_s) && !empty($gst_amount_s)){
//                                                             $save_arr[] = array('proforma_id'=>$tax_invc_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
//                                                             'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s
//                                                             ,'gst'=>$gst_s,'taxable_amount'=>$taxable_amount_s,
//                                                             'gst_amount' => $gst_amount_s,'gst_type'=>$gst_type_s,'proforma_from'=>$proforma_from_s,
//                                                             'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));
//                                                         }
//                                                     }
//                                                 }
//                                             }
//                                             if(isset($save_arr) && !empty($save_arr)){
//                                                 $this->common_model->SaveMultiData('tbl_proforma_invc_items',$save_arr);
//                                                 $this->json->jsonReturn(array(
//                                                     'valid'=>TRUE,
//                                                     'msg'=>'<div class="alert modify alert-success">Perfoma Invoice Details Saved Successfully!</div>',
//                                                     'redirect' => base_url().'create-proforma-invoice'
//                                                 ));    
//                                             }else{
//                                                 $this->json->jsonReturn(array(
//                                                     'valid'=>FALSE,
//                                                     'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Proforma Invoice!!</div>'
//                                                 ));    
//                                             }
//                                         }else{
//                                             $this->json->jsonReturn(array(
//                                                 'valid'=>FALSE,
//                                                 'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
//                                             ));
//                                         }
//                                     }
                
//                                  }
//                         }else{
//                             $this->json->jsonReturn(array(
//                                 'valid'=>FALSE,
//                                 'msg'=>'<div class="alert modify alert-danger">Proforma Invoice no already exist!</div>'
//                             ));    
//                         }
//                         }else{
//                             $this->json->jsonReturn(array(
//                                 'valid'=>FALSE,
//                                 'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
//                             ));    
//                         }
//                     }else{
//                         $this->json->jsonReturn(array(
//                             'valid'=>FALSE,
//                             'msg'=>'<div class="alert modify alert-danger">You have no Permission!!</div>'
//                         ));    
//                     }
//                 }else{
//                     $this->json->jsonReturn(array(
//                         'valid'=>FALSE,
//                         'msg'=>'<div class="alert modify alert-danger">You have no Permission!!</div>'
//                     )); 
//                 }
//             }else{
//                 $this->json->jsonReturn(array(
//                     'valid'=>FALSE,
//                     'msg'=>'<div class="alert modify alert-danger">You have no Permission!!</div>'
//                 )); 
//             }
            
//         }



        public function save_proforma_invoice_details() 
        {
            
            $auto_round_off_enable = $this->input->post('auto_round_off_enable')  != null &&  $this->input->post('auto_round_off_enable')  != "" ? $this->input->post('auto_round_off_enable')  != null : "No";
            $auto_round_off_type = $this->input->post('auto_round_off_type');
            $auto_round_off_value = $this->input->post('auto_round_off_value');
            $auto_round_value = 0 ;
            if($auto_round_off_value > 0){
                $auto_round_value = $auto_round_off_type == "Add" ? "+".$auto_round_off_value : "-".$auto_round_off_value;
            }
            $auto_round_enable = $auto_round_off_enable;
            $loguser_id = $this->session->userData('user_id');
            $logrole_id = $this->session->userData('role_id');
            if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
                $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_proforma_invoice_details');
                if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                    $usubmenu_id = $submenu_datau->submenu_id;
                    $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                    if(isset($check_permissionu) && !empty($check_permissionu)){
                        $save_arr = array();
                        $update_boq_stock_arr = array();
                        $update_boq_stock_arr1 = array();

                        $project_id = $this->input->post('project_id');
                        //$proforma_no = $this->input->post('proforma_invoice_no');
                        $getPrifixData = $this->common_model->getPrifixData('PROFORMA');
                        if(isset($getPrifixData) && !empty($getPrifixData)){
                            $prefix_name = $getPrifixData['prefix_name'];   
                            $financial_year = $getPrifixData['financial_year'];   
                        }else{
                            $prefix_name = 'PRO';
                            $financial_year = $this->getFinancialYear();
                        }
                        // $getLastFinancialYear = $this->common_model->getLastFinancialYear('PROFORMA');
                        $proforma_inc = 1;
                        $getLastInc = $this->common_model->getLastInc('PROFORMA');
                        // if($getLastFinancialYear == $financial_year){
                        //     if(isset($getLastInc) && !empty($getLastInc)){
                        //         $proforma_inc = $getLastInc + 1;    
                        //     }
                        // }
                         $proforma_inc = $getLastInc + 1; 
                        if(strlen($proforma_inc) > 4){
                            $proforma_no = $prefix_name.'-'.$proforma_inc.'/'.$financial_year;
                        }else{
                            $proforma_no = $prefix_name.'-'.sprintf('%02d',$proforma_inc).'/'.$financial_year;
                        }
                        $invoice_date = $this->input->post('invoice_date');
                        $gst_type = $this->input->post('gst_type');
                        $project_billing_type = $this->input->post('project_billing_type');
                        if(isset($project_billing_type) && !empty($project_billing_type)) {$project_billing_type = $project_billing_type; } else {$project_billing_type=''; }
                        // if(isset($project_billing_type) && empty($project_billing_type)){
                        // $error = 'Y';
                        // $error_message = 'Please Select Billing Type!';
                        // }
                        $project_billing_type_value = $this->input->post('project_billing_type_value');
                                    $billing_type_value = 0;
                                    if($project_billing_type_value > 0){
                                        $billing_type_value = $project_billing_type_value;
                                    }

                        if(isset($project_id) && !empty($project_id) && isset($proforma_no) && !empty($proforma_no) && isset($invoice_date) && !empty($invoice_date)){
                            $proforma_invc = $this->common_model->selectDetailsWhr('tbl_proforma_invc','proforma_no',$proforma_no);
                            if(isset($proforma_invc) && empty($proforma_invc)){
                                if($gst_type == 'cgst_sgst'){
                                    $error = 'N';
                                    $error_message = '';
                                    $user_id = $this->session->userdata('user_id');
                                    if(isset($user_id) && empty($user_id)){
                                    $error = 'Y';
                                    $error_message = 'Please loggedin!';
                                    }
                                    $boq_code = $this->input->post('proforma_boq_code_v');
                                     if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                                     if(isset($boq_code) && empty($boq_code)){
                                      $error = 'Y';
                                      $error_message = 'Please enter BOQ Sr No!';
                                    }
                                    $hsn_sac_code = $this->input->post('proforma_hsn_sac_code');
                                    if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                                    if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                                    $error = 'Y';
                                    $error_message = 'Please enter HSN/SAC Code!';
                                    }
                                    $item_description = $this->input->post('proforma_item_description');
                                    if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                                    if(isset($item_description) && empty($item_description)){
                                    $error = 'Y';
                                    $error_message = 'Please enter Item Description!';
                                    }
                                    $unit = $this->input->post('proforma_unit');
                                    if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                                    if(isset($unit) && empty($unit)){
                                    $error = 'Y';
                                    $error_message = 'Please enter Unit!';
                                    }
                                    $qty = $this->input->post('proforma_qty');
                                    if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
                                    if(isset($qty) && empty($qty)){
                                    $error = 'Y';
                                    $error_message = 'Please enter Qty!';
                                    }
                                    $rate = $this->input->post('proforma_rate');
                                    if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
                                    if(isset($rate) && empty($rate)){
                                    $error = 'Y';
                                    $error_message = 'Please enter Rate!';
                                    }
                                    $taxable_amount = $this->input->post('proforma_itaxable_amount');
                                    if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
                                    if(isset($taxable_amount) && empty($taxable_amount)){
                                    $error = 'Y';
                                    $error_message = 'Please enter taxable amount!';
                                    }
                
                                    $sgst = $this->input->post('proforma_sgst');
                                    if(isset($sgst) && !empty($sgst)) {$sgst = $sgst; } else {$sgst=''; }
                                    if(isset($sgst) && empty($sgst)){
                                    $error = 'Y';
                                    $error_message = 'Please enter sgst!';
                                    }
                                    $cgst = $this->input->post('proforma_cgst');
                                    if(isset($cgst) && !empty($cgst)) {$cgst = $cgst; } else {$cgst=''; }
                                    if(isset($cgst) && empty($cgst)){
                                    $error = 'Y';
                                    $error_message = 'Please enter cgst!';
                                    }
                                    $cgst_amount = $this->input->post('proforma_cgst_amount');
                                    if(isset($cgst_amount) && !empty($cgst_amount)) {$cgst_amount = $cgst_amount; } else {$cgst_amount=''; }
                                    if(isset($cgst_amount) && empty($cgst_amount)){
                                    $error = 'Y';
                                    $error_message = 'Please enter cgst amount!';
                                    }
                                    $sgst_amount = $this->input->post('proforma_sgst_amount');
                                    if(isset($sgst_amount) && !empty($sgst_amount)) {$sgst_amount = $sgst_amount; } else {$sgst_amount=''; }
                                    if(isset($sgst_amount) && empty($sgst_amount)){
                                    $error = 'Y';
                                    $error_message = 'Please enter sgst amount!';
                                    }
                                    $project_billing_type_value = $this->input->post('project_billing_type_value');
                                    $billing_type_value = 0;
                                    if($project_billing_type_value > 0){
                                        $billing_type_value = $project_billing_type_value;
                                    }
                                   
                                    // if(isset($project_billing_type) && empty($project_billing_type)){
                                    //     $this->json->jsonReturn(array(
                                    //         'valid'=>FALSE,
                                    //         'msg'=>'<div class="alert modify alert-danger">Please Select Billing Type!</div>'
                                    //     )); 
                                    // }else
                                    if(isset($boq_code) && empty($boq_code)
                                  && isset($hsn_sac_code) && empty($hsn_sac_code)
                                  && isset($item_description) && empty($item_description)
                                  && isset($unit) && empty($unit)
                                  && isset($qty) && empty($qty)
                                  && isset($rate) && empty($rate)
                                  && isset($taxable_amount) && empty($taxable_amount)
                                  && isset($sgst) && empty($sgst)
                                  && isset($cgst) && empty($cgst)
                                  && isset($cgst_amount) && empty($cgst_amount)
                                  && isset($sgst_amount) && empty($sgst_amount))
                                  {
                                      $this->json->jsonReturn(array(
                                          'valid'=>FALSE,
                                          'msg'=>'<div class="alert modify alert-danger">Please Enter Proforma Invoice Details!!</div>'
                                      ));    
                                  }else{
                                      if($error == 'N'){
                                        if(isset($boq_code) && !empty($boq_code)){
                                        if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
                                        
                                        $event_name = 'Proforma Invoice';
                                        $BOQTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,'exceptional_no'=>$proforma_no,
                                        'exceptional_id'=>0,'event_type'=>'proforma_invc','created_date'=>date('Y-m-d H:i:s'),
                                        'created_by'=>$user_id,'updated_by'=>$user_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending',
                                        'approved_by'=>0,'approved_date'=>'');
                                        $transaction_id = $this->common_model->addData('tbl_boq_transactions',$BOQTransArr);
                                        if($transaction_id){
                                        $main_arr = array('project_id'=>$project_id,'proforma_no'=>$proforma_no,'billing_type'=>$project_billing_type,'invoice_date'=>$invoice_date,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),
                                        'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending','proforma_inc'=>$proforma_inc,
                                        'transaction_id'=>$transaction_id,'billing_type_value'=>$billing_type_value,"auto_round_value"=>$auto_round_value,"auto_round_enable" => $auto_round_enable);
                                        $tax_invc_id = $this->common_model->addData('tbl_proforma_invc',$main_arr);
                                        $proforma_from = $this->input->post('proforma_from');
                                        if($tax_invc_id){
                                            for($i=0;$i<count($boq_code);$i++){
                                                if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                                if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                                if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                                if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                                if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
                                                if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
                                                if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
                                                if(isset($sgst[$i]) && !empty($sgst[$i])) {$sgst_s = $sgst[$i]; } else {$sgst_s=0; }            
                                                if(isset($cgst[$i]) && !empty($cgst[$i])) {$cgst_s = $cgst[$i]; } else {$cgst_s=0; }            
                                                if(isset($cgst_amount[$i]) && !empty($cgst_amount[$i])) {$cgst_amount_s = $cgst_amount[$i]; } else {$cgst_amount_s=0; }            
                                                if(isset($sgst_amount[$i]) && !empty($sgst_amount[$i])) {$sgst_amount_s = $sgst_amount[$i]; } else {$sgst_amount_s=0; }            
                                                if(isset($gst_type) && !empty($gst_type)) {$gst_type_s = 'intra-state'; } else {$gst_type_s= ''; }            
                                                if(isset($proforma_from[$i]) && !empty($proforma_from[$i])) {$proforma_from_s = $proforma_from[$i]; } else {$proforma_from_s=''; }            
                                                
                                                if(isset($boq_code_s) && !empty($boq_code_s)
                                                && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                                && isset($item_description_s) && !empty($item_description_s)
                                                && isset($unit_s) && !empty($unit_s)
                                                && isset($qty_s) && !empty($qty_s)
                                                && isset($rate_s) && !empty($rate_s)
                                                && isset($taxable_amount_s) && !empty($taxable_amount_s)
                                                && isset($cgst_s) && !empty($cgst_s)
                                                && isset($sgst_s) && !empty($sgst_s)
                                                && isset($cgst_amount_s) && !empty($cgst_amount_s)
                                                && isset($gst_type_s) && !empty($gst_type_s)
                                                && isset($sgst_amount_s) && !empty($sgst_amount_s)){
                                                    $save_arr[] = array('proforma_id'=>$tax_invc_id,'proforma_from'=>$proforma_from_s,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                                    'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s,'taxable_amount' =>$taxable_amount_s,'gst_type' => $gst_type_s,
                                                    'sgst' => $sgst_s,'cgst' => $cgst_s,
                                                    'sgst_amount' => $sgst_amount_s,'cgst_amount' => $cgst_amount_s,
                                                    'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));   
                                                }
                                            }
                                        }
                                        }
                                    }
                                    if(isset($save_arr) && !empty($save_arr)){
                                        $this->common_model->SaveMultiData('tbl_proforma_invc_items',$save_arr);
                                        $this->json->jsonReturn(array(
                                            'valid'=>TRUE,
                                            'msg'=>'<div class="alert modify alert-success">Perfoma Invoice Details Saved Successfully!</div>',
                                            'redirect' => base_url().'create-proforma-invoice'
                                        ));    
                                    }else{
                                        $this->json->jsonReturn(array(
                                            'valid'=>FALSE,
                                            'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Perfoma Invoice!!</div>'
                                        ));    
                                    }
                                    }else{
                                        $this->json->jsonReturn(array(
                                            'valid'=>FALSE,
                                            'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                                        ));
                                      }
                                    }
                
                
                    
                
                                 }
                                 else{
                                    $error = 'N';
                                    $error_message = '';
                                    $user_id = $this->session->userdata('user_id');
                                    if(isset($user_id) && empty($user_id)){
                                    $error = 'Y';
                                    $error_message = 'Please loggedin!';
                                    }
                                    $boq_code = $this->input->post('proforma_boq_code');
                                    if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                                    if(isset($boq_code) && empty($boq_code)){
                                    $error = 'Y';
                                    $error_message = 'Please enter BOQ Sr No!';
                                    }
                                    $hsn_sac_code = $this->input->post('proforma_hsn_sac_code');
                                    if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                                    if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                                    $error = 'Y';
                                    $error_message = 'Please enter HSN/SAC Code!';
                                    }
                                    $item_description = $this->input->post('proforma_item_description');
                                    if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                                    if(isset($item_description) && empty($item_description)){
                                    $error = 'Y';
                                    $error_message = 'Please enter Item Description!';
                                    }
                                    $unit = $this->input->post('proforma_unit');
                                    if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                                    if(isset($unit) && empty($unit)){
                                    $error = 'Y';
                                    $error_message = 'Please enter Unit!';
                                    }
                                    $qty = $this->input->post('proforma_qty');
                                    if(isset($qty) && !empty($qty)) {$qty = $qty; } else {$qty=''; }
                                    if(isset($qty) && empty($qty)){
                                    $error = 'Y';
                                    $error_message = 'Please enter Qty!';
                                    }
                                    $rate = $this->input->post('proforma_rate');
                                    if(isset($rate) && !empty($rate)) {$rate = $rate; } else {$rate=''; }
                                    if(isset($rate) && empty($rate)){
                                    $error = 'Y';
                                    $error_message = 'Please enter Rate!';
                                    }
                                    $taxable_amount = $this->input->post('proforma_itaxable_amount');
                                    if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount = $taxable_amount; } else {$taxable_amount=''; }
                                    if(isset($taxable_amount) && empty($taxable_amount)){
                                    $error = 'Y';
                                    $error_message = 'Please enter taxable amount!';
                                    }
                
                                    $gst = $this->input->post('proforma_gst');
                                    if(isset($gst) && !empty($gst)) {$gst = $gst; } else {$gst=''; }
                                    if(isset($gst) && empty($gst)){
                                    $error = 'Y';
                                    $error_message = 'Please enter gst!';
                                    }
                                    $gst_amount = $this->input->post('proforma_itotal_amount');
                                    if(isset($gst_amount) && !empty($gst_amount)) {$gst_amount = $gst_amount; } else {$gst_amount=''; }
                                    if(isset($gst_amount) && empty($gst_amount)){
                                    $error = 'Y';
                                    $error_message = 'Please enter gst amount!';
                                    }
                                    
                                    $project_data=$this->common_model->selectDetailsWhr('tbl_projects','project_id',$project_id);
                                    
                                    $project_billing_type = $this->input->post('project_billing_type');
                                    if(isset($project_billing_type) && !empty($project_billing_type)) {$project_billing_type = $project_billing_type; } else {$project_billing_type=''; }
                                    if(isset($project_billing_type) && empty($project_billing_type) && $project_data->payment_terms == "SITC"){
                                    $error = 'Y';
                                    $error_message = 'Please Select Billing Type!';
                                    }
                
                                    if(isset($boq_code) && empty($boq_code)
                                    && isset($hsn_sac_code) && empty($hsn_sac_code)
                                    && isset($item_description) && empty($item_description)
                                    && isset($unit) && empty($unit)
                                    && isset($qty) && empty($qty)
                                    && isset($rate) && empty($rate)
                                    && isset($taxable_amount) && empty($taxable_amount)
                                    && isset($gst) && empty($gst)
                                    && isset($gst_amount) && empty($gst_amount)
                                    ){
                                        $this->json->jsonReturn(array(
                                            'valid'=>FALSE,
                                            'msg'=>'<div class="alert modify alert-danger">Please Enter Proforma Invoice Details!!</div>'
                                        ));    
                                    }else{
                                        if($error == 'N'){
                                            if(isset($boq_code) && !empty($boq_code)){
                                               if(isset($invoice_date) && !empty($invoice_date)) {$invoice_date = date('Y-m-d',strtotime($invoice_date)); } else {$invoice_date=''; }
                                                 $main_arr = array('project_id'=>$project_id,'proforma_no'=>$proforma_no,'billing_type'=>$project_billing_type,'billing_type_value'=>$billing_type_value,'invoice_date'=>$invoice_date,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),
                                                'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending','proforma_inc'=>$proforma_inc,"auto_round_value"=>$auto_round_value,"auto_round_enable" => $auto_round_enable);
                                                $tax_invc_id = $this->common_model->addData('tbl_proforma_invc',$main_arr);
                                                if($tax_invc_id){
                                                    $proforma_from = $this->input->post('proforma_from');
                                                    for($i=0;$i<count($boq_code);$i++){
                                                        if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                                        if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                                        if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                                        if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                                        if(isset($qty[$i]) && !empty($qty[$i])) {$qty_s = $qty[$i]; } else {$qty_s=0; }            
                                                        if(isset($rate[$i]) && !empty($rate[$i])) {$rate_s = $rate[$i]; } else {$rate_s=0; }            
                                                        if(isset($taxable_amount[$i]) && !empty($taxable_amount[$i])) {$taxable_amount_s = $taxable_amount[$i]; } else {$taxable_amount_s=0; }            
                                                        if(isset($gst[$i]) && !empty($gst[$i])) {$gst_s = $gst[$i]; } else {$gst_s=0; }            
                                                        if(isset($gst_amount[$i]) && !empty($gst_amount[$i])) {$gst_amount_s = $gst_amount[$i]; } else {$gst_amount_s=0; }     
                                                        if(isset($gst_type) && !empty($gst_type)) {$gst_type_s = 'inter-state'; } else {$gst_type_s= ''; }         
                                                        if(isset($proforma_from[$i]) && !empty($proforma_from[$i])) {$proforma_from_s = $proforma_from[$i]; } else {$proforma_from_s=0; }     
                                                        
                                                        if(isset($boq_code_s) && !empty($boq_code_s)
                                                        && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                                        && isset($item_description_s) && !empty($item_description_s)
                                                        && isset($unit_s) && !empty($unit_s)
                                                        && isset($qty_s) && !empty($qty_s)
                                                        && isset($rate_s) && !empty($rate_s)
                                                        && isset($taxable_amount_s) && !empty($taxable_amount_s)
                                                        && isset($gst_s) && !empty($gst_s)
                                                        && isset($gst_type_s) && !empty($gst_type_s)
                                                        && isset($gst_amount_s) && !empty($gst_amount_s)){
                                                            $save_arr[] = array('proforma_id'=>$tax_invc_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                                            'unit'=>$unit_s,'qty'=>$qty_s,'rate'=>$rate_s
                                                            ,'gst'=>$gst_s,'taxable_amount'=>$taxable_amount_s,
                                                            'gst_amount' => $gst_amount_s,'gst_type'=>$gst_type_s,'proforma_from'=>$proforma_from_s,
                                                            'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));
                                                        }
                                                    }
                                                }
                                            }
                                            if(isset($save_arr) && !empty($save_arr)){
                                                $this->common_model->SaveMultiData('tbl_proforma_invc_items',$save_arr);
                                                $this->json->jsonReturn(array(
                                                    'valid'=>TRUE,
                                                    'msg'=>'<div class="alert modify alert-success">Perfoma Invoice Details Saved Successfully!</div>',
                                                    'redirect' => base_url().'create-proforma-invoice'
                                                ));    
                                            }else{
                                                $this->json->jsonReturn(array(
                                                    'valid'=>FALSE,
                                                    'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Proforma Invoice!!</div>'
                                                ));    
                                            }
                                        }else{
                                            $this->json->jsonReturn(array(
                                                'valid'=>FALSE,
                                                'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                                            ));
                                        }
                                    }
                
                                 }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">Proforma Invoice no already exist!</div>'
                            ));    
                        }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
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
            }else{
                $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger">You have no Permission!!</div>'
                )); 
            }
            
        }

    public function update_provisional_wip_details() 
    {
        $save_arr = array();
        $save_boq_stock_arr = array();
        $update_boq_stock_arr = array();
        $delete_boq_arr = array();
        $project_id = $this->input->post('project_id');
        $update_p_wip_id = $this->input->post('update_p_wip_id');
        if(isset($project_id) && !empty($project_id) && isset($update_p_wip_id) && !empty($update_p_wip_id)){
                $prov_wip = $this->common_model->selectDetailsWhr('tbl_provisional_wip','p_wip_id',$update_p_wip_id);
                if(isset($prov_wip) && !empty($prov_wip)){
                    $error = 'N';
                    $error_message = '';
                    $user_id = $this->session->userdata('user_id');
                    if(isset($user_id) && empty($user_id)){
                    $error = 'Y';
                    $error_message = 'Please loggedin!';
                    }
                    $boq_code = $this->input->post('boq_code');
                    if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                    if(isset($boq_code) && empty($boq_code)){
                    $error = 'Y';
                    $error_message = 'Please enter BOQ Sr No!';
                    }
                    $hsn_sac_code = $this->input->post('hsn_sac_code');
                    if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                    if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                    $error = 'Y';
                    $error_message = 'Please enter HSN/SAC Code!';
                    }
                    $item_description = $this->input->post('item_description');
                    if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                    if(isset($item_description) && empty($item_description)){
                    $error = 'Y';
                    $error_message = 'Please enter Item Description!';
                    }
                    $unit = $this->input->post('unit');
                    if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                    if(isset($unit) && empty($unit)){
                    $error = 'Y';
                    $error_message = 'Please enter Unit!';
                    }
                    $avl_qty = $this->input->post('avl_qty');
                    if(isset($avl_qty) && !empty($avl_qty)) {$avl_qty = $avl_qty; } else {$avl_qty=''; }
                    if(isset($avl_qty) && empty($avl_qty)){
                    $error = 'Y';
                    $error_message = 'Please enter Avl Qty!';
                    }
                    $prov_qty = $this->input->post('prov_qty');
                    if(isset($prov_qty) && !empty($prov_qty)) {$prov_qty = $prov_qty; } else {$prov_qty=''; }
                    if(isset($prov_qty) && empty($prov_qty)){
                    $error = 'Y';
                    $error_message = 'Please enter Provisional Qty!';
                    }
                    if(isset($boq_code) && empty($boq_code)
                    && isset($hsn_sac_code) && empty($hsn_sac_code)
                    && isset($item_description) && empty($item_description)
                    && isset($unit) && empty($unit)
                    && isset($avl_qty) && empty($avl_qty)
                    && isset($prov_qty) && empty($prov_qty)){
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">Please Enter Provisional WIP Details!!</div>'
                        ));    
                    }else{
                        if($error == 'N'){
                            if(isset($boq_code) && !empty($boq_code)){
                                if($update_p_wip_id){
                                    for($i=0;$i<count($boq_code);$i++){
                                        $rate_basic = $this->input->post('rate_basic');
                                        if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                        if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                        if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                        if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                        if(isset($avl_qty[$i]) && !empty($avl_qty[$i]) && $avl_qty[$i] > 0) {$avl_qty_s = $avl_qty[$i]; } else {$avl_qty_s='0'; }            
                                        if(isset($prov_qty[$i]) && !empty($prov_qty[$i]) && $prov_qty[$i] > 0) {$prov_qty_s = $prov_qty[$i]; } else {$prov_qty_s='0'; }            
                                        if(isset($rate_basic[$i]) && !empty($rate_basic[$i]) && $rate_basic[$i] > 0) {$rate_basic_s = $rate_basic[$i]; } else {$rate_basic_s='0'; }            
                                        
                                        if(isset($boq_code_s) && !empty($boq_code_s)
                                        && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                        && isset($item_description_s) && !empty($item_description_s)
                                        && isset($unit_s) && !empty($unit_s)
                                        && isset($avl_qty_s) && !empty($avl_qty_s)
                                        && isset($prov_qty_s) && !empty($prov_qty_s)){
                                            if(isset($project_id) && !empty($project_id) && isset($boq_code_s) && !empty($boq_code_s)){
                                                $delete_boq_arr[] = $boq_code_s;
                                                $save_arr[] = array('p_wip_id'=>$update_p_wip_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                                'unit'=>$unit_s,'avl_qty'=>$avl_qty_s,'prov_qty'=>$prov_qty_s,'rate_basic'=>$rate_basic_s,
                                                'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));    
                                            }
                                        }
                                    }
                                }
                            }
                            if(isset($save_arr) && !empty($save_arr)){
                                if(isset($delete_boq_arr) && !empty($delete_boq_arr)){
                                   $this->admin_model->deleteBOQProvWIPOldItemById($delete_boq_arr,$update_p_wip_id);
                                }
                                $main_arr = array('modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),
                                'display'=>'Y','status'=>'pending');
                                $this->common_model->updateDetails('tbl_provisional_wip', 'p_wip_id', $update_p_wip_id,$main_arr);
                                $this->common_model->SaveMultiData('tbl_prov_wip_items',$save_arr);
                                $this->json->jsonReturn(array(
                                    'valid'=>TRUE,
                                    'msg'=>'<div class="alert modify alert-success">Provisional WIP Details Saved Successfully!</div>',
                                    'redirect' => base_url().'add-provisional-wip'
                                ));    
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Provisional WIP!!</div>'
                                ));    
                            }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                            ));
                        }
                    }
                }else{
                    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger">Invalid Provisional WIP!</div>'
                    ));    
                }
            
        }else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
            ));    
        }
    }
    public function update_installed_wip_details() 
    {
        $save_arr = array();
        $save_boq_stock_arr = array();
        $update_boq_stock_arr = array();
        $delete_boq_arr = array();
        $project_id = $this->input->post('project_id');
        $update_i_wip_id = $this->input->post('update_i_wip_id');
        if(isset($project_id) && !empty($project_id) && isset($update_i_wip_id) && !empty($update_i_wip_id)){
                $installed_wip = $this->common_model->selectDetailsWhr('tbl_installed_wip','i_wip_id',$update_i_wip_id);
                if(isset($installed_wip) && !empty($installed_wip)){
                    $error = 'N';
                    $error_message = '';
                    $user_id = $this->session->userdata('user_id');
                    if(isset($user_id) && empty($user_id)){
                    $error = 'Y';
                    $error_message = 'Please loggedin!';
                    }
                    $boq_code = $this->input->post('boq_code');
                    if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                    if(isset($boq_code) && empty($boq_code)){
                    $error = 'Y';
                    $error_message = 'Please enter BOQ Sr No!';
                    }
                    $hsn_sac_code = $this->input->post('hsn_sac_code');
                    if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                    if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                    $error = 'Y';
                    $error_message = 'Please enter HSN/SAC Code!';
                    }
                    $item_description = $this->input->post('item_description');
                    if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                    if(isset($item_description) && empty($item_description)){
                    $error = 'Y';
                    $error_message = 'Please enter Item Description!';
                    }
                    $unit = $this->input->post('unit');
                    if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                    if(isset($unit) && empty($unit)){
                    $error = 'Y';
                    $error_message = 'Please enter Unit!';
                    }
                    $avl_qty = $this->input->post('avl_qty');
                    if(isset($avl_qty) && !empty($avl_qty)) {$avl_qty = $avl_qty; } else {$avl_qty=''; }
                    if(isset($avl_qty) && empty($avl_qty)){
                    $error = 'Y';
                    $error_message = 'Please enter Avl Qty!';
                    }
                    $installed_qty = $this->input->post('installed_qty');
                    if(isset($installed_qty) && !empty($installed_qty)) {$installed_qty = $installed_qty; } else {$installed_qty=''; }
                    if(isset($installed_qty) && empty($installed_qty)){
                    $error = 'Y';
                    $error_message = 'Please enter Installed Qty!';
                    }
                    if(isset($boq_code) && empty($boq_code)
                    && isset($hsn_sac_code) && empty($hsn_sac_code)
                    && isset($item_description) && empty($item_description)
                    && isset($unit) && empty($unit)
                    && isset($avl_qty) && empty($avl_qty)
                    && isset($installed_qty) && empty($installed_qty)){
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">Please Enter Installed WIP Details!!</div>'
                        ));    
                    }else{
                        if($error == 'N'){
                            if(isset($boq_code) && !empty($boq_code)){
                                $i_wip_itemid = $this->input->post('i_wip_itemid');
                                if($update_i_wip_id){
                                    $rate_basic = $this->input->post('rate_basic');
                                    for($i=0;$i<count($boq_code);$i++){
                                        if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                        if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                        if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                        if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                        if(isset($avl_qty[$i]) && !empty($avl_qty[$i]) && $avl_qty[$i] > 0) {$avl_qty_s = $avl_qty[$i]; } else {$avl_qty_s='0'; }            
                                        if(isset($installed_qty[$i]) && !empty($installed_qty[$i]) && $installed_qty[$i] > 0) {$installed_qty_s = $installed_qty[$i]; } else {$installed_qty_s='0'; }            
                                        if(isset($i_wip_itemid[$i]) && !empty($i_wip_itemid[$i])) {$i_wip_itemid_s = $i_wip_itemid[$i]; } else {$i_wip_itemid_s=0; }            
                                        if(isset($rate_basic[$i]) && !empty($rate_basic[$i])) {$rate_basic_s = $rate_basic[$i]; } else {$rate_basic_s=0; }            
                                        
                                        if(isset($boq_code_s) && !empty($boq_code_s)
                                        && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                        && isset($item_description_s) && !empty($item_description_s)
                                        && isset($unit_s) && !empty($unit_s)
                                        && isset($avl_qty_s) && !empty($avl_qty_s)
                                        && isset($installed_qty_s) && !empty($installed_qty_s)){
                                            if(isset($project_id) && !empty($project_id) && isset($boq_code_s) && !empty($boq_code_s)){
                                                $delete_boq_arr[] = $boq_code_s;
                                                $save_arr[] = array('i_wip_id'=>$update_i_wip_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                                'unit'=>$unit_s,'avl_qty'=>$avl_qty_s,'installed_qty'=>$installed_qty_s,'rate_basic'=>$rate_basic_s,
                                                'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));    
                                            }
                                        }
                                    }
                                }
                            }
                            if(isset($save_arr) && !empty($save_arr)){
                                if(isset($delete_boq_arr) && !empty($delete_boq_arr)){
                                   $this->admin_model->deleteBOQInstalledWIPOldItemById($delete_boq_arr,$update_i_wip_id);
                                }
                                $this->common_model->SaveMultiData('tbl_install_wip_items',$save_arr);
                                $main_arr = array('modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),
                                'display'=>'Y','status'=>'pending');
                                $this->common_model->updateDetails('tbl_installed_wip', 'i_wip_id', $update_i_wip_id,$main_arr);
                                $this->json->jsonReturn(array(
                                    'valid'=>TRUE,
                                    'msg'=>'<div class="alert modify alert-success">Installed WIP Details Saved Successfully!</div>',
                                    'redirect' => base_url().'add-installed-wip'
                                ));    
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Installed WIP!!</div>'
                                ));    
                            }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                            ));
                        }
                    }
                }else{
                    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger">Invalid Installed WIP!</div>'
                    ));    
                }
            
        }else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
            ));    
        }
    }
    public function save_installed_wip_details() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		   
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_installed_wip_details');
		     
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $save_arr = array();
                    $save_boq_stock_arr = array();
                    $update_boq_stock_arr = array();
                    $project_id = $this->input->post('project_id');
                    //$i_wip_no = $this->input->post('installed_wip_no');
                      
                    $getPrifixData = $this->common_model->getPrifixData('IWIP');
                     
                    if(isset($getPrifixData) && !empty($getPrifixData)){
                        $prefix_name = $getPrifixData['prefix_name'];   
                        $financial_year = $getPrifixData['financial_year'];   
                    }else{
                        $prefix_name = 'IWIP';
                        $financial_year = $this->getFinancialYear();
                    }
                  
                //     $getLastFinancialYear = $this->common_model->getLastFinancialYear('IWIP');
                //       pr("ok");
		              //  pr($this->db->last_query(),1);
                    $i_wip_inc = 1;
                    $getLastInc = $this->common_model->getLastInc('IWIP');
                    // if($getLastFinancialYear == $financial_year){
                    //     if(isset($getLastInc) && !empty($getLastInc)){
                    //         $i_wip_inc = $getLastInc + 1;    
                    //     }
                    // }
                     $i_wip_inc = $getLastInc + 1;  
                  
                    if(strlen($i_wip_inc) > 4){
                        $i_wip_no = $prefix_name.'-'.$i_wip_inc.'/'.$financial_year;
                    }else{
                        $i_wip_no = $prefix_name.'-'.sprintf('%02d',$i_wip_inc).'/'.$financial_year;
                    }
                    if(isset($project_id) && !empty($project_id) && isset($i_wip_no) && !empty($i_wip_no)){
                        $installed_wip = $this->common_model->selectDetailsWhr('tbl_installed_wip','i_wip_no',$i_wip_no);
                        if(isset($installed_wip) && empty($installed_wip)){
                        $error = 'N';
                        $error_message = '';
                        $user_id = $this->session->userdata('user_id');
                        if(isset($user_id) && empty($user_id)){
                        $error = 'Y';
                        $error_message = 'Please loggedin!';
                        }
                        $boq_code = $this->input->post('boq_code');
                        if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                        if(isset($boq_code) && empty($boq_code)){
                        $error = 'Y';
                        $error_message = 'Please enter BOQ Sr No!';
                        }
                        $hsn_sac_code = $this->input->post('hsn_sac_code');
                        if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
                        if(isset($hsn_sac_code) && empty($hsn_sac_code)){
                        $error = 'Y';
                        $error_message = 'Please enter HSN/SAC Code!';
                        }
                        $item_description = $this->input->post('item_description');
                        if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                        if(isset($item_description) && empty($item_description)){
                        $error = 'Y';
                        $error_message = 'Please enter Item Description!';
                        }
                        $unit = $this->input->post('unit');
                        if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
                        if(isset($unit) && empty($unit)){
                        $error = 'Y';
                        $error_message = 'Please enter Unit!';
                        }
                        $avl_qty = $this->input->post('avl_qty');
                        if(isset($avl_qty) && !empty($avl_qty)) {$avl_qty = $avl_qty; } else {$avl_qty=''; }
                        if(isset($avl_qty) && empty($avl_qty)){
                        $error = 'Y';
                        $error_message = 'Please enter Avl Qty!';
                        }
                        $installed_qty = $this->input->post('installed_qty');
                        if(isset($installed_qty) && !empty($installed_qty)) {$installed_qty = $installed_qty; } else {$installed_qty=''; }
                        if(isset($installed_qty) && empty($installed_qty)){
                        $error = 'Y';
                        $error_message = 'Please enter Installed Qty!';
                        }
                        if(isset($boq_code) && empty($boq_code)
                        && isset($hsn_sac_code) && empty($hsn_sac_code)
                        && isset($item_description) && empty($item_description)
                        && isset($unit) && empty($unit)
                        && isset($avl_qty) && empty($avl_qty)
                        && isset($installed_qty) && empty($installed_qty)){
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">Please Enter Installed WIP Details!!</div>'
                            ));    
                        }else{
                            if($error == 'N'){
                                if(isset($boq_code) && !empty($boq_code)){
                                    $event_name = 'Installed WIP';
                                    $BOQTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,'exceptional_no'=>$i_wip_no,
                                    'exceptional_id'=>0,'event_type'=>'iwip','created_date'=>date('Y-m-d H:i:s'),
                                    'created_by'=>$user_id,'updated_by'=>$user_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending',
                                    'approved_by'=>0,'approved_date'=>'');
                                    $transaction_id = $this->common_model->addData('tbl_boq_transactions',$BOQTransArr);
                                    if($transaction_id){
                                    $main_arr = array('project_id'=>$project_id,'i_wip_no'=>$i_wip_no,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),
                                    'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending','i_wip_inc'=>$i_wip_inc,
                                    'transaction_id'=>$transaction_id);
                                    $i_wip_id = $this->common_model->addData('tbl_installed_wip',$main_arr);
                                    if($i_wip_id){
                                        $rate_basic = $this->input->post('rate_basic');
                                        for($i=0;$i<count($boq_code);$i++){
                                            if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                            if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                            if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                            if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                            if(isset($avl_qty[$i]) && !empty($avl_qty[$i]) && $avl_qty[$i] > 0) {$avl_qty_s = $avl_qty[$i]; } else {$avl_qty_s=''; }            
                                            if(isset($installed_qty[$i]) && !empty($installed_qty[$i]) && $installed_qty[$i] > 0) {$installed_qty_s = $installed_qty[$i]; } else {$installed_qty_s=''; }            
                                            if(isset($rate_basic[$i]) && !empty($rate_basic[$i]) && $rate_basic[$i] > 0) {$rate_basic_s = $rate_basic[$i]; } else {$rate_basic_s=''; }            
                                            
                                            if(isset($boq_code_s) && !empty($boq_code_s)
                                            && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                            && isset($item_description_s) && !empty($item_description_s)
                                            && isset($unit_s) && !empty($unit_s)
                                            && isset($avl_qty_s) && !empty($avl_qty_s)
                                            && isset($installed_qty_s) && !empty($installed_qty_s)){
                                                $save_arr[] = array('i_wip_id'=>$i_wip_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                                'unit'=>$unit_s,'avl_qty'=>$avl_qty_s,'installed_qty'=>$installed_qty_s,'rate_basic'=>$rate_basic_s,
                                                'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));    
                                            }
                                        }
                                    }
                                    }
                                }
                               
                                //   pr($this->db->last_query(),1);
                                if(isset($save_arr) && !empty($save_arr)){
                                    $this->common_model->SaveMultiData('tbl_install_wip_items',$save_arr);
                                  
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE,
                                        'msg'=>'<div class="alert modify alert-success">Installed WIP Details Saved Successfully!</div>',
                                        'redirect' => base_url().'add-installed-wip'
                                    ));    
                                }else{
                                    $this->json->jsonReturn(array(
                                        'valid'=>FALSE,
                                        'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Installed WIP!!</div>'
                                    ));    
                                }
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                                ));
                            }
                        }
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">Installed WIP no already exist!</div>'
                        ));    
                    }
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
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
		}else{
		    $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">You have no Permission!!</div>'
            )); 
		}
		
    }
    public function save_virtual_stock_details() 
    {
        $save_arr = array();
        $project_id = $this->input->post('project_id');
        $virtual_stock_no = $this->input->post('virtual_stock_no');
        if(isset($project_id) && !empty($project_id) && isset($virtual_stock_no) && !empty($virtual_stock_no)){
            $virtual_stock = $this->common_model->selectDetailsWhr('tbl_virtual_stock','vs_no',$virtual_stock_no);
            if(isset($virtual_stock) && empty($virtual_stock)){
            $error = 'N';
            $error_message = '';
            $user_id = $this->session->userdata('user_id');
            if(isset($user_id) && empty($user_id)){
            $error = 'Y';
            $error_message = 'Please loggedin!';
            }
            $boq_code = $this->input->post('boq_code');
            if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
            if(isset($boq_code) && empty($boq_code)){
            $error = 'Y';
            $error_message = 'Please enter BOQ Sr No!';
            }
            $hsn_sac_code = $this->input->post('hsn_sac_code');
            if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
            if(isset($hsn_sac_code) && empty($hsn_sac_code)){
            $error = 'Y';
            $error_message = 'Please enter HSN/SAC Code!';
            }
            $item_description = $this->input->post('item_description');
            if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
            if(isset($item_description) && empty($item_description)){
            $error = 'Y';
            $error_message = 'Please enter Item Description!';
            }
            $unit = $this->input->post('unit');
            if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
            if(isset($unit) && empty($unit)){
            $error = 'Y';
            $error_message = 'Please enter Unit!';
            }
            $avl_qty = $this->input->post('avl_qty');
            if(isset($avl_qty) && !empty($avl_qty)) {$avl_qty = $avl_qty; } else {$avl_qty=''; }
            if(isset($avl_qty) && empty($avl_qty)){
            $error = 'Y';
            $error_message = 'Please enter Avl Qty!';
            }
            $stock_qty = $this->input->post('stock_qty');
            if(isset($stock_qty) && !empty($stock_qty)) {$stock_qty = $stock_qty; } else {$stock_qty=''; }
            if(isset($stock_qty) && empty($stock_qty)){
            $error = 'Y';
            $error_message = 'Please enter Stock Qty!';
            }
            if(isset($boq_code) && empty($boq_code)
            && isset($hsn_sac_code) && empty($hsn_sac_code)
            && isset($item_description) && empty($item_description)
            && isset($unit) && empty($unit)
            && isset($avl_qty) && empty($avl_qty)
            && isset($stock_qty) && empty($stock_qty)){
                $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger">Please Enter Warehouse Details!!</div>'
                ));    
            }else{
                if($error == 'N'){
                    if(isset($boq_code) && !empty($boq_code)){
                        $main_arr = array('project_id'=>$project_id,'vs_no'=>$virtual_stock_no,'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),
                        'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending');
                        $vs_id = $this->common_model->addData('tbl_virtual_stock',$main_arr);
                        if($vs_id){
                            for($i=0;$i<count($boq_code);$i++){
                                if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                if(isset($avl_qty[$i]) && !empty($avl_qty[$i])) {$avl_qty_s = $avl_qty[$i]; } else {$avl_qty_s=''; }            
                                if(isset($stock_qty[$i]) && !empty($stock_qty[$i])) {$stock_qty_s = $stock_qty[$i]; } else {$stock_qty_s=''; }            
                                
                                if(isset($boq_code_s) && !empty($boq_code_s)
                                && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                                && isset($item_description_s) && !empty($item_description_s)
                                && isset($unit_s) && !empty($unit_s)
                                && isset($avl_qty_s) && !empty($avl_qty_s)
                                && isset($stock_qty_s) && !empty($stock_qty_s)){
                                    $save_arr[] = array('vs_id'=>$vs_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,'item_description'=>$item_description_s,
                                    'unit'=>$unit_s,'avl_qty'=>$avl_qty_s,'stock_qty'=>$stock_qty_s,
                                    'created_by'=>$user_id,'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'));    
                                }
                            }
                        }
                    }
                    if(isset($save_arr) && !empty($save_arr)){
                        $this->common_model->SaveMultiData('tbl_virtual_stock_items',$save_arr);
                        $this->json->jsonReturn(array(
                            'valid'=>TRUE,
                            'msg'=>'<div class="alert modify alert-success">Warehouse Details Saved Successfully!</div>',
                            'redirect' => base_url().'move-to-warehouse'
                        ));    
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">Please Enter Valid Warehouse!!</div>'
                        ));    
                    }
                }else{
                    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                    ));
                }
            }
        }else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">Warehouse no already exist!</div>'
            ));    
        }
        }else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
            ));    
        }
    }
    
    public function save_boq_exceptional_approval() 
    {
        error_reporting(E_ALL);
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_boq_exceptional_approval');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $save_exceptional_arr = array();
                    $update_stock_arr = array();
                    $delete_boq_arr = array();
                    $save_new_boq_item_arr = array();
                    $save_stock_arr=array();
                    $save_neg_exceptional_arr = array();
                    $save_ns_exceptional_arr = array();
                    
                    $bom_exception_arr = array();
                    $bom_neg_exception_arr = array();
                    $bom_ns_exception_arr = array();


                    $project_id = $this->input->post('project_id');
                    if(isset($project_id) && !empty($project_id)){
                        $error = 'N';
                        $error_message = '';
                        $user_id = $this->session->userdata('user_id');
                        if(isset($user_id) && empty($user_id)){
                        $error = 'Y';
                        $error_message = 'Please loggedin!';
                        }
                        
                        $billable = $this->input->post('billable');
                        if(isset($billable) && !empty($billable) && $billable == 'Y') {$billable = 'Y'; } else {$billable='N'; }
                        
                        $boq_code = $this->input->post('boq_code');
                        if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
                        if(isset($boq_code) && empty($boq_code)){
                        $error = 'Y';
                        $error_message = 'Please enter BOQ Sr No!';
                        }
                        $item_description = $this->input->post('item_description');
                        if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
                        if(isset($item_description) && empty($item_description)){
                        $error = 'Y';
                        $error_message = 'Please enter Item Description!';
                        }
                        $ea_qty = $this->input->post('ea_qty');
                        if(isset($ea_qty) && !empty($ea_qty)) {$ea_qty = $ea_qty; } else {$ea_qty=''; }
                        if(isset($ea_qty) && empty($ea_qty)){
                        $error = 'Y';
                        $error_message = 'Please enter EA Qty!';
                        }
                        $non_schedule = $this->input->post('non_schedule');
                        if(isset($non_schedule) && !empty($non_schedule)) {$non_schedule = $non_schedule; } else {$non_schedule=''; }
                        if(isset($non_schedule) && empty($non_schedule)){
                        $error = 'Y';
                        $error_message = 'Please select NS Yes/No!';
                        }
                        $PO_taxable_amt = $this->input->post('PO_taxable_amt');
                        if(isset($PO_taxable_amt) && !empty($PO_taxable_amt)) {$PO_taxable_amt = $PO_taxable_amt; } else {$PO_taxable_amt=''; }
                        if(isset($PO_taxable_amt) && empty($PO_taxable_amt)){
                        $error = 'Y';
                        $error_message = 'Please enter Variation PO Taxable Amount!';
                        }
                        $gst_rate = $this->input->post('gst_rate');
                        if(isset($gst_rate) && !empty($gst_rate)) {$gst_rate = $gst_rate; } else {$gst_rate=''; }
                        if(isset($gst_rate) && empty($gst_rate)){
                        $error = 'Y';
                        $error_message = 'Please select GST Rate!';
                        }
                        $gst_amount = $this->input->post('gst_amount');
                        if(isset($gst_amount) && !empty($gst_amount)) {$gst_amount = $gst_amount; } else {$gst_amount=''; }
                        if(isset($gst_amount) && empty($gst_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter GST Amount!';
                        }
                        $po_final_amount = $this->input->post('po_final_amount');
                        if(isset($po_final_amount) && !empty($po_final_amount)) {$po_final_amount = $po_final_amount; } else {$po_final_amount=''; }
                        if(isset($po_final_amount) && empty($po_final_amount)){
                        $error = 'Y';
                        $error_message = 'Please enter Total Variation PO Amount!';
                        }
                        $po_doc_file = '';
                        if(isset($_FILES['po_doc']['name']) && !empty($_FILES['po_doc']['name'])){
                          $po_doc = $_FILES['po_doc']['name'];
                          $po_doc_fileImg = array('upload_path' =>'./uploads/variation_po/',
                                'fieldname' => 'po_doc',
                                'encrypt_name' => TRUE,        
                                'overwrite' => FALSE,
                                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                          $po_doc_file_img = $this->imageupload->image_upload($po_doc_fileImg);
                          $errormsg= $this->upload->display_errors();
                          if(isset($po_doc_file_img) && !empty($po_doc_file_img))
                          {
                            $po_doc_fileData = $this->upload->data();      
                            $po_doc_file = $po_doc_fileData['file_name'];
                          }
                        }else{
                            $po_doc_file = '';
                        }
                        if(isset($boq_code) && empty($boq_code)
                        && isset($item_description) && empty($item_description)
                        && isset($ea_qty) && empty($ea_qty)
                        && isset($PO_taxable_amt) && empty($PO_taxable_amt)
                        && isset($gst_rate) && empty($gst_rate)
                        && isset($po_doc) && empty($po_doc)){
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">Please Enter BOQ Exceptional Approval Details!!</div>'
                            ));    
                        }else{
                            // check negative EA exist
                            $negEaQtys = array();
                            if(isset($ea_qty) && !empty($ea_qty)){
                                $negEaQtys = array_filter($ea_qty, function($x) {
                                    return $x < 0;
                                });
                            }
                            // check positive EA exist
                            $posEaQtys = $posEaQtysFilter = array();
                            if(isset($ea_qty) && !empty($ea_qty) && isset($non_schedule) && !empty($non_schedule)){
                                $posEaQtysFilter = array_filter($ea_qty, function($x) {
                                    return $x > 0;
                                });
                                if(isset($posEaQtysFilter) && !empty($posEaQtysFilter)){
                                    $posEaQtysKeys = array_keys($posEaQtysFilter);
                                    foreach($posEaQtysKeys as $key){
                                        if(isset($non_schedule[$key]) && !empty($non_schedule[$key]) && $non_schedule[$key] == 'No'){
                                            $posEaQtys[] = $posEaQtysFilter[$key];     
                                        }    
                                    }
                                }
                            }
                            $nsEaItem = $nsEaItemFilter = array();
                            if(isset($ea_qty) && !empty($ea_qty) && isset($non_schedule) && !empty($non_schedule)){
                                $nsEaItemFilter = array_filter($non_schedule, function($x) {
                                    return $x == 'Yes';
                                });
                                if(isset($nsEaItemFilter) && !empty($nsEaItemFilter)){
                                    $nsEaItemKeys = array_keys($nsEaItemFilter);
                                    foreach($nsEaItemKeys as $key){
                                        if(isset($ea_qty[$key]) && !empty($ea_qty[$key]) && $ea_qty[$key] > 0){
                                            $nsEaItem[] = $nsEaItemFilter[$key];     
                                        }    
                                    }
                                }
                            }
                            $action = 'save';
                            $except_type = '';
                            $exceptional_id = $this->input->post('exceptional_id');
                            if(isset($exceptional_id) && !empty($exceptional_id)){
                                $action = 'update';
                                $exceptional_data = $this->common_model->selectDetailsWhr('view_boq_exceptional','exceptional_id',$exceptional_id);
                                if(isset($exceptional_data->display) && !empty($exceptional_data->display) && $exceptional_data->display == 'Y'){
                                    //get last count
                                    $exceptional_id = $exceptional_data->exceptional_id;
                                    $exceptional_inc = $exceptional_data->exceptional_inc;
                                    $except_type = $exceptional_data->except_type;
                                    if(isset($exceptional_data->except_type) && !empty($exceptional_data->except_type) && $exceptional_data->except_type == 'positive'){
                                        if(isset($posEaQtys) && !empty($posEaQtys)){
                                            if(isset($negEaQtys) && !empty($negEaQtys)){
                                                $error = 'Y';
                                                $error_message = 'Please enter only positive EA Qty BOQ Exceptional Approval Details!';    
                                            }elseif(isset($nsEaItem) && !empty($nsEaItem)){
                                                $error = 'Y';
                                                $error_message = 'Please enter only positive Non-Schedule(No) EA Qty BOQ Exceptional Approval Details!';    
                                            }
                                        }
                                    }elseif(isset($exceptional_data->except_type) && !empty($exceptional_data->except_type) && $exceptional_data->except_type == 'negative'){
                                        if(isset($negEaQtys) && !empty($negEaQtys)){
                                            if(isset($posEaQtys) && !empty($posEaQtys)){
                                                $error = 'Y';
                                                $error_message = 'Please enter only negative EA Qty BOQ Exceptional Approval Details!';    
                                            }elseif(isset($nsEaItem) && !empty($nsEaItem)){
                                                $error = 'Y';
                                                $error_message = 'Please enter only negative Non-Schedule(No) EA Qty BOQ Exceptional Approval Details!';    
                                            }   
                                        }
                                    }elseif(isset($exceptional_data->except_type) && !empty($exceptional_data->except_type) && $exceptional_data->except_type == 'ns_yes'){
                                        if(isset($nsEaItem) && !empty($nsEaItem)){
                                            if(isset($negEaQtys) && !empty($negEaQtys)){
                                                $error = 'Y';
                                                $error_message = 'Please enter only positive EA Qty NS BOQ Exceptional Approval Details!';    
                                            }elseif(isset($posEaQtys) && !empty($posEaQtys)){
                                                $error = 'Y';
                                                $error_message = 'Please enter only positive EA Qty NS BOQ Exceptional Approval Details!';    
                                            }
                                        }   
                                    }else{
                                        $error = 'Y';
                                        $error_message = 'Invalid BOQ Exceptional Approval Details!';
                                    }
                                }else{
                                    $error = 'Y';
                                    $error_message = 'Invalid BOQ Exceptional Approval Details!';
                                }
                            }else{
                                //get last count
                                $exceptional_id = $this->admin_model->getLastExceptionalId();
                                $exceptional_inc = $this->common_model->getLastInc('EA');
                            }
                           
                            if($error == 'N'){
                                //get EA prefix and year
                                $ea_prefix = $this->common_model->getPrifixData('EA');
                                $lastFinancialYear = $this->common_model->getLastFinancialYear('EA');
                                if(isset($ea_prefix) && !empty($ea_prefix)){
                                    $ea_prefix_name = $ea_prefix['prefix_name'];    
                                    $financialYear = $ea_prefix['financial_year'];    
                                }else{
                                    $ea_prefix_name = 'EA';
                                    $financialYear = $this->getFinancialYear();
                                }
                                if(isset($negEaQtys) && !empty($negEaQtys) && isset($posEaQtys) && !empty($posEaQtys) && isset($nsEaItem) && !empty($nsEaItem)){
                                    if($action == 'save'){
                                        $excep_id = 1;
                                        if(isset($exceptional_id) && !empty($exceptional_id)){
                                            $excep_id = $exceptional_id + 1;
                                        }
                                        if(isset($excep_id) && !empty($excep_id)){
                                            $neg_excep_id = $excep_id + 1;
                                        }
                                        if(isset($neg_excep_id) && !empty($neg_excep_id)){
                                            $ns_excep_id = $neg_excep_id + 1;
                                        }
                                        $pos_except_inc=1;
                                        $neg_except_inc=1;
                                        $ns_except_inc=1;
                                        if($lastFinancialYear == $financialYear){
                                            if(isset($exceptional_inc) && !empty($exceptional_inc)){
                                                $pos_except_inc = $exceptional_inc + 1;
                                            }
                                            if(isset($pos_except_inc) && !empty($pos_except_inc)){
                                                $neg_except_inc = $pos_except_inc + 1;
                                            }
                                            if(isset($neg_except_inc) && !empty($neg_except_inc)){
                                                $ns_except_inc = $neg_except_inc + 1;
                                            }
                                        }
                                    }else{
                                        $pos_except_inc = 0;
                                        $neg_except_inc = 0;
                                        $ns_except_inc = 0;
                                        $excep_id = $exceptional_id;
                                        if(isset($except_type) && !empty($except_type) && $except_type == 'positive'){
                                            $pos_except_inc = $exceptional_inc;      
                                        }elseif(isset($except_type) && !empty($except_type) && $except_type == 'negative'){
                                            $neg_except_inc = $exceptional_inc;      
                                        }elseif(isset($except_type) && !empty($except_type) && $except_type == 'ns_yes'){
                                            $ns_except_inc = $exceptional_inc;      
                                        }
                                    }
                                    $pos_exceptional_no = 0;
                                    if(!empty($pos_except_inc)){
                                        if(strlen($pos_except_inc) > 4){
                                			   $pos_exceptional_no = $ea_prefix_name.'-'.$pos_except_inc.'/'.$financialYear;
                                		}else{
                                			   $pos_exceptional_no = $ea_prefix_name.'-'.sprintf('%02d',$pos_except_inc).'/'.$financialYear;
                                		}
                                    }
                                    //   pr($ns_exceptional_no,1);
                            		$neg_exceptional_no = 0;
                                    if(!empty($neg_except_inc)){
                                        if(strlen($neg_except_inc) > 4){
                                			   $neg_exceptional_no = $ea_prefix_name.'-'.$neg_except_inc.'/'.$financialYear;
                                		}else{
                                			   $neg_exceptional_no = $ea_prefix_name.'-'.sprintf('%02d',$neg_except_inc).'/'.$financialYear;
                                		}
                                    }
                                    //  pr($neg_exceptional_no,1);
                                    $ns_exceptional_no = 0;
                                    if(!empty($ns_except_inc)){
                                        if(strlen($ns_except_inc) > 4){
                                			   $ns_exceptional_no = $ea_prefix_name.'-'.$ns_except_inc.'/'.$financialYear;
                                		}else{
                                			   $ns_exceptional_no = $ea_prefix_name.'-'.sprintf('%02d',$ns_except_inc).'/'.$financialYear;
                                		}
                                    }
                                    // pr($ns_exceptional_no,1);
                                }elseif(isset($negEaQtys) && !empty($negEaQtys) && isset($posEaQtys) && empty($posEaQtys) && isset($nsEaItem) && empty($nsEaItem)){
                                    if($action == 'update'){
                                        $excep_id = 0;
                                        $neg_excep_id = $exceptional_id; 
                                        $pos_except_inc = 0;
                                        $neg_except_inc = $exceptional_inc;
                                        $ns_excep_id = 0;
                                        $ns_except_inc = 0;
                                    }elseif($action == 'save'){
                                        $excep_id = 0;
                                        $neg_excep_id=1;
                                        if(isset($exceptional_id) && !empty($exceptional_id)){
                                            $neg_excep_id = $exceptional_id + 1;
                                        }
                                        $pos_except_inc = 0;
                                        $neg_except_inc = 1;
                                        if($lastFinancialYear == $financialYear){
                                            if(isset($exceptional_inc) && !empty($exceptional_inc)){
                                                $neg_except_inc = $exceptional_inc + 1;
                                            }
                                        }
                                        $ns_excep_id = 0;
                                        $ns_except_inc = 0;
                                    }
                                    $pos_exceptional_no = '';
                                    $neg_exceptional_no = '';
                                    $ns_exceptional_no = '';
                                    if(!empty($neg_except_inc)){
                                    if(strlen($neg_except_inc) > 4){
                            			$neg_exceptional_no = $ea_prefix_name.'-'.$neg_except_inc.'/'.$financialYear;
                            		}else{
                            			$neg_exceptional_no = $ea_prefix_name.'-'.sprintf('%02d',$neg_except_inc).'/'.$financialYear;
                            		}
                            // 		pr($neg_exceptional_no,1);
                                    }
                                }elseif(isset($negEaQtys) && empty($negEaQtys) && isset($posEaQtys) && !empty($posEaQtys) && isset($nsEaItem) && empty($nsEaItem)){
                                    if($action == 'update'){
                                        $neg_excep_id = 0;
                                        $ns_excep_id = 0;
                                        $excep_id = $exceptional_id;
                                        $pos_except_inc = $exceptional_inc;
                                        $neg_except_inc = 0;
                                        $ns_except_inc = 0;
                                    }elseif($action == 'save'){
                                        $neg_excep_id = 0;
                                        $ns_excep_id = 0;
                                        $excep_id=1;
                                        if(isset($exceptional_id) && !empty($exceptional_id)){
                                            $excep_id = $exceptional_id + 1;
                                        }
                                        $pos_except_inc = 1;
                                        $neg_except_inc = 0;
                                        if($lastFinancialYear == $financialYear){
                                            if(isset($exceptional_inc) && !empty($exceptional_inc)){
                                                $pos_except_inc = $exceptional_inc + 1;
                                            }
                                        }
                                        $ns_except_inc = 0;
                                        
                                    }
                                    $neg_exceptional_no = '';
                                    $pos_exceptional_no = '';
                                    $ns_exceptional_no = '';
                                    if(!empty($pos_except_inc)){
                                    if(strlen($pos_except_inc) > 4){
                                        $pos_exceptional_no = $ea_prefix_name.'-'.$pos_except_inc.'/'.$financialYear;
                            		}else{
                            			 $pos_exceptional_no = $ea_prefix_name.'-'.sprintf('%02d',$pos_except_inc).'/'.$financialYear;
                            		}
                            // 			pr($pos_exceptional_no,1);
                                    }
                                }elseif(isset($negEaQtys) && empty($negEaQtys) && isset($posEaQtys) && empty($posEaQtys) && isset($nsEaItem) && !empty($nsEaItem)){
                                    if($action == 'update'){
                                        $neg_excep_id = 0;
                                        $ns_excep_id = $exceptional_id;
                                        $excep_id = 0;
                                        $pos_except_inc = 0;
                                        $neg_except_inc = 0;
                                        $ns_except_inc = $exceptional_inc;
                                    }elseif($action == 'save'){
                                        $neg_excep_id = 0;
                                        $ns_excep_id = 1;
                                        $excep_id=0;
                                        if(isset($exceptional_id) && !empty($exceptional_id)){
                                            $ns_excep_id = $exceptional_id + 1;
                                        }
                                        $pos_except_inc = 0;
                                        $neg_except_inc = 0;
                                        $ns_except_inc = 1;
                                        if($lastFinancialYear == $financialYear){
                                            if(isset($exceptional_inc) && !empty($exceptional_inc)){
                                                $ns_except_inc = $exceptional_inc + 1;
                                            }
                                        }
                                        
                                    }
                                    $neg_exceptional_no = '';
                                    $pos_exceptional_no = '';
                                    $ns_exceptional_no = '';
                                    if(!empty($ns_except_inc)){
                                    if(strlen($ns_except_inc) > 4){
                                        $ns_exceptional_no = $ea_prefix_name.'-'.$ns_except_inc.'/'.$financialYear;
                            		}else{
                            			 $ns_exceptional_no = $ea_prefix_name.'-'.sprintf('%02d',$ns_except_inc).'/'.$financialYear;
                            		}
                            // 			pr($ns_exceptional_no,1);
                                    }
                                }elseif(isset($negEaQtys) && empty($negEaQtys) && isset($posEaQtys) && !empty($posEaQtys) && isset($nsEaItem) && !empty($nsEaItem)){
                                    if($action == 'save'){
                                        $excep_id = 1;
                                        if(isset($exceptional_id) && !empty($exceptional_id)){
                                            $excep_id = $exceptional_id + 1;
                                        }
                                        $neg_excep_id  = 0;
                                        if(isset($excep_id) && !empty($excep_id)){
                                            $ns_excep_id = $excep_id + 1;
                                        }
                                        $pos_except_inc=1;
                                        $neg_except_inc=0;
                                        $ns_except_inc=1;
                                        if($lastFinancialYear == $financialYear){
                                            if(isset($exceptional_inc) && !empty($exceptional_inc)){
                                                $pos_except_inc = $exceptional_inc + 1;
                                            }
                                            if(isset($pos_except_inc) && !empty($pos_except_inc)){
                                                $ns_except_inc = $pos_except_inc + 1;
                                            }
                                        }
                                    }else{
                                        $pos_except_inc = 0;
                                        $neg_except_inc = 0;
                                        $ns_except_inc = 0;
                                        $excep_id = $exceptional_id;
                                        if(isset($except_type) && !empty($except_type) && $except_type == 'positive'){
                                            $pos_except_inc = $exceptional_inc;      
                                        }elseif(isset($except_type) && !empty($except_type) && $except_type == 'negative'){
                                            $neg_except_inc = $exceptional_inc;      
                                        }elseif(isset($except_type) && !empty($except_type) && $except_type == 'ns_yes'){
                                            $ns_except_inc = $exceptional_inc;      
                                        }
                                    }
                                    $pos_exceptional_no = 0;
                                    if(!empty($pos_except_inc)){
                                        if(strlen($pos_except_inc) > 4){
                                			   $pos_exceptional_no = $ea_prefix_name.'-'.$pos_except_inc.'/'.$financialYear;
                                		}else{
                                			   $pos_exceptional_no = $ea_prefix_name.'-'.sprintf('%02d',$pos_except_inc).'/'.$financialYear;
                                		}
                                    }
                            		$neg_exceptional_no = 0;
                                    $ns_exceptional_no = 0;
                                    if(!empty($ns_except_inc)){
                                        if(strlen($ns_except_inc) > 4){
                                			   $ns_exceptional_no = $ea_prefix_name.'-'.$ns_except_inc.'/'.$financialYear;
                                		}else{
                                			   $ns_exceptional_no = $ea_prefix_name.'-'.sprintf('%02d',$ns_except_inc).'/'.$financialYear;
                                		}
                                    }
                                }elseif(isset($negEaQtys) && !empty($negEaQtys) && isset($posEaQtys) && empty($posEaQtys) && isset($nsEaItem) && !empty($nsEaItem)){
                                    if($action == 'save'){
                                        $excep_id = 0;
                                        if(isset($exceptional_id) && !empty($exceptional_id)){
                                            $neg_excep_id = $exceptional_id + 1;
                                        }
                                        if(isset($neg_excep_id) && !empty($neg_excep_id)){
                                            $ns_excep_id = $neg_excep_id + 1;
                                        }
                                        $pos_except_inc=0;
                                        $neg_except_inc=1;
                                        $ns_except_inc=1;
                                        if($lastFinancialYear == $financialYear){
                                            if(isset($exceptional_inc) && !empty($exceptional_inc)){
                                                $neg_except_inc = $exceptional_inc + 1;
                                            }
                                            if(isset($neg_except_inc) && !empty($neg_except_inc)){
                                                $ns_except_inc = $neg_except_inc + 1;
                                            }
                                        }
                                    }else{
                                        $pos_except_inc = 0;
                                        $neg_except_inc = 0;
                                        $ns_except_inc = 0;
                                        $excep_id = $exceptional_id;
                                        if(isset($except_type) && !empty($except_type) && $except_type == 'positive'){
                                            $pos_except_inc = $exceptional_inc;      
                                        }elseif(isset($except_type) && !empty($except_type) && $except_type == 'negative'){
                                            $neg_except_inc = $exceptional_inc;      
                                        }elseif(isset($except_type) && !empty($except_type) && $except_type == 'ns_yes'){
                                            $ns_except_inc = $exceptional_inc;      
                                        }
                                    }
                                    $pos_exceptional_no = 0;
                                    $neg_exceptional_no = 0;
                                    if(!empty($neg_except_inc)){
                                        if(strlen($neg_except_inc) > 4){
                                			   $neg_exceptional_no = $ea_prefix_name.'-'.$neg_except_inc.'/'.$financialYear;
                                		}else{
                                			   $neg_exceptional_no = $ea_prefix_name.'-'.sprintf('%02d',$neg_except_inc).'/'.$financialYear;
                                		}
                                    }
                            		$ns_exceptional_no = 0;
                                    if(!empty($ns_except_inc)){
                                        if(strlen($ns_except_inc) > 4){
                                			   $ns_exceptional_no = $ea_prefix_name.'-'.$ns_except_inc.'/'.$financialYear;
                                		}else{
                                			   $ns_exceptional_no = $ea_prefix_name.'-'.sprintf('%02d',$ns_except_inc).'/'.$financialYear;
                                		}
                                    }
                                }elseif(isset($negEaQtys) && !empty($negEaQtys) && isset($posEaQtys) && !empty($posEaQtys) && isset($nsEaItem) && empty($nsEaItem)){
                                    if($action == 'save'){
                                        $excep_id = 1;
                                        if(isset($exceptional_id) && !empty($exceptional_id)){
                                            $excep_id = $exceptional_id + 1;
                                        }
                                        if(isset($excep_id) && !empty($excep_id)){
                                            $neg_excep_id = $excep_id + 1;
                                        }
                                        $ns_excep_id = 0;
                                        
                                        $pos_except_inc=1;
                                        $neg_except_inc=1;
                                        $ns_except_inc=0;
                                        if($lastFinancialYear == $financialYear){
                                            if(isset($exceptional_inc) && !empty($exceptional_inc)){
                                                $pos_except_inc = $exceptional_inc + 1;
                                            }
                                            if(isset($pos_except_inc) && !empty($pos_except_inc)){
                                                $neg_except_inc = $pos_except_inc + 1;
                                            }
                                        }
                                    }else{
                                        $pos_except_inc = 0;
                                        $neg_except_inc = 0;
                                        $ns_except_inc = 0;
                                        $excep_id = $exceptional_id;
                                        if(isset($except_type) && !empty($except_type) && $except_type == 'positive'){
                                            $pos_except_inc = $exceptional_inc;      
                                        }elseif(isset($except_type) && !empty($except_type) && $except_type == 'negative'){
                                            $neg_except_inc = $exceptional_inc;      
                                        }elseif(isset($except_type) && !empty($except_type) && $except_type == 'ns_yes'){
                                            $ns_except_inc = $exceptional_inc;      
                                        }
                                    }
                                    $pos_exceptional_no = 0;
                                    if(!empty($pos_except_inc)){
                                        if(strlen($pos_except_inc) > 4){
                                			   $pos_exceptional_no = $ea_prefix_name.'-'.$pos_except_inc.'/'.$financialYear;
                                		}else{
                                			   $pos_exceptional_no = $ea_prefix_name.'-'.sprintf('%02d',$pos_except_inc).'/'.$financialYear;
                                		}
                                    }
                            		$neg_exceptional_no = 0;
                                    if(!empty($neg_except_inc)){
                                        if(strlen($neg_except_inc) > 4){
                                			   $neg_exceptional_no = $ea_prefix_name.'-'.$neg_except_inc.'/'.$financialYear;
                                		}else{
                                			   $neg_exceptional_no = $ea_prefix_name.'-'.sprintf('%02d',$neg_except_inc).'/'.$financialYear;
                                		}
                                    }
                                    $ns_exceptional_no = 0;
                                }
                                $delete_boq_save_arr = array();
                                if(isset($boq_code) && !empty($boq_code) && $error == 'N'){
                                    $hsn_sac_code = $this->input->post('hsn_sac_code');
                                    $unit = $this->input->post('unit');
                                    $rate_basic = $this->input->post('rate_basic');
                                    $gst = $this->input->post('gst');
                                    $boq_items_id = $this->input->post('boq_items_id');
                                    $scheduled_qty = $this->input->post('scheduled_qty');
                                    $o_design_qty = $this->input->post('o_design_qty');
                                    $design_qty = $this->input->post('design_qty');

                                    for($i=0;$i<count($boq_code);$i++){

                                        if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                                        if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                                        if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                                        if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                                        if(isset($rate_basic[$i]) && !empty($rate_basic[$i])) {$rate_basic_s = $rate_basic[$i]; } else {$rate_basic_s=0; }            
                                        if(isset($gst[$i]) && !empty($gst[$i])) {$gst_s = $gst[$i]; } else {$gst_s=0; }            
                                        if(isset($boq_items_id[$i]) && !empty($boq_items_id[$i])) {$boq_items_id_s = $boq_items_id[$i]; } else {$boq_items_id_s=0; }            
                                        if(isset($ea_qty[$i]) && !empty($ea_qty[$i])) {$ea_qty_s = $ea_qty[$i]; } else {$ea_qty_s=0; }            
                                        if(isset($scheduled_qty[$i]) && !empty($scheduled_qty[$i])) {$scheduled_qty_s = $scheduled_qty[$i]; } else {$scheduled_qty_s=0; }            
                                        if(isset($o_design_qty[$i]) && !empty($o_design_qty[$i])) {$o_design_qty_s = $o_design_qty[$i]; } else {$o_design_qty_s=0; }            
                                        if(isset($design_qty[$i]) && !empty($design_qty[$i])) {$design_qty_s = $design_qty[$i]; } else {$design_qty_s=0; }            
                                        if(isset($non_schedule[$i]) && !empty($non_schedule[$i]) && $non_schedule[$i] == 'Yes') {$non_schedule_s = 'Y'; } else {$non_schedule_s='N'; }            
                                                
                                        if(isset($boq_code_s) && !empty($boq_code_s) && isset($item_description_s) && !empty($item_description_s) 
                                        && isset($ea_qty_s) && !empty($ea_qty_s)){

                                        $qr_array = array('project_id' =>$project_id,'boq_code'=>$boq_code_s);
                                        $bom_items_data = $this->common_model->selectDetailsWhereArrBom('tbl_bom_items',$qr_array);

                                       
                                        //check EA Item Exist
                                        $newAdd = 0;    
                                        $boq_exceptional_item = $this->admin_model->get_boq_exceptional_item($project_id,$boq_code_s);
                                        if(isset($boq_exceptional_item) && empty($boq_exceptional_item)){
                                            $newAdd = 1;    
                                        }
                                        if($action = 'save'){
                                            $delete_boq_save_arr[] = $boq_code_s;
                                        }
                                        if($ea_qty_s > 0 && $excep_id > 0 && !empty($pos_exceptional_no) && $non_schedule_s == 'N'){
                                            if($action = 'update'){
                                                $delete_boq_arr[] = array('exceptional_id'=>$excep_id,'display'=>'N');
                                            }
                                            $save_exceptional_arr[] = array('exceptional_id'=>$excep_id,'boq_items_id'=>$boq_items_id_s,'project_id'=>$project_id,'boq_code'=>$boq_code_s,
                                            'hsn_sac_code'=>$hsn_sac_code_s,'unit'=>$unit_s,'rate_basic'=>$rate_basic_s,'gst'=>$gst_s,
                                            'scheduled_qty'=>$scheduled_qty_s,'o_design_qty'=>$o_design_qty_s,'design_qty'=>$design_qty_s,
                                            'non_schedule'=>$non_schedule_s,
                                            'item_description'=>$item_description_s,'EA_qty'=>$ea_qty_s,
                                            'PO_taxable_amt'=>$PO_taxable_amt,'gst_rate'=>$gst_rate,'gst_amount'=>$gst_amount,
                                            'po_final_amount'=>$po_final_amount,'po_doc'=>$po_doc_file,'updated_by'=>$user_id,
                                            'updated_at'=>date('Y-m-d H:i:s'),'created_by'=>$user_id,
                                            'created_at'=>date('Y-m-d H:i:s'),'status'=>'pending','newAdd'=>$newAdd,'billable'=>$billable,
                                            'exceptional_no'=>$pos_exceptional_no,'exceptional_inc'=>$pos_except_inc,'except_type'=>'positive',
                                            'newAdd'=>$newAdd);
                                            
                                            if(isset($bom_items_data) && !empty($bom_items_data)) {
                                                foreach ($bom_items_data as $key => $bom_items) {
                                                    if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }
                                                    if(isset($bom_items->bom_ratio) && !empty($bom_items->bom_ratio)) { $bom_ratio = $bom_items->bom_ratio; }else { $bom_ratio = ''; }
                                                    
                                                    $total_bom_release_qty = $bom_ratio * $ea_qty_s;

                                                    $bom_exception_arr[] = array(
                                                        'project_id' => $project_id,
                                                        'boq_code' => $boq_code_s,
                                                        'bom_code' => $bom_code,
                                                        'qty' =>  $total_bom_release_qty,
                                                        'display' => 'Y',
                                                        'created_at' => date('Y-m-d H:i:s'),
                                                        'created_by' => $user_id,
                                                        'updated_at' => date('Y-m-d H:i:s'),
                                                        'updated_by' => $user_id,
                                                        'status' => 'pending',
                                                    );
                                                }
                                            }
                                        }

                                        if($ea_qty_s < 0 && $neg_excep_id > 0 && !empty($neg_exceptional_no)){
                                            if($action = 'update'){
                                                $delete_boq_arr[] = array('exceptional_id'=>$neg_excep_id,'display'=>'N');
                                            }
                                            $save_neg_exceptional_arr[] = array('exceptional_id'=>$neg_excep_id,'boq_items_id'=>$boq_items_id_s,
                                            'project_id'=>$project_id,'boq_code'=>$boq_code_s,
                                            'hsn_sac_code'=>$hsn_sac_code_s,'unit'=>$unit_s,'rate_basic'=>$rate_basic_s,'gst'=>$gst_s,
                                            'scheduled_qty'=>$scheduled_qty_s,'o_design_qty'=>$o_design_qty_s,'design_qty'=>$design_qty_s,
                                            'non_schedule'=>$non_schedule_s,
                                            'item_description'=>$item_description_s,'EA_qty'=>$ea_qty_s,
                                            'PO_taxable_amt'=>$PO_taxable_amt,'gst_rate'=>$gst_rate,'gst_amount'=>$gst_amount,
                                            'po_final_amount'=>$po_final_amount,'po_doc'=>$po_doc_file,'updated_by'=>$user_id,
                                            'updated_at'=>date('Y-m-d H:i:s'),'created_by'=>$user_id,
                                            'created_at'=>date('Y-m-d H:i:s'),'status'=>'pending','newAdd'=>$newAdd,'billable'=>$billable,
                                            'exceptional_no'=>$neg_exceptional_no,'exceptional_inc'=>$neg_except_inc,'except_type'=>'negative',
                                            'newAdd'=>$newAdd); 

                                            if(isset($bom_items_data) && !empty($bom_items_data)) {
                                                foreach ($bom_items_data as $key => $bom_items) {
                                                    if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }
                                                    if(isset($bom_items->bom_ratio) && !empty($bom_items->bom_ratio)) { $bom_ratio = $bom_items->bom_ratio; }else { $bom_ratio = ''; }
                                                    $total_bom_release_qty = $bom_ratio * $ea_qty_s;

                                                    $bom_neg_exception_arr[] = array(
                                                        'project_id' => $project_id,
                                                        'boq_code' => $boq_code_s,
                                                        'bom_code' => $bom_code,
                                                        'qty' =>  $total_bom_release_qty,
                                                        'display' => 'Y',
                                                        'created_at' => date('Y-m-d H:i:s'),
                                                        'created_by' => $user_id,
                                                        'updated_at' => date('Y-m-d H:i:s'),
                                                        'updated_by' => $user_id,
                                                        'status' => 'pending',
                                                    );
                                                }
                                            }
                                        }

                                        if($ea_qty_s > 0 && $ns_excep_id > 0 && !empty($ns_exceptional_no) && $non_schedule_s == 'Y'){
                                            if($action = 'update'){
                                                $delete_boq_arr[] = array('exceptional_id'=>$ns_excep_id,'display'=>'N');
                                            }
                                            $save_ns_exceptional_arr[] = array('exceptional_id'=>$ns_excep_id,'boq_items_id'=>$boq_items_id_s,
                                            'project_id'=>$project_id,'boq_code'=>$boq_code_s,
                                            'hsn_sac_code'=>$hsn_sac_code_s,'unit'=>$unit_s,'rate_basic'=>$rate_basic_s,'gst'=>$gst_s,
                                            'scheduled_qty'=>$scheduled_qty_s,'o_design_qty'=>$o_design_qty_s,'design_qty'=>$design_qty_s,
                                            'non_schedule'=>$non_schedule_s,
                                            'item_description'=>$item_description_s,'EA_qty'=>$ea_qty_s,
                                            'PO_taxable_amt'=>$PO_taxable_amt,'gst_rate'=>$gst_rate,'gst_amount'=>$gst_amount,
                                            'po_final_amount'=>$po_final_amount,'po_doc'=>$po_doc_file,'updated_by'=>$user_id,
                                            'updated_at'=>date('Y-m-d H:i:s'),'created_by'=>$user_id,
                                            'created_at'=>date('Y-m-d H:i:s'),'status'=>'pending','newAdd'=>$newAdd,'billable'=>$billable,
                                            'exceptional_no'=>$ns_exceptional_no,'exceptional_inc'=>$ns_except_inc,'except_type'=>'ns_yes',
                                            'newAdd'=>$newAdd); 

                                            if(isset($bom_items_data) && !empty($bom_items_data)) {
                                                foreach ($bom_items_data as $key => $bom_items) {
                                                    if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }
                                                    if(isset($bom_items->design_qty) && !empty($bom_items->design_qty)) { $bom_d_qty = $bom_items->design_qty; }else { $bom_d_qty = ''; }
                                                    if(isset($bom_items->bom_ratio) && !empty($bom_items->bom_ratio)) { $bom_ratio = $bom_items->bom_ratio; }else { $bom_ratio = ''; }
                                                    $total_bom_release_qty = $bom_ratio * $ea_qty_s;

                                                    $bom_ns_exception_arr[] = array(
                                                        'project_id' => $project_id,
                                                        'boq_code' => $boq_code_s,
                                                        'bom_code' => $bom_code,
                                                        'qty' =>  $total_bom_release_qty,
                                                        'display' => 'Y',
                                                        'created_at' => date('Y-m-d H:i:s'),
                                                        'created_by' => $user_id,
                                                        'updated_at' => date('Y-m-d H:i:s'),
                                                        'updated_by' => $user_id,
                                                        'status' => 'pending',
                                                    );
                                                }
                                            }
                                        }
                                    }
                                }

                               
                                if(!empty($save_neg_exceptional_arr) || !empty($save_exceptional_arr) || !empty($save_ns_exceptional_arr)){
                                if(isset($delete_boq_save_arr) && !empty($delete_boq_save_arr)){
                                    $this->admin_model->deleteBOQExceptionalOldItem($delete_boq_save_arr,$project_id);
                                }
                                if(isset($delete_boq_arr) && !empty($delete_boq_arr)){
                                    $this->admin_model->updateMultiData('tbl_boq_exceptional',$delete_boq_arr,'exceptional_id');
                                }
                                if(isset($save_ns_exceptional_arr) && !empty($save_ns_exceptional_arr)){
                                    $ns_exceptional_no = $save_ns_exceptional_arr[0]['exceptional_no'];
                                    $ns_exceptional_id = $save_ns_exceptional_arr[0]['exceptional_id'];
                                    $event_name = 'NS BOQ Exceptional Approval';
                                    $BOQTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,'exceptional_no'=>$ns_exceptional_no,
                                    'exceptional_id'=>$ns_exceptional_id,'event_type'=>'boq_exceptional_appr','created_date'=>date('Y-m-d H:i:s'),
                                    'created_by'=>$user_id,'updated_by'=>$user_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending',
                                    'approved_by'=>0,'approved_date'=>'');
                                    $transaction_id = $this->common_model->addData('tbl_boq_transactions',$BOQTransArr);
                                    if($transaction_id){
                                        foreach($save_ns_exceptional_arr as $key => $csm){
                                			$save_ns_exceptional_arr[$key]['transaction_id'] = $transaction_id;
                                           
                                		}
                                        foreach($bom_ns_exception_arr as $key => $csm){
                                			$bom_ns_exception_arr[$key]['transaction_id'] = $transaction_id;
                                		}
                                     
                                		$this->common_model->SaveMultiData('tbl_boq_exceptional',$save_ns_exceptional_arr);
                                        if(!empty($bom_ns_exception_arr)) {
                                            $this->common_model->SaveMultiData('tbl_bom_exceptional',$bom_ns_exception_arr);
                                        }
                                    }
                                }
                                if(isset($save_neg_exceptional_arr) && !empty($save_neg_exceptional_arr)){
                                    $neg_exceptional_no = $save_neg_exceptional_arr[0]['exceptional_no'];
                                    $neg_exceptional_id = $save_neg_exceptional_arr[0]['exceptional_id'];
                                    $event_name = 'Negative BOQ Exceptional Approval';
                                    $BOQTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,'exceptional_no'=>$neg_exceptional_no,
                                    'exceptional_id'=>$neg_exceptional_id,'event_type'=>'boq_exceptional_appr','created_date'=>date('Y-m-d H:i:s'),
                                    'created_by'=>$user_id,'updated_by'=>$user_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending',
                                    'approved_by'=>0,'approved_date'=>'');
                                    $transaction_id = $this->common_model->addData('tbl_boq_transactions',$BOQTransArr);
                                    if($transaction_id){
                                        foreach($save_neg_exceptional_arr as $key => $csm){
                                			$save_neg_exceptional_arr[$key]['transaction_id'] = $transaction_id;
                                		}
                                        foreach($bom_neg_exception_arr as $key => $csm){
                                			$bom_neg_exception_arr[$key]['transaction_id'] = $transaction_id;
                                		}
                                		$this->common_model->SaveMultiData('tbl_boq_exceptional',$save_neg_exceptional_arr);
                                        
                                        if(!empty($bom_neg_exception_arr)) {
                                            $this->common_model->SaveMultiData('tbl_bom_exceptional',$bom_neg_exception_arr);
                                        }
                                    }
                                }


                                if(isset($save_exceptional_arr) && !empty($save_exceptional_arr)){
                                    $exceptional_no = $save_exceptional_arr[0]['exceptional_no'];
                                    $exceptional_id = $save_exceptional_arr[0]['exceptional_id'];
                                    $event_name = 'Positive BOQ Exceptional Approval';
                                    $BOQTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,'exceptional_no'=>$exceptional_no,
                                    'exceptional_id'=>$exceptional_id,'event_type'=>'boq_exceptional_appr','created_date'=>date('Y-m-d H:i:s'),
                                    'created_by'=>$user_id,'updated_by'=>$user_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending',
                                    'approved_by'=>0,'approved_date'=>'');
                                    $transaction_id = $this->common_model->addData('tbl_boq_transactions',$BOQTransArr);
                                    if($transaction_id){
                                            foreach($save_exceptional_arr as $key => $csm){
                                                $save_exceptional_arr[$key]['transaction_id'] = $transaction_id;
                                            }
                                            foreach($bom_exception_arr as $key => $csm){
                                                $bom_exception_arr[$key]['transaction_id'] = $transaction_id;
                                            }
                                          
                                            $this->common_model->SaveMultiData('tbl_boq_exceptional',$save_exceptional_arr);
                                            if(!empty($bom_exception_arr)) {
                                                $this->common_model->SaveMultiData('tbl_bom_exceptional',$bom_exception_arr);
                                            }
                                        }
                                    }

                                    
                                    $this->json->jsonReturn(array(
                                        'valid'=>TRUE,
                                        'msg'=>'<div class="alert modify alert-success"> BOQ Exceptional Approval Details Saved Successfully!</div>',
                                        'redirect' => base_url().'boq-exceptional-approval'
                                    ));  
                                }else{
                                    $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger">Please Enter Valid BOQ Exceptional Approval Details!!</div>'
                                    ));    
                                }
                            }else{
                                $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                                ));
                            }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                            ));
                        }
                    }
                }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
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
    }else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">Please LoggedIn!</div>'
            )); 
    }
    }
    public function save_boq_item_details() 
    {
        $save_arr = array();
        $save_stock_arr = array();
        $update_stock_arr = array();
        $save_exceptional_arr = array();
        $project_id = $this->input->post('project_id');
        if(isset($project_id) && !empty($project_id)){
            $steps = $this->admin_model->getTotalBoqTransactionCnt($project_id);
            if(isset($steps) && $steps !='no'){
    		    $steps = $steps + 1;
    		}else{
    		    $steps = 0;
    	    }
            $error = 'N';
            $error_message = '';
            $user_id = $this->session->userdata('user_id');
            if(isset($user_id) && empty($user_id)){
            $error = 'Y';
            $error_message = 'Please loggedin!';
            }
            $boq_code = $this->input->post('boq_code');
            if(isset($boq_code) && !empty($boq_code)) {$boq_code = $boq_code; } else {$boq_code=''; }
            if(isset($boq_code) && empty($boq_code)){
            $error = 'Y';
            $error_message = 'Please enter BOQ Sr No!';
            }
            $hsn_sac_code = $this->input->post('hsn_sac_code');
            if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
            if(isset($hsn_sac_code) && empty($hsn_sac_code)){
            $error = 'Y';
            $error_message = 'Please enter HSN/SAC Code!';
            }
            $item_description = $this->input->post('item_description');
            if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
            if(isset($item_description) && empty($item_description)){
            $error = 'Y';
            $error_message = 'Please enter Item Description!';
            }
            $unit = $this->input->post('unit');
            if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
            if(isset($unit) && empty($unit)){
            $error = 'Y';
            $error_message = 'Please enter Unit!';
            }
            $scheduled_qty = $this->input->post('scheduled_qty');
            if(isset($scheduled_qty) && !empty($scheduled_qty)) {$scheduled_qty = $scheduled_qty; } else {$scheduled_qty=''; }
            if(isset($scheduled_qty) && empty($scheduled_qty)){
            $error = 'Y';
            $error_message = 'Please enter Scheduled Qty!';
            }
            $design_qty = $this->input->post('design_qty');
            if(isset($design_qty) && !empty($design_qty)) {$design_qty = $design_qty; } else {$design_qty=''; }
            if(isset($design_qty) && empty($design_qty)){
            $error = 'Y';
            $error_message = 'Please enter Design Qty!';
            }
            $rate_basic = $this->input->post('rate_basic');
            if(isset($rate_basic) && !empty($rate_basic)) {$rate_basic = $rate_basic; } else {$rate_basic=''; }
            if(isset($rate_basic) && empty($rate_basic)){
            $error = 'Y';
            $error_message = 'Please enter Rate Basic!';
            }
            $gst = $this->input->post('gst');
            if(isset($gst) && !empty($gst)) {$gst = $gst; } else {$gst=''; }
            $non_schedule = $this->input->post('non_schedule');
            if(isset($non_schedule) && !empty($non_schedule)) {$non_schedule = $non_schedule; } else {$non_schedule=''; }
            if(isset($boq_code) && empty($boq_code)
            && isset($hsn_sac_code) && empty($hsn_sac_code)
            && isset($item_description) && empty($item_description)
            && isset($unit) && empty($unit)
            && isset($scheduled_qty) && empty($scheduled_qty)
            && isset($design_qty) && empty($design_qty)
            && isset($rate_basic) && empty($rate_basic)){
                $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger">Please Enter BOQ Items Details!!</div>'
                ));    
            }else{
                if($error == 'N'){
                    if(isset($boq_code) && !empty($boq_code)){
                        for($i=0;$i<count($boq_code);$i++){
                            if(isset($boq_code[$i]) && !empty($boq_code[$i])) {$boq_code_s = $boq_code[$i]; } else {$boq_code_s=''; }
                            if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
                            if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }            
                            if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }            
                            if(isset($scheduled_qty[$i]) && !empty($scheduled_qty[$i])) {$scheduled_qty_s = $scheduled_qty[$i]; } else {$scheduled_qty_s=0; }            
                            if(isset($design_qty[$i]) && !empty($design_qty[$i])) {$design_qty_s = $design_qty[$i]; } else {$design_qty_s=0; }            
                            if(isset($rate_basic[$i]) && !empty($rate_basic[$i])) {$rate_basic_s = str_replace(',', '', $rate_basic[$i]); } else {$rate_basic_s=0; }            
                            if(isset($gst[$i]) && !empty($gst[$i])) {$gst_s = $gst[$i]; } else {$gst_s='0'; }            
                            if(isset($non_schedule[$i]) && !empty($non_schedule[$i])) {$non_schedule_s = $non_schedule[$i]; } else {$non_schedule_s ='N'; }
                            
                            if(isset($boq_code_s) && !empty($boq_code_s)
                            && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s)
                            && isset($item_description_s) && !empty($item_description_s)
                            && isset($unit_s) && !empty($unit_s)
                            && isset($scheduled_qty_s) && isset($design_qty_s) && isset($rate_basic_s) && !empty($rate_basic_s)){
                                $existData = $this->admin_model->get_boq_item_details($project_id,$boq_code_s);
                                //check BOQ Exceptional Pending
                                $boq_exceptional_status = 'N';
                                $boq_exceptional_item = $this->admin_model->get_boq_exceptional_item($project_id,$boq_code_s);
                                if(isset($boq_exceptional_item) && empty($boq_exceptional_item)){
                                    $boq_exceptional_status = 'Y';
                                }else{
                                    $boq_exceptional_item_p = $this->admin_model->get_boq_exceptional_item_pending($project_id,$boq_code_s);
                                    if(isset($boq_exceptional_item_p) && empty($boq_exceptional_item_p)){
                                        $boq_exceptional_status = 'Y';
                                    }
                                }
                                if($boq_exceptional_status == 'Y'){
                                    $o_design_qty = $design_qty_s;
                                    $exist_design_qty = $design_qty_s;
                                    if(isset($existData) && !empty($existData)){
                                        if(isset($existData->o_design_qty) && !empty($existData->o_design_qty) && $existData->o_design_qty > 0){
                                            $o_design_qty = $existData->o_design_qty;    
                                        }
                                        if($design_qty_s != $scheduled_qty_s){
                                            if(isset($existData->design_qty) && !empty($existData->design_qty) && $existData->design_qty > 0){
                                                $exist_design_qty = $existData->design_qty;    
                                            }
                                        }
                                        if(isset($existData->status) && !empty($existData->status) && $existData->status == 'Y'){
                                        $save_arr[] = array('project_id'=>$project_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,
                                        'item_description'=>$item_description_s,'unit'=>$unit_s,'scheduled_qty'=>$scheduled_qty_s,'o_design_qty'=>$o_design_qty,
                                        'design_qty'=>$exist_design_qty,'upload_design_qty'=>$design_qty_s,'rate_basic'=>$rate_basic_s,'gst'=>$gst_s,'non_schedule'=>$non_schedule_s,'created_by'=>$user_id,
                                        'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'steps'=>$steps,'status'=>'N');
                                        }
                                    }else{
                                        $exist_design_qty = 0;
                                        if($design_qty_s == $scheduled_qty_s){
                                        $exist_design_qty = $design_qty_s;    
                                        }
                                    $save_arr[] = array('project_id'=>$project_id,'boq_code'=>$boq_code_s,'hsn_sac_code'=>$hsn_sac_code_s,
                                    'item_description'=>$item_description_s,'unit'=>$unit_s,'scheduled_qty'=>$scheduled_qty_s,'o_design_qty'=>$o_design_qty,
                                    'design_qty'=>$exist_design_qty,'upload_design_qty'=>$design_qty_s,'rate_basic'=>$rate_basic_s,'gst'=>$gst_s,'non_schedule'=>$non_schedule_s,'created_by'=>$user_id,
                                    'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'steps'=>$steps,'status'=>'N');
                                    }
                                }    
                            }
                        }
                    }
                    if(isset($save_arr) && !empty($save_arr)){
                        $event_name = 'BOQ Item Added';
        				$BOQTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,
        				'event_type'=>'add_edit_boq','created_date'=>date('Y-m-d H:i:s'),'created_by'=>$user_id,
        				'updated_by'=>$user_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending');
        				$transaction_id = $this->common_model->addData('tbl_boq_transactions',$BOQTransArr);
        				if($transaction_id > 0){
        				    foreach($save_arr as $key => $csm){
        				        $save_arr[$key]['transaction_id'] = $transaction_id;
        				    }
            				$this->common_model->SaveMultiData('tbl_boq_items',$save_arr);
                            $this->json->jsonReturn(array(
                                'valid'=>TRUE,
                                'msg'=>'<div class="alert modify alert-success">BOQ Items Details Saved Successfully!</div>',
                                'redirect' => base_url().'add-boq-items'
                            ));
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">Please Enter Valid BOQ Items Details!!</div>'
                            ));    
                        }
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">Please Enter Valid BOQ Items Details!!</div>'
                        ));    
                    }
                }else{
                    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                    ));
                }
            }
        }else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger">Please Select Project!</div>'
            ));    
        }
    }
    public function save_boq_file_data()
    {
    	$id=$this->input->post('id');
        $project_code =$this->input->post('project_code');
        $boq_code =$this->input->post('boq_code');
        $boq_item_file =$this->input->post('boq_item_file');

        $inputFileName ='uploads/upload_boq_file/'.$boq_item_file;
        if(file_exists($inputFileName))
        {
            $object = PHPExcel_IOFactory::load($inputFileName);
            $Errosdata=array();
            foreach($object->getWorksheetIterator() as $worksheet)
            {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=3; $row<$highestRow; $row++)
                {
                    $user_id=$this->session->userdata('user_id');
                    $boq_items=array();
                    $boq_items_srno= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $hsn_sac_code = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $item_description = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $unit = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $scheduled_qty = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $design_qty = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $rate_basic = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $gst = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $unit_basic_amount = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $non_schedule = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    
                    $boq_items = array(
                        'project_code' => $project_code,
                        'boq_code' => $boq_code,
                        'boq_items_srno' => $boq_items_srno,
                        'hsn_sac_code' => $hsn_sac_code, 
                        'item_description' => $item_description,
                        'unit' => $unit,  
                        'scheduled_qty' => $scheduled_qty,
                        'design_qty' => $design_qty,
                        'rate_basic' => $rate_basic,
                        'gst' => $gst,
                        'unit_basic_amount' => $unit_basic_amount,
                        'non_schedule' => $non_schedule,
                        'modified_on'=>date('Y-m-d H:i:s'),
                        'modified_by'=>$user_id, 
                        'display' =>'Y',
                    );
                    $boq_items['created_by']=$user_id;
                    $boq_items['created_on']=date('Y-m-d H:i:s');
                    $result=$this->common_model->addData('tbl_boq_items',$boq_items);
                }
                if($result)
                {
                    $this->json->jsonReturn(array(
                        'valid'=>TRUE,
                        'msg'=>'<div class="alert modify alert-success"><strong>Welldone!</strong> BOQ Items Details Saved Successfully.</div>',
                        'redirect' => base_url().'list-boq-items'
                    ));
                }
            }
        }
        else
        {
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Oops!</strong> File Does not exist.</div>'
            ));
        }
    }
    public function client_delivery_challan() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','client-delivery-challan');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_update = 'N';
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_client_dc_details');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                    $data['check_permission_update'] = $check_permission_update;
                    $this->load->view('client-delivery-challan',$data);
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
    public function payment_receipt_details() 
    {
        $id = $this->uri->segment(2);
        if(isset($id) && !empty($id)){
        $id = base64_decode($id);
        }
        $payment_receipt_data = $this->common_model->selectDetailsWhereAllDY('tbl_payment_receipt', 'id',$id);
        if(isset($payment_receipt_data[0]->tax_incv_id) && !empty($payment_receipt_data[0]->tax_incv_id)){
        $data['cess_data'] = $this->common_model->selectDetailsWhereAllDY('tbl_any_o_cess', 'pay_receipt_id',$id);
        $data['deduction_data'] = $this->common_model->selectDetailsWhereAllDY('tbl_any_o_deduction', 'pay_receipt_id',$id);
        $data['deposit_data'] = $this->common_model->selectDetailsWhereAllDY('tbl_any_o_deposit', 'pay_receipt_id',$id);
        $data['other_tax_data'] = $this->common_model->selectDetailsWhereAllDY('tbl_any_o_tax', 'pay_receipt_id',$id);
        $data['withheld_data'] = $this->common_model->selectDetailsWhereAllDY('tbl_withheld', 'pay_receipt_id',$id);
        $tax_invc_no = $this->admin_model->get_invoice_no($payment_receipt_data[0]->tax_incv_id)->tax_invc_no;
        $tax_invc_date = $this->admin_model->get_invoice_no($payment_receipt_data[0]->tax_incv_id)->tax_invc_date;
        // $invoice_amount = $this->admin_model->get_invoice_amount($payment_receipt_data[0]->tax_incv_id);
        
        $tax_invc = $this->common_model->selectDetailsWhr('tbl_tax_invc','tax_invc_id',$payment_receipt_data[0]->tax_incv_id);
            $performa_invc = $this->common_model->selectDetailsWhr('tbl_proforma_invc','proforma_id',$tax_invc->convertid);
            $tax_invc_item = $this->common_model->selectDetailsWhereAll('tbl_tax_invc_items','tax_invc_id',$payment_receipt_data[0]->tax_incv_id);
            // pr($tax_invc_item);
            $sub_total = 0;
            $total_amount = 0 ;
            $gst_amount = 0 ;
            if(isset($tax_invc_item) && !empty($tax_invc_item)){
            foreach($tax_invc_item as $member){
                if($member->gst_type == 'intra-state'){
                  
                    $gst_rate = $member->sgst + $member->cgst;
                     $gst_amount = ($member->taxable_amount * $gst_rate) / 100;
                    $sub_total += $member->taxable_amount;
                   
                    $total_amount += $member->taxable_amount + $gst_amount;
                   
                }else{
                   
                    $member->gst_amount = ($member->taxable_amount * $member->gst) / 100;
                $sub_total += $member->taxable_amount;
                $gst_amount += $member->gst_amount;
                $total_amount += $member->taxable_amount + $member->gst_amount;
                }
              
            }
            }
            $invoice_amount = $total_amount + $performa_invc->auto_round_value;
        if(isset($invoice_amount) && !empty($invoice_amount) && $invoice_amount > 0){
        $invoice_amount = $invoice_amount;
        }else{
        $invoice_amount = 0;
        }
        $data['tax_invc_no'] = $tax_invc_no;
        $data['tax_invc_date'] = $tax_invc_date;
        $data['invoice_amount'] = sprintf('%0.2f', $invoice_amount);
        $data['payment_receipt_data'] = $payment_receipt_data;
       }else{
        $data['cess_data'] = '';
        $data['deduction_data'] = '';
        $data['invoice_amount'] = '';
        $data['deposit_data'] = '';
        $data['other_tax_data'] = '';
        $data['tax_invc_no'] = '';
        $data['tax_invc_date'] = '';
        $data['invoice_amount'] = '';
        $data['payment_receipt_data'] = '';
       }
       $this->load->view('payment-receipt-details',$data);
    }
    
    public function add_virtual_stock() 
    {
        $this->load->view('add-virtual-stock');
    }
    public function add_installed_wip() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','add-installed-wip');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_update = 'N';
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_installed_wip_details');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                    $data['check_permission_update'] = $check_permission_update;
                    $this->load->view('add-installed-wip',$data);
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
    public function add_provisional_wip() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','add-provisional-wip');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_update = 'N';
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_provisional_wip_details');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                    $data['check_permission_update'] = $check_permission_update;
                    $this->load->view('add-provisional-wip',$data);
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
    public function add_boq_items() 
    {
        $this->load->view('add-boq-items');
    }
    public function list_boq_items() 
    {
        $this->load->view('list-boq-items');
    }
    public function list_boq_items_operational_b() 
    {
        $this->load->view('list-boq-items-operational-b');
    }
    public function list_boq_items_operational_b_negative() 
    {
        $this->load->view('list-boq-items-operational-b-negative');
    }
    public function create_proforma_invoice() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','create-proforma-invoice');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_update = 'N';
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_proforma_invoice_details');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                    $data['check_permission_update'] = $check_permission_update;
                    $this->load->view('create-proforma-invoice',$data);
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
    public function create_tax_invoice() 
    {
        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','create-tax-invoice');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $check_permission_update = 'N';
                    $submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_tax_invoice_details');
                    if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
                        $usubmenu_id = $submenu_datau->submenu_id;
                        $check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
                        if(isset($check_permissionu) && !empty($check_permissionu)){
                            $check_permission_update = 'Y';
                        }
                    }
                    $data['check_permission_update'] = $check_permission_update;
                    $this->load->view('create-tax-invoice',$data);
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
    public function save_invoice_closure(){

        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_invoice_closure');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                    $error = 'N';
                    $error_message = '';
                    $user_id = $this->session->userdata('user_id');
                    if(isset($user_id) && empty($user_id)){
                    $error = 'Y';
                    $error_message = 'Please loggedin!';
                    }
                    if(isset($user_id) && !empty($user_id)){
                    $tax_invc_id = $this->input->post('tax_invc_id');
                    if(isset($tax_invc_id) && empty($tax_invc_id)){
                    $error = 'Y';
                    $error_message = 'Invalid Invoice Details!';
                    }
                    $tax_invc_data = $this->admin_model->get_invoice_no($tax_invc_id);
                    if(isset($tax_invc_data) && empty($tax_invc_data)){
                    $error = 'Y';
                    $error_message = 'Invalid Invoice Details!';
                    }
                    $final_received_payment = 0;
                    $received_payment = $this->admin_model->get_invoice_received_payment($tax_invc_id);
                    if(isset($received_payment) && !empty($received_payment) && $received_payment > 0){
                    $received_payment = $received_payment;
                    }else{
                    $received_payment = 0;
                    }
                    //Statutory Deductions
                    $statutory_deductions = 0;
                    $it_tds_amount = $this->admin_model->get_invoice_it_tds_amount($tax_invc_id);
                    if(isset($it_tds_amount) && !empty($it_tds_amount) && $it_tds_amount > 0){
                    $it_tds_amount = $it_tds_amount;
                    }else{
                    $it_tds_amount = 0;
                    }
                    $gtds_amount = $this->admin_model->get_invoice_gtds_amount($tax_invc_id);
                    if(isset($gtds_amount) && !empty($gtds_amount) && $gtds_amount > 0){
                    $gtds_amount = $gtds_amount;
                    }else{
                    $gtds_amount = 0;
                    }
                    $other_tax_deduction_amount = $this->admin_model->get_invoice_other_tax_deduction($tax_invc_id);
                    if(isset($other_tax_deduction_amount) && !empty($other_tax_deduction_amount) && $other_tax_deduction_amount > 0){
                    $other_tax_deduction_amount = $other_tax_deduction_amount;
                    }else{
                    $other_tax_deduction_amount = 0;
                    }
                    $statutory_deductions = $it_tds_amount + $gtds_amount + $other_tax_deduction_amount;
                    
                    //Refundables
                    $security_deposit_retn_amount = $this->admin_model->get_invoice_security_deposit_retn_amount($tax_invc_id);
                    if(isset($security_deposit_retn_amount) && !empty($security_deposit_retn_amount) && $security_deposit_retn_amount > 0){
                    $security_deposit_retn_amount = $security_deposit_retn_amount;
                    }else{
                    $security_deposit_retn_amount = 0;
                    }

                    $retenstion_amount = $this->admin_model->get_invoice_retn_amount($tax_invc_id);
                    if(isset($retenstion_amount) && !empty($retenstion_amount) && $retenstion_amount > 0){
                    $retenstion_amount = $retenstion_amount;
                    }else{
                    $retenstion_amount = 0;
                    }


                    $other_deposit_amount = $this->admin_model->get_invoice_other_deposit($tax_invc_id);
                    if(isset($other_deposit_amount) && !empty($other_deposit_amount) && $other_deposit_amount > 0){
                    $other_deposit_amount = $other_deposit_amount;
                    }else{
                    $other_deposit_amount = 0;
                    }
                    $withheld_amount = $this->admin_model->get_invoice_withheld($tax_invc_id);
                    if(isset($withheld_amount) && !empty($withheld_amount) && $withheld_amount > 0){
                    $withheld_amount = $withheld_amount;
                    }else{
                    $withheld_amount = 0;
                    }
                    $refundables = $security_deposit_retn_amount + $other_deposit_amount + $withheld_amount  + $retenstion_amount;
                    
                    //Non-Refundables
                    $labour_cess_amount = $this->admin_model->get_invoice_labour_cess($tax_invc_id);
                    if(isset($labour_cess_amount) && !empty($labour_cess_amount) && $labour_cess_amount > 0){
                    $labour_cess_amount = $labour_cess_amount;
                    }else{
                    $labour_cess_amount = 0;
                    }
                    $other_cess_amount = $this->admin_model->get_invoice_other_cess($tax_invc_id);
                    if(isset($other_cess_amount) && !empty($other_cess_amount) && $other_cess_amount > 0){
                    $other_cess_amount = $other_cess_amount;
                    }else{
                    $other_cess_amount = 0;
                    }
                    $other_deductions_amount = $this->admin_model->get_invoice_other_deductions($tax_invc_id);
                    if(isset($other_deductions_amount) && !empty($other_deductions_amount) && $other_deductions_amount > 0){
                    $other_deductions_amount = $other_deductions_amount;
                    }else{
                    $other_deductions_amount = 0;
                    }
                    $nonrefundables = $labour_cess_amount + $other_cess_amount + $other_deductions_amount;
                    $final_received_payment = $received_payment + $nonrefundables + $refundables + $statutory_deductions;
                    
                    $invoice_amount = $this->admin_model->get_invoice_amount($tax_invc_id);
                    if(isset($invoice_amount) && !empty($invoice_amount) && $invoice_amount > 0){
                    $invoice_amount = $invoice_amount;
                    }else{
                    $invoice_amount = 0;
                    }
                    $diff = sprintf('%0.2f',$invoice_amount) - sprintf('%0.2f',$final_received_payment);

                    if(isset($invoice_amount) && empty($invoice_amount) && $invoice_amount == 0){
                    $error = 'Y';
                    $error_message = 'Invalid Invoice Amount!';
                    }
                    if(isset($final_received_payment) && empty($final_received_payment) && $final_received_payment == 0){
                    $error = 'Y';
                    $error_message = 'Payment Received Amount must be equal to Invoice Amount!';
                    }
                    if($invoice_amount!=$final_received_payment && $diff > 0){
                    $error = 'Y';
                    $error_message = 'Payment Received Amount must be equal to Invoice Amount!';
                    }
                    $gtds_confirm_date = $this->input->post('gtds_confirm_date');
                    if(isset($gtds_confirm_date) && empty($gtds_confirm_date)){
                    $error = 'Y';
                    $error_message = 'Please enter GTDS Confirmation Date!';
                    }else{
                    $gtds_confirm_date = date('Y-m-d',strtotime($gtds_confirm_date));    
                    }
                    $gtds_return_date = $this->input->post('gtds_return_date');
                    if(isset($gtds_return_date) && empty($gtds_return_date)){
                    $error = 'Y';
                    $error_message = 'Please enter GTDS Return Date!';
                    }else{
                    $gtds_return_date = date('Y-m-d',strtotime($gtds_return_date));    
                    }
                    $gtds_doc_file = '';
                    if(isset($_FILES['gtds_doc']['name']) && !empty($_FILES['gtds_doc']['name'])){
                        $gtds_doc_fileImg = 
                                array('upload_path' =>'./uploads/invoice_closure/',
                                'fieldname' => 'gtds_doc',
                                'encrypt_name' => TRUE,        
                                'overwrite' => FALSE,
                                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                        $gtds_doc_file_img = $this->imageupload->image_upload($gtds_doc_fileImg);
                        $errormsg= $this->upload->display_errors();
                        if(isset($gtds_doc_file_img) && !empty($gtds_doc_file_img)){
                            $gtds_doc_fileData = $this->upload->data();      
                            $gtds_doc_file = $gtds_doc_fileData['file_name'];
                        }else{
                            $gtds_doc_file = '';
                        }    
                    }else{
                        if(isset($tax_invc_data->gtds_doc) && !empty($tax_invc_data->gtds_doc)){
                            $gtds_doc_file = $tax_invc_data->gtds_doc;    
                        }else{
                            $error = 'Y';
                            $error_message = 'Please upload TDS Document!';
                        }
                    }
                    $it_tds_confirm_date = $this->input->post('it_tds_confirm_date');
                    if(isset($it_tds_confirm_date) && empty($it_tds_confirm_date)){
                    $error = 'Y';
                    $error_message = 'Please enter TDS Confirmation Date!';
                    }else{
                    $it_tds_confirm_date = date('Y-m-d',strtotime($it_tds_confirm_date));    
                    }
                    $it_tds_doc_file = '';
                    if(isset($_FILES['it_tds_doc']['name']) && !empty($_FILES['it_tds_doc']['name'])){
                        $it_tds_doc_fileImg = 
                                array('upload_path' =>'./uploads/invoice_closure/',
                                'fieldname' => 'it_tds_doc',
                                'encrypt_name' => TRUE,        
                                'overwrite' => FALSE,
                                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                        $it_tds_doc_file_img = $this->imageupload->image_upload($it_tds_doc_fileImg);
                        $errormsg= $this->upload->display_errors();
                        if(isset($it_tds_doc_file_img) && !empty($it_tds_doc_file_img)){
                            $it_tds_doc_fileData = $this->upload->data();      
                            $it_tds_doc_file = $it_tds_doc_fileData['file_name'];
                        }else{
                            $it_tds_doc_file = '';
                        }    
                    }else{
                        if(isset($tax_invc_data->it_tds_doc) && !empty($tax_invc_data->it_tds_doc)){
                            $it_tds_doc_file = $tax_invc_data->it_tds_doc;    
                        }else{
                            $error = 'Y';
                            $error_message = 'Please upload TDS Document!';
                        }
                    }
                    $other_tds_confirm_date = $this->input->post('other_tds_confirm_date');
                    if(isset($other_tds_confirm_date) && !empty($other_tds_confirm_date)){
                    $other_tds_confirm_date = date('Y-m-d',strtotime($other_tds_confirm_date));    
                    }else{
                    $other_tds_confirm_date = '';    
                    }
                    $other_tds_doc_file = '';
                    $other_tds_doc = $_FILES['other_tds_doc']['name'];
                    if(isset($other_tds_doc) && !empty($other_tds_doc)){
                        $other_tds_doc = $_FILES['other_tds_doc']['name'];
                        $other_tds_doc_fileImg = 
                                array('upload_path' =>'./uploads/invoice_closure/',
                                'fieldname' => 'other_tds_doc',
                                'encrypt_name' => TRUE,        
                                'overwrite' => FALSE,
                                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                        $other_tds_doc_file_img = $this->imageupload->image_upload($other_tds_doc_fileImg);
                        $errormsg= $this->upload->display_errors();
                        if(isset($other_tds_doc_file_img) && !empty($other_tds_doc_file_img)){
                            $other_tds_doc_fileData = $this->upload->data();      
                            $other_tds_doc_file = $other_tds_doc_fileData['file_name'];
                        }else{
                            $other_tds_doc_file = '';
                        }
                    }else{
                        if(isset($tax_invc_data->other_tds_doc) && empty($tax_invc_data->other_tds_doc)){
                            $other_tds_doc_file = '';
                        }else{
                            $other_tds_doc_file = $tax_invc_data->other_tds_doc;    
                        }
                    }
                    $statutory_deductions_date = $this->input->post('statutory_deductions_date');
                    if(isset($statutory_deductions_date) && empty($statutory_deductions_date)){
                    $error = 'Y';
                    $error_message = 'Please enter Security Deposit Retention Bank Credit Date!';
                    }else{
                    $statutory_deductions_date = date('Y-m-d',strtotime($statutory_deductions_date));    
                    }
                    $statutory_deductions_doc_file = '';
                    if(isset($_FILES['statutory_deductions_doc']['name']) && !empty($_FILES['statutory_deductions_doc']['name'])){
                        $statutory_deductions_doc_fileImg = 
                                array('upload_path' =>'./uploads/invoice_closure/',
                                'fieldname' => 'statutory_deductions_doc',
                                'encrypt_name' => TRUE,        
                                'overwrite' => FALSE,
                                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                        $statutory_deductions_doc_file_img = $this->imageupload->image_upload($statutory_deductions_doc_fileImg);
                        $errormsg= $this->upload->display_errors();
                        if(isset($statutory_deductions_doc_file_img) && !empty($statutory_deductions_doc_file_img)){
                            $statutory_deductions_doc_fileData = $this->upload->data();      
                            $statutory_deductions_doc_file = $statutory_deductions_doc_fileData['file_name'];
                        }else{
                            $statutory_deductions_doc_file = '';
                        }    
                    }else{
                        if(isset($tax_invc_data->statutory_deductions_doc) && !empty($tax_invc_data->statutory_deductions_doc)){
                            $statutory_deductions_doc_file = $tax_invc_data->statutory_deductions_doc;    
                        }else{
                            $error = 'Y';
                            $error_message = 'Please upload TDS Document!';
                        }
                    }
                    $deposit_confirm_date = $this->input->post('deposit_confirm_date');
                    if(isset($deposit_confirm_date) && !empty($deposit_confirm_date)){
                    $deposit_confirm_date = date('Y-m-d',strtotime($deposit_confirm_date));    
                    }else{
                    $deposit_confirm_date = '';    
                    }
                    $deposit_confirm_doc_file = '';
                    $deposit_confirm_doc = $_FILES['deposit_confirm_doc']['name'];
                    if(isset($deposit_confirm_doc) && !empty($deposit_confirm_doc)){
                        $deposit_confirm_doc = $_FILES['deposit_confirm_doc']['name'];
                        $deposit_confirm_doc_fileImg = 
                                array('upload_path' =>'./uploads/invoice_closure/',
                                'fieldname' => 'deposit_confirm_doc',
                                'encrypt_name' => TRUE,        
                                'overwrite' => FALSE,
                                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                        $deposit_confirm_doc_file_img = $this->imageupload->image_upload($deposit_confirm_doc_fileImg);
                        $errormsg= $this->upload->display_errors();
                        if(isset($deposit_confirm_doc_file_img) && !empty($deposit_confirm_doc_file_img)){
                            $deposit_confirm_doc_fileData = $this->upload->data();      
                            $deposit_confirm_doc_file = $deposit_confirm_doc_fileData['file_name'];
                        }else{
                            $deposit_confirm_doc_file = '';
                        }
                    }else{
                        if(isset($tax_invc_data->deposit_confirm_doc) && empty($tax_invc_data->deposit_confirm_doc)){
                            $deposit_confirm_doc_file = '';
                        }else{
                            $deposit_confirm_doc_file = $tax_invc_data->deposit_confirm_doc;    
                        }
                    }
                    $withheld_confirm_date = $this->input->post('withheld_confirm_date');
                    if(isset($withheld_confirm_date) && !empty($withheld_confirm_date)){
                    $withheld_confirm_date = date('Y-m-d',strtotime($withheld_confirm_date));    
                    }else{
                    $withheld_confirm_date = '';    
                    }
                    $withheld_confirm_doc_file = '';
                    $withheld_confirm_doc = $_FILES['withheld_confirm_doc']['name'];
                    if(isset($withheld_confirm_doc) && !empty($withheld_confirm_doc)){
                        $withheld_confirm_doc = $_FILES['withheld_confirm_doc']['name'];
                        $withheld_confirm_doc_fileImg = 
                                array('upload_path' =>'./uploads/invoice_closure/',
                                'fieldname' => 'withheld_confirm_doc',
                                'encrypt_name' => TRUE,        
                                'overwrite' => FALSE,
                                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                        $withheld_confirm_doc_file_img = $this->imageupload->image_upload($withheld_confirm_doc_fileImg);
                        $errormsg= $this->upload->display_errors();
                        if(isset($withheld_confirm_doc_file_img) && !empty($withheld_confirm_doc_file_img)){
                            $withheld_confirm_doc_fileData = $this->upload->data();      
                            $withheld_confirm_doc_file = $withheld_confirm_doc_fileData['file_name'];
                        }else{
                            $withheld_confirm_doc_file = '';
                        }
                    }else{
                        if(isset($tax_invc_data->withheld_confirm_doc) && empty($tax_invc_data->withheld_confirm_doc)){
                            $withheld_confirm_doc_file = '';
                        }else{
                            $withheld_confirm_doc_file = $tax_invc_data->withheld_confirm_doc;    
                        }
                    }
                    $upload_anydepo_doc_file = '';
                    $upload_anydepo_doc = $_FILES['upload_anydepo_doc']['name'];
                    if(isset($upload_anydepo_doc) && !empty($upload_anydepo_doc)){
                        $upload_anydepo_doc = $_FILES['upload_anydepo_doc']['name'];
                        $upload_anydepo_doc_fileImg = 
                                array('upload_path' =>'./uploads/invoice_closure/',
                                'fieldname' => 'upload_anydepo_doc',
                                'encrypt_name' => TRUE,        
                                'overwrite' => FALSE,
                                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                        $upload_anydepo_doc_file_img = $this->imageupload->image_upload($upload_anydepo_doc_fileImg);
                        $errormsg= $this->upload->display_errors();
                        if(isset($upload_anydepo_doc_file_img) && !empty($upload_anydepo_doc_file_img)){
                            $upload_anydepo_doc_fileData = $this->upload->data();      
                            $upload_anydepo_doc_file = $upload_anydepo_doc_fileData['file_name'];
                        }else{
                            $upload_anydepo_doc_file = '';
                        }
                    }else{
                        if(isset($tax_invc_data->upload_anydepo_doc) && empty($tax_invc_data->upload_anydepo_doc)){
                            $upload_anydepo_doc_file = '';
                        }else{
                            $upload_anydepo_doc_file = $tax_invc_data->upload_anydepo_doc;    
                        }
                    }
                    if($error == 'N'){
                        $updateArr = array('gtds_confirm_date'=>$gtds_confirm_date,'gtds_return_date'=>$gtds_return_date,'gtds_doc'=>$gtds_doc_file,
                        'it_tds_confirm_date'=>$it_tds_confirm_date,'it_tds_doc'=>$it_tds_doc_file,'other_tds_confirm_date'=>$other_tds_confirm_date,
                        'other_tds_doc'=>$other_tds_doc_file,'statutory_deductions_date'=>$statutory_deductions_date,'statutory_deductions_doc'=>$statutory_deductions_doc_file,
                        'deposit_confirm_date'=>$deposit_confirm_date,'deposit_confirm_doc'=>$deposit_confirm_doc_file, 'withheld_confirm_date'=>$withheld_confirm_date,
                        'withheld_confirm_doc'=>$withheld_confirm_doc_file, 'upload_anydepo_doc'=>$upload_anydepo_doc_file, 
                        'closure_created_date'=>date('Y-m-d H:i:s'),'closure_created_by'=>$user_id,'invoice_closure'=>'Y');
                        $result = $this->common_model->updateDetails('tbl_tax_invc','tax_invc_id',$tax_invc_id,$updateArr);
                        if($result)
                        {
                            $this->json->jsonReturn(array(
                                'valid'=>TRUE,
                                'msg'=>'<div class="alert modify alert-success">Invoice Closure Details Saved Successfully!</div>',
                                'redirect' => base_url().'create-tax-invoice'
                            ));
                        }
                        else
                        {
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While Saving Invoice Closure Details!</div>'
                            ));
                        }
                    }else{
                         $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                        ));    
                    }
                    }else{
                         $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Oops!</strong> Something Went Wrong.</div>'
                        ));    
                    }
                }else{
                    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger"><strong>Oops!</strong> You have no Permission!!.</div>'
                    ));
                }
            }else{
                $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger"><strong>Oops!</strong> You have no Permission!!.</div>'
                ));
            }
		}else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Oops!</strong> You have no Permission!!.</div>'
            ));
        }
		
    }
    public function save_payment_advice(){

        $loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
		    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_payment_advice');
            if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
                $submenu_id = $submenu_data->submenu_id;
                $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
                if(isset($check_permission) && !empty($check_permission)){
                        $error = 'N';
                        $error_message = '';
                        $user_id = $this->session->userdata('user_id');
                        if(isset($user_id) && empty($user_id)){
                        $error = 'Y';
                        $error_message = 'Please loggedin!';
                        }
                        if(isset($user_id) && !empty($user_id)){
                        $tax_invc_id = $this->input->post('tax_invc_id');
                        if(isset($tax_invc_id) && empty($tax_invc_id)){
                        $error = 'Y';
                        $error_message = 'Invali Invoice Details!';
                        }
                        $payment_date = $this->input->post('payment_date');
                        if(isset($payment_date) && empty($payment_date)){
                        $error = 'Y';
                        $error_message = 'Please enter Payment Date!';
                        }else{
                        $payment_date = date('Y-m-d',strtotime($payment_date));
                        }
                        $bank_acc_no = $this->input->post('bank_acc_no');
                        if(isset($bank_acc_no) && empty($bank_acc_no)){
                        $error = 'Y';
                        $error_message = 'Please select Payment Account!';
                        }
                        $payment_received_amount = $this->input->post('payment_received_amount');
                        if(isset($payment_received_amount) && empty($payment_received_amount) && $payment_received_amount > 0){
                        $error = 'Y';
                        $error_message = 'Please enter Payment Amount Received!';
                        }
                        $invoice_date = $this->input->post('invoice_date');
                        if(isset($invoice_date) && empty($invoice_date)){
                        $error = 'Y';
                        $error_message = 'Please enter Invoice Date!';
                        }else{
                        $invoice_date = date('Y-m-d',strtotime($invoice_date));
                        }
                        $invoice_no = $this->input->post('invoice_no');
                        if(isset($invoice_no) && empty($invoice_no)){
                        $error = 'Y';
                        $error_message = 'Please enter Invoice No!';
                        }
                        $invoice_amount = $this->input->post('invoice_amount');
                        if(isset($invoice_amount) && empty($invoice_amount) && $invoice_amount > 0){
                        $error = 'Y';
                        $error_message = 'Please enter Invoice Amount!';
                        }
                        $client_name = $this->input->post('client_name');
                        if(isset($client_name) && empty($client_name)){
                        $error = 'Y';
                        $error_message = 'Please enter Client Name!';
                        }
                        $remark = $this->input->post('remark');                
                        if(isset($remark) && empty($remark)){
                        //$error = 'Y';
                        //$error_message = 'Please enter Remark!';
                        }
                        $it_tds_amount = $this->input->post('it_tds_amount');         
                        if(isset($it_tds_amount) && !empty($it_tds_amount) && $it_tds_amount > 0){
                        $it_tds_amount = $it_tds_amount;
                        }else{
                        $it_tds_amount = 0;   
                        }
                        $gtds_amount = $this->input->post('gtds_amount');         
                        if(isset($gtds_amount) && !empty($gtds_amount) && $gtds_amount > 0){
                        $gtds_amount = $gtds_amount;
                        }else{
                        $gtds_amount = 0;
                        }
                        $security_deposit_retn_amount = $this->input->post('security_deposit_retn_amount');    
                        if(isset($security_deposit_retn_amount) && !empty($security_deposit_retn_amount) && $security_deposit_retn_amount > 0){
                        $security_deposit_retn_amount = $security_deposit_retn_amount;
                        }else{
                        $security_deposit_retn_amount = 0;
                        }
                        $retenstion_amount = $this->input->post('retenstion_amount');
                        $payment_advice_received = $this->input->post('payment_advice_received');         
                        if(isset($payment_advice_received) && !empty($payment_advice_received)){
                        $payment_advice_received = $payment_advice_received;
                        }else{
                        $payment_advice_received = 'No';
                        }
                        $payment_advice_received_date = $this->input->post('payment_advice_received_date'); 
                        if(isset($payment_advice_received_date) && !empty($payment_advice_received_date)){
                        $payment_advice_received_date = date('Y-m-d',strtotime($payment_advice_received_date));
                        }else{
                        $payment_advice_received_date = '';
                        }
                        $labour_cess = $this->input->post('labour_cess');         
                        if(isset($labour_cess) && !empty($labour_cess)){
                        $labour_cess = $labour_cess;
                        }else{
                        $labour_cess = '';
                        }
                        $debit_note = $this->input->post('debit_note'); 
                        if(isset($debit_note) && !empty($debit_note)){
                        $debit_note = $debit_note;
                        }else{
                        $debit_note = '';
                        }
                        $received_payment = $this->admin_model->get_invoice_received_payment($tax_invc_id);
                        if(isset($received_payment) && !empty($received_payment) && $received_payment > 0){
                        $received_payment = $received_payment;
                        }else{
                        $received_payment = 0;
                        }
                        $invoice_amount = $this->admin_model->get_invoice_amount($tax_invc_id);
                        if(isset($invoice_amount) && !empty($invoice_amount) && $invoice_amount > 0){
                        $invoice_amount = $invoice_amount;
                        }else{
                        $invoice_amount = 0;
                        }
                        if($invoice_amount > $received_payment){
                            $rec = 0;
                            $rec = $invoice_amount - $received_payment;
                            if($rec < $payment_received_amount){
                                $error = 'Y';
                                $error_message = 'Please enter Payment Amount Received must be less than or equal to Balance amount '.$rec.' !';
                            }elseif($invoice_amount < ($payment_received_amount + $received_payment)){
                                $error = 'Y';
                                $error_message = 'Please enter Payment Amount Received must be less than or equal to Balance amount '.$rec.' !';
                            }    
                        }elseif($invoice_amount == $received_payment){
                            $error = 'Y';
                            $error_message = 'All amount already received! Can not create Payment Receipt!';
                        }else{
                            $error = 'Y';
                            $error_message = 'All amount already received! Can not create Payment Receipt!';
                        }
                        /*$tax_invc_status = $this->admin_model->get_invoice_no($tax_invc_id)->status;
                        if(isset($tax_invc_status) && !empty($tax_invc_status) && $tax_invc_status !='Approved'){
                            $error = 'Y';
                            $error_message = 'Please approve TAX Invoce first!';
                        }*/
                        
                        //$prefix = 'INV';
                        //$randomNumber = mt_rand(1000, 9999);
                        //$invoiceNumber = $prefix . $randomNumber;
                        $invoiceNumber = $this->admin_model->get_payment_receipt_no();
                        if(isset($invoiceNumber) && !empty($invoiceNumber) && $invoiceNumber > 0){
                        $invoiceNumber = $invoiceNumber + 1;
                        }else{
                        $invoiceNumber = 1;
                        }
                        $contarct_deposit_emd_rec = $this->input->post('contarct_deposit_emd_rec'); 
                        if(isset($contarct_deposit_emd_rec) && !empty($contarct_deposit_emd_rec)){
                        $contarct_deposit_emd_rec = $contarct_deposit_emd_rec;
                        }else{
                        $contarct_deposit_emd_rec = 'No';
                        }
                        $contarct_deposit_asd_rec = $this->input->post('contarct_deposit_asd_rec'); 
                        if(isset($contarct_deposit_asd_rec) && !empty($contarct_deposit_asd_rec)){
                        $contarct_deposit_asd_rec = $contarct_deposit_asd_rec;
                        }else{
                        $contarct_deposit_asd_rec = 'No';
                        }
                        if($contarct_deposit_emd_rec == 'Yes'){
                            $received_amt = $this->input->post('received_amt'); 
                            if(isset($received_amt) && !empty($received_amt) && $received_amt > 0){
                            $received_amt = $received_amt;
                            }else{
                            $received_amt = 0;
                            }
                            $emd_payment_date = $this->input->post('emd_payment_date');
                            if(isset($emd_payment_date) && !empty($emd_payment_date)){
                            $emd_payment_date = date('Y-m-d',strtotime($emd_payment_date));
                            }else{
                            $emd_payment_date = '';
                            }
                            $emd_doc_file = '';
                            if(isset($_FILES['emd_doc']['name'])){
                                $emd_doc = $_FILES['emd_doc']['name']; //here [] name attribute
                                $emd_doc_fileImg = array('upload_path' =>'./uploads/recipt/',
                                   'fieldname' => 'emd_doc',
                                     'encrypt_name' => TRUE,        
                                     'overwrite' => FALSE,
                                   'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                                $emd_doc_file_img = $this->imageupload->image_upload($emd_doc_fileImg);
                                $errormsg= $this->upload->display_errors();
                                if(isset($emd_doc_file_img) && !empty($emd_doc_file_img)){
                                    $emd_doc_fileData = $this->upload->data();      
                                    $emd_doc_file = $emd_doc_fileData['file_name'];
                                }
                            }else{
                                $emd_doc_file = '';    
                            }   
                        }else{
                            $received_amt = '';   
                            $emd_payment_date = '';
                            $emd_doc_file = '';
                        } 
                        if($contarct_deposit_asd_rec == 'Yes'){
                            $asd_received_amt = $this->input->post('asd_received_amt');         
                            if(isset($asd_received_amt) && !empty($asd_received_amt) && $asd_received_amt > 0){
                            $asd_received_amt = $asd_received_amt;
                            }else{
                            $asd_received_amt = 0;
                            }
                            $asd_payment_date = $this->input->post('asd_payment_date');
                            if(isset($asd_payment_date) && !empty($asd_payment_date)){
                            $asd_payment_date = date('Y-m-d',strtotime($asd_payment_date));
                            }else{
                            $asd_payment_date = '';
                            }
                            if(isset($_FILES['asd_doc']['name'])){
                                $asd_doc = $_FILES['asd_doc']['name']; //here [] name attribute
                                $asd_doc_fileImg = array('upload_path' =>'./uploads/recipt/',
                                    'fieldname' => 'asd_doc',
                                    'encrypt_name' => TRUE,        
                                    'overwrite' => FALSE,
                                   'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                                   $asd_doc_file_img = $this->imageupload->image_upload($asd_doc_fileImg);
                                   $errormsg= $this->upload->display_errors();
                                   if(isset($asd_doc_file_img) && !empty($asd_doc_file_img)){
                                        $asd_doc_fileData = $this->upload->data();      
                                        $asd_doc_file = $asd_doc_fileData['file_name'];
                                   }
                            }else{
                                $asd_doc_file = '';
                            }   
                        }else{
                            $asd_doc_file = '';
                            $asd_received_amt = '';         
                            $asd_payment_date = '';
                
                        }
                        $payment_advice_doc = '';
                        if(isset($_FILES['payment_advice_doc']['name']))//Code for to take image from form and check isset
                        {
                          $payment_advice_doc = $_FILES['payment_advice_doc']['name']; //here [] name attribute
                          $payment_advice_doc_fileImg = array('upload_path' =>'./uploads/recipt/',
                                   'fieldname' => 'payment_advice_doc',
                                     'encrypt_name' => TRUE,        
                                     'overwrite' => FALSE,
                                   'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG' );
                          $payment_advice_doc_img = $this->imageupload->image_upload($payment_advice_doc_fileImg);
                          $errormsg= $this->upload->display_errors();
                          if(isset($payment_advice_doc_img) && !empty($payment_advice_doc_img))
                          {
                            $payment_advice_docData = $this->upload->data();      
                            $payment_advice_doc = $payment_advice_docData['file_name'];
                          }else{
                              $payment_advice_doc = '';
                          }
                        }else{
                            $payment_advice_doc = '';
                        } 
                        $save_dep_array = $save_ded_data = $held_desk = $cess_desk = $any_dedu = array();
                        if($error == 'N'){
                            $save_arr = array(
                            'payment_date' => $payment_date, 
                            'bank_acc_no' =>  $bank_acc_no,
                            'payment_received_amount' => $payment_received_amount,
                            'payment_received_amount' => $payment_received_amount,
                            'invoice_date' => $invoice_date,
                            'invoice_date' => $invoice_date,
                            'invoice_no' => $invoice_no,
                            'invoice_amount' => $invoice_amount,
                            'client_name' => $client_name,
                            'remark' => $remark,
                            'contarct_deposit_emd_rec' => $contarct_deposit_emd_rec,
                            'contarct_deposit_asc_rec' => $contarct_deposit_asd_rec,
                            'received_amt' => $received_amt,
                            'emd_payment_date' => $emd_payment_date,
                            'emd_doc' => $emd_doc_file,
                            'asd_received_amount' => $asd_received_amt,
                            'asd_payment_date' => $asd_payment_date,
                            'asd_doc' => $asd_doc_file,
                            'it_tds_amount' => $it_tds_amount,
                            'gtds_amount' => $gtds_amount,
                            'security_deposit_retn_amount' => $security_deposit_retn_amount,
                            'retenstion_amount' => $retenstion_amount,
                            'labour_cess' => $labour_cess,
                            'debit_note' => $debit_note,
                            'payment_advice_received_date' => $payment_advice_received_date,
                            'payment_advice_doc' => $payment_advice_doc,
                            'tax_incv_id' => $tax_invc_id,
                            'payment_receipt_no' => $invoiceNumber,
                            'payment_advice_received' => $payment_advice_received,
                            'created_date' => date('Y-m-d H:i:s'),
                            'created_by' => $user_id,
                            'updated_date' => date('Y-m-d H:i:s'),
                            'updated_by' => $user_id,
                            'display' => 'Y');
                            $pay_receipt_id =  $this->common_model->addData('tbl_payment_receipt',$save_arr);
                            if(isset($pay_receipt_id) && !empty($pay_receipt_id)){
                                $deposit_desc = $this->input->post('deposit_desc'); 
                                if(isset($deposit_desc) && !empty($deposit_desc)){
                                $deposit_desc = $deposit_desc;
                                }else{
                                $deposit_desc = '';
                                }
                                $deposit_amount = $this->input->post('deposit_amount');         
                                if(isset($deposit_amount) && !empty($deposit_amount) && $deposit_amount > 0){
                                $deposit_amount = $deposit_amount;
                                }else{
                                $deposit_amount = 0;
                                }
                                if(isset($deposit_desc) && !empty($deposit_desc) && isset($deposit_amount)){
                                    for($i=0;$i<count($deposit_desc);$i++){
                                        if(isset($deposit_desc[$i]) && !empty($deposit_desc[$i])) { $deposit_desc_s = $deposit_desc[$i]; }else { $deposit_desc_s = ''; }
                                        if(isset($deposit_amount[$i]) && !empty($deposit_amount[$i])) { $deposit_amount_s = $deposit_amount[$i]; }else { $deposit_amount_s = 0; } 
                                        if(isset($deposit_desc_s) && !empty($deposit_desc_s) && isset($deposit_amount_s)){
                                            $save_dep_array[] = array('pay_receipt_id' =>  $pay_receipt_id,'deposit_desc' => $deposit_desc_s,'deposit_amount' => $deposit_amount_s);
                                        }
                                    }    
                                }
                                if(isset($save_dep_array) && !empty($save_dep_array)){
                                    $this->common_model->SaveMultiData('tbl_any_o_deposit',$save_dep_array);
                                }
                                $tax_deduction_desc = $this->input->post('tax_deduction_desc');
                                if(isset($tax_deduction_desc) && !empty($tax_deduction_desc)){
                                $tax_deduction_desc = $tax_deduction_desc;
                                }else{
                                $tax_deduction_desc = '';
                                }
                                $tax_deduction_amt = $this->input->post('tax_deduction_amt'); 
                                if(isset($tax_deduction_amt) && !empty($tax_deduction_amt) && $tax_deduction_amt > 0){
                                $tax_deduction_amt = $tax_deduction_amt;
                                }else{
                                $tax_deduction_amt = 0;
                                }
                                if(isset($tax_deduction_desc) && !empty($tax_deduction_desc) && isset($tax_deduction_amt)){
                                    for($i=0;$i<count($tax_deduction_desc);$i++){
                                        if(isset($tax_deduction_desc[$i]) && !empty($tax_deduction_desc[$i])) { $tax_deduction_desc_s = $tax_deduction_desc[$i]; }else { $tax_deduction_desc_s = ''; }
                                        if(isset($tax_deduction_amt[$i]) && !empty($tax_deduction_amt[$i])) { $tax_deduction_amt_s = $tax_deduction_amt[$i]; }else { $tax_deduction_amt_s = 0; } 
                                        if(isset($tax_deduction_desc_s) && !empty($tax_deduction_desc_s) && isset($tax_deduction_amt_s)){
                                            $save_ded_data[] = array('pay_receipt_id' =>  $pay_receipt_id,'tax_deduction_desc' => $tax_deduction_desc_s,'tax_deduction_amt' => $tax_deduction_amt_s);
                                        }
                                    }    
                                }
                                if(isset($save_ded_data) && !empty($save_ded_data)){
                                    $this->common_model->SaveMultiData('tbl_any_o_tax',$save_ded_data);
                                }
                                $withheld_desc = $this->input->post('withheld_desc');  
                                if(isset($withheld_desc) && !empty($withheld_desc)){
                                $withheld_desc = $withheld_desc;
                                }else{
                                $withheld_desc = '';
                                }
                                $withheld_amt = $this->input->post('withheld_amt');      
                                if(isset($withheld_amt) && !empty($withheld_amt) && $withheld_amt > 0){
                                $withheld_amt = $withheld_amt;
                                }else{
                                $withheld_amt = 0;
                                }
                                if(isset($withheld_desc) && !empty($withheld_desc) && isset($withheld_amt)){
                                    for($i=0;$i<count($withheld_desc);$i++){
                                        if(isset($withheld_desc[$i]) && !empty($withheld_desc[$i])) { $withheld_desc_s = $withheld_desc[$i]; }else { $withheld_desc_s = ''; }
                                        if(isset($withheld_amt[$i]) && !empty($withheld_amt[$i])) { $withheld_amt_s = $withheld_amt[$i]; }else { $withheld_amt_s = 0; } 
                                        if(isset($withheld_desc_s) && !empty($withheld_desc_s) && isset($withheld_amt_s)){
                                            $held_desk[] = array('pay_receipt_id' =>  $pay_receipt_id,'withheld_desc' => $withheld_desc_s,'withheld_amt' => $withheld_amt_s);
                                        }
                                    }    
                                }
                                if(isset($held_desk) && !empty($held_desk)){
                                    $this->common_model->SaveMultiData('tbl_withheld',$held_desk);
                                }
                                $other_cess_desc = $this->input->post('other_cess_desc');   
                                if(isset($other_cess_desc) && !empty($other_cess_desc)){
                                $other_cess_desc = $other_cess_desc;
                                }else{
                                $other_cess_desc = '';
                                }
                                $other_cess_amt = $this->input->post('other_cess_amt');         
                                if(isset($other_cess_amt) && !empty($other_cess_amt) && $other_cess_amt > 0){
                                $other_cess_amt = $other_cess_amt;
                                }else{
                                $other_cess_amt = 0;
                                }
                                if(isset($other_cess_desc) && !empty($other_cess_desc) && isset($other_cess_amt)){
                                    for($i=0;$i<count($other_cess_desc);$i++){
                                        if(isset($other_cess_desc[$i]) && !empty($other_cess_desc[$i])) { $other_cess_desc_s = $other_cess_desc[$i]; }else { $other_cess_desc_s = ''; }
                                        if(isset($other_cess_amt[$i]) && !empty($other_cess_amt[$i])) { $other_cess_amt_s = $other_cess_amt[$i]; }else { $other_cess_amt_s = 0; } 
                                        if(isset($other_cess_desc_s) && !empty($other_cess_desc_s) && isset($other_cess_amt_s)){
                                            $cess_desk[] = array('pay_receipt_id' =>  $pay_receipt_id,'other_cess_desc' => $other_cess_desc_s,'other_cess_amt' => $other_cess_amt_s);
                                        }
                                    }    
                                }
                                if(isset($cess_desk) && !empty($cess_desk)){
                                    $this->common_model->SaveMultiData('tbl_any_o_cess',$cess_desk);
                                }
                                $deduction_desc = $this->input->post('deduction_desc');         
                                if(isset($deduction_desc) && !empty($deduction_desc)){
                                $deduction_desc = $deduction_desc;
                                }else{
                                $deduction_desc = '';
                                }
                                $deduction_amt = $this->input->post('deduction_amt'); 
                                if(isset($deduction_amt) && !empty($deduction_amt) && $deduction_amt > 0){
                                $deduction_amt = $deduction_amt;
                                }else{
                                $deduction_amt = 0;
                                }
                                if(isset($deduction_desc) && !empty($deduction_desc) && isset($deduction_amt)){
                                    for($i=0;$i<count($deduction_desc);$i++){
                                        if(isset($deduction_desc[$i]) && !empty($deduction_desc[$i])) { $deduction_desc_s = $deduction_desc[$i]; }else { $deduction_desc_s = ''; }
                                        if(isset($deduction_amt[$i]) && !empty($deduction_amt[$i])) { $deduction_amt_s = $deduction_amt[$i]; }else { $deduction_amt_s = 0; } 
                                        if(isset($deduction_desc_s) && !empty($deduction_desc_s) && isset($deduction_desc_s)){
                                            $any_dedu[] = array('pay_receipt_id' =>  $pay_receipt_id,'deduction_desc' => $deduction_desc_s,'deduction_amt' => $deduction_amt_s);
                                        }
                                    }    
                                }
                                if(isset($any_dedu) && !empty($any_dedu)){
                                    $this->common_model->SaveMultiData('tbl_any_o_deduction',$any_dedu);
                                }
                                $this->json->jsonReturn(array(
                                    'valid'=>TRUE,
                                    'msg'=>'<div class="alert modify alert-success">Payment Receipt Details Saved Successfully!</div>',
                                    'redirect' => base_url().'create-tax-invoice'
                                ));
                            }else{
                                 $this->json->jsonReturn(array(
                                    'valid'=>FALSE,
                                    'msg'=>'<div class="alert modify alert-danger"><strong>Oops!</strong> Something Went Wrong.</div>'
                                ));
                            }
                        }else{
                            $this->json->jsonReturn(array(
                                'valid'=>FALSE,
                                'msg'=>'<div class="alert modify alert-danger">'.$error_message.'</div>'
                            ));
                        }
                    }else{
                        $this->json->jsonReturn(array(
                            'valid'=>FALSE,
                            'msg'=>'<div class="alert modify alert-danger"><strong>Oops!</strong> Something Went Wrong.</div>'
                        ));
                    }
                }else{
                    $this->json->jsonReturn(array(
                        'valid'=>FALSE,
                        'msg'=>'<div class="alert modify alert-danger"><strong>Oops!</strong> You have no Permission!!.</div>'
                    ));
                }
            }else{
                $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger"><strong>Oops!</strong> You have no Permission!!.</div>'
                ));
            }
        }else{
            $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Oops!</strong> You have no Permission!!.</div>'
            ));
        }
        
    }


    public function test() {
        // echo 'string TAX';
        // $data = $this->common_model->getLastFinancialYear('TAX');
        
        // echo "<pre>";
        // print_r($data);die;
    }


}



