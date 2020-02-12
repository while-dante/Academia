<?php

namespace Tuiter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tuiter\Models\UserNull;

class LoginController
 implements \Tuiter\Interfaces\Controller {
   
    public function config($app) {

        $app->get('/login', function (Request $request, Response $response, array $args) {
    
            $template = $request->getAttribute("twig")->load('index.html');
            $response->getBody()->write(
                $template->render([])
            );
            return $response;
        });

        $app->get('/feed', function (Request $request, Response $response, array $args) {
    
            $template = $request->getAttribute("twig")->load('feed.html');
            $response->getBody()->write(
                $template->render([])
            );
            return $response;
        });

        $app->post('/login', function (Request $request, Response $response, array $args) {
    
            $login = $request->getAttribute("loginService")->login($_POST['user'], $_POST['pass']);
            if (!($login instanceof \Tuiter\Models\UserNull)){
                
                $template = $request->getAttribute("twig")->load('feed.html');
                $response->getBody()->write(
                    $template->render(['user' => $request->getAttribute("user")->getName()])
                );
                return $response;
            }

            return $response;
        });

    }
}