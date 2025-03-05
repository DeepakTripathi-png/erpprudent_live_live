<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['add-bom-items'] ='upload_bom_items/upload_bom_items_controller/add_bom_items';
$route['get_boq_item_info'] ='upload_bom_items/upload_bom_items_controller/get_boq_item_details';
$route['save_bom_item_details'] ='upload_bom_items/upload_bom_items_controller/save_bom_item_details';
$route['export-boq-items'] ='upload_bom_items/upload_bom_items_controller/export_boq_items';
$route['project_boq_item_list_export'] ='upload_bom_items/upload_bom_items_controller/project_boq_item_list_export';
$route['upload-bom-items'] ='upload_bom_items/upload_bom_items_controller/upload_bom_items';
$route['publish_bom_items_bulk_upload'] ='upload_bom_items/upload_bom_items_controller/publish_bom_items_bulk_upload';
$route['project_bom_item_list'] ='upload_bom_items/upload_bom_items_controller/project_bom_item_list';
$route['project_bom_boq_item_list'] ='upload_bom_items/upload_bom_items_controller/project_bom_boq_item_list';
$route['get_bom_transaction_list'] ='upload_bom_items/upload_bom_items_controller/get_bom_transaction_list';
$route['view_bom_items'] ='upload_bom_items/upload_bom_items_controller/view_bom_items';
$route['project_bom_trans_list_display'] ='upload_bom_items/upload_bom_items_controller/project_bom_trans_list_display';
$route['approved_bom_details'] ='upload_bom_items/upload_bom_items_controller/approved_bom_details';
$route['edit_bom_items'] ='upload_bom_items/upload_bom_items_controller/edit_bom_items';
$route['get_bom_item_details'] ='upload_bom_items/upload_bom_items_controller/get_bom_item_details';
$route['save_bom_edit_item'] ='upload_bom_items/upload_bom_items_controller/save_bom_edit_item';
$route['check_bom_pending_approvel'] ='upload_bom_items/upload_bom_items_controller/check_bom_pending_approvel';
$route['get_last_design_qty_bom_item'] ='upload_bom_items/upload_bom_items_controller/get_last_design_qty_bom_item';
$route['approve_release_qty'] ='upload_bom_items/upload_bom_items_controller/approve_release_qty';
$route['bom-release-quantity'] ='upload_bom_items/upload_bom_items_controller/bom_release_quantity';
$route['project_bom_boq_release_item_list'] ='upload_bom_items/upload_bom_items_controller/project_bom_boq_release_item_list';
$route['edit_bom_release_items'] ='upload_bom_items/upload_bom_items_controller/edit_bom_release_items';
$route['bom-indent-request'] ='upload_bom_items/upload_bom_items_controller/bom_indent_request';
$route['get_bom_indent_item_by_project'] ='upload_bom_items/upload_bom_items_controller/get_bom_indent_item_by_project';
$route['save_indent_request'] ='upload_bom_items/upload_bom_items_controller/save_indent_request';
$route['approve_indent_request'] ='upload_bom_items/upload_bom_items_controller/approve_indent_request';
$route['get_indent_request_list'] ='upload_bom_items/upload_bom_items_controller/get_indent_request_list';
$route['edit_indent_request'] ='upload_bom_items/upload_bom_items_controller/edit_indent_request';
$route['save_edit_indent_item'] ='upload_bom_items/upload_bom_items_controller/save_edit_indent_item';
$route['project_boq_item_list_mapping'] ='upload_bom_items/upload_bom_items_controller/project_boq_item_list_mapping';

$route['mapping_boq_items'] ='upload_bom_items/upload_bom_items_controller/mapping_boq_items';
$route['boq_items_upload'] ='upload_bom_items/upload_bom_items_controller/boq_items_upload';

$route['release-bom-qty/(:any)/(:any)'] ='upload_bom_items/upload_bom_items_controller/release_bom_qty/$1/$1';
$route['boq_scha_list_display_for_bom_release_qty'] ='upload_bom_items/upload_bom_items_controller/boq_scha_list_display_for_bom_release_qty';
$route['boq_schb_list_display_for_bom_release_qty'] ='upload_bom_items/upload_bom_items_controller/boq_schb_list_display_for_bom_release_qty';
$route['boq_schc_list_display_for_bom_release_qty'] ='upload_bom_items/upload_bom_items_controller/boq_schc_list_display_for_bom_release_qty';
$route['boq_schbn_list_display_for_bom_release_qty'] ='upload_bom_items/upload_bom_items_controller/boq_schbn_list_display_for_bom_release_qty';


