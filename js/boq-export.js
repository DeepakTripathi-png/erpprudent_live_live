$(document).ready(function() {
    var base_url = $('#base_url').val().trim();
    var download_title = 'BOQ Item List';
    var download_title_boqlist = "Mapping BOQ Items";
    var recordsPerPage = 10; 
    var BoqItemdataTable = $('#pboqlist').DataTable({
	    "dom": 'Bfrtip',
        "lengthMenu": [
            [25, 50, 75, 100, 125,150, -1],
            [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
        ],
        // rowCallback: function (row, data) {
        //     if (data[1] == '') {
        //         $(row).addClass('bg-green');
        //     }
        // },
        "buttons": [
            'pageLength',
            {
                "extend": 'excel',
                "filename": download_title,
                'title':'',
                "exportOptions": {
                    "columns": [0,1,2,3,4,5,6,7,8,9]
                },
                "footer": true,
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                
                    // Set background color for cells in column D
                    $('row c[r^="D"]', sheet).each(function () {
                        $(this).attr('s', '55');
                    });
                    
                    $('row', sheet).each(function(x) {
                        if ($('c[r=C'+x+'] t', sheet).text() === 'London') {
                            $('row:nth-child('+x+') c', sheet).attr('s', '39');
                        }
                    });
                                
                }
            },
        ],
        "bAutoWidth": false,
        "oLanguage": {
        "sEmptyTable": "No BOQ Items Available!"
        },
        "paging": false,
		"iDisplayLength": 25,
        "deferRender": true,
        "responsive": true,
        "processing": true,
		"serverSide": false,
        "ordering": true,
    });

    var clientboqlist = $('#clientboqlist').DataTable({
	    "dom": 'Bfrtip',
        "lengthMenu": [
            [25, 50, 75, 100, 125,150, -1],
            [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
        ],
        ajax: {
			url: base_url + "project_boq_item_list_mapping",
			type: "POST",
			data: {
				project_id: $("#project_id").val(),
			},
		},
        customize: function(xlsx) {
            var sheet = xlsx.xl.worksheets['sheet1.xml'];
        
            // Set background color for cells in column D
            $('row c[r^="E"]', sheet).each(function () {
                $(this).attr('s', '55');
            });
        },
        "buttons": [
            'pageLength',
            {
                "extend": 'excel',
                "filename": download_title_boqlist,
                'title':'',
                "exportOptions": {
                    "columns": [1,2,3,4]
                },
                "footer": true,
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    // Set background color for cells in column D
                    $('row c[r^="D"]', sheet).each(function () {
                        $(this).attr('s', '55');
                    });
                }
            },
        ],
        "bAutoWidth": false,
        "oLanguage": {
        "sEmptyTable": "No BOQ Items Available!"
        },
        "paging": true,
		"iDisplayLength": 25,
        "deferRender": true,
        "responsive": true,
        "processing": true,
		"serverSide": false,
        "ordering": true,
        order: [[1, 'asc']]
    });

    $(document).on('change', '#project_id', function() {
        var project_id = $(this).val();
        if(project_id){
            var url = base_url+"project_boq_item_list_export";
            url += "?project_id=" + project_id;
            BoqItemdataTable.ajax.url(url).load();

            if($('#clientboqlist').length) {
                var url = base_url+"project_boq_item_list_mapping";
                url += "?project_id=" + project_id;
                clientboqlist.ajax.url(url).load();
            }
        }
    });

    $('#exportButton').on('click', function () {
        const status = $("#exportboq").valid();
        var type = $("#type").val();

        if(type == 1) {
            if (status == true) {
                $('#clientboqlistshowbom .buttons-excel').click();
            }
        } else {
            if (status == true) {
                $('#clientboqlistshow .buttons-excel').click();
            }
        }
    });

});

$('.type').select2({
    // data: data.users,
    // placeholder: 'search',
    // search: false,
    minimumResultsForSearch: -1

    // query with pagination
    // query: function(q) {
    //   var pageSize,
    //     results,
    //     that = this;
    //   pageSize = 20; // or whatever pagesize
    //   results = [];
    //   if (q.term && q.term !== '') {
    //     // HEADS UP; for the _.filter function i use underscore (actually lo-dash) here
    //     results = _.filter(that.data, function(e) {
    //       return e.text.toUpperCase().indexOf(q.term.toUpperCase()) >= 0;
    //     });
    //   } else if (q.term === '') {
    //     results = that.data;
    //   }
    //   q.callback({
    //     results: results.slice((q.page - 1) * pageSize, q.page * pageSize),
    //     more: results.length >= q.page * pageSize,
    //   });
    // },
  });
    