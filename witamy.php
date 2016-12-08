<?php
session_start();
require_once "polaczenie.php";
?>

<html>
  <head>
    <title>Witamy!</title>
    <meta http-equiv="refresh" content="3;url=panel.php" />
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
  </head>
  <body>


    <div id="okno_witamy">
       Zarejestrowano pomyślnie.<br />
       Witamy na stronie!<br /><br />
       Za chwilę zostaniesz przekierowany...
     </div>
  </body>
</html>
