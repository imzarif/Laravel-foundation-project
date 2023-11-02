<?php

namespace App\Http\Controllers\Auth;

use App\Constant\AppConstant;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\PartnerProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;



class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $partners =  array(
                array("code" =>  AppConstant::ROLE_CODE_CP, "name"=>"Content Provider(CP)"),
                array("code" =>  AppConstant::ROLE_CODE_VENDOR, "name"=>"Vendor Portal")
            );
        return view('auth.register', compact('partners'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'partner_code' => ['required'],
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'robi_spoc_email' => ['required', 'string', 'email', 'max:255'],
            'partner_spoc_email' => ['required', 'string', 'email', 'max:255'],
        ]);
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->company_name,
                'role_id' => Role::getId($request->partner_code),
                'email' => $request->email,
            ]);

            # Save spoc email in partners table
            PartnerProfile::create([
                'user_id' => $user->id,
                'robi_spoc_email' => $request->robi_spoc_email,
                'partner_spoc_email' => $request->partner_spoc_email,
                'email' => $request->email,
                'local_partner_name' => $request->company_name,
            ]);
            DB::commit();
            event(new Registered($user));
            Auth::login($user);
            Log::info('RegisteredUserController:store: User Creation successful' . $request->email);
            return redirect(Auth::user()->role->code . '/');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('RegisteredUserController:store: ' . $e->getMessage());
            return redirect()->route('login');
        }
    }
}
