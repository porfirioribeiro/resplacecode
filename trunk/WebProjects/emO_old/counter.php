<?
$username="root";
$password="porfirio";
$database="emonline";
mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$c=mysql_query("SELECT * FROM counter");
$c=mysql_result($c,0,"test");
eval(chr(36)."a=".$c);
print_r($a);
//$result=mysql_query("UPDATE counter SET test=$c");

?>
