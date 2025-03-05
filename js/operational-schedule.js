var project_id = $('#project_id').val().trim(); 
var base_url = $('#base_url').val().trim();
var download_title_a = 'Operable Schedule A';
var download_title_b = 'Operable Schedule B Positive';
var download_title_bn = 'Operable Schedule B Negative';
var download_title_c = 'Operable Schedule C';
$('#pboqscha').DataTable({
    "scrollX": true,
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
            "title": download_title_a,
            "footer": true
        },
        // {
        //     "extend": 'csv',
        //     "title": download_title_a,
        //     "footer": true
        // },
        {
            "extend": 'excel',
            "title": download_title_a,
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
            "title": download_title_a,
            "footer": true
        },
        {
            "extend": 'print',
            "title": download_title_a,
            "footer": true
        },
        {
            'text': 'Release Schedule A Qty',
            'className': 'btn-release green js-release-qty',
            "footer": true,
            attr:  {
                type: 'A',
            }
        },
       
    ],
	"paging": true,
	"iDisplayLength": 25,
    "deferRender": true,
    "responsive": false,
    "processing": true,
	"serverSide": true,
   // "order": [],
    order: [[1, 'asc']],
	// Load data from an Ajax source
    "ajax": {
        "url": base_url+"boq_scha_list_display",
        "type": "POST",
        "data":{project_id:project_id}
    },
     "columnDefs": [{ 
         "targets": [0,3,4,5],
        "orderable": false
    },
    { 
        "targets": [4,5,6,7,8,9,10],
        "orderable": false,
        "className": "text-right"
    }],
    "footerCallback": function (row, data, start, end, display) {
        var api = this.api();
        if (api.page.info().page === (api.page.info().pages - 1)) {
            $('.operable_a_footer').show();
        }else{
            $('.operable_a_footer').hide();
        }
    }
});

   
$('.nav-tabs a').on('shown.bs.tab', function (e) {
    e.preventDefault();
    const tabIndex = $(this).attr('data-tab-index');
    if(tabIndex == 2) {
        if ( $.fn.dataTable.isDataTable( '#pboqschb' ) ) {
            table = $('#pboqschb').DataTable();
        } else {
            $('#pboqschb').DataTable({
                "scrollX": true,
                scrollY: 400,
                scrollX: true,
                scroller: true,
                fixedHeader: {
                    header: true,
                    footer: true
                },
                "dom": 'Bfrtip',
                "lengthMenu": [
                    [25, 50, 75, 100, 125,150, -1],
                    [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
                ],
                "buttons": [
                    'pageLength',
                    {
                        "extend": 'copy',
                        "title": download_title_b,
                        "footer": true
                    },
                    // {
                    //     "extend": 'csv',
                    //     "title": download_title_b,
                    //     "footer": true
                    // },
                    {
                        "extend": 'excel',
                        "title": download_title_b,
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
                        "title": download_title_b,
                        "footer": true
                    },
                    {
                        "extend": 'print',
                        "title": download_title_b,
                        "footer": true
                    },
                    {
                        'text': 'Release Qty',
                        'className': 'btn-release green js-release-qty',
                        "footer": true,
                        attr:  {
                            type: 'B',
                        }
                    },
                 
                ],
                // Processing indicator
                    "paging": true,
                     "iDisplayLength": 25,
                     "deferRender": true,
                     "responsive": false,
                    "processing": true,
                    "serverSide": true,
                    // Initial no order.
                    // "order": [],
                    order: [[1, 'asc']],
                    
                    // Load data from an Ajax source
                    "ajax": {
                        "url": base_url+"boq_schb_list_display",
                        "type": "POST",
                        "data":{project_id:project_id}
                    },
                    "columnDefs": [{ 
                         "targets": [0,3,4,5],
                        "orderable": false
                    },
                    { 
                        "targets": [4,5,6,7,8,9,10,11],
                        "orderable": false,
                        "className": "text-right"
                    }],
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api();
                        if (api.page.info().page === (api.page.info().pages - 1)) {
                            $('.operable_b_footer').show();
                        }else{
                            $('.operable_b_footer').hide();
                        }
                    }
            });
        }
    } else if(tabIndex ==3) {
        if ( $.fn.dataTable.isDataTable( '#pboqschbn' ) ) {
            table = $('#pboqschbn').DataTable();
        } else {
            $('#pboqschbn').DataTable({
                "scrollX": true,
                scrollY: 400,
                scrollX: true,
                scroller: true,
                fixedHeader: {
                    header: true,
                    footer: true
                },
                "dom": 'Bfrtip',
                "lengthMenu": [
                    [25, 50, 75, 100, 125,150, -1],
                    [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
                ],
                "buttons": [
                    'pageLength',
                    {
                        "extend": 'copy',
                        "title": download_title_bn,
                        "footer": true
                    },
                    // {
                    //     "extend": 'csv',
                    //     "title": download_title_bn,
                    //     "footer": true
                    // },
                    {
                        "extend": 'excel',
                        "title": download_title_bn,
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
                        "title": download_title_bn,
                        "footer": true
                    },
                    {
                        "extend": 'print',
                        "title": download_title_bn,
                        "footer": true
                    },
                    {
                        'text': 'Release Qty',
                        'className': 'btn-release green js-release-qty',
                        "footer": true,
                        attr:  {
                            type: 'B-',
                        }
                    },
                ],
                "paging": true,
                "iDisplayLength": 25,
                "deferRender": true,
                "responsive": false,
                "processing": true,
                "serverSide": true,
                order: [[1, 'asc']],
                // "order": [],
                "ajax": {
                        "url": base_url+"boq_schbn_list_display",
                        "type": "POST",
                        "data":{project_id:project_id},
                        'dataSrc':function(result) {
                            if(result.boq_approval_pending && result.boq_approval_pending!='' && result.boq_approval_pending.length >= 0) {
                                const boqCode = result.boq_approval_pending.join(',')
                                $('#invaliderrorid').html('BOQ Exceptinal Pending for BOQ Sr No ('+boqCode+' )');
                            } else {
                                $('#invaliderrorid').html('');
                            }
                            return result.data;  
                        },
                    },
                    "columnDefs": [{ 
                        "targets": [0,3,4,5],
                        "orderable": false
                    },
                    { 
                        "targets": [4,5,6,7,8,9,10,11],
                        "orderable": false,
                        "className": "text-right"
                    }],
                    "footerCallback": function (row, data, start, end, display) {
                        // console.log(arguments);
                        var api = this.api();
                        if (api.page.info().page === (api.page.info().pages - 1)) {
                            $('.operable_bn_footer').show();
                        }else{
                            $('.operable_bn_footer').hide();
                        }
                    }
            });
        }
    } else if(tabIndex == 4) {
        if ( $.fn.dataTable.isDataTable( '#pboqschc' ) ) {
            table = $('#pboqschbn').DataTable();
        } else {
        $('#pboqschc').DataTable({
            "scrollX": true,
            scrollY: 400,
            scrollX: true,
            scroller: true,
            fixedHeader: {
                header: true,
                footer: true
            },
            "dom": 'Bfrtip',
            "lengthMenu": [
                [25, 50, 75, 100, 125,150, -1],
                [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
            ],
            "buttons": [
                'pageLength',
                {
                    "extend": 'copy',
                    "title": download_title_c,
                    "footer": true
                },
                // {
                //     "extend": 'csv',
                //     "title": download_title_c,
                //     "footer": true
                // },
                {
                    "extend": 'excel',
                    "title": download_title_c,
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
                    "title": download_title_c,
                    "footer": true
                },
                {
                    "extend": 'print',
                    "title": download_title_c,
                    "footer": true
                },
                {
                    'text': 'Release Qty',
                    'className': 'btn-release green js-release-qty',
                    "footer": true,
                    attr:  {
                        type: 'C',
                    }
                },
            ],
            "paging": true,
                 "iDisplayLength": 25,
                 "deferRender": true,
                 "responsive": false,
                "processing": true,
                "serverSide": true,
                // Initial no order.
              //  "order": [],
              order: [[1, 'asc']],
                // Load data from an Ajax source
                "ajax": {
                    "url": base_url+"boq_schc_list_display",
                    "type": "POST",
                    "data":{project_id:project_id}
                },
                
                "columnDefs": [{ 
                     "targets": [0,3,4,5],
                    "orderable": false
                },
                { 
                    "targets": [4,5,6,7,8,9],
                    "orderable": false,
                    "className": "text-right"
                }],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();
                    if (api.page.info().page === (api.page.info().pages - 1)) {
                        $('.operable_c_footer').show();
                    }else{
                        $('.operable_c_footer').hide();
                    }
                }
        });
        }
    }
}); 



$(document).on('click','.js-release-qty',function(){   
    const type = $(this).attr('type');
    var type_encode = btoa(type);
    // console.log('a');
    location.href = base_url +'release-bom-qty/'+project_id+'/'+type_encode;
});
