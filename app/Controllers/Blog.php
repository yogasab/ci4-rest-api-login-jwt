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
    helper(['form', 'array']);
    $rules = [
      'post_title' => 'required|min_length[6]',
      'post_description' => 'required',
    ];
    $imageFile = array_search('post_featured_image.name', $_FILES);
    if ($imageFile != '') {
      $rulesImage = ['post_featured_image' => 'uploaded[post_featured_image]|max_size[post_featured_image, 1024]|is_image[post_featured_image]'];
      $rules = array_merge($rulesImage, $rules);
    }

    if (!$this->validate($rules)) {
      return $this->fail($this->validator->getErrors());
    } else {
      $data = [
        'post_id' => $id,
        'post_title' => $this->request->getVar('post_title'),
        'post_description' => $this->request->getVar('post_description')
      ];
      // If the user upload a new image
      if ($imageFile != '') {
        $file = $this->request->getFile('post_featured_image');
        if (!$file->isValid()) {
          return $this->fail($file->getErrorString());
        }
        $file->move('./assets/uploads');
        // Replace the current name file image with the new name
        $data['post_featured_image'] = $file->getName();
      }
      $this->model->save($data);
      return $this->respondCreated($data, 'HEHEHEHEHEHE');
    }
    // return $this->respond($imageFile);
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
