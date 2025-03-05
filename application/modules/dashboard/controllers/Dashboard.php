<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Base_Controller {

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
        $this->load->library('upload');
    }

	public function index()
	{
        $getOrderAmtFY = $this->common_model->getOrderAmt('fy');
        $getOrderAmtCm = $this->common_model->getOrderAmt('cm');
        $getBillingAmtFY = $this->common_model->getBillingAmt('fy');
        $getBillingAmtCm = $this->common_model->getBillingAmt('cm');
        $getProformaInvoiceAmountFY = $this->common_model->getProformaInvoiceAmount('fy');
        $getProformaInvoiceAmountCm = $this->common_model->getProformaInvoiceAmount('cm');
        $getDepositsAmount = $this->common_model->getDepositsAmount();
        $getCollectionsAmountFY = $this->common_model->getCollectionsAmount('fy');
        $getCollectionsAmountCm = $this->common_model->getCollectionsAmount('cm');
        $getPaymentOverdue = $this->common_model->getPaymentOverdue();
        $getRetentionAmt = $this->common_model->getRetentionAmt();
        $getBankGuaranteeInForce = $this->common_model->getBankGuaranteeInForce();
        $getVendorStopPayment = $this->common_model->get_stop_vendor_name();
        $getVendorIds = array_column($getVendorStopPayment,"vendor_id");
       
        if(count($getVendorIds) > 0){
            $getVendorWriteOffBack = $this->common_model->get_stop_vendors_details($getVendorIds);;     
            foreach($getVendorStopPayment as $key=>$val){
                $is_pending = false;
                foreach($getVendorWriteOffBack as $key_val=>$value){
                    if($value['vendor_id'] == $val['vendor_id']){
                        if(!($value['write_off_back_id'] > 0)){
                            $is_pending = true;
                            
                        }else{
                            
                            $approval_status = json_decode($value['approval_status'],TRUE);
                            $is_pending_status = in_array('pending', array_column($approval_status, 'status')) ? true : false;
                            if($is_pending_status){
                                $is_pending = true;
                            }
                        }
                    }
                }
                
                if(!$is_pending){
                    unset($getVendorStopPayment[$key]);
                }
            }
        
            $getVendorStopPayment = array_values($getVendorStopPayment);
        }
       
        
        // $getven
       
        $data['order_amount_fy'] = $getOrderAmtFY; 
        $data['order_amount_cm'] = $getOrderAmtCm; 
        $data['billing_amount_fy'] = $getBillingAmtFY; 
        $data['billing_amount_cm'] = $getBillingAmtCm; 
        $data['proforma_amount_fy'] = $getProformaInvoiceAmountFY; 
        $data['proforma_amount_cm'] = $getProformaInvoiceAmountCm; 
        $data['deposite_amount'] = $getDepositsAmount; 
        $data['collection_amount_fy'] = $getCollectionsAmountFY; 
        $data['collection_amount_cm'] = $getCollectionsAmountCm; 
        $data['payment_overdue_amt'] = $getPaymentOverdue; 
        $data['retention_amt'] = $getRetentionAmt; 
        $data['bank_guarantee_amt'] = $getBankGuaranteeInForce; 
        $data['stop_payment_vendor'] = $getVendorStopPayment; 
        $this->load->view('dashboard',$data);
	}
	public function test_query()
	{
        $getOrderAmt = $this->common_model->getBankGuaranteeInForce();
        print_r($getOrderAmt);
	}
}
