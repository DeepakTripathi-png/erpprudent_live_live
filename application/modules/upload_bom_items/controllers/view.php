<!--CREATE View `view_latest_bom_items` AS (SELECT -->
<!--`bomitm`.`bom_items_id`, `bomitm`.`project_id`, `bomitm`.`boq_code`,`bomitm`.`bom_code`, `bomitm`.`hsn_sac_code`, `bomitm`.`item_description`, `bomitm`.`unit`,-->
<!--`bomitm`.`scheduled_qty`, `bomitm`.`design_qty`,`bomitm`.`o_design_qty`,`bomitm`.`rate_basic`, `bomitm`.`gst`, `bomitm`.`non_schedule`,-->
<!--`bomitm`.`created_by`, `bomitm`.`created_on`, `bomitm`.`modified_by`, `bomitm`.`modified_on`, `bomitm`.`display`, `bomitm`.`status`,-->
<!-- `bomitm`.steps,`bomitm`.transaction_id,p.bp_code,p.is_billing_inter_state,-->
<!--IFNULL(CONCAT(u.fullname, u.m_name, u.s_name),u.fullname) as created_by_name,IFNULL(r.role_name,0) as created_by_rolename,-->
<!--IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name),u1.fullname) as approved_by_name,IFNULL(r1.role_name,0) as approved_by_rolename -->
<!--FROM tbl_bom_items bomitm -->
<!--INNER JOIN tbl_projects p ON bomitm.project_id=p.project_id-->
<!--LEFT JOIN tbl_user u ON u.user_id=bomitm.created_by -->
<!--LEFT JOIN tbl_role r ON r.role_id=u.role_id -->
<!--LEFT JOIN tbl_user u1 ON u1.user_id=bomitm.approved_by -->
<!--LEFT JOIN tbl_role r1 ON r1.role_id=u1.role_id -->
<!--WHERE `bomitm`.billable='Y' AND `bomitm`.display='Y' -->
<!--AND bom_items_id IN (SELECT MAX(bom_items_id) FROM tbl_bom_items WHERE billable='Y' AND display='Y' GROUP BY project_id,bom_code)-->
<!--GROUP BY `bomitm`.project_id,`bomitm`.bom_code) -->

CREATE VIEW `view_latest_bom_items` AS
SELECT 
    bomitm.bom_items_id, 
    bomitm.project_id, 
    bomitm.boq_code,
    bomitm.bom_code, 
    bomitm.hsn_sac_code, 
    bomitm.item_description, 
    bomitm.unit,
    bomitm.scheduled_qty, 
    bomitm.design_qty,
    bomitm.o_design_qty,
    bomitm.rate_basic, 
    bomitm.gst, 
    bomitm.non_schedule,
    bomitm.created_by, 
    bomitm.created_on, 
    bomitm.modified_by, 
    bomitm.modified_on, 
    bomitm.display, 
    bomitm.status,
    bomitm.steps,
    bomitm.transaction_id,
    p.bp_code,
    p.is_billing_inter_state,
    IFNULL(CONCAT(u.fullname, u.m_name, u.s_name), u.fullname) AS created_by_name,
    IFNULL(r.role_name, 0) AS created_by_rolename,
    IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name), u1.fullname) AS approved_by_name,
    IFNULL(r1.role_name, 0) AS approved_by_rolename
FROM 
    tbl_bom_items bomitm
INNER JOIN 
    tbl_projects p ON bomitm.project_id = p.project_id
LEFT JOIN 
    tbl_user u ON u.user_id = bomitm.created_by
LEFT JOIN 
    tbl_role r ON r.role_id = u.role_id
LEFT JOIN 
    tbl_user u1 ON u1.user_id = bomitm.approved_by
LEFT JOIN 
    tbl_role r1 ON r1.role_id = u1.role_id
