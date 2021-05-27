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
		$result = selectTipoAcademy($conn);
		$result1 = selectProcuratore($conn);
		$result2 = selectSquadra($conn);

		if (!isset($_POST["button"])) {
			if ($result2->num_rows == 0) {
				echo " non ci sono squadre a cui far riferimento;<br> per inserire delle squadre clicca qui";
				echo "<form action=" . $_SERVER['PHP_SELF'] . " method=POST>";
				echo "<input type=submit name=S value=Squadra>";
				echo "</form>";
				if (isset($_POST["S"]))
					goSquadra();
			} else {
				echo "<div id=formContent>";
				/* Tabs Titles -->*/
				echo "<h2 class=active> INSERISCI CALCIATORE </h2>";

				// Icon -->
				echo "<div class=fadeIn first>";
				echo "<img src=..\img\LogoPisa.png id=icon alt=User Icon /><br>";
				echo " </div>";

				echo "<form action=" . $_SERVER['PHP_SELF'] . " method=POST>";

				echo "<br><label for=CF>Codice Fiscale:</label><br>";
				echo "<input type=text class=fadeIn third name=CF placeholder=CF pattern=^[a-zA-Z]{6}[0-9]{2}[abcdehlmprstABCDEHLMPRST]{1}[0-9]{2}([a-zA-Z]{1}[0-9]{3})[a-zA-Z]{1}$ <br>";

				echo "<br><label for=Nome>Nome:</label><br>";
				echo "<input type=text name=Nome placeholder=Nome  >";

				echo "<br><label for=Cognome>Cognome:</label><br>";
				echo "<input type=text name=Cognome placeholder=Cognome  >";

				echo "<br><label for=eta>Età:</label><br>";
				echo "<input type=number name=eta placeholder=Età min=6 max=40  >";


				echo "<div class=box>";
				echo "<br><label for=Tipo>TipoAcademy:</label><br>";
				echo "<select name=Tipo id=Tipo>";

				while ($row = $result->fetch_assoc()) {
					echo "<option value=" . $row['ID'] . ">" . $row['Tipo'] . "</option>";
				}
				echo "</select>";
				echo "</div>";

				echo "<br><label for=CaratteristicheFisiche>Caratteristiche Fisiche:</label><br>";
				echo "<textarea id=CaratteristicheFisiche name=CaratteristicheFisiche rows=4 cols=60  ></textarea>";

				echo "<br><label for=CaratteristicheTecniche>Caratteristiche Tecniche:</label><br>";
				echo "<textarea id=CaratteristicheTecniche name=CaratteristicheTecniche rows=4 cols=60  ></textarea>";

				echo "<br><label for=Sponsor>Sponsor:</label><br>";
				echo "<input type=text name=Sponsor placeholder=Sponsor  >";

				echo "<br><label for=QTalento>Qualità Talento:</label><br>";
				echo "<input type=number name=QTalento placeholder=QualitàTalento min=0 max=10  >";

				echo "<br><label for=eta>Scelta Scout:</label><br>";
				echo "<input type=number name=sceltascout placeholder=sceltascout min=0 max=100  >";

				echo "<br><label for=Ruolo>Ruolo:</label><br>";
				echo "<input type=text name=Ruolo placeholder=Ruolo  >";

				echo "<div class=box>";
				echo "<br><label for=Squadra>Squadra:</label><br>";
				echo "<select name=Squadra id=Squadra>";

				while ($row = $result2->fetch_assoc()) {
					echo "<option value=" . $row['IDSquadra'] . ">" . $row['Nome'] . "</option>";
				}
				echo "</select>";
				echo "</div>";


				echo "<div class=box>";
				echo "<br><label for=CFProcuratore>Procuratore:</label><br>";
				echo "<select name=CFProcuratore id=CFProcuratore>";

				while ($row = $result1->fetch_assoc()) {
					echo "<option value=" . $row['CF'] . ">" . $row['Nome'] . " " . $row['Cognome'] . "</option>";
				}
				echo "</select>";
				echo "</div><br><br>";


				echo "<input type=submit name=button value=Invio>";
				echo "<input type=reset name=cancella value=Annulla>";
				echo "<br><br><input type=submit name=LOGOUT value=LOGOUT>";
				echo "<br><br><input type=submit name=indietro value=Indietro>";
		?>
				<div class="d-flex align-items-center">
					<a href="#" aria-hidden="true" data-attribute="back-to-top" class="back-to-top shadow">
						<svg class="icon icon-light"><img src="..\img\frecciasu.png" width="5%"></use></svg>

						<!--<use xlink:href="/bootstrap-italia/dist/svg/sprite.svg#it-arrow-up"></use>-->
					</a>
			<?php
				echo "</form>";
				echo "</div>";
				echo "</div>";

				if (isset($_POST["LOGOUT"]))
					closeSession();
				if (isset($_POST["indietro"]))
					goScelta();
			}
		} else {

			$CF = $_POST["CF"];
			$Nome = $_POST["Nome"];
			$Cognome = $_POST["Cognome"];
			$eta = $_POST["eta"];
			$_POST["Tipo"];
			$T = selectAcademy($conn, $_POST["Tipo"]);
			$CaratteristicheFisiche = $_POST["CaratteristicheFisiche"];
			$CaratteristicheTecniche = $_POST["CaratteristicheTecniche"];
			$Sponsor = $_POST["Sponsor"];
			$QTalento = $_POST["QTalento"];
			$Ruolo = $_POST["Ruolo"];
			$Squadra = $_POST["Squadra"];
			$sceltascout = $_POST["sceltascout"];
			$CFProcuratore = $_POST["CFProcuratore"];
			$codice = $_SESSION['codice'];


			if (isset($CF) && isset($Nome) && isset($Cognome) && isset($eta) && isset($T) && isset($QTalento) && isset($Ruolo) && isset($Squadra) && isset($CFProcuratore)  && !empty($CF) && !empty($Nome) && !empty($Cognome) && !empty($eta) && !empty($T) && !empty($QTalento) && !empty($Ruolo) && !empty($Squadra) && !empty($CFProcuratore)) {
				//$t=inserisciProcuratore($conn,$CFProcuratore,$NomeProcuratore,$CognomeProcuratore,$TipoProcuratore);
				//echo $t;

				$s = inserisciCalciatore($conn, $CF, $T, $eta, $CaratteristicheFisiche, $CaratteristicheTecniche, $Nome, $Cognome, $Sponsor, $QTalento, $Ruolo, $CFProcuratore, $Squadra, $sceltascout, $codice);
				if ($s == "Record inserito correttamente") {
					echo "<div class=fadeIn first>";
					echo "<img src=..\img\check.jpg id=icon alt=User Icon /><br>";
					echo " </div>";
					echo $s;
					echo "<form action=" . $_SERVER['PHP_SELF'] . " method=POST>";
					echo "<br><br><input type=submit name=indietro value=Indietro>";
					echo "</form>";
					if (isset($_POST["indietro"]))
						goScelta();
				} else {

					$msg = "Uno dei dati di input non è stato correttamente compilato/mancante";
					header("Location:..\utils\MP-ErrorPage.php?errore=" . $msg . "    u" . $T);; //pagina di errore
				}
			} else {
				$msg = "Uno dei dati di input non è stato correttamente compilato/mancante";
				header("Location:..\utils\MP-ErrorPage.php?errore=" . $msg . "    u" . $T);; //pagina di errore

			}
		}

			?>