$(document).on("click", ".date1", function () {
	$(".date1").datepicker({
		orientation: "right",
		autoclose: true,
	});
});
var original_invoice_value = 0;
$(".round-off-select").select2()
var base_url = $("#base_url").val().trim();
var project_id = $("#project_id").val().trim();
var download_title = "Proforma Invoice";

$(document).on("change", "#project_id", function () {
	var gst_type = $("#gst_type").val();
	if (gst_type === "" || gst_type === null) {
		$("#displayTaxInvc").hide();
		$("#invaliderrorgst").html("Please Select Gst Type!");
		return;
	}

	var project_id = $("#project_id").val();

	if (gst_type == "igst") {
		if (project_id) {
			$("#invaliderrorgst").html("");
			$("#displayProformaInvc").show();
			$("#displayperfomaInvccgst").hide();
			$("#proformainvcdisplay").DataTable({
				bAutoWidth: false,
				bDestroy: true,
				bInfo: false,
				ordering: false,
				searching: false,
				paging: false,
				deferRender: true,
				responsive: false,
				processing: true,
				serverSide: true,
				order: [],
				ajax: {
					url: base_url + "get_proforma_by_projects",
					type: "POST",
					data: {
						project_id: project_id,
						gst_type: gst_type,
					},
                    dataSrc:function(result) {
                        const payment_terms = result.billing_split.payment_terms;
                        if(payment_terms !== '' && typeof  payment_terms!== "undefined" && payment_terms =='SITC'){
                            $("#billingsplitdetails").show();
                            $("#billing_split_supply").val(result.billing_split.bill_split_supply);
                            $("#billing_split_installation").val(result.billing_split.bill_installation);
                            $("#billing_split_test_comminss").val(result.billing_split.testing_commissioning);
                            $("#billing_split_handover").val(result.billing_split.bill_handover);
							$("#billing_split_up_container").show();
							$("#billing_split_up").trigger("change");
							$(".total_type_amount_row").show();
							$(".total_type_amount_igst_row").show();
                        } else {
                            $("#billingsplitdetails").hide();
							$("#billing_split_up_container").hide();
							$(".total_type_amount").val("");
							$(".total_type_amount_row").hide();
							$(".total_type_amount_igst_row").hide();
                        }
						return result.data;
                    }
				},
				columnDefs: [
					{
						targets: [0],
						orderable: false,
					},
				],
			});
		} else {
		}
	} else {
		if (project_id) {
			
			$("#invaliderrorgst").html("");
			$("#displayProformaInvc").hide();
			$("#displayperfomaInvccgst").show();
			$("#taxperfomadisplaysgsts").DataTable({
				bAutoWidth: false,
				bDestroy: true,
				bInfo: false,
				ordering: false,
				searching: false,
				paging: false,
				deferRender: true,
				responsive: false,
				processing: true,
				serverSide: true,
				order: [],
				ajax: {
					url: base_url + "get_proforma_by_projects",
					type: "POST",
					data: {
						project_id: project_id,
						gst_type: gst_type,
					},
                    dataSrc:function(result) {
                        const payment_terms = result.billing_split.payment_terms;
						const billing_type_arr = result.billing_split.billing_type_arr;

                        if(payment_terms !== '' && typeof  payment_terms!== "undefined" && payment_terms =='SITC'){
                            $("#billingsplitdetails").show();
                            $("#billing_split_supply").val(result.billing_split.bill_split_supply);
                            $("#billing_split_installation").val(result.billing_split.bill_installation);
                            $("#billing_split_test_comminss").val(result.billing_split.testing_commissioning);
                            $("#billing_split_handover").val(result.billing_split.bill_handover);
							$("#billing_split_up_container").show();

							if(jQuery.inArray("supply", billing_type_arr) === -1) {
								$("#project_billing_type").val('supply');
								// $("#billing_split_up").val('supply').change().attr('disabled', true);
							} else if (jQuery.inArray("installation", billing_type_arr) === -1) {
								$("#project_billing_type").val('installation');
								// $("#billing_split_up").val('installation').change().attr('disabled', true);
							} else if (jQuery.inArray("testing_commissioning", billing_type_arr) === -1) {
								$("#project_billing_type").val('testing_commissioning');
								// $("#billing_split_up").val('testing_commissioning').change().attr('disabled', true);
							} else if (jQuery.inArray("handover", billing_type_arr) === -1) {
								$("#project_billing_type").val('handover');
								// $("#billing_split_up").val('handover').change().attr('disabled', true);
							} else {
								$("#project_billing_type").val('');
								// $("#billing_split_up").val(' ').change().attr('disabled', true);
							}
							$("#billing_split_up").trigger("change");
							$(".total_type_amount_row").show();
							$(".total_type_amount_igst_row").show();
							$("#billing_split_up").parents(".form-groupp").addClass("has-error");
                        } else {
                            $("#billingsplitdetails").hide();
							$("#billing_split_up_container").hide();
							$(".total_type_amount").val("");
							$(".total_type_amount_row").hide();
							$(".total_type_amount_igst_row").hide();
							$("#billing_split_up").parents(".form-groupp").removeClass("has-error");
							
							// $("#project_billing_type").val('');
							// $("#billing_split_up").val('').change().attr('disabled', true);
                        }
						$("#proforma_sub_total1").html("");
						$("#proforma_cgst_total1").html("");
						$("#proforma_sgst_total1").html("");
						$("#proforma_final1").html("");
                        return result.data;
                    }
				},
				columnDefs: [
					{
						targets: [0],
						orderable: false,
					},
				],
			});
		} else {
		}
	}
});

