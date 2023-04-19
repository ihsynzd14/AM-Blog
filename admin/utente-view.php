<?php session_start(); include('../config/dbcon.php');?>

<?php

if($_SESSION['auth_role'] == 0 || $_SESSION['auth_role'] == 2) // ospiti non hanno $_SESSIONE['auth'];
{
    $_SESSION['message'] = "Devi essere un Admin per accedere qui!";
    header("Location: index.php");
    exit(0);
}  
$uidCorrente = $_SESSION['auth_user']['user_id'];
?>

<?php include('includes/header.php'); ?>


<div class="container-fluid px-4">
                        <h1 class="mt-4">Pannello di Gestione</h1>
                <div class="row">
                  <div class="col-md-12">
                    <?php include('includes/message.php') ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>Utenti Registrati
                                <a href="utente-add.php" class="btn btn-primary float-end">Aggiungi Utente</a>
                            </h4>
                                <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Utente ID</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Nome</th>
                                            <th>Cognome</th>
                                            <th>Data di nascita</th>
                                            <th>Biografia</th>
                                            <th>Ruolo</th>
                                            <th>Modifica</th>
                                            <th>Elimina</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT * FROM utenti";
                                        $query_run = mysqli_query($con,$query);

                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $row)
                                            {
                                                 ?>
                                                        <tr>
                                                            <td><?= $row['uid'] ?></td>
                                                            <td><?= $row['username'] ?></td>
                                                            <td><?= $row['email'] ?></td>
                                                            <td><?= $row['nome'] ?></td>
                                                            <td><?= $row['cognome'] ?></td>
                                                            <td><?= $row['d_nascita'] ?></td>
                                                            <td><?= $row['biografia'] ?></td>
                                                            <td>
                                                                <?php
                                                                if($row['ruolo'] == 1){
                                                                    echo 'Admin';        
                                                                }elseif($row['ruolo'] == 0){
                                                                    echo 'Utente';
                                                                }
                                                                elseif($row['ruolo'] == 2){
                                                                    echo 'Utente Premium';
                                                                }
                                                                   
                                                                ?>
                                                            </td>
                                                            <td><a href="utente-edit.php?id=<?=$row['uid'];?>" class="btn btn-success">Modifica</a></td>
                                                            <td>
                                                                <form action="panel-codes.php" method="POST">
                                                                    <button type="submit" name="elimina-utente" value="<?=$row['uid']?>" class="btn btn-danger">Elimina</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                 <?php
                                            }    
                                        }
                                        else
                                        {
                                            ?>
                                            <tr>
                                                <td colspan="9">Nessun risultato trovato!</td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
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