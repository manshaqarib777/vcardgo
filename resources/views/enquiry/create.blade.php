<div class="modal fade" id="addEnquiryModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">{{ __('messages.vcard.add_enquiry') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {!! Form::open(['id'=>'addEnquiryForm', 'files' => 'true']) !!}

            <div class="modal-body">
                <div class="row mb-5">
                    <div class="col-sm-12 mb-5 col-lg-6">
                        {{ Form::hidden('vcard_id', auth()->id()) }}
                        {{ Form::label('name',__('messages.common.name').(':'), ['class' => 'form-label required']) }}
                        {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'addName', 'required', 'placeholder' => __('messages.common.name')]) }}
                    </div>
                    <div class="col-sm-12 mb-5 col-lg-6">
                        {{ Form::label('email',__('messages.user.email').(':'), ['class' => 'form-label required']) }}
                        {{ Form::text('email', null, ['class' => 'form-control', 'id' => 'addEmail', 'required', 'placeholder' => __('messages.form.your_email')]) }}
                    </div>
                    <div class="col-sm-12 mb-5 col-lg-6">
                        {{ Form::label('phone',__('messages.user.phone').(':'), ['class' => 'form-label required']) }}
                        {{ Form::tel('phone', null, ['class' => 'form-control', 'id' => 'addPhone', 'required', 'placeholder' => __('messages.form.phone')]) }}
                    </div>
                    <div class="col-sm-12 mb-5 col-lg-6">
                        {{ Form::label('reason',__('messages.common.reason').':', ['class' => 'form-label']) }}
                        {{ Form::select('reason',  \App\Models\Enquiry::REASON, null, ['class' => 'form-select form-select-solid fw-bold select2Selector', 'data-placeholder'=>__('messages.common.reason'), 'id' => 'addReason', 'data-control' => 'select2', 'data-dropdown-parent' => '#addEnquiryModal']) }}
                    </div>
                    <div class="col-sm-12 mb-5 col-lg-6">
                        <div class="mb-3" io-image-input="true">
                            <label for="addEnquiryPreview"
                                   class="form-label required">{{ __('messages.vcard.enquiry').':' }}</label>
                            <div class="d-block">
                                <div class="image-picker">
                                    <div class="image previewImage" id="addEnquiryPreview"
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
                        {{ Form::textarea('message', null, ['class' => 'form-control', 'id' => 'addMessage', 'placeholder' => __('messages.form.type_message'), 'rows' => '5' , 'required']) }}
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
