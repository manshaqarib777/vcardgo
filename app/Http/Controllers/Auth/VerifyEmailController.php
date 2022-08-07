<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class VerifyEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = User::find($request->route('id'));
        
        if ($user->hasVerifiedEmail()) {
            Flash::success('Your mail is already verified, please login.');

            return redirect(route('login'));
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        Flash::success('You have successfully verified your mail, please login.');

        return redirect(route('login'));
    }
}
