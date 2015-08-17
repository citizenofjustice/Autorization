<?php
	ob_start();
	#Генерируем уникальную строку для одноразовой ссылки
	$hash = md5(microtime());
	
	#Файл в котором хранятся уникальные строки
	$file = "code.txt";
	
	#Открываем текстовый фал для записи
	$fd = fopen($file,"a");
	if(!$fd) {
		exit("Не возможно открыть файл");
	}
	
	#Запись строки в файл
	fwrite($fd,$hash."\n");
	
	#Закрытие файла
	fclose($fd);
	
	#Путь в котором находятся исполняемые файлы
	$path = substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],"/"));
	
	#Отправка письма на указанную почту (во временную папку писем на сервере "..\tmp\!sendmail")
	if (isset($_POST[Send])) {
		$result = mail("$_POST[login]", "Авторизация пользователя", "Для прохожденя авторизации пройдите по ссылке http://".$_SERVER['HTTP_HOST'].$path."/get_file.php?hash=".$hash."");
		if ($result) {
			echo "<p>Сообщение отправлено!</p>";
			echo "<p>Одноразовая ссылка: <a href='http://".$_SERVER['HTTP_HOST'].$path."/get_file.php?hash=".$hash."'>http://".$_SERVER['HTTP_HOST'].$path."/get_file.php?hash=".$hash."</a></p>";
			exit();
		}
		else {
			echo "<p>Ошибка. Попробуте снова.</p>";
		}
	}
?>

<html>
	<head>
		<title>Главная страница</title>
	</head>
	<body>
		<form method="POST">
			<p>E-mail: <input type="email" name="login" requaired></input></p>
			<input type="submit" name="Send"></input>
		</form>
	</body>
</html>