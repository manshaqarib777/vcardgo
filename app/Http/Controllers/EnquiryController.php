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

    public function store(CreateEnquiryRequest $request, Vcard $vcard)
    {
        $input = $request->all();
        $input['vcard_id'] = $vcard->id;
        $input['vcard_name'] = $vcard->name;
        Enquiry::create($input);
        $email = empty($vcard->email) ? $vcard->user->email : $vcard->email;

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
}
