<?php
http_response_code($code);
$title = "Error code ".$code;
$content = "<h2 class=\"page-error\"> Error code ".$code."</h2><p>".$message."</p>";
