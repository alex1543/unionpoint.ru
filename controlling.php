<?php 
	$activeHead = 4;
	include 'head.php';

	echo "<content><main>";

			$activeMenu = 4;
			include 'aside.php';

			include 'inc.php';
	/////

		function GetMessageByLoginForControl($login) {
		
			@ $dbAUTH = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);

			if (!$dbAUTH)
			{
				echo "Ошибка: не удается соединиться с сервером.";
				exit;
			}

			if (!GetTrueTable($dbAUTH, "processing")) {
				MyNEWBase($dbAUTH);
			}

			$result=mysqli_query($dbAUTH, "SET NAMES utf8");
			if (isset($_POST["id"])) {
				$query = "UPDATE processing SET otdel=" . ($_POST["otdel"] +1) . " WHERE ID=" . $_POST["id"];
				$result = mysqli_query($dbAUTH,$query);
			}
			
			if (isset($_GET["otdel"])) {
				$otdel = $_GET["otdel"];
			} else {
				$otdel = 0;
			}
			
			function GetHref($srtOtdel, $i, $otdel) {
				if ($srtOtdel == "") {
					return "<td class=\"tdotdelhead\">&nbsp;</td>";
				}
				if ($i == $otdel) {
					return "<td class=\"tdotdel\"><div class=\"activeotdel\">" . $srtOtdel . "</div></td>";
				} else {
					return "<td class=\"tdotdel\"><a href=\"controlling.php?otdel=" . $i . "\">" . $srtOtdel . "</a></td>";
				}
			}
			
			
			$massOtdel = array("Отдел 1", "Отдел 2", "Цех 1", "Цех 2", "Цех3", "Цех 4");
			
			$query = "SELECT * FROM processing WHERE otdel = " . ($otdel+1) . " ORDER BY ID DESC";
			@ $result = mysqli_query($dbAUTH, $query);
			$num_results = mysqli_num_rows($result);

			///----
			echo "<table><tr><td class=\"tdotdelhead\">&nbsp;</td><td class=\"tdprocl\">Имя</td><td class=\"tdprocdt\">Дата записи</td><td>Процесс...</td><td class=\"tdprocdt\">&nbsp;</td></tr>";
			
			if (count($massOtdel) > $num_results) {
				$NumLimeTr = count($massOtdel);
			} else {
				$NumLimeTr = $num_results;
			}
			for ($i=0; $i < $NumLimeTr; $i++) {

//++
				if ($i < count($massOtdel)) {
					$srtOtdel = $massOtdel[$i];
				} else {
					$srtOtdel = "";
				}
				if (($result) && ($i <$num_results)) {
					$row = mysqli_fetch_array($result);
					echo "<tr>" . GetHref($srtOtdel, $i, $otdel) . "<td class=\"tdprocl\">" . $row["login"] . "</td><td class=\"tdprocdt\">" . $row["dtW"] . "</td><td>" . $row["message"] . "</td><td class=\"tdprocdt\">";

					echo "<FORM ACTION=\"controlling.php?otdel=" . $otdel . "\" METHOD=\"POST\">";
					echo "<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=" . $row["id"] . ">";
					echo "<INPUT TYPE=\"hidden\" NAME=\"login\" VALUE=" . $row["login"] . ">";
					echo "<INPUT TYPE=\"hidden\" NAME=\"otdel\" VALUE=" . $row["otdel"] . ">";
					if ($row["state"] == true) {
						echo "<INPUT TYPE=\"submit\" disabled=\"disabled\" VALUE=\" Выполнено \">";		
					} else {
						echo "<INPUT TYPE=\"submit\" VALUE=\" Выполнено \">";
					}

					echo "&nbsp;</FORM>";
		
					echo "</td></tr>";
				} else {
					echo "<tr>" . GetHref($srtOtdel, $i, $otdel) . "<td class=\"tdprocl\">&nbsp;</td><td class=\"tdprocdt\">&nbsp;</td><td>&nbsp;</td><td class=\"tdprocdt\">&nbsp;</td></tr>";
				}

//++

			}
			echo "</table>";
			////----
			mysqli_close($dbAUTH);
		}
/////		
			if (GetAuth()) {
				echo "<h3>Система контроля</h3>";
				GetMessageByLoginForControl($_COOKIE["unionpoint"]);
			}

		echo "</main></content>";
		include 'footer.php'; 
 
 ?>