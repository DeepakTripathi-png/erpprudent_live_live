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
  $('#project_id').on('change', function() {
    var project_id = $(this).val();
    var base_url = $('#base_url').val();

    if (project_id) {
      $.ajax({
        url: base_url + 'return_memo_list_by_project_id',
        type: 'POST',
        data: {
          project_id: project_id
        },
        beforeSend: function() {
          $('#projlaoding').html('<span>Loading...</span>');
        },
        success: function(response) {
          console.log(response);
          $('#return_memo_list tbody').html(response);
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

  var download_title = 'Return Memo';
  var recordsPerPage = 10;
  var return_memo_list = $('#return_memo_list').DataTable({
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
      "sEmptyTable": "No Retrun Memo Data Found!"
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


});
