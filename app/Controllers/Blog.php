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

  public function show($id = null)
  {
    $userID = $this->model->find($id);
    return $this->respond($userID);
  }

  public function update($id = null)
  {
    $data = $this->request->getRawInput();
    if (!$this->validation->run($data, 'blogRules')) {
      $errors = $this->validation->getErrors();
      return $this->fail($errors);
    } else {
      $data['post_id'] = $id;
      $this->model->save($data);
      return $this->respondUpdated($data);
    }
  }

  public function delete($id = null)
  {
    $postId = $this->model->find($id);
    if ($postId) {
      $this->model->delete($postId);
      return $this->respondDeleted(json_encode('Post deleted successfully'));
    } else {
      return $this->failNotFound('ID is not found');
    }
  }
}