WHERE 
    bomitm.billable = 'Y' 
    AND bomitm.display = 'Y'
    AND bomitm.bom_items_id IN (
        SELECT MAX(bom_items_id) 
        FROM tbl_bom_items 
        WHERE billable = 'Y' 
          AND display = 'Y' 
        GROUP BY project_id, bom_code
    );



<!--CREATE View `view_bom_transactions` AS (SELECT `dcci`.*,p.bp_code,p.customer_name,boqitm.boq_code,boqitm.item_description,-->
<!--IFNULL(CONCAT(u.fullname, u.m_name, u.s_name),u.fullname) as created_by_name,IFNULL(r.role_name,0) as created_by_rolename,-->
<!--IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name),u1.fullname) as approved_by_name,IFNULL(r1.role_name,0) as approved_by_rolename-->
<!--FROM tbl_bom_transactions dcci -->
<!--INNER JOIN tbl_bom_items bomitm ON dcci.id=bomitm.transaction_id-->
<!--INNER JOIN tbl_boq_items boqitm ON boqitm.boq_code=bomitm.boq_code and boqitm.project_id=bomitm.project_id-->
<!--INNER JOIN tbl_projects p ON dcci.project_id=p.project_id-->
<!--LEFT JOIN tbl_user u ON u.user_id=dcci.created_by -->
<!--LEFT JOIN tbl_role r ON r.role_id=u.role_id -->
<!--LEFT JOIN tbl_user u1 ON u1.user_id=dcci.approved_by-->
<!--LEFT JOIN tbl_role r1 ON r1.role_id=u1.role_id WHERE bomitm.`status` = 'pending' GROUP BY `bomitm`.project_id,`bomitm`.boq_code) -->
CREATE VIEW `view_bom_transactions` AS
SELECT 
    dcci.*,
    p.bp_code,
    p.customer_name,
    boqitm.boq_code,
    boqitm.item_description,
    IFNULL(CONCAT(u.fullname, u.m_name, u.s_name), u.fullname) AS created_by_name,
    IFNULL(r.role_name, 0) AS created_by_rolename,
    IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name), u1.fullname) AS approved_by_name,
    IFNULL(r1.role_name, 0) AS approved_by_rolename
FROM 
    tbl_bom_transactions dcci
INNER JOIN 
    tbl_bom_items bomitm ON dcci.id = bomitm.transaction_id
INNER JOIN 
    tbl_boq_items boqitm ON boqitm.boq_code = bomitm.boq_code AND boqitm.project_id = bomitm.project_id
INNER JOIN 
    tbl_projects p ON dcci.project_id = p.project_id
LEFT JOIN 
    tbl_user u ON u.user_id = dcci.created_by
LEFT JOIN 
    tbl_role r ON r.role_id = u.role_id
LEFT JOIN 
    tbl_user u1 ON u1.user_id = dcci.approved_by
LEFT JOIN 
    tbl_role r1 ON r1.role_id = u1.role_id
WHERE 
    bomitm.status = 'pending';


<!-- CREATE View `view_bom_items` AS (SELECT `bomitm`.*,p.bp_code,p.is_billing_inter_state
FROM tbl_bom_items bomitm INNER JOIN tbl_projects p ON bomitm.project_id=p.project_id) -->

