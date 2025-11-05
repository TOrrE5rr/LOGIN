<?php

$servidor = "localhost";
$user = "root" ;
$pass = "" ;
$basedatos = "sistema_login" ;

$Conn = mysqli_connect( $servidor, $user, $pass, $basedatos) ;

if( !$Conn )
{
	die("Connection failed: ".mysqli_connect_error()) ;
}

?>
