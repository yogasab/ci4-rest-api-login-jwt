<?php

namespace App\Controllers;

use \App\Libraries\OAuth;
use \OAuth2\Request;
use \CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class User extends BaseController
{
  use ResponseTrait;

  public function __construct()
  {
    $this->validation = \Config\Services::validation();
  }

  public function login()
  {
    $oauth = new OAuth();
    $request = new Request();
    $respond = $oauth->server->handleTokenRequest($request->createFromGlobals());
    $code = $respond->getStatusCode();
    $body = $respond->getResponseBody();
    return $this->respond(json_decode($body), $code);
  }

  public function register()
  {
    helper(['form']);
    if ($this->request->getMethod() != 'post') {
      return $this->fail('Please use a POST method');
    }
    $data = $this->request->getPost();
    if (!$this->validation->run($data, 'userRules')) {
      $errors = $this->validation->getErrors();
      return $this->fail($errors);
    }
    $model = new UserModel();
    $post = $model->insert($data);
    $data['id'] = $post;
    return $this->respondCreated($data);
  }
}
