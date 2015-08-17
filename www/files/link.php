<?php
	ob_start();
	#Задаем имя файла в котором хранятся уникальные коды
	$file = "code.txt";
	
	#Переменная для проверки на повторение
	$check = FALSE;
	$hash = $_GET['hash'];
	
	#Проверка кодов на длину
	if(strlen($hash) != 32) {
		exit("Неправильныая ссылка");
	}
	
	#Записываем в массив данные из файла
	$arr = file($file);
	
	#Открываем файл
	$fd = fopen($file,"w");
	if(!$fd) {
		exit("Невозможно открыть файл");
	}

	#Цикл проверяет и записывает уникальные коды в файл, если не найдено совпадений с значением переменной $hash.
	#Если совпадение есть то код удаляется.
	for ($i = 0; count($arr) > $i; $i++) {
	
		if($hash == rtrim($arr[$i])) {
			$check = TRUE;
		}
		else {
			fwrite($fd,$arr[$i]);
		}
	}
	
	#Закрываем файл
	fclose($fd);
	
	#Авторизация
	if (isset($_POST['AUTO'])) {
		header("Location: autorization.php");
		exit();
	}
	
	#Регистрация
	if (isset($_POST['REG'])) {
		header("Location: registration.php");
		exit();
	}
	
	#Проверка кода
	if($check == false) {
		exit("Срок действия ссылки истек.");
	}
?>
<html>
	<head>
		<title>Авторизация или регистрация</title>
	</head>
	<body>
		<form method="POST">
			<input type="submit" name="AUTO" value="Авторизация"></input>
			<input type="submit" name="REG" value="Регистрация"></input>
		</form>
	</body>
</html>