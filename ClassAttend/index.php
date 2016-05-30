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
        list($userId,$Date,$Time,$Type)=$ClassAttendDB->Attend_select("0K01001","2016-5-27");
        // $ClassAttendDB->Attend_select("0K01001","2016-5-27");
        echo $Date.$Type;
        ?>
        <form method="post" action="">
          <input type="text" name="userId">
          <input type="submit" name="shusseki">
        </form>
  </form>
</body>
</html>
