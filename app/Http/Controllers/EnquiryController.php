<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEnquiryRequest;
use App\Jobs\SendEmailJob;
use App\Models\Enquiry;
use App\Models\Vcard;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnquiryController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('permission:enquiries.index', ['only' => ['index']]);
        $this->middleware('permission:enquiries.create', ['only' => ['create']]);
        // $this->middleware('permission:enquiries.store', ['only' => ['store']]);
        // $this->middleware('permission:enquiries.edit', ['only' => ['edit']]);
        // $this->middleware('permission:enquiries.update', ['only' => ['update']]);
        // $this->middleware('permission:enquiries.delete', ['only' => ['destroy']]);
    }
    /**
     * @param  CreateEnquiryRequest  $request
     * @param $id
     * @throws Exception
     * @return mixed
     */
    public function index(Request $request, $id)
    {
        return view('enquiry.index');
    }

    public function store(CreateEnquiryRequest $request)
    {
        $input = $request->except("enquiry_url");
        $input['vcard_id'] = auth()->id();
        $input['vcard_name'] = auth()->user()->first_name." ".auth()->user()->last_name;
        $enquiry = Enquiry::create($input);
        //dd($enquiry->phone);
        if (isset($request->enquiry_url) && !empty($request->enquiry_url)) {
            $enquiry->addMedia($request->enquiry_url)->toMediaCollection(Enquiry::ENQUIRYURL, config('app.media_disc'));
        }
        $email = $request->email;

        if (!empty($email)) {
            dispatch(new SendEmailJob($input, $email));
        }

        return $this->sendSuccess('Enquiry send successfully.');
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $enquiry = Enquiry::with('vcard')->where('id', '=', $id)->first();

        return $this->sendResponse($enquiry, 'Testimonial successfully retrieved.');
    }

    /**
     * @param Request $request
     *
     * @throws Exception
     *
     * @return Application|Factory|View
     */
    public function enquiryList(Request $request)
    {

        return view('enquiry.list');
    }

    /**
     * @param $id
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $enquiry = Enquiry::with('vcard')->where('id', '=', $id)->first();


        return $this->sendResponse($enquiry, 'Enquiry successfully retrieved.');
    }

    /**
     * @param $id
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $enquiry = Enquiry::where('id', $id)->first();
        $enquiry->clearMediaCollection(Enquiry::ENQUIRYURL);
        $enquiry->delete();

        return $this->sendSuccess('Enquiry deleted successfully.');
    }

    /**
     * @param  UpdateProductRequest  $request
     * @param $id
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateEnquiryRequest $request, $id)
    {
        $input = $request->except("enquiry_url");
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->update($input);

        if (isset($request['enquiry_url']) && ! empty($request['enquiry_url'])) {
            $enquiry->clearMediaCollection(Enquiry::ENQUIRYURL);
            $enquiry->addMedia($request['enquiry_url'])->toMediaCollection(Enquiry::ENQUIRYURL, config('app.media_disc'));
        }

        return $this->sendSuccess('Enquiry updated successfully.');
    }
}
