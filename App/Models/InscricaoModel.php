<?php

namespace App\Models;

final class InscricaoModel {


    public static function getFields(): array{
        return [
            'aluno_id',
            'nota'
        ];
    }


}