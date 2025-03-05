var base_url = $('#base_url').val().trim();
var download_title = 'BOQ Variable Discount';
$(document).ready(function() {
    $('#projlaoding').html('Please wait project list loading...');
    $.ajax({
        url : base_url+'get_all_project_list',
        type:'GET',
        dataType:'json',
    }).done(function(data) {
        $('#projlaoding').html('');
        $('.allprojectsdiscount').select2({
            data: data.users,
            placeholder: 'search',
            multiple: false,
            // query with pagination
            query: function(q) {
              var pageSize,
                results,
                that = this;
              pageSize = 20; // or whatever pagesize
              results = [];
              if (q.term && q.term !== '') {
                // HEADS UP; for the _.filter function i use underscore (actually lo-dash) here
                results = _.filter(that.data, function(e) {
                  return e.text.toUpperCase().indexOf(q.term.toUpperCase()) >= 0;
                });
              } else if (q.term === '') {
                results = that.data;
              }
              q.callback({
                results: results.slice((q.page - 1) * pageSize, q.page * pageSize),
                more: results.length >= q.page * pageSize,
              });
            },
          });
    });

   
});

$(document).on("change", "#project_id", function () {
	var project_id = $(this).val();
	if (project_id) {
		// var url = base_url + "project_boq_item_list";
		// url += "?project_id=" + project_id;
        $.ajax({
            url: base_url + "get_boq_items_list?id="+project_id,
            type: "GET",
            dataType: "json",
        }).done(function (data) {
            $("#projlaoding").html("");
            $("#basic_rate").val(''); 
            $(".allitems").select2({
                data: data.users,
                placeholder: "search",
                multiple: false,
                // query with pagination
                query: function (q) {
                    var pageSize,
                        results,
                        that = this;
                    pageSize = 20; // or whatever pagesize
                    results = [];
                    if (q.term && q.term !== "") {
                        // HEADS UP; for the _.filter function i use underscore (actually lo-dash) here
                        results = _.filter(that.data, function (e) {
                            return e.text.toUpperCase().indexOf(q.term.toUpperCase()) >= 0;
                        });
                    } else if (q.term === "") {
                        results = that.data;
                    }
                    q.callback({
                        results: results.slice((q.page - 1) * pageSize, q.page * pageSize),
                        more: results.length >= q.page * pageSize,
                    });
                },
            });
        });
	}
});

$(document).on("change", "#boq_items", function () {
	var boq_code = $(this).val();
    const project_id = $("#project_id").val();
	if (project_id) {
        var url = 'get_boq_item_details_for_variable_discount';
        $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:{project_id:project_id,boq_code:boq_code},
            success:function(result){
                if(result.boq_code !== '' && typeof result.boq_code !== "undefined" && result.is_exist !== 'Y'){
                    $("#basic_rate").val(result.rate_basic); 
                    $("#boq_items_id").val(result.boq_items_id);
                    $(".boq-valid-item").hide();
                } else if(result.boq_code !== '' && typeof result.boq_code !== "undefined" && result.is_exist == 'Y') {
                    $("#basic_rate").val(''); 
                    $("#boq_items_id").val('');
                    $(".allitems").select2("val", "");
                    $(".boq-valid-item").show();
                } else {
                    $("#basic_rate").val(''); 
                }
            }
        });
	}
});

$(document).on('click','.deleteParticularRow', function(){ 
    $(this).closest('tr').remove();   
});



