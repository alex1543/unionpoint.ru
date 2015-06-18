<?php 
	$activeHead = 9;
	include 'head.php';

	echo "<content><main>";

			$activeMenu = 0;
			include 'aside.php';

			include 'inc.php';
	/////

		function GetAllTableByLogin($login) {

			@ $dbAUTH = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);

			if (!$dbAUTH)
			{
				echo "Ошибка: не удается соединиться с сервером.";
				exit;
			}

			mysqli_select_db($dbAUTH, DB_DATABASE);
			$result=mysqli_query($dbAUTH, "SET NAMES utf8");
			
			if (isset($_POST["id"])) {
				$query = "DROP TABLE IF EXISTS " . $_POST["id"];
				$result = mysqli_query($dbAUTH,$query);
			}
			
			$query = "SHOW TABLES FROM " . DB_DATABASE;
			$result = mysqli_query($dbAUTH,$query);
					
			if ($result) {
				$num_results = mysqli_num_rows($result);
				echo "<table class=\"tabledop1\"><tr><td class=\"tdproc\">№</td><td class=\"tdprocl\">Имя таблицы</td><td class=\"tdproc\">&nbsp;</td></tr>";
				for ($i=0; $i <$num_results; $i++)
				{
					$row = mysqli_fetch_array($result);
					$itmp = $i;
					echo "<tr><td class=\"tdproc\">" . ++$itmp . "</td><td class=\"tdproc\">" . $row[0] . "</td><td class=\"tdproc\">";

		echo "<FORM ACTION=\"admin.db.php\" METHOD=\"POST\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=" . $row[0] . ">";
		if (GetRoleByLogin($_COOKIE["unionpoint"]) < 20) {
			echo "<INPUT TYPE=\"submit\" disabled=\"disabled\" VALUE=\" Удалить \">";		
		} else {
			echo "<INPUT TYPE=\"submit\" VALUE=\" Удалить \">";
		}
		echo "&nbsp;</FORM>";
		
					echo "</td></tr>";
				}
				echo "</table>";

			if (GetRoleByLogin($_COOKIE["unionpoint"]) < 20) {
				echo "<p><span>Удалять таблицы имеет право только администратор!</span></p>";
			} else {
				echo "<p>Вы зашли как администратор, Вы имеете право удалять таблицы.</p>";
			}				
			}
			mysqli_close($dbAUTH);
		}




/////		
			if (GetAuth()) {
				echo "<h3>Администрирование БД</h3>";
				GetAllTableByLogin($_COOKIE["unionpoint"]);
			}

		echo "</main></content>";
		include 'footer.php'; 
 
 ?>