<x-livewire-tables::table.cell>
    <?php
        $defaultTemplate = asset('assets/images/default_cover_image.jpg');
    ?>
    <div class="d-flex align-items-center">
        <div class="image image-circle image-mini me-3">
            <img src="{{ empty($row->template) ? $defaultTemplate : $row->template->template_url }}" alt="Vcard">
        </div>
        <div class="d-flex flex-column">
            <a href="{{ route('vcards.edit', $row->id) }}" class="mb-1 text-decoration-none fs-6">
                {{ $row->name }}
            </a>
            <span class="fs-6">{{ $row->occupation }}</span>
        </div>
    </div>
</x-livewire-tables::table.cell>


<x-livewire-tables::table.cell>
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
</x-livewire-tables::table.cell>


<x-livewire-tables::table.cell>
    <a href="{{ route('vcard.analytics', $row->id)}}">
        <i class="fa-solid fa-chart-line fs-2"></i>
    </a>

</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    <label class="form-check form-switch d-flex justify-content-center">
        <input name="is_active" data-id="{{$row->id}}" class="form-check-input vcardStatus"
               type="checkbox" value="1" {{ $row->status == 1 ? 'checked': ''}}>
    </label>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    <div class="qr-code-image mt-4 d-flex justify-content-center">
        @if($row->template_id == 1)
        <img src="{{asset('assets/img/vcard1/vcard-qr.png')}}" alt="qr code" width="50" height="50"/>
        @elseif($row->template_id == 2)
        <img src="{{asset('assets/img/vcard2/vcard2-qr-code.png')}}" alt="qr code" width="50" height="50"/>
        @elseif($row->template_id == 3)
        <img src="{{asset('assets/img/vcard3/vcard3-qr-code.png')}}" alt="qr code" width="50" height="50"/>
        @elseif($row->template_id == 4)
        <img src="{{asset('assets/img/vcard4/qr-code.png')}}" alt="qr code" width="50" height="50"/>
        @elseif($row->template_id == 5)
        <img src="{{asset('assets/img/newqr.png')}}" alt="qr code" width="50" height="50"/>
        @elseif($row->template_id == 6)
        <img src="{{asset('assets/img/vcard6/qrcode.png')}}" alt="qr code" width="50" height="50"/>
        @elseif($row->template_id == 7)
        <img src="{{asset('assets/img/qrcode.png')}}" alt="qr code" width="50" height="50"/>
        @elseif($row->template_id == 8)
        <img src="{{asset('assets/img/vcard3/vcard3-qr-code.png')}}" alt="qr code" width="50" height="50"/>
        @elseif($row->template_id == 9)
        <img src="{{asset('assets/img/vcard3/vcard3-qr-code.png')}}" alt="qr code" width="50" height="50"/>
        @elseif($row->template_id == 10)
        <img src="{{asset('assets/img/vcard3/vcard3-qr-code.png')}}" alt="qr code" width="50" height="50"/>
        @endif
    </div>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    <span class="badge bg-secondary me-2">
        {{ Carbon\Carbon::parse($row->created_at)->isoFormat('Do MMM, YYYY') }}
    </span>
</x-livewire-tables::table.cell>



<x-livewire-tables::table.cell>
    <div class="justify-content-center d-flex">
    @if(route('enquiry.index', $row->id))
        <a title = "{{ __('messages.common.view') }}" href="{{route('enquiry.index', $row->id)}}"
           class="btn px-1 text-info fs-3">
            <i class="fa-solid fa-eye"></i>
        </a>
    @endif
    <a href="{{ route('vcards.edit', $row->id) }}" title="{{ __('messages.common.edit') }}" class="btn px-1 text-primary fs-3">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>
    <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"
       class="btn px-1 text-danger fs-3 vcard_delete-btn">
        <i class="fa-solid fa-trash"></i>
    </a>
    <a class="btn btn-primary" href="{{ route('subscription.upgrade',$row->id) }}">
        {{ __('messages.subscription.upgrade_plan') }}
    </a>
    </div>

</x-livewire-tables::table.cell>
