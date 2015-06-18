<?php 

	$arrayMenuLeft = array("", "Главная", 
				"Инструкции", 
				"Авторизация", 
				"Контроллинг",
				"Процессинг",
				"Тех. поддержка");

	$arrayMenuLeftLink = array("", "index.php", 
				"instructions.php", 
				"auth.php", 
				"controlling.php",
				"processing.php",
				"tech.support.php");
				
		
	echo "<aside>";
	echo "<ul>";
	
	for ($i=1; $i < count($arrayMenuLeft); $i++) {
		if ($i == $activeMenu) {
			echo "<p>" . $arrayMenuLeft[$i] . "</p>";
		} else {
			echo "<li><a href=\"" . $arrayMenuLeftLink[$i] . "\">" . $arrayMenuLeft[$i] . "</a></li>";	
		}
	}

	echo "</ul>";
	
	if (isset($_COOKIE["color"])) {
	echo "<FORM ACTION=\"index.php\" METHOD=\"POST\">";	
	echo "<INPUT TYPE=\"hidden\" NAME=\"color\" VALUE=\"" . $_COOKIE["color"] . "\">";
	if (isset($_COOKIE["color_fix"])) {
		echo "<p style=\"margin:5px;\"><INPUT TYPE=\"submit\" VALUE=\"    Случайный цвет ...   \"></p>";
	} else {
		echo "<p style=\"margin:5px;\"><INPUT TYPE=\"submit\" VALUE=\"   Зафиксировать цвет!   \"></p>";
	}	
	echo "</FORM>";
	}
			
	echo "</aside>";

?>
