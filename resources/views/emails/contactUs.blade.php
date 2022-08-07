@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset(getAppLogo()) }}" class="logo" alt="{{ getAppName() }}">
        @endcomponent
    @endslot
    <h2> Here is a Enquiry Detail <br>
    </h2>
    <p><b>Name: </b>{{$input['name']}}</p>
    <p><b>Email: </b>{{$input['email']}}</p>
    <p><b>Message: </b>{{$input['message']}}</p>
    <p><b>Phone: </b>{{is_null($input['phone']) ? 'N/A' : $input['phone']}}</p>
    <p><b>VCard Name: </b>{{$input['vcard_name']}}</p>
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ getAppName() }}.</h6>
        @endcomponent
    @endslot
@endcomponent
