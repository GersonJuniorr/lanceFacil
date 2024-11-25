<!-- Sidebar (fora do #main-content) -->
<div class="sidebar-wrap sidebar-overlay">
    <div class="closemenu text-opac" onclick="closeSidebar()">Close Menu</div>
    <div class="sidebar">
        <div class="row mt-4 mb-3">
            <div class="col-auto">
                <div class="sidebar-perfil">
                    <img src="imagem.php?id=<?php echo $cpf_user; ?>" alt="" id="profile-img">
                </div>
            </div>
            <div class="col align-self-center ps-0">
                <h6 class="mb-0"><?php echo $nome; ?></h6>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">
                            <ion-icon name="home-sharp" class="icon"></ion-icon>
                            <div class="col">Home</div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="curtidos.php" tabindex="-1">
                            <ion-icon name="heart" class="icon"></ion-icon>
                            <div class="col">Posts curtidos</div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" tabindex="-1" onclick="Evento()">
                            <ion-icon name="log-out-outline" class="icon"></ion-icon>
                            <div class="col">Logout</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

