<?php

namespace App\DAO;

class UserDAO extends Connection {

    public function __construct()
    {
        parent::__construct();
    }

    public function validateToken($token){
        $user = $this->db->user()->where('access_token', $token)->fetch();

        if(!$user) return false;
        return true;
    }

    public function login($data) {
        if(!isset($data['password']) || !isset($data['username']))
            return false;

        $user = $this->db->user()->where('username', $data['username'])->fetch();

        if(password_verify($data['password'], $user['password'])){
            $token = bin2hex(openssl_random_pseudo_bytes(16));

            $user->update(["access_token" => $token]);

            return ["token" => $token];
        }
        
        return false;
    }


    //CRUD

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
        if(!isset($user['username']) || !isset($user['password'])) return false;
        if($this->db->user()->where('username',$user['username'])->fetch()) return "Username já existe";


        $user['password'] = password_hash($user['password'],PASSWORD_BCRYPT);
        

        //encriptar password
        $id = $this->db->user()->insert($user);

        if($id) return $this->db->user[$id];
        return false;
    }

    public function update($user){
        $id = $user['id'];
//encriptar password

        if(isset($user['password'])){
            $user['password'] = password_hash($user['password'], PASSWORD_BCRYPT);
        }

        $sucess = $this->db->user()->where('id',$id)->update($user);
        
        return $sucess;
    }
    
    public function delete($id){
        $sucess = $this->db->user()->where('id',$id)->delete();
        
        return $sucess;
    }
}