$route['release_schedule_a_quantity'] ='upload_bom_items/upload_bom_items_controller/release_schedule_a_quantity';
$route['release_schedule_quantity'] ='upload_bom_items/upload_bom_items_controller/release_schedule_quantity';
$route['check_boq_avl_release_qty'] ='upload_bom_items/upload_bom_items_controller/check_boq_avl_release_qty';
$route['release_schedule_b_negative_quantity'] ='upload_bom_items/upload_bom_items_controller/release_schedule_b_negative_quantity';

$route['check_boq_exceptional_bom_item'] ='upload_bom_items/upload_bom_items_controller/check_boq_exceptional_bom_item';



$route['view-bom/(:any)'] ='upload_bom_items/upload_bom_items_controller/view_bom/$1';
$route['bom-approval-waiting/(:any)'] ='upload_bom_items/upload_bom_items_controller/bom_approval_waiting/$1';
$route['view-bom-release-quantity/(:any)'] ='upload_bom_items/upload_bom_items_controller/view_bom_release_quantity/$1';
$route['view-indent-request/(:any)'] ='upload_bom_items/upload_bom_items_controller/view_bom_indent_request/$1';


$route['save_bom_release_qty_edit_item'] ='upload_bom_items/upload_bom_items_controller/save_bom_release_qty_edit_item';

$route['check_build_qty'] ='upload_bom_items/upload_bom_items_controller/check_build_qty';
$route['check_bom_indent_qty'] ='upload_bom_items/upload_bom_items_controller/check_bom_indent_qty';

$route['clear-test-data'] ='upload_bom_items/upload_bom_items_controller/clear_test_data';
$route['clear_bom_data'] ='upload_bom_items/upload_bom_items_controller/clear_bom_data';


$route['create_purchase_order'] ='upload_bom_items/upload_bom_items_controller/create_purchase_order';
$route['get_all_vendor_list'] ='upload_bom_items/upload_bom_items_controller/get_all_vendor_list';
$route['get_vendor_detail'] ='upload_bom_items/upload_bom_items_controller/get_vendor_detail';
$route['get_all_category'] ='upload_bom_items/upload_bom_items_controller/get_all_category';
$route['get_purchase_order_list'] ='upload_bom_items/upload_bom_items_controller/get_purchase_order_list';
$route['view-purchase-order/(:any)'] ='upload_bom_items/upload_bom_items_controller/view_purchase_order/$1';
$route['get_po_list'] ='upload_bom_items/upload_bom_items_controller/get_po_list';
$route['get_edit_bom_po_item_by_project'] ='upload_bom_items/upload_bom_items_controller/get_edit_bom_po_item_by_project';
$route['get_bom_po_item_by_project'] ='upload_bom_items/upload_bom_items_controller/get_bom_po_item_by_project';
$route['save_po_request'] ='upload_bom_items/upload_bom_items_controller/save_po_request';
$route['edit_save_po_request'] ='upload_bom_items/upload_bom_items_controller/edit_save_po_request';
$route['approved_pruchase_order'] ='upload_bom_items/upload_bom_items_controller/approved_pruchase_order';
$route['get_po_bom_detail'] ='upload_bom_items/upload_bom_items_controller/get_po_bom_detail';


