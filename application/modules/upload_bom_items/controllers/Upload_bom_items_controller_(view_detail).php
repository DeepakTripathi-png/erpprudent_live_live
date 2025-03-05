<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_bom_items_controller extends Base_Controller
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
		require_once(APPPATH.'libraries/tcpdf/tcpdf.php');
	}

	public function clear_cache()
	{
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
	}

	public function add_bom_items()
	{
		$this->load->view('add-bom-items');
	}

	public function bom_release_quantity()
	{
		$this->load->view('add-edit-bom-release-qty');
	}

	public function bom_indent_request() {

		$this->load->view('indent-request');
	}

	public function view_bom($project_id) {

		$id = $this->uri->segment(2);
		if(isset($id) && !empty($id)){
			$id = base64_decode($id);
		}

		$bp_code = $this->admin_model->get_bp_code($id);
		$data['bp_code'] = $bp_code;
		$data['project_id_encode'] = $project_id;
		$data['project_id'] = $id;
		$data['id'] = $id;
		$this->load->view('bom-view',$data);
	}

	public function bom_approval_waiting($project_id) {
		$id = $this->uri->segment(2);
		if(isset($id) && !empty($id)){
			$id = base64_decode($id);
		}

		$bp_code = $this->admin_model->get_bp_code($id);
		$data['bp_code'] = $bp_code;
		$data['project_id_encode'] = $project_id;
		$data['project_id'] = $id;
		$data['id'] = $id;
		$this->load->view('bom-waiting-approval',$data);
	}

	public function view_bom_release_quantity($project_id) {
		$id = $this->uri->segment(2);
		if(isset($id) && !empty($id)){
			$id = base64_decode($id);
		}

		$bp_code = $this->admin_model->get_bp_code($id);
		$data['bp_code'] = $bp_code;
		$data['project_id_encode'] = $project_id;
		$data['project_id'] = $id;
		$data['id'] = $id;
		$this->load->view('view-release-quantity',$data);
	}

	public function view_bom_indent_request($project_id) {
		$id = $this->uri->segment(2);
		if(isset($id) && !empty($id)){
			$id = base64_decode($id);
		}

		$bp_code = $this->admin_model->get_bp_code($id);
		$data['bp_code'] = $bp_code;
		$data['project_id_encode'] = $project_id;
		$data['project_id'] = $id;
		$data['id'] = $id;
		$this->load->view('view-indent-request',$data);
	}

	public function get_boq_item_details()
	{
		$project_id = $this->input->post('project_id');
		$boq_code = $this->input->post('boq_code');
		$user_id = $this->session->userData('user_id');
		$res = array();

		$member = $this->admin_model->get_boq_item_details($project_id,$boq_code);
		$boq_exceptional = $this->admin_model->get_boq_exceptional_item($project_id,$boq_code);

		if(isset($member) && !empty($member)){
			if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $res['boq_items_id'] = $member->boq_items_id; }else { $res['boq_items_id'] = '0'; }
			if(isset($member->project_id) && !empty($member->project_id)) { $project_id_db = $member->project_id; }else { $project_id_db = '0'; }
			if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code_db = $member->boq_code; }else { $boq_code_db = ''; }
			if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $res['hsn_sac_code'] = $member->hsn_sac_code; }else { $res['hsn_sac_code'] = ''; }
			if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = ''; }
			if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = ''; }
			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = ''; }
			if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
			if(isset($member->o_design_qty) && !empty($member->o_design_qty)) { $res['o_design_qty'] = $member->o_design_qty; }else { $res['o_design_qty'] = '0'; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = '0'; }
			if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = '0'; }
			if(isset($member->non_schedule) && !empty($member->non_schedule)) { $non_schedule = $member->non_schedule; }else { $non_schedule = 'N'; }
			if(isset($member->status) && !empty($member->status)) { $res['boq_status'] = $member->status; }else { $res['boq_status'] = 'N'; }
		}

		$ns_text = ($non_schedule == "Y") ? "YES" : "NO";
		$BOQStockArr = $this->admin_model->check_stock_details($project_id, $boq_code);
		if (isset($BOQStockArr) && !empty($BOQStockArr)) {
			$dc_stock = isset($BOQStockArr->dc_stock) && !empty($BOQStockArr->dc_stock) ? $BOQStockArr->dc_stock : 0;
		} else {
			$dc_stock = 0;
		}

		$build_qty = $dc_stock;

		$oprableAmount = abs($build_qty * $rate_basic);
		$gst_amount = 0;

		if ($oprableAmount > 0 && $gst > 0) {
			$gst_amount = $oprableAmount * ($gst / 100);
		}
		$oprableAmountGST=0;
		$oprableAmountGST = $gst_amount + $oprableAmount;

		if(isset($user_id) && !empty($user_id)){
			$data = $row = $newarr = $datad = array();
			$boq_code_d = '<input type="text" class="form-control" readonly  value="'.$boq_code.'"  id="boq_code" placeholder="BOQ Sr No" style="font-size: 12px;width:100%">';
			$item_description_d = '<input type="text" class="form-control " readonly value="'.$item_description.'" id="item_description" placeholder="Item Description" style="font-size: 12px;width:100%">';
			$unit_d = '<input type="text" class="form-control"  id="unit" value="'.$unit.'"  readonly placeholder="Unit" style="font-size: 12px;width:100%">';
			$scheduled_qty_d = '<input type="number" min="0" class="form-control " readonly value="'.$scheduled_qty.'"  id="scheduled_qty" placeholder="Sche. Qty" style="font-size: 12px;width:100%">';
			$design_qty_d = '<input type="number" min="1" class="form-control" readonly value="'.$design_qty.'"  id="design_qty" placeholder="Des. Qty" style="font-size: 12px;width:100%">';
			$build_qty_d = '<input type="number" min="1" class="form-control" readonly value="'.$design_qty.'"  id="build_qty" placeholder="Build Qty" style="font-size: 12px;width:100%">';
			$rate_basic_d = '<input type="number" min="1" class="form-control" readonly value="'.$rate_basic.'"  id="rate_basic" placeholder="Rate Basic" style="font-size: 12px;width:100%">';
			$gst_d = '<input type="number" min="0" class="form-control"  id="gst" readonly value="'.$gst.'"  placeholder="GST %" style="font-size: 12px;width:100%">';
			$gst_amount_d = '<input type="number" min="0" class="form-control"  id="amount" readonly value="'.sprintf('%0.2f', $oprableAmountGST).'" readonly placeholder="Amount" style="font-size: 12px;width:100%">';
			$non_schedule_d = '<input type="text" class="form-control"  id="non_schedule_yes_no" placeholder="Yes/No" value="'.$ns_text.'" style="font-size: 12px;width:100%;" readonly>';
			$action_d = '';
			$action_d .='<div>';
			$action_d .='<button type="button" style="padding: 4px 6px 4px 6px;font-size: 12px;" class="btn green add_bom_item" title="Add BOM" rel="0"><span style="font-size:12px;"><i class="fa fa-plus"></i></span> Add BOM </button>';
			$action_d .='</div>';

			$datad[] = array(
				$boq_code_d,
				$item_description_d,
				$unit_d,
				$scheduled_qty_d,
				$design_qty_d,
				$build_qty_d,
				$rate_basic_d,
				$gst_d,
				$gst_amount_d,
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

	public function save_bom_item_details() {


		$project_id = $this->input->post('project_id');
		if (isset($project_id) && !empty($project_id)) {

			$steps = $this->admin_model->getTotalBOMTransactionCnt($project_id);
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

			$boq_items = $this->input->post('boq_items');
			if(isset($boq_items) && !empty($boq_items)) { $boq_code = $boq_items; } else { $boq_code=''; }
			if(isset($boq_code) && empty($boq_code)){
				$error = 'Y';
				$error_message = 'Please select BOQ Sr No!';
			}

			$bom_code = $this->input->post('bom_sr_no');
			if(isset($bom_code) && !empty($bom_code)) { $bom_code = $bom_code; } else { $bom_code=''; }
			if(isset($bom_code) && empty($bom_code)){
				$error = 'Y';
				$error_message = 'Please enter BOM Sr No!';
			}

			$hsn_sac_code = $this->input->post('bom_hns_code');
			if(isset($hsn_sac_code) && !empty($hsn_sac_code)) {$hsn_sac_code = $hsn_sac_code; } else {$hsn_sac_code=''; }
			if(isset($hsn_sac_code) && empty($hsn_sac_code)){
				$error = 'Y';
				$error_message = 'Please enter HSN/SAC Code!';
			}

			$item_description = $this->input->post('bom_item_name');
			if(isset($item_description) && !empty($item_description)) {$item_description = $item_description; } else {$item_description=''; }
			if(isset($item_description) && empty($item_description)){
				$error = 'Y';
				$error_message = 'Please enter Item Description!';
			}

			$unit = $this->input->post('bom_unit');
			if(isset($unit) && !empty($unit)) {$unit = $unit; } else {$unit=''; }
			if(isset($unit) && empty($unit)){
				$error = 'Y';
				$error_message = 'Please enter Unit!';
			}

			$bom_quantity = $this->input->post('bom_quantity');
			if(isset($bom_quantity) && !empty($bom_quantity)) {$bom_quantity = $bom_quantity; } else {$bom_quantity = ''; }
			if(isset($bom_quantity) && empty($bom_quantity)) {
				$error = 'Y';
				$error_message = 'Please enter Quantity!';
			}

			$rate_basic = $this->input->post('bom_rate_basic');
			if(isset($rate_basic) && !empty($rate_basic)) {$rate_basic = $rate_basic; } else {$rate_basic=''; }
			if(isset($rate_basic) && empty($rate_basic)){
				$error = 'Y';
				$error_message = 'Please enter Rate Basic!';
			}

			$bom_make = $this->input->post('bom_make');
			$bom_model = $this->input->post('bom_model');

			$gst = $this->input->post('bom_gst');
			if(isset($gst) && !empty($gst)) {$gst = $gst; } else {$gst=''; }

			if(isset($boq_code) && empty($boq_code) && isset($hsn_sac_code) && empty($hsn_sac_code) && isset($item_description) && empty($item_description)
			&& isset($unit) && empty($unit)  && isset($bom_quantity) && empty($bom_quantity) && isset($rate_basic) && empty($rate_basic)) {

				$this->json->jsonReturn(
					array(
						'valid'=>FALSE,
						'msg'=>'<div class="alert modify alert-danger">Please Enter BOM Items Details!!</div>'
					)
				);

			}else{


				if($error == 'N'){
					if(isset($bom_code) && !empty($bom_code)){

						$boqData = $this->admin_model->get_boq_item_details($project_id,$boq_code);
						if(isset($boqData->o_design_qty) && !empty($boqData->o_design_qty) && $boqData->o_design_qty > 0){
							$boq_exist_design_qty = $boqData->o_design_qty;
						}

						for($i=0;$i<count($bom_code);$i++){
							if(isset($bom_code[$i]) && !empty($bom_code[$i])) {$bom_code_s = $bom_code[$i]; } else {$bom_code_s=''; }
							if(isset($hsn_sac_code[$i]) && !empty($hsn_sac_code[$i])) {$hsn_sac_code_s = $hsn_sac_code[$i]; } else {$hsn_sac_code_s=''; }
							if(isset($item_description[$i]) && !empty($item_description[$i])) {$item_description_s = $item_description[$i]; } else {$item_description_s=''; }
							if(isset($unit[$i]) && !empty($unit[$i])) {$unit_s = $unit[$i]; } else {$unit_s=''; }
							if(isset($rate_basic[$i]) && !empty($rate_basic[$i])) {$rate_basic_s = str_replace(',', '', $rate_basic[$i]); } else {$rate_basic_s=0; }
							if(isset($gst[$i]) && !empty($gst[$i])) {$gst_s = $gst[$i]; } else {$gst_s='0'; }
							// if(isset($non_schedule[$i]) && !empty($non_schedule[$i])) { $non_schedule_s = $non_schedule[$i]; } else { $non_schedule_s ='N'; }
							if(isset($bom_quantity[$i]) && !empty($bom_quantity[$i])) { $bom_quantity_s = $bom_quantity[$i]; } else { $bom_quantity_s ='N'; }

							if(isset($bom_make[$i]) && !empty($bom_make[$i])) { $bom_make_s = $bom_make[$i]; } else { $bom_make_s =''; }
							if(isset($bom_model[$i]) && !empty($bom_model[$i])) { $bom_model_s = $bom_model[$i]; } else { $bom_model_s =''; }



							if(isset($bom_code_s) && !empty($bom_code_s) && isset($hsn_sac_code_s) && !empty($hsn_sac_code_s) && isset($item_description_s)
							&& !empty($item_description_s) && isset($unit_s) && !empty($unit_s) && isset($rate_basic_s) && !empty($rate_basic_s)) {



								$existData = $this->admin_model->get_bom_item_details($project_id, $bom_code_s,$boq_code);
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
										$save_arr[] = array('project_id'=>$project_id,'bom_code'=>$bom_code_s,'boq_code'=>$boq_code,'hsn_sac_code'=>$hsn_sac_code_s,
										'item_description'=>$item_description_s,'unit'=>$unit_s,'scheduled_qty'=>0,'o_design_qty'=>0,
										'design_qty'=>$upload_design_qty,'upload_design_qty'=>$bom_quantity_s,'make'=>$existData->make,'model'=>$existData->model,'rate_basic'=>$rate_basic_s,'gst'=>$gst_s,'non_schedule'=>'','created_by'=>$user_id,
										'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'steps'=>$steps,'status'=>'pending');
									}
								} else {
									$single_ratio = $bom_quantity_s / abs($boq_exist_design_qty);
									$save_arr[] = array('project_id'=>$project_id,'boq_code'=>$boq_code,'bom_code'=>$bom_code_s,'hsn_sac_code'=>$hsn_sac_code_s,
									'item_description'=>$item_description_s,'unit'=>$unit_s,'scheduled_qty'=>$bom_quantity_s,'o_design_qty'=>0,
									'design_qty'=> $bom_quantity_s,'upload_design_qty'=>$bom_quantity_s,'rate_basic'=>$rate_basic_s,'make'=>$bom_make_s,'model'=> $bom_model_s,'gst'=>$gst_s,'non_schedule'=>'','created_by'=>$user_id,
									'created_on'=>date('Y-m-d H:i:s'),'modified_by'=>$user_id,'modified_on'=>date('Y-m-d H:i:s'),'steps'=>$steps,'status'=>'pending');
								}
							}
						}
					}

					if(isset($save_arr) && !empty($save_arr)){
						$event_name = 'BOM Item Added';
						$BOMTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,
						'event_type'=>'add_edit_bom','created_date'=>date('Y-m-d H:i:s'),'created_by'=>$user_id,
						'updated_by'=>$user_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending');
						$transaction_id = $this->common_model->addData('tbl_bom_transactions',$BOMTransArr);
						if($transaction_id > 0){
							foreach($save_arr as $key => $csm){
								$save_arr[$key]['transaction_id'] = $transaction_id;
							}
							$this->common_model->SaveMultiData('tbl_bom_items',$save_arr);
							$this->json->jsonReturn(array(
								'valid'=>TRUE,
								'msg'=>'<div class="alert modify alert-success">BOM Items Details Saved Successfully!</div>',
								'redirect' => base_url().'add-bom-items'
							));
						}else{
							$this->json->jsonReturn(array(
								'valid'=>FALSE,
								'msg'=>'<div class="alert modify alert-danger">Please Enter Valid BOM Items Details!!</div>'
							));
						}
					}else{
						$this->json->jsonReturn(array(
							'valid'=>FALSE,
							'msg'=>'<div class="alert modify alert-danger">Please Enter Valid BOM Items Details!!</div>'
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


	public function export_boq_items() {

		$this->load->view('export-boq-items');
	}


	public function project_boq_item_list_export()
	{
		$projectId = $_GET['project_id'];
		if(isset($projectId) && !empty($projectId)){
			$project_id =$projectId;
			//$checkBOQUploadTransaction = $this->admin_model->checkBOQUploadTransactionCount($project_id);
		}else{
			$project_id = null;
			// $checkBOQUploadTransaction = 0;
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
				if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $hsn_sac_code = $member->hsn_sac_code; }else { $hsn_sac_code = '-'; }
				if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
				if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = '0'; }
				if(isset($member->non_schedule) && !empty($member->non_schedule)) { $non_schedule = $member->non_schedule; }else { $non_schedule = '-'; }

				if($non_schedule == 'Y') {
					$qty  = $design_qty;
				} else {
					$qty = $scheduled_qty;
				}


				$data[] = array(
					$boq_code,
					'',
					$hsn_sac_code,
					$item_description,
					$unit,
					'',
					'',
					$qty,
					'',
					'',
				);

				for ($i=1; $i <6; $i++) {
					$bom_sr_auto =  $boq_code.'/'.$i;

					$data[] = array(
						$boq_code,
						$bom_sr_auto,
						'',
						'',
						'',
						'',
						'',
						'',
						'',
						'',
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


	public function upload_bom_items()
	{
		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
			$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','upload-bom-items');
			if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
				$submenu_id = $submenu_data->submenu_id;
				$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
				if(isset($check_permission) && !empty($check_permission)){
					$check_permission_update = 'N';
					$submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','publish_bom_items_bulk_upload');
					if(isset($submenu_datau->submenu_id) && !empty($submenu_datau->submenu_id)){
						$usubmenu_id = $submenu_datau->submenu_id;
						$check_permissionu=$this->admin_model->check_permission($usubmenu_id,$logrole_id);
						if(isset($check_permissionu) && !empty($check_permissionu)){
							$check_permission_update = 'Y';
						}
					}
					$data['check_permission_update'] = $check_permission_update;
					$this->load->view('upload-bom-items',$data);
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


	public function publish_bom_items_bulk_upload() {
		$project_id = $this->input->post('project_id');
		$user_id = $this->session->userData("user_id");
		if(isset($user_id) && !empty($user_id)){
			if(isset($project_id) && !empty($project_id)){
				$steps = $this->admin_model->getTotalBOMTransactionCnt($project_id);
				if(isset($steps) && $steps !='no'){
					$steps = $steps + 1;
				}else{
					$steps = 0;
				}

				if(isset($_FILES['bom_excel_file']['name']))//Code for to take image from form and check isset
				{
					$bom_excel_file=$_FILES['bom_excel_file']['name']; //here [] name attribute
					$arr_bom_excel_file = array('upload_path' =>'./uploads/bom_excel_file/',
					'fieldname' => 'bom_excel_file',
					'encrypt_name' => TRUE,
					'overwrite' => FALSE,
					'allowed_types' => '*' );
					$arr_bom_excel_file = $this->imageupload->image_upload($arr_bom_excel_file);
					$error= $this->upload->display_errors();
					if(isset($arr_boq_excel_file) && !empty($arr_bom_excel_file)) {
						$userData = $this->upload->data();
						$category_img = $userData['file_name'];
					}
					$path = $_FILES["bom_excel_file"]["tmp_name"];
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
							if(isset($value['B']) && !empty($value['B'])) { $bom_sr_no = $value['B']; }else { $bom_sr_no = '0'; }
							if(isset($value['C']) && !empty($value['C'])) { $hsn_sac_code = $value['C']; }else { $hsn_sac_code = '0'; }
							if(isset($value['D']) && !empty($value['D'])) { $bom_item_description = $value['D']; }else { $bom_item_description = ''; }
							if(isset($value['E']) && !empty($value['E'])) { $unit = $value['E']; }else { $unit = ''; }
							//	if(isset($value['F']) && !empty($value['F'])) { $scheduled_qty = $value['F']; }else { $scheduled_qty = '0'; }
							if(isset($value['F']) && !empty($value['F'])) { $make = $value['F']; }else { $make = ''; }
							if(isset($value['G']) && !empty($value['G'])) { $model = $value['G']; }else { $model = ''; }
							if(isset($value['H']) && !empty($value['H'])) { $qty = $value['H']; }else { $qty = '0'; }
							if(isset($value['I']) && !empty($value['I'])) { $rate_basic = $value['I']; }else { $rate_basic = '0'; }
							if(isset($value['J']) && !empty($value['J'])) { $gst = $value['J']; }else { $gst = '0'; }


							if(!empty($boq_code) && !empty($project_id) && !empty($bom_sr_no)){
								$inserdata[$i]['project_id'] = $project_id;
								$inserdata[$i]['boq_code'] = $boq_code;
								$inserdata[$i]['bom_code'] = $bom_sr_no;
								$inserdata[$i]['hsn_sac_code'] =  $hsn_sac_code;
								$inserdata[$i]['item_description'] =  $bom_item_description;
								$inserdata[$i]['unit'] =  $unit;
								$inserdata[$i]['scheduled_qty'] = $qty;
								$inserdata[$i]['design_qty'] = $qty;
								$inserdata[$i]['upload_design_qty'] = $qty;
								$inserdata[$i]['rate_basic'] =  $rate_basic;
								$inserdata[$i]['gst'] =  $gst;
								$inserdata[$i]['make'] =  $make;
								$inserdata[$i]['model'] =  $model;
								$inserdata[$i]['non_schedule'] =  $non_schedule;
								$inserdata[$i]['created_by'] =  $user_id;
								$inserdata[$i]['created_on'] =  date('Y-m-d H:i:s');
								$inserdata[$i]['modified_by'] =  $user_id;
								$inserdata[$i]['modified_on'] =  date('Y-m-d H:i:s');
								$inserdata[$i]['steps'] =  $steps;
								$inserdata[$i]['o_design_qty'] =  0;
								$inserdata[$i]['status'] =  'pending';
								$i++;
							}
						}
					} catch (Exception $e) {
						die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
						. '": ' .$e->getMessage());
					}

					if(isset($inserdata) && !empty($inserdata)) {
						$event_name = 'BOM Item Upload';
						$is_first_upload = 0;

						$BOMTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,
						'event_type'=>'bom_upload','created_date'=>date('Y-m-d H:i:s'),'created_by'=>$user_id,
						'updated_by'=>$user_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending',
						'is_first_upload'=>$is_first_upload);
						$transaction_id = $this->common_model->addData('tbl_bom_transactions',$BOMTransArr);
						if($transaction_id > 0){
							foreach($inserdata as $key => $csm){
								$inserdata[$key]['transaction_id'] = $transaction_id;
							}
							$result = $this->common_model->SaveMultiData('tbl_bom_items',$inserdata);
							if($result) {
								$this->json->jsonReturn(array(
									'valid'=>TRUE,
									'msg'=>'<div class="alert modify alert-success">BOM Items Uploaded Successfully!</div>',
									'redirect' => base_url().'upload-bom-items'
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


	public function project_bom_boq_item_list()
	{
		$projectId = $_GET['project_id'];
		if(isset($projectId) && !empty($projectId)){
			$project_id =$projectId;
			$checkBOMUploadTransaction = $this->admin_model->checkBOMUploadTransactionCount($project_id);
		}else{
			$project_id = null;
			$checkBOMUploadTransaction = 0;
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

			$check_permission_edit = 'N';
			if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
				$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_bom_items');
				if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
					$submenu_id = $submenu_data->submenu_id;
					$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
					if(isset($check_permission) && !empty($check_permission)){
						$check_permission_edit = 'Y';
					}
				}
			}

			$memData = $this->admin_model->getBOMBOQListRows($_POST,$project_id);
			$allCount = $this->admin_model->countBOMBOQListAll();
			$countFiltered = $this->admin_model->countBOMBOQListFiltered($_POST,$projectId);
			$i = $_POST['start'];
			$boq_items_arr = [];

			foreach($memData as $member){
				if(!in_array($member->boq_items_id,$boq_items_arr)){
					array_push($boq_items_arr,$member->boq_items_id);
					$i++;
					if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $boq_items_id = $member->boq_items_id; }else { $boq_items_id = '0'; }
					if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
					if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
					if(isset($member->item_description) && !empty($member->item_description)) { $item_description =$member->item_description;}else { $item_description = '-'; }
					if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $hsn_sac_code =$member->hsn_sac_code;}else { $hsn_sac_code = '-'; }

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

					$qr_array = array('project_id' =>$project_id,'boq_code'=>$boq_code,);

					$bom_items_data = $this->common_model->selectDetailsWhereArrBom('tbl_bom_items',$qr_array);

					$bom_data = array();
					if(isset($bom_items_data) && !empty($bom_items_data)){
						$unique_sub_arr = [];
						foreach ($bom_items_data as $key => $bom_items) {
							if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }
							if(isset($bom_items->hsn_sac_code) && !empty($bom_items->hsn_sac_code)) { $bom_hsn_sac_code = $bom_items->hsn_sac_code; }else { $bom_hsn_sac_code = ''; }
							if(isset($bom_items->item_description) && !empty($bom_items->item_description)) { $bom_item_description = $bom_items->item_description; }else { $bom_item_description = ''; }
							if(isset($bom_items->unit) && !empty($bom_items->unit)) { $bom_unit = $bom_items->unit; }else { $bom_unit = ''; }
							if(isset($bom_items->o_design_qty) && !empty($bom_items->o_design_qty)) { $bom_o_design_qty = $bom_items->o_design_qty; }else { $bom_o_design_qty = ''; }
							if(isset($bom_items->make) && !empty($bom_items->make)) { $make = $bom_items->make; }else { $make = ''; }
							if(isset($bom_items->model) && !empty($bom_items->model)) { $model = $bom_items->model; }else { $model = ''; }
							if(isset($bom_items->rate_basic) && !empty($bom_items->rate_basic)) { $bom_rate_basic = $bom_items->rate_basic; }else { $bom_rate_basic = ''; }
							if(isset($bom_items->gst) && !empty($bom_items->gst)) { $bom_gst = $bom_items->gst; }else { $bom_gst = ''; }
							if(isset($bom_items->bom_ratio) && !empty($bom_items->bom_ratio)) { $bom_ratio = $bom_items->bom_ratio; }else { $bom_ratio = ''; }
							if(isset($bom_items->bom_ratio) && !empty($bom_items->project_id)) { $bom_project_id = $bom_items->project_id; }else { $bom_project_id = ''; }


							$html_d ="";
							$html_d.='<a href="javascript:;" class="delete tooltips " rel="" title="" rev="delete_boq_details" data-original-title="Delete Role"><i class="fa fa-trash-o" style="color:#a94442; font-size: 15px;"></i></a>';
							$latest_bom = $this->admin_model->get_latest_approved_bom_item($bom_project_id, $boq_code, $bom_code);
							if(isset($latest_bom->upload_design_qty) && !empty($latest_bom->upload_design_qty)) { $bom_upload_design_qty = $latest_bom->upload_design_qty; }else { $bom_upload_design_qty = 0; }

							if($bom_gst > 0){
								$total_amount = ($bom_rate_basic * $bom_upload_design_qty);
								$gst_amount=0;
								if($total_amount > 0 && $bom_gst > 0){
									$gst_amount =  $total_amount * ($bom_gst/100);
								}
								$final_amount = $total_amount + $gst_amount;
							} else {
								$final_amount = 0;
							}

							if(!in_array($bom_code,$unique_sub_arr)){
								array_push($unique_sub_arr,$bom_code);
								$bom_data[] = array(
									$bom_code,
									$bom_hsn_sac_code,
									$bom_item_description,
									$make,
									$model,
									$bom_unit,
									$bom_upload_design_qty,
									$bom_rate_basic,
									$bom_gst,
									sprintf('%0.2f', $final_amount),
								);
							}
						}
					}


					$action_status='';
					if($status == 'approved'){
						$action_status .='<span style="color:green;font-weight:600;">Approved</span>';
					} else if($status == 'pending'){
						$action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
					} else if($status == 'reject'){
						$action_status .='<span style="color:red;font-weight:600;">Rejected</span>';
					}

					$non_schedule_txt='NS';
					if($non_schedule == 'N'){
						$non_schedule_txt ='Sch';
					}
					$html = '';
					$html.='&nbsp;<a href="javascript:;" class="tooltips openBomview" rev="view_bom_items" rel="" project_id="'.$project_id.'" boq_code="'.$boq_code.'" title="" data-original-title="Delete Role">Close </a>';
					if($status =='reject'){
						if($check_permission_edit == 'Y'){
							$html .='&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="editBomRecord tooltips" title="Edit Record" rev="edit_bom_items" data-project_id="'.$project_id.'" data-boq_code="'.$boq_code.'" data-original-title="Edit Bom Record"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';
						}
					}

					$data[] = array(
						$i,
						$boq_code,
						$bp_code,
						$hsn_sac_code,
						$item_description,
						$unit,
						$design_qty,
						$action_status,
						$html,
						'subTableData' => $bom_data,
					);
				}
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $allCount,
				"recordsFiltered" => $countFiltered,
				"data" => $data,
				'BOMUploadTransaction'=>$checkBOMUploadTransaction,
			);
			echo json_encode($output);
		}
	}

	// 	public function get_bom_transaction_list() {

	// 		$user_id = $this->session->userData('user_id');
	// 		if(isset($user_id) && !empty($user_id)){
	// 			$project_idpost = $this->input->post('project_id');
	// 			if(isset($project_idpost) && !empty($project_idpost)){
	// 				$project_idpost = base64_decode($project_idpost);
	// 			}else{
	// 				$project_idpost = 0;
	// 			}
	// 			$status_txtpost = $this->input->post('status_txt');
	// 			if(isset($status_txtpost) && !empty($status_txtpost)){
	// 				$status_txt = $status_txtpost;
	// 			}else{
	// 				$status_txt = '';
	// 			}
	// 			$check_permission_approved = 'N';
	// 			$loguser_id = $this->session->userData('user_id');
	// 			$logrole_id = $this->session->userData('role_id');
	// 			if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
	// 				$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_bom_details');
	// 				if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
	// 					$submenu_id = $submenu_data->submenu_id;
	// 					$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
	// 					if(isset($check_permission) && !empty($check_permission)){
	// 						$check_permission_approved = 'Y';
	// 					}
	// 				}
	// 			}
	// 			$check_permission_approved_indent ='N';
	// 			$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_indent_stock');
	// 			if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
	// 				$submenu_id = $submenu_data->submenu_id;
	// 				$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
	// 				if(isset($check_permission) && !empty($check_permission)){
	// 					$check_permission_approved_indent = 'Y';
	// 				}
	// 			}
	// 			$check_permission_approved_po = 'N';
	// 			$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_pruchase_order');
	// 			if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){

	// 				$submenu_id = $submenu_data->submenu_id;
	// 				$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);

	// 				if(isset($check_permission) && !empty($check_permission)){

	// 					$check_permission_approved_po = 'Y';
	// 				}
	// 			}
	// 			$check_permission_approved_pi = 'N';
	// 			$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_vendor_proforma_invoice');
	// 			if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){

	// 				$submenu_id = $submenu_data->submenu_id;
	// 				$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);

	// 				if(isset($check_permission) && !empty($check_permission)){

	// 					$check_permission_approved_pi = 'Y';
	// 				}
	// 			}

	// 			$data = $row = array();

	// 			$transaction_data = array_merge(
	// 				$this->admin_model->getBOMTransactionItemListRows($_POST, $project_idpost, $status_txt),
	// 				$this->admin_model->getBOMTransactionOtherItemListRows($_POST, $project_idpost, $status_txt),
	// 				$this->admin_model->getBOMTransactionOtherSingleItemListRows($_POST, $project_idpost, $status_txt),
	// 				$this->admin_model->getPurchaseListRows($_POST, $project_idpost, $status_txt),
	// 				$this->admin_model->getBOMTransactionVendorPIListRows($_POST, $project_idpost, $status_txt)

	// 			);


	// 			$allCount = $this->admin_model->countBOMTransactionItemListAll($project_idpost, $status_txt)
	// 			+ $this->admin_model->countBOMTransactionOtherItemListAll($project_idpost, $status_txt)
	// 			+ $this->admin_model->getBOMTransactionOtherSingleItemListAll($project_idpost, $status_txt);

	// 			$countFiltered = $this->admin_model->countBOMTransactionItemListFiltered($_POST, $project_idpost, $status_txt)
	// 			+ $this->admin_model->countBOMTransactionOtherItemListFiltered($_POST, $project_idpost, $status_txt)
	// 			+ $this->admin_model->getBOMTransactionOtherSingleItemListFiltered($_POST, $project_idpost, $status_txt);

	// 			$FinalContractTotalNew = 0;
	// 			$i = 0;
	// 			if(isset($postData['length']))
	// 			$i = $_POST['start'];
	// 			$boq_code_arr = [];

	// 				$unique_arr =[];
	// 			$unique_bom_items =[];

	// 			if (isset($transaction_data) && !empty($transaction_data)) {
	// 			  foreach ($transaction_data as $bom_item) {
	// 						if ($bom_item->event_type == "bom_upload") {
	// 						 $unique_bom_items[] = $bom_item;
	// 					 }else if (!in_array($bom_item->id, $unique_arr)) {
	// 				      array_push($unique_arr, $bom_item->id);
	// 				      $unique_bom_items[] = $bom_item;
	// 				    }
	// 				  }
	// 			}

	// 			foreach($unique_bom_items as $member){
	// 				if(!in_array($member->boq_code,$boq_code_arr) || $member->boq_code == null){
	// 					array_push($boq_code_arr,$member->boq_code);
	// 					$i++;
	// 					if(isset($member->id) && !empty($member->id)) { $id = $member->id; }else { $id = '0'; }
	// 					if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '0'; }
	// 					if(isset($member->boq_code) && !empty($member->boq_code)) {   $boq_code = $member->boq_code; }else { $boq_code = '-'; }
	// 					if(isset($member->item_description) && !empty($member->item_description)) {   $item_description = $member->item_description; }else { $item_description = '-'; }
	// 					if(isset($member->bom_items_id) && !empty($member->bom_items_id)) {   $bom_items_id = $member->bom_items_id; }else { $bom_items_id = ''; }

	// 					if(isset($member->event_name) && !empty($member->event_name)) { $event_name = $member->event_name; }else { $event_name = '-'; }
	// 					if(isset($member->event_type) && !empty($member->event_type)) { $event_type = $member->event_type; }else { $event_type = '-'; }
	// 					if(isset($member->display) && !empty($member->display)) { $display = $member->display; }else { $display = '-'; }
	// 					if(isset($member->created_date) && !empty($member->created_date)) { $created_at = $member->created_date; }else { $created_at = '-'; }
	// 					if(isset($member->created_by) && !empty($member->created_by)) { $created_by = $member->created_by; }else { $created_by = '-'; }
	// 					if(isset($member->updated_date) && !empty($member->updated_date)) { $updated_at = $member->updated_date; }else { $updated_at = '-'; }
	// 					if(isset($member->updated_by) && !empty($member->updated_by)) { $updated_by = $member->updated_by; }else { $updated_by = '-'; }
	// 					if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = '-'; }
	// 					if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '-'; }
	// 					if(isset($member->created_by_rolename) && !empty($member->created_by_rolename)) { $created_by_rolename = '<br>('.$member->created_by_rolename.')'; }else { $created_by_rolename = ''; }
	// 					if(isset($member->approved_by_rolename) && !empty($member->approved_by_rolename)) { $approved_by_rolename = '<br>('.$member->approved_by_rolename.')'; }else { $approved_by_rolename = ''; }
	// 					if(isset($member->created_by_name) && !empty($member->created_by_name)) { $created_by_name = $member->created_by_name.''.$created_by_rolename; }else { $created_by_name = '-'; }
	// 					if(isset($member->approved_by_name) && !empty($member->approved_by_name)) { $approved_by_name = $member->approved_by_name.''.$approved_by_rolename; }else { $approved_by_name = '-'; }
	// 					if(isset($member->exceptional_no) && !empty($member->exceptional_no)) { $exceptional_no = $member->exceptional_no; }else { $exceptional_no = '-'; }
	// 					if(isset($member->exceptional_id) && !empty($member->exceptional_id)) { $exceptional_id = $member->exceptional_id; }else { $exceptional_id = 0; }
	// 					if(isset($member->is_first_upload) && !empty($member->is_first_upload)) { $is_first_upload = $member->is_first_upload; }else { $is_first_upload = 0; }
	// 					if(isset($member->variable_discount_id) && !empty($member->variable_discount_id)) { $variable_discount_id = $member->variable_discount_id; }else { $variable_discount_id = 0; }



	// 					$FinalContractTotal = 0;
	// 					$filter = 'original';
	// 					if($event_type == 'bom_upload' || $event_type == 'add_edit_bom' || $event_type == 'indent_request' || $event_type == 'purchase_order'|| $event_type == 'vendor_proforma_invoice'){
	// 						$FinalContractamount = $this->getBOMFinalContractamount($filter,$id,$event_type,$project_id,$status_txt,$boq_code);
	// 					}
	// 					if($event_type == 'bom_upload' || $event_type == 'add_edit_bom' || $event_type == 'indent_request' || $event_type == 'purchase_order'|| $event_type == 'vendor_proforma_invoice'){
	// 						if(isset($FinalContractamount['totalBOMAmountGST']) && !empty($FinalContractamount['totalBOMAmountGST'])){
	// 							$FinalContractTotal = abs($FinalContractamount['totalBOMAmountGST']);
	// 						}
	// 					}

	// 					if($event_type == 'bom_upload'){
	// 						$event_type_name = 'BOM Upload';
	// 					}elseif($event_type == 'add_edit_bom'){
	// 						$event_type_name = 'Add BOM';
	// 					} else if ($event_type == 'release_qty'){
	// 						$event_type_name = 'Release Quantity';
	// 					} else if ($event_type == 'indent_request'){
	// 						$event_type_name = 'Indent Request';
	// 					}else if ($event_type == 'purchase_order'){
	// 						$event_type_name = 'Purchase Order';
	// 					}else if ($event_type == 'vendor_proforma_invoice'){
	// 						$event_type_name = 'Vendor Proforma Invoice';
	// 					}
	// 					else{
	// 						$event_type_name = $exceptional_no;
	// 					}

	// 					$action_status='';
	// 					if($status == 'approved'){
	// 						$action_status .='<span style="color:green;font-weight:600;">Approved</span>';
	// 					}elseif($status == 'reject'){
	// 						$action_status .='<span style="color:red;font-weight:600;">Rejected</span>';
	// 					}else{
	// 						$action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
	// 					}
	// 					$action = '';
	// 					$action .='<a class="openview" href="javascript:void(0);" data-project_id="'.base64_encode($project_id).'" data-boq_code="'.$boq_code.'" data-type="'.$event_type.'"  data-id="'.$id.'">VIEW</a>';
	// 					if($event_type == 'bom_upload' || $event_type == 'add_edit_bom'){
	// 						if($check_permission_approved == 'Y'){
	// 							$action .='&nbsp;&nbsp;&nbsp;<select class="statusselectbom" id="statusselect'.$boq_code.'" rel="'.$id.'" rev="approved_bom_details" data-project_id="'.base64_encode($project_id).'" data-boq_code="'.$boq_code.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
	// 						}
	// 					}

	// 					if($event_type == 'release_qty') {
	// 						if($check_permission_approved == 'Y'){
	// 							$action .='&nbsp;&nbsp;&nbsp;<select class="statusselectbom" id="statusselect'.$boq_code.'" rel="'.$id.'" rev="approve_release_qty" data-project_id="'.base64_encode($project_id).'" data-boq_code="'.$boq_code.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
	// 						}
	// 					}

	// 					if($event_type == 'indent_request') {
	// 						if($check_permission_approved_indent == 'Y'){
	// 							$action .='&nbsp;&nbsp;&nbsp;<select class="statusselectbom" id="statusselect'.$boq_code.'" rel="'.$id.'" rev="approve_indent_request" data-project_id="'.base64_encode($project_id).'" data-boq_code="'.$boq_code.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
	// 						}
	// 					}
	// 					if($event_type == 'purchase_order') {
	// 						if($check_permission_approved_po == 'Y'){
	// 							$action .='&nbsp;&nbsp;&nbsp;<select class="statusselectbom" id="statusselect'.$boq_code.'" rel="'.$id.'" rev="approved_pruchase_order" data-project_id="'.base64_encode($project_id).'" data-boq_code="'.$boq_code.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
	// 						}
	// 					}
	// 					if($event_type == 'vendor_proforma_invoice') {
	// 						if($check_permission_approved_pi == 'Y'){
	// 							$action .='&nbsp;&nbsp;&nbsp;<select class="statusselectbom" id="statusselect'.$boq_code.'" rel="'.$id.'" rev="approved_vendor_proforma_invoice" data-project_id="'.base64_encode($project_id).'" data-boq_code="'.$boq_code.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
	// 						}
	// 					}

	// 					if($event_type == 'release_qty') {
	// 						$member = $this->admin_model->check_stock_details($project_id,$boq_code);
	// 						if(isset($member) && !empty($member)) {
	// 							if(isset($member->released_pending) && !empty($member->released_pending)) { $released_pending = $member->released_pending; }else { $released_pending = '0'; }
	// 						} else {
	// 							$released_pending = 0;
	// 						}
	// 					} else {
	// 						$released_pending = '-';
	// 					}


	// 					if(isset($project_idpost) && !empty($project_idpost)){
	// 				// 		$data[] = array(
	// 				// 			$i,
	// 				// 			// $boq_code,
	// 				// 			$bp_code,
	// 				// 			// $item_description,
	// 				// 			$event_name,
	// 				// 			$event_type_name,
	// 				// 			sprintf('%0.2f', $FinalContractTotal),
	// 				// 			// $released_pending,
	// 				// 			$created_by_name,
	// 				// 			$approved_by_name,
	// 				// 			$created_at,
	// 				// 			$action);
	// 				if (($event_type == "bom_upload" && $FinalContractTotal > 0) || $event_type == 'add_edit_bom' || $event_type == 'release_qty' || $event_type == 'indent_request' || $event_type == 'purchase_order' || $event_type == 'vendor_proforma_invoice') {
	// 								$data[] = array(
	// 									$i,
	// 									// $boq_code,
	// 									$bp_code,
	// 									// $item_description,
	// 									$event_name,
	// 									$event_type_name,
	// 									sprintf('%0.2f', $FinalContractTotal),
	// 									// $released_pending,
	// 									$created_by_name,
	// 									$approved_by_name,
	// 									$created_at,
	// 									$action);
	// 								}
	// 						}
	// 					}

	// 				}

	// 				$output = array(
	// 					"draw" => isset( $_POST['draw']) ? $_POST['draw'] : 0,
	// 					"recordsTotal" => $allCount,
	// 					"recordsFiltered" => $countFiltered,
	// 					"data" => $data,
	// 				);
	// 				echo json_encode($output);
	// 			}
	// 		}

	public function get_bom_transaction_list() {

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
				$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_bom_details');
				if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
					$submenu_id = $submenu_data->submenu_id;
					$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
					if(isset($check_permission) && !empty($check_permission)){
						$check_permission_approved = 'Y';
					}
				}
			}
			$check_permission_approved_indent ='N';
			$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_indent_stock');
			if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
				$submenu_id = $submenu_data->submenu_id;
				$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
				if(isset($check_permission) && !empty($check_permission)){
					$check_permission_approved_indent = 'Y';
				}
			}
			$check_permission_approved_po = 'N';
			$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_pruchase_order');
			if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){

				$submenu_id = $submenu_data->submenu_id;
				$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);

				if(isset($check_permission) && !empty($check_permission)){

					$check_permission_approved_po = 'Y';
				}
			}
			$check_permission_approved_pi = 'N';
			$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_vendor_proforma_invoice');
			if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){

				$submenu_id = $submenu_data->submenu_id;
				$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);

				if(isset($check_permission) && !empty($check_permission)){

					$check_permission_approved_pi = 'Y';
				}
			}
			$check_permission_approved_pr = 'N';
			$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_ppi_payment_receipt');
			if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){

				$submenu_id = $submenu_data->submenu_id;
				$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);

				if(isset($check_permission) && !empty($check_permission)){

					$check_permission_approved_pr = 'Y';
				}
			}

			$data = $row = array();

			$transaction_data = array_merge(
				$this->admin_model->getBOMTransactionItemListRows($_POST, $project_idpost, $status_txt),
				$this->admin_model->getBOMTransactionOtherItemListRows($_POST, $project_idpost, $status_txt),
				$this->admin_model->getBOMTransactionOtherSingleItemListRows($_POST, $project_idpost, $status_txt),
				$this->admin_model->getPurchaseListRows($_POST, $project_idpost, $status_txt),
				$this->admin_model->getBOMTransactionVendorPIListRows($_POST, $project_idpost, $status_txt)
				// $this->admin_model->getBOMTransactionVendorPIListRows($_POST, $project_idpost, $status_txt)

			);

			// pr($transaction_data,1);
			$allCount = $this->admin_model->countBOMTransactionItemListAll($project_idpost, $status_txt)
			+ $this->admin_model->countBOMTransactionOtherItemListAll($project_idpost, $status_txt)
			+ $this->admin_model->getBOMTransactionOtherSingleItemListAll($project_idpost, $status_txt);

			$countFiltered = $this->admin_model->countBOMTransactionItemListFiltered($_POST, $project_idpost, $status_txt)
			+ $this->admin_model->countBOMTransactionOtherItemListFiltered($_POST, $project_idpost, $status_txt)
			+ $this->admin_model->getBOMTransactionOtherSingleItemListFiltered($_POST, $project_idpost, $status_txt);

			$FinalContractTotalNew = 0;
			$i = 0;
			if(isset($postData['length']))
			$i = $_POST['start'];
			$boq_code_arr = [];

			$unique_arr =[];
			$unique_bom_items =[];


			if (isset($transaction_data) && !empty($transaction_data)) {

				foreach ($transaction_data as $bom_item) {
					if ($bom_item->event_type == "bom_upload") {
						$unique_bom_items[] = $bom_item;
					}else if (!in_array($bom_item->id, $unique_arr)) {
						array_push($unique_arr, $bom_item->id);
						$unique_bom_items[] = $bom_item;
					}
				}
			}
			// pr($unique_bom_items,1);
			foreach($unique_bom_items as $member){
				if(!in_array($member->boq_code,$boq_code_arr) || $member->boq_code == null){
					array_push($boq_code_arr,$member->boq_code);
					$i++;
					if(isset($member->id) && !empty($member->id)) { $id = $member->id; }else { $id = '0'; }
					if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '0'; }
					if(isset($member->boq_code) && !empty($member->boq_code)) {   $boq_code = $member->boq_code; }else { $boq_code = '-'; }
					if(isset($member->item_description) && !empty($member->item_description)) {   $item_description = $member->item_description; }else { $item_description = '-'; }
					if(isset($member->bom_items_id) && !empty($member->bom_items_id)) {   $bom_items_id = $member->bom_items_id; }else { $bom_items_id = ''; }

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
					if($event_type == 'bom_upload' || $event_type == 'add_edit_bom' || $event_type == 'indent_request' || $event_type == 'purchase_order'|| $event_type == 'vendor_proforma_invoice'){
						$FinalContractamount = $this->getBOMFinalContractamount($filter,$id,$event_type,$project_id,$status_txt,$boq_code);
					}
					if($event_type == 'bom_upload' || $event_type == 'add_edit_bom' || $event_type == 'indent_request' || $event_type == 'purchase_order'|| $event_type == 'vendor_proforma_invoice'){
						if(isset($FinalContractamount['totalBOMAmountGST']) && !empty($FinalContractamount['totalBOMAmountGST'])){
							$FinalContractTotal = abs($FinalContractamount['totalBOMAmountGST']);
						}
					}
					if ($event_type == 'payment_receipt') {
						$pr_data = $this->admin_model->get_ppi_pr_data_by_trancation_by($id);

						$FinalContractTotal = $pr_data[0]['payment_amount'];
					}

					if($event_type == 'bom_upload'){
						$event_type_name = 'BOM Upload';
					}elseif($event_type == 'add_edit_bom'){
						$event_type_name = 'Add BOM';
					} else if ($event_type == 'release_qty'){
						$event_type_name = 'Release Quantity';
					} else if ($event_type == 'indent_request'){
						$event_type_name = 'Indent Request';
					}else if ($event_type == 'purchase_order'){
						$event_type_name = 'Purchase Order';
					}else if ($event_type == 'vendor_proforma_invoice'){
						$event_type_name = 'Vendor Proforma Invoice';
					}else if ($event_type == 'payment_receipt'){
						$event_type_name = 'Payment Receipt';
					}
					else{
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
					if($event_type != 'payment_receipt') {
						$action .='<a class="openview" href="javascript:void(0);" data-project_id="'.base64_encode($project_id).'" data-boq_code="'.$boq_code.'" data-type="'.$event_type.'"  data-id="'.$id.'">VIEW</a>';
					}else{
						$action .='<a class="opentransactionview" href="javascript:void(0);"  data-id="'.$id.'">VIEW</a>';
					}

					if($event_type == 'bom_upload' || $event_type == 'add_edit_bom'){
						if($check_permission_approved == 'Y'){
							$action .='&nbsp;&nbsp;&nbsp;<select class="statusselectbom" id="statusselect'.$boq_code.'" rel="'.$id.'" rev="approved_bom_details" data-project_id="'.base64_encode($project_id).'" data-boq_code="'.$boq_code.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
						}
					}

					if($event_type == 'release_qty') {
						if($check_permission_approved == 'Y'){
							$action .='&nbsp;&nbsp;&nbsp;<select class="statusselectbom" id="statusselect'.$boq_code.'" rel="'.$id.'" rev="approve_release_qty" data-project_id="'.base64_encode($project_id).'" data-boq_code="'.$boq_code.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
						}
					}

					if($event_type == 'indent_request') {
						if($check_permission_approved_indent == 'Y'){
							$action .='&nbsp;&nbsp;&nbsp;<select class="statusselectbom" id="statusselect'.$boq_code.'" rel="'.$id.'" rev="approve_indent_request" data-project_id="'.base64_encode($project_id).'" data-boq_code="'.$boq_code.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
						}
					}
					if($event_type == 'purchase_order') {
						if($check_permission_approved_po == 'Y'){
							$action .='&nbsp;&nbsp;&nbsp;<select class="statusselectbom" id="statusselect'.$boq_code.'" rel="'.$id.'" rev="approved_pruchase_order" data-project_id="'.base64_encode($project_id).'" data-boq_code="'.$boq_code.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
						}
					}
					if($event_type == 'vendor_proforma_invoice') {
						if($check_permission_approved_pi == 'Y'){
							$action .='&nbsp;&nbsp;&nbsp;<select class="statusselectbom" id="statusselect'.$boq_code.'" rel="'.$id.'" rev="approved_vendor_proforma_invoice" data-project_id="'.base64_encode($project_id).'" data-boq_code="'.$boq_code.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
						}
					}
					if($event_type == 'payment_receipt') {
						if($check_permission_approved_pr == 'Y'){
							$action .='&nbsp;&nbsp;&nbsp;<select class="statusselectbom" id="statusselect'.$boq_code.'" rel="'.$id.'" rev="approved_ppi_payment_receipt" data-project_id="'.base64_encode($project_id).'" data-boq_code="'.$boq_code.'"><option class="statusselectoption" value="pending">Pending</option><option class="statusselectoption" value="approved">Approve</option><option class="statusselectoption" value="reject">Reject</option></select>';
						}
					}

					if($event_type == 'release_qty') {
						$member = $this->admin_model->check_stock_details($project_id,$boq_code);
						if(isset($member) && !empty($member)) {
							if(isset($member->released_pending) && !empty($member->released_pending)) { $released_pending = $member->released_pending; }else { $released_pending = '0'; }
						} else {
							$released_pending = 0;
						}
					} else {
						$released_pending = '-';
					}


					if(isset($project_idpost) && !empty($project_idpost)){
						if (($event_type == "bom_upload" && $FinalContractTotal > 0) || $event_type == 'add_edit_bom' || $event_type == 'release_qty' || $event_type == 'indent_request' || $event_type == 'purchase_order' || $event_type == 'vendor_proforma_invoice' || $event_type ==  'payment_receipt') {
							$data[] = array(
								$i,
								// $boq_code,
								$bp_code,
								// $item_description,
								$event_name,
								$event_type_name,
								sprintf('%0.2f', $FinalContractTotal),
								// $released_pending,
								$created_by_name,
								$approved_by_name,
								$created_at,
								$action);
							}
						}
						// pr($data);

					}

				}

				$output = array(
					"draw" => isset( $_POST['draw']) ? $_POST['draw'] : 0,
					"recordsTotal" => $allCount,
					"recordsFiltered" => $countFiltered,
					"data" => $data,
				);
				echo json_encode($output);
			}
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

		public function getBOMFinalContractamount($filter,$transaction_id,$transaction_type,$project_id,$status_txt,$boq_code){
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
			if(isset($filter) && !empty($filter) && isset($transaction_id) && !empty($transaction_id) && isset($transaction_type) && !empty($transaction_type) && isset($project_id) && !empty($project_id) && isset($boq_code) && !empty($boq_code)){
				$detail = $this->admin_model->get_bom_item_amount($filter,$transaction_id,$transaction_type,$project_id,$status_txt,$boq_code);
				if($detail){
					if(isset($detail['total_bom_gst_amount']) && !empty($detail['total_bom_gst_amount']) && $detail['total_bom_gst_amount'] > 0){
						$res['totalBOMAmountGST'] = $detail['total_bom_gst_amount'];
					}else{
						$res['totalBOMAmountGST'] = 0;
					}
				}
			}
			return $res;
		}

		public function approved_bom_details()
		{
			$save_stock_arr = $update_stock_arr = $save_exceptional_arr = array();
			$loguser_id = $this->session->userData('user_id');
			$logrole_id = $this->session->userData('role_id');
			if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
				$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_bom_details');
				if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
					$submenu_id = $submenu_data->submenu_id;
					$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
					if(isset($check_permission) && !empty($check_permission)){

						$project_id = $this->input->post('project_id');
						$boq_code = $this->input->post('boq_code');
						$a_status = $this->input->post('status');
						$transaction_id = $this->input->post('id');

						if(isset($project_id) && !empty($project_id)){
							$project_id = base64_decode($project_id);
						}

						$boq_code = $this->input->post('boq_code');
						if(isset($boq_code) && !empty($boq_code)){
							$boq_code = $boq_code;
						}

						if(isset($boq_items_id) && !empty($boq_items_id) && $boq_items_id > 0){
							$boq_items_id = $boq_items_id;
						}else{
							$boq_items_id = 0;
						}

						$qr_array = array('project_id' =>$project_id,'boq_code'=>$boq_code,'transaction_id' => $transaction_id);
						$bom_items_data=$this->common_model->selectDetailsWhereArr('tbl_bom_items',$qr_array);

						$boqExistData = $this->admin_model->get_boq_item_details($project_id,$boq_code);

						if(isset($boqExistData->o_design_qty) && !empty($boqExistData->o_design_qty) && $boqExistData->o_design_qty > 0){
							$boq_exist_design_qty = $boqExistData->o_design_qty;
						}

						if(isset($boqExistData->non_schedule) && !empty($boqExistData->non_schedule) && $boqExistData->non_schedule){
							$boq_exist_non_schedule = $boqExistData->non_schedule;
						}

						if(isset($boqExistData->scheduled_qty) && !empty($boqExistData->scheduled_qty) && $boqExistData->scheduled_qty > 0){
							$boq_exist_sch_qty = $boqExistData->scheduled_qty;
						}

						if(isset($bom_items_data) && !empty($bom_items_data)){
							foreach ($bom_items_data as $key => $bom_items) {
								if(isset($bom_items->status) && !empty($bom_items->status) && $bom_items->status !='approved'){
									if(isset($bom_items->bom_items_id) && !empty($bom_items->bom_items_id)) { $bom_items_id = $bom_items->bom_items_id; }else { $bom_items_id = 0; }
									if(isset($bom_items->boq_items_id) && !empty($bom_items->boq_items_id)) { $boq_items_id = $bom_items->boq_items_id; }else { $boq_items_id = 0; }
									if(isset($bom_items->project_id) && !empty($bom_items->project_id)) { $project_id = $bom_items->project_id; }else { $project_id = 0; }
									if(isset($bom_items->boq_code) && !empty($bom_items->boq_code)) { $boq_code = $bom_items->boq_code; }else { $boq_code = ''; }
									if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }
									if(isset($bom_items->hsn_sac_code) && !empty($bom_items->hsn_sac_code)) { $hsn_sac_code = $bom_items->hsn_sac_code; }else { $hsn_sac_code = ''; }
									if(isset($bom_items->item_description) && !empty($bom_items->item_description)) { $item_description = $bom_items->item_description; }else { $item_description = ''; }
									if(isset($bom_items->unit) && !empty($bom_items->unit)) { $unit = $bom_items->unit; }else { $unit = ''; }
									if(isset($bom_items->rate_basic) && !empty($bom_items->rate_basic)) { $rate_basic = $bom_items->rate_basic; }else { $rate_basic = 0; }
									if(isset($bom_items->gst) && !empty($bom_items->gst)) { $gst = $bom_items->gst; }else { $gst = 0; }
									// if(isset($bom_items->scheduled_qty) && !empty($bom_items->scheduled_qty)) { $scheduled_qty = $bom_items->scheduled_qty; }else { $scheduled_qty = 0; }
									if(isset($bom_items->o_design_qty) && !empty($bom_items->o_design_qty)) { $o_design_qty = $bom_items->o_design_qty; }else { $o_design_qty = 0; }
									if(isset($bom_items->upload_design_qty) && !empty($bom_items->upload_design_qty)) { $upload_design_qty = $bom_items->upload_design_qty; }else { $upload_design_qty = 0; }
									if(isset($bom_items->non_schedule) && !empty($bom_items->non_schedule)) { $non_schedule = $bom_items->non_schedule; }else { $non_schedule = 'N'; }
									if(isset($bom_items->transaction_id) && !empty($bom_items->transaction_id)) { $transaction_id = $bom_items->transaction_id; }else { $transaction_id = 0; }

									if(isset($bom_items->design_qty) && !empty($bom_items->design_qty)) { $chk_design_qty = $bom_items->design_qty; }else { $chk_design_qty = 0; }

									$check_bom_stock_details = $this->admin_model->check_bom_stock_details($bom_items->project_id, $boq_code, $bom_items->bom_code);

									$qty = $chk_design_qty - abs($o_design_qty);

									$db_total_stock = 0;
									$db_release_stock = 0;
									$db_dc_total_stock = 0;
									$db_dc_stock = 0;

									if(isset($check_bom_stock_details) && empty($check_bom_stock_details)) {

										$save_stock_arr = array('project_id'=>$project_id,'boq_code'=>$boq_code,'bom_code'=>$bom_code,'release_stock'=>$qty,
										'total_stock'=>$qty,'dc_total_stock'=>$qty,'dc_stock'=>$qty,
										'updated_by'=>$loguser_id,'updated_date'=>date('Y-m-d H:i:s'));

									} else {
										$db_total_stock  = $check_bom_stock_details->total_stock;
										$db_release_stock = $check_bom_stock_details->release_stock;
										$db_dc_total_stock = $check_bom_stock_details->dc_total_stock;
										$db_dc_stock = $check_bom_stock_details->dc_stock;

										$pending_approve_qty = $upload_design_qty - abs($chk_design_qty);

										$latest_total_stock = $db_total_stock + $pending_approve_qty;
										$latest_total_release_stock = $db_release_stock + $pending_approve_qty;
										$latest_dc_total_stock =  $db_dc_total_stock + $pending_approve_qty;
										$latest_dc_stock = $db_dc_stock + $pending_approve_qty;

										$update_stock_arr[] = array('boq_code'=>$boq_code,'bom_code'=>$bom_code,
										'total_stock'=>$latest_total_stock,
										'dc_total_stock'=>$latest_dc_total_stock,
										'dc_stock'=>$latest_dc_stock,
										'release_stock'=>$latest_total_release_stock,
										'updated_by'=>$loguser_id,'updated_date'=>date('Y-m-d H:i:s'));

									}

									if($a_status =='approved') {


										if($boq_exist_non_schedule == 'Y') {
											$single_ratio = $chk_design_qty / abs($boq_exist_design_qty);
										} else {
											$single_ratio = $chk_design_qty / abs($boq_exist_sch_qty);
										}


										$data = array(
											'bom_ratio'=> sprintf('%0.2f', $single_ratio),
											'o_design_qty'=> $upload_design_qty,
											'status'=>'approved','approved_by'=>$loguser_id,
											'approved_date'=>date('Y-m-d H:i:s')
										);
										$this->common_model->updateDetails('tbl_bom_items','bom_items_id',$bom_items_id,$data);

										if(isset($save_stock_arr) && !empty($save_stock_arr)){
											$this->common_model->addData('tbl_bom_stock',$save_stock_arr);
										}
										if(isset($update_stock_arr) && !empty($update_stock_arr)){

											$this->common_model->updateBOMStock($update_stock_arr,$project_id,$boq_code);
										}
									} else {
										$data = array('status'=>'reject','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
										$this->common_model->updateDetails('tbl_bom_items','bom_items_id',$bom_items_id,$data);
									}

									if(isset($transaction_id) && !empty($transaction_id) && $transaction_id > 0){
										$dataTrans = array('status'=>'approved','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
										$this->common_model->updateDetails('tbl_bom_transactions','id',$transaction_id,$dataTrans);
									}
								}
							}


							$this->json->jsonReturn(array(
								'valid'=>TRUE,
								'msg'=>'<div class="alert modify alert-success">BOM Item status changed successfully!</div>'
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

		public function approve_release_qty() {
			$save_stock_arr = $update_stock_arr = $save_exceptional_arr = array();
			$loguser_id = $this->session->userData('user_id');
			$logrole_id = $this->session->userData('role_id');
			if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
				$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_bom_release_stock');
				if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
					$submenu_id = $submenu_data->submenu_id;
					$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
					if(isset($check_permission) && !empty($check_permission)){

						$project_id = $this->input->post('project_id');
						$boq_code = $this->input->post('boq_code');
						$a_status = $this->input->post('status');
						$transaction_id = $this->input->post('id');

						if(isset($project_id) && !empty($project_id)){
							$project_id = base64_decode($project_id);
						}

						$boq_code = $this->input->post('boq_code');
						if(isset($boq_code) && !empty($boq_code)){
							$boq_code = $boq_code;
						}

						if(isset($boq_items_id) && !empty($boq_items_id) && $boq_items_id > 0){
							$boq_items_id = $boq_items_id;
						}else{
							$boq_items_id = 0;
						}
						$qr_array = array('project_id' =>$project_id,'boq_code'=>$boq_code,'transaction_id' => $transaction_id,'status'=> 'pending');
						$bom_items_data = $this->common_model->selectDetailsWhereArr('tbl_bom_release_stock',$qr_array);

						if(isset($bom_items_data) && !empty($bom_items_data)){
							foreach ($bom_items_data as $key => $bom_items) {
								if(isset($bom_items->status) && !empty($bom_items->status) && $bom_items->status !='approved'){
									if(isset($bom_items->bom_release_id) && !empty($bom_items->bom_release_id)) { $bom_release_id = $bom_items->bom_release_id; }else { $bom_release_id = 0; }
									if(isset($bom_items->project_id) && !empty($bom_items->project_id)) { $project_id = $bom_items->project_id; }else { $project_id = 0; }
									if(isset($bom_items->boq_code) && !empty($bom_items->boq_code)) { $boq_code = $bom_items->boq_code; }else { $boq_code = ''; }
									if(isset($bom_items->released_quantity) && !empty($bom_items->released_quantity)) { $released_quantity = $bom_items->released_quantity; }else { $released_quantity = ''; }
									if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }


									if(isset($bom_items->transaction_id) && !empty($bom_items->transaction_id)) { $transaction_id = $bom_items->transaction_id; }else { $transaction_id = 0; }


									$check_bom_stock_details = $this->admin_model->check_bom_stock_details($bom_items->project_id,$boq_code,$bom_items->bom_code);

									// $qty = $chk_design_qty - abs($o_design_qty);

									$db_total_stock = 0;
									$db_release_stock = 0;
									$db_dc_total_stock = 0;
									$db_dc_stock = 0;
									$db_indent_stock = 0;

									if(isset($check_bom_stock_details) && !empty($check_bom_stock_details)) {

										$db_release_stock = $check_bom_stock_details->release_stock;
										$db_indent_stock  = $check_bom_stock_details->indent_stock;
										$update_qty       =  $db_release_stock - $released_quantity;


										$db_indent_stock_pending = $check_bom_stock_details->indent_stock_pending;
										$total_reaming           = $db_release_stock - $db_indent_stock_pending;
										$total_indent_stock      = $db_indent_stock_pending + $db_indent_stock;

										$update_stock_arr[] = array(
											'boq_code'=>$boq_code,'bom_code'=>$bom_code,
											'release_stock'=> $total_reaming,
											'indent_stock'=>$total_indent_stock,
											'indent_stock_pending'=> 0,
											'updated_by'=>$loguser_id,
											'updated_date'=>date('Y-m-d H:i:s')
										);


									}

									if($a_status =='approved') {

										$last_release_qty_data = $this->admin_model->get_last_approved_release_qty($project_id,$boq_code,$bom_code);
										if(isset($last_release_qty_data->released_quantity) && !empty($last_release_qty_data->released_quantity)){
											$total_quantity = $last_release_qty_data->released_quantity + $released_quantity;
										} else {
											$total_quantity = $released_quantity;
										}

										$data = array('status'=>'approved','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));


										$this->common_model->updateDetails('tbl_bom_release_stock','bom_release_id',$bom_release_id,$data);

										if(isset($update_stock_arr) && !empty($update_stock_arr)){

											$this->common_model->updateBOMStock($update_stock_arr,$project_id,$boq_code);
										}
									} else {
										$data = array('status'=>'reject','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
										$this->common_model->updateDetails('tbl_bom_release_stock','bom_release_id',$bom_release_id,$data);
									}

									if(isset($transaction_id) && !empty($transaction_id) && $transaction_id > 0){
										$dataTrans = array('status'=>'approved','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
										$this->common_model->updateDetails('tbl_bom_transactions','id',$transaction_id,$dataTrans);
									}
								}
							}

							if($a_status =='approved') {
								$member = $this->admin_model->check_stock_details($project_id,$boq_code);
								if(isset($member) && !empty($member)) {
									if(isset($member->released_pending) && !empty($member->released_pending)) { $released_pending = $member->released_pending; }else { $released_pending = '0'; }
									if(isset($member->released_approved) && !empty($member->released_approved)) { $released_approved = $member->released_approved; }else { $released_approved = '0'; }

									$total_released = $released_approved + $released_pending;

									$update_boq_stock_arr = array(
										'released_pending' => 0,
										'released_approved' => $total_released,
										'updated_by'=>$loguser_id,
										'updated_date'=>date('Y-m-d H:i:s')
									);

									$boq_release_arr = array(
										'project_id'=>$project_id,
										'boq_code'=>$boq_code,
										// 'bom_code'=>$bom_code,
										'released_quantity'=> $released_pending,
										'status'=>'approved',
										'display' => 'Y',
										'created_by'=>$loguser_id,
										'created_on'=>date('Y-m-d H:i:s'),
										'updated_by'=> $loguser_id,
										'updated_date'=>date('Y-m-d H:i:s'),
										'transaction_id'=> $transaction_id,
									);

									if(isset($update_boq_stock_arr) && !empty($update_boq_stock_arr)){
										$this->common_model->updateBOQStockDetails($update_boq_stock_arr,$project_id,$boq_code);
									}

									if(isset($boq_release_arr) && !empty($boq_release_arr)) {
										$this->common_model->addData('tbl_boq_release_stock',$boq_release_arr);
									}
								}
							}

							$this->json->jsonReturn(array(
								'valid'=>TRUE,
								'msg'=>'<div class="alert modify alert-success">Release Quantity Approved Successfully!</div>'
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


		public function edit_bom_items(){
			$loguser_id = $this->session->userData('user_id');
			$logrole_id = $this->session->userData('role_id');

			if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
				$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_bom_items');
				if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
					$submenu_id = $submenu_data->submenu_id;
					$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
					if(isset($check_permission) && !empty($check_permission)){
						$check_permission_update = 'N';
						$submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_bom_item_approval');
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

			$project_id_post = $this->input->post('project_id');
			$boq_code_post = $this->input->post('boq_code');
			$page = $this->input->post('page');


			if(!empty($project_id_post) && isset($project_id_post) && isset($boq_code_post) && !empty($boq_code_post)) {
				$qr_array = array('project_id' =>$project_id_post,'boq_code'=>$boq_code_post);
				$bom_items_data= $this->common_model->selectDetailsWhereArr('tbl_bom_items',$qr_array);
				$project_data=$this->common_model->selectDetailsWhr('tbl_projects','project_id',$project_id_post);
				$data = array();
				$data['check_permission_update'] = $check_permission_update;
				$data['bom_items_data'] = $bom_items_data;
				$data['project_data'] = $project_data;
				$data['boq_code'] = $boq_code_post;
				$data['project_id'] = $project_id_post;
			} else {
				$data = array();
			}
			if($page == 'add_edit') {
				$member = $this->admin_model->get_boq_item_details($project_id_post,$boq_code_post);
				$data['boq_items_data'] = $member;
				$this->load->view('add-bom-items',$data);
			} else  {
				$this->load->view('upload-bom-items',$data);
			}

		}


		public function edit_bom_release_items(){

			$loguser_id = $this->session->userData('user_id');
			$logrole_id = $this->session->userData('role_id');

			if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
				$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_bom_release_stock');
				if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
					$submenu_id = $submenu_data->submenu_id;
					$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
					if(isset($check_permission) && !empty($check_permission)){
						$check_permission_update = 'N';
						$submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_bom_release_stock');
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

			$project_id_post = $this->input->post('project_id');
			$boq_code_post = $this->input->post('boq_code');
			$transaction_id = $this->input->post('transaction_id');
			$page = $this->input->post('page');


			if(!empty($project_id_post) && isset($project_id_post) && isset($boq_code_post) && !empty($boq_code_post)) {
				$qr_array = array('project_id' =>$project_id_post,'boq_code'=>$boq_code_post);
				$bom_items_data= $this->common_model->get_bom_release_boq_item_data($project_id_post, $boq_code_post);
				$project_data=$this->common_model->selectDetailsWhr('tbl_projects','project_id',$project_id_post);
				$data = array();
				$data['check_permission_update'] = $check_permission_update;
				$data['bom_items_data'] = $bom_items_data;
				$data['project_data'] = $project_data;
				$data['boq_code'] = $boq_code_post;
				$data['project_id'] = base64_encode($project_id_post);
			} else {
				$data = array();
			}

			$member = $this->admin_model->get_boq_oper_list_datatables_query_single($project_id_post,'B_pos',$boq_code_post);

			$data['boq_items_data'] = $member;
			$data['transaction_id'] = $transaction_id;

			if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = '0'; }
			if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
			if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = '0'; }
			if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = '0'; }

			$check_stock_details = $this->admin_model->check_stock_details($project_id_post,$boq_code_post);
			if(isset($check_stock_details) && !empty($check_stock_details)){
				$released_total_stock = 0;
				$released_pending = 0;
				$released_approved = 0;
				if(isset($check_stock_details->released_approved) && !empty($check_stock_details->released_approved)
				&& $check_stock_details->released_approved > 0){
					$released_approved = $check_stock_details->released_approved;
				}
				if(isset($check_stock_details->released_pending) && !empty($check_stock_details->released_pending)
				&& $check_stock_details->released_pending > 0){
					$released_pending = $check_stock_details->released_pending;
				}
			} else {
				$released_total_stock = 0;
				$released_pending = 0;
				$released_approved = 0;
			}
			if($design_qty > 0) {
				$avl_release_qty = $design_qty - $released_approved;
			} else{
				$avl_release_qty = 0;
			}


			$var_qty = 0;
			$var_qty = $design_qty - $scheduled_qty;
			$oprableAmount = 0;
			$oprableAmount = $design_qty * $rate_basic;
			$gst_amount=0;
			if($gst > 0 && $oprableAmount > 0){
				$gst_amount = $oprableAmount * ($gst/100);
			}
			$oprableAmountGST = $gst_amount + $oprableAmount;
			$data['var_qty'] = $var_qty;
			$data['scheduled_qty'] = $scheduled_qty;
			$data['avl_release_qty'] = $avl_release_qty;
			$data['released_pending'] = $released_pending;
			$this->load->view('add-edit-bom-release-qty',$data);

		}

		public function save_bom_release_qty_edit_item() {

			$loguser_id = $this->session->userData('user_id');
			$logrole_id = $this->session->userData('role_id');

			if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)) {
				$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_bom_release_stock');
				if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
					$submenu_id = $submenu_data->submenu_id;
					$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
					if(isset($check_permission) && !empty($check_permission)){

						$project_id = $this->input->post('project_id');
						if(isset($project_id) && !empty($project_id)){
							$project_id = base64_decode($project_id);
						}
						$error = 'N';
						$error_message = '';
						if(isset($loguser_id) && empty($loguser_id)){
							$error = 'Y';
							$error_message = 'Please loggedin!';
						}

						$boq_items = $this->input->post('bom_boq_sr_no');
						if(isset($boq_items) && !empty($boq_items)) { $boq_code = $boq_items; } else { $boq_code=''; }
						if(isset($boq_code) && empty($boq_code)){
							$error = 'Y';
							$error_message = 'BOQ Item is empty!';
						}

						$bom_code = $this->input->post('bom_code');
						if(isset($bom_code) && !empty($bom_code)) { $bom_code = $bom_code; } else { $bom_code=''; }
						if(isset($bom_code) && empty($bom_code)){
							$error = 'Y';
							$error_message = 'BOM Sr No is empty!';
						}

						$boq_rel_qty = $this->input->post('boq_rel_qty');
						if(isset($boq_rel_qty) && !empty($boq_rel_qty)) { $boq_rel_qty = $boq_rel_qty; } else { $boq_rel_qty=''; }
						if(isset($boq_rel_qty) && empty($boq_rel_qty)){
							$error = 'Y';
							$error_message = 'Release Quantity empty!';
						}

						$transaction_id = $this->input->post('transaction_id');




						if(isset($boq_code) && empty($boq_code) && isset($bom_code) && empty($bom_code) && isset($boq_rel_qty) && empty($boq_rel_qty)) {

							$this->json->jsonReturn(
								array(
									'valid'=>FALSE,
									'msg'=>'<div class="alert modify alert-danger">Please Enter Release Quantity!</div>'
								)
							);
						} else {


							$member = $this->admin_model->get_boq_item_details($project_id,$boq_code);

							if(isset($member) && !empty($member)) {

								if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }


								$qr_array = array('project_id' =>$project_id,'boq_code'=>$boq_code);
								$bom_items_data = $this->common_model->selectDetailsWhereArrBom('tbl_bom_items',$qr_array);

								if(isset($bom_items_data) && !empty($bom_items_data)) {
									foreach ($bom_items_data as $key => $bom_items) {
										if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }
										if(isset($bom_items->design_qty) && !empty($bom_items->design_qty)) { $bom_design_qty = $bom_items->design_qty; }else { $bom_design_qty = ''; }
										if(isset($bom_items->bom_ratio) && !empty($bom_items->bom_ratio)) { $bom_ratio = $bom_items->bom_ratio; }else { $bom_ratio = ''; }

										$total_bom_release_qty = $boq_rel_qty * $bom_ratio;

										$bom_release_stock = $this->common_model->get_bom_release_stock_data_pending($project_id, $boq_code, $bom_code);

										if(isset($bom_release_stock->bom_release_id) && !empty($bom_release_stock->bom_release_id)) { $bom_release_id = $bom_release_stock->bom_release_id ; }  else { $bom_release_id  = '';}

										$update_stock_arr[] = array(
											'boq_code'=>$boq_code,
											'bom_code'=> $bom_code,
											//'indent_stock' => $total_bom_release_qty,
											'indent_stock_pending' =>$total_bom_release_qty,
											//'release_stock' => $reaming_qty,
											'updated_by'=> $loguser_id,
											'updated_date'=>date('Y-m-d H:i:s')
										);

										$release_stock_arr = array(
											'released_quantity'=> $total_bom_release_qty,
											'status'=>'pending',
											'updated_by'=> $loguser_id,
											'updated_date'=>date('Y-m-d H:i:s'),
										);

										$this->common_model->updateDetails('tbl_bom_release_stock','bom_release_id',$bom_release_id,$release_stock_arr);
									}
									if(isset($update_stock_arr) && !empty($update_stock_arr)){
										$this->common_model->updateBOMStock($update_stock_arr,$project_id,$boq_code);
									}
								}
							}

							$update_boq_stock_arr = array(
								'released_pending' => $boq_rel_qty,
								'updated_by'=>$loguser_id,
								'updated_date'=>date('Y-m-d H:i:s')
							);

							if(isset($update_boq_stock_arr) && !empty($update_boq_stock_arr)){
								$this->common_model->updateBOQStockDetails($update_boq_stock_arr,$project_id,$boq_code);
							}
						}

						if((isset($update_stock_arr) && !empty($update_stock_arr))){
							$dataTrans = array('status'=>'pending','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
							$this->common_model->updateDetails('tbl_bom_transactions','id',$transaction_id,$dataTrans);
							$this->json->jsonReturn(array(
								'valid'=>TRUE,
								'msg'=>'<div class="alert modify alert-success">BOM Stock Release Successfully!</div>',
								'redirect' => base_url().'bom-release-quantity',
							));
						} else {
							$this->json->jsonReturn(array(
								'valid'=>FALSE,
								'msg'=>'<div class="alert modify alert-danger">Please Enter Valid BOM Items Details!!</div>'
							));
						}
					} else {
						$this->json->jsonReturn(array(
							'valid'=>FALSE,
							'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
						));
					}
				}
			}

		}

		public function get_bom_item_details() {
			$res = array();
			$project_id = $this->input->post('project_id');
			$bom_code = $this->input->post('bom_code');
			$boq_code = $this->input->post('boq_code');
			$user_id = $this->session->userData('user_id');

			if(isset($user_id) && !empty($user_id)
			&& isset($project_id) && !empty($project_id)
			&& isset($bom_code) && !empty($bom_code)){

				$member = $this->admin_model->get_bom_item_details($project_id,$bom_code,$boq_code);
				if(isset($member) && !empty($member)){
					if(isset($member->bom_items_id) && !empty($member->bom_items_id)) { $res['bom_items_id'] = $member->bom_items_id; }else { $res['bom_items_id'] = '0'; }
					if(isset($member->project_id) && !empty($member->project_id)) { $res['project_id'] = $member->project_id; }else { $res['project_id'] = '0'; }
					if(isset($member->boq_code) && !empty($member->boq_code)) { $res['boq_code'] = $member->boq_code; }else { $res['boq_code'] = ''; }
					if(isset($member->bom_code) && !empty($member->bom_code)) { $res['bom_code'] = $member->bom_code; }else { $res['bom_code'] = ''; }
					if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $res['hsn_sac_code'] = $member->hsn_sac_code; }else { $res['hsn_sac_code'] = ''; }
					if(isset($member->item_description) && !empty($member->item_description)) { $res['item_description'] = $member->item_description; }else { $res['item_description'] = ''; }
					if(isset($member->unit) && !empty($member->unit)) { $res['unit'] = $member->unit; }else { $res['unit'] = ''; }
					if(isset($member->o_design_qty) && !empty($member->o_design_qty)) { $res['o_design_qty'] = $member->o_design_qty; }else { $res['o_design_qty'] = ''; }
					if(isset($member->make) && !empty($member->make)) { $res['make'] = $member->make; }else { $res['make'] = ''; }
					if(isset($member->model) && !empty($member->model)) { $res['model'] = $member->model; }else { $res['model'] = ''; }
					// if(isset($member->design_qty) && !empty($member->design_qty)) { $res['design_qty'] = $member->design_qty; }else { $res['design_qty'] = '0'; }
					if(isset($member->design_qty) && !empty($member->design_qty)) { $res['design_qty'] = $member->design_qty; }else { $res['design_qty'] = '0'; }
					if(isset($member->rate_basic) && !empty($member->rate_basic)) { $res['rate_basic'] = $member->rate_basic; }else { $res['rate_basic'] = '0'; }
					if(isset($member->gst) && !empty($member->gst)) { $res['gst'] = $member->gst; }else { $res['gst'] = '0'; }
					if(isset($member->non_schedule) && !empty($member->non_schedule)) { $res['non_schedule'] = $member->non_schedule; }else { $res['non_schedule'] = 'N'; }
					if(isset($member->status) && !empty($member->status)) { $res['bom_status'] = $member->status; }else { $res['bom_status'] = 'N'; }
				}
			}
			echo json_encode($res);
		}

		public function save_bom_edit_item() {

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

				$boq_items = $this->input->post('bom_boq_sr_no');
				if(isset($boq_items) && !empty($boq_items)) {$boq_items = $boq_items; } else {$boq_items=''; }
				if(isset($boq_items) && empty($boq_items)){
					$error = 'Y';
					$error_message = 'BOQ item not found!';
				}

				$bom_code = $this->input->post('bom_code');
				if(isset($bom_code) && !empty($bom_code)) {$bom_code = $bom_code; } else {$bom_code=''; }
				if(isset($bom_code) && empty($bom_code)){
					$error = 'Y';
					$error_message = 'Please enter BOM Sr.No.!';
				}

				$bom_hsn_sac_code = $this->input->post('bom_hsn_sac_code');
				if(isset($bom_hsn_sac_code) && !empty($bom_hsn_sac_code)) {$bom_hsn_sac_code = $bom_hsn_sac_code; } else {$bom_hsn_sac_code=''; }
				if(isset($bom_hsn_sac_code) && empty($bom_hsn_sac_code)){
					$error = 'Y';
					$error_message = 'Please enter HSN Code!';
				}

				$bom_item_description = $this->input->post('bom_item_description');
				if(isset($bom_item_description) && !empty($bom_item_description)) {$bom_item_description = $bom_item_description; } else {$bom_item_description=''; }
				if(isset($bom_item_description) && empty($bom_item_description)){
					$error = 'Y';
					$error_message = 'Please enter Item Description!';
				}

				$bom_unit = $this->input->post('bom_unit');
				if(isset($bom_unit) && !empty($bom_unit)) {$bom_unit = $bom_unit; } else {$bom_unit=''; }
				if(isset($bom_unit) && empty($bom_unit)){
					$error = 'Y';
					$error_message = 'Please enter Unit!';
				}

				$bom_o_design_qty = $this->input->post('bom_o_design_qty');
				if(isset($bom_o_design_qty) && !empty($bom_o_design_qty)) {$bom_o_design_qty = $bom_o_design_qty; } else {$bom_o_design_qty=''; }
				if(isset($bom_o_design_qty) && empty($bom_o_design_qty)){
					$error = 'Y';
					$error_message = 'Please enter Build Qty!';
				}

				$bom_rate_basic = $this->input->post('bom_rate_basic');
				if(isset($bom_rate_basic) && !empty($bom_rate_basic)) {$bom_rate_basic = $bom_rate_basic; } else {$bom_rate_basic=''; }
				if(isset($bom_rate_basic) && empty($bom_rate_basic)){
					$error = 'Y';
					$error_message = 'Please enter Basic Rate!';
				}

				$bom_gst = $this->input->post('bom_gst');
				if(isset($bom_gst) && !empty($bom_gst)) {$bom_gst = $bom_gst; } else {$bom_gst=''; }
				if(isset($bom_gst) && empty($bom_gst)){
					$error = 'Y';
					$error_message = 'Please enter GST!';
				}


				$bom_item_make = $this->input->post('bom_item_make');
				if(isset($bom_item_make) && !empty($bom_item_make)) {$bom_item_make = $bom_item_make; } else {$bom_item_make=''; }

				$bom_item_model = $this->input->post('bom_item_model');
				if(isset($bom_item_model) && !empty($bom_item_model)) {$bom_item_model = $bom_item_model; } else {$bom_item_model=''; }


				$transaction_id = $this->input->post('transaction_id');


				if(isset($boq_items) && empty($boq_items)
				&& isset($bom_code) && empty($bom_code)
				&& isset($bom_hsn_sac_code) && empty($bom_hsn_sac_code)
				&& isset($bom_item_description) && empty($bom_item_description)
				&& isset($bom_unit) && empty($bom_unit)
				&& isset($bom_o_design_qty) && empty($bom_o_design_qty)
				&& isset($bom_rate_basic) && empty($bom_rate_basic)
				&& isset($bom_gst) && empty($bom_gst)
			){
				$this->json->jsonReturn(array(
					'valid'=>FALSE,
					'msg'=>'<div class="alert modify alert-danger">Please Enter BOM item Details!!</div>'
				));
			}else{
				if($error == 'N'){
					if(isset($boq_items) && !empty($boq_items) && isset($bom_code) && !empty($bom_code)) {

						$inserdata = array();
						for($i=0;$i<count($bom_code);$i++){
							if(!empty($bom_code[$i])) {
								if(isset($bom_code[$i]) && !empty($bom_code[$i])) { $bom_code_s =  $bom_code[$i]; } else { $bom_code_s =''; }

								$member = $this->admin_model->get_bom_item_details($project_id, $bom_code_s, $boq_items);

								if(isset($bom_hsn_sac_code[$i]) && !empty($bom_hsn_sac_code[$i])) { $bom_hsn_sac_code_s = $bom_hsn_sac_code[$i]; } else {$bom_hsn_sac_code_s=''; }
								if(isset($bom_item_description[$i]) && !empty($bom_item_description[$i])) { $bom_item_description_s = $bom_item_description[$i]; } else {$bom_item_description_s =''; }
								if(isset($bom_unit[$i]) && !empty($bom_unit[$i])) { $bom_unit_s = $bom_unit[$i]; } else { $bom_unit_s =''; }
								if(isset($bom_o_design_qty[$i]) && !empty($bom_o_design_qty[$i])) { $design_qty_s = $bom_o_design_qty[$i]; } else { $design_qty_s =''; }
								if(isset($bom_rate_basic[$i]) && !empty($bom_rate_basic[$i])) { $bom_rate_basic_s = $bom_rate_basic[$i]; } else { $bom_rate_basic_s =''; }
								if(isset($bom_gst[$i]) && !empty($bom_gst[$i])) { $bom_gst_s = $bom_gst[$i]; } else { $bom_gst_s =''; }

								if(isset($bom_item_make[$i]) && !empty($bom_item_make[$i])) { $bom_item_make_s = $bom_item_make[$i]; } else { $bom_item_make_s =''; }
								if(isset($bom_item_model[$i]) && !empty($bom_item_model[$i])) { $bom_item_model_s = $bom_item_model[$i]; } else { $bom_item_model_s =''; }


								if(!empty($member) && isset($member)) {
									if(isset($member->bom_items_id) && !empty($member->bom_items_id)) { $bom_items_id = $member->bom_items_id; } else { $bom_items_id = ''; }

									$updateDesignQtyArr[] = array('bom_items_id'=>$bom_items_id,'design_qty'=>$design_qty_s,'upload_design_qty'=>$design_qty_s,'modified_by'=>$user_id,'status' =>'pending','modified_on'=>date('Y-m-d H:i:s'));

								} else{
									$inserdata[$i]['project_id'] = $project_id;
									$inserdata[$i]['boq_code'] = $boq_items;
									$inserdata[$i]['bom_code'] = $bom_code_s;
									$inserdata[$i]['hsn_sac_code'] =  $bom_hsn_sac_code_s;
									$inserdata[$i]['item_description'] =  $bom_item_description_s;
									$inserdata[$i]['unit'] =  $bom_unit_s;
									$inserdata[$i]['scheduled_qty'] = $design_qty_s;
									$inserdata[$i]['design_qty'] = $design_qty_s;
									$inserdata[$i]['upload_design_qty'] = $design_qty_s;
									$inserdata[$i]['rate_basic'] =  $bom_rate_basic_s;
									$inserdata[$i]['gst'] =  $bom_gst_s;
									$inserdata[$i]['make'] =  $bom_item_make_s;
									$inserdata[$i]['model'] =  $bom_item_model_s;
									$inserdata[$i]['non_schedule'] =  '';
									$inserdata[$i]['created_by'] =  $user_id;
									$inserdata[$i]['created_on'] =  date('Y-m-d H:i:s');
									$inserdata[$i]['modified_by'] =  $user_id;
									$inserdata[$i]['modified_on'] =  date('Y-m-d H:i:s');
									// $inserdata[$i]['steps'] =  $steps;
									$inserdata[$i]['status'] =  'pending';
									$inserdata[$i]['transaction_id'] = $transaction_id;
								}
							}
						}
					}

					if(isset($inserdata) && !empty($inserdata)) {
						$this->common_model->SaveMultiData('tbl_bom_items',$inserdata);
					}

					if(isset($updateDesignQtyArr) && !empty($updateDesignQtyArr)){
						$this->admin_model->updateMultiData('tbl_bom_items',$updateDesignQtyArr,'bom_items_id');
					}

					if((isset($inserdata) && !empty($inserdata)) || (isset($updateDesignQtyArr) && !empty($updateDesignQtyArr))){
						$this->json->jsonReturn(array(
							'valid'=>TRUE,
							'msg'=>'<div class="alert modify alert-success">BOM Items Saved Successfully!</div>',
							'redirect' => base_url().'upload-bom-items'
						));
					} else {
						$this->json->jsonReturn(array(
							'valid'=>FALSE,
							'msg'=>'<div class="alert modify alert-danger">Please Enter Valid BOM Items Details!!</div>'
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


	public function check_bom_pending_approvel() {
		$res = array();
		$count = 0;
		$project_id = $this->input->post('project_id');
		$boq_code = $this->input->post('boq_code');
		$user_id = $this->session->userData('user_id');

		if(isset($user_id) && !empty($user_id)
		&& isset($project_id) && !empty($project_id)
		&& isset($boq_code) && !empty($boq_code)){
			$count = $this->admin_model->get_bom_boq_pending($project_id,$boq_code);
		}
		$data['count'] = $count;
		echo json_encode($data);
	}

	public function check_build_qty(){
		$project_id = $this->input->post('project_id');
		$boq_code = $this->input->post('boq_code');
		$last_design_qty = 0;
		$non_schedule ='';
		$scheduled_qty = 0;
		if(isset($project_id) && !empty($project_id) && isset($boq_code) && !empty($boq_code)){
			$get_last_design_qty = $this->admin_model->get_boq_item_details($project_id,$boq_code);
			if(isset($get_last_design_qty->design_qty) && !empty($get_last_design_qty->design_qty) && $get_last_design_qty->design_qty > 0){
				$last_design_qty = $get_last_design_qty->design_qty;
			}
			if(isset($get_last_design_qty->non_schedule) && !empty($get_last_design_qty->non_schedule) && $get_last_design_qty->non_schedule) {
				$non_schedule = $get_last_design_qty->non_schedule;
			}
			if(isset($get_last_design_qty->	scheduled_qty) && !empty($get_last_design_qty->scheduled_qty) && $get_last_design_qty->scheduled_qty) {
				$scheduled_qty = $get_last_design_qty->scheduled_qty;
			}
		}
		echo json_encode(array(
			'last_design_qty' => $last_design_qty,
			'non_schedule' => $non_schedule,
			'scheduled_qty' => $scheduled_qty
		));
	}

	public function get_last_design_qty_bom_item() {
		$project_id = $this->input->post('project_id');
		$boq_code = $this->input->post('boq_code');
		$bom_code = $this->input->post('bom_code');

		$last_design_qty = 0;
		if(isset($project_id) && !empty($project_id) && isset($boq_code) && !empty($boq_code) && !empty($bom_code) && isset($bom_code)){
			$get_last_design_qty = $this->admin_model->get_bom_item_details($project_id,$bom_code,$boq_code);
			if(isset($get_last_design_qty->o_design_qty) && !empty($get_last_design_qty->o_design_qty) && $get_last_design_qty->o_design_qty > 0){
				$last_design_qty = $get_last_design_qty->o_design_qty;
			}
		}
		echo $last_design_qty;
	}

	public function release_bom_qty($project_id) {
		$id = $this->uri->segment(2);
		$type = $this->uri->segment(3);
		if(isset($id) && !empty($id)){
			$id = base64_decode($id);
		}

		$schedule_type = base64_decode($type);
		$bp_code = $this->admin_model->get_bp_code($id);

		$notification_data = $this->common_model->ProjNotReadNotification($id);
		$reminder_data = $this->common_model->ProjNotReadReminder($id);

		$schedule_release = $this->admin_model->check_schedule_approved('A',$id);
		if(empty($schedule_release)) { $s_release ="no"; } else { $s_release ="yes"; }

		$data['notification_data'] = $notification_data;
		$data['reminder_data'] = $reminder_data;
		$data['bp_code'] = $bp_code;
		$data['project_id'] = $id;
		$data['schedule_type'] = $schedule_type;
		$data['schedule_release'] = $s_release;

		$this->load->view('release-bom-qty',$data);
	}

	public function boq_scha_list_display_for_bom_release_qty() {
		$project_id = $this->input->post('project_id');
		if(isset($project_id) && !empty($project_id)){
			$project_id = base64_decode($project_id);
		}
		$type='operable_a_release';
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
			$data = $row = array();
			$memData = $this->admin_model->getBOQOperListRows($_POST,$project_id,$type);
			$allCount = $this->admin_model->countBOQOperListAll($project_id,$type);
			$countFiltered = $this->admin_model->countBOQOperListFiltered($_POST,$project_id,$type);
			$i = $_POST['start'];

			$schedule_release = $this->admin_model->check_schedule_approved('A',$project_id);

			if(empty($schedule_release)) { $s_release ="no"; } else { $s_release ="yes"; }

			$boq_exceptional_pending = $this->admin_model->countBOQExceptItemListAll($project_id);
			$boq_exceptional_pending_1 = $this->admin_model->countBOQExceptItemListAllByExceptionalId($project_id);

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
				// if(isset($member->status) && !empty($member->status) && $status == 'Y') { $status = 'Approved'; }else { $status = 'Not Approved'; }
				if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
				if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }


				$ea_negative_qty = $this->admin_model->check_negative_ea($project_id,$boq_code);
				if($ea_negative_qty > 0) {
					$qty = $design_qty;
				} else {
					$qty = $scheduled_qty;
				}
				$qr_array = array('project_id' =>$project_id,'boq_code'=>$boq_code);
				$bom_items_data = $this->common_model->selectDetailsWhereArrBom('tbl_bom_items',$qr_array);
				$unique_arr =[];
				$unique_bom_items =[];

				if (isset($bom_items_data) && !empty($bom_items_data)) {
					foreach ($bom_items_data as $bom_item) {
						if (!in_array($bom_item->bom_code, $unique_arr)) {
							array_push($unique_arr, $bom_item->bom_code);
							$unique_bom_items[] = $bom_item;
						}
					}
				}

				$bom_data = array();

				if(isset($unique_bom_items) && !empty($unique_bom_items)){
					foreach ($unique_bom_items as $key => $bom_items) {



						if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }
						// if(isset($bom_items->hsn_sac_code) && !empty($bom_items->hsn_sac_code)) { $hsn_sac_code = $bom_items->hsn_sac_code; }else { $hsn_sac_code = ''; }
						if(isset($bom_items->hsn_sac_code) && !empty($bom_items->hsn_sac_code)) { $bom_hsn_sac_code = $bom_items->hsn_sac_code; }else { $bom_hsn_sac_code = ''; }
						if(isset($bom_items->item_description) && !empty($bom_items->item_description)) { $bom_item_description = $bom_items->item_description; }else { $bom_item_description = ''; }
						if(isset($bom_items->unit) && !empty($bom_items->unit)) { $bom_unit = $bom_items->unit; }else { $bom_unit = ''; }
						// if(isset($bom_items->o_design_qty) && !empty($bom_items->o_design_qty)) { $bom_o_design_qty = $bom_items->o_design_qty; }else { $bom_o_design_qty = ''; }
						if(isset($bom_items->design_qty) && !empty($bom_items->design_qty)) { $bom_design_qty = $bom_items->design_qty; }else { $bom_design_qty = ''; }
						if(isset($bom_items->rate_basic) && !empty($bom_items->rate_basic)) { $bom_rate_basic = $bom_items->rate_basic; }else { $bom_rate_basic = ''; }
						if(isset($bom_items->gst) && !empty($bom_items->gst)) { $bom_gst = $bom_items->gst; }else { $bom_gst = ''; }
						// if(isset($bom_items->gst) && !empty($bom_items->gst)) { $bom_gst = $bom_items->gst; }else { $bom_gst = ''; }
						if(isset($bom_items->make) && !empty($bom_items->make)) { $make = $bom_items->make; }else { $make = ''; }
						if(isset($bom_items->model) && !empty($bom_items->model)) { $model = $bom_items->model; }else { $model = ''; }
						if(isset($bom_items->bom_ratio) && !empty($bom_items->bom_ratio)) { $bom_ratio = $bom_items->bom_ratio; }else { $bom_ratio = ''; }

						$release_stock = $bom_ratio * $qty;


						$html_d ="";
						$html_d.='<a href="javascript:;" class="delete tooltips " rel="" title="" rev="delete_boq_details" data-original-title="Delete Role"><i class="fa fa-trash-o" style="color:#a94442; font-size: 15px;"></i></a>';
						if($bom_gst > 0){
							$total_amount = ($bom_rate_basic * $release_stock);
							$gst_amount=0;
							if($total_amount > 0 && $bom_gst > 0){
								$gst_amount =  $total_amount * ($bom_gst/100);
							}
							$final_amount = $total_amount + $gst_amount;
						} else {
							$final_amount = 0;
						}
						// sprintf('%0.2f', $final_amount),
						$bom_data[] = array(
							$bom_code,
							$bom_hsn_sac_code,
							$bom_item_description,
							$make,
							$model,
							$bom_unit,
							sprintf('%0.2f', $release_stock),
							$bom_rate_basic,
							$bom_gst,
							sprintf('%0.2f', $final_amount),

						);


					}
				}

				$html ='';
				$html.='&nbsp;<a href="javascript:;" class="tooltips openBomview" rev="view_bom_items" rel="" project_id="'.$project_id.'" boq_code="'.$boq_code.'" title="" data-original-title="View BOM">Close </a>';

				$oprableAmount = 0;
				$oprableAmount = $rate_basic * $design_qty;
				$gst_amount=0;
				if($oprableAmount > 0 && $gst > 0){
					$gst_amount =  $oprableAmount * ($gst/100);
				}
				$oprableAmountGST=0;
				$oprableAmountGST = $gst_amount + $oprableAmount;

				$bom_item_count = $this->admin_model->boq_exceptional_bom_item($project_id,$boq_code);



				if($s_release =='no') {
					if($bom_item_count  > 0 ) {
						$data[] = array(
							$i,
							//$bp_code,
							$boq_code,
							$item_description,
							$unit,
							$qty,
							$design_qty,
							$rate_basic,
							sprintf('%0.2f', $oprableAmount),
							sprintf('%0.2f', $gst),
							sprintf('%0.2f', $gst_amount),
							sprintf('%0.2f', $oprableAmountGST),
							$html,
							'subTableData' => $bom_data,
						);
					} else {
						$boq_without_bom[] = $boq_code;
					}
				}
			}

			if(!empty($boq_without_bom)) {
				$data = array();
			}

			if($boq_exceptional_pending > 0) {
				$data = array();
			}

			if($boq_exceptional_pending_1 > 0) {
				$data = array();
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $allCount,
				"recordsFiltered" => $countFiltered,
				"data" => $data,
				'boq_without_bom' => $boq_without_bom,
				'boq_exceptional_design' => $boq_exceptional_pending,
				'boq_exceptional_ea' => $boq_exceptional_pending_1,
			);

			echo json_encode($output);

		}
	}


	public function get_bom_item_subtable_data_release_qty($project_id,$boq_code,$boq_release_qty) {
		$qr_array = array('project_id' =>$project_id,'boq_code'=>$boq_code);
		$bom_items_data = $this->common_model->selectDetailsWhereArrBom('tbl_bom_items',$qr_array);

		$bom_data = array();
		$unique_arr = [];
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


				$html_d ="";
				$html_d.='<a href="javascript:;" class="delete tooltips " rel="" title="" rev="delete_boq_details" data-original-title="Delete Role"><i class="fa fa-trash-o" style="color:#a94442; font-size: 15px;"></i></a>';


				if(!empty($boq_release_qty) && $boq_release_qty > 0) {
					$bom_design_qty = $bom_ratio * $boq_release_qty;
				} else if($boq_release_qty <= 0) {
					$bom_design_qty = 0;
				} else {
					$bom_design_qty = $bom_design_qty;
				}

				if($bom_gst > 0){
					$total_amount = ($bom_rate_basic * $bom_design_qty);
					$gst_amount = 0;
					if($total_amount > 0 && $bom_gst > 0){
						$gst_amount =  $total_amount * ($bom_gst/100);
					}
					$final_amount = $total_amount + $gst_amount;
				} else {
					$final_amount = 0;
				}

				$bom_sr_no_d = '<input type="text" class="form-control invaliderror" name="bom_code[]"   value="'.$bom_code.'" placeholder="BOM Sr.No." style="font-size: 12px;width:100%" readonly>';
				$bom_hsn_code_d = '<input type="text" class="form-control invaliderror" name="bom_hsn_code[]"   value="'.$bom_hsn_sac_code.'" placeholder="HNS Code" style="font-size: 12px;width:100%" readonly>';
				$item_description_d = '<input type="text" class="form-control invaliderror" name="bom_item_description[]"   value="'.$bom_item_description.'" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>';
				$make_d = '<input type="text" class="form-control invaliderror" name="make[]" value="'.$make.'" placeholder="Make" style="font-size: 12px;width:100%" readonly>';
				$model_d = '<input type="text" class="form-control invaliderror" name="model[]" value="'.$model.'" placeholder="Model" style="font-size: 12px;width:100%" readonly>';
				$bom_unit_d = '<input type="text" class="form-control invaliderror"  name="bom_unit[]"  value="'.$bom_unit.'" placeholder="Unit" style="font-size: 12px;width:100%" readonly>';
				$release_qty_d = '<input type="hidden" class="form-control invaliderror bom_ratio" name="bom_ratio[]"  value="'.$bom_ratio.'" readonly><input type="hidden" class="form-control invaliderror bom_original_avl_qty" name="bom_original_avl_qty[]"  value="'.$bom_design_qty.'" placeholder="Release Qty" style="font-size: 12px;width:100%" readonly>
				<input type="text" class="form-control invaliderror bom_release_avl_qty color-red" name="bom_release_qty[]"  value="'.$bom_design_qty.'" placeholder="Release Qty" style="font-size: 12px;width:100%" readonly>';
				$bom_rate_basic_d = '<input type="text" class="form-control invaliderror js-bom-rate-basic" name="bom_rate_basic[]"  value="'.$bom_rate_basic.'" placeholder="Basic Rate" style="font-size: 12px;width:100%" readonly>';
				$bom_gst_d = '<input type="text" class="form-control invaliderror js-bom-gst" name="bom_gst[]" value="'.$bom_gst.'" placeholder="Basic Rate" style="font-size: 12px;width:100%" readonly>';
				$amount_d = '<input type="text" class="form-control invaliderror js-bom-amount" name="bom_amount[]"  value="'.sprintf('%0.2f', $final_amount).'" placeholder="Basic Rate" style="font-size: 12px;width:100%" readonly>';

				if(!in_array($bom_sr_no_d,$unique_arr)){
					array_push($unique_arr,$bom_sr_no_d);
					$bom_data[] = array(
						$bom_sr_no_d,
						$bom_hsn_code_d,
						$item_description_d,
						$make_d,
						$model_d,
						$bom_unit_d,
						$release_qty_d,
						$bom_rate_basic_d,
						$bom_gst_d,
						$amount_d,
					);
				}
			}
		}
		return  array(
			'bom_data' => $bom_data,
			'count' => count($bom_data)
		);
	}

	public function boq_schb_list_display_for_bom_release_qty() {
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
			$boq_release_pending = array();
			$unique_arr = [];
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
				// if(isset($member->status) && !empty($member->status) && $status == 'Y') { $status = 'Approved'; }else { $status = 'Not Approved'; }
				if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
				if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }

				$check_stock_details = $this->admin_model->check_stock_details($project_id,$boq_code);
				if(isset($check_stock_details) && !empty($check_stock_details)){

					$released_total_stock = 0;
					$released_pending = 0;
					$released_approved = 0;

					if(isset($check_stock_details->released_approved) && !empty($check_stock_details->released_approved) && $check_stock_details->released_approved > 0){
						$released_approved = $check_stock_details->released_approved;
					}
				} else {
					$released_total_stock = 0;
					$released_pending = 0;
					$released_approved = 0;
				}


				if($design_qty > 0) {
					$avl_release_qty = $design_qty - $released_approved;
				} else{
					$avl_release_qty = 0;
				}


				$bom_subtable_data = $this->get_bom_item_subtable_data_release_qty($project_id,$boq_code,$avl_release_qty);

				$bom_subtable = $bom_subtable_data['bom_data'];
				$count = $bom_subtable_data['count'];

				$html ='';
				$html.='&nbsp;<a href="javascript:;" class="tooltips openBomview" rev="view_bom_items" rel="" project_id="'.$project_id.'" boq_code="'.$boq_code.'" title="" data-original-title="View BOM">Close </a>';
				$html.='&nbsp;&nbsp;<a href="javascript:;" class="delete tooltips delete_bom_qty" rel="" title="" rev="" data-original-title="Delete Role"><i class="fa fa-trash-o" style="color:#a94442; font-size: 15px;"></i></a>';

				$var_qty = 0;
				$var_qty = $design_qty - $scheduled_qty;
				$oprableAmount = 0;
				$oprableAmount = $design_qty * $rate_basic;
				$gst_amount=0;
				if($gst > 0 && $oprableAmount > 0){
					$gst_amount = $oprableAmount * ($gst/100);
				}
				$oprableAmountGST = $gst_amount + $oprableAmount;

				$sr_no_d = '<input type="text" class="form-control invaliderror js-sr_no" name="sr_no[]" id="sr_no" value="'.$i.'" placeholder="Sr.no" style="font-size: 12px;width:100%" readonly>';
				$item_description_d = '<input type="text" class="form-control invaliderror js-item_description" name="item_description[]" value="'.$item_description.'" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>';
				$boq_sr_no_d = '<input type="text" class="form-control invaliderror js-boq_sr_no" name="boq_sr_no[]"  id="boq_sr_no" value="'.$boq_code.'" placeholder="BOQ Sr No" style="font-size: 12px;width:100%" readonly>';

				$unit_d = '<input type="text" class="form-control invaliderror js-unit" name="unit[]" id="unit" value="'.$unit.'" placeholder="Unit" style="font-size: 12px;width:100%" readonly>';
				$scheduled_d = '<input type="text" class="form-control invaliderror js-scheduled_qty" name="scheduled_qty[]"  id="scheduled_qty" value="'.$scheduled_qty.'" placeholder="Sch Qty" style="font-size: 12px;width:100%" readonly>';
				$var_d = '<input type="text" class="form-control invaliderror js-var-qty" name="var_qty[]" id="var_qty" value="'.'+'.$var_qty.'" placeholder="Variation Qty" style="font-size: 12px;width:100%" readonly>';
				$design_qty_d = '<input type="text" class="form-control invaliderror js-avl_release_qty" name="avl_release_qty[]"  id="var_qty" value="'.'+'.$avl_release_qty.'" placeholder="Avl Relase Qty" style="font-size: 12px;width:100%" readonly>';
				$release_qty_d = '<input type="number" class="form-control invaliderror js-release_qty" name="release_qty[]"  id="release_qty" value="'.$avl_release_qty.'" placeholder="Release Qty" style="font-size: 12px;width:100%">';

				$release_pending = $this->admin_model->check_release_qty_pending($project_id,$boq_code);


				if(empty($release_pending)) {

					if($avl_release_qty > 0) {

						if(!in_array($boq_sr_no_d,$unique_arr)){
							array_push($unique_arr,$boq_sr_no_d);
							$data[] = array(
								$sr_no_d,
								//$bp_code,
								$boq_sr_no_d,
								$item_description_d,
								$unit_d,
								$scheduled_d,
								$var_d,
								$design_qty_d,
								$release_qty_d,
								$html,
								'subTableData' => $bom_subtable,

							);
						}
					}
				} else {
					$boq_release_pending[] = $boq_code;
				}
			}
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $allCount,
				"recordsFiltered" => $countFiltered,
				"data" => $data,
				'boq_approval_pending' => $boq_release_pending,
			);
			echo json_encode($output);
		}
	}

	public function boq_schbn_list_display_for_bom_release_qty() {
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
			$boq_release_pending = array();
			$boq_without_bom = array();
			$boq_ex_app_pending = array();

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
				// if(isset($member->status) && !empty($member->status) && $status == 'Y') { $status = 'Approved'; }else { $status = 'Not Approved'; }
				if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
				if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }

				$check_stock_details = $this->admin_model->check_stock_details($project_id,$boq_code);
				if(isset($check_stock_details) && !empty($check_stock_details)){

					$released_total_stock = 0;
					$released_pending = 0;
					$released_approved = 0;

					if(isset($check_stock_details->released_approved) && !empty($check_stock_details->released_approved) && $check_stock_details->released_approved > 0){
						$released_approved = $check_stock_details->released_approved;
					}
				} else {
					$released_total_stock = 0;
					$released_pending = 0;
					$released_approved = 0;
				}


				if($design_qty > 0) {
					$avl_release_qty = $design_qty - $released_approved;
				} else{
					$avl_release_qty = 0;
				}

				$bom_subtable_data = $this->get_bom_item_subtable_data_release_qty($project_id,$boq_code,$avl_release_qty);

				$bom_subtable = $bom_subtable_data['bom_data'];
				$count = $bom_subtable_data['count'];

				$html ='';
				$html.='&nbsp;<a href="javascript:;" class="tooltips openBomview" rev="view_bom_items" rel="" project_id="'.$project_id.'" boq_code="'.$boq_code.'" title="" data-original-title="View BOM">Close </a>';
				$html.='&nbsp;&nbsp;<a href="javascript:;" class="delete tooltips delete_bom_qty" rel="" title="" rev="" data-original-title="Delete Role"><i class="fa fa-trash-o" style="color:#a94442; font-size: 15px;"></i></a>';

				$var_qty = 0;
				$var_qty = $design_qty - $scheduled_qty;
				$oprableAmount = 0;
				$oprableAmount = $design_qty * $rate_basic;
				$gst_amount=0;
				if($gst > 0 && $oprableAmount > 0){
					$gst_amount = $oprableAmount * ($gst/100);
				}
				$oprableAmountGST = $gst_amount + $oprableAmount;


				$sr_no_d = '<input type="text" class="form-control invaliderror js-sr_no" name="sr_no[]" id="sr_no" value="'.$i.'" placeholder="Sr.no" style="font-size: 12px;width:100%" readonly>';
				$item_description_d = '<input type="text" class="form-control invaliderror js-item_description" name="item_description[]" value="'.$item_description.'" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>';
				$boq_sr_no_d = '<input type="text" class="form-control invaliderror js-boq_sr_no" name="boq_sr_no[]"  id="boq_sr_no" value="'.$boq_code.'" placeholder="BOQ Sr No" style="font-size: 12px;width:100%" readonly>';

				$unit_d = '<input type="text" class="form-control invaliderror js-unit" name="unit[]" id="unit" value="'.$unit.'" placeholder="Unit" style="font-size: 12px;width:100%" readonly>';
				$scheduled_d = '<input type="text" class="form-control invaliderror js-scheduled_qty" name="scheduled_qty[]"  id="scheduled_qty" value="'.$scheduled_qty.'" placeholder="Sch Qty" style="font-size: 12px;width:100%" readonly>';
				$var_d = '<input type="text" class="form-control invaliderror js-var-qty" name="var_qty[]" id="var_qty" value="'.''.$var_qty.'" placeholder="Variation Qty" style="font-size: 12px;width:100%" readonly>';
				$design_qty_d = '<input type="text" class="form-control invaliderror js-avl_release_qty" name="avl_release_qty[]"  id="var_qty" value="'.'+'.$avl_release_qty.'" placeholder="Avl Relase Qty" style="font-size: 12px;width:100%" readonly>';
				$release_qty_d = '<input type="number" class="form-control invaliderror js-release_qty" name="release_qty[]"  id="release_qty" value="'.$avl_release_qty.'" placeholder="Release Qty" style="font-size: 12px;width:100%">';

				$release_pending = $this->admin_model->check_release_qty_pending($project_id,$boq_code);

				$bom_item_count = $this->admin_model->boq_exceptional_bom_item($project_id,$boq_code);
				$boqExceptional = $this->admin_model->getBOQPendingExceptional($project_id,$boq_code);


				if(empty($release_pending)) {
					if($bom_item_count  > 0 ) {
						if(empty($boqExceptional)) {

							if($avl_release_qty > 0) {

								$data[] = array(
									$sr_no_d,
									$boq_sr_no_d,
									$item_description_d,
									$unit_d,
									$scheduled_d,
									$var_d,
									$design_qty_d,
									$release_qty_d,
									$html,
									'subTableData' => $bom_subtable,
								);
							}
						} else {
							$boq_ex_app_pending[] = $boq_code;
						}
					} else {
						$boq_without_bom[] = $boq_code;
					}
				} else {
					$boq_release_pending[] = $boq_code;
				}


			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $allCount,
				"recordsFiltered" => $countFiltered,
				"data" => $data,
				'boq_approval_pending' => $boq_release_pending,
				'boq_without_bom' => $boq_without_bom,
				'boq_ex_app_pending'=> $boq_ex_app_pending
			);

			echo json_encode($output);

		}
	}


	public function boq_schc_list_display_for_bom_release_qty() {
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
			$boq_release_pending = array();
			$boq_without_bom = array();
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
				// if(isset($member->status) && !empty($member->status) && $status == 'Y') { $status = 'Approved'; }else { $status = 'Not Approved'; }
				if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
				if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
				$oprableAmount = 0;
				$oprableAmount = $design_qty * $rate_basic;
				$gst_amount=0;
				if($gst > 0 && $oprableAmount > 0){
					$gst_amount = $oprableAmount * ($gst/100);
				}
				$oprableAmountGST = $gst_amount + $oprableAmount;

				$check_stock_details = $this->admin_model->check_stock_details($project_id,$boq_code);
				if(isset($check_stock_details) && !empty($check_stock_details)){
					$released_total_stock = 0;
					$released_pending = 0;
					$released_approved = 0;
					if(isset($check_stock_details->released_approved) && !empty($check_stock_details->released_approved) && $check_stock_details->released_approved > 0){
						$released_approved = $check_stock_details->released_approved;
					}
				} else {
					$released_total_stock = 0;
					$released_pending = 0;
					$released_approved = 0;
				}

				if($design_qty > 0) {
					$avl_release_qty = $design_qty - $released_approved;
				} else{
					$avl_release_qty = 0;
				}

				$bom_subtable_data = $this->get_bom_item_subtable_data_release_qty($project_id,$boq_code,$avl_release_qty);

				$bom_subtable = $bom_subtable_data['bom_data'];
				$count        = $bom_subtable_data['count'];

				$html ='';
				$html.='&nbsp;<a href="javascript:;" class="tooltips openBomview" rev="view_bom_items" rel="" project_id="'.$project_id.'" boq_code="'.$boq_code.'" title="" data-original-title="View BOM">Close </a>';
				$sr_no_d = '<input type="text" class="form-control invaliderror js-sr_no" name="sr_no[]" id="sr_no" value="'.$i.'" placeholder="Sr.no" style="font-size: 12px;width:100%" readonly>';
				$item_description_d = '<input type="text" class="form-control invaliderror js-item_description" name="item_description[]" value="'.$item_description.'" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>';
				$boq_sr_no_d = '<input type="text" class="form-control invaliderror js-boq_sr_no" name="boq_sr_no[]"  id="boq_sr_no" value="'.$boq_code.'" placeholder="BOQ Sr No" style="font-size: 12px;width:100%" readonly>';
				$unit_d = '<input type="text" class="form-control invaliderror js-unit" name="unit[]" id="unit" value="'.$unit.'" placeholder="Unit" style="font-size: 12px;width:100%" readonly>';
				$scheduled_d = '<input type="text" class="form-control invaliderror js-scheduled_qty" name="scheduled_qty[]"  id="scheduled_qty" value="'.$scheduled_qty.'" placeholder="Sch Qty" style="font-size: 12px;width:100%" readonly>';
				$design_qty_d = '<input type="text" class="form-control invaliderror js-avl_release_qty" name="avl_release_qty[]"  id="var_qty" value="'.'+'.$avl_release_qty.'" placeholder="Avl Relase Qty" style="font-size: 12px;width:100%" readonly>';
				$release_qty_d = '<input type="number" class="form-control invaliderror js-release_qty" name="release_qty[]"  id="release_qty" value="'.$avl_release_qty.'" placeholder="Release Qty" style="font-size: 12px;width:100%">';

				$release_pending = $this->admin_model->check_release_qty_pending($project_id,$boq_code);
				$bom_item_count = $this->admin_model->boq_exceptional_bom_item($project_id,$boq_code);

				if(empty($release_pending)) {

					if($bom_item_count  > 0 ) {

						if($avl_release_qty > 0) {

							$data[] = array(
								$sr_no_d,
								//$bp_code,
								$boq_sr_no_d,
								$item_description_d,
								$unit_d,
								$design_qty_d,
								$release_qty_d,
								$html,
								'subTableData' => $bom_subtable,

							);
						}

					} else {
						$boq_without_bom[] = $boq_code;
					}

				} else {
					$boq_release_pending[] = $boq_code;
				}
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $allCount,
				"recordsFiltered" => $countFiltered,
				"data" => $data,
				'boq_approval_pending' => $boq_release_pending,
				'boq_without_bom' => $boq_without_bom,
			);
			echo json_encode($output);
		}
	}

	public function release_schedule_a_quantity() {
		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');

		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)) {
			$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_bom_release_stock');
			if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
				$submenu_id = $submenu_data->submenu_id;
				$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);

				if(isset($check_permission) && !empty($check_permission)){

					$project_id = $this->input->post('project_id');
					if(isset($project_id) && !empty($project_id)){
						$project_id = base64_decode($project_id);
					}

					$schedule_a = $this->input->post('schedule_a');
					$type='operable_a_release';
					$memData = $this->admin_model->getBOQOperListRows($_POST,$project_id,$type);

					foreach($memData as $member){
						if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
						$qr_array = array('project_id' =>$project_id,'boq_code'=>$boq_code);
						$bom_items_data = $this->common_model->selectDetailsWhereArrBom('tbl_bom_items',$qr_array);


						if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = ''; }
						if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = ''; }

						$ea_negative_qty = $this->admin_model->check_negative_ea($project_id,$boq_code);

						if($ea_negative_qty > 0) {
							$qty_approved = $design_qty;
						} else {
							$qty_approved = $scheduled_qty;
						}

						if(isset($bom_items_data) && !empty($bom_items_data)) {
							foreach ($bom_items_data as $key => $bom_items) {
								if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }
								if(isset($bom_items->bom_ratio) && !empty($bom_items->bom_ratio)) { $bom_ratio = $bom_items->bom_ratio; }else { $bom_ratio = ''; }

								$bom_stock = $this->admin_model->check_bom_stock_details($project_id, $boq_code, $bom_code);

								if(!empty($bom_stock) && isset($bom_stock)) {

									if(isset($bom_stock->indent_stock) && !empty($bom_stock->indent_stock)) { $bom_indent_stock = $bom_stock->indent_stock; }else { $bom_indent_stock = 0; }
									if(isset($bom_stock->release_stock) && !empty($bom_stock->release_stock)) { $bom_release_stock = $bom_stock->release_stock; }else { $bom_release_stock = 0; }
									if(isset($bom_stock->indent_stock_pending) && !empty($bom_stock->indent_stock_pending)) { $bom_indent_stock_pending = $bom_stock->indent_stock_pending; }else { $bom_indent_stock_pending = 0; }

									$total_bom_release_qty = $qty_approved * $bom_ratio;
									$total_indent_stock = $bom_indent_stock + $total_bom_release_qty;
									$total_reaming      = $bom_release_stock - $total_bom_release_qty;


									$update_stock_arr[] = array(
										'boq_code'=>$boq_code,
										'bom_code'=> $bom_code,
										'indent_stock' => $total_indent_stock,
										'release_stock' => $total_reaming,
										'updated_by'=> $loguser_id,
										'updated_date'=>date('Y-m-d H:i:s')
									);

									$release_stock_arr[] = array(
										'project_id'=>$project_id,
										'boq_code'=>$boq_code,
										'bom_code'=>$bom_code,
										'released_quantity'=> $total_reaming,
										'schedule_type'=> 'A',
										'status'=>'approved',
										'display' => 'Y',
										'created_by'=>$loguser_id,
										'created_on'=>date('Y-m-d H:i:s'),
										'updated_by'=> $loguser_id,
										'updated_date'=>date('Y-m-d H:i:s'),
										'transaction_id'=> 0,
									);
								}
							}

							if(isset($update_stock_arr) && !empty($update_stock_arr)){
								$this->common_model->updateBOMStock($update_stock_arr,$project_id,$boq_code);
							}
						}

						$update_boq_stock_arr = array(
							'released_pending' => 0,
							'released_approved' => $qty_approved,
							'updated_by'=>$loguser_id,
							'updated_date'=>date('Y-m-d H:i:s')
						);

						$boq_release_arr[] = array(
							'project_id'=>$project_id,
							'boq_code'=>$boq_code,
							// 'bom_code'=>$bom_code,
							'released_quantity'=> $qty_approved,
							'status'=>'approved',
							'display' => 'Y',
							'created_by'=>$loguser_id,
							'created_on'=>date('Y-m-d H:i:s'),
							'updated_by'=> $loguser_id,
							'updated_date'=>date('Y-m-d H:i:s'),
							// 'transaction_id'=> $transaction_id,
						);

						if(isset($update_boq_stock_arr) && !empty($update_boq_stock_arr)){
							$this->common_model->updateBOQStockDetails($update_boq_stock_arr,$project_id,$boq_code);
						}
					}


					$event_name = 'Schedule A Release Quantity';
					$BOMTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,
					'event_type'=>'release_qty','created_date'=>date('Y-m-d H:i:s'),'created_by'=>$loguser_id,
					'updated_by'=>$loguser_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'approved');
					$transaction_id = $this->common_model->addData('tbl_bom_transactions',$BOMTransArr);

					if($transaction_id > 0){
						foreach($release_stock_arr as $key => $csm){
							$release_stock_arr[$key]['transaction_id'] = $transaction_id;
						}

						foreach($boq_release_arr as $key => $csm){
							$boq_release_arr[$key]['transaction_id'] = $transaction_id;
						}

						if(isset($release_stock_arr) && !empty($release_stock_arr)){
							$result = $this->common_model->SaveMultiData('tbl_bom_release_stock',$release_stock_arr);
						}

						if(isset($boq_release_arr) && !empty($boq_release_arr)) {
							$this->common_model->SaveMultiData('tbl_boq_release_stock',$boq_release_arr);
						}
					}

					if((isset($update_stock_arr) && !empty($update_stock_arr)) || ($result)){
						$this->json->jsonReturn(array(
							'valid'=>TRUE,
							'msg'=>'<div class="alert modify alert-success">BOM Stock Release Successfully!</div>',
							'redirect' => base_url().'bom-release-quantity',
						));
					} else {
						$this->json->jsonReturn(array(
							'valid'=>FALSE,
							'msg'=>'<div class="alert modify alert-danger">Please Enter Valid BOM Items Details!!</div>'
						));
					}
				} else {
					$this->json->jsonReturn(array(
						'valid'=>FALSE,
						'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
					));
				}
			}
		}

	}

	public function release_schedule_quantity() {

		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)) {
			$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_bom_release_stock');
			if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
				$submenu_id = $submenu_data->submenu_id;
				$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
				if(isset($check_permission) && !empty($check_permission)){

					$project_id = $this->input->post('project_id');
					if(isset($project_id) && !empty($project_id)){
						$project_id = base64_decode($project_id);
					}
					$error = 'N';
					$error_message = '';
					if(isset($loguser_id) && empty($loguser_id)){
						$error = 'Y';
						$error_message = 'Please loggedin!';
					}

					$boq_items = $this->input->post('boq_sr_no');
					if(isset($boq_items) && !empty($boq_items)) { $boq_code = $boq_items; } else { $boq_code=''; }
					if(isset($boq_code) && empty($boq_code)){
						$error = 'Y';
						$error_message = 'BOQ Item is empty!';
					}

					$bom_code = $this->input->post('bom_code');
					if(isset($bom_code) && !empty($bom_code)) { $bom_code = $bom_code; } else { $bom_code=''; }
					if(isset($bom_code) && empty($bom_code)){
						$error = 'Y';
						$error_message = 'BOM Sr No is empty!';
					}

					$release_qty = $this->input->post('release_qty');
					if(isset($release_qty) && !empty($release_qty)) { $release_qty = $release_qty; } else { $release_qty=''; }
					if(isset($release_qty) && empty($release_qty)){
						$error = 'Y';
						$error_message = 'Release Quantity empty!';
					}

					$schedule_type = $this->input->post('schedule_type');
					if(isset($schedule_type) && !empty($schedule_type)) { $schedule_type = $schedule_type; } else { $schedule_type=''; }


					if(isset($boq_code) && empty($boq_code) && isset($bom_code) && empty($bom_code) && isset($release_qty) && empty($release_qty)) {
						$this->json->jsonReturn(
							array(
								'valid'=>FALSE,
								'msg'=>'<div class="alert modify alert-danger">Please Enter Release Quantity!</div>'
							)
						);
					} else {
						for($i=0;$i<count($boq_code);$i++){

							if(isset($boq_code[$i]) && !empty($boq_code[$i])) { $boq_code_s = $boq_code[$i]; } else { $boq_code_s = ''; }
							if(isset($release_qty[$i]) && !empty($release_qty[$i])) { $release_qty_s = $release_qty[$i]; } else { $release_qty_s = ''; }

							$member = $this->admin_model->get_boq_item_details($project_id,$boq_code_s);
							$boq_release_qty_total = $this->admin_model->get_boq_release_qty_count($project_id, $boq_code_s);

							$check_stock_details = $this->admin_model->check_stock_details($project_id,$boq_code_s);

							$total_stock = 0;
							$total_stock_val = 0;
							$dc_total_stock = 0;
							$dc_total_stock_val = 0;
							$dc_stock = 0;
							$dc_stock_val = 0;
							$avl_stock=0;
							$avl_stock_val=0;
							// $avl_released_pending = 0;
							if(isset($check_stock_details) && !empty($check_stock_details)){
								if(isset($check_stock_details->released_approved) && !empty($check_stock_details->released_approved) && $check_stock_details->released_approved > 0){
									$released_approved = $check_stock_details->released_approved;
								}
								if(isset($check_stock_details->released_pending) && !empty($check_stock_details->released_pending) && $check_stock_details->released_pending > 0){
									$released_pending = $check_stock_details->released_pending;
								}

							}

							if(isset($member) && !empty($member)) {

								if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
								if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = '0'; }

								$remaining_qty                = $scheduled_qty - abs($release_qty_s);
								if($boq_release_qty_total <= $scheduled_qty) {
									$avl_qty_for_without_approval = $scheduled_qty - abs($boq_release_qty_total);
								} else {
									$avl_qty_for_without_approval = 0;
								}
								$approval_qty              = $release_qty_s - $avl_qty_for_without_approval;
								$qr_array = array('project_id' =>$project_id,'boq_code'=>$boq_code_s);
								$bom_items_data = $this->common_model->selectDetailsWhereArrBom('tbl_bom_items',$qr_array);

								if(isset($bom_items_data) && !empty($bom_items_data)) {

									foreach ($bom_items_data as $key => $bom_items) {

										if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }
										if(isset($bom_items->design_qty) && !empty($bom_items->design_qty)) { $bom_design_qty = $bom_items->design_qty; }else { $bom_design_qty = ''; }
										if(isset($bom_items->bom_ratio) && !empty($bom_items->bom_ratio)) { $bom_ratio = $bom_items->bom_ratio; }else { $bom_ratio = ''; }


										$check_bom_stock_details = $this->admin_model->check_bom_stock_details($project_id,$boq_code_s,$bom_code);

										$bom_indent_stock = 0;
										$bom_release_stock = 0;
										$bom_indent_stock_pending = 0;

										if(isset($check_bom_stock_details) && !empty($check_bom_stock_details)) {
											if(isset($check_bom_stock_details->indent_stock) && !empty($check_bom_stock_details->indent_stock)) { $bom_indent_stock = $check_bom_stock_details->indent_stock; }else { $bom_indent_stock = 0; }
											if(isset($check_bom_stock_details->release_stock) && !empty($check_bom_stock_details->release_stock)) { $bom_release_stock = $check_bom_stock_details->release_stock; }else { $bom_release_stock = 0; }
											if(isset($check_bom_stock_details->indent_stock_pending) && !empty($check_bom_stock_details->indent_stock_pending)) { $bom_indent_stock_pending = $check_bom_stock_details->indent_stock_pending; }else { $bom_indent_stock_pending = 0; }
										}

										$total_bom_release_qty = $release_qty_s * $bom_ratio;
										$schedule_bom_release_qty = $scheduled_qty * $bom_ratio;
										$schedule_bom_remaining_qty = $remaining_qty * $bom_ratio;

										$approval_qty_total   = $approval_qty * $bom_ratio;
										$without_approval_qty = $avl_qty_for_without_approval * $bom_ratio;

										// $total_bom_release_qty
										if($avl_qty_for_without_approval > 0 && $approval_qty > 0) {

											// $total_indent_stock_pending = $bom_indent_stock + $approval_qty_total;
											$total_indent_stock_pending = $bom_indent_stock_pending + $approval_qty_total;


											$update_stock_arr_approval[] = array(
												'boq_code'=>$boq_code_s,
												'bom_code'=> $bom_code,
												//'indent_stock' => $total_bom_release_qty,
												'indent_stock_pending' =>$total_indent_stock_pending,
												//'release_stock' => $reaming_qty,
												'updated_by'=> $loguser_id,
												'updated_date'=>date('Y-m-d H:i:s')
											);

											$total_indent_stock = $bom_indent_stock + $without_approval_qty;
											$total_reaming      = $bom_release_stock - $without_approval_qty;

											$update_stock_arr[] = array(
												'boq_code'=>$boq_code_s,
												'bom_code'=> $bom_code,
												'indent_stock' => $total_indent_stock,
												'release_stock'=> $total_reaming,
												// 'indent_stock_pending' =>$without_approval_qty,
												//'release_stock' => $reaming_qty,
												'updated_by'=> $loguser_id,
												'updated_date'=>date('Y-m-d H:i:s')
											);

										} else if($approval_qty > 0) {

											$total_indent_stock = $bom_indent_stock_pending + $approval_qty_total;
											// $total_reaming      = $bom_release_stock - $without_approval_qty;

											$update_stock_arr[] = array(
												'boq_code'=>$boq_code_s,
												'bom_code'=> $bom_code,
												'indent_stock_pending' => $total_indent_stock,
												// 'release_stock'=> $total_reaming,
												// 'indent_stock_pending' =>$without_approval_qty,
												//'release_stock' => $reaming_qty,
												'updated_by'=> $loguser_id,
												'updated_date'=>date('Y-m-d H:i:s')
											);
										} else if($approval_qty <= 0) {

											$total_indent_stock = $bom_indent_stock + $total_bom_release_qty;
											$total_reaming      = $bom_release_stock - $total_bom_release_qty;

											$update_stock_arr[] = array(
												'boq_code'=>$boq_code_s,
												'bom_code'=> $bom_code,
												'indent_stock' => $total_indent_stock,
												'release_stock'=> $total_reaming,
												// 'indent_stock_pending' =>$without_approval_qty,
												//'release_stock' => $reaming_qty,
												'updated_by'=> $loguser_id,
												'updated_date'=>date('Y-m-d H:i:s')
											);
										}

										if($avl_qty_for_without_approval > 0 && $approval_qty > 0) {

											$release_stock_arr_approval[] = array(
												'project_id'=>$project_id,
												'boq_code'=>$boq_code_s,
												'bom_code'=>$bom_code,
												'released_quantity'=> $approval_qty_total,
												// 'o_released_quantity'=> $total_bom_release_qty,
												'schedule_type'=> $schedule_type,
												'status'=>'pending',
												'display' => 'Y',
												'created_by'=>$loguser_id,
												'created_on'=>date('Y-m-d H:i:s'),
												'updated_by'=> $loguser_id,
												'updated_date'=>date('Y-m-d H:i:s'),
												// 'transaction_id'=> 0,
											);

											$release_stock_arr[] = array(
												'project_id'=>$project_id,
												'boq_code'=>$boq_code_s,
												'bom_code'=>$bom_code,
												'released_quantity'=> $without_approval_qty,
												// 'o_released_quantity'=> $total_bom_release_qty,
												'schedule_type'=> $schedule_type,
												'status'=>'approved',
												'display' => 'Y',
												'created_by'=>$loguser_id,
												'created_on'=>date('Y-m-d H:i:s'),
												'updated_by'=> $loguser_id,
												'updated_date'=>date('Y-m-d H:i:s'),
												// 'transaction_id'=> 0,
											);
										} else if($approval_qty > 0) {

											$release_stock_arr[] = array(
												'project_id'=>$project_id,
												'boq_code'=>$boq_code_s,
												'bom_code'=>$bom_code,
												'released_quantity'=> $approval_qty_total,
												// 'o_released_quantity'=> $total_bom_release_qty,
												'schedule_type'=> $schedule_type,
												'status'=>'pending',
												'display' => 'Y',
												'created_by'=>$loguser_id,
												'created_on'=>date('Y-m-d H:i:s'),
												'updated_by'=> $loguser_id,
												'updated_date'=>date('Y-m-d H:i:s'),
												// 'transaction_id'=> 0,
											);
										} else if($approval_qty <= 0) {

											$release_stock_arr[] = array(
												'project_id'=>$project_id,
												'boq_code'=>$boq_code_s,
												'bom_code'=>$bom_code,
												'released_quantity'=> $total_bom_release_qty,
												// 'o_released_quantity'=> $total_bom_release_qty,
												'schedule_type'=> $schedule_type,
												'status'=>'approved',
												'display' => 'Y',
												'created_by'=>$loguser_id,
												'created_on'=>date('Y-m-d H:i:s'),
												'updated_by'=> $loguser_id,
												'updated_date'=>date('Y-m-d H:i:s'),
												// 'transaction_id'=> 0,
											);
										}
									}

									if(isset($update_stock_arr) && !empty($update_stock_arr)){
										$this->common_model->updateBOMStock($update_stock_arr,$project_id,$boq_code_s);
									}

									if(isset($update_stock_arr_approval) && !empty($update_stock_arr_approval)){
										$this->common_model->updateBOMStock($update_stock_arr_approval,$project_id,$boq_code_s);
									}
								}
							}

							if ($avl_qty_for_without_approval > 0 && $approval_qty > 0) {

								$total_released_approved = $released_approved + $avl_qty_for_without_approval;
								$total_released_pending = $released_pending + $approval_qty;

								//without approval release
								$update_boq_stock_arr = array(
									'released_approved' => $total_released_approved,
									'updated_by'=>$loguser_id,
									'updated_date'=>date('Y-m-d H:i:s')
								);

								if(isset($update_boq_stock_arr) && !empty($update_boq_stock_arr)){
									$this->common_model->updateBOQStockDetails($update_boq_stock_arr,$project_id,$boq_code_s);
								}

								$boq_release_arr[] = array(
									'project_id'=>$project_id,
									'boq_code'=>$boq_code_s,
									// 'bom_code'=>$bom_code,
									'released_quantity'=> $avl_qty_for_without_approval,
									'status'=>'approved',
									'display' => 'Y',
									'created_by'=>$loguser_id,
									'approved_by'=>$loguser_id,
									'created_on'=>date('Y-m-d H:i:s'),
									'updated_by'=> $loguser_id,
									'updated_date'=>date('Y-m-d H:i:s'),
									// 'transaction_id'=> $transaction_id,
								);


								//neeed approval for more then schedule qty
								$update_boq_stock_arr_approval = array(
									'released_pending' => $total_released_pending,
									'updated_by'=>$loguser_id,
									'updated_date'=>date('Y-m-d H:i:s')
								);

								if(isset($update_boq_stock_arr_approval) && !empty($update_boq_stock_arr_approval)){
									$this->common_model->updateBOQStockDetails($update_boq_stock_arr_approval,$project_id,$boq_code_s);
								}

							} else if($approval_qty > 0) {

								$total_released_pending = $released_pending + $release_qty_s;

								$update_boq_stock_arr = array(
									// 'released_approved' => $total_released_approved,
									'released_pending' => $total_released_pending,
									'updated_by'=> $loguser_id,
									'updated_date'=>date('Y-m-d H:i:s')
								);
								if(isset($update_boq_stock_arr) && !empty($update_boq_stock_arr)){
									$this->common_model->updateBOQStockDetails($update_boq_stock_arr,$project_id,$boq_code_s);
								}

							} else if($approval_qty <= 0) {

								$total_released_approved = $released_approved + $release_qty_s;

								$boq_release_arr[] = array(
									'project_id'=>$project_id,
									'boq_code'=>$boq_code_s,
									// 'bom_code'=>$bom_code,
									'released_quantity'=> $release_qty_s,
									'status'=>'approved',
									'display' => 'Y',
									'created_by'=>$loguser_id,
									'created_on'=>date('Y-m-d H:i:s'),
									'updated_by'=> $loguser_id,
									'updated_date'=>date('Y-m-d H:i:s'),
									// 'transaction_id'=> $transaction_id,
								);

								$update_boq_stock_arr = array(
									'released_approved' => $total_released_approved,
									'updated_by'=>$loguser_id,
									'updated_date'=>date('Y-m-d H:i:s')
								);

								if(isset($update_boq_stock_arr) && !empty($update_boq_stock_arr)){
									$this->common_model->updateBOQStockDetails($update_boq_stock_arr,$project_id,$boq_code_s);
								}
							}
						}
					}


					if ((isset($update_stock_arr) && !empty($update_stock_arr))) {

						$event_name = 'Schedule '.$schedule_type.' Release Quantity';
						$BOMTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,
						'event_type'=>'release_qty','created_date'=>date('Y-m-d H:i:s'),'created_by'=>$loguser_id,
						'updated_by'=>$loguser_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending');
						$transaction_id = $this->common_model->addData('tbl_bom_transactions',$BOMTransArr);

						if($transaction_id > 0){
							foreach($release_stock_arr as $key => $csm){
								$release_stock_arr[$key]['transaction_id'] = $transaction_id;
							}

							if(isset($release_stock_arr_approval)) {
								foreach($release_stock_arr_approval as $key => $csm){
									$release_stock_arr_approval[$key]['transaction_id'] = $transaction_id;
								}
							}

							if(isset($boq_release_arr)) {
								foreach($boq_release_arr  as $key => $csm){
									$boq_release_arr[$key]['transaction_id'] = $transaction_id;
								}
							}

							if(isset($release_stock_arr) && !empty($release_stock_arr)){
								$result = $this->common_model->SaveMultiData('tbl_bom_release_stock',$release_stock_arr);
							}

							if(isset($release_stock_arr_approval) && !empty($release_stock_arr_approval)){
								$result = $this->common_model->SaveMultiData('tbl_bom_release_stock',$release_stock_arr_approval);
							}

							if(isset($boq_release_arr) && !empty($boq_release_arr)){
								$result = $this->common_model->SaveMultiData('tbl_boq_release_stock',$boq_release_arr);
							}


						}

						$this->json->jsonReturn(array(
							'valid'=>TRUE,
							'msg'=>'<div class="alert modify alert-success">BOM Stock Release Successfully!</div>',
							'redirect' => base_url().'bom-release-quantity',
						));
					} else {
						$this->json->jsonReturn(array(
							'valid'=>FALSE,
							'msg'=>'<div class="alert modify alert-danger">Please Enter Valid BOM Items Details!!</div>'
						));
					}
				} else {
					$this->json->jsonReturn(array(
						'valid'=>FALSE,
						'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
					));
				}
			}
		}
	}

	public function release_schedule_b_negative_quantity() {

		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');

		$req_boq_items = $this->input->post('boq_sr_no');
		if(isset($req_boq_items) && !empty($req_boq_items)) { $r_boq_sr_no = $req_boq_items; } else { $req_boq_items = ''; }
		if(isset($r_boq_sr_no) && empty($r_boq_sr_no)){
			$error = 'Y';
			$error_message = 'BOQ Item is empty!';
		}

		if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)) {
			$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_bom_release_stock');
			if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
				$submenu_id = $submenu_data->submenu_id;
				$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);

				if(isset($check_permission) && !empty($check_permission)){

					$project_id = $this->input->post('project_id');
					if(isset($project_id) && !empty($project_id)){
						$project_id = base64_decode($project_id);
					}
					$error = 'N';
					$error_message = '';
					if(isset($loguser_id) && empty($loguser_id)){
						$error = 'Y';
						$error_message = 'Please loggedin!';
					}

					$boq_items = $this->input->post('boq_sr_no');
					if(isset($boq_items) && !empty($boq_items)) { $boq_code = $boq_items; } else { $boq_code=''; }
					if(isset($boq_code) && empty($boq_code)){
						$error = 'Y';
						$error_message = 'BOQ Item is empty!';
					}

					$bom_code = $this->input->post('bom_code');
					if(isset($bom_code) && !empty($bom_code)) { $bom_code = $bom_code; } else { $bom_code=''; }
					if(isset($bom_code) && empty($bom_code)){
						$error = 'Y';
						$error_message = 'BOM Sr No is empty!';
					}

					$release_qty = $this->input->post('release_qty');
					if(isset($release_qty) && !empty($release_qty)) { $release_qty = $release_qty; } else { $release_qty=''; }
					if(isset($release_qty) && empty($release_qty)){
						$error = 'Y';
						$error_message = 'Release Quantity empty!';
					}

					$schedule_type = 'B';
					if(isset($schedule_type) && !empty($schedule_type)) { $schedule_type = $schedule_type; } else { $schedule_type=''; }

					if(isset($boq_code) && empty($boq_code) && isset($bom_code) && empty($bom_code) && isset($release_qty) && empty($release_qty)) {
						$this->json->jsonReturn(
							array(
								'valid'=>FALSE,
								'msg'=>'<div class="alert modify alert-danger">Please Enter Release Quantity!</div>'
							)
						);
					} else {

						for($i=0;$i<count($boq_code);$i++){

							if(isset($boq_code[$i]) && !empty($boq_code[$i])) { $boq_code_s = $boq_code[$i]; } else { $boq_code_s = ''; }
							if(isset($release_qty[$i]) && !empty($release_qty[$i])) { $release_qty_s = $release_qty[$i]; } else { $release_qty_s = ''; }

							$member = $this->admin_model->get_boq_item_details($project_id,$boq_code_s);

							$check_stock_details = $this->admin_model->check_stock_details($project_id,$boq_code_s);

							$total_stock = 0;
							$total_stock_val = 0;
							$dc_total_stock = 0;
							$dc_total_stock_val = 0;
							$dc_stock = 0;
							$dc_stock_val = 0;
							$avl_stock=0;
							$avl_stock_val=0;
							// $avl_released_pending = 0;
							if(isset($check_stock_details) && !empty($check_stock_details)){
								if(isset($check_stock_details->released_approved) && !empty($check_stock_details->released_approved) && $check_stock_details->released_approved > 0){
									$released_approved = $check_stock_details->released_approved;
								}
								if(isset($check_stock_details->released_pending) && !empty($check_stock_details->released_pending) && $check_stock_details->released_pending > 0){
									$released_pending = $check_stock_details->released_pending;
								}

							}

							if(isset($member) && !empty($member)) {

								if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
								if(isset($member->scheduled_qty) && !empty($member->scheduled_qty)) { $scheduled_qty = $member->scheduled_qty; }else { $scheduled_qty = '0'; }
								$qr_array = array('project_id' =>$project_id,'boq_code'=>$boq_code_s);
								$bom_items_data = $this->common_model->selectDetailsWhereArrBom('tbl_bom_items',$qr_array);

								if(isset($bom_items_data) && !empty($bom_items_data)) {

									foreach ($bom_items_data as $key => $bom_items) {

										if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }
										if(isset($bom_items->design_qty) && !empty($bom_items->design_qty)) { $bom_design_qty = $bom_items->design_qty; }else { $bom_design_qty = ''; }
										if(isset($bom_items->bom_ratio) && !empty($bom_items->bom_ratio)) { $bom_ratio = $bom_items->bom_ratio; }else { $bom_ratio = ''; }


										$check_bom_stock_details = $this->admin_model->check_bom_stock_details($project_id,$boq_code_s,$bom_code);

										$bom_indent_stock = 0;
										$bom_release_stock = 0;
										$bom_indent_stock_pending = 0;

										if(isset($check_bom_stock_details) && !empty($check_bom_stock_details)) {
											if(isset($check_bom_stock_details->indent_stock) && !empty($check_bom_stock_details->indent_stock)) { $bom_indent_stock = $check_bom_stock_details->indent_stock; }else { $bom_indent_stock = 0; }
											if(isset($check_bom_stock_details->release_stock) && !empty($check_bom_stock_details->release_stock)) { $bom_release_stock = $check_bom_stock_details->release_stock; }else { $bom_release_stock = 0; }
											if(isset($check_bom_stock_details->indent_stock_pending) && !empty($check_bom_stock_details->indent_stock_pending)) { $bom_indent_stock_pending = $check_bom_stock_details->indent_stock_pending; }else { $bom_indent_stock_pending = 0; }
										}

										$total_bom_release_qty = $release_qty_s * $bom_ratio;

										$total_indent_stock = $bom_indent_stock + $total_bom_release_qty;
										$total_reaming      = $bom_release_stock - $total_bom_release_qty;

										$update_stock_arr[] = array(
											'boq_code'=>$boq_code_s,
											'bom_code'=> $bom_code,
											'indent_stock' => $total_indent_stock,
											'release_stock'=> $total_reaming,
											'updated_by'=> $loguser_id,
											'updated_date'=>date('Y-m-d H:i:s')
										);

										$release_stock_arr[] = array(
											'project_id'=>$project_id,
											'boq_code'=>$boq_code_s,
											'bom_code'=>$bom_code,
											'released_quantity'=> $total_bom_release_qty,
											'schedule_type'=> $schedule_type,
											'status'=>'approved',
											'display' => 'Y',
											'created_by'=>$loguser_id,
											'created_on'=>date('Y-m-d H:i:s'),
											'updated_by'=> $loguser_id,
											'updated_date'=>date('Y-m-d H:i:s'),
											// 'transaction_id'=> 0,
										);
									}

									if(isset($update_stock_arr) && !empty($update_stock_arr)){
										$this->common_model->updateBOMStock($update_stock_arr,$project_id,$boq_code_s);
									}
								}
							}


							$total_released_approved = $released_approved + $release_qty_s;
							// $total_released_pending = $released_pending + $approval_qty;

							//without approval release
							$update_boq_stock_arr = array(
								'released_approved' => $total_released_approved,
								'updated_by'=>$loguser_id,
								'updated_date'=>date('Y-m-d H:i:s')
							);

							if(isset($update_boq_stock_arr) && !empty($update_boq_stock_arr)){
								$this->common_model->updateBOQStockDetails($update_boq_stock_arr,$project_id,$boq_code_s);
							}

							$boq_release_arr[] = array(
								'project_id'=>$project_id,
								'boq_code'=>$boq_code_s,
								// 'bom_code'=>$bom_code,
								'released_quantity'=> $release_qty_s,
								'status'=>'approved',
								'display' => 'Y',
								'created_by'=>$loguser_id,
								'approved_by'=>$loguser_id,
								'created_on'=>date('Y-m-d H:i:s'),
								'updated_by'=> $loguser_id,
								'updated_date'=>date('Y-m-d H:i:s'),
								// 'transaction_id'=> $transaction_id,
							);


							if(isset($update_boq_stock_arr_approval) && !empty($update_boq_stock_arr_approval)){
								$this->common_model->updateBOQStockDetails($update_boq_stock_arr_approval,$project_id,$boq_code_s);
							}
						}

					}

					if ((isset($update_stock_arr) && !empty($update_stock_arr))) {

						$event_name = 'Schedule B Negative Release Quantity';
						$BOMTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,
						'event_type'=>'release_qty','created_date'=>date('Y-m-d H:i:s'),'created_by'=>$loguser_id,
						'updated_by'=>$loguser_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'approved');
						$transaction_id = $this->common_model->addData('tbl_bom_transactions',$BOMTransArr);

						if($transaction_id > 0){
							foreach($release_stock_arr as $key => $csm){
								$release_stock_arr[$key]['transaction_id'] = $transaction_id;
							}

							if(isset($boq_release_arr)) {
								foreach($boq_release_arr  as $key => $csm){
									$boq_release_arr[$key]['transaction_id'] = $transaction_id;
								}
							}


							if(isset($release_stock_arr) && !empty($release_stock_arr)){
								$result = $this->common_model->SaveMultiData('tbl_bom_release_stock',$release_stock_arr);
							}

							if(isset($boq_release_arr) && !empty($boq_release_arr)){
								$result = $this->common_model->SaveMultiData('tbl_boq_release_stock',$boq_release_arr);
							}
						}

						$this->json->jsonReturn(array(
							'valid'=>TRUE,
							'msg'=>'<div class="alert modify alert-success">BOM Stock Release Successfully!</div>',
							'redirect' => base_url().'bom-release-quantity',
						));
					} else {
						$this->json->jsonReturn(array(
							'valid'=>FALSE,
							'msg'=>'<div class="alert modify alert-danger">Please Enter Valid BOM Items Details!!</div>'
						));
					}

				} else {
					$this->json->jsonReturn(array(
						'valid'=>FALSE,
						'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
					));
				}
			}
		}
	}
	public function project_bom_boq_release_item_list() {
		$projectId = $_GET['project_id'];
		if(isset($projectId) && !empty($projectId)){
			$project_id =$projectId;
		}else{
			$project_id = null;
		}

		// $user_id = $this->session->userData('user_id');
		$loguser_id = $this->session->userData('user_id');
		$logrole_id = $this->session->userData('role_id');
		if(isset($loguser_id) && !empty($loguser_id)){

			$check_permission_edit = 'N';
			if(isset($loguser_id) && !empty($loguser_id) && isset($loguser_id) && !empty($loguser_id)){
				$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_bom_release_stock');
				if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
					$submenu_id = $submenu_data->submenu_id;
					$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
					if(isset($check_permission) && !empty($check_permission)){
						$check_permission_edit = 'Y';
					}
				}
			}

			$data = $row = array();
			$memData = $this->admin_model->getBOMBOQReleaseListRows($_POST,$project_id);
			$allCount = $this->admin_model->countBOMBOQReleaseListAll();
			$countFiltered = $this->admin_model->countBOMBOQReleaseListFiltered($_POST,$projectId);
			$i = $_POST['start'];

			$unique_sub_data = [];
			foreach($memData as $member){
				$i++;
				if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $boq_items_id = $member->boq_items_id; }else { $boq_items_id = '0'; }
				if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
				if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
				if(isset($member->item_description) && !empty($member->item_description)) { $item_description =$member->item_description;}else { $item_description = '-'; }
				if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $hsn_sac_code =$member->hsn_sac_code;}else { $hsn_sac_code = '-'; }
				if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '-'; }
				if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = 'N'; }
				if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
				if(isset($member->transaction_id) && !empty($member->transaction_id)) { $transaction_id = $member->transaction_id; }else { $transaction_id = ''; }

				$member_stock = $this->admin_model->check_stock_details($project_id,$boq_code);
				$boq_release_stock = $this->common_model->get_boq_release_stock_data($project_id,$boq_code);
				if(isset($boq_release_stock->released_quantity) && !empty($boq_release_stock->released_quantity)) { $boq_released_quantity = $boq_release_stock->released_quantity; }else { $boq_released_quantity = ''; }


				$released_pending = 0;
				$released_approved = 0;
				if(isset($member_stock) && !empty($member_stock)) {
					if((isset($member_stock->released_pending) && !empty($member_stock->released_pending) && $member->status=='pending') || $member->status=='reject') {
						$released_pending = $member_stock->released_pending; }else { $released_pending = '0';
						}
						if(isset($member_stock->released_approved) && !empty($member_stock->released_approved) && $member->status=='approved') {
							$released_approved = $member_stock->released_approved; }else { $released_approved = '0';
							}
						}


						$qr_array = array('project_id' =>$project_id,'boq_code'=>$boq_code);
						$bom_items_data = $this->common_model->selectDetailsWhereArrBom('tbl_bom_items',$qr_array);

						$bom_data = array();
						if(isset($bom_items_data) && !empty($bom_items_data)){
							$unique_sub_arr = [];
							foreach ($bom_items_data as $key => $bom_items) {

								if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }
								if(isset($bom_items->hsn_sac_code) && !empty($bom_items->hsn_sac_code)) { $bom_hsn_sac_code = $bom_items->hsn_sac_code; }else { $bom_hsn_sac_code = ''; }
								if(isset($bom_items->item_description) && !empty($bom_items->item_description)) { $bom_item_description = $bom_items->item_description; }else { $bom_item_description = ''; }
								if(isset($bom_items->unit) && !empty($bom_items->unit)) { $bom_unit = $bom_items->unit; }else { $bom_unit = ''; }
								if(isset($bom_items->rate_basic) && !empty($bom_items->rate_basic)) { $bom_rate_basic = $bom_items->rate_basic; }else { $bom_rate_basic = ''; }
								if(isset($bom_items->gst) && !empty($bom_items->gst)) { $bom_gst = $bom_items->gst; }else { $bom_gst = ''; }

								if(isset($bom_items->make) && !empty($bom_items->make)) { $make = $bom_items->make; }else { $make = ''; }
								if(isset($bom_items->model) && !empty($bom_items->model)) { $model = $bom_items->model; }else { $model = ''; }

								$bom_release_stock = $this->common_model->get_bom_release_stock_data($project_id, $boq_code, $bom_code);

								$released_bom_pending = 0;
								$released_bom_approved = 0;
								if(isset($bom_release_stock->released_quantity) && !empty($bom_release_stock->released_quantity)) {
									$released_quantity = $bom_release_stock->released_quantity; }else { $released_quantity = '';
									}

									if($bom_release_stock->status == 'pending' || $member->status=='reject') {
										$released_bom_pending = $released_quantity;
									} else {
										$released_bom_approved = $released_quantity;
									}

									$html_d ="";
									$html_d.='<a href="javascript:;" class="delete tooltips " rel="" title="" rev="delete_boq_details" data-original-title="Delete Role"><i class="fa fa-trash-o" style="color:#a94442; font-size: 15px;"></i></a>';

									if($bom_gst > 0){
										$total_amount = ($bom_rate_basic * $released_quantity);
										$gst_amount=0;
										if($total_amount > 0 && $bom_gst > 0){
											$gst_amount =  $total_amount * ($bom_gst/100);
										}
										$final_amount = $total_amount + $gst_amount;
									} else {
										$final_amount = 0;
									}
									if(!in_array($bom_code,$unique_sub_arr)){
										array_push($unique_sub_arr,$bom_code);
										$bom_data[] = array(
											$bom_code,
											$bom_hsn_sac_code,
											$bom_item_description,
											$make,
											$model,
											$bom_unit,
											$released_bom_pending,
											$released_bom_approved,
											$bom_rate_basic,
											$bom_gst,
											sprintf('%0.2f', $final_amount),
										);
									}
								}
							}

							$action_status='';
							if($status == 'approved'){
								$action_status .='<span style="color:green;font-weight:600;">Approved</span>';
							} else if($status == 'pending'){
								$action_status .='<span style="color:orange;font-weight:600;">Pending</span>';
							} else if($status == 'reject'){
								$action_status .='<span style="color:red;font-weight:600;">Rejected</span>';
							}

							$html = '';
							$html.= '&nbsp;<a href="javascript:;" class="tooltips openBomview" rev="view_bom_items" rel="" project_id="'.$project_id.'" boq_code="'.$boq_code.'" title="" data-original-title="Delete Role">Close </a>';
							if($status =='reject'){
								if($check_permission_edit == 'Y'){
									$html .= '&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="editBomReleaseRecord tooltips" title="Edit Record" rev="edit_bom_release_items" data-project_id="'.$project_id.'" data-boq_code="'.$boq_code.'" data-transaction_id="'.$transaction_id.'" data-original-title="Edit Bom Record"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';
								}
							}
							if(!in_array($boq_code,$unique_sub_data)){
								array_push($unique_sub_data,$boq_code);
								$data[] = array(
									$i,
									$boq_code,
									$bp_code,
									$hsn_sac_code,
									$item_description,
									$unit,
									$released_pending,
									$boq_released_quantity,
									$action_status,
									$html,
									'subTableData' => $bom_data,
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

				public function get_bom_indent_item_by_project() {

					$project_idpost = $this->input->post('project_id');
					if(isset($project_idpost) && !empty($project_idpost)){
						$project_id = $project_idpost;
					}else{
						$project_id = 0;
					}

					$user_id = $this->session->userData('user_id');
					if(isset($user_id) && !empty($user_id)){
						$data = $new_entry_arr = array();
						$memData = $this->admin_model->getBOMIndentItemListRows($_POST,$project_id);
						$allCount = count($memData);
						$countFiltered = count($memData);

						$i = $_POST['start'];
						$indent_approval_pending = array();
						$unique_arr = [];
						foreach($memData as $member){
							if(!in_array($member->bom_code,$unique_arr)){
								array_push($unique_arr,$member->bom_code);
								$i++;
								if(isset($member->bom_code) && !empty($member->bom_code)) { $bom_code = $member->bom_code; }else { $bom_code = 0; }
								if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = 0; }
								if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
								if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = ''; }
								if(isset($member->unit) && !empty($member->unit)) { $make = $member->make; }else { $make = ''; }
								if(isset($member->model) && !empty($member->model)) { $model = $member->model; }else { $model = ''; }
								if(isset($member->indent_stock) && !empty($member->indent_stock)) { $indent_stock = $member->indent_stock; }else { $indent_stock = ''; }


								$bom_indent_pending = $this->admin_model->check_bom_indent_pending($project_idpost, $boq_code, $bom_code);

								$sr_no_d = '<input type="text" class="form-control invaliderror"  name="sr_no[]" value="'. $i.'" placeholder="Sr.No" style="font-size: 12px;width:100%" readonly>';
								$bom_sr_d = '<input type="hidden" class="js-req_qty"  name="req_qty[]" value="'.$indent_stock.'" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>';
								$bom_sr_d .= '<input type="hidden" class="js-boq_code"  name="boq_code[]" value="'.$boq_code.'" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>
								<input type="text" class="form-control invaliderror js-bom_sr_no"  name="bom_code[]" value="'.$bom_code.'" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>';
								$bom_item_d = '<input type="text" class="form-control invaliderror"  name="bom_item_description[]" value="'.$item_description.'" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>';

								$bom_unit_d = '<input type="text" class="form-control invaliderror"  name="bom_unit[]" value="'.$unit.'" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>';
								$bom_make_d = '<input type="text" class="form-control invaliderror"  name="bom_make[]" value="'.$make.'" placeholder="Make" style="font-size: 12px;width:100%" readonly>';
								$bom_model_d = '<input type="text" class="form-control invaliderror"  name="bom_model[]" value="'.$model.'" placeholder="Model" style="font-size: 12px;width:100%" readonly>';
								$bom_indent_d = '<input type="text" class="form-control invaliderror"  name="bom_avl_stock[]" value="'.$indent_stock.'" placeholder="Available Qty" style="font-size: 12px;width:100%" readonly>';
								$bom_required_d = '<input type="text" class="form-control invaliderror js-required-qty js-required-qty-indent" id="js-required-qty" name="bom_req_stock[]" value="'.$indent_stock.'" placeholder="Required Qty" style="font-size: 12px;width:100%">';
								$action_d ='<div class="addDeleteButton"><span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span></div>';

								if($bom_indent_pending <= 0 ) {
									$data[] = array(
										$sr_no_d,
										$bom_sr_d,
										$bom_item_d,
										$bom_unit_d,
										$bom_make_d,
										$bom_model_d,
										$bom_indent_d,
										$bom_required_d,
										$action_d
									);

								} else {
									$indent_approval_pending[] = $bom_code;
								}
							}
						}

						$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $allCount,
							"recordsFiltered" => $countFiltered,
							"data" => $data,
							'indent_approval_pending' => $indent_approval_pending

						);

						echo json_encode($output);

					}
				}

				public function save_indent_request() {
					$loguser_id = $this->session->userData('user_id');
					$logrole_id = $this->session->userData('role_id');

					if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)) {
						$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_indent_stock');
						if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
							$submenu_id = $submenu_data->submenu_id;
							$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
							if(isset($check_permission) && !empty($check_permission)){

								$project_id = $this->input->post('project_id');

								$error = 'N';
								$error_message = '';
								if(isset($loguser_id) && empty($loguser_id)){
									$error = 'Y';
									$error_message = 'Please loggedin!';
								}

								$bom_code = $this->input->post('bom_code');
								if(isset($bom_code) && !empty($bom_code)) { $bom_code = $bom_code; } else { $bom_code=''; }
								if(isset($bom_code) && empty($bom_code)){
									$error = 'Y';
									$error_message = 'BOM Sr No is empty!';
								}

								$release_qty = $this->input->post('bom_req_stock');
								if(isset($release_qty) && !empty($release_qty)) { $release_qty = $release_qty; } else { $release_qty=''; }
								if(isset($release_qty) && empty($release_qty)){
									$error = 'Y';
									$error_message = 'Required Quantity empty!';
								}

								$boq_code = $this->input->post('boq_code');
								if(isset($boq_code) && !empty($boq_code)) { $boq_code = $boq_code; } else { $boq_code=''; }

								if(isset($boq_code) && empty($boq_code) && isset($bom_code) && empty($bom_code) && isset($release_qty) && empty($release_qty)) {

									$this->json->jsonReturn(
										array(
											'valid'=>FALSE,
											'msg'=>'<div class="alert modify alert-danger">Please Enter Required Qty Details !</div>'
										)
									);
								} else {
									for($i=0;$i<count($bom_code);$i++){

										if(isset($boq_code[$i]) && !empty($boq_code[$i])) { $boq_code_s = $boq_code[$i]; } else { $boq_code_s = ''; }
										if(isset($release_qty[$i]) && !empty($release_qty[$i])) { $release_qty_s = $release_qty[$i]; } else { $release_qty_s = ''; }
										if(isset($bom_code[$i]) && !empty($bom_code[$i])) { $bom_code_s = $bom_code[$i]; } else { $bom_code_s = ''; }


										$indent_stock_arr[] = array(
											'project_id'=>$project_id,
											'boq_code'=>$boq_code_s,
											'bom_code'=>$bom_code_s,
											'indent_quantity'=> $release_qty_s,
											'status'=>'pending',
											'display' => 'Y',
											'created_by'=>$loguser_id,
											'created_on'=>date('Y-m-d H:i:s'),
											'updated_by'=> $loguser_id,
											'updated_date'=>date('Y-m-d H:i:s'),
											// 'transaction_id'=> 0,
										);

									}
								}

								if((isset($indent_stock_arr) && !empty($indent_stock_arr))){
									$event_name = 'Indent Request';
									$BOMTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,
									'event_type'=>'indent_request','created_date'=>date('Y-m-d H:i:s'),'created_by'=>$loguser_id,
									'updated_by'=>$loguser_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending');
									$transaction_id = $this->common_model->addData('tbl_bom_transactions',$BOMTransArr);

									if($transaction_id > 0){
										foreach($indent_stock_arr as $key => $csm){
											$indent_stock_arr[$key]['transaction_id'] = $transaction_id;
										}


										if(isset($indent_stock_arr) && !empty($indent_stock_arr)){
											$result = $this->common_model->SaveMultiData('tbl_bom_indent_stock',$indent_stock_arr);
										}
									}
									$this->json->jsonReturn(array(
										'valid'=>TRUE,
										'msg'=>'<div class="alert modify alert-success">Indent Request send Successfully!</div>',
										'redirect' => base_url().'bom-indent-request',
									));
								} else {
									$this->json->jsonReturn(array(
										'valid'=>FALSE,
										'msg'=>'<div class="alert modify alert-danger">Please Enter Valid BOM Items Details!!</div>'
									));
								}
							} else {
								$this->json->jsonReturn(array(
									'valid'=>FALSE,
									'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
								));
							}
						}
					}
				}


				public function approve_indent_request() {

					$save_stock_arr = $update_stock_arr = $save_exceptional_arr = array();
					$loguser_id = $this->session->userData('user_id');
					$logrole_id = $this->session->userData('role_id');
					if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
						$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_indent_stock');
						if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
							$submenu_id = $submenu_data->submenu_id;
							$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
							if(isset($check_permission) && !empty($check_permission)){

								$project_id = $this->input->post('project_id');
								$boq_code = $this->input->post('boq_code');
								$a_status = $this->input->post('status');
								$transaction_id = $this->input->post('id');

								if(isset($project_id) && !empty($project_id)){
									$project_id = base64_decode($project_id);
								}
								$qr_array = array('project_id' =>$project_id,'transaction_id' => $transaction_id);
								$bom_items_data = $this->common_model->selectDetailsWhereArr('tbl_bom_indent_stock',$qr_array);

								if(isset($bom_items_data) && !empty($bom_items_data)){
									foreach ($bom_items_data as $key => $bom_items) {
										if(isset($bom_items->status) && !empty($bom_items->status) && $bom_items->status !='approved'){
											if(isset($bom_items->indent_id) && !empty($bom_items->indent_id)) { $indent_id = $bom_items->indent_id; }else { $indent_id = 0; }
											if(isset($bom_items->project_id) && !empty($bom_items->project_id)) { $project_id = $bom_items->project_id; }else { $project_id = 0; }
											if(isset($bom_items->boq_code) && !empty($bom_items->boq_code)) { $boq_code = $bom_items->boq_code; }else { $boq_code = ''; }
											if(isset($bom_items->indent_quantity) && !empty($bom_items->indent_quantity)) { $indent_quantity = $bom_items->indent_quantity; }else { $indent_quantity = ''; }
											if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }


											if(isset($bom_items->transaction_id) && !empty($bom_items->transaction_id)) { $transaction_id = $bom_items->transaction_id; }else { $transaction_id = 0; }
											$check_bom_stock_details = $this->admin_model->check_bom_stock_details($bom_items->project_id, $boq_code, $bom_items->bom_code);

											$db_total_stock = 0;
											$db_release_stock = 0;
											$db_dc_total_stock = 0;
											$db_dc_stock = 0;

											if(isset($check_bom_stock_details) && !empty($check_bom_stock_details)) {

												$indent_stock = $check_bom_stock_details->indent_stock;
												$pending_indent_stock = $indent_stock - abs($indent_quantity);

												$update_stock_arr[] = array(
													'boq_code'=>$boq_code,
													'bom_code'=>$bom_code,
													// 'release_stock'=> $update_qty,
													'indent_stock'=> $pending_indent_stock,
													'updated_by'=>$loguser_id,
													'updated_date'=>date('Y-m-d H:i:s')
												);
											}

											if($a_status =='approved') {

												$data = array('status'=>'approved','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
												$this->common_model->updateDetails('tbl_bom_indent_stock','indent_id',$indent_id,$data);

												if(isset($update_stock_arr) && !empty($update_stock_arr)){
													$this->common_model->updateBOMStock($update_stock_arr,$project_id,$boq_code);
												}
											} else {
												$data = array('status'=>'reject','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
												$this->common_model->updateDetails('tbl_bom_indent_stock','	indent_id',$indent_id,$data);
											}
										}
									}

									if($a_status =='approved') {
										if(isset($transaction_id) && !empty($transaction_id) && $transaction_id > 0){
											$dataTrans = array('status'=>'approved','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
											$this->common_model->updateDetails('tbl_bom_transactions','id',$transaction_id,$dataTrans);
										}
									} else {
										if(isset($transaction_id) && !empty($transaction_id) && $transaction_id > 0){
											$dataTrans = array('status'=>'reject','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
											$this->common_model->updateDetails('tbl_bom_transactions','id',$transaction_id,$dataTrans);
										}
									}
									$this->json->jsonReturn(array(
										'valid'=>TRUE,
										'msg'=>'<div class="alert modify alert-success">Indent Request Approved Successfully!</div>'
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

				public function get_indent_request_list() {

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
							$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_indent_stock');
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
							$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_indent_request');
							if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
								$submenu_id = $submenu_data->submenu_id;
								$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
								if(isset($check_permission) && !empty($check_permission)){
									$check_permission_edit = 'Y';
								}
							}
						}

						$data = $row = array();
						$memData = $this->admin_model->getBOMTransactionIndentListRows($_POST,$project_idpost,'indent_request');
						$allCount = $this->admin_model->getBOMTransactionIndentListAll($project_idpost,'indent_request');
						$countFiltered = $this->admin_model->getBOMTransactionIndentFiltered($_POST,$project_idpost,'indent_request');

						$i = $_POST['start'];
						foreach($memData as $member){
							$i++;
							if(isset($member->id) && !empty($member->id)) { $id = $member->id; }else { $id = '0'; }
							if(isset($member->event_name) && !empty($member->event_name)) { $event_name = $member->event_name; }else { $event_name = '-'; }
							if(isset($member->event_type) && !empty($member->event_type)) { $event_type = $member->event_type; }else { $event_type = '-'; }
							if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
							if(isset($member->created_date) && !empty($member->created_date)) { $created_at = $member->created_date; }else { $created_at = '-'; }
							if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = '-'; }
							if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '-'; }
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
							$action = '';
							$action .='<a class="openview" href="javascript:void(0);" data-project_id="'.base64_encode($project_id).'" data-boq_code="" data-type="'.$event_type.'" data-status="'.$status.'"  data-id="'.$id.'">VIEW</a>';
							if($status =='pending'){

							}elseif($status =='reject'){
								if($check_permission_edit == 'Y'){
									$action .='<a href="javascript:;" class="editRecordIndent tooltips" rel="'.$id.'" data-project-id="'.$project_id.'" title="Edit Record" rev="edit_indent_request" data-original-title="Edit Record"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';
								}
							}
							$data[] = array(
								$i,
								$event_name,
								$bp_code,
								'-',
								$created_by_name,
								$approved_by_name,
								$action_status,
								$created_at,
								$action
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


				public function edit_indent_request() {
					$loguser_id = $this->session->userData('user_id');
					$logrole_id = $this->session->userData('role_id');

					if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
						$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_indent_request');
						if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
							$submenu_id = $submenu_data->submenu_id;
							$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
							if(isset($check_permission) && !empty($check_permission)){
								$check_permission_update = 'N';
								$submenu_datau=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_indent_stock');
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

					$project_id_post = $this->input->post('project_id');
					$id_post = $this->input->post('id');
					if(!empty($project_id_post) && isset($project_id_post) && !empty($id_post) && isset($id_post)) {
						$qr_array = array('project_id' =>$project_id_post,'transaction_id' =>$id_post);
						$bom_items_data = $this->admin_model->getBOMIndentEditItemListRows($_POST,$project_id_post, $id_post);
						// $bom_items_data = $this->common_model->selectDetailsWhereArrBom('tbl_bom_indent_stock',$qr_array);
						$project_data=$this->common_model->selectDetailsWhr('tbl_projects','project_id',$project_id_post);
						$data = array();
						$data['check_permission_update'] = $check_permission_update;
						$data['bom_items_data'] = $bom_items_data;
						$data['project_data'] = $project_data;
						// $data['boq_code'] = $boq_code_post;
						$data['project_id'] = $project_id_post;
					} else {
						$data = array();
					}

					$this->load->view('indent-request',$data);

				}
				public function save_edit_indent_item() {
					$loguser_id = $this->session->userData('user_id');
					$logrole_id = $this->session->userData('role_id');

					if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)) {
						$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_indent_stock');
						if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
							$submenu_id = $submenu_data->submenu_id;
							$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
							if(isset($check_permission) && !empty($check_permission)){

								$project_id = $this->input->post('project_id');

								$error = 'N';
								$error_message = '';
								if(isset($loguser_id) && empty($loguser_id)){
									$error = 'Y';
									$error_message = 'Please loggedin!';
								}

								$bom_code = $this->input->post('bom_code');
								if(isset($bom_code) && !empty($bom_code)) { $bom_code = $bom_code; } else { $bom_code=''; }
								if(isset($bom_code) && empty($bom_code)){
									$error = 'Y';
									$error_message = 'BOM Sr No is empty!';
								}

								$release_qty = $this->input->post('bom_req_stock');
								if(isset($release_qty) && !empty($release_qty)) { $release_qty = $release_qty; } else { $release_qty=''; }
								if(isset($release_qty) && empty($release_qty)){
									$error = 'Y';
									$error_message = 'Required Quantity empty!';
								}

								$release_qty = $this->input->post('bom_req_stock');
								if(isset($release_qty) && !empty($release_qty)) { $release_qty = $release_qty; } else { $release_qty=''; }

								$boq_code = $this->input->post('boq_code');
								if(isset($boq_code) && !empty($boq_code)) { $boq_code = $boq_code; } else { $boq_code=''; }

								$transaction_id = $this->input->post('transaction_id');
								if(isset($transaction_id) && !empty($transaction_id)) { $transaction_id = $transaction_id; } else { $transaction_id=''; }

								if(isset($boq_code) && empty($boq_code) && isset($bom_code) && empty($bom_code) && isset($release_qty) && empty($release_qty)) {

									$this->json->jsonReturn(
										array(
											'valid'=>FALSE,
											'msg'=>'<div class="alert modify alert-danger">Please Enter Required Qty Details !</div>'
										)
									);
								} else {

									for($i=0;$i<count($bom_code);$i++){
										if(isset($boq_code[$i]) && !empty($boq_code[$i])) { $boq_code_s = $boq_code[$i]; } else { $boq_code_s = ''; }
										if(isset($release_qty[$i]) && !empty($release_qty[$i])) { $release_qty_s = $release_qty[$i]; } else { $release_qty_s = ''; }
										if(isset($bom_code[$i]) && !empty($bom_code[$i])) { $bom_code_s = $bom_code[$i]; } else { $bom_code_s = ''; }

										$qr_array = array('project_id' =>$project_id,'boq_code'=>$boq_code_s,'bom_code'=>$bom_code_s,'transaction_id' => $transaction_id);
										$bom_items_data=$this->common_model->selectDetailsWhereArrBom('tbl_bom_indent_stock',$qr_array);

										foreach($bom_items_data as $key => $item) {
											if(isset($item->indent_id) && !empty($item->indent_id)) { $indent_id_s = $item->indent_id; } else { $indent_id_s = ''; }
											$indent_stock_arr = array(
												// 'project_id'=>$project_id,
												// 'boq_code'=>$boq_code_s,
												// 'bom_code'=>$bom_code_s,
												'indent_quantity'=> $release_qty_s,
												'status'=>'pending',
												'display' => 'Y',
												// 'created_by'=>$loguser_id,
												// 'created_on'=>date('Y-m-d H:i:s'),
												'updated_by'=> $loguser_id,
												'updated_date'=>date('Y-m-d H:i:s'),
												// 'transaction_id'=> 0,
											);
											$this->common_model->updateDetails('tbl_bom_indent_stock','indent_id',$indent_id_s,$indent_stock_arr);
										}
									}
								}

								if((isset($indent_stock_arr) && !empty($indent_stock_arr))){
									if(isset($transaction_id) && !empty($transaction_id) && $transaction_id > 0){
										$dataTrans = array('status'=>'pending','updated_by'=>$loguser_id,'updated_date'=>date('Y-m-d H:i:s'));
										$this->common_model->updateDetails('tbl_bom_transactions','id',$transaction_id,$dataTrans);
									}

									$this->json->jsonReturn(array(
										'valid'=>TRUE,
										'msg'=>'<div class="alert modify alert-success">Indent Request edit Successfully!</div>',
										'redirect' => base_url().'bom-indent-request',
									));
								} else {
									$this->json->jsonReturn(array(
										'valid'=>FALSE,
										'msg'=>'<div class="alert modify alert-danger">Please Enter Valid BOM Items Details!!</div>'
									));
								}
							} else {
								$this->json->jsonReturn(array(
									'valid'=>FALSE,
									'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
								));
							}
						}
					}
				}

				public function check_boq_exceptional_bom_item(){
					$project_id = $this->input->post('project_id');
					$boq_code = $this->input->post('boq_code');
					$cnt = 0;
					if(isset($project_id) && !empty($project_id) && isset($boq_code) && !empty($boq_code)){
						$check_bom_items = $this->admin_model->boq_exceptional_bom_item($project_id,$boq_code);
						if(isset($check_bom_items) && !empty($check_bom_items)){
							$cnt = 1;
						}
					}
					echo $cnt;
				}

				public function check_boq_avl_release_qty() {
					$project_id = $this->input->post('project_id');
					$boq_code = $this->input->post('boq_code');
					$user_id = $this->session->userData('user_id');

					if(isset($project_id) && !empty($project_id)){
						$project_id = base64_decode($project_id);
					}
					$res = array();
					$member = $this->admin_model->get_boq_item_details($project_id,$boq_code);
					if(isset($member) && !empty($member)) {
						if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }

						$check_stock_details = $this->admin_model->check_stock_details($project_id,$boq_code);

						if(isset($check_stock_details) && !empty($check_stock_details)){
							$released_total_stock = 0;
							$released_pending = 0;
							$released_approved = 0;
							if(isset($check_stock_details->released_approved) && !empty($check_stock_details->released_approved)
							&& $check_stock_details->released_approved > 0){
								$released_approved = $check_stock_details->released_approved;
							}
						} else {
							$released_total_stock = 0;
							$released_pending = 0;
							$released_approved = 0;
						}
						if($design_qty > 0) {
							$avl_release_qty = $design_qty - $released_approved;
						} else{
							$avl_release_qty = 0;
						}
					}
					echo $avl_release_qty;
				}


				public function check_bom_indent_qty() {
					$project_id = $this->input->post('project_id');
					$boq_code = $this->input->post('bom_code');
					$user_id = $this->session->userData('user_id');

					if(isset($project_id) && !empty($project_id)){
						$project_id = base64_decode($project_id);
					}
					$res = array();
					$member = $this->admin_model->get_boq_item_details($project_id,$boq_code);
					if(isset($member) && !empty($member)) {
						if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }

						$check_stock_details = $this->admin_model->check_stock_details($project_id,$boq_code);

						if(isset($check_stock_details) && !empty($check_stock_details)){
							$released_total_stock = 0;
							$released_pending = 0;
							$released_approved = 0;
							if(isset($check_stock_details->released_approved) && !empty($check_stock_details->released_approved)
							&& $check_stock_details->released_approved > 0){
								$released_approved = $check_stock_details->released_approved;
							}
						} else {
							$released_total_stock = 0;
							$released_pending = 0;
							$released_approved = 0;
						}
						if($design_qty > 0) {
							$avl_release_qty = $design_qty - $released_approved;
						} else{
							$avl_release_qty = 0;
						}
					}
					echo $avl_release_qty;
				}

				public function mapping_boq_items()
				{
					$this->load->view('mapping-boq-items');
				}


				public function boq_items_upload() {

					$project_id = $this->input->post('project_id');
					$user_id = $this->session->userData("user_id");
					if(isset($user_id) && !empty($user_id)){
						if(isset($project_id) && !empty($project_id)){
							if(isset($_FILES['mapping_boq_item_excel_file']['name']))//Code for to take image from form and check isset
							{
								$mapping_boq_item_excel_file=$_FILES['mapping_boq_item_excel_file']['name']; //here [] name attribute
								$arr_mapping_boq_item_excel_file = array('upload_path' =>'./uploads/mapping_boq_item_excel_file/',
								'fieldname' => 'mapping_boq_item_excel_file',
								'encrypt_name' => TRUE,
								'overwrite' => FALSE,
								'allowed_types' => '*' );
								$arr_mapping_boq_item_excel_file = $this->imageupload->image_upload($arr_mapping_boq_item_excel_file);

								$error= $this->upload->display_errors();
								if(isset($arr_mapping_boq_item_excel_file) && !empty($arr_mapping_boq_item_excel_file)) {
									$userData = $this->upload->data();
									$category_img = $userData['file_name'];
								}
								$path = $_FILES["mapping_boq_item_excel_file"]["tmp_name"];
								require_once APPPATH . "/third_party/PHPExcel.php";
								$inputFileName = $path;
								try {

									$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
									$objReader = PHPExcel_IOFactory::createReader($inputFileType);
									$objPHPExcel = $objReader->load($inputFileName);
									$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
									$flag = true;
									$i=0;
									$updatedata = array();
									$query_result = false; // Initialize to false before the loop
									foreach ($allDataInSheet as $value) {
										if($flag){
											$flag =false;
											continue;
										}
										if(isset($value['A']) && !empty($value['A'])) { $boq_code = $value['A']; }else { $boq_code = '0'; }
										if(isset($value['B']) && !empty($value['B'])) { $client_boq_sr_no = $value['B']; }else { $client_boq_sr_no = '0'; }
										if(isset($value['C']) && !empty($value['C'])) { $hsn_sac_code = $value['C']; }else { $hsn_sac_code = '0'; }
										if(isset($value['D']) && !empty($value['D'])) { $bom_item_description = $value['D']; }else { $bom_item_description = ''; }


										if(!empty($boq_code) && !empty($project_id) && !empty($client_boq_sr_no))
										{
											$chkstatus='Y';
											$boq_item_details = $this->admin_model->get_boq_item_details($project_id,$boq_code);
											if(isset($boq_item_details) && !empty($boq_item_details)){
												if(isset($boq_item_details->status) && !empty($boq_item_details->status) && $boq_item_details->status == 'N'){
													$chkstatus = 'N';
												}
											}
											$non_schedule ="N";
											if (($boq_code !== null) && ($project_id !== null) && ($client_boq_sr_no !== null) && $chkstatus == 'Y') {
												$updatedata['client_boq_sr_no'] = $client_boq_sr_no;
												$this->db->where('project_id', $project_id);
												$this->db->where('boq_code', $boq_code);
												$this->db->update('tbl_boq_items', $updatedata);
												$query_result = true;
											}
										}
									}

								} catch (Exception $e) {

									die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
									. '": ' .$e->getMessage());
								}

								if($query_result == true) {
									$this->json->jsonReturn(array(
										'valid'=>TRUE,
										'msg'=>'<div class="alert modify alert-success">Mapping BOQ Items Uploaded Successfully!</div>',
										'redirect' => base_url().'mapping_boq_items'
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

				public function project_boq_item_list_mapping()
				{
					$projectId = $_GET['project_id'];
					if(isset($projectId) && !empty($projectId)){
						$project_id =$projectId;
						//$checkBOQUploadTransaction = $this->admin_model->checkBOQUploadTransactionCount($project_id);
					}else{
						$project_id = null;
						// $checkBOQUploadTransaction = 0;
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
							if(isset($member->hsn_sac_code) && !empty($member->hsn_sac_code)) { $hsn_sac_code = $member->hsn_sac_code; }else { $hsn_sac_code = '-'; }
							if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
							if(isset($member->client_boq_sr_no) && !empty($member->client_boq_sr_no)) { $client_boq_sr_no =$member->client_boq_sr_no;}else { $client_boq_sr_no = ''; }
							//if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '-'; }

							$data[] = array(
								$i,
								$boq_code,
								$client_boq_sr_no,
								$hsn_sac_code,
								$item_description,
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

				public function clear_test_data()  {

					$project_id = $_GET['project_id'];

					if(!empty($project_id) && isset($project_id) && $project_id > 0) {

						$this->db->where('project_id', $project_id);
						$this->db->delete('tbl_boq_exceptional');

						$this->db->where('project_id', $project_id);
						$this->db->delete('tbl_boq_items');

						$this->db->where('project_id', $project_id);
						$this->db->delete('tbl_boq_release_stock');

						$this->db->where('project_id', $project_id);
						$this->db->delete('tbl_boq_stock');

						$this->db->where('project_id', $project_id);
						$this->db->delete('tbl_boq_transactions');

						$this->db->where('project_id', $project_id);
						$this->db->delete('tbl_bom_exceptional');

						$this->db->where('project_id', $project_id);
						$this->db->delete('tbl_bom_indent_stock');

						$this->db->where('project_id', $project_id);
						$this->db->delete('tbl_bom_items');

						$this->db->where('project_id', $project_id);
						$this->db->delete('tbl_bom_release_stock');

						$this->db->where('project_id', $project_id);
						$this->db->delete('tbl_bom_stock');

						$this->db->where('project_id', $project_id);
						$this->db->delete('tbl_bom_transactions');

						$this->db->where('project_id', $project_id);
						$this->db->delete('tbl_delivery_challan');

						$this->db->where('project_id', $project_id);
						$this->db->delete('tbl_purchase_order');

						$this->db->where('project_id', $project_id);
						$this->db->delete('tbl_ppi_payment_receipt');

						$query=$this->db->query("SELECT * FROM `tbl_proforma_invc` WHERE project_id='".$project_id."'");
						if($query->num_rows() > 0){
							$tbl_proforma_invc_items = $query->result_array();

							foreach($tbl_proforma_invc_items as $key  => $proforma_invc) {
								if(isset($proforma_invc->proforma_id) && !empty($proforma_invc->proforma_id)) { $proforma_id = $proforma_invc->boq_items_id; }else { $proforma_id = '0'; }
								if($proforma_id > 0) {
									$this->db->where('proforma_id', $proforma_id);
									$this->db->delete('tbl_proforma_invc_items');
								}
							}
							$this->db->where('project_id', $project_id);
							$this->db->delete('tbl_proforma_invc');
						}

						$query2=$this->db->query("SELECT * FROM `tbl_provisional_wip` WHERE project_id='".$project_id."'");
						if($query2->num_rows() > 0){
							$tbl_provisional_wip = $query2->result_array();
							foreach($tbl_provisional_wip as $key  => $provisional_wip) {
								if(isset($provisional_wip->p_wip_id) && !empty($provisional_wip->p_wip_id)) { $p_wip_id = $provisional_wip->p_wip_id; }else { $p_wip_id = '0'; }
								if($p_wip_id > 0) {
									$this->db->where('p_wip_id', $p_wip_id);
									$this->db->delete('tbl_provisional_wip');
								}
							}
							$this->db->where('project_id', $project_id);
							$this->db->delete('tbl_provisional_wip');
						}
						$query3=$this->db->query("SELECT * FROM `tbl_installed_wip` WHERE project_id='".$project_id."'");
						if($query3->num_rows() > 0){
							$tbl_installed_wip = $query3->result_array();
							foreach($tbl_installed_wip as $key  => $installed_wip) {
								if(isset($installed_wip->i_wip_id) && !empty($installed_wip->i_wip_id)) { $p_wip_id = $installed_wip->i_wip_id; }else { $i_wip_id = '0'; }
								if($p_wip_id > 0) {
									$this->db->where('i_wip_id', $i_wip_id);
									$this->db->delete('tbl_install_wip_items');
								}
							}
							$this->db->where('project_id', $project_id);
							$this->db->delete('tbl_installed_wip');
						}
						$query4=$this->db->query("SELECT * FROM `tbl_tax_invc` WHERE project_id='".$project_id."'");
						if($query4->num_rows() > 0){
							$tbl_tax_invc = $query4->result_array();
							foreach($tbl_tax_invc as $key  => $tax_invc) {
								if(isset($tax_invc->tax_invc_id) && !empty($tax_invc->tax_invc_id)) { $tax_invc_id = $tax_invc->tax_invc_id; }else { $tax_invc_id = '0'; }
								if($tax_invc_id > 0) {
									$this->db->where('tax_invc_id', $tax_invc_id);
									$this->db->delete('tbl_tax_invc_items');
								}
							}
							$this->db->where('project_id', $project_id);
							$this->db->delete('tbl_tax_invc');
						}
						echo "Done";
					} else {
						echo 'Project id is not found in URL';
					}


				}
				public function create_purchase_order()
				{
					$this->load->view('create-purchase-order');
				}
				public function get_all_vendor_list(){

					$user_id=$this->session->userData("user_id");
					$category = $_POST['category'];
					$categories = explode(',', $category);
					$res = array();
					$vendor_data = $this->admin_model->getApprovedVendorList($categories);
					$processed_vendor_data = [];

					$vendor_map = [];

					foreach ($vendor_data as $vendor) {
						if (!isset($vendor_map[$vendor->vendor_id])) {
							$vendor_map[$vendor->vendor_id] = (array) $vendor;
							$vendor_map[$vendor->vendor_id]['category_names'] = [];
						}
						$vendor_map[$vendor->vendor_id]['category_names'][] = $vendor->category_name;
					}

					foreach ($vendor_map as $vendor_id => $vendor) {
						unset($vendor['category_name']);
						$vendor['category_names'] = implode(', ', $vendor['category_names']);
						$processed_vendor_data[] = (object) $vendor;
					}
					if (isset($processed_vendor_data) && !empty($processed_vendor_data) && isset($user_id) && !empty($user_id)) {
						$i = 0;
						$res = [];
						foreach ($processed_vendor_data as $key) {
							$res[$i]['id'] = $key->vendor_id;
							$res[$i]['vendor'] = $key->name_of_company ."(".$key->category_names.")";
							$i++;
						}
					}

					echo json_encode($res);
				}

				public function get_vendor_detail(){
					$user_id=$this->session->userData("user_id");
					$vendor_id = $_POST['vendor_id'];
					$res = array();
					$getPrifixData = $this->common_model->getPrifixData("PO");
					if(isset($getPrifixData) && !empty($getPrifixData)){
						$prefix_name = $getPrifixData['prefix_name'];
						$financial_year = $getPrifixData['financial_year'];
					}else{
						$prefix_name = "PEPL";
						$financial_year = $this->getFinancialYear();
					}
					$po_no = 1;
					$getLastInc = $this->common_model->getLastInc("PO");
					$parts = explode('/', $getLastInc);
					$getLastInc = $parts[2];
					$po_no = intval($getLastInc) + $po_no;
					$purchase_order_no = $prefix_name."/".$financial_year."/".$po_no;

					$vendor_data = $this->admin_model->getVendorDetail($vendor_id);

					$res['po_no'] = $purchase_order_no;
					$res['data'] = $vendor_data[0];

					echo json_encode($res);
				}


				public function get_all_category(){

					$res = array();
					$category_data = $this->admin_model->getAllCategory();
					$res['data'] = $category_data;
					echo json_encode($res);
				}

				public function get_purchase_order_list() {

					$page_type = $this->input->get("type");
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
							$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_pruchase_order');
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
							$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_po_request');
							if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
								$submenu_id = $submenu_data->submenu_id;
								$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
								if(isset($check_permission) && !empty($check_permission)){
									$check_permission_edit = 'Y';
								}
							}
						}

						$data = $row = array();

						$memData = $this->admin_model->getBOMTransactionIndentListRows($_POST,$project_idpost,'purchase_order');
						$allCount = $this->admin_model->getBOMTransactionIndentListAll($project_idpost,'purchase_order');
						$countFiltered = $this->admin_model->getBOMTransactionIndentFiltered($_POST,$project_idpost,'purchase_order');


						$po_amount = 0;
						$filter = 'original';
						$i = isset($_POST['start']) ? $_POST['start'] : 1;
						foreach($memData as $member){
							$podata =[];
							if ($member->event_type == 'purchase_order') {
								$purchaseOrderInfo = $this->admin_model->getpurchaseOrderInfo($member->project_id,$member->id);

								if(count($purchaseOrderInfo) > 0){
									$total_amount = array_sum(array_column($purchaseOrderInfo,"total_amount"));
									$podata = $purchaseOrderInfo[0];
									$podata->total_amount = $total_amount;
								}
							}

							$i++;
							if(isset($member->id) && !empty($member->id)) { $id = $member->id; }else { $id = '0'; }
							if(isset($podata->po_id) && !empty($podata->po_id)) { $po_id = $podata->po_id; }else { $po_id = '0'; }
							if(isset($podata->po_number) && !empty($podata->po_number)) { $po_number = $podata->po_number; }else { $po_number = '-'; }
							if(isset($podata->name_of_company) && !empty($podata->name_of_company)) { $vendor_name = $podata->name_of_company; }else { $vendor_name = '-'; }
							if(isset($podata->total_amount) && !empty($podata->total_amount)) { $po_amount = $podata->total_amount; }else { $po_amount = '-'; }
							if(isset($member->event_name) && !empty($member->event_name)) { $event_name = $member->event_name; }else { $event_name = '-'; }
							if(isset($member->event_type) && !empty($member->event_type)) { $event_type = $member->event_type; }else { $event_type = '-'; }
							if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
							if(isset($member->created_date) && !empty($member->created_date)) { $created_at = $member->created_date; }else { $created_at = '-'; }
							if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = '-'; }
							if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '-'; }
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
							$action = '';

							if($page_type != 'pruchase_order_listing'){
								$action .='<a href="javascript:void(0);" title="Download Po" data-project_id="'.base64_encode($project_id).'" data-boq_code="" data-type="'.$event_type.'" data-status="'.$status.'"  data-transaction_id="'.$id.'" class="download-po" style="margin-right: 8px;"><i class="fa fa-download" style="color:#000; font-size:15px;"></i></a>';
								$open_doc_url = $this->config->item("base_url")."generate_po_pdf?project_id=".base64_encode($project_id)."&type=".$event_type."&status=".$status."&transaction_id=".$id."";
								$action .='<a class="Invoice" href="'.$open_doc_url.'" data-project_id="'.base64_encode($project_id).'" data-boq_code="" data-type="'.$event_type.'" data-status="'.$status.'"  data-id="'.$id.' " style="margin-right: 8px;"><i class="fa fa-file-text" style="color:#000; font-size:15px;"></i></a>';
							}

							$action .='<a class=" openview" href="javascript:void(0);" data-project_id="'.base64_encode($project_id).'" data-boq_code="" data-type="'.$event_type.'" data-status="'.$status.'"  data-id="'.$id.'" style="margin-right: 8px;">VIEW</a>';

							if($status =='approved' && $page_type != 'pruchase_order_listing'){
								$action .= '<a class="popup_save me-2" href="' . base_url() . 'vendor_proforma_invoice?po='.base64_encode($po_number).'" data-project_id="' . base64_encode($project_id) . '" data-boq_code="" data-type="' . $event_type . '" data-status="' . $status . '" data-transaction_id="' . $id . '" title="Convert To Vendor PI" data-status="allow" style="margin-right: 8px;"><img src="' . base_url() . 'uploads/images/tax_icon.jpg" width="20px" height="20px"></a>';

							}elseif($status =='reject' && $page_type != 'pruchase_order_listing'){

								$action .='<a href="javascript:;" class="editRecordPO tooltips" rel-po-id="'.$id.'" data-project-id="'.$project_id.'" title="Edit Record" rev="edit_indent_request" data-original-title="Edit Record"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';

							}
							$data[] = array(
								$i,
								$po_number,
								$bp_code,
								$vendor_name,
								number_format((float)$po_amount, 2, '.', ''),
								$created_by_name,
								$approved_by_name,
								$action_status,
								$action
							);

						}

						$output = array(
							"draw" => isset($_POST['draw']) ? $_POST['draw'] : '',
							"recordsTotal" => $allCount,
							"recordsFiltered" => $countFiltered,
							"data" => $data,
						);
						echo json_encode($output);
					}

				}


				public function view_purchase_order($project_id) {
					$id = $this->uri->segment(2);
					if(isset($id) && !empty($id)){
						$id = base64_decode($id);
					}
					$bp_code = $this->admin_model->get_bp_code($id);
					$data['bp_code'] = $bp_code;
					$data['project_id_encode'] = $project_id;
					$data['project_id'] = $id;
					$data['id'] = $id;
					$this->load->view('view-purchase-order',$data);
				}
				public function get_edit_bom_po_item_by_project() {

					$post_data = $this->input->post();
					$part_pending_qty = $this->get_bom_po_pending_qty_item_by_project($post_data['project_id']);
					$user_id = $this->session->userData('user_id');
					if(isset($user_id) && !empty($user_id)){
						$data = $new_entry_arr = array();
						// $memData = $this->admin_model->getBOMIndentItemListRows($_POST,$project_id);
						$memData = $this->admin_model->getBOMEditPoItemListRows($post_data['project_id'],$post_data['po_id']);
						$transaction_id = $memData[0]->transaction_id;
						$po_number = $memData[0]->po_number;
						$project_name = $memData[0]->project_name;
						$vendor = $memData[0]->vendor;
						$gst_registration_no = $memData[0]->gst_registration_no;
						$address = $memData[0]->address;
						$category_name = $memData[0]->category_name;
						$po_number = $memData[0]->po_number;
						$allCount = count($memData);
						$countFiltered = count($memData);
						$i = $_POST['start'];
						$po_approval_pending = array();
						// 		pr($memData,1);
						foreach($memData as $member){

							$i++;
							if(isset($member->id) && !empty($member->id)) { $id = $member->id; }else { $id = 0; }
							if(isset($member->bom_code) && !empty($member->bom_code)) { $bom_code = $member->bom_code; }else { $bom_code = 0; }
							if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = 0; }
							if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
							if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = ''; }
							if(isset($member->unit) && !empty($member->unit)) { $make = $member->make; }else { $make = ''; }
							if(isset($member->model) && !empty($member->model)) { $model = $member->model; }else { $model = ''; }
							if(isset($member->indent_quantity) && !empty($member->indent_quantity)) { $quantity = $member->indent_quantity; }else { $quantity = ''; }
							if(isset($member->po_basic_rate) && !empty($member->po_basic_rate)) { $rate_basic = $member->po_basic_rate; }else { $po_basic_rate = ''; }
							if(isset($member->rate_basic) && !empty($member->rate_basic)) { $original_rate_basic = $member->rate_basic; }else { $rate_basic = ''; }
							if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = ''; }
							$pending_qty = isset($part_pending_qty[$member->bom_code]) ? $part_pending_qty[$member->bom_code] : 0;
							$available_qty = $quantity + $pending_qty;
							// $finalAmount = $quantity * $basicRate * (1 + ($gst / 100));
							$amount = floatval($quantity) * floatval($rate_basic)* (1 + ($gst / 100));
							$famount = number_format($amount, 2, '.', '');

							// $bom_indent_pending = $this->admin_model->check_bom_indent_pending($project_idpost, $boq_code, $bom_code);

							$item_data = $this->admin_model->getItemDataDetails($member->project_id,$member->bom_code);
							$item_make = explode("/",$item_data['make']);
							$make_slect_opt = "<option value='".$item_data['make']."' >Select Make</option>";
							foreach($item_make as $val){
								if($val == $make){
									$make_slect_opt .= "<option value='".$val."' selected>".$val."</option>";
								}else{
									$make_slect_opt .= "<option value='".$val."'>".$val."</option>";
								}
							}
							$item_model = explode("/",$item_data['model']);
							$model_slect_opt = "<option value='".$item_data['model']."' >Select Model</option>";
							foreach($item_model as $val){
								if($val == $model){
									$model_slect_opt .= "<option value='".$val."' selected>".$val."</option>";
								}else{
									$model_slect_opt .= "<option value='".$val."'>".$val."</option>";
								}
							}
							$sr_no_d = '<input type="text" class="form-control invaliderror"  name="sr_no[]" value="'. $i.'" placeholder="Sr.No" style="font-size: 12px;width:100%" readonly>';
							$bom_sr_d = '<input type="hidden" class="form-control invaliderror"  name="po_id[]" value="'. $id.'" placeholder="Sr.No" style="font-size: 12px;width:100%" readonly>';
							$bom_sr_d .= '<input type="hidden" class="js-req_qty"  name="req_qty[]" value="'.$indent_stock.'" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>';
							$bom_sr_d .= '<input type="hidden" class="js-boq_code"  name="boq_code[]" value="'.$boq_code.'" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>
							<input type="text" class="form-control invaliderror js-bom_sr_no"  name="bom_code[]" value="'.$bom_code.'" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>';
							$bom_item_d = '<input type="text" class="form-control invaliderror"  name="bom_item_description[]" value="'.$item_description.'" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>';
							$bom_unit_d = '<input type="text" class="form-control invaliderror"  name="bom_unit[]" value="'.$unit.'" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>';
							$bom_make_d = '<select  class="form-control invaliderror bom_make"  name="bom_make[]">'.$make_slect_opt.'</select>';
							$bom_model_d = '<select  class="form-control invaliderror bom_model"  name="bom_model[]">'.$model_slect_opt.'</select>';
							$bom_indent_d = '<input type="text" class="form-control invaliderror po-avilable-stock"  name="bom_avl_stock[]" value="'.$available_qty.'" placeholder="Available Qty" style="font-size: 12px;width:100%" readonly>';
							$bom_required_d = '<input type="text" class="form-control invaliderror js-requires-po-qty"  name="bom_req_stock[]" value="'.$quantity.'" placeholder="Required Qty" style="font-size: 12px;width:100%">';
							$bom_basic_rate = '<input type="hidden" class="js-boq_code basic_rate"  name="basic_rate[]" value="'.$original_rate_basic.'" placeholder="" style="font-size: 12px;width:100%" readonly>
							<input type="text" class="form-control invaliderror js-po-basic_rate" id="js-required-qty" name="rate_basic[]" value="'.$rate_basic.'" placeholder="Required Qty" style="font-size: 12px;width:100%" >';
							$bom_gst = '<input type="text" class="form-control invaliderror " name="bom_gst[]" value="'.$gst.'" placeholder="Required gst" style="font-size: 12px;width:100%" readonly>';
							$bom_amount = '<input type="text" class="form-control invaliderror " id="js-required-qty" name="amount[]" value="'.$famount.'" placeholder="Required Qty" style="font-size: 12px;width:100%" readonly>';

							$data[] = array(
								$sr_no_d,
								$bom_sr_d,
								$bom_item_d,
								$bom_unit_d,
								$bom_make_d,
								$bom_model_d,
								$bom_indent_d,
								$bom_required_d,
								$bom_basic_rate,
								$bom_gst,
								$bom_amount,
							);
						}

						$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $allCount,
							"recordsFiltered" => $countFiltered,
							"data" => $data,
							'po_number' => $po_number,
							'project_name' => $project_name,
							'vendor' => $vendor,
							'address' => $address,
							'category_name' => $category_name,
							'gst_registration_no'=>$gst_registration_no,
							'transaction_id'=>$transaction_id

						);

						echo json_encode($output);
					}
				}
				public function get_bom_po_item_by_project() {

					$project_idpost = $this->input->post('project_id');
					if(isset($project_idpost) && !empty($project_idpost)){
						$project_id = $project_idpost;
					}else{
						$project_id = 0;
					}

					$user_id = $this->session->userData('user_id');
					if(isset($user_id) && !empty($user_id)){
						$data = $new_entry_arr = array();
						// $memData = $this->admin_model->getBOMIndentItemListRows($_POST,$project_id);
						$memData = $this->admin_model->getBOMPoItemListRows($_POST,$project_id);

						$project_po_data = $this->admin_model->getProjectPoData($project_id);
						$bom_code_wise_qty = [];
						foreach($project_po_data as $key=>$val){
							if(isset($bom_code_wise_qty[$val->bom_code])){
								$bom_code_wise_qty[$val->bom_code] += $val->po_quantity;
							}else{
								$bom_code_wise_qty[$val->bom_code] = $val->po_quantity;
							}

						}
						// 	$bom_code_wise_qty = array_column($project_po_data,"total_qty","bom_code");

						$allCount = count($memData);
						$countFiltered = count($memData);
						$i = $_POST['start'];
						$po_approval_pending = array();

						foreach($memData as $member){

							if(isset($bom_code_wise_qty[$member->bom_code])){
								$member->indent_quantity = $member->indent_quantity - $bom_code_wise_qty[$member->bom_code];
							}
							$i++;
							if(isset($member->bom_code) && !empty($member->bom_code)) { $bom_code = $member->bom_code; }else { $bom_code = 0; }
							if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = 0; }
							if(isset($member->item_description) && !empty($member->item_description)) { $item_description = $member->item_description; }else { $item_description = '-'; }
							if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = ''; }
							if(isset($member->unit) && !empty($member->unit)) { $make = $member->make; }else { $make = ''; }
							if(isset($member->model) && !empty($member->model)) { $model = $member->model; }else { $model = ''; }
							if(isset($member->indent_quantity) && !empty($member->indent_quantity)) { $quantity = $member->indent_quantity; }else { $quantity = ''; }
							if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = ''; }
							if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = ''; }

							// $finalAmount = $quantity * $basicRate * (1 + ($gst / 100));
							$amount = floatval($quantity) * floatval($rate_basic)* (1 + ($gst / 100));
							$famount = number_format($amount, 2, '.', '');
							$item_data = $this->admin_model->getItemDataDetails($member->project_id,$member->bom_code);
							$item_make = explode("/",$item_data['make']);
							$make_slect_opt = "<option value='".$item_data['make']."'>Select Make</option>";
							foreach($item_make as $val){
								if($val == $make){
									$make_slect_opt .= "<option value='".$val."' selected>".$val."</option>";
								}else{
									$make_slect_opt .= "<option value='".$val."'>".$val."</option>";
								}
							}
							$item_model = explode("/",$item_data['model']);
							$model_slect_opt = "<option value='".$item_data['model']."'>Select Model</option>";
							foreach($item_model as $val){

								if($val == $model){
									$model_slect_opt .= "<option value='".$val."' selected>".$val."</option>";
								}else{
									$model_slect_opt .= "<option value='".$val."'>".$val."</option>";
								}
							}
							$sr_no_d = '<input type="text" class="form-control invaliderror"  name="sr_no[]" value="'. $i.'" placeholder="Sr.No" style="font-size: 12px;width:100%" readonly>';
							$bom_sr_d = '<input type="hidden" class="js-req_qty"  name="req_qty[]" value="'.$indent_stock.'" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>';
							$bom_sr_d .= '<input type="hidden" class="js-boq_code"  name="boq_code[]" value="'.$boq_code.'" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>
							<input type="text" class="form-control invaliderror js-bom_sr_no"  name="bom_code[]" value="'.$bom_code.'" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>';
							$bom_item_d = '<input type="text" class="form-control invaliderror"  name="bom_item_description[]" value="'.$item_description.'" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>';
							$bom_unit_d = '<input type="text" class="form-control invaliderror"  name="bom_unit[]" value="'.$unit.'" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>';
							$bom_make_d = '<select  class="form-control bom_make"  name="bom_make[]">'.$make_slect_opt.'</select>';
							$bom_model_d = '<select  class="form-control bom_model"  name="bom_model[]">'.$model_slect_opt.'</select>';
							$bom_indent_d = '<input type="text" class="form-control invaliderror po-avilable-stock"  name="bom_avl_stock[]" value="'.$quantity.'" placeholder="Available Qty" style="font-size: 12px;width:100%" readonly>';
							$bom_required_d = '<input type="text" class="form-control invaliderror js-requires-po-qty"  name="bom_req_stock[]" value="'.$quantity.'" placeholder="Required Qty" style="font-size: 12px;width:100%">';
							$bom_basic_rate = '<input type="hidden" class="form-control basic_rate"  name="basic_rate[]" value="'.$rate_basic.'" placeholder="Required Qty" style="font-size: 12px;width:100%">
							<input type="text" class="form-control invaliderror js-po-basic_rate" name="rate_basic[]" value="'.$rate_basic.'" placeholder="Required Qty" style="font-size: 12px;width:100%" >';
							$bom_gst = '<input type="text" class="form-control invaliderror " name="bom_gst[]" value="'.$gst.'" placeholder="Required gst" style="font-size: 12px;width:100%" readonly>';
							$bom_amount = '<input type="text" class="form-control invaliderror " id="js-required-qty" name="amount[]" value="'.$famount.'" placeholder="Required Qty" style="font-size: 12px;width:100%" readonly>';
							$action_d ='<div class="addDeleteButton"><span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span></div>';

							if($member->indent_quantity > 0){
								$data[] = array(
									$sr_no_d,
									$bom_sr_d,
									$bom_item_d,
									$bom_unit_d,
									$bom_make_d,
									$bom_model_d,
									$bom_indent_d,
									$bom_required_d,
									$bom_basic_rate,
									$bom_gst,
									$bom_amount,
									$action_d
								);
							}


						}

						$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $allCount,
							"recordsFiltered" => $countFiltered,
							"data" => $data,
							'po_approval_pending' => $po_approval_pending

						);

						echo json_encode($output);

					}
				}
				public function get_po_list() {

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
							$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_pruchase_order');
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
							$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','save_po_request');
							if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
								$submenu_id = $submenu_data->submenu_id;
								$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
								if(isset($check_permission) && !empty($check_permission)){
									$check_permission_edit = 'Y';
								}
							}
						}

						$data = $row = array();
						$memData = $this->admin_model->getBOMTransactionIndentListRows($_POST,$project_idpost,'purchase_order');
						$allCount = $this->admin_model->getBOMTransactionIndentListAll($project_idpost,'purchase_order');
						$countFiltered = $this->admin_model->getBOMTransactionIndentFiltered($_POST,$project_idpost,'purchase_order');

						$i = $_POST['start'];
						foreach($memData as $member){
							$podata =[];
							if ($member->event_type == 'purchase_order') {
								$purchaseOrderInfo = $this->admin_model->getpurchaseOrderInfo($member->project_id,$member->id);
								$podata = $purchaseOrderInfo[0];
								$total_sum = array_column($purchaseOrderInfo,"total_amount");
								$total_po_sum= array_sum($total_sum);


							}
							$i++;
							if(isset($member->id) && !empty($member->id)) { $id = $member->id; }else { $id = '0'; }
							if(isset($podata->po_id) && !empty($podata->po_id)) { $po_id = $podata->po_id; }else { $po_id = '0'; }
							if(isset($podata->po_number) && !empty($podata->po_number)) { $po_number = $podata->po_number; }else { $po_number = '-'; }
							if(isset($podata->name_of_company) && !empty($podata->name_of_company)) { $vendor_name = $podata->name_of_company; }else { $vendor_name = '-'; }
							if(isset($total_po_sum) && !empty($total_po_sum)) { $po_amount = $total_po_sum; }else { $po_amount = '-'; }
							if(isset($member->event_name) && !empty($member->event_name)) { $event_name = $member->event_name; }else { $event_name = '-'; }
							if(isset($member->event_type) && !empty($member->event_type)) { $event_type = $member->event_type; }else { $event_type = '-'; }
							if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
							if(isset($member->created_date) && !empty($member->created_date)) { $created_at = $member->created_date; }else { $created_at = '-'; }
							if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = '-'; }
							if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '-'; }
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

							$action = '';
							$action .='<a href="javascript:void(0);" title="Download Po" data-project_id="'.base64_encode($project_id).'" data-boq_code="" data-type="'.$event_type.'" data-status="'.$status.'"  data-transaction_id="'.$id.'" class="download-po" style="margin-right: 8px;"><i class="fa fa-download" style="color:#000; font-size:15px;"></i></a>';
							$action .= '<a class="popup_save me-2" href="' . base_url() . 'vendor_proforma_invoice?po='.base64_encode($po_number).'" data-project_id="' . base64_encode($project_id) . '" data-boq_code="" data-type="' . $event_type . '" data-status="' . $status . '" data-transaction_id="' . $id . '" title="Convert To Vendor PI" data-status="allow" style="margin-right: 8px;"><img src="' . base_url() . 'uploads/images/tax_icon.jpg" width="20px" height="20px"></a>';

							$action .='<a class="Invoice" href="javascript:void(0);" data-project_id="'.base64_encode($project_id).'" data-boq_code="" data-type="'.$event_type.'" data-status="'.$status.'"  data-id="'.$id.' " style="margin-right: 8px;"><i class="fa fa-file-text" style="color:#000; font-size:15px;"></i></a>';
							$action .='<a class=" openview" href="javascript:void(0);" data-project_id="'.base64_encode($project_id).'" data-boq_code="" data-type="'.$event_type.'" data-status="'.$status.'"  data-id="'.$id.'" style="margin-right: 8px;">VIEW</a>';

							if($status =='pending'){

							}elseif($status =='reject'){
								$action .='<a href="javascript:;" class="editRecordPO tooltips" rel-po-id="'.$id.'" data-project-id="'.$project_id.'" title="Edit Record" rev="edit_indent_request" data-original-title="Edit Record"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';

							}
							$data[] = array(
								$i,
								$po_number,
								$bp_code,
								$vendor_name,
								number_format((float)$po_amount, 2, '.', ''),
								$created_by_name,
								$approved_by_name,
								$action_status,
								$action
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

				public function save_po_request() {

					$loguser_id = $this->session->userData('user_id');
					$logrole_id = $this->session->userData('role_id');

					if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)) {
						$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_pruchase_order');
						if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
							$submenu_id = $submenu_data->submenu_id;
							$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
							if(isset($check_permission) && !empty($check_permission)){
								$project_id = $this->input->post('project_id');
								$po_number = $this->input->post('po_number');
								$terms_and_condition = $this->input->post('terms_and_condition');
								$vendor_category_id = $this->input->post('vendor_category_id');
								$vendor_id = $this->input->post('vendor_id');
								$remark = $this->input->post('remark');
								$attachment = $this->input->post('attachment');
								$error = 'N';
								$error_message = '';
								if(isset($loguser_id) && empty($loguser_id)){
									$error = 'Y';
									$error_message = 'Please loggedin!';
								}

								$bom_code = $this->input->post('bom_code');
								if(isset($bom_code) && !empty($bom_code)) { $bom_code = $bom_code; } else { $bom_code=''; }
								if(isset($bom_code) && empty($bom_code)){
									$error = 'Y';
									$error_message = 'BOM Sr No is empty!';
								}

								$qty = $this->input->post('bom_req_stock');

								$boq_code = $this->input->post('boq_code');
								$rate_basic = $this->input->post('rate_basic');
								$amount = $this->input->post('amount');

								if(isset($boq_code) && !empty($boq_code)) { $boq_code = $boq_code; } else { $boq_code=''; }
								if(isset($boq_code) && empty($boq_code) && isset($bom_code) && empty($bom_code) && isset($qty) && empty($qty)&& isset($amount) && empty($amount)) {
									$this->json->jsonReturn(
										array(
											'valid'=>FALSE,
											'msg'=>'<div class="alert modify alert-danger">Please Enter Required Qty Details !</div>'
										)
									);
								} else {
									$flag = true;
									$bom_model = $this->input->post('bom_model');
									$bom_make = $this->input->post('bom_make');
									foreach($bom_code as $key=>$val){
										if(!($qty[$key] > 0)){
											$flag = false;
										}
										if(isset($boq_code[$key]) && !empty($boq_code[$key])) { $boq_code_s = $boq_code[$key]; } else { $boq_code_s = ''; }
										if(isset($qty[$key]) && !empty($qty[$key])) { $qty_val = $qty[$key]; } else { $qty_val = ''; }
										if(isset($bom_code[$key]) && !empty($bom_code[$key])) { $bom_code_s = $bom_code[$key]; } else { $bom_code_s = ''; }
										if(isset($amount[$key]) && !empty($amount[$key])) { $amount_val = $amount[$key]; } else { $amount_val = ''; }
										if(isset($bom_model[$key]) && !empty($bom_model[$key])) { $model = $bom_model[$key]; } else { $model = ''; }
										if(isset($bom_make[$key]) && !empty($bom_make[$key])) { $make = $bom_make[$key]; } else { $make = ''; }
										if(isset($rate_basic[$key]) && !empty($rate_basic[$key])) { $basic_rate = $rate_basic[$key]; } else { $basic_rate = 0; }

										$indent_stock_arr[] = array(
											'po_number'=>$po_number,
											'project_id'=>$project_id,
											'vendor_category'=>$vendor_category_id,
											'vendor_id'=>$vendor_id,
											'boq_code'=>$boq_code_s,
											'bom_code'=>$bom_code_s,
											"make"=>$make,
											"model"=>$model,
											'terms_and_condition'=> $terms_and_condition,
											'po_quantity'=> $qty_val,
											'basic_rate'=>$basic_rate,
											'po_amount'=> $amount_val,
											'remark'=> $remark,
											'attachment'=> $attachment,
											'status'=>'pending',
											'display' => 'Y',
											'created_by'=>$loguser_id,
											'created_on'=>date('Y-m-d H:i:s'),

										);
									}

								}
								// pr($indent_stock_arr,1);
								if(!$flag){
									$error = 'Y';
									$error_message = 'Required Quantity empty!';
									$this->json->jsonReturn(array(
										'valid'=>FALSE,
										'msg'=>'<div class="alert modify alert-danger">Required Quantity empty!</div>',
										// 'redirect' => base_url().'create_purchase_order',
									));
								}else{
									if((isset($indent_stock_arr) && !empty($indent_stock_arr))){
										$event_name = 'Purchase Order Request';
										$BOMTransArr = array('project_id'=>$project_id,'event_name'=>$event_name,
										'event_type'=>'purchase_order','created_date'=>date('Y-m-d H:i:s'),'created_by'=>$loguser_id,
										'updated_by'=>$loguser_id, 'updated_date'=>date('Y-m-d H:i:s'),'display'=>'Y','status'=>'pending');
										$transaction_id = $this->common_model->addData('tbl_bom_transactions',$BOMTransArr);

										if($transaction_id > 0){
											foreach($indent_stock_arr as $key => $csm){
												$indent_stock_arr[$key]['transaction_id'] = $transaction_id;
											}

											if(isset($indent_stock_arr) && !empty($indent_stock_arr)){
												$result = $this->common_model->SaveMultiData('tbl_purchase_order',$indent_stock_arr);

											}
										}
										$this->json->jsonReturn(array(
											'valid'=>TRUE,
											'msg'=>'<div class="alert modify alert-success">Purchase Order Request send Successfully!</div>',
											'redirect' => base_url().'create_purchase_order',
										));
									} else {
										$this->json->jsonReturn(array(
											'valid'=>FALSE,
											'msg'=>'<div class="alert modify alert-danger">Please Enter Valid BOM Items Details!!</div>'
										));
									}
								}

							} else {
								$this->json->jsonReturn(array(
									'valid'=>FALSE,
									'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
								));
							}
						}
					}
				}
				public function edit_save_po_request() {
					$loguser_id = $this->session->userData('user_id');
					$logrole_id = $this->session->userData('role_id');
					if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)) {
						$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_pruchase_order');
						if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
							$submenu_id = $submenu_data->submenu_id;
							$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
							if(isset($check_permission) && !empty($check_permission)){

								$post_data = $this->input->post();
								// pr($post_data,1);
								$update_arr = [];
								$flag = true;
								foreach($post_data['bom_code'] as $key=>$val){
									$update_arr[] = [
										"id" => $post_data['po_id'][$key],
										"po_amount" =>$post_data['amount'][$key],
										"po_quantity" =>$post_data['bom_req_stock'][$key],
										"basic_rate"=>$post_data['rate_basic'][$key],
										"status" => "pending",
										"make" => $post_data['bom_make'][$key],
										"model" => $post_data['bom_model'][$key],
										"updated_by" => $loguser_id,
										"updated_date" => date('Y-m-d H:i:s')
									];
									if($post_data['bom_req_stock'][$key] <= 0){
										$flag = false;
									}
								}

								if(!$flag){
									$error = 'Y';
									$error_message = 'Required Quantity empty!';
									$this->json->jsonReturn(array(
										'valid'=>FALSE,
										'msg'=>'<div class="alert modify alert-danger">Required Quantity empty!</div>',

									));
								}else{
									$affected_row=$this->admin_model->updatePoItemListRows($update_arr);
									if($affected_row >= 0){
										$affected_row=$this->admin_model->updatePoTransactionStatus($post_data['transaction_id']);
										$this->json->jsonReturn(array(
											'valid'=>TRUE,
											'msg'=>'<div class="alert modify alert-success">Purchase order updated successfully.</div>',
											'redirect' => base_url().'create_purchase_order',
										));
									}else{
										$this->json->jsonReturn(array(
											'valid'=>FALSE,
											'msg'=>'<div class="alert modify alert-danger"><strong>Something went wrong!</div>'
										));
									}
								}

							} else {
								$this->json->jsonReturn(array(
									'valid'=>FALSE,
									'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
								));
							}
						}
					}
				}
				public function project_bom_trans_list_display()
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
					$boq_code = $this->input->post('boq_code');
					if(isset($boq_code) && !empty($boq_code)){
						$boq_code = $boq_code;
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
						$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_bom_details');
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
						if($transaction_type == 'bom_upload' || $transaction_type == 'add_edit_bom'){
							$memData = $this->admin_model->getViewBOMTransListRows($_POST,$project_id,$transaction_id,$boq_code,$status_txt);
							$allCount = $this->admin_model->countViewBOMTransListAll($project_id,$transaction_id,$boq_code,$status_txt);
							$countFiltered = $this->admin_model->countViewBOMTransListFiltered($_POST,$project_id,$transaction_id,$boq_code,$status_txt);
						} else if($transaction_type =='release_qty') {
							$memData = $this->admin_model->getViewBOMTransReleaseQtyListRows($_POST,$project_id,$transaction_id,$boq_code,$status_txt);
							$allCount = $this->admin_model->countViewBOMTransReleaseQtyListAll($project_id,$transaction_id,$boq_code,$status_txt);
							$countFiltered = $this->admin_model->countViewBOMTransReleaseQtyListFiltered($_POST,$project_id,$transaction_id,$boq_code,$status_txt);
						} else if($transaction_type =='indent_request') {
							$memData = $this->admin_model->getViewBOMIndentListRows($_POST,$project_id,$transaction_id,$boq_code,$status_txt);
							$allCount = $this->admin_model->countViewBOMIndentListAll($project_id,$transaction_id,$boq_code,$status_txt);
							$countFiltered = $this->admin_model->countViewBOMIndentListFiltered($_POST,$project_id,$transaction_id,$boq_code,$status_txt);
						}else if($transaction_type =='purchase_order') {
							$memData = $this->admin_model->getViewBomPOListRows($_POST,$project_id,$transaction_id,$boq_code,$status_txt);
							$allCount = $this->admin_model->countViewBomPoListAll($project_id,$transaction_id,$boq_code,$status_txt);
							$countFiltered = $this->admin_model->countViewBOMIndentListFiltered($_POST,$project_id,$transaction_id,$boq_code,$status_txt);
						}else if($transaction_type =='vendor_proforma_invoice') {
							$memData = $this->admin_model->getViewBomVpiListRows($_POST,$project_id,$transaction_id,$boq_code,$status_txt);
							$allCount = $this->admin_model->countViewBomVpiListAll($project_id,$transaction_id,$boq_code,$status_txt);
							$countFiltered = $this->admin_model->countViewBOMIndentListFiltered($_POST,$project_id,$transaction_id,$boq_code,$status_txt);
						}

						$i = $_POST['start'];
						$unique_arr = [];
						// pr($memData,1);
						foreach($memData as $member){
							$i++;
							if(isset($member->boq_items_id) && !empty($member->boq_items_id)) { $boq_items_id = $member->boq_items_id; }else { $boq_items_id = '-'; }
							if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
							if(isset($member->bom_code) && !empty($member->bom_code)) { $bom_code = $member->bom_code; }else { $bom_code = '-'; }
							if(isset($member->boq_code) && !empty($member->boq_code)) { $boq_code = $member->boq_code; }else { $boq_code = '-'; }
							if(isset($member->item_description) && !empty($member->item_description)) { $item_description =$member->item_description; }else { $item_description = '-'; }
							if(isset($member->make) && !empty($member->make)) { $make =$member->make; }else { $make = '-'; }
							if(isset($member->model) && !empty($member->model)) { $model =$member->model; }else { $model = '-'; }
							if(isset($member->unit) && !empty($member->unit)) { $unit = $member->unit; }else { $unit = '-'; }
							if(isset($member->rate_basic) && !empty($member->rate_basic)) { $rate_basic = $member->rate_basic; }else { $rate_basic = '0'; }
							if(isset($member->gst) && !empty($member->gst)) { $gst = $member->gst; }else { $gst = '0'; }
							if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = 'N'; }
							if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '0'; }
							if(isset($member->is_billing_inter_state) && !empty($member->is_billing_inter_state)) { $is_billing_inter_state = $member->is_billing_inter_state; }else { $is_billing_inter_state = 'N'; }
							if(isset($member->o_design_qty) && !empty($member->o_design_qty)) { $o_design_qty = $member->o_design_qty; }else { $o_design_qty = '0'; }
							if(isset($member->upload_design_qty) && !empty($member->upload_design_qty)) { $upload_design_qty = $member->upload_design_qty; }else { $upload_design_qty = '0'; }
							if(isset($member->design_qty) && !empty($member->design_qty)) { $design_qty = $member->design_qty; }else { $design_qty = '0'; }
							if(isset($member->display) && !empty($member->display)) { $display = $member->display; }else { $display = 'N'; }
							if(isset($member->display) && !empty($member->hsn_sac_code)) { $hsn_sac_code = $member->hsn_sac_code; }else { $hsn_sac_code = ''; }

							if ($transaction_type =='indent_request' || $transaction_type =='purchase_order' || $transaction_type =='vendor_proforma_invoice') {
								$action_status='';
								if($status == 'approved'){
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
							} else {
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
							}


							$html='';
							if($status == 'pending' && $check_permission_status == 'Y'){
								$html .='&nbsp;&nbsp;&nbsp;<a class="btn btn-success btn-xs active_link_wt_approve" href="javascript:void(0);" rev="approved_bom_details" rel="'.$boq_items_id.'" title="Click here to Approved Record" data-status="Y">Approve</a>';
							}

							if($transaction_type == 'bom_upload' ||  $transaction_type == 'add_edit_bom'){
								if($upload_design_qty == $design_qty) {
									$qty_pending = $upload_design_qty;
								} else {
									$qty_pending = $upload_design_qty - abs($design_qty);
								}
							} else if($transaction_type == 'release_qty') {
								if(isset($member->released_quantity) && !empty($member->released_quantity)) { $released_quantity = $member->released_quantity; }else { $released_quantity = '0'; }
								$qty_pending = $released_quantity;
							} else if($transaction_type == 'indent_request') {
								if(isset($member->indent_quantity) && !empty($member->indent_quantity)) { $indent_quantity = $member->indent_quantity; }else { $indent_quantity = '0'; }
								$qty_pending = $indent_quantity;
							}else if($transaction_type == 'purchase_order') {
								if(isset($member->indent_quantity) && !empty($member->indent_quantity)) { $indent_quantity = $member->indent_quantity; }else { $indent_quantity = '0'; }
								$qty_pending = $indent_quantity;
							}else if($transaction_type == 'vendor_proforma_invoice') {

								if(isset($member->qty) && !empty($member->qty)) { $indent_quantity = $member->qty; }else { $qty = '0'; }
								$qty_pending = $indent_quantity;
							}

							if($gst > 0){
								$total_amount = ($rate_basic * $qty_pending);
								$gst_amount=0;
								if($total_amount > 0 && $gst > 0){
									$gst_amount =  $total_amount * ($gst/100);
								}
								$final_amount = $total_amount + $gst_amount;
							}

							if($transaction_type == 'bom_upload' ||  $transaction_type == 'add_edit_bom' || $transaction_type =='release_qty' || $transaction_type =='indent_request' || $transaction_type =='purchase_order' || $transaction_type =='vendor_proforma_invoice'){
								if(!in_array($member->bom_code,$unique_arr)){
									array_push($unique_arr,$member->bom_code);
									$data[] = array(
										$i,
										$bom_code,
										$hsn_sac_code,
										$item_description,
										$make,
										$model,
										$unit,
										$qty_pending,
										$rate_basic,
										$gst,
										sprintf('%0.2f', $final_amount),
										$action_status
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
				public function approved_pruchase_order() {

					$save_stock_arr = $update_stock_arr = $save_exceptional_arr = array();
					$loguser_id = $this->session->userData('user_id');
					$logrole_id = $this->session->userData('role_id');
					if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
						$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_pruchase_order');
						if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
							$submenu_id = $submenu_data->submenu_id;
							$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
							if(isset($check_permission) && !empty($check_permission)){

								$project_id = $this->input->post('project_id');
								$boq_code = $this->input->post('boq_code');
								$a_status = $this->input->post('status');
								$transaction_id = $this->input->post('id');

								if(isset($project_id) && !empty($project_id)){
									$project_id = base64_decode($project_id);
								}
								$qr_array = array('project_id' =>$project_id,'transaction_id' => $transaction_id);
								$bom_items_data = $this->common_model->selectDetailsWhereArr('tbl_purchase_order',$qr_array);

								if(isset($bom_items_data) && !empty($bom_items_data)){
									foreach ($bom_items_data as $key => $bom_items) {
										if(isset($bom_items->status) && !empty($bom_items->status) && $bom_items->status !='approved'){
											if(isset($bom_items->id) && !empty($bom_items->id)) { $id = $bom_items->id; }else { $id = 0; }
											if(isset($bom_items->project_id) && !empty($bom_items->project_id)) { $project_id = $bom_items->project_id; }else { $project_id = 0; }
											if(isset($bom_items->boq_code) && !empty($bom_items->boq_code)) { $boq_code = $bom_items->boq_code; }else { $boq_code = ''; }
											if(isset($bom_items->po_quantity) && !empty($bom_items->po_quantity)) { $po_quantity = $bom_items->po_quantity; }else { $po_quantity = ''; }
											if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }


											if(isset($bom_items->transaction_id) && !empty($bom_items->transaction_id)) { $transaction_id = $bom_items->transaction_id; }else { $transaction_id = 0; }
											$check_bom_stock_details = $this->admin_model->check_bom_stock_details($bom_items->project_id, $boq_code, $bom_items->bom_code);
											// $qty = $chk_design_qty - abs($o_design_qty);

											$db_total_stock = 0;
											$db_release_stock = 0;
											$db_dc_total_stock = 0;
											$db_dc_stock = 0;

											if(isset($check_bom_stock_details) && !empty($check_bom_stock_details)) {

												$po_stock = $check_bom_stock_details->po_stock;
												$pending_po_stock = $po_stock - abs($po_quantity);

												$update_stock_arr[] = array(
													'boq_code'=>$boq_code,
													'bom_code'=>$bom_code,
													// 'release_stock'=> $update_qty,
													'po_stock'=> $pending_indent_stock,
													'updated_by'=>$loguser_id,
													'updated_date'=>date('Y-m-d H:i:s')
												);
											}

											if($a_status =='approved') {

												$data = array('status'=>'approved','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
												$this->common_model->updateDetails('tbl_purchase_order','id',$id,$data);

												if(isset($update_stock_arr) && !empty($update_stock_arr)){
													$this->common_model->updateBOMStock($update_stock_arr,$project_id,$boq_code);
												}
											} else {
												$data = array('status'=>'reject','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
												$this->common_model->updateDetails('tbl_purchase_order','	id',$id,$data);
											}
										}
									}

									if($a_status =='approved') {

										if(isset($transaction_id) && !empty($transaction_id) && $transaction_id > 0){
											$dataTrans = array('status'=>'approved','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
											$this->common_model->updateDetails('tbl_bom_transactions','id',$transaction_id,$dataTrans);
										}
									} else {
										if(isset($transaction_id) && !empty($transaction_id) && $transaction_id > 0){
											$dataTrans = array('status'=>'reject','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
											$this->common_model->updateDetails('tbl_bom_transactions','id',$transaction_id,$dataTrans);
										}
									}
									$this->json->jsonReturn(array(
										'valid'=>TRUE,
										'msg'=>'<div class="alert modify alert-success">Purchase Order Request status changed Successfully!</div>'
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
				public function get_po_bom_detail(){

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
					$boq_code = $this->input->post('boq_code');
					if(isset($boq_code) && !empty($boq_code)){
						$boq_code = $boq_code;
					}


					$status_txtpost = $this->input->post('status');
					if(isset($status_txtpost) && !empty($status_txtpost)){
						$status_txt = $status_txtpost;
					}else{
						$status_txt = '';
					}
					$project_data = $this->common_model->selectAllWhr('tbl_projects','project_id',$project_id);

					$memData = $this->admin_model->getViewBomPOListRows($_POST,$project_id,$transaction_id,$boq_code,$status_txt);
					$is_billing_inter_state = $this->admin_model->is_billing_inter_state($project_id);
					$bom_data = [];
					$fAmount = 0;
					$fcgst_amount = 0;
					$fsgst_amount = 0;
					$figst_amount = 0;
					$ftotal_amount = 0;
					$cgst = 0 ;
					$sgst = 0 ;
					$igst = 0;


					$unique_arr = [];
					$unique_bom_items = [];

					if (isset($memData) && !empty($memData)) {

						foreach ($memData as $bom_item) {
							if (!in_array($bom_item->bom_code, $unique_arr)) {
								$unique_arr[] = $bom_item->bom_code;
								$unique_bom_items[] = $bom_item;
							}
						}
					}

					foreach ($unique_bom_items as $key => $value) {
						$gst = rtrim($value->gst, '%');
						if ($is_billing_inter_state == "Y") {
							$cgst = 0 ;
							$sgst = 0 ;
							$igst = $gst;
						}else{
							$cgst = $gst / 2 ;
							$sgst = $gst / 2 ;
							$igst = 0;
						}
						$indent_quantity = $value->indent_quantity;
						$rate_basic = number_format((float)$value->rate_basic, 2, '.', '');
						$amount = $indent_quantity * $rate_basic;
						$amount = number_format((float)$amount, 2, '.', '');

						$cgst_amount = ($amount * $cgst) / 100;
						$sgst_amount = ($amount * $sgst) / 100;
						$igst_amount = ($amount * $igst) / 100;
						$total_amount = ($amount) + $cgst_amount + $sgst_amount + $igst_amount;

						$po_date_time = $value->created_on;
						$date = new DateTime($po_date_time);
						$po_date = $date->format('Y-m-d');

						$row = [
							'bom_items_id' => $value->bom_items_id,
							'project_id' => $value->project_id,
							'boq_code' => $value->boq_code,
							'bom_code' => $value->bom_code,
							'hsn_sac_code' => $value->hsn_sac_code,
							'item_description' => $value->item_description,
							'unit' => $value->unit,
							'scheduled_qty' => $value->scheduled_qty,
							'design_qty' => $value->design_qty,
							'upload_design_qty' => $value->upload_design_qty,
							'o_design_qty' => $value->o_design_qty,
							'rate_basic' => $value->rate_basic,
							'gst' => $value->gst,
							'make' => $value->make,
							'model' => $value->model,
							'terms_and_condition' => $value->terms_and_condition,
							'approval_trans_id' => $value->approval_trans_id,
							'bp_code' => $value->bp_code,
							'is_billing_inter_state' => $value->is_billing_inter_state,
							'indent_quantity' => $value->indent_quantity,
							'po_number' => $value->po_number,
							'vendor_category' => $value->vendor_category,
							'vendor_id' => $value->vendor_id,
							'status' => $value->status,
							'transaction_id' => $value->transaction_id,
							'display' => $value->display,
							'po_date' => $po_date,
							'amount' => number_format((float)$amount, 2, '.', ''),
							'cgst' => $cgst."%",
							'sgst' => $sgst."%",
							'igst' => $igst."%",
							'cgst_amount' => number_format((float)$cgst_amount, 2, '.', ''),
							'sgst_amount' => number_format((float)$sgst_amount, 2, '.', ''),
							'igst_amount' => number_format((float)$igst_amount, 2, '.', ''),
							'total_amount' => number_format((float)$total_amount, 2, '.', '')
						];

						$bom_data[] = $row;
						$fAmount += number_format((float)$amount, 2, '.', '');
						$fcgst_amount += number_format((float)$cgst_amount, 2, '.', '');
						$fsgst_amount += number_format((float)$sgst_amount, 2, '.', '');
						$figst_amount += number_format((float)$igst_amount, 2, '.', '');
						$ftotal_amount += number_format((float)$total_amount, 2, '.', '');
					}

					$vendor_ids = array_unique(array_column($bom_data, 'vendor_id'));

					$vendor_ids_str = implode(',', $vendor_ids);

					$vendor_info = $this->admin_model->getVendorDetail($vendor_ids_str);

					$response['bom_data'] = $bom_data;
					$response['vendor_data'] = $vendor_info[0] ?? [];
					$response['fAmount'] = $fAmount;
					$response['fcgst_amount'] = $fcgst_amount;
					$response['fsgst_amount'] = $fsgst_amount;
					$response['figst_amount'] = $figst_amount;
					$response['ftotal_amount'] = $ftotal_amount;
					$response['project_data'] = $project_data['0'];

					echo json_encode($response);
					exit;
				}

				public function generatePo(){


					$input_params = [
						"transaction_id" =>$this->input->get('transaction_id'),
						"transaction_type" =>$this->input->get('type'),
						"project_id" =>$this->input->get('project_id'),
						"boq_code"=>"",
						"status"=>$this->input->get('status')

					];
					$po_data = $this->get_po_data($input_params);
					$path = dirname(dirname(__DIR__)) . "/public/uploads/compan.pdf";
					$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
					$pdf->SetMargins(4, 7, 4, 4);
					// set document information
					$pdf->SetCreator(PDF_CREATOR);
					// remove default header/footer
					$pdf->setPrintHeader(false);
					$pdf->setPrintFooter(false);
					$pdf->SetAutoPageBreak(false);
					// set font
					$pdf->SetFont('helvetica', '', 10);
					// add a page
					$pdf->AddPage();
					// pr($data,1);
					// $html = $this->smarty->fetch('po_item_download', $data);
					$html = $this->load->view('po_item_download.tpl', $po_data, true);
					// pr($html,1);
					// $pdf->setCellPaddings( $left = '', $top = '2px', $right = '', $bottom = '2px');
					$pdf->writeHTML($html, true, 0, true, 0);
					// $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
					$pdf->Output("purchase_order.pdf", 'D');
				}
				public function get_po_data($input_params = array()){
					$transaction_id = $input_params['transaction_id'];
					if(isset($transaction_id) && !empty($transaction_id)){
						$transaction_id = $transaction_id;
					}
					$transaction_type = $input_params['transaction_type'];
					if(isset($transaction_type) && !empty($transaction_type)){
						$transaction_type = $transaction_type;
					}
					$project_id = $input_params['project_id'];
					if(isset($project_id) && !empty($project_id)){
						$project_id = base64_decode($project_id);
					}
					$boq_code = $input_params['boq_code'];
					if(isset($boq_code) && !empty($boq_code)){
						$boq_code = $boq_code;
					}


					$status_txtpost = $input_params['status'];
					if(isset($status_txtpost) && !empty($status_txtpost)){
						$status_txt = $status_txtpost;
					}else{
						$status_txt = '';
					}
					$project_data = $this->common_model->selectAllWhr('tbl_projects','project_id',$project_id);

					$memData = $this->admin_model->getViewBomPOListRows($_POST,$project_id,$transaction_id,$boq_code,$status_txt);
					$is_billing_inter_state = $this->admin_model->is_billing_inter_state($project_id);
					$bom_data = [];
					$fAmount = 0;
					$fcgst_amount = 0;
					$fsgst_amount = 0;
					$figst_amount = 0;
					$ftotal_amount = 0;
					$cgst = 0 ;
					$sgst = 0 ;
					$igst = 0;


					$unique_arr = [];
					$unique_bom_items = [];

					if (isset($memData) && !empty($memData)) {

						foreach ($memData as $bom_item) {
							if (!in_array($bom_item->bom_code, $unique_arr)) {
								$unique_arr[] = $bom_item->bom_code;
								$unique_bom_items[] = $bom_item;
							}
						}
					}
					foreach ($unique_bom_items as $key => $value) {
						$gst = rtrim($value->gst, '%');
						if ($is_billing_inter_state == "Y") {
							$cgst = 0 ;
							$sgst = 0 ;
							$igst = $gst;
						}else{
							$cgst = $gst / 2 ;
							$sgst = $gst / 2 ;
							$igst = 0;
						}


						$indent_quantity = $value->indent_quantity;
						$rate_basic = number_format((float)$value->rate_basic, 2, '.', '');
						$amount = $indent_quantity * $rate_basic;
						$amount = number_format((float)$amount, 2, '.', '');

						$cgst_amount = ($amount * $cgst) / 100;
						$sgst_amount = ($amount * $sgst) / 100;
						$igst_amount = ($amount * $igst) / 100;
						$total_amount = ($amount) + $cgst_amount + $sgst_amount + $igst_amount;

						$po_date_time = $value->created_on;
						$date = new DateTime($po_date_time);
						$po_date = $date->format('Y-m-d');

						$row = [
							'bom_items_id' => $value->bom_items_id,
							'project_id' => $value->project_id,
							'boq_code' => $value->boq_code,
							'bom_code' => $value->bom_code,
							'hsn_sac_code' => $value->hsn_sac_code,
							'item_description' => $value->item_description,
							'unit' => $value->unit,
							'scheduled_qty' => $value->scheduled_qty,
							'design_qty' => $value->design_qty,
							'upload_design_qty' => $value->upload_design_qty,
							'o_design_qty' => $value->o_design_qty,
							'rate_basic' => $value->rate_basic,
							'gst' => $value->gst,
							'make' => $value->make,
							'model' => $value->model,
							'terms_and_condition' => $value->terms_and_condition,
							'approval_trans_id' => $value->approval_trans_id,
							'bp_code' => $value->bp_code,
							'is_billing_inter_state' => $value->is_billing_inter_state,
							'indent_quantity' => $value->indent_quantity,
							'po_number' => $value->po_number,
							'vendor_category' => $value->vendor_category,
							'vendor_id' => $value->vendor_id,
							'status' => $value->status,
							'transaction_id' => $value->transaction_id,
							'display' => $value->display,
							'po_date' => $po_date,
							'amount' => number_format((float)$amount, 2, '.', ''),
							'cgst' => $cgst."%",
							'sgst' => $sgst."%",
							'igst' => $igst."%",
							'cgst_amount' => number_format((float)$cgst_amount, 2, '.', ''),
							'sgst_amount' => number_format((float)$sgst_amount, 2, '.', ''),
							'igst_amount' => number_format((float)$igst_amount, 2, '.', ''),
							'total_amount' => number_format((float)$total_amount, 2, '.', '')
						];


						$bom_data[] = $row;


						$fAmount += number_format((float)$amount, 2, '.', '');
						$fcgst_amount += number_format((float)$cgst_amount, 2, '.', '');
						$fsgst_amount += number_format((float)$sgst_amount, 2, '.', '');
						$figst_amount += number_format((float)$igst_amount, 2, '.', '');
						$ftotal_amount += number_format((float)$total_amount, 2, '.', '');
					}


					$vendor_ids = array_unique(array_column($bom_data, 'vendor_id'));

					$vendor_ids_str = implode(',', $vendor_ids);

					$vendor_info = $this->admin_model->getVendorDetail($vendor_ids_str);

					$response['bom_data'] = $bom_data;
					$response['vendor_data'] = $vendor_info[0] ?? [];
					$response['fAmount'] = $fAmount;
					$response['fcgst_amount'] = $fcgst_amount;
					$response['fsgst_amount'] = $fsgst_amount;
					$response['figst_amount'] = $figst_amount;
					$response['ftotal_amount'] = $ftotal_amount;
					$response['project_data'] = $project_data['0'];

					return $response;

				}


				// ______________________________vendor_proforma_invoice ______________________________




				public function vendor_proforma_invoice()
				{
					$po_number = base64_decode($_GET['po']);
					$po_details=$this->common_model->selectAllWhr('tbl_purchase_order','po_number',$po_number);
					$project_item_data = $this->admin_model->getProjectItem($po_details[0]->project_id);
					$po_item_details=$this->admin_model->getPerformaInvoicePerviousItem($po_number);
					$project_item_data_arr = [];
					foreach($po_item_details as $key=>$val){
						$po_item_arr[$val['bom_code']] += $val['qty'];
						$po_item_rate_arr[$val['bom_code']] += $val['rate'];
					}

					$project_item_basic_rate = array_column($project_item_data,"rate_basic","bom_code");
					$item_description =  array_column($project_item_data,"item_description","bom_code");
					$item_hsn_sac_code =  array_column($project_item_data,"hsn_sac_code","bom_code");
					$item_unit =  array_column($project_item_data,"unit","bom_code");
					$item_gst =  array_column($project_item_data,"gst","bom_code");
					$item_model =  array_column($project_item_data,"model","bom_code");
					$item_make =  array_column($project_item_data,"make","bom_code");
					$po_items = [];

					foreach($po_details as $key=>$val){
						// pr($val);
						$item_makes = explode("/",$item_make[$val->bom_code]);
						$make_slect_opt = "<option value='".$item_make[$val->bom_code]."' >Select Make</option>";
						foreach($item_makes as $vals){
							if($vals == $val->make){
								$make_slect_opt .= "<option value='".$vals."' selected>".$vals."</option>";
							}else{
								$make_slect_opt .= "<option value='".$vals."'>".$vals."</option>";
							}
						}
						$item_models = explode("/",$item_model[$val->bom_code]);
						$model_slect_opt = "<option value='".$item_make[$val->bom_code]."' >Select Model</option>";
						foreach($item_models as $vals){
							if($vals == $val->model){
								$model_slect_opt .= "<option value='".$vals."' selected>".$vals."</option>";
							}else{
								$model_slect_opt .= "<option value='".$vals."'>".$vals."</option>";
							}
						}
						$total_qty = number_format((float)$val->po_quantity, 2, '.', '') - number_format((float)$po_item_arr[$val->bom_code], 2, '.', '') ;
						$basic_rate = $project_item_basic_rate[$val->bom_code] * $total_qty;
						$gst_total = (1 + $item_gst[$val->bom_code] / 100);
						$total_amount = number_format(round($project_item_basic_rate[$val->bom_code] *  $total_qty * $gst_total, 2), 2, '.', '');


						if($total_qty > 0){
							$po_items[] =
							[
								'sr_no' => $key+1,
								'req_qty' => $total_qty,
								'boq_code' =>  $val->boq_code,
								'bom_code' =>  $val->bom_code,
								'bom_item_description' => $item_description[$val->bom_code],
								'hsn_sac_code' => $item_hsn_sac_code[$val->bom_code],
								'bom_unit' => $item_unit[$val->bom_code],
								'bom_make' =>$val->make,
								'bom_model' => $val->model,
								'bom_avl_stock' =>  $total_qty,
								'bom_req_stock' => $total_qty,
								'rate_basic' => $project_item_basic_rate[$val->bom_code],
								'bom_gst' => $item_gst[$val->bom_code],
								'amount' => $total_amount,
								"make_opt" => $make_slect_opt,
								"model_opt" => $model_slect_opt
							];
						}
					}

					$data['po_items'] = $po_items;
					$common_data = [
						'transaction_id' => $po_details[0]->transaction_id,
						'po_number' => $po_details[0]->po_number,
						'project_id' => $po_details[0]->project_id,
						'category_id' => $po_details[0]->vendor_category,
						'vendor_id' => $po_details[0]->vendor_id,
						'terms_and_condition' => $po_details[0]->terms_and_condition,
						'remark' => $po_details[0]->remark,
					];

					$vendor_data = $this->admin_model->getVendorDetail($common_data['vendor_id']);
					$category_data = $this->admin_model->getCategoryDetails($common_data['category_id']);
					$transaction_data = $this->common_model->selectDetailsWhr('tbl_bom_transactions','id',$common_data['transaction_id']);
					$project_data=$this->common_model->selectDetailsWhr('tbl_projects','project_id',$common_data['project_id']);
					$data['po_details'] = $po_details;
					$data['category_data'] = $category_data[0];
					$data['vendor_data'] = $vendor_data[0];
					$data['transaction_data']= $transaction_data;
					$data['project_data'] = $project_data;
					$data['common_data'] = $common_data;

					$this->load->view('vendor-proforma-invoice',$data);
				}
				public function save_proforma_invovce(){


					$loguser_id = $this->session->userData('user_id');
					$logrole_id = $this->session->userData('role_id');

					if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)) {
						$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','vendor_proforma_invoice_add');
						if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
							$submenu_id = $submenu_data->submenu_id;
							$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
							if(isset($check_permission) && !empty($check_permission)){
								$error = 'N';
								$error_message = '';
								if(isset($loguser_id) && empty($loguser_id)){
									$error = 'Y';
									$error_message = 'Please loggedin!';
								}



								$bom_code = $this->input->post('bom_code');
								if(isset($bom_code) && !empty($bom_code)) { $bom_code = $bom_code; } else { $bom_code=''; }
								if(isset($bom_code) && empty($bom_code)){
									$error = 'Y';
									$error_message = 'BOM Sr No is empty!';
								}
								$rate_basic =  $this->input->post('rate_basic');
								$bom_req_stock =  $this->input->post('bom_req_stock');
								foreach($bom_code as $key=>$val){
									if(!($bom_req_stock[$key] > 0)){
										$error = 'Y';
										$error_message = 'Required Qty empty!';
									}
									if(!($rate_basic[$key] > 0)){
										$error = 'Y';
										$error_message = 'Basic Rate empty!';
									}
								}

								if($error == 'N'){
									$transaction_insert_arr = [
										"project_id"=> $this->input->post('project_id_val'),
										"event_name" => "Proforma Invoice",
										"event_type"=>"vendor_proforma_invoice",
										"created_by"=>$loguser_id,
										"created_date"=>date("Y-m-d H:i:s"),
										"display"=>"Y",
										"status"=>"pending"
									];
									$transaction_insert_id = $this->admin_model->SavePerformaInvoiceTransaction($transaction_insert_arr);
									$performa_invoice_count = count($this->admin_model->getPerformaInvoiceCount());
									$financial_year = $this->getFinancialYear();
									$performa_invoice_number = "PI/" . $financial_year . "/" . ($performa_invoice_count + 1);

									$performa_invoice_insert_arr = [
										"project_id" => $this->input->post('project_id_val') ,
										"proforma_no" =>$performa_invoice_number,
										"invoice_date" =>date("Y-m-d H:i:s"),
										"terms_and_condition" =>$this->input->post('terms_and_condition') ,
										"remark" =>$this->input->post('remark') ,
										"created_by"=>$loguser_id,
										"created_on"=>date("Y-m-d H:i:s"),
										"display" => "Y",
										"status" => "pending",
										"Converted" => "Y",
										"po_number"=>$this->input->post('po_number'),
										"transaction_id" =>$transaction_insert_id
									];

									$performa_invoice_insert_id = $this->admin_model->SavePerformaInvoiceCount($performa_invoice_insert_arr);
									$bom_unit_arr =  $this->input->post('bom_unit');
									$bom_hsn_sac_code_arr =  $this->input->post('hsn_sac_code');
									$bom_make_arr =  $this->input->post('bom_make');
									$bom_model_arr =  $this->input->post('bom_model');
									$amount_arr =  $this->input->post('amount');
									$bom_gst_arr =  $this->input->post('bom_gst');
									$bom_item_description_arr =  $this->input->post('bom_item_description');
									$item_details_arr = [];

									foreach($bom_code as $key=>$val){

										$item_details_arr[] = [
											"proforma_id" => $performa_invoice_insert_id,
											"boq_code"=>"",
											"bom_code"=>$val,
											"item_description"=>$bom_item_description_arr[$key],
											"hsn_code"=>$bom_hsn_sac_code_arr[$key],
											"unit"=>$bom_unit_arr[$key],
											"qty"=>$bom_req_stock[$key],
											"rate"=>$rate_basic[$key],
											"make"=>$bom_make_arr[$key],
											"model"=>$bom_model_arr[$key],
											"total_amount"=>$amount_arr[$key],
											"gst"=>$bom_gst_arr[$key],
											"created_by"=>$loguser_id,
											"created_on"=>date("Y-m-d H:i:s"),
											"display" => 'Y',
											"status"=>"pending"
										];
									}

									$performa_invoice_insert_id = $this->admin_model->SavePerformaInvoiceItem($item_details_arr);

									if($performa_invoice_insert_id > 0){
										$this->json->jsonReturn(array(
											'valid'=>TRUE,
											'msg'=>'<div class="alert modify alert-success">Vendor Proforma Invoice send Successfully!</div>',
											// 			'redirect' => base_url().'vendor_proforma_invoice?po='.base64_encode($this->input->post('po_number')),
											'redirect' => base_url().'vendor_proforma_invoice',
										));
									}else{
										$this->json->jsonReturn(array(
											'valid'=>FALSE,
											'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong>Something went wrong</div>'
										));
									}

								}else{
									$this->json->jsonReturn(array(
										'valid'=>FALSE,
										'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong>'.$error_message.'</div>'
									));
								}
							} else {
								$this->json->jsonReturn(array(
									'valid'=>FALSE,
									'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
								));
							}
						}
					}
				}
				public function view_vendor_proforma_invoice($project_id) {
					$id = $this->uri->segment(2);
					if(isset($id) && !empty($id)){
						$project_id = base64_decode($id);
					}

					$bp_code = $this->admin_model->get_bp_code($id);
					$data['bp_code'] = $bp_code;
					$data['project_id_encode'] = $project_id;
					$data['project_id_encode'] = $id;
					$data['project_id'] = $project_id;
					$this->load->view('view-vendor-proforma-invoice',$data);
				}

				public function get_vendor_proforma_invoice_list() {
					$page_type = $this->input->get("type");
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
							$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_pruchase_order');
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
							$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','vendor_proforma_invoice_add');
							if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
								$submenu_id = $submenu_data->submenu_id;
								$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
								if(isset($check_permission) && !empty($check_permission)){
									$check_permission_edit = 'Y';
								}
							}
						}

						$data = $row = array();

						$memData = $this->admin_model->getBOMTransactionIndentListRows($_POST,$project_idpost,'vendor_proforma_invoice');

						$allCount = $this->admin_model->getBOMTransactionIndentListAll($project_idpost,'vendor_proforma_invoice');
						$countFiltered = $this->admin_model->getBOMTransactionIndentFiltered($_POST,$project_idpost,'vendor_proforma_invoice');

						$po_amount = 0;
						$filter = 'original';
						$i = $_POST['start'];
						foreach($memData as $member){
							$vpiData =[];
							if ($member->event_type == 'vendor_proforma_invoice') {
								$vendorPerformaInvoiceInfo = $this->admin_model->getVendorPerformaInvoiceInfo($member->project_id,$member->id);
								$vpiData = $vendorPerformaInvoiceInfo[0];

							}

							$i++;
							if(isset($member->id) && !empty($member->id)) { $id = $member->id; }else { $id = '0'; }
							if(isset($vpiData->po_number) && !empty($vpiData->po_number)) { $po_number = $vpiData->po_number; }else { $po_number = '-'; }
							if(isset($vpiData->proforma_no) && !empty($vpiData->proforma_no)) { $proforma_no = $vpiData->proforma_no; }else { $proforma_no = '-'; }
							if(isset($vpiData->name_of_company) && !empty($vpiData->name_of_company)) { $vendor_name = $vpiData->name_of_company; }else { $vendor_name = '-'; }
							if(isset($vpiData->total_amount) && !empty($vpiData->total_amount)) { $pi_amount = $vpiData->total_amount; }else { $pi_amount = '-'; }

							if(isset($member->event_name) && !empty($member->event_name)) { $event_name = $member->event_name; }else { $event_name = '-'; }
							if(isset($member->event_type) && !empty($member->event_type)) { $event_type = $member->event_type; }else { $event_type = '-'; }
							if(isset($member->project_id) && !empty($member->project_id)) { $project_id = $member->project_id; }else { $project_id = '-'; }
							if(isset($member->created_date) && !empty($member->created_date)) { $created_at = $member->created_date; }else { $created_at = '-'; }
							if(isset($member->status) && !empty($member->status)) { $status = $member->status; }else { $status = '-'; }
							if(isset($member->bp_code) && !empty($member->bp_code)) { $bp_code = $member->bp_code; }else { $bp_code = '-'; }
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
							$action = '';

							if($page_type != 'vendor_proforma_invoice_listing'){
								$action .='<a href="javascript:void(0);" title="Download Po" data-project_id="'.base64_encode($project_id).'" data-boq_code="" data-type="'.$event_type.'" data-status="'.$status.'"  data-transaction_id="'.$id.'" class="download-po" style="margin-right: 8px;"><i class="fa fa-download" style="color:#000; font-size:15px;"></i></a>';
								$open_doc_url = $this->config->item("base_url")."generate_vpi_pdf?project_id=".base64_encode($project_id)."&type=".$event_type."&status=".$status."&transaction_id=".$id."";
								$action .='<a class="Invoice" href="'.$open_doc_url.'" data-project_id="'.base64_encode($project_id).'" data-boq_code="" data-type="'.$event_type.'" data-status="'.$status.'"  data-id="'.$id.' " style="margin-right: 8px;"><i class="fa fa-file-text" style="color:#000; font-size:15px;"></i></a>';
							}
							$action .='<a class=" openview" href="javascript:void(0);" data-project_id="'.base64_encode($project_id).'" data-boq_code="" data-type="'.$event_type.'" data-status="'.$status.'"  data-id="'.$id.'" style="margin-right: 8px;">VIEW</a>';

							if($status =='approved' && $page_type != 'vendor_proforma_invoice_listing'){
								$action .= '<a class="popup_save me-2" href="' . base_url() . 'payment_receipt?ppi=' . base64_encode($vpiData->proforma_id). '" data-project_id="' . base64_encode($project_id) . '" data-boq_code="" data-type="' . $event_type . '" data-status="' . $status . '" data-transaction_id="' . $id . '" title="Convert To Payment Receipt" data-status="allow" style="margin-right: 8px;"><img src="' . base_url() . 'uploads/images/payment_receipt.png" width="20px" height="20px"></a>';

								// $action .= '<a class="popup_save me-2" href="javascript:void(0);" data-project_id="' . base64_encode($project_id) . '" data-boq_code="" data-type="' . $event_type . '" data-status="' . $status . '" data-transaction_id="' . $id . '" title="Convert To Tax" data-status="allow" style="margin-right: 8px;"><img src="' . base_url() . 'uploads/images/payment_receipt.png" width="20px" height="20px"></a>';
							}elseif($status =='reject' && $page_type != 'vendor_proforma_invoice_listing'){

								$action .='<a href="javascript:void(0);" class="editRecordVPI tooltips" rel-vpi-id="'.$vpiData->proforma_id.'" data-project-id="'.$project_id.'" title="Edit Record"  data-original-title="Edit Record"><i class="fa fa-edit" style="color:#3598dc; font-size:15px;"></i></a>';

							}
							$data[] = array(
								$i,
								$po_number,
								$proforma_no,
								$bp_code,
								$vendor_name,
								number_format((float)$pi_amount, 2, '.', ''),
								$created_by_name,
								$approved_by_name,
								$action_status,
								$action
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


				public function vpi_bom_trans_list_display()
				{

					$transaction_id= $_POST['transaction_id'];
					$memData = $this->admin_model->getViewBomVendorPIListRows($transaction_id);

					foreach ($memData as $member) {
						$i++;

						$proforma_itemid = $member->proforma_itemid ?? '-';

						$boq_code = $member->boq_code ?? '-';
						$bom_code = $member->bom_code ?? '-';
						$hsn_code = $member->hsn_code ?? '-';
						$item_description = $member->item_description ?? '-';
						$make = $member->make ?? '-';
						$model = $member->model ?? '-';
						$unit = $member->unit ?? '-';
						$rate_basic = $member->rate ?? '0';
						$gst = $member->gst ?? '0';
						$status = $member->status ?? 'N';
						$display = $member->display ?? 'N';


						$action_status = $status == 'approved' ? '<span style="color:green;font-weight:600;">Approved</span>' : '<span style="color:orange;font-weight:600;">Pending</span>';
						if ($display == 'N') {
							$action_status .= '<br><span style="color:red;font-weight:600;">Deleted</span>';
						}


						$qty_pending = $member->qty ?? '0';
						$total_amount = $rate_basic * $qty_pending;
						$gst_amount = $gst > 0 ? $total_amount * ($gst / 100) : 0;
						$final_amount = $total_amount + $gst_amount;
						$unique_arr = [];
						if (!in_array($boq_code, $unique_arr)) {
							array_push($unique_arr, $boq_code);
							$data[] = [
								$i,
								$bom_code,
								$hsn_code,
								$item_description,
								$make,
								$model,
								$unit,
								$qty_pending,
								$rate_basic,
								$gst,
								sprintf('%0.2f', $final_amount),
								$action_status
							];
						}
					}

					$output = [
						"draw" => $_POST['draw'],
						"recordsTotal" => count($memData),
						"recordsFiltered" => count($data),
						"data" => $data,
					];

					echo json_encode($output);

				}
				public function get_vendor_pi_bom_detail(){
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
					$boq_code = $this->input->post('boq_code');
					if(isset($boq_code) && !empty($boq_code)){
						$boq_code = $boq_code;
					}
					$status_txtpost = $this->input->post('status');
					if(isset($status_txtpost) && !empty($status_txtpost)){
						$status_txt = $status_txtpost;
					}else{
						$status_txt = '';
					}
					$project_data = $this->common_model->selectAllWhr('tbl_projects','project_id',$project_id);

					$memData = $this->admin_model->getViewBomVendorPIListRows($transaction_id);

					$is_billing_inter_state = $this->admin_model->is_billing_inter_state($project_id);
					$bom_data = [];
					$fAmount = 0;
					$fcgst_amount = 0;
					$fsgst_amount = 0;
					$figst_amount = 0;
					$ftotal_amount = 0;
					$cgst = 0 ;
					$sgst = 0 ;
					$igst = 0;


					$unique_arr = [];
					$unique_bom_items = [];

					if (isset($memData) && !empty($memData)) {

						foreach ($memData as $bom_item) {
							if (!in_array($bom_item->bom_code, $unique_arr)) {
								$unique_arr[] = $bom_item->bom_code;
								$unique_bom_items[] = $bom_item;
							}
						}
					}

					foreach ($unique_bom_items as $key => $value) {

						$gst = rtrim($value->gst, '%');
						if ($is_billing_inter_state == "Y") {
							$cgst = 0 ;
							$sgst = 0 ;
							$igst = $gst;
						}else{
							$cgst = $gst / 2 ;
							$sgst = $gst / 2 ;
							$igst = 0;
						}


						$qty = $value->qty;
						$rate_basic = number_format((float)$value->rate, 2, '.', '');
						$amount = $qty * $rate_basic;
						$amount = number_format((float)$amount, 2, '.', '');

						$cgst_amount = ($amount * $cgst) / 100;
						$sgst_amount = ($amount * $sgst) / 100;
						$igst_amount = ($amount * $igst) / 100;
						$total_amount = ($amount) + $cgst_amount + $sgst_amount + $igst_amount;

						$po_date_time = $value->created_on;
						$date = new DateTime($po_date_time);
						$po_date = $date->format('Y-m-d');

						$row = [
							'bom_items_id' => $value->bom_items_id,
							'project_id' => $value->project_id,
							'boq_code' => $value->boq_code,
							'bom_code' => $value->bom_code,
							'hsn_sac_code' => $value->hsn_code,
							'item_description' => $value->item_description,
							'unit' => $value->unit,
							'qty' => $value->qty,
							'rate_basic' => $value->rate,
							'gst' => $value->gst,
							'make' => $value->make,
							'model' => $value->model,
							'terms_and_condition' => $value->terms_and_condition,
							'approval_trans_id' => $value->approval_trans_id,
							'bp_code' => $value->bp_code,
							'is_billing_inter_state' => $value->is_billing_inter_state,
							'proforma_no' => $value->proforma_no,
							'po_number' => $value->po_number,
							'vendor_category' => $value->vendor_category,
							'vendor_id' => $value->vendor_id,
							'status' => $value->status,
							'transaction_id' => $value->transaction_id,
							'display' => $value->display,
							'invoice_date' => $value->invoice_date,
							'amount' => number_format((float)$amount, 2, '.', ''),
							'cgst' => $cgst."%",
							'sgst' => $sgst."%",
							'igst' => $igst."%",
							'cgst_amount' => number_format((float)$cgst_amount, 2, '.', ''),
							'sgst_amount' => number_format((float)$sgst_amount, 2, '.', ''),
							'igst_amount' => number_format((float)$igst_amount, 2, '.', ''),
							'total_amount' => number_format((float)$total_amount, 2, '.', '')
						];


						$bom_data[] = $row;


						$fAmount += number_format((float)$amount, 2, '.', '');
						$fcgst_amount += number_format((float)$cgst_amount, 2, '.', '');
						$fsgst_amount += number_format((float)$sgst_amount, 2, '.', '');
						$figst_amount += number_format((float)$igst_amount, 2, '.', '');
						$ftotal_amount += number_format((float)$total_amount, 2, '.', '');
					}

					$po_numbers = array_unique(array_column($bom_data, 'po_number'));

					$po_number_str = implode(',', $po_numbers);
					$getVendorId = $this->admin_model->getVendorId($po_number_str);

					$vendor_ids = array_unique(array_column($getVendorId, 'vendor_id'));

					$vendor_ids_str = implode(',', $vendor_ids);

					$vendor_info = $this->admin_model->getVendorDetail($vendor_ids_str);

					$response['bom_data'] = $bom_data;
					$response['vendor_data'] = $vendor_info[0] ?? [];
					$response['fAmount'] = $fAmount;
					$response['fcgst_amount'] = $fcgst_amount;
					$response['fsgst_amount'] = $fsgst_amount;
					$response['figst_amount'] = $figst_amount;
					$response['ftotal_amount'] = $ftotal_amount;
					$response['project_data'] = $project_data['0'];

					echo json_encode($response);
					exit;
				}

				public function generateVendorPIPDF()
				{
					$input_params = [
						"transaction_id" =>$this->input->get('transaction_id'),
						"transaction_type" =>$this->input->get('type'),
						"project_id" =>$this->input->get('project_id'),
						"boq_code"=>"",
						"status"=>$this->input->get('status')

					];
					$vpi_data = $this->get_vpi_data($input_params);

					$path = dirname(dirname(__DIR__)) . "/public/uploads/compan.pdf";
					$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
					$pdf->SetMargins(4, 7, 4, 4);
					// set document information
					$pdf->SetCreator(PDF_CREATOR);
					// remove default header/footer
					$pdf->setPrintHeader(false);
					$pdf->setPrintFooter(false);
					$pdf->SetAutoPageBreak(false);
					// set font
					$pdf->SetFont('helvetica', '', 10);
					// add a page
					$pdf->AddPage();

					// $html = $this->smarty->fetch('po_item_download', $data);
					$html = $this->load->view('vendor_pi_item_download.tpl', $vpi_data, true);
					// pr($html,1);
					// $pdf->setCellPaddings( $left = '', $top = '2px', $right = '', $bottom = '2px');
					$pdf->writeHTML($html, true, 0, true, 0);
					// $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
					$pdf->Output("vendor_performa_invoice.pdf", 'D');
				}

				public function get_vpi_data($input_params = array()){
					$transaction_id = $input_params['transaction_id'];
					if(isset($transaction_id) && !empty($transaction_id)){
						$transaction_id = $transaction_id;
					}
					$transaction_type = $input_params['transaction_type'];
					if(isset($transaction_type) && !empty($transaction_type)){
						$transaction_type = $transaction_type;
					}
					$project_id = $input_params['project_id'];
					if(isset($project_id) && !empty($project_id)){
						$project_id = base64_decode($project_id);
					}
					$boq_code = $input_params['boq_code'];
					if(isset($boq_code) && !empty($boq_code)){
						$boq_code = $boq_code;
					}


					$status_txtpost = $input_params['status'];
					if(isset($status_txtpost) && !empty($status_txtpost)){
						$status_txt = $status_txtpost;
					}else{
						$status_txt = '';
					}

					$project_data = $this->common_model->selectAllWhr('tbl_projects','project_id',$project_id);

					$memData = $this->admin_model->getViewBomVendorPIListRows($transaction_id);

					$is_billing_inter_state = $this->admin_model->is_billing_inter_state($project_id);
					$bom_data = [];
					$fAmount = 0;
					$fcgst_amount = 0;
					$fsgst_amount = 0;
					$figst_amount = 0;
					$ftotal_amount = 0;
					$cgst = 0 ;
					$sgst = 0 ;
					$igst = 0;


					$unique_arr = [];
					$unique_bom_items = [];

					if (isset($memData) && !empty($memData)) {

						foreach ($memData as $bom_item) {
							if (!in_array($bom_item->bom_code, $unique_arr)) {
								$unique_arr[] = $bom_item->bom_code;
								$unique_bom_items[] = $bom_item;
							}
						}
					}

					foreach ($unique_bom_items as $key => $value) {

						$gst = rtrim($value->gst, '%');
						if ($is_billing_inter_state == "Y") {
							$cgst = 0 ;
							$sgst = 0 ;
							$igst = $gst;
						}else{
							$cgst = $gst / 2 ;
							$sgst = $gst / 2 ;
							$igst = 0;
						}


						$qty = $value->qty;
						$rate_basic = number_format((float)$value->rate, 2, '.', '');
						$amount = $qty * $rate_basic;
						$amount = number_format((float)$amount, 2, '.', '');

						$cgst_amount = ($amount * $cgst) / 100;
						$sgst_amount = ($amount * $sgst) / 100;
						$igst_amount = ($amount * $igst) / 100;
						$total_amount = ($amount) + $cgst_amount + $sgst_amount + $igst_amount;

						$po_date_time = $value->created_on;
						$date = new DateTime($po_date_time);
						$po_date = $date->format('Y-m-d');

						$row = [
							'bom_items_id' => $value->bom_items_id,
							'project_id' => $value->project_id,
							'boq_code' => $value->boq_code,
							'bom_code' => $value->bom_code,
							'hsn_sac_code' => $value->hsn_code,
							'item_description' => $value->item_description,
							'unit' => $value->unit,
							'qty' => $value->qty,
							'rate_basic' => $value->rate,
							'gst' => $value->gst,
							'make' => $value->make,
							'model' => $value->model,
							'terms_and_condition' => $value->terms_and_condition,
							'approval_trans_id' => $value->approval_trans_id,
							'bp_code' => $value->bp_code,
							'is_billing_inter_state' => $value->is_billing_inter_state,
							'proforma_no' => $value->proforma_no,
							'po_number' => $value->po_number,
							'vendor_category' => $value->vendor_category,
							'vendor_id' => $value->vendor_id,
							'status' => $value->status,
							'transaction_id' => $value->transaction_id,
							'display' => $value->display,
							'invoice_date' => $value->invoice_date,
							'amount' => number_format((float)$amount, 2, '.', ''),
							'cgst' => $cgst."%",
							'sgst' => $sgst."%",
							'igst' => $igst."%",
							'cgst_amount' => number_format((float)$cgst_amount, 2, '.', ''),
							'sgst_amount' => number_format((float)$sgst_amount, 2, '.', ''),
							'igst_amount' => number_format((float)$igst_amount, 2, '.', ''),
							'total_amount' => number_format((float)$total_amount, 2, '.', '')
						];


						$bom_data[] = $row;


						$fAmount += number_format((float)$amount, 2, '.', '');
						$fcgst_amount += number_format((float)$cgst_amount, 2, '.', '');
						$fsgst_amount += number_format((float)$sgst_amount, 2, '.', '');
						$figst_amount += number_format((float)$igst_amount, 2, '.', '');
						$ftotal_amount += number_format((float)$total_amount, 2, '.', '');
					}

					$po_numbers = array_unique(array_column($bom_data, 'po_number'));

					$po_number_str = implode(',', $po_numbers);
					$getVendorId = $this->admin_model->getVendorId($po_number_str);

					$vendor_ids = array_unique(array_column($getVendorId, 'vendor_id'));

					$vendor_ids_str = implode(',', $vendor_ids);

					$vendor_info = $this->admin_model->getVendorDetail($vendor_ids_str);

					$response['bom_data'] = $bom_data;
					$response['vendor_data'] = $vendor_info[0] ?? [];
					$response['fAmount'] = $fAmount;
					$response['cgst'] = $cgst."%";
					$response['sgst'] = $sgst."%";
					$response['igst'] = $igst."%";
					$response['fcgst_amount'] = $fcgst_amount;
					$response['fsgst_amount'] = $fsgst_amount;
					$response['figst_amount'] = $figst_amount;
					$response['ftotal_amount'] = $ftotal_amount;
					$response['project_data'] = $project_data['0'];

					return $response;
				}

				public function get_edit_bom_vpi_item_by_project()
				{
					$post_data = $this->input->post();

					$project_item_data = $this->admin_model->getProjectItem($post_data['project_id']);

					$performa_data = $this->admin_model->getPerformaInvoiceData($post_data['vpi_trancsaction_id']);
					$original_price_arr = [];
					$bom_code_arr = [];
					$item_model = [];
					$item_make = [];
					foreach($project_item_data as $key=>$val){
						if(!in_array($val['bom_code'],$bom_code_arr)){
							$original_price_arr[$val['bom_code']] = $val['rate_basic'];
							$bom_code_arr[] = $val['bom_code'];
							$item_make[trim($val['bom_code'])] = $val['make'];
							$item_model[trim($val['bom_code'])] = $val['model'];
						}
					}
					$po_details=$this->common_model->selectAllWhr('tbl_purchase_order','po_number',$performa_data->po_number);
					$pi_item_details=$this->admin_model->getPerformaInvoiceItem($post_data['vpi_trancsaction_id']);
					$vendor_data = $this->admin_model->getVendorDetail($po_details[0]->vendor_id);
					$category_data = $this->admin_model->getCategoryDetails($po_details[0]->vendor_category);
					$pending_qty_arr = $this->vendor_proforma_invoice_pending_Qty($performa_data->po_number);
					//                 $item_model =  array_column($project_item_data,"model","bom_code");
					// 	$item_make =  array_column($project_item_data,"make","bom_code");




					$itemData = [];
					foreach($pi_item_details as $member){
						$i++;

						if(isset($member['proforma_itemid']) && !empty($member['proforma_itemid'])) { $id = $member['proforma_itemid']; }else { $id = 0; }
						if(isset($member['bom_code']) && !empty($member['bom_code'])) { $bom_code = $member['bom_code']; }else { $bom_code = 0; }
						if(isset($member['boq_code']) && !empty($member['boq_code'])) { $boq_code = $member['boq_code']; }else { $boq_code = 0; }
						if(isset($member['item_description']) && !empty($member['item_description'])) { $item_description = $member['item_description']; }else { $item_description = '-'; }
						if(isset($member['unit']) && !empty($member['unit'])) { $unit = $member['unit']; }else { $unit = ''; }
						if(isset($member['make']) && !empty($member['make'])) { $make = $member['make']; }else { $make = ''; }
						if(isset($member->model) && !empty($member['model'])) { $model = $member['model']; }else { $model = ''; }
						if(isset($member['qty']) && !empty($member['qty'])) { $quantity =$member['qty']; }else { $quantity = ''; }
						if(isset($member['rate']) && !empty($member['rate'])) { $rate_basic =$member['rate']; }else { $rate_basic = ''; }
						if(isset($member['gst']) && !empty($member['gst'])) { $gst = $member['gst']; }else { $gst = ''; }
						if(isset($original_price_arr[$member['bom_code']]) && !empty($original_price_arr[$member['bom_code']])) { $original_price = $original_price_arr[$member['bom_code']]; }else { $original_price = 0; }

						$pending_qty = isset($pending_qty_arr[$member['bom_code']]) ? $pending_qty_arr[$member['bom_code']] : 0;
						$available_qty = $quantity + $pending_qty;


						// $finalAmount = $quantity * $basicRate * (1 + ($gst / 100));

						$amount = floatval($quantity) * floatval($rate_basic)* (1 + ($gst / 100));
						$famount = number_format($amount, 2, '.', '');
						$item_makes = explode("/",$item_make[$member['bom_code']]);
						$make_slect_opt  = "<option value='".$item_make[$member['bom_code']]."' >Select Make</option>";
						foreach($item_makes as $val){
							if($val == $make){
								$make_slect_opt .= "<option value='".$val."' selected>".$val."</option>";
							}else{
								$make_slect_opt .= "<option value='".$val."'>".$val."</option>";
							}
						}

						$item_models = explode("/",$item_model[$member['bom_code']]);
						$model_slect_opt = "<option value='".$item_model[$member['bom_code']]."' >Select Model</option>";
						foreach($item_models as $val){
							if($val == $model){
								$model_slect_opt .= "<option value='".$val."' selected>".$val."</option>";
							}else{
								$model_slect_opt .= "<option value='".$val."'>".$val."</option>";
							}
						}

						$sr_no_d = '<input type="text" class="form-control invaliderror"  name="sr_no[]" value="'. $i.'" placeholder="Sr.No" style="font-size: 12px;width:100%" readonly>';
						$bom_sr_d = '<input type="hidden" class="form-control invaliderror"  name="po_id[]" value="'. $id.'" placeholder="Sr.No" style="font-size: 12px;width:100%" readonly>';
						$bom_sr_d .= '<input type="hidden" class="js-req_qty"  name="req_qty[]" value="'.$indent_stock.'" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>';
						$bom_sr_d .= '<input type="hidden" class="js-boq_code"  name="boq_code[]" value="'.$boq_code.'" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>
						<input type="text" class="form-control invaliderror js-bom_sr_no"  name="bom_code[]" value="'.$bom_code.'" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly>';
						$bom_item_d = '<input type="text" class="form-control invaliderror"  name="bom_item_description[]" value="'.$item_description.'" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>';
						$bom_unit_d = '<input type="text" class="form-control invaliderror"  name="bom_unit[]" value="'.$unit.'" placeholder="Item Description" style="font-size: 12px;width:100%" readonly>';
						$bom_make_d = '<select  class="form-control bom_make"  name="bom_make[]">'.$make_slect_opt.'</select>';
						$bom_model_d = '<select  class="form-control bom_model"  name="bom_model[]">'.$model_slect_opt.'</select>';
						$bom_indent_d = '<input type="text" class="form-control invaliderror po-avilable-stock"  name="bom_avl_stock[]" value="'.$available_qty.'" placeholder="Available Qty" style="font-size: 12px;width:100%" readonly>';
						$bom_required_d = '<input type="text" class="form-control invaliderror js-requires-po-qty"  name="bom_req_stock[]" value="'.$quantity.'" placeholder="Required Qty" style="font-size: 12px;width:100%">';
						$bom_basic_rate = '
						<input type="hidden" class="form-control  basic_rate " name="basic_rate[]" value="'.$original_price.'" placeholder="" style="font-size: 12px;width:100%">
						<input type="text" class="form-control invaliderror js-po-basic_rate " id="js-required-qty" name="rate_basic[]" value="'.$rate_basic.'" placeholder="Required Qty" style="font-size: 12px;width:100%" >';
						$bom_gst = '<input type="text" class="form-control invaliderror " name="bom_gst[]" value="'.$gst.'" placeholder="Required gst" style="font-size: 12px;width:100%" readonly>';
						$bom_amount = '<input type="text" class="form-control invaliderror " id="js-required-qty" name="amount[]" value="'.$famount.'" placeholder="Required Qty" style="font-size: 12px;width:100%" readonly>';

						$itemData[] = array(
							$sr_no_d,
							$bom_sr_d,
							$bom_item_d,
							$bom_unit_d,
							$bom_make_d,
							$bom_model_d,
							$bom_indent_d,
							$bom_required_d,
							$bom_basic_rate,
							$bom_gst,
							$bom_amount,
						);


					}

					$data['po_number'] = $performa_data->po_number;
					$data['category'] = $category_data[0]->category_name;
					$data['project_name'] = $performa_data->project_name;
					$data['gst_registration_no'] = $vendor_data[0]->gst_registration_no;
					$data['vendor_name'] = $vendor_data[0]->name_of_company;
					$data['address'] = $vendor_data[0]->reg_house_building_no." ".$vendor_data[0]->reg_street." ".$vendor_data[0]->reg_city_post_code." ".$vendor_data[0]->reg_state;
					$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => 2,
						"recordsFiltered" => 2,
						"data" => $itemData,
						"transaction_id"=>$performa_data->transaction_id,
						'po_number' => $performa_data->po_number,
						'project_name' => $performa_data->project_name,
						'vendor' => $vendor_data[0]->name_of_company,
						'address' => $vendor_data[0]->reg_house_building_no." ".$vendor_data[0]->reg_street." ".$vendor_data[0]->reg_city_post_code." ".$vendor_data[0]->reg_state,
						'category_name' =>  $category_data[0]->category_name,
						'gst_registration_no'=> $vendor_data[0]->gst_registration_no,
						'performa_invoice_id'=>$post_data['vpi_trancsaction_id'],
						"terms_and_condition" => $performa_data->terms_and_condition,
						"remark" => $performa_data->remark

					);
					echo json_encode($output);
				}
				public function edit_save_pi_request() {

					$loguser_id = $this->session->userData('user_id');
					$logrole_id = $this->session->userData('role_id');

					if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)) {
						$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','edit_performa_invoice');
						if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
							$submenu_id = $submenu_data->submenu_id;
							$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
							if(isset($check_permission) && !empty($check_permission)){
								$post_data = $this->input->post();

								$update_arr = [];
								$flag = true;

								foreach($post_data['bom_code'] as $key=>$val){
									$update_arr[] = [
										"proforma_itemid" => $post_data['po_id'][$key],
										"total_amount" =>$post_data['amount'][$key],
										"qty" =>$post_data['bom_req_stock'][$key],
										'rate'=>$post_data['rate_basic'][$key],
										"status" => "pending",
										"make" => $post_data['bom_make'][$key],
										"model" => $post_data['bom_model'][$key],
										"modified_by" => $loguser_id,
										"modified_on" => date('Y-m-d H:i:s')
									];
									if($post_data['bom_req_stock'][$key] <= 0){
										$flag = false;
									}
								}


								if(!$flag){
									$error = 'Y';
									$error_message = 'Required Quantity empty!';
									$this->json->jsonReturn(array(
										'valid'=>FALSE,
										'msg'=>'<div class="alert modify alert-danger">Required Quantity empty!</div>',

									));
								}else{
									$affected_row=$this->admin_model->updatePiItemListRows($update_arr);
									if($affected_row >= 0){
										$update_arr = [
											"edit_terms_and_condition" => $post_data['edit_terms_and_condition'],
											"edit_remark" => $post_data['edit_remark']
										];
										$affected_row=$this->admin_model->updatePiRows($post_data['performa_id'],$update_arr);
										$affected_row=$this->admin_model->updatePiTransactionStatus($post_data['transaction_id']);
										$this->json->jsonReturn(array(
											'valid'=>TRUE,
											'msg'=>'<div class="alert modify alert-success">Vendor Proforma Invoice updated successfully.</div>',
											// 			'redirect' => base_url().'vendor_proforma_invoice?po='.base64_encode($post_data['po_number']),
											'redirect' => base_url().'vendor_proforma_invoice',
										));
									}else{
										$this->json->jsonReturn(array(
											'valid'=>FALSE,
											'msg'=>'<div class="alert modify alert-danger"><strong>Something went wrong!</div>'
										));
									}
								}

							} else {
								$this->json->jsonReturn(array(
									'valid'=>FALSE,
									'msg'=>'<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!!</div>'
								));
							}
						}
					}
				}


				public function approved_vendor_proforma_invoice()
				{
					$save_stock_arr = $update_stock_arr = $save_exceptional_arr = array();
					$loguser_id = $this->session->userData('user_id');
					$logrole_id = $this->session->userData('role_id');
					if(isset($loguser_id) && !empty($loguser_id) && isset($logrole_id) && !empty($logrole_id)){
						$submenu_data=$this->common_model->selectDetailsWhr('tbl_submenu','action','approved_vendor_proforma_invoice');
						if(isset($submenu_data->submenu_id) && !empty($submenu_data->submenu_id)){
							$submenu_id = $submenu_data->submenu_id;
							$check_permission=$this->admin_model->check_permission($submenu_id,$logrole_id);
							if(isset($check_permission) && !empty($check_permission)){

								$project_id = $this->input->post('project_id');
								$boq_code = $this->input->post('boq_code');
								$a_status = $this->input->post('status');
								$transaction_id = $this->input->post('id');

								if(isset($project_id) && !empty($project_id)){
									$project_id = base64_decode($project_id);
								}
								$qr_array = array('project_id' =>$project_id,'transaction_id' => $transaction_id);
								$bom_items_data = $this->admin_model->getViewBomVendorPIListRows($transaction_id);


								if(isset($bom_items_data) && !empty($bom_items_data)){
									foreach ($bom_items_data as $key => $bom_items) {
										if(isset($bom_items->status) && !empty($bom_items->status) && $bom_items->status !='approved'){
											if(isset($bom_items->proforma_id) && !empty($bom_items->proforma_id)) { $proforma_id = $bom_items->proforma_id; }else { $proforma_id = 0; }
											if(isset($bom_items->boq_code) && !empty($bom_items->boq_code)) { $boq_code = $bom_items->boq_code; }else { $boq_code = ''; }
											if(isset($bom_items->qty) && !empty($bom_items->qty)) { $pi_qty = $bom_items->qty; }else { $pi_qty = ''; }
											if(isset($bom_items->bom_code) && !empty($bom_items->bom_code)) { $bom_code = $bom_items->bom_code; }else { $bom_code = ''; }


											if(isset($bom_items->transaction_id) && !empty($bom_items->transaction_id)) { $transaction_id = $bom_items->transaction_id; }else { $transaction_id = 0; }
											$check_bom_stock_details = $this->admin_model->check_bom_stock_details($project_id, $boq_code, $bom_items->bom_code);
											// need to add this qty in tbl_bom_stock


											$db_total_stock = 0;
											$db_release_stock = 0;
											$db_dc_total_stock = 0;
											$db_dc_stock = 0;

											if(isset($check_bom_stock_details) && !empty($check_bom_stock_details)) {

												$vpi_stock = $check_bom_stock_details->vpi_stock;
												$pending_vpi_stock = $vpi_stock - abs($vpi_stock);

												$update_stock_arr[] = array(
													'boq_code'=>$boq_code,
													'bom_code'=>$bom_code,
													'vpi_stock'=> $pending_vpi_stock,
													'updated_by'=>$loguser_id,
													'updated_date'=>date('Y-m-d H:i:s')
												);
											}

											if($a_status =='approved') {

												$data = array('status'=>'approved','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
												$this->common_model->updateDetails('tbl_vendor_performa_invoice','proforma_id',$proforma_id,$data);
												$this->common_model->updateDetails('tbl_vendor_pi_item','proforma_id',$proforma_id,$data);

												if(isset($update_stock_arr) && !empty($update_stock_arr)){
													$this->common_model->updateBOMStock($update_stock_arr,$project_id,$boq_code);
												}
											} else {
												$data = array('status'=>'reject','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
												$this->common_model->updateDetails('tbl_vendor_performa_invoice','proforma_id',$proforma_id,$data);
												$this->common_model->updateDetails('tbl_vendor_pi_item','proforma_id',$proforma_id,$data);
											}
										}
									}

									if($a_status =='approved') {

										if(isset($transaction_id) && !empty($transaction_id) && $transaction_id > 0){
											$dataTrans = array('status'=>'approved','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
											$this->common_model->updateDetails('tbl_bom_transactions','id',$transaction_id,$dataTrans);
										}
									} else {
										if(isset($transaction_id) && !empty($transaction_id) && $transaction_id > 0){
											$dataTrans = array('status'=>'reject','approved_by'=>$loguser_id,'approved_date'=>date('Y-m-d H:i:s'));
											$this->common_model->updateDetails('tbl_bom_transactions','id',$transaction_id,$dataTrans);
										}
									}
									$this->json->jsonReturn(array(
										'valid'=>TRUE,
										'msg'=>'<div class="alert modify alert-success">Vendor Performa Invoice status changed Successfully!</div>'
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
				public function get_bom_po_pending_qty_item_by_project($project_id = '') {


					$user_id = $this->session->userData('user_id');
					if(isset($user_id) && !empty($user_id)){
						$data = $new_entry_arr = array();
						// $memData = $this->admin_model->getBOMIndentItemListRows($_POST,$project_id);
						$memData = $this->admin_model->getBOMPoItemListRows($_POST,$project_id);

						$project_po_data = $this->admin_model->getProjectPoData($project_id);
						$bom_code_wise_qty = [];
						foreach($project_po_data as $key=>$val){
							if(isset($bom_code_wise_qty[$val->bom_code])){
								$bom_code_wise_qty[$val->bom_code] += $val->po_quantity;
							}else{
								$bom_code_wise_qty[$val->bom_code] = $val->po_quantity;
							}

						}
						// 	$bom_code_wise_qty = array_column($project_po_data,"total_qty","bom_code");

						$allCount = count($memData);
						$countFiltered = count($memData);
						$i = $_POST['start'];
						$po_approval_pending = array();
						$pending_qty_arr = [];
						foreach($memData as $member){
							if(isset($bom_code_wise_qty[$member->bom_code])){
								$member->indent_quantity = $member->indent_quantity - $bom_code_wise_qty[$member->bom_code];
							}
							$pending_qty_arr[$member->bom_code] = $member->indent_quantity;
						}

						return $pending_qty_arr;


					}
				}
				public function vendor_proforma_invoice_pending_Qty($po_number = '')
				{

					$po_details=$this->common_model->selectAllWhr('tbl_purchase_order','po_number',$po_number);
					$project_item_data = $this->admin_model->getProjectItem($po_details[0]->project_id);
					$po_item_details=$this->admin_model->getPerformaInvoicePerviousItem($po_number);
					$project_item_data_arr = [];

					foreach($po_item_details as $key=>$val){
						$po_item_arr[$val['bom_code']] += $val['qty'];
						$po_item_rate_arr[$val['bom_code']] += $val['rate'];
					}

					$po_items = [];
					$pending_qty = [];
					foreach($po_details as $key=>$val){

						$total_qty = number_format((float)$val->po_quantity, 2, '.', '') - number_format((float)$po_item_arr[$val->bom_code], 2, '.', '') ;
						$pending_qty[$val->bom_code] = $total_qty;
					}
					return $pending_qty;
				}


				//  ------------------------------------------------- payment_receipt -------------------------------------------------
				public function payment_receipt()
				{
					$ppi_id = $this->input->get("ppi");
					$ppi= base64_decode($ppi_id);

					$pr_data = [];
					if ($this->input->get("pr_id")) {
						$pr_id = $this->input->get("pr_id");
						$pr_id = base64_decode($pr_id);

						if (!empty($pr_id) && is_numeric($pr_id)) {
							$pr_data = $this->admin_model->get_payment_receipt_data_by_id($pr_id);
							// pr($pr_data, 1);
						}
					}
					$ppi_data = $this->admin_model->getPerformaInvoiceData($ppi);
					$ppi_item = $this->admin_model->getPerformaInvoiceItem($ppi);
					$po_details = $this->common_model->selectAllWhr('tbl_purchase_order','po_number',$ppi_data->po_number);
					// pr($ppi_data->project_id,1);
					$vendor_data = $this->admin_model->getVendorDetail($po_details[0]->vendor_id);
					$total_amount_sum = 0;
					foreach ($ppi_item as $item) {
						$total_amount_sum += (float)$item['total_amount'];
					}

					$payment_receipt_data = $this->admin_model->get_payment_receipt_data($ppi_data->project_id,$ppi_data->proforma_no);

					$checking_amount_sum = 0;
					if (isset($payment_receipt_data) && count($payment_receipt_data) > 0) {
						foreach ($payment_receipt_data as $data) {
							$checking_amount_sum += (float)$data['payment_amount'];
						}

					}

					// 	$final_amount = number_format($total_amount_sum - $checking_amount_sum, 2, '.', '');
					if(!empty($pr_data)){
						$final_amount = number_format(($total_amount_sum+$pr_data[0]['payment_amount']) - $checking_amount_sum , 2, '.', '');

					}else{
						$final_amount = number_format($total_amount_sum - $checking_amount_sum, 2, '.', '');
					}
					$data['ppi_data'] = $ppi_data;
					$data['vendor_data'] = $vendor_data[0];
					$data['payment_amount'] = $final_amount;
					$data['invoice_amount'] = $total_amount_sum;
					$data['pr_data'] = $pr_data;
					// pr($data);
					$this->load->view('payment_receipt',$data);
				}

				public function save_ppi_payment_receipt_data()
				{
					$input_params = [];
					$post_data = $this->input->post();
					// pr($post_data,1);
					unset($post_data['project_name']);
					unset($post_data['vendor_name']);

					$config['upload_path']   = './uploads/payment_receipts/';
					$config['allowed_types'] = 'doc|pdf|txt|png|PNG|jpg|JPG|jpeg|JPEG|xls|xlsx';
					$config['encrypt_name']  = TRUE;

					$this->load->library('upload', $config);
					$file_name = '';
					$bom_transactions_data['project_id'] = $post_data['project_id'];
					$bom_transactions_data['event_name'] = "Payment Receipt";
					$bom_transactions_data['event_type'] = "payment_receipt";
					$bom_transactions_data['created_date'] = date('Y-m-d H:i:s');
					$bom_transactions_data['created_by'] = $this->session->userdata('user_id');
					$bom_transactions_data['status'] = 'pending';


					if (!empty($_FILES['payment_document']['name'])) {
						if ($this->upload->do_upload('payment_document')) {
							$uploaded_data = $this->upload->data();
							$file_name = $uploaded_data['file_name'];

						} else {
							$success = 0;
							$messages = $this->upload->display_errors();
							$return_arr['success'] = $success;
							$return_arr['messages'] = $messages;
							echo json_encode($return_arr);
							exit;
						}
					}
					$input_params = $post_data;



					$input_params['status'] = 'pending';
					if ($post_data['mode']=="update" && $post_data['pr_id']!="") {
						unset($input_params['mode']);
						if ($post_data['hidden_payment_document'] != "" && $file_name == "") {
							$input_params['payment_document'] = $post_data['hidden_payment_document'];

						}else{
							$input_params['payment_document'] = $file_name;
						}
						unset($input_params['hidden_payment_document']);
						$input_params['updated_date'] = date('Y-m-d H:i:s');
						$input_params['created_by'] = $this->session->userdata('user_id');

						$update_trans_status =	$this->admin_model->updatePoTransactionStatus($post_data['transaction_id']);
						$update_data = $this->admin_model->update_ppi_payment_receipt_data($input_params,$post_data['pr_id']);
						if ($update_data > 0 ) {
							$success = 1;
							$messages = "Payment Receipt data updated successfully.";
						} else {
							$success = 0;
							$messages = "Something went wrong, Please try again.";
						}
					}else if ($post_data['mode']=="add" && $post_data['pr_id']=="") {
						$bom_trans_data = $this->admin_model->SavePerformaInvoiceTransaction($bom_transactions_data);
						unset($input_params['mode']);
						unset($input_params['hidden_payment_document']);
						$input_params['transaction_id'] = $bom_trans_data;
						$input_params['payment_document'] = $file_name;
						$input_params['created_date'] = date('Y-m-d H:i:s');
						$input_params['created_by'] = $this->session->userdata('user_id');
						$save_data = $this->admin_model->save_ppi_payment_receipt_data($input_params);
						if ($save_data > 0 ) {
							$success = 1;
							$messages = "Payment Receipt generated successfully.";
						} else {
							$success = 0;
							$messages = "Something went wrong, Please try again.";
						}
					}

					$return_arr['success'] = $success;
					$return_arr['messages'] = $messages;

					echo json_encode($return_arr);
					exit;
				}

				public function ppi_payment_receipt()
				{
					$payment_receipt_data = $this->admin_model->get_payment_receipt_data();
					$data['payment_receipt_data'] = $payment_receipt_data;
					$this->load->view('ppi_payment_receipt',$data);
				}
				public function get_payment_sub_item(){
					$post_data = $this->input->post();
					$ppi_id = $post_data["ppi_id"];
					if(isset($post_data['transaction_id'])){
						$payment_receipt_data = $this->admin_model->get_payment_receipt_data_by_id_data($post_data['transaction_id']);
						$ppi_id = $payment_receipt_data[0]['ppi_id'];
					}
					$performa_invoice_data = $this->admin_model->getPerformaInvoiceData($ppi_id);
					$memData = $this->admin_model->getViewBomVendorPIListRows($performa_invoice_data->transaction_id);
					foreach ($memData as $member) {
						$i++;

						$proforma_itemid = $member->proforma_itemid ?? '-';

						$boq_code = $member->boq_code ?? '-';
						$bom_code = $member->bom_code ?? '-';
						$hsn_code = $member->hsn_code ?? '-';
						$item_description = $member->item_description ?? '-';
						$make = $member->make ?? '-';
						$model = $member->model ?? '-';
						$unit = $member->unit ?? '-';
						$rate_basic = $member->rate ?? '0';
						$gst = $member->gst ?? '0';
						$status = $member->status ?? 'N';
						$display = $member->display ?? 'N';



						$qty_pending = $member->qty ?? '0';
						$total_amount = $rate_basic * $qty_pending;
						$gst_amount = $gst > 0 ? $total_amount * ($gst / 100) : 0;
						$final_amount = $total_amount + $gst_amount;
						$unique_arr = [];
						if (!in_array($boq_code, $unique_arr)) {
							array_push($unique_arr, $boq_code);
							$data[] = [
								$i,
								$bom_code,
								$hsn_code,
								$item_description,
								$make,
								$model,
								$unit,
								$qty_pending,
								$rate_basic,
								$gst,
								sprintf('%0.2f', $final_amount),
							];
						}
					}

					$output = [
						"draw" => $_POST['draw'],
						"recordsTotal" => count($memData),
						"recordsFiltered" => count($data),
						"data" => $data,
					];

					echo json_encode($output);
					// pr($performa_invoice_data);
				}
				public function view_ppi_payment_receipt()
				{
					$id = $this->uri->segment(2);
					if(isset($id) && !empty($id)){
						$project_id = base64_decode($id);
					}
					$payment_receipt_data = $this->admin_model->get_payment_receipt_data($project_id);
					$data['payment_receipt_data'] = $payment_receipt_data;
					$data['project_id_encode'] = $id;
					$data['project_id'] = $project_id;
					$this->load->view('view_ppi_payment_receipt',$data);
				}

				public function approved_ppi_payment_receipt()
				{
					$loguser_id = $this->session->userdata('user_id');
					$logrole_id = $this->session->userdata('role_id');

					if (!empty($loguser_id) && !empty($logrole_id)) {
						$submenu_data = $this->common_model->selectDetailsWhr('tbl_submenu', 'action', 'approved_ppi_payment_receipt');

						if (!empty($submenu_data->submenu_id)) {
							$submenu_id = $submenu_data->submenu_id;

							$check_permission = $this->admin_model->check_permission($submenu_id, $logrole_id);

							if (!empty($check_permission)) {
								$project_id = $this->input->post('project_id');
								$transaction_id = $this->input->post('id');
								$a_status = $this->input->post('status');
								if (!empty($project_id)) {
									$project_id = base64_decode($project_id);
								}
								$pr_data = $this->admin_model->get_ppi_pr_data_by_trancation_by($transaction_id);
								if (!empty($pr_data)) {
									$pr_id = $pr_data[0]['pr_id'];
									$receipt_data = [
										'status' => $a_status == 'approved' ? 'approved' : 'reject',
										'approved_by' => $loguser_id,
										'approved_date' => date('Y-m-d H:i:s')
									];
									$this->common_model->updateDetails('tbl_ppi_payment_receipt', 'pr_id', $pr_id, $receipt_data);


									$transaction_data = [
										'status' => $a_status == 'approved' ? 'approved' : 'reject',
										'approved_by' => $loguser_id,
										'approved_date' => date('Y-m-d H:i:s')
									];
									if (!empty($transaction_id) && $transaction_id > 0) {
										$this->common_model->updateDetails('tbl_bom_transactions', 'id', $transaction_id, $transaction_data);
									}
									$this->json->jsonReturn([
										'valid' => TRUE,
										'msg' => '<div class="alert modify alert-success">Payment Receipt status changed successfully!</div>'
									]);
								} else {

									$this->json->jsonReturn([
										'valid' => FALSE,
										'msg' => '<div class="alert modify alert-danger"><strong>Error!</strong> Payment receipt data not found.</div>'
									]);
								}
							} else {

								$this->json->jsonReturn([
									'valid' => FALSE,
									'msg' => '<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!</div>'
								]);
							}
						} else {

							$this->json->jsonReturn([
								'valid' => FALSE,
								'msg' => '<div class="alert modify alert-danger"><strong>Error!</strong> You have no permission!</div>'
							]);
						}
					} else {

						$this->json->jsonReturn([
							'valid' => FALSE,
							'msg' => '<div class="alert modify alert-danger"><strong>Error!</strong> You are not logged in or your role is invalid!</div>'
						]);
					}
				}




			}
