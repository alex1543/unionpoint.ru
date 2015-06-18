<?php 
	$activeHead = 0;
	include 'head.php';

	echo "<content><main>";
 
			$activeMenu = 0;
			include 'aside.php';

			echo "<h3>Редактор</h3>";

			include 'inc.php';
			
			
			// блок записи в БД	

			if (isset($_POST["password"])) {
				if ($_POST["password"] == MyPW()) {
					
					MySaveBDSQL();
					echo "<p>Изменения успешно зафиксированы.</p>";					
				} else {
					echo "<p>У Вас нет прав доступа на редактирование. Пожалуйста, повторите ввод. Возможно Вы ошиблись при вводе пароля.</p>";
				}
			}


		if (!isset($_COOKIE["unionpoint"])) {
			echo "<p>Вы не авторизованы в системе!</p>";
		}
			
			?>
			
	<FORM ACTION="edit.php" METHOD="POST">
		<table style="font-size:14px;margin:10px;padding:10px;border:1px gray solid;margin-left:230px;">
		<tr style="font-size:12px;margin:10px;padding:10px;"><td>Инструкции:</td>
		<?php
		
		function GetMSGEchoDisabled() {
			echo "<td class=\"table_fulledit\"><TEXTAREA NAME=\"msg1\" disabled=\"disabled\" COLS=50 ROWS=10><" . MyReadBDSQL(2) . "</TEXTAREA></td></tr>";	
			echo "<tr style=\"font-size:12px;margin:10px;padding:10px;\"><td>&nbsp;</td>";
			echo "<td><INPUT TYPE=\"submit\" disabled=\"disabled\" VALUE=\" Отредактировать \">";
			echo "	<input type=\"password\" disabled=\"disabled\" name=\"password\" value=\"Пароль\">";		
		
		}
		
		if (isset($_COOKIE["unionpoint"])) {
		
		if (GetRoleByLogin($_COOKIE["unionpoint"]) < 20) {
			GetMSGEchoDisabled();
		} else {
			echo "<td class=\"table_fulledit\"><TEXTAREA NAME=\"msg1\" COLS=50 ROWS=10><" . MyReadBDSQL(2) . "</TEXTAREA></td></tr>";	
			echo "<tr style=\"font-size:12px;margin:10px;padding:10px;\"><td>&nbsp;</td>";
			echo "<td><INPUT TYPE=\"submit\" VALUE=\" Отредактировать \">";
			echo " &nbsp;&nbsp;<input type=\"password\" name=\"password\" value=\"Пароль\">";
			}
		} else {
			GetMSGEchoDisabled();
		}
			
		?>			
			
		</td></tr>		
		</table>
	</FORM>
		<?php
		if (isset($_COOKIE["unionpoint"])) {
			if (GetRoleByLogin($_COOKIE["unionpoint"]) < 20) {
				echo "<p><span>Редактировать инструкции имеет право только администратор!</span></p>";
			} else {
				echo "<p>Вы зашли как администратор, Вы имеете право редактировать инструкции.</p>";
			}
		} else {
		//	echo "<p>Вы не авторизованы в системе!</p>";
		}

		echo "</main></content>";
		include 'footer.php'; 
 
 ?>