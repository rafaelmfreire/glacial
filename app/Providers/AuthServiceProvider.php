<?php

namespace App\Providers;

use App\Models\AirConditioner;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\Team;
use App\Models\User;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-brands', function (User $user) {
            return $user->hasTeamPermission($user->currentTeam, 'brand:view');
        });

        Gate::define('view-contract-items', function (User $user) {
            return $user->hasTeamPermission($user->currentTeam, 'contract_item:view');
        });

        Gate::define('create-user', function (User $user) {
            return $user->hasTeamPermission($user->currentTeam, 'user:create');
        });

        Gate::define('view-air-conditioner', function (User $user, AirConditioner $airConditioner) {
            return $user->currentTeam->id === $airConditioner->team_id;
        });

        Gate::define('view-quote-items', function (User $user, Quote $quote) {
            $quoteItems = QuoteItem::where('quote_id', $quote->id)->whereHas('airConditioner', function ($query) use ($user) {
                $query->where('team_id', $user->currentTeam->id);
            })->get();
            return $quoteItems->count() > 0;
        });

        Gate::define('view-requisition-items', function (User $user, Requisition $requisition) {
            $requisitionItems = RequisitionItem::where('requisition_id', $requisition->id)->whereHas('airConditioner', function ($query) use ($user) {
                $query->where('team_id', $user->currentTeam->id);
            })->get();
            return $requisitionItems->count() > 0;
        });
    }
}
