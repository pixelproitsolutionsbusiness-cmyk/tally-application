<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserTokenModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class AuthController extends ResourceController
{
    protected $format = 'json';

    public function register()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $userModel = new UserModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
        ];

        try {
            $userModel->save($data);
            return $this->respondCreated(['message' => 'User registered successfully.']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function login()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $this->request->getVar('email'))->first();

        if (!$user || !password_verify($this->request->getVar('password'), $user['password'])) {
            return $this->failUnauthorized('Invalid email or password.');
        }

        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $userTokenModel = new UserTokenModel();
        $userTokenModel->save([
            'user_id' => $user['id'],
            'token' => $token,
            'expires_at' => $expiry,
        ]);

        return $this->respond(['token' => $token, 'expires_at' => $expiry]);
    }

    public function logout()
    {
        $token = $this->request->getHeaderLine('Authorization');
        if (!$token) {
            return $this->failUnauthorized('Token is required.');
        }

        $userTokenModel = new UserTokenModel();
        $userTokenModel->where('token', $token)->delete();

        return $this->respond(['message' => 'Logged out successfully.']);
    }
}
