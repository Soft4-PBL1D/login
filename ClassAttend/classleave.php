<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
</head>
<body>
  <?php
  error_reporting(0);
<<<<<<< HEAD
  session_start();
  require("/var/www/html/liliq/Function/ClassAttendFunction/ClassAttendDB.php");
      $ClassAttendDB=new ClassAttendDB();
      $ClassAttendDB->Attendance_Check($_SESSION["USERID"]);
      $ClassAttendDB->Attendance_School($_SESSION["USERID"]);
      $ClassAttendDB->AttendUpdate($_GET["id"],$_SESSION["USERID"],2);
      header("Location:/liliq/design/wait.php");
      ?>

=======
  require("/var/www/html/Dfun/Function/ClassAttendFunction/ClassAttendDB.php");
  require("/var/www/html/Dfun/Function/SchoolAttendFunction/SchoolAttend.php");
      $ClassAttendDB=new ClassAttendDB();
      // 登下校時間の取得
        $ClassAttendDB->Attend_check("0K01001",date("Y-m-d"));
        echo $ClassAttendDB->toukou;
        //下校処
        $ClassAttendDB->Attend_insert($_GET["id"],1);
        // echo $ClassAttendDB->testtoukou;
        header("Location:/Dfun/design/wait.php");
  ?>
>>>>>>> a6df07e9a511764ca2d4c2b357cde93e1b05fb25
</body>
</html>
