<?php
session_start();
require_once "polaczenie.php";

if(isset($_SESSION['status_zalogowania']) && $_SESSION['status_zalogowania']==true)
{
  header('Location: panel.php');
  exit();
}

?>

<html>
  <head>
    <title>Logowanie</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
  </head>
  <body>

    <div id="index_logowanie_error_body">
      <?php
           if(isset($_SESSION['powiadomienie_error']))
           {
             echo($_SESSION['powiadomienie_error']);
           }

         ?>
    </div>

    <div id="okno_zaloguj">
       <div id="okno_zaloguj_img"></div>
       <div id="okno_zaloguj_logowanie">
           <form action="logowanie.php" method="post">
           <input type="text" placeholder="Username" name="login"/>
           <br />
           <input type="password" placeholder="Password" name="haslo"/>
           <br />
           <input type="submit" value="Zaloguj" id="przycisk_zaloguj"/>
           <div id="okno_zaloguj_pytanie">
             <?php
             if(isset($_SESSION['powiadomienie_error']))
             {
               echo('<script type="text/javascript" src="js/logowanie_error_okno.js"></script>');
             }
             unset($_SESSION['powiadomienie_error']);
             ?>
             Nie masz konta?<a href="rejestracja.php"> Zarejestruj się!</a>
           </div>
         </form>
       </div>
     </div>
  </body>
</html>
