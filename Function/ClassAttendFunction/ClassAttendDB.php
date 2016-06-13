<?php
class ClassAttendDB {
      function construct($host,$user,$pass,$db){
	      $this->host = $host;
	      $this->user = $user;
	      $this->pass = $pass;
	      $this->db = $db;
	      $this->dsn = "mysql:dbname=$db;$host=$host";
        $this->onegen=date("09:20:00");//1time
        $this->twogen=date("10:20:00");//2time
        $this->threegen=date("11:20:00");//3time
        $this->fourgen=date("13:00:00");//4time
        $this->fifgen=date("14:00:00");//5time
        // 出席：0遅刻：1欠席：2就活：3病欠：4公欠：5

        }
        function NameSelect($UserId){
          error_reporting(E_ALL ^ E_NOTICE);
          // DBの選択
          $this->construct("localhost","root","root","Users");
          $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
          // 登校ならtype=1　初回登録ならnull 下校ならType=0をかえす
          $sql="select * from UserTable where UserId=?;";
          $stmt=$pdo->prepare($sql);
          $stmt->execute(array($UserId));
          while($data=$stmt->fetch(PDO::FETCH_ASSOC)){
            // echo "boke";
                $this->Name=$data[Name];//1 or 0

              }
            }

      //登校処理をするか下校処理をするかの判別
        function Attendance_Check($userId){
          error_reporting(E_ALL ^ E_NOTICE);
          // DBの選択
          $this->construct("localhost","root","root","Users");
          $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
          // 登校ならtype=1　初回登録ならnull 下校ならType=0をかえす
          $sql="select * from SchoolAttendTable where UserId=? and from_unixtime(Time) like ? order by Time desc limit 1;";
          $stmt=$pdo->prepare($sql);
          $stmt->execute(array($userId,date("Y-m-d")."%"));
          foreach($stmt as $data){
                $this->Type=$data[Type];//1 or 0
              }
            }

      //登校または下校をデーターベースに登録する
        function Attendance_School($userId){
          error_reporting(E_ALL ^ E_NOTICE);
          session_start();
          $type=$this->Type;
          // DBの選択
          $this->construct("localhost","root","root","Users");
          $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
            //登校処理
            if($type==1 || $type==null){
              $sql="insert into SchoolAttendTable(UserId,Time,Type,Checking)values(?,?,?,?);";
              $stmt=$pdo->prepare($sql);
              $stmt->execute(array($userId,time(),0,0));
            }
            // 下校処理
            else{
              $sql="insert into SchoolAttendTable(UserId,Time,Type,Checking)values(?,?,?,?);";
              $stmt=$pdo->prepare($sql);
              $stmt->execute(array($userId,time(),1,1));
            }
        }

