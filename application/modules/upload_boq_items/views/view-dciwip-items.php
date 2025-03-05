 <div id="ClientDcItemList">
    <input type="hidden" id="i_wip_no" value="<?php echo base64_encode($i_wip_no); ?>">
    <input type="hidden" id="view_i_wip_no" value="<?php echo base64_encode($view_i_wip_no); ?>">
    <table width="100%" id="dciwipitemlist" class="table table-striped table-bordered table-hover">
        <thead>
             <tr>
                 <th style="min-width: 30px;width:30px;font-size:13px;vertical-align: top;">Sr No</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;vertical-align: top;">BOQ<br>Sr No</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;vertical-align: top;">HSN/SAC<br>Code</th>
                 <th style="min-width: 350px;width:350px;font-size:13px;vertical-align: top;">Item Description</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;vertical-align: top;">Unit</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;vertical-align: top;">Stock<br>Qty</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;vertical-align: top;">Installed<br>Qty</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;vertical-align: top;">Installed<br>Amount</th>
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
    var i_wip_no = $('#i_wip_no').val().trim(); 
    var view_i_wip_no = $('#view_i_wip_no').val().trim(); 
    var download_title = view_i_wip_no+' Installed WIP BOQ Item';
    $('#dciwipitemlist').DataTable({
	    "bAutoWidth": false,
         "dom": 'Bfrtip',
                    "lengthMenu": [
                        [25, 50, 75, 100, 125,150, -1],
                        [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
                    ],
                    "buttons": [
                        'pageLength',
                        {
                            "extend": 'copy',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7]
                            },
                            "footer": true
                        },
                        {
                            "extend": 'csv',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7]
                            },
                            "footer": true
                        },
                        {
                            "extend": 'excel',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7]
                            },
                            "footer": true
                        },
                        {
                            "extend": 'pdf',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7]
                            },
                            "footer": true
                        },
                        {
                            "extend": 'print',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7]
                            },
                            "footer": true
                        }
                    ],
                    "oLanguage": {
                "sEmptyTable": "No BOQ Items Available!"
            },
            "bDestroy" : true,
	    "paging": true,
		"iDisplayLength": 25,
        "deferRender": true,
        "responsive": true,
        "processing": true,
		"serverSide": true,
        "order": [],
		"ajax": {
            "url": "<?php echo base_url('project_dciwip_items'); ?>",
            "type": "POST",
            "data":{i_wip_no:i_wip_no}
        },
        "columnDefs": [{ 
            "targets": [0,2,3,4,5,6,7],
            "orderable": false,
        },
        { 
            "targets": [5,6,7],
            "className": 'text-right'
        }]
    });
</script>