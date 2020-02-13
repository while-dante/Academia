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
            
            foreach ($posts as $post) {
                $post->likes = $request->getAttribute('likeService')->count($post);
            }
            
            $response->getBody()->write(
                $template->render(['posts' =>  $posts, 'user' => $request->getAttribute("user")->getName(), 'login' => $request->getAttribute('login'), 'current_user' => $request->getAttribute("user")->getName()])
            );
            return $response;
        });
    }
}
