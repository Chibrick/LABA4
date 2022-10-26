<?php 
	#Режим работы
	set_time_limit(10);
	error_reporting(E_ALL);
	ignore_user_abort(false);

	#Пути
	//$_SERVER['DOCUMENT_ROOT'] ['SERVER_NAME'] ['HTTP_HOST']
	//Следует заменить пути при необходимости
	$dir = $_SERVER['DOCUMENT_ROOT'] . '/laba4';
	$www = 'http://' . $_SERVER['HTTP_HOST'] . '/laba4';

	session_start();

	#БД
	$server = 'localhost';
	$user = 'root';
	$password = '';
	$database = 'myfirstnewsblogsite';

	$mysqli = new mysqli($server, $user, $password, $database);

	if ($mysqli -> connect_error) {
		die ('Ошибка подключения (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error);
	} 
	mysqli_set_charset($mysqli, 'utf8');


	#Пользователи(есть регистрация)
?>