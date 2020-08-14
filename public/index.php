<?php
require_once "../includes/dbcredentials.php";
require_once "../includes/header.php";
require_once "../includes/functions.php";
require_once "../includes/validation-functions.php";

session_start();



//Coming from signup page
if(isset($_POST["signupSumbit"])){
  $connection = connectDatabase();
  $uname = $_POST['username'];
  $pass = $_POST['password'];
  $requiredFields = ["username" , "password" ,"confirmPassword"];
  validatePresences($requiredFields);
  validateLength("username" , 5 , 30);
  validateUniqueness( $uname, "username" , "users");
  validatePass();
  if(!$errors){
    insertUser($uname , $pass);
    $_SESSION["message"] = "User created successfully";
    redirectTo("index.php");
  } else{
    $_SESSION["errors"] = $errors;
    redirectTo("index.php?mode=signup");
  }
}


//User have pressed submit on loginPage
if (isset($_POST["loginSubmit"])) {
  $connection = connectDatabase();
  $uname = $_POST['username'];
  $pass = $_POST['password'];
  $requiredFields = ["username" , "password"];
  validatePresences($requiredFields);
  if(!$errors){ //if the fields user entered are valid
    $passSet = selectPassword();
     if($passSet){//if there is no error from reading hashpassword from server
       if(password_verify($pass,mysqli_fetch_row($passSet)[0])){//if the password matches
         $_SESSION["verified"] = true;
         $_SESSION["username"] = $uname;

         redirectTo ("home.php");
       }else {//if password does not match
         $errors["authenerr"] = "Password or username is not correct!";
         $_SESSION["errors"] = $errors;
         redirectTo("index.php");
       }
     }
  } else{//if the fields user entered are not valid
    $_SESSION["errors"] = $errors;
    redirectTo("index.php");
  }
}


if (!$_GET && !$_POST){   //User entered the url directly or ...
  echo loginPage();       //coming with on get or post data
  if(isset($_SESSION["message"])){
    echo $_SESSION["message"];
    $_SESSION["message"] = null;
  }

  if(isset($_SESSION["errors"])){
    echo formErrors($_SESSION["errors"]);
    $_SESSION["errors"] = null;
  }

} else if(isset($_GET["mode"]) && !$_POST) {//User clicked signup link
    if($_GET["mode"] === "signup"){
      echo signupPage();
      if(isset($_SESSION["errors"])){
        echo formErrors($_SESSION["errors"]);
        $_SESSION["errors"] = null;
      }
    }

} else if( $_GET["logout"] === "1" ){//User coming from pressing logout link
  echo loginPage();
  $_SESSION["verified"] = null;
}


if(isset($connection)){
    mysqli_close($connection);
}
include "../includes/footer.php" ;
 ?>
