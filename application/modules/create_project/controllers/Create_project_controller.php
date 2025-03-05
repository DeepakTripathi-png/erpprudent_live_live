<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_project_controller extends Base_Controller
{
  public function __construct()
  {
    parent::__construct();
    date_default_timezone_set("Asia/Kolkata");
    ini_set('memory_limit', '1024M');
    ini_set('max_execution_time', 2000);
    ini_set('upload_max_filesize', '100M');
    ini_set('post_max_size', '100M');
    $value = base_url();
    setcookie("multicare",$value, time()+3600*24,'/');
    $this->load->model('common_model');
    $this->load->model('admin_model');
    $this->load->library('upload');
  }
  public function project_details()
  {
    $check_permission_status = 'N';
    $loguser_id = $this->session->userData('user_id');
    $logrole_id = $this->session->userData('role_id');
    if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
      $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','update_create_project');
      if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
        $submenu_id = $submenu_data->submenu_id;
        $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
        if(isset($check_permission) && !empty($check_permission)){
          $check_permission_status = 'Y';
        }
      }
    }
    $id = $this->uri->segment(2);
    if(isset($id) && !empty($id)){
      $id = base64_decode($id);
    }
    $create_project_data = $this->common_model->selectDetailsWhr('tbl_projects','project_id',$id);
    if(isset($create_project_data) && !empty($create_project_data)){
      $notification_data = $this->common_model->ProjNotReadNotification($id);
      $reminder_data = $this->common_model->ProjNotReadReminder($id);
      $insurance_data = $this->common_model->selectAllWhr('tbl_insurance_data','project_id',$id);
      $sample_data = $this->common_model->selectAllWhr('tbl_sample','project_id',$id);
      $prototype_data = $this->common_model->selectAllWhr('tbl_prototype','project_id',$id);
      $inspection_data = $this->common_model->selectAllWhr('tbl_inspection','project_id',$id);
      $fat_data = $this->common_model->selectAllWhr('tbl_fat','project_id',$id);
      $consignee_data = $this->common_model->selectAllconsineeWhr('tbl_deliv_challan_consignee','project_id',$id);
      $sat_data = $this->common_model->selectAllWhr('tbl_sat','project_id',$id);
      $test_report_data = $this->common_model->selectAllWhr('tbl_test_report','project_id',$id);
      $data['notification_data'] = $notification_data;
      $data['reminder_data'] = $reminder_data;
      $data['project_data'] = $create_project_data;
      $data['insurance_data'] = $insurance_data;
      $data['sample_data'] = $sample_data;
      $data['prototype_data'] = $prototype_data;
      $data['inspection_data'] = $inspection_data;
      $data['fat_data'] = $fat_data;
      $data['consignee_data'] = $consignee_data;
      $data['sat_data'] = $sat_data;
      $data['test_report_data'] = $test_report_data;
      $data['project_id'] = $id;
      $data['business_user'] = $this->common_model->selectDetailsWhere("tbl_user",'role_id','7');
      $data['project_user'] = $this->common_model->selectDetailsWhere("tbl_user",'role_id','6');
      $data['check_permission_status'] = $check_permission_status;
      // pr($data['project_data'],1);
      $this->load->view('project-details',$data);
    }else{
      $data['check_permission_status'] = $check_permission_status;
      $data['project_id'] = $id;
      $this->load->view('project-details',$data);
    }
  }

  public function view_boq_exceptional_approval()
  {
    
    $id = $this->uri->segment(2);
    if(isset($id) && !empty($id)){
      $id = base64_decode($id);
    }
    $notification_data = $this->common_model->ProjNotReadNotification($id);
    $reminder_data = $this->common_model->ProjNotReadReminder($id);
    $bp_code = $this->admin_model->get_bp_code($id);
    $data['notification_data'] = $notification_data;
    $data['reminder_data'] = $reminder_data;
    $data['project_id'] = $id;
    $data['bp_code'] = $bp_code;
    $boq_transaction_cnt = $this->admin_model->getTotalBoqTransactionCnt($id);
    $data['boq_transaction_cnt'] = $boq_transaction_cnt;
  
    $this->load->view('view-boq-exceptional-approval',$data);
  }
  public function view_boq()
  {
    $id = $this->uri->segment(2);
    if(isset($id) && !empty($id)){
      $id = base64_decode($id);
    }
    $totalData = $this->common_model->getBOQViewOriginalAmount($id);
    $totalPosData = $this->common_model->get_boq_item_variation_data('pos_variation',$id);
    $totalNegData = $this->common_model->get_boq_item_variation_data('neg_variation',$id);
    $data['totalData'] = $totalData;
    $data['totalPosData'] = $totalPosData;
    $data['totalNegData'] = $totalNegData;

    $notification_data = $this->common_model->ProjNotReadNotification($id);
    $reminder_data = $this->common_model->ProjNotReadReminder($id);
    $bp_code = $this->admin_model->get_bp_code($id);
    $data['notification_data'] = $notification_data;
    $data['reminder_data'] = $reminder_data;
    $data['project_id'] = $id;
    $data['bp_code'] = $bp_code;
    $boq_transaction_cnt = $this->admin_model->getTotalBoqTransactionCnt($id);
    $data['boq_transaction_cnt'] = $boq_transaction_cnt;
    $this->load->view('boq-view',$data);
  }
  public function project_closure()
  {
    $loguser_id = $this->session->userData('user_id');
    $logrole_id = $this->session->userData('role_id');
    if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
      $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_project_closure');
      if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
        $submenu_id = $submenu_data->submenu_id;
        $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
        if(isset($check_permission) && !empty($check_permission)){
          $id = $this->uri->segment(2);
          if(isset($id) && !empty($id)){
            $id = base64_decode($id);
          }
          $bp_code = $this->admin_model->get_bp_code($id);
          $data['project_id'] = $id;
          $data['bp_code'] = $bp_code;
          // pr($data,1);
          $this->load->view('project-closure',$data);
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
  public function virtual_stock()
  {
    $id = $this->uri->segment(2);
    if(isset($id) && !empty($id)){
      $id = base64_decode($id);
    }
    $bp_code = $this->admin_model->get_bp_code($id);
    $notification_data = $this->common_model->ProjNotReadNotification($id);
    $reminder_data = $this->common_model->ProjNotReadReminder($id);
    $data['notification_data'] = $notification_data;
    $data['reminder_data'] = $reminder_data;
    $data['project_id'] = $id;
    $data['bp_code'] = $bp_code;
    $this->load->view('virtual-stock',$data);
  }
  public function installed_wip()
  {
    $id = $this->uri->segment(2);
    if(isset($id) && !empty($id)){
      $id = base64_decode($id);
    }
    $bp_code = $this->admin_model->get_bp_code($id);
    $notification_data = $this->common_model->ProjNotReadNotification($id);
    $reminder_data = $this->common_model->ProjNotReadReminder($id);
    $data['notification_data'] = $notification_data;
    $data['reminder_data'] = $reminder_data;
    $data['project_id'] = $id;
    $data['bp_code'] = $bp_code;
    $this->load->view('installed-wip',$data);
  }
  public function wip_status()
  {
    $id = $this->uri->segment(2);
    if(isset($id) && !empty($id)){
      $id = base64_decode($id);
    }
    $bp_code = $this->admin_model->get_bp_code($id);
    $notification_data = $this->common_model->ProjNotReadNotification($id);
    $reminder_data = $this->common_model->ProjNotReadReminder($id);
    $data['notification_data'] = $notification_data;
    $data['reminder_data'] = $reminder_data;
    $data['project_id'] = $id;
    $data['bp_code'] = $bp_code;
    $this->load->view('wip-status',$data);
  }

  public function provisional_wip()
  {
    $id = $this->uri->segment(2);
    if(isset($id) && !empty($id)){
      $id = base64_decode($id);
    }
    $bp_code = $this->admin_model->get_bp_code($id);
    $notification_data = $this->common_model->ProjNotReadNotification($id);
    $reminder_data = $this->common_model->ProjNotReadReminder($id);
    $data['notification_data'] = $notification_data;
    $data['reminder_data'] = $reminder_data;
    $data['project_id'] = $id;
    $data['bp_code'] = $bp_code;
    $this->load->view('provisional-wip',$data);
  }
  public function project_wipstatus_list()
  {
    $project_id = $this->input->post('project_id');
    $user_id = $this->session->userData('user_id');
    if(isset($user_id) && !empty($user_id)){
      $data = $row = $newarr = $datad = array();
      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => $data,
      );
      echo json_encode($output);
    }

  }
  public function tax_invoice()
  {
    $id = $this->uri->segment(2);
    if(isset($id) && !empty($id)){
      $id = base64_decode($id);
    }
    $bp_code = $this->admin_model->get_bp_code($id);
    $notification_data = $this->common_model->ProjNotReadNotification($id);
    $reminder_data = $this->common_model->ProjNotReadReminder($id);
    $data['notification_data'] = $notification_data;
    $data['reminder_data'] = $reminder_data;
    $data['project_id'] = $id;
    $data['bp_code'] = $bp_code;
    $this->load->view('tax-invoice',$data);
  }
  public function proforma_invoice()
  {
    $id = $this->uri->segment(2);
    if(isset($id) && !empty($id)){
      $id = base64_decode($id);
    }
    $bp_code = $this->admin_model->get_bp_code($id);
    $notification_data = $this->common_model->ProjNotReadNotification($id);
    $reminder_data = $this->common_model->ProjNotReadReminder($id);
    $data['notification_data'] = $notification_data;
    $data['reminder_data'] = $reminder_data;
    $data['project_id'] = $id;
    $data['bp_code'] = $bp_code;
    $this->load->view('proforma-invoice',$data);
  }

  public function delivery_challan()
  {
    $id = $this->uri->segment(2);
    if(isset($id) && !empty($id)){
      $id = base64_decode($id);
    }
    $bp_code = $this->admin_model->get_bp_code($id);
    $notification_data = $this->common_model->ProjNotReadNotification($id);
    $reminder_data = $this->common_model->ProjNotReadReminder($id);
    $data['notification_data'] = $notification_data;
    $data['reminder_data'] = $reminder_data;
    $data['project_id'] = $id;
    $data['bp_code'] = $bp_code;
    $this->load->view('delivery-challan',$data);
  }

  public function view_all_notification()
  {
    $id = $this->uri->segment(2);
    if(isset($id) && !empty($id)){
      $id = base64_decode($id);
    }
    $bp_code = $this->admin_model->get_bp_code($id);
    $notification_data = $this->common_model->ProjNotReadNotification($id);
    $reminder_data = $this->common_model->ProjNotReadReminder($id);
    $data['notification_data'] = $notification_data;
    $data['reminder_data'] = $reminder_data;
    $data['project_id'] = $id;
    $data['bp_code'] = $bp_code;
    $this->load->view('view-all-notification',$data);
  }
  public function view_all_reminder()
  {
    $id = $this->uri->segment(2);
    if(isset($id) && !empty($id)){
      $id = base64_decode($id);
    }
    $bp_code = $this->admin_model->get_bp_code($id);
    $notification_data = $this->common_model->ProjNotReadNotification($id);
    $reminder_data = $this->common_model->ProjNotReadReminder($id);
    $data['notification_data'] = $notification_data;
    $data['reminder_data'] = $reminder_data;
    $data['project_id'] = $id;
    $data['bp_code'] = $bp_code;
    $this->load->view('view-all-reminder',$data);
  }
  public function approval_waiting()
  {
    $id = $this->uri->segment(2);
    if(isset($id) && !empty($id)){
      $id = base64_decode($id);
    }
    $bp_code = $this->admin_model->get_bp_code($id);
    $notification_data = $this->common_model->ProjNotReadNotification($id);
    $reminder_data = $this->common_model->ProjNotReadReminder($id);
    $data['notification_data'] = $notification_data;
    $data['reminder_data'] = $reminder_data;
    $data['project_id'] = $id;
    $data['bp_code'] = $bp_code;
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
    $data['check_permission_status'] = $check_permission_status;
    $this->load->view('approval-waiting',$data);
  }

  public function boq_transaction()
  {
    $id = $this->uri->segment(2);
    if(isset($id) && !empty($id)){
      $id = base64_decode($id);
    }
    $bp_code = $this->admin_model->get_bp_code($id);
    $notification_data = $this->common_model->ProjNotReadNotification($id);
    $reminder_data = $this->common_model->ProjNotReadReminder($id);
    $data['notification_data'] = $notification_data;
    $data['reminder_data'] = $reminder_data;
    $data['bp_code'] = $bp_code;
    $data['project_id'] = $id;
    $boq_transaction_cnt = $this->admin_model->getTotalBoqTransactionCnt($id);
    $data['boq_transaction_cnt'] = $boq_transaction_cnt;
    $this->load->view('boq-transactions-new',$data);
  }
  public function operational_schedule()
  {
    $id = $this->uri->segment(2);
    if(isset($id) && !empty($id)){
      $id = base64_decode($id);
    }
    $bp_code = $this->admin_model->get_bp_code($id);
    $notification_data = $this->common_model->ProjNotReadNotification($id);
    $reminder_data = $this->common_model->ProjNotReadReminder($id);
    $data['notification_data'] = $notification_data;
    $data['reminder_data'] = $reminder_data;
    $data['bp_code'] = $bp_code;
    $data['project_id'] = $id;
    $boq_transaction_cnt = $this->admin_model->getTotalBoqTransactionCnt($id);
    $data['boq_transaction_cnt'] = $boq_transaction_cnt;
    $data['sch_a_total_data'] = $this->common_model->getBOQOperableAmount($id,'operable_a');
    $data['sch_b_total_data'] = $this->common_model->getBOQOperableAmount($id,'operable_b');
    $data['sch_bn_total_data'] = $this->common_model->getBOQOperableAmount($id,'operable_bn');
    $data['sch_c_total_data'] = $this->common_model->getBOQOperableAmount($id,'operable_c');
    $totalData = $this->common_model->getBOQViewOriginalAmount($id);
    $data['totalData'] = $totalData;

    $status_txt = '';
    $params['length'] ='-1';
    $memData = $this->admin_model->getBOQTransactionItemListRows($params,$id,$status_txt);
    $ea_data = array();
    $ea_total_positive = 0;
    $ea_total_nagative = 0;
    $schedule_total = 0;
    foreach($memData as $member){
      if(isset($member->id) && !empty($member->id)) { $id_1 = $member->id; }else { $id_1 = '0'; }
      if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '0'; }
      if(isset($member->event_name) && !empty($member->event_name)) { $event_name = $member->event_name; }else { $event_name = '-'; }
      if(isset($member->event_type) && !empty($member->event_type)) { $event_type = $member->event_type; }else { $event_type = '-'; }
      if(isset($member->is_first_upload) && !empty($member->is_first_upload)) { $is_first_upload = $member->is_first_upload; }else { $is_first_upload = 0; }

      $filter = 'original';
      $FinalContractamount = $this->getFinalContractamount($filter,$id_1,$event_type,$project_id,$status_txt);
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
          $FinalContractTotal = abs($FinalContractamount['totalDcAmountGST']);
        }
      }else{
        if(isset($FinalContractamount['totalEaAmountGST']) && !empty($FinalContractamount['totalEaAmountGST'])){
          $FinalContractTotal = abs($FinalContractamount['totalEaAmountGST']);
        }
      }

      if($event_type == 'boq_exceptional_appr' && $event_name == 'Negative BOQ Exceptional Approval') {
        $ea_total_nagative += abs($FinalContractamount['totalEaAmountGST']);
      }
      if($event_type == 'boq_exceptional_appr' && $event_name == 'Positive BOQ Exceptional Approval') {
        $ea_total_positive += abs($FinalContractamount['totalEaAmountGST']);
      }
      if($event_type == 'boq_upload' && $event_name == 'Sch. BOQ Upload') {
        $schedule_total += abs($FinalContractamount['totalUdsgnGSTAmount']);
      }
    }
    // $data['ea_data'] = $ea_data;
    $data['ea_total_positive'] = $ea_total_positive;
    $data['ea_total_nagative'] = $ea_total_nagative;
    $data['schedule_total'] = $schedule_total;

    $this->load->view('operational-schedule',$data);
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
  public function create_project_list()
  {
    $check_permission_status = 'N';
    $loguser_id = $this->session->userData('user_id');
    $logrole_id = $this->session->userData('role_id');
    if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
      $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','create-project-list');
      if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
        $submenu_id = $submenu_data->submenu_id;
        $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
        if(isset($check_permission) && !empty($check_permission)){
          $check_permission_create = 'N';
          $submenu_datac=$this->common_model->selectDetailsWhr('tbl_submenu','action','create-project');
          if(isset($submenu_datac->submenu_id) && !empty($submenu_datac->submenu_id)){
            $submenu_idc = $submenu_datac->submenu_id;
            $check_permissionc=$this->admin_model->check_permission($submenu_idc,$logrole_id);
            if(isset($check_permissionc) && !empty($check_permissionc)){
              $check_permission_create = 'Y';
            }
          }
          $data['check_permission_create'] = $check_permission_create;
          $this->load->view('create-project-list',$data);
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

  public function notification_list()
  {
    $project_id = $this->input->post('project_id');
    if(isset($project_id) && !empty($project_id)){
      $project_id = base64_decode($project_id);
    }else{
      $project_id = 0;
    }
    $user_id = $this->session->userData('user_id');
    if(isset($user_id) && !empty($user_id)){
      $data = $row = array();
      $memData = $this->admin_model->getNotiListRows($_POST,$project_id);
      $allCount = $this->admin_model->countNotiListAll($project_id);
      $countFiltered = $this->admin_model->countNotiListFiltered($_POST,$project_id);
      $i = $_POST['start'];
      foreach($memData as $member){
        $i++;
        if(isset($member->id) && !empty($member->id)) { $id = $member->id; }else { $id = '-'; }
        if(isset($member->notification) && !empty($member->notification)) { $activity = $member->notification; }else { $activity = '-'; }
        if(isset($member->created_date) && !empty($member->created_date)) { $created_date = $member->created_date; }else { $created_date = ''; }
        $html='<a href="javascript:;" class="delete tooltips" rel="8" title="" rev="" data-original-title="Delete Role"><i class="fa fa-trash-o" style="color:#a94442; font-size: 15px;"></i></a>';
        $data[] = array(
          $i,
          $activity,
          $created_date,
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

  public function project_waiting_approv_list()
  {
    $project_id = $this->input->post('project_id');
    if(isset($project_id) && !empty($project_id)){
      $project_id = base64_decode($project_id);
    }else{
      $project_id = 0;
    }
    $user_id = $this->session->userData('user_id');
    if(isset($user_id) && !empty($user_id)){
      $data = $row = array();
      $memData = $this->admin_model->getApproWaitListRows($_POST,$project_id);
      $allCount = $this->admin_model->countApproWaitListAll($project_id);
      $countFiltered = $this->admin_model->countApproWaitListFiltered($_POST,$project_id);
      $i = $_POST['start'];
      foreach($memData as $member){
        $i++;
        if(isset($member->id) && !empty($member->id)) { $id = $member->id; }else { $id = '-'; }
        if(isset($member->activity) && !empty($member->activity)) { $activity = ucwords($member->activity); }else { $activity = '-'; }
        if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = '-'; }
        if(isset($member->action_id) && !empty($member->action_id)) { $action_id = $member->action_id; }else { $action_id = '-'; }
        if(isset($member->action_url) && !empty($member->action_url)) { $action_url = $member->action_url; }else { $action_url = ''; }
        if(isset($member->created_by) && !empty($member->created_by)) { $created_by = $member->created_by; }else { $created_by = ''; }
        if(isset($member->created_date) && !empty($member->created_date)) { $created_date = $member->created_date; }else { $created_date = ''; }
        if(isset($member->modified_on) && !empty($member->modified_on)) { $modified_on = $member->modified_on; }else { $modified_on = ''; }
        if(isset($member->modified_by) && !empty($member->modified_by)) { $modified_by = $member->modified_by; }else { $modified_by = ''; }
        $htmlactivity = '';
        if(!empty($activity)){
          $htmlactivity .='<a href="'.$action_url.'">'.$activity.'</a>';
        }
        $html='';
        if($member->status == 'Y'){
          $html .='<a class="btn btn-danger btn-xs" href="javascript:void(0);" rev="" rel="'.$id.'" title="Click here to Reject Record" data-placement="top" data-status="N">Reject</a>';
        }else{
          $html .='<a class="btn btn-success btn-xs" href="javascript:void(0);" rev="" rel="'.$id.'" title="Click here to Accept Record" data-status="Y">Accept</a>';
        }
        $data[] = array(
          $i,
          $htmlactivity,
          $status,
          $created_date,
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
  public function all_reminder_list()
  {
    $project_id = $this->input->post('project_id');
    if(isset($project_id) && !empty($project_id)){
      $project_id = base64_decode($project_id);
    }else{
      $project_id = 0;
    }
    $user_id = $this->session->userData('user_id');
    if(isset($user_id) && !empty($user_id)){
      $data = $row = array();
      $memData = $this->admin_model->getReminderListRows($_POST,$project_id);
      $allCount = $this->admin_model->countReminderListAll($project_id);
      $countFiltered = $this->admin_model->countReminderListFiltered($_POST,$project_id);
      $i = $_POST['start'];
      foreach($memData as $member){
        $i++;
        if(isset($member->id) && !empty($member->id)) { $id = $member->id; }else { $id = '-'; }
        if(isset($member->icon) && !empty($member->icon)) { $icon = $member->icon; }else { $icon = '-'; }
        if(isset($member->notification) && !empty($member->notification)) { $notification = $member->notification; }else { $notification = '-'; }
        if(isset($member->created_date) && !empty($member->created_date)) { $created_date = $member->created_date; }else { $created_date = ''; }
        $html='<a href="javascript:;" class="delete tooltips" rel="8" title="" rev="" data-original-title="Delete Role"><i class="fa fa-trash-o" style="color:#a94442; font-size: 15px;"></i></a>';
        $data[] = array(
          $i,
          $notification,
          $created_date,
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
  public function project_list_display()
  {
    $user_id = $this->session->userData('user_id');
    if(isset($user_id) && !empty($user_id)){
      $check_permission_status = 'N';
      $loguser_id = $this->session->userData('user_id');
      $logrole_id = $this->session->userData('role_id');
      if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
        $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_project_details');
        if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
          $submenu_id = $submenu_data->submenu_id;
          $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
          if(isset($check_permission) && !empty($check_permission)){
            $check_permission_status = 'Y';
          }
        }
      }
      $check_permission_savepc = 'N';
      if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
        $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_project_closure');
        if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
          $submenu_id = $submenu_data->submenu_id;
          $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
          if(isset($check_permission) && !empty($check_permission)){
            $check_permission_savepc = 'Y';
          }
        }
      }
      $data = $row = array();
      $memData = $this->admin_model->getProjectListRows($_POST);
      $allCount = $this->admin_model->countProjectListAll();
      $countFiltered = $this->admin_model->countProjectListFiltered($_POST);
      $i = $_POST['start'];
      foreach($memData as $member){
        $i++;
        if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
        if(isset($member->customer_code) && !empty($member->customer_code)) { $customer_code = '<p style="margin:0;"><span style="font-weight:600;">Code : </span> CUST'.sprintf('%05d',$member->customer_code).'</p>'; }else { $customer_code = '-'; }
        if(isset($member->customer_name) && !empty($member->customer_name)) { $customer_name = '<p style="margin:0;"><span style="font-weight:600;">Name : </span> '.ucwords(strtolower($member->customer_name)).'</p>'; }else { $customer_name = '-'; }
        if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '-'; }
        if(isset($member->po_loi_no) && !empty($member->po_loi_no)) { $po_loi_no = $member->po_loi_no; }else { $po_loi_no = ''; }
        if(isset($member->registered_address) && !empty($member->registered_address)) { $registered_address = $member->registered_address; }else { $registered_address = ''; }
        if(isset($member->created_date) && !empty($member->created_date)) { $created_date = $member->created_date; }else { $created_date = ''; }
        if(isset($member->updated_date) && !empty($member->updated_date)) { $updated_date = $member->updated_date; }else { $updated_date = ''; }
        if(isset($member->role_name) && !empty($member->role_name)) { $role_name = '<br>('.$member->role_name.')'; }else { $role_name = ''; }
        if(isset($member->fullname) && !empty($member->fullname)) { $created_by = ucwords($member->fullname).''.$role_name; }else { $created_by = ''; }
        $action_status='';
        if(isset($member->status) && !empty($member->status) && $member->status == 'Y'){
          $action_status .='<span style="color:green;font-weight:600;">Approved</span>';
        }elseif(isset($member->status) && !empty($member->status) && $member->status == 'N'){
          $action_status .='<span style="color:red;font-weight:600;">Rejected</span>';
        }else{
          $action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
        }
        $cust_details = $customer_code.''.$customer_name;
        $html='';
        if($check_permission_savepc == 'Y'){
          $html .= '<a href="'.base_url().'project-closure/'.base64_encode($project_id).'" title="Project Closure"><img src="'.base_url().'uploads/images/projectclosure.jpg" width="20px" height="20px"></a>';
        }
        if($check_permission_status == 'Y'){
          if($member->status != 'Y'){
            $html .='&nbsp;&nbsp;&nbsp;<a class="btn btn-success btn-xs active_link_cmn" href="javascript:void(0);" rev="approved_project_details" rel="'.$project_id.'" title="Click here to Approved Record" data-status="Y">Approve</a>';
          }
        }
        $htmlp='';
        if(isset($bp_code) && !empty($bp_code)){
          $htmlp .='<a href="'.base_url().'project-details/'.base64_encode($project_id).'" title="Click here to view details">'.$bp_code.'</a>';
        }
        $data[] = array(
          $i,
          $htmlp,
          $po_loi_no,
          $cust_details,
          $registered_address,
          $action_status,
          $created_by,
          $created_date,
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
  public function approved_project_details()
  {
    $current_date = date('Y-m-d H:i:s');
    $loguser_id = $this->session->userData('user_id');
    $logrole_id = $this->session->userData('role_id');
    if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
      $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_project_details');
      if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
        $submenu_id = $submenu_data->submenu_id;
        $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
        if(isset($check_permission) && !empty($check_permission)){
          $id = $this->input->post('id');
          $status = $this->input->post('status');
          if(isset($id) && !empty($id) && isset($status) && !empty($status)){
            if($status == 'Y'){
              $msg = 'project approved';
            }else{
              $msg = 'project rejected';
            }
            $error_status = 'N';
            $project_data=$this->common_model->selectDetailsWhr('tbl_projects','project_id',$id);
            if(isset($project_data) && !empty($project_data)){
              if(isset($project_data->project_id) && !empty($project_data->project_id)
              && isset($project_data->customer_code) && !empty($project_data->customer_code)
              && isset($project_data->business_head) && !empty($project_data->business_head)
              && isset($project_data->manager_head) && !empty($project_data->manager_head)
              && isset($project_data->customer_name) && !empty($project_data->customer_name)
              && isset($project_data->bp_code) && !empty($project_data->bp_code)
              && isset($project_data->po_loi_no) && !empty($project_data->po_loi_no)
              && isset($project_data->po_loi_received_data) && !empty($project_data->po_loi_received_data)
              && isset($project_data->registered_address) && !empty($project_data->registered_address)
              && isset($project_data->client_po_addr) && !empty($project_data->client_po_addr)
              && isset($project_data->our_address_on_po) && !empty($project_data->our_address_on_po)
              && isset($project_data->name_of_work) && !empty($project_data->name_of_work)
              && isset($project_data->work_order_on) && !empty($project_data->work_order_on)
              && isset($project_data->site_address) && !empty($project_data->site_address)
              && isset($project_data->taxable_amount) && !empty($project_data->taxable_amount)
              && isset($project_data->total_amount) && !empty($project_data->total_amount)
              && isset($project_data->security_deposite_num) && !empty($project_data->security_deposite_num)
              && isset($project_data->warranty_period) && !empty($project_data->warranty_period)
              && isset($project_data->billing_related) && !empty($project_data->billing_related)
              && isset($project_data->po_related) && !empty($project_data->po_related)
              && isset($project_data->execution_related) && !empty($project_data->execution_related)
              && isset($project_data->engineer_in_charge) && !empty($project_data->engineer_in_charge)
              && isset($project_data->completion_period) && !empty($project_data->completion_period)
              && isset($project_data->gst_no) && !empty($project_data->gst_no)
              && isset($project_data->penalty_clause) && !empty($project_data->penalty_clause)
              && isset($project_data->power_of_attorney) && !empty($project_data->power_of_attorney)){
                if(isset($project_data->emd_paid) && !empty($project_data->emd_paid) && $project_data->emd_paid == 'Y'){
                  if(isset($project_data->emd_paid_num) && !empty($project_data->emd_paid_num)
                  && isset($project_data->emd_paid_status) && !empty($project_data->emd_paid_status)
                  && isset($project_data->emd_converted_deposit) && !empty($project_data->emd_converted_deposit)
                  && isset($project_data->emd_payment_mode) && !empty($project_data->emd_payment_mode)
                  && isset($project_data->upload_emd_paid_file) && !empty($project_data->upload_emd_paid_file)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please enter EMD Paid Project Details!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->asd_paid) && !empty($project_data->asd_paid) && $project_data->asd_paid == 'Y'){
                  if(isset($project_data->asd_paid_num) && !empty($project_data->asd_paid_num)
                  && isset($project_data->asd_paid_status) && !empty($project_data->asd_paid_status)
                  && isset($project_data->asd_converted_deposit) && !empty($project_data->asd_converted_deposit)
                  && isset($project_data->asd_payment_mode) && !empty($project_data->asd_payment_mode)
                  && isset($project_data->upload_asd_paid_file) && !empty($project_data->upload_asd_paid_file)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please enter ASD Paid Project Details!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->performance_paid) && !empty($project_data->performance_paid) && $project_data->performance_paid == 'Y'){
                  if(isset($project_data->performance_guarantee_num) && !empty($project_data->performance_guarantee_num)
                  && isset($project_data->per_paid_status) && !empty($project_data->per_paid_status)
                  && isset($project_data->pbg_validity) && !empty($project_data->pbg_validity)
                  && isset($project_data->per_payment_mode) && !empty($project_data->per_payment_mode)
                  && isset($project_data->draft_performance_paid_file) && !empty($project_data->draft_performance_paid_file)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg='Please enter Performance Paid Details!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->price_inslusive_of_amc) && !empty($project_data->price_inslusive_of_amc) && $project_data->price_inslusive_of_amc == 'Y'){
                  if(isset($project_data->amc_applicable_after) && !empty($project_data->amc_applicable_after)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please enter AMC Applicable After (Months)!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->is_billing_inter_state) && !empty($project_data->is_billing_inter_state) && $project_data->is_billing_inter_state == 'Y'){
                  if(isset($project_data->billing_address) && !empty($project_data->billing_address)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please enter Billing Address!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->insurance_req) && !empty($project_data->insurance_req) && $project_data->insurance_req == 'Y'){
                  $insurance_req_data = $this->common_model->selectDetailsWhr('tbl_insurance_data','project_id',$project_data->project_id);
                  if(isset($insurance_req_data) && !empty($insurance_req_data)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please enter Insurance Required!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->sample) && !empty($project_data->sample) && $project_data->sample == 'Y'){
                  $sample_data = $this->common_model->selectDetailsWhr('tbl_sample','project_id',$project_data->project_id);
                  if(isset($sample_data) && !empty($sample_data)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please enter Sample Details!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->prototype) && !empty($project_data->prototype) && $project_data->prototype == 'Y'){
                  $prototype_data = $this->common_model->selectDetailsWhr('tbl_prototype','project_id',$project_data->project_id);
                  if(isset($prototype_data) && !empty($prototype_data)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please enter Prototype Details!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->inspection) && !empty($project_data->inspection) && $project_data->inspection == 'Y'){
                  $inspection_data = $this->common_model->selectDetailsWhr('tbl_inspection','project_id',$project_data->project_id);
                  if(isset($inspection_data) && !empty($inspection_data)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please enter Inspection Details!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->fat) && !empty($project_data->fat) && $project_data->fat == 'Y'){
                  $fat_data = $this->common_model->selectDetailsWhr('tbl_fat','project_id',$project_data->project_id);
                  if(isset($fat_data) && !empty($fat_data)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please enter FAT Details!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->sat) && !empty($project_data->sat) && $project_data->sat == 'Y'){
                  $sat_data = $this->common_model->selectDetailsWhr('tbl_sat','project_id',$project_data->project_id);
                  if(isset($sat_data) && !empty($sat_data)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please enter SAT Details!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->agreement_prepared) && !empty($project_data->agreement_prepared) && $project_data->agreement_prepared == 'Y'){
                  if(isset($project_data->draft_doc_file) && !empty($project_data->draft_doc_file)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please Upload Draft Agreement Document!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->payment_terms) && !empty($project_data->payment_terms) && $project_data->payment_terms == 'S&I'){
                  if(isset($project_data->bill_split_supply) && !empty($project_data->bill_split_supply)
                  && isset($project_data->bill_installation) && !empty($project_data->bill_installation)
                  && isset($project_data->testing_commissioning) && !empty($project_data->testing_commissioning)
                  && isset($project_data->bill_handover) && !empty($project_data->bill_handover)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please enter Payment Terms Details!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->invoice_submitted) && !empty($project_data->invoice_submitted) && $project_data->invoice_submitted == 'Y'){
                  if(isset($project_data->invoice_submitted_text) && !empty($project_data->invoice_submitted_text)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please enter Invoice to be submitted on customer website!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->invoice_submitted_address) && !empty($project_data->invoice_submitted_address) && $project_data->invoice_submitted_address == 'Y'){
                  if(isset($project_data->invoice_submitted_address_text) && !empty($project_data->invoice_submitted_address_text)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please enter Invoice to be sent on different address!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->esic_required) && !empty($project_data->esic_required) && $project_data->esic_required == 'Y'){
                  if(isset($project_data->esic_required_text) && !empty($project_data->esic_required_text)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please enter ESIC Required!!';
                  }
                }else{
                  $error_status = 'N';
                }
                if(isset($project_data->pf_required) && !empty($project_data->pf_required) && $project_data->pf_required == 'Y'){
                  if(isset($project_data->pf_required_text) && !empty($project_data->pf_required_text)){
                    $error_status = 'N';
                  }else{
                    $error_status = 'Y';
                    $error_status_msg = 'Please enter PF Required!!';
                  }
                }else{
                  $error_status = 'N';
                }
              }else{
                $error_status = 'Y';
                $error_status_msg = 'Please complete OEF details!!';
              }
              if($error_status == 'N'){
                $data = array('status'=>$status,'approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
                $result = $this->common_model->updateDetails('tbl_projects','project_id',$id,$data);
                if($result)
                {
                  $this->json->jsonReturn(array(
                    'valid'=>TRUE,
                    'msg'=>'<div class="alert modify alert-success"><strong></strong> '.$msg.' Successfully!</div>'
                  ));
                }else{
                  $this->json->jsonReturn(array(
                    'valid'=>FALSE,
                    'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While '.$msg.' !</div>'
                  ));
                }
              }else{
                $this->json->jsonReturn(array(
                  'valid'=>FALSE,
                  'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> '.$error_status_msg.'</div>'
                ));
              }
            }else{
              $this->json->jsonReturn(array(
                'valid'=>FALSE,
                'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While '.$msg.'!</div>'
              ));
            }
          }else{
            $this->json->jsonReturn(array(
              'valid'=>FALSE,
              'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> While '.$msg.'!</div>'
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
        'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> Please LoggedIn!</div>'
      ));
    }
  }
  public function edit_create_project($id=NULL)
  {
    $data['create_project_data']=$this->common_model->selectDetailsWhr('tbl_projects','project_id',$id);
    $this->load->view('create-project',$data);
  }
  public function create_project()
  {
    $check_permission_status = 'N';
    $loguser_id = $this->session->userData('user_id');
    $logrole_id = $this->session->userData('role_id');
    if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
      $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','create-project');
      if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
        $submenu_id = $submenu_data->submenu_id;
        $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
        if(isset($check_permission) && !empty($check_permission)){
          $data['business_user'] = $this->common_model->selectDetailsWhere("tbl_user",'role_id','7');
          $data['project_user'] = $this->common_model->selectDetailsWhere("tbl_user",'role_id','6');
          $this->load->view('create-project',$data);
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
  public function upload_document_file()
  {
    if($_FILES['file']['name'] != '')
    {
      $test =explode(".", $_FILES['file']['name']);
      $extension = end($test);
      $name = rand(100000000, 999999999) . '.' . $extension;
      $location = './uploads/document_upload/'.$name;
      move_uploaded_file($_FILES['file']['tmp_name'], $location);
      $file_path = base_url().'uploads/document_upload/'.$name;
      echo $name;
    }
  }
  public function upload_emd_paid()
  {
    if($_FILES['file']['name'] != '')
    {
      $test =explode(".", $_FILES['file']['name']);
      $extension = end($test);
      $name = rand(100000000, 999999999) . '.' . $extension;
      $location = './uploads/emd_paid_document/'.$name;
      move_uploaded_file($_FILES['file']['tmp_name'], $location);
      $file_path = base_url().'uploads/emd_paid_document/'.$name;
      echo $name;
    }
  }
  public function upload_asd_paid()
  {
    if($_FILES['file']['name'] != '')
    {
      $test =explode(".", $_FILES['file']['name']);
      $extension = end($test);
      $name = rand(100000000, 999999999) . '.' . $extension;
      $location = './uploads/asd_paid_document/'.$name;
      move_uploaded_file($_FILES['file']['tmp_name'], $location);
      $file_path = base_url().'uploads/asd_paid_document/'.$name;
      echo $name;
    }
  }
  public function upload_security_deposite()
  {
    if($_FILES['file']['name'] != '')
    {
      $test =explode(".", $_FILES['file']['name']);
      $extension = end($test);
      $name = rand(100000000, 999999999) . '.' . $extension;
      $location = './uploads/security_deposite_document/'.$name;
      move_uploaded_file($_FILES['file']['tmp_name'], $location);
      $file_path = base_url().'uploads/security_deposite_document/'.$name;
      echo $name;
    }
  }
  public function upload_performance_paid()
  {
    if($_FILES['file']['name'] != '')
    {
      $test =explode(".", $_FILES['file']['name']);
      $extension = end($test);
      $name = rand(100000000, 999999999) . '.' . $extension;
      $location = './uploads/performance_gaurantee_document/'.$name;
      move_uploaded_file($_FILES['file']['tmp_name'], $location);
      $file_path = base_url().'uploads/performance_gaurantee_document/'.$name;
      echo $name;
    }
  }
  public function save_create_project()
  {
    // pr($_POST);
    // pr($_FILES,1);
    $error = 'N';
    $error_message = '';
    $user_id = $this->session->userdata('user_id');
    if(isset($user_id) && empty($user_id)){
      $error = 'Y';
      $error_message = 'Please loggedin!';
    }
    $last_code = $this->common_model->last_custcode();
    if(isset($last_code) && !empty($last_code)) {$customer_code = $last_code + 1; } else {$customer_code='1'; }
    $customer_name = $this->input->post('customer_name');
    $business_head = $this->input->post('business_head');
    $manager_head = $this->input->post('manager_head');
    $gst_rate = $this->input->post('gst_rate');
    $emd_converted_deposit = $this->input->post('emd_converted_deposit');
    $asd_converted_deposit = $this->input->post('asd_converted_deposit');
    if(isset($customer_name) && !empty($customer_name)) {$customer_name = trim($customer_name); } else {$customer_name=''; }
    $bp_code =$this->input->post('bp_code');
    if(isset($bp_code) && !empty($bp_code)) {$bp_code=trim($bp_code); } else {$bp_code=''; }
    if(isset($bp_code) && empty($bp_code)){
      $error = 'Y';
      $error_message = 'Please enter BP Code!';
    }else{
      $existbpcode = $this->common_model->existbpcode($bp_code);
      if(isset($existbpcode) && !empty($existbpcode)) {
        $error = 'Y';
        $error_message = 'This BP Code already exist!';
      }
    }
    // pr($_POST);
    // pr($_FILES,1);
    $po_loi_no =$this->input->post('po_loi_no');
    if(isset($po_loi_no) && !empty($po_loi_no)) {$po_loi_no=trim($po_loi_no); } else {$po_loi_no=''; }
    $po_loi_received_data =$this->input->post('po_loi_received_data');
    if(isset($po_loi_received_data) && !empty($po_loi_received_data)) {$po_loi_received_data = date('Y-m-d',strtotime($po_loi_received_data)); } else {$po_loi_received_data=''; }
    $registered_address =$this->input->post('registered_address');
    if(isset($registered_address) && !empty($registered_address)) {$registered_address=trim($registered_address); } else {$registered_address=''; }
    $client_po_addr =$this->input->post('client_po_addr');
    if(isset($client_po_addr) && !empty($client_po_addr)) {$client_po_addr=trim($client_po_addr); } else {$client_po_addr=''; }
    $our_address_on_po =$this->input->post('our_address_on_po');
    if(isset($our_address_on_po) && !empty($our_address_on_po)) {$our_address_on_po=trim($our_address_on_po); } else {$our_address_on_po=''; }
    $name_of_work =$this->input->post('name_of_work');
    if(isset($name_of_work) && !empty($name_of_work)) {$name_of_work=trim($name_of_work); } else {$name_of_work=''; }
    $work_order_on =$this->input->post('work_order_on');
    if(isset($work_order_on) && !empty($work_order_on)) {$work_order_on=trim($work_order_on); } else {$work_order_on=''; }
    $site_address =$this->input->post('site_address');
    if(isset($site_address) && !empty($site_address)) {$site_address=trim($site_address); } else {$site_address=''; }
    $taxable_amount =$this->input->post('taxable_amount');
    if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount=trim($taxable_amount); } else {$taxable_amount='0'; }
    $gst_amount =$this->input->post('gst_amount');
    if(isset($gst_amount) && !empty($gst_amount)) {$gst_amount=trim($gst_amount); } else {$gst_amount='0'; }
    $total_amount =$this->input->post('total_amount');
    if(isset($total_amount) && !empty($total_amount)) {$total_amount=trim($total_amount); } else {$total_amount='0'; }

    $emd_paid =$this->input->post('emd_paid');
    if(isset($emd_paid) && !empty($emd_paid) && $emd_paid == 'Y') {$emd_paid = 'Y'; } else {$emd_paid= 'N'; }
    $emd_paid_num =$this->input->post('emd_paid_num');
    if(isset($emd_paid_num) && !empty($emd_paid_num)) {$emd_paid_num=trim($emd_paid_num); } else {$emd_paid_num='0'; }
    $emd_payment_mode = $this->input->post('emd_payment_mode');
    if(isset($emd_payment_mode) && !empty($emd_payment_mode)) {$emd_payment_mode=trim($emd_payment_mode); } else {$emd_payment_mode=''; }
    //upload_emd_paid_file
    $upload_emd_paid_file ='';
    $errormsg='';
    if(isset($_FILES['upload_emd_paid_file']['name']))//Code for to take image from form and check isset
    {
      $upload_emd_paid_file = $_FILES['upload_emd_paid_file']['name']; //here [] name attribute
      $upload_emd_paid_fileImg = array('upload_path' =>'./uploads/emd_paid_document/',
      'fieldname' => 'upload_emd_paid_file',
      'encrypt_name' => TRUE,
      'overwrite' => FALSE,
      'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
      'max_size' => 15360  );
      $upload_emd_paid_file_img = $this->imageupload->image_upload($upload_emd_paid_fileImg);
      $errormsg= $this->upload->display_errors();
      if(isset($upload_emd_paid_file_img) && !empty($upload_emd_paid_file_img))
      {
        $upload_emd_paid_fileData = $this->upload->data();
        $upload_emd_paid_file = $upload_emd_paid_fileData['file_name'];
      }
    }else{
      $upload_emd_paid_file = $this->input->post('hidden_upload_emd_paid_file');
      if(isset($upload_emd_paid_file) && !empty($upload_emd_paid_file)) {$upload_emd_paid_file = $upload_emd_paid_file; } else {$upload_emd_paid_file=''; }
    }
    if(isset($upload_emd_paid_file) && !empty($upload_emd_paid_file)) {$upload_emd_paid_file = $upload_emd_paid_file; } else {$upload_emd_paid_file=''; }
    if($emd_paid == 'Y'){
      if(empty($upload_emd_paid_file)){
        //$error = 'Y';
        //$error_message = 'Please Upload EMD Paid!';
      }
    }

    $emd_paid_status =$this->input->post('emd_paid_status');
    if(isset($emd_paid_status) && !empty($emd_paid_status) && $emd_paid_status == 'Yes') {$emd_paid_status = 'Y'; } else {$emd_paid_status = 'N'; }
    if($emd_paid == 'Y'){
      if(empty($emd_paid_num)){
        //$error = 'Y';
        //$error_message = 'Please enter EMD paid value!';
      }
    }
    $asd_paid =$this->input->post('asd_paid');
    if(isset($asd_paid) && !empty($asd_paid) && $asd_paid == 'Y') {$asd_paid = 'Y'; } else {$asd_paid = 'N'; }
    $upload_asd_paid_file ='';
    $errormsg='';
    if(isset($_FILES['upload_asd_paid_file']['name']))//Code for to take image from form and check isset
    {
      $upload_asd_paid_file = $_FILES['upload_asd_paid_file']['name']; //here [] name attribute
      $upload_asd_paid_fileImg = array('upload_path' =>'./uploads/asd_paid_document/',
      'fieldname' => 'upload_asd_paid_file',
      'encrypt_name' => TRUE,
      'overwrite' => FALSE,
      'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
      'max_size' => 15360 );
      $upload_asd_paid_file_img = $this->imageupload->image_upload($upload_asd_paid_fileImg);
      $errormsg= $this->upload->display_errors();
      if(isset($upload_asd_paid_file_img) && !empty($upload_asd_paid_file_img))
      {
        $upload_asd_paid_fileData = $this->upload->data();
        $upload_asd_paid_file = $upload_asd_paid_fileData['file_name'];
      }
    }else{
      $upload_asd_paid_file = $this->input->post('hidden_upload_asd_paid_file');
      if(isset($upload_asd_paid_file) && !empty($upload_asd_paid_file)) {$upload_asd_paid_file = $upload_asd_paid_file; } else {$upload_asd_paid_file=''; }
    }
    if(isset($upload_asd_paid_file) && !empty($upload_asd_paid_file)) {$upload_asd_paid_file = $upload_asd_paid_file; } else {$upload_asd_paid_file=''; }
    if($asd_paid == 'Y'){
      if(empty($upload_asd_paid_file)){
        //$error = 'Y';
        //$error_message = 'Please Upload ASD Paid!';
      }
    }
    $asd_paid_num = $this->input->post('asd_paid_num');
    if(isset($asd_paid_num) && !empty($asd_paid_num)) {$asd_paid_num=trim($asd_paid_num); } else {$asd_paid_num='0'; }
    $asd_paid_status = $this->input->post('asd_paid_status');
    if(isset($asd_paid_status) && !empty($asd_paid_status) && $asd_paid_status == 'Yes') {$asd_paid_status = 'Y'; } else {$asd_paid_status = 'N'; }

    $asd_payment_mode = $this->input->post('asd_payment_mode');
    if(isset($asd_payment_mode) && !empty($asd_payment_mode)){$asd_payment_mode =trim($asd_payment_mode); } else {$asd_payment_mode = ''; }
    if($asd_paid == 'Y'){
      if(empty($asd_paid_num)){
        //$error = 'Y';
        //$error_message = 'Please enter ASD paid value!';
      }
    }

    $performance_paid =$this->input->post('performance_paid');
    if(isset($performance_paid) && !empty($performance_paid) && $performance_paid == 'Y') {$performance_paid = 'Y'; } else {$performance_paid = 'N'; }
    $performance_guarantee_num = $this->input->post('performance_guarantee_num');
    if(isset($performance_guarantee_num) && !empty($performance_guarantee_num)) {$performance_guarantee_num=trim($performance_guarantee_num); } else {$performance_guarantee_num='0'; }
    $per_paid_status = $this->input->post('per_paid_status');
    if(isset($per_paid_status) && !empty($per_paid_status) && $per_paid_status == 'Yes') {$per_paid_status = 'Y'; } else {$per_paid_status = 'N'; }
    $per_payment_mode = $this->input->post('per_payment_mode');
    if(isset($per_payment_mode) && !empty($per_payment_mode)){$per_payment_mode =trim($per_payment_mode); } else {$per_payment_mode = ''; }
    $sd_pbg_fd = $this->input->post('sd_pbg_fd');
    if(isset($sd_pbg_fd) && !empty($sd_pbg_fd)){$sd_pbg_fd =trim($sd_pbg_fd); } else {$sd_pbg_fd = ''; }
    $pg_amount = $this->input->post('pg_amount');
    if(isset($pg_amount) && !empty($pg_amount)){$pg_amount =trim($pg_amount); } else {$pg_amount = 0; }

    if($performance_paid == 'Y'){
      if(empty($performance_guarantee_num)){
        //$error = 'Y';
        //$error_message = 'Please enter performance guarantee value!';
      }
    }
    $draft_performance_paid_file ='';
    $errormsg='';
    if(isset($_FILES['draft_performance_paid_file']['name']))//Code for to take image from form and check isset
    {
      $draft_performance_paid_file = $_FILES['draft_performance_paid_file']['name']; //here [] name attribute
      $draft_performance_paid_fileImg = array('upload_path' =>'./uploads/performance_gaurantee_document/',
      'fieldname' => 'draft_performance_paid_file',
      'encrypt_name' => TRUE,
      'overwrite' => FALSE,
      'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
      'max_size' => 15360);
      $draft_performance_paid_file_img = $this->imageupload->image_upload($draft_performance_paid_fileImg);
      $errormsg= $this->upload->display_errors();
      if(isset($draft_performance_paid_file_img) && !empty($draft_performance_paid_file_img))
      {
        $draft_performance_paid_fileData = $this->upload->data();
        $draft_performance_paid_file = $draft_performance_paid_fileData['file_name'];
      }
    }else{
      $draft_performance_paid_file = $this->input->post('hidden_draft_performance_paid_file');
      if(isset($draft_performance_paid_file) && !empty($draft_performance_paid_file)) {$draft_performance_paid_file = $draft_performance_paid_file; } else {$draft_performance_paid_file=''; }
    }
    if(isset($draft_performance_paid_file) && !empty($draft_performance_paid_file)) {$draft_performance_paid_file = $draft_performance_paid_file; } else {$draft_performance_paid_file=''; }
    if($performance_paid == 'Y'){
      if(empty($draft_performance_paid_file)){
        //$error = 'Y';
        //$error_message = 'Please Upload Draf Performance Bank Guarantee!';
      }
    }
    $final_performance_paid_file ='';
    $errormsg='';
    if(isset($_FILES['final_performance_paid_file']['name']))//Code for to take image from form and check isset
    {
      $final_performance_paid_file = $_FILES['final_performance_paid_file']['name']; //here [] name attribute
      $final_performance_paid_fileImg = array('upload_path' =>'./uploads/performance_gaurantee_document/',
      'fieldname' => 'final_performance_paid_file',
      'encrypt_name' => TRUE,
      'overwrite' => FALSE,
      'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
      'max_size' => 15360 );
      $final_performance_paid_file_img = $this->imageupload->image_upload($final_performance_paid_fileImg);
      $errormsg= $this->upload->display_errors();
      if(isset($final_performance_paid_file_img) && !empty($final_performance_paid_file_img))
      {
        $final_performance_paid_fileData = $this->upload->data();
        $final_performance_paid_file = $final_performance_paid_fileData['file_name'];
      }
    }else{
      $final_performance_paid_file = $this->input->post('hidden_final_performance_paid_file');
      if(isset($final_performance_paid_file) && !empty($final_performance_paid_file)) {$final_performance_paid_file = $final_performance_paid_file; } else {$final_performance_paid_file=''; }
    }
    if(isset($final_performance_paid_file) && !empty($final_performance_paid_file)) {$final_performance_paid_file = $final_performance_paid_file; } else {$final_performance_paid_file=''; }
    if($performance_paid == 'Y'){
      if(empty($final_performance_paid_file)){
        //$error = 'Y';
        //$error_message = 'Please Upload Final Performance Bank Guarantee!';
      }
    }
    $pbg_validity =$this->input->post('pbg_validity');
    if(isset($pbg_validity) && !empty($pbg_validity)) {$pbg_validity=trim($pbg_validity); } else {$pbg_validity='0'; }
    $security_deposite_num =$this->input->post('security_deposite_num');
    if(isset($security_deposite_num) && !empty($security_deposite_num)) {$security_deposite_num=trim($security_deposite_num); } else {$security_deposite_num='0'; }
    $warranty_period =$this->input->post('warranty_period');
    if(isset($warranty_period) && !empty($warranty_period)) {$warranty_period=trim($warranty_period); } else {$warranty_period='0'; }
    $billing_related =$this->input->post('billing_related');
    if(isset($billing_related) && !empty($billing_related)) {$billing_related=trim($billing_related); } else {$billing_related=''; }
    $po_related =$this->input->post('po_related');
    if(isset($po_related) && !empty($po_related)) {$po_related=trim($po_related); } else {$po_related=''; }
    $execution_related =$this->input->post('execution_related');
    if(isset($execution_related) && !empty($execution_related)) {$execution_related=trim($execution_related); } else {$execution_related=''; }
    $engineer_in_charge =$this->input->post('engineer_in_charge');
    if(isset($engineer_in_charge) && !empty($engineer_in_charge)) {$engineer_in_charge=trim($engineer_in_charge); } else {$engineer_in_charge=''; }
    $completion_period =$this->input->post('completion_period');
    if(isset($completion_period) && !empty($completion_period)) {$completion_period=trim($completion_period); } else {$completion_period='0'; }
    $gst_no =$this->input->post('gst_no');
    if(isset($gst_no) && !empty($gst_no)) {$gst_no=trim($gst_no); } else {$gst_no=''; }

    $price_inslusive_of_amc =$this->input->post('price_inslusive_of_amc');
    if(isset($price_inslusive_of_amc) && !empty($price_inslusive_of_amc) && $price_inslusive_of_amc == 'Yes') {$price_inslusive_of_amc = 'Y'; } else {$price_inslusive_of_amc='N'; }
    $amc_applicable_after =$this->input->post('amc_applicable_after');
    if(isset($amc_applicable_after) && !empty($amc_applicable_after)) {$amc_applicable_after=trim($amc_applicable_after); } else {$amc_applicable_after='0'; }
    if($price_inslusive_of_amc == 'Y'){
      if(empty($amc_applicable_after)){
        //$error = 'Y';
        //$error_message = 'Please enter AMC applicable after (Months) value!';
      }
    }

    $is_billing_inter_state =$this->input->post('is_billing_inter_state');
    if(isset($is_billing_inter_state) && !empty($is_billing_inter_state) && $is_billing_inter_state == 'Yes') {$is_billing_inter_state = 'Y'; } else {$is_billing_inter_state='N'; }

    $billing_address=$this->input->post('billing_address');
    if(isset($billing_address) && !empty($billing_address)) {$billing_address = $billing_address; } else {$billing_address=''; }
    $bill_same_as_reg_addr =$this->input->post('bill_same_as_reg_addr');
    if(isset($bill_same_as_reg_addr) && !empty($bill_same_as_reg_addr) && $bill_same_as_reg_addr == 'checked') {$bill_same_as_reg_addr = 'checked'; } else {$bill_same_as_reg_addr='unchecked'; }

    $consignee_name = $this->input->post('consignee_name');
    if(isset($consignee_name) && !empty($consignee_name)) {$consignee_name = $consignee_name; } else {$consignee_name=''; }
    $con_sdelivery_address = $this->input->post('delivery_address');
    if(isset($con_sdelivery_address) && !empty($con_sdelivery_address)) {$con_sdelivery_address = $con_sdelivery_address; } else {$con_sdelivery_address=''; }
    $con_gst_number = $this->input->post('gst_types');
    if(isset($con_gst_number) && !empty($con_gst_number)) {$con_gst_number = $con_gst_number; } else {$con_gst_number=''; }
    if(empty($consignee_name) || empty($con_sdelivery_address) || empty($con_gst_number)){
      //$error = 'Y';
      //$error_message = 'Please enter consignee required details!';
    }
    $insurance_req =$this->input->post('insurance_req');
    if(isset($insurance_req) && !empty($insurance_req) && $insurance_req == 'Yes') {$insurance_req='Y'; } else {$insurance_req='N'; }
    $insurance_remark =$this->input->post('insurance_remark');
    if(isset($insurance_remark) && !empty($insurance_remark)) {$insurance_remark = $insurance_remark; } else {$insurance_remark=''; }
    $insurance_up_to_date =$this->input->post('insurance_up_to_date');
    if(isset($insurance_up_to_date) && !empty($insurance_up_to_date)) {$insurance_up_to_date = $insurance_up_to_date; } else {$insurance_up_to_date=''; }
    $amount_of_risk_cov =$this->input->post('amount_of_risk_cov');
    if(isset($amount_of_risk_cov) && !empty($amount_of_risk_cov)) {$amount_of_risk_cov = $amount_of_risk_cov; } else {$amount_of_risk_cov='0'; }
    //$insurance_required_doc =$this->input->post('insurance_required_doc');
    //if(isset($insurance_required_doc) && !empty($insurance_required_doc)) {$insurance_required_doc = $insurance_required_doc; } else {$insurance_required_doc='0'; }
    if($insurance_req == 'Y'){
      if(empty($insurance_remark) || empty($insurance_up_to_date) || empty($amount_of_risk_cov)){
        //$error = 'Y';
        //$error_message = 'Please enter insurance required details!';
      }
    }

    $agreement_prepared =$this->input->post('agreement_prepared');
    if(isset($agreement_prepared) && !empty($agreement_prepared) && $agreement_prepared == 'Yes') {$agreement_prepared='Y'; } else {$agreement_prepared='N'; }
    //upload_draft_doc_file
    $upload_draft_doc_file ='';
    $errormsg='';
    if(isset($_FILES['upload_draft_doc_file']['name']))//Code for to take image from form and check isset
    {
      $upload_draft_doc_file = $_FILES['upload_draft_doc_file']['name']; //here [] name attribute
      $upload_draft_doc_fileImg = array('upload_path' =>'./uploads/agreement_prepared/',
      'fieldname' => 'upload_draft_doc_file',
      'encrypt_name' => TRUE,
      'overwrite' => FALSE,
      'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
      'max_size' => 15360 );
      $upload_draft_doc_file_img = $this->imageupload->image_upload($upload_draft_doc_fileImg);
      $errormsg= $this->upload->display_errors();
      if(isset($upload_draft_doc_file_img) && !empty($upload_draft_doc_file_img))
      {
        $upload_draft_doc_fileData = $this->upload->data();
        $upload_draft_doc_file = $upload_draft_doc_fileData['file_name'];
      }
    }else{
      $upload_draft_doc_file = $this->input->post('hidden_upload_draft_doc_file');
      if(isset($upload_draft_doc_file) && !empty($upload_draft_doc_file)) {$upload_draft_doc_file = $upload_draft_doc_file; } else {$upload_draft_doc_file=''; }
    }
    if(isset($upload_draft_doc_file) && !empty($upload_draft_doc_file)) {$upload_draft_doc_file = $upload_draft_doc_file; } else {$upload_draft_doc_file=''; }
    if($agreement_prepared == 'Y'){
      if(empty($upload_draft_doc_file)){
        //$error = 'Y';
        //$error_message = 'Please upload Draft Agreement Document!';
      }
    }

    //upload_sign_doc_file
    $upload_sign_doc_file ='';
    $errormsg='';
    if(isset($_FILES['upload_sign_doc_file']['name']))//Code for to take image from form and check isset
    {
      $upload_sign_doc_file = $_FILES['upload_sign_doc_file']['name']; //here [] name attribute
      $upload_sign_doc_fileImg = array('upload_path' =>'./uploads/agreement_prepared/',
      'fieldname' => 'upload_sign_doc_file',
      'encrypt_name' => TRUE,
      'overwrite' => FALSE,
      'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
      'max_size' => 15360 );
      $upload_sign_doc_file_img = $this->imageupload->image_upload($upload_sign_doc_fileImg);
      $errormsg= $this->upload->display_errors();
      if(isset($upload_sign_doc_file_img) && !empty($upload_sign_doc_file_img))
      {
        $upload_sign_doc_fileData = $this->upload->data();
        $upload_sign_doc_file = $upload_sign_doc_fileData['file_name'];
      }
    }else{
      $upload_sign_doc_file = $this->input->post('hidden_upload_sign_doc_file');
      if(isset($upload_sign_doc_file) && !empty($upload_sign_doc_file)) {$upload_sign_doc_file = $upload_sign_doc_file; } else {$upload_sign_doc_file=''; }
    }
    if(isset($upload_sign_doc_file) && !empty($upload_sign_doc_file)) {$upload_sign_doc_file = $upload_sign_doc_file; } else {$upload_sign_doc_file=''; }
    if($agreement_prepared == 'Y'){
      if(empty($upload_sign_doc_file)){
        //$error = 'Y';
        //$error_message = 'Please upload Draft Agreement Document!';
      }
    }

    // po_loi_doc

    $po_loi_doc ='';
    $errormsg='';
    if(isset($_FILES['po_loi_doc']['name']))
    {
      $po_loi_doc = $_FILES['po_loi_doc']['name'];
      $po_loi_docImg = array('upload_path' =>'./uploads/document_upload/',
      'fieldname' => 'po_loi_doc',
      'encrypt_name' => TRUE,
      'overwrite' => FALSE,
      'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
      'max_size' => 15360
    );
    $po_loi_doc_img = $this->imageupload->image_upload($po_loi_docImg);
    $errormsg= $this->upload->display_errors();
    if(isset($po_loi_doc_img) && !empty($po_loi_doc_img))
    {
      $po_loi_docData = $this->upload->data();
      $po_loi_doc = $po_loi_docData['file_name'];
    }
  }else{
    $po_loi_doc = $this->input->post('hidden_po_loi_doc');
    if(isset($po_loi_doc) && !empty($po_loi_doc)) {$po_loi_doc = $po_loi_doc; } else {$po_loi_doc=''; }
  }

  $payment_terms_document ='';
  $errormsg='';
  if(isset($_FILES['payment_terms_document']['name']))
  {
    $payment_terms_document = $_FILES['payment_terms_document']['name'];
    $payment_terms_documentImg = array('upload_path' =>'./uploads/document_upload/',
    'fieldname' => 'payment_terms_document',
    'encrypt_name' => TRUE,
    'overwrite' => FALSE,
    'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
    'max_size' => 15360
  );
  $payment_terms_document_img = $this->imageupload->image_upload($payment_terms_documentImg);
  $errormsg= $this->upload->display_errors();
  if(isset($payment_terms_document_img) && !empty($payment_terms_document_img))
  {
    $payment_terms_documentData = $this->upload->data();
    $payment_terms_document = $payment_terms_documentData['file_name'];
  }
}
// else{
//   $payment_terms_document = $this->input->post('hidden_payment_terms_document');
//   if(isset($payment_terms_document) && !empty($payment_terms_document)) {$payment_terms_document = $payment_terms_document; } else {$payment_terms_document=''; }
// }

// penalty_clause
$penalty_clause =$this->input->post('penalty_clause');
if(isset($penalty_clause) && !empty($penalty_clause)) {$penalty_clause=trim($penalty_clause); } else {$penalty_clause=''; }
$penalty_clause_file ='';
$errormsg='';
if(isset($_FILES['penalty_clause_file']['name']))//Code for to take image from form and check isset
{
  $penalty_clause_file = $_FILES['penalty_clause_file']['name']; //here [] name attribute
  $penalty_clause_fileImg = array('upload_path' =>'./uploads/document_upload/',
  'fieldname' => 'penalty_clause_file',
  'encrypt_name' => TRUE,
  'overwrite' => FALSE,
  'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
  'max_size' => 15360 );
  $penalty_clause_file_img = $this->imageupload->image_upload($penalty_clause_fileImg);
  $errormsg= $this->upload->display_errors();
  if(isset($penalty_clause_file_img) && !empty($penalty_clause_file_img))
  {
    $penalty_clause_fileData = $this->upload->data();
    $penalty_clause_file = $penalty_clause_fileData['file_name'];
  }
}else{
  $penalty_clause_file = $this->input->post('hidden_penalty_clause_file');
  if(isset($penalty_clause_file) && !empty($penalty_clause_file)) {$penalty_clause_file = $penalty_clause_file; } else {$penalty_clause_file=''; }
}


$power_of_attorney =$this->input->post('power_of_attorney');
if(isset($power_of_attorney) && !empty($power_of_attorney)) {$power_of_attorney=trim($power_of_attorney); } else {$power_of_attorney=''; }
$power_of_attorney_file ='';
$errormsg='';
if(isset($_FILES['power_of_attorney_file']['name']))//Code for to take image from form and check isset
{
  $power_of_attorney_file = $_FILES['power_of_attorney_file']['name']; //here [] name attribute
  $power_of_attorney_fileImg = array('upload_path' =>'./uploads/document_upload/',
  'fieldname' => 'power_of_attorney_file',
  'encrypt_name' => TRUE,
  'overwrite' => FALSE,
  'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
  'max_size' => 15360 );
  $power_of_attorney_file_img = $this->imageupload->image_upload($power_of_attorney_fileImg);
  $errormsg= $this->upload->display_errors();
  if(isset($power_of_attorney_file_img) && !empty($power_of_attorney_file_img))
  {
    $power_of_attorney_fileData = $this->upload->data();
    $power_of_attorney_file = $power_of_attorney_fileData['file_name'];
  }
}else{
  $power_of_attorney_file = $this->input->post('hidden_power_of_attorney_file');
  if(isset($power_of_attorney_file) && !empty($power_of_attorney_file)) {$power_of_attorney_file = $power_of_attorney_file; } else {$power_of_attorney_file=''; }
}
$sample =$this->input->post('sample');
if(isset($sample) && !empty($sample) && $sample == 'Y') {$sample = 'Y'; } else {$sample='N'; }
$sample_text =$this->input->post('sample_text');
if(isset($sample_text) && !empty($sample_text)) {$sample_text=$sample_text; } else {$sample_text=''; }
if($sample == 'Y'){
  if(empty($sample_text)){
    //$error = 'Y';
    //$error_message = 'Please enter sample value!';
  }
}
$prototype =$this->input->post('prototype');
if(isset($prototype) && !empty($prototype) && $prototype == 'Y') {$prototype = 'Y'; } else {$prototype='N'; }
$prototype_text =$this->input->post('prototype_text');
if(isset($prototype_text) && !empty($prototype_text)) {$prototype_text=$prototype_text; } else {$prototype_text=''; }
if($prototype == 'Y'){
  if(empty($prototype_text)){
    //$error = 'Y';
    //$error_message = 'Please enter prototype value!';
  }
}
$inspection =$this->input->post('inspection');
if(isset($inspection) && !empty($inspection) && $inspection == 'Y') {$inspection = 'Y'; } else {$inspection='N'; }
$inspection_text =$this->input->post('inspection_text');
if(isset($inspection_text) && !empty($inspection_text)) {$inspection_text=$inspection_text; } else {$inspection_text=''; }
if($inspection == 'Y'){
  if(empty($inspection_text)){
    //$error = 'Y';
    //$error_message = 'Please enter inspection value!';
  }
}
$fat =$this->input->post('fat');
if(isset($fat) && !empty($fat) && $fat == 'Y') {$fat='Y'; } else {$fat='N'; }
$fat_text = $this->input->post('fat_text');
if(isset($fat_text) && !empty($fat_text)) {$fat_text=$fat_text; } else {$fat_text=''; }
if($fat == 'Y'){
  if(empty($fat_text)){
    //$error = 'Y';
    //$error_message = 'Please enter FAT value!';
  }
}
$sat =$this->input->post('sat');
if(isset($sat) && !empty($sat) && $sat == 'Y') {$sat = 'Y'; } else {$sat='N'; }
$sat_text =$this->input->post('sat_text');
if(isset($sat_text) && !empty($sat_text)) {$sat_text=$sat_text; } else {$sat_text=''; }
if($sat == 'Y'){
  if(empty($sat_text)){
    //$error = 'Y';
    //$error_message = 'Please enter SAT value!';
  }
}
$test_report =$this->input->post('test_report');
if(isset($test_report) && !empty($test_report) && $test_report == 'Y') {$test_report = 'Y'; } else {$test_report='N'; }
$test_report_text =$this->input->post('test_report_text');
if(isset($test_report_text) && !empty($test_report_text)) {$test_report_text=$test_report_text; } else {$test_report_text=''; }
if($test_report == 'Y'){
  if(empty($test_report_text)){
    //$error = 'Y';
    //$error_message = 'Please enter SAT value!';
  }
}
$payment_terms =$this->input->post('payment_terms');
if(isset($payment_terms) && !empty($payment_terms)) {$payment_terms=trim($payment_terms); } else {$payment_terms='0'; }
$bill_split_supply =$this->input->post('bill_split_supply');
if(isset($bill_split_supply) && !empty($bill_split_supply)) {$bill_split_supply=trim($bill_split_supply); } else {$bill_split_supply='0'; }
$bill_installation =$this->input->post('bill_installation');
if(isset($bill_installation) && !empty($bill_installation)) {$bill_installation=trim($bill_installation); } else {$bill_installation='0'; }
$testing_commissioning =$this->input->post('testing_commissioning');
if(isset($testing_commissioning) && !empty($testing_commissioning)) {$testing_commissioning=trim($testing_commissioning); } else {$testing_commissioning='0'; }
$bill_handover =$this->input->post('bill_handover');
if(isset($bill_handover) && !empty($bill_handover)) {$bill_handover=trim($bill_handover); } else {$bill_handover='0'; }
if($payment_terms == 'S&I'){
  $totalper = $bill_split_supply + $bill_installation + $testing_commissioning + $bill_handover;
  if($totalper > 100 && $totalper > 0){
    $error = 'Y';
    $error_message = 'Billing split up must be less than equal to 100%!';
  }
}
$invoice_submitted =$this->input->post('invoice_submitted');
if(isset($invoice_submitted) && !empty($invoice_submitted) && $invoice_submitted == 'Yes') {$invoice_submitted = 'Y'; } else {$invoice_submitted='N'; }
$invoice_submitted_text =$this->input->post('invoice_submitted_text');
if(isset($invoice_submitted_text) && !empty($invoice_submitted_text)) {$invoice_submitted_text=trim($invoice_submitted_text); } else {$invoice_submitted_text=''; }
if($invoice_submitted == 'Y'){
  if(empty($invoice_submitted_text)){
    //$error = 'Y';
    //$error_message = 'Please enter invoice to be submitted on customer website value!';
  }
}
$invoice_submitted_address =$this->input->post('invoice_submitted_address');
if(isset($invoice_submitted_address) && !empty($invoice_submitted_address) && $invoice_submitted_address == 'Yes') {$invoice_submitted_address = 'Y'; } else {$invoice_submitted_address='N'; }
$invoice_submitted_address_text =$this->input->post('invoice_submitted_address_text');
if(isset($invoice_submitted_address_text) && !empty($invoice_submitted_address_text)) {$invoice_submitted_address_text=trim($invoice_submitted_address_text); } else {$invoice_submitted_address_text=''; }
if($invoice_submitted_address == 'Y'){
  if(empty($invoice_submitted_address_text)){
    //$error = 'Y';
    //$error_message = 'Please enter invoice to be sent on different address value!';
  }
}
$esic_required =$this->input->post('esic_required');
if(isset($esic_required) && !empty($esic_required) && $esic_required == 'Yes') {$esic_required = 'Y'; } else {$esic_required='N'; }
$esic_required_text =$this->input->post('esic_required_text');
if(isset($esic_required_text) && !empty($esic_required_text)) {$esic_required_text=trim($esic_required_text); } else {$esic_required_text=''; }
if($esic_required == 'Y'){
  if(empty($esic_required_text)){
    //$error = 'Y';
    //$error_message = 'Please enter ESIC required value!';
  }
}
$pf_required =$this->input->post('pf_required');
if(isset($pf_required) && !empty($pf_required) && $pf_required == 'Yes') {$pf_required = 'Y'; } else {$pf_required='N'; }
$pf_required_text =$this->input->post('pf_required_text');
if(isset($pf_required_text) && !empty($pf_required_text)) {$pf_required_text=trim($pf_required_text); } else {$pf_required_text=''; }
if($pf_required == 'Y'){
  if(empty($pf_required_text)){
    //$error = 'Y';
    //$error_message = 'Please enter PF required value!';
  }
}
$any_other_details =$this->input->post('any_other_details');
if(isset($any_other_details) && !empty($any_other_details)) {$any_other_details=trim($any_other_details); } else {$any_other_details=''; }
//upload_projectcmpl_doc_file
$upload_projectcmpl_doc_file ='';
$errormsg='';
if(isset($_FILES['upload_projectcmpl_doc_file']['name']))//Code for to take image from form and check isset
{
  $upload_projectcmpl_doc_file = $_FILES['upload_projectcmpl_doc_file']['name']; //here [] name attribute
  $upload_projectcmpl_doc_fileImg = array('upload_path' =>'./uploads/document_upload/',
  'fieldname' => 'upload_projectcmpl_doc_file',
  'encrypt_name' => TRUE,
  'overwrite' => FALSE,
  'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
  'max_size' => 15360 );
  $upload_projectcmpl_doc_file_img = $this->imageupload->image_upload($upload_projectcmpl_doc_fileImg);
  $errormsg= $this->upload->display_errors();
  if(isset($upload_projectcmpl_doc_file_img) && !empty($upload_projectcmpl_doc_file_img))
  {
    $upload_projectcmpl_doc_fileData = $this->upload->data();
    $upload_projectcmpl_doc_file = $upload_projectcmpl_doc_fileData['file_name'];
  }
}else{
  $upload_projectcmpl_doc_file = $this->input->post('hidden_upload_projectcmpl_doc_file');
  if(isset($upload_projectcmpl_doc_file) && !empty($upload_projectcmpl_doc_file)) {$upload_projectcmpl_doc_file = $upload_projectcmpl_doc_file; } else {$upload_projectcmpl_doc_file=''; }
}
if(isset($upload_projectcmpl_doc_file) && !empty($upload_projectcmpl_doc_file)) {$upload_projectcmpl_doc_file = $upload_projectcmpl_doc_file; } else {$upload_projectcmpl_doc_file=''; }

//upload_projectdesig_doc_file
$upload_projectdesig_doc_file ='';
$errormsg='';
if(isset($_FILES['upload_projectdesig_doc_file']['name']))//Code for to take image from form and check isset
{
  $upload_projectdesig_doc_file = $_FILES['upload_projectdesig_doc_file']['name']; //here [] name attribute
  $upload_projectdesig_doc_fileImg = array('upload_path' =>'./uploads/document_upload/',
  'fieldname' => 'upload_projectdesig_doc_file',
  'encrypt_name' => TRUE,
  'overwrite' => FALSE,
  'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
  'max_size' => 15360 );
  $upload_projectdesig_doc_file_img = $this->imageupload->image_upload($upload_projectdesig_doc_fileImg);
  $errormsg= $this->upload->display_errors();
  if(isset($upload_projectdesig_doc_file_img) && !empty($upload_projectdesig_doc_file_img))
  {
    $upload_projectdesig_doc_fileData = $this->upload->data();
    $upload_projectdesig_doc_file = $upload_projectdesig_doc_fileData['file_name'];
  }
}else{
  $upload_projectdesig_doc_file = $this->input->post('hidden_upload_projectdesig_doc_file');
  if(isset($upload_projectdesig_doc_file) && !empty($upload_projectdesig_doc_file)) {$upload_projectdesig_doc_file = $upload_projectdesig_doc_file; } else {$upload_projectdesig_doc_file=''; }
}
if(isset($upload_projectdesig_doc_file) && !empty($upload_projectdesig_doc_file)) {$upload_projectdesig_doc_file = $upload_projectdesig_doc_file; } else {$upload_projectdesig_doc_file=''; }

//upload_projectcashflw_doc_file
$upload_projectcashflw_doc_file ='';
$errormsg='';
if(isset($_FILES['upload_projectcashflw_doc_file']['name']))//Code for to take image from form and check isset
{
  $upload_projectcashflw_doc_file = $_FILES['upload_projectcashflw_doc_file']['name']; //here [] name attribute
  $upload_projectcashflw_doc_fileImg = array('upload_path' =>'./uploads/document_upload/',
  'fieldname' => 'upload_projectcashflw_doc_file',
  'encrypt_name' => TRUE,
  'overwrite' => FALSE,
  'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
  'max_size' => 15360 );
  $upload_projectcashflw_doc_file_img = $this->imageupload->image_upload($upload_projectcashflw_doc_fileImg);
  $errormsg= $this->upload->display_errors();
  if(isset($upload_projectcashflw_doc_file_img) && !empty($upload_projectcashflw_doc_file_img))
  {
    $upload_projectcashflw_doc_fileData = $this->upload->data();
    $upload_projectcashflw_doc_file = $upload_projectcashflw_doc_fileData['file_name'];
  }
}else{
  $upload_projectcashflw_doc_file = $this->input->post('hidden_upload_projectcashflw_doc_file');
  if(isset($upload_projectcashflw_doc_file) && !empty($upload_projectcashflw_doc_file)) {$upload_projectcashflw_doc_file = $upload_projectcashflw_doc_file; } else {$upload_projectcashflw_doc_file=''; }
}
if(isset($upload_projectcashflw_doc_file) && !empty($upload_projectcashflw_doc_file)) {$upload_projectcashflw_doc_file = $upload_projectcashflw_doc_file; } else {$upload_projectcashflw_doc_file=''; }

//upload_projectinvstsch_doc_file
$upload_projectinvstsch_doc_file ='';
$errormsg='';
if(isset($_FILES['upload_projectinvstsch_doc_file']['name']))//Code for to take image from form and check isset
{
  $upload_projectinvstsch_doc_file = $_FILES['upload_projectinvstsch_doc_file']['name']; //here [] name attribute
  $upload_projectinvstsch_doc_fileImg = array('upload_path' =>'./uploads/document_upload/',
  'fieldname' => 'upload_projectinvstsch_doc_file',
  'encrypt_name' => TRUE,
  'overwrite' => FALSE,
  'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
  'max_size' => 15360 );
  $upload_projectinvstsch_doc_file_img = $this->imageupload->image_upload($upload_projectinvstsch_doc_fileImg);
  $errormsg= $this->upload->display_errors();
  if(isset($upload_projectinvstsch_doc_file_img) && !empty($upload_projectinvstsch_doc_file_img))
  {
    $upload_projectinvstsch_doc_fileData = $this->upload->data();
    $upload_projectinvstsch_doc_file = $upload_projectinvstsch_doc_fileData['file_name'];
  }
}else{
  $upload_projectinvstsch_doc_file = $this->input->post('hidden_upload_projectinvstsch_doc_file');
  if(isset($upload_projectinvstsch_doc_file) && !empty($upload_projectinvstsch_doc_file)) {$upload_projectinvstsch_doc_file = $upload_projectinvstsch_doc_file; } else {$upload_projectinvstsch_doc_file=''; }
}
if(isset($upload_projectinvstsch_doc_file) && !empty($upload_projectinvstsch_doc_file)) {$upload_projectinvstsch_doc_file = $upload_projectinvstsch_doc_file; } else {$upload_projectinvstsch_doc_file=''; }

$data = array('customer_code'=>$customer_code,'customer_name'=>$customer_name,'bp_code'=>$bp_code,
'po_loi_no'=>$po_loi_no, 'po_loi_received_data'=>$po_loi_received_data, 'po_loi_doc'=> $po_loi_doc,'registered_address'=>$registered_address,
'client_po_addr'=>$client_po_addr, 'our_address_on_po'=>$our_address_on_po,'name_of_work'=>$name_of_work,
'work_order_on'=>$work_order_on, 'site_address'=>$site_address, 'taxable_amount'=>$taxable_amount, 'gst_rate'=>$gst_rate,'gst_amount'=>$gst_amount,
'total_amount'=>$total_amount, 'emd_paid'=>$emd_paid, 'emd_paid_num'=>$emd_paid_num,'emd_paid_status'=>$emd_paid_status,'emd_payment_mode' => $emd_payment_mode,
'business_head' => $business_head,'manager_head' => $manager_head,
'asd_paid'=>$asd_paid, 'asd_paid_num'=>$asd_paid_num, 'asd_paid_status'=>$asd_paid_status,'asd_payment_mode' => $asd_payment_mode, 'performance_paid'=>$performance_paid,
'performance_guarantee_num'=>$performance_guarantee_num,'per_paid_status'=>$per_paid_status,'per_payment_mode' => $per_payment_mode,
'sd_pbg_fd'=>$sd_pbg_fd,'pg_amount'=>$pg_amount,'pbg_validity'=>$pbg_validity, 'security_deposite_num'=>$security_deposite_num,
'warranty_period'=>$warranty_period, 'billing_related'=>$billing_related, 'po_related'=>$po_related, 'execution_related'=>$execution_related,
'engineer_in_charge'=>$engineer_in_charge,'completion_period'=>$completion_period, 'gst_no'=>$gst_no, 'price_inslusive_of_amc'=>$price_inslusive_of_amc,
'amc_applicable_after'=>$amc_applicable_after, 'is_billing_inter_state'=>$is_billing_inter_state,
'billing_address'=>$billing_address,'bill_same_as_reg_addr' => $bill_same_as_reg_addr,

// 'delivery_address'=>$delivery_address,
'insurance_req'=>$insurance_req, 'agreement_prepared'=>$agreement_prepared, 'penalty_clause'=>$penalty_clause,
'power_of_attorney'=>$power_of_attorney, 'sample'=>$sample,'prototype'=>$prototype,'inspection'=>$inspection,'fat'=>$fat,'sat'=>$sat,'test_report'=>$test_report,'payment_terms'=>$payment_terms,
'bill_split_supply'=>$bill_split_supply,'bill_installation'=>$bill_installation, 'testing_commissioning'=>$testing_commissioning, 'bill_handover'=>$bill_handover,
'invoice_submitted'=>$invoice_submitted, 'invoice_submitted_text'=>$invoice_submitted_text, 'invoice_submitted_address'=>$invoice_submitted_address,
'invoice_submitted_address_text'=>$invoice_submitted_address_text, 'esic_required'=>$esic_required, 'esic_required_text'=>$esic_required_text,
'pf_required'=>$pf_required, 'pf_required_text'=>$pf_required_text, 'any_other_details'=>$any_other_details, 'payment_terms_document'=>$payment_terms_document,
'display'=>'Y', 'created_date'=>date('Y-m-d H:i:s'), 'created_by'=>$user_id,'upload_emd_paid_file'=>$upload_emd_paid_file,
'upload_asd_paid_file'=>$upload_asd_paid_file,'final_performance_paid_file'=>$final_performance_paid_file,'draft_performance_paid_file'=>$draft_performance_paid_file,
'emd_converted_deposit' => $emd_converted_deposit,
'asd_converted_deposit' => $asd_converted_deposit,
'projectcmpl_doc_file'=>$upload_projectcmpl_doc_file,'projectdesig_doc_file'=>$upload_projectdesig_doc_file,
'projectcashflw_doc_file'=>$upload_projectcashflw_doc_file,'projectinvstsch_doc_file'=>$upload_projectinvstsch_doc_file,
'sign_doc_file'=>$upload_sign_doc_file,'draft_doc_file'=>$upload_draft_doc_file,'penalty_clause_file'=>$penalty_clause_file,'power_of_attorney_file'=>$power_of_attorney_file);

// pr($data);
if($error == 'N'){

  $project_id = $this->common_model->addData('tbl_projects',$data);

  //   pr($this->db->last_query());
  if(isset($project_id) && !empty($project_id)){
    $action_url = base_url().'create-project-list';
    $activity = '#'.$bp_code.' OEF waiting for approval!';
    $approved_noti_arr = array('activity'=>$activity,'action_id'=>$project_id,'action_url'=>$action_url,'created_by'=>$user_id,
    'created_date'=>date('Y-m-d H:i:s'),'modified_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id);
    //$this->common_model->addData('tbl_approval_waiting',$approved_noti_arr);
    if($insurance_req == 'Y'){
      $cpt = count($_FILES['insurance_required_doc']['name']);
      $save_insurance_data = array();
      if(isset($insurance_remark) && !empty($insurance_remark) &&
      isset($insurance_up_to_date) && !empty($insurance_up_to_date) &&
      isset($amount_of_risk_cov) && !empty($amount_of_risk_cov) &&
      isset($cpt) && !empty($cpt) && $cpt > 0){
        $files = $_FILES;
        for($i=0;$i < count($insurance_remark); $i++){
          $_FILES['insurance_required_doc']['name']= $files['insurance_required_doc']['name'][$i];
          $_FILES['insurance_required_doc']['type']= $files['insurance_required_doc']['type'][$i];
          $_FILES['insurance_required_doc']['tmp_name']= $files['insurance_required_doc']['tmp_name'][$i];
          $_FILES['insurance_required_doc']['error']= $files['insurance_required_doc']['error'][$i];
          $_FILES['insurance_required_doc']['size']= $files['insurance_required_doc']['size'][$i];
          $set_upload_options = array('upload_path' =>'./uploads/insurance_required/',
          'encrypt_name' => TRUE,
          'overwrite' => FALSE,
          'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
          'max_size' => 15360 );
          //  $this->imageupload->image_upload($set_upload_options);
          //  $this->upload->data();
          $this->upload->initialize($set_upload_options);
          $this->upload->do_upload('insurance_required_doc');
          $uploadedFileName = $this->upload->data('file_name');
          if(isset($uploadedFileName) &&!empty($uploadedFileName)){
            $uploadedFileName = $uploadedFileName;
          }else{
            $uploadedFileName = '';
          }
          if(isset($insurance_remark[$i]) && !empty($insurance_remark[$i])
          && isset($insurance_up_to_date[$i]) && !empty($insurance_up_to_date[$i])
          && isset($amount_of_risk_cov[$i]) && !empty($amount_of_risk_cov[$i])){
            $insdate = date('Y-m-d',strtotime($insurance_up_to_date[$i]));
            $save_insurance_data[] = array('project_id'=>$project_id,'remark'=>$insurance_remark[$i],
            'insdate'=>$insdate,'amount'=>$amount_of_risk_cov[$i],'insurance_required_doc'=>$uploadedFileName);
          }
        }
      }
      if(isset($save_insurance_data) && !empty($save_insurance_data)){
        $this->common_model->SaveMultiData('tbl_insurance_data',$save_insurance_data);
      }
    }
    if($consignee_name && $con_sdelivery_address && $con_gst_number){
      $save_consignee_data = array();
      for($i = 0;$i<count($consignee_name);$i++) {
        if(isset($consignee_name[$i]) && !empty($consignee_name[$i])
        && isset($con_sdelivery_address[$i]) && !empty($con_sdelivery_address[$i])
        && isset($con_gst_number[$i]) && !empty($con_gst_number[$i])){
          $save_consignee_data[] = array('project_id'=>$project_id,'consignee_name'=>$consignee_name[$i],
          'delivery_address'=>$con_sdelivery_address[$i],'gst_number'=>$con_gst_number[$i]);
        }
      }
      if(isset($save_consignee_data) && !empty($save_consignee_data)){
        $this->common_model->SaveMultiData('tbl_deliv_challan_consignee',$save_consignee_data);
      }
    }
    if($sample == 'Y'){
      $save_sample_data = array();
      if(isset($sample_text) && !empty($sample_text)){
        for($i=0;$i < count($sample_text); $i++){
          if(!empty($sample_text[$i])){
            $save_sample_data[] = array('project_id'=>$project_id,'sample'=>$sample_text[$i]);
          }
        }
      }
      if(isset($save_sample_data) && !empty($save_sample_data)){
        $this->common_model->SaveMultiData('tbl_sample',$save_sample_data);
      }
    }
    if($prototype == 'Y'){
      $save_prototype_data = array();
      if(isset($prototype_text) && !empty($prototype_text)){
        for($i=0;$i < count($prototype_text); $i++){
          if(!empty($prototype_text[$i])){
            $save_prototype_data[] = array('project_id'=>$project_id,'prototype'=>$prototype_text[$i]);
          }
        }
      }
      if(isset($save_prototype_data) && !empty($save_prototype_data)){
        $this->common_model->SaveMultiData('tbl_prototype',$save_prototype_data);
      }
    }
    if($inspection == 'Y'){
      $save_inspection_data = array();
      if(isset($inspection_text) && !empty($inspection_text)){
        for($i=0;$i < count($inspection_text); $i++){
          if(!empty($inspection_text[$i])){
            $save_inspection_data[] = array('project_id'=>$project_id,'inspection'=>$inspection_text[$i]);
          }
        }
      }
      if(isset($save_inspection_data) && !empty($save_inspection_data)){
        $this->common_model->SaveMultiData('tbl_inspection',$save_inspection_data);
      }
    }
    if($fat == 'Y'){
      $save_fat_data = array();
      if(isset($fat_text) && !empty($fat_text)){
        for($i=0;$i < count($fat_text); $i++){
          if(!empty($fat_text[$i])){
            $save_fat_data[] = array('project_id'=>$project_id,'fat'=>$fat_text[$i]);
          }
        }
      }
      if(isset($save_fat_data) && !empty($save_fat_data)){
        $this->common_model->SaveMultiData('tbl_fat',$save_fat_data);
      }
    }
    if($sat == 'Y'){
      $save_sat_data = array();
      if(isset($sat_text) && !empty($sat_text)){
        for($i=0;$i < count($sat_text); $i++){
          if(!empty($sat_text[$i])){
            $save_sat_data[] = array('project_id'=>$project_id,'sat'=>$sat_text[$i]);
          }
        }
      }
      if(isset($save_sat_data) && !empty($save_sat_data)){
        $this->common_model->SaveMultiData('tbl_sat',$save_sat_data);
      }
    }
    if($test_report == 'Y'){
      $test_report_data = array();
      if(isset($test_report_text) && !empty($test_report_text)){
        for($i=0;$i < count($test_report_text); $i++){
          if(!empty($test_report_text[$i])){
            $save_test_report_data[] = array('project_id'=>$project_id,'test_report'=>$test_report_text[$i]);
          }
        }
      }
      if(isset($save_test_report_data) && !empty($save_test_report_data)){
        $this->common_model->SaveMultiData('tbl_test_report',$save_test_report_data);
      }
    }
    $this->json->jsonReturn(array(
      'valid'=>TRUE,
      'msg'=>'<div class="alert modify alert-info"><strong>Welldone!</strong>Project Details Saved Successfully!</div>',
      'redirect' => base_url().'create-project-list'
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
}
public function update_create_project()
{
  $error = 'N';
  $error_message = '';
  $user_id = $this->session->userdata('user_id');
  if(isset($user_id) && empty($user_id)){
    $error = 'Y';
    $error_message = 'Please loggedin!';
  }
  $loguser_id = $this->session->userData('user_id');
  $logrole_id = $this->session->userData('role_id');
  if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
    $submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','update_create_project');
    if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
      $submenu_id = $submenu_data->submenu_id;
      $check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
      if(isset($check_permission) && !empty($check_permission)){
        $project_id = $this->input->post('update_project_id');
        if(isset($project_id) && !empty($project_id)){
          $project_data = $this->common_model->selectDetailsWhr('tbl_projects','project_id',$project_id);
          if(isset($project_data) && !empty($project_data)){
            $bp_code = $this->input->post('bp_code');
            if(isset($bp_code) && !empty($bp_code)) {$bp_code=trim($bp_code); } else {$bp_code=$project_data->bp_code; }
            $bp_code_exist = $this->admin_model->check_exist_wip_no('project',$project_id,$bp_code);
            if(isset($bp_code_exist) && !empty($bp_code_exist)){
              $error = 'Y';
              $error_message = 'This BP Code already exist!';
            }else{
              $customer_name = $this->input->post('customer_name');
              if(isset($customer_name) && !empty($customer_name)) {$customer_name=trim($customer_name); } else {$customer_name=$project_data->customer_name; }
              $business_head = $this->input->post('business_head');
              if(isset($business_head) && !empty($business_head)) {$business_head=trim($business_head); } else {$business_head=$project_data->business_head; }
              $manager_head = $this->input->post('manager_head');
              if(isset($manager_head) && !empty($manager_head)) {$manager_head=trim($manager_head); } else {$manager_head=$project_data->manager_head; }
              $gst_rate = $this->input->post('gst_rate');
              if(isset($gst_rate) && !empty($gst_rate)) {$gst_rate=$gst_rate; } else {$gst_rate=0; }
              $emd_converted_deposit = $this->input->post('emd_converted_deposit');
              if(isset($emd_converted_deposit) && !empty($emd_converted_deposit)) {$emd_converted_deposit=trim($emd_converted_deposit); } else {$emd_converted_deposit=$project_data->emd_converted_deposit; }
              $asd_converted_deposit = $this->input->post('asd_converted_deposit');
              if(isset($asd_converted_deposit) && !empty($asd_converted_deposit)) {$asd_converted_deposit=trim($asd_converted_deposit); } else {$asd_converted_deposit=$project_data->asd_converted_deposit; }
              if(isset($bp_code) && empty($bp_code)){
                $error = 'Y';
                $error_message = 'Please enter BP Code!';
              }
              $po_loi_no =$this->input->post('po_loi_no');
              if(isset($po_loi_no) && !empty($po_loi_no)) {$po_loi_no=trim($po_loi_no); } else {$po_loi_no=$project_data->po_loi_no; }
              $po_loi_received_data =$this->input->post('po_loi_received_data');
              if(isset($po_loi_received_data) && !empty($po_loi_received_data)) {$po_loi_received_data = date('Y-m-d',strtotime($po_loi_received_data)); } else {$po_loi_received_data=$project_data->po_loi_received_data; }
              $registered_address =$this->input->post('registered_address');
              if(isset($registered_address) && !empty($registered_address)) {$registered_address=trim($registered_address); } else {$registered_address=$project_data->registered_address; }
              $client_po_addr =$this->input->post('client_po_addr');
              if(isset($client_po_addr) && !empty($client_po_addr)) {$client_po_addr=trim($client_po_addr); } else {$client_po_addr=$project_data->client_po_addr; }
              $our_address_on_po =$this->input->post('our_address_on_po');
              if(isset($our_address_on_po) && !empty($our_address_on_po)) {$our_address_on_po=trim($our_address_on_po); } else {$our_address_on_po=$project_data->our_address_on_po; }
              $name_of_work =$this->input->post('name_of_work');
              if(isset($name_of_work) && !empty($name_of_work)) {$name_of_work=trim($name_of_work); } else {$name_of_work=$project_data->name_of_work; }
              $work_order_on =$this->input->post('work_order_on');
              if(isset($work_order_on) && !empty($work_order_on)) {$work_order_on=trim($work_order_on); } else {$work_order_on=$project_data->work_order_on; }
              $site_address =$this->input->post('site_address');
              if(isset($site_address) && !empty($site_address)) {$site_address=trim($site_address); } else {$site_address=$project_data->site_address; }
              $taxable_amount =$this->input->post('taxable_amount');
              if(isset($taxable_amount) && !empty($taxable_amount)) {$taxable_amount=trim($taxable_amount); } else {$taxable_amount='0'; }
              $gst_amount =$this->input->post('gst_amount');
              if(isset($gst_amount) && !empty($gst_amount)) {$gst_amount=trim($gst_amount); } else {$gst_amount='0'; }
              $total_amount =$this->input->post('total_amount');
              if(isset($total_amount) && !empty($total_amount)) {$total_amount=trim($total_amount); } else {$total_amount='0'; }
              $emd_paid = $this->input->post('emd_paid');
              if(isset($emd_paid) && !empty($emd_paid) && $emd_paid == 'Y') {$emd_paid = 'Y'; } else {$emd_paid= 'N'; }
              $emd_paid_num =$this->input->post('emd_paid_num');
              if(isset($emd_paid_num) && !empty($emd_paid_num)) {$emd_paid_num=trim($emd_paid_num); } else {$emd_paid_num='0'; }
              $emd_payment_mode = $this->input->post('emd_payment_mode');
              if(isset($emd_payment_mode) && !empty($emd_payment_mode)) {$emd_payment_mode=trim($emd_payment_mode); } else {$emd_payment_mode=''; }
              $upload_emd_paid_file ='';
              if($emd_paid == 'Y'){
                $errormsg='';
                if(isset($_FILES['upload_emd_paid_file']['name'])){
                  $upload_emd_paid_file = $_FILES['upload_emd_paid_file']['name']; //here [] name attribute
                  $upload_emd_paid_fileImg = array('upload_path' =>'./uploads/emd_paid_document/',
                  'fieldname' => 'upload_emd_paid_file',
                  'encrypt_name' => TRUE,
                  'overwrite' => FALSE,
                  'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
                  'max_size' => 15360 );
                  $upload_emd_paid_file_img = $this->imageupload->image_upload($upload_emd_paid_fileImg);
                  $errormsg= $this->upload->display_errors();
                  if(isset($upload_emd_paid_file_img) && !empty($upload_emd_paid_file_img))
                  {
                    $upload_emd_paid_fileData = $this->upload->data();
                    $upload_emd_paid_file = $upload_emd_paid_fileData['file_name'];
                  }
                }else{
                  if(isset($project_data->upload_emd_paid_file) && !empty($project_data->upload_emd_paid_file)) {
                    $upload_emd_paid_file = $project_data->upload_emd_paid_file;
                  }
                }
              }
              if(isset($upload_emd_paid_file) && !empty($upload_emd_paid_file)) {$upload_emd_paid_file = $upload_emd_paid_file; } else {$upload_emd_paid_file=''; }
              if($emd_paid == 'Y'){
                if(empty($upload_emd_paid_file)){
                  $error = 'Y';
                  $error_message = 'Please Upload EMD Paid!';
                }
              }
              $emd_paid_status =$this->input->post('emd_paid_status');
              if(isset($emd_paid_status) && !empty($emd_paid_status) && $emd_paid_status == 'Yes') {$emd_paid_status = 'Y'; } else {$emd_paid_status = 'N'; }
              if($emd_paid == 'Y'){
                if(empty($emd_paid_num)){
                  $error = 'Y';
                  $error_message = 'Please enter EMD paid value!';
                }
              }
              $asd_paid =$this->input->post('asd_paid');
              if(isset($asd_paid) && !empty($asd_paid) && $asd_paid == 'Y') {$asd_paid = 'Y'; } else {$asd_paid = 'N'; }
              $upload_asd_paid_file ='';
              if($asd_paid == 'Y'){
                $errormsg='';
                if(isset($_FILES['upload_asd_paid_file']['name']))//Code for to take image from form and check isset
                {
                  $upload_asd_paid_file = $_FILES['upload_asd_paid_file']['name']; //here [] name attribute
                  $upload_asd_paid_fileImg = array('upload_path' =>'./uploads/asd_paid_document/',
                  'fieldname' => 'upload_asd_paid_file',
                  'encrypt_name' => TRUE,
                  'overwrite' => FALSE,
                  'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
                  'max_size' => 15360
                );
                $upload_asd_paid_file_img = $this->imageupload->image_upload($upload_asd_paid_fileImg);
                $errormsg= $this->upload->display_errors();
                if(isset($upload_asd_paid_file_img) && !empty($upload_asd_paid_file_img))
                {
                  $upload_asd_paid_fileData = $this->upload->data();
                  $upload_asd_paid_file = $upload_asd_paid_fileData['file_name'];
                }
              }else{
                if(isset($project_data->upload_asd_paid_file) && !empty($project_data->upload_asd_paid_file)) {
                  $upload_asd_paid_file = $project_data->upload_asd_paid_file;
                }
              }
            }
            if(isset($upload_asd_paid_file) && !empty($upload_asd_paid_file)) {$upload_asd_paid_file = $upload_asd_paid_file; } else {$upload_asd_paid_file=''; }
            if($asd_paid == 'Y'){
              if(empty($upload_asd_paid_file)){
                $error = 'Y';
                $error_message = 'Please Upload ASD Paid!';
              }
            }
            $asd_paid_num = $this->input->post('asd_paid_num');
            if(isset($asd_paid_num) && !empty($asd_paid_num)) {$asd_paid_num=trim($asd_paid_num); } else {$asd_paid_num='0'; }
            $asd_paid_status = $this->input->post('asd_paid_status');
            if(isset($asd_paid_status) && !empty($asd_paid_status) && $asd_paid_status == 'Yes') {$asd_paid_status = 'Y'; } else {$asd_paid_status = 'N'; }
            $asd_payment_mode = $this->input->post('asd_payment_mode');
            if(isset($asd_payment_mode) && !empty($asd_payment_mode)){$asd_payment_mode =trim($asd_payment_mode); } else {$asd_payment_mode = ''; }
            if($asd_paid == 'Y'){
              if(empty($asd_paid_num)){
                $error = 'Y';
                $error_message = 'Please enter ASD paid value!';
              }
            }
            $performance_paid =$this->input->post('performance_paid');
            if(isset($performance_paid) && !empty($performance_paid) && $performance_paid == 'Y') {$performance_paid = 'Y'; } else {$performance_paid = 'N'; }
            $performance_guarantee_num = $this->input->post('performance_guarantee_num');
            if(isset($performance_guarantee_num) && !empty($performance_guarantee_num)) {$performance_guarantee_num=trim($performance_guarantee_num); } else {$performance_guarantee_num='0'; }
            $per_paid_status = $this->input->post('per_paid_status');
            if(isset($per_paid_status) && !empty($per_paid_status) && $per_paid_status == 'Yes') {$per_paid_status = 'Y'; } else {$per_paid_status = 'N'; }
            $per_payment_mode = $this->input->post('per_payment_mode');
            if(isset($per_payment_mode) && !empty($per_payment_mode)){$per_payment_mode =trim($per_payment_mode); } else {$per_payment_mode = ''; }
            $sd_pbg_fd = $this->input->post('sd_pbg_fd');
            if(isset($sd_pbg_fd) && !empty($sd_pbg_fd)){$sd_pbg_fd =trim($sd_pbg_fd); } else {$sd_pbg_fd = ''; }
            $pg_amount = $this->input->post('pg_amount');
            if(isset($pg_amount) && !empty($pg_amount)){$pg_amount =trim($pg_amount); } else {$pg_amount = 0; }
            if($performance_paid == 'Y'){
              if(empty($performance_guarantee_num)){
                $error = 'Y';
                $error_message = 'Please enter performance guarantee value!';
              }
            }
            $draft_performance_paid_file ='';
            if($performance_paid == 'Y'){
              $errormsg='';
              if(isset($_FILES['draft_performance_paid_file']['name']))//Code for to take image from form and check isset
              {
                $draft_performance_paid_file = $_FILES['draft_performance_paid_file']['name']; //here [] name attribute
                $draft_performance_paid_fileImg = array('upload_path' =>'./uploads/performance_gaurantee_document/',
                'fieldname' => 'draft_performance_paid_file',
                'encrypt_name' => TRUE,
                'overwrite' => FALSE,
                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
                'max_size' => 15360 );
                $draft_performance_paid_file_img = $this->imageupload->image_upload($draft_performance_paid_fileImg);
                $errormsg= $this->upload->display_errors();
                if(isset($draft_performance_paid_file_img) && !empty($draft_performance_paid_file_img))
                {
                  $draft_performance_paid_fileData = $this->upload->data();
                  $draft_performance_paid_file = $draft_performance_paid_fileData['file_name'];
                }else{
                  if(isset($project_data->draft_performance_paid_file) && !empty($project_data->draft_performance_paid_file)) {
                    $draft_performance_paid_file = $project_data->draft_performance_paid_file;
                  }
                }
              }else{
                if(isset($project_data->draft_performance_paid_file) && !empty($project_data->draft_performance_paid_file)) {
                  $draft_performance_paid_file = $project_data->draft_performance_paid_file;
                }
              }
            }
            if(isset($draft_performance_paid_file) && !empty($draft_performance_paid_file)) {$draft_performance_paid_file = $draft_performance_paid_file; } else {$draft_performance_paid_file=''; }
            if($performance_paid == 'Y'){
              if(empty($draft_performance_paid_file)){
                $error = 'Y';
                $error_message = 'Please Upload Draf Performance Bank Guarantee!';
              }
            }
            $final_performance_paid_file ='';
            $errormsg='';
            if(isset($_FILES['final_performance_paid_file']['name']))//Code for to take image from form and check isset
            {
              $final_performance_paid_file = $_FILES['final_performance_paid_file']['name']; //here [] name attribute
              $final_performance_paid_fileImg = array('upload_path' =>'./uploads/performance_gaurantee_document/',
              'fieldname' => 'final_performance_paid_file',
              'encrypt_name' => TRUE,
              'overwrite' => FALSE,
              'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
              'max_size' => 15360 );
              $final_performance_paid_file_img = $this->imageupload->image_upload($final_performance_paid_fileImg);
              $errormsg= $this->upload->display_errors();
              if(isset($final_performance_paid_file_img) && !empty($final_performance_paid_file_img))
              {
                $final_performance_paid_fileData = $this->upload->data();
                $final_performance_paid_file = $final_performance_paid_fileData['file_name'];
              }
            }else{
              if(isset($project_data->final_performance_paid_file) && !empty($project_data->final_performance_paid_file)) {
                $final_performance_paid_file = $project_data->final_performance_paid_file;
              }
            }
            if(isset($final_performance_paid_file) && !empty($final_performance_paid_file)) {$final_performance_paid_file = $final_performance_paid_file; } else {$final_performance_paid_file=''; }
            $pbg_validity =$this->input->post('pbg_validity');
            if(isset($pbg_validity) && !empty($pbg_validity)) {$pbg_validity=trim($pbg_validity); } else {$pbg_validity='0'; }
            $security_deposite_num =$this->input->post('security_deposite_num');
            if(isset($security_deposite_num) && !empty($security_deposite_num)) {$security_deposite_num=trim($security_deposite_num); } else {$security_deposite_num='0'; }
            $warranty_period =$this->input->post('warranty_period');
            if(isset($warranty_period) && !empty($warranty_period)) {$warranty_period=trim($warranty_period); } else {$warranty_period='0'; }
            $billing_related =$this->input->post('billing_related');
            if(isset($billing_related) && !empty($billing_related)) {$billing_related=trim($billing_related); } else {$billing_related=''; }
            $po_related =$this->input->post('po_related');
            if(isset($po_related) && !empty($po_related)) {$po_related=trim($po_related); } else {$po_related=''; }
            $execution_related =$this->input->post('execution_related');
            if(isset($execution_related) && !empty($execution_related)) {$execution_related=trim($execution_related); } else {$execution_related=''; }
            $engineer_in_charge =$this->input->post('engineer_in_charge');
            if(isset($engineer_in_charge) && !empty($engineer_in_charge)) {$engineer_in_charge=trim($engineer_in_charge); } else {$engineer_in_charge=''; }
            $completion_period =$this->input->post('completion_period');
            if(isset($completion_period) && !empty($completion_period)) {$completion_period=trim($completion_period); } else {$completion_period='0'; }
            $gst_no =$this->input->post('gst_no');
            if(isset($gst_no) && !empty($gst_no)) {$gst_no=trim($gst_no); } else {$gst_no=''; }
            $price_inslusive_of_amc =$this->input->post('price_inslusive_of_amc');
            if(isset($price_inslusive_of_amc) && !empty($price_inslusive_of_amc) && $price_inslusive_of_amc == 'Yes') {$price_inslusive_of_amc = 'Y'; } else {$price_inslusive_of_amc='N'; }
            $amc_applicable_after =$this->input->post('amc_applicable_after');
            if(isset($amc_applicable_after) && !empty($amc_applicable_after)) {$amc_applicable_after=trim($amc_applicable_after); } else {$amc_applicable_after='0'; }
            if($price_inslusive_of_amc == 'Y'){
              if(empty($amc_applicable_after)){
                $error = 'Y';
                $error_message = 'Please enter AMC applicable after (Months) value!';
              }
            }
            $is_billing_inter_state =$this->input->post('is_billing_inter_state');
            if(isset($is_billing_inter_state) && !empty($is_billing_inter_state) && $is_billing_inter_state == 'Yes') {$is_billing_inter_state = 'Y'; } else {$is_billing_inter_state='N'; }
            $bill_same_as_reg_addr =$this->input->post('bill_same_as_reg_addr');
            if(isset($bill_same_as_reg_addr) && !empty($bill_same_as_reg_addr) && $bill_same_as_reg_addr == 'checked') {$bill_same_as_reg_addr = 'checked'; } else {$bill_same_as_reg_addr='unchecked'; }

            $billing_address=$this->input->post('billing_address');
            if(isset($billing_address) && !empty($billing_address)) {$billing_address = $billing_address; } else {$billing_address=''; }

            $consignee_name = $this->input->post('consignee_name');
            if(isset($consignee_name) && !empty($consignee_name)) {$consignee_name = $consignee_name; } else {$consignee_name=''; }
            $con_sdelivery_address = $this->input->post('delivery_address');
            if(isset($con_sdelivery_address) && !empty($con_sdelivery_address)) {$con_sdelivery_address = $con_sdelivery_address; } else {$con_sdelivery_address=''; }
            $con_gst_number = $this->input->post('gst_types');
            if(isset($con_gst_number) && !empty($con_gst_number)) {$con_gst_number = $con_gst_number; } else {$con_gst_number=''; }
            if(empty($consignee_name) || empty($con_sdelivery_address) || empty($con_gst_number)){
              $error = 'Y';
              $error_message = 'Please enter consignee required details!';
            }
            if($consignee_name && $con_sdelivery_address && $con_gst_number){
              $save_consignee_data = array();
              for($i = 0;$i<count($consignee_name);$i++) {
                $save_consignee_data[] = array('project_id'=>$project_id,'consignee_name'=>$consignee_name[$i],
                'delivery_address'=>$con_sdelivery_address[$i],'gst_number'=>$con_gst_number[$i]);
              }
              if(isset($save_consignee_data) && !empty($save_consignee_data)){
                $this->admin_model->deleteOldConsignee($project_id);
                $this->common_model->SaveMultiData('tbl_deliv_challan_consignee',$save_consignee_data);
              }
            }

            $insurance_req =$this->input->post('insurance_req');
            if(isset($insurance_req) && !empty($insurance_req) && $insurance_req == 'Yes') {$insurance_req='Y'; } else {$insurance_req='N'; }
            $insurance_remark =$this->input->post('insurance_remark');
            if(isset($insurance_remark) && !empty($insurance_remark)) {$insurance_remark = $insurance_remark; } else {$insurance_remark=''; }
            $insurance_up_to_date =$this->input->post('insurance_up_to_date');
            if(isset($insurance_up_to_date) && !empty($insurance_up_to_date)) {$insurance_up_to_date = $insurance_up_to_date; } else {$insurance_up_to_date=''; }
            $amount_of_risk_cov =$this->input->post('amount_of_risk_cov');
            if(isset($amount_of_risk_cov) && !empty($amount_of_risk_cov)) {$amount_of_risk_cov = $amount_of_risk_cov; } else {$amount_of_risk_cov='0'; }
            if($insurance_req == 'Y'){
              if(empty($insurance_remark) || empty($insurance_up_to_date) || empty($amount_of_risk_cov)){
                $error = 'Y';
                $error_message = 'Please enter insurance required details!';
              }
            }
            if($insurance_req == 'Y'){
              $cpt = count($_FILES['insurance_required_doc']['name']);
              $save_insurance_data = array();
              if(isset($insurance_remark) && !empty($insurance_remark) &&
              isset($insurance_up_to_date) && !empty($insurance_up_to_date) &&
              isset($amount_of_risk_cov) && !empty($amount_of_risk_cov) &&
              isset($cpt) && !empty($cpt) && $cpt > 0){
                $files = $_FILES;
                for($i=0;$i < count($insurance_remark); $i++){
                  $_FILES['insurance_required_doc']['name']= $files['insurance_required_doc']['name'][$i];
                  $_FILES['insurance_required_doc']['type']= $files['insurance_required_doc']['type'][$i];
                  $_FILES['insurance_required_doc']['tmp_name']= $files['insurance_required_doc']['tmp_name'][$i];
                  $_FILES['insurance_required_doc']['error']= $files['insurance_required_doc']['error'][$i];
                  $_FILES['insurance_required_doc']['size']= $files['insurance_required_doc']['size'][$i];
                  $set_upload_options = array('upload_path' =>'./uploads/insurance_required/',
                  'encrypt_name' => TRUE,
                  'overwrite' => FALSE,
                  'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG','max_size' => 15360 );
                  //  $this->imageupload->image_upload($set_upload_options);
                  //  $this->upload->data();
                  $this->upload->initialize($set_upload_options);
                  $this->upload->do_upload('insurance_required_doc');
                  $uploadedFileName = $this->upload->data('file_name');
                  $insdate = date('Y-m-d',strtotime($insurance_up_to_date[$i]));
                  $save_insurance_data[] = array('project_id'=>$project_id,'remark'=>$insurance_remark[$i],
                  'insdate'=>$insdate,'amount'=>$amount_of_risk_cov[$i],'insurance_required_doc'=>$uploadedFileName);
                }
              }
              if(isset($save_insurance_data) && !empty($save_insurance_data)){
                $this->admin_model->deleteOldInsuranceData($project_id);
                $this->common_model->SaveMultiData('tbl_insurance_data',$save_insurance_data);
              }
            }
            $agreement_prepared =$this->input->post('agreement_prepared');
            if(isset($agreement_prepared) && !empty($agreement_prepared) && $agreement_prepared == 'Yes') {$agreement_prepared='Y'; } else {$agreement_prepared='N'; }
            $upload_draft_doc_file ='';
            if($agreement_prepared == 'Y'){
              $errormsg='';
              if(isset($_FILES['upload_draft_doc_file']['name']))//Code for to take image from form and check isset
              {
                $upload_draft_doc_file = $_FILES['upload_draft_doc_file']['name']; //here [] name attribute
                $upload_draft_doc_fileImg = array('upload_path' =>'./uploads/agreement_prepared/',
                'fieldname' => 'upload_draft_doc_file',
                'encrypt_name' => TRUE,
                'overwrite' => FALSE,
                'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
                'max_size' => 15360 );
                $upload_draft_doc_file_img = $this->imageupload->image_upload($upload_draft_doc_fileImg);
                $errormsg= $this->upload->display_errors();
                if(isset($upload_draft_doc_file_img) && !empty($upload_draft_doc_file_img))
                {
                  $upload_draft_doc_fileData = $this->upload->data();
                  $upload_draft_doc_file = $upload_draft_doc_fileData['file_name'];
                }else{
                  if(isset($project_data->draft_doc_file) && !empty($project_data->draft_doc_file)) {
                    $upload_draft_doc_file = $project_data->draft_doc_file;
                  }
                }
              }else{
                if(isset($project_data->draft_doc_file) && !empty($project_data->draft_doc_file)) {
                  $upload_draft_doc_file = $project_data->draft_doc_file;
                }
              }
            }
            if(isset($upload_draft_doc_file) && !empty($upload_draft_doc_file)) {$upload_draft_doc_file = $upload_draft_doc_file; } else {$upload_draft_doc_file=''; }
            if($agreement_prepared == 'Y'){
              if(empty($upload_draft_doc_file)){
                $error = 'Y';
                $error_message = 'Please upload Draft Agreement Document!';
              }
            }
            $upload_sign_doc_file ='';
            $errormsg='';
            if(isset($_FILES['upload_sign_doc_file']['name']))//Code for to take image from form and check isset
            {
              $upload_sign_doc_file = $_FILES['upload_sign_doc_file']['name']; //here [] name attribute
              $upload_sign_doc_fileImg = array('upload_path' =>'./uploads/agreement_prepared/',
              'fieldname' => 'upload_sign_doc_file',
              'encrypt_name' => TRUE,
              'overwrite' => FALSE,
              'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
              'max_size' => 15360 );
              $upload_sign_doc_file_img = $this->imageupload->image_upload($upload_sign_doc_fileImg);
              $errormsg= $this->upload->display_errors();
              if(isset($upload_sign_doc_file_img) && !empty($upload_sign_doc_file_img))
              {
                $upload_sign_doc_fileData = $this->upload->data();
                $upload_sign_doc_file = $upload_sign_doc_fileData['file_name'];
              }
            }else{
              $upload_sign_doc_file = $this->input->post('hidden_upload_sign_doc_file');
              if(isset($project_data->upload_sign_doc_file) && !empty($project_data->upload_sign_doc_file)) {
                $upload_sign_doc_file = $project_data->upload_sign_doc_file;
              }
            }
            if(isset($upload_sign_doc_file) && !empty($upload_sign_doc_file)) {$upload_sign_doc_file = $upload_sign_doc_file; } else {$upload_sign_doc_file=''; }

            // po_loi_doc

            $po_loi_doc ='';
            $errormsg='';
            if(isset($_FILES['po_loi_doc']['name']))//Code for to take image from form and check isset
            {
              $po_loi_doc = $_FILES['po_loi_doc']['name']; //here [] name attribute
              $po_loi_docImg = array('upload_path' =>'./uploads/document_upload/',
              'fieldname' => 'po_loi_doc',
              'encrypt_name' => TRUE,
              'overwrite' => FALSE,
              'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
              'max_size' => 15360 );
              $po_loi_doc_img = $this->imageupload->image_upload($po_loi_docImg);
              $errormsg= $this->upload->display_errors();
              if(isset($po_loi_doc_img) && !empty($po_loi_doc_img))
              {
                $po_loi_docData = $this->upload->data();
                $po_loi_doc = $po_loi_docData['file_name'];
              }
            }else{
              $po_loi_doc = $this->input->post('hidden_po_loi_doc');
              if(isset($po_loi_doc) && !empty($po_loi_doc)) {$po_loi_doc = $po_loi_doc; } else {$po_loi_doc=''; }
            }


            $penalty_clause =$this->input->post('penalty_clause');
            if(isset($penalty_clause) && !empty($penalty_clause)) {$penalty_clause=trim($penalty_clause); } else {$penalty_clause=''; }
            $penalty_clause_file ='';
            $errormsg='';
            if(isset($_FILES['penalty_clause_file']['name']))//Code for to take image from form and check isset
            {
              $penalty_clause_file = $_FILES['penalty_clause_file']['name']; //here [] name attribute
              $penalty_clause_fileImg = array('upload_path' =>'./uploads/document_upload/',
              'fieldname' => 'penalty_clause_file',
              'encrypt_name' => TRUE,
              'overwrite' => FALSE,
              'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
              'max_size' => 15360 );
              $penalty_clause_file_img = $this->imageupload->image_upload($penalty_clause_fileImg);
              $errormsg= $this->upload->display_errors();
              if(isset($penalty_clause_file_img) && !empty($penalty_clause_file_img))
              {
                $penalty_clause_fileData = $this->upload->data();
                $penalty_clause_file = $penalty_clause_fileData['file_name'];
              }
            }else{
              if(isset($project_data->penalty_clause_file) && !empty($project_data->penalty_clause_file)) {
                $penalty_clause_file = $project_data->penalty_clause_file;
              }
            }
            if(isset($penalty_clause_file) && !empty($penalty_clause_file)) {$penalty_clause_file = $penalty_clause_file; } else {$penalty_clause_file=''; }
            $power_of_attorney =$this->input->post('power_of_attorney');
            if(isset($power_of_attorney) && !empty($power_of_attorney)) {$power_of_attorney=trim($power_of_attorney); } else {$power_of_attorney=''; }
            $power_of_attorney_file ='';
            $errormsg='';
            if(isset($_FILES['power_of_attorney_file']['name']))//Code for to take image from form and check isset
            {
              $power_of_attorney_file = $_FILES['power_of_attorney_file']['name']; //here [] name attribute
              $power_of_attorney_fileImg = array('upload_path' =>'./uploads/document_upload/',
              'fieldname' => 'power_of_attorney_file',
              'encrypt_name' => TRUE,
              'overwrite' => FALSE,
              'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
              'max_size' => 15360 );
              $power_of_attorney_file_img = $this->imageupload->image_upload($power_of_attorney_fileImg);
              $errormsg= $this->upload->display_errors();
              if(isset($power_of_attorney_file_img) && !empty($power_of_attorney_file_img))
              {
                $power_of_attorney_fileData = $this->upload->data();
                $power_of_attorney_file = $power_of_attorney_fileData['file_name'];
              }
            }else{
              if(isset($project_data->power_of_attorney_file) && !empty($project_data->power_of_attorney_file)) {
                $power_of_attorney_file = $project_data->power_of_attorney_file;
              }
            }
            $payment_terms_document ='';
            $errormsg='';
            if(isset($_FILES['payment_terms_document']['name']))
            {
              $payment_terms_document = $_FILES['payment_terms_document']['name'];
              $payment_terms_documentImg = array('upload_path' =>'./uploads/document_upload/',
              'fieldname' => 'payment_terms_document',
              'encrypt_name' => TRUE,
              'overwrite' => FALSE,
              'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
              'max_size' => 15360
            );
            $payment_terms_document_img = $this->imageupload->image_upload($payment_terms_documentImg);
            $errormsg= $this->upload->display_errors();
            if(isset($payment_terms_document_img) && !empty($payment_terms_document_img))
            {
              $payment_terms_documentData = $this->upload->data();
              $payment_terms_document = $payment_terms_documentData['file_name'];
            }
          }else{
            $payment_terms_document = $this->input->post('hidden_payment_terms_document');
            if(isset($payment_terms_document) && !empty($payment_terms_document)) {$payment_terms_document = $payment_terms_document; } else {$payment_terms_document=''; }
          }

          if(isset($power_of_attorney_file) && !empty($power_of_attorney_file)) {$power_of_attorney_file = $power_of_attorney_file; } else {$power_of_attorney_file=''; }
          $sample =$this->input->post('sample');
          if(isset($sample) && !empty($sample) && $sample == 'Y') {$sample = 'Y'; } else {$sample='N'; }
          $sample_text =$this->input->post('sample_text');
          if(isset($sample_text) && !empty($sample_text)) {$sample_text=$sample_text; } else {$sample_text=''; }
          if($sample == 'Y'){
            if(empty($sample_text)){
              $error = 'Y';
              $error_message = 'Please enter sample value!';
            }
          }
          $prototype =$this->input->post('prototype');
          if(isset($prototype) && !empty($prototype) && $prototype == 'Y') {$prototype = 'Y'; } else {$prototype='N'; }
          $prototype_text =$this->input->post('prototype_text');
          if(isset($prototype_text) && !empty($prototype_text)) {$prototype_text=$prototype_text; } else {$prototype_text=''; }
          if($prototype == 'Y'){
            if(empty($prototype_text)){
              $error = 'Y';
              $error_message = 'Please enter prototype value!';
            }
          }
          $inspection =$this->input->post('inspection');
          if(isset($inspection) && !empty($inspection) && $inspection == 'Y') {$inspection = 'Y'; } else {$inspection='N'; }
          $inspection_text =$this->input->post('inspection_text');
          if(isset($inspection_text) && !empty($inspection_text)) {$inspection_text=$inspection_text; } else {$inspection_text=''; }
          if($inspection == 'Y'){
            if(empty($inspection_text)){
              $error = 'Y';
              $error_message = 'Please enter inspection value!';
            }
          }
          $fat =$this->input->post('fat');
          if(isset($fat) && !empty($fat) && $fat == 'Y') {$fat='Y'; } else {$fat='N'; }
          $fat_text = $this->input->post('fat_text');
          if(isset($fat_text) && !empty($fat_text)) {$fat_text=$fat_text; } else {$fat_text=''; }
          if($fat == 'Y'){
            if(empty($fat_text)){
              $error = 'Y';
              $error_message = 'Please enter FAT value!';
            }
          }
          $sat =$this->input->post('sat');
          if(isset($sat) && !empty($sat) && $sat == 'Y') {$sat = 'Y'; } else {$sat='N'; }
          $sat_text =$this->input->post('sat_text');
          if(isset($sat_text) && !empty($sat_text)) {$sat_text=$sat_text; } else {$sat_text=''; }
          if($sat == 'Y'){
            if(empty($sat_text)){
              $error = 'Y';
              $error_message = 'Please enter SAT value!';
            }
          }
          $test_report =$this->input->post('test_report');
          if(isset($test_report) && !empty($test_report) && $test_report == 'Y') {$test_report = 'Y'; } else {$test_report='N'; }
          $test_report_text =$this->input->post('test_report_text');
          if(isset($test_report_text) && !empty($test_report_text)) {$test_report_text=$test_report_text; } else {$test_report_text=''; }
          if($test_report == 'Y'){
            if(empty($test_report_text)){
              //$error = 'Y';
              //$error_message = 'Please enter SAT value!';
            }
          }
          $payment_terms =$this->input->post('payment_terms');
          if(isset($payment_terms) && !empty($payment_terms)) {$payment_terms=trim($payment_terms); } else {$payment_terms='0'; }
          $bill_split_supply =$this->input->post('bill_split_supply');
          if(isset($bill_split_supply) && !empty($bill_split_supply)) {$bill_split_supply=trim($bill_split_supply); } else {$bill_split_supply='0'; }
          $bill_installation =$this->input->post('bill_installation');
          if(isset($bill_installation) && !empty($bill_installation)) {$bill_installation=trim($bill_installation); } else {$bill_installation='0'; }
          $testing_commissioning =$this->input->post('testing_commissioning');
          if(isset($testing_commissioning) && !empty($testing_commissioning)) {$testing_commissioning=trim($testing_commissioning); } else {$testing_commissioning='0'; }
          $bill_handover =$this->input->post('bill_handover');
          if(isset($bill_handover) && !empty($bill_handover)) {$bill_handover=trim($bill_handover); } else {$bill_handover='0'; }
          if($payment_terms == 'S&I'){
            $totalper = $bill_split_supply + $bill_installation + $testing_commissioning + $bill_handover;
            if($totalper > 100 && $totalper > 0){
              $error = 'Y';
              $error_message = 'Billing split up must be less than equal to 100%!';
            }
          }
          $invoice_submitted =$this->input->post('invoice_submitted');
          if(isset($invoice_submitted) && !empty($invoice_submitted) && $invoice_submitted == 'Yes') {$invoice_submitted = 'Y'; } else {$invoice_submitted='N'; }
          $invoice_submitted_text =$this->input->post('invoice_submitted_text');
          if(isset($invoice_submitted_text) && !empty($invoice_submitted_text)) {$invoice_submitted_text=trim($invoice_submitted_text); } else {$invoice_submitted_text=''; }
          if($invoice_submitted == 'Y'){
            if(empty($invoice_submitted_text)){
              $error = 'Y';
              $error_message = 'Please enter invoice to be submitted on customer website value!';
            }
          }
          $invoice_submitted_address =$this->input->post('invoice_submitted_address');
          if(isset($invoice_submitted_address) && !empty($invoice_submitted_address) && $invoice_submitted_address == 'Yes') {$invoice_submitted_address = 'Y'; } else {$invoice_submitted_address='N'; }
          $invoice_submitted_address_text =$this->input->post('invoice_submitted_address_text');
          if(isset($invoice_submitted_address_text) && !empty($invoice_submitted_address_text)) {$invoice_submitted_address_text=trim($invoice_submitted_address_text); } else {$invoice_submitted_address_text=''; }
          if($invoice_submitted_address == 'Y'){
            if(empty($invoice_submitted_address_text)){
              $error = 'Y';
              $error_message = 'Please enter invoice to be sent on different address value!';
            }
          }
          $esic_required =$this->input->post('esic_required');
          if(isset($esic_required) && !empty($esic_required) && $esic_required == 'Yes') {$esic_required = 'Y'; } else {$esic_required='N'; }
          $esic_required_text =$this->input->post('esic_required_text');
          if(isset($esic_required_text) && !empty($esic_required_text)) {$esic_required_text=trim($esic_required_text); } else {$esic_required_text=''; }
          if($esic_required == 'Y'){
            if(empty($esic_required_text)){
              $error = 'Y';
              $error_message = 'Please enter ESIC required value!';
            }
          }
          $pf_required =$this->input->post('pf_required');
          if(isset($pf_required) && !empty($pf_required) && $pf_required == 'Yes') {$pf_required = 'Y'; } else {$pf_required='N'; }
          $pf_required_text =$this->input->post('pf_required_text');
          if(isset($pf_required_text) && !empty($pf_required_text)) {$pf_required_text=trim($pf_required_text); } else {$pf_required_text=''; }
          if($pf_required == 'Y'){
            if(empty($pf_required_text)){
              $error = 'Y';
              $error_message = 'Please enter PF required value!';
            }
          }
          $any_other_details =$this->input->post('any_other_details');
          if(isset($any_other_details) && !empty($any_other_details)) {$any_other_details=trim($any_other_details); } else {$any_other_details=''; }
          $upload_projectcmpl_doc_file ='';
          $errormsg='';
          if(isset($_FILES['upload_projectcmpl_doc_file']['name']))//Code for to take image from form and check isset
          {
            $upload_projectcmpl_doc_file = $_FILES['upload_projectcmpl_doc_file']['name']; //here [] name attribute
            $upload_projectcmpl_doc_fileImg = array('upload_path' =>'./uploads/document_upload/',
            'fieldname' => 'upload_projectcmpl_doc_file',
            'encrypt_name' => TRUE,
            'overwrite' => FALSE,
            'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
            'max_size' => 15360 );
            $upload_projectcmpl_doc_file_img = $this->imageupload->image_upload($upload_projectcmpl_doc_fileImg);
            $errormsg= $this->upload->display_errors();
            if(isset($upload_projectcmpl_doc_file_img) && !empty($upload_projectcmpl_doc_file_img))
            {
              $upload_projectcmpl_doc_fileData = $this->upload->data();
              $upload_projectcmpl_doc_file = $upload_projectcmpl_doc_fileData['file_name'];
            }
          }else{
            if(isset($project_data->projectcmpl_doc_file) && !empty($project_data->projectcmpl_doc_file)) {
              $upload_projectcmpl_doc_file = $project_data->projectcmpl_doc_file;
            }
          }
          if(isset($upload_projectcmpl_doc_file) && !empty($upload_projectcmpl_doc_file)) {$upload_projectcmpl_doc_file = $upload_projectcmpl_doc_file; } else {$upload_projectcmpl_doc_file=''; }
          $upload_projectdesig_doc_file ='';
          $errormsg='';
          if(isset($_FILES['upload_projectdesig_doc_file']['name']))//Code for to take image from form and check isset
          {
            $upload_projectdesig_doc_file = $_FILES['upload_projectdesig_doc_file']['name']; //here [] name attribute
            $upload_projectdesig_doc_fileImg = array('upload_path' =>'./uploads/document_upload/',
            'fieldname' => 'upload_projectdesig_doc_file',
            'encrypt_name' => TRUE,
            'overwrite' => FALSE,
            'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
            'max_size' => 15360 );
            $upload_projectdesig_doc_file_img = $this->imageupload->image_upload($upload_projectdesig_doc_fileImg);
            $errormsg= $this->upload->display_errors();
            if(isset($upload_projectdesig_doc_file_img) && !empty($upload_projectdesig_doc_file_img))
            {
              $upload_projectdesig_doc_fileData = $this->upload->data();
              $upload_projectdesig_doc_file = $upload_projectdesig_doc_fileData['file_name'];
            }
          }else{
            if(isset($project_data->projectdesig_doc_file) && !empty($project_data->projectdesig_doc_file)) {
              $upload_projectdesig_doc_file = $project_data->projectdesig_doc_file;
            }
          }
          if(isset($upload_projectdesig_doc_file) && !empty($upload_projectdesig_doc_file)) {$upload_projectdesig_doc_file = $upload_projectdesig_doc_file; } else {$upload_projectdesig_doc_file=''; }

          //upload_projectcashflw_doc_file
          $upload_projectcashflw_doc_file ='';
          $errormsg='';
          if(isset($_FILES['upload_projectcashflw_doc_file']['name']))//Code for to take image from form and check isset
          {
            $upload_projectcashflw_doc_file = $_FILES['upload_projectcashflw_doc_file']['name']; //here [] name attribute
            $upload_projectcashflw_doc_fileImg = array('upload_path' =>'./uploads/document_upload/',
            'fieldname' => 'upload_projectcashflw_doc_file',
            'encrypt_name' => TRUE,
            'overwrite' => FALSE,
            'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
            'max_size' => 15360 );
            $upload_projectcashflw_doc_file_img = $this->imageupload->image_upload($upload_projectcashflw_doc_fileImg);
            $errormsg= $this->upload->display_errors();
            if(isset($upload_projectcashflw_doc_file_img) && !empty($upload_projectcashflw_doc_file_img))
            {
              $upload_projectcashflw_doc_fileData = $this->upload->data();
              $upload_projectcashflw_doc_file = $upload_projectcashflw_doc_fileData['file_name'];
            }
          }else{
            if(isset($project_data->projectcashflw_doc_file) && !empty($project_data->projectcashflw_doc_file)) {
              $upload_projectcashflw_doc_file = $project_data->projectcashflw_doc_file;
            }
          }
          if(isset($upload_projectcashflw_doc_file) && !empty($upload_projectcashflw_doc_file)) {$upload_projectcashflw_doc_file = $upload_projectcashflw_doc_file; } else {$upload_projectcashflw_doc_file=''; }

          //upload_projectinvstsch_doc_file
          $upload_projectinvstsch_doc_file ='';
          $errormsg='';
          if(isset($_FILES['upload_projectinvstsch_doc_file']['name']))//Code for to take image from form and check isset
          {
            $upload_projectinvstsch_doc_file = $_FILES['upload_projectinvstsch_doc_file']['name']; //here [] name attribute
            $upload_projectinvstsch_doc_fileImg = array('upload_path' =>'./uploads/document_upload/',
            'fieldname' => 'upload_projectinvstsch_doc_file',
            'encrypt_name' => TRUE,
            'overwrite' => FALSE,
            'allowed_types' => 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG',
            'max_size' => 15360
          );
          $upload_projectinvstsch_doc_file_img = $this->imageupload->image_upload($upload_projectinvstsch_doc_fileImg);
          $errormsg= $this->upload->display_errors();
          if(isset($upload_projectinvstsch_doc_file_img) && !empty($upload_projectinvstsch_doc_file_img))
          {
            $upload_projectinvstsch_doc_fileData = $this->upload->data();
            $upload_projectinvstsch_doc_file = $upload_projectinvstsch_doc_fileData['file_name'];
          }
        }else{
          if(isset($project_data->projectinvstsch_doc_file) && !empty($project_data->projectinvstsch_doc_file)) {
            $upload_projectinvstsch_doc_file = $project_data->projectinvstsch_doc_file;
          }
        }
        if(isset($upload_projectinvstsch_doc_file) && !empty($upload_projectinvstsch_doc_file)) {$upload_projectinvstsch_doc_file = $upload_projectinvstsch_doc_file; } else {$upload_projectinvstsch_doc_file=''; }
        $data = array('customer_name'=>$customer_name,'bp_code'=>$bp_code,
        'po_loi_no'=>$po_loi_no, 'po_loi_received_data'=>$po_loi_received_data, 'po_loi_doc'=> $po_loi_doc,'registered_address'=>$registered_address,
        'client_po_addr'=>$client_po_addr, 'our_address_on_po'=>$our_address_on_po,'name_of_work'=>$name_of_work,
        'work_order_on'=>$work_order_on, 'site_address'=>$site_address, 'taxable_amount'=>$taxable_amount, 'gst_rate'=>$gst_rate,'gst_amount'=>$gst_amount,
        'total_amount'=>$total_amount, 'emd_paid'=>$emd_paid, 'emd_paid_num'=>$emd_paid_num,'emd_paid_status'=>$emd_paid_status,'emd_payment_mode' => $emd_payment_mode,
        'business_head' => $business_head,'manager_head' => $manager_head,
        'asd_paid'=>$asd_paid, 'asd_paid_num'=>$asd_paid_num, 'asd_paid_status'=>$asd_paid_status,'asd_payment_mode' => $asd_payment_mode, 'performance_paid'=>$performance_paid,
        'performance_guarantee_num'=>$performance_guarantee_num,'per_paid_status'=>$per_paid_status,'per_payment_mode' => $per_payment_mode,
        'sd_pbg_fd'=>$sd_pbg_fd,'pg_amount'=>$pg_amount,'pbg_validity'=>$pbg_validity, 'security_deposite_num'=>$security_deposite_num,
        'warranty_period'=>$warranty_period, 'billing_related'=>$billing_related, 'po_related'=>$po_related, 'execution_related'=>$execution_related,
        'engineer_in_charge'=>$engineer_in_charge,'completion_period'=>$completion_period, 'gst_no'=>$gst_no, 'price_inslusive_of_amc'=>$price_inslusive_of_amc,
        'amc_applicable_after'=>$amc_applicable_after, 'is_billing_inter_state'=>$is_billing_inter_state,
        'bill_same_as_reg_addr'=>$bill_same_as_reg_addr,'billing_address'=>$billing_address,
        'insurance_req'=>$insurance_req, 'agreement_prepared'=>$agreement_prepared, 'penalty_clause'=>$penalty_clause,
        'power_of_attorney'=>$power_of_attorney, 'sample'=>$sample,'prototype'=>$prototype,'inspection'=>$inspection,'fat'=>$fat,'sat'=>$sat,'test_report'=>$test_report,'payment_terms'=>$payment_terms,
        'bill_split_supply'=>$bill_split_supply,'bill_installation'=>$bill_installation, 'testing_commissioning'=>$testing_commissioning, 'bill_handover'=>$bill_handover,
        'invoice_submitted'=>$invoice_submitted, 'invoice_submitted_text'=>$invoice_submitted_text, 'invoice_submitted_address'=>$invoice_submitted_address,
        'invoice_submitted_address_text'=>$invoice_submitted_address_text, 'esic_required'=>$esic_required, 'esic_required_text'=>$esic_required_text,
        'pf_required'=>$pf_required, 'pf_required_text'=>$pf_required_text, 'any_other_details'=>$any_other_details,'payment_terms_document'=>$payment_terms_document,
        'display'=>'Y', 'updated_date'=>date('Y-m-d H:i:s'), 'updated_by'=>$user_id,'status'=>'P','upload_emd_paid_file'=>$upload_emd_paid_file,
        'upload_asd_paid_file'=>$upload_asd_paid_file,'final_performance_paid_file'=>$final_performance_paid_file,'draft_performance_paid_file'=>$draft_performance_paid_file,
        'emd_converted_deposit' => $emd_converted_deposit,
        'asd_converted_deposit' => $asd_converted_deposit,
        'projectcmpl_doc_file'=>$upload_projectcmpl_doc_file,'projectdesig_doc_file'=>$upload_projectdesig_doc_file,
        'projectcashflw_doc_file'=>$upload_projectcashflw_doc_file,'projectinvstsch_doc_file'=>$upload_projectinvstsch_doc_file,
        'sign_doc_file'=>$upload_sign_doc_file,'draft_doc_file'=>$upload_draft_doc_file,'penalty_clause_file'=>$penalty_clause_file,'power_of_attorney_file'=>$power_of_attorney_file);
        if($error == 'N'){
          if(isset($project_id) && !empty($project_id)){
            $this->common_model->updateDetails('tbl_projects','project_id',$project_id,$data);
            $action_url = base_url().'create-project-list';
            $activity = '#'.$bp_code.' OEF waiting for approval!';
            $approved_noti_arr = array('activity'=>$activity,'action_id'=>$project_id,'action_url'=>$action_url,'created_by'=>$user_id,
            'created_date'=>date('Y-m-d H:i:s'),'modified_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id);
            //$this->common_model->addData('tbl_approval_waiting',$approved_noti_arr);
            if($sample == 'Y'){
              $save_sample_data = array();
              if(isset($sample_text) && !empty($sample_text)){
                for($i=0;$i < count($sample_text); $i++){
                  if(!empty($sample_text[$i])){
                    $save_sample_data[] = array('project_id'=>$project_id,'sample'=>$sample_text[$i]);
                  }
                }
              }
              if(isset($save_sample_data) && !empty($save_sample_data)){
                $this->admin_model->deleteOldSampleData($project_id);
                $this->common_model->SaveMultiData('tbl_sample',$save_sample_data);
              }
            }
            if($prototype == 'Y'){
              $save_prototype_data = array();
              if(isset($prototype_text) && !empty($prototype_text)){
                for($i=0;$i < count($prototype_text); $i++){
                  if(!empty($prototype_text[$i])){
                    $save_prototype_data[] = array('project_id'=>$project_id,'prototype'=>$prototype_text[$i]);
                  }
                }
              }
              if(isset($save_prototype_data) && !empty($save_prototype_data)){
                $this->admin_model->deleteOldPrototypeData($project_id);
                $this->common_model->SaveMultiData('tbl_prototype',$save_prototype_data);
              }
            }
            if($inspection == 'Y'){
              $save_inspection_data = array();
              if(isset($inspection_text) && !empty($inspection_text)){
                for($i=0;$i < count($inspection_text); $i++){
                  if(!empty($inspection_text[$i])){
                    $save_inspection_data[] = array('project_id'=>$project_id,'inspection'=>$inspection_text[$i]);
                  }
                }
              }
              if(isset($save_inspection_data) && !empty($save_inspection_data)){
                $this->admin_model->deleteOldInspectionData($project_id);
                $this->common_model->SaveMultiData('tbl_inspection',$save_inspection_data);
              }
            }
            if($fat == 'Y'){
              $save_fat_data = array();
              if(isset($fat_text) && !empty($fat_text)){
                for($i=0;$i < count($fat_text); $i++){
                  if(!empty($fat_text[$i])){
                    $save_fat_data[] = array('project_id'=>$project_id,'fat'=>$fat_text[$i]);
                  }
                }
              }
              if(isset($save_fat_data) && !empty($save_fat_data)){
                $this->admin_model->deleteOldFatData($project_id);
                $this->common_model->SaveMultiData('tbl_fat',$save_fat_data);
              }
            }
            if($sat == 'Y'){
              $save_sat_data = array();
              if(isset($sat_text) && !empty($sat_text)){
                for($i=0;$i < count($sat_text); $i++){
                  if(!empty($sat_text[$i])){
                    $save_sat_data[] = array('project_id'=>$project_id,'sat'=>$sat_text[$i]);
                  }
                }
              }
              if(isset($save_sat_data) && !empty($save_sat_data)){
                $this->admin_model->deleteOldSatData($project_id);
                $this->common_model->SaveMultiData('tbl_sat',$save_sat_data);
              }
            }
            if($test_report == 'Y'){
              $test_report_data = array();
              if(isset($test_report_text) && !empty($test_report_text)){
                for($i=0;$i < count($test_report_text); $i++){
                  if(!empty($test_report_text[$i])){
                    $save_test_report_data[] = array('project_id'=>$project_id,'test_report'=>$test_report_text[$i]);
                  }
                }
              }
              if(isset($save_test_report_data) && !empty($save_test_report_data)){
                  $this->admin_model->deleteOldtestreport($project_id);
                $this->common_model->SaveMultiData('tbl_test_report',$save_test_report_data);
              }
            }
            $this->json->jsonReturn(array(
              'valid'=>TRUE,
              'msg'=>'<div class="alert modify alert-info"><strong>Welldone!</strong>Project Details Saved Successfully!</div>',
              'redirect' => base_url().'create-project-list'
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
    'msg'=>'<div class="alert modify alert-danger"><strong>Oops!</strong> Please LoggedIn!!.</div>'
  ));
}

}
}
