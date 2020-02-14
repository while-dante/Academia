<?php

namespace Tuiter\Services;

class UserService {

    private $collections;

    public function __construct(array $collections){
        $this->collections = $collections;
    }
    
    public function register(string $userId, string $name, string $password) {
        $user = $this->getUser($userId);
        if($user instanceof \Tuiter\Models\UserNull){
            $usuarios= array();
            $usuarios['userId']= $userId;
            $usuarios['name']= $name;
            $usuarios['password']=$password;
            $this->collections[0]->insertOne($usuarios);
            return true;
        } else {
            return false;
        }
    }
    public function getUser($userId){
        $cursor= $this->collections[0]->findOne(['userId'=> $userId]);
        if (is_null($cursor)){
            $user = new \Tuiter\Models\UserNull('','','');
            return $user;
        }
        $user = new \Tuiter\Models\User($cursor['userId'],$cursor['name'], $cursor['password']);
        return $user;
    }
}
