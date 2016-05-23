<?php require("../Function/LoginFunction/Logindb.php");
      require("../Function/LoginFunction/LoginCheak.php");
      $comment=password();?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8">
</head>
<body>
  <form method="post" action="">
    <!-- パスワードを変更したらテキストフィールドを 隠し指定時間後トップ画面に繊維 -->
    <?php
      if(strstr(SHA1($_SESSION["USERID"]),$_SESSION["PASSWORD"])){?>
      password<input type="password" placeholder="パスワードを入力してください" name="password"><br>
      passwordcheck<input type="password" placeholder="確認用パスワードを入力してください" name="passwordcheck">
      <input type="submit" name="passcheck" values="submit">
      <?php
    }
   echo $comment;
?>
</body>
