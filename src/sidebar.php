<div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <!-- profile box -->
                <div class="profileBox pt-2 pb-2">                   
                    <div class="in">
                        <strong>
                            <?php echo $nome; ?>
                        </strong>
                        <div class="text-muted">
                            <?php echo $cpf_motorista; ?>
                        </div>
                    </div>
              
                </div>
                <!-- * profile box -->
                <!-- balance -->
                <div class="sidebar-balance">
                    <div class="listview-title">Média</div>
                    <div class="in">
                        <h1 class="amount">
                            <?php echo $mediaAtual; ?>
                        </h1>
                    </div>                 
                </div>
                <!-- menu -->
                <div class="listview-title mt-1">Menu</div>
                <ul class="listview flush transparent no-line image-listview">
                    <li>
                        <a href="app-home" class="item active">
                            <div class="icon-box bg-primary">
                                <ion-icon name="pie-chart-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Dashboard
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="app-abastecimento" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="color-fill-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Abastecimentos
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="app-carteira" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="time-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Jornada
                            </div>
                        </a>
                    </li>                    
                    <li>
                        <a href="app-perfil" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="person-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Perfil
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- * menu -->

                <!-- outros -->
                <div class="listview-title mt-1">Outros</div>
                <ul class="listview flush transparent no-line image-listview">
                    <li>
                        <a href="app-lgpd" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="megaphone-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Lei Proteção de Dados - LGPD
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="logout" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="log-out-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Sair
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- * outros -->

                <!-- contatos -->
                <div class="listview-title mt-1">Contato</div>
                <ul class="listview image-listview flush transparent no-line">
                    <li>
                        <a href="mailto:suporte@rotahightech.com.br" class="item">
                            <ion-icon name="chatbox-ellipses-outline" alt="image" class="image"></ion-icon>
                            <div class="in">
                                <div>Suporte</div>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- * contatos -->
            </div>
        </div>
    </div>
</div>