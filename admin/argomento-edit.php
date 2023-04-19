<?php session_start(); include('../config/dbcon.php');?>

<?php
if($_SESSION['auth_role'] == 0 || $_SESSION['auth_role'] == 2) // ospiti non hanno $_SESSIONE['auth'];
{
    $_SESSION['message'] = "Devi essere Admin per accedere qui !";
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
                              <h4>Modifica Argomento
                                <a href="argomento-view.php" class="btn btn-danger float-end">Indietro</a>
                              </h4>
                            <div class="card-body">
                                <?php
                                    if(isset($_GET['id'])) // 289
                                    {
                                    $argom_id = $_GET['id']; // 289  
                                    $argomento_modifica = "SELECT * FROM argomenti WHERE aid='$argom_id'";
                                    $argomento_modifica_run = mysqli_query($con, $argomento_modifica);

                                    if(mysqli_num_rows($argomento_modifica_run) > 0) // se esiste risultato
                                    {
                                            $row = mysqli_fetch_array($argomento_modifica_run); 
                                            ?>
                                            
                            <form action="panel-codes.php" method="POST">
                                <input type="hidden" name="aid" value="<?= $row['aid'];?>">
                                      <div class="row">
                                          <div class="col-md-6 mb-3">
                                            <label for="">Nome</label>
                                            <input  type="text" name="nome" value="<?= $row['nome'];?>" class="form-control">
                                          </div>
                                          <div class="col-md-12 mb-3">
                                            <label for="">Descrizione</label>
                                            <textarea   name="descrizione" row="4"  class="form-control"><?= $row['descrizione'];?></textarea>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Status</label>
                                            <select name="status"   class="form-control">
                                               <option value="">-- Scegli Tipo --</option>
                                               <option value="0">-- Visibile --</option>
                                               <option value="2">-- Contenuto Adulto --</option>
                                               <option value="1">-- Archiviato --</option>
                                             </select>
                                             <label>Se non viene modificato, viene selezionato il tipo salvato in precedenza</label>
                                          </div>
                                          <div class="col-md-12 mb-3">
                                            <button type="submit" name="aggiorna_argomento" class="btn btn-primary">Salva Argomento</button>
                                        </div>
                                      </div>
                                    </form>

                                    <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <h4>Nessun risultato trovato!</h4>
                                        <?php
                                    }
                                    }
                                ?>

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