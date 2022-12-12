<?php

namespace App\Http\Livewire;

use App\Models\Vcard;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Stancl\Tenancy\Database\Models\Tenant;

class VcardTable extends LivewireTableComponent
{
    public $paginationTheme = 'bootstrap-5';
    protected $listeners = ['refresh' => '$refresh', 'changeFilter'];
    public string $primaryKey = 'Vcard_id';
    protected string $pageName = 'Vcard-table';
    public string $defaultSortColumn = 'created_at';
    public string $defaultSortDirection = 'desc';

    public function columns(): array
    {
        return [
            Column::make(__('messages.vcard.vcard_name'), 'name')->sortable()->searchable(),
            Column::make(__('messages.vcard.vcard_unique_number'), 'vcard_unique_number')->sortable()->searchable(),
            Column::make(__('messages.vcard.user_name'), 'tenant.tenant_username')->sortable(function (
                Builder $query,
                $direction
            ) {
                return $query->orderBy(Tenant::select('tenant_username')->whereColumn('tenants.id', 'vcards.tenant_id'),
                    $direction);
            })
                ->searchable(),

            Column::make(__('messages.vcard.registration_vin_no'), 'registration_vin_no')->sortable()->searchable(),
            Column::make(__('messages.vcard.registration_vehicle_model'), 'registration_vehicle_model')->sortable()->searchable(),
            Column::make(__('messages.vcard.registration_vehicle_color'), 'registration_vehicle_color')->sortable()->searchable(),
            Column::make(__('messages.vcard.registration_vehicle_year'), 'registration_vehicle_year')->sortable()->searchable(),
            Column::make(__('messages.vcard.registration_plate_no'), 'registration_plate_no')->sortable()->searchable(),
            Column::make(__('messages.vcard.registration_district'), 'registration_district')->sortable()->searchable(),
            Column::make(__('messages.vcard.registration_emergency_contact_no'), 'registration_emergency_contact_no')->sortable()->searchable(),
            Column::make(__('messages.vcard.registration_ar_no'), 'registration_ar_no')->sortable()->searchable(),
            Column::make(__('messages.vcard.registration_pcn_no'), 'registration_pcn_no')->sortable()->searchable(),

            Column::make(__('messages.vcard.inspection_address'), 'inspection_address')->sortable()->searchable(),
            Column::make(__('messages.vcard.inspection_chassis_no'), 'inspection_chassis_no')->sortable()->searchable(),
            Column::make(__('messages.vcard.inspection_vin_no'), 'inspection_vin_no')->sortable()->searchable(),
            Column::make(__('messages.vcard.inspection_vehicle_model'), 'inspection_vehicle_model')->sortable()->searchable(),
            Column::make(__('messages.vcard.inspection_vehicle_color'), 'inspection_vehicle_color')->sortable()->searchable(),
            Column::make(__('messages.vcard.inspection_vehicle_year'), 'inspection_vehicle_year')->sortable()->searchable(),
            Column::make(__('messages.vcard.inspection_plate_no'), 'inspection_plate_no')->sortable()->searchable(),
            Column::make(__('messages.vcard.inspection_contact'), 'inspection_contact')->sortable()->searchable(),
            Column::make(__('messages.vcard.inspection_ar_no'), 'inspection_ar_no')->sortable()->searchable(),
            Column::make(__('messages.vcard.inspection_district'), 'inspection_district')->sortable()->searchable(),
            Column::make(__('messages.vcard.inspection_control_technique'), 'inspection_control_technique')->sortable()->searchable(),
            Column::make(__('messages.vcard.inspection_date_of_inspection'), 'inspection_date_of_inspection')->sortable()->searchable(),

            Column::make(__('messages.vcard.parking_owner_mobile_no'), 'parking_owner_mobile_no')->sortable()->searchable(),
            Column::make(__('messages.vcard.parking_address'), 'parking_address')->sortable()->searchable(),
            Column::make(__('messages.vcard.parking_vehicle_color'), 'parking_vehicle_color')->sortable()->searchable(),
            Column::make(__('messages.vcard.parking_vehicle_model'), 'parking_vehicle_model')->sortable()->searchable(),
            Column::make(__('messages.vcard.parking_plate_no'), 'parking_plate_no')->sortable()->searchable(),
            Column::make(__('messages.vcard.parking_mobile'), 'parking_mobile')->sortable()->searchable(),
            Column::make(__('messages.vcard.parking_district'), 'parking_district')->sortable()->searchable(),
            Column::make(__('messages.vcard.parking_p_place_of_registration'), 'parking_p_place_of_registration')->sortable()->searchable(),
            Column::make(__('messages.vcard.parking_p_registration_officer'), 'parking_p_registration_officer')->sortable()->searchable(),
            Column::make(__('messages.vcard.parking_p_date_of_payment'), 'parking_p_date_of_payment')->sortable()->searchable(),
            Column::make(__('messages.vcard.parking_parking_plan'), 'parking_parking_plan')->sortable()->searchable(),
            Column::make(__('messages.vcard.parking_date_of_inspection'), 'parking_date_of_inspection')->sortable()->searchable(),



            Column::make(__('messages.vcard.nationality'), 'nationality')->sortable()->searchable(),
            Column::make(__('messages.vcard.footer_text'), 'footer_text')->sortable()->searchable(),
            Column::make(__('messages.vcard.alternative_email'), 'alternative_email')->sortable()->searchable(),
            Column::make(__('messages.vcard.alternative_phone'), 'alternative_phone')->sortable()->searchable(),
            Column::make(__('messages.vcard.alternative_region_code'), 'alternative_region_code')->sortable()->searchable(),
            Column::make(__('messages.vcard.issue_date'), 'issue_date')->sortable()->searchable(),
            Column::make(__('messages.vcard.expire_date'), 'expire_date')->sortable()->searchable(),
            Column::make(__('messages.vcard.hair_color'), 'hair_color')->sortable()->searchable(),
            Column::make(__('messages.vcard.eye_color'), 'eye_color')->sortable()->searchable(),
            Column::make(__('messages.vcard.sex'), 'sex')->sortable()->searchable(),
            Column::make(__('messages.vcard.type'), 'type')->sortable()->searchable(),
            Column::make(__('messages.vcard.height'), 'height')->sortable()->searchable(),
            Column::make(__('messages.vcard.weight'), 'weight')->sortable()->searchable(),
            Column::make(__('messages.vcard.rstr'), 'rstr')->sortable()->searchable(),
            Column::make(__('messages.vcard.address'), 'address')->sortable()->searchable(),
            Column::make(__('messages.vcard.category'), 'category')->sortable()->searchable(),

            Column::make(__('messages.vcard.preview_url'), 'url_alias')->sortable(),
            Column::make(__('messages.vcard.stats')),
            Column::make(__('messages.vcard.created_at'), 'created_at')->sortable()->searchable(),
            Column::make(__('messages.vcard.status'), 'status')->sortable()->searchable(function (Builder $query, $searchTerm) {
                if(strtolower($searchTerm) == "active")
                $query->orWhere("status",1);
                else if(strtolower($searchTerm) == "deactive")
                $query->orWhere("status",2);

            }),
        ];
    }

    public function query(): Builder
    {
        return Vcard::with('template', 'tenant')->where('id', '!=', getLogInUserId());
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.vcard_table';
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
                'bulkActions'   => $this->bulkActions,
            ]);
    }
}
