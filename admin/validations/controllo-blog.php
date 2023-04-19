                            
<?php
// define variables and set to empty values
$nomeErr = $slugErr = $descrizioneErr  = $imgErr = $stsErr  = $argErr  = "";
$nome = $slug = $descrizione =  $b_aid = $b_uid =  $img = $status =   "";
$flag = true;





if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
  $b_aid = test_input($_POST['b_aid']);
  $b_uid = test_input($_POST['b_uid']);


  if (empty($_POST["b_aid"])) {
    $argErr = "* Argomento richiesto!";
    $flag = false;
  } else {
    $b_aid = test_input($_POST['b_aid']);
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
    // check if e-mail address is well-formed
    if (!preg_match("/^[a-zA-Z0-9]*$/",$slug)) {
        $flag = false;
      $slugErr = "Sono ammessi solo le lettere ed i numeri"; 
    }
  }
    

  if (empty($_POST["descrizione"])) {
    $descrizioneErr = "* Descrizione richiesta";
    $flag = false;
  } else {
    $descrizione = mysqli_escape_string($con,test_input($_POST["descrizione"]));
  }


  if ($_FILES["immagine"]['size'] == 0) {
    $imgErr = "* Immagine richiesta";
    $flag = false;
  } else { 
    $img =  $_FILES["immagine"]['name'];
    $immagine_extensione = pathinfo($img, PATHINFO_EXTENSION);
    //rinomina quell' immagine con unix timestamp 1652132.... con extensione .png .jpg ....
    $filenome = time().'.'.$immagine_extensione;
  }

    if (empty($_POST["status"])) {
    $status = "0";
    } else {
    $status = "1";
    }

    // Preparazione di SQL per slug doppio
    $check_slug = "SELECT * FROM blogs WHERE slug='$slug' LIMIT 1";
    // Esegui query al database
    $check_slug_run = mysqli_query($con, $check_slug);

    if(!empty($_POST['slug']) && mysqli_num_rows($check_slug_run) > 0){
        $slugErr = "* Questo slug già esiste! Prova a cambiarlo!";
        $flag = false;
    }

    // Preparazione di SQL per titolo doppio
    $check_titolo = "SELECT * FROM blogs WHERE nome='$nome' LIMIT 1";
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