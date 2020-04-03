<?php

namespace App\Models;

use Config\Database;
use PDO;
use PDOException;

abstract class Model
{
	public static $table;
	public static $columns;
	/**
	* Get the PDO database connection
	*
	* @return mixed
	*/
	protected static function getDB() {
		static $db = null;

		if ($db == null) {
			try {
				$dsn = 'mysql:host=' . Database::DB_HOST . ';dbname=' . Database::DB_NAME . ';charset=utf8';

				$db = new PDO($dsn, Database::DB_USER, Database::DB_PASSWORD);
				return $db;
			}catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
	}

	/**
	* Get all the posts as an associative array
	*
	* @return array
	*/
	public static function all() {
		try {
			$db = static::getDB();
			// Throw an exception when an error occures
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt = $db->query("SELECT * from " . static::$table);
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results;
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


	/**
	* Insert data in database
	*
	* @return array
	*/
	public static function create($columns) {
		try {
			$db = static::getDB();
			// Throw an exception when an error occures
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	        $stmt  = "INSERT INTO " . static::$table . " (";
	        $stmt .= join(", ", array_keys($columns));
	        $stmt .= ") values ('";
	        $stmt .= join("', '", array_values($columns));
	        $stmt .= "')";

			// use exec() because no results are returned
			$result = $db->exec($stmt);

			return $result;
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/**
	* update data from database
	*
	* @return array
	*/
	public static function update($columns, $id) {
		try {
			$db = static::getDB();
			// Throw an exception when an error occures
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$attributes = [];
	        foreach ($columns as $key => $value) {
	            $attributes[] = "{$key}='{$value}'";
	        }
	        $stmt  = "UPDATE " . static::$table . " SET ";
	        $stmt .= join(', ', $attributes);
	        $stmt .= " WHERE id='" . $id . "' ";
	        $stmt .= "LIMIT 1";

			// use exec() because no results are returned
			$result = $db->exec($stmt);

			return $result;
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/**
	* Remove data from database
	*
	* @return array
	*/
	public static function destroy() {
		try {
			$db = static::getDB();
			// Throw an exception when an error occures
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt = "DELETE FROM " . static::$table . " WHERE completed_at IS NOT NULL";

			// use exec() because no results are returned
			$result = $db->exec($stmt);

			return $result;
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/**
	* Select rows where column is not null
	*
	* @return array
	*/
	public static function whereIsNotNull($column) {
		try {
			$db = static::getDB();
			// Throw an exception when an error occures
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt = $db->query("SELECT * FROM " . static::$table . " WHERE " . $column . " IS NOT NULL");

			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $result;
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/**
	* Select rows where column is not null
	*
	* @return array
	*/
	public static function whereIsNull($column) {
		try {
			$db = static::getDB();
			// Throw an exception when an error occures
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt = $db->query("SELECT * FROM " . static::$table . " WHERE " . $column . " IS NULL");

			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $result;
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

}