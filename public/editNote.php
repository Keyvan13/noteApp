<?php
require_once "../includes/functions.php";
require_once "../includes/loginAccess.php";
include_once "../includes/header.php";
require_once "../includes/dbcredentials.php";
session_start();
$connection = connectDatabase();

$uName = $_SESSION["username"];
if(!verifiyNoteAccess($_GET["id"] , $uName)){
  redirectTo("home.php");
}



if(isset($_POST["saveChanges"])){
  $text =$_POST["noteText"];
  updateNote($_GET["id"] , $text);
}


if(isset($_POST["delete"])){
  deleteNote($_GET["id"] , $text);
  redirectTo("home.php");
}

$bodySet = getNoteById($_GET["id"]);
$body = mysqli_fetch_row($bodySet);

?>


<form class="w3-container " action="editNote.php?id=<?php echo "{$_GET["id"]}"; ?>" method="post" id="note" style="resize: none;">
  <textarea rows="10" class="w3-margin-top w3-container w3-card w3-light-blue" style="width:100%; resize:none;" name="noteText" form="note"><?php echo "{$body[0]}";?></textarea>
  <input class="w3-button  w3-section w3-aqua w3-ripple" type="submit" name="saveChanges" value="Save Changes" form="note"/>
  <input class="w3-button  w3-section w3-deep-orange w3-ripple" type="submit" name="delete" value="Delete Note" form="note"/>
</form>







<?php
if(isset($connection)){
    mysqli_close($connection);
}

echo "\n<a class=\"w3-button w3-ripple w3-margin-left\" href = \"home.php\">Homepage</a>\n";
include_once "../includes/footer.php";


?>
