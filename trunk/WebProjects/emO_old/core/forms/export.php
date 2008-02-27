<script type="text/javascript" language="JavaScript">
 function selectFormat(f){
  obt=document.getElementById("name");
  t=obt.value;
  p=t.indexOf(".");
  if (p>-1){
    t=t.substring(0,p)
  }
  obt.value=t+"."+f.value;
 }
</script>
<div id="export" style="z-index:100;width:200px;border:1px solid #000000;padding:5px;padding-bottom:0px;visibility:hidden;position:absolute;background-color:#0099FF;background-image:url(core/img/body.png)">
  <form action="download.php" name="exportForm" id="exportForm" method="get">
    <fieldset>
      <legend>Preview</legend>
      <center>
        <img id="ims" src="emote.php" alt="emote">
      </center>
    </fieldset>
    <fieldset>
      <legend>Select Name</legend>
      <input type="text" name="name" id="name" value="Emote.png" title="Name of file">
    </fieldset>
    <fieldset>
      <legend>Select Format</legend>
      <input type="radio" name="format" value="png" title="Save as PNG" checked onclick="selectFormat(this)">
      <label title="Save as PNG">Png</label><br>
      <input type="radio" name="format" value="jpg" title="Save as JPG" onclick="selectFormat(this)">
      <label title="Save as JPG">Jpg</label><br>
      <input type="radio" name="format" value="gif" title="Save as GIF" onclick="selectFormat(this)">
      <label title="Save as GIF">Gif</label>
    </fieldset>
    <fieldset>
      <legend>Save</legend>
	  <input id="ipw" type="hidden" name="pw" value="0">
	  <input id="ipw" type="hidden" name="ph" value="0">
      <input id="ifi" type="hidden" name="fi" value="0">
	  <input id="ifx" type="hidden" name="fx" value="0">
	  <input id="ify" type="hidden" name="fy" value="0">
      <input id="iei" type="hidden" name="ei" value="0">
	  <input id="iex" type="hidden" name="ex" value="0">
	  <input id="iey" type="hidden" name="ey" value="0">
      <input id="imi" type="hidden" name="mi" value="0">
	  <input id="imx" type="hidden" name="mx" value="0">
	  <input id="imy" type="hidden" name="my" value="0">
      <button title="Close this window" onclick="hideForm('export');return false">Close</button>
      <button type="submit" onclick="hideForm('export')">Save</button>
    </fieldset>
  </form>
</div>