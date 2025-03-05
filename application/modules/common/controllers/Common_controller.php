<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_controller extends Base_Controller 
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
    
	public function payment_received_amount_chk() 
    {
        $tax_invoice_id = $this->input->post('tax_invoice_id');


        if(isset($tax_invoice_id) && !empty($tax_invoice_id)){
            $tax_invoice_id = $tax_invoice_id;    
        }else{
            $tax_invoice_id = 0;
        }
        $final_payment_received_amount_post = 0;
        $payment_received_amount_post = $this->input->post('payment_received_amount');
         
       

        if(isset($payment_received_amount_post) && !empty($payment_received_amount_post) && $payment_received_amount_post > 0){
            $payment_received_amount_post = $payment_received_amount_post;    
        }else{
            $payment_received_amount_post = 0;
        }

        $it_tds_amount_post = $this->input->post('it_tds_amount');
        if(isset($it_tds_amount_post) && !empty($it_tds_amount_post) && $it_tds_amount_post > 0){
            $it_tds_amount_post = $it_tds_amount_post;    
        }else{
            $it_tds_amount_post = 0;
        }
        $gtds_amount_post = $this->input->post('gtds_amount');
        if(isset($gtds_amount_post) && !empty($gtds_amount_post) && $gtds_amount_post > 0){
            $gtds_amount_post = $gtds_amount_post;    
        }else{
            $gtds_amount_post = 0;
        }
        $tax_deduction_amt_post = $this->input->post('tax_deduction_amt');
        if(isset($tax_deduction_amt_post) && !empty($tax_deduction_amt_post) && $tax_deduction_amt_post > 0){
            $tax_deduction_amt_post = $tax_deduction_amt_post;    
        }else{
            $tax_deduction_amt_post = 0;
        }
        $security_deposit_retn_amount_post = $this->input->post('security_deposit_retn_amount');
        if(isset($security_deposit_retn_amount_post) && !empty($security_deposit_retn_amount_post) && $security_deposit_retn_amount_post > 0){
            $security_deposit_retn_amount_post = $security_deposit_retn_amount_post;    
        }else{
            $security_deposit_retn_amount_post = 0;
        }
        $retenstion_amount_post = $this->input->post('retenstion_amount');
        if(isset($retenstion_amount_post) && !empty($retenstion_amount_post) && $retenstion_amount_post > 0){
            $retenstion_amount_post = $retenstion_amount_post;    
        }else{
            $retenstion_amount_post = 0;
        }
        $deposit_amount_post = $this->input->post('deposit_amount');
        if(isset($deposit_amount_post) && !empty($deposit_amount_post) && $deposit_amount_post > 0){
            $deposit_amount_post = $deposit_amount_post;    
        }else{
            $deposit_amount_post = 0;
        }
        $withheld_amt_post = $this->input->post('withheld_amt');
        if(isset($withheld_amt_post) && !empty($withheld_amt_post) && $withheld_amt_post > 0){
            $withheld_amt_post = $withheld_amt_post;    
        }else{
            $withheld_amt_post = 0;
        }
        $labour_cess_post = $this->input->post('labour_cess');
        if(isset($labour_cess_post) && !empty($labour_cess_post) && $labour_cess_post > 0){
            $labour_cess_post = $labour_cess_post;    
        }else{
            $labour_cess_post = 0;
        }
        $other_cess_amt_post = $this->input->post('other_cess_amt');
        if(isset($other_cess_amt_post) && !empty($other_cess_amt_post) && $other_cess_amt_post > 0){
            $other_cess_amt_post = $other_cess_amt_post;    
        }else{
            $other_cess_amt_post = 0;
        }
        $deduction_amt_post = $this->input->post('deduction_amt');
        if(isset($deduction_amt_post) && !empty($deduction_amt_post) && $deduction_amt_post > 0){
            $deduction_amt_post = $deduction_amt_post;    
        }else{
            $deduction_amt_post = 0;
        }
        
        $final_payment_received_amount_post = $payment_received_amount_post + $it_tds_amount_post + $gtds_amount_post + $tax_deduction_amt_post
        + $labour_cess_post + $other_cess_amt_post + $deduction_amt_post + ($security_deposit_retn_amount_post + $retenstion_amount_post + $deposit_amount_post + $withheld_amt_post);
        if(isset($final_payment_received_amount_post) && !empty($final_payment_received_amount_post) && $final_payment_received_amount_post > 0){
        $final_payment_received_amount_post = $final_payment_received_amount_post;    
        }else{
        $final_payment_received_amount_post = 0;
        }
        
        $final_received_payment = 0;
        $received_payment = $this->admin_model->get_invoice_received_payment($tax_invoice_id);
        if(isset($received_payment) && !empty($received_payment) && $received_payment > 0){
        $received_payment = $received_payment;
        }else{
        $received_payment = 0;
        }
        //Statutory Deductions
        $statutory_deductions = 0;
        $it_tds_amount = $this->admin_model->get_invoice_it_tds_amount($tax_invoice_id);
        if(isset($it_tds_amount) && !empty($it_tds_amount) && $it_tds_amount > 0){
        $it_tds_amount = $it_tds_amount;
        }else{
        $it_tds_amount = 0;
        }
        $gtds_amount = $this->admin_model->get_invoice_gtds_amount($tax_invoice_id);
        if(isset($gtds_amount) && !empty($gtds_amount) && $gtds_amount > 0){
        $gtds_amount = $gtds_amount;
        }else{
        $gtds_amount = 0;
        }
        $other_tax_deduction_amount = $this->admin_model->get_invoice_other_tax_deduction($tax_invoice_id);
        if(isset($other_tax_deduction_amount) && !empty($other_tax_deduction_amount) && $other_tax_deduction_amount > 0){
        $other_tax_deduction_amount = $other_tax_deduction_amount;
        }else{
        $other_tax_deduction_amount = 0;
        }
        $statutory_deductions = $it_tds_amount + $gtds_amount + $other_tax_deduction_amount;
        
        //Refundables
        $security_deposit_retn_amount = $this->admin_model->get_invoice_security_deposit_retn_amount($tax_invoice_id);
        if(isset($security_deposit_retn_amount) && !empty($security_deposit_retn_amount) && $security_deposit_retn_amount > 0){
        $security_deposit_retn_amount = $security_deposit_retn_amount;
        }else{
        $security_deposit_retn_amount = 0;
        }
        $retenstion_amount = $this->admin_model->get_invoice_retn_amount($tax_invoice_id);
        if(isset($retenstion_amount) && !empty($retenstion_amount) && $retenstion_amount > 0){
        $retenstion_amount = $retenstion_amount;
        }else{
        $retenstion_amount = 0;
        }
        $other_deposit_amount = $this->admin_model->get_invoice_other_deposit($tax_invoice_id);
        if(isset($other_deposit_amount) && !empty($other_deposit_amount) && $other_deposit_amount > 0){
        $other_deposit_amount = $other_deposit_amount;
        }else{
        $other_deposit_amount = 0;
        }
        $withheld_amount = $this->admin_model->get_invoice_withheld($tax_invoice_id);
        if(isset($withheld_amount) && !empty($withheld_amount) && $withheld_amount > 0){
        $withheld_amount = $withheld_amount;
        }else{
        $withheld_amount = 0;
        }
        $refundables = $security_deposit_retn_amount + $other_deposit_amount + $withheld_amount;
        
        //Non-Refundables
        $labour_cess_amount = $this->admin_model->get_invoice_labour_cess($tax_invoice_id);
        if(isset($labour_cess_amount) && !empty($labour_cess_amount) && $labour_cess_amount > 0){
        $labour_cess_amount = $labour_cess_amount;
        }else{
        $labour_cess_amount = 0;
        }
        $other_cess_amount = $this->admin_model->get_invoice_other_cess($tax_invoice_id);
        if(isset($other_cess_amount) && !empty($other_cess_amount) && $other_cess_amount > 0){
        $other_cess_amount = $other_cess_amount;
        }else{
        $other_cess_amount = 0;
        }
        $other_deductions_amount = $this->admin_model->get_invoice_other_deductions($tax_invoice_id);
        if(isset($other_deductions_amount) && !empty($other_deductions_amount) && $other_deductions_amount > 0){
        $other_deductions_amount = $other_deductions_amount;
        }else{
        $other_deductions_amount = 0;
        }
        $nonrefundables = $labour_cess_amount + $other_cess_amount + $other_deductions_amount;
        
        $final_received_payment = $received_payment + $nonrefundables + $refundables + $statutory_deductions;
        
        $invoice_amount = $this->admin_model->get_invoice_amount($tax_invoice_id);
  
    
      
        if(isset($invoice_amount) && !empty($invoice_amount) && $invoice_amount > 0){
        $invoice_amount = $invoice_amount;
        }else{
        $invoice_amount = 0;
        }
        $amount_type = $this->input->post('amount_type');
        if(isset($amount_type) && !empty($amount_type)){
            $amount_type = $amount_type;    
        }else{
            $amount_type = 0;
        }
        if($invoice_amount > 0){
        if($final_received_payment == $invoice_amount){
            $this->json->jsonReturn(array(
                'valid'=>true,
                'msg'=>'All amount already received! Can not create Payment Receipt!'
            ));
        }elseif($final_received_payment > $invoice_amount){
            $this->json->jsonReturn(array(
                'valid'=>true,
                'msg'=>'All amount already received! Can not create Payment Receipt!'
            ));
        }else{
            if($invoice_amount < ($final_received_payment + $final_payment_received_amount_post)){
                $msg1='';
                if($amount_type == 'payment_received_amount'){
                    $rec = $invoice_amount - $final_received_payment;
                    $msg1 = 'Please enter Payment Amount Received must be less than Balance amount '.$rec.' !';    
                }elseif($amount_type == 'it_tds_amount'){
                    $rec = $invoice_amount - ($final_received_payment + $payment_received_amount_post  + $gtds_amount_post + $tax_deduction_amt_post
                    + $labour_cess_post + $other_cess_amt_post + $deduction_amt_post + ($security_deposit_retn_amount_post + $deposit_amount_post + $withheld_amt_post + $retenstion_amount_post));
                    
                    //  echo $rec."<br>";
                    //  echo $invoice_amount."<br>";
                    //  echo ($final_received_payment + $payment_received_amount_post  + $gtds_amount_post + $tax_deduction_amt_post
                    //  + $labour_cess_post + $other_cess_amt_post + $deduction_amt_post + ($security_deposit_retn_amount_post + $deposit_amount_post + $withheld_amt_post + $retenstion_amount_post))."<br>";
                    //  exit();

                    $msg1 = 'Please enter IT TDS Amount must be less than Balance amount '.$rec.' !';    
                }elseif($amount_type == 'gtds_amount'){
                    $rec = $invoice_amount - ($final_received_payment + $payment_received_amount_post  + $it_tds_amount_post + $tax_deduction_amt_post
                    + $labour_cess_post + $other_cess_amt_post + $deduction_amt_post + ($security_deposit_retn_amount_post + $deposit_amount_post + $withheld_amt_post + $retenstion_amount_post));
                    $msg1 = 'Please enter GTDS Amount must be less than Balance amount '.$rec.' !';    
                }elseif($amount_type == 'tax_deduction_amt'){
                    $rec = $invoice_amount - ($final_received_payment + $payment_received_amount_post  + $gtds_amount_post + $it_tds_amount_post
                    + $labour_cess_post + $other_cess_amt_post + $deduction_amt_post + ($security_deposit_retn_amount_post + $deposit_amount_post + $withheld_amt_post + $retenstion_amount_post));
                    $msg1 = 'Please enter Total Any Other Tax Deduction must be less than Balance amount '.$rec.' !';    
                }elseif($amount_type == 'security_deposit_retn_amount'){
                    $rec = $invoice_amount - ($final_received_payment + $payment_received_amount_post  + $gtds_amount_post + $it_tds_amount_post + $tax_deduction_amt_post
                    + $labour_cess_post + $other_cess_amt_post + $deduction_amt_post + ($deposit_amount_post + $withheld_amt_post + $retenstion_amount_post));
                    $msg1 = 'Please enter Security Deposit Retention Amount must be less than Balance amount '.$rec.' !';    
                }elseif($amount_type == 'retenstion_amount'){
                    $rec = $invoice_amount - ($final_received_payment + $payment_received_amount_post  + $gtds_amount_post + $it_tds_amount_post + $tax_deduction_amt_post
                    + $labour_cess_post + $other_cess_amt_post + $deduction_amt_post + ($security_deposit_retn_amount_post + $deposit_amount_post + $withheld_amt_post));
                    $msg1 = 'Please enter Retention Amount must be less than Balance amount '.$rec.' !';    
                }elseif($amount_type == 'deposit_amount'){
                    $rec = $invoice_amount - ($final_received_payment + $payment_received_amount_post  + $gtds_amount_post + $it_tds_amount_post + $tax_deduction_amt_post
                    + $labour_cess_post + $other_cess_amt_post + $deduction_amt_post + ($security_deposit_retn_amount_post + $withheld_amt_post + $retenstion_amount_post));
                    $msg1 = 'Please enter Total Any Other Deposit must be less than Balance amount '.$rec.' !';    
                }elseif($amount_type == 'withheld_amt'){
                    $rec = $invoice_amount - ($final_received_payment + $payment_received_amount_post  + $gtds_amount_post + $it_tds_amount_post + $tax_deduction_amt_post
                    + $labour_cess_post + $other_cess_amt_post + $deduction_amt_post + ($security_deposit_retn_amount_post + $deposit_amount_post + $retenstion_amount_post));
                    $msg1 = 'Please enter Total Withheld must be less than Balance amount '.$rec.' !';    
                }elseif($amount_type == 'labour_cess'){
                    $rec = $invoice_amount - ($final_received_payment + $payment_received_amount_post  + $gtds_amount_post + $it_tds_amount_post + $tax_deduction_amt_post
                    + $other_cess_amt_post + $deduction_amt_post + ($security_deposit_retn_amount_post + $deposit_amount_post + $withheld_amt_post + $retenstion_amount_post));
                    $msg1 = 'Please enter Labour Cess must be less than Balance amount '.$rec.' !';    
                }elseif($amount_type == 'other_cess_amt'){
                    $rec = $invoice_amount - ($final_received_payment + $payment_received_amount_post  + $gtds_amount_post + $it_tds_amount_post + $tax_deduction_amt_post
                    + $labour_cess_post + $deduction_amt_post + ($security_deposit_retn_amount_post + $deposit_amount_post + $withheld_amt_post + $retenstion_amount_post));
                    $msg1 = 'Please enter Total Any Other Cess must be less than Balance amount '.$rec.' !';    
                }elseif($amount_type == 'deduction_amt'){
                    $rec = $invoice_amount - ($final_received_payment + $payment_received_amount_post  + $gtds_amount_post + $it_tds_amount_post + $tax_deduction_amt_post
                    + $labour_cess_post + $other_cess_amt_post + ($security_deposit_retn_amount_post + $deposit_amount_post + $withheld_amt_post + $retenstion_amount_post));
                    $msg1 = 'Please enter Total Any Other Deductions must be less than Balance amount '.$rec.' !';    
                }
                if($rec == 0){
                    $this->json->jsonReturn(array(
                        'valid'=>true,
                        'msg'=>'Invoice Amount complete! Can not enter amount more than Invoice Amount!'
                    ));
                }else{
                    $this->json->jsonReturn(array(
                        'valid'=>true,
                        'msg'=>$msg1
                    ));
                }
            }else{
                $this->json->jsonReturn(array(
                    'valid'=>False
                )); 
            }
        }
        }else{
            $this->json->jsonReturn(array(
                'valid'=>true,
                'msg'=>'Invalid Invoice Amount!'
            ));
        }
    }
    public function duplicate() 
    {
        $id=$this->input->post('id');
        if(isset($id) && !empty($id)){
            $id = $id;    
        }else{
            $id = 0;
        }
        $p_key=$this->input->post('p_key');
        $tbl=$this->input->post('tbl');
        $where=$this->input->post('where');     
        $value=$this->input->post('value');
        if(isset($value) && !empty($value)){
            $value = $value;    
        }else{
            $value = 0;
        }
        $result=$this->common_model->duplicate($id,$p_key,$tbl,$where,$value);
        if($result->numrows>0)
        {
            $this->json->jsonReturn(array(
                'valid'=>true,
                'msg'=>'<strong>"'. $value.'" </strong> Record Already Exist !'
            ));
        }
        else
        {
            $this->json->jsonReturn(array(
                'valid'=>False
            ));
        }
    }
	
}
