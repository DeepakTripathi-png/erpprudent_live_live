var mode = "add";
$(document).ready(function() {
    $('#voucher_type').on('change', function() {
        var selectedValue = $(this).val();
        $('.office_expense').addClass('hide');
        $('.project_expense').addClass('hide');
        if (selectedValue === 'Office Expense') {
            $('.office_expense').removeClass('hide');
            office_head(selectedValue);
        } else if (selectedValue === 'Project Expense') {
            $('.project_expense').removeClass('hide');
        }
    });

    $('#qty').on('input', function() {
      var qty = parseFloat($(this).val()) || 0;
      var max_qty = parseFloat($(this).attr("data-max"));
      var rate = parseFloat($('#rate').val()) || 0;
      if (qty > max_qty) {
          qty = max_qty;
          $(this).val(qty);  
      }
  
      var amount = qty * rate;
      $('#amount').val(amount.toFixed(2)); 
  });
  



    addFinancialYears()

    // $('#qty, #rate').on('input', calculateAmount);


    var download_title = 'Voucher System List';
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
        "sEmptyTable": "No Voucher System Data Found!"
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
    $.validator.addMethod("lessThan", function(value, element) {  
        var voucher_type = $("#voucher_type").val();
        var amount_val = parseFloat($("#amount").val());
        let amount = parseFloat($("#amount").attr("data-max"));
        let validate = true;
        if(voucher_type == "Project Expense" && amount_val > amount){
            validate = false;
        }
    return validate;
    },  function() {
        // Dynamically create the error message
        return "Amount should be less than or equal to " + $("#amount").attr("data-max") + ".";
    });
    $.validator.addMethod("greaterThan", function(value, element) {  
      var voucher_type = $("#voucher_type").val();
      var amount_val = parseFloat($("#amount").val());
      let validate = true;
      if(voucher_type == "Project Expense" && amount_val < 1){
          validate = false;
      }
  return validate;
  },  function() {
      // Dynamically create the error message
      return "Amount should be greater than 0.";
  });
    $("#voucher_form").validate({

        rules: {
        voucher_type: {
            required: true
        },
        // p_head: {
        //     required: function() {
        //         return $("#voucher_type").val() === "Project Expense";
        //     }
        // },
        bom_code: {
            required: function() {
                return $("#voucher_type").val() === "Project Expense";
            }
        },
        rate: {
            required: function() {
                return $("#voucher_type").val() === "Project Expense";
            }
        },
     
        project_id: {
            required: function() {

                return $("#voucher_type").val() === "Project Expense";
            }
        },
        p_voucher_date: {
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
        o_voucher_date: {
            required: function() {
                return $("#voucher_type").val() === "Office Expense";
            }
        },
      //   p_amount: {
      //     required: function() {
      //         return $("#voucher_type").val() === "Project Expense";
      //     },
          
      //     // lessThan: true,
      //     // greaterThan:true
      // },
      p_qty: {
        required: function() {
            return $("#voucher_type").val() === "Project Expense";
        },
      },
        
      
    },
    messages: {
        voucher_type: {
            required: "Please select Voucher Type."
        },
        // p_head: {
        //     required: "Please select head for Office Expense."
        // },
        bom_code: {
            required: "Please enter bom code for Project budget."
        },
        rate: {
            required: "Please enter rate for Project budget."
        },
        project_id: {
            required: "Please select project for Project budget."
        },
        p_voucher_date: {
            required: "Please select Voucher Date."
        },
        p_qty: {
          required: "Please enter qty.",
        },
        o_head: {
            required: "Please enter head for Office budget."
        },
        o_amount: {
            required: "Please enter amount for Office budget."
        },
        o_voucher_date: {
            required: "Please select Voucher Date."
        },
        // p_amount: {
        //     required: "Please enter amount for Project Expense.",
        // },
        
        
       
    },
        errorPlacement: function(error, element) {
          error.insertAfter(element);
          
        },
        submitHandler: function(form) {
          var formData = new FormData(form);
          var bom_type = $('option:selected', "#bom_code").attr('data-type');
          formData.append('bom_type', bom_type);
          $.ajax({
            url: "save_voucher_data",
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
                var voucher_id = this1.attr('data-voucher-id');
                var url = this1.attr('rev');   
                var project_id = this1.attr('data-project_id');   
                        
                var status = this1.val(); 
                
                $.ajax({
                    url : completeURL(url),
                    type:'POST',
                    dataType:'json',
                    data:{voucher_id:voucher_id,status:status,project_id:project_id},
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
    var project_search = false;
    $(document).off('change', '#project_id');
    $(document).on('change', '#project_id', function(e) {
      // if(mode == "add"){
        var project_id = $(this).val();
        $('#bom_code').val(''); 
        $('input[name="p_qty"]').val(""); 
        $('input[name="description"]').val(""); 
        $('input[name="p_rate"]').val(""); 
        $('input[name="p_amount"]').val("");
        $(".error").html(""); 
        $.ajax({
          url : "get_all_bom_code_by_project_id",
          type:'POST',
          data:{project_id:project_id},
          success:function(response)
          {
              response = JSON.parse(response);
              var opt_val = '<option value="">Select Bom Code</option>';
              for (var i = 0; i < (response.final_opt).length; i++) {
                  opt_val += `<option value="${response.final_opt[i]['key']}" data-type="${response.final_opt[i]['type']}">${response.final_opt[i]['val']}</option>`;
              }
              bom_search = true;
              $("#bom_code").html(opt_val).trigger("change");

              var po_opt_val = '<option value="">Select Po Number</option>';
              for (var i = 0; i < (response.po_number).length; i++) {

                  po_opt_val += `<option value="${response.po_number[i]}" >${response.po_number[i]}</option>`;
              }
              project_search = true;
              $("#po_number").html(po_opt_val).trigger("change");
              
              
           
          }
        });
      // }
    });
    var bom_search = false;
    $(document).off('change', '#po_number');
    $(document).on('change', '#po_number', function(e) {
      if(!project_search && mode == "add"){
          var project_id = $("#project_id").val();
          var po_number = $(this).val();
          $('input[name="p_qty"]').val(""); 
          $('input[name="description"]').val(""); 
          $('input[name="p_rate"]').val(""); 
          $('input[name="p_amount"]').val("");
          $.ajax({
            url : "get_all_bom_code_by_project_id",
            type:'POST',
            data:{project_id:project_id,po_number:po_number},
            success:function(response)
            {
                  response = JSON.parse(response);
                  var opt_val = '<option value="">Select Bom Code</option>';
                  for (var i = 0; i < (response.final_opt).length; i++) {
                      opt_val += `<option value="${response.final_opt[i]['key']}" data-type="${response.final_opt[i]['type']}">${response.final_opt[i]['val']}</option>`;
                  }
                  bom_search = true;
                  $("#bom_code").html(opt_val).trigger("change");        
            }
            });
        }else{
            project_search = false;
            
        }
    });
    
    $(document).off('change', '#bom_code');
     $('#bom_code').on('change', function() {
      var voucher_id = $("#voucher_form input[name='voucher_id']").val();
      var bom_code = $(this).val();
      var type = $('option:selected', this).attr('data-type');
      var project_id = $("#project_id").val();
      var po_number = $("#po_number").val();
      console.log(bom_search,voucher_id,bom_code)
      if(!(voucher_id > 0) && !bom_search && mode == "add"){
        $('#qty').val(""); 
        $("#voucher_form #description").val("");
        $("#voucher_form #amount").val(0);
        $("#voucher_form #amount").attr("data-max",0)
        if(bom_code != "" ){
            $.ajax({
              url : "get_bom_code_data_by_code",
              type:'POST',
              data:{bom_code:bom_code,project_id:project_id,voucher_id:voucher_id,type:type,po_number:po_number},
              success:function(data)
              {
                var res  = JSON.parse(data);
                $("#voucher_form #description").val(res.description)
                $("#voucher_form #amount").val(res.amount)
                $("#voucher_form #qty").val(res.qty)
                $("#voucher_form #rate").val(res.rate)
                $("#voucher_form #qty").attr("data-max",res.qty)
         
              }
          });
        }
      }else{
        bom_search = false;
        
      }
  });
  
    
    getAllProject();
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
            $("#voucher_type,#p_head_drop").select2();
            
       
        }
      });
    }
    $(document).on('click', '.edit_voucher_data', function(e) {
      e.preventDefault(); 
      var voucher_id = $(this).data('voucher-id');
      var project_id = $(this).data('project_id');
      $.ajax({
        url : "edit_voucher_data",
        type:'POST',
        data:{voucher_id:voucher_id},
        success:function(response)
        {
            response = JSON.parse(response);
            var res = response.data;
            $("#voucher_type").val(res.voucher_type).trigger("change").prop("readonly", true);
            $("input[name='voucher_id']").val(res.voucher_id);
            mode = "Update";
            var downloadLink ="";
            if (res.voucher_type == "Project Expense") {
              $("#project_id").val(res.project_id).trigger('change');
              $("#voucher_form").prepend("<input name='project_id' value='"+res.project_id+"' type='hidden'>")
              $(".allProjectDropDown").select2("enable", false);
              $("#voucher_form").prepend("<input name='p_head' value='"+res.head+"' type='hidden'>")
              $("#p_head_drop").val(res.head).trigger("change").select2("enable", false);
              $("input[name='p_qty']").val(res.qty)
              $("input[name='p_qty']").attr("data-max",res.max_qty)
              $("input[name='p_rate']").val(res.rate)
              $("input[name='p_amount']").val(res.amount).prop("readonly", true);
              // $("input[name='p_amount']").val(res.amount);
              $("input[name='p_voucher_date']").val(res.voucher_date).prop("readonly", true);
              if(res.attachement != ""){
                $("input[name='hidden_p_attachment']").val(res.attachement)
              downloadLink = '<div><a href="uploads/voucher_system/' + res.attachement + '" download>Download</a></div>';
              $("input[name='p_attachment']").after(downloadLink);
              }
              
              // $("#bom_code").val(res.bom_code).prop("disabled", true).trigger("change");
              $("#voucher_form #amount").attr("data-max",res.max_amount)
             
              $("#description").val(res.description);

              $(".project_expense").removeClass('hide');
              $(".office_expense").addClass('hide');
              if(res.bom_code_type != "po_bom"){
                 $(".po_number_block").hide();

              }
              setTimeout(function(){
                if(res.bom_code_type == "po_bom"){
                   $("#po_number").html(`<option value="${res.po_number}" selected>${res.po_number}</option>`).prop("disabled", true).trigger("change");
                   $("#bom_code").html(`<option value="${res.po_bom_code}" selected>${res.po_bom_code}</option>`).prop("disabled", true).trigger("change");
                }else{
                 $("#bom_code").val(res.bom_code).prop("disabled", true).trigger("change");
                }
              },1000);
              



            } else {
              setTimeout(function(){
                $("#o_head_drop").val(res.head).prop("disabled", true).trigger("change");
                $("#financial_year").val(res.financial_year).prop("disabled", true).trigger("change");
              },300)
              
              $("input[name='o_amount']").val(res.amount)
              $("input[name='o_voucher_date']").val(res.voucher_date).prop("readonly", true);
              if(res.attachement != ""){
                $("input[name='hidden_o_attachment']").val(res.attachement)
                downloadLink = '<div><a href="uploads/voucher_system/' + res.attachement + '" download>Download</a></div>';
                $("input[name='o_attachment']").after(downloadLink);
              }
           
              $(".office_expense").removeClass('hide');
              $(".project_expense").addClass('hide');
            }
            $("#voucher_type").select2("enable", false);
            $("#voucher_form").prepend("<input name='voucher_type' value='"+res.voucher_type+"' type='hidden'>")
       
        }
      });
      
  });
  
  $(document).on("click", ".download-voucher-excel", function() {
    var voucher_id = $(this).attr("data-voucher-id");
 
    $.ajax({
        url: base_url + 'get_voucher_data_for_excel',
        type: 'POST',
        dataType: 'json',
        data: { voucher_id: voucher_id },
        success: function(response) {
            var data = response.data;
            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet('Sheet1');

            // Data for worksheet
            var ws_data = [
                [data.voucher_type],
                [""],
                [""],
                ["Name", data.fullname, "", "Budget Date", data.created_on.split(' ')[0],"","Financial Year",data.financial_year !== null && data.financial_year !== undefined ? data.financial_year : '-'], // only date part
                ["", "", "", "", "", "", "", "", "", "", "", "", "", ""],
                ["Sr. No.", "Date", "BP Code", "Voucher Type", "Head", "BOM Code", "Description", "Qty","Rate","Amount"],
              
                  [
                      "1",
                      data.voucher_date || '-',
                      data.bp_code || '-',
                      data.voucher_type || '-',
                      data.head || '-',
                      data.v_bom_code !== null && data.v_bom_code !== undefined ? data.v_bom_code : '-',
                      
                      data.description !== null && data.description !== undefined ? data.description : '-',
                      data.qty !== null && data.qty !== undefined ? data.qty : '-',
                      data.rate !== null && data.rate !== undefined ? data.rate : '-',
                      // (parseFloat(data.qty) || 0).toFixed(2) || '-'
                      // (parseFloat(data.rate) || 0).toFixed(2) || '-'
                      (parseFloat(data.amount) || 0).toFixed(2) || '-'
                  ],
            
            ];

            // Total row
            var final_amount = [
                ["", "", "", "", "", "", "","", "Total",  (parseFloat(data.amount) || 0).toFixed(2)]
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
              { width: 15 }, // Column 5
              { width: 15 }, // Column 6
              { width: 30 }, // Column 7
              { width: 15 }, // Column 8
              { width: 15 }, // Column 9
              { width: 20 }, // Column 10
             
            ];
            

            // Merge and center title cells
            worksheet.mergeCells(1, 1, 2, 10);
            worksheet.mergeCells(8, 1, 8, 8);
            worksheet.getCell(1, 1).alignment = centerAlignment;
            worksheet.getCell(1, 1).font = { size: 20, bold: true };
            worksheet.getCell(8, 7).font = {bold: true };
            worksheet.getCell(8, 8).font = {bold: true };
            worksheet.getCell(4, 2).font = {bold: true };
            worksheet.getCell(4, 5).font = {bold: true };
            worksheet.getCell(4, 8).font = {bold: true };

            [6, 7, 8].forEach(rowNumber => {
              for (let colNumber = 1; colNumber <= 10; colNumber++) {
                worksheet.getCell(rowNumber, colNumber).border = borderStyle;
              }
            });

            // Export workbook
            workbook.xlsx.writeBuffer().then(function(buffer) {
                const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                saveAs(blob, 'voucher.xlsx');
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching data:', textStatus, errorThrown);
        }
    });
});

    
});

function calculateAmount() {
    var qty = parseFloat($('#qty').val()) || 0; 
    var rate = parseFloat($('#rate').val()) || 0; 
    var amount = qty * rate; 
    $('#amount').val(amount.toFixed(2)); 
}


function office_head(voucher_type) {
  var voucher_type = voucher_type;
  $.ajax({
    url : "get_office_head_data",
    type: 'POST',
    dataType: 'json',
    data: { voucher_type: voucher_type },
    success: function(response) {
      var data = typeof response === 'string' ? JSON.parse(response) : response;
      $('#o_head_drop').empty();
      $('#o_head_drop').append('<option value="">Select Head/Type Of Expense</option>');
      $.each(data, function(index, item) {
        $('#o_head_drop').append('<option value="' + item.head + '">' + item.head + '</option>');
      });
    }
  });
}



function addFinancialYears() {
  const currentDate = new Date();
  let startYear, endYear;

  // Determine start and end year for the current financial year
  if (currentDate.getMonth() >= 3) { // April is month index 3
      startYear = currentDate.getFullYear();
      endYear = startYear + 1;
  } else {
      startYear = currentDate.getFullYear() - 1;
      endYear = currentDate.getFullYear();
  }

  // Current financial year
  const currentYear = `${startYear}-${endYear}`;
  $('#financial_year').append(`<option value="${currentYear}">${currentYear}</option>`);

  // Upcoming financial year
  const upcomingYear = `${startYear + 1}-${endYear + 1}`;
  $('#financial_year').append(`<option value="${upcomingYear}">${upcomingYear}</option>`);
}