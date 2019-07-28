<?php
include "db.php";  //include the connection

// extend so that it can can use con variable for connections
class dataOperaion extends Database {

  // create a function insert that takes two arguments as parameters
  public function insert($table, $fields){
    // INSERT INTO <table-name>(, ,) VALUES ('medicine', 'quantity')";
    $query = "";
    $query .= "INSERT INTO " .$table;

    //
    $query .= "(".implode(", ", array_keys($fields)).") VALUES ";

    // used to get an array of values from another array that may contain key-value pairs or just values
    $query .= "('".implode("', '", array_values($fields))."')";
    //echo $query;
    $result = mysqli_query($this -> con, $query);
    if($result){
      return true;
    }
  }

  // now function for fetching data from Database
  public function fetch($table){
    $query = "SELECT * FROM ".$table;
    $array = array();
    $result = mysqli_query($this->con, $query);
    while($row = mysqli_fetch_assoc($result)){
    $array[] = $row;
    }
    return $array;
  }

// code for selecting data using id
public function select($table, $where){
  $query = "";
  $candition = "";
  foreach ($where as $key => $value) {
    // id = '5' and medicine_name = "kuffdryl"
    $candition .= $key . "='" .$value ."' AND ";
  }
   $candition = substr($candition, 0 , -5);
   $query .= "SELECT * FROM ".$table. " WHERE " .$candition;
   $result = mysqli_query($this->con, $query);
   $row = mysqli_fetch_array($result);
   return $row;
}

// code of update function goes here...
  public function update($table, $where, $fields){
    $query = "";
    $candition = "";
    foreach ($where as $key => $value) {
      // id = '5' and medicine_name = "kuffdryl"
      $candition .= $key . "='" .$value ."' AND ";
    }
    $candition = substr($candition, 0 , -5);
    foreach ($fields as $key => $value) {
      // update table set medicine_name = '', quantity = '' where id = '';
      $query .= $key . "='".$value."', ";
    }
    $query = substr($query, 0 , -2);
    $query ="UPDATE ".$table." SET ".$query." WHERE ".$candition;
    if(mysqli_query($this->con, $query)){
      return true;
    }
  }

  // code for deletion
  public function delete($table, $where){
    $query = "";
    $candition = "";
    foreach ($where as $key => $value) {
    $candition .= $key . "='" .$value ."' AND ";
    }
    $candition = substr($candition, 0 , -5);
    $query ="DELETE FROM ".$table." WHERE ".$candition;
    if (mysqli_query($this->con, $query)) {
      return true;
    }
  }


}

 $obj = new dataOperaion;

 if(isset($_POST['submit'])){
   $myArray = array(
     "medicine_name" => strip_tags(trim($_POST['name'])),
     "quantity" => strip_tags(trim($_POST['quantity']))
   );

   if($obj -> insert("medicines", $myArray)){
     header("location:index.php?message=Record Saved!");
   }
 }
 //code for update goes here jus calling the update function
 if(isset($_POST['update'])){
   $id = $_POST["id"];
   $where = array("id"=>$id);
   $myArray = array(
     "medicine_name" => strip_tags(trim($_POST['name'])),
     "quantity" => strip_tags(trim($_POST['quantity']))
   );
   if ($obj->update("medicines",$where, $myArray)) {
     header("location:index.php?msg=Updated");
   }
  }

  //code for Delete goes here jus calling the delete function
  if(isset($_GET['delete'])){
    if(isset($_GET["id"])){  // check if the id id attached with url or not
      $id = $_GET["id"];
      $where = array("id"=>$id);
      if ($obj->delete("medicines",$where)) {
        header("location:index.php?msg=Deleted");
      }
    }
   }
 ?>
