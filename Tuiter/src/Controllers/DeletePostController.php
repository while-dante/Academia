<?php

namespace Tuiter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DeletePostController implements \Tuiter\Interfaces\Controller {

    public function config($app) {

        $app->get('/deletePost/{postId}', function (Request $request, Response $response, array $args) {
            $previousPage = $_GET['URL'];
            
            $postId = $args['postId'];
            $ps = $request->getAttribute("postService");
            $user = $request->getAttribute("user");
            $ps->delete($postId, $user);
            $response = $response->withStatus(302);
            $response = $response->withHeader("Location", $previousPage);
            return $response;
        });
    }
}