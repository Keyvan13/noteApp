<?php
require_once "../includes/functions.php";
require_once "../includes/loginAccess.php";
include_once "../includes/header.php";
require_once "../includes/dbcredentials.php";
session_start();
$connection = connectDatabase();

if (isset($_SESSION["message"])) {
  echo $_SESSION["message"];
  $_SESSION["message"] = null;
}

?>



<form class="w3-container " action="home.php<?php //echo "{$_GET["id"]}"; ?>" method="post" id="note">
  <textarea rows="10" class="w3-margin-top w3-container w3-card w3-light-blue" style="width:100%; resize:none;" name="noteText" form="note"></textarea>
  <input class="w3-button  w3-section w3-aqua w3-ripple" type="submit" name="saveChanges" value="Save Changes" form="note"/>
</form>





<?php
if(isset($connection)){
    mysqli_close($connection);
}

echo "\n<a class=\"w3-button w3-ripple w3-margin-left\" href = \"home.php\">Homepage</a>\n";
include_once "../includes/footer.php";





?>
