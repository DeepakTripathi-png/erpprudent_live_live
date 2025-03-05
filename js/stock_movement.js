var allProjectList;

$( document ).ready(function() {
  let today = new Date().toISOString().split('T')[0]; 
  $("#stock_date").val(today);


        getAllProject()
  
    var download_title ="Stock Movement"
    var stockMovementlist = $('#stockMovementlist').DataTable({
      "scrollX": true,
      "dom": 'Bfrtip',
      "lengthMenu": [
        [10,25, 50, 75, 100, 125,150, -1],
        [ '10 rows','25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
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
        {
          "extend": 'excel',
          "title": download_title,
          "exportOptions": {
            "columns": [0,1,2,3,4,5,6,7,8]
          },
          "footer": true,
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
        "sEmptyTable": "No Stock Movement Found!"
      },
      "bDestroy" : true,
      "bInfo" : false,
      "ordering": true,
      "searching":true,
      "paging": true,
      "iDisplayLength": 25,
      "deferRender": true,
      "responsive": false,
      "processing": true,
      "serverSide": false,
      "order": [],
      "ajax": {
        "url": base_url+"get_stock_movement_list?project_id="+$('#project_id').val(),
        // "url": base_url+"get_stock_movement_list",
        "type": "GET",
        "data":{project_id:$('#project_id').val()}
      },
  
    });
  
    $("#project_po,#project_vdc_no,#to_project_id,#project_bom_item").select2();
    $(document).on('input', 'input[name="stock_movement_qty[]"]', function() {
      var available_qty = parseFloat($(this).attr("data-max")) || 0;
      var value = parseFloat($(this).val()) || 0;
      if(value > available_qty ){
        $(this).val(parseFloat(available_qty).toFixed(2));
        value = available_qty;
      }
      const $row = $(this).closest('tr');
      const reqQty = parseFloat(value) || 0;
      const rate = parseFloat($row.find('[name="rate[]"]').val()) || 0;
      const gst = parseFloat($row.find('[name="gst[]"]').val()) || 0;
      const amount = reqQty * rate * (1 + gst / 100);
      $row.find('[name="total_amount[]"]').val(amount.toFixed(2));
    });
  

  
    $('#stockMovementlist tbody').on('click','.openview', function () {
  
      $(this).text(function(i, text){
        return text === "CLOSE" ? "VIEW" : "CLOSE";
      });
  
      var transaction_id = $(this).attr('data-id');
  
  
      var project_id = $(this).attr('data-project_id');
      var boq_code = $(this).attr('data-boq_code');
      var transaction_type = $(this).attr('data-type');
      var status_txt = $(this).attr('data-status');
  
      var filter = 'original';
  
      var tr = $(this).closest('tr');
      var row = stockMovementlist.row(tr);
      // console.log(table_bom);
  
      if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
      }else{
        var divwidth = $("#bomtranslist").width();
        var divminwidth = divwidth - 20;
        var filterhtml='';
        var headtxt='';
        download_title = 'BOM - Waiting for Approval';
  
        if(transaction_type == 'bom_upload'){
          download_title = 'Waiting for Approval (BOM Upload)';
        } else if (transaction_type == 'purchase_order') {
          download_title = 'Purchase Order';
        }
  
        var actionhtml='';
        var actionhtmlfooter='';
  
        var html = '<div class="portlet-body form" id="displayed'+boq_code+'">'
        +'<div class="displayFlx" style="margin-bottom: 15px;display:flex;">'
        +filterhtml
        +'<div class="col-md" id="calculatedfiler'+boq_code+'"></div>'
        +'</div>'
        +'<div id="originalpbomviewdiv'+boq_code+'"><div class="table-responsive">'
        +'<table width="100%" id="originalpbomview'+boq_code+'" class="table table-striped table-bordered table-hover" style="text-align: left;">'
        +'<thead style="background:#26a69a;color:#fff;font-weight:400;">'
        +'<tr>'
        +'<th scope="col" style="vertical-align: top;">Sr.no</th>'
        +'<th scope="col" style="vertical-align: top;">BOM Sr. No</th>'
        +'<th scope="col" style="vertical-align: top;">HNS Code</th>'
        +'<th scope="col" style="vertical-align: top;">Item Name</th>'
        +'<th scope="col" style="vertical-align: top;">Make</th>'
        +'<th scope="col" style="vertical-align: top;">Model</th>'
        +'<th scope="col" style="vertical-align: top;">Unit</th>'
        +'<th scope="col" style="vertical-align: top;text-align:right;">Quantity</th>'
        +'<th scope="col" style="vertical-align: top;text-align:right;">Rate Basic</th>'
        +'<th scope="col" style="vertical-align: top;text-align:right;">GST (%)</th>'
        +'<th scope="col" style="vertical-align: top;text-align:right;">Amount</th>'
        +'<th scope="col" style="vertical-align: top;text-align:right;">Status</th>'
        +actionhtml
        +'</tr>'
        +'</thead>'
        +'<tbody></tbody>'
        +'</table></div></div>';
        row.child(html).show();
        tr.addClass('shown');
        $('.dt-hasChild').next().css('background','#f5f5f5');
        $('.dt-hasChild').next().css('box-shadow','inset 0 0 0 9999px rgba(0, 0, 0, 0.075)');
  
        var table2 = $('#originalpbomview'+boq_code).DataTable({
          "dom": 'Bfrtip',
          scrollY: 400,
          scrollX: true,
          scroller: true,
          "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; // Calculate the current page
            var indexOnPage = iDisplayIndexFull % recordsPerPage; // Calculate the index on the current page
            var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;
  
            $("td:eq(0)", nRow).text(serialNumber); // Update the first cell content
            aData[0] = serialNumber; // Update the underlying data
          },
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
              "footer": true
            },
            {
              "extend": 'excel',
              "title": download_title,
              "footer": true,
              customize: function(xlsx) {
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                $('row c[r^="C"]', sheet).each( function () {
                  $(this).attr( 's', '55' );
                });
              },
            },
            {
              "extend": 'pdf',
              "title": download_title,
              "footer": true
            },
            {
              "extend": 'print',
              "title": download_title,
              "footer": true
            }
          ],
  
          "bAutoWidth": false,
          "bDestroy" : true,
          "paging": true,
          "iDisplayLength": 25,
          "deferRender": true,
          "responsive": true,
          "processing": true,
          "serverSide": false,
          "order": [[1, 'asc']],
          "ajax": {
            "url": base_url+"project_bom_trans_list_display",
            "type": "POST",
            "data":{project_id:project_id,filter:filter,transaction_id:transaction_id,transaction_type:transaction_type,boq_code:boq_code,status_txt:status_txt}
          },
  
          "columnDefs": [{
            "targets": [0,3,4,5],
            "orderable": false
          },
          {
            "targets": [6,7,8,9],
            "orderable": false,
            "className": "text-right"
          }],
        });
        new $.fn.dataTable.FixedHeader( table2 );
      }
    });


    $(document).on("click",".openMoreDetails",function(){
        let that = $(this);
        var sm_id = $(this).data("sm-id");
        $.ajax({
              type: "POST",
              url: "sm_item_list_display",
              data: {sm_id:sm_id},
              success: function (response) {
                  var responseObject = JSON.parse(response);
                  $(that).parents("tr").after(responseObject.html);
        //           $(that).parents("tr").next(".extented_row").find(".table-responsive table").DataTable({
        //             "dom": 'Bfrtip',
        //   scrollY: 400,
        //   scrollX: true,
        //   scroller: true,
        //   "lengthMenu": [
        //     [25, 50, 75, 100, 125,150, -1],
        //     [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
        //   ],
        //   "buttons": [
        //     'pageLength',
        //     {
        //       "extend": 'copy',
        //       "title": download_title,
        //       "footer": true
        //     },
        //     {
        //       "extend": 'excel',
        //       "title": download_title,
        //       "footer": true,
        //       customize: function(xlsx) {
        //         var sheet = xlsx.xl.worksheets['sheet1.xml'];
        //         $('row c[r^="C"]', sheet).each( function () {
        //           $(this).attr( 's', '55' );
        //         });
        //       },
        //     },
        //     {
        //       "extend": 'pdf',
        //       "title": download_title,
        //       "footer": true
        //     },
        //     {
        //       "extend": 'print',
        //       "title": download_title,
        //       "footer": true
        //     }
        //   ],
  
        // });
                  $(that).html("Close").removeClass("openMoreDetails").addClass("closeMoreDetails")
              },
              error: function (error) {
                  console.error("Error:", error);
              },
          });
    })
    // $(document).on("click",".closeMoreDetails",function(){
    //     console.log("ok")
    //      $(this).parents("tr").next(".extented_row").remove();
    //      $(this).addClass("openMoreDetails").removeClass("closeMoreDetails").html("View")
    // });
    
    $(document).on("click", ".closeMoreDetails", function() {
      $(this).parents("tr").nextAll(".extented_row").remove();
      $(this).addClass("openMoreDetails").removeClass("closeMoreDetails").html("View");
    });

    $('#form_project_id').on("change",function() {
      var form_project_id = $(this).val();
      $.ajax({
        url : "po_list_by_project_id",
        type:'POST',
        data:{project_id:form_project_id},
        success:function(response)
        {
          var response = JSON.parse(response);
          $('#project_po').html(response.option).trigger("update");
           
          var to_project_list_opt = "<option value=''>Select Project</option>";
          for (var i = 0; i < allProjectList.length; i++) {

            if(allProjectList[i].id != form_project_id){
              to_project_list_opt += "<option value='"+allProjectList[i]['id']+"'>"+allProjectList[i]['text']+"</option>";
            }
          }
          $("#to_project_id").html(to_project_list_opt).trigger("update");
        }
      });
    });

    $('#project_po').off("change");
    
    // $('#project_po').on("change",function() {
    // var po_number = $(this).val();
    // var form_project_id = $("#form_project_id").val();
    // $("#project_vdc_no").html('<option value="">Select VDC Number</option>').trigger('change');
   
    // // $("#project_vdc_no").empty().append(new Option("Select VDC Number", "", false, false)).trigger('change');

    // $("#project_bom_item").html('<option value="">Select BOM Items</option>').trigger('change');
    // $('#stockMovementItems tbody').html('<tr><td colspan="14" class="text-center">No Stock data found.</td></tr>');
    //   $.ajax({
    //     url : "vdc_list_by_po_number",
    //     type:'POST',
    //     data:{project_id:form_project_id,po_number:po_number},
    //     success:function(response)
    //     {
    //       var response = JSON.parse(response);
         
    //       $('#project_vdc_no').html(response.vdc_option).trigger("update");
    //       $('#project_bom_item').html(response.bom_option).trigger("update");
          
    //     }
    //   });
      
    // });
    
   $(document).on("change", "#project_po", function () {
    var po_number = $(this).val();
    var form_project_id = $("#form_project_id").val();

    // Reset Select2 dropdowns properly
    $("#project_vdc_no").empty().append(new Option("Select VDC Number", "", false, false)).trigger('change');
    $("#project_bom_item").empty().append(new Option("Select BOM Items", "", false, false)).trigger('change');

    // Reset stock movement table
    $('#stockMovementItems tbody').html('<tr><td colspan="14" class="text-center">No Stock data found.</td></tr>');

    $.ajax({
        url: "vdc_list_by_po_number",
        type: 'POST',
        data: { project_id: form_project_id, po_number: po_number },
        success: function (response) {
            var parsedResponse = JSON.parse(response);

            // Populate VDC dropdown
            var $vdcSelect = $("#project_vdc_no");
            $vdcSelect.empty().append(new Option("Select VDC Number", "", false, false));
            if (Array.isArray(parsedResponse.vdc_option)) {
                $.each(parsedResponse.vdc_option, function (index, item) {
                    $vdcSelect.append(new Option(item.text, item.value, false, false));
                });
            } else {
                $vdcSelect.html(parsedResponse.vdc_option); // If HTML response
            }
            $vdcSelect.trigger('change');

            // Populate BOM dropdown
            var $bomSelect = $("#project_bom_item");
            $bomSelect.empty().append(new Option("Select BOM Items", "", false, false));
            if (Array.isArray(parsedResponse.bom_option)) {
                $.each(parsedResponse.bom_option, function (index, item) {
                    $bomSelect.append(new Option(item.text, item.value, false, false));
                });
            } else {
                $bomSelect.html(parsedResponse.bom_option);
            }
            $bomSelect.trigger('change');
        },
        error: function () {
            console.error("Error fetching VDC/BOM data.");
        }
    });
});



    
    $('#project_vdc_no').off("change");
   
   
    
    //   $('#project_vdc_no').on("change",function() {
    //   var po_number = $("#project_po").val();
    //   var form_project_id = $("#form_project_id").val();
    //   var project_vdc_no = $(this).val();
    //     $('#stockMovementItems tbody').html('<tr><td colspan="14" class="text-center">No Stock data found.</td></tr>');
    //     // $('#project_bom_item').html("")
    //     // $('#project_bom_item').append(`<option value="">Select Bom Items</option>`);
    //     $('#project_bom_item').empty().append('<option value="">Select BOM Items</option>');

    //   $.ajax({
    //     url : "bom_items_by_project_id",
    //     type:'POST',
    //     data:{project_id:form_project_id,po_number:po_number,project_vdc_no:project_vdc_no},
    //     success:function(response)
    //     {
    //       response = JSON.parse(response);
    //       var $select = $("#project_bom_item");
    //       $.each(response.data, function(index, item) {
    //         if (item.bom_code) {
    //             $select.append(`<option value="${item.bom_code}">${item.bom_code}</option>`);
    //         }
    //     });
          
    //     }
    //   });
      
    // });
    
    
    $(document).on("change", "#project_vdc_no", function () {
    var po_number = $("#project_po").val();
    var form_project_id = $("#form_project_id").val();
    var project_vdc_no = $(this).val();

    // Reset stock movement items
    $('#stockMovementItems tbody').html('<tr><td colspan="14" class="text-center">No Stock data found.</td></tr>');

    // Reset BOM dropdown with Select2 handling
    var $select = $("#project_bom_item");
    $select.html('<option value="">Select BOM Items</option>').trigger('change'); // Reset and trigger Select2 refresh

    // Fetch BOM items via AJAX
    $.ajax({
        url: "bom_items_by_project_id",
        type: 'POST',
        data: { project_id: form_project_id, po_number: po_number, project_vdc_no: project_vdc_no },
        success: function (response) {
            response = JSON.parse(response);

            // Check if data exists
            if (response.data && response.data.length > 0) {
                $.each(response.data, function (index, item) {
                    if (item.bom_code) {
                        $select.append(new Option(item.bom_code, item.bom_code, false, false));
                    }
                });
            }

            // Refresh Select2 after updating options
            $select.trigger('change');
        },
        error: function () {
            console.error("Error fetching BOM items.");
        }
    });
});

  


    

    $('#project_bom_item').on("change",function() {
      var po_number = $("#project_po").val();
      var form_project_id = $("#form_project_id").val();
      var project_vdc_no = $("#project_vdc_no").val();
      var project_bom_item = $(this).val();
       $('#stockMovementItems tbody').html('<tr><td colspan="14" class="text-center">No Stock data found.</td></tr>');
      $.ajax({
        url : "stock_list_by_project_id",
        type:'POST',
        data:{project_id:form_project_id,po_number:po_number,project_vdc_no:project_vdc_no,project_bom_item:project_bom_item},
        success:function(response)
        {
          if (form_project_id !== 'Select Project' && form_project_id > 0) {
            $('#stockMovementItems tbody').html(response);
            var append_data = '<tr class="text-center"><td colspan="13">No Stock data found</td></tr>'
            if(response == append_data){
              // $('.common_save').attr('disabled', true);
            }
            $('#displayStockMovementItems').show(); 
          } else {
            $('#displayStockMovementItems').hide(); 
          }
          
        }
      });
      
    });
    
    $('#to_project_id').off("change");
    $('#to_project_id').on("change",function() {
      var to_project_id = $(this).val();
      $.ajax({
        url : "get_project_bom_code",
        type:'POST',
        data:{project_id:to_project_id},
        success:function(response)
        {
          var response = JSON.parse(response);
          $('#to_project_bom_code').html(response.bom_code_opt).trigger("update");
        }
      });
      
    });

   
      $(document).on('change', '#to_project_bom_code', function () {
          var project_id = $('#to_project_id').val(); 
          var bom_code = $(this).val(); 
          $.ajax({
            url : "get_project_bom_code_description",
            type:'POST',
            data:{project_id:project_id,bom_code:bom_code},
            success:function(response)
            {
              var response = JSON.parse(response);
              $('#bom_code_description').val(response.bom_code_description);
            }
          });
      });




    $(document).on('click','.editStockMovement', function () {
      $("#save_stock_movement_form").hide();
      $("#update_stock_movement_form").show();
      var stock_movement_id = $(this).attr("data-sm-id");
      var form_project_id = $(this).val();
      $.ajax({
        url : "get_update_stock_movement_data",
        type:'POST',
        data:{stock_movement_id:stock_movement_id},
        success:function(response)
        {
          var res = JSON.parse(response);
          $("#update_stock_movement_id").val(stock_movement_id)
          $("#stockMovementUpdateItems tbody").html(res.item_html);
          $("#update_from_project ").val(res.stock_movement_data.from_project);
          $("#update_to_project ").val(res.stock_movement_data.to_project);
          $("#update_stock_movement_date ").val(res.stock_movement_data.stock_date);
          $("#update_po_number").val(res.stock_movement_data.po_number);
          $("#update_to_bom_Code").val(res.stock_movement_data.to_bom_code);
          $("#update_form_bom_code").val(res.stock_movement_data.form_bom_code);
          $("#update_vdc_number").val(res.stock_movement_data.vdc_number);
         
        }
      });
    });
    $("#update_stock_movement_form").validate({
        rules: {
          "stock_movement_qty[]": {
              required: true
          }
      },
      messages: {
          "stock_movement_qty[]": {
              required: "Please enter the stock movement quantity."
          }
      },
      onfocusout: function(element) {
        // Trigger validation on focus out to remove the error message once corrected
        $(element).valid();
      },
      errorPlacement: function(error, element) {
          error.insertAfter(element);
      },
      submitHandler: function(form) {
          var formData = new FormData(form);
          $.ajax({
            url: "update_stock_movement_data",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              var res = JSON.parse(response);
             
              $(".alert-container").removeClass("hide");
              if(res.success == 1) {
                $(".alert-container").html('<div class="alert modify alert-success">' + res.messages + '</div>');
                setTimeout(function() {
                      $(".alert-container").addClass("hide");
                  $(".alert-container").html('');
                  location.reload();
                }, 3000);
              } else {
                $(".alert-container").html('<div class="alert modify alert-danger">' + res.messages + '</div>');
                setTimeout(function() {
                      $(".alert-container").addClass("hide");
                },3000);
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.error('Error: ' + textStatus, errorThrown);
            }
          });

        }
      });

  $.validator.addMethod("notDefault", function(value, element) {
    return value !== "Select Project"; 
}, "Please select a valid project.");

