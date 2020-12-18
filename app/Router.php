<?php

declare(strict_types = 1);

namespace App;

use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Simple PSR7 Router
 */
class Router
{
    public Request $request;

    public $routes = [];

    /**
     * For this example, the constructor will be responsible
     * for parsing the request.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getTarget() : string
    {
        $this->requestTarget = $this->request->getRequestTarget();

        if ($this->requestTarget != '/') {
            $this->requestTarget = ltrim($this->request->getRequestTarget(), '/');
        }

        //return $this->requestTarget;
        return $this->requestTarget;
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
        $this->getTarget();


        if($this->hasRoute($this->requestTarget)) {
            $this->routes[$this->requestTarget]->call($this);
        } else {
            throw new \App\RouteNotFoundException(sprintf('`%s` route was not found / 404', $this->requestTarget));
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