<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($id) {
    $result_tps_pgs_ed = "SELECT * FROM adms_tps_pgs WHERE id=$id LIMIT 1";

    $resultado_tps_pgs_ed = mysqli_query($conn, $result_tps_pgs_ed);
    if (($resultado_tps_pgs_ed) AND ( $resultado_tps_pgs_ed->num_rows != 0)) {
        $row_tps_pgs_ed = mysqli_fetch_assoc($resultado_tps_pgs_ed);
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
                                <h2 class="display-4 titulo">Editar Tipo de Página</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/list_tps_pgs', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/list_tps_pgs' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_vis = carregar_btn('visualizar/vis_tps_pgs', $conn);
                                    if ($btn_vis) {
                                        echo "<a href='" . pg . "/visualizar/vis_tps_pgs?id=" . $row_tps_pgs_ed['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/apagar_tps_pgs', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/apagar_tps_pgs?id=" . $row_tps_pgs_ed['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                        if ($btn_vis) {
                                            echo "<a class='dropdown-item' href='" . pg . "/visualizar/vis_tps_pgs?id=" . $row_tps_pgs_ed['id'] . "'>Visualizar</a>";
                                        }
                                        if ($btn_apagar) {
                                            echo "<a class='dropdown-item' href='" . pg . "/processa/apagar_tps_pgs?id=" . $row_tps_pgs_ed['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div><hr>
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <form method="POST" action="<?php echo pg; ?>/processa/proc_edit_tps_pgs">                    
                            <input type="hidden" name="id" value="<?php
                            if (isset($row_tps_pgs_ed['id'])) {
                                echo $row_tps_pgs_ed['id'];
                            }
                            ?>">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>                                
                                        <span class="text-danger">*</span> Tipo
                                    </label>
                                    <input name="tipo" type="text" class="form-control" id="tipo" placeholder="Tipo da página exe: adms" value="<?php
                                    if (isset($_SESSION['dados']['tipo'])) {
                                        echo $_SESSION['dados']['tipo'];
                                    }elseif (isset($row_tps_pgs_ed['tipo'])) {
                                        echo $row_tps_pgs_ed['tipo'];
                                    }
                                    ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label><span class="text-danger">*</span> Nome</label>
                                    <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome do tipo da página" value="<?php
                                    if (isset($_SESSION['dados']['nome'])) {
                                        echo $_SESSION['dados']['nome'];
                                    }elseif (isset($row_tps_pgs_ed['nome'])) {
                                        echo $row_tps_pgs_ed['nome'];
                                    }
                                    ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label><span class="text-danger">*</span> Observação</label>
                                <textarea name="obs" class="form-control"><?php
                                    if (isset($_SESSION['dados']['obs'])) {
                                        echo $_SESSION['dados']['obs'];
                                    }elseif (isset($row_tps_pgs_ed['obs'])) {
                                        echo $row_tps_pgs_ed['obs'];
                                    }
                                    ?></textarea>
                            </div>
                            
                            <p>
                                <span class="text-danger">* </span>Campo obrigatório
                            </p>
                            <input name="SendEditTpsPgs" type="submit" class="btn btn-warning" value="Salvar">
                        </form>
                    </div>    
                </div>
                <?php
                include_once 'app/adms/include/rodape_lib.php';
                ?>

            </div>
        </body>
        <?php
        unset($_SESSION['dados']);
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Tipo de página não encontrado! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        $url_destino = pg . '/listar/list_tps_pgs';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Tipo de página não encontrado! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $url_destino = pg . '/listar/list_tps_pgs';
    header("Location: $url_destino");
}


