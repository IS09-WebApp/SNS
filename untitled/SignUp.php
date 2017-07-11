<?php
require 'password.php';
session_start();

$db['host'] = "localhost";
$db['user'] = "root";
$db['pass'] = "";
$db['dbname'] = "db1";
//エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$singUpMessage = "";

if (isset($_POST["singUp"])) {
    if
}