<?php 
	$activeHead = 7;
	include 'head.php';

	echo "<content><main>";
 
			$activeMenu = 0;
			include 'aside.php';

			include 'inc.php';

			function MySaveBDSQLOnePole($idpole) {
			
				@ $db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);

				if (!$db)
					{
						echo "Ошибка: не удается соединиться с сервером.";
						exit;
					}
					mysqli_select_db($db, DB_DATABASE);
					$result=mysqli_query($db, "SET NAMES utf8");
					$query = "SELECT * FROM system";
					@ $result = mysqli_query($db,$query);
					if ($result) {

						mysqli_select_db($db, DB_DATABASE);	
						$result=mysqli_query($db, "SET NAMES utf8");	
						
						$query = "UPDATE system SET text='" . FL_MARKER . "' WHERE ID = " . $idpole;
						$result = mysqli_query($db,$query);			
						
						}
					mysqli_close($db);			
			
			}
			
			if (GetAuth()) {

				if (isset($_POST["id"])) {
					if ($_POST["id"] == FL_MARKER) {
						MySaveBDSQLOnePole(FL_BLOCK);  // 9 - it is block site in notes table
					}
						//		echo MyReadBDSQL(FL_BLOCK);
					echo "<h3>Сайт успешно заблокирован.</h3>";
				} else {		

			if (MyReadBDSQL(FL_BLOCK) == FL_MARKER) {
				echo "<h3>Блокировка сайта активна, но отключена в глобальных настройках.</h3>";
			
			} else {
				echo "<h3>Управление сайтом</h3>";
				echo "<table class=\"tabledop1\"><tr><td>Заблокировать сайт!</td><td>";
				
				echo "<FORM ACTION=\"admin.site.php\" METHOD=\"POST\">";
				echo "<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"" . FL_MARKER . "\">";
				if (GetRoleByLogin($_COOKIE["unionpoint"]) < 20) {
					echo "<INPUT TYPE=\"submit\" disabled=\"disabled\" VALUE=\" Заблокировать \">";		
				} else {
					echo "<INPUT TYPE=\"submit\" VALUE=\" Заблокировать \">";
				}
				echo "&nbsp;</FORM></td></tr></table>";
				
			if (GetRoleByLogin($_COOKIE["unionpoint"]) < 20) {
				echo "<p><span>Заблокировать сайт имеет право только администратор!</span></p>";
			} else {
				echo "<p>Вы зашли как администратор, Вы имеете право заблокировать сайт.</p>";
			}	
			
				}
			}
			}

		echo "</main></content>";
		include 'footer.php'; 
 
 ?>