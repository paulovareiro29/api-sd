<?php

namespace App\DAO;

class InscricaoDAO extends Connection {

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll($curso_id){

        $data = array();

        foreach($this->db->alunocurso()->where('curso_id',$curso_id) as $inscricao){
            array_push($data,$inscricao);
        }
        
        return $data;
    }

    public function get($id){
        $data = $this->db->alunocurso()->where('curso_id', $id['curso_id'])->where('aluno_id',$id['aluno_id'])->fetch();
        return $data;
    }

    public function insert($inscricao){
        $id = $this->db->alunocurso()->insert($inscricao);

        return $id;
    }

    public function update($inscricao){

        $sucess = $this->db->alunocurso()
            ->where('curso_id',$inscricao['curso_id'])
            ->where('aluno_id',$inscricao['aluno_id'])
            ->update($inscricao);
        
        return $sucess;
    }
    
    public function delete($id){
        $sucess = $this->db->alunocurso()
            ->where('curso_id',$id['curso_id'])
            ->where('aluno_id',$id['aluno_id'])
            ->delete();
        
        return $sucess;
    }
}