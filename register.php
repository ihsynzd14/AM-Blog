<?php 
include('includes/header.php');
include('includes/navbar.php');

//se variabile dichiarata è diversa da NULL 
// $_SESSION['auth'] una cosa che abbiamo creato nel logincode.php per determinare se un utente ha già effettuato l'accesso ($_SESSION['auth']= true;) o se è un ospite senza accesso (NULL) 
if(isset($_SESSION['auth']))
{
    // un utente con accesso non può andare in register.php
     $_SESSION['message'] = "Hai gia fatto registrazione non potresti accedere di la!";
     // manda l' utente alla pagina di index.php
     header("Location: index.php");
     // termina il codice corrente
     exit(0);
}


?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">

            <?php include('includes/message.php');?>            
            <?php include('user-validation/registercode.php');?>            
            
            <div class="card">
                    <div class="card-header">
                        <h4>Registrazione</h4>
                    </div>
                    <div class="card-body">

                <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">Attenzione!</h4>
                <p>Se sei minorenne sarai un utente normale e avrai alcuni limiti:</br>potrai pubblicare blog,&nbsp;post e commenti in numero limitato.</p>
                <hr>
                <p class="mb-0">Se sei maggiorenne, invece sarai un utente premium ed oltre ad avere infinite azioni potrai visualizzare qualsiasi tipo di contenuto.</p>
                </div>
</br>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <div class="input-control">
                            <div class="form-group mb-3">
                                <label>Username</label> 
                                <input type="text" maxlength="20" name="u_nome" value="<?= $username; ?>" placeholder="Inserire Username" class="form-control" >
                                <span class="text-danger"> <?= $usernameErr; ?></span>
                            </div>
                            </div>
                            <div class="input-control">
                            <div class="form-group mb-3">
                                <label>Email</label>  
                                <input  type="text" maxlength="35" name="email" value="<?= $email; ?>" placeholder="Inserire Email" class="form-control">
                                <span class="text-danger"> <?= $emailErr; ?></span>
                            </div>
                            </div>
                            <div class="input-control">
                            <div class="form-group mb-3">
                                <label>Nome</label>
                                <input  type="text" maxlength="20" name="nome" value="<?= $name; ?>" placeholder="Inserire Nome" class="form-control">
                                <span class="text-danger"> <?= $nameErr; ?></span>
                            </div>
                            </div>
                            <div class="input-control">
                            <div class="form-group mb-3">
                                <label>Cognome</label>                      
                                <input  type="text" maxlength="20" name="cognome" value="<?= $surname; ?>" placeholder="Inserire Cognome" class="form-control">
                                <span class="text-danger"> <?= $surnameErr; ?></span>
                            </div>
                            </div>
                            <div class="input-control">
                            <div class="form-group mb-3">
                                <label>Codice Fiscale</label>                      
                                <input  type="text" maxlength="16" name="cfiscale" value="<?= $cfiscale; ?>" placeholder="Inserire Codice Fiscale" class="form-control">
                                <span class="text-danger"> <?= $cfiscaleErr; ?></span>
                            </div>
                            </div>
                            <div class="input-control">
                            <div class="form-group mb-3">
                                <label>Password</label>                                              
                                <input  type="password" maxlength="16"  name="password" value="<?= $password; ?>" placeholder="Inserire Password" class="form-control">
                                <label class="text-secondary" for="password">*La password deve contenere un carattere speciale e un numero </br>*un minimo di 8 ed un massimo di 16 caratteri.</label>
                                <span class="text-danger"> <?= $passwordErr; ?></span>
                            </div>
                            </div>
                            <div class="input-control">
                            <div class="form-group mb-3">
                                <label>Conferma Password</label>
                                <input  type="password" maxlength="16" name="cpassword"  value="<?= $cpassword; ?>" placeholder="Conferma Password" class="form-control">
                                <span class="text-danger"> <?= $cpasswordErr; ?></span>
                            </div>
                            </div>
                            <div class="input-control">
                            <div class="form-group mb-3">
                                <label>Data di nascita</label> 
                                <input  type="date" max="2020-12-31" min="1940-12-31" onkeydown="return false;" name="d_nascita" value="<?= $d_nascita; ?>" placeholder="Inserire data di nascita" class="form-control">
                                <label>&nbsp;Selezionare dal calendario</label> 
                                <div class="text-danger"> <?= $d_nascitaErr; ?></div>
                            </div>
                            </div>
                            <div class="input-control">
                            <div class="form-group mb-3">
                                <label>Biografia</label>
                                <textarea  type="text"  name="biografia" maxlength="500" placeholder="Inserire biografia (max. 500 caratteri)" class="form-control"><?= $biografia; ?></textarea>
                                <span class="text-danger"> <?= $biografiaErr; ?></span>
                            </div>
                            </div>
                            <div class="form-group mb-3">
                            <button type="submit" name="register_btn" class="btn btn-primary">Registrati Ora</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>

<?php 
include('includes/footer.php');
?>

