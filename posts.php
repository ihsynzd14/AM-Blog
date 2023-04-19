<?php 
include('includes/header.php');
include('includes/navbar.php');

if(isset($_SESSION['auth'])){
    $uidCorrente = $_SESSION['auth_user']['user_id'];
}

if(isset($_GET['titolo']))
{ 
//slug prende il valore di URL dove titolo = "prendequestovalore" (questa caso slug di post)
 $slug = mysqli_real_escape_string($con,$_GET['titolo']);
}

//quando si clicca delete ti porta a index.php
if (isset($_POST['delete'])){
    header('location: posts.php?titolo='.$slug);
}

//quando si clicca submit ti porta a index.php
if (isset($_POST['comment'])){
    $comment = $_POST['content'];
    header('location: posts.php?titolo='.$slug);
}

if (isset($_POST['liked'])){
   $postid = $_POST['postid'];
   $result = mysqli_query($con,"SELECT * FROM posts WHERE pid = $postid");
   $rox = mysqli_fetch_array($result);
   $n = $rox['likes'];

   mysqli_query($con,"UPDATE posts SET likes=$n+1 WHERE pid = $postid");
   mysqli_query($con,"INSERT INTO likes(userid,postid) VALUES ($uidCorrente,$postid)");
   header('location: posts.php?titolo='.$slug);
   exit(0);
}

if (isset($_POST['unliked'])){
   $postid = $_POST['postid'];
   $result = mysqli_query($con,"SELECT * FROM posts WHERE pid = $postid");
   $rox = mysqli_fetch_array($result);
   $n = $rox['likes'];

   mysqli_query($con,"DELETE FROM likes WHERE postid = $postid AND userid = $uidCorrente ");
   mysqli_query($con,"UPDATE posts SET likes=$n-1 WHERE pid = $postid");
   header('location: posts.php?titolo='.$slug);
   exit(0);
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<div class="py-5">
    <div class="container">
        <div class="row">
        <?php include('includes/message.php');?>     
            <div class="col-md-9">
            <?php
            // se dichiarato e diverso da null prende valore di URL dove titolo = "prendequestovalore" (questa caso post di slug)
            if(isset($_GET['titolo']))
            { 
            
                //slug prende valore di URL dove titolo = "prendequestovalore" (questa caso slug di post)
                $slug = mysqli_real_escape_string($con,$_GET['titolo']);
                //
                $posts = "SELECT * FROM posts WHERE slug ='$slug'";
                $posts_run = mysqli_query($con,$posts);
                
                if(mysqli_num_rows($posts_run) > 0)
                {
                        foreach($posts_run as $posto)
                        {
                            ?>

                                <div class="card card-body shadow-sm mb-4">
                                    <div class="card-header">
                                        <h5><?= $posto['nome'];?></h5>
                                    </div>

                                    <div class="card-body">
                                        <label class="text-dark me-2">Postato: <?= date('d-M-Y', strtotime($posto['data_postato']));?></label>
                                        <hr/>
                                        <?php // se esiste immagine falla vedere, se non esiste immagine non mostra icona con errore di foto vuota?>
                                        <?php if($posto['immagine'] != null) : ?> 
                                        <img src="caricati/posts/<?= $posto['immagine'];?>" class="w-25" />
                                        <hr/>
                                        <?php endif; ?>
                                        
                                    <div>
                                           <?= $posto['descrizione']; ?>
                                        
                                        </div>
                                    </div>
                                </div>
                                <form method="post"> 
                                <?php $pxID = $posto['pid'];  ?> 
                                <input type="hidden" name="postid" value="<?php echo $pxID?>">
                                <?php if(isset($_SESSION['auth'])){
                                $sl = "SELECT * FROM likes where userid = $uidCorrente AND postid = $pxID";
                                $res = mysqli_query($con,$sl);                                
                                if(mysqli_num_rows($res) > 0 ){ ?>
                                <button type="submit" class="unlike fa fa-thumbs-up" name="unliked" value="<?php echo $pxID?>">  </button>  <span><?php echo $posto['likes']." persone hanno messo like";?></span>
                                <?php } else {?>
                                <button type="submit" class="like fa fa-thumbs-o-up" name="liked" value="<?php echo $pxID?>"> </button>   <?php if($posto['likes'] > 0){ ?> <span><?php echo $posto['likes']." persone ha messo like";?></span> <?php }else {?> <span><?php echo "nessuno ha messo like";?></span> <?php } ?>
                                <?php } } elseif(!isset($_SESSION['auth'])){
                                 ?>
                                    <span><?php echo $posto['likes']." persone hanno messo like";?></span>
                                <?php }?>
                                <br/><a class="btn w-10" href="list-likes.php?titolo=<?= $posto['slug'];?>">Chi ha messo like? </a>
                                </form>                              
                             <?php
                        }

                }
                else
                {
                    ?>
                    <h4>Non esiste nessun post così!</h4>
                    <?php
                }
            }
            else
            {
                ?>
                    <h4>Non esiste nessun URL così!</h4>
                <?php
            }
            ?>

<?php include('post-comments.php') ?>
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

