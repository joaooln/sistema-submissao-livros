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
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <i class="fas fa-calendar-day fa-3x"></i>
                                <h6 class="card-title">Submissões Recebidas Hoje</h6>
                                <?php
                                $result_artigos_hoje = "SELECT COUNT(id) AS num_result FROM adms_artigos WHERE DATE_FORMAT(created,'%Y-%m-%d') = CURDATE( )";
                                $resultado_artigos_hoje = mysqli_query($conn, $result_artigos_hoje);
                                $row_pg = mysqli_fetch_assoc($resultado_artigos_hoje);
                                echo "<h2 class='lead-4'>" . $row_pg['num_result'] . "</h2>";
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <i class="fas fa-file fa-3x"></i>
                                <h6 class="card-title">Submissões Recebidas no mês</h6>
                                <?php
                                $result_artigos_mes = "SELECT COUNT(id) AS num_result FROM adms_artigos WHERE MONTH(created) = MONTH(CURDATE()) AND YEAR(created) = YEAR(CURDATE())";
                                $resultado_artigos_mes = mysqli_query($conn, $result_artigos_mes);
                                $row_artigos_mes = mysqli_fetch_assoc($resultado_artigos_mes);
                                echo "<h2 class='lead-4'>" . $row_artigos_mes['num_result'] . "</h2>";
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <i class="fas fa-users fa-3x"></i>
                                <h6 class="card-title">Autores Cadastrados</h6>
                                <?php
                                $result_autores = "SELECT COUNT(id) AS num_result FROM adms_usuarios WHERE adms_niveis_acesso_id = 4 AND adms_sits_usuario_id = 1";
                                $resultado_autores = mysqli_query($conn, $result_autores);
                                $row_autores = mysqli_fetch_assoc($resultado_autores);
                                echo "<h2 class='lead-4'>" . $row_autores['num_result'] . "</h2>";
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <i class="fas fa-newspaper fa-3x"></i>
                                <h6 class="card-title">Capitulos de Livros Publicados</h6>
                                <?php
                                $result_artigos_publi = "SELECT COUNT(id) AS num_result FROM adms_artigos WHERE adms_sit_artigo_id = 5";
                                $resultado_artigos_publi = mysqli_query($conn, $result_artigos_publi);
                                $row_artigos_publi = mysqli_fetch_assoc($resultado_artigos_publi);
                                echo "<h2 class='lead-4'>" . $row_artigos_publi['num_result'] . "</h2>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="list-group-item">
                <div class="d-flex">
                    <div class="mr-auto p-2">
                        <h2 class="display-4 titulo">Resumo dos artigos</h2>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <i class="fas fa-thumbs-up fa-3x"></i>
                                <h6 class="card-title">Submissões em Avaliação. Aguardando Aceite</h6>
                                <?php
                                $result_artigos_av = "SELECT COUNT(id) AS num_result FROM adms_artigos WHERE adms_sit_artigo_id = 1";
                                $resultado_artigos_av = mysqli_query($conn, $result_artigos_av);
                                $row_artigos_av = mysqli_fetch_assoc($resultado_artigos_av);
                                echo "<h2 class='lead-4'>" . $row_artigos_av['num_result'] . "</h2>";
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <i class="fas fa-money-bill-alt fa-3x"></i>
                                <h6 class="card-title">Submissões Aceitas. Aguardando pagamento</h6>
                                <?php
                                $result_artigos_aceito = "SELECT COUNT(id) AS num_result FROM adms_artigos WHERE adms_sit_artigo_id = 2";
                                $resultado_artigos_aceito = mysqli_query($conn, $result_artigos_aceito);
                                $row_artigos_aceito = mysqli_fetch_assoc($resultado_artigos_aceito);
                                echo "<h2 class='lead-4'>" . $row_artigos_aceito['num_result'] . "</h2>";
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <i class="fas fa-hourglass-start fa-3x"></i>
                                <h6 class="card-title">Submissões Aguardandano publicação</h6>
                                <?php
                                $result_artigos_pg = "SELECT COUNT(id) AS num_result FROM adms_artigos WHERE adms_sit_artigo_id = 3";
                                $resultado_artigos_pg = mysqli_query($conn, $result_artigos_pg);
                                $row_artigos_pg = mysqli_fetch_assoc($resultado_artigos_pg);
                                echo "<h2 class='lead-4'>" . $row_artigos_pg['num_result'] . "</h2>";
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <i class="fas fa-times-circle fa-3x"></i>
                                <h6 class="card-title">Submissões Rejeitadas</h6>
                                <?php
                                $result_artigos_reg = "SELECT COUNT(id) AS num_result FROM adms_artigos WHERE adms_sit_artigo_id = 4";
                                $resultado_artigos_reg = mysqli_query($conn, $result_artigos_reg);
                                $row_artigos_reg = mysqli_fetch_assoc($resultado_artigos_reg);
                                echo "<h2 class='lead-4'>" . $row_artigos_reg['num_result'] . "</h2>";
                                ?>
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


