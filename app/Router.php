<?php

namespace App;

use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * First, let's define our Router object.
 */
class Router
{
    /**
     * The request we're working with.
     *
     * @var string
     */
    public $request;

    /**
     * The $routes array will contain our URI's and callbacks.
     * @var array
     */
    public $routes = [];

    /**
     * For this example, the constructor will be responsible
     * for parsing the request.
     *
     * @param array $request
     */
    public function __construct(Request $request)
    {
        /**
         * This is a very (VERY) simple example of parsing
         * the request. We use the $_SERVER superglobal to
         * grab the URI.
         */
        // $this->request $request;
        $this->request = ltrim($request->getRequestTarget(), '/');
    }

    /**
     * Add a route and callback to our $routes array.
     *
     * @param string   $uri
     * @param Callable $fn
     */
    public function addRoute(string $uri, \Closure $fn) : void
    {
        $this->routes[$uri] = $fn;
    }

    /**
     * Determine is the requested route exists in our
     * routes array.
     *
     * @param  string  $uri
     * @return boolean
     */
    public function hasRoute(string $uri) : bool
    {
        return array_key_exists($uri, $this->routes);
    }

    /**
     * Run the router.
     *
     * @return mixed
     */
    public function run()
    {
        // echo __METHOD__;

        // print_r( $this->hasRoute($this->request) );

        if($this->hasRoute($this->request)) {
            $this->routes[$this->request]->call($this);
        }
    }
}

/**
 * Create a new router instance.
 */
// $router = new Router($_SERVER);

/**
 * Add a "hello" route that prints to the screen.
 */
// $router->addRoute('hello', function() {
//     echo 'Well, hello there!!';
// });

/**
 * Run it!
 */
// $router->run();