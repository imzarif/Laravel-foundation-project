<?php

namespace App\Http\Controllers\Auth;

use App\Constant\AppConstant;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (
            $request->user()->hasVerifiedEmail() ||
            $request->user()->role_id != Role::getId(AppConstant::ROLE_CODE_CP)
        ) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }
        if (
            $request->user()->role_id == Role::getId(AppConstant::ROLE_CODE_CP)
        ) {
            $request->user()->sendEmailVerificationNotification();
        }

        return back()->with("status", "verification-link-sent");
    }
}
