<?php
http_response_code($code);
$title = "Erreur  code ".$code;
$content = "<h2 class=\"page-error\"> Erreur code ".$code."</h2><p>".$message."</p>";
