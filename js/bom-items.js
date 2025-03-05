

$(document).ready(function () {
	var base_url = $("#base_url").val().trim();
	var download_title = "BOM Item List";
	var recordsPerPage = 10;
	var BoqItemdataTable = $("#pbomlist").DataTable({
		dom: "Bfrtip",
		scrollY: 400,
		scrollX: true,
		scroller: true,
		fixedHeader: {
			header: true,
			footer: true,
		},
		initComplete: function () {
			BoqItemdataTable.rows().every(function () {
				var row = this;
				var rowData = row.data();
				// Check if subTableData is not empty
				if (rowData.subTableData && Object.keys(rowData.subTableData).length > 0) {
					var tr = row.node();
					var html = generate_table(rowData);
					row.child(html).show();
					$(tr).addClass('shown ');
					$('.dt-hasChild').next().css('background','#f5f5f5');
            		$('.dt-hasChild').next().css('box-shadow','inset 0 0 0 9999px rgba(0, 0, 0, 0.075)');
					$('.dt-hasChild').next().addClass('sub-table');
					$('.sub-table > td ').css('padding', '0');
					
				}
			});
		},
		drawCallback: function (settings) {
			var api = this.api();
			// Check if the table is empty
			if (api.rows().count() === 0) {
				return;
			}
			api.rows().every(function () {
				var row = this;
				var rowData = row.data();
	
				// Check if subTableData is not empty
				if (rowData.subTableData && Object.keys(rowData.subTableData).length > 0) {
					var tr = row.node();
					var html = generate_table(rowData);
					row.child(html).show();
					$(tr).addClass('shown');
					$('.dt-hasChild').next().css('background', '#f5f5f5');
					$('.dt-hasChild').next().css('box-shadow', 'inset 0 0 0 9999px rgba(0, 0, 0, 0.075)');
					$('.dt-hasChild').next().addClass('sub-table');
					$('.sub-table > td ').css('padding', '0');
				}
			});
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
		buttons: [
			"pageLength",
			{
				extend: "copy",
				title: download_title,
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7],
				},
				footer: true,
			},
			{
				extend: "excel",
				title: download_title,
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7],
				},
				footer: true,
				customize: function (xlsx) {
					var sheet = xlsx.xl.worksheets["sheet1.xml"];
					$('row c[r^="D"]', sheet).each(function () {
						$(this).attr("s", "55");
					});
				},
			},
			{
				extend: "pdf",
				title: download_title,
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7],
				},
				footer: true,
			},
			{
				extend: "print",
				title: download_title,
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7],
				},
				footer: true,
			},
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
		order: [[1, "asc"]],
		fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1;
			var indexOnPage = iDisplayIndexFull % recordsPerPage;
			var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;

			$("td:eq(0)", nRow).text(serialNumber);
			aData[0] = serialNumber;
		},
		ajax: {
			url: base_url + "project_bom_boq_item_list",
			type: "POST",
			data: {
				project_id: $("#project_id").val(),
			},
			dataSrc: function (result) {
				if (
					result.BOMUploadTransaction &&
					result.BOMUploadTransaction != "" &&
					result.BOMUploadTransaction >= 1
				) {
					$("#bomUploadLimit").show();
					$("#bom_excel_file").prop("disabled", true);
				} else {
					$("#bomUploadLimit").hide();
					$("#bom_excel_file").prop("disabled", false);
				}

				return result.data;
			},
		},
		 columnDefs: [
			{
				targets: [8],
				className: "w70",
			},
		 ],
	});
	new $.fn.dataTable.FixedHeader(BoqItemdataTable);

});

