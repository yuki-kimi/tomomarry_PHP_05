<?php
session_start();
include("functions.php");
check_session_id();

$pdo = connect_to_db();

$sql = 'SELECT * FROM profile_initial_table';

$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>家族観ノート編集</title>
</head>

<header>
    <nav>
      <ul>
        <li><a href="profile_read.php"><img src="img/サーチアイコン.png" alt="さがす"/></a></li>
        <li><img src="img/いいねアイコン.png" alt="いいね"/></li>
        <li><img src="img/コメントアイコン7.png" alt="コメント"/></li>
        <li><a href="mypage.php"><img src="img/履歴書アイコン6.png" alt="プロフィール入力"></a></li>
      </ul>
    </nav>
</header>

<body>
<form action="profile_familyvalue_create.php" method="POST"  enctype="multipart/form-data">
<fieldset>
      <legend>家族観ノート編集</legend>
      <div>
        <label for="family_comment_01">１．将来の展望（自身のライフプラン）</label>
        <textarea id="textarea" name="family_comment_01" rows="2" placeholder="メッセージを入力"></textarea>
      </div>
      <div>
        <button>保存</button>
      </div>
    </fieldset>
  </form>

<style>
  body{
    margin-right: auto;
    margin-left: auto;
    padding:0;
    width: 700px;
    font-size: 13px;
    color: rgba(0,0, 0, 0.7);
    font-family: 'メイリオ', Meiryo, sans-serif;
    text-align:center;
}
header{
    background-color: #fff;
    border-bottom: 1px solid #ccc;
    text-align: center;
}

nav ul {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    padding: 5px;
    list-style-type: none;
    margin: 0;
}
nav ul li {
    display: inline-block;
}
nav ul li img {
    width: 40px;
    height: auto;
    object-fit: contain;
}

form {
  width: 100%;
  padding: 20px;
  box-sizing: border-box;
}

fieldset {
  border: 1px solid #ddd;
  padding: 20px;
  margin: 0;
  border-radius: 8px;
}

legend {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 10px;
}

div {
  margin-bottom: 15px;
  text-align: left; /* 質問文を左揃えにする */
}

div label {
  font-size: 14px;
  font-weight: bold;
  display: block; /* 質問文をブロック要素にして改行 */
  margin-bottom: 5px; /* 質問文と入力フィールドの間にスペースを追加 */
}

div textarea {
  width: 100%;
  height: 100px; /* ボックスの高さを指定 */
  padding: 8px;
  font-size: 14px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  resize: vertical; /* 縦方向にリサイズ可能 */
}

div textarea:focus {
  outline: none;
  border-color:rgb(167, 159, 159);
}

button {
  background-color:rgb(210, 117, 58);
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 13px;
}

button:hover {
  background-color:rgb(167, 159, 159);
}

</style>
</body>
</html>