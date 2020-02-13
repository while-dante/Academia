<?php

namespace Tuiter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FollowController implements \Tuiter\Interfaces\Controller {
    public function config($app){
        $app->get('/follow/{username}', function (Request $request, Response $response, array $args) {
            $userId=$args["username"];
            if($userId !== $request->getAttribute("user")->getUserId()){
                $followService=$request->getAttribute("followService");
                $loginService=$request->getAttribute("loginService");
                $userService=$request->getAttribute("userService");
                $followService->follow($loginService->getLoggedUser(),$userService->getUser($userId));
            }
                $response = $response->withStatus(302);
                $response = $response->withHeader("Location","/".$userId);
            return $response;
        });
        $app->get('/unFollow/{username}', function (Request $request, Response $response, array $args) {
            $userId=$args["username"];
            $followService=$request->getAttribute("followService");
            $loginService=$request->getAttribute("loginService");
            $followService->follow($loginService->getLoggedUser()->getUserId(),$userId);
            $response = $response->withStatus(302);
            $response = $response->withHeader("Location","/".$userId);
            return $response;
        });

    }
}