<?php include('../config/dbcon.php');
      include('authentication.php');
      include('includes/header.php'); 
?>

<div class="container-fluid px-4">
                        <h1 class="mt-4">Pannello di Gestione</h1>
                <div class="row">
                  <div class="col-md-12">
                    <?php include('includes/message.php') ?>
                    <div class="card">
                        <div class="card-header">
                              <h4>Lista Argomenti
                              <?php if ($_SESSION['auth_role'] == 1):?> 
                                <a href="argomento-add.php" class="btn btn-primary float-end">Aggiungi Argomento</a>
                                <?php endif; ?>
                              </h4>
                            <div class="card-body">


                                <div class="table-responsive">
                                    <table class="table table-bordered table-stripe">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nome</th>
                                                <th>Status</th>
                                               <?php if ($_SESSION['auth_role'] == 1):?> 
                                                <th>Modifica</th> 
                                                <th>Elimina</th>
                                                <?php endif; ?> 
                                            </tr>
                                            <tbody>
                                            <?php 
                                                    $argomento = "SELECT * FROM argomenti "; // status = 2 vuol dire argomento eliminato
                                                    $argomento_run = mysqli_query($con,$argomento); // esegui query al MySQL
                                                    
                                                    if(mysqli_num_rows($argomento_run)) // numeri di righe di risultato o argomenti  // 3
                                                    {
                                                        foreach($argomento_run as $uno) // se ci sono 3 argomenti per ogni argomento assegni variabili come $uno
                                                        {
                                            ?>

                                                            <tr>
                                                                <td><?= $uno['aid'];?></td> 
                                                                <td><?= $uno['nome'];?></td> 
                                                                <td>
                                                                    <?php
                                                                    if($uno['status'] == '1'){ echo 'Archiviato'; } elseif($uno['status'] == '0'){ echo 'Visibile'; }  elseif($uno['status'] == '2'){ echo 'Contenuto Adulto'; } 
                                                                    ?>
                                                                </td>
                                                                <?php if ($_SESSION['auth_role'] == 1):?> 
                                                                <td>
                                                                    <a href="argomento-edit.php?id=<?= $uno['aid'];?>" class="btn btn-success">Modifica</a>
                                                                </td>
                                                                <td>
                                                                    <form action="panel-codes.php" method="POST">
                                                                    <button type="submit" name="elimina_argomento" value="<?= $uno['aid'];?>" class="btn btn-danger">Elimina</button>
                                                                    </form>
                                                                </td>
                                                                <?php endif; ?> 
                                                            </tr>
                                                                                                        <?php

                                                        }
                                                    }
                                                        else  // se non ci sono arogmenti o non esistono
                                                        {
                                                        ?>

                                                            <tr>
                                                                <td>Nessun risultato trovato!</td>
                                                            </tr>

                                                        <?php
                                                        }
                                                ?>
                                            </tbody>
                                        </thead>
                                    </table>
                                </div>
                                
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