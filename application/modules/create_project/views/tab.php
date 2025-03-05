
<ul class="nav nav-tabs prudent-tab-list" id="prudent-tab-list" role="tablist">
    <li class="nav-item <?php if($type== 1 || empty($type)) {?> active <?php }?>" role="presentation">
        <a class="nav-link border-0 prudent-tab" data-toggle="tab" data-tab-index="1" data-project-code="<?php echo base64_encode($project_id); ?>" href="#">BOQ</a>
    </li>
    
    <li class="nav-item border-0 <?php if($type== 2) {?> active <?php }?>" role="presentation">
        <a class="nav-link prudent-tab"  data-toggle="tab" data-tab-index="2" data-project-code="<?php echo base64_encode($project_id); ?>" href="#">BOM</a>
    </li>
</ul>