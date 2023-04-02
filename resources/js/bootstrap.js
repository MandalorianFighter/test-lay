import 'bootstrap';

import $ from "jquery";
window.$ = $;

import select2 from 'select2';
select2();

$(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });


  $('#inputDepartment').select2({
    placeholder: 'Select Department',
    ajax: {
      url: '/departments/select',
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
      url: '/tags/new-option',
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
      url: '/tags/select',
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
