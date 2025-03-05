$(document).ready(function() {
  updatePaymentAmount();
  updatePaymentAndGst();
  
  $('input[name="payment_with_gst"]').change(function() {
    updatePaymentAndGst();
    setTDSTCS("TDS");
    setTDSTCS("TCS");
  });
  if (parseFloat($("#hidden_payment_percent").val()) <= 0 ) {
    console.log("ok")
    $(".payment_receipt_exit_msg").addClass('show');
    $(".payment_receipt_exit_msg").removeClass('hide');
    $('.psupdatesubmit').prop('disabled', true);
  }
  $('#payment_percent').on('input', function() {
    var maxAmount = parseFloat($('#hidden_payment_percent').val()) || 0;
    var enteredAmount = parseFloat($(this).val()) || 0;
    if (enteredAmount > maxAmount) {
      $(this).val(maxAmount);
    }
     updatePaymentAndGst();
  });
  $('#it_ids_percentage').on('change', function() {
   
      setTDSTCS("TDS");
 });
 $('#gtds_percenatge').on('change', function() {
      setTDSTCS("TCS");
 });
 $('#payment_mode').on('change', function() {
  if ($(this).val() === 'PDC') {
      $('#check_number_field, #pdc_date_field').removeClass('hide');
  } else {
      $('#check_number_field, #pdc_date_field').addClass('hide');
  }
});
  $(document).on('input', "#payment_amount", function() {
    var hidden_payment_amount = parseFloat($('#hidden_payment_amount').val());
    var payment_amount = parseFloat($(this).val());
    if(payment_amount > hidden_payment_amount) {
      $(this).val(hidden_payment_amount.toFixed(2));
      payment_amount = hidden_payment_amount;
    }

    if(payment_amount < 0 || payment_amount == 0) {
      $(this).val(hidden_payment_amount.toFixed(2));
      payment_amount = hidden_payment_amount;
    }
  });

  $('input[name="payment_copy"]').change(function() {
    if ($(this).val() === "Yes") {
      $('#payment_document_div').removeClass('hide').addClass('show');
    } else {
      $('#payment_document_div').removeClass('show').addClass('hide');
    }
  });
  $('.onlyNumericInput').on('keypress', function(event) {
    var charCode = (event.which) ? event.which : event.keyCode;

   var value = $(this).val();
   if (value.includes('.')  && charCode == 46 ) {
      event.preventDefault();
   }
    // Allow only digits (0-9) and some specific control keys
      if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !== 46) {
          event.preventDefault();
      }
    
});

$('input[name="statutory_deductions_radio"]').on('change', function() {
  var selectedValue = $(this).val(); 
  var total_amount = $("#total_payable_amount_val").val(); 
  if (selectedValue === 'Yes') {
    $('#it_ids_percentage').prop('disabled', false);
    $('#gtds_percenatge').prop('disabled', false);
    $('#it_ids_amount').prop('disabled', false).val(0.00);
    $('#gtds_amount').prop('disabled', false).val(0.00);
    $('input[name="tax_deduction_description[]"]').prop('disabled', false);
    $('input[name="tax_deduction_amount[]"]').prop('disabled', false);
    $('.add-tax-deduction').prop('disabled', false);
  } else if (selectedValue === 'No') {
    $('#it_ids_amount').prop('disabled', true).val(0.00);
    $('#gtds_amount').prop('disabled', true).val(0.00);
    $('#it_ids_percentage').prop('disabled', true).val(''); 
    $('#gtds_percenatge').prop('disabled', true).val(''); 
    $('input[name="tax_deduction_description[]"]').prop('disabled', true).val(''); 
    $('input[name="tax_deduction_amount[]"]').prop('disabled', true).val(0.00); 
    $('.add-tax-deduction').prop('disabled', true); 
    $('#total_amount_with_deduction').val(total_amount)
  }
});


$(document).on('click', '.add-tax-deduction', function() {
  var newElement = `
  <div class="tax-deduction-row extra-row">
      <div class="col-md-6">
          <div class="form-group">
              <label class="">Tax Deduction Description <span class="require" aria-required="true" style="color:#a94442">*</span></label>
              <input type="text" class="form-control" name="tax_deduction_description[]"  value="" placeholder="Tax Deduction Description">
          </div>
      </div>

      <div class="col-md-5">
          <div class="form-group">
              <label class="">Tax Deduction Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>
              <input type="text" class="form-control onlyNumericInput tax_deduction_amount" name="tax_deduction_amount[]" value="" placeholder="Tax Deduction Amount">
          </div>
      </div>

      <div class="col-md-1">
          <div class="form-group">
              <br>
              <button type="button" class="remove-tax-deduction">Remove</button>
          </div>
      </div>
  </div>
  `;

  $('.tax-deduction-block').append(newElement);
  total_amount_with_deduction();
});

$(document).on('click', '.remove-tax-deduction', function() {
  $(this).parents(".tax-deduction-row").remove();
  total_amount_with_deduction();
});


  $("#payment_receipt_form").validate({
    rules: {
      payment_date: {
        required: true
      },
      payment_account: {
        required: true
      },
      payment_amount: {
        required: true
      },
      payment_mode: {
        required: true
      },
      it_ids_percentage: {
        required: true
      },
      gtds_percenatge: {
        required: true
      },
      "tax_deduction_description[]": {
        required: true
      },
      "tax_deduction_amount[]": {
        required: true
      },
      // security_deposit_amount: {
      //   required: true
      // },
      // retention_amount: {
      //   required: true
      // },
      // deposit_description: {
      //   required: true
      // },
      // deposit_amount: {
      //   required: true
      // },
      // withheld_description: {
      //   required: true
      // },
      // withheld_amount: {
      //   required: true
      // },
      // lebour_cess: {
      //   required: true
      // },
      // debit_credit_note: {
      //   required: true
      // },
      // cess_description: {
      //   required: true
      // },
      // cess_amount: {
      //   required: true
      // },
      // deduction_description: {
      //   required: true
      // },
      // deduction_amount: {
      //   required: true
      // },
      payment_with_gst: {
        required: true
      },
      payment_copy: {
        required: true
      },
      payment_copy_date: {
        required: true
      },
    },
    messages: {
      payment_date: {
        required: "Please select payment date."
      },
      payment_account: {
        required: "Please enter payment account."
      },
      payment_amount: {
        required: "Please enter payment amount."
      },
      payment_mode: {
        required: "Please select payment mode."
      },
      it_ids_percentage: {
        required: "Please enter the IT IDS amount."
      },
      gtds_percenatge: {
        required: "Please enter the GTDS amount."
      },
      "tax_deduction_description[]": {
        required: "Please provide a description for the tax deduction."
      },
      "tax_deduction_amount[]": {
        required: "Please enter the tax deduction amount."
      },
      // security_deposit_amount: {
      //   required: "Please enter the security deposit amount."
      // },
      // retention_amount: {
      //   required: "Please enter the retention amount."
      // },
      // deposit_description: {
      //   required: "Please provide a description for the deposit."
      // },
      // deposit_amount: {
      //   required: "Please enter the deposit amount."
      // },
      // withheld_description: {
      //   required: "Please provide a description for the withheld amount."
      // },
      // withheld_amount: {
      //   required: "Please enter the withheld amount."
      // },
      // lebour_cess: {
      //   required: "Please enter the labor cess amount."
      // },
      // debit_credit_note: {
      //   required: "Please provide a debit/credit note."
      // },
      // cess_description: {
      //   required: "Please provide a description for the cess."
      // },
      // cess_amount: {
      //   required: "Please enter the cess amount."
      // },
      // deduction_description: {
      //   required: "Please provide a description for the deduction."
      // },
      // deduction_amount: {
      //   required: "Please enter the deduction amount."
      // },
      payment_with_gst: {
        required: "Please select payment with gst."
      },
      payment_copy: {
        required: "Please upload the payment copy."
      },
      payment_copy_date: {
        required: "Please select the payment copy date."
      },
    },
    errorPlacement: function(error, element) {
      error.insertAfter(element);
      if (element.attr("name") === "payment_copy") {
        error.insertAfter(element.closest(".dflx"));
      }else if (element.attr("name") === "payment_with_gst") {
        error.insertAfter(element.closest(".dflx"));
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function(form) {
      var formData = new FormData(form);
      $.ajax({
        url: "save_ppi_payment_receipt_data",
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
              window.location.href = "ppi_payment_receipt";
            }, 3000);
          } else {
            $(".alert-container").html('<div class="alert modify alert-danger">' + res.messages + '</div>');
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error: ' + textStatus, errorThrown);
        }
      });

    }
  });

  $(document).on('keyup',".tax_deduction_amount", function() {
   
    var total_payable_amount_val = parseFloat($("#total_payable_amount_val").val()) || 0;
    var total_percentage = 0.05; // 5%
    var max_tax_deduction = total_payable_amount_val * total_percentage;
    var tax_deduction_amount = parseFloat($(this).val()) || 0;

    if (tax_deduction_amount > max_tax_deduction) {
        // alert("Tax deduction amount cannot exceed 5% of the total payable amount.");
        $(this).val(max_tax_deduction.toFixed(2)); // Reset to the maximum allowed amount
    }
    total_amount_with_deduction();
});

