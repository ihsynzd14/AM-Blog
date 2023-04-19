<?php

// connettere database scrivendo le credenziali
$host = "localhost";
$username = "root";
$password = "";
$database = "blog_am";

$con = mysqli_connect("$host","$username","$password","$database");

if(!$con)
{
    header("Location: ../errors/dberror.php");
    die();
}

?>