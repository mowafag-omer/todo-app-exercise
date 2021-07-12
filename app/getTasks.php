<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once './config/DB.php';
  include_once './models/Task.php';

  //connect db
  $database = new Database();
  $db = $database->connect();

  $tasks = new Task($db);

  $result = $tasks->read();

  if($result->rowCount() > 0) {
    $tasks_arr = array();
    
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      array_push($tasks_arr, $row);
    }
    
    // row ex:
    // {
    //   id : 1,
    //   task: "task name",
    //   id_done : 0
    // }

    echo json_encode($tasks_arr);
    
  } else {
     echo json_encode(
      array('message' => 'No Tasks Found')
    );
  }