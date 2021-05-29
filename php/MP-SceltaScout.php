<!-- Massimo Parlanti -->
<html>

<head>
	<link href="..\css\sceltascout.css" rel="stylesheet" type="text/css">
</head>

<div class="wrapper fadeInDown">
	<div id="formContent">
		<?php
		require_once $_SERVER['DOCUMENT_ROOT'] . '/PisaSC/utils/MP_func.php';
		// Tabs Titles 
		$bool = authSession();
		if ($bool == "0") {
			$msg = "Non sei autenticato";
			header("Location:..\utils\MP-ErrorPage.php?errore=" . $msg);; //pagina di errore
		}
		echo "<h2 class=active> " .htmlentities($bool). "</h2>";

		// Icon -->
		echo "<div class=fadeIn first>";
		echo "<img src=..\img\LogoPisa.png id=icon alt=User Icon /><br>";
		echo "</div>";
		echo "Inserisci <br>";

		echo "<form action=" . $_SERVER['PHP_SELF'] . " method=POST>";
		echo "<input type=submit class=fadeIn third name=InsCalc value=Calciatore>";
		echo "<input type=submit class=fadeIn third name=InsSqua value=Squadra>";
		echo "<input type=submit class=fadeIn second name=InsProc value=Procuratore>";
		echo "<input type=submit class=fadeIn fourth name=LOGOUT value=LOGOUT>";

		echo "</form>";
		if (isset($_POST["LOGOUT"]))
			closeSession();
		else if (isset($_POST["InsCalc"]))
			header("Location:MP-InserisciCalciatore.php");
		else if (isset($_POST["InsSqua"]))
			header("Location:MP-InserisciSquadra.php");
		else if (isset($_POST["InsProc"]))
			header("Location:MP-InserisciProcuratore.php");
		?>