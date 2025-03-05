<div class="panel-group accordion scrollable prvlege" id="accordion3" >
   <?php 
      if(isset($role_menu_data) && !empty($role_menu_data)){
      
          $menu=$role_menu_data[0]['menu'];
      
      	$submenu=$role_menu_data[0]['submenu'];
      
      	$k=0;
      
      }
      
      if(isset($role_manage_menu_data) && !empty($role_manage_menu_data)){
      
          $menu=$role_manage_menu_data[0]['menu'];
      
      	$submenu1=$role_manage_menu_data[0]['submenu'];
      
      	$k=0;
      
      }
      
      if(isset($users_menu_data) && !empty($users_menu_data)){
      
          $menu=$users_menu_data[0]['menu'];
      
      	$submenu2=$users_menu_data[0]['submenu'];
      
      	$k=0;
      
      }
      
      if(isset($oef_menu_data) && !empty($oef_menu_data)){
      
          $menu1=$oef_menu_data[0]['menu'];
      
      	$submenu3=$oef_menu_data[0]['submenu'];
      
      	$k=1;
      
      }
      
      if(isset($boq_menu_data) && !empty($boq_menu_data)){
      
          $menu1=$boq_menu_data[0]['menu'];
      
      	$submenu4=$boq_menu_data[0]['submenu'];
      
      	$k=1;
      
      }

	 
      
      if(isset($boq_exceptional_menu_data) && !empty($boq_exceptional_menu_data)){
      
          $menu1=$boq_exceptional_menu_data[0]['menu'];
      
      	$submenu5=$boq_exceptional_menu_data[0]['submenu'];
      
      	$k=1;
      
      }
      
      if(isset($dc_menu_data) && !empty($dc_menu_data)){
      
          $menu1=$dc_menu_data[0]['menu'];
      
      	$submenu6=$dc_menu_data[0]['submenu'];
      
      	$k=1;
      
      }
      
      if(isset($iwip_menu_data) && !empty($iwip_menu_data)){
      
          $menu1=$iwip_menu_data[0]['menu'];
      
      	$submenu7=$iwip_menu_data[0]['submenu'];
      
      	$k=1;
      
      }
      
      if(isset($pwip_menu_data) && !empty($pwip_menu_data)){
      
          $menu1=$pwip_menu_data[0]['menu'];
      
      	$submenu8=$pwip_menu_data[0]['submenu'];
      
      	$k=1;
      
      }
      
      if(isset($pinvoice_menu_data) && !empty($pinvoice_menu_data)){
      
          $menu1=$pinvoice_menu_data[0]['menu'];
      
      	$submenu9=$pinvoice_menu_data[0]['submenu'];
      
      	$k=1;
      
      }
      
      if(isset($tinvoice_menu_data) && !empty($tinvoice_menu_data)){
      
          $menu1=$tinvoice_menu_data[0]['menu'];
      
      	$submenu10=$tinvoice_menu_data[0]['submenu'];
      
      	$k=1;
      
      }
      
      if(isset($payment_recpt_menu_data) && !empty($payment_recpt_menu_data)){
      
          $menu1=$payment_recpt_menu_data[0]['menu'];
      
      	$submenu13=$payment_recpt_menu_data[0]['submenu'];
      
      	$k=1;
      
      }
      
      if(isset($invoive_closure_menu_data) && !empty($invoive_closure_menu_data)){
      
          $menu1=$invoive_closure_menu_data[0]['menu'];
      
      	$submenu14=$invoive_closure_menu_data[0]['submenu'];
      
      	$k=1;
      
      }
      
      if(isset($project_closure_menu_data) && !empty($project_closure_menu_data)){
      
          $menu1=$project_closure_menu_data[0]['menu'];
      
      	$submenu15=$project_closure_menu_data[0]['submenu'];
      
      	$k=1;
      
      }

	  if(isset($boq_variable_disc_data) && !empty($boq_variable_disc_data)){
      
		$menu1=$boq_variable_disc_data[0]['menu'];
	
		$submenu16=$boq_variable_disc_data[0]['submenu'];
	
		$k=1;
	
	}
      
      if(isset($compliance_menu_data) && !empty($compliance_menu_data)){
      
          $menu2=$compliance_menu_data[0]['menu'];
      
      	$submenu11=$compliance_menu_data[0]['submenu'];
      
      	$k=1;
      
      }

      if(isset($bom_menu_data) && !empty($bom_menu_data)){
      
         $menu4=$bom_menu_data[0]['menu'];
      
         $submenu17=$bom_menu_data[0]['submenu'];
      
         $k=1;
      
      }
      // if(isset($bom_menu_data) && !empty($bom_menu_data)){
      
      //    $menu4=$bom_menu_data[0]['menu'];
      
      //    $submenu17=$bom_menu_data[0]['submenu'];
      
      //    $k=1;
      
      // }
      
      if(isset($reports_menu_data) && !empty($reports_menu_data)){
      
          $menu3=$reports_menu_data[0]['menu'];
      
      	$submenu12=$reports_menu_data[0]['submenu'];
      
      	$k=1;
      
      }
      
      ?>
   <?php if(isset($menu) && !empty($menu)){ ?>
   <div class="panel panel-default">
      <div class="panel-heading">
         <h4 class="panel-title">
            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_0">
            <?php echo (isset($menu->menu_name) && !empty($menu->menu_name))?$menu->menu_name:''; ?> </a>
         </h4>
      </div>
      <div id="collapse_0" class="panel-collapse in">
         <div class="panel-body">
            <div class="portlet-body">
               <div class="task-content">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu) && !empty($submenu)){ ?>
                     <?php $i=0;foreach($submenu as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">Role Master</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'role-list'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'add-role'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'edit_role'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">EDIT</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'delete_role'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">DELETE</span>
                              <?php } ?>
                           </div>
                           <?php if($i==(count($submenu)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <hr style="margin:5px 0;">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu1) && !empty($submenu1)){ ?>
                     <?php $i=0;foreach($submenu1 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">Role Management</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-4">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'role-management'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">EDIT</span>
                              <?php } ?>
                           </div>
                           <?php if($i==(count($submenu1)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <hr style="margin:5px 0;">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu2) && !empty($submenu2)){ ?>
                     <?php $i=0;foreach($submenu2 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">Team Member</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'user-list'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'add-user'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'edit_user'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">EDIT</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'delete_user'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">DELETE</span>
                              <?php } ?>
                           </div>
                           <?php if($i==(count($submenu2)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <div class="row">
                     <div class="task-title col-md-12">
                        <hr/>
                        <span style="float:left;">
                        <input type="checkbox" class="category_select_all"><span style="vertical-align: top;padding-left: 5px;font-size:12px;">Select All</span>
                        </span>
                        <span style="float:right;">
                        <button class="btn btn-xs green common_save" type="submit">Save</button>
                        </span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php } ?>
   <?php if(isset($menu1) && !empty($menu1)){ ?>
   <div class="panel panel-default">
      <div class="panel-heading">
         <h4 class="panel-title">
            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_1">
            <?php echo (isset($menu1->menu_name) && !empty($menu1->menu_name))?$menu1->menu_name:''; ?> </a>
         </h4>
      </div>
      <div id="collapse_1" class="panel-collapse in">
         <div class="panel-body">
            <div class="portlet-body">
               <div class="task-content">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu3) && !empty($submenu3)){ ?>
                     <?php $i=0;foreach($submenu3 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">OEF Master</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'create-project-list'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'create-project'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'update_create_project'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">EDIT</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'delete_project_details'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">DELETE</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'approved_project_details'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">APPROVE</span>
                              <?php } ?>
                           </div>
                           <?php if($i==(count($submenu3)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <hr style="margin:5px 0;">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu4) && !empty($submenu4)){ ?>
                     <?php $i=0;foreach($submenu4 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">BOQ Items</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3" style="margin:5px 0px;">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChildp" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'upload-boq-items'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'add-boq-items'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'publish_boq_items_bulk_upload'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">UPLOAD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'approved_boq_details'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">APPROVE</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'delete_boq_details'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">DELETE</span>
                              <?php } ?>
                           </div>
                           <?php if($i==(count($submenu4)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <hr style="margin:5px 0;">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu5) && !empty($submenu5)){ ?>
                     <?php $i=0;foreach($submenu5 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">BOQ Exceptional</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'boq-exceptional-approval'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'save_boq_exceptional_approval'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'edit_boq_exceptional_approval'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">EDIT</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'approve_boq_exceptional_approval'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">APPROVE</span>
                              <?php } ?>
                           </div>
                           <?php if($i==(count($submenu5)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <hr style="margin:5px 0;">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu6) && !empty($submenu6)){ ?>
                     <?php $i=0;foreach($submenu6 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">Client Delivery Challan</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'client-delivery-challan'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'save_client_dc_details'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'edit_delivery_challan'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">EDIT</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'approved_delivery_challan'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">APPROVE</span>
                              <?php } ?>
                           </div>
                           <?php if($i==(count($submenu6)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <hr style="margin:5px 0;">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu7) && !empty($submenu7)){ ?>
                     <?php $i=0;foreach($submenu7 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">Installed WIP</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'add-installed-wip'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'save_installed_wip_details'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'edit_installed_wip'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">EDIT</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'approved_installed_wip'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">APPROVE</span>
                              <?php } ?>
                           </div>
                           <?php if($i==(count($submenu7)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <hr style="margin:5px 0;">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu8) && !empty($submenu8)){ ?>
                     <?php $i=0;foreach($submenu8 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">Provisional WIP</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'add-provisional-wip'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'save_provisional_wip_details'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'edit_provisional_wip'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">EDIT</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'approved_provisional_wip'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">APPROVE</span>
                              <?php } ?>
                           </div>
                           <?php if($i==(count($submenu8)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <hr style="margin:5px 0;">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu9) && !empty($submenu9)){ ?>
                     <?php $i=0;foreach($submenu9 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">Proforma Invoice</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3" style="margin:5px 0px;">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'create-proforma-invoice'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'save_proforma_invoice_details'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'edit_proforma_invoice'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">EDIT</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'approved_proforma_invoice'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">APPROVE</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'convert_to_tax_invoice'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">Convert to Tax Invoice</span>
                              <?php } ?>
                           </div>
                           <?php if($i==(count($submenu9)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <hr style="margin:5px 0;">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu10) && !empty($submenu10)){ ?>
                     <?php $i=0;foreach($submenu10 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">Tax Invoice</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'create-tax-invoice'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'save_tax_invoice_details'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'edit_tax_invoice'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">EDIT</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'approved_tax_invoice'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">APPROVE</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'payment-receipt'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">Payment Receipt</span>
                              <?php } ?>
                           </div>
                           <?php if($i==(count($submenu10)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <hr style="margin:5px 0;">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu13) && !empty($submenu13)){ ?>
                     <?php $i=0;foreach($submenu13 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">Payment Receipt</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'view_payment_receipt'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'save_payment_advice'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'edit_payment_advice'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">EDIT</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'approved_payment_advice'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">APPROVE</span>
                              <?php }?>
                           </div>
                           <?php if($i==(count($submenu13)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <hr style="margin:5px 0;">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu14) && !empty($submenu14)){ ?>
                     <?php $i=0;foreach($submenu14 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">Invoice Closure</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'view_invoice_closure'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'save_invoice_closure'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'edit_invoice_closure'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">EDIT</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'approved_invoice_closure'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">APPROVE</span>
                              <?php }?>
                           </div>
                           <?php if($i==(count($submenu14)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <hr style="margin:5px 0;">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu15) && !empty($submenu15)){ ?>
                     <?php $i=0;foreach($submenu15 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">Project Closure</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'view_project_closure'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'save_project_closure'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'edit_project_closure'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">EDIT</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'approved_project_closure'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">APPROVE</span>
                              <?php }?>
                           </div>
                           <?php if($i==(count($submenu15)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
				  <hr style="margin:5px 0;">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu16) && !empty($submenu16)){ ?>
                     <?php $i=0;foreach($submenu16 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">BOQ Variable Discount</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'boq-variable-discount'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'save_boq_variable_discount'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD</span>
                               <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'edit_boq_variable_discount_approval'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">EDIT</span> 
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'approve_boq_variable_discount'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">APPROVE</span>
                              <?php }?>
                           </div>
                           <?php if($i==(count($submenu16)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>

                  

                  <div class="row">
                     <div class="task-title col-md-12">
                        <hr/>
                        <span style="float:left;">
                        <input type="checkbox" class="category_select_all"><span style="vertical-align: top;padding-left: 5px;font-size:12px;">Select All</span>
                        </span>
                        <span style="float:right;">
                        <button class="btn btn-xs green common_save" type="submit">Save</button>
                        </span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php } ?>
   <?php if(isset($menu2) && !empty($menu2)){ ?>
   <div class="panel panel-default">
      <div class="panel-heading">
         <h4 class="panel-title">
            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_2">
            <?php echo (isset($menu2->menu_name) && !empty($menu2->menu_name))?$menu2->menu_name:''; ?> </a>
         </h4>
      </div>
      <div id="collapse_2" class="panel-collapse in">
         <div class="panel-body">
            <div class="portlet-body">
               <div class="task-content">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu11) && !empty($submenu11)){ ?>
                     <?php $i=0;foreach($submenu11 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">Compliance Master</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'add-or-view-compliance'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'Add_View_Compliance'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD/EDIT</span>
                              <?php } ?>
                           </div>
                           <?php if($i==(count($submenu11)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <div class="row">
                     <div class="task-title col-md-12">
                        <hr/>
                        <span style="float:left;">
                        <input type="checkbox" class="category_select_all"><span style="vertical-align: top;padding-left: 5px;font-size:12px;">Select All</span>
                        </span>
                        <span style="float:right;">
                        <button class="btn btn-xs green common_save" type="submit">Save</button>
                        </span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php } ?>
   <?php if(isset($menu3) && !empty($menu3)){ ?>
   <div class="panel panel-default">
      <div class="panel-heading">
         <h4 class="panel-title">
            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3">
            <?php echo (isset($menu3->menu_name) && !empty($menu3->menu_name))?$menu3->menu_name:''; ?> </a>
         </h4>
      </div>
      <div id="collapse_3" class="panel-collapse in">
         <div class="panel-body">
            <div class="portlet-body">
               <div class="task-content">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu12) && !empty($submenu12)){ ?>
                     <?php $i=0;foreach($submenu12 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">Reports</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChild" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;"><?php echo (isset($row->submenu_name) && !empty($row->submenu_name))?ucwords($row->submenu_name):''; ?></span>
                           </div>
                           <?php if($i==(count($submenu12)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <div class="row">
                     <div class="task-title col-md-12">
                        <hr/>
                        <span style="float:left;">
                        <input type="checkbox" class="category_select_all"><span style="vertical-align: top;padding-left: 5px;font-size:12px;">Select All</span>
                        </span>
                        <span style="float:right;">
                        <button class="btn btn-xs green common_save" type="submit">Save</button>
                        </span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php } ?>

   <?php if(isset($menu4) && !empty($menu4)){ ?>
   <div class="panel panel-default">
      <div class="panel-heading">
         <h4 class="panel-title">
            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3">
            <?php echo (isset($menu4->menu_name) && !empty($menu4->menu_name))?$menu4->menu_name:''; ?> </a>
         </h4>
      </div>
      <div id="collapse_3" class="panel-collapse in">
         <div class="panel-body">
            <div class="portlet-body">
               <div class="task-content">
                  <div class="row" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2" style="align-items: center;">
                     <?php if(isset($submenu17) && !empty($submenu17)){ ?>
                     <?php $i=0;foreach($submenu17 as $row){ ?>
                     <?php if($i==0){ ?>
                     <div class="col-md-4">
                        <h6 style="font-size: 13px;font-weight: 600;margin:0">BOM Items</h6>
                     </div>
                     <div class="col-md-8">
                        <div class="row">
                           <?php } ?>
                           <div class="col-md-3" style="margin:5px 0px;">
                              <input type="checkbox" <?php echo (isset($row->prev) && !empty($row->prev) && $row->prev=='Y' )?'checked="checked"':''; ?> class="liChildp" value="<?php echo (isset($row->submenu_id) && !empty($row->submenu_id))?$row->submenu_id:''; ?>" name="submenu[]"/>
                              <?php if(isset($row->action) && !empty($row->action) && $row->action == 'upload-bom-items'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">VIEW</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'add-bom-items'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">ADD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'publish_bom_items_bulk_upload'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">UPLOAD</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'approved_bom_details'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">APPROVE</span>
                              <?php }elseif(isset($row->action) && !empty($row->action) && $row->action == 'delete_bom_details'){ ?>
                              <span class="task-title-sp" style="vertical-align: top;padding-left: 5px;font-size:12px;">DELETE</span>
                              <?php } ?>
                           </div>
                           <?php if($i==(count($submenu17)-1)){ ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php $i++;} } ?>
                  </div>
                  <div class="row">
                     <div class="task-title col-md-12">
                        <hr/>
                        <span style="float:left;">
                        <input type="checkbox" class="category_select_all"><span style="vertical-align: top;padding-left: 5px;font-size:12px;">Select All</span>
                        </span>
                        <span style="float:right;">
                        <button class="btn btn-xs green common_save" type="submit">Save</button>
                        </span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php } ?>

</div>