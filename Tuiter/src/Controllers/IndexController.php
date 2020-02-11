<?php

namespace Tuiter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class IndexController implements \Tuiter\Interfaces\Controller {

    public function config($app) {

        $app->get('/', function (Request $request, Response $response, array $args){
    
            $template = $request->getAttribute('twig')->load('index.html');
        
            if(empty($_SESSION['login']) or empty($_SESSION['registrado'])){
                $_SESSION['login'] = False;
                $_SESSION['registrado'] = False;
            }
        
            if (!$_SESSION['login']){
                $response->getBody()->write(
                    $template->render([
                        'cabecera' => 'Bienvenido',
                        'titulo' => 'Tuiter',
                        'usuario' => 'Nombre de Usuario',
                        'pass' => 'Contraseña',
                        'nombre' => 'Nombre Completo',
                        'mensaje' => 'Incorrecto, intente de nuevo'
                    ])
                );
            }elseif(!$_SESSION['registrado']){
                $response->getBody()->write(
                    $template->render([
                        'cabecera' => 'Bienvenido',
                        'titulo' => 'Tuiter',
                        'usuario' => 'Nombre de Usuario',
                        'pass' => 'Contraseña',
                        'nombre' => 'Nombre Completo',
                        'mensaje' => 'Registro fallido'
                    ])
                );
            }else{
                $response->getBody()->write(
                    $template->render([
                        'cabecera' => 'Bienvenido',
                        'titulo' => 'Tuiter',
                        'usuario' => 'Nombre de Usuario',
                        'pass' => 'Contraseña',
                        'nombre' => 'Nombre Completo'
                    ])
                );
            }
            return $response;
        });
    }
}