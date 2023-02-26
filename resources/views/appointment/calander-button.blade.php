@can("user-appointments.calender")
<a href="{{ route('appointments.calendar') }}"
   class="btn btn-icon btn-light"><i
            class="fas fa-calendar-alt fs-2"></i></a>
            <a type="button" class="btn btn-primary ms-auto" id="addAppointmentBtn">{{__('messages.vcard.add_appointment')}}</a>
@endcan
