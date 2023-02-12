<?php

namespace App\Http\Livewire;


use App\Models\Vcard;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\ScheduleAppointment;

class ScheduleAppointmentTable extends LivewireTableComponent
{
    public $paginationTheme = 'bootstrap-5';
    public string $primaryKey = 'schedule_appointment_id';
    public string $defaultSortColumn = 'created_at';
    public string $defaultSortDirection = 'desc';
    protected $listeners = ['refresh' => '$refresh', 'changeFilter', 'resetPageTable'];
    protected string $pageName = 'schedule-appointment-table';
    public int $typeFilter = ScheduleAppointment::ALL;

    public function columns(): array
    {
        return [
            Column::make(__('messages.vcard.vcard_name'), 'vcard.name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(Vcard::select('name')->whereColumn('id', 'vcard_id'),
                        $direction);
                })->searchable(),
            Column::make(__('messages.common.name'), "name")
                ->sortable()->searchable(),
            Column::make(__('messages.common.email'), "email")
                ->sortable()->searchable(),
            Column::make(__('messages.common.phone'), "phone")
                ->sortable()->searchable(),
            Column::make(__('messages.date'), "date")
                ->sortable()->searchable(),
            Column::make(__('messages.from_time'), "from_time")
                ->sortable()->searchable()->addClass('justify-content-center d-flex'),
            Column::make(__('messages.to_time'), "to_time")
                ->sortable()->searchable()->addClass('w-100px '),
            Column::make(__('messages.common.type'), "id")->addClass('w-100px'),
            Column::make(__('messages.common.reason'), 'reason')->sortable()->searchable(),
            Column::make(__('messages.vcard.location'), 'location')->sortable()->searchable(),
            Column::make(__('messages.common.message'), 'message')->sortable()->searchable(),
            Column::make(__('messages.common.action'))->addClass('justify-content-center d-flex'),
        ];
    }

    public function changeFilter($value)
    {
        $this->typeFilter = $value;
    }

    public function query(): Builder
    {
        $vcardIds = Vcard::whereTenantId(getLogInTenantId())->pluck('id')->toArray();

        $scheduleAppointments = ScheduleAppointment::with('vcard')->whereIn('vcard_id', $vcardIds);

        if (isset($this->typeFilter) && $this->typeFilter != ScheduleAppointment::ALL){
            return $this->typeFilter == ScheduleAppointment::PAID
                ? $scheduleAppointments->whereNotNull('appointment_tran_id')
                : $scheduleAppointments->whereNull('appointment_tran_id');
        }

        return $scheduleAppointments;
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.schedule_appointment_table';
    }

    public function render()
    {
        $types = ScheduleAppointment::TYPES;

        return view('livewire-tables::'.config('livewire-tables.theme').'.datatable')
            ->with([
                'columns'       => $this->columns(),
                'rowView'       => $this->rowView(),
                'filtersView'   => $this->filtersView(),
                'customFilters' => $this->filters(),
                'rows'          => $this->rows,
                'modalsView'    => $this->modalsView(),
                'bulkActions'   => $this->bulkActions,
                'componentName' => 'appointment.calander-button',
                'filterComponent' => 'appointment.type-filter',
                'types'        => $types,
            ]);
    }

    public function resetPageTable($pageName = 'user-table')
    {
        $this->customResetPage($pageName);
    }
}
