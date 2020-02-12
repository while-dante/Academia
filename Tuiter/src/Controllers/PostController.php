<?php

namespace Tuiter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PostController implements \Tuiter\Interfaces\Controller {

    public function config($app) {

        $app->post('/post', function (Request $request, Response $response, array $args) {
            $ps = $request->getAttribute("postService");
            $ls = $request->getAttribute("loginService");
            $user = $ls->getLoggedUser();
            $ps->create($_POST['post'], $user);

            $response = $response->withStatus(302);
            $response = $response->withHeader("Location", "/user/me");
            return $response;
        });
    }
}