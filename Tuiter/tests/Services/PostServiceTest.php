<?php

namespace TestTuiter\Services;

use Tuiter\Services\PostService;
use Tuiter\Models\User;
use Tuiter\Models\Post;

final class TestPostService extends \PHPUnit\Framework\TestCase {

    protected function setUp() :void{
        $conn = new \MongoDB\Client("mongodb://localhost");
        $postsCollection = $conn->testPostService->posts;
        $postsCollection->drop();
        $this->pService = new PostService($postsCollection);
    }

    public function testClassExists(){
        $this->assertTrue(class_exists("\Tuiter\Services\PostService"));
    }

    public function testReturnCreatePost(){
        $content = "Esto es un tuit";
        $user = new User("userId","Juan Perez","pass");
        $postReturned = $this->pService->create($content,$user);
        $this->assertTrue($postReturned instanceof Post);
    }

    public function testGetPostNull(){
        $content = "Esto es un tuit";
        $user = new User("userId","Juan Perez","pass");
        $postReturned = $this->pService->getPost("notSavedId");
        $this->assertTrue(is_subclass_of($postReturned,"\Tuiter\Models\Post"));
    }

    public function testReturnCreateTwoPosts(){
        $content1 = "Esto es un tuit";
        $content2 = "Esto otro tuit";
        $user = new User("userId","Juan Perez","pass");
        $postReturned1 = $this->pService->create($content1,$user);
        $postReturned2 = $this->pService->create($content2,$user);
        $this->assertTrue($postReturned1 instanceof Post);
        $this->assertTrue($postReturned2 instanceof Post);
    }

    public function testGetAllPost(){
        $content1 = "Esto es un tuit";
        $content2 = "Esto otro tuit";
        $user = new User("userId","Juan Perez","pass");
        $postReturned1 = $this->pService->create($content1,$user);
        $postReturned2 = $this->pService->create($content2,$user);
        $resultArray = array($postReturned1,$postReturned2);
        $this->assertEquals($resultArray,$this->pService->getAllPosts($user));
    }

    public function testGetPost(){
        $content = "Esto es un tuit";
        $user = new User("userId","Juan Perez","pass");
        $content1 = "Esto es un tuit";
        $content2 = "Esto otro tuit";
        $postReturned1 = $this->pService->create($content1,$user);
        $postReturned2 = $this->pService->create($content2,$user);
        
        $postReturned11 = $this->pService->getPost($postReturned1->getPostId());
        $postReturned22 = $this->pService->getPost($postReturned2->getPostId());
        $this->assertEquals($postReturned1,$postReturned11);
        $this->assertEquals($postReturned2,$postReturned22);
    }
    public function testTwoUsersPosts(){

        $content = "Esto es un tuit";
        $user1 = new User("user1","Juan Perez","pass");
        $user2 = new User("user2","Juan Perez","pass");
        $content1 = "Esto es un tuit";
        $content2 = "Esto otro tuit";
        $postReturned1 = $this->pService->create($content1,$user1);
        $postReturned2 = $this->pService->create($content2,$user2);
        
        $postReturned11 = $this->pService->getPost($postReturned1->getPostId());
        $postReturned22 = $this->pService->getPost($postReturned2->getPostId());
        $this->assertEquals($postReturned1,$postReturned11);
        $this->assertEquals($postReturned2,$postReturned22);
    }
}
