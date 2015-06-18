<?php

	include 'inc.php';

class guestbook {	

	private $db;

function __construct() {
// блок подключения к базе данных
	@ $this->db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);

	if (!$this->db)
	{
		echo "Ошибка: не удается соединиться с сервером.";
		exit;
	}
}


function View($gbAddressMy) {
// основной блок

	echo "<FORM ACTION=\"" . $gbAddressMy ."\" METHOD=\"POST\">";
	echo "	<table><tr><td>Ваше имя:</td><td>";
			
				if (isset($_COOKIE["unionpoint"])) {
					echo $_COOKIE["unionpoint"];
					echo "<INPUT TYPE=\"hidden\" NAME=\"name\" VALUE=\"" .  $_COOKIE["unionpoint"] . "\">";				
				} else {
					echo "<INPUT TYPE=\"text\" NAME=\"name\" SIZE=20 MAXLENGTH=\"30\">";
				}
			
	echo "<td></tr>";
	echo "		<tr><td>Ваш email:</td><td><INPUT TYPE=\"text\" NAME=\"email\" SIZE=20 MAXLENGTH=\"30\" VALUE=\"Ваш E-mail\"></td></tr>";
	echo "		<tr><td>Сообщение:</td><td class=\"table_fulledit\"><TEXTAREA NAME=\"message\" COLS=50 ROWS=10>Ваш вопрос...</TEXTAREA></td></tr>";
	echo "		<tr><td>&nbsp;</td><td><INPUT TYPE=\"submit\" VALUE=\" Отправить \"></td></tr>";
	echo "	</table></FORM>";
}
	
function Delete() {
// блок удаления записи
	if (isset($_GET["id"])) {
		if ($_GET["password"] == MyPW()) {
		mysqli_select_db($this->db, DB_DATABASE);    
		$query = "DELETE FROM support WHERE ID=" . $_GET["id"];
		$result = mysqli_query($this->db,$query);
		echo mysqli_error($this->db);
		echo "<p>Запись успешно удалена.</p>";
		} else {
			echo "<p>У Вас нет прав доступа на удаление записи. Пожалуйста, вернитесь назад и повторите ввод. Возможно Вы ошиблись при вводе пароля.</p>";
		}
	}
}

function Add() {
// блок записи в базу данных	
	if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["message"])) {
		$name=$_POST["name"]; 
		$email=$_POST["email"];
		$message=$_POST["message"];

		if ($name=="" || $email==""  || $message=="" ) {
			echo "<p>Вы указали не все детали.<br> Пожалуйста, вернитесь назад и повторите ввод.</p>";
		} else {
		if ((substr(strrchr($email, "@"), 1) == "") && (substr(strrchr($email, "."), 1) == "")) {
			echo "<p>E-mail задан не корректно...</p>";
		} else {

		if (isset($_COOKIE["unionpoint"])) {
			$login=$_COOKIE["unionpoint"];
		} else {
			$login = "";
		}
		
		$name = mysqli_real_escape_string($this->db,$name);
		$email = mysqli_real_escape_string($this->db,$email);
		$message = mysqli_real_escape_string($this->db,$message);

		if (!GetTrueTable($this->db, "support")) {
			MyNEWBase($this->db);
		}
		
		mysqli_select_db($this->db, DB_DATABASE);
		$result=mysqli_query($this->db, "SET NAMES utf8");
		$query = "INSERT INTO support (name, email, text, role) values ('".strip_tags($name)."', '".strip_tags($email)."', '".strip_tags($message)."', " . GetRoleByLogin($login) . ")";
		$result = mysqli_query($this->db,$query);
		echo mysqli_error($this->db);
		}
		}
	}
}
	
function ViewMessage($gbAddressMy) {

// блок показа записей на экране	
	mysqli_select_db($this->db,DB_DATABASE);
	$result=mysqli_query($this->db, "SET NAMES utf8");
	$query = "SELECT * FROM support ORDER BY ID DESC";
	@ $result = mysqli_query($this->db,$query);
if ($result) {
	$num_results = mysqli_num_rows($result);
	echo "<p style=\"margin-left:250px;\">Всего записей: ".$num_results."</p>";
	for ($i=0; $i <$num_results; $i++)
	{
		$row = mysqli_fetch_array($result);
		echo "<table class=\"tabledop1\"><tr><td>Имя:</td><td>";
		echo stripslashes($row["name"]) . "</td></tr><tr><td>Email:</td><td>";
		echo stripslashes($row["email"]) . "</td></tr><tr><td>Краткий отзыв:</td><td>";
		echo stripslashes($row["text"]) . "</td></tr><tr><td>&nbsp;</td><td>"; 
		echo "</p>";
				
		echo "<FORM ACTION=\"" . $gbAddressMy . "\" METHOD=\"GET\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=" . $row["id"] . ">";
		
		if (isset($_COOKIE["unionpoint"])) {
			if (GetRoleByLogin($_COOKIE["unionpoint"]) < 20) {
				echo "<INPUT TYPE=\"submit\" DISABLED=\"disabled\" VALUE=\" Удалить запись \">";		
			} else {
				echo "<INPUT TYPE=\"submit\" VALUE=\" Удалить запись \">";
				echo " &nbsp;&nbsp;<input TYPE=\"password\" NAME=\"password\" VALUE=\"Пароль\">";
			}
		} else {
			echo "<INPUT TYPE=\"submit\" DISABLED=\"disabled\" VALUE=\" Удалить запись \">";			
		}
		

		echo "&nbsp;</FORM></td></tr></table>";
			
	}
} else {
	echo "<p>Нет ни одной записи.</p>";
}

}
	
	function __destruct() {
		mysqli_close($this->db);
	}

	
}
?>

