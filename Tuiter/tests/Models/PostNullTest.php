<?php

namespace TestTuiter\Models;

use \Tuiter\Models\PostNull;

final class PostNullTest extends \PHPUnit\Framework\TestCase {

    public function testClassExists() {
        $this->assertTrue(class_exists("\Tuiter\Models\PostNull"));
    }

    public function testCanCreateObj() {
        $post = new PostNull("postId", "soyelcapo", "Juan Tuiter");

        $this->assertTrue(is_subclass_of($post,"\Tuiter\Models\Post"));
        $this->assertEquals("null", $post->getPostId());
        $this->assertEquals("null", $post->getContent());
        $this->assertEquals("null", $post->getUserId());
    }
}