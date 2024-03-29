@extends('layouts.app')
@section('title')
    {{ __('messages.setting.credentials') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="col-12">
                @include('layouts.errors')
                @include('flash::message')
                @include('user-settings.setting_menu')
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => 'user.setting.update', 'id'=>'UserCredentialsSettings', 'class'=>'form']) }}
                        {{ Form::hidden('sectionName', $sectionName) }}
                        <div class="row">

                            {{--  STRIPE --}}
                            <div class="col-12 d-flex align-items-center">
                                <span class="fs-3 my-3 me-3">{{ __('messages.setting.stripe') }}</span>
                                <label class="form-switch">
                                    <input type="checkbox" name="stripe_enable" class="form-check-input stripe-enable"
                                           value="1" {{ !empty($setting['stripe_enable']) == '1' ? 'checked' : ''}}
                                           id="stripeEnable">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                            <div class="stripe-div {{ !empty($setting['stripe_enable'] ) == '1' ? '' : 'd-none'}} col-12">
                                <div class="row">
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('stripe_key', __('messages.setting.stripe_key').':', ['class' => 'form-label']) }}
                                        {{ Form::text('stripe_key',(!empty($setting)) ? $setting['stripe_key'] : null, ['class' => 'form-control' , 'id' => 'stripeKey' , 'placeholder' => __('messages.setting.stripe_key')]) }}
                                    </div>
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('stripe_secret', __('messages.setting.stripe_secret').':', ['class' => 'form-label']) }}
                                        {{ Form::text('stripe_secret',!empty($setting) ? $setting['stripe_secret']: null, ['class' => 'form-control', 'id' => 'stripeSecret' , 'placeholder' => __('messages.setting.stripe_secret')]) }}
                                    </div>
                                </div>
                            </div>
                            {{--  PAYPAL --}}
                            <div class="col-12 d-flex align-items-center">
                                <span class="fs-3 my-3">{{ __('messages.setting.paypal') }}</span>
                                <label class="form-check form-switch ms-3">
                                    <input type="checkbox" name="paypal_enable" class="form-check-input paypal-enable"
                                           value="1"
                                           {{ !empty($setting['paypal_enable'])  == '1' ? 'checked' : ''
    }}
                                           id="paypalEnable">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                            <div class="paypal-div {{!empty($setting['paypal_enable']) == '1' ? '' : 'd-none' }} col-12">
                                <div class="row">
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('paypal_client_id', __('messages.setting.paypal_client_id').':', ['class' => 'form-label']) }}
                                        {{ Form::text('paypal_client_id', !empty($setting['paypal_client_id'])?$setting['paypal_client_id'] : null, ['class' => 'form-control','id' => 'paypalKey' , 'placeholder' => __('messages.setting.paypal_client_id')]) }}
                                    </div>
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('paypal_secret', __('messages.setting.paypal_secret').':', ['class' => 'form-label']) }}
                                        {{ Form::text('paypal_secret',!empty($setting['paypal_secret']) ? $setting['paypal_secret'] : null,  ['class' => 'form-control','id' => 'paypalSecret' , 'placeholder' => __('messages.setting.paypal_secret')]) }}
                                    </div>
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('paypal_mode', __('messages.setting.paypal_mode').':', ['class' => 'form-label']) }}
                                        {{ Form::text('paypal_mode',!empty($setting['paypal_mode']) ? $setting['paypal_mode'] : null, ['class' => 'form-control','id' => 'paypalMode' , 'placeholder' => __('messages.setting.paypal_mode')]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-6 mb-5">
                                {{ Form::label('currency', __('messages.setting.currency').':', ['class' => 'form-label required']) }}
                                <div class="input-group ">
                                    {{ Form::select('currency_id', getCurrencies(), !empty ($setting['currency_id']) ? $setting['currency_id']: null,['class' => 'form-control', 'required','data-control' => 'select2','id' => 'userCurrencySettingId', 'placeholder' => __('messages.setting.select_currency'),]) }}
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"
                                id="userCredentialSettingBtn">{{ __('messages.common.save') }}</button>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
