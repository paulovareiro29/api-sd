<?php

namespace App\Models;

final class AlunoModel {


    public static function getFields(): array{
        return [
            'nome',
            'email',
            'morada'
        ];
    }


}