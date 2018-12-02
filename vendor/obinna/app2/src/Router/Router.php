<?php
/**
 * Created by PhpStorm.
 * User: obinnajohnphill
 * Date: 30/11/18
 * Time: 14:20
 */

namespace Obinna\Router;

use Obinna\Controllers\YoutubeVideosController;

class Router
{
    private $request;
    private $supportedHttpMethods = array(
        "GET",
        "POST"
    );

    function __construct(IRequest $request)
    {
        $this->request = $request;
    }

    function __call($name, $args)
    {
        list($route, $method) = $args;

        if(!in_array(strtoupper($name), $this->supportedHttpMethods))
        {
            $this->invalidMethodHandler();
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    /**
     * Removes trailing forward slashes from the right of the route.
     * @param route (string)
     */
    private function formatRoute($route)
    {
        $result = rtrim($route, '/');
        if ($result === '')
        {
            return '/';
        }
        return $result;
    }

    private function invalidMethodHandler()
    {
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
    }

    private function defaultRequestHandler()
    {
        $redirect = "../404";
        header( "Location: $redirect" );
    }

    /**
     * Resolves a route
     */
    function resolve()
    {
        $methodDictionary = $this->{strtolower($this->request->requestMethod)};
        $formatedRoute = $this->formatRoute($this->request->requestUri);

         if (empty($methodDictionary[$formatedRoute])){
            return $this->request->requestUri;
         }

       return call_user_func_array($methodDictionary[$formatedRoute], array($this->request));
       //  new YoutubeVideosController($data);
    }

    function __destruct()
    {
      $this->resolve();
    }
}