<?php
class Common_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getPrifixData($type){
        $query=$this->db->query("SELECT * FROM `tbl_prefix` WHERE `prefix_type`='".$type."' ORDER BY id DESC LIMIT 0,1");
        if($query->num_rows()>0){
            return $query->row_array();
        }else{
            return 0;
        }
    }
    public function getBOQItemBulkDetails($boq_items_ids){
        $query = $this->db->query("SELECT 
        IFNULL(boq_items_id,0) as boq_items_id,IFNULL(project_id,0) as project_id,IFNULL(boq_code,0) as boq_code,
        IFNULL(hsn_sac_code,0) as hsn_sac_code,IFNULL(item_description,0) as item_description,IFNULL(unit,0) as unit,
        IFNULL(scheduled_qty,0) as scheduled_qty,IFNULL(design_qty,0) as design_qty,IFNULL(upload_design_qty,0) as upload_design_qty,
        IFNULL(o_design_qty,0) as o_design_qty,IFNULL(rate_basic,0) as rate_basic,IFNULL(gst,0) as gst,
        IFNULL(non_schedule,0) as non_schedule,IFNULL(addFromEA,0) as addFromEA,IFNULL(billable,0) as billable,
        IFNULL(transaction_id,0) as transaction_id
        FROM `tbl_boq_items` WHERE `boq_items_id` IN ($boq_items_ids) AND display='Y'");
        if($query->num_rows()>0){
            $result = $query->result_array();
            $tbl_data = array();
            if(isset($result) && !empty($result)){
                foreach($result as $key){
                    $tbl_data[$key['boq_items_id']] = array('project_id'=>$key['project_id'],'boq_code'=>$key['boq_code'],
                    'hsn_sac_code'=>$key['hsn_sac_code'],'item_description'=>$key['item_description'],'unit'=>$key['unit'],'scheduled_qty'=>$key['scheduled_qty'],
                    'design_qty'=>$key['design_qty'],'upload_design_qty'=>$key['upload_design_qty'],'o_design_qty'=>$key['o_design_qty'],'rate_basic'=>$key['rate_basic'],
                    'gst'=>$key['gst'],'non_schedule'=>$key['non_schedule'],'addFromEA'=>$key['addFromEA'],'billable'=>$key['billable'],'transaction_id'=>$key['transaction_id']);        
                }  
                return $tbl_data;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }
    public function getBOQStockBulkDetails($project_ids,$boq_codes){
        $query = $this->db->query("SELECT * FROM `tbl_boq_stock` WHERE `project_id` IN ($project_ids) AND `boq_code` IN ($boq_codes) GROUP BY project_id,boq_code,stock_id");

        if($query->num_rows()>0){
            $result = $query->result_array();
            $tbl_data = array();
            if(isset($result) && !empty($result)){
                foreach($result as $key){
                    $tbl_data[$key['project_id'].'-'.$key['boq_code']] = array('stock_id'=>$key['stock_id'],'project_id'=>$key['project_id'],
                    'boq_code'=>$key['boq_code'],'total_stock'=>$key['total_stock'],'dc_total_stock'=>$key['dc_total_stock'],'dc_stock'=>$key['dc_stock'],'dc_approved'=>$key['dc_approved'],
                    'total_installed'=>$key['total_installed'],'installed'=>$key['installed'],'total_provisional'=>$key['total_provisional'],'provisional'=>$key['provisional'],'proforma_stock'=>$key['proforma_stock'],'tax_invoice_stock'=>$key['tax_invoice_stock']);        
                }  
                return $tbl_data;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }
    /*
    public function getLastFinancialYear($type){
        if($type == 'EA'){
            $query=$this->db->query("SELECT CASE WHEN MONTH(created_at)>=7 THEN concat(SUBSTR(YEAR(created_at),-2,2), '-',SUBSTR((YEAR(created_at)+1),-2,2)) ELSE (0) END AS financial_year
            FROM tbl_boq_exceptional GROUP BY financial_year ORDER BY id DESC LIMIT 0,1");
        }elseif($type == 'DC'){
            // $query=$this->db->query("SELECT CASE WHEN MONTH(created_on)>=7 THEN concat(SUBSTR(YEAR(created_on),-2,2), '-',SUBSTR((YEAR(created_on)+1),-2,2)) ELSE (0) END AS financial_year
            // FROM tbl_delivery_challan GROUP BY financial_year ORDER BY challan_id DESC LIMIT 0,1");
            $query = $this->db->query("SELECT CASE WHEN MONTH(CURDATE()) >= 4 THEN CONCAT(SUBSTR(YEAR(CURDATE()), -2, 2), '-', SUBSTR((YEAR(CURDATE()) + 1), -2, 2)) ELSE CONCAT(SUBSTR((YEAR(CURDATE()) - 1), -2, 2), '-', SUBSTR(YEAR(CURDATE()), -2, 2)) END AS financial_year FROM tbl_delivery_challan GROUP BY financial_year ORDER BY challan_id DESC LIMIT 0, 1");
        }elseif($type == 'IWIP'){
            $query=$this->db->query("SELECT CASE WHEN MONTH(created_on)>=7 THEN concat(SUBSTR(YEAR(created_on),-2,2), '-',SUBSTR((YEAR(created_on)+1),-2,2)) ELSE (0) END AS financial_year
            FROM tbl_installed_wip GROUP BY financial_year ORDER BY i_wip_id DESC LIMIT 0,1");
        }elseif($type == 'PWIP'){
            $query=$this->db->query("SELECT CASE WHEN MONTH(created_on)>=7 THEN concat(SUBSTR(YEAR(created_on),-2,2), '-',SUBSTR((YEAR(created_on)+1),-2,2)) ELSE (0) END AS financial_year
            FROM tbl_provisional_wip GROUP BY financial_year ORDER BY p_wip_id DESC LIMIT 0,1");
        }elseif($type == 'PROFORMA'){
            $query=$this->db->query("SELECT CASE WHEN MONTH(created_on)>=7 THEN concat(SUBSTR(YEAR(created_on),-2,2), '-',SUBSTR((YEAR(created_on)+1),-2,2)) ELSE (0) END AS financial_year
            FROM tbl_proforma_invc GROUP BY financial_year ORDER BY proforma_id DESC LIMIT 0,1");
        }elseif($type == 'TAX'){
            $query=$this->db->query("SELECT CASE WHEN MONTH(created_on)>=7 THEN concat(SUBSTR(YEAR(created_on),-2,2), '-',SUBSTR((YEAR(created_on)+1),-2,2)) ELSE (0) END AS financial_year
            FROM tbl_tax_invc GROUP BY financial_year ORDER BY tax_invc_id DESC LIMIT 0,1");
        }
        if($query->num_rows()>0){
            return $query->row()->financial_year;
        }else{
            return 0;
        }
    }
    */
    public function getLastFinancialYear($type){
        if($type == 'EA'){
            $query=$this->db->query("SELECT CASE WHEN MONTH(CURDATE()) >= 4 THEN CONCAT(SUBSTR(YEAR(CURDATE()), -2, 2), '-', SUBSTR((YEAR(CURDATE()) + 1), -2, 2)) ELSE CONCAT(SUBSTR((YEAR(CURDATE()) - 1), -2, 2), '-', SUBSTR(YEAR(CURDATE()), -2, 2)) END AS financial_year
            FROM tbl_boq_exceptional GROUP BY financial_year,id ORDER BY id DESC LIMIT 0,1");
        }elseif($type == 'DC'){
            $query = $this->db->query("SELECT CASE WHEN MONTH(CURDATE()) >= 4 THEN CONCAT(SUBSTR(YEAR(CURDATE()), -2, 2), '-', SUBSTR((YEAR(CURDATE()) + 1), -2, 2)) ELSE CONCAT(SUBSTR((YEAR(CURDATE()) - 1), -2, 2), '-', SUBSTR(YEAR(CURDATE()), -2, 2)) END AS financial_year 
            FROM tbl_delivery_challan GROUP BY financial_year,challan_id ORDER BY challan_id DESC LIMIT 0, 1");
        }elseif($type == 'IWIP'){
            $query=$this->db->query("SELECT CASE WHEN MONTH(CURDATE()) >= 4 THEN CONCAT(SUBSTR(YEAR(CURDATE()), -2, 2), '-', SUBSTR((YEAR(CURDATE()) + 1), -2, 2)) ELSE CONCAT(SUBSTR((YEAR(CURDATE()) - 1), -2, 2), '-', SUBSTR(YEAR(CURDATE()), -2, 2)) END AS financial_year
            FROM tbl_installed_wip GROUP BY financial_year ORDER BY i_wip_id DESC LIMIT 0,1");
        }elseif($type == 'PWIP'){
            $query=$this->db->query("SELECT CASE WHEN MONTH(CURDATE()) >= 4 THEN CONCAT(SUBSTR(YEAR(CURDATE()), -2, 2), '-', SUBSTR((YEAR(CURDATE()) + 1), -2, 2)) ELSE CONCAT(SUBSTR((YEAR(CURDATE()) - 1), -2, 2), '-', SUBSTR(YEAR(CURDATE()), -2, 2)) END AS financial_year
            FROM tbl_provisional_wip GROUP BY financial_year ORDER BY p_wip_id DESC LIMIT 0,1");
        }elseif($type == 'PROFORMA'){
            $query=$this->db->query("SELECT CASE WHEN MONTH(CURDATE()) >= 4 THEN CONCAT(SUBSTR(YEAR(CURDATE()), -2, 2), '-', SUBSTR((YEAR(CURDATE()) + 1), -2, 2)) ELSE CONCAT(SUBSTR((YEAR(CURDATE()) - 1), -2, 2), '-', SUBSTR(YEAR(CURDATE()), -2, 2)) END AS financial_year
            FROM tbl_proforma_invc GROUP BY financial_year ORDER BY proforma_id DESC LIMIT 0,1");
        }elseif($type == 'TAX'){
            $query=$this->db->query("SELECT CASE WHEN MONTH(CURDATE()) >= 4 THEN CONCAT(SUBSTR(YEAR(CURDATE()), -2, 2), '-', SUBSTR((YEAR(CURDATE()) + 1), -2, 2)) ELSE CONCAT(SUBSTR((YEAR(CURDATE()) - 1), -2, 2), '-', SUBSTR(YEAR(CURDATE()), -2, 2)) END AS financial_year
            FROM tbl_tax_invc GROUP BY financial_year ORDER BY tax_invc_id DESC LIMIT 0,1");
        }
        elseif($type == 'PO'){
            $query=$this->db->query("SELECT CASE WHEN MONTH(CURDATE()) >= 4 THEN CONCAT(SUBSTR(YEAR(CURDATE()), -2, 2), '-', SUBSTR((YEAR(CURDATE()) + 1), -2, 2)) ELSE CONCAT(SUBSTR((YEAR(CURDATE()) - 1), -2, 2), '-', SUBSTR(YEAR(CURDATE()), -2, 2)) END AS financial_year
            FROM tbl_tax_invc GROUP BY financial_year ORDER BY tax_invc_id DESC LIMIT 0,1");
        }
        if($query->num_rows()>0){
            return $query->row()->financial_year;
        }else{
            return 0;
        }
    }



    
    public function getLastInc($type)
    {
        if($type == 'EA'){
            $query=$this->db->query("SELECT IFNULL(exceptional_inc,0) as inc_no FROM `tbl_boq_exceptional` ORDER BY exceptional_inc DESC LIMIT 0,1");
        }elseif($type == 'DC'){
            $query=$this->db->query("SELECT IFNULL(challan_no,0) as inc_no FROM `tbl_delivery_challan` ORDER BY challan_no DESC LIMIT 0,1");
        }elseif($type == 'IWIP'){
            $query=$this->db->query("SELECT IFNULL(i_wip_inc,0) as inc_no FROM `tbl_installed_wip` ORDER BY i_wip_inc DESC LIMIT 0,1");
        }elseif($type == 'PWIP'){
            $query=$this->db->query("SELECT IFNULL(p_wip_inc,0) as inc_no FROM `tbl_provisional_wip` ORDER BY p_wip_inc DESC LIMIT 0,1");
        }elseif($type == 'PROFORMA'){
            $query=$this->db->query("SELECT IFNULL(proforma_inc,0) as inc_no FROM `tbl_proforma_invc` ORDER BY proforma_inc DESC LIMIT 0,1");
        }elseif($type == 'TAX'){
            $query=$this->db->query("SELECT IFNULL(tax_invc_inc,0) as inc_no FROM `tbl_tax_invc` ORDER BY tax_invc_inc DESC LIMIT 0,1");
        }elseif($type == 'VD'){
            $query=$this->db->query("SELECT IFNULL(variable_discount_tid,0) as inc_no FROM `tbl_variable_discount` ORDER BY variable_discount_tid DESC LIMIT 0,1");
        }
        elseif($type == 'PO'){
            $query=$this->db->query("SELECT IFNULL(po_number,0) as inc_no FROM `tbl_purchase_order` ORDER BY id DESC LIMIT 0,1;");
           
        }
        if($query->num_rows() > 0){
            $inc_no = $query->row()->inc_no;
            if(isset($inc_no) && !empty($inc_no)){
                return $inc_no;    
            }else{
                return 0;
            }
        }else{
            return 0;
        }
        $this->db->close();
    }
    public function get_boq_item_variation_data($type,$project_id)
    {
            if($type == 'pos_variation'){
                $query=$this->db->query("SELECT IFNULL(SUM((design_qty-scheduled_qty)),0) as qty,
                IFNULL(SUM((design_qty-scheduled_qty) * rate_basic),0) as amount,
                IFNULL(SUM(((design_qty-scheduled_qty) * rate_basic)*(gst/100)+((design_qty-scheduled_qty) * rate_basic)),0) as amount_gst
                FROM `tbl_boq_items` 
                WHERE status='Y' AND display='Y' AND project_id = '".$project_id."' AND design_qty > scheduled_qty");    
            }else{
                $query=$this->db->query("SELECT SUM((scheduled_qty-design_qty)) as qty,
                IFNULL(SUM((scheduled_qty-design_qty) * rate_basic),0) as amount,
                IFNULL(SUM(((scheduled_qty-design_qty) * rate_basic)*(gst/100)+((scheduled_qty-design_qty) * rate_basic)),0) as amount_gst
                FROM `tbl_boq_items` 
                WHERE status='Y' AND display='Y' AND project_id = '".$project_id."' AND design_qty < scheduled_qty");    
            }
            if($query->num_rows()>0){
                return $query->row_array();
            }else{
                return 0;
            }
            $this->db->close();
    }
    public function getBOQViewOriginalAmount($project_id){
        // $query=$this->db->query("SELECT IFNULL(SUM(`scheduled_qty`),0) as total_sch_qty,
        // IFNULL(SUM(`design_qty`),0) as total_dsgnqty,
        // IFNULL(SUM(`o_design_qty`),0) as total_odsgnqty,
        // IFNULL(SUM(`rate_basic`),0) as total_basic_rate,
        // IFNULL(SUM(`rate_basic`*`scheduled_qty`),0) as total_sch_amount,
        // IFNULL(SUM(`rate_basic`*`design_qty`),0) as total_dsgn_amount,
        // IFNULL(SUM(`gst`),0) as total_gst_rate, 
        // IFNULL(SUM((`rate_basic`*`scheduled_qty`)*(`gst`/100)),0) as total_sch_gst_amount,
        // IFNULL(SUM((`rate_basic`*`scheduled_qty`)+(`rate_basic`*`scheduled_qty`)*(`gst`/100)),0) as total_sch_amount_with_gst,
        // IFNULL(SUM((`rate_basic`*`design_qty`)*(`gst`/100)),0) as total_dsgn_gst_amount,
        // IFNULL(SUM((`rate_basic`*`design_qty`)+(`rate_basic`*`design_qty`)*(`gst`/100)),0) as total_dsgn_amount_with_gst,
        // (case when (`design_qty` > scheduled_qty) then (SUM((design_qty-scheduled_qty))) else (0) END) AS total_positive_var,
        // (case when (`design_qty` < scheduled_qty) then (SUM((scheduled_qty-design_qty))) else (0) END) AS total_negative_var,
        // (case when (`design_qty` > scheduled_qty) then (SUM((design_qty-scheduled_qty) * rate_basic)) else (0) END) AS total_ea_amount,
        // (case when (`design_qty` > scheduled_qty) then (SUM(((design_qty-scheduled_qty) * rate_basic)+(((design_qty-scheduled_qty) * rate_basic)*(`gst`/100)))) else (0) END) AS total_ea_gst_amount,
        // (case when (`design_qty` < scheduled_qty) then (SUM((scheduled_qty-design_qty) * rate_basic)) else (0) END) AS total_negative_var_amount,
        // (case when (`design_qty` < scheduled_qty) then (SUM(((scheduled_qty-design_qty) * rate_basic)+(((scheduled_qty-design_qty) * rate_basic)*(`gst`/100)))) else (0) END) AS total_negative_var_gst_amount,
        // (case when (`non_schedule` ='Y') then (SUM(design_qty * rate_basic)) else (0) END) AS total_non_sch_amount,
        // (case when (`non_schedule` ='Y') then (SUM((design_qty * rate_basic)+((design_qty * rate_basic) * (`gst`/100)))) else (0) END) AS total_non_sch_gst_amount
        // FROM `view_latest_boq_items` WHERE display='Y' AND status='Y' AND project_id='".$project_id."'");
        $query = $this->db->query("
    SELECT 
        IFNULL(SUM(`scheduled_qty`), 0) AS total_sch_qty,
        IFNULL(SUM(`design_qty`), 0) AS total_dsgnqty,
        IFNULL(SUM(`o_design_qty`), 0) AS total_odsgnqty,
        IFNULL(SUM(`rate_basic`), 0) AS total_basic_rate,
        IFNULL(SUM(`rate_basic` * `scheduled_qty`), 0) AS total_sch_amount,
        IFNULL(SUM(`rate_basic` * `design_qty`), 0) AS total_dsgn_amount,
        IFNULL(SUM(`gst`), 0) AS total_gst_rate, 
        IFNULL(SUM((`rate_basic` * `scheduled_qty`) * (`gst` / 100)), 0) AS total_sch_gst_amount,
        IFNULL(SUM((`rate_basic` * `scheduled_qty`) + (`rate_basic` * `scheduled_qty`) * (`gst` / 100)), 0) AS total_sch_amount_with_gst,
        IFNULL(SUM((`rate_basic` * `design_qty`) * (`gst` / 100)), 0) AS total_dsgn_gst_amount,
        IFNULL(SUM((`rate_basic` * `design_qty`) + (`rate_basic` * `design_qty`) * (`gst` / 100)), 0) AS total_dsgn_amount_with_gst,
        
        -- Positive variance
        SUM(CASE WHEN `design_qty` > `scheduled_qty` THEN (`design_qty` - `scheduled_qty`) ELSE 0 END) AS total_positive_var,
        
        -- Negative variance
        SUM(CASE WHEN `design_qty` < `scheduled_qty` THEN (`scheduled_qty` - `design_qty`) ELSE 0 END) AS total_negative_var,
        
        -- Positive variance amount
        SUM(CASE WHEN `design_qty` > `scheduled_qty` THEN ((`design_qty` - `scheduled_qty`) * `rate_basic`) ELSE 0 END) AS total_ea_amount,
        
        -- Positive variance amount with GST
        SUM(CASE WHEN `design_qty` > `scheduled_qty` THEN ((`design_qty` - `scheduled_qty`) * `rate_basic` + ((`design_qty` - `scheduled_qty`) * `rate_basic` * (`gst` / 100))) ELSE 0 END) AS total_ea_gst_amount,
        
        -- Negative variance amount
        SUM(CASE WHEN `design_qty` < `scheduled_qty` THEN ((`scheduled_qty` - `design_qty`) * `rate_basic`) ELSE 0 END) AS total_negative_var_amount,
        
        -- Negative variance amount with GST
        SUM(CASE WHEN `design_qty` < `scheduled_qty` THEN ((`scheduled_qty` - `design_qty`) * `rate_basic` + ((`scheduled_qty` - `design_qty`) * `rate_basic` * (`gst` / 100))) ELSE 0 END) AS total_negative_var_gst_amount,
        
        -- Non-scheduled amount
        SUM(CASE WHEN `non_schedule` = 'Y' THEN (`design_qty` * `rate_basic`) ELSE 0 END) AS total_non_sch_amount,
        
        -- Non-scheduled amount with GST
        SUM(CASE WHEN `non_schedule` = 'Y' THEN (`design_qty` * `rate_basic` + (`design_qty` * `rate_basic` * (`gst` / 100))) ELSE 0 END) AS total_non_sch_gst_amount

    FROM 
        `view_latest_boq_items` 
    WHERE 
        `display` = 'Y' 
        AND `status` = 'Y' 
        AND `project_id` = " . $this->db->escape($project_id) . "
");

        if($query->num_rows()>0){
            return $query->row_array();
        }else{
            return 0;
        }
    }
    public function getBOQOperableAmount($project_id,$type){
        $whr = '';
        if($type == 'operable_a'){
        $query=$this->db->query("SELECT IFNULL(SUM(`scheduled_qty`),0) as total_sch_qty,
        IFNULL(SUM(`design_qty`),0) as total_dsgnqty,'0' AS total_positive_var,'0' AS total_negative_var,
        IFNULL(SUM(`rate_basic`),0) as total_basic_rate,
        IFNULL(SUM(`rate_basic`*`scheduled_qty`),0) as total_sch_amount,
        IFNULL(SUM(`rate_basic`*`design_qty`),0) as total_dsgn_amount,
        IFNULL(SUM(`gst`),0) as total_gst_rate, 
        IFNULL(SUM((`rate_basic`*`scheduled_qty`)*(`gst`/100)),0) as total_sch_gst_amount,
        IFNULL(SUM((`rate_basic`*`scheduled_qty`)+(`rate_basic`*`scheduled_qty`)*(`gst`/100)),0) as total_sch_amount_with_gst,
        IFNULL(SUM((`rate_basic`*`design_qty`)*(`gst`/100)),0)as total_dsgn_gst_amount,
        IFNULL(SUM((`rate_basic`*`design_qty`)+(`rate_basic`*`design_qty`)*(`gst`/100)),0) as total_dsgn_amount_with_gst
        FROM `view_latest_boq_items` WHERE display='Y' AND status='Y' AND project_id='".$project_id."' AND scheduled_qty = design_qty AND non_schedule='N'");
        }elseif($type == 'operable_b'){
        $query=$this->db->query("SELECT IFNULL(SUM(`scheduled_qty`),0) as total_sch_qty,
        IFNULL(SUM(`design_qty`),0) as total_dsgnqty,
        IFNULL(SUM(design_qty-scheduled_qty),0) as total_positive_var,
        '0' AS total_negative_var,
        IFNULL(SUM(`rate_basic`),0) as total_basic_rate,
        IFNULL(SUM(`rate_basic`*`scheduled_qty`),0) as total_sch_amount,
        IFNULL(SUM(`rate_basic`*`design_qty`),0) as total_dsgn_amount,
        IFNULL(SUM(`gst`),0) as total_gst_rate, 
        IFNULL(SUM((`rate_basic`*`scheduled_qty`)*(`gst`/100)),0) as total_sch_gst_amount,
        IFNULL(SUM((`rate_basic`*`scheduled_qty`)+(`rate_basic`*`scheduled_qty`)*(`gst`/100)),0) as total_sch_amount_with_gst,
        IFNULL(SUM((`rate_basic`*`design_qty`)*(`gst`/100)),0) as total_dsgn_gst_amount,
        IFNULL(SUM((`rate_basic`*`design_qty`)+(`rate_basic`*`design_qty`)*(`gst`/100)),0) as total_dsgn_amount_with_gst
        FROM `view_latest_boq_items` WHERE display='Y' AND status='Y' AND project_id='".$project_id."' AND design_qty > scheduled_qty AND non_schedule = 'N'");
        }elseif($type == 'operable_bn'){
        $query=$this->db->query("SELECT IFNULL(SUM(`scheduled_qty`),0) as total_sch_qty,
        IFNULL(SUM(`design_qty`),0) as total_dsgnqty,
        IFNULL(SUM(scheduled_qty-design_qty),0) as total_negative_var,
        '0' AS total_positive_var,
        IFNULL(SUM(`rate_basic`),0) as total_basic_rate,
        IFNULL(SUM(`rate_basic`*`scheduled_qty`),0) as total_sch_amount,
        IFNULL(SUM(`rate_basic`*`design_qty`),0) as total_dsgn_amount,
        IFNULL(SUM(`gst`),0) as total_gst_rate, 
        IFNULL(SUM((`rate_basic`*`scheduled_qty`)*(`gst`/100)),0) as total_sch_gst_amount,
        IFNULL(SUM((`rate_basic`*`scheduled_qty`)+(`rate_basic`*`scheduled_qty`)*(`gst`/100)),0) as total_sch_amount_with_gst,
        IFNULL(SUM((`rate_basic`*`design_qty`)*(`gst`/100)),0) as total_dsgn_gst_amount,
        IFNULL(SUM((`rate_basic`*`design_qty`)+(`rate_basic`*`design_qty`)*(`gst`/100)),0) as total_dsgn_amount_with_gst
        FROM `view_latest_boq_items` WHERE display='Y' AND status='Y' AND project_id='".$project_id."' AND design_qty < scheduled_qty AND non_schedule = 'N'");
        }elseif($type == 'operable_c'){
        $query=$this->db->query("SELECT IFNULL(SUM(`scheduled_qty`),0) as total_sch_qty,
        IFNULL(SUM(`design_qty`),0) as total_dsgnqty,
        IFNULL(SUM(scheduled_qty-design_qty),0) as total_negative_var,
        '0' AS total_positive_var,
        IFNULL(SUM(`rate_basic`),0) as total_basic_rate,
        IFNULL(SUM(`rate_basic`*`scheduled_qty`),0) as total_sch_amount,
        IFNULL(SUM(`rate_basic`*`design_qty`),0) as total_dsgn_amount,
        IFNULL(SUM(`gst`),0) as total_gst_rate, 
        IFNULL(SUM((`rate_basic`*`scheduled_qty`)*(`gst`/100)),0) as total_sch_gst_amount,
        IFNULL(SUM((`rate_basic`*`scheduled_qty`)+(`rate_basic`*`scheduled_qty`)*(`gst`/100)),0) as total_sch_amount_with_gst,
        IFNULL(SUM((`rate_basic`*`design_qty`)*(`gst`/100)),0) as total_dsgn_gst_amount,
        IFNULL(SUM((`rate_basic`*`design_qty`)+(`rate_basic`*`design_qty`)*(`gst`/100)),0) as total_dsgn_amount_with_gst
        FROM `view_latest_boq_items` WHERE display='Y' AND status='Y' AND project_id='".$project_id."' AND non_schedule = 'Y' AND design_qty > 0");
        }
        if($query->num_rows()>0){
            return $query->row_array();
        }else{
            return 0;
        }
    }
    public function getRetentionAmt(){
        $security_deposit_retn_amount = 0;
        $withheld_amount = 0;
        $query=$this->db->query("SELECT
        IFNULL(SUM(security_deposit_retn_amount),0) as security_deposit_retn_amount
        FROM `tbl_payment_receipt` prcp LEFT JOIN tbl_tax_invc ttinvc
        ON prcp.tax_incv_id = ttinvc.tax_invc_id
        WHERE ttinvc.display = 'Y' AND ttinvc.status = 'approved' AND prcp.display = 'Y'
        AND prcp.status = 'approved' AND ttinvc.invoice_closure = 'N'");
        if($query->num_rows()>0){
            $security_deposit_retn_amount =  $query->row()->security_deposit_retn_amount;
            $queryWithheld=$this->db->query("SELECT IFNULL(SUM(ttw.`withheld_amt`),0) as total_amount FROM `tbl_withheld` ttw 
            INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttw.pay_receipt_id 
            LEFT JOIN tbl_tax_invc ttinvc ON ttinvc.tax_invc_id = tpr.tax_incv_id WHERE tpr.display = 'Y' AND tpr.`status`='approved' AND ttinvc.display = 'Y' AND ttinvc.status = 'approved' AND ttinvc.invoice_closure = 'N'");
            if($queryWithheld->num_rows() > 0){
                $withheld_amt =  $queryWithheld->row()->total_amount;
                if(isset($withheld_amt) && !empty($withheld_amt) && $withheld_amt > 0){
                    $withheld_amount = $withheld_amt;    
                }
            }
            return ($withheld_amount + $security_deposit_retn_amount);
        }else{
            return 0;
        }
    }
    public function getBankGuaranteeInForce(){
        $query=$this->db->query("SELECT IFNULL(SUM(`performance_guarantee_num`),0) as performance_guarantee_num FROM `tbl_projects` WHERE display='Y' AND status = 'Y' AND `per_payment_mode`='bank_guarantee' AND project_closure = 'N'");
        if($query->num_rows()>0){
            return $query->row()->performance_guarantee_num;
        }else{
            return 0;
        }
    }
    public function getOrderAmt($type){
        $cm = date('m');
        $year = ( date('m') > 6) ? date('Y') + 1 : date('Y');
        $start_date = ($year-1).'-04-01';
        $end_date = $year.'-03-31';
        if($type == 'fy'){
        $query=$this->db->query("SELECT IFNULL(SUM(taxable_amount),0) as total_amount FROM `tbl_projects` WHERE display='Y' AND status = 'Y'
        AND DATE(created_date) BETWEEN '".$start_date."' AND '".$end_date."'");
        }else{
        $query=$this->db->query("SELECT IFNULL(SUM(taxable_amount),0) as total_amount FROM `tbl_projects` WHERE display='Y' AND status = 'Y'
        AND MONTH(created_date) = '".$cm."'");
        }
        if($query->num_rows()>0){
            return $query->row()->total_amount;
        }else{
            return 0;
        }
    }
    public function getBillingAmt($type){
        $cm = date('m');
        $year = ( date('m') > 6) ? date('Y') + 1 : date('Y');
        $start_date = ($year-1).'-04-01';
        $end_date = $year.'-03-31';
        if($type == 'fy'){
        $query=$this->db->query("SELECT IFNULL(SUM(rate*qty),0) as total_amount FROM `tbl_tax_invc_items` WHERE display='Y' AND status='approved'
        AND DATE(created_on) BETWEEN '".$start_date."' AND '".$end_date."'");
        }else{
        $query=$this->db->query("SELECT IFNULL(SUM(rate*qty),0) as total_amount FROM `tbl_tax_invc_items` WHERE display='Y' AND status='approved'
        AND MONTH(created_on) = '".$cm."'");
        }
        if($query->num_rows()>0){
            return $query->row()->total_amount;
        }else{
            return 0;
        }
    }
    public function getProformaInvoiceAmount($type){
        $cm = date('m');
        $year = ( date('m') > 6) ? date('Y') + 1 : date('Y');
        $start_date = ($year-1).'-04-01';
        $end_date = $year.'-03-31';
        if($type == 'fy'){
        $query=$this->db->query("SELECT IFNULL(SUM(pitems.rate*pitems.qty),0) as total_amount FROM `tbl_proforma_invc_items` pitems
        INNER JOIN tbl_proforma_invc tpi ON tpi.proforma_id = pitems.proforma_id
        WHERE pitems.display='Y' AND tpi.status='approved' AND tpi.Converted = 'N'
        AND DATE(tpi.created_on) BETWEEN '".$start_date."' AND '".$end_date."'");
        }else{
        $query=$this->db->query("SELECT IFNULL(SUM(pitems.rate*pitems.qty),0) as total_amount FROM `tbl_proforma_invc_items` pitems
        INNER JOIN tbl_proforma_invc tpi ON tpi.proforma_id = pitems.proforma_id
        WHERE pitems.display='Y' AND tpi.status='approved' AND tpi.Converted = 'N'
        AND MONTH(tpi.created_on) = '".$cm."'");
        }
        if($query->num_rows()>0){
            return $query->row()->total_amount;
        }else{
            return 0;
        }
    }
    public function getDepositsAmount(){
        $emd_paid_num=0;
        $performance_guarantee_num=0;
        $asd_paid_num=0;
        $final_amount=0;
        $query=$this->db->query("SELECT 
        IFNULL(SUM(`emd_paid_num`),0) as emd_paid_num,
        IFNULL(SUM(`performance_guarantee_num`),0) as performance_guarantee_num,
        IFNULL(SUM(`asd_paid_num`),0) as asd_paid_num
        FROM `tbl_projects` WHERE display='Y' AND status = 'Y' AND `per_payment_mode` !='bank_guarantee'");
        if($query->num_rows()>0){
            $emd_paid_num =  $query->row()->emd_paid_num;
            $performance_guarantee_num =  $query->row()->performance_guarantee_num;
            $asd_paid_num =  $query->row()->asd_paid_num;
            $final_amount = $emd_paid_num + $emd_paid_num + $emd_paid_num;
            return $final_amount;
        }else{
            return 0;
        }
    }
      
    public function getPaymentOverdue(){
        $invoice_amount = 0;
        $other_tax_deduction_amount = 0;
        $withheld_amount = 0;
        $other_deposit_amount = 0;
        $other_cess_amount = 0; 
        $other_deductions_amount = 0;
        $received_payment = 0;
        $statutory_deductions = 0;
        $it_tds_amount = 0;
        $gtds_amount = 0;
        $security_deposit_retn_amount = 0;
        $labour_cess_amount = 0;
        $refundables = 0;
        $nonrefundables = 0;
        $final_received_payment = 0;
        // $query=$this->db->query("SELECT 
        // (case when (gst_type = 'intra-state') then ((IFNULL(SUM(`taxable_amount`),0) + IFNULL(SUM(`sgst_amount`),0) + IFNULL(SUM(`cgst_amount`),0))) else ((IFNULL(SUM(`taxable_amount`),0) + IFNULL(SUM(`gst_amount`),0))) END) as total_amount
        // FROM `tbl_tax_invc_items` WHERE display = 'Y' AND `status`='approved'");
        $query = $this->db->query("SELECT 
        SUM(CASE 
            WHEN gst_type = 'intra-state' THEN (IFNULL(`taxable_amount`, 0) + IFNULL(`sgst_amount`, 0) + IFNULL(`cgst_amount`, 0))
            ELSE (IFNULL(`taxable_amount`, 0) + IFNULL(`gst_amount`, 0))
        END) AS total_amount
        FROM `tbl_tax_invc_items`
        WHERE display = 'Y' 
          AND `status` = 'approved'
          ");

        if($query->num_rows() > 0){
            $invoice_amount =  $query->row()->total_amount;
            if(isset($invoice_amount) && !empty($invoice_amount) && $invoice_amount > 0){
                $queryc=$this->db->query("SELECT IFNULL(SUM(`payment_received_amount`),0) as payment_received_amount,
                IFNULL(SUM(`it_tds_amount`),0) as it_tds_amount, 
                IFNULL(SUM(`gtds_amount`),0) as gtds_amount, 
                IFNULL(SUM(`security_deposit_retn_amount`),0) as security_deposit_retn_amount, 
                IFNULL(SUM(`labour_cess`),0) as labour_cess
                FROM `tbl_payment_receipt` WHERE display = 'Y' AND status = 'approved'");
                if($queryc->num_rows()>0){
                    $queryOtherTaxD=$this->db->query("SELECT IFNULL(SUM(ttx.`tax_deduction_amt`),0) as total_amount 
                    FROM `tbl_any_o_tax` ttx INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttx.pay_receipt_id 
                    WHERE tpr.display = 'Y' AND tpr.`status`='approved'");
                    if($queryOtherTaxD->num_rows() > 0){
                        $tax_deduction_amt =  $queryOtherTaxD->row()->total_amount;
                        if(isset($tax_deduction_amt) && !empty($tax_deduction_amt) && $tax_deduction_amt > 0){
                        $other_tax_deduction_amount = $tax_deduction_amt;    
                        }
                    }
                    $queryOtherDeposite=$this->db->query("SELECT IFNULL(SUM(ttd.`deposit_amount`),0) as total_amount 
                    FROM `tbl_any_o_deposit` ttd INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttd.pay_receipt_id 
                    WHERE tpr.display = 'Y' AND tpr.`status`='approved'");
                    if($queryOtherDeposite->num_rows() > 0){
                        $deposit_amount =  $queryOtherDeposite->row()->total_amount;
                        if(isset($deposit_amount) && !empty($deposit_amount) && $deposit_amount > 0){
                        $other_deposit_amount = $deposit_amount;    
                        }
                    }
                    $queryWithheld=$this->db->query("SELECT IFNULL(SUM(ttw.`withheld_amt`),0) as total_amount 
                    FROM `tbl_withheld` ttw INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttw.pay_receipt_id 
                    WHERE tpr.display = 'Y' AND tpr.`status`='approved'");
                    if($queryWithheld->num_rows() > 0){
                        $withheld_amt =  $queryWithheld->row()->total_amount;
                        if(isset($withheld_amt) && !empty($withheld_amt) && $withheld_amt > 0){
                        $withheld_amount = $withheld_amt;    
                        }
                    }
                    $queryCess=$this->db->query("SELECT IFNULL(SUM(ttoc.`other_cess_amt`),0) as total_amount 
                    FROM `tbl_any_o_cess` ttoc INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttoc.pay_receipt_id 
                    WHERE tpr.display = 'Y' AND tpr.`status`='approved'");
                    if($queryCess->num_rows() > 0){
                        $other_cess_amt =  $queryCess->row()->total_amount;
                        if(isset($other_cess_amt) && !empty($other_cess_amt) && $other_cess_amt > 0){
                        $other_cess_amount = $other_cess_amt;    
                        }
                    }
                    $queryOtherD=$this->db->query("SELECT IFNULL(SUM(ttod.`deduction_amt`),0) as total_amount 
                    FROM `tbl_any_o_deduction` ttod INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttod.pay_receipt_id 
                    WHERE tpr.display = 'Y' AND tpr.`status`='approved'");
                    if($queryOtherD->num_rows() > 0){
                        $deduction_amt =  $queryOtherD->row()->total_amount;
                        if(isset($deduction_amt) && !empty($deduction_amt) && $deduction_amt > 0){
                            $other_deductions_amount = $deduction_amt;    
                        }
                    }
                    $payment_received_amount =  $queryc->row()->payment_received_amount;
                    if(isset($payment_received_amount) && !empty($payment_received_amount) && $payment_received_amount > 0){
                        $received_payment  = $payment_received_amount;
                    }
            
                    $it_tds_amount =  $queryc->row()->it_tds_amount;
                    if(isset($it_tds_amount) && !empty($it_tds_amount) && $it_tds_amount > 0){
                        $it_tds_amount  = $it_tds_amount;
                    }
                    $gtds_amount =  $queryc->row()->gtds_amount;
                    if(isset($gtds_amount) && !empty($gtds_amount) && $gtds_amount > 0){
                        $gtds_amount  = $gtds_amount;
                    }
                    $statutory_deductions = $it_tds_amount + $gtds_amount + $other_tax_deduction_amount;
                    
                    $security_deposit_retn_amount =  $queryc->row()->security_deposit_retn_amount;
                    if(isset($security_deposit_retn_amount) && !empty($security_deposit_retn_amount) && $security_deposit_retn_amount > 0){
                        $security_deposit_retn_amount  = $security_deposit_retn_amount;
                    }
                    $labour_cess =  $queryc->row()->labour_cess;
                    if(isset($labour_cess) && !empty($labour_cess) && $labour_cess > 0){
                        $labour_cess_amount  = $labour_cess;
                    }
                    $refundables = $security_deposit_retn_amount + $other_deposit_amount + $withheld_amount;
                    $nonrefundables = $labour_cess_amount + $other_cess_amount + $other_deductions_amount;
                    $final_received_payment = $received_payment + $nonrefundables + $statutory_deductions;
                    $rec = 0;
                    if($invoice_amount >= $final_received_payment){
                        $rec =  $invoice_amount - $final_received_payment;   
                    }
                    if(isset($rec) && !empty($rec) && $rec > 0){
                        $rec = sprintf('%0.2f', $rec);
                    }else{
                        $rec = 0.00;
                    }
                    return $rec;
                }else{
                    return 0;
                }    
            }else{
                return 0;
            }
        }else{
            return 0;
        }
        
    }
    public function getCollectionsAmount($type){
        $invoice_amount = 0;
        $other_tax_deduction_amount = 0;
        $withheld_amount = 0;
        $other_deposit_amount = 0;
        $other_cess_amount = 0; 
        $other_deductions_amount = 0;
        $received_payment = 0;
        $statutory_deductions = 0;
        $it_tds_amount = 0;
        $gtds_amount = 0;
        $security_deposit_retn_amount = 0;
        $labour_cess_amount = 0;
        $refundables = 0;
        $nonrefundables = 0;
        $final_received_payment = 0;
        $cm = date('m');
        $year = ( date('m') > 6) ? date('Y') + 1 : date('Y');
        $start_date = ($year-1).'-04-01';
        $end_date = $year.'-03-31';
        $whr="";
        $whr1="";
        if($type == 'fy'){
            $whr =" AND DATE(created_on) BETWEEN '".$start_date."' AND '".$end_date."'";
            $whr1 =" AND DATE(created_date) BETWEEN '".$start_date."' AND '".$end_date."'";
        }else{
            $whr =" AND MONTH(created_on) = '".$cm."'";
            $whr1 =" AND MONTH(created_date) = '".$cm."'";
        }
        
        // $query=$this->db->query("SELECT 
        // (case when (gst_type = 'intra-state') then ((IFNULL(SUM(`taxable_amount`),0) + IFNULL(SUM(`sgst_amount`),0) + IFNULL(SUM(`cgst_amount`),0))) else ((IFNULL(SUM(`taxable_amount`),0) + IFNULL(SUM(`gst_amount`),0))) END) as total_amount
        // FROM `tbl_tax_invc_items` WHERE display = 'Y' AND `status`='approved' $whr");
        $query = $this->db->query("SELECT 
        SUM(CASE 
            WHEN gst_type = 'intra-state' THEN (IFNULL(`taxable_amount`, 0) + IFNULL(`sgst_amount`, 0) + IFNULL(`cgst_amount`, 0))
            ELSE (IFNULL(`taxable_amount`, 0) + IFNULL(`gst_amount`, 0))
        END) AS total_amount
        FROM `tbl_tax_invc_items`
        WHERE display = 'Y' 
          AND `status` = 'approved' 
          $whr GROUP BY gst_type");

        // print_r($query);
        if($query->num_rows() > 0){
            $invoice_amount =  $query->row()->total_amount;
            if(isset($invoice_amount) && !empty($invoice_amount) && $invoice_amount > 0){
                $queryc=$this->db->query("SELECT IFNULL(SUM(`payment_received_amount`),0) as payment_received_amount,
                IFNULL(SUM(`it_tds_amount`),0) as it_tds_amount, 
                IFNULL(SUM(`gtds_amount`),0) as gtds_amount, 
                IFNULL(SUM(`security_deposit_retn_amount`),0) as security_deposit_retn_amount, 
                IFNULL(SUM(`labour_cess`),0) as labour_cess
                FROM `tbl_payment_receipt` WHERE display = 'Y' AND status = 'approved' $whr1");
                if($queryc->num_rows()>0){
                    $queryOtherTaxD=$this->db->query("SELECT IFNULL(SUM(ttx.`tax_deduction_amt`),0) as total_amount 
                    FROM `tbl_any_o_tax` ttx INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttx.pay_receipt_id 
                    WHERE tpr.display = 'Y' AND tpr.`status`='approved' $whr1");
                    if($queryOtherTaxD->num_rows() > 0){
                        $tax_deduction_amt =  $queryOtherTaxD->row()->total_amount;
                        if(isset($tax_deduction_amt) && !empty($tax_deduction_amt) && $tax_deduction_amt > 0){
                        $other_tax_deduction_amount = $tax_deduction_amt;    
                        }
                    }
                    $queryOtherDeposite=$this->db->query("SELECT IFNULL(SUM(ttd.`deposit_amount`),0) as total_amount 
                    FROM `tbl_any_o_deposit` ttd INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttd.pay_receipt_id 
                    WHERE tpr.display = 'Y' AND tpr.`status`='approved' $whr1");
                    if($queryOtherDeposite->num_rows() > 0){
                        $deposit_amount =  $queryOtherDeposite->row()->total_amount;
                        if(isset($deposit_amount) && !empty($deposit_amount) && $deposit_amount > 0){
                        $other_deposit_amount = $deposit_amount;    
                        }
                    }
                    $queryWithheld=$this->db->query("SELECT IFNULL(SUM(ttw.`withheld_amt`),0) as total_amount 
                    FROM `tbl_withheld` ttw INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttw.pay_receipt_id 
                    WHERE tpr.display = 'Y' AND tpr.`status`='approved' $whr1");
                    if($queryWithheld->num_rows() > 0){
                        $withheld_amt =  $queryWithheld->row()->total_amount;
                        if(isset($withheld_amt) && !empty($withheld_amt) && $withheld_amt > 0){
                        $withheld_amount = $withheld_amt;    
                        }
                    }
                    $queryCess=$this->db->query("SELECT IFNULL(SUM(ttoc.`other_cess_amt`),0) as total_amount 
                    FROM `tbl_any_o_cess` ttoc INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttoc.pay_receipt_id 
                    WHERE tpr.display = 'Y' AND tpr.`status`='approved' $whr1");
                    if($queryCess->num_rows() > 0){
                        $other_cess_amt =  $queryCess->row()->total_amount;
                        if(isset($other_cess_amt) && !empty($other_cess_amt) && $other_cess_amt > 0){
                        $other_cess_amount = $other_cess_amt;    
                        }
                    }
                    $queryOtherD=$this->db->query("SELECT IFNULL(SUM(ttod.`deduction_amt`),0) as total_amount 
                    FROM `tbl_any_o_deduction` ttod INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttod.pay_receipt_id 
                    WHERE tpr.display = 'Y' AND tpr.`status`='approved' $whr1");
                    if($queryOtherD->num_rows() > 0){
                        $deduction_amt =  $queryOtherD->row()->total_amount;
                        if(isset($deduction_amt) && !empty($deduction_amt) && $deduction_amt > 0){
                            $other_deductions_amount = $deduction_amt;    
                        }
                    }
                    $payment_received_amount =  $queryc->row()->payment_received_amount;
                    if(isset($payment_received_amount) && !empty($payment_received_amount) && $payment_received_amount > 0){
                        $received_payment  = $payment_received_amount;
                    }
            
                    $it_tds_amount =  $queryc->row()->it_tds_amount;
                    if(isset($it_tds_amount) && !empty($it_tds_amount) && $it_tds_amount > 0){
                        $it_tds_amount  = $it_tds_amount;
                    }
                    $gtds_amount =  $queryc->row()->gtds_amount;
                    if(isset($gtds_amount) && !empty($gtds_amount) && $gtds_amount > 0){
                        $gtds_amount  = $gtds_amount;
                    }
                    $statutory_deductions = $it_tds_amount + $gtds_amount + $other_tax_deduction_amount;
                    
                    $security_deposit_retn_amount =  $queryc->row()->security_deposit_retn_amount;
                    if(isset($security_deposit_retn_amount) && !empty($security_deposit_retn_amount) && $security_deposit_retn_amount > 0){
                        $security_deposit_retn_amount  = $security_deposit_retn_amount;
                    }
                    $labour_cess =  $queryc->row()->labour_cess;
                    if(isset($labour_cess) && !empty($labour_cess) && $labour_cess > 0){
                        $labour_cess_amount  = $labour_cess;
                    }
                    $refundables = $security_deposit_retn_amount + $other_deposit_amount + $withheld_amount;
                    $nonrefundables = $labour_cess_amount + $other_cess_amount + $other_deductions_amount;
                    $final_received_payment = $received_payment + $nonrefundables + $statutory_deductions;
                    if(isset($final_received_payment) && !empty($final_received_payment) && $final_received_payment > 0){
                        $final_received_payment = sprintf('%0.2f', $final_received_payment);
                    }else{
                        $final_received_payment = 0.00;
                    }
                    return $final_received_payment;
                }else{
                    return 0;
                }    
            }else{
                return 0;
            }
        }else{
            return 0;
        }
        
    }
    public function ProjNotReadNotification($id){
        $query=$this->db->query("SELECT * FROM `tbl_admin_notif` WHERE `display`='Y' AND `read_noti`='N'");
        if($query->num_rows()>0){
            return $query->result();
        }else{
            return null;
        }
    }
    public function getProformaApprovedQty($project_id,$boq_code){
        $installed_qty=0;
        $provisional_qty=0;
        $profrma_qty=0;
        $tax_qty=0;
        $queryInstalled = $this->db->query("SELECT IFNULL(SUM(td.`installed_qty`),0) as approved_qty
        FROM `tbl_install_wip_items` td 
        INNER JOIN tbl_installed_wip tdc ON tdc.i_wip_id = td.i_wip_id  
        WHERE td.display='Y' AND td.status='approved' AND td.`boq_code`='".$boq_code."' AND tdc.project_id = '".$project_id."'
        AND tdc.display='Y' AND tdc.status = 'approved'");
        if($queryInstalled->num_rows()>0){
            $installed_qty =  $queryInstalled->row()->approved_qty;
            if(isset($installed_qty) && !empty($installed_qty)){
                $installed_qty = $installed_qty;    
            }
        }
        $queryProv = $this->db->query("SELECT IFNULL(SUM(td.`prov_qty`),0) as approved_qty
        FROM `tbl_prov_wip_items` td 
        INNER JOIN tbl_provisional_wip tdc ON tdc.p_wip_id = td.p_wip_id  
        WHERE td.display='Y' AND td.status='approved' AND td.`boq_code`='".$boq_code."' AND tdc.project_id = '".$project_id."'
        AND tdc.display='Y' AND tdc.status = 'approved'");
        if($queryProv->num_rows()>0){
            $provisional_qty =  $queryProv->row()->approved_qty;
            if(isset($provisional_qty) && !empty($provisional_qty)){
                $provisional_qty = $provisional_qty;    
            }
        }
        $queryProforma = $this->db->query("SELECT IFNULL(SUM(td.`qty`),0) as approved_qty
        FROM `tbl_proforma_invc_items` td 
        INNER JOIN tbl_proforma_invc tdc ON tdc.proforma_id = td.proforma_id  
        WHERE td.display='Y' AND td.status!='reject' AND td.`boq_code`='".$boq_code."' AND tdc.project_id = '".$project_id."'
        AND tdc.display='Y' AND tdc.status != 'reject'");
        if($queryProforma->num_rows()>0){
            $profrma_qty =  $queryProforma->row()->approved_qty;
            if(isset($profrma_qty) && !empty($profrma_qty)){
                $profrma_qty = $profrma_qty;    
            }
        }
        if(($provisional_qty + $installed_qty) > $profrma_qty){
           return (($provisional_qty + $installed_qty) - $profrma_qty); 
        }else{
            return 0;
        }
    }
    public function getTaxInvApprovedQty($project_id,$boq_code){
        $installed_qty=0;
        $provisional_qty=0;
        $profrma_qty=0;
        $tax_qty=0;
        $queryInstalled = $this->db->query("SELECT IFNULL(SUM(td.`installed_qty`),0) as approved_qty
        FROM `tbl_install_wip_items` td 
        INNER JOIN tbl_installed_wip tdc ON tdc.i_wip_id = td.i_wip_id  
        WHERE td.display='Y' AND td.status='approved' AND td.`boq_code`='".$boq_code."' AND tdc.project_id = '".$project_id."'
        AND tdc.display='Y' AND tdc.status = 'approved'");
        if($queryInstalled->num_rows()>0){
            $installed_qty =  $queryInstalled->row()->approved_qty;
            if(isset($installed_qty) && !empty($installed_qty)){
                $installed_qty = $installed_qty;    
            }
        }
        $queryProv = $this->db->query("SELECT IFNULL(SUM(td.`prov_qty`),0) as approved_qty
        FROM `tbl_prov_wip_items` td 
        INNER JOIN tbl_provisional_wip tdc ON tdc.p_wip_id = td.p_wip_id  
        WHERE td.display='Y' AND td.status='approved' AND td.`boq_code`='".$boq_code."' AND tdc.project_id = '".$project_id."'
        AND tdc.display='Y' AND tdc.status = 'approved'");
        if($queryProv->num_rows()>0){
            $provisional_qty =  $queryProv->row()->approved_qty;
            if(isset($provisional_qty) && !empty($provisional_qty)){
                $provisional_qty = $provisional_qty;    
            }
        }
        $queryTaxInv = $this->db->query("SELECT IFNULL(SUM(td.`qty`),0) as approved_qty
        FROM `tbl_tax_invc_items` td 
        INNER JOIN tbl_tax_invc tdc ON tdc.tax_invc_id = td.tax_invc_id  
        WHERE td.display='Y' AND td.status!='reject' AND td.`boq_code`='".$boq_code."' AND tdc.project_id = '".$project_id."'
        AND tdc.display='Y' AND tdc.status != 'reject'");
        if($queryTaxInv->num_rows()>0){
            $tax_qty =  $queryTaxInv->row()->approved_qty;
            if(isset($tax_qty) && !empty($tax_qty)){
                $tax_qty = $tax_qty;    
            }
        }
        if(($provisional_qty + $installed_qty) > $tax_qty){
           return (($provisional_qty + $installed_qty) - $tax_qty); 
        }else{
            return 0;
        }
    }
    
    public function getTotalApprovedQty($project_id,$boq_code){
        $boq_qty = 0;
        $pending_EA_qty = 0;
        $approved_EA_qty = 0;
        $dc_qty = 0;
        $queryBOQ = $this->db->query("SELECT IFNULL(design_qty,0) as design_qty  FROM `tbl_boq_items` WHERE `project_id`='".$project_id."' AND `boq_code`='".$boq_code."'  ORDER BY `boq_items_id` DESC LIMIT 0,1");
        if($queryBOQ->num_rows()>0){
            $boq_qty =  $queryBOQ->row()->design_qty;
            if(isset($boq_qty) && !empty($boq_qty)){
                $boq_qty = $boq_qty;    
            }
        }
        $querypEA = $this->db->query("SELECT IFNULL(EA_qty,0) as EA_qty  FROM `tbl_boq_exceptional` WHERE `project_id`='".$project_id."' AND `boq_code`='".$boq_code."'  
        AND display='Y' AND status != 'approved'");
        if($querypEA->num_rows()>0){
            $pending_EA_qty =  $querypEA->row()->EA_qty;
            if(isset($pending_EA_qty) && !empty($pending_EA_qty)){
                $pending_EA_qty = $pending_EA_qty;    
            }
        }
        $queryDC = $this->db->query("SELECT IFNULL(SUM(td.`qty`),0) as approved_qty
        FROM `tbl_deliv_challan_items` td 
        INNER JOIN tbl_delivery_challan tdc ON tdc.challan_id = td.challan_id  
        WHERE td.display='Y' AND td.status='approved' AND td.`boq_code`='".$boq_code."' AND tdc.project_id = '".$project_id."'
        AND tdc.display='Y' AND tdc.status = 'approved'");
        if($queryDC->num_rows()>0){
            $dc_qty =  $queryDC->row()->approved_qty;
            if(isset($dc_qty) && !empty($dc_qty)){
                $dc_qty = $dc_qty;    
            }
        }
        if(($boq_qty + $pending_EA_qty) > $dc_qty){
           return (($boq_qty + $pending_EA_qty) - $dc_qty); 
        }else{
            return 0;
        }
    }
    public function getDCApprovedQty($project_id,$boq_code){
        $dc_qty = 0;
        $dc_installed_qty = 0;
        $dc_prov_qty = 0;
        $queryDC = $this->db->query("SELECT IFNULL(SUM(td.`qty`),0) as approved_qty
        FROM `tbl_deliv_challan_items` td 
        INNER JOIN tbl_delivery_challan tdc ON tdc.challan_id = td.challan_id  
        WHERE td.display='Y' AND td.status='approved' AND td.`boq_code`='".$boq_code."' AND tdc.project_id = '".$project_id."'
        AND tdc.display='Y' AND tdc.status = 'approved'");
        if($queryDC->num_rows()>0){
            $dc_qty =  $queryDC->row()->approved_qty;
            if(isset($dc_qty) && !empty($dc_qty)){
                $dc_qty = $dc_qty;    
            }
        }
        $queryInstall = $this->db->query("SELECT IFNULL(SUM(td.`installed_qty`),0) as approved_qty
        FROM `tbl_install_wip_items` td 
        INNER JOIN tbl_installed_wip tdc ON tdc.i_wip_id = td.i_wip_id  
        WHERE td.display='Y' AND td.status='approved' AND td.`boq_code`='".$boq_code."' AND tdc.project_id = '".$project_id."'
        AND tdc.display='Y' AND tdc.status = 'approved'");
        if($queryInstall->num_rows()>0){
            $dc_installed_qty =  $queryInstall->row()->approved_qty;
            if(isset($dc_installed_qty) && !empty($dc_installed_qty)){
                $dc_installed_qty = $dc_installed_qty;    
            }
        }
        $queryProv = $this->db->query("SELECT IFNULL(SUM(td.`prov_qty`),0) as approved_qty
        FROM `tbl_prov_wip_items` td 
        INNER JOIN tbl_provisional_wip tdc ON tdc.p_wip_id = td.p_wip_id  
        WHERE td.display='Y' AND td.status='approved' AND td.`boq_code`='".$boq_code."' AND tdc.project_id = '".$project_id."'
        AND tdc.display='Y' AND tdc.status = 'approved'");
        if($queryProv->num_rows()>0){
            $dc_prov_qty =  $queryProv->row()->approved_qty;
            if(isset($dc_prov_qty) && !empty($dc_prov_qty)){
                $dc_prov_qty = $dc_prov_qty;    
            }
        }
        if($dc_qty >= ($dc_prov_qty + $dc_installed_qty)){
            return  ($dc_qty - ($dc_prov_qty + $dc_installed_qty));    
        }elseif($dc_prov_qty > 0){
            return  'provisional-'.$dc_prov_qty;    
        }else{
            return 0;
        }
    }
    
    public function ProjNotReadReminder($id){
        $query=$this->db->query("SELECT * FROM `tbl_admin_remind` WHERE `display`='Y' AND `read_noti`='N'");
        if($query->num_rows()>0){
            return $query->result();
        }else{
            return null;
        }
    }
    public function NotReadNotification(){
        $query=$this->db->query("SELECT * FROM `tbl_admin_notif` WHERE `display`='Y' AND `read_noti`='N'");
        if($query->num_rows()>0){
            return $query->result();
        }else{
            return null;
        }
    }
    public function NotReadReminder(){
        $query=$this->db->query("SELECT * FROM `tbl_admin_remind` WHERE `display`='Y' AND `read_noti`='N'");
        if($query->num_rows()>0){
            return $query->result();
        }else{
            return null;
        }
    }
    
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hr',
            'i' => 'min',
            's' => 'sec',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string): 'just now';
    }
    public function SaveMultiData($tablename,$data) {
        $query=$this->db->insert_batch($tablename,$data); 
        if($query) {
            return true; 
        } else {
            return false; 
        } 
    } 
    public function updateBOQExceptional($data,$project_id) {
        $this->db->where('project_id',$project_id);
		$query = $this->db->update_batch('tbl_boq_exceptional',$data,'boq_code'); 
		if($query) {
			return true; 
		} else {
			return false; 
		} 
	}
	public function updateBOQInstallStock($data,$project_id) {
	   // pr($data,1);
        $this->db->where('project_id',$project_id);
		$query = $this->db->update_batch('tbl_boq_stock',$data,'boq_code'); 
		if($query) {
			return true; 
		} else {
			return false; 
		} 
	}
	
    public function insert_record($tbl_name, $record) {
        return $this->db->insert($tbl_name, $record);
    }
    public function addData($tablename,$data) 
    {
         
          
        $query=$this->db->insert($tablename,$data); 
        $user_id= $this->db->insert_id(); 
        if($query) {
            return $user_id; 
        } 
        else {
            return false; 
        } 
    }
    public function fetchDataDESC($table_name, $asc_by_col_name)
	{		
		$this->db->select('*')->from($table_name)->where('display', 'Y')->order_by($asc_by_col_name, "DESC");  
		$query = $this->db->get();

		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	public function last_custcode()
	{		
		$query = $this->db->query("SELECT `customer_code` FROM `tbl_projects` ORDER BY `project_id` DESC LIMIT 0,1");
        if($query->num_rows()>0)
		{
			return $query->row()->customer_code;
		}
		else
		{
			return 0;
		}
	}
	public function updateDetails($tblname,$where,$condition,$data) 
    {
        $this->db->where($where, $condition); 
        $query = $this->db->update($tblname, $data); 
        return $query; 
    }
	public function updateBOQStockDetails($data,$project_id,$boq_code) 
    {
        $this->db->where('project_id', $project_id); 
        $this->db->where('boq_code', $boq_code); 
        $query = $this->db->update('tbl_boq_stock', $data); 
        return $query; 
    }
	public function updateDetailscomp($tblname,$where,$condition,$where1,$condition1,$data) 
    {
        $this->db->where($where, $condition); 
        $this->db->where($where1, $condition1); 
        $query = $this->db->update($tblname, $data); 
        return $query; 
    }
	public function selectDetailsWhr($tblname,$where,$condition)
	{
		$this->db->where($where,$condition);
		$query = $this->db->get($tblname);
		if($query->num_rows() > 0){	
			return $query->row();
		}
		else
		{
			return false;
		}			
	}
	public function selectDetailsWhrArry($tblname,$where,$condition)
	{
		$this->db->where($where,$condition);
		$query = $this->db->get($tblname);
		if($query->num_rows() > 0){	
			return $query->row_array();
		}
		else
		{
			return false;
		}			
	}
	public function selectDetailsWhere($tblname,$where,$condition)
	{
		$this->db->where($where,$condition);
		$query = $this->db->get($tblname);
		if($query->num_rows() > 0){	

            foreach ($query->result() as $row)
            {
                $tbl_data[]=$row;
            }
			return $tbl_data;
		}
		else
		{
			return false;
		}			
	}
	public function selectDetailsWhereAllDY($tblname,$where,$condition)
	{
		$this->db->where($where,$condition);
		$this->db->where('display','Y');
		$query = $this->db->get($tblname);
		if($query->num_rows()> 0){	

            foreach ($query->result() as $row)
            {
                $tbl_data[]=$row;
            }
			return $tbl_data;
		}
		else
		{
			return false;
		}			
	}
	public function selectDetailsWhereAll($tblname,$where,$condition)
	{
		$this->db->where($where,$condition);
		$query = $this->db->get($tblname);
		if($query->num_rows()> 0){	

            foreach ($query->result() as $row)
            {
                $tbl_data[]=$row;
            }
			return $tbl_data;
		}
		else
		{
			return false;
		}			
	}
	public function existbpcode($bp_code)
	{
		$this->db->where('bp_code',$bp_code);
		$this->db->where('display','Y');
		$query = $this->db->get('tbl_projects');
		if($query->num_rows() > 0){	
			return $query->row();
		}else{
			return false;
		}			
	}
	
	public function tbl_city_name($tbl)
    {
        $query= $this->db->query("SELECT DISTINCT tbl2.city_name FROM $tbl as tbl1 left join tbl_city as tbl2 on tbl2.city_id=tbl1.city_id where tbl1.display='Y' order by tbl2.city_name ASC");
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }   
    }
    public function selectAllWhrDsc($tblname,$where,$condition,$dsc)
    {
        $this->db->where($where,$condition)->where('display','Y' && 'visibility','Active')->order_by($dsc,"DESC");
        $query = $this->db->get($tblname);
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $tbl_data[]=$row;
            }
            return $tbl_data;
        }
        else
        {
            return false;
        }       
    }
    public function selectAllWhr($tblname,$where,$condition)
    {
        $this->db->where($where,$condition);
        $this->db->where('display','Y');
        $query = $this->db->get($tblname);
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $tbl_data[]=$row;
            }
            return $tbl_data;
        }
        else
        {
            return false;
        }       
    }
    public function selectAllconsineeWhr($tblname,$where,$condition)
    {
        $this->db->where($where,$condition);
       
        $query = $this->db->get($tblname);
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $tbl_data[]=$row;
            }
            return $tbl_data;
        }
        else
        {
            return false;
        }       
    }
    public function fetchDataDESClimit($table_name, $dsc_by_col_name, $limit)
    {       
        $this->db->select('*')->from($table_name)->where('display', 'Y')->order_by($dsc_by_col_name, "DESC")->limit($limit);
        $qry = $this->db->get();

        if($qry->num_rows()>0)
        {
            foreach ($qry->result() as $row)
            {
                $tbl_data[]=$row;
            }
            return $tbl_data;
        }
        else
        {
            return false;
        }
    }
    public function fetchDataASC($table_name, $asc_by_col_name) 
    {
        $this->db->select('*')->from($table_name)->where('display', 'Y')->order_by($asc_by_col_name, "asc"); 
        $qry = $this->db->get(); 
        if($qry->num_rows()>0) 
        {
            return $qry->result();
        } 
        else 
        {
            return false; 
        } 
    }

    public function alljoin2tbl($tbl1,$tbl2,$where)
    {
        $query=$this->db->query("SELECT * from $tbl1 tbl1 left join $tbl2 tbl2 on tbl1.$where=tbl2.$where where  tbl1.display='Y' AND tbl2.display='Y'");
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $tbl_data[]=$row;
            }
            return $tbl_data;
        }
        else
        {
            return false;
        }
    }

    public function selectMultiDataFor($tblname,$where1,$where2,$condition1,$condition2)
    {
        $this->db->where($where1,$condition1);
        $this->db->where($where2,$condition2);
        $this->db->where('display','Y');
        $query = $this->db->get($tblname);

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $tbl_data[]=$row;
            }
            return $tbl_data;
        }
        else
        {
            return false;
        }
    }
    public function selectMultiDataForcom($tblname,$where1,$where2,$condition1,$condition2)
    {
        $this->db->where($where1,$condition1);
        $this->db->where($where2,$condition2);
        $this->db->where('display','Y');
        $query = $this->db->get($tblname);
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $tbl_data[]=$row;
            }
            return $tbl_data;
        }
        else
        {
            return false;
        }
    }
    public function singlejoin2tbl($tbl1,$tbl2,$where,$condition,$id)
    {
        $query=$this->db->query("SELECT * from $tbl1 tbl1 left join $tbl2 tbl2 on tbl1.$where=tbl2.$where where tbl1.$condition=$id AND tbl1.display='Y' AND tbl2.display='Y'");
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }
    }
    public function duplicate($id,$p_key,$tbl,$where,$value) 
    {
        if (empty($value)) 
        {
            return FALSE; 
        } 
        $query=$this->db->query("SELECT COUNT(*) AS numrows FROM $tbl WHERE $where = ? AND $p_key != ? AND display='Y'",array($value,$id)); 
        if($query->num_rows()==1) 
        {
            return $query->row(); 
        } 
        else 
        {
            return false; 
        } 
    }

    public function deleteRow($table, $id){
        $query=$this->db->query("DELETE from $table WHERE id =$id");
        
            return $query;
        
    }
    public function deleteRowWhere($table,$whr){
        $this->db->where($whr);
        $this->db->delete($table);
    }


    public function selectDetailsWhereArr($tblname,$arr)
	{
        foreach($arr as $key => $value) {
           
            $this->db->where($key,$value);
        }
		$query = $this->db->get($tblname);
		if($query->num_rows() > 0){	
            foreach ($query->result() as $row)
            {
                $tbl_data[]=$row;
            }
			return $tbl_data;
		}
		else
		{
			return false;
		}			
	}

    public function selectDetailsWhereArrBom($tblname,$arr)
	{
        foreach($arr as $key => $value) {
           
            $this->db->where($key,$value);
        }
        
        // $this->db->order_by('bom_items_id', 'asc');
        // $this->db->group_by('bom_code'); 
		$query = $this->db->get($tblname);
		if($query->num_rows() > 0){	
            foreach ($query->result() as $row)
            {
                $tbl_data[]=$row;
            }
			return $tbl_data;
		}
		else
		{
			return false;
		}			
	}

    public function updateBOMStock($data, $project_id, $boq_code) {
        $this->db->where('project_id',$project_id);
        $this->db->where('boq_code',$boq_code);
		$query = $this->db->update_batch('tbl_bom_stock',$data,'bom_code'); 
		if($query) {
			return true; 
		} else {
			return false; 
		} 
	}

    public function get_bom_stock_data($project_id, $boq_code, $bom_code) {
        $this->db->select('*');
		$this->db->from('tbl_bom_stock');
		$this->db->where('project_id',$project_id);
        $this->db->where('boq_code', $boq_code);
        $this->db->where('bom_code', $bom_code);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return 0;
        }
    }

    public function get_bom_exceptional_stock_data($project_id, $boq_code, $bom_code, $transaction_id) {
        $this->db->select('*');
		$this->db->from('tbl_bom_exceptional');
		$this->db->where('project_id',$project_id);
        $this->db->where('boq_code', $boq_code);
        $this->db->where('bom_code', $bom_code);
        $this->db->where('transaction_id', $transaction_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return 0;
        }
    }

    public function get_bom_release_stock_data($project_id, $boq_code, $bom_code) {
        $this->db->select('*');
		$this->db->from('tbl_bom_release_stock');
		$this->db->where('project_id',$project_id);
        $this->db->where('boq_code', $boq_code);
        $this->db->where('bom_code', $bom_code);
        $this->db->order_by('bom_release_id','desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return 0;
        }
    }

    public function get_boq_release_stock_data($project_id, $boq_code) {
        $this->db->select('*');
		$this->db->from('tbl_boq_release_stock');
		$this->db->where('project_id',$project_id);
        $this->db->where('boq_code', $boq_code);
        $this->db->order_by('boq_release_id','desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return 0;
        }
    }

    public function get_bom_release_stock_data_pending($project_id, $boq_code, $bom_code) {
        $this->db->select('*');
		$this->db->from('tbl_bom_release_stock');
		$this->db->where('project_id',$project_id);
        $this->db->where('boq_code', $boq_code);
        $this->db->where('bom_code', $bom_code);
        $this->db->where('status', 'pending');
        $this->db->or_where('status','reject');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return 0;
        }
    }

    public function get_bom_release_boq_item_data($project_id, $boq_code) {
        $this->db->select('bomitem.boq_code,bomitem.gst,bomitem.bom_code, bomitem.hsn_sac_code, 
        bomitem.item_description, bomitem.unit, bomitem.rate_basic, tblrstock.released_quantity,bomitem.make,bomitem.model,bomitem.bom_ratio');
        $this->db->from('tbl_bom_release_stock tblrstock');
        $this->db->join('(SELECT boq_code, bom_code, MAX(bom_items_id) as max_id FROM tbl_bom_items GROUP BY boq_code, bom_code) latest_bom', 'latest_bom.boq_code = tblrstock.boq_code AND latest_bom.bom_code = tblrstock.bom_code');
        $this->db->join('tbl_bom_items bomitem', 'tblrstock.boq_code = bomitem.boq_code AND tblrstock.project_id = bomitem.project_id AND tblrstock.bom_code = bomitem.bom_code AND latest_bom.max_id = bomitem.bom_items_id');
        $this->db->where('tblrstock.project_id', $project_id);
        $this->db->where('tblrstock.boq_code', $boq_code);
        $this->db->where('tblrstock.status', 'reject');
        $this->db->order_by('tblrstock.bom_code', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }
    public function get_stop_vendor_name() {
        $this->db->distinct();
        $this->db->select('v.name_of_company as vendor_name,v.vendor_id as vendor_id');
		$this->db->from('tbl_debit_note_items as db');
        $this->db->join('tbl_vendor as v','v.vendor_id = db.vendor_id');
        $this->db->group_by('db.vdc_number');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_stop_vendors_details($vendor_id = array()) {
        $this->db->distinct();
        $this->db->select('v.name_of_company as vendor_name, v.vendor_id as vendor_id, db.vdc_number, SUM(db.advance_payment) as advance_payment, wb.id as write_off_back_id, wb.approval as approval_status');
        $this->db->from('tbl_debit_note_items as db');
        $this->db->join('tbl_vendor as v', 'v.vendor_id = db.vendor_id');
        $this->db->join('tbl_write_off_back as wb', 'wb.vdc_number = db.vdc_number', 'left');
        $this->db->group_by('db.vdc_number');
        $this->db->where_in('v.vendor_id', $vendor_id);  // Assuming $vendor_id is an array of vendor ids
        $query = $this->db->get();
        return $query->result_array();

    }
    public function get_stop_vendor_details($vendor_id = 0) {
        $this->db->distinct();
        $this->db->select('v.name_of_company as vendor_name,v.vendor_id as vendor_id,db.vdc_number,SUM(db.advance_payment) as advance_payment,wb.id as write_off_back_id');
		$this->db->from('tbl_debit_note_items as db');
        $this->db->join('tbl_vendor as v','v.vendor_id = db.vendor_id');
        $this->db->join('tbl_write_off_back as wb','wb.vdc_number = db.vdc_number AND wb.vendor_id = v.vendor_id','left');
        $this->db->group_by('db.vdc_number');
        if($vendor_id > 0){
            $this->db->where('v.vendor_id',$vendor_id);
        }
        $query = $this->db->get();
        return $query->row_array();
    }

}
