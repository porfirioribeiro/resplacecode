<?php

$path="AutoSys/";

$page=new WebMS($path,"Sobre AutoSys, sistema de construção de sites para venda de carros!");
$page->addMeta(array('name' => 'keywords','content' => 'FFAuto,carros,usados'));

$page->addModule("Menu");

function AutoSys(){
	global $WebMS;
?>
<p style="text-align: center;font-size: x-large;">
<strong>
AutoSys</strong></p>
<img alt="AutoSys" longdesc="Carro" src="<?=$WebMS["ImagesUrl"]?>car.png" width="144" height="144" style="float:left" />
Este website foi desenvolvido por Porfirio Ribeiro.<br />
<br />
Este site é construido em PHP e usa MySQL como base de dados
<br />
<br />
<br />
<br />
Esta pagina ainda não ta acabada
<br />
<br />
(C) 2007

<?php
}

$page->addModule(AutoSys,"AutoSys, Sistema de venda de carros");

$page->create();
?>
