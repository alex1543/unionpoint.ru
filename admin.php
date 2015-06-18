<?php 
	$activeHead = 8;
	include 'head.php';

	echo "<content><main>";

			$activeMenu = 0;
			include 'aside.php';

			include 'inc.php';
	/////

		function GetUserTableByLogin($login) {
		
			@ $dbAUTH = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);

			if (!$dbAUTH)
			{
				echo "Ошибка: не удается соединиться с сервером.";
				exit;
			}
			
			if (!GetTrueTable($dbAUTH, "auth")) {
				MyNEWBase($dbAUTH);
			}
		
			$result=mysqli_query($dbAUTH, "SET NAMES utf8");
			if (isset($_POST["id"])) {
				$query = "DELETE FROM auth WHERE login = \"" . $_POST["id"] . "\"";
				$result = mysqli_query($dbAUTH,$query);
			}
			if (isset($_POST["login"]) && isset($_POST["password"])) {
				$query = "INSERT INTO auth (role, login, password) values (10, '" . $_POST["login"] . "', '" . $_POST["password"] . "')";
				$result = mysqli_query($dbAUTH,$query);
			}

			
			$query = "SELECT * FROM auth WHERE role <= 20";
			@ $result = mysqli_query($dbAUTH, $query);
			if ($result) {
				$num_results = mysqli_num_rows($result);
				echo "<table class=\"tabledop1\"><tr><td class=\"tdproc\">№</td><td class=\"tdproc\">Роль</td><td>&nbsp;</td><td class=\"tdprocl\">Имя</td><td class=\"tdproc\">&nbsp;</td></tr>";
				for ($i=0; $i <$num_results; $i++)
				{
					$row = mysqli_fetch_array($result);
					$itmp = $i +1;
					echo "<tr><td class=\"tdproc\">" . $itmp . "</td><td class=\"tdproc\">(" . GetGLoginByRole($row["role"]) . ")" . "</td><td class=\"tdproc\">";

		echo "<FORM ACTION=\"admin.php\" METHOD=\"POST\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=" . $row["login"] . ">";
		if (GetRoleByLogin($_COOKIE["unionpoint"]) < 20) {
			echo "<INPUT TYPE=\"submit\" disabled=\"disabled\" VALUE=\" Удалить \">";		
		} else {
			echo "<INPUT TYPE=\"submit\" VALUE=\" Удалить \">";
		}
		echo "&nbsp;</FORM>";
		
					echo "</td><td class=\"tdprocl\">" . $row["login"] . "</td></tr>";
				}
				echo "</table>";
				
			echo "<FORM ACTION=\"admin.php\" METHOD=\"POST\">";	
			echo "<table class=\"tabledop1\">";	
			echo "	<tr><td>Login:</td><td><INPUT TYPE=\"text\" NAME=\"login\" SIZE=20 MAXLENGTH=\"30\"><td></tr>";	
			echo "	<tr><td>Password:</td><td><INPUT TYPE=\"password\" NAME=\"password\" SIZE=20 MAXLENGTH=\"30\"></td></tr>";	
			echo "	<tr><td>&nbsp;</td><td><INPUT TYPE=\"submit\" VALUE=\" Добавить \"></td></tr>";	
			echo "</table>";	
			echo "</FORM>";	
			if (GetRoleByLogin($_COOKIE["unionpoint"]) < 20) {
				echo "<p><span>Удалять пользователей имеет право только администратор!</span></p>";
			} else {
				echo "<p>Вы зашли как администратор, Вы имеете право удалять пользователей.</p>";
			}
			}
			mysqli_close($dbAUTH);
		}




/////		
			if (GetAuth()) {
				echo "<h3>Управление пользователями</h3>";
				GetUserTableByLogin($_COOKIE["unionpoint"]);
			}

		echo "</main></content>";
		include 'footer.php'; 
 
 ?>