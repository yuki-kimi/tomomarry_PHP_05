<?php

session_start();
include('functions.php');
check_session_id();

// DB接続
$pdo = connect_to_db();

// SQL作成&実行
$sql = 'SELECT * FROM profile_familyvalue_table';

$stmt = $pdo->prepare($sql);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = "";
foreach ($result as $record) {

$output .= "
      <div class = card>
        <div>{$record["family_comment_01"]}</div>
      </div>
  ";
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
<form action="familyvalue_create.php" method="POST"  enctype="multipart/form-data">
<fieldset>
  <legend>家族観ノート編集</legend>
    <body>
     <div class=my_familyvalue_area>
      <?= $output ?>
     </div>
    </body>


      <div>
        <label for="family_comment_01">１．将来の展望（自身のライフプラン）</label>
        <textarea name="family_comment_01" id="family_comment_01"></textarea>
      </div>
      <div>
       ２．なぜ結婚したいのか。<input type="text" name="comment">
      </div>
      <div>
       ３．いつまでに結婚したいのか。<input type="text" name="comment">
      </div>
      <div>
       ４．どんな結婚生活をしたいのか。<input type="text" name="comment">
      </div>
      <div>
       ５．居住エリア<input type="text" name="comment">
      </div>
      <div>
       ６．食事（一緒にとる：自炊/一緒にとる：外食/一緒にとる：購入/各々でとる）<input type="text" name="comment">
      </div>
      <div>
       ７．家事【現在の掃除の仕方と頻度】<input type="text" name="comment">
      </div>
      <div>
       ８．休暇【現在の休日の過ごし方】<input type="text" name="comment">
      </div>
      <div>
       ９．休暇【結婚後の希望】<input type="text" name="comment">
      </div>
      <div>
       １０．習慣（他人に変わっていると言われる習慣や、人と違うと思う習慣）<input type="text" name="comment">
      </div>
      <div>
       １１．現在の仕事の状況<input type="text" name="comment">
      </div>
      <div>
       １２．健康状態・病歴：自身の病歴<input type="text" name="comment">
      </div>
      <div>
       １３．恋愛、性活動：現在の活動状況<input type="text" name="comment">
      </div>
      <div>
       １４．恋愛、性活動：結婚後の希望<input type="text" name="comment">
      </div>
      <div>
       １５．恋愛、性活動：結婚後の性的欲求への対処<input type="text" name="comment">
      </div>
      <div>
       １６．現在の仕事の状況<input type="text" name="comment">
      </div>
      <div>
       １７．家計のやりくり（予想される金額、支払う側）<input type="text" name="comment">
      </div>
      <div>
       １８．管理方法（共通、別口座）<input type="text" name="comment">
      </div>
      <div>
       １９．家族構成<input type="text" name="comment">
      </div>
      <div>
       ２０．親族、友人、会社関係との現在の付き合い方の現状（家族旅行、冠婚葬祭、盆正月、会社イベント など）<input type="text" name="comment">
      </div>
      <div>
       ２１．親族、友人、会社関係との結婚後の付き合い方（家族旅行、冠婚葬祭、盆正月、会社イベント など）<input type="text" name="comment">
      </div>
      <div>
       ２２．戸籍について（どちらの姓になるか）<input type="text" name="comment">
      </div>
      <div>
       ２３．入籍のタイミング<input type="text" name="comment">
      </div>
      <div>
       ２４．子どもがほしいか、ほしくないか、またその理由<input type="text" name="comment">
      </div>
      <div>
       ２５．妊活：授かる方法<input type="text" name="comment">
      </div>
      <div>
       ２６．妊活：開始する時期・期間と予算<input type="text" name="comment">
      </div>
      <div>
       ２７．妊活：むずかしかった場合<input type="text" name="comment">
      </div>
      <div>
       ２８．育児の分担<input type="text" name="comment">
      </div>
      <div>
       ２９．結婚生活を守るために大切にしたいこと<input type="text" name="comment">
      </div>
      <div>
       ３０．相手に求めること（して欲しくないことなど）<input type="text" name="comment">
      </div>
      <div>
       ３１．覚書もしくは契約書（交わす、交わさない）<input type="text" name="comment">
      </div>
      <div>
        <button>登録</button>
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
  border-color: #4a90e2;
}

button {
  background-color: #4a90e2;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}

button:hover {
  background-color: #357abd;
}

</style>
</body>
</html>