<?php

namespace App\Config\Me;

use App\Models\UserModel;

class CustomRules
{
    public function password_check(string $str): bool
    {
        $model = new UserModel;
        $user = $model->find(user()->id);

        if (!password_verify($str, $user->password)) {
            return false;
        }

        return true;
    }
}
