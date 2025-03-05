<?php
class Report_model extends CI_Model {
  	function __construct() {
  	 $this->db->query("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
  	}

  	public function get_boq_open_so_report_view_data(
        $condition_arr = [],
        $search_params = ""
    ) {
        $this->db->select(
            'p.*'
        );
        $this->db->from("tbl_projects as p");
        if (count($condition_arr) > 0) {
            $this->db->limit($condition_arr["length"], $condition_arr["start"]);
            if ($condition_arr["order_by"] != "") {
                $this->db->order_by($condition_arr["order_by"]);
            }
        }

        if (is_array($search_params) && count($search_params) > 0) {
           
            if ($search_params["value"] != "") {
                $search = $search_params["value"];
                $this->db->group_start(); // Start a group for 'like' queries
                $this->db->like('p.bp_code', $search);
                $this->db->or_like('p.po_loi_no', $search);
                $this->db->or_like('p.customer_name', $search);
                $this->db->group_end(); // End the group
            }
        }

        $result_obj = $this->db->get();
        $ret_data = is_object($result_obj) ? $result_obj->result_array() : [];

        // pr($this->db->last_query(),1);
        return $ret_data;
    }
    public function get_boq_open_so_report_view_count(
        $condition_arr = [],
        $search_params = ""
    ) {
        $this->db->select(
            'COUNT(p.project_id) as total_record'
        );
        $this->db->from("tbl_projects as p");
        if (count($condition_arr) > 0) {
            $this->db->limit($condition_arr["length"], $condition_arr["start"]);
            if ($condition_arr["order_by"] != "") {
                $this->db->order_by($condition_arr["order_by"]);
            }
        }

        if (is_array($search_params) && count($search_params) > 0) {
           
            if ($search_params["value"] != "") {
                $search = $search_params["value"];
                $this->db->group_start(); // Start a group for 'like' queries
                $this->db->like('p.bp_code', $search);
                $this->db->or_like('p.po_loi_no', $search);
                $this->db->or_like('p.customer_name', $search);
                $this->db->group_end(); // End the group
            }
        }

        $result_obj = $this->db->get();
        $ret_data = is_object($result_obj) ? $result_obj->row_array() : [];

        // pr($this->db->last_query(),1);
        return $ret_data;
    }
    public function get_boq_open_so_report_more_data($project_id = 0){
    	$this->db->select(
            'bt.id as uploaded_boq,bt.status as boq_status,bt.created_date as boq_uploaded,bom.id as bom_uploaded,bom.status as bom_uploaded_status,bom.created_date as bom_uploaded_date'
        );
        $this->db->from("tbl_projects as p");
        $this->db->join("tbl_boq_transactions as bt","bt.project_id = p.project_id AND bt.event_type= 'boq_upload' AND bt.is_first_upload = 1","left");
        $this->db->join("tbl_bom_transactions as bom","bom.project_id = p.project_id AND bom.event_type= 'bom_upload' AND bom.is_first_upload = 1","left");
        $this->db->where("p.project_id",$project_id);
        $result_obj = $this->db->get();
        $ret_data = is_object($result_obj) ? $result_obj->row_array() : [];

        // pr($this->db->last_query(),1);
        return $ret_data;
    }

}