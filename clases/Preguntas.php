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
        for($r=0;$r<$num;$r+++) $vector[$r]=0;
        for($r=0;$r<$num;$r++){
            //Almacenar en el vector las preguntas aleatoriamente
            $alea=rand(1,$pregExistentes);
            $bandera=true;
            for($f=0;$f<$r;$f++)
                if($vector[$f]==$alea){
                    $bandera=false;
                    break;
                }
            if(!$bandera){ $r-; continue; }
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
}
?>
