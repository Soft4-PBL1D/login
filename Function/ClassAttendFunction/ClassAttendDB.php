<?php
class ClassAttendDB {
      function construct($host,$user,$pass,$db){
	      $this->host = $host;
	      $this->user = $user;
	      $this->pass = $pass;
	      $this->db = $db;
	      $this->dsn = "mysql:dbname=$db;$host=$host";
        // $this->date=date("H:i:s");//nowtime
        // $this->date=date("10:47:45");
        $this->onegen=date("09:20:59");//1time
        $this->twogen=date("10:20:59");//2time
        $this->threegen=date("11:20:59");//3time
        $this->fourgen=date("13:00:59");//4time
        $this->fifgen=date("14:00:59");//5time
        // 出席：0遅刻：1欠席：2就活：3病欠：4公欠：5
        $this->insert = "insert into ClassAttendTable(UserId,Date,Time,Type)values(?,?,?,?)";
        $this->attendCheck="select  * from Users.SchoolAttendTable where UserId=? and from_unixtime(Time) like ? and Type=? order by Time desc limit 1";
        $this->attendselect="select * from Users.ClassAttendTable where userId=? and Date=?  order by Type desc limit 1";
        $this->attendselecttime="select * from Users.ClassAttendTable where userId=? and Date=?";
        $this->attendupdate="update ClassAttendTable set Type=? where Time=? and Date=? and UserId=? and Type=0";
        }
        function sampleData($toukouTime,$gekouTime,$userId){
          $this->toukouTime=$toukouTime;
          $this->gekouTime=$gekouTime;
          $this->userId=$userId;
          if($this->toukouTime>date("09:20:59")){
          $this->Attend_insert(1,0);
          echo "tikoku";}
          if($this->toukouTime<date("09:19:59")){
          $this->Attend_insert(0,0);
          echo "attend";}
          if($this->gekouTime<date("14:49:59")){
          $this->Attend_insert(2,1);
          echo "soutai";}
          if($this->gekouTime>date("14:50:59")){
          $this->Attend_insert(0,1);
          echo "kitaku";}
        }

        //出欠状況の表示
        function Attend_select($userId,$Date){
          $this->construct("localhost","root","root","Users");
          $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
          $stmt = $pdo->prepare($this->attendselect);
          $stmt->execute(array($userId,$Date));
          while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
            $this->userid=$kari[UserId];
            $this->type=$kari[Type];
                    }
        }
        //各時間の出席状況を取得
        function Attend_select_time($userId,$Date){
          $this->construct("localhost","root","root","Users");
          $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
          $stmt = $pdo->prepare($this->attendselecttime);
          $stmt->execute(array($userId,$Date));
          $i=1;
          while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
            $this->time[$i]=$kari[Time];
            $this->type[$i]=$kari[Type];
            $i=$i+1;
        }
      }
        //登下校時間の取得
        function Attend_check($userId,$Time){
          $this->construct("localhost","root","root","Users");
          $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
            // $stmt = $pdo->prepare($this->attendCheck);
            $stmt=$pdo->prepare($this->attendCheck);
            $stmt->execute(array($userId,"$Time%","0"));
            while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
              $this->userid=$kari["UserId"];
              $toukou=$kari["Time"];
              $this->toukou=date("H:i:s",$toukou);
            }
            $stmt->execute(array($userId,"$Time%","1"));
            while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
              $gekou=$kari["Time"];
              $this->gekou=date("H:i:s",$gekou);
              $this->gekoudate=date("Y-m-d",$gekou);
            }
            // return array($user,$toukou,$gekou);
          }

        //出席、遅刻、早退、下校処理
        function Attend_insert($Type,$check){
          // $check=0ha tikoku 1 ha soutai
          // $testtoukou=$this->toukouTime;
          // $testgekou=$this->gekouTime;
          $this->construct("localhost","root","root","Users");
          $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
          $stmt = $pdo->prepare($this->insert);
          //kimasita
          if($check==0){
          if($this->toukou<$this->onegen)
          // if($testtoukou<$this->onegen)
          $stmt->execute(array($this->userid,date("Y-m-d"),1,0));
          else
          $stmt->execute(array($this->userid,date("Y-m-d"),1,$Type));

          if($this->toukou<$this->twogen)
          // if($testtoukou<$this->twogen)
          $stmt->execute(array($this->userid,date("Y-m-d"),2,0));
          else
          $stmt->execute(array($this->userid,date("Y-m-d"),2,$Type));

          if($this->toukou<$this->threegen)
          // if($testtoukou<$this->threegen)
          $stmt->execute(array($this->userid,date("Y-m-d"),3,0));
          else
          $stmt->execute(array($this->userid,date("Y-m-d"),3,$Type));

          if($this->toukou<$this->fourgen)
          // if($testtoukou<$this->fourgen)
          $stmt->execute(array($this->userid,date("Y-m-d"),4,0));
          else
          $stmt->execute(array($this->userid,date("Y-m-d"),4,$Type));

          if($this->toukou<$this->fifgen)
          // if($testtoukou<$this->fifgen)
          $stmt->execute(array($this->userid,date("Y-m-d"),5,0));
          else
          $stmt->execute(array($this->userid,date("Y-m-d"),5,$Type));

          }
          //kaeru
          if($check==1){
            $stmt=$pdo->prepare($this->attendupdate);
            if($this->gekou<date("10:09:59"))
            // if($testgekou<date("10:09:59"))
              $stmt->execute(array($Type,1,$this->gekoudate,$this->userid));
            if($this->gekou<date("11:09:59"))
            // if($testgekou<date("11:09:59"))
              $stmt->execute(array($Type,2,$this->gekoudate,$this->userid));

            if($this->gekou<date("12:09:59"))
            // if($testgekou<date("12:09:59"))
              $stmt->execute(array($Type,3,$this->gekoudate,$this->userid));

            if($this->gekou<date("13:49:59"))
            // if($testgekou<date("13:49:59"))
              $stmt->execute(array($Type,4,$this->gekoudate,$this->userid));

            if($this->gekou<date("14:49:59"))
            // if($testgekou<date("14:49:59"))
              $stmt->execute(array($Type,5,$this->gekoudate,$this->userid));
            }
          }


}
?>
