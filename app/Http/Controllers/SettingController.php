<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFrontCmsRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Meta;
use App\Models\PaymentGateway;
use App\Models\Plan;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class SettingController extends AppBaseController
{
    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * SettingController constructor.
     * @param  SettingRepository  $settingRepository
     */
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->middleware('permission:settings.index', ['only' => ['index']]);
        $this->middleware('permission:front-cms.index', ['only' => ['frontCmsIndex']]);
    }

    /**
     * @param  Request  $request
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $setting = Setting::pluck('value', 'key')->toArray();
        $selectedPaymentGateways = PaymentGateway::pluck('payment_gateway')->toArray();
        $metas = Meta::first();
        if (!empty($metas)){
            $metas = $metas->toArray();
        }
        return view("settings.general", compact('setting', 'selectedPaymentGateways', 'metas'));
    }

    /**
     * @param  UpdateSettingRequest  $request
     * @return RedirectResponse
     */
    public function update(UpdateSettingRequest $request)
    {
        if ($request->favicon){
            $imageSize = getimagesize($request->favicon);
            $width = $imageSize[0];
            $height = $imageSize[1];

            if ($width > 16 && $height > 16){
                Flash::error('The favicon has invalid image dimensions.');
                return redirect()->back();
            }
        }

        Meta::query()->delete();

        if (isset($request->site_title) || isset($request->site_title) || isset($request->site_title) || isset($request->site_title) || isset($request->google_analytics)){
            Meta::updateOrCreate([
               'site_title' => $request->site_title,
               'home_title' => $request->home_title,
               'meta_keyword' => $request->meta_keyword,
               'meta_description' => $request->meta_description,
               'google_analytics' => $request->google_analytics,
            ]);
        }
        $paymentGateways = $request->payment_gateway;
        PaymentGateway::query()->delete();

        if (isset($paymentGateways)) {
            foreach ($paymentGateways as $paymentGateway) {
                PaymentGateway::updateOrCreate(['payment_gateway_id' => $paymentGateway],
                    [
                        'payment_gateway' => Plan::PAYMENT_METHOD[$paymentGateway],
                    ]);
            }
        }

        $id = Auth::id();
        // dd($request->all());
        $this->settingRepository->update($request->all(), $id);

        Flash::success(__('messages.flash.setting_update'));

        return redirect(route('setting.index'));
    }

    /**
     *
     * @return Application|Factory|View
     */
    public function frontCmsIndex()
    {
        $setting = Setting::pluck('value', 'key')->toArray();

        return view("settings.front_cms.index", compact('setting'));

    }

    /**
     * @param  UpdateFrontCmsRequest  $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function frontCmsUpdate(UpdateFrontCmsRequest $request)
    {

        $id = Auth::id();

        $this->settingRepository->update($request->all(), $id);

        Flash::success(__('messages.flash.front_cms'));

        return redirect(route('setting.front.cms'));
    }
}
