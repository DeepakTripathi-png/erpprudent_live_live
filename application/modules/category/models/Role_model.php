<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model 

{
    public function menu_list($role_id) 
    {

        $query=$this->db->query("SELECT * FROM tbl_menu where display='Y'"); 
        if($query->num_rows()>0) 
        {
            $data=array(); 
            foreach($query->result() as $key) 
            {
                $array_data['menu']=$key; 
                $menu_id=$key->menu_id; 
                $subquery=$this->db->query("SELECT s.*,if(isnull(p.role_id),'N','Y') prev FROM tbl_submenu s left join tbl_priviledges p on p.role_id=? 
                and p.submenu_id=s.submenu_id where s.menu_id=? and s.display='Y' and 
                s.action NOT IN ('create-project','update_create_project','approved_project_details','publish_boq_items_bulk_upload',
                'save_boq_exceptional_approval','edit_boq_exceptional_approval','add-role','edit_role','delete_role','add-user','edit_user',
                'delete_user','delete_project_details','save_boq_item_details','approve_boq_exceptional_approval','save_client_dc_details',
                'edit_delivery_challan','approved_delivery_challan','save_installed_wip_details','edit_installed_wip','approved_installed_wip','save_provisional_wip_details',
                'edit_provisional_wip','approved_provisional_wip','save_proforma_invoice_details','edit_proforma_invoice','approved_proforma_invoice','save_tax_invoice_details',
                'edit_tax_invoice','approved_tax_invoice','Add_View_Compliance','convert_to_tax_invoice','view_payment_receipt','save_payment_advice','edit_payment_advice',
                'approved_payment_advice','view_invoice_closure','save_invoice_closure','edit_invoice_closure','approved_invoice_closure',
                'view_project_closure','save_project_closure','edit_project_closure','approved_project_closure','approved_boq_details','delete_boq_details',
                'approve_boq_variable_discount','save_boq_variable_discount','edit_boq_variable_discount_approval','approved_bom_details','edit_bom_items',
                'edit_bom_item_approval','approved_bom_release_stock','edit_bom_release_stock','approved_indent_stock','save_indent_request','edit_indent_request') 
                having prev='Y' ORDER BY s.submenu_id ASC",array($role_id,$menu_id)); 
                if($subquery->num_rows()>0) 
                {
                    $array_data['submenu']=$subquery->result(); 
                    $data[]=$array_data; 
                }
            } 
        } else {
            return null; 
        } 
        return $data; 
    }

    public function menu_list1($role_id) 

    {
        $query=$this->db->query("SELECT * FROM tbl_menu where display='Y'"); 
        if($query->num_rows()>0) 
        {
            $data=array(); 
            foreach($query->result() as $key) 
            {
                $array_data['menu']=$key; 
                $menu_id=$key->menu_id; 
                $subquery=$this->db->query("SELECT s.*,if(isnull(p.role_id),'N','Y') prev FROM tbl_submenu s left join tbl_priviledges p on p.role_id=? and p.submenu_id=s.submenu_id where s.menu_id=? and s.display='Y'",array($role_id,$menu_id)); 
                if($subquery->num_rows()>0) 
                {
                    $array_data['submenu']=$subquery->result(); 
                    $data[]=$array_data; 
                }
                else
                {
                    $array_data['submenu']=null; 
                }
            } 
        }
        else 
        {
            return null; 
        } 
        return $data; 
    }

    public function seperate_menu_list($type,$role_id) 

    {
        $menu_name='';
        $whr='';
        if($type == 'role'){
            $menu_name = 'Users'; 
            $whr = "AND s.action IN ('role-list','add-role','edit_role','delete_role')";
        }elseif($type == 'role_manage'){
            $menu_name = 'Users'; 
            $whr = "AND s.action IN ('role-management')";
        }elseif($type == 'users'){
            $menu_name = 'Users'; 
            $whr = "AND s.action IN ('user-list','add-user','edit_user','delete_user')";
        }elseif($type == 'oef'){
            $menu_name = 'BOQ';    
            $whr = "AND s.action IN ('create-project-list','create-project','update_create_project','approved_project_details')";
        }elseif($type == 'boq'){
            $menu_name = 'BOQ';    
            $whr = "AND s.action IN ('upload-boq-items','publish_boq_items_bulk_upload','add-boq-items','approved_boq_details','delete_boq_details')";
        }elseif($type == 'boq_exceptional'){
            $menu_name = 'BOQ';    
            $whr = "AND s.action IN ('boq-exceptional-approval','save_boq_exceptional_approval','edit_boq_exceptional_approval','approve_boq_exceptional_approval')";
        }else if($type == 'boq_variable') {
            $menu_name = 'BOQ';    
            $whr = "AND s.action IN ('boq-variable-discount','save_boq_variable_discount','edit_boq_variable_discount_approval','approve_boq_variable_discount')";
        } elseif($type == 'client_delivery_challan'){
            $menu_name = 'BOQ';    
            $whr = "AND s.action IN ('client-delivery-challan','save_client_dc_details','edit_delivery_challan','approved_delivery_challan')";
        }elseif($type == 'installed_wip'){
            $menu_name = 'BOQ';    
            $whr = "AND s.action IN ('add-installed-wip','save_installed_wip_details','edit_installed_wip','approved_installed_wip')";
        }elseif($type == 'provisional_wip'){
            $menu_name = 'BOQ';    
            $whr = "AND s.action IN ('add-provisional-wip','save_provisional_wip_details','edit_provisional_wip','approved_provisional_wip')";
        }elseif($type == 'proforma_invc'){
            $menu_name = 'BOQ';    
            $whr = "AND s.action IN ('create-proforma-invoice','save_proforma_invoice_details','edit_proforma_invoice','approved_proforma_invoice','convert_to_tax_invoice')";
        }elseif($type == 'tax_invc'){
            $menu_name = 'BOQ';    
            $whr = "AND s.action IN ('create-tax-invoice','save_tax_invoice_details','edit_tax_invoice','approved_tax_invoice')";
        }elseif($type == 'payment_recpt'){
            $menu_name = 'BOQ';    
            $whr = "AND s.action IN ('view_payment_receipt','save_payment_advice','edit_payment_advice','approved_payment_advice')";
        }elseif($type == 'invoive_closure'){
            $menu_name = 'BOQ';    
            $whr = "AND s.action IN ('view_invoice_closure','save_invoice_closure','edit_invoice_closure','approved_invoice_closure')";
        }elseif($type == 'project_closure'){
            $menu_name = 'BOQ';    
            $whr = "AND s.action IN ('view_project_closure','save_project_closure','edit_project_closure','approved_project_closure')";
        }elseif($type == 'compliance'){
            $menu_name = 'Compliance';    
            $whr = "AND s.action IN ('add-or-view-compliance','Add_View_Compliance')";
        }elseif($type == 'reports'){
            $menu_name = 'Reports';    
            $whr = "";
        }elseif($type == 'bom'){
            $menu_name = 'BOM';    
            $whr = "AND s.action IN ('upload-bom-items','publish_bom_items_bulk_upload','add-bom-items','approved_bom_details','delete_bom_details')";
        }

        $query=$this->db->query("SELECT * FROM tbl_menu where display='Y' AND menu_name = '".$menu_name."'"); 
        if($query->num_rows()>0) 
        {
            $data=array(); 
            foreach($query->result() as $key) 
            {
                $array_data['menu']=$key; 
                $menu_id=$key->menu_id; 
                $subquery=$this->db->query("SELECT s.*,if(isnull(p.role_id),'N','Y') prev FROM tbl_submenu s 
                left join tbl_priviledges p on p.role_id=? and p.submenu_id=s.submenu_id where s.menu_id=? and s.display='Y' $whr ORDER BY s.submenu_id ASC",array($role_id,$menu_id)); 
                if($subquery->num_rows()>0) 
                {
                    $array_data['submenu']=$subquery->result(); 
                    $data[]=$array_data; 
                }
                else 
                {
                    $array_data['submenu']=null; 
                }
            } 
        }
        else 
        {
            return null; 
        } 
        return $data; 
    }

    public function save_role_config($role_id,$submenu) 

    {
        $this->db->trans_start(); 
        $this->db->where('role_id',$role_id); 
        $this->db->delete('tbl_priviledges'); 
        if($submenu) 
        {
            foreach ($submenu as $key) 
            {
                $this->db->insert('tbl_priviledges',array('submenu_id'=>$key,'role_id'=>$role_id)); 
            } 
            $query=$this->db->trans_complete(); 
            if($query) 
            {
                return true; 
            } 
            else 
            {
                return false; 
            } 
        }
        else 
        {
            return null; 
        } 
    }
}?>