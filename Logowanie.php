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
            <li> <a href="index.html"class="btn-main">Strona Główna</a> </li> <li> <a href="Rejestracja.php"class="btn-main">Rejestracja</a> </li> <li> <a href="Repertuar.html" class="btn-main"> Repertuar </a> </li> <li> <a href="Kontakt.html"class="btn-main">Kontakt</a> </li>
          </ul>
        </nav>
    </header>

    <main>
      <div class="jumbotron">

	  <?php
session_start();
mysql_connect("localhost","root","");
mysql_select_db("test");
?>

<?php
if (isset($_GET['wyloguj'])==1) 
{
	$_SESSION['zalogowany'] = false;
	session_destroy();
}
?>

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
	$haslo = filtruj($_POST['haslo']);
	$ip = filtruj($_SERVER['REMOTE_ADDR']);
	
	// sprawdzamy czy login i hasło są dobre
	if (mysql_num_rows(mysql_query("SELECT login, haslo FROM uzytkownicy WHERE login = '".$login."' AND haslo = '".md5($haslo)."';")) > 0) 
	{	
		// uaktualniamy date logowania oraz ip
		mysql_query("UPDATE `uzytkownicy` SET (`logowanie` = '".time().", `ip` = '".$ip."'') WHERE login = '".$login."';");
	
		$_SESSION['zalogowany'] = true;
		$_SESSION['login'] = $login;
		
		// zalogowany

	}
	else echo "Wpisano złe dane.";
}

if ($_SESSION['zalogowany']==true)
{
	echo "Witaj <b>".$_SESSION['login']."</b><br><br>";
	
	echo '<a href="?wyloguj=1">[Wyloguj]</a>';
}
?>

<?php if ($_SESSION['zalogowany']==false): ?>

<form method="POST" action="logowanie.php">
<b>Login:</b> <input type="text" name="login"><br>
<b>Hasło:</b> <input type="password" name="haslo"><br>
<input type="submit" value="Zaloguj" name="loguj">
</form> 

<?php endif; ?>



<?php mysql_close(); ?>
	  
      </div>
    </main>



    <footer>
      <div class="container">
        <p>&copy; Czernikiewicz & Rujner</p>
      </div>
    </footer>
    
  </body>
</html>