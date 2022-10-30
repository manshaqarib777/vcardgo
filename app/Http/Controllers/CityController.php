<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use App\Repositories\CityRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends AppBaseController
{
    /**
     * @var CityRepository
     */
    private $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
        // $this->middleware('permission:cities.index', ['only' => ['index']]);
        $this->middleware('permission:cities.create', ['only' => ['create']]);
        $this->middleware('permission:cities.store', ['only' => ['store']]);
        $this->middleware('permission:cities.edit', ['only' => ['edit']]);
        $this->middleware('permission:cities.update', ['only' => ['update']]);
        $this->middleware('permission:cities.delete', ['only' => ['destroy']]);
        $this->middleware('permission:cities.status', ['only' => ['updateStatus']]);
        $this->middleware('permission:cities.impersonate', ['only' => ['impersonate']]);
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('sadmin.cities.index');
    }

    /**
     * @param CreateCityRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateCityRequest $request)
    {
        $input = $request->all();
        $state = $this->cityRepository->create($input);

        return $this->sendResponse($state, __('messages.flash.city_create'));
    }

    /**
     * @param City $city
     *
     * @return JsonResponse
     */
    public function edit(City $city)
    {
        return $this->sendResponse($city, 'City successfully retrieved.');
    }

    /**
     * @param UpdateCityRequest $request
     * @param City $city
     *
     * @return JsonResponse
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        $input = $request->all();
        $this->cityRepository->update($input, $city->id);

        return $this->sendSuccess(__('messages.flash.city_update'));
    }

    /**
     * @param City $city
     *
     * @return JsonResponse
     */
    public function destroy(City $city)
    {
        $city->delete();

        return $this->sendSuccess('City deleted successfully.');
    }
}
