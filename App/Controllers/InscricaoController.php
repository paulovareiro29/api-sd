<?php


namespace App\Controllers;

use App\DAO\InscricaoDAO;
use App\Models\InscricaoModel;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class InscricaoController{

    public function index(Request $request, Response $response, array $args): Response {
        $inscricaoDAO= new InscricaoDAO();

        $data = $inscricaoDAO->getAll($request->getAttribute('curso_id'));

        $response->getBody()->write(json_encode($data) , JSON_UNESCAPED_UNICODE);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    } 

    public function show(Request $request, Response $response, array $args): Response {
        $inscricaoDAO= new InscricaoDAO();

        $id = [
            'curso_id' => $request->getAttribute('curso_id'),
            'aluno_id' => $request->getAttribute('aluno_id')
        ];

        $data = $inscricaoDAO->get($id);

        $response->getBody()->write(json_encode($data) , JSON_UNESCAPED_UNICODE);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
    
    public function create(Request $request, Response $response, array $args): Response {
        $inscricaoDAO= new InscricaoDAO();

        $body = $request->getParsedBody(); 

        $fields = array();
        $fields['curso_id'] = $request->getAttribute('curso_id');

        //loop para se algum campo do user for vazio atribuir null
        foreach(InscricaoModel::getFields() as $field){ 
            if(!isset($body[$field]) || $body[$field] == ""){
                $fields[$field] = null;
                continue;
            }
            $fields[$field] = $body[$field];
        }
        

        $result = $inscricaoDAO->insert($fields); 

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
        $inscricaoDAO= new InscricaoDAO();

        $body = $request->getParsedBody(); 

        $fields = array();
        $fields['curso_id'] = $request->getAttribute('curso_id');
        $fields['aluno_id'] = $request->getAttribute('aluno_id');


        foreach(InscricaoModel::getFields() as $field){ 
            if(!isset($body[$field]) || $body[$field] == ""){
                continue;
            }
            $fields[$field] = $body[$field];
        }

        $result = $inscricaoDAO->update($fields); 

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
        $inscricaoDAO= new InscricaoDAO();

        $id = [
            'curso_id' => $request->getAttribute('curso_id'),
            'aluno_id' => $request->getAttribute('aluno_id')
        ];
        
        $result = $inscricaoDAO->delete($id);

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