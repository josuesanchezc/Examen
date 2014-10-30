<?php
/**
 * Created by PhpStorm.
 * User: MAQ11-LAB2-TIC
 * Date: 12/09/14
 * Time: 06:57 PM
 */
$bd_name= "examen";
$bd_server="localhost";
$bd_user="root";
$bd_pass="qwerty";
$bd_connection = mysql_connect($bd_server,$bd_user,$bd_pass)or die ("error de conexion");
mysql_select_db($bd_name,$bd_connection) or die("la bd no existe");
mysql_query("SET NAMES utf8");
?>