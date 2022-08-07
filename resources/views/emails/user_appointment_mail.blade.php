@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset(getAppLogo()) }}" class="logo" alt="{{ getAppName() }}">
        @endcomponent
    @endslot


    {{-- Body --}}
    <div>
        <h2>Hello, <b>{{ $toName }}</b></h2>
        <p><b>{{ $name }}  booked appointment with you</b>.</p>
        <p><b>Appointment Time: </b> {{ $date }} - {{ $from_time }} to {{ $to_time }}</p>
        <p><b>VCard Name: </b> {{ $vcard_name }}</p>
        <p>Thanks & Regards,</p>
        <p>{{ getAppName() }}</p>
    </div>


    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ getAppName() }}.</h6>
        @endcomponent
    @endslot
@endcomponent
