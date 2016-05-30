<?php
error_reporting(0);
require("/var/www/html/Dfun/Function/ClassAttendFunction/ClassAttendDB.php");
$ClassAttendDB=new ClassAttendDB();
if($_POST["tikoku"]){
$ClassAttendDB->Being_late("0K01001",3);}
?>
<html>
<body>
<form method="post" acjtion="">
  <input type="submit" name="jiko" value="jiko">
  <input type="submit" name="tikoku" value="tikoku">
  <input type="submit" name="tien" value="tien">

</form>
</body>
</html>
