<!--CREATE View `view_boq_exceptional` AS (SELECT boqe.exceptional_id,-->
<!--boqe.`project_id`,boqe.`exceptional_no`, boqe.`except_type`, boqe.`exceptional_inc`, boqe.`transaction_id`, p.name_of_work,p.bp_code,p.customer_name,boqe.`PO_taxable_amt`, boqe.`gst_rate`,boqe.`gst_amount`,-->
<!--boqe.`po_final_amount`, boqe.`po_doc`, boqe.`display`, boqe.`created_at`, boqe.`created_by`, boqe.`updated_at`, boqe.`updated_by`, boqe.`status`,boqe.billable,-->
<!--IFNULL(CONCAT(u.fullname, u.m_name, u.s_name),u.fullname) as created_by_name,IFNULL(r.role_name,0) as created_by_rolename,-->
<!--IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name),u1.fullname) as approved_by_name,IFNULL(r1.role_name,0) as approved_by_rolename-->
<!--FROM tbl_boq_exceptional boqe -->
<!--INNER JOIN tbl_projects p ON boqe.project_id=p.project_id -->
<!--LEFT JOIN tbl_user u ON u.user_id=boqe.created_by -->
<!--LEFT JOIN tbl_role r ON r.role_id=u.role_id -->
<!--LEFT JOIN tbl_user u1 ON u1.user_id=boqe.approved_by -->
<!--LEFT JOIN tbl_role r1 ON r1.role_id=u1.role_id -->
<!--WHERE boqe.exceptional_id >0 AND boqe.`display` = 'Y' GROUP BY boqe.exceptional_id);-->

CREATE VIEW `view_boq_exceptional` AS
SELECT 
    boqe.exceptional_id,
    boqe.project_id,
    boqe.exceptional_no,
    boqe.except_type,
    boqe.exceptional_inc,
    boqe.transaction_id,
    p.name_of_work,
    p.bp_code,
    p.customer_name,
    boqe.PO_taxable_amt,
    boqe.gst_rate,
    boqe.gst_amount,
    boqe.po_final_amount,
    boqe.po_doc,
    boqe.display,
    boqe.created_at,
    boqe.created_by,
    boqe.updated_at,
    boqe.updated_by,
    boqe.status,
    boqe.billable,
    IFNULL(CONCAT(u.fullname, u.m_name, u.s_name), u.fullname) AS created_by_name,
    IFNULL(r.role_name, 0) AS created_by_rolename,
    IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name), u1.fullname) AS approved_by_name,
    IFNULL(r1.role_name, 0) AS approved_by_rolename
FROM 
    tbl_boq_exceptional boqe
INNER JOIN 
    tbl_projects p ON boqe.project_id = p.project_id
LEFT JOIN 
    tbl_user u ON u.user_id = boqe.created_by
LEFT JOIN 
    tbl_role r ON r.role_id = u.role_id
LEFT JOIN 
    tbl_user u1 ON u1.user_id = boqe.approved_by
LEFT JOIN 
    tbl_role r1 ON r1.role_id = u1.role_id
WHERE 
    boqe.exceptional_id > 0 
    AND boqe.display = 'Y';


CREATE View `view_dcc` AS (SELECT `dcci`.*,p.bp_code,p.work_order_on,p.customer_name,c.consignee_name,
IFNULL(CONCAT(u.fullname, u.m_name, u.s_name),u.fullname) as created_by_name,IFNULL(r.role_name,0) as created_by_rolename,
IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name),u1.fullname) as approved_by_name,IFNULL(r1.role_name,0) as approved_by_rolename
FROM tbl_delivery_challan dcci 
INNER JOIN tbl_projects p ON dcci.project_id=p.project_id
LEFT JOIN tbl_deliv_challan_consignee c ON dcci.consignee=c.id
LEFT JOIN tbl_user u ON u.user_id=dcci.created_by 
LEFT JOIN tbl_role r ON r.role_id=u.role_id 
LEFT JOIN tbl_user u1 ON u1.user_id=dcci.approved_by
LEFT JOIN tbl_role r1 ON r1.role_id=u1.role_id) 


CREATE View `view_tax_payment_receipts` AS (SELECT `dcci`.*,
IFNULL(CONCAT(u.fullname, u.m_name, u.s_name),u.fullname) as created_by_name,
IFNULL(r.role_name,0) as created_by_rolename,
IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name),u1.fullname) as approved_by_name,
IFNULL(r1.role_name,0) as approved_by_rolename
FROM tbl_payment_receipt dcci 
LEFT JOIN tbl_user u ON u.user_id=dcci.created_by 
LEFT JOIN tbl_role r ON r.role_id=u.role_id 
LEFT JOIN tbl_user u1 ON u1.user_id=dcci.approved_by 
LEFT JOIN tbl_role r ON r1.role_id=u1.role_id)


