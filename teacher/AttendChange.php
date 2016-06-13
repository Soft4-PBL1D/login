<?php
//申請の許可及び拒否処理
require("/var/www/html/liliq/Function/ClassAttendFunction/ClassAttendDB.php");
$Cl=new ClassAttendDB();
$Cl->TacherChange($_GET["Id"],$_GET["Type"],$_GET["i"],$_GET["Date"]);
header("Location:AttendCheck.php");
?>
