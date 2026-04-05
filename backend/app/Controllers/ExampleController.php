<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ExampleController extends ResourceController
{
    protected $format = 'json';

    public function protectedEndpoint()
    {
        return $this->respond(['message' => 'You have accessed a protected endpoint.']);
    }
}
