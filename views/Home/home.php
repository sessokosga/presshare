<?php
require_once (ROOT."views/layouts/functions.php");

ob_start();

echo "<h2>Last press</h2>";
echo showPresDiv($last_press);
echo '<h2>Texts <a class="button" href="'.ROOT_URL.'press/index/texts">More <img class="svg" src="svg/arrow-right.svg" alt="More"></a></h2>';
echo showPresDiv($text_press);
echo '<h2>Links<a class="button" href="'.ROOT_URL.'press/index/texts">More <img class="svg" src="svg/arrow-right.svg" alt="More"></a></h2>';
echo showPresDiv($link_press);

$content = ob_get_clean();



