<?php
	ob_start();
	#Восстанавливаем сессию
	session_start();
	#Подключаем БД
	include ("db.php");
	#Выводим логин пользователя
	echo "Здравствуйте, ";
	echo $_SESSION[user_login];
	
	#Изменение логина пользователя
	if (isset($_POST['Send'])) {
		mysqli_query($link, "UPDATE users SET user_login='".$_POST['newlogin']."' WHERE user_login='".$_SESSION[user_login]."'");
		session_destroy();
		header('Location: account.php');
	}
	
	#Выход из профиля
	if (isset($_POST['Exit'])) {
		session_destroy();
		header('Location: index.php');
		exit;
	}
?>

<html>
	<head>
		<title>Авторизация</title>
	</head>
	<body>
		<form method="POST">
			<p>Введите новый логин: <input type="text" name="newlogin"></input></p>
			<p><input type="submit" name="Send" value="Изменить логин"></input></p>
			<p><input type="submit" name="Exit" value="Выйти"></input></p>
		</form>
	</body>
</html>