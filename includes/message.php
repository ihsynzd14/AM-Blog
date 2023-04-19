<?php
// se c'e un messaggio o se variabile dichiarata è diversa da NULL 
if(isset($_SESSION['message']))
{ 
  ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <stron>Hey! </strong><?= $_SESSION['message']; ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    <?php
    //unsettare messaggio // non vedere più
    unset($_SESSION['message']);
}
?>