<?php 
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row">
        
        <div class="col-md-9">
            <?php
            // se dichiarato nell' URL, la stringa dove titolo = uguale questa cosa che troviamo.
            if(isset($_GET['titolo']))
            {
                //if anyone tries to sql inject so that time it will escape from it !
                $slug = mysqli_real_escape_string($con,$_GET['titolo']);
                //per il caso di PHP Blog ci da risulto come bid = 2 | slug = blog-php
                $blog = "SELECT * FROM blogs WHERE slug='$slug' AND status='0' LIMIT 1";
                //eseguire query
                $blog_run = mysqli_query($con,$blog);
                
                
                //se il risultato dei numeri delle righe è maggiore di 0 
                if(mysqli_num_rows($blog_run) > 0)
                {   
                    foreach($blog_run as $blog)
                    {
                       
                        ?>
                        <div class="card card-body shadow-sm mb-4">
                        <img src="caricati/blogs/<?= $blog['immagine'];?>" width="60px" height="60px" />
                            <h5><?= $blog['nome'];?></h5>
                            <div>
                                <?= $blog['descrizione'];?>
                        </div>
                          </div>
                         </a>
                         <?php
                    }

                    // trasformare la data in array
                    $blog_fetched = mysqli_fetch_array($blog_run);
    
                    $blog_id = $blog['bid'];

                    $posts = "SELECT p.*, u.username AS utentenome,u.uid FROM posts p, utenti u WHERE p.p_bid ='$blog_id' AND p.p_uid = u.uid AND p.status='0' ";
                    $posts_run = mysqli_query($con,$posts);
                    if(mysqli_num_rows($posts_run) > 0)
                    {   // per ogni lezione post fai un ciclo 
                        foreach($posts_run as $posto)
                        {
                           
                            ?>
                            <a href="posts.php?titolo=<?= $posto['slug'];?>" class="text-decoration-none">
                            <div class="card card-body shadow-sm mb-4">
                            <img src="caricati/posts/<?= $posto['immagine'];?>" width="60px" height="60px" />
                                <h5><?= $posto['nome'];?></h5>
                                <div>
                                    <label class="text-dark me-2">Postato da: <?= $posto['utentenome'] ;?> &nbsp; Data: <?= date('d-M-Y', strtotime($posto['data_postato'])) ;?></label>
                                </div>
                              </div>
                             </a>
                             <?php
                        }
                    }
                    else
                    {
                        ?>
                        <h4>Non esiste nessun post cosi !</h4>
                        <?php 
                    }
                }
                else
                {
                    ?>
                    <h4>Non esiste nessun URL di blog cosi !</h4>
                    <?php
                }
            }
            
            ?>

            </div>

            <div class="col-md-3">
              <div class="card">
                    <div class="card-header">
                        <h4>Area pubblicitaria</h4>
                    </div>
                    <div class="card-bod">
                        La tua pubblicità
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php 
include('includes/footer.php');
?>

