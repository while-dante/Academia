<?php

namespace Tuiter\Services;

use Tuiter\Models\User;
use Tuiter\Models\Post;
use Tuiter\Models\PostNull;
use Tuiter\Services\LoginService;
use Tuiter\Services\UserService;

class PostService {

    private $collection;

    public function __construct($collection){
        $this->collection = $collection;
    }

    public function create(string $content, User $user): Post{
        $userId = $user->getUserId();
        $postId = md5(microtime());
        $time=time();
        $confirm = $this->collection->insertOne(
            array(
                "id" => $postId,
                "owner" => $userId,
                "content" => $content,
                "time"=>$time
            )
        );
        if ($confirm->getInsertedCount() != 1){
            return new PostNull($postId,$content,$userId,$time);
        }
        return new Post($postId,$content,$userId,$time);
    }

    public function getPost(string $postId): Post{
        $postFound = $this->collection->findOne(array(
            "id" => $postId
        ));

        if ($postFound == null){
            return new PostNull("null","null","null",0);
        }
        $newPost = new Post(
            $postFound["id"],
            $postFound["content"],
            $postFound["owner"],
            $postFound["time"]
        );
        return $newPost;
    }

    public function getAllPosts(User $user): array{
        $cursor = $this->collection->find(
            array(
                "owner" => $user->getUserId()
            )
        );
        $posts = array();
        foreach($cursor as $post){
            $newPost = new Post(
                $post["id"],
                $post["content"],
                $post["owner"],
                $post["time"]
            );
            $posts [] = $newPost;
        }
        return $posts;
    }
    public function deletePost(Post $post,User $user){
        if($user->getUserId() == $post->getUserId()){
            $confirm = $this->collection->deleteOne(
                array(
                    "id" => $post->getPostId(),
                )
            );
            return True;
        }
        return False;
    }

}