<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRegisterRequest;
use App\Models\MultiTenant;
use App\Models\Plan;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laracasts\Flash\Flash;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class RegisteredUserController extends Controller
{
    /**
     *
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     * @param CreateRegisterRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateRegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $tenant = MultiTenant::create(['tenant_username' => $request->first_name]);

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'tenant_id'  => $tenant->id,
            ])->assignRole(Role::ROLE_ADMIN);
            $user->permissions()->sync(["dashboard.index","account-settings.index","change-password.index","change-language.index","user-vcards.index","user-vcards.create","user-vcards.store","user-vcards.edit","user-vcards.update","user-vcards.delete","user-vcards.status","user-vcards.upgrade-plan","user-vcards.show","user-enquiries.index","user-appointments.index","user-manage-subscriptions.index","user-settings.index","user-enquiries.show","user-appointments.calender"]);

            // $plan = Plan::whereIsDefault(true)->first();

            // Subscription::create([
            //     'plan_id'        => $plan->id,
            //     'plan_amount'    => $plan->price,
            //     'plan_frequency' => Plan::MONTHLY,
            //     'starts_at'      => Carbon::now(),
            //     'ends_at'        => Carbon::now()->addDays($plan->trial_days),
            //     'trial_ends_at'  => Carbon::now()->addDays($plan->trial_days),
            //     'status'         => Subscription::ACTIVE,
            //     'tenant_id'      => $tenant->id,
            //     'no_of_vcards'   => $plan->no_of_vcards,
            // ]);

            DB::commit();

//            Cache::forget('subscription');
            event(new Registered($user));

            Flash::success('You have registered successfully, Activate your account from mail.');

            return redirect(route('login'));
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
