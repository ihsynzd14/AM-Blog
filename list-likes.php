<?php 
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        
        <div class="row">

            <div class="col-md-9">
            <?php
            // se dichiarato e diverso da null prende il valore di URL dove titolo = "prende questo valore" (questa caso post di slug)
            if(isset($_GET['titolo']))
            { 
                //slug prende valore di URL dove titolo = "prende questo valore" (questo caso slug di post)
                $slug = mysqli_real_escape_string($con,$_GET['titolo']);
                //
                $posts = "SELECT u.username,u.uid,l.data_postato AS TimeSpent,p.likes FROM utenti u,posts p, likes l WHERE p.slug ='$slug' AND p.pid = l.postid AND l.userid = u.uid ";
                $posts_run = mysqli_query($con,$posts);
                
                if(mysqli_num_rows($posts_run) > 0)
                {
                        foreach($posts_run as $posto)
                         ?>
                      
                      <div class="card card-body shadow-sm mb-4">
                    
                    <?php {
                            ?>
                                    <div class="card-header">
                                        <h5><a href="profiles.php?id=<?= $posto['uid'] ?>"><?= $posto['username'];?></a> ha messo mi piace <?php echo ($posto['TimeSpent']); ?></h5>
                                    </div> <br/>

                                <?php
                        }
                        ?>
                        </div>
                    </div>      

                    <span class="text-dark fw-bold">Ci sono <?php echo $posto['likes'];?> persone che hanno messo like</span>
                       
                    <?php

                }
                else
                {
                    ?>
                    <h4>Nessuno ha messo like!</h4>
                    <?php
                }
            }
            else
            {
                ?>
                    <h4>Non esiste nessun URL cosi !</h4>
                <?php
            }
            ?>

<br/><br/>

<a href="posts.php?titolo=<?= $slug ?>" class="btn btn-primary">Indietro</a>
</div>
    </div>
         </div>
            </div>
<?php 
include('includes/footer.php');
?>

