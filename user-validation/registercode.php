<?php

$nameErr = $surnameErr  = $cfiscaleErr =  $usernameErr = $emailErr  = $passwordErr  = $cpasswordErr  = $d_nascitaErr = $biografiaErr  = NULL;
//inizialmente tutti sono dichiarati null
$name = $surname  = $cfiscale = $username = $email  = $password  = $cpassword  = $d_nascita = $biografia  = NULL;

// flag è il nostro controllore, se nome non scritto viene flag false e non dà il permesso all'utente di registrarsi
$flag = true;
  
// prende il form del register con il suo method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

// se variabile nome è vuota
    if (empty($_POST["nome"])) {
        //dichiaro errore con il suo messaggio
        $nameErr = "*Nome richiesto";
        //flag torna dal true al false perchè non possiamo dare il permesso di registrarsi / mandare input vuoto al DATABASE
        $flag = false;
    } 
    // se non (!empty)
    else {
        // variabile name va in function test_input poi se ci sono i caratteri e spazi e backslashes vengono rimossi
        $name = test_input($_POST["nome"]);
        //qui e' $flag = true
    }

    if (empty($_POST["cognome"])) {
        $surnameErr = "* Cognome richiesto";
        $flag = false;
    } else {
        $surname = test_input($_POST["cognome"]);
        //qui e' $flag = true
    }

    if (empty($_POST["cfiscale"])) {
        $cfiscaleErr = "* Codice Fiscale richiesto";
        $flag = false;
    } else {
        $cfiscale = test_input($_POST["cfiscale"]);
        //qui e' $flag = true
    }

    if (empty($_POST["u_nome"])) {
        $usernameErr = "* Username richiesto";
        $flag = false;
    } else {
        $username = test_input($_POST["u_nome"]);
        //qui e' $flag = true
    }

    if (empty($_POST["email"])) {
        $emailErr = "* Email richiesta";
        $flag = false;
    }
    else {  
        $email = test_input($_POST["email"]);
        //qui e' $flag = true
    }  
        
    if (empty($_POST["d_nascita"])) {
        $d_nascitaErr = "* Data di nascita richiesta!";
        $flag = false;
    } else {
        $d_nascita = test_input($_POST["d_nascita"]);
        //qui e' $flag = true
    }

    if (empty($_POST["biografia"])) {
        $biografiaErr = "* Biografia richiesta!";
        $flag = false;
    } else {
        $biografia = test_input($_POST["biografia"]);
        //qui e' $flag = true
    }


    if (empty($_POST["password"])) {
        $passwordErr = "* Password richiesta";
        $flag = false;
    } else {
        $password = $_POST["password"];
        //qui e' $flag = true
    }

    if (empty($_POST["cpassword"])) {
        $cpasswordErr = "* Conferma della password richiesta!";
        $flag = false;
    } else {
        $cpassword = $_POST["cpassword"];
        //qui e' $flag = true
    }

    if(!empty($password && $cpassword)){
    //controllo di password e conferma della password
    if ($password != $cpassword) {
        $cpasswordErr = "* Le password non corrispondono!";
        $flag = false;
    } else if($password == $cpassword) {
        $password =  $_POST["password"]; 
        $cpassword = $_POST["cpassword"];
        //qui e' $flag = true
     }
    }

    
    // regular expressions --- qui dico se email non vuota e non coincide con preg_match(la nostra regular exp, email)
    if (!empty($email) && !preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
        $emailErr = "* Formato non valido per email";
        $flag = false;
    }
    else {  
        $email = test_input($_POST['email']);
        //qui e' $flag = true
    }   

// in registrazione per nome si possono mettere solo le lettere dell'alfabeto
    if (!preg_match("/^[a-zA-Z]*$/",$name)) {
        $nameErr = "* Solo lettere ammesse per Nome";
        $flag = false;
    }
    else {  
        $name = test_input($_POST['nome']);
        //qui e' $flag = true
    }  

