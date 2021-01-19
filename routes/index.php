<?php

use App\Controllers\UserController;
use App\Controllers\AlunoController;
use App\Controllers\CursoController;
use App\Controllers\InscricaoController;

use function src\slimConfiguration;

$app = new \Slim\App(slimConfiguration());


$app->group('/user', function () use ($app){
    $app->get ('/', UserController::class . ':index');
    $app->get ('/{id}', UserController::class . ':show');
    $app->post('/', UserController::class . ':create');
    $app->put ('/{id}', UserController::class . ':update');
    $app->delete('/{id}', UserController::class . ':delete');
});

$app->group('/aluno', function () use ($app){
    $app->get ('/', AlunoController::class . ':index');
    $app->get ('/{id}', AlunoController::class . ':show');
    $app->post('/', AlunoController::class . ':create');
    $app->put ('/{id}', AlunoController::class . ':update');
    $app->delete('/{id}', AlunoController::class . ':delete');
});

$app->group('/curso', function () use ($app){
    $app->get   ('/', CursoController::class . ':index');
    $app->get   ('/{id}', CursoController::class . ':show');
    $app->post  ('/', CursoController::class . ':create');
    $app->put   ('/{id}', CursoController::class . ':update');
    $app->delete('/{id}', CursoController::class . ':delete');

    $app->get   ('/{curso_id}/inscricao/', InscricaoController::class . ':index');
    $app->get   ('/{curso_id}/inscricao/{aluno_id}', InscricaoController::class . ':show');
    $app->post  ('/{curso_id}/inscricao/', InscricaoController::class . ':create');
    $app->put   ('/{curso_id}/inscricao/{aluno_id}', InscricaoController::class . ':update');
    $app->delete('/{curso_id}/inscricao/{aluno_id}', InscricaoController::class . ':delete');
    
});

$app->run();