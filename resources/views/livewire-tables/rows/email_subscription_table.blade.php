<x-livewire-tables::bs5.table.cell>
    {{ $row->email }}
</x-livewire-tables::bs5.table.cell>

<x-livewire-tables::bs5.table.cell>
    @can("subscriptions.delete")
        <div class="justify-content-center d-flex">
            <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"
            class="btn px-1 text-danger fs-3 email-subscribe-delete-btn d-flex justify-content-center">
                <i class="fa-solid fa-trash"></i>
            </a>
        </div>
    @endcan
</x-livewire-tables::bs5.table.cell>
