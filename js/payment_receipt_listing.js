$( document ).ready(function() {
  if ($('#project_id').val() != "") {
    var project_id = $('#project_id').val().trim();
  }
  if ($('#base_url').val() != "") {
    var base_url = $('#base_url').val().trim();
  }

  var download_title = 'Payment Receipt';
  var recordsPerPage = 10;


  var payment_receipt_list = $('#payment_receipt_list').DataTable({
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
      "sEmptyTable": "No Payment Recepit Data Found!"
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
    // "ajax": {
    //   "url": base_url+"get_purchase_order_list?project_id="+$('#project_id').val()+"&type="+page_type,
    //   "type": "GET",
    //   "data":{project_id:project_id}
    // },

  });


  $(document).on("click", ".download-pr-excel", function() {
    var project_id = $(this).data("project_id");
    var boq_code = $(this).data("boq_code");
    var type = $(this).data("type");
    var status = $(this).data("status");
    var transaction_id = $(this).data("transaction_id");

    $.ajax({
      url: base_url + 'get_pr_bom_detail_for_excel',
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
        var pr_data = response.pr_data;
        var bom_data = response.bom_data;
        var cgst = bom_data[0].cgst;
        var sgst = bom_data[0].sgst;
        var igst = bom_data[0].igst;
        var total_bom_item = bom_data.length;
        var vendor_data = response.vendor_data;
        var address = vendor_data.reg_house_building_no + " " + vendor_data.reg_street + " " + vendor_data.reg_city_post_code + " " + vendor_data.reg_state;
        var gst_number = vendor_data.gst_registration_no;
        var fAmount = response.fAmount;
        var fcgst_amount = response.fcgst_amount;
        var fsgst_amount = response.fsgst_amount;
        var figst_amount = response.figst_amount;
        var ftotal_amount = response.ftotal_amount;
        var project_data = response.project_data;
        var shipping_address = response.project_data.site_address;
        var billing_address = `Prudent EPC Pvt. Ltd.
        5th floor, 509 B wing, Golf
        Scappe, Sion Trombay, Road,
        Chembur, Mumbai -400071
        GST No- 27AAKCP4656L1Zs`;
        var paymentAmount = parseFloat(pr_data.payment_amount) || 0;
        var gstAmount = parseFloat(pr_data.gst_amount) || 0;
        var payable_amount = paymentAmount + gstAmount;
        var bom_data_array = [];
        var count = 1;
        bom_data.forEach(function(item) {
          var row = [
            count,
            item.item_description,
            item.bom_code,
            item.hsn_code,
            item.make,
            item.model,
            item.unit,
            item.qty,
            item.rate,
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
          ["Payment Receipt"],
          [""],
          ["", "Puchase Order Number", bom_data[0]['po_number'], "", "", "", "", "", "", "", "", "", "", ""],
          ["", "Proforma Invoice Number", bom_data[0]['proforma_no'], "", "", "", "", "", "", "", "", "", "", ""],
          ["", "Date", pr_data['payment_date'], "", "", "", "", "", "", "", "", "", "", ""],
          ["", "", "", "", "", "", "", "", "", "", "", "", "", ""],
          ["", "To,", "", "", "", "", "", "", "", "", "", "", "", ""],
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
          ["","CGST"+"("+cgst+")","","","","","","","",fcgst_amount,"","","","","","",""],
          ["","SGST"+"("+sgst+")","","","","","","","",fsgst_amount,"","","","","","",""],
          ["","IGST"+"("+igst+")","","","","","","","",figst_amount,"","","","","","",""],
          ["","Total With GST","","","","","","","",ftotal_amount,"","","","","","",""],
          ["","Advance payment","","","","","","","",paymentAmount,"","","","","","",""],
          ["","Advance payment GSt","","","","","","","",gstAmount,"","","","","","",""],
          ["","Total Advance Payment","","","","","","","",payable_amount,"","","","","","",""],

        ]

        var termsAndConditionText = bom_data[0].terms_and_condition;
        termsAndConditionText = termsAndConditionText.replaceAll("<br>", '');
        var formattedTermsAndCondition = termsAndConditionText
        .split(/(\d+\.\s+)/)
        .filter(Boolean)
        .map(function(text, index, array) {
            return (index % 2 !== 0) ? array[index - 1] + text : null;
        })
        .filter(Boolean)
        .join('\n');
        bom_data[0].terms_and_condition = formattedTermsAndCondition;
        

        var terms_n_condition = [
          [""],
          ["","Terms & Conditions"],
          ["",bom_data[0].terms_and_condition]
        ];
        var address_details=[
          [""],
          ["","Bill To","","Ship To"],
          ["",billing_address,"",shipping_address],
        ]

        ws_data = ws_data.concat(bom_data_array);
        ws_data = ws_data.concat(final_amount);
        ws_data = ws_data.concat(terms_n_condition);
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
        worksheet.getCell(11, 2).font = boldFont;
        worksheet.getRow(13).font = boldFont;
        worksheet.getRow(14).font = boldFont;

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
        worksheet.mergeCells(8, 3, 8, 8);
        worksheet.mergeCells(9, 3, 9, 8);
        worksheet.mergeCells(10, 3, 10, 8);
        worksheet.mergeCells(11, 3, 11, 8);

        worksheet.mergeCells(13, 11, 13, 13); // Merge cells at row 12, columns 9 to 10
        worksheet.mergeCells(13, 14, 13, 16); // Merge cells at row 12, columns 11 to 13

        // Apply center alignment to merged cells
        worksheet.getCell(13, 9).alignment = { vertical: 'middle', horizontal: 'center' };
        worksheet.getCell(13, 11).alignment = { vertical: 'middle', horizontal: 'center' };
        worksheet.getCell(1, 8).alignment = { vertical: 'middle', horizontal: 'center' };
        worksheet.getCell(1, 1).font = { size: 18 };

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


        const grand_total_row_num = 14 + total_bom_item;
        // console.log(grand_total_row_num)
        const  tnc_row = grand_total_row_num+10;
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
        const centerAlignment = { vertical: 'middle', horizontal: 'center' };
        const backgroundColor = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'a3b4fcb4' } };
        const fontColor = { color: { argb: 'FFFF0000' } }; // red color for font

        // Apply border and alignment only to BOM data items
        worksheet.eachRow({ includeEmpty: true }, (row, rowNumber) => {
          if (rowNumber > 12 && rowNumber < grand_total_row_num+9) { // Skip the first two rows (headers and the first data row)
            row.eachCell({ includeEmpty: true }, (cell) => {
              // Example: Apply a specific border style to column 5

              // // for grand total roe backgroundColor
              // if(grand_total_row_num+6 == rowNumber){
              //   if(cell.col > 3){
              //     cell.font = { ...boldFont, color: fontColor.color };
              //   }else{
              //     cell.font = boldFont;
              //   }
              //   cell.fill = backgroundColor;
              // }
              // // for grand total roe backgroundColor
              // if(grand_total_row_num+2 == rowNumber || grand_total_row_num+3 == rowNumber){
              //   if(cell.col > 2){
              //     cell.font = { ...boldFont, color: fontColor.color };
              //   }else{
              //     cell.font = boldFont;
              //   }
              // }
              // if(grand_total_row_num+3 == rowNumber || grand_total_row_num+4 == rowNumber){
              //   if(cell.col > 3){
              //     cell.font = { ...boldFont, color: fontColor.color };
              //   }else{
              //     cell.font = boldFont;
              //   }
              // }

              if(grand_total_row_num < rowNumber ){
                cell.font = { ...boldFont};
                // cell.fill = backgroundColor;
              }
              if(grand_total_row_num+5 == rowNumber || grand_total_row_num+8 == rowNumber ){
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


        workbook.xlsx.writeBuffer().then(function(buffer) {
          const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
          saveAs(blob, 'payment_receipt.xlsx');
        });
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('Error fetching vendor list:', textStatus, errorThrown);
      }
    });
  });

});
