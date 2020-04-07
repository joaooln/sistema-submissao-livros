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
                        <h2 class="display-4 titulo">Escolha o tipo de submissão</h2>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-info text-white text-center">
                            <div class="card-body">
                                <?php
                                echo "<a href='" . pg . "/cadastrar/cad_artigo' style='color:white'>";
                                ?>
                                <i class="fas fa-file-alt fa-3x"></i><br/>
                                <h6 class="card-title">Capítulo de Livro</h6>
                                </a>
                            </div>
                        </div>
                    </div>                    
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-success text-white text-center">
                            <div class="card-body">
                                <?php
                                echo "<a href='" . pg . "/cadastrar/cad_livro_completo' style='color:white'>";
                                ?>
                                <i class="fas fa-book fa-3x"></i>
                                <h6 class="card-title">Livro Completo</h6>
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


