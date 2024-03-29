<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentTransaction;
use App\Models\Currency;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\Vcard;
use App\Repositories\AppointmentRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class StripeController extends AppBaseController
{
    /**
     * @param Request $request
     *
     * @throws ApiErrorException
     *
     * @return JsonResponse
     */
    public function purchase(Request $request): JsonResponse
    {
        $plan = Plan::with('currency')->findOrFail($request->plan_id);

        setStripeApiKey();

        $session = Session::create([
            'payment_method_types' => ['card'],
            'customer_email'       => getLogInUser()->email,
            'line_items'           => [
                [
                    'name'     => $plan->name,
                    'amount'   => !in_array($plan->currency->currency_code,
                        zeroDecimalCurrencies()) ? removeCommaFromNumbers($plan->price) * 100 : removeCommaFromNumbers($plan->price),
                    'currency' => $plan->currency->currency_code,
                    'quantity' => 1,
                ],
            ],
            'success_url'          => route('stripe.success', $plan->id).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => route('stripe.failed').'?error=payment_cancelled',
        ]);
        $result = [
            'sessionId' => $session['id'],
        ];

        return $this->sendResponse($result, 'Subscription resumed successfully.');
    }

    /**
     * @param Request $request
     * @param Plan $plan
     *
     * @throws Exception
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function paymentSuccess(Request $request, Plan $plan)
    {
        $sessionId = $request->get('session_id');
        if (empty($sessionId)) {
            throw new UnprocessableEntityHttpException('session_id required');
        }

        try {
            setStripeApiKey();
            $sessionData = Session::retrieve($sessionId);

            DB::beginTransaction();

            Transaction::create([
                'transaction_id' => $sessionData->payment_intent,
                'amount'         => $sessionData->amount_total / 100,
                'type'           => Transaction::STRIPE,
            ]);

            Subscription::whereTenantId(getLogInTenantId())
                ->whereIsActive(true)->update(['is_active' => false]);

            $expiryDate = setExpiryDate($plan);

            Subscription::create([
                'plan_id'   => $plan->id,
                'expiry_at' => $expiryDate,
                'is_active' => true,
            ]);

            DB::commit();

//            Cache::forget('subscription');
            
            Flash::success('You purchase this plan successfully');

            return view('sadmin.plans.payment.paymentSuccess');
        } catch (ApiErrorException $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function paymentFailed(Request $request)
    {
        return view('sadmin.plans.payment.paymentcancel');
    }


    /**
     * @param Request $request
     * @throws Exception
     * @return Application|RedirectResponse|Redirector
     */
    public function userPaymentSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');
        if (empty($sessionId)) {
            throw new UnprocessableEntityHttpException('session_id required');
        }

        $vcard = Vcard::with('tenant.user')->where('id', $request->get('vcard_id'))->first();

        $userId = $vcard->tenant->user->id;

        try {
            setUserStripeApiKey($userId);
            $sessionData = Session::retrieve($sessionId);
            $currencyId = Currency::whereCurrencyCode($sessionData->currency)->first()->id;

            DB::beginTransaction();

            $appointmentTran = AppointmentTransaction::create([
                'vcard_id'       => $vcard->id,
                'transaction_id' => $sessionData->payment_intent,
                'currency_id'    => $currencyId,
                'amount'         => $sessionData->amount_total / 100,
                'tenant_id'      => $vcard->tenant->id,
                'type'           => Appointment::STRIPE,
                'status'         => Transaction::SUCCESS,
                'meta'           => json_encode($sessionData),
            ]);

            $appointmentInput = session()->get('appointment_details');
            session()->forget('appointment_details');
            $appointmentInput['appointment_tran_id'] = $appointmentTran->id;

            /** @var AppointmentRepository $appointmentRepo */
            $appointmentRepo = App::make(AppointmentRepository::class);
            $vcardEmail = is_null($vcard->email) ? $vcard->tenant->user->email : $vcard->email;
            $appointmentRepo->appointmentStoreOrEmail($appointmentInput, $vcardEmail);

            DB::commit();

            Flash::success('Payment successfully done');

            return redirect(route('vcard.show', [$vcard->url_alias, 'Appointment created successfully.']));
        } catch (ApiErrorException $e) {
            DB::rollBack();

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param Request $request
     *
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function userHandleFailedPayment(Request $request)
    {
        session()->forget('appointment_details');

        Flash::error('Your Payment is Cancelled');

        return redirect(route('vcard.show', $request->get('vcard_id')));
    }
}
