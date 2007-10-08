<?php 
include_once "../OpenWebMS/WebMS.php";
$db=new ResDB("Menu");
$m1=$db->addMap("1");
$m1->put("name","Home");
$m1->put("url","http://resplace.net/");
$m1->put("icon","http://porf.no-ip.org/owms/OpenWebMS/Core/Images/link/home.png");
$m2=$db->addMap("2");
$m2->put("name","Blog");
$m2->put("url","http://blog.resplace.net/");
$m3=$db->addMap("3");
	$m3->put("name","Projects");
	$pm1=$m3->addMap("1");
		$pm1->put("name","Home");
		$pm1->put("url","http://projects.resplace.net/");
		$pm1->put("icon","http://porf.no-ip.org/owms/OpenWebMS/Core/Images/link/home.png");
	$wpm1=$m3->addMap("2");
	$wpm1->put("name","Web Projects");
	$wpm12=$wpm1->addMap("1");
	$wpm12->put("name","WebsiteCMS");
	$wpm12->put("url","http://projects.resplace/cms/");
$db->close();
print_r($db);


function expandMenu($mnu){
	for ($i=1;$i<=count($mnu);$i++){
		$val=$mnu[$i];
		if (ArrayMap::is($val)){
			if ($val->isMap("1")){
				$id=preg_replace(array("/-/","/ /"),"_",$val->get("name"));
				?>
				<a style="display:block;" href="javascript:;" onclick="$('<?=$id?>').toggle();"><?=$val->get("name")?></a>
				<div $id="<?=$id?>" style="padding-left:10px">
				<?php
					expandMenu($val);
				?>
				</div>
				<?php				
			}else{
				$name=$val->get("name");
				$url =$val->get("url"); 			
				?>
				<a style="display:block;" href="<?=$val->get("url")?>"><?=$val->get("name")?></a>
				<?php	
			}
			//if ()
			//expandMenu($val->getArray());
		}
	}
}


?>

<div>
	<!--?=expandMenu($db)?-->
</div>


<?php
$db->close();
?>