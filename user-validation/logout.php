<?php
session_start();

if(isset($_POST['logout_btn']))
{
    //disinserita informazione di auth che era true, auth_role = 1/0, auth_user[ user_id , user_username.....]
    unset($_SESSION['auth']);
    unset($_SESSION['auth_role']);
    unset($_SESSION['auth_user']);
    
    $_SESSION['message'] = "Hai fatto logout!";
    header("Location: ../login.php");
    exit(0);
}


?>