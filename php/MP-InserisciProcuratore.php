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
		$result1 = selectProcuratore($conn);

		if (!isset($_POST["button"])) {

			echo "<div id=formContent>";
			/* Tabs Titles -->*/
			echo "<h2 class=active> INSERISCI Procuratore </h2>";

			// Icon -->
			echo "<div class=fadeIn first>";
			echo "<img src=..\img\LogoPisa.png id=icon alt=User Icon /><br>";
			echo " </div>";

			echo "<form action=" . $_SERVER['PHP_SELF'] . " method=POST>";

			echo "<br><label for=CFProcuratore>Codice Fiscale Procuratore:</label><br>";
			echo "<input type=text name=CFProcuratore placeholder=CFProcuratore pattern=^[a-zA-Z]{6}[0-9]{2}[abcdehlmprstABCDEHLMPRST]{1}[0-9]{2}([a-zA-Z]{1}[0-9]{3})[a-zA-Z]{1}$>";

			echo "<br><label for=NomeProcuratore>Nome Procuratore:</label><br>";
			echo "<input type=text name=NomeProcuratore placeholder=NomeProcuratore>";

			echo "<br><label for=CognomeProcuratore>Cognome Procuratore:</label><br>";
			echo "<input type=text name=CognomeProcuratore placeholder=CognomeProcuratore>";

			echo "<br><label for=TipoProcuratore>Tipo Procuratore:</label><br>";
			echo "<input type=text name=TipoProcuratore placeholder=TipoProcuratore>";


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
			$CFProcuratore = $_POST["CFProcuratore"];
			$NomeProcuratore = $_POST["NomeProcuratore"];
			$CognomeProcuratore = $_POST["CognomeProcuratore"];
			$TipoProcuratore = $_POST["TipoProcuratore"];
			$codice = $_SESSION['codice'];
			$scelta = 4;

			if (isset($CFProcuratore) && isset($NomeProcuratore) && isset($CognomeProcuratore)  && !empty($CFProcuratore) && !empty($NomeProcuratore) && !empty($CognomeProcuratore)) {
				$t = inserisciProcuratore($conn, $CFProcuratore, $NomeProcuratore, $CognomeProcuratore, $TipoProcuratore);
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

					$msg = "Uno dei dati di input non è stato correttamente compilato/mancante";
					header("Location:..\utils\MP-ErrorPage.php?errore=" . $msg);; //pagina di errore
				}
			} else {
				$msg = "Uno dei dati di input non è stato correttamente compilato/mancante";
				header("Location:..\utils\MP-ErrorPage.php?errore=" . $msg);; //pagina di errore

			}
		}

		?>