<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($id) {

    $result_edit_area = "SELECT * FROM adms_areas WHERE id=$id LIMIT 1";

    $resultado_edit_area = mysqli_query($conn, $result_edit_area);
    if (($resultado_edit_area) AND ( $resultado_edit_area->num_rows != 0)) {
        $row_edit_area = mysqli_fetch_assoc($resultado_edit_area);
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
                                <h2 class="display-4 titulo">Editar Área</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/list_area', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/list_area' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_vis = carregar_btn('visualizar/vis_area', $conn);
                                    if ($btn_vis) {
                                        echo "<a href='" . pg . "/visualizar/vis_area?id=" . $row_edit_area['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/apagar_area', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/apagar_area?id=" . $row_edit_area['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="dropdown d-block d-md-none">
                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ações
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                    <?php
                                    if ($btn_list) {
                                        echo "<a class='dropdown-item' href='" . pg . "/listar/list_area'>Listar</a>";
                                    }
                                    if ($btn_vis) {
                                        echo "<a class='dropdown-item' href='" . pg . "/visualizar/vis_area?id=" . $row_edit_area['id'] . "'>Visualizar</a>";
                                    }
                                    if ($btn_apagar) {
                                        echo "<a class='dropdown-item' href='" . pg . "/processa/apagar_area?id=" . $row_edit_area['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div><hr>
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <form method="POST" action="<?php echo pg; ?>/processa/proc_edit_area">                    
                            <input type="hidden" name="id" value="<?php
                            if (isset($row_edit_area['id'])) {
                                echo $row_edit_area['id'];
                            }
                            ?>">

                            <div class="form-group">
                                <label>
                                    <span class="text-danger">*</span> Nome
                                    <span data-placement="top" tabindex="0" data-toggle="tooltip" title="Nome da área">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                </label>
                                <input name="nome" type="text" class="form-control" placeholder="Nome da área" value="<?php
                                if (isset($_SESSION['dados']['nome'])) {
                                    echo $_SESSION['dados']['nome'];
                                } elseif (isset($row_edit_area['nome'])) {
                                    echo $row_edit_area['nome'];
                                }
                                ?>">
                            </div>
                            <p>
                                <span class="text-danger">* </span>Campo obrigatório
                            </p>
                            <input name="SendEditArea" type="submit" class="btn btn-warning" value="Salvar">
                        </form>
                    </div>    
                </div>
                <?php
                include_once 'app/adms/include/rodape_lib.php';
                ?>

            </div>
        </body>
        <?php
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Área não encontrada! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        $url_destino = pg . '/listar/list_area';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Nível de acesso não encontrado! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $url_destino = pg . '/listar/list_area';
    header("Location: $url_destino");
}


