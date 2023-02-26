<?php

namespace App\Http\Livewire;


use App\Models\Vcard;
use App\Models\Gallery;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class GalleryTable extends LivewireTableComponent
{

    public $paginationTheme = 'bootstrap-5';
    protected $listeners = ['refresh' => '$refresh', 'changeFilter', 'resetPageTable'];
    public string $primaryKey = 'gallery_id';
    protected string $pageName = 'gallery-table';
    public string $defaultSortColumn = 'created_at';
    public string $defaultSortDirection = 'desc';
    public $vcardId;

    public function columns(): array
    {
        return [
            Column::make(__('messages.common.type'), "type"),
            Column::make(__('messages.common.link'), "link")
                ->sortable()->searchable()->addClass('w-800px'),

            Column::make(__('messages.gallery.gallery_name'), 'gallery_name')->sortable()->searchable(),
            Column::make(__('messages.gallery.description'), 'description')->sortable()->searchable(),
            Column::make(__('messages.gallery.date'), 'date')->sortable()->searchable(),
            Column::make(__('messages.gallery.ticket_fine'), 'ticket_fine')->sortable()->searchable(),
            Column::make(__('messages.gallery.ticket_status'), 'ticket_status')->sortable()->searchable(),
            Column::make(__('messages.gallery.date_before'), 'date_before')->sortable()->searchable(),
            Column::make(__('messages.gallery.fine'), 'fine')->sortable()->searchable(),
            Column::make(__('messages.gallery.suspended_description'), 'suspended_description')->sortable()->searchable(),
            Column::make(__('messages.gallery.agent_name'), 'agent_name')->sortable()->searchable(),
            Column::make(__('messages.gallery.days'),)

        ];
    }

    public function query(): Builder
    {
        $vcardIds = Vcard::whereTenantId(getLogInTenantId())->pluck('id')->toArray();

        return Gallery::with('media')->whereIn('vcard_id', $vcardIds);
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.gallery_table';
    }

    public function render()
    {

        return view('livewire-tables::'.config('livewire-tables.theme').'.datatable')
            ->with([
                'columns'       => $this->columns(),
                'rowView'       => $this->rowView(),
                'filtersView'   => $this->filtersView(),
                'customFilters' => $this->filters(),
                'rows'          => $this->rows,
                'modalsView'    => $this->modalsView(),
                'bulkActions'   => $this->bulkActions
            ]);
    }

    public function resetPageTable($pageName = 'gallery-table')
    {
        $this->customResetPage($pageName);
    }
}
