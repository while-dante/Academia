<?php

namespace Tuiter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserNameController implements \Tuiter\Interfaces\Controller {
    public function config($app) {
        $app->get('/{username}', function (Request $request, Response $response, array $args) {
            $userId = $args['username'];
            $userObject = $request->getAttribute("userService")->getUser($userId);
            
            if(!($userObject instanceof \Tuiter\Models\UserNull)){

                $postList = $request->getAttribute("postService")->getAllPosts($userObject);
    
                $template = $request->getAttribute("twig")->load('/feed.html');
                $response->getBody()->write(
                    $template->render(['posts' => $postList])
                );
                return $response;
            }else{
                $response->getBody()->write("error");
                return $response;
            }
        });
    }
}