CREATE View `view_bom_items` AS (SELECT
    `bomitm`.`bom_items_id` AS `bom_items_id`,
    `bomitm`.`project_id` AS `project_id`,
    `bomitm`.`boq_code` AS `boq_code`,
    `bomitm`.`bom_code` AS `bom_code`,
    `bomitm`.`hsn_sac_code` AS `hsn_sac_code`,
    `bomitm`.`item_description` AS `item_description`,
    `bomitm`.`unit` AS `unit`,
    `bomitm`.`scheduled_qty` AS `scheduled_qty`,
    `bomitm`.`design_qty` AS `design_qty`,
    `bomitm`.`upload_design_qty` AS `upload_design_qty`,
    `bomitm`.`o_design_qty` AS `o_design_qty`,
    `bomitm`.`rate_basic` AS `rate_basic`,
    `bomitm`.`gst` AS `gst`,
    `bomitm`.`make` AS `make`,
    `bomitm`.`model` AS `model`,
    `bomitm`.`non_schedule` AS `non_schedule`,
    `bomitm`.`created_by` AS `created_by`,
    `bomitm`.`created_on` AS `created_on`,
    `bomitm`.`modified_by` AS `modified_by`,
    `bomitm`.`modified_on` AS `modified_on`,
    `bomitm`.`display` AS `display`,
    `bomitm`.`status` AS `status`,
    `bomitm`.`steps` AS `steps`,
    `bomitm`.`stock` AS `stock`,
    `bomitm`.`deleted_by` AS `deleted_by`,
    `bomitm`.`deleted_date` AS `deleted_date`,
    `bomitm`.`approved_by` AS `approved_by`,
    `bomitm`.`approved_date` AS `approved_date`,
    `bomitm`.`addFromEA` AS `addFromEA`,
    `bomitm`.`billable` AS `billable`,
    `bomitm`.`transaction_id` AS `transaction_id`,
    `bomitm`.`approval_trans_id` AS `approval_trans_id`,
    `p`.`bp_code` AS `bp_code`,
    `p`.`is_billing_inter_state` AS `is_billing_inter_state`
FROM
    `tbl_bom_items` `bomitm`
JOIN `tbl_projects` `p`
ON
    (`bomitm`.`project_id` = `p`.`project_id`)
)


<!--CREATE View `view_bom_boq_items` AS ( SELECT `bomitm`.`bom_items_id` AS `bom_items_id`, `bomitm`.`bom_code` AS `bom_code`, `boqitm`.*,-->
<!-- `p`.`bp_code` AS `bp_code`, `p`.`is_billing_inter_state` AS `is_billing_inter_state` -->
<!-- FROM ( `tbl_bom_items` `bomitm` JOIN tbl_boq_items boqitm ON bomitm.boq_code = boqitm.boq_code AND `bomitm`.`project_id` = `boqitm`.`project_id` -->
<!-- JOIN `tbl_projects` `p` ON ( `bomitm`.`project_id` = `p`.`project_id` ) ) WHERE  GROUP BY `bomitm`.`project_id`, `bomitm`.`boq_code`)-->

CREATE VIEW `view_bom_boq_items` AS
SELECT 
    `bomitm`.`bom_items_id` AS `bom_items_id`,
    `bomitm`.`bom_code` AS `bom_code`,
    `boqitm`.*,
    `p`.`bp_code` AS `bp_code`,
    `p`.`is_billing_inter_state` AS `is_billing_inter_state`
FROM 
    `tbl_bom_items` `bomitm`
JOIN 
    `tbl_boq_items` `boqitm` ON `bomitm`.`boq_code` = `boqitm`.`boq_code` 
    AND `bomitm`.`project_id` = `boqitm`.`project_id`
JOIN 
    `tbl_projects` `p` ON `bomitm`.`project_id` = `p`.`project_id`
;

