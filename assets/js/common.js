$(document).ready(function(){

    $(document).on('change','.role_configuration',function(){    
        var id = $(this).val();
        Metronic.startPageLoading({animate: true});
        $.ajax({
            type:'POST',
            url:completeURL('fetch_role_config'),
            data:{id:id},
            dataType:'json', 
            success:function(data) 
            {             
                $('.prevelege_data').html(data.view);
            },
            complete:function()
            {
                Metronic.stopPageLoading();
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
            }
        }); 
    });

    $(document).on('change','.category_select_all',function(){
       if($(this).is(":checked"))
       {
            $(this).parents('.panel-collapse').find('.portlet-body input[type=checkbox]').each(function( index ) {
                $(this).prop('checked', true); 
            });
       }else
       {
            $(this).parents('.panel-collapse').find('.portlet-body').find('input[type=checkbox]').prop('checked', false);
       }
       $.uniform.update();
    });

    $(document).on('click','.common_save',function(e){
        var form = '#'+$(this).parents('form').attr('id');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        var id = $(this).attr('rel');

        $(form).validate({ 
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: ":hidden",  // validate all fields including form hidden input
            rules: {
                    contact_name:{required: true },
                    mail: {required: true, email:true },
                    number: {number:true, minlength:10, maxlength:12, required:true},
                    contact_type:{required:true},
                    msg: {required: true },
                    city_name:{required:true},
                    confirm_password:   
                    {                                            
                        required: true,
                        equalTo: "#user_pass"                                                               
                    }
                    
            }, 

            invalidHandler: function (event, validator) { //display error alert on form submit              
                success.hide();
                error.show();
                $('html,body').animate({scrollTop:0});
            },

            errorPlacement: function (error, element) { // render error placement for each input type
                var icon = $(element).parent('.input-icon').children('i');
                icon.removeClass('fa-check').addClass("fa-warning");  
                icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
            },

            highlight: function (element) { // hightlight error inputs
                //alert($(element).attr('name'));
                $(element).closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
            },

            unhighlight: function (element) { // revert the change done by hightlight
                
            },

            success: function (label, element) {
                var icon = $(element).parent('.input-icon').children('i');
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                icon.removeClass("fa-warning").addClass("fa-check");
            },

            submitHandler: function (form) {
                $('.common_save').prop('disabled',true);
                var url = $(form).attr('action');
                var serialize_data = $(form).serialize();
                serialize_data = {id:id};
                $(form).ajaxSubmit({
                    type:'POST',
                    url:completeURL(url), 
                    dataType:'json',
                    data:serialize_data,
                    success:function(data)
                    {   
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
        });
    });

    $(document).on('click','.chk_login',function(e){
        //alert('hello');
        e.preventDefault();
        var this1 = $(this);
        $('.alert-success').show(); 
        var form = '#'+$(this).closest('form').attr('id');
        $('.chk_login').prop('disabled',true);
        var url = $(form).attr('action');
        var serialize_data = $(form).serialize();
        $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:serialize_data,
            success:function(data)
            {   
                if (data.valid)
                {
                    if(data.redirect)
                    {
                        document.location.href = data.redirect;
                    }
                    else
                    {
                        document.location.href = document.location.href;
                    }
                }
                else
                {
                    this1.closest('form').find('.alert-success').hide();
                    this1.closest('form').find('.alert-danger').html(data.msg).show();  
                    this1.closest('form').find('.alert-danger').fadeOut(3500);   
                    this1.closest('form').find('.password').val('');              
                }                                      
                $('.chk_login').prop('disabled',false);
            }
        });
    });

    $(document).on('click','.popup_save',function()
    {
        alert('hi');
        var id = $(this).attr('rel');
        var url = $(this).attr('rev');
        var title= $(this).data('title');
        title='<span class="caption-subject font-red-haze bold uppercase">'+title+'</span>';
        var data={id:id};

        $.ajax({
            url:completeURL(url), 
            data:data,          
            type:'POST',  
            dataType:'json',
            success: function(data)
            {   
                var dialog = bootbox.dialog({
                    message: data.view,
                    title: title, 
                    buttons: { 
                        danger: {
                            label: "Cancel",
                            className: "btn-danger",
                            callback: function() { }
                        }, 
                        success: {
                            label: "Submit",
                            className: "btn-success",
                            callback: function() {
                                var form= '#popup_save';
                                var url = $(form).attr('action');
                                var serialize_data = $(form).serialize();
                                serialize_data = {serialize_data:serialize_data,id:id};
                                var form2 = $(form);
                                var error2 = $('.alert-danger', form2);
                                var success2 = $('.alert-success', form2);
                                var validate = $(form).validate({
                                    errorElement: 'span', 
                                    errorClass: 'help-block', 
                                    focusInvalid: false, 
                                    ignore: ":hidden",  
                                    debug: true,
                                    rules: {
                                        category_name: {required: true },
                                        category_desc: {required: true },
                                        category_about: {required: true },
                                        reply: {required: true },
                                        price:{required:true},
                                        category_id: {required: true },
                                        sc_name: {required: true },
                                        sc_desc: {required: true },
                                        city_name: {required: true },
                                        city_desc: {required: true },
                                        testimonial_name: {required: true },
                                        testimonial_desc: {required: true },
                                        sup_cat_name: {required: true },
                                        sup_cat_desc: {required: true },
                                        category_id:{required: true},
                                        question:{required: true},
                                        client_name:{required:true},
                                        answer:{required:true},
                                        email:{required:true},
                                        greet_file:{required:true},
                                        subject:{required:true},
                                        name:{required:true},
                                        mobile:{required: true,number: true},
                                        address:{required:true},
                                        city:{required:true},
                                        pincode:{required:true},
                                        home:{required:true}
                                    },

                                    invalidHandler: function (event, validator) { 
                                        success2.hide();
                                        error2.show();
                                       $('html, body').animate({scrollTop:0});
                                    },

                                    errorPlacement: function (error, element) { 
                                        var icon = $(element).parent('.input-icon').children('i');
                                        icon.removeClass('fa-check').addClass("fa-warning");  
                                        icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                                    }, 

                                    highlight: function (element) { 
                                        $(element).closest('.form-group').removeClass("has-success").addClass('has-error'); 
                                    },

                                    unhighlight: function (element) {
                                        $(element).closest('.form-group').removeClass('has-error'); 
                                    },

                                    success: function (label, element) {
                                        var icon = $(element).parent('.input-icon').children('i');
                                        $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); 
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
                                    $(form).ajaxSubmit({
                                        type:'POST',
                                        url:completeURL(url), 
                                        dataType:'json',
                                        data: serialize_data,
                                        success:function(data)
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
                                                bootbox.alert(data.msg, function() {
                                                    setTimeout(function(){
                                                        document.location.href=document.location.href;                                
                                                    },1500);
                                                });  
                                            }                                      
                                        }
                                    });
                                }                                         
                            }
                        }
                    }
                });
            },
            complete:function()
            {   
                Metronic.init();
                ComponentsPickers.init();
                if (jQuery().datepicker) {
                    $(".date-picker").datepicker( {
                        format: "d-m-yyyy",
                        viewMode: "months", 
                        minViewMode: "months",
                        autoclose: true
                    });
                    $(".date-picker1").datepicker( {
                        format: "yyyy",
                        viewMode: "years", 
                        minViewMode: "years",
                        autoclose: true
                    });
                }
            }
        }); 
    });

    $(document).on('click','.editRecord', function(){
        var id = $(this).attr('rel');
        var url = $(this).attr('rev');

        $.ajax({
            url : completeURL(url),
            type : 'POST',
            dataType : 'html',
            data:{id:id},
            success:function(data)
            {          
                $('html, body').animate({scrollTop:0});
                $('.form').html($(data).find('.form').html());
            }
        }); 
    });

    $(document).on('click','.deleteRecord' , function(){
        var deleteDiv = $(this);
        bootbox.confirm("Are you sure?", function(result) {
            if(result)
            {
                var id = deleteDiv.attr('rel');
                var url = deleteDiv.attr('rev');
                
                $.ajax({
                    url : completeURL(url),
                    type:'POST',
                    dataType:'json',
                    data:{id:id},
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

});  

function completeURL(url)
{
    return $('base').attr('href')+url;
}