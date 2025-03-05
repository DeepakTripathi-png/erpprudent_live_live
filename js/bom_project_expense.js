$(document).ready(function () {
    $("#save_bom_project_expense").validate({
        rules: {
            bom_code: {
                required: true,
            },
            description: {
                required: true
            },
            qty: {
                required: true,
                number: true
            },
            unit: {
                required: true
            },
        },
        messages: {
            bom_code: {
                required: "Please enter the BOM code.",
            },
            description: {
                required: "Please enter a description.",
            },
            qty: {
                required: "Please enter qty.",
                 number: "Please enter a valid numeric value."
            },
            unit: {
                required: "Please enter the Unit.",
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            error.insertAfter(element);
        },

        submitHandler: function (form) {
            var formData = new FormData(form);
          $.ajax({
            url: "save_bom_project_expense",
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

    // Clear form functionality
    $(".clearData").click(function () {
        $("#save_head")[0].reset();
        $("input").removeClass('is-invalid is-valid');
        $("select").removeClass('is-invalid is-valid');
    });


      $('#qty').on('input', function() {
          var qty = parseFloat($(this).val()) || 0;
          var rate = parseFloat($('#rate').val()) || 0;
          var amount = rate * qty;
          $('#amount').val(amount.toFixed(2));
      });

    $('.editRecord').on('click', function(e) {
        e.preventDefault();
        var bpe_id = $(this).attr('rel');
        $.ajax({
            url: 'get_bom_project_expense_data_by_bpe_id',
            type: 'POST',
            data: { bpe_id: bpe_id },
            success: function(response) {
                var data = JSON.parse(response);
                $('#bpe_id').val(data.bpe_id);
                $('#bom_code').val(data.bom_code).prop("readonly", true);
                $('#description').val(data.description);
                $('#unit').val(data.unit).prop("readonly", true);
                $('#qty').val(data.qty);
                $('#rate').val(data.rate);
                $('#amount').val(data.amount);

            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    });

    $(document).on('change','.statusselectbom' , function(e){
        var this1 = $(this);
        bootbox.confirm("Are you sure?", function(result)
        {
            if(result)
            {
                var bpe_id = this1.attr('data-bpe-id');
                var url = this1.attr('rev');
                //  console.log(completeURL(url));


                var status = this1.val();

                $.ajax({
                    url : url,
                    type:'POST',
                    dataType:'json',
                    data:{bpe_id:bpe_id,status:status},
                    success:function(data)
                    {
                        bootbox.alert(data.msg);
                        setTimeout(function() {
                            location.reload();
                        }, 1500);


                    }
                });
            }
        });
    });

});
