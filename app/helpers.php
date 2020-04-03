<?php

use Bootstrap\View;

if (! function_exists('view')) {
    
    function view($file, $params = [])
    {
    	View::render($file, $params);
    }
}

if (! function_exists('json')) {

    function json($data)
    {
    	echo json_encode($data);
    }
}