$.validator.addMethod("notSameAsFrom", function(value, element) {
  return value !== $('#form_project_id').val(); 
}, "The target project must be different from the source project.");

  $("#save_stock_movement_form").validate({

    rules: {
      form_project_id: {
          required: true,
          notDefault: true
      },
      to_project_id: {
          required: true,
          notDefault: true,
          notSameAsFrom: true 
      },
      project_po:{
        required: true,
      },
      "stock_movement_qty[]": {
          required: true
      },
      
      // project_vdc_no:{
      //   required: true,
      // },
      to_project_bom_code:{
        required: true,
      }
  },
  messages: {
      form_project_id: {
          required: "Please select a project.",
          notDefault: "Please select a project."
      },
      to_project_id: {
          required: "Please select a target project.",
          notDefault: "Please select a target project.",
            notSameAsFrom: "The target project cannot be the same as the source project."
      },
      "stock_movement_qty[]": {
          required: "Please enter the stock movement quantity."
      },
      stock_date:{
        required: "Please select stock movement date."
      },
      project_po:{
         required: "Please select PO NO."
      },
      // project_vdc_no:{
      //  required: "Please select VDC NO."
      // },
      to_project_bom_code:{
        required: "Please select BOM Code."
      }
  },
  onfocusout: function(element) {
    // Trigger validation on focus out to remove the error message once corrected
    $(element).valid();
},


    errorPlacement: function(error, element) {
      error.insertAfter(element);
      
    },
    submitHandler: function(form) {
      var formData = new FormData(form);
      $.ajax({
        url: "save_stock_movement_data",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          var res = JSON.parse(response);
         
          
            $(".alert-container").removeClass("hide");
          if(res.success == 1) {
            $(".alert-container").html('<div class="alert modify alert-success">' + res.messages + '</div>');
            setTimeout(function() {
                  $(".alert-container").addClass("hide");
              $(".alert-container").html('');
              location.reload();
            }, 3000);
          } else {
            $(".alert-container").html('<div class="alert modify alert-danger">' + res.messages + '</div>');
            setTimeout(function() {
                  $(".alert-container").addClass("hide");
            },3000);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error: ' + textStatus, errorThrown);
        }
      });

    }
  });


