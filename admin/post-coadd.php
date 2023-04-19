<?php include('../config/dbcon.php');
      include('validations/controllo-post.php');
      include('authentication.php');
      include('includes/header.php'); 

      $uidCorrente=$_SESSION['auth_user']['user_id'];
      $check_limit = "SELECT * FROM posts WHERE p_uid = $uidCorrente ";
      $check_limit_run = mysqli_query($con,$check_limit);

  if(mysqli_num_rows($check_limit_run) >= 2 && $_SESSION['auth_role'] == 0){
    $_SESSION['message'] = "Hai superato il limite massimo di post per gli utenti normali!";
    ?><script> location.replace("post-view.php"); </script>
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
                              <h4>Aggiungi Post
                                <a href="post-view.php" class="btn btn-danger float-end">Indietro</a>
                              </h4>
                            <div class="card-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="p_uid" value="<?= $_SESSION['auth_user']['user_id']; ?>">
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
                                                    <select name="p_bid"  class="form-control">
                                                        <option value="">-- Scegli Blog --</option>
                                                            <?php
                                                            foreach($blog_run as $blogx){
                                                                ?>
                                                                        <option value="<?= $blogx['bid'];?>"
                                                                        <?= $blogx['bid'] == $p_bid ? 'selected' : '' //se blog id uguale post blog modifica; altrimenti non fa niente ?>>
                                                                        <?= $blogx['nome'];?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </option>
                                                    </select>
                                                    <span class="error"><?php echo $blogErr;?></span>
                                                    <?php
                                            }   
                                            else
                                            {
                                                ?>
                                                <h5>Al momento non ci sono blog</h5>
                                                <?php
                                            } 
                                            ?>
                                        </div>
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
                                            <textarea name="descrizione" row="4" class="form-control"><?= $descrizione; ?></textarea>
                                            <label for="">Per il momento è possibile scrivere semplice testo, in seguito con "Modifica post" si potrà editare il testo</label>
                                            <span class="error text-danger"><?php echo $descrizioneErr;?></span>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Carica Immagina</label>
                                            <input  type="file" name="immagine" class="form-control">
                                            <span class="error text-danger"><?php echo $imgErr;?></span>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                            <label for="">Status</label>
                                            <input type="checkbox" name="status" width="70px" height="70px"/>
                                            <span class="error text-danger"><?php echo $stsErr;?></span>

                                          </div>
                                          <div class="col-md-12 mb-3">
                                            <button type="submit" name="post_add" class="btn btn-primary">Salva Post</button>
                                        </div>
                                      </div>
                                    </form>
                                    <?php include('validations/execute-post.php')?>

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