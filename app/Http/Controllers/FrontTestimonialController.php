<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFrontTestimonialRequest;
use App\Http\Requests\UpdateFrontTestimonialRequest;
use App\Models\FrontTestimonial;
use App\Repositories\FrontTestimonialRepository;
use Illuminate\Http\Request;

class FrontTestimonialController extends AppBaseController
{
    private $frontTestimonialRepo;

    /**
     * @param  FrontTestimonialRepository  $frontTestimonialRepo
     */
    public function __construct(FrontTestimonialRepository $frontTestimonialRepo)
    {
        $this->frontTestimonialRepo = $frontTestimonialRepo;
        $this->middleware('permission:flag.index', ['only' => ['index']]);
        $this->middleware('permission:flag.create', ['only' => ['create']]);
        $this->middleware('permission:flag.store', ['only' => ['store']]);
        $this->middleware('permission:flag.edit', ['only' => ['edit']]);
        $this->middleware('permission:flag.update', ['only' => ['update']]);
        $this->middleware('permission:flag.delete', ['only' => ['destroy']]);
    }


    /**
     * @param  Request  $request
     *
     * @throws \Exception
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('sadmin.testimonial.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateFrontTestimonialRequest $request)
    {
        $input = $request->all();

        $testimonial = $this->frontTestimonialRepo->store($input);

        return $this->sendResponse($testimonial, __('messages.flash.create_front_testimonial'));
    }

    /**
     * @param  FrontTestimonial  $frontTestimonial
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(FrontTestimonial $frontTestimonial): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse($frontTestimonial, 'Testimonial successfully retrieved.');
    }

    /**
     * @param  UpdateFrontTestimonialRequest  $request
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateFrontTestimonialRequest $request)
    {
        $input = $request->all();

        $testimonial = $this->frontTestimonialRepo->update($input, $request->testimonial_id);

        return $this->sendResponse($testimonial, __('messages.flash.update_front_testimonial'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FrontTestimonial $frontTestimonial)
    {
        $frontTestimonial->clearMediaCollection(FrontTestimonial::PATH);
        $frontTestimonial->delete();

        return $this->sendSuccess('Testimonial deleted successfully.');
    }
}
