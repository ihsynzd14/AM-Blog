<?php
      include('../config/dbcon.php');
      include('validations/controllo-blog.php');
      include('authentication.php');
      include('includes/header.php'); 

      $uidCorrente=$_SESSION['auth_user']['user_id'];
      $check_limit = "SELECT * FROM blogs WHERE b_uid = $uidCorrente ";
      $check_limit_run = mysqli_query($con,$check_limit);

         if(mysqli_num_rows($check_limit_run) >= 3 && $_SESSION['auth_role'] == 0){
            $_SESSION['message'] = "Hai superato il limite massimo di blog per gli utenti normali!";
            ?><script> location.replace("coautori-view.php"); </script>
            <?php
            exit(0);
                        }          
  ?>

<div class="container-fluid px-4">
                        <h1 class="mt-4">Pannello di Gestione</h1>
                <div class="row">
                  <div class="col-md-12">
                    <?php include('includes/message.php') ?>
                    <div class="card">
                        <div class="card-header">
                              <h4>Aggiungi Blog
                                <a href="coautori-view.php" class="btn btn-danger float-end">Indietro</a>
                              </h4>
                            <div class="card-body">


                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="b_uid" value="<?= $_SESSION['auth_user']['user_id']; ?>">
                                      <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="">Lista Argomenti</label>
                                            <?php
                                            if($_SESSION['auth_role'] == 1 || $_SESSION['auth_role'] == 2 ) {
                                              $argomento="SELECT * FROM argomenti WHERE status='0' OR status='2' ";
                                              $argomento_run = mysqli_query($con,$argomento);  
                                            }
                                             elseif($_SESSION['auth_role'] == 0){
                                              $argomento="SELECT * FROM argomenti WHERE status='0'";
                                              $argomento_run = mysqli_query($con,$argomento);  
                                            }

                                            if(mysqli_num_rows($argomento_run) > 0)
                                            {
                                                    ?>
                                                    
                                                    <select name="b_aid"  class="form-control">
                                                        <option value="">-- Scegli Argomento --</option>
                                                            <?php
                                                            foreach($argomento_run as $argo){
                                                                ?>
                                                                        <option value="<?= $argo['aid'];?>"
                                                                        <?= $argo['aid'] == $b_aid ? 'selected' : '' ?>>
                                                                        <?= $argo['nome'];?> </option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </option>
                                                    </select>
                                                    <span class="error"><?php echo $argErr;?></span>

                                                    <?php
                                            }   
                                            else
                                            {
                                                ?>
                                                <h5>Al momento non c'è nessun argomento</h5>
                                                <?php
                                            } 
                                            ?>
                                        </div>

    

                                          <div class="col-md-6 mb-3">
                                            <label for="">Nome</label>
                                            <input   type="text" name="nome"  value="<?= $nome; ?>" class="form-control">
                                            <span class="error text-danger"><?php echo $nomeErr;?></span>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Slug (URL)</label>
                                            <input   type="text" name="slug" value="<?= $slug; ?>" class="form-control">
                                            <span class="error text-danger"><?php echo $slugErr;?></span>
                                          </div>
                                          <div class="col-md-12 mb-3">
                                            <label for="">Descrizione</label>
                                            <textarea name="descrizione" row="4" value="<?= $descrizione; ?>"  class="form-control"></textarea>
                                            <label for="">Per il momento è possibile scrivere semplice testo, in seguito con "Modifica blog" si potrà editare il testo</label>
                                            <span class="error text-danger"><?php echo $descrizioneErr;?></span>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Carica Immagine</label>
                                            <input   type="file" name="immagine" class="form-control">
                                            <span class="error text-danger"><?php echo $imgErr;?></span>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Status</label>
                                            <input type="checkbox" name="status"  width="70px" height="70px"/>
                                            <span class="error text-danger"><?php echo $stsErr;?></span>
                                          </div>
                                          <div class="col-md-12 mb-3">
                                            <button type="submit" name="blog_add" class="btn btn-primary">Salva Post</button>
                                        </div>
                                      </div>
                                    </form>
                                    <?php include('validations/execute-blog.php')?>

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