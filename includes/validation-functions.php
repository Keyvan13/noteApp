<?php
$errors = array();
function validateUniqueness($value ,$field , $table){
  global $errors;
  if(!$errors){
    global $connection;
    $query = "select {$field} from {$table}";
    $result = mysqli_query($connection , $query);
    while ($row = mysqli_fetch_row($result)) {
      if($row[0] === $value ){
        $errors[$field] = "{$field} already exists";
      }
    }
    mysqli_free_result($result);
  }
}

function hasPresence($value){
  return isset($value) && $value !== "";
}

function validatePresences($requiredFields){
  global $errors;

  foreach($requiredFields as $field){
    $value = trim($_POST[$field]);
    if(!hasPresence($value)){
      $errors[$field] = "{$field} can't be blank";
    }
  }
}

function validateLength($field , $min , $max){
  global $errors;
  if(!$errors){
    $value = $_POST[$field];
    if (!(strlen($value) >= $min && strlen($value) <= $max)){
      $errors[$field] = "{$field} must be between {$min} and {$max}";
    }
  }
}

function validatePass(){
  global $errors;
  $pass = $_POST["password"];
  $cpass = $_POST["confirmPassword"];
  if(!$errors){

    if(strlen($pass) <
     8){ $errors["password"] = "password must be at least 8 charcacters"; }
    if($pass !== $cpass){$errors["cpassword"] = "password does not match"; }


  }
}


?>
