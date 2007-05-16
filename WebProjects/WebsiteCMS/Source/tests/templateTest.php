<?php
include_once "../data/Functions/ADB.php";
include_once "../data/Functions/Template.php";

$tpl=new Template("My name is #{name} and i am #{age} years old!");
?>
$tpl=new Template("My name is #{name} and i am #{age} years old!");<br>
echo $tpl->evaluate(array("name"=>"porfirio","age"=>26));<br>

<?php
echo $tpl->evaluate(array("name"=>"porfirio","age"=>26))."<br>";

?>
$map=new ArrayMap();<br>
$map->put("name","Porfirio");<br>
$map->put("age",26);<br>
$adrs=$map->addMap("adress");<br>
$adrs->put("country","Portugal");<br>
$adrs->put("town","Alcobaça");<br>
echo $tpl->evaluate($map);<br><br>
<?php
$map=new ArrayMap();
$map->put("name","Porfirio");
$map->put("age",26);
$adrs=$map->addMap("adress");
$adrs->put("country","Portugal");
$adrs->put("town","Alcobaça");

echo $tpl->evaluate($map)."<br>";
?>
$tpl2=new Template("My name is #{name} and i am #{age} years old! My town is #{adress.town} and my country is #{adress.country}");<br>
echo $tpl2->evaluate($map);<br><br>
<?php
$tpl2=new Template("My name is #{name} and i am #{age} years old! My town is #{adress.town} and my country is #{adress.country}");
echo $tpl2->evaluate($map);


?>