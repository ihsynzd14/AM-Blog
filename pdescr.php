<?php 
include('includes/header.php');
include('includes/navbar.php');

$uidCorrente = $_SESSION['auth_user']['user_id'];
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card card-body text-center">
                <?php          //il GET controlla url e trova cosa hai inserito, nel nostro caso ID,
                // caso di isset profiles.php?id=2
                // caso non giusto per isset profiles.php
                                if(isset($_GET['id'])) 
                                {
                                    //prende id dal URL http://localhost/tblog/profiles.php?id=2 allora ---> $user_id = 2;
                                    $user_id = $_GET['id'];
                                    $user_query = "SELECT * FROM utenti WHERE uid = '$user_id' LIMIT 1";
                                    
                                    //esegue query
                                    $user_query_result = mysqli_query($con,$user_query);
                                    
                                    // se esiste il risultato
                                    if(mysqli_num_rows($user_query_result ) > 0)
                                    {
                                      $row = mysqli_fetch_array($user_query_result); // trasforma la data in array

                                            ?>

                                            <?php if($uidCorrente == $row['uid']){?>
                                    <form action="user-validation/editcode.php" method="POST">
                                      <input type="hidden" name="user_id" value="<?=$row['uid'];?>">
                                            <div class="col-md-12 mb-3">
                                            <label for="">Biografia</label>
                                            <textarea style="height:100px" type="text" name="biografia" maxlength="500" class="form-control"><?=$row['biografia'];?></textarea>
                                          </div>
                                          <div class="col-md-12 mb-3">
                                            <button type="submit" name="aggiorna_bio" class="btn btn-primary">SALVA</button>
                                        </div>
                                    </form>
                                
                                <?php
                                    }
                                    else
                                    {
                                        ?>
                                <h4>Non hai il permesso di modificare!</h4>
                                        <?php
                                    }
                                }else{
                                    ?>
                                <h4>Non esiste questo utente!</h4>
                                        <?php 
                                }
                            }
                            ?>


                </div>
            </div>
        </div>
    </div>
</div>


<?php 
include('includes/footer.php');
?>

