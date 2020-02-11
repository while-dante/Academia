<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

session_start();

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) return false;
}

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);

$mongoconn = new \MongoDB\Client("mongodb://localhost");
$userService = new \Tuiter\Services\UserService($mongoconn->tuiter->users);
$postService = new \Tuiter\Services\PostService($mongoconn->tuiter->posts);
$likeService = new \Tuiter\Services\LikeService($mongoconn->tuiter->likes);
$followService = new \Tuiter\Services\FollowService($mongoconn->tuiter->follows, $userService);
$loginService = new \Tuiter\Services\LoginService($userService);


$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, array $args) use ($twig) {
    
    $template = $twig->load('index.html');

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

$app->post('/login', function (Request $request, Response $response) use ($loginService){

    $usuario = $loginService->login($_POST['usuario'],$_POST['pass']);
    $userId = $usuario->getUserId();

    $response = new \Slim\Psr7\Response();

    if ($_SESSION['login']){
        $response = $response->withStatus(302);
        $response = $response->withHeader('Location','/feed');
    }else{
        $response = $response->withStatus(302);
        $response = $response->withHeader('Location','/');
    }

    return $response;
});

$app->post('/registrar', function (Request $request, Response $response) use ($userService){

    $usuario = $userService->register($_POST['usuario'],$_POST['nombre'],$_POST['pass']);
    $_SESSION['registrado'] = $usuario;
    $response = new \Slim\Psr7\Response();
    
    $response = $response->withStatus(302);
    $response = $response->withHeader('Location','/');

    return $response;
});

$app->get('/feed', function (Request $request, Response $response) use ($postService,$followService,$twig){
    $template = $twig->load('feed.html');

    $followed = $followService->getFollowed($_SESSION['user']);
    
    $posts = array();
    $prePosts = array();
    foreach($followed as $usuario){
        $prePosts[] = $postService->getAllPosts($usuario);

        foreach($prePosts as $post){

            foreach($post as $content){
                $posts[] = array(
                    'content' => $content->getContent(),
                    'owner' => $content->getUserId()
                );
            }
        }
    }

    $response->getBody()->write(
        $template->render(array(
                'cabecera' => 'Principal',
            )
        )
    );

    return $response;
});

$app->post('/post', function (Request $request, Response $response) use ($postService,$userService){
    $activeUser = $userService->getUser($_SESSION['user']);
    $postService->create($_POST['content'],$activeUser);

    $response = new \Slim\Psr7\Response();
    $response = $response->withStatus(302);
    $response = $response->withHeader('Location','feed');

    return $response;
});

$app->get('/user/me', function(Request $request, Response $response) use($postService,$userService,$twig){
    $activeUser = $userService->getUser($_SESSION['user']);
    $posts = $postService->getAllPosts($activeUser);

    $template = $twig->load('user.html');

    $response->getBody()->write($template->render(
        array(
            'cabecera' => $_SESSION['user']
        )
    ));

    return $response;
});

$app->get('/follow', function (Request $request, Response $response) use ($followService){

});

$app->get('/contacto', function (Request $request, Response $response, array $args) use ($twig) {
    
    $template = $twig->load('contacto.html');

    $response->getBody()->write(
        $template->render(['name' => 'Dario'])
    );
    return $response;
});

$app->run();