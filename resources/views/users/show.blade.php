@extends('layouts.app')
@section('title')
    {{ __('messages.user.user_details') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                @can("users.edit")
                <a href="{{ route('users.edit', $user->id) }}">
                <button type="button" class="btn btn-primary me-4">Edit</button>
                </a>
                @endcan
                @can("users.index")
                <a href="{{ route('users.index') }}">
                <button type="button" class="btn btn-outline-primary float-end">Back</button>
                </a>
                @endcan
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('users.show_fields')
        </div>
    </div>
@endsection