$(document).on('click','.addVariableDiscountData',function(e){  
      
    const isValid = $("#save_boq_variable_discount").valid();
    if(isValid == false) {
        return false;
    }
    var maintml = $(this);
    var variable_disc_from = document.getElementById("variable_disc_from").value;
    var variable_disc_to = document.getElementById("variable_disc_to").value;
    var variable_disc_base_rate = document.getElementById("variable_disc_base_rate").value;

    if(variable_disc_from =='') {
        $("#variable_disc_from").valid();
        return false;
    }
    if(variable_disc_to =='') {
        $("#variable_disc_to").valid();
        return false;
    }
    if(variable_disc_base_rate =='') {
        $("#variable_disc_base_rate").valid();
        return false;
    }
    var html='<tr><td>'
    +'<input type="number" class="form-control" name="variable_disc_from[]" value="'+variable_disc_from+'" readonly style="font-size: 12px;width:100%">'
    +'</td>'
    +'<td><input type="number" class="form-control" name="variable_disc_to[]" value="'+variable_disc_to+'" readonly style="font-size: 12px;width:100%"></td>'
    +'<td><input type="number" class="form-control" name="variable_disc_base_rate[]" value="'+variable_disc_base_rate+'" readonly></td>'
    +'<td style="text-align:center;">'
    +'<div class="addDeleteButton">'
    +'<span class="tooltips deleteBoqExceptnRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
    +'</div></td></tr>';
    $('.invaliderrorexcept').removeClass('has-error-d');
    $('#invaliderrorexceptdiv').html('');
    // console.log(html);
    $(maintml).parents('#displayBoqItems tbody').find("tr:last").before(html);
    $('#variable_disc_from').val('');
    $('#variable_disc_to').val('');
    $('#variable_disc_base_rate').val('');
});

$("#save_boq_variable_discount").validate({ 
    rules: {
        project_id: {
            required: true,
        },
        // boq_items: {
        //     required: true,
        // },
        "variable_disc_from[]":{
            required: true,
        },
        "variable_disc_to[]":{
            required: true,
        },
        "variable_disc_base_rate[]":{
            required: true,
        },
    },
    messages: {
        project_id: "Please Select Project",
       // boq_items: "Please Select BOQ Items",
        variable_disc_from: "From Quantity is required",
        variable_disc_to: "To Quantity is required",
        variable_disc_base_rate: "Base Rates is required",
    }
});


