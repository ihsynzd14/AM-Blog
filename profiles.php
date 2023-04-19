<?php 
include('includes/header.php');
include('includes/navbar.php');

if(isset($_SESSION['auth'])){
$uidCorrente = $_SESSION['auth_user']['user_id'];
}

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
                    <h4>Username: </h4>
                    <h4><?= $row['username'] ?></h4>
                    </br>
                    <h4>Email: </h4>
                    <h4><?= $row['email'] ?></h4>
                    </br>
                    <h4>Nome e Cognome: </h4>
                    <h4><?= $row['nome'] ?>&nbsp;<?= $row['cognome'] ?></h4>
                    </br>
                    <h4>Data di Nascita: </h4>
                    <h4><?= $row['d_nascita'] ?></h4>
                    </br>
                    <h4>Biografia: </h4>
                    <h4><?= $row['biografia'] ?></h4>
                    
                    <?php if(isset($_SESSION['auth'])){ ?>

                    <?php if( $row['uid'] == $uidCorrente){?>
                        <a href="pdescr.php?id=<?= $row['uid']?>" class="align-center btn btn-primary">Modifica Biografia</a>
                        <?php } ?>
                                
                                <?php
                                    }
                                    elseif(!isset($_SESSION['auth']))
                                    {
                                        ?>
                                        <?php
                                    } 
                                    else 
                                      {
                                        ?>
                                        <h4>Non esiste questo utente!</h4>
                                        <?php
                                    }
                                }
                                }?>


                </div>
            </div>
        </div>
    </div>
</div>


<?php 
include('includes/footer.php');
?>

