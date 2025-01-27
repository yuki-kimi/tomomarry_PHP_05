<?php

session_start();
include('functions.php');
check_session_id();

// POSTパラメータが存在し、空でないことを確認
if (
  !isset($_POST['family_name']) || $_POST['family_name'] === '' ||
  !isset($_POST['first_name']) || $_POST['first_name'] === '' ||
  !isset($_POST['email_address']) || $_POST['email_address'] === '' ||
  !isset($_POST['password']) || $_POST['password'] === ''
) {
  exit('paramError');
}

// POSTされたデータを変数に格納
$family_name = $_POST['family_name'];
$first_name = $_POST['first_name'];
$email_address = $_POST['email_address'];
$password = $_POST['password'];
$is_admin = 0;  // 例: デフォルトで一般ユーザーに設定

//DB接続
$pdo = connect_to_db();

// SQLクエリ
// $sql = 'INSERT INTO users_table(id, username, password, is_admin, created_at, updated_at,	deleted_at) VALUES(NULL, :username, :password, now(), now())';
$sql = 'INSERT INTO profile_initial_table(user_id, family_name, first_name, email_address, is_admin, password, created_at, deleted_at) 
         VALUES(NULL, :family_name, :first_name, :email_address, :is_admin, :password, now(), NULL)';

// SQL実行の準備
$stmt = $pdo->prepare($sql);

// 変数をバインド
$stmt->bindValue(':family_name', $family_name, PDO::PARAM_STR);
$stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
$stmt->bindValue(':email_address', $email_address, PDO::PARAM_STR);
$stmt->bindValue(':is_admin', $is_admin, PDO::PARAM_INT);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
  // SQLの実行
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// 成功した場合、リダイレクト
header("Location:profile_read.php");
exit();

?>