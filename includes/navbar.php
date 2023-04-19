<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow sticky-top">
  <div class="container">
    <a class="navbar-brand d-block d-sm none d-md-none"></a>

    <a class="navbar-brand" href="#">Blog AM</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="search.php">Cerca</a>
        </li>


        <?php if(isset($_SESSION['auth_user'])) : //se un utente ha fatto accesso ?> 
                      <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="myblogs.php">I miei Blogs</a>
                      </li>
                      <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $_SESSION['auth_user']['user_username'];?>
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item" href="admin/index.php">Pannello di gestione</a></li>
                      <li> <a class="dropdown-item" href="profiles.php?id=<?= $_SESSION['auth_user']['user_id'];?>" >Il mio Profilo</a></li>
                        <li>
                        <form action="user-validation/logout.php" method="POST">
                          <button name="logout_btn" type="submit" class="dropdown-item">Logout</button>
                        </form>
                        </li>
                      </ul>
                    </li>
        <?php else : // altri casi ?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Accedi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Registrati</a>
        </li>
        <?php endif; //finisci condizione if else ?>
      </ul>
    </div>
  </div>
</nav>