<?php include('checkme.php'); ?>
<!DOCTYPE html><head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <head> 
  <title>Google Search | MedicYatra</title> 
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
    echo '<b>Data successfully added</b><hr>';
  else
    echo '<b>Error! data not added</b><hr>';
}
if(isset($_GET['submit']) || isset($_GET['start']))
 {
  if(isset($_GET['start']))
    $start=$_GET['start'];
  else
    $start=1;
  if(isset($_GET['submit']))
  {
  $q=urlencode($_GET['q']);
  $query="https://www.googleapis.com/customsearch/v1?key=AIzaSyCYOG6auVqaWRG7Er6BjkWpB9XkMDUAge4&cx=009874814392991826856:ke1bke9urzc&q=".$q."&start=".$start;
  }
  $file=file_get_contents($query);
  $obj = json_decode($file);
  $data=$obj->{'items'};
  for($i=0;$i<count($data);$i++) {
   $result=$data[$i]->{'snippet'};
   $title=$data[$i]->{'title'};
   $link=$data[$i]->{'link'};
   $dlink=$data[$i]->{'displayLink'};
   echo '<a href="'.$link.'">'.$title.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<br/>'.$result.'<br/><b>site:</b> '.$dlink;
   $result=str_replace("'","",$result);
   $result=str_replace("'","",$result);
   $qw=mysql_query("SELECT * FROM lead WHERE content='$result'");
	if($qw)
	  $q=mysql_fetch_array($qw);
        if(!($q['id']))
		echo '<form action="" method="post"><textarea style="visibility:hidden; display:none;" name="l">'.$link.'</textarea><textarea style="visibility:hidden; display:none;" name="p"></textarea><textarea style="visibility:hidden; display:none;" name="c">'.$result.'</textarea><input type="submit" value="Add To Database" name="add"></form><hr>';
    	else
 		echo '<br/><b>[ Added in Database ]</b><hr>';
  }
  $nextstart=$start+10;
  if($start!=1)
    $prevpage=$start-10;
  $tot=$obj->{'queries'}->{'nextPage'};
  echo '<b>Total results : </b>'.$tot[0]->{'totalResults'}.'<br/>';
  if(isset($prevpage))
    echo '<a href="?q='.$_GET['q'].'&submit=search&start='.$prevpage.'">Prev</a> | ';
  echo '<a href="?q='.$_GET['q'].'&submit=search&start='.$nextstart.'">Next</a>';
 }
?>
</body>
</html>
