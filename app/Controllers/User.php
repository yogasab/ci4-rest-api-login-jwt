<?php

namespace App\Controllers;

use \App\Libraries\OAuth2;
use \OAuth2\Request;
use CodeIgniter\API\ResponseTrait;

class User extends BaseController
{
  use ResponseTrait;
  public function index()
  {
    $OAuth = new OAuth2();
    $request = new Request();
    $respond = $OAuth->server->handleTokenRequest($request->createFromGlobals());
    $codeStatus = $respond->getStatusCode();
    $responseBody = $respond->getResponseBody();
    return $this->respond($responseBody, $codeStatus);
  }
}
