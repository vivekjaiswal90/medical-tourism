<?php include('checkme.php'); ?>
<!DOCTYPE html><head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <head> 
  <title>Facebook Search | MedicYatra</title> 
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
if(isset($_GET['submit']) || isset($_GET['url']))
 {
  if(isset($_GET['submit']))
  {
  $q=urlencode($_GET['q']);
  $query="https://graph.facebook.com/search?q=".$q."&type=post";
  }
  if(isset($_GET['url']))
    $query="https://graph.facebook.com/".$_GET['url'];    
  $file=file_get_contents($query);
  $obj = json_decode($file);
  $data=$obj->{'data'};
  for($i=0;$i<count($data);$i++) {
   $result=$data[$i]->{'message'};
   $pid=$data[$i]->{'id'};
   $post_id=explode('_',$pid);
   $name=$data[$i]->{'from'}->{'name'};
   $id=$data[$i]->{'from'}->{'id'};
   $created=$data[$i]->{'created_time'};
   echo '<a href="http://facebook.com/profile.php?id='.$id.'">'.$name.'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.facebook.com/permalink.php?story_fbid='.$post_id[1].'&id='.$id.'">View On Facebook</a><br/><b>Status : </b>'.$result.'<br/><b>Created On:</b> '.$created;
   $result=str_replace("'","",$result);
   $result=str_replace("'","",$result);
   $qw=mysql_query("SELECT * FROM lead WHERE content='$result'");
	if($qw)
	  $q=mysql_fetch_array($qw);
        if(!($q['id']))
		echo '<form action="" method="post"><textarea style="visibility:hidden; display:none;" name="l">http://www.facebook.com/permalink.php?story_fbid='.$post_id[1].'&id='.$id.'</textarea><textarea style="visibility:hidden; display:none;" name="p">http://facebook.com/profile.php?id='.$id.'</textarea><textarea style="visibility:hidden; display:none;" name="c">'.$result.'</textarea><input type="submit" value="Add To Database" name="add"></form><hr>';
    	else
 		echo '<br/><b>[ Added in Database ]</b><hr>';
  }
 $prev=$obj->{'paging'}->{'previous'};
 $next=$obj->{'paging'}->{'next'};
 $prev=str_replace("https://graph.facebook.com/","",$prev);
 $next=str_replace("https://graph.facebook.com/","",$next);
 echo '<a href="?url='.urlencode($prev).'">Previous</a> | <a href="?url='.urlencode($next).'">Next</a>';
}
?>
</body>
</html>
