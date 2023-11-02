<?php

namespace App\Http\Controllers\Auth\ADLogin;

use GuzzleHttp\Exception\ClientException;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\User;
use Microsoft\Graph\Model\User as MicrosoftUser;
use Session;

class AzureUser
{
    public $data;
    protected $graph;

    public function __construct()
    {
        $this->checkAuthentication();
        $this->fetch();
    }

    protected function fetch()
    {
        $url = "/me";
        try {
            $user = $this->graph()
                ->createRequest("get", $url)
                ->setReturnType(MicrosoftUser::class)
                ->execute();
        } catch (ClientException $e) {
            throw new \Exception(
                "Cannot connect make sure you have asked User.Read permission from the authenticated user.",
                1
            );
        }
        $this->data = $user;
        return $this->data;
    }

    public function graph()
    {
        $this->graph = new Graph();
        $this->graph->setAccessToken(Session::get("accessToken"));
        return $this->graph;
    }
    public function checkAuthentication(): bool
    {
        $url = "/me";
        try {
            $user = $this->graph()
                ->createRequest("get", $url)
                ->setReturnType(User::class)
                ->execute();
        } catch (ClientException $e) {
            return false;
        }
        return is_null($user->getGivenName()) ? false : true;
    }
}
