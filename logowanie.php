<?php

	session_start();

	if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}

	require_once "polaczenie.php";

	$polaczenie = @new mysqli($host,$baza_uzytkownik,$baza_haslo,$baza_nazwa);

	if($polaczenie->connect_errno!=0)
	{
		echo("Error: ".$polaczenie->connect_errno);
	}
	else
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];

		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		//$haslo = htmlentities($haslo, ENT_QUOTES, "UTF_8");


		if($wynik = $polaczenie->query(sprintf("SELECT * FROM uzytkownik WHERE login='%s'",
		   mysqli_real_escape_string($polaczenie,$login))))
		{
			$ilosc_uzytkownikow = $wynik->num_rows;
			if($ilosc_uzytkownikow>0)
			{
				$wiersz = $wynik->fetch_assoc();

				if(password_verify($haslo,$wiersz['haslo']))
				{
					$_SESSION['status_zalogowania'] = true;

					$_SESSION['uzytkownik'] = $wiersz['login'];

					unset($_SESSION['powiadomienie_error']);
					$wynik->free_result();
					header('Location: panel.php');
				}
				else
				{
					$_SESSION['powiadomienie_error'] = "Nierawidłowy login lub hasło";
					header('Location: index.php');
				}
			}
			else
			{
				$_SESSION['powiadomienie_error'] = "Nierawidłowy login lub hasło";
				header('Location: index.php');
			}
		}
	$polaczenie->close();
	}
?>
