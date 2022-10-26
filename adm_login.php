<?php
	
	require '_config.php';

	if (isset($_REQUEST['act'])){
		$act = (int) $_REQUEST['act'];
	} else {
		$act = 0;
	}

	switch ($act) {
		case 0:
?>

	<!DOCTYPE html>
	<html lang="ru">
	<head>
		<title>Авторизация</title>
		<meta charset="utf-8">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
		<link href="All.css" rel=" stylesheet" type=" text/css">
		<script src="All.js" defer></script>		
	</head>

	<body>
		<div class="wrapper">
			<?php 
				require_once('Repeat/Header.php');
			?>
			<div class="content" align="center">

				<div id="blockAuth">
				<h1>Форма авторизации</h1>
				<form action="<?php echo $www; ?>/adm_login.php" method="post">
					<input type="text" class="form" name="login" placeholder="Введите логин" required><br />
					<input type="password" class="form" name="pass" placeholder="Введите пароль" required><br />
					<input type="submit" value="Войти"><br />
					<input type="button" value="Регистрация" onclick = "LogOrReg('blockRegist', 'blockAuth')">
					<input type="hidden" name="act" value="1" />
				</form>
				</div>

				<div id="blockRegist" style="display: none;">
				<h1>Форма регистрации</h1>
				<form action="<?php echo $www; ?>/adm_login.php" method="post">
					<input type="text" class="form" name="login" placeholder="Введите логин" required><br>
					<input type="password" class="form" name="pass" placeholder="Введите пароль" required><br>
					<input type="password" class="form" name="pass2" placeholder="Повторите пароль" required><br>
					<input type="submit" value="Зарегистрироваться"><br>
					<input type="button" value="Авторизация" onclick = "LogOrReg('blockAuth', 'blockRegist')">
					<input type="hidden" name="act" value="3" />
				</form>
				</div>				

			</div>
			<?php 
					require_once('Repeat/footer.php');
			?>
		</div>
	</body>
	</html>

<?php
	
	break;
	case 1:

		$login = trim($_POST['login']);
		$pass = trim($_POST['pass']);

		$pass = md5($pass."DUD");

		$sql = 'SELECT COUNT(*) FROM `users` WHERE (`login`="' . $login . '" and `pass`="' . $pass . '")';
		$sql = mysqli_query($mysqli, $sql);
		$count = mysqli_fetch_array($sql)[0];

		if ($count == 1) {
			$_SESSION['logon'] = 'Ok';
			header('Location: ' . $www . '/admin.php');
			exit();
		} else {
?>

		<h3>Неверный логин или пароль!</h3>
		<a href="<?php echo $www; ?>/adm_login.php">Попробовать снова</a>

<?php	

		}
	break;
	case 2:
		session_unset();
		session_destroy();
		header('Location: ' . $www . '/');
		exit;
	break;
	case 3:
		$login = trim($_POST['login']);
		$pass = trim($_POST['pass']);
		$pass2 = trim($_POST['pass2']);

		#проверка
		if(mb_strlen($login)>50 || mb_strlen($pass)>32 || $pass != $pass2){

			if(mb_strlen($login)>50) echo '<label>Слишком длинный логин</label><br />';
			if(mb_strlen($pass)>32) echo '<label>Слишком длинный пароль</label><br />';
			if($pass != $pass2) echo '<label>Пароли не совпадают</label><br />';
			?>
				<a href="<?php echo $www; ?>/adm_login.php">Попробовать снова</a>
			<?php
			exit();
		}

		#Хэш пароля
		$pass = md5($pass."DUD");

		$sql = 'SELECT COUNT(*) FROM `users` WHERE (`login`="' . $login . '" or `pass`="' . $pass . '")';
		$sql = mysqli_query($mysqli, $sql);
		$count = mysqli_fetch_array($sql)[0];

		if ($count == 1) {
			echo '<label>Такой пользователь уже существует</label><br />';
		?>
			<a href="<?php echo $www; ?>/adm_login.php">Попробовать снова</a>
		<?php
		} else {
			$sql = 'INSERT INTO `users` (`login`, `pass`) VALUES("' . $login .'","' .$pass .'")';
			$sql = mysqli_query($mysqli, $sql);
			$_SESSION['logon'] = 'Ok';
			header('Location: ' . $www . '/admin.php');
			exit();
		}
	break;
	}
?>