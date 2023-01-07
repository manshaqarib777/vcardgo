<div class="modal fade" id="editGalleryModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">{{ __('messages.vcard.edit_gallery') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'editGalleryForm', 'files' => 'true']) !!}
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        {{ Form::label('gallery_name', __('messages.gallery.gallery_name') . ':', ['class' => 'form-label']) }}
                        {{ Form::text('gallery_name', null, ['class' => 'form-control', 'placeholder' => __('messages.gallery.gallery_name'),'id'=>'editGalleryName','maxlength'=>20]) }}
                    </div>
                    <div class="col-sm-12 mb-5">
                        {{ Form::label('description', __('messages.gallery.description') . ':', ['class' => 'form-label required']) }}
                        {!! Form::textarea('description', null, [
                            'class' => 'form-control',
                            'placeholder' => __('messages.gallery.description'),
                            'rows' => '5',
                            'id'=>'editDescription'
                        ]) !!}
                    </div>
                    <div class="col-lg-6 mb-5">
                        {{ Form::label('date', __('messages.gallery.date') . ':', ['class' => 'form-label']) }}
                        {{ Form::date('date',  null, ['class' => 'form-control bg-white', 'placeholder' => __('messages.form.date'),'id'=>'editDate']) }}
                    </div>
                    <div class="col-sm-6 mb-5">
                        <label class="form-label required fs-6 fw-bolder text-gray-700">{{ __('messages.gallery.ticket_fine').':' }}</label>
                        {{ Form::select('ticket_fine', \App\Models\Gallery::TICKET_FINE,null,['class' => 'form-select form-select-solid fw-bold', 'data-control' => '', 'data-dropdown-parent' => '#editGalleryModal' ,'id'=>'editTicketFine']) }}
                    </div>
                    <div class="col-sm-6 mb-5">
                        <label class="form-label required fs-6 fw-bolder text-gray-700">{{ __('messages.gallery.ticket_status').':' }}</label>
                        {{ Form::select('ticket_status', \App\Models\Gallery::TICKET_STATUS,null,['class' => 'form-select form-select-solid fw-bold', 'data-control' => '', 'data-dropdown-parent' => '#editGalleryModal' ,'id'=>'editTicketStatus']) }}
                    </div>
                    <div class="col-lg-6 mb-5">
                        {{ Form::label('date_before', __('messages.gallery.date_before') . ':', ['class' => 'form-label']) }}
                        {{ Form::date('date_before', null, ['class' => 'form-control bg-white', 'placeholder' => __('messages.gallery.date_before'),'id'=>'editDateBefore']) }}
                    </div>
                    <div class="col-sm-6 mb-5">
                        <label class="form-label required fs-6 fw-bolder text-gray-700">{{ __('messages.gallery.fine').':' }}</label>
                        {{ Form::select('fine', \App\Models\Gallery::FINE,null,['class' => 'form-select form-select-solid fw-bold', 'data-control' => '', 'data-dropdown-parent' => '#editGalleryModal' ,'id'=>'editFine']) }}
                    </div>
                    <div class="col-sm-12 mb-5 editSuspended" >
                        {{ Form::label('suspended_description', __('messages.gallery.suspended_description') . ':', ['class' => 'form-label required']) }}
                        {!! Form::textarea('suspended_description', null, [
                            'class' => 'form-control',
                            'placeholder' => __('messages.gallery.suspended_description'),
                            'rows' => '5',
                            'id'=>'editSuspendedDescription'
                        ]) !!}
                    </div>

                    <div class="col-sm-12 mb-5 editSuspended">

                        <img src="https://safety.idkaccounting.com/imgs/suspended.png" alt="" class="img-fluid">
                    </div>

                    <div class="col-lg-12 mb-5">
                        {{ Form::label('agent_name', __('messages.gallery.agent_name') . ':', ['class' => 'form-label']) }}
                        {{ Form::text('agent_name', null, ['class' => 'form-control', 'placeholder' => __('messages.gallery.agent_name'),'id'=>'editAgentName']) }}
                    </div>
                    <div class="col-sm-12 mb-5">
                        {{ Form::hidden('gallery_id', null,['id' => 'galleryId']) }}
                    </div>
                    <div class="col-sm-12 mb-5">
                        <label
                            class="form-label required fs-6 fw-bolder text-gray-700">{{ __('messages.gallery.type').':' }}</label>
                        {{ Form::select('type', \App\Models\Gallery::TYPE,\App\Models\Gallery::TYPE_IMAGE,
                            ['class' => 'form-select form-select-solid fw-bold', 'data-control' => '', 'data-dropdown-parent' => '#editGalleryModal' ,'id'=>'editTypeId']) }}
                    </div>
                    <div class="col-sm-12 mb-5 mt-3 editImagelink">

                        <div class="mb-3" io-image-input="true">
                            <label for="editGalleryPreview"
                                   class="form-label">{{ __('messages.gallery.gallery_name').':' }}</label>
                            <div class="d-block">
                                <div class="image-picker">
                                    <div class="image previewImage" id="editGalleryPreview"
                                         style="background-image: url('{{ asset('assets/images/default_service.png') }}')"></div>
                                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                          data-placement="top" data-bs-original-title="{{__('messages.tooltip.image')}}">
                                        <label>
                                            <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                            <input type="file" id="editImage" name="image"
                                                   class="image-upload d-none" accept="image/*"/> </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-5 d-none editYouTubeLink">
                    {{ Form::label('link', __('messages.gallery.youtube').':', ['class' => 'form-label required fs-6 fw-bolder text-gray-700 mb-3']) }}
                    {{ Form::url('link', null, ['class' => 'form-control', 'placeholder' => 'https://www.youtube.com/watch?v=hAGbufevHM4','id'=>'editYouTube_Link']) }}
                </div>
                <div class="d-flex">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary me-3','id'=>'editGallerySave']) }}
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

