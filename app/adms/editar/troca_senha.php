<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($id) {

    $result_edit_senha = "SELECT * FROM adms_usuarios WHERE id=$id LIMIT 1";

    $resultado_edit_senha = mysqli_query($conn, $result_edit_senha);
    if (($resultado_edit_senha) AND ( $resultado_edit_senha->num_rows != 0)) {
        $row_edit_senha = mysqli_fetch_assoc($resultado_edit_senha);
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
                                <h2 class="display-4 titulo">Troca Senha</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('visualizar/vis_perfil', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/visualizar/vis_perfil' class='btn btn-outline-info btn-sm'>Cancelar</a> ";
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
                                        echo "<a class='dropdown-item' href='" . pg . "/visualizar/vis_perfil'>Cancelar</a>";
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
                        <form method="POST" action="<?php echo pg; ?>/processa/proc_troca_senha">                    
                            <input type="hidden" name="id" value="<?php
                            if (isset($row_edit_senha['id'])) {
                                echo $row_edit_senha['id'];
                            }
                            ?>">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>
                                        <span class="text-danger">*</span> Nova Senha
                                        <span data-placement="top" tabindex="0" data-toggle="tooltip" title="Informe uma nova senha">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                    </label>
                                    <input name="nova_senha" type="password" class="form-control" placeholder="Nova Senha" value="" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>
                                        <span class="text-danger">*</span> Confirma Nova Senha
                                        <span data-placement="top" tabindex="0" data-toggle="tooltip" title="Informe novamente a nova senha">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                    </label>
                                    <input name="nova_senha_conf" type="password" class="form-control" placeholder="Confirma Nova Senha" value="" required>
                                </div>
                            </div>
                            <p>
                                <span class="text-danger">* </span>Campo obrigatório
                            </p>
                            <input name="SendTrocaSenha" type="submit" class="btn btn-warning" value="Salvar">
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
        $_SESSION['msg'] = "<div class='alert alert-danger'>Usuário não encontrado!1 <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        $url_destino = pg . '/visualizar/vis_perfil';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Usuário não encontrado!2 <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $url_destino = pg . '/visualizar/vis_perfil';
    header("Location: $url_destino");
}


