<?php
require("../Function/LoginFunction/Logindb.php");
$errorMessage=Login();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
  <form id="loginForm" name="loginForm" action="<?php print($_SERVER['PHP_SELF']) ?>" method="POST">
  <!-- <fieldset> -->
  <!-- <legend>Loginform</legend> -->

<div id="box">

<img src="../design/img/logo.png" style="display:block;width:170px;height:48px;margin:70px 0 70px 110px;" alt="LILIQ">

<input type="text" id="userid" name="userid" style="margin-left:48px;" placeholder=" ユーザーID" value="<?php echo $viewUserId ?>">
  <br><br>
<input type="password" id="password" name="password" style="margin-left:48px; placeholder=" パスワード" value="">
  <br>
  <input type="submit" id="login" name="login" value="Login" style="margin-left:48px;margin-top:60px;width:303px;height:40px;border:1px solid #ccc;">
  <!-- </fieldset> -->
  </form>

    <div style="color:#f00;margin-left:48px;margin-top:20px;"><?php echo $errorMessage ?></div>
</div>



  </body>
</html>
