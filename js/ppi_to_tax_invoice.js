$( document ).ready(function() {
    var project_id = $('#project_id').val().trim();
    var base_url = $('#base_url').val().trim();
    var download_title = 'Fore Close';
    var recordsPerPage = 10;
//     var po_value = $('#po_data').val();
//     var po_count = $('#po_count').val();
//     if ($('#po_data').val() != "") {
//       po_value=  $('#po_data').val().trim()
//     }
//     if ($('#po_count').val() != "") {
//       po_count  = $('#po_count').val().trim()
//     }
  
//      if (po_value == "") {
//       $('.form_data').css("display", "none");
//   }
//   if (po_count == 0 && po_value != "") {
//       $('.form_data').css("display", "none");
//       $('.alert-warning').removeClass("hide");
//       $('.alert-warning').addClass("show");
//   }
    var taxInvoiceList = $('#taxInvoiceList').DataTable({
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
        "sEmptyTable": "No Fore Close Found!"
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
        "url": base_url+"get_fore_close_list?project_id="+$('#project_id').val()+"&type="+page_type,
        "type": "GET",
        "data":{project_id:project_id}
      },
  
    });
 
    
    $(document).on('input', ".js-tax-basic_rate", function() {
      var basic_rate = parseFloat($(this).parents("tr").find(".basic_rate").val());
      var value = parseFloat($(this).val());
      if(value > basic_rate){
        $(this).val(parseFloat(basic_rate).toFixed(2));
        value = basic_rate;
      }
      const $row = $(this).closest('tr');
      const rate = parseFloat(value) || 0;
      const qty = parseFloat($row.find('[name="rate_basic[]"]').val()) || 0;
      const gst = parseFloat($row.find('[name="bom_gst[]"]').val()) || 0;
      const amount = qty * rate * (1 + gst / 100);
      $row.find('[name="amount[]"]').val(amount.toFixed(2));
    });

    $(document).on('input', ".tax-avilable-qty", function() {
        var available_qty = parseFloat($(this).parents("tr").find(".avilable-qty").val());
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
  
  
    // download FC excel
  
    $(document).on("click",".download-fc",function(){
  
      var project_id = $(this).data("project_id");
      var boq_code = $(this).data("boq_code");
      var type = $(this).data("type");
      var status = $(this).data("status");
      var transaction_id = $(this).data("transaction_id");
  
      $.ajax({
        url: base_url + 'get_fore_close_bom_detail',
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
          var vendor_data=   response.vendor_data;
          var address = vendor_data.reg_house_building_no + " " + vendor_data.reg_street + " "+ vendor_data.reg_city_post_code + " "+  vendor_data.reg_state;
          var gst_number = vendor_data.gst_registration_no;
          var fAmount = response.fAmount;
          var fcgst_amount = response.fcgst_amount;
          var fsgst_amount = response.fsgst_amount;
          var figst_amount = response.figst_amount;
          var ftotal_amount = response.ftotal_amount;
          var project_data = response.project_data
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
              item.fore_close_qty,
              item.veriable_rate,
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
            ["Fore Close"],
            [""],
            ["", "Puchase Order Number", bom_data[0]['po_number'], "", "", "", "", "", "", "", "", "", "", ""],
            ["", "Fore Close Number", bom_data[0]['fore_close_number'], "", "", "", "", "", "", "", "", "", "", ""],
            ["", "Date",  bom_data[0]['fc_date'], "", "", "", "", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", "", "", "", "", "", "", ""],
            ["", "To,", "", "", "", "", "", "", "", "", "", "", "", ""],
            ["", project_data.work_order_on, "", "", "", "", "", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", "", "", "", "", "", "", ""],
            ["", "Form,", "", "", "", "", "", "", "", "", "", "", "", ""],
            ["", "Vendor Name", vendor_data.name_of_company, "", "", "", "", "", "", "", "", "", "", ""],
            ["", "Address", address, "", "", "", "", "", "", "", "", "", "", ""],
            ["", "GST No", gst_number, "", "", "", "", "", "", "", "", "", "", ""],
            ["", "Project Name", project_data.bp_code, "", "", "", "", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", "", "", "", "", "", "", ""],
            ["Sr. No.","Item Description","BOM Code","HSN/SAC Code","Make","Model","Unit","Qty","Rate","Amount","Rate","","","Amount","","","Total"],
            ["","","","","","","","","","","CGST","SGST","IGST","CGST","SGST","IGST","Total"],
  
  
          ];
          var final_amount =[
            ["","Grand Total","","","","","","","",fAmount,"","","",fcgst_amount,fsgst_amount,figst_amount,ftotal_amount],
            ["","CGST","","","","","","","",fcgst_amount,"","","","","","",""],
            ["","SGST","","","","","","","",fsgst_amount,"","","","","","",""],
            ["","IGST","","","","","","","",figst_amount,"","","","","","",""],
            ["","Total With GST","","","","","","","",ftotal_amount,"","","","","","",""],
  
          ]
          var address_details=[
            [""],
            ["","Bill To","","Ship To"],
            ["",billing_address,"",shipping_address],
          ]
          ws_data = ws_data.concat(bom_data_array);
          ws_data = ws_data.concat(final_amount);
          ws_data = ws_data.concat(address_details);
          ws_data.forEach(row => worksheet.addRow(row));
  
          const boldFont = { bold: true };
   // Set font for specific cells
   worksheet.getCell(1, 1).font = boldFont;
   worksheet.getCell(3, 2).font = boldFont;
   worksheet.getCell(4, 2).font = boldFont;
   worksheet.getCell(5, 2).font = boldFont;
   worksheet.getCell(3, 4).font = boldFont;
   worksheet.getCell(7, 2).font = boldFont;
   worksheet.getCell(8, 2).font = boldFont;
   worksheet.getCell(9, 2).font = boldFont;
   worksheet.getCell(10, 2).font = boldFont;
   worksheet.getCell(11, 3).font = boldFont;
   worksheet.getCell(12, 3).font = boldFont;
   worksheet.getCell(13,3).font = boldFont;
   worksheet.getCell(14,3).font = boldFont;
   worksheet.getRow(16).font = boldFont;
   worksheet.getRow(17).font = boldFont;

   // Set column widths
   worksheet.columns = [
     { width: 8 },
     { width: 60 },
     { width: 20 },
     { width: 12 },
     { width: 12 },
     { width: 12 },
     { width: 12 },
     { width: 12 },
     { width: 12 },
     { width: 12 },
     { width: 12 },
     { width: 12 },
     { width: 12 },
     { width: 12 },
     { width: 12 },
     { width: 12 },
     { width: 12 },

   ];

   // Merge and align cells
   worksheet.mergeCells(1, 1, 2, 17);
   worksheet.mergeCells(11, 3, 11, 8);
   worksheet.mergeCells(12, 3, 12, 8);
   worksheet.mergeCells(13, 3, 13, 8);
   worksheet.mergeCells(14, 3, 14, 8);

   worksheet.mergeCells(16, 11, 16, 13); 
   worksheet.mergeCells(16, 14, 16, 16); 

   // Apply center alignment to merged cells
   worksheet.getCell(16, 9).alignment = { vertical: 'middle', horizontal: 'center' };
   worksheet.getCell(16, 11).alignment = { vertical: 'middle', horizontal: 'center' };
   worksheet.getCell(1, 8).alignment = { vertical: 'middle', horizontal: 'center' };
   worksheet.getCell(1, 1).font = { size: 18 };
         
  
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
          const grand_total_row_num = 17+total_bom_item;
          const  address_row = grand_total_row_num+7;
          worksheet.getRow(address_row).font = boldFont;
          const billing_text = worksheet.getCell(address_row+1, 2); 
          billing_text.alignment = { wrapText: true };
          const shipping_text = worksheet.getCell(address_row+1, 4); 
          shipping_text.alignment = { wrapText: true };
          worksheet.mergeCells(address_row, 4, address_row, 6);
          worksheet.mergeCells(address_row+1, 4, address_row+1, 6);
          const leftAlignment = { vertical: 'left', horizontal: 'left' };
          // Apply border style to all rows after the second row
          worksheet.eachRow({ includeEmpty: true }, (row, rowNumber) => {
            if (rowNumber > 15 && rowNumber < grand_total_row_num+6) { // Skip the first two rows (headers and the first data row)
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
                if(rowNumber > 16 && cell.col === 2){
                  cell.alignment = leftAlignment;
                }else{
                  cell.alignment = centerAlignment;
                }
  
                // for boder sip for marge column
                if(rowNumber == 16){
                  cell.font = boldFont;
                  if(cell.col === 10){
                    cell.border = borderStyle2;
                  }else if(cell.col === 11){
                    cell.border = borderStyle3;
                  }else if(cell.col === 12){
                    cell.border = borderStyle2;
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
            saveAs(blob, 'fore_close.xlsx');
          });
  
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error fetching vendor list:', textStatus, errorThrown);
        }
      });
  
  
  
  
    })
  
    $(document).on("click",".editRecordFC",function(){
      var fc_id = $(this).attr("rel-fc-id");
      $('.form_data').css("display", "");
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
            "url": base_url+"get_edit_bom_fc_item_by_project",
            "type": "POST",
            "data":{ fc_id: fc_id,project_id:project_id },
            'dataSrc':function(result) {
              $("#edit_project_name").val(result.project_name);
              $("#edit_project_id").val(project_id);
              $("#edit_category").val(result.category_name);
              $("#edit_vendor_id").val(result.vendor);
              $("#edit_address").val(result.address);
              $("#edit_gst_number").val(result.gst_registration_no);
              $("#edit_po_number").val(result.po_number);
              $("#po_data").val(result.po_number);
              $("#fc_id_edit").val(result.fc_id);
              $("#edit_remark").val(result.remark);
              $("#transaction_id_edit").val(result.transaction_id);
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
  
    })
  
  
    $('#taxInvoiceList tbody').on('click','.openview', function () {
  
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
      var row = taxInvoiceList.row(tr);
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
          download_title = 'Fore Close';
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
        +'<th scope="col" style="vertical-align: top;text-align:right;">Fore Close Qty</th>'
        +'<th scope="col" style="vertical-align: top;text-align:right;">Rate</th>'
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
            //   "url": base_url+"vpi_bom_trans_list_display",
              "url": base_url+"fc_bom_trans_list_display",
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


    $("#ppi_to_tax_invoice_form").validate({
        rules: {
          "bom_qty[]": {
            required: true
          },
          "rate_basic[]": {
            required: true
          },
         
        },
        messages: {
            "bom_qty[]": {
            required: "Please enter qty."
          },
          "rate_basic[]": {
            required: "Please enter rate."
          },
         
        },
        errorPlacement: function(error, element) {
          error.insertAfter(element);
        },
        submitHandler: function(form) {
          var formData = new FormData(form);
          $.ajax({
            // url: "save_fore_close_data",
            url: "save_tax_invoice_data",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              var res = JSON.parse(response);
              if(res.success == 1) {
                $(".alert-container").html('<div class="alert modify alert-success">' + res.messages + '</div>');
                setTimeout(function() {
                  $(".alert-container").html('');
                  window.location.href = "fore_close";
                }, 3000);
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
      $("#edit_force_close_form").validate({
        rules: {
          "bom_fore_close[]": {
            required: true
          },
         
        },
        messages: {
            "bom_fore_close[]": {
            required: "Please enter fore close qty."
          },
         
        },
        errorPlacement: function(error, element) {
          error.insertAfter(element);
        },
        submitHandler: function(form) {
          var formData = new FormData(form);
          $.ajax({
            url: "update_fore_close_data",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              var res = JSON.parse(response);
              if(res.success == 1) {
                $(".alert-container").html('<div class="alert modify alert-success">' + res.messages + '</div>');
                setTimeout(function() {
                  $(".alert-container").html('');
                  window.location.href = "fore_close";
                }, 3000);
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
  });
  
  