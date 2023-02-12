<div class="modal fade" id="editAppointmentModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">{{ __('messages.vcard.edit_appointment') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {!! Form::open(['id'=>'editAppointmentForm', 'files' => 'true']) !!}

            <div class="modal-body">
                <div class="row mb-5">
                    <div class="col-sm-12 mb-5 col-lg-6">
                        {{ Form::label('date',__('messages.date').(':'), ['class' => 'form-label required']) }}
                        {{ Form::text('date', null, ['class' => 'appointmentDate mb-2 form-control', 'id' => 'pickUpDate', 'required', 'placeholder' => __('messages.form.pick_date')]) }}
                    </div>
                    <div class="col-sm-12 mb-5 col-lg-6 vcard-one vcard-one__appointment ">
                        {{ Form::label('hour',__('messages.hour').(':'), ['class' => 'form-label required']) }}
                        <div id="slotData" class="row appointment-one">
                        </div>
                    </div>
                    <div class="col-sm-12 mb-5 col-lg-6">
                        {{ Form::hidden('vcard_id', null, ['id' => 'vCardId']) }}
                        {{ Form::hidden('appointment_id', null,['id' => 'appointmentId']) }}
                        {{ Form::hidden('from_time', null, ['id' => 'timeSlot']) }}
                        {{ Form::hidden('to_time', null, ['id' => 'toTime']) }}
                        {{ Form::label('name',__('messages.common.name').(':'), ['class' => 'form-label required']) }}
                        {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'editName', 'required', 'placeholder' => __('messages.form.appointment')]) }}
                    </div>
                    <div class="col-sm-12 mb-5 col-lg-6">
                        {{ Form::label('email',__('messages.user.email').(':'), ['class' => 'form-label required']) }}
                        {{ Form::text('email', null, ['class' => 'form-control', 'id' => 'editEmail', 'required', 'placeholder' => __('messages.form.your_email')]) }}
                    </div>
                    <div class="col-sm-12 mb-5 col-lg-6">
                        {{ Form::label('phone',__('messages.user.phone').(':'), ['class' => 'form-label required']) }}
                        {{ Form::tel('phone', null, ['class' => 'form-control', 'id' => 'editPhone', 'required', 'placeholder' => __('messages.form.phone')]) }}
                    </div>
                    <div class="col-sm-12 mb-5 col-lg-6">
                        {{ Form::label('reason',__('messages.common.reason').':', ['class' => 'form-label']) }}
                        {{ Form::select('reason',  \App\Models\Appointment::REASON, null, ['class' => 'form-select form-select-solid fw-bold select2Selector', 'data-placeholder'=>__('messages.common.reason'), 'id' => 'editReason', 'data-control' => 'select2', 'data-dropdown-parent' => '#editAppointmentModal']) }}
                    </div>
                    <div class="col-sm-12 mb-5 col-lg-6">
                        {{ Form::label('location',__('messages.vcard.location').':', ['class' => 'form-label']) }}
                        {{ Form::select('location',  \App\Models\Appointment::LOCATION, null, ['class' => 'form-select form-select-solid fw-bold select2Selector', 'data-placeholder'=>__('messages.common.location'), 'id' => 'editLocation', 'data-control' => 'select2', 'data-dropdown-parent' => '#editAppointmentModal']) }}
                    </div>
                    <div class="col-sm-12 mb-5 col-lg-6">
                        {{ Form::label('message', __('messages.contact_us.message').':', ['class' => 'form-label required']) }}
                        {{ Form::textarea('message', null, ['class' => 'form-control', 'id' => 'editMessage', 'placeholder' => __('messages.form.type_message'), 'rows' => '5' , 'required']) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary m-0','id' => 'appointmentUpdateBtn']) }}
                {{ Form::button(__('messages.common.discard'),['class' => 'btn btn-secondary my-0 ms-5 me-0','data-bs-dismiss' => 'modal']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
