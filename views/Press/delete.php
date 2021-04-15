<?php
ob_start();
if(isset($success)){
	if($success){
		echo '<div class="alert success">'.$message.'</div>';
	}else{
		echo '<div class="alert error">'.$message.'</div>';
	}
}
$content=ob_get_clean();