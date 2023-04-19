<?php 
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row">

            <div class="col-md-9">
            <?php
            // se dichiarato diverso dal null la variabile di $_GET['titolo']  
            if(isset($_GET['titolo']))
            {
                // prendiamo dall' url il valore di titolo come nostro slug di argomento
                $slug = mysqli_real_escape_string($con,$_GET['titolo']);
                // query che ci darà l'argomento id e slug dove slug = URL corrente slug
                $argomento = "SELECT * FROM argomenti WHERE slug='$slug' AND status = '0'  LIMIT 1";
                // esegui query
                $argomento_run = mysqli_query($con,$argomento);
                
                // se esiste risultato 
                if(mysqli_num_rows($argomento_run) > 0)
                {
                    //trasforma la data in array
                    $argomento_fetched = mysqli_fetch_array($argomento_run);
                    
                    $arg_id = $argomento_fetched['aid'];
                    
                    ?>
                    <div class="card card-body shadow-sm mb-4">
                        <h5>Argomento <?= $argomento_fetched['nome'];?></h5>
                        <div>
                            <?= $argomento_fetched['descrizione'];?>
                    </div>
                      </div>
                     </a>
                     <?php

               
                    $blogs = "SELECT b.b_aid,b.nome,b.slug,b.data_postato,u.username AS utentenome,u.uid FROM blogs b, utenti u WHERE b.b_aid ='$arg_id' AND b.b_uid = u.uid AND b.status='0' ";
                    $blogs_run = mysqli_query($con,$blogs);

                    // se esiste risultato
                    if(mysqli_num_rows($blogs_run) > 0)
                    {
                        // fa solo un ciclo per argomento di php
                        foreach($blogs_run as $blogo)
                        {
                            ?>
                            
                            <a href="blogs.php?titolo=<?= $blogo['slug'];?>" class="text-decoration-none">
                            <div class="card card-body shadow-sm mb-4">
                                <h5><?= $blogo['nome'];?></h5>
                                <div>
                                <label class="text-dark me-2">Postato da: <?= $blogo['utentenome'] ;?> &nbsp; Data: <?= date('d-M-Y', strtotime($blogo['data_postato'])) ;?></label>
                                </div>
                              </div>
                             </a>
                             <?php
                        }
                    }
                    else
                    {
                        ?>
                        <h4>Non esiste nessun blog cosi !</h4>
                        <?php 
                    }
                }
                else
                {
                    ?>
                    <h4>Non esiste nessun argomento cosi !</h4>
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

