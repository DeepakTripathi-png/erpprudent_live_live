    var isChecked = $('#bill_same_as_reg_addr').is(':checked');
    $('#bill_same_as_reg_addr').change(function() {
      if ($(this).is(':checked')) {
        $('#bill_same_as_reg_addr').val('checked')
      } else {
            $('#bill_same_as_reg_addr').val('unchecked')
      }
    });
     $(document).on("change","#per_payment_mode", function(){
        var value = $(this).val();
        if(value == 'bank_guarantee'){
            var html = '<div class="form-group">'
                +'<label class="">Form Of PG <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                +'<div class="input-icon right">'
                +'<i class="fa"></i>'
                +'<input type="text" class="form-control " name="sd_pbg_fd" id="sd_pbg_fd" placeholder="PBG/FD/DD/ONLINE">'
                +'</div>';
                $('#sd_pbg_fd').html(html);    
        }else{
            $('#sd_pbg_fd').html('');    
        }
    });
    $(document).on("click",".emd_paid_status_div", function(){
        var value = $(this).val();
        if(value == 'Yes'){
            var html = '<button type="button" id="emd_paid_status_id" class="btn btn-primary" title="click To Convert to Contract Deposit" rel="">Convert to Contract Deposit</button>';
                $('#ccd_div').html(html);    
        }else{
            $('#ccd_div').html(''); 
            $('#emd_paid_status_id_value').val("N");

        }
    });

    $(document).on("click","#emd_paid_status_id", function(){

        $('#emd_paid_status_id_value').val("Y");
        $(this).removeClass('btn btn-primary').addClass('btn btn-success').text('Converted Deposit');

    });

    $(document).on("click","#asd_paid_status_id", function(){

        $('#asd_paid_status_id_value').val("Y");
        $(this).removeClass('btn btn-primary').addClass('btn btn-success').text('Converted Deposit');

    });





    $(document).on("click",".asd_paid_status_div", function(){
        var value = $(this).val();
        if(value == 'Yes'){
            var html = '<button type="button" id="asd_paid_status_id" class="btn btn-primary" title="click To Convert to Contract Deposit" rel="">Convert to Contract Deposit</button>';
                $('#asdccd_div').html(html);    
        }else{
            $('#asdccd_div').html(''); 
            $('#asd_paid_status_id_value').val("N");   
        }
    });

    //keyup gst

    $(document).on('keyup','#taxable_amount',function()
    {        
        var taxable_amount = document.getElementById("taxable_amount").value;
        var rate = document.getElementById("gst_rate").value;
        if(taxable_amount > 0 && rate > 0){
              var gst_amount =  ((rate/100)*taxable_amount).toFixed(2);
              var total_amount =  (parseFloat(taxable_amount) +  parseFloat(gst_amount)).toFixed(2);
              console.log(taxable_amount)
              console.log(total_amount)
              $('#gst_amount').val(gst_amount);
              $('#total_amount').val(total_amount);
        }else{
            $('#gst_amount').val('');
            $('#total_amount').val('');

        }
       
    });
    $(document).on('change','#gst_rate',function()
    {        
        var taxable_amount = document.getElementById("taxable_amount").value;
        var rate = document.getElementById("gst_rate").value;
        if(taxable_amount > 0 && rate > 0){
              var gst_amount =  ((rate/100)*taxable_amount).toFixed(2);
              var total_amount =  (parseFloat(taxable_amount) +  parseFloat(gst_amount)).toFixed(2);
              $('#gst_amount').val(gst_amount);
              $('#total_amount').val(total_amount);
        }else{
            $('#gst_amount').val('');
            $('#total_amount').val('');

        }
       
    });





    
    $(document).ready(function(){
            $("#inspection").click(function () {
                if ($(this).is(":checked")) {
                    var html = '<hr style="margin: 15px 0;"><div class="row dvinspectiontype">'
                    +'<div class="col-md-4">'
                    +'<label class="">Inspection <span class="require" aria-required="true" style="color:#a94442">*</span></label> <span id="adinspecerror" style="font-size:12px;color:#a94442;"></span>'
                    +'</div>'
                    +'<div class="col-md-8">'
                    +'<div style="display:flex;">'
                    +'<div class="form-group" style="width: 90%;">'
                    +'<div class="input-icon right"><i class="fa"></i>'
                    +'<input type="hidden" id="smcnt" value="1">'
                    +'<input type="text" class="form-control" name="inspection_text[]" id="inspection_text1" placeholder="Inspection" required>'
                    +'</div>'
                    +'</div><div class="" style="width: 10%;">'
                    +'<div class="adinspectionbtn"><i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i></div>'
                    +'</div></div>'
                    +'</div>'
                    +'</div><div class="adinspectiond" id="adinspectiond"></div>';
                    $('#didetlsa').append(html);
                } else {
                    $(".dvinspectiontype").remove();
                }
            });
            var inspection = 2;
            $(document).on('click','.adinspectionbtn',function(){
                var inspection_text = $("#inspection_text1").val();
                if(inspection_text !=='' && typeof inspection_text !== 'undefined'){
                var html = '<div class="row" id="ins'+inspection+'">'
                +'<div class="col-md-4">'
                +'<label class=""></label>'
                +'</div>'
                +'<div class="col-md-8">'
                +'<div style="display:flex;">'
                +'<div class="form-group" style="width: 90%;">'
                +'<div class="input-icon right"><i class="fa"></i>'
                +'<input type="hidden" id="smcnt" value="1">'
                +'<input type="text" class="form-control" name="inspection_text[]" value="" placeholder="Inspection" required="">'
        	    +'</div>'
                +'</div><div class="" style="width: 10%;">'
                +'<div class="rminspectionbtn" data-id="'+inspection+'"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>'
        	    +'</div></div>'
                +'</div>'
                +'</div>';
                $("#adinspectiond").append(html);
        		$("#adinspecerror").html('');
        		inspection++;
                }else{
                $("#adinspecerror").html('Please enter Inspection value!');
        		}
        	});
            $(document).on('click','.rminspectionbtn',function(){
                var id = $(this).attr('data-id');
                $('#ins'+id).remove();
            });
            $("#prototype").click(function () {
                if ($(this).is(":checked")) {
                    var html = '<hr style="margin: 15px 0;"><div class="row dvprototype">'
                    +'<div class="col-md-4">'
                    +'<label class="">Prototype <span class="require" aria-required="true" style="color:#a94442">*</span></label> <span id="adprotoderror" style="font-size:12px;color:#a94442;"></span>'
                    +'</div>'
                    +'<div class="col-md-8">'
                    +'<div style="display:flex;">'
                    +'<div class="form-group" style="width: 90%;">'
                    +'<div class="input-icon right"><i class="fa"></i>'
                    +'<input type="hidden" id="prcnt" value="1">'
                    +'<input type="text" class="form-control" name="prototype_text[]" id="prototype_text1" placeholder="Prototype" required>'
                    +'</div>'
                    +'</div><div class="" style="width: 10%;">'
                    +'<div class="adsprotobtn"><i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i></div>'
                    +'</div></div>'
                    +'</div>'
                    +'</div><div class="adprotod" id="adprotod"></div>';
                    $('#didetlsa').append(html);
                } else {
                    $(".dvprototype").remove();
                }
            });
            var prototypet = 2;
            $(document).on('click','.adsprotobtn',function(){
                var prototype_text = $("#prototype_text1").val();
                if(prototype_text !='' && typeof prototype_text != 'undefined'){
                var html = '<div class="row" id="pro'+prototypet+'">'
                +'<div class="col-md-4">'
                +'<label class=""></label>'
                +'</div>'
                +'<div class="col-md-8">'
                +'<div style="display:flex;">'
                +'<div class="form-group" style="width: 90%;">'
                +'<div class="input-icon right"><i class="fa"></i>'
                +'<input type="hidden" id="prcnt" value="1">'
                +'<input type="text" class="form-control" name="prototype_text[]" value="" placeholder="Prototype" required="">'
        	    +'</div>'
                +'</div><div class="" style="width: 10%;">'
                +'<div class="rmprotobtn" data-id="'+prototypet+'"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>'
        	    +'</div></div>'
                +'</div>'
                +'</div>';
                $("#adprotod").append(html);
        		$("#adprotoderror").html('');
        		prototypet++;
                }else{
                $("#adprotoderror").html('Please enter Prototype value!');
        		}
        	});
            $(document).on('click','.rmprotobtn',function(){
                var id = $(this).attr('data-id');
                $('#pro'+id).remove();
            });
            //var sample = 2;
            $(document).on('click','.adsamplebtn',function(){
                var sample = $('#smcnt').val();
                var sample_text = $("#sample_text1").val();
                if(sample_text !=='' && typeof sample_text !== 'undefined'){
                var html = '<div class="row" id="sm'+sample+'">'
                +'<div class="col-md-4">'
                +'<label class=""></label>'
                +'</div>'
                +'<div class="col-md-8">'
                +'<div style="display:flex;">'
                +'<div class="form-group" style="width: 90%;">'
                +'<div class="input-icon right"><i class="fa"></i>'
                +'<input type="text" class="form-control" name="sample_text[]"  value="" placeholder="Sample" required="">'
                +'</div>'
                +'</div><div class="" style="width: 10%;">'
                +'<div class="rmsamplebtn" data-id="'+sample+'"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>'
                +'</div></div>'
                +'</div>'
                +'</div>';
                $("#adsampled").append(html);
        		$("#appsamplederror").html('');
        		var adcnt = parseInt(sample) + 1;
                $("#smcnt").val(adcnt);
        		}else{
                $("#appsamplederror").html('Please enter Sample value!');
        		}
        	});
            $(document).on('click','.rmsamplebtn',function(){
                var smcnt = $('#smcnt').val();
                var id = $(this).attr('data-id');
                $('#sm'+id).remove();
                var rm = smcnt - 1;
                $('#smcnt').val(rm);
            });
            var fat = 2;
            $(document).on('click','.adfatbtn',function(){
                var fat_text = $("#fat_text1").val();
                if(fat_text !='' && typeof fat_text != 'undefined'){
                var html = '<div class="row" id="fat'+fat+'">'
                +'<div class="col-md-4">'
                +'<label class=""></label>'
                +'</div>'
                +'<div class="col-md-8">'
                +'<div style="display:flex;">'
                +'<div class="form-group" style="width: 90%;">'
                +'<div class="input-icon right"><i class="fa"></i>'
                +'<input type="hidden" id="prcnt" value="1">'
                +'<input type="text" class="form-control" name="fat_text[]" data-id="fat_id" value="" placeholder="FAT" required="">'
        	    +'</div>'
                +'</div><div class="" style="width: 10%;">'
                +'<div class="rmfatbtn" data-id="'+fat+'"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>'
        	    +'</div></div>'
                +'</div>'
                +'</div>';
                $("#appfatd").append(html);
        		$("#appfatderror").html('');
        		fat++;
                }else{
                $("#appfatderror").html('Please enter FAT value!');
        		}
        	});
            $(document).on('click','.rmfatbtn',function(){
                var id  = $(this).attr("data-id");
                $('#fat'+id).remove();
            });
        	var sat = 2;
        	$(document).on('click','.adsatbtn',function(){
                var sat_text = $("#sat_text1").val();
                if(sat_text !='' && typeof sat_text != 'undefined'){
                var html = '<div class="row" id="sat'+sat+'">'
                +'<div class="col-md-4">'
                +'<label class=""></label>'
                +'</div>'
                +'<div class="col-md-8">'
                +'<div style="display:flex;">'
                +'<div class="form-group" style="width: 90%;">'
                +'<div class="input-icon right"><i class="fa"></i>'
                +'<input type="text" class="form-control" name="sat_text[]" value="" placeholder="SAT" required="">'
        	    +'</div>'
                +'</div><div class="" style="width: 10%;">'
                +'<div class="rmsatbtn" data-id="'+sat+'"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>'
        	    +'</div></div>'
                +'</div>'
                +'</div>';
                $("#appsatd").append(html);
        		$("#appsatderror").html('');
        		sat++;
                }else{
                $("#appsatderror").html('Please enter SAT value!');
        		}
        	});
            $(document).on('click','.rmsatbtn',function(){
                var id = $(this).attr('data-id');
                $('#sat'+id).remove();
            });
            var cnt = 2;
        	$(document).on('click', '.adbtn', function() {
        	    var insurance_remark = $("#insurance_remark1").val();
                var insurance_up_to_date = $("#insurance_up_to_date1").val();
                var amount_of_risk_cov = $("#amount_of_risk_cov1").val();
                var insurance_required_doc = $("#insurance_required_doc1").val();
                if(insurance_remark !=='' && typeof insurance_remark != 'undefined' && 
                insurance_up_to_date !=='' && typeof insurance_up_to_date != 'undefined' && 
                amount_of_risk_cov !=='' && typeof amount_of_risk_cov != 'undefined'){
                var html = '<div class="row dflxd">'
        	    +'<div class="col-md-6"><div class="form-group">'
        	    +'<div class="input-icon right">'
        	    +'<i class="fa"></i><textarea type="text" class="form-control " name="insurance_remark[]" id="insurance_remark'+cnt+'" required="" readonly="">'+insurance_remark+'</textarea>'
                +'</div></div></div>'
                +'<div class="col-md-3">'
                +'<div class="form-group">'
                +'<input type="text" class="form-control " name="insurance_up_to_date[]" id="insurance_up_to_date'+cnt+'"value="'+insurance_up_to_date+'" required="" readonly="">'
                +'</div></div>'
                +'<div class="col-md-3">'
                +'<div class="form-group">'
                +'<div class="input-icon right">'
                +'<i class="fa"></i>'
                +'<input type="text" class="form-control " name="amount_of_risk_cov[]" id="amount_of_risk_cov'+cnt+'" placeholder="Amount Of Risk Coverage" value="'+amount_of_risk_cov+'" required="" readonly="">'
                +'</div></div></div>'
                +'<div class="col-md-3">'
                +'<div class="form-group">'
                +'<input type="file" name="insurance_required_doc[]" id="insurance_required_doc'+cnt+'" class="insurance_required_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" required="" value="'+insurance_required_doc+'">'
                +'</div></div>'
                +'<div class="col-md-1">'
                +'<div class="rmbtn"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>'
                +'</div></div>';
        		$("#nsuranceRequiredApp").prepend(html);
        		$("#amount_of_risk_cov1").val('');
                $("#insurance_required_doc1").val('');
                $("#insurance_up_to_date1").val('');
        		$("#insurance_remark1").val('');
        		$("#insurance_req_err").html('');
        		cnt++;
                }else{
                $("#insurance_req_err").html('Please enter insurance required details!');
        		}
        	});

            
            $("#nsuranceRequiredApp").on('click','.rmbtn',function(){
                $(this).parent().parent().remove();
            });






        });
        if (jQuery().datepicker) {
            $('.date1').datepicker({
                orientation: "right",
                autoclose: true,
            });
        }
        $(function () {
            var ifpros = 0;
            $("input[name='price_inslusive_of_amc']").click(function () {
                if ($("#price_inslusive_of_amc_yes").is(":checked")) {
                    var html = '<div class="col-md-6 ifpriceAMCYes">'
                    +'<div class="form-group">'
                    +'<label class="">AMC Applicable After (Months) <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="input-icon right">'
                    +'<i class="fa"></i>'
                    +'<input type="number" class="form-control" name="amc_applicable_after" id="amc_applicable_after" placeholder="AMC applicable after ">'
                    +'</div></div></div>';
                    ifpros++;
                    if(ifpros == 1){
                    $(".ifpros").prepend(html);
                    }
                }else{
                    ifpros = 0;
                    $(".ifpriceAMCYes").remove();
                }
            });
            var ifprosc = 0;
            $("input[name='is_billing_inter_state']").click(function () {
                if ($("#is_billing_inter_state_yes").is(":checked")) {
                    var samas = '<input type="checkbox" name="del_same_as_bill_addr" id="del_same_as_bill_addr" value="Y">'
                    +'<label class="" style="padding:0 5px;font-size: 12px;">Same as Billing Address</label><span id="deladdrserror" style="font-size: 11px;color: #a94442;"></span>';
                    $('#sameasaddr').html(samas);
                    var html='<div class="col-md-6 ifinterstateYes">'
                    +'<div class="form-group billingaddrsdiv">'
                    +'<label class="">Billing Address <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="input-icon right">'
                    +'<i class="fa"></i>'
                    +'<textarea rows="2" type="text" class="form-control" name="billing_address" id="billing_address" placeholder="Billing Address"></textarea>'
                    +'</div>'
                    +'<div class="dflx">'
                    +'<input type="checkbox" name="bill_same_as_reg_addr" id="bill_same_as_reg_addr" value="checked">'
                    +'<label class="" style="padding:0 5px;font-size: 12px;">Same as Registered Address</label>'
                    +'</div>'
                    +'<span class="billingaddrserror" style="font-size: 11px;color: #a94442;"></span>'
                    +'</div></div>';
                    ifprosc++;
                    if(ifprosc == 1){
                    $(".ifpros").prepend(html);
                    }
                }else{
                    ifprosc = 0;
                    var samas = '<input type="checkbox" name="del_same_as_site_addr" id="del_same_as_site_addr" value="Y">'
                    +'<label class="" style="padding:0 5px;font-size: 12px;">Same as Site Address</label><span id="deladdrserror" style="font-size: 11px;color: #a94442;"></span>';
                    $('#sameasaddr').html(samas);
                    $(".ifinterstateYes").remove();
                }
            });
            var cntda = 0;
            $("input[name='agreement_prepared']").click(function () {
                if ($("#agreement_prepared_yes").is(":checked")) {
                    var html = '<div class="col-md-3 aggupload"><div class="form-group">'
                    +'<label class="control-label">Draft Agreement Document Upload  <span class="require" aria-required="true" style="color:#a94442">*</span></label><br>'
                    +'<input type="file" name="upload_draft_doc_file" id="upload_draft_doc_file" class="upload_draft_doc_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />'
                    +'<span id="upload_draft_doc_file_error" style="font-size: 12px;color:#a94442;"></span>'
                    +'</div></div>'
                    +'<div class="col-md-3 aggupload">'
                    +'<div class="form-group">'
                    +'<label class="control-label">Signed Agreement Document Upload</label><br>'
                    +'<input type="file" name="upload_sign_doc_file" id="upload_sign_doc_file" class="upload_sign_doc_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />'
                    +'<span id="upload_sign_doc_file_error" style="font-size: 12px;color:#a94442;"></span>'
                    +'</div></div>';
                    cntda++;
                    if(cntda == 1){
                    $(".agreementprepared").append(html);
                    }
                } else {
                    cntda = 0;
                    $(".aggupload").remove();
                }
            });
            
            $("input[name='insurance_req']").click(function () {
                if ($("#insurance_yes").is(":checked")) {
                    var html = '<div class="row dflxd insurance_req_div">'
                    +'<div class="col-md-6"><div class="form-group">'
                    +'<label class="">Insurance Details <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="input-icon right"><i class="fa"></i>'
                    +'<textarea rows="2" type="text" class="form-control" name="insurance_remark[]" id="insurance_remark1" placeholder="Insurance Details"></textarea>'
                    +'</div></div></div>'
                    +'<div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="">Insurance up to <br> which date <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="input-icon right">'
                    +'<i class="fa"></i>'
                    +'<div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-viewmode="years">'
                    +'<input type="text" name="insurance_up_to_date[]" id="insurance_up_to_date1" class="form-control" placeholder="dd-mm-yyyy" readonly>'
                    +'<span class="input-group-btn">'
                    +'<button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>'
                    +'</div></div></div></div>'
                    +'<div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="">Amount Of Risk <br> Coverage <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="input-icon right">'
                    +'<i class="fa"></i>'
                    +'<input type="number" class="form-control " name="amount_of_risk_cov[]" id="amount_of_risk_cov1" placeholder="Amount Of Risk Coverage">'
                    +'</div></div></div>'
                    +'<div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="">Upload Insurance <br> Documment</label>'
                    +'<input type="file" name="insurance_required_doc[]" id="insurance_required_doc1" class="insurance_required_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">'
                    +'</div></div>'
                    +'<div class="col-md-1">'
                    +'<div class="adbtn"><i class="fa fa-plus" aria-hidden="true"  style="font-size:10px;"></i></div>'
                    +'</div></div>';
                    $('#insurancereqdiv').html(html);
                    $("#nsuranceRequiredApp").show();
                }else{
                    $("#insurancereqdiv").html('');
                    $("#nsuranceRequiredApp").hide();
                }
            });
            
            $("input[name='payment_terms']").click(function () {
                if ($("#SITC").is(":checked")) {
                    $("#billing_split_up").show();
                    const a = document.getElementById('bill_split_supply');
                    a.setAttribute('required', '');
                    const b = document.getElementById('bill_installation');
                    b.setAttribute('required', '');
                    const c = document.getElementById('testing_commissioning');
                    c.setAttribute('required', '');
                    const d = document.getElementById('bill_handover');
                    d.setAttribute('required', '');
                } else {
                    $("#billing_split_up").hide();
                    const a = document.getElementById('bill_split_supply');
                    a.removeAttribute('required');
                    const b = document.getElementById('bill_installation');
                    b.removeAttribute('required');
                    const c = document.getElementById('testing_commissioning');
                    c.removeAttribute('required');
                    const d = document.getElementById('bill_handover');
                    d.removeAttribute('required');
                }
            });
            $("#fat").click(function () {
                if ($(this).is(":checked")) {
                    var html = '<hr style="margin: 15px 0;"><div class="row dvfat">'
                    +'<div class="col-md-4">'
                    +'<label class="">FAT <span class="require" aria-required="true" style="color:#a94442">*</span></label> <span id="appfatderror" style="font-size:12px;color:#a94442;"></span>'
                    +'</div>'
                    +'<div class="col-md-8">'
                    +'<div style="display:flex;">'
                    +'<div class="form-group" style="width: 90%;">'
                    +'<div class="input-icon right"><i class="fa"></i>'
                    +'<input type="hidden" id="prcnt" value="1">'
                    +'<input type="text" class="form-control" name="fat_text[]" id="fat_text1" placeholder="FAT" required>'
                    +'</div>'
                    +'</div><div class="" style="width: 10%;">'
                    +'<div class="adfatbtn"><i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i></div>'
                    +'</div></div>'
                    +'</div>'
                    +'</div><div class="appfatd" id="appfatd"></div>';
                    $('#didetlsa').append(html);
                } else {
                    $(".dvfat").remove();
                }
            });
            $("#sat").click(function () {
                if ($(this).is(":checked")) {
                    var html = '<hr style="margin: 15px 0;"><div class="row dvsat">'
                    +'<div class="col-md-4">'
                    +'<label class="">SAT <span class="require" aria-required="true" style="color:#a94442">*</span></label> <span id="appsatderror" style="font-size:12px;color:#a94442;"></span>'
                    +'</div>'
                    +'<div class="col-md-8">'
                    +'<div style="display:flex;">'
                    +'<div class="form-group" style="width: 90%;">'
                    +'<div class="input-icon right"><i class="fa"></i>'
                    +'<input type="hidden" id="stcnt" value="1">'
                    +'<input type="text" class="form-control" name="sat_text[]" id="sat_text1" placeholder="SAT" required>'
                    +'</div>'
                    +'</div><div class="" style="width: 10%;">'
                    +'<div class="adsatbtn"><i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i></div>'
                    +'</div></div>'
                    +'</div>'
                    +'</div><div class="appsatd" id="appsatd"></div>';
                    $('#didetlsa').append(html);
                } else {
                    $(".dvsat").remove();
                }
            });
            $("#sample").click(function () {
                if ($(this).is(":checked")) {
                    var html = '<hr style="margin: 15px 0;"><div class="row dvsample">'
                    +'<div class="col-md-4">'
                    +'<label class="">Sample <span class="require" aria-required="true" style="color:#a94442">*</span></label> <span id="appsamplederror" style="font-size:12px;color:#a94442;"></span>'
                    +'</div>'
                    +'<div class="col-md-8">'
                    +'<div style="display:flex;">'
                    +'<div class="form-group" style="width: 90%;">'
                    +'<div class="input-icon right"><i class="fa"></i>'
                    +'<input type="hidden" id="smcnt" value="1">'
                    +'<input type="text" class="form-control" name="sample_text[]" id="sample_text1" placeholder="Sample" required>'
                    +'</div>'
                    +'</div><div class="" style="width: 10%;">'
                    +'<div class="adsamplebtn"><i class="fa fa-plus" aria-hidden="true" style="font-size:10px;"></i></div>'
                    +'</div></div>'
                    +'</div>'
                    +'</div><div class="adsampled" id="adsampled"></div>';
                    $('#didetlsa').append(html);
                } else {
                    $(".dvsample").remove();
                }
            });
            
            $("[name*=sat_text]").on("keyup change", function() 
            {
                var data_id = $(this).data("id"); 
                var value = $(this).val() 
                $("input[data-id=" + data_id + "]").val(value)  
            })
            var cntw = 0;
            $("input[name='invoice_submitted']").click(function () {
                if ($("#invoice_submitted_yes").is(":checked")) {
                    var html = '<div class="col-md-6 ifinvoicesubmittedYes">'
                    +'<div class="form-group">'
                    +'<label class="">Invoice to be submitted on customer website <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="input-icon right"><i class="fa"></i>'
                    +'<input type="text" class="form-control" name="invoice_submitted_text" id="invoice_submitted_text" placeholder="Invoice to be submitted on customer website" >'
                    +'</div></div></div>';
                    cntw++;
                    if(cntw == 1){
                    $("#daddde").append(html);
                    }
                }else{
                    cntw = 0;
                    $(".ifinvoicesubmittedYes").remove();
                }
            });
            var cntwa = 0;
            $("input[name='invoice_submitted_address']").click(function () {
                if ($("#invoice_submitted_address_yes").is(":checked")) {
                    var html = '<div class="col-md-6 ifinvoicesubmittedaddYes">'
                    +'<div class="form-group">'
                    +'<label class="">Invoice to be sent on different address <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="input-icon right"><i class="fa"></i>'
                    +'<textarea rows="1" type="text" class="form-control" name="invoice_submitted_address_text" id="invoice_submitted_address_text" placeholder="Invoice to be sent on different address"></textarea>'
                    +'</div></div></div>';
                    cntwa++;
                    if(cntwa == 1){
                    $("#daddde").append(html);
                    }
                }else{
                    cntwa = 0;
                    $('.ifinvoicesubmittedaddYes').remove();
                }
            });
            var cntwe = 0;
            $("input[name='esic_required']").click(function () {
                if ($("#esicYes").is(":checked")) {
                    $("#ifesicrequiredYes").show();
                    var html = '<div class="col-md-6 ifesicrequiredYes">'
                    +'<div class="form-group"><label class="">ESIC Required <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="input-icon right"><i class="fa"></i>'
                    +'<input type="text" class="form-control" name="esic_required_text" id="esic_required_text" placeholder="ESIC Required">'
                    +'</div></div></div>';
                    cntwe++;
                    if(cntwe == 1){
                    $("#daddde").append(html);
                    }
                }else{
                    cntwe = 0;
                    $('.ifesicrequiredYes').remove();
                }
            });
            var cntwp = 0;
            $("input[name='pf_required']").click(function () {
                if ($("#pfYes").is(":checked")) {
                    var html = '<div class="col-md-6 ifepfrequiredYes">'
                    +'<div class="form-group"><label class="">PF Required <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="input-icon right"><i class="fa"></i>'
                    +'<input type="text" class="form-control" name="pf_required_text" id="pf_required_text" placeholder="PF Required">'
                    +'</div></div></div>';
                    cntwp++;
                    if(cntwp == 1){
                    $("#daddde").append(html);
                    }
                } else {
                    cntwp = 0;
                    $('.ifepfrequiredYes').remove();
                }
            });




// Ankit changes
             var ccnt =1
            $(document).on('click', '.add_consignee', function() {
        	    var consignee_name = $("#consignee_name0").val();
                var delivery_address = $("#delivery_address0").val();
                var gst_types = $("#gst_types0").val();
                
                if(consignee_name !=='' && typeof consignee_name != 'undefined' && 
                delivery_address !=='' && typeof delivery_address != 'undefined' && 
                gst_types !=='' && typeof gst_types != 'undefined'
                ){
                $("#consignee_error").html('');
                var html = '<div class="row consinee_detail">'
        	    +'<div class="col-md-4">'
        	    +'<div class="form-group">'
                +'<input type="text" class="form-control " name="consignee_name[]" id="consignee_name'+ccnt+'" value="'+consignee_name+'" readonly>'
                +'</div>'
                +'</div>'
                +'<div class="col-md-4">'
                +'<div class="form-group">'
                +'<textarea type="text" class="form-control " name="delivery_address[]" id="delivery_address'+ccnt+'" readonly>'+delivery_address+'</textarea>'
                +'</div>'
                +'</div>'
                +'<div class="col-md-3">'
                +'<div class="form-group">'
                +'<input type="text" class="form-control " name="gst_types[]" id="gst_types'+ccnt+'" value="'+gst_types+'" readonly>'
                +'</div>'
                +'</div>'
                +'<div class="col-md-1">'
                +'<div class="rmbtnss"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>'
                +'</div></div>';
        		$("#consineeDetailDisplayed").prepend(html);
        		$("#consignee_name0").val('');
                $("#delivery_address0").val('');
                $("#gst_types0").val('');
        		ccnt++;
                }else{
                $("#consignee_error").html('Please enter consignee required details!');
        		}
        	});
           
            $(document).on('click','.rmbtnss',function(){
               
                $(this).parent().parent().remove();
            });
            
            $(document).on("click", '#del_same_as_bill_addr', function(event) { 
                if ($("#del_same_as_bill_addr").is(":checked")) {
                    var billing_address = $("#billing_address").val().trim();
                    if(billing_address !=''){
                        $("#delivery_address").val(billing_address);
                        $("#deladdrserror").text('');
                        const input2 = document.getElementById('delivery_address');
                        input2.setAttribute('readonly', '');
                        const input = document.getElementById('billing_address');
                        input.setAttribute('required', '');
                    }else{
                        $('#del_same_as_bill_addr').prop('checked',false);
                        $("#deladdrserror").text('Enter Billing Address!');
                        const input2 = document.getElementById('delivery_address');
                        input2.removeAttribute('readonly');
                        const input = document.getElementById('billing_address');
                        input.setAttribute('required', '');
                    }
                } else {
                    $('#del_same_as_bill_addr').prop('checked',false);
                    $("#deladdrserror").text('');
                    const input2 = document.getElementById('delivery_address');
                    input2.removeAttribute('readonly');
                    const input = document.getElementById('billing_address');
                    input.removeAttribute('required');
                }
            });
            $(document).on("click", '#del_same_as_site_addr', function(event) { 
                if ($("#del_same_as_site_addr").is(":checked")) {
                    var site_address = $("#site_address").val().trim();
                    if(site_address !=''){
                        $("#delivery_address").val(site_address);
                        $("#deladdrserror").text('');
                    }else{
                        $('#del_same_as_site_addr').prop('checked',false);
                        $("#deladdrserror").text('Enter Site Address!');
                    }
                } else {
                    $('#del_same_as_site_addr').prop('checked',false);
                    $("#deladdrserror").text('');
                }
            });
            
            
            $(document).on("click", '#bill_same_as_reg_addr', function(event) { 
                if ($("#bill_same_as_reg_addr").is(":checked")) {
                    var registered_address = $("#registered_address").val().trim();
                    if(registered_address !=''){
                        $("#billing_address").val(registered_address);
                        $(".billingaddrsdiv").show();
                        $(".billingaddrserror").text('');
                        const input2 = document.getElementById('billing_address');
                        input2.setAttribute('readonly', '');
                        const input = document.getElementById('registered_address');
                        input.setAttribute('required', '');
                        const input1 = document.getElementById('bill_same_as_reg_addr');
                        input1.setAttribute('required', '');
                    }else{
                        $(".billingaddrsdiv").show();
                        $('#bill_same_as_reg_addr').prop('checked',false);
                        $(".billingaddrserror").text('Enter Registered Address!');
                        const input = document.getElementById('registered_address');
                        input.setAttribute('required', '');
                        const input1 = document.getElementById('bill_same_as_reg_addr');
                        input1.removeAttribute('required');
                    }
                } else {
                    $("#billing_address").val('');
                    $(".billingaddrsdiv").show();
                    $(".billingaddrserror").text('');
                    const input2 = document.getElementById('billing_address');
                    input2.removeAttribute('readonly');
                    const input = document.getElementById('registered_address');
                    input.removeAttribute('required');
                    const input1 = document.getElementById('bill_same_as_reg_addr');
                    input1.removeAttribute('required');
                }
            });
            
            $("input[name='emd_paid']").click(function () {
                if ($("#emd_paid").is(":checked")) {
                    var html = '<div class="row ifemdpaid">'
                    +'<div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="">EMD Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="input-icon right"><i class="fa"></i>'
                    +'<input type="number" class="form-control " name="emd_paid_num" id="emd_paid_num" placeholder="EMD Amount">'
                    +'</div></div></div>'
                    +'<div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="control-label">EMD Paid <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="dflx">'
                    +'<input type="radio" name="emd_paid_status" id="emd_paid_status_yes" class="emd_paid_status_div" value="Yes"><span style="padding: 0 10px 0px 5px;">Yes</span>'
                    +'<input type="radio" name="emd_paid_status" id="emd_paid_status_no" class="emd_paid_status_div" value="No" checked=""><span style="padding: 0 10px 0px 5px;">No</span>'
                    +'</div></div></div>'
                    +'<div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="control-label">Upload EMD Paid <span class="require" aria-required="true" style="color:#a94442">*</span></label><br>'
                    +'<input type="file" name="upload_emd_paid_file" id="upload_emd_paid_file" class="upload_emd_paid_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">'
                    +'<span id="upload_emd_paid_file_error" style="font-size: 12px;color:#a94442;"></span>'
                    +'</div></div>'
                    +'<div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="">Payment Mode <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<select class="form-control select2me" name="emd_payment_mode" id="emd_payment_mode">'
                    +'<option value="">Select</option>'
                    +'<option value="Bank Transfer">Bank Transfer</option>'
                    +'<option value="Fixed Deposit">Fixed Deposit</option>'
                    +'<option value="Demand Draft">Demand Draft</option>'
                    +'</select>'
                    +'</div>'
                    +'</div>'
                    +'<div class="col-md-3" id="ccd_div"></div>'
                    +'</div>';
                    $("#ifemdpaiddiv").html(html);
                }else{
                    $(".ifemdpaid").remove();
                }
            });
            $("[name*=emd_paid_num]").on("keyup change", function() 
            {
                var data_id = $(this).data("id"); 
                var value = $(this).val() 
                $("input[data-id=" + data_id + "]").val(value)  
            })
            $("input[name='asd_paid']").click(function () {
                if ($("#asd_paid").is(":checked")) {
                    var html='<div class="row ifasdpaid">'
                    +'<div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="">ASD Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="input-icon right">'
                    +'<i class="fa"></i>'
                    +'<input type="number" class="form-control " name="asd_paid_num" id="asd_paid_num" placeholder="ASD Amount">'
                    +'</div></div></div>'
                    +'<div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="control-label">ASD Paid <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="dflx">'
                    +'<input type="radio" name="asd_paid_status" id="asd_paid_status_yes" class="asd_paid_status_div" value="Yes"><span style="padding: 0 10px 0px 5px;">Yes</span>'
                    +'<input type="radio" name="asd_paid_status" id="asd_paid_status_no" class="asd_paid_status_div" value="No" checked><span style="padding: 0 10px 0px 5px;">No</span>'
                    +'</div></div></div>'
                    +'<div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="control-label">Upload ASD Paid  <span class="require" aria-required="true" style="color:#a94442">*</span></label><br>'
                    +'<input type="file" name="upload_asd_paid_file" id="upload_asd_paid_file" class="upload_asd_paid_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />'
                    +'<span id="upload_asd_paid_file_error" style="font-size: 12px;color:#a94442;"></span></div></div>'
                    +'<div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="">Payment Mode <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<select class="form-control select2me" name="asd_payment_mode" id="asd_payment_mode">'
                    +'<option value="">Select</option>'
                    +'<option value="Bank Transfer">Bank Transfer</option>'
                    +'<option value="Fixed Deposit">Fixed Deposit</option>'
                    +'<option value="Demand Draft">Demand Draft</option>'
                    +'</select>'
                    +'</div>'
                    +'</div>'
                    +'<div class="col-md-3" id="asdccd_div"></div>'
                    +'</div>';
                    $("#ifasdpaiddiv").html(html);
                }else{
                    $(".ifasdpaid").remove();
                }
            });
            $("[name*=asd_paid_num]").on("keyup change", function() 
            {
                var data_id = $(this).data("id"); 
                var value = $(this).val() 
                $("input[data-id=" + data_id + "]").val(value)  
            })
           
            
            $("input[name='security_deposite']").click(function () {
                if ($("#security_deposite").is(":checked")) {
                    $(".ifsecdepostitepaid").show();
                    $(".sdfullwidth").css('width','100%');
                    $(".sdfullwidth").css('display','flex');
                    const input = document.getElementById('security_deposite_num');
                    input.setAttribute('required', '');
                } else {
                    $(".ifsecdepostitepaid").hide();
                    $(".sdfullwidth").css('width','auto');
                    $(".sdfullwidth").css('display','block');
                    const input = document.getElementById('security_deposite_num');
                    input.removeAttribute('required');
                }
            });
            $("[name*=security_deposite_num]").on("keyup change", function() 
            {
                var data_id = $(this).data("id"); 
                var value = $(this).val() 
                $("input[data-id=" + data_id + "]").val(value)  
            })
            var apperdi = 0;
            $("input[name='performance_paid']").click(function () {
                if ($("#performance_paid").is(":checked")) {
                    var html='<div class="row ifperformancepaid"><div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="">Performance Guarantee/Bond Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="input-icon right"><i class="fa"></i>'
                    +'<input type="number" class="form-control" name="performance_guarantee_num" id="performance_guarantee_num" placeholder="Performance Guarantee/Bond Amount">'
                    +'</div></div></div>'
                    +'<div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="control-label">Performance Guarantee/Bond Paid <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="dflx">'
                    +'<input type="radio" name="per_paid_status" id="per_paid_status_yes" value="Yes"><span style="padding: 0 10px 0px 5px;">Yes</span>'
                    +'<input type="radio" name="per_paid_status" id="per_paid_status_no" value="No" checked><span style="padding: 0 10px 0px 5px;">No</span>'
                    +'</div></div></div>'
                    +'<div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="">Performance Guarantee/Bond Validity (Months) <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="input-icon right">'
                    +'<i class="fa"></i>'
                    +'<input type="number" class="form-control " name="pbg_validity" id="pbg_validity" placeholder="PBG Validity">'
                    +'</div></div></div>'
                    +'<div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="">Payment Mode <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<select class="form-control select2me" name="per_payment_mode" id="per_payment_mode">'
                    +'<option value="">Select</option>'
                    +'<option value="bank_transder">Bank Transfer</option>'
                    +'<option value="fixed_deposite">Fixed Deposit</option>'
                    +'<option value="demand_draft">Demand Draft</option>'
                    +'<option value="bank_guarantee">Bank Guarantee</option>'
                    +'</select>'
                    +'</div>'
                    +'</div>';
                    
                    var html1 = '<div class="row"><div class="col-md-3 ifperformancepaid">'
                    +'<div class="form-group">'
                    +'<label class="control-label">Upload Draft Bond Document <span class="require" aria-required="true" style="color:#a94442">*</span></label><br>'
                    +'<input type="file" name="draft_performance_paid_file" id="draft_performance_paid_file" class="draft_performance_paid_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />'
                    +'<span id="draft_performance_paid_file_error" style="font-size: 12px;color:#a94442;"></span>'
                    +'</div></div>'
                    +'<div class="col-md-3 ifperformancepaid">'
                    +'<div class="form-group">'
                    +'<label class="control-label">Upload Final Bond Document</label><br>'
                    +'<input type="file" name="final_performance_paid_file" id="final_performance_paid_file" class="final_performance_paid_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />'
                    +'<span id="final_performance_paid_file_error" style="font-size: 12px;color:#a94442;"></span>'
                    +'</div></div>'
                    +'<div class="col-md-3">'
                    +'<div class="form-group">'
                    +'<label class="">PG Amount <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
                    +'<div class="input-icon right">'
                    +'<i class="fa"></i>'
                    +'<input type="number" class="form-control " name="pg_amount" id="pg_amount" placeholder="PG Amount">'
                    +'</div></div></div>'
                    +'<div class="col-md-3" id="sd_pbg_fd"></div>'
                    +'</div>';
                    apperdi++;
                    if(apperdi == 1){
                    $("#apperdi").html(html1);
                    }
                    $("#ifperformancepaiddiv").html(html);
                }else{
                    apperdi = 0;
                    $(".ifperformancepaid").remove();
                }
            });
            $("[name*=performance_guarantee_num]").on("keyup change", function() 
            {
                var data_id = $(this).data("id"); 
                var value = $(this).val() 
                $("input[data-id=" + data_id + "]").val(value)  
            })
        });
    $(document).on('click','.psupdatesubmit',function(e){
        var form = '#'+$(this).parents('form').attr('id');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        var id = $(this).attr('rel');

        jQuery.validator.addMethod("onlyletters", function(value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
        }, "Only Alphabetical Characters");

        jQuery.validator.addMethod("percentage", function(value, element) {
        return this.optional(element) || /^\d+\.?\d?\d?%?$/i.test(value);
        }, "Only Number Are Allowed");

        jQuery.validator.addMethod("onlyNumber", function(value, element) {
        return this.optional(element) || /^[0-9]*$/i.test(value);
        }, "Only Number Are Allowed");
        
        jQuery.validator.addMethod("totalPercent", function (value, element) {
            var total = 0;
            $(".tcl").each(function(){
                if(parseInt($(this).val()) > 0){
                    total += parseInt($(this).val());
                }
            });
            return total == 100;
        }, function(params, element) {
          return 'Total amount must be less than or equal to 100%.'
        });

        $(form).validate({ 
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: ":hidden",  // validate all fields including form hidden input
            rules: {
                customer_name:{ required: true },
                bp_code:{ required: true },
                po_loi_no:{ required: true },
                po_loi_received_data:{ required: true },
                registered_address:{ required: true },
                client_po_addr:{ required: true },
                our_address_on_po:{ required: true },
                name_of_work:{ required: true },
                work_order_on:{ required: true },
                site_address:{ required: true },
                taxable_amount:{ required: true,number:true },
                gst_amount:{ required: true,number:true },
                total_amount:{ required: true,number:true },
                emd_paid_num:{ required: true,number:true },
                //upload_emd_paid_file:{ required: true },
                emd_paid_status:{ required: true },
                asd_paid_num:{ required: true,number:true },
                //upload_asd_paid_file:{ required: true },
                performance_guarantee_num:{ required: true,number:true },
                //final_performance_paid_file:{ required: true },
                //draft_performance_paid_file:{ required: true },
                pbg_validity:{ required: true,number:true },
                security_deposite_num:{ required: true,number:true },
                warranty_period:{ required: true,number:true },
                billing_related:{ required: true },
                po_related:{ required: true },
                execution_related:{ required: true },
                engineer_in_charge:{ required: true },
                completion_period:{ required: true,number:true },
                gst_no:{ required: true},
                price_inslusive_of_amc:{ required: true},
                is_billing_inter_state:{ required: true},
                amc_applicable_after:{ required: true,number:true },
                billing_address:{ required: true},
                delivery_address:{ required: true},
                insurance_req:{ required: true},
                "insurance_remark[]": 
                { 
                    required: true
                },
                "insurance_up_to_date[]": 
                { 
                    required: true
                },
                "amount_of_risk_cov[]": 
                { 
                    required: true
                },
               // "insurance_required_doc[]": 
                //{ 
                 //   required: true
                //},
                agreement_prepared:{ required: true },
                //upload_draft_doc_file:{ required: true },
                //upload_sign_doc_file:{ required: true },
                //upload_sign_doc_file:{ required: true },
                penalty_clause:{ required: true },
                power_of_attorney:{ required: true },
                inspection_text:{ required: true },
                inspection_text:{ required: true },
                "sample_text[]": 
                { 
                    required: true
                },
                "prototype_text[]": 
                { 
                    required: true
                },
                "fat_text[]": 
                { 
                    required: true
                },
                "sat_text[]": 
                { 
                    required: true
                },
                payment_terms:{ required: true },
                bill_split_supply:{ required: true,number:true, totalPercent: true },
                bill_installation:{ required: true,number:true, totalPercent: true },
                testing_commissioning:{ required: true,number:true, totalPercent: true },
                bill_handover:{ required: true,number:true, totalPercent: true },
                invoice_submitted:{ required: true},
                invoice_submitted_text:{ required: true},
                invoice_submitted_address:{ required: true},
                invoice_submitted_address_text:{ required: true},
                esic_required:{ required: true},
                esic_required_text:{ required: true},
                pf_required:{ required: true},
                pf_required_text:{ required: true},
                //upload_projectcmpl_doc_file:{ required: true},
                //upload_projectdesig_doc_file:{ required: true},
                //upload_projectcashflw_doc_file:{ required: true},
                //upload_projectinvstsch_doc_file:{ required: true},
            },
            invalidHandler: function (event, validator) { //display error alert on form submit              
                success.hide();
                error.show();
                $('html,body').animate({scrollTop:0});
                $('#error_alert').show();
                $('.required_icon').html('*');
            },
            errorPlacement: function (error, element) { // render error placement for each input type
                var icon = $(element).parent('.input-icon').children('i');
                icon.removeClass('fa-check').addClass("fa-warning");  
                icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
            },
            highlight: function (element) { // hightlight error inputs
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
                Metronic.startPageLoading({animate: true});
                $(form).ajaxSubmit({
                    type:'POST',
                    url:completeURL(url), 
                    dataType:'json',
                    data:serialize_data,
                    success:function(data)
                    {  
                        Metronic.stopPageLoading(); 
                        $('.common_save').prop('disabled',false);
                        if(data.valid) 
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
                                bootbox.alert(data.msg);
                            }
                        }
                        else
                        {
                            if(data.no_popup)
                            {
                               bootbox.alert(data.msg);
                            }
                            else
                            {
                                bootbox.alert(data.msg);
                            }
                        }

                    }
                });
            }
        });
    });
        $(document).on('click','.pssave',function(e){
        var form = '#'+$(this).parents('form').attr('id');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        var id = $(this).attr('rel');

        jQuery.validator.addMethod("onlyletters", function(value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
        }, "Only Alphabetical Characters");

        jQuery.validator.addMethod("percentage", function(value, element) {
        return this.optional(element) || /^\d+\.?\d?\d?%?$/i.test(value);
        }, "Only Number Are Allowed");

        jQuery.validator.addMethod("onlyNumber", function(value, element) {
        return this.optional(element) || /^[0-9]*$/i.test(value);
        }, "Only Number Are Allowed");
        
        jQuery.validator.addMethod("totalPercent", function (value, element) {
            var total = 0;
            $(".tcl").each(function(){
                if(parseInt($(this).val()) > 0){
                    total += parseInt($(this).val());
                }
            });
            return total == 100;
        }, function(params, element) {
          return 'Total amount must be less than or equal to 100%.'
        });

        $(form).validate({ 
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: ":hidden",  // validate all fields including form hidden input
            rules: {
                customer_name:{ required: true },
                business_head:{ required: true },
                manager_head:{ required: true },
                bp_code:{ required: true },
            },
            invalidHandler: function (event, validator) { //display error alert on form submit              
                success.hide();
                error.show();
                $('html,body').animate({scrollTop:0});
                $('#error_alert').show();
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
                Metronic.startPageLoading({animate: true});
                $(form).ajaxSubmit({
                    type:'POST',
                    url:completeURL(url), 
                    dataType:'json',
                    data:serialize_data,
                    success:function(data)
                    {  
                        Metronic.stopPageLoading(); 
                        $('.common_save').prop('disabled',false);
                        if(data.valid) 
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
                                bootbox.alert(data.msg);
                            }
                        }
                        else
                        {
                            if(data.no_popup)
                            {
                               bootbox.alert(data.msg);
                            }
                            else
                            {
                                bootbox.alert(data.msg);
                            }
                        }

                    }
                });
            }
        });
    });
        
    $(document).on('click','.psupdate',function(e){
        var form = '#'+$(this).parents('form').attr('id');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        var id = $(this).attr('rel');

        jQuery.validator.addMethod("onlyletters", function(value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
        }, "Only Alphabetical Characters");

        jQuery.validator.addMethod("percentage", function(value, element) {
        return this.optional(element) || /^\d+\.?\d?\d?%?$/i.test(value);
        }, "Only Number Are Allowed");

        jQuery.validator.addMethod("onlyNumber", function(value, element) {
        return this.optional(element) || /^[0-9]*$/i.test(value);
        }, "Only Number Are Allowed");
        
        jQuery.validator.addMethod("totalPercent", function (value, element) {
            var total = 0;
            $(".tcl").each(function(){
                if(parseInt($(this).val()) > 0){
                    total += parseInt($(this).val());
                }
            });
            return total == 100;
        }, function(params, element) {
          return 'Total amount must be less than or equal to 100%.'
        });

        $(form).validate({ 
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: ":hidden",  // validate all fields including form hidden input
            rules: {
                customer_name:{ required: true },
                business_head:{ required: true },
                manager_head:{ required: true },
                bp_code:{ required: true },
            },
            invalidHandler: function (event, validator) { //display error alert on form submit              
                success.hide();
                error.show();
                $('html,body').animate({scrollTop:0});
                $('#error_alert').show();
                $('.required_icon').text('');
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
                Metronic.startPageLoading({animate: true});
                $(form).ajaxSubmit({
                    type:'POST',
                    url:completeURL(url), 
                    dataType:'json',
                    data:serialize_data,
                    success:function(data)
                    {  
                        Metronic.stopPageLoading(); 
                        $('.common_save').prop('disabled',false);
                        if(data.valid) 
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
                                bootbox.alert(data.msg);
                            }
                        }
                        else
                        {
                            if(data.no_popup)
                            {
                               bootbox.alert(data.msg);
                            }
                            else
                            {
                                bootbox.alert(data.msg);
                            }
                        }

                    }
                });
            }
        });
    });
    
    