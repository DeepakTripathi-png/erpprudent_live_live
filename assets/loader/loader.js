$( document ).ready(function() {
    $(document).ajaxStart(function() {
    if($("body").hasClass("modal-open")){
        setTimeout(function(){
        $(".main-loader-box").show();
        $("body").addClass("loader-show");
        },100)
    }else{
        $(".main-loader-box").show();
        $("body").addClass("loader-show");
    }
    });
    $(document).ajaxStop(function() {
        if($("body").hasClass("modal-open")){
        setTimeout(function(){
            $(".main-loader-box").hide();
            $("body").removeClass("loader-show");
        },1500)
        }else{
        $(".main-loader-box").hide();
            $("body").removeClass("loader-show");
        }
        
    });
});