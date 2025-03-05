<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['upload-boq-items'] ='upload_boq_items/upload_boq_items_controller/upload_boq_items';
$route['upload_boq_items_file'] ='upload_boq_items/upload_boq_items_controller/upload_boq_items_file';
$route['save_boq_file_data'] ='upload_boq_items/upload_boq_items_controller/save_boq_file_data';
$route['list-boq-items'] ='upload_boq_items/upload_boq_items_controller/list_boq_items';
$route['list-boq-items-operational-b'] ='upload_boq_items/upload_boq_items_controller/list_boq_items_operational_b';
$route['list-boq-items-operational-b-negative'] ='upload_boq_items/upload_boq_items_controller/list_boq_items_operational_b_negative';
$route['boq-variable-discount'] ='upload_boq_items/upload_boq_items_controller/boq_variable_discount';


$route['add-boq-items'] ='upload_boq_items/upload_boq_items_controller/add_boq_items';
$route['client-delivery-challan'] ='upload_boq_items/upload_boq_items_controller/client_delivery_challan';
$route['save_client_dc_details'] ='upload_boq_items/upload_boq_items_controller/save_client_dc_details';
$route['get_all_project_list'] ='upload_boq_items/upload_boq_items_controller/get_all_project_list';
$route['publish_boq_items_bulk_upload'] ='upload_boq_items/upload_boq_items_controller/publish_boq_items_bulk_upload';
$route['project_boq_list_display'] ='upload_boq_items/upload_boq_items_controller/project_boq_list_display';
$route['boq_scha_list_display'] ='upload_boq_items/upload_boq_items_controller/boq_scha_list_display';
$route['boq_schb_list_display'] ='upload_boq_items/upload_boq_items_controller/boq_schb_list_display';
$route['boq_schbn_list_display'] ='upload_boq_items/upload_boq_items_controller/boq_schbn_list_display';
$route['project_boq_item_list'] ='upload_boq_items/upload_boq_items_controller/project_boq_item_list';
$route['boq_transaction_display'] ='upload_boq_items/upload_boq_items_controller/boq_transaction_display';
$route['boq_schc_list_display'] ='upload_boq_items/upload_boq_items_controller/boq_schc_list_display';
$route['get_boq_item_by_project'] ='upload_boq_items/upload_boq_items_controller/get_boq_item_by_project';
$route['save_boq_item_details'] ='upload_boq_items/upload_boq_items_controller/save_boq_item_details';
$route['get_boq_item_details'] ='upload_boq_items/upload_boq_items_controller/get_boq_item_details';
$route['get_client_dc_by_project'] ='upload_boq_items/upload_boq_items_controller/get_client_dc_by_project';
$route['project_dcc_list'] ='upload_boq_items/upload_boq_items_controller/project_dcc_list';
$route['project_dcc_list_p'] ='upload_boq_items/upload_boq_items_controller/project_dcc_list_p';
$route['get_boq_items_list'] ='upload_boq_items/upload_boq_items_controller/get_boq_items_list';
$route['save_boq_variable_discount'] ='upload_boq_items/upload_boq_items_controller/save_boq_variable_discount';
$route['project_boq_discount_item_list'] ='upload_boq_items/upload_boq_items_controller/project_boq_discount_item_list';
$route['view_variable_discount_items'] ='upload_boq_items/upload_boq_items_controller/view_variable_discount_items';
$route['project_variable_discount_item'] ='upload_boq_items/upload_boq_items_controller/project_variable_discount_item';
$route['approve_boq_variable_discount'] ='upload_boq_items/upload_boq_items_controller/approve_boq_variable_discount';
$route['edit_boq_variable_discount_approval'] ='upload_boq_items/upload_boq_items_controller/edit_boq_variable_discount_approval';
$route['get_boq_item_details_for_variable_discount'] ='upload_boq_items/upload_boq_items_controller/get_boq_item_details_for_variable_discount';
$route['phpinfo'] ='upload_boq_items/upload_boq_items_controller/server_info';





