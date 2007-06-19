<form enctype="multipart/form-data" action="upload.php" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
Send this file: <input name="userfile" type="file" />
<input type="submit" value="Send File" />
</form>

<?php
include 'data/setup.php';
echo "AbsRootPath=".$AbsRootPath."<br>";
echo "RootPath=".$RootPath."<br>";
echo "AbsDataPath=".$AbsDataPath."<br>";
echo "DataPath=".$DataPath."<br>";
echo "AbsUploadPath=".$AbsUploadPath."<br>";
echo "UploadPath=".$UploadPath."<br>";
echo $_SERVER["DOCUMENT_ROOT"];
// Nas versões do PHP anteriores a 4.1.0, deve ser usado $HTTP_POST_FILES
// ao invés de $_FILES.

$uploaddir = $AbsUploadPath;
$uploadfile = $uploaddir . $_FILES['userfile']['name'];
print "<pre>";
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $_FILES['userfile']['name'])) {
    print "O arquivo é valido e foi carregado com sucesso. Aqui esta alguma informação:\n";
    print_r($_FILES);
} else {
    print "Possivel ataque de upload! Aqui esta alguma informação:\n";
    print_r($_FILES);
}
print "</pre>";
?> 
