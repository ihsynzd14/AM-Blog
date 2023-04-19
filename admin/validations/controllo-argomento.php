                            
<?php
// define variables and set to empty values
$nomeErr = $slugErr = $descrizioneErr  =  $stsErr  = "";
$nome = $slug = $descrizione =  $status = $a_uid =  "";
$flag = true;





if ($_SERVER["REQUEST_METHOD"] == "POST") { // se qualcosa richiesta dal methodo di POST
 
  if (empty($_POST["nome"])) {
    $nomeErr = "* Titolo richiesto!";
    $flag = false;
  } else {
    $nome = mysqli_escape_string($con,test_input($_POST["nome"]));
    
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z0-9$#'!(*.+?\-%)|&`;]*$/",$nome)) {
      $flag = false;
      $nomeErr = "Per il nome sono ammessi solo lettere e spazi"; 
    }
  }
  
  if (empty($_POST["slug"])) {
    $flag = false;
    $slugErr = "* Slug richiesto per URL!";
  } else {
    $slug =  mysqli_escape_string($con,test_input($_POST["slug"]));
    // check if e-mail address is well-formed
    if (!preg_match("/^[a-zA-Z0-9$#'!(*.+?\-%)|]*$/",$slug)){
        $flag = false;
      $slugErr = "Sono ammessi solo le lettere e i numeri"; 
    }
  
    

  if (empty($_POST["descrizione"])) {
    $descrizioneErr = "* Descrizione richiesta";
    $flag = false;
  } else {
    $descrizione =  mysqli_escape_string($con,test_input($_POST["descrizione"]));
  }

  if ($_POST["status"]== 3) {
    $stsErr = "* Status richiesto";
    $flag = false;
  } else {
    $status = $_POST["status"];
    $a_uid = test_input($_POST["a_uid"]); 
  }

  
    $check_slug = "SELECT * FROM argomenti WHERE slug='$slug' LIMIT 1";
    // Esegui query al database
    $check_slug_run = mysqli_query($con, $check_slug);

    if(!empty($_POST['slug']) && mysqli_num_rows($check_slug_run) > 0){
        $slugErr = "* Questo slug già esiste! Prova a cambiarlo!";
        $flag = false;
    }

    $check_titolo = "SELECT * FROM argomenti WHERE nome='$nome' LIMIT 1";
    // Esegui query al database
    $check_titolo_run = mysqli_query($con, $check_titolo);

    if(!empty($_POST['nome']) && mysqli_num_rows($check_titolo_run) > 0){
        $nomeErr = "* Questo titolo già esiste! Prova a cambiarlo!";
        $flag = false;
    }

}
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
                                    

?>