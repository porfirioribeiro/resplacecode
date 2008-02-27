<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=windows-1250">
    <meta name="generator" content="PSPad editor, www.pspad.com">
    <title>
    Link's
    </title>
    <?
include 'core\f_e_m.php';
    echo '<script type="text/javascript" language="JavaScript">Fi='.$face.';Ei='.$eye.';Mi='.$mouth.'</script>';
    ?>

    <script type="text/javascript">

/***********************************************
* Bookmark site script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

function bookmarksite(title, url){
if (document.all)
window.external.AddFavorite(url, title);
else if (window.sidebar)
window.sidebar.addPanel(title, url, "")
}
function SaveEmote(){
  bookmarksite("My emote","http://porfirio.no-ip.info/emonline/?face="+Fi+"&eye="+Ei+"&mouth="+Mi)
}

</script>
  </head>
  <body bgcolor="#E9E9D8">
  <fieldset title="Test" style="padding:5px">
   <label>IMG for websites:</label><br>
   <input style="width:100%" type="text" title="IMG for websites" value="<img src='http://porfirio.no-ip.info/emonline/emote.php?face=<?echo $face;?>&eye=<?echo $eye;?>&mouth=<?echo $mouth;?>' alt='My emote'>">
   <br><label>URL for websites:</label>
   <input style="width:100%" type="text" title="URL for websites" value="<a href='http://porfirio.no-ip.info/emonline/emote.php?face=<?echo $face;?>&eye=<?echo $eye;?>&mouth=<?echo $mouth;?>' alt='My emote'>My emote</a>">
   <br> <label>IMG and URL for websites:</label><br>
   <input style="width:100%" type="text" title="IMG and URL for websites" value="<a href='http://porfirio.no-ip.info/emonline/emote.php?face=<?echo $face;?>&eye=<?echo $eye;?>&mouth=<?echo $mouth;?>' alt='My emote'><img src='http://porfirio.no-ip.info/emonline/emote.php?face=<?echo $face;?>&eye=<?echo $eye;?>&mouth=<?echo $mouth;?>' alt='My emote'></a>">
  <br> <label>URL for edit later:</label><br>
   <input style="width:100%" type="text" title="URL for edit later" value="http://porfirio.no-ip.info/emonline/?face=<?echo $face;?>&eye=<?echo $eye;?>&mouth=<?echo $mouth;?>">
    <button type="button" onClick="SaveEmote()">Save to Favorites</button>
  </fieldset>
  </body>
</html>
