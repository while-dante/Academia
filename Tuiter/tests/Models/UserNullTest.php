<?php

namespace TestTuiter\Models;


use Tuiter\Models\UserNull;

final class UserNullTest extends \PHPUnit\Framework\TestCase {

    public function testExisteClase() {
        $this->assertTrue(class_exists("\Tuiter\Models\UserNull"));
    }

    public function testPodesCrearObj() {
        $user = new UserNull("ventilete", "Juan Tuiter", "soyelcapo");

        $this->assertTrue(is_subclass_of($user, "\Tuiter\Models\User"));
        $this->assertEquals("Null", $user->getUserId());
        $this->assertEquals("Null", $user->getName());
        $this->assertEquals("Null", $user->getPassword());
    }
    
    public function testPodesCrearOtroObj() {
        $user = new UserNull("ventilete2", "Juan Tuiter2", "soyelcapo2");

        $this->assertTrue(is_subclass_of($user, "\Tuiter\Models\User"));
        $this->assertEquals("Null", $user->getUserId());
        $this->assertEquals("Null", $user->getName());
        $this->assertEquals("Null", $user->getPassword());
    }
}