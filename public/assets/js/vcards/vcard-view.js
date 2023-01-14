/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/assets/js/vcards/vcard-view.js":
/*!**************************************************!*\
  !*** ./resources/assets/js/vcards/vcard-view.js ***!
  \**************************************************/
/***/ (() => {

document.addEventListener('DOMContentLoaded', displayError);
document.addEventListener('DOMContentLoaded', loadVcardView);
document.addEventListener('DOMContentLoaded', passwordLoad);
document.addEventListener('DOMContentLoaded', langDropdown);

function displayError(selector, msg) {
  var selectorAttr = $(selector);
  selectorAttr.removeClass('d-none');
  selectorAttr.show();
  selectorAttr.text(msg);
  setTimeout(function () {
    $(selector).slideUp();
  }, 3000);
}

var timezone_offset_minutes;

function loadVcardView() {
  var urlStr = window.location.href;

  if (urlStr.indexOf('?') != -1) {
    window.history.pushState(null, '', route('vcard.show', vcardAlias));
    var message = urlStr.split('?').pop();
    displaySuccessMessage(message.replace(/%20/g, ' '));
  }

  if (!$('.date').length) {
    return;
  }

  timezone_offset_minutes = new Date().getTimezoneOffset();
  timezone_offset_minutes = timezone_offset_minutes === 0 ? 0 : -timezone_offset_minutes;
  $('.date').flatpickr({
    locale: lang,
    minDate: new Date(),
    disableMobile: true
  });
  setTimeout(function () {
    if (isEdit) {
      $('.date').val(date).trigger('change');
    }
  }, 1000);
  var selectedDate;
  var selectedSlotTime;

  if (!$('.no-time-slot').length) {
    return;
  }

  $('.no-time-slot').removeClass('d-none');
}

listenChange('.date', function () {
  $('#slotData').empty();
  selectedDate = $(this).val();
  $('#Date').val(selectedDate);
  $.ajax({
    url: slotUrl,
    type: 'GET',
    data: {
      'date': selectedDate,
      'timezone_offset_minutes': timezone_offset_minutes,
      'vcardId': vcardId
    },
    success: function success(result) {
      if (result.success) {
        $.each(result.data, function (index, value) {
          var data = [{
            'value': value
          }];
          $('#slotData').append(prepareTemplateRender('#appoitmentTemplate', data));
        });
      }
    },
    error: function error(result) {
      $('#slotData').html('');
      displayErrorMessage(result.responseJSON.message);
    }
  });
});
listenClick('.appointmentAdd', function () {
  if (!$('.time-slot').hasClass('activeSlot')) {
    displayErrorMessage('Please Select Date Or Hour');
  } else {
    $('#AppointmentModal').modal('show');
    $('#appointmentPaymentMethod').select2({
      dropdownParent: $('#AppointmentModal')
    });
  }
});
listenClick('.time-slot', function () {
  if ($(this).hasClass('activeSlot')) {
    $('.time-slot').removeClass('activeSlot');
    $(this).removeClass('activeSlot');
    selectedSlotTime = $(this).addClass('activeSlot');

    if (selectedSlotTime) {
      $(this).removeClass('activeSlot');
    }
  } else {
    $('.time-slot').removeClass('activeSlot');
    selectedSlotTime = $(this).addClass('activeSlot');
  }

  var fromToTime = $(this).attr('data-id').split('-');
  var fromTime = fromToTime[0];
  var toTime = fromToTime[1];
  $('#timeSlot').val('');
  $('#toTime').val('');
  $('#timeSlot').val(fromTime);
  $('#toTime').val(toTime);
});
listenHiddenBsModal('#AppointmentModal', function () {
  resetModalForm('#addAppointmentForm');
});
listenSubmit('#addAppointmentForm', function (event) {
  event.preventDefault();
  $('#serviceSave').prop('disabled', true);
  $.ajax({
    url: appointmentUrl,
    type: 'POST',
    data: $(this).serialize(),
    success: function success(result) {
      if (result.success) {
        if (!isEmpty(result.data)) {
          if (result.data.payment_method == 1) {
            var sessionId = result.data[0].sessionId;
            stripe.redirectToCheckout({
              sessionId: sessionId
            });
          }

          if (result.data.payment_method == 2) {
            if (result.url) {
              window.location.href = result.url;
            }

            if (result.data[0].original.statusCode === 201) {
              var redirectTo = '';
              $.each(result.data[0].original.result.links, function (key, val) {
                if (val.rel == 'approve') {
                  redirectTo = val.href;
                }
              });
              location.href = redirectTo;
            }
          }
        }

        displaySuccessMessage(result.message);
        $('#addAppointmentForm')[0].reset();
        $("#AppointmentModal").modal('hide');
        $('#slotData').empty();
        $('#pickUpDate').val('');
        $('.date').flatpickr({
          minDate: new Date(),
          disableMobile: true
        });
        $('#serviceSave').prop('disabled', false);
      }
    },
    error: function error(result) {
      displayErrorMessage(result.responseJSON.message);
      $('#serviceSave').prop('disabled', false);
    }
  });
});

function langDropdown() {
  if (!$('.dropdown1').length) {
    return;
  }

  $('.dropdown1').hover(function () {
    $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(100);
  }, function () {
    $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(100);
  });
}

listenClick('#languageName', function () {
  var languageName = $(this).attr('data-name');
  $.ajax({
    url: languageChange + '/' + languageName + '/' + vcardAlias,
    type: 'GET',
    success: function success(result) {
      displaySuccessMessage(result.message);
      setTimeout(function () {
        location.reload();
      }, 2000);
    },
    error: function error(result) {
      displayErrorMessage(result.responseJSON.message);
    }
  });
});
listenClick('.share', function () {
  $('#vcard1-shareModel').modal('hide');
});
listenClick('.share2', function () {
  $('#vcard2-shareModel').modal('hide');
});
listenClick('.share3', function () {
  $('#vcard3-shareModel').modal('hide');
});
listenClick('.share4', function () {
  $('#vcard4-shareModel').modal('hide');
});
listenClick('.share5', function () {
  $('#vcard5-shareModel').modal('hide');
});
listenClick('.share6', function () {
  $('#vcard6-shareModel').modal('hide');
});
listenClick('.share7', function () {
  $('#vcard7-shareModel').modal('hide');
});
listenClick('.share8', function () {
  $('#vcard8-shareModel').modal('hide');
});
listenClick('share9', function () {
  $('#vcard9-shareModel').modal('hide');
});
listenClick('.share10', function () {
  $('#vcard10-shareModel').modal('hide');
});

function passwordLoad() {
  if (password) {
    var passwordAttr = $('#passwordModal');
    passwordAttr.appendTo('body').modal('show');
  } else {
    $('.content-blur').removeClass('content-blur');
  }
}

listenHiddenBsModal('#passwordModal', function () {
  $(this).find('#password').focus();
});
listenSubmit('#passwordForm', function (event) {
  event.preventDefault();
  $.ajax({
    url: passwordUrl,
    type: 'POST',
    data: $(this).serialize(),
    success: function success(result) {
      if (result.success) {
        $('#passwordModal').modal('hide');
        $('.content-blur').removeClass('content-blur');
      }
    },
    error: function error(result) {
      displayError('#passwordError', result.responseJSON.message);
    }
  });
});
var $window = $(window),
    previousScrollTop = 0,
    scrollLock = true;
$window.scroll(function (event) {
  if (scrollLock) {
    previousScrollTop = $window.scrollTop();
  }

  $window.scrollTop(previousScrollTop);
});
listenSubmit('#enquiryForm', function (event) {
  event.preventDefault();
  $('.contact-btn').prop('disabled', true);
  var formData = new FormData(this);

  $.ajax({
    url: enquiryUrl,
    type: 'POST',
    data: formData,
    success: function success(result) {
      if (result.success) {
        displaySuccessMessage(result.message);
        $('#enquiryForm')[0].reset();
        $("#exampleInputEnquiry").css("background-image", "url('')");
        $('.contact-btn').prop('disabled', false);
      }
    },
    error: function error(result) {
      displayError('#enquiryError', result.responseJSON.message);
      $('.contact-btn').prop('disabled', false);
    },
    cache: false,
    contentType: false,
    processData: false
  });
});
listenClick('.vcard1-share', function () {
  $('#vcard1-shareModel').modal('show');
});
listenClick('.vcard2-share', function () {
  $('#vcard2-shareModel').modal('show');
});
listenClick('.vcard3-share', function () {
  $('#vcard3-shareModel').modal('show');
});
listenClick('.vcard4-share', function () {
  $('#vcard4-shareModel').modal('show');
});
listenClick('.vcard5-share', function () {
  $('#vcard5-shareModel').modal('show');
});
listenClick('.vcard6-share', function () {
  $('#vcard6-shareModel').modal('show');
});
listenClick('.vcard7-share', function () {
  $('#vcard7-shareModel').modal('show');
});
listenClick('.vcard8-share', function () {
  $('#vcard8-shareModel').modal('show');
});
listenClick('.vcard9-share', function () {
  $('#vcard9-shareModel').modal('show');
});
listenClick('.vcard10-share', function () {
  $('#vcard10-shareModel').modal('show');
});
listenClick('.gallery-link', function () {
  var url = $(this).data('id');
  $('#video').attr('src', url);
});
listenHiddenBsModal('#exampleModal', function () {
  $('#video').attr('src', '');
});

window.downloadVcard = function (fileName, id) {
  $.ajax({
    url: '/vcards/' + id,
    type: 'GET',
    success: function success(result) {
      if (result.success) {
        var vcard = result.data;
        var vcardString = 'BEGIN:VCARD\n' + 'VERSION:3.0\n';

        if (!isEmpty(vcard.first_name) || !isEmpty(vcard.last_name)) {
          vcardString += 'N;CHARSET=UTF-8:' + vcard.first_name + ' ' + vcard.last_name + '\n';
        }

        if (!isEmpty(vcard.dob)) {
          vcardString += 'BDAY;CHARSET=UTF-8:' + new Date(vcard.dob) + '\n';
        }

        if (!isEmpty(vcard.email)) {
          vcardString += 'EMAIL;CHARSET=UTF-8:' + vcard.email + '\n';
        }

        if (!isEmpty(vcard.job_title)) {
          vcardString += 'TITLE;CHARSET=UTF-8:' + vcard.job_title + '\n';
        }

        if (!isEmpty(vcard.company)) {
          vcardString += 'ORG;CHARSET=UTF-8:' + vcard.company + '\n';
        }

        if (!isEmpty(vcard.region_code) && !isEmpty(vcard.phone)) {
          vcardString += 'TEL;TYPE=WORK,VOICE:' + vcard.region_code + vcard.phone + '\n';
        }

        if (!isEmpty(vcard.url_alias)) {
          vcardString += 'URL;CHARSET=UTF-8:' + appUrl + '/v/' + vcard.url_alias + '\n';
        }

        if (!isEmpty(vcard.description)) {
          vcardString += 'NOTE;CHARSET=UTF-8:' + vcard.description + '\n';
        }

        if (!isEmpty(vcard.location)) {
          vcardString += 'ADR;CHARSET=UTF-8:' + vcard.location + '\n';
        }

        var extension = vcard.profile_url.split('.').pop();
        vcardString += 'PHOTO;ENCODING=BASE64;TYPE=' + extension.toUpperCase() + ':' + vcard.profile_url_base64 + '\n';
        vcardString += 'REV:' + moment().toISOString() + '\n';
        vcardString += 'END:VCARD';
        var a = $("<a />");
        a.attr("download", fileName);
        a.attr("href", "data:text/vcard;charset=UTF-8," + encodeURI(vcardString));
        $("body").append(a);
        a[0].click();
        $("body").remove(a);
      }
    },
    error: function error(result) {
      displayError('#enquiryError', result.responseJSON.message);
    }
  });
};

listen('click', '.paymentByPaypal', function () {
  var campaignId = $('#campaignId').val();
  var firstName = $('#firstName').val();
  var LastName = $('#lastName').val();
  var email = $('#email').val();
  var currencyCode = $('#currencyCode').val();
  var amount = $('#amount').val();

  if (amount.trim().length === 0) {
    iziToast.error({
      title: 'Error',
      message: 'The amount field is required',
      position: 'topRight'
    });
    return false;
  } else if (amount === '0') {
    iziToast.error({
      title: 'Error',
      message: 'The amount is required greater than zero',
      position: 'topRight'
    });
    return false;
  } else if (firstName.trim().length === 0) {
    iziToast.error({
      title: 'Error',
      message: 'The first name field is required',
      position: 'topRight'
    });
    return false;
  } else if (LastName.trim().length === 0) {
    iziToast.error({
      title: 'Error',
      message: 'The last name field is required',
      position: 'topRight'
    });
    return false;
  }

  $(this).addClass('disabled');
  $('.donate-btn').text('Please Wait...');
  $.ajax({
    type: 'GET',
    url: route('paypal.init'),
    data: {
      amount: parseFloat($('#amount').val()),
      currency_code: $('#currencyCode').val(),
      campaign_id: campaignId,
      first_name: firstName,
      last_name: LastName,
      email: email
    },
    success: function success(result) {
      if (result.url) {
        window.location.href = result.url;
      }

      if (result.statusCode === 201) {
        var redirectTo = '';
        $.each(result.result.links, function (key, val) {
          if (val.rel == 'approve') {
            redirectTo = val.href;
          }
        });
        location.href = redirectTo;
      }
    },
    error: function error(_error) {
      iziToast.error({
        title: 'Error',
        message: _error.responseJSON.message,
        position: 'topRight'
      });
    },
    complete: function complete() {}
  });
});
listenClick('.terms-policies-btn', function () {
  var termPolicySection = $('.terms-policies-section');
  var allSection = $('.allSection');

  if (termPolicySection.hasClass('show')) {
    termPolicySection.removeClass('show');
    allSection.addClass('show');
  } else {
    termPolicySection.addClass('show');
    allSection.removeClass('show');
  }
});

/***/ }),

