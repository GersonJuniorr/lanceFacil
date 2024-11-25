<?php
// Obter a URL atual
$current_page = basename($_SERVER['REQUEST_URI'], ".php");

?>
<div class="appBottomMenu">
    <a href="app-home.php" class="item <?= (strpos($current_page, 'app-home') !== false) ? 'active' : '' ?>">
        <div class="col">
            <ion-icon name="pie-chart-outline"></ion-icon>
            <strong>Dashboard</strong>
        </div>
    </a>
    <a href="app-abastecimento" class="item <?= (strpos($current_page, 'app-abastecimento') !== false) ? 'active' : '' ?>">
        <div class="col">
            <ion-icon name="color-fill-outline"></ion-icon>
            <strong>Abastecimentos</strong>
        </div>
    </a>
    <a href="app-perfil" class="item <?= (strpos($current_page, 'app-perfil') !== false) ? 'active' : '' ?>">
        <div class="col">
            <ion-icon name="person-outline"></ion-icon>
            <strong>Perfil</strong>
        </div>
    </a>
</div>