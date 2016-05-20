<?php require("../Function/LoginFunction/Logindb.php");
      require("../Function/LoginFunction/LoginCheak.php");
$comment=password();
// $redirect=Redirect();?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8">
</head>
<body>
  <form method="post" action="">
    <!-- パスワードを変更したらテキストフィールドを 隠し指定時間後トップ画面に繊維 -->
    <?php
      if(strstr(SHA1($_SESSION["USERID"]),$_SESSION["PASSWORD"])){?>
      password<input type="password" name="password">
      <input type="submit" name="passcheck" values="submit">
      <?php }
    // }else if($comment=="パスワードを変更しました\n"||$comment==null){
      // echo $comment;
      // Jamp();
    // }
    echo $comment;
?>
</body>