$route['view_dcc_items'] ='upload_boq_items/upload_boq_items_controller/view_dcc_items';
$route['view_dcvs_items'] ='upload_boq_items/upload_boq_items_controller/view_dcvs_items';
$route['project_dcc_items'] ='upload_boq_items/upload_boq_items_controller/project_dcc_items';
$route['move-to-warehouse'] ='upload_boq_items/upload_boq_items_controller/add_virtual_stock';
$route['add-installed-wip'] ='upload_boq_items/upload_boq_items_controller/add_installed_wip';
$route['add-provisional-wip'] ='upload_boq_items/upload_boq_items_controller/add_provisional_wip';
$route['get_dc_item_by_project'] ='upload_boq_items/upload_boq_items_controller/get_dc_item_by_project';
$route['get_dc_boq_item_details'] ='upload_boq_items/upload_boq_items_controller/get_dc_boq_item_details';
$route['get_dcip_boq_item_details'] ='upload_boq_items/upload_boq_items_controller/get_dcip_boq_item_details';
$route['save_virtual_stock_details'] ='upload_boq_items/upload_boq_items_controller/save_virtual_stock_details';
$route['project_dcvs_list'] ='upload_boq_items/upload_boq_items_controller/project_dcvs_list';
$route['project_dcvs_items'] ='upload_boq_items/upload_boq_items_controller/project_dcvs_items';
$route['get_dciwip_item_by_project'] ='upload_boq_items/upload_boq_items_controller/get_dciwip_item_by_project';
$route['get_dcpwip_item_by_project'] ='upload_boq_items/upload_boq_items_controller/get_dcpwip_item_by_project';
$route['save_provisional_wip_details'] ='upload_boq_items/upload_boq_items_controller/save_provisional_wip_details';
$route['save_installed_wip_details'] ='upload_boq_items/upload_boq_items_controller/save_installed_wip_details';
$route['project_dciwip_list'] ='upload_boq_items/upload_boq_items_controller/project_dciwip_list';
$route['project_dciwip_list_p'] ='upload_boq_items/upload_boq_items_controller/project_dciwip_list_p';
$route['view_dciwip_items'] ='upload_boq_items/upload_boq_items_controller/view_dciwip_items';
$route['project_dciwip_items'] ='upload_boq_items/upload_boq_items_controller/project_dciwip_items';
$route['project_dcpwip_list'] ='upload_boq_items/upload_boq_items_controller/project_dcpwip_list';
$route['project_dcpwip_list_p'] ='upload_boq_items/upload_boq_items_controller/project_dcpwip_list_p';
$route['view_dcpwip_items'] ='upload_boq_items/upload_boq_items_controller/view_dcpwip_items';
$route['project_dcpwip_items'] ='upload_boq_items/upload_boq_items_controller/project_dcpwip_items';

$route['create-proforma-invoice'] ='upload_boq_items/upload_boq_items_controller/create_proforma_invoice';
$route['save_proforma_invoice_details'] ='upload_boq_items/upload_boq_items_controller/save_proforma_invoice_details';
$route['get_install_prov_by_project'] ='upload_boq_items/upload_boq_items_controller/get_install_prov_by_project';
$route['get_wip_boq_item_details'] ='upload_boq_items/upload_boq_items_controller/get_wip_boq_item_details';
$route['project_proformaInvc_list'] ='upload_boq_items/upload_boq_items_controller/project_proformaInvc_list';
$route['view_proforma_invoice_items'] ='upload_boq_items/upload_boq_items_controller/view_proforma_invoice_items';
$route['project_proinvc_items'] ='upload_boq_items/upload_boq_items_controller/project_proinvc_items';
$route['convert_to_tax_invoice'] ='upload_boq_items/upload_boq_items_controller/convert_to_tax_invoice';
$route['convert_tax_invoice_details'] ='upload_boq_items/upload_boq_items_controller/convert_tax_invoice_details';

