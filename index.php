<?php 
	$activeHead = 1;
	include 'head.php';

	echo "<content><main>";

			$activeMenu = 1;
			include 'aside.php';
		?>
			<a href="auth.php"><table id="mainImg"><tr><td><img src="img/poster.jpg" title="UnionPoint: Система управления предприятием" alt="UnionPoint: Система управления предприятием" /></td></tr></table></a>

		<?php
		echo "</main></content>";
		include 'footer.php'; 
 
 ?>