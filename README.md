## OOP & VUEJS TODO APP

## Installation

Clone this repo [https://github.com/shahadat015/todo.git](https://github.com/shahadat015/todo.git). 

Run the Composer dump-autoload command from the Terminal:

    composer dump-autoload

The final steps for you are to add the database credentials. To do this open `config/Database.php` file.

And import todo.sql to your databse.

## Usage

Go to project directory using localhost/folder or virtual host e.g. todo.dev

## File structure
I have folllowed laravel folder structure but not 100%

```
todo
├── app
│   └── controllers
|   └── models
├── bootstrap - All of my core files as Route, View etc
├── config - All of my config files as Database, View etc
├── public - Publicly accessible files
├── resource - All of my templete and vue files
├── route - Web route file
└── storage - Application logs file
```
NB: I did not make any security (csrf) or validation task