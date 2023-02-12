<x-livewire-tables::bs5.table.cell>
    {{$row->vcard->name}}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->name }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->email }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    @if($row->phone)
       {{ $row->phone }}
    @else
        {{'N/A'}}
    @endif
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->date }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell class="text-center">
    {{ $row->from_time }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell class="text-center">
    {{ $row->to_time }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    @if($row->paid_amount)
        <span class="badge bg-success">{{__('messages.appointment.paid').' '.$row->paid_amount}}</span>
    @else
        <span class="badge bg-primary">{{__('messages.appointment.free')}}</span>
    @endif
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->reason }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->location }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    {{ $row->message }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <div class="justify-content-center d-flex">
        <a href="javascript:void(0)" class="btn px-1 text-primary appointment-edit-btn fs-3"
            data-id="{{$row->id}}" title="{{__('messages.common.edit')}}">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"
        class="btn px-1 text-danger fs-3 appointment-delete-btn">
            <i class="fa-solid fa-trash"></i>
        </a>
        {{--  <a title = "{{ __('messages.common.view') }}" data-id="{{$row->id}}"
        class="btn px-1 text-info fs-3 enquiries-view-btn">
            <i class="fa-solid fa-eye"></i>
        </a>  --}}
    </div>
</x-livewire-tables::bs5.table.cell>
