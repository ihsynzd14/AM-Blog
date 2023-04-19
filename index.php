<script src="assets/js/slide.js"> </script>
<?php 
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5 bg-secondary">
    <div class="container">
        <div class="row ">
            <div class="col-md-12 ">
            <h3 class="text-white text-center">Argomenti</h3>
            <div class="underline "></div>
            </div>

  <?php
          if(isset($_SESSION['auth']) && ($_SESSION['auth_role']== 1 || $_SESSION['auth_role']== 2 )){
          //creiamo una query per risultare tutti argomenti
          $home_argomento = "SELECT * FROM argomenti WHERE status='2' ";
          $home_argomento_run = mysqli_query($con,$home_argomento);

          $home_argomentonormale = "SELECT * FROM argomenti WHERE status='0' ";
          $home_argomentonormale_run = mysqli_query($con,$home_argomentonormale);
          
          // se esiste risultato
          if(mysqli_num_rows($home_argomento_run) > 0)
          {
            //fai click per ogni riga di risultato
            foreach($home_argomento_run as $argomento)
            {
              ?>
                <div class="d-flex-col mb-4 ms-4 ">
                    <a class="text-dark text-decoration-none" href="argomento-premium.php?titolo=<?= $argomento['slug']; ?>">
                            <div class="card card-body text-center fw-bold">
                            <?= $argomento['nome']; ?>
                            </div>
                        </div>
                    </a>
              <?php
            }
          } 
          if(mysqli_num_rows($home_argomentonormale_run) > 0)
          {
            //fai click per ogni riga di risultato
            foreach($home_argomentonormale_run as $argomento)
            {
              ?>
                <div class="d-flex-col mb-4 ms-4 ">
                    <a class="text-dark text-decoration-none" href="argomento.php?titolo=<?= $argomento['slug']; ?>">
                            <div class="card card-body text-center fw-bold">
                            <?= $argomento['nome']; ?>
                            </div>
                        </div>
                    </a>
              <?php
            }
          }
          
          
          else {
            ?>
                    <h4 class="text-white text-center">Non ci sono Argomenti!</h4>            
          <?php
                  }
                }
                
                else{
                          //creiamo una query per risultare tutti argomenti
                  $home_argomento = "SELECT * FROM argomenti WHERE status ='0'";
                  $home_argomento_run = mysqli_query($con,$home_argomento);

                  if(mysqli_num_rows($home_argomento_run) > 0)
                  {
                    //fai click per ogni riga di risultato
                    foreach($home_argomento_run as $argomento)
                    {
                      ?>
                        <div class="d-flex-col mb-4 ms-4 ">
                            <a class="text-dark text-decoration-none" href="argomento.php?titolo=<?= $argomento['slug']; ?>">
                                    <div class="card card-body text-center fw-bold">
                                    <?= $argomento['nome']; ?>
                                    </div>
                                </div>
                            </a>
                      <?php
                    }
                  } 
                  else {
                    ?>
                            <h4 class="text-white text-center">Non ci sono Argomenti!</h4>            
                  <?php
                          }
                }
        ?>
        </div>
    </div>
