<?php
require('clases/ValidarUser.php');
require ('bd/bd.php');
$sesion = new Valida();
if(isset($_POST['submit'])){
    switch($_POST['submit']){
        case "Ingresar":
            $sesion->ValidaUser("$_POST[mat]","$_POST[pas]");
            break;
    }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Test</title>
</head>
<body>
<center>
<form method="post" action="loguin.php">
    <h3>Ingresar al siguiente test</h3>
    Matricula:
    <label>
        <input type="text" name="mat" id="mat"/>
    </label>
    <p>Password:
        <label>
            <input type="password" name="pas" id="pas" />
        </label>
    </p>
    <p>
        <label>
            <input type="submit" value="Ingresar" name="submit" id="submit" />
        </label>
    </p>
  </form>
<br><div><center><font size='13' color='red'><?php $msg=$_GET['msg']; echo"$msg";?></font></center></div>
</center>
<?php
require ('templete/footer.php');
?>
</body>
</html>