<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\UserTokenModel;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $token = $request->getHeaderLine('Authorization');

        if (!$token) {
            return service('response')->setJSON(['error' => 'Unauthorized'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        $userTokenModel = new UserTokenModel();
        $tokenData = $userTokenModel->where('token', $token)->first();

        if (!$tokenData || strtotime($tokenData['expires_at']) < time()) {
            return service('response')->setJSON(['error' => 'Token is invalid or expired'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Optionally, set user data in the request for further use
        $request->user = $tokenData['user_id'];
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
