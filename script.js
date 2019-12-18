'use strict';

var $checkbox = document.getElementsByClassName('show_completed');

if ($checkbox.length) {
  $checkbox[0].addEventListener('change', function (event) {
    var is_checked = +event.target.checked;

    var searchParams = new URLSearchParams(window.location.search);
    searchParams.set('show_completed', is_checked);

    window.location = '/index.php?' + searchParams.toString();
  });
}

var tasksCB = document.querySelectorAll('input.task__checkbox');
tasksCB.forEach(e => {
  e.addEventListener('change', function (event) {
    var is_checked = +event.target.checked;
    var searchParams = new URLSearchParams();
    searchParams.set('status', is_checked);
    searchParams.set('task', +event.target.dataset.task);
    window.location = '/status.php?' + searchParams.toString();
  })
});

flatpickr('#date', {
  enableTime: false,
  dateFormat: "Y-m-d",
  locale: "ru"
});
