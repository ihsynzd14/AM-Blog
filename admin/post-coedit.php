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
                              <h4>Modifica Post
                                <a href="post-view.php" class="btn btn-danger float-end">Indietro</a>
                              </h4>
                            <div class="card-body">
                                <?php
                                if(isset($_GET['id']))
                                {
                                    $post_id = $_GET['id'];                
                                    $post_query = "SELECT * FROM posts WHERE pid = '$post_id' LIMIT 1";
                                    $post_query_result = mysqli_query($con,$post_query);

                                    if(mysqli_num_rows($post_query_result ) > 0)
                                    {
                                            $row = mysqli_fetch_array($post_query_result);
                                            ?>


                            <form action="panel-codes.php" method="POST" enctype="multipart/form-data">
                                
                                    <input type="hidden" name="pid" value="<?= $row['pid'] ?>">  
                                    <div class="row">
                                       
                                        <div class="col-md-12 mb-3">
                                            <label for="">Lista Blogs</label>
                                            <?php
                                            
                                            $uidCorrente = $_SESSION['auth_user']['user_id'];

                                            if($_SESSION['auth_role'] == 1){
                                              $blog="SELECT * FROM blogs WHERE status='0' ";
                                              $blog_run = mysqli_query($con,$blog);  
                                            }
                                            elseif($_SESSION['auth_role'] == 0 || $_SESSION['auth_role'] == 2 ){
                                              $blog="SELECT b.* FROM coautori c, blogs b,utenti u WHERE b.status='0' AND b.b_uid = u.uid AND b.bid = c.blog_id  AND c.coautore_id = $uidCorrente ";
                                              $blog_run = mysqli_query($con,$blog);  
                                            }

                                            if(mysqli_num_rows($blog_run) > 0)
                                            {
                                                    ?>
                                                    <select name="p_bid" required class="form-control">
                                                        <option value="">-- Scegli Blog --</option>
                                                            <?php
                                                            foreach($blog_run as $blogx){
                                                                ?>      
                                                                        <option value="<?= $blogx['bid']; //prende il valore che ho selezionato ?>"        
                                                                        <?= $blogx['bid'] == $row['p_bid'] ? 'selected' : '' //se blog id uguale post blog id modifica; altrimenti non fa niente ?>>
                                                                        <?= $blogx['nome'];?>
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
                                                <h5>Al momento non ci sono Blog</h5>
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
                                            <label for="">Carica Immagina</label><br/>
                                            Se non viene caricata nessuna nuova immagine, l'immagine inserita in precedenza rimane salvata 
                                            <input type="hidden" name="vecchio_immagine" value="<?= $row['immagine'] ?>"/>
                                            <input type="file" name="immagine"  class="form-control">
                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Status</label><br/>
                                            <input type="checkbox" name="status" <?= $row['status']=='1' ? 'checked' : '' ?> width="70px" height="70px"/>
                                            Checked = Archiviato, Unchecked= Visibile
                                          </div>
                                          <div class="col-md-12 mb-3">
                                            <button type="submit" name="aggiorna_post" class="btn btn-primary">Aggiorna Post</button>
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