<!-- CREATE View `view_bom_boq_latest_items` AS (-->
<!-- SELECT -->
<!--`boqitm`.`boq_items_id`, `boqitm`.`project_id`, `boqitm`.`boq_code`, `boqitm`.`hsn_sac_code`, `boqitm`.`item_description`, `boqitm`.`unit`,-->
<!--`boqitm`.`scheduled_qty`, `boqitm`.`design_qty`,`boqitm`.`o_design_qty`,`boqitm`.`rate_basic`, `boqitm`.`gst`, `boqitm`.`non_schedule`,-->
<!--`boqitm`.`created_by`, `boqitm`.`created_on`, `boqitm`.`modified_by`, `boqitm`.`modified_on`, `boqitm`.`display`, `bomitm`.`status`, `boqitm`.steps,`boqitm`.transaction_id,-->
<!--p.bp_code,p.is_billing_inter_state,-->
<!--IFNULL(CONCAT(u.fullname, u.m_name, u.s_name),u.fullname) as created_by_name,IFNULL(r.role_name,0) as created_by_rolename,-->
<!--IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name),u1.fullname) as approved_by_name,IFNULL(r1.role_name,0) as approved_by_rolename -->
<!--FROM tbl_boq_items boqitm -->
<!--INNER JOIN tbl_projects p ON boqitm.project_id=p.project_id-->
<!--INNER JOIN tbl_bom_items bomitm ON bomitm.boq_code=boqitm.boq_code AND bomitm.project_id=boqitm.project_id-->
<!--LEFT JOIN tbl_user u ON u.user_id=boqitm.created_by -->
<!--LEFT JOIN tbl_role r ON r.role_id=u.role_id -->
<!--LEFT JOIN tbl_user u1 ON u1.user_id=boqitm.approved_by -->
<!--LEFT JOIN tbl_role r1 ON r1.role_id=u1.role_id -->
<!--WHERE `boqitm`.billable='Y' AND `boqitm`.display='Y' -->
<!--AND boq_items_id IN (SELECT MAX(boq_items_id) FROM tbl_boq_items WHERE billable='Y' AND display='Y' GROUP BY project_id,boq_code)-->
<!--GROUP BY `boqitm`.project_id,`boqitm`.boq_code)-->

CREATE VIEW `view_bom_boq_latest_items` AS 
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
    bomitm.status, 
    boqitm.steps,
    boqitm.transaction_id,
    p.bp_code,
    p.is_billing_inter_state,
    IFNULL(CONCAT(u.fullname, u.m_name, u.s_name), u.fullname) as created_by_name,
    IFNULL(r.role_name, 0) as created_by_rolename,
    IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name), u1.fullname) as approved_by_name,
    IFNULL(r1.role_name, 0) as approved_by_rolename 
FROM 
    tbl_boq_items boqitm 
INNER JOIN 
    tbl_projects p ON boqitm.project_id = p.project_id
INNER JOIN 
    tbl_bom_items bomitm ON bomitm.boq_code = boqitm.boq_code AND bomitm.project_id = boqitm.project_id
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
        WHERE billable = 'Y' AND display = 'Y' 
        GROUP BY project_id, boq_code
    );



<!--CREATE View `view_bom_stock` AS ( SELECT `bomitm`.`bom_items_id` AS `bom_items_id`, `bomitm`.`bom_code` AS `bom_code`, `boqitm`.*,-->
<!-- `p`.`bp_code` AS `bp_code`, `p`.`is_billing_inter_state` AS `is_billing_inter_state` -->
<!-- FROM ( `tbl_bom_items` `bomitm` JOIN tbl_boq_items boqitm ON bomitm.boq_code = boqitm.boq_code AND `bomitm`.`project_id` = `boqitm`.`project_id` -->
<!-- JOIN `tbl_projects` `p` ON ( `bomitm`.`project_id` = `p`.`project_id` ) ) WHERE  GROUP BY `bomitm`.`project_id`, `bomitm`.`boq_code`)-->

CREATE VIEW `view_bom_stock` AS
SELECT 
    bomitm.bom_items_id AS bom_items_id, 
    bomitm.bom_code AS bom_code, 
    boqitm.*,
    p.bp_code AS bp_code, 
    p.is_billing_inter_state AS is_billing_inter_state
FROM 
    tbl_bom_items bomitm
JOIN 
    tbl_boq_items boqitm ON bomitm.boq_code = boqitm.boq_code 
    AND bomitm.project_id = boqitm.project_id
JOIN 
    tbl_projects p ON bomitm.project_id = p.project_id;




