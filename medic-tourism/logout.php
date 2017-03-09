<?php

 $past = time() - 100; 
  setcookie("medicyatra_pwd", "gone", $past);
header("location:login.php?changed");
?>