<?php
session_start();

$user_id = $_SESSION['user_id'] ?? null;

// ユーザーIDがセッションにない場合、エラーメッセージを表示して終了
if ($user_id === null) {
    echo "Error: User not logged in.";
    exit();  // ログインしていない場合はここで処理を終了
}

include("functions.php");
check_session_id();

$pdo = connect_to_db();

// SQL文を修正して、ログインユーザーのプロフィールのみ取得
$sql = 'SELECT * FROM profile_table WHERE user_id = :user_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT); // プレースホルダに値をバインド
try {
    $stmt->execute();
    $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}


// 出力内容を生成
$output = "";
foreach ($profiles as $record) {
    $img = "data:image/jpeg;base64," . base64_encode($record["profile_photo"]);
    $output .= "
        <div class='card'>
            <div><img src='$img' alt='' class='profile_img'></div>
        </div>
    ";
}
// if ($_SESSION["is_admin"] == 1) {
//  $is_admin_link = '<a href="admin.php">管理者ページ</a>';
// } else {
//   $is_admin_link = '';
// }

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マイページ</title>
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
    <legend><?= $_SESSION['first_name']?>さんのマイページ</legend>
    <!-- <a href="profile_input.php" class="button_edit">プロフィール編集ページ</a> -->
  <main>
        <!-- 1カセット目: 自身のプロフィール写真 -->
        <section class="profile-photo-section">
            <div class="profile-photo">
            <?= $output ?>
            </div>
            <div>プロフィール編集</div>
            <div class="buttons">
                <a href="profile_input.php" class="btn">基本プロフィール</a>
                <a href="profile_familyvalue_read.php" class="btn">家族観ノート</a>
            </div>
        </section>
        <section class="footprint-section">
            <button class="btn">足あとを見る</button>
            <button class="btn">いいね履歴を見る</button>
        </section>
        <a href="profile_logout.php" class="button_logout">ログアウト</a>
    </main>
</body>

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

 /* ボタンのデザイン */
a.button_edit {
      display: inline-block;
      padding: 12px 25px;
      margin: 10px;
      background-color:rgb(210, 117, 58);
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-size: 1.2em;
      text-align: center;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

a.button_logout {
      display: inline-block;
      padding: 12px 25px;
      margin: 10px;
      background-color:rgb(122, 119, 119);
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-size: 1.2em;
      text-align: center;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

a.button_edit:hover {
      background-color:rgb(220, 143, 95);
    }

a.button_logout:hover {
      background-color:rgb(230, 223, 223);
    }


main {
    max-width: 700px;
    margin: 0 auto;
}

legend{
  padding-top: 20px;
}

section {
    margin-bottom: 30px;
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

section h2 {
    margin-bottom: 15px;
    font-size: 1.2rem;
    color: rgb(210, 117, 58);
}

/* プロフィール写真 */
.profile-photo {
    width: 150px; /* 円の幅 */
    height: 150px; /* 円の高さ */
    margin: 0 auto; /* 中央揃え */
    border-radius: 50%; /* 円形にする */
    overflow: hidden; /* 円形以外を隠す */
    border: 1px solid rgb(169, 161, 155); /* 外枠 */
    display: flex; /* 子要素を中央揃えにするための設定 */
    justify-content: center; /* 水平方向の中央揃え */
    align-items: center; /* 垂直方向の中央揃え */
    background-color:rgb(244, 242, 230); /* 背景色（任意） */
}

.profile-photo img {
    width: 100%; /* 画像の幅を親要素に合わせる */
    height: auto; /* 高さを自動調整 */
    object-fit: cover; /* 画像を中央で切り抜く */
    display: block; /* 画像をインライン要素からブロック要素にする */
}

/* ボタン */
.btn {
    display: inline-block;
    padding: 10px 20px;
    margin: 5px;
    font-size: 1rem;
    color: white;
    text-decoration: none;
    background-color: rgb(210, 117, 58);
    border: 1px solid rgb(200, 100, 50);
    border-radius: 25px;
    transition: background-color 0.3s ease, opacity 0.3s ease;
    cursor: pointer;
}

.btn:hover {
    background-color: rgb(200, 100, 50);
    opacity: 0.9;
}

.btn:disabled {
    background-color: #ccc;
    border-color: #aaa;
    cursor: not-allowed;
}

/* 足あとボタンといいね履歴ボタンの特別スタイル */
.footprint-section .btn,
.like-history-section .btn {
    width: 50%;
    margin: 10px auto;
    display: block;
}

</style>

</html>