var pr_id_value = $("#pr_id_value").val();
if(pr_id_value > 0){
  total_amount_with_deduction();
}

});

function updatePaymentAmount() {
  var gstAmount = parseFloat($('#hidden_gst_amount').val()) || 0;
  var selectedOption = $('input[name="payment_with_gst"]:checked').val();
  
  var invoiceAmountWithGst = parseFloat($('#invoice_amount').val()) || 0;
  var invoiceAmountWithoutGst = parseFloat($('#invoice_amount_without_gst').val()) || 0;
   var paymentPercent = parseFloat($('#payment_percent').val()) || 0;
  var gstAmount = (gstAmount * paymentPercent) / (100);
    
  if (selectedOption === 'Yes') {
    $('#gst_amount').val(gstAmount.toFixed(2));
  } else if (selectedOption === 'No') {
    $('#gst_amount').val('0.00');
  }
  calculateTotalPayableAmount()
}

function updatePaymentAndGst() {

  var advancePaymentPercent = parseFloat($('#advance_payment_percent').val()) || 0;
  var paymentPercent = parseFloat($('#payment_percent').val()) || 0;
  var invoiceAmountWithGst = parseFloat($('#invoice_amount').val()) || 0;
  var invoiceAmountWithoutGst = parseFloat($('#invoice_amount_without_gst').val()) || 0;
   var paymentAmount = 0;
  var gstAmount = (invoiceAmountWithGst - invoiceAmountWithoutGst);
  var paymentWithGst = $('input[name="payment_with_gst"]:checked').val() === 'Yes';
  if (paymentPercent > advancePaymentPercent) {
    paymentPercent = advancePaymentPercent;
  }
  paymentAmount = (invoiceAmountWithoutGst * paymentPercent) / 100;
  if (paymentWithGst) {
    gstAmount = (gstAmount * paymentPercent) / (100);
  } else {
    gstAmount = 0;
  }
  $('#gst_amount').val(gstAmount.toFixed(2));
  $('#payment_amount').val(paymentAmount.toFixed(2));
  $('#hidden_payment_amount').val(paymentAmount.toFixed(2));
  $('#hidden_gst_amount').val(gstAmount.toFixed(2));
  
  calculateTotalPayableAmount()
  
}

