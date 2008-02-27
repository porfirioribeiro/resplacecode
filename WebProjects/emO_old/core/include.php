<?
 if (!isset($face))
  $face="0";
 if (!isset($eye))
  $eye="0";
 if (!isset($mouth))
  $mouth="0"; 
echo '<script type="text/javascript" language="JavaScript">Fi='.$face.';Ei='.$eye.';Mi='.$mouth.'</script>';
//clearstatcache();


function dirList ($directory) 
{
    $results = array();
    $handler = opendir($directory);
    while ($file = readdir($handler)) {
        if ($file != '.' && $file != '..')
            $results[] = $file;
    }
    closedir($handler);
	sort($results);
    return $results;
}
/*loading*/

echo '<table id="loading" border="0" cellspacing="0" cellpadding="0"><tr>'."\n";
echo '<td>Loading...</td>'."\n";
echo '</tr></table>'."\n";


/*Faces*/
$Faces=dirList(getcwd().'/emfaces/');
echo '<script type="text/javascript" language="JavaScript">totalFaces='.count($Faces).'</script>';
$fid=1;
$lin=1;
echo '<table class="tabs" id="faces" border="0" cellspacing="0" cellpadding="0"><tr>'."\n";
foreach( $Faces as $key => $value){
  if ((strpos(strtolower($value),".gif")!==false) or (strpos(strtolower($value),".jpg")!==false) or (strpos(strtolower($value),".png")!==false)){
    If ($fid<($lin*10))
      echo '<td class="bem" onmousedown="selectFace(this)"><img alt="'.str_replace(".png","",$value).'" src="emfaces/'.$value.'"></td>'."\n";
    }
    If ($fid==($lin*10)){
      $lin+=1;
      echo "</tr><tr>"."\n";
      }
    $fid+=1;
}
echo '</tr></table>'."\n";
/*Eyes*/
$Faces=dirList(getcwd().'/emeyes/');
echo '<script type="text/javascript" language="JavaScript">totalEyes='.count($Faces).'</script>';
$fid=1;
$lin=1;
echo '<table class="tabs" id="eyes" border="0" cellspacing="0" cellpadding="0"><tr>'."\n";
foreach( $Faces as $key => $value){
  if ((strpos(strtolower($value),".gif")!==false) or (strpos(strtolower($value),".jpg")!==false) or (strpos(strtolower($value),".png")!==false)){
    If ($fid<($lin*10))
      echo '<td class="bem" onmousedown="selectEye(this)"><img alt="'.str_replace(".png","",$value).'" src="emeyes/'.$value.'"></td>'."\n";
    }
    If ($fid==($lin*10)){
      $lin+=1;
      echo "</tr><tr>"."\n";
      }
    $fid+=1;
}
echo '</tr></table>'."\n";

/*Mouth*/
$Faces=dirList(getcwd().'/emmouth/');
echo '<script type="text/javascript" language="JavaScript">totalMouth='.count($Faces).'</script>';

$fid=1;
$lin=1;
echo '<table class="tabs" id="mouth_test" border="0" cellspacing="0" cellpadding="0"><tr>'."\n";
foreach( $Faces as $key => $value){
  if ((strpos(strtolower($value),".gif")!==false) or (strpos(strtolower($value),".jpg")!==false) or (strpos(strtolower($value),".png")!==false)){
    If ($fid<($lin*10))
      echo '<td class="bem" onmousedown="selectMouth(this)"><img alt="'.str_replace(".png","",$value).'" src="emmouth/'.$value.'"></td>'."\n";
    }
    If ($fid==($lin*10)){
      $lin+=1;
      echo "</tr><tr>"."\n";
      }
    $fid+=1;
}
echo '</tr></table>'."\n";

?>
