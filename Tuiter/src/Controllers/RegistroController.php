<?php

namespace Tuiter\Controllers;

class RegistroController implements \Tuiter\Interfaces\Controller{

    public function config($app){
        $app->post('/registrar', function (Request $request, Response $response){
            $uService = $request->getAttribute('userServie');

            $usuario = $uService->register($_POST['usuario'],$_POST['nombre'],$_POST['pass']);
            $_SESSION['registrado'] = $usuario;
            $response = new \Slim\Psr7\Response();
            
            $response = $response->withStatus(302);
            $response = $response->withHeader('Location','/');
        
            return $response;
        });
    }
}