/***/ "./resources/assets/scss/vcard6.scss":
/*!*******************************************!*\
  !*** ./resources/assets/scss/vcard6.scss ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/vcard7.scss":
/*!*******************************************!*\
  !*** ./resources/assets/scss/vcard7.scss ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/vcard8.scss":
/*!*******************************************!*\
  !*** ./resources/assets/scss/vcard8.scss ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/vcard9.scss":
/*!*******************************************!*\
  !*** ./resources/assets/scss/vcard9.scss ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/vcard10.scss":
/*!********************************************!*\
  !*** ./resources/assets/scss/vcard10.scss ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/blog.scss":
/*!*****************************************!*\
  !*** ./resources/assets/scss/blog.scss ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/front/front-custom.scss":
/*!*******************************************************!*\
  !*** ./resources/assets/scss/front/front-custom.scss ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/css/main.scss":
/*!****************************************!*\
  !*** ./resources/assets/css/main.scss ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/custom-vcard.scss":
/*!*************************************************!*\
  !*** ./resources/assets/scss/custom-vcard.scss ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/css/front-custom.scss":
/*!************************************************!*\
  !*** ./resources/assets/css/front-custom.scss ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/vcard1.scss":
/*!*******************************************!*\
  !*** ./resources/assets/scss/vcard1.scss ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/vcard2.scss":
/*!*******************************************!*\
  !*** ./resources/assets/scss/vcard2.scss ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/vcard3.scss":
/*!*******************************************!*\
  !*** ./resources/assets/scss/vcard3.scss ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/vcard4.scss":
/*!*******************************************!*\
  !*** ./resources/assets/scss/vcard4.scss ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/vcard5.scss":
/*!*******************************************!*\
  !*** ./resources/assets/scss/vcard5.scss ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/assets/js/vcards/vcard-view": 0,
/******/ 			"assets/css/vcard3": 0,
/******/ 			"assets/css/vcard2": 0,
/******/ 			"assets/css/vcard10": 0,
/******/ 			"assets/css/vcard9": 0,
/******/ 			"assets/css/vcard8": 0,
/******/ 			"assets/css/vcard5": 0,
/******/ 			"assets/css/vcard4": 0,
/******/ 			"assets/css/vcard1": 0,
/******/ 			"assets/css/custom": 0,
/******/ 			"assets/css/custom-vcard": 0,
/******/ 			"assets/css/page": 0,
/******/ 			"assets/css/front/front-custom": 0,
/******/ 			"assets/css/blog": 0,
/******/ 			"assets/css/vcard7": 0,
/******/ 			"assets/css/vcard6": 0
/******/ 		};
/******/
/******/ 		// no chunk on demand loading
/******/
/******/ 		// no prefetching
/******/
/******/ 		// no preloaded
/******/
/******/ 		// no HMR
/******/
/******/ 		// no HMR manifest
/******/
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/
/************************************************************************/
/******/
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/js/vcards/vcard-view.js")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/scss/vcard1.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/scss/vcard2.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/scss/vcard3.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/scss/vcard4.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/scss/vcard5.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/scss/vcard6.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/scss/vcard7.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/scss/vcard8.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/scss/vcard9.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/scss/vcard10.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/scss/blog.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/scss/front/front-custom.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/css/main.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/scss/custom-vcard.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["assets/css/vcard3","assets/css/vcard2","assets/css/vcard10","assets/css/vcard9","assets/css/vcard8","assets/css/vcard5","assets/css/vcard4","assets/css/vcard1","assets/css/custom","assets/css/custom-vcard","assets/css/page","assets/css/front/front-custom","assets/css/blog","assets/css/vcard7","assets/css/vcard6"], () => (__webpack_require__("./resources/assets/css/front-custom.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/
/******/ })()
;
