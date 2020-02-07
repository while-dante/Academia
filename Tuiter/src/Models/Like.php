<?php

namespace Tuiter\Models;

class Like
{
    private $likeId;
    private $postId;
    private $userId;

    public function __construct($postId, $userId)
    {
        $this->userId = $userId;
        $this->postId = $postId;
        $this->likeId = md5(microtime());
    }
    public function getLikeId()
    {
        return $this->likeId;
    }
    public function getPostId()
    {
        return $this->postId;
    }
    public function getUserId()
    {
        return $this->userId;
    }
}
