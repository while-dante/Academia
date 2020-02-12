<?php

namespace Tuiter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LoginController implements \Tuiter\Interfaces\Controller {

    public function config($app) {

        $app->post('/login', function (Request $request, Response $response, array $args) {
            
            $user = $request->getAttribute("loginService")->login($_POST["userId"],$_POST["password"]);
            $response = $response->withStatus(302);

            if(!$user instanceof \Tuiter\Models\UserNull){
                return $response->withHeader("Location", "/feed");
            }
            else{
                return $response->withHeader("Location", "/");
            }
        });

    }


}