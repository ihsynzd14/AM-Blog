<?php session_start(); include('../config/dbcon.php');?>
<?php include('validations/controllo-utente.php') ?> 
<?php
if($_SESSION['auth_role'] == 0 || $_SESSION['auth_role'] == 2) // ospiti non hanno $_SESSIONE['auth'];
{
    $_SESSION['message'] = "Devi essere un Admin per accedere qui !";
    header("Location: index.php");
    exit(0);
}  
?>

<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
                        <h1 class="mt-4">Pannello di Gestione</h1>
                <div class="row">
                  <div class="col-md-12">
              <?php include('includes/message.php') ?>
                    <div class="card">
                        <div class="card-header">
                              <h4>Aggiungi Utente
                                <a href="utente-view.php" class="btn btn-danger float-end">Indietro</a>
                              </h4>
                            <div class="card-body">

                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                      <div class="row">
                                          <div class="col-md-6 mb-3">
                                            <label for="">Username</label>
                                            <input type="text" name="username" class="form-control">
                                            <span class="text-danger"> <?= $usernameErr; ?></span>

                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Email</label>
                                            <input type="text" name="email" class="form-control">
                                            <span class="text-danger"> <?= $emailErr; ?></span>

                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Nome</label>
                                            <input type="text" name="nome"  class="form-control">
                                            <span class="text-danger"> <?= $nameErr; ?></span>

                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Cognome</label>
                                            <input type="text" name="cognome"  class="form-control">
                                            <span class="text-danger"> <?= $surnameErr; ?></span>
                                          </div>
                                          
                                          <div class="input-control">
                                          <div class="form-group mb-3">
                                          <label>Codice Fiscale</label>                      
                                           <input  type="text" maxlength="16" name="cfiscale" value="<?= $cfiscale; ?>" placeholder="Inserire Codice Fiscale" class="form-control">
                                           <span class="text-danger"> <?= $cfiscaleErr; ?></span>
                                          </div>
                                          </div>

                                          <div class="col-md-6 mb-3">
                                            <label for="">Password</label>
                                            <input type="password" name="password" class="form-control">
                                            <span class="text-danger"> <?= $passwordErr; ?></span>

                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Data di nascita</label>
                                            <input type="date" name="d_nascita"  class="form-control">
                                            <div class="text-danger"> <?= $d_nascitaErr; ?></div>

                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Biografia</label>
                                            <input style="height:60px" type="text" name="biografia"  maxlength="500" class="form-control">
                                            <span class="text-danger"> <?= $biografiaErr; ?></span>

                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Ruolo</label>
                                            <select name="ruolo" class="form-control">
                                              <option value="">--Selezionare Ruolo--</option>
                                              <option value="1">Admin</option>
                                              <option value="0">Utente</option>
                                              <option value="2">Utente Premium</option>
                                            </select>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Status</label>
                                            <input type="checkbox" name="status" width="70px" height="70px"/>
                                          </div>
                                          <div class="col-md-12 mb-3">
                                            <button type="submit" name="aggiungi_utente" class="btn btn-primary">Aggiungi Utente</button>
                                        </div>
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
include('includes/scripts.php'); 
?>