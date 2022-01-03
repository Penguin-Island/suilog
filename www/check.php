<?php
session_start();
require(__DIR__ . '/dbconnect.php');

if (isset($_SESSION['id']) && ($_SESSION['time'] + 3600) > time()) {
	//ログインしている
	$_SESSION['time'] = time();

	$stmt = $db->prepare('SELECT * FROM users WHERE id=?', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->bindValue(1, $_SESSION['id']);
	$stmt->execute();
	$result = $stmt->fetch();
} else {
	//ログインしていない
	header('Location: login.php');
	exit;
}
?>