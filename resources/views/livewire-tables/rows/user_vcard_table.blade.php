<link rel="stylesheet" href="{{ asset('assets/css/vcard1.css')}}">
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
        <img src="{{asset('assets/img/vcard1/vcard-qr.png')}}" alt="qr code" width="50" height="50" data-bs-toggle="modal" data-bs-target="#exampleModal{{$row->id}}" style="cursor: pointer;"/>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal{{$row->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">QR Code</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="vcard-one__qr-code my-3 py-5 px-3">
                <div class="qr-code p-3 card d-block mx-auto border-0">
                    <div class="qr-code-profile d-flex justify-content-center">
                        <img src="{{asset('assets/img/vcard1/vcard1-profile.png')}}" alt="qr profile"
                             class="rounded-circle"/>
                    </div>
                    <div class="qr-code-image mt-4 d-flex justify-content-center">
                        <img src="{{asset('assets/img/vcard1/vcard-qr.png')}}" alt="qr code"/>
                    </div>
                </div>
                <a download="vcard-qr.png" href="{{asset('assets/img/vcard1/vcard-qr.png')}}" title="ImageName" class="qr-code-btn text-white mt-4 d-block mx-auto" style="text-decoration:none;">
                    Download My QR Code
                </a>
            </div>
        </div>
      </div>
    </div>
  </div>
