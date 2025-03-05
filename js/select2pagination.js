// var base_url = $('#base_url').val().trim();
var base_url = ($('#base_url').val() || '').trim();
$(document).on('click', '.displaysln', function(){
    $('#assign_user_id').val('0');
    $('.deflthide').hide();
    $('.edithide').show();
    $('#uslaoding').html('Please wait user list loading...');
    $.ajax({
        url : base_url+'get_all_user_list',
        type:'GET',
        dataType:'json',
    }).done(function(data) {
        $('#uslaoding').html('');
        $('.allusers').select2({
            data: data.users,
            placeholder: 'search',
            multiple: false,
            // query with pagination
            query: function(q) {
              var pageSize,
                results,
                that = this;
              pageSize = 20; // or whatever pagesize
              results = [];
              if (q.term && q.term !== '') {
                // HEADS UP; for the _.filter function i use underscore (actually lo-dash) here
                results = _.filter(that.data, function(e) {
                  return e.text.toUpperCase().indexOf(q.term.toUpperCase()) >= 0;
                });
              } else if (q.term === '') {
                results = that.data;
              }
              q.callback({
                results: results.slice((q.page - 1) * pageSize, q.page * pageSize),
                more: results.length >= q.page * pageSize,
              });
            },
          });
    });
});
var base_url = $('#base_url').val().trim();
$(document).ready(function() {
    $('#projlaoding').html('Please wait project list loading...');
    $.ajax({
        url : base_url+'get_all_project_list',
        type:'GET',
        dataType:'json',
    }).done(function(data) {
        $('#projlaoding').html('');

        $('.allprojects').select2({
            data: data.users,
            placeholder: 'search',
            multiple: false,
            // query with pagination
            query: function(q) {
              var pageSize,
                results,
                that = this;
              pageSize = 20; // or whatever pagesize
              results = [];
              if (q.term && q.term !== '') {
                // HEADS UP; for the _.filter function i use underscore (actually lo-dash) here
                results = _.filter(that.data, function(e) {
                  return e.text.toUpperCase().indexOf(q.term.toUpperCase()) >= 0;
                });
              } else if (q.term === '') {
                results = that.data;
              }
              q.callback({
                results: results.slice((q.page - 1) * pageSize, q.page * pageSize),
                more: results.length >= q.page * pageSize,
              });
            },
          });
    });

  // $(".p_search_boq_item").select2({
  //   minimumInputLength: 4,
  //   ajax: {
  //     url: base_url + 'get_all_item_list',
  //     dataType: 'json',
  //     type: "POST",
  //     quietMillis: 50,
  //     data: function (term) {
  //       return {
  //          term: term,
  //          type: $("#p_search_type").val()           , 
  //        };
  //     },
  //     results: function (data) {
  //       return {
  //         results: data.users
  //       };
  //     }
  //   }
  // });

  // $('#p_search_type').select2({
  //   minimumResultsForSearch: -1
  // });
});




// $(document).ready(function() {
//     $('#aglaoding').html('Please wait agent list loading...');
//     $.ajax({
//         url : base_url+'get_all_agent_list',
//         type:'GET',
//         dataType:'json',
//     }).done(function(data) {
//         $('#aglaoding').html('');
//         $('.allagents').select2({
//             data: data.users,
//             placeholder: 'search',
//             multiple: false,
//             // query with pagination
//             query: function(q) {
//               var pageSize,
//                 results,
//                 that = this;
//               pageSize = 20; // or whatever pagesize
//               results = [];
//               if (q.term && q.term !== '') {
//                 // HEADS UP; for the _.filter function i use underscore (actually lo-dash) here
//                 results = _.filter(that.data, function(e) {
//                   return e.text.toUpperCase().indexOf(q.term.toUpperCase()) >= 0;
//                 });
//               } else if (q.term === '') {
//                 results = that.data;
//               }
//               q.callback({
//                 results: results.slice((q.page - 1) * pageSize, q.page * pageSize),
//                 more: results.length >= q.page * pageSize,
//               });
//             },
//           });
//     });
// });
// $(document).on('click', '.displayslnimei_no', function(){
//     $('#default_imei_no').val('0');
//     $('.deflthideimei_no').hide();
//     $('.edithideimei_no').show();
//     $('#imeilaoding').html('Please wait IMEI list loading...');
//     $.ajax({
//         url : base_url+'get_all_imei_list',
//         type:'GET',
//         dataType:'json',
//     }).done(function(data) {
//         $('#imeilaoding').html('');
//         $('.allimei').select2({
//             data: data.imeis,
//             placeholder: 'search',
//             multiple: false,
//             // query with pagination
//             query: function(q) {
//               var pageSize,
//                 results,
//                 that = this;
//               pageSize = 20; // or whatever pagesize
//               results = [];
//               if (q.term && q.term !== '') {
//                 // HEADS UP; for the _.filter function i use underscore (actually lo-dash) here
//                 results = _.filter(that.data, function(e) {
//                   return e.text.toUpperCase().indexOf(q.term.toUpperCase()) >= 0;
//                 });
//               } else if (q.term === '') {
//                 results = that.data;
//               }
//               q.callback({
//                 results: results.slice((q.page - 1) * pageSize, q.page * pageSize),
//                 more: results.length >= q.page * pageSize,
//               });
//             },
//           });
//     });
// });

// $(document).ready(function() {
//     $('#imeilaoding').html('Please wait IMEI list loading...');
//     $.ajax({
//         url : base_url+'get_all_imei_list',
//         type:'GET',
//         dataType:'json',
//     }).done(function(data) {
//         $('#imeilaoding').html('');
//         $('.allimei').select2({
//             data: data.imeis,
//             placeholder: 'search',
//             multiple: false,
//             // query with pagination
//             query: function(q) {
//               var pageSize,
//                 results,
//                 that = this;
//               pageSize = 20; // or whatever pagesize
//               results = [];
//               if (q.term && q.term !== '') {
//                 // HEADS UP; for the _.filter function i use underscore (actually lo-dash) here
//                 results = _.filter(that.data, function(e) {
//                   return e.text.toUpperCase().indexOf(q.term.toUpperCase()) >= 0;
//                 });
//               } else if (q.term === '') {
//                 results = that.data;
//               }
//               q.callback({
//                 results: results.slice((q.page - 1) * pageSize, q.page * pageSize),
//                 more: results.length >= q.page * pageSize,
//               });
//             },
//           });
//     });
// });