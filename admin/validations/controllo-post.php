                            
<?php
// define variables and set to empty values
$nomeErr = $slugErr = $descrizioneErr  = $imgErr = $stsErr  = $blogErr  = NULL;
$nome = $slug = $descrizione =  $navbar =  $img = $status = $a_uid = $p_bid =  NULL;
$flag = true;





if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
  //controllo se tolgo p_bid (problema )
  $p_bid = test_input($_POST['p_bid']);
  $p_uid = test_input($_POST['p_uid']);


  if (empty($_POST["p_bid"])) {
    $blogErr = "* Blog richiesto!";
    $flag = false;
  } else {
    $p_bid = test_input($_POST["p_bid"]);
  }

  if (empty($_POST["nome"])) {
    $nomeErr = "* Titolo richiesto!";
    $flag = false;
  } else {
    $nome = mysqli_escape_string($con,test_input($_POST["nome"]));
    
  }
  
  if (empty($_POST["slug"])) {
    $flag = false;
    $slugErr = "* Slug richiesto per URL!";
  } else {
    $slug = mysqli_escape_string($con,test_input($_POST["slug"]));
    if (!preg_match("/^[a-zA-Z0-9]*$/",$slug)) {
        $flag = false;
      $slugErr = "Sono ammesse solo le lettere e i numeri"; 
    }
  }
    

  if (empty($_POST["descrizione"])) {
    $descrizioneErr = "* Descrizione richiesta";
    $flag = false;
  } else {
    $descrizione = mysqli_escape_string($con,htmlentities($_POST["descrizione"]));
  }


  if ($_FILES["immagine"]['size'] == 0) {
    $imgErr = "* Immagine richiesta";
    $flag = false;
  } else {
    $img =  $_FILES["immagine"]['name']; //flowers
                              //flowers, png  ----> png
    $immagine_extensione = pathinfo($img, PATHINFO_EXTENSION); // aggiunge extension (jpg,png,tiff,webp)
                //166444812.png
    $filenome = time().'.'.$immagine_extensione;
  }

    if (empty($_POST["status"])) {
    $status = "0";
    } else {
    $status = "1";
    }

    // Preparazione di SQL per utente già registrato con stessa email
    $check_slug = "SELECT * FROM posts WHERE slug='$slug' LIMIT 1";
    // Esegui query al database
    $check_slug_run = mysqli_query($con, $check_slug);

    if(!empty($_POST['slug']) && mysqli_num_rows($check_slug_run) > 0){
        $slugErr = "* Questo slug già esiste! Prova a cambiarlo!";
        $flag = false;
    }

    // Preparazione di SQL per utente già registrato con stessa email
    $check_titolo = "SELECT * FROM posts WHERE nome='$nome' LIMIT 1";
    // Esegui query al database
    $check_titolo_run = mysqli_query($con, $check_titolo);

    if(!empty($_POST['nome']) && mysqli_num_rows($check_titolo_run) > 0){
        $nomeErr = "* Questo titolo già esiste! Prova a cambiarlo!";
        $flag = false;
    }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>