<?php

// like_create.php
session_start();
include('functions.php');
check_session_id();

// GETパラメータからいいねを送ったユーザー（ログイン）といいねを送った対象ユーザーのIDを受け取る
if (isset($_GET['sender_id']) && isset($_GET['receiver_id'])) {
  $sender_id = $_GET['sender_id'];  // ログインしているユーザーのID（sender）
  $receiver_id = $_GET['receiver_id'];  // いいねを送る相手のユーザーID（receiver）
} else {
  // GETパラメータがない場合はエラーメッセージを出力
  echo "Error: sender_id or receiver_id not provided.";
  exit();
}

// var_dump($sender_id); // ここでsender_idの確認
// exit();

$pdo = connect_to_db();

// まず、sender_id と receiver_id のペアで「いいね」がすでに存在するか確認する
$sql = 'SELECT COUNT(*) FROM like_table WHERE sender_id=:sender_id AND receiver_id=:receiver_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':sender_id', $sender_id, PDO::PARAM_INT);  // sender_idをバインド
$stmt->bindValue(':receiver_id', $receiver_id, PDO::PARAM_INT);  // receiver_idをバインド

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// like_countを取得
$like_count = $stmt->fetchColumn();

// いいねされている状態（すでに「いいね」をしている場合）
if ($like_count !== 0) {
  $sql = 'DELETE FROM like_table WHERE sender_id=:sender_id AND receiver_id=:receiver_id';
} else {
  // いいねされていない状態（まだ「いいね」をしていない場合）
  $sql = 'INSERT INTO like_table (id, sender_id, receiver_id, created_at) VALUES (NULL, :sender_id, :receiver_id, now())';
}

// 再度SQLクエリの準備
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':sender_id', $sender_id, PDO::PARAM_INT);  // sender_idをバインド
$stmt->bindValue(':receiver_id', $receiver_id, PDO::PARAM_INT);  // receiver_idをバインド

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:profile_read.php");
exit();

?>