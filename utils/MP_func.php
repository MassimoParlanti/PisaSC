<!-- Massimo Parlanti -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/PisaSC/utils/MP_properties.php';

function connection()
{

	global $servername;
	global $username;
	global $password;
	global $dbname;
	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error)
		die("Connection failed: " . $conn->connect_error);

	return $conn;
}

function initSession($codice)
{
	session_start();
	$_SESSION['codice'] = $codice;
}

function closeSession()
{
	session_start();
	session_unset();
	session_destroy();
	header("Location:..\index.php");
}

function authSession()
{
	session_start();
	if (!isset($_SESSION['codice']) && empty($_SESSION['codice']))
		return "0";
	else {
		//chiamata funzione
		$cod = selectCognome($_SESSION['codice']);
		$s = "Benvenuto " . $cod;
		return $s;
	}
}

function backIndex()
{
	header("Location:..\index.php");
}

function goSquadra()
{
	header("Location:MP-InserisciSquadra.php");
}

function goScelta()
{
	header("Location:MP-SceltaScout.php");
}

function selectTipoAcademy(&$conn)
{

	$conn = connection();

	$sql = "SELECT * from TipoAcademy";
	$result = $conn->query($sql);
	return $result;
}

function selectAcademy(&$conn, $ID)
{

	$sql = "SELECT Tipo FROM TipoAcademy WHERE ID=?"; // SQL with parameters
	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("i", $ID);
		if (!$stmt->execute()) {
			$string = null;
		} else {
			$result = $stmt->get_result(); // get the mysqli result
			while ($row = $result->fetch_assoc()) {
				$string = $row['Tipo'];
			}
		}
	} else {
		$string = null;
	}
	return $string;
}

function selectCognome($ID)
{
	$conn = connection();

	/*$sql="SELECT Cognome from Scout WHERE Codice=".$ID;
		$result=$conn->query($sql); 
		while($row = $result->fetch_assoc()){
			$string=$row['Cognome'];
		}
		return $string;*/

	$sql = "SELECT Cognome FROM Scout WHERE Codice=?"; // SQL with parameters
	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("i", $ID);
		if (!$stmt->execute()) {
			$string = null;
		} else {
			$result = $stmt->get_result(); // get the mysqli result
			while ($row = $result->fetch_assoc()) {
				$string = $row['Cognome'];
			}
		}
	} else {
		$string = null;
	}
	return $string;
}

function selectProcuratore(&$conn)
{
	$conn = connection();

	$sql = "SELECT * from Procuratore";
	$result = $conn->query($sql);
	return $result;
}

function selectSquadra(&$conn)
{
	$conn = connection();

	$sql = "SELECT * from Squadra";
	$result = $conn->query($sql);
	return $result;
}

function inserisciProcuratore(&$conn, $CFProcuratore, $NomeProcuratore, $CognomeProcuratore, $TipoProcuratore)
{
	$s = null;
	if ($stmt = $conn->prepare("INSERT INTO Procuratore(CF,Nome,Cognome,Tipo) VALUES(?, ? ,?, ? );"))  //preparazione comando sql
	{
		$stmt->bind_param('ssss', $CFProcuratore, $NomeProcuratore, $CognomeProcuratore, $TipoProcuratore);  //placeholder sostituiti dai valori
		if (!$stmt->execute()) {
			$s = urlencode("Errore di sistema!");
		} else
			$s = "Record inserito correttamente";
	} else {
		$s = urlencode("inserimento fallito ");
	}

	return $s;
}

function inserisciVisione(&$conn, $scelta, $CFProcuratore, $codice)
{
	$s = null;
	if ($stmt = $conn->prepare("INSERT INTO Visione(SceltaScout,CFCalciatore,CodiceScout) VALUES(?, ? ,?);"))  //preparazione comando sql
	{
		$stmt->bind_param('isi', $scelta, $CFProcuratore, $codice);  //placeholder sostituiti dai valori
		if (!$stmt->execute()) {
			$s = urlencode("Errore di sistema");
		} else
			$s = "Record inserito correttamente";
	} else {
		$s = urlencode("inserimento fallito ");
	}

	return $s;
}

function inserisciCalciatore(&$conn, $CF, $Tipo, $eta, $CaratteristicheFisiche, $CaratteristicheTecniche, $Nome, $Cognome, $Sponsor, $QTalento, $Ruolo, $CFProcuratore, $Squadra, $scelta, $codice)
{
	if ($stmt = $conn->prepare("INSERT INTO Calciatore(CF,TipoAcademy,Eta,CaratteristicheFisiche,CaratteristicheTecniche,Nome,Cognome,Sponsor,QualitaTalento,Ruolo,CFProcuratore,IDSquadra) VALUES(?, ? ,?, ?,?,?,?,?,?,?,?,? );"))  //preparazione comando sql
	{
		$stmt->bind_param('ssisssssisss', $CF, $Tipo, $eta, $CaratteristicheFisiche, $CaratteristicheTecniche, $Nome, $Cognome, $Sponsor, $QTalento, $Ruolo, $CFProcuratore, $Squadra);  //placeholder sostituiti dai valori
		if (!$stmt->execute()) {
			$s = urlencode("Errore di sistema");
		} else {
			$s = "Record inserito correttamente";
			$t = inserisciVisione($conn, $scelta, $CF, $codice);
			if ($s != $t)
				$s = "Errore di sistema!";
		}
	} else {
		$s = urlencode("inserimento fallito ");
	}
	return $s;
}

function inserisciSquadra(&$conn, $Nome, $Campionato, $Qualita)
{
	if ($stmt = $conn->prepare("INSERT INTO Squadra(Nome,Campionato,Qualita) VALUES(?, ? ,? );"))  //preparazione comando sql
	{
		$stmt->bind_param('ssi', $Nome, $Campionato, $Qualita);  //placeholder sostituiti dai valori
		if (!$stmt->execute()) {
			$s = urlencode("Errore di sistema!");
		} else
			$s = "Record inserito correttamente";
	} else {
		$s = urlencode("inserimento fallito ");
	}

	return $s;
}
