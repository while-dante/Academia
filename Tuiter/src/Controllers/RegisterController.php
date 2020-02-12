<?php

namespace Tuiter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RegisterController implements \Tuiter\Interfaces\Controller {

    public function config($app) {

        $app->post('/register', function (Request $request, Response $response, array $args) {
            
            $result = $request->getAttribute("userService")->register($_POST["userId"],$_POST['name'],$_POST["password"]);
            $response = $response->withStatus(302);

            if($result){
                return $response->withHeader("Location", "/");
            }
            else{
                return $response->withHeader("Location", "/");
            }
        });

    }


}