// Vendor PO, PI etc
$route['generate_po_ui'] ='upload_bom_items/upload_bom_items_controller/generate_po_ui';
$route['vendor_proforma_invoice'] ='upload_bom_items/upload_bom_items_controller/vendor_proforma_invoice';
$route['get_vendor_proforma_invoice_list'] ='upload_bom_items/upload_bom_items_controller/get_vendor_proforma_invoice_list';
$route['save_proforma_invovce'] ='upload_bom_items/upload_bom_items_controller/save_proforma_invovce';
$route['vpi_bom_trans_list_display'] ='upload_bom_items/upload_bom_items_controller/vpi_bom_trans_list_display';
$route['get_vendor_pi_bom_detail'] ='upload_bom_items/upload_bom_items_controller/get_vendor_pi_bom_detail';
$route['get_edit_bom_vpi_item_by_project'] ='upload_bom_items/upload_bom_items_controller/get_edit_bom_vpi_item_by_project';
$route['approved_vendor_proforma_invoice'] ='upload_bom_items/upload_bom_items_controller/approved_vendor_proforma_invoice';
$route['edit_save_pi_request'] ='upload_bom_items/upload_bom_items_controller/edit_save_pi_request';
$route['view_vendor_proforma_invoice/(:any)'] ='upload_bom_items/upload_bom_items_controller/view_vendor_proforma_invoice/$1';

// generate po pdf
$route['generate_po_pdf'] ='upload_bom_items/upload_bom_items_controller/generatePo';
// generate vendor perform pdf
$route['generate_vpi_pdf'] ='upload_bom_items/upload_bom_items_controller/generateVendorPIPDF';


//payment_receipt
$route['payment_receipt'] ='upload_bom_items/upload_bom_items_controller/payment_receipt';
$route['save_ppi_payment_receipt_data'] ='upload_bom_items/upload_bom_items_controller/save_ppi_payment_receipt_data';
$route['ppi_payment_receipt'] ='upload_bom_items/upload_bom_items_controller/ppi_payment_receipt';
$route['view_ppi_payment_receipt/(:any)'] ='upload_bom_items/upload_bom_items_controller/view_ppi_payment_receipt/$1';
$route['approved_ppi_payment_receipt'] ='upload_bom_items/upload_bom_items_controller/approved_ppi_payment_receipt';
$route['get_payment_sub_item'] ='upload_bom_items/upload_bom_items_controller/get_payment_sub_item';


// vendor Delivery Challan
$route['vendor_delivery_challan'] ='upload_bom_items/upload_bom_items_controller/vendor_delivery_challan';
$route['save_vendor_delivery_challan_data'] ='upload_bom_items/upload_bom_items_controller/save_vendor_delivery_challan_data';
$route['update_vendor_delivery_challan_data'] ='upload_bom_items/upload_bom_items_controller/update_vendor_delivery_challan_data';
$route['get_update_vendor_delivery_challan_data'] ='upload_bom_items/upload_bom_items_controller/get_update_vendor_delivery_challan_data';
$route['get_vendor_dc_list'] ='upload_bom_items/upload_bom_items_controller/get_vendor_dc_list';
$route['view-vendor-delivery-challan/(:any)'] ='upload_bom_items/upload_bom_items_controller/view_vendor_delivery_challan/$1';
$route['approved_delivery_challan_data'] ='upload_bom_items/upload_bom_items_controller/approved_delivery_challan';
// $route['return_memo'] ='upload_bom_items/upload_bom_items_controller/return_memo';
$route['return_memo_list_by_project_id'] ='upload_bom_items/upload_bom_items_controller/return_memo_list_by_project_id';
$route['generate_vdc_pdf'] ='upload_bom_items/upload_bom_items_controller/generateVendorDCPDF';
$route['get_vdc_bom_detail_for_excel'] ='upload_bom_items/upload_bom_items_controller/get_vdc_bom_detail_for_excel';
$route['generate_payment_receipt_pdf'] ='upload_bom_items/upload_bom_items_controller/generate_payment_receipt_pdf';
$route['get_pr_bom_detail_for_excel'] ='upload_bom_items/upload_bom_items_controller/get_pr_bom_detail_for_excel';
$route['delete_merge_vdc_data'] ='upload_bom_items/upload_bom_items_controller/delete_merge_vdc_data';

