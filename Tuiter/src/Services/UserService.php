<?php

namespace Tuiter\Services;

class UserService {

    private $collection;

    public function __construct($collection){
        $this->collection= $collection;
    }
    
    public function register(string $userId, string $name, string $password) {
        $user = $this->getUser($userId);
        if($user instanceof \Tuiter\Models\UserNull){
            $usuarios= array();
            $usuarios['userId']= $userId;
            $usuarios['name']= $name;
            $usuarios['password']=$password;
            $this->collection->insertOne($usuarios);
            return true;
        } else {
            return false;
        }
    }
    public function getUser($userId){
        $cursor= $this->collection->findOne(['userId'=> $userId]);
        if (is_null($cursor)){
            $user = new \Tuiter\Models\UserNull('','','');
            return $user;
        }
        $user = new \Tuiter\Models\User($cursor['userId'],$cursor['name'], $cursor['password']);
        return $user;
    }
}