//   $('#form_project_id, #to_project_id').change(function() {
//     $(this).valid(); // Re-validate the field on change
// });


$(document).on('change','.statusselectbom' , function(e){
  var this1 = $(this);
  bootbox.confirm("Are you sure?", function(result) 
  {
      if(result)
      {
          var sm_id = this1.attr('data-sm-id');
          var url = this1.attr('rev');   
          
                  
          var status = this1.val(); 
          
          $.ajax({
              url : completeURL(url),
              type:'POST',
              dataType:'json',
              data:{sm_id:sm_id,status:status},
              success:function(data)
              {
                  bootbox.alert(data.msg, function() {
                     
                  });
                  setTimeout(function(){
                    location.reload();                          
                  },1500);
                  
                    //  $(`#voucher_list`).DataTable().ajax.reload();
              }
          });
      }
  }); 
});


// $(document).on("click", ".download-stock-movement", function() {
//   var sm_id = $(this).attr("data-sm-id");

//   $.ajax({
//     url: base_url + 'get_stock_movement_data_for_excel',
//     type: 'POST',
//     dataType: 'json',
//     data: { sm_id: sm_id },
//     success: function(response) {
//         // Ensure that the response is valid
//         if (!response || !response.data || !response.data.data || !Array.isArray(response.data.data)) {
//             console.error('Invalid response format:', response);
//             return;
//         }