function generate_table(rowData) {

    // var boq_code = rowData.boq_code;
    let number = Math.floor(Math.random() * 1000000);

    var html = '<hr>';
    var html = '<div class="portlet-body" id="displayed' + number + '">'
    + '<div class="displayFlx" style="display:flex;">'
    + '<div class="col-md" id="calculatedfiler' + number + '"></div>'
    + '</div>'
    + '<div id="originalpbomviewdiv' + number + '"><div class="table-responsive">'
    + '<table width="100%" id="originalpbomview' + number + '" class="table table-striped table-bordered table-hover" style="margin-bottom:0;text-align: left;">'
    + '<thead style="background:#26a69a;color:#fff;font-weight:400;">'
    + '<tr>'
    + '<th scope="col" style="vertical-align: top;">BOM Sr.No.</th>'
    + '<th scope="col" style="vertical-align: top;">HNS Code</th>'
    + '<th scope="col" style="vertical-align: top;">BOM Item Description</th>'
    + '<th scope="col" style="vertical-align: top;">Make</th>'
    + '<th scope="col" style="vertical-align: top;">Model</th>'
    + '<th scope="col" style="vertical-align: top;">Unit</th>'
    + '<th scope="col" style="vertical-align: top;">Build Qty</th>'
    + '<th scope="col" style="vertical-align: top;">Basic Rate</th>'
    + '<th scope="col" style="vertical-align: top;">GST (%)</th>'
    + '<th scope="col" style="vertical-align: top;">Amount</th>'
    // + '<th scope="col" style="vertical-align: top;text-align:right;">Action</th>'
    + '</tr>'
    + '</thead>'

        // Loop through subTableData and add rows to the sub-table
    for (var i = 0; i < rowData.subTableData.length; i++) {
        var subRowData = rowData.subTableData[i];
        html += '<tr>';
        for (var j = 0; j < subRowData.length; j++) {
            html += '<td>' + subRowData[j] + '</td>';
        }
        html += '</tr>';
    }
    html += '</tbody>'
    + '</table></div></div><hr style="margin: 5px 0;border:0;">';
    return html;
}


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
            $("#displayBoqItems").hide();
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
        $('#displayBoqItems').show();
        var table = $('#boqitmdisplay').DataTable({
            "bAutoWidth": false,
            "oLanguage": {
                "sEmptyTable": "No BOQ Items Available"
            },
            "bDestroy" : true,
            "bInfo" : false,
            "ordering": false,
            "searching":false,
            "paging": false,
            "deferRender": true,
            "responsive": false,
            "processing": true,
            "serverSide": false,
            "order": [],
            "ajax": {
                "url": base_url+"get_boq_item_info",
                "type": "POST",
                "data":{
                    project_id:project_id,
                    boq_code:boq_code
                }
            },
            "createdRow": function(row, data, dataIndex) {
                $('td', row).last().addClass('align');
            },
            "columnDefs": [{ 

                "targets": [0],

                "orderable": false

            }]
        });
	}
});

$(document).on('click',".add_bom_item",function() {
    var boq_code  = $("#boq_items").val();
    var project_id = $("#project_id").val();

    var build_qty = '';
    build_qty = function () {
    var tmp_build_qty = '0';
    $.ajax({
        'async': false,
        'type': "POST",
        'global': false,
        'dataType': 'html',
        'url': completeURL('check_build_qty'),
        'data': { 'boq_code': boq_code, 'project_id': project_id},
        'success': function (resultData) {
            const result = JSON.parse(resultData);
            if(result['non_schedule'] !== '' && typeof result['non_schedule'] !== "undefined" && result['non_schedule'] && result['non_schedule'] == "Y"){
                const last_design_qty = result['last_design_qty'];
                tmp_build_qty = last_design_qty;
            }else{
                tmp_build_qty = result['scheduled_qty'];
            }
        }
    });
    return tmp_build_qty;
    }();
    // console.log(build_qty);
    var url = 'check_bom_pending_approvel';
    $.ajax({
        type:'POST',
        url:completeURL(url), 
        dataType:'json',
        data:{project_id:project_id,boq_code:boq_code},
        success:function(result){
            // console.log(build_qty);
            if(build_qty <= 0) {
                $('#invaliderrorid').html('Build.Qty must be greater than 0');
            } else if(result.count > 0) {
                $('#invaliderrorid').html('BOM Items Pending for Approval!');
            } else {
                $('#invaliderrorid').html('');
                var tr = $(this).closest('tr');
                var html = `<tr><td colspan="11">
                <div class="portlet-body form" id="displayed">
                    <div id="addbomitemsdiv">
                        <div class="table-responsive">
                            <table width="100%" id="addbomitems" class="table table-striped table-bordered table-hover" style="text-align: left;">
                                <thead style="background:#26a69a;color:#fff;font-weight:400;">
                                    <tr>
                                        <th scope="col" style="vertical-align: top;">BOM Sr.no.</th>
                                        <th scope="col" style="vertical-align: top;">HNS Code</th>
                                        <th scope="col" style="vertical-align: top;">Item Name</th>
                                        <th scope="col" style="vertical-align: top;">Unit</th>
                                        <th scope="col" style="vertical-align: top;">Make</th>
                                        <th scope="col" style="vertical-align: top;">Model</th>
                                        <th scope="col" style="vertical-align: top;">Quantity</th>
                                        <th scope="col" style="vertical-align: top;">Rate Basic</th>
                                        <th scope="col" style="vertical-align: top;">GST(%)</th>
                                        
                                        <th scope="col" style="vertical-align: top;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td><input type="text" class="form-control invaliderror" id="bom_sr_no" placeholder="BOM Sr.no." style="font-size: 12px;width:100%"></td>
                                    <td><input type="text" class="form-control invaliderror" id="bom_hns_code" placeholder="HNS Code" style="font-size: 12px;width:100%"></td>
                                    <td><input type="text" class="form-control invaliderror" id="bom_item_name" placeholder="Item Name" style="font-size: 12px;width:100%"></td>
                                    <td><input type="text" class="form-control invaliderror" id="bom_unit" placeholder="Unit" style="font-size: 12px;width:100%"></td>
                                    <td><input type="text" class="form-control invaliderror" id="bom_make" placeholder="Make" style="font-size: 12px;width:100%"></td>
                                    <td><input type="text" class="form-control invaliderror" id="bom_model" placeholder="Model" style="font-size: 12px;width:100%"></td>
                                    <td><input type="text" class="form-control invaliderror" id="bom_quantity" placeholder="Quantity" style="font-size: 12px;width:100%"></td>
                                    <td><input type="text" class="form-control invaliderror" id="bom_rate_basic" placeholder="Rate Basic" style="font-size: 12px;width:100%"></td>
                                    <td><input type="text" class="form-control invaliderror" id="bom_gst" placeholder="0.00" style="font-size: 12px;width:100%"></td>
                                    
                                    <td style="text-align: center;vertical-align: middle;"><span class="tooltips addDynaRowBom" data-placement="top" data-original-title="Add" style="cursor: pointer;"><i class="fa fa-plus" style="color:#000"></i></span></td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </tr></td>
                `;
                if($('#addbomitems').length == 0) {
                    $("#boqitmdisplay tbody").append(html);
                }
            }
        }
    });
});