// in registrazione per password si devono mettere min 8 e max 16, almeno 1 numero e 1 carattere speciale

    if (strlen($password) < 8 || strlen($password) > 16) {
        $passwordErr = "La Password deve contenere min 8 carattere ed max 16 caratteri";
        $flag = false;
    }
    if (!preg_match("/\d/", $password)) {
        $passwordErr = "La Password deve contenere almeno 1 numero";
        $flag = false;
    }
    if (!preg_match("/\W/", $password)) {
        $passwordErr = "La Password deve contenere almeno un carattere speciale";
    }



    if (!preg_match("/^[A-Za-z]{6}[0-9]{2}[A-Za-z]{1}[0-9]{2}[A-Za-z]{1}[0-9]{3}[A-Za-z]{1}$/",$cfiscale)) {
        $cfiscaleErr = "* Codice Fiscale non valido!";
        $flag = false;
    }
    else {  
        $cfiscale = test_input($_POST['cfiscale']);
        //qui e' $flag = true
    }  



    if (!preg_match("/^[a-zA-Z]*$/",$surname)) {
        $surnameErr = "* Solo lettere ammesse per Cognome";
        $flag = false;
    }
    else {  
        $surname = test_input($surname);
        //qui e' $flag = true
    }  


    // Preparazione di SQL per utente già registrato con stessa email
    $check_email = "SELECT * FROM utenti WHERE email='$email' LIMIT 1";
    // Esegui query al database
    $check_email_run = mysqli_query($con, $check_email);

    if(!empty($_POST['email']) && mysqli_num_rows($check_email_run) > 0){
        $emailErr = "* Un utente con questa email già esiste!";
        $flag = false;
    }

    // Preparazione di SQL per utente già registrato con stesso username
    $check_username = "SELECT * FROM utenti WHERE username='$username' LIMIT 1";
    // Esegui query al database
    $check_username_run = mysqli_query($con, $check_username);

    if(!empty($_POST['u_nome']) && mysqli_num_rows($check_username_run) > 0){
        $usernameErr = "* Un utente con questo username già esiste!";
        $flag = false;
    }

    // submit form if validated successfully  
    if ($flag) {

        //maschera password (nascondere il vero password)
        $password_hashed = password_hash($password,PASSWORD_DEFAULT);

        // connetto il mio database
        $conn = new mysqli('localhost', "root", "", "blog_am");
        // se credenziali sono invalide mi dà errore
        if (!$conn) {
            die("connection failed error: " . $conn->connect_error);
        }
 
        $bday = new DateTime($d_nascita); // Your date of birth
        $today = new Datetime(date('m.d.y'));
        $diff = $today->diff($bday); //funzione differenza tra today e bday
        $eta = $diff->y;      //prendo solo years

        // se ho fatto la connessione al mio database e eseguito la query alla mia tabella 
       
            if($eta > 17){
             
             $sql = "INSERT INTO utenti (username,email,nome,cognome,cfiscale,password,d_nascita,biografia,ruolo) VALUES ('$username','$email','$name','$surname','$cfiscale','$password_hashed','$d_nascita','$biografia','2')";   
                
             if ($conn->query($sql) === TRUE) {
             $_SESSION['message'] = "Registrazione completata! Ora sei un utente Premium !";
             // mi diretta in login.php
             header("Location: login.php");
             // termina il codice
             exit(0);
             }

            }

            elseif ($eta < 18) {

                $sql = "INSERT INTO utenti (username,email,nome,cognome,cfiscale,password,d_nascita,biografia) VALUES ('$username','$email','$name','$surname','$cfiscale','$password_hashed','$d_nascita','$biografia')";   

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['message'] = "Registrazione completata sei un utente!";
                    // mi diretta in login.php
                    header("Location: login.php");
                    // termina il codice
                    exit(0);
                    }
        }
    }
}


function test_input($data)
{                                                     
    $data = trim($data); //trim togle gli spazi doppi tripli   
    $data = stripslashes($data); // rimuove backslashes '\'   HTML \ LEZIONE = HTML LEZIONE
    $data = htmlspecialchars($data); // l'apice viene convertito con la sua versione (es: D´Orletta = D&#180;Orletta)
    return $data; // stato finale 
}

?> 