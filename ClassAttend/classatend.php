<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
</head>
<body>
  <?php
  error_reporting(0);
      require("/var/www/html/Dfun/Function/ClassAttendFunction/ClassAttendDB.php");
      require("/var/www/html/Dfun/Function/SchoolAttendFunction/SchoolAttend.php");
      $ClassAttendDB=new ClassAttendDB();
        // 登下校時間の取得
        $ClassAttendDB->Attend_check("0K01001",date("Y-m-d"));
        // 出席処理
        $ClassAttendDB->Attend_insert($_GET["id"],0);
        header("Location:/Dfun/design/wait.php");
        ?>
</body>
</html>