$(document).on('click','.addDynaRowBom',function(){
    // console.log('dfddf');

    var project_id = document.getElementById("project_id").value;
    var bom_sr_no = document.getElementById("bom_sr_no").value;
    var bom_hns_code = document.getElementById("bom_hns_code").value;
    var bom_item_name = document.getElementById("bom_item_name").value;
    var bom_unit = document.getElementById("bom_unit").value;
    var bom_quantity = document.getElementById("bom_quantity").value;
    var bom_rate_basic = document.getElementById("bom_rate_basic").value;
    var bom_gst = document.getElementById("bom_gst").value;
    var bom_make = document.getElementById("bom_make").value;
    var bom_model = document.getElementById("bom_model").value;
    var boq_code = $("#boq_items").val();
    var $this = $(this);


    // var bom_amount = document.getElementById("bom_amount").value;
    
    if(bom_sr_no == '' || bom_hns_code == '' || bom_item_name == '' || bom_unit === '' || bom_quantity=== '' || bom_rate_basic==='' || bom_gst==='' ){
        
        if (bom_sr_no == '') {
            $('#invaliderrorid').html('BOM Sr No is empty !');
        } else if (bom_hns_code == '') {
            $('#invaliderrorid').html('HNS code is empty !');
        }else if (bom_item_name == '') {
            $('#invaliderrorid').html('Item name is empty !');
        }else if (bom_unit == '') {
            $('#invaliderrorid').html('Unit is empty !');
        } else if (bom_quantity == '') {
            $('#invaliderrorid').html('Quantity is empty !');
        }else if (bom_rate_basic == '') {
            $('#invaliderrorid').html('rate basic is empty !');
        }else if (bom_gst == '') {
            $('#invaliderrorid').html('gst is empty !');
        }

        //$('.invaliderror').addClass('has-error');
    }else{

        var url = 'get_last_design_qty_bom_item';
        $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:{project_id:project_id,bom_code:bom_sr_no,boq_code:boq_code},
            success:function(result){
                
                var last_design_qty = parseInt(result);
               // var bom_quantity  = parseInt(bom_quantity);
                //console.log(last_design_qty);
                //console.log(last_design_qty === parseInt(bom_quantity));

                if(last_design_qty === parseInt(bom_quantity)){
                    console.log('a');
                    $('#invaliderrorid').html('BOM Sr No '+bom_sr_no+' design Qty must be greater than original design qty!');
                
                } else {
                    $('#invaliderrorid').html('');
                    console.log('aff');
                     $('.invaliderror').removeClass('has-error');
                    var html='<tr><td>'
                    +'<input type="text" class="form-control" name="bom_sr_no[]" value="'+bom_sr_no+'" readonly style="font-size: 12px;width:100%"></td>'
                    +'<td><input type="text" class="form-control" name="bom_hns_code[]" value="'+bom_hns_code+'" readonly style="font-size: 12px;width:100%"></td>'
                    +'<td><input type="text" class="form-control" name="bom_item_name[]" value="'+bom_item_name+'" readonly style="font-size: 12px;width:100%"></td>'
                    +'<td><input type="text" class="form-control" name="bom_unit[]" value="'+bom_unit+'" readonly style="font-size: 12px;width:100%"></td>'
                    +'<td><input type="text" class="form-control" name="bom_make[]" value="'+bom_make+'" readonly style="font-size: 12px;width:100%"></td>'
                    +'<td><input type="text" class="form-control" name="bom_model[]" value="'+bom_model+'" readonly style="font-size: 12px;width:100%"></td>'
                    +'<td><input type="text" class="form-control" name="bom_quantity[]" value="'+bom_quantity+'" readonly style="font-size: 12px;width:100%"></td>'
                    +'<td><input type="text" class="form-control" name="bom_rate_basic[]" value="'+bom_rate_basic+'" readonly style="font-size: 12px;width:100%"></td>'
                    +'<td><input type="text" class="form-control" name="bom_gst[]" value="'+bom_gst+'" readonly style="font-size: 12px;width:100%"></td>'
                    +'<td style="text-align: center;vertical-align: middle;">'
                    +'<div class="addDeleteButton">'
                    +'<span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
                    +'</div></td></tr>';
                    
                    $this.parents('#boqitmdisplay tbody').find("tr:last").before(html);

                    $("#bom_sr_no").val("");
                    $("#bom_hns_code").val("");
                    $("#bom_item_name").val("");
                    $("#bom_unit").val("");
                    $("#bom_quantity").val("");
                    $("#bom_rate_basic").val("");
                    $("#bom_gst").val("");
                    $("#bom_make").val('');
                    $("#bom_model").val('');
                }
            }
        });
    }

});







