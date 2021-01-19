<?php


namespace App\Controllers;

use App\DAO\AlunoDAO;
use App\Models\AlunoModel;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class AlunoController{

    public function index(Request $request, Response $response, array $args): Response {
        $alunoDAO = new AlunoDAO();
        $data = $alunoDAO->getAll();

        $response->getBody()->write(json_encode($data) , JSON_UNESCAPED_UNICODE);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    } 

    public function show(Request $request, Response $response, array $args): Response {
        $alunoDAO = new AlunoDAO();

        $data = $alunoDAO->get($request->getAttribute('id'));

        $response->getBody()->write(json_encode($data) , JSON_UNESCAPED_UNICODE);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    
    public function create(Request $request, Response $response, array $args): Response {
        $alunoDAO = new AlunoDAO();

        $body = $request->getParsedBody(); 

        $fields = array();

        //loop para se algum campo do user for vazio atribuir null
        foreach(AlunoModel::getFields() as $field){ 
            if(!isset($body[$field]) || $body[$field] == ""){
                $fields[$field] = null;
                continue;
            }
            $fields[$field] = $body[$field];
        }
        

        $result = $alunoDAO->insert($fields); 

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
        $alunoDAO = new AlunoDAO();

        $body = $request->getParsedBody(); 

        $fields = array();
        $fields['id'] = $request->getAttribute('id');


        foreach(AlunoModel::getFields() as $field){ 
            if(!isset($body[$field]) || $body[$field] == ""){
                continue;
            }
            $fields[$field] = $body[$field];
        }

        $result = $alunoDAO->update($fields); 

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
        $alunoDAO = new AlunoDAO();

        $id = $request->getAttribute('id');

        $result = $alunoDAO->delete($id);

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