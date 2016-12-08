<?php
	session_start();

	if(isset($_SESSION['status_zalogowania']) && $_SESSION['status_zalogowania']=TRUE)
	{
		header('Location: index.php');
		exit();
	}

	if(isset($_POST['email']))
	{
		$test_rejestracji = TRUE;

		$nick = $_POST['nick'];
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		$email = $_POST['email'];

		//długość nicku
		if((strlen($nick)<3) || (strlen($nick)>20))
		{
			$test_rejestracji = FALSE;
			$_SESSION['e_nick'] = "Nick musi posiadać od 3 do 20 znaków.";
		}
		//znaki nicku
		if(ctype_alnum($nick)==FALSE)
		{
			$test_rejestracji = FALSE;
			$_SESSION['e_nick'] = "Nick nie może zawierać znaków specjalnych.";
		}
		//dlugosc hasla
		if(strlen($haslo1)<6)
		{
			$test_rejestracji = FALSE;
			$_SESSION['e_haslo'] = "Hasło jest za krótkie.";
		}
		//zgodność haseł
		if($haslo1!=$haslo2)
		{
			$test_rejestracji = FALSE;
			$_SESSION['e_haslo'] = "Hasła nie pasują.";
		}

		$haslo_hash = password_hash($haslo1,PASSWORD_DEFAULT);

		//zgodność email
		$email1 = @filter_var($email,FILTER_SANITIZE_EMAIL);
		if((filter_var($email1,FILTER_VALIDATE_EMAIL)==FALSE) || ($email!=$email1))
		{
			$test_rejestracji = FALSE;
			$_SESSION['e_email'] = "Podaj poprawny e-mail.";
		}
		//regulamin
		if(!isset($_POST['regulamin']))
		{
			$test_rejestracji = FALSE;
			$_SESSION['e_regulamin'] = "Potwierdź regulamin.";
		}

		require_once("polaczenie.php");
		mysqli_report(MYSQLI_REPORT_STRICT);

		try
		{
			$polaczenie = @new mysqli($host,$baza_uzytkownik,$baza_haslo,$baza_nazwa);
			if($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//czy email istnieje
				$wynik = $polaczenie->query("SELECT uzytkownik_id FROM uzytkownik WHERE email='$email'");
				if(!$wynik) throw new Exception($polaczenie->error);

				$czy_mail_istnieje = $wynik->num_rows;
				if($czy_mail_istnieje>0)
				{
					{
						$test_rejestracji = FALSE;
						$_SESSION['e_email'] = "Ten e-mail jest już przypisany do konta.";
					}
				}

				//czy nick istnieje
				$wynik = $polaczenie->query("SELECT uzytkownik_id FROM uzytkownik WHERE login='$nick'");
				if(!$wynik) throw new Exception($polaczenie->error);

				$czy_nick_istnieje = $wynik->num_rows;
				if($czy_nick_istnieje>0)
				{
					{
						$test_rejestracji = FALSE;
						$_SESSION['e_nick'] = "Taki użytkownik już istnieje.";
					}
				}

				if($test_rejestracji==TRUE)
				{
					if($polaczenie->query("INSERT INTO uzytkownik (login,haslo,email) VALUES ('$nick','$haslo_hash','$email')"))
					{
						$_SESSION['udana_rejestracja'] = TRUE;
						header('Location: witamy.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
				}

				$polaczenie->close();
			}
		}
		catch (Exception $e)
		{
			echo('<span style="color:red;">Błąd serwera, spróbuj ponownie później.</span>');
		}

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

      <div id="rejestracja_okno">
			<div id="rejestracja">
				<form method="post">
			      	<div id="rejestracja_naglowek">Rejestracja</div>
			      	<input type="text" placeholder="Login" name="nick"/>
				      	<?php
							if(isset($_SESSION['e_nick']))
							{
								echo'<div class="error_rejestracja">'.$_SESSION['e_nick'].'</div>';
								unset($_SESSION['e_nick']);
							}
						?>
				      	<br />
			      	<input type="password" placeholder="Hasło" name="haslo1"/>
				      	<?php
							if(isset($_SESSION['e_haslo']))
							{
								echo'<div class="error_rejestracja">'.$_SESSION['e_haslo'].'</div>';
								unset($_SESSION['e_haslo']);
							}
						?>
			      	<br />
			      	<input type="password" placeholder="Powtórz Hasło" name="haslo2"/>
			      	<br />
			      	<input type="text" placeholder="E-mail" name="email"/>
				      	<?php
							if(isset($_SESSION['e_email']))
							{
								echo'<div class="error_rejestracja">'.$_SESSION['e_email'].'</div>';
								unset($_SESSION['e_email']);
							}
						?>
			      	<br />
			      	<label id="rejestracja_regulamin"><input type="checkbox" name="regulamin" /> Akceptuję Regulamin</label>
				      	<?php
							if(isset($_SESSION['e_regulamin']))
							{
								echo'<div class="error_rejestracja">'.$_SESSION['e_regulamin'].'</div>';
								unset($_SESSION['e_regulamin']);
							}
						?>
			      	<br />
			      	<input type="submit" value="Zarejestruj"/>
			    </form>
			</div>
    </div>

  </body>
</html>
