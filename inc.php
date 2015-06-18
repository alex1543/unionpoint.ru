<?php

	function GetTrueTable($dbAUTH, $MyTableName) {
		mysqli_select_db($dbAUTH, DB_DATABASE);
		$query = "SELECT * FROM " . $MyTableName;
		return mysqli_query($dbAUTH,$query);
	}
	
	function MyNewTable($dbPW) {

		if (!GetTrueTable($dbPW, "auth")) {
				$query="CREATE TABLE IF NOT EXISTS privileges (role int(5) NOT NULL, glogin VARCHAR(20) NOT NULL, PRIMARY KEY (role))";
				$result=mysqli_query($dbPW, $query);
				$query="CREATE TABLE IF NOT EXISTS auth (login VARCHAR(20) NOT NULL, password VARCHAR(20) NOT NULL, role int(5) NOT NULL, PRIMARY KEY (login), FOREIGN KEY (role) REFERENCES privileges(role))";
				$result=mysqli_query($dbPW, $query);

				$query = "INSERT INTO privileges (role, glogin) VALUES (10, 'users')";
				$result = mysqli_query($dbPW,$query);
				$query = "INSERT INTO privileges (role, glogin) VALUES (20, 'admins')";
				$result = mysqli_query($dbPW,$query);
				$query = "INSERT INTO privileges (role, glogin) VALUES (30, 'systems')";
				$result = mysqli_query($dbPW,$query);
				$query = "INSERT INTO privileges (role, glogin) VALUES (0, 'guests')";
				$result = mysqli_query($dbPW,$query);
				
				$query = "INSERT INTO auth (login, password, role) VALUES ('user', 'pass', 10)";
				$result = mysqli_query($dbPW,$query);
				$query = "INSERT INTO auth (login, password, role) VALUES ('admin', 'admin', 20)";
				$result = mysqli_query($dbPW,$query);
				$query = "INSERT INTO auth (login, password,role) VALUES ('system', '', 30)";
				$result = mysqli_query($dbPW,$query);
				$query = "INSERT INTO auth (login, password,role) VALUES ('guest', '', 0)";
				$result = mysqli_query($dbPW,$query);
				
				echo mysqli_error($dbPW);
		}
		
		if (!GetTrueTable($dbPW, "processing")) {
				$query="CREATE TABLE IF NOT EXISTS processing (id int(5) NOT NULL AUTO_INCREMENT, otdel int(5) NOT NULL, login VARCHAR(20) NOT NULL, message TEXT NOT NULL, dtW DATE NOT NULL, state BOOLEAN NOT NULL, PRIMARY KEY(id), FOREIGN KEY (login) REFERENCES auth(login))";
				$result=mysqli_query($dbPW, $query);

				$query = "INSERT INTO processing (login, otdel, message, dtW) VALUES ('system', 1, 'Первая запись...', NOW())";
				$result = mysqli_query($dbPW,$query);
				$query = "INSERT INTO processing (login, otdel, message, dtW) VALUES ('system', 1, 'Новая запись...', NOW())";
				$result = mysqli_query($dbPW,$query);
				$query = "INSERT INTO processing (login, otdel, message, dtW) VALUES ('system', 1, 'Ещё запись...', NOW())";
				$result = mysqli_query($dbPW,$query);
				echo mysqli_error($dbPW);
		}
		
		if (!GetTrueTable($dbPW, "support")) {
				$query="CREATE TABLE IF NOT EXISTS support (id int(5) NOT NULL AUTO_INCREMENT, name VARCHAR(20) NOT NULL, email VARCHAR(20) NOT NULL, text TEXT NOT NULL, role int(5) NOT NULL, PRIMARY KEY(id), FOREIGN KEY (role) REFERENCES privileges(role))";
				$result=mysqli_query($dbPW, $query);
    
				$query = "INSERT INTO support (id, name, email, text, role) VALUES
					(1, 'UseR', 'use-aL@gmail.rU', 'Пробная запись для Тех.ПоддержкИ...', 0);
				";
				$result = mysqli_query($dbPW,$query);
		}
		
		if (!GetTrueTable($dbPW, "system")) {
				$query="CREATE TABLE IF NOT EXISTS system (id int(5) NOT NULL AUTO_INCREMENT, role int(5) NOT NULL, text TEXT NOT NULL, PRIMARY KEY(id), FOREIGN KEY (role) REFERENCES privileges(role))";
				$result=mysqli_query($dbPW, $query);
    
				$query = "INSERT INTO system (role, text) VALUES (30, '" . FL_PASSWORD . "')";
				$result = mysqli_query($dbPW,$query);
								
				$query = "INSERT INTO system (id, role, text) VALUES
					(2, 30, '<p>Краткая инструкция по основным пунктам меню:</p><p> 1. Авторизуйтесь в системе UnionPoint<br /> 2. Зайдите в пункт меню Процессинг и понаблюдайте за происходящими процессами на предприятии, при желании добавьте свой процесс<br /> 3. Зайдите в пункт меню Контроллинг и отметьте те процессы, которые уже выполнены<br /> 4. Если у Вас остались вопросы, напишите в тех. поддержку (нижний пункт меню)<br /> 5. Отредактируйте этот текст - ссылка в самом низу страницы<br /> 6. Смените и зафиксируйте цвет страницы, при желании</p><p>С уважением,<br />Автор</p>'),
					(3, 30, '<p>Контроль...</p>\r\n'),
					(4, 30, '<p>Процессы...</p>\r\n'),
					(5, 30, '<p>Авторизация...</p>\r\n'),
					(6, 30, '-'),
					(7, 30, '-'),
					(8, 30, '-'),
					(9, 30, '-');
				";
				$result = mysqli_query($dbPW,$query);
		}
	}
	
	
			function MyNEWBase($dbPW) {

				$query="CREATE DATABASE IF NOT EXISTS " . DB_DATABASE . " DEFAULT CHARACTER SET utf8";
				$result=mysqli_query($dbPW, $query);
					
				mysqli_select_db($dbPW, DB_DATABASE);
				$result=mysqli_query($dbPW, "SET NAMES utf8");
				
				MyNewTable($dbPW);

				return FL_PASSWORD;	
			}
				
			function MyPW() {
			
				if (file_exists(FL_NAME)) {
					// блок чтения из файла
					$mytextedit = "";
					$fp = fopen(FL_NAME, "r"); // Открываем файл в режиме чтения
					if ($fp) {
						while (!feof($fp)) {
							$mytextedit = $mytextedit . fgets($fp, 999);
						}
					}
					else echo "Ошибка при открытии файла";
					fclose($fp);
					return $mytextedit;
				} else {
					// если нет файла, читаем из БД
					$MyPWt="";
					@ $dbPW = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
					if (!$dbPW)
					{
						echo "Ошибка: не удается соединиться с сервером.";
						exit;
					}	
					mysqli_select_db($dbPW,DB_DATABASE);
					$query = "SELECT text FROM system WHERE ID = 1";
					@ $result = mysqli_query($dbPW,$query);
					if (!$result) {
					 
							$MyPWt = MyNEWBase($dbPW);
						
						} else {
							$row = mysqli_fetch_array($result);
							$MyPWt = $row["text"];
						}
					mysqli_close($dbPW);
					
					return $MyPWt;
				}
			}
			
			function MySaveBDSQL() {

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
						$query = "UPDATE system SET text='".$_POST["msg1"]."' WHERE ID = 2";
						$result = mysqli_query($db,$query);	
						
						}
					mysqli_close($db);			
			
			}
			
			function MyReadBDSQL($MyIDInBD) {

				@ $db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);

				if (!$db)
				{
					echo "Ошибка: не удается соединиться с сервером.";
					exit;
				}
				$mytextedit = "";

					mysqli_select_db($db, DB_DATABASE);
					$result=mysqli_query($db, "SET NAMES utf8");
					$query = "SELECT * FROM system WHERE ID = " . $MyIDInBD;
					@ $result = mysqli_query($db,$query);
					if ($result) {
						$row = mysqli_fetch_array($result);
						$mytextedit = $row["text"];
					} else {
					
						MyNEWBase($db);

						$query = "SELECT * FROM system WHERE ID = " . $MyIDInBD;
						@ $result = mysqli_query($db,$query);
						if ($result) {
							$row = mysqli_fetch_array($result);
							$mytextedit = $row["text"];
						}						
					}
					mysqli_close($db);
				return $mytextedit;
				}
				
				
		function GetAuth() {
		
		
			if (isset($_COOKIE["unionpoint"])) {
				echo "<p>Добро пожаловать в систему UnionPoint, <span class=\"bold\">" . $_COOKIE["unionpoint"] . "!</span>";
			
			} else {
				echo "<p><span>Этот раздел доступен только после авторизации!</span></p>";
			
			}
			return isset($_COOKIE["unionpoint"]);
		
		}

			function GetGLoginByRole($role) {

			@ $dbAUTH = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);

			if (!$dbAUTH)
			{
				echo "Ошибка: не удается соединиться с сервером.";
				exit;
			}
			$mytextedit = "";

			mysqli_select_db($dbAUTH, DB_DATABASE);
			$result=mysqli_query($dbAUTH, "SET NAMES utf8");
			$query = "SELECT glogin FROM privileges WHERE role = " . $role;
			@ $result = mysqli_query($dbAUTH, $query);
			if ($result) {
				$row = mysqli_fetch_array($result);
				$mytextedit = $row["glogin"];
			}
			mysqli_close($dbAUTH);		
			return $mytextedit;
		
		}
		
			function GetRoleByLogin($login) {

			if ($login == "") {
				return 0;
			}
			@ $dbAUTH = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);

			if (!$dbAUTH)
			{
				echo "Ошибка: не удается соединиться с сервером.";
				exit;
			}
			$mytextedit = "";

			mysqli_select_db($dbAUTH, DB_DATABASE);
			$result=mysqli_query($dbAUTH, "SET NAMES utf8");
			$query = "SELECT * FROM auth WHERE role <= 20 AND login = '" . $login . "'";
			@ $result = mysqli_query($dbAUTH, $query);
			if ($result) {
				$row = mysqli_fetch_array($result);
				$mytextedit = $row["role"];
			}
			mysqli_close($dbAUTH);		
			return $mytextedit;
		
		}
	
		function GetPasswordByLogin($login) {

			@ $dbAUTH = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);

			if (!$dbAUTH)
			{
				echo "Ошибка: не удается соединиться с сервером.";
				exit;
			}
			$mytextedit = "";

			mysqli_select_db($dbAUTH, DB_DATABASE);
			$query = "SELECT * FROM auth WHERE role <= 20";
			$result = mysqli_query($dbAUTH,$query);
						
			if (!GetTrueTable($dbAUTH, "auth")) {
				MyNEWBase($dbAUTH);
			}
				
			$result=mysqli_query($dbAUTH, "SET NAMES utf8");
			$query = "SELECT * FROM auth WHERE role <= 20 AND login = '" . $login . "'";
			@ $result = mysqli_query($dbAUTH, $query);
			if ($result) {
				$row = mysqli_fetch_array($result);
				$mytextedit = $row["password"];
			}
			mysqli_close($dbAUTH);		
			return $mytextedit;
		}
?>

