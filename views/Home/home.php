<?php
require_once (ROOT."/views/layouts/functions.php");

ob_start();

echo "<h2>Les derniers press</h2>";
echo showPresDiv($last_press);
//echo showPressTable($last_press);
echo '<h2>Textes <a class="button" href="'.ROOT_URL.'press/index/texts">Voir plus <img class="svg" src="svg/arrow-right.svg" alt="Plus"></a></h2>';
echo showPresDiv($text_press);
//echo showPressTable($text_press);
echo '<h2>Liens<a class="button" href="'.ROOT_URL.'press/index/texts">Voir plus <img class="svg" src="svg/arrow-right.svg" alt="Plus"></a></h2>';
echo showPresDiv($link_press);
//echo showPressTable($link_press);
$content = ob_get_clean();



