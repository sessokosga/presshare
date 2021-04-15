<?php
ob_start();
require_once (ROOT."/views/layouts/functions.php");
echo "<h2>Résultats de recherche</h2>";
echo "<h3>".$message."</h3>";

if(isset($press)){	
	echo showPresDiv($press);
}
$content=ob_get_clean();