<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_controller extends Base_Controller 
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
        $this->load->model('report_model');
        error_reporting(E_ALL & ~E_NOTICE);
    }
    public function clear_cache()
    {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }
    public function wip_status_report() 
    {
        $this->load->view('wip-status-report');
    }
    public function stock_wip_report_summary() 
    {
        $this->load->view('stock-wip-report-summary');
    }
    public function stock_or_wip_status() 
    {
        $this->load->view('stock-or-wip-status');
    }
    public function stock_movement_reports() 
    {
        $this->load->view('stock-movement-reports');
    }
    
    public function wipstatusreports_display() 
		{
		$user_id = $this->session->userData('user_id');
		if(isset($user_id) && !empty($user_id)){
		$data = $row = array();
		$i = $_POST['start'];
		$allCount = 0;
		$countFiltered = 0;
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $allCount,
            "recordsFiltered" => $countFiltered,
            "data" => $data,
        );
        echo json_encode($output);
		}

    }
    
     // ----------------------------------------- Stock Reports -----------------------------------------

    public function stock_report() {
      
        $stock_data = $this->admin_model->stock_report();
        $data = []; 

        foreach ($stock_data as $item) {
            $key = $item['project_id'] . '_' . $item['bom_code'];
            
            if (!isset($data[$key])) {
                $data[$key] = $item; // Copy the original item
                $data[$key]['good_condition_qty'] = $item['good_condition_qty'];
            } else {
                $data[$key]['good_condition_qty'] += $item['good_condition_qty'];
            }
        }

        $data = array_values($data);
        $data['data'] = $data;
        $this->load->view('stock',$data);
    }

    public function stock_report_list_by_project_id()
    {
        
        $project_id = $_POST['project_id'];
        $stock_data = $this->admin_model->stock_list_by_project_id($project_id);
        $data = []; 
        foreach ($stock_data as $item) {
            $key = $item['project_id'] . '_' . $item['bom_code'];
            if (!isset($data[$key])) {
                $data[$key] = $item; 
                $data[$key]['good_condition_qty'] = $item['good_condition_qty']; 
            } else {
                $data[$key]['good_condition_qty'] += $item['good_condition_qty'];
            }
        }
        $data = array_values($data);
        $html = '';
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $html .= '<tr>';
                $html .= '<th>' . ($key + 1) . '</th>'; 
                $html .= '<td>' . (!empty($value['bp_code']) ? htmlspecialchars($value['bp_code']) : '-') . '</td>';
                $html .= '<td>' . (!empty($value['bom_code']) ? htmlspecialchars($value['bom_code']) : '-') . '</td>';
                $html .= '<td>' . (!empty($value['item_description']) ? htmlspecialchars($value['item_description']) : '-') . '</td>';
                $html .= '<td>' . (!empty($value['hsn_code']) ? htmlspecialchars($value['hsn_code']) : '-') . '</td>';
                $html .= '<td>' . (!empty($value['unit']) ? htmlspecialchars($value['unit']) : '-') . '</td>';
                $html .= '<td>' . (!empty($value['make']) ? htmlspecialchars($value['make']) : '-') . '</td>';
                $html .= '<td>' . (!empty($value['model']) ? htmlspecialchars($value['model']) : '-') . '</td>';
                $html .= '<td>' . (!empty($value['good_condition_qty']) ? htmlspecialchars($value['good_condition_qty']) : '-') . '</td>';
                if (!empty($value['status'])) {
                    switch ($value['status']) {
                        case 'approved':
                            $html .= '<td><span style="color:green;font-weight:600;">Approved</span></td>';
                            break;
                        case 'pending':
                            $html .= '<td><span style="color:orange;font-weight:600;">Pending</span></td>';
                            break;
                        case 'reject':
                            $html .= '<td><span style="color:red;font-weight:600;">Rejected</span></td>';
                            break;
                        default:
                            $html .= '<td>-</td>'; 
                    }
                } else {
                    $html .= '<td>-</td>'; 
                }
                $html .= '</tr>'; 
            }
        } else {
           
            $html .= '<tr class="text-center"><td colspan="13">No Stock data found</td></tr>';
        }
        echo $html;
        exit; 
    }

    /* reports chnages */

    public function boq_open_so_report() {
       
        // $column[] = [
        //     "data" => "part_id",
        //     "title" => "Part Id",
        //     "width" => "7%",
        //     "className" => "dt-center",
        //     "visible"=> false,
        // ];
        $column[] = [
            "data" => "serial_number",
            "title" => "Sr.No.",
            "width" => "2%",
            "className" => "dt-center",
        ];
        $column[] = [
            "data" => "bp_code",
            "title" => "BP Code",
            "width" => "50px",
            "className" => "dt-left",
        ];
        $column[] = [
            "data" => "po_loi_no",
            "title" => "PO/LOI NO.",
            "width" => "50px",
            "className" => "dt-center",
        ];
        $column[] = [
            "data" => "customer_name",
            "title" => "Customer Name",
            "width" => "50px",
            "className" => "dt-center",
        ];
        $column[] = [
            "data" => "created_by",
            "title" => "Created By",
            "width" => "50px",
            "className" => "dt-center",
        ];
        $column[] = [
            "data" => "created_date",
            "title" => "Created On",
            "width" => "50px",
            "className" => "dt-center",
        ];
        $column[] = [
            "data" => "status",
            "title" => "OEF Status",
            "width" => "50px",
            "className" => "dt-center",
        ];
        $column[] = [
            "data" => "action",
            "title" => "Action",
            "width" => "20px",
            "className" => "dt-center",
        ];
       
        
        $data["data"] = $column;
        $data["is_searching_enable"] = true;
        $data["is_paging_enable"] = true;
        $data["is_serverSide"] = true;
        $data["is_ordering"] = true;
        $data["is_heading_color"] = "#a18f72";
        $data["no_data_message"] =
            '<div class="p-3 no-data-found-block"><img class="p-2" src="' .
            base_url() .
            'public/assets/images/images/no_data_found_new.png" height="150" width="150"><br> No Employee data found..!</div>';
            
        $data["is_top_searching_enable"] = true;
        $data["sorting_column"] = json_encode([]);
        $data["page_length_arr"] = [[10,50,100,200,500,1000,1500], [10,50,100,200,500,1000,1500]];
        $data["admin_url"] = base_url();
        $data["base_url"] = base_url();
        
        $this->load->view('boq_open_so_report',$data)
        ;
    }

    public function get_boq_open_so_report_data(){
        
        $post_data = $this->input->post();
        $column_index = array_column($post_data["columns"], "data");
        $order_by = "";
        foreach ($post_data["order"] as $key => $val) {
            if ($key == 0) {
                $order_by .= $column_index[$val["column"]] . " " . $val["dir"];
            } else {
                $order_by .=
                    "," . $column_index[$val["column"]] . " " . $val["dir"];
            }
        }
        $condition_arr["order_by"] = $order_by;
        $condition_arr["start"] = $post_data["start"];
        $condition_arr["length"] = $post_data["length"];
        $base_url = $this->config->item("base_url");
        $data = $this->report_model->get_boq_open_so_report_view_data(
            $condition_arr,
            $post_data["search"]
        );

        foreach ($data as $key => $value) {
        
            $data[$key]['serial_number'] .= $key+1;
            $data[$key]['action'] = '<a href="javascript:;" class="tooltips openMoreDetails" rev="view_bom_items" project_id="'.$value["project_id"].'" title="" data-original-title="Delete Role">More Details</a>';
            
        }
        $data["data"] = $data;
        $total_record = $this->report_model->get_boq_open_so_report_view_count([], $post_data["search"]);
        $data["recordsTotal"] = $total_record['total_record'];
        $data["recordsFiltered"] = $total_record['total_record'];
        echo json_encode($data);
        exit();
    }

    public function extend_table_row() {
        $post_data = $this->input->post();
        $type = $post_data['type'];

        if($type == 'boq_open_so_report'){
            $project_id = $post_data['project_id'];
            $more_data = $this->report_model->get_boq_open_so_report_more_data(
                $project_id
            );
            $uploade_boq = $more_data['uploaded_boq'] > 0 ? "Yes" : "No";
            $boq_status = $more_data['boq_status'] != '' &&  $more_data['boq_status'] != null ? ucfirst($more_data['boq_status']) : "N/A";
            $boq_uploaded = $more_data['boq_uploaded'] != '' &&  $more_data['boq_uploaded'] != null  ? $more_data['boq_uploaded'] : "N/A";

            $uploade_bom = $more_data['bom_uploaded'] > 0 ? "Yes" : "No";
            $bom_status = $more_data['bom_uploaded_status'] != '' &&  $more_data['bom_uploaded_status'] != null ? ucfirst($more_data['bom_uploaded_status']) : "N/A";
            $bom_uploaded = $more_data['bom_uploaded_date'] != '' &&  $more_data['bom_uploaded_date'] != null  ? $more_data['bom_uploaded_date'] : "N/A";
            $html = '<tr class="extented_row"><td colspan="8"><div class="main-extend-contain" style="margin: 18px;">
                        <div class="row">
                            <div class="boq-container">
                                <span class="title-block">BOQ Details</span>
                                <hr>
                                <div class="boq-main-details">
                                    <div class="sub-container" ><span class="title-data">BOQ Uploaded : <b>'.$uploade_boq.'</b></span></div>
                                    <div class="sub-container" ><span class="title-data">BOQ Uploaded Date : <b>'.$boq_uploaded.'</b></span></div>
                                    <div class="sub-container" ><span class="title-data">BOQ Uploaded Status : <b>'.$boq_status.'</b></span></div>
                                    <div class="sub-container" ></div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="main-extend-contain" style="margin: 18px;">
                        <div class="row">
                            <div class="boq-container">
                                <span class="title-block">BOM Details</span>
                                <hr>
                                <div class="boq-main-details">
                                    <div class="sub-container" ><span class="title-data">BOQ Uploaded : <b>'.$uploade_bom.'</b></span></div>
                                    <div class="sub-container" ><span class="title-data">BOQ Uploaded Date : <b>'.$bom_uploaded.'</b></span></div>
                                    <div class="sub-container" ><span class="title-data">BOQ Uploaded Status : <b>'.$bom_status.'</b></span></div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    </td></tr>';
        }

        $data['html'] = $html;
        echo json_encode($data);
        exit();
    }   
}