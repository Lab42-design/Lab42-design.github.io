<?php

/**
 *
 * boot script
 * using Psr7 Request, Response, Payload, View and Emitter
 *
 */

declare(strict_types = 1);

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

// if request is NOT root ... then get the partial name from the $request_target
if ($request_target != '/') {
    $view_file = '_' . ltrim($request_target, '/') . '.php';
}
// default to _index.php when no $request_target is provided
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
