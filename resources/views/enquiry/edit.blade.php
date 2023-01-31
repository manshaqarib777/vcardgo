<div class="modal fade" id="editEnquiryModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">{{ __('messages.vcard.edit_enquiry') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {!! Form::open(['id'=>'editEnquiryForm', 'files' => 'true']) !!}

            <div class="modal-body">
                <div class="row mb-5">
                    <div class="col-sm-12 mb-5 col-lg-6">
                        {{ Form::hidden('enquiry_id', null,['id' => 'enquiryId']) }}
                        {{ Form::label('name',__('messages.common.name').(':'), ['class' => 'form-label required']) }}
                        {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'editName', 'required', 'placeholder' => __('messages.form.enquiry')]) }}
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
                        {{ Form::select('reason',  \App\Models\Enquiry::REASON, null, ['class' => 'form-select form-select-solid fw-bold select2Selector', 'data-placeholder'=>__('messages.common.reason'), 'id' => 'editReason', 'data-control' => 'select2', 'data-dropdown-parent' => '#editEnquiryModal']) }}
                    </div>
                    <div class="col-sm-12 mb-5 col-lg-6">
                        <div class="mb-3" io-image-input="true">
                            <label for="editEnquiryPreview"
                                   class="form-label required">{{ __('messages.vcard.enquiry').':' }}</label>
                            <div class="d-block">
                                <div class="image-picker">
                                    <div class="image previewImage" id="editEnquiryPreview"
                                         style="background-image: url('{{ asset('assets/images/default_service.png') }}')"></div>
                                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                          data-placement="top" data-bs-original-title="{{__('messages.tooltip.image')}}">
                                        <label>
                                            <i class="fa-solid fa-pen" id="enquiryIcon"></i>
                                            <input type="file" id="editEnquiryIcon" name="enquiry_url"
                                                   class="image-upload d-none" accept="image/*"/> </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-5 col-lg-6">
                        {{ Form::label('message', __('messages.contact_us.message').':', ['class' => 'form-label required']) }}
                        {{ Form::textarea('message', null, ['class' => 'form-control', 'id' => 'editMessage', 'placeholder' => __('messages.form.type_message'), 'rows' => '5' , 'required']) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary m-0','id' => 'enquiryUpdateBtn']) }}
                {{ Form::button(__('messages.common.discard'),['class' => 'btn btn-secondary my-0 ms-5 me-0','data-bs-dismiss' => 'modal']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
