<?php
	require '_config.php';

	if(!isset($_SESSION['logon']) || $_SESSION['logon'] != 'Ok'){
		header('Location: ' . $www . '/adm_login.php');
		exit;
	}
	if (isset($_REQUEST['act'])){
		$act = $_REQUEST['act'];
	} else {
		$act = 0;
	}
	switch ($act) {
		case "add":
			$title = htmlspecialchars(trim($_POST['title']));
			$abstract = htmlspecialchars(trim($_POST['abstract']));
			$text = htmlspecialchars(trim($_POST['text']));

			$sql = 'INSERT INTO `news` (`date`, `title`, `abstract`, `text`) VALUES (NOW(), "' . $title . '", "' . $abstract . '", "' . $text . '")';
			$sql = mysqli_real_query($mysqli, $sql);
			$id = mysqli_insert_id($mysqli);

			move_uploaded_file($_FILES['photo']['tmp_name'], $dir . '/images/' . $id . '.jpg');

			header('Location: ' . $www);
			exit;
		break;

		case "edit":
			$id = $_POST['news'];
			
			$sql = 'SELECT * FROM `news` WHERE `news`.`id`="'. $id .'"';
			$sql = mysqli_query($mysqli, $sql);
       		$row = mysqli_fetch_assoc($sql);

			$title = htmlspecialchars(trim($_POST['title']));
			$abstract = htmlspecialchars(trim($_POST['abstract']));
			$text = htmlspecialchars(trim($_POST['text']));

			if($title == ""){
				$title = $row['title'];
			}
			if($abstract == ""){
				$abstract = $row['abstract'];
			}
			if($text == ""){
				$text = $row['text'];
			}

			$sql = 'UPDATE `news` SET `title`="' . $title . '", `abstract`="' . $abstract . '", `text`="' . $text . '" WHERE `news`.`id`="'. $id .'"';
			$sql = mysqli_real_query($mysqli, $sql);

			move_uploaded_file($_FILES['photo']['tmp_name'], $dir . '/images/' . $id . '.jpg');

			header('Location: ' . $www);
			exit;
		break;

		case "delete":
			$delchecked = $_POST['check'];
			foreach ($delchecked as $id => $value) {
				$sql = 'DELETE FROM `news` WHERE `news`.`id`="'. $id .'"';
				$sql = mysqli_real_query($mysqli, $sql);
				unlink($dir . '/images/' . $id . '.jpg');
			}
			header('Location: ' . $www);
			exit;
		break;

		default:
		?>
	
			<!DOCTYPE html>
			<html lang="ru">
			<head>
				<title>Работа с новостями</title>
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


					<div class="content">
						<h1>Выберите дествие</h1>
						<div class="ChooseButton">
							<table>
								<tr>
									<td><button type="button" onclick="WorkWithNews('AddNews','EditNews','DeleteNews')">Добавить</button></td>
									<td><button type="button" onclick="WorkWithNews('EditNews','AddNews','DeleteNews')">Редактировать</button></td>
									<td><button type="button" onclick="WorkWithNews('DeleteNews','AddNews','EditNews')">Удалить</button></td>
								</tr>
							</table>
						</div>

						<div id="AddNews">
							<h3>Добавление новости</h3>
							<form action="<?php echo $www; ?>/admin.php" method="post" enctype="multipart/form-data">
								<table>
									<tr><td class="Fir">Заголовок</td><td><input type="text" name="title" required/></td></tr>
									<tr><td>Фотография</td><td><input type="file" name="photo" required/></td></tr>
									<tr><td>Аннотация</td><td><textarea name="abstract" cols="50" rows="5" required></textarea></td></tr>
									<tr><td>Текст</td><td><textarea name="text" cols="50" rows="10" required></textarea></td></tr>
									<tr><td colspan="2"><input type="submit" /></td></tr>
								</table>
								<input type="hidden" name="act" value="add" />
							</form>
						</div>

						<div id="EditNews">
							<h3>Редактирование новости</h3>
							<form action="<?php echo $www; ?>/admin.php" method="post" enctype="multipart/form-data">
								<table>
									<tr><td class="Fir">Выберите новость</td>
										<td>
											<select name="news" id="ChooseNews">
												<?php
							
													$sql = 'SELECT `id`,`title` FROM `news` ORDER BY `id` DESC';
													$sql = mysqli_query($mysqli, $sql);
													while ($row = mysqli_fetch_assoc($sql)){
														echo '<option value="' . $row['id'] . '">'. $row['title'] .'</option>';
													}
												?>
											</select>
										</td>
									</tr>
									<tr><td>Заголовок</td><td><input type="text" name="title" /></td></tr>
									<tr><td>Фотография</td><td><input type="file" name="photo" /></td></tr>
									<tr><td>Аннотация</td><td><textarea name="abstract" cols="50" rows="5"></textarea></td></tr>
									<tr><td>Текст</td><td><textarea name="text" cols="50" rows="10"></textarea></td></tr>
									<tr><td colspan="2"><input type="submit" /></td></tr>
								</table>
								<input type="hidden" name="act" value="edit" />
							</form>					
						</div>

						<div id="DeleteNews">
							<h3>Удаление новости</h3>
							<form action="<?php echo $www; ?>/admin.php" method="post" enctype="multipart/form-data">
								<table>
									<?php
										$sql = 'SELECT `id`,`title` FROM `news` ORDER BY `id` DESC ';
										$sql = mysqli_query($mysqli, $sql);
										while ($row = mysqli_fetch_assoc($sql)){
											echo	
												'<tr><td>' . $row['title'] . '</td><td><input type="checkbox" name="check[' . $row['id'] . ']"></td>';
										}
									?>									
									<tr><td colspan="2"><input type="submit" /></td></tr>
								</table>
								<input type="hidden" name="act" value="delete" />
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
			exit;
		break;
	}
?>
