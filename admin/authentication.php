<?php
session_start();

if(!isset($_SESSION['auth'])) // ospiti non hanno $_SESSIONE['auth'];
{
    $_SESSION['message'] = "Devi essere registrato per accedere qui !";
    header("Location: ../login.php");
    exit(0);
}   
else
{

}

?>