    var base_url = $('#base_url').val().trim();

    $(document).on('click','.date1',function(){   

        $('.date1').datepicker({

          dateFormat: "dd-mm-yy",

          orientation: "right",

          autoclose: true

        });    

      });

    var download_title = 'Client Delivery Challan';

     var datatable = $('#dcclist').DataTable({

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

            "sEmptyTable": "No Client Delivery Challan Available!"

        },

        "paging": true,

		 "iDisplayLength": 25,

         "deferRender": true,

         "responsive": false,

        "processing": true,

		"serverSide": false,
        "order": [],

        "ajax": {

            "url": base_url+"project_dcc_list",

            "type": "POST"

        },
        "columnDefs": [{ 

            "targets": [0,2,3,4,5,6,7],

            "orderable": false

        }]

    });

$(document).on('change', '#consignee', function() {

    var consignee = $('#consignee').val();

    if(consignee){

        $.ajax({

            type: "POST",

            url: base_url+"get_consignee_detail",

            data: {consignee_id : consignee},

            success: function (response) {

                var res = JSON.parse(response);

                $('#gst_number').val(res.gst_number);

                $('#site_address').val(res.delivery_address); 

            }

        });

    }

});

$(document).on('change', '#project_id', function() {

    var project_id = $(this).val();

    var gst_type = $('#gst_type').val().trim();

    var c_type = $('#c_type').val().trim();

    $('#gst_number').val('');

    $('#site_address').val(''); 

    $('#invaliderrordccid').html('');

    $('#invaliderrordccid1').html('');

    $('#invaliderrordccid2').html('');

    if(project_id !== '' && typeof project_id !== "undefined"){

        $.ajax({

            type: "POST",

            url: base_url+"get_consignee_list",

            data: {project_id : project_id},

            success: function (response) {

                $('#consigneechange').html(response);

                if (jQuery().select2){

                $('#consignee').select2();

                }

            }

        });

    }

    displayRecords(project_id,gst_type,c_type);

});

$(document).on('change', '#gst_type', function() {

    $('#invaliderrordccid').html('');

    $('#invaliderrordccid1').html('');

    $('#invaliderrordccid2').html('');

    var project_id = $('#project_id').val().trim();

    var gst_type = $(this).val().trim();

    var c_type = $('#c_type').val().trim();

    displayRecords(project_id,gst_type,c_type);

});

$(document).on('change', '#c_type', function() {

    $('#invaliderrordccid').html('');

    $('#invaliderrordccid1').html('');

    $('#invaliderrordccid2').html('');

    var project_id = $('#project_id').val().trim();

    var gst_type = $('#gst_type').val().trim();

    var c_type = $(this).val().trim();

    if(c_type == 'delivery_challan'){

        $('#bill_type_div').hide();

        $('#challan_name').html('DELIVERY CHALLAN');

    }else{

        $('#bill_type_div').show();

        $('#challan_name').html('DELIVERY CHALLAN CUM INVOICE');

    }

    displayRecords(project_id,gst_type,c_type);

});

