<?php

namespace TestTuiter\Services;

use PHPUnit\Framework\TestCase;
use \Tuiter\Services\LoginService;
use \Tuiter\Services\UserService;
use \Tuiter\Models\User;
use \Tuiter\Models\UserNull;

final class LoginServiceTest extends TestCase{

    public function setUp():void{
        $_SESSION['login']=False;
    }
    
    public function testLoginClass(){
        $this->assertTrue(class_exists('\Tuiter\Services\LoginService'));
    }
    
    public function testLoginBien(){
        $userService = $this->createMock(UserService::class);
        $userx = new User('Coco', 'Pepe Ventilete', '123456');
        $userService->method('getUser')->willReturn($userx);


        $ls = new \Tuiter\Services\LoginService($userService);
        $user = $ls->login("Coco", "123456");
        $this->assertEquals($user, $userx);
        $this->assertTrue($user instanceof User);
    }

    public function testLoginMal(){
        $userService = $this->createMock(UserService::class);
        $userx = new User('Coco', 'Pepe Ventilete', '123456');
        $userService->method('getUser')->willReturn($userx);


        $ls = new \Tuiter\Services\LoginService($userService);
        $user = $ls->login("Coco", "ieedhhd");
        $this->assertTrue($user instanceof UserNull);
    }


    public function testLoginDeAlguienQueNoExiste(){
        $userService = $this->createMock(UserService::class);
        $userx = new UserNull('', '', '');
        $userService->method('getUser')->willReturn($userx);


        $ls = new \Tuiter\Services\LoginService($userService);
        $user = $ls->login("Coco", "123456");
        $this->assertTrue($user instanceof UserNull);
    }

    public function testUsuarioLogueado(){
        $userService = $this->createMock(UserService::class);
        $userx = new User('Coco', 'Pepe Ventilete', '123456');
        $userService->method('getUser')->willReturn($userx);

        $ls = new \Tuiter\Services\LoginService($userService);
        $user = $ls->login("Coco", "123456");
        $this->assertTrue($_SESSION['login']);
        $this->assertEquals($_SESSION['user'], "Coco");
    }

    public function testUsuarioNoLogueado(){
        $userService = $this->createMock(UserService::class);
        $userx = new User('Coco', 'Pepe Ventilete', '123456');
        $userService->method('getUser')->willReturn($userx);

        $ls = new \Tuiter\Services\LoginService($userService);
        $user = $ls->login("Coco", "25984");
        $this->assertFalse($_SESSION['login']);
    }

    public function testLoginNoLogueadoUsuarioNoExiste(){
        $userService = $this->createMock(UserService::class);
        $userx = new UserNull('', '', '');
        $userService->method('getUser')->willReturn($userx);


        $ls = new \Tuiter\Services\LoginService($userService);
        $user = $ls->login("Coco", "123456");
        $this->assertTrue($user instanceof UserNull);
        $this->assertFalse($_SESSION['login']);
    }
    
    public function testLogout(){
        $userService = $this->createMock(UserService::class);
        $userx = new User('Coco', 'Pepe Ventilete', '123456');
        $userService->method('getUser')->willReturn($userx);

        $ls = new \Tuiter\Services\LoginService($userService);
        $user = $ls->login("Coco", "123456");
        $ls->logout();
        $this->assertTrue(empty($_SESSION['login']));
        $this->assertTrue(empty($_SESSION['user']));
    }

    public function testGetLoggedUser() {
        $userService = $this->createMock(UserService::class);
        $userx = new User('Coco', 'Pepe Ventilete', '123456');
        $userService->method('getUser')->willReturn($userx);

        $ls = new \Tuiter\Services\LoginService($userService);
        $loginUser = $ls->login("Coco", "123456");
        $this->assertFalse($loginUser instanceof \Tuiter\Models\UserNull);

        $user = $ls->getLoggedUser();
        $this->assertFalse($user instanceof \Tuiter\Models\UserNull);
    }

    public function testGetLoggedUserNotLogged() {
        $userService = $this->createMock(UserService::class);
        $userx = new User('Coco', 'Pepe Ventilete', '123456');
        $userService->method('getUser')->willReturn($userx);

        $ls = new \Tuiter\Services\LoginService($userService);
        $user = $ls->getLoggedUser();
        $this->assertTrue($user instanceof \Tuiter\Models\UserNull);
    }
}