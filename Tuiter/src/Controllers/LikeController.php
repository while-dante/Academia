<?php

namespace Tuiter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LikeController implements \Tuiter\Interfaces\Controller {
    public function config($app){
        $app->get('/like/{postId}', function (Request $request, Response $response, array $args) {
            $postId=$args["postId"];
            $previousPage = $_GET['URL'];
            $likeService=$request->getAttribute("likeService");
            $postService=$request->getAttribute("postService");
            $loginService=$request->getAttribute("loginService");
            $post = $postService->getPost($postId);
            $user = $loginService->getLoggedUser();
            $likeService->like($user,$post);
            $response = $response->withStatus(302);
            $response = $response->withHeader("Location", $previousPage);
            return $response;
        });
    }
}