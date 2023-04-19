<?php
session_start();
include('../config/dbcon.php');

if(isset($_POST['login_btn'])) // se viene attivato cliccando bottone login
{
    //dichiarazione di variabili impedire i caratteri speciali per non farli andare nel database 
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password = mysqli_real_escape_string($con,$_POST['password']);

    
 
    // Preparazione di SQL per utente già registrato per accesso
    $login_query = "SELECT * FROM utenti WHERE email='$email' LIMIT 1";
    // Esegui query al database
    $login_query_run = mysqli_query($con, $login_query);
    // numeri di righe nel risultato se sono > 0 , quell'account esiste


    if(empty($password))// se non trova nulla nella query (mysqli_num_rows($login_query_run) < 0)
    {
        $_SESSION['message']= "Password Richiesto!";
        header("Location: ../login.php");
        exit(0);
    }

    if(mysqli_num_rows($login_query_run) > 0) 
    {
        // nella query ogni riga viene assegnata come una data diversa
        //SELECT * FROM utenti WHERE email='mariateresa@yahoo.it' AND password = 'maryitsme2001' LIMIT 1
        //  2 maryitsme mariateresa@yahoo.it Maria Teresa Mazza 2022-10-25 Ciao sono mary...
        foreach($login_query_run as $data){
            $user_id = $data['uid'];   // 2
            $user_email = $data['email']; //  mariateresa@yahoo.it
            $user_username = $data['username']; // splinter967
            $user_nome = $data['nome'];   // Maria Teresa
            $user_cognome = $data['cognome'];  // Mazza
            $user_pass = $data['password'];  // maryitsme2001
            $user_dnascita = $data['d_nascita']; // 2001-02-27
            $user_biografia = $data['biografia']; // Ciao sono Mary!
            $user_role = $data['ruolo']; //0=utente 1=admin    1
            $user_stat = $data['status']; // 0=sbannati 1=bannato
            $user_timestamp = $data['data_postato']; // 2022-10-21 02:59:50
        } //non si possono stampare perchè non sono stringhe sono le date, allora vanno trasformate in stringhe
        
        // se password non è uguale alla password che l'utente ha scritto nell'input di password
        if(!password_verify($_POST['password'], $user_pass))
        {
            $_SESSION['message']= "Password non e' valido!";
            header("Location: ../login.php");
            exit(0);
        } 

        $_SESSION['auth']= true; //questo true solo per utenti che possono fare login, un ospite del sito, se non ha fatto l'accesso non ha il suo $_SESSION['auth'];
        $_SESSION['auth_role']= "$user_role"; // 0 = utente  1 = admin
        $_SESSION['auth_user']= [ // un array dove ci sono variabili con le info di un utente
            'user_id'=>$user_id,
            'user_username'=>$user_username,
            'user_nome'=>$user_nome,
            'user_cognome'=>$user_cognome,
            'user_email'=>$user_email,
        ]; // se voglio stampare il nome dell'utente che ha fatto l'accesso $_SESSION['auth_user']['user_nome']  
        // c'è un array dentro, ci sono le info che usiamo per user chi ha fatto accesso

        if($_SESSION['auth_role'] == '1') // se è un admin, lo diretta al panello di admin
        {
            $_SESSION['message']= "Ti diamo il benvenuto al pannello dell'admin!";
            header("Location: ../admin/index.php"); // 
            exit(0);
        }
        elseif($_SESSION['auth_role'] == '0') // se un utente lo diretta al index.php
        {
            $_SESSION['message']= "Hai effetuato l'accesso, sei un Utente normale!";
            header("Location: ../index.php");
            exit(0);
        }
        elseif($_SESSION['auth_role'] == '2') // se un utente lo diretta al index.php
        {
            $_SESSION['message']= "Hai effetuato l'accesso, sei un Utente Premium!";
            header("Location: ../index.php");
            exit(0);
        }


    }

    else if (!empty($email) && !preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
        $_SESSION['message']= "Email non valida!";
        header("Location: ../login.php");
        exit(0);
    }

    else if(!empty($password) && empty($email))// se non trova nulla nella query (mysqli_num_rows($login_query_run) < 0)
    {
        $_SESSION['message']= "Email Richiesta!";
        header("Location: ../login.php");
        exit(0);
    }

    else if(!empty($email) && empty($password))// se non trova nulla nella query (mysqli_num_rows($login_query_run) < 0)
    {
        $_SESSION['message']= "Password Richiesta!";
        header("Location: ../login.php");
        exit(0);
    }

    else if(empty($password) && empty($email))// se non trova nulla nella query (mysqli_num_rows($login_query_run) < 0)
    {
        $_SESSION['message']= "Email e Password Richiesti!";
        header("Location: ../login.php");
        exit(0);
    }


    else // se non trova nulla nella query (mysqli_num_rows($login_query_run) < 0)
    {
        $_SESSION['message']= "Le credenziali non sono valide";
        
        header("Location: ../login.php");
        exit(0);
    }
}
else //se qualcuno prova ad andare a login.php nell' url abbiamo questo messaggio:
     //se non viene attivato cliccando il bottone login
{
    $_SESSION['message']= "Non hai il permesso di accedere qui!";
    header("Location: ../login.php");
    exit(0);
}