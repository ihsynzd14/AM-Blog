<?php include('../config/dbcon.php');
      include('authentication.php');
      include('includes/header.php'); 
?>

<div class="container-fluid px-4">
                        <h1 class="mt-4">Pannello di Gestione</h1>
                <div class="row">
                  <div class="col-md-12">
                    <?php include('includes/message.php') ?>
                    <div class="card">
                        <div class="card-header">
                              <h4>Modifica Blog
                                <a href="coautori-view.php" class="btn btn-danger float-end">Indietro</a>
                              </h4>
                            <div class="card-body">
                                <?php
                                if(isset($_GET['id']))
                                {
                                    $blog_id = $_GET['id'];
                                    $blog_query = "SELECT * FROM blogs WHERE bid = '$blog_id' LIMIT 1";
                                    $blog_query_result = mysqli_query($con,$blog_query);

                                    if(mysqli_num_rows($blog_query_result ) > 0)
                                    {
                                            $row = mysqli_fetch_array($blog_query_result);
                                            ?>
                                            
                            <form action="panel-codes.php" method="POST" enctype="multipart/form-data">
                                
                                    <input type="hidden" name="bid" value="<?= $row['bid'] ?>">  
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
                                                    <select name="b_aid" required class="form-control">
                                                        <option value="">-- Scegli Argomento --</option>
                                                            <?php
                                                            foreach($argomento_run as $argo){
                                                                ?>
                                                                        <option value="<?= $argo['aid'];?>"
                                                                        <?= $argo['aid'] == $row['b_aid'] ? 'selected' : '' ?>>
                                                                        <?= $argo['nome'];?>
                                                                        </option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </option>
                                                    </select>
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
                                            <input  type="text" value="<?= $row['nome'] ?>" name="nome" class="form-control">
                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Slug (URL)</label>
                                            <input  type="text" value="<?= $row['slug'] ?>" name="slug" class="form-control">
                                          </div>
                                          <div class="col-md-12 mb-3">
                                            <label for="">Descrizione</label>
                                            <textarea  id="summernote" name="descrizione" row="4"  class="form-control"><?= htmlentities($row['descrizione']); ?></textarea>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Carica Immagine</label><br/>
                                            Se non si carica niente, l'immagine precedente rimane salvata 
                                            
                                            <!--- stampare valore della vecchia immagine --->
                                            <input type="hidden" name="vecchio_immagine" value="<?= $row['immagine'] ?>"/>
                                           
                                            <!--- carica nuova immagine --->
                                            <input type="file" name="immagine"  class="form-control">
                                            
                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Status</label><br/>
                                            <input type="checkbox" name="status" <?= $row['status']=='1' ? 'checked' : '0' ?> width="70px" height="70px"/>
                                            Checked = Archiviato, Unchecked= Visibile
                                          </div>
                                          <div class="col-md-12 mb-3">
                                            <button type="submit" name="aggiorna_blog" class="btn btn-primary">Aggiorna Blog</button>
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