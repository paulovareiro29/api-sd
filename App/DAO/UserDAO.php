<?php

namespace App\DAO;

class UserDAO extends Connection {

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(){

        $data = array();

        foreach($this->db->user() as $user){
            array_push($data,$user);
        }
        
        return $data;
    }

    public function get($id){
        $data = $this->db->user($id)->where('id', $id)->fetch();
        return $data;
    }

    public function insert($user){
        $id = $this->db->user()->insert($user);

        if($id) return $this->db->user[$id];
        return false;
    }

    public function update($user){
        $id = $user['id'];

        $sucess = $this->db->user()->where('id',$id)->update($user);
        
        return $sucess;
    }
    
    public function delete($id){
        $sucess = $this->db->user()->where('id',$id)->delete();
        
        return $sucess;
    }
}