<?php
class ClassAttendDB {
    function construct($host,$user,$pass,$db){
	      $this->host = $host;
	      $this->user = $user;
	      $this->pass = $pass;
	      $this->db = $db;
	      $this->dsn = "mysql:dbname=$db;$host=$host";
        // $this->date=date("H:i:s");//nowtime
        $this->date=date("10:47:45");
        $this->onegen=date("09:20:59");//1time
        $this->twogen=date("10:20:59");//2time
        $this->threegen=date("11:20:59");//3time
        $this->fourgen=date("13:00:59");//4time
        $this->fifgen=date("14:00:59");//5time
        // 出席：0遅刻：1欠席：2就活：3病欠：4公欠：5
        $this->insert = "insert into ClassAttendTable(UserId,Date,Time,Type)values(?,?,?,?)";
        $this->attendCheck="select  userId,from_unixtime(Time) from Users.SchoolAttendTable where UserId=? and from_unixtime(Time) like ? and Type=? order by Time desc limit 1;";
        $this->attendselect="select * from Users.ClassAttendTable where userId=? and Date=?";
        }
        function Attend_chack($userId,$Time){
          $this->construct("localhost","root","root","Users");
          $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
          $stmt = $pdo->prepare($this->attendCheck);
          $stmt->execute(array($userId,$Time,0));
          while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
            $user=$kari["UserId"];
            $toukou=$kari["Time"];
          }
          $stmt->execute(array($userId,$Time,1));
          while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
            $gekou=$kari["Time"];
          }
        }

        function Attend_select($userId,$Date){
          $this->construct("localhost","root","root","Users");
          $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
          $stmt = $pdo->prepare($this->attendselect);
          $stmt->execute(array($userId,$Date));
          while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
            echo "aho";
            $user[0]=$kari[UserId];
            $user[1]=$kari[Date];
            $user[2]=$kari[Time];
            $user[3]=$kari[Type];
          }
          return array($user[0],$user[1],$user[2],$user[3]);
        }
//遅刻理由
    function  Being_late($userId,$Type){
        $this->construct("localhost","root","root","Users");
        $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
        $stmt = $pdo->prepare($this->insert);
        // １限目途中から
        if($this->onegen < $this->date) {
        $stmt->execute(array($userId,date("Y-m/d"),1,$Type));}
      // 2限目途中から
        if($this->twogen < $this->date){
        // $cnt=2;
        //   for($i=0;$i<$cnt;$i++){
            $stmt=$pdo->prepare($this->insert);
            $stmt->execute(array($userId,date("Y-m/d"),2,$Type));}
          // }
      //3限目途中から
        if($this->threegen < $this->date){
            $stmt=$pdo->prepare($this->insert);
            $stmt->execute(array($userId,date("Y-m/d"),3,$Type));}
      //4限目途中から
        if($this->fourgen < $this->date){
            $stmt=$pdo->prepare($this->insert);
            $stmt->execute(array($userId,date("Y-m/d"),4,$Type));}
      //5限目途中から
        if($this->fifgen < $this->date){
            $stmt=$pdo->prepare($this->insert);
            $stmt->execute(array($userId,date("Y-m/d"),5,$Type));}
}
//早退
    function Leave_early($userId,$Type){
      $this->construct("localhost","root","root","Users");
      $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
      $stmt = $pdo->prepare($this->attendCheck);
      $stmt->execute($userId,date("y-m-d"));
       while($kari=$stmt->fetch(PDO::FETCH_ASSOC)){
         $time=$kari[Time];
         $time=date("H:i:s",$time);
        }
        $stmt = $pdo->prepare($this->insert);
        if($time<$this->fifgen)
        echo $time;
        // $stmt->execute(array($userId,date("Y-m/d"),1,0));
        // １限目途中から
        if($this->date < date("10:09:59"))$stmt->execute(array($userId,date("Y-m/d"),1,$Type));
        // 2限目途中から
        if($this->date < date("11:09:59"))$stmt->execute(array($userId,date("Y-m/d"),2,$Type));
        // 3限目途中から
        if($this->date < date("12:09:59"))$stmt->execute(array($userId,date("Y-m/d"),3,$Type));
        // 4限目途中から
        if($this->date < date("13:49:59"))$stmt->execute(array($userId,date("Y-m/d"),4,$Type));
        // 5限目途中から
        if($this->date < date("14:49:59"))$stmt->execute(array($userId,date("Y-m/d"),5,$Type));
    }
function fetch()
	{
	try{
        $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
        } catch(PDOException $ei) {
                echo 'Connection failed:'.$e->getMessage();
                exit();}
	}

function execute ($sql)
        {
        try{
        $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = $pdo->lastInsertId();
        return $data;
	} catch(PDOException $ei) {
                     echo 'Connection failed:'.$e->getMessage();
                exit();}
	}

}
?>
