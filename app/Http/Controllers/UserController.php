<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Vcard;
use App\Models\Section;
use Laracasts\Flash\Flash;
use App\Models\MultiTenant;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Role as CustomRole;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\UpdateChangePasswordRequest;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class UserController extends AppBaseController
{

    /**
     * @var UserRepository
     */
    public $userRepo;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
        $this->middleware('permission:users.index', ['only' => ['index']]);
        $this->middleware('permission:users.create', ['only' => ['create']]);
        $this->middleware('permission:users.store', ['only' => ['store']]);
        $this->middleware('permission:users.edit', ['only' => ['edit']]);
        $this->middleware('permission:users.update', ['only' => ['update']]);
        $this->middleware('permission:users.delete', ['only' => ['destroy']]);
        $this->middleware('permission:users.status', ['only' => ['updateStatus']]);
        $this->middleware('permission:users.impersonate', ['only' => ['impersonate']]);
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {

        return view('users.index');
    }

    /**
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $sections = Section::get();
        $roles = Role::get();
        return view('users.create',compact("sections","roles"));
    }

    /**
     * @param CreateUserRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();
        $this->userRepo->store($input);

        Flash::success(__('messages.flash.user_create'));

        return redirect(route('users.index'));
    }

    /**
     * @param User $user
     *
     * @return Application|Factory|View
     */
    public function show(Request $request, User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * @param User $user
     *
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        $sections = Section::get();
        $roles = Role::get();
        return view('users.edit', compact('user','sections','roles'));
    }

    /**
     * @param User $user
     *
     * @return JsonResponse
     */
    public function emailVerified(User $user)
    {
        DB::table('users')->where('id', $user->id)->update(['email_verified_at' => Carbon::now()]);

        return $this->sendSuccess(__('messages.flash.verified_email'));
    }

    /**
     * @param User $user
     *
     * @return JsonResponse
     */
    public function updateStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active,
        ]);

        return $this->sendSuccess(__('messages.flash.user_status'));
    }

    /**
     * @param UpdateUserRequest $request
     * @param User $user
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userRepo->update($request->all(), $user);

        Flash::success(__('messages.flash.user_update'));

        return redirect(route('users.index'));
    }

    /**
     * @param User $user
     *
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        Vcard::where('tenant_id', $user->tenant_id)->delete();
        MultiTenant::where('id', $user->tenant_id)->delete();
        Subscription::where('tenant_id', $user->tenant_id)->delete();
        $user->delete();

        return $this->sendSuccess('User deleted successfully.');
    }

    /**
     * @param User $user
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function impersonate(User $user)
    {
        getLogInUser()->impersonate($user);
        return redirect()->route("login");
    }

    /**
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function impersonateLeave()
    {
        getLogInUser()->leaveImpersonation();

        return redirect(route('users.index'));
    }

    /**
     * @return Application|Factory|View
     */
    public function editProfile()
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    /**
     * @param UpdateUserProfileRequest $request
     *
     * @return Application
     */
    public function updateProfile(UpdateUserProfileRequest $request)
    {
        $this->userRepo->updateProfile($request->all());
        Flash::success(__('messages.flash.user_profile'));

        return redirect(route('profile.setting'));
    }

    /**
     * @param UpdateChangePasswordRequest $request
     *
     * @return JsonResponse
     */
    public function changePassword(UpdateChangePasswordRequest $request)
    {
        $input = $request->all();

        try {
            /** @var User $user */
            $user = Auth::user();
            if (!Hash::check($input['current_password'], $user->password)) {
                return $this->sendError(__('messages.flash.current_invalid'));
            }
            $input['password'] = Hash::make($input['new_password']);
            $user->update($input);

            return $this->sendSuccess(__('messages.flash.password_update'));
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @param  Request  $request
     *
     *
     * @return JsonResponse
     */
    public function changeLanguage(Request $request)
    {
        $input = $request->all();

        $user = Auth::user();
        $user->update($input);

        return $this->sendSuccess(__('messages.flash.language_update'));
    }

    /**
     *
     *
     * @return RedirectResponse
     */
    public function changeMode()
    {

        $user = Auth::user();
        $user->update([
            'theme_mode' => !$user->theme_mode,
        ]);

        return redirect()->back();
    }
}
