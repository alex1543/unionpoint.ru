<?php 
	$activeHead = 3;
	include 'head.php';

	echo "<content><main>";

			$activeMenu = 3;
			include 'aside.php';

			include 'inc.php';
						
			echo "<h3>Авторизация в системе</h3>";

		if (isset($_POST["id"])) {
			if ($_POST["id"] == "quit") {			
				unset($_COOKIE["unionpoint"]); 
				SetCookie("unionpoint", NULL, -1);
			}
		}
		
		if (isset($_POST["login"]) && isset($_POST["password"])) {
			if (($_POST["login"] != "") && ($_POST["password"] != "")) {
				if (GetPasswordByLogin($_POST["login"]) == ($_POST["password"])) {
					$value = $_POST["login"];
					SetCookie("unionpoint", $value);
					echo "<p>Вы успешно авторизованы. Дальнейшая авторизация не требуется.</p>";
				} else {
					echo "<p>Вами введён неверный пароль! Повторите ввод login/password ...</p>";
				}
			} else {
				echo "<p>У Вас пустые поля. Повторите ввод login/password ...</p>";
			}
		}
		
		if (isset($_COOKIE["unionpoint"])) {
		
			echo "<FORM ACTION=\"auth.php\" METHOD=\"POST\">";	
			echo "<INPUT type=\"hidden\" name=\"id\" value=\"quit\">";
			echo "<p>Добро пожаловать в систему UnionPoint, <span class=\"bold\">" . $_COOKIE["unionpoint"] . "!</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "<INPUT TYPE=\"submit\" VALUE=\"   Выйти   \"></p>";		
			echo "</FORM>";	
			
		} else {
		if (!(isset($_POST["login"]) && isset($_POST["password"]))) {
			echo "<p>Вы не авторизованы! Вам нужно автоизоваться...</p>";
			echo "<p>Введите свои данные в форму, педставленную ниже:</p>";		

			echo "<FORM ACTION=\"auth.php\" METHOD=\"POST\">";	
			echo "<table class=\"tabledop1\">";	
			echo "	<tr><td>Login:</td><td><INPUT TYPE=\"text\" NAME=\"login\" SIZE=20 MAXLENGTH=\"30\"><td></tr>";	
			echo "	<tr><td>Password:</td><td><INPUT TYPE=\"password\" NAME=\"password\" SIZE=20 MAXLENGTH=\"30\"></td></tr>";	
			echo "	<tr><td>&nbsp;</td><td><INPUT TYPE=\"submit\" VALUE=\" Авторизация \"></td></tr>";	
			echo "</table>";	
			echo "</FORM>";	
		}
	
		}
 
		echo "</main></content>";
		include 'footer.php'; 
 
 ?>