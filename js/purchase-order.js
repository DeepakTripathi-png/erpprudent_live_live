$( document ).ready(function() {
  var project_id = $('#project_id').val().trim();
  var base_url = $('#base_url').val().trim();
  var download_title = 'PUrchase Order';
  var recordsPerPage = 10;
  get_all_category()
  // console.log(type);
  // alert(type);

$('input[name="advance_amount"]').on('input', function() {
         var maxAmount = 100; // Maximum allowed amount
         var enteredAmount = parseFloat($(this).val()) || 0;

         // Check if the entered amount exceeds the maximum allowed
         if (enteredAmount > maxAmount) {
             $(this).val(maxAmount); // Reset the value to the maximum allowed
         }
     });
       $('.onlyNumericInput').on('keypress', function(event) {
    var charCode = (event.which) ? event.which : event.keyCode;
    // Allow only digits (0-9) and some specific control keys
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      event.preventDefault();
    }
  });


  var purchaseOrderlist = $('#purchaseOrderlist').DataTable({
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
      "sEmptyTable": "No Purchase Order Found!"
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
      "url": base_url+"get_purchase_order_list?project_id="+$('#project_id').val()+"&type="+page_type,
      "type": "GET",
      "data":{project_id:project_id}
    },

  });

  function get_all_category(){
    $('#vCategoryLaoding').html('Please wait Category list loading...');
    $.ajax({
      url: base_url + 'get_all_category',
      type: 'POST',
      dataType: 'json',
    }).done(function(data) {
      $('#vCategoryLaoding').html('');
      $('.allVendorCategory').select2({
        data: data.data.map(function(item) {
          return { id: item.category_id, text: item.category_name };
        }),
        placeholder: 'search',
        multiple: true,
      });

    }).fail(function(jqXHR, textStatus, errorThrown) {
      console.error('Error fetching Category list:', textStatus, errorThrown);
      $('#vCategoryLaoding').html('Failed to load vendors.');
    });
  }


  $(document).on('change', '#project_id', function() {
    var project_id = $(this).val();
    // console.log(project_id);
    // var billable = $('#billable').val();
    if(project_id){
      $('#displayBomIndentItems,#bomIndentRemark').show();
      var table = $('#bomindentitmdisplay').DataTable({
        "bAutoWidth": false,
        "oLanguage": {
          "sEmptyTable": "No BOM Items Available to Send for Approval"
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
          "url": base_url+"get_bom_po_item_by_project",
          "type": "POST",
          "data":{project_id:project_id},
          'dataSrc':function(result) {
            //  console.log(result.boq_without_bom);
            if(result.po_approval_pending && result.po_approval_pending!='' && result.po_approval_pending.length >= 0) {
              const bomCode = result.po_approval_pending.join(',')
              // console.log(boqCode);
              $('#invaliderrorid').html('Purchase Order Quantity Pending for BOM Sr No ('+bomCode+' )');
            } else {
              $('#invaliderrorid').html('');
            }
            return result.data;
          },
        },
        "columnDefs": [{
          "targets": [0],
          "orderable": false
        }]
      });
      var url = base_url + "get_po_list?type="+page_type;
      // url += "?project_id=" + project_id;
      purchaseOrderlist.ajax.url(url).load();
    }

  });


  $(document).on('click','.editRecordIndent', function(){
    var project_id = $(this).attr('data-project-id');
    var url = $(this).attr('rev');
    var id = $(this).attr('rel');
    $.ajax({
      url : completeURL(url),
      type : 'POST',
      dataType : 'html',
      data:{project_id:project_id,id:id},
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

  $(document).on('input', ".js-requires-po-qty", function() {
    var available_qty = parseFloat($(this).parents("tr").find(".po-avilable-stock").val());
    var value = parseFloat($(this).val());
    if(value > available_qty){
      $(this).val(parseFloat(available_qty).toFixed(2));
      value = available_qty;
    }
    const $row = $(this).closest('tr');
    const reqQty = parseFloat(value) || 0;
    const rate = parseFloat($row.find('[name="rate_basic[]"]').val()) || 0;
    const gst = parseFloat($row.find('[name="bom_gst[]"]').val()) || 0;
    const amount = reqQty * rate * (1 + gst / 100);
    $row.find('[name="amount[]"]').val(amount.toFixed(2));
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
    const qty = parseFloat($row.find('[name="bom_req_stock[]"]').val()) || 0;
    const gst = parseFloat($row.find('[name="bom_gst[]"]').val()) || 0;
    const amount = qty * rate * (1 + gst / 100);
    $row.find('[name="amount[]"]').val(amount.toFixed(2));
  });


  $(".vendor-details").hide()
  $("#displayPOItems").hide();
  $("#displayPORemark").hide();
  $("#displayPOAttachment").hide();



  $(document).on('change', '#category', function() {
    var category = $(this).val();
    $('#vendorLaoding').html('Please wait Vendor list loading...');
    $.ajax({
      url: base_url + 'get_all_vendor_list',
      type: 'POST',
      dataType: 'json',
      data: { category: category },
    }).done(function(data) {
      $('#vendorLaoding').html('');

      $('.allVendor').select2({
        data: data.map(function(item) {
          return { id: item.id, text: item.vendor,disabled: item.disabled || false }; // Adjust to match your data structure
        }),
        placeholder: 'search',
        multiple: false,
      });
      // $(".vendor-details").show();
    }).fail(function(jqXHR, textStatus, errorThrown) {
      console.error('Error fetching vendor list:', textStatus, errorThrown);
      $('#vendorLaoding').html('Failed to load vendors.');
    });
  });



  $(document).on('change', '#vendor_id', function() {
    var vendor_id = $(this).val();
    $.ajax({
      url: base_url + 'get_vendor_detail',
      type: 'POST',
      dataType: 'json',
      data: { vendor_id: vendor_id },
    }).done(function(response) {
      console.log(response);
      var data = response.data;
      var po_no = response.po_no;
      var address = data.reg_house_building_no + " " + data.reg_street + " "+ data.reg_city_post_code + " "+  data.reg_state;
      $("#address").val(address);
      $("#gst_number").val(data.gst_registration_no);
      $("#po_number").val(po_no);
      $(".vendor-details").show();
      $("#displayPOItems").show();
      $("#displayPORemark").show();
      $("#displayPOAttachment").show();
    }).fail(function(jqXHR, textStatus, errorThrown) {
      console.error('Error fetching vendor list:', textStatus, errorThrown);
    });
  });

  // download po
//   $(document).on("click",".download-po",function(){

//     var project_id = $(this).data("project_id");
//     var boq_code = $(this).data("boq_code");
//     var type = $(this).data("type");
//     var status = $(this).data("status");
//     var transaction_id = $(this).data("transaction_id");

//     $.ajax({
//       url: base_url + 'get_po_bom_detail',
//       type: 'POST',
//       dataType: 'json',
//       data: {
//         project_id: project_id,
//         boq_code: boq_code,
//         transaction_type: type,
//         status: status,
//         transaction_id: transaction_id
//       },
//       success: function(response) {

//         var bom_data = response.bom_data;
//         console.log(bom_data);
//         var total_bom_item = bom_data.length;
//         var po_number = bom_data[0].po_number;
//         var po_date = bom_data[0].po_date;
//           var tnc = bom_data[0].terms_and_condition;
//         //   alert(tnc);
        
//         var vendor_data=   response.vendor_data;
//         console.log(response.vendor_data.gst_registration_no)
//         var address = vendor_data.reg_house_building_no + " " + vendor_data.reg_street + " "+ vendor_data.reg_city_post_code + " "+  vendor_data.reg_state;
//         var gst_number = vendor_data.gst_registration_no;
//         var fAmount = response.fAmount;
//         var fcgst_amount = response.fcgst_amount;
//         var fsgst_amount = response.fsgst_amount;
//         var figst_amount = response.figst_amount;
//         var ftotal_amount = response.ftotal_amount;
//         var project_name = response.project_data.bp_code;


//         var bom_data_array = [];
//         var count = 1;
//         bom_data.forEach(function(item) {
//           var row = [
//             count,
//             item.item_description,
//             item.hsn_sac_code,
//             item.make,
//             item.model,
//             item.unit,
//             item.indent_quantity,
//             item.rate_basic,
//             item.amount,
//             item.cgst,
//             item.sgst,
//             item.igst,
//             item.cgst_amount,
//             item.sgst_amount,
//             item.igst_amount,
//             item.total_amount
//           ];
//           bom_data_array.push(row);
//           count++;
//         });
//         const workbook = new ExcelJS.Workbook();
//         const worksheet = workbook.addWorksheet('Sheet1');
//         var ws_data = [
//           ["", "Purchase Order No.", po_number,"","Date",po_date,"","", "","","", "","","", ""],
//           ["","", "","","", "","","", "","","", ""], // Header row
//           ["","To", "","","", "","","", "","","", "","","", ""],
//           ["","Vender Name", vendor_data.name_of_company, "","","", "","","", "","","", "",],
//           ["","Address", address, "","","", "","","", "","","", ""],
//           ["", "", ""],
//           ["","GSTN NO:",gst_number, ""],
//           ["","Project Name", project_name, ""],
//           [""],
//           ["","Dear Sir"],
//           ["","We are pleased to place purchase Order for the following Items.The details are as follows."],
//           [""],
//           ["BOM Sr. No.","Item Description","HSN/SAC Code","Make","Model","Unit","Qty","Rate","Amount","Rate","","","Amount","","","Total"],
//           ["","","","","","","","","","CGST","SGST","IGST","CGST","SGST","IGST","Total"],


//         ];
//         var final_amount =[
//           ["","Grand Total","","","","","","",fAmount,"","","",fcgst_amount,fsgst_amount,figst_amount,ftotal_amount],
//           ["","CGST","","","","","","",fcgst_amount,"","","","","","",""],
//           ["","SGST","","","","","","",fsgst_amount,"","","","","","",""],
//           ["","IGST","","","","","","",figst_amount,"","","","","","",""],
//           ["","Total With GST","","","","","","",ftotal_amount,"","","","","","",""],

//         ]
//         var terms_n_condition=[
//           [""],
//           ["","Terms And Condition"],
//           ["",tnc],
//         ]
//         ws_data = ws_data.concat(bom_data_array);
//         ws_data = ws_data.concat(final_amount);
//         ws_data = ws_data.concat(terms_n_condition);
//         // Add data to worksheet
//         ws_data.forEach(row => worksheet.addRow(row));

//         const boldFont = { bold: true };

//          // add bold for signle row cell
//          worksheet.getCell(1, 5).font = boldFont;
//          worksheet.getCell(1, 2).font = boldFont;
//          worksheet.getCell(3, 2).font = boldFont;
//          worksheet.getCell(4, 2).font = boldFont;
//          worksheet.getCell(5, 2).font = boldFont;
//          worksheet.getCell(6, 2).font = boldFont;
//          worksheet.getCell(7, 2).font = boldFont;
//          worksheet.getCell(8, 2).font = boldFont;
//          worksheet.getCell(9, 2).font = boldFont;
//          worksheet.getCell(11, 2).font = boldFont;
//          worksheet.getCell(12, 2).font = boldFont;

//          // Set column widths
//          worksheet.columns = [
//              { width: 11 }, // Width for the first column
//              { width: 85 }, // Width for the second column
//              { width: 15 }, // Width for the third column
//              { width: 10 }, // Width for the fourth column
//              { width: 10 }, // Width for the fifth column
//              // Add widths for remaining columns as needed
//          ];

//          // Define cell merges and align text to center
//          worksheet.mergeCells(13, 10, 13, 12); // Merge cells at row 12, columns 9 to 10
//          worksheet.mergeCells(13, 13, 13, 15); // Merge cells at row 12, columns 11 to 13

//          // Apply center alignment to merged cells
//          worksheet.getCell(13, 9).alignment = { vertical: 'middle', horizontal: 'center' };
//          worksheet.getCell(13, 11).alignment = { vertical: 'middle', horizontal: 'center' };

//         // Define border styles
//         const borderStyle1 = {
//           top: { style: 'thin', color: { argb: '0000' } },
//           left: { style: 'thin', color: { argb: '0000' } },
//           bottom: { style: 'thin', color: { argb: '0000' } },
//           right: { style: 'thin', color: { argb: '0000' } }
//       };

//       const borderStyle2 = {
//           top: { style: 'thin', color: { argb: '0000' } },
//           left: { style: 'thin', color: { argb: '0000' } },
//           bottom: { style: 'thin', color: { argb: '0000' } },
//           // right: { style: 'thin', color: { argb: '0000' } }
//       };

//       const borderStyle3 = {
//           top: { style: 'thin', color: { argb: '0000' } },
//           // left: { style: 'thin', color: { argb: '0000' } },
//           bottom: { style: 'thin', color: { argb: '0000' } },
//           right: { style: 'thin', color: { argb: '0000' } }
//       };
//       const borderStyle4 = {
//           top: { style: 'thin', color: { argb: '0000' } },
//           // left: { style: 'thin', color: { argb: '0000' } },
//           bottom: { style: 'thin', color: { argb: '0000' } },
//           // right: { style: 'thin', color: { argb: '0000' } }
//       };

//       const backgroundColor = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'a3b4fcb4' } };
//       const centerAlignment = { vertical: 'middle', horizontal: 'center' };
//       const fontColor = { color: { argb: 'FFFF0000' } }; // red color for font
//       const grand_total_row_num = 14+total_bom_item;
//       const leftAlignment = { vertical: 'left', horizontal: 'left' };
//         // Apply border style to all rows after the second row
//         worksheet.eachRow({ includeEmpty: true }, (row, rowNumber) => {
//             if (rowNumber > 12 && rowNumber < grand_total_row_num+6) { // Skip the first two rows (headers and the first data row)
//                 row.eachCell({ includeEmpty: true }, (cell) => {
//                     // Example: Apply a specific border style to column 5

//                     // for grand total roe backgroundColor
//                     if(grand_total_row_num+1 == rowNumber){
//                       if(cell.col > 3){
//                         cell.font = { ...boldFont, color: fontColor.color };
//                       }else{
//                         cell.font = boldFont;
//                       }
//                       cell.fill = backgroundColor;
//                     }
//                     // for grand total roe backgroundColor
//                     if(grand_total_row_num+2 == rowNumber || grand_total_row_num+3 == rowNumber){
//                       if(cell.col > 2){
//                         cell.font = { ...boldFont, color: fontColor.color };
//                       }else{
//                         cell.font = boldFont;
//                       }
//                     }
//                     if(grand_total_row_num+3 == rowNumber || grand_total_row_num+4 == rowNumber){
//                       if(cell.col > 3){
//                         cell.font = { ...boldFont, color: fontColor.color };
//                       }else{
//                         cell.font = boldFont;
//                       }
//                     }

//                     if(grand_total_row_num+5 == rowNumber ){
//                       cell.font = { ...boldFont};
//                       cell.fill = backgroundColor;
//                     }



//                     // for left alignment of item
//                     if(rowNumber > 13 && cell.col === 2){
//                       cell.alignment = leftAlignment;
//                     }else{
//                       cell.alignment = centerAlignment;
//                     }

//                     // for boder sip for marge column
//                     if(rowNumber == 13){
//                         cell.font = boldFont;
//                         if(cell.col === 10){
//                             cell.border = borderStyle2;
//                         }else if(cell.col === 11){
//                             cell.border = borderStyle3;
//                         }else if(cell.col === 12){
//                             cell.border = borderStyle2;
//                         }else if(cell.col === 13){
//                             cell.border = borderStyle4;
//                         }else if(cell.col === 14){
//                             cell.border = borderStyle3;
//                         }else{
//                             cell.border = borderStyle1;
//                         }

//                     }else{
//                         cell.border = borderStyle1;
//                     }



//                 });
//             }
//         });



//         // Export the workbook to a file
//         workbook.xlsx.writeBuffer().then(function(buffer) {
//             const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
//             saveAs(blob, 'purchase_order.xlsx');
//         });

//       },
//       error: function(jqXHR, textStatus, errorThrown) {
//         console.error('Error fetching vendor list:', textStatus, errorThrown);
//       }
//     });




//   })
  $(document).on("click",".download-po",function(){

    var project_id = $(this).data("project_id");
    var boq_code = $(this).data("boq_code");
    var type = $(this).data("type");
    var status = $(this).data("status");
    var transaction_id = $(this).data("transaction_id");

    $.ajax({
      url: base_url + 'get_po_bom_detail',
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
        var total_bom_item = bom_data.length;
        var po_number = bom_data[0].po_number;
        var po_date = bom_data[0].po_date;
        var cgst = bom_data[0].cgst;
        var sgst = bom_data[0].sgst;
        var igst = bom_data[0].igst;
          var tnc = bom_data[0].terms_and_condition;
        //   alert(tnc);

        var vendor_data=   response.vendor_data;
        var address = vendor_data.reg_house_building_no + " " + vendor_data.reg_street + " "+ vendor_data.reg_city_post_code + " "+  vendor_data.reg_state;
        var gst_number = vendor_data.gst_registration_no;
        var pan_number = vendor_data.pan_number;
        var fAmount = response.fAmount;
        var fcgst_amount = response.fcgst_amount;
        var fsgst_amount = response.fsgst_amount;
        var figst_amount = response.figst_amount;
        var ftotal_amount = response.ftotal_amount;
        var project_name = response.project_data.bp_code;
        var shipping_address = response.project_data.site_address;
        var billing_address = `Prudent EPC Pvt. Ltd.
  5th floor, 509 B wing, Golf
  Scappe, Sion Trombay, Road,
  Chembur, Mumbai -400071
  GST No- 27AAKCP4656L1Zs`;

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
            item.indent_quantity,
            item.rate_basic,
            item.amount,
            item.cgst,
            item.sgst,
            item.igst,
            item.cgst_amount,
            item.sgst_amount,
            item.igst_amount,
            item.total_amount
          ];
          bom_data_array.push(row);
          count++;
        });
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet('Sheet1');
        var ws_data = [
          ["", "Purchase Order No.", po_number,"","Date",po_date,"","", "","","", "","","", ""],
          ["","", "","","", "","","", "","","", ""], // Header row
          ["","To", "","","", "","","", "","","", "","","", ""],
          ["","Vender Name", vendor_data.name_of_company, "","","", "","","", "","","", "",],
          ["","Address", address, "","","", "","","", "","","", ""],
          ["","GSTN NO:",gst_number, ""],
          ["","PAN NO:",pan_number, ""],
          ["","Project Name", project_name, ""],
          [""],
          ["","Dear Sir"],
          ["","We are pleased to place purchase Order for the following Items.The details are as follows."],
          [""],
          ["Sr. No.","Item Description","BOM Code","HSN/SAC Code","Make","Model","Unit","Qty","Rate","Amount","Rate","","","Amount","","","Total"],
          ["","","","","","","","","","","CGST","SGST","IGST","CGST","SGST","IGST","Total"],


        ];
        var final_amount =[
          ["","Grand Total","","","","","","","",fAmount,"","","",fcgst_amount,fsgst_amount,figst_amount,ftotal_amount],
          ["","CGST"+"("+cgst+")","","","","","","","",fcgst_amount,"","","","","","",""],
          ["","SGST"+"("+sgst+")","","","","","","","",fsgst_amount,"","","","","","",""],
          ["","IGST"+"("+igst+")","","","","","","","",figst_amount,"","","","","","",""],
          ["","Total With GST","","","","","","","",ftotal_amount,"","","","","","",""],

        ]
        var terms_n_condition=[
          [""],
          ["","Terms And Condition"],
          ["",tnc],
        ]
        
        var address_details=[
          [""],
          ["","Bill To","","Ship To"],
          ["",billing_address,"",shipping_address],
        ]
        ws_data = ws_data.concat(bom_data_array);
        ws_data = ws_data.concat(final_amount);
        ws_data = ws_data.concat(terms_n_condition);
        ws_data = ws_data.concat(address_details);
        // Add data to worksheet
        ws_data.forEach(row => worksheet.addRow(row));

        const boldFont = { bold: true };

         // add bold for signle row cell
         worksheet.getCell(1, 5).font = boldFont;
         worksheet.getCell(1, 2).font = boldFont;
         worksheet.getCell(3, 2).font = boldFont;
         worksheet.getCell(4, 2).font = boldFont;
         worksheet.getCell(5, 2).font = boldFont;
         worksheet.getCell(6, 2).font = boldFont;
         worksheet.getCell(7, 2).font = boldFont;
         worksheet.getCell(8, 2).font = boldFont;
         worksheet.getCell(9, 2).font = boldFont;
         worksheet.getCell(11, 2).font = boldFont;
         worksheet.getCell(12, 2).font = boldFont;

         // Set column widths
         worksheet.columns = [
             { width: 11 }, // Width for the first column
             { width: 85 }, // Width for the second column
             { width: 15 }, // Width for the third column
             { width: 10 }, // Width for the fourth column
             { width: 10 }, // Width for the fifth column
             // Add widths for remaining columns as needed
         ];

         // Define cell merges and align text to center
         worksheet.mergeCells(13, 11, 13, 13); // Merge cells at row 12, columns 9 to 10
         worksheet.mergeCells(13, 14, 13, 16); // Merge cells at row 12, columns 11 to 13

         // Apply center alignment to merged cells
         worksheet.getCell(13, 9).alignment = { vertical: 'middle', horizontal: 'center' };
         worksheet.getCell(13, 11).alignment = { vertical: 'middle', horizontal: 'center' };

        // Define border styles
        const borderStyle1 = {
          top: { style: 'thin', color: { argb: '0000' } },
          left: { style: 'thin', color: { argb: '0000' } },
          bottom: { style: 'thin', color: { argb: '0000' } },
          right: { style: 'thin', color: { argb: '0000' } }
      };

      const borderStyle2 = {
          top: { style: 'thin', color: { argb: '0000' } },
          left: { style: 'thin', color: { argb: '0000' } },
          bottom: { style: 'thin', color: { argb: '0000' } },
          // right: { style: 'thin', color: { argb: '0000' } }
      };

      const borderStyle3 = {
          top: { style: 'thin', color: { argb: '0000' } },
          // left: { style: 'thin', color: { argb: '0000' } },
          bottom: { style: 'thin', color: { argb: '0000' } },
          right: { style: 'thin', color: { argb: '0000' } }
      };
      const borderStyle4 = {
          top: { style: 'thin', color: { argb: '0000' } },
          // left: { style: 'thin', color: { argb: '0000' } },
          bottom: { style: 'thin', color: { argb: '0000' } },
          // right: { style: 'thin', color: { argb: '0000' } }
      };

      const backgroundColor = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'a3b4fcb4' } };
      const centerAlignment = { vertical: 'middle', horizontal: 'center' };
      const fontColor = { color: { argb: 'FFFF0000' } }; // red color for font
      const grand_total_row_num = 14+total_bom_item;
      
      const  tnc_row = grand_total_row_num+7;
      worksheet.getRow(tnc_row).font = boldFont;
      const tnc_text = worksheet.getCell(tnc_row+1, 2);
      tnc_text.alignment = { wrapText: true };

      var  address_row = tnc_row+3;
      worksheet.getRow(address_row).font = boldFont;
      var billing_text = worksheet.getCell(address_row+1, 2);
      billing_text.alignment = { wrapText: true };
      var shipping_text = worksheet.getCell(address_row+1, 4);
      shipping_text.alignment = { wrapText: true };
      
      const leftAlignment = { vertical: 'left', horizontal: 'left' };
        // Apply border style to all rows after the second row
        worksheet.eachRow({ includeEmpty: true }, (row, rowNumber) => {
            if (rowNumber > 12 && rowNumber < grand_total_row_num+6) { // Skip the first two rows (headers and the first data row)
                row.eachCell({ includeEmpty: true }, (cell) => {
                    // Example: Apply a specific border style to column 5

                    // for grand total roe backgroundColor
                    if(grand_total_row_num+1 == rowNumber){
                      if(cell.col > 3){
                        cell.font = { ...boldFont, color: fontColor.color };
                      }else{
                        cell.font = boldFont;
                      }
                      cell.fill = backgroundColor;
                    }
                    // for grand total roe backgroundColor
                    if(grand_total_row_num+2 == rowNumber || grand_total_row_num+3 == rowNumber){
                      if(cell.col > 2){
                        cell.font = { ...boldFont, color: fontColor.color };
                      }else{
                        cell.font = boldFont;
                      }
                    }
                    if(grand_total_row_num+3 == rowNumber || grand_total_row_num+4 == rowNumber){
                      if(cell.col > 3){
                        cell.font = { ...boldFont, color: fontColor.color };
                      }else{
                        cell.font = boldFont;
                      }
                    }

                    if(grand_total_row_num+5 == rowNumber ){
                      cell.font = { ...boldFont};
                      cell.fill = backgroundColor;
                    }



                    // for left alignment of item
                    if(rowNumber > 13 && cell.col === 2){
                      cell.alignment = leftAlignment;
                    }else{
                      cell.alignment = centerAlignment;
                    }

                    // for boder sip for marge column
                    if(rowNumber == 13){
                        cell.font = boldFont;
                        if(cell.col === 10){
                            cell.border = borderStyle2;
                        }else if(cell.col === 11){
                            cell.border = borderStyle3;
                        }else if(cell.col === 12){
                            cell.border = borderStyle2;
                        }else if(cell.col === 13){
                            cell.border = borderStyle4;
                        }else if(cell.col === 14){
                            cell.border = borderStyle3;
                        }else{
                            cell.border = borderStyle1;
                        }

                    }else{
                        cell.border = borderStyle1;
                    }



                });
            }
        });



        // Export the workbook to a file
        workbook.xlsx.writeBuffer().then(function(buffer) {
            const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            saveAs(blob, 'purchase_order.xlsx');
        });

      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('Error fetching vendor list:', textStatus, errorThrown);
      }
    });

});


  $(document).on("click",".editRecordPO",function(){
    var po_id = $(this).attr("rel-po-id");
    var project_id = $(this).attr("data-project-id");
    if(project_id){
      var table = $('#Editbomindentitmdisplay').DataTable({
        "bAutoWidth": false,
        "oLanguage": {
          "sEmptyTable": "No BOM Items Available to Send for Approval"
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
          "url": base_url+"get_edit_bom_po_item_by_project",
          "type": "POST",
          "data":{ po_id: po_id,project_id:project_id },
          'dataSrc':function(result) {
             $("#edit_project_id").val(result.project_name);
             $("#edit_category").val(result.category_name);
             $("#edit_vendor_id").val(result.vendor);
             $("#edit_address").val(result.address);
             $("#edit_gst_number").val(result.gst_registration_no);
             $("#edit_po_number").val(result.po_number);
             $("#transaction_id_edit").val(result.transaction_id);
             $("#edit_advance_amount").val(result.advance_amount);
            $(".add_po_form").hide();
            $(".edit_po_form").show();

            return result.data;
          },
        },
        "columnDefs": [{
          "targets": [0],
          "orderable": false
        }]
      });

    }
    // $.ajax({
    //   url: base_url + 'get_edit_bom_po_item_by_project',
    //   type: 'POST',
    //   dataType: 'json',
    //   data: { po_id: po_id,project_id:project_id },
    // }).done(function(response) {
    //   console.log(response);
    //   var data = response.data;
    //   var po_no = response.po_no;
    //   $("#address").val(data.corporate_house_building_no);
    //   $("#gst_number").val(data.gst_registration_no);
    //   $("#po_number").val(po_no);
    //   $(".vendor-details").show();
    //   $("#displayPOItems").show();
    //   $("#displayPORemark").show();
    //   $("#displayPOAttachment").show();
    // }).fail(function(jqXHR, textStatus, errorThrown) {
    //   console.error('Error fetching vendor list:', textStatus, errorThrown);
    // });
  })







  $(document).on('keyup','.js-required-qty-indent',function(){
    //console.log('fff');
    var $this = $(this);
    var qty = parseFloat($this.val());
    // console.log('dd');
    if(qty > 0) {
      var bom_sr_no = $this.closest('tr').find('.js-bom_sr_no').val();
      var max_qty_allow = $this.closest('tr').find('.js-req_qty').val();
      var url = 'check_bom_indent_qty';
      var project_id = $("#project_id").val();
      if(qty > max_qty_allow){
        $('#invaliderrorid').html('Indent Quantity must be less than or equal to Available Qty '+max_qty_allow+'');
        $this.val(max_qty_allow);
      } else {
        $('#invaliderrorid').html('');
      }
    } else {
      //  console.log('ffdddd');
      $('#invaliderrorid').html('');
      // $this.val('');
      // calculateReleaseQuantity($this);
    }
  });



  $('#purchaseOrderlist tbody').on('click','.openview', function () {

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
    var row = purchaseOrderlist.row(tr);
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
});
var content = $('#terms_and_condition').val();  // Get the textarea content
    var formattedContent = content.replace(/\n/g, '<br>');  // Replace newlines with <br>
$('#terms_and_condition_val').val(formattedContent);
$(document).on('keyup','#terms_and_condition',function(e){
    var content = $('#terms_and_condition').val();  // Get the textarea content
    var formattedContent = content.replace(/\n/g, '<br>');  // Replace newlines with <br>
    $('#terms_and_condition_val').val(formattedContent);
});