//         var data = response.data.data; // Array of items
//         var form_project = data[0].form_project;
//         var to_project = data[0].to_project;
//         var bom_data_array = [];
//         var count = 1;

//         // Loop through the data array
//         data.forEach(function(item) {
//             var row = [
//                 count,
//                 item.bom_code || 'N/A',
//                 item.item_description || 'N/A',
//                 item.hsn_code || 'N/A',
//                 item.make || 'N/A',
//                 item.model || 'N/A',
//                 item.unit || 'N/A',
//                 item.qty || 0
//             ];
//             bom_data_array.push(row);
//             count++;
//         });

        
//         const workbook = new ExcelJS.Workbook();
//         const worksheet = workbook.addWorksheet('Sheet1');

//         // Header data for worksheet
//         // var ws_data = [
//         //     ['Stock Movement'],
//         //     [""],
//         //     [""],
//         //     ["", "From Project", form_project || 'N/A', "", "", "", "Date", (data[0].created_on ? data[0].created_on.split(' ')[0] : 'N/A')],
//         //     ["", "To Project", to_project || 'N/A', "", "", "", ""],
//         //     [""], // Empty row
//         //     ["Sr. No.", "Bom Code", "Item Description", "HSN Code", "Make", "Model", "Unit", "Qty"]
//         // ];
        
