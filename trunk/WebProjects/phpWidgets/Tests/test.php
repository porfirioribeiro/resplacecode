<?php 

include "../PWidgets/PWidgets.php";
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Insert title here</title>
		<link rel="stylesheet" href="../PWidgets/srv.php?css" type="text/css">
		<script type="text/javascript" src="../PWidgets/srv.php?js"></script>
	</head>
	<body>
		<?=$p=new WPanel(array()) ?>
			<?=$tf=new WTextField(array("label"=>"Name:","value"=>"porfirio", "bounds"=>"100,100,100,100")) ?>
			<?=$b=new WInput(array("type"=>"button","value"=>"Click", "onclick"=>"this.setText({$tf}.getValue())")) ?>
		<?=$p->close() ?>
		<?php 

		?>
	</body>
</html>
