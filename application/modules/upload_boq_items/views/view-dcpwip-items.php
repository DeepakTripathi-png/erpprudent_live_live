 <div id="ClientDcItemList">
    <input type="hidden" id="p_wip_no" value="<?php echo base64_encode($p_wip_no); ?>">
    <input type="hidden" id="view_p_wip_no" value="<?php echo $view_p_wip_no; ?>">
    <table width="100%" id="dcpwipitemlist" class="table table-striped table-bordered table-hover">
        <thead>
             <tr>
                 <th style="min-width: 30px;width:30px;font-size:13px;vertical-align: top;">Sr No</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;vertical-align: top;">BOQ<br>Sr No</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;vertical-align: top;">HSN/SAC<br>Code</th>
                 <th style="min-width: 350px;width:350px;font-size:13px;vertical-align: top;">Item Description</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;vertical-align: top;">Unit</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;vertical-align: top;">Stock<br>Qty</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;vertical-align: top;">Prov.<br>Qty</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;vertical-align: top;">Prov.<br>Amount</th>
            </tr>
        </thead>
    </table>
</div>
<style>
    
     .modal-footer {
         display: none;
     }

     .modal-dialog {
         width: 80%;
     }
 </style>
 <script>
    var p_wip_no = $('#p_wip_no').val().trim(); 
    var view_p_wip_no = $('#view_p_wip_no').val().trim();
    var recordsPerPage = 10; 
    var download_title = view_p_wip_no+' Provisional WIP BOQ Item';
    $('#dcpwipitemlist').DataTable({
	    "bAutoWidth": false,
         "dom": 'Bfrtip',
         scrollY: 400,
            scrollX: true,
            scroller: true,
            fixedHeader: {
                header: true,
                footer: true
            },
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
                        // {
                        //     "extend": 'csv',
                        //     "title": download_title,
                        //     "exportOptions": {
                        //         "columns": [0,1,2,3,4,5,6,7]
                        //     },
                        //     "footer": true
                        // },
                        {
                            "extend": 'excel',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7]
                            },
                            "footer": true,
                            customize: function(xlsx) {
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                $('row c[r^="D"]', sheet).each( function () {
                                    $(this).attr( 's', '55' );
                                });
                            }
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
		"serverSide": false,
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; 
                    var indexOnPage = iDisplayIndexFull % recordsPerPage; 
                    var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;
    
                    $("td:eq(0)", nRow).text(serialNumber); 
                    aData[0] = serialNumber; 
                },
        "order": [[1, 'asc']],

		"ajax": {
            "url": "<?php echo base_url('project_dcpwip_items'); ?>",
            "type": "POST",
            "data":{p_wip_no:p_wip_no}
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