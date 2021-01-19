<?php

namespace App\Models;

final class CursoModel {


    public static function getFields(): array{
        return [
            'nome',
            'descricao'
        ];
    }


}