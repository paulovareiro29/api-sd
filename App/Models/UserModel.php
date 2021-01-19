<?php

namespace App\Models;

final class UserModel {


    public static function getFields(): array{
        return [
            'username',
            'password'
        ];
    }


}