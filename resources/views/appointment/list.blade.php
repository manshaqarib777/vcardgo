@extends('layouts.app')
@section('title')
    {{__('messages.appointments')}}
@endsection
@section('style')
<link rel="stylesheet" href="{{ mix('assets/css/vcard1.css')}}">

@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column table-striped">
            @include('layouts.errors')
            <livewire:schedule-appointment-table/>
        </div>
    </div>
    @include('vcardTemplates.template.templates')
    @include('appointment.edit')
@endsection
