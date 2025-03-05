function getAge(dob) { return ~~((new Date()-new Date(dob))/(31556952000)) }
$(document).on('change','#f_dob0',function(){
    var dateAr = $(this).val().split('-');
    var newDate = dateAr[1] + '-' + dateAr[0] + '-' + dateAr[2].slice(-2);
    $('#f_age0').val(getAge(newDate));
});
$(document).on('click','.date1',function(){   
      
    $('.date1').datepicker({
        dateFormat: "dd-mm-yy",
        orientation: "right",
        autoclose: true,
        clearBtn: true
    });    
});
var fcnt = 1;
$(document).on('click','.addFRow',function()
    {   
        
        var f_name = document.getElementById("f_name0").value;
        var relation = document.getElementById("relation0").value;
        var f_dob = document.getElementById("f_dob0").value;
        var f_age = document.getElementById("f_age0").value;
        var f_education = document.getElementById("f_education0").value;
        var f_occup = document.getElementById("f_occup0").value;
        console.log(f_name)
        console.log(relation)
        console.log(f_dob)
        console.log(f_age)
        console.log(f_occup)
        if(f_name == '' || f_dob == '' || f_age == '' || f_education == '' || f_occup == '' || f_dob == '00-00-0000'){
            $('.invalidferror').addClass('has-errorp');
        }else{
            var html='<tr><td>'
            +'<div class="form-group">'
            +'<input type="text" class="form-control" name="relation[]" value="'+relation+'" placeholder="Select" required readonly>'
            +'</div>'
            +'</td>'
            +'<td>'
            +'<input type="text" class="form-control" name="f_name[]" value="'+f_name+'" placeholder="Name" required readonly>'
            +'</td>'
            +'<td>'
            +'<input type="text" class="form-control" name="f_dob[]" value="'+f_dob+'" placeholder="DOB" required readonly>'
            +'</td>'
            +'<td>'
            +'<input type="text" class="form-control" name="f_age[]" value="'+f_age+'" placeholder="Age" required readonly>'
            +'</td>'
            +'<td>'
            +'<input type="text" class="form-control" name="f_education[]" value="'+f_education+'" placeholder="Education" required readonly>'
            +'</td>'
            +'<td>'
            +'<input type="text" class="form-control" name="f_occup[]" value="'+f_occup+'" placeholder="Occupation" required readonly>'
            +'</td>'
            +'<td>'
            +'<div class="addDeleteButton">'
            +'<span class="tooltips deleteFRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'
            +'</div></td></tr>';
            $('.invalidferror').removeClass('has-errorp');
            $('#invalidferrorid').html('');
            var clonedRow = $(this).parents('tbody.addFRow').find('tr:first').clone();
            clonedRow.find('input:not(.ftype)').val('');
            clonedRow.find('textarea').val('');
            clonedRow.find('select').val(''); 
            clonedRow.find('.select2-container').remove(); 
            clonedRow.find("select").select2();   
            clonedRow.find('.tooltip').css('display','none');  
            clonedRow.find('.tooltips').tooltip({placement: 'top'});
            $(this).parents('#familytbl tbody').find("tr:last").before(html);
            fcnt++;
            
            $('#relation0').val('');
            $('#f_name0').val('');
            $('#f_dob0').val('');
            $('#f_age0').val('');
            $('#f_education0').val('');
            $('#f_occup0').val('');
        }
        Metronic.init();
    });
    
    
    var educnt = 1;
    
    $(document).on('click','.addedurow',function()
    {        
        var clg_name = document.getElementById("college0").value;
        var p_year = document.getElementById("passing_year0").value;
        var degree = document.getElementById("degree_diploma0").value;
        var spsub = document.getElementById("special_sub0").value;
        var p_obtain = document.getElementById("percent_obtain0").value;
        
        if(clg_name == '' || p_year == '' || degree == '' || spsub == '' || p_obtain == '' || p_year  == '00-00-0000'){
            $('.invalideduerror').addClass('has-errorp');
        }else{
            var html='<tr><td>'
            +'<div class="form-group">'
            +'<input type="text" class="form-control" name="college[]" value="'+clg_name+'" placeholder="Select" required readonly>'
            +'</div>'
            +'</td>'
            +'<td>'
            +'<input type="text" class="form-control" name="passing_year[]" value="'+p_year+'" placeholder="Year of Passing" required readonly>'
            +'</td>'
            +'<td>'
            +'<input type="text" class="form-control" name="degree_diploma[]" value="'+degree+'" placeholder="Degree/Diploma" required readonly>'
            +'</td>'
            +'<td>'
            +'<input type="text" class="form-control" name="special_sub[]" value="'+spsub+'" placeholder="Specialized Subject" required readonly>'
            +'</td>'
            +'<td>'
            +'<input type="text" class="form-control" name="percent_obtain[]" value="'+p_obtain+'" placeholder="Percentage Obtained Subject" required readonly>'
            +'</td>'
            +'<td>'
            +'<div class="addDeleteButton">'
            +'<span class="tooltips deleteduRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'
            +'</div></td></tr>';
            $('.invalideduerror').removeClass('has-errorp');
            $('#invalideduerrorid').html('');
            var clonedRow = $(this).parents('tbody.addeduRow').find('tr:first').clone();
            clonedRow.find('input:not(.ftype)').val('');
            clonedRow.find('.tooltip').css('display','none');  
            clonedRow.find('.tooltips').tooltip({placement: 'top'});
            $(this).parents('#edutabel tbody').find("tr:last").before(html);
            educnt++;
            $('#college0').val('');
            $('#passing_year0').val('');
            $('#degree_diploma0').val('');
            $('#percent_obtain0').val('');
            $('#special_sub0').val('');
        }
        Metronic.init();
    });
    
    
    
     var empcnt = 1;
    
    $(document).on('click','.addempRow',function()
    {        
        var postion = document.getElementById("position0").value;
        var from = document.getElementById("from0").value;
        var to = document.getElementById("to0").value;
        var empdetail = document.getElementById("employer_details0").value;
        var respo = document.getElementById("responsibilities0").value;
        var ctc = document.getElementById("cost_to_company0").value;
        
        if(postion == '' || from == '' || to == '' || empdetail == '' || respo == '' || ctc == '' ||  from  == '00-00-0000' ||  to  == '00-00-0000'){
            $('.invalidemperror').addClass('has-errorp');
        }else{
            var html='<tr><td>'
            +'<div class="form-group">'
            +'<input type="text" class="form-control" name="position[]" value="'+postion+'" placeholder="Position Held" required readonly>'
            +'</div>'
            +'</td>'
            +'<td>'
            +'<input type="text" class="form-control" name="from[]" value="'+from+'" placeholder="From" required readonly>'
            +'</td>'
            +'<td>'
            +'<input type="text" class="form-control" name="to[]" value="'+to+'" placeholder="To" required readonly>'
            +'</td>'
            +'<td>'
            +'<input type="text" class="form-control" name="employer_details[]" value="'+empdetail+'" placeholder="Employer (Name, address and contact nos.)" required readonly>'
            +'</td>'
            +'<td>'
            +'<input type="text" class="form-control" name="responsibilities[]" value="'+respo+'" placeholder="Main Responsibilities" required readonly>'
            +'</td>'
            +'<td>'
            +'<input type="text" class="form-control" name="cost_to_company[]" value="'+ctc+'" placeholder="Cost to Company" required readonly>'
            +'</td>'
            +'<td>'
            +'<div class="addDeleteButton">'
            +'<span class="tooltips deletempRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'
            +'</div></td></tr>';
            $('.invalidemperror').removeClass('has-errorp');
            $('#invalidemperrorid').html('');
            var clonedRow = $(this).parents('tbody.addempRow').find('tr:first').clone();
            clonedRow.find('input:not(.ftype)').val('');
            clonedRow.find('.tooltip').css('display','none');  
            clonedRow.find('.tooltips').tooltip({placement: 'top'});
            $(this).parents('#emptble tbody').find("tr:last").before(html);
            empcnt++;
            $('#position0').val('');
            $('#from0').val('');
            $('#to0').val('');
            $('#employer_details0').val('');
            $('#responsibilities0').val('');
            $('#cost_to_company0').val('');
        }
        Metronic.init();
    });
    
    
     $(document).on('click','.deletempRow', function(){ 
            $(this).closest('tr').remove(); 
        
    });
    
    
    
    
    
    $(document).on('click','.deleteFRow', function(){ 
        $(this).closest('tr').remove();   
        
    });
    $(document).on('click','.deleteduRow', function(){ 
        $(this).closest('tr').remove();   
        
    });
    $(document).on('click','.deleteParticularRow', function(){ 
        $(this).closest('tr').remove();   
        var k=0; 
        $("tbody.appendDynaRow  tr").each(function() {
            k++;
            $(this).find('input[type=radio]').val(k);
        });  
    });