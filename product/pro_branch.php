<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['kaiin']) || $_SESSION['kaiin']['login'] != 1) {
	print 'ログインされていません。';
	print '<a href="../kaiin_login/kaiin_login.html">ログイン画面へ</a>';
	exit();
}

if (isset($_POST['add']) == true) {
	header('Location:pro_add.php');
}

if (isset($_POST['disp']) == true) {
	if (isset($_POST['pro_code']) == false) {
		header('Location:pro_ng.php');
	} else {
		$pro_code = $_POST['pro_code'];
		header('Location:pro_disp.php?pro_code=' . $pro_code);
	}
}

$kaiin_code = $_POST['kaiin_code'];

if (isset($_POST['edit']) == true) {
	if (isset($_POST['pro_code']) == false) {
		header('Location:pro_ng.php');
	} else {
		$pro_code = $_POST['pro_code'];
		header('Location:pro_edit.php?pro_code=' . $pro_code . '&kaiin_code=' . $kaiin_code);
	}
}

if (isset($_POST['delete']) == true) {
	if (isset($_POST['pro_code']) == false) {
		header('Location:pro_ng.php');
	} else {
		$pro_code = $_POST['pro_code'];
		header('Location:pro_delete.php?pro_code=' . $pro_code . '&kaiin_code=' . $kaiin_code);
	}
}

?>