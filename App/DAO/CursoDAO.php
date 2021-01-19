<?php

namespace App\DAO;

class CursoDAO extends Connection {

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(){

        $data = array();

        foreach($this->db->curso() as $curso){
            $inscricoes = array();
            foreach($this->db->alunocurso()->where('curso_id', $curso['id']) as $inscricao){
                array_push($inscricoes, [
                    'id' => $inscricao['aluno_id'],
                    'nome' => $this->db->aluno[$inscricao['aluno_id']]['nome'],
                    'nota' => $inscricao['nota']
                ]);
            }

            array_push($data,[
                'id' => $curso['id'],
                'nome' => $curso['nome'],
                'descricao' => $curso['descricao'],
                'inscricoes' => $inscricoes
            ]);
        }
        
        return $data;
    }

    public function get($id){
        $curso = $this->db->curso()->where('id', $id)->fetch();
        if(!$curso){
            return null;
        } 
        $inscricoes = array();
        foreach($this->db->alunocurso()->where('curso_id', $curso['id']) as $inscricao){
            array_push($inscricoes, [
                'id' => $inscricao['aluno_id'],
                'nome' => $this->db->aluno[$inscricao['aluno_id']]['nome'],
                'nota' => $inscricao['nota']
            ]);
        }

        return [
            'id' => $curso['id'],
            'nome' => $curso['nome'],
            'descricao' => $curso['descricao'],
            'inscricoes' => $inscricoes
        ];
    }

    public function insert($curso){
        $id = $this->db->curso()->insert($curso);

        if($id) return $this->db->curso[$id];
        return false;
    }

    public function update($curso){
        $id = $curso['id'];

        $sucess = $this->db->curso()->where('id',$id)->update($curso);
        
        return $sucess;
    }
    
    public function delete($id){
        $sucess = $this->db->curso()->where('id',$id)->delete();
        
        return $sucess;
    }
}