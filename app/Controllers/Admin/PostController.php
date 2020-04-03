<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;

class PostController extends Controller
{
	/**
	* Show the index page
	*
	* @return void
	*/
	public function index()
	{
		echo "Hello from the index action in the post controller";
	}

	/**
	* Show the create page
	*
	* @return void
	*/
	public function create()
	{
		echo "Hello from the create action in the post controller";
	}
	/**
	* Show the edit page
	*
	* @return void
	*/
	public function edit()
	{
		echo '<pre>';
		echo print_r($this->route_params['id'], true);
		echo '</pre>';
		echo "Hello from the edit action in the post controller";
	}
}