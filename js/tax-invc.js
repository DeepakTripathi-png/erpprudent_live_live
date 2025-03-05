$(document).on('click', '.date1', function() {

    $('.date1').datepicker({

        orientation: "right",

        autoclose: true

    });

});

var base_url = $('#base_url').val().trim();

var project_id = $('#project_id').val().trim();

var download_title = 'Tax Invoice';

$(document).on('change', '#project_id', function() {

        var gst_type = $('#gst_type').val();



            if (gst_type === '' || gst_type === null) {

                $('#displayTaxInvc').hide();

                $('#invaliderrorgst').html('Please Select Gst Type!');

                return;

            }



            var project_id = $('#project_id').val();

            if(gst_type == 'igst'){

                if (project_id) {

                $('#invaliderrorgst').html('');

                $('#displayProformaInvc').show();

                $('#displayperfomaInvccgst').hide();

                $('#proformainvcdisplay').DataTable({

                    "bAutoWidth": false,

                    "bDestroy": true,

                    "bInfo": false,

                    "ordering": false,

                    "searching": false,

                    "paging": false,

                    "deferRender": true,

                    "responsive": false,

                    "processing": true,

                    "serverSide": true,

                    "order": [],

                    "ajax": {

                        "url": base_url+"get_tax_invoice_by_projects",

                        "type": "POST",

                        "data": {

                            project_id: project_id,

                            gst_type: gst_type

                        }

                    },

                    "columnDefs": [{

                        "targets": [0],

                        "orderable": false

                    }]

                });

            } else {

          }



            }else{



                if (project_id) {

                $('#invaliderrorgst').html('');

                $('#displayProformaInvc').hide();

                $('#displayperfomaInvccgst').show();

                $('#taxperfomadisplaysgsts').DataTable({

                    "bAutoWidth": false,

                    "bDestroy": true,

                    "bInfo": false,

                    "ordering": false,

                    "searching": false,

                    "paging": false,

                    "deferRender": true,

                    "responsive": false,

                    "processing": true,

                    "serverSide": true,

                    "order": [],

                    "ajax": {

                        "url": base_url+"get_tax_invoice_by_projects",

                        "type": "POST",

                        "data": {

                            project_id: project_id,

                            gst_type: gst_type

                        }

                    },

                    "columnDefs": [{

                        "targets": [0],

                        "orderable": false

                    }]

                });

            } else {

        }

            }

 

        });

        $(document).on('change', '#gst_type', function() {



            var gst_type = $('#gst_type').val();



            if (gst_type === '' || gst_type === null) {

                $('#displayTaxInvc').hide();

                $('#invaliderrorgst').html('Please Select Gst Type!');

                return;

            }



            var project_id = $('#project_id').val();

            if(gst_type == 'igst'){

                if (project_id) {

                $('#invaliderrorgst').html('');

                $('#displayProformaInvc').show();

                $('#displayperfomaInvccgst').hide();

                $('#proformainvcdisplay').DataTable({

                    "bAutoWidth": false,

                    "bDestroy": true,

                    "bInfo": false,

                    "ordering": false,

                    "searching": false,

                    "paging": false,

                    "deferRender": true,

                    "responsive": false,

                    "processing": true,

                    "serverSide": true,

                    "order": [],

                    "ajax": {

                        "url": base_url+"get_tax_invoice_by_projects",

                        "type": "POST",

                        "data": {

                            project_id: project_id,

                            gst_type: gst_type

                        }

                    },

                    "columnDefs": [{

                        "targets": [0],

                        "orderable": false

                    }]

                });

            } else {

          }



            }else{



                if (project_id) {

                $('#invaliderrorgst').html('');

                $('#displayProformaInvc').hide();

                $('#displayperfomaInvccgst').show();

                $('#taxperfomadisplaysgsts').DataTable({

                    "bAutoWidth": false,

                    "bDestroy": true,

                    "bInfo": false,

                    "ordering": false,

                    "searching": false,

                    "paging": false,

                    "deferRender": true,

                    "responsive": false,

                    "processing": true,

                    "serverSide": true,

                    "order": [],

                    "ajax": {

                        "url": base_url+"get_tax_invoice_by_projects",

                        "type": "POST",

                        "data": {

                            project_id: project_id,

                            gst_type: gst_type

                        }

                    },

                    "columnDefs": [{

                        "targets": [0],

                        "orderable": false

                    }]

                });

            } else {

        }

            }

        });

        $('#taxInvclist').DataTable({

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

                                "columns": [0,1,2,3,4,5,6,7,8]

                            },

                            "title": download_title,

                            "footer": true

                        },

                        // {

                        //     "extend": 'csv',

                        //     "exportOptions": {

                        //         "columns": [0,1,2,3,4,5,6,7,8]

                        //     },

                        //     "title": download_title,

                        //     "footer": true

                        // },

                        {

                            "extend": 'excel',

                            "exportOptions": {

                                "columns": [0,1,2,3,4,5,6,7,8]

                            },

                            "title": download_title,

                            "footer": true

                        },

                        {

                            "extend": 'pdf',

                            "exportOptions": {

                                "columns": [0,1,2,3,4,5,6,7,8]

                            },

                            "title": download_title,

                            "footer": true

                        },

                        {

                            "extend": 'print',

                            "exportOptions": {

                                "columns": [0,1,2,3,4,5,6,7,8]

                            },

                            "title": download_title,

                            "footer": true

                        }

                    ],

            	    "bAutoWidth": false,

                  "oLanguage": {

                "sEmptyTable": "No Tax Invoice Available!"

            },

            "scrollX": true,

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

                "url": base_url+"project_taxInvc_list",

                "type": "POST"

            },



            //Set column definition initialisation properties

            "columnDefs": [{

                "targets": [0,2,3,4,6,7,8,9],

                "orderable": false

            }]

        });

    