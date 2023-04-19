<?php if (!empty($_SESSION['auth_user']['user_id'])): ?>
<?php

//connette il database, se ci sono errori fai exit
$conn = mysqli_connect("localhost","root","","blog_am") or die('Database connection error: ' . $conn->connect_error);

$uidCorrente= $_SESSION['auth_user']['user_id'];
$uNameCorrente = $_SESSION['auth_user']['user_username'];

$utenti = mysqli_query($conn,"SELECT * FROM utenti WHERE uid = '$uidCorrente'")or die($conn -> mysqli_error);
// trasforma le date all' array assocativo perchè se c'era la data non potevano prendere informazioni come le stringhe
$utenti_row = mysqli_fetch_array($utenti);

?>
<?php endif ?>
<br>       		
					<form method="post">
					<hr>
					<h2>Commenti:</h2><br>
                    <?php $id= $posto['pid']; if (!empty($uidCorrente)): ?>
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<textarea name="comment_content" rows="3" cols="40" placeholder=".... Scrivi il tuo commento ...." required></textarea><br>
					<input type="submit" name="comment">
					</form>
					</br>
                    <?php endif ?>
							
							<?php 
								$comment_query = mysqli_query($con,"SELECT * ,UNIX_TIMESTAMP() - date_posted AS TimeSpent FROM comment LEFT JOIN utenti ON utenti.uid = comment.user_id WHERE post_id = '$id'") or die ($conn -> mysqli_error);
								while ($c_row = mysqli_fetch_array($comment_query)){
								$comment_id = $c_row['commento_id'];
								$comment_by = $c_row['username'];
								$comment_userid = $c_row['user_id'];
							?>

					<br><?php echo $c_row['contenuto']; ?> </br> da:  <a class="text-dark" href="profiles.php?id=<?= $comment_userid ?>"><?php echo $comment_by; ?></a>
					  &ThinSpace; 
							<?php
								$days = floor($c_row['TimeSpent'] / (60 * 60 * 24));
								$remainder = $c_row['TimeSpent'] % (60 * 60 * 24);

								$hours = floor($remainder / (60 * 60));
								$remainder = $remainder % (60 * 60);

								$minutes = floor($remainder / 60);
								$seconds = $remainder % 60;

								if($days > 0)
								echo date('F d, Y - H:i:sa', $c_row['date_posted']);

								elseif($days == 0 && $hours == 0 && $minutes == 0)
								echo "Pochi secondi fa";		

								elseif($days == 0 && $hours == 0)
								echo $minutes.' minuti fa';
								
								elseif($days == 0)
								echo $hours.' ore fa';
							?>
					
                  
  <?php if(!empty($uidCorrente)): ?>      
<form method="POST">
<input type="hidden" name="cid" value="<?php echo $c_row['commento_id']; ?>">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="hidden"  name="date" value="<?php echo $c_row['date_posted']; ?>">
<input type="hidden"  name="message" value="<?php echo $c_row['contenuto']; ?>">

<?php if(!empty($uidCorrente) && $uNameCorrente == $comment_by): ?>    
<button name="delete">Delete Comment</button>

<?php elseif($_SESSION['auth_role'] == 1): ?>    
<button name="delete">Delete Comment</button>

<?php endif ?>
</form>


                          <?php if (isset($_POST['delete'])){
                                $comment_content = $_POST['comment_content'];
                                $cid = $_POST['cid'];
                                $post_id= $id;
                                
                                mysqli_query($conn,"DELETE FROM comment WHERE $cid = commento_id") or die ($conn -> mysqli_error);
								
                                }
                      
                        ?>
						      
                     <?php endif ?>

							<?php
							}
							?>
					
                    <hr>
					&nbsp;

    

					<?php
							// se cliccato submit (bottone) per commentare 
								if (isset($_POST['comment'])){
								$comment_content = mysqli_escape_string($con,$_POST['comment_content']);
								$post_id=$_POST['id'];
								
								$check_limit = "SELECT * FROM comment WHERE user_id = $uidCorrente ";
								$check_limit_run = mysqli_query($con,$check_limit);
							  
								if(mysqli_num_rows($check_limit_run) >= 2 && $_SESSION['auth_role'] == 0){
								  $_SESSION['message'] = "Hai superato il numero massimo di commenti per gli utenti normali!";
								  ?>
								  <?php
								  exit(0);
							
							  }
								mysqli_query($conn,"INSERT INTO comment(contenuto,date_posted,user_id,post_id) VALUES ('$comment_content','".strtotime(date("Y-m-d h:i:sa"))."','$uidCorrente','$post_id')");
								header('location: posts.php?titolo='.$posto['slug']);
								}
							?>