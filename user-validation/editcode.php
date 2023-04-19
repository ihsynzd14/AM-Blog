
      <?php include('../config/dbcon.php');
            include('authentication.php');

      if(isset($_POST['aggiorna_bio']))
      {
        $user_id = $_POST['user_id'];
        $biografia = $_POST['biografia'];

        if (empty($biografia)) {
          $_SESSION['message'] = "Hai lasciato il campo vuoto! Devi riempirlo!";
          header('Location: utente-edit.php?id='.$user_id);
          exit(0);
        }

        $query = "UPDATE utenti SET biografia='$biografia' WHERE uid='$user_id'";
        $query_run = mysqli_query($con,$query);

        if($query_run){
            $_SESSION['message'] = "Aggiornamento completato!";
            header('Location: ../profiles.php?id='.$user_id);
            exit(0);
        }
      }
      
      ?>