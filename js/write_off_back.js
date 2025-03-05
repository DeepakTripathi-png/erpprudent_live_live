$(document).ready(function () {

    var today = new Date();
  var currentDate = today.getFullYear() + '-' +
                    String(today.getMonth() + 1).padStart(2, '0') + '-' +
                    String(today.getDate()).padStart(2, '0');

  $("#date").val(currentDate);

  $('input[name="type"]').on('change', function () {
    const selectedType = $('input[name="type"]:checked').val();
    const $returnAmount = $('#return_amount');
    const hiddenReturnAmountValue = $('#hidden_return_amount').val();

    if (selectedType === 'Write Back') {
        // Remove readonly and clear the prefilled value
        $returnAmount.prop('readonly', false).val('');
    } else if (selectedType === 'Write Off') {
        // Add readonly and set the value to hidden_return_amount's value
        $returnAmount.prop('readonly', true).val(hiddenReturnAmountValue);
    }
});

    $("#write_off_back_form").validate({
      rules: {
        vendor_name: {
          required: true
        },
        type: {
          required: true
        },
        return_amount: {
          required: true,
          number: true
        },
      
      },
      messages: {
        vendor_name: {
          required: "Please enter Vendor Name."
        },
        type: {
          required: "Please select a type (Write Off or Write Back)."
        },
        return_amount: {
          required: "Please enter Return Amount.",
          number: "Please enter a valid numeric value."
        },
       
      },
      errorElement: "span",
      errorClass: "text-danger",
      highlight: function (element) {
        $(element).addClass("is-invalid");
      },
      unhighlight: function (element) {
        $(element).removeClass("is-invalid");
      },
      errorPlacement: function (error, element) {
        if (element.attr("type") === "radio") {
          error.insertAfter(element.closest(".form-check").parent());
        } else if (element.attr("type") === "checkbox") {
          error.insertAfter(element.closest(".form-check-inline"));
        } else {
          error.insertAfter(element);
        }
      },
      submitHandler: function (form) {
        var formData = new FormData(form);
  
        $.ajax({
          url: "save_write_off_back_data", // Update URL as needed
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            try {
              var res = JSON.parse(response);
  
              $(".alert-container").removeClass("hide");
              if (res.success == 1) {
                $(".alert-container").html('<div class="alert modify alert-success">' + res.messages + '</div>');
                setTimeout(function () {
                  $(".alert-container").addClass("hide").html('');
                  location.reload();
                }, 3000);
              } else {
                $(".alert-container").html('<div class="alert modify alert-danger">' + res.messages + '</div>');
                setTimeout(function () {
                  $(".alert-container").addClass("hide").html('');
                }, 3000);
              }
            } catch (e) {
              // console.error("Error parsing response: ", e.message);
              $(".alert-container").html('<div class="alert modify alert-danger">Unexpected error occurred.</div>');
              setTimeout(function () {
                $(".alert-container").addClass("hide").html('');
              }, 3000);
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error: " + textStatus, errorThrown);
            $(".alert-container").html('<div class="alert modify alert-danger">An error occurred during submission.</div>');
            setTimeout(function () {
              $(".alert-container").addClass("hide").html('');
            }, 3000);
          }
        });
  
        return false; // Prevent default form submission
      }
    });


    $("#write_off_back_list").DataTable({
        dom: "Bfrtip",
        columns: column_details,
        info: true,
        buttons: [
            { extend: "excelHtml5", title: "Write Off/Back List" },
            { extend: "pdfHtml5", title: "Write Off/Back List", orientation: "landscape", pageSize: "A4" },
            { extend: "csvHtml5", title: "Write Off/Back List" },
            { extend: "print", title: "Write Off/Back List" }
        ],
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "get_write_off_back_list",
            type: "POST",
            
        },
        // columns: [
          
        //     { data: "vendor_name" },
        //     { data: "type" },
        //     {
        //         data: "payment_clear",
                
        //     },
        //     { data: "return_amount" },
        //     { data: "date" },
        //     {
        //       data: "approval_super_admin",
        //       render: function (data, type, row) {
        //           return createDropdown(data, row, "approval_a_status",'a');
        //       }
        //   },
        // //   {
        // //       data: "approval_b_status",
        // //       render: function (data, type, row) {
        // //           return createDropdown(data, row, "approval_b_status","b");
        // //       }
        // //   },
        // //   {
        // //       data: "approval_c_status",
        // //       render: function (data, type, row) {
        // //           return createDropdown(data, row, "approval_c_status",'c');
        // //       }
        // //   },
        // //   {
        // //       data: "approval_d_status",
        // //       render: function (data, type, row) {
        // //           return createDropdown(data, row, "approval_d_status",'d');
        // //       }
        // //   }
        // ],
        columnDefs: [
            { targets: "_all", className: "text-center align-middle" }
        ]
    });
    

    $(document).on('change','.statusselectbom' , function(e){
      var this1 = $(this);
      bootbox.confirm("Are you sure?", function(result) 
      {
          if(result)
          {
              var wright_off_back_id = this1.attr('data-write-off-back-id');
              var url = 'approve_write_off_back';   
              var approval_status = this1.val();
              var status = this1.val(); 
              console.log(wright_off_back_id)
              $.ajax({
                  url : completeURL(url),
                  type:'POST',
                  dataType:'json',
                  data:{wright_off_back_id:wright_off_back_id,approval_status:approval_status},
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



  });
  


  function createDropdown(status, row, columnName, type) {
    if (status === 'Approved') {
        // Display a span with bold and green text if status is 'approved'
        return `<span style="font-weight: bold; color: green;">Approved</span>`;
    }

    // Display a dropdown for other statuses
    const options = `
        <option value="pending" ${status === 'Pending' ? 'selected' : ''}>Pending</option>
        <option value="approved" ${status === 'Approved' ? 'selected' : ''}>Approve</option>
        <option value="reject" ${status === 'Reject' ? 'selected' : ''}>Reject</option>
    `;

    return `
        <select class="statusselectbom approve_write_off_back" 
            id="statusselect_${columnName}_${row.id}" 
            data-column="${columnName}" 
            data-type="${type}" 
            data-id="${row.id}">
            ${options}
        </select>
    `;
}
