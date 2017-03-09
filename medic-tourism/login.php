<center>
<?php
if($_GET['er']==1)
 echo '<font color="red"><b> Incorrect Password </b></font>';
if($_GET['er']==2)
 echo '<font color="red"><b> Not Logged In, Log-In Now ! </b></font>';
if(isset($_GET['changed']))
 echo '<font color="red"><b> Successfully logged out ! </b></font>';
?>
<form action="checkme.php" method="post">
<label>Password : </label><input type="password" name="pass"><br/>
<input type="submit" name="submit" value="Log In">
</form>
</center>