<div id="layoutSidenav_nav">
    
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="utente-view.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Lista degli Utenti
                            </a>
                            <div class="sb-sidenav-menu-heading">Interfaccia</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Argomenti
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="argomento-add.php">Aggiungi Argomento</a>
                                    <a class="nav-link" href="argomento-view.php">Lista Argomenti</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBlogs" aria-expanded="false" aria-controls="collapseBlogs">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Blogs
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseBlogs" aria-labelledby="Blogs" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="blog-add.php">Aggiungi Blog</a>
                                    <a class="nav-link" href="coautori-view.php">Lista Blogs & Co-Autori</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePosts" aria-expanded="false" aria-controls="collapsePosts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Posts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePosts" aria-labelledby="Posts" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="post-add.php">Aggiungi Post</a>
                                    <a class="nav-link" href="post-view.php">Lista Post & Co-Autori</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Accesso come:</div>
                        <?= $_SESSION['auth_user']['user_username'];?>    
                    </div>
                </nav>
            </div>