$(document).on('keyup', '#bom_sr_no', function() {
    $('#invaliderrorid').html('');
    var bom_code = $(this).val();
    var project_id = $('#project_id').val();
    var boq_code = $("#boq_items").val();

	var bom_code_arr = [];
	$('input[name^="bom_sr_no"]').each( function() {
        var single_bom_code = $(this).val();
		bom_code_arr.push(single_bom_code);
    });

   // console.log(bom_code_arr);
	var status_check;
	if(jQuery.inArray(bom_code, bom_code_arr) !== -1) {
		$('#invaliderrorid').html('BOM Sr No '+bom_code+' details Already Exist!');
		$('#bom_sr_no').val('');
		$('#bom_hsn_sac_code').val('');
		$('#bom_item_description').val('');
		$('#bom_unit').val('');
		$('#bom_o_design_qty').val('');
		$('#bom_rate_basic').val('');
		$('#bom_gst').val('');
        $('#bom_make').val('');
        $('#bom_model').val('');
		return false;
	}

    if(bom_code !== '' && typeof bom_code !== "undefined"){
        var url = 'get_bom_item_details';
        $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:{project_id:project_id,bom_code:bom_code,boq_code:boq_code},
            success:function(result){
                if(result.bom_code !== '' && typeof result.bom_code !== "undefined"){
					// $('#invaliderrorid').html('BOM Sr No '+bom_code+' details Already Exist!');
					$('#bom_sr_no').val('');

					// $('#bom_hns_code').val(result.hsn_sac_code);
					// $('#bom_item_name').val(result.item_description);
					// $('#bom_unit').val(result.unit);
                    // $('#bom_rate_basic').val(result.rate_basic);
                    // $('#bom_gst').val(result.gst);    
					// $('#bom_quantity').val(result.o_design_qty);
                    // $('#bom_make').val(result.make);
                    // $('#bom_model').val(result.model);
                    // $('#bom_hns_code, #bom_item_name, #bom_unit, #bom_rate_basic, #bom_gst,#bom_make,#bom_model').prop('readonly', true);

					// $('#bom_rate_basic').val('');
					// $('#bom_gst').val('');
                    $('#invaliderrorid').html('BOM Item Already exist!');
				} else {
                    // $("#bom_sr_no").val("");
                    $("#bom_hns_code").val("");
                    $("#bom_item_name").val("");
                    $("#bom_unit").val("");
                    $("#bom_quantity").val("");
                    $("#bom_rate_basic").val("");
                    $("#bom_gst").val("");
                    $('#bom_make').val("");
                    $('#bom_model').val("");
                    $('#bom_hns_code, #bom_item_name, #bom_unit, #bom_rate_basic, #bom_gst,#bom_make,#bom_model').prop('readonly', false);
                }
        	}
        });
    }else{
        $("#bom_sr_no").val("");
        $("#bom_hns_code").val("");
        $("#bom_item_name").val("");
        $("#bom_unit").val("");
        $("#bom_quantity").val("");
        $("#bom_rate_basic").val("");
        $("#bom_gst").val("");
        $('#bom_make').val("");
        $('#bom_model').val("");
        $('#bom_hns_code, #bom_item_name, #bom_unit, #bom_rate_basic, #bom_gst,#bom_make,#bom_model').prop('readonly', false);
    }
});


