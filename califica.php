<?php
session_start();
?>
<?php
$matricula=$_SESSION['idu'];
require ('helpers.php');
require ('templete/header.php');
require ('clases/Preguntas.php');
require ('bd/bd.php');
// $num = 6; // asegurarse q la bd tenga >=10 preguntas
// diseño estatico para solo revisar diez preguntas
$preg[0] = (isset($_POST['preg1'])?$_POST['preg1']:NULL);
$preg[] = (isset($_POST['preg2'])?$_POST['preg2']:NULL);
$preg[] = (isset($_POST['preg3'])?$_POST['preg3']:NULL);
$preg[] = (isset($_POST['preg4'])?$_POST['preg4']:NULL);
$preg[] = (isset($_POST['preg5'])?$_POST['preg5']:NULL);
$preg[] = (isset($_POST['preg6'])?$_POST['preg6']:NULL);
$respDada[0] = (isset($_POST['0'])?$_POST['0']:NULL);
$respDada[] = (isset($_POST['1'])?$_POST['1']:NULL);
$respDada[] = (isset($_POST['2'])?$_POST['2']:NULL);
$respDada[] = (isset($_POST['3'])?$_POST['3']:NULL);
$respDada[] = (isset($_POST['4'])?$_POST['4']:NULL);
$respDada[] = (isset($_POST['5'])?$_POST['5']:NULL);
if(!$preg||!$respDada){
    echo "<p>Acceso invalido</p>";
}
else{
    $conexion = mysql_connect("localhost","root","qwerty");
    if(!$conexion){
        echo "<p>Error: No se puede conectar al servidor<br>\n";
    }
    else{
        $bd = mysql_select_db("examen",$conexion);
        if(!$bd){
            echo "<p>Error: No se pudo seleccionar la bd<br>\n";
         }
        else{
            $calif=0;
            $consulta = mysql_query("select nombre from usuarios where matricula='$matricula'",$conexion);
            echo "<h2> Calificacion </h2>\n";
            echo "<p> Alumno:".mysql_result($consulta,0,'nombre')." matricula $matricula </p>\n";
            for($cju=0;$cju<sizeof($preg);$cju++){
                $consulta = mysql_query("select idr from corresponde where idp='$preg[$cju] and sipi=1'",$conexion);
                $idres = mysql_result($consulta,0,'idr');
                $consulta = mysql_query("select respuesta from respuestas where idr='$idres'",$conexion);
                $respuest = mysql_result($consulta,0,'respuesta');
                if($respDada[$cju]==$respuest) $calif+=1;
            }
            mysql_query("update usuarios set calif='$calif', presento=1 where matricula='$matricula'",$conexion);
            mysql_Close($conexion);
            echo "<p>Has obtenido: $calif  respuestas buenas.</p>";

        }
    }
}
require ('templete/footer.php');
?>
