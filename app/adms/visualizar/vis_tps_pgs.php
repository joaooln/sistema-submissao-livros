<?php
if (!isset($seg)) {
    exit;
}
include_once 'app/adms/include/head.php';
?>
<body>    
    <?php
    include_once 'app/adms/include/header.php';
    ?>
    <div class="d-flex">
        <?php
        include_once 'app/adms/include/menu.php';

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $result_tps_pgs = "SELECT * FROM adms_tps_pgs WHERE id=$id ORDER BY ordem ASC LIMIT 1";
                
        $resultado_tps_pgs = mysqli_query($conn, $result_tps_pgs);
        $row_tps_pgs = mysqli_fetch_assoc($resultado_tps_pgs);
        ?>
        <div class="content p-1">
            <div class="list-group-item">
                <div class="d-flex">
                    <div class="mr-auto p-2">
                        <h2 class="display-4 titulo">Detalhes do Tipo de Página</h2>
                    </div>
                    <div class="p-2">
                        <span class = "d-none d-md-block">
                        <?php
                        $btn_list = carregar_btn('listar/list_tps_pgs', $conn);
                        if ($btn_list) {
                            echo "<a href='" . pg . "/listar/list_tps_pgs' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        $btn_edit = carregar_btn('editar/edit_tps_pgs', $conn);
                        if ($btn_edit) {
                            echo "<a href='" . pg . "/editar/edit_tps_pgs?id=" . $row_tps_pgs['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                        }
                        $btn_apagar = carregar_btn('processa/apagar_tps_pgs', $conn);
                        if ($btn_apagar) {
                            echo "<a href='" . pg . "/processa/apagar_tps_pgs?id=" . $row_tps_pgs['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                    echo "<a class='dropdown-item' href='" . pg . "/listar/list_tps_pgs'>Listar</a>";
                                }
                                if ($btn_edit) {
                                    echo "<a class='dropdown-item' href='" . pg . "/editar/edit_tps_pgs?id=" . $row_tps_pgs['id'] . "'>Editar</a>";
                                }
                                if ($btn_apagar) {
                                    echo "<a class='dropdown-item' href='" . pg . "/processa/apagar_tps_pgs?id=" . $row_tps_pgs['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div><hr>
                <?php
                if (($resultado_tps_pgs) AND ( $resultado_tps_pgs->num_rows != 0)) {
                    
                    ?>
                    <dl class="row">
                        <dt class="col-sm-3">ID</dt>
                        <dd class="col-sm-9"><?php echo $row_tps_pgs['id']; ?></dd>

                        <dt class="col-sm-3">Tipo</dt>
                        <dd class="col-sm-9"><?php echo $row_tps_pgs['tipo']; ?></dd>

                        <dt class="col-sm-3">Nome</dt>
                        <dd class="col-sm-9"><?php echo $row_tps_pgs['nome']; ?></dd>

                        <dt class="col-sm-3">Observação</dt>
                        <dd class="col-sm-9"><?php echo $row_tps_pgs['obs']; ?></dd>

                        <dt class="col-sm-3">Ordem</dt>
                        <dd class="col-sm-9"><?php echo $row_tps_pgs['ordem']; ?></dd>

                        <dt class="col-sm-3 text-truncate">Data do Cadastro</dt>
                        <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($row_tps_pgs['created'])); ?></dd>

                        <dt class="col-sm-3 text-truncate">Data de Edição</dt>
                        <dd class="col-sm-9"><?php
                            if (!empty($row_tps_pgs['modified'])) {
                                echo date('d/m/Y H:i:s', strtotime($row_tps_pgs['modified']));
                            }
                            ?></dd>

                    </dl>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        Nenhum registro encontrado!
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        include_once 'app/adms/include/rodape_lib.php';
        ?>

    </div>
</body>


