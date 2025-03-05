$(document).ready(function () {


    $("#save_head").validate({
        rules: {
            head_name: {
                required: true,
                minlength: 3 // Adjust the length according to your needs
            },
            // voucher_type: {
            //     required: true
            // },
            is_asset: {
                required: true
            },
        },
        messages: {
            head_name: {
                required: "Head Name is required",
                minlength: "Head Name must be at least 3 characters long"
            },
            // voucher_type: {
            //     required: "Please select a voucher type"
            // },
            is_asset: {
                required: "Please select whether this is an asset (Yes or No)."
            },

        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            // if (element.prop('type') === 'checkbox') {
            //     error.insertAfter(element.siblings('label'));
            // }
            if (element.attr("name") === "is_asset") {
            error.insertAfter(element.closest(".d-flex"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        },
        submitHandler: function (form) {
            var formData = new FormData(form);
          $.ajax({
            url: "save_head_data",
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

    $('.deleteRecord').on('click', function(e) {
        e.preventDefault();

        var head_id = $(this).attr('rel');
        var url = 'delete_head';

        bootbox.confirm("Are you sure you want to delete this head?", function(result) {
            if(result) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: { head_id: head_id },
                    success: function(response) {
                      var response =  JSON.parse(response);
                       console.log(response);
                       console.log(response.success);
                       console.log(response.messages);

                        if(response.success) {
                            bootbox.alert(response.messages);

                            setTimeout(function(){
                                location.reload();
                              },1500);

                        } else {
                            bootbox.alert(response.messages);

                        }
                    },
                    error: function(xhr, status, error) {

                        alert('An error occurred while deleting the head: ' + error);
                    }
                });
            }
        });
    });


    $('.editRecord').on('click', function(e) {
        e.preventDefault();
        var head_id = $(this).attr('rel');
        $.ajax({
            url: 'get_head_data_by_head_id',
            type: 'POST',
            data: { head_id: head_id },
            success: function(response) {
                var data = JSON.parse(response);
                $('#head_name').val(data.head);
                $('#voucher_type').val(data.voucher_type);
                $('#head_id').val(data.head_id);
                $('input[name="is_asset"][value="' + data.is_asset + '"]').prop("checked", true);
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    });


});
