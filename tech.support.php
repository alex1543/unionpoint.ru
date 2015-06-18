<?php 
	$activeHead = 6;
	include 'head.php';

	echo "<content><main>";
 
			$activeMenu = 6;
			include 'aside.php';

			echo "<h3>Техническая поддержка</h3>";


	$gbAddressMy = 'tech.support.php';
	include 'class_guestbook.php';
	$MyGuestbook = new guestbook;
	if (isset($_GET["id"])) {
		$MyGuestbook->Delete();
	}
	if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["message"])) {
		$MyGuestbook->Add();
	}
	$MyGuestbook->View($gbAddressMy);
	$MyGuestbook->ViewMessage($gbAddressMy);


		echo "</main></content>";
		include 'footer.php'; 
 
 ?>