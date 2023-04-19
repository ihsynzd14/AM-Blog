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
                        <?php if ($_SESSION['auth_role'] == 1):?> 
                              <h4>Lista di tutti i posts del sito
                                <a href="post-add.php" class="btn btn-primary float-end">Aggiungi Post</a>
                              </h4>

                              <?php elseif ($_SESSION['auth_role'] == 0 || $_SESSION['auth_role'] == 2):?> 
                                <h4>Lista dei tuoi Posts
                                <a href="post-add.php" class="btn btn-primary float-end">Aggiungi Post</a>
                              </h4>

                              <?php endif; ?> 

                            <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Post ID</th>
                                                    <th>Nome</th>
                                                    <th>Blog</th>
                                                    <th>Immagine</th>
                                                    <th>Proprietario</th>
                                                    <th>Status</th>
                                                    <th>Modifica Post</th>
                                                    <th>Elimina Post</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    if($_SESSION['auth_role'] == 0)
                                                    {
                                                     $uidCorrente = $_SESSION['auth_user']['user_id'];
                                                     $posts = "SELECT p.*, b.nome AS blog_nome,u.nome AS utente_nome FROM posts p, blogs b, utenti u WHERE b.bid = p.p_bid AND u.uid = b.b_uid AND b.b_uid = $uidCorrente ORDER BY b.nome ASC";
                                                     $posts_run = mysqli_query($con,$posts);
                                                    }
                                                    elseif($_SESSION['auth_role'] == 2)
                                                    {
                                                     $uidCorrente = $_SESSION['auth_user']['user_id'];
                                                     $posts = "SELECT p.*, b.nome AS blog_nome,u.nome AS utente_nome FROM posts p, blogs b, utenti u WHERE b.bid = p.p_bid AND u.uid = b.b_uid AND b.b_uid = $uidCorrente ORDER BY b.nome ASC";
                                                     $posts_run = mysqli_query($con,$posts);
                                                    }
                                                    else if($_SESSION['auth_role'] == 1)
                                                    {
                                                     $uidCorrente = $_SESSION['auth_user']['user_id'];
                                                     $posts = "SELECT p.*,  b.nome AS blog_nome,u.nome AS utente_nome FROM posts p, blogs b, utenti u WHERE b.bid = p.p_bid AND p.p_uid = u.uid ORDER BY b.nome ASC";
                                                     $posts_run = mysqli_query($con,$posts);
                                                    }


                                                     if(mysqli_num_rows($posts_run) > 0)
                                                     {
                                                         foreach($posts_run as $post)
                                                         {
                                                            ?>
                                                            <tr>
                                                            <td><?= $post['pid'];?></td>
                                                            <td><?= $post['nome'];?></td>
                                                            <td><?= $post['blog_nome'];?></td>
                                                            <td>  <img src="../caricati/posts/<?= $post['immagine'];?>" width="60px" height="60px" /></td>
                                                            <td><?= $post['utente_nome'];?></td>
                                                            <td><?= $post['status'] == '1' ? 'Archiviato' : 'Visibile'  //? -if  | : -else ?></td>
                                                            <td>
                                                                <a href="post-edit.php?id=<?= $post['pid'];?>" class="btn btn-success">Modifica post</a>
                                                            </td>
                                                            <td>
                                                                <form action="panel-codes.php" method="POST">
                                                                <button type="submit" name="elimina_post" value="<?= $post['pid'];?>" class="btn btn-danger">Elimina post</button>
                                                                </form>
                                                                
                                                            </td>
                                                            </tr>
                                                            <?php
                                                         }   
                                                     }
                                                     else{
                                                         ?>

                                                         <tr>
                                                         <td colspan="6">Nessun post trovato!</td>
                                                         </tr>

                                                         <?php
                                                        }
                                                ?>
                                                <tr>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                        </div>
                        <br/>
                    <div class="card">
                        <div class="card-header">
                              <h4>Lista dei post di cui sei Co-Autore
                              <a href="post-coadd.php" class="btn btn-warning float-end">Aggiungi Post da Co-Autore</a>
                              </h4>
                            <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Post ID</th>
                                                    <th>Nome</th>
                                                    <th>Blog</th>
                                                    <th>Immagine</th>
                                                    <th>Proprietario</th>
                                                    <th>Status</th>
                                                    <th>Modifica</th>
                                                    <th>Elimina</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                               $posts = "SELECT p.*, c.*, b.nome AS blog_nome,u.nome AS utente_nome FROM posts p, blogs b,coautori c, utenti u WHERE b.bid = p.p_bid AND c.blog_id = b.bid AND p.p_uid = u.uid AND c.coautore_id = $uidCorrente AND c.autore_id != $uidCorrente ORDER BY b.nome ASC";
                                               $posts_run = mysqli_query($con,$posts);

                                                     if(mysqli_num_rows($posts_run) > 0)
                                                     {
                                                         foreach($posts_run as $post)
                                                         {
                                                            ?>
                                                            <tr>
                                                            <td><?= $post['pid'];?></td>
                                                            <td><?= $post['nome'];?></td>
                                                            <td><?= $post['blog_nome'];?></td>
                                                            <td>  <img src="../caricati/posts/<?= $post['immagine'];?>" width="60px" height="60px" /></td>
                                                            <td><?= $post['utente_nome'];?></td>
                                                            <td><?= $post['status'] == '1' ? 'Archiviato' : 'Visibile' ?></td>
                                                            <td>
                                                                <a href="post-coedit.php?id=<?= $post['pid'];?>" class="btn btn-success">Modifica</a>
                                                            </td>
                                                            <td>
                                                                <form action="panel-codes.php" method="POST">
                                                                <button type="submit" name="elimina_post" value="<?= $post['pid'];?>" class="btn btn-danger">Elimina</button>
                                                                </form>
                                                                
                                                            </td>
                                                            </tr>
                                                            <?php
                                                         }   
                                                     }
                                                     else{
                                                         ?>

                                                         <tr>
                                                         <td colspan="6">Nessun risultato trovato!</td>
                                                         </tr>

                                                         <?php
                                                        }
                                                ?>
                                                <tr>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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