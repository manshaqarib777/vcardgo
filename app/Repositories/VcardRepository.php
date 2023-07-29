<?php

namespace App\Repositories;

use DB;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Vcard;
use App\Models\Analytic;
use Carbon\CarbonPeriod;
use App\Models\SocialLink;
use App\Models\Appointment;
use App\Models\BusinessHour;
use App\Models\Subscription;
use App\Models\PrivacyPolicy;
use App\Models\TermCondition;
use App\Models\AppointmentDetail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class VcardRepository extends BaseRepository
{
    /**
     * @var array
     */
    public $fieldSearchable = [
        'name',
    ];

    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Vcard::class;
    }

    /**
     * @param $input
     *
     * @return mixed
     */
    public function store($input)
    {
        try {
            DB::beginTransaction();
            if (isset($input['url_alias'])) {
                $input['url_alias'] = str_replace(' ', '-', $input['url_alias']);
            }

            $plan = Plan::whereIsDefault(true)->first();

            $subscription = Subscription::create([
                'plan_id'        => $plan->id,
                'plan_amount'    => $plan->price,
                'plan_frequency' => Plan::MONTHLY,
                'starts_at'      => Carbon::now(),
                'ends_at'        => Carbon::now()->addDays($plan->trial_days),
                'trial_ends_at'  => Carbon::now()->addDays($plan->trial_days),
                'status'         => Subscription::ACTIVE,
                'tenant_id'      => getLogInTenantId(),
                'no_of_vcards'   => $plan->no_of_vcards,
            ]);

            // $subscription = getCurrentSubscription();
            if ($subscription->plan) {
                $input['template_id'] = $subscription->plan->templates->first()->id;
            }
            $vcard = Vcard::create($input);
            $subscription->update(['card_id'=> $vcard->id]);
            $vcard->update(['vcard_unique_number'=> getUniqueNumber($vcard->id)]);

            $input['vcard_id'] = $vcard->id;
            SocialLink::create($input);

            if (isset($input['profile_img']) && !empty($input['profile_img'])) {
                $vcard->addMedia($input['profile_img'])->toMediaCollection(Vcard::PROFILE_PATH,
                    config('app.media_disc'));
            }
            if (isset($input['cover_img']) && !empty($input['cover_img'])) {
                $vcard->addMedia($input['cover_img'])->toMediaCollection(Vcard::COVER_PATH, config('app.media_disc'));
            }

            if (isset($input['id_back']) && !empty($input['id_back'])) {
                $vcard->addMedia($input['id_back'])->toMediaCollection(Vcard::ID_BACK,
                    config('app.media_disc'));
            }
            if (isset($input['id_back2']) && !empty($input['id_back2'])) {
                $vcard->addMedia($input['id_back2'])->toMediaCollection(Vcard::ID_BACK2,
                    config('app.media_disc'));
            }
            if (isset($input['registration_driver_image']) && !empty($input['registration_driver_image'])) {
                $vcard->addMedia($input['registration_driver_image'])->toMediaCollection(Vcard::REGISTRATION_DRIVER_IMAGE,
                    config('app.media_disc'));
            }
            if (isset($input['barcode']) && !empty($input['barcode'])) {
                $vcard->addMedia($input['barcode'])->toMediaCollection(Vcard::BARCODE,
                    config('app.media_disc'));
            }
            if (isset($input['qrcode']) && !empty($input['qrcode'])) {
                $vcard->addMedia($input['qrcode'])->toMediaCollection(Vcard::QRCODE,
                    config('app.media_disc'));
            }
            if (isset($input['category_a']) && !empty($input['category_a'])) {
                $vcard->addMedia($input['category_a'])->toMediaCollection(Vcard::CATEGORYA,
                    config('app.media_disc'));
            }
            if (isset($input['category_b']) && !empty($input['category_b'])) {
                $vcard->addMedia($input['category_b'])->toMediaCollection(Vcard::CATEGORYB,
                    config('app.media_disc'));
            }
            if (isset($input['category_c']) && !empty($input['category_c'])) {
                $vcard->addMedia($input['category_c'])->toMediaCollection(Vcard::CATEGORYC,
                    config('app.media_disc'));
            }
            if (isset($input['category_d']) && !empty($input['category_d'])) {
                $vcard->addMedia($input['category_d'])->toMediaCollection(Vcard::CATEGORYD,
                    config('app.media_disc'));
            }
            if (isset($input['category_e']) && !empty($input['category_e'])) {
                $vcard->addMedia($input['category_e'])->toMediaCollection(Vcard::CATEGORYE,
                    config('app.media_disc'));
            }

            DB::commit();

            return $vcard;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param $vcard
     *
     * @return array
     */
    public function edit($vcard): array
    {
        $data['vcard'] = $vcard;

        $businessHours = $vcard->businessHours()->get();

        foreach ($businessHours as $hour) {
            $data['hours'][$hour->day_of_week] = [
                'start_time' => $hour->start_time,
                'end_time'   => $hour->end_time,
            ];
        }

        $appointmentHours = $vcard->appointmentHours()->get()->groupBy('day_of_week');

        foreach ($appointmentHours as $day => $hours) {
            foreach ($hours as $hour) {
                $data['time'][$day][] = [
                    'start_time' => $hour->start_time,
                    'end_time'   => $hour->end_time,
                ];
            }
        }

        $data['socialLink'] = SocialLink::whereVcardId($vcard->id)->first();
        $currentPlan = getCurrentSubscription();
        if ($currentPlan->plan) {
            $data['templates'] = getTemplateUrls($currentPlan->plan->templates);
        } else {
            $data['templates'] = getTemplateUrls();
        }

        return $data;
    }

    /**
     * @param array $input
     * @param int $vcard
     *
     *
     * @return Builder|Builder[]|Collection|Model|int
     */
    public function update($input, $vcard)
    {
        try {
            DB::beginTransaction();
            if (isset($input['url_alias'])) {
                $input['url_alias'] = str_replace(' ', '-', $input['url_alias']);
            }
            if (isset($input['phone'])) {
                $input['phone'] = str_replace([' ', '-'], '', $input['phone']);
            }
            if (isset($input['part']) && $input['part'] == 'templates') {
                $planTemplates = getCurrentSubscription()->plan->templates()->pluck('template_id')->toArray();
                if (!in_array($input['template_id'], $planTemplates)) {
                    $input['template_id'] = $planTemplates[array_rand($planTemplates)];
                }
                $input['share_btn'] = isset($input['share_btn']);
                $input['status'] = isset($input['status']);
            }
            if (isset($input['part']) && $input['part'] == 'advanced') {
                $input['password'] = isset($input['password']) ? Crypt::encrypt($input['password']) : '';
                $input['branding'] = isset($input['branding']);
            }

            if (!isset($input['part']) || $input['part'] == 'basic') {
                $input['language_enable'] = isset($input['language_enable']) ? 1 : 0;
            }

            if (!isset($input['part']) || $input['part'] == 'custom_id') {
                $input['category_a_checkbox'] = isset($input['category_a_checkbox']) ? 1 : 0;
                $input['category_b_checkbox'] = isset($input['category_b_checkbox']) ? 1 : 0;
                $input['category_c_checkbox'] = isset($input['category_c_checkbox']) ? 1 : 0;
                $input['category_d_checkbox'] = isset($input['category_d_checkbox']) ? 1 : 0;
                $input['category_e_checkbox'] = isset($input['category_e_checkbox']) ? 1 : 0;
            }
            if (!isset($input['part']) || $input['part'] == 'registration_custom_idea') {
                $input['registration_driver'] = isset($input['registration_driver']) ? 1 : 0;
            }
            $vcard->update($input);

            if (isset($input['part']) && $input['part'] == 'business_hours') {
                BusinessHour::whereVcardId($vcard->id)->delete();
                if (isset($input['days'])) {
                    foreach ($input['days'] as $day) {
                        BusinessHour::create([
                            'vcard_id'    => $vcard->id,
                            'day_of_week' => $day,
                            'start_time'  => $input['startTime'][$day],
                            'end_time'    => $input['endTime'][$day],
                        ]);
                    }
                }
            }

            if (isset($input['part']) && $input['part'] == 'appointments') {
                Appointment::whereVcardId($vcard->id)->delete();
                if (isset($input['checked_week_days'])) {
                    foreach ($input['checked_week_days'] as $day) {
                        $this->saveSlots($input, $day, $vcard);
                    }
                }

                $appointmentDetails = AppointmentDetail::where('vcard_id', $vcard->id)->first();

                if (isset($input['is_paid'])) {
                    if (!empty($appointmentDetails)) {
                        $appointmentDetails->update([
                            'is_paid' => $input['is_paid'],
                            'price'   => $input['price'],
                        ]);
                    } else {
                        AppointmentDetail::create([
                            'vcard_id' => $vcard->id,
                            'is_paid'  => $input['is_paid'],
                            'price'    => $input['price'],
                        ]);
                    }
                }
            }

            $socialLink = SocialLink::whereVcardId($vcard->id)->first();
            $socialLink->update($input);

            if (isset($input['profile_img']) && !empty($input['profile_img'])) {
                $vcard->clearMediaCollection(Vcard::PROFILE_PATH);
                $vcard->addMedia($input['profile_img'])->toMediaCollection(Vcard::PROFILE_PATH,
                    config('app.media_disc'));
            }
            if (isset($input['cover_img']) && !empty($input['cover_img'])) {
                $vcard->clearMediaCollection(Vcard::COVER_PATH);
                $vcard->addMedia($input['cover_img'])->toMediaCollection(Vcard::COVER_PATH, config('app.media_disc'));
            }

            if (isset($input['id_back']) && !empty($input['id_back'])) {
                $vcard->clearMediaCollection(Vcard::ID_BACK);
                $vcard->addMedia($input['id_back'])->toMediaCollection(Vcard::ID_BACK,
                    config('app.media_disc'));
            }
            if (isset($input['id_back2']) && !empty($input['id_back2'])) {
                $vcard->clearMediaCollection(Vcard::ID_BACK2);
                $vcard->addMedia($input['id_back2'])->toMediaCollection(Vcard::ID_BACK2,
                    config('app.media_disc'));
            }
            if (isset($input['registration_driver_image']) && !empty($input['registration_driver_image'])) {
                $vcard->clearMediaCollection(Vcard::REGISTRATION_DRIVER_IMAGE);
                $vcard->addMedia($input['registration_driver_image'])->toMediaCollection(Vcard::REGISTRATION_DRIVER_IMAGE,
                    config('app.media_disc'));
            }
            if (isset($input['barcode']) && !empty($input['barcode'])) {
                $vcard->clearMediaCollection(Vcard::BARCODE);
                $vcard->addMedia($input['barcode'])->toMediaCollection(Vcard::BARCODE,
                    config('app.media_disc'));
            }
            if (isset($input['qrcode']) && !empty($input['qrcode'])) {
                $vcard->clearMediaCollection(Vcard::QRCODE);
                $vcard->addMedia($input['qrcode'])->toMediaCollection(Vcard::QRCODE,
                    config('app.media_disc'));
            }
            if (isset($input['category_a']) && !empty($input['category_a'])) {
                $vcard->clearMediaCollection(Vcard::CATEGORYA);

                $vcard->addMedia($input['category_a'])->toMediaCollection(Vcard::CATEGORYA,
                    config('app.media_disc'));
            }
            if (isset($input['category_b']) && !empty($input['category_b'])) {
                $vcard->clearMediaCollection(Vcard::CATEGORYB);

                $vcard->addMedia($input['category_b'])->toMediaCollection(Vcard::CATEGORYB,
                    config('app.media_disc'));
            }
            if (isset($input['category_c']) && !empty($input['category_c'])) {
                $vcard->clearMediaCollection(Vcard::CATEGORYC);
                $vcard->addMedia($input['category_c'])->toMediaCollection(Vcard::CATEGORYC,
                    config('app.media_disc'));
            }
            if (isset($input['category_d']) && !empty($input['category_d'])) {
                $vcard->clearMediaCollection(Vcard::CATEGORYD);
                $vcard->addMedia($input['category_d'])->toMediaCollection(Vcard::CATEGORYD,
                    config('app.media_disc'));
            }
            if (isset($input['category_e']) && !empty($input['category_e'])) {
                $vcard->clearMediaCollection(Vcard::CATEGORYE);
                $vcard->addMedia($input['category_e'])->toMediaCollection(Vcard::CATEGORYE,
                    config('app.media_disc'));
            }

            if (isset($input['privacy_policy']) && !empty($input['privacy_policy'])) {
                $privacyPolicy = PrivacyPolicy::where('vcard_id', $vcard->id)->first();
                if ($privacyPolicy) {
                    $privacyPolicy->update($input);
                } else {
                    PrivacyPolicy::create([
                        'vcard_id'       => $vcard->id,
                        'privacy_policy' => $input['privacy_policy'],
                    ]);
                }
            }

            if (isset($input['term_condition']) && !empty($input['term_condition'])) {
                $termCondition = TermCondition::where('vcard_id', $vcard->id)->first();
                if ($termCondition) {
                    $termCondition->update($input);
                } else {
                    TermCondition::create([
                        'vcard_id'       => $vcard->id,
                        'term_condition' => $input['term_condition'],
                    ]);
                }
            }
            DB::commit();

            return $vcard;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     *
     * @return bool
     */
    public function checkTotalVcard(): bool
    {
        $makeVcard = true;
        // $subscription = Subscription::where('tenant_id', getLogInTenantId())->where('status',
        //     Subscription::ACTIVE)->first();

        // if (!empty($subscription)) {
        //     $totalCards = Vcard::whereTenantId(getLogInTenantId())->count();
        //     $makeVcard = $subscription->no_of_vcards > $totalCards;
        // }

        return $makeVcard;
    }

    /**
     * @param $input
     * @param $day
     * @param $vcard
     *
     *
     * @return bool
     */
    public function saveSlots($input, $day, $vcard)
    {
        $startTimeArr = $input['startTimes'][$day] ?? [];
        $endTimeArr = $input['endTimes'][$day] ?? [];
        if (count($startTimeArr) != 0 && count($endTimeArr) != 0) {
            foreach (array_unique($startTimeArr) as $key => $startTime) {
                Appointment::create([
                    'vcard_id'    => $vcard->id,
                    'day_of_week' => $day,
                    'start_time'  => $startTime,
                    'end_time'    => $endTimeArr[$key],
                ]);
            }
        }

        return true;
    }

    /**
     * @param $input
     * @param $vcard
     *
     *
     * @return array
     */
    public function analyticsData($input, $vcard): array
    {

        $analytics = Analytic::where('vcard_id', $vcard->id)->get();
        if ($analytics->count() > 0) {
            $DataCount = $analytics->count();
            $percentage = 100 / $DataCount;
            $browser = $analytics->groupBy('browser');
            $data = [];
            foreach ($browser as $key => $item) {
                $browser_record[$key]['count'] = $item->count();
                $browser_record[$key]['per'] = $item->count() * $percentage;
            }

            $browser_data = collect($browser_record)->sortBy('count')->reverse()->toArray();

            $data['browser'] = $browser_data;

            $device = $analytics->groupBy('device');

            foreach ($device as $key => $item) {
                $device_record[$key]['count'] = $item->count();
                $device_record[$key]['per'] = $item->count() * $percentage;
            }

            $device_data = collect($device_record)->sortBy('count')->reverse()->toArray();

            $data['device'] = $device_data;

            $country = $analytics->groupBy('country');

            foreach ($country as $key => $item) {
                $country_record[$key]['count'] = $item->count();
                $country_record[$key]['per'] = $item->count() * $percentage;
            }

            $country_data = collect($country_record)->sortBy('count')->reverse()->toArray();

            $data['country'] = $country_data;

            $operating_system = $analytics->groupBy('operating_system');

            foreach ($operating_system as $key => $item) {
                $operating_record[$key]['count'] = $item->count();
                $operating_record[$key]['per'] = $item->count() * $percentage;
            }

            $operating_data = collect($operating_record)->sortBy('count')->reverse()->toArray();

            $data['operating_system'] = $operating_data;

            $language = $analytics->groupBy('language');

            foreach ($language as $key => $item) {

                $language_record[$key]['count'] = $item->count();
                $language_record[$key]['per'] = $item->count() * $percentage;
            }

            $language_data = collect($language_record)->sortBy('count')->reverse()->toArray();

            $data['language'] = $language_data;

            $data['vcardID'] = $vcard->id;

            return $data;
        }
        $data['noRecord'] = 'No Record Found';

        return $data;

    }

    /**
     * @param $input
     *
     *
     * @return array
     */
    public function chartData($input): array
    {
        $startDate = isset($input['start_date']) ? Carbon::parse($input['start_date']) : '';
        $endDate = isset($input['end_date']) ? Carbon::parse($input['end_date']) : '';
        $data = [];

        $analytics = Analytic::where('vcard_id', $input['vcardId']);
        $visitor = $analytics->addSelect([\DB::raw('DAY(created_at) as day,created_at')])
            ->addSelect([\DB::raw('Month(created_at) as month,created_at')])
            ->addSelect([\DB::raw('YEAR(created_at) as year,created_at')])
            ->orderBy('created_at')
            ->get();
        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            $data['totalVisitorCount'][] = $visitor->where('day', $date->format('d'))->where('month',
                $date->format('m'))->count();
            $data['weeklyLabels'][] = $date->format('d-m-y');
        }

        return $data;
    }

    public function dashboardChartData($input)
    {
        $startDate = isset($input['start_date']) ? Carbon::parse($input['start_date']) : '';
        $endDate = isset($input['end_date']) ? Carbon::parse($input['end_date']) : '';
        $data = [];

        $vcardIds = Vcard::where('tenant_id', getLogInTenantId())->pluck('id')->toArray();

//        $analytics = Analytic::with('vcard')->whereIn('vcard_id', $vcardIds);
//        $visitor = $analytics->addSelect([\DB::raw('DAY(created_at) as day,created_at')])
//            ->addSelect([\DB::raw('Month(created_at) as month,created_at')])
//            ->addSelect([\DB::raw('YEAR(created_at) as year,created_at')])
//            ->addSelect([\DB::raw('vcard_id')])
//            ->orderBy('created_at')
//            ->get();
        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
//            $data['totalVisitorCount'][] = $visitor->where('day', $date->format('d'))->where('month',
//                $date->format('m'))->count();
            $data['weeklyLabels'][] = $date->format('d-m-y');
        }

        $colors = [
            'rgb(245, 158, 11',
            'rgb(77, 124, 15',
            'rgb(254, 199, 2',
            'rgb(80, 205, 137',
            'rgb(16, 158, 247',
            'rgb(241, 65, 108',
            'rgb(80, 205, 137',
            'rgb(245, 152, 28',
            'rgb(13, 148, 136',
            'rgb(59, 130, 246',
            'rgb(162, 28, 175',
            'rgb(190, 18, 60',
            'rgb(244, 63, 94',
            'rgb(30, 30, 45',
        ];

        $vcards = Vcard::whereIn('id', $vcardIds)->get()->keyBy('id');

        $analytics = Analytic::whereIn('vcard_id', $vcardIds);
        $visitor = $analytics->addSelect([\DB::raw('DAY(created_at) as day, created_at')])
            ->addSelect([\DB::raw('Month(created_at) as month,created_at')])
            ->addSelect([\DB::raw('YEAR(created_at) as year,created_at')])
            ->addSelect([\DB::raw('vcard_id')])
            ->orderBy('created_at')
            ->get()
            ->groupBy('vcard_id');

        foreach ($vcardIds as $key => $vcardId) {
            $color = $colors[ceil($key % count($colors))];
            $visitorArr = isset($visitor[$vcardId]) ? $visitor[$vcardId] : [];
            $data['data'][] = $this->getData($vcards[$vcardId], $startDate, $endDate, $color, $visitorArr);
        }

        return $data;
    }

    public function getData($vcard, $startDate, $endDate, $color, $visitor = null)
    {
        $period = CarbonPeriod::create($startDate, $endDate);
        $data = [];
        $data['backgroundColor'] = $color.')';
        $data['label'] = $vcard->name;
        $data['data'] = $this->getVisitor($period, $vcard->id, $visitor);
        $data['lineTension'] = 0.5;
        $data['radius'] = 4;
        $data['borderColor'] = $color.', 0.7)';

        return $data;
    }


    public function getVisitor($period, $vcardId, $visitor)
    {
        $data = [];
        foreach ($period as $date) {
            try {
                if ($visitor instanceof Collection) {
                    $count = $visitor->where('day', $date->format('d'))->where('month',
                        $date->format('m'))->count();
                    $data[] = $count;

                } else {
                    if (empty($visitor)) {
                        $data[] = 0;
                    } else {
                        if ($visitor instanceof Analytic) {
                            $count = ($visitor->day == $date->format('d') && $visitor->month == $date->format('m')) ? 1 : 0;
                            $data[] = $count;
                        }
                    }
                }

            } catch (\Exception $exception) {
            }
        }

        return $data;
    }
}
