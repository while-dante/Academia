<?php

namespace TestTuiter\Models;

use \Tuiter\Models\User;

final class UserTest extends \PHPUnit\Framework\TestCase {

    public function testExisteClase() {
        $this->assertTrue(class_exists("\Tuiter\Models\User"));
    }

    public function testPodesCrearObj() {
        $user = new User("ventilete", "Juan Tuiter", "soyelcapo");

        $this->assertTrue($user instanceof User);
        $this->assertEquals("ventilete", $user->getUserId());
        $this->assertEquals("Juan Tuiter", $user->getName());
        $this->assertEquals("soyelcapo", $user->getPassword());
    }
    
    public function testPodesCrearOtroObj() {
        $user = new User("ventilete2", "Juan Tuiter2", "soyelcapo2");

        $this->assertTrue($user instanceof User);
        $this->assertEquals("ventilete2", $user->getUserId());
        $this->assertEquals("Juan Tuiter2", $user->getName());
        $this->assertEquals("soyelcapo2", $user->getPassword());
    }
}