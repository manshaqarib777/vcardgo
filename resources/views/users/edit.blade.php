@extends('layouts.app')
@section('title')
    {{__('messages.user.edit_user')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-end mb-5">
                    <h1>{{__('messages.user.edit_user')}}</h1>
                    @can("users.index")
                    <a class="btn btn-outline-primary float-end"
                       href="{{ route('users.index') }}">{{ __('messages.common.back') }}</a>
                       @endcan
                </div>
                <div class="col-12">
                    @include('layouts.errors')
                </div>
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['route' => ['users.update', $user->id], 'method' => 'put',
                                'files' => 'true','id'=>'userEditForm']) !!}
                             @include('users.fields')
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
