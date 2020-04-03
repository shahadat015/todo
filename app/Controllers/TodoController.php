<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Todo;

class TodoController extends Controller
{
	/**
	* Show the index page
	*
	* @return void
	*/
	public function index()
	{ 
		view('home.php');
	}

	/**
	* Get all todos from database
	*
	* @return void
	*/
	public function todos()
	{
		return json(Todo::all());
	}

	/**
	* Store data in database
	*
	* @return void
	*/
	public function store()
	{
		Todo::create([
			'task' => $_POST['task'], 
			'created_at' => date('y-m-d h:i:s')
		]);

		return json("New task successfully created");
	}

	/**
	* Update data from database
	*
	* @return void
	*/
	public function update()
	{
		Todo::update([
			'task' => $_POST['task']
		], $this->params['id']);

		return json("Task successfully updated");
	}
	
	/**
	* Update complete time mark as complete
	*
	* @return void
	*/
	public function complete()
	{
		Todo::update([
			'completed_at' => date('y-m-d h:i:s'),
		], $this->params['id']);

		return json("Task marked as completed");
	}

	/**
	* Get incomplete items from database
	*
	* @return void
	*/
	public function incomplete()
	{
		return json(Todo::whereIsNull('completed_at'));
	}

	/**
	* Get incomplete items from database
	*
	* @return void
	*/
	public function incompleted()
	{
		return json(Todo::whereIsNotNull('completed_at'));
	}

	/**
	* Update complete time mark as complete
	*
	* @return void
	*/
	public function destroy()
	{
		Todo::destroy();

		return json("Tasks successfully deleted");
	}
}