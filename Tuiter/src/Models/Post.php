<?php

namespace Tuiter\Models;

class Post {

    protected $postId;
    protected $content;
    protected $userId;
    protected $time;
    public function __construct($postId,$content,string $userId,int $time){
        $this->postId = $postId;
        $this->content = $content;
        $this->userId = $userId;
        $this->time=$time;
    }

    public function getPostId() :string{
        return $this->postId;
    }
    public function getContent() :string{
        return $this->content;
    }
    public function getUserId() :string{
        return $this->userId;
    }
    public function getTime() :int{
        return $this->time;
    }
}