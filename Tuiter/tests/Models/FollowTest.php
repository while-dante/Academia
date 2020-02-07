<?php

namespace TestTuiter\Models;

use \Tuiter\Models\Follow;

final class FollowTest extends \PHPUnit\Framework\TestCase {
    public function testClassExists(){
        $this->assertTrue(class_exists("Tuiter\Models\Follow"));
    }

    public function testGetFollowId(){
        $follow = new \Tuiter\Models\Follow("eliel","diego","edu");
        $this->assertEquals("eliel", $follow->getFollowId());
    }

    public function testGetFollowerId(){
        $follow = new \Tuiter\Models\Follow("eliel","diego","edu");
        $this->assertEquals("diego", $follow->getFollowerId());
    }
    public function testGetFollowedId(){
        $follow = new \Tuiter\Models\Follow("eliel","diego","edu");
        $this->assertEquals("edu", $follow->getFollowedId());
    }
}