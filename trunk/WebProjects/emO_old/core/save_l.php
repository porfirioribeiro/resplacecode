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
<form action="download.php" name="dload" method="get">
  <div class="fdiv" onmouseover="setDrag(this)" id="save_l" style="z-index:100;">
    <table cellspacing="0" cellpadding="0" border="1">
      <tr>
        <td class="caption" onmousedown="dragStart(this,event)" onmousemove="doDrag(this,event)">          EmOnline
        </td>
      </tr>
      <tr>
        <td class="content">
          <center>
            <img id="ims" src="emote.php" alt="emote">
          </center>
        </td>
      </tr>
      <tr>
        <td class="content">
          <fieldset>
            <legend>
              Select Format
            </legend>
            <input type="radio" name="format" value="png" title="Save as PNG" checked onclick="selectFormat(this)">
            <label title="Save as PNG">
              Png
            </label>
            <br>
            <input type="radio" name="format" value="jpg" title="Save as JPG" onclick="selectFormat(this)">
            <label title="Save as JPG">
              Jpg
            </label>
            <br>
            <input type="radio" name="format" value="gif" title="Save as GIF" onclick="selectFormat(this)">
            <label title="Save as GIF">
              Gif
            </label>
            </fieldset>
            <fieldset>
              <legend>
                Select Name
              </legend>
              <input type="text" name="name" id="name" value="Emote.png" title="Name of file">
              <br>
              </fieldset>
        </td>
      </tr>
      <tr>
        <td class="footer">
          <input id="sf" type="hidden" name="face" value="0">
          <input id="se" type="hidden" name="eye" value="0">
          <input id="sm" type="hidden" name="mouth" value="0">
          <input type="button" title="Close this window" value="Close" onclick="hideDiv('save_l')">
          <input type="submit" value="Save" onclick="hideDiv('save_l')">
        </td>
      </tr>
    </table>
  </div>
</form>
