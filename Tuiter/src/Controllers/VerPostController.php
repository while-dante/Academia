<?php

namespace Tuiter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VerPostController implements \Tuiter\Interfaces\Controller {

    public function config($app) {

        $app->get('/verPost/{postId}', function (Request $request, Response $response, array $args) {
            
            $template = $request->getAttribute('twig')->load('verPost.html');
            $postId = $args['postId'];
            $ps = $request->getAttribute("postService");
            
            $post = $ps->getPost($postId);

            $response->getBody()->write(
                $template->render([
                    'fecha' => $post->getTime(),
                    'contenido' => $post->getContent(),
                    'usuario del post' => $post->getUserId()
                ])
            );
           
            return $response;
        });
    }
}