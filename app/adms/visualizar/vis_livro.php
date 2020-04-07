<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    $result_livro_vis = "SELECT livro.*,
            sit.nome nome_sit,
            cors.cor cor_cors,
            areas.nome nome_area
            FROM adms_livros livro
            INNER JOIN adms_sits sit ON sit.id=livro.adms_sit_id
            INNER JOIN adms_cors cors ON cors.id=sit.adms_cor_id
            INNER JOIN adms_areas areas ON areas.id=livro.adms_area_id
            WHERE livro.id=$id LIMIT 1";
    $resultado_livro_vis = mysqli_query($conn, $result_livro_vis);
    if (($resultado_livro_vis) AND ( $resultado_livro_vis->num_rows != 0)) {
        $row_livro_vis = mysqli_fetch_assoc($resultado_livro_vis);
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
                                <h2 class="display-4 titulo">Detalhes do Livro</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/list_livro', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/list_livro' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_edit = carregar_btn('editar/edit_livro', $conn);
                                    if ($btn_edit) {
                                        echo "<a href='" . pg . "/editar/edit_livro?id=" . $row_livro_vis['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/apagar_livro', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/apagar_livro?id=" . $row_livro_vis['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($btn_list) {
                                            echo "<a class='dropdown-item' href='" . pg . "/listar/list_livro'>Listar</a>";
                                        }
                                        if ($btn_edit) {
                                            echo "<a class='dropdown-item' href='" . pg . "/editar/edit_livro?id=" . $row_livro_vis['id'] . "'>Editar</a>";
                                        }
                                        if ($btn_apagar) {
                                            echo "<a class='dropdown-item' href='" . pg . "/processa/apagar_livro?id=" . $row_livro_vis['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div><hr>
                        <dl class="row">
                            <dt class="col-sm-3">ID</dt>
                            <dd class="col-sm-9"><?php echo $row_livro_vis['id']; ?></dd>

                            <dt class="col-sm-3">Nome</dt>
                            <dd class="col-sm-9"><?php echo $row_livro_vis['nome']; ?></dd>

                            <dt class="col-sm-3">Área</dt>
                            <dd class="col-sm-9"><?php echo $row_livro_vis['nome_area']; ?></dd>

                            <dt class="col-sm-3">Data da publicação</dt>
                            <dd class="col-sm-9"><?php
                                if (!empty($row_livro_vis['data_publicacao'])) {
                                    echo date('d/m/Y', strtotime($row_livro_vis['data_publicacao']));
                                }
                                ?></dd>

                            <dt class="col-sm-3">Situação</dt>
                            <dd class="col-sm-9">
                                <?php
                                echo "<span class='badge badge-" . $row_livro_vis['cor_cors'] . "'>" . $row_livro_vis['nome_sit'] . "</span>";
                                ?>
                            </dd>

                            <dt class="col-sm-3 text-truncate">Data do Cadastro</dt>
                            <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($row_livro_vis['created'])); ?></dd>

                            <dt class="col-sm-3 text-truncate">Data de Edição</dt>
                            <dd class="col-sm-9"><?php
                                if (!empty($row_livro_vis['modified'])) {
                                    echo date('d/m/Y H:i:s', strtotime($row_livro_vis['modified']));
                                }
                                ?></dd>

                        </dl>
                    </div>
                </div>
                <?php
                include_once 'app/adms/include/rodape_lib.php';
                ?>

            </div>
        </body>
        <?php
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Livro não encontrado!</div>";
        $url_destino = pg . '/listar/list_livro';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}