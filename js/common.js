// add/edit BOQ Items
// alert("ok");
$(document).on('click','.addDynaRow',function(){        
        var project_id = document.getElementById("project_id").value;
        var boq_code = document.getElementById("boq_code").value;
        var hsn_sac_code = document.getElementById("hsn_sac_code").value;
        var item_description = document.getElementById("item_description").value;
        var unit = document.getElementById("unit").value;
        var scheduled_qty = document.getElementById("scheduled_qty").value;
        var design_qty = document.getElementById("design_qty").value;
        var rate_basic = document.getElementById("rate_basic").value;
        var gst = document.getElementById("gst").value;
        var non_schedule = 'N';//document.querySelector("input[type='radio'][name=non_schedule_r]:checked").value;
        if($('#non_schedule_yes').is(':checked')){
        non_schedule = 'Y';    
        }else if($('#non_schedule_no').is(':checked')){
        non_schedule = 'N';    
        }else{
        non_schedule = 'N';    
        }
        if(boq_code === '' || hsn_sac_code === '' || item_description === '' || unit === '' || scheduled_qty < 0 || design_qty < 0 || rate_basic < 1){
            $('.invaliderror').addClass('has-error');
        }else{
            boq_code_no = [];
        	$("input[name='boq_code[]']").each(function(){
        		boq_code_no.push($(this).val());
        	});
            
        	if ($.inArray(boq_code, boq_code_no) != -1){
        	    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                $('#boq_code').val('');
                $('#hsn_sac_code').val('');
                $('#item_description').val('');
                $('#unit').val('');
                $('#scheduled_qty').val('');
                $('#design_qty').val('');
                $('#rate_basic').val('');
                $('#gst').val('');
                //$('#boq_code').prop('readonly', false);
                $('#hsn_sac_code').prop('readonly', false);
                $('#item_description').prop('readonly', false);
                $('#unit').prop('readonly', false);
                $('#scheduled_qty').prop('readonly', false);
                $('#gst').prop('readonly', false);
                $('#non_schedule_yes').prop('checked', false);
                $('#non_schedule_no').prop('checked', true);
            }else{
                var base_url = $('#base_url').val().trim();
                var last_design_qty = 0;
                last_design_qty = function () {
                    var tmp = null;
                    $.ajax({
                        'async': false,
                        'type': "POST",
                        'global': false,
                        'dataType': 'html',
                        'url': base_url+"get_last_design_qty",
                        'data': { 'boq_code': boq_code, 'project_id': project_id},
                        'success': function (data) {
                            tmp = data;
                        }
                    });
                    return tmp;
                }();
                var pending_req = 0;
                pending_req = function () {
                    var tmp1 = null;
                    $.ajax({
                        'async': false,
                        'type': "POST",
                        'global': false,
                        'dataType': 'html',
                        'url': base_url+"check_boq_exceptional_approval",
                        'data': {'boq_code': boq_code, 'project_id': project_id},
                        'success': function (data) {
                            tmp1 = data;
                        }
                    });
                    return tmp1;
                }();
                if(parseInt(pending_req) === 0){
                    if(parseInt(last_design_qty) < parseInt(design_qty)){
                        var html='<tr><td>'
                        +'<input type="text" class="form-control" name="boq_code[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
                        +'<td><input type="text" class="form-control" name="hsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
                        +'<td><input type="text" class="form-control" name="item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
                        +'<td><input type="text" class="form-control" name="unit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
                        +'<td><input type="text" class="form-control" name="scheduled_qty[]" value="'+scheduled_qty+'" readonly style="font-size: 12px;width:100%"></td>'
                        +'<td><input type="text" class="form-control" name="design_qty[]" value="'+design_qty+'" readonly style="font-size: 12px;width:100%"></td>'
                        +'<td><input type="text" class="form-control" name="rate_basic[]" value="'+rate_basic+'" readonly style="font-size: 12px;width:100%"></td>'
                        +'<td><input type="text" class="form-control" name="gst[]" value="'+gst+'" readonly style="font-size: 12px;width:100%"></td>'
                        +'<td><input type="text" class="form-control" name="non_schedule[]" value="'+non_schedule+'" readonly  style="font-size: 12px;width:100%"></td>'
                        +'<td>'
                        +'<div class="addDeleteButton">'
                        +'<span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                        +'</div></td></tr>';
                        $('.invaliderror').removeClass('has-error');
                        $('#invaliderrorid').html('');
                        var clonedRow = $(this).parents('tbody.appendDynaRow').find('tr:first').clone();
                        clonedRow.find('input:not(.ftype)').val('');
                        clonedRow.find('textarea').val('');
                        clonedRow.find('select').val(''); 
                        clonedRow.find('.select2-container').remove(); 
                        clonedRow.find("select").select2();   
                        clonedRow.find('.tooltip').css('display','none');  
                        //clonedRow.find('div.addDeleteButton').html('<span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>');
                        clonedRow.find('.tooltips').tooltip({placement: 'top'});
                        $(this).parents('#boqitmdisplay tbody').find("tr:last").before(html);
                        $('#boq_code').val('');
                        $('#hsn_sac_code').val('');
                        $('#item_description').val('');
                        $('#unit').val('');
                        $('#scheduled_qty').val('');
                        $('#design_qty').val('');
                        $('#rate_basic').val('');
                        $('#gst').val('');
                        //$('#boq_code').prop('readonly', false);
                        $('#hsn_sac_code').prop('readonly', false);
                        $('#item_description').prop('readonly', false);
                        $('#unit').prop('readonly', false);
                        $('#scheduled_qty').prop('readonly', false);
                        $('#gst').prop('readonly', false);
                        $('#non_schedule_yes').prop('checked', false);
                        $('#non_schedule_no').prop('checked', true);
                    	
                    }else{
                        $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Design Qty must be greater than '+last_design_qty+' !');
                    }
                }else{
                    $('#invaliderrorid').html('Exceptional Approval Pending!');
                }
            }
        }
        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                orientation: "right",
                autoclose: true,
            });
        } 
        Metronic.init();
    });
    
//BOQ Exceptional Approval
$(document).on('keyup','#except_ea_qty',function(){  
    var boq_code = document.getElementById("except_boq_code").value;
    var ea_design_qty = document.getElementById("except_ea_design_qty").value;
    var qty = $(this).val().trim();
    var calqty = 0;
    if(ea_design_qty !== '' && typeof ea_design_qty !== "undefined" && parseInt(ea_design_qty) > 0){
        var design_qty_chk = ea_design_qty;
        if(qty !== '' && typeof qty !== "undefined" && parseInt(qty) < 0){
            if(Math.abs(qty) <= design_qty_chk){
                $('#invaliderrorexceptdiv').html('');          
            }else{
                $('#invaliderrorexceptdiv').html('BOQ Sr No '+boq_code+' Build Qty up to -'+design_qty_chk+'!');
                $('#except_ea_qty').val('');          
            }
        }else{
            $('#invaliderrorexceptdiv').html('');    
        }
    }else{
        if(ea_design_qty !== '' && typeof ea_design_qty !== "undefined" && parseInt(ea_design_qty) === 0){
           if(qty !== '' && typeof qty !== "undefined" && parseInt(qty) > 0){
               $('#invaliderrorexceptdiv').html('');
           }else{
                $('#invaliderrorexceptdiv').html('BOQ Sr No '+boq_code+' Build Qty must be greater than 0!');
                $('#except_ea_qty').val('');        
            }
        }else{
            $('#invaliderrorexceptdiv').html('BOQ Sr No '+boq_code+' Build Qty must be greater than 0!');
            $('#except_ea_qty').val('');        
        }
    }
});    
$(document).on('click','.addBOQExceptionalData',function(){        
    var maintml = $(this);
    var project_id = document.getElementById("project_id").value;
    var boq_items_id = document.getElementById("except_boq_items_id").value;
    var boq_code = document.getElementById("except_boq_code").value;
    var hsn_sac_code = document.getElementById("except_hsn_sac_code").value;
    var item_description = document.getElementById("except_item_description").value;
    var unit = document.getElementById("except_unit").value;
    var qty = document.getElementById("except_ea_qty").value;
    var rate = document.getElementById("except_rate_basic").value;
    var gst = document.getElementById("except_gst").value;
    var scheduled_qty = document.getElementById("except_scheduled_qty").value;
    var o_design_qty = document.getElementById("except_o_design_qty").value;
    var design_qty = document.getElementById("except_design_qty").value;
    var non_schedule = document.getElementById("except_non_schedule").value;
    var ea_design_qty = document.getElementById("except_ea_design_qty").value;
    var taxable_amount = 0;
    if(parseInt(qty) > 0 && $.isNumeric(qty) && parseFloat(rate) > 0 && $.isNumeric(rate)){
        taxable_amount = parseFloat(rate) * parseInt(qty);
    }else if(parseInt(qty) < 0 && $.isNumeric(qty) && parseFloat(rate) > 0 && $.isNumeric(rate)){
        taxable_amount = parseFloat(rate) * parseInt(qty);
    }
    var gst_amount = 0;
    if(parseInt(taxable_amount) > 0 && $.isNumeric(taxable_amount)
    && parseFloat(gst) > 0 && $.isNumeric(gst)){
        gst_amount = parseFloat(taxable_amount) * (parseFloat(gst)/100);
    }
    
    if(project_id === '' || boq_code === '' || qty === '' || typeof qty === "undefined" 
    || parseInt(qty) === 0){
        $('.invaliderrorexcept').addClass('has-error-d');
    }else{
        
        var base_url = $('#base_url').val().trim();
        var exist_boq_code = '';
        exist_boq_code = function () {
        var tmp1 = null;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'dataType': 'json',
            'url': completeURL('get_approved_boq_item_details'),
            'data': { 'boq_code': boq_code, 'project_id': project_id},
            'success': function (result) {
                if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){
                    tmp1 = result.boq_code;
                }else{
                    tmp1 = 0;
                }
            }
        });
        return tmp1;
        }();
        
        if(exist_boq_code !== 0 && exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
            if(qty !== '' && typeof qty !== "undefined" && parseInt(qty) !== 0 && $.isNumeric(qty)){
                boq_code_no = [];
                $("input[name='boq_code[]']").each(function(){
                    boq_code_no.push($(this).val());
                });
                if ($.inArray(boq_code, boq_code_no) != -1){
                    $('#invaliderrorexceptdiv').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                    $('#except_boq_items_id').val('');
                    $('#except_boq_code').val('');
                    $('#except_item_description').val('');
                    $('#except_ea_qty').val('');
                    $('#except_hsn_sac_code').val('');
                    $('#except_unit').val('');
                    $('#except_rate_basic').val('');
                    $('#except_gst').val('');
                    $('#except_scheduled_qty').val('');
                    $('#except_o_design_qty').val('');
                    $('#except_design_qty').val('');
                    $('#except_non_schedule').val('');
                    $('#except_ea_design_qty').val('');
                    $("#except_or_design_qty").val('');
                }else{
                    var qtyres=0;
                    var qtymsg='';
                    if(ea_design_qty !== '' && typeof ea_design_qty !== "undefined" && parseInt(ea_design_qty) > 0){
                        var design_qty_chk = ea_design_qty;
                        if(qty !== '' && typeof qty !== "undefined" && parseInt(qty) < 0){
                            if(qty <= design_qty_chk){
                                qtyres = 1;
                            }else{
                                qtymsg = 'BOQ Sr No '+boq_code+' Build Qty must be greater than or equal to '+design_qty_chk+'!';
                            }
                        }else{
                            if(qty !== '' && typeof qty !== "undefined" && parseInt(qty) > 0){
                                qtyres = 1;
                            }else{
                                qtymsg = 'BOQ Sr No '+boq_code+' EA Qty must be greater than 0';    
                            }
                        }
                    }else{
                        if(ea_design_qty !== '' && typeof ea_design_qty !== "undefined" && parseInt(ea_design_qty) === 0){
                            if(qty !== '' && typeof qty !== "undefined" && parseInt(qty) > 0){
                               qtyres = 1;
                            }else{
                                qtymsg = 'BOQ Sr No '+boq_code+' Build Qty must be greater than 0';
                            }
                        }else{
                            qtymsg = 'BOQ Sr No '+boq_code+' Build Qty must be greater than 0';
                        }
                    }
                    if(qtyres == 1){
                        var html='<tr><td>'
                        +'<input type="hidden" name="boq_items_id[]" value="'+boq_items_id+'"><input type="text" class="form-control" name="boq_code[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%">'
                        +'<input type="hidden" class="form-control" name="hsn_sac_code[]" value="'+hsn_sac_code+'"></td>'
                        +'<td><input type="text" class="form-control" name="item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%">'
                        +'<input type="hidden" class="form-control" name="unit[]" value="'+unit+'"></td>'
                        +'<td><input type="text" class="form-control" name="scheduled_qty[]" value="'+scheduled_qty+'" readonly style="font-size: 12px;width:100%"></td>'
                        +'<td><input type="text" class="form-control" name="o_design_qty[]" value="'+design_qty+'" readonly style="font-size: 12px;width:100%"></td>'
                        +'<td><input type="text" class="form-control" name="ea_design_qty[]" value="'+ea_design_qty+'" readonly style="font-size: 12px;width:100%"></td>'
                        +'<td><input type="text" class="form-control" name="ea_qty[]" value="'+qty+'" readonly style="font-size: 12px;width:100%">'
                        +'<input type="hidden" name="design_qty[]" value="'+design_qty+'">'
                        +'<input type="hidden" name="rate_basic[]" value="'+rate+'">'
                        +'<input type="hidden" name="gst[]" value="'+gst+'">'
                        +'<input type="hidden" name="o_design_qty[]" value="'+o_design_qty+'">'
                        +'<input type="hidden" name="taxable_amount[]" value="'+taxable_amount+'">'
                        +'<input type="hidden" name="gst_amount[]" value="'+gst_amount+'">'
                        +'</td>'
                        +'<td><input type="text" class="form-control" name="non_schedule[]" value="'+non_schedule+'" readonly style="font-size: 12px;width:100%"></td>'
                        // +'<td><input type="number" min="1" class="form-control"  id="except_or_design_qty" placeholder="Design Qty" value="'+o_design_qty+'" style="font-size: 12px;width:100%;" readonly></td>'
                        +'<td>'
                        +'<div class="addDeleteButton">'
                        +'<span class="tooltips deleteBoqExceptnRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                        +'</div></td></tr>';
                        $('.invaliderrorexcept').removeClass('has-error-d');
                        $('#invaliderrorexceptdiv').html('');
                        $(maintml).parents('#displayBoqItems tbody').find("tr:last").before(html);
                        $(maintml).parents('#displayBoqItemsExist tbody').find("tr:last").before(html);
                            $('#except_boq_items_id').val('');
                            $('#except_boq_code').val('');
                            $('#except_item_description').val('');
                            $('#except_ea_qty').val('');
                            $('#except_hsn_sac_code').val('');
                            $('#except_unit').val('');
                            $('#except_rate_basic').val('');
                            $('#except_gst').val('');
                            $('#except_scheduled_qty').val('');
                            $('#except_o_design_qty').val('');
                            $('#except_design_qty').val('');
                            $('#except_non_schedule').val('');
                            $('#except_ea_design_qty').val('');
                             $('#except_or_design_qty').val('');
                            var total_taxable_amount = 0;
                            $("input[name='taxable_amount[]']").each(function() {
                                total_taxable_amount += parseFloat($(this).val());
                            });
                            $('#PO_taxable_amt').val(parseFloat(total_taxable_amount).toFixed(2));
                            
                            var total_gst_amount = 0;
                            $("input[name='gst_amount[]']").each(function() {
                                total_gst_amount += parseFloat($(this).val());
                            });
                            $('#gst_amount').val(parseFloat(total_gst_amount).toFixed(2));
                            var po_final_amount = 0;
                            po_final_amount = parseFloat(total_taxable_amount) + parseFloat(total_gst_amount);
                            $('#po_final_amount').val(parseFloat(po_final_amount).toFixed(2));
                        
                    }else{
                        $('#invaliderrorexceptdiv').html(qtymsg);
                    }
                }   
            }else{
                $('#invaliderrorexceptdiv').html('BOQ Sr No '+boq_code+' Out of Stock!');
            }
        }else{
            $('#invaliderrorexceptdiv').html('BOQ Sr No '+boq_code+' Pending for Approval!');
            $('#except_boq_items_id').val('');
            $('#except_boq_code').val('');
            $('#except_item_description').val('');
            $('#except_ea_qty').val('');
            $('#except_hsn_sac_code').val('');
            $('#except_unit').val('');
            $('#except_rate_basic').val('');
            $('#except_gst').val('');
            $('#except_scheduled_qty').val('');
            $('#except_o_design_qty').val('');
            $('#except_design_qty').val('');
            $('#except_non_schedule').val('');
            $('#except_ea_design_qty').val('');
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});

//Original Delivery Challan
$(document).on('click','.addDccWIRow',function(){        
    var maintml = $(this);
    var project_id = document.getElementById("project_id").value;
    var boq_items_id = document.getElementById("dcwi_boq_items_id").value;
    var boq_code = document.getElementById("dcwi_boq_code").value;
    var hsn_sac_code = document.getElementById("dcwi_hsn_sac_code").value;
    var item_description = document.getElementById("dcwi_item_description").value;
    var unit = document.getElementById("dcwi_unit").value;
    var qty = document.getElementById("dcwi_qty").value;
    var rate = document.getElementById("dcwi_rate").value;
    var total_rate = document.getElementById("dcwi_total_rate").value;
    var challan_id = $('#challan_id').val().trim();
    if(project_id === '' || boq_code === '' || hsn_sac_code === '' || item_description === '' || unit === '' || 
    qty < 0 || rate < 1){
        $('.invaliderrordcc').addClass('has-error-d');
    }else{
        var base_url = $('#base_url').val().trim();
        var dc_qty = 0;
        var exist_boq_code = '';
        var exist_dc_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            dc_qty = function () {
            var tmpdc = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.dc_stock !== '' && typeof result.dc_stock !== "undefined"){
                        tmpdc = result.dc_stock;
                    }else{
                        tmpdc = 0;
                    }
                }
            });
            return tmpdc;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
            exist_dc_boq_code = function () {
            var dc_exist_tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_dc_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    dc_exist_tmp1 = result.boq_status;
                }
            });
            return dc_exist_tmp1;
            }();
        }
        var allowed = 'N';
        if(exist_dc_boq_code !== '' && typeof exist_dc_boq_code !== "undefined"){
            if(exist_dc_boq_code === 'approved'){
                allowed = 'Y';
            }else{
                allowed = 'N';    
            }
        }else{
            allowed = 'Y';
        }
        if(challan_id !== '' && typeof challan_id !== "undefined"){
            challan_id = challan_id;
        }else{
            challan_id = 0;
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
            if(allowed !== '' && typeof allowed !== "undefined" && allowed === 'Y'){
            if(parseInt(dc_qty) > 0 && $.isNumeric(dc_qty)){
                if(parseInt(qty) <= parseInt(dc_qty)){
                    boq_code_no = [];
                    $("input[name='boq_code[]']").each(function(){
                            boq_code_no.push($(this).val());
                        });
                    if ($.inArray(boq_code, boq_code_no) != -1){
                            $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                            $('#dcwi_boq_code').val('');
                            $('#dcwi_hsn_sac_code').val('');
                            $('#dcwi_item_description').val('');
                            $('#dcwi_unit').val('');
                            $('#dcwi_qty').val('');
                            $('#dcwi_rate').val('');
                            $('#dcwi_total_rate').val('');
                            $('#dcwi_hsn_sac_code').prop('readonly', false);
                            $('#dcwi_item_description').prop('readonly', false);
                            $('#dcwi_unit').prop('readonly', false);
                    }else{
                        if(parseFloat(qty) > 0){
                                var html='<tr><td>'
                                +'<input type="hidden" name="boq_items_id[]" value="'+boq_items_id+'"><input type="text" class="form-control invaliderrordcc_'+boq_code+'" name="boq_code[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invaliderrordcc_'+boq_code+'" name="hsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invaliderrordcc_'+boq_code+'" name="item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invaliderrordcc_'+boq_code+'" name="unit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control checkqtyvalid invaliderrordcc_'+boq_code+' invalidqty_'+boq_code+'" data-id="'+boq_code+'" data-pid="'+project_id+'" data-cid="'+challan_id+'" name="qty[]" value="'+qty+'" style="font-size: 12px;width:100%">'
                                +'<input type="hidden" name="rate[]" value="'+rate+'">'
                                +'<input type="hidden" name="total_rate[]" value="'+total_rate+'"></td>'
                                +'<td>'
                                +'<div class="addDeleteButton">'
                                +'<span class="tooltips deleteDccWIRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                                +'</div></td></tr>';
                                $('.invaliderrordcc').removeClass('has-error-d');
                                $('#invaliderrordccid').html('');
                                $(maintml).parents('#displayDCCTable tbody').find("tr:last").before(html);
                                $(maintml).parents('#displayDCCTableExist tbody').find("tr:last").before(html);
                                $('#dcwi_boq_code').val('');
                                $('#dcwi_hsn_sac_code').val('');
                                $('#dcwi_item_description').val('');
                                $('#dcwi_unit').val('');
                                $('#dcwi_qty').val('');
                                $('#dcwi_rate').val('');
                                $('#dcwi_hsn_sac_code').prop('readonly', false);
                                $('#dcwi_item_description').prop('readonly', false);
                                $('#dcwi_unit').prop('readonly', false);
                                $('#dcwi_total_rate').val('');
                                var total = 0;
                                $("input[name='total_rate[]']").each(function() {
                                    total += parseFloat($(this).val());
                                });
                                $('#dcwi_sub_total').html(parseFloat(total).toFixed(2));
                        }else{
                            $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Invalid Qty!');
                        }
                    }   
                }else{
                    $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+dc_qty+' !');
                }
            }else{
                $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Out of Stock!');
            }
            }else{
                $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Pending for Approval!');
                $('#dcwi_boq_code').val('');
                $('#dcwi_hsn_sac_code').val('');
                $('#dcwi_item_description').val('');
                $('#dcwi_unit').val('');
                $('#dcwi_total_rate').val('');
                $('#dcwi_qty').val('');
                $('#dcwi_rate').val('');
                $('#dcwi_hsn_sac_code').prop('readonly', false);
                $('#dcwi_item_description').prop('readonly', false);
                $('#dcwi_unit').prop('readonly', false);
            }
        }else{
            $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Details Not Exist!');
            $('#dcwi_boq_code').val('');
            $('#dcwi_hsn_sac_code').val('');
            $('#dcwi_item_description').val('');
            $('#dcwi_unit').val('');
            $('#dcwi_total_rate').val('');
            $('#dcwi_qty').val('');
            $('#dcwi_rate').val('');
            $('#dcwi_hsn_sac_code').prop('readonly', false);
            $('#dcwi_item_description').prop('readonly', false);
            $('#dcwi_unit').prop('readonly', false);
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});
$(document).on('keyup', '#dcwi_rate', function() {
    var qty = $('#dcwi_qty').val().trim();
    var rate = $(this).val().trim();
    var total_rate = 0;
    if(qty !== '' && typeof qty !== "undefined" && parseFloat(qty) > 0
    && rate !== '' && typeof rate !== "undefined" && parseFloat(rate) > 0){
    total_rate = parseFloat(qty) * parseFloat(rate);     
    }
    $('#dcwi_total_rate').val(parseFloat(total_rate).toFixed(2));
    var total = 0;
    $("input[name='total_rate[]']").each(function() {
        total += parseFloat($(this).val());
    });
    $('#dcwi_sub_total').html(parseFloat(total).toFixed(2));
});
$(document).on('keyup','#dcwi_qty',function(){        
    var project_id = $('#project_id').val().trim();
    var boq_code = $('#dcwi_boq_code').val().trim();
    var qty = $(this).val().trim();
    var rate = $('#dcwi_rate').val().trim();
    // if(project_id === '' || boq_code === '' || qty < 1){
    if(project_id === '' || boq_code === '' || qty < 0.1){
        $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Qty must be greater than 0!');
    }else{
        var base_url = $('#base_url').val().trim();
        var dc_qty = 0;
        var exist_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            dc_qty = function () {
            var tmpdc = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.dc_stock !== '' && typeof result.dc_stock !== "undefined"){
                        tmpdc = result.dc_stock;
                    }else{
                        tmpdc = 0;
                    }
                }
            });
            return tmpdc;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
           if(dc_qty !== '' && typeof dc_qty !== "undefined" && parseInt(dc_qty) > 0){
                if(parseInt(qty) <= parseInt(dc_qty)){
                    $('#invaliderrordccid').html('');
                    var total_rate = 0;
                    if(qty !== '' && typeof qty !== "undefined" && parseFloat(qty) > 0
                    && rate !== '' && typeof rate !== "undefined" && parseFloat(rate) > 0){
                    total_rate = parseFloat(qty) * parseFloat(rate);     
                    }
                    $('#dcwi_total_rate').val(parseFloat(total_rate).toFixed(2));
                    var total = 0;
                    $("input[name='total_rate[]']").each(function() {
                        total += parseFloat($(this).val());
                    });
                    $('#dcwi_sub_total').html(parseFloat(total).toFixed(2));
                }else{
                    $(this).val('');      
                    $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+dc_qty+' !');
                }
            }else{
                $(this).val('');      
                $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Out of Stock!');
            }
        }else{
            $(this).val('');      
            $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Details Not Exist!');
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});
$(document).on('keyup','.checkqtyvalid',function(){        
    var maintml = $(this);
    var qty = $(this).val();
    var boq_code = $(this).attr('data-id');
    var project_id = $(this).attr('data-pid');
    var challan_id = $(this).attr('data-cid');
    if(project_id === '' || boq_code === '' || qty < 1){
        $('.invalidqty_'+boq_code).val('');      
        $('.invaliderrordcc_'+boq_code).addClass('has-error-d');
        $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Qty must be greater than 0!');
    }else{
        var base_url = $('#base_url').val().trim();
        var dc_qty = 0;
        var exist_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            dc_qty = function () {
            var tmpdc = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.dc_stock !== '' && typeof result.dc_stock !== "undefined"){
                        tmpdc = result.dc_stock;
                    }else{
                        tmpdc = 0;
                    }
                }
            });
            return tmpdc;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
           if(dc_qty !== '' && typeof dc_qty !== "undefined" && parseInt(dc_qty) > 0){
                if(parseInt(qty) <= parseInt(dc_qty)){
                    $('.invalidqty_'+boq_code).val(qty);  
                    $('.invaliderrordcc_'+boq_code).removeClass('has-error-d');
                    $('#invaliderrordccid').html('');
                }else{
                    $('.invalidqty_'+boq_code).val('');      
                    $('.invaliderrordcc_'+boq_code).addClass('has-error-d');
                    $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+dc_qty+' !');
                }
            }else{
                $('.invalidqty_'+boq_code).val('');      
                $('.invaliderrordcc_'+boq_code).addClass('has-error-d');
                $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Out of Stock!');
            }
        }else{
            $('.invalidqty_'+boq_code).val('');      
            $('.invaliderrordcc_'+boq_code).addClass('has-error-d');
            $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Details Not Exist!');
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});
$(document).on('keyup', '#dcwi_boq_code,#dcwi1_boq_code,#dcwi2_boq_code', function() {
    $('#invaliderrordccid').html('');
    $('#invaliderrordccid1').html('');
    $('#invaliderrordccid2').html('');
    var boq_code = $(this).val();
    var project_id = $('#project_id').val();
    var exist_qty = 0;
    var exist_boq_code = '';
    var exist_dc_boq_code = '';
    if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
        exist_qty = function () {
        var tmpdc = 0;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'dataType': 'json',
            'url': completeURL('get_stock_details'),
            'data': { 'boq_code': boq_code, 'project_id': project_id},
            'success': function (result) {
                    if(result.dc_stock !== '' && typeof result.dc_stock !== "undefined"){
                        tmpdc = result.dc_stock;
                    }else{
                        tmpdc = 0;
                    }
                }
            });
            return tmpdc;
            }();
        exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
        exist_dc_boq_code = function () {
            var dc_exist_tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_dc_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    dc_exist_tmp1 = result.boq_status;
                }
            });
            return dc_exist_tmp1;
            }();
    }
    var allowed = 'N';
    if(exist_dc_boq_code !== '' && typeof exist_dc_boq_code !== "undefined"){
        if(exist_dc_boq_code === 'approved'){
            allowed = 'Y';
        }else{
            allowed = 'N';    
        }
    }else{
        allowed = 'Y';
    }
    $.ajax({
            type:'POST',
            url:completeURL('get_approved_boq_item_details'), 
            dataType:'json',
            data:{project_id:project_id,boq_code:boq_code},
            success:function(result){
                if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){
                    if(allowed !== '' && typeof allowed !== "undefined" && allowed === 'Y'){
                    if(exist_qty !== '' && typeof exist_qty !== "undefined" && $.isNumeric(exist_qty) && parseInt(exist_qty) > 0){
                        $('#wdc_boq_items_id').val(result.boq_items_id);
                        $('#wdc_boq_code').val(result.boq_code);
                        $('#wdc_hsn_sac_code').val(result.hsn_sac_code);
                        $('#wdc_hsn_sac_code').prop('readonly', true);
                        $('#wdc_item_description').val(result.item_description);
                        $('#wdc_item_description').prop('readonly', true);
                        $('#wdc_unit').val(result.unit);
                        $('#wdc_unit').prop('readonly', true);
                        $('#wdc_avl_qty').val(exist_qty);
                        $('#wdc_avl_qty').prop('readonly', true);
                        
                        $('#dcwi_boq_items_id').val(result.boq_items_id);
                        $('#dcwi_boq_code').val(result.boq_code);    
                        $('#dcwi_hsn_sac_code').val(result.hsn_sac_code);     
                        $('#dcwi_hsn_sac_code').prop('readonly', true);
                        $('#dcwi_item_description').val(result.item_description);    
                        $('#dcwi_item_description').prop('readonly', true);
                        $('#dcwi_unit').val(result.unit);    
                        $('#dcwi_unit').prop('readonly', true);
                        $('#dcwi_qty').val(exist_qty);    
                        $('#dcwi_rate').val(result.rate_basic);   
                        $('#dcwi_gst').val(result.gst);   
                        
                        $('#dcwi1_boq_items_id').val(result.boq_items_id);
                        $('#dcwi1_boq_code').val(result.boq_code);    
                        $('#dcwi1_hsn_sac_code').val(result.hsn_sac_code);     
                        $('#dcwi1_hsn_sac_code').prop('readonly', true);
                        $('#dcwi1_item_description').val(result.item_description);    
                        $('#dcwi1_item_description').prop('readonly', true);
                        $('#dcwi1_unit').val(result.unit);    
                        $('#dcwi1_unit').prop('readonly', true);
                        $('#dcwi1_qty').val(exist_qty);    
                        $('#dcwi1_rate').val(result.rate_basic);   
                        $('#dcwi1_gst').val(result.gst);   
                        
                        $('#dcwi2_boq_items_id').val(result.boq_items_id);
                        $('#dcwi2_boq_code').val(result.boq_code);    
                        $('#dcwi2_hsn_sac_code').val(result.hsn_sac_code);     
                        $('#dcwi2_hsn_sac_code').prop('readonly', true);
                        $('#dcwi2_item_description').val(result.item_description);    
                        $('#dcwi2_item_description').prop('readonly', true);
                        $('#dcwi2_unit').val(result.unit);    
                        $('#dcwi2_unit').prop('readonly', true);
                        $('#dcwi2_qty').val(exist_qty);    
                        $('#dcwi2_rate').val(result.rate_basic);   
                        $('#dcwi2_gst').val(result.gst);  
                        var total_rate = 0;
                        if(exist_qty !== '' && typeof exist_qty !== "undefined" && parseFloat(exist_qty) > 0
                        && result.rate_basic !== '' && typeof result.rate_basic !== "undefined" && parseFloat(result.rate_basic) > 0){
                        total_rate = parseFloat(exist_qty) * parseFloat(result.rate_basic);     
                        }
                        $('#dcwi_total_rate').val(parseFloat(total_rate).toFixed(2));
                        $('#dcwi1_total_rate').val(parseFloat(total_rate).toFixed(2));
                        $('#dcwi2_total_rate').val(parseFloat(total_rate).toFixed(2));
                        
                        var total_rate_gst = 0;
                        var total_gst_amount = 0;
                        if(total_rate !== '' && typeof total_rate !== "undefined" && parseFloat(total_rate) > 0
                        && result.gst !== '' && typeof result.gst !== "undefined" && parseFloat(result.gst) > 0){
                        total_rate_gst = (parseFloat(total_rate) * (parseFloat(result.gst)/100)) + parseFloat(total_rate);     
                        total_gst_amount = parseFloat(total_rate) * (parseFloat(result.gst)/100);     
                        }
                        $('#dcwi_itotal_amount').val(parseFloat(total_rate_gst).toFixed(2));
                        $('#dcwi1_itotal_amount').val(parseFloat(total_rate_gst).toFixed(2));
                        $('#dcwi2_itotal_amount').val(parseFloat(total_rate_gst).toFixed(2));
                        $('#dcwi1_gst_amount').val(parseFloat(total_gst_amount).toFixed(2));
                        
                        var sgst=0;
                        var cgst=0;
                        if(result.gst !== '' && typeof result.gst !== "undefined" && parseFloat(result.gst) > 0){
                        sgst = result.gst/2;    
                        cgst = result.gst/2;    
                        }
                        var total_rate_sgst = 0;
                        var total_sgst_amount = 0;
                        if(total_rate !== '' && typeof total_rate !== "undefined" && parseFloat(total_rate) > 0
                        && result.gst !== '' && typeof result.gst !== "undefined" && parseFloat(result.gst) > 0){
                        total_rate_sgst = (parseFloat(total_rate) * ((parseFloat(result.gst)/100)/2)) + parseFloat(total_rate);     
                        total_sgst_amount = parseFloat(total_rate) * ((parseFloat(result.gst)/100)/2);     
                        }
                        var total_rate_cgst = 0;
                        var total_cgst_amount = 0;
                        if(total_rate !== '' && typeof total_rate !== "undefined" && parseFloat(total_rate) > 0
                        && result.gst !== '' && typeof result.gst !== "undefined" && parseFloat(result.gst) > 0){
                        total_rate_cgst = (parseFloat(total_rate) * ((parseFloat(result.gst)/100)/2)) + parseFloat(total_rate);     
                        total_cgst_amount = parseFloat(total_rate) * ((parseFloat(result.gst)/100)/2);     
                        }
                        $('#dcwi2_sgst').val(sgst);
                        $('#dcwi2_sgst_amount').val(total_sgst_amount);
                        $('#dcwi2_cgst').val(cgst);
                        $('#dcwi2_cgst_amount').val(total_cgst_amount);
                        $('#invaliderrordccid').html('');
                        $('#invaliderrordccid1').html('');
                        $('#invaliderrordccid2').html('');
                    }else{
                        $('#dcwi_boq_code').val('');    
                        $('#dcwi1_boq_code').val('');    
                        $('#dcwi2_boq_code').val('');    
                        
                        $('#wdc_boq_items_id').val('0');
                        $('#wdc_boq_code').val('');
                        $('#wdc_hsn_sac_code').val('');
                        $('#wdc_item_description').val('');
                        $('#wdc_unit').val('');
                        $('#wdc_avl_qty').val('');
                        $('#wdc_hsn_sac_code').prop('readonly', false);
                        $('#wdc_item_description').prop('readonly', false);
                        $('#wdc_unit').prop('readonly', false);
                        
                        $('#dcwi_boq_items_id').val('0');
                        $('#dcwi_hsn_sac_code').prop('readonly', false);
                        $('#dcwi_item_description').prop('readonly', false);
                        $('#dcwi_unit').prop('readonly', false);
                        $('#dcwi_rate').prop('readonly', false);
                        $('#dcwi_qty').prop('readonly', false);
                        $('#dcwi_hsn_sac_code').val(''); 
                        $('#dcwi_item_description').val('');
                        $('#dcwi_unit').val('');  
                        $('#dcwi_qty').val('');
                        $('#dcwi_rate').val('');  
                        $('#dcwi_total_rate').val('');
                        $('#dcwi_gst').val('');
                        $('#dcwi_itotal_amount').val('');
                    
                        $('#dcwi1_boq_items_id').val('0');
                        $('#dcwi1_hsn_sac_code').prop('readonly', false);
                        $('#dcwi1_item_description').prop('readonly', false);
                        $('#dcwi1_unit').prop('readonly', false);
                        $('#dcwi1_rate').prop('readonly', false);
                        $('#dcwi1_qty').prop('readonly', false);
                        $('#dcwi1_hsn_sac_code').val(''); 
                        $('#dcwi1_item_description').val('');
                        $('#dcwi1_unit').val('');  
                        $('#dcwi1_qty').val('');
                        $('#dcwi1_rate').val('');  
                        $('#dcwi1_total_rate').val('');
                        $('#dcwi1_gst').val('');
                        $('#dcwi1_itotal_amount').val('');
                        $('#dcwi1_gst_amount').val('');
                        
                        $('#dcwi2_boq_items_id').val('0');
                        $('#dcwi2_hsn_sac_code').prop('readonly', false);
                        $('#dcwi2_item_description').prop('readonly', false);
                        $('#dcwi2_unit').prop('readonly', false);
                        $('#dcwi2_rate').prop('readonly', false);
                        $('#dcwi2_qty').prop('readonly', false);
                        $('#dcwi2_hsn_sac_code').val(''); 
                        $('#dcwi2_item_description').val('');
                        $('#dcwi2_unit').val('');  
                        $('#dcwi2_qty').val('');
                        $('#dcwi2_rate').val('');  
                        $('#dcwi2_total_rate').val('');
                        $('#dcwi2_sgst').val('');
                        $('#dcwi2_sgst_amount').val('');
                        $('#dcwi2_cgst').val('');
                        $('#dcwi2_cgst_amount').val('');
                        $('#dcwi2_itotal_amount').val('');
                        $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Out of Stock!');
                        $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' Out of Stock!');
                        $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' Out of Stock!');
                    }
                    }else{
                        $('#dcwi_boq_code').val('');    
                        $('#dcwi1_boq_code').val('');    
                        $('#dcwi2_boq_code').val('');    
                        
                        $('#wdc_boq_items_id').val('0');
                        $('#wdc_boq_code').val('');
                        $('#wdc_hsn_sac_code').val('');
                        $('#wdc_item_description').val('');
                        $('#wdc_unit').val('');
                        $('#wdc_avl_qty').val('');
                        $('#wdc_hsn_sac_code').prop('readonly', false);
                        $('#wdc_item_description').prop('readonly', false);
                        $('#wdc_unit').prop('readonly', false);
                        
                        $('#dcwi_boq_items_id').val('0');
                        $('#dcwi_hsn_sac_code').prop('readonly', false);
                        $('#dcwi_item_description').prop('readonly', false);
                        $('#dcwi_unit').prop('readonly', false);
                        $('#dcwi_rate').prop('readonly', false);
                        $('#dcwi_qty').prop('readonly', false);
                        $('#dcwi_hsn_sac_code').val(''); 
                        $('#dcwi_item_description').val('');
                        $('#dcwi_unit').val('');  
                        $('#dcwi_qty').val('');
                        $('#dcwi_rate').val('');  
                        $('#dcwi_total_rate').val('');
                        $('#dcwi_gst').val('');
                        $('#dcwi_itotal_amount').val('');
                    
                        $('#dcwi1_boq_items_id').val('0');
                        $('#dcwi1_hsn_sac_code').prop('readonly', false);
                        $('#dcwi1_item_description').prop('readonly', false);
                        $('#dcwi1_unit').prop('readonly', false);
                        $('#dcwi1_rate').prop('readonly', false);
                        $('#dcwi1_qty').prop('readonly', false);
                        $('#dcwi1_hsn_sac_code').val(''); 
                        $('#dcwi1_item_description').val('');
                        $('#dcwi1_unit').val('');  
                        $('#dcwi1_qty').val('');
                        $('#dcwi1_rate').val('');  
                        $('#dcwi1_total_rate').val('');
                        $('#dcwi1_gst').val('');
                        $('#dcwi1_itotal_amount').val('');
                        $('#dcwi1_gst_amount').val('');
                        
                        $('#dcwi2_boq_items_id').val('0');
                        $('#dcwi2_hsn_sac_code').prop('readonly', false);
                        $('#dcwi2_item_description').prop('readonly', false);
                        $('#dcwi2_unit').prop('readonly', false);
                        $('#dcwi2_rate').prop('readonly', false);
                        $('#dcwi2_qty').prop('readonly', false);
                        $('#dcwi2_hsn_sac_code').val(''); 
                        $('#dcwi2_item_description').val('');
                        $('#dcwi2_unit').val('');  
                        $('#dcwi2_qty').val('');
                        $('#dcwi2_rate').val('');  
                        $('#dcwi2_total_rate').val('');
                        $('#dcwi2_sgst').val('');
                        $('#dcwi2_sgst_amount').val('');
                        $('#dcwi2_cgst').val('');
                        $('#dcwi2_cgst_amount').val('');
                        $('#dcwi2_itotal_amount').val('');
                        $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Pending for Approval!');
                        $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' Pending for Approval!');
                        $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' Pending for Approval!');
                    }
                }else{
                    // $('#dcwi_boq_code').val('');    
                    $('#dcwi1_boq_code').val('');    
                    $('#dcwi2_boq_code').val('');    
                    
                    $('#wdc_boq_items_id').val('0');
                    $('#wdc_boq_code').val('');
                    $('#wdc_hsn_sac_code').val('');
                    $('#wdc_item_description').val('');
                    $('#wdc_unit').val('');
                    $('#wdc_avl_qty').val('');
                    $('#wdc_hsn_sac_code').prop('readonly', false);
                    $('#wdc_item_description').prop('readonly', false);
                    $('#wdc_unit').prop('readonly', false);
                    
                    $('#dcwi_boq_items_id').val('0');
                    $('#dcwi_hsn_sac_code').prop('readonly', false);
                    $('#dcwi_item_description').prop('readonly', false);
                    $('#dcwi_unit').prop('readonly', false);
                    $('#dcwi_rate').prop('readonly', false);
                    $('#dcwi_qty').prop('readonly', false);
                    $('#dcwi_hsn_sac_code').val(''); 
                    $('#dcwi_item_description').val('');
                    $('#dcwi_unit').val('');  
                    $('#dcwi_qty').val('');
                    $('#dcwi_rate').val('');  
                    $('#dcwi_total_rate').val('');
                    $('#dcwi_gst').val('');
                    $('#dcwi_itotal_amount').val('');
                
                    $('#dcwi1_boq_items_id').val('0');
                    $('#dcwi1_hsn_sac_code').prop('readonly', false);
                    $('#dcwi1_item_description').prop('readonly', false);
                    $('#dcwi1_unit').prop('readonly', false);
                    $('#dcwi1_rate').prop('readonly', false);
                    $('#dcwi1_qty').prop('readonly', false);
                    $('#dcwi1_hsn_sac_code').val(''); 
                    $('#dcwi1_item_description').val('');
                    $('#dcwi1_unit').val('');  
                    $('#dcwi1_qty').val('');
                    $('#dcwi1_rate').val('');  
                    $('#dcwi1_total_rate').val('');
                    $('#dcwi1_gst').val('');
                    $('#dcwi1_itotal_amount').val('');
                    $('#dcwi1_gst_amount').val('');
                    
                    $('#dcwi2_boq_items_id').val('0');
                    $('#dcwi2_hsn_sac_code').prop('readonly', false);
                    $('#dcwi2_item_description').prop('readonly', false);
                    $('#dcwi2_unit').prop('readonly', false);
                    $('#dcwi2_rate').prop('readonly', false);
                    $('#dcwi2_qty').prop('readonly', false);
                    $('#dcwi2_hsn_sac_code').val(''); 
                    $('#dcwi2_item_description').val('');
                    $('#dcwi2_unit').val('');  
                    $('#dcwi2_qty').val('');
                    $('#dcwi2_rate').val('');  
                    $('#dcwi2_total_rate').val('');
                    $('#dcwi2_sgst').val('');
                    $('#dcwi2_sgst_amount').val('');
                    $('#dcwi2_cgst').val('');
                    $('#dcwi2_cgst_amount').val('');
                    $('#dcwi2_itotal_amount').val('');
                    $('#invaliderrordccid').html('BOQ Sr No '+boq_code+' Details Not Exist!');
                    $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' Details Not Exist!');
                    $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' Details Not Exist!');
                }        
            }
    });
});

//Intra State Delivery Challan
$(document).on('keyup','#dcwi2_qty',function(){        
    var project_id = $('#project_id').val().trim();
    var boq_code = $('#dcwi2_boq_code').val().trim();
    var qty = $(this).val().trim();
    var rate = $('#dcwi2_rate').val().trim();
    if(project_id === '' || boq_code === '' || qty < 1){
        $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' Qty must be greater than 0!');
    }else{
        var base_url = $('#base_url').val().trim();
        var dc_qty = 0;
        var exist_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            dc_qty = function () {
            var tmpdc = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.dc_stock !== '' && typeof result.dc_stock !== "undefined"){
                        tmpdc = result.dc_stock;
                    }else{
                        tmpdc = 0;
                    }
                }
            });
            return tmpdc;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
           if(dc_qty !== '' && typeof dc_qty !== "undefined" && parseInt(dc_qty) > 0){
                if(parseInt(qty) <= parseInt(dc_qty)){
                    $('#invaliderrordccid2').html('');
                    var total_rate = 0;
                    if(qty !== '' && typeof qty !== "undefined" && parseFloat(qty) > 0
                        && rate !== '' && typeof rate !== "undefined" && parseFloat(rate) > 0){
                        total_rate = parseFloat(qty) * parseFloat(rate);     
                    }
                    $('#dcwi2_total_rate').val(parseFloat(total_rate).toFixed(2));
                    var total = 0;
                    $("input[name='ctaxable_amount[]']").each(function() {
                        total += parseFloat($(this).val());
                    });
                    $('#dcwi_sub_total2').html(parseFloat(total).toFixed(2));
                }else{
                    $(this).val('');      
                    $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+dc_qty+' !');
                }
            }else{
                $(this).val('');      
                $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' Out of Stock!');
            }
        }else{
            $(this).val('');      
            $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' Details Not Exist!');
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});
$(document).on('click','.addDccTIRowIntra',function(){        
    var maintml = $(this);
    var project_id = document.getElementById("project_id").value;
    var boq_items_id = document.getElementById("dcwi2_boq_items_id").value;
    var boq_code = document.getElementById("dcwi2_boq_code").value;
    var hsn_sac_code = document.getElementById("dcwi2_hsn_sac_code").value;
    var item_description = document.getElementById("dcwi2_item_description").value;
    var unit = document.getElementById("dcwi2_unit").value;
    var qty = document.getElementById("dcwi2_qty").value;
    var rate = document.getElementById("dcwi2_rate").value;
    var itaxable_amount = document.getElementById("dcwi2_total_rate").value;
    var sgst = document.getElementById("dcwi2_sgst").value;
    var sgst_amount = document.getElementById("dcwi2_sgst_amount").value;
    var cgst = document.getElementById("dcwi2_cgst").value;
    var cgst_amount = document.getElementById("dcwi2_cgst_amount").value;
    var itotal_amount = document.getElementById("dcwi2_itotal_amount").value;
    if(project_id === '' || boq_code === '' || hsn_sac_code === '' || item_description === '' || unit === '' || 
    qty < 1 || rate < 1){
        $('.invaliderrordcc2').addClass('has-error-d');
    }else{
        var base_url = $('#base_url').val().trim();
        var exist_qty = 0;
        var exist_boq_code = '';
        var exist_dc_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            exist_qty = function () {
            var tmpdc = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                        if(result.dc_stock !== '' && typeof result.dc_stock !== "undefined"){
                            tmpdc = result.dc_stock;
                        }else{
                            tmpdc = 0;
                        }
                    }
                });
                return tmpdc;
                }();
            exist_boq_code = function () {
                var tmp1 = null;
                $.ajax({
                    'async': false,
                    'type': "POST",
                    'global': false,
                    'dataType': 'json',
                    'url': completeURL('get_approved_boq_item_details'),
                    'data': { 'boq_code': boq_code, 'project_id': project_id},
                    'success': function (result) {
                        tmp1 = result.boq_code;
                    }
                });
                return tmp1;
                }();
            exist_dc_boq_code = function () {
                var dc_exist_tmp1 = null;
                $.ajax({
                    'async': false,
                    'type': "POST",
                    'global': false,
                    'dataType': 'json',
                    'url': completeURL('get_dc_boq_item_details'),
                    'data': { 'boq_code': boq_code, 'project_id': project_id},
                    'success': function (result) {
                        dc_exist_tmp1 = result.boq_status;
                    }
                });
                return dc_exist_tmp1;
                }();
        }
        var allowed = 'N';
        if(exist_dc_boq_code !== '' && typeof exist_dc_boq_code !== "undefined"){
            if(exist_dc_boq_code === 'approved'){
                allowed = 'Y';
            }else{
                allowed = 'N';    
            }
        }else{
            allowed = 'Y';
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
            if(allowed !== '' && typeof allowed !== "undefined" && allowed === 'Y'){
                if(parseInt(qty) <= parseInt(exist_qty)){
                    boq_code_no = [];
                    $("input[name='cboq_code[]']").each(function(){
                            boq_code_no.push($(this).val());
                        });
                    if ($.inArray(boq_code, boq_code_no) != -1){
                            $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                            $('#dcwi2_boq_code').val('');
                            $('#dcwi2_hsn_sac_code').val('');
                            $('#dcwi2_item_description').val('');
                            $('#dcwi2_unit').val('');
                            $('#dcwi2_qty').val('');
                            $('#dcwi2_rate').val('');
                            $('#dcwi2_total_rate').val('');
                            $('#dcwi2_sgst').val('');
                            $('#dcwi2_sgst_amount').val('');
                            $('#dcwi2_cgst').val('');
                            $('#dcwi2_cgst_amount').val('');
                            $('#dcwi2_itotal_amount').val('');
                            $('#dcwi2_hsn_sac_code').prop('readonly', false);
                            $('#dcwi2_item_description').prop('readonly', false);
                            $('#dcwi2_unit').prop('readonly', false);
                    }else{
                        if(parseInt(qty) > 0){
                                var html='<tr><td>'
                                +'<input type="hidden" name="boq_items_id[]" value="'+boq_items_id+'"><input type="text" class="form-control invaliderrorintra_'+boq_code+'" name="cboq_code[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invaliderrorintra_'+boq_code+'" name="chsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invaliderrorintra_'+boq_code+'" name="citem_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invaliderrorintra_'+boq_code+'" name="cunit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control checkqtyvalidintra invalidintraqty_'+boq_code+' invaliderrorintra_'+boq_code+'" name="cqty[]" value="'+qty+'" data-id="'+boq_code+'"  data-pid="'+project_id+'" style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invaliderrorintra_'+boq_code+'" name="crate[]" value="'+rate+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invaliderrorintra_'+boq_code+'" name="ctaxable_amount[]" value="'+itaxable_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invaliderrorintra_'+boq_code+'" name="sgst[]" value="'+sgst+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invaliderrorintra_'+boq_code+'" name="sgst_amount[]" value="'+sgst_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invaliderrorintra_'+boq_code+'" name="cgst[]" value="'+cgst+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invaliderrorintra_'+boq_code+'" name="cgst_amount[]" value="'+cgst_amount+'" readonly style="font-size: 12px;width:100%">'
                                +'<input type="hidden" name="itotal_amount[]" value="'+itotal_amount+'"></td>'
                                +'<td>'
                                +'<div class="addDeleteButton">'
                                +'<span class="tooltips deleteDccITIRowIntra" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                                +'</div></td></tr>';
                                $('.invaliderrordcc2').removeClass('has-error-d');
                                $('#invaliderrordccid2').html('');
                                $(maintml).parents('#displayDCCInvccgstTable tbody').find("tr:last").before(html);
                                $(maintml).parents('#displayDCCInvccgstTableExist tbody').find("tr:last").before(html);
                                $('#dcwi2_boq_code').val('');
                                $('#dcwi2_hsn_sac_code').val('');
                                $('#dcwi2_item_description').val('');
                                $('#dcwi2_unit').val('');
                                $('#dcwi2_qty').val('');
                                $('#dcwi2_rate').val('');
                                $('#dcwi2_hsn_sac_code').prop('readonly', false);
                                $('#dcwi2_item_description').prop('readonly', false);
                                $('#dcwi2_unit').prop('readonly', false);
                                $('#dcwi2_total_rate').val('');
                                $('#dcwi2_sgst').val('');
                                $('#dcwi2_sgst_amount').val('');
                                $('#dcwi2_cgst').val('');
                                $('#dcwi2_cgst_amount').val('');
                                $('#dcwi2_itotal_amount').val('');
                                var total = 0;
                                $("input[name='ctaxable_amount[]']").each(function() {
                                    total += parseFloat($(this).val());
                                });
                                var total_sgst_amt = 0;
                                $("input[name='sgst_amount[]']").each(function() {
                                    total_sgst_amt += parseFloat($(this).val());
                                });
                                var total_cgst_amt = 0;
                                $("input[name='cgst_amount[]']").each(function() {
                                    total_cgst_amt += parseFloat($(this).val());
                                });
                                $('#dcwi_sub_total2').html(parseFloat(total).toFixed(2));
                                $('#dcwi2_cgst_total').html(parseFloat(total_cgst_amt).toFixed(2));
                                $('#dcwi2_sgst_total').html(parseFloat(total_sgst_amt).toFixed(2));
                                var dcwi_igst_final = 0;
                                dcwi_igst_final = parseFloat(total_sgst_amt) + parseFloat(total_cgst_amt) + parseFloat(total);
                                $('#dcwi_igst_final2').html(parseFloat(dcwi_igst_final).toFixed(2));
                        }else{
                            $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' Invalid Qty!');
                        }
                    }   
                }else{
                    $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' qty must be less than equal to '+exist_qty+' !');
                }
            }else{
                $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' Pending for Approval!');
                $('#dcwi2_boq_code').val('');
                $('#dcwi2_hsn_sac_code').val('');
                $('#dcwi2_item_description').val('');
                $('#dcwi2_unit').val('');
                $('#dcwi2_qty').val('');
                $('#dcwi2_rate').val('');
                $('#dcwi2_total_rate').val('');
                $('#dcwi2_sgst').val('');
                $('#dcwi2_sgst_amount').val('');
                $('#dcwi2_cgst').val('');
                $('#dcwi2_cgst_amount').val('');
                $('#dcwi2_itotal_amount').val('');
                $('#dcwi2_hsn_sac_code').prop('readonly', false);
                $('#dcwi2_item_description').prop('readonly', false);
                $('#dcwi2_unit').prop('readonly', false);
            } 
        }else{
            $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' Details Not Exist!');
            $('#dcwi2_boq_code').val('');
            $('#dcwi2_hsn_sac_code').val('');
            $('#dcwi2_item_description').val('');
            $('#dcwi2_unit').val('');
            $('#dcwi2_qty').val('');
            $('#dcwi2_rate').val('');
            $('#dcwi2_total_rate').val('');
            $('#dcwi2_sgst').val('');
            $('#dcwi2_sgst_amount').val('');
            $('#dcwi2_cgst').val('');
            $('#dcwi2_cgst_amount').val('');
            $('#dcwi2_itotal_amount').val('');
            $('#dcwi2_hsn_sac_code').prop('readonly', false);
            $('#dcwi2_item_description').prop('readonly', false);
            $('#dcwi2_unit').prop('readonly', false);
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});
$(document).on('keyup','.checkqtyvalidintra',function(){        
    var maintml = $(this);
    var qty = $(this).val();
    var boq_code = $(this).attr('data-id');
    var project_id = $(this).attr('data-pid');
    if(project_id === '' || boq_code === '' || qty < 1){
        $('.invalidintraqty_'+boq_code).val('');      
        $('.invaliderrorintra_'+boq_code).addClass('has-error-d');
        $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' Qty must be greater than 0!');
    }else{
        var base_url = $('#base_url').val().trim();
        var dc_qty = 0;
        var exist_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            dc_qty = function () {
            var tmpdc = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.dc_stock !== '' && typeof result.dc_stock !== "undefined"){
                        tmpdc = result.dc_stock;
                    }else{
                        tmpdc = 0;
                    }
                }
            });
            return tmpdc;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
            if(parseInt(dc_qty) > 0 && $.isNumeric(dc_qty)){
                if(parseInt(qty) <= parseInt(dc_qty)){
                    $('.invalidintraqty_'+boq_code).val(qty);  
                    $('.invaliderrorintra_'+boq_code).removeClass('has-error-d');
                    $('#invaliderrordccid2').html('');
                }else{
                    $('.invalidintraqty_'+boq_code).val('');      
                    $('.invaliderrorintra_'+boq_code).addClass('has-error-d');
                    $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+dc_qty+' !');
                }
            }else{
                $('.invalidintraqty_'+boq_code).val('');      
                $('.invaliderrorintra_'+boq_code).addClass('has-error-d');
                $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' Out of Stock!');
            }
        }else{
            $('.invalidintraqty_'+boq_code).val('');      
            $('.invaliderrorintra_'+boq_code).addClass('has-error-d');
            $('#invaliderrordccid2').html('BOQ Sr No '+boq_code+' Details Not Exist!');
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});
$(document).on('keyup', '#dcwi2_rate', function() {
    var qty = $('#dcwi2_qty').val().trim();
    var rate = $(this).val().trim();
    var total_rate = 0;
    if(qty !== '' && typeof qty !== "undefined" && parseFloat(qty) > 0
    && rate !== '' && typeof rate !== "undefined" && parseFloat(rate) > 0){
    total_rate = parseFloat(qty) * parseFloat(rate);     
    }
    $('#dcwi2_total_rate').val(parseFloat(total_rate).toFixed(2));
    var total = 0;
    $("input[name='ctaxable_amount[]']").each(function() {
        total += parseFloat($(this).val());
    });
    $('#dcwi_sub_total2').html(parseFloat(total).toFixed(2));
});

//Inter State Delivery Challan
$(document).on('keyup','#dcwi1_qty',function(){        
    var project_id = $('#project_id').val().trim();
    var boq_code = $('#dcwi1_boq_code').val().trim();
    var qty = $(this).val().trim();
    var rate = $('#dcwi2_rate').val().trim();
    if(project_id === '' || boq_code === '' || qty < 1){
        $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' Qty must be greater than 0!');
    }else{
        var base_url = $('#base_url').val().trim();
        var dc_qty = 0;
        var exist_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            dc_qty = function () {
            var tmpdc = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.dc_stock !== '' && typeof result.dc_stock !== "undefined"){
                        tmpdc = result.dc_stock;
                    }else{
                        tmpdc = 0;
                    }
                }
            });
            return tmpdc;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
           if(dc_qty !== '' && typeof dc_qty !== "undefined" && parseInt(dc_qty) > 0){
                if(parseInt(qty) <= parseInt(dc_qty)){
                    $('#invaliderrordccid1').html('');
                    var total_rate = 0;
                    if(qty !== '' && typeof qty !== "undefined" && parseFloat(qty) > 0
                        && rate !== '' && typeof rate !== "undefined" && parseFloat(rate) > 0){
                        total_rate = parseFloat(qty) * parseFloat(rate);     
                    }
                    $('#dcwi2_total_rate').val(parseFloat(total_rate).toFixed(2));
                    var total = 0;
                    $("input[name='ctaxable_amount[]']").each(function() {
                        total += parseFloat($(this).val());
                    });
                    $('#dcwi_sub_total2').html(parseFloat(total).toFixed(2));
                }else{
                    $(this).val('');      
                    $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+dc_qty+' !');
                }
            }else{
                $(this).val('');      
                $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' Out of Stock!');
            }
        }else{
            $(this).val('');      
            $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' Details Not Exist!');
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});
$(document).on('click','.addDccTIRow',function(){        
    var maintml = $(this);
    var project_id = document.getElementById("project_id").value;
    var boq_items_id = document.getElementById("dcwi1_boq_items_id").value;
    var boq_code = document.getElementById("dcwi1_boq_code").value;
    var hsn_sac_code = document.getElementById("dcwi1_hsn_sac_code").value;
    var item_description = document.getElementById("dcwi1_item_description").value;
    var unit = document.getElementById("dcwi1_unit").value;
    var qty = document.getElementById("dcwi1_qty").value;
    var rate = document.getElementById("dcwi1_rate").value;
    var itaxable_amount = document.getElementById("dcwi1_total_rate").value;
    var gst = document.getElementById("dcwi1_gst").value;
    var itotal_amount = document.getElementById("dcwi1_itotal_amount").value;
    var gst_amount = document.getElementById("dcwi1_gst_amount").value;
    if(project_id === '' || boq_code === '' || hsn_sac_code === '' || item_description === '' || unit === '' || 
    qty < 1 || rate < 1){
        $('.invaliderrordcc1').addClass('has-error-d');
    }else{
        var base_url = $('#base_url').val().trim();
        var exist_qty = 0;
        var exist_boq_code = '';
        var exist_dc_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            exist_qty = function () {
            var tmpdc = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                        if(result.dc_stock !== '' && typeof result.dc_stock !== "undefined"){
                            tmpdc = result.dc_stock;
                        }else{
                            tmpdc = 0;
                        }
                    }
                });
                return tmpdc;
                }();
            exist_boq_code = function () {
                var tmp1 = null;
                $.ajax({
                    'async': false,
                    'type': "POST",
                    'global': false,
                    'dataType': 'json',
                    'url': completeURL('get_approved_boq_item_details'),
                    'data': { 'boq_code': boq_code, 'project_id': project_id},
                    'success': function (result) {
                        tmp1 = result.boq_code;
                    }
                });
                return tmp1;
                }();
            exist_dc_boq_code = function () {
                var dc_exist_tmp1 = null;
                $.ajax({
                    'async': false,
                    'type': "POST",
                    'global': false,
                    'dataType': 'json',
                    'url': completeURL('get_dc_boq_item_details'),
                    'data': { 'boq_code': boq_code, 'project_id': project_id},
                    'success': function (result) {
                        dc_exist_tmp1 = result.boq_status;
                    }
                });
                return dc_exist_tmp1;
                }();
        }
        var allowed = 'N';
        if(exist_dc_boq_code !== '' && typeof exist_dc_boq_code !== "undefined"){
            if(exist_dc_boq_code === 'approved'){
                allowed = 'Y';
            }else{
                allowed = 'N';    
            }
        }else{
            allowed = 'Y';
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
            if(allowed !== '' && typeof allowed !== "undefined" && allowed === 'Y'){
            if(parseInt(qty) <= parseInt(exist_qty)){
                boq_code_no = [];
                $("input[name='iboq_code[]']").each(function(){
                        boq_code_no.push($(this).val());
                    });
                if ($.inArray(boq_code, boq_code_no) != -1){
                        $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                        $('#dcwi1_boq_code').val('');
                        $('#dcwi1_hsn_sac_code').val('');
                        $('#dcwi1_item_description').val('');
                        $('#dcwi1_unit').val('');
                        $('#dcwi1_qty').val('');
                        $('#dcwi1_rate').val('');
                        $('#dcwi1_total_rate').val('');
                        $('#dcwi1_gst').val('');
                        $('#dcwi1_itotal_amount').val('');
                        $('#dcwi1_gst_amount').val('');
                        $('#dcwi1_hsn_sac_code').prop('readonly', false);
                        $('#dcwi1_item_description').prop('readonly', false);
                        $('#dcwi1_unit').prop('readonly', false);
                }else{
                    if(parseInt(qty) > 0){
                            var html='<tr><td>'
                            +'<inpu type="hidden" name="boq_items_id[]" value="'+boq_items_id+'"><input type="text" class="form-control invaliderrorinter_'+boq_code+'" name="iboq_code[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control invaliderrorinter_'+boq_code+'" name="hsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control invaliderrorinter_'+boq_code+'" name="item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control invaliderrorinter_'+boq_code+'" name="unit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control checkqtyvalidinter invalidinterqty_'+boq_code+' invaliderrorinter_'+boq_code+'" name="qty[]" value="'+qty+'" data-id="'+boq_code+'" data-pid="'+project_id+'" style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control invaliderrorinter_'+boq_code+'" name="rate[]" value="'+rate+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control invaliderrorinter_'+boq_code+'" name="itaxable_amount[]" value="'+itaxable_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control invaliderrorinter_'+boq_code+'" name="gst[]" value="'+gst+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control invaliderrorinter_'+boq_code+'" name="itotal_amount[]" value="'+itotal_amount+'" readonly style="font-size: 12px;width:100%">'
                            +'<input type="hidden" class="form-control invaliderrorinter_'+boq_code+'" name="gst_amount[]" value="'+gst_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td>'
                            +'<div class="addDeleteButton">'
                            +'<span class="tooltips deleteDccITIRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                            +'</div></td></tr>';
                            $('.invaliderrordcc1').removeClass('has-error-d');
                            $('#invaliderrordccid1').html('');
                            $(maintml).parents('#displayDCCInvcTable tbody').find("tr:last").before(html);
                            $(maintml).parents('#displayDCCInvcTableExist tbody').find("tr:last").before(html);
                            $('#dcwi1_boq_code').val('');
                            $('#dcwi1_hsn_sac_code').val('');
                            $('#dcwi1_item_description').val('');
                            $('#dcwi1_unit').val('');
                            $('#dcwi1_qty').val('');
                            $('#dcwi1_rate').val('');
                            $('#dcwi1_hsn_sac_code').prop('readonly', false);
                            $('#dcwi1_item_description').prop('readonly', false);
                            $('#dcwi1_unit').prop('readonly', false);
                            $('#dcwi1_total_rate').val('');
                            $('#dcwi1_gst').val('');
                            $('#dcwi1_itotal_amount').val('');
                            $('#dcwi1_gst_amount').val('');
                            var total = 0;
                            $("input[name='itaxable_amount[]']").each(function() {
                                total += parseFloat($(this).val());
                            });
                            var total_gst_amt = 0;
                            $("input[name='gst_amount[]']").each(function() {
                                total_gst_amt += parseFloat($(this).val());
                            });
                            var dcwi_igst_final = 0;
                            dcwi_igst_final = parseFloat(total) + parseFloat(total_gst_amt);
                            $('#dcwi_sub_total1').html(parseFloat(total).toFixed(2));
                            $('#dcwi1_igst').html(parseFloat(total_gst_amt).toFixed(2));
                            $('#dcwi_igst_final').html(parseFloat(dcwi_igst_final).toFixed(2));
                    }else{
                        $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' Invalid Qty!');
                    }
                }   
            }else{
                $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' qty must be less than equal to '+exist_qty+' !');
            } 
            }else{
                $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' Pending for Approval!');
                $('#dcwi1_boq_code').val('');
                $('#dcwi1_hsn_sac_code').val('');
                $('#dcwi1_item_description').val('');
                $('#dcwi1_unit').val('');
                $('#dcwi1_qty').val('');
                $('#dcwi1_rate').val('');
                $('#dcwi1_total_rate').val('');
                $('#dcwi1_gst').val('');
                $('#dcwi1_itotal_amount').val('');
                $('#dcwi1_gst_amount').val('');
                $('#dcwi1_hsn_sac_code').prop('readonly', false);
                $('#dcwi1_item_description').prop('readonly', false);
                $('#dcwi1_unit').prop('readonly', false);
            }
        }else{
            $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' Details Not Exist!');
            $('#dcwi1_boq_code').val('');
            $('#dcwi1_hsn_sac_code').val('');
            $('#dcwi1_item_description').val('');
            $('#dcwi1_unit').val('');
            $('#dcwi1_qty').val('');
            $('#dcwi1_rate').val('');
            $('#dcwi1_total_rate').val('');
            $('#dcwi1_gst').val('');
            $('#dcwi1_itotal_amount').val('');
            $('#dcwi1_gst_amount').val('');
            $('#dcwi1_hsn_sac_code').prop('readonly', false);
            $('#dcwi1_item_description').prop('readonly', false);
            $('#dcwi1_unit').prop('readonly', false);
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});
$(document).on('keyup','.checkqtyvalidinter',function(){        
    var maintml = $(this);
    var qty = $(this).val();
    var boq_code = $(this).attr('data-id');
    var project_id = $(this).attr('data-pid');
    if(project_id === '' || boq_code === '' || qty < 1){
        $('.invalidinterqty_'+boq_code).val('');      
        $('.invaliderrorinter_'+boq_code).addClass('has-error-d');
        $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' Qty must be greater than 0!');
    }else{
        var base_url = $('#base_url').val().trim();
        var dc_qty = 0;
        var exist_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            dc_qty = function () {
            var tmpdc = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.dc_stock !== '' && typeof result.dc_stock !== "undefined"){
                        tmpdc = result.dc_stock;
                    }else{
                        tmpdc = 0;
                    }
                }
            });
            return tmpdc;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
            if(parseInt(dc_qty) > 0 && $.isNumeric(dc_qty)){
                if(parseInt(qty) <= parseInt(dc_qty)){
                    $('.invalidinterqty_'+boq_code).val(qty);  
                    $('.invaliderrorinter_'+boq_code).removeClass('has-error-d');
                    $('#invaliderrordccid1').html('');
                }else{
                    $('.invalidinterqty_'+boq_code).val('');      
                    $('.invaliderrorinter_'+boq_code).addClass('has-error-d');
                    $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+dc_qty+' !');
                }
            }else{
                $('.invalidinterqty_'+boq_code).val('');      
                $('.invaliderrorinter_'+boq_code).addClass('has-error-d');
                $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' Out of Stock!');
            }
        }else{
            $('.invalidinterqty_'+boq_code).val('');      
            $('.invaliderrorinter_'+boq_code).addClass('has-error-d');
            $('#invaliderrordccid1').html('BOQ Sr No '+boq_code+' Details Not Exist!');
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});

//Installed WIP
$(document).on('keyup', '#wdc_boq_code', function() {
    $('#invaliderrorid').html('');
    var wip_type = $('#wip_type').val();
    var boq_code = $(this).val();
    var project_id = $('#project_id').val();
    var url = 'get_approved_boq_item_details';
    var exist_dc_stock = 0;
    var exist_wip_boq_code = '';
    var provisional_stock = 0;
    var provisional_stock_chk = 'N';
    if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
        exist_dc_stock = function () {
        var tmp_dc_stock_qty = 0;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'dataType': 'json',
            'url': completeURL('get_stock_details'),
            'data': { 'boq_code': boq_code, 'project_id': project_id},
            'success': function (result) {
                if(result.dc_approved !== '' && typeof result.dc_approved !== "undefined"){
                    tmp_dc_stock_qty = result.dc_approved;
                }else{
                    tmp_dc_stock_qty = 0;
                }
            }
        });
        return tmp_dc_stock_qty;
        }();
        if(wip_type == 'installed'){
        provisional_stock_chk = 'Y';
        exist_wip_boq_code = function () {
        var tmp_iwip_status = 0;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'dataType': 'json',
            'url': completeURL('get_wip_boq_item'),
            'data': { 'boq_code': boq_code, 'project_id': project_id,wip_type:wip_type},
            'success': function (result) {
                tmp_iwip_status = result.boq_status;
            }
        });
        return tmp_iwip_status;
        }();
        provisional_stock = function () {
            var tmp_provisional = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.provisional !== '' && typeof result.provisional !== "undefined"){
                        tmp_provisional = result.provisional;
                    }else{
                        tmp_provisional = 0;
                    }
                }
            });
            return tmp_provisional;
            }();
        }else{
        exist_wip_boq_code = function () {
        var tmp_iwip_status = 0;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'dataType': 'json',
            'url': completeURL('get_wip_boq_item'),
            'data': { 'boq_code': boq_code, 'project_id': project_id,wip_type:wip_type},
            'success': function (result) {
                tmp_iwip_status = result.boq_status;
            }
        });
        return tmp_iwip_status;
        }();
        }
    }
    var allowed = 'N';
    if(exist_wip_boq_code !== '' && typeof exist_wip_boq_code !== "undefined"){
        if(exist_wip_boq_code === 'approved'){
            allowed = 'Y';
        }else{
            allowed = 'N';    
        }
    }else{
        allowed = 'Y';
    }
    $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:{project_id:project_id,boq_code:boq_code},
            success:function(result){
                if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){
                    if(allowed !== '' && typeof allowed !== "undefined" && allowed==='Y'){
                    if(exist_dc_stock !== '' && typeof exist_dc_stock !== "undefined" && parseFloat(exist_dc_stock) > 0){
                        $('#invaliderrorid').html('');
                        $('#wdc_boq_items_id').val(result.boq_items_id);
                        $('#wdc_boq_code').val(result.boq_code);
                        $('#wdc_hsn_sac_code').val(result.hsn_sac_code);
                        $('#wdc_hsn_sac_code').prop('readonly', true);
                        $('#wdc_item_description').val(result.item_description);
                        $('#wdc_item_description').prop('readonly', true);
                        $('#wdc_rate_basic').val(result.rate_basic);
                        $('#wdc_unit').val(result.unit);
                        $('#wdc_unit').prop('readonly', true);
                        $('#wdc_avl_qty').val(exist_dc_stock);
                        $('#wdc_avl_qty').prop('readonly', true);
                    }else{
                        if(provisional_stock_chk !== '' && typeof provisional_stock_chk !== "undefined" && provisional_stock_chk==='Y'){
                            if(provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
                                $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Out of Stock! '+provisional_stock+' Provisional Qty Available!');
                            }else{
                                $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Stock not Available!');
                            }
                        }else{
                            $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Stock not Available!');
                        }
                        $('#wdc_boq_code').val('');
                        $('#wdc_hsn_sac_code').val('');
                        $('#wdc_item_description').val('');
                        $('#wdc_unit').val('');
                        $('#wdc_avl_qty').val('');
                        $('#wdc_rate_basic').val('0');
                        $('#wdc_hsn_sac_code').prop('readonly', false);
                        $('#wdc_item_description').prop('readonly', false);
                        $('#wdc_unit').prop('readonly', false);
                    }
                    }else{
                        $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Pending for Approval!');
                        $('#wdc_boq_code').val('');
                        $('#wdc_hsn_sac_code').val('');
                        $('#wdc_item_description').val('');
                        $('#wdc_unit').val('');
                        $('#wdc_avl_qty').val('');
                        $('#wdc_rate_basic').val('0');
                        $('#wdc_hsn_sac_code').prop('readonly', false);
                        $('#wdc_item_description').prop('readonly', false);
                        $('#wdc_unit').prop('readonly', false);
                    }
                }else{
                    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Not Exist!');
                    $('#wdc_boq_code').val('');
                    $('#wdc_hsn_sac_code').val('');
                    $('#wdc_item_description').val('');
                    $('#wdc_unit').val('');
                    $('#wdc_avl_qty').val('');
                    $('#wdc_rate_basic').val('0');
                    $('#wdc_hsn_sac_code').prop('readonly', false);
                    $('#wdc_item_description').prop('readonly', false);
                    $('#wdc_unit').prop('readonly', false);
                }        
            }
    });
});
$(document).on('keyup','#wdc_installed_qty',function(){        
    var project_id = $('#project_id').val().trim();
    var boq_code = $('#wdc_boq_code').val().trim();
    var qty = $(this).val().trim();
    if(project_id === '' || boq_code === '' || qty < 0){
        $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Qty must be greater than 0!');
    }else{
        var base_url = $('#base_url').val().trim();
        var dc_qty = 0;
        var exist_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            dc_qty = function () {
            var tmpdc = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.dc_approved !== '' && typeof result.dc_approved !== "undefined"){
                        tmpdc = result.dc_approved;
                    }else{
                        tmpdc = 0;
                    }
                }
            });
            return tmpdc;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
           if(dc_qty !== '' && typeof dc_qty !== "undefined" && parseFloat(dc_qty) > 0){
                if(parseFloat(qty) <= parseFloat(dc_qty)){
                    $('#invaliderrorid').html('');
                }else{
                    $(this).val('');      
                    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+dc_qty+' !');
                }
            }else{
                $(this).val('');      
                $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Out of Stock!');
            }
        }else{
            $(this).val('');      
            $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Not Exist!');
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});
$(document).on('click','.addDCIWIPRow',function(){        
        var maintml = $(this);
        var project_id = document.getElementById("project_id").value;
        var boq_items_id = document.getElementById("wdc_boq_items_id").value;
        var boq_code = document.getElementById("wdc_boq_code").value;
        var hsn_sac_code = document.getElementById("wdc_hsn_sac_code").value;
        var item_description = document.getElementById("wdc_item_description").value;
        var unit = document.getElementById("wdc_unit").value;
        var avl_qty = document.getElementById("wdc_avl_qty").value;
        var installed_qty = document.getElementById("wdc_installed_qty").value;
        // console.log(installed_qty);
        var rate_basic = document.getElementById("wdc_rate_basic").value;
        if(boq_code == '' || hsn_sac_code == '' || item_description == '' || unit == '' ||  parseFloat(installed_qty) < 0 ||parseFloat(avl_qty) < 0 ){
        //   console.log("ok");
            $('.invaliderror').addClass('has-error-p');
        }else{
            var exist_dc_stock = 0;
            var exist_boq_code = '';
            var exist_dc_boq_code = '';
            var provisional_stock = 0;
            if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
                exist_dc_stock = function () {
                var tmpdc = 0;
                $.ajax({
                    'async': false,
                    'type': "POST",
                    'global': false,
                    'dataType': 'json',
                    'url': completeURL('get_stock_details'),
                    'data': { 'boq_code': boq_code, 'project_id': project_id},
                    'success': function (result) {
                        if(result.dc_approved !== '' && typeof result.dc_approved !== "undefined"){
                            tmpdc = result.dc_approved;
                        }else{
                            tmpdc = 0;
                        }
                    }
                });
                return tmpdc;
                }();
                exist_boq_code = function () {
                var tmp1 = null;
                $.ajax({
                    'async': false,
                    'type': "POST",
                    'global': false,
                    'dataType': 'json',
                    'url': completeURL('get_approved_boq_item_details'),
                    'data': { 'boq_code': boq_code, 'project_id': project_id},
                    'success': function (result) {
                        tmp1 = result.boq_code;
                    }
                });
                return tmp1;
                }();
                exist_dc_boq_code = function () {
                var tmp2 = null;
                $.ajax({
                    'async': false,
                    'type': "POST",
                    'global': false,
                    'dataType': 'json',
                    'url': completeURL('get_dc_boq_item_details'),
                    'data': { 'boq_code': boq_code, 'project_id': project_id},
                    'success': function (result) {
                        tmp2 = result.boq_code;
                    }
                });
                return tmp2;
                }();
                provisional_stock = function () {
                var tmp_provisional = 0;
                $.ajax({
                    'async': false,
                    'type': "POST",
                    'global': false,
                    'dataType': 'json',
                    'url': completeURL('get_stock_details'),
                    'data': { 'boq_code': boq_code, 'project_id': project_id},
                    'success': function (result) {
                        if(result.provisional !== '' && typeof result.provisional !== "undefined"){
                            tmp_provisional = result.provisional;
                        }else{
                            tmp_provisional = 0;
                        }
                    }
                });
                return tmp_provisional;
                }();
                
            }
            if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
                if(exist_dc_boq_code !== '' && typeof exist_dc_boq_code !== "undefined"){
                    if(installed_qty !== '' && typeof installed_qty !== "undefined" && parseFloat(installed_qty) > 0){
                        if(exist_dc_stock !== '' && typeof exist_dc_stock !== "undefined" && $.isNumeric(exist_dc_stock) && parseFloat(exist_dc_stock) > 0){
                            boq_code_no = [];
                            $("input[name='boq_code[]']").each(function(){
                                boq_code_no.push($(this).val());
                            });
                            if ($.inArray(boq_code, boq_code_no) != -1){
                                    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                                    $('#wdc_boq_code').val('');
                                    $('#wdc_hsn_sac_code').val('');
                                    $('#wdc_item_description').val('');
                                    $('#wdc_unit').val('');
                                    $('#wdc_avl_qty').val('');
                                    $('#wdc_installed_qty').val('');
                                    $('#wdc_hsn_sac_code').prop('readonly', false);
                                    $('#wdc_item_description').prop('readonly', false);
                                    $('#wdc_unit').prop('readonly', false);
                            }else{
                                    
                                    var html='<tr><td>'
                                    +'<inpu type="hidden" name="boq_items_id[]" value="'+boq_items_id+'"><input type="text" class="form-control update_invaliderror_'+boq_code+'" name="boq_code[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                    +'<td><input type="text" class="form-control update_invaliderror_'+boq_code+'" name="hsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                    +'<td><input type="text" class="form-control update_invaliderror_'+boq_code+'" name="item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
                                    +'<td><input type="text" class="form-control update_invaliderror_'+boq_code+'" name="unit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
                                    +'<td><input type="number" class="form-control update_invaliderror_'+boq_code+'" name="avl_qty[]" value="'+exist_dc_stock+'" readonly style="font-size: 12px;width:100%"></td>'
                                    +'<td><input type="number" class="form-control invalid_installed_qty_'+boq_code+' checkinstalledqty update_invaliderror_'+boq_code+'" name="installed_qty[]" value="'+installed_qty+'" data-id="'+boq_code+'" data-pid="'+project_id+'" style="font-size: 12px;width:100%"><input type="hidden" name="rate_basic[]" value="'+rate_basic+'"></td>'
                                    +'<td>'
                                    +'<div class="addDeleteButton">'
                                    +'<span class="tooltips deletedciwipRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                                    +'</div></td></tr>';
                                    $('.invaliderror').removeClass('has-error-p');
                                    $('#invaliderrorid').html('');
                                    $(maintml).parents('#clientdciwipitemdisplay tbody').find("tr:last").before(html);
                                    $(maintml).parents('#clientdciwipitemexistdisplay tbody').find("tr:last").before(html);
                                    $('#wdc_boq_code').val('');
                                    $('#wdc_hsn_sac_code').val('');
                                    $('#wdc_item_description').val('');
                                    $('#wdc_unit').val('');
                                    $('#wdc_avl_qty').val('');
                                    $('#wdc_installed_qty').val('');
                                    $('#wdc_hsn_sac_code').prop('readonly', false);
                                    $('#wdc_item_description').prop('readonly', false);
                                    $('#wdc_unit').prop('readonly', false);
                                }    
                        }else{ 
                            if($.isNumeric(provisional_stock) && parseFloat(provisional_stock) > 0){
                                $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Out of Stock! '+provisional_stock+' Provisional Qty Available!');
                            }else{
                                $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Out of Stock!');
                            }
                        }
                    }else{    
                        $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Invalid Qty!');
                    }
                }else{    
                    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Not Available in Client Delivery Challan!');
                    $('#wdc_boq_code').val('');
                    $('#wdc_hsn_sac_code').val('');
                    $('#wdc_item_description').val('');
                    $('#wdc_unit').val('');
                    $('#wdc_avl_qty').val('');
                    $('#wdc_installed_qty').val('');
                    $('#wdc_hsn_sac_code').prop('readonly', false);
                    $('#wdc_item_description').prop('readonly', false);
                    $('#wdc_unit').prop('readonly', false);
                }
            }else{    
                $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Not Exist!');
                $('#wdc_boq_code').val('');
                $('#wdc_hsn_sac_code').val('');
                $('#wdc_item_description').val('');
                $('#wdc_unit').val('');
                $('#wdc_avl_qty').val('');
                $('#wdc_installed_qty').val('');
                $('#wdc_hsn_sac_code').prop('readonly', false);
                $('#wdc_item_description').prop('readonly', false);
                $('#wdc_unit').prop('readonly', false);
            }
        }
        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                orientation: "right",
                autoclose: true,
            });
        } 
        Metronic.init();
    });
$(document).on('keyup','.checkinstalledqty',function(){        
    var maintml = $(this);
    var qty = $(this).val();
    var boq_code = $(this).attr('data-id');
    var project_id = $(this).attr('data-pid');
    if(project_id === '' || boq_code === '' || qty < 1){
        $('.invalid_installed_qty_'+boq_code).val('');      
        $('.update_invaliderror_'+boq_code).addClass('has-error-d');
        $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Qty must be greater than 0!');
    }else{
        var base_url = $('#base_url').val().trim();
        var dc_qty = 0;
        var provisional_stock = 0;
        var exist_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            dc_qty = function () {
            var tmpdc = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.dc_approved !== '' && typeof result.dc_approved !== "undefined"){
                        tmpdc = result.dc_approved;
                    }else{
                        tmpdc = 0;
                    }
                }
            });
            return tmpdc;
            }();
            provisional_stock = function () {
            var tmp_provisional = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.provisional !== '' && typeof result.provisional !== "undefined"){
                        tmp_provisional = result.provisional;
                    }else{
                        tmp_provisional = 0;
                    }
                }
            });
            return tmp_provisional;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
            if(parseInt(dc_qty) > 0 && $.isNumeric(dc_qty)){
                if(parseInt(qty) <= parseInt(dc_qty)){
                    $('.invalid_installed_qty_'+boq_code).val(qty);  
                    $('.update_invaliderror_'+boq_code).removeClass('has-error-d');
                    $('#invaliderrorid').html('');
                }else{
                    $('.invalid_installed_qty_'+boq_code).val('');      
                    $('.update_invaliderror_'+boq_code).addClass('has-error-d');
                    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+dc_qty+' !');
                }
            }else{
                if($.isNumeric(provisional_stock) && parseInt(provisional_stock) > 0){
                    $('.invalid_installed_qty_'+boq_code).val('');      
                    $('.update_invaliderror_'+boq_code).addClass('has-error-d');
                    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Out of Stock! '+provisional_stock+' Provisional Qty Available!');
                }else{
                    $('.invalid_installed_qty_'+boq_code).val('');      
                    $('.update_invaliderror_'+boq_code).addClass('has-error-d');
                    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Out of Stock!');
                }
            }
        }else{
            $('.invalid_installed_qty_'+boq_code).val('');      
            $('.update_invaliderror_'+boq_code).addClass('has-error-d');
            $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Not Exist!');
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});

//Provisional WIP
$(document).on('keyup','#wdc_prov_qty',function(){        
    var project_id = $('#project_id').val().trim();
    var boq_code = $('#wpdc_boq_code').val().trim();
    var qty = $(this).val().trim();
    if(project_id === '' || boq_code === '' || qty < 0.1){
        $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Qty must be greater than 0!');
    }else{
        var base_url = $('#base_url').val().trim();
        var provisional_stock = 0;
        var installed_stock = 0;
        var exist_boq_design_qty = 0;
        var exist_boq_code = '';
        var installed_exist_qty = 0;
        var provisional_exist_qty = 0;
        var provisional_stock_pending = 0;
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            provisional_stock = function () {
            var tmp_provisional = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.total_provisional !== '' && typeof result.total_provisional !== "undefined" && parseInt(result.total_provisional) > 0){
                        tmp_provisional = result.total_provisional;
                    }else{
                        tmp_provisional = 0;
                    }
                }
            });
            return tmp_provisional;
            }();
            installed_stock = function () {
            var tmp_installed = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.total_installed !== '' && typeof result.total_installed !== "undefined" && parseInt(result.total_installed) > 0){
                        tmp_installed = result.total_installed;
                    }else{
                        tmp_installed = 0;
                    }
                }
            });
            return tmp_installed;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
            exist_boq_design_qty = function () {
            var tmp_exist_boq_design_qty = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.design_qty !== '' && typeof result.design_qty !== "undefined" && parseInt(result.design_qty) > 0){
                        tmp_exist_boq_design_qty = result.design_qty;
                    }else{
                        tmp_exist_boq_design_qty = 0;
                    }
                }
            });
            return tmp_exist_boq_design_qty;
            }();
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
           if(exist_boq_design_qty !== '' && typeof exist_boq_design_qty !== "undefined" && parseInt(exist_boq_design_qty) > 0){
               if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseInt(installed_stock) > 0){
                    installed_exist_qty = parseInt(installed_stock);    
                }
                if(provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseInt(provisional_stock) > 0){
                    provisional_exist_qty = parseInt(provisional_stock);    
                }
                if(parseInt(exist_boq_design_qty) > (parseInt(installed_exist_qty) + parseInt(provisional_exist_qty))){ 
                    provisional_stock_pending = parseInt(exist_boq_design_qty) - (parseInt(installed_exist_qty) + parseInt(provisional_exist_qty));         
                }
                if(parseInt(qty) <= parseInt(provisional_stock_pending)){
                    $('#invaliderrorid').html('');
                }else{
                    $(this).val('');      
                    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+provisional_stock_pending+' !');
                }
            }else{
                $(this).val('');      
                $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Out of Stock!');
            }
        }else{
            $(this).val('');      
            $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Not Exist!');
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});
$(document).on('keyup','.checkprovisionalqty',function(){        
    var maintml = $(this);
    var qty = $(this).val();
    var boq_code = $(this).attr('data-id');
    var project_id = $(this).attr('data-pid');
    if(project_id === '' || boq_code === '' || qty < 1){
        $('.invalid_installed_qty_'+boq_code).val('');      
        $('.update_invaliderror_'+boq_code).addClass('has-error-d');
        $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Qty must be greater than 0!');
    }else{
        var base_url = $('#base_url').val().trim();
        var provisional_stock = 0;
        var installed_stock = 0;
        var exist_boq_design_qty = 0;
        var exist_boq_code = '';
        var installed_exist_qty = 0;
        var provisional_exist_qty = 0;
        var provisional_stock_pending = 0;
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            provisional_stock = function () {
            var tmp_provisional = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.total_provisional !== '' && typeof result.total_provisional !== "undefined" && parseInt(result.total_provisional) > 0){
                        tmp_provisional = result.total_provisional;
                    }else{
                        tmp_provisional = 0;
                    }
                }
            });
            return tmp_provisional;
            }();
            installed_stock = function () {
            var tmp_installed = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.total_installed !== '' && typeof result.total_installed !== "undefined" && parseInt(result.total_installed) > 0){
                        tmp_installed = result.total_installed;
                    }else{
                        tmp_installed = 0;
                    }
                }
            });
            return tmp_installed;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
            exist_boq_design_qty = function () {
            var tmp_exist_boq_design_qty = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.design_qty !== '' && typeof result.design_qty !== "undefined" && parseInt(result.design_qty) > 0){
                        tmp_exist_boq_design_qty = result.design_qty;
                    }else{
                        tmp_exist_boq_design_qty = 0;
                    }
                }
            });
            return tmp_exist_boq_design_qty;
            }();
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
            if(exist_boq_design_qty !== '' && typeof exist_boq_design_qty !== "undefined" && parseInt(exist_boq_design_qty) > 0){
                if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseInt(installed_stock) > 0){
                    installed_exist_qty = parseInt(installed_stock);    
                }
                if(provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseInt(provisional_stock) > 0){
                    provisional_exist_qty = parseInt(provisional_stock);    
                }
                if(parseInt(exist_boq_design_qty) > (parseInt(installed_exist_qty) + parseInt(provisional_exist_qty))){ 
                    provisional_stock_pending = parseInt(exist_boq_design_qty) - (parseInt(installed_exist_qty) + parseInt(provisional_exist_qty));         
                }
                if(parseInt(provisional_stock_pending) >= parseInt(qty)){
                    $('.invalid_installed_qty_'+boq_code).val(qty);  
                    $('.update_invaliderror_'+boq_code).removeClass('has-error-d');
                    $('#invaliderrorid').html('');
                }else{
                    $('.invalid_installed_qty_'+boq_code).val('');      
                    $('.update_invaliderror_'+boq_code).addClass('has-error-d');
                    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+provisional_stock_pending+' !');
                }
            }else{
                $('.invalid_installed_qty_'+boq_code).val('');      
                $('.update_invaliderror_'+boq_code).addClass('has-error-d');
                $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Out of Stock!');
            }
        }else{
            $('.invalid_installed_qty_'+boq_code).val('');      
            $('.update_invaliderror_'+boq_code).addClass('has-error-d');
            $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Not Exist!');
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});
$(document).on('keyup', '#wpdc_boq_code', function() {
    $('#invaliderrorid').html('');
    var wip_type = $('#wip_type').val();
    var boq_code = $(this).val();
    var project_id = $('#project_id').val();
    var url = 'get_approved_boq_item_details';
    var exist_wip_boq_code = '';
    var provisional_stock = 0;
    var installed_stock = 0;
    if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
        exist_wip_boq_code = function () {
        var tmp_iwip_status = 0;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'dataType': 'json',
            'url': completeURL('get_wip_boq_item'),
            'data': { 'boq_code': boq_code, 'project_id': project_id,wip_type:wip_type},
            'success': function (result) {
                tmp_iwip_status = result.boq_status;
            }
        });
        return tmp_iwip_status;
        }();
        provisional_stock = function () {
            var tmp_provisional = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.total_provisional !== '' && typeof result.total_provisional !== "undefined" && parseInt(result.total_provisional) > 0){
                        tmp_provisional = result.total_provisional;
                    }else{
                        tmp_provisional = 0;
                    }
                }
            });
            return tmp_provisional;
            }();
        installed_stock = function () {
            var tmp_installed = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.total_installed !== '' && typeof result.total_installed !== "undefined" && parseInt(result.total_installed) > 0){
                        tmp_installed = result.total_installed;
                    }else{
                        tmp_installed = 0;
                    }
                }
            });
            return tmp_installed;
            }();
    }
    // check Provisional BOQ Item Approved
    var allowed = 'N';
    if(exist_wip_boq_code !== '' && typeof exist_wip_boq_code !== "undefined"){
        if(exist_wip_boq_code === 'approved'){
            allowed = 'Y';
        }else{
            allowed = 'N';    
        }
    }else{
        allowed = 'Y';
    }
    var installed_exist_qty = 0;
    var provisional_exist_qty = 0;
    var provisional_stock_pending = 0; 
    $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:{project_id:project_id,boq_code:boq_code},
            success:function(result){
                if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){
                    if(allowed !== '' && typeof allowed !== "undefined" && allowed==='Y'){
                        if(result.design_qty !== '' && typeof result.design_qty !== "undefined" && parseInt(result.design_qty) > 0){
                            if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseInt(installed_stock) > 0){
                                installed_exist_qty = parseInt(installed_stock);    
                            }
                            if(provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseInt(provisional_stock) > 0){
                                provisional_exist_qty = parseInt(provisional_stock);    
                            }
                            if(parseInt(result.design_qty) > (parseInt(installed_exist_qty) + parseInt(provisional_exist_qty))){ 
                                provisional_stock_pending = parseInt(result.design_qty) - (parseInt(installed_exist_qty) + parseInt(provisional_exist_qty));         
                            }
                        }
                    if(provisional_stock_pending !== '' && typeof provisional_stock_pending !== "undefined" && parseInt(provisional_stock_pending) > 0){
                        $('#invaliderrorid').html('');
                        $('#wdc_boq_items_id').val(result.boq_items_id);
                        $('#wpdc_boq_code').val(result.boq_code);
                        $('#wdc_hsn_sac_code').val(result.hsn_sac_code);
                        $('#wdc_hsn_sac_code').prop('readonly', true);
                        $('#wdc_item_description').val(result.item_description);
                        $('#wdc_item_description').prop('readonly', true);
                        $('#wdc_rate_basic').val(result.rate_basic);
                        $('#wdc_unit').val(result.unit);
                        $('#wdc_unit').prop('readonly', true);
                        $('#wdc_avl_qty').val(provisional_stock_pending);
                        $('#wdc_avl_qty').prop('readonly', true);
                    }else{
                        $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Stock not Available!');
                        $('#wpdc_boq_code').val('');
                        $('#wdc_hsn_sac_code').val('');
                        $('#wdc_item_description').val('');
                        $('#wdc_unit').val('');
                        $('#wdc_avl_qty').val('');
                        $('#wdc_rate_basic').val('0');
                        $('#wdc_hsn_sac_code').prop('readonly', false);
                        $('#wdc_item_description').prop('readonly', false);
                        $('#wdc_unit').prop('readonly', false);
                    }
                    }else{
                        $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Pending for Approval!');
                        $('#wpdc_boq_code').val('');
                        $('#wdc_hsn_sac_code').val('');
                        $('#wdc_item_description').val('');
                        $('#wdc_unit').val('');
                        $('#wdc_avl_qty').val('');
                        $('#wdc_rate_basic').val('0');
                        $('#wdc_hsn_sac_code').prop('readonly', false);
                        $('#wdc_item_description').prop('readonly', false);
                        $('#wdc_unit').prop('readonly', false);
                    }
                }else{
                    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Not Exist!');
                    $('#wpdc_boq_code').val('');
                    $('#wdc_hsn_sac_code').val('');
                    $('#wdc_item_description').val('');
                    $('#wdc_unit').val('');
                    $('#wdc_avl_qty').val('');
                    $('#wdc_rate_basic').val('0');
                    $('#wdc_hsn_sac_code').prop('readonly', false);
                    $('#wdc_item_description').prop('readonly', false);
                    $('#wdc_unit').prop('readonly', false);
                }        
            }
    });
});
$(document).on('click','.addDCPWIPRow',function(){        
        var maintml = $(this);
        var project_id = document.getElementById("project_id").value;
        var boq_code = document.getElementById("wpdc_boq_code").value;
        var hsn_sac_code = document.getElementById("wdc_hsn_sac_code").value;
        var item_description = document.getElementById("wdc_item_description").value;
        var unit = document.getElementById("wdc_unit").value;
        var avl_qty = document.getElementById("wdc_avl_qty").value;
        var prov_qty = document.getElementById("wdc_prov_qty").value;
        var rate_basic = document.getElementById("wdc_rate_basic").value;
        if(boq_code == '' || hsn_sac_code == '' || item_description == '' || unit == '' || parseFloat(avl_qty) < 0.1 || parseFloat(prov_qty) < 0.1){
            $('.invaliderror').addClass('has-error-p');
        }else{
            var exist_boq_code = '';
            if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
                exist_boq_code = function () {
                var tmp1 = null;
                $.ajax({
                    'async': false,
                    'type': "POST",
                    'global': false,
                    'dataType': 'json',
                    'url': completeURL('get_approved_boq_item_details'),
                    'data': { 'boq_code': boq_code, 'project_id': project_id},
                    'success': function (result) {
                        tmp1 = result.boq_code;
                    }
                });
                return tmp1;
                }();
            }
            if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
                if(avl_qty !== '' && typeof avl_qty !== "undefined" && prov_qty !== '' && typeof prov_qty !== "undefined" 
                && parseFloat(avl_qty) >= parseFloat(prov_qty)){
                        if(avl_qty !== '' && typeof avl_qty !== "undefined" && avl_qty > 0){
                                boq_code_no = [];
                                $("input[name='boq_code[]']").each(function(){
                                    boq_code_no.push($(this).val());
                                });
                                if ($.inArray(boq_code, boq_code_no) != -1){
                                    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                                    $('#wpdc_boq_code').val('');
                                    $('#wdc_hsn_sac_code').val('');
                                    $('#wdc_item_description').val('');
                                    $('#wdc_unit').val('');
                                    $('#wdc_avl_qty').val('');
                                    $('#wdc_installed_qty').val('');
                                    $('#wdc_hsn_sac_code').prop('readonly', false);
                                    $('#wdc_item_description').prop('readonly', false);
                                    $('#wdc_unit').prop('readonly', false);
                                }else{
                                    var html='<tr><td>'
                                    +'<input type="text" class="form-control update_invaliderror_'+boq_code+'" name="boq_code[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                    +'<td><input type="text" class="form-control update_invaliderror_'+boq_code+'" name="hsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                    +'<td><input type="text" class="form-control update_invaliderror_'+boq_code+'" name="item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
                                    +'<td><input type="text" class="form-control update_invaliderror_'+boq_code+'" name="unit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
                                    +'<td><input type="number" class="form-control update_invaliderror_'+boq_code+'" name="avl_qty[]" value="'+avl_qty+'" readonly style="font-size: 12px;width:100%"></td>'
                                    +'<td><input type="number" class="form-control checkprovisionalqty invalid_installed_qty_'+boq_code+' update_invaliderror_'+boq_code+'" name="prov_qty[]" value="'+prov_qty+'" data-id="'+boq_code+'" data-pid="'+project_id+'"  style="font-size: 12px;width:100%"><input type="hidden" name="rate_basic[]" value="'+rate_basic+'"></td>'
                                    +'<td>'
                                    +'<div class="addDeleteButton">'
                                    +'<span class="tooltips deletedcpwipRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                                    +'</div></td></tr>';
                                    $('.invaliderror').removeClass('has-error-p');
                                    $('#invaliderrorid').html('');
                                    $(maintml).parents('#clientdcpwipitemdisplay tbody').find("tr:last").before(html);
                                    $(maintml).parents('#clientdcpwipitemexistdisplay tbody').find("tr:last").before(html);
                                    $('#wpdc_boq_code').val('');
                                    $('#wdc_hsn_sac_code').val('');
                                    $('#wdc_item_description').val('');
                                    $('#wdc_unit').val('');
                                    $('#wdc_avl_qty').val('');
                                    $('#wdc_prov_qty').val('');
                                    $('#wdc_hsn_sac_code').prop('readonly', false);
                                    $('#wdc_item_description').prop('readonly', false);
                                    $('#wdc_unit').prop('readonly', false);
                                }
                        }else{
                            $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Out of Stock!');
                        }
                }else{    
                    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Provisional Qty must be less than or equal to Stock Qty '+avl_qty+' !');
                }
            }else{    
                $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Not Exist!');
                $('#wpdc_boq_code').val('');
                $('#wdc_hsn_sac_code').val('');
                $('#wdc_item_description').val('');
                $('#wdc_unit').val('');
                $('#wdc_avl_qty').val('');
                $('#wdc_prov_qty').val('');
                $('#wdc_hsn_sac_code').prop('readonly', false);
                $('#wdc_item_description').prop('readonly', false);
                $('#wdc_unit').prop('readonly', false);
            }
        }
        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                orientation: "right",
                autoclose: true,
            });
        } 
        Metronic.init();
    });


    function calculatedBillSplit(rate_basic, final_qty) {
        if($("#billing_split_up_container").is(':visible')) {
            var billing_split_up = $("#billing_split_up").val();
        } else {
            var billing_split_up = '';
        }

        if(billing_split_up == 'supply') {
            var supply_per = $("#billing_split_supply").val();
            var supply_per_amount = parseFloat(rate_basic) * parseFloat(supply_per) / 100;
            var amount = parseFloat(final_qty) * parseFloat(supply_per_amount);
            proforma_itaxable_amount = parseFloat(amount).toFixed(2);
        } else if (billing_split_up == 'installation') {
            var installation_per = $("#billing_split_installation").val();
            installation_per_amount = parseFloat(rate_basic) * parseFloat(installation_per) / 100;
            var amount = parseFloat(final_qty) * parseFloat(installation_per_amount);
            proforma_itaxable_amount = parseFloat(amount).toFixed(2);
        } else if (billing_split_up == 'testing_commissioning') {
            var test_comminss_per = $("#billing_split_test_comminss").val();
            var test_comminss_per_amount = parseFloat(rate_basic) * parseFloat(test_comminss_per) / 100;
            var amount = parseFloat(final_qty) * parseFloat(test_comminss_per_amount);
            proforma_itaxable_amount = parseFloat(amount).toFixed(2);
        } else if (billing_split_up == 'handover') {
            var handover_per = $("#billing_split_handover").val();
            var handover_per_amount = parseFloat(rate_basic) * parseFloat(handover_per) / 100;
            var amount = parseFloat(final_qty) * parseFloat(handover_per_amount);
            proforma_itaxable_amount = parseFloat(amount).toFixed(2);
        } else {
            var amount = parseFloat(final_qty) * parseFloat(rate_basic);
            proforma_itaxable_amount = parseFloat(amount).toFixed(2);;
        }
        return proforma_itaxable_amount
    }

//Proforma Invoice
$(document).on('keyup', '#proforma_boq_code,#proforma_boq_code1', function() {
    $('#invaliderrorprod').html('');
    $('#invaliderrorprod1').html('');
    var boq_code = $(this).val();
    var project_id = $('#project_id').val();
    var gst_type = $('#gst_type').val();
    var installed_stock = 0;
    var provisional_stock = 0;
    var exist_proforma_boq_code = '';
    
    
    // if($("#billing_split_up_container").is(":visible")) {
    //     var billing_split_up = $("#billing_split_up").val();
    // } 
    
    var dc_qty_minus = 0;
    if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
        // alert("ok")
        installed_stock = function () {
            var tmpinstalled = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.installed !== '' && typeof result.installed !== "undefined"){
                        tmpinstalled = result.installed;
                    }else{
                        tmpinstalled = 0;
                    }
                }
            });
            return tmpinstalled;
            }();
        provisional_stock = function () {
            var tmp_provisional = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.provisional !== '' && typeof result.provisional !== "undefined"){
                        tmp_provisional = result.provisional;
                    }else{
                        tmp_provisional = 0;
                    }
                    dc_qty_minus = result.dc_stock;
                }
            });
            return tmp_provisional;
            }();
        exist_proforma_boq_code = function () {
            var tmp_proforma = '';
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_proforma_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp_proforma = result.boq_status;
                    
                }
            });
            return tmp_proforma;
            }();
    }
    var allowed = 'N';
    if(exist_proforma_boq_code !== '' && typeof exist_proforma_boq_code !== "undefined"){
        if(exist_proforma_boq_code === 'approved'){
            allowed = 'Y';
        }else{
            allowed = 'N';    
        }
    }else{
        allowed = 'Y';
    }
    var final_qty=0;
    if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
    && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
        final_qty = parseFloat(installed_stock) + parseFloat(provisional_stock); 
    }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) === 0
    && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
        final_qty = parseFloat(provisional_stock); 
    }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
    && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) === 0){
        final_qty = parseFloat(installed_stock); 
    }
    console.log(final_qty,dc_qty_minus)
    var parent_form  = $(this).parents("#save_proforma_invoice_details");
    var type = "other";
    if(parent_form.length > 0){
        // final_qty = final_qty - dc_qty_minus;
    }
    $.ajax({
        type:'POST',
        url:completeURL('get_approved_boq_item_details'), 
        dataType:'json',
        data:{project_id:project_id,boq_code:boq_code},
        success:function(result){
            // alert(result);
            // console.log(result);
            if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){
                if(allowed !== '' && typeof allowed !== "undefined" && allowed === 'Y'){
                    if(final_qty !== '' && typeof final_qty !== "undefined" && parseFloat(final_qty) > 0){
                        $('#proforma_boq_code').val(result.boq_code);    
                        $('#proforma_hsn_sac_code').val(result.hsn_sac_code);    
                        $('#proforma_hsn_sac_code').prop('readonly', true);
                        $('#proforma_item_description').val(result.item_description);
                        $('#proforma_item_description').prop('readonly', true);
                        $('#proforma_unit').val(result.unit);    
                        $('#proforma_unit').prop('readonly', true);
                        $('#proforma_qty').val(final_qty); 
                           
                        $('#proforma_rate').val(result.rate_basic);  
                        
                        var proforma_itaxable_amount = 0;
                        if(final_qty !== '' && typeof final_qty !== "undefined" && parseFloat(final_qty) > 0
                        && result.rate_basic !== '' && typeof result.rate_basic !== "undefined" && parseFloat(result.rate_basic) > 0){
                            proforma_itaxable_amount = calculatedBillSplit(result.rate_basic,final_qty);
                        }
                        $('#proforma_itaxable_amount').val(proforma_itaxable_amount);
                        
                        var proforma_gst = 0;
                        var proforma_itotal_amt = 0;
                        var proforma_gst_amt = 0;
                        if(proforma_itaxable_amount !== '' && typeof proforma_itaxable_amount !== "undefined" && parseFloat(proforma_itaxable_amount) > 0 && 
                        result.gst !== '' && typeof result.gst !== "undefined" && parseFloat(result.gst) > 0){
                            proforma_gst = parseFloat(result.gst);
                            proforma_itotal_amt = (parseFloat(proforma_itaxable_amount) * (proforma_gst/100)) + parseFloat(proforma_itaxable_amount);
                            proforma_gst_amt = parseFloat(proforma_itaxable_amount) * (proforma_gst/100);
                        }
                        $('#proforma_gst').val(proforma_gst);
                        $('#proforma_itotal_amount').val(proforma_gst_amt);
                        $('#proforma_gst_amount').val(proforma_gst_amt);
                        
                        var proforma_sgst = 0;
                        var proforma_sgst_amt = 0;
                        if(proforma_itaxable_amount !== '' && typeof proforma_itaxable_amount !== "undefined" && parseFloat(proforma_itaxable_amount) > 0 && 
                            result.gst !== '' && typeof result.gst !== "undefined" && parseFloat(result.gst) > 0){
                            proforma_sgst = parseFloat(result.gst)/2;
                            proforma_sgst_amt = parseFloat(proforma_itaxable_amount) * (proforma_sgst/100);
                        }
                        $('#proforma_sgst1').val(proforma_sgst);
                        $('#proforma_sgst_amount1').val(proforma_sgst_amt);
                        
                        var proforma_cgst = 0;
                        var proforma_cgst_amt = 0;
                        if(proforma_itaxable_amount !== '' && typeof proforma_itaxable_amount !== "undefined" && parseFloat(proforma_itaxable_amount) > 0 && 
                            result.gst !== '' && typeof result.gst !== "undefined" && parseFloat(result.gst) > 0){
                            proforma_cgst = parseFloat(result.gst)/2;
                            proforma_cgst_amt = parseFloat(proforma_itaxable_amount) * (proforma_cgst/100);
                        }
                        $('#proforma_cgst1').val(proforma_cgst);
                        $('#proforma_cgst_amount1').val(proforma_cgst_amt);
                                    
                        $('#proforma_boq_code1').val(result.boq_code);    
                        $('#proforma_hsn_sac_code1').val(result.hsn_sac_code);    
                        $('#proforma_hsn_sac_code1').prop('readonly', true);
                        $('#proforma_item_description1').val(result.item_description);
                        $('#proforma_item_description1').prop('readonly', true);
                        $('#proforma_unit1').val(result.unit);    
                        $('#proforma_unit1').prop('readonly', true);
                        $('#proforma_qty1').val(final_qty);    
                        $('#proforma_itaxable_amount1').val(proforma_itaxable_amount);
                        $('#proforma_rate1').val(result.rate_basic);  
                    }else{
                        $('#invaliderrorprod').html('BOQ Sr No.'+boq_code+' not available for billing!');  
                        $('#invaliderrorprod1').html('BOQ Sr No.'+boq_code+' not available for billing!');  
                        $('#proforma_from').val('');    
                        $('#proforma_from1').val('');    
                        $('#proforma_boq_code').val('');    
                        $('#proforma_hsn_sac_code').val('');    
                        $('#proforma_hsn_sac_code').prop('readonly', false);
                        $('#proforma_item_description').val('');
                        $('#proforma_item_description').prop('readonly', false);
                        $('#proforma_unit').val('');    
                        $('#proforma_unit').prop('readonly', false);
                        $('#proforma_qty').val('');    
                        $('#proforma_rate').val('');    
                        $('#proforma_itaxable_amount').val('');    
                        $('#proforma_itotal_amount').val('');
                                    
                        $('#proforma_boq_code1').val('');    
                        $('#proforma_hsn_sac_code1').val('');    
                        $('#proforma_hsn_sac_code1').prop('readonly', false);
                        $('#proforma_item_description1').val('');
                        $('#proforma_item_description1').prop('readonly', false);
                        $('#proforma_unit1').val('');    
                        $('#proforma_unit1').prop('readonly', false);
                        $('#proforma_qty1').val('');    
                        $('#proforma_rate1').val('');    
                        $('#proforma_itaxable_amount1').val('');    
                        $('#proforma_itotal_amount1').val('');  
                    }
                }else{
                    $('#invaliderrorprod').html('BOQ Sr No.'+boq_code+' Pending for Approval!');  
                    $('#invaliderrorprod1').html('BOQ Sr No.'+boq_code+' Pending for Approval!');  
                    $('#proforma_from').val('');    
                    $('#proforma_from1').val('');    
                    $('#proforma_boq_code').val('');    
                    $('#proforma_hsn_sac_code').val('');    
                    $('#proforma_hsn_sac_code').prop('readonly', false);
                    $('#proforma_item_description').val('');
                    $('#proforma_item_description').prop('readonly', false);
                    $('#proforma_unit').val('');    
                    $('#proforma_unit').prop('readonly', false);
                    $('#proforma_qty').val('');    
                    $('#proforma_rate').val('');    
                    $('#proforma_itaxable_amount').val('');    
                    $('#proforma_itotal_amount').val('');
                                
                    $('#proforma_boq_code1').val('');    
                    $('#proforma_hsn_sac_code1').val('');    
                    $('#proforma_hsn_sac_code1').prop('readonly', false);
                    $('#proforma_item_description1').val('');
                    $('#proforma_item_description1').prop('readonly', false);
                    $('#proforma_unit1').val('');    
                    $('#proforma_unit1').prop('readonly', false);
                    $('#proforma_qty1').val('');    
                    $('#proforma_rate1').val('');    
                    $('#proforma_itaxable_amount1').val('');    
                    $('#proforma_itotal_amount1').val('');  
                }
            }else{
                $('#invaliderrorprod').html('BOQ Sr No.'+boq_code+' not available for billing!');  
                $('#invaliderrorprod1').html('BOQ Sr No.'+boq_code+' not available for billing!');  
                $('#proforma_from').val('');    
                $('#proforma_from1').val('');    
                $('#proforma_boq_code').val('');    
                $('#proforma_hsn_sac_code').val('');    
                $('#proforma_hsn_sac_code').prop('readonly', false);
                $('#proforma_item_description').val('');
                $('#proforma_item_description').prop('readonly', false);
                $('#proforma_unit').val('');    
                $('#proforma_unit').prop('readonly', false);
                $('#proforma_qty').val('');    
                $('#proforma_rate').val('');    
                $('#proforma_itaxable_amount').val('');    
                $('#proforma_itotal_amount').val('');
                            
                $('#proforma_boq_code1').val('');    
                $('#proforma_hsn_sac_code1').val('');    
                $('#proforma_hsn_sac_code1').prop('readonly', false);
                $('#proforma_item_description1').val('');
                $('#proforma_item_description1').prop('readonly', false);
                $('#proforma_unit1').val('');    
                $('#proforma_unit1').prop('readonly', false);
                $('#proforma_qty1').val('');    
                $('#proforma_rate1').val('');    
                $('#proforma_itaxable_amount1').val('');    
                $('#proforma_itotal_amount1').val('');  
            }

        }
    });    
});

// $(document).on('click','.addPerfomaInvcRow1',function(){        
//     // alert("ok")
//     var maintml = $(this);
//     var project_id = document.getElementById("project_id").value;
//     var boq_code = document.getElementById("proforma_boq_code1").value;
//     var hsn_sac_code = document.getElementById("proforma_hsn_sac_code1").value;
//     var item_description = document.getElementById("proforma_item_description1").value;
//     var unit = document.getElementById("proforma_unit1").value;
//     var qty = document.getElementById("proforma_qty1").value;
//     var rate = document.getElementById("proforma_rate1").value;
//     var itaxable_amount = document.getElementById("proforma_itaxable_amount1").value;
//     var sgst = document.getElementById("proforma_sgst1").value;
//     var sgst_amount = document.getElementById("proforma_sgst_amount1").value;
//     var cgst = document.getElementById("proforma_cgst1").value;
//     var cgst_amount = document.getElementById("proforma_cgst_amount1").value;
//     var proforma_from = document.getElementById("proforma_from1").value;
    
//     if(sgst !== '' && typeof sgst !== "undefined" && parseFloat(sgst) > 0){
//         sgst = sgst;    
//     }else{
//         sgst = 0;
//     }
//     if(sgst_amount !== '' && typeof sgst_amount !== "undefined" && parseFloat(sgst_amount) > 0){
//         sgst_amount = sgst_amount;    
//     }else{
//         sgst_amount = 0.00;
//     }
//     if(cgst !== '' && typeof cgst !== "undefined" && parseFloat(cgst) > 0){
//         cgst = cgst;    
//     }else{
//         cgst = 0;
//     }
//     if(cgst_amount !== '' && typeof cgst_amount !== "undefined" && parseFloat(cgst_amount) > 0){
//         cgst_amount = cgst_amount;    
//     }else{
//         cgst_amount = 0.00;
//     }
//     if(project_id === '' || boq_code === '' || hsn_sac_code === '' || item_description === '' || unit === '' || 
//     qty < 1 || rate < 1){
//         $('.invaliderrorpro1').addClass('has-error-p');
//     }else{
//         var base_url = $('#base_url').val().trim();
//         var installed_stock = 0;
//         var provisional_stock = 0;
//         var total_stock = 0;
//         var proforma_stock = 0;
//         var exist_boq_code = '';
//         if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
//             proforma_stock = function () {
//             var tmp_proforma_stock = 0;
//             $.ajax({
//                 'async': false,
//                 'type': "POST",
//                 'global': false,
//                 'dataType': 'json',
//                 'url': completeURL('get_stock_details'),
//                 'data': { 'boq_code': boq_code, 'project_id': project_id},
//                 'success': function (result) {
//                     if(result.proforma_stock !== '' && typeof result.proforma_stock !== "undefined" && parseFloat(result.proforma_stock) > 0){
//                         tmp_proforma_stock = result.proforma_stock;
//                     }else{
//                         tmp_proforma_stock = 0;
//                     }
//                 }
//             });
//             return tmp_proforma_stock;
//             }();
//             total_stock = function () {
//             var tmptotalstock = 0;
//             $.ajax({
//                 'async': false,
//                 'type': "POST",
//                 'global': false,
//                 'dataType': 'json',
//                 'url': completeURL('get_stock_details'),
//                 'data': { 'boq_code': boq_code, 'project_id': project_id},
//                 'success': function (result) {
//                     if(result.total_stock !== '' && typeof result.total_stock !== "undefined" && parseFloat(result.total_stock) > 0){
//                         tmptotalstock = result.total_stock;
//                     }else{
//                         tmptotalstock = 0;
//                     }
//                 }
//             });
//             return tmptotalstock;
//             }();
//             installed_stock = function () {
//             var tmpinstalled = 0;
//             $.ajax({
//                 'async': false,
//                 'type': "POST",
//                 'global': false,
//                 'dataType': 'json',
//                 'url': completeURL('get_stock_details'),
//                 'data': { 'boq_code': boq_code, 'project_id': project_id},
//                 'success': function (result) {
//                     if(result.installed !== '' && typeof result.installed !== "undefined" && parseFloat(result.installed) > 0){
//                         tmpinstalled = result.installed;
//                     }else{
//                         tmpinstalled = 0;
//                     }
//                 }
//             });
//             return tmpinstalled;
//             }();
//             provisional_stock = function () {
//             var tmp_provisional = 0;
//             $.ajax({
//                 'async': false,
//                 'type': "POST",
//                 'global': false,
//                 'dataType': 'json',
//                 'url': completeURL('get_stock_details'),
//                 'data': { 'boq_code': boq_code, 'project_id': project_id},
//                 'success': function (result) {
//                     if(result.provisional !== '' && typeof result.provisional !== "undefined" && parseFloat(result.provisional) > 0){
//                         tmp_provisional = result.provisional;
//                     }else{
//                         tmp_provisional = 0;
//                     }
//                 }
//             });
//             return tmp_provisional;
//             }();
//             exist_boq_code = function () {
//             var tmp1 = null;
//             $.ajax({
//                 'async': false,
//                 'type': "POST",
//                 'global': false,
//                 'dataType': 'json',
//                 'url': completeURL('get_approved_boq_item_details'),
//                 'data': { 'boq_code': boq_code, 'project_id': project_id},
//                 'success': function (result) {
//                     tmp1 = result.boq_code;
//                 }
//             });
//             return tmp1;
//             }();
//         }
//         var final_qty=0;
//         var proforma_from = '';
//         if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
//         && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
//             final_qty = parseInt(installed_stock) + parseInt(provisional_stock); 
//         }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) === 0
//         && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
//             final_qty = parseInt(provisional_stock); 
//         }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
//         && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) === 0){
//             final_qty = parseInt(installed_stock); 
//         }
//         if(parseInt(qty) <= parseInt(installed_stock)){
//             proforma_from = 'installed_stock';
//         }else if(parseInt(qty) <= parseInt(provisional_stock)){
//             proforma_from = 'provisional_stock';
//         }else if(parseInt(qty) <= parseInt(final_qty)){
//             proforma_from = 'both';
//         }
//         if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
//             if(parseInt(total_stock) > parseInt(proforma_stock)){
//             if(final_qty !== '' && typeof final_qty !== "undefined" && parseInt(final_qty) > 0){
//                 if(parseInt(qty) <= parseInt(final_qty)){
//                     boq_code_no = [];
//                     $("input[name='proforma_boq_code_v[]']").each(function(){
//                             boq_code_no.push($(this).val());
//                         });
//                     if ($.inArray(boq_code, boq_code_no) != -1){
//                             $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Details Already Exist!');
//                             $('#proforma_boq_code1').val('');
//                             $('#proforma_hsn_sac_code1').val('');
//                             $('#proforma_item_description1').val('');
//                             $('#proforma_unit1').val('');
//                             $('#proforma_qty1').val('');
//                             $('#proforma_rate1').val('');
//                             $('#proforma_itaxable_amount1').val('');
//                             $('#proforma_sgst1').val('');
//                             $('#proforma_sgst_amount1').val('');
//                             $('#proforma_cgst1').val('');
//                             $('#proforma_cgst_amount1').val('');
//                             $('#proforma_hsn_sac_code1').prop('readonly', false);
//                             $('#proforma_item_description1').prop('readonly', false);
//                             $('#proforma_unit1').prop('readonly', false);
//                     }else{
//                         if(parseInt(qty) > 0){
//                                 var html='<tr><td>'
//                                 +'<input type="hidden" id="proforma_from_'+boq_code+'" name="proforma_from[]" value="'+proforma_from+'"><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_boq_code_v[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_hsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_unit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="number" class="form-control checkproformaqty invalidqtyproformaerror_'+boq_code+' invalidqtyproforma_'+boq_code+'" name="proforma_qty[]" value="'+qty+'" data-id="'+boq_code+'" data-pid="'+project_id+'" style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_rate[]" id="proforma_rate_'+boq_code+'" value="'+rate+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_itaxable_amount[]" id="proforma_itaxable_amount_'+boq_code+'" value="'+itaxable_amount+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_sgst[]" id="proforma_sgst_'+boq_code+'" value="'+sgst+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_sgst_amount[]" id="proforma_sgst_amount_'+boq_code+'" value="'+sgst_amount+'" readonly style="font-size: 12px;width:100%">'
//                                 +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_cgst[]" id="proforma_cgst_'+boq_code+'" value="'+cgst+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_cgst_amount[]" id="proforma_cgst_amount_'+boq_code+'" value="'+cgst_amount+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td>'
//                                 +'<div class="addDeleteButton">'
//                                 +'<span class="tooltips deletePerfomaInvcRow1" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
//                                 +'</div></td></tr>';
//                                 $('.invaliderrorpro1').removeClass('has-error-d');
//                                 $('#invaliderrorprod1').html('');
//                                 $(maintml).parents('#taxperfomadisplaysgsts tbody').find("tr:last").before(html);
//                                 $(maintml).parents('#taxperfomadisplaysgstsexist tbody').find("tr:last").before(html);
//                                 $('#proforma_boq_code1').val('');
//                                 $('#proforma_hsn_sac_code1').val('');
//                                 $('#proforma_item_description1').val('');
//                                 $('#proforma_unit1').val('');
//                                 $('#proforma_qty1').val('');
//                                 $('#proforma_rate1').val('');
//                                 $('#proforma_itaxable_amount1').val('');
//                                 $('#proforma_sgst1').val('');
//                                 $('#proforma_sgst_amount1').val('');
//                                 $('#proforma_cgst1').val('');
//                                 $('#proforma_cgst_amount1').val('');
//                                 $('#proforma_hsn_sac_code1').prop('readonly', false);
//                                 $('#proforma_item_description1').prop('readonly', false);
//                                 $('#proforma_unit1').prop('readonly', false);
                                
//                                 var total = 0;
//                                 $("input[name='proforma_itaxable_amount[]']").each(function() {
//                                     total += parseFloat($(this).val());
//                                 });
//                                 var total_sgst_amt = 0;
//                                 $("input[name='proforma_sgst_amount[]']").each(function() {
//                                     total_sgst_amt += parseFloat($(this).val());
//                                 });
                                
//                                 var total_cgst_amt = 0;
//                                 $("input[name='proforma_cgst_amount[]']").each(function() {
//                                     total_cgst_amt += parseFloat($(this).val());
//                                 });
                                
//                                 var proformafinal = 0;
//                                 proformafinal = parseFloat(total) + parseFloat(total_sgst_amt) + parseFloat(total_cgst_amt);
//                                 $('#proforma_sub_total1').html(parseFloat(total).toFixed(2));
//                                 $('#proforma_cgst_total1').html(parseFloat(total_cgst_amt).toFixed(2));
//                                 $('#proforma_sgst_total1').html(parseFloat(total_sgst_amt).toFixed(2));
//                                 $('#proforma_final1').html(parseFloat(proformafinal).toFixed(2));

//                         }else{
//                             $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Invalid Qty!');
//                         }
//                     }   
//                 }else{
//                     $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+final_qty+' !');
//                 }
//             }else{
//                 $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' not available for billing!!');
//                 $('#proforma_from').val('');
//                 $('#proforma_from1').val('');
//                 $('#proforma_boq_code1').val('');
//                 $('#proforma_hsn_sac_code1').val('');
//                 $('#proforma_item_description1').val('');
//                 $('#proforma_unit1').val('');
//                 $('#proforma_qty1').val('');
//                 $('#proforma_rate1').val('');
//                 $('#proforma_itaxable_amount1').val('');
//                 $('#proforma_sgst1').val('');
//                 $('#proforma_sgst_amount1').val('');
//                 $('#proforma_cgst1').val('');
//                 $('#proforma_cgst_amount1').val('');
//                 $('#proforma_hsn_sac_code1').prop('readonly', false);
//                 $('#proforma_item_description1').prop('readonly', false);
//                 $('#proforma_unit1').prop('readonly', false);
            
//             }
//             }
//             else{
//                 $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' already Billed!!');
//                 $('#proforma_from').val('');
//                 $('#proforma_from1').val('');
//                 $('#proforma_boq_code1').val('');
//                 $('#proforma_hsn_sac_code1').val('');
//                 $('#proforma_item_description1').val('');
//                 $('#proforma_unit1').val('');
//                 $('#proforma_qty1').val('');
//                 $('#proforma_rate1').val('');
//                 $('#proforma_itaxable_amount1').val('');
//                 $('#proforma_sgst1').val('');
//                 $('#proforma_sgst_amount1').val('');
//                 $('#proforma_cgst1').val('');
//                 $('#proforma_cgst_amount1').val('');
//                 $('#proforma_hsn_sac_code1').prop('readonly', false);
//                 $('#proforma_item_description1').prop('readonly', false);
//                 $('#proforma_unit1').prop('readonly', false);
            
//             }
//         }else{
//             $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Details Not Exist!');
//             $('#proforma_from').val('');
//             $('#proforma_from1').val('');
//             $('#proforma_boq_code1').val('');
//             $('#proforma_hsn_sac_code1').val('');
//             $('#proforma_item_description1').val('');
//             $('#proforma_unit1').val('');
//             $('#proforma_qty1').val('');
//             $('#proforma_rate1').val('');
//             $('#proforma_itaxable_amount1').val('');
//             $('#proforma_sgst1').val('');
//             $('#proforma_sgst_amount1').val('');
//             $('#proforma_cgst1').val('');
//             $('#proforma_cgst_amount1').val('');
//             $('#proforma_hsn_sac_code1').prop('readonly', false);
//             $('#proforma_item_description1').prop('readonly', false);
//             $('#proforma_unit1').prop('readonly', false);
//         }
//         $("#billing_split_up").trigger("change");
//     }
//     if (jQuery().datepicker) {
//         $('.date-picker').datepicker({
//             dateFormat: "dd-mm-yy",
//             orientation: "right",
//             autoclose: true,
//         });
//     } 
//     Metronic.init();
    
// });
// $(document).on('click','.addPerfomaInvcRow1',function(){        
//     // alert("ok")
//     var maintml = $(this);
//     var project_id = document.getElementById("project_id").value;
//     var boq_code = document.getElementById("proforma_boq_code1").value;
//     var hsn_sac_code = document.getElementById("proforma_hsn_sac_code1").value;
//     var item_description = document.getElementById("proforma_item_description1").value;
//     var unit = document.getElementById("proforma_unit1").value;
//     var qty = document.getElementById("proforma_qty1").value;
//     var rate = document.getElementById("proforma_rate1").value;
//     var itaxable_amount = document.getElementById("proforma_itaxable_amount1").value;
//     var sgst = document.getElementById("proforma_sgst1").value;
//     var sgst_amount = document.getElementById("proforma_sgst_amount1").value;
//     var cgst = document.getElementById("proforma_cgst1").value;
//     var cgst_amount = document.getElementById("proforma_cgst_amount1").value;
//     var proforma_from = document.getElementById("proforma_from1").value;
    
//     if(sgst !== '' && typeof sgst !== "undefined" && parseFloat(sgst) > 0){
//         sgst = sgst;    
//     }else{
//         sgst = 0;
//     }
//     if(sgst_amount !== '' && typeof sgst_amount !== "undefined" && parseFloat(sgst_amount) > 0){
//         sgst_amount = sgst_amount;    
//     }else{
//         sgst_amount = 0.00;
//     }
//     if(cgst !== '' && typeof cgst !== "undefined" && parseFloat(cgst) > 0){
//         cgst = cgst;    
//     }else{
//         cgst = 0;
//     }
//     if(cgst_amount !== '' && typeof cgst_amount !== "undefined" && parseFloat(cgst_amount) > 0){
//         cgst_amount = cgst_amount;    
//     }else{
//         cgst_amount = 0.00;
//     }
//     if(project_id === '' || boq_code === '' || hsn_sac_code === '' || item_description === '' || unit === '' || 
//     qty < 0 || rate < 0){
//         $('.invaliderrorpro1').addClass('has-error-p');
//     }else{
//         var base_url = $('#base_url').val().trim();
//         var installed_stock = 0;
//         var provisional_stock = 0;
//         var total_stock = 0;
//         var proforma_stock = 0;
//         var exist_boq_code = '';
//         if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
//             proforma_stock = function () {
//             var tmp_proforma_stock = 0;
//             $.ajax({
//                 'async': false,
//                 'type': "POST",
//                 'global': false,
//                 'dataType': 'json',
//                 'url': completeURL('get_stock_details'),
//                 'data': { 'boq_code': boq_code, 'project_id': project_id},
//                 'success': function (result) {
//                     if(result.proforma_stock !== '' && typeof result.proforma_stock !== "undefined" && parseFloat(result.proforma_stock) > 0){
//                         tmp_proforma_stock = result.proforma_stock;
//                     }else{
//                         tmp_proforma_stock = 0;
//                     }
//                 }
//             });
//             return tmp_proforma_stock;
//             }();
//             total_stock = function () {
//             var tmptotalstock = 0;
//             $.ajax({
//                 'async': false,
//                 'type': "POST",
//                 'global': false,
//                 'dataType': 'json',
//                 'url': completeURL('get_stock_details'),
//                 'data': { 'boq_code': boq_code, 'project_id': project_id},
//                 'success': function (result) {
//                     if(result.total_stock !== '' && typeof result.total_stock !== "undefined" && parseFloat(result.total_stock) > 0){
//                         tmptotalstock = result.total_stock;
//                     }else{
//                         tmptotalstock = 0;
//                     }
//                 }
//             });
//             return tmptotalstock;
//             }();
//             installed_stock = function () {
//             var tmpinstalled = 0;
//             $.ajax({
//                 'async': false,
//                 'type': "POST",
//                 'global': false,
//                 'dataType': 'json',
//                 'url': completeURL('get_stock_details'),
//                 'data': { 'boq_code': boq_code, 'project_id': project_id},
//                 'success': function (result) {
//                     if(result.installed !== '' && typeof result.installed !== "undefined" && parseFloat(result.installed) > 0){
//                         tmpinstalled = result.installed;
//                     }else{
//                         tmpinstalled = 0;
//                     }
//                 }
//             });
//             return tmpinstalled;
//             }();
//             provisional_stock = function () {
//             var tmp_provisional = 0;
//             $.ajax({
//                 'async': false,
//                 'type': "POST",
//                 'global': false,
//                 'dataType': 'json',
//                 'url': completeURL('get_stock_details'),
//                 'data': { 'boq_code': boq_code, 'project_id': project_id},
//                 'success': function (result) {
//                     if(result.provisional !== '' && typeof result.provisional !== "undefined" && parseFloat(result.provisional) > 0){
//                         tmp_provisional = result.provisional;
//                     }else{
//                         tmp_provisional = 0;
//                     }
//                 }
//             });
//             return tmp_provisional;
//             }();
//             exist_boq_code = function () {
//             var tmp1 = null;
//             $.ajax({
//                 'async': false,
//                 'type': "POST",
//                 'global': false,
//                 'dataType': 'json',
//                 'url': completeURL('get_approved_boq_item_details'),
//                 'data': { 'boq_code': boq_code, 'project_id': project_id},
//                 'success': function (result) {
//                     tmp1 = result.boq_code;
//                 }
//             });
//             return tmp1;
//             }();
//         }
//         var final_qty=0;
//         var proforma_from = '';
//         if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
//         && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
//             final_qty = parseFloat(installed_stock) + parseFloat(provisional_stock); 
//         }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) === 0
//         && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
//             final_qty = parseFloat(provisional_stock); 
//         }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
//         && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) === 0){
//             final_qty = parseFloat(installed_stock); 
//         }
//         if(parseFloat(qty) <= parseFloat(installed_stock)){
//             proforma_from = 'installed_stock';
//         }else if(parseFloat(qty) <= parseFloat(provisional_stock)){
//             proforma_from = 'provisional_stock';
//         }else if(parseFloat(qty) <= parseFloat(final_qty)){
//             proforma_from = 'both';
//         }
//         if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
//             if(parseFloat(total_stock) > parseFloat(proforma_stock)){
//             if(final_qty !== '' && typeof final_qty !== "undefined" && parseFloat(final_qty) > 0){
//                 if(parseFloat(qty) <= parseFloat(final_qty)){
//                     boq_code_no = [];
//                     $("input[name='proforma_boq_code_v[]']").each(function(){
//                             boq_code_no.push($(this).val());
//                         });
//                     if ($.inArray(boq_code, boq_code_no) != -1){
//                             $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Details Already Exist!');
//                             $('#proforma_boq_code1').val('');
//                             $('#proforma_hsn_sac_code1').val('');
//                             $('#proforma_item_description1').val('');
//                             $('#proforma_unit1').val('');
//                             $('#proforma_qty1').val('');
//                             $('#proforma_rate1').val('');
//                             $('#proforma_itaxable_amount1').val('');
//                             $('#proforma_sgst1').val('');
//                             $('#proforma_sgst_amount1').val('');
//                             $('#proforma_cgst1').val('');
//                             $('#proforma_cgst_amount1').val('');
//                             $('#proforma_hsn_sac_code1').prop('readonly', false);
//                             $('#proforma_item_description1').prop('readonly', false);
//                             $('#proforma_unit1').prop('readonly', false);
//                     }else{
//                         if(parseFloat(qty) > 0){
//                                 var html='<tr><td>'
//                                 +'<input type="hidden" id="proforma_from_'+boq_code+'" name="proforma_from[]" value="'+proforma_from+'"><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_boq_code_v[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_hsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_unit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="number" class="form-control checkproformaqty invalidqtyproformaerror_'+boq_code+' invalidqtyproforma_'+boq_code+'" name="proforma_qty[]" value="'+qty+'" data-id="'+boq_code+'" data-pid="'+project_id+'" style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_rate[]" id="proforma_rate_'+boq_code+'" value="'+rate+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_itaxable_amount[]" id="proforma_itaxable_amount_'+boq_code+'" value="'+itaxable_amount+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_sgst[]" id="proforma_sgst_'+boq_code+'" value="'+sgst+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_sgst_amount[]" id="proforma_sgst_amount_'+boq_code+'" value="'+sgst_amount+'" readonly style="font-size: 12px;width:100%">'
//                                 +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_cgst[]" id="proforma_cgst_'+boq_code+'" value="'+cgst+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_cgst_amount[]" id="proforma_cgst_amount_'+boq_code+'" value="'+cgst_amount+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td>'
//                                 +'<div class="addDeleteButton">'
//                                 +'<span class="tooltips deletePerfomaInvcRow1" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
//                                 +'</div></td></tr>';
//                                 $('.invaliderrorpro1').removeClass('has-error-d');
//                                 $('#invaliderrorprod1').html('');
//                                 $(maintml).parents('#taxperfomadisplaysgsts tbody').find("tr:last").before(html);
//                                 $(maintml).parents('#taxperfomadisplaysgstsexist tbody').find("tr:last").before(html);
//                                 $('#proforma_boq_code1').val('');
//                                 $('#proforma_hsn_sac_code1').val('');
//                                 $('#proforma_item_description1').val('');
//                                 $('#proforma_unit1').val('');
//                                 $('#proforma_qty1').val('');
//                                 $('#proforma_rate1').val('');
//                                 $('#proforma_itaxable_amount1').val('');
//                                 $('#proforma_sgst1').val('');
//                                 $('#proforma_sgst_amount1').val('');
//                                 $('#proforma_cgst1').val('');
//                                 $('#proforma_cgst_amount1').val('');
//                                 $('#proforma_hsn_sac_code1').prop('readonly', false);
//                                 $('#proforma_item_description1').prop('readonly', false);
//                                 $('#proforma_unit1').prop('readonly', false);
                                
//                                 var total = 0;
//                                 $("input[name='proforma_itaxable_amount[]']").each(function() {
//                                     total += parseFloat($(this).val());
//                                 });
//                                 var total_sgst_amt = 0;
//                                 $("input[name='proforma_sgst_amount[]']").each(function() {
//                                     total_sgst_amt += parseFloat($(this).val());
//                                 });
                                
//                                 var total_cgst_amt = 0;
//                                 $("input[name='proforma_cgst_amount[]']").each(function() {
//                                     total_cgst_amt += parseFloat($(this).val());
//                                 });
                                
//                                 var proformafinal = 0;
//                                 proformafinal = parseFloat(total) + parseFloat(total_sgst_amt) + parseFloat(total_cgst_amt);
//                                 $('#proforma_sub_total1').html(parseFloat(total).toFixed(2));
//                                 $('#proforma_cgst_total1').html(parseFloat(total_cgst_amt).toFixed(2));
//                                 $('#proforma_sgst_total1').html(parseFloat(total_sgst_amt).toFixed(2));
//                                 $('#proforma_final1').html(parseFloat(proformafinal).toFixed(2));
//                                 $("#original_invoice_value").val(proformafinal.toFixed(2))
//                                 $("#original_igst_invoice_value").val(0)

//                         }else{
//                             $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Invalid Qty!');
//                         }
//                     }   
//                 }else{
//                     $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+final_qty+' !');
//                 }
//             }else{
//                 $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' not available for billing!!');
//                 $('#proforma_from').val('');
//                 $('#proforma_from1').val('');
//                 $('#proforma_boq_code1').val('');
//                 $('#proforma_hsn_sac_code1').val('');
//                 $('#proforma_item_description1').val('');
//                 $('#proforma_unit1').val('');
//                 $('#proforma_qty1').val('');
//                 $('#proforma_rate1').val('');
//                 $('#proforma_itaxable_amount1').val('');
//                 $('#proforma_sgst1').val('');
//                 $('#proforma_sgst_amount1').val('');
//                 $('#proforma_cgst1').val('');
//                 $('#proforma_cgst_amount1').val('');
//                 $('#proforma_hsn_sac_code1').prop('readonly', false);
//                 $('#proforma_item_description1').prop('readonly', false);
//                 $('#proforma_unit1').prop('readonly', false);
            
//             }
//             }
//             else{
//                 $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' already Billed!!');
//                 $('#proforma_from').val('');
//                 $('#proforma_from1').val('');
//                 $('#proforma_boq_code1').val('');
//                 $('#proforma_hsn_sac_code1').val('');
//                 $('#proforma_item_description1').val('');
//                 $('#proforma_unit1').val('');
//                 $('#proforma_qty1').val('');
//                 $('#proforma_rate1').val('');
//                 $('#proforma_itaxable_amount1').val('');
//                 $('#proforma_sgst1').val('');
//                 $('#proforma_sgst_amount1').val('');
//                 $('#proforma_cgst1').val('');
//                 $('#proforma_cgst_amount1').val('');
//                 $('#proforma_hsn_sac_code1').prop('readonly', false);
//                 $('#proforma_item_description1').prop('readonly', false);
//                 $('#proforma_unit1').prop('readonly', false);
            
//             }
//         }else{
//             $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Details Not Exist!');
//             $('#proforma_from').val('');
//             $('#proforma_from1').val('');
//             $('#proforma_boq_code1').val('');
//             $('#proforma_hsn_sac_code1').val('');
//             $('#proforma_item_description1').val('');
//             $('#proforma_unit1').val('');
//             $('#proforma_qty1').val('');
//             $('#proforma_rate1').val('');
//             $('#proforma_itaxable_amount1').val('');
//             $('#proforma_sgst1').val('');
//             $('#proforma_sgst_amount1').val('');
//             $('#proforma_cgst1').val('');
//             $('#proforma_cgst_amount1').val('');
//             $('#proforma_hsn_sac_code1').prop('readonly', false);
//             $('#proforma_item_description1').prop('readonly', false);
//             $('#proforma_unit1').prop('readonly', false);
//         }
//         $("#billing_split_up").trigger("change");
//     }
//     if (jQuery().datepicker) {
//         $('.date-picker').datepicker({
//             dateFormat: "dd-mm-yy",
//             orientation: "right",
//             autoclose: true,
//         });
//     } 
//     Metronic.init();
    
// });

$(document).on('click','.addPerfomaInvcRow1',function(){        
    // alert("ok")
    var maintml = $(this);
    var project_id = document.getElementById("project_id").value;
    var boq_code = document.getElementById("proforma_boq_code1").value;
    var hsn_sac_code = document.getElementById("proforma_hsn_sac_code1").value;
    var item_description = document.getElementById("proforma_item_description1").value;
    var unit = document.getElementById("proforma_unit1").value;
    var qty = document.getElementById("proforma_qty1").value;
    var rate = document.getElementById("proforma_rate1").value;
    var itaxable_amount = document.getElementById("proforma_itaxable_amount1").value;
    var sgst = document.getElementById("proforma_sgst1").value;
    var sgst_amount = document.getElementById("proforma_sgst_amount1").value;
    var cgst = document.getElementById("proforma_cgst1").value;
    var cgst_amount = document.getElementById("proforma_cgst_amount1").value;
    var proforma_from = document.getElementById("proforma_from1").value;
    
    if(sgst !== '' && typeof sgst !== "undefined" && parseFloat(sgst) > 0){
        sgst = sgst;    
    }else{
        sgst = 0;
    }
    if(sgst_amount !== '' && typeof sgst_amount !== "undefined" && parseFloat(sgst_amount) > 0){
        sgst_amount = sgst_amount;    
    }else{
        sgst_amount = 0.00;
    }
    if(cgst !== '' && typeof cgst !== "undefined" && parseFloat(cgst) > 0){
        cgst = cgst;    
    }else{
        cgst = 0;
    }
    if(cgst_amount !== '' && typeof cgst_amount !== "undefined" && parseFloat(cgst_amount) > 0){
        cgst_amount = cgst_amount;    
    }else{
        cgst_amount = 0.00;
    }
    if(project_id === '' || boq_code === '' || hsn_sac_code === '' || item_description === '' || unit === '' || 
    qty < 0 || rate < 0){
        $('.invaliderrorpro1').addClass('has-error-p');
    }else{
        var base_url = $('#base_url').val().trim();
        var installed_stock = 0;
        var provisional_stock = 0;
        var total_stock = 0;
        var proforma_stock = 0;
        var exist_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            proforma_stock = function () {
            var tmp_proforma_stock = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.proforma_stock !== '' && typeof result.proforma_stock !== "undefined" && parseFloat(result.proforma_stock) > 0){
                        tmp_proforma_stock = result.proforma_stock;
                    }else{
                        tmp_proforma_stock = 0;
                    }
                }
            });
            return tmp_proforma_stock;
            }();
            total_stock = function () {
            var tmptotalstock = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.total_stock !== '' && typeof result.total_stock !== "undefined" && parseFloat(result.total_stock) > 0){
                        tmptotalstock = result.total_stock;
                    }else{
                        tmptotalstock = 0;
                    }
                }
            });
            return tmptotalstock;
            }();
            installed_stock = function () {
            var tmpinstalled = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.installed !== '' && typeof result.installed !== "undefined" && parseFloat(result.installed) > 0){
                        tmpinstalled = result.installed;
                    }else{
                        tmpinstalled = 0;
                    }
                }
            });
            return tmpinstalled;
            }();
            provisional_stock = function () {
            var tmp_provisional = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.provisional !== '' && typeof result.provisional !== "undefined" && parseFloat(result.provisional) > 0){
                        tmp_provisional = result.provisional;
                    }else{
                        tmp_provisional = 0;
                    }
                }
            });
            return tmp_provisional;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
        }
        var final_qty=0;
        var proforma_from = '';
        if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
            final_qty = parseFloat(installed_stock) + parseFloat(provisional_stock); 
        }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) === 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
            final_qty = parseFloat(provisional_stock); 
        }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) === 0){
            final_qty = parseFloat(installed_stock); 
        }
        if(parseFloat(qty) <= parseFloat(installed_stock)){
            proforma_from = 'installed_stock';
        }else if(parseFloat(qty) <= parseFloat(provisional_stock)){
            proforma_from = 'provisional_stock';
        }else if(parseFloat(qty) <= parseFloat(final_qty)){
            proforma_from = 'both';
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
            if(parseFloat(total_stock) > parseFloat(proforma_stock)){
            if(final_qty !== '' && typeof final_qty !== "undefined" && parseFloat(final_qty) > 0){
                if(parseFloat(qty) <= parseFloat(final_qty)){
                    boq_code_no = [];
                    $("input[name='proforma_boq_code_v[]']").each(function(){
                            boq_code_no.push($(this).val());
                        });
                    if ($.inArray(boq_code, boq_code_no) != -1){
                            $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                            $('#proforma_boq_code1').val('');
                            $('#proforma_hsn_sac_code1').val('');
                            $('#proforma_item_description1').val('');
                            $('#proforma_unit1').val('');
                            $('#proforma_qty1').val('');
                            $('#proforma_rate1').val('');
                            $('#proforma_itaxable_amount1').val('');
                            $('#proforma_sgst1').val('');
                            $('#proforma_sgst_amount1').val('');
                            $('#proforma_cgst1').val('');
                            $('#proforma_cgst_amount1').val('');
                            $('#proforma_hsn_sac_code1').prop('readonly', false);
                            $('#proforma_item_description1').prop('readonly', false);
                            $('#proforma_unit1').prop('readonly', false);
                    }else{
                        if(parseFloat(qty) > 0){
                                var html='<tr><td>'
                                +'<input type="hidden" id="proforma_from_'+boq_code+'" name="proforma_from[]" value="'+proforma_from+'"><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_boq_code_v[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_hsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_unit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="number" class="form-control checkproformaqty invalidqtyproformaerror_'+boq_code+' invalidqtyproforma_'+boq_code+'" name="proforma_qty[]" value="'+qty+'" data-id="'+boq_code+'" data-pid="'+project_id+'" style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_rate[]" id="proforma_rate_'+boq_code+'" value="'+rate+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_itaxable_amount[]" id="proforma_itaxable_amount_'+boq_code+'" value="'+itaxable_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_sgst[]" id="proforma_sgst_'+boq_code+'" value="'+sgst+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_sgst_amount[]" id="proforma_sgst_amount_'+boq_code+'" value="'+sgst_amount+'" readonly style="font-size: 12px;width:100%">'
                                +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_cgst[]" id="proforma_cgst_'+boq_code+'" value="'+cgst+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="number" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_cgst_amount[]" id="proforma_cgst_amount_'+boq_code+'" value="'+cgst_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td>'
                                +'<div class="addDeleteButton">'
                                +'<span class="tooltips deletePerfomaInvcRow1" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                                +'</div></td></tr>';
                                $('.invaliderrorpro1').removeClass('has-error-d');
                                $('#invaliderrorprod1').html('');
                                $(maintml).parents('#taxperfomadisplaysgsts tbody').find("tr:last").before(html);
                                $(maintml).parents('#taxperfomadisplaysgstsexist tbody').find("tr:last").before(html);
                                $('#proforma_boq_code1').val('');
                                $('#proforma_hsn_sac_code1').val('');
                                $('#proforma_item_description1').val('');
                                $('#proforma_unit1').val('');
                                $('#proforma_qty1').val('');
                                $('#proforma_rate1').val('');
                                $('#proforma_itaxable_amount1').val('');
                                $('#proforma_sgst1').val('');
                                $('#proforma_sgst_amount1').val('');
                                $('#proforma_cgst1').val('');
                                $('#proforma_cgst_amount1').val('');
                                $('#proforma_hsn_sac_code1').prop('readonly', false);
                                $('#proforma_item_description1').prop('readonly', false);
                                $('#proforma_unit1').prop('readonly', false);
                                
                                var total = 0;
                                $("input[name='proforma_itaxable_amount[]']").each(function() {
                                    total += parseFloat($(this).val());
                                });
                                var total_sgst_amt = 0;
                                $("input[name='proforma_sgst_amount[]']").each(function() {
                                    total_sgst_amt += parseFloat($(this).val());
                                });
                                
                                var total_cgst_amt = 0;
                                $("input[name='proforma_cgst_amount[]']").each(function() {
                                    total_cgst_amt += parseFloat($(this).val());
                                });
                                
                                var proformafinal = 0;
                                proformafinal = parseFloat(total) + parseFloat(total_sgst_amt) + parseFloat(total_cgst_amt);
                                $('#proforma_sub_total1').html(parseFloat(total).toFixed(2));
                                $('#proforma_cgst_total1').html(parseFloat(total_cgst_amt).toFixed(2));
                                $('#proforma_sgst_total1').html(parseFloat(total_sgst_amt).toFixed(2));
                                $('#proforma_final1').html(parseFloat(proformafinal).toFixed(2));
                                $("#original_invoice_value").val(proformafinal.toFixed(2))
                                $("#original_igst_invoice_value").val(0)

                        }else{
                            $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Invalid Qty!');
                        }
                    }   
                }else{
                    $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+final_qty+' !');
                }
            }else{
                $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' not available for billing!!');
                $('#proforma_from').val('');
                $('#proforma_from1').val('');
                $('#proforma_boq_code1').val('');
                $('#proforma_hsn_sac_code1').val('');
                $('#proforma_item_description1').val('');
                $('#proforma_unit1').val('');
                $('#proforma_qty1').val('');
                $('#proforma_rate1').val('');
                $('#proforma_itaxable_amount1').val('');
                $('#proforma_sgst1').val('');
                $('#proforma_sgst_amount1').val('');
                $('#proforma_cgst1').val('');
                $('#proforma_cgst_amount1').val('');
                $('#proforma_hsn_sac_code1').prop('readonly', false);
                $('#proforma_item_description1').prop('readonly', false);
                $('#proforma_unit1').prop('readonly', false);
            
            }
            }
            else{
                $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' already Billed!!');
                $('#proforma_from').val('');
                $('#proforma_from1').val('');
                $('#proforma_boq_code1').val('');
                $('#proforma_hsn_sac_code1').val('');
                $('#proforma_item_description1').val('');
                $('#proforma_unit1').val('');
                $('#proforma_qty1').val('');
                $('#proforma_rate1').val('');
                $('#proforma_itaxable_amount1').val('');
                $('#proforma_sgst1').val('');
                $('#proforma_sgst_amount1').val('');
                $('#proforma_cgst1').val('');
                $('#proforma_cgst_amount1').val('');
                $('#proforma_hsn_sac_code1').prop('readonly', false);
                $('#proforma_item_description1').prop('readonly', false);
                $('#proforma_unit1').prop('readonly', false);
            
            }
        }else{
            $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Details Not Exist!');
            $('#proforma_from').val('');
            $('#proforma_from1').val('');
            $('#proforma_boq_code1').val('');
            $('#proforma_hsn_sac_code1').val('');
            $('#proforma_item_description1').val('');
            $('#proforma_unit1').val('');
            $('#proforma_qty1').val('');
            $('#proforma_rate1').val('');
            $('#proforma_itaxable_amount1').val('');
            $('#proforma_sgst1').val('');
            $('#proforma_sgst_amount1').val('');
            $('#proforma_cgst1').val('');
            $('#proforma_cgst_amount1').val('');
            $('#proforma_hsn_sac_code1').prop('readonly', false);
            $('#proforma_item_description1').prop('readonly', false);
            $('#proforma_unit1').prop('readonly', false);
        }
        $("#billing_split_up").trigger("change");
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
    
});

$(document).on('keyup','.checkproformaqty',function(){        
    var maintml = $(this);
    var qty = $(this).val();
    var boq_code = $(this).attr('data-id');
    var project_id = $(this).attr('data-pid');
    if(project_id === '' || boq_code === '' || qty < 1){
        $('.invalidqtyproforma_'+boq_code).addClass('has-error-d');
    }else{
        var base_url = $('#base_url').val().trim();
        var installed_stock = 0;
        var provisional_stock = 0;
        var exist_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            installed_stock = function () {
            var tmpinstalled = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.installed !== '' && typeof result.installed !== "undefined"){
                        tmpinstalled = result.installed;
                    }else{
                        tmpinstalled = 0;
                    }
                }
            });
            return tmpinstalled;
            }();
            provisional_stock = function () {
            var tmp_provisional = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.provisional !== '' && typeof result.provisional !== "undefined"){
                        tmp_provisional = result.provisional;
                    }else{
                        tmp_provisional = 0;
                    }
                }
            });
            return tmp_provisional;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
        }
        var final_qty=0;
        var proforma_from = '';
        if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
            final_qty = parseInt(installed_stock) + parseInt(provisional_stock); 
        }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) === 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
            final_qty = parseInt(provisional_stock); 
        }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) === 0){
            final_qty = parseInt(installed_stock); 
        }
        if(parseInt(qty) <= parseInt(installed_stock)){
            proforma_from = 'installed_stock';
        }else if(parseInt(qty) <= parseInt(provisional_stock)){
            proforma_from = 'provisional_stock';
        }else if(parseInt(qty) <= parseInt(final_qty)){
            proforma_from = 'both';
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
            if(parseInt(final_qty) > 0 && $.isNumeric(final_qty)){
                if(parseInt(qty) <= parseInt(final_qty)){
                    $('#proforma_from_'+boq_code).val(proforma_from);
                    var itaxable_amount = 0;
                    var itotal_amount = 0;
                    var rate = $('#proforma_rate_'+boq_code).val();
                    var gst = $('#proforma_gst_'+boq_code).val();
                    var gst_amount = 0;
                    if(qty !== '' && typeof qty !== "undefined" && parseFloat(qty) > 0){
                        qty = qty;
                    }else{
                        qty = 0;
                    }
                    if(rate !== '' && typeof rate !== "undefined" && parseFloat(rate) > 0 && parseFloat(qty) > 0){
                        //  itaxable_amount = parseFloat(rate) * parseFloat(qty);   
                        var itaxable_amount_s = calculatedBillSplit(rate,qty);
                        itaxable_amount = parseFloat(itaxable_amount_s);
                        console.log(itaxable_amount);
                    }
                    if(gst !== '' && typeof gst !== "undefined" && parseFloat(gst) > 0
                    && itaxable_amount !== '' && typeof itaxable_amount !== "undefined" && parseFloat(itaxable_amount) > 0){
                        gst_amount = parseFloat(itaxable_amount) * (parseFloat(gst)/100);    
                    }
                    var cgst_amount = 0;
                    var cgst = $('#proforma_cgst_'+boq_code).val();
                    if(cgst !== '' && typeof cgst !== "undefined" && parseFloat(cgst) > 0
                    && itaxable_amount !== '' && typeof itaxable_amount !== "undefined" && parseFloat(itaxable_amount) > 0){
                        cgst_amount = parseFloat(itaxable_amount) * (parseFloat(cgst)/100);    
                    }
                    var sgst_amount = 0;
                    var sgst = $('#proforma_sgst_'+boq_code).val();
                    if(sgst !== '' && typeof sgst !== "undefined" && parseFloat(sgst) > 0
                    && itaxable_amount !== '' && typeof itaxable_amount !== "undefined" && parseFloat(itaxable_amount) > 0){
                        sgst_amount = parseFloat(itaxable_amount) * (parseFloat(sgst)/100);    
                    }
                    itotal_amount = parseFloat(itaxable_amount) + parseFloat(gst_amount); 

                    $('#proforma_itaxable_amount_'+boq_code).val(itaxable_amount.toFixed(2));
                    $('#proforma_itotal_amount_'+boq_code).val(itotal_amount.toFixed(2));
                    $('#proforma_gst_amount_'+boq_code).val(gst_amount.toFixed(2));
                    $('#proforma_cgst_amount_'+boq_code).val(cgst_amount.toFixed(2));
                    $('#proforma_sgst_amount_'+boq_code).val(sgst_amount.toFixed(2));
                    
                    var proforma_sub_total1 = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total1 += parseFloat($(this).val());
                    });
                    var proforma_sub_total = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total += parseFloat($(this).val());
                    });
                    var proforma_total_gst = 0;
                    $("input[name='proforma_gst_amount[]']").each(function() {
                        proforma_total_gst += parseFloat($(this).val());
                    });
                    
                    var proforma_cgst_total1 = 0;
                    $("input[name='proforma_cgst_amount[]']").each(function() {
                        proforma_cgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_sgst_total1 = 0;
                    $("input[name='proforma_sgst_amount[]']").each(function() {
                        proforma_sgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_final1 = 0;
                    proforma_final1 = parseFloat(proforma_sub_total1) + parseFloat(proforma_sgst_total1) + parseFloat(proforma_cgst_total1);
                    
                    var proforma_igst_final = 0;
                    proforma_igst_final = parseFloat(proforma_sub_total) + parseFloat(proforma_total_gst);
                    $('#proforma_sub_total1').html(parseFloat(proforma_sub_total1).toFixed(2));
                    $('#proforma_sub_total').html(parseFloat(proforma_sub_total).toFixed(2));
                    $('#proforma_cgst_total1').html(parseFloat(proforma_cgst_total1).toFixed(2));
                    $('#proforma_sgst_total1').html(parseFloat(proforma_sgst_total1).toFixed(2));
                    $('#proforma_total_gst').html(parseFloat(proforma_total_gst).toFixed(2));
                    $('#proforma_final1').html(parseFloat(proforma_final1).toFixed(2));
                    $('#proforma_igst_final').html(parseFloat(proforma_igst_final).toFixed(2));
                    $("#original_invoice_value").val(parseFloat(proforma_final1).toFixed(2))
                    $("#original_igst_invoice_value").val(parseFloat(proforma_igst_final).toFixed(2))
                    
                    $('.invalidqtyproformaerror_'+boq_code).val(qty);  
                    $('.invalidqtyproforma_'+boq_code).removeClass('has-error-d');
                    $('#invaliderrorprod1').html('');
                    $('#invaliderrorprod').html('');
                }else{
                    $('#proforma_from_'+boq_code).val('');
                    $('#proforma_itaxable_amount_'+boq_code).val('0.00');
                    $('#proforma_itotal_amount_'+boq_code).val('0.00');
                    $('#proforma_gst_amount_'+boq_code).val('0.00');
                    $('#proforma_cgst_amount_'+boq_code).val('0.00');
                    $('#proforma_sgst_amount_'+boq_code).val('0.00');
                    
                    var proforma_sub_total1 = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total1 += parseFloat($(this).val());
                    });
                    var proforma_sub_total = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total += parseFloat($(this).val());
                    });
                    var proforma_total_gst = 0;
                    $("input[name='proforma_gst_amount[]']").each(function() {
                        proforma_total_gst += parseFloat($(this).val());
                    });
                    
                    var proforma_cgst_total1 = 0;
                    $("input[name='proforma_cgst_amount[]']").each(function() {
                        proforma_cgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_sgst_total1 = 0;
                    $("input[name='proforma_sgst_amount[]']").each(function() {
                        proforma_sgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_final1 = 0;
                    proforma_final1 = parseFloat(proforma_sub_total1) + parseFloat(proforma_sgst_total1) + parseFloat(proforma_cgst_total1);
                    
                    var proforma_igst_final = 0;
                    proforma_igst_final = parseFloat(proforma_sub_total) + parseFloat(proforma_total_gst);
                    $('#proforma_sub_total1').html(parseFloat(proforma_sub_total1).toFixed(2));
                    $('#proforma_sub_total').html(parseFloat(proforma_sub_total).toFixed(2));
                    $('#proforma_cgst_total1').html(parseFloat(proforma_cgst_total1).toFixed(2));
                    $('#proforma_sgst_total1').html(parseFloat(proforma_sgst_total1).toFixed(2));
                    $('#proforma_total_gst').html(parseFloat(proforma_total_gst).toFixed(2));
                    $('#proforma_final1').html(parseFloat(proforma_final1).toFixed(2));
                    $('#proforma_igst_final').html(parseFloat(proforma_igst_final).toFixed(2));
                    $("#original_invoice_value").val(parseFloat(proforma_final1).toFixed(2))
                    $("#original_igst_invoice_value").val(parseFloat(proforma_igst_final).toFixed(2))
                    
                    $('.invalidqtyproformaerror_'+boq_code).val('');      
                    $('.invalidqtyproforma_'+boq_code).addClass('has-error-d');
                    $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' qty must be less than equal to '+final_qty+' !');
                    $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' qty must be less than equal to '+final_qty+' !');
                    
                }
            }else{
                    $('#proforma_itaxable_amount_'+boq_code).val('0.00');
                    $('#proforma_itotal_amount_'+boq_code).val('0.00');
                    $('#proforma_gst_amount_'+boq_code).val('0.00');
                    $('#proforma_cgst_amount_'+boq_code).val('0.00');
                    $('#proforma_sgst_amount_'+boq_code).val('0.00');
                    
                    var proforma_sub_total1 = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total1 += parseFloat($(this).val());
                    });
                    var proforma_sub_total = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total += parseFloat($(this).val());
                    });
                    var proforma_total_gst = 0;
                    $("input[name='proforma_gst_amount[]']").each(function() {
                        proforma_total_gst += parseFloat($(this).val());
                    });
                    
                    var proforma_cgst_total1 = 0;
                    $("input[name='proforma_cgst_amount[]']").each(function() {
                        proforma_cgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_sgst_total1 = 0;
                    $("input[name='proforma_sgst_amount[]']").each(function() {
                        proforma_sgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_final1 = 0;
                    proforma_final1 = parseFloat(proforma_sub_total1) + parseFloat(proforma_sgst_total1) + parseFloat(proforma_cgst_total1);
                    
                    var proforma_igst_final = 0;
                    proforma_igst_final = parseFloat(proforma_sub_total) + parseFloat(proforma_total_gst);
                    $('#proforma_sub_total1').html(parseFloat(proforma_sub_total1).toFixed(2));
                    $('#proforma_sub_total').html(parseFloat(proforma_sub_total).toFixed(2));
                    $('#proforma_cgst_total1').html(parseFloat(proforma_cgst_total1).toFixed(2));
                    $('#proforma_sgst_total1').html(parseFloat(proforma_sgst_total1).toFixed(2));
                    $('#proforma_total_gst').html(parseFloat(proforma_total_gst).toFixed(2));
                    $('#proforma_final1').html(parseFloat(proforma_final1).toFixed(2));
                    $('#proforma_igst_final').html(parseFloat(proforma_igst_final).toFixed(2));
                    $("#original_invoice_value").val(parseFloat(proforma_final1).toFixed(2))
                    $("#original_igst_invoice_value").val(parseFloat(proforma_igst_final).toFixed(2))
                    
                    $('.invalidqtyproformaerror_'+boq_code).val('');      
                    $('.invalidqtyproforma_'+boq_code).addClass('has-error-d');
                    $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Out of Stock!');
                    $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Out of Stock!');
                    
                }
        }else{
            $('#proforma_from_'+boq_code).val('');
            $('#proforma_itaxable_amount_'+boq_code).val('0.00');
            $('#proforma_itotal_amount_'+boq_code).val('0.00');
            $('#proforma_gst_amount_'+boq_code).val('0.00');
            $('#proforma_cgst_amount_'+boq_code).val('0.00');
            $('#proforma_sgst_amount_'+boq_code).val('0.00');
                    
            var proforma_sub_total1 = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total1 += parseFloat($(this).val());
                    });
                    var proforma_sub_total = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total += parseFloat($(this).val());
                    });
                    var proforma_total_gst = 0;
                    $("input[name='proforma_gst_amount[]']").each(function() {
                        proforma_total_gst += parseFloat($(this).val());
                    });
                    
                    var proforma_cgst_total1 = 0;
                    $("input[name='proforma_cgst_amount[]']").each(function() {
                        proforma_cgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_sgst_total1 = 0;
                    $("input[name='proforma_sgst_amount[]']").each(function() {
                        proforma_sgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_final1 = 0;
                    proforma_final1 = parseFloat(proforma_sub_total1) + parseFloat(proforma_sgst_total1) + parseFloat(proforma_cgst_total1);
                    
                    var proforma_igst_final = 0;
                    proforma_igst_final = parseFloat(proforma_sub_total) + parseFloat(proforma_total_gst);
                    $('#proforma_sub_total1').html(parseFloat(proforma_sub_total1).toFixed(2));
                    $('#proforma_sub_total').html(parseFloat(proforma_sub_total).toFixed(2));
                    $('#proforma_cgst_total1').html(parseFloat(proforma_cgst_total1).toFixed(2));
                    $('#proforma_sgst_total1').html(parseFloat(proforma_sgst_total1).toFixed(2));
                    $('#proforma_total_gst').html(parseFloat(proforma_total_gst).toFixed(2));
                    $('#proforma_final1').html(parseFloat(proforma_final1).toFixed(2));
                    $('#proforma_igst_final').html(parseFloat(proforma_igst_final).toFixed(2));
                    $("#original_invoice_value").val(parseFloat(proforma_final1).toFixed(2))
                    $("#original_igst_invoice_value").val(parseFloat(proforma_igst_final).toFixed(2))
                    
                    $('.invalidqtyproformaerror_'+boq_code).val('');      
            $('.invalidqtyproforma_'+boq_code).addClass('has-error-d');
            $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Details Not Exist!');
            $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Details Not Exist!');
            
        }
        $("#billing_split_up").trigger("change");
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});
// $(document).on('click','.addPerfomaInvcRow',function(){  
//     // var gst_type_txt = $('input[name="gst_type_txt"]').val(); 
//     // var gst_type_txt = $('input[name="gst_type"]').val(); 
//     // alert(gst_type_txt);    
//     var maintml = $(this);
//     var project_id = document.getElementById("project_id").value;
//     var boq_code = document.getElementById("proforma_boq_code").value;
//     var hsn_sac_code = document.getElementById("proforma_hsn_sac_code").value;
//     var item_description = document.getElementById("proforma_item_description").value;
//     var unit = document.getElementById("proforma_unit").value;
//     var qty = document.getElementById("proforma_qty").value;
//     var rate = document.getElementById("proforma_rate").value;
//     var itaxable_amount = document.getElementById("proforma_itaxable_amount").value;
//     var gst = document.getElementById("proforma_gst").value;
//     var itotal_amount = document.getElementById("proforma_itotal_amount").value;
//     var gst_amount = document.getElementById("proforma_gst_amount").value;
//     var proforma_from = document.getElementById("proforma_from").value;
    
//     if(gst !== '' && typeof gst !== "undefined" && parseFloat(gst) > 0){
//         gst = gst;    
//     }else{
//         gst = 0;
//     }
//     if(gst_amount !== '' && typeof gst_amount !== "undefined" && parseFloat(gst_amount) > 0){
//         gst_amount = gst_amount;    
//     }else{
//         gst_amount = 0.00;
//     }
//     if(project_id === '' || boq_code === '' || hsn_sac_code === '' || item_description === '' || unit === '' || 
//     qty < 1 || rate < 1){
//         $('.invaliderrorpro').addClass('has-error-p');
//     }else{
//         var base_url = $('#base_url').val().trim();
//         var installed_stock = 0;
//         var provisional_stock = 0;
//         var proforma_stock = 0;
//         var total_stock = 0;
//         var exist_boq_code = '';
//         if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
//             proforma_stock = function () {
//             var tmp_proforma_stock = 0;
//             $.ajax({
//                 'async': false,
//                 'type': "POST",
//                 'global': false,
//                 'dataType': 'json',
//                 'url': completeURL('get_stock_details'),
//                 'data': { 'boq_code': boq_code, 'project_id': project_id},
//                 'success': function (result) {
//                     if(result.proforma_stock !== '' && typeof result.proforma_stock !== "undefined" && parseFloat(result.proforma_stock) > 0){
//                         tmp_proforma_stock = result.proforma_stock;
//                     }else{
//                         tmp_proforma_stock = 0;
//                     }
//                 }
//             });
//             return tmp_proforma_stock;
//             }();
//             total_stock = function () {
//             var tmptotalstock = 0;
//             $.ajax({
//                 'async': false,
//                 'type': "POST",
//                 'global': false,
//                 'dataType': 'json',
//                 'url': completeURL('get_stock_details'),
//                 'data': { 'boq_code': boq_code, 'project_id': project_id},
//                 'success': function (result) {
//                     if(result.total_stock !== '' && typeof result.total_stock !== "undefined" && parseFloat(result.total_stock) > 0){
//                         tmptotalstock = result.total_stock;
//                     }else{
//                         tmptotalstock = 0;
//                     }
//                 }
//             });
//             return tmptotalstock;
//             }();
//             installed_stock = function () {
//             var tmpinstalled = 0;
//             $.ajax({
//                 'async': false,
//                 'type': "POST",
//                 'global': false,
//                 'dataType': 'json',
//                 'url': completeURL('get_stock_details'),
//                 'data': { 'boq_code': boq_code, 'project_id': project_id},
//                 'success': function (result) {
//                     if(result.installed !== '' && typeof result.installed !== "undefined" && parseFloat(result.installed) > 0){
//                         tmpinstalled = result.installed;
//                     }else{
//                         tmpinstalled = 0;
//                     }
//                 }
//             });
//             return tmpinstalled;
//             }();
//             provisional_stock = function () {
//             var tmp_provisional = 0;
//             $.ajax({
//                 'async': false,
//                 'type': "POST",
//                 'global': false,
//                 'dataType': 'json',
//                 'url': completeURL('get_stock_details'),
//                 'data': { 'boq_code': boq_code, 'project_id': project_id},
//                 'success': function (result) {
//                     if(result.provisional !== '' && typeof result.provisional !== "undefined" && parseFloat(result.provisional) > 0){
//                         tmp_provisional = result.provisional;
//                     }else{
//                         tmp_provisional = 0;
//                     }
//                 }
//             });
//             return tmp_provisional;
//             }();
//             exist_boq_code = function () {
//             var tmp1 = null;
//             $.ajax({
//                 'async': false,
//                 'type': "POST",
//                 'global': false,
//                 'dataType': 'json',
//                 'url': completeURL('get_approved_boq_item_details'),
//                 'data': { 'boq_code': boq_code, 'project_id': project_id},
//                 'success': function (result) {
//                     tmp1 = result.boq_code;
//                 }
//             });
//             return tmp1;
//             }();
//         }
//         var final_qty=0;
//         var proforma_from = '';
//         if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
//         && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
//             final_qty = parseInt(installed_stock) + parseInt(provisional_stock); 
//         }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) === 0
//         && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
//             final_qty = parseInt(provisional_stock); 
//         }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
//         && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) === 0){
//             final_qty = parseInt(installed_stock); 
//         }
//         if(parseInt(qty) <= parseInt(installed_stock)){
//             proforma_from = 'installed_stock';
//         }else if(parseInt(qty) <= parseInt(provisional_stock)){
//             proforma_from = 'provisional_stock';
//         }else if(parseInt(qty) <= parseInt(final_qty)){
//             proforma_from = 'both';
//         }
        
//         if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
//             if(parseInt(total_stock) > parseInt(proforma_stock)){
//             if(final_qty !== '' && typeof final_qty !== "undefined" && parseInt(final_qty) > 0){
//                 if(parseInt(qty) <= parseInt(final_qty)){
//                     boq_code_no = [];
//                     $("input[name='proforma_boq_code[]']").each(function(){
//                             boq_code_no.push($(this).val());
//                         });
//                     if ($.inArray(boq_code, boq_code_no) != -1){
//                             $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Details Already Exist!');
//                             $('#proforma_boq_code').val('');
//                             $('#proforma_hsn_sac_code').val('');
//                             $('#proforma_item_description').val('');
//                             $('#proforma_unit').val('');
//                             $('#proforma_qty').val('');
//                             $('#proforma_rate').val('');
//                             $('#proforma_itaxable_amount').val('');
//                             $('#proforma_gst').val('');
//                             $('#proforma_itotal_amount').val('');
//                             $('#proforma_gst_amount').val('');
//                             $('#proforma_hsn_sac_code').prop('readonly', false);
//                             $('#proforma_item_description').prop('readonly', false);
//                             $('#proforma_unit').prop('readonly', false);
//                     }else{
//                         if(parseInt(qty) > 0){
//                                 var html='<tr><td>'
//                                 +'<input type="hidden" id="proforma_from_'+boq_code+'" name="proforma_from[]" value="'+proforma_from+'"><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_boq_code[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_hsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_unit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="text" class="form-control checkproformaqty invalidqtyproformaerror_'+boq_code+' invalidqtyproforma_'+boq_code+'" name="proforma_qty[]" value="'+qty+'" data-id="'+boq_code+'" data-pid="'+project_id+'" style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_rate[]" id="proforma_rate_'+boq_code+'" value="'+rate+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_itaxable_amount[]" id="proforma_itaxable_amount_'+boq_code+'" value="'+itaxable_amount+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_gst[]" id="proforma_gst_'+boq_code+'" value="'+gst+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_itotal_amount[]" id="proforma_itotal_amount_'+boq_code+'" value="'+itotal_amount+'" readonly style="font-size: 12px;width:100%">'
//                                 +'<input type="hidden" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_gst_amount[]" id="proforma_gst_amount_'+boq_code+'" value="'+gst_amount+'" readonly style="font-size: 12px;width:100%"></td>'
//                                 +'<td>'
//                                 +'<div class="addDeleteButton">'
//                                 +'<span class="tooltips deletePerfomaInvcRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
//                                 +'</div></td></tr>';
//                                 $('.invaliderrorpro').removeClass('has-error-d');
//                                 $('#invaliderrorprod').html('');
//                                 $(maintml).parents('#proformainvcdisplay tbody').find("tr:last").before(html);
//                                 $(maintml).parents('#proformainvcexistdisplay tbody').find("tr:last").before(html);
//                                 $('#proforma_boq_code').val('');
//                                 $('#proforma_hsn_sac_code').val('');
//                                 $('#proforma_item_description').val('');
//                                 $('#proforma_unit').val('');
//                                 $('#proforma_qty').val('');
//                                 $('#proforma_rate').val('');
//                                 $('#proforma_itaxable_amount').val('');
//                                 $('#proforma_gst').val('');
//                                 $('#proforma_itotal_amount').val('');
//                                 $('#proforma_gst_amount').val('');
//                                 $('#proforma_hsn_sac_code').prop('readonly', false);
//                                 $('#proforma_item_description').prop('readonly', false);
//                                 $('#proforma_unit').prop('readonly', false);
                                
//                                 var total = 0;
//                                 $("input[name='proforma_itaxable_amount[]']").each(function() {
//                                     total += parseFloat($(this).val());
//                                 });
//                                 var total_gst_amt = 0;
//                                 $("input[name='proforma_gst_amount[]']").each(function() {
//                                     total_gst_amt += parseFloat($(this).val());
//                                 });
//                                 var proforma_igst_final = 0;
//                                 proforma_igst_final = parseFloat(total) + parseFloat(total_gst_amt);
//                                 $('#proforma_sub_total').html(parseFloat(total).toFixed(2));
//                                 $('#proforma_total_gst').html(parseFloat(total_gst_amt).toFixed(2));
//                                 $('#proforma_igst_final').html(parseFloat(proforma_igst_final).toFixed(2));
                             
//                         }else{
//                             $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Invalid Qty!');
//                         }
//                     }   
//                 }else{
//                     $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' qty must be less than equal to '+final_qty+' !');
//                 } 
//             }else{
//                 $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Out of Stock!');
//                 $('#proforma_boq_code').val('');
//                 $('#proforma_hsn_sac_code').val('');
//                 $('#proforma_item_description').val('');
//                 $('#proforma_unit').val('');
//                 $('#proforma_qty').val('');
//                 $('#proforma_rate').val('');
//                 $('#proforma_itaxable_amount').val('');
//                 $('#proforma_gst').val('');
//                 $('#proforma_itotal_amount').val('');
//                 $('#proforma_gst_amount').val('');
//                 $('#proforma_hsn_sac_code').prop('readonly', false);
//                 $('#proforma_item_description').prop('readonly', false);
//                 $('#proforma_unit').prop('readonly', false);
//             }
//             }else{
//                 $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' already Billed!');
//                 $('#proforma_boq_code').val('');
//                 $('#proforma_hsn_sac_code').val('');
//                 $('#proforma_item_description').val('');
//                 $('#proforma_unit').val('');
//                 $('#proforma_qty').val('');
//                 $('#proforma_rate').val('');
//                 $('#proforma_itaxable_amount').val('');
//                 $('#proforma_gst').val('');
//                 $('#proforma_itotal_amount').val('');
//                 $('#proforma_gst_amount').val('');
//                 $('#proforma_hsn_sac_code').prop('readonly', false);
//                 $('#proforma_item_description').prop('readonly', false);
//                 $('#proforma_unit').prop('readonly', false);
//             }
//         }else{
//             $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Details Not Exist!');
//             $('#proforma_boq_code').val('');
//             $('#proforma_hsn_sac_code').val('');
//             $('#proforma_item_description').val('');
//             $('#proforma_unit').val('');
//             $('#proforma_qty').val('');
//             $('#proforma_rate').val('');
//             $('#proforma_itaxable_amount').val('');
//             $('#proforma_gst').val('');
//             $('#proforma_itotal_amount').val('');
//             $('#proforma_gst_amount').val('');
//             $('#proforma_hsn_sac_code').prop('readonly', false);
//             $('#proforma_item_description').prop('readonly', false);
//             $('#proforma_unit').prop('readonly', false);
//         }
//         $("#billing_split_up").trigger("change");
//     }
//     if (jQuery().datepicker) {
//         $('.date-picker').datepicker({
//             dateFormat: "dd-mm-yy",
//             orientation: "right",
//             autoclose: true,
//         });
//     } 
//     Metronic.init();
// });
$(document).on('click','.addPerfomaInvcRow',function(){  
    // var gst_type_txt = $('input[name="gst_type_txt"]').val(); 
    // var gst_type_txt = $('input[name="gst_type"]').val(); 
    // alert(gst_type_txt);    
    var maintml = $(this);
    var project_id = document.getElementById("project_id").value;
    var boq_code = document.getElementById("proforma_boq_code").value;
    var hsn_sac_code = document.getElementById("proforma_hsn_sac_code").value;
    var item_description = document.getElementById("proforma_item_description").value;
    var unit = document.getElementById("proforma_unit").value;
    var qty = document.getElementById("proforma_qty").value;
    var rate = document.getElementById("proforma_rate").value;
    var itaxable_amount = document.getElementById("proforma_itaxable_amount").value;
    var gst = document.getElementById("proforma_gst").value;
    var itotal_amount = document.getElementById("proforma_itotal_amount").value;
    var gst_amount = document.getElementById("proforma_gst_amount").value;
    var proforma_from = document.getElementById("proforma_from").value;
    
    if(gst !== '' && typeof gst !== "undefined" && parseFloat(gst) > 0){
        gst = gst;    
    }else{
        gst = 0;
    }
    if(gst_amount !== '' && typeof gst_amount !== "undefined" && parseFloat(gst_amount) > 0){
        gst_amount = gst_amount;    
    }else{
        gst_amount = 0.00;
    }
    if(project_id === '' || boq_code === '' || hsn_sac_code === '' || item_description === '' || unit === '' || 
    qty < 0 || rate < 1){
        $('.invaliderrorpro').addClass('has-error-p');
    }else{
        var base_url = $('#base_url').val().trim();
        var installed_stock = 0;
        var provisional_stock = 0;
        var proforma_stock = 0;
        var total_stock = 0;
        var exist_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            proforma_stock = function () {
            var tmp_proforma_stock = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.proforma_stock !== '' && typeof result.proforma_stock !== "undefined" && parseFloat(result.proforma_stock) > 0){
                        tmp_proforma_stock = result.proforma_stock;
                    }else{
                        tmp_proforma_stock = 0;
                    }
                }
            });
            return tmp_proforma_stock;
            }();
            total_stock = function () {
            var tmptotalstock = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.total_stock !== '' && typeof result.total_stock !== "undefined" && parseFloat(result.total_stock) > 0){
                        tmptotalstock = result.total_stock;
                    }else{
                        tmptotalstock = 0;
                    }
                }
            });
            return tmptotalstock;
            }();
            installed_stock = function () {
            var tmpinstalled = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.installed !== '' && typeof result.installed !== "undefined" && parseFloat(result.installed) > 0){
                        tmpinstalled = result.installed;
                    }else{
                        tmpinstalled = 0;
                    }
                }
            });
            return tmpinstalled;
            }();
            provisional_stock = function () {
            var tmp_provisional = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.provisional !== '' && typeof result.provisional !== "undefined" && parseFloat(result.provisional) > 0){
                        tmp_provisional = result.provisional;
                    }else{
                        tmp_provisional = 0;
                    }
                }
            });
            return tmp_provisional;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
        }
        var final_qty=0;
        var proforma_from = '';
        if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
            final_qty = parseFloat(installed_stock) + parseFloat(provisional_stock); 
        }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) === 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
            final_qty = parseFloat(provisional_stock); 
        }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) === 0){
            final_qty = parseFloat(installed_stock); 
        }
        if(parseFloat(qty) <= parseFloat(installed_stock)){
            proforma_from = 'installed_stock';
        }else if(parseFloat(qty) <= parseFloat(provisional_stock)){
            proforma_from = 'provisional_stock';
        }else if(parseFloat(qty) <= parseFloat(final_qty)){
            proforma_from = 'both';
        }
        
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
            if(parseFloat(total_stock) > parseFloat(proforma_stock)){
            if(final_qty !== '' && typeof final_qty !== "undefined" && parseFloat(final_qty) > 0){
                if(parseFloat(qty) <= parseFloat(final_qty)){
                    boq_code_no = [];
                    $("input[name='proforma_boq_code[]']").each(function(){
                            boq_code_no.push($(this).val());
                        });
                    if ($.inArray(boq_code, boq_code_no) != -1){
                            $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                            $('#proforma_boq_code').val('');
                            $('#proforma_hsn_sac_code').val('');
                            $('#proforma_item_description').val('');
                            $('#proforma_unit').val('');
                            $('#proforma_qty').val('');
                            $('#proforma_rate').val('');
                            $('#proforma_itaxable_amount').val('');
                            $('#proforma_gst').val('');
                            $('#proforma_itotal_amount').val('');
                            $('#proforma_gst_amount').val('');
                            $('#proforma_hsn_sac_code').prop('readonly', false);
                            $('#proforma_item_description').prop('readonly', false);
                            $('#proforma_unit').prop('readonly', false);
                    }else{
                        if(parseFloat(qty) > 0){
                                var html='<tr><td>'
                                +'<input type="hidden" id="proforma_from_'+boq_code+'" name="proforma_from[]" value="'+proforma_from+'"><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_boq_code[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_hsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_unit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control checkproformaqty invalidqtyproformaerror_'+boq_code+' invalidqtyproforma_'+boq_code+'" name="proforma_qty[]" value="'+qty+'" data-id="'+boq_code+'" data-pid="'+project_id+'" style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_rate[]" id="proforma_rate_'+boq_code+'" value="'+rate+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_itaxable_amount[]" id="proforma_itaxable_amount_'+boq_code+'" value="'+itaxable_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_gst[]" id="proforma_gst_'+boq_code+'" value="'+gst+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_itotal_amount[]" id="proforma_itotal_amount_'+boq_code+'" value="'+itotal_amount+'" readonly style="font-size: 12px;width:100%">'
                                +'<input type="hidden" class="form-control invalidqtyproforma_'+boq_code+'" name="proforma_gst_amount[]" id="proforma_gst_amount_'+boq_code+'" value="'+gst_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td>'
                                +'<div class="addDeleteButton">'
                                +'<span class="tooltips deletePerfomaInvcRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                                +'</div></td></tr>';
                                $('.invaliderrorpro').removeClass('has-error-d');
                                $('#invaliderrorprod').html('');
                                $(maintml).parents('#proformainvcdisplay tbody').find("tr:last").before(html);
                                $(maintml).parents('#proformainvcexistdisplay tbody').find("tr:last").before(html);
                                $('#proforma_boq_code').val('');
                                $('#proforma_hsn_sac_code').val('');
                                $('#proforma_item_description').val('');
                                $('#proforma_unit').val('');
                                $('#proforma_qty').val('');
                                $('#proforma_rate').val('');
                                $('#proforma_itaxable_amount').val('');
                                $('#proforma_gst').val('');
                                $('#proforma_itotal_amount').val('');
                                $('#proforma_gst_amount').val('');
                                $('#proforma_hsn_sac_code').prop('readonly', false);
                                $('#proforma_item_description').prop('readonly', false);
                                $('#proforma_unit').prop('readonly', false);
                                
                                var total = 0;
                                $("input[name='proforma_itaxable_amount[]']").each(function() {
                                    total += parseFloat($(this).val());
                                });
                                var total_gst_amt = 0;
                                $("input[name='proforma_gst_amount[]']").each(function() {
                                    total_gst_amt += parseFloat($(this).val());
                                });
                                var proforma_igst_final = 0;
                                proforma_igst_final = parseFloat(total) + parseFloat(total_gst_amt);
                                $('#proforma_sub_total').html(parseFloat(total).toFixed(2));
                                $('#proforma_total_gst').html(parseFloat(total_gst_amt).toFixed(2));
                                $('#proforma_igst_final').html(parseFloat(proforma_igst_final).toFixed(2));
                                $("#original_invoice_value").val(0)
                                $("#original_igst_invoice_value").val(proforma_igst_final.toFixed(2))
                             
                        }else{
                            $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Invalid Qty!');
                        }
                    }   
                }else{
                    $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' qty must be less than equal to '+final_qty+' !');
                } 
            }else{
                $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Out of Stock!');
                $('#proforma_boq_code').val('');
                $('#proforma_hsn_sac_code').val('');
                $('#proforma_item_description').val('');
                $('#proforma_unit').val('');
                $('#proforma_qty').val('');
                $('#proforma_rate').val('');
                $('#proforma_itaxable_amount').val('');
                $('#proforma_gst').val('');
                $('#proforma_itotal_amount').val('');
                $('#proforma_gst_amount').val('');
                $('#proforma_hsn_sac_code').prop('readonly', false);
                $('#proforma_item_description').prop('readonly', false);
                $('#proforma_unit').prop('readonly', false);
            }
            }else{
                $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' already Billed!');
                $('#proforma_boq_code').val('');
                $('#proforma_hsn_sac_code').val('');
                $('#proforma_item_description').val('');
                $('#proforma_unit').val('');
                $('#proforma_qty').val('');
                $('#proforma_rate').val('');
                $('#proforma_itaxable_amount').val('');
                $('#proforma_gst').val('');
                $('#proforma_itotal_amount').val('');
                $('#proforma_gst_amount').val('');
                $('#proforma_hsn_sac_code').prop('readonly', false);
                $('#proforma_item_description').prop('readonly', false);
                $('#proforma_unit').prop('readonly', false);
            }
        }else{
            $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Details Not Exist!');
            $('#proforma_boq_code').val('');
            $('#proforma_hsn_sac_code').val('');
            $('#proforma_item_description').val('');
            $('#proforma_unit').val('');
            $('#proforma_qty').val('');
            $('#proforma_rate').val('');
            $('#proforma_itaxable_amount').val('');
            $('#proforma_gst').val('');
            $('#proforma_itotal_amount').val('');
            $('#proforma_gst_amount').val('');
            $('#proforma_hsn_sac_code').prop('readonly', false);
            $('#proforma_item_description').prop('readonly', false);
            $('#proforma_unit').prop('readonly', false);
        }
        $("#billing_split_up").trigger("change");
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});

//Tax Invoice
$(document).on('keyup', '#taxinvoice_boq_code,#taxinvoice_boq_code1', function() {
    $('#invaliderrorprod').html('');
    $('#invaliderrorprod1').html('');
    var boq_code = $(this).val();
    var project_id = $('#project_id').val();
    var gst_type = $('#gst_type').val();
    var installed_stock = 0;
    var provisional_stock = 0;
    var exist_tax_boq_code = '';
    if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
        installed_stock = function () {
            var tmpinstalled = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.installed !== '' && typeof result.installed !== "undefined"){
                        tmpinstalled = result.installed;
                    }else{
                        tmpinstalled = 0;
                    }
                }
            });
            return tmpinstalled;
            }();
        provisional_stock = function () {
            var tmp_provisional = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.provisional !== '' && typeof result.provisional !== "undefined"){
                        tmp_provisional = result.provisional;
                    }else{
                        tmp_provisional = 0;
                    }
                }
            });
            return tmp_provisional;
            }();
        exist_tax_boq_code = function () {
            var tmp_proforma = '';
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_tax_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp_proforma = result.boq_status;
                    
                }
            });
            return tmp_proforma;
            }();
    }
    var allowed = 'N';
    if(exist_tax_boq_code !== '' && typeof exist_tax_boq_code !== "undefined"){
        if(exist_tax_boq_code === 'approved'){
            allowed = 'Y';
        }else{
            allowed = 'N';    
        }
    }else{
        allowed = 'Y';
    }
    var final_qty=0;
    if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
    && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
        final_qty = parseInt(installed_stock) + parseInt(provisional_stock); 
    }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) === 0
    && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
        final_qty = parseInt(provisional_stock); 
    }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
    && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) === 0){
        final_qty = parseInt(installed_stock); 
    }
    if(boq_code !== '' && typeof boq_code !== "undefined" && project_id !== '' && typeof project_id !== "undefined"
     && gst_type !== '' && typeof gst_type !== "undefined"){
        if(final_qty !== '' && typeof final_qty !== "undefined" && parseFloat(final_qty) > 0){
            $.ajax({
                    type:'POST',
                    url:completeURL('get_approved_boq_item_details'), 
                    dataType:'json',
                    data:{project_id:project_id,boq_code:boq_code},
                    success:function(result){
                        if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){
                            if(allowed !== '' && typeof allowed !== "undefined" && allowed === 'Y'){
                                $('#taxinvoice_boq_code').val(result.boq_code);    
                                $('#proforma_hsn_sac_code').val(result.hsn_sac_code);    
                                $('#proforma_hsn_sac_code').prop('readonly', true);
                                $('#proforma_item_description').val(result.item_description);
                                $('#proforma_item_description').prop('readonly', true);
                                $('#proforma_unit').val(result.unit);    
                                $('#proforma_unit').prop('readonly', true);
                                $('#proforma_qty').val(final_qty);    
                                $('#proforma_rate').val(result.rate_basic);  
                                
                                var proforma_itaxable_amount = 0;
                                if(final_qty !== '' && typeof final_qty !== "undefined" && parseFloat(final_qty) > 0
                                && result.rate_basic !== '' && typeof result.rate_basic !== "undefined" && parseFloat(result.rate_basic) > 0){
                                    proforma_itaxable_amount = parseFloat(final_qty) * parseFloat(result.rate_basic);
                                }
                                $('#proforma_itaxable_amount').val(proforma_itaxable_amount);
                                
                                var proforma_gst = 0;
                                var proforma_itotal_amt = 0;
                                var proforma_gst_amt = 0;
                                if(proforma_itaxable_amount !== '' && typeof proforma_itaxable_amount !== "undefined" && parseFloat(proforma_itaxable_amount) > 0 && 
                                result.gst !== '' && typeof result.gst !== "undefined" && parseFloat(result.gst) > 0){
                                    proforma_gst = parseFloat(result.gst);
                                    proforma_itotal_amt = (parseFloat(proforma_itaxable_amount) * (proforma_gst/100)) + parseFloat(proforma_itaxable_amount);
                                    proforma_gst_amt = parseFloat(proforma_itaxable_amount) * (proforma_gst/100);
                                }
                                $('#proforma_gst').val(proforma_gst);
                                $('#proforma_itotal_amount').val(proforma_gst_amt);
                                $('#proforma_gst_amount').val(proforma_gst_amt);
                                
                                
                                var proforma_sgst = 0;
                                var proforma_sgst_amt = 0;
                                if(proforma_itaxable_amount !== '' && typeof proforma_itaxable_amount !== "undefined" && parseFloat(proforma_itaxable_amount) > 0 && 
                                result.gst !== '' && typeof result.gst !== "undefined" && parseFloat(result.gst) > 0){
                                    proforma_sgst = parseFloat(result.gst)/2;
                                    proforma_sgst_amt = parseFloat(proforma_itaxable_amount) * (proforma_sgst/100);
                                }
                                $('#proforma_sgst1').val(proforma_sgst);
                                $('#proforma_sgst_amount1').val(proforma_sgst_amt);
                                
                                var proforma_cgst = 0;
                                var proforma_cgst_amt = 0;
                                if(proforma_itaxable_amount !== '' && typeof proforma_itaxable_amount !== "undefined" && parseFloat(proforma_itaxable_amount) > 0 && 
                                result.gst !== '' && typeof result.gst !== "undefined" && parseFloat(result.gst) > 0){
                                    proforma_cgst = parseFloat(result.gst)/2;
                                    proforma_cgst_amt = parseFloat(proforma_itaxable_amount) * (proforma_cgst/100);
                                }
                                $('#proforma_cgst1').val(proforma_cgst);
                                $('#proforma_cgst_amount1').val(proforma_cgst_amt);
                                
                                $('#taxinvoice_boq_code1').val(result.boq_code);    
                                $('#proforma_hsn_sac_code1').val(result.hsn_sac_code);    
                                $('#proforma_hsn_sac_code1').prop('readonly', true);
                                $('#proforma_item_description1').val(result.item_description);
                                $('#proforma_item_description1').prop('readonly', true);
                                $('#proforma_unit1').val(result.unit);    
                                $('#proforma_unit1').prop('readonly', true);
                                $('#proforma_qty1').val(final_qty);    
                                $('#proforma_rate1').val(result.rate_basic);  
                                $('#proforma_itaxable_amount1').val(proforma_itaxable_amount);
                            }else{    
                                $('#taxinvoice_boq_code').val('');    
                                $('#proforma_hsn_sac_code').val('');    
                                $('#proforma_hsn_sac_code').prop('readonly', false);
                                $('#proforma_item_description').val('');
                                $('#proforma_item_description').prop('readonly', false);
                                $('#proforma_unit').val('');    
                                $('#proforma_unit').prop('readonly', false);
                                $('#proforma_qty').val('');    
                                $('#proforma_rate').val('');    
                                $('#proforma_itaxable_amount').val('');    
                                $('#proforma_itotal_amount').val('');
                                
                                $('#taxinvoice_boq_code1').val('');    
                                $('#proforma_hsn_sac_code1').val('');    
                                $('#proforma_hsn_sac_code1').prop('readonly', false);
                                $('#proforma_item_description1').val('');
                                $('#proforma_item_description1').prop('readonly', false);
                                $('#proforma_unit1').val('');    
                                $('#proforma_unit1').prop('readonly', false);
                                $('#proforma_qty1').val('');    
                                $('#proforma_rate1').val('');    
                                $('#proforma_itaxable_amount1').val('');    
                                $('#proforma_itotal_amount1').val('');
                                $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Pending for Approval!');  
                                $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Pending for Approval!');  
                            }     
                        }else{    
                            $('#taxinvoice_boq_code').val('');    
                            $('#proforma_hsn_sac_code').val('');    
                            $('#proforma_hsn_sac_code').prop('readonly', false);
                            $('#proforma_item_description').val('');
                            $('#proforma_item_description').prop('readonly', false);
                            $('#proforma_unit').val('');    
                            $('#proforma_unit').prop('readonly', false);
                            $('#proforma_qty').val('');    
                            $('#proforma_rate').val('');    
                            $('#proforma_itaxable_amount').val('');    
                            $('#proforma_itotal_amount').val('');
                            
                            $('#taxinvoice_boq_code1').val('');    
                            $('#proforma_hsn_sac_code1').val('');    
                            $('#proforma_hsn_sac_code1').prop('readonly', false);
                            $('#proforma_item_description1').val('');
                            $('#proforma_item_description1').prop('readonly', false);
                            $('#proforma_unit1').val('');    
                            $('#proforma_unit1').prop('readonly', false);
                            $('#proforma_qty1').val('');    
                            $('#proforma_rate1').val('');    
                            $('#proforma_itaxable_amount1').val('');    
                            $('#proforma_itotal_amount1').val('');  
                        }        
                    }
            });    
        }else{
            $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' not available for billing!');  
            $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' not available for billing!');  
        }
    }else{
        $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' not available for billing!');  
        $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' not available for billing!');  
    }
});
$(document).on('click','.addTaxInvoiceRow',function(){        
    var maintml = $(this);
    var project_id = document.getElementById("project_id").value;
    var boq_code = document.getElementById("taxinvoice_boq_code").value;
    var hsn_sac_code = document.getElementById("proforma_hsn_sac_code").value;
    var item_description = document.getElementById("proforma_item_description").value;
    var unit = document.getElementById("proforma_unit").value;
    var qty = document.getElementById("proforma_qty").value;
    var rate = document.getElementById("proforma_rate").value;
    var itaxable_amount = document.getElementById("proforma_itaxable_amount").value;
    var gst = document.getElementById("proforma_gst").value;
    var itotal_amount = document.getElementById("proforma_itotal_amount").value;
    var gst_amount = document.getElementById("proforma_gst_amount").value;
    var proforma_from = document.getElementById("proforma_from").value;
    
    if(gst !== '' && typeof gst !== "undefined" && parseFloat(gst) > 0){
        gst = gst;    
    }else{
        gst = 0;
    }
    if(gst_amount !== '' && typeof gst_amount !== "undefined" && parseFloat(gst_amount) > 0){
        gst_amount = gst_amount;    
    }else{
        gst_amount = 0.00;
    }
    if(project_id === '' || boq_code === '' || hsn_sac_code === '' || item_description === '' || unit === '' || 
    qty < 1 || rate < 1){
        $('.invaliderrorpro').addClass('has-error-p');
    }else{
        var base_url = $('#base_url').val().trim();
        var installed_stock = 0;
        var provisional_stock = 0;
        var exist_boq_code = '';
        var exist_tax_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
        installed_stock = function () {
            var tmpinstalled = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.installed !== '' && typeof result.installed !== "undefined"){
                        tmpinstalled = result.installed;
                    }else{
                        tmpinstalled = 0;
                    }
                }
            });
            return tmpinstalled;
            }();
        provisional_stock = function () {
            var tmp_provisional = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.provisional !== '' && typeof result.provisional !== "undefined"){
                        tmp_provisional = result.provisional;
                    }else{
                        tmp_provisional = 0;
                    }
                }
            });
            return tmp_provisional;
            }();
        exist_tax_boq_code = function () {
            var tmp_proforma = '';
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_tax_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp_proforma = result.boq_status;
                    
                }
            });
            return tmp_proforma;
            }();
        exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
        }
        var allowed = 'N';
        if(exist_tax_boq_code !== '' && typeof exist_tax_boq_code !== "undefined"){
            if(exist_tax_boq_code === 'approved'){
                allowed = 'Y';
            }else{
                allowed = 'N';    
            }
        }else{
            allowed = 'Y';
        }
        var final_qty=0;
        var proforma_from = '';
        if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
            final_qty = parseInt(installed_stock) + parseInt(provisional_stock); 
        }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) === 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
            final_qty = parseInt(provisional_stock); 
        }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) === 0){
            final_qty = parseInt(installed_stock); 
        }
        if(parseInt(qty) <= parseInt(installed_stock)){
            proforma_from = 'installed_stock';
        }else if(parseInt(qty) <= parseInt(provisional_stock)){
            proforma_from = 'provisional_stock';
        }else if(parseInt(qty) <= parseInt(final_qty)){
            proforma_from = 'both';
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
            if(allowed !== '' && typeof allowed !== "undefined" && allowed === 'Y'){
            if(final_qty !== '' && typeof final_qty !== "undefined" && parseInt(final_qty) > 0){
                if(parseInt(qty) <= parseInt(final_qty)){
                boq_code_no = [];
                $("input[name='taxinvoice_boq_code[]']").each(function(){
                        boq_code_no.push($(this).val());
                    });
                if ($.inArray(boq_code, boq_code_no) != -1){
                        $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                        $('#taxinvoice_boq_code').val('');
                        $('#proforma_hsn_sac_code').val('');
                        $('#proforma_item_description').val('');
                        $('#proforma_unit').val('');
                        $('#proforma_qty').val('');
                        $('#proforma_rate').val('');
                        $('#proforma_itaxable_amount').val('');
                        $('#proforma_gst').val('');
                        $('#proforma_itotal_amount').val('');
                        $('#proforma_gst_amount').val('');
                        $('#proforma_hsn_sac_code').prop('readonly', false);
                        $('#proforma_item_description').prop('readonly', false);
                        $('#proforma_unit').prop('readonly', false);
                }else{
                    if(parseInt(qty) > 0){
                            var html='<tr><td>'
                            +'<input type="hidden" id="proforma_from_'+boq_code+'" name="proforma_from[]" value="'+proforma_from+'"><input type="text" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="taxinvoice_boq_code[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_hsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_unit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control checktaxinvoiceqty invalidqtytaxinvoiceerror_'+boq_code+' invalidqtytaxinvoice_'+boq_code+'" name="proforma_qty[]" value="'+qty+'" data-id="'+boq_code+'" data-pid="'+project_id+'" style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_rate[]" id="proforma_rate_'+boq_code+'" value="'+rate+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_itaxable_amount[]" id="proforma_itaxable_amount_'+boq_code+'" value="'+itaxable_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_gst[]" id="proforma_gst_'+boq_code+'" value="'+gst+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_itotal_amount[]" id="proforma_itotal_amount_'+boq_code+'" value="'+itotal_amount+'" readonly style="font-size: 12px;width:100%">'
                            +'<input type="hidden" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_gst_amount[]" id="proforma_gst_amount_'+boq_code+'" value="'+gst_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td>'
                            +'<div class="addDeleteButton">'
                            +'<span class="tooltips deletePerfomaInvcRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                            +'</div></td></tr>';
                            $('.invaliderrorpro').removeClass('has-error-d');
                            $('#invaliderrorprod').html('');
                            $(maintml).parents('#proformainvcdisplay tbody').find("tr:last").before(html);
                            $(maintml).parents('#proformainvcexistdisplay tbody').find("tr:last").before(html);
                            $('#taxinvoice_boq_code').val('');
                            $('#proforma_hsn_sac_code').val('');
                            $('#proforma_item_description').val('');
                            $('#proforma_unit').val('');
                            $('#proforma_qty').val('');
                            $('#proforma_rate').val('');
                            $('#proforma_itaxable_amount').val('');
                            $('#proforma_gst').val('');
                            $('#proforma_itotal_amount').val('');
                            $('#proforma_gst_amount').val('');
                            $('#proforma_hsn_sac_code').prop('readonly', false);
                            $('#proforma_item_description').prop('readonly', false);
                            $('#proforma_unit').prop('readonly', false);
                            
                            var total = 0;
                            $("input[name='proforma_itaxable_amount[]']").each(function() {
                                total += parseFloat($(this).val());
                            });
                            var total_gst_amt = 0;
                            $("input[name='proforma_gst_amount[]']").each(function() {
                                total_gst_amt += parseFloat($(this).val());
                            });
                            var proforma_igst_final = 0;
                            proforma_igst_final = parseFloat(total) + parseFloat(total_gst_amt);
                            $('#proforma_sub_total').html(parseFloat(total).toFixed(2));
                            $('#proforma_total_gst').html(parseFloat(total_gst_amt).toFixed(2));
                            $('#proforma_igst_final').html(parseFloat(proforma_igst_final).toFixed(2));
                    }else{
                        $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Invalid Qty!');
                    }
                }   
                }else{
                    $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+final_qty+' !');
                } 
            }else{
                $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Out of Stock!');
                $('#taxinvoice_boq_code').val('');
                $('#proforma_from').val('');
                $('#proforma_hsn_sac_code').val('');
                $('#proforma_item_description').val('');
                $('#proforma_unit').val('');
                $('#proforma_qty').val('');
                $('#proforma_rate').val('');
                $('#proforma_itaxable_amount').val('');
                $('#proforma_gst').val('');
                $('#proforma_itotal_amount').val('');
                $('#proforma_gst_amount').val('');
                $('#proforma_hsn_sac_code').prop('readonly', false);
                $('#proforma_item_description').prop('readonly', false);
                $('#proforma_unit').prop('readonly', false);
            }
            }else{
            $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Pending for Approval!');
            $('#proforma_from').val('');
            $('#taxinvoice_boq_code').val('');
            $('#proforma_hsn_sac_code').val('');
            $('#proforma_item_description').val('');
            $('#proforma_unit').val('');
            $('#proforma_qty').val('');
            $('#proforma_rate').val('');
            $('#proforma_itaxable_amount').val('');
            $('#proforma_gst').val('');
            $('#proforma_itotal_amount').val('');
            $('#proforma_gst_amount').val('');
            $('#proforma_hsn_sac_code').prop('readonly', false);
            $('#proforma_item_description').prop('readonly', false);
            $('#proforma_unit').prop('readonly', false);
        }
        }else{
            $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Details Not Exist!');
            $('#taxinvoice_boq_code').val('');
            $('#proforma_from').val('');
            $('#proforma_hsn_sac_code').val('');
            $('#proforma_item_description').val('');
            $('#proforma_unit').val('');
            $('#proforma_qty').val('');
            $('#proforma_rate').val('');
            $('#proforma_itaxable_amount').val('');
            $('#proforma_gst').val('');
            $('#proforma_itotal_amount').val('');
            $('#proforma_gst_amount').val('');
            $('#proforma_hsn_sac_code').prop('readonly', false);
            $('#proforma_item_description').prop('readonly', false);
            $('#proforma_unit').prop('readonly', false);
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});
$(document).on('keyup','.checktaxinvoiceqty',function(){        
    var maintml = $(this);
    var qty = $(this).val();
    var boq_code = $(this).attr('data-id');
    var project_id = $(this).attr('data-pid');
    if(project_id === '' || boq_code === '' || qty < 0){
        $('.invalidqtytaxinvoice_'+boq_code).addClass('has-error-d');
    }else{
        var base_url = $('#base_url').val().trim();
        var installed_stock = 0;
        var provisional_stock = 0;
        var exist_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            installed_stock = function () {
            var tmpinstalled = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.installed !== '' && typeof result.installed !== "undefined"){
                        tmpinstalled = result.installed;
                    }else{
                        tmpinstalled = 0;
                    }
                }
            });
            return tmpinstalled;
            }();
            provisional_stock = function () {
            var tmp_provisional = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.provisional !== '' && typeof result.provisional !== "undefined"){
                        tmp_provisional = result.provisional;
                    }else{
                        tmp_provisional = 0;
                    }
                }
            });
            return tmp_provisional;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
        }
        var final_qty=0;
        var proforma_from = '';
        if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
            final_qty = parseInt(installed_stock) + parseInt(provisional_stock); 
        }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) === 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
            final_qty = parseInt(provisional_stock); 
        }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) === 0){
            final_qty = parseInt(installed_stock); 
        }
        if(parseInt(qty) <= parseInt(installed_stock)){
            proforma_from = 'installed_stock';
        }else if(parseInt(qty) <= parseInt(provisional_stock)){
            proforma_from = 'provisional_stock';
        }else if(parseInt(qty) <= parseInt(final_qty)){
            proforma_from = 'both';
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
            if(parseInt(final_qty) > 0 && $.isNumeric(final_qty)){
                if(parseInt(qty) <= parseInt(final_qty)){
                    $('#proforma_from'+boq_code).val(proforma_from);
                    var itaxable_amount = 0;
                    var itotal_amount = 0;
                    var rate = $('#proforma_rate_'+boq_code).val();
                    var gst = $('#proforma_gst_'+boq_code).val();
                    var gst_amount = 0;
                    if(qty !== '' && typeof qty !== "undefined" && parseFloat(qty) > 0){
                        qty = qty;
                    }else{
                        qty = 0;
                    }
                    if(rate !== '' && typeof rate !== "undefined" && parseFloat(rate) > 0 && parseFloat(qty) > 0){
                        itaxable_amount = parseFloat(rate) * parseFloat(qty);    
                    }
                    if(gst !== '' && typeof gst !== "undefined" && parseFloat(gst) > 0
                    && itaxable_amount !== '' && typeof itaxable_amount !== "undefined" && parseFloat(itaxable_amount) > 0){
                        gst_amount = parseFloat(itaxable_amount) * (parseFloat(gst)/100);    
                    }
                    var cgst_amount = 0;
                    var cgst = $('#proforma_cgst_'+boq_code).val();
                    if(cgst !== '' && typeof cgst !== "undefined" && parseFloat(cgst) > 0
                    && itaxable_amount !== '' && typeof itaxable_amount !== "undefined" && parseFloat(itaxable_amount) > 0){
                        cgst_amount = parseFloat(itaxable_amount) * (parseFloat(cgst)/100);    
                    }
                    var sgst_amount = 0;
                    var sgst = $('#proforma_sgst_'+boq_code).val();
                    if(sgst !== '' && typeof sgst !== "undefined" && parseFloat(sgst) > 0
                    && itaxable_amount !== '' && typeof itaxable_amount !== "undefined" && parseFloat(itaxable_amount) > 0){
                        sgst_amount = parseFloat(itaxable_amount) * (parseFloat(sgst)/100);    
                    }
                    itotal_amount = parseFloat(itaxable_amount) + parseFloat(gst_amount);    
                    $('#proforma_itaxable_amount_'+boq_code).val(itaxable_amount.toFixed(2));
                    $('#proforma_itotal_amount_'+boq_code).val(itotal_amount.toFixed(2));
                    $('#proforma_gst_amount_'+boq_code).val(gst_amount.toFixed(2));
                    $('#proforma_cgst_amount_'+boq_code).val(cgst_amount.toFixed(2));
                    $('#proforma_sgst_amount_'+boq_code).val(sgst_amount.toFixed(2));
                    
                    var proforma_sub_total1 = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total1 += parseFloat($(this).val());
                    });
                    var proforma_sub_total = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total += parseFloat($(this).val());
                    });
                    var proforma_total_gst = 0;
                    $("input[name='proforma_gst_amount[]']").each(function() {
                        proforma_total_gst += parseFloat($(this).val());
                    });
                    
                    var proforma_cgst_total1 = 0;
                    $("input[name='proforma_cgst_amount[]']").each(function() {
                        proforma_cgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_sgst_total1 = 0;
                    $("input[name='proforma_sgst_amount[]']").each(function() {
                        proforma_sgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_final1 = 0;
                    proforma_final1 = parseFloat(proforma_sub_total1) + parseFloat(proforma_sgst_total1) + parseFloat(proforma_cgst_total1);
                    
                    var proforma_igst_final = 0;
                    proforma_igst_final = parseFloat(proforma_sub_total) + parseFloat(proforma_total_gst);
                    $('#proforma_sub_total1').html(parseFloat(proforma_sub_total1).toFixed(2));
                    $('#proforma_sub_total').html(parseFloat(proforma_sub_total).toFixed(2));
                    $('#proforma_cgst_total1').html(parseFloat(proforma_cgst_total1).toFixed(2));
                    $('#proforma_sgst_total1').html(parseFloat(proforma_sgst_total1).toFixed(2));
                    $('#proforma_total_gst').html(parseFloat(proforma_total_gst).toFixed(2));
                    $('#proforma_final1').html(parseFloat(proforma_final1).toFixed(2));
                    $('#proforma_igst_final').html(parseFloat(proforma_igst_final).toFixed(2));
                    $('.invalidqtytaxinvoiceerror_'+boq_code).val(qty);  
                    $('.invalidqtytaxinvoice_'+boq_code).removeClass('has-error-d');
                    $('#invaliderrorprod1').html('');
                    $('#invaliderrorprod').html('');
                }else{
                    $('#proforma_from'+boq_code).val('');
                    $('#proforma_itaxable_amount_'+boq_code).val('0.00');
                    $('#proforma_itotal_amount_'+boq_code).val('0.00');
                    $('#proforma_gst_amount_'+boq_code).val('0.00');
                    $('#proforma_cgst_amount_'+boq_code).val('0.00');
                    $('#proforma_sgst_amount_'+boq_code).val('0.00');
                    
                    var proforma_sub_total1 = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total1 += parseFloat($(this).val());
                    });
                    var proforma_sub_total = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total += parseFloat($(this).val());
                    });
                    var proforma_total_gst = 0;
                    $("input[name='proforma_gst_amount[]']").each(function() {
                        proforma_total_gst += parseFloat($(this).val());
                    });
                    
                    var proforma_cgst_total1 = 0;
                    $("input[name='proforma_cgst_amount[]']").each(function() {
                        proforma_cgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_sgst_total1 = 0;
                    $("input[name='proforma_sgst_amount[]']").each(function() {
                        proforma_sgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_final1 = 0;
                    proforma_final1 = parseFloat(proforma_sub_total1) + parseFloat(proforma_sgst_total1) + parseFloat(proforma_cgst_total1);
                    
                    var proforma_igst_final = 0;
                    proforma_igst_final = parseFloat(proforma_sub_total) + parseFloat(proforma_total_gst);
                    $('#proforma_sub_total1').html(parseFloat(proforma_sub_total1).toFixed(2));
                    $('#proforma_sub_total').html(parseFloat(proforma_sub_total).toFixed(2));
                    $('#proforma_cgst_total1').html(parseFloat(proforma_cgst_total1).toFixed(2));
                    $('#proforma_sgst_total1').html(parseFloat(proforma_sgst_total1).toFixed(2));
                    $('#proforma_total_gst').html(parseFloat(proforma_total_gst).toFixed(2));
                    $('#proforma_final1').html(parseFloat(proforma_final1).toFixed(2));
                    $('#proforma_igst_final').html(parseFloat(proforma_igst_final).toFixed(2));
                    
                    $('.invalidqtytaxinvoiceerror_'+boq_code).val('');      
                    $('.invalidqtytaxinvoice_'+boq_code).addClass('has-error-d');
                    $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' qty must be less than equal to '+final_qty+' !');
                    $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' qty must be less than equal to '+final_qty+' !');
                }
            }else{
                    $('#proforma_from'+boq_code).val('');
                    $('#proforma_itaxable_amount_'+boq_code).val('0.00');
                    $('#proforma_itotal_amount_'+boq_code).val('0.00');
                    $('#proforma_gst_amount_'+boq_code).val('0.00');
                    $('#proforma_cgst_amount_'+boq_code).val('0.00');
                    $('#proforma_sgst_amount_'+boq_code).val('0.00');
                    
                    var proforma_sub_total1 = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total1 += parseFloat($(this).val());
                    });
                    var proforma_sub_total = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total += parseFloat($(this).val());
                    });
                    var proforma_total_gst = 0;
                    $("input[name='proforma_gst_amount[]']").each(function() {
                        proforma_total_gst += parseFloat($(this).val());
                    });
                    
                    var proforma_cgst_total1 = 0;
                    $("input[name='proforma_cgst_amount[]']").each(function() {
                        proforma_cgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_sgst_total1 = 0;
                    $("input[name='proforma_sgst_amount[]']").each(function() {
                        proforma_sgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_final1 = 0;
                    proforma_final1 = parseFloat(proforma_sub_total1) + parseFloat(proforma_sgst_total1) + parseFloat(proforma_cgst_total1);
                    
                    var proforma_igst_final = 0;
                    proforma_igst_final = parseFloat(proforma_sub_total) + parseFloat(proforma_total_gst);
                    $('#proforma_sub_total1').html(parseFloat(proforma_sub_total1).toFixed(2));
                    $('#proforma_sub_total').html(parseFloat(proforma_sub_total).toFixed(2));
                    $('#proforma_cgst_total1').html(parseFloat(proforma_cgst_total1).toFixed(2));
                    $('#proforma_sgst_total1').html(parseFloat(proforma_sgst_total1).toFixed(2));
                    $('#proforma_total_gst').html(parseFloat(proforma_total_gst).toFixed(2));
                    $('#proforma_final1').html(parseFloat(proforma_final1).toFixed(2));
                    $('#proforma_igst_final').html(parseFloat(proforma_igst_final).toFixed(2));
                    
                    $('.invalidqtytaxinvoiceerror_'+boq_code).val('');      
                    $('.invalidqtytaxinvoice_'+boq_code).addClass('has-error-d');
                    $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Out of Stock!');
                    $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Out of Stock!');
                }
        }else{
            $('#proforma_from'+boq_code).val('');
            $('#proforma_itaxable_amount_'+boq_code).val('0.00');
            $('#proforma_itotal_amount_'+boq_code).val('0.00');
            $('#proforma_gst_amount_'+boq_code).val('0.00');
            $('#proforma_cgst_amount_'+boq_code).val('0.00');
            $('#proforma_sgst_amount_'+boq_code).val('0.00');
                    
            var proforma_sub_total1 = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total1 += parseFloat($(this).val());
                    });
                    var proforma_sub_total = 0;
                    $("input[name='proforma_itaxable_amount[]']").each(function() {
                        proforma_sub_total += parseFloat($(this).val());
                    });
                    var proforma_total_gst = 0;
                    $("input[name='proforma_gst_amount[]']").each(function() {
                        proforma_total_gst += parseFloat($(this).val());
                    });
                    
                    var proforma_cgst_total1 = 0;
                    $("input[name='proforma_cgst_amount[]']").each(function() {
                        proforma_cgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_sgst_total1 = 0;
                    $("input[name='proforma_sgst_amount[]']").each(function() {
                        proforma_sgst_total1 += parseFloat($(this).val());
                    });
                    var proforma_final1 = 0;
                    proforma_final1 = parseFloat(proforma_sub_total1) + parseFloat(proforma_sgst_total1) + parseFloat(proforma_cgst_total1);
                    
                    var proforma_igst_final = 0;
                    proforma_igst_final = parseFloat(proforma_sub_total) + parseFloat(proforma_total_gst);
                    $('#proforma_sub_total1').html(parseFloat(proforma_sub_total1).toFixed(2));
                    $('#proforma_sub_total').html(parseFloat(proforma_sub_total).toFixed(2));
                    $('#proforma_cgst_total1').html(parseFloat(proforma_cgst_total1).toFixed(2));
                    $('#proforma_sgst_total1').html(parseFloat(proforma_sgst_total1).toFixed(2));
                    $('#proforma_total_gst').html(parseFloat(proforma_total_gst).toFixed(2));
                    $('#proforma_final1').html(parseFloat(proforma_final1).toFixed(2));
                    $('#proforma_igst_final').html(parseFloat(proforma_igst_final).toFixed(2));
                    
                    $('.invalidqtytaxinvoiceerror_'+boq_code).val('');      
            $('.invalidqtytaxinvoice_'+boq_code).addClass('has-error-d');
            $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Details Not Exist!');
            $('#invaliderrorprod').html('BOQ Sr No '+boq_code+' Details Not Exist!');
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});
$(document).on('click','.addTaxInvoiceRow1',function(){        
    var maintml = $(this);
    var project_id = document.getElementById("project_id").value;
    var boq_code = document.getElementById("taxinvoice_boq_code1").value;
    var hsn_sac_code = document.getElementById("proforma_hsn_sac_code1").value;
    var item_description = document.getElementById("proforma_item_description1").value;
    var unit = document.getElementById("proforma_unit1").value;
    var qty = document.getElementById("proforma_qty1").value;
    var rate = document.getElementById("proforma_rate1").value;
    var itaxable_amount = document.getElementById("proforma_itaxable_amount1").value;
    var sgst = document.getElementById("proforma_sgst1").value;
    var sgst_amount = document.getElementById("proforma_sgst_amount1").value;
    var cgst = document.getElementById("proforma_cgst1").value;
    var cgst_amount = document.getElementById("proforma_cgst_amount1").value;
    var proforma_from = document.getElementById("proforma_from1").value;
    
    if(sgst !== '' && typeof sgst !== "undefined" && parseFloat(sgst) > 0){
        sgst = sgst;    
    }else{
        sgst = 0;
    }
    if(sgst_amount !== '' && typeof sgst_amount !== "undefined" && parseFloat(sgst_amount) > 0){
        sgst_amount = sgst_amount;    
    }else{
        sgst_amount = 0.00;
    }
    if(cgst !== '' && typeof cgst !== "undefined" && parseFloat(cgst) > 0){
        cgst = cgst;    
    }else{
        cgst = 0;
    }
    if(cgst_amount !== '' && typeof cgst_amount !== "undefined" && parseFloat(cgst_amount) > 0){
        cgst_amount = cgst_amount;    
    }else{
        cgst_amount = 0.00;
    }
    if(project_id === '' || boq_code === '' || hsn_sac_code === '' || item_description === '' || unit === '' || 
    qty < 1 || rate < 1){
        $('.invaliderrorpro1').addClass('has-error-p');
    }else{
        var base_url = $('#base_url').val().trim();
        var installed_stock = 0;
        var provisional_stock = 0;
        var exist_boq_code = '';
        if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
            installed_stock = function () {
            var tmpinstalled = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.installed !== '' && typeof result.installed !== "undefined"){
                        tmpinstalled = result.installed;
                    }else{
                        tmpinstalled = 0;
                    }
                }
            });
            return tmpinstalled;
            }();
            provisional_stock = function () {
            var tmp_provisional = 0;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_stock_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    if(result.provisional !== '' && typeof result.provisional !== "undefined"){
                        tmp_provisional = result.provisional;
                    }else{
                        tmp_provisional = 0;
                    }
                }
            });
            return tmp_provisional;
            }();
            exist_boq_code = function () {
            var tmp1 = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_approved_boq_item_details'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp1 = result.boq_code;
                }
            });
            return tmp1;
            }();
        }
        var final_qty=0;
        var proforma_from = '';
        if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
            final_qty = parseInt(installed_stock) + parseInt(provisional_stock); 
        }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) === 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) > 0){
            final_qty = parseInt(provisional_stock); 
        }else if(installed_stock !== '' && typeof installed_stock !== "undefined" && parseFloat(installed_stock) > 0
        && provisional_stock !== '' && typeof provisional_stock !== "undefined" && parseFloat(provisional_stock) === 0){
            final_qty = parseInt(installed_stock); 
        }
        if(parseInt(qty) <= parseInt(installed_stock)){
            proforma_from = 'installed_stock';
        }else if(parseInt(qty) <= parseInt(provisional_stock)){
            proforma_from = 'provisional_stock';
        }else if(parseInt(qty) <= parseInt(final_qty)){
            proforma_from = 'both';
        }
        if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
            if(final_qty !== '' && typeof final_qty !== "undefined" && parseInt(final_qty) > 0){
                if(parseInt(qty) <= parseInt(final_qty)){
                    boq_code_no = [];
                    $("input[name='proforma_boq_code_v[]']").each(function(){
                            boq_code_no.push($(this).val());
                        });
                    if ($.inArray(boq_code, boq_code_no) != -1){
                            $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                            $('#proforma_from1').val('');
                            $('#taxinvoice_boq_code1').val('');
                            $('#proforma_hsn_sac_code1').val('');
                            $('#proforma_item_description1').val('');
                            $('#proforma_unit1').val('');
                            $('#proforma_qty1').val('');
                            $('#proforma_rate1').val('');
                            $('#proforma_itaxable_amount1').val('');
                            $('#proforma_sgst1').val('');
                            $('#proforma_sgst_amount1').val('');
                            $('#proforma_cgst1').val('');
                            $('#proforma_cgst_amount1').val('');
                            $('#proforma_hsn_sac_code1').prop('readonly', false);
                            $('#proforma_item_description1').prop('readonly', false);
                            $('#proforma_unit1').prop('readonly', false);
                    }else{
                        if(parseInt(qty) > 0){
                                var html='<tr><td>'
                                +'<input type="hidden" id="proforma_from_'+boq_code+'" name="proforma_from[]" value="'+proforma_from+'"><input type="text" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_boq_code_v[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_hsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_unit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="number" class="form-control checktaxinvoiceqty invalidqtytaxinvoiceerror_'+boq_code+' invalidqtytaxinvoice_'+boq_code+'" name="proforma_qty[]" value="'+qty+'" data-id="'+boq_code+'" data-pid="'+project_id+'" style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="number" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_rate[]" id="proforma_rate_'+boq_code+'" value="'+rate+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="number" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_itaxable_amount[]" id="proforma_itaxable_amount_'+boq_code+'" value="'+itaxable_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="number" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_sgst[]" id="proforma_sgst_'+boq_code+'" value="'+sgst+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="number" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_sgst_amount[]" id="proforma_sgst_amount_'+boq_code+'" value="'+sgst_amount+'" readonly style="font-size: 12px;width:100%">'
                                +'<td><input type="number" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_cgst[]" id="proforma_cgst_'+boq_code+'" value="'+cgst+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="number" class="form-control invalidqtytaxinvoice_'+boq_code+'" name="proforma_cgst_amount[]" id="proforma_cgst_amount_'+boq_code+'" value="'+cgst_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td>'
                                +'<div class="addDeleteButton">'
                                +'<span class="tooltips deletePerfomaInvcRow1" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                                +'</div></td></tr>';
                                $('.invaliderrorpro1').removeClass('has-error-d');
                                $('#invaliderrorprod1').html('');
                                $(maintml).parents('#taxperfomadisplaysgsts tbody').find("tr:last").before(html);
                                $(maintml).parents('#taxperfomadisplaysgstsexist tbody').find("tr:last").before(html);
                                $('#taxinvoice_boq_code1').val('');
                                $('#proforma_hsn_sac_code1').val('');
                                $('#proforma_item_description1').val('');
                                $('#proforma_unit1').val('');
                                $('#proforma_qty1').val('');
                                $('#proforma_rate1').val('');
                                $('#proforma_itaxable_amount1').val('');
                                $('#proforma_sgst1').val('');
                                $('#proforma_sgst_amount1').val('');
                                $('#proforma_cgst1').val('');
                                $('#proforma_cgst_amount1').val('');
                                $('#proforma_hsn_sac_code1').prop('readonly', false);
                                $('#proforma_item_description1').prop('readonly', false);
                                $('#proforma_unit1').prop('readonly', false);
                                $('#proforma_from1').val('');
                            
                                var total = 0;
                                $("input[name='proforma_itaxable_amount[]']").each(function() {
                                    total += parseFloat($(this).val());
                                });
                                var total_sgst_amt = 0;
                                $("input[name='proforma_sgst_amount[]']").each(function() {
                                    total_sgst_amt += parseFloat($(this).val());
                                });
                                
                                var total_cgst_amt = 0;
                                $("input[name='proforma_cgst_amount[]']").each(function() {
                                    total_cgst_amt += parseFloat($(this).val());
                                });
                                
                                var proformafinal = 0;
                                proformafinal = parseFloat(total) + parseFloat(total_sgst_amt) + parseFloat(total_cgst_amt);
                                $('#proforma_sub_total1').html(parseFloat(total).toFixed(2));
                                $('#proforma_cgst_total1').html(parseFloat(total_cgst_amt).toFixed(2));
                                $('#proforma_sgst_total1').html(parseFloat(total_sgst_amt).toFixed(2));
                                $('#proforma_final1').html(parseFloat(proformafinal).toFixed(2));
                        }else{
                            $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Invalid Qty!');
                        }
                    }   
                }else{
                    $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Qty must be less than equal to '+final_qty+' !');
                }
            }else{
                $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' not Available for Billing!');
                $('#proforma_from1').val('');
                $('#taxinvoice_boq_code1').val('');
                $('#proforma_hsn_sac_code1').val('');
                $('#proforma_item_description1').val('');
                $('#proforma_unit1').val('');
                $('#proforma_qty1').val('');
                $('#proforma_rate1').val('');
                $('#proforma_itaxable_amount1').val('');
                $('#proforma_sgst1').val('');
                $('#proforma_sgst_amount1').val('');
                $('#proforma_cgst1').val('');
                $('#proforma_cgst_amount1').val('');
                $('#proforma_hsn_sac_code1').prop('readonly', false);
                $('#proforma_item_description1').prop('readonly', false);
                $('#proforma_unit1').prop('readonly', false);
            }
        }else{
            $('#invaliderrorprod1').html('BOQ Sr No '+boq_code+' Details Not Exist!');
            $('#proforma_from1').val('');
            $('#taxinvoice_boq_code1').val('');
            $('#proforma_hsn_sac_code1').val('');
            $('#proforma_item_description1').val('');
            $('#proforma_unit1').val('');
            $('#proforma_qty1').val('');
            $('#proforma_rate1').val('');
            $('#proforma_itaxable_amount1').val('');
            $('#proforma_sgst1').val('');
            $('#proforma_sgst_amount1').val('');
            $('#proforma_cgst1').val('');
            $('#proforma_cgst_amount1').val('');
            $('#proforma_hsn_sac_code1').prop('readonly', false);
            $('#proforma_item_description1').prop('readonly', false);
            $('#proforma_unit1').prop('readonly', false);
        }
    }
    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            dateFormat: "dd-mm-yy",
            orientation: "right",
            autoclose: true,
        });
    } 
    Metronic.init();
});


$(document).on('click','.addBOQExceptnalDynaRow',function(){        
        var maintml = $(this);
        var project_id = document.getElementById("project_id").value;
        var boq_code = document.getElementById("boq_code_exceptional").value;
        var item_description = document.getElementById("item_description").value;
        var ea_qty = document.getElementById("ea_qty").value;
        if(project_id === '' || boq_code === '' || item_description === '' || ea_qty < 1){
            $('.invaliderror').addClass('has-error-d');
        }else{
            var base_url = $('#base_url').val().trim();
            var exist_boq_code = function () {
            var tmp = null;
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': completeURL('get_boq_exceptional_item'),
                'data': { 'boq_code': boq_code, 'project_id': project_id},
                'success': function (result) {
                    tmp = result.boq_code;
                }
            });
            return tmp;
            }();
            //alert(exist_boq_code);
            if(exist_boq_code !== '' && typeof exist_boq_code !== "undefined"){
                boq_code_no = [];
                $("input[name='boq_code[]']").each(function(){
                    boq_code_no.push($(this).val());
                });
                if ($.inArray(boq_code, boq_code_no) != -1){
                    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                    $('#boq_code_exceptional').val('');
                    $('#item_description').val('');
                    $('#ea_qty').val('');
                    $('#item_description').prop('readonly', false);
                }else{
                    if(ea_qty > 0){
                        var html='<tr><td>'
                        +'<input type="text" class="form-control" name="boq_code[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
                        +'<td><input type="text" class="form-control" name="item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
                        +'<td><input type="text" class="form-control" name="ea_qty[]" value="'+ea_qty+'" readonly style="font-size: 12px;width:100%"></td>'
                        +'<td>'
                        +'<div class="addDeleteButton">'
                        +'<span class="tooltips deleteBoqExceptnRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                        +'</div></td></tr>';
                        $('.invaliderror').removeClass('has-error-d');
                        $('#invaliderrorid').html('');
                        $(maintml).parents('#boqitmdisplay tbody').find("tr:last").before(html);
                        $('#boq_code_exceptional').val('');
                        $('#item_description').val('');
                        $('#ea_qty').val('');
                        $('#item_description').prop('readonly', false);
                    }else{
                        $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Invalid EA Qty!');
                    }
                }   
            }else{
                $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Not Exist!');
                $('#boq_code_exceptional').val('');
                $('#item_description').val('');
                $('#ea_qty').val('');
                $('#item_description').prop('readonly', false);
            } 
        }
        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                orientation: "right",
                autoclose: true,
            });
        } 
        Metronic.init();
    });
    $(document).on("change","#summary_type_id", function(){
        var base_url = $('#base_url').val().trim();
        var summary_type_id = $(this).val().trim();
        if(summary_type_id === 'wip'){
            var wiphtml = '<table width="100%" id="summarycommomtable" class="table table-striped table-bordered table-hover"><thead><tr>'
            +'<th scope="col" style="min-width:30px;width:30px;">Sr.no</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BP Code</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">WIP Amount</th>'
            +'</tr>'
            +'</thead>'
            +'<tbody></tbody></table>';    
            $('#summarycommomtablediv').html(wiphtml);
        }else{
            var stockhtml = '<table width="100%" id="summarycommomtable" class="table table-striped table-bordered table-hover"><thead><tr>'
            +'<th scope="col" style="min-width:30px;width:30px;">Sr.no</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BP Code</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">Stock Amount</th>'
            +'</tr>'
            +'</thead>'
            +'<tbody></tbody></table>';    
            $('#summarycommomtablediv').html(stockhtml);
        }
        $('#summarycommomtable').dataTable({
        	// Processing indicator
        		"bDestroy" : true,
        		"paging": true,
        		"iDisplayLength": 10,
                "deferRender": true,
                "responsive": true,
                "processing": true,
        		"serverSide": true,
                // Initial no order.
                "order": [],
        		
                // Load data from an Ajax source
                "ajax": {
                    "url": base_url+"wipstatusreports_display",
                    "type": "POST"
                },
        		
                //Set column definition initialisation properties
                "columnDefs": [{ 
                    "targets": [0],
                    "orderable": false
                }]
        });
    });
    $(document).on("change","#rate_type", function(){
        var base_url = $('#base_url').val().trim();
        var rate_type = $(this).val().trim();
        var type_id = $('#type_id').val().trim();
        if(type_id === 'wip' && rate_type === 'boq_rate'){
            var wipboqrate = '<table width="100%" id="commomtable" class="table table-striped table-bordered table-hover"><thead><tr>'
            +'<th scope="col" style="min-width:30px;width:30px;">Sr.no</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BP Code</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BOQ Sr No</th>'
            +'<th scope="col" style="min-width:150px;width:150px;">Item Description</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOQ Qty</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOQ Rate</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">WIP Amount</th>'
            +'</tr>'
            +'</thead>'
            +'<tbody></tbody></table>';    
            $('#commomtablediv').html(wipboqrate);
        }else if(type_id === 'wip' && rate_type === 'bom_rate'){
            var wipbomrate = '<table width="100%" id="commomtable" class="table table-striped table-bordered table-hover"><thead><tr>'
            +'<th scope="col" style="min-width:30px;width:30px;">Sr.no</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BP Code</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BOM Sr No</th>'
            +'<th scope="col" style="min-width:150px;width:150px;">Item Description</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOM Qty</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOM Rate</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">WIP Amount</th>'
            +'</tr>'
            +'</thead>'
            +'<tbody></tbody></table>';    
            $('#commomtablediv').html(wipbomrate);
        }else if(type_id === 'stock' && rate_type === 'boq_rate'){
            var stockboqrate = '<table width="100%" id="commomtable" class="table table-striped table-bordered table-hover"><thead><tr>'
            +'<th scope="col" style="min-width:30px;width:30px;">Sr.no</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BP Code</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BOQ Sr No</th>'
            +'<th scope="col" style="min-width:150px;width:150px;">Item Description</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOQ Qty</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOQ Rate</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">Stock Amount</th>'
            +'</tr>'
            +'</thead>'
            +'<tbody></tbody></table>';    
            $('#commomtablediv').html(stockboqrate);
        }else if(type_id === 'stock' && rate_type === 'bom_rate'){
            var stockbomrate = '<table width="100%" id="commomtable" class="table table-striped table-bordered table-hover"><thead><tr>'
            +'<th scope="col" style="min-width:30px;width:30px;">Sr.no</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BP Code</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BOM Sr No</th>'
            +'<th scope="col" style="min-width:150px;width:150px;">Item Description</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOM Qty</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOM Rate</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">Stock Amount</th>'
            +'</tr>'
            +'</thead>'
            +'<tbody></tbody></table>';    
            $('#commomtablediv').html(stockbomrate);
        }
        $('#commomtable').dataTable({
        	// Processing indicator
        		"bDestroy" : true,
        		"paging": true,
        		"iDisplayLength": 10,
                "deferRender": true,
                "responsive": true,
                "processing": true,
        		"serverSide": true,
                // Initial no order.
                "order": [],
        		
                // Load data from an Ajax source
                "ajax": {
                    "url": base_url+"wipstatusreports_display",
                    "type": "POST"
                },
        		
                //Set column definition initialisation properties
                "columnDefs": [{ 
                    "targets": [0],
                    "orderable": false
                }]
        });
    });
    $(document).on("change","#type_id", function(){
        var base_url = $('#base_url').val().trim();
        var type_id = $(this).val().trim();
        var rate_type = $('#rate_type').val().trim();
        if(type_id === 'wip' && rate_type === 'boq_rate'){
            var wipboqrate = '<table width="100%" id="commomtable" class="table table-striped table-bordered table-hover"><thead><tr>'
            +'<th scope="col" style="min-width:30px;width:30px;">Sr.no</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BP Code</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BOQ Sr No</th>'
            +'<th scope="col" style="min-width:150px;width:150px;">Item Description</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOQ Qty</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOQ Rate</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">WIP Amount</th>'
            +'</tr>'
            +'</thead>'
            +'<tbody></tbody></table>';    
            $('#commomtablediv').html(wipboqrate);
        }else if(type_id === 'wip' && rate_type === 'bom_rate'){
            var wipbomrate = '<table width="100%" id="commomtable" class="table table-striped table-bordered table-hover"><thead><tr>'
            +'<th scope="col" style="min-width:30px;width:30px;">Sr.no</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BP Code</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BOM Sr No</th>'
            +'<th scope="col" style="min-width:150px;width:150px;">Item Description</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOM Qty</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOM Rate</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">WIP Amount</th>'
            +'</tr>'
            +'</thead>'
            +'<tbody></tbody></table>';    
            $('#commomtablediv').html(wipbomrate);
        }else if(type_id === 'stock' && rate_type === 'boq_rate'){
            var stockboqrate = '<table width="100%" id="commomtable" class="table table-striped table-bordered table-hover"><thead><tr>'
            +'<th scope="col" style="min-width:30px;width:30px;">Sr.no</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BP Code</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BOQ Sr No</th>'
            +'<th scope="col" style="min-width:150px;width:150px;">Item Description</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOQ Qty</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOQ Rate</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">Stock Amount</th>'
            +'</tr>'
            +'</thead>'
            +'<tbody></tbody></table>';    
            $('#commomtablediv').html(stockboqrate);
        }else if(type_id === 'stock' && rate_type === 'bom_rate'){
            var stockbomrate = '<table width="100%" id="commomtable" class="table table-striped table-bordered table-hover"><thead><tr>'
            +'<th scope="col" style="min-width:30px;width:30px;">Sr.no</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BP Code</th>'
            +'<th scope="col" style="min-width:50x;width:50x;">BOM Sr No</th>'
            +'<th scope="col" style="min-width:150px;width:150px;">Item Description</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOM Qty</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">BOM Rate</th>'
            +'<th scope="col" style="min-width:50px;width:50px;">Stock Amount</th>'
            +'</tr>'
            +'</thead>'
            +'<tbody></tbody></table>';    
            $('#commomtablediv').html(stockbomrate);
        }
        $('#commomtable').dataTable({
        	// Processing indicator
        		"bDestroy" : true,
        		"paging": true,
        		"iDisplayLength": 10,
                "deferRender": true,
                "responsive": true,
                "processing": true,
        		"serverSide": true,
                // Initial no order.
                "order": [],
        		
                // Load data from an Ajax source
                "ajax": {
                    "url": base_url+"wipstatusreports_display",
                    "type": "POST"
                },
        		
                //Set column definition initialisation properties
                "columnDefs": [{ 
                    "targets": [0],
                    "orderable": false
                }]
        });
    });
    $(document).on("change",".completion_cerf_received", function(){
        var value = $(this).val();
        if(value == 'Yes'){
            var html = '<div class="col-md-3 completion_cerf_receivedrm">'
            +'<div class="form-group">'
            +'<label>Upload Completion Certificate <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
            +'<input type="file" name="emd_doc" id="emd_doc" class="emd_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />'
            +'</div></div>';
            $('#completioncerfreceivedyes').prepend(html);    
        }else{
            $('.completion_cerf_receivedrm').remove();    
        }
    });
    $(document).on("change",".contarct_deposit_emd_recclass", function(){
        var value = $(this).val();
        if(value == 'Yes'){
            var html = '<div class="row">'
            +'<div class="col-md-3">'
            +'<div class="form-group">'
            +'<label>Received Amount (EMD) <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
            +'<div class="input-icon right"><i class="fa"></i>'
            +'<input type="number" class="form-control " id="received_amt" name="received_amt" placeholder="Received Amount" required>'
            +'</div></div></div>'
            +'<div class="col-md-3">'
            +'<div class="form-group">'
            +'<label class="">Payment Date (EMD) <span class="required" aria-required="true" style="color:#a94442">*</span></label>'
            +'<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">'
            +'<input type="text" name="emd_payment_date" id="emd_payment_date" class="form-control" readonly="" placeholder="Payment Date">'
            +'<span class="input-group-btn">'
            +'<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>'
            +'</span></div></div></div>'
            +'<div class="col-md-3">'
            +'<div class="form-group">'
            +'<label>Document Upload (EMD) <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
            +'<input type="file" name="emd_doc" id="emd_doc" class="emd_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />'
            +'</div></div>'
            +'</div>';
            $('#contarct_deposit_emd_div').html(html);    
        }else{
            $('#contarct_deposit_emd_div').html('');    
        }
    });
     $(document).on("change",".contarct_deposit_asd_rec_class", function(){
        var value = $(this).val();
        if(value == 'Yes'){
            var html = '<div class="row">'
            +'<div class="col-md-3">'
            +'<div class="form-group">'
            +'<label>Received Amount (ASD) <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
            +'<div class="input-icon right"><i class="fa"></i>'
            +'<input type="number" class="form-control " id="asd_received_amt" name="asd_received_amt" placeholder="Received Amount" required>'
            +'</div></div></div>'
            +'<div class="col-md-3">'
            +'<div class="form-group">'
            +'<label class="">Payment Date (ASD) <span class="required" aria-required="true" style="color:#a94442">*</span></label>'
            +'<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">'
            +'<input type="text" name="asd_payment_date" id="asd_payment_date" class="form-control" readonly="" placeholder="Payment Date">'
            +'<span class="input-group-btn">'
            +'<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>'
            +'</span></div></div></div>'
            +'<div class="col-md-3">'
            +'<div class="form-group">'
            +'<label>Document Upload (ASD) <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
            +'<input type="file" name="asd_doc" id="asd_doc" class="asd_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />'
            +'</div></div>'
            +'</div>';
            $('#contarct_deposit_asd_div').html(html);    
        }else{
            $('#contarct_deposit_asd_div').html('');    
        }
    });
    $(document).on("change",".payment_advice_receivedcclass", function(){
        var value = $(this).val();
        if(value == 'Yes'){
            var html = '<div class="form-group">'
            +'<label class="">Payment Receipt Copy Received Date <span class="required" aria-required="true" style="color:#a94442">*</span></label>'
            +'<div class="input-group date date1" data-date-end-date="0d" data-date-format="dd-mm-yyyy">'
            +'<input type="text" name="payment_advice_received_date" id="payment_advice_received_date" class="form-control" readonly="" placeholder="Payment Receipt Copy Received Date">'
            +'<span class="input-group-btn">'
            +'<button class="btn default" type="button"><span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -1.0625px; left: -9.5px;"></span><i class="fa fa-calendar"></i></button>'
            +'</span></div></div>';
            
            var html_p = '<div class="form-group">'
            +'<label>Upload Payment Receipt Document <span class="require" aria-required="true" style="color:#a94442">*</span></label>'
            +'<input type="file" name="payment_advice_doc" id="payment_advice_doc" class="payment_advice_doc" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" />'
            +'</div>';
            
            $('#payment_advice_received_date_d').html(html);    
            $('#payment_advice_doc_d').html(html_p);    
        }else{
            $('#payment_advice_received_date_d').html('');    
            $('#payment_advice_doc_d').html('');    
        }
    });
    $(document).on("change","#filter", function(){
    var value = $(this).val();
    if(value == 'calculated'){
        var html = '<div class="form-group">'
            +'<select class="form-control" name="calculatedfiler" id="calculatedfiler">'
            +'<option value="without_gst">Without GST</option>'
            +'<option value="with_gst">With GST</option>'
            +'</select></div>';
            $('#calculatedfiler').html(html);    
        }else{
            $('#calculatedfiler').html('');    
        }
});

/*$( ".project-details" ).on( "mouseover", function() {
    $(".menu-inner-box").animate({scrollLeft: "0px"});
});
$( ".boq-transaction" ).on( "mouseover", function() {
    $(".menu-inner-box").animate({scrollLeft: "100px"});
});
$( ".boq-view" ).on( "mouseover", function() {
    $(".menu-inner-box").animate({scrollLeft: "150px"});
});
$( ".boq-operational-view" ).on( "mouseover", function() {
    $(".menu-inner-box").animate({scrollLeft: "200px"});
});
$( ".delivery-challan" ).on( "mouseover", function() {
    $(".menu-inner-box").animate({scrollLeft: "250px"});
});
$( ".virtual-stock" ).on( "mouseover", function() {
    $(".menu-inner-box").animate({scrollLeft: "300px"});
});
$( ".installed-wip" ).on( "mouseover", function() {
    $(".menu-inner-box").animate({scrollLeft: "350px"});
});
$( ".provisional-wip" ).on( "mouseover", function() {
    $(".menu-inner-box").animate({scrollLeft: "400px"});
});
$( ".proforma-invoice" ).on( "mouseover", function() {
    $(".menu-inner-box").animate({scrollLeft: "450px"});
});
$( ".tax-invoice" ).on( "mouseover", function() {
    $(".menu-inner-box").animate({scrollLeft: "500px"});
});
$( ".waiting-approval" ).on( "mouseover", function() {
    $(".menu-inner-box").animate({scrollLeft: "650px"});
});
$( ".wip-status" ).on( "mouseover", function() {
    $(".menu-inner-box").animate({scrollLeft: "750px"});
});
*/
$('#btn-nav-previous').click(function(){
    $(".menu-inner-box").animate({scrollLeft: "-=100px"});
});
$('#btn-nav-next').click(function(){
    $(".menu-inner-box").animate({scrollLeft: "+=100px"});
});
$(document).on('click','.popup_save',function()
    {
        var id = $(this).attr('rel');
        var url = $(this).attr('rev');
        var title= $(this).data('title');
        var data={id:id};
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
                                    serialize_data = {serialize_data:serialize_data,id:id};
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
$(document).on('keyup', '#proforma_qty1', function() {
    var qty = $(this).val().trim();
    var rate = $('#proforma_rate1').val().trim();
    var sgst = $('#proforma_sgst1').val().trim();
    var cgst = $('#proforma_cgst1').val().trim();
    var total_rate = 0;
    if(qty !== '' && typeof qty !== "undefined" && parseFloat(qty) > 0
    && rate !== '' && typeof rate !== "undefined" && parseFloat(rate) > 0){
        // total_rate = parseFloat(qty) * parseFloat(rate); 
        total_rate = calculatedBillSplit(rate, qty);
    }

    $('#proforma_itaxable_amount1').val(parseFloat(total_rate).toFixed(2));
    
    var proforma_sgst_amount = 0;
    if(sgst !== '' && typeof sgst !== "undefined" && parseFloat(sgst) > 0){
    proforma_sgst_amount = parseFloat(total_rate) * (parseFloat(sgst)/100);     
    }
    $('#proforma_sgst_amount1').val(parseFloat(proforma_sgst_amount).toFixed(2));
    
    var proforma_cgst_amount = 0;
    if(cgst !== '' && typeof cgst !== "undefined" && parseFloat(cgst) > 0){
    proforma_cgst_amount = parseFloat(total_rate) * (parseFloat(cgst)/100);     
    }
    $('#proforma_cgst_amount1').val(parseFloat(proforma_cgst_amount).toFixed(2));
    
    var total = 0;
    $("input[name='proforma_itaxable_amount[]']").each(function() {
        total += parseFloat($(this).val());
    });
    $('#proforma_sub_total1').html(parseFloat(total).toFixed(2));
    
    var proforma_total_cgst = 0;
    $("input[name='proforma_cgst_amount[]']").each(function() {
        proforma_total_cgst += parseFloat($(this).val());
    });
    $('#proforma_cgst_total1').html(parseFloat(proforma_total_cgst).toFixed(2));
    
    var proforma_total_sgst = 0;
    $("input[name='proforma_sgst_amount[]']").each(function() {
        proforma_total_sgst += parseFloat($(this).val());
    });
    $('#proforma_sgst_total1').html(parseFloat(proforma_total_sgst).toFixed(2));
    
});
$(document).on('keyup', '#proforma_rate1', function() {
    var qty = $('#proforma_qty1').val().trim();
    var rate = $(this).val().trim();
    var sgst = $('#proforma_sgst1').val().trim();
    var cgst = $('#proforma_cgst1').val().trim();
    var total_rate = 0;
    if(qty !== '' && typeof qty !== "undefined" && parseFloat(qty) > 0
    && rate !== '' && typeof rate !== "undefined" && parseFloat(rate) > 0){
        // total_rate = parseFloat(qty) * parseFloat(rate); 
        total_rate = calculatedBillSplit(rate, qty);
    }
    $('#proforma_itaxable_amount1').val(parseFloat(total_rate).toFixed(2));
    
    var proforma_sgst_amount = 0;
    if(sgst !== '' && typeof sgst !== "undefined" && parseFloat(sgst) > 0){
    proforma_sgst_amount = parseFloat(total_rate) * (parseFloat(sgst)/100);     
    }
    $('#proforma_sgst_amount1').val(parseFloat(proforma_sgst_amount).toFixed(2));
    
    var proforma_cgst_amount = 0;
    if(cgst !== '' && typeof cgst !== "undefined" && parseFloat(cgst) > 0){
    proforma_cgst_amount = parseFloat(total_rate) * (parseFloat(cgst)/100);     
    }
    $('#proforma_cgst_amount1').val(parseFloat(proforma_cgst_amount).toFixed(2));
    
    var total = 0;
    $("input[name='proforma_itaxable_amount[]']").each(function() {
        total += parseFloat($(this).val());
    });
    $('#proforma_sub_total1').html(parseFloat(total).toFixed(2));
    
    var proforma_total_cgst = 0;
    $("input[name='proforma_cgst_amount[]']").each(function() {
        proforma_total_cgst += parseFloat($(this).val());
    });
    $('#proforma_cgst_total1').html(parseFloat(proforma_total_cgst).toFixed(2));
    
    var proforma_total_sgst = 0;
    $("input[name='proforma_sgst_amount[]']").each(function() {
        proforma_total_sgst += parseFloat($(this).val());
    });
    $('#proforma_sgst_total1').html(parseFloat(proforma_total_sgst).toFixed(2));
    
});
$(document).on('keyup', '#proforma_sgst1,#proforma_cgst1', function() {
    var qty = $('#proforma_qty1').val().trim();
    var rate = $('#proforma_rate1').val().trim();
    var sgst = $('#proforma_sgst1').val().trim();
    var cgst = $('#proforma_cgst1').val().trim();
    var total_rate = 0;
    if(qty !== '' && typeof qty !== "undefined" && parseFloat(qty) > 0
    && rate !== '' && typeof rate !== "undefined" && parseFloat(rate) > 0){
    // total_rate = parseFloat(qty) * parseFloat(rate);    
        total_rate = calculatedBillSplit(rate, qty);
    }
    $('#proforma_itaxable_amount1').val(parseFloat(total_rate).toFixed(2));
    
    var proforma_sgst_amount = 0;
    if(sgst !== '' && typeof sgst !== "undefined" && parseFloat(sgst) > 0){
    proforma_sgst_amount = parseFloat(total_rate) * (parseFloat(sgst)/100);     
    }
    $('#proforma_sgst_amount1').val(parseFloat(proforma_sgst_amount).toFixed(2));
    
    var proforma_cgst_amount = 0;
    if(cgst !== '' && typeof cgst !== "undefined" && parseFloat(cgst) > 0){
    proforma_cgst_amount = parseFloat(total_rate) * (parseFloat(cgst)/100);     
    }
    $('#proforma_cgst_amount1').val(parseFloat(proforma_cgst_amount).toFixed(2));
    
    var total = 0;
    $("input[name='proforma_itaxable_amount[]']").each(function() {
        total += parseFloat($(this).val());
    });
    $('#proforma_sub_total1').html(parseFloat(total).toFixed(2));
    
    var proforma_total_cgst = 0;
    $("input[name='proforma_cgst_amount[]']").each(function() {
        proforma_total_cgst += parseFloat($(this).val());
    });
    $('#proforma_cgst_total1').html(parseFloat(proforma_total_cgst).toFixed(2));
    
    var proforma_total_sgst = 0;
    $("input[name='proforma_sgst_amount[]']").each(function() {
        proforma_total_sgst += parseFloat($(this).val());
    });
    $('#proforma_sgst_total1').html(parseFloat(proforma_total_sgst).toFixed(2));
    
});

//
$(document).on('keyup', '#proforma_qty', function() {
    var qty = $(this).val().trim();
    var rate = $('#proforma_rate').val().trim();
    var gst = $('#proforma_gst').val().trim();
    var total_rate = 0;
    if(qty !== '' && typeof qty !== "undefined" && parseFloat(qty) > 0
    && rate !== '' && typeof rate !== "undefined" && parseFloat(rate) > 0){
    total_rate = parseFloat(qty) * parseFloat(rate);     
    }
    $('#proforma_itaxable_amount').val(parseFloat(total_rate).toFixed(2));
    var proforma_itotal_amount = 0;
    if(gst !== '' && typeof gst !== "undefined" && parseFloat(gst) > 0){
    // proforma_itotal_amount = (parseFloat(total_rate) * (parseFloat(gst)/100)) + parseFloat(total_rate);   
     proforma_itotal_amount = (parseFloat(total_rate) * (parseFloat(gst)/100));   
    }
    $('#proforma_itotal_amount').val(parseFloat(proforma_itotal_amount).toFixed(2));
    
    var proforma_gst_amount = 0;
    if(gst !== '' && typeof gst !== "undefined" && parseFloat(gst) > 0){
    proforma_gst_amount = parseFloat(total_rate) * (parseFloat(gst)/100);     
    }
    $('#proforma_gst_amount').val(parseFloat(proforma_gst_amount).toFixed(2));
    
    var total = 0;
    $("input[name='proforma_itaxable_amount[]']").each(function() {
        total += parseFloat($(this).val());
    });
    $('#proforma_sub_total').html(parseFloat(total).toFixed(2));
    
    var proforma_total_gst = 0;
    $("input[name='proforma_gst_amount[]']").each(function() {
        proforma_total_gst += parseFloat($(this).val());
    });
    $('#proforma_total_gst').html(parseFloat(proforma_total_gst).toFixed(2));
});
$(document).on('keyup', '#proforma_rate', function() {
    var qty = $('#proforma_qty').val().trim();
    var rate = $(this).val().trim();
    var gst = $('#proforma_gst').val().trim();
    var total_rate = 0;
    if(qty !== '' && typeof qty !== "undefined" && parseFloat(qty) > 0
    && rate !== '' && typeof rate !== "undefined" && parseFloat(rate) > 0){
    total_rate = parseFloat(qty) * parseFloat(rate);     
    }
    $('#proforma_itaxable_amount').val(parseFloat(total_rate).toFixed(2));
    var proforma_itotal_amount = 0;
    if(gst !== '' && typeof gst !== "undefined" && parseFloat(gst) > 0){
    proforma_itotal_amount = (parseFloat(total_rate) * (parseFloat(gst)/100)) + parseFloat(total_rate);     
    }
    $('#proforma_itotal_amount').val(parseFloat(proforma_itotal_amount).toFixed(2));
    
    var proforma_gst_amount = 0;
    if(gst !== '' && typeof gst !== "undefined" && parseFloat(gst) > 0){
    proforma_gst_amount = parseFloat(total_rate) * (parseFloat(gst)/100);     
    }
    $('#proforma_gst_amount').val(parseFloat(proforma_gst_amount).toFixed(2));
    
    var total = 0;
    $("input[name='proforma_itaxable_amount[]']").each(function() {
        total += parseFloat($(this).val());
    });
    $('#proforma_sub_total').html(parseFloat(total).toFixed(2));
    
    var proforma_total_gst = 0;
    $("input[name='proforma_gst_amount[]']").each(function() {
        proforma_total_gst += parseFloat($(this).val());
    });
    $('#proforma_total_gst').html(parseFloat(proforma_total_gst).toFixed(2));

});
$(document).on('keyup', '#proforma_gst', function() {
    var qty = $('#proforma_qty').val().trim();
    var rate = $('#proforma_rate').val().trim();
    var gst = $(this).val().trim();
    var total_rate = 0;
    if(qty !== '' && typeof qty !== "undefined" && parseFloat(qty) > 0
    && rate !== '' && typeof rate !== "undefined" && parseFloat(rate) > 0){
    total_rate = parseFloat(qty) * parseFloat(rate);     
    }
    $('#proforma_itaxable_amount').val(parseFloat(total_rate).toFixed(2));
    var proforma_itotal_amount = 0;
    if(gst !== '' && typeof gst !== "undefined" && parseFloat(gst) > 0){
    proforma_itotal_amount = (parseFloat(total_rate) * (parseFloat(gst)/100)) + parseFloat(total_rate);     
    }
    $('#proforma_itotal_amount').val(parseFloat(proforma_itotal_amount).toFixed(2));
    
    var proforma_gst_amount = 0;
    if(gst !== '' && typeof gst !== "undefined" && parseFloat(gst) > 0){
    proforma_gst_amount = parseFloat(total_rate) * (parseFloat(gst)/100);     
    }
    $('#proforma_gst_amount').val(parseFloat(proforma_gst_amount).toFixed(2));
    
    var total = 0;
    $("input[name='proforma_itaxable_amount[]']").each(function() {
        total += parseFloat($(this).val());
    });
    $('#proforma_sub_total').html(parseFloat(total).toFixed(2));
    
    var proforma_total_gst = 0;
    $("input[name='proforma_gst_amount[]']").each(function() {
        proforma_total_gst += parseFloat($(this).val());
    });
    $('#proforma_total_gst').html(parseFloat(proforma_total_gst).toFixed(2));

});
$(document).on('keyup', '#PO_taxable_amt', function() {
    var PO_taxable_amt = $('#PO_taxable_amt').val();
    var gst_rate = $('#gst_rate').val();
    var gst_amount = 0;
    var po_final_amount = 0;
    if(gst_rate === 'composite'){
        $('#gst_amount').prop('readonly', false);
        $('#po_final_amount').prop('readonly', false);
        $('#gst_amount').val('');
        $('#po_final_amount').val('');
    }else{
        $('#gst_amount').prop('readonly', true);
        $('#po_final_amount').prop('readonly', true);
        if(PO_taxable_amt !=='' && PO_taxable_amt > 0 && gst_rate !=='' && gst_rate > 0){
            gst_amount = parseFloat(PO_taxable_amt) * parseFloat((gst_rate/100));
            po_final_amount = parseFloat(PO_taxable_amt) + parseFloat(gst_amount);
        }
        $('#gst_amount').val(gst_amount.toFixed(2));
        $('#po_final_amount').val(po_final_amount.toFixed(2));
    }
});
$(document).on('change', '#gst_rate', function() {
    var PO_taxable_amt = $('#PO_taxable_amt').val();
    var gst_rate = $('#gst_rate').val();
    var gst_amount = 0;
    var po_final_amount = 0;
    if(gst_rate === 'composite'){
        $('#gst_amount').prop('readonly', false);
        $('#po_final_amount').prop('readonly', false);
        $('#gst_amount').val('');
        $('#po_final_amount').val('');
    }else{
        $('#gst_amount').prop('readonly', true);
        $('#po_final_amount').prop('readonly', true);
        if(PO_taxable_amt !=='' && PO_taxable_amt > 0 && gst_rate !=='' && gst_rate > 0){
            gst_amount = parseFloat(PO_taxable_amt) * parseFloat((gst_rate/100));
            po_final_amount = parseFloat(PO_taxable_amt) + parseFloat(gst_amount);
        }
        $('#gst_amount').val(gst_amount.toFixed(2));
        $('#po_final_amount').val(po_final_amount.toFixed(2));
    }
});
$(document).on('keyup', '#except_boq_code', function() {
    $('#invaliderrorid').html('');
    var boq_code = $(this).val();
    var project_id = $('#project_id').val();
    if(boq_code !== '' && typeof boq_code !== "undefined"){

        var approved_ea = '';
        approved_ea = function () {
        var tmp_ea_approved = 'Y';
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'dataType': 'html',
            'url': completeURL('check_boq_exceptional_approval'),
            'data': { 'boq_code': boq_code, 'project_id': project_id},
            'success': function (result) {
                if(result !== '' && typeof result !== "undefined" && result > 0){
                    tmp_ea_approved = 'N';
                }else{
                    tmp_ea_approved = 'Y';
                }
            }
        });
        return tmp_ea_approved;
        }();

        var bom_item_check = '';
        bom_item_check = function () {
        var tmp_bom_item_exist = null;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'dataType': 'html',
            'url': completeURL('check_boq_exceptional_bom_item'),
            'data': { 'boq_code': boq_code, 'project_id': project_id},
            'success': function (result) {
                if(result !== '' && typeof result !== "undefined" && result > 0){
                    tmp_bom_item_exist = 'Y';
                }else{
                    tmp_bom_item_exist = 'N';
                }
            }
        });
        return tmp_bom_item_exist;
        }();

        var dc_stock_qty = 0;
        var temp_released_approved = 0;
        dc_stock_qty = function () {
        var tmp_stock_qty = 0;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'dataType': 'json',
            'url': completeURL('get_stock_details'),
            'data': { 'boq_code': boq_code, 'project_id': project_id},
            'success': function (result) {
                if(result.dc_stock !== '' && typeof result.dc_stock !== "undefined"){
                    tmp_stock_qty = result.dc_stock;
                    temp_released_approved = result.released_approved;
                }else{
                    tmp_stock_qty = 0;
                    temp_released_approved = 0;
                }
            }
        });
        return tmp_stock_qty;
        }();
        var url = 'get_boq_item_details';
        $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:{project_id:project_id,boq_code:boq_code},
            success:function(result){
                if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){
                    if(result.boq_status !== '' && typeof result.boq_status !== "undefined" && result.boq_status == 'Y'){
                        if(bom_item_check !== '' && typeof bom_item_check !== "undefined" && bom_item_check == 'Y'){
                            if(approved_ea !== '' && typeof approved_ea !== "undefined" && approved_ea == 'Y'){
                                $('#invaliderrorexceptdiv').html('');
                                $('#except_boq_items_id').val(result.boq_items_id);    
                                $('#except_item_description').val(result.item_description);    
                                $('#except_hsn_sac_code').val(result.hsn_sac_code);    
                                $('#except_unit').val(result.unit);    
                                $('#except_rate_basic').val(result.rate_basic);
                                $('#except_gst').val(result.gst);    
                                if(result.scheduled_qty !== '' && typeof result.scheduled_qty !== "undefined" && result.scheduled_qty > 0){
                                $('#except_scheduled_qty').val(result.scheduled_qty);
                                }else{
                                $('#except_scheduled_qty').val('0');
                                }
                                $('#except_o_design_qty').val(result.o_design_qty);
                                $('#except_or_design_qty').val(result.design_qty);    
                                $('#except_design_qty').val(result.design_qty);    
                                if(result.non_schedule !== '' && typeof result.non_schedule !== "undefined" && result.non_schedule == 'Y'){
                                    $('#except_non_schedule').val('Yes');    
                                }else{
                                    $('#except_non_schedule').val('No');    
                                }
                                if(dc_stock_qty !== '' && typeof dc_stock_qty !== "undefined" && parseInt(dc_stock_qty) > 0){
                                    $('#except_ea_design_qty').val(parseInt(dc_stock_qty));    
                                }else{
                                    $('#except_ea_design_qty').val('0');    
                                }

                                if(temp_released_approved !== '' && typeof temp_released_approved !== "undefined" && parseInt(temp_released_approved) > 0){
                                    $('#except_released_approved').val(parseInt(temp_released_approved));    
                                }else{
                                    $('#except_released_approved').val('0');    
                                }
                            }else{    
                                $('#invaliderrorexceptdiv').html('BOQ Sr No '+boq_code+' EA approval is pending!');
                                $('#except_boq_code').val('');  
                                $('#except_ea_qty').val('');  
                                $('#except_boq_items_id').val('');    
                                $('#except_item_description').val('');    
                                $('#except_hsn_sac_code').val('');    
                                $('#except_unit').val('');    
                                $('#except_rate_basic').val('');
                                $('#except_gst').val('');    
                                $('#except_scheduled_qty').val('');
                                $('#except_o_design_qty').val('');    
                                $('#except_design_qty').val('');    
                                $('#except_non_schedule').val('');    
                                $('#except_ea_design_qty').val('');
                                $('#except_or_design_qty').val('');  
                                $('#except_released_approved').val('');     
                            }
                        } else {
                            $('#invaliderrorexceptdiv').html('BOM Items is not available for BOQ.');
                            $('#except_boq_code').val('');  
                            $('#except_ea_qty').val('');  
                            $('#except_boq_items_id').val('');    
                            $('#except_item_description').val('');    
                            $('#except_hsn_sac_code').val('');    
                            $('#except_unit').val('');    
                            $('#except_rate_basic').val('');
                            $('#except_gst').val('');    
                            $('#except_scheduled_qty').val('');
                            $('#except_o_design_qty').val('');    
                            $('#except_design_qty').val('');    
                            $('#except_non_schedule').val('');    
                            $('#except_ea_design_qty').val('');
                            $('#except_or_design_qty').val('');   
                            $('#except_released_approved').val('');
                        }
                    }else{    
                            $('#invaliderrorexceptdiv').html('BOQ Sr No '+boq_code+' approval is pending!');
                            $('#except_boq_code').val('');
                            $('#except_ea_qty').val('');  
                            $('#except_boq_items_id').val('');    
                            $('#except_item_description').val('');    
                            $('#except_hsn_sac_code').val('');    
                            $('#except_unit').val('');    
                            $('#except_rate_basic').val('');
                            $('#except_gst').val('');    
                            $('#except_scheduled_qty').val('');
                            $('#except_o_design_qty').val('');    
                            $('#except_design_qty').val('');    
                            $('#except_non_schedule').val('');    
                            $('#except_ea_design_qty').val('');
                            $('#except_or_design_qty').val('');
                            $('#except_released_approved').val('');    
                    }
                }else{    
                            $('#invaliderrorexceptdiv').html('BOQ Sr No '+boq_code+' Details Not Exist!');
                            $('#except_boq_code').val('');
                            $('#except_ea_qty').val('');  
                            $('#except_boq_items_id').val('');    
                            $('#except_item_description').val('');    
                            $('#except_hsn_sac_code').val('');    
                            $('#except_unit').val('');    
                            $('#except_rate_basic').val('');
                            $('#except_gst').val('');    
                            $('#except_scheduled_qty').val('');
                            $('#except_o_design_qty').val('');    
                            $('#except_design_qty').val('');    
                            $('#except_non_schedule').val('');    
                            $('#except_ea_design_qty').val(''); 
                            $('#except_or_design_qty').val('');   
                            $('#except_released_approved').val('');
                }
            }
        });
    }else{
        $('#except_boq_items_id').val('');
        $('#except_boq_code').val('');
        $('#except_item_description').val('');
        $('#except_ea_qty').val('');
        $('#except_hsn_sac_code').val('');
        $('#except_unit').val('');
        $('#except_rate_basic').val('');
        $('#except_gst').val('');
        $('#except_scheduled_qty').val('');
        $('#except_o_design_qty').val('');    
        $('#except_design_qty').val('');    
        $('#except_non_schedule').val('');
        $('#except_or_design_qty').val('');  
        $('#except_released_approved').val('');  
    }
});
/*$(document).on('keyup', '#dc_boq_code', function() {
    $('#invaliderrorid').html('');
    var boq_code = $(this).val();
    var project_id = $('#project_id').val();
    var gst_type = $('#gst_type').val();
    var url = 'get_dc_boq_item_details';
    if(boq_code == ''){
        $('#hsn_sac_code').val(''); 
        $('#item_description').val('');
        $('#unit').val('');  
        $('#scheduled_qty').val('');  
        $('#design_qty').val('');
        $('#sgst').val(''); 
        $('#gst').val(''); 
        $('#cgst').val(''); 
        $('#sgst_amount').val(''); 
        $('#cgst_amount').val(''); 
        $('#taxable_amount').val(''); 
        $('#rate_basic').val('');  
        $('#qty').val('');  
        $('#amount').val('');  
        $('#rate').val('');  
        $('#total_amount').val('');  
        $('#non_schedule_yes').prop('checked', false);
        return
    }
       
    $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:{project_id:project_id,boq_code:boq_code},
            success:function(result){
                
               
                if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){
                    // $('#dc_boq_code').val(result.boq_code);    
                    // $('#hsn_sac_code').val(result.hsn_sac_code);    
                    // $('#hsn_sac_code').prop('readonly', true);
                    // $('#item_description').val(result.item_description);    
                    // $('#rate').val(result.rate);   
                    if(gst_type == 'igst') {
                        $('#gst').val(result.gst);  
                        $('#dc_boq_code').val(result.boq_code);    
                        $('#hsn_sac_code').val(result.hsn_sac_code);    
                        $('#hsn_sac_code').prop('readonly', true);
                        $('#item_description').val(result.item_description);    
                        $('#rate').val(result.rate);     
                                          
                    }else{
                        
                        $('#dc_boq_code').val(result.boq_code);    
                        $('#hsn_sac_code').val(result.hsn_sac_code);    
                        $('#hsn_sac_code').prop('readonly', true);
                        $('#item_description').val(result.item_description);    
                        $('#rate').val(result.rate);   


                        $('#sgst').val(result.gst/2);    
                        $('#cgst').val(result.gst/2);    
                    }
                    $('#item_description').prop('readonly', true);
                    $('#unit').val(result.unit);    
                    $('#unit').prop('readonly', true);
                    $('#avl_qty').val('12');    
                    $('#avl_qty').prop('readonly', true);
                }else{    
                    $('#hsn_sac_code').prop('readonly', false);
                    $('#item_description').prop('readonly', false);
                    $('#unit').prop('readonly', false);
                    $('#avl_qty').prop('readonly', false);


                    $('#hsn_sac_code').val(''); 
                    $('#item_description').val('');
                    $('#unit').val('');  
                    $('#scheduled_qty').val('');  
                    $('#design_qty').val('');
                    $('#sgst').val(''); 
                    $('#gst').val(''); 
                    $('#cgst').val(''); 
                    $('#sgst_amount').val(''); 
                    $('#cgst_amount').val(''); 
                    $('#taxable_amount').val(''); 
                    $('#rate_basic').val('');  
                    $('#qty').val('');  
                    $('#amount').val('');  
                    $('#rate').val('');  
                    $('#total_amount').val('');  
                    $('#non_schedule_yes').prop('checked', false);
                }        
            }
    });
});*/

$(document).on('keyup', '#pwdc_boq_code', function() {

   
    $('#invaliderrorid').html('');
    var boq_code = $(this).val();
    var project_id = $('#project_id').val();
    var gst_type = $('#gst_type').val();
    var url = 'get_dc_boq_item_details';
    if(boq_code == ''){
        $('#hsn_sac_code').val(''); 
        $('#item_description').val('');
        $('#unit').val('');  
        $('#scheduled_qty').val('');  
        $('#avl_qty').val('');  
        $('#installed_qty').val('');  
        $('#non_schedule_yes').prop('checked', false);
        return
    }
       
    $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:{project_id:project_id,boq_code:boq_code},
            success:function(result){
                
               console.log(result);
                if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){

                        $('#pwdc_boq_code').val(result.boq_code);    
                        $('#hsn_sac_code').val(result.hsn_sac_code);    
                        $('#hsn_sac_code').prop('readonly', true);
                        $('#item_description').val(result.item_description);    

                    $('#item_description').prop('readonly', true);
                    $('#unit').val(result.unit);    
                    $('#unit').prop('readonly', true);
                    $('#avl_qty').val(result.design_qty);    
                    $('#avl_qty').prop('readonly', true);

                }else{    
                    $('#hsn_sac_code').prop('readonly', false);
                    $('#item_description').prop('readonly', false);
                    $('#unit').prop('readonly', false);
                    $('#avl_qty').prop('readonly', false);


                    $('#hsn_sac_code').val(''); 
                    $('#pwdc_boq_code').val('');
                    $('#item_description').val('');
                    $('#unit').val('');  
                    $('#scheduled_qty').val('');  
                    $('#prov_qty').val('');  
                    $('#installed_qty').val('');    
                    $('#non_schedule_yes').prop('checked', false);
                }        
            }
    });
});
$(document).on('keyup', '#idc_boq_code', function() {
    $('#invaliderrorid').html('');
    var boq_code = $(this).val();
    var project_id = $('#project_id').val();
    var gst_type = $('#gst_type').val();
    var url = 'get_dc_boq_item_details';
    var exist_qty = 0;
    if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
    exist_qty = function () {
    var tmp = null;
    $.ajax({
        'async': false,
        'type': "POST",
        'global': false,
        'dataType': 'html',
        'url': completeURL('get_boq_final_qty'),
        'data': { 'boq_code': boq_code, 'project_id': project_id},
        'success': function (result) {
            tmp = result;
        }
    });
    return tmp;
    }();
    }
    if(boq_code == ''){
        $('#hsn_sac_code').val(''); 
        $('#item_description').val('');
        $('#unit').val('');  
        $('#scheduled_qty').val('');  
        $('#design_qty').val('');
        $('#sgst').val(''); 
        $('#gst').val(''); 
        $('#cgst').val(''); 
        $('#sgst_amount').val(''); 
        $('#cgst_amount').val(''); 
        $('#taxable_amount').val(''); 
        $('#rate_basic').val('');  
        $('#qty').val('');  
        $('#amount').val('');  
        $('#rate').val('');  
        $('#total_amount').val('');  
        $('#non_schedule_yes').prop('checked', false);
        return
    }
       
    $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:{project_id:project_id,boq_code:boq_code},
            success:function(result){
                
               
                if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){
                    if(gst_type == 'igst') {
                        $('#gst').val(result.gst);  
                        $('#idc_boq_code').val(result.boq_code);    
                        $('#hsn_sac_code').val(result.hsn_sac_code);    
                        $('#hsn_sac_code').prop('readonly', true);
                        $('#item_description').val(result.item_description);    
                        $('#qty').val(exist_qty);     
                        $('#rate').val(result.rate);   
                        var itaxable_amount = 0;
                        if(exist_qty !== '' && typeof exist_qty !== "undefined" && parseFloat(exist_qty) > 0
                        && result.rate !== '' && typeof result.rate !== "undefined" && parseFloat(result.rate) > 0){
                        itaxable_amount = parseFloat(exist_qty) * parseFloat(result.rate);     
                        }
                        $('#itaxable_amount').val(parseFloat(itaxable_amount).toFixed(2));
                        var gst_amount = 0;
                        if(itaxable_amount !== '' && typeof itaxable_amount !== "undefined" && parseFloat(itaxable_amount) > 0
                        && result.gst !== '' && typeof result.gst !== "undefined" && parseFloat(result.gst) > 0){
                        gst_amount = (parseFloat(itaxable_amount) * (parseFloat(result.gst)/100)) + itaxable_amount;     
                        }
                        $('#itotal_amount').val(parseFloat(gst_amount).toFixed(2));
                        
                    }else{
                        
                        $('#idc_boq_code').val(result.boq_code);    
                        $('#hsn_sac_code').val(result.hsn_sac_code);    
                        $('#hsn_sac_code').prop('readonly', true);
                        $('#item_description').val(result.item_description);    
                        $('#qty').val(exist_qty);     
                        $('#rate').val(result.rate);
                        var itaxable_amount = 0;
                        if(exist_qty !== '' && typeof exist_qty !== "undefined" && parseFloat(exist_qty) > 0
                        && result.rate !== '' && typeof result.rate !== "undefined" && parseFloat(result.rate) > 0){
                        itaxable_amount = parseFloat(exist_qty) * parseFloat(result.rate);     
                        }
                        var gst_amount = 0;
                        if(itaxable_amount !== '' && typeof itaxable_amount !== "undefined" && parseFloat(itaxable_amount) > 0
                        && result.gst !== '' && typeof result.gst !== "undefined" && parseFloat(result.gst) > 0){
                        gst_amount = (parseFloat(itaxable_amount) * (parseFloat(result.gst)/100))/2;     
                        }
                        $('#sgst_amount').val(parseFloat(gst_amount).toFixed(2));
                        $('#cgst_amount').val(parseFloat(gst_amount).toFixed(2));
                        $('#sgst').val(result.gst/2);    
                        $('#cgst').val(result.gst/2);    
                    }
                    $('#item_description').prop('readonly', true);
                    $('#unit').val(result.unit);    
                    $('#unit').prop('readonly', true);
                    $('#avl_qty').val('12');    
                    $('#avl_qty').prop('readonly', true);
                }else{    
                    $('#hsn_sac_code').prop('readonly', false);
                    $('#item_description').prop('readonly', false);
                    $('#unit').prop('readonly', false);
                    $('#avl_qty').prop('readonly', false);


                    $('#hsn_sac_code').val(''); 
                    $('#item_description').val('');
                    $('#unit').val('');  
                    $('#scheduled_qty').val('');  
                    $('#design_qty').val('');
                    $('#sgst').val(''); 
                    $('#gst').val(''); 
                    $('#cgst').val(''); 
                    $('#sgst_amount').val(''); 
                    $('#cgst_amount').val(''); 
                    $('#taxable_amount').val(''); 
                    $('#rate_basic').val('');  
                    $('#qty').val('');  
                    $('#amount').val('');  
                    $('#rate').val('');  
                    $('#total_amount').val('');  
                    $('#non_schedule_yes').prop('checked', false);
                }        
            }
    });
});
$(document).on('keyup', '#cdc_boq_code', function() {
    $('#invaliderrorid').html('');
    var boq_code = $(this).val();
    var project_id = $('#project_id').val();
    var gst_type = $('#gst_type').val();
    var url = 'get_dc_boq_item_details';
    var exist_qty = 0;
    if(project_id !== '' && typeof project_id !== "undefined" && boq_code !== '' && typeof boq_code !== "undefined"){
        exist_qty = function () {
        var tmp = null;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'dataType': 'html',
            'url': completeURL('get_boq_final_qty'),
            'data': { 'boq_code': boq_code, 'project_id': project_id},
            'success': function (result) {
                tmp = result;
            }
        });
        return tmp;
        }();
    }
    if(boq_code == ''){
        $('#chsn_sac_code').val(''); 
        $('#citem_description').val('');
        $('#cunit').val('');  
        $('#scheduled_qty').val('');  
        $('#design_qty').val('');
        $('#sgst').val(''); 
        $('#gst').val(''); 
        $('#cgst').val(''); 
        $('#sgst_amount').val(''); 
        $('#cgst_amount').val(''); 
        $('#taxable_amount').val(''); 
        $('#rate_basic').val('');  
        $('#cqty').val('');  
        $('#amount').val('');  
        $('#crate').val('');  
        $('#total_amount').val('');  
        $('#non_schedule_yes').prop('checked', false);
        return
    }
       
    $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:{project_id:project_id,boq_code:boq_code},
            success:function(result){
                
                       
                if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){
                    // $('#dc_boq_code').val(result.boq_code);    
                    // $('#hsn_sac_code').val(result.hsn_sac_code);    
                    // $('#hsn_sac_code').prop('readonly', true);
                    // $('#item_description').val(result.item_description);    
                    // $('#rate').val(result.rate);   
                    if(gst_type == 'igst') {
                        $('#gst').val(result.gst);  
                        $('#cdc_boq_code').val(result.boq_code);    
                        $('#hsn_sac_code').val(result.hsn_sac_code);    
                        $('#hsn_sac_code').prop('readonly', true);
                        $('#item_description').val(result.item_description);    
                        $('#rate').val(result.rate);     
                        $('#qty').val(result.qty);     
                                          
                    }else{
                            
                        $('#cdc_boq_code').val(result.boq_code);    
                        $('#chsn_sac_code').val(result.hsn_sac_code);    
                        $('#chsn_sac_code').prop('readonly', true);
                        $('#citem_description').val(result.item_description);    
                        $('#crate').val(result.rate);
                        $('#cqty').val(result.qty);
                        $('#cunit').val(result.unit);    
                        $('#cunit').prop('readonly', true);   


                        $('#sgst').val(result.gst/2);    
                        $('#cgst').val(result.gst/2);    
                    }
                    $('#citem_description').prop('readonly', true);
                    $('#unit').val(result.unit);    
                    $('#unit').prop('readonly', true);
                    $('#avl_qty').val('12');    
                    $('#avl_qty').prop('readonly', true);
                }else{    
                    $('#hsn_sac_code').prop('readonly', false);
                    $('#item_description').prop('readonly', false);
                    $('#unit').prop('readonly', false);
                    $('#avl_qty').prop('readonly', false);


                    $('#hsn_sac_code').val(''); 
                    // $('#cdc_boq_code').val(''); 
                    $('#citem_description').val(''); 
                    $('#crate').val(''); 
                    $('#cunit').val(''); 
                    $('#chsn_sac_code').val(''); 
                    $('#item_description').val('');
                    $('#unit').val('');  
                    $('#scheduled_qty').val('');  
                    $('#design_qty').val('');
                    $('#sgst').val(''); 
                    $('#gst').val(''); 
                    $('#cgst').val(''); 
                    $('#sgst_amount').val(''); 
                    $('#cgst_amount').val(''); 
                    $('#taxable_amount').val(''); 
                    $('#rate_basic').val('');  
                    $('#qty').val('');  
                    $('#amount').val('');  
                    $('#rate').val('');  
                    $('#total_amount').val('');  
                    $('#non_schedule_yes').prop('checked', false);
                }        
            }
    });
});
$(document).on('keyup', '#boq_code_exceptional', function() {
    $('#invaliderrorid').html('');
    var boq_code = $(this).val();
    var project_id = $('#project_id').val();
    var url = 'get_boq_exceptional_item';
    if(boq_code == ''){
        $('#item_description').val('');
        $('#ea_qty').val('');  
    }
    $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:{project_id:project_id,boq_code:boq_code},
            success:function(result){
                if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){
                    $('#boq_code').val(result.boq_code);    
                    $('#item_description').val(result.item_description);    
                    $('#item_description').prop('readonly', true);
                    $('#ea_qty').val(result.ea_qty);    
                }else{
                    $('#item_description').prop('readonly', false);
                    $('#ea_qty').val(''); 
                }        
            }
    });
});
$(document).on('keyup', '#boq_code', function() {
    $('#invaliderrorid').html('');
    var boq_code = $(this).val();
    var project_id = $('#project_id').val();
    var url = 'get_boq_item_details';
    if(boq_code == ''){
        $('#hsn_sac_code').val(''); 
        $('#item_description').val('');
        $('#unit').val('');  
        $('#scheduled_qty').val('');  
        $('#design_qty').val('');
        $('#gst').val(''); 
        $('#rate_basic').val('');  
        $('#non_schedule_yes').prop('checked', false);

    }
    console.log(url);
    $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:{project_id:project_id,boq_code:boq_code},
            success:function(result){
                if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){
                    if(result.boq_status !== '' && typeof result.boq_status !== "undefined" && result.boq_status == 'Y'){
                        $('#boq_code').val(result.boq_code);
                        $('#hsn_sac_code').val(result.hsn_sac_code);
                        $('#hsn_sac_code').prop('readonly', true);
                        $('#item_description').val(result.item_description);    
                        $('#item_description').prop('readonly', true);
                        $('#unit').val(result.unit);    
                        $('#unit').prop('readonly', true);
                        $('#scheduled_qty').val(result.scheduled_qty);    
                        $('#scheduled_qty').prop('readonly', true);
                        $('#design_qty').val(result.design_qty);
                        $('#rate_basic').val(result.rate_basic);    
                        $('#rate_basic').prop('readonly', true);    
                        $('#gst').val(result.gst);
                        $('#gst').prop('readonly', true);
                        if(result.non_schedule == 'Y'){
                          $('#non_schedule_yes').prop('checked', true);
                          $('#non_schedule_no').prop('checked', false);
                        }else{
                          $('#non_schedule_yes').prop('checked', false);
                          $('#non_schedule_no').prop('checked', true);
                        }    
                    }else{
                        $('#hsn_sac_code').prop('readonly', false);
                        $('#item_description').prop('readonly', false);
                        $('#unit').prop('readonly', false);
                        $('#scheduled_qty').prop('readonly', false);
                        $('#rate_basic').prop('readonly', false);
                        $('#design_qty').prop('readonly', false);
                        $('#gst').prop('readonly', false);
                        $('#non_schedule_yes').prop('checked', false);
                        $('#non_schedule_no').prop('checked', true);
                        $('#hsn_sac_code').val(''); 
                        $('#item_description').val('');
                        $('#unit').val('');  
                        $('#scheduled_qty').val('');  
                        $('#design_qty').val('');
                        $('#gst').val(''); 
                        $('#rate_basic').val('');  
                        $('#non_schedule_yes').prop('checked', false);
                        $('#invaliderrorid').html('Please approved BOQ Sr No '+result.boq_code+'!');
                    }
                }else{
                    //$('#boq_code').prop('readonly', false);
                    $('#hsn_sac_code').prop('readonly', false);
                    $('#item_description').prop('readonly', false);
                    $('#unit').prop('readonly', false);
                    $('#scheduled_qty').prop('readonly', false);
                    $('#rate_basic').prop('readonly', false);
                    $('#design_qty').prop('readonly', false);
                    $('#gst').prop('readonly', false);
                    $('#non_schedule_yes').prop('checked', false);
                    $('#non_schedule_no').prop('checked', true);
                    $('#hsn_sac_code').val(''); 
                    $('#item_description').val('');
                    $('#unit').val('');  
                    $('#scheduled_qty').val('');  
                    $('#design_qty').val('');
                    $('#gst').val(''); 
                    $('#rate_basic').val('');  
                    $('#non_schedule_yes').prop('checked', false);
                    //$('#invaliderrorid').html('BOQ Sr No '+boq_code+' Not exist!');
                }        
            }
    });
    
});
$(document.body).on('click', '.date-picker' ,function(){
     if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            orientation: "right",
            autoclose: true
        });
    }
});
$(document).ready(function(){ 
      if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            orientation: "right",
            autoclose: true
        });
    }
    if (jQuery().datepicker) {
        $('.date-picker-18').datepicker({
            orientation: "right",
            autoclose: true,
            endDate: '-18y'
        });
    }
    $(document).on('click','.clearData', function(){
       var formId = '#'+$(this).parents('form').attr('id');
        $(formId).find('input:text, input:password, input:file, select,textarea').val('');
        $(formId).find('button:submit').removeAttr('disabled');
        $(formId).find('input:checkbox').removeAttr('checked').removeAttr('selected');
        $(formId).find('.select2-container').select2('val','0');

        $('html, body').animate({scrollTop:0});
    });
    $(".validate").validationEngine('attach', { 
        promptPosition: "topLeft", showOneMessage: true, maxErrorsPerField: 1, scroll: true 
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
$(document).on('click','.common_save',function(e){
    //e.preventDefault();
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
    $(form).validate({ 
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: ":hidden",  // validate all fields including form hidden input
        rules: {
                payment_date:{ required: true},
                payment_received_amount:{ required: true,number:true},
                invoice_date:{ required: true},
                invoice_no:{ required: true},
                invoice_amount:{ required: true},
                //remark:{ required: true},
                it_tds_amount:{ required: true,number:true},
                security_deposit_retn_amount:{ required: true,number:true},
                labour_cess:{ required: true,number:true},
                // debit_note:{ required: true},
                payment_advice_received:{ required: true},
                payment_advice_received_date:{ required: true},
                payment_advice_doc:{ required: true},
                gtds_amount:{ required: true,number:true },
                tds_amount:{ required: true,number:true },
                withheld_amount:{ required: true,number:true },
                upload_tds_doc:{ required: true },
                tds_confirmation_date:{ required: true },
                upload_withheld_doc:{ required: true },
                withheld_confirmation_date:{ required: true },
                upload_gtds_doc:{ required: true },
                return_date:{ required: true },
                confirmation_date:{ required: true },
                dc_no:{ required: true },
                virtual_stock_no:{ required: true },
                installed_wip_no:{ required: true },
                prov_wip_no:{ required: true },
                proforma_invoice_no:{ required: true },
                project_id:{ required: true },
                role_name:{ required: true },
                fullname:{ required:true , onlyletters :true },
                email: { required: true, email:true },
                mobile:{ number:true, minlength:10, maxlength:12, required:true },
                address:{ required: true },
                "role_id[]": 
                { 
                    required: true
                },
                "designation_id[]": 
                { 
                    required: true
                },
                username:{ required: true },
                password : {
                    minlength : 5
                },
                cpassword : {
                    minlength : 5,
                    equalTo : "#user_pass"
                },
                unit_name:{ required: true },
                prefix_name:{ required: true },
                tax_name:{ required: true },
                percentage_tax:{ required: true , percentage :true },
                designation_name:{ required: true },
                name_of_company:{ required:true , onlyletters :true },
                company_type:{ required: true },
                name_of_dir_part:{ required:true , onlyletters :true },
                dir_part_contact_no:{ number:true, minlength:10, maxlength:12, required:true },
                dir_part_contact_address:{ required: true },
                dir_cin_act_reng_nos:{ required: true ,onlyNumber: true},
                reg_house_building_no:{ required: true ,onlyNumber: true},
                reg_street:{ required:true },
                reg_country:{ required:true , onlyletters :true },
                corporate_house_building_no:{ required: true ,onlyNumber: true},
                contact_person_name:{ required:true , onlyletters :true },
                comm_mobile_phone:{ number:true, minlength:10, maxlength:12, required:true },
                comm_email:{ required:true, email:true },
                bank_acc_no_vendor:{ required: true ,onlyNumber: true},
                name_of_bank:{ required:true , onlyletters :true },
                name_of_branch:{ required:true , onlyletters :true },
                bank_ifsc_code:{ required:true  },
                bank_address:{ required:true },
                bank_city:{ required:true , onlyletters :true },
                bank_type_of_account:{ required:true },
                ref_vendor_emp_frd:{ required:true },
                reg_city_post_code:{ number:true },
                taxable_amount:{ number:true },
                gst_amount:{ number:true },
                total_amount:{ number:true },
                emd_paid_num:{ number:true },
                asd_paid_num:{ number:true },
                performance_guarantee_num:{ number:true },
                amount_of_risk_cov:{ number:true },
                bill_split_supply:{ percentage:true },
                bill_installation:{ percentage:true },
                testing_commissioning:{ percentage:true },
                bill_handover:{ percentage:true },
                amc_applicable_after:{ number:true },
                "boq_code[]": 
                { 
                    required: true
                },
                "hsn_sac_code[]": 
                { 
                    required: true
                },
                "item_description[]": 
                { 
                    required: true
                },
                "unit[]": 
                { 
                    required: true
                },
                "scheduled_qty[]": 
                { 
                    required: true
                },
                "design_qty[]": 
                { 
                    required: true
                },
                "ea_qty[]": 
                { 
                    required: true
                },
                "rate_basic[]": 
                { 
                    required: true
                },
                "gst[]": 
                { 
                    required: true
                },
                "non_schedule[]": 
                { 
                    required: true
                },
                gtds_amount:{ required: true,number:true},
                gtds_confirm_date:{ required: true},
                gtds_return_date:{ required: true},
                //gtds_doc:{ required: true},
                it_tds_amount:{ required: true,number:true},
                it_tds_confirm_date:{ required: true},
                //it_tds_doc:{ required: true},
                statutory_deductions:{ required: true,number:true},
                statutory_deductions_date:{ required: true},
                //statutory_deductions_doc:{ required: true},
        },
        invalidHandler: function (event, validator) { //display error alert on form submit              
            success.hide();
            error.show();
            // alert();
            //console.log('invalidHandler',event);
            //console.log('invalidHandler',validator);
            $('html,body').animate({scrollTop:0});
            $('#error_alert').show();
        },
        errorPlacement: function (error, element) { // render error placement for each input type
            // console.log('errorPlacement',error);
            // console.log('errorPlacement',element);
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
            //alert(completeURL(url));
            $(form).ajaxSubmit({
                type:'POST',
                url:completeURL(url), 
                dataType:'json',
                data:serialize_data,
                success:function(data)
                {  
                    Metronic.stopPageLoading(); 
                    $('.common_save').prop('disabled',false);
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
                }
            });
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
                if(url == "edit_proforma_invoice"){
                    $(".round-off-select").select2();
                }
            },
            complete:function(){
                Layout.init();
                Metronic.init(); // init metronic core components
                Layout.init();
            }
        }); 
    });
    $(document).on('click','.edit_performa', function(){
        var id = $(this).attr('rel');
        var url = $(this).attr('rev');
        $.ajax({
            url : completeURL(url),
            type : 'POST',
            dataType : 'html',
            data:{id:id},
            success:function(data)
            {    
                console.log(data);      
                $('html, body').animate({scrollTop:0});
                // $('.portlet-body').html($(data).find('.portlet-body').html());
                

                // $('#proformaInvclist').dataTable({
                //     // Processing indicator
                //     "paging": true,
                //     "iDisplayLength": 10,
                //     "deferRender": true,
                //     "responsive": true,
                //     "processing": true,
                //     "serverSide": true,
                //     // Initial no order.
                //     "order": [],
        
                //     // Load data from an Ajax source
                //     "ajax": {
                //         // "url": "<?php echo base_url('project_proformaInvc_list'); ?>",
                //         "url": completeURL('project_proformaInvc_list'),
                //         "type": "POST"
                //     },
        
                //     //Set column definition initialisation properties
                //     "columnDefs": [{
                //         "targets": [0],
                //         "orderable": false
                //     }]
                // });
            },
            complete:function(){
                Layout.init();
                Metronic.init(); // init metronic core components
                Layout.init();

               
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
    $(document).on('change','.role_configuration',function(){
        var id = $(this).val();
        if(id > 0){
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
        }else{
            $('.prevelege_data').html('');
        }
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
    $(document).on('click','.selected_val', function(){
        $('.selected_val').css({"border-color": "#eaeaea", "border-weight":"2px", "border-style":"solid"});
        if($('.address').is(":checked"))
        {
            $(this).css({"border-color": "#32c5d2", "border-weight":"2px", "border-style":"solid"});
        }
    }); 
    $(document).on('change', '.upload_sign_doc_file', function(){
        var url = $('.upload_sign_doc_file').data('url');
        var property = document.getElementById("upload_sign_doc_file").files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;
        var invalidformat = false;
        var maxFileSize = false;
        if(jQuery.inArray(image_extension, ['doc','pdf','txt','png','jpg','jpge','jpeg']) == -1)
        {          
            $('.sign_doc_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">Invalid File format!</lable>');
            $('.sign_doc_filename').html('');
            setTimeout(replce_sign_doc_file, 10);
            $('.sign_doc_filename').val('');
            $('.upload_sign_doc_button').html('Select File');
            $('#signfileloading').text('');
            invalidformat = true;
        }
        if(image_size > 5000000)
        {
            $('.sign_doc_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">File size is only upto 2MB!</lable>');
            $('.sign_doc_filename').html('');
            setTimeout(replce_sign_doc_file, 10);
            $('.sign_doc_filename').val('');
            $('.upload_sign_doc_button').html('Select File');
            $('#signfileloading').text('');
            maxFileSize = true;
        }
        if(invalidformat == false && maxFileSize == false)
        {
            
            var form_data = new FormData();
            form_data.append("file", property);
            $('.sign_doc_file_error').html('');
            $('#signfileloading').text('Uploading file, Please wait!');
            $.ajax({
                url:url,
                method:"POST",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function(data)
                {
                    $('.sign_doc_filename').html(data);
                    setTimeout(replce_sign_doc_file, 50);
                    $('.sign_doc_filename').val(data);
                    $('.upload_sign_doc_button').html('Change');
                    $('#signfileloading').text('');
                }
            });
        }
    });
    
    $(document).on('change','.duplicate',function(){
        var p_key = $(this).data('p_key');
        var id = $(this).attr('rel');
        var tbl = $(this).data('tbl');
        var where = $(this).data('where');
        var value = $(this).val();
        var this1 = $(this);
        $(this).closest('div').find('.help-block').remove();
        $.ajax({
            type:'POST',
            url:completeURL('duplicate'),
            data:{id:id,p_key:p_key,tbl:tbl,where:where,value:value},
            dataType:'json',
            success:function(data)
            { 
                if(data.valid)
                {
                    this1.closest('div').append('<span class="help-block">'+data.msg+'</span>');
                    this1.val("");                    
                    //this1.select2('val','');                    
                    this1.closest('.form-group').addClass('has-error');
                    this1.closest('div').find('i').addClass('fa-warning').removeClass('fa-check');                    
                }
                else
                {
                    this1 .closest('.form-group').removeClass('has-error').addClass('has-success');
                    this1.closest('div').find('i').addClass('fa-check').removeClass('fa-warning');
                }

                
            }
        });
    });
    $(document).on('keyup','.payment_received_amount_chk',function(e){
        e.preventDefault();
        var tax_invoice_id = $(this).attr('data-id');
        var amount_type = $(this).attr('data-type');
        var payment_received_amount = $('#payment_received_amount').val();

        if(payment_received_amount !== '' && typeof payment_received_amount !== "undefined" && parseFloat(payment_received_amount) > 0){
            payment_received_amount = parseFloat(payment_received_amount);
        }
        var retenstion_amount = $("#retenstion_amount").val();
        if(retenstion_amount !== '' && typeof retenstion_amount !== "undefined" && parseFloat(retenstion_amount) > 0){
            retenstion_amount = parseFloat(retenstion_amount);
        }
        var it_tds_amount = $('#it_tds_amount').val();
        if(it_tds_amount !== '' && typeof it_tds_amount !== "undefined" && parseFloat(it_tds_amount) > 0){
            it_tds_amount = parseFloat(it_tds_amount);
        }
        var gtds_amount = $('#gtds_amount').val();
        if(gtds_amount !== '' && typeof gtds_amount !== "undefined" && parseFloat(gtds_amount) > 0){
            gtds_amount = parseFloat(gtds_amount);
        }
        var tax_deduction_amt = 0;
        $(".tax_deduction_amt").each(function() {
            tax_deduction_amt += parseFloat($(this).val());
        });
        if(tax_deduction_amt !== '' && typeof tax_deduction_amt !== "undefined" && parseFloat(tax_deduction_amt) > 0){
            tax_deduction_amt = parseFloat(tax_deduction_amt);
        }
        var security_deposit_retn_amount = $('#security_deposit_retn_amount').val();
        if(security_deposit_retn_amount !== '' && typeof security_deposit_retn_amount !== "undefined" && parseFloat(security_deposit_retn_amount) > 0){
            security_deposit_retn_amount = parseFloat(security_deposit_retn_amount);
        }
        var deposit_amount = 0;
        $(".deposit_amount").each(function() {
            deposit_amount += parseFloat($(this).val());
        });
        if(deposit_amount !== '' && typeof deposit_amount !== "undefined" && parseFloat(deposit_amount) > 0){
            deposit_amount = parseFloat(deposit_amount);
        }
        var withheld_amt = 0;
        $(".withheld_amt").each(function() {
            withheld_amt += parseFloat($(this).val());
        });
        if(withheld_amt !== '' && typeof withheld_amt !== "undefined" && parseFloat(withheld_amt) > 0){
            withheld_amt = parseFloat(withheld_amt);
        }
        var labour_cess = $('#labour_cess').val();
        if(labour_cess !== '' && typeof labour_cess !== "undefined" && parseFloat(labour_cess) > 0){
            labour_cess = parseFloat(labour_cess);
        }
        var other_cess_amt = 0;
        $(".other_cess_amt").each(function() {
            other_cess_amt += parseFloat($(this).val());
        });
        if(other_cess_amt !== '' && typeof other_cess_amt !== "undefined" && parseFloat(other_cess_amt) > 0){
            other_cess_amt = parseFloat(other_cess_amt);
        }
        var deduction_amt = 0;
        $(".deduction_amt").each(function() {
            deduction_amt += parseFloat($(this).val());
        });
        if(deduction_amt !== '' && typeof deduction_amt !== "undefined" && parseFloat(deduction_amt) > 0){
            deduction_amt = parseFloat(deduction_amt);
        }
        var this1 = $(this);
        $(this).closest('div').find('.help-block').remove();
        $.ajax({
            type:'POST',
            url:completeURL('payment_received_amount_chk'),
            data:{tax_invoice_id:tax_invoice_id,amount_type:amount_type,payment_received_amount:payment_received_amount,retenstion_amount:retenstion_amount,it_tds_amount:it_tds_amount,
            gtds_amount:gtds_amount,tax_deduction_amt:tax_deduction_amt,security_deposit_retn_amount:security_deposit_retn_amount,
            deposit_amount:deposit_amount,withheld_amt:withheld_amt,labour_cess:labour_cess,other_cess_amt:other_cess_amt,deduction_amt:deduction_amt},
            dataType:'json',
            success:function(data)
            { 
                if(data.valid)
                {
                    this1.closest('div').append('<span class="help-block">'+data.msg+'</span>');
                    this1.val("");                    
                    this1.closest('.form-group').addClass('has-error');
                    this1.closest('div').find('i').addClass('fa-warning').removeClass('fa-check');                    
                }
                else
                {
                    this1 .closest('.form-group').removeClass('has-error').addClass('has-success');
                    this1.closest('div').find('i').addClass('fa-check').removeClass('fa-warning');
                }

                
            }
        });
    });
    $(document).on('click','.status_change' , function(){
        var deleteDiv = $(this);
        bootbox.confirm("Are you sure?", function(result) 
        {
            if(result)
            {
                var id = deleteDiv.attr('rel');
                var url = deleteDiv.attr('rev');             
                // var status = deleteDiv.data('status');                
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
    $(document).on('change', '.upload_file', function(){
        var url = $('.upload_file').data('url');
        var property = document.getElementById("file").files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;
        var invalidformat = false;
        var maxFileSize = false;
        if(jQuery.inArray(image_extension, ['doc','pdf','txt','png','jpg','jpge','jpeg']) == -1)
        {          
            $('.img_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">Invalid File format!</lable>');
            invalidformat = true;
        }
        if(image_size > 5000000)
        {
            $('.img_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">File size is only upto 2MB!</lable>');
            maxFileSize = true;
        }
        if(invalidformat == false && maxFileSize == false)
        {
            var form_data = new FormData();
            form_data.append("file", property);
            $.ajax({
                url:url,
                method:"POST",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function(data)
                {
                    $('.fileinput-filename').html(data);
                    setTimeout(replce_file, 50);
                    $('.file_name').val(data);
                    $('.upload_button').html('Change');
                }
            });
        }
    });
    $(document).on('change', '.upload_emd_paid_file', function(){
        var url = $('.upload_emd_paid_file').data('url');
        var property = document.getElementById("upload_emd_paid_file").files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;
        var invalidformat = false;
        var maxFileSize = false;
        if(jQuery.inArray(image_extension, ['doc','pdf','txt','png','jpg','jpge','jpeg']) == -1)
        {          
            $('.emd_paid_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">Invalid File format!</lable>');
            $('.emd_paid_filename').html('');
            setTimeout(replce_emd_paid_file, 10);
            $('.emd_paid_filename').val('');
            $('.upload_emd_paid_button').html('Select File');
            $('#emdfileloading').text('');
            invalidformat = true;
        }
        if(image_size > 5000000)
        {
            $('.emd_paid_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">File size is only upto 2MB!</lable>');
            $('.emd_paid_filename').html('');
            setTimeout(replce_emd_paid_file, 10);
            $('.emd_paid_filename').val('');
            $('.upload_emd_paid_button').html('Select File');
            $('#emdfileloading').text('');
            maxFileSize = true;
        }
        if(invalidformat == false && maxFileSize == false)
        {
            var form_data = new FormData();
            form_data.append("file", property);
            $('.emd_paid_file_error').html('');
            $('#emdfileloading').text('Uploading file, Please wait!');
            $.ajax({
                url:url,
                method:"POST",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function(data)
                {
                    $('.emd_paid_filename').html(data);
                    setTimeout(replce_emd_paid_file, 10);
                    $('.emd_paid_filename').val(data);
                    $('.upload_emd_paid_button').html('Change');
                    $('.emd_paid_file_error').html('');
                    $('#emdfileloading').text('');
                }
            });
        }
    });
    $(document).on('change', '.upload_projectdesig_doc_file', function(){
        var url = $('.upload_projectdesig_doc_file').data('url');
        var property = document.getElementById("upload_projectdesig_doc_file").files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;
        var invalidformat = false;
        var maxFileSize = false;
        if(jQuery.inArray(image_extension, ['doc','pdf','txt','png','jpg','jpge','jpeg']) == -1)
        {          
            $('.projectdesig_doc_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">Invalid File format!</lable>');
            $('.projectdesig_doc_filename').html('');
            setTimeout(replce_projectdesig_doc_file, 10);
            $('.projectdesig_doc_filename').val('');
            $('.upload_projectdesig_doc_button').html('Select File');
            $('#projectdesigfileloading').text('');
            invalidformat = true;
        }
        if(image_size > 5000000)
        {
            $('.projectdesig_doc_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">File size is only upto 2MB!</lable>');
            $('.projectdesig_doc_filename').html('');
            setTimeout(replce_projectdesig_doc_file, 10);
            $('.projectdesig_doc_filename').val('');
            $('.upload_projectdesig_doc_button').html('Select File');
            $('#projectdesigfileloading').text('');
            maxFileSize = true;
        }
        if(invalidformat == false && maxFileSize == false)
        {
            
            var form_data = new FormData();
            form_data.append("file", property);
            $('.projectdesig_doc_file_error').html('');
            $('#projectdesigfileloading').text('Uploading file, Please wait!');
            $.ajax({
                url:url,
                method:"POST",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function(data)
                {
                    $('.projectdesig_doc_filename').html(data);
                    setTimeout(replce_projectdesig_doc_file, 50);
                    $('.projectdesig_doc_filename').val(data);
                    $('.upload_projectdesig_doc_button').html('Change');
                    $('#projectdesigfileloading').text('');
                }
            });
        }
    });
    $(document).on('change', '.upload_projectcashflw_doc_file', function(){
        var url = $('.upload_projectcashflw_doc_file').data('url');
        var property = document.getElementById("upload_projectcashflw_doc_file").files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;
        var invalidformat = false;
        var maxFileSize = false;
        if(jQuery.inArray(image_extension, ['doc','pdf','txt','png','jpg','jpge','jpeg']) == -1)
        {          
            $('.projectcashflw_doc_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">Invalid File format!</lable>');
            $('.projectcashflw_doc_filename').html('');
            setTimeout(replce_projectcashflw_doc_file, 10);
            $('.projectcashflw_doc_filename').val('');
            $('.upload_projectcashflw_doc_button').html('Select File');
            $('#projectcashflwfileloading').text('');
            invalidformat = true;
        }
        if(image_size > 5000000)
        {
            $('.projectcashflw_doc_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">File size is only upto 2MB!</lable>');
            $('.projectcashflw_doc_filename').html('');
            setTimeout(replce_projectcashflw_doc_file, 10);
            $('.projectcashflw_doc_filename').val('');
            $('.upload_projectcashflw_doc_button').html('Select File');
            $('#projectcashflwfileloading').text('');
            maxFileSize = true;
        }
        if(invalidformat == false && maxFileSize == false)
        {
            
            var form_data = new FormData();
            form_data.append("file", property);
            $('.projectcashflw_doc_file_error').html('');
            $('#projectcashflwfileloading').text('Uploading file, Please wait!');
            $.ajax({
                url:url,
                method:"POST",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function(data)
                {
                    $('.projectcashflw_doc_filename').html(data);
                    setTimeout(replce_projectcashflw_doc_file, 50);
                    $('.projectcashflw_doc_filename').val(data);
                    $('.upload_projectcashflw_doc_button').html('Change');
                    $('#projectcashflwfileloading').text('');
                }
            });
        }
    });
    $(document).on('change', '.upload_projectinvstsch_doc_file', function(){
        var url = $('.upload_projectinvstsch_doc_file').data('url');
        var property = document.getElementById("upload_projectinvstsch_doc_file").files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;
        var invalidformat = false;
        var maxFileSize = false;
        if(jQuery.inArray(image_extension, ['doc','pdf','txt','png','jpg','jpge','jpeg']) == -1)
        {          
            $('.projectinvstsch_doc_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">Invalid File format!</lable>');
            $('.projectinvstsch_doc_filename').html('');
            setTimeout(replce_projectinvstsch_doc_file, 10);
            $('.projectinvstsch_doc_filename').val('');
            $('.upload_projectinvstsch_doc_button').html('Select File');
            $('#projectinvstschfileloading').text('');
            invalidformat = true;
        }
        if(image_size > 5000000)
        {
            $('.projectinvstsch_doc_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">File size is only upto 2MB!</lable>');
            $('.projectinvstsch_doc_filename').html('');
            setTimeout(replce_projectinvstsch_doc_file, 10);
            $('.projectinvstsch_doc_filename').val('');
            $('.upload_projectinvstsch_doc_button').html('Select File');
            $('#projectinvstschfileloading').text('');
            maxFileSize = true;
        }
        if(invalidformat == false && maxFileSize == false)
        {
            
            var form_data = new FormData();
            form_data.append("file", property);
            $('.projectinvstsch_doc_file_error').html('');
            $('#projectinvstschfileloading').text('Uploading file, Please wait!');
            $.ajax({
                url:url,
                method:"POST",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function(data)
                {
                    $('.projectinvstsch_doc_filename').html(data);
                    setTimeout(replce_projectinvstsch_doc_file, 50);
                    $('.projectinvstsch_doc_filename').val(data);
                    $('.upload_projectinvstsch_doc_button').html('Change');
                    $('#projectinvstschfileloading').text('');
                }
            });
        }
    });
    
    $(document).on('change', '.upload_draft_doc_file', function(){
        var url = $('.upload_draft_doc_file').data('url');
        var property = document.getElementById("upload_draft_doc_file").files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;
        var invalidformat = false;
        var maxFileSize = false;
        if(jQuery.inArray(image_extension, ['doc','pdf','txt','png','jpg','jpge','jpeg']) == -1)
        {          
            $('.draft_doc_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">Invalid File format!</lable>');
            $('.draft_doc_filename').html('');
            setTimeout(replce_draft_doc_file, 10);
            $('.draft_doc_filename').val('');
            $('.upload_draft_doc_button').html('Select File');
            $('#draftfileloading').text('');
            invalidformat = true;
        }
        if(image_size > 5000000)
        {
            $('.draft_doc_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">File size is only upto 2MB!</lable>');
            $('.draft_doc_filename').html('');
            setTimeout(replce_draft_doc_file, 10);
            $('.draft_doc_filename').val('');
            $('.upload_draft_doc_button').html('Select File');
            $('#draftfileloading').text('');
            maxFileSize = true;
        }
        if(invalidformat == false && maxFileSize == false)
        {
            
            var form_data = new FormData();
            form_data.append("file", property);
            $('.draft_doc_file_error').html('');
            $('#draftfileloading').text('Uploading file, Please wait!');
            $.ajax({
                url:url,
                method:"POST",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function(data)
                {
                    $('.draft_doc_filename').html(data);
                    setTimeout(replce_draft_doc_file, 50);
                    $('.draft_doc_filename').val(data);
                    $('.upload_draft_doc_button').html('Change');
                    $('#draftfileloading').text('');
                }
            });
        }
    });
    $(document).on('change', '.upload_projectcmpl_doc_file', function(){
        var url = $('.upload_projectcmpl_doc_file').data('url');
        var property = document.getElementById("upload_projectcmpl_doc_file").files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;
        var invalidformat = false;
        var maxFileSize = false;
        if(jQuery.inArray(image_extension, ['doc','pdf','txt','png','jpg','jpge','jpeg']) == -1)
        {          
            $('.projectcmpl_doc_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">Invalid File format!</lable>');
            $('.projectcmpl_doc_filename').html('');
            setTimeout(replce_projectcmpl_doc_file, 10);
            $('.projectcmpl_doc_filename').val('');
            $('.upload_projectcmpl_doc_button').html('Select File');
            $('#projectcmplfileloading').text('');
            invalidformat = true;
        }
        if(image_size > 5000000)
        {
            $('.projectcmpl_doc_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">File size is only upto 2MB!</lable>');
            $('.projectcmpl_doc_filename').html('');
            setTimeout(replce_projectcmpl_doc_file, 10);
            $('.projectcmpl_doc_filename').val('');
            $('.upload_projectcmpl_doc_button').html('Select File');
            $('#projectcmplfileloading').text('');
            maxFileSize = true;
        }
        if(invalidformat == false && maxFileSize == false)
        {
            
            var form_data = new FormData();
            form_data.append("file", property);
            $('.projectcmpl_doc_file_error').html('');
            $('#projectcmplfileloading').text('Uploading file, Please wait!');
            $.ajax({
                url:url,
                method:"POST",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function(data)
                {
                    $('.projectcmpl_doc_filename').html(data);
                    setTimeout(replce_projectcmpl_doc_file, 50);
                    $('.projectcmpl_doc_filename').val(data);
                    $('.upload_projectcmpl_doc_button').html('Change');
                    $('#projectcmplfileloading').text('');
                }
            });
        }
    });
    
    $(document).on('change', '.upload_asd_paid_file', function(){
        var url = $('.upload_asd_paid_file').data('url');
        var property = document.getElementById("upload_asd_paid_file").files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;
        var invalidformat = false;
        var maxFileSize = false;
        if(jQuery.inArray(image_extension, ['doc','pdf','txt','png','jpg','jpge','jpeg']) == -1)
        {          
            $('.asd_paid_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">Invalid File format!</lable>');
            $('.asd_paid_filename').html('');
            setTimeout(replce_asd_paid_file, 10);
            $('.asd_paid_filename').val('');
            $('.upload_asd_paid_button').html('Select File');
            $('#asdfileloading').text('');
            invalidformat = true;
        }
        if(image_size > 5000000)
        {
            $('.asd_paid_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">File size is only upto 2MB!</lable>');
            $('.asd_paid_filename').html('');
            setTimeout(replce_asd_paid_file, 10);
            $('.asd_paid_filename').val('');
            $('.upload_asd_paid_button').html('Select File');
            $('#asdfileloading').text('');
            maxFileSize = true;
        }
        if(invalidformat == false && maxFileSize == false)
        {
            
            var form_data = new FormData();
            form_data.append("file", property);
            $('.asd_paid_file_error').html('');
            $('#asdfileloading').text('Uploading file, Please wait!');
            $.ajax({
                url:url,
                method:"POST",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function(data)
                {
                    $('.asd_paid_filename').html(data);
                    setTimeout(replce_asd_paid_file, 50);
                    $('.asd_paid_filename').val(data);
                    $('.upload_asd_paid_button').html('Change');
                    $('#asdfileloading').text('');
                }
            });
        }
    });
    $(document).on('change', '.upload_security_desposite_file', function(){
        var url = $('.upload_security_desposite_file').data('url');
        var property = document.getElementById("upload_security_desposite_file").files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;
        var invalidformat = false;
        var maxFileSize = false;
        if(jQuery.inArray(image_extension, ['doc','pdf','txt','png','jpg','jpge','jpeg']) == -1)
        {          
            $('.security_desposite_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">Invalid File format!</lable>');
            invalidformat = true;
        }
        if(image_size > 5000000)
        {
            $('.security_desposite_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">File size is only upto 2MB!</lable>');
            maxFileSize = true;
        }
        if(invalidformat == false && maxFileSize == false)
        {
            var form_data = new FormData();
            form_data.append("file", property);
            $.ajax({
                url:url,
                method:"POST",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function(data)
                {
                    $('.security_desposite_filename').html(data);
                    setTimeout(replce_security_desposite_file, 50);
                    $('.security_desposite_filename').val(data);
                    $('.upload_security_desposite_button').html('Change');
                }
            });
        }
    });
    $(document).on('change', '.upload_performance_paid_file', function(){
        var url = $('.upload_performance_paid_file').data('url');
        var property = document.getElementById("upload_performance_paid_file").files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;
        var invalidformat = false;
        var maxFileSize = false;
        if(jQuery.inArray(image_extension, ['doc','pdf','txt','png','jpg','jpge','jpeg']) == -1)
        {          
            $('.performance_paid_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">Invalid File format!</lable>');
            $('.performance_paid_filename').html('');
            setTimeout(replce_performance_paid_file, 10);
            $('.performance_paid_filename').val('');
            $('.upload_performance_paid_button').html('Select File');
            $('#perffileloading').text('');
            invalidformat = true;
        }
        if(image_size > 5000000)
        {
            $('.performance_paid_file_error').html('<lable class="text-danger bold" style="position: absolute;top: 75%;left: 7%;">File size is only upto 2MB!</lable>');
            $('.performance_paid_filename').html('');
            setTimeout(replce_performance_paid_file, 10);
            $('.performance_paid_filename').val('');
            $('.upload_performance_paid_button').html('Select File');
            $('#perffileloading').text('');
            maxFileSize = true;
        }
        if(invalidformat == false && maxFileSize == false)
        {
            
            $('.performance_paid_file_error').html('');
            $('#perffileloading').text('Uploading file, Please wait!');
            var form_data = new FormData();
            form_data.append("file", property);
            $.ajax({
                url:url,
                method:"POST",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function(data)
                {
                    $('.performance_paid_filename').html(data);
                    setTimeout(replce_performance_paid_file, 10);
                    $('.performance_paid_filename').val(data);
                    $('.upload_performance_paid_button').html('Change');
                    $('#perffileloading').text('');
                }
            });
        }
    });
    $(document).on('change', '.upload_boq_excel_file', function(){
        var url = $('.upload_boq_excel_file').data('url');
        var property = document.getElementById("upload_boq_excel_file").files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        var image_size = property.size;
        var invalidformat = false;
        var maxFileSize = false;
        if(jQuery.inArray(image_extension, ['doc','pdf','txt','xlsx','.csv']) == -1)
        {          
            $('.boq_file_error').html('<lable class="text-danger bold" style="position: absolute; top: 36%; left: 30%;">Invalid File format!</lable>');
            invalidformat = true;
        }
        if(image_size > 5000000)
        {
            $('.boq_file_error').html('<lable class="text-danger bold" style="position: absolute; top: 36%; left: 30%;">File size is only upto 2MB!</lable>');
            maxFileSize = true;
        }
        if(invalidformat == false && maxFileSize == false)
        {
            var form_data = new FormData();
            form_data.append("file", property);
            $.ajax({
                url:url,
                method:"POST",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function(data)
                {
                    $('.boq_excel_filename').html(data);
                    setTimeout(replce_boq_file, 50);
                    $('.boq_excel_filename').val(data);
                    $('.upload_boq_file_button').html('Change');
                }
            });
        }
    });
    $(document).on('click','.deleteParticularRow', function(){ 
        $(this).closest('tr').remove();   
    });
    $(document).on('click','.deletedccRow', function(){ 
        $(this).closest('tr').remove();   
    });
    $(document).on('click','.deleteBoqExceptnRow', function(){ 
        $(this).closest('tr').remove();   
        var total_taxable_amount = 0;
        $("input[name='taxable_amount[]']").each(function() {
            total_taxable_amount += parseFloat($(this).val());
        });
        $('#PO_taxable_amt').val(parseFloat(total_taxable_amount).toFixed(2));
        
        var total_gst_amount = 0;
        $("input[name='gst_amount[]']").each(function() {
            total_gst_amount += parseFloat($(this).val());
        });
        $('#gst_amount').val(parseFloat(total_gst_amount).toFixed(2));
        var po_final_amount = 0;
        po_final_amount = parseFloat(total_taxable_amount) + parseFloat(total_gst_amount);
        $('#po_final_amount').val(parseFloat(po_final_amount).toFixed(2));
    });
    $(document).on('click','.deleteDccWIRow', function(){ 
        $(this).closest('tr').remove(); 
        var total = 0;
        $("input[name='total_rate[]']").each(function() {
            total += parseFloat($(this).val());
        });
        $('#dcwi_sub_total').html(parseFloat(total).toFixed(2));
    });
    $(document).on('click','.deleteDccITIRow', function(){ 
        $(this).closest('tr').remove(); 
        var total = 0;
        $("input[name='itaxable_amount[]']").each(function() {
            total += parseFloat($(this).val());
        });
        $('#dcwi_sub_total1').html(parseFloat(total).toFixed(2));
        var total_gst_amt = 0;
        $("input[name='gst_amount[]']").each(function() {
            total_gst_amt += parseFloat($(this).val());
        });
        var dcwi_igst_final = 0
        dcwi_igst_final = parseFloat(total_gst_amt) + parseFloat(total);
        $('#dcwi1_igst').html(parseFloat(total_gst_amt).toFixed(2));
        $('#dcwi_igst_final').html(parseFloat(dcwi_igst_final).toFixed(2));
    });
    $(document).on('click','.deleteDccITIRowIntra', function(){ 
        $(this).closest('tr').remove(); 
        var total = 0;
        $("input[name='ctaxable_amount[]']").each(function() {
            total += parseFloat($(this).val());
        });
        var total_sgst_amt = 0;
        $("input[name='sgst_amount[]']").each(function() {
            total_sgst_amt += parseFloat($(this).val());
        });
        var total_cgst_amt = 0;
        $("input[name='cgst_amount[]']").each(function() {
            total_cgst_amt += parseFloat($(this).val());
        });
        $('#dcwi_sub_total2').html(parseFloat(total).toFixed(2));
        $('#dcwi2_cgst_total').html(parseFloat(total_cgst_amt).toFixed(2));
        $('#dcwi2_sgst_total').html(parseFloat(total_sgst_amt).toFixed(2));
        var dcwi_igst_final = 0;
        dcwi_igst_final = parseFloat(total_sgst_amt) + parseFloat(total_cgst_amt) + parseFloat(total);
        $('#dcwi_igst_final2').html(parseFloat(dcwi_igst_final).toFixed(2));
    });
    
    $(document).on('click','.deletePerfomaInvcRow1', function(){ 
        $(this).closest('tr').remove(); 
        var total = 0;
        $("input[name='proforma_itaxable_amount[]']").each(function() {
            total += parseFloat($(this).val());
        });
        var total_cgst_amt = 0;
        $("input[name='proforma_cgst_amount[]']").each(function() {
            total_cgst_amt += parseFloat($(this).val());
        });
        
        var total_sgst_amt = 0;
        $("input[name='proforma_sgst_amount[]']").each(function() {
            total_sgst_amt += parseFloat($(this).val());
        });
        
        $('#proforma_sub_total1').html(parseFloat(total).toFixed(2));
        $('#proforma_cgst_total1').html(parseFloat(total_cgst_amt).toFixed(2));
        $('#proforma_sgst_total1').html(parseFloat(total_sgst_amt).toFixed(2));
        var proforma_final = 0;
        proforma_final = parseFloat(total_sgst_amt) + parseFloat(total_cgst_amt) + parseFloat(total);
        $('#proforma_final1').html(parseFloat(proforma_final).toFixed(2));
        $("#billing_split_up").trigger("change");
    });
    $(document).on('click','.deletePerfomaInvcRow', function(){ 
        $(this).closest('tr').remove(); 
        var total = 0;
        $("input[name='proforma_itaxable_amount[]']").each(function() {
            total += parseFloat($(this).val());
        });
        var total_gst_amt = 0;
        $("input[name='proforma_gst_amount[]']").each(function() {
            total_gst_amt += parseFloat($(this).val());
        });
        $('#proforma_sub_total').html(parseFloat(total).toFixed(2));
        $('#proforma_total_gst').html(parseFloat(total_gst_amt).toFixed(2));
        var proforma_igst_final = 0;
        proforma_igst_final = parseFloat(total_gst_amt) + parseFloat(total);
        $('#proforma_igst_final').html(parseFloat(proforma_igst_final).toFixed(2));
    });
    
    $(document).on('click','.deletedciwipRow', function(){ 
        $(this).closest('tr').remove();   
    });
    $(document).on('click','.deleteProformaInvcRow', function(){ 
        $(this).closest('tr').remove();   
        var k=0; 
        $("tbody.addProformaInvcRow  tr").each(function() {
            k++;
            $(this).find('input[type=radio]').val(k);
        });  

        var total_amt = 0;
        var gst_amt = 0;
        var final_amt = 0;


        $("input[name='amount[]']").each(function(){
            total_amt = parseFloat($(this).val());
        });
        $('#subtotal').html(total_amt.toFixed(2));
        if(total_amt > 0){
            gst_amt = parseFloat(total_amt) * 0.09;   
        }
        $('.gst_amt').html(gst_amt.toFixed(2));
        final_amt = parseFloat(gst_amt) + parseFloat(gst_amt) + parseFloat(total_amt);
        $('#finaltotal').html(final_amt.toFixed(2));
    });
    $(document).on('click','.deleteTaxInvcRow', function(){ 
        $(this).closest('tr').remove();  
        var gst_type = $('#gst_type').val(); 
        var k=0; 
        $("tbody.addTaxInvcRow  tr").each(function() {
            k++;
            $(this).find('input[type=radio]').val(k);
        });

            if(gst_type == "cgst_sgst"){
   

                var total_amt = 0;
                                var gst_amt = 0;
                                var cgst_amt = 0;
                                var final_amt = 0;
                                $("input[name='ctaxable_amount[]']").each(function(){
                                    total_amt += parseFloat($(this).val());
                                });
                                $('#subtotal').html(total_amt.toFixed(2));

                                if(total_amt > 0){
                                    $("input[name='sgst_amount[]']").each(function(){
                                        gst_amt += parseFloat($(this).val());
                                    });

                                    $("input[name='cgst_amount[]']").each(function(){
                                        cgst_amt += parseFloat($(this).val());
                                    });
                                    
                                    gst_amt = parseFloat(gst_amt);   
                                    cgst_amt = parseFloat(cgst_amt);   
                                }

                                $('.gst_amt').html(gst_amt.toFixed(2));
                                final_amt = parseFloat(gst_amt) + parseFloat(cgst_amt) + parseFloat(total_amt) + parseFloat(final_amt);
                                console.log(final_amt);
                                $('#finaltotalaq').html(final_amt.toFixed(2));

            }else{

                var total_amt = 0;
                                var gst_amt = 0;
                                var final_amt = 0;
                                $("input[name='itaxable_amount[]']").each(function(){
                                    total_amt += parseFloat($(this).val());
                                });
                                $('#subtotali').html(total_amt.toFixed(2));
                                if(total_amt > 0){

                                    $("input[name='itotal_amount[]']").each(function(){
                                        gst_amt += parseFloat($(this).val());
                                    });

                                    // gst_amt = parseFloat(total_amt) * 0.09;   
                                }
                                $('.cgst_amt').html(gst_amt.toFixed(2));
                                final_amt = parseFloat(gst_amt) + parseFloat(total_amt);
                                $('#finaltotal').html(final_amt.toFixed(2));







            }

    });



    
    $(document).on('click','.deletedcpwipRow', function(){ 
        $(this).closest('tr').remove();   
        var k=0; 
        $("tbody.addDCPWIPRow  tr").each(function() {
            k++;
            $(this).find('input[type=radio]').val(k);
        });  
    });
    
    $(document).on('click','.deletedcvsRow', function(){ 
        $(this).closest('tr').remove();   
        var k=0; 
        $("tbody.addDCVSRow  tr").each(function() {
            k++;
            $(this).find('input[type=radio]').val(k);
        });  
    });
    $(document).on('keyup','#qty',function()
    {        
        var gst_type = $('#gst_type').val();
        var qty = document.getElementById("qty").value;
        var rate = document.getElementById("rate").value;
        if(gst_type != 'igst'){

            var sgst = document.getElementById("sgst").value;
            var cgst = document.getElementById("cgst").value;
        }
        if(gst_type == 'igst'){

            var gst = document.getElementById("gst").value;
        }
        
        if(qty > 0 && rate > 0 ){
            var amount = qty * rate;
            // var tax_amount = (gst / 100) * amount;
            if(gst_type == 'igst'){
                var igst_amount = (gst / 100) * amount;

                $('#itotal_amount').val(igst_amount);
               
                $('#itaxable_amount').val(amount);


            }
            
            $('#taxable_amount').val(amount);
            // $('#amount').val(amount);
            // $('#total_amount').val(amount + tax_amount);
        }else{
            // $('#amount').val('0');
            $('#taxable_amount').val('0');
            $('#total_amount').val('0');

            if(gst_type == 'igst'){
                $('#itaxable_amount').val('0');
            $('#itotal_amount').val('0');

            }
        }

    if(qty > 0 && rate > 0 && sgst > 0){
        var taxable_amount = document.getElementById("taxable_amount").value;
        var sgst_amount = (sgst / 100) * taxable_amount;
        $('#sgst_amount').val(sgst_amount);
   
    }else{
        // $('#taxable_amount').val('0');
        // $('#sgst').val('0');
        $('#sgst_amount').val('0');
      //  $('#cgst').val('0');
        $('#cgst_amount').val('0');

    }

    if(qty > 0 && rate > 0 && cgst > 0){
        var taxable_amount = document.getElementById("taxable_amount").value;
        var cgst_amount = (sgst / 100) * taxable_amount;
        $('#cgst_amount').val(cgst_amount);

    }else{
        // $('#taxable_amount').val('0');
        // $('#cgst').val('0');
        $('#cgst_amount').val('0');
        $('#sgst_amount').val('0');

    }
    });
    $(document).on('keyup','#cqty',function()
    {        
        var gst_type = $('#gst_type').val();
        var qty = document.getElementById("cqty").value;
        var rate = document.getElementById("crate").value;
        if(gst_type != 'igst'){

            var sgst = document.getElementById("sgst").value;
            var cgst = document.getElementById("cgst").value;
        }
        
        if(qty > 0 && rate > 0 ){
            var amount = qty * rate;
            // var tax_amount = (gst / 100) * amount;
            if(gst_type == 'igst'){
                var igst_amount = (gst / 100) * amount;

                $('#itotal_amount').val(igst_amount);
               
                $('#ctaxable_amount').val(amount);


            }
            
            $('#ctaxable_amount').val(amount);
            // $('#amount').val(amount);
            // $('#total_amount').val(amount + tax_amount);
        }else{
            // $('#amount').val('0');
            $('#taxable_amount').val('0');
            $('#total_amount').val('0');

            if(gst_type == 'igst'){
                $('#itaxable_amount').val('0');
            $('#itotal_amount').val('0');

            }
        }

    if(qty > 0 && rate > 0 && sgst > 0){
        var taxable_amount = document.getElementById("ctaxable_amount").value;
        var sgst_amount = (sgst / 100) * taxable_amount;
        $('#sgst_amount').val(sgst_amount);
   
    }else{
      
        $('#sgst_amount').val('0');
     
        $('#cgst_amount').val('0');

    }

    if(qty > 0 && rate > 0 && cgst > 0){
        var taxable_amount = document.getElementById("ctaxable_amount").value;
        var cgst_amount = (sgst / 100) * taxable_amount;
        $('#cgst_amount').val(cgst_amount);

    }else{
       
        $('#cgst_amount').val('0');
        $('#sgst_amount').val('0');

    }
    });
    $(document).on('keyup','#sgst',function()
    {        
        var taxable_amount = document.getElementById("taxable_amount").value;
        var rate = document.getElementById("rate").value;
        var qty = document.getElementById("qty").value;
        var sgst = document.getElementById("sgst").value;
        if(sgst > 28){
            $('#sgst').val('28');
            $('#cgst').val('28');
        }
        $('#cgst').val(sgst);
       
        if(qty > 0 && rate > 0  && sgst > 0 ){
            // var amount = qty * rate;
            var sgst_amount = (sgst / 100) * taxable_amount;
            
            $('#sgst_amount').val(sgst_amount);
            $('#cgst_amount').val(sgst_amount);
            // $('#amount').val(amount);
            // $('#total_amount').val(amount + tax_amount);
        }else{
            // $('#amount').val('0');
            $('#sgst_amount').val('0');
            $('#cgst_amount').val('0');
            // $('#total_amount').val('0');
        }
    });
    $(document).on('keyup','#cgst',function()
    {        
        var taxable_amount = document.getElementById("taxable_amount").value;
        var rate = document.getElementById("rate").value;
        var qty = document.getElementById("qty").value;
        var cgst = document.getElementById("cgst").value;
        if(cgst > 28){
            $('#cgst').val('28');
            $('#sgst').val('28');
        }

        $('#sgst').val(cgst);
        if(qty > 0 && rate > 0 && cgst > 0 ){
            // var amount = qty * rate;
            var cgst_amount = (cgst / 100) * taxable_amount;
            
            $('#cgst_amount').val(cgst_amount);
            $('#sgst_amount').val(cgst_amount);
            // $('#amount').val(amount);
            // $('#total_amount').val(amount + tax_amount);
        }else{
            // $('#amount').val('0');
            $('#cgst_amount').val('0');
            $('#sgst_amount').val('0');
            // $('#total_amount').val('0');
        }
    });
    $(document).on('keyup','#rate',function()
    {      
        var gst_type = $('#gst_type').val();  
        var qty = document.getElementById("qty").value;
        var rate = document.getElementById("rate").value;
        if(gst_type != 'igst'){

            var sgst = document.getElementById("sgst").value;
            var cgst = document.getElementById("cgst").value;

            if(qty > 0 && rate > 0 && sgst >0 &&  cgst >0){
                var amount = qty * rate;
                var sgst_amount = (sgst / 100) * amount;
                var cgst_amount = (cgst / 100) * amount;
                $('#taxable_amount').val(amount);
                $('#sgst_amount').val(sgst_amount);
                $('#cgst_amount').val(cgst_amount);
                // $('#taxable_amount').val(amount + tax_amount);
            }else{
                // $('#amount').val('0');
                $('#taxable_amount').val('0');
                $('#sgst_amount').val('0');
                $('#cgst_amount').val('0');
                // $('#total_amount').val('0');
            }




        }
        if(gst_type == 'igst'){
            var gst = document.getElementById("gst").value;
            if(qty > 0 && rate > 0){
                var amount = qty * rate;
                var igst_amount = (gst / 100) * amount;

                $('#itotal_amount').val(igst_amount);
                $('#itaxable_amount').val(amount);
               



            }else{
                $('#itotal_amount').val('0');
                $('#itaxable_amount').val('0');

            }

        }

        
    });
    $(document).on('keyup','#crate',function()
    {      
        var gst_type = $('#gst_type').val();  
        var qty = document.getElementById("cqty").value;
        var rate = document.getElementById("crate").value;
          
        if(gst_type != 'igst'){

            var sgst = document.getElementById("sgst").value;
            var cgst = document.getElementById("cgst").value;

            if(qty > 0 && rate > 0 && sgst >0 &&  cgst >0){
                var amount = qty * rate;
                var sgst_amount = (sgst / 100) * amount;
                var cgst_amount = (cgst / 100) * amount;
                $('#ctaxable_amount').val(amount);
                $('#sgst_amount').val(sgst_amount);
                $('#cgst_amount').val(cgst_amount);
                // $('#taxable_amount').val(amount + tax_amount);
            }else{
                // $('#amount').val('0');
                $('#ctaxable_amount').val('0');
                $('#sgst_amount').val('0');
                $('#cgst_amount').val('0');
                // $('#total_amount').val('0');
            }




        }
        
        
    });
    $(document).on('keyup','#gst',function()
    {        
        var qty = document.getElementById("qty").value;
        var rate = document.getElementById("rate").value;
        var gst = document.getElementById("gst").value;
        if(qty > 0 && rate > 0 && gst >0){
            var amount = qty * rate;
            var tax_amount = (gst / 100) * amount;
            $('#taxable_amount').val(tax_amount);
            $('#amount').val(amount);
            $('#total_amount').val(amount + tax_amount);
        }else{
            $('#amount').val('0');
            $('#taxable_amount').val('0');
            $('#total_amount').val('0');
        }
    });
    
    $(document).on('click','.addTaxInvcRow',function()
    {        

        var gst_type = $('#gst_type').val();
       
        console.log(gst_type == "cgst_sgst");

        if(gst_type == "cgst_sgst"){

            
            var maintml = $(this);
            var boq_code = document.getElementById("cdc_boq_code").value;
            var hsn_sac_code = document.getElementById("chsn_sac_code").value;
            var item_description = document.getElementById("citem_description").value;
            var unit = document.getElementById("cunit").value;
            var qty = document.getElementById("cqty").value;
            var rate = document.getElementById("crate").value;
            var taxable_amount = document.getElementById("ctaxable_amount").value;
            var sgst = document.getElementById("sgst").value;
            var sgst_amount = document.getElementById("sgst_amount").value;
            var cgst = document.getElementById("cgst").value;
            var cgst_amount = document.getElementById("cgst_amount").value;
               
            // if(qty > 0 && rate > 0){
            //     var amount = qty * rate;
            //     var tax_amount = (gst / 100) * amount;
            //     var total_amount = amount + tax_amount;
            // }else{
            //     var amount = 0;
            //     var total_amount = 0;
            // }

            if(boq_code == '' || hsn_sac_code == '' || item_description == '' || unit == '' || qty < 1 || rate < 1 || taxable_amount < 1){
                $('.invaliderror').addClass('has-error-p');
            }
            else{
                var project_id = $('#project_id').val();
                // var url = 'get_proforma_boq_item_details';
                var url = 'get_approved_boq_item_details';
               
                $.ajax({
                        type:'POST',
                        url:completeURL(url), 
                        dataType:'json',
                        data:{project_id:project_id,boq_code:boq_code},
                        success:function(result){
                            if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){
                                boq_code_no = [];
                                $("input[name='cboq_code[]']").each(function(){
                                    boq_code_no.push($(this).val());
                                });
                                if ($.inArray(boq_code, boq_code_no) != -1){
                                    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                                    $('#cdc_boq_code').val('');
                                    $('#hsn_sac_code').val('');
                                    $('#item_description').val('');
                                    $('#unit').val('');
                                    $('#qty').val('');
                                    $('#gst').val('');
                                    $('#taxable_amount').val('');
                                    $('#rate').val('');
                                    $('#taxable_amount').val('');
                                    $('#sgst').val('');
                                    $('#sgst_amount').val('');
                                    $('#cgst_amount').val('');
                                    $('#cgst').val('');
                                    // $('#total_amount').val('');
                                    $('#hsn_sac_code').prop('readonly', false);
                                    $('#item_description').prop('readonly', false);
                                    $('#unit').prop('readonly', false);
                                }else{
                                var html='<tr><td>'
                                +'<input type="text" class="form-control" name="cboq_code[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="chsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="citem_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="cunit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="cqty[]" value="'+qty+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="crate[]" value="'+rate+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="ctaxable_amount[]" value="'+taxable_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="sgst[]" value="'+sgst+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="sgst_amount[]" value="'+sgst_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="cgst[]" value="'+cgst+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="cgst_amount[]" value="'+cgst_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td>'
                                +'<div class="addDeleteButton">'
                                +'<span class="tooltips deleteTaxInvcRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                                +'</div></td></tr>';
                                $('.invaliderror').removeClass('has-error-p');
                                $('#invaliderrorid').html('');
                                var clonedRow = $(this).parents('tbody.addTaxInvcRow').find('tr:first').clone();
                                clonedRow.find('input:not(.ftype)').val('');
                                clonedRow.find('textarea').val('');
                                clonedRow.find('select').val(''); 
                                clonedRow.find('.select2-container').remove(); 
                                clonedRow.find("select").select2();   
                                clonedRow.find('.tooltip').css('display','none');  
                                clonedRow.find('div.addDeleteButton').html('<span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>');
                                clonedRow.find('.tooltips').tooltip({placement: 'top'});
                                // $(maintml).parents('#taxinvcdisplay tbody').find("tr:last").before(html);
                                $(maintml).parents('#taxinvcdisplaysgst tbody').find("tr:last").before(html);
                                $('#cdc_boq_code').val('');
                                $('#chsn_sac_code').val('');
                                $('#citem_description').val('');
                                $('#cunit').val('');
                                $('#cqty').val('');
                                $('#crate').val('');
                                $('#cgst').val('');
                                $('#sgst').val('');
                                $('#ctaxable_amount').val('');
                                $('#sgst_amount').val('');
                                $('#cgst_amount').val('');
                                $('#cgst_amount').val('');
                                // $('#total_amount').val('');
                                $('#chsn_sac_code').prop('readonly', false);
                                
                                // $('#taxable_amount').prop('readonly', false);
                                $('#citem_description').prop('readonly', false);
                                $('#cunit').prop('readonly', false);
                                var total_amt = 0;
                                var gst_amt = 0;
                                var cgst_amt = 0;
                                var final_amt = 0;
                                $("input[name='ctaxable_amount[]']").each(function(){
                                    total_amt += parseFloat($(this).val());
                                });
                                $('#subtotal').html(total_amt.toFixed(2));

                                if(total_amt > 0){
                                    $("input[name='sgst_amount[]']").each(function(){
                                        gst_amt += parseFloat($(this).val());
                                    });

                                    $("input[name='cgst_amount[]']").each(function(){
                                        cgst_amt += parseFloat($(this).val());
                                    });
                                    
                                    gst_amt = parseFloat(gst_amt);   
                                    cgst_amt = parseFloat(cgst_amt);   
                                }

                                $('.gst_amt').html(gst_amt.toFixed(2));
                                final_amt = parseFloat(gst_amt) + parseFloat(cgst_amt) + parseFloat(total_amt) + parseFloat(final_amt);
                                console.log(final_amt);
                                $('#finaltotalaq').html(final_amt.toFixed(2));
                                }
                            }else{    
                                $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Not Exist!');
                            }        
                        }
                });
            }
            if (jQuery().datepicker) {
                $('.date-picker').datepicker({
                    orientation: "right",
                    autoclose: true,
                });
            } 
            Metronic.init();

  
        }else{
           
            var maintml = $(this);
            var boq_code = document.getElementById("idc_boq_code").value;
            var hsn_sac_code = document.getElementById("hsn_sac_code").value;
            var item_description = document.getElementById("item_description").value;
            var unit = document.getElementById("unit").value;
            var qty = document.getElementById("qty").value;
            var rate = document.getElementById("rate").value;
            var taxable_amount = document.getElementById("itaxable_amount").value;
            var gst = document.getElementById("gst").value;
            var total_amount = document.getElementById("itotal_amount").value;

            if(boq_code == '' || hsn_sac_code == '' || item_description == '' || unit == '' || qty < 1 || rate < 1 || taxable_amount < 1){
                $('.invaliderror').addClass('has-error-p');
            } else{
                var project_id = $('#project_id').val();
                // var url = 'get_proforma_boq_item_details';
                var url = 'get_approved_boq_item_details';
               
                $.ajax({
                        type:'POST',
                        url:completeURL(url), 
                        dataType:'json',
                        data:{project_id:project_id,boq_code:boq_code},
                        success:function(result){
                            console.log(result);
                            if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){
                                boq_code_no = [];
                                $("input[name='iboq_code[]']").each(function(){
                                    boq_code_no.push($(this).val());
                                });
                                console.log(boq_code_no);
                                if ($.inArray(boq_code, boq_code_no) != -1){
                                    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                                    $('#dc_boq_code').val('');
                                    $('#hsn_sac_code').val('');
                                    $('#item_description').val('');
                                    $('#unit').val('');
                                    $('#qty').val('');
                                    $('#gst').val('');
                                    $('#itaxable_amount').val('');
                                    $('#rate').val('');
                                    $('#taxable_amount').val('');
                                    $('#sgst').val('');
                                    $('#sgst_amount').val('');
                                    $('#cgst_amount').val('');
                                    $('#cgst').val('');
                                    $('#itotal_amount').val('');
                                    $('#hsn_sac_code').prop('readonly', false);
                                    $('#item_description').prop('readonly', false);
                                    $('#unit').prop('readonly', false);
                                }else{
                                var html='<tr><td>'
                                +'<input type="text" class="form-control" name="iboq_code[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="hsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="unit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="qty[]" value="'+qty+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="rate[]" value="'+rate+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="itaxable_amount[]" value="'+taxable_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="gst[]" value="'+gst+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><input type="text" class="form-control" name="itotal_amount[]" value="'+total_amount+'" readonly style="font-size: 12px;width:100%"></td>'
                                +'<td><div class="addDeleteButton">'
                                +'<span class="tooltips deleteTaxInvcRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                                +'</td></div></td></tr>';
                                $('.invaliderror').removeClass('has-error-p');
                                $('#invaliderrorid').html('');
                                var clonedRow = $(this).parents('tbody.addTaxInvcRow').find('tr:first').clone();
                                clonedRow.find('input:not(.ftype)').val('');
                                clonedRow.find('textarea').val('');
                                clonedRow.find('select').val(''); 
                                clonedRow.find('.select2-container').remove(); 
                                clonedRow.find("select").select2();   
                                clonedRow.find('.tooltip').css('display','none');  
                                clonedRow.find('div.addDeleteButton').html('<span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>');
                                clonedRow.find('.tooltips').tooltip({placement: 'top'});
                                // $(maintml).parents('#taxinvcdisplay tbody').find("tr:last").before(html);
                                $(maintml).parents('#taxinvcdisplay tbody').find("tr:last").before(html);
                                $('#dc_boq_code').val('');
                                $('#idc_boq_code').val('');
                                $('#hsn_sac_code').val('');
                                $('#item_description').val('');
                                $('#unit').val('');
                                $('#qty').val('');
                                $('#rate').val('');
                                // $('#cgst').val('');
                                $('#gst').val('');
                               // $('#sgst').val('');
                                $('#itaxable_amount').val('');
                                $('#sgst_amount').val('');
                                $('#cgst_amount').val('');
                                $('#amount').val('');
                                $('#itotal_amount').val('');
                                $('#hsn_sac_code').prop('readonly', false);
                                
                                $('#itaxable_amount').prop('readonly', true);
                                $('#item_description').prop('readonly', false);
                                $('#unit').prop('readonly', false);
                                var total_amt = 0;
                                var gst_amt = 0;
                                var final_amt = 0;
                                $("input[name='itaxable_amount[]']").each(function(){
                                    total_amt += parseFloat($(this).val());
                                });
                                $('#subtotali').html(total_amt.toFixed(2));
                                if(total_amt > 0){

                                    $("input[name='itotal_amount[]']").each(function(){
                                        gst_amt += parseFloat($(this).val());
                                    });

                                    // gst_amt = parseFloat(total_amt) * 0.09;   
                                }
                                $('.cgst_amt').html(gst_amt.toFixed(2));
                                final_amt = parseFloat(gst_amt) + parseFloat(total_amt);
                                $('#finaltotal').html(final_amt.toFixed(2));
                                }
                            }else{    
                                $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Not Exist!');
                            }        
                        }
                });
            }
            if (jQuery().datepicker) {
                $('.date-picker').datepicker({
                    orientation: "right",
                    autoclose: true,
                });
            } 
            Metronic.init();  
        }
    });


txccnt = 1;
    $(document).on('click', '.txdd', function() {


        console.log("ankit")
        var tax_deduction_desc = $("#tax_deduction_desc").val();
        var tax_deduction_amt = $("#tax_deduction_amt").val();
       
        
        if(tax_deduction_desc !=='' && typeof tax_deduction_desc != 'undefined' && 
        tax_deduction_amt !=='' && typeof tax_deduction_amt != 'undefined'
        
        ){
            $("#tax_ded_des").html('');
        var html = '<div class="row consinee_detail">'
        +'<div class="input-icon right col-md-6">'
        +'<i class="fa"></i> <i class="fa"></i>'
        +'<i class="fa"></i><input type="text" class="form-control " name="tax_deduction_desc[]" id="tax_deduction_desc'+txccnt+'" value="'+tax_deduction_desc+'" placeholder="Tax Deduction Description" readonly>'
        +'</div>'
        +'<div class="col-md-5">'
        +'<div class="form-group">'
        +'<div class="input-icon right">'
        +'<i class="fa"></i>'
        +'<input type="text" class="form-control tax_deduction_amt" name="tax_deduction_amt[]" id="tax_deduction_amt'+txccnt+'" placeholder="Tax Deduction Amount" value="'+tax_deduction_amt+'" readonly>'
        +'</div></div></div>'
        +'<div class="col-md-1">'
        +'<div class="rmbtnss"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>'
        +'</div></div>';
        $("#addtxdd").append(html);
        $("#tax_ded_des").html('');
        $('#tax_deduction_desc').prop('required', false);
        $('#tax_deduction_amt').prop('required', false);
        $("#tax_deduction_desc").val('');
        $("#tax_deduction_amt").val('');
      
        txccnt++;
        }else{
        $("#tax_ded_des").html('Please enter Tax Deduction details!');
        }
    });
    ddcount =1 ;
    $(document).on('click', '.desadd', function() {


    
        var deposit_desc = $("#deposit_desc").val();
        var deposit_amount = $("#deposit_amount").val();
       
        
        if(deposit_desc !=='' && typeof deposit_desc != 'undefined' && 
        deposit_amount !=='' && typeof deposit_amount != 'undefined'
        
        ){
            $("#depo_des_error").html('');
        var html = '<div class="row consinee_detail">'
        +'<div class="input-icon right col-md-6">'
        +'<i class="fa"></i> <i class="fa"></i>'
        +'<i class="fa"></i><input type="text" class="form-control " name="deposit_desc[]" id="deposit_desc'+ddcount+'" value="'+deposit_desc+'" placeholder="Tax Deduction Description" readonly>'
        +'</div>'
        +'<div class="col-md-5">'
        +'<div class="form-group">'
        +'<div class="input-icon right">'
        +'<i class="fa"></i>'
        +'<input type="text" class="form-control deposit_amount" name="deposit_amount[]" id="deposit_amount'+ddcount+'" placeholder="Tax Deduction Amount" value="'+deposit_amount+'" readonly>'
        +'</div></div></div>'
        +'<div class="col-md-1">'
        +'<div class="ddrmbtn"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>'
        +'</div></div>';
        $("#deposesc").append(html);
        $("#depo_des_error").html('');
        $('#deposit_desc').prop('required', false);
        $('#deposit_amount').prop('required', false);
        $("#deposit_desc").val('');
        $("#deposit_amount").val('');
      
        ddcount++;
        }else{
        $("#depo_des_error").html('Please enter Deposit details!');
        }
    });
    hdcnt =1 ;
    $(document).on('click', '.withhdadbtn', function() {


       
        var withheld_desc = $("#withheld_desc").val();
        var withheld_amt = $("#withheld_amt").val();
       
        
        if(withheld_desc !=='' && typeof withheld_desc != 'undefined' && 
        withheld_amt !=='' && typeof withheld_amt != 'undefined'
        
        ){
            $("#with_held_error").html('');
        var html = '<div class="row newhd detail">'
        +'<div class="input-icon right col-md-6">'
        +'<i class="fa"></i> <i class="fa"></i>'
        +'<i class="fa"></i><input type="text" class="form-control " name="withheld_desc[]" id="withheld_desc'+hdcnt+'" value="'+withheld_desc+'" placeholder="Tax Deduction Description" readonly>'
        +'</div>'
        +'<div class="col-md-5">'
        +'<div class="form-group">'
        +'<div class="input-icon right">'
        +'<i class="fa"></i>'
        +'<input type="text" class="form-control withheld_amt" name="withheld_amt[]" id="withheld_amt'+hdcnt+'" placeholder="Tax Deduction Amount" value="'+withheld_amt+'" readonly>'
        +'</div></div></div>'
        +'<div class="col-md-1">'
        +'<div class="wdrmbtn"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>'
        +'</div></div>';
        $("#rowwithheld").append(html);
        $("#with_held_error").html('');
        $('#withheld_desc').prop('required', false);
        $('#withheld_amt').prop('required', false);
        $("#withheld_desc").val('');
        $("#withheld_amt").val('');
      
        hdcnt++;
        }else{
        $("#with_held_error").html('Please enter Withheld details!');
        }
    });
   var cdadn =1 ;
    $(document).on('click', '.cdadbtn', function() {


       
        var other_cess_desc = $("#other_cess_desc").val();
        var other_cess_amt = $("#other_cess_amt").val();
       
        
        if(other_cess_desc !=='' && typeof other_cess_desc != 'undefined' && 
        other_cess_amt !=='' && typeof other_cess_amt != 'undefined'
        
        ){
            $("#cess_desc_error").html('');
        var html = '<div class="row newhd detail">'
        +'<div class="input-icon right col-md-6">'
        +'<i class="fa"></i> <i class="fa"></i>'
        +'<i class="fa"></i><input type="text" class="form-control " name="other_cess_desc[]" id="other_cess_desc'+hdcnt+'" value="'+other_cess_desc+'" placeholder="Tax Deduction Description" readonly>'
        +'</div>'
        +'<div class="col-md-5">'
        +'<div class="form-group">'
        +'<div class="input-icon right">'
        +'<i class="fa"></i>'
        +'<input type="text" class="form-control other_cess_amt" name="other_cess_amt[]" id="other_cess_amt'+hdcnt+'" placeholder="Tax Deduction Amount" value="'+other_cess_amt+'" readonly>'
        +'</div></div></div>'
        +'<div class="col-md-1">'
        +'<div class="cesrmbtn"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>'
        +'</div></div>';
        $("#rowcess").append(html);
        $("#cess_desc_error").html('');
        $('#other_cess_desc').prop('required', false);
        $('#other_cess_amt').prop('required', false);
        $("#other_cess_desc").val('');
        $("#other_cess_amt").val('');
      
        cdadn++;
        }else{
        $("#cess_desc_error").html('Please enter Any other cess details!');
        }
    });
    var newadd = 1;
    $(document).on('click', '.dedescadbtn', function() {


       
        var deduction_desc = $("#deduction_desc").val();
        var deduction_amt = $("#deduction_amt").val();
       
        
        if(deduction_desc !=='' && typeof deduction_desc != 'undefined' && 
        deduction_amt !=='' && typeof deduction_amt != 'undefined'
        
        ){
            $("#ded_descp_error").html('');
        var html = '<div class="row newhd detail">'
        +'<div class="input-icon right col-md-6">'
        +'<i class="fa"></i> <i class="fa"></i>'
        +'<i class="fa"></i><input type="text" class="form-control " name="deduction_desc[]" id="deduction_desc'+newadd+'" value="'+deduction_desc+'" placeholder="Tax Deduction Description" readonly>'
        +'</div>'
        +'<div class="col-md-5">'
        +'<div class="form-group">'
        +'<div class="input-icon right">'
        +'<i class="fa"></i>'
        +'<input type="text" class="form-control deduction_amt" name="deduction_amt[]" id="deduction_amt'+newadd+'" placeholder="Tax Deduction Amount" value="'+deduction_amt+'" readonly>'
        +'</div></div></div>'
        +'<div class="col-md-1">'
        +'<div class="desdecrmbtn"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>'
        +'</div></div>';
        $("#newaddded").append(html);
        $("#ded_descp_error").html('');
        $('#deduction_desc').prop('required', false);
        $('#deduction_amt').prop('required', false);
        $("#deduction_desc").val('');
        $("#deduction_amt").val('');
      
        newadd++;
        }else{
        $("#ded_descp_error").html('Please enter Any other deductions details!');
        }
    });

    $(document).on('click','.rmbtnss',function(){
        $(this).parent().parent().remove();
    });
    $(document).on('click','.desdecrmbtn',function(){
        $(this).parent().parent().remove();
    });
    $(document).on('click','.cesrmbtn',function(){
        $(this).parent().parent().remove();
    });
    $(document).on('click','.ddrmbtn',function(){
        $(this).parent().parent().remove();
    });
    $(document).on('click','.wdrmbtn',function(){
        $(this).parent().parent().remove();
    });


   
    
     









    
    $(document).on('click','.addDCVSRow',function()
    {        
        var maintml = $(this);
        var boq_code = document.getElementById("dc_boq_code").value;
        var hsn_sac_code = document.getElementById("hsn_sac_code").value;
        var item_description = document.getElementById("item_description").value;
        var unit = document.getElementById("unit").value;
        var avl_qty = document.getElementById("avl_qty").value;
        var stock_qty = document.getElementById("stock_qty").value;
        if(boq_code == '' || hsn_sac_code == '' || item_description == '' || unit == '' || avl_qty < 1 || stock_qty < 1){
            $('.invaliderror').addClass('has-error-p');
        }else{
            var project_id = $('#project_id').val();
            var url = 'get_dcip_boq_item_details';
            $.ajax({
                    type:'POST',
                    url:completeURL(url), 
                    dataType:'json',
                    data:{project_id:project_id,boq_code:boq_code},
                    success:function(result){
                        if(result.boq_code !== '' && typeof result.boq_code !== "undefined"){
                            boq_code_no = [];
                        	$("input[name='boq_code[]']").each(function(){
                        		boq_code_no.push($(this).val());
                        	});
                        	if ($.inArray(boq_code, boq_code_no) != -1){
                        	    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                                $('#dc_boq_code').val('');
                                $('#hsn_sac_code').val('');
                                $('#item_description').val('');
                                $('#unit').val('');
                                $('#avl_qty').val('');
                                $('#stock_qty').val('');
                                $('#hsn_sac_code').prop('readonly', false);
                                $('#item_description').prop('readonly', false);
                                $('#unit').prop('readonly', false);
                            }else{
                            var html='<tr><td>'
                            +'<input type="text" class="form-control" name="boq_code[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control" name="hsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control" name="item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control" name="unit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control" name="avl_qty[]" value="'+avl_qty+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td><input type="text" class="form-control" name="stock_qty[]" value="'+stock_qty+'" readonly style="font-size: 12px;width:100%"></td>'
                            +'<td>'
                            +'<div class="addDeleteButton">'
                            +'<span class="tooltips deletedcvsRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                            +'</div></td></tr>';
                            $('.invaliderror').removeClass('has-error-p');
                            $('#invaliderrorid').html('');
                            var clonedRow = $(this).parents('tbody.addDCVSRow').find('tr:first').clone();
                            clonedRow.find('input:not(.ftype)').val('');
                            clonedRow.find('textarea').val('');
                            clonedRow.find('select').val(''); 
                            clonedRow.find('.select2-container').remove(); 
                            clonedRow.find("select").select2();   
                            clonedRow.find('.tooltip').css('display','none');  
                            //clonedRow.find('div.addDeleteButton').html('<span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>');
                            clonedRow.find('.tooltips').tooltip({placement: 'top'});
                            $(maintml).parents('#clientdcvsitemdisplay tbody').find("tr:last").before(html);
                            $('#dc_boq_code').val('');
                            $('#hsn_sac_code').val('');
                            $('#item_description').val('');
                            $('#unit').val('');
                            $('#avl_qty').val('');
                            $('#stock_qty').val('');
                            $('#hsn_sac_code').prop('readonly', false);
                            $('#item_description').prop('readonly', false);
                            $('#unit').prop('readonly', false);
                            }
                        }else{    
                            $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Not Available!');
                        }        
                    }
            });
        }
        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                orientation: "right",
                autoclose: true,
            });
        } 
        Metronic.init();
    });
    $(document).on('click','.addDCCRow',function()
    {        
        var boq_code = document.getElementById("boq_code").value;
        var hsn_sac_code = document.getElementById("hsn_sac_code").value;
        var item_description = document.getElementById("item_description").value;
        var unit = document.getElementById("unit").value;
        var scheduled_qty = document.getElementById("scheduled_qty").value;
        var design_qty = document.getElementById("design_qty").value;
        var receive_qty = document.getElementById("receive_qty").value;
        if(boq_code == '' || hsn_sac_code == '' || item_description == '' || unit == '' || scheduled_qty < 1 || design_qty < 1 || receive_qty < 1){
            $('.invaliderror').addClass('has-error-p');
        }else{
            boq_code_no = [];
        	$("input[name='boq_code[]']").each(function(){
        		boq_code_no.push($(this).val());
        	});
        	if ($.inArray(boq_code, boq_code_no) != -1){
        	    $('#invaliderrorid').html('BOQ Sr No '+boq_code+' Details Already Exist!');
                $('#boq_code').val('');
                $('#hsn_sac_code').val('');
                $('#item_description').val('');
                $('#unit').val('');
                $('#scheduled_qty').val('');
                $('#design_qty').val('');
                $('#receive_qty').val('');
                $('#hsn_sac_code').prop('readonly', false);
                $('#item_description').prop('readonly', false);
                $('#unit').prop('readonly', false);
                $('#scheduled_qty').prop('readonly', false);
            }else{
            var html='<tr><td>'
            +'<input type="text" class="form-control" name="boq_code[]" value="'+boq_code+'" readonly style="font-size: 12px;width:100%"></td>'
            +'<td><input type="text" class="form-control" name="hsn_sac_code[]" value="'+hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
            +'<td><input type="text" class="form-control" name="item_description[]" value="'+item_description+'" readonly style="font-size: 12px;width:100%"></td>'
            +'<td><input type="text" class="form-control" name="unit[]" value="'+unit+'" readonly style="font-size: 12px;width:100%"></td>'
            +'<td><input type="text" class="form-control" name="scheduled_qty[]" value="'+scheduled_qty+'" readonly style="font-size: 12px;width:100%"></td>'
            +'<td><input type="text" class="form-control" name="design_qty[]" value="'+design_qty+'" readonly style="font-size: 12px;width:100%"></td>'
            +'<td><input type="text" class="form-control" name="receive_qty[]" value="'+receive_qty+'" readonly style="font-size: 12px;width:100%"></td>'
            +'<td>'
            +'<div class="addDeleteButton">'
            +'<span class="tooltips deletedccRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
            +'</div></td></tr>';
            $('.invaliderror').removeClass('has-error-p');
            $('#invaliderrorid').html('');
            var clonedRow = $(this).parents('tbody.appendDynaRow').find('tr:first').clone();
            clonedRow.find('input:not(.ftype)').val('');
            clonedRow.find('textarea').val('');
            clonedRow.find('select').val(''); 
            clonedRow.find('.select2-container').remove(); 
            clonedRow.find("select").select2();   
            clonedRow.find('.tooltip').css('display','none');  
            //clonedRow.find('div.addDeleteButton').html('<span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>');
            clonedRow.find('.tooltips').tooltip({placement: 'top'});
            $(this).parents('#clientdcdisplay tbody').find("tr:last").before(html);
            $('#boq_code').val('');
            $('#hsn_sac_code').val('');
            $('#item_description').val('');
            $('#unit').val('');
            $('#scheduled_qty').val('');
            $('#design_qty').val('');
            $('#receive_qty').val('');
            $('#hsn_sac_code').prop('readonly', false);
            $('#item_description').prop('readonly', false);
            $('#unit').prop('readonly', false);
            $('#scheduled_qty').prop('readonly', false);
            }
        }
        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                orientation: "right",
                autoclose: true,
            });
        } 
        Metronic.init();
    });
    $(document).on('click','.deleteRow', function(){ 
        var this1 = $(this);
        var id = $(this).attr('rel');
        var url= $(this).attr('rev');
        bootbox.confirm("Are you sure?", function(result) 
        {
            if(result)
            {
                $.ajax({
                    type:'POST',
                    url:completeURL(url),
                    data:{id:id},
                    dataType:'json',
                    success:function(data)
                    {      
                        this1.closest('tr').remove();
                        var k=0; 
                        $("tbody.appendDynaRow tr").each(function() {
                            k++;
                            $(this).find('input[type=radio]').val(k);
                        });
                    }
                });
            }
        });
    });
});
$(document).on('change','.statusselect' , function(e){
        //e.preventDefault();
    
        var this1 = $(this);

        bootbox.confirm("Are you sure?", function(result) 

        {

            if(result)

            {

                var id = this1.attr('rel');
                
                var url = this1.attr('rev');             

                var status = this1.val();                

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
$(document).on('click','.active_link_cmn' , function(){
        var this1 = $(this);
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

// $(document).on('keyup','#except_ea_qty',function(){  
$(document).on('keyup', '.js-release_qty-b', function() {
    var $this = $(this);
    var qty = parseFloat($this.val());
    if(qty > 0) {
        var boq_sr_no = $this.closest('tr').find('.js-boq_sr_no').val();
        var url = 'check_boq_avl_release_qty';
        var project_id = $("#project_id").val();

        $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:{project_id:project_id,boq_code:boq_sr_no},
            success:function(result){
                var avl_relase_qty = parseInt(result);
                if(qty < 0) {
                    $('#invaliderrorid').html('Release Quantity must be greater than 0!');
                    $this.val('');
                } else if(qty > avl_relase_qty) {
                    $('#invaliderrorid').html('Release Quantity must be less than or equal to Avl.Release Qty '+avl_relase_qty+'');
                    $this.val(avl_relase_qty);
                    calculateReleaseQuantity($this);
                } else {
                    $(this).removeClass('has-error');
                    $('#invaliderrorid').html('');
                    calculateReleaseQuantity($this);
                }
            }
        });
    } else {
        $('#invaliderrorid').html('Release Quantity must be greater than 0!');
        $this.val('');
        // calculateReleaseQuantity($this);
    }
});

function calculateReleaseQuantity(triggerElement) {
    var bomTableRow =  $(triggerElement).closest('tr');
    var quantity = $(bomTableRow).find('.js-avl_release_qty').val();
    var releaseQuantity = $(bomTableRow).find('.js-release_qty-b').val();
  
    var parsedQuantity = parseFloat(quantity);
    var tableCells = $(triggerElement).closest('tr').next('tr').find('table tbody');
    

   $('#bomitmdisplay tbody tr').each(function() {
        var originalAvailableQuantity = $(this).closest('tr').find('.bom_original_avl_qty').val();
        var bomRatio = $(this).closest('tr').find('.bom_ratio').val();
        var bomGST = $(this).closest('tr').find('.js-bom-gst').val();
        var bomRateBasic = $(this).closest('tr').find('.js-bom-rate-basic').val();
        var releaseAvailableQuantity = parseFloat($(this).val());

       
        var totalReleaseQuantity = parseFloat(bomRatio) * parseFloat(releaseQuantity);
        totalReleaseQuantity = totalReleaseQuantity.toFixed(2); // Round to two decimal points
    console.log(totalReleaseQuantity);
        if (bomGST > 0) {
            var totalAmount = bomRateBasic * totalReleaseQuantity;
            var gstAmount = 0;
        
            if (totalAmount > 0 && bomGST > 0) {
                gstAmount = totalAmount * (bomGST / 100);
            }
            var finalAmount = totalAmount + gstAmount;
        } else {
            var finalAmount = 0;
        }
        // $(this).find('.js-bom-amount').val(finalAmount.toFixed(2));
        $(this).find('.bom_release_avl_qty').val(totalReleaseQuantity);
    });
}

$(".prudent-tab").click(function() {
    const index = $(this).attr('data-tab-index');
    const projectCcode = $(this).attr('data-project-code');
    const p_url = $("#p_url").val();

    if(index == 1) {
        location.href = p_url + 'project-details/'+projectCcode;
        // $("#boq-tab .menu-item")[0].click();
    } else if (index == 2) {
        location.href = p_url + 'view-bom/'+projectCcode;
    }
});

$(document).on('click','.editBomReleaseRecord', function(){

	var project_id = $(this).attr('data-project_id');
	var boq_code = $(this).attr('data-boq_code');
    var transaction_id = $(this).attr('data-transaction_id');
    
	var url = $(this).attr('rev');

	$.ajax({
		url : completeURL(url),
		type : 'POST',
		dataType : 'html',
		data:{project_id:project_id,boq_code:boq_code,transaction_id:transaction_id},
		success:function(data)
		{          
			$('html, body').animate({scrollTop:0});
			$('.form').html($(data).find('.form').html());
		},
		complete:function(){
			Layout.init();
			Metronic.init(); // init metronic core components
			Layout.init();
		}
	}); 
});


$(document).ready(function() {
    var p_url = $("#p_url").val();
    $(".p_search_boq_item").select2({
        minimumInputLength: 4,
        ajax: {
          url: p_url + 'get_all_item_list',
          dataType: 'json',
          type: "POST",
          quietMillis: 50,
          data: function (term) {
            return {
               term: term,
               type: $("#p_search_type").val(), 
             };
          },
          results: function (data) {
            return {
              results: data.users
            };
          }
        }
      });
    
      $('#p_search_type').select2({
        minimumResultsForSearch: -1
      });

      $(document).on("change", "#p_search_type", function () {
        var project_id = $(this).val();
        if (project_id) {
            $(".p_search_boq_item").select2("val", "");
        }
    });
    
    $(document).on('keypress','.onlyNumericInput', function(event) {
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
    
});

function replce_file()
{
    var file_name = $('.file_name span').val();
    $('.file_name').val(data);
};
function replce_emd_paid_file()
{
    var file_name = $('.emd_paid_filename span').attr('src');
    $('.emd_paid_filename').val(data);
};
function replce_asd_paid_file()
{
    var file_name = $('.asd_paid_filename span').val('src');
    $('.asd_paid_filename').val(data);
};
function replce_draft_doc_file()
{
    var file_name = $('.draft_doc_filename span').val('src');
    $('.draft_doc_filename').val(data);
};
function replce_projectinvstsch_doc_file()
{
    var file_name = $('.projectinvstsch_doc_filename span').val('src');
    $('.projectinvstsch_doc_filename').val(data);
};

function replce_projectcashflw_doc_file()
{
    var file_name = $('.projectcashflw_doc_filename span').val('src');
    $('.projectcashflw_doc_filename').val(data);
};

function replce_projectdesig_doc_file()
{
    var file_name = $('.projectdesig_doc_filename span').val('src');
    $('.projectdesig_doc_filename').val(data);
};

function replce_projectcmpl_doc_file()
{
    var file_name = $('.projectcmpl_doc_filename span').val('src');
    $('.projectcmpl_doc_filename').val(data);
};

function replce_sign_doc_file()
{
    var file_name = $('.sign_doc_filename span').val('src');
    $('.sign_doc_filename').val(data);
};

function replce_security_desposite_file()
{
    var file_name = $('.security_desposite_filename span').val('src');
    $('.security_desposite_filename').val(data);
};
function replce_performance_paid_file()
{
    var file_name = $('.performance_paid_filename span').val('src');
    $('.performance_paid_filename').val(data);
}
function replce_boq_file()
{
    var file_name = $('.boq_excel_filename span').val('src');
    $('.boq_excel_filename').val(data);
};

function getCookie(key) 
{
   var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');  
   return keyValue ? keyValue[2] : null;  
} 

function replaceurl(url)
{
    var url1=url.toString().replace("%3A",":"); 
    var url2=url1.toString().replace(/%2F/g,"/");  
    return url2;
}   

function completeURL(url)
{
    try
    {
        var target= getCookie('multicare')+url;
        target=replaceurl(target);
        return replaceurl(target);      
    }
    catch(e)
    {
        alert(e);
    }
}