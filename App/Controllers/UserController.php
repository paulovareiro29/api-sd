<?php


namespace App\Controllers;

use App\DAO\UserDAO;
use App\Models\UserModel;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class UserController{

    public function login(Request $request, Response $response, array $args): Response {
        $userDAO = new UserDAO();

        $body = $request->getParsedBody(); 
        $result = $userDAO->login($body);

        if(!$result){
            $response->getBody()->write(json_encode("Unauthorized") , JSON_UNESCAPED_UNICODE);

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
        }

        $response->getBody()->write(json_encode($result) , JSON_UNESCAPED_UNICODE);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    } 

    //CRUD

    public function index(Request $request, Response $response, array $args): Response {
        $userDAO = new UserDAO();
        $users = $userDAO->getAll();

        $response->getBody()->write(json_encode($users) , JSON_UNESCAPED_UNICODE);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    } 

    public function show(Request $request, Response $response, array $args): Response {
        $userDAO = new UserDAO();

        $user = $userDAO->get($request->getAttribute('id'));

        $response->getBody()->write(json_encode($user) , JSON_UNESCAPED_UNICODE);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    
    public function create(Request $request, Response $response, array $args): Response {
        $userDAO = new UserDAO();

        $body = $request->getParsedBody(); 

        $fields = array();

        //loop para se algum campo do user for vazio atribuir null
        foreach(UserModel::getFields() as $field){ 
            if(!isset($body[$field]) || $body[$field] == ""){
                $fields[$field] = null;
                continue;
            }
            $fields[$field] = $body[$field];
        }
        

        $result = $userDAO->insert($fields); 

        if($result){
            $response->getBody()->write(json_encode($result) , JSON_UNESCAPED_UNICODE);
            return $response 
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
        }
            
        
        $response->getBody()->write(json_encode("Erro ao inserir registo") , JSON_UNESCAPED_UNICODE);
        return $response 
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
          
    }
    
    public function update(Request $request, Response $response, array $args): Response {
        $userDAO = new UserDAO();

        $body = $request->getParsedBody(); 

        $fields = array();
        $fields['id'] = $request->getAttribute('id');


        foreach(UserModel::getFields() as $field){ 
            if(!isset($body[$field]) || $body[$field] == ""){
                continue;
            }
            $fields[$field] = $body[$field];
        }

        $result = $userDAO->update($fields); 

        if($result){
            $response->getBody()->write(json_encode("Registo atualizado com sucesso") , JSON_UNESCAPED_UNICODE);
            return $response 
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
        }
            
        
        $response->getBody()->write(json_encode("Erro ao atualizado registo") , JSON_UNESCAPED_UNICODE);
        return $response 
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
          
    }

    public function delete(Request $request, Response $response, array $args): Response {
        $userDAO = new UserDAO();

        $id = $request->getAttribute('id');

        $result = $userDAO->delete($id);

        if($result){
            $response->getBody()->write(json_encode("Registo eliminado com sucesso") , JSON_UNESCAPED_UNICODE);
            return $response 
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }
            
        
        $response->getBody()->write(json_encode("Erro ao eliminar registo") , JSON_UNESCAPED_UNICODE);
        return $response 
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
    }
}