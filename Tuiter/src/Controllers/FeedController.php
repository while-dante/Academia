<?php
namespace Tuiter\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
class FeedController implements \Tuiter\Interfaces\Controller{
    public function config($app){
    $app->get('/feed', function (Request $request, Response $response, array $args)  {
    $template = $request->getAttribute('twig')->load('feed.html');
    $allUsersFollowed = $request->getAttribute('followService')->getFollowed($request->getAttribute('user')->getUserId());
    $allUsers= $allUsersFollowed;
    $allUsers[]=$request->getAttribute('user');
    $allpost = array();
    foreach ($allUsers as $v) {
        foreach ($request->getAttribute('postService')->getAllPosts($v) as $p) {
            $allpost[] = $p;
        }
    }
    $time_sort = function ($a, $b){
        return $a->getTime()<$b->getTime();
    };

    usort($allpost, $time_sort);

    $response->getBody()->write(
        $template->render(['posts' => $allpost])
    );
    return $response;
});
}
}