$(document).on('click','.editBomRecord', function(){

	var project_id = $(this).attr('data-project_id');
	var boq_code = $(this).attr('data-boq_code');
	var url = $(this).attr('rev');

	$.ajax({
		url : completeURL(url),
		type : 'POST',
		dataType : 'html',
		data:{project_id:project_id,boq_code:boq_code,page:'add_edit'},
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

$(document).on('click', '.openBomview', function() {
	$(this).text(function(i, text){
		return text === "VIEW" ? " CLOSE" : "VIEW";
	});
    var id = $(this).closest('tr').next('tr').find('table').toggleClass('d-none');
});

$(document).on('click','.addBOMData',function(e){  
    var maintml = $(this);
    var bom_sr_no = document.getElementById("bom_sr_no").value;
    var bom_hsn_sac_code = document.getElementById("bom_hsn_sac_code").value;
	var bom_item_description = document.getElementById("bom_item_description").value;
	var bom_unit = document.getElementById("bom_unit").value;
	var bom_o_design_qty = document.getElementById("bom_o_design_qty").value;
	var bom_rate_basic = document.getElementById("bom_rate_basic").value;
	var bom_gst = document.getElementById("bom_gst").value;
	var project_id = document.getElementById("project_id").value;
	var boq_code = document.getElementById("bom_boq_sr_no").value;
    var bom_item_make = document.getElementById("bom_item_make").value;
    var bom_item_model = document.getElementById("bom_item_model").value;


	if(bom_sr_no === '' || bom_hsn_sac_code === '' || bom_item_description === '' || bom_unit === '' 
	|| bom_o_design_qty === '' || bom_rate_basic === '' || bom_gst === ''){
        $('.invaliderrorexcept').addClass('has-error-d');
		$('#invaliderrorexceptdiv').html('BOM item details required.');
    } else {
		$('.invaliderrorexcept').removeClass('has-error-d');
		$('#invaliderrorexceptdiv').html('');

		var html='<tr><td>'
		+'<input type="text" class="form-control" name="bom_code[]" value="'+bom_sr_no+'" readonly style="font-size: 12px;width:100%">'
		+'</td>'
		+'<td><input type="text" class="form-control js-bom-add" name="bom_hsn_sac_code[]" value="'+bom_hsn_sac_code+'" readonly style="font-size: 12px;width:100%"></td>'
		+'<td><input type="text" class="form-control js-bom-add" name="bom_item_description[]" value="'+bom_item_description+'" readonly style="font-size: 12px;width:100%"></td>'
        +'<td><input type="text" class="form-control js-bom-add" name="bom_item_make[]" value="'+bom_item_make+'" readonly style="font-size: 12px;width:100%"></td>'
        +'<td><input type="text" class="form-control js-bom-add" name="bom_item_model[]" value="'+bom_item_model+'" readonly style="font-size: 12px;width:100%"></td>'
		+'<td><input type="text" class="form-control js-bom-add" name="bom_unit[]" value="'+bom_unit+'" readonly style="font-size: 12px;width:100%"></td>'
		+'<td><input type="text" class="form-control js-bom-add" name="bom_o_design_qty[]" value="'+bom_o_design_qty+'" readonly style="font-size: 12px;width:100%"></td>'
		+'<td><input type="text" class="form-control js-bom-add" name="bom_rate_basic[]" value="'+bom_rate_basic+'" readonly style="font-size: 12px;width:100%"></td>'
		+'<td><input type="text" class="form-control js-bom-add" name="bom_gst[]" value="'+bom_gst+'" readonly style="font-size: 12px;width:100%"></td>'
		+'<td>'
		+'<div class="addDeleteButton">'
		+'<span class="tooltips deleteParticularRow" data-placement="top" data-original-title="Remove" style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>'  
		+'</div></td></tr>';
		$(maintml).parents('#bomitmdisplay tbody').find("tr:last").before(html);
		$('#bom_sr_no').val('');
		$('#bom_hsn_sac_code').val('');
		$('#bom_item_description').val('');
		$('#bom_unit').val('');
		$('#bom_o_design_qty').val('');
		$('#bom_rate_basic').val('');
		$('#bom_gst').val('');
        $('#bom_item_make').val('');
        $('#bom_item_model').val('');
	}
});