</div>



    <section class="product "> 
    <h2 class="product-category">Blogs</h2>
    <button class="pre-btn"><img src="assets/images/arrow.png" alt=""></button>
    <button class="nxt-btn"><img src="assets/images/arrow.png" alt=""></button>
    <div class="product-container">
    <?php
          if(isset($_SESSION['auth']) && ($_SESSION['auth_role']== 1 || $_SESSION['auth_role']== 2 )){
          $home_blogs = "SELECT b.*, u.username,u.uid FROM blogs b,utenti u WHERE b.status ='0' AND b.b_uid = u.uid ORDER BY b.data_postato ASC";
          $home_blogs_run = mysqli_query($con,$home_blogs);
          }
          else
          {
            $home_blogs = "SELECT b.*, u.username,u.uid,a.status FROM blogs b,utenti u,argomenti a WHERE a.aid = b.b_aid AND a.status ='0' AND b.status ='0' AND b.b_uid = u.uid  ORDER BY b.data_postato ASC";
            $home_blogs_run = mysqli_query($con,$home_blogs);  
          }
          
          if(mysqli_num_rows($home_blogs_run) > 0)
          {
            foreach($home_blogs_run as $blog)
            {
              ?>
        

            <div class="product-card">
                <div class="product-image">
                    <img src="caricati/blogs/<?= $blog['immagine'];?>" class="product-thumb" width="60px" height="60px" />
                    <button class="card-btn"> <a href="blogs.php?titolo=<?= $blog['slug']; ?>" class=" fw-bold text-white" style="text-decoration:none;"> Vai al Blog </a></button>
                </div>
                <div class="product-info">
                    <h2 class="product-brand"><?= $blog['nome'] ?></h2>
                    <p class="product-short-description">di: <a style="text-decoration:none;" class="p-1 mb-2 bg-dark text-white" href="profiles.php?id=<?= $blog['uid'] ?>" ><?= $blog['username'] ?></a></p>
                </div>
            </div>
        <?php
            }
          } 
          else {
            ?>
            <h2 class="text-danger text-center">Non ci sono blog!</h2>
            <?php
          }
        ?>
                </div>
                </div>
    </section>

    <div class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
            <h3 class="text-dark">Progetto Blog_am</h3>
            <div class="underline"></div>
            </div>
            <p>
                Questo sito è stato creato per utenti che vogliono condividere liberamente blog, post e commenti.
            </p>
        </div>
    </div>
</div>

<div class="py-5 bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
            <h3 class="text-dark">Post recenti</h3>
            <div class="underline"></div>
        </div>
    </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
  
        <?php
          if(isset($_SESSION['auth']) && ($_SESSION['auth_role']== 1 || $_SESSION['auth_role']== 2 )){
          $home_posts = "SELECT p.*, u.username, u.uid FROM posts p, utenti u WHERE p.p_uid = u.uid AND p.status = '0' ORDER BY p.data_postato ASC";
          $home_post_run = mysqli_query($con,$home_posts);
          }
          else {
          $home_posts = "SELECT a.*,b.*,p.*, u.username, u.uid FROM argomenti a, blogs b, posts p, utenti u WHERE a.status ='0' AND b.status ='0' AND a.aid = b.b_aid AND p.p_bid = b.bid AND p.p_uid = u.uid AND p.status = '0' ORDER BY p.data_postato ASC";
          $home_post_run = mysqli_query($con,$home_posts);
          }
          

          if(mysqli_num_rows($home_post_run ) > 0)
          {
            foreach($home_post_run  as $post)
            {
              ?>        
                <div class="col">
                  <div class="card">
                  <img src="caricati/posts/<?= $post['immagine'];?>" class="card-img-top"/>
                    <div class="card-body">
                      <h5 class="card-title"><?= $post['nome']; ?></h5>
                      <p class="card-text">
                      <?php echo html_entity_decode(substr($post['descrizione'], 0, 500) . '</br><strong><i>.... Per leggere tutto il post devi cliccarci sopra</i></strong>'); ?>
                      </p>
                        <p class="product-short-description">da: <a style="text-decoration:none;" class="p-1 mb-2 bg-dark text-white" href="profiles.php?id=<?= $post['uid'] ?>" ><?= $post['username'] ?></a></p>
                    </div>
                    <button class="btn btn-dark"> <a href="posts.php?titolo=<?= $post['slug']; ?>" class=" fw-bold text-white" style="text-decoration:none;"> Vai al Post </a></button>

                  </div>
                </div>
                <?php
                          }
                        }
                        else {
                            ?>
                                <h2 class="text-danger text-center">Non ci sono post!</h2>
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
      </div>
    </div>
  </div>
</div>


<?php 
include('includes/footer.php');
?>
