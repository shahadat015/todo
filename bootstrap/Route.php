<?php

namespace Bootstrap;

class Route
{
	/**
	* Associative array of routes (the routing table)
	* @var array
	*/
	protected static $routes = [];

	/**
	* Parameters from the matched routes
	* @var array
	*/
	protected static $params = [];

	/**
	* Addd a route to the routing table
	*
	* @param string $route the route URL
	* @param array $params Parameters (controller, action, etc.)
	*
	* @return void
	*/
	public static function get($route, $params = [])
	{
		// Convert the route to a regular expression: escape forward slashes
		$route = preg_replace('/\//', '\\/', $route);

		// Convert variables e.g. {controller}
		$route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

		// Convert variables with custom regular expressions e.g. {id:\d+}
		$route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

		// Add start and end delimiters, and case insensitive flag
		$route = '/^' . $route . '$/i';

		static::$routes[$route] = $params;
	}

	/**
	* Get all the routes from the routing table
	*
	* @return array
	*/
	public static function getRoutes()
	{
		return static::$routes;
	}

	/**
	* Match the route to the routes in the routing table, setting the $params
	* property if a route is found
	* @param string $url the route URL
	*
	*@return boolean true if a match found, false otherwise
	*/
	public static function match($url)
	{
		foreach (static::$routes as $route => $params) {
			if (preg_match($route, $url, $matches)) {
				// Get named capture group values
				foreach ($matches as $key => $match) {
					if (is_string($key)) {
						$params[$key] = $match;
					}
				}
				static::$params = $params;
				return true;
			}
		}

		return false;
	}

	/** 
	*Get the currently matched parameters
	*
	* @return array
	*/

	public static function getParams()
	{
		return static::$params;
	}

	/**
	* Dispatch the route, creating the controller object and naming the action method
	*
	* @param string $url the route URL
	*
	* @return void
	*/
	public static function dispatch($url)
	{
		$url = static::removeQueryStringVariables($url);

		if (static::match($url)) {
			$controller = static::$params['controller'];
			$controller = static::convertToStudlyCaps($controller);
			$controller = static::getNamespace() . $controller;

			if (class_exists($controller)) {
				$controller_object = new $controller(static::$params);

				$action = static::$params['action'];
				$action = static::convertToCamelCase($action);

				if (is_callable([$controller_object, $action])) {
					$controller_object->$action();
				} else {
					throw new \Exception("Method $action does not exist in $controller");
				}
			} else {
				throw new \Exception("Controller $controller does not exist");
			}
		} else {
			throw new \Exception("No route matched", 404);
		}
	}

	/**
	* Convert the string with hypens to StudlyCaps,
	* e.g. post-authors => PostAuthos
	*
	* @param string $string The string to convert
	*
	* @return string
	*/
	protected static function convertToStudlyCaps($string)
	{
		return str_replace('  ', '', ucwords(str_replace('-', ' ', $string)));
	}

	/**
	* Convert the string with hypens to camelCase,
	* e.g. add-new => addNew
	*
	* @param string $string The string to convert
	*
	* @return string
	*/
	protected static function convertToCamelCase($string)
	{
		return lcfirst(static::convertToStudlyCaps($string));
	}

	/**
	* Remove the query string variables from the URL (if any). As the full
	* query string is used for the route, any variables at the end will need
	* to be removed before the routes is matched to the routin table. For
	* example: 
	*
	*	URL 					$_SERVER['QUERY_STRING']	Route
	*------------------------------------------------------------
	*	localhost					''							''
	*	localhost/?				''							''
	*	localhost/?page=1			page=1						''
	*	localhost/posts?page=1	posts&page=1				''
	*
	* A URL of the format localhost/?page (one variable name, no value) wont
	* word however. (NB. the .htaccess file converts the first ? to a & when
	* it's passed through to the $_SERVER variable).
	*
	* @param string $url The full URL
	*/
	protected static function removeQueryStringVariables($url) 
	{
		if ($url != '') {
			$parts = explode('&', $url, 2);

			if (strpos($parts[0], '=') === false) {
				$url = $parts[0];
			}else{
				$url = '';
			}
		}

		return $url;
	}

	/**
	* Get the namespace for the controller class. The namespace define in the
	* route parameters is added if present.
	*
	* @return string The request URL
	*/
	protected static function getNamespace()
	{
		$namespace = 'App\Controllers\\';

		if(array_key_exists('namespace', static::$params)) {
			$namespace .= static::$params['namespace'] . '\\';
		}

		return $namespace;
	}
}