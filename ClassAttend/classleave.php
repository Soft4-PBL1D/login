<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
</head>
<body>
  <?php
  error_reporting(0);
  session_start();
  require("/var/www/html/liliq/Function/ClassAttendFunction/ClassAttendDB.php");
      $ClassAttendDB=new ClassAttendDB();
      $ClassAttendDB->Attendance_Check($_SESSION["USERID"]);
      $ClassAttendDB->Attendance_School($_SESSION["USERID"]);
      $ClassAttendDB->AttendUpdate($_GET["id"],$_SESSION["USERID"],2);
      header("Location:/liliq/design/wait.php");
      ?>

</body>
</html>
