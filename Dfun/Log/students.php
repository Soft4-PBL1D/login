<?php
require("../Function/LoginFunction/LoginCheak.php");
studentsCheak();
echo "WELCOME" . $_SESSION["NAME"]."生徒";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>TOPPAGE</title>
  </head>
  <body>
  <ul>
  <li><a href="logout.php">Logout</a></li>
  </ul>
  </body>
</html>
