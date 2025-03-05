var TableAdvanced = function () {

   
    var initTable = function () 
    {
        var table = $('.masterTable');
        var oTable = table.dataTable({
            "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // datatable layout without  horizobtal scroll
            "deferRender": true,
            "order": [
                [0, 'asc']
            ],
            "lengthMenu": [
                [5, 10, 20,50, -1],
                [5, 10, 20,50, "All"] // change per page values here
            ],
            "pageLength": 10        
        });
    }

    var initdatatable = function () 
    {
        var url=$('.datatable').data('url');
        table = $('.datatable').DataTable({ 
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            "lengthMenu": [
                [10,50,100, -1],
                [10,50,100, "All"] // change per page values here
            ],
            "pageLength": 10,  
            "ajax": {
                "url": completeURL(url),
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
            { 
                "targets": [ 0 ], //first column / numbering column
                "orderable": false, //set not orderable
            },
            ],
        });
        $('.table-responsive').removeClass('table-responsive');        
    }

    if (jQuery().select2) {
        $('.select2').select2(); 
    }



    return {
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            initTable();
            initdatatable();
        }
    };
}();