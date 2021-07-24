<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Blog extends ResourceController
{
  protected $modelName = '\App\Models\BlogModel';
  protected $format = 'json';

  public function __construct()
  {
    $this->validation = \Config\Services::validation();
  }

  public function index()
  {
    $posts = $this->model->findAll();
    return $this->respond($posts);
  }

  public function create()
  {
    $data = $this->request->getPost();
    if (!$this->validation->run($data, 'blogRules')) {
      $errors = $this->validation->getErrors();
      return $this->fail($errors);
    } else {
      $post = $this->model->insert($data);
      $data['post_id'] = $post;
      return $this->respondCreated($data);
    }
  }
}
