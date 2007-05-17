<?php
include_once "data/Functions/ResDB.php";
include_once "data/Functions/Template.php";

$moduleTpl=new Template("My name is #{name} and i am #{age} years old!");


//echo $moduleTpl->evaluate(array("name"=>"Porfirio"));

include_once "Encryption.php";

$cr=new Encryption();

$original="this is a nice stuff :)";
$pass="porf";

$encrypted=$cr->encrypt($pass,$original);
$decrypted=$cr->decrypt("shit",$encrypted);

echo "Original: ".$original."<br>";
echo "Pass: ".$pass."<br>";
echo "Encrypted: ".$encrypted."<br>";
echo "Decrypted: ".$decrypted."<br>";

print_r($cr->errors);
?>

#|encrypted,gziped|#