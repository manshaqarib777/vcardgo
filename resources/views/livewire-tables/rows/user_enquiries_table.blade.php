<x-livewire-tables::bs5.table.cell>
    <span class="">{{$row->name}}</span>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <a href="mailto:{{$row->email}}"
       class="event-name text-center pt-3 mb-0">{{$row->email}}</a>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <span class="">{{ !empty($row->phone) ? $row->phone : 'N/A' }}</span>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    <span class="">{{ Carbon\Carbon::parse($row->created_at)->isoFormat('Do MMM, YYYY') }}</span>
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    @can("user-enquiries.show")
    <div class="justify-content-center d-flex">
        <a title=" {{__('messages.common.view')}}"
           class="btn px-1 text-info enquiries-view-btn fs-3"
           href="javascript:void(0)" data-id="{{$row->id}}">
            <i class="fa-solid fa-eye"></i>
        </a>
    </div>
    @endcan
</x-livewire-tables::bs5.table.cell>
