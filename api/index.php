<?php
require 'vendor/autoload.php';
require 'database/ConnectionFactory.php';
require 'tasks/TaskService.php';

$app = new \Slim\Slim();

// http://hostname/api/
$app->get('/', function() use ( $app ) {
    echo "Welcome to Task REST API";
});

/*
HTTP GET http://domain/api/tasks
RESPONSE 200 OK
[
  {
    "id": 1,
    "description": "Learn REST",
    "done": false
  },
  {
    "id": 2,
    "description": "Learn JavaScript",
    "done": false
  },
  {
    "id": 3,
    "description": "Learn English",
    "done": false
  }
]
*/
$app->get('/tasks', function() use ( $app ) {
    $tasks = TaskService::listTasks();
    //Define what kind is this response
    $app->response()->header('Content-Type','application/json');
    echo json_encode($tasks);
});

/*
HTTP GET http://domain/api/tasks/1
RESPONSE 200 OK
{
  "id": 1,
  "description": "Learn REST",
  "done": false
}

RESPONSE 204 NO CONTENT
*/
$app->get('/tasks/:id', function($id) use ( $app ) {
    $tasks = getTasks();
    $index = array_search($id, array_column($tasks, 'id'));
    
    if($index > -1) {
        $app->response()->header('Content-Type', 'application/json');
        echo json_encode($tasks[$index]);
    }
    else {
        $app->response()->setStatus(204);
    }
});

/*
HTTP POST http://domain/api/tasks
REQUEST Body
{
  "description": "Learn REST",
}

RESPONSE 200 OK Body
Learn REST added
*/
$app->post('/tasks', function() use ( $app ) {
    $taskJson = $app->request()->getBody();
    $task = json_decode($taskJson);
    if($task) {
        echo "{$task->description} added";
    }
    else {
        $app->response()->setStatus(400);
        echo "Malformat JSON";
    }
});

/*
HTTP PUT http://domain/api/tasks/1
REQUEST Body
{
  "id": 1,
  "description": "Learn REST",
  "done": false
}
RESPONSE 200 OK
{
  "id": 1,
  "description": "Learn REST",
  "done": false
}
*/
$app->put('/tasks/:id', function($id) use ( $app ) {
    echo $app->request()->getBody();
});

/*
HTTP DELETE http://domain/api/tasks/1
RESPONSE 200 OK
Task deleted
*/
$app->delete('/tasks/:id', function($id) use ( $app ) {
    echo $id;
});

$app->run();
?>