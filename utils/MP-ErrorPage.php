<html>

<head>
  <link href="..\css\login.css" rel="stylesheet" type="text/css">
  <style>
    input[type=button],
    input[type=submit],
    input[type=reset] {
      background-color: #56baed;
      border: none;
      color: white;
      padding: 15px 80px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      text-transform: uppercase;
      font-size: 13px;
      -webkit-box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
      box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
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
    <h2 class="active"> ERROR </h2>

    <!-- Icon -->
    <div class="fadeIn first">
      <img src="..\img\ROSSO.png" id="icon" alt="User Icon" /><br>
    </div>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/PisaSC/utils/MP_func.php';
    echo $msg = $_GET["errore"];
    echo "<form action=" . $_SERVER['PHP_SELF'] . " method=POST>";
    echo "<input type=submit name=LOGOUT value=HOME>";
    echo "</form>";
    if (isset($_POST["LOGOUT"]))
      backIndex();

    ?>

  </div>
</div>

</html>