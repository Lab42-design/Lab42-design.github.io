<?php

/**
 *
 * boot script
 * using Psr7 Request, Response, Payload and View
 *
 */

declare(strict_types = 1);




$payload = [
    "title" => "json title", 
    "subtitle" => "json subtitle",
    "body" => "4325435 34565436547 768675867 8968795678 5e6565436 4352345345 235345435 2345342543",
    "slug" => "json-slug",
    "status" => "STATUS_42",
    "published" => true
];


define('LAZER_DATA_PATH', realpath(__DIR__).'/../_tmp/_database/'); //Path to folder with tables

use Lab42\Database\Database as Lazer;

/*
Lazer::create('lazarus', 
array(
    'id' => 'integer',
    'nickname' => 'string'
));
*/


$row = Lazer::table('lazarus');

//$row->nickname = 'defaultman'; // or $row->setField('nickname', 'new_user')
//$row->save();
echo '<pre>';
$result = Lazer::table('lazarus')->findAll();
foreach($result as $row)
{
    print_r($row);
}

$zzz = Lazer::table('lazarus')->where('id', '=', 1)->findAll();
foreach($zzz as $row)
{
    print_r($row);
}






/*
Lazer::create('projects', array(
    'title' => 'string',
    'subtitle' => 'string',
    "body" => "string",
    'slug' => 'string',
    'status' => 'string',
    'status' => 'string',
    "published" => 'boolean'
));
*/


$row = Lazer::table('projects');

$row->set($payload);
$row->save();








exit;

/**
 * use
 */

use Lab42\Http\ServerRequest\ServerRequestCreator;
use Lab42\Http\Response\HtmlResponse;
use Lab42\Domain\{Payload, Status};
use Lab42\SpaceSuit\View;



/**
 * Variables
 */

// root path
$rootpath =  __DIR__;



/**
 * Views
 */
$template = new View();

$viewpath = $rootpath . '/../resources/templates/';
$layout = $viewpath . 'layout.php';



/**
 * get view file with $request->getRequestTarget()
 */
$request = ServerRequestCreator::createFromGlobals();
$request_target = $request->getRequestTarget();

if ($request_target != '/') {
    $view_file = '_' . ltrim($request_target, '/') . '.php';
}
$view = $viewpath . $view_file ??= '_index.php'; 



// set layout amd view
$template->setLayout($layout);
$template->setView($view);

// set data for view
$data = [
    'message' => 'hello world',
    'text' => 'this is lab42.design'
];

// use payload for data
$payoad = new Payload(Status::SUCCESS, $data);
$template->setPayload($payoad);

// render view to $var
$rendered_view = $template->__invoke();



/**
 * response
 */
$response = new HtmlResponse(
    $rendered_view, $statusCode = HtmlResponse::STATUS_OK
);



/**
 * emit response
 */
// echo($response->getBody()->getContents());

use Lab42\Http\Emitter\SapiEmitter;

$emitter = new SapiEmitter();
$emitter->emit($response);



// eof





/*
//
use Lab42\Router\RouteCollector;

//
$handlerFn = fn(): ResponseInterface => new Response();

$handler = handler();
function handler(){
    $response = new HtmlResponse(__FUNCTION__ . '3253245345345 sdfgdfsgdf');
    print_r($response->getBody()->getContents());
}

//
$router = new RouteCollector();

$router->get('home', '/', $handler);
$router->get('mikka', '/mikka', $handlerFn);

$router->get('zorro', '/zorro', App\Action::class);

if (!$route = $router->routes()->match($request, false)) {
    // 404 Not Found
    echo '404';
};

if (!$route->isAllowedMethod($request->getMethod())) {
    echo '405';
};

// 200 OK
return $route;
*/

