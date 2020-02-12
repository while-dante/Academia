<?php
namespace TestTuiter\Services;

use \Tuiter\Services\LikeService;

final class LikeServiceTest extends \PHPUnit\Framework\TestCase {
    private $collection;
    protected function setUp(): void
    {
        $conn= new \MongoDB\Client("mongodb://localhost:27017");
        $this->collection=$conn->leandro->likes;
        $this->collection->drop();
        $this->ls= new \Tuiter\Services\LikeService($this->collection);

    }
    public function testExisteLikeService(){
        $this->assertTrue(class_exists("\Tuiter\Services\LikeService"));
    }
    public function testCrearLikeService(){
        $this->assertTrue(is_a(new \Tuiter\Services\LikeService($this->collection), "\Tuiter\Services\LikeService"));
    }
    public function testCollectionExist(){
        $this->assertTrue(is_a($this->collection,"\MongoDB\Collection"));
    }
    public function testLike(){
        $test= $this->ls->like(
            new \Tuiter\Models\User("diegote","tom","lean"),
            new \Tuiter\Models\Post("aoeu", "","tom",time())
        );
        $this->assertIsBool($test);
        $this->assertTrue($test);
    }
    public function testCount(){
        $post=new \Tuiter\Models\Post("oaeu", "","tom",time());
        $this->assertIsInt($this->ls->count($post));
    }
    public function testDarLikeYContar(){
        $post=new \Tuiter\Models\Post("", "","tom",time());
        $likesAntes=$this->ls->count($post); 
        $this->assertTrue($this->ls->like(
            new \Tuiter\Models\User("diegote","tom","lean"),
            $post
        ));
        $this->assertEquals($likesAntes+1,$this->ls->count($post));
    }
    public function testDosLikesIguales(){
        $post=new \Tuiter\Models\Post("", "","tom",time());
        $this->assertTrue($this->ls->like(
            new \Tuiter\Models\User("diegote","tom","lean"),
            $post
        ));
        $this->assertFalse($this->ls->like(
            new \Tuiter\Models\User("diegote","tom","lean"),
            $post
        ));
    }


    public function testMuchosLikes() {
        $post=new \Tuiter\Models\Post("", "","tom",time());
        $this->assertTrue($this->ls->like(
            new \Tuiter\Models\User("diegote","tom","lean"),
            $post
        ));
        $this->assertEquals(1, $this->ls->count($post));

        for($n=0; $n < 50; $n++) {
            $this->assertTrue($this->ls->like(
                new \Tuiter\Models\User("diegote $n","tom $n","lean $n"),
                $post
            ));
        }
        $this->assertEquals(50+1, $this->ls->count($post));
    }
    public function testUnlike(){
        $user=new \Tuiter\Models\User("diegote","tom","lean");
        $post=new \Tuiter\Models\Post("aoeu", "","tom",time());
        $test= $this->ls->like($user,$post);
        $this->assertTrue($test);
        $this->assertTrue($this->ls->unlike($user,$post));
    }
    public function testUnlikeDeUnPostSinLikear(){
        $this->assertFalse($this->ls->unlike(
            new \Tuiter\Models\User("diegote","tom","lean"),
            new \Tuiter\Models\Post("aoeu", "","tom",time())
        ));
    }



}
    
