<?php

$titulo= 'Bienvenidos al siguiente cuestionario';
$contenido = 'Da clik en la opcion del menu "Cuestionario"';

$variables = array('titulo'=>$titulo,
    'contenido'=>$contenido);
view('home',$variables);

?>