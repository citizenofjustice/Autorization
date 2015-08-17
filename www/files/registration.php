<?php
	ob_start();
	#Подключаем БД
	include ("db.php");
	
	#Действия по нажатию кнопки
	if (isset($_POST['Send'])) {
		#Массив для вывода ошибок
		$err = array();
		
		$login = $_POST['login'];
		
		#Проверяем логин
		if(!preg_match("/^[a-zA-Z0-9]+$/", $_POST['login'])) {
			$err[] = "Логин может состоять только из букв латинского алфавита и цифр";
		}
		if (strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30) {
			$err[] = "Логин должен быть не меньше 3-х символов и не больше 30-и";
		}
		
		#Проверяем не существует ли пользователя с таким именем
		$query = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='$login'");
		$count = mysqli_fetch_array($query);
		if (!empty($count['user_id'])) {
			$err[] = "Пользователь с таким логином уже существует в базе данных";
		}
		
		#Если нет ошибок, то добавляем в БД нового пользователя
		if (count($err) == 0) {
			#Убираем лишние пробелы и делаем двойное шифрование
			$password = md5(md5(trim($_POST['password'])));
			mysqli_query($link, "INSERT INTO users SET user_login='".$login."', user_password='".$password."'");
			header("Location: autorization.php");
			exit();
		}
		else
		{
			#Вывод ошибок
			print "<p><b>При регистрации произошли следующие ошибки:</b></p>";
			foreach($err AS $error) {
				print $error."<br>";
			}
        }
	}
?>
<html>
	<head>
		<title>Регистрация</title>
	</head>
	<body>
		<form method="POST">
			<p>Логин: <input type="text" name="login" required></input></p>
			<p>Пароль: <input type="password" name="password" required></input></p>
			<p><input type="submit" name="Send" value="Зарегистрироваться"></input></p>
		</form>
	</body>
</html>