$route['create-tax-invoice'] ='upload_boq_items/upload_boq_items_controller/create_tax_invoice';
$route['get_proforma_boq_item_details'] ='upload_boq_items/upload_boq_items_controller/get_proforma_boq_item_details';
$route['get_proforma_by_project'] ='upload_boq_items/upload_boq_items_controller/get_proforma_by_project';
$route['get_proforma_by_projects'] ='upload_boq_items/upload_boq_items_controller/get_proforma_by_projects';
$route['save_tax_invoice_details'] ='upload_boq_items/upload_boq_items_controller/save_tax_invoice_details';
$route['project_taxInvc_list'] ='upload_boq_items/upload_boq_items_controller/project_taxInvc_list';
$route['download_tax_invoice'] ='upload_boq_items/upload_boq_items_controller/download_tax_invoice';
$route['download_proforma_invoice'] ='upload_boq_items/upload_boq_items_controller/download_proforma_invoice';
$route['view_tax_invoice_items'] ='upload_boq_items/upload_boq_items_controller/view_tax_invoice_items';
$route['project_taxinvc_items'] ='upload_boq_items/upload_boq_items_controller/project_taxinvc_items';
$route['invoice-closure/(:any)'] ="upload_boq_items/upload_boq_items_controller/invoice_closure/$1";
$route['payment-receipt/(:any)'] ="upload_boq_items/upload_boq_items_controller/payment_receipt/$1";
$route['download_tax_invoice_format_1/(:any)'] ="upload_boq_items/upload_boq_items_controller/download_tax_invoice_format_1/$1";
$route['download_tax_invoice_format_2/(:any)'] ="upload_boq_items/upload_boq_items_controller/download_tax_invoice_format_2/$1";
$route['download_proforma_invoice_format_2/(:any)'] ="upload_boq_items/upload_boq_items_controller/download_proforma_invoice_format_2/$1";
$route['download_proforma_invoice_format_1/(:any)'] ="upload_boq_items/upload_boq_items_controller/download_proforma_invoice_format_1/$1";
$route['download_delivery_challan_note/(:any)'] ="upload_boq_items/upload_boq_items_controller/download_delivery_challan_note/$1";


