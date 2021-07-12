<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once './config/DB.php';
  include_once './models/Task.php';

  //connect db
  $database = new Database();
  $db = $database->connect();

  $task = new Task($db);
  
  // get raw posted data
  $data = json_decode(file_get_contents("php://input"));
  
  $task->id = isset($_GET['id']) ? $_GET['id'] : die();
  $task->done = $data->done;
  
  // Create task
  if($task->toggle()) {
    echo json_encode(array('message' => 'task updated'));
  } else {
    echo json_encode(array('message' => 'task Not updated'));
  }  