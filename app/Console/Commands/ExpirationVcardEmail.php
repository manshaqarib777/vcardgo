<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Vcard;
use App\Models\Setting;
use App\Models\Subscription;
use Illuminate\Console\Command;
use App\Mail\ExpirationVcardMail;
use Illuminate\Support\Facades\Mail;

class ExpirationVcardEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email for expiration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $setting = Setting::pluck('value', 'key')->toArray();

        $subscriptions = Subscription::with('plan','tenant.user')
        ->where('status', Subscription::ACTIVE)
        ->whereDate('ends_at',Carbon::now()->addDays($setting["email_expiration"])->format('Y-m-d'))
        ->get();
        foreach ($subscriptions as $key => $subscription) {
            Mail::to($subscription->tenant->user->email)
                ->send(new ExpirationVcardMail('emails.expiration_vcard_mail',
                    'Your Plan will be expired tomorrow',
                    [
                        "data" => [
                            "purchased_at" => $subscription->starts_at,
                            "expiry_date" => $subscription->ends_at,
                            "plan_name" => $subscription->plan->name,
                            "customer_name" => $subscription->tenant->user->full_name,
                            "plan_price" => $subscription->plan->price,
                            "checkout_url" => url("/")."/admin/manage-subscription/upgrade/".$subscription->vcard->id,
                            "order_id" => $subscription->tenant_id,
                            "order_id" => $subscription->tenant_id,
                        ]
                    ]));
        }
    }
}
