<?php

/**
 *
 * boot script
 * using Psr7 Request, Response, Payload, View and Emitter
 *
 */

declare(strict_types = 1);

<<<<<<< HEAD



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








/**
 * use
 */

=======
>>>>>>> dccc2d43444bf1a706511baacd7dde91dc93f269
use Lab42\Http\ServerRequest\ServerRequestCreator;
use Lab42\Http\Response\HtmlResponse;
use Lab42\Http\Emitter\SapiEmitter as Emitter;
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
$emitter = new Emitter();
$emitter->emit($response);



/**
 * echo response
 */
// echo($response->getBody()->getContents());



// eof
