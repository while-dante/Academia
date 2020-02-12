<?php
namespace Tuiter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class NewPostController implements \Tuiter\Interfaces\Controller {

    public function config($app) {
        $app->get('/newPost', function (Request $request, Response $response, array $args) {
            echo "hello";
            return $response;
        });
        $app->post('/newPost', function (Request $request, Response $response, array $args) {
        
            $request->getAttribute("postService")->create($_POST["contenido"],$request->getAttribute("userService")->getUser($_POST["user"]));
            
            $response = $response->withStatus(302);
            $response = $response->withHeader("Location","/");
            
            return $response;    
        });
    }
}