$route['payment-receipt-details/(:any)'] ="upload_boq_items/upload_boq_items_controller/payment_receipt_details/$1";
$route['boq-exceptional-approval'] ='upload_boq_items/upload_boq_items_controller/boq_exceptional_approval';
$route['edit_proforma_invoice'] ='upload_boq_items/upload_boq_items_controller/edit_proforma_invoice';
$route['edit_tax_invoice'] ='upload_boq_items/upload_boq_items_controller/edit_tax_invoice';
$route['get_consignee_detail'] ='upload_boq_items/upload_boq_items_controller/get_consignee_detail';
$route['save_payment_advice'] ='upload_boq_items/upload_boq_items_controller/save_payment_advice';
$route['get_last_design_qty'] ='upload_boq_items/upload_boq_items_controller/get_last_design_qty';
$route['get_boq_exceptional_by_project'] ='upload_boq_items/upload_boq_items_controller/get_boq_exceptional_by_project';
$route['get_boq_exceptional_item'] ='upload_boq_items/upload_boq_items_controller/get_boq_exceptional_item';
$route['save_boq_exceptional_approval'] ='upload_boq_items/upload_boq_items_controller/save_boq_exceptional_approval';
$route['get_boq_exceptional_list'] ='upload_boq_items/upload_boq_items_controller/get_boq_exceptional_list';
$route['check_boq_exceptional_approval'] ='upload_boq_items/upload_boq_items_controller/check_boq_exceptional_approval';
$route['get_boq_exceptional_amount'] ='upload_boq_items/upload_boq_items_controller/get_boq_exceptional_amount';
$route['delete_boq_exceptional_approval'] ='upload_boq_items/upload_boq_items_controller/delete_boq_exceptional_approval';
$route['approve_boq_exceptional_approval'] ='upload_boq_items/upload_boq_items_controller/approve_boq_exceptional_approval';
$route['view_boq_exceptional_items'] ='upload_boq_items/upload_boq_items_controller/view_boq_exceptional_items';
$route['project_boq_exceptional_items'] ='upload_boq_items/upload_boq_items_controller/project_boq_exceptional_items';
$route['get_boq_final_qty'] ='upload_boq_items/upload_boq_items_controller/get_boq_final_qty';
$route['get_consignee_list'] ='upload_boq_items/upload_boq_items_controller/get_consignee_list';
$route['approved_delivery_challan'] ='upload_boq_items/upload_boq_items_controller/approved_delivery_challan';
$route['get_boq_avl_stock'] ='upload_boq_items/upload_boq_items_controller/get_boq_avl_stock';
$route['get_boq_installed_provisional_qty'] ='upload_boq_items/upload_boq_items_controller/get_boq_installed_provisional_qty';
$route['approved_installed_wip'] ='upload_boq_items/upload_boq_items_controller/approved_installed_wip';
$route['approved_provisional_wip'] ='upload_boq_items/upload_boq_items_controller/approved_provisional_wip';
$route['approved_proforma_invoice'] ='upload_boq_items/upload_boq_items_controller/approved_proforma_invoice';
$route['view_payment_receipt'] ='upload_boq_items/upload_boq_items_controller/view_payment_receipt';
$route['project_taxinvc_payment_receipts'] ='upload_boq_items/upload_boq_items_controller/project_taxinvc_payment_receipts';
$route['approved_tax_invoice'] ='upload_boq_items/upload_boq_items_controller/approved_tax_invoice';
$route['save_invoice_closure'] ='upload_boq_items/upload_boq_items_controller/save_invoice_closure';
$route['invoice_format'] ='upload_boq_items/upload_boq_items_controller/invoice_format';
$route['edit_boq_exceptional_approval'] ='upload_boq_items/upload_boq_items_controller/edit_boq_exceptional_approval';
$route['get_boq_dc_stock'] ='upload_boq_items/upload_boq_items_controller/get_boq_dc_stock';
$route['edit_delivery_challan'] ='upload_boq_items/upload_boq_items_controller/edit_delivery_challan';
$route['update_client_dc_details'] ='upload_boq_items/upload_boq_items_controller/update_client_dc_details';
$route['get_boq_old_dc_qty'] ='upload_boq_items/upload_boq_items_controller/get_boq_old_dc_qty';
$route['edit_provisional_wip'] ='upload_boq_items/upload_boq_items_controller/edit_provisional_wip';
$route['edit_installed_wip'] ='upload_boq_items/upload_boq_items_controller/edit_installed_wip';
$route['update_installed_wip_details'] ='upload_boq_items/upload_boq_items_controller/update_installed_wip_details';
$route['update_provisional_wip_details'] ='upload_boq_items/upload_boq_items_controller/update_provisional_wip_details';
$route['get_boq_dc_stock_qty'] ='upload_boq_items/upload_boq_items_controller/get_boq_dc_stock_qty';
$route['get_boq_stock'] ='upload_boq_items/upload_boq_items_controller/get_boq_stock';
$route['get_boq_proforma_stock'] ='upload_boq_items/upload_boq_items_controller/get_boq_proforma_stock';
$route['update_proforma_invoice_details'] ='upload_boq_items/upload_boq_items_controller/update_proforma_invoice_details';
$route['get_boq_tax_stock'] ='upload_boq_items/upload_boq_items_controller/get_boq_tax_stock';
$route['get_tax_invoice_by_projects'] ='upload_boq_items/upload_boq_items_controller/get_tax_invoice_by_projects';
$route['update_tax_invoice_details'] ='upload_boq_items/upload_boq_items_controller/update_tax_invoice_details';
$route['approved_boq_details'] ='upload_boq_items/upload_boq_items_controller/approved_boq_details';
$route['delete_boq_details'] ='upload_boq_items/upload_boq_items_controller/delete_boq_details';
$route['get_approved_boq_item_details'] ='upload_boq_items/upload_boq_items_controller/get_approved_boq_item_details';
$route['get_boq_transaction_list'] ='upload_boq_items/upload_boq_items_controller/get_boq_transaction_list';
$route['project_boq_trans_list_display'] ='upload_boq_items/upload_boq_items_controller/project_boq_trans_list_display';
$route['get_boq_item_amount'] ='upload_boq_items/upload_boq_items_controller/get_boq_item_amount';
$route['get_stock_details'] ='upload_boq_items/upload_boq_items_controller/get_stock_details';
$route['get_exist_dc_boq_item_details'] ='upload_boq_items/upload_boq_items_controller/get_exist_dc_boq_item_details';
$route['get_wip_boq_item'] ='upload_boq_items/upload_boq_items_controller/get_wip_boq_item';
$route['get_tax_boq_item_details'] ='upload_boq_items/upload_boq_items_controller/get_tax_boq_item_details';

$route['get_all_item_list'] ='upload_boq_items/upload_boq_items_controller/get_all_item_list';

$route['test'] ='upload_boq_items/upload_boq_items_controller/test';
























