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
			sEmptyTable: "No BOM Items Available!",
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
			url: base_url + "project_bom_boq_item_list?project_id="+ $("#project_id").val(),
			type: "GET",
			// data: {
			// 	project_id: $("#project_id").val(),
			// },
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
	$(document).on("change", "#project_id", function () {
		var project_id = $(this).val();
		if (project_id) {
			var url = base_url + "project_bom_boq_item_list";
			url += "?project_id=" + project_id;
			BoqItemdataTable.ajax.url(url).load();
		}
	});
	// var project_id = $("#project_id").val().trim();
	
	// if(project_id != '') {
	// 	var url = base_url + "project_bom_boq_item_list";
	// 	url += "?project_id=" + project_id;
	// 	BoqItemdataTable.ajax.url(url).load();
	// }

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

});


$(document).on('click','.editBomRecord', function(){

	var project_id = $(this).attr('data-project_id');
	var boq_code = $(this).attr('data-boq_code');
	var url = $(this).attr('rev');

	$.ajax({
		url : completeURL(url),
		type : 'POST',
		dataType : 'html',
		data:{project_id:project_id,boq_code:boq_code},
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
	}
});


$(document).on('keyup', '.js-bom-add', function() {
	$('.invaliderrorexcept').removeClass('has-error-d');
	$('#invaliderrorexceptdiv').html('');
});



$(document).on('keyup', '#bom_sr_no', function() {
    $('#invaliderrorid').html('');
    var bom_code = $(this).val();
    var project_id = $('#project_id').val();
	var bom_boq_sr_no = $("#bom_boq_sr_no").val();

	var bom_code_arr = [];
	$('input[name^="bom_code"]').each( function() {
        var single_bom_code = $(this).val();
		bom_code_arr.push(single_bom_code);
    });

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
		return false;
	}

    if(bom_code !== '' && typeof bom_code !== "undefined"){
        var url = 'get_bom_item_details';
        $.ajax({
            type:'POST',
            url:completeURL(url), 
            dataType:'json',
            data:{project_id:project_id,bom_code:bom_code,boq_code:bom_boq_sr_no},
            success:function(result){
                if(result.bom_code !== '' && typeof result.bom_code !== "undefined"){
					$('#invaliderrorid').html('BOM Sr No '+bom_code+' details Already Exist!');
					$('#bom_sr_no').val('');
					$('#bom_hsn_sac_code').val('');
					$('#bom_item_description').val('');
					$('#bom_unit').val('');
					$('#bom_o_design_qty').val('');
					$('#bom_rate_basic').val('');
					$('#bom_gst').val('');
				}
        	}
        });
    }else{
        $('#bom_sr_no').val('');
		$('#bom_hsn_sac_code').val('');
		$('#bom_item_description').val('');
		$('#bom_unit').val('');
		$('#bom_o_design_qty').val('');
		$('#bom_rate_basic').val('');
		$('#bom_gst').val(''); 
    }
});


$(document).on('click', '.openBomview', function() {
	$(this).text(function(i, text){
		return text === "VIEW" ? " CLOSE" : "VIEW";
	});
    var id = $(this).closest('tr').next('tr').find('table').toggleClass('d-none');
});
