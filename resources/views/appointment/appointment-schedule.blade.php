@extends('layouts.app')
@section('title')
    {{__('messages.vcard.edit_appointment')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <h1>{{__('messages.vcard.edit_appointment')}}</h1>
        </div>
        <div class="col-12">
            @if(Session::has('success'))
                <p class="alert alert-success">{{ getSuccessMessage(Request::query('part')).Session::get('success') }}</p>
            @endif
            @include('layouts.errors')
            @include('flash::message')
        </div>
        <div class="card">
            <div class="card-body">
                {!! Form::open(['route' => ['appointments.appointments-schedule-update', auth()->id()], 'id' => 'editForm', 'method' => 'post', 'files' => 'true']) !!}
                    <div class="col-12">
                        <table class="table table-striped mt-lg-4">
                            <tbody>
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
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>

</script>
@endsection