<!-- CREATE View `view_bom_transactions_release` AS (SELECT `dcci`.*,p.bp_code,p.customer_name,boqitm.boq_code,boqitm.item_description,-->
<!--IFNULL(CONCAT(u.fullname, u.m_name, u.s_name),u.fullname) as created_by_name,IFNULL(r.role_name,0) as created_by_rolename,-->
<!--IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name),u1.fullname) as approved_by_name,IFNULL(r1.role_name,0) as approved_by_rolename-->
<!--FROM tbl_bom_transactions dcci -->

<!--INNER JOIN tbl_bom_release_stock bomrelease ON dcci.id=bomrelease.transaction_id-->
<!--INNER JOIN tbl_boq_items boqitm ON boqitm.boq_code=bomrelease.boq_code and boqitm.project_id=bomrelease.project_id-->

<!--INNER JOIN tbl_projects p ON dcci.project_id=p.project_id-->
<!--LEFT JOIN tbl_user u ON u.user_id=dcci.created_by -->
<!--LEFT JOIN tbl_role r ON r.role_id=u.role_id -->
<!--LEFT JOIN tbl_user u1 ON u1.user_id=dcci.approved_by-->
<!--LEFT JOIN tbl_role r1 ON r1.role_id=u1.role_id WHERE bomrelease.`status` = 'pending' GROUP BY `bomrelease`.project_id,`bomrelease`.boq_code) -->

CREATE VIEW `view_bom_transactions_release` AS
SELECT 
    dcci.*,
    p.bp_code,
    p.customer_name,
    boqitm.boq_code,
    boqitm.item_description,
    IFNULL(CONCAT(u.fullname, u.m_name, u.s_name), u.fullname) AS created_by_name,
    IFNULL(r.role_name, 0) AS created_by_rolename,
    IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name), u1.fullname) AS approved_by_name,
    IFNULL(r1.role_name, 0) AS approved_by_rolename
FROM 
    tbl_bom_transactions dcci
INNER JOIN 
    tbl_bom_release_stock bomrelease ON dcci.id = bomrelease.transaction_id
INNER JOIN 
    tbl_boq_items boqitm ON boqitm.boq_code = bomrelease.boq_code AND boqitm.project_id = bomrelease.project_id
INNER JOIN 
    tbl_projects p ON dcci.project_id = p.project_id
LEFT JOIN 
    tbl_user u ON u.user_id = dcci.created_by
LEFT JOIN 
    tbl_role r ON r.role_id = u.role_id
LEFT JOIN 
    tbl_user u1 ON u1.user_id = dcci.approved_by
LEFT JOIN 
    tbl_role r1 ON r1.role_id = u1.role_id
WHERE 
    bomrelease.status = 'pending';


CREATE View `view_bom_item_release` AS (SELECT
    `bomitm`.`bom_items_id` AS `bom_items_id`,
    `bomitm`.`project_id` AS `project_id`,
    `bomitm`.`boq_code` AS `boq_code`,
    `bomitm`.`bom_code` AS `bom_code`,
    `bomitm`.`hsn_sac_code` AS `hsn_sac_code`,
    `bomitm`.`item_description` AS `item_description`,
    `bomitm`.`unit` AS `unit`,
    `bomitm`.`scheduled_qty` AS `scheduled_qty`,
    `bomitm`.`design_qty` AS `design_qty`,
    `bomitm`.`upload_design_qty` AS `upload_design_qty`,
    `bomitm`.`o_design_qty` AS `o_design_qty`,
    `bomitm`.`rate_basic` AS `rate_basic`,
    `bomitm`.`gst` AS `gst`,
    `bomitm`.`make` AS `make`,
    `bomitm`.`model` AS `model`,
    `bomitm`.`approval_trans_id` AS `approval_trans_id`,
    `p`.`bp_code` AS `bp_code`,
    `p`.`is_billing_inter_state` AS `is_billing_inter_state`,
    `bomrelease`.`released_quantity`,
    `bomrelease`.`schedule_type`,
    `bomrelease`.`status`,
    `bomrelease`.`transaction_id`,
    `bomrelease`.`display`
FROM
    `tbl_bom_items` `bomitm`
JOIN tbl_bom_release_stock bomrelease ON bomitm.bom_code=bomrelease.bom_code and bomitm.boq_code=bomrelease.boq_code and bomitm.project_id=bomrelease.project_id
JOIN `tbl_projects` `p` ON `bomitm`.`project_id` = `p`.`project_id`) 


