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