CREATE View `view_dcvs` AS (SELECT `dcci`.*,p.bp_code,p.customer_name FROM tbl_virtual_stock dcci INNER JOIN tbl_projects p ON dcci.project_id=p.project_id)
CREATE View `view_dciwip` AS (SELECT `dcci`.*,p.bp_code,p.customer_name FROM tbl_installed_wip dcci INNER JOIN tbl_projects p ON dcci.project_id=p.project_id)
CREATE View `view_dcpwip` AS (SELECT `dcci`.*,p.bp_code,p.customer_name FROM tbl_provisional_wip dcci INNER JOIN tbl_projects p ON dcci.project_id=p.project_id)
CREATE View `view_boq_items` AS (SELECT `boqitm`.*,p.bp_code,p.is_billing_inter_state
FROM tbl_boq_items boqitm INNER JOIN tbl_projects p ON boqitm.project_id=p.project_id)

CREATE View `view_proforma_invc` AS (SELECT `proinvc`.*,p.payment_terms,p.bp_code,p.customer_name,p.name_of_work,p.work_order_on,p.site_address,p.billing_address
FROM tbl_proforma_invc proinvc INNER JOIN tbl_projects p ON proinvc.project_id=p.project_id)

CREATE View `view_tax_invc` AS 
(SELECT `taxinvc`.*,p.bp_code,p.customer_name,p.name_of_work,p.work_order_on,p.site_address,p.billing_address,IFNULL(p.gst_no,0) as gst_no,
IFNULL(CONCAT(u.fullname, u.m_name, u.s_name),u.fullname) as created_by_name,IFNULL(r.role_name,0) as created_by_rolename,
IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name),u1.fullname) as approved_by_name,IFNULL(r1.role_name,0) as approved_by_rolename 
FROM tbl_tax_invc taxinvc 
INNER JOIN tbl_projects p ON taxinvc.project_id=p.project_id
LEFT JOIN tbl_user u ON u.user_id=taxinvc.created_by 
LEFT JOIN tbl_role r ON r.role_id=u.role_id 
LEFT JOIN tbl_user u1 ON u1.user_id=taxinvc.approved_by 
LEFT JOIN tbl_role r1 ON r1.role_id=u1.role_id 
)

<!--CREATE View `view_latest_boq_items` AS (SELECT -->
<!--`boqitm`.`boq_items_id`, `boqitm`.`project_id`, `boqitm`.`boq_code`, `boqitm`.`hsn_sac_code`, `boqitm`.`item_description`, `boqitm`.`unit`,-->
<!--`boqitm`.`scheduled_qty`, `boqitm`.`design_qty`,`boqitm`.`o_design_qty`,`boqitm`.`rate_basic`, `boqitm`.`gst`, `boqitm`.`non_schedule`,-->
<!--`boqitm`.`created_by`, `boqitm`.`created_on`, `boqitm`.`modified_by`, `boqitm`.`modified_on`, `boqitm`.`display`, `boqitm`.`status`, `boqitm`.steps,`boqitm`.transaction_id,-->
<!--p.bp_code,p.is_billing_inter_state,boqitm.client_boq_sr_no,-->
<!--IFNULL(CONCAT(u.fullname, u.m_name, u.s_name),u.fullname) as created_by_name,IFNULL(r.role_name,0) as created_by_rolename,-->
<!--IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name),u1.fullname) as approved_by_name,IFNULL(r1.role_name,0) as approved_by_rolename -->
<!--FROM tbl_boq_items boqitm -->
<!--INNER JOIN tbl_projects p ON boqitm.project_id=p.project_id-->
<!--LEFT JOIN tbl_user u ON u.user_id=boqitm.created_by -->
<!--LEFT JOIN tbl_role r ON r.role_id=u.role_id -->
<!--LEFT JOIN tbl_user u1 ON u1.user_id=boqitm.approved_by -->
<!--LEFT JOIN tbl_role r1 ON r1.role_id=u1.role_id -->
<!--WHERE `boqitm`.billable='Y' AND `boqitm`.display='Y' -->
<!--AND boq_items_id IN (SELECT MAX(boq_items_id) FROM tbl_boq_items WHERE billable='Y' AND display='Y' GROUP BY project_id,boq_code)-->
<!--GROUP BY `boqitm`.project_id,`boqitm`.boq_code) -->

