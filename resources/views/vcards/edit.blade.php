@extends('layouts.app')
@section('title')
    {{__('messages.vcard.edit_vcard')}}
@endsection
@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <h1>{{__('messages.vcard.edit_vcard')}}</h1>
            @can("user-vcards.index")
            <a class="btn btn-outline-primary float-end"
               href="{{ route('vcards.index') }}">{{ __('messages.common.back') }}</a>
            @endcan
        </div>
        <div class="col-12">
            @if(Session::has('success'))
                <p class="alert alert-success">{{ getSuccessMessage(Request::query('part')).Session::get('success') }}</p>
            @endif
            @include('layouts.errors')
            @include('flash::message')
        </div>
        @include('vcards.sub_menu')
        <div class="card">
            <div class="card-body">
                {{ Form::hidden('is_true', Request::query('part') == 'business_hours',['id' => 'vcardCreateEditIsTrue']) }}
                @if($partName != 'services' && $partName != 'blogs' && $partName != 'testimonials' && $partName != 'products' && $partName != 'galleries')
                    {!! Form::open(['route' => ['vcards.update', $vcard->id], 'id' => 'editForm', 'method' => 'put', 'files' => 'true']) !!}
                    @include('vcards.fields')
                    {{ Form::close() }}
                @else
                    @if($partName === 'services')
                        @include('vcards.services.index')
                    @elseif($partName === 'products')
                        @include('vcards.products.index')
                    @elseif($partName === 'galleries')
                        @include('vcards.gallery.index')
                    @elseif($partName === 'blogs')
                        @include('vcards.blogs.index')
                    @else
                        @include('vcards.testimonials.index')
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(".datepicker").datepicker( {
        format: "yyyy",
        startView: "years",
        minViewMode: "years"
    });
 setTimeout(() => {
    $('#registration_country').trigger('change');
    $('#inspection_country').trigger('change');
    $('#parking_country').trigger('change');
    setTimeout(() => {
        $('#registration_state').trigger('change');
        $('#inspection_state').trigger('change');
        $('#parking_state').trigger('change');
    }, 200);
 }, 100);
    $('#registration_country').change(function() {
        var id = $(this).val();
        $.get("{{ route('get-states-ajax') }}?country_id=" + id, function(data) {
            var state = "{{isset($vcard) ? $vcard->registration_state : null}}";
            $('#registration_state').empty();
            $('#registration_city').empty();
            $('#registration_state').append(
                '<option value=""></option>');
            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                var selected = "";
                if(state == element['id'] )
                {
                    selected = "selected";
                }
                $('#registration_state').append('<option value="' +
                    element['id'] + '" '+selected+'>' + element['name'] + '</option>');
            }


        });
    });
    $('#registration_state').change(function() {
        var id = $(this).val();

        $.get("{{ route('get-cities-ajax') }}?state_id=" + id, function(data) {
            var city = "{{isset($vcard) ? $vcard->registration_city : null}}";
            $('#registration_city').empty();
            $('#registration_city').append(
                '<option value=""></option>');
            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                var selected = "";
                if(city == element['id'] )
                {
                    selected = "selected";
                }
                $('#registration_city').append('<option value="' +
                    element['id'] + '" '+selected+'>' + element['name'] + '</option>');
            }


        });
    });


    $('#inspection_country').change(function() {
        var id = $(this).val();
        $.get("{{ route('get-states-ajax') }}?country_id=" + id, function(data) {
            var state = "{{isset($vcard) ? $vcard->inspection_state : null}}";
            $('#inspection_state').empty();
            $('#inspection_city').empty();
            $('#inspection_state').append(
                '<option value=""></option>');
            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                var selected = "";
                if(state == element['id'] )
                {
                    selected = "selected";
                }
                $('#inspection_state').append('<option value="' +
                    element['id'] + '" '+selected+'>' + element['name'] + '</option>');
            }


        });
    });
    $('#inspection_state').change(function() {
        var id = $(this).val();

        $.get("{{ route('get-cities-ajax') }}?state_id=" + id, function(data) {
            var city = "{{isset($vcard) ? $vcard->inspection_city : null}}";
            $('#inspection_city').empty();
            $('#inspection_city').append(
                '<option value=""></option>');
            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                var selected = "";
                if(city == element['id'] )
                {
                    selected = "selected";
                }
                $('#inspection_city').append('<option value="' +
                    element['id'] + '" '+selected+'>' + element['name'] + '</option>');
            }


        });
    });


    $('#parking_country').change(function() {
        var id = $(this).val();
        $.get("{{ route('get-states-ajax') }}?country_id=" + id, function(data) {
            var state = "{{isset($vcard) ? $vcard->parking_state : null}}";
            $('#parking_state').empty();
            $('#parking_city').empty();
            $('#parking_state').append(
                '<option value=""></option>');
            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                var selected = "";
                if(state == element['id'] )
                {
                    selected = "selected";
                }
                $('#parking_state').append('<option value="' +
                    element['id'] + '" '+selected+'>' + element['name'] + '</option>');
            }


        });
    });
    $('#parking_state').change(function() {
        var id = $(this).val();

        $.get("{{ route('get-cities-ajax') }}?state_id=" + id, function(data) {
            var city = "{{isset($vcard) ? $vcard->parking_city : null}}";
            $('#parking_city').empty();
            $('#parking_city').append(
                '<option value=""></option>');
            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                var selected = "";
                if(city == element['id'] )
                {
                    selected = "selected";
                }
                $('#parking_city').append('<option value="' +
                    element['id'] + '" '+selected+'>' + element['name'] + '</option>');
            }


        });
    });
</script>
@endsection