$(document).on('click','.variable_discount_save',function(e){

    const isValid = $("#save_boq_variable_discount").valid();
    if(isValid == false) {
        return false;
    }

    var form = '#'+$(this).parents('form').attr('id');
    var error = $('.alert-danger', form);
    var success = $('.alert-success', form);
    var id = $(this).attr('rel');
    var serialize_data = $(form).serialize();
    var url = $(form).attr('action');

    $.ajax({
        type:'POST',
        url:completeURL(url), 
        dataType:'json',
        data:serialize_data,
        success:function(data)
        {  
            Metronic.stopPageLoading(); 
            $('.variable_discount_save').prop('disabled',false);
            if(data.valid){  
                if(data.redirect){
                    bootbox.alert(data.msg, function() {
                        setTimeout(function(){
                            document.location.href=data.redirect;                                
                        },1500);
                    });
                }else{
                    bootbox.alert(data.msg);
                }
            }else{
                if(data.no_popup){
                       bootbox.alert(data.msg);
                }else{
                    bootbox.alert(data.msg);
                }
            }
        },error: function (error) {
        }
    });
    //e.preventDefault();
    // var form = '#'+$(this).parents('form').attr('id');
    // var error = $('.alert-danger', form);
    // var success = $('.alert-success', form);
    // var id = $(this).attr('rel');
    
    // jQuery.validator.addMethod("onlyletters", function(value, element) {
    //     return this.optional(element) || /^[a-z\s]+$/i.test(value);
    // }, "Only Alphabetical Characters");

    // jQuery.validator.addMethod("percentage", function(value, element) {
    //     return this.optional(element) || /^\d+\.?\d?\d?%?$/i.test(value);
    // }, "Only Number Are Allowed");

    // jQuery.validator.addMethod("onlyNumber", function(value, element) {
    //     return this.optional(element) || /^[0-9]*$/i.test(value);
    // }, "Only Number Are Allowed");
    // $(form).validate({ 
    //     rules: {
    //         project_id: {
    //             required: true,
    //         },
    //         boq_items: {
    //             required: true,
    //         },
    //         "variable_disc_from[]":{
    //             required: true,
    //         },
    //         "variable_disc_to[]":{
    //             required: true,
    //         },
    //         "variable_disc_base_rate[]":{
    //             required: true,
    //         },
    //     },
    //     messages: {
    //         project_id: "Please Select Project",
    //         boq_items: "Please Select BOQ Items",
    //         variable_disc_from: "From Quantity is required",
    //         variable_disc_to: "To Quantity is required",
    //         variable_disc_base_rate: "Base Rates is required",
    //       },
    //     // invalidHandler: function (event, validator) { //display error alert on form submit              
    //     //     success.hide();
    //     //     error.show();
    //     //     $('html,body').animate({scrollTop:0});
    //     //     $('#error_alert').show();
    //     // },
    //     // errorPlacement: function (error, element) { // render error placement for each input type
    //     //     var icon = $(element).parent('.input-icon').children('i');
    //     //     icon.removeClass('fa-check').addClass("fa-warning");  
    //     //     icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
    //     // },
    //     // highlight: function (element) { // hightlight error inputs
    //     //     $(element).closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
    //     // },
    //     // unhighlight: function (element) { // revert the change done by hightlight
    //     // },
    //     // success: function (label, element) {
    //     //     var icon = $(element).parent('.input-icon').children('i');
    //     //     $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
    //     //     icon.removeClass("fa-warning").addClass("fa-check");
    //     // },

    //     submitHandler: function (form) {
    //         $('.variable_discount_save').prop('disabled',true);
    //         var url = $(form).attr('action');
    //         var serialize_data = $(form).serialize();
    //         serialize_data = {id:id};
    //         Metronic.startPageLoading({animate: true});
    //         //alert(completeURL(url));
    //         $(form).ajaxSubmit({
    //             type:'POST',
    //             url:completeURL(url), 
    //             dataType:'json',
    //             data:serialize_data,
    //             success:function(data)
    //             {  
    //                 Metronic.stopPageLoading(); 
    //                 $('.variable_discount_save').prop('disabled',false);
    //                 if(data.valid){  
    //                     if(data.redirect){
    //                         bootbox.alert(data.msg, function() {
    //                             setTimeout(function(){
    //                                 document.location.href=data.redirect;                                
    //                             },1500);
    //                         });
    //                     }else{
    //                         bootbox.alert(data.msg);
    //                     }
    //                 }else{
    //                     if(data.no_popup){
    //                            bootbox.alert(data.msg);
    //                     }else{
    //                         bootbox.alert(data.msg);
    //                     }
    //                 }
    //             },error: function (error) {
    //             }
    //         });
    //     }
    // });
});


