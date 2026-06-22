<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class GuestFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('isLoggedIn')) {
            $role = (int) session()->get('id_role');

            return match ($role) {
                1, 2 => redirect()->to('/dashboard'),
                3 => redirect()->to('/dashboard'),
                4, 5    => redirect()->to('/'),
                default => redirect()->to('/'),
            };
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
