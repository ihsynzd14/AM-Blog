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
                              <h4>Aggiungi Co-Autore
                                <a href="coautori-view.php" class="btn btn-danger float-end">Indietro</a>
                              </h4>
                            <div class="card-body">
                            <?php
                                if(isset($_GET['id']))
                                {
                                    $blog_id = $_GET['id'];
                                    $blog_query = "SELECT * FROM blogs WHERE bid = '$blog_id' LIMIT 1";
                                    $blog_query_result = mysqli_query($con,$blog_query);

                                    $co_query = "SELECT * FROM coautori";
                                    $co_query_result = mysqli_query($con,$co_query);

                                    if(mysqli_num_rows($blog_query_result ) > 0)
                                    {
                                            $row = mysqli_fetch_array($blog_query_result);
                                            $cos = mysqli_fetch_array($co_query_result);
                                            ?>


                            <form action="panel-codes.php" method="POST" enctype="multipart/form-data">
                                
                                    <input type="hidden" name="bid" value="<?= $row['bid'] ?>">  
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="">Lista Co-Autori</label>
                                            <?php
                                            $uidOwnerBlog = $row['b_uid'];
                                            $uidCorrente = $_SESSION['auth_user']['user_id'];
                                            $user="SELECT u.* FROM utenti u WHERE  u.uid != $uidCorrente AND u.uid != $uidOwnerBlog";
                                            $user_run = mysqli_query($con,$user);
                                            
                                            if(mysqli_num_rows($user_run) > 0)
                                            {
                                                    ?>
                                                    <input type="hidden" name="autore_id" value=<?= $uidCorrente;?> > </input> 

                                                    <select name="coautore_id" required class="form-control">
                                                        <option value="">-- Scegli Co-Autore --</option>
                                                            <?php
                                                            foreach($user_run as $uno){
                                                                ?>
                                                                        <option value="<?= $uno['uid'];?>">
                                                                        <?= $uno['username'];?>
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
                                                <h5>Al momento non c'è nessun Co-Autore</h5>
                                                <?php
                                            } 
                                            ?>
                                        </div>
                                          <div class="col-md-12 mb-3">
                                            <button type="submit" name="aggiungi_coautore" class="btn btn-primary">Aggiungi Co-Autore</button>
                                        </div>
                                      </div>
                                    </form>
                                            
                                    <?php
                                    }
                                }
                                ?>
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