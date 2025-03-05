<?php
class Admin_model extends CI_Model
{
    function __construct()
    {
        $this->db->query("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        $this->column_boqtrans_order = [
            null,
            'id',
            'project_id',
            'event_name',
            'event_type',
            'exceptional_no',
            'created_date',
            'status',
            'bp_code',
            'customer_name',
            'created_by_name',
            'created_by_rolename',
            'approved_by_name',
            'approved_by_rolename',
        ];
        $this->column_boqtrans_search = [
            'id',
            'project_id',
            'event_name',
            'event_type',
            'exceptional_no',
            'created_date',
            'status',
            'bp_code',
            'customer_name',
            'created_by_name',
            'created_by_rolename',
            'approved_by_name',
            'approved_by_rolename',
        ];
        $this->boqtrans_order = ['id' => 'desc'];

        $this->column_taxinvprc_order = [null, 'id', 'payment_receipt_no', 'payment_date', 'bank_acc_no_name', 'client_name', 'created_date', 'created_by_name'];
        $this->column_taxinvprc_search = ['id', 'payment_receipt_no', 'payment_date', 'bank_acc_no_name', 'client_name', 'created_date', 'created_by_name'];
        $this->taxinvprc_order = ['id' => 'desc'];

        $this->column_boqexcept_order = [null, 'id', 'boq_code'];
        $this->column_boqexcept_search = ['id', 'boq_code'];
        $this->boqexcept_order = ['id' => 'desc'];

        $this->column_boqexceptn_order = [null, 'exceptional_id', 'project_id', 'bp_code', 'exceptional_no'];
        $this->column_boqexceptn_search = ['exceptional_id', 'project_id', 'bp_code', 'exceptional_no'];
        $this->boqexceptn_order = ['exceptional_id' => 'desc'];

        $this->column_reminder_order = [null, 'id', 'notification', 'created_date'];
        $this->column_reminder_search = ['id', 'notification', 'created_date'];
        $this->reminder_order = ['id' => 'desc'];

        $this->column_noti_order = [null, 'id', 'notification', 'created_date'];
        $this->column_noti_search = ['id', 'notification', 'created_date'];
        $this->noti_order = ['id' => 'desc'];

        $this->column_approvwait_order = [null, 'id', 'event_name', 'event_type', 'exceptional_no', 'created_date'];
        $this->column_approvwait_search = ['id', 'event_name', 'event_type', 'exceptional_no', 'created_date'];
        $this->approvwait_order = ['id' => 'desc'];

        $this->column_dcc_order = [null, 'challan_id', 'project_id', 'dc_no', 'created_by', 'created_on', 'modified_by', 'modified_on', 'display', 'status', 'bp_code', 'customer_name'];
        $this->column_dcc_search = ['challan_id', 'project_id', 'dc_no', 'created_by', 'created_on', 'modified_by', 'modified_on', 'display', 'status', 'bp_code', 'customer_name'];
        $this->dcc_order = ['challan_id' => 'desc'];

        $this->column_dcvs_order = [null, 'vs_id', 'project_id', 'vs_no', 'created_by', 'created_on', 'modified_by', 'modified_on', 'display', 'status', 'bp_code', 'customer_name'];
        $this->column_dcvs_search = ['vs_id', 'project_id', 'vs_no', 'created_by', 'created_on', 'modified_by', 'modified_on', 'display', 'status', 'bp_code', 'customer_name'];
        $this->dcvs_order = ['vs_id' => 'desc'];

        $this->column_taxinvc_order = [null, 'tax_invc_id', 'project_id', 'tax_invc_no', 'created_by', 'created_on', 'modified_by', 'modified_on', 'display', 'status', 'bp_code', 'customer_name'];
        $this->column_taxinvc_search = ['tax_invc_id', 'project_id', 'tax_invc_no', 'created_by', 'created_on', 'modified_by', 'modified_on', 'display', 'status', 'bp_code', 'customer_name'];
        $this->taxinvc_order = ['tax_invc_id' => 'desc'];

        $this->column_taxinvc_item_order = [null, 'tax_invc_itemid', 'tax_invc_id', 'boq_code', 'hsn_sac_code', 'item_description', 'unit', 'qty', 'rate'];
        $this->column_taxinvc_item_search = ['tax_invc_itemid', 'tax_invc_id', 'boq_code', 'hsn_sac_code', 'item_description', 'unit', 'qty', 'rate'];
        $this->taxinvc_item_order = ['tax_invc_itemid' => 'desc'];

        $this->column_proinvc_order = [null, 'proforma_id', 'project_id', 'proforma_no', 'created_by', 'created_on', 'modified_by', 'modified_on', 'display', 'status', 'bp_code', 'customer_name'];
        $this->column_proinvc_search = ['proforma_id', 'project_id', 'proforma_no', 'created_by', 'created_on', 'modified_by', 'modified_on', 'display', 'status', 'bp_code', 'customer_name'];
        $this->proinvc_order = ['proforma_id' => 'desc'];

        $this->column_proinvc_item_order = [null, 'proforma_itemid', 'proforma_id', 'boq_code', 'hsn_sac_code', 'item_description', 'unit', 'qty', 'rate'];
        $this->column_proinvc_item_search = ['proforma_itemid', 'proforma_id', 'boq_code', 'hsn_sac_code', 'item_description', 'unit', 'qty', 'rate'];
        $this->proinvc_item_order = ['proforma_itemid' => 'desc'];

        $this->column_dciwip_order = [null, 'i_wip_id', 'project_id', 'i_wip_no', 'created_by', 'created_on', 'modified_by', 'modified_on', 'display', 'status', 'bp_code', 'customer_name'];
        $this->column_dciwip_search = ['i_wip_id', 'project_id', 'i_wip_no', 'created_by', 'created_on', 'modified_by', 'modified_on', 'display', 'status', 'bp_code', 'customer_name'];
        $this->dciwip_order = ['i_wip_id' => 'desc'];

        $this->column_dcpwip_order = [null, 'p_wip_id', 'project_id', 'p_wip_no', 'created_by', 'created_on', 'modified_by', 'modified_on', 'display', 'status', 'bp_code', 'customer_name'];
        $this->column_dcpwip_search = ['p_wip_id', 'project_id', 'p_wip_no', 'created_by', 'created_on', 'modified_by', 'modified_on', 'display', 'status', 'bp_code', 'customer_name'];
        $this->dcpwip_order = ['p_wip_id' => 'desc'];

        $this->column_dcc_item_order = [null, 'challan_itemid', 'challan_id', 'boq_code', 'hsn_sac_code', 'item_description', 'unit', 'scheduled_qty', 'design_qty', 'received_qty'];
        $this->column_dcc_item_search = ['challan_itemid', 'challan_id', 'boq_code', 'hsn_sac_code', 'item_description', 'unit', 'scheduled_qty', 'design_qty', 'received_qty'];
        $this->dcc_item_order = ['challan_itemid' => 'desc'];

        $this->column_dcvs_item_order = [null, 'vs_itemid', 'vs_id', 'boq_code', 'hsn_sac_code', 'item_description', 'unit', 'avl_qty', 'stock_qty'];
        $this->column_dcvs_item_search = ['vs_itemid', 'vs_id', 'boq_code', 'hsn_sac_code', 'item_description', 'unit', 'avl_qty', 'stock_qty'];
        $this->compliance_item = ['id', 'month', 'gstr_1a_confirmation_date', 'gstr_3b_confirmation_date', 'tds_confirmation_date', 'proof_tax_confirmation_date', 'pro_fund_confirmation_date', 'esic_confirmation_date'];
        $this->dcvs_item_order = ['vs_itemid' => 'desc'];
        $this->comp_item_order = ['id' => 'desc'];

        $this->column_dciwip_item_order = [null, 'i_wip_itemid', 'i_wip_id', 'boq_code', 'hsn_sac_code', 'item_description', 'unit', 'avl_qty', 'installed_qty'];
        $this->column_dciwip_item_search = ['i_wip_itemid', 'i_wip_id', 'boq_code', 'hsn_sac_code', 'item_description', 'unit', 'avl_qty', 'installed_qty'];
        $this->dciwip_item_order = ['i_wip_itemid' => 'desc'];

        $this->column_dcpwip_item_order = [null, 'p_wip_itemid', 'p_wip_id', 'boq_code', 'hsn_sac_code', 'item_description', 'unit', 'avl_qty', 'prov_qty'];
        $this->column_dcpwip_item_search = ['p_wip_itemid', 'p_wip_id', 'boq_code', 'hsn_sac_code', 'item_description', 'unit', 'avl_qty', 'prov_qty'];
        $this->dcpwip_item_order = ['p_wip_itemid' => 'desc'];

        $this->column_project_order = [null, 'p.project_id', 'p.customer_code', 'p.customer_name', 'p.bp_code', 'p.po_loi_no', 'p.registered_address', 'p.created_date', 'p.updated_date', 'p.status', 'p.created_by', 'tu.fullname'];
        $this->column_project_search = ['p.project_id', 'p.customer_code', 'p.customer_name', 'p.bp_code', 'p.po_loi_no', 'p.registered_address', 'p.created_date', 'p.updated_date', 'p.status', 'p.created_by', 'tu.fullname'];
        $this->project_order = ['p.project_id' => 'desc'];

        $this->column_boq_order = [null, 'boq_items_id', 'project_id', 'bp_code', 'boq_code', 'item_description', 'unit', 'scheduled_qty', 'design_qty', 'rate_basic', 'gst', 'non_schedule', 'status'];
        $this->column_boq_search = ['boq_items_id', 'project_id', 'bp_code', 'boq_code', 'item_description', 'unit', 'scheduled_qty', 'design_qty', 'rate_basic', 'gst', 'non_schedule', 'status'];
        $this->boq_order = ['boq_items_id' => 'desc'];

        $this->column_boqp_order = [null, 'boq_items_id', 'project_id', 'bp_code', 'boq_code', 'item_description', 'unit', 'scheduled_qty', 'design_qty', 'rate_basic', 'gst', 'non_schedule', 'status'];
        $this->column_boqp_search = ['boq_items_id', 'project_id', 'bp_code', 'boq_code', 'item_description', 'unit', 'scheduled_qty', 'design_qty', 'rate_basic', 'gst', 'non_schedule', 'status'];
        $this->boqp_order = ['boq_items_id' => 'asc'];

        $this->column_bom_order = [null, 'bom_items_id', 'bom_code', 'project_id', 'bp_code', 'boq_code', 'item_description', 'unit', 'scheduled_qty', 'design_qty', 'rate_basic', 'gst', 'non_schedule', 'status'];
        $this->column_bom_search = ['bom_items_id', 'project_id', 'bp_code', 'boq_code', 'item_description', 'unit', 'scheduled_qty', 'design_qty', 'rate_basic', 'gst', 'non_schedule', 'status'];
        $this->bom_order = ['bom_items_id' => 'desc'];

        $this->column_bomtrans_order = [
            null,
            'id',
            'project_id',
            'event_name',
            'event_type',
            'exceptional_no',
            'created_date',
            'status',
            'bp_code',
            'customer_name',
            'created_by_name',
            'created_by_rolename',
            'approved_by_name',
            'approved_by_rolename',
        ];
        $this->column_bomtrans_search = [
            'id',
            'project_id',
            'event_name',
            'event_type',
            'exceptional_no',
            'created_date',
            'status',
            'bp_code',
            'customer_name',
            'created_by_name',
            'created_by_rolename',
            'approved_by_name',
            'approved_by_rolename',
        ];
        $this->bomtrans_order = ['id' => 'desc'];
    }
    public function getViewBOQTransListRows($postData, $project_id, $transaction_id, $status_txt)
    {
        $this->_get_boq_view_trans_list_datatables_query($postData, $project_id, $transaction_id, $status_txt);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countViewBOQTransListFiltered($postData, $project_id, $transaction_id, $status_txt)
    {
        $this->_get_boq_view_trans_list_datatables_query($postData, $project_id, $transaction_id, $status_txt);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countViewBOQTransListAll($project_id, $transaction_id, $status_txt)
    {
        $this->db->select('*');
        $this->db->from('view_boq_items');
        $this->db->where('project_id', $project_id);
        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('status', 'N');
        } else {
            $this->db->where('status', 'Y');
        }
        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('display', 'Y');
        return $this->db->count_all_results();
    }
    private function _get_boq_view_trans_list_datatables_query($postData, $project_id, $transaction_id, $status_txt)
    {
        $this->db->select('*');
        $this->db->from('view_boq_items');
        $this->db->where('project_id', $project_id);
        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('status', 'N');
        } else {
            $this->db->where('status', 'Y');
        }
        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('display', 'Y');
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_boq_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_boq_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_boq_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->boq_order)) {
            $order = $this->boq_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getBOQTransactionItemListRows($postData, $project_id, $status_txt)
    {
        $this->_get_boqtrans_list_datatables_query($postData, $project_id, $status_txt);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countBOQTransactionItemListFiltered($postData, $project_id, $status_txt)
    {
        $this->_get_boqtrans_list_datatables_query($postData, $project_id, $status_txt);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countBOQTransactionItemListAll($project_id, $status_txt)
    {
        //  echo $status_txt;die;
        $this->db->select('*');
        if (isset($status_txt) && !empty($status_txt)) {
            $this->db->from('view_boq_transactions appr');
            $this->db->where("(SELECT IFNULL(COUNT(boq_items_id),0) as cnt FROM tbl_boq_items WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='N') > 0");
            $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_boq_exceptional WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
            $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_variable_discount WHERE project_id = '" . $project_id . "' AND variable_discount_tid = appr.variable_discount_id AND display='Y' AND status='pending') > 0");
            $this->db->or_where("(SELECT IFNULL(COUNT(challan_id),0) as cnt FROM tbl_delivery_challan WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
        } else {
            $this->db->from('view_boq_transactions appr');
            $this->db->where("(SELECT IFNULL(COUNT(boq_items_id),0) as cnt FROM tbl_boq_items WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='Y') > 0");
            $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_variable_discount WHERE project_id = '" . $project_id . "' AND variable_discount_tid = appr.variable_discount_id AND display='Y' AND status='approved') > 0");
            $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_boq_exceptional WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='approved') > 0");
            //$this->db->or_where("(SELECT IFNULL(COUNT(challan_id),0) as cnt FROM tbl_delivery_challan WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
        }
        $this->db->where('display', 'Y');
        $this->db->where('project_id', $project_id);
        return $this->db->count_all_results();
    }
    private function _get_boqtrans_list_datatables_query($postData, $project_id, $status_txt)
    {
        $this->db->select('*');
        if (isset($status_txt) && !empty($status_txt)) {
            $this->db->from('view_boq_transactions appr');
            $this->db->where("(SELECT IFNULL(COUNT(boq_items_id),0) as cnt FROM tbl_boq_items WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='N') > 0");
            $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_boq_exceptional WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
            $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_variable_discount WHERE project_id = '" . $project_id . "' AND variable_discount_tid = appr.variable_discount_id AND display='Y' AND status='pending') > 0");
            $this->db->or_where("(SELECT IFNULL(COUNT(challan_id),0) as cnt FROM tbl_delivery_challan WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
        } else {
            $this->db->from('view_boq_transactions appr');
            $this->db->where("(SELECT IFNULL(COUNT(boq_items_id),0) as cnt FROM tbl_boq_items WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='Y') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_variable_discount WHERE project_id = '".$project_id."' AND variable_discount_tid = appr.variable_discount_id AND display='Y' AND status='approved') > 0");
            $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_boq_exceptional WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='approved') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(challan_id),0) as cnt FROM tbl_delivery_challan WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
        }
        $this->db->where('display', 'Y');
        $this->db->where('project_id', $project_id);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_boqtrans_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_boqtrans_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_boqtrans_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->boqtrans_order)) {
            $order = $this->boqtrans_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getTaxInvcPRCListRows($postData, $tax_invc_id)
    {
        $this->_get_taxinvprc_list_datatables_query($postData, $tax_invc_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countTaxInvcPRCListFiltered($postData, $tax_invc_id)
    {
        $this->_get_taxinvprc_list_datatables_query($postData, $tax_invc_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countTaxInvcPRCListAll($tax_invc_id)
    {
        $this->db->select('*');
        $this->db->from('view_tax_payment_receipts');
        $this->db->where('display', 'Y');
        $this->db->where('tax_incv_id', $tax_invc_id);
        return $this->db->count_all_results();
    }
    private function _get_taxinvprc_list_datatables_query($postData, $tax_invc_id)
    {
        $this->db->select('*');
        $this->db->from('view_tax_payment_receipts');
        $this->db->where('display', 'Y');
        $this->db->where('tax_incv_id', $tax_invc_id);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_taxinvprc_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_taxinvprc_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_taxinvprc_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->taxinvprc_order)) {
            $order = $this->taxinvprc_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getBOQExceptionalItemListRows($postData, $project_id)
    {
        $this->_get_boqexceptn_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countBOQExceptionalItemListFiltered($postData, $project_id)
    {
        $this->_get_boqexceptn_list_datatables_query($postData, $project_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countBOQExceptionalItemListAll($project_id)
    {
        $this->db->select('*');
        $this->db->from('view_boq_exceptional');
        $this->db->where('display', 'Y');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
            $this->db->where('status', 'approved');
        }
        return $this->db->count_all_results();
    }
    private function _get_boqexceptn_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('view_boq_exceptional');
        $this->db->where('display', 'Y');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
            $this->db->where('status', 'approved');
        }
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_boqexceptn_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_boqexceptn_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_boqexceptn_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->boqexceptn_order)) {
            $order = $this->boqexceptn_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getSendBOQExceptItemListRows($postData, $exceptional_id)
    {
        $this->_get_sendboqexcept_list_datatables_query($postData, $exceptional_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countSendBOQExceptItemListFiltered($postData, $exceptional_id)
    {
        $this->_get_sendboqexcept_list_datatables_query($postData, $exceptional_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countSendBOQExceptItemListAll($exceptional_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_boq_exceptional');
        $this->db->where('display', 'Y');
        $this->db->where('exceptional_id', $exceptional_id);
        return $this->db->count_all_results();
    }
    private function _get_sendboqexcept_list_datatables_query($postData, $exceptional_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_boq_exceptional');
        $this->db->where('display', 'Y');
        $this->db->where('exceptional_id', $exceptional_id);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_boqexcept_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_boqexcept_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_boqexcept_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->boqexcept_order)) {
            $order = $this->boqexcept_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    //
    public function getBOQExceptItemListRows($postData, $project_id)
    {
        $this->_get_boqexcept_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countBOQExceptItemListFiltered($postData, $project_id)
    {
        $this->_get_boqexcept_list_datatables_query($postData, $project_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countBOQExceptItemListAll($project_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_boq_exceptional');
        $this->db->where('display', 'Y');
        $this->db->where('exceptional_id', 0);
        $this->db->where('status', 'pending');
        $this->db->where('project_id', $project_id);
        return $this->db->count_all_results();
    }
    private function _get_boqexcept_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_boq_exceptional');
        $this->db->where('display', 'Y');
        $this->db->where('exceptional_id', 0);
        $this->db->where('status', 'pending');
        $this->db->where('project_id', $project_id);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_boqexcept_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_boqexcept_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_boqexcept_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->boqexcept_order)) {
            $order = $this->boqexcept_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getReminderListRows($postData, $project_id)
    {
        $this->_get_reminder_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countReminderListFiltered($postData, $project_id)
    {
        $this->_get_reminder_list_datatables_query($postData, $project_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countReminderListAll($project_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_admin_remind');
        return $this->db->count_all_results();
    }
    private function _get_reminder_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_admin_remind');
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_reminder_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_reminder_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_reminder_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->reminder_order)) {
            $order = $this->reminder_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getNotiListRows($postData, $project_id)
    {
        $this->_get_noti_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countNotiListFiltered($postData, $project_id)
    {
        $this->_get_noti_list_datatables_query($postData, $project_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countNotiListAll($project_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_admin_notif');
        return $this->db->count_all_results();
    }
    private function _get_noti_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_admin_notif');
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_noti_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_noti_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_noti_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->noti_order)) {
            $order = $this->noti_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getApproWaitListRows($postData, $project_id)
    {
        $this->_get_approvwait_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countApproWaitListFiltered($postData, $project_id)
    {
        $this->_get_approvwait_list_datatables_query($postData, $project_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countApproWaitListAll($project_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_approval_waiting');
        $this->db->where('action_id', $project_id);
        return $this->db->count_all_results();
    }
    private function _get_approvwait_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_approval_waiting');
        $this->db->where('action_id', $project_id);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_approvwait_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_approvwait_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_approvwait_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->approvwait_order)) {
            $order = $this->approvwait_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getProInvcItemListRows($postData, $proforma_id)
    {
        $this->_get_provinvc_item_list_datatables_query($postData, $proforma_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countProInvcItemListFiltered($postData, $proforma_id)
    {
        $this->_get_provinvc_item_list_datatables_query($postData, $proforma_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countProInvcItemListAll($i_wip_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_proforma_invc_items');
        $this->db->where('proforma_id', $proforma_id);
        return $this->db->count_all_results();
    }
    private function _get_provinvc_item_list_datatables_query($postData, $proforma_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_proforma_invc_items');
        $this->db->where('proforma_id', $proforma_id);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_proinvc_item_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_proinvc_item_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_proinvc_item_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->proinvc_item_order)) {
            $order = $this->proinvc_item_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getTaxInvcItemListRows($postData, $tax_invc_id)
    {
        $this->_get_taxvinvc_item_list_datatables_query($postData, $tax_invc_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countTaxInvcItemListFiltered($postData, $tax_invc_id)
    {
        $this->_get_taxvinvc_item_list_datatables_query($postData, $tax_invc_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countTaxInvcItemListAll($tax_invc_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_tax_invc_items');
        $this->db->where('tax_invc_id', $tax_invc_id);
        return $this->db->count_all_results();
    }
    private function _get_taxvinvc_item_list_datatables_query($postData, $tax_invc_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_tax_invc_items');
        $this->db->where('tax_invc_id', $tax_invc_id);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_taxinvc_item_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_taxinvc_item_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_taxinvc_item_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->taxinvc_item_order)) {
            $order = $this->taxinvc_item_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getVariableDiscItemListRows($postData, $project_id, $variable_discount_tid)
    {
        $this->_get_variable_disc_list_datatables_query($postData, $project_id, $variable_discount_tid);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countVariableDiscItemListFiltered($postData, $project_id, $variable_discount_tid)
    {
        $this->_get_variable_disc_list_datatables_query($postData, $project_id, $variable_discount_tid);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countVariableDiscItemListAll($project_id, $variable_discount_tid)
    {
        $this->db->select('*');
        $this->db->from('tbl_variable_discount');
        // $this->db->where('project_id',$project_id);
        $this->db->where('variable_discount_tid', $variable_discount_tid);
        return $this->db->count_all_results();
    }
    private function _get_variable_disc_list_datatables_query($postData, $project_id, $variable_discount_tid)
    {
        $this->db->select('*');
        $this->db->from('tbl_variable_discount');
        // $this->db->where('project_id',$project_id);
        $this->db->where('variable_discount_tid', $variable_discount_tid);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_taxinvc_item_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_taxinvc_item_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        // if(isset($postData['order'])){
        //     $this->db->order_by($this->column_taxinvc_item_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        // }else if(isset($this->taxinvc_item_order)){
        //     $order = $this->taxinvc_item_order;
        //     $this->db->order_by(key($order), $order[key($order)]);
        // }
    }

    public function getDCIWIPItemListRows($postData, $i_wip_id)
    {
        $this->_get_dciwip_item_list_datatables_query($postData, $i_wip_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countDCIWIPItemListFiltered($postData, $i_wip_id)
    {
        $this->_get_dciwip_item_list_datatables_query($postData, $i_wip_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countDCIWIPItemListAll($i_wip_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_install_wip_items');
        $this->db->where('i_wip_id', $i_wip_id);
        return $this->db->count_all_results();
    }
    private function _get_dciwip_item_list_datatables_query($postData, $i_wip_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_install_wip_items');
        $this->db->where('i_wip_id', $i_wip_id);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_dciwip_item_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_dciwip_item_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_dciwip_item_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->dciwip_item_order)) {
            $order = $this->dciwip_item_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getDCPWIPItemListRows($postData, $p_wip_id)
    {
        $this->_get_dcpwip_item_list_datatables_query($postData, $p_wip_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countDCPWIPItemListFiltered($postData, $p_wip_id)
    {
        $this->_get_dcpwip_item_list_datatables_query($postData, $p_wip_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countDCPWIPItemListAll($p_wip_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_prov_wip_items');
        $this->db->where('p_wip_id', $p_wip_id);
        return $this->db->count_all_results();
    }
    private function _get_dcpwip_item_list_datatables_query($postData, $p_wip_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_prov_wip_items');
        $this->db->where('p_wip_id', $p_wip_id);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_dcpwip_item_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_dcpwip_item_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_dcpwip_item_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->dcpwip_item_order)) {
            $order = $this->dcpwip_item_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getDCVSItemListRows($postData, $vs_id)
    {
        $this->_get_dcvs_item_list_datatables_query($postData, $vs_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countDCVSItemListFiltered($postData, $vs_id)
    {
        $this->_get_dcvs_item_list_datatables_query($postData, $vs_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function compliance_dataListFiltered($postData)
    {
        $this->_get_compliance_item_list_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countDCVSItemListAll($vs_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_virtual_stock_items');
        $this->db->where('vs_id', $vs_id);
        return $this->db->count_all_results();
    }
    public function countcompliance_data()
    {
        $this->db->select('*');
        $this->db->from('tbl_compliance');
        $this->db->where('display', 'Y');
        return $this->db->count_all_results();
    }

    public function compliance_data($postData)
    {
        $this->compliance_list_datatables_query($postData);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    private function compliance_list_datatables_query($postData)
    {
        $this->db->select('*');
        $this->db->from('tbl_compliance');
        $this->db->where('display', 'Y');
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->compliance_item as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->compliance_item) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->comp_item_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->comp_item_order)) {
            $order = $this->comp_item_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    private function _get_dcvs_item_list_datatables_query($postData, $vs_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_virtual_stock_items');
        $this->db->where('vs_id', $vs_id);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_dcvs_item_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_dcvs_item_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_dcvs_item_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->dcvs_item_order)) {
            $order = $this->dcvs_item_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    private function _get_compliance_item_list_datatables_query($postData)
    {
        $this->db->select('*');
        $this->db->from('tbl_compliance');
        $this->db->where('display', 'Y');
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->compliance_item as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->compliance_item) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->comp_item_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->comp_item_order)) {
            $order = $this->comp_item_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getDCCItemListRows($postData, $challan_id)
    {
        $this->_get_dcc_item_list_datatables_query($postData, $challan_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countDCCItemListFiltered($postData, $challan_id)
    {
        $this->_get_dcc_item_list_datatables_query($postData, $challan_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countDCCItemListAll($challan_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_deliv_challan_items');
        $this->db->where('challan_id', $challan_id);
        return $this->db->count_all_results();
    }
    private function _get_dcc_item_list_datatables_query($postData, $challan_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_deliv_challan_items');
        $this->db->where('challan_id', $challan_id);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_dcc_item_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_dcc_item_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_dcc_item_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->dcc_item_order)) {
            $order = $this->dcc_item_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getTAXINVCListRows($postData, $project_id)
    {
        $this->_get_taxinvc_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countTAXINVCListFiltered($postData, $project_id)
    {
        $this->_get_taxinvc_list_datatables_query($postData, $project_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countTAXINVCListAll($project_id)
    {
        $this->db->select('*');
        $this->db->from('view_tax_invc');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
        }
        return $this->db->count_all_results();
    }
    private function _get_taxinvc_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('view_tax_invc');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
        }
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_taxinvc_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_taxinvc_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_taxinvc_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->taxinvc_order)) {
            $order = $this->taxinvc_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getPROINVCListRows($postData, $project_id)
    {
        $this->_get_proinvc_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countPROINVCListFiltered($postData, $project_id)
    {
        $this->_get_proinvc_list_datatables_query($postData, $project_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countPROINVCListAll($project_id)
    {
        $this->db->select('*');
        $this->db->from('view_proforma_invc');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
        }
        return $this->db->count_all_results();
    }
    private function _get_proinvc_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('view_proforma_invc');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
        }

        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_proinvc_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_proinvc_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_proinvc_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->proinvc_order)) {
            $order = $this->proinvc_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getDCIWIPListRows($postData, $project_id)
    {
        $this->_get_dciwip_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countDCIWIPListFiltered($postData, $project_id)
    {
        $this->_get_dciwip_list_datatables_query($postData, $project_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countDCIWIPListAll($project_id)
    {
        $this->db->select('*');
        $this->db->from('view_dciwip');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
        }
        return $this->db->count_all_results();
    }
    private function _get_dciwip_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('view_dciwip');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
        }
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_dciwip_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_dciwip_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_dciwip_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->dciwip_order)) {
            $order = $this->dciwip_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getDCPWIPListRows($postData, $project_id)
    {
        $this->_get_dcpwip_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countDCPWIPListFiltered($postData, $project_id)
    {
        $this->_get_dcpwip_list_datatables_query($postData, $project_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countDCPWIPListAll($project_id)
    {
        $this->db->select('*');
        $this->db->from('view_dcpwip');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
        }
        return $this->db->count_all_results();
    }
    private function _get_dcpwip_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('view_dcpwip');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
        }
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_dcpwip_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_dcpwip_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_dcpwip_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->dcpwip_order)) {
            $order = $this->dcpwip_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getDCVSListRows($postData, $project_id)
    {
        $this->_get_dcvs_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countDCVSListFiltered($postData, $project_id)
    {
        $this->_get_dcvs_list_datatables_query($postData, $project_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countDCVSListAll($project_id)
    {
        $this->db->select('*');
        $this->db->from('view_dcvs');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
        }
        return $this->db->count_all_results();
    }
    private function _get_dcvs_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('view_dcvs');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
        }
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_dcvs_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_dcvs_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_dcvs_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->dcvs_order)) {
            $order = $this->dcvs_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getDCCListRows($postData, $project_id)
    {
        $this->_get_dcc_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countDCCListFiltered($postData, $project_id)
    {
        $this->_get_dcc_list_datatables_query($postData, $project_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countDCCListAll($project_id)
    {
        $this->db->select('*');
        $this->db->from('view_dcc');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
        }
        return $this->db->count_all_results();
    }
    private function _get_dcc_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('view_dcc');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
        }
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_dcc_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_dcc_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_dcc_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->dcc_order)) {
            $order = $this->dcc_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getPBOQItemListRows($postData, $project_id)
    {
        $this->_get_boq_p_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countPBOQItemListFiltered($postData, $project_id)
    {
        $this->_get_boq_p_list_datatables_query($postData, $project_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countPBOQItemListAll($project_id)
    {
        $this->db->select('*');
        $this->db->from('view_latest_boq_items');
        $this->db->where('project_id', $project_id);
        return $this->db->count_all_results();
    }
    private function _get_boq_p_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('view_latest_boq_items');
        $this->db->where('project_id', $project_id);
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_boqp_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_boqp_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_boqp_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->boqp_order)) {
            $order = $this->boqp_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getBOQCListRows($postData, $project_id)
    {
        $this->_get_boq_c_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countBOQCListFiltered($postData, $project_id)
    {
        $this->_get_boq_c_list_datatables_query($postData, $project_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countBOQCListAll($project_id)
    {
        $this->db->select('*');
        $this->db->from('view_latest_boq_items');
        $this->db->where('non_schedule', 'Y');
        $this->db->where('project_id', $project_id);
        $this->db->where('display', 'Y');
        $this->db->where('status', 'Y');
        return $this->db->count_all_results();
    }
    private function _get_boq_c_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('view_latest_boq_items');
        $this->db->where('non_schedule', 'Y');
        $this->db->where('project_id', $project_id);
        $this->db->where('display', 'Y');
        $this->db->where('status', 'Y');
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_boq_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_boq_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_boq_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->boq_order)) {
            $order = $this->boq_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getBOQExceptnlViewListRows($postData, $project_id, $transaction_id, $status_txt)
    {
        $this->_get_boq_exceptnal_view_list_datatables_query($postData, $project_id, $transaction_id, $status_txt);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countBOQExceptnlViewListAll($project_id, $transaction_id, $status_txt)
    {
        $this->db->select('*');
        $this->db->from('view_boq_expectional_item');
        $this->db->where('project_id', $project_id);
        $this->db->where('transaction_id', $transaction_id);
        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('status', 'pending');
        } else {
            $this->db->where('status', 'approved');
        }
        return $this->db->count_all_results();
    }
    public function countBOQExceptnlViewListFiltered($postData, $project_id, $transaction_id, $status_txt)
    {
        $this->_get_boq_exceptnal_view_list_datatables_query($postData, $project_id, $transaction_id, $status_txt);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_boq_exceptnal_view_list_datatables_query($postData, $project_id, $transaction_id, $status_txt)
    {
        $this->db->select('*');
        $this->db->from('view_boq_expectional_item');
        $this->db->where('project_id', $project_id);
        $this->db->where('transaction_id', $transaction_id);
        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('status', 'pending');
        } else {
            $this->db->where('status', 'approved');
        }
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_boq_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_boq_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_boq_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->boq_order)) {
            $order = $this->boq_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getViewBOQListRows($postData, $project_id, $transaction_id)
    {
        $this->_get_boq_view_list_datatables_query($postData, $project_id, $transaction_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countViewBOQListFiltered($postData, $project_id, $transaction_id)
    {
        $this->_get_boq_view_list_datatables_query($postData, $project_id, $transaction_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countViewBOQListAll($project_id, $transaction_id)
    {
        $this->db->select('*');
        $this->db->from('view_latest_boq_items');
        $this->db->where('project_id', $project_id);
        if ($transaction_id > 0) {
            $this->db->where('transaction_id', $transaction_id);
        }
        $this->db->where('status', 'Y');
        return $this->db->count_all_results();
    }
    private function _get_boq_view_list_datatables_query($postData, $project_id, $transaction_id)
    {
        $this->db->select('*');
        $this->db->from('view_latest_boq_items');
        $this->db->where('project_id', $project_id);
        if ($transaction_id > 0) {
            $this->db->where('transaction_id', $transaction_id);
        }
        $this->db->where('status', 'Y');
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_boq_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_boq_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_boq_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->boq_order)) {
            $order = $this->boq_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getBOQTransListRows($postData, $boq_transaction_cnt, $project_id)
    {
        $this->_get_boq_trans_list_datatables_query($postData, $boq_transaction_cnt, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countBOQTransListFiltered($postData, $boq_transaction_cnt, $project_id)
    {
        $this->_get_boq_trans_list_datatables_query($postData, $boq_transaction_cnt, $project_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countBOQTransListAll($boq_transaction_cnt, $project_id)
    {
        $this->db->select('*');
        $this->db->from('view_boq_items');
        $this->db->where('project_id', $project_id);
        $this->db->where('steps', $boq_transaction_cnt);
        return $this->db->count_all_results();
    }
    private function _get_boq_trans_list_datatables_query($postData, $boq_transaction_cnt, $project_id)
    {
        $this->db->select('*');
        $this->db->from('view_boq_items');
        $this->db->where('project_id', $project_id);
        $this->db->where('steps', $boq_transaction_cnt);
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_boq_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_boq_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_boq_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->boq_order)) {
            $order = $this->boq_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getBOQOperListRows($postData, $project_id, $type)
    {
        $this->_get_boq_oper_list_datatables_query($postData, $project_id, $type);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countBOQOperListFiltered($postData, $project_id, $type)
    {
        $this->_get_boq_oper_list_datatables_query($postData, $project_id, $type);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countBOQOperListAll($project_id, $type)
    {
        $this->db->select('*');
        $this->db->from('view_latest_boq_items');
        $this->db->where('project_id', $project_id);
        if ($type == 'operable_a') {
            $this->db->where('scheduled_qty = design_qty');
            $this->db->where('non_schedule', 'N');
        } elseif ($type == 'B_pos') {
            $this->db->where('design_qty > scheduled_qty');
            $this->db->where('non_schedule', 'N');
        } elseif ($type == 'B_nav') {
            $this->db->where('design_qty < scheduled_qty');
            $this->db->where('non_schedule', 'N');
        } elseif ($type == 'operable_c') {
            $this->db->where('non_schedule', 'Y');
        }
        $this->db->where('display', 'Y');
        $this->db->where('status', 'Y');
        return $this->db->count_all_results();
    }
    private function _get_boq_oper_list_datatables_query($postData, $project_id, $type)
    {
        $this->db->select('*');
        $this->db->from('view_latest_boq_items');
        $this->db->where('project_id', $project_id);
        if ($type == 'operable_a') {
            $this->db->where('scheduled_qty = design_qty');
            $this->db->where('non_schedule', 'N');
        } elseif ($type == 'B_pos') {
            $this->db->where('design_qty > scheduled_qty');
            $this->db->where('non_schedule', 'N');
        } elseif ($type == 'B_nav') {
            $this->db->where('design_qty < scheduled_qty');
            $this->db->where('non_schedule', 'N');
        } elseif ($type == 'operable_c') {
            $this->db->where('non_schedule', 'Y');
        } elseif ($type == 'operable_a_release') {
            // $this->db->where('scheduled_qty = design_qty');
            $this->db->where('non_schedule', 'N');
        }
        $this->db->where('display', 'Y');
        $this->db->where('status', 'Y');
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_boq_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_boq_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_boq_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->boq_order)) {
            $order = $this->boq_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getBOQListRows($postData, $project_id)
    {
        $this->_get_boq_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countBOQListFiltered($postData, $projectId)
    {
        $this->_get_boq_list_datatables_query($postData, $projectId);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countBOQListAll()
    {
        $this->db->select('*');
        $this->db->from('view_latest_boq_items');
        $this->db->where('display', 'Y');
        return $this->db->count_all_results();
    }
    private function _get_boq_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('view_latest_boq_items');
        if ($project_id != null) {
            $this->db->where('project_id', $project_id);
        }
        $this->db->where('display', 'Y');
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_boq_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_boq_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_boq_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->boq_order)) {
            $order = $this->boq_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getProjectListRows($postData)
    {
        $this->_get_project_list_datatables_query($postData);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countProjectListFiltered($postData)
    {
        $this->_get_project_list_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countProjectListAll()
    {
        $this->db->select('p.project_id,p.customer_code,p.customer_name,p.bp_code,
    p.po_loi_no,p.registered_address,p.created_date,p.updated_date,p.status,p.created_by,tu.fullname,r.role_name');
        $this->db->from('tbl_projects p');
        $this->db->join('tbl_user tu', 'tu.user_id = p.created_by');
        $this->db->join('tbl_role r', 'r.role_id = tu.role_id');
        $this->db->where('p.display', 'Y');
        return $this->db->count_all_results();
    }
    private function _get_project_list_datatables_query($postData)
    {
        $this->db->select('p.project_id,p.customer_code,p.customer_name,p.bp_code,
    p.po_loi_no,p.registered_address,p.created_date,p.updated_date,p.status,p.created_by,tu.fullname,r.role_name');
        $this->db->from('tbl_projects p');
        $this->db->join('tbl_user tu', 'tu.user_id = p.created_by');
        $this->db->join('tbl_role r', 'r.role_id = tu.role_id');
        $this->db->where('p.display', 'Y');
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_project_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_project_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_project_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->project_order)) {
            $order = $this->project_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        $this->db->close();
    }
    public function SaveMultiData($tablename, $data)
    {
        $query = $this->db->insert_batch($tablename, $data);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    public function updateBOQInstallStock($data, $project_id)
    {
        $this->db->where('project_id', $project_id);
        $query = $this->db->update_batch('tbl_boq_stock', $data, 'boq_code');
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    public function bulk_insert_boq_items_data($data, $user_id, $transaction_id)
    {
        $data1 = $update_stock_arr = $save_stock_arr = [];
        $this->db->trans_start();
        for ($i = 0; $i < count($data); $i++) {
            $boq_code = $data[$i]['boq_code'];
            $project_id = $data[$i]['project_id'];
            if (!empty($boq_code) && !empty($project_id)) {
                //check BOQ Item exceptional pending
                $checkboqexceptn = $this->db->query("SELECT exceptional_id FROM `tbl_boq_exceptional` WHERE project_id='" . $project_id . "' AND boq_code='" . $boq_code . "' AND display='Y' AND status='pending' ORDER BY id DESC LIMIT 0,1");
                if ($checkboqexceptn->num_rows() > 0) {
                } else {
                    $check = $this->db->query(
                        "SELECT * FROM `tbl_boq_items` WHERE project_id='" .
                            $project_id .
                            "' AND boq_code='" .
                            $boq_code .
                            "'
          AND display='Y' ORDER BY boq_items_id DESC LIMIT 0,1"
                    );
                    if ($check->num_rows() > 0) {
                        $existing_data = $check->row();
                        //if(isset($existing_data->design_qty) && !empty($existing_data->design_qty) && $data[$i]['design_qty'] >= $existing_data->design_qty){
                        if (isset($existing_data->status) && !empty($existing_data->status) && $existing_data->status == 'Y') {
                            $o_design_qty = 0;
                            if (isset($existing_data->o_design_qty) && !empty($existing_data->o_design_qty) && $existing_data->o_design_qty > 0) {
                                $o_design_qty = $existing_data->o_design_qty;
                            }
                            if ($o_design_qty == 0) {
                                $o_design_qty = $data[$i]['design_qty'];
                            }
                            $data[$i]['o_design_qty'] = $o_design_qty;
                            $data[$i]['transaction_id'] = $transaction_id;
                            $this->db->insert('tbl_boq_items', $data[$i]);
                        }
                        //}
                    } else {
                        $data[$i]['o_design_qty'] = $data[$i]['design_qty'];
                        $data[$i]['transaction_id'] = $transaction_id;
                        $this->db->insert('tbl_boq_items', $data[$i]);
                        /*
            $EA_qty = 0;
            if(isset($data[$i]['design_qty']) && !empty($data[$i]['design_qty']) && $data[$i]['design_qty'] > 0
            && isset($data[$i]['scheduled_qty']) && !empty($data[$i]['scheduled_qty']) && $data[$i]['scheduled_qty'] > 0
            && $data[$i]['scheduled_qty'] < $data[$i]['design_qty']){
            $EA_qty = $data[$i]['design_qty'] - $data[$i]['scheduled_qty'];
          }
          if($EA_qty > 0 && $data[$i]['status'] == 'Y'){
          if(isset($data[$i]['project_id']) && !empty($data[$i]['project_id'])) { $project_id = $data[$i]['project_id']; }else { $project_id = 0; }
          if(isset($data[$i]['boq_code']) && !empty($data[$i]['boq_code'])) { $boq_code = $data[$i]['boq_code']; }else { $boq_code = ''; }
          if(isset($data[$i]['hsn_sac_code']) && !empty($data[$i]['hsn_sac_code'])) { $hsn_sac_code = $data[$i]['hsn_sac_code']; }else { $hsn_sac_code = ''; }
          if(isset($data[$i]['item_description']) && !empty($data[$i]['item_description'])) { $item_description = $data[$i]['item_description']; }else { $item_description = ''; }
          if(isset($data[$i]['unit']) && !empty($data[$i]['unit'])) { $unit = $data[$i]['unit']; }else { $unit = ''; }
          if(isset($data[$i]['rate_basic']) && !empty($data[$i]['rate_basic'])) { $rate_basic = $data[$i]['rate_basic']; }else { $rate_basic = 0; }
          if(isset($data[$i]['gst']) && !empty($data[$i]['gst'])) { $gst = $data[$i]['gst']; }else { $gst = 0; }

          $data1[$i]['project_id'] = $project_id;
          $data1[$i]['boq_code'] = $boq_code;
          $data1[$i]['hsn_sac_code'] = $hsn_sac_code;
          $data1[$i]['item_description'] = $item_description;
          $data1[$i]['unit'] = $unit;
          $data1[$i]['rate_basic'] = $rate_basic;
          $data1[$i]['gst'] = $gst;
          $data1[$i]['EA_qty'] = $EA_qty;
          $data1[$i]['created_by'] = $user_id;
          $data1[$i]['created_at'] = date('Y-m-d H:i:s');
          $data1[$i]['updated_by'] = $user_id;
          $data1[$i]['updated_at'] = date('Y-m-d H:i:s');
          $this->db->insert('tbl_boq_exceptional',$data1[$i]);
        }
        */
                        /*if($data[$i]['status'] == 'Y'){
        $check_stock_details = $this->admin_model->check_stock_details($project_id,$boq_code);
        if(isset($check_stock_details) && !empty($check_stock_details)){
        $avl_stock = 0;
        $ea_pending = 0;
        $ea_pending_val = 0;
        $avl_stock_val = 0;
        $ea_total_stock = 0;
        $ea_total_stock_val = 0;
        $dc_total_stock_val = 0;
        $dc_total_stock = 0;
        if(isset($check_stock_details->ea_pending) && !empty($check_stock_details->ea_pending)
        && $check_stock_details->ea_pending > 0){
        $ea_pending = $check_stock_details->ea_pending;
      }
      $ea_pending_val = $ea_pending + $EA_qty;

      if(isset($check_stock_details->ea_total_stock) && !empty($check_stock_details->ea_total_stock)
      && $check_stock_details->ea_total_stock > 0){
      $ea_total_stock = $check_stock_details->ea_total_stock;
    }
    $ea_total_stock_val = $ea_total_stock + $EA_qty;

    if(isset($check_stock_details->avl_stock) && !empty($check_stock_details->avl_stock)
    && $check_stock_details->avl_stock > 0){
    $avl_stock = $check_stock_details->avl_stock;
  }
  if(isset($check_stock_details->dc_total_stock) && !empty($check_stock_details->dc_total_stock)
  && $check_stock_details->dc_total_stock > 0){
  $dc_total_stock = $check_stock_details->dc_total_stock;
}
if($EA_qty > 0){
if($avl_stock >= $EA_qty){
$avl_stock_val = $avl_stock - $EA_qty;
$dc_total_stock_val = $dc_total_stock - $EA_qty;
}else{
$dc_total_stock_val = $dc_total_stock;
$avl_stock_val = $avl_stock;
}
}else{
$dc_total_stock_val = $data[$i]['design_qty'];
$avl_stock_val = $data[$i]['design_qty'];
}
$update_stock_arr[] = array('boq_code'=>$boq_code,'total_stock'=>$data[$i]['design_qty'],'ea_total_stock'=>$ea_total_stock_val,
'ea_pending'=>$ea_pending_val,'avl_stock'=>$avl_stock_val,'dc_total_stock'=>$dc_total_stock_val,
'dc_stock'=>$avl_stock_val,'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));
}else{
$avl_stock_val = 0;
$dc_total_stock_val = 0;
if($data[$i]['design_qty'] >= $EA_qty && $EA_qty > 0){
$avl_stock_val = $data[$i]['design_qty'] - $EA_qty;
$dc_total_stock_val = $data[$i]['design_qty'] - $EA_qty;
}else{
$dc_total_stock_val = $data[$i]['design_qty'];
$avl_stock_val = $data[$i]['design_qty'];
}
$save_stock_arr[] = array('project_id'=>$project_id,'boq_code'=>$boq_code,'total_stock'=>$data[$i]['design_qty'],
'ea_total_stock'=>$EA_qty,'ea_pending'=>$EA_qty,'avl_stock'=>$avl_stock_val,'dc_total_stock'=>$dc_total_stock_val,
'dc_stock'=>$avl_stock_val,'updated_by'=>$user_id,'updated_date'=>date('Y-m-d H:i:s'));
}
}*/
                    }
                }
            }
        }
        /*if(isset($save_stock_arr) && !empty($save_stock_arr)){
$this->SaveMultiData('tbl_boq_stock',$save_stock_arr);
}
if(isset($update_stock_arr) && !empty($update_stock_arr)){
$this->updateBOQInstallStock($update_stock_arr,$project_id);
}*/
        $query = $this->db->trans_complete();
        if ($query) {
            return true;
        } else {
            return false;
        }
        $this->db->close();
    }
    public function getTotalBoqTransactionCnt($project_id)
    {
        $query = $this->db->query("SELECT MAX(steps) as `steps` FROM `tbl_boq_items` WHERE `project_id` = '" . $project_id . "'");
        if ($query->num_rows() > 0) {
            return $query->row()->steps;
        } else {
            return 'no';
        }
        $this->db->close();
    }

    public function getTotalBOMTransactionCnt($project_id)
    {
        $query = $this->db->query("SELECT MAX(steps) as `steps` FROM `tbl_bom_items` WHERE `project_id` = '" . $project_id . "'");
        if ($query->num_rows() > 0) {
            return $query->row()->steps;
        } else {
            return 'no';
        }
        $this->db->close();
    }
    public function get_bp_code($project_id)
    {
        $query = $this->db->query("SELECT `bp_code` FROM `tbl_projects` WHERE project_id='" . $project_id . "'");
        if ($query->num_rows() > 0) {
            return $query->row()->bp_code;
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_invoice_no($tax_invc_id)
    {
        $query = $this->db->query("SELECT * FROM `view_tax_invc` WHERE tax_invc_id='" . $tax_invc_id . "'");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_proforma_invoice_details($proforma_id)
    {
        $query = $this->db->query("SELECT * FROM `view_proforma_invc` WHERE proforma_id='" . $proforma_id . "'");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function check_exist_wip_no($type, $id, $no)
    {
        if ($type = 'installed') {
            $query = $this->db->query("SELECT * FROM `tbl_installed_wip` WHERE i_wip_id!='" . $id . "' AND i_wip_no='" . $no . "'");
            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return 0;
            }
        } elseif ($type = 'provisional') {
            $query = $this->db->query("SELECT * FROM `tbl_provisional_wip` WHERE p_wip_id!='" . $id . "' AND p_wip_no='" . $no . "'");
            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return 0;
            }
        } elseif ($type = 'proforma') {
            $query = $this->db->query("SELECT * FROM `tbl_proforma_invc` WHERE proforma_id!='" . $id . "' AND proforma_no='" . $no . "'");
            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return 0;
            }
        } elseif ($type = 'tax_invoice') {
            $query = $this->db->query("SELECT * FROM `tbl_tax_invc` WHERE tax_invc_id!='" . $id . "' AND tax_invc_no='" . $no . "'");
            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return 0;
            }
        } elseif ($type = 'project') {
            $query = $this->db->query("SELECT * FROM `tbl_projects` WHERE project_id!='" . $id . "' AND bp_code='" . $no . "'");
            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_project_detail($id)
    {
        $query = $this->db->query("SELECT `project_id` FROM `tbl_tax_invc` WHERE tax_invc_id='" . $id . "'");
        if ($query->num_rows() > 0) {
            $ids = $query->row()->project_id;
            $projectName = $this->db->query("SELECT `customer_name` FROM `tbl_projects` WHERE project_id='" . $ids . "'");
            if ($projectName->num_rows() > 0) {
                return $projectName->row()->customer_name;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function get_design_qty($project_id, $boq_code)
    {
        $query = $this->db->query("SELECT SUM(IFNULL(`design_qty`,0)) as total_design_qty FROM `tbl_boq_items` WHERE project_id='" . $project_id . "' AND boq_code='" . $boq_code . "'");
        if ($query->num_rows() > 0) {
            return $query->row()->total_design_qty;
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function TaxInvoiceAmount($tax_invc_id)
    {
        $query = $this->db->query("SELECT SUM(IFNULL(`qty`,0) * IFNULL(`rate`,0)) as total_amt FROM `tbl_tax_invc_items` WHERE tax_invc_id='" . $tax_invc_id . "'");
        if ($query->num_rows() > 0) {
            return $query->row()->total_amt;
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_approved_boq_item_details($project_id, $boq_code)
    {
        $query = $this->db->query(
            "SELECT * FROM `tbl_boq_items` WHERE project_id='" .
                $project_id .
                "' AND boq_code='" .
                $boq_code .
                "'
  AND status='Y' AND display='Y' ORDER BY boq_items_id DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_boq_item_details($project_id, $boq_code)
    {
        $query = $this->db->query(
            "SELECT * FROM `tbl_boq_items` WHERE project_id='" .
                $project_id .
                "'
  AND boq_code='" .
                $boq_code .
                "' AND display='Y' ORDER BY boq_items_id DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function getBOQLastItemData($boq_items_id)
    {
        $query = $this->db->query(
            "SELECT * FROM `tbl_boq_items` WHERE boq_items_id < '" .
                $boq_items_id .
                "'
  AND display='Y' AND status='Y' ORDER BY boq_items_id DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_boq_exceptional_item($project_id, $boq_code)
    {
        $query = $this->db->query(
            "SELECT * FROM `tbl_boq_exceptional` WHERE project_id='" .
                $project_id .
                "' AND boq_code='" .
                $boq_code .
                "' AND display='Y'
  AND exceptional_id=0 ORDER BY id DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function getBOQPendingExceptional($project_id, $boq_code)
    {
        $query = $this->db->query(
            "SELECT * FROM `tbl_boq_exceptional` WHERE project_id='" .
                $project_id .
                "' AND boq_code='" .
                $boq_code .
                "' AND display='Y'
  AND status='pending' ORDER BY id DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_boq_exceptional_item_pending($project_id, $boq_code)
    {
        $query = $this->db->query(
            "SELECT * FROM `tbl_boq_exceptional` WHERE project_id='" .
                $project_id .
                "' AND boq_code='" .
                $boq_code .
                "'
  AND display='Y' AND status='pending' AND exceptional_id > 0 ORDER BY id DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function getBOQExceptionalItemDetails($boq_items_id)
    {
        $query = $this->db->query(
            "SELECT * FROM `tbl_boq_exceptional` WHERE boq_items_id='" .
                $boq_items_id .
                "'
  AND display='Y' AND exceptional_id > 0 ORDER BY id DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function check_boq_dc_approved($boq_items_id)
    {
        $query = $this->db->query(
            "SELECT * FROM `tbl_deliv_challan_items` WHERE boq_items_id='" .
                $boq_items_id .
                "'
  AND display='Y' AND status='approved' ORDER BY challan_itemid DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function checkBOQUploadTransaction($project_id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(id,0) as cnt FROM `tbl_boq_transactions` WHERE project_id='" .
                $project_id .
                "'
  AND event_type='boq_upload' AND is_first_upload = 1"
        );
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function checkBOQUploadTransactionCount($project_id)
    {
        $query = $this->db->query(
            "SELECT count(IFNULL(id,0)) as cnt FROM `tbl_boq_transactions` WHERE project_id='" .
                $project_id .
                "'
  AND event_type='boq_upload'"
        );
        $query_row = $query->row();
        if ($query_row->cnt > 0) {
            return $query_row->cnt;
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function checkBOMUploadTransactionCount($project_id)
    {
        $query = $this->db->query(
            "SELECT count(IFNULL(id,0)) as cnt FROM `tbl_bom_transactions` WHERE project_id='" .
                $project_id .
                "'
  AND event_type='bom_upload'"
        );
        $query_row = $query->row();
        if ($query_row->cnt > 0) {
            return $query_row->cnt;
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function getLastExceptionalId()
    {
        $query = $this->db->query("SELECT IFNULL(exceptional_id,0) as exceptional_id FROM `tbl_boq_exceptional` ORDER BY exceptional_id DESC LIMIT 0,1");
        if ($query->num_rows() > 0) {
            $exceptional_id = $query->row()->exceptional_id;
            if (isset($exceptional_id) && !empty($exceptional_id)) {
                return $exceptional_id;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function getLastVariableDiscountId()
    {
        $query = $this->db->query("SELECT IFNULL(variable_discount_tid,0) as variable_discount_tid FROM `tbl_variable_discount` ORDER BY variable_discount_tid DESC LIMIT 0,1");
        if ($query->num_rows() > 0) {
            $variable_discount_tid = $query->row()->variable_discount_tid;
            if (isset($variable_discount_tid) && !empty($variable_discount_tid)) {
                return $variable_discount_tid;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function getBOQExceptionalAmountByProjectID($project_id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(`rate_basic` * `EA_qty`),0) AS total_taxable_amount,
  IFNULL(SUM(`gst`),0) AS total_gst_rate FROM `tbl_boq_exceptional` WHERE display = 'Y' AND project_id = '" .
                $project_id .
                "' AND status = 'pending'"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function getBOQPreviousQty($boq_items_id, $project_id, $boq_code)
    {
        $query = $this->db->query(
            "SELECT IFNULL(design_qty,0) as design_qty
  FROM `tbl_boq_items` WHERE boq_items_id < '" .
                $boq_items_id .
                "' AND project_id= '" .
                $project_id .
                "' AND boq_code = '" .
                $boq_code .
                "'
  AND display='Y' AND status='Y' ORDER BY boq_items_id DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            return $query->row()->design_qty;
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function pending_boq_exceptional_item($project_id, $boq_code)
    {
        $query = $this->db->query(
            "SELECT * FROM `tbl_boq_exceptional` WHERE
    project_id='" .
                $project_id .
                "' AND boq_code='" .
                $boq_code .
                "' AND status='pending' AND display='Y'"
        );
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_boq_final_qty($project_id, $boq_code)
    {
        $query = $this->db->query("SELECT IFNULL(design_qty,0) as design_qty FROM `view_latest_boq_items` WHERE project_id='" . $project_id . "' AND boq_code='" . $boq_code . "' AND display = 'Y' ORDER BY boq_items_id DESC LIMIT 0,1");
        $qty = 0;
        $design_qty = $query->row()->design_qty;
        if ($design_qty > 0) {
            $qty = $design_qty;
        }
        return $qty;
        $this->db->close();
    }
    public function get_boq_dc_reject_stock($project_id, $boq_code)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(tt.qty),0) as qty
    FROM `tbl_deliv_challan_items` tt INNER JOIN tbl_delivery_challan td ON td.challan_id = tt.challan_id
    WHERE td.project_id='" .
                $project_id .
                "' AND tt.boq_code='" .
                $boq_code .
                "' AND tt.display = 'Y'"
        );
        $qty = 0;
        $design_qty = $query->row()->qty;
        if ($design_qty > 0) {
            $qty = $design_qty;
        }
        return $qty;
        $this->db->close();
    }

    public function get_boq_old_dc_qty($project_id, $boq_code, $challan_id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(tt.qty,0) as qty
    FROM `tbl_deliv_challan_items` tt INNER JOIN tbl_delivery_challan td ON td.challan_id = tt.challan_id
    WHERE td.project_id='" .
                $project_id .
                "' AND tt.boq_code='" .
                $boq_code .
                "' AND tt.challan_id = '" .
                $challan_id .
                "' AND
    tt.display = 'Y' ORDER BY tt.challan_itemid DESC LIMIT 0,1"
        );
        $qty = 0;
        $design_qty = $query->row()->qty;
        if (isset($design_qty) && $design_qty > 0) {
            $qty = $design_qty;
        }
        return $qty;
        $this->db->close();
    }

    public function get_boq_installed_provisional_qty($project_id, $boq_code)
    {
        $query = $this->db->query("SELECT IFNULL(`proforma_stock`,0) as proforma_stock FROM `tbl_boq_stock` WHERE `boq_code`='" . $boq_code . "' AND project_id='" . $project_id . "'");
        $qty = 0;
        $proforma_stock = $query->row()->proforma_stock;
        if (isset($proforma_stock) && !empty($proforma_stock) && $proforma_stock > 0) {
            $qty = $proforma_stock;
        }
        return $qty;
        $this->db->close();
    }
    public function get_project_item_details($project_id)
    {
        $query = $this->db->query("SELECT * FROM `tbl_projects` WHERE project_id='" . $project_id . "'");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_dc_boq_item_details($project_id, $boq_code)
    {
        $query = $this->db->query(
            "SELECT tdci.* FROM `tbl_deliv_challan_items` tdci INNER JOIN
      tbl_delivery_challan dc ON dc.challan_id = tdci.challan_id
      WHERE dc.project_id='" .
                $project_id .
                "' AND tdci.boq_code='" .
                $boq_code .
                "' ORDER BY challan_itemid DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_wip_boq_item($project_id, $boq_code, $wip_type)
    {
        if ($wip_type == 'installed') {
            $query = $this->db->query(
                "SELECT tdci.* FROM `tbl_install_wip_items` tdci INNER JOIN
          tbl_installed_wip dc ON dc.i_wip_id = tdci.i_wip_id
          WHERE dc.project_id='" .
                    $project_id .
                    "' AND tdci.boq_code='" .
                    $boq_code .
                    "' ORDER BY i_wip_itemid DESC LIMIT 0,1"
            );
            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return 0;
            }
            $this->db->close();
        } elseif ($wip_type == 'provisional') {
            $query = $this->db->query(
                "SELECT tdci.* FROM `tbl_prov_wip_items` tdci INNER JOIN
            tbl_provisional_wip dc ON dc.p_wip_id = tdci.p_wip_id
            WHERE dc.project_id='" .
                    $project_id .
                    "' AND tdci.boq_code='" .
                    $boq_code .
                    "' ORDER BY p_wip_itemid DESC LIMIT 0,1"
            );
            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return 0;
            }
            $this->db->close();
        } else {
            return 0;
        }
    }
    public function get_consignee_list($project_id)
    {
        $query = $this->db->query("SELECT * FROM `tbl_deliv_challan_consignee` WHERE project_id='" . $project_id . "' AND display = 'Y'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function check_stock_details($project_id, $boq_code)
    {
        $query = $this->db->query("SELECT * FROM `tbl_boq_stock` WHERE project_id='" . $project_id . "' AND boq_code='" . $boq_code . "'");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function check_bom_stock_details($project_id, $boq_code, $bom_code)
    {
        $query = $this->db->query("SELECT * FROM `tbl_bom_stock` WHERE project_id='" . $project_id . "' AND bom_code='" . $bom_code . "' AND boq_code='" . $boq_code . "'");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function getExceptionalDetails($exceptional_id)
    {
        $query = $this->db->query("SELECT * FROM `tbl_boq_exceptional` WHERE exceptional_id='" . $exceptional_id . "' AND display='Y'");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function getVariableDiscountDetails($variable_discount_tid)
    {
        $query = $this->db->query("SELECT * FROM `tbl_variable_discount` WHERE variable_discount_tid='" . $variable_discount_tid . "' AND display='Y'");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function getDCCDetails($challan_id)
    {
        $query = $this->db->query("SELECT * FROM `tbl_delivery_challan` WHERE challan_id='" . $challan_id . "' AND display='Y'");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function updateBOQItemDesignQty($type, $qty, $project_id, $boq_code)
    {
        $querylast = $this->db->query(
            "SELECT IFNULL(boq_items_id,0) AS boq_items_id  FROM `tbl_boq_items`
          WHERE `project_id` = '" .
                $project_id .
                "' AND `boq_code`='" .
                $boq_code .
                "' AND display='Y' AND status='Y' ORDER BY boq_items_id DESC LIMIT 0,1"
        );
        if ($querylast->num_rows() > 0) {
            $boq_items_id = $querylast->row()->boq_items_id;
            if ($type == 'add') {
                $query = $this->db->query("UPDATE tbl_boq_items SET design_qty = design_qty + $qty WHERE boq_items_id='" . $boq_items_id . "'");
            } else {
                $query = $this->db->query("UPDATE tbl_boq_items SET design_qty = design_qty - $qty WHERE boq_items_id='" . $boq_items_id . "'");
            }
        }
        $this->db->close();
    }
    public function checkLastExceptionalEAQtyEnter($project_id, $boq_code)
    {
        $final_design_qty = 0;
        $last_design_qty = 0;
        $prev_design_qty = 0;
        $querycount = $this->db->query(
            "SELECT IFNULL(COUNT(boq_items_id),0) AS boq_count
          FROM `tbl_boq_items` WHERE `project_id` = '" .
                $project_id .
                "' AND `boq_code`='" .
                $boq_code .
                "' AND display='Y' AND status='Y'"
        );
        if ($querycount->num_rows() > 0) {
            $count = $querycount->row()->boq_count;
            if (isset($count) && !empty($count) && $count == 1) {
                $query = $this->db->query(
                    "SELECT IFNULL(scheduled_qty,0) AS scheduled_qty,IFNULL(design_qty,0) AS design_qty
              FROM `tbl_boq_items` WHERE `project_id` = '" .
                        $project_id .
                        "' AND `boq_code`='" .
                        $boq_code .
                        "' AND display='Y' AND status='Y' ORDER BY boq_items_id DESC LIMIT 0,1"
                );
                if ($query->num_rows() > 0) {
                    $design_qty = $query->row()->design_qty;
                    $scheduled_qty = $query->row()->scheduled_qty;
                    if (isset($design_qty) && $design_qty > 0 && isset($scheduled_qty) && $scheduled_qty > 0 && $design_qty >= $scheduled_qty) {
                        $final_design_qty = $design_qty - $scheduled_qty;
                    }
                }
            } elseif (isset($count) && !empty($count) && $count > 1) {
                $querylast = $this->db->query(
                    "SELECT IFNULL(design_qty,0) AS design_qty  FROM `tbl_boq_items`
              WHERE `project_id` = '" .
                        $project_id .
                        "' AND `boq_code`='" .
                        $boq_code .
                        "' AND display='Y' AND status='Y' ORDER BY boq_items_id DESC LIMIT 0,1"
                );
                if ($querylast->num_rows() > 0) {
                    $last_design_qty = $querylast->row()->design_qty;
                    if (isset($last_design_qty) && $last_design_qty > 0) {
                        $last_design_qty = $last_design_qty;
                    }
                }
                $queryprev = $this->db->query(
                    "SELECT IFNULL(design_qty,0) AS design_qty  FROM `tbl_boq_items`
              WHERE `project_id` = '" .
                        $project_id .
                        "' AND `boq_code`='" .
                        $boq_code .
                        "' AND display='Y' AND status='Y' ORDER BY boq_items_id DESC LIMIT 1,1"
                );
                if ($queryprev->num_rows() > 0) {
                    $prev_design_qty = $queryprev->row()->design_qty;
                    if (isset($prev_design_qty) && $prev_design_qty > 0) {
                        $prev_design_qty = $prev_design_qty;
                    }
                }
                if ($prev_design_qty < $last_design_qty) {
                    $final_design_qty = $last_design_qty - $prev_design_qty;
                }
            }
        }
        return $final_design_qty;
        $this->db->close();
    }
    public function getExceptionalProjectID($exceptional_id)
    {
        $query = $this->db->query("SELECT DISTINCT project_id FROM `tbl_boq_exceptional` WHERE exceptional_id='" . $exceptional_id . "' AND display='Y' LIMIT 0,1");
        if ($query->num_rows() > 0) {
            return $query->row()->project_id;
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function getExceptionalStatusID($exceptional_id)
    {
        $query = $this->db->query("SELECT DISTINCT status FROM `tbl_boq_exceptional` WHERE exceptional_id='" . $exceptional_id . "' AND display='Y' LIMIT 0,1");
        if ($query->num_rows() > 0) {
            return $query->row()->status;
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function getDccStatusID($challan_id)
    {
        $query = $this->db->query("SELECT DISTINCT status FROM `tbl_delivery_challan` WHERE challan_id='" . $challan_id . "' AND display='Y' LIMIT 0,1");
        if ($query->num_rows() > 0) {
            return $query->row()->status;
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function getProformaInvoiceItems($proforma_id, $user_id, $tax_invc_id)
    {
        $curr_date = date('Y-m-d H:i:s');
        $query = $this->db->query(
            "SELECT '" .
                $tax_invc_id .
                "' as tax_invc_id,IFNULL(`boq_code`,0) as boq_code, IFNULL(`hsn_sac_code`,0) AS hsn_sac_code,
          IFNULL(`item_description`,0) AS item_description , IFNULL(`unit`,0) AS unit,IFNULL(`qty`,0) AS qty, IFNULL(`rate`,0) AS rate,
          IFNULL(`taxable_amount`,0) AS taxable_amount,IFNULL(`gst_type`,0) AS gst_type,IFNULL(`gst`,0) AS gst,IFNULL(`sgst`,0) AS sgst,
          IFNULL(`cgst`,0) AS cgst, IFNULL(`sgst_amount`,0) AS sgst_amount,IFNULL(`cgst_amount`,0) AS cgst_amount, IFNULL(`gst_amount`,0) AS gst_amount,
          '" .
                $user_id .
                "' AS created_by,'" .
                $curr_date .
                "' AS created_on,'" .
                $user_id .
                "' AS modified_by,'" .
                $curr_date .
                "' AS modified_on,'Y' AS display,'Under Approval' AS status
          FROM `tbl_proforma_invc_items` WHERE `proforma_id`='" .
                $proforma_id .
                "'  AND `display`='Y'"
        );
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function getInstalledWIPDetails($i_wip_id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(tiw.project_id,0) as project_id,IFNULL(tiwi.`boq_code`,0) as boq_code,IFNULL(tiwi.installed_qty,0) as installed_qty
          FROM `tbl_install_wip_items` tiwi INNER JOIN tbl_installed_wip tiw ON tiw.i_wip_id = tiwi.i_wip_id
          WHERE tiwi.i_wip_id = '" .
                $i_wip_id .
                "' AND tiw.display = 'Y' AND tiwi.display = 'Y' "
        );
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function getProvisionalWIPDetails($p_wip_id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(tiw.project_id,0) as project_id,IFNULL(tiwi.`boq_code`,0) as boq_code,IFNULL(tiwi.prov_qty,0) as prov_qty
          FROM `tbl_prov_wip_items` tiwi INNER JOIN tbl_provisional_wip tiw ON tiw.p_wip_id = tiwi.p_wip_id
          WHERE tiwi.p_wip_id = '" .
                $p_wip_id .
                "' AND tiw.display = 'Y' AND tiwi.display = 'Y' "
        );
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function getProvisionalProjectID($p_wip_id)
    {
        $query = $this->db->query("SELECT DISTINCT project_id FROM `tbl_provisional_wip` WHERE p_wip_id='" . $p_wip_id . "' AND display='Y' LIMIT 0,1");
        if ($query->num_rows() > 0) {
            return $query->row()->project_id;
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function getInstalledProjectID($i_wip_id)
    {
        $query = $this->db->query("SELECT DISTINCT project_id FROM `tbl_installed_wip` WHERE i_wip_id='" . $i_wip_id . "' AND display='Y' LIMIT 0,1");
        if ($query->num_rows() > 0) {
            return $query->row()->project_id;
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_invoice_received_payment($tax_incv_id)
    {
        $query = $this->db->query("SELECT IFNULL(SUM(`payment_received_amount`),0) as total_amount FROM `tbl_payment_receipt` WHERE display = 'Y' AND `tax_incv_id`='" . $tax_incv_id . "'");
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_receipt_received_payment($id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(`payment_received_amount`),0) as total_amount FROM `tbl_payment_receipt`
          WHERE display = 'Y' AND `id`='" .
                $id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_receipt_it_tds_amount($id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(`it_tds_amount`),0) as total_amount
          FROM `tbl_payment_receipt` WHERE display = 'Y' AND `id`='" .
                $id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_receipt_gtds_amount($id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(`gtds_amount`),0) as total_amount
          FROM `tbl_payment_receipt` WHERE display = 'Y' AND `id`='" .
                $id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_receipt_other_tax_deduction($id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(ttx.`tax_deduction_amt`),0) as total_amount
          FROM `tbl_any_o_tax` ttx INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttx.pay_receipt_id
          WHERE tpr.display = 'Y' AND tpr.`id`='" .
                $id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_receipt_security_deposit_retn_amount($id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(`security_deposit_retn_amount`),0) as total_amount
          FROM `tbl_payment_receipt` WHERE display = 'Y' AND `id`='" .
                $id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_invoice_it_tds_amount($tax_incv_id)
    {
        $query = $this->db->query("SELECT IFNULL(SUM(`it_tds_amount`),0) as total_amount FROM `tbl_payment_receipt` WHERE display = 'Y' AND `tax_incv_id`='" . $tax_incv_id . "'");
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_invoice_gtds_amount($tax_incv_id)
    {
        $query = $this->db->query("SELECT IFNULL(SUM(`gtds_amount`),0) as total_amount FROM `tbl_payment_receipt` WHERE display = 'Y' AND `tax_incv_id`='" . $tax_incv_id . "'");
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_boq_item_variation_data($type, $transaction_id, $transaction_type, $project_id, $status_txt)
    {
        if (isset($status_txt) && !empty($status_txt)) {
            $status = 'N';
            $status1 = 'pending';
        } else {
            $status = 'Y';
            $status1 = 'approved';
        }
        if ($transaction_type == 'boq_upload' || $transaction_type == 'add_edit_boq') {
            if ($type == 'pos_variation') {
                $query = $this->db->query(
                    "SELECT IFNULL(SUM((design_qty-scheduled_qty)),0) as qty,
              IFNULL(SUM((design_qty-scheduled_qty) * rate_basic),0) as amount,
              IFNULL(SUM(((design_qty-scheduled_qty) * rate_basic)*(gst/100)+((design_qty-scheduled_qty) * rate_basic)),0) as amount_gst
              FROM `tbl_boq_items`
              WHERE transaction_id = '" .
                        $transaction_id .
                        "' AND status='" .
                        $status .
                        "' AND display='Y' AND project_id = '" .
                        $project_id .
                        "' AND design_qty > scheduled_qty"
                );
            } else {
                $query = $this->db->query(
                    "SELECT SUM((scheduled_qty-design_qty)) as qty,
              IFNULL(SUM((scheduled_qty-design_qty) * rate_basic),0) as amount,
              IFNULL(SUM(((scheduled_qty-design_qty) * rate_basic)*(gst/100)+((scheduled_qty-design_qty) * rate_basic)),0) as amount_gst
              FROM `tbl_boq_items`
              WHERE transaction_id = '" .
                        $transaction_id .
                        "' AND status='" .
                        $status .
                        "' AND display='Y' AND project_id = '" .
                        $project_id .
                        "' AND design_qty < scheduled_qty"
                );
            }
            if ($query->num_rows() > 0) {
                return $query->row_array();
            } else {
                return 0;
            }
            $this->db->close();
        } else {
            return 0;
        }
    }
    public function get_boq_item_amount($filter, $transaction_id, $transaction_type, $project_id, $status_txt)
    {
        if (isset($status_txt) && !empty($status_txt)) {
            $status = 'N';
            $status1 = 'pending';
        } else {
            $status = 'Y';
            $status1 = 'approved';
        }
        if ($transaction_type == 'boq_upload' || $transaction_type == 'add_edit_boq') {
            // $query=$this->db->query("SELECT IFNULL(SUM(`scheduled_qty`),0) as total_sch_qty,
            // IFNULL(SUM(`design_qty`),0) as total_dsgnqty,
            // IFNULL(SUM(`upload_design_qty`),0) as total_udsgn_qty,
            // IFNULL(SUM(`o_design_qty`),0) as total_odsgnqty,
            // IFNULL(SUM(`rate_basic`),0) as total_basic_rate,
            // IFNULL(SUM(`rate_basic`*`scheduled_qty`),0) as total_sch_amount,
            // IFNULL(SUM(`rate_basic`*`design_qty`),0) as total_dsgn_amount,
            // IFNULL(SUM(`rate_basic`*`upload_design_qty`),0) as total_udsgn_amt,
            // IFNULL(SUM(`gst`),0) as total_gst_rate,
            // IFNULL(SUM((`rate_basic`*`scheduled_qty`)*(`gst`/100)),0) as total_sch_gst_amount,
            // IFNULL(SUM((`rate_basic`*`upload_design_qty`)*(`gst`/100)),0) as total_udsgn_amt_gst,
            // IFNULL(SUM((`rate_basic`*`scheduled_qty`)+((`rate_basic`*`scheduled_qty`)*(`gst`/100))),0) as total_sch_amount_with_gst,
            // IFNULL(SUM((`rate_basic`*`upload_design_qty`)+((`rate_basic`*`upload_design_qty`)*(`gst`/100))),0) as total_udsgn_withgst_amt,
            // IFNULL(SUM((`rate_basic`*`design_qty`)*(`gst`/100)),0) as total_dsgn_gst_amount,
            // IFNULL(SUM((`rate_basic`*`design_qty`) + ((`rate_basic`*`design_qty`)*(`gst`/100))),0) as total_dsgn_amount_with_gst,
            // (case when (`design_qty` > scheduled_qty) then (SUM((design_qty-scheduled_qty))) else (0) END) AS total_positive_var,
            // (case when (`design_qty` < scheduled_qty) then (SUM((scheduled_qty-design_qty))) else (0) END) AS total_negative_var,
            // (case when (`design_qty` > scheduled_qty) then (SUM((design_qty-scheduled_qty) * rate_basic)) else (0) END) AS total_ea_amount,

            // (case when (`design_qty` > scheduled_qty) then (SUM(((design_qty-scheduled_qty) * rate_basic)+(((design_qty-scheduled_qty) * rate_basic)*(`gst`/100)))) else (0) END) AS total_ea_gst_amount,
            // (case when (`design_qty` < scheduled_qty) then (SUM((scheduled_qty-design_qty) * rate_basic)) else (0) END) AS total_negative_var_amount,
            // (case when (`design_qty` < scheduled_qty) then (SUM(((scheduled_qty-design_qty) * rate_basic)+(((scheduled_qty-design_qty) * rate_basic)*(`gst`/100)))) else (0) END) AS total_negative_var_gst_amount,
            // (case when (`non_schedule` ='Y') then (SUM(design_qty * rate_basic)) else (0) END) AS total_non_sch_amount,
            // (case when (`non_schedule` ='Y') then (SUM((design_qty * rate_basic)+((design_qty * rate_basic) * (`gst`/100)))) else (0) END) AS total_non_sch_gst_amount
            // FROM `tbl_boq_items` WHERE display='Y' AND status='".$status."' AND project_id='".$project_id."' AND transaction_id = '".$transaction_id."'");
//             error_reporting(-1);
// 		ini_set('display_errors', 1);
            $query = $this->db->query(
                "
            SELECT 
            DISTINCT boq_code,
            IFNULL(`scheduled_qty`, 0) AS total_sch_qty,
            IFNULL(`design_qty`, 0) AS total_dsgnqty,
            IFNULL(`upload_design_qty`, 0) AS total_udsgn_qty,
            IFNULL(`o_design_qty`, 0) AS total_odsgnqty,
            IFNULL(`rate_basic`, 0) AS total_basic_rate,
            IFNULL(`rate_basic` * `scheduled_qty`, 0) AS total_sch_amount,
            IFNULL(`rate_basic` * `design_qty`, 0) AS total_dsgn_amount,
            IFNULL(`rate_basic` * `upload_design_qty`, 0) AS total_udsgn_amt,
            IFNULL(`gst`, 0) AS total_gst_rate,
            IFNULL(`rate_basic` * `scheduled_qty` * (`gst` / 100), 0) AS total_sch_gst_amount,
            IFNULL(`rate_basic` * `upload_design_qty` * (`gst` / 100), 0) AS total_udsgn_amt_gst,
            IFNULL(`rate_basic` * `scheduled_qty` + (`rate_basic` * `scheduled_qty` * (`gst` / 100)), 0) AS total_sch_amount_with_gst,
            IFNULL(`rate_basic` * `upload_design_qty` + (`rate_basic` * `upload_design_qty` * (`gst` / 100)), 0) AS total_udsgn_withgst_amt,
            IFNULL(`rate_basic` * `design_qty` * (`gst` / 100), 0) AS total_dsgn_gst_amount,
            IFNULL(`rate_basic` * `design_qty` + (`rate_basic` * `design_qty` * (`gst` / 100)), 0) AS total_dsgn_amount_with_gst,
            
            -- Positive variance
            IFNULL(CASE WHEN `design_qty` > `scheduled_qty` THEN (`design_qty` - `scheduled_qty`) ELSE 0 END, 0) AS total_positive_var,
            
            -- Negative variance
            IFNULL(CASE WHEN `design_qty` < `scheduled_qty` THEN (`scheduled_qty` - `design_qty`) ELSE 0 END, 0) AS total_negative_var,
        
            -- Positive variance amount
            IFNULL(CASE WHEN `design_qty` > `scheduled_qty` THEN (`design_qty` - `scheduled_qty`) * `rate_basic` ELSE 0 END, 0) AS total_ea_amount,
        
            -- Positive variance amount with GST
            IFNULL(CASE WHEN `design_qty` > `scheduled_qty` THEN (`design_qty` - `scheduled_qty`) * `rate_basic` + ((`design_qty` - `scheduled_qty`) * `rate_basic` * (`gst` / 100)) ELSE 0 END, 0) AS total_ea_gst_amount,
        
            -- Negative variance amount
            IFNULL(CASE WHEN `design_qty` < `scheduled_qty` THEN (`scheduled_qty` - `design_qty`) * `rate_basic` ELSE 0 END, 0) AS total_negative_var_amount,
        
            -- Negative variance amount with GST
            IFNULL(CASE WHEN `design_qty` < `scheduled_qty` THEN (`scheduled_qty` - `design_qty`) * `rate_basic` + ((`scheduled_qty` - `design_qty`) * `rate_basic` * (`gst` / 100)) ELSE 0 END, 0) AS total_negative_var_gst_amount,
        
            -- Non-scheduled amount
            IFNULL(CASE WHEN `non_schedule` = 'Y' THEN `design_qty` * `rate_basic` ELSE 0 END, 0) AS total_non_sch_amount,
        
            -- Non-scheduled amount with GST
            IFNULL(CASE WHEN `non_schedule` = 'Y' THEN `design_qty` * `rate_basic` + (`design_qty` * `rate_basic` * (`gst` / 100)) ELSE 0 END, 0) AS total_non_sch_gst_amount
        
        FROM
            `tbl_boq_items`
        WHERE
            `display` = 'Y'
                    AND `status` = " .
                            $this->db->escape($status) .
                            "
                    AND `project_id` = " .
                            $this->db->escape($project_id) .
                            "
                    AND `transaction_id` = " .
                            $this->db->escape($transaction_id)
                    );
             if ($query->num_rows() > 0) {
                    $data_val = $query->result_array();
                    $final_data = [
                        'boq_code' => 1, // You can set any default here, since the boq_codes are already unique in each entry
                        'total_sch_qty' => 0,
                        'total_dsgnqty' => 0,
                        'total_udsgn_qty' => 0,
                        'total_odsgnqty' => 0,
                        'total_basic_rate' => 0,
                        'total_sch_amount' => 0,
                        'total_dsgn_amount' => 0,
                        'total_udsgn_amt' => 0,
                        'total_gst_rate' => 0,
                        'total_sch_gst_amount' => 0,
                        'total_udsgn_amt_gst' => 0,
                        'total_sch_amount_with_gst' => 0,
                        'total_udsgn_withgst_amt' => 0,
                        'total_dsgn_gst_amount' => 0,
                        'total_dsgn_amount_with_gst' => 0,
                        'total_positive_var' => 0,
                        'total_negative_var' => 0,
                        'total_ea_amount' => 0,
                        'total_ea_gst_amount' => 0,
                        'total_negative_var_amount' => 0,
                        'total_negative_var_gst_amount' => 0,
                        'total_non_sch_amount' => 0,
                        'total_non_sch_gst_amount' => 0
                    ];
                    
                    // Iterate over the input data and sum up the values
                    foreach ($data_val as $row) {
                        $final_data['total_sch_qty'] += $row['total_sch_qty'];
                        $final_data['total_dsgnqty'] += $row['total_dsgnqty'];
                        $final_data['total_udsgn_qty'] += $row['total_udsgn_qty'];
                        $final_data['total_odsgnqty'] += $row['total_odsgnqty'];
                        $final_data['total_basic_rate'] += $row['total_basic_rate'];
                        $final_data['total_sch_amount'] += $row['total_sch_amount'];
                        $final_data['total_dsgn_amount'] += $row['total_dsgn_amount'];
                        $final_data['total_udsgn_amt'] += $row['total_udsgn_amt'];
                        $final_data['total_gst_rate'] += $row['total_gst_rate'];
                        $final_data['total_sch_gst_amount'] += $row['total_sch_gst_amount'];
                        $final_data['total_udsgn_amt_gst'] += $row['total_udsgn_amt_gst'];
                        $final_data['total_sch_amount_with_gst'] += $row['total_sch_amount_with_gst'];
                        $final_data['total_udsgn_withgst_amt'] += $row['total_udsgn_withgst_amt'];
                        $final_data['total_dsgn_gst_amount'] += $row['total_dsgn_gst_amount'];
                        $final_data['total_dsgn_amount_with_gst'] += $row['total_dsgn_amount_with_gst'];
                        $final_data['total_positive_var'] += $row['total_positive_var'];
                        $final_data['total_negative_var'] += $row['total_negative_var'];
                        $final_data['total_ea_amount'] += $row['total_ea_amount'];
                        $final_data['total_ea_gst_amount'] += $row['total_ea_gst_amount'];
                        $final_data['total_negative_var_amount'] += $row['total_negative_var_amount'];
                        $final_data['total_negative_var_gst_amount'] += $row['total_negative_var_gst_amount'];
                        $final_data['total_non_sch_amount'] += $row['total_non_sch_amount'];
                        $final_data['total_non_sch_gst_amount'] += $row['total_non_sch_gst_amount'];
                    }
                    return $final_data;
                } else {
                    return 0;
                }
        } elseif ($transaction_type == 'boq_exceptional_appr') {
            $query = $this->db->query(
                "SELECT DISTINCT boq_code,IFNULL(SUM(`EA_qty`),0) as total_EA_qty,IFNULL(SUM(`scheduled_qty`),0) as total_sch_qty,
          IFNULL(SUM(`rate_basic`),0) as total_basic_rate,
          IFNULL(SUM(`rate_basic`*`scheduled_qty`),0) as total_sch_amount,
          IFNULL(SUM(`rate_basic`*`EA_qty`),0) as total_ea_amount,
          IFNULL(SUM(`gst`),0) as total_gst_rate,
          IFNULL(SUM((`rate_basic`*`scheduled_qty`)*(`gst`/100)),0) as total_sch_gst_amount,
          IFNULL(SUM((`rate_basic`*`EA_qty`)*(`gst`/100)),0) as total_ea_gst_amount,
          IFNULL(SUM((`rate_basic`*`scheduled_qty`)+(`rate_basic`*`scheduled_qty`)*(`gst`/100)),0) as total_sch_amount_with_gst,
          IFNULL(SUM((`rate_basic`*`EA_qty`)+((`rate_basic`*`EA_qty`)*(`gst`/100))),0) as total_ea_amount_with_gst
          FROM `tbl_boq_exceptional` WHERE display='Y' AND status='" .
                    $status1 .
                    "' AND project_id='" .
                    $project_id .
                    "' AND transaction_id = '" .
                    $transaction_id .
                    "'"
            );
        } elseif ($transaction_type == 'add_dc') {
            $query = $this->db->query(
                "SELECT
            IFNULL(SUM(taxable_amount),0) as total_dc_withgst_amt
            FROM `tbl_deliv_challan_items` dcitem INNER JOIN tbl_delivery_challan dc
            ON dcitem.challan_id = dc.challan_id
            WHERE dc.display='Y' AND dc.status='" .
                    $status1 .
                    "' AND dc.project_id='" .
                    $project_id .
                    "' AND dc.transaction_id = '" .
                    $transaction_id .
                    "'"
            );
        } elseif ($transaction_type == 'boq_variable_discount') {
            return 0;
        }
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
       
        $this->db->close();
    }
    public function get_invoice_security_deposit_retn_amount($tax_incv_id)
    {
        $query = $this->db->query("SELECT IFNULL(SUM(`security_deposit_retn_amount`),0) as total_amount FROM `tbl_payment_receipt` WHERE display = 'Y' AND `tax_incv_id`='" . $tax_incv_id . "'");
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_invoice_retn_amount($tax_incv_id)
    {
        $query = $this->db->query("SELECT IFNULL(SUM(`retenstion_amount`),0) as total_amount FROM `tbl_payment_receipt` WHERE display = 'Y' AND `tax_incv_id`='" . $tax_incv_id . "'");
        if ($query->num_rows() > 0) {
            //echo $this->db->last_query();die;
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_invoice_labour_cess($tax_incv_id)
    {
        $query = $this->db->query("SELECT IFNULL(SUM(`labour_cess`),0) as total_amount FROM `tbl_payment_receipt` WHERE display = 'Y' AND `tax_incv_id`='" . $tax_incv_id . "'");
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_invoice_hsn_data($tbl, $invoice_id)
    {
        if ($tbl == 'tbl_proforma_invc_items') {
            $query = $this->db->query(
                "SELECT `hsn_sac_code`,gst_type,IFNULL(SUM(`qty`),0) as qty,IFNULL(SUM(`rate`),0) as rate,
            IFNULL(SUM(`gst`),0) as gst,IFNULL(SUM(`cgst`),0) as cgst,IFNULL(SUM(`sgst`),0) as sgst,
            IFNULL(SUM(`cgst_amount`),0) as cgst_amount,IFNULL(SUM(`sgst_amount`),0) as sgst_amount,IFNULL(SUM(`gst_amount`),0) as gst_amount
            FROM tbl_proforma_invc_items WHERE `proforma_id`='" .
                    $invoice_id .
                    "' AND display='Y' GROUP BY `hsn_sac_code` ORDER BY `proforma_itemid` ASC"
            );
        } else {
            $query = $this->db->query(
                "SELECT `hsn_sac_code`,gst_type,IFNULL(SUM(`qty`),0) as qty,IFNULL(SUM(`rate`),0) as rate,
            IFNULL(SUM(`gst`),0) as gst,IFNULL(SUM(`cgst`),0) as cgst,IFNULL(SUM(`sgst`),0) as sgst,
            IFNULL(SUM(`cgst_amount`),0) as cgst_amount,IFNULL(SUM(`sgst_amount`),0) as sgst_amount,IFNULL(SUM(`gst_amount`),0) as gst_amount
            FROM tbl_tax_invc_items WHERE `tax_invc_id`='" .
                    $invoice_id .
                    "' AND display='Y' GROUP BY `hsn_sac_code` ORDER BY `tax_invc_itemid` ASC"
            );
        }
        if ($query->num_rows() > 0) {
            $tbl_data = [];
            $result = $query->result_array();
            if (isset($result) && !empty($result)) {
                $count = count($result) * 2;
                $j = 0;
                for ($i = 0; $i < $count; $i++) {
                    if ($i % 2 == 0) {
                        $tbl_data[$i]['hsn_sac_code'] = $result[$j]['hsn_sac_code'];
                        $tbl_data[$i]['gst_type'] = $result[$j]['gst_type'];
                        $tbl_data[$i]['qty'] = $result[$j]['qty'];
                        $tbl_data[$i]['rate'] = $result[$j]['rate'];
                        $tbl_data[$i]['gst'] = $result[$j]['gst'];
                        $tbl_data[$i]['cgst'] = $result[$j]['cgst'];
                        $tbl_data[$i]['sgst'] = $result[$j]['sgst'];
                        $tbl_data[$i]['cgst_amount'] = $result[$j]['cgst_amount'];
                        $tbl_data[$i]['gst_amount'] = $result[$j]['gst_amount'];
                        $tbl_data[$i]['sgst_amount'] = $result[$j]['sgst_amount'];
                        $j = $j - 1;
                    } else {
                        $tbl_data[$i]['hsn_sac_code'] = '';
                        $tbl_data[$i]['gst_type'] = '';
                        $tbl_data[$i]['qty'] = '';
                        $tbl_data[$i]['rate'] = '';
                        $tbl_data[$i]['gst'] = '';
                        $tbl_data[$i]['cgst'] = '';
                        $tbl_data[$i]['sgst'] = '';
                        $tbl_data[$i]['cgst_amount'] = '';
                        $tbl_data[$i]['gst_amount'] = '';
                        $tbl_data[$i]['sgst_amount'] = '';
                    }
                    if ($j < $count) {
                        $j++;
                    }
                }
                return $tbl_data;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
    public function get_invoice_other_tax_deduction($tax_incv_id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(ttx.`tax_deduction_amt`),0) as total_amount
          FROM `tbl_any_o_tax` ttx INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttx.pay_receipt_id
          WHERE tpr.display = 'Y' AND tpr.`tax_incv_id`='" .
                $tax_incv_id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_invoice_other_deposit($tax_incv_id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(ttd.`deposit_amount`),0) as total_amount
          FROM `tbl_any_o_deposit` ttd INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttd.pay_receipt_id
          WHERE tpr.display = 'Y' AND tpr.`tax_incv_id`='" .
                $tax_incv_id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_receipt_other_deposit($id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(ttd.`deposit_amount`),0) as total_amount
          FROM `tbl_any_o_deposit` ttd INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttd.pay_receipt_id
          WHERE tpr.display = 'Y' AND tpr.`id`='" .
                $id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_receipt_withheld($id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(ttw.`withheld_amt`),0) as total_amount
          FROM `tbl_withheld` ttw INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttw.pay_receipt_id
          WHERE tpr.display = 'Y' AND tpr.`id`='" .
                $id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_receipt_labour_cess($id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(`labour_cess`),0) as total_amount
          FROM `tbl_payment_receipt` WHERE display = 'Y' AND `id`='" .
                $id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_receipt_other_cess($id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(ttoc.`other_cess_amt`),0) as total_amount
          FROM `tbl_any_o_cess` ttoc INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttoc.pay_receipt_id
          WHERE tpr.display = 'Y' AND tpr.`id`='" .
                $id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_receipt_other_deductions($id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(ttod.`deduction_amt`),0) as total_amount
          FROM `tbl_any_o_deduction` ttod INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttod.pay_receipt_id
          WHERE tpr.display = 'Y' AND tpr.`id`='" .
                $id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_invoice_withheld($tax_incv_id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(ttw.`withheld_amt`),0) as total_amount
          FROM `tbl_withheld` ttw INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttw.pay_receipt_id
          WHERE tpr.display = 'Y' AND tpr.`tax_incv_id`='" .
                $tax_incv_id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_invoice_other_cess($tax_incv_id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(ttoc.`other_cess_amt`),0) as total_amount
          FROM `tbl_any_o_cess` ttoc INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttoc.pay_receipt_id
          WHERE tpr.display = 'Y' AND tpr.`tax_incv_id`='" .
                $tax_incv_id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_invoice_other_deductions($tax_incv_id)
    {
        $query = $this->db->query(
            "SELECT IFNULL(SUM(ttod.`deduction_amt`),0) as total_amount
          FROM `tbl_any_o_deduction` ttod INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttod.pay_receipt_id
          WHERE tpr.display = 'Y' AND tpr.`tax_incv_id`='" .
                $tax_incv_id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
                return $total_amount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function getInvoiceClouserOtherDeductions($tablename, $tax_incv_id)
    {
        $query = $this->db->query(
            "SELECT ttod.*
            FROM $tablename ttod INNER JOIN tbl_payment_receipt tpr ON tpr.id = ttod.pay_receipt_id
            WHERE tpr.display = 'Y' AND tpr.`tax_incv_id`='" .
                $tax_incv_id .
                "'"
        );
        if ($query->num_rows() > 0) {
            $result = $query->result();
            if (isset($result) && !empty($result)) {
                return $result;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        $this->db->close();
    }


    // public function get_invoice_amount($tax_invc_id)
    // {
    //     $query=$this->db->query("SELECT
    //     (case when (gst_type = 'intra-state') then ((IFNULL(SUM(`taxable_amount`),0) + IFNULL(SUM(`sgst_amount`),0) + IFNULL(SUM(`cgst_amount`),0))) else ((IFNULL(SUM(`taxable_amount`),0) + IFNULL(SUM(`gst_amount`),0))) END) as total_amount
    //     FROM `tbl_tax_invc_items` WHERE display = 'Y' AND `tax_invc_id`='".$tax_invc_id."'");

    //     $query = $this->db->query(
    //         "
    //         SELECT
    //         SUM(
    //           CASE
    //           WHEN gst_type = 'intra-state' THEN
    //           IFNULL(taxable_amount, 0) + IFNULL(sgst_amount, 0) + IFNULL(cgst_amount, 0)
    //           ELSE
    //           IFNULL(taxable_amount, 0) + IFNULL(gst_amount, 0)
    //           END
    //           ) AS total_amount
    //           FROM
    //           tbl_tax_invc_items
    //           WHERE
    //           display = 'Y'
    //           AND tax_invc_id = '" .
    //             $tax_invc_id .
    //             "'
    //           "
    //     );

    //     if ($query->num_rows() > 0) {
    //         $total_amount = $query->row()->total_amount;
    //         if (isset($total_amount) && !empty($total_amount) && $total_amount > 0) {
    //             return $total_amount;
    //         } else {
    //             return 0;
    //         }
    //     } else {
    //         return 0;
    //     }
    //     $this->db->close();
    // }

    public function get_invoice_amount($tax_invc_id)
    {
        // SQL query to get the total invoice amount from tbl_tax_invc_items
        $sql = "
            SELECT
                SUM(
                    CASE
                        WHEN gst_type = 'intra-state' THEN
                            IFNULL(taxable_amount, 0) + IFNULL(sgst_amount, 0) + IFNULL(cgst_amount, 0)
                        ELSE
                            IFNULL(taxable_amount, 0) + IFNULL(gst_amount, 0)
                    END
                ) AS total_amount
            FROM tbl_tax_invc_items
            WHERE display = 'Y' AND tax_invc_id = ?
        ";
    
        // Execute the query with the parameter
        $query = $this->db->query($sql, [$tax_invc_id]);
    
        $total_amount = 0;
        if ($query->num_rows() > 0) {
            $total_amount = $query->row()->total_amount;
            $total_amount = ($total_amount > 0) ? $total_amount : 0;
        }
    
        // Query to get the auto_round_value from tbl_proforma_invc using convertid from tbl_tax_invc
        $round_sql = "
            SELECT pi.auto_round_value
            FROM tbl_tax_invc ti
            JOIN tbl_proforma_invc pi ON ti.convertid = pi.proforma_id
            WHERE ti.tax_invc_id = ?
        ";
    
        $round_query = $this->db->query($round_sql, [$tax_invc_id]);
    
        $auto_round_value = 0;
        if ($round_query->num_rows() > 0) {
            $auto_round_value = $round_query->row()->auto_round_value;
        }
    
        // Add auto_round_value to the total_amount
        return $total_amount + $auto_round_value;
    }
    

    public function get_consinee_details($consignee_id)
    {
        $query = $this->db->query(
            "SELECT * FROM `tbl_deliv_challan_consignee`
                WHERE id='" .
                $consignee_id .
                "' ORDER BY id DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_payment_receipt_no()
    {
        $query = $this->db->query("SELECT IFNULL(payment_receipt_no,0) as payment_receipt_no FROM `tbl_payment_receipt` ORDER BY payment_receipt_no DESC LIMIT 0,1");
        if ($query->num_rows() > 0) {
            return $query->row()->payment_receipt_no;
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function get_wip_boq_item_details($project_id, $boq_code)
    {
        $queryi = $this->db->query(
            "SELECT tdc.* FROM `tbl_install_wip_items` tdc
                  INNER JOIN tbl_installed_wip iwip ON iwip.i_wip_id = tdc.i_wip_id
                  INNER JOIN tbl_boq_items tb ON iwip.project_id = tb.project_id AND tdc.boq_code = tb.boq_code
                  WHERE iwip.project_id='" .
                $project_id .
                "' AND tb.boq_code='" .
                $boq_code .
                "' ORDER BY tdc.i_wip_itemid DESC LIMIT 0,1"
        );
        if ($queryi->num_rows() > 0) {
            return $queryi->row();
        } else {
            $queryip = $this->db->query(
                "SELECT tdc.* FROM `tbl_prov_wip_items` tdc
                      INNER JOIN tbl_provisional_wip pwip ON pwip.p_wip_id = tdc.p_wip_id
                      INNER JOIN tbl_boq_items tb ON pwip.project_id = tb.project_id AND tdc.boq_code = tb.boq_code
                      WHERE pwip.project_id='" .
                    $project_id .
                    "' AND tb.boq_code='" .
                    $boq_code .
                    "' ORDER BY tdc.p_wip_itemid DESC LIMIT 0,1"
            );
            if ($queryip->num_rows() > 0) {
                return $queryip->row();
            } else {
                return 0;
            }
            $this->db->close();
        }
    }
    public function get_proforma_boq_item_details($project_id, $boq_code)
    {
        $queryi = $this->db->query(
            "SELECT tdc.* FROM `tbl_proforma_invc_items` tdc
                      INNER JOIN tbl_proforma_invc prom ON prom.proforma_id = tdc.proforma_id
                      INNER JOIN tbl_boq_items tb ON prom.project_id = tb.project_id AND tdc.boq_code = tb.boq_code
                      WHERE prom.project_id='" .
                $project_id .
                "' AND tb.boq_code='" .
                $boq_code .
                "' ORDER BY tdc.proforma_itemid DESC LIMIT 0,1"
        );
        if ($queryi->num_rows() > 0) {
            return $queryi->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function get_tax_boq_item_details($project_id, $boq_code)
    {
        $queryi = $this->db->query(
            "SELECT tdc.* FROM `tbl_tax_invc_items` tdc
                        INNER JOIN tbl_tax_invc prom ON prom.tax_invc_id = tdc.tax_invc_id
                        INNER JOIN tbl_boq_items tb ON prom.project_id = tb.project_id AND tdc.boq_code = tb.boq_code
                        WHERE prom.project_id='" .
                $project_id .
                "' AND tb.boq_code='" .
                $boq_code .
                "' ORDER BY tdc.tax_invc_itemid DESC LIMIT 0,1"
        );
        if ($queryi->num_rows() > 0) {
            return $queryi->row();
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function deleteOldConsignee($project_id)
    {
        $this->db->where('project_id', $project_id);
        $this->db->delete('tbl_deliv_challan_consignee');
    }
    public function deleteOldInsuranceData($project_id)
    {
        $this->db->where('project_id', $project_id);
        $this->db->delete('tbl_insurance_data');
    }
    public function deleteOldSampleData($project_id)
    {
        $this->db->where('project_id', $project_id);
        $this->db->delete('tbl_sample');
    }
    public function deleteOldPrototypeData($project_id)
    {
        $this->db->where('project_id', $project_id);
        $this->db->delete('tbl_prototype');
    }
    public function deleteOldInspectionData($project_id)
    {
        $this->db->where('project_id', $project_id);
        $this->db->delete('tbl_inspection');
    }
    public function deleteOldFatData($project_id)
    {
        $this->db->where('project_id', $project_id);
        $this->db->delete('tbl_fat');
    }
    public function deleteOldSatData($project_id)
    {
        $this->db->where('project_id', $project_id);
        $this->db->delete('tbl_sat');
    }
    public function deleteOldtestreport($project_id)
    {
        $this->db->where('project_id', $project_id);
        $this->db->delete('tbl_test_report');
    }

    public function deleteOldVendordirectorData($vendor_id)
    {
        $this->db->where('vendor_id', $vendor_id);
        $this->db->delete('tbl_vendor_director');
    }
    public function deleteOldVendorregionData($vendor_id)
    {
        $this->db->where('vendor_id', $vendor_id);
        $this->db->delete('tbl_vendor_region');
    }

    public function deletereferencesData($vendor_id)
    {
        $this->db->where('vendor_id', $vendor_id);
        $this->db->delete('tbl_vendor_references');
    }

    public function deleteBOQExceptionalItem($deleted_boq_items_id, $boq_items_id, $project_id, $boq_code)
    {
        $update_minus_stock_arr = $delete_arr = [];
        if (isset($boq_items_id) && !empty($boq_items_id) && $boq_items_id > 0) {
            $query = $this->db->query(
                "SELECT id,project_id,boq_code,IFNULL(EA_qty,0) AS EA_qty FROM `tbl_boq_exceptional`
                          WHERE boq_items_id = '" .
                    $boq_items_id .
                    "' AND display='Y' AND status!='approved'"
            );
        } else {
            $query = $this->db->query(
                "SELECT id,project_id,boq_code,IFNULL(EA_qty,0) AS EA_qty FROM `tbl_boq_exceptional`
                          WHERE project_id = '" .
                    $project_id .
                    "' AND boq_code = '" .
                    $boq_code .
                    "' AND display='Y' AND status!='approved'"
            );
        }
        if ($query->num_rows() > 0) {
            $result = $query->result();
            if (isset($result) && !empty($result)) {
                foreach ($result as $key) {
                    if (isset($key->EA_qty) && !empty($key->EA_qty) && $key->EA_qty > 0) {
                        $check_stock_details = $this->check_stock_details($key->project_id, $key->boq_code);
                        if (isset($check_stock_details) && !empty($check_stock_details)) {
                            $ea_total_stock = 0;
                            $ea_total_stock_val = 0;
                            $ea_pending = 0;
                            $ea_pending_val = 0;
                            if (isset($check_stock_details->ea_total_stock) && !empty($check_stock_details->ea_total_stock) && $check_stock_details->ea_total_stock > 0) {
                                $ea_total_stock = $check_stock_details->ea_total_stock;
                            }
                            if (isset($check_stock_details->ea_pending) && !empty($check_stock_details->ea_pending) && $check_stock_details->ea_pending > 0) {
                                $ea_pending = $check_stock_details->ea_pending;
                            }
                            if ($ea_total_stock >= $key->EA_qty && $ea_pending >= $key->EA_qty) {
                                $ea_total_stock_val = $ea_total_stock - $key->EA_qty;
                                $ea_pending_val = $ea_pending - $key->EA_qty;
                                $update_minus_stock_arr[] = ['boq_code' => $key->boq_code, 'ea_total_stock' => $ea_total_stock_val, 'ea_pending' => $ea_pending_val];
                                $loguser_id = $this->session->userData('user_id');
                                $delete_arr[] = ['id' => $key->id, 'boq_items_id' => $deleted_boq_items_id, 'display' => 'N', 'deleted_by' => $loguser_id, 'deleted_date' => date('Y-m-d H:i:s')];
                            }
                        }
                    }
                }
            }
        }
        if (isset($update_minus_stock_arr) && !empty($update_minus_stock_arr) && $project_id > 0) {
            $this->updateBOQInstallStock($update_minus_stock_arr, $project_id);
        }
        if (isset($delete_arr) && !empty($delete_arr)) {
            $this->updateMultiData('tbl_boq_exceptional', $delete_arr, 'id');
        }
    }
    public function deleteBOQExceptionalOldItem($delete_boq_arr, $project_id)
    {
        $this->db->where_in('boq_code', $delete_boq_arr);
        $this->db->where('exceptional_id', 0);
        $this->db->where('project_id', $project_id);
        $this->db->where('display', 'Y');
        $this->db->delete('tbl_boq_exceptional');
    }
    public function deleteBOQExceptionalOldItemByExp($delete_boq_arr, $excep_id)
    {
        $this->db->where_in('boq_code', $delete_boq_arr);
        $this->db->where('exceptional_id', $excep_id);
        $this->db->where('display', 'Y');
        $this->db->delete('tbl_boq_exceptional');
    }
    public function deleteBOQDCCOldItemById($delete_boq_arr, $challan_id)
    {
        $this->db->where_in('boq_code', $delete_boq_arr);
        $this->db->where('challan_id', $challan_id);
        $this->db->delete('tbl_deliv_challan_items');
    }
    public function deleteBOQInstalledWIPOldItemById($delete_boq_arr, $update_i_wip_id)
    {
        $this->db->where_in('boq_code', $delete_boq_arr);
        $this->db->where('i_wip_id', $update_i_wip_id);
        $this->db->delete('tbl_install_wip_items');
    }
    public function deleteBOQProvWIPOldItemById($delete_boq_arr, $update_p_wip_id)
    {
        $this->db->where_in('boq_code', $delete_boq_arr);
        $this->db->where('p_wip_id', $update_p_wip_id);
        $this->db->delete('tbl_prov_wip_items');
    }
    public function deleteBOQProformaOldItemById($delete_boq_arr, $proforma_id)
    {
        $this->db->where_in('boq_code', $delete_boq_arr);
        $this->db->where('proforma_id', $proforma_id);
        $this->db->delete('tbl_proforma_invc_items');
    }
    public function deleteBOQVariableDiscountById($variable_discount_tid)
    {
        $this->db->where('variable_discount_tid', $variable_discount_tid);
        $this->db->delete('tbl_variable_discount');
    }

    public function deleteBOQTaxInvOldItemById($delete_boq_arr, $tax_invc_id)
    {
        $this->db->where_in('boq_code', $delete_boq_arr);
        $this->db->where('tax_invc_id', $tax_invc_id);
        $this->db->delete('tbl_tax_invc_items');
    }

    public function get_dcip_boq_item_details($project_id, $boq_code)
    {
        $query = $this->db->query(
            "SELECT tdc.* FROM `tbl_deliv_challan_items` tdc INNER JOIN tbl_boq_items tb ON tb.boq_code = tdc.boq_code
                          WHERE tb.project_id='" .
                $project_id .
                "' AND tb.boq_code='" .
                $boq_code .
                "' ORDER BY tdc.challan_itemid DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            $queryi = $this->db->query(
                "SELECT tdc.* FROM `tbl_install_wip_items` tdc
                              INNER JOIN tbl_installed_wip iwip ON iwip.i_wip_id = tdc.i_wip_id
                              INNER JOIN tbl_boq_items tb ON iwip.project_id = tb.project_id AND tdc.boq_code = tb.boq_code
                              WHERE iwip.project_id='" .
                    $project_id .
                    "' AND tb.boq_code='" .
                    $boq_code .
                    "' ORDER BY tdc.i_wip_itemid DESC LIMIT 0,1"
            );
            if ($queryi->num_rows() > 0) {
                return 0;
            } else {
                $queryi = $this->db->query(
                    "SELECT tdc.* FROM `tbl_prov_wip_items` tdc
                                  INNER JOIN tbl_provisional_wip pwip ON pwip.p_wip_id = tdc.p_wip_id
                                  INNER JOIN tbl_boq_items tb ON pwip.project_id = tb.project_id AND tdc.boq_code = tb.boq_code
                                  WHERE pwip.project_id='" .
                        $project_id .
                        "' AND tb.boq_code='" .
                        $boq_code .
                        "' ORDER BY tdc.p_wip_itemid DESC LIMIT 0,1"
                );
                if ($queryi->num_rows() > 0) {
                    return 0;
                } else {
                    $queryi = $this->db->query(
                        "SELECT tdc.* FROM `tbl_virtual_stock_items` tdc
                                      INNER JOIN tbl_virtual_stock vs ON vs.vs_id = tdc.vs_id
                                      INNER JOIN tbl_boq_items tb ON vs.project_id = tb.project_id AND tdc.boq_code = tb.boq_code
                                      WHERE vs.project_id='" .
                            $project_id .
                            "' AND tb.boq_code='" .
                            $boq_code .
                            "' ORDER BY tdc.vs_itemid DESC LIMIT 0,1"
                    );
                    if ($queryi->num_rows() > 0) {
                        return 0;
                    } else {
                        return $query->row();
                    }
                }
            }
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function getApprovedProjectList()
    {
        $query = $this->db->query("SELECT * FROM `tbl_projects` WHERE display='Y' and status='Y'");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function getApprovedProjectItem($search, $type)
    {
        if ($type == 1) {
            $this->db->select('*');
            $this->db->from('view_latest_boq_items');
            $this->db->where('display', 'Y');
            $this->db->where('project_closure', 'N');
            $this->db->like('item_description', $search);
            $this->db->or_like('bp_code', $search);
            $this->db->or_like('client_boq_sr_no', $search);
            $this->db->or_like('boq_code', $search);
            $query = $this->db->get();
        } elseif ($type == 2) {
            $this->db->select('bomitem.item_description, bomitem.bom_code, p.customer_name, p.bp_code,
                                  bomitem.rate_basic, MAX(boqitem.item_description) as boq_item_description,bomitem.boq_code');
            $this->db->from('tbl_bom_items bomitem');
            $this->db->join('tbl_projects p', 'bomitem.project_id = p.project_id');
            $this->db->join('tbl_boq_items boqitem', 'boqitem.boq_code = bomitem.boq_code and boqitem.project_id = bomitem.project_id', 'left');
            $this->db->where('bomitem.display', 'Y');
            $this->db->where('p.project_closure', 'N');
            $this->db->like('bomitem.item_description', $search);
            $this->db->or_like('p.bp_code', $search);
            $this->db->or_like('bomitem.bom_code', $search);
            $this->db->or_like('bomitem.rate_basic', $search);
            $this->db->group_by('bomitem.item_description, bomitem.bom_code, p.customer_name, p.bp_code, bomitem.rate_basic');
            $query = $this->db->get();
        }
        return $query->result();
    }

    public function getBoqItemsList($project_id)
    {
        $this->db->select('*');
        $this->db->from('view_latest_boq_items');
        if ($project_id != null) {
            $this->db->where('project_id', $project_id);
        }
        $this->db->where('display', 'Y');
        // $this->db->where('status','Y');
        $this->db->order_by('boq_code', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function checkVariableDiscount($boq_code, $project_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_variable_discount');
        if ($project_id != null) {
            $this->db->where('project_id', $project_id);
        }
        $this->db->where('display', 'Y');
        $this->db->where('boq_code', $boq_code);
        // $this->db->where('status','Y');
        $this->db->order_by('boq_code', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function check_permission($submenu_id, $role_id)
    {
        $query = $this->db->query("SELECT * FROM `tbl_priviledges` WHERE display='Y' and submenu_id='" . $submenu_id . "' and role_id = '" . $role_id . "'");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }
    public function updateMultiData($tblname, $data, $column_name)
    {
        $query = $this->db->update_batch($tblname, $data, $column_name);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function getBoqExceptionalType($project_id, $transaction_id)
    {
        $query = $this->db->query("SELECT * FROM `tbl_boq_exceptional` WHERE project_id='" . $project_id . "' AND transaction_id='" . $transaction_id . "' GROUP BY transaction_id,id");
        // print_r($this->db->last->query);
        // exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function getBOMListRows($postData, $project_id)
    {
        $this->_get_bom_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countBOMListFiltered($postData, $projectId)
    {
        $this->_get_bom_list_datatables_query($postData, $projectId);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countBOMListAll()
    {
        $this->db->select('*');
        $this->db->from('view_latest_bom_items');
        $this->db->where('display', 'Y');
        return $this->db->count_all_results();
    }
    private function _get_bom_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('view_latest_bom_items');
        if ($project_id != null) {
            $this->db->where('project_id', $project_id);
        }
        $this->db->where('display', 'Y');
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_bom_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_bom_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_bom_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->bom_order)) {
            $order = $this->bom_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getBOMBOQListRows($postData, $project_id)
    {
        $this->_get_bom_boq_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countBOMBOQListFiltered($postData, $projectId)
    {
        $this->_get_bom_boq_list_datatables_query($postData, $projectId);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countBOMBOQListAll()
    {
        $this->db->select('*');
        $this->db->from('view_bom_boq_latest_items');
        $this->db->where('display', 'Y');
        return $this->db->count_all_results();
    }

    private function _get_bom_boq_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('view_bom_boq_latest_items');
        if ($project_id != null) {
            $this->db->where('project_id', $project_id);
        }
        $this->db->where('display', 'Y');
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_boq_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_boq_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_boq_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->boq_order)) {
            $order = $this->boq_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getBOMBOQReleaseListRows($postData, $project_id)
    {
        $this->_get_bom_boq_release_list_datatables_query($postData, $project_id);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countBOMBOQReleaseListFiltered($postData, $projectId)
    {
        $this->_get_bom_boq_release_list_datatables_query($postData, $projectId);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countBOMBOQReleaseListAll()
    {
        $this->db->select('*');
        $this->db->from('view_bom_boq_latest_release_items');
        $this->db->where('display', 'Y');
        return $this->db->count_all_results();
    }

    private function _get_bom_boq_release_list_datatables_query($postData, $project_id)
    {
        $this->db->select('*');
        $this->db->from('view_bom_boq_latest_release_items');
        if ($project_id != null) {
            $this->db->where('project_id', $project_id);
        }
        $this->db->where('display', 'Y');
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_boq_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_boq_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_boq_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->boq_order)) {
            $order = $this->boq_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getBOMTransactionItemListRows($postData, $project_id, $status_txt)
    {
        $this->_get_bomtrans_list_datatables_query($postData, $project_id, $status_txt);
        if (isset($postData['length'])) {
            if ($postData['length'] != -1) {
                $this->db->limit($postData['length'], $postData['start']);
            }
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countBOMTransactionItemListFiltered($postData, $project_id, $status_txt)
    {
        $this->_get_bomtrans_list_datatables_query($postData, $project_id, $status_txt);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countBOMTransactionItemListAll($project_id, $status_txt)
    {
        //  echo $status_txt;die;
        $this->db->select('*');
        if (isset($status_txt) && !empty($status_txt)) {
            $this->db->from('view_bom_transactions appr');
            $this->db->where("(SELECT IFNULL(COUNT(bom_items_id),0) as cnt FROM tbl_bom_items WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
            $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_bom_release_stock WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_variable_discount WHERE project_id = '".$project_id."' AND variable_discount_tid = appr.variable_discount_id AND display='Y' AND status='pending') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(challan_id),0) as cnt FROM tbl_delivery_challan WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
        } else {
            $this->db->from('view_bom_transactions appr');
            $this->db->where("(SELECT IFNULL(COUNT(boq_items_id),0) as cnt FROM tbl_bom_items WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='Y') > 0");
            $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_bom_release_stock WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='approved') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_boq_exceptional WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='approved') > 0");
            //$this->db->or_where("(SELECT IFNULL(COUNT(challan_id),0) as cnt FROM tbl_delivery_challan WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
        }
        $this->db->where('display', 'Y');
        $this->db->where('project_id', $project_id);
        return $this->db->count_all_results();
    }

    private function _get_bomtrans_list_datatables_query($postData, $project_id, $status_txt)
    {
        $this->db->select('*');
        if (isset($status_txt) && !empty($status_txt)) {
            $this->db->from('view_bom_transactions appr');
            $this->db->where("(SELECT IFNULL(COUNT(bom_items_id),0) as cnt FROM tbl_bom_items WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
        } else {
            $this->db->from('view_bom_transactions appr');
            $this->db->where("(SELECT IFNULL(COUNT(bom_items_id),0) as cnt FROM tbl_bom_items WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='Y') > 0");
        }
        $this->db->where('display', 'Y');
        $this->db->where('project_id', $project_id);

        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_bomtrans_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_bomtrans_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_bomtrans_search[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->bomtrans_order)) {
            $order = $this->bomtrans_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getBOMTransactionOtherItemListRows($postData, $project_id, $status_txt)
    {
        $this->_get_bomtrans_other_list_datatables_query($postData, $project_id, $status_txt);
        if (isset($postData['length'])) {
            if ($postData['length'] != -1) {
                $this->db->limit($postData['length'], $postData['start']);
            }
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countBOMTransactionOtherItemListFiltered($postData, $project_id, $status_txt)
    {
        $this->_get_bomtrans_other_list_datatables_query($postData, $project_id, $status_txt);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countBOMTransactionOtherItemListAll($project_id, $status_txt)
    {
        //  echo $status_txt;die;
        $this->db->select('*');
        if (isset($status_txt) && !empty($status_txt)) {
            $this->db->from('view_bom_transactions_release appr');
            $this->db->where("(SELECT IFNULL(COUNT(bom_release_id),0) as cnt FROM tbl_bom_release_stock WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_bom_release_stock WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_variable_discount WHERE project_id = '".$project_id."' AND variable_discount_tid = appr.variable_discount_id AND display='Y' AND status='pending') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(challan_id),0) as cnt FROM tbl_delivery_challan WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
        } else {
            $this->db->from('view_bom_transactions_release appr');
            $this->db->where("(SELECT IFNULL(COUNT(bom_release_id),0) as cnt FROM tbl_bom_release_stock WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='Y') > 0");
            //$this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_bom_release_stock WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='approved') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_boq_exceptional WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='approved') > 0");
            //$this->db->or_where("(SELECT IFNULL(COUNT(challan_id),0) as cnt FROM tbl_delivery_challan WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
        }
        $this->db->where('display', 'Y');
        $this->db->where('project_id', $project_id);
        return $this->db->count_all_results();
    }

    private function _get_bomtrans_other_list_datatables_query($postData, $project_id, $status_txt)
    {
        $this->db->select('*');
        if (isset($status_txt) && !empty($status_txt)) {
            $this->db->from('view_bom_transactions_release appr');
            $this->db->where("(SELECT IFNULL(COUNT(bom_release_id),0) as cnt FROM tbl_bom_release_stock WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
        } else {
            $this->db->from('view_bom_transactions_release appr');
            $this->db->where("(SELECT IFNULL(COUNT(bom_release_id),0) as cnt FROM tbl_bom_release_stock WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='Y') > 0");
        }
        $this->db->where('display', 'Y');
        $this->db->where('project_id', $project_id);

        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_bomtrans_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_bomtrans_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_bomtrans_search[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->bomtrans_order)) {
            $order = $this->bomtrans_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getViewBOMTransListRows($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->_get_bom_view_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countViewBOMTransListFiltered($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->_get_bom_view_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countViewBOMTransListAll($project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->db->select('*');
        $this->db->from('view_bom_items');
        $this->db->where('project_id', $project_id);
        $this->db->where('boq_code', $boq_code);
        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('status', 'pending');
        } else {
            $this->db->where('status', 'approved');
        }
        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('display', 'Y');
        return $this->db->count_all_results();
    }
    private function _get_bom_view_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->db->select('*');
        $this->db->from('view_bom_items');
        $this->db->where('project_id', $project_id);
        $this->db->where('boq_code', $boq_code);
        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('status', 'pending');
        } else {
            $this->db->where('status', 'approved');
        }
        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('display', 'Y');
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_bom_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_bom_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_bom_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->bom_order)) {
            $order = $this->bom_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getViewBOMTransReleaseQtyListRows($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->_get_bom_view_release_qty_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countViewBOMTransReleaseQtyListFiltered($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->_get_bom_view_release_qty_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countViewBOMTransReleaseQtyListAll($project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->db->select('*');
        $this->db->from('view_bom_item_release');
        $this->db->where('project_id', $project_id);
        $this->db->where('boq_code', $boq_code);
        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('status', 'pending');
        } else {
            $this->db->where('status', 'approved');
        }
        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('display', 'Y');
        return $this->db->count_all_results();
    }
    private function _get_bom_view_release_qty_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->db->select('*');
        $this->db->from('view_bom_item_release');
        $this->db->where('project_id', $project_id);
        $this->db->where('boq_code', $boq_code);
        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('status', 'pending');
        } else {
            $this->db->where('status', 'approved');
        }
        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('display', 'Y');
        $this->db->group_by('bom_code');
        $this->db->group_by('released_quantity');
        $this->db->group_by('bom_items_id');
        $this->db->group_by('schedule_type');
        $this->db->group_by('project_id');
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_bom_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_bom_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_bom_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->bom_order)) {
            $order = $this->bom_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getViewBOMIndentListRows($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->_get_bom_indent_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();

        return $query->result();
    }

    public function countViewBOMIndentListFiltered($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->_get_bom_view_release_qty_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countViewBOMIndentListAll($project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->db->select('*');
        $this->db->from('view_bom_indent');
        $this->db->where('project_id', $project_id);
        // $this->db->where('boq_code',$boq_code);
        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('status', 'pending');
        } else {
            $this->db->where('status', 'approved');
        }
        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('display', 'Y');
        return $this->db->count_all_results();
    }
    private function _get_bom_indent_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->db->select('*');
        $this->db->from('view_bom_indent');
        $this->db->where('project_id', $project_id);
        // $this->db->where('boq_code',$boq_code);
        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('status', 'pending');
        } else {
            $this->db->where('status', 'approved');
        }
        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('display', 'Y');
        // $this->db->group_by('bom_code');
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_bom_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_bom_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_bom_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->bom_order)) {
            $order = $this->bom_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    //     public function getBOMIndentItemListRows($postData,$project_id){
    //         $this->db->select('*');
    // 		$this->db->from('tbl_bom_stock bomstock');
    //         $this->db->join('(SELECT boq_code, bom_code, MAX(bom_items_id) as max_id FROM tbl_bom_items GROUP BY boq_code, bom_code) latest_bom', 'latest_bom.boq_code = bomstock.boq_code AND latest_bom.bom_code = bomstock.bom_code');
    //         $this->db->join('tbl_bom_items bomitem','bomstock.boq_code = bomitem.boq_code AND bomstock.project_id = bomitem.project_id AND bomstock.bom_code = bomitem.bom_code AND latest_bom.max_id = bomitem.bom_items_id');
    //         $this->db->join('tbl_bom_release_stock bomrelesestock','bomstock.boq_code = bomrelesestock.boq_code AND bomstock.project_id = bomrelesestock.project_id AND bomstock.bom_code = bomrelesestock.bom_code');
    //         $this->db->where('bomstock.project_id',$project_id);
    //         $this->db->where('bomrelesestock.status','approved');
    //         $this->db->where('bomstock.indent_stock >',0);
    //         $this->db->group_by('bomrelesestock.bom_code');
    //         $this->db->group_by('bomstock.stock_id');
    //         $query = $this->db->get();
    //         echo $this->db->last_query();die;
    //         return $query->result();
    //     }
    public function getBOMIndentItemListRows($postData, $project_id)
    {
        $this->db->select('
                                bomstock.*,
                                bomitem.*,
                                bomrelesestock.*,
                                latest_bom.max_id
                                ');
        $this->db->from('tbl_bom_stock bomstock');
        $this->db->join(
            '(
                                  SELECT boq_code, bom_code, MAX(bom_items_id) as max_id
                                  FROM tbl_bom_items
                                  GROUP BY boq_code, bom_code
                                  ) latest_bom',
            'latest_bom.boq_code = bomstock.boq_code AND latest_bom.bom_code = bomstock.bom_code'
        );
        $this->db->join('tbl_bom_items bomitem', 'bomstock.boq_code = bomitem.boq_code AND bomstock.project_id = bomitem.project_id AND bomstock.bom_code = bomitem.bom_code AND latest_bom.max_id = bomitem.bom_items_id');
        $this->db->join('tbl_bom_release_stock bomrelesestock', 'bomstock.boq_code = bomrelesestock.boq_code AND bomstock.project_id = bomrelesestock.project_id AND bomstock.bom_code = bomrelesestock.bom_code');
        $this->db->where('bomstock.project_id', $project_id);
        $this->db->where('bomrelesestock.status', 'approved');
        $this->db->where('bomstock.indent_stock >', 0);
        $this->db->group_by('bomstock.boq_code, bomstock.bom_code, bomstock.project_id, bomstock.stock_id, bomitem.bom_items_id, bomrelesestock.bom_release_id, bomrelesestock.status, latest_bom.max_id');
        $query = $this->db->get();
        // echo $this->db->last_query(); die;
        return $query->result();
    }

    public function getBOMIndentEditItemListRows($postData, $project_id, $transaction_id)
    {
        $this->db->select('bomstock.*,bomitem.item_description,bomitem.unit,bomitem.make,bomitem.model');
        $this->db->from('tbl_bom_indent_stock bomstock');
        $this->db->join('(SELECT boq_code, bom_code, MAX(bom_items_id) as max_id FROM tbl_bom_items GROUP BY boq_code, bom_code) latest_bom', 'latest_bom.boq_code = bomstock.boq_code AND latest_bom.bom_code = bomstock.bom_code');
        $this->db->join('tbl_bom_items bomitem', 'bomstock.boq_code = bomitem.boq_code AND bomstock.project_id = bomitem.project_id AND bomstock.bom_code = bomitem.bom_code AND latest_bom.max_id = bomitem.bom_items_id');
        //  $this->db->where('bomstock.indent_stock >',0);
        $this->db->where('bomstock.project_id', $project_id);
        if (!empty($transaction_id)) {
            $this->db->where('bomstock.transaction_id', $transaction_id);
        } else {
            // $this->db->where('bomstock.indent_stock >',0);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function getBOMTransactionOtherSingleItemListRows($postData, $project_id, $status_txt)
    {
        $this->_get_bomtrans_list_single_datatables_query($postData, $project_id, $status_txt);
        if (isset($postData['length'])) {
            if ($postData['length'] != -1) {
                $this->db->limit($postData['length'], $postData['start']);
            }
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function getBOMTransactionOtherSingleItemListFiltered($postData, $project_id, $status_txt)
    {
        $this->_get_bomtrans_list_single_datatables_query($postData, $project_id, $status_txt);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getBOMTransactionOtherSingleItemListAll($project_id, $status_txt)
    {
        //  echo $status_txt;die;
        $this->db->select('*');
        if (isset($status_txt) && !empty($status_txt)) {
            $this->db->from('view_bom_transactions_other appr');
            $this->db->where("(SELECT IFNULL(COUNT(bom_code),0) as cnt FROM tbl_bom_indent_stock WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_boq_exceptional WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_variable_discount WHERE project_id = '".$project_id."' AND variable_discount_tid = appr.variable_discount_id AND display='Y' AND status='pending') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(challan_id),0) as cnt FROM tbl_delivery_challan WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
        } else {
            $this->db->from('view_boq_transactions appr');
            // $this->db->where("(SELECT IFNULL(COUNT(boq_items_id),0) as cnt FROM tbl_boq_items WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='Y') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_variable_discount WHERE project_id = '".$project_id."' AND variable_discount_tid = appr.variable_discount_id AND display='Y' AND status='approved') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_boq_exceptional WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='approved') > 0");
            //$this->db->or_where("(SELECT IFNULL(COUNT(challan_id),0) as cnt FROM tbl_delivery_challan WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
        }
        $this->db->where('display', 'Y');
        $this->db->where('project_id', $project_id);
        return $this->db->count_all_results();
    }
    private function _get_bomtrans_list_single_datatables_query($postData, $project_id, $status_txt)
    {
        $this->db->select('*');
        if (isset($status_txt) && !empty($status_txt)) {
            $this->db->from('view_bom_transactions_other appr');
            $this->db->where("(SELECT IFNULL(COUNT(bom_code),0) as cnt FROM tbl_bom_indent_stock WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
            //     $this->db->where("(SELECT IFNULL(COUNT(boq_items_id),0) as cnt FROM tbl_boq_items WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='N') > 0");
            //     $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_boq_exceptional WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
            //    $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_variable_discount WHERE project_id = '".$project_id."' AND variable_discount_tid = appr.variable_discount_id AND display='Y' AND status='pending') > 0");
            //     $this->db->or_where("(SELECT IFNULL(COUNT(challan_id),0) as cnt FROM tbl_delivery_challan WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
        } else {
            $this->db->from('view_bom_transactions_other appr');
            $this->db->where("(SELECT IFNULL(COUNT(bom_code),0) as cnt FROM tbl_bom_indent_stock WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='approved') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_variable_discount WHERE project_id = '".$project_id."' AND variable_discount_tid = appr.variable_discount_id AND display='Y' AND status='approved') > 0");
            //$this->db->or_where("(SELECT IFNULL(COUNT(id),0) as cnt FROM tbl_boq_exceptional WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='approved') > 0");
            // $this->db->or_where("(SELECT IFNULL(COUNT(challan_id),0) as cnt FROM tbl_delivery_challan WHERE project_id = '".$project_id."' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
        }
        $this->db->where('display', 'Y');
        $this->db->where('project_id', $project_id);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_bomtrans_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_bomtrans_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->bomtrans_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->bomtrans_order)) {
            $order = $this->bomtrans_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getBOMTransactionIndentListRows($postData, $project_id, $type)
    {
        $this->_get_bom_indent_list_datatables_query($postData, $project_id, $type);
        if (isset($postData['length'])) {
            if ($postData['length'] != -1) {
                $this->db->limit($postData['length'], $postData['start']);
            }
        }

        $query = $this->db->get();
        return $query->result();
    }
    public function getBOMTransactionIndentFiltered($postData, $project_id, $type)
    {
        $this->_get_boqexceptn_list_datatables_query($postData, $project_id, $type);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getBOMTransactionIndentListAll($project_id, $type)
    {
        $this->db->select('*');
        $this->db->from('view_indent');
        $this->db->where('display', 'Y');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
            //$this->db->where('status','approved');
        }
        $this->db->where('event_type', $type);

        return $this->db->count_all_results();
    }
    private function _get_bom_indent_list_datatables_query($postData, $project_id, $type)
    {
        $this->db->select('*');
        $this->db->from('view_indent');
        $this->db->where('display', 'Y');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
            //$this->db->where('status','approved');
        }
        $this->db->where('event_type', $type);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_bomtrans_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_bomtrans_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->bomtrans_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->bomtrans_order)) {
            $order = $this->bomtrans_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_bom_boq_pending($project_id, $boq_code)
    {
        $this->db->select('*');
        $this->db->from('tbl_bom_items');
        $this->db->where('display', 'Y');
        $this->db->where('status', 'pending');
        $this->db->where('project_id', $project_id);
        $this->db->where('boq_code', $boq_code);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function get_bom_boq_item_count($project_id, $boq_code)
    {
        $this->db->select('*');
        $this->db->from('tbl_bom_items');
        $this->db->where('display', 'Y');
        $this->db->where('status', 'approved');
        $this->db->where('project_id', $project_id);
        $this->db->where('boq_code', $boq_code);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function boq_exceptional_bom_item($project_id, $boq_code)
    {
        $this->db->select('*');
        $this->db->from('tbl_bom_items');
        $this->db->where('display', 'Y');
        $this->db->where('status', 'approved');
        $this->db->where('project_id', $project_id);
        $this->db->where('boq_code', $boq_code);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function get_bom_item_details($project_id, $bom_code, $boq_items)
    {
        $query = $this->db->query(
            "SELECT * FROM `tbl_bom_items` WHERE project_id='" .
                $project_id .
                "'
                                  AND bom_code='" .
                $bom_code .
                "' AND boq_code ='" .
                $boq_items .
                "' AND display='Y' ORDER BY bom_items_id DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function delete_bom_item($boq_code, $project_id)
    {
        $this->db->where_in('boq_code', $boq_code);
        $this->db->where('project_id', $project_id);
        $this->db->where('display', 'Y');
        $this->db->delete('tbl_bom_items');
    }

    public function get_last_approved_release_qty($project_id, $boq_code, $bom_code)
    {
        $query = $this->db->query(
            "SELECT * FROM `tbl_bom_release_stock` WHERE project_id='" .
                $project_id .
                "' AND boq_code='" .
                $boq_code .
                "' AND bom_code='" .
                $bom_code .
                "'
                                  AND status='approved' AND display='Y' ORDER BY bom_release_id DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function get_boq_release_qty_count($project_id, $boq_code)
    {
        $query = $this->db->query("SELECT SUM(IFNULL(`released_quantity`,0)) as total_released_quantity FROM `tbl_boq_release_stock` WHERE project_id='" . $project_id . "' AND boq_code='" . $boq_code . "' AND status='approved'");
        if ($query->num_rows() > 0) {
            return $query->row()->total_released_quantity;
        } else {
            return 0;
        }
    }

    public function get_boq_oper_list_datatables_query_single($project_id, $type, $boq_code)
    {
        $this->db->select('*');
        $this->db->from('view_latest_boq_items');
        $this->db->where('project_id', $project_id);
        if ($type == 'operable_a') {
            $this->db->where('scheduled_qty = design_qty');
            $this->db->where('non_schedule', 'N');
        } elseif ($type == 'B_pos') {
            $this->db->where('design_qty > scheduled_qty');
            $this->db->where('non_schedule', 'N');
        } elseif ($type == 'B_nav') {
            $this->db->where('design_qty < scheduled_qty');
            $this->db->where('non_schedule', 'N');
        } elseif ($type == 'operable_c') {
            $this->db->where('non_schedule', 'Y');
        }
        $this->db->where('boq_code', $boq_code);
        $this->db->where('display', 'Y');
        $this->db->where('status', 'Y');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

    public function check_schedule_approved($schedule_type, $project_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_bom_release_stock');
        $this->db->where('project_id', $project_id);
        $this->db->where('schedule_type', $schedule_type);
        $this->db->where('display', 'Y');
        $this->db->where('status', 'approved');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

    public function check_release_qty_pending($project_id, $boq_code)
    {
        $query = $this->db->query(
            "SELECT * FROM `tbl_bom_release_stock` WHERE project_id='" .
                $project_id .
                "' AND boq_code='" .
                $boq_code .
                "'
                                  AND display='Y' AND status='pending' AND transaction_id > 0 ORDER BY bom_release_id DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function getBOQReleaseOperListRows($postData, $project_id, $type)
    {
        $this->_get_boq_bom_oper_list_datatables_query($postData, $project_id, $type);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countBOQReleaseOperListFiltered($postData, $project_id, $type)
    {
        $this->_get_boq_bom_oper_list_datatables_query($postData, $project_id, $type);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countBOQReleaseOperListAll($project_id, $type)
    {
        $this->db->select('*');
        $this->db->from('view_latest_boq_items');
        $this->db->where('project_id', $project_id);
        if ($type == 'operable_a') {
            // $this->db->where('scheduled_qty = design_qty');
            $this->db->where('non_schedule', 'N');
        } elseif ($type == 'B_pos') {
            $this->db->where('design_qty > scheduled_qty');
            $this->db->where('non_schedule', 'N');
        } elseif ($type == 'B_nav') {
            $this->db->where('design_qty < scheduled_qty');
            $this->db->where('non_schedule', 'N');
        } elseif ($type == 'operable_c') {
            $this->db->where('non_schedule', 'Y');
        }
        $this->db->where('display', 'Y');
        $this->db->where('status', 'Y');
        return $this->db->count_all_results();
    }

    private function _get_boq_bom_oper_list_datatables_query($postData, $project_id, $type)
    {
        $this->db->select('*');
        $this->db->from('view_latest_boq_items');
        $this->db->where('project_id', $project_id);
        if ($type == 'operable_a') {
            // $this->db->where('scheduled_qty = design_qty');
            $this->db->where('non_schedule', 'N');
        } elseif ($type == 'B_pos') {
            $this->db->where('design_qty > scheduled_qty');
            $this->db->where('non_schedule', 'N');
        } elseif ($type == 'B_nav') {
            $this->db->where('design_qty < scheduled_qty');
            $this->db->where('non_schedule', 'N');
        } elseif ($type == 'operable_c') {
            $this->db->where('non_schedule', 'Y');
        }
        $this->db->where('display', 'Y');
        $this->db->where('status', 'Y');
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_boq_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_boq_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_boq_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->boq_order)) {
            $order = $this->boq_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function check_bom_indent_pending($project_id, $boq_code, $bom_code)
    {
        $this->db->select('*');
        $this->db->from('tbl_bom_indent_stock');
        $this->db->where('project_id', $project_id);
        $this->db->where('boq_code', $boq_code);
        $this->db->where('bom_code', $bom_code);
        $this->db->where('status', 'pending');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

    public function get_latest_approved_bom_item($project_id, $boq_code, $bom_code)
    {
        $query = $this->db->query(
            "SELECT * FROM `tbl_bom_items` WHERE project_id='" .
                $project_id .
                "' AND boq_code='" .
                $boq_code .
                "' AND bom_code='" .
                $bom_code .
                "'
                                  AND status='approved' AND display='Y' ORDER BY bom_items_id DESC LIMIT 0,1"
        );
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
        $this->db->close();
    }

    public function countBOQExceptItemListAllByExceptionalId($project_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_boq_exceptional');
        $this->db->where('display', 'Y');
        // $this->db->where('exceptional_id',0);
        $this->db->where('status', 'pending');
        $this->db->where('project_id', $project_id);
        return $this->db->count_all_results();
    }

    public function check_negative_ea($project_id, $boq_code)
    {
        $this->db->select('*');
        $this->db->from('tbl_boq_exceptional');
        $this->db->where('display', 'Y');
        $this->db->where('except_type', 'negative');
        // $this->db->where('exceptional_id',0);
        // $this->db->where('status','pending');
        $this->db->where('project_id', $project_id);
        $this->db->where('boq_code', $boq_code);
        return $this->db->count_all_results();
    }

    public function getPurchaseListRows($postData, $project_id, $status_txt)
    {
        $this->_get_purchase_list_single_datatables_query($postData, $project_id, $status_txt);
        if (isset($postData['length'])) {
            if ($postData['length'] != -1) {
                $this->db->limit($postData['length'], $postData['start']);
            }
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function getPurchaseListRowsFiltered($postData, $project_id, $status_txt)
    {
        $this->_get_purchase_list_single_datatables_query($postData, $project_id, $status_txt);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getApprovedVendorList($categories)
    {
        $this->db->select('tbl_vendor.*, tbl_category.category_name');
        $this->db->from('tbl_vendor');
        $this->db->join('tbl_category', 'FIND_IN_SET(tbl_category.category_id, tbl_vendor.category_id) > 0');
        $this->db->where('tbl_vendor.display', 'Y');

        $this->db->group_start();
        foreach ($categories as $category) {
            $this->db->or_where("FIND_IN_SET(" . intval($category) . ", tbl_vendor.category_id) >", 0);
        }
        $this->db->group_end();

        $query = $this->db->get();
        return $query->result();
    }

    public function getVendorDetail($vendor_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor');
        $this->db->where('vendor_id ', $vendor_id);
        $this->db->where('display', 'Y');
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllCategory()
    {
        $this->db->select('*');
        $this->db->from('tbl_category');
        $this->db->where('display', 'Y');
        $query = $this->db->get();
        return $query->result();
    }

    // public function getBOMPoItemListRows($postData,$project_id){
    //   $this->db->select('bomstock.*,bomitem.*,SUM(bomindent.indent_quantity) as indent_quantity');
    //   $this->db->from('tbl_bom_stock bomstock');
    //   $this->db->join('(SELECT boq_code, bom_code, MAX(bom_items_id) as max_id FROM tbl_bom_items GROUP BY boq_code, bom_code) latest_bom', 'latest_bom.boq_code = bomstock.boq_code AND latest_bom.bom_code = bomstock.bom_code');
    //   $this->db->join('tbl_bom_items bomitem','bomstock.boq_code = bomitem.boq_code AND bomstock.project_id = bomitem.project_id AND bomstock.bom_code = bomitem.bom_code AND latest_bom.max_id = bomitem.bom_items_id');
    //   $this->db->join('tbl_bom_indent_stock bomindent','bomstock.boq_code = bomindent.boq_code AND bomstock.project_id = bomindent.project_id AND bomstock.bom_code = bomindent.bom_code');
    //   $this->db->where('bomstock.project_id',$project_id);
    //   $this->db->where('bomindent.status','approved');
    //   // $this->db->where('bomstock.indent_stock >',0);
    //   $this->db->group_by(array('bomstock.boq_code', 'bomstock.bom_code', 'bomstock.stock_id','bomitem.bom_items_id'));
    //   $query = $this->db->get();
    //   return $query->result();
    // }

    public function getBOMPoItemListRows($postData, $project_id)
    {
        $this->db->select('bomstock.*,bomitem.*,SUM(bomindent.indent_quantity) as indent_quantity');
        $this->db->from('tbl_bom_stock bomstock');
        $this->db->join('(SELECT boq_code, bom_code, MAX(bom_items_id) as max_id FROM tbl_bom_items GROUP BY boq_code, bom_code) latest_bom', 'latest_bom.boq_code = bomstock.boq_code AND latest_bom.bom_code = bomstock.bom_code');
        $this->db->join('tbl_bom_items bomitem', 'bomstock.boq_code = bomitem.boq_code AND bomstock.project_id = bomitem.project_id AND bomstock.bom_code = bomitem.bom_code AND latest_bom.max_id = bomitem.bom_items_id');
        $this->db->join('tbl_bom_indent_stock bomindent', 'bomstock.boq_code = bomindent.boq_code AND bomstock.project_id = bomindent.project_id AND bomstock.bom_code = bomindent.bom_code');
        $this->db->where('bomstock.project_id', $project_id);
        $this->db->where('bomindent.status', 'approved');
        // $this->db->where('bomstock.indent_stock >',0);
        $this->db->group_by(['bomstock.boq_code', 'bomstock.bom_code', 'bomstock.stock_id', 'bomitem.bom_items_id']);
        $query = $this->db->get();
        return $query->result();
    }
    
     public function get_project_bom_code_description($project_id, $bom_code)
    {
        $this->db->select('bomstock.*'); 
        $this->db->from('tbl_bom_items as bomstock'); 
        $this->db->where('bomstock.project_id', $project_id);
        $this->db->where('bomstock.bom_code', $bom_code);
        $this->db->where('bomstock.status', 'approved');
        $query = $this->db->get();
        return $query->result(); 
    }
    public function getProjectPoData($project_id)
    {
        $this->db->select('po.*,SUM(po.po_quantity) as total_qty');
        $this->db->from('tbl_bom_transactions as bt');
        $this->db->join('tbl_purchase_order as po', 'po.transaction_id = bt.id');
        $this->db->where('bt.event_type', 'purchase_order');
        $this->db->where('bt.display', 'Y');
        $this->db->where('bt.project_id', $project_id);
        $this->db->group_by(['po.bom_code', 'po.id', 'po.transaction_id']);
        $query = $this->db->get();
        return $query->result();
    }
    public function getBOMEditPoItemListRows($project_id = '', $transaction_id = '')
    {
        $this->db->select('po.bom_code,
                                  MAX(po.advance_amount) as advance_amount,
                                  MAX(po.id) AS id, MAX(po.transaction_id) AS transaction_id,, MAX(po.po_number) AS po_number,
                                  MAX(po.project_id) AS project_id,
                                  MAX(po.po_quantity) AS indent_quantity,
                                  MAX(item.rate_basic) AS rate_basic,
                                  MAX(item.gst) AS gst,
                                  MAX(item.item_description) AS item_description,
                                  MAX(item.unit) AS unit,
                                  MAX(po.make) AS make,
                                  MAX(po.basic_rate) AS po_basic_rate,
                                  MAX(po.model) AS model,
                                  MAX(p.bp_code) AS project_name,
                                  MAX(v.name_of_company) AS vendor,
                                  MAX(v.gst_registration_no) AS gst_registration_no,
                                  MAX(CONCAT(v.reg_house_building_no, " ", v.reg_street, " ", v.reg_city_post_code, " ", v.reg_state)) AS address,
                                  MAX(vc.category_name) AS category_name');
        $this->db->from('tbl_bom_transactions as bt');
        $this->db->join('tbl_purchase_order as po', 'po.transaction_id = bt.id');
        $this->db->join('tbl_vendor as v', 'v.vendor_id = po.vendor_id');
        $this->db->join('tbl_category as vc', 'vc.category_id = po.vendor_category');
        $this->db->join('tbl_projects as p', 'p.project_id = po.project_id');
        $this->db->join('tbl_bom_items as item', 'item.project_id = po.project_id AND item.bom_code = po.bom_code');
        $this->db->where('bt.event_type', 'purchase_order');
        $this->db->where('bt.display', 'Y');
        $this->db->where('bt.project_id', $project_id);
        $this->db->where('bt.id', $transaction_id);
        $this->db->group_by('po.bom_code');
        $query = $this->db->get();
        return $query->result();
    }
    public function updatePoItemListRows($update_arr = [])
    {
        $this->db->update_batch('tbl_purchase_order', $update_arr, 'id');
        $affected_row = $this->db->affected_rows();
        return $affected_row;
    }
    public function updatePoTransactionStatus($transaction_id = '')
    {
        $this->db->set('status', 'pending');
        $this->db->where('id', $transaction_id);
        $this->db->update('tbl_bom_transactions');
    }

    public function getBOMTransactionPOListAll($project_id = "")
    {
        $this->db->select('*');
        $this->db->from('view_bom_po');
        $this->db->where('display', 'Y');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
            //$this->db->where('status','approved');
        }
        // $this->db->where('event_type',$type);

        return $this->db->count_all_results();
    }
    public function getBOMTransactionPoListRows($postData, $project_id, $type)
    {
        $this->_get_bom_po_list_datatables_query($postData, $project_id, $type);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function getBOMTransactionPoFiltered($postData, $project_id, $type)
    {
        $this->_get_boqexceptn_list_datatables_query($postData, $project_id, $type);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function _get_bom_po_list_datatables_query($postData, $project_id, $type)
    {
        $this->db->select('*');
        $this->db->from('view_bom_po');
        $this->db->where('display', 'Y');
        if (!empty($project_id)) {
            $this->db->where('project_id', $project_id);
            //$this->db->where('status','approved');
        }
        $this->db->where('event_type', $type);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_bomtrans_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_bomtrans_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->bomtrans_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->bomtrans_order)) {
            $order = $this->bomtrans_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getViewBomPOListRows($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->_get_bom_po_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countViewBomPoListFiltered($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->_get_bom_view_release_qty_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countViewBomPoListAll($project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->db->select('*');
        $this->db->from('view_bom_po');
        $this->db->where('project_id', $project_id);
        // $this->db->where('boq_code',$boq_code);
        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('status', 'pending');
        } else {
            $this->db->where('status', 'approved');
        }
        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('display', 'Y');
        return $this->db->count_all_results();
    }
    public function _get_bom_po_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->db->select(
            'po_number,bom_code,project_id,status,hsn_sac_code,transaction_id,display,item_description,make,model,unit,boq_code,rate_basic,gst,bp_code,is_billing_inter_state,o_design_qty,upload_design_qty,design_qty,created_on,indent_quantity,vendor_id,terms_and_condition, MAX(bom_items_id) AS max_bom_items_id'
        );
        $this->db->from('view_bom_po');
        $this->db->where('project_id', $project_id);

        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('status', 'pending');
        } elseif (isset($status_txt) && !empty($status_txt) && $status_txt == 'reject') {
            $this->db->where('status', 'reject');
        } else {
            $this->db->where('status', 'approved');
        }
        // $this->db->where('transaction_id',$transaction_id);
        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('display', 'Y');
        $this->db->group_by([
            'po_number',
            'bom_code',
            'project_id',
            'status',
            'transaction_id',
            'display',
            'hsn_sac_code',
            'item_description',
            'make',
            'model',
            'unit',
            'boq_code',
            'rate_basic',
            'gst',
            'bp_code',
            'is_billing_inter_state',
            'o_design_qty',
            'upload_design_qty',
            'design_qty',
            'created_on',
            'indent_quantity',
            'vendor_id',
            'terms_and_condition',
        ]);
        $i = 0;
        // loop searchable columns
        if (isset($postData['search']['value'])) {
            foreach ($this->column_bom_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();

                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    // last loop
                    if (count($this->column_bom_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }
    }

    public function getpurchaseOrderInfo($project_id, $transaction_id)
    {
        $this->db->select('po.id as po_id ,po.po_number, po.vendor_id, v.name_of_company, po.transaction_id, SUM(DISTINCT po.po_amount) as total_amount');
        $this->db->from('tbl_purchase_order as po');
        $this->db->join('tbl_vendor as v', 'v.vendor_id = po.vendor_id');
        $this->db->where('po.project_id', $project_id);
        $this->db->where('po.transaction_id', $transaction_id);
        $this->db->where('po.display', 'Y');
        $this->db->group_by(['po.po_number', 'po.vendor_id', 'v.name_of_company', 'po.transaction_id', 'po.id']);
        $this->db->group_by('v.vendor_id');
        $query = $this->db->get();
        return $query->result();
    }
    public function _get_purchase_list_single_datatables_query($postData, $project_id, $status_txt)
    {
        $this->db->select('*');
        if (isset($status_txt) && !empty($status_txt)) {
            $this->db->from('view_bom_transactions_other appr');
            $this->db->where("(SELECT IFNULL(COUNT(bom_code),0) as cnt FROM tbl_purchase_order WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='pending') > 0");
        } else {
            $this->db->from('view_bom_transactions_other appr');
            $this->db->where("(SELECT IFNULL(COUNT(bom_code),0) as cnt FROM tbl_purchase_order WHERE project_id = '" . $project_id . "' AND transaction_id = appr.id AND display='Y' AND status='approved') > 0");
        }
        $this->db->where('display', 'Y');
        $this->db->where('project_id', $project_id);
        // pr($this->db->last_query(),1);
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_bomtrans_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }

                    if (count($this->column_bomtrans_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->bomtrans_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } elseif (isset($this->bomtrans_order)) {
            $order = $this->bomtrans_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    // public function get_bom_item_amount($filter,$transaction_id,$transaction_type,$project_id,$status_txt,$boq_code)
    // {
    //   if(isset($status_txt) && !empty($status_txt)){
    //     $status = 'N';
    //     $status1='pending';
    //   }else{
    //     $status = 'Y';
    //     $status1='approved';
    //   }
    //   $query = '';
    //   if($transaction_type == 'bom_upload' || $transaction_type == 'add_edit_bom'){
    //     $query=$this->db->query("SELECT IFNULL(SUM(`design_qty`),0) as total_odsgnqty,
    //     IFNULL(SUM(`rate_basic`),0) as total_basic_rate,
    //     -- IFNULL(SUM((`rate_basic`*`o_design_qty`)*(`gst`/100)),0) as total_bom_gst_amount
    //     IFNULL(SUM((`rate_basic`*`design_qty`)+((`rate_basic`*`design_qty`)*(`gst`/100))),0) as total_bom_gst_amount

    //     FROM `tbl_bom_items` WHERE display='Y' AND status='".$status1."' AND project_id='".$project_id."' AND transaction_id = '".$transaction_id."'
    //     AND boq_code = '".$boq_code."'
    //     ");
    //   } else if ($transaction_type == 'indent_request') {
    //     $query=$this->db->query("SELECT IFNULL(SUM(bomitem.rate_basic), 0) as total_basic_rate,
    //     IFNULL(SUM((bomitem.rate_basic * tblindstock.indent_quantity) +((rate_basic * tblindstock.indent_quantity) * (bomitem.gst /100))), 0) as total_bom_gst_amount
    //     FROM tbl_bom_indent_stock tblindstock JOIN (SELECT boq_code, bom_code, MAX(bom_items_id) as max_id FROM tbl_bom_items GROUP BY boq_code, bom_code)
    //     latest_bom ON latest_bom.boq_code = tblindstock.boq_code AND latest_bom.bom_code = tblindstock.bom_code JOIN
    //     tbl_bom_items bomitem ON tblindstock.boq_code = bomitem.boq_code AND tblindstock.project_id = bomitem.project_id AND tblindstock.bom_code = bomitem.bom_code
    //     AND latest_bom.max_id = bomitem.bom_items_id WHERE tblindstock.project_id = '".$project_id."' AND tblindstock.transaction_id = '".$transaction_id."'
    //     AND tblindstock.status = '".$status1."'
    //     AND tblindstock.display = 'Y' ORDER BY tblindstock.bom_code ASC");
    //   }else if ($transaction_type == 'purchase_order') {
    //     $query = $this->db->query("
    //     SELECT
    //     IFNULL(SUM(bomitem.rate_basic), 0) AS total_basic_rate,
    //     IFNULL(SUM((bomitem.rate_basic * tblpurchase.po_quantity) + ((rate_basic * tblpurchase.po_quantity) * (bomitem.gst / 100))), 0) AS total_bom_gst_amount
    //     FROM
    //     tbl_purchase_order tblpurchase
    //     JOIN
    //     (SELECT boq_code, bom_code, MAX(bom_items_id) AS max_id
    //     FROM tbl_bom_items
    //     GROUP BY boq_code, bom_code) latest_bom
    //     ON latest_bom.boq_code = tblpurchase.boq_code
    //     AND latest_bom.bom_code = tblpurchase.bom_code
    //     JOIN
    //     tbl_bom_items bomitem
    //     ON tblpurchase.boq_code = bomitem.boq_code
    //     AND tblpurchase.project_id = bomitem.project_id
    //     AND tblpurchase.bom_code = bomitem.bom_code
    //     AND latest_bom.max_id = bomitem.bom_items_id
    //     WHERE
    //     tblpurchase.project_id = '".$project_id."'
    //     AND tblpurchase.transaction_id = '".$transaction_id."'
    //     AND tblpurchase.status = '".$status1."'
    //     AND tblpurchase.display = 'Y'
    //     ORDER BY
    //     tblpurchase.bom_code ASC
    //     ");

    //   }

    //   if($query != ''){
    //     if($query->num_rows()>0){
    //       return $query->row_array();
    //     }else{
    //       return 0;
    //     }
    //   }else{
    //     return 0;
    //   }

    //   $this->db->close();
    // }
    public function get_bom_item_amount($filter, $transaction_id, $transaction_type, $project_id, $status_txt, $boq_code)
    {
        if (isset($status_txt) && !empty($status_txt)) {
            $status = 'N';
            $status1 = 'pending';
        } else {
            $status = 'Y';
            $status1 = 'approved';
        }
        $query = '';
        if ($transaction_type == 'bom_upload' || $transaction_type == 'add_edit_bom') {
            $query = $this->db->query(
                "SELECT IFNULL(SUM(design_qty),0) as total_odsgnqty,
                                    IFNULL(SUM(rate_basic),0) as total_basic_rate,
                                    -- IFNULL(SUM((rate_basico_design_qty)(gst/100)),0) as total_bom_gst_amount
                                    IFNULL(SUM((rate_basic*design_qty)+((rate_basic*design_qty)*(gst/100))),0) as total_bom_gst_amount

                                    FROM tbl_bom_items WHERE display='Y' AND status='" .
                    $status1 .
                    "' AND project_id='" .
                    $project_id .
                    "' AND transaction_id = '" .
                    $transaction_id .
                    "'
                                    AND boq_code = '" .
                    $boq_code .
                    "'
                                    "
            );
        } elseif ($transaction_type == 'indent_request') {
            $query = $this->db->query(
                "SELECT IFNULL(SUM(bomitem.rate_basic), 0) as total_basic_rate,
                                    IFNULL(SUM((bomitem.rate_basic * tblindstock.indent_quantity) +((rate_basic * tblindstock.indent_quantity) * (bomitem.gst /100))), 0) as total_bom_gst_amount
                                    FROM tbl_bom_indent_stock tblindstock JOIN (SELECT boq_code, bom_code, MAX(bom_items_id) as max_id FROM tbl_bom_items GROUP BY boq_code, bom_code)
                                    latest_bom ON latest_bom.boq_code = tblindstock.boq_code AND latest_bom.bom_code = tblindstock.bom_code JOIN
                                    tbl_bom_items bomitem ON tblindstock.boq_code = bomitem.boq_code AND tblindstock.project_id = bomitem.project_id AND tblindstock.bom_code = bomitem.bom_code
                                    AND latest_bom.max_id = bomitem.bom_items_id WHERE tblindstock.project_id = '" .
                    $project_id .
                    "' AND tblindstock.transaction_id = '" .
                    $transaction_id .
                    "'
                                    AND tblindstock.status = '" .
                    $status1 .
                    "'
                                    AND tblindstock.display = 'Y' ORDER BY tblindstock.bom_code ASC"
            );
        } elseif ($transaction_type == 'purchase_order') {
            $query = $this->db->query(
                "
                                    SELECT
                                    IFNULL(SUM(bomitem.rate_basic), 0) AS total_basic_rate,
                                    IFNULL(SUM((bomitem.rate_basic * tblpurchase.po_quantity) + ((rate_basic * tblpurchase.po_quantity) * (bomitem.gst / 100))), 0) AS total_bom_gst_amount
                                    FROM
                                    tbl_purchase_order tblpurchase
                                    JOIN
                                    tbl_bom_items bomitem
                                    ON tblpurchase.boq_code = bomitem.boq_code
                                    AND tblpurchase.project_id = bomitem.project_id
                                    AND tblpurchase.bom_code = bomitem.bom_code

                                    WHERE
                                    tblpurchase.project_id = '" .
                    $project_id .
                    "'
                                    AND tblpurchase.transaction_id = '" .
                    $transaction_id .
                    "'
                                    AND tblpurchase.status = '" .
                    $status1 .
                    "'
                                    AND tblpurchase.display = 'Y'
                                    ORDER BY
                                    tblpurchase.bom_code ASC
                                    "
            );
        } elseif ($transaction_type == 'vendor_proforma_invoice') {
            // $query = $this->db->query();
            $this->db->select(' SUM(DISTINCT i.total_amount) as total_bom_gst_amount');
            $this->db->from('tbl_vendor_performa_invoice as vpi');
            $this->db->join('tbl_vendor_pi_item as i', 'i.proforma_id = vpi.proforma_id');
            $this->db->where('vpi.project_id', $project_id);
            $this->db->where('vpi.transaction_id', $transaction_id);
            $this->db->where('vpi.status', $status1);
            $this->db->where('vpi.display', 'Y');
            $query = $this->db->get();
        } elseif ($transaction_type == 'vendor_delivery_challan') {
            // $query = $this->db->query();
            $this->db->select(' SUM(i.total_amount) as total_bom_gst_amount');
            $this->db->from('tbl_vendor_delivery_challan as vdc');
            $this->db->join('tbl_vendor_dc_item as i', 'i.vdc_id = vdc.vdc_id');
            $this->db->where('vdc.project_id', $project_id);
            $this->db->where('vdc.transaction_id', $transaction_id);
            $this->db->where('vdc.status', $status1);
            $this->db->where('i.status', 'pending');
            $this->db->where('vdc.display', 'Y');
            $query = $this->db->get();
        } elseif ($transaction_type == 'fore_close') {
            // $query = $this->db->query();
            $this->db->select(' SUM(DISTINCT i.total_amount) as total_bom_gst_amount');
            $this->db->from('tbl_fore_close as fc');
            $this->db->join('tbl_fore_close_item as i', 'i.fc_id = fc.fc_id');
            $this->db->where('fc.project_id', $project_id);
            $this->db->where('fc.transaction_id', $transaction_id);
            $this->db->where('fc.status', $status1);
            $this->db->where('fc.display', 'Y');
            $query = $this->db->get();
        }

        if ($query != '') {
            if ($query->num_rows() > 0) {
                return $query->row_array();
            } else {
                return 0;
            }
        } else {
            return 0;
        }

        $this->db->close();
    }

    public function is_billing_inter_state($project_id)
    {
        $this->db->select('is_billing_inter_state');
        $this->db->from('tbl_projects');
        $this->db->where('display', 'Y');
        $this->db->where('project_id', $project_id);
        $query = $this->db->get();
        return $query->result();
    }
    public function getItemDataDetails($project_id = "", $bom_code = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_bom_items');
        $this->db->where('project_id ', $project_id);
        $this->db->where('bom_code', $bom_code);
        $query = $this->db->get();
        return $query->row_array();
    }

    // ______________________________vendor_proforma_invoice ______________________________

    public function getCategoryDetails($category_id = "")
    {
        $this->db->select('*');
        $this->db->from('tbl_category');
        $this->db->where('category_id ', $category_id);
        $this->db->where('display', 'Y');
        $query = $this->db->get();
        return $query->result();
    }

    public function SavePerformaInvoiceTransaction($data = [])
    {
        $this->db->insert('tbl_bom_transactions', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function getProjectItem($project_id = "")
    {
        $this->db->select('*');
        $this->db->from('tbl_bom_items');
        $this->db->where('project_id ', $project_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getPerformaInvoiceCount()
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_performa_invoice');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function SavePerformaInvoiceCount($data = [])
    {
        $this->db->insert('tbl_vendor_performa_invoice', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function SavePerformaInvoiceItem($data = [])
    {
        $this->db->insert_batch('tbl_vendor_pi_item', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function getPerformaInvoicePerviousItem($purchase_no = "")
    {
        $this->db->select('pii.*');
        $this->db->from('tbl_vendor_performa_invoice as p');
        $this->db->join('tbl_vendor_pi_item as pii', 'pii.proforma_id = p.proforma_id');
        $this->db->where('po_number', $purchase_no);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getVendorPerformaInvoiceInfo($project_id, $transaction_id)
    {
        $this->db->select('vpi.proforma_id as proforma_id, vpi.proforma_no, vpi.po_number, vpi.invoice_date, vpi.transaction_id, v.name_of_company, SUM(DISTINCT `i`.`total_amount`) as total_amount');
        $this->db->from('tbl_vendor_performa_invoice as vpi');
        $this->db->join('tbl_vendor_pi_item as i', 'i.proforma_id = vpi.proforma_id');
        $this->db->join('tbl_purchase_order as po', 'po.po_number = vpi.po_number');
        $this->db->join('tbl_vendor as v', 'po.vendor_id = v.vendor_id');
        $this->db->where('vpi.project_id', $project_id);
        $this->db->where('vpi.transaction_id', $transaction_id);
        $this->db->where('vpi.display', 'Y');
        $this->db->group_by('vpi.proforma_id, vpi.proforma_no, vpi.po_number, vpi.invoice_date, vpi.transaction_id, v.name_of_company');
        $query = $this->db->get();
        return $query->result();
    }
    public function getViewBomVendorPIListRows($transaction_id = '')
    {
        $this->db->select('i.*, vpi.proforma_id as proforma_id, vpi.proforma_no, vpi.po_number, vpi.invoice_date, vpi.transaction_id,vpi.terms_and_condition');
        $this->db->from('tbl_vendor_performa_invoice as vpi');
        $this->db->join('tbl_vendor_pi_item as i', 'i.proforma_id = vpi.proforma_id');
        $this->db->where('vpi.display', 'Y');
        $this->db->where('vpi.transaction_id', $transaction_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getVendorId($po_number_str = '')
    {
        $this->db->select('v.*');
        $this->db->from('tbl_purchase_order as po');
        $this->db->join('tbl_vendor as v', 'po.vendor_id =v.vendor_id');
        $this->db->where('v.display', 'Y');
        $this->db->where('po_number', $po_number_str);
        $query = $this->db->get();
        return $query->result();
    }
    public function getBOMEditVendorPiItemListRows($project_id = '', $transaction_id = '')
    {
        $this->db->select('po.bom_code,
                                  MAX(po.id) AS id, MAX(po.transaction_id) AS transaction_id,, MAX(po.po_number) AS po_number,
                                  MAX(po.project_id) AS project_id,
                                  MAX(po.po_quantity) AS indent_quantity,
                                  MAX(item.rate_basic) AS rate_basic,
                                  MAX(item.gst) AS gst,
                                  MAX(item.item_description) AS item_description,
                                  MAX(item.unit) AS unit,
                                  MAX(po.make) AS make,
                                  MAX(po.model) AS model,
                                  MAX(p.bp_code) AS project_name,
                                  MAX(v.name_of_company) AS vendor,
                                  MAX(v.gst_registration_no) AS gst_registration_no,
                                  MAX(CONCAT(v.reg_house_building_no, " ", v.reg_street, " ", v.reg_city_post_code, " ", v.reg_state)) AS address,
                                  MAX(vc.category_name) AS category_name');
        $this->db->from('tbl_bom_transactions as bt');
        $this->db->join('tbl_purchase_order as po', 'po.transaction_id = bt.id');
        $this->db->join('tbl_vendor as v', 'v.vendor_id = po.vendor_id');
        $this->db->join('tbl_category as vc', 'vc.category_id = po.vendor_category');
        $this->db->join('tbl_projects as p', 'p.project_id = po.project_id');
        $this->db->join('tbl_bom_items as item', 'item.project_id = po.project_id AND item.bom_code = po.bom_code');
        $this->db->where('bt.event_type', 'purchase_order');
        $this->db->where('bt.display', 'Y');
        $this->db->where('bt.project_id', $project_id);
        $this->db->where('bt.id', $transaction_id);
        $this->db->group_by('po.bom_code');
        $query = $this->db->get();
        return $query->result();
    }
    public function getBOMTransactionVendorPIListRows($post_data = [], $project_id = '', $status_txt = '')
    {
        $this->db->select('*');
        $this->db->from('view_bom_transactions_other');
        $this->db->where('display', 'Y');
        $this->db->where('project_id', $project_id);
        $this->db->where('status', $status_txt);
        $query = $this->db->get();
        return $query->result();
    }

    public function getPerformaInvoiceData($performa_id = '')
    {
        $this->db->select('pi.*,p.bp_code as project_name');
        $this->db->from('tbl_vendor_performa_invoice as pi');
        $this->db->join('tbl_projects as p', 'p.project_id = pi.project_id');
        $this->db->where('pi.display', 'Y');
        $this->db->where('pi.proforma_id', $performa_id);
        $query = $this->db->get();
        return $query->row();
    }
    public function getPerformaInvoiceItem($proforma_id = "")
    {
        $this->db->select('pii.*');
        $this->db->from('tbl_vendor_performa_invoice as p');
        $this->db->join('tbl_vendor_pi_item as pii', 'pii.proforma_id = p.proforma_id');
        $this->db->where('p.proforma_id', $proforma_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function updatePiItemListRows($update_arr = [])
    {
        $this->db->update_batch('tbl_vendor_pi_item', $update_arr, 'proforma_itemid');
        $affected_row = $this->db->affected_rows();
        return $affected_row == 0 ? 1 : $affected_row;
    }
    public function updatePiRows($performa_id = '', $update_arr = [])
    {
        $this->db->set('status', 'pending');
        $this->db->set('terms_and_condition', $update_arr['edit_terms_and_condition']);
        $this->db->set('remark', $update_arr['edit_remark']);
        $this->db->where('proforma_id', $performa_id);
        $this->db->update('tbl_vendor_performa_invoice');
    }
    public function updatePiTransactionStatus($transaction_id = '')
    {
        $this->db->set('status', 'pending');
        $this->db->where('id', $transaction_id);
        $this->db->update('tbl_bom_transactions');
    }

    public function getViewBomVpiListRows($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->_get_bom_vpi_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countViewBomVPIListFiltered($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->_get_bom_view_release_qty_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function countViewBomVpiListAll($project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->db->select('i.*, vpi.proforma_id as proforma_id, vpi.proforma_no, vpi.po_number, vpi.invoice_date, vpi.transaction_id,vpi.terms_and_condition');
        $this->db->from('tbl_vendor_performa_invoice as vpi');
        $this->db->join('tbl_vendor_pi_item as i', 'i.proforma_id = vpi.proforma_id');

        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('vpi.status', 'pending');
        } else {
            $this->db->where('vpi.status', 'approved');
        }
        $this->db->where('vpi.transaction_id', $transaction_id);
        $this->db->where('vpi.display', 'Y');
        return $this->db->count_all_results();
    }
    public function _get_bom_vpi_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->db->select('i.*,i.rate as rate_basic,i.hsn_code as hsn_sac_code, vpi.proforma_id as proforma_id, vpi.proforma_no, vpi.po_number, vpi.invoice_date, vpi.transaction_id,vpi.terms_and_condition');
        $this->db->from('tbl_vendor_performa_invoice as vpi');
        $this->db->join('tbl_vendor_pi_item as i', 'i.proforma_id = vpi.proforma_id');
        $this->db->where('vpi.project_id', $project_id);
        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('vpi.status', 'pending');
        } elseif (isset($status_txt) && !empty($status_txt) && $status_txt == 'reject') {
            $this->db->where('vpi.status', 'reject');
        } else {
            $this->db->where('vpi.status', 'approved');
        }
        $this->db->where('vpi.transaction_id', $transaction_id);
        $this->db->where('vpi.display', 'Y');
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_bom_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }
                    if (count($this->column_bom_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }
    }

    //  ------------------------------------------------- payment_receipt -------------------------------------------------

    public function save_ppi_payment_receipt_data($input_params = [])
    {
        $this->db->insert('tbl_ppi_payment_receipt', $input_params);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function save_ppi_payment_receipt_deduction_details($input_params = [])
    {
        $this->db->insert_batch(' tbl_ppi_payment_receipt_deductions', $input_params);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function update_ppi_payment_receipt_data($input_params = [], $pr_id)
    {
        $this->db->where('pr_id', $pr_id);
        $this->db->update('tbl_ppi_payment_receipt', $input_params);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }
    public function get_payment_receipt_data($project_id = '', $proforma_no = '')
    {
        $this->db->select('pr.*, p.bp_code as project_name, v.name_of_company as vendor_name, u1.fullname as created_by, u2.fullname as approved_by,vpi.po_number');
        $this->db->from('tbl_ppi_payment_receipt as pr');
        $this->db->join('tbl_projects as p', 'pr.project_id = p.project_id');
        $this->db->join('tbl_vendor as v', 'pr.vendor_id = v.vendor_id');
        $this->db->join('tbl_vendor_performa_invoice as vpi', 'pr.ppi_id = vpi.proforma_id');
        $this->db->join('tbl_user as u1', 'pr.created_by = u1.user_id');
        $this->db->join('tbl_user as u2', 'pr.approved_by = u2.user_id', 'left');
        if ($project_id != "") {
            $this->db->where('pr.project_id', $project_id);
        }
        if ($proforma_no != "") {
            $this->db->where('pr.invoice_number', $proforma_no);
        }
        $this->db->where('pr.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_ppi_pr_data_by_trancation_by($transaction_id = '')
    {
        $this->db->select('pr.*');
        $this->db->from('tbl_ppi_payment_receipt as pr');
        $this->db->where('pr.display', 'Y');
        $this->db->where('pr.transaction_id', $transaction_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_payment_receipt_data_by_id($pr_id = '')
    {
        $this->db->select('pr.*');
        $this->db->from('tbl_ppi_payment_receipt as pr');
        $this->db->where('pr.display', 'Y');
        $this->db->where('pr.pr_id', $pr_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_pr_pending_data($ppi_id = '')
    {
        $this->db->select('pr.*');
        $this->db->from('tbl_ppi_payment_receipt as pr');
        $this->db->join('tbl_bom_transactions as t', 't.id = pr.transaction_id');
        $this->db->where('pr.display', 'Y');
        // $this->db->where('pr.status !=', 'approved');
        // $this->db->where('t.status !=', 'approved');
        $this->db->where('pr.status', 'pending');
        $this->db->where('t.status', 'pending');

        if (!empty($ppi_id)) {
            $this->db->where('pr.ppi_id', $ppi_id);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_payment_receipt_added_data($ppi = '', $pr_id = 0)
    {
        $this->db->select('pr.*');
        $this->db->from('tbl_ppi_payment_receipt as pr');
        $this->db->where('pr.display', 'Y');
        $this->db->where('pr.ppi_id', $ppi);
        if ($pr_id > 0) {
            $this->db->where('pr.pr_id != ', $pr_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_payment_receipt_deduction_data_by_id($pr_id = '')
    {
        $this->db->select('pr.*');
        $this->db->from('tbl_ppi_payment_receipt_deductions as pr');
        $this->db->where('pr.payment_receipt_id ', $pr_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function delete_payment_receipt_deduction_data($pr_id = 0)
    {
        $this->db->where('payment_receipt_id', $pr_id);
        $this->db->delete('tbl_ppi_payment_receipt_deductions');
    }
    public function get_payment_receipt_data_by_id_data($transaction_id = '')
    {
        $this->db->select('pr.*');
        $this->db->from('tbl_ppi_payment_receipt as pr');
        $this->db->where('pr.display', 'Y');
        $this->db->where('pr.transaction_id', $transaction_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    // ------------------------------------------------ vendor_delivery_challan ----------------------------------------------------------
    public function saveVendorDelieryChallan($data = [])
    {
        $this->db->insert('tbl_vendor_delivery_challan', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function saveVendorDelieryChallanItem($data = [])
    {
        $this->db->insert_batch('tbl_vendor_dc_item', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function get_vendor_dc_list_data()
    {
        $this->db->select('vdc.*');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->where('vdc.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_vendor_dc_list_data_by_traansaction_id($transaction_id = 0)
    {
        $this->db->select('vdc.*');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->where('vdc.transaction_id', $transaction_id);
        $this->db->where('vdc.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_vendor_dc_listing_data($po_number = "")
    {
        $this->db->select('vdc.*, p.bp_code, u1.fullname as created_by_name, u2.fullname as approved_by_name');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_projects as p', 'vdc.project_id = p.project_id', 'left');
        $this->db->join('tbl_user as u1', 'u1.user_id = vdc.created_by', 'left');
        $this->db->join('tbl_user as u2', 'u2.user_id = vdc.approved_by', 'left');
        if ($po_number != "" && $po_number != null) {
            $this->db->where('vdc.po_number', $po_number);
        }
        $this->db->where('vdc.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_vendor_dc_amount($vdc_id = '', $transaction_id = '')
    {
        $this->db->select('SUM(vdc.total_amount) as total_amount');
        $this->db->from('tbl_vendor_dc_item as vdc');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.vdc_id', $vdc_id);
        $this->db->where('vdc.transaction_id', $transaction_id);
        $query = $this->db->get();

        return $query->row_array();
    }
   public function get_vendor_dc_amount1($vdc_id = '', $transaction_id = '')
    {
        $this->db->select('vdc.*');
        $this->db->from('tbl_vendor_dc_item as vdc');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.vdc_id', $vdc_id);
        $this->db->where('vdc.transaction_id', $transaction_id);
        $query = $this->db->get();
    
        return $query->result_array(); 
    }


    public function get_vendor_dc_item_added_already($po_number = '')
    {
        $this->db->select('vdci.*,vdc.*');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as vdci', 'vdc.vdc_id = vdci.vdc_id', 'left');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.po_number', $po_number);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_vendor_dc_details_by_po($po_number = '')
    {
        $this->db->select('vdc.*');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.po_number', $po_number);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getDeliveryChallanListRows($post = [], $project_id = 0, $status_txt = '')
    {
        $this->db->select('vdc.*,p.bp_code, u1.fullname as created_by_name, u2.fullname as approved_by_name');
        $this->db->from('tbl_bom_transactions as vdc');
        $this->db->join('tbl_projects as p', 'vdc.project_id = p.project_id', 'left');
        $this->db->join('tbl_user as u1', 'u1.user_id = vdc.created_by', 'left');
        $this->db->join('tbl_user as u2', 'u2.user_id = vdc.approved_by', 'left');
        $this->db->where('vdc.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getViewBomDCListRows($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->_get_bom_DC_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();

        return $query->result();
    }
    public function _get_bom_DC_trans_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->db->select('i.*,i.basic_rate as rate_basic,i.hsn_code as hsn_sac_code, vdc.vdc_id as vdc_id,vdc.type');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as i', 'i.vdc_id = vdc.vdc_id');
        $this->db->where('vdc.project_id', $project_id);
        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('vdc.status', 'pending');
            $this->db->where('i.status', 'pending');
        } else {
            $this->db->group_start();
            $this->db->where('vdc.status', 'approved');
            $this->db->or_where('vdc.status', 'pending');
            $this->db->or_where('vdc.status', 'reject');
            $this->db->group_end();
        }
        $this->db->where('vdc.vdc_id', $transaction_id);
        $this->db->where('i.vdc_id', $transaction_id);

        $this->db->where('vdc.display', 'Y');
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_bom_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }
                    if (count($this->column_bom_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }
    }
    public function countViewBomDCiListAll($project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->db->select('i.*,i.basic_rate as rate_basic,i.hsn_code as hsn_sac_code, vdc.vdc_id as vdc_id');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as i', 'i.vdc_id = vdc.vdc_id');
        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('vdc.status', 'pending');
            $this->db->where('i.status', 'pending');
        } else {
            $this->db->where('vdc.status', 'approved');
        }
        $this->db->where('vdc.vdc_id', $transaction_id);
        $this->db->where('vdc.display', 'Y');
        return $this->db->count_all_results();
    }

    public function get_vendor_dc_row_data($vdc_id = 0)
    {
        $this->db->select('vdc.*');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->where('vdc.vdc_id', $vdc_id);
        $this->db->where('vdc.display', 'Y');
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_vendor_dc_item_added_already_for_update($po_number = '', $vdc_id = '')
    {
        $this->db->select('vdci.*');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as vdci', 'vdc.vdc_id = vdci.vdc_id', 'left');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.po_number', $po_number);
        $this->db->where('vdci.status ', "approved");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_vendor_dc_item_details($vdc_id = '')
    {
        $this->db->select('vdci.*');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as vdci', 'vdc.vdc_id = vdci.vdc_id', 'left');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.vdc_id', $vdc_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function update_delivery_challan_data($input_params = [], $vdc_id)
    {
        $this->db->where('vdc_id', $vdc_id);
        $this->db->update('tbl_vendor_delivery_challan', $input_params);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }
    public function update_delivery_challan_part_data($data = [])
    {
        $query = $this->db->update_batch("tbl_vendor_dc_item", $data, "vdc_item_id");
        $affected_rows = $this->db->affected_rows();
        $affected_rows = $affected_rows == 0 ? 1 : $affected_rows;
        return $affected_rows;
    }
    public function update_delivery_challan_item_data($vdc_id = 0, $input_params = [])
    {
        $this->db->where('vdc_id', $vdc_id);
        $this->db->where('status', "pending");
        $this->db->update('tbl_vendor_dc_item', $input_params);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    public function return_memo_data($po_number = '', $type = "", $project_id = 0)
    {
        $this->db->select('dn.*,SUM(dn.total_amount) as total_amount,p.bp_code');
        $this->db->from('tbl_debit_note_items as dn');
        $this->db->join('tbl_projects as p', 'dn.project_id = p.project_id', 'left');
        // $this->db->where('vdc.display', 'Y');
        $this->db->where('dn.type', $type);
        if (isset($po_number) && !empty($po_number)) {
            $this->db->where('dn.po_number', $po_number);
        }
        if (isset($project_id) && $project_id > 0) {
            $this->db->where('dn.project_id', $project_id);
        }
        $this->db->group_by("dn.vdc_number");

        $query = $this->db->get();
        return $query->result_array();
    }

    public function return_memo_data_by_project_id($project_id = '')
    {
        $this->db->select('vdc.*,vdci.*,p.bp_code');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as vdci', 'vdc.vdc_id = vdci.vdc_id');
        $this->db->join('tbl_projects as p', 'vdc.project_id = p.project_id', 'left');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.status', 'approved');
        $this->db->where('vdci.bad_condition_qty > 0');

        if (isset($project_id) && !empty($project_id)) {
            $this->db->where('vdc.project_id', $project_id);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getViewBomVendorDCListRows($transaction_id = '', $status = "")
    {
        $this->db->select('vdc.*, vdci.*,u1.fullname as created_by_name');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as vdci', 'vdc.vdc_id = vdci.vdc_id');
        $this->db->join('tbl_user as u1', 'u1.user_id = vdc.created_by', 'left');
        $this->db->where('vdc.display', 'Y');
        if ($status != "") {
            $this->db->where('vdci.status', 'pending');
        }
        if (!empty($transaction_id)) {
            $this->db->where('vdc.transaction_id', $transaction_id);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function getVdcInfoByvdcNumber($vdc_number = '')
    {
        $this->db->select('vdc.*');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.vdc_number', $vdc_number);
        $this->db->where('vdc.type !=', "Merged");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_purchase_performa_invoice($ppi_id)
    {
        $this->db->select('i.*, vpi.*');
        $this->db->from('tbl_vendor_performa_invoice as vpi');
        $this->db->join('tbl_vendor_pi_item as i', 'i.proforma_id = vpi.proforma_id');
        $this->db->where('vpi.proforma_id', $ppi_id);
        $this->db->where('vpi.display', 'Y');
        $query = $this->db->get();

        return $query->result();
    }
    public function getPurchaseOrderItem($po_number_str = '')
    {
        $this->db->select('po.*');
        $this->db->from('tbl_purchase_order as po');
        $this->db->where('po.display', 'Y');
        $this->db->where('po.po_number', $po_number_str);
        $query = $this->db->get();
        return $query->result();
    }
    public function getUpdatePurchaseOrderItemAfterBad($update_arr = [])
    {
        $this->db->update_batch('tbl_purchase_order', $update_arr, 'id');
    }
    public function getxya($po_number = '')
    {
        $this->db->select('po.*');
        $this->db->from('tbl_purchase_order as po');
        $this->db->where('po.display', 'Y');
        $this->db->where('po.po_number', $po_number);
        $query = $this->db->get();
        return $query->result();
    }
    public function save_debit_note_item_data($data = [])
    {
        $this->db->insert_batch('tbl_debit_note_items', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function get_dc_details_item_for_debit_note($po_number)
    {
        $this->db->select('vdc.po_number,vdc.vdc_number,i.*');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as i', 'vdc.vdc_id = i.vdc_id AND i.status = "approved"');
        $this->db->where('vdc.po_number', $po_number);
        // $this->db->where("vdc.type","NotMerged");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getViewDebitListRows($postData, $project_id, $transaction_id, $boq_code, $status_txt, $type)
    {
        $this->_get_bom_debit_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt, $type);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();

        return $query->result();
    }
    public function _get_bom_debit_list_datatables_query($postData, $project_id, $transaction_id, $boq_code, $status_txt, $type)
    {
        $this->db->select('dn.*,SUM(dn.bad_condition_qty) as bad_condition_qty,SUM(dn.total_amount) as total_amount');
        $this->db->from('tbl_debit_note_items as dn');
        $this->db->where('dn.project_id', $project_id);
        $this->db->where('dn.vdc_number', $transaction_id);
        $this->db->where('dn.type', $type);
        $this->db->group_by("bom_code");
        $i = 0;
        if (isset($postData['search']['value'])) {
            foreach ($this->column_bom_search as $item) {
                if ($postData['search']['value']) {
                    if ($i === 0) {
                        $this->db->group_start();
                        $this->db->like($item, trim($postData['search']['value']));
                    } else {
                        $this->db->or_like($item, trim($postData['search']['value']));
                    }
                    if (count($this->column_bom_search) - 1 == $i) {
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }
    }
    public function countViewDebitiListAll($project_id, $transaction_id, $boq_code, $status_txt, $type)
    {
        $this->db->select('dn.*');
        $this->db->from('tbl_debit_note_items as dn');
        $this->db->where('dn.project_id', $project_id);
        $this->db->where('dn.vdc_number', $transaction_id);
        $this->db->group_by("dn.bom_code");
        $this->db->where('dn.type', $type);
        return $this->db->count_all_results();
    }

    public function get_debit_note_data_by_vdc_id($vdc_id, $project_id)
    {
        $this->db->select('dn.*');
        $this->db->from('tbl_debit_note_items as dn');
        $this->db->where('dn.vdc_id', $vdc_id);
        $this->db->where('dn.project_id', $project_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    //------------------------------------------------------ Goods Received Notes ------------------------------------------------------

    public function grn_data_by_project_id($project_id = '')
    {
        $this->db->select('vdc.*,vdci.*,p.bp_code');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as vdci', 'vdc.vdc_id = vdci.vdc_id');
        $this->db->join('tbl_projects as p', 'vdc.project_id = p.project_id', 'left');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.status', 'approved');
        $this->db->where('vdci.good_condition_qty > 0');

        if (isset($project_id) && !empty($project_id)) {
            $this->db->where('vdc.project_id', $project_id);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function grn_data($po_number = '')
    {
        $this->db->select('vdc.*,vdci.*,p.bp_code');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as vdci', 'vdc.vdc_id = vdci.vdc_id');
        $this->db->join('tbl_projects as p', 'vdc.project_id = p.project_id', 'left');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.status', 'approved');
        $this->db->where('vdci.good_condition_qty > 0');
        if (isset($po_number) && !empty($po_number)) {
            $this->db->where('vdc.po_number', $po_number);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function check_grn_pending_data($po_number = '')
    {
        $this->db->select('grn.*');
        $this->db->from('tbl_goods_received_notes as grn');
        $this->db->where('grn.po_number', $po_number);
        $this->db->where('grn.status', 'pending');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_vendor_dc_list_data_by_id($vdc_id)
    {
        $this->db->select('i.*');
        $this->db->from('tbl_vendor_dc_item as i');
        $this->db->where('i.display', 'Y');
        if (isset($vdc_id) && !empty($vdc_id)) {
            $this->db->where('i.vdc_id', $vdc_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_merge_vdc_data_by_vdc_id($vdc_id)
    {
        $this->db->select('v.*');
        $this->db->from('tbl_vendor_delivery_challan as v');
        $this->db->where('v.display', 'Y');
        $this->db->where('v.type', 'Merged');
        if (isset($vdc_id) && !empty($vdc_id)) {
            $this->db->where('v.vdc_id', $vdc_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_vdc_type($input_params = [], $vdc_number)
    {
        $vdc_numbers = explode(",", $vdc_number);
        $this->db->where_in('vdc_number', $vdc_numbers);
        $this->db->update('tbl_vendor_delivery_challan', $input_params);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    public function delete_merge_vdc_data($transaction_id)
    {
        $this->db->trans_start();

        $this->db->where('transaction_id', $transaction_id);
        $this->db->delete('tbl_vendor_delivery_challan');

        $this->db->where('transaction_id', $transaction_id);
        $this->db->delete('tbl_vendor_dc_item');

        $this->db->where('id', $transaction_id);
        $this->db->delete('tbl_bom_transactions');

        $this->db->trans_complete();

        // if ($this->db->trans_status() === FALSE) {
        //     return 0;
        // } else {
        //     return $this->db->affected_rows();
        // }
        return 1;
    }

    public function getAdvancePayment($po_number = "")
    {
        $this->db->select('pr.*');
        $this->db->from('tbl_ppi_payment_receipt as pr');
        $this->db->join('tbl_vendor_performa_invoice as pi', 'pi.proforma_no = pr.invoice_number AND pi.display = "Y"');
        $this->db->where('pi.po_number ', $po_number);
        $this->db->where('pr.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_grn_list_data()
    {
        $this->db->select('grn.*');
        $this->db->from('tbl_goods_received_notes as grn');
        $this->db->where('grn.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function save_grn_data($data = [])
    {
        $this->db->insert('tbl_goods_received_notes', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function save_grn_item_data($data = [])
    {
        $this->db->insert_batch('tbl_grn_item', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function save_grn_tax_data($data = [])
    {
        $this->db->insert_batch('tbl_grn_tax_deductions', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function getGrnData($project_id, $transaction_id)
    {
        $this->db->select('grn.grn_id,grn.grn_number,grn.po_number,grn.dc_amount,grn.dc_number,grn.transaction_id,SUM(i.total_amount) as total_amount ,SUM(`i`.`dc_qty`) as total_dc_qty,vdc.type');
        $this->db->from('tbl_goods_received_notes as grn');
        $this->db->join('tbl_grn_item as i', 'i.grn_id = grn.grn_id');
        // $this->db->join('tbl_vendor_delivery_challan as vdc', 'vdc.vdc_number = grn.dc_number');
        $this->db->join('tbl_vendor_delivery_challan as vdc', 'vdc.vdc_number = i.dc_number');
        // $this->db->where('grn.project_id', $project_id);
        $this->db->where('grn.transaction_id', $transaction_id);
        $this->db->where('grn.display', 'Y');
        $this->db->group_by('grn.grn_id,grn.grn_number,grn.po_number,grn.dc_amount, grn.transaction_id,vdc.type,grn.dc_number');
        $query = $this->db->get();
        return $query->result();
    }
    public function getMergeVdcData($project_id)
    {
        $this->db->select('vdc.*');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->where('vdc.project_id', $project_id);
        $this->db->where('vdc.type = "Merged"');
        $this->db->where('vdc.display', 'Y');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_grn_data_by_trancation_by($transaction_id = '')
    {
        $this->db->select('grn.*,SUM(`i`.`total_amount`) as total_amount');
        $this->db->from('tbl_goods_received_notes as grn');
        $this->db->join('tbl_grn_item as i', 'i.grn_id = grn.grn_id');
        $this->db->where('grn.display', 'Y');
        $this->db->where('i.status', 'pending');
        $this->db->where('grn.transaction_id', $transaction_id);
        $this->db->group_by('
        grn.grn_id,
        grn.grn_number,
        grn.po_number,
        grn.dc_amount,
        grn.dc_number,
        grn.transaction_id,
        grn.display
    ');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getViewBomGrnListRows($transaction_id = '', $status = "")
    {
        $this->db->select('grn.*, i.*,u1.fullname as created_by_name,i.status as item_status');
        $this->db->from('tbl_goods_received_notes as grn');
        $this->db->join('tbl_grn_item as i', 'grn.grn_id = i.grn_id');
        $this->db->join('tbl_user as u1', 'u1.user_id = grn.created_by', 'left');
        if ($status != "" && $status != null) {
            $this->db->where('i.status', 'Pending');
        }
        $this->db->where('grn.display', 'Y');

        if (!empty($transaction_id)) {
            $this->db->where('grn.transaction_id', $transaction_id);
        }

        $query = $this->db->get();
        return $query->result();
    }
    public function countViewBomGrnListAll($project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->db->select('i.*, grn.*');
        $this->db->from('tbl_goods_received_notes as grn');
        $this->db->join('tbl_grn_item as i', 'grn.grn_id = i.grn_id');

        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('i.status', 'pending');
        } else {
            $this->db->where('i.status', 'approved');
        }
        $this->db->where('i.transaction_id', $transaction_id);
        $this->db->where('i.display', 'Y');
        return $this->db->count_all_results();
    }

    public function get_grn_data_by_id($grn_id = '')
    {
        $this->db->select('grn.*,p.bp_code as project_name, i.dc_number');
        $this->db->from('tbl_goods_received_notes as grn');
        $this->db->join('tbl_grn_item as i', 'grn.grn_id = i.grn_id');
        $this->db->join('tbl_projects as p', 'p.project_id = grn.project_id');
        $this->db->where('grn.display', 'Y');
        $this->db->where('grn.grn_id', $grn_id);
        $query = $this->db->get();
        return $query->row();
    }
     public function get_grn_tax_data_by_id($grn_id = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_grn_tax_deductions as grn');
        $this->db->where('grn.grn_id', $grn_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_grn_item_data_by_id($grn_id = "", $status = "")
    {
        $this->db->select('i.*');
        $this->db->from('tbl_goods_received_notes as grn');
        $this->db->join('tbl_grn_item as i', 'grn.grn_id = i.grn_id');
        if ($status != "") {
            $this->db->where('i.status ', $status);
        }
        $this->db->where('grn.grn_id', $grn_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_grn_data($input_params = [], $grn_id)
    {
        $this->db->where('grn_id', $grn_id);
        $this->db->update('tbl_goods_received_notes', $input_params);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }
    public function update_grn_item_data($data = [])
    {
        $query = $this->db->update_batch("tbl_grn_item", $data, "grn_item_id");
        $affected_rows = $this->db->affected_rows();
        $affected_rows = $affected_rows == 0 ? 1 : $affected_rows;
        return $affected_rows;
    }

     public function update_grn_tax_data($grn_id = '', $grn_tax_arr = [])
    { 
        if (!empty($grn_id)) {
            $this->db->where('grn_id', $grn_id);
            $this->db->delete('tbl_grn_tax_deductions');
        }
        if (!empty($grn_tax_arr)) {
            $query = $this->db->insert_batch("tbl_grn_tax_deductions", $grn_tax_arr);
            return $this->db->affected_rows();
        }
        return 0;
    }
    public function purchase_list()
    {
        $this->db->distinct();
        $this->db->select('po.po_number');
        $this->db->from('tbl_purchase_order as po');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_dc_details_by_po_number($po_number)
    {
        $this->db->select('vdc.po_number,vdc.vdc_number,i.*,g.grn_id,g.status as grn_status');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as i', 'vdc.vdc_id = i.vdc_id');
        $this->db->join('tbl_goods_received_notes as g', 'g.dc_number = vdc.vdc_number', 'left');
        $this->db->where('vdc.po_number', $po_number);
        $this->db->where("vdc.status", "approved");
        $this->db->where("vdc.type", "NotMerged");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_fc_details_by_po_number($po_number)
    {
        $this->db->select('fc.*,i.*');
        $this->db->from('tbl_fore_close as fc');
        $this->db->join('tbl_fore_close_item as i', 'fc.fc_id = i.fc_id');

        $this->db->where('fc.po_number', $po_number);
        $this->db->where("fc.status", "approved");

        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_vdc_item_details($vdc_ids = [])
    {
        $this->db->select('vi.*,vdc.project_id,vdc.vendor_category_id,vdc.vendor_id,vdc.work_order_on,vdc.vdc_number,vdc.po_number,vdc.po_date');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as vi', 'vdc.vdc_id = vi.vdc_id');
        $this->db->where_in('vdc.vdc_id', $vdc_ids);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function update_merge_vdc_type($update_arr)
    {
        $this->db->update_batch('tbl_vendor_delivery_challan', $update_arr, 'vdc_id');
    }
    public function get_grn_data_by_po($po_number = '')
    {
        $this->db->select('grn.*');
        $this->db->from('tbl_goods_received_notes as grn');
        $this->db->where('grn.display', 'Y');
        $this->db->where('grn.po_number', $po_number);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function update_vdc_grn_status($input_params = [], $vdc_number)
    {
        $this->db->where('vdc_number', $vdc_number);
        $this->db->update('tbl_vendor_delivery_challan', $input_params);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }
    public function updateGRNItemStatusDetails($tblname, $where, $condition, $data)
    {
        $this->db->where("status", "Pending");
        $this->db->where($where, $condition);
        $query = $this->db->update($tblname, $data);
        return $query;
    }

    public function get_grn_all_data_by_vdc($vdc_number = '', $po_number = "", $status = "")
    {
        $this->db->select('i.*');
        $this->db->from('tbl_goods_received_notes as grn');
        $this->db->join('tbl_grn_item as i', 'grn.grn_id = i.grn_id');
        $this->db->where('grn.display', 'Y');
        $this->db->where('grn.dc_number', $vdc_number);
        $this->db->where('grn.po_number', $po_number);
        if ($status != "") {
            $this->db->where('i.status !=', $status);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function getGrnDataByProjectId($project_id = "", $po_number = "")
    {
        $this->db->select('grn.grn_number,i.*');
        $this->db->from('tbl_goods_received_notes as grn');
        $this->db->join('tbl_grn_item as i', 'grn.grn_id = i.grn_id');
        $this->db->where('grn.display', 'Y');
        $this->db->where('grn.project_id', $project_id);

        if ($po_number != "") {
            $this->db->where('grn.po_number', $po_number);
        }
        $query = $this->db->get();
        return $query->result();
    }

    // ------------------------------------------------------ Fore Close ------------------------------------------------------

    public function get_fore_close_item_added_already($po_number = '')
    {
        $this->db->select('fci.*');
        $this->db->from('tbl_fore_close as fc');
        $this->db->join('tbl_fore_close_item as fci', 'fc.fc_id = fci.fc_id', 'left');
        $this->db->where('fc.display', 'Y');
        $this->db->where('fc.po_number', $po_number);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_fore_close_list_data()
    {
        $this->db->select('fc.*');
        $this->db->from('tbl_fore_close as fc');
        $this->db->where('fc.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function saveForeCloseData($data = [])
    {
        $this->db->insert('tbl_fore_close', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function saveForeCloseDataItem($data = [])
    {
        $this->db->insert_batch('tbl_fore_close_item', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function get_fore_close_list_data_by_traansaction_id($transaction_id = 0)
    {
        $this->db->select('fc.*');
        $this->db->from('tbl_fore_close as fc');
        $this->db->where('fc.transaction_id', $transaction_id);
        $this->db->where('fc.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getViewBomForeCloseListRows($transaction_id = '')
    {
        $this->db->select('fc.*, fci.*,u1.fullname as created_by_name');
        $this->db->from('tbl_fore_close as fc');
        $this->db->join('tbl_fore_close_item as fci', 'fc.fc_id = fci.fc_id');
        $this->db->join('tbl_user as u1', 'u1.user_id = fc.created_by', 'left');
        $this->db->where('fc.display', 'Y');

        if (!empty($transaction_id)) {
            $this->db->where('fc.transaction_id', $transaction_id);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function getForeCloseData($project_id, $transaction_id)
    {
        $this->db->select('fc.fc_id,fc.po_number,fc.fore_close_number, fc.transaction_id, v.name_of_company, SUM(DISTINCT `i`.`total_amount`) as total_amount');
        $this->db->from('tbl_fore_close as fc');
        $this->db->join('tbl_fore_close_item as i', 'i.fc_id = fc.fc_id');
        $this->db->join('tbl_purchase_order as po', 'po.po_number = fc.po_number');
        $this->db->join('tbl_vendor as v', 'po.vendor_id = v.vendor_id');
        $this->db->where('fc.project_id', $project_id);
        $this->db->where('fc.transaction_id', $transaction_id);
        $this->db->where('fc.display', 'Y');
        $this->db->group_by('fc.fc_id, fc.po_number, fc.fore_close_number, fc.transaction_id, v.name_of_company');
        $query = $this->db->get();
        return $query->result();
    }
    public function countViewBomForeCloseListAll($project_id, $transaction_id, $boq_code, $status_txt)
    {
        $this->db->select('i.*, fc.*');
        $this->db->from('tbl_fore_close as fc');
        $this->db->join('tbl_fore_close_item as i', 'i.fc_id = fc.fc_id');

        if (isset($status_txt) && !empty($status_txt) && $status_txt == 'pending') {
            $this->db->where('i.status', 'pending');
        } else {
            $this->db->where('i.status', 'approved');
        }
        $this->db->where('i.transaction_id', $transaction_id);
        $this->db->where('i.display', 'Y');
        return $this->db->count_all_results();
    }

    public function get_fore_close_data_by_id($fc_id = '')
    {
        $this->db->select('fc.*,p.bp_code as project_name');
        $this->db->from('tbl_fore_close as fc');
        $this->db->join('tbl_projects as p', 'p.project_id = fc.project_id');
        $this->db->where('fc.display', 'Y');
        $this->db->where('fc.fc_id', $fc_id);
        $query = $this->db->get();
        return $query->row();
    }
    public function get_fore_close_item_data_by_id($fc_id = "")
    {
        $this->db->select('i.*');
        $this->db->from('tbl_fore_close as fc');
        $this->db->join('tbl_fore_close_item as i', 'i.fc_id = fc.fc_id');
        $this->db->where('fc.fc_id', $fc_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_fore_close_data($input_params = [], $fc_id)
    {
        $this->db->where('fc_id', $fc_id);
        $this->db->update('tbl_fore_close', $input_params);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }
    public function update_fore_close_part_data($data = [])
    {
        $query = $this->db->update_batch("tbl_fore_close_item", $data, "fc_item_id");
        $affected_rows = $this->db->affected_rows();
        $affected_rows = $affected_rows == 0 ? 1 : $affected_rows;
        return $affected_rows;
    }
    public function getVDCDetailIfGrnGenerated($vdc_number = "")
    {
        $this->db->select('vdc.*,i.*');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as i', 'i.vdc_id = vdc.vdc_id');
        $this->db->join('tbl_goods_received_notes as grn', 'grn.po_number = vdc.po_number');
        $this->db->where('vdc.vdc_number', $vdc_number);
        //   $this->db->where('vdc.grn_generated', 'Yes');
        $this->db->where('grn.status', 'approved');
        $this->db->where('vdc.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getVDCDetailIfGrnGeneratedByPoNumber($po_number = "")
    {
        $this->db->select('grn.*');
        $this->db->from('tbl_goods_received_notes as grn');
        $this->db->where('grn.po_number', $po_number);
        $this->db->where('grn.status', 'approved');
        $this->db->where('grn.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }
    // public function getVDCDetailIfGrnGeneratedByPoNumber($po_number = "")
    // {
    //   $this->db->select('vdc.*,grn.*');
    //   $this->db->from('tbl_vendor_delivery_challan as vdc');
    //   $this->db->join('tbl_goods_received_notes as grn', 'grn.po_number = vdc.po_number');
    //   $this->db->where('vdc.po_number', $po_number);
    //   $this->db->where('vdc.grn_generated', 'Yes');
    //   $this->db->where('grn.status', 'approved');
    //   $this->db->where('vdc.display', 'Y');
    //   $query = $this->db->get();
    //   return $query->result_array();
    // }

    //-------------------------- PO Details ------------------------------------------

    public function total_po_advance_amount($po_number)
    {
        $this->db->select('SUM(pr.total_amount_with_deduction) AS total_advance');
        $this->db->from('tbl_purchase_order as po');
        $this->db->join('tbl_vendor_performa_invoice as vpi', 'vpi.po_number = po.po_number');
        $this->db->join('tbl_ppi_payment_receipt as pr', 'vpi.proforma_no = pr.invoice_number');
        $this->db->where('po.status', 'approved');
        $this->db->where('po.po_number', $po_number);
        $this->db->where('po.display', 'Y');
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result->total_advance : 0;
    }

    //-------------------------- Head ------------------------------------------

    public function save_head_data($data = [])
    {
        $this->db->insert('tbl_head_master', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function update_head_data($data = [], $head_id)
    {
        $this->db->where('head_id', $head_id);
        $this->db->update('tbl_head_master', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function check_head_data($voucher_type, $head, $head_id = "")
    {
        $this->db->select('h.*');
        $this->db->from('tbl_head_master as h');
        $this->db->where('h.display', 'Y');
        $this->db->where('h.voucher_type', $voucher_type);
        $this->db->where('h.head', $head);

        if (!empty($head_id)) {
            $this->db->where('h.head_id !=', $head_id);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function head_data_list()
    {
        $this->db->select('h.*');
        $this->db->from('tbl_head_master as h');
        $this->db->where('h.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_head_data($head_id)
    {
        if (empty($head_id) || !is_numeric($head_id)) {
            return false;
        }
        $this->db->where('head_id', $head_id);
        $this->db->delete('tbl_head_master');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //-------------------------- Voucher system  ------------------------------------------
    public function save_voucher_data($data = [])
    {
        $this->db->insert('tbl_voucher', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function update_voucher_data($input_params = [], $voucher_id)
    {
        $this->db->where('voucher_id', $voucher_id);
        $this->db->update('tbl_voucher', $input_params);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    public function get_voucher_data($type)
    {
        $this->db->select('v.*,p.bp_code');
        $this->db->from('tbl_voucher as v');
        $this->db->join('tbl_projects as p', 'v.project_id = p.project_id', 'left');
        $this->db->where('v.display', 'Y');
        if ($type != "" && $type == "Project Expense") {
            $this->db->where('v.voucher_type', 'Project Expense');
        }

        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    public function get_voucher_data_type($voucher_id)
    {
        $this->db->select('v.*');
        $this->db->from('tbl_voucher as v');
        $this->db->where('v.display', 'Y');
        $this->db->where('v.voucher_id', $voucher_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_voucher_data_by_id($voucher_id)
    {
        $this->db->select('v.*,v.po_bom_code as v_bom_code,p.bp_code,u.fullname,bp.bom_code');
        $this->db->from('tbl_voucher as v');
        $this->db->join('tbl_projects as p', 'v.project_id = p.project_id', 'left');
        $this->db->join('tbl_user as u', 'u.user_id = v.created_by', 'left');
        $this->db->join('tbl_bom_project_expense as bp', 'bp.bpe_id  = v.bom_code_id', 'left');
        $this->db->where('v.display', 'Y');
        $this->db->where('v.voucher_id', $voucher_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_voucher_data_by_bom_code($bom_code_id,$project_id,$voucher_type="") {
                                $this->db->select('v.*, p.bp_code, u.fullname, bp.bom_code');
                                $this->db->from('tbl_voucher as v');
                                $this->db->join('tbl_projects as p', 'v.project_id = p.project_id', 'left');
                                $this->db->join('tbl_user as u', 'u.user_id = v.created_by', 'left');
                                $this->db->join('tbl_bom_project_expense as bp', 'bp.bpe_id = v.bom_code_id', 'left');
                                $this->db->where('v.display', 'Y');
                                if($voucher_type == "NonTransfer"){
                                  $this->db->where('v.bom_code_id', $bom_code_id);
                                }else if($voucher_type == "Transfer"){
                                  $this->db->where('v.po_bom_code', $bom_code_id);
                                }
                               
                                $this->db->where('v.project_id', $project_id);
                                
                                $query = $this->db->get();
                                return $query->result_array();
                              }

    public function check_unique_voucher_data($head, $project_id, $financial_year)
    {
        $this->db->select('v.*');
        $this->db->from('tbl_voucher as v');
        $this->db->where('v.head', $head);
        $this->db->where('v.display', 'Y');
        if (!empty($project_id) && $project_id > 0 && is_numeric($project_id)) {
            $this->db->where('v.project_id', $project_id);
        }
        if (!empty($financial_year) && isset($financial_year)) {
            $this->db->where('v.financial_year', $financial_year);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_project_expense_head_data()
    {
        $this->db->select('h.*');
        $this->db->from('tbl_head_master as h');
        $this->db->where('h.voucher_type', 'Project Expense');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_bom_project_expense_data()
    {
        $this->db->select('b.*');
        $this->db->from('tbl_bom_project_expense as b');
        $this->db->where('b.display', 'Y');
        $this->db->where('b.status', 'approved');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_pending_bom_voucher_data()
    {
        $this->db->select('v.bom_code_id');
        $this->db->from('tbl_voucher as v');
        $this->db->where('v.status', 'pending');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_bom_code_data($bom_code = '')
    {
        $this->db->select('b.*');
        $this->db->from('tbl_bom_project_expense as b');
        $this->db->where('b.display', 'Y');
        $this->db->where('b.bpe_id', $bom_code);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_po_item_data($bom_code = '', $project_id = "")
    {
        $this->db->select('b.*');
        $this->db->from('tbl_bom_items as b');
        $this->db->where('b.display', 'Y');
        $this->db->where('b.bom_code', $bom_code);
        $this->db->where('b.project_id', $project_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_all_bom_code_data($bom_code_id = 0, $project_id = 0)
    {
        // $this->db->select('SUM(v.amount) as amount');
        $this->db->select('SUM(v.qty) as qty');
        $this->db->from('tbl_voucher as v');
        $this->db->where('v.display', 'Y');
        $this->db->where('v.bom_code_id', $bom_code_id);
        if (isset($project_id) && !empty($project_id)) {
            $this->db->where('v.project_id', $project_id);
        }
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_po_data_by_project_id($project_id = 0, $po_number = '')
    {
        $this->db->select('po.*');
        $this->db->from('tbl_purchase_order as po');
        $this->db->where('po.display', 'Y');
        $this->db->where('po.project_id', $project_id);
        if ($po_number != "" && $po_number != null) {
            $this->db->where('po.po_number', $po_number);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_vdc_data_by_project_id($project_id = 0, $po_number = '')
    {
        $this->db->select('vi.*,vdc.project_id,vdc.vendor_category_id,vdc.vendor_id,vdc.work_order_on,vdc.vdc_number,vdc.po_number,vdc.po_date');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as vi', 'vdc.vdc_id = vi.vdc_id');
        $this->db->where_in('vdc.project_id', $project_id);
        if ($po_number != "" && $po_number != null) {
            $this->db->where('vdc.po_number', $po_number);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_voucher_data_po_wise($project_id = 0, $po_number = '', $po_bom_code = "", $voucher_id = 0)
    {
        $this->db->select('SUM(v.qty) as total_qty');
        $this->db->from('tbl_voucher as v');
        $this->db->where('v.project_id', $project_id);
        $this->db->where('v.po_number', $po_number);
        $this->db->where('v.po_bom_code', $po_bom_code);
        $this->db->where('v.display', 'Y');
        // $this->db->where('v.status != ', 'approved');
        if ($voucher_id > 0) {
            $this->db->where('v.voucher_id != ', $voucher_id);
        }
        $this->db->group_by('v.po_bom_code');

        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_voucher_data_indent_wise($project_id = 0, $po_bom_code = "")
    {
        $this->db->select('SUM(v.qty) as total_qty');
        $this->db->from('tbl_voucher as v');
        $this->db->where('v.project_id', $project_id);
        $this->db->where('v.po_bom_code', $po_bom_code);
        $this->db->where('v.display', 'Y');
        $this->db->where('v.bom_code_type', "common_bom");
        // $this->db->where('v.status != ', 'approved');
        if ($voucher_id > 0) {
            $this->db->where('v.voucher_id != ', $voucher_id);
        }
        $this->db->group_by('v.po_bom_code');

        $query = $this->db->get();
        return $query->row_array();
    }


    public function get_bom_indent_data($project_id = 0)
    {
        
        $this->db->select('*');
        $this->db->from('view_bom_indent');
        $this->db->where('project_id', $project_id);
        $query = $this->db->get();
        return $query->result();

    }

    //-------------------------- Voucher Transaction System  ------------------------------------------

    public function save_voucher_transaction_data($data = [])
    {
        $this->db->insert('tbl_voucher_transaction', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function update_voucher_transaction_data($input_params = [], $transaction_id)
    {
        $this->db->where('transaction_id', $transaction_id);
        $this->db->update('tbl_voucher_transaction', $input_params);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    public function get_voucher_transaction_data()
    {
        $this->db->select('v.*,v.bom_code as v_bom_code,p.bp_code,bp.bom_code');
        $this->db->from('tbl_voucher_transaction as v');
        $this->db->join('tbl_projects as p', 'v.project_id = p.project_id', 'left');
        $this->db->join('tbl_bom_project_expense as bp', 'v.bom_code_id  = bp.bpe_id ', 'left');
        $this->db->where('v.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_voucher_transaction_data_by_id($voucher_id)
    {
        $this->db->select('v.*,p.bp_code,u.fullname');
        $this->db->from('tbl_voucher_transaction as v');
        $this->db->join('tbl_projects as p', 'v.project_id = p.project_id', 'left');
        $this->db->join('tbl_user as u', 'u.user_id = v.created_by', 'left');
        $this->db->where('v.display', 'Y');
        $this->db->where('v.status', 'approved');
        $this->db->where('v.voucher_id', $voucher_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_voucher_head_data($voucher_type, $project_id)
    {
        $this->db->select('v.*');
        $this->db->from('tbl_voucher as v');
        $this->db->where('v.voucher_type', $voucher_type);
        if ($project_id != "" && $project_id > 0 && is_numeric($project_id)) {
            $this->db->where('v.project_id', $project_id);
        }
        $this->db->where('v.display', 'Y');
        $this->db->where('v.status', 'approved');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_bom_codes($project_id)
    {
        $this->db->select('v.*,b.bom_code');
        $this->db->from('tbl_voucher as v');
        if ($project_id != "" && $project_id > 0 && is_numeric($project_id)) {
            $this->db->where('v.project_id', $project_id);
        }
        // if ('v.bom_code_id' > 0 && 'v.bom_code_id' != "") {
        $this->db->join('tbl_bom_project_expense as b', 'b.bpe_id = v.bom_code_id', 'left');
        // }
        $this->db->where('v.display', 'Y');
        $this->db->where('v.status', 'approved');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_office_head_data($voucher_type)
    {
        $this->db->select('h.*');
        $this->db->from('tbl_head_master as h');
        $this->db->where('h.voucher_type', $voucher_type);
        $this->db->where('h.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_approve_transaction_data_by_voucher_id($voucher_id)
    {
        $this->db->select('v.*');
        $this->db->from('tbl_voucher_transaction as v');
        $this->db->where('v.voucher_id', $voucher_id);
        $this->db->where('v.display', 'Y');
        // $this->db->where('v.status', 'approved');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function pending_voucher_transaction_data($head, $project_id)
    {
        $this->db->select('v.*');
        $this->db->from('tbl_voucher_transaction as v');
        $this->db->where('v.head', $head);
        if (!empty($project_id) && is_numeric($project_id) && $project_id > 0) {
            $this->db->where('v.project_id', $project_id);
        }
        $this->db->where('v.display', 'Y');
        $this->db->where('v.status !=', 'approved');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_voucher_transaction_data_by_transaction_id($transaction_id)
    {
        $this->db->select('v.*, v.bom_code as v_bom_code,p.bp_code,u.fullname,bp.bom_code');
        $this->db->from('tbl_voucher_transaction as v');
        $this->db->join('tbl_projects as p', 'v.project_id = p.project_id', 'left');
        $this->db->join('tbl_user as u', 'u.user_id = v.created_by', 'left');
        $this->db->join('tbl_bom_project_expense as bp', 'v.bom_code_id  = bp.bpe_id ', 'left');
        $this->db->where('v.display', 'Y');
        $this->db->where('v.transaction_id', $transaction_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_exist_voucher_data($voucher_id = 0)
    {
        $this->db->select('v.*');
        $this->db->from('tbl_voucher_transaction as v');
        $this->db->where('v.display', 'Y');
        $this->db->where('v.voucher_id', $voucher_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_exist_voucher_transaction_data($bom_code_id = 0, $project_id = 0)
    {
        $this->db->select('v.*');
        $this->db->from('tbl_voucher_transaction as v');
        $this->db->where('v.display', 'Y');
        $this->db->where('v.bom_code_id', ".$bom_code_id.");
        $this->db->where('v.project_id', $project_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    //-------------------------- Stock Movement System  ------------------------------------------

     public function save_stock_movement_data($data = [])
    {
        $this->db->insert('tbl_stock_movement', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function save_stock_movement_item_data($data = [])
    {
        $this->db->insert_batch('tbl_stock_movement_item', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function get_stock_movement_list()
    {
        $this->db->select('sm.*, SUM(i.stock_qty) as qty, p1.bp_code as form_project, p2.bp_code as to_project, u1.fullname as created_by, u2.fullname as approved_by');
        $this->db->from('tbl_stock_movement as sm');
        $this->db->join('tbl_stock_movement_item as i', 'sm.sm_id = i.sm_id', 'left');
        $this->db->join('tbl_projects as p1', 'sm.form_project_id = p1.project_id', 'left');
        $this->db->join('tbl_projects as p2', 'sm.to_project_id = p2.project_id', 'left');
        $this->db->join('tbl_user as u1', 'u1.user_id = sm.created_by', 'left');
        $this->db->join('tbl_user as u2', 'u2.user_id = sm.approved_by', 'left');
        $this->db->where('sm.display', 'Y');
        $this->db->group_by('sm.sm_id, p1.bp_code, p2.bp_code, u1.fullname, u2.fullname');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_stock_movement_data_by_sm_id($sm_id)
    {
        $this->db->select('sm.*, i.*, p1.bp_code as form_project, p2.bp_code as to_project, u1.fullname as created_by, u2.fullname as approved_by');
        $this->db->from('tbl_stock_movement as sm');
        $this->db->join('tbl_stock_movement_item as i', 'sm.sm_id = i.sm_id');
        $this->db->join('tbl_projects as p1', 'sm.form_project_id = p1.project_id', 'left');
        $this->db->join('tbl_projects as p2', 'sm.to_project_id = p2.project_id', 'left');
        $this->db->join('tbl_user as u1', 'u1.user_id = sm.created_by', 'left');
        $this->db->join('tbl_user as u2', 'u2.user_id = sm.approved_by', 'left');
        $this->db->where('sm.display', 'Y');
        $this->db->where('sm.sm_id', $sm_id);
        $query = $this->db->get();
        return $query->result_array();
    }
     public function get_stock_movement_bom_data($to_project_id,$to_bom_code)
    {
        $this->db->select('bi.*');
        $this->db->from('tbl_bom_items as bi');
        $this->db->where('bi.project_id ', $to_project_id);
        $this->db->where('bi.bom_code ', $to_bom_code);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_stock_movement_data($sm_id)
    {
        $this->db->select('sm.*,CONCAT(fp.bp_code,"(",fp.payment_terms,",",fp.customer_name,")") as from_project ,CONCAT(tp.bp_code,"(",tp.payment_terms,",",tp.customer_name,")") as to_project');
        $this->db->from('tbl_stock_movement as sm');
        $this->db->join('tbl_projects as fp', 'fp.project_id = sm.form_project_id', 'left');
        $this->db->join('tbl_projects as tp', 'tp.project_id = sm.to_project_id', 'left');
        $this->db->where('sm.display', 'Y');
        $this->db->where('sm.sm_id', $sm_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function grn_stock_exist($project_id = '',$vdc_number = "")
    {
        $this->db->select('grni.bom_code as bom_code ,SUM(grni.grn_qty) as grn_qty');
        $this->db->from('tbl_goods_received_notes as grn');
        $this->db->join('tbl_grn_item as grni', 'grni.grn_id = grn.grn_id');
        $this->db->where('grn.display', 'Y');
        $this->db->where('grn.project_id', $project_id);
        if($vdc_number != "" && $vdc_number != null){
          $this->db->where('grn.dc_number', $vdc_number);  
        }
        $this->db->group_by('grni.bom_code');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function vdc_stock_exist($project_id = '',$vdc_number = "")
    {
        $this->db->select('vdc.*,vdci.*, p.bp_code');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as vdci', 'vdc.vdc_id = vdci.vdc_id');
        $this->db->join('tbl_projects as p', 'vdc.project_id = p.project_id', 'left');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.status', 'approved');
        $this->db->where('vdc.project_id', $project_id);
        if($vdc_number != "" && $vdc_number != null){
            $this->db->where('vdc.vdc_number', $vdc_number);
        }
        // $this->db->group_by('vdci.bom_code');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function vdc_stock_exist1($project_id = '',$vdc_number = "",$project_bom_item ="",$po_number="")
    {
        $this->db->select('vdc.*,vdci.*, p.bp_code');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as vdci', 'vdc.vdc_id = vdci.vdc_id');
        $this->db->join('tbl_projects as p', 'vdc.project_id = p.project_id', 'left');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.status', 'approved');
        $this->db->where('vdc.project_id', $project_id);
        $this->db->where('vdc.po_number', $po_number);
        $this->db->where('vdci.bom_code', $project_bom_item);
        if($vdc_number != "" && $vdc_number != null){
            $this->db->where('vdc.vdc_number', $vdc_number);
        }
        // $this->db->group_by('vdci.bom_code');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_stock_movement_items($sm_id = '')
    {
        $this->db->select('smi.*,sm.to_bom_code');
        $this->db->from('tbl_stock_movement as sm');
        $this->db->join('tbl_stock_movement_item as smi', 'smi.sm_id = sm.sm_id');
        $this->db->where('smi.display', 'Y');
        $this->db->where('smi.sm_id', $sm_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_stock_movemnt_stock_data($project_id = '', $sm_id = 0,$vdc_number ="")
    {
        $this->db->select('smi.*,SUM(smi.stock_qty) as qty_val');
        $this->db->from('tbl_stock_movement as sm');
        $this->db->join('tbl_stock_movement_item as smi', 'smi.sm_id = sm.sm_id');
        $this->db->where('smi.display', 'Y');
        $this->db->where('sm.form_project_id', $project_id);
        $this->db->where('sm.status != ', "approved");
        if ($sm_id > 0) {
            $this->db->where('sm.sm_id != ', $sm_id);
        }
        if ($vdc_number != "" && $vdc_number != null) {
            // pr($vdc_number,1);
            $this->db->where('sm.vdc_number ', $vdc_number);
        }
        $this->db->group_by('smi.bom_code');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function updateStockMovementItems($data, $stock_movement_id = 0)
    {
        $this->db->where('sm_id', $stock_movement_id);
        $this->db->update_batch('tbl_stock_movement_item', $data, 'sm_item_id');
        $affected_row = $this->db->affected_rows();
        return $affected_row > 0 ? $affected_row : 1;
    }


    //new 
    public function get_po_list_by_project_id($project_id = 0)
    {
        $this->db->select('po.*');
        $this->db->from('tbl_purchase_order as po');
        $this->db->where('po.display', 'Y');
        $this->db->where('po.status', 'approved');
        $this->db->where('po.project_id', $project_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function vdc_list_by_po_number($project_id = '',$po_number = '')
    {
        $this->db->select('vdc.*');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.status', 'approved');
        $this->db->where('vdc.project_id', $project_id);
        $this->db->where('vdc.po_number', $po_number);
        $query = $this->db->get();
        return $query->result_array();
    }
    
     public function bom_data_by_po_number($project_id = '',$po_number = '')
    {
        $this->db->select('vdci.*,p.bp_code');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as vdci', 'vdc.vdc_id = vdci.vdc_id');
        $this->db->join('tbl_projects as p', 'vdc.project_id = p.project_id', 'left');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.status', 'approved');
        $this->db->where('vdc.project_id', $project_id);
        $this->db->where('vdc.po_number', $po_number);
        $query = $this->db->get();
        return $query->result_array();
    }

    // ----------------------------------------- Reports -----------------------------------------
    // ----------------------------------------- Stock Reports -----------------------------------------
    public function stock_report()
    {
        $this->db->select('vdc.*,vdci.*,p.bp_code');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as vdci', 'vdc.vdc_id = vdci.vdc_id');
        $this->db->join('tbl_projects as p', 'vdc.project_id = p.project_id', 'left');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.status', 'approved');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function stock_list_by_project_id($project_id = '')
    {
        $this->db->select('vdc.*,vdci.*,p.bp_code');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as vdci', 'vdc.vdc_id = vdci.vdc_id');
        $this->db->join('tbl_projects as p', 'vdc.project_id = p.project_id', 'left');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.status', 'approved');
        $this->db->where('vdc.project_id', $project_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    // ---------------------------------- BOM Project Expense ----------------------------------

    public function bom_project_expense_list()
    {
        $this->db->select('bpe.*');
        $this->db->from('tbl_bom_project_expense as bpe');
        $this->db->where('bpe.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function save_bom_project_expense($data = [])
    {
        $this->db->insert('tbl_bom_project_expense', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function save_bom_project_expense_batch($data = array()) {
                                $this->db->insert_batch('tbl_voucher', $data);
                                $insert_id = $this->db->insert_id();
                                return  $insert_id;
                              }
    public function update_bom_project_expense($data = [], $bpe_id)
    {
        $this->db->where('bpe_id', $bpe_id);
        $this->db->update('tbl_bom_project_expense', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function check_bom_project_expense($bom_code, $bpe_id = "")
    {
        $this->db->select('bpe.*');
        $this->db->from('tbl_bom_project_expense as bpe');
        $this->db->where('bpe.display', 'Y');
        $this->db->where('bpe.bom_code', $bom_code);
        if (!empty($bpe_id)) {
            $this->db->where('bpe.bpe_id !=', $bpe_id);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function project_expense_list()
    {
        $this->db->select('v.*');
        $this->db->from('tbl_voucher as v');
        $this->db->where('bpe.display', 'Y');
        $this->db->where('bpe.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }
    // --------------------------------------------------- Write Off Back ---------------------------------------------------
    public function get_write_off_back_list($start, $length, $searchValue, $orderColumn, $orderDirection)
    {
        $columns = ['id', 'vendor_name', 'type', 'payment_clear', 'return_amount', 'date', 'approval'];

        $this->db->select('*')->from('tbl_write_off_back');

        // Apply search filter
        if (!empty($searchValue)) {
            $this->db
                ->group_start()
                ->like('vendor_name', $searchValue)
                ->or_like('type', $searchValue)
                ->or_like('payment_clear', $searchValue)
                ->or_like('return_amount', $searchValue)
                ->or_like('date', $searchValue)
                ->group_end();
        }

        // Get total filtered records
        $filteredQuery = clone $this->db;
        $totalFiltered = $filteredQuery->count_all_results();

        // Apply ordering and pagination
        if (isset($columns[$orderColumn])) {
            $this->db->order_by($columns[$orderColumn], $orderDirection);
        }
        $this->db->limit($length, $start);

        // Execute the query
        $query = $this->db->get();
        $totalRecords = $this->db->count_all('tbl_write_off_back');

        return [
            'data' => $query->result_array(),
            'totalRecords' => $totalRecords,
            'totalFiltered' => $totalFiltered,
        ];
    }

    public function save_write_off_back_data($data = [])
    {
        $this->db->insert('tbl_write_off_back', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    public function get_approve_user_role($role_id = [])
    {
        $this->db->select('ro.*');
        $this->db->from('tbl_role as ro');
        $this->db->where_in('ro.role_id',$role_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_wright_off_back($wright_off_back_id = [])
    {
        $this->db->select('wob.*');
        $this->db->from('tbl_write_off_back as wob');
        $this->db->where_in('wob.id',$wright_off_back_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
     //------------------------------ Payout ---------------------------------------------------


    public function get_all_grn_data_by_po($po_number = '')
    {
        $this->db->select('grn.*,SUM(`i`.`total_amount`) as total_amount');
        $this->db->from('tbl_goods_received_notes as grn');
        $this->db->join('tbl_grn_item as i', 'grn.grn_id = i.grn_id');
        $this->db->where('grn.display', 'Y');
        $this->db->where('grn.po_number', $po_number);
        $this->db->group_by('
        grn.grn_id,
        grn.grn_number,
        grn.po_number,
        grn.dc_amount,
        grn.dc_number,
        grn.transaction_id,
        grn.display
    ');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_payout_list_data()
    {
        $this->db->select('p.*');
        $this->db->from('tbl_payout as p');
        $this->db->where('p.display', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }
   
    public function savePayoutData($data = [])
    {
        $this->db->insert('tbl_payout', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function savePayoutDataItem($data = [])
    {
        $this->db->insert_batch('tbl_payout_item', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }



    public function updatePayoutData($input_params = [], $payout_id)
{
    $loguser_id = $this->session->userData('user_id');
    $current_datetime = date("Y-m-d H:i:s");
    
    $input_params['updated_by'] = $loguser_id;
    $input_params['updated_on'] = $current_datetime;

    $this->db->where('payout_id', $payout_id);
    $this->db->update('tbl_payout', $input_params);
    $affected_rows = $this->db->affected_rows();
    
    return $affected_rows;
}

public function updatePayoutDataItem($data = [])
{

    $loguser_id = $this->session->userData('user_id');
    $current_datetime = date("Y-m-d H:i:s");
    
    foreach ($data as &$item) {
        $item['updated_by'] = $loguser_id;
        $item['updated_on'] = $current_datetime;
    }
    // pr($data,1);
    // $query = $this->db->update_batch("tbl_payout_item", $data, "pi_id");
    $query = $this->db->update_batch("tbl_payout_item", $data, "grn_number");

    $affected_rows = $this->db->affected_rows();
    
    $affected_rows = $affected_rows == 0 ? 1 : $affected_rows;
    
    return $affected_rows;
}


    public function get_payout_list()
    {
        $this->db->select('po.*, i.*, pr.bp_code')
                 ->from('tbl_payout as po')
                 ->join('tbl_payout_item as i', 'po.payout_id = i.payout_id') 
                 ->join('tbl_projects as pr', 'po.project_id = pr.project_id', 'left'); 
    
        $query = $this->db->get();
        return $query->result_array();
    }
   

    
    // public function get_payout_data_by_id($payout_id ='')
    // {
    //     $this->db->select('po.*, i.*, pr.bp_code')
    //              ->from('tbl_payout as po')
    //              ->join('tbl_payout_item as i', 'po.payout_id = i.payout_id') 
    //              ->join('tbl_projects as pr', 'po.project_id = pr.project_id', 'left');
    //              if($payout_id !=""){
    //                 $this->db->where('po.payout_id', $payout_id); 
    //              }
                
    
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

 public function get_payout_data_by_id($payout_id ='')
    {
        $this->db->select('po.*,po.advance_amount as advance_payment, i.*, pr.bp_code')
                 ->from('tbl_payout as po')
                 ->join('tbl_payout_item as i', 'po.payout_id = i.payout_id') 
                 ->join('tbl_projects as pr', 'po.project_id = pr.project_id', 'left');
                 if($payout_id !=""){
                    $this->db->where('po.payout_id', $payout_id); 
                 }
                
    
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_payout_data_by_po($po_number ='')
    {
        $this->db->select('po.*, i.*, pr.bp_code')
                 ->from('tbl_payout as po')
                 ->join('tbl_payout_item as i', 'po.payout_id = i.payout_id') 
                 ->join('tbl_projects as pr', 'po.project_id = pr.project_id', 'left');
                 if($po_number !=""){
                    $this->db->where('po.po_number', $po_number); 
                 }
                
    
        $query = $this->db->get();
        return $query->result_array();
    }
    
        public function get_stock_movement_list_by_project_id($project_id)
    {
        $this->db->select('sm.*, SUM(i.stock_qty) as qty, p1.bp_code as form_project, p2.bp_code as to_project, u1.fullname as created_by, u2.fullname as approved_by');
        $this->db->from('tbl_stock_movement as sm');
        $this->db->join('tbl_stock_movement_item as i', 'sm.sm_id = i.sm_id', 'left');
        $this->db->join('tbl_projects as p1', 'sm.form_project_id = p1.project_id', 'left');
        $this->db->join('tbl_projects as p2', 'sm.to_project_id = p2.project_id', 'left');
        $this->db->join('tbl_user as u1', 'u1.user_id = sm.created_by', 'left');
        $this->db->join('tbl_user as u2', 'u2.user_id = sm.approved_by', 'left');
        $this->db->where('sm.display', 'Y');
        $this->db->where('p1.project_id', $project_id);
        $this->db->group_by('sm.sm_id, p1.bp_code, p2.bp_code, u1.fullname, u2.fullname');
        $query = $this->db->get();
        return $query->result_array();
    }

    
    public function get_stock_movement_list_by_to_project_id($form_project_id = 0,$to_project_id = 0)
    {
        $this->db->select('sm.*, SUM(i.stock_qty) as qty, p1.bp_code as form_project, p2.bp_code as to_project, u1.fullname as created_by, u2.fullname as approved_by');
        $this->db->from('tbl_stock_movement as sm');
        $this->db->join('tbl_stock_movement_item as i', 'sm.sm_id = i.sm_id', 'left');
        $this->db->join('tbl_projects as p1', 'sm.form_project_id = p1.project_id', 'left');
        $this->db->join('tbl_projects as p2', 'sm.to_project_id = p2.project_id', 'left');
        $this->db->join('tbl_user as u1', 'u1.user_id = sm.created_by', 'left');
        $this->db->join('tbl_user as u2', 'u2.user_id = sm.approved_by', 'left');
        $this->db->where('sm.display', 'Y');
        $this->db->where('p1.project_id', $form_project_id);
        $this->db->where('p2.project_id', $to_project_id);
        $this->db->group_by('sm.sm_id, p1.bp_code, p2.bp_code, u1.fullname, u2.fullname');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_vendor_dc_item_by_code($po_number = '',$vdc_codes = [])
    {
        $this->db->select('vdci.*,vdc.*');
        $this->db->from('tbl_vendor_delivery_challan as vdc');
        $this->db->join('tbl_vendor_dc_item as vdci', 'vdc.vdc_id = vdci.vdc_id', 'left');
        $this->db->where('vdc.display', 'Y');
        $this->db->where('vdc.po_number', $po_number);
        $this->db->where_in('vdc.vdc_number', $vdc_codes);
        $query = $this->db->get();
        return $query->result_array();
    }
    //new
     public function get_payout_selection_list()
    {
        $this->db->select('po.*, i.*, pr.bp_code')
                 ->from('tbl_payout as po')
                 ->join('tbl_payout_item as i', 'po.payout_id = i.payout_id') 
                 ->join('tbl_projects as pr', 'po.project_id = pr.project_id', 'left'); 
                 $this->db->where('po.status', 'Approved'); 
        $query = $this->db->get();
        return $query->result_array();
    }
    
        // ---------------- Payout Chnages --------------------------------------

     public function save_payout_selection_data($data = [])
    {
        $this->db->insert_batch('tbl_payout_selection', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function update_payout_selection_data($data = [], $id) {
        if (!is_array($data) || empty($data) || empty($id)) {
            return false; // Ensure data is a non-empty associative array and ID is valid
        }
    
        $this->db->where('id', $id);
        $this->db->update('tbl_payout_selection', $data);
    
        if ($this->db->affected_rows() >= 0) { 
            return true; // Query ran successfully, even if no rows were changed
        } else {
            return false;
        }
    }
    


//     public function get_payout_selection_data_list()
// {
//     $this->db->select('ps.*,ps.status as ps_status, p.*, pi.*,pr.bp_code');
//     $this->db->from('tbl_payout_selection as ps');
//     $this->db->join('tbl_payout as p', 'FIND_IN_SET(p.payout_id, ps.payout_ids)'); 
//     $this->db->join('tbl_payout_item as pi', 'pi.payout_id = p.payout_id');
//     $this->db->join('tbl_projects as pr', 'p.project_id = pr.project_id', 'left');;
//     $this->db->where('p.status', 'Approved');
    
//     $query = $this->db->get();
//     return $query->result_array();
// }

public function get_payout_selection_data_list() {
    $this->db->select('ps.*, ps.status as ps_status, p.*, pi.*, pr.bp_code');
    $this->db->from('tbl_payout_selection as ps');
    $this->db->join('tbl_payout as p', 'p.payout_id = ps.payout_ids', 'left'); 
    $this->db->join('tbl_payout_item as pi', 'pi.payout_id = ps.payout_ids', 'left');
    $this->db->join('tbl_projects as pr', 'p.project_id = pr.project_id', 'left');
    $this->db->where('p.status', 'Approved');
    
    $query = $this->db->get();
    return $query->result_array();
}
public function get_payout_selection_data_excel($payout_id ='') {
    $this->db->select('ps.*, ps.status as ps_status, p.*, pi.*, pr.bp_code');
    $this->db->from('tbl_payout_selection as ps');
    $this->db->join('tbl_payout as p', 'p.payout_id = ps.payout_ids', 'left'); 
    $this->db->join('tbl_payout_item as pi', 'pi.payout_id = ps.payout_ids', 'left');
    $this->db->join('tbl_projects as pr', 'p.project_id = pr.project_id', 'left');
    $this->db->where('p.status', 'Approved');
    $this->db->where('ps.id', $payout_id);
    
    $query = $this->db->get();
    return $query->result_array();
}

public function get_vendor_info($po_number) {
    $this->db->select('v.*'); 
    $this->db->from('tbl_purchase_order as po');
    $this->db->join('tbl_vendor as v', 'v.vendor_id = po.vendor_id', 'left');
    $this->db->where('po.po_number', $po_number);
    $this->db->where('po.status', 'Approved');

    $query = $this->db->get();
    return $query->result_array(); 
}



public function get_bank_payment_data() {
    $this->db->select('ps.*');
    $this->db->from('tbl_payout_selection as ps');
    $query = $this->db->get();
    return $query->result_array();
}

 public function get_payout_advance_amount_data_by_po($po_number ='')
    {
        $this->db->select('i.*')
                 ->from('tbl_payout as po')
                 ->join('tbl_payout_item as i', 'po.payout_id = i.payout_id') 
                 ->join('tbl_projects as pr', 'po.project_id = pr.project_id', 'left');
                 if($po_number !=""){
                    $this->db->where('po.po_number', $po_number); 
                 }
                
    
        $query = $this->db->get();
        return $query->result_array();
    }



 public function get_payment_receipt_bank_credit_data($tax_invc_id = '')
{
    $this->db->select('p.*');
    $this->db->from('tbl_payment_receipt as p');
    if (!empty($tax_invc_id)) {
        $this->db->where('p.tax_incv_id', $tax_invc_id);
    }

    $query = $this->db->get();
    return $query->result_array();
}


public function get_pending_payout_data($po_number = "") {
    $this->db->select('po.*');
    $this->db->from('tbl_payout as po');
    $this->db->where('po.po_number', $po_number);
    $this->db->where('po.status', 'Pending');
    $query = $this->db->get();
    return $query->result_array();
}



}
?>
