<?php

use Bootstrap\Route;

// add the routes
Route::get('', ['controller' => 'TodoController', 'action' => 'index']);
Route::get('todos', ['controller' => 'TodoController', 'action' => 'todos']);
Route::get('todos/store', ['controller' => 'TodoController', 'action' => 'store']);
Route::get('todos/{id:\d+}/update', ['controller' => 'TodoController', 'action' => 'update']);
Route::get('todos/{id:\d+}/complete', ['controller' => 'TodoController', 'action' => 'complete']);
Route::get('todos/destroy', ['controller' => 'TodoController', 'action' => 'destroy']);
Route::get('todos/incomplete', ['controller' => 'TodoController', 'action' => 'incomplete']);
Route::get('todos/completed', ['controller' => 'TodoController', 'action' => 'incompleted']);


Route::dispatch($_SERVER['QUERY_STRING']);