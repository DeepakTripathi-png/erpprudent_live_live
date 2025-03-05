$( document ).ready(function() {
  if ($('#project_id_data').val() != "") {
    var project_id = $('#project_id_data').val().trim();
    $("#project_dropdown").hide();
  }else{
    $("#project_dropdown").show();
  }
  if ($('#base_url').val() != "") {
    var base_url = $('#base_url').val().trim();
  }


  var download_title = 'Return Memo';
  var recordsPerPage = 10;
  var return_memo_list;
  dataTable();

  $('#project_id').on('change', function() {
    var project_id = $(this).val();
    var po_number = $("#po_number_val").val()
    var type = $("#type_val").val()
    var base_url = $('#base_url').val();

    if (project_id) {
      $.ajax({
        url: base_url + 'return_memo_list_by_project_id',
        type: 'POST',
        data: {
          project_id: project_id,
          po_number:po_number,
          type:type
        },
        beforeSend: function() {
          // $('#projlaoding').html('<span>Loading...</span>');
        },
        success: function(response) {
          console.log(response)
          return_memo_list.destroy();
          $('#return_memo_list tbody').html(response);

          dataTable()
        },
        complete: function() {
          $('#projlaoding').html('');
        },
        error: function(xhr, status, error) {
          console.error('AJAX Error: ' + status + error);
        }
      });
    }
  });
  $('#return_memo_list tbody').on('click','.openview', function () {

    $(this).text(function(i, text){
      return text === "CLOSE" ? "VIEW" : "CLOSE";
    });
    console
    var transaction_id = $(this).attr('data-id');

    var project_id = $(this).attr('data-project_id');
    var boq_code = $(this).attr('data-boq_code');
    var transaction_type = $(this).attr('data-type');
    var status_txt = $(this).attr('data-status');

    var filter = 'original';

    var tr = $(this).closest('tr');
    var row = return_memo_list.row(tr);
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
function dataTable(){
    var type_val = $("#type_val").val() == "return_memo" ? "Return Memo" : "Debit Note";
    return_memo_list = $('#return_memo_list').DataTable({
    "scrollX": false,
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
      "sEmptyTable": "No "+type_val+" Data Found!"
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
    });
  }



  $(document).on("click", ".download-debit-note", function() {
    var vdc_id = $(this).attr("data-vdc-id");
    var project_id = $(this).attr("data-project-id");

    $.ajax({
        url: base_url + 'get_debit_note_data_for_excel',
        type: 'POST',
        dataType: 'json',
        data: { vdc_id: vdc_id,
          project_id:project_id,
         },
         success: function(response) {
    var data = response.data;
    console.log(data);

    const workbook = new ExcelJS.Workbook();
    const worksheet = workbook.addWorksheet('Sheet1');
    var total_bom_item = data.length;
    var bom_data_array = [];
    var count = 1;

    data.forEach(function(item) {
        var row = [
            count,
            item.item_description,
            item.bom_code,
            item.hsn_sac_code,
            item.make,
            item.model,
            item.unit,
            item.bad_condition_qty,
            item.basic_rate,
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

    var ws_data = [
        ['Debit Note'],
        [""],
        [""],
        ["", "Debit Note Number", "1245036", "", "", "", "Date", data[0]['debit_note_date']],  // Updated date format
        ["", "Vendor Delivery Number", data[0]['vdc_number'], "", "", "", "Project", response['project_data']['bp_code']],
        ["", "Vendor Name", response['vendor_data']['name_of_company'], "", "", "", "", ""],
        ["", "", "", "", "", "", "", "", "", "", "", "", "", ""],
        ["Sr. No.", "Item Description", "BOM Code", "HSN/SAC Code", "Make", "Model", "Unit", "Qty", "Rate", "Amount", " Rate", "Rate", " Rate", " Amount", " Amount", " Amount", "Total Amount"],
        ["", "", "", "", "", "", "", "", "", "", "CGST", "SGST", "IGST", "CGST ", "SGST ", "IGST ", "Total"]
    ];

    var final_amount = [
        ["", "Grand Total", "", "", "", "", "", "", "", response.fAmount, "", "", "", response.fcgst_amount, response.fsgst_amount, response.figst_amount, response.ftotal_amount],
        ["", "CGST (" + response.cgst + ")", "", "", "", "", "", "", "", response.fcgst_amount, "", "", "", "", "", "", ""],
        ["", "SGST (" + response.sgst + ")", "", "", "", "", "", "", "", response.fsgst_amount, "", "", "", "", "", "", ""],
        ["", "IGST (" + response.igst + ")", "", "", "", "", "", "", "", response.figst_amount, "", "", "", "", "", "", ""],
        ["", "Total With GST", "", "", "", "", "", "", "", response.ftotal_amount, "", "", "", "", "", "", ""]
    ];

    // Concatenate data and totals to worksheet
    ws_data = ws_data.concat(bom_data_array);
    ws_data = ws_data.concat(final_amount);

    // Add data rows to worksheet
    ws_data.forEach(row => worksheet.addRow(row));

    // Set column widths
    worksheet.columns = [
        { width: 10 }, // Column 1
        { width: 25 }, // Column 2
        { width: 15 }, // Column 3
        { width: 20 }, // Column 4
        { width: 15 }, // Column 5
        { width: 15 }, // Column 6
        { width: 15 }, // Column 7
        { width: 15 }, // Column 8
        { width: 15 }, // Column 9
        { width: 15 }, // Column 10
        { width: 10 }, // CGST
        { width: 10 }, // SGST
        { width: 10 }, // IGST
        { width: 15 }, // CGST Amount
        { width: 15 }, // SGST Amount
        { width: 15 }, // IGST Amount
        { width: 15 }  // Total Amount
    ];

    // Apply font and alignment to headers
    worksheet.getRow(8).font = { bold: true };  // Make header row bold
    worksheet.getRow(9).font = { bold: true };  // Make header row bold
    worksheet.getRow(8).alignment = { vertical: 'middle', horizontal: 'center' }; // Align header row

    // Merge and center title cells
    worksheet.mergeCells(1, 1, 2, 17);
    worksheet.mergeCells(8, 11, 8, 13);
    worksheet.mergeCells(8, 14, 8, 16);
    worksheet.getCell(1, 1).alignment = { vertical: 'middle', horizontal: 'center' };
    worksheet.getCell(1, 1).font = { size: 20, bold: true };
    worksheet.getCell(4, 3).font = { bold: true };
    worksheet.getCell(5, 3).font = { bold: true };
    worksheet.getCell(5, 8).font = { bold: true };
    worksheet.getCell(4, 8).font = { bold: true };
    worksheet.getCell(6, 3).font = { bold: true };

    const boldFont = { bold: true };
    const borderStyle = {
        top: { style: 'thin', color: { argb: '000000' } },
        left: { style: 'thin', color: { argb: '000000' } },
        bottom: { style: 'thin', color: { argb: '000000' } },
        right: { style: 'thin', color: { argb: '000000' } }
    };

    const greenBackground = { type: 'pattern', pattern: 'solid', fgColor: { argb: '92e89e' } }; // Green background color
    const centerAlignment = { vertical: 'middle', horizontal: 'center' };

    const grand_total_row_num = 8 + total_bom_item;

    worksheet.eachRow({ includeEmpty: true }, (row, rowNumber) => {
        if (rowNumber > 7 && rowNumber < grand_total_row_num + 7) {
            row.eachCell({ includeEmpty: true }, (cell) => {
                cell.border = borderStyle;
                if (rowNumber == grand_total_row_num+2 ) {
                    cell.fill = greenBackground;
                }
                if (rowNumber == grand_total_row_num+6 ) {
                    cell.fill = greenBackground;
                }
                cell.alignment = centerAlignment;
                if (rowNumber > grand_total_row_num+1) {
                      cell.font = boldFont;
                  }
            });

        }

    });


    workbook.xlsx.writeBuffer().then(function(buffer) {
        const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        saveAs(blob, 'debit_note.xlsx');
    });
},


        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching data:', textStatus, errorThrown);
        }
    });
});

});