//         var ws_data = [
//           ['Stock Movement'],
//           [""],
//           [""],
//           ["", "From Project", form_project || 'N/A', "PO Number", data[0].po_number,"VDC Number", data[0].vdc_number],
//           ["", "Bom Code", data[0].bom_code, "To Project", to_project || 'N/A', "Date", (data[0].created_on ? data[0].created_on.split(' ')[0] : 'N/A')],
//           [""], // Empty row
//           ["Sr. No.", "Bom Code", "Item Description", "HSN Code", "Make", "Model", "Unit", "Qty"]
//       ];

//         // Append BOM data to worksheet
//         ws_data = ws_data.concat(bom_data_array);
//         ws_data.forEach(row => worksheet.addRow(row));

//         // Set font and styles
//         const boldFont = { bold: true };
//         const centerAlignment = { vertical: 'middle', horizontal: 'center' };
//         const borderStyle = {
//             top: { style: 'thin', color: { argb: '000000' } },
//             left: { style: 'thin', color: { argb: '000000' } },
//             bottom: { style: 'thin', color: { argb: '000000' } },
//             right: { style: 'thin', color: { argb: '000000' } }
//         };

//         // Apply font and alignment to headers
//         worksheet.getRow(7).font = boldFont;
//         worksheet.getRow(7).alignment = centerAlignment;
//         for (let col = 1; col <= 8; col++) {
//           worksheet.getCell(7, col).border = borderStyle; 
//       }

