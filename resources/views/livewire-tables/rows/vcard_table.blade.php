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
            @if($row->emaoccupationil != '')
                {{ dd(2412) }}
            @endif
            <span class="fs-6">{{$row->emaoccupationil}}</span>
        </div>
    </div>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{$row->tenant->tenant_username}}
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
    {{ $row->name }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->location }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    static , not in vcard yet. <br>
    ID Category Here like <br> Moto,Taxi
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    static , not in vcard yet. <br>
    ID Class Here like <br> A, B, C etc.
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    static , not in vcard yet. <br>
    Blood type here <br> A, AB etc.
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->sex }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <a href="{{ route('sadmin.vcard.analytics', $row->id)}}">
        <i class="fa-solid fa-chart-line fs-2"></i>
    </a>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <span class="badge bg-secondary me-2">
       {{ Carbon\Carbon::parse($row->created_at)->isoFormat('Do MMM, YYYY') }}
    </span>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    @if ($row->status == 1)
        <span class="badge bg-success">Active</span>
    @else
        <span class="badge bg-danger">DeActive</span>
    @endif
</x-livewire-tables::bs5.table.cell>
