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
            $post = $postService->getPost($postId);
            $user = $request->getAttribute('user');
            $fueLikeado=$likeService->like($user,$post);
            if(!$fueLikeado)
            {
                $response = $response->withStatus(302)->withHeader("Location","/unlike/$postId ?URL=$previousPage");
                return $response;
            }
            $response = $response->withStatus(302);
            $response = $response->withHeader("Location", $previousPage);
            return $response;
        });
        $app->get('/unlike/{postId}', function (Request $request, Response $response, array $args) {
            $postId=$args["postId"];
            $previousPage = $_GET['URL'];
            $likeService=$request->getAttribute("likeService");
            $postService=$request->getAttribute("postService");
            $post = $postService->getPost($postId);
            $user = $request->getAttribute('user');
            $likeService->unlike($user,$post);
            $response = $response->withStatus(302);
            $response = $response->withHeader("Location", $previousPage);
            return $response;
        });
    }
}