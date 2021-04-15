<!DOCTYPE html>
<html>
<head>
	<title><?=$title?> - Presshare</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?=ROOT_URL?>css/style.css">
</head>
<body>
	<?php require_once ROOT."views/layouts/header.php"; ?>
	<?php if(isset($add)){?>
		<a class="button" href="<?=ROOT_URL?>press/add">Ajouter un press</a>
	<?php }?>
	<?=$content?>
	<?php require_once ROOT."views/layouts/footer.php"; ?>
	<?php if(isset($script)){echo $script;}?>
</body>
</html>