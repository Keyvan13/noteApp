<?php
require_once "../includes/functions.php";
require_once "../includes/loginAccess.php";
include_once "../includes/header.php";
require_once "../includes/dbcredentials.php";
session_start();
$connection = connectDatabase();


$uName = $_SESSION["username"];
echo " <header class=\"w3-container w3-black\"><h1>Hi ". htmlentities($uName) . "</h1></header>\n
      <style>
        li{
          list-style-type: none;
        }
      </style>";


if($_POST && $_POST["noteText"] !==""){
  insertNote($uName , $_POST["noteText"]);
} else if($_POST && $_POST["noteText"] ===""){
  $_SESSION["message"] = "note can not be blank";
  redirectTo("new.php");
}

$noteSet = getNoteSet($uName);


if($noteSet->num_rows === 0){
  echo "<p>You have no notes</p>\n";
} else {
  echo "<nav class=\"w3-container\" >\n\t<ul>\n";

  while($row = mysqli_fetch_row($noteSet)){
    $row[0] = htmlentities($row[0]);
    $row[1] = htmlentities($row[1]);
    echo "\t\t<li class=\"w3-margin-top w3-container w3-card-2 w3-hover-shadow w3-half\"><a href =\"editNote.php?id={$row[1]}\" >{$row[0]}</a> </li> \n";
  }
  echo "\t</ul>\n</nav>";
}





if(isset($connection)){
    mysqli_close($connection);
}
echo "\n<div class=\"w3-container\"> <a class=\"w3-button  w3-section w3-teal w3-ripple\" href=\"new.php?name=". htmlentities($uName) . "\">+ New Note </a> ";
echo "<a class=\"w3-button  w3-section w3-red w3-ripple\" href = \"index.php?logout=1\">Log out</a></div>";
include_once "../includes/footer.php";
 ?>