//         worksheet.columns = [
//             { width: 10 }, // Sr. No.
//             { width: 20 }, // Bom Code
//             { width: 30 }, // Item Description
//             { width: 15 }, // HSN Code
//             { width: 20 }, // Make
//             { width: 20 }, // Model
//             { width: 10 }, // Unit
//             { width: 10 }  // Qty
//         ];

//         // Merge and center title cells
//         worksheet.mergeCells(1, 1, 2, 8); 
    

//         worksheet.getCell(1, 1).alignment = centerAlignment;
//         worksheet.getCell(1, 1).font = { size: 20, bold: true };

//         worksheet.getCell(4, 8).font = boldFont; // Date
//         worksheet.getCell(4, 3).font = boldFont; // Project Names

//         const startRow = 8; // Assuming bom_data_array starts at row 8
//         const startCol = 1; // Starting from column 1

//         bom_data_array.forEach((row, rowIndex) => {
//             row.forEach((_, colIndex) => {
//                 const cell = worksheet.getCell(startRow + rowIndex, startCol + colIndex);
//                 cell.border = borderStyle; 
//             });
//         });

//         // Export workbook
//         workbook.xlsx.writeBuffer().then(function(buffer) {
//             const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
//             saveAs(blob, 'stock-movement.xlsx');
//         });
//     },
//     error: function(jqXHR, textStatus, errorThrown) {
//         console.error('Error fetching data:', textStatus, errorThrown);
//     }
// });






