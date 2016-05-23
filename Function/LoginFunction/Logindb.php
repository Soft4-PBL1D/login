<?php
 function Password(){
   error_reporting(E_ALL ^ E_NOTICE);
   session_start();
  //  session_regenerate_id(true);
  $password=$_SESSION["PASSWORD"];
  $userid=$_SESSION["USERID"];
   $pass=$_POST["password"];
  //  echo $password."<br>".$userid;
  //  パスワードを変更済みなら以降変更不可
   if($password!=SHA1($userid)){
    //  echo $password."<br>".sha1($userid);
     //no SHA1
     //  if(strstr($password,$pass)){
    //  Jamp();
     if($_SESSION["TYPE"]==1):
       header("Location:teacher.php");
       exit;
   endif;
      if($_SESSION["TYPE"]==0):
        // echo "2";
        // echo $userid;
      header("Location:students.php");
      exit;
    endif;
   }
  //パスワード変更ボタンを押されたら実行
  if(isset($_POST["passcheck"])){
    if(($pass!=null)&&!strstr($password,$userid)){
    // if(($pass!=null)&&($userid==$password)){
    // passcheck
    // $ パスワードは６文字以上１０文字以下
      if(mb_strlen($pass)<6 ||mb_strlen($pass)>10):
        $message.="<br>パスワード６文字以上10文字以下を入力してください<br>";
        return $message;
        // exit;
      endif;
      if(strstr(SHA1($pass),$password)):
        // no SHA
        // if(strstr($pass,$password)):
        $message.="<br>IDと違うパスワードを入力してください";
        return $message;
        // exit;
        endif;
      if(!strstr($pass,$_POST["passwordcheck"])):
        $message.="<br>パスワードが一致していません";
        return $message;
      endif;
  // type check
    if($userid=="teacher"){
      $type=1;
    }else{
      $type=0;
    }
    try{
      $pdo= new PDO('mysql:host=localhost;dbname=Users;charset=utf8','root','root',
      array(PDO::ATTR_EMULATE_PREPARES=>false));
      $sql="update UserTable set UserId=?,Password=SHA1(?),Type=? where userId=?;";
      // no SHA
      // $sql="update UserTable set UserId=?,Password=?,Type=? where userId=?;";
      $stmt=$pdo->prepare($sql);
      $stmt->execute(array($userid,$pass,$type,$userid));
      // $stmt->execute(array($userid,$pass,$type,$userid));
      $sql="select * from UserTable where userId=?";
      $stmt=$pdo->prepare($sql);
      $stmt->execute(array($userid));
      while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
        $user[0]=$kari[UserId];
        $user[1]=$kari[Password];
        $user[2]=$kari[Type];
        $user[3]=$kari[Name];
        // session_destroy();
        // session_regenerate_id(TRUE);
        $_SESSION["USERID"] = $user[0];
        $_SESSION["TYPE"]=$user[2];
        $_SESSION["NAME"]=$user[3];
        $_SESSION["PASSWORD"]=$user[1];
      }
  } catch (PDOException $e) {
      exit('database session error。'.$e->getMessage());
      $errorMessage="database error";
    }
      // return $message;
      if($_SESSION["TYPE"]==1):
        echo "パスワードを変更しました\n";
      header("Refresh:2;URL=teacher.php");
    endif;
      if($_SESSION["TYPE"]==0):
        echo "パスワードを変更しました\n";
        header("Refresh:2;URL=students.php");

      endif;
    }else
      return $comment="<br>パスワード６文字以上10文字以下を入力してください<br>";;
    }
//
    }

function Logout(){
  error_reporting(E_ALL ^ E_NOTICE);
  session_start();
  session_regenerate_id(true);
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
  //データーベースにない場合のエラーメッセージ
      // db session
      if($_SESSION["TYPE"]=="1"){
        header("Location:teacher.php");
        exit;
      }
      if($_SESSION["TYPE"]=="0"){
        header("Location:students.php");
        exit;
      }
    if(isset($_POST["login"])&&isset($_POST["userid"])&&isset($_POST["password"])&&$_POST["password"]!=null){
      try{
        $pdo= new PDO('mysql:host=localhost;dbname=Users;charset=utf8','root','root',
        array(PDO::ATTR_EMULATE_PREPARES=>false));
        //  SHA1で暗号化したpasswordを抽出
        // $sql="select SHA1(?)";
        // $stmt=$pdo->prepare($sql);
        // $stmt->execute(array($_POST['password']));
        // if($passwd=$stmt->fetch(PDO::FETCH_ASSOC)){
            // $sha=$passwd["password"];
            // echo $sha;
            // echo "aho";
          // }
          // 抽出したものpasswordよりselect文を実行
        $sql="select * from UserTable where UserId=? and Password like ?";
        $stmt=$pdo->prepare($sql);
        $stmt->execute(array($_POST['userid'],sha1($_POST["password"])));
        while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
      //    session_regenerate_id(TRUE);
        $user[0]=$kari[UserId];
        $user[1]=$kari[Password];
        $user[2]=$kari[Type];
        $user[3]=$kari[Name];
        session_regenerate_id(true);
        $_SESSION["USERID"] = $user[0];
        $_SESSION["TYPE"]=$user[2];
        $_SESSION["NAME"]=$user[3];
        $_SESSION["PASSWORD"]=$user[1];
        // echo $_SESSSION["PASSWORD"];
       if(strstr(SHA1($_SESSION["USERID"]),$_SESSION["PASSWORD"])){
        header("Location:password.php");
        exit;
        // echo SHA1($_SESSION["USERID"])."<br>";
        // echo $_SESSION["PASSWORD"];
      }
        if($_SESSION["TYPE"]=="1"){
          header("Location:teacher.php");
          exit;
        }
          if($_SESSION["TYPE"]=="0"){
            // echo $user[1];
            header("Location:students.php");
            exit;
          }
          // echo SHA1($_SESSION["USERID"])."<br>";
          // echo $_SESSION["PASSWORD"];
      }
      } catch (PDOException $e) {
        exit('database session error。'.$e->getMessage());
        $errorMessage="database error";
      }
    //データーベースにない場合のエラーメッセージ
  }
    if($_POST["login"]){
      // if($_POST["password"]!=$_SESSION["PASSWORD"]||$_POST["userid"]!=$_SESSION["USERID"]){
      $errorMessage="パスワードまたはID miss";
      if($_POST["userid"]==null||$_POST["password"]=null){
        $errorMessage="パスワードまたはIDが入力されていません";
      }
      return $errorMessage;
    }
}


?>