$(document).on("change", "#gst_type", function () {
	var gst_type = $("#gst_type").val();
	if (gst_type === "" || gst_type === null) {
		$("#displayTaxInvc").hide();
		$("#invaliderrorgst").html("Please Select Gst Type!");
		return;
	}

	var project_id = $("#project_id").val();
	if (gst_type == "igst") {
		if (project_id) {
			$("#invaliderrorgst").html("");
			$("#displayProformaInvc").show();
			$("#displayperfomaInvccgst").hide();
			$("#proformainvcdisplay").DataTable({
				bAutoWidth: false,
				bDestroy: true,
				bInfo: false,
				ordering: false,
				searching: false,
				paging: false,
				deferRender: true,
				responsive: false,
				processing: true,
				serverSide: true,
				order: [],
				ajax: {
					url: base_url + "get_proforma_by_projects",
					type: "POST",
					data: {
						project_id: project_id,
						gst_type: gst_type,
					},
                    dataSrc:function(result) {
                        const payment_terms = result.billing_split.payment_terms;
                        if(payment_terms !== '' && typeof  payment_terms!== "undefined" && payment_terms =='SITC'){
                            $("#billingsplitdetails").show();
                            $("#billing_split_supply").val(result.billing_split.bill_split_supply);
                            $("#billing_split_installation").val(result.billing_split.bill_installation);
                            $("#billing_split_test_comminss").val(result.billing_split.testing_commissioning);
                            $("#billing_split_handover").val(result.billing_split.bill_handover);
							$("#billing_split_up_container").show();
							$("#billing_split_up").trigger("change");
							$(".total_type_amount_row").show();
							$(".total_type_amount_igst_row").show();
                        } else {
                            $("#billingsplitdetails").hide();
							$("#billing_split_up_container").hide();
							$(".total_type_amount").val("");
							$(".total_type_amount_row").hide();
							$(".total_type_amount_igst_row").hide();
                        }
						return result.data;
                    }
				},
				columnDefs: [
					{
						targets: [0],
						orderable: false,
					},
				],
			});
		} else {
		}
	} else {
		if (project_id) {
			$("#invaliderrorgst").html("");
			$("#displayProformaInvc").hide();
			$("#displayperfomaInvccgst").show();
			$("#taxperfomadisplaysgsts").DataTable({
				bAutoWidth: false,
				bDestroy: true,
				bInfo: false,
				ordering: false,
				searching: false,
				paging: false,
				deferRender: true,
				responsive: false,
				processing: true,
				serverSide: true,
				order: [],
				ajax: {
					url: base_url + "get_proforma_by_projects",
					type: "POST",
					data: {
						project_id: project_id,
						gst_type: gst_type,
					},
                    dataSrc:function(result) {
                        const payment_terms = result.billing_split.payment_terms;
                        if(payment_terms !== '' && typeof  payment_terms!== "undefined" && payment_terms =='SITC'){
                            $("#billingsplitdetails").show();
                            $("#billing_split_supply").val(result.billing_split.bill_split_supply);
                            $("#billing_split_installation").val(result.billing_split.bill_installation);
                            $("#billing_split_test_comminss").val(result.billing_split.testing_commissioning);
                            $("#billing_split_handover").val(result.billing_split.bill_handover);
							$("#billing_split_up_container").show();
                        } else {
                            $("#billingsplitdetails").hide();
							$("#billing_split_up_container").hide();
                        }
                        return result.data;
                    }
				},
				columnDefs: [
					{
						targets: [0],
						orderable: false,
					},
				],
			});
		} else {
		}
	}
});

