<?php session_start(); include('../config/dbcon.php');?>
<?php include('validations/controllo-argomento.php') ?> 

<?php
if($_SESSION['auth_role'] == 0 || $_SESSION['auth_role'] == 2) // ospiti non hanno $_SESSIONE['auth'];
{
    $_SESSION['message'] = "Devi essere Admin per aggiungere un argomento!";
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
                              <h4>Aggiungi Argomento
                                <a href="argomento-view.php" class="btn btn-danger float-end">Indietro</a>
                              </h4>
                            <div class="card-body">
                              

                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    
                            <input type="hidden" name="a_uid" value="<?= $_SESSION['auth_user']['user_id']; ?>">

                                      <div class="row">
                                          <div class="col-md-6 mb-3">
                                            <label for="">Nome</label>
                                            <input  type="text" name="nome" value="<?= $nome; ?>" class="form-control">
                                            <span class="error text-danger"><?php echo $nomeErr;?></span>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Slug (URL)</label>
                                            <input  type="text" name="slug" value="<?= $slug; ?>" class="form-control">
                                            <span class="error text-danger"><?php echo $slugErr;?></span>
                                          </div>
                                          <div class="col-md-12 mb-3">
                                            <label for="">Descrizione</label>
                                            <textarea   name="descrizione" row="4" class="form-control"><?= $descrizione; ?></textarea>
                                            <span class="error text-danger"><?php echo $descrizioneErr;?></span>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Status</label>
                                            <select name="status"   class="form-control">
                                               <option value="3">-- Scegli Argomento --</option>
                                               <option value="0">-- Visibile --</option>
                                               <option value="2">-- Contenuto Adulto --</option>
                                               <option value="1">-- Archiviato --</option>
                                             </select>
                                            <span class="error text-danger"><?php echo $stsErr;?></span>
                                          </div>
                                          <div class="col-md-12 mb-3">
                                            <button type="submit" name="argomento_add" class="btn btn-primary">Salva Argomento</button>
                                        </div>
                                      </div>
                                    </form>
                                    <?php include('validations/execute-argomento.php')?>

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