<?php

namespace TestTuiter\Services;

use \Tuiter\Services\UserService;

final class UserServiceTest extends \PHPUnit\Framework\TestCase {
    private $collections;

    protected function setUp(): void{
        $conn = new \MongoDB\Client("mongodb://localhost");
        $this->collections = array();
        
        for($i=0;$i<5;$i++){
            $tuiterName = "tuiter".$i;
            $collection = $conn->$tuiterName->usuarios;
            $collection->drop();
            $this->collections[] = $collection;
        }
    }


    public function testExisteClase() {
        $this->assertTrue(class_exists("\Tuiter\Services\UserService"));
    }
    public function testRegisterOk(){
        $us = new UserService($this->collections);
        $user= $us->register("mati23", "1234", "matias");
        $this->assertTrue($user);

    }
    public function testRegisterUsers(){
        $us = new UserService($this->collections);
        $user= $us->register("mati23", "1234", "matias");
        $this->assertTrue($user);
        $user2= $us->register("lucho23", "1234", "luciano");
        $this->assertTrue($user2);
    }
    public function testRegisterSameUser(){
        $us = new UserService($this->collections);
        $user= $us->register("mati23", "1234", "matias");
        $this->assertTrue($user);
        $user2= $us->register("mati23", "1234", "luciano");
        $this->assertFalse($user2);
    }

    public function testGetUser(){
        $us = new UserService($this->collections);
        $us->register("mati23", "1234", "matias");
        $user=$us->getUser('mati23');
        $this->assertEquals($user->getUserId(), 'mati23');
    }

    public function testGetUserNotExist(){
        $us = new UserService($this->collections);
        $us->register("mati23", "1234", "matias");
        $user=$us->getUser('culo44');
        $this->assertEquals($user->getUserId(), 'Null');
    }

    public function testRegister1000Users(){
        $us = new UserService($this->collections);
        for ($i=0;$i<1000;$i++){
            $us->register("user".$i,"1234","name");
        }
        for ($i=0;$i<1000;$i++){
            $userFetched = $us->getUser("user".$i)->getUserId();
            $userExpected = "user".$i;
            $this->assertEquals($userExpected,$userFetched);
        }
    }
}