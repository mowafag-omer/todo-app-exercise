<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once './config/DB.php';
  include_once './models/Task.php';

  $database = new Database();
  $db = $database->connect();

  $task = new Task($db);

  $data = json_decode(file_get_contents("php://input"));

  $task->newTask = $data->task;
  
  if($task->create()) {
    echo json_encode(array('message' => 'task Created'));
  } else {
    echo json_encode(array('message' => 'task Not Created'));
  }  