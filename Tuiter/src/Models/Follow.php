<?php

namespace Tuiter\Models;

class Follow {
    private $followId;
    private $followerId;
    private $followedId;

    public function __construct(String $followId,String $followerId,String $followedId){
        $this->followId=$followId;
        $this->followerId=$followerId;
        $this->followedId=$followedId;
    }
    
    public function getFollowId(): string{
        return $this->followId;
    }

    public function getFollowerId(): string{
        return $this->followerId;
    }

    public function getFollowedId(): string{
        return $this->followedId;
    }
}