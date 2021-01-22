<?php

namespace App\Middlewares;

use App\DAO\UserDAO;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class AuthMiddleware {

    public function hasToken(Request $request, Response $response, $next){
        $userDAO = new UserDAO();

        $token = $request->getHeader('TOKEN');
        if($userDAO->validateToken($token)){
            $response = $next($request,$response);
            return $response;
        }

        $response->getBody()->write(json_encode("Unauthorized"), JSON_UNESCAPED_UNICODE);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(401);
    }

    public function addHeaders(Request $request, Response $response, $next){
        $response = $next($request, $response);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Token, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    }

}