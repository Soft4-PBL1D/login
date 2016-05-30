<?php
function yesterdayCheack(){
require("../Function/SchoolAttendFunction/SchoolAttend.php");
// date("Y-m-d :H:i:s",time());
list($Type,$Time)=Attendance_Cheack();

if($Type==0){
  try{
    $pdo=new PDO("mysql:host=localhost;dbname=Users;charset=utf8","root","root",
    array(PDO::ATTR_EMULATE_PREPARES=>false));
    if(!$pdo){$message="error";}
//下校済みかcheak
    $sql="update SchoolAttendTable set Type=0 where Type=1;";
    // $stmt=$pdo->prepare($sql);
    // $stmt->execute(array("0","1"));
    $pdo->query($sql);
    }catch (PDOException $e) {
      exit('database session error。'.$e->getMessage());
      $errorMessage="database error";
          }

}
}
yesterdayCheack();
?>
