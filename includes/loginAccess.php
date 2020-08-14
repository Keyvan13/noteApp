<?php
if (isset($_SESSION)){
  if($_SESSION["verified"] !== true){
    redirectTo("index.php");
  }
}



?>
