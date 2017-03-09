<?php 
if(isset($_POST['submit']))
 {
  if(md5($_POST['pass'])==md5("medicyatra94307"))
   {
   $hour = time() +(3600*1); 
   setcookie("medicyatra_pwd", md5($_POST['pass']), $hour);
   header("location:index.php");
   }
   else
      header("location:login.php?er=1");
 }
elseif($_COOKIE['medicyatra_pwd']!=md5("medicyatra94307"))
{
 header("location:login.php?er=2");
}
?>