<!--CREATE VIEW `view_bom_boq_latest_release_items` AS (-->
<!--  SELECT-->
<!--    `boqitm`.`boq_items_id`, `boqitm`.`project_id`, `boqitm`.`boq_code`, `boqitm`.`hsn_sac_code`,-->
<!--    `boqitm`.`item_description`, `boqitm`.`unit`, `boqitm`.`rate_basic`, `boqitm`.`gst`, `boqitm`.`non_schedule`,-->
<!--    `bomrstock`.`created_by`, `bomrstock`.`created_on`, `bomrstock`.`updated_by`, `bomrstock`.`updated_date`,-->
<!--    `bomrstock`.`display`, `bomrstock`.`status`, `bomrstock`.`transaction_id`, p.bp_code,-->
<!--    p.is_billing_inter_state, IFNULL(CONCAT(u.fullname, u.m_name, u.s_name), u.fullname) AS created_by_name,-->
<!--    IFNULL(r.role_name, 0) AS created_by_rolename, IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name), u1.fullname) AS approved_by_name,-->
<!--    IFNULL(r1.role_name, 0) AS approved_by_rolename-->
<!--  FROM tbl_boq_items boqitm-->
<!--    INNER JOIN tbl_projects p ON boqitm.project_id = p.project_id-->
<!--    INNER JOIN tbl_bom_items bomitm ON bomitm.boq_code = boqitm.boq_code AND bomitm.project_id = boqitm.project_id-->
<!--    INNER JOIN tbl_bom_release_stock bomrstock ON bomrstock.boq_code = boqitm.boq_code AND bomrstock.project_id = boqitm.project_id-->
<!--    LEFT JOIN tbl_user u ON u.user_id = boqitm.created_by-->
<!--    LEFT JOIN tbl_role r ON r.role_id = u.role_id-->
<!--    LEFT JOIN tbl_user u1 ON u1.user_id = boqitm.approved_by-->
<!--    LEFT JOIN tbl_role r1 ON r1.role_id = u1.role_id-->
<!--  WHERE `boqitm`.billable = 'Y' AND `boqitm`.display = 'Y' AND bomrstock.bom_release_id IN (-->
<!--    SELECT MAX(bom_release_id)-->
<!--    FROM tbl_bom_release_stock-->
<!--    WHERE display = 'Y'-->
<!--    GROUP BY project_id, boq_code-->
<!--  )-->
<!--  GROUP BY `boqitm`.project_id, `boqitm`.boq_code, bomrstock.status-->
<!--);-->

CREATE VIEW `view_bom_boq_latest_release_items` AS
SELECT
    boqitm.boq_items_id,
    boqitm.project_id,
    boqitm.boq_code,
    boqitm.hsn_sac_code,
    boqitm.item_description,
    boqitm.unit,
    boqitm.rate_basic,
    boqitm.gst,
    boqitm.non_schedule,
    bomrstock.created_by,
    bomrstock.created_on,
    bomrstock.updated_by,
    bomrstock.updated_date,
    bomrstock.display,
    bomrstock.status,
    bomrstock.transaction_id,
    p.bp_code,
    p.is_billing_inter_state,
    IFNULL(CONCAT(u.fullname, u.m_name, u.s_name), u.fullname) AS created_by_name,
    IFNULL(r.role_name, 0) AS created_by_rolename,
    IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name), u1.fullname) AS approved_by_name,
    IFNULL(r1.role_name, 0) AS approved_by_rolename
FROM
    tbl_boq_items boqitm
INNER JOIN
    tbl_projects p ON boqitm.project_id = p.project_id
