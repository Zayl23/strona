<!DOCTYPE html>
<html>
  
  <head>
	<meta charset="UTF-8">
    <link href='https://fonts.googleapis.com/css?family=Raleway:400, 600' rel='stylesheet' type='text/css'>
    <link href='style.css' rel='stylesheet' type='text/css'/>
  </head>

  <body>
    
    <header>
        <nav>
          <ul>
            <li> <a href="index.html"class="btn-main">Strona Główna</a> </li> <li> <a href="Logowanie.html"class="btn-main">Logowanie</a> </li> <li> <a href="Repertuar.html" class="btn-main"> Repertuar </a> </li> <li> <a href="Kontakt.html"class="btn-main">Kontakt</a> </li>
        </nav>
    </header>

    <main>
      <div class="jumbotron">

	  
	  <form method="POST" action="rejestracja.php">
<b>Login:</b> <input type="text" name="login"><br>
<b>Haslo:</b> <input type="password" name="haslo1"><br>
<b>Powtorz haslo:</b> <input type="password" name="haslo2"><br>
<b>Email:</b> <input type="text" name="email"><br>
<input type="submit" value="Zaloguj" name="loguj">
</form> 

<?php



function filtruj($zmienna) 
{
    if(get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna); // usuwamy slashe

	// usuwamy spacje, tagi html oraz niebezpieczne znaki
    return mysql_real_escape_string(htmlspecialchars(trim($zmienna))); 
}

if (isset($_POST['loguj'])) 
{
	$login = filtruj($_POST['login']);
	$haslo1 = filtruj($_POST['haslo1']);
	$haslo2 = filtruj($_POST['haslo2']);
	$email = filtruj($_POST['email']);
	$ip = filtruj($_SERVER['REMOTE_ADDR']);
	
	// sprawdzamy czy login nie jest już w bazie
	if (mysql_num_rows(mysql_query("SELECT login FROM uzytkownicy WHERE login = '".$login."';")) == 0) 
	{
		if ($haslo1 == $haslo2) // sprawdzamy czy hasła takie same
		{
			mysql_query("INSERT INTO `uzytkownicy` (`login`, `haslo`, `email`, `rejestracja`, `logowanie`, `ip`)
				VALUES ('".$login."', '".md5($haslo1)."', '".$email."', '".time()."', '".time()."', '".$ip."');");

			echo "Konto zostało utworzone!";
		}
		else echo "Hasła nie są takie same";
	}
	else echo "Podany login jest już zajęty.";
}
?>


	  
	  
      </div>
    </main>



    <footer>
      <div class="container">
        <p>&copy; Czernikiewicz & Rujner</p>
      </div>
    </footer>
    
  </body>
</html>