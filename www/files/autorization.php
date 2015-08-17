<?php
	ob_start();
	#Запускаем сессию
	session_start();
	
	#Соединение с БД
	include ("db.php");
	if(isset($_POST['Send'])) {
		#Вытаскиваем из БД запись, у которой логин равняется введенному
		$query = mysqli_query($link, "SELECT user_login user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link,$_POST['login'])."' LIMIT 1");
		#Записываем данные в массив
		$data = mysqli_fetch_assoc($query);
		#Сравниваем пароли
		if($data['user_password'] === md5(md5($_POST['password']))) {
			$_SESSION[user_login]=$_POST['login'];
			header("Location: account.php");
			exit();
		}
		else {
			echo "Вы ввели не верный логин/пароль";
		}
	}
?>

<html>
	<head>
		<title>Авторизация</title>
	</head>
	<body>
		<form method="POST">
			<p>Логин: <input type="text" name="login"></input></p>
			<p>Пароль: <input type="password" name="password"></input></p>
			<p><input type="submit" name="Send" value="Войти"></input></p>
		</form>
	</body>
</html>