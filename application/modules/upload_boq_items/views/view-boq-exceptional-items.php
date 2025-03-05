 <div id="ClientDcItemList">
    <input type="hidden" id="exceptional_id" value="<?php echo base64_encode($exceptional_id); ?>">
    <input type="hidden" id="view_exceptional_no" value="<?php echo $view_exceptional_no; ?>">
    <table width="100%" id="boqexceptnitemlist" class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Sr. No</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">BOQ Sr No</th>
                 <th style="min-width: 150px;width:150px;font-size:13px;">Item Description</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Unit</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">EA Qty</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Basic <br> Rate</th>
                 <!-- <th style="min-width: 50px;width:50px;font-size:13px;">Build<br> Amount<br>(Basic)</th> -->
                 <th style="min-width: 50px;width:50px;font-size:13px;">GST<br> Rate(%)</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">GST<br> Amount</th>
                 <th style="min-width: 50px;width:50px;font-size:13px;">Build<br> Amount<br>(GST)</th>

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
    var exceptional_id = $('#exceptional_id').val().trim(); 
    var view_exceptional_no = $('#view_exceptional_no').val().trim(); 
    var recordsPerPage = 10; 
    var download_title = view_exceptional_no+' BOQ Exceptional Approval BOQ Item';
    $('#boqexceptnitemlist').DataTable({
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
                                "columns": [0,1,2,3,4,5,6,7,8]
                            },
                            "footer": true
                        },
                        // {
                        //     "extend": 'csv',
                        //     "title": download_title,
                        //     "exportOptions": {
                        //         "columns": [0,1,2,3]
                        //     },
                        //     "footer": true
                        // },
                        {
                            "extend": 'excel',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7,8]
                            },
                            "footer": true,
                            customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row c[r^="C"]', sheet).each( function () {
                                $(this).attr( 's', '55' );
                            });
            }
                        },
                        {
                            "extend": 'pdf',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7,8]
                            },
                            "footer": true
                        },
                        {
                            "extend": 'print',
                            "title": download_title,
                            "exportOptions": {
                                "columns": [0,1,2,3,4,5,6,7,8]
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
        "order": [[1, 'asc']],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; 
                    var indexOnPage = iDisplayIndexFull % recordsPerPage; 
                    var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;
    
                    $("td:eq(0)", nRow).text(serialNumber); 
                    aData[0] = serialNumber; 
                },
		"ajax": {
            "url": "<?php echo base_url('project_boq_exceptional_items'); ?>",
            "type": "POST",
            "data":{exceptional_id:exceptional_id}
        },
        "columnDefs": [{ 
            "targets": [0,2,3],
            "orderable": false
        }]
    });
</script>