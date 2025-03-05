var FormWizard = function () {


    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }

            var form = $('#submit_form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);

            form.validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                        institute_name:{required: true }
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
                    success.show();
                    error.hide();
                    //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
                }
            });

            /*var displayConfirm = function() {
                $('#tab4 .form-control-static', form).each(function(){
                    var input = $('[name="'+$(this).attr("data-display")+'"]', form);
                    if (input.is(":radio")) {
                        input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                    }
                    if (input.is(":text") || input.is("textarea")) {
                        $(this).html(input.val());
                    } else if (input.is("select")) {
                        $(this).html(input.find('option:selected').text());
                    } else if (input.is(":radio") && input.is(":checked")) {
                        $(this).html(input.attr("data-title"));
                    } else if ($(this).attr("data-display") == 'payment[]') {
                        var payment = [];
                        $('[name="payment[]"]:checked', form).each(function(){ 
                            payment.push($(this).attr('data-title'));
                        });
                        $(this).html(payment.join("<br>"));
                    }
                });
            }*/

            var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                    //displayConfirm();
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                }
                Metronic.scrollTo($('.page-title'));
            }

            // default form wizard
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    //return false;
                    
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    handleTitle(tab, navigation, clickedIndex);
                    
                },
                onNext: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    if (form.valid() == false) {
                        return false;
                    }

                    handleTitle(tab, navigation, index);
                },
                onPrevious: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#form_wizard_1').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });

            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1 .button-submit').click(function () {
                var id = $(this).attr('rel');
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
                        //divUnblockUi();
                        if(data.valid)
                        {
                           if(data.redirect)
                           {
                                bootbox.alert(data.msg, function() {
                                    setTimeout(function(){
                                        document.location.href=completeURL(data.redirect);                                
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
                        else
                        {
                            if(data.redirect)
                            {
                                bootbox.alert(data.msg, function() {
                                    setTimeout(function(){
                                        document.location.href=completeURL(data.redirect);                                
                                    },1500);
                                });
                            }
                           else
                           {
                                bootbox.alert(data.msg, function() {});
                           }  
                        }
                    }
                });
            }).hide();
        }

    };

}();


    function divImageBlockUi(msg)
    {
        $.blockUI({
            message: '<div class="loading-message loading-message-boxed"><img src="./assets/global/img/loading-spinner-grey.gif" align="">&nbsp; &nbsp;'+msg+'</div>',
            css: {
                border: '0',
                backgroundColor: 'none',                      
            }
        });
    }

    function divUnblockUi()
    {
        Metronic.unblockUI();
        /*window.setTimeout(function() {
            Metronic.unblockUI();
        }, 2000);*/
    }

    function completeURL(url)
    {
        try
        {
            var target= getCookie('website_builder')+url;
            target=replaceurl(target);
            return replaceurl(target);      
        }
        catch(e)
        {
            alert(e);
        }
    }