INNER JOIN
    tbl_bom_items bomitm ON bomitm.boq_code = boqitm.boq_code AND bomitm.project_id = boqitm.project_id
INNER JOIN
    tbl_bom_release_stock bomrstock ON bomrstock.boq_code = boqitm.boq_code AND bomrstock.project_id = boqitm.project_id
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
    AND bomrstock.bom_release_id IN (
        SELECT MAX(bom_release_id)
        FROM tbl_bom_release_stock
        WHERE display = 'Y'
        GROUP BY project_id, boq_code
    );


CREATE View `view_bom_transactions_other` AS (SELECT `dcci`.*,p.bp_code,p.customer_name,
IFNULL(CONCAT(u.fullname, u.m_name, u.s_name),u.fullname) as created_by_name,IFNULL(r.role_name,0) as created_by_rolename,
IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name),u1.fullname) as approved_by_name,IFNULL(r1.role_name,0) as approved_by_rolename
FROM tbl_bom_transactions dcci 
INNER JOIN tbl_projects p ON dcci.project_id=p.project_id
LEFT JOIN tbl_user u ON u.user_id=dcci.created_by 
LEFT JOIN tbl_role r ON r.role_id=u.role_id 
LEFT JOIN tbl_user u1 ON u1.user_id=dcci.approved_by
LEFT JOIN tbl_role r1 ON r1.role_id=u1.role_id) 


CREATE View `view_indent` AS (SELECT `dcci`.*,p.bp_code,p.customer_name,
IFNULL(CONCAT(u.fullname, u.m_name, u.s_name),u.fullname) as created_by_name,IFNULL(r.role_name,0) as created_by_rolename,
IFNULL(CONCAT(u1.fullname, u1.m_name, u1.s_name),u1.fullname) as approved_by_name,IFNULL(r1.role_name,0) as approved_by_rolename
FROM tbl_bom_transactions dcci 
INNER JOIN tbl_projects p ON dcci.project_id=p.project_id
LEFT JOIN tbl_user u ON u.user_id=dcci.created_by 
LEFT JOIN tbl_role r ON r.role_id=u.role_id 
LEFT JOIN tbl_user u1 ON u1.user_id=dcci.approved_by
LEFT JOIN tbl_role r1 ON r1.role_id=u1.role_id) 


CREATE View `view_bom_indent` AS (SELECT `bomitm`.`bom_items_id` AS `bom_items_id`, `bomitm`.`project_id` 
AS `project_id`, `bomitm`.`boq_code` AS `boq_code`, `bomitm`.`bom_code` AS `bom_code`, `bomitm`.`hsn_sac_code` 
AS `hsn_sac_code`, `bomitm`.`item_description` AS `item_description`, `bomitm`.`unit` AS `unit`, `bomitm`.
`scheduled_qty` AS `scheduled_qty`, `bomitm`.`design_qty` AS `design_qty`, `bomitm`.`upload_design_qty` AS `
upload_design_qty`, `bomitm`.`o_design_qty` AS `o_design_qty`, `bomitm`.`rate_basic` AS `rate_basic`, `bomitm`.`gst` AS `gst`, 
`bomitm`.`make` AS `make`, `bomitm`.`model` AS `model`, `bomitm`.`approval_trans_id` AS `approval_trans_id`, `p`.`bp_code` AS `bp_code`, 
`p`.`is_billing_inter_state` AS `is_billing_inter_state`, `bomindent`.`indent_quantity`, `bomindent`.`status`, `bomindent`.`transaction_id`, 
`bomindent`.`display` FROM `tbl_bom_items` `bomitm` JOIN tbl_bom_indent_stock bomindent ON bomitm.bom_code = bomindent.bom_code 
AND bomitm.boq_code = bomindent.boq_code AND bomitm.project_id = bomindent.project_id JOIN 
`tbl_projects` `p` ON( `bomitm`.`project_id` = `p`.`project_id`))