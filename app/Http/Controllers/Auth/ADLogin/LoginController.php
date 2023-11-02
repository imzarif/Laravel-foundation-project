<?php

namespace App\Http\Controllers\Auth\ADLogin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $token;

    public function login(ADLoginClient $adLoginClient, Request $request)
    {
        if (!isset($_REQUEST["code"])) {
            return redirect($adLoginClient->step1());
        } else {
            $this->token = $adLoginClient->step2($_REQUEST["code"]);

            if (isset($this->token)) {
                return $adLoginClient->step3($this->token, $request);
            } else {
                $adLoginClient->step1();
            }
        }
    }
}
