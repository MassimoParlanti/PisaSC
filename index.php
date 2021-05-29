<!-- Massimo Parlanti -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/PisaSC/utils/MP_func.php';
$auth=authSession();

if(!isset($_POST["button"])){
	if($auth!="0")
		header("Location:php/MP-SceltaScout.php");
	?>
<!DOCTYPE html>
<html>
<head>
<link href="css\login.css" rel="stylesheet" type="text/css">
<style>
body{
	margin:0;
	font:600 16px/18px 'Open Sans',sans-serif;
		width:100vw;
			min-height:100vh;
			background-image: url('img/Curva-Pisa.jpg');
			background-repeat: no-repeat;
			background-size: cover;
}
input[type=button], input[type=submit], input[type=reset] {
  background-color: #56baed;
  border: none;
  color: white;
  padding: 15px 80px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  text-transform: uppercase;
  font-size: 13px;
  -webkit-box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
  box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
  -webkit-border-radius: 5px 5px 5px 5px;
  border-radius: 5px 5px 5px 5px;
  margin: 5px 20px 40px 20px;
  -webkit-transition: all 0.3s ease-in-out;
  -moz-transition: all 0.3s ease-in-out;
  -ms-transition: all 0.3s ease-in-out;
  -o-transition: all 0.3s ease-in-out;
  transition: all 0.3s ease-in-out;
}
</style>
</head>
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->
    <h2 class="active"> Log In </h2>

    <!-- Icon -->
    <div class="fadeIn first">
      <img src="img\LogoPisa.png" id="icon" alt="User Icon" /><br>
    </div>

    <!-- Login Form -->
    <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
	
	<input type="radio" id="utenza1" name="utenza" value="Scout" checked>
	<label for="utenza1">Scout</label>
	<input type="radio" id="utenza2" name="utenza" value="CapoScout">
	<label for="utenza2">CapoScout</label>  
	<input type="radio" id="utenza3" name="utenza" value="DS">
	<label for="utenza3">DS</label><br><br>
	
	<!--<div class="radio-toolbar">
    <input type="radio" id="radioApple" name="radioFruit" value="apple" checked>
    <label for="radioApple">Apple</label>

    <input type="radio" id="radioBanana" name="radioFruit" value="banana">
    <label for="radioBanana">Banana</label>

    <input type="radio" id="radioOrange" name="radioFruit" value="orange">
    <label for="radioOrange">Orange</label> 
	</div>
	<p>&nbsp;</p>-->


	
      <input type="text" id="login" class="fadeIn second" name="Email" required pattern="(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])" placeholder="email" >
      <input type="text" id="password" class="fadeIn third" name="Password" placeholder="password" required><br><br>
      <input type="submit" class="fadeIn fourth" name="button">
    </form>

  </div>
</div>
</html>

<?php
}else{
try{
 $url    = "http://localhost:8080/MP-Scouting/scout?wsdl";
 $client = new SoapClient(
   $url,array("trace" => 1) 
 
  );
  
  $email = htmlentities($_POST['Email']);
  $email = strip_tags($_POST['Email']);
  
  //$password = MD5($_POST["Password"]);
  
  $parameters = array("arg0"=> $email,
					"arg1"=> $_POST["Password"],
					"arg2"=> $_POST["utenza"]);
}catch(SoapFault $ex){
   //echo $ex->getMessage();
   $msg="connessione non riuscitaaaaaa";
   header("Location:utils\MP-ErrorPage.php?errore=".$msg);;//pagina di errore
}

try{
 $response = $client->valida($parameters);
 if($response->return<0){
	 $msg="Email e/o password errate";
	 header("Location:utils\MP-ErrorPage.php?errore=".$msg);
 }else{
 echo "Benvenuto ".$response->return;
 initSession($response->return);
 header("Location:php\MP-SceltaScout.php");
 }
}catch(SoapFault $ex){
   //echo $ex->getMessage();
   $msg="Connessione non riuscita";
   header("Location:utils\MP-ErrorPage.php?errore=".$msg);;//pagina di errore
}
/*
 $soap_request = $client->__getLastRequest();   
 $soap_response = $client->__getLastResponse();
 echo "<xmp>";
 echo "SOAP request:\n$soap_request\n";
 echo "SOAP response:\n$soap_response\n";
 echo "</xmp>";*/
}
?>
