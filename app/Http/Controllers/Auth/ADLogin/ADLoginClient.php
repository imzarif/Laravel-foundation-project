<?php

namespace App\Http\Controllers\Auth\ADLogin;

use App\Constant\AppConstant;
use App\Models\PartnerProfile;
use App\Models\RobiHRSupervisor;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ADLoginClient
{
    protected $baseUrl = "https://login.microsoftonline.com/";

    protected const AUTHORIZE_URL = "/oauth2/v2.0/authorize";
    protected const ACCESS_TOKEN_URL = "/oauth2/v2.0/token";
    protected const USER_DATA_URL = "/oauth2/v2.0/userinfo";

    protected $accessToken;

    private function getAuthUrl()
    {
        return $this->baseUrl . env('AZURE_TENANT_ID') . self::AUTHORIZE_URL;
    }

    private function generateRandString()
    {
        return hash("sha512", uniqid(random_int(1, PHP_INT_MAX), true));
    }

    private function setNonce()
    {
        $this->nonce = $this->generateRandString();
        $_SESSION['openid_connect_nonce'] = $this->nonce;
    }

    private function setState()
    {
        $this->state = $this->generateRandString();
        $_SESSION['openid_connect_state'] = $this->nonce;
    }

    private function getAccessTokenUrl()
    {
        return $this->baseUrl . env('AZURE_TENANT_ID') . self::ACCESS_TOKEN_URL;
    }

    private function post($url, $params, $headers = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params, null, '&'));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        $return = curl_exec($ch);

        curl_close($ch);

        return $return;
    }

    public function getToken($request, string $code, string $state = null)
    {
        try {
            if (!is_null($state) && $request->session()->get('state') != $state) {
                throw new \Exception("State parameter does not matched.", 1);
            }
            $url = $this->host . $this->tenant_id . self::ACCESS_TOKEN_URL;
            $tokens = $this->guzzle->post(
                $url,
                [
                    'form_params' => [
                        'client_id' => $this->client_id,
                        'client_secret' => $this->client_secret,
                        'redirect_uri' => $this->redirect_uri,
                        'scope' => implode(' ', $this->scopes),
                        'grant_type' => 'authorization_code',
                        'code' => $code,
                    ],
                ]
            )->getBody()->getContents();
            return json_decode($tokens);
        } catch (\Exception $e) {
            Log::error("ADLoginClientController:getToken:" . $e->getMessage());
            return response()->json([
                "success" => false,
                "error_message" => $e->getMessage(),
            ]);
        }
    }

    public function setAccessToken(Request $request)
    {
        if ($this->accessToken) {
            $this->accessToken = trim($this->accessToken);
        }
        $request->session()->put("accessToken", $this->accessToken);
        return $request->session()->get("accessToken");
    }

    public function step1()
    {
        $url = $this->getAuthUrl();

        $this->setNonce();
        $this->setState();

        $params = array(
            'response_type' => 'code',
            'redirect_uri' => env('AZURE_REDIRECT_URL'),
            'client_id' => env('AZURE_CLIENT_ID'),
            'nonce' => $this->nonce,
            'state' => $this->state,
            'scope' => 'openid email',
        );

        $url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($params, null, '&');
        session_commit();
        return $url;
    }

    public function step2($code)
    {
        $url = $this->getAccessTokenUrl();

        $params = array(
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => env('AZURE_REDIRECT_URL'),
            'client_id' => env('AZURE_CLIENT_ID'),
            'client_secret' => env('AZURE_CLIENT_SECRET'),
        );

        $token = $this->post($url, $params);
        return json_decode($token);
    }

    // Step 3: Retrieve User Data
    public function step3($token, $request)
    {
        $this->accessToken = $token->access_token;
        $this->setAccessToken($request);

        $azureUser = new AzureUser();
        $email = $azureUser->data->getMail();
        $user = User::where('email', $email)->first();

        if (empty($user->id)) {
            $hrData = RobiHRSupervisor::where('email', $email)->first();
            $name = isset($hrData->name) ? $hrData->name : strstr($email, '@', true);
            $mobile = isset($hrData->mobile) ? $hrData->mobile : 'N/A';

            $user = User::create([
                'name' => $name,
                'role_id' => Role::getId(AppConstant::ROLE_CODE_SPOC),
                'email' => $email,
                'ad_login' => true,
            ]);
            $user->markEmailAsVerified();
            event(new Registered($user));

            PartnerProfile::createInternalUserProfile($user->id, $name, $email, $mobile);
        }
        Auth::login($user);
        return redirect(Auth::user()->role->code . '/');
    }
}
