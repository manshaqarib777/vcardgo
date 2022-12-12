<div class="modal fade" id="addGalleryModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">{{ __('messages.vcard.new_gallery') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'addGalleryForm', 'files' => 'true']) !!}
                <div class="row">
                    <div class="col-sm-12 mb-5">
                        <label class="form-label required fs-6 fw-bolder text-gray-700">{{ __('messages.gallery.gallery_name1').':' }}</label>
                        {{ Form::select('gallery_name', \App\Models\Gallery::NAME,null,['class' => 'form-select form-select-solid fw-bold', 'data-control' => '', 'data-dropdown-parent' => '#addGalleryModal' ,'id'=>'addGalleryName']) }}
                    </div>
                    <div class="col-sm-12 mb-5">
                        {{ Form::label('description', __('messages.gallery.description') . ':', ['class' => 'form-label required']) }}
                        {!! Form::textarea('description', null, [
                            'class' => 'form-control',
                            'placeholder' => __('messages.gallery.description'),
                            'rows' => '5',
                            'id'=>'addDescription'
                        ]) !!}
                    </div>
                    <div class="col-lg-6 mb-5">
                        {{ Form::label('date', __('messages.gallery.date') . ':', ['class' => 'form-label']) }}
                        {{ Form::date('date',  null, ['class' => 'form-control bg-white', 'placeholder' => __('messages.form.date'),'id'=>'addDate']) }}
                    </div>
                    <div class="col-sm-6 mb-5">
                        <label class="form-label required fs-6 fw-bolder text-gray-700">{{ __('messages.gallery.ticket_fine').':' }}</label>
                        {{ Form::select('ticket_fine', \App\Models\Gallery::TICKET_FINE,null,['class' => 'form-select form-select-solid fw-bold', 'data-control' => '', 'data-dropdown-parent' => '#addGalleryModal' ,'id'=>'addTicketFine']) }}
                    </div>
                    <div class="col-sm-6 mb-5">
                        <label class="form-label required fs-6 fw-bolder text-gray-700">{{ __('messages.gallery.ticket_status').':' }}</label>
                        {{ Form::select('ticket_status', \App\Models\Gallery::TICKET_STATUS,null,['class' => 'form-select form-select-solid fw-bold', 'data-control' => '', 'data-dropdown-parent' => '#addGalleryModal' ,'id'=>'addTicketStatus']) }}
                    </div>
                    <div class="col-lg-6 mb-5">
                        {{ Form::label('date_before', __('messages.gallery.date_before') . ':', ['class' => 'form-label']) }}
                        {{ Form::date('date_before', null, ['class' => 'form-control bg-white', 'placeholder' => __('messages.gallery.date_before'),'id'=>'addDateBefore']) }}
                    </div>
                    <div class="col-sm-6 mb-5">
                        <label class="form-label required fs-6 fw-bolder text-gray-700">{{ __('messages.gallery.fine').':' }}</label>
                        {{ Form::select('fine', \App\Models\Gallery::FINE,null,['class' => 'form-select form-select-solid fw-bold', 'data-control' => '', 'data-dropdown-parent' => '#addGalleryModal' ,'id'=>'addFine']) }}
                    </div>


                    <div class="col-sm-12 mb-5">

                        <img src="https://safety.idkaccounting.com/imgs/suspended.png" alt="" class="img-fluid">
                    </div>

                    <div class="col-lg-12 mb-5">
                        {{ Form::label('agent_name', __('messages.gallery.agent_name') . ':', ['class' => 'form-label']) }}
                        {{ Form::text('agent_name', null, ['class' => 'form-control', 'placeholder' => __('messages.gallery.agent_name'),'id'=>'addAgentName']) }}
                    </div>
                    <div class="col-sm-12 mb-5">
                        {{ Form::hidden('vcard_id', $vcard->id) }}
                    </div>
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label
                                class="form-label required fs-6 fw-bolder text-gray-700">{{ __('messages.gallery.type').':' }}</label>
                        </div>
                        {{ Form::select('type', \App\Models\Gallery::TYPE,null,
                            ['class' => 'form-control form-select form-select-solid fw-bold', 'required','data-dropdown-parent' => '#addGalleryModal','placeholder'=>'Select Type', 'data-control' => 'select2','id'=>'typeId']) }}
                    </div>
                    <div class="col-sm-12 mb-5 mt-3 image_link">

                        <div class="mb-3" io-image-input="true">
                            <label for="addGalleryPreview"
                                   class="form-label">{{ __('messages.gallery.gallery_name')}}</label>
                            <div class="d-block">
                                <div class="image-picker">
                                    <div class="image previewImage" id="addGalleryPreview"
                                         style="background-image: url('{{ asset('assets/images/default_service.png') }}')"></div>
                                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                          data-placement="top" data-bs-original-title="{{__('messages.tooltip.image')}}">
                                        <label>
                                            <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                            <input type="file" id="addImage" name="image"
                                                   class="image-upload d-none" accept="image/*"/> </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-7 d-none youtube_link">
                    {{ Form::label('link', __('messages.gallery.youtube').':', ['class' => 'form-label fs-6 fw-bolder required text-gray-700 mb-3']) }}
                    {{ Form::url('link', null, ['class' => 'form-control', 'placeholder' => 'https://www.youtube.com/watch?v=hAGbufevHM4','id'=>'linkRequired']) }}
                </div>
                <div class="d-flex">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary me-3','id'=>'GallerySave']) }}
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

