<?php
session_start();
require_once "polaczenie.php";

$polaczenie = @new mysqli($host,$baza_uzytkownik,$baza_haslo,$baza_nazwa);
$wynik = $polaczenie->query(sprintf("SELECT * FROM uzytkownik WHERE login='%s'",
            mysql_real_escape_string($_SESSION['uzytkownik'])));
$wiersz = $wynik->fetch_assoc();


if(!isset($_SESSION['status_zalogowania']))
{
  header('Location: index.php');
  exit();
}
?>

<html>
  <head>
    <title>Panel</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
  </head>
  <body>
    <div id="okno_profil">
        <?php echo("Witaj ".$_SESSION['uzytkownik']); ?><br />



        Imię: <input type="text" />
        Nazwisko: <input type="text" />
        Data urodzenia: <input type="date" />
        Miasto: <input type="text" />
        Wzrost: <input type="text" />
    </div>

    <a href="wyloguj.php"><button>Wyloguj się</button></a>
  </body>
</html>
