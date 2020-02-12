<?php

namespace Tuiter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserMeController implements \Tuiter\Interfaces\Controller {

    
    public function config($app) {
        
        $app->get('/user/me', function (Request $request, Response $response, array $args) {
                        
            $template = $request->getAttribute("twig")->load('/feed.html');
            $user = $request->getAttribute("user");
            $posts= $request->getAttribute("postService")->getAllPosts($user);

            $response->getBody()->write(
                $template->render(['posts' =>  print_r($posts)])
            );
            return $response;
        });
    }
}
