<?php

namespace App\DAO;

class AlunoDAO extends Connection {

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(){

        $data = array();

        foreach($this->db->aluno() as $aluno){

            $inscricoes = array();
            foreach($this->db->alunocurso()->where('aluno_id', $aluno['id']) as $inscricao){
                array_push($inscricoes, [
                    'id' => $inscricao['curso_id'],
                    'nome' => $this->db->curso[$inscricao['curso_id']]['nome'],
                    'nota' => $inscricao['nota']
                ]);
            }

            array_push($data,[
                "id"=> $aluno['id'],
                "nome"=> $aluno['nome'],
                "email"=> $aluno['email'],
                "morada"=> $aluno['morada'],
                "inscricoes" => $inscricoes
            ]);
        }
        
        return $data;
    }

    public function get($id){
        $aluno = $this->db->aluno($id)->where('id', $id)->fetch();


        $inscricoes = array();
        foreach($this->db->alunocurso()->where('aluno_id', $aluno['id']) as $inscricao){
            array_push($inscricoes, [
                'id' => $inscricao['curso_id'],
                'nome' => $this->db->curso[$inscricao['curso_id']]['nome'],
                'nota' => $inscricao['nota']
            ]);
        }

        return [
            "id"=> $aluno['id'],
            "nome"=> $aluno['nome'],
            "email"=> $aluno['email'],
            "morada"=> $aluno['morada'],
            "inscricoes" => $inscricoes
        ];
    }

    public function insert($aluno){
        $id = $this->db->aluno()->insert($aluno);

        if($id) return $this->db->aluno[$id];
        return false;
    }

    public function update($aluno){
        $id = $aluno['id'];

        $sucess = $this->db->aluno()->where('id',$id)->update($aluno);
        
        return $sucess;
    }
    
    public function delete($id){
        $sucess = $this->db->aluno()->where('id',$id)->delete();
        
        return $sucess;
    }
}