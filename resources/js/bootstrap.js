import 'bootstrap';

import $ from "jquery";
window.$ = $;

import Noty from 'noty';
window.Noty = Noty;

import toastr from 'toastr';
window.toastr = toastr;

import select2 from 'select2';
select2();

$(function () {
    $("#employees-table").DataTable({
      processing: true,
      serverSide: true,
    ajax: '/users/data-source/employees',
    columns: [
      {data: 'id', name: 'id'},
      {data: 'employee_name', name: 'employee_name'},
      {data: 'photo', name: 'photo', orderable: false, searchable: false },
      {data: 'age', name: 'age'},
      {data: 'position', name: 'position'},
      {data: 'employee_details', name: 'employee_details',
        render: function (data) { return data.substr(0,100)+'...'; }
      },
      {data: 'department.department_name', defaultContent:"#", name: 'department.department_name'},
      
      {data: 'tags', defaultContent:"#", name: 'tags', orderable: false, searchable: false},
      {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
    });
});

  
  $(function () {
    $("#departments-table").DataTable({
      processing: true,
      serverSide: true,
    ajax: '/users/data-source/departments',
    columns: [
      {data: 'id', name: 'id'},
      {data: 'department_name', name: 'department_name', width: "20%"},
      {data: 'department_details', name: 'department_details', width: "40%",
        render: function (data) { return data.substr(0,100)+'...'; }
      },
      {data: 'created_at', type: 'num', name: 'created_at', orderable: true, searchable: false,
        render: { _: 'display', sort: 'timestamp' }
      },
      {data: 'action', name: 'action', width: "15%", orderable: false, searchable: false},
    ]
    });
});


$(function () {
  $("#tags-table").DataTable({
    processing: true,
    serverSide: true,
  ajax: '/users/data-source/tags',
  columns: [
    {data: 'id', name: 'id'},
    {data: 'tag_name', name: 'tag_name'},
    {data: 'created_at', type: 'num', name: 'created_at', orderable: true, searchable: false,
      render: { _: 'display', sort: 'timestamp' }
    },
    {data: 'action', name: 'action', width: "20%", orderable: false, searchable: false},
  ]
  });
});

$(function () {
  var table = $("#activity-table").DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
  ajax: '/admin/data-source/activity',
  columns: [
    {data: 'created_at', type: 'num', name: 'created_at', searchable: false},
    {data: 'description', name: 'description', width: "40%"},
    // {data: 'ip', defaultContent:"#", name: 'ip', width: "20%"},
    {data: 'causer.name', defaultContent: 'Deleted User', name: 'causer.name'},
  ]
  });

  $('#userFind').select2({
    placeholder: {
      id: '-1', // the value of the option
      text: 'Select User'
    },
    allowClear: true,
    ajax: {
      url: '/admin/users/select',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                    id: item.id,
                    text: item.name
                  }
              })
          };
        }
    }
});

$('#userFind').on('select2:select', function (e) {
  var data = e.params.data;
  var searchable = $(this).data('column');
  table.column(searchable).search(data.text)
  .draw();
  console.log(data);
});

});

$(function () {
  $("#userlog-table").DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
  ajax: '/users/data-source/user-log',
  columns: [
    {data: 'created_at', type: 'num', name: 'created_at', searchable: false},
    {data: 'description', name: 'description', width: "50%"},
  ]
  });

});


$('#inputDepartment').select2({
  placeholder: 'Select Department',
  ajax: {
    url: '/users/departments/select',
    dataType: 'json',
    delay: 250,
    processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
                return {
                  id: item.id,
                  text: item.department_name
                }
            })
        };
      }
  }
});


$('.tags-input').on('select2:select', function (e) {
    var data = e.params.data;
    console.log(data.text);
    $.ajax({
      type: 'GET',
      url: '/users/tags/new-option',
      dataType: 'json',
      delay: 250,
      data: {
        option: data.text
      },
      success: function(response){
        var data = JSON.stringify(response);
        console.log(data);
      } 
  });  
});

$('.tags-input').select2({
  placeholder: 'Select Tags',
  tags: true,
  tokenSeparators: [',', ' '],
  ajax: {
      url: '/users/tags/select',
      dataType: 'json',
      delay: 250,
      data: function(params) {
        return {
          q: params.term
        }
      },
      processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                    id: item.tag_name,
                    text: item.tag_name,
                    newTag: true
                  }
              })
          };
        }
    }
});






/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
