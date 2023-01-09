<?php ?>
@if ($partName == 'basics')
<div class="row" id="basic">
    <div class="col-lg-12 mb-7">
        {{ Form::label('url_alias', __('messages.vcard.url_alias') . ':', ['class' => 'form-label required']) }}
        <span data-bs-toggle="tooltip" data-placement="top"
            data-bs-original-title="{{ __('messages.tooltip.the_main_url') }}">
            <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
        </span>
        <div class="d-sm-flex">
            <div class="input-group-prepend mb-sm-0 mb-4">
                <div class="input-group-text form-control">
                    {{ route('vcard.defaultIndex') }}/
                </div>
            </div>
            {{ Form::text('url_alias', isset($vcard) ? $vcard->url_alias : null, ['class' => 'form-control ms-1', 'placeholder' => __('messages.form.my_vcard_url'), 'onkeypress' => 'return (event.charCode > 64 && event.charCode < 91 ) || (event.charCode >= 47 && event.charCode <= 57 ) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 45)']) }}
        </div>
    </div>
    <div class="col-lg-6 mb-7">
        {{ Form::label('name', __('messages.vcard.vcard_name') . ':', ['class' => 'form-label required']) }}
        {{ Form::text('name', isset($vcard) ? $vcard->name : null, ['class' => 'form-control', 'placeholder' => __('messages.form.vcard_name'), 'required']) }}
    </div>
    <div class="col-lg-6 mb-7">
        {{ Form::label('occupation', __('messages.vcard.occupation') . ':', ['class' => 'form-label required']) }}
        {{ Form::text('occupation', isset($vcard) ? $vcard->occupation : null, ['class' => 'form-control', 'placeholder' => __('messages.form.occupation'), 'required']) }}
    </div>
    <div class="col-lg-6 mb-7">
        {{ Form::label('description', __('messages.vcard.description') . ':', ['class' => 'form-label required']) }}
        {!! Form::textarea('description', isset($vcard) ? $vcard->description : null, [
            'class' => 'form-control',
            'placeholder' => __('messages.form.description'),
            'required',
            'rows' => '5',
        ]) !!}
    </div>
    <div class="col-lg-3 col-sm-6 mb-7">
        <div class="mb-3" io-image-input="true">
            <label for="exampleInputImage" class="form-label">{{ __('messages.vcard.profile_image') . ':' }}</label>
            <div class="d-block">
                <div class="image-picker">
                    <div class="image previewImage" id="exampleInputImage"
                        style="background-image: url({{ !empty($vcard->profile_url) ? $vcard->profile_url : asset('web/media/avatars/150-26.jpg') }})">
                    </div>
                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                        data-placement="top" data-bs-original-title="{{ __('messages.tooltip.profile') }}">
                        <label>
                            <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                            <input type="file" id="profile_image" name="profile_img" class="image-upload d-none"
                                accept="image/*" />
                        </label>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-text text-danger" id="profileImageValidationErrors"></div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-7">
        <div class="mb-3" io-image-input="true">
            <label for="exampleInputImage" class="form-label">{{ __('messages.vcard.cover_image') . ':' }}</label>
            <div class="d-block">
                <div class="image-picker">
                    <div class="image previewImage" id="exampleInputImage"
                        style="background-image: url({{ !empty($vcard->cover_url) ? $vcard->cover_url : asset('assets/images/default_cover_image.jpg') }})">
                    </div>
                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                        data-placement="top" data-bs-original-title="{{ __('messages.tooltip.cover') }}">
                        <label>
                            <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                            <input type="file" id="profile_image" name="cover_img" class="image-upload d-none"
                                accept="image/*" />
                        </label>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-text text-danger" id="coverImageValidationErrors"></div>
    </div>
    @if (isset($vcard))
        <div class="mt-5 row">
            <h4 class="fw-bolder text-gray-800 mb-5"> {{ __('messages.vcard.vcard_details') }} </h4>
            <div class="col-md-6">
                <div class="form-group mb-7">
                    {{ Form::label('first_name', __('messages.vcard.first_name') . ':', ['class' => 'form-label required']) }}
                    {{ Form::text('first_name', isset($vcard) ? $vcard->first_name : null, ['class' => 'form-control', 'placeholder' => __('messages.form.f_name'), 'required']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-7">
                    {{ Form::label('last_name', __('messages.vcard.last_name') . ':', ['class' => 'form-label required']) }}
                    {{ Form::text('last_name', isset($vcard) ? $vcard->last_name : null, ['class' => 'form-control', 'placeholder' => __('messages.form.l_name'), 'required']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-7">
                    {{ Form::label('email', __('messages.user.email') . ':', ['class' => 'form-label']) }}
                    {{ Form::text('email', isset($vcard) ? $vcard->email : null, ['class' => 'form-control', 'placeholder' => __('messages.form.email')]) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('phone', __('messages.user.phone') . ':', ['class' => 'form-label']) }}
                    {{ Form::text('phone', isset($vcard) ? (isset($vcard->region_code) ? '+' . $vcard->region_code . '' . $vcard->phone : $vcard->phone) : null, ['class' => 'form-control', 'placeholder' => __('messages.form.phone'), 'id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
                    {{ Form::hidden('region_code', isset($vcard) ? $vcard->region_code : null, ['id' => 'prefix_code']) }}
                    <div class="mt-2">
                        <span id="valid-msg" class="text-success d-none fw-400 fs-small mt-2">Valid Number</span>
                        <span id="error-msg" class="text-danger d-none fw-400 fs-small mt-2">Invalid Number</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-7">
                    {{ Form::label('alternative_email', __('messages.vcard.alternative_email') . ':', ['class' => 'form-label']) }}
                    {{ Form::text('alternative_email', isset($vcard) ? $vcard->alternative_email : null, ['class' => 'form-control', 'placeholder' => __('messages.form.alternative_email')]) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('alternative_phone', __('messages.vcard.alternative_phone') . ':', ['class' => 'form-label']) }}
                    {{ Form::text('alternative_phone', isset($vcard) ? (isset($vcard->alternative_region_code) ? '+' . $vcard->alternative_region_code . '' . $vcard->alternative_phone : $vcard->alternative_phone) : null, ['class' => 'form-control', 'placeholder' => __('messages.form.alternative_phone'), 'id' => 'alternative_phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
                    {{ Form::hidden('alternative_region_code', isset($vcard) ? $vcard->alternative_region_code : null, ['id' => 'alternative_prefix_code']) }}
                    <div class="mt-2">
                        <span id="valid-msg1" class="text-success d-none fw-400 fs-small mt-2">Valid Number</span>
                        <span id="error-msg1" class="text-danger d-none fw-400 fs-small mt-2">Invalid Number</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-7">
                    {{ Form::label('location', __('messages.user.location') . ':', ['class' => 'form-label']) }}
                    {{ Form::textarea('location', isset($vcard) ? $vcard->location : null, ['class' => 'form-control', 'placeholder' => __('messages.form.location'), 'rows' => '1']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-7">
                    {{ Form::label('location_url', __('messages.setting.location_url') . ':', ['class' => 'form-label']) }}
                    {{ Form::text('location_url', isset($vcard) ? $vcard->location_url : null, ['class' => 'form-control', 'placeholder' => __('messages.form.location_url')]) }}
                </div>
            </div>
            <div class="col-lg-6 mb-7">
                {{ Form::label('dob', __('messages.vcard.date_of_birth') . ':', ['class' => 'form-label']) }}
                {{ Form::text('dob', isset($vcard) ? $vcard->dob : null, ['class' => 'form-control bg-white', 'placeholder' => __('messages.form.DOB')]) }}
            </div>

            <div class="col-lg-6 mb-7">
                <div class="d-flex">
                    {{ Form::label('default_language', __('messages.setting.default_language') . ':', ['class' => 'form-label']) }}

                </div>
                <div class="form-group">

                    {{ Form::select('default_language', getAllLanguage(), isset($vcard) ? $vcard->default_language : null, ['class' => 'form-control', 'data-control' => 'select2']) }}
                </div>
            </div>
            <div class="col-lg-6 mb-7">
                <div class="d-flex">
                    {{ Form::label('language_enable', __('messages.vcard.language_enable') . ':', ['class' => 'form-label']) }}
                    <div class="mx-4">
                        <div
                            class="form-check form-switch form-check-custom form-check-solid form-switch-sm col-6">
                            <div class="fv-row d-flex align-items-center">
                                {{ Form::checkbox('language_enable', 1, $vcard['language_enable'] ?? 0, ['class' => 'form-check-input mt-0 ', 'id' => 'languageEnable']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="d-flex">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
        <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
    </div>
</div>
@endif

@if ($partName == 'templates')
    <div class="col-lg-12 mb-3">
        <input type="hidden" name="part" value="{{ $partName }}">
        <label class="form-label required">{{ __('messages.vcard.select_template') }}
            :</label>
    </div>
    <div class="form-group mb-7 vcard-template">
        <div class="row">
            <input type="hidden" name="template_id" id="templateId" value="{{ $vcard->template_id }}">
            @foreach ($templates as $id => $url)
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-3">
                    <div class="img-radio img-thumbnail {{ $vcard->template_id == $id ? 'img-border' : '' }}"
                        data-id="{{ $id }}">
                        <img src="{{ $url }}" alt="Template">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-lg-12 mt-5 mb-5">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="vcardTemplateStatus" name="status"
                {{ $vcard->status ? 'checked' : '' }}>
            <label class="form-check-label" for="vcardTemplateStatus">
                {{ __('messages.common.active') }}
            </label>
        </div>
    </div>
    <div class="col-lg-12 mt-2 d-flex">
        <button class="btn btn-primary me-3 template-save">
            {{ __('messages.common.save') }}
        </button>
        <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
    </div>
@endif

@if ($partName === 'business_hours')
    <div class="row">
        <input type="hidden" name="part" value="{{ $partName }}">
        @foreach (\App\Models\BusinessHour::DAY_OF_WEEK as $key => $day)
            <div class="col-xxl-6 mb-7 d-sm-flex align-items-center mb-3">
                <div class="col-xl-4 col-lg-4 col-md-2 col-4">
                    <label class="form-check">
                        <input class="form-check-input feature mx-2" type="checkbox" value="{{ $key }}"
                            name="days[]" {{ !empty($hours[$key]) ? 'checked' : '' }} />
                        {{ strtoupper(__('messages.business.' . $day)) }}
                    </label>
                </div>
                <div class="col-xl-8 col-lg-3 col-3 d-flex align-items-center buisness_end">
                    <div class="d-inline-block">
                        {{ Form::select('startTime[' . $key . ']', getSchedulesTimingSlot(), isset($hours[$key]) ? $hours[$key]['start_time'] : null, ['class' => 'form-control', 'data-control' => 'select2']) }}
                    </div>
                    <span class="px-3">To</span>
                    <div class="d-inline-block">
                        {{ Form::select('endTime[' . $key . ']', getSchedulesTimingSlot(), isset($hours[$key]) ? $hours[$key]['end_time'] : null, ['class' => 'form-control', 'data-control' => 'select2']) }}
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-lg-12 mt-2 d-flex">
            <button class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}" class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
@endif

@if ($partName == 'appointments')
    <div class="col-12">
        <table class="table table-striped mt-lg-4">
            <tbody>
                <input type="hidden" name="part" value="{{ $partName }}">
                @foreach (App\Models\BusinessHour::WEEKDAY_NAME as $day => $shortWeekDay)
                    <tr>
                        <td>
                            <div class="weekly-content" data-day="{{ $day }}">
                                <div class="d-flex w-100 align-items-center position-relative">
                                    <div class="d-flex row flex-md-row flex-column w-100 weekly-row">
                                        <div class="col-xl-2 form-check mb-0 d-flex align-items-center ms-5">
                                            <input id="chkShortWeekDay_{{ $shortWeekDay }}" class="form-check-input"
                                                type="checkbox" value="{{ $day }}"
                                                name="checked_week_days[]" {{ !empty($time[$day]) ? 'checked' : '' }}>
                                            <label class="form-label mb-0 me-2"
                                                for="chkShortWeekDay_{{ $shortWeekDay }}">
                                                <span
                                                    class="ms-4 d-md-block">{{ strtoupper(__('messages.business.' . strtolower($shortWeekDay))) }}</span>
                                            </label>
                                        </div>
                                        <div class="col-xl-8 session-times">
                                            @include('vcards.appointment.slot', ['day' => $day])
                                        </div>
                                    </div>
                                    <div class="weekly-icon position-absolute end-0 d-flex">
                                        <a href="javascript:void(0)" class="add-session-time"
                                            id="add-session-{{ $day }}" data-day="{{ $day }}"
                                            data-bs-toggle="tooltip" title="{{ __('messages.common.add') }}">
                                            <i class="fa fa-plus text-primary me-5 fs-2 mb-3" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (getUserSettingValue('stripe_enable', getLogInUserId()) ||
            getUserSettingValue('paypal_enable', getLogInUserId()))
            <div class="weekly-icon end-0 d-flex py-4 px-0 ">
                @if (isset($appointmentDetail->is_paid))
                    <button type="button"
                        class="btn me-3 {{ $appointmentDetail->is_paid == 0 ? 'btn-primary' : 'btn-light btn-active-light-primary' }}"
                        id="freeButton">{{ __('messages.appointment.free') }}</button>
                    <button type="button"
                        class="btn me-3 {{ $appointmentDetail->is_paid == 1 ? 'btn-primary' : 'btn-light btn-active-light-primary' }}"
                        id="paidButton">{{ __('messages.appointment.paid') }}</button>
                    <input type="hidden" id="isUserPaidId" name="is_paid"
                        value="{{ $appointmentDetail->is_paid }}">
                @else
                    <button type="button" class="btn me-3 btn-primary"
                        id="freeButton">{{ __('messages.appointment.free') }}</button>
                    <button type="button" class="btn me-3 btn-light btn-active-light-primary"
                        id="paidButton">{{ __('messages.appointment.paid') }}</button>
                    <input type="hidden" id="isUserPaidId" name="is_paid" value="0">
                @endif
            </div>
            <div class="card-body px-0 pt-0">
                <div class="row {{ isset($appointmentDetail->is_paid) && $appointmentDetail->is_paid == 1 ? '' : 'd-none' }}"
                    id="userPaidInputDiv">
                    <div class="col-12">
                        <div class="row">
                            <div class="form-group col-sm-6 px-3">
                                {{ Form::label('price', __('messages.subscription.amount') . ':', ['class' => 'form-label required']) }}
                                @if (isset($appointmentDetail))
                                    {{ Form::number('price', $appointmentDetail->price, ['class' => 'form-control', $appointmentDetail->is_paid == 1 ? 'required' : '', 'id' => 'userPaymentAmount', 'placeholder' => __('messages.subscription.amount')]) }}
                                @else
                                    {{ Form::number('price', null, ['class' => 'form-control', 'id' => 'userPaymentAmount', 'placeholder' => __('Amount'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
    </div>
@endif

@if ($partName == 'social_links')
    <div class="row">
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fa fa-globe-africa fa-2x text-dark mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('website', isset($socialLink) ? $socialLink->website : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.website'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-twitter fa-2x text-primary mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('twitter', isset($socialLink) ? $socialLink->twitter : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.twitter'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-facebook-square fa-2x text-primary mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('facebook', isset($socialLink) ? $socialLink->facebook : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.facebook'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-instagram fa-2x text-danger mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('instagram', isset($socialLink) ? $socialLink->instagram : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.instagram'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-reddit-alien fa-2x text-danger mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('reddit', isset($socialLink) ? $socialLink->reddit : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.reddit'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-tumblr-square fa-2x text-dark mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('tumblr', isset($socialLink) ? $socialLink->tumblr : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.tumblr'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-youtube fa-2x text-danger mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('youtube', isset($socialLink) ? $socialLink->youtube : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.youtube'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-linkedin fa-2x text-primary mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('linkedin', isset($socialLink->linkedin) ? $socialLink->linkedin : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.linkedin'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-whatsapp fa-2x text-success mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('whatsapp', isset($socialLink) ? $socialLink->whatsapp : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.whatsapp'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-pinterest fa-2x text-danger mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('pinterest', isset($socialLink) ? $socialLink->pinterest : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.pinterest'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-7">
            <div class="row">
                <div class="col-sm-1 mb-3 mb-sm-0">
                    <i class="fab fa-tiktok fa-2x text-danger mt-3 me-3"></i>
                </div>
                <div class="col-sm-11">
                    {!! Form::text('tiktok', isset($socialLink) ? $socialLink->tiktok : null, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.form.tiktok'),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
    </div>
@endif

@if ($partName == 'advanced')
    <div class="row">
        <input type="hidden" name="part" value="{{ $partName }}">
        @if (checkFeatureVcard('advanced')->password)
            <div class="col-lg-6 mb-7">
                <label class="form-label">{{ __('messages.user.password') . ':' }}</label>
                <div class="position-relative mb-3">
                    <div class="mb-3 position-relative">
                        <input class="form-control" type="password"
                            placeholder="{{ __('messages.form.password') }}" name="password"
                            value="{{ !empty($vcard->password) ? Crypt::decrypt($vcard->password) : '' }}"
                            autocomplete="off" aria-label="Password" data-toggle="password" />
                        <span
                            class="position-absolute d-flex align-items-center top-0 bottom-0 end-0 me-4 input-icon input-password-hide cursor-pointer text-gray-600">
                            <i class="bi bi-eye-slash-fill"></i>
                        </span>
                    </div>
                    <div class="d-flex align-items-center mb-3"></div>
                </div>
            </div>
        @endif

        @if (checkFeatureVcard('advanced')->custom_css)
            <div class="col-lg-12 mb-7">
                {{ Form::label('custom_css', __('messages.vcard.custom_css') . ':', ['class' => 'form-label']) }}
                {{ Form::textarea('custom_css', isset($vcard) ? $vcard->custom_css : null, ['class' => 'form-control', 'placeholder' => __('messages.form.css'), 'rows' => '5']) }}
            </div>
        @endif

        @if (checkFeatureVcard('advanced')->custom_js)
            <div class="col-lg-12 mb-7">
                {{ Form::label('custom_js', __('messages.vcard.custom_js') . ':', ['class' => 'form-label']) }}
                {{ Form::textarea('custom_js', isset($vcard) ? $vcard->custom_js : null, ['class' => 'form-control', 'placeholder' => __('messages.form.js'), 'rows' => '5']) }}
            </div>
        @endif

        @if (checkFeatureVcard('advanced')->hide_branding)
            <div class="col-lg-6 mb-7">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="branding" name="branding"
                        {{ $vcard->branding ? 'checked' : '' }}>
                    <label class="form-label" for="branding">
                        {{ __('messages.vcard.remove_branding') }}
                    </label>
                    <span data-bs-toggle="tooltip" data-placement="top"
                        data-bs-original-title="{{ __('messages.tooltip.remove_branding') }}">
                        <i class="fas fa-question-circle ml-1 mt-1 general-question-mark"></i>
                    </span>
                </div>
            </div>
        @endif

        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
    </div>
@endif

@if ($partName == 'custom_fonts')
    <div class="row">
        <div class="col-lg-6 mb-7">
            {{ Form::label('font_family', __('messages.font.font_family') . ':', ['class' => 'form-label']) }}
            {{ Form::select(
                'font_family',
                \App\Models\Vcard::FONT_FAMILY,
                \App\Models\Vcard::FONT_FAMILY[$vcard->font_family],
                ['class' => 'form-select', 'data-control' => 'select2'],
            ) }}
        </div>
        <div class="col-lg-6 mb-7">
            {!! Form::label('font_size', __('messages.font.font_size') . ':', ['class' => 'form-label']) !!}

            {!! Form::number('font_size', $vcard->font_size, [
                'class' => 'form-control',
                'min' => '14',
                'max' => '40',
                'placeholder' => __('messages.font.font_size_in_px'),
            ]) !!}
        </div>
        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
@endif

@if ($partName == 'seo')
    <div class="row">
        <div class="col-lg-6 mb-7">
            {{ Form::label('Site title', __('messages.vcard.site_title') . ':', ['class' => 'form-label']) }}
            {{ Form::text('site_title', isset($vcard) ? $vcard->site_title : null, ['class' => 'form-control', 'placeholder' => __('messages.form.site_title')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Home title', __('messages.vcard.home_title') . ':', ['class' => 'form-label']) }}
            {{ Form::text('home_title', isset($vcard) ? $vcard->home_title : null, ['class' => 'form-control', 'placeholder' => __('messages.form.home_title')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Meta keyword', __('messages.vcard.meta_keyword') . ':', ['class' => 'form-label']) }}
            {{ Form::text('meta_keyword', isset($vcard) ? $vcard->meta_keyword : null, ['class' => 'form-control', 'placeholder' => __('messages.form.meta_keyword')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Meta Description', __('messages.vcard.meta_description') . ':', ['class' => 'form-label']) }}
            {{ Form::text('meta_description', isset($vcard) ? $vcard->meta_description : null, ['class' => 'form-control', 'placeholder' => __('messages.form.meta_description')]) }}
        </div>
        <div class="col-lg-12 mb-7">
            {{ Form::label('Google Analytics', __('messages.vcard.google_analytics') . ':', ['class' => 'form-label']) }}
            {{ Form::textarea('google_analytics', isset($vcard) ? $vcard->google_analytics : null, ['class' => 'form-control', 'placeholder' => __('messages.form.google_analytics')]) }}
        </div>
        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
@endif

@if ($partName == 'privacy_policy')
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-5">
                <input type="hidden" name="part" value="{{ $partName }}" id="privacyPolicyPartName">
                {{ Form::hidden('id', isset($privacyPolicy) ? $privacyPolicy->id : null, ['id' => 'privacyPolicyId']) }}
                {{ Form::label('privacy_policy', __('messages.setting.privacy&policy') . ':', ['class' => 'form-label required']) }}
                <div id="privacyPolicyQuill" class="editor-height" style="height: 200px"></div>
                {{ Form::hidden('privacy_policy', isset($privacyPolicy) ? $privacyPolicy->privacy_policy : null, ['id' => 'privacyData']) }}
            </div>
        </div>
        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
    </div>
@endif

@if ($partName == 'term_condition')
    <div class="row">
        <input type="hidden" name="part" value="{{ $partName }}" id="termConditionPartName">
        <div class="col-lg-12">
            <div class="mb-5">
                {{ Form::hidden('id', isset($termCondition) ? $termCondition->id : null, ['id' => 'termConditionId']) }}
                {{ Form::label('term_condition', __('messages.vcard.term_condition') . ':', ['class' => 'form-label required']) }}
                <div id="termConditionQuill" class="editor-height" style="height: 200px"></div>
                {{ Form::hidden('term_condition', isset($termCondition) ? $termCondition->term_condition : null, ['id' => 'conditionData']) }}
            </div>
        </div>
        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
    </div>
@endif


@if ($partName == 'registration_custom_idea')
    <div class="row">
        <div class="col-lg-6 mb-7">
            {{ Form::label('Address', __('messages.vcard.registration_address') . ':', ['class' => 'form-label']) }}
            {{ Form::text('registration_address', isset($vcard) ? $vcard->registration_address : null, ['class' => 'form-control', 'placeholder' => __('messages.form.registration_address'), 'required']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Chassis No.', __('messages.vcard.registration_chassis_no') . ':', ['class' => 'form-label']) }}
            {{ Form::text('registration_chassis_no', isset($vcard) ? $vcard->registration_chassis_no : null, ['class' => 'form-control', 'placeholder' => __('messages.form.registration_chassis_no')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Vin No.', __('messages.vcard.registration_vin_no') . ':', ['class' => 'form-label']) }}
            {{ Form::text('registration_vin_no', isset($vcard) ? $vcard->registration_vin_no : null, ['class' => 'form-control', 'placeholder' => __('messages.form.registration_vin_no')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Vehicle Model', __('messages.vcard.registration_vehicle_model') . ':', ['class' => 'form-label']) }}
            {{ Form::text('registration_vehicle_model', isset($vcard) ? $vcard->registration_vehicle_model : null, ['class' => 'form-control', 'placeholder' => __('messages.form.registration_vehicle_model')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Vehicle Color', __('messages.vcard.registration_vehicle_color') . ':', ['class' => 'form-label']) }}
            {{ Form::text('registration_vehicle_color', isset($vcard) ? $vcard->registration_vehicle_color : null, ['class' => 'form-control', 'placeholder' => __('messages.form.registration_vehicle_color')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Vehicle Year', __('messages.vcard.registration_vehicle_year') . ':', ['class' => 'form-label']) }}
            {{ Form::text('registration_vehicle_year', isset($vcard) ? $vcard->registration_vehicle_year : null, ['class' => 'form-control datepicker', 'placeholder' => __('messages.form.registration_vehicle_year')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Plate No.', __('messages.vcard.registration_plate_no') . ':', ['class' => 'form-label']) }}
            {{ Form::text('registration_plate_no', isset($vcard) ? $vcard->registration_plate_no : null, ['class' => 'form-control', 'placeholder' => __('messages.form.registration_plate_no')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Country', __('messages.vcard.registration_country') . ':', ['class' => 'form-label required']) }}
            {{ Form::select('registration_country', getCountry(), isset($vcard) ? $vcard->registration_country : null, ['id' => 'registration_country', 'class' => 'form-select', 'required', 'placeholder' => __('messages.form.select_country'), 'data-control' => 'select2']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('State', __('messages.vcard.registration_state') . ':', ['class' => 'form-label required']) }}
            {{ Form::select('registration_state', [], isset($vcard) ? $vcard->registration_state : null, ['id' => 'registration_state', 'class' => 'form-select', 'required', 'placeholder' => __('messages.form.select_state'), 'data-control' => 'select2']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('City', __('messages.vcard.registration_city') . ':', ['class' => 'form-label required']) }}
            {{ Form::select('registration_city', [], isset($vcard) ? $vcard->registration_city : null, ['id' => 'registration_city', 'class' => 'form-select', 'required', 'placeholder' => __('messages.form.select_city'), 'data-control' => 'select2']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('District', __('messages.vcard.registration_district') . ':', ['class' => 'form-label']) }}
            {{ Form::text('registration_district', isset($vcard) ? $vcard->registration_district : null, ['class' => 'form-control', 'placeholder' => __('messages.form.registration_district')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Emergency Contact No.', __('messages.vcard.registration_emergency_contact_no') . ':', ['class' => 'form-label']) }}
            {{ Form::text('registration_emergency_contact_no', isset($vcard) ? $vcard->registration_emergency_contact_no : null, ['class' => 'form-control', 'placeholder' => __('messages.form.registration_emergency_contact_no')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('AR No.', __('messages.vcard.registration_ar_no') . ':', ['class' => 'form-label']) }}
            {{ Form::text('registration_ar_no', isset($vcard) ? $vcard->registration_ar_no : null, ['class' => 'form-control', 'placeholder' => __('messages.form.registration_ar_no')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('PCN no.', __('messages.vcard.registration_pcn_no') . ':', ['class' => 'form-label']) }}
            {{ Form::text('registration_pcn_no', isset($vcard) ? $vcard->registration_pcn_no : null, ['class' => 'form-control', 'placeholder' => __('messages.form.registration_pcn_no')]) }}
        </div>

        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
@endif

@if ($partName == 'inspection_custom_idea')
    <div class="row">
        <div class="col-lg-6 mb-7">
            {{ Form::label('Address', __('messages.vcard.inspection_address') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_address', isset($vcard) ? $vcard->inspection_address : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_address'), 'required']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Chassis No.', __('messages.vcard.inspection_chassis_no') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_chassis_no', isset($vcard) ? $vcard->inspection_chassis_no : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_chassis_no')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Vin No.', __('messages.vcard.inspection_vin_no') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_vin_no', isset($vcard) ? $vcard->inspection_vin_no : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_vin_no')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Vehicle Model', __('messages.vcard.inspection_vehicle_model') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_vehicle_model', isset($vcard) ? $vcard->inspection_vehicle_model : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_vehicle_model')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Vehicle Color', __('messages.vcard.inspection_vehicle_color') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_vehicle_color', isset($vcard) ? $vcard->inspection_vehicle_color : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_vehicle_color')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Vehicle Year', __('messages.vcard.inspection_vehicle_year') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_vehicle_year', isset($vcard) ? $vcard->inspection_vehicle_year : null, ['class' => 'form-control datepicker', 'placeholder' => __('messages.form.inspection_vehicle_year')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Plate No.', __('messages.vcard.inspection_plate_no') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_plate_no', isset($vcard) ? $vcard->inspection_plate_no : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_plate_no')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Contact', __('messages.vcard.inspection_contact') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_contact', isset($vcard) ? $vcard->inspection_contact : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_contact')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('AR No.', __('messages.vcard.inspection_ar_no') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_ar_no', isset($vcard) ? $vcard->inspection_ar_no : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_ar_no')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Country', __('messages.vcard.inspection_country') . ':', ['class' => 'form-label required']) }}
            {{ Form::select('inspection_country', getCountry(), isset($vcard) ? $vcard->inspection_country : null, ['id' => 'inspection_country', 'class' => 'form-select', 'required', 'placeholder' => __('messages.form.select_country'), 'data-control' => 'select2']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('State', __('messages.vcard.inspection_state') . ':', ['class' => 'form-label required']) }}
            {{ Form::select('inspection_state', [], isset($vcard) ? $vcard->inspection_state : null, ['id' => 'inspection_state', 'class' => 'form-select', 'required', 'placeholder' => __('messages.form.select_state'), 'data-control' => 'select2']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('City', __('messages.vcard.inspection_city') . ':', ['class' => 'form-label required']) }}
            {{ Form::select('inspection_city', [], isset($vcard) ? $vcard->inspection_city : null, ['id' => 'inspection_city', 'class' => 'form-select', 'required', 'placeholder' => __('messages.form.select_city'), 'data-control' => 'select2']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('District', __('messages.vcard.inspection_district') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_district', isset($vcard) ? $vcard->inspection_district : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_district')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Control Technique', __('messages.vcard.inspection_control_technique') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_control_technique', isset($vcard) ? $vcard->inspection_control_technique : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_control_technique')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Date of Inspection', __('messages.vcard.inspection_date_of_inspection') . ':', ['class' => 'form-label']) }}
            {{ Form::date('inspection_date_of_inspection', isset($vcard) ? $vcard->inspection_date_of_inspection : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_date_of_inspection')]) }}
        </div>

        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
@endif

@if ($partName == 'inspection_custom_idea_new')
    <div class="row">
        <div class="col-lg-6 mb-7">
            {{ Form::label('Address', __('messages.vcard.inspection_address_new') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_address_new', isset($vcard) ? $vcard->inspection_address_new : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_address_new'), 'required']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Chassis No.', __('messages.vcard.inspection_chassis_no_new') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_chassis_no_new', isset($vcard) ? $vcard->inspection_chassis_no_new : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_chassis_no_new')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Vin No.', __('messages.vcard.inspection_vin_no_new') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_vin_no_new', isset($vcard) ? $vcard->inspection_vin_no_new : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_vin_no_new')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Vehicle Model', __('messages.vcard.inspection_vehicle_model_new') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_vehicle_model_new', isset($vcard) ? $vcard->inspection_vehicle_model_new : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_vehicle_model_new')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Vehicle Color', __('messages.vcard.inspection_vehicle_color_new') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_vehicle_color_new', isset($vcard) ? $vcard->inspection_vehicle_color_new : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_vehicle_color_new')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Vehicle Year', __('messages.vcard.inspection_vehicle_year_new') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_vehicle_year_new', isset($vcard) ? $vcard->inspection_vehicle_year_new : null, ['class' => 'form-control datepicker', 'placeholder' => __('messages.form.inspection_vehicle_year_new')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Plate No.', __('messages.vcard.inspection_plate_no_new') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_plate_no_new', isset($vcard) ? $vcard->inspection_plate_no_new : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_plate_no_new')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Contact', __('messages.vcard.inspection_contact_new') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_contact_new', isset($vcard) ? $vcard->inspection_contact_new : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_contact_new')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('AR No.', __('messages.vcard.inspection_ar_no_new') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_ar_no_new', isset($vcard) ? $vcard->inspection_ar_no_new : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_ar_no_new')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Country', __('messages.vcard.inspection_country_new') . ':', ['class' => 'form-label required']) }}
            {{ Form::select('inspection_country_new', getCountry(), isset($vcard) ? $vcard->inspection_country_new : null, ['id' => 'inspection_country_new', 'class' => 'form-select', 'required', 'placeholder' => __('messages.form.select_country'), 'data-control' => 'select2']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('State', __('messages.vcard.inspection_state_new') . ':', ['class' => 'form-label required']) }}
            {{ Form::select('inspection_state_new', [], isset($vcard) ? $vcard->inspection_state_new : null, ['id' => 'inspection_state_new', 'class' => 'form-select', 'required', 'placeholder' => __('messages.form.select_state'), 'data-control' => 'select2']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('City', __('messages.vcard.inspection_city_new') . ':', ['class' => 'form-label required']) }}
            {{ Form::select('inspection_city_new', [], isset($vcard) ? $vcard->inspection_city_new : null, ['id' => 'inspection_city_new', 'class' => 'form-select', 'required', 'placeholder' => __('messages.form.select_city'), 'data-control' => 'select2']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('District', __('messages.vcard.inspection_district_new') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_district_new', isset($vcard) ? $vcard->inspection_district_new : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_district_new')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Control Technique', __('messages.vcard.inspection_control_technique_new') . ':', ['class' => 'form-label']) }}
            {{ Form::text('inspection_control_technique_new', isset($vcard) ? $vcard->inspection_control_technique_new : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_control_technique_new')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Date of Inspection', __('messages.vcard.inspection_date_of_inspection_new') . ':', ['class' => 'form-label']) }}
            {{ Form::date('inspection_date_of_inspection_new', isset($vcard) ? $vcard->inspection_date_of_inspection_new : null, ['class' => 'form-control', 'placeholder' => __('messages.form.inspection_date_of_inspection_new')]) }}
        </div>

        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
@endif
@if ($partName == 'custom_id')
<div class="row">
    <div class="col-lg-6 mb-7">
        {{ Form::label('nationality', __('messages.vcard.nationality') . ':', ['class' => 'form-label required']) }}
        {{ Form::text('nationality', isset($vcard) ? $vcard->nationality : null, ['class' => 'form-control', 'placeholder' => __('messages.form.nationality'), 'required']) }}
    </div>
    <div class="col-lg-6 mb-7">
        {{ Form::label('footer_text', __('messages.vcard.footer_text') . ':', ['class' => 'form-label required']) }}
        {!! Form::textarea('footer_text', isset($vcard) ? $vcard->footer_text : null, [
            'class' => 'form-control',
            'placeholder' => __('messages.form.footer_text'),
            'required',
            'rows' => '5',
        ]) !!}
    </div>
    <div class="col-lg-6 mb-7">
        {{ Form::label('issue_date', __('messages.vcard.issue_date') . ':', ['class' => 'form-label']) }}
        {{ Form::text('issue_date', isset($vcard) ? $vcard->issue_date : null, ['class' => 'form-control bg-white', 'placeholder' => __('messages.form.issue_date')]) }}
    </div>
    <div class="col-lg-6 mb-7">
        {{ Form::label('expire_date', __('messages.vcard.expire_date') . ':', ['class' => 'form-label']) }}
        {{ Form::text('expire_date', isset($vcard) ? $vcard->expire_date : null, ['class' => 'form-control bg-white', 'placeholder' => __('messages.form.expire_date')]) }}
    </div>
    <div class="col-lg-6 mb-7">
        {{ Form::label('company', __('messages.vcard.company') . ':', ['class' => 'form-label']) }}
        {{ Form::text('company', isset($vcard) ? $vcard->company : null, ['class' => 'form-control', 'placeholder' => __('messages.form.company')]) }}
    </div>

    <div class="col-lg-6 mb-7">
        {{ Form::label('hair_color', __('messages.vcard.hair_color') . ':', ['class' => 'form-label']) }}
        {{ Form::text('hair_color', isset($vcard) ? $vcard->hair_color : null, ['class' => 'form-control', 'placeholder' => __('messages.form.hair_color')]) }}
    </div>
    {{--  <div class="col-md-6">
        <div class="form-group mb-7">
            {{ Form::label('made_by_url', __('messages.vcard.made_by_url') . ':', ['class' => 'form-label required']) }}
            {{ Form::text('made_by_url', isset($vcard) ? $vcard->made_by_url : null, ['class' => 'form-control', 'placeholder' => __('messages.form.made_by_url'), '']) }}
        </div>
    </div>  --}}
    <div class="col-md-6">
        <div class="form-group mb-7">
            {{ Form::label('eye_color', __('messages.vcard.eye_color') . ':', ['class' => 'form-label']) }}
            {{ Form::text('eye_color', isset($vcard) ? $vcard->eye_color : null, ['class' => 'form-control', 'placeholder' => __('messages.form.eye_color'), '']) }}
        </div>
    </div>
    <div class="col-lg-6 mb-7">
        <div class="d-flex">
            {{ Form::label('sex', __('messages.vcard.sex') . ':', ['class' => 'form-label']) }}

        </div>
        <div class="form-group">

            {{ Form::select('sex', ['Male'=>'male', "Female"=>'Female', 'Other'=>'Other'], isset($vcard) ? $vcard->sex : null, ['class' => 'form-control', 'data-control' => 'select2']) }}
        </div>
    </div>
    <div class="col-lg-6 mb-7">
        <div class="d-flex">
            {{ Form::label('type', __('messages.vcard.type') . ':', ['class' => 'form-label']) }}

        </div>
        <div class="form-group">

            {{ Form::select('type', ['A'=>'A', 'B'=>'B', 'AB'=>'AB', 'O'=>'O'], isset($vcard) ? $vcard->type : null, ['class' => 'form-control', 'data-control' => 'select2']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-7">
            {{ Form::label('height', __('messages.vcard.height') . ':', ['class' => 'form-label']) }}
            {{ Form::text('height', isset($vcard) ? $vcard->height : null, ['class' => 'form-control', 'placeholder' => __('messages.form.height'), '']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-7">
            {{ Form::label('weight', __('messages.vcard.weight') . ':', ['class' => 'form-label']) }}
            {{ Form::text('weight', isset($vcard) ? $vcard->weight : null, ['class' => 'form-control', 'placeholder' => __('messages.form.weight'), '']) }}
        </div>
    </div>
    <div class="col-lg-6 mb-7">
        {{ Form::label('rstr', __('messages.vcard.rstr') . ':', ['class' => 'form-label']) }}
        {{ Form::text('rstr', isset($vcard) ? $vcard->rstr : null, ['class' => 'form-control', 'placeholder' => __('messages.form.rstr')]) }}
    </div>
    <div class="col-lg-6 mb-7">
        <div class="d-flex">
            {{ Form::label('comercial', __('messages.vcard.comercial') . ':', ['class' => 'form-label']) }}

        </div>
        <div class="form-group">
            {{ Form::select('comercial', ['Comercial'=>'Comercial', "Non Comercial"=>'Non Comercial'], isset($vcard) ? $vcard->comercial : null, ['class' => 'form-control', 'data-control' => 'select2']) }}
        </div>
    </div>
    <div class="col-lg-6 mb-7">
        {{ Form::label('dd', __('messages.vcard.dd') . ':', ['class' => 'form-label']) }}
        {{ Form::text('dd', isset($vcard) ? $vcard->dd : null, ['class' => 'form-control', 'placeholder' => __('messages.form.dd')]) }}
    </div>
    <div class="col-lg-6 mb-7">
        <div class="d-flex">
            {{ Form::label('category', __('messages.vcard.category') . ':', ['class' => 'form-label']) }}

        </div>
        <div class="form-group">

            {{ Form::select('category', ['A'=>'A', 'B'=>'B', 'C'=>'C', 'D'=>'D', 'E'=>'E'], isset($vcard) ? $vcard->category : null, ['class' => 'form-control', 'data-control' => 'select2']) }}
        </div>
    </div>
    <div class="col-lg-6 mb-7">
        {{ Form::label('address', __('messages.vcard.address') . ':', ['class' => 'form-label']) }}
        {!! Form::textarea('address', isset($vcard) ? $vcard->address : null, [
            'class' => 'form-control',
            'placeholder' => __('messages.form.address'),
            '',
            'rows' => '5',
        ]) !!}
    </div>

    <div class="col-lg-12">
        <h4 class="text-danger mb-4">ID Back SIDE</h4>
    </div>
    <div class="col-lg-3 col-sm-6 mb-7">
        <div class="mb-3" io-image-input="true">
            <label for="exampleInputIDBack" class="form-label">{{ __('messages.vcard.id_back').':' }}</label>
            <div class="d-block">
                <div class="image-picker">
                    <div class="image previewImage" id="exampleInputIDBack"
                         style="background-image: url({{ !empty($vcard->id_back) ? $vcard->id_back : "" }})"></div>
                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                          data-placement="top" data-bs-original-title="{{__('messages.tooltip.id_back')}}">
                                <label>
                                <i class="fa-solid fa-pen" id="idBackIcon"></i>
                                    <input type="file" id="id_back" name="id_back"
                                           class="image-upload d-none" accept="image/*"/>
                                </label>
                            </span>
                </div>
            </div>
        </div>
        <div class="form-text text-danger" id="idBackValidationErrors"></div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-7">
        <div class="mb-3" io-image-input="true">
            <label for="exampleInputIDBack2" class="form-label">{{ __('messages.vcard.id_back2').':' }}</label>
            <div class="d-block">
                <div class="image-picker">
                    <div class="image previewImage" id="exampleInputIDBack2"
                         style="background-image: url({{ !empty($vcard->id_back2) ? $vcard->id_back2 : "" }})"></div>
                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                          data-placement="top" data-bs-original-title="{{__('messages.tooltip.id_back2')}}">
                                <label>
                                <i class="fa-solid fa-pen" id="idBack2Icon"></i>
                                    <input type="file" id="id_back2" name="id_back2"
                                           class="image-upload d-none" accept="image/*"/>
                                </label>
                            </span>
                </div>
            </div>
        </div>
        <div class="form-text text-danger" id="idBack2ValidationErrors"></div>
    </div>
    {{--  <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-7">
                    {{ Form::label('barcode_url', __('messages.vcard.barcode_url') . ':', ['class' => 'form-label required']) }}
                    {{ Form::text('barcode_url', isset($vcard) ? $vcard->barcode_url : null, ['class' => 'form-control', 'placeholder' => __('messages.form.barcode_url'), '']) }}
                </div>
            </div>
            <div class="col-md-6 mb-7">
                {{ Form::label('qrcode_url', __('messages.vcard.qrcode_url') . ':', ['class' => 'form-label']) }}
                {{ Form::text('qrcode_url', isset($vcard) ? $vcard->qrcode_url : null, ['class' => 'form-control', 'placeholder' => __('messages.form.qrcode_url')]) }}
            </div>
            <div class="col-lg-6 col-sm-6 mb-7">
                <div class="mb-3" io-image-input="true">
                    <label for="exampleInputBarcode" class="form-label">{{ __('messages.vcard.barcode').':' }}</label>
                    <div class="d-block">
                        <div class="image-picker">
                            <div class="image previewImage" id="exampleInputBarcode"
                                 style="background-image: url({{ !empty($vcard->barcode) ? $vcard->barcode : "" }})"></div>
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                  data-placement="top" data-bs-original-title="{{__('messages.tooltip.barcode')}}">
                                        <label>
                                        <i class="fa-solid fa-pen" id="barcodeIcon"></i>
                                            <input type="file" id="barcode" name="barcode"
                                                   class="image-upload d-none" accept="image/*"/>
                                        </label>
                                    </span>
                        </div>
                    </div>
                </div>
                <div class="form-text text-danger" id="barcodeValidationErrors"></div>
            </div>
            <div class="col-lg-6 col-sm-6 mb-7">
                <div class="mb-3" io-image-input="true">
                    <label for="exampleInputQrcode" class="form-label">{{ __('messages.vcard.qrcode').':' }}</label>
                    <div class="d-block">
                        <div class="image-picker">
                            <div class="image previewImage" id="exampleInputQrcode"
                                 style="background-image: url({{ !empty($vcard->qrcode) ? $vcard->qrcode : "" }})"></div>
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                  data-placement="top" data-bs-original-title="{{__('messages.tooltip.qrcode')}}">
                                        <label>
                                        <i class="fa-solid fa-pen" id="qrcodeIcon"></i>
                                            <input type="file" id="qrcode" name="qrcode"
                                                   class="image-upload d-none" accept="image/*"/>
                                        </label>
                                    </span>
                        </div>
                    </div>
                </div>
                <div class="form-text text-danger" id="qrcodeValidationErrors"></div>
            </div>
        </div>
    </div>  --}}
    <div class="col-lg-12">
        <h4 class="text-danger mb-4">Categories Texts</h4>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-2 col-sm-6 mb-7">
                <div class="mb-3" io-image-input="true">
                    <label for="exampleInputCategoryA" class="form-label">{{ __('messages.vcard.category_a').':' }}</label>
                    <div class="d-block">
                        <div class="image-picker">
                            <div class="image previewImage" id="exampleInputCategoryA"
                                 style="background-image: url({{ !empty($vcard->category_a) ? $vcard->category_a : "" }})"></div>
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                  data-placement="top" data-bs-original-title="{{__('messages.tooltip.category_a')}}">
                                        <label>
                                        <i class="fa-solid fa-pen" id="categoryAIcon"></i>
                                            <input type="file" id="category_a" name="category_a"
                                                   class="image-upload d-none" accept="image/*"/>
                                        </label>
                                    </span>
                        </div>
                    </div>
                </div>
                <div class="form-text text-danger" id="categoryAValidationErrors"></div>
            </div>
            <div class="col-lg-2 col-sm-6 mb-7">
                <div class="mb-3" io-image-input="true">
                    <label for="exampleInputCategoryB" class="form-label">{{ __('messages.vcard.category_b').':' }}</label>
                    <div class="d-block">
                        <div class="image-picker">
                            <div class="image previewImage" id="exampleInputCategoryB"
                                 style="background-image: url({{ !empty($vcard->category_b) ? $vcard->category_b : "" }})"></div>
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                  data-placement="top" data-bs-original-title="{{__('messages.tooltip.category_b')}}">
                                        <label>
                                        <i class="fa-solid fa-pen" id="categoryBIcon"></i>
                                            <input type="file" id="category_b" name="category_b"
                                                   class="image-upload d-none" accept="image/*"/>
                                        </label>
                                    </span>
                        </div>
                    </div>
                </div>
                <div class="form-text text-danger" id="categoryBValidationErrors"></div>
            </div>
            <div class="col-lg-2 col-sm-6 mb-7">
                <div class="mb-3" io-image-input="true">
                    <label for="exampleInputCategoryC" class="form-label">{{ __('messages.vcard.category_c').':' }}</label>
                    <div class="d-block">
                        <div class="image-picker">
                            <div class="image previewImage" id="exampleInputCategoryC"
                                 style="background-image: url({{ !empty($vcard->category_c) ? $vcard->category_c : "" }})"></div>
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                  data-placement="top" data-bs-original-title="{{__('messages.tooltip.category_c')}}">
                                        <label>
                                        <i class="fa-solid fa-pen" id="categoryCIcon"></i>
                                            <input type="file" id="category_c" name="category_c"
                                                   class="image-upload d-none" accept="image/*"/>
                                        </label>
                                    </span>
                        </div>
                    </div>
                </div>
                <div class="form-text text-danger" id="categoryCValidationErrors"></div>
            </div>
            <div class="col-lg-2 col-sm-6 mb-7">
                <div class="mb-3" io-image-input="true">
                    <label for="exampleInputCategoryD" class="form-label">{{ __('messages.vcard.category_d').':' }}</label>
                    <div class="d-block">
                        <div class="image-picker">
                            <div class="image previewImage" id="exampleInputCategoryD"
                                 style="background-image: url({{ !empty($vcard->category_d) ? $vcard->category_d : "" }})"></div>
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                  data-placement="top" data-bs-original-title="{{__('messages.tooltip.category_d')}}">
                                        <label>
                                        <i class="fa-solid fa-pen" id="categoryDIcon"></i>
                                            <input type="file" id="category_d" name="category_d"
                                                   class="image-upload d-none" accept="image/*"/>
                                        </label>
                                    </span>
                        </div>
                    </div>
                </div>
                <div class="form-text text-danger" id="categoryDValidationErrors"></div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-7">
                <div class="mb-3" io-image-input="true">
                    <label for="exampleInputCategoryE" class="form-label">{{ __('messages.vcard.category_e').':' }}</label>
                    <div class="d-block">
                        <div class="image-picker">
                            <div class="image previewImage" id="exampleInputCategoryE"
                                 style="background-image: url({{ !empty($vcard->category_e) ? $vcard->category_e : "" }})"></div>
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                  data-placement="top" data-bs-original-title="{{__('messages.tooltip.category_e')}}">
                                        <label>
                                        <i class="fa-solid fa-pen" id="categoryEIcon"></i>
                                            <input type="file" id="category_e" name="category_e"
                                                   class="image-upload d-none" accept="image/*"/>
                                        </label>
                                    </span>
                        </div>
                    </div>
                </div>
                <div class="form-text text-danger" id="categoryEValidationErrors"></div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-7">
                    {{ Form::label('category_a_text', __('messages.vcard.category_a_text') . ':', ['class' => 'form-label required']) }}
                    {{ Form::text('category_a_text', isset($vcard) ? $vcard->category_a_text : null, ['class' => 'form-control', 'placeholder' => __('messages.form.category_a_text'), '']) }}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-7">
                    {{ Form::label('category_b_text', __('messages.vcard.category_b_text') . ':', ['class' => 'form-label required']) }}
                    {{ Form::text('category_b_text', isset($vcard) ? $vcard->category_b_text : null, ['class' => 'form-control', 'placeholder' => __('messages.form.category_b_text'), '']) }}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-7">
                    {{ Form::label('category_c_text', __('messages.vcard.category_c_text') . ':', ['class' => 'form-label required']) }}
                    {{ Form::text('category_c_text', isset($vcard) ? $vcard->category_c_text : null, ['class' => 'form-control', 'placeholder' => __('messages.form.category_c_text'), '']) }}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-7">
                    {{ Form::label('category_d_text', __('messages.vcard.category_d_text') . ':', ['class' => 'form-label required']) }}
                    {{ Form::text('category_d_text', isset($vcard) ? $vcard->category_d_text : null, ['class' => 'form-control', 'placeholder' => __('messages.form.category_d_text'), '']) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-7">
                    {{ Form::label('category_e_text', __('messages.vcard.category_e_text') . ':', ['class' => 'form-label required']) }}
                    {{ Form::text('category_e_text', isset($vcard) ? $vcard->category_e_text : null, ['class' => 'form-control', 'placeholder' => __('messages.form.category_e_text'), '']) }}
                </div>
            </div>
            <div class="col-lg-12 d-flex">
                <button type="submit" class="btn btn-primary me-3">
                    {{ __('messages.common.save') }}
                </button>
                <a href="{{ route('vcards.index') }}"
                    class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
            </div>
        </div>
    </div>
</div>
@endif

@if ($partName == 'parking_custom_idea')
    <div class="row">
        <div class="col-lg-6 mb-7">
            {{ Form::label('Owner Mobile No.', __('messages.vcard.parking_owner_mobile_no') . ':', ['class' => 'form-label']) }}
            {{ Form::text('parking_owner_mobile_no', isset($vcard) ? $vcard->parking_owner_mobile_no : null, ['class' => 'form-control', 'placeholder' => __('messages.form.parking_owner_mobile_no'), 'required']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Address', __('messages.vcard.parking_address') . ':', ['class' => 'form-label']) }}
            {{ Form::text('parking_address', isset($vcard) ? $vcard->parking_address : null, ['class' => 'form-control', 'placeholder' => __('messages.form.parking_address')]) }}
        </div>

        <div class="col-lg-6 mb-7">
            {{ Form::label('Vehicle Color', __('messages.vcard.parking_vehicle_color') . ':', ['class' => 'form-label']) }}
            {{ Form::text('parking_vehicle_color', isset($vcard) ? $vcard->parking_vehicle_color : null, ['class' => 'form-control', 'placeholder' => __('messages.form.parking_vehicle_color')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Vehicle Model', __('messages.vcard.parking_vehicle_model') . ':', ['class' => 'form-label']) }}
            {{ Form::text('parking_vehicle_model', isset($vcard) ? $vcard->parking_vehicle_model : null, ['class' => 'form-control', 'placeholder' => __('messages.form.parking_vehicle_model')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Plate No.', __('messages.vcard.parking_plate_no') . ':', ['class' => 'form-label']) }}
            {{ Form::text('parking_plate_no', isset($vcard) ? $vcard->parking_plate_no : null, ['class' => 'form-control', 'placeholder' => __('messages.form.parking_plate_no')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Driver Mobile No.', __('messages.vcard.parking_mobile') . ':', ['class' => 'form-label']) }}
            {{ Form::text('parking_mobile', isset($vcard) ? $vcard->parking_mobile : null, ['class' => 'form-control', 'placeholder' => __('messages.form.parking_mobile')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Country', __('messages.vcard.parking_country') . ':', ['class' => 'form-label required']) }}
            {{ Form::select('parking_country', getCountry(), isset($vcard) ? $vcard->parking_country : null, ['id' => 'parking_country', 'class' => 'form-select', 'required', 'placeholder' => __('messages.form.select_country'), 'data-control' => 'select2']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('State', __('messages.vcard.parking_state') . ':', ['class' => 'form-label required']) }}
            {{ Form::select('parking_state', [], isset($vcard) ? $vcard->parking_state : null, ['id' => 'parking_state', 'class' => 'form-select', 'required', 'placeholder' => __('messages.form.select_state'), 'data-control' => 'select2']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('City', __('messages.vcard.parking_city') . ':', ['class' => 'form-label required']) }}
            {{ Form::select('parking_city', [], isset($vcard) ? $vcard->parking_city : null, ['id' => 'parking_city', 'class' => 'form-select', 'required', 'placeholder' => __('messages.form.select_city'), 'data-control' => 'select2']) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('District', __('messages.vcard.parking_district') . ':', ['class' => 'form-label']) }}
            {{ Form::text('parking_district', isset($vcard) ? $vcard->parking_district : null, ['class' => 'form-control', 'placeholder' => __('messages.form.parking_district')]) }}
        </div>

        <div class="col-lg-6 mb-7">
            {{ Form::label('P. Place of Registration', __('messages.vcard.parking_p_place_of_registration') . ':', ['class' => 'form-label']) }}
            {{ Form::text('parking_p_place_of_registration', isset($vcard) ? $vcard->parking_p_place_of_registration : null, ['class' => 'form-control', 'placeholder' => __('messages.form.parking_p_place_of_registration')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('P. Registration Officer', __('messages.vcard.parking_p_registration_officer') . ':', ['class' => 'form-label']) }}
            {{ Form::text('parking_p_registration_officer', isset($vcard) ? $vcard->parking_p_registration_officer : null, ['class' => 'form-control', 'placeholder' => __('messages.form.parking_p_registration_officer')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('P. Date of Payment', __('messages.vcard.parking_p_date_of_payment') . ':', ['class' => 'form-label']) }}
            {{ Form::date('parking_p_date_of_payment', isset($vcard) ? $vcard->parking_p_date_of_payment : null, ['class' => 'form-control', 'placeholder' => __('messages.form.parking_p_date_of_payment')]) }}
        </div>
        <div class="col-lg-6 mb-7">
            {{ Form::label('Parking Plan', __('messages.vcard.parking_parking_plan') . ':', ['class' => 'form-label']) }}
            {{ Form::text('parking_parking_plan', isset($vcard) ? $vcard->parking_parking_plan : null, ['class' => 'form-control', 'placeholder' => __('messages.form.parking_parking_plan')]) }}
        </div>

        <div class="col-lg-6 mb-7">
            {{ Form::label('Date of Inspection', __('messages.vcard.parking_date_of_inspection') . ':', ['class' => 'form-label']) }}
            {{ Form::date('parking_date_of_inspection', isset($vcard) ? $vcard->parking_date_of_inspection : null, ['class' => 'form-control', 'placeholder' => __('messages.form.parking_date_of_inspection')]) }}
        </div>

        <div class="col-lg-12 d-flex">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('messages.common.save') }}
            </button>
            <a href="{{ route('vcards.index') }}"
                class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
        </div>
@endif
