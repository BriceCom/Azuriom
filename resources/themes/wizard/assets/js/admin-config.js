/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************!*\
  !*** ./js/admin-config.js ***!
  \****************************/
window.addEventListener("DOMContentLoaded", function (event) {
  "use strict";

  var formAzuriom = document.getElementById('configForm');
  formAzuriom.addEventListener('submit', function (event) {
    document.querySelectorAll('.js-detect-create-builder-input').forEach(function (el) {
      var i = 0;
      el.querySelectorAll('.inputs_wrapper .form-row').forEach(function (row) {
        row.querySelectorAll('input').forEach(function (input) {
          input.name = input.name.replace('{index}', i.toString());
        });
        i++;
      });
    });
    document.querySelectorAll('.js-detect-create-builder-input').forEach(function (el) {
      var copy = el.querySelector('.js-detect-create-builder-copy').firstElementChild;
      copy.parentNode.removeChild(copy);
    });
    document.querySelectorAll('.form-check-input').forEach(function (el) {
      if (!el.checked) {
        el.checked = "false";
        el.value = 'false';
      }
    });
    // event.preventDefault()
    // return false
  });
  function removeInput(el) {
    el.addEventListener('click', function () {
      var element = el.parentNode.parentNode;
      element.parentNode.removeChild(element);
    });
  }
  ;
  document.querySelectorAll('.link-remove').forEach(function (el) {
    removeInput(el);
  });
  document.querySelectorAll('.js-detect-create-builder-input-add').forEach(function (event) {
    event.addEventListener('click', function (click) {
      var copy = event.closest('.js-detect-create-builder-input').querySelector('.js-detect-create-builder-copy');
      var wrapper = event.closest('.js-detect-create-builder-input').querySelector('.inputs_wrapper');
      wrapper.append(copy.firstElementChild.cloneNode(true));
      document.querySelectorAll('.link-remove').forEach(function (el) {
        removeInput(el);
      });
    });
  });
});
/******/ })()
;