var BoqItemdataTable = $("#boqvariabledisclist").DataTable({
    dom: "Bfrtip",
    scrollY: 400,
    scrollX: true,
    scroller: true,
    fixedHeader: {
      header: true,
      footer: true,
    },
    lengthMenu: [
      [25, 50, 75, 100, 125, 150, -1],
      [
        "25 rows",
        "50 rows",
        "75 rows",
        "100 rows",
        "125 rows",
        "150 rows",
        "Show all",
      ],
    ],
    bAutoWidth: false,
    oLanguage: {
      sEmptyTable: "No BOQ Items Available!",
    },
    paging: true,
    iDisplayLength: 25,
    deferRender: true,
    responsive: true,
    processing: true,
    serverSide: false,
    order: [[0, "asc"]],
    ajax: {
      url: base_url + "project_boq_discount_item_list",
      type: "POST",
      data: {
        project_id: $("#project_id").val(),
      },
    },
    columnDefs: [
      {
        targets: [1],
        className: "w500",
      },
      {
        targets: [3],
        className: "w400",
      },
    ],
    });


    $(document).on('click','.popup_var_discount',function(){
        var id = $(this).attr('rel');
        var url = $(this).attr('rev');
        var title= $(this).data('title');
        var project_id= $(this).attr('project_id');
        var data={id:id,project_id:project_id};
        $.ajax({
            url:completeURL(url), 
            data:data,          
            type:'POST',  
            dataType:'json', 
            success: function(data)
            {   
                if(data.redirect) 
                {
                    bootbox.alert(data.msg, function() {
                        setTimeout(function(){
                            document.location.href=data.redirect;                                
                        },1500);
                     });
                }
                else
                {

                    var dialog = bootbox.dialog({
                        message: data.view,
                        title: title, 
                        buttons: { 
                            success: {
                                label: "Submit",
                                className: "btn-success",
                                callback: function() {
                                    var form= '#popup_save';
                                    var url = $(form).attr('action');
                                    // alert(url);
                                    var serialize_data = $(form).serialize();
                                    serialize_data = {serialize_data:serialize_data,id:id,project_id:project_id};
                                    //alert(serialize_data);                                    

                                    var form2 = $(form);
                                    var error2 = $('.alert-danger', form2);
                                    var success2 = $('.alert-success', form2);

                                    var validate = $(form).validate({
                                        errorElement: 'span', //default input error message container
                                        errorClass: 'help-block', // default input error message class
                                        focusInvalid: false, // do not focus the last invalid input
                                        ignore: "hidden",  // validate all fields including form hidden input,
                                        debug: true,
                                        rules: {
                                            tax_invc_no:{ required: true },
                                            tax_invc_date:{ required: true },
                                        },

                                        invalidHandler: function (event, validator) { //display error alert on form submit              
                                            success2.hide();
                                            error2.show();
                                           /* Metronic.scrollTo(error2, -200);*/
                                        },

                                        errorPlacement: function (error, element) { // render error placement for each input type
                                            var icon = $(element).parent('.input-icon').children('i');
                                            icon.removeClass('fa-check').addClass("fa-warning");  
                                            icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                                        }, 

                                        highlight: function (element) { // hightlight error inputs
                                            $(element)
                                                .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                                        },

                                        unhighlight: function (element) { // revert the change done by hightlight
                                            $(element)
                                                .closest('.form-group').removeClass('has-error'); // set error class to the control group
                                        },

                                        success: function (label, element) {
                                            var icon = $(element).parent('.input-icon').children('i');
                                            $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                                            icon.removeClass("fa-warning").addClass("fa-check");
                                        },

                                        submitHandler: function (form) {
                                            
                                        }
                                    }).form();
                                    var $valid = $(form).valid();
                                    if(!$valid) 
                                    {                                                               
                                        return false;
                                    }
                                    else
                                    { 
                                        Metronic.startPageLoading({animate: true});
                                        $(form).ajaxSubmit({
                                            type:'POST',
                                            url:completeURL(url), 
                                            dataType:'json',
                                            data: serialize_data,
                                            success:function(data)
                                            {   
                                               Metronic.stopPageLoading();
                                                if(data.valid)
                                                {  
                                                    if(data.redirect)
                                                    {
                                                        bootbox.alert(data.msg, function() {
                                                            window.location.href = data.redirect;
                                                        }); 
                                                    }
                                                    else
                                                    {
                                                        bootbox.alert(data.msg, function() {
                                                            window.location.href = window.location.href;
                                                        }); 
                                                    }
                                                }   
                                                else
                                                {
                                                    bootbox.alert(data.msg, function() {
                                                        window.location.href = window.location.href;
                                                    }); 
                                                }                                        
                                            }
                                        });
                                    }                                         
                                }
                            },
                            danger: {
                                label: "Cancel",
                                className: "btn-danger",
                                callback: function() { }
                            } 
                        }
                    });

                    dialog.on("shown.bs.modal", function() {
                        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                    });
                    
                }
            },
            complete:function()
            {   
                if (jQuery().select2)
                {
                    //$('select').select2();   
                }    
            }
        }); 
});

$(document).on('click','.active_link_cmn' , function(){
    var this1 = $(this);
    $('.bootbox.modal').modal('hide');
    bootbox.confirm("Are you sure?", function(result) 
    {
        if(result)
        {
            var id = this1.attr('rel');
            var url = this1.attr('rev');             
            var status = this1.data('status');                
            $.ajax({
                url : completeURL(url),
                type:'POST',
                dataType:'json',
                data:{id:id,status:status},
                success:function(data)
                {
                    bootbox.alert(data.msg, function() {
                        setTimeout(function(){
                            document.location.href=document.location.href;                                
                        },1500);
                    });                       
                }
            });
        }
    }); 
});


  