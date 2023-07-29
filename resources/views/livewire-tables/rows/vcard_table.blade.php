<x-livewire-tables::bs5.table.cell>
    <div class="d-flex align-items-center">
        <a>
            <div class="image image-circle image-mini me-3">
                @if(empty($row->template))
                    <img src="{{ asset('assets/images/default_cover_image.jpg') }}" alt="Vcard">
                @else
                    <img src="{{$row->template->template_url}}" alt="Vcard">
                @endif
            </div>
        </a>
        <div class="d-flex flex-column">
            <a class="text-decoration-none fs-6">
                {{$row->name}}
            </a>
        </div>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{$row->vcard_unique_number}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->tenant->tenant_username}}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{$row->registration_vin_no}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_vehicle_model}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_vehicle_color}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_vehicle_year}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_plate_no}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_district}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_emergency_contact_no}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_ar_no}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_pcn_no}}
</x-livewire-tables::bs5.table.cell>


<x-livewire-tables::bs5.table.cell>
    {{$row->registration_driver_name}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_driver_address}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_driver_emergency_contact_no}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_driver_extra_field}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_driver_country}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_driver_state}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_driver_city}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_driver_district}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_driver_commune}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->registration_driver}}
</x-livewire-tables::bs5.table.cell>


<x-livewire-tables::bs5.table.cell>
    {{$row->inspection_address}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->inspection_chassis_no}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->inspection_vin_no}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->inspection_vehicle_model}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->inspection_vehicle_color}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->inspection_vehicle_year}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->inspection_plate_no}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->inspection_contact}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->inspection_ar_no}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->inspection_district}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->inspection_control_technique}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->inspection_date_of_inspection}}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{$row->parking_owner_mobile_no}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->parking_address}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->parking_vehicle_color}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->parking_vehicle_model}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->parking_plate_no}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->parking_mobile}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->parking_district}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->parking_p_place_of_registration}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->parking_p_registration_officer}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->parking_p_date_of_payment}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->parking_parking_plan}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->parking_date_of_inspection}}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{$row->nationality}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->footer_text}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->alternative_email}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->alternative_phone}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->alternative_region_code}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->issue_date}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->expire_date}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->hair_color}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->eye_color}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->sex}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->type}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->height}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->weight}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->rstr}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->comercial}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->non_comercial}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->dd}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->address}}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::bs5.table.cell>
    {{$row->category}}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    @if ($row->status == 1)
        <a href="{{ route('vcard.defaultIndex').'/'. $row->url_alias }}" id="vcardUrl{{ $row->id }}"
           target="_blank" class="text-decoration-none fs-6">{{ route('vcard.defaultIndex').'/'. $row->url_alias }}</a>
        <button class="btn px-2 text-primary fs-2 user-edit-btn copy-clipboard"
                data-id="{{ $row->id }}" title="{{'copy'}}">
            <i class="fa-regular fa-copy fs-2"></i>
        </button>
    @else
        <span id="vcardUrl{{$row->id}}" target="_blank"> {{route('vcard.defaultIndex').'/'. $row->url_alias}} </span>
    @endif
</x-livewire-tables::bs5.table.cell>




<x-livewire-tables::bs5.table.cell>
    <a href="{{ route('sadmin.vcard.analytics', $row->id)}}">
        <i class="fa-solid fa-chart-line fs-2"></i>
    </a>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <span class="badge bg-secondary me-2">
       {{ $row->created_at}}
    </span>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    @if ($row->status == 1)
        <span class="badge bg-success">Active</span>
    @else
        <span class="badge bg-danger">DeActive</span>
    @endif
</x-livewire-tables::bs5.table.cell>
