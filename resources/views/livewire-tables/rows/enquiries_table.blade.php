
<x-livewire-tables::bs5.table.cell>
    {{ $row->name }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <a href="mailto:{{$row->email}}" class="text-decoration-none fs-6">{{$row->email}}</a>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    @if($row->phone)
        {{ $row->phone }}
    @else
        {{'N/A'}}
    @endif
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ Carbon\Carbon::parse($row->created_at)->isoFormat('Do MMM, YYYY') }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->reason }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->message }}
</x-livewire-tables::bs5.table.cell>
<x-livewire-tables::table.cell>
    @if($row->enquiry_url)
    <div class="mt-4 d-flex justify-content-center">
        <img src="{{ $row->enquiry_url }}" width="100" height="100" >
    </div>
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="justify-content-center d-flex">
        <a href="javascript:void(0)" class="btn px-1 text-primary enquiry-edit-btn fs-3"
            data-id="{{$row->id}}" title="{{__('messages.common.edit')}}">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"
        class="btn px-1 text-danger fs-3 enquiry-delete-btn">
            <i class="fa-solid fa-trash"></i>
        </a>
        <a title = "{{ __('messages.common.view') }}" data-id="{{$row->id}}"
        class="btn px-1 text-info fs-3 enquiries-view-btn">
            <i class="fa-solid fa-eye"></i>
        </a>
    </div>
</x-livewire-tables::bs5.table.cell>

