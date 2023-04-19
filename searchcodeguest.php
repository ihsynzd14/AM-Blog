<?php
 include('config/dbcon.php');  // connettere database

 // se viene scritto qualcosa nel posto di input (barra di ricerca)
if(isset($_POST['input'])){
   $input = $_POST['input'];
   
   $query = "SELECT a.*,b.*,p.*, u.username, u.uid FROM argomenti a, blogs b, posts p, utenti u WHERE a.status ='0' AND b.status ='0' AND a.aid = b.b_aid AND p.p_bid = b.bid AND p.p_uid = u.uid AND p.status = '0' AND (p.nome LIKE '%{$input}%' OR p.descrizione LIKE '%{$input}%') ORDER BY p.nome ASC";
  

   $result = mysqli_query($con,$query);

   if(mysqli_num_rows($result) > 0){ ?>

      <table class="table table-bordered table-striped mt-4">
         <thead>
            <tr>
            <th>Immagine</th>
            <th>Titolo del Post</th>
            <th>Data di Creazione</th>
            <th>Link</th>
            </tr>
         </thead>
         <tbody>
            <?php
            //trasforma la data all' array associativo
            while($row = mysqli_fetch_assoc($result)){
               $img = $row['immagine'];
               $nome = $row['nome'];
               $created_at = $row['data_postato'];
               ?>
            <tr>
               <td><img src="caricati/posts/<?= $row['immagine'];?>" width="60px" height="60px" /></td>
               <td><?php echo $nome;?></td>
               <td><?php echo $created_at;?></td>
               <td><a href="posts.php?titolo=<?= $row['slug']; ?>" class="btn btn-primary">Leggi Tutto</a></td>
            </tr>
            <?php
            }
            ?>
         </tbody>
      </table>
      <?php
   }else{
      echo"<h6 class='text-danger text-center mt-3 fw-bold'> Post Non Trovato! </h6>";
   }
}
?>