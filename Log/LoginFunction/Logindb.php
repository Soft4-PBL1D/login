<?php
function Logout(){
  error_reporting(E_ALL ^ E_NOTICE);
  session_start();
  if (isset($_SESSION["USERID"])) {
    $errorMessage = "Logout--";
  }
  else {
    $errorMessage = "Session_Time_out";
  }
  // sessionclear
  $_SESSION = array();
  //cukkiedestroy
  if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
      );
  }
  // sessionclear
  session_destroy();
  // return header("Refresh:5;URL=index.php");

}

function Login(){
  error_reporting(E_ALL ^ E_NOTICE);
  session_start();
  // errMS
  $errorMessage = "";
  // escappecheck
  $viewUserId = htmlspecialchars($_POST["userid"], ENT_QUOTES);
  // login_submit
  if (isset($_POST["login"])&&isset($_POST["userid"])&&isset($_POST["password"])) {
      // db session
      try{
        $pdo= new PDO('mysql:host=localhost;dbname=Users;charset=utf8','root','root',
        array(PDO::ATTR_EMULATE_PREPARES=>false));
        $sql="select * from UserTable where UserId=? and Password=?";
        $stmt=$pdo->prepare($sql);
        $stmt->execute(array($_POST['userid'],$_POST['password']));
        while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
          $user[0]=$kari[UserId];
          $user[1]=$kari[Password];
          $user[2]=$kari[Type];
          $user[3]=$kari[Name];
        }
      } catch (PDOException $e) {
          exit('database session error。'.$e->getMessage());
          $errorMessage="database error";
      }
  }
  //passwordhenshuu
  // loginOK
  if ($_POST["userid"] == $user[0] && $_POST["password"] == $user[1]) {
    // sessionID_create
    session_regenerate_id(TRUE);
    $_SESSION["USERID"] = $user[0];
    $_SESSION["TYPE"]=$user[2];
    $_SESSION["NAME"]=$user[3];
    $_SESSION["PASSWORD"]=$user[1];
    if($user[0]==$user[1]){
      header("Location:password.php");
    }
     if($_SESSION["TYPE"]=="1"){
        header("Location:teacher.php");
      exit;}
    if($_SESSION["TYPE"]=="0"){
        header("Location:students.php");
      exit;}
  }
  else if(!isset($_POST["userid"])||!isset($_POST["password"])){
     $errorMessage = "ユーザーIDまたはパスワードが入力されていません";
 }else{
   $errorMessage = "ユーザーIDまたはパスワードが間違えています";
 }
 return $errorMessage;



}



?>
