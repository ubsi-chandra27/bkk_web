<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        if ($arguments) {
            $userRole = (int) session()->get('id_role');
            $allowed  = array_map('intval', $arguments);

            if (!in_array($userRole, $allowed)) {
                // Redirect ke halaman sesuai role masing-masing
                return match ($userRole) {
                    1, 2 => redirect()->to('/dashboard'),
                    3 => redirect()->to('/dashboard'),
                    4, 5    => redirect()->to('/'),
                    default => redirect()->to('/'),
                };
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
