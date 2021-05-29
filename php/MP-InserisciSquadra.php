<!-- Massimo Parlanti -->
<html>

<head>
	<link href="..\css\calciatore.css" rel="stylesheet" type="text/css">
</head>
<div class="wrapper fadeInDown">
	<div id="formContent">
		<?php

		require_once $_SERVER['DOCUMENT_ROOT'] . '/PisaSC/utils/MP_func.php';

		$bool = authSession();
		if ($bool == "0") {
			$msg = "Non sei autenticato";
			header("Location:..\utils\MP-ErrorPage.php?errore=" . $msg);; //pagina di errore
		}

		$conn = connection();

		if (!isset($_POST["button"])) {
			echo "<div id=formContent>";
			/* Tabs Titles -->*/
			echo "<h2 class=active> INSERISCI SQUADRA </h2>";

			// Icon -->
			echo "<div class=fadeIn first>";
			echo "<img src=..\img\LogoPisa.png id=icon alt=User Icon /><br>";
			echo " </div>";

			echo "<form action=" . $_SERVER['PHP_SELF'] . " method=POST>";

			echo "<br><label for=Nome>Nome:</label><br>";
			echo "<input type=text name=Nome placeholder=Nome >";

			echo "<br><label for=Campionato>Campionato:</label><br>";
			echo "<input type=text name=Campionato placeholder=Campionato >";

			echo "<br><label for=Qualita>Qualità:</label><br>";
			echo "<input type=number name=Qualita min=0 max=10  placeholder=Qualita><br><br>";


			echo "<input type=submit name=button value=Invio>";
			echo "<input type=reset name=cancella value=Annulla>";
			echo "<br><br><input type=submit name=LOGOUT value=LOGOUT>";
			echo "<br><br><input type=submit name=indietro value=Indietro>";

			echo "</form>";

			if (isset($_POST["LOGOUT"]))
				closeSession();
			if (isset($_POST["indietro"]))
				goScelta();
		} else {
			echo "<br>" . $Nome = $_POST["Nome"];
			echo "<br>" . $Campionato = $_POST["Campionato"];
			echo "<br>" . $Qualita = $_POST["Qualita"];

			if (isset($Nome) && isset($Campionato) && isset($Qualita) &&  !empty($Nome) && !empty($Campionato) && !empty($Qualita)) {
				$t = inserisciSquadra($conn, $Nome, $Campionato, $Qualita);
				if ($t == "Record inserito correttamente") {
					echo "<div class=fadeIn first>";
					echo "<img src=..\img\check.jpg id=icon alt=User Icon /><br>";
					echo " </div>";
					echo $t;
					echo "<form action=" . $_SERVER['PHP_SELF'] . " method=POST>";
					echo "<br><br><input type=submit name=indietro value=Indietro>";
					echo "</form>";
					if (isset($_POST["indietro"]))
						goScelta();
				} else {

					$msg = "Uno dei dati di input non è stato correttamente compilato/mancanteeeeeeeeeeeeeee";
					header("Location:..\utils\MP-ErrorPage.php?errore=" . $msg);; //pagina di errore
				}
			} else {
				$msg = "Uno dei dati di input non è stato correttamente compilato/mancante";
				header("Location:..\utils\MP-ErrorPage.php?errore=" . $msg);; //pagina di errore

			}
		}

		?>