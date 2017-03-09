<?php include('checkme.php'); ?>
<!DOCTYPE html><head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <head> 
  <title>Twitter Search | MedicYatra</title> 
  </head>
<body>
<a href="fbsearch.php">Facebook Search</a> | <a href="google.php">Google Search</a> | <a href="index.php">Twitter Search</a> | <b><a href="logout.php">[ LOGOUT ]</a></b><br/><br/>
<form action="" method="GET"><label> Search Term </label> <input type="text" name="q"><br/><input type="submit" value="search" name="submit"></form><hr>
<?php
include('connect.php');
if(isset($_POST['add']))
 {
  $c=$_POST['c'];
  $p=$_POST['p'];
  $l=$_POST['l'];
  $query=mysql_query("INSERT INTO lead(content,p_link,link) VALUES('$c','$p','$l')");
  if($query)
    echo 'Data successfully added<hr>';
    else
    echo 'Error! data not added<hr>';
}
if(isset($_GET['submit']))
 {
  require_once("twitter.class.php");
  $page=isset($_GET['page'])?$_GET['page']:1;
  $nextpage=$page+1;
  if($page!=1)
   $prevpage=$page-1;
  $Twitter = new Twitter;
  $search=$_GET['q'];
  $results = $Twitter->SearchResults($search,$page);
  $i=0;
  foreach( $results->entry as $result ) {
	$i++;
	echo "<h3><a href=\"".$result->author->uri ."\">".$result->author->name."<a/></h3>";
	echo "<p>".$result->content."</p>";
	$qw=mysql_query("SELECT * FROM lead WHERE content='$result->content'");
	if($qw)
	  $q=mysql_fetch_array($qw);
        if(!($q['id']))
		echo '<form action="" method="post"><textarea style="visibility:hidden; display:none;" name="l">'.$result->link[0]->attributes()->href.'</textarea><textarea style="visibility:hidden; display:none;" name="p">'.$result->author->uri.'</textarea><textarea style="visibility:hidden; display:none;" name="c">'.$result->content.'</textarea><input type="submit" value="Add To Database" name="add"></form><hr>';
    	else
 		echo '<br/><b>[ Added in Database ]</b><hr>';
}
if($page!=1)
echo '<br/><br/><a href="?q='.$_GET['q'].'&submit='.$_GET['submit'].'&page='.$prevpage.'">Prev</a> &nbsp;|&nbsp; ';
if($page*10<1500)
echo '<a href="?q='.$_GET['q'].'&submit='.$_GET['submit'].'&page='.$nextpage.'">Next</a>';

  }
?>
</body>
</html>
