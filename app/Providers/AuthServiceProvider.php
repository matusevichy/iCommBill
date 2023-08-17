<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Abonent;
use App\Models\Accrual;
use App\Models\Counter;
use App\Models\CounterValue;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\Saldo;
use App\Models\Tarif;
use App\Models\User;
use App\Policies\AbonentPolicy;
use App\Policies\AccrualPolicy;
use App\Policies\CounterPolicy;
use App\Policies\CounterValuePolicy;
use App\Policies\OrganizationPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\SaldoPolicy;
use App\Policies\TarifPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Abonent::class => AbonentPolicy::class,
        Accrual::class => AccrualPolicy::class,
        Counter::class => CounterPolicy::class,
        CounterValue::class => CounterValuePolicy::class,
        Organization::class => OrganizationPolicy::class,
        Payment::class => PaymentPolicy::class,
        Saldo::class => SaldoPolicy::class,
        Tarif::class => TarifPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
