<?php

namespace App\Http\Controllers;

use App\Models\EmailSubscription;
use App\Http\Requests\CreateEmailSubscriptionRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class EmailSubscriptionController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('permission:subscriptions.index', ['only' => ['index']]);
    }
    /**
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('email_subscription.index');
    }

    /**
     * @param  Request  $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateEmailSubscriptionRequest $request)
    {

        EmailSubscription::create($request->all());

        return $this->sendSuccess('Subscribed Successfully.');

    }

    /**
     * @param  EmailSubscription  $emailSubscription
     *
     * @return mixed
     */
    public function destroy(EmailSubscription $emailSubscription)
    {
        $emailSubscription->delete();
        return $this->sendSuccess('Email deleted successfully.');
    }
}
