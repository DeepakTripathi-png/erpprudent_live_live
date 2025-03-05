$( document ).ready(function() {
  if ($('#project_id').val() != "") {
    var project_id = $('#project_id').val().trim();
  }
  if ($('#base_url').val() != "") {
    var base_url = $('#base_url').val().trim();
  }

  

  var vdc_po_value = $('#vdc_po').val();
  var vdc_po_count = $('#vdc_po_count').val();
  if ($('#vdc_po').val() != "") {
    vdc_po_value=  $('#vdc_po').val().trim()
  }

  if ($('#vdc_po_count').val() != "") {
    vdc_po_count  = $('#vdc_po_count').val().trim()
  }

  if (vdc_po_value == "") {
    $('.vdc_form_data').css("display", "none");
  }
  if (vdc_po_count == 0 && vdc_po_value != "") {
    $('.vdc_form_data').css("display", "none");
    $('.alert-warning').removeClass("hide");
    $('.alert-warning').addClass("show");
  }

  $(document).on('click','.date1',function(){
    $('.date1').datepicker({
      dateFormat: "dd-mm-yy",
      orientation: "right",
      autoclose: true
    });

  });

  var download_title = 'Vendor Delivery Challan';
  var recordsPerPage = 10;


  var vendor_dc_list = $('#vendor_dc_list').DataTable({
    "scrollX": true,
    "dom": 'Bfrtip',
    "lengthMenu": [
      [10,25, 50, 75, 100, 125,150, -1],
      [ '10 rows','25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
    ],
    "buttons": [
      'pageLength',
      {
        "extend": 'copy',
        "title": download_title,
        "exportOptions": {
          "columns": [0,1,2,3,4,5,6,7,8]
        },
        "footer": true
      },
      {
        "extend": 'excel',
        "title": download_title,
        "exportOptions": {
          "columns": [0,1,2,3,4,5,6,7,8]
        },
        "footer": true,
      },
      {
        "extend": 'pdf',
        "title": download_title,
        "exportOptions": {
          "columns": [0,1,2,3,4,5,6,7,8]
        },
        "footer": true
      },
      {
        "extend": 'print',
        "title": download_title,
        "exportOptions": {
          "columns": [0,1,2,3,4,5,6,7,8]
        },
        "footer": true
      }
    ],
    "oLanguage": {
      "sEmptyTable": "No Vendor Delivery Challan Data Found!"
    },
    "bDestroy" : true,
    "bInfo" : false,
    "ordering": true,
    "searching":true,
    "paging": true,
    "iDisplayLength": 25,
    "deferRender": true,
    "responsive": false,
    "processing": true,
    "serverSide": false,
    "order": [],
    "ajax": {
      // "url": base_url+"get_vendor_dc_list?project_id="+$('#project_id').val()+"&type="+page_type,
      "url": base_url+"get_vendor_dc_list",
      "type": "POST",
      "data":{
        project_id:project_id,
        // po_number:po_number,
        type:page_type
      }
    },

  });
  $(document).on('input', ".js-po-basic_rate", function() {
    var basic_rate = parseFloat($(this).parents("tr").find(".basic_rate").val());
    var value = parseFloat($(this).val());
    if(value > basic_rate){
      $(this).val(parseFloat(basic_rate).toFixed(2));
      value = basic_rate;
    }
    const $row = $(this).closest('tr');
    const rate = parseFloat(value) || 0;
    const qty = parseFloat($row.find('[name="bom_good_condition[]"]').val()) || 0;
    const gst = parseFloat($row.find('[name="bom_gst[]"]').val()) || 0;
    const amount = qty * rate * (1 + gst / 100);
    $row.find('[name="amount[]"]').val(amount.toFixed(2));
  });


  $(document).on('input','.js-requires-dc-qty', function() {
    var $row = $(this).closest('tr');
    var dcStock = parseFloat($(this).val());
    var poStock = parseFloat($row.find('.po-avilable-stock').val());
    var dcGoodStock = $row.find('input[name="bom_good_condition[]"]').val();
    if(dcStock > 0){

      if (dcStock > poStock) {
        $(this).val(poStock);
        dcStock = poStock;
        dcGoodStock = dcStock;
        dcBadStock = 0;
      }

      if(dcGoodStock > dcStock){
        dcGoodStock = dcStock;
      }
      dcBadStock = dcStock - dcGoodStock;
      var dcBadStock = dcStock - dcGoodStock;
    }else{
      dcStock = 0;
      dcBadStock = 0;
    }

    var rate = parseFloat($row.find('.js-po-basic_rate').val());
    var gst = parseFloat($row.find('input[name="bom_gst[]"]').val());
    var totalAmount = (rate * dcStock) + (rate * dcStock * gst / 100);
    $row.find('input[name="amount[]"]').val(totalAmount.toFixed(2));
    $row.find('input[name="bom_good_condition[]"]').val(dcGoodStock);
    $row.find('input[name="bom_bad_condition[]"]').val(dcBadStock);
  });


  $(document).on('input', 'input[name="bom_good_condition[]"]', function() {
    var $row = $(this).closest('tr');
    var dcStock = parseFloat($row.find('.js-requires-dc-qty').val()) || 0;
    var goodCondition = parseFloat($(this).val()) || 0;

    if (goodCondition > dcStock) {
      $(this).val(dcStock);
      goodCondition = dcStock;
    }

    var badCondition = dcStock - goodCondition;

    $row.find('input[name="bom_bad_condition[]"]').val(badCondition);

    var rate = parseFloat($row.find('.js-po-basic_rate').val()) || 0;
    var gst = parseFloat($row.find('input[name="bom_gst[]"]').val()) || 0;
    var totalAmount = (rate * goodCondition) + (rate * goodCondition * gst / 100);

    $row.find('input[name="amount[]"]').val(totalAmount.toFixed(2));
  });


  $("#vendor_delivery_challan_update_form").validate({
    rules: {
      project_id: {
        required: true
      },
      vendor_category_id: {
        required: true
      },
      vendor_id: {
        required: true
      },
      work_order_on: {
        required: true
      },
      dc_date: {
        required: true
      },
      suppliers_ref: {
        required: true
      },
      registered_address: {
        required: true
      },
      e_way_number: {
        required: true
      },
      gst_number: {
        required: true
      },
      dispatch_document_no: {
        required: true
      },
      destination: {
        required: true
      },
      site_address: {
        required: true
      },
      dispatch_through: {
        required: true
      },
      terms_of_delivery: {
        required: true
      },
      "bom_dc_stock[]": {
        required: true
      },
      "bom_good_condition[]": {
        required: true
      },
      "bom_bad_condition[]": {
        required: true
      },
    },
    messages: {
      project_id: {
        required: "Please select a project."
      },
      vendor_category_id: {
        required: "Please select a vendor category."
      },
      vendor_id: {
        required: "Please select a vendor."
      },
      work_order_on: {
        required: "The work order date is required."
      },
      dc_date: {
        required: "Please enter the delivery challan date."
      },
      suppliers_ref: {
        required: "The supplier's reference is required."
      },
      registered_address: {
        required: "Please enter the registered address."
      },
      buyer_order_ref: {
        required: "Please provide the buyer order reference."
      },
      e_way_number: {
        required: "Please enter the e-way number."
      },
      gst_number: {
        required: "Please provide the GST number."
      },
      dispatch_document_no: {
        required: "The dispatch document number is required."
      },
      destination: {
        required: "Please specify the destination."
      },
      site_address: {
        required: "Please enter the site address."
      },
      dispatch_through: {
        required: "Please specify the dispatch method."
      },
      terms_of_delivery: {
        required: "Please enter the terms of delivery."
      },
      "bom_dc_stock[]": {
        required: "Please enter the BOM DC stock quantity."
      },
      "bom_good_condition[]": {
        required: "Please enter the quantity in good condition."
      },
      "bom_bad_condition[]": {
        required: "Please enter the quantity in bad condition."
      }
    },
    errorPlacement: function(error, element) {
      error.insertAfter(element);
    },
    submitHandler: function(form) {
      var formData = new FormData(form);
      var po_number = btoa($("#po_number_edit").val());
      $.ajax({
        url: "update_vendor_delivery_challan_data",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
         
          var res = JSON.parse(response);
          $(".alert-container").removeClass("hide");
          if(res.success == 1) {
           
            $(".alert-container").html('<div class="alert modify alert-success">' + res.messages + '</div>');
            setTimeout(function() {
              $(".alert-container").addClass("hide");
              $(".alert-container").html('');
              window.location.href = "vendor_delivery_challan";
            }, 1000);
          } else {
            $(".alert-container").html('<div class="alert modify alert-danger">' + res.messages + '</div>');
           
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error: ' + textStatus, errorThrown);
        }
      });

    }
  });
  $("#vendor_delivery_challan_form").validate({
    rules: {
      project_id: {
        required: true
      },
      vendor_category_id: {
        required: true
      },
      vendor_id: {
        required: true
      },
      work_order_on: {
        required: true
      },
      dc_date: {
        required: true
      },
      
      registered_address: {
        required: true
      },
      e_way_number: {
        required: true
      },
      gst_number: {
        required: true
      },
      dispatch_document_no: {
        required: true
      },
      destination: {
        required: true
      },
      site_address: {
        required: true
      },
      dispatch_through: {
        required: true
      },
      terms_of_delivery: {
        required: true
      },
      attachement: {
        required: true
      },
      "bom_dc_stock[]": {
        required: true
      },
      "bom_good_condition[]": {
        required: true
      },
      "bom_bad_condition[]": {
        required: true
      },
     
    },
    messages: {
      project_id: {
        required: "Please select a project."
      },
      vendor_category_id: {
        required: "Please select a vendor category."
      },
      vendor_id: {
        required: "Please select a vendor."
      },
      work_order_on: {
        required: "The work order date is required."
      },
      dc_date: {
        required: "Please enter the delivery challan date."
      },
      attachement: {
        required: "Please Provide copy of Vendor DC or Eway Challan Number."
      },
      registered_address: {
        required: "Please enter the registered address."
      },
      buyer_order_ref: {
        required: "Please provide the buyer order reference."
      },
      e_way_number: {
        required: "Please enter the e-way number."
      },
      gst_number: {
        required: "Please provide the GST number."
      },
      dispatch_document_no: {
        required: "The dispatch document number is required."
      },
      destination: {
        required: "Please specify the destination."
      },
      site_address: {
        required: "Please enter the site address."
      },
      dispatch_through: {
        required: "Please specify the dispatch method."
      },
      terms_of_delivery: {
        required: "Please enter the terms of delivery."
      },
      "bom_dc_stock[]": {
        required: "Please enter the BOM DC stock quantity."
      },
      "bom_good_condition[]": {
        required: "Please enter the quantity in good condition."
      },
      "bom_bad_condition[]": {
        required: "Please enter the quantity in bad condition."
      }
    },
    errorPlacement: function(error, element) {
      // error.insertAfter(element);
      if (element.attr("name") == "dc_date") {
        error.insertAfter(element.closest('.input-group'));
    } else {
        error.insertAfter(element);
    }
    },
    submitHandler: function(form) {
      var formData = new FormData(form);
      var remaining_amount = calculateRemainingAmount();
    //   alert(remaining_amount);
    //   return;
      if(remaining_amount >= 0){
          $.ajax({
        url: "save_vendor_delivery_challan_data",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          var res = JSON.parse(response);
          $(".alert-container").removeClass("hide");
          if(res.success == 1) {
            $(".alert-container").html('<div class="alert modify alert-success">' + res.messages + '</div>');
            setTimeout(function() {
              $(".alert-container").addClass("hide");
              $(".alert-container").html('');
              window.location.href = "vendor_delivery_challan";
            }, 3000);
         
             
            
          } else {
            $(".alert-container").html('<div class="alert modify alert-danger">' + res.messages + '</div>');
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error: ' + textStatus, errorThrown);
        }
      }); 
      }else{
           $(".alert-container").removeClass("hide");
           $(".alert-container").html('<div class="alert modify alert-danger">Advance amount must be less than the VDC total amount. Please increase the quantity.</div>');
            setTimeout(function() {
              $(".alert-container").addClass("hide");
              $(".alert-container").html('');
            
            }, 3000);
      }
     

    }
  });
  $('#vendor_dc_list tbody').on('click','.openview', function () {

    $(this).text(function(i, text){
      return text === "CLOSE" ? "VIEW" : "CLOSE";
    });

    var transaction_id = $(this).attr('data-id');


    var project_id = $(this).attr('data-project_id');
    var boq_code = $(this).attr('data-boq_code');
    var transaction_type = $(this).attr('data-type');
    var status_txt = $(this).attr('data-status');

    var filter = 'original';

    var tr = $(this).closest('tr');
    var row = vendor_dc_list.row(tr);
    // console.log(table_bom);

    if (row.child.isShown()) {
      row.child.hide();
      tr.removeClass('shown');
    }else{
      var divwidth = $("#bomtranslist").width();
      var divminwidth = divwidth - 20;
      var filterhtml='';
      var headtxt='';
      download_title = 'BOM - Waiting for Approval';

      if(transaction_type == 'bom_upload'){
        download_title = 'Waiting for Approval (BOM Upload)';
      } else if (transaction_type == 'purchase_order') {
        download_title = 'Purchase Order';
      }

      var actionhtml='';
      var actionhtmlfooter='';

      var html = '<div class="portlet-body form" id="displayed'+boq_code+'">'
      +'<div class="displayFlx" style="margin-bottom: 15px;display:flex;">'
      +filterhtml
      +'<div class="col-md" id="calculatedfiler'+boq_code+'"></div>'
      +'</div>'
      +'<div id="originalpbomviewdiv'+boq_code+'"><div class="table-responsive">'
      +'<table width="100%" id="originalpbomview'+boq_code+'" class="table table-striped table-bordered table-hover" style="text-align: left;">'
      +'<thead style="background:#26a69a;color:#fff;font-weight:400;">'
      +'<tr>'
      +'<th scope="col" style="vertical-align: top;">Sr.no</th>'
      +'<th scope="col" style="vertical-align: top;">BOM Sr. No</th>'
      +'<th scope="col" style="vertical-align: top;">HNS Code</th>'
      +'<th scope="col" style="vertical-align: top;">Item Name</th>'
      +'<th scope="col" style="vertical-align: top;">Make</th>'
      +'<th scope="col" style="vertical-align: top;">Model</th>'
      +'<th scope="col" style="vertical-align: top;">Unit</th>'
      +'<th scope="col" style="vertical-align: top;text-align:right;">Quantity</th>'
      +'<th scope="col" style="vertical-align: top;text-align:right;">Rate Basic</th>'
      +'<th scope="col" style="vertical-align: top;text-align:right;">GST (%)</th>'
      +'<th scope="col" style="vertical-align: top;text-align:right;">Amount</th>'
      +'<th scope="col" style="vertical-align: top;text-align:right;">Status</th>'
      +actionhtml
      +'</tr>'
      +'</thead>'
      +'<tbody></tbody>'
      +'</table></div></div>';
      row.child(html).show();
      tr.addClass('shown');
      $('.dt-hasChild').next().css('background','#f5f5f5');
      $('.dt-hasChild').next().css('box-shadow','inset 0 0 0 9999px rgba(0, 0, 0, 0.075)');

      var table2 = $('#originalpbomview'+boq_code).DataTable({
        "dom": 'Bfrtip',
        scrollY: 400,
        scrollX: true,
        scroller: true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
          var currentPage = Math.floor(iDisplayIndexFull / recordsPerPage) + 1; // Calculate the current page
          var indexOnPage = iDisplayIndexFull % recordsPerPage; // Calculate the index on the current page
          var serialNumber = (currentPage - 1) * recordsPerPage + indexOnPage + 1;

          $("td:eq(0)", nRow).text(serialNumber); // Update the first cell content
          aData[0] = serialNumber; // Update the underlying data
        },
        fixedHeader: {
          header: true,
          footer: true
        },
        "lengthMenu": [
          [25, 50, 75, 100, 125,150, -1],
          [ '25 rows', '50 rows', '75 rows',  '100 rows',  '125 rows',  '150 rows', 'Show all' ]
        ],
        "buttons": [
          'pageLength',
          {
            "extend": 'copy',
            "title": download_title,
            "footer": true
          },
          {
            "extend": 'excel',
            "title": download_title,
            "footer": true,
            customize: function(xlsx) {
              var sheet = xlsx.xl.worksheets['sheet1.xml'];
              $('row c[r^="C"]', sheet).each( function () {
                $(this).attr( 's', '55' );
              });
            },
          },
          {
            "extend": 'pdf',
            "title": download_title,
            "footer": true
          },
          {
            "extend": 'print',
            "title": download_title,
            "footer": true
          }
        ],

        "bAutoWidth": false,
        "bDestroy" : true,
        "paging": true,
        "iDisplayLength": 25,
        "deferRender": true,
        "responsive": true,
        "processing": true,
        "serverSide": false,
        "order": [[1, 'asc']],
        "ajax": {
          "url": base_url+"project_bom_trans_list_display",
          "type": "POST",
          "data":{project_id:project_id,filter:filter,transaction_id:transaction_id,transaction_type:transaction_type,boq_code:boq_code,status_txt:status_txt}
        },

        "columnDefs": [{
          "targets": [0,3,4,5],
          "orderable": false
        },
        {
          "targets": [6,7,8,9],
          "orderable": false,
          "className": "text-right"
        }],
      });
      new $.fn.dataTable.FixedHeader( table2 );
    }
  });

  $(document).on('click','.editRecordPO', function () {

    var vdc_id = $(this).attr("rel-po-id");
    var project_id = $(this).attr("data-project-id");
    $('#project_id').val(project_id)
    // alert("ok - editRecordVdc");
    // alert(project_id);
    $.ajax({
      url: "get_update_vendor_delivery_challan_data",
      type: 'POST',
      data: {vdc_id:vdc_id,project_id:project_id},
      success: function(response) {
        // console.log(response);
        var res = JSON.parse(response);
        $("#transaction_id").val(res.vdc_data.transaction_id);
        $("#vdc_id").val(res.vdc_id);
        $("#bp_code_edit").val(res.bp_code);
        $("#category_name_edit").val(res.category_name);
        $("#vendor_name_edit").val(res.vendor_name);
        $("#work_order_on_edit").val(res.work_order_on);
        $('#dc_date_edit').datepicker('setDate', res.vdc_data.dc_date);
        $("#suppliers_ref_edit").val(res.suppliers_ref);
        $("#registered_address_edit").val(res.registered_address);
        $("#po_number_edit").val(res.po_number);
        $('#po_date_edit').datepicker('setDate', res.vdc_data.po_date);
        $("#e_way_number_edit").val(res.e_way_number);
        $("#gst_number_edit").val(res.gst_number);
        $("#dispatch_document_no_edit").val(res.dispatch_document_no);
        $("#site_address_edit").val(res.site_address);
        $("#dispatch_through_edit").val(res.dispatch_through);
        $("#terms_of_delivery_edit").val(res.terms_of_delivery);
        $("#hidden_attachement").val(res.attachement);
        $("#bomindentitmdisplay_edit tbody").html(res.po_items_html)
        $("#vendor_delivery_challan_update_form").show();
        $("#vendor_delivery_challan_form").hide();
        $('.vdc_form_data').css("display", "");

        if (res.attachement != "") {
          var downloadLink = `<a href="${base_url}uploads/vendor_delivery_challan/${res.attachement}" download>Download</a>`;
          $('.download_attachement').append(downloadLink);
      }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('Error: ' + textStatus, errorThrown);
      }
    });
  });
  $(document).on('click','.deleteRecordVdc ', function () {

    var vdc_id = $(this).attr("rel-po-id");
    var project_id = $(this).attr("data-project-id");
    var transaction_id = $(this).attr("data-transaction-id");
    $('#project_id').val(project_id)
    // alert("ok - editRecordVdc");
    // alert(project_id);
    $.ajax({
      url: "delete_merge_vdc_data",
      type: 'POST',
      data: {vdc_id:vdc_id,project_id:project_id,transaction_id:transaction_id},
      success: function(response) {
       
        var res = JSON.parse(response);
        $(".alert-container").removeClass("hide");
        if(res.success == 1) {
               
          $(".alert-container").html('<div class="alert modify alert-success">' + res.messages + '</div>');
          
          setTimeout(function() {
            $(".alert-container").addClass("hide");
            $(".alert-container").html('');
            window.location.href = "vendor_delivery_challan"  ;
          }, 3000);
         
      } else {
           
          $(".alert-container").html('<div class="alert modify alert-danger">' + res.messages + '</div>');
        }
       
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('Error: ' + textStatus, errorThrown);
      }
    });
  });

  $(document).on("click", ".download-vdc-excel", function() {
      var project_id = $(this).data("project_id");
      var boq_code = $(this).data("boq_code");
      var type = $(this).data("type");
      var status = $(this).data("status");
      var transaction_id = $(this).data("transaction_id");

      $.ajax({
          url: base_url + 'get_vdc_bom_detail_for_excel',
          type: 'POST',
          dataType: 'json',
          data: {
              project_id: project_id,
              boq_code: boq_code,
              transaction_type: type,
              status: status,
              transaction_id: transaction_id
          },
          success: function(response) {
              var bom_data = response.bom_data;
              var total_dc_qty = response.total_dc_qty;
              var total_bom_item = bom_data.length;
              var po_number = bom_data[0].po_number;
              var proforma_no = bom_data[0].proforma_no;
              var invoice_date = bom_data[0].invoice_date;
              var tnc = bom_data[0].terms_and_condition;
              var vendor_data = response.vendor_data;
              var address = vendor_data.reg_house_building_no + " " + vendor_data.reg_street + " " + vendor_data.reg_city_post_code + " " + vendor_data.reg_state;
              var gst_number = vendor_data.gst_registration_no;
              var fAmount = response.fAmount;
              var fcgst_amount = response.fcgst_amount;
              var fsgst_amount = response.fsgst_amount;
              var figst_amount = response.figst_amount;
              var ftotal_amount = response.ftotal_amount;
              var project_data = response.project_data;
              var project_name = response.project_data.bp_code;

              var bom_data_array = [];
              var count = 1;
              bom_data.forEach(function(item) {
                  var row = [
                      count,
                      item.item_description,
                      item.bom_code,
                      item.hsn_sac_code,
                      item.make,
                      item.model,
                      item.unit,
                      item.good_condition_qty
                  ];
                  bom_data_array.push(row);
                  count++;
              });

              const workbook = new ExcelJS.Workbook();
              const worksheet = workbook.addWorksheet('Sheet1');

              var ws_data = [
                  ["Delivery Challan", ""],
                  [""],
                  ["", "Prudent EPC Pvt Ltd", "Delivery Challan Date", "Delivery Challan No", "", "", "", "", "", "", "", "", "", ""],
                  ["", "91/B, Opp. Vishal Tower 2,Kamgar Nagar, Kurla East, Mumbai - 400 024 ", bom_data[0]['dc_date'], bom_data[0]['vdc_number'], "", "", "", "", "", "", "", "", "", ""],
                  ["", "", "", "", "", "", "", "", "", "", "", "", "", ""],
                  ["", "Site Address", "BP Code", project_name, "", "", "", "", "", "", "", "", "", ""],
                  ["", bom_data[0]['site_address'], "Location", bom_data[0]['registered_address'], "", "", "", "", "", "", "", "", "", ""],
                  ["", "", "Vendor Invoice No", bom_data[0]['suppliers_ref'], "", "", "", "", "", "", "", "", "", ""],
                  ["", "", "Vendor DC No", bom_data[0]['dispatch_document_no'], "", "", "", "", "", "", "", "", "", ""],
                  ["", "", "", "", "", "", "", "", "", "", "", "", "", ""],
                  ["Sr. No.", "Item Description", "BOM Code", "HSN/SAC Code", "Make", "Model", "Unit", "Qty"]
              ];

              var authorised_detail = [
                  [""],
                  ["", "Received the above Items in full Quantity : " + total_dc_qty, "", "", "", "", "", "", ""],
                  ["", "Received Name : " + bom_data[0]['recevier_name'], "", "", "", "", "", "", ""]
              ];

              var terms_n_condition = [
                  [""],
                  ["Compiled & Suggested by"],
                  ["Corporate Office  91/B, S. G. Barve Marg, Kamgar Nagar, Kurla(East), Mumbai-400024 Land Line: +91 22 2522 0676, E: sales@prudentepc.com, accounts@prudentepc.com www.prudentepc.com, CIN :U72900MH2019PTC323399"]
              ];

              ws_data = ws_data.concat(bom_data_array);
              ws_data = ws_data.concat(authorised_detail);
              ws_data = ws_data.concat(terms_n_condition);
              ws_data.forEach(row => worksheet.addRow(row));

              const boldFont = { bold: true };

              // Set font for specific cells
              worksheet.getCell(1, 1).font = boldFont;
              worksheet.getCell(3, 2).font = boldFont;
              worksheet.getCell(3, 3).font = boldFont;
              worksheet.getCell(3, 4).font = boldFont;
              worksheet.getCell(6, 2).font = boldFont;
              worksheet.getCell(6, 3).font = boldFont;
              worksheet.getCell(7, 3).font = boldFont;
              worksheet.getCell(8, 3).font = boldFont;
              worksheet.getCell(9, 3).font = boldFont;
              worksheet.getRow(11).font = boldFont;

              // Set column widths
              worksheet.columns = [
                  { width: 10 },
                  { width: 85 },
                  { width: 20 },
                  { width: 20 },
                  { width: 20 },
                  { width: 20 }
              ];

              // Merge and align cells
              worksheet.mergeCells(1, 1, 2, 8);
              worksheet.getCell(1, 8).alignment = { vertical: 'middle', horizontal: 'center' };
              worksheet.getCell(1, 1).font = { size: 18 };

              const borderStyle = {
                  top: { style: 'thin', color: { argb: '000000' } },
                  left: { style: 'thin', color: { argb: '000000' } },
                  bottom: { style: 'thin', color: { argb: '000000' } },
                  right: { style: 'thin', color: { argb: '000000' } }
              };

              const centerAlignment = { vertical: 'middle', horizontal: 'center' };

              // Apply border and alignment only to BOM data items
              worksheet.eachRow({ includeEmpty: true }, (row, rowNumber) => {
                  if (rowNumber > 10 && rowNumber <= 11 + total_bom_item) { // Apply to BOM data rows only
                      row.eachCell({ includeEmpty: true }, (cell) => {
                          cell.border = borderStyle;
                          cell.alignment = centerAlignment;
                      });
                  }
              });

              const grand_total_row_num = 12 + total_bom_item;
              const tnc_row = grand_total_row_num + 4;
              const tnc_row_add_one = grand_total_row_num + 5;

              worksheet.getCell(grand_total_row_num+1,2).font = boldFont;
              worksheet.getCell(grand_total_row_num+2,2).font = boldFont;
              worksheet.getRow(tnc_row).font = boldFont;
              worksheet.getRow(tnc_row_add_one).font = boldFont;

              const tnc_text = worksheet.getCell(tnc_row + 1, 1);
              const tnc_row_add_one_text = worksheet.getCell(tnc_row_add_one + 1, 1);

              tnc_text.alignment = { wrapText: true };
              tnc_row_add_one_text.alignment = { wrapText: true };

              worksheet.mergeCells(tnc_row, 1, tnc_row, 8);
              worksheet.mergeCells(tnc_row_add_one, 1, tnc_row_add_one+1, 8);
              worksheet.getCell(tnc_row, 1).alignment = { vertical: 'middle', horizontal: 'center' };
              worksheet.getCell(tnc_row_add_one, 1).alignment = { vertical: 'middle', horizontal: 'center' };

              workbook.xlsx.writeBuffer().then(function(buffer) {
                  const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                  saveAs(blob, 'vendor_delivery_challan.xlsx');
              });
          },
          error: function(jqXHR, textStatus, errorThrown) {
              console.error('Error fetching vendor list:', textStatus, errorThrown);
          }
      });
  });

 
      
          $('#po_number_select').on('change', function() {
            $("#checkbox-container").hide()
              var selectedPoNumber = $(this).val(); 
              console.log("Selected PO Number: " + selectedPoNumber);
              var $checkboxContainer = $('#checkbox-container');
              $.ajax({
                  url: "get_dc_details_by_po_number",  
                  type: 'POST',  
                  data: { po_number: selectedPoNumber },  
                  success: function(response) {
                      var jsonData = JSON.parse(response);
                      $(".vdc_merege_save").prop('disabled', true);
                      if(Array.isArray(jsonData.dc_details) && jsonData.dc_details.length > 0){
                        $(".vdc_merege_save").prop('disabled', false);
                        $(".merging_data").css("display","")
                        $checkboxContainer.empty(); 
                        var uniqueVdcNumbers = new Set();
        
                        $.each(jsonData.dc_details, function(index, item) {
                            if (!uniqueVdcNumbers.has(item.vdc_number)) {
                                uniqueVdcNumbers.add(item.vdc_number);
                                var uniqueId = 'checkbox-' + index;
                                var checkboxHtml = `
                                    <div class="col-xs-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input vdc-number" type="checkbox" id="${uniqueId}" value="${item.vdc_id}" />
                                            <label class="form-check-label" for="${uniqueId}">${item.vdc_number}</label>
                                        </div>
                                    </div>
                                `;
                                $checkboxContainer.append(checkboxHtml);
                            }
                        });
      
                      var $tableBody = $('#table-body');
                      $tableBody.empty(); 
                        console.log(jsonData.dc_details);
                        
                      $.each(jsonData.dc_details, function(index, item) {
                          var rowHtml = `
                              <tr>
                                  <th scope="row">${index + 1}</th>
                                  
                                  <td>${item.bom_code}</td>
                                  <td>${item.item_description}</td>
                                  <td>${item.dc_qty}</td>
                                  <td>${item.basic_rate}</td>
                                  <td>${item.gst}</td>
                                 <td>${parseFloat(item.total_amount).toFixed(2)}</td>
l
                              </tr>
                          `;
                          $tableBody.append(rowHtml);
                      });
                      }else{
                        $checkboxContainer.empty(); 
                        $(".merging_data").css("display","none");
                        if( $(".vdc-merege-body .alert-container-msg").length == 0){
                          $(".vdc-merege-body").prepend('<div class="alert-container-msg"><div class="alert modify alert-danger">Vendor Delivery Challans Data not available for merging.</div></div>');
                        //   setTimeout(function(){
                        //     $(".vdc-merege-body .alert-container-msg").remove();
                        //   },3000)
                        } 
                      }
      
                     
                      
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                      console.error('Error: ' + textStatus, errorThrown);
                  }
              });
          });
   
      

      $("#vendor_delivery_challan_merege_form").submit(function(){
     
        // var marge_vdc = [];
        // $('#vendor_delivery_challan_merege_form input:checkbox  ').each(function() 
        // {    
        //     if($(this).is(':checked')){
        //       marge_vdc.push($(this).val());
        //     }
        // });
        // if(marge_vdc.length > 1){

          $.ajax({
            url: "merege_vdc_for_grn",  
            type: 'POST',  
            data: { marge_vdc: marge_vdc },  
            success: function(response) {
              var res = JSON.parse(response);
           
              if(res.success == 1) {
                $(".vdc-merege-body").prepend('<div class="alert-container-msg"><div class="alert modify alert-success">' + res.messages + '</div></div>');
                setTimeout(function(){
                  $(".vdc-merege-body .alert-container-msg").remove();
                  window.location.href = "vendor_delivery_challan"  ;
                },3000)
               
              } else {
             
                $(".vdc-merege-body").prepend('<div class="alert-container-msg"><div class="alert modify alert-danger">' + res.messages + '</div></div>');
              }
            }
          });
        // }else if(marge_vdc.length > 0){
        //   if( $(".vdc-merege-body .alert-container-msg").length == 0){
        //     $(".vdc-merege-body").prepend('<div class="alert-container-msg"><div class="alert modify alert-danger">Please select at least two Vendor Delivery Challans to merge.</div></div>');
        //     setTimeout(function(){
        //       $(".vdc-merege-body .alert-container-msg").remove();
        //     },3000)
        //   } 
        // }else{
        //   if( $(".vdc-merege-body .alert-container-msg").length == 0){
        //     $(".vdc-merege-body").prepend('<div class="alert-container-msg"><div class="alert modify alert-danger">Please select Vendor Delivery Challan</div></div>');
        //     setTimeout(function(){
        //       $(".vdc-merege-body .alert-container-msg").remove();
        //     },3000)
        //   } 
        // }
      });
});



function calculateRemainingAmount() {
    let totalAdvancePayment = parseFloat($("#total_advance_payment").val()) || 0;
    let sumAmount = 0;

    $(".amount").each(function () {
        sumAmount += parseFloat($(this).val()) || 0;
    });
    // alert(sumAmount);
    // alert(totalAdvancePayment);
   
    let remainingAmount = sumAmount - totalAdvancePayment;

    return remainingAmount;
}