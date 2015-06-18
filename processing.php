<?php 
	$activeHead = 5;
	include 'head.php';

	echo "<content><main>";

			$activeMenu = 5;
			include 'aside.php';

			include 'inc.php';
	/////

		function GetMessageByLogin($login) {
		
			@ $dbAUTH = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);

			if (!$dbAUTH)
			{
				echo "Ошибка: не удается соединиться с сервером.";
				exit;
			}

			echo "<FORM ACTION=\"processing.php\" METHOD=\"POST\">";
			echo "<table>";
			echo "<tr><td><TEXTAREA NAME=\"message\" COLS=50 ROWS=2>добавить</TEXTAREA></td>";
			echo "<td><INPUT TYPE=\"submit\" VALUE=\"   Добавить процесс   \"></td></tr>";
			echo "</table>";
			echo "</FORM>";
				
			if (!GetTrueTable($dbAUTH, "processing")) {
				MyNEWBase($dbAUTH);
			}

			$result=mysqli_query($dbAUTH, "SET NAMES utf8");
			if (isset($_POST["message"])) {
				$query = "INSERT INTO processing (login, otdel, message, dtW) values ('" . $login . "', 1, '" . $_POST["message"] . "', NOW())";
				$result = mysqli_query($dbAUTH,$query);
			}
			
			$query = "SELECT * FROM processing ORDER BY ID DESC";
			@ $result = mysqli_query($dbAUTH, $query);
			if ($result) {
				$num_results = mysqli_num_rows($result);
				echo "<table><tr><td class=\"tdproc\">№</td><td class=\"tdprocl\">Имя</td><td class=\"tdprocdt\">Дата записи</td><td>Процесс...</td></tr>";
				for ($i=0; $i <$num_results; $i++)
				{
					$row = mysqli_fetch_array($result);
					echo "<tr><td class=\"tdproc\">" . $row["id"] . "</td><td class=\"tdprocl\">" . $row["login"] . "</td><td class=\"tdprocdt\">" . $row["dtW"] . "</td><td>" . $row["message"] . "</td></tr>";
				
				}
				echo "</table>";
			}
			mysqli_close($dbAUTH);
		}
/////	
			if (GetAuth()) {
				echo "<h3>Процессы на предприятии</h3>";
				GetMessageByLogin($_COOKIE["unionpoint"]);
			}

		echo "</main></content>";
		include 'footer.php'; 
 
 ?>