//Goods Received Note
$route['goods_received_note'] ='upload_bom_items/upload_bom_items_controller/goods_received_note';
$route['save_grn_data'] ='upload_bom_items/upload_bom_items_controller/save_grn_data';
$route['get_good_received_notes_list'] ='upload_bom_items/upload_bom_items_controller/get_good_received_notes_list';
$route['grn_list_by_project_id'] ='upload_bom_items/upload_bom_items_controller/grn_list_by_project_id';
$route['approved_good_received_notes'] ='upload_bom_items/upload_bom_items_controller/approved_good_received_notes';
$route['grn_bom_trans_list_display'] ='upload_bom_items/upload_bom_items_controller/grn_bom_trans_list_display';
$route['view-grn/(:any)'] ='upload_bom_items/upload_bom_items_controller/view_grn/$1';
$route['get_edit_bom_grn_item_by_project'] ='upload_bom_items/upload_bom_items_controller/get_edit_bom_grn_item_by_project';
$route['update_grn_data'] ='upload_bom_items/upload_bom_items_controller/update_grn_data';
$route['generate_grn_pdf'] ='upload_bom_items/upload_bom_items_controller/generateGoodReceivedNotesPDF';
$route['get_grn_bom_detail'] ='upload_bom_items/upload_bom_items_controller/get_grn_bom_detail';
$route['get_dc_details_by_po_number'] ='upload_bom_items/upload_bom_items_controller/get_dc_details_by_po_number';
$route['merege_vdc_for_grn'] ='upload_bom_items/upload_bom_items_controller/merege_vdc_for_grn';
$route['check_grn_pending_data'] ='upload_bom_items/upload_bom_items_controller/check_grn_pending_data';


// Fore close
$route['fore_close'] ='upload_bom_items/upload_bom_items_controller/fore_close';
$route['get_fore_close_list'] ='upload_bom_items/upload_bom_items_controller/get_fore_close_list';
$route['save_fore_close_data'] ='upload_bom_items/upload_bom_items_controller/save_fore_close_data';
$route['approved_fore_close'] ='upload_bom_items/upload_bom_items_controller/approved_fore_close';
$route['fc_bom_trans_list_display'] ='upload_bom_items/upload_bom_items_controller/fc_bom_trans_list_display';
$route['get_fore_close_bom_detail'] ='upload_bom_items/upload_bom_items_controller/get_fore_close_bom_detail';
$route['get_edit_bom_fc_item_by_project'] ='upload_bom_items/upload_bom_items_controller/get_edit_bom_fc_item_by_project';
$route['generate_fc_pdf'] ='upload_bom_items/upload_bom_items_controller/generateForeClosePDF';
$route['update_fore_close_data'] ='upload_bom_items/upload_bom_items_controller/update_fore_close_data';
$route['get_fore_close_bom_item'] ='upload_bom_items/upload_bom_items_controller/get_fore_close_bom_item';
$route['view-fore-close/(:any)'] ='upload_bom_items/upload_bom_items_controller/view_fore_close/$1';



// PPI To Tax Invoice 
$route['ppi_to_tax_invoice'] ='upload_bom_items/upload_bom_items_controller/ppi_to_tax_invoice';
$route['save_tax_invoice_data'] ='upload_bom_items/upload_bom_items_controller/save_tax_invoice_data';

// create po detail
$route['po_details'] ='upload_bom_items/upload_bom_items_controller/po_details';

//Debit note
$route['debit_note'] ='upload_bom_items/upload_bom_items_controller/debit_note';
$route['return_memo'] ='upload_bom_items/upload_bom_items_controller/debit_note';
$route['get_debit_note_data_for_excel'] ='upload_bom_items/upload_bom_items_controller/get_debit_note_data_for_excel';
$route['generate_debit_note_pdf'] ='upload_bom_items/upload_bom_items_controller/generate_debit_note_pdf';


// Head 
$route['head'] ='upload_bom_items/upload_bom_items_controller/head';
$route['save_head_data'] ='upload_bom_items/upload_bom_items_controller/save_head_data';
$route['delete_head'] ='upload_bom_items/upload_bom_items_controller/delete_head';
$route['get_head_data_by_head_id'] ='upload_bom_items/upload_bom_items_controller/get_head_data_by_head_id';


