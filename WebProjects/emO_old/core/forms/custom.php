<div id="custom" style="position:absolute;left:200px;top:20px;width:113px;height:93px;border:1px solid #333333;background-color:#0099FF;background-image:url(core/img/body.png);visibility:hidden;padding:3px;">
	<form id="customForm" onSubmit="return false" action="javascript:void(0)">
			<div style="border:1px solid #333333;width:100%">Custum Size</div>
			<label>Width :</label>
			<input type="text" name="width" size="2" value="20">
			<br>
			<label>Height:</label>
			<input type="text" name="height" size="2" value="20">
			<br>
		<button name="set" onclick="PageSizeH=this.form.height.value;PageSizeW=this.form.width.value;doEmote();hideForm('custom');return false;">SetSize</button>
		<button onclick="hideForm('custom');return false;">X</button>
	</form>
</div>