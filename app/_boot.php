<?php

/**
 *
 * boot script
 * using Psr7 Request, Response, Payload, View and Emitter
 *
 */

declare(strict_types = 1);



// FILEBASE 


/*
$database = new \Filebase\Database([
    'dir' => __DIR__ . '/../_tmp/db/filebase'
]);

// in this example, you would search an exact user name
// it would technically be stored as user_name.json in the directories
// if user_name.json doesn't exists get will return new empty Document
$item = $database->get('mikka');
// display property values


// change existing or add new properties
$item->first_name = 'mikka';
$item->last_name = 'makka';
$item->email = 'example@example.com';
$item->tags  = ['php','developer','html5'];
// need to save? thats easy!
// $item->save();


// check if a record exists and do something if it does or does not
if ($database->has('kingslayer'))
{
    // do some action
    echo $item->first_name . '<br/>';
    echo $item->last_name . '<br/>';;
    echo $item->email . '<br/>';;
}

// Need to find all the users that have a tag for "php" ?
$users = $database->where('tags','IN','php')->results();

// Need to search for all the users who use @yahoo.com email addresses?
$users = $database->where('email','LIKE','@yahoo.com')->results();







$db->title = 'kingslayer';
$db->save();



$itemx = $db->get('kingslayer');

echo $itemx->first_name;
echo $itemx->last_name;
echo $itemx->email;


echo '<hr>';




exit();
*/








use Lab42\Http\ServerRequest\ServerRequestCreator;
use Lab42\Http\Response\HtmlResponse;
use Lab42\Http\Emitter\SapiEmitter as Emitter;
use Lab42\Domain\{Payload, Status};
use Lab42\SpaceSuit\View;



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
// $emitter = new Emitter();
// $emitter->emit($response);



/**
 * echo response
 */
echo($response->getBody()->getContents());
