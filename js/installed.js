var project_id = $('#project_id').val().trim(); 
var base_url = $('#base_url').val().trim(); 
var download_title = 'Installed WIP';
$(document).on('change', '#project_id', function() {
        var project_id = $(this).val();
        if(project_id){
            $('#displayVcIWIPItem').show();
            $('#clientdciwipitemdisplay').DataTable({
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
                        "url": base_url+"get_dciwip_item_by_project",
                        "type": "POST",
                        "data":{project_id:project_id}
                    },
                    "columnDefs": [{ 
                        "targets": [0,2,3,4,6],
                        "orderable": false
                    }]
            });    
        }else{
            
        }
    });
    $('#iwiplist').DataTable({
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
		"oLanguage": {
            "sEmptyTable": "No Installed WIP Available!"
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
            "url": base_url+"project_dciwip_list",
            "type": "POST"
        },
		
        //Set column definition initialisation properties
        "columnDefs": [{ 
            "targets": [0],
            "orderable": false
        }]
    } );
    
    
    // $(document).on('input', '.check_installed_qty_validation', function() {
      
    //     var  maxValue = parseFloat($(this).data('max'));
    //     var currentValue = parseFloat($(this).val());
     
    //     if (currentValue > maxValue) {
         
    //         $(this).val(maxValue);  // Reset the value to the max value
    //     }
    //       $(this).closest('tr').find('input').removeClass('has-error-d');
       
    // });
    
    $(document).on('input', '.check_installed_qty_validation', function() {
       
        var installedQty = parseFloat($(this).val());
        var maxQty = parseFloat($(this).data('max'));
        var avlQty = parseFloat($(this).closest('tr').find('input[name="avl_qty[]"]').val());
        if (installedQty > avlQty) {
           
            // alert('Installed quantity cannot exceed available quantity!');
            $(this).val(avlQty); // Optionally set it back to avl_qty
        }
        $(this).closest('tr').find('input').removeClass('has-error-d');
    });
    