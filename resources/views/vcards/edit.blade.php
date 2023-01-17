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

    @if ($partName == 'registration_custom_idea')
        var state = "{{isset($vcard) ? $vcard->registration_state : null}}";
        var city = "{{isset($vcard) ? $vcard->registration_city : null}}";
        var commune = "{{isset($vcard) ? $vcard->registration_commune : null}}";

        setTimeout(() => {
            $('#registration_country').trigger('change');
            $('#registration_district').trigger('change');
            setTimeout(() => {
                $('#registration_state').trigger('change');
            }, 600);
        }, 300);
    @endif
    @if ($partName == 'inspection_custom_idea')
        var state = "{{isset($vcard) ? $vcard->inspection_state : null}}";
        var city = "{{isset($vcard) ? $vcard->inspection_city : null}}";
        var commune = "{{isset($vcard) ? $vcard->inspection_commune : null}}";
        setTimeout(() => {
            $('#inspection_country').trigger('change');
            $('#inspection_district').trigger('change');
            setTimeout(() => {
                $('#inspection_state').trigger('change');
            }, 600);
        }, 300);
    @endif
    @if ($partName == 'inspection_custom_idea_new')
        var state = "{{isset($vcard) ? $vcard->inspection_state_new : null}}";
        var city = "{{isset($vcard) ? $vcard->inspection_city_new : null}}";
        var commune = "{{isset($vcard) ? $vcard->inspection_commune_new : null}}";
        setTimeout(() => {
            $('#inspection_country_new').trigger('change');
            $('#inspection_district_new').trigger('change');
            setTimeout(() => {
                $('#inspection_state_new').trigger('change');
            }, 600);
        }, 300);
    @endif
    @if ($partName == 'parking_custom_idea')
        var state = "{{isset($vcard) ? $vcard->parking_state : null}}";
        var city = "{{isset($vcard) ? $vcard->parking_city : null}}";
        var commune = "{{isset($vcard) ? $vcard->parking_commune : null}}";
        setTimeout(() => {
            $('#parking_country').trigger('change');
            $('#parking_district').trigger('change');
            setTimeout(() => {
                $('#parking_state').trigger('change');
            }, 600);
        }, 300);
    @endif

    $('#registration_country,#inspection_country,#inspection_country_new,#parking_country').change(function() {
        var id = $(this).val();
        var module = $(this).attr("module");
        $.get("{{ route('get-states-ajax') }}?country_id=" + id, function(data) {
            $(module).empty();
            $('#registration_city,#inspection_city,#inspection_city_new,#parking_city').empty();
            $(module).append(
                '<option value=""></option>');
            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                var selected = "";
                if(state == element['id'] )
                {
                    selected = "selected";
                }
                $(module).append('<option value="' +
                    element['id'] + '" '+selected+'>' + element['name'] + '</option>');
            }
        });
    });
    $('#registration_state,#inspection_state,#inspection_state_new,#parking_state').change(function() {
        var id = $(this).val();
        var module = $(this).attr("module");
        var hidden_module = $(this).attr("hidden_module");
        if(id == 828){
            $(hidden_module).show();
        }
        else{
            $(hidden_module).hide();
        }
        $.get("{{ route('get-cities-ajax') }}?state_id=" + id, function(data) {
            $(module).empty();
            $(module).append('<option value=""></option>');
            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                var selected = "";
                if(city == element['id'] )
                {
                    selected = "selected";
                }
                $(module).append('<option value="' +
                    element['id'] + '" '+selected+'>' + element['name'] + '</option>');
            }
        });
    });


    $('#registration_district, #inspection_district, #inspection_district_new, #parking_district').change(function() {
        var module = $(this).attr("module");
        var id = $(this).val();
        $(module).empty();
        if (id == "MONT-AMBA") {
            $(module).append(`
                <option value="LEMBA" ${(commune=='LEMBA')?'selected':''}>LEMBA</option>
                <option value="MATETE" ${(commune=='MATETE')?'selected':''}>MATETE</option>
                <option value="KISENSO" ${(commune=='KISENSO')?'selected':''}>KISENSO</option>
                <option value="NGABA" ${(commune=='NGABA')?'selected':''}>NGABA</option>
                <option value="LIMETE" ${(commune=='LIMETE')?'selected':''}>LIMETE</option>
            `);
        }
        else if (id == "FUNA") {
            $(module).append(`
                <option value="MAKALA" ${(commune=='MAKALA')?'selected':''}>MAKALA</option>
                <option value="KALAMU" ${(commune=='KALAMU')?'selected':''}>KALAMU</option>
                <option value="SELEMBAO" ${(commune=='SELEMBAO')?'selected':''}>SELEMBAO</option>
                <option value="BANDALUNGWA" ${(commune=='BANDALUNGWA')?'selected':''}>BANDALUNGWA</option>
                <option value="NGIRI-NGIRI" ${(commune=='NGIRI-NGIRI')?'selected':''}>NGIRI-NGIRI</option>
                <option value="BUMBU" ${(commune=='BUMBU')?'selected':''}>BUMBU</option>
                <option value="KASA-VUBU" ${(commune=='KASA-VUBU')?'selected':''}>KASA-VUBU</option>
            `);
        }
        else if (id == "LUKUNGA") {
            $(module).append(`
                <option value="KITAMBO" ${(commune=='KITAMBO')?'selected':''}>KITAMBO</option>
                <option value="MONT-NGAFULA" ${(commune=='MONT-NGAFULA')?'selected':''}>MONT-NGAFULA</option>
                <option value="NGALIEMA" ${(commune=='NGALIEMA')?'selected':''}>NGALIEMA</option>
                <option value="KINSHASA" ${(commune=='KINSHASA')?'selected':''}>KINSHASA</option>
                <option value="BARUMBU" ${(commune=='BARUMBU')?'selected':''}>BARUMBU</option>
                <option value="GOMBE" ${(commune=='GOMBE')?'selected':''}>GOMBE</option>
                <option value="LINGWALA" ${(commune=='LINGWALA')?'selected':''}>LINGWALA</option>
            `);
        }
        else if (id == "TSHANGU") {
            $(module).append(`
                <option value="NDJILI" ${(commune=='NDJILI')?'selected':''}>NDJILI</option>
                <option value="KIMBANSEKE" ${(commune=='KIMBANSEKE')?'selected':''}>KIMBANSEKE</option>
                <option value="MASINA" ${(commune=='MASINA')?'selected':''}>MASINA</option>
                <option value="NSELE" ${(commune=='NSELE')?'selected':''}>NSELE</option>
                <option value="MALUKU" ${(commune=='MALUKU')?'selected':''}>MALUKU</option>
            `);
        }

    });
</script>
@endsection
