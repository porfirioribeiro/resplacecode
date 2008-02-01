<?php
/**
* Page Rate module
* This module allows a visitor to rate a page
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright (c) 2007 ResPlace Team
* @lastedit 24-10-07
*
*@notes Need to gather IP address to stop multiple rating.
*/

if (isset($_GET["RatePage"]) && isset($_GET["page"]) && isset($_GET["path"])){
	include_once '../../config.php';
	$db=new ResDB("PageRater");
	$page=$db->getMap($_GET["page"]);
	$bar=$db->get("pageratebarbac");
	if ($bar=="") {
		$bar="Star/Blue.png";
	}
	$bac=$db->get("pageratebar");
	if ($bac=="") {
		$bac="Star/Grey.png";
	}
	$ips=explode(",",$page->get("ip",""));
	$nope=0;
	foreach ($ips as $ipc){
		if ($ipc==$_SERVER['REMOTE_ADDR']){
		$nope=1;
		break;
		}
	}
	if ($nope==0){
		$votes=$page->get("votes","0")+1;
		$rank=$page->get("rank","0")+$_GET["RatePage"];
		$ip=$page->get("ip","").','.$_SERVER['REMOTE_ADDR'];
		$page->put("votes",$votes);
		$page->put("rank" ,$rank);
		$page->put("ip" ,$ip);
		$rv=round($rank/$votes,2);
		echo $votes."-".$rank."-".$rv."- You rated this page ".$_GET["RatePage"]."/5<br>";
	}else{
		$votes=$page->get("votes","0");
		$rank=$page->get("rank","0");
		$rv=round($rank/$votes,2);
		echo $votes."-".$rank."-".$rv."-<br><b>You already rated this page.</b>";
	}
	$db->close();
	
}else{
	class PageRate extends Module {
		var $url;
		var $base;
		function PageRate($page){
			global $WebMS;
			$this->page=$page;
			$this->side=Module::LEFT;
			$this->title="Rate this Page";	
			$this->db=new ResDB("PageRater");
			$this->bar=$this->db->get("pageratebarbac");
			if ($this->bar=="") {
				$this->bar="Star/Blue.png";
			}
			$this->bac=$this->db->get("pageratebar");
			if ($this->bac=="") {
				$this->bac="Star/Grey.png";
			}
			$this->bac2=explode("/",$this->bac);
			$this->pg=$this->db->getMap($this->page->id);
			$this->url=str_replace($_SERVER["DOCUMENT_ROOT"],"", preg_replace("/\\\/","/",__FILE__));
			$this->base=$WebMS["ServerURL"].str_replace("PageRate.php","",$this->url);
			$this->page->addJSCode("
				function PageRate(rate){
					var url='".$this->url."';
					new Ajax.Request(
						url, 
						{
							method: 'get', 
							parameters: '?RatePage='+rate+'&page='+'".$this->page->id."'+'&path='+'".$this->page->absRoot."', 
							onComplete: function(req){
								var opts=req.responseText.split('-');
								$('PageRate_votes').title='Voted '+opts[2]+'/5 with '+opts[0]+' votes';
								$('PageRate_votest').innerHTML='Voted '+opts[2]+'/5 with '+opts[0]+' votes';
								$('PageRate_progress').style.width=(parseFloat(opts[2])*100)/5+'px';
								$('PageRate_rate').innerHTML=opts[3];
							}
					});				
				}
			");
		}
		function content(){
			if (isset($_GET["RatePage"])){
				$r=$_GET["RatePage"];
				if ($r=="1" || $r=="2" || $r=="3" || $r=="4" || $r=="5"){
					$this->pg->put("votes",$this->pg->get("votes","0")+1);
					$this->pg->put("rank",$this->pg->get("rank","0")+$r);				
				}
			}
			$rank=$this->pg->get("rank");
			$votes=$this->pg->get("votes");
			if ($votes>0){		
				$rv=round($rank/$votes,2);
			}else{
				$rv=0;	
				$votes=0;
			}		
			$p=$_SERVER['PHP_SELF'];
						$ips=explode(",",$this->pg->get("ip",""));
				$nope=0;
				foreach ($ips as $ipc){
					if ($ipc==$_SERVER['REMOTE_ADDR'])
					{
					$nope=1;
					break;
					}
				}			
			?>
			<div id="PageRate_Arround" style="height: 50px;cursor:default;" onmouseover="$('PageRate_Display').hide();$('PageRate_Vote').show();" onmouseout="$('PageRate_Display').show();$('PageRate_Vote').hide();">
				<div id="PageRate_Display">
					<b>Rate page:</b><br>
					
					<div id="PageRate_votes" title="Voted <?=$rv; ?>/5 with <?=$votes; ?> votes." style="width:100px; <?php
						if (!strcmp($this->bac2[1],"none")==0) {										
							echo "background-image:URL(".$this->base."PageRate/Bars/".$this->bac.");";
						}
					?> height: 20px;">
					
						<div id="PageRate_progress" style="position: static;left:0px;top:0px;background-image:URL(<?=$this->base."PageRate/Bars/".$this->bar; ?>); height: 100%;width: <?=(100*$rv)/5?>px;font-size:0px"></div>
					</div>
					<div id="PageRate_votest" style="font-size: xx-small;">Voted <?=$rv; ?>/5 with <?=$votes; ?> votes</div>
				</div>
				<div id="PageRate_Vote" style="display: none;">
	                <?php
					if (!$nope==1){
						?>
						<div id="PageRate_rate">
							<b>Rate page:</b><br>
							<script language="javascript">
								selsource=0;
								function switchstar(val,inout) {
									if (inout==1) {
										for(var x=1;x<=val;x++) {
												document['i'+x].src="<?=$this->base."PageRate/Bars/".$this->bar; ?>";
										}
									} else {
										for(var x=1;x<=val;x++) {
												document['i'+x].src="<?=$this->base."PageRate/Bars/".$this->bac; ?>";
										}
									}
								}
							</script>
							<img class="alpha" name="i1" onmouseover="switchstar(1,1)" onmouseout="switchstar(1,0)" onclick="PageRate(1)" src="<?=$this->base."PageRate/Bars/".$this->bac; ?>" alt="1" title="Rate this page 1/5"><img class="alpha" name="i2" onmouseover="switchstar(2,1)" onmouseout="switchstar(2,0)" onclick="PageRate(2)" src="<?=$this->base."PageRate/Bars/".$this->bac; ?>" alt="2" title="Rate this page 2/5"><img class="alpha" name="i3" onmouseover="switchstar(3,1)" onmouseout="switchstar(3,0)" onclick="PageRate(3)" src="<?=$this->base."PageRate/Bars/".$this->bac; ?>" alt="3" title="Rate this page 3/5"><img class="alpha" name="i4" onmouseover="switchstar(4,1)" onmouseout="switchstar(4,0)" onclick="PageRate(4)" src="<?=$this->base."PageRate/Bars/".$this->bac; ?>" alt="4" title="Rate this page 4/5"><img class="alpha" name="i5" onmouseover="switchstar(5,1)" onmouseout="switchstar(5,0)" onclick="PageRate(5)" src="<?=$this->base."PageRate/Bars/".$this->bac; ?>" alt="5" title="Rate this page 5/5">  </div>
						<?php
					}else{
						?>
	                    <div id="PageRate_rate">
	                    	<b>You have already rated!<br>Thanks!</b><br>
	                    </div>
	                    <?php
					}
				?>
				</div>
			</div>
			<?php
		}
	}
}
?>
