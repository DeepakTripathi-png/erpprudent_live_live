$( document ).ready(function() {
    getAllProject()
    // alert("ok")

    // $('#po_number').select2({
    //     placeholder: "Select PO Number",
    //     allowClear: true
    // });

    
    // $('#project_id').on('change', function () {
    //     var project_id = $(this).val();
    //     $(".grn_info").addClass('hide') 
    //     $.ajax({
    //         url : "get_all_po_by_project_id",
    //         type:'POST',
    //         data:{project_id:project_id},
    //         success: function (response) {
    //             response = JSON.parse(response); 
    //             console.log(response);
    //             $('#po_number').empty();
    //             $('#po_number').append('<option value="">Select Po Number</option>');
    //             response.data.forEach(function (po) {
    //                 $('#po_number').append('<option value="' + po + '">' + po + '</option>');
    //             });
    //         },
    //         error: function (xhr, status, error) {
    //             console.error('Error fetching PO numbers:', error);
    //         }
    //       });
    // });

$('#project_id').on('change', function () {
    var project_id = $(this).val();
    $(".grn_info").addClass('hide');

    $.ajax({
        url: "get_all_po_by_project_id",
        type: 'POST',
        data: { project_id: project_id },
        dataType: 'json', // Ensure response is automatically parsed
        success: function (response) {
            // console.log("API Response:", response); // Debugging

            $('#po_number').empty();
            $('#po_number').append('<option value="">Select PO Number</option>');

            if (response.data && typeof response.data === "object") {
                Object.values(response.data).forEach(function (po) {
                    $('#po_number').append('<option value="' + po + '">' + po + '</option>');
                });
            } else {
                console.error("Expected an object in response.data, but got:", response.data);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching PO numbers:', error);
        }
    });
});



    $('#po_number').on('change', function () {
        var po_number = $(this).val(); 
        $.ajax({
            url : "get_all_grn_by_po_number",
            type:'POST',
            data:{po_number:po_number},
            success: function (response) {
                try {
                    response = JSON.parse(response); 
                    // console.log(response.data);
                   var total_po_amount = response.total_po_amount;
                   var total_advance_payment = response.total_advance_payment;
                   var total_used_advance_payment = response.total_used_advance_payment;
                    $("#po_amount").val(total_po_amount);
                    $("#advance_payment").val(total_advance_payment);
                    $("#total_used_advance_payment").val(total_used_advance_payment);
                    let tableBody = $(".grn_table_details tbody"); // Select the table's <tbody>
            
                    tableBody.empty();
            
                    if (response.data && response.data.length > 0) {
                        // If data is available, loop through and append rows
                        response.data.forEach(function (item, index) {
                            let balanceAmount = parseFloat(item.total_amount || 0) - parseFloat(item.advance_payment || 0);
                
                            let newRow = `
                               <tr>
                                    <th scope="row">
                                        ${index + 1}
                                        <input type="hidden" name="row_index[]" value="${index + 1}" />
                                    </th>
                                    <td>
                                        ${item.grn_number || '-'}
                                        <input type="hidden" name="grn_number[]" value="${item.grn_number || '-'}" />
                                    </td>
                                    <td class="grn-amount">
                                        ${parseFloat(item.total_amount || 0).toFixed(2)}
                                        <input type="hidden" name="grn_amount[]" value="${parseFloat(item.total_amount || 0).toFixed(2)}" />
                                        
                                    </td>
                                    <td class="total-amount">
                                        ${parseFloat(item.total_amount || 0).toFixed(2)}
                                         <input type="hidden" name="total_amount[]" value="${parseFloat(item.total_amount || 0).toFixed(2)}" />
                                        
                                    </td>
                                    <td class="advance-amount">
                                       <input type="text" class="form-control" name="advance_amount[]" placeholder="Enter amount" style="width: 100px;" />
                                  
                                        
                                    </td>
                                    <td>
                                    ${parseFloat(item.settled_amount || 0).toFixed(2)}
                                        <input type="hidden" name="settled_amount[]" value="${parseFloat(item.settled_amount || 0).toFixed(2)}" />
                                    </td>
                                   
                                    <td class="balance-amount">
                                        ${parseFloat(item.balance_amount || 0).toFixed(2)}
                                        <input type="hidden" name="balance_amount[]" value="${parseFloat(item.balance_amount || 0).toFixed(2)}" />
                                       
                                    </td>
                                    <td class="old-balance-amount hide">
                                        ${parseFloat(item.balance_amount || 0).toFixed(2)}
                                       
                                       
                                    </td>
                                    <td>
                                    ${item.payout_status || '-'}
                                        <input type="hidden" name="payout_status[]" value="${item.payout_status || '-'}" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control onlyNumericInput" name="percentage[]" placeholder="Enter %" style="width: 100px;" />
                                        <input type="hidden" class="form-control total_percengae"  value="100" />
                                      
                                    </td>
                                    <td class="amount">
                                        -
                                        <input type="hidden" name="amount_percentage[]" value="" />
                                      
                                    </td>
                                    <td class="remove-grn-data">
                                      <div class="addDeleteButton"><span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span></div>
                                    </td>
                                </tr>

                            `;
                
                            tableBody.append(newRow);
                            $(".btn-success").prop("disabled", false);
                        });
                    } else {
                        // If no data is available, append a single row with colspan
                        let noDataRow = `
                            <tr>
                                <td colspan="11" class="text-center">No data available</td>
                            </tr>
                        `;
                        tableBody.append(noDataRow);
                        $(".btn-success").prop("disabled", true);

                    }
                    $(".grn_info").removeClass('hide')
            
                } catch (error) {
                    console.error('Error processing the response:', error);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data:', error);
            }
            
          });
    });

    $("#payout_form").validate({
        rules: {
            project_id: {
                required: true
            },
            // po_number: {
            //     required: true
            // },
            payment_date: {
                required: true,
                date: true
            },
            payment_mode: {
                required: true
            },
            'amount[]': {
                required: true
            },
        },
        messages: {
            project_id: {
                required: "Please select a project."
            },
            // po_number: {
            //     required: "Please select a PO number."
            // },
            payment_date: {
                required: "Please select a payment date.",
                date: "Please enter a valid date."
            },
            payment_mode: {
                required: "Please select a payment mode."
            },
            'amount[]': {
                required: 'Please enter amount.'
            },
        },
        errorElement: "span",
        errorClass: "text-danger",
        // highlight: function (element) {
        //     $(element).closest('.form-group').addClass('has-error');
        // },
        // unhighlight: function (element) {
        //     $(element).closest('.form-group').removeClass('has-error');
        // },
        errorPlacement: function (error, element) {
            error.insertAfter(element); // Place the error message after the element
        },
        submitHandler: function (form) {
            var formData = new FormData(form);
            $.ajax({
                url : "save_payout",
                type:'POST',
                data: formData,
                processData: false,
                contentType: false,
                success:function(response)
                {
                    var res = JSON.parse(response);
                    $(".alert-container").removeClass("hide");
                    if(res.success == 1) {
                        $(".alert-container").html('<div class="alert modify alert-success">' + res.messages + '</div>');
                        setTimeout(function() {
                            $(".alert-container").addClass("hide");
                        $(".alert-container").html('');
                        window.location.href = "payout";
                        }, 3000);
                    } else {
                        $(".alert-container").html('<div class="alert modify alert-danger">' + res.messages + '</div>');
                        setTimeout(function() {
                            $(".alert-container").addClass("hide");
                        },3000);
                    }
               
                }
              });
        }
    });

    // $(document).on('input', '.onlyNumericInput', function () {
    //     var  $row = $(this).closest('tr'); 
    //     var balanceAmount = parseFloat($row.find('.balance-amount').text()); 
    //     var percentage = parseFloat($(this).val()); 
    //     var total_percentage = parseFloat($(this).val()); 
    //     if (isNaN(percentage) || percentage < 0) {
    //         percentage = 0; 
    //     }

    //     const calculatedAmount = (percentage / 100) * balanceAmount;

    //     if (calculatedAmount > balanceAmount) {
    //         $(this).val((balanceAmount / balanceAmount) * 100); 
    //         $row.find('.amount').text(balanceAmount.toFixed(2));
    //         $row.find('input[name="amount_percentage[]"]').val(balanceAmount.toFixed(2)); // Update hidden input
    //     } else {
    //         $row.find('.amount').text(calculatedAmount.toFixed(2)); 
    //         $row.find('input[name="amount_percentage[]"]').val(calculatedAmount.toFixed(2)); // Update hidden input
            
    //     }
       
        
    // });

    checkAdvancePayment(); // Initialize on page load


    // $(document).on("input", "input[name='advance_amount[]']", function () {
    //     let row = $(this).closest("tr");  
    //     let totalAmount = parseFloat(row.find("input[name='grn_amount[]']").val()) || 0;  
    //     let advanceInput = row.find("input[name='advance_amount[]']");  
    //     let balance_amount = parseFloat(row.find("input[name='balance_amount[]']"));  
    //     let advanceAmount = parseFloat(advanceInput.val()) || 0;  
    //     let advance_payment = $("input[name='total_used_advance_payment']").val();  
    //     if (advanceAmount > advance_payment) {
    //         // alert("Advance amount cannot exceed total amount!");
    //         bootbox.alert("Advance amount cannot exceed total amount!", function() {});
    //         advanceInput.val("");  
    //         advanceAmount = 0;  
    //     }
    //     let balanceAmount = totalAmount - advanceAmount;
    //     row.find(".total-amount").text(balanceAmount.toFixed(2));   
    //     let balanceInput = row.find(".total-amount input[name='total_amount[]']");  
    //     balanceInput.val(balanceAmount.toFixed(2));  

    //     let balanceAmount1 = balance_amount - advanceAmount;
    //     console.log(balanceAmount1);
        
    //     row.find(".balance-amount").text(balanceAmount1.toFixed(2));   
    //     let balanceInput1 = row.find(".balance-amount input[name='balance_amount[]']");  
    //     balanceInput1.val(balanceAmount1.toFixed(2)); 
   
    // });
    
    
    $(document).on("input", "input[name='advance_amount[]']", function () {
        let row = $(this).closest("tr");  
        let totalAmount = parseFloat(row.find("input[name='grn_amount[]']").val()) || 0;  
        let advanceInput = row.find("input[name='advance_amount[]']");  
        let balance_amount = parseFloat(row.find(".old-balance-amount").text()) || 0; 
        let advanceAmount = parseFloat(advanceInput.val()) || 0;  
        let advance_payment = parseFloat($("input[name='total_used_advance_payment']").val()) || 0;  
    
        if (advanceAmount > advance_payment) {
            bootbox.alert("Advance amount cannot exceed total amount!", function() {});
            advanceInput.val("");  
            advanceAmount = 0;  
        }
    
        let balanceAmount = totalAmount - advanceAmount;
        row.find(".total-amount").text(balanceAmount.toFixed(2));   
        row.find("input[name='total_amount[]']").val(balanceAmount.toFixed(2));  
    
        let balanceAmount1 = balance_amount - advanceAmount;  
        console.log(balance_amount); 
        console.log(balanceAmount1); 
    
        row.find(".balance-amount").text(balanceAmount1.toFixed(2));   
        row.find("input[name='balance_amount[]']").val(balanceAmount1.toFixed(2)); 
    });
    

    $(document).on('input', '.onlyNumericInput', function () {
        var $row = $(this).closest('tr'); 
        var balanceAmount = parseFloat($row.find('.balance-amount').text());
        // var balanceAmount = parseFloat($row.find('.total-amount').text());
      
        
        var enteredPercentage = parseFloat($(this).val());
        var totalPercentage = parseFloat($row.find('.total_percengae').val());
        if (isNaN(enteredPercentage) || enteredPercentage < 0) {
            enteredPercentage = 0;
        }
        const calculatedAmount = (enteredPercentage / 100) * balanceAmount;
        if (enteredPercentage > totalPercentage) {
            enteredPercentage = totalPercentage;
            $row.find('.onlyNumericInput').val(enteredPercentage); 
        }
        if (calculatedAmount > balanceAmount) {
            calculatedAmount = balanceAmount;
        }
        $row.find('.amount').text(calculatedAmount.toFixed(2)); 
        $row.find('input[name="amount_percentage[]"]').val(calculatedAmount.toFixed(2)); 
        // var remainingPercentage = totalPercentage - enteredPercentage;
        // $row.find('.remaining-percentage').text(remainingPercentage.toFixed(2) + '%');
    });
    

   
    var payout_list = $('#payout_list').DataTable({
        ajax: {
            url: "get_payout_list", // Controller endpoint
            type: "POST",
        },
        columns: [
            { data: 'bp_code' },
            { data: 'payout_number' },
            { data: 'po_number' },
            { data: 'settled_amount' },
            { data: 'payment_date' },
            { data: 'status' },
            { data: 'action', orderable: false, searchable: false }
        ],
        columnDefs: [
            { targets: "_all", className: "text-center align-middle" }
        ],
        paging: true,
        searching: true,
        ordering: true,
        responsive: true,
        lengthMenu: [10, 25, 50],
        dom: 'Bfrtip', 
        buttons: [
            'copy', 
            'excel', 
            {
                extend: 'pdf',
                title: 'Payout', 
                orientation: 'landscape', 
                pageSize: 'A4', 
            },
            'print', 
            'colvis', 
        ],
    });
    
    

    $(document).on('change','.statusselectbom' , function(e){
        var this1 = $(this);
        bootbox.confirm("Are you sure?", function(result) 
        {
            if(result)
            {
                var payout_id = this1.attr('data-payout-id');
                var url = this1.attr('rev');   
             
                        
                var status = this1.val(); 
                
                $.ajax({
                    url : completeURL(url),
                    type:'POST',
                    dataType:'json',
                    data:{payout_id:payout_id,status:status},
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


    // $(document).on('click', '.editRecordPayout', function (e) {
    //     e.preventDefault();
    //     var payout_id = $(this).data('payout-id');
    
    //     $.ajax({
    //         url: "edit_payout_data",
    //         type: 'POST',
    //         data: { payout_id: payout_id },
    //         success: function (response) {
    //             try {
    //                 response = JSON.parse(response);
    //                 var res = response.data;
    //                 // console.log(res);
                    
    //                 // Set form values
    //                 $("#payout_id").val(res[0].payout_id);
    //                 $("#project_id").val(res[0].project_id).prop("readonly", true)
    //                 .trigger("change");
    //                 $("#po_number").val(res[0].po_number).prop("readonly", true)
    //                 // .trigger("change");
    //                 $("#payment_date").val(res[0].payment_date).prop("readonly", true);
    
    //                 // Reset table body to prevent duplicate rows
    //                 var tbody = $(".grn_table_details tbody");
    //                 tbody.innerHTML = ""; // Clear previous rows
    
    //                 // Populate the table with new data
    //                 res.forEach((item, index) => {
    //                     var row = `
    //                         <tr>
    //                             <th scope="row">
    //                                 ${index + 1}
    //                                 <input type="hidden" name="row_index[]" value="${index + 1}" />
    //                                 <input type="hidden" name="pi_id[]" value="${item.pi_id}" />
    //                             </th>
    //                             <td>
    //                                 ${item.grn_number || '-'}
    //                                 <input type="hidden" name="grn_number[]" value="${item.grn_number || '-'}" />
    //                             </td>
    //                             <td class="grn-amount">
    //                                     ${parseFloat(item.total_amount || 0).toFixed(2)}
    //                                     <input type="hidden" name="grn_amount[]" value="${parseFloat(item.grn_amount || 0).toFixed(2)}" />
                                        
    //                                 </td>
    //                             <td class="total-amount">
    //                                 ${parseFloat(item.total_amount || 0).toFixed(2)}
    //                                 <input type="hidden" name="total_amount[]" value="${parseFloat(item.total_amount || 0).toFixed(2)}" />
    //                             </td>
    //                              <td class="advance-amount">
    //                                    <input type="text" class="form-control" name="advance_amount[]" placeholder="Enter amount" style="width: 100px;" value="${parseFloat(item.advance_amount || 0).toFixed(2)}" />
                                  
                                        
    //                                 </td>
    //                             <td>
    //                             ${parseFloat(item.settled_amount || 0).toFixed(2)}
    //                                 <input type="hidden" name="settled_amount[]" value="-" />
    //                             </td>
    //                             <td class="balance-amount">
    //                                 ${parseFloat(item.balance_amount || 0).toFixed(2)}
    //                                 <input type="hidden" name="balance_amount[]" value="${parseFloat(item.balance_amount || 0).toFixed(2)}" />
    //                             </td>
    //                             <td>
    //                                 ${item.payout_status || 'Unpaid'}
    //                                 <input type="hidden" name="payout_status[]" value="${item.payout_status || 'Unpaid'}" />
    //                             </td>
    //                             <td>
    //                                     <input type="text" class="form-control onlyNumericInput" name="percentage[]" placeholder="Enter %" style="width: 100px;" />
    //                                     <input type="hidden" class="form-control total_percengae"  value="${100 - item.percentage || '-'}" />
                                      
    //                                 </td>
    //                             <td class="amount">
    //                                 -
    //                                 <input type="hidden" name="amount_percentage[]" />
    //                             </td>
    //                             <td class="remove-grn-data">
    //                                   <div class="addDeleteButton"><span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span></div>
    //                                 </td>
    //                         </tr>
    //                     `;
    //                     tbody.insertAdjacentHTML("beforeend", row); // Append the new row
    //                 });
    
    //             } catch (error) {
    //                 console.error("Error parsing response:", error);
    //                 alert("An error occurred while processing the data. Please try again.");
    //             }
    //         },
    //         error: function () {
    //             alert("Failed to fetch data. Please check the server connection.");
    //         }
    //     });
    // });
    
    $(document).on("click", ".editRecordPayout", function (e) {
        e.preventDefault();
        var payout_id = $(this).data("payout-id");
    
        $.ajax({
            url: "edit_payout_data",
            type: "POST",
            data: { payout_id: payout_id },
            success: function (response) {
              
                    response = JSON.parse(response);
                    var res = response.data;
                    console.log(response);
                    
                    if (!res || res.length === 0) {
                        alert("No data found for this payout.");
                        return;
                    }
    
                    // Set form values
                    $("#edit_payout_number").removeClass('hide')   
                    $("#payout_id").val(res[0].payout_id);
                    $("#project_id").val(res[0].project_id).prop("readonly", true).trigger("change");
                    $("#po_number").val(res[0].po_number).prop("readonly", true).addClass('hide');
                    $("#edit_payout_number").val(res[0].po_number).prop("readonly", true);
                    $("#payment_date").val(res[0].payment_date).prop("readonly", true);
                    $("#po_amount").val(res[0].po_amount);
                    $("#advance_payment").val(res[0].advance_payment);
                    $("#total_used_advance_payment").val(response.total_used_advance_payment);
                     $(".grn_info").removeClass('hide')   
                    
                    // Reset table body to prevent duplicate rows
                    var tbody = $(".grn_table_details tbody");
                    tbody.html(""); // Corrected: jQuery equivalent of innerHTML = ""
    
                    // Populate the table with new data
                    res.forEach((item, index) => {
                        var row = `
                            <tr>
                                <th scope="row">
                                    ${index + 1}
                                    <input type="hidden" name="row_index[]" value="${index + 1}" />
                                    <input type="hidden" name="pi_id[]" value="${item.pi_id || ""}" />
                                </th>
                                <td>
                                    ${item.grn_number || "-"}
                                    <input type="hidden" name="grn_number[]" value="${item.grn_number || "-"}" />
                                </td>
                                <td class="grn-amount">
                                    ${parseFloat(item.grn_amount || 0).toFixed(2)}
                                    <input type="hidden" name="grn_amount[]" value="${parseFloat(item.grn_amount || 0).toFixed(2)}" />
                                </td>
                                <td class="total-amount">
                                    ${parseFloat(item.total_amount || 0).toFixed(2)}
                                    <input type="hidden" name="total_amount[]" value="${parseFloat(item.total_amount || 0).toFixed(2)}" />
                                </td>
                                <td class="advance-amount">
                                    <input type="text" class="form-control" name="advance_amount[]" placeholder="Enter amount" style="width: 100px;" value="${parseFloat(item.advance_amount || 0).toFixed(2)}" />
                                </td>
                                <td>
                                    ${parseFloat( 0).toFixed(2)}
                                    <input type="hidden" name="settled_amount[]" value="${parseFloat(item.settled_amount || 0).toFixed(2)}" />
                                </td>
                                <td class="balance-amount">
                                    ${parseFloat(item.balance_amount || 0).toFixed(2)}
                                    <input type="hidden" name="balance_amount[]" value="${parseFloat(item.balance_amount || 0).toFixed(2)}" />
                                    <input type="hidden" name="old-balance_amount[]" value="${parseFloat(item.balance_amount || 0).toFixed(2)}" />
                                </td>
                                 <td class="old-balance-amount hide">
                                    ${parseFloat(item.balance_amount || 0).toFixed(2)}
                                   
                                </td>
                               
                                <td>
                                    ${item.payout_status || "Unpaid"}
                                    <input type="hidden" name="payout_status[]" value="${item.payout_status || "Unpaid"}" />
                                </td>
                                <td>
                                    <input type="text" class="form-control onlyNumericInput" name="percentage[]" placeholder="Enter %" style="width: 100px;" value="${parseFloat(item.percentage || 0).toFixed(2)}" />
                                  
                                    <input type="hidden" class="form-control total_percengae" value="100" />
                                </td>
                                <td class="amount">
                                     ${parseFloat(item.settled_amount || 0).toFixed(2)}
                                    <input type="hidden" name="amount_percentage[]" />
                                </td>
                                <td class="remove-grn-data">
                                    <div class="addDeleteButton">
                                        <span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;">
                                            <i class="fa fa-trash-o"></i>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        `;
                        tbody.append(row); // Corrected: Use jQuery append instead of insertAdjacentHTML
                    });
    
                
            },
            error: function () {
                alert("Failed to fetch data. Please check the server connection.");
            },
        });
    });
    


    $('#payout_list tbody').on('click', '.openview', function () {
        // Toggle button text between "CLOSE" and "VIEW"
        $(this).text(function (i, text) {
            return text === "CLOSE" ? "VIEW" : "CLOSE";
        });
    
        // Extract data attributes
        const payout_id = $(this).attr('data-payout-id');
        const payout_item_id = $(this).attr('data-payout-item-id');
        const tr = $(this).closest('tr');
        
        if (typeof payout_list === "undefined") {
            console.error("payout_list DataTable is not defined!");
            return;
        }
    
        const row = payout_list.row(tr);
    
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            const divwidth = $("#bomtranslist").width();
            const divminwidth = divwidth - 20;
    
            let filterhtml = '';
            const download_title = 'Payout Details';
    
            const html = `
                <div class="portlet-body form" id="displayed${payout_id}">
                    <div class="displayFlx" style="margin-bottom: 15px; display: flex;">
                        ${filterhtml}
                    </div>
                    <div id="originalpbomviewdiv${payout_id}">
                        <div class="table-responsive">
                            <table width="100%" id="originalpbomview${payout_id}" class="table table-striped table-bordered table-hover" style="text-align: left;">
                                <thead style="background: #26a69a; color: #fff; font-weight: 400;">
                                    <tr>
                                        <th scope="col" style="vertical-align: top;">Sr.no</th>
                                        <th scope="col" style="vertical-align: top;">GRN No</th>
                                        <th scope="col" style="vertical-align: top;">GRN Amount</th>
                                        <th scope="col" style="vertical-align: top;">Advance Amount</th>
                                        <th scope="col" style="vertical-align: top;">Total Amount</th>
                                        <th scope="col" style="vertical-align: top;">Amount Paid</th>
                                        <th scope="col" style="vertical-align: top;">Balance Amount</th>
                                        <th scope="col" style="vertical-align: top;">Status</th>
                                        <th scope="col" style="vertical-align: top;">Percentage (%)</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            `;
    
            row.child(html).show();
            tr.addClass('shown');
    
            // Initialize DataTable
            const table2 = $(`#originalpbomview${payout_id}`).DataTable({
                dom: 'Bfrtip',
                scrollY: 400,
                scrollX: true,
                scroller: true,
                fixedHeader: {
                    header: true,
                    footer: true,
                },
                ajax: {
                    url: `${base_url}payout_list_display`,
                    type: "POST",
                    data: { payout_id: payout_id,payout_item_id:payout_item_id },
                    error: function (xhr, error, thrown) {
                        console.error("Error fetching data:", error, thrown);
                    },
                },
                lengthMenu: [
                    [25, 50, 75, 100, 125, 150, -1],
                    ['25 rows', '50 rows', '75 rows', '100 rows', '125 rows', '150 rows', 'Show all'],
                ],
                buttons: [
                    'pageLength',
                    { extend: 'copy', title: download_title, footer: true },
                    {
                        extend: 'excel',
                        title: download_title,
                        footer: true,
                        customize: function (xlsx) {
                            const sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row c[r^="C"]', sheet).attr('s', '55');
                        },
                    },
                    { extend: 'pdf', title: download_title, footer: true },
                    { extend: 'print', title: download_title, footer: true },
                ],
                autoWidth: false,
                destroy: true,
                paging: true,
                displayLength: 25,
                deferRender: true,
                responsive: true,
                processing: true,
                serverSide: true,
                order: [[1, 'asc']],
                columnDefs: [
                    { targets: [0], orderable: false },
                    { targets: [3, 4, 5, 6], className: "text-right" },
                ],
            });
    
            new $.fn.dataTable.FixedHeader(table2);
        }
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

function checkAdvancePayment() {
    let advancePayment = parseFloat($("#advance_payment").val()) || 0;
    let advanceInputs = $("input[name='advance_amount[]']");
    console.log("advancePayment : " + advancePayment);
    console.log("advanceInputs : " + advanceInputs);
    
    if (advancePayment == 0) {
        advanceInputs.val(0).prop("readonly", true);
    } else {
        advanceInputs.prop("readonly", false);
    }
}





function calculateTotal(input) {
    let advancePayment = parseFloat($("#advance_payment").val()) || 0;
    let total = 0;

    $("input[name='advance_amount[]']").each(function () {
        total += parseFloat($(this).val()) || 0;
    });

    if (total > advancePayment) {
        // alert("Total advance amount cannot exceed the advance payment!");
        bootbox.alert("Total advance amount cannot exceed the advance payment!", function() {});
        input.val("");
    }
}