$("#proformaInvclist").DataTable({
	dom: "Bfrtip",
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
				columns: [0, 1, 2, 3, 4, 5, 6],
			},
			footer: true,
		},
		// {

		//     "extend": 'csv',

		//     "title": download_title,

		//     "exportOptions": {

		//         "columns": [0,1,2,3,4,5,6]

		//     },

		//     "footer": true

		// },

		{
			extend: "excel",
			title: download_title,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6],
			},
			footer: true,
		},

		{
			extend: "pdf",
			title: download_title,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6],
			},
			footer: true,
		},

		{
			extend: "print",
			title: download_title,
			exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6],
			},
			footer: true,
		},
	],

	bAutoWidth: false,
	oLanguage: {
		sEmptyTable: "No Proforma Invoice Available!",
	},

	scrollX: true,
	paging: true,
	iDisplayLength: 25,
	deferRender: true,
	responsive: false,
	processing: true,
	serverSide: false,
	// Initial no order.
	order: [],
	// Load data from an Ajax source
	ajax: {
		url: base_url + "project_proformaInvc_list",
		type: "POST",
	},
	//Set column definition initialisation properties
	columnDefs: [
		{
			targets: [0, 2, 4, 5, 7],
			orderable: false,
		},
	],
});

$(document).on("change","#billing_split_up",function(){
	let gst_type = $("#gst_type").val();
	if(gst_type == "cgst_sgst"){
		// var proforma_final = $("#proforma_final1").html();
		var proforma_final = $("#original_invoice_value").val();
	}else{
		// var proforma_final = $("#proforma_igst_final").html();
		var proforma_final = $("#original_igst_invoice_value").val();
	}

	var project_billing_type = $(this).val();
	var percentage_val = 0;
	if(project_billing_type == "supply"){
		percentage_val = parseFloat($("#billing_split_supply").val());
	}else if(project_billing_type == "installation"){
		percentage_val = parseFloat($("#billing_split_installation").val());
	}else if(project_billing_type == "testing_commissioning"){
		percentage_val = parseFloat($("#billing_split_test_comminss").val());
	}else if(project_billing_type == "handover"){
		percentage_val = parseFloat($("#billing_split_handover").val());
	}
	var auto_round_off = $('#flexCheckIndeterminate').prop('checked');
	var auto_round_off_type = $("#auto_round_off_type").val();
	var auto_round_off_val = $("#auto_round_off_value").val();
	if(proforma_final != ""){
		proforma_final = parseFloat(proforma_final);
		proforma_final = (proforma_final != undefined && proforma_final > 0) ? proforma_final : 0;
		if(auto_round_off_val > 0){
			if(auto_round_off_type == "Add"){
				proforma_final += parseFloat(auto_round_off_val);
			}else{
				proforma_final -= parseFloat(auto_round_off_val);
			}
		}
		proforma_final_val = proforma_final.toFixed(2);
		if(gst_type == "cgst_sgst"){
			$("#proforma_final1").html(proforma_final_val);
		}else{
			$("#proforma_igst_final").html(proforma_final_val);
		}
		if(percentage_val > 0 && percentage_val != undefined){
			let proforma_final_after_bill_type = (proforma_final*percentage_val)/ 100;
			// proforma_final += proforma_final_after_bill_type; 
			proforma_final = proforma_final_after_bill_type; 
		}
		proforma_final = proforma_final.toFixed(2)
		$(".total_type_amount").html(proforma_final);
	}else{
		proforma_final = proforma_final;
		$(".total_type_amount").html(proforma_final);
	}
	$("#project_billing_type_value").val(percentage_val.toFixed(2));
	

});
$(document).on("change","#flexCheckIndeterminate,#auto_round_off_type",function(){
	var auto_round_off = $('#flexCheckIndeterminate').prop('checked');
	if(auto_round_off){
		$('#flexCheckIndeterminate').val("Yes");
	}else{
		$('#flexCheckIndeterminate').val("No");
	}
	roudnOffInvoiveAmount();
});


