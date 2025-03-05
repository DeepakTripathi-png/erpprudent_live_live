$(document).ready(function() {
    $('#voucher_type').on('change', function() {
      
        var selectedValue = $(this).val();
        var project_id = $('#project_id').val();
        getVoucherHeadData(selectedValue,project_id)
        $('.office_expense').addClass('hide');
        $('.project_expense').addClass('hide');
        if (selectedValue === 'Office Expense') {
            $('.office_expense').removeClass('hide');
        } else if (selectedValue === 'Project Expense') {
            $('.project_expense').removeClass('hide');

        }
    });
    $('#qty').on('input', function() {
      var qty = parseFloat($(this).val()) || 0;
      var max_qty = parseFloat($('#p_hidden_qty').val());
      var rate = parseFloat($('#rate').val()) || 0;
      if (qty > max_qty) {
          qty = max_qty;
          $(this).val(qty);  
      }
  
      var amount = qty * rate;
      $('#p_amount').val(amount.toFixed(2)); 
  });

    $('#qty, #rate').on('input', calculateAmount);


    var download_title = 'Transaction';
    var recordsPerPage = 10;
    var voucher_list = $('#voucher_list').DataTable({
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
        "sEmptyTable": "No Transaction Data Found!"
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
  
  
    });
    getAllProject()
    $("#voucher_transaction_form").validate({

        rules: {
        voucher_type: {
            required: true
        },
        // p_head: {
        //     required: function() {
        //         return $("#voucher_type").val() === "Project Expense";
        //     }
        // },
        qty: {
            required: function() {
                return $("#voucher_type").val() === "Project Expense";
            }
        },
        bom_code: {
            required: function() {
                return $("#voucher_type").val() === "Project Expense";
            }
        },
     
        project_id: {
            required: function() {
                return $("#voucher_type").val() === "Project Expense";
            }
        },
        p_transaction_date: {
            required: function() {
                return $("#voucher_type").val() === "Project Expense";
            }
        },
        
        o_head: {
            required: function() {
                return $("#voucher_type").val() === "Office Expense";
            }
        },
        o_amount: {
            required: function() {
                return $("#voucher_type").val() === "Office Expense";
            }
        },
        o_transaction_date: {
            required: function() {
                return $("#voucher_type").val() === "Office Expense";
            }
        }
    },
    messages: {
        voucher_type: {
            required: "Please select Voucher Type."
        },
        // p_head: {
        //     required: "Please select head for Office Expense."
        // },
        qty: {
            required: "Please enter quantity for Project Budget."
        },
        bom_code: {
            required: "Please select Bom Code for Project Budget."
        },
      
        project_id: {
            required: "Please select project for Project Budget."
        },
        p_transaction_date: {
            required: "Please select Transaction Date."
        },
    
        o_head: {
            required: "Please enter head for Office Budget."
        },
        o_amount: {
            required: "Please enter amount for Office Budget."
        },
        o_transaction_date: {
            required: "Please select Transaction Date."
        },
        
    },
        errorPlacement: function(error, element) {
          error.insertAfter(element);
          
        },
        submitHandler: function(form) {
          var formData = new FormData(form);
          var voucher_type = $('#voucher_type').val();
          formData.append('voucher_type', voucher_type);
          if (voucher_type === 'Office Expense') {
            var selectedHead = $('select[name="o_head"]').val();
            var voucher_id = $('select[name="o_head"]').find('option[value="' + selectedHead + '"]').data("voucher-id");
          } else if (voucher_type === 'Project Expense') {
            var selectedHead = $('select[name="bom_code"]').val();
            var voucher_id = selectedHead;
          }
          formData.append("voucher_id", voucher_id)
          $.ajax({
            url: "save_voucher_transaction_data",
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


      $(document).on('change','.statusselectbom' , function(e){
        var this1 = $(this);
        bootbox.confirm("Are you sure?", function(result) 
        {
            if(result)
            {
                var transaction_id = this1.attr('data-transaction-id');
                var url = this1.attr('rev');   
                var project_id = this1.attr('data-project_id');   
                        
                var status = this1.val(); 
                
                $.ajax({
                    url : completeURL(url),
                    type:'POST',
                    dataType:'json',
                    data:{transaction_id:transaction_id,status:status,project_id:project_id},
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
 
  
  $(document).on('click', '.edit_voucher_transaction_data', function(e) {
    e.preventDefault(); 
    var transaction_id = $(this).data('transaction-id');
    var project_id = $(this).data('project_id');
    $.ajax({
      url : "edit_voucher_transaction_data",
      type:'POST',
      data:{transaction_id:transaction_id},
      success:function(response)
      {
          response = JSON.parse(response);
          var res = response.data;
          console.log(res)
          $("#voucher_type").val(res.voucher_type).trigger("change").prop("readonly", true);
          $("input[name='transaction_id']").val(res.transaction_id)
          var downloadLink ="";
          if (res.voucher_type == "Project Expense") {
            $("#project_id").val(res.project_id).trigger('change');
            $("#voucher_transaction_form").prepend("<input name='project_id' value='"+res.project_id+"' type='hidden'>")
            $(".allProjectDropDown").select2("enable", false);
            
            // .trigger("change").prop("readonly", true);
            setTimeout(function(){
              $("#bom_code").val(res.bom_code_id).prop("readonly",true).trigger("change");
              $('#bom_code').attr({'readonly': 'readonly'}).trigger('change.select2');
              $("#p_head_drop").html("<option>"+res.head+"</option>").prop("readonly",true).trigger("change");
              $('#p_head_drop').attr({'readonly': 'readonly'}).trigger('change.select2');
            },500);
           
            $("input[name='description']").val(res.description)
            $("input[name='p_amount']").val(res.amount);
            $("input[name='qty']").val(res.qty);
            $("#p_hidden_qty").val(res.max_qty);
            $("input[name='rate']").val(res.rate);
            $("#p_hidden_amount ").val(res.max_amount);
            $("input[name='p_transaction_date']").val(res.transaction_date).prop("readonly", true);
           
            $(".project_expense").removeClass('hide');
            $(".office_expense").addClass('hide');
          } else {
              setTimeout(function(){
                $("#voucher_transaction_form").prepend("<input name='o_head' value='"+res.head+"' type='hidden'>");
                 $("#o_head_drop").val(res.head).select2("enable", false).trigger("change");
                
            },500);
          //   $("select[name='o_head']").val(res.head)
            // .trigger("change").prop("readonly", true);
            $("input[name='o_amount']").val(res.amount)
            $("#o_hidden_amount ").val(res.max_amount);
            $("input[name='o_transaction_date']").val(res.transaction_date).prop("readonly", true);
            $(".office_expense").removeClass('hide');
            $(".project_expense").addClass('hide');
          }
          $("#voucher_type").select2("enable", false);
          $("#voucher_form").prepend("<input name='voucher_type' value='"+res.voucher_type+"' type='hidden'>");

     
     
      }
    });
    
});
// $(document).on('change', '#project_id', function(e) {
//   var project_id = $(this).val();
//   $('#bom_code').val(''); 
//   $('input[name="qty"]').val(""); 
//   $('input[name="description"]').val(""); 
//   $('input[name="rate"]').val(""); 
//   $('input[name="p_amount"]').val("");
//   $(".error").html(""); 
// });

$(document).on("click", ".download-transaction-excel", function() {
    var transaction_id = $(this).attr("data-transaction-id");
  
    $.ajax({
        url: base_url + 'get_voucher_transaction_data_for_excel',
        type: 'POST',
        dataType: 'json',
        data: { transaction_id: transaction_id },
        success: function(response) {
            var data = response.data;

            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet('Sheet1');

            // Data for worksheet
            var ws_data = [
                ['Transaction'],
                [""],
                [""],
                ["", "Name", data.fullname, "",'','','','', "Date", data.created_on.split(' ')[0]], // only date part
                ["", "", "", "", "", "", "", "", "", "", "", "", "", ""],
                ["Sr. No.", "Date", "BP Code", "Voucher Type", "Head", "BOM Code", "Description", "Qty", "Rate", "Amount"],
              
                  [
                      "1",
                      data.transaction_date || '-',
                      data.bp_code || '-',
                      data.voucher_type || '-',
                      data.head || '-',
                      data.v_bom_code !== null && data.v_bom_code !== undefined ? data.v_bom_code : '-',
                      data.description !== null && data.description !== undefined ? data.description : '-',
                      data.qty !== null && data.qty !== undefined ? data.qty : '-',
                      data.rate !== null && data.rate !== undefined ? data.rate : '-',
                      (parseFloat(data.amount) || 0).toFixed(2) || '-'
                  ],
            
            ];

            // Total row
            var final_amount = [
                ["", "", "", "", "",'','', "", "Total",  (parseFloat(data.amount) || 0).toFixed(2)]
            ];

            ws_data = ws_data.concat(final_amount);
            ws_data.forEach(row => worksheet.addRow(row));

            // Set font and styles
            const boldFont = { bold: true };
            const centerAlignment = { vertical: 'middle', horizontal: 'center' };
            const leftAlignment = { vertical: 'middle', horizontal: 'left' };
            const borderStyle = { 
                top: { style: 'thin', color: { argb: '0000' } },
                left: { style: 'thin', color: { argb: '0000' } },
                bottom: { style: 'thin', color: { argb: '0000' } },
                right: { style: 'thin', color: { argb: '0000' } }
            };

            // Apply font and alignment to headers
            worksheet.getRow(6).font = boldFont;
            worksheet.columns = [
              { width: 15 }, // Column 1
              { width: 15 }, // Column 2
              { width: 15 }, // Column 3
              { width: 20 }, // Column 4
              { width: 15 }, // Column 4
              { width: 15 }, // Column 4
              { width: 30 }, // Column 4
              { width: 15 }, // Column 4
              { width: 15 }, // Column 4
              { width: 15 }, // Column 4
             
            ];
            

            // Merge and center title cells
            worksheet.mergeCells(1, 1, 2, 10);
            worksheet.mergeCells(8, 1, 8, 8);
            worksheet.getCell(1, 1).alignment = centerAlignment;
            worksheet.getCell(1, 1).font = { size: 20, bold: true };
            worksheet.getCell(8, 7).font = {bold: true };
            worksheet.getCell(8, 8).font = {bold: true };
            worksheet.getCell(4, 3).font = {bold: true };
            worksheet.getCell(4, 10).font = {bold: true };

            [6, 7, 8].forEach(rowNumber => {
              for (let colNumber = 1; colNumber <= 10; colNumber++) {
                worksheet.getCell(rowNumber, colNumber).border = borderStyle;
              }
            });

            // Export workbook
            workbook.xlsx.writeBuffer().then(function(buffer) {
                const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                saveAs(blob, 'transaction.xlsx');
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching data:', textStatus, errorThrown);
        }
    });
});


$('select[name="o_head"]').on('change', function() {
  const selectedHead = $(this).val(); 
  var voucher_id = $(this).find('option[value="' + selectedHead + '"]').data("voucher-id");
  var transaction_id = $(this).parents("form").find("#transaction_id_val").val(); 
  $.ajax({
      url: 'get_approve_t_voucher_data',
      type: 'POST',
      data: {
          voucher_id: voucher_id,
          head: selectedHead,
          transaction_id:transaction_id
      },
      dataType: 'json',
      success: function(res) {
        var data = res.data;
        if(data != undefined){
            if(data.amount > 0){
              if(!(transaction_id > 0)){
                $('input[name="o_amount"]').val(data.amount);
                $('#o_hidden_amount').val(data.amount);
              }
            }else{
              $(".alert-container").html('<div class="alert modify alert-danger">There are no expense details found for this transaction.</div>');
          
              $('.green').prop('disabled', true).css('opacity', '0.6')
              $(".alert-container").addClass("show");
              setTimeout(function() {
                    $(".alert-container").addClass("hide");
              },3000);
            }
        
        }
          
     
      },
      error: function(xhr, status, error) {
          console.error("Error fetching voucher head data:", error);
      }
  });
});



$('input[name="o_amount"]').on('input', function() {
  var maxAmount = parseFloat($('#o_hidden_amount').val());
  var currentValue = parseFloat($(this).val());
  if (currentValue > maxAmount) {
      $(this).val(maxAmount.toFixed(2)); 
  }
});
$('input[name="p_amount"]').on('input', function() {
  var maxAmount = parseFloat($('#p_hidden_amount').val());
  var currentValue = parseFloat($(this).val());
  if (currentValue > maxAmount) {
      $(this).val(maxAmount.toFixed(2)); 
  }
  calculateAmount()
});

$('#qty').on('input', function() {
  var qty = parseFloat($(this).val()) || 0;
  var rate = parseFloat($('#rate').val()) || 0;
  var amount = qty * rate;
  $('#p_amount').val(amount.toFixed(2));
  $('#p_hidden_amount').val(amount.toFixed(2));
});


$(document).on('change', '#project_id', function(e) {
  var project_id = $(this).val();
  var transaction_id = $("#transaction_id_val").val();
  var voucher_type = $('#voucher_type').val();
  $("#description").val("");
  $("#qty").val("");
  $("#rate").val("");
  $('#p_amount').val("");
  if (project_id && !(transaction_id > 0)) {
    getVoucherHeadData(voucher_type,project_id)
  }
});


$('#bom_code').on('change', function() {
  // alert("ok");
  var transaction_id = $("#transaction_id_val").val();
  var bom_code_id = $(this).val();
  var voucher_id = $(this).find(":selected").data("voucher-id");
  var voucher_type = $(this).find(":selected").data("type");
  var project_id = $("#project_id").find(":selected").val(); 

  if(!(transaction_id > 0) && bom_code_id != ""){
    $.ajax({
      url: 'get_voucher_data',  
      type: 'POST',                 
      data: {
        bom_code_id: bom_code_id,
        voucher_id: voucher_id,
        project_id:project_id,
        voucher_type:voucher_type
      },
      dataType: 'json',             
      success: function(res) {
        var data = Array.isArray(res) ? res : Object.values(res);
        console.log(data)
        if (Array.isArray(data)) {
          $('select[name="p_head"]').empty().html('<option value="'+data[0]['head']+'" selected>'+data[0]['head']+'</option>').prop("readonly",true).trigger("change");
          $('#p_head_drop').attr({'readonly': 'readonly'}).trigger('change.select2');
          $("#description").val(data[0]['description']);
          $("#qty").val(data[0]['qty']);
          $("#rate").val(data[0]['rate']);
          $('#p_amount').val(data[0]['amount']);
          $('#p_hidden_qty').val(data[0]['qty']);
          $("#p_hidden_amount").val(data[0]['amount']);
          if(data[0]['voucher_data_type'] == 'Transfer'){
               $(".stock_type").removeClass('hide');
               $(".stock_type #type").val('Stock Movement');
          }else{
              $(".stock_type #type").val('');
               $(".stock_type").addClass('hide');
          }
         
          // data.forEach(voucherArray => {
          //     if (Array.isArray(voucherArray)) {
          //         voucherArray.forEach(voucher => { 
          //             if (voucher.bom_code) {
          //                 $('#voucher_transaction_form  #bom_code').append(`<option value="${voucher.bpe_id}" data-voucher-id="${voucher.bpe_id}">${voucher.bom_code}</option>`);
          //             }
          //         });
          //     }
          // });
        } else {
            console.error("Expected an array but got:", data);
        }
    },
    
      error: function(xhr, status, error) {
          console.error("Error fetching voucher head data:", error);
      }
  });
  }
  
});
    
});

function calculateAmount() {
    var qty = parseFloat($('#qty').val()) || 0; 
    var rate = parseFloat($('#rate').val()) || 0; 
    var amount = qty * rate; 
    $('#amount').val(amount.toFixed(2)); 
}


function getVoucherHeadData(voucher_type, project_id) {
  $.ajax({
      url: 'get_bom_code',  
      type: 'POST',                 
      data: {
          voucher_type: voucher_type,
          project_id: project_id
      },
      dataType: 'json',             
      success: function(res) {
        var data = Array.isArray(res) ? res : Object.values(res);
        if (Array.isArray(data)) {
            if (voucher_type === "Office Expense") {
              $('select[name="o_head"]').empty().append('<option value="">Select Office Expense Head</option>');
              console.log(data)
              data.forEach(voucherArray => {
                  if (Array.isArray(voucherArray)) {
                      voucherArray.forEach(voucher => { 
                         
                          if (voucher.head) {
                            $('select[name="o_head"]').append(
                              $('<option>', {
                                  value: voucher.head,
                                  'data-voucher-id': voucher.voucher_id,
                                  text: `${voucher.head} (${voucher.financial_year})`
                              })
                          );
                         } else {
                              // console.warn('Head is missing for voucher:', voucher);
                          }
                      });
                  }
              });
          } else if (voucher_type === "Project Expense") {
              $('select[name="p_head"]').empty().html('<option value="">Select Project Expense Head</option>');
              $('#voucher_transaction_form #bom_code').empty().html('<option value="">Select BOM Code</option>');
              data.forEach(voucherArray => {
                  if (Array.isArray(voucherArray)) {
                      voucherArray.forEach(voucher => { 
                        if (voucher.po_bom_code != null && voucher.bom_code_id == 0 && voucher.po_bom_code != "" &&  voucher.po_bom_code != undefined) {
                            $('#voucher_transaction_form  #bom_code').append(`<option value="${voucher.po_bom_code}" data-voucher-id="${voucher.voucher_id}" data-type="Transfer">${voucher.po_bom_code}</option>`);
                        }
                        
                        if (voucher.bom_code && voucher.bom_code != null && voucher.bom_code_id > 0) {
                              $('#voucher_transaction_form  #bom_code').append(`<option value="${voucher.bom_code_id}" data-voucher-id="${voucher.voucher_id}" data-type="NonTransfer">${voucher.bom_code}</option>`);
                        }
                      });
                  }
              });
             
          }
        } else {
            console.error("Expected an array but got:", data);
        }
    },
    
      error: function(xhr, status, error) {
          console.error("Error fetching voucher head data:", error);
      }
  });
}


function getAllProject(){
  $.ajax({
  url : "get_all_project_list",
  type:'POST',
  data:{},
  success:function(response)
  {
      response = JSON.parse(response);
     
      var project_opt = "<option value=''>Select Project</option>";
      var projects = response.users;
      for(let i=0;i<projects.length;i++){
          project_opt += `<option value='${projects[i].id}'>${projects[i].text}</option>`;
      }
      $(".allProjectDropDown").html(project_opt).select2();
      $("#voucher_type,#p_head_drop,#o_head_drop").select2();
      
 
  }
});
}