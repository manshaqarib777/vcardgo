<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CurrencyController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('permission:currencies.index', ['only' => ['index']]);
    
    }
    /**
     * @param Request $request
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('sadmin.currencies.index');
    }
}
