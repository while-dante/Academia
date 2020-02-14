<?php

namespace Tuiter\Services;

class UserService {

    private $collections;
    private $nCollections;

    public function __construct(array $collections){
        $this->collections = $collections;
        $this->nCollections = count($collections);
    }
    
    public function register(string $userId, string $name, string $password) {
        $user = $this->getUser($userId);
        if($user instanceof \Tuiter\Models\UserNull){
            $usuarios= array();
            $usuarios['userId']= $userId;
            $usuarios['name']= $name;
            $usuarios['password']=$password;

            $encripted = md5($userId);
            $number = 0;
            for ($i=0;$i<strlen($encripted);$i++){
                $number += ord($encripted[$i]);
            }
            $db = $number%$this->nCollections;
            $this->collections[$db]->insertOne($usuarios);
            return true;
        } else {
            return false;
        }
    }
    public function getUser($userId){
        $encripted = md5($userId);
        $number = 0;
        for ($i=0;$i<strlen($encripted);$i++){
            $number += ord($encripted[$i]);
        }
        $db = $number%$this->nCollections;
        $cursor= $this->collections[$db]->findOne(['userId'=> $userId]);
        if (is_null($cursor)){
            $user = new \Tuiter\Models\UserNull('','','');
            return $user;
        }
        $user = new \Tuiter\Models\User($cursor['userId'],$cursor['name'], $cursor['password']);
        return $user;
    }
}
