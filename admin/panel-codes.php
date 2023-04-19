<?php include('../config/dbcon.php');
      include('authentication.php');

      $uidCorrente = $_SESSION['auth_user']['user_id'];


      if(isset($_POST['elimina_coautori']))
      {
        $bid = $_POST['elimina_coautori'];

        $query = "DELETE FROM coautori WHERE blog_id = '$bid' ";
        //Esegui query
        $query_run = mysqli_query($con,$query);
        
        if($query_run)
        {
          $_SESSION['message'] = "Tutti i Co-Autori sono eliminati!";
          header('Location: coautori-view.php');
          exit(0);
        }
        else
        {
          $_SESSION['message'] = "Qualcosa è andato storto!";
          header('Location: coautori-view.php');
          exit(0);
        }

      }


      
      if(isset($_POST['aggiungi_coautore']))
      {

        $bid = mysqli_escape_string($con,$_POST['bid']);
        $autore_id = mysqli_escape_string($con,$_POST['autore_id']);
        $coautore_id = mysqli_escape_string($con,$_POST['coautore_id']);

        $checkcoautore = "SELECT * FROM coautori WHERE coautore_id = '$coautore_id' AND blog_id = '$bid'";
        $checkcoautore_run = mysqli_query($con,$checkcoautore); // connette database poi esegue la SQL query al database

        if(mysqli_num_rows($checkcoautore_run) > 0){ // numeri di righe nel risulto di $checkmail_run, se sono piu di 0
          // se coautore esiste
          $_SESSION['message'] = "E' già Co-Autore!";
          header('Location: coautori-view.php');
          exit(0);
        }

        else // se numeri di righe nel risulto di $checkmail_run sono = 0 o (non possibile ma a caso sono meno di zero)
        {
        $query = "INSERT INTO coautori (blog_id,autore_id,coautore_id) VALUES ('$bid','$autore_id','$coautore_id')";
        $query_run = mysqli_query($con,$query);      
        
        if($query_run)
        {
          $_SESSION['message'] = "Coautore Aggiunto!";
          header('Location: coautori-view.php');
          exit(0);
        }
        else
        {
          $_SESSION['message'] = "Qualcosa è andato storto!";
          header('Location: coautori-view.php');
          exit(0);
        }
      }
      }



      if(isset($_POST['elimina_blog']))
      {
        $bid = $_POST['elimina_blog']; 

        $controlla_immagine = "SELECT * FROM blogs WHERE bid = '$bid' LIMIT 1";
        //Esegui query
        $controlla_immagine_run = mysqli_query($con,$controlla_immagine);
        //trasforma la data in array
        $row = mysqli_fetch_array($controlla_immagine_run);
        $immagine = $row['immagine'];

        $query = "DELETE FROM blogs WHERE bid = '$bid' LIMIT 1";
        $query_run = mysqli_query($con,$query);
        
        if($query_run)
        {    // se esiste immagine di blog 
            if(file_exists('../caricati/blogs/'.$immagine)){ 
              //lo elimina
                unlink('../caricati/blogs/'.$immagine);
            }
          
          $_SESSION['message'] = "Blog Eliminato!";
          header('Location: coautori-view.php');
          exit(0);
        }
        else
        {
          $_SESSION['message'] = "Qualcosa è andato storto!";
          header('Location: coautori-view.php');
          exit(0);
        }
      }



      if(isset($_POST['aggiorna_blog']))
      {
        $bid = $_POST['bid'];

        $b_aid = $_POST['b_aid'];

        $nome = mysqli_escape_string($con,$_POST['nome']);
        $slug = mysqli_escape_string($con,$_POST['slug']);
        $descrizione = mysqli_escape_string($con,$_POST['descrizione']);

        $status = $_POST['status'] == true ? '1' : '0';

        $vecchio_filenome = $_POST['vecchio_immagine'];
        //nuova immagine
        $immagine = $_FILES['immagine']['name'];

        $aggiornato_filenome = "";

        if($immagine != NULL)
        {
        //se ha messo nuova immagine     LK1, .png
        $immagine_extensione = pathinfo($immagine, PATHINFO_EXTENSION);
        // cambio nome di immagine con 166671237.png
        $filenome = time().'.'.$immagine_extensione;
        // assegna nuova immagine
        $aggiornato_filenome = $filenome;        
        }
        else
        {//se non ho messo nuova immagine
          $aggiornato_filenome = $vecchio_filenome;
        }
        
        if (empty($b_aid) || empty($nome) || empty($slug) || empty($descrizione)){
          $_SESSION['message'] = "Hai lasciato dei campi vuoti! Devi riempirli tutti!";
          header('Location: coautori-view.php');
          exit(0);
        }

        if (!preg_match("/^[a-zA-Z0-9$#'!(*.+?\-%)| ]*$/",$nome)) {
          $_SESSION['message'] = "Per il titolo sono ammesse solo le lettere,i numeri, gli spazi ed i caratteri speciali come[$#^'!?()*.+-%|] "; 
          header('Location: coautori-view.php');
          exit(0);
        }
        
        if (!preg_match("/^[a-zA-Z0-9]*$/",$slug)) {
          $_SESSION['message'] = "Solo  lettere e numeri ammesse per il slug"; 
          header('Location: coautori-view.php');
          exit(0);
          }

        // Preparazione di SQL per utente già registrato con la stessa email
        $check_slug = "SELECT * FROM blogs WHERE slug='$slug' LIMIT 1";
        // Esegui query al database
        $check_slug_run = mysqli_query($con, $check_slug);

        if(!empty($_POST['slug']) && mysqli_num_rows($check_slug_run) > 1){
            $_SESSION['message'] = "* Questo slug già esiste! Prova a cambiarlo!";
            header('Location: blog-edit.php?id='.$bid);
            exit(0);
        }

        // Preparazione di SQL per utente già registrato con la stessa email
        $check_titolo = "SELECT * FROM blogs WHERE nome='$nome' LIMIT 1";
        // Esegui query al database
        $check_titolo_run = mysqli_query($con, $check_titolo);

        if(!empty($_POST['nome']) && mysqli_num_rows($check_titolo_run) > 1){
            $_SESSION['message'] = "* Questo titolo già esiste! Prova a cambiarlo!";
            header('Location: blog-edit.php?id='.$bid);
            exit(0);
        }
        

        $query = "UPDATE blogs SET b_aid='$b_aid', nome='$nome',slug='$slug',descrizione='$descrizione',immagine='$aggiornato_filenome',status='$status' WHERE bid = '$bid' ";
        $query_run = mysqli_query($con,$query);
    
         
        if($query_run)
        {
          if($immagine != NULL) // se ho messo una nuova immagine
          {
            if(file_exists('../caricati/blogs/'.$vecchio_filenome)){ // elimina il vecchio file
                unlink('../caricati/blogs/'.$vecchio_filenome);
            }
            // manda la nuova immagine alla sua direzione
          move_uploaded_file($_FILES['immagine']['tmp_name'],'../caricati/blogs/'.$filenome);
          }
          $_SESSION['message'] = "Blog Aggiornato!";
          header('Location: coautori-view.php');
          exit(0);
        }
        else
        {
          $_SESSION['message'] = "Qualcosa non andato bene!";
          header('Location: coautori-view.php');
          exit(0);
        }

      }


      if(isset($_POST['elimina_post']))
      {
        $pid = $_POST['elimina_post']; 

        $controlla_immagine = "SELECT * FROM posts WHERE pid = '$pid' LIMIT 1";

        $immagine_result = mysqli_query($con,$controlla_immagine);

        $f_result = mysqli_fetch_array($immagine_result);
        
        // l'immagine del post che voglio eliminare
        $immagine = $f_result['immagine'];

        $query = "DELETE FROM posts WHERE pid = '$pid' LIMIT 1";
        $query_run = mysqli_query($con,$query);
        
        if($query_run)
        {
          // se esiste file con questo nome
            if(file_exists('../caricati/posts/'.$immagine)){
              // elimina questa immagine
                unlink('../caricati/posts/'.$immagine);
            }
            
          $_SESSION['message'] = "Post Eliminato!";
          header('Location: post-view.php');
          exit(0);
        }
        else
        {
          $_SESSION['message'] = "Qualcosa è andato storto!";
          header('Location: post-view.php');
          exit(0);
        }
      }


      if(isset($_POST['aggiorna_post']))
      {
        $pid = mysqli_escape_string($con,$_POST['pid']);

        $p_bid = mysqli_escape_string($con,$_POST['p_bid']);
        $nome = mysqli_escape_string($con,$_POST['nome']);
        $slug = mysqli_escape_string($con,$_POST['slug']);
        $descrizione = mysqli_escape_string($con,$_POST['descrizione']);
        $status = $_POST['status'] == true ? '1' : '0';

        $vecchio_filenome = $_POST['vecchio_immagine'];
        $immagine = $_FILES['immagine']['name'];

        $aggiornato_filenome = "";

        // se utente ha caricato immagine
        if($immagine != NULL)
        {
        //rinomina quell'immagine
        $immagine_extensione = pathinfo($immagine, PATHINFO_EXTENSION);
        $filenome = time().'.'.$immagine_extensione;
        $aggiornato_filenome = $filenome;        
        }
        else
        {
          // se utente non ha caricato l'immagine
          $aggiornato_filenome = $vecchio_filenome;
        }

        if (empty($p_bid) || empty($nome) || empty($slug) || empty($descrizione)){
          $_SESSION['message'] = "Hai lasciato dei campi vuoti! Devi riempirli tutti!";
          header('Location: post-view.php');
          exit(0);
        }
        if (!preg_match("/^[a-zA-Z0-9$#'!(*.+?\-%)| ]*$/",$nome)) {
          $_SESSION['message'] = "Per il titolo sono ammesse solo le lettere,i numeri e gli spazi"; 
          header('Location: post-view.php');
          exit(0);
        }
        
        if (!preg_match("/^[a-zA-Z0-9]*$/",$slug)) {
          $_SESSION['message'] = "Sono ammesse solo le lettere e i numeri"; 
          header('Location: post-view.php');
          exit(0);
          }
        
          
        // Preparazione di SQL per utente già registrato con stessa email
        $check_slug = "SELECT * FROM posts WHERE slug='$slug' LIMIT 1";
        // Esegui query al database
        $check_slug_run = mysqli_query($con, $check_slug);

        if(!empty($_POST['slug']) && mysqli_num_rows($check_slug_run) > 1){
            $_SESSION['message'] = "* Questo slug già esiste! Prova a cambiarlo!";
            header('Location: post-edit.php?id='.$pid);
            exit(0);
        }

        // Preparazione di SQL per utente già registrato con stessa email
        $check_titolo = "SELECT * FROM posts WHERE nome='$nome' LIMIT 1";
        // Esegui query al database
        $check_titolo_run = mysqli_query($con, $check_titolo);

        if(!empty($_POST['nome']) && mysqli_num_rows($check_titolo_run) > 1){
            $_SESSION['message'] = "* Questo titolo già esiste! Prova a cambiarlo!";
            header('Location: post-edit.php?id='.$pid);
            exit(0);
        }
        

        $query = "UPDATE posts SET p_bid='$p_bid',nome='$nome',slug='$slug',descrizione='$descrizione',immagine='$aggiornato_filenome',status='$status' WHERE pid = '$pid' ";

        $query_run = mysqli_query($con,$query);

         
        if($query_run)
        {
        // se utente ha caricato l'immagine
            if($immagine != NULL)
          {
            // se esiste file con nome questa
            if(file_exists('../caricati/posts/'.$vecchio_filenome)){
              // elimina file
                unlink('../caricati/posts/'.$vecchio_filenome);
            }
          // sposta file
          move_uploaded_file($_FILES['immagine']['tmp_name'],'../caricati/posts/'.$filenome);
          }
          $_SESSION['message'] = "Post Aggiornato!";
          header('Location: post-view.php');
          exit(0);
        }


        else
        {
          $_SESSION['message'] = "Qualcosa è andato storto!";
          header('Location: post-view.php');
          exit(0);
        }

      }

      if(isset($_POST['elimina_argomento']))
      {
          $aid = $_POST['elimina_argomento']; // value di bottone 
          
          $query = "DELETE FROM argomenti WHERE aid ='$aid' ";
          $query_run = mysqli_query($con,$query);


          if($query_run)
          {
            $_SESSION['message'] = "Argomento Eliminato!";
            header('Location: argomento-view.php');
            exit(0);
          }
          else
          {
            $_SESSION['message'] = "Qualcosa è andato storto!";
            header('Location: argomento-view.php');
            exit(0);
          }
  
      }
   
      if(isset($_POST['aggiorna_argomento']))
      { 
        $aid = mysqli_escape_string($con,$_POST['aid']);
        $nome = mysqli_escape_string($con,$_POST['nome']);
        $descrizione = mysqli_escape_string($con,$_POST['descrizione']);

        $status = $_POST['status'];

        if (empty($nome) || empty($descrizione)){
          
          $_SESSION['message'] = "Hai lasciato dei campi vuoti! Devi riempirli tutti!";
          header('Location: argomento-view.php');
          exit(0);
        }

        if (!preg_match("/^[a-zA-Z0-9$#'!(*.+?\-%)|&`;]*$/",$nome)) {
          $_SESSION['message'] = "Per il titolo sono ammesse solo le lettere e gli spazi"; 
          header('Location: argomento-view.php');
          exit(0);
        }
                
        
        // Preparazione di SQL per utente già registrato con stessa email
        $check_titolo = "SELECT * FROM argomenti WHERE nome='$nome'";
        // Esegui query al database
        $check_titolo_run = mysqli_query($con, $check_titolo);

        if(!empty($_POST['nome']) && mysqli_num_rows($check_titolo_run) > 1){
            $_SESSION['message'] = "* Questo titolo già esiste! Prova a cambiarlo!";
            header('Location: argomento-edit.php?id='.$aid);
            exit(0);
        }
        
        $query = "UPDATE argomenti SET nome='$nome',descrizione='$descrizione',status='$status' WHERE aid='$aid'";
        $query_run = mysqli_query($con,$query);


        if($query_run )
        {
          $_SESSION['message'] = "Argomento Aggiornato!";
          header('Location: argomento-view.php');
          exit(0);
        }
        else
        {
          $_SESSION['message'] = "Qualcosa è andato storto!";
          header('Location: argomento-view.php');
          exit(0);
        }

      }


      if(isset($_POST['elimina-utente']))
      {
        $user_id = $_POST['elimina-utente'];

        $query = "DELETE FROM utenti WHERE uid='$user_id'";
        $query_run = mysqli_query($con, $query);

        $query2 = "DELETE FROM blogs WHERE b_uid='$user_id'";
        $query2_run = mysqli_query($con, $query2);
        
        if($query_run){
          if($user_id == $uidCorrente){
            unset($_SESSION['auth']);
            unset($_SESSION['auth_role']);
            unset($_SESSION['auth_user']);
            
            $_SESSION['message'] = "Hai fatto logout!";
            header("Location: ../login.php");
            exit(0);
          }
          
          else{
            $_SESSION['message'] = "Admin/Utente è stato eliminato";
            header('Location: utente-view.php');
            exit(0);
          }
          
        }
        else
        {
          $_SESSION['message'] = "Qualcosa è andato storto!";
          header('Location: utente-view.php');
          exit(0);
        }

      }


      if(isset($_POST['aggiorna_utente']))
      {
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $d_nascita = $_POST['d_nascita'];
        $biografia = $_POST['biografia'];
        $ruolo = $_POST['ruolo'];
        $cfiscale = $_POST['cfiscale'];
        $status = $_POST['status'] == true ? '1' :'0';

        if (empty($username) || empty($cfiscale) || empty($email) || empty($nome) || empty($cognome) ||  empty($d_nascita) ||  empty($biografia)) {
          $_SESSION['message'] = "Hai lasciato dei campi vuoti! Devi riempirli tutti!";
          header('Location: utente-edit.php?id='.$user_id);
          exit(0);
        }

        if (!empty($email) && !preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
          $_SESSION['message'] = "Email non valida";
          header('Location: utente-edit.php?id='.$user_id);
          exit(0);
      } 
        if (!preg_match("/^[a-zA-Z]*$/",$nome)) {
          $_SESSION['message'] = "Sono ammesse solo lettere per Nome!";
          header('Location: utente-edit.php?id='.$user_id);
          exit(0);
        }
        if (!preg_match("/^[a-zA-Z]*$/",$cognome)) {
          $_SESSION['message'] = "Sono ammesse solo lettere per Cognome!";
          header('Location: utente-edit.php?id='.$user_id);
          exit(0);
        }

        if (!preg_match("/^[A-Za-z]{6}[0-9]{2}[A-Za-z]{1}[0-9]{2}[A-Za-z]{1}[0-9]{3}[A-Za-z]{1}$/",$cfiscale)) {
          $_SESSION['message'] = "Codice Fiscale non valido";
          header('Location: utente-edit.php?id='.$user_id);
          exit(0);
        }
  


        $query = "UPDATE utenti SET username='$username',email='$email',nome='$nome',cognome='$cognome',cfiscale='$cfiscale',d_nascita='$d_nascita',biografia='$biografia',ruolo='$ruolo',status='$status'
                     WHERE uid='$user_id'";
        $query_run = mysqli_query($con,$query);

        if($query_run){
            $_SESSION['message'] = "Aggiornamento completato!";
            header('Location: utente-view.php');
            exit(0);
        }
      }
      

?>