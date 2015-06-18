<?php 
	$activeHead = 2;
	include 'head.php';

	echo "<content><main>";
 
			$activeMenu = 2;
			include 'aside.php';

		include 'inc.php';
		echo MyReadBDSQL(2); 

		echo "</main></content>";
		include 'footer.php'; 
 
 ?>