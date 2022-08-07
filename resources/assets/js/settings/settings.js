document.addEventListener('turbo:load', loadSettingData);

let form;
let phone;
let prefixCode;
function loadSettingData() {
    if (!$('#createSetting').length) {
        return
    }
    form = document.getElementById('createSetting');
    
    form.addEventListener('reset', reset);
    
    phone = document.getElementById('phoneNumber').value;
    prefixCode = document.getElementById('prefix_code').value;
}

listenChange( '#appLogo', function () {
    displayPhoto(this, '#appLogoPreview');
});

listenClick('.cancel-app-logo', function () {
    $('#appLogoPreview').attr('src', defaultAppLogoUrl);
});

listenChange( '#favicon', function () {
   displayPhoto(this, '#faviconPreview', true);
});

listenClick( '.cancel-favicon', function () {
    $('#faviconPreview').attr('src', defaultFaviconUrl);
});

function reset () {
    document.getElementById('phoneNumber').
        setAttribute('value', phone);
    document.getElementById('prefix_code').setAttribute('value', '+'+prefixCode);
}

function isEmail(email) {
    let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

listenSubmit('#createSetting', function () {
   
    if ($.trim($('#settingAppName').val()) == '') {
        displayErrorMessage('App Name field is required.')
        return false
    }

    if (!isEmail($('#settingEmail').val())) {
        displayErrorMessage('Please enter valid email.')
        return false
    }

    if ($.trim($('#phoneNumber').val()) == '') {
        displayErrorMessage('Phone Number field is required.')
        return false
    }

    if ($.trim($('#settingPlanExpireNotification').val()) == '') {
        displayErrorMessage('Plan Expire Notification field is required.')
        return false
    }

    if ($.trim($('#settingAddress').val()) == '') {
        displayErrorMessage('Address field is required.')
        return false
    }
    
});


listen('click', '.stripe-enable', function () {
    $('.stripe-div').toggleClass('d-none')
})

listen('click', '.paypal-enable', function () {
    $('.paypal-div').toggleClass('d-none')
})

listen('submit', '#UserCredentialsSettings', function () {
    
    

    if ($('#stripeEnable').prop('checked')) {
        if ($('#stripeKey').val().trim().length === 0) {
            displayErrorMessage('Stripe key field is required')
            return false
        } else if ($('#stripeSecret').val().trim().length === 0) {
            displayErrorMessage('Stripe secret field is required')
            return false
        }
    }

    if ($('#paypalEnable').prop('checked')) {
        if ($('#paypalKey').val().trim().length === 0) {
            displayErrorMessage('Paypal key field is required')
            return false
        } else if ($('#paypalSecret').val().trim().length === 0) {
            displayErrorMessage('Paypal secret field is required')
            return false
        } else if ($('#paypalMode').val().trim().length === 0) {
            displayErrorMessage('Paypal mode field is required')
            return false
        }
    }
    
    processingBtn('#UserCredentialsSettings', '#userCredentialSettingBtn',
        'loading')
    $('#userCredentialSettingBtn').prop('disabled', true)
})
