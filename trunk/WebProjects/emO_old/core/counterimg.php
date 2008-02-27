<?

  $username="tpvgames_co_uk";
  $password="playing";
  $database="tpvgames_co_uk";
  mysql_connect(localhost,$username,$password);
  @mysql_select_db($database) or die( "Unable to select database");
  $tmp=mysql_query("SELECT * FROM counter");
  $s=mysql_result($tmp,0,"count");
  if (!$count==1)
  {
  mysql_query("UPDATE counter SET count=".($s+1));
  }
  $tmp=mysql_query("SELECT * FROM counter");
  $aaa=mysql_result($tmp,0,"count");
  mysql_close();

echo '<img alt="Counter" style="vertical-align:middle;" src="core/digits/count.php?c='.$aaa.'"  onMouseOver="setMsg(this,22)">';
?>