// });

$(document).on("click", ".download-stock-movement", function() {
  var sm_id = $(this).attr("data-sm-id");

  $.ajax({
    url: base_url + 'get_stock_movement_data_for_excel',
    type: 'POST',
    dataType: 'json',
    data: { sm_id: sm_id },
    success: function(response) {
        // Ensure that the response is valid
        if (!response || !response.data || !response.data.data || !Array.isArray(response.data.data)) {
            console.error('Invalid response format:', response);
            return;
        }
        console.log(response.data);
        var data = response.data.data; // Array of items
        var sm_data = response.data.sm_data[0]; // Array of items
        var form_project = data[0].form_project;
        var to_project = data[0].to_project;
        var bom_data_array = [];
        var count = 1;
        var total_stock_qty = 0;
      
        data.forEach(function(item) {
          var stock_qty = item.stock_qty ? parseFloat(item.stock_qty) : 0; 
          total_stock_qty += stock_qty; 
            var row = [
                count,
                item.bom_code || 'N/A',
                item.item_description || 'N/A',
                item.hsn_code || 'N/A',
                item.make || 'N/A',
                item.model || 'N/A',
                item.unit || 'N/A',
                item.stock_qty || 0
            ];
            bom_data_array.push(row);
            count++;
            
        });

        
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet('Sheet1');

        var ws_data = [
          ['Stock Movement'],
          [""],
          [""],
          ["", "From Project", form_project || 'N/A', "PO Number", data[0].po_number,"VDC Number", data[0].vdc_number],
          ["", "Bom Code", data[0].bom_code, "To Project", to_project || 'N/A', "Date", (data[0].created_on ? data[0].created_on.split(' ')[0] : 'N/A')],
          [""], // Empty row
          ["Form Project Details"], // Empty row
          [""], // Empty row
          ["Sr. No.", "Bom Code", "Item Description", "HSN Code", "Make", "Model", "Unit", "Qty"]
      ];

      var sm_data = [
       
        [""],
        ["To Project Details"],
        [""],
        ["Sr. No.", "Bom Code", "Item Description", "HSN Code", "Make", "Model", "Unit", "Qty"],
        ["1", sm_data.bom_code || '-',
          sm_data.item_description || '-',
          sm_data.hsn_sac_code || '-',
          sm_data.make || '-',
          sm_data.model || '-',
          sm_data.unit || '-',
          total_stock_qty || 0],
    ];

        // Append BOM data to worksheet
        ws_data = ws_data.concat(bom_data_array);
        ws_data = ws_data.concat(sm_data);
        ws_data.forEach(row => worksheet.addRow(row));

        // Set font and styles
        const boldFont = { bold: true };
        const centerAlignment = { vertical: 'middle', horizontal: 'center' };
        const borderStyle = {
            top: { style: 'thin', color: { argb: '000000' } },
            left: { style: 'thin', color: { argb: '000000' } },
            bottom: { style: 'thin', color: { argb: '000000' } },
            right: { style: 'thin', color: { argb: '000000' } }
        };

        // Apply font and alignment to headers
        worksheet.getRow(7).font = boldFont;
        worksheet.getRow(9).font = boldFont;
        worksheet.getRow(8+count+2).font = boldFont;
        worksheet.getRow(8+count+4).font = boldFont;
        worksheet.getRow(7).alignment = centerAlignment;
        worksheet.getRow(9).alignment = centerAlignment;
        worksheet.getRow(8+count+2).alignment = centerAlignment;
        worksheet.getRow(8+count+4).alignment = centerAlignment;
        for (let col = 1; col <= 8; col++) {
          worksheet.getCell(8+count, col).border = borderStyle; 
      }

      for (let col = 1; col <= 8; col++) {
        worksheet.getCell(8+count+4, col).border = borderStyle; 
    }
    for (let col = 1; col <= 8; col++) {
      worksheet.getCell(8+count+5, col).border = borderStyle; 
  }
        worksheet.columns = [
            { width: 10 }, // Sr. No.
            { width: 20 }, // Bom Code
            { width: 30 }, // Item Description
            { width: 15 }, // HSN Code
            { width: 20 }, // Make
            { width: 20 }, // Model
            { width: 20 }, // Unit
            { width: 10 }  // Qty
        ];

        // Merge and center title cells
        worksheet.mergeCells(1, 1, 2, 8); 
        worksheet.mergeCells(7, 1, 7, 8); 
        worksheet.mergeCells(8+count+2, 1, 8+count+2, 8); 
        

        worksheet.getCell(1, 1).alignment = centerAlignment;
        worksheet.getCell(1, 1).font = { size: 20, bold: true };

        worksheet.getCell(4, 3).font = boldFont; // Date
        worksheet.getCell(5, 3).font = boldFont; // Project Names
        worksheet.getCell(4, 5).font = boldFont; // Project Names
        worksheet.getCell(5, 5).font = boldFont; // Project Names
        worksheet.getCell(4, 7).font = boldFont; // Project Names
        worksheet.getCell(5, 7).font = boldFont; // Project Names

        const startRow = 9; // Assuming bom_data_array starts at row 8
        const startCol = 1; // Starting from column 1

        bom_data_array.forEach((row, rowIndex) => {
            row.forEach((_, colIndex) => {
                const cell = worksheet.getCell(startRow + rowIndex, startCol + colIndex);
                cell.border = borderStyle; 
            });
        });

        // Export workbook
        workbook.xlsx.writeBuffer().then(function(buffer) {
            const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            saveAs(blob, 'stock-movement.xlsx');
        });
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error('Error fetching data:', textStatus, errorThrown);
    }
});






});
  });
 
  

  function getAllProject(){
    $.ajax({
    url : "get_all_project_list",
    type:'POST',
    data:{},
    success:function(response)
    {
        response = JSON.parse(response);
        allProjectList = response.users;
        var project_opt = "<option>Select Project</option>";
        var projects = response.users;
        for(let i=0;i<projects.length;i++){
            project_opt += `<option value='${projects[i].id}'>${projects[i].text}</option>`;
        }
        $(".allProjectDropDown").html(project_opt).select2();
        $("#voucher_type,#p_head_drop").select2();
        
   
    }
  });
}