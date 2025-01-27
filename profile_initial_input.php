<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録画面</title>
</head>

<body>
  <form action="profile_initial_create.php" method="POST">
    
    <fieldset>
      <legend>新規登録画面</legend>
      <div>
      姓: <input type="text" name="family_name">
      </div>
      <div>
      名：<input type="text" name="first_name">
      </div>
      <div>
       メールアドレス: <input type="text" name="email_address">
      </div>
      <div>
       パスワード <input type="text" name="password">
      </div>
      <div>
        <button>新規登録</button>
      </div>
    </fieldset>
  </form>
</body>

</html>