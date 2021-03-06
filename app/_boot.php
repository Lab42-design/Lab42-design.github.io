<?php

/**
 *
 * boot script
 * using Psr7 Request, Response, Payload, View and Emitter
 *
 */

declare(strict_types = 1);

use Lab42\Http\ServerRequest\ServerRequestCreator as Request;
use Lab42\Http\Response\HtmlResponse;
// use Lab42\Http\Response\Response;
// use Lab42\Http\Message\Response;
use Lab42\Http\Emitter\SapiEmitter as Emitter;
use Lab42\Domain\{Payload, Status};
use Lab42\SpaceSuit\View;
use Filebase\Database;

use App\Router;





$request = Request::createFromGlobals();

/**
 * Create a new router instance.
 */
// $router = new App\Router($_SERVER);
// $router = new App\Router($request);




/**
 * Add a "hello" route that prints to the screen.
 */
/*
$router->addRoute('k', function() {
    echo 'Well, hello there!! ROT';
});
$router->addRoute('hello', function() {
    echo 'Well, hello there!!';
});
*/

// print_r($router);



/**
 * Run it!
 */
// $router->run();








// FILEBASE 
$database = new Database([
    'dir' => __DIR__ . '/../_tmp/db',
    // 'backupLocation' => 'path/to/database/backup/dir',
    'format'         => \Filebase\Format\Json::class,
    'cache'          => true,
    'cache_expires'  => 1800,
    'pretty'         => true,
    'safe_filename'  => true,
    'read_only'      => false,
    'validate' => [
        'title'   => [
            'valid.type' => 'string',
            'valid.required' => true
        ]
    ]
]);


// create a project
$item = $database->get('project_35345345');
$item->title = 'project_35345345';
$item->subtitle = 'ehhh';
$item->body = '6654 6233 3343 4444 3';
$item->tags  = ['42','demo','data'];
// $item->save();


$projects = $database->where('tags','IN','demo')->results();
// $data = $projects;

if (!$projects) {
    $data = [
        'message' => 'hello world',
        'text' => 'this is lab42.design'
    ];
} 

if (count($projects) > 1) {
    $data = $projects;
} else {
    $data = $projects[0];
}







// Need to search for all the users who use @yahoo.com email addresses?
// $projects = $database->where('email','LIKE','@gmail.com')->results();







/**
 * Variables
 */
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
$request = Request::createFromGlobals();
// $request_target = $request->getRequestTarget();
$request_target = ltrim($request->getRequestTarget(), '/');

//print_r('req target ___' . $request_target . '___');
//var_dump($request_target);







//?????????????????
// routing
$router = new Router($request);

$router->addRoute('routetest', function() {
    //print_r($this->routes['routetest'] );
});


$router->addRoute('/', function() {
    $xx =  'Well, hello ehh //////// there!!';
    // $view = $viewpath . '_index.php';
    //print_r($xx );

});

$router->addRoute('zorromorro', function() {
    $xx =  'Well, hello there!!';
    // $view = $viewpath . '_index.php';

    $response = new HtmlResponse(
        $xx, 404
    );
    emitResponse($response);

});

$router->addRoute('ehh', function() {
   // $xx =  'Well, hello ehh there!!';
    // $view = $viewpath . '_index.php';
   // echo '<pre>' . $xx;
   // print_r($this->getTarget());
});


// print_r($router);



try {

    $router->run();

} catch (Exception $e) {

    $msg = 'Caught exception: ' .  $e->getMessage() . "\n";

    $responseX = new HtmlResponse(
        '___ ' . $msg, $statusCode = HtmlResponse::STATUS_NOT_FOUND
    );
    emitResponse($responseX);

}




// defaults to 404
$view = $viewpath . '_404.php'; 

if (empty($request_target)) {
    // default to _index.php when no $request_target is provided
    $view = $viewpath . $view_file ??= '_index.php'; 
} else {
    $view = $viewpath . $view_file = '_' . $request_target . '.php';
}





// set layout amd view
$template->setLayout($layout);
$template->setView($view);

// use payload for data
$payoad = new Payload(Status::SUCCESS, $data);
$template->setPayload($payoad);

// render view to $var
// $rendered_view = $template->__invoke();



/**
 * response
 */

try {
    $rendered_view = $template->__invoke();

    $response = new HtmlResponse(
        $rendered_view, $statusCode = HtmlResponse::STATUS_OK
    );
    emitResponse($response);

} catch (Exception $e) {

    // echo 'Caught exception: ',  $e->getMessage(), "\n";
    $view = $viewpath . '_404.php';
    $template->setView($view);
    $rendered_view = $template->__invoke();

    $response = new HtmlResponse(
        $rendered_view, $statusCode = HtmlResponse::STATUS_NOT_FOUND
    );

    emitResponse($response);

}








/**
 * emit response
 */
function emitResponse($response)
{
    $emitter = new Emitter();
    $emitter->emit($response);
}







/**
 * echo response
 */
// echo($response->getBody()->getContents());