// $(document).on("keyup","#auto_round_off_value",function(){
	
// 	var charCode = (event.which) ? event.which : event.keyCode;
//     var value = $(this).val();
//     if (value.includes('.')  && charCode == 46 ) {
//           event.preventDefault();
//     }
//         // Allow only digits (0-9) and some specific control keys
//     if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !== 46) {
//               event.preventDefault();
//     }
//     value = this.value.replace(/[^0-9.]/g, '');
//     if(value.toString().split('.')[1] && value.toString().split('.')[1].length > 2){
//      	 value = parseFloat(value).toFixed(2);
//     }
//     // console.log(value)
//     if(parseFloat(value) > 999.99){
//     	if(value == 1000){
//      		value = 999.99;
//      	}else{
//      		value = 0;
//      	}
//     }
//     $(this).val(value);
// 	roudnOffInvoiveAmount();
// });


// Code By Deepak Start

// $(document).on("change", "#auto_round_off_value", function () {
//     var value = $(this).val().trim(); // Trim to remove extra spaces

//     // Allow only numbers and one decimal point
//     value = value.replace(/[^0-9.]/g, "");

//     // Ensure single decimal point
//     let decimalParts = value.split(".");
//     if (decimalParts.length > 2) {
//         value = decimalParts[0] + "." + decimalParts[1]; // Keep only the first decimal
//     }

//     // Convert to float and restrict to 2 decimal places
//     var floatValue = parseFloat(value);
//     if (isNaN(floatValue)) {
//         floatValue = 0;
//     } else {
//         floatValue = floatValue.toFixed(2);
//     }

//     // Ensure max value is 999.99
//     if (floatValue > 999.99) {
//         floatValue = 999.99;
//     }

//     $(this).val(floatValue);

//     // Call function to update invoice amount
//     roudnOffInvoiveAmount();
// });

//Code By Deepak End 






function roudnOffInvoiveAmount(){
	let gst_type = $("#gst_type").val();
	if(gst_type == "cgst_sgst"){
		var original_invoice_value = $("#original_invoice_value").val();
	}else{
		// var original_invoice_value = $("#original_igst_invoice_value").val();
		var original_invoice_value = document.getElementById("proforma_igst_final").innerText;
	    // console.log(original_invoice_value);
	}


	
	var auto_round_off = $('#flexCheckIndeterminate').prop('checked');
	var auto_round_off_type = $("#auto_round_off_type").val();
	var auto_round_off_val = $("#auto_round_off_value").val();
	var project_billing_type = $("#billing_split_up").val();
	var percentage_val = 0;
	if(project_billing_type == "supply"){
		percentage_val = parseFloat($("#billing_split_supply").val());
	}else if(project_billing_type == "installation"){
		percentage_val = parseFloat($("#billing_split_installation").val());
	}else if(project_billing_type == "testing_commissioning"){
		percentage_val = parseFloat($("#billing_split_test_comminss").val());
	}else if(project_billing_type == "handover"){
		percentage_val = parseFloat($("#billing_split_handover").val());
	}
	if(original_invoice_value != ""){
		proforma_final = parseFloat(original_invoice_value);
		proforma_final = (proforma_final != undefined && proforma_final > 0) ? proforma_final : 0;
		if(auto_round_off_val > 0){
			if(auto_round_off_type == "Add"){
				proforma_final += parseFloat(auto_round_off_val);
			}else{
				proforma_final -= parseFloat(auto_round_off_val);
			}
		}
		proforma_final_val = proforma_final.toFixed(2);
		if(gst_type == "cgst_sgst"){
			$("#proforma_final1").html(proforma_final_val);
		}else{
			
			$("#proforma_igst_final").html(proforma_final_val);
		}
		if(percentage_val > 0 && percentage_val != undefined){
			let proforma_final_after_bill_type = (proforma_final*percentage_val)/ 100;
			// proforma_final += proforma_final_after_bill_type; 
			proforma_final = proforma_final_after_bill_type; 
		}
		proforma_final = proforma_final.toFixed(2)
		$(".total_type_amount").html(proforma_final);
	}
}


