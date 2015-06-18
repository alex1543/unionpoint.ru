<?php 

	echo "<!doctype html>";
	echo "<html lang=\"ru\">";
	echo "<head>";
	echo "<meta charset=\"UTF-8\">";

	$arrayHeadMy = array("Редактор", "Главная страница", 
				"Инструкции", 
				"Авторизация", 
				"Контроллинг",
				"Процессинг",
				"Тех. поддержка",
				"Управление сайтом",
				"Пользователи",
				"Администрирование БД",
				"Редактирование инструкций",
				"Дополнительно");
	
	echo "<title>UnionPoint: " . $arrayHeadMy[$activeHead] . "</title>";
	echo "<meta name=\"description\" content=\"UnionPoint, " . $arrayHeadMy[$activeHead] . "\">";
	echo " <meta name=\"Keywords\" content=\"UnionPoint, " . $arrayHeadMy[$activeHead] . "\">";

	function GetIsly() {
		$isly = rand(0, 3);
		if (isset($_COOKIE["color"])) {  // уникальное значение
			while ($_COOKIE["color"] == $isly) {
				$isly = rand(0, 3);
			}
		}
		return $isly;			
	}
	
	if (isset($_POST["color"])) {
		if (isset($_COOKIE["color_fix"])) {
			unset($_COOKIE["color_fix"]); 
			SetCookie("color_fix", NULL, -1);
			$isly = GetIsly();
		} else {
			SetCookie("color_fix", "fix");
			$isly = $_COOKIE["color"];
		}
	
	} else {
		if (isset($_COOKIE["color_fix"])) {
			$isly = $_COOKIE["color"];
		} else {
			$isly = GetIsly();
			SetCookie("color", $isly);
		}
	}
	
	$arrStyle = array("style_blue.css",
					  "style_yellow.css",
					  "style_fil.css",
					  "style_green.css");
	$arrLogo =  array("logo_blue2.jpg",
					  "logo_yellow2.jpg",
					  "logo_fil2.jpg",
					  "logo_green2.jpg");
	
	echo "<link rel=\"stylesheet\" href=\"css/" . $arrStyle[$isly] . "\">";
	echo "<link rel=\"stylesheet\" href=\"css/base.css\">";
	echo "<script src=\"js/ie.js\"></script>";
	echo "<script src=\"js/nav.js\"></script>";
	echo "</head>";

	echo "<body><div class=\"fullcont\"><div class=\"container\">";
	echo "<header>";
	$title = "<img src=\"img/" . $arrLogo[$isly] . "\" title=\"UnionPoint: Система управления предприятием\" alt=\"UnionPoint: Система управления предприятием\" />";

	if ($activeHead == 1) {
		echo $title;
	} else {
		echo "<a href=\"index.php\">" . $title . "</a>";
	
	}
	echo "<nav id=\"nav\"></nav></header>";

	
	function MyReadBDSQLSpecial($MyIDInBD) {

		@ $db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);

		if (!$db)
		{
			echo "Ошибка: не удается соединиться с сервером.";
			exit;
		}
		$mytextedit = "";

		mysqli_select_db($db, DB_DATABASE);
		$result=mysqli_query($db, "SET NAMES utf8");
		$query = "SELECT text FROM system WHERE ID = " . $MyIDInBD;
		@ $result = mysqli_query($db,$query);
		if ($result) {
			$row = mysqli_fetch_array($result);
			$mytextedit = $row["text"];
		}
		mysqli_close($db);
		return $mytextedit;
	}

	include 'deff.php';
	
	if (MyReadBDSQLSpecial(FL_BLOCK) == FL_MARKER) {
		echo "<h1>" . FL_MARKER . "</h1>";
		exit;
	
	}
	
	$timeOf = MyReadBDSQLSpecial(7);
	$timeTo = MyReadBDSQLSpecial(8);
	if (($timeOf != "") && ($timeTo != "")) {
		if (($timeOf != "-") && ($timeTo != "-")) {
	
		if (!((MY_TIME < $timeOf) && (MY_TIME >= $timeTo))) {
			echo "<p style=\"margin:10px;\">В системе установлено ограничение входа по времени!</p>";
			echo "<p style=\"margin:10px;\">Текущий час: " . MY_TIME . " час., время разрешенное для входа: c " . $timeTo . " час. по " . $timeOf . " час.</p>";
			exit;
		}
	
		}
	}
?>
