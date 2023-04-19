<?php

$nameErr = $surnameErr  = $usernameErr = $cfiscaleErr = $emailErr  = $passwordErr  = $d_nascitaErr = $biografiaErr = $ruoloErr  = NULL;
//inizialmente  sono dichiarati tutti null
$name = $surname  = $username = $email = $cfiscale  = $password  = $d_nascita = $biografia  = $ruolo = NULL;

// flag è il nostro controllore, se il nome non viene scritto, viene flag false, e non dà il permesso di all'utente di registrarsi 
$flag = true;
  
// prende il form del register con il suo method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

// se variabile nome e' vuoto
    if (empty($_POST["nome"])) {
        //dichiari errore con il suo messaggio
        $nameErr = "* Nome richiesto";
        //flag torna dal true al false perche non possiamo dargli il permesso di registrarsi / mandare un input vuoto al DATABASE
        $flag = false;
    } 
    // se non (!empty)
    else {
        // variabile name va function test_input, poi se ci sono i caratteri e spazi e backslashes vengono rimossi
        $name = mysqli_escape_string($con,test_input($_POST["nome"]));
        //qui e' $flag = true
    }

    if (empty($_POST["cognome"])) {
        $surnameErr = "* Cognome richiesto";
        $flag = false;
    } else {
        $surname = mysqli_escape_string($con,test_input($_POST["cognome"]));
        //qui e' $flag = true
    }

    if (empty($_POST["username"])) {
        $usernameErr = "* Username richiesto";
        $flag = false;
    } else {
        $username = mysqli_escape_string($con,test_input($_POST["username"]));
        //qui e' $flag = true
    }

    if (empty($_POST["email"])) {
        $emailErr = "* Email richiesto";
        $flag = false;
    }
    else {  
        $email = mysqli_escape_string($con,test_input($_POST["email"]));
        //qui e' $flag = true
    }  


    
    if (empty($_POST["d_nascita"])) {
        $d_nascitaErr = "* Data di nascita richiesto";
        $flag = false;
    } else {
        $d_nascita = mysqli_escape_string($con,test_input($_POST["d_nascita"]));
        //qui e' $flag = true
    }

    if (empty($_POST["biografia"])) {
        $biografiaErr = "* Biografia richiesto  ";
        $flag = false;
    } else {
        $biografia = mysqli_escape_string($con,test_input($_POST["biografia"]));
        //qui e' $flag = true
    }

    if (empty($_POST["cfiscale"])) {
        $cfiscaleErr = "* Codice Fiscale richiesto";
        $flag = false;
    } else {
        $cfiscale = mysqli_escape_string($con,test_input($_POST['cfiscale']));
        //qui e' $flag = true
    }


    if (empty($_POST["password"])) {
        $passwordErr = "* Password richiesto";
        $flag = false;
    } else {
        $password = mysqli_escape_string($con,$_POST["password"]);
        //qui e' $flag = true
    }

    if (empty($_POST["ruolo"])) {
        $ruoloErr = "* Argomento richiesto!";
        $flag = false;
      } else {
        $ruolo = mysqli_escape_string($con,test_input($_POST["ruolo"]));
      }
    
    // regular expressions --- qui se email non vuota e non contiene preg_match(la nostra regular exp, email)
    if (!empty($email) && !preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
        $emailErr = "* Email non valida";
        $flag = false;
    }
    else {  
        $email = mysqli_escape_string($con,test_input($_POST["email"]));
        //qui e' $flag = true
    }   


    if (!preg_match("/^[A-Za-z]{6}[0-9]{2}[A-Za-z]{1}[0-9]{2}[A-Za-z]{1}[0-9]{3}[A-Za-z]{1}$/",$cfiscale)) {
        $cfiscaleErr = "* Codice Fiscale non valido!";
        $flag = false;
    }
    else {  
        $cfiscale = mysqli_escape_string($con,test_input($_POST['cfiscale']));
        //qui e' $flag = true
    }  


// in registrazione per nome si possono mettere solo lettere dell'alfabeto
    if (!preg_match("/^[a-zA-Z]*$/",$name)) {
        $nameErr = "* Per Nome sono ammesse solo lettere";
        $flag = false;
    }
    else {  
        $name = test_input($name);
        //qui e' $flag = true
    }  



    if (!preg_match("/^[a-zA-Z]*$/",$surname)) {
        $surnameErr = "* Per Cognome sono ammesse solo lettere";
        $flag = false;
    }
    else {  
        $surname = test_input($surname);
        //qui e' $flag = true
    }  


    // Preparazione di SQL per utente già registrato con la stessa email
    $check_email = "SELECT * FROM utenti WHERE email='$email' LIMIT 1";
    // Esegui query al database
    $check_email_run = mysqli_query($con, $check_email);

    if(mysqli_num_rows($check_email_run) > 0){
        $emailErr = "* Un utente con questa email già esiste!";
        $flag = false;
    }

    // Preparazione di SQL per utente già registrato con lo stesso username
    $check_username = "SELECT * FROM utenti WHERE username='$username' LIMIT 1";
    // Esegui query al database
    $check_username_run = mysqli_query($con, $check_username);

    if(mysqli_num_rows($check_username_run) > 0){
        $usernameErr = "* Un utente con questo username già esiste!";
        $flag = false;
    }

 // submit form if validated successfully  
 if ($flag) {

    //maschera password (nasconde la vera password)
    $password_hashed = password_hash($password,PASSWORD_DEFAULT);

    // connetto il mio database
    $conn = new mysqli('localhost', "root", "", "blog_am");
    // se le credenziali sono invalide mi dà errore
    if (!$conn) {
        die("connection failed error: " . $conn->connect_error);
    }
         
         $sql = "INSERT INTO utenti (username,email,nome,cognome,cfiscale,password,d_nascita,biografia,ruolo) VALUES ('$username','$email','$name','$surname','$cfiscale','$password_hashed','$d_nascita','$biografia','$ruolo')";   
            
         if ($conn->query($sql) === TRUE) {
         $_SESSION['message'] = "Registrazione completata, ora sei un Utente Premium !";
         // mi diretta login.php
         header("Location: utente-view.php");
         // termina il codice
         exit(0);
         }
}
}

function test_input($data)
{                                                     
    $data = trim($data); //trim togle i spazi doppi tripli   
    $data = stripslashes($data); // rimuove backslashes 
    $data = htmlspecialchars($data); // l'apice va convertita il la sua versione (es: D´Orletta = D&#180;Orletta)
    return $data; // lo stato finale 
}

?> 