CREATE VIEW `view_latest_boq_items` AS
SELECT 
    boqitm.boq_items_id, 
    boqitm.project_id, 
    boqitm.boq_code, 
    boqitm.hsn_sac_code, 
    boqitm.item_description, 
    boqitm.unit,
    boqitm.scheduled_qty, 
    boqitm.design_qty,
    boqitm.o_design_qty,
    boqitm.rate_basic, 
    boqitm.gst, 
    boqitm.non_schedule,
    boqitm.created_by, 
    boqitm.created_on, 
    boqitm.modified_by, 
    boqitm.modified_on, 
    boqitm.display, 
    boqitm.status,
    boqitm.steps,
    boqitm.transaction_id,
    p.bp_code,
    p.is_billing_inter_state,
    boqitm.client_boq_sr_no,
    IFNULL(CONCAT(u.fullname, u.m_name, u.s_name), u.fullname) AS created_by_name,
    IFNULL(r.role_name, 0) AS created_by_rolename,
    IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name), u1.fullname) AS approved_by_name,
    IFNULL(r1.role_name, 0) AS approved_by_rolename
FROM 
    tbl_boq_items boqitm
INNER JOIN 
    tbl_projects p ON boqitm.project_id = p.project_id
LEFT JOIN 
    tbl_user u ON u.user_id = boqitm.created_by
LEFT JOIN 
    tbl_role r ON r.role_id = u.role_id
LEFT JOIN 
    tbl_user u1 ON u1.user_id = boqitm.approved_by
LEFT JOIN 
    tbl_role r1 ON r1.role_id = u1.role_id
WHERE 
    boqitm.billable = 'Y' 
    AND boqitm.display = 'Y'
    AND boqitm.boq_items_id IN (
        SELECT MAX(boq_items_id) 
        FROM tbl_boq_items 
        WHERE billable = 'Y' 
          AND display = 'Y' 
        GROUP BY project_id, boq_code
    );


CREATE View `view_boq_transactions` AS (SELECT `dcci`.*,p.bp_code,p.customer_name,
IFNULL(CONCAT(u.fullname, u.m_name, u.s_name),u.fullname) as created_by_name,IFNULL(r.role_name,0) as created_by_rolename,
IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name),u1.fullname) as approved_by_name,IFNULL(r1.role_name,0) as approved_by_rolename
FROM tbl_boq_transactions dcci 
INNER JOIN tbl_projects p ON dcci.project_id=p.project_id
LEFT JOIN tbl_user u ON u.user_id=dcci.created_by 
LEFT JOIN tbl_role r ON r.role_id=u.role_id 
LEFT JOIN tbl_user u1 ON u1.user_id=dcci.approved_by
LEFT JOIN tbl_role r1 ON r1.role_id=u1.role_id) 

CREATE View `view_approval_waiting` AS (SELECT `dcci`.*,p.bp_code,p.customer_name,
IFNULL(CONCAT(u.fullname, u.m_name, u.s_name),u.fullname) as created_by_name,IFNULL(r.role_name,0) as created_by_rolename,
IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name),u1.fullname) as approved_by_name,IFNULL(r1.role_name,0) as approved_by_rolename
FROM tbl_approval_waiting dcci 
INNER JOIN tbl_projects p ON dcci.project_id=p.project_id
LEFT JOIN tbl_user u ON u.user_id=dcci.created_by 
LEFT JOIN tbl_role r ON r.role_id=u.role_id 
LEFT JOIN tbl_user u1 ON u1.user_id=dcci.approved_by
LEFT JOIN tbl_role r1 ON r1.role_id=u1.role_id) 

CREATE View `view_boq_expectional_item` AS (SELECT boqitm.*,p.bp_code,p.is_billing_inter_state,
IFNULL(CONCAT(u.fullname, u.m_name, u.s_name),u.fullname) as created_by_name,IFNULL(r.role_name,0) as created_by_rolename,
IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name),u1.fullname) as approved_by_name,IFNULL(r1.role_name,0) as approved_by_rolename 
FROM tbl_boq_exceptional boqitm 
INNER JOIN tbl_projects p ON boqitm.project_id=p.project_id
LEFT JOIN tbl_user u ON u.user_id=boqitm.created_by 
LEFT JOIN tbl_role r ON r.role_id=u.role_id 
LEFT JOIN tbl_user u1 ON u1.user_id=boqitm.approved_by 
LEFT JOIN tbl_role r1 ON r1.role_id=u1.role_id 
WHERE `boqitm`.billable='Y' AND `boqitm`.display='Y') 


