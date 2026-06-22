<?php

namespace App\Validation;

class PasswordRules
{
    public function strong_password(?string $password, ?string $fields = null, array $data = [], ?string &$error = null): bool
    {
        $password = (string) $password;
        $error = 'Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan karakter simbol.';

        if (strlen($password) < 8) {
            return false;
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }

        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }

        if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?`~]/', $password)) {
            return false;
        }

        return true;
    }
}
