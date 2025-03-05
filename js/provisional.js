var project_id = $('#project_id').val().trim(); 

var base_url = $('#base_url').val().trim(); 

var download_title = 'Provisional WIP';

$(document).on('change', '#project_id', function() {

        var project_id = $(this).val();

        if(project_id){

            $('#displayVcIWIPItem').show();

            $('#clientdcpwipitemdisplay').DataTable({

            	    "bAutoWidth": false,

            	    "bDestroy" : true,

            	    "bInfo" : false,

            	    "ordering": false,

            	    "searching":false,

            	    "paging": false,

            		"deferRender": true,

                    "responsive": false,

                    "processing": true,

            		"serverSide": true,

                    "order": [],

                    "ajax": {

                        "url": base_url+"get_dcpwip_item_by_project",

                        "type": "POST",

                        "data":{project_id:project_id}

                    },

                    "columnDefs": [{ 

                        "targets": [0,1,2,3,4,5],

                        "orderable": false

                    }]

            });    

        }else{

            

        }

    });

    $('#pwiplist').DataTable({

	// Processing indicator

		"scrollX": true,

		"dom": 'Bfrtip',

                    "lengthMenu": [

                        [25, 50, 75, 100, 125,150, -1],

                        [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]

                    ],

                    "buttons": [

                        'pageLength',

                        {

                            "extend": 'copy',

                            "exportOptions": {

                                "columns": [0,1,2,3,4,5]

                            },

                            "title": download_title,

                            "footer": true

                        },

                        // {

                        //     "extend": 'csv',

                        //     "exportOptions": {

                        //         "columns": [0,1,2,3,4,5]

                        //     },

                        //     "title": download_title,

                        //     "footer": true

                        // },

                        {

                            "extend": 'excel',

                            "exportOptions": {

                                "columns": [0,1,2,3,4,5]

                            },

                            "title": download_title,

                            "footer": true

                        },

                        {

                            "extend": 'pdf',

                            "exportOptions": {

                                "columns": [0,1,2,3,4,5]

                            },

                            "title": download_title,

                            "footer": true

                        },

                        {

                            "extend": 'print',

                            "exportOptions": {

                                "columns": [0,1,2,3,4,5]

                            },

                            "title": download_title,

                            "footer": true

                        }

                    ],

                    "bAutoWidth": false,

		"oLanguage": {

            "sEmptyTable": "No Provisional WIP Available!"

        },

        "paging": true,

		 "iDisplayLength": 25,

         "deferRender": true,

         "responsive": false,

        "processing": true,

		"serverSide": false,

        // Initial no order.

        "order": [],

		

        // Load data from an Ajax source

        "ajax": {

            "url": base_url+"project_dcpwip_list",

            "type": "POST"

        },

		

        //Set column definition initialisation properties

        "columnDefs": [{ 

            "targets": [0,2,3,4,6],

            "orderable": false

        }]

    } );