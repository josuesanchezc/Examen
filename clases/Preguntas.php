<?php

class Preguntas {
    public function Mostrarpreguntas(){
        $num = 6; // declarar que se muestren >=6 preguntas para obetener de la bd
        echo "<center><h2> Examen de conocimientos de variedades</h2></center>\n";
        echo "<p>Bienvenido alumno</p>\n";
        // seleccionar las preguntas aleatoriamente
        $preg = mysql_query("select count(idp) as 'num' from preguntas");
        //consulta en la bd el total de preguntas
        $pregExistentes = mysql_result($preg,0,'num');
        //iniciar vector en 0
        for($r=0;$r<$num;$r++) $vector[$r]=0;
        for($r=0;$r<$num;$r++){
            //Almacenar en el vector las preguntas aleatoriamente
            $alea=rand(1,$pregExistentes);
            $bandera=true;
            for($f=0;$f<$r;$f++)
                if($vector[$f]==$alea){
                    $bandera=false;
                    break;
                }
            if(!$bandera){ $r--; continue; }
            $vector[$r]=$alea;
        }
        // carga de las preguntas
        echo '<form action="califica.php" method="post">'."\n";
        for($r=0;$r<$num;$r++){
            $preg2 = mysql_query("select preguntas from preguntas where idp='$vector[$r]'");
            $PregActu = mysql_result($preg2,0,'preguntas');
            $tp = mysql_query("select tipo from preguntas where idp='$vector[$r]'");
            $tipo = mysql_result($tp,0,'tipo');
            echo "<p>\n";
            echo "".($r+1).") ".$PregActu;
            if($tipo==1){ // Respuestas abierta en campos de texto
                echo ' <input type="text" name="'.$r.'">'."\n";
                echo ' <input type="hidden" name="preg'.($r+1).'" value="'.$vector[$r].'">'."\n";
            }
            else{ // Respuestas multiopción con radios
                $conOps = mysql_query("select idr from corresponde where idp='$vector[$r]'");
                $numResp = mysql_num_rows($conOps);
                echo "\n<br>";
                echo ' <input type="hidden" name="preg'.($r+1).'" value="'.$vector[$r].'">'."\n";
                for($i=0;$i<$numResp;$i++){
                    $cResp = mysql_query("select respuesta from respuestas where idr='".mysql_result($conOps,$i,'idr')."'");
                    $valor= mysql_result($cResp,0,'respuesta');
                    echo '<input type="radio" name="'.$r.'" value="'.$valor.'">'.$valor."<br>\n";
                }
            }
            echo "</p>\n";
        }
        echo '<input type="submit" value="Guardar">'."\n";
        echo '</form>'."\n";

    }
/*public function calificar($preg){

    if(!$preg||!$respDada){
        echo "<p>Acceso invalido</p>";
    }
    else{
        $conexion = mysql_connect("localhost","root","qwerty");
        if(!$conexion){
            echo "<p>Error: No se puede conectar al servidor<br>\n";
            echo "<a href=\"index.php\"> Regresar al homie ese</a> </p>\n";
        }
        else{
            $bd = mysql_select_db("examen",$conexion);
            if(!$bd){
                echo "<p>Error: No se pudo seleccionar la bd<br>\n";
                echo "<a href=\"Index.php\"> Regresar al homie ese</a> </p>\n";
            }
            else{
                $calif=0;
                $consulta = mysql_query("select nombre from usuarios where matricula='$matricula'",$conexion);
                echo "<h2> Calificacion </h2>\n";
                echo "<p> Alumno</p>\n";
                for($cju=0;$cju<sizeof($preg);$cju++){
                    $consulta = mysql_query("select idr from corresponde where idp='$preg[$cju] and sipi=1'",$conexion);
                    $idres = mysql_result($consulta,0,'idr');
                    $consulta = mysql_query("select respuesta from respuestas where idr='$idres'",$conexion);
                    $respuestidirijilla = mysql_result($consulta,0,'respuesta');
                    if($respDada[$cju]==$respuestidirijilla) $calif+=1;
                }
                mysql_query("update usuarios set calif='$calif', presento=1 where matricula='$matricula'",$conexion);
                mysql_Close($conexion);
                echo "<p>Ha obtenido una calificacion ".($calif>=7?"aprobatoria":"reprobatoria")." de $calif</p>";
                echo "<p><a href=\"Index.php\"> Regresar al homie ese</a> </p>\n";
            }
        }
    }


}*/

}
?>