function calculateTotalPayableAmount(){
    var paymentAmount = 0;
    var gstAmount = 0;
    var paymentPercent = parseFloat($('#payment_percent').val()) || 0;
    var invoiceAmountWithGst = parseFloat($('#invoice_amount').val()) || 0;
    var invoiceAmountWithoutGst = parseFloat($('#invoice_amount_without_gst').val()) || 0;
    paymentAmount = (invoiceAmountWithoutGst * paymentPercent) / 100;
    var gstAmount = (invoiceAmountWithGst - invoiceAmountWithoutGst);
    gstAmount = (gstAmount * paymentPercent) / (100);
    var paymentWithGst = $('input[name="payment_with_gst"]:checked').val() === 'Yes';
    var total_payable = 0;
    
    if (paymentWithGst) {
        total_payable = paymentAmount+gstAmount;
    } else {
        total_payable = paymentAmount;
    }
    $("#total_payable_amount_val").val(total_payable.toFixed(2))
    $("#total_amount_with_deduction").val(total_payable.toFixed(2))
    
}
function setTDSTCS(type = ''){
    
    var paymentWithGst = $('input[name="payment_with_gst"]:checked').val() === 'Yes';
    //  var invoiceAmountWithoutGst = parseFloat($('#invoice_amount_without_gst').val()) || 0;
    // var invoiceAmountWithGst = parseFloat($('#invoice_amount').val()) || 0;
    var gst_amount = parseFloat($('#gst_amount').val()) || 0;
    var invoiceAmountWithoutGst = parseFloat($('#payment_amount').val()) || 0;
    // var invoiceAmountWithGst = gst_amount +  invoiceAmountWithoutGst;
    if(type == "TDS"){
        var percentage = $("#it_ids_percentage").val();
        var total_amount = 0;
        var calculatedAmount = (invoiceAmountWithoutGst * percentage) / 100;
        // if(paymentWithGst){
        //     var calculatedAmount = (invoiceAmountWithGst * percentage) / 100;
        // }else{
        //     var calculatedAmount = (invoiceAmountWithoutGst * percentage) / 100;
        // }
        
        $('#it_ids_amount').val(calculatedAmount.toFixed(2));
    }
    if(type == "TCS"){
        var percentage = $("#gtds_percenatge").val();
        var total_amount = 0;
        var calculatedAmount = (invoiceAmountWithoutGst * percentage) / 100;
        // if(paymentWithGst){
        //     var calculatedAmount = (invoiceAmountWithGst * percentage) / 100;
        // }else{
        //     var calculatedAmount = (invoiceAmountWithoutGst * percentage) / 100;
        // }
        
        $('#gtds_amount').val(calculatedAmount.toFixed(2));
    }
    
    total_amount_with_deduction();
}
function total_amount_with_deduction(){
//   var it_ids_amount = parseFloat($("#it_ids_amount").val()) || 0;
// var gtds_amount = parseFloat($("#gtds_amount").val()) || 0;
var it_ids_amount =  0;
var gtds_amount =  0;
var statutory_deductions_radio = $('input[name="statutory_deductions_radio"]:checked').val();
// alert(statutory_deductions_radio);
if(statutory_deductions_radio == "Yes"){
   it_ids_amount = parseFloat($("#it_ids_amount").val()) ;
   gtds_amount = parseFloat($("#gtds_amount").val()) ;
}
var tax_deduction_amount = parseFloat($(".tax_deduction_amount").val()) || 0;
var total_payable_amount_val = parseFloat($("#total_payable_amount_val").val()) || 0;
tax_deduction_amount = 0;
$( ".tax-deduction-row .tax_deduction_amount " ).each(function( index ) {
  var value = $( this ).val();
  if(value > 0){
    tax_deduction_amount += parseFloat(value);
  }
});
var deduction_amount = it_ids_amount + gtds_amount + tax_deduction_amount;
var total_deduction_amount = total_payable_amount_val - deduction_amount;

total_deduction_amount = total_deduction_amount.toFixed(2);

$("#total_amount_with_deduction").val(total_deduction_amount);

// console.log(
//     it_ids_amount.toFixed(2),
//     gtds_amount.toFixed(2),
//     tax_deduction_amount.toFixed(2),
//     total_payable_amount_val.toFixed(2),
//     deduction_amount.toFixed(2),
//     total_deduction_amount
// );

}
