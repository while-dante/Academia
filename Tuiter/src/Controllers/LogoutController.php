<?php

namespace Tuiter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LogoutController implements \Tuiter\Interfaces\Controller {

    public function config($app) {

        $app->get('/logout', function (Request $request, Response $response, array $args) {
            $request->getAttribute("loginService")->logout();
            $response = $response->withStatus(302);
            return $response->withHeader("Location", "/");
        });

    }


}