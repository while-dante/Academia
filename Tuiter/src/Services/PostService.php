<?php

namespace Tuiter\Services;

use Tuiter\Models\User;
use Tuiter\Models\Post;
use Tuiter\Models\PostNull;


class PostService {

    private $collection;

    public function __construct($collection){
        $this->collection = $collection;
    }

    public function create(string $content, User $user): Post{
        $userId = $user->getUserId();
        $postId = md5(microtime());
        $confirm = $this->collection->insertOne(
            array(
                "id" => $postId,
                "owner" => $userId,
                "content" => $content
            )
        );
        if ($confirm->getInsertedCount() != 1){
            return new PostNull($postId,$content,$userId);
        }
        return new Post($postId,$content,$userId);
    }

    public function getPost(string $postId): Post{
        $postFound = $this->collection->findOne(array(
            "id" => $postId
        ));

        if ($postFound == null){
            return new PostNull("null","null","null");
        }
        $newPost = new Post(
            $postFound["id"],
            $postFound["content"],
            $postFound["owner"]
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
                $post["owner"]
            );
            $posts [] = $newPost;
        }
        return $posts;
    }

}