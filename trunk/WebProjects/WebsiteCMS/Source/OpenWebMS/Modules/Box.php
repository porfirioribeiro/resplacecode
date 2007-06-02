<?php
/*
 * Box.Net Module
 * Notes: Made for use on either left or right column, some editing may be required for center use.
 * @author Porfirio
 */
class Box extends Module {
	const BLACK="000000";
	const ORANGE="CE6700";
	const BLUE="0C5C98";
	var $color=Box::BLACK;
	function Box($page){
		$this->page=$page;
		$this->side=Module::RIGHT;
		$this->title="Box.net Files";
	}
	function content(){
	?>
		<object type="application/x-shockwave-flash" data="http://www.box.net/static/flash/widget_player.swf" width="183" height="260">
		  <param name="movie" value="http://www.box.net/static/flash/widget_player.swf">
		  <param name="FlashVars" value="subString=folderId=qij72cpi89,color=<?=$this->color?>,title=All Files:">
		  <param name="wmode" value="transparent">
		</object>
	<?php		
	}
}
?>

