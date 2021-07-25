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
    $fileImage = $this->request->getFile('post_featured_image');
    if (!$this->validation->run($data, 'blogRules')) {
      return $this->fail($this->validation->getErrors());
    } else {
      if (!$fileImage->isValid()) {
        return $this->fail($fileImage->getErrorString());
      }
      $fileImage->move('./assets/uploads');
      $fileImageName = $fileImage->getName();
      $dataBlog = [
        'post_title' => $this->request->getVar('post_title'),
        'post_description' => $this->request->getVar('post_description'),
        'post_featured_image' => $fileImageName
      ];
      $save = $this->model->insert($dataBlog);
      $dataBlog['post_id'] = $save;
      return $this->respondCreated($dataBlog);
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