// Voucher System
$route['voucher'] ='upload_bom_items/upload_bom_items_controller/voucher';
$route['save_voucher_data'] ='upload_bom_items/upload_bom_items_controller/save_voucher_data';
$route['approve_voucher_data'] ='upload_bom_items/upload_bom_items_controller/approve_voucher_data';
$route['edit_voucher_data'] ='upload_bom_items/upload_bom_items_controller/edit_voucher_data';
$route['get_voucher_data_for_excel'] ='upload_bom_items/upload_bom_items_controller/get_voucher_data_for_excel';
$route['generate_voucher_pdf'] ='upload_bom_items/upload_bom_items_controller/generate_voucher_pdf';
$route['get_office_head_data'] ='upload_bom_items/upload_bom_items_controller/get_office_head_data';
$route['get_bom_code_data'] ='upload_bom_items/upload_bom_items_controller/get_bom_code_data';
$route['get_all_bom_code_by_project_id'] ='upload_bom_items/upload_bom_items_controller/get_all_bom_code_by_project_id';
$route['get_bom_code_data_by_code'] ='upload_bom_items/upload_bom_items_controller/get_bom_code_data_by_code';


// transaction
$route['voucher_transaction'] ='upload_bom_items/upload_bom_items_controller/voucher_transaction';
$route['get_voucher_head_data'] ='upload_bom_items/upload_bom_items_controller/get_voucher_head_data';
$route['save_voucher_transaction_data'] ='upload_bom_items/upload_bom_items_controller/save_voucher_transaction_data';
$route['approve_voucher_transaction_data'] ='upload_bom_items/upload_bom_items_controller/approve_voucher_transaction_data';
$route['get_voucher_transaction_data_for_excel'] ='upload_bom_items/upload_bom_items_controller/get_voucher_transaction_data_for_excel';
$route['generate_transaction_pdf'] ='upload_bom_items/upload_bom_items_controller/generate_transaction_pdf';
$route['edit_voucher_transaction_data'] ='upload_bom_items/upload_bom_items_controller/edit_voucher_transaction_data';
$route['get_approve_t_voucher_data'] ='upload_bom_items/upload_bom_items_controller/get_approve_t_voucher_data';
$route['get_bom_code'] ='upload_bom_items/upload_bom_items_controller/get_bom_code';
$route['get_voucher_data'] ='upload_bom_items/upload_bom_items_controller/get_voucher_data';
$route['get_voucher_data_type'] ='upload_bom_items/upload_bom_items_controller/get_voucher_data_type';


$route['bom_voucher_transaction'] ='upload_bom_items/upload_bom_items_controller/voucher_transaction';

//Stock Movement
$route['stock_movement'] ='upload_bom_items/upload_bom_items_controller/stock_movement';
$route['stock_list_by_project_id'] ='upload_bom_items/upload_bom_items_controller/stock_list_by_project_id';
$route['save_stock_movement_data'] ='upload_bom_items/upload_bom_items_controller/save_stock_movement_data';
$route['get_stock_movement_list'] ='upload_bom_items/upload_bom_items_controller/get_stock_movement_list';
$route['approved_stock_movement'] ='upload_bom_items/upload_bom_items_controller/approved_stock_movement';
$route['get_update_stock_movement_data'] ='upload_bom_items/upload_bom_items_controller/get_update_stock_movement_data';
$route['update_stock_movement_data'] ='upload_bom_items/upload_bom_items_controller/update_stock_movement_data';
$route['generate_stock_movement_pdf'] ='upload_bom_items/upload_bom_items_controller/generate_stock_movement_pdf';
$route['approve_stock_movement'] ='upload_bom_items/upload_bom_items_controller/approve_stock_movement';
$route['get_stock_movement_data_for_excel'] ='upload_bom_items/upload_bom_items_controller/get_stock_movement_data_for_excel';
$route['sm_item_list_display'] ='upload_bom_items/upload_bom_items_controller/sm_item_list_display';

$route['po_list_by_project_id'] ='upload_bom_items/upload_bom_items_controller/po_list_by_project_id';
$route['vdc_list_by_po_number'] ='upload_bom_items/upload_bom_items_controller/vdc_list_by_po_number';
$route['get_project_bom_code'] ='upload_bom_items/upload_bom_items_controller/get_project_bom_code';
$route['bom_items_by_project_id'] ='upload_bom_items/upload_bom_items_controller/bom_items_by_project_id';
$route['stock_movement_reports'] ='upload_bom_items/upload_bom_items_controller/stock_movement_reports';
$route['get_stock_movement_list_report'] ='upload_bom_items/upload_bom_items_controller/get_stock_movement_list_report';
$route['get_stock_movement_list_by_project_id'] ='upload_bom_items/upload_bom_items_controller/get_stock_movement_list_by_project_id';
$route['get_stock_movement_list_by_to_project_id'] ='upload_bom_items/upload_bom_items_controller/get_stock_movement_list_by_to_project_id';
$route['get_project_bom_code_description'] ='upload_bom_items/upload_bom_items_controller/get_project_bom_code_description';



