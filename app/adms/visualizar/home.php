<?php
if (!isset($seg)) {
    exit;
}
//Inclui o arquivo do head
include_once 'app/adms/include/head.php';
?>
<body>
    <?php
    include_once 'app/adms/include/header.php';
    ?>
    <div class="d-flex">
        <?php
        include_once 'app/adms/include/menu.php';
        ?>

        <div class="content p-1">
            <div class="list-group-item">
                <div class="d-flex">
                    <div class="mr-auto p-2">
                        <h2 class="display-4 titulo">Página Inicial</h2>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <?php
                                echo "<a href='" . pg . "/cadastrar/cad_artigo' style='color:white'>";
                                ?>
                                <i class="fas fa-plus-circle fa-3x"></i><br/>
                                <h6 class="card-title">Cadastrar Artigo</h6>
                                </a>
                            </div>
                        </div>
                    </div>                    
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <?php
                                echo "<a href='" . pg . "/listar/list_artigo' style='color:white'>";
                                ?>
                                <i class="fas fa-file-alt fa-3x"></i>
                                <h6 class="card-title">Minhas submissões</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <?php
                                echo "<a href='" . pg . "/visualizar/vis_perfil' style='color:white'>";
                                ?>
                                <i class="fas fa-user fa-3x"></i>
                                <h6 class="card-title">Meus dados</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <?php
                                echo "<a href='" . pg . "/acesso/sair' style='color:white'>";
                                ?>
                                <i class="fas fa-sign-out-alt fa-3x"></i>
                                <h6 class="card-title">Sair</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php
        include_once 'app/adms/include/rodape_lib.php';
        ?>
    </div>
</body>


