<?php

namespace TestTuiter\Models;

use \Tuiter\Models\Post;

final class PostTest extends \PHPUnit\Framework\TestCase {

    public function testClassExists() {
        $this->assertTrue(class_exists("\Tuiter\Models\Post"));
    }

    public function testCanCreateObj() {
        $post = new Post("postId", "soyelcapo", "Juan Tuiter");

        $this->assertTrue($post instanceof Post);
        $this->assertEquals("postId", $post->getPostId());
        $this->assertEquals("soyelcapo", $post->getContent());
        $this->assertEquals("Juan Tuiter", $post->getUserId());
    }
    
    public function testCanCreateAnotherObj() {
        $post = new Post("postId2", "soyelcapo2", "Juan Tuiter2");

        $this->assertTrue($post instanceof Post);
        $this->assertEquals("postId2", $post->getPostId());
        $this->assertEquals("soyelcapo2", $post->getContent());
        $this->assertEquals("Juan Tuiter2", $post->getUserId());
    }
}