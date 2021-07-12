<?php
  class Task {
    // database props
    private $conn;

    public $id;
    public $newTask;
    public $done;

    public function __construct($db) {
      $this->conn = $db;
    }
    
    // get tasks
    public function read() {
      $query = "SELECT * FROM tasks";

      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt;    
    }

    // add new task
    public function create() {
      $query = "INSERT INTO tasks SET task = :task";
      
      $stmt = $this->conn->prepare($query);
      
      // Clean data
      $this->newTask = htmlspecialchars(strip_tags($this->newTask));

      // Bind data
      $stmt->bindParam(':task', $this->newTask);
      

      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function toggle() {
      $query = "UPDATE tasks SET is_done = :done WHERE id = :id";
      
      $stmt = $this->conn->prepare($query);
      
      // Clean data
      $this->done = htmlspecialchars(strip_tags($this->done));

      // Bind data
      $stmt->bindParam(':done', $this->done);
      $stmt->bindParam(':id', $this->id);
      

      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
  }