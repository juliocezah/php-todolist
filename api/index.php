<?php 
require 'vendor/autoload.php';

$app = new \Slim\Slim();

//http://hostname/api/
//get all tasks
$app->get('/', function() use ($app){
    echo "Welcome to REST API";
});

/*
HTTP GET http://url(...)/api/tasks
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
    "done": true
  },
  {
    "id": 3,
    "description": "Learn English",
    "done": false
  }
]
*/
$app->get('/tasks', function() use ($app){
    $tasks = getTasks();
    //Define what kind is this response / Define qual é o tipo de resposta
    $app->response()->header('Content-Type', 'application/json'); //$app é um objeto do framework Slim | Resposta é um Json
    echo json_encode($tasks);
});

/*
HTTP GET http://url(...)/api/tasks/1
RESPONSE 200 OK
{
    "id": 1,
    "description": "Learn REST",
    "done": false
}

RESPONSE 204 NO CONTENT
*/
$app->get('/tasks/:id', function($id) use ( $app ){
   $tasks = getTasks();
   $index = array_search($id, array_column($tasks, 'id'));
   
   if($index > -1) { //sem o -1 não funciona para o ID 1...
     $app->response()->header('Content-Type', 'application/json');
     echo json_encode($tasks[$index]);
   }
   else{
       $app->response()->setStatus(204); //antes estava 404. o 204 não aparece a msg
       echo "Not found";
   }
});

/*
HTTP POST http://url(...)/api/tasks
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
    //print_r($task);
    
    if($task){
        echo "{$task->description} added";
    }
    
    else{
        $app->response()->setStatus(400);
        echo "Malformat JSON";
    }
});

//TODO move it to a DAO class
function getTasks(){
     $tasks = array(
        array('id' => 1, 'description' => 'Learn REST', 'done' => false), //posição 0 do vetor tasks []
        array('id' => 2, 'description' => 'Learn JavaScript', 'done' => true), //posição 1 do vetor tasks []
        array('id' => 3, 'description' => 'Learn English', 'done' => false), 
    );
    
    return $tasks;
}
$app->run();
?>