<?php
  class Database {
    public $con;
    public function __construct(){
      $this -> con = mysqli_connect("localhost", "root", "", "medical");
      // if($this -> con){
      //   echo "Connected!";
      // }else{
      //   echo "Error In Connection!";
      // }
    }
  }

 ?>
