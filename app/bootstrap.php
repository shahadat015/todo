<?php

/**
* Error and exception handling
*/
error_reporting(E_ALL);
set_error_handler('Bootstrap\Exception::errorHandler');
set_exception_handler('Bootstrap\Exception::exceptionHandler');

require __DIR__.'/../routes/web.php';