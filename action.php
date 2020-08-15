<?php
session_start();
if(!empty($_POST['action'] && $_POST['action'] !== 'exit')){
	$dbh = new PDO('mysql:host=localhost;dbname=test_php',
		'test_user','123456789');
}

if($_POST['action'] === 'auth'){
	$query = $dbh->prepare("SELECT `login`, `pass`,`fio` FROM `users` WHERE login = ?");
	$query->bindParam(1, $_POST['login']);
	$query->execute();
	['login' => $login,'pass' => $hash,'fio'=>$fio] = $query->fetch(PDO::FETCH_ASSOC);
	$dbh = null;

	if ($hash && password_verify($_POST['pass'], $hash)) {
		$_SESSION['username'] = $login;
		$_SESSION['fio'] = $fio;
		header('location: index.php');
	}
	else {
		header('Location:index.php?fail=auth');
	}


}
if($_POST['action'] === 'register'){
	$query = $dbh->prepare(
		"INSERT INTO `users` (`login`,`pass`,`email`,`fio`) VALUES (:login, :pass,:email,:fio)"
	);
	$password_hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);

	$query->execute([
		'login' => $_POST['login'],
		'pass' => $password_hash,
		'email' => $_POST['email'],
		'fio' => $_POST['fio']
	]);
	if($query){
		header("Location: index.php?success=register");
	}

}
if($_POST['action'] === 'changeData'){
	$query = $dbh->prepare("SELECT `id` FROM `users` WHERE `login` = ?");
	$login = $_POST['login'];
	$query->bindParam(1,$_POST['login']);
	$query->execute();
	$id = $query->fetchColumn();

	$fields = "`fio` = :fio";
	$values = [
		'fio'=> $_POST['fio'],
		'id' => $id
	];
 	if(!empty($_POST['pass'])){
		$password_hash = password_hash($_POST['pass'],PASSWORD_DEFAULT);
		$fields .= ", `pass` = :pass";
		$values['pass'] = $password_hash;
	}
	$sql = "UPDATE `users` SET $fields WHERE `id` = :id";
	$query = $dbh->prepare($sql);
	$query->execute($values);
	if($query){
		$_SESSION['fio'] = $_POST['fio'];
		header('Location: index.php?success=changed');
	}


}
if($_POST['action'] === 'exit'){
	session_destroy();
	header('Location: index.php');
}