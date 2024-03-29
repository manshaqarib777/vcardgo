<?php

namespace App\Http\Livewire;

use App\Models\Plan;
use App\Models\Vcard;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class UsersubscriptionTable extends LivewireTableComponent
{

    public function columns(): array
    {
        return [
            Column::make(__('messages.subscription.plan_name'), "plan.name")
                ->sortable(function (Builder $query,$direction) {
                return $query->orderBy(Plan::select('name')->whereColumn('subscriptions.plan_id', 'plans.id'),
                    $direction);
            })->searchable(),
            Column::make(__('messages.subscription.card_name'), "vcard.name")
                ->sortable(function (Builder $query,$direction) {
                return $query->orderBy(Vcard::select('name')->whereColumn('subscriptions.card_id', 'vcards.id'),
                    $direction);
            })->searchable(),
            Column::make(__('messages.subscription.amount'), "plan_amount")
                ->sortable(),
            Column::make(__('messages.subscription.subscribed_date'), "starts_at")
                ->sortable(),
            Column::make(__('messages.subscription.expired_date'), 'ends_at')->sortable(),
            Column::make(__('messages.common.status'), 'status')->sortable(),


        ];
    }

    public function query(): Builder
    {
        return Subscription::with(['plan.currency','vcard'])->where('tenant_id', getLogInTenantId())->select('subscriptions.*');
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.usersubscription_table';
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
