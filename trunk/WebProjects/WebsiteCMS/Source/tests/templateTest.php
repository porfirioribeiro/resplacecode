<?php
include_once "../data/Functions/ResDB.php";
include_once "Template.php";

$data=array(
	array("name"=>"Porfirio","age"=>"26"),
	array("name"=>"Dean","age"=>"19")
);

$tpl=new Template("
	#{start:cell}
		<td>#{content}</td>
	#{end:cell}
	#{start:row}
		<tr>#{name}#{age}</tr>
	#{end:row}
	#{start:table}
		<table border='1'>
				<tr>
					<td>Name:</td><td>Age:</td>
				</tr>
				#{rows}
		</table>
	#{end:table}
	");

$celltpl=$tpl->get("cell");
$rowtpl=$tpl->get("row");
$tabletpl=$tpl->get("table");

$rows="";
foreach ($data as $dt){
	$rows.=$rowtpl->parse(array("name"=>$celltpl->parse(array("content"=>$dt["name"])),"age"=>$celltpl->parse(array("content"=>$dt["age"]))));
}

echo $tabletpl->parse(array("rows"=>$rows));
?>