<?php

namespace Tuiter\Models;

class Post {

    protected $postId;
    protected $content;
    protected $userId;

    public function __construct($postId,$content,string $userId){
        $this->postId = $postId;
        $this->content = $content;
        $this->userId = $userId;
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
}