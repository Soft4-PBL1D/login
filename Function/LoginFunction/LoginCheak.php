<?php

function teacherCheak(){
  session_start();
  // login_check teacherONLY
    if (!isset($_SESSION["USERID"])){
      header("Location:login.php");
      exit;
    }else if($_SESSION["TYPE"]!="1"){
      header("Location:students.php");
      exit;
    }
}
function studentsCheak(){
  session_start();
  // login_cheack
    if (!isset($_SESSION["USERID"])){
      header("Location:login.php");
      exit;
    }else if($_SESSION["TYPE"]=="1"){
      header("Location:teacher.php");
      exit;
    }
}
function Jamp(){
  error_reporting(E_ALL ^ E_NOTICE);
    session_start();
    //login->OK = main jamp
    if($_SESSION["TYPE"]==0){
      header("Location:students.php");
    exit;}
    if($_SESSION["TYPE"]==1){
        header("Location:teacher.php");
    exit;}
}
?>
