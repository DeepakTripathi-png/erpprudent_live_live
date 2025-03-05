var vrcnt = 1
$(document).on('click', '.add_region', function () {
    var region_name = $("#region_name0").val();
    var region_person = $("#region_person0").val();
    if (region_name !== '' && typeof region_name != 'undefined' &&
        region_person !== '' && typeof region_person != 'undefined') {
        $("#region_error").html('');
        var html = '<div class="row region_detail">'
            + '<div class="col-md-5">'
            + '<div class="form-group">'
            + '<label class="control-label">Region Name</label>'
            + '<input type="text" class="form-control " name="region_name[]" id="region_name' + vrcnt + '" value="' + region_name + '" readonly>'
            + '</div>'
            + '</div>'
            + '<div class="col-md-5">'
            + '<div class="form-group">'
            + '<label class="control-label">Region Person</label>'
            + '<input type="text" class="form-control " name="region_person[]" id="region_person' + vrcnt + '" value="' + region_person + '" readonly>'
            + '</div>'
            + '</div>'
            + '<div class="col-md-2">'
            + '<div class="vrbtnss"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>'
            + '</div></div>';
        $("#vendorregionDisplayed").append(html);
        $("#region_name0").val('');
        $("#region_person0").val('');
        vrcnt++;

    } else {
        $("#region_error").html('Please enter region details!');
    }
});

$(document).on('click', '.vrbtnss', function () {

    $(this).parent().parent().remove();
});


var vrrcnt = 1
$(document).on('click', '.add_company', function () {
    var name_of_dir_part = $("#name_of_dir_part0").val();
    var dir_part_contact_no = $("#dir_part_contact_no0").val();
    var dir_part_contact_address = $("#dir_part_contact_address0").val();

    if ((name_of_dir_part !== '' && typeof name_of_dir_part != 'undefined' &&
        dir_part_contact_no !== '' && typeof dir_part_contact_no != 'undefined' &&
        dir_part_contact_address !== '' && typeof dir_part_contact_address != 'undefined')) {
        $("#company_error").html('');
        var html = '<div class="row dir_detail">'
            + '<div class="col-md-4">'
            + '<div class="form-group">'
            + '<label class="control-label">Name of All Director/Partners </label>'
            + '<input type="text" class="form-control " name="name_of_dir_part[]" id="name_of_dir_part' + vrrcnt + '" value="' + name_of_dir_part + '" readonly required="">'
            + '</div>'
            + '</div>'
            + '<div class="col-md-4">'
            + '<div class="form-group">'
            + '<label class="control-label">Director/Partner Contact Number </label>'
            + '<input type="text" class="form-control " name="dir_part_contact_no[]" id="dir_part_contact_no' + vrrcnt + '" value="' + dir_part_contact_no + '" readonly required="">'
            + '</div>'
            + '</div>'
            + '<div class="col-md-3">'
            + '<div class="form-group">'
            + '<label class="control-label">Director/Partner Contact Address </label>'
            + '<input type="text" class="form-control " name="dir_part_contact_address[]" id="dir_part_contact_address' + vrrcnt + '" value="' + dir_part_contact_address + '" readonly required="">'
            + '</div>'
            + '</div>'
            + '<div class="col-md-1">'
            + '<div class="vrrbtnss"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>'
            + '</div></div>';
        $("#vendorcompanyDisplayed").append(html);
        $("#name_of_dir_part0").val('');
        $("#dir_part_contact_no0").val('');
        $("#dir_part_contact_address0").val('');
        vrrcnt++;
    } else {
        $("#company_error").html('Please enter director details!');
    }
});

$(document).on('click', '.vrrbtnss', function () {
    $(this).parent().parent().remove();
});



var refcnt = 1;
$(document).on('click', '.add_reference', function () {
    var references = $("#references0").val();
    var reference_name = $("#reference_name0").val();
    if ((references !== '' && typeof references != 'undefined' &&
        reference_name !== '' && typeof reference_name != 'undefined')) {
        $("#reference_error").html('');
        var html = '<div class="row reference_detail">'
            + '<div class="col-md-5">'
            + '<div class="form-group">'
            + '<label class="control-label">Reference vendor/employee/friends </label>'
            + '<select class="form-control" name="references[]" id="references' + refcnt + '" readonly>'
            + '<option value="" disabled>Select</option>'
            + '<option value="vendor" ' + (references === 'vendor' ? 'selected' : '') + '>Vendor</option>'
            + '<option value="friends" ' + (references === 'friends' ? 'selected' : '') + '>Friends</option>'
            + '<option value="employee" ' + (references === 'employee' ? 'selected' : '') + '>Employee</option>'
            + '</select>'
            + '</div>'
            + '</div>'
            + '<div class="col-md-5">'
            + '<div class="form-group">'
            + '<label class="control-label">Reference Name</label>'
            + '<input type="text" class="form-control " name="reference_name[]" id="reference_name' + refcnt + '" value="' + reference_name + '" readonly>'
            + '</div>'
            + '</div>'
            + '<div class="col-md-2">'
            + '<div class="refbtnss"><i class="fa fa-minus" aria-hidden="true" style="font-size:10px;"></i></div>'
            + '</div></div>';
        $("#referenceDisplayed").append(html);
        $("#references0").val('');
        $("#reference_name0").val('');
        refcnt++;
    } else {
        $("#reference_error").html('Please enter Reference details!');
    }
});

$(document).on('click', '.refbtnss', function () {
    $(this).parent().parent().remove();
});
