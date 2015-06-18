<?php 
	$activeHead = 11;
	include 'head.php';

	echo "<content><main>";

			$activeMenu = 0;
			include 'aside.php';

			include 'inc.php';

			function MySaveBDSQLOnePole($idpole, $stForWrite) {

				@ $db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);

				if (!$db)
					{
						echo "Ошибка: не удается соединиться с сервером.";
						exit;
					}
					mysqli_select_db($db, DB_DATABASE);
					$result=mysqli_query($db, "SET NAMES utf8");
					$query = "select * from system";
					@ $result = mysqli_query($db,$query);
					if ($result) {

						mysqli_select_db($db, DB_DATABASE);	
						$result=mysqli_query($db, "SET NAMES utf8");	
						
						$query = "UPDATE system SET text='" . $stForWrite . "' WHERE ID = " . $idpole;
						$result = mysqli_query($db,$query);			
						
						}
					mysqli_close($db);			
			
			}
			
			if (GetAuth()) {

				if (isset($_POST["disabled"])) {
						MySaveBDSQLOnePole(7, "-");
						MySaveBDSQLOnePole(8, "-");				
				}
				if (isset($_POST["in"]) && isset($_POST["out"])) {
						MySaveBDSQLOnePole(7, $_POST["in"]);
						MySaveBDSQLOnePole(8, $_POST["out"]);
						
						//		echo MyReadBDSQL(FL_BLOCK);
					echo "<h3>Доступ на сайт успешно ограничен</h3><p style=\"margin-left:380px\">(с " . $_POST["in"] . ":00 час. по " . $_POST["out"] . ":00 час.)</p>";
				} else {		

			if ((MyReadBDSQL(7) != "-") && (MyReadBDSQL(8) != "-")) {
				echo "<h3>Блокировка сайта активна</h3>";
				echo "<p>Время блокировки: с " . MyReadBDSQL(7) . ":00 час. по " . MyReadBDSQL(8) . ":00 час. (сейчас: " . MY_TIME . " час.)</p>";

				echo "<table class=\"tabledop1\"><tr><td>Снять блокировку:</td><td>";
				
				echo "<FORM ACTION=\"admin.dop.php\" METHOD=\"POST\">";
				echo "<INPUT TYPE=\"hidden\" NAME=\"disabled\" VALUE=\"disabled\">";
				if (GetRoleByLogin($_COOKIE["unionpoint"]) < 20) {
					echo "<INPUT TYPE=\"submit\" disabled=\"disabled\" VALUE=\" Снять \">";		
				} else {
					echo " <INPUT TYPE=\"submit\" VALUE=\" Снять \">";

				}
				echo "&nbsp;</FORM></td></tr></table>";
			if (GetRoleByLogin($_COOKIE["unionpoint"]) < 20) {
				echo "<p><span>Снять блокировку может только администратор!</span></p>";
			} else {
				echo "<p>Вы зашли как администратор, Вы имеете право снять блокировку.</p>";
			}	
				
			} else {
				echo "<h3>Дополнительное управление</h3>";
				echo "<table class=\"tabledop1\"><tr><td style=\"width:280px;\">Ограничить доступ к сайту:</td><td style=\"width:380px;\">";
				
				echo "<FORM ACTION=\"admin.dop.php\" METHOD=\"POST\">";
				if (GetRoleByLogin($_COOKIE["unionpoint"]) < 20) {
					echo " с <input TYPE=\"text\" disabled=\"disabled\" NAME=\"in\" SIZE=2 MAXLENGTH=\"2\" VALUE=\"18\"> час. ";
					echo " по <input TYPE=\"text\" disabled=\"disabled\" NAME=\"out\" SIZE=2 MAXLENGTH=\"2\" VALUE=\"08\"> час. ";
					echo "<INPUT TYPE=\"submit\" disabled=\"disabled\" VALUE=\" Ограничить \">";		
				} else {
					echo " с <input TYPE=\"text\" NAME=\"in\" SIZE=2 MAXLENGTH=\"2\" VALUE=\"18\"> час. ";
					echo " по <input TYPE=\"text\" NAME=\"out\" SIZE=2 MAXLENGTH=\"2\" VALUE=\"08\"> час. ";
					echo " <INPUT TYPE=\"submit\" VALUE=\" Ограничить \">";

				}
				echo "&nbsp;</FORM></td></tr></table>";
				
			if (GetRoleByLogin($_COOKIE["unionpoint"]) < 20) {
				echo "<p><span>Ограничить доступ на сайт может только администратор!</span></p>";
			} else {
				echo "<p>Вы зашли как администратор, Вы имеете право ограничить доступ на сайт.</p>";
			}	
			
				}
			}
			}

		echo "</main></content>";
		include 'footer.php'; 
 
 ?>