// BOM Project Expense 
$route['bom_project_expense'] ='upload_bom_items/upload_bom_items_controller/bom_project_expense';
$route['save_bom_project_expense'] ='upload_bom_items/upload_bom_items_controller/save_bom_project_expense';
$route['get_bom_project_expense_data_by_bpe_id'] ='upload_bom_items/upload_bom_items_controller/get_bom_project_expense_data_by_bpe_id';
$route['approve_bom_project_expense'] ='upload_bom_items/upload_bom_items_controller/approve_bom_project_expense';
// $route['project_expense'] ='upload_bom_items/upload_bom_items_controller/project_expense';
$route['project_expense'] ='upload_bom_items/upload_bom_items_controller/bom_project_expense';
$route['get_bom_code_data_by_code'] ='upload_bom_items/upload_bom_items_controller/get_bom_code_data_by_code';


//GRN Report
$route['grn_report'] ='upload_bom_items/upload_bom_items_controller/grn_report';
$route['grn_report_by_project_wise'] ='upload_bom_items/upload_bom_items_controller/grn_report_by_project_wise';


//Grn Payment Receipt or tax invoice
$route['bom_grn_payment_receipt'] ='upload_bom_items/upload_bom_items_controller/bom_grn_payment_receipt';
$route['bom_grn_pr_list'] ='upload_bom_items/upload_bom_items_controller/bom_grn_pr_list';


//write off and right back 
$route['write_off_back'] ='upload_bom_items/upload_bom_items_controller/write_off_back';
$route['get_write_off_back_list'] ='upload_bom_items/upload_bom_items_controller/get_write_off_back_list';
$route['save_write_off_back_data'] ='upload_bom_items/upload_bom_items_controller/save_write_off_back_data';
$route['approve_write_off_back'] ='upload_bom_items/upload_bom_items_controller/approve_write_off_back';



//Debit Note Amount Wise
$route['debit_note_amount_wise'] ='upload_bom_items/upload_bom_items_controller/debit_note_amount_wise';

//Payout 
$route['payout'] ='upload_bom_items/upload_bom_items_controller/payout';
$route['get_all_po_by_project_id'] ='upload_bom_items/upload_bom_items_controller/get_all_po_by_project_id';
$route['get_all_grn_by_po_number'] ='upload_bom_items/upload_bom_items_controller/get_all_grn_by_po_number';
$route['save_payout'] ='upload_bom_items/upload_bom_items_controller/save_payout';
$route['get_payout_list'] ='upload_bom_items/upload_bom_items_controller/get_payout_list';
$route['approve_payout_data'] ='upload_bom_items/upload_bom_items_controller/approve_payout_data';
$route['edit_payout_data'] ='upload_bom_items/upload_bom_items_controller/edit_payout_data';
$route['payout_list_display'] ='upload_bom_items/upload_bom_items_controller/payout_list_display';
$route['payout_selection'] ='upload_bom_items/upload_bom_items_controller/payout_selection';
$route['get_payout_selction_list'] ='upload_bom_items/upload_bom_items_controller/get_payout_selction_list';
$route['save_payout_selection'] ='upload_bom_items/upload_bom_items_controller/save_payout_selection';
$route['get_payout_selection_data_list'] ='upload_bom_items/upload_bom_items_controller/get_payout_selection_data_list';
$route['bank_payment'] ='upload_bom_items/upload_bom_items_controller/bank_payment';
$route['bank_payment_data'] ='upload_bom_items/upload_bom_items_controller/bank_payment_data';
$route['add_utr_no_in_payout_selection'] ='upload_bom_items/upload_bom_items_controller/add_utr_no_in_payout_selection';
$route['get_bank_payment_data_for_excel'] ='upload_bom_items/upload_bom_items_controller/get_bank_payment_data_for_excel';
