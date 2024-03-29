<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use App\Models\Vcard;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class CheckSubscription
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return Application|RedirectResponse|Redirector|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request = $next($request);
        return $request;

        $subscription = Subscription::with('plan')
            ->where('status', Subscription::ACTIVE)
            ->where('tenant_id', getLogInUser()->tenant_id)
            ->first();

        if (!$subscription) {
            Vcard::where('tenant_id',getLogInUser()->tenant_id)->update([
                'status' => 0
            ]);
            return redirect(route('subscription.upgrade'))
                ->withErrors('Your plan is expired. Please choose a plan to continue the services');
        }

        if ($subscription->isExpired() && request()->segment(2) != "vcards" && request()->segment(2) != "vcard") {
            // Vcard::where('tenant_id',getLogInUser()->tenant_id)->update([
            //     'status' => 0
            // ]);
            return redirect(route('subscription.upgrade'))
                ->withErrors('Your plan is expired. Please choose a plan to continue the services');
        }

        return $request;
    }
}
