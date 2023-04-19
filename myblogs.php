<?php 
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
                <div class="card card-body text-center">
                    
<div class="py-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <h3 class="text-white">I miei Blogs</h3>
            <div class="underline"></div>
            </div>

            <?php // b_uid = '$user_id'  per my blogs --->  blog user id = current id chi ha fatto l'accesso
          //ID di utente corrente 
          // status = 0 vuol dire blog visibile 
          $user_id = $_SESSION['auth_user']['user_id'];
          $home_blog = "SELECT * FROM blogs WHERE b_uid = '$user_id' AND status ='0' ";
          // performare query
          $home_blog_run = mysqli_query($con,$home_blog);

          //se i numeri delle righe del risultato della query è maggiore di 0 vuol dire che esiste
          if(mysqli_num_rows($home_blog_run) > 0)
          {
            //fa un ciclo in cui ogni volta il risultato corre come $blogo
            foreach($home_blog_run as $blogo)
            {
              ?>
                <div class="col-md-4 mb-2">                         
                    <a class="text-decoration-none text-dark" href="blogs.php?titolo=<?= $blogo['slug']; ?>">
                            <div class="card card-body">
                              <!-- prende immagine dal folder di caricati/blogs/immagine_nome-->
                            <img src="caricati/blogs/<?= $blogo['immagine'];?>" width="200px" height="150px" /> <!--qui cambiamo la grandezza delle immagini in myblogs-->
                            <h5><?= $blogo['nome']; ?></h5>
                    </a>
                    </div>
                    </div>   
              <?php
            }
          } else {
            ?>

            <h3 class="text-white"> Per il momento non hai Blog! </h3>

            <?php
          }
        ?>
        </div>
    </div>
</div>
          
            </div>
        </div>
    </div>
</div>


<?php 
include('includes/footer.php');
?>

