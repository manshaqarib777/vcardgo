@extends('layouts.app')
@section('title')
    {{__('messages.galleries')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column table-striped">
            @include('layouts.errors')
            <livewire:gallery-table/>
        </div>
    </div>
    @include('vcardTemplates.template.templates')
@endsection