        //当日の投稿時間、下校時間の抽出
        function AttendTime(){
            $attendtime="select  * from SchoolDayTable where Date= ?";
            $this->construct("localhost","root","root","Users");
            $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
              PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
              $stmt = $pdo->prepare($attendtime);
              $stmt->execute(array(date("Y-m-d")));
              while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
                $this->start=$kari[SchoolStartTime];
                $this->end=$kari[SchoolEndTime];
              }
            }
            //遅刻処理、早退処理、出欠処理、下校処理　Type=8は登校前

        //各日の出席、欠席の登録（下校時に処理）0は正常処理1は早退や遅刻
        function AttendUpdate($Type,$UserId,$check){
          $this->construct("localhost","root","root","Users");
          $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
          //各自の投稿した時間を抽出
          $select="select Time from SchoolAttendTable where UserId=? and from_unixtime(Time) like ? and Type=0 order by Time desc limit 1;";
          $stmt=$pdo->prepare($select);
          $stmt->execute(array($UserId,date("Y-m-d")."%"));
          while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
            $attend[0]=$kari[Time];
          }
          // 下校時間した時間を抽出
          $select="select Time from SchoolAttendTable where UserId=? and from_unixtime(Time) like ?  and Type=1 order by Time desc limit 1;";
          $stmt=$pdo->prepare($select);
          $stmt->execute(array($UserId,date("Y-m-d")."%"));
          //登校時間と下校時間の抽出
          while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
            $attend[1]=$kari[Time];
          }
          $attendupdate="update ClassAttendTable set Type=? where Time=? and Date=? and UserId=? and Type=8";
          $attendupdate1="update ClassAttendTable set Type=? where Time=? and Date=? and UserId=?";
          $this->construct("localhost","root","root","Users");
          $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
            $this->AttendTime();
            //学校の登校時間
            $start=date("H:i:s",$this->start);
            //学校の下校時間
            $end=$this->end;
            //授業の開始時間が通常とは違う場合
            if($this->onegen<$start){
              $stmt = $pdo->prepare($attendupdate);
              for($i=1;$i<=1;$i++){
              $stmt->execute(array(0,$i,date("Y-m-d"),$UserId));}
            }

            if($this->twogen<$start){
              $stmt = $pdo->prepare($attendupdate);
              for($i=1;$i<=2;$i++){
              $stmt->execute(array(0,$i,date("Y-m-d"),$UserId));}
            }

            if($this->threegen<$start){
              $stmt = $pdo->prepare($attendupdate);
              for($i=1;$i<=3;$i++){
              $stmt->execute(array(0,$i,date("Y-m-d"),$UserId));}
            }

            if($this->fourgen<$start){
              $stmt = $pdo->prepare($attendupdate);
              for($i=1;$i<=4;$i++){
              $stmt->execute(array(0,$i,date("Y-m-d"),$UserId));}
            }

            if($this->fifgen<$start){
              $stmt = $pdo->prepare($attendupdate);
              for($i=1;$i<=5;$i++){
              $stmt->execute(array(0,$i,date("Y-m-d"),$UserId));}
            }
            //ココマデ
            $start=$this->start;
            //通常登校（１元）
            //遅刻
            if($check==1){
              if($start+900<$attend[0]&&$Type==1){
                $stmt = $pdo->prepare($attendupdate);
                $stmt->execute(array(2,1,date("Y-m-d"),$UserId));
              }else if($start<$attend[0]){
                $stmt = $pdo->prepare($attendupdate);
                $stmt->execute(array($Type,1,date("Y-m-d"),$UserId));
              }

              if($start+4500<$attend[0]&&$Type==1){
                  $stmt = $pdo->prepare($attendupdate);
                  $stmt->execute(array(2,2,date("Y-m-d"),$UserId));
                }
                else if($start+3600<$attend[0]){
                  $stmt = $pdo->prepare($attendupdate);
                  $stmt->execute(array($Type,2,date("Y-m-d"),$UserId));
                }
              if($start+8100<$attend[0]&&$Type==1){
                    $stmt = $pdo->prepare($attendupdate);
                    $stmt->execute(array(2,3,date("Y-m-d"),$UserId));
                    }
                    else if($start+7200<$attend[0]){
                    $stmt = $pdo->prepare($attendupdate);
                    $stmt->execute(array($Type,3,date("Y-m-d"),$UserId));
                    }
              if($start+13500<$attend[0]&&$Type==1){
                    $stmt = $pdo->prepare($attendupdate);
                    $stmt->execute(array(2,4,date("Y-m-d"),$UserId));
                  }
                  else if($start+12600<$attend[0]){
                    $stmt = $pdo->prepare($attendupdate);
                    $stmt->execute(array($Type,4,date("Y-m-d"),$UserId));
                  }
              if($start+17100<$attend[0]&&$Type==1){
                    $stmt = $pdo->prepare($attendupdate);
                    $stmt->execute(array(2,5,date("Y-m-d"),$UserId));
                }else if($start+16200<$attend[0]){
                $stmt = $pdo->prepare($attendupdate);
                $stmt->execute(array($Type,5,date("Y-m-d"),$UserId));
                }
            }

            //下校兼早退
            if($check==2){
            //１限目の出席条件
            if($start>=$attend[0]&& $start<=$attend[1]){
                $stmt = $pdo->prepare($attendupdate);
                $stmt->execute(array(0,1,date("Y-m-d"),$UserId));
              }else{//早退
                 $stmt = $pdo->prepare($attendupdate);
                 $stmt->execute(array($Type,1,date("Y-m-d"),$UserId));}
            //２限目の出席条件
            if($start+3600>=$attend[0] && $start+3600<=$attend[1]){
                 $stmt = $pdo->prepare($attendupdate);
                 $stmt->execute(array(0,2,date("Y-m-d"),$UserId));

                }else{
                 $stmt = $pdo->prepare($attendupdate);
                 $stmt->execute(array($Type,2,date("Y-m-d"),$UserId));}
            //3限目の出席条件
            if($start+7200>=$attend[0]&& $start+7200<=$attend[1]){
                 $stmt = $pdo->prepare($attendupdate);
                 $stmt->execute(array(0,3,date("Y-m-d"),$UserId));

                }else{
                  $stmt = $pdo->prepare($attendupdate);
                 $stmt->execute(array($Type,3,date("Y-m-d"),$UserId));}
            //4限目の出席条件
            if($start+11600>=$attend[0]&& $start+11600<=$attend[1]){
                 $stmt = $pdo->prepare($attendupdate);
                 $stmt->execute(array(0,4,date("Y-m-d"),$UserId));

                }else{
                  $stmt = $pdo->prepare($attendupdate);
                 $stmt->execute(array($Type,4,date("Y-m-d"),$UserId));}
            //5限目の出席条件
            if($start+15200>=$attend[0]&& $start+15200<=$attend[1]){
                 $stmt = $pdo->prepare($attendupdate);
                 $stmt->execute(array(0,5,date("Y-m-d"),$UserId));
                }else{
                  $stmt = $pdo->prepare($attendupdate);
                  $stmt->execute(array($Type,5,date("Y-m-d"),$UserId));}
                }
          }

        //出欠状況の表示
        function Attend_select($userId,$Date){
          $type=8;
          $attendselect="select * from Users.ClassAttendTable where userId=? and Date=?  order by Type desc limit 1";
          $this->construct("localhost","root","root","Users");
          $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
          $stmt = $pdo->prepare($attendselect);
          $stmt->execute(array($userId,$Date));
          while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
            $type=$kari["Type"];
                    }
          return $type;
        }

        //生徒の出席欠席の変更
        function TeacherUpdate($Type,$Time,$Date,$UserId){
          $this->construct("localhost","root","root","Users");
          $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
          $sql="update ClassAttendTable set Type=? where Time=? and Date=? and UserId=?";
          $stmt=$pdo->prepare($sql);
          $stmt->execute(array($Type,$Time,$Date,$UserId));
      }

      //当日までの登校していない生徒の抽出毎日１5時以降のみ
      function TeacherCheck(){
        $this->construct("localhost","root","root","Users");
        $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
        $sql="select c.Date,c.UserId,u.Name,c.Type from ClassAttendTable as c join UserTable as u on c.UserId=u.UserId  where c.Type in(6,7,8) and c.Date <= ?  group by UserId,Date order by Date";
        $stmt=$pdo->prepare($sql);
        $i=0;
        $stmt->execute(array(date("Y-m-d")));
        while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
        $this->userdate[$i]=$kari[Date];
          $this->userid[$i]=$kari[UserId];
          $this->username[$i]=$kari[Name];
          $this->usertype[$i]=$kari[Type];
          $i=$i+1;
        }
      }
      //認可、または拒否
      function TacherChange($UserId,$NowType,$ChangeType,$Date){
        $this->construct("localhost","root","root","Users");
        $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
        if($NowType==6){
        $sql="update ClassAttendTable set Type=? where UserId=? and Type=? and Date=?";
        $stmt=$pdo->prepare($sql);
        $stmt->execute(array($ChangeType,$UserId,6,$Date));
      }
      else if($NowType==7){
            $sql="update ClassAttendTable set Type=? where UserId=? and Type=? and Date=?";
            $stmt=$pdo->prepare($sql);
            $stmt->execute(array($ChangeType,$UserId,7,$Date));
            }
        else if($NowType==8){
            $sql="update ClassAttendTable set Type=? where UserId=? and Type=? and Date=?";
            $stmt=$pdo->prepare($sql);
            $stmt->execute(array($ChangeType,$UserId,8,$Date));
          }
      }

      function Calendar($Month){
        $this->construct("localhost","root","root","Users");
        $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
        $sql="select DATE_FORMAT(Date,'%e') from SchoolDayTable where Date like ? and SchoolDay=1";
        $stmt=$pdo->prepare($sql);
        switch ($Month) {
          case 1:$Month="01";break;case 2:$Month="02";break;
          case 3:$Month="03";break;case 4:$Month="04";break;
          case 5:$Month="05";break;case 6:$Month="06";break;
          case 7:$Month="07";break;case 8:$Month="08";break;
          case 9:$Month="09";break;}
        $stmt->execute(array(date("Y-$Month")."%"));
        $i=0;
      while($cal=$stmt->fetch(PDO::FETCH_ASSOC)){
                  $this->calendar[$cal["DATE_FORMAT(Date,'%e')"]]=$cal["DATE_FORMAT(Date,'%e')"];
                  // $i++;

      }
      }
    }




?>
