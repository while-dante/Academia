<?php

namespace TestTuiter\Services;

use PHPUnit\Framework\TestCase;
use Tuiter\Services\ReshardingMongo;
use Tuiter\Services\UserService;

final class ReshardingMongoTest extends TestCase{

    private $collections = array();
    private $oldDBs = array();
    private $newDBs = array();
    private $oldUserIds = array();
    private $newUserIds = array();

    protected function setUp() :void{
        $conn = new \MongoDB\Client("mongodb://localhost");
        for($i=0;$i<10;$i++){
            $tuiterName = "DB".$i;
            $collection = $conn->$tuiterName->usuarios;
            $collection->drop();
            $this->collections[] = $collection;
        }

        $this->oldDBs = array();
        $this->newDBs = array();
        $this->oldUserIds = array();
        $this->newUserIds = array();
    }
    
    public function testClassExists(){
        $this->assertTrue(class_exists("\Tuiter\Services\ReshardingMongo"));
    }

    public function testcanReshardUsers(){
        $this->oldDBs = array_splice($this->collections,0,4);
        $this->newDBs = array_splice($this->collections,0,6);
        $ReSh = new ReshardingMongo($this->oldDBs,$this->newDBs);
        $this->assertTrue($ReSh->reshardingUsers($this->oldDBs,$this->newDBs));
    }

    public function testReshardUsersToOtherDB(){

        $this->oldDBs = array_splice($this->collections,0,4);
        $this->newDBs = array_splice($this->collections,0,6);

        $ReSh = new ReshardingMongo($this->oldDBs,$this->newDBs);

        $uService = new UserService($this->oldDBs);

        foreach($this->newDBs as $users){
            $cursor = $users->find();
            $this->assertTrue(empty($cursor->currentDocument));
        }

        for($i=0;$i<10;$i++){
            $uService->register("user".$i,"Pepe","1234");
        }

        foreach($this->oldDBs as $collection){
            $users = $collection->find();

            foreach($users as $user){
                $this->oldUserIds[] = $user["userId"];
            }
        }
        $ReSh->prepareReshardingUsers($this->oldDBs);
        $ReSh->reshardingUsers($this->oldDBs,$this->newDBs);

        foreach($this->newDBs as $collection){
            $users = $collection->find();

            foreach($users as $user){
                $this->newUserIds[] = $user["userId"];
            }
        }

        foreach($this->oldUserIds as $userId){
            $this->assertTrue(in_array($userId,$this->newUserIds));
        }
    }
}