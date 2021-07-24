<?php

namespace App\Controllers;

use \App\Libraries\OAuth;
use \OAuth2\Request;
use \CodeIgniter\API\ResponseTrait;

class User extends BaseController
{
  use ResponseTrait;
  public function login()
  {
    // $OAuth = new OAuth();
    // $request = new Request();
    // $respond = $OAuth->server->handleTokenRequest($request->createFromGlobals());
    // $code = $respond->getStatusCode();
    // $body = $respond->getResponseBody();
    // return $this->respond(json_decode($body), $code);
    $oauth = new OAuth();
    $request = new Request();
    $respond = $oauth->server->handleTokenRequest($request->createFromGlobals());
    $code = $respond->getStatusCode();
    $body = $respond->getResponseBody();
    return $this->respond(json_decode($body), $code);
  }
}
