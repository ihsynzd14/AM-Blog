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
                            <div class="card-body">
                            <h4>Blogs & Utenti a cui hai dato il permesso di modificare
                                
                                </h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Argomento</th>
                                                    <th>Co-Autore</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                     $uidCorrente = $_SESSION['auth_user']['user_id'];
                                                     $cols = "SELECT c.*,b.*,b.nome AS blogname, a.nome AS argomento_nome, u.nome AS usernome FROM coautori c, utenti u, blogs b,argomenti a WHERE c.blog_id = b.bid AND  a.aid = b.b_aid AND c.coautore_id = u.uid AND c.coautore_id != $uidCorrente AND c.autore_id = $uidCorrente";
                                                     $cols_run = mysqli_query($con,$cols);

                                                     if(mysqli_num_rows($cols_run) > 0)
                                                     {
                                                         foreach($cols_run as $col)
                                                         { 
                                                            
                                                                                                                                                                                 
                                                            {
                                                            ?>
                                                            <tr>

                                                            <td><?= $col['nome'];?></td>
                                                            <td><?= $col['argomento_nome'];?></td>
                                                            <td>
                                                                    <?= $col['usernome'];?>
                                                            </td>

                            
                                                            </tr>
                                                            
                                                            <?php
                                                            }
                                                           
                                                         }   
                                                       
                                                     } 
                                                     else{
                                                         ?>

                                                         <tr>
                                                         <td colspan="6">Al momento non c'è nessun Co-Autore</td>
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
                            <div class="card-body">
                            <div class="card-body">
                            <h4>Blogs di cui sei Co-Autore                                                                                                                                                  
                                
                                </h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Argomento</th>
                                                    <th>Modifica</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                     $uidCorrente = $_SESSION['auth_user']['user_id'];
                                                     $cols = "SELECT c.*,b.*,b.nome AS blogname, a.nome AS argomento_nome, u.nome AS usernome FROM coautori c, utenti u, blogs b,argomenti a WHERE c.blog_id = b.bid AND a.aid = b.b_aid AND c.coautore_id = u.uid AND c.coautore_id = $uidCorrente";
                                                     $cols_run = mysqli_query($con,$cols);

                                                     if(mysqli_num_rows($cols_run) > 0)
                                                     {
                                                         foreach($cols_run as $col)
                                                         { 
                                                            
                                                                                                                                                                                 
                                                            {
                                                            ?>
                                                            <tr>

                                                            <td><?= $col['nome'];?></td>
                                                            <td><?= $col['argomento_nome'];?></td>                                                    
                                                            <td><a href="blog-edit.php?id=<?= $col['bid'];?>" class="btn btn-success">Modifica</a></td>                                                    
                                                            </tr>
                                                            
                                                            <?php
                                                            }
                                                           
                                                         }   
                                                       
                                                     } 
                                                     else{
                                                         ?>

                                                         <tr>
                                                         <td colspan="6">Al momento non sei Co-Autore di nessun blog</td>
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
                            
                            <div class="card-body">
                            <div class="card-header">

                            <?php if ($_SESSION['auth_role'] == 1):?>  
                            <h4>Lista di tutti i blogs del sito
                                <a href="blog-add.php" class="btn btn-primary float-end">Aggiungi Blog</a>
                              </h4>

                              <?php elseif ($_SESSION['auth_role'] == 0 || $_SESSION['auth_role'] == 2):?> 
                                <h4>Lista dei Tuoi Blogs
                                <a href="blog-add.php" class="btn btn-primary float-end">Aggiungi Blog</a>
                              </h4>
                              <?php endif; ?> 
                            </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Blog ID</th>
                                                    <th>Nome</th>
                                                    <th>Argomento</th>
                                                    <th>Immagine</th>
                                                    <th>Status</th>
                                                    <th>Aggiungi Coautore</th>
                                                    <th>Modifica Blog</th>
                                                    <th>Elimina Coautore</th>
                                                    <th>Elimina Blog</th>

                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                <?php 

                                                    if($_SESSION['auth_role'] == 0)
                                                    {
                                                     //$blogs = "SELECT * FROM blogs WHERE status!='2'";
                                                     $uidCorrente = $_SESSION['auth_user']['user_id'];
                                                     $blogs = "SELECT b.*, a.nome AS argomento_nome FROM blogs b,argomenti a WHERE a.aid = b.b_aid AND b.b_uid = $uidCorrente";
                                                     $blogs_run = mysqli_query($con,$blogs);
                                                    }
                                                    else if($_SESSION['auth_role'] == 1){
                                                     //$blogs = "SELECT * FROM blogs WHERE status!='2'";
                                                     $uidCorrente = $_SESSION['auth_user']['user_id'];
                                                     $blogs = "SELECT b.*, a.nome AS argomento_nome FROM blogs b,argomenti a WHERE a.aid = b.b_aid";
                                                     $blogs_run = mysqli_query($con,$blogs);

                                                    }
                                                    elseif($_SESSION['auth_role'] == 2)
                                                    {
                                                     //$blogs = "SELECT * FROM blogs WHERE status!='2'";
                                                     $uidCorrente = $_SESSION['auth_user']['user_id'];
                                                     $blogs = "SELECT b.*, a.nome AS argomento_nome FROM blogs b,argomenti a WHERE b.b_uid = $uidCorrente AND a.aid = b.b_aid";
                                                     $blogs_run = mysqli_query($con,$blogs);
                                                    }

                                                     if(mysqli_num_rows($blogs_run) > 0)
                                                     {
                                                         foreach($blogs_run as $blog)
                                                         { 
                                                            
                                                                                                                                                                                 
                                                            {
                                                            ?>
                                                            <tr>
                                                            <td><?= $blog['bid'];?></td>
                                                            <td><?= $blog['nome'];?></td>
                                                            <td><?= $blog['argomento_nome'];?></td>
                                                            <td>  <img src="../caricati/blogs/<?= $blog['immagine'];?>" width="60px" height="60px" /></td>
                                                            <td><?= $blog['status'] == '1' ? 'Archiviato' : 'Visibile' ?></td>
                                                            <td>
                                                                 <a href="coautori-add.php?id=<?= $blog['bid'];?>" class="btn btn-primary">Aggiungi Coautore</a>
                                                            </td>
                                                            <td>
                                                                <a href="blog-edit.php?id=<?= $blog['bid'];?>" class="btn btn-success">Modifica Blog</a>
                                                            </td>
                                                            <td>
                                                                <form action="panel-codes.php" method="POST">
                                                                <button type="submit" name="elimina_coautori" value="<?= $blog['bid'];?>" class="btn btn-danger">Elimina Tutti Coautori</button>
                                                                </form>
                                                                
                                                            </td>
                                                            <td>
                                                            <form action="panel-codes.php" method="POST">
                                                                <button type="submit" name="elimina_blog" value="<?= $blog['bid'];?>" class="btn btn-danger">Elimina Blog</button>
                                                                </form>                                                               
                                                            </td>
                                                            </tr>
                                                            
                                                            <?php
                                                            }
                                                           
                                                         }   
                                                       
                                                     } 
                                                     else{
                                                         ?>

                                                         <tr>
                                                         <td colspan="6">Per il momento non hai blog!</td>
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
</div>



<?php 
include('includes/footer.php'); 
include('includes/scripts.php'); 
?>