<?php

namespace TestTuiter\Services;

use \Tuiter\Services\FollowService;

final class FollowServiceTest extends \PHPUnit\Framework\TestCase {
    
    protected function setUp(): void{
        $connection = new \MongoDB\Client("mongodb://localhost");
        $collection = $connection->FollowServiceTest->FollowTest;
        $collection->drop();
        $this->fs= new \Tuiter\Services\FollowService($collection);
    }

    public function testClassExists(){
        $this->assertTrue(class_exists("\Tuiter\Services\FollowService"));
    }
    
    public function testFollow(){
        $this->assertTrue($this->fs->follow("eliel","edu"));
        $this->assertFalse($this->fs->follow("eliel","edu"));
    }

    public function testGetFollowers(){
        $this->assertTrue($this->fs->follow("eliel","edu"));
        $this->assertCount(1,$this->fs->getFollowers("edu"));
    }

    public function testGetMasFollowers(){
        $this->assertTrue($this->fs->follow("eliel","edu"));
        $this->assertTrue($this->fs->follow("diego","edu"));
        $this->assertTrue($this->fs->follow("nico","edu"));
        $this->assertCount(3,$this->fs->getFollowers("edu"));
    }

    public function testGetFollowed(){
        $this->assertTrue($this->fs->follow("eliel","edu"));
        $this->assertCount(1,$this->fs->getFollowed("eliel"));
    }

    public function testGetMasFollowed(){
        $this->assertTrue($this->fs->follow("eliel","fran"));
        $this->assertTrue($this->fs->follow("eliel","nico"));
        $this->assertTrue($this->fs->follow("eliel","rober"));
        $this->assertCount(3,$this->fs->getFollowed("eliel"));
    }
}