function displayRecords(project_id,gst_type,c_type){

    if(c_type === 'delivery_challan'){

        if(project_id){

            $('#invaliderrorgst').html('');

            $('#displayDCCInvc').hide();

            $('#displayDCCInvccgst').hide();

            $('#displayDCCDiv').show();

            $('#displayDCCTable').DataTable({

                "bAutoWidth": false,

                "bDestroy" : true,

                "bInfo" : false,

                "ordering": false,

                "searching":false,

                "paging": false,

                "deferRender": true,

                "responsive": false,

                "processing": true,

                "serverSide": false,

                "order": [],

                "ajax": {

                        "url": base_url+"get_client_dc_by_project",

                        "type": "POST",

                        "data":{project_id:project_id,c_type:c_type,gst_type:gst_type}

                },

                "columnDefs": [{ 

                    "targets": [0],

                    "orderable": false

                }],

                "initComplete": function () {

                var project_detail = this.api().ajax.json().project_detail; // Access the 'extraData' value

                var data = this.api().ajax.json(); // Access the 'extraData' value

                console.log(data);

                if(project_detail.work_order_on !== '' && typeof project_detail.work_order_on !== "undefined"){

                $('#workorderon').val(project_detail.work_order_on);

                }else{

                $('#workorderon').prop('readonly', false);

                }

                if(project_detail.client_po_addr !== '' && typeof project_detail.client_po_addr !== "undefined"){

                $('#registered_address').val(project_detail.client_po_addr);

                }else{

                $('#registered_address').prop('readonly', false);

                }

                if(project_detail.po_loi_received_data !== '' && typeof project_detail.po_loi_received_data !== "undefined"){

                    var dateAr = project_detail.po_loi_received_data.split('-');

                    var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];

                    $('#dcc_dated').val(newDate);

                }else{

                    $('#dcc_dated').prop('readonly', false);

                }

                if(project_detail.customer_name !== '' && typeof project_detail.customer_name !== "undefined"){

                $('#buyer_order_ref').val(project_detail.customer_name);

                }else{

                $('#buyer_order_ref').prop('readonly', false);

                }

                if(project_detail.site_address !== '' && typeof project_detail.site_address !== "undefined"){

                $('#buyer_registered_address').val(project_detail.site_address);

                }else{

                $('#buyer_registered_address').prop('readonly', false);

                }

                if(project_detail.site_address !== '' && typeof project_detail.site_address !== "undefined"){

                $('#site_address').val(project_detail.site_address);

                }else{

                $('#site_address').prop('readonly', false);

                }

            }

        });    

    }

    }else{

        if (gst_type === '' || gst_type === null) {

            $('#displayTaxInvc').hide();

            $('#invaliderrorgst').html('Please Select Gst Type!');

            return;

        }

        if(gst_type == 'igst'){

            if(project_id){

                $('#invaliderrorgst').html('');

                $('#displayDCCInvc').show();

                $('#displayDCCInvccgst').hide();

                $('#displayDCCDiv').hide();

                var tabl = $('#displayDCCInvcTable').DataTable({

                	    "bAutoWidth": false,

                	    "bDestroy" : true,

                	    "bInfo" : false,

                	    "ordering": false,

                	    "searching":false,

                	    "paging": false,

                		"deferRender": true,

                        "responsive": false,

                        "processing": true,

                		"serverSide": false,

                        "order": [],

                        "ajax": {

                            "url": base_url+"get_client_dc_by_project",

                            "type": "POST",

                            "data":{project_id:project_id,c_type:c_type,gst_type: gst_type}

                        },

                        "columnDefs": [{ 

                            "targets": [0],

                            "orderable": false

                        }],

                        "initComplete": function () {

                        var project_detail = this.api().ajax.json().project_detail; // Access the 'extraData' value

                        var data = this.api().ajax.json(); // Access the 'extraData' value

                        console.log(data);

                          if(project_detail.work_order_on !== '' && typeof project_detail.work_order_on !== "undefined"){

                            $('#workorderon').val(project_detail.work_order_on);

                            }else{

                            $('#workorderon').prop('readonly', false);

                            }

                            if(project_detail.client_po_addr !== '' && typeof project_detail.client_po_addr !== "undefined"){

                            $('#registered_address').val(project_detail.client_po_addr);

                            }else{

                            $('#registered_address').prop('readonly', false);

                            }

                            if(project_detail.po_loi_received_data !== '' && typeof project_detail.po_loi_received_data !== "undefined"){

                                var dateAr = project_detail.po_loi_received_data.split('-');

                                var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];

                                $('#dcc_dated').val(newDate);

                            }else{

                                $('#dcc_dated').prop('readonly', false);

                            }

                            if(project_detail.customer_name !== '' && typeof project_detail.customer_name !== "undefined"){

                            $('#buyer_order_ref').val(project_detail.customer_name);

                            }else{

                            $('#buyer_order_ref').prop('readonly', false);

                            }

                            if(project_detail.site_address !== '' && typeof project_detail.site_address !== "undefined"){

                            $('#buyer_registered_address').val(project_detail.site_address);

                            }else{

                            $('#buyer_registered_address').prop('readonly', false);

                            }

                            if(project_detail.site_address !== '' && typeof project_detail.site_address !== "undefined"){

                            $('#site_address').val(project_detail.site_address);

                            }else{

                            $('#site_address').prop('readonly', false);

                            }

                    }

                });    

             }

        }else{

            if(project_id){

                $('#invaliderrorgst').html('');

                $('#displayDCCInvc').hide();

                $('#displayDCCInvccgst').show();

                $('#displayDCCDiv').hide();

                $('#displayDCCInvccgstTable').DataTable({

                	    "bAutoWidth": false,

                	    "bDestroy" : true,

                	    "bInfo" : false,

                	    "ordering": false,

                	    "searching":false,

                	    "paging": false,

                		"deferRender": true,

                        "responsive": false,

                        "processing": true,

                		"serverSide": false,

                        "order": [],

                        "ajax": {

                            "url": base_url+"get_client_dc_by_project",

                            "type": "POST",

                            "data":{project_id:project_id,c_type:c_type,gst_type: gst_type}

                        },

                       

                        "columnDefs": [{ 

                            "targets": [0],

                            "orderable": false

                        }],

                        "initComplete": function () {

                        var project_detail = this.api().ajax.json().project_detail; // Access the 'extraData' value

                        var data = this.api().ajax.json(); // Access the 'extraData' value

                        console.log(data);

                        if(project_detail.work_order_on !== '' && typeof project_detail.work_order_on !== "undefined"){

                            $('#workorderon').val(project_detail.work_order_on);

                            }else{

                            $('#workorderon').prop('readonly', false);

                            }

                            if(project_detail.client_po_addr !== '' && typeof project_detail.client_po_addr !== "undefined"){

                            $('#registered_address').val(project_detail.client_po_addr);

                            }else{

                            $('#registered_address').prop('readonly', false);

                            }

                            if(project_detail.po_loi_received_data !== '' && typeof project_detail.po_loi_received_data !== "undefined"){

                                var dateAr = project_detail.po_loi_received_data.split('-');

                                var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];

                                $('#dcc_dated').val(newDate);

                            }else{

                                $('#dcc_dated').prop('readonly', false);

                            }

                            if(project_detail.customer_name !== '' && typeof project_detail.customer_name !== "undefined"){

                            $('#buyer_order_ref').val(project_detail.customer_name);

                            }else{

                            $('#buyer_order_ref').prop('readonly', false);

                            }

                            if(project_detail.site_address !== '' && typeof project_detail.site_address !== "undefined"){

                            $('#buyer_registered_address').val(project_detail.site_address);

                            }else{

                            $('#buyer_registered_address').prop('readonly', false);

                            }

                            if(project_detail.site_address !== '' && typeof project_detail.site_address !== "undefined"){

                            $('#site_address').val(project_detail.site_address);

                            }else{

                            $('#site_address').prop('readonly', false);

                            }

                      }

                }); 

            }   

        }

    }

}

