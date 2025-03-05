

<?php
$role_id = $this->session->userdata('role_id');
$current_menu = $this->uri->segment(1);

?>

<div class="page-sidebar-wrapper">
  <div class="page-sidebar md-shadow-z-2-i  navbar-collapse collapse">
    <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
      <li class="start <?php if($current_menu == 'dashboard' ){ echo "active"; } ?>" >
        <a href="<?php echo base_url(); ?>dashboard">
          <i class="icon-home"></i>
          <span class="title">Dashboard</span>
        </a>
      </li>

      <?php $this->load->model('role/role_model');
      $menu_data=$this->role_model->menu_list($role_id);
      $i=0;
      if(isset($menu_data) && !empty($menu_data))
      {
        foreach ($menu_data as $key)
        { $i++;

          $act_menu='';
          $menu=$key['menu'];
          $submenu=$key['submenu'];
          $users_arr = array('role-list','role-management','user-list','add-role','add-user','edit_user');
          $master_arr = array('add-designation','add-tax','add-unit','unit-list','tax-list','designation-list');
          $BOQ_arr = array('payment-receipt-details','boq-exceptional-approval','create-tax-invoice','create-proforma-invoice','add-provisional-wip','add-installed-wip','move-to-warehouse','client-delivery-challan','create-project','create-project-list','upload-boq-items','add-boq-items','list-boq-items','list-boq-items-operational-b','list-boq-items-operational-b-negative','boq-variable-discount','mapping_boq_items');
          $BOM_arr = array('category_list','add-vendor','vendor-list','add-bom-items','export-boq-items','upload-bom-items','bom-release-quantity','bom-indent-request','create_purchase_order','vendor_proforma_invoice','payment_receipt','ppi_payment_receipt','vendor_delivery_challan','return_memo','goods_received_note','fore_close','ppi_to_tax_invoice','po_details','debit_note','voucher','voucher_transaction','stock_movement','head','bom_project_expense','project_expense','bom_voucher_transaction','write_off_back','payout','payout_selection','bank_payment');
          $compliance_arr = array('add-or-view-compliance','pending-compliance');
          $report_arr = array('wip-status-report','stock-wip-report-summary','stock-or-wip-status','stock-movement-reports','stock','grn_report','boq_open_so_report');
          if(in_array($current_menu,$users_arr)){
            $act_menu = 'Users';

          }elseif(in_array($current_menu,$master_arr)){
            $act_menu = 'Masters';
          }elseif(in_array($current_menu,$BOQ_arr)){
            $act_menu = 'BOQ';
          }elseif(in_array($current_menu,$BOM_arr)){
            $act_menu = 'BOM';
          }elseif(in_array($current_menu,$compliance_arr)){
            $act_menu = 'Compliance';
          }elseif(in_array($current_menu,$report_arr)){
            $act_menu = 'Reports';
          }

          ?>

          <li class="<?php if($act_menu == $menu->menu_name){ echo 'open'; }?>">
            <a href="javascript:;">
              <i class="<?php echo(isset($menu->icon) && !empty($menu->icon))?$menu->icon:''; ?>"></i>
              <span class="title"><?php echo(isset($menu->menu_name) && !empty($menu->menu_name))?$menu->menu_name:''; ?></span>
              <span class="arrow "></span>
            </a>

            <ul class="sub-menu" <?php if($act_menu == $menu->menu_name){ echo 'style="display:block;"'; }?>>
              <?php if(isset($submenu) && !empty($submenu))
              { $k=0;
                foreach ($submenu as $row)
                { $k++;?>
                  <?php if(isset($current_menu) && !empty($current_menu) && ($current_menu == 'proforma-invoice' || $current_menu == 'tax-invoice' || $current_menu == 'wip-status' ||
                  $current_menu == 'provisional-wip' || $current_menu == 'installed-wip' || $current_menu == 'warehouse' ||
                  $current_menu == 'project-closure' || $current_menu == 'view-all-reminder' || $current_menu == 'view-all-notification' || $current_menu == 'approval-waiting' ||
                  $current_menu == 'delivery-challan' || $current_menu == 'operational-scheduled' || $current_menu=='view-boq' ||
                  $current_menu == 'boq-transaction' || $current_menu == 'create-project' || $current_menu == 'project-details' || $current_menu=='view-boq-exceptional-approval' || $current_menu=='view-bom' || $current_menu=='view-bom-release-quantity' || $current_menu=='view-indent-request' || $current_menu=='view-purchase-order' ||  $current_menu ==  'view_vendor_proforma_invoice' ||   $current_menu=='view_ppi_payment_receipt' ||   $current_menu=='view-vendor-delivery-challan' || $current_menu=='view-grn'||   $current_menu=='view-fore-close' || $current_menu=='bom-approval-waiting')){
                    $current_menu = 'create-project-list'; }elseif(isset($current_menu) && !empty($current_menu) && ($current_menu=='payment-receipt' || $current_menu == 'invoice-closure'  || $current_menu == 'payment-receipt-details')){
                      $current_menu = 'create-tax-invoice'; }elseif(isset($current_menu) && !empty($current_menu) && ($current_menu == 'add-user' || $current_menu=='edit_user')){
                        $current_menu = 'user-list'; } ?>
                        <li class="<?php if($current_menu == $row->action){ echo "active"; } ?>">
                          <a href="<?php echo base_url();?><?php echo(isset($row->action) && !empty($row->action))?$row->action:'';?>">
                            <i class="<?php echo (isset($row->icon) && !empty($row->icon))?$row->icon:''; ?>"></i>
                            <?php echo(isset($row->submenu_name) && !empty($row->submenu_name))?$row->submenu_name:''; ?></a>
                          </li>
                        <?php }
                      }?>
                    </ul>
                  </li>
                <?php }
              }?>
            </ul>
          
          </div>
        </div>
