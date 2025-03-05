CREATE View `view_dcc` AS (SELECT `dcci`.*,p.bp_code,p.customer_name FROM tbl_delivery_challan dcci INNER JOIN tbl_projects p ON dcci.project_id=p.project_id)
CREATE View `view_dcvs` AS (SELECT `dcci`.*,p.bp_code,p.customer_name FROM tbl_virtual_stock dcci INNER JOIN tbl_projects p ON dcci.project_id=p.project_id)
CREATE View `view_dciwip` AS (SELECT `dcci`.*,p.bp_code,p.customer_name FROM tbl_installed_wip dcci INNER JOIN tbl_projects p ON dcci.project_id=p.project_id)
CREATE View `view_dcpwip` AS (SELECT `dcci`.*,p.bp_code,p.customer_name FROM tbl_provisional_wip dcci INNER JOIN tbl_projects p ON dcci.project_id=p.project_id)
CREATE View `view_boq_items` AS (SELECT `boqitm`.*,p.bp_code FROM tbl_boq_items boqitm INNER JOIN tbl_projects p ON boqitm.project_id=p.project_id)
CREATE View `view_proforma_invc` AS (SELECT `proinvc`.*,p.bp_code,p.customer_name FROM tbl_proforma_invc proinvc INNER JOIN tbl_projects p ON proinvc.project_id=p.project_id)
CREATE View `view_tax_invc` AS (SELECT `taxinvc`.*,p.bp_code,p.customer_name FROM tbl_tax_invc taxinvc INNER JOIN tbl_projects p ON taxinvc.project_id=p.project_id)

CREATE View `view_latest_boq_items` AS (SELECT 
`boqitm`.`boq_items_id`, `boqitm`.`project_id`, `boqitm`.`boq_code`, `boqitm`.`hsn_sac_code`, `boqitm`.`item_description`, `boqitm`.`unit`,
`boqitm`.`scheduled_qty`, `boqitm`.`design_qty`,`boqitm`.`rate_basic`, `boqitm`.`gst`, `boqitm`.`non_schedule`,
`boqitm`.`created_by`, `boqitm`.`created_on`, `boqitm`.`modified_by`, `boqitm`.`modified_on`, `boqitm`.`display`, `boqitm`.`status`, steps,
p.bp_code,p.is_billing_inter_state FROM tbl_boq_items boqitm INNER JOIN tbl_projects p ON boqitm.project_id=p.project_id
WHERE steps IN (SELECT MAX(steps) FROM tbl_boq_items GROUP BY project_id,boq_code) GROUP BY `boqitm`.project_id,`boqitm`.boq_code) 