<?php

// セッション開始
session_start();
include('functions.php');
check_session_id();

// var_dump($_SESSION['user_id']); 
// exit();


// POSTデータ確認
if (
    !isset($_SESSION['user_id']) || $_SESSION['user_id'] === '' ||
    !isset($_POST['family_comment_01']) || $_POST['family_comment_01'] === ''
  ) 
  {
    var_dump($_SESSION); 
    var_dump($_POST); 
  exit('データがありません');
}

// データベース接続を確立
$pdo = connect_to_db(); // ここで $pdo にデータベース接続を格納

// SQL文を作成して実行準備
$sql = 'INSERT INTO profile_familyvalue_table (user_id, family_comment_01) VALUES (:user_id, :family_comment_01)';

try {
    // SQLの準備
    $stmt = $pdo->prepare($sql);
    if ($stmt === false) {
        throw new Exception("SQLの準備に失敗しました");
    }

    // バインドパラメータ
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindValue(':family_comment_01', $_POST['family_comment_01'], PDO::PARAM_STR);

    // SQL実行
    $status = $stmt->execute();
    
    if (!$status) {
        throw new Exception("SQL実行に失敗しました");
    }

    // リダイレクト
    header('Location: profile_familyvalue_read.php');
    exit();

} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

// // バインドパラメータ
//   $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
//   $stmt->bindValue(':family_comment_01', $_POST['family_comment_01'], PDO::PARAM_STR);

// // SQL実行（実行に失敗すると `sql error ...` が出力される）
// try {
//     $status = $stmt->execute();
//   } catch (PDOException $e) {
//     echo json_encode(["sql error" => "{$e->getMessage()}"]);
//     exit();
//   }


  
//   // SQL実行の処理
  
//   header('Location:profile_read.php');
//   exit();
  




