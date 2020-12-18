<?php

/**
 *
 * boot script
 * using Psr7 Request, Response, Payload, View and Emitter
 *
 */

declare(strict_types = 1);

// FILEBASE 

$database = new \Filebase\Database([
    'dir' => __DIR__ . '/../_tmp/db/filebase'
]);

// in this example, you would search an exact user name
// it would technically be stored as user_name.json in the directories
// if user_name.json doesn't exists get will return new empty Document
$item = $database->get('mikka');

// create a project
$item = $database->get('project_35345345');
$item->title = 'project_35345345';
$item->subtitle = 'ehhh';
$item->body = '6654 6233 3343 4444 3';
$item->tags  = ['42','demo','data'];
// $item->save();

// set data for view
// check if a record exists and do something if it does or does not
if ($database->has('project_42X')) {
    // do some action
    // echo $item->first_name . '<br/>';
    // echo $item->last_name . '<br/>';;
    // echo $item->email . '<br/>';;
    $projects = $database->where('tags','IN','42')->results();

    //print_r(count($projects));
    // exit;

    // check if rray has more then 1 items

    if (count($projects, COUNT_RECURSIVE) > 1) {
        $data = $projects;
    } else {
        $data = $projects[0];
    }
    // $data = $projects;
    // Need to find all the users that have a tag for "php" ?
    // $projects = $database->where('tags','IN','42')->results();
} else {
    //$data = [
    //    'message' => 'hello world',
    //    'text' => 'this is lab42.design'
    //];
}

$projects = $database->where('tags','IN','42')->results();
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



use Lab42\Http\ServerRequest\ServerRequestCreator as Request;
use Lab42\Http\Response\HtmlResponse;
use Lab42\Http\Response\Response;
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
$request = Request::createFromGlobals();
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
