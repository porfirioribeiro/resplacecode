<?php
ob_start("ob_gzhandler");
//ResDB performance test 01
//set the content first
$content1="blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah ";
$content2="blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah ";
$content3="blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah ";

//how many times do you want to add to the DB?
$repeats=2000;
$repeat=0;

//Inlclude the DB system...
$timer_begin_include=microtime(true);
include_once "../data/Functions/ResDB.php";
$timer_end_include=microtime(true);

//add data to the DB...
$timer_adddata_begin=microtime(true);
$db=new ResDB("test.db");

do
{
$m1=$db->addMap($repeat);
$m1->put("content1",$content1);
$m1->put("content2",$content2);
$m1->put("content3",$content3);
$repeat+=1;
} while ($repeat<$repeats);
$timer_adddata_end=microtime(true);

//close the db
$timer_closedb_begin=microtime(true);
$db->close();
$timer_closedb_end=microtime(true);

//wipe db
unset($db);

//reconnect
$timer_read_begin=microtime(true);
$db=new ResDB("test.db");

//read the DB
for ($i=1;$i<=count($db);$i++){
	$val=$db[1];
	echo'map: '.$i.'<br>';
	echo'--key1: ';
	echo $val->get("content1");
	echo '<br>';
	echo'--key2: ';
	echo $val->get("content2");
	echo '<br>';
	echo'--key3: ';
	echo $val->get("content3");
}
$timer_read_end=microtime(true);

//close the db (again)
$timer_closedba_begin=microtime(true);
$db->close();
$timer_closedba_end=microtime(true);

?>
<p><b>Performance tests for ResDB</b><br>
  <i>Lets hope its good news folkes</i>!<br>
  <br>

<fieldset>
			<legend>Write the DB...</legend>
Time to include the ResDB module:<br>
<?=$timer_end_include-$timer_begin_include; ?> 
secs.<br>
<br>

Time to create all the DB data:<br>
<?=$timer_adddata_end-$timer_adddata_begin; ?> 
secs.<br>
<br>

Time to close the DB:<br>
<?=$timer_closedb_end-$timer_closedb_begin; ?> 
secs.<br>
<br>
Overall time to write a DB:<br>
<?=$timer_closedb_end-$timer_begin_include; ?> 
secs.<br>
</fieldset>
<br>
<fieldset>
			<legend>Read DB...</legend>
Time to read the DB: <br>
<?=$timer_read_end-$timer_read_begin; ?> 
secs.<br>
<br>
Time to close the DB: <br>
<?=$timer_closedba_end-$timer_closedba_begin; ?> 
secs.<br>
<br>
Overall time to read a DB:<br>
<?=$timer_closedba_end-$timer_read_begin; ?> 
secs.<br>
</fieldset>
