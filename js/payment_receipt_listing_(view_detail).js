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


  // $(document).on("click",".openpaymentview",function(){
  //     let id = $(this).attr("data-id");
  //     $.ajax({
  //       url: base_url + 'get_payment_sub_item',
  //       type: 'POST',
  //       dataType: 'json',
  //       data: { ppi_id: id },
  //     }).done(function(data) {
  //       $('#vendorLaoding').html('');
  
  //       $('.allVendor').select2({
  //         data: data.map(function(item) {
  //           return { id: item.id, text: item.vendor }; // Adjust to match your data structure
  //         }),
  //         placeholder: 'search',
  //         multiple: false,
  //       });
  //       // $(".vendor-details").show();
  //     }).fail(function(jqXHR, textStatus, errorThrown) {
  //       console.error('Error fetching vendor list:', textStatus, errorThrown);
  //       $('#vendorLaoding').html('Failed to load vendors.');
  //     });
  // })
  $(document).on("click",".openpaymentview",function(){

    $(this).text(function(i, text){
      return text === "CLOSE" ? "VIEW" : "CLOSE";
    });
    let ppi_id = $(this).attr("data-id");

    var filter = 'original';

    var tr = $(this).closest('tr');
    var row = payment_receipt_list.row(tr);
    // console.log(table_bom);

    if (row.child.isShown()) {
      row.child.hide();
      tr.removeClass('shown');
    }else{
      var divwidth = $("#bomtranslist").width();
      var divminwidth = divwidth - 20;
      var filterhtml='';
      var headtxt='';
      download_title = 'Payment Receipt Items';


      var actionhtml='';
      var actionhtmlfooter='';

      var html = '<div class="portlet-body form" id="displayed'+ppi_id+'">'
      +'<div class="displayFlx" style="margin-bottom: 15px;display:flex;">'
      +filterhtml
      +'<div class="col-md" id="calculatedfiler'+ppi_id+'"></div>'
      +'</div>'
      +'<div id="originalpbomviewdiv'+ppi_id+'"><div class="table-responsive">'
      +'<table width="100%" id="originalpbomview'+ppi_id+'" class="table table-striped table-bordered table-hover" style="text-align: left;">'
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
      +actionhtml
      +'</tr>'
      +'</thead>'
      +'<tbody></tbody>'
      +'</table></div></div>';
      row.child(html).show();
      tr.addClass('shown');
      $('.dt-hasChild').next().css('background','#f5f5f5');
      $('.dt-hasChild').next().css('box-shadow','inset 0 0 0 9999px rgba(0, 0, 0, 0.075)');

      var table2 = $('#originalpbomview'+ppi_id).DataTable({
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
          "url": base_url+"get_payment_sub_item",
          "type": "POST",
          "data":{ppi_id:ppi_id}
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
