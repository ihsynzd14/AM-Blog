<?php include('../config/dbcon.php'); ?>
<?php include('authentication.php'); ?>
<?php include('includes/header.php');  $uidCorrente = $_SESSION['auth_user']['user_id']?>

<div class="container-fluid px-4">
                        <h1 class="mt-4">Pannello di Gestione</h1><br/>
                        <?php include('includes/message.php') ?>
                        <div class="row">
                            <?php if($_SESSION['auth_role'] == 1){ ?>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Totale argomenti
                                        <?php
                                            $dash_argomento_query = "SELECT * FROM argomenti";
                                            $dash_argomento_query_run = mysqli_query($con,$dash_argomento_query);
                                            
                                            if($argomento_tot = mysqli_num_rows($dash_argomento_query_run))
                                            {
                                                echo '<h4 class="mb-0">'.$argomento_tot.'</h4>';
                                            }
                                            else
                                            {
                                                echo '<h4 class="mb-0">Nessun risultato trovato!</h4>';
                                            }
                                        ?>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="argomento-view.php">Vedi dettagli</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                                <?php } ?>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Totale posts
                                    <?php
                                            if($_SESSION['auth_role'] == 1){
                                            $dash_posts_query = "SELECT * FROM posts";
                                            $dash_posts_query_run = mysqli_query($con,$dash_posts_query);
                                            }
                                            elseif($_SESSION['auth_role'] == 0 ||$_SESSION['auth_role'] == 2 ){
                                            $dash_posts_query = "SELECT * FROM posts WHERE p_uid = $uidCorrente";
                                            $dash_posts_query_run = mysqli_query($con,$dash_posts_query);    
                                            }

                                            if($posts_tot = mysqli_num_rows($dash_posts_query_run))
                                            {
                                                echo '<h4 class="mb-0">'.$posts_tot.'</h4>';
                                            }
                                            else
                                            {
                                                echo '<h4 class="mb-0">Nessun risultato trovato!</h4>';
                                            }
                                        ?>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="post-view.php">Vedi dettagli</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Totale Blogs
                                    <?php
                                            if($_SESSION['auth_role'] == 1){
                                            $dash_blogs_query = "SELECT * FROM blogs";
                                            $dash_blogs_query_run = mysqli_query($con,$dash_blogs_query);
                                            }
                                            elseif($_SESSION['auth_role'] == 0 ||$_SESSION['auth_role'] == 2 ){
                                            $dash_blogs_query = "SELECT * FROM blogs WHERE b_uid = $uidCorrente";
                                            $dash_blogs_query_run = mysqli_query($con,$dash_blogs_query);    
                                            }
                                            if($blogs_tot = mysqli_num_rows($dash_blogs_query_run))
                                            {
                                              echo '<h4 class="mb-0">'.$blogs_tot.'</h4>';
                                            }
                                            else
                                            {
                                                echo '<h4 class="mb-0">Nessun risultato trovato</h4>';
                                            }
                                        ?>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="coautori-view.php">Vedi dettagli</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <?php if($_SESSION['auth_role'] == 1){ ?>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Utenti Totali
                                    <?php
                                            $dash_utenti_query = "SELECT * FROM utenti";
                                            $dash_utenti_query_run = mysqli_query($con,$dash_utenti_query);
                                            if($utenti_tot = mysqli_num_rows($dash_utenti_query_run))
                                            {
                                                echo '<h4 class="mb-0">'.$utenti_tot.'</h4>';
                                            }
                                            else
                                            {
                                                echo '<h4 class="mb-0">Nessun risultato trovato!</h4>';
                                            }
                                        ?>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="utente-view.php">Vedi dettagli</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        
</div>




<?php 
include('includes/footer.php'); 
include('includes/scripts.php'); 
?>