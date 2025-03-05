 <div id="ClientDcItemList">
    <input type="hidden" id="vs_id" value="<?php echo base64_encode($vs_id); ?>">
    <table width="100%" id="dcvsitemlist" class="table table-striped table-bordered table-hover">
        <thead>
             <tr>
                 <th style="min-width: 30px;width:30px;font-size:13px;">Sr No</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">BOQ Sr No</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">HSN/SAC Code</th>
                 <th style="min-width: 450px;width:450px;font-size:13px;">Item Description</th>
                 <th style="min-width: 80px;width:80px;font-size:13px;">Unit</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Avl.<br>Qty</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Stock<br> Qty</th>
            </tr>
        </thead>
    </table>
</div>
<style>
    .modal-footer{
        display:none;
    }
    .modal-dialog{
        width:80%;
    }
</style>
<script>
    var vs_id = $('#vs_id').val().trim(); 
    $('#dcvsitemlist').dataTable({
	    "bDestroy" : true,
	    "paging": true,
		"iDisplayLength": 10,
        "deferRender": true,
        "responsive": true,
        "processing": true,
		"serverSide": true,
        "order": [],
		"ajax": {
            "url": "<?php echo base_url('project_dcvs_items'); ?>",
            "type": "POST",
            "data":{vs_id:vs_id}
        },
        "columnDefs": [{ 
            "targets": [0],
            "orderable": false
        }]
    });
</script>