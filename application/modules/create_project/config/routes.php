<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['create-project'] ='create_project/create_project_controller/create_project';
$route['save_create_project'] ='create_project/create_project_controller/save_create_project';
$route['upload_document_file'] ='create_project/create_project_controller/upload_document_file';
$route['upload_emd_paid'] ='create_project/create_project_controller/upload_emd_paid';
$route['upload_asd_paid'] ='create_project/create_project_controller/upload_asd_paid';
$route['upload_security_deposite'] ='create_project/create_project_controller/upload_security_deposite';
$route['upload_performance_paid'] ='create_project/create_project_controller/upload_performance_paid';
$route['create-project-list'] ='create_project/create_project_controller/create_project_list';
$route['edit-create-project/(:any)'] ="create_project/create_project_controller/edit_create_project/$1";
$route['project_list_display'] ='create_project/create_project_controller/project_list_display';
$route['approved_project_details'] ='create_project/create_project_controller/approved_project_details';
$route['project-details/(:any)'] ="create_project/create_project_controller/project_details/$1";
$route['view-boq/(:any)'] ="create_project/create_project_controller/view_boq/$1";
$route['boq-transaction/(:any)'] ="create_project/create_project_controller/boq_transaction/$1";
$route['operational-scheduled/(:any)'] ="create_project/create_project_controller/operational_schedule/$1";
$route['delivery-challan/(:any)'] ="create_project/create_project_controller/delivery_challan/$1";
$route['approval-waiting/(:any)'] ="create_project/create_project_controller/approval_waiting/$1";
$route['project_waiting_approv_list'] ='create_project/create_project_controller/project_waiting_approv_list';
$route['all_reminder_list'] ='create_project/create_project_controller/all_reminder_list';
$route['notification_list'] ='create_project/create_project_controller/notification_list';
$route['view-all-notification/(:any)'] ="create_project/create_project_controller/view_all_notification/$1";
$route['view-all-reminder/(:any)'] ="create_project/create_project_controller/view_all_reminder/$1";
$route['project-closure/(:any)'] ="create_project/create_project_controller/project_closure/$1";
$route['warehouse/(:any)'] ="create_project/create_project_controller/virtual_stock/$1";
$route['installed-wip/(:any)'] ="create_project/create_project_controller/installed_wip/$1";
$route['provisional-wip/(:any)'] ="create_project/create_project_controller/provisional_wip/$1";
$route['tax-invoice/(:any)'] ="create_project/create_project_controller/tax_invoice/$1";
$route['proforma-invoice/(:any)'] ="create_project/create_project_controller/proforma_invoice/$1";
$route['wip-status/(:any)'] ="create_project/create_project_controller/wip_status/$1";
$route['project_wipstatus_list'] ='create_project/create_project_controller/project_wipstatus_list';
$route['update_create_project'] ='create_project/create_project_controller/update_create_project';
$route['view-boq-exceptional-approval/(:any)'] ="create_project/create_project_controller/view_boq_exceptional_approval/$1";

