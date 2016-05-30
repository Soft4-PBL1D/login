<?php
//登校ボタンか下校ボタンを表示させる
  function Attendance_Cheack(){
    error_reporting(E_ALL ^ E_NOTICE);
    session_start();
    $userId=$_SESSION["USERID"];
    if(!$_SESSION["USERID"]){
      $ip=$_SERVER["REMOTE_ADDR"];
      $ip=$_SERVER["SERVER_NAME"];
    //  return header("location: http://{$ip}/login/login.php");
    }
    $Type=""; //attend flag 1 or 0
    $message=""; //message
      try{
// DBの選択
        $pdo=new PDO("mysql:host=localhost;dbname=Users;charset=utf8","root","root",
        array(PDO::ATTR_EMULATE_PREPARES=>false));
        if(!$pdo){$message="error";}
// 登下校かcheak
        $sql="select * from SchoolAttendTable where UserId=? and Checking=? order by Time desc limit 1;";
        $stmt=$pdo->prepare($sql);
        $stmt->execute(array($userId,"0"));
        foreach($stmt as $data){
          $Type=$data["Type"];
          $time=date("Y-m-d H:i",$data["Time"]);
        }
//DB Error
      }catch (PDOException $e) {
        exit('database session error。'.$e->getMessage());
        $errorMessage="database error";
            }
      return $Type;
      }

//登校処理
function Attendance_School(){
  error_reporting(E_ALL ^ E_NOTICE);
  session_start();
  $userId=$_SESSION["USERID"];
  if(!$_SESSION["USERID"]){
    $ip=$_SERVER["REMOTE_ADDR"];
  //return header("location: http://{$ip}/login/login.php");
  }
  $Type="1"; //attend flag 1 or 0
  $message=""; //message
    try{
// DBの選択
      $pdo=new PDO("mysql:host=localhost;dbname=Users;charset=utf8","root","root",
      array(PDO::ATTR_EMULATE_PREPARES=>false));
      if(!$pdo){$message="error";}
//登校済みかcheak
      $sql="select * from SchoolAttendTable where UserId=? order by Time desc limit 1;";
      $stmt=$pdo->prepare($sql);
      $stmt->execute(array($userId));
      foreach($stmt as $data){
      $Type=$data["Type"];
      $time=date("Y-m-d H:i",$data["Time"]);
    }
//DBに投稿時間を書き込む
    if($Type=="1"||$Type=null){
        $Time=date("Y-m-d H:i:s",time()); //NowTime;
        // $sql="insert into SchoolAttendTable(UserId,Time,Type,Checking)values(?,?,?,?)";
        $sql="insert into SchoolAttendTable(UserId,Time,Type)values(?,?,0,0);";
        $stmt->execute(array($userId,time()));
        $stmt=$pdo->prepare($sql);
        // $stmt->execute(array($userId,time(),0,0));
        $message=$Time."に<br>".$userId."さん登校しました<br>";
//DBに投稿時間を書きこまれいていたら投稿時間を出力
      }
      //else if($Type==0){
        //$message=$time."に\n".$userId."さん登校済み<br>";
    //}
//DB Error
      }catch (PDOException $e) {
        exit('database session error。'.$e->getMessage());
        $errorMessage="database error";
            }
      return $message;
      }
// }

//下校処理

function Leave_School(){
  error_reporting(E_ALL ^ E_NOTICE);
  session_start();
  $userId=$_SESSION["USERID"];
  if(!$_SESSION["USERID"]){
    $ip=$_SERVER["REMOTE_ADDR"];
  //return header("location: http://{$ip}/login/login.php");
  }
  $Type="1"; //attend flag 1 or 0
  $message=""; //message
    try{
      $pdo=new PDO("mysql:host=localhost;dbname=Users;charset=utf8","root","root",
      array(PDO::ATTR_EMULATE_PREPARES=>false));
      if(!$pdo){$message="error";}
//下校済みかcheak
      $sql="select * from SchoolAttendTable where UserId=? order by Time desc limit 1;";
      $stmt=$pdo->prepare($sql);
      $stmt->execute(array($userId));
      foreach($stmt as $data){
      $Type=$data["Type"];
      $time=date("Y-m-d H:i",$data["Time"]);
    }
//DBに下校時間を書き込む
    if($Type=="0"){
        $Time=date("Y-m-d H:i:s",time()); //NowTime;
        $type=1;
        $checking=1;
        // $sql="insert into SchoolAttendTable(UserId,Time,Type,Checking)values(?,?,?,?)";
        $sql="insert into SchoolAttendTable(UserId,Time,Type,Checking)values(?,?,?,?)";
        $stmt->execute(array("0K01004",time(),$type,$checking));
        $stmt=$pdo->prepare($sql);
        // $stmt->execute(array($userId,time(),1,1));
        $message=$Time."に<br>".$userId."さん下校しました<br>";
//DBに下校時間を書きこまれいていたら下校時間を出力
      }
      // else if($Type==1){
        //$message=$time."に\n".$userId."さん下校済み<br>登校ボタンを押してください";
    //}
      }catch (PDOException $e) {
        exit('database session error。'.$e->getMessage());
        $errorMessage="database error";
            }
      return $message;
      }

?>
