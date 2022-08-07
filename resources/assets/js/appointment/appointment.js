document.addEventListener('turbo:load', loadAppointmentCalendar);

let popover;
let popoverState = false;
let calendar;
let data = {
    id: '',
    uId: '',
    eventName: '',
    eventDescription: '',
    eventStatus: '',
    startDate: '',
    endDate: '',
    vcardName: '',
    email: '',
    phone: '',
    startDateTime: '',
    endDateTime: '',
};

// View event variables
let viewEventName, viewEventDescription, viewEventStatus, viewStartDate,
    viewEndDate,
    viewModal,
    viewEditButton,
    viewDeleteButton,
    viewVcardName,
    viewEmail,
    viewPhone
;


function loadAppointmentCalendar () {
    if (!$('#appointmentCalendar').length) {
        return;
    }

    initCalendarApp();
    let calendar = document.getElementById('appointmentCalendar');
    if (isEmpty(calendar)) {
        return;
    }
    init();
}

const initCalendarApp = function () {
    let calendarEl = document.getElementById('appointmentCalendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        themeSystem: 'bootstrap5',
        height: 750,
        headerToolbar: {
            left: 'title',
            center: 'prev,next today',
            right: 'dayGridMonth',
        },
        initialDate: new Date(),
        timeZone: 'UTC',
        dayMaxEvents: true,
        events: function (info, successCallback, failureCallback) {
            $.ajax({
                url: route('appointments.calendar'),
                type: 'GET',
                data: info,
                success: function (result) {
                    if (result.success) {
                        successCallback(result.data);
                    }
                },
                error: function (result) {
                    displayErrorMessage(result.responseJSON.message);
                    failureCallback();
                },
            });
        },
        // MouseEnter event --- more info: https://fullcalendar.io/docs/eventMouseEnter
        eventMouseEnter: function (arg) {
            formatArgs({
                id: arg.event.id,
                title: arg.event.title,
                startStr: arg.event.startStr,
                endStr: arg.event.endStr,
                description: arg.event.extendedProps.description,
                name: arg.event.extendedProps.name,
                vcardName: arg.event.extendedProps.vcardName,
                email: arg.event.extendedProps.email,
                phone: arg.event.extendedProps.phone,
                startDateTime: arg.event.extendedProps.startDateTime,
                endDateTime: arg.event.extendedProps.endDateTime,
            });
            // Show popover preview
            initPopovers(arg.el);
        },
        eventMouseLeave: function () {
            hidePopovers();
        },
        // Click event --- more info: https://fullcalendar.io/docs/eventClick
        eventClick: function (arg) {
            hidePopovers();
            formatArgs({
                id: arg.event.id,
                title: arg.event.title,
                startStr: arg.event.startStr,
                endStr: arg.event.endStr,
                description: arg.event.extendedProps.description,
                name: arg.event.extendedProps.name,
                vcardName: arg.event.extendedProps.vcardName,
                email: arg.event.extendedProps.email,
                phone: arg.event.extendedProps.phone,
                startDateTime: arg.event.extendedProps.startDateTime,
                endDateTime: arg.event.extendedProps.endDateTime,
            });
            handleViewEvent();
        },
    });
    calendar.render();
};

const init = () => {
    const viewElement = document.getElementById('patientEventModal');
    viewModal = new bootstrap.Modal(viewElement);
    viewEventName = viewElement.querySelector(
        '[data-calendar="event_name"]');
    viewEventDescription = viewElement.querySelector(
        '[data-calendar="event_description"]');
    viewEventStatus = viewElement.querySelector(
        '[data-calendar="event_status"]');
    viewVcardName = viewElement.querySelector('[data-calendar="event_vcard_name"]');
    viewEmail = viewElement.querySelector('[data-calendar="event_email"]');
    viewPhone = viewElement.querySelector('[data-calendar="event_phone"]');
    viewStartDate = viewElement.querySelector(
        '[data-calendar="event_start_date"]');
    viewEndDate = viewElement.querySelector(
        '[data-calendar="event_end_date"]');
    viewEditButton = viewElement.querySelector('#modal_view_event_edit');
    viewDeleteButton = viewElement.querySelector('#modal_view_event_delete');
};

// Format FullCalendar responses
const formatArgs = (res) => {
    data.id = res.id;
    data.eventName = res.title;
    data.eventDescription = res.description;
    data.startDate = res.startStr;
    data.endDate = res.endStr;
    data.name = res.name;
    data.vcardName = res.vcardName;
    data.email = res.email;
    data.phone = res.phone;
    data.startDateTime = res.startDateTime;
    data.endDateTime = res.endDateTime;
};

// Initialize popovers --- more info: https://getbootstrap.com/docs/4.0/components/popovers/
const initPopovers = (element) => {
    hidePopovers();
    // Generate popover content
    const startDate = data.allDay ?
        moment(data.startDate).format('Do MMM, YYYY')
        : moment(data.startDate).format('Do MMM, YYYY - h:mm a');
    const endDate = data.allDay
        ? moment(data.endDate).format('Do MMM, YYYY')
        : moment(data.endDate).format('Do MMM, YYYY - h:mm a');
    const popoverHtml = '<div class="fw-bolder mb-2"><b>User</b>: ' +
        data.name +
        '</div><div class="fs-7"><span class="fw-bold">Start:</span> ' +
        startDate +
        '</div><div class="fs-7 mb-2"><span class="fw-bold">End:</span> ' +
        endDate + '</div>' +
        '<div class="fw-bolder"><b>'+Lang.get('messages.vcard.vcard_name')+'</b>:</span> ' +
            data.vcardName + '</div>';
    // Popover options
    let options = {
        container: 'body',
        trigger: 'manual',
        boundary: 'window',
        placement: 'auto',
        dismiss: true,
        html: true,
        title: 'Appointment Details',
        content: popoverHtml,
    };

};

// Hide active popovers
const hidePopovers = () => {
    if (popoverState) {
        popover.dispose();
        popoverState = false;
    }
};

// Handle view button
const handleViewButton = () => {
    const viewButton = document.querySelector('#calendar_event_view_button');
    viewButton.addEventListener('click', e => {
        e.preventDefault();
        hidePopovers();
        handleViewEvent();
    });
};

// Handle view event
const handleViewEvent = () => {
    $('.fc-popover').addClass('hide');
    viewModal.show();

    // Detect all day event
    let eventNameMod;
    let startDateMod;
    let endDateMod;

    eventNameMod = '';
    startDateMod = data.startDateTime;
    endDateMod = data.endDateTime;
    viewEndDate.innerText = ': ' + endDateMod;
    viewStartDate.innerText = ': ' + startDateMod;

    // Populate view data
    viewEventName.innerText = 'User: ' + data.name;
    $(viewEventStatus).val(data.eventStatus);
    viewVcardName.innerText = Lang.get('messages.vcard.vcard_name')+': ' + data.vcardName;
    viewEmail.innerText = Lang.get('messages.user.email')+': ' + data.email;
    viewPhone.innerText = Lang.get('messages.user.phone')+': ' + data.phone;
};

listen('change', '#appointmentType', function () {
    window.livewire.emit('changeFilter', $(this).val());
    hideDropdownManually($('#appointmentFilterBtn'), $('#appointmentFilter'))
})

listen('click', '#appointmentResetFilter', function () {
    $('#appointmentType').val(3).change()
    hideDropdownManually($('#appointmentFilterBtn'), $('#appointmentFilter'))
})

listen('click', '#appointmentFilterBtn', function () {
    openDropdownManually($('#appointmentFilterBtn'), $('#appointmentFilter'))
})
