<?php

			if (!defined("DB_HOST")) {
				if ($_SERVER['SERVER_NAME'] == "localhost") {
					define('DB_HOST', 'localhost');
					define('DB_USER', 'root');
					define('DB_PASSWORD', '');
					define('DB_DATABASE', 'unionpoint');				
				} else {
					define('DB_HOST', 'mysql.hostinger.ru');
					define('DB_USER', 'u672484183_user');
					define('DB_PASSWORD', '123456789q');
					define('DB_DATABASE', 'u672484183_user');
				}
			}

			if (!defined("FL_NAME")) {
				define('FL_PASSWORD', '8940');
				define('FL_NAME', 'MyPW.txt');
				define('FL_MARKER', 'yes, block my site for all used');
				define('FL_BLOCK', '9');   // 9 - it is block site in notes table
			}

			if (!defined("MY_TIME")) {
				if ($_SERVER['SERVER_NAME'] == "localhost") {
					$time = date( 'H', time() + (2*3600));
					define('MY_TIME', $time);				
				} else {
					$time = date( 'H', time() + (4*3600));
					define('MY_TIME', $time);				
				}
			}			
				
?>