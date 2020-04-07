<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($id) {

    $result_edit_livro = "SELECT * FROM adms_livros WHERE id=$id LIMIT 1";

    $resultado_edit_livro = mysqli_query($conn, $result_edit_livro);
    if (($resultado_edit_livro) AND ( $resultado_edit_livro->num_rows != 0)) {
        $row_edit_livro = mysqli_fetch_assoc($resultado_edit_livro);
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
                                <h2 class="display-4 titulo">Editar Livro</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/list_livro', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/list_livro' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_vis = carregar_btn('visualizar/vis_livro', $conn);
                                    if ($btn_vis) {
                                        echo "<a href='" . pg . "/visualizar/vis_livro?id=" . $row_edit_livro['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/apagar_livro', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/apagar_livro?id=" . $row_edit_livro['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                        echo "<a class='dropdown-item' href='" . pg . "/listar/list_livro'>Listar</a>";
                                    }
                                    if ($btn_vis) {
                                        echo "<a class='dropdown-item' href='" . pg . "/visualizar/vis_livro?id=" . $row_edit_livro['id'] . "'>Visualizar</a>";
                                    }
                                    if ($btn_apagar) {
                                        echo "<a class='dropdown-item' href='" . pg . "/processa/apagar_livro?id=" . $row_edit_livro['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                        <form method="POST" action="<?php echo pg; ?>/processa/proc_edit_livro">                    
                            <input type="hidden" name="id" value="<?php
                            if (isset($row_edit_livro['id'])) {
                                echo $row_edit_livro['id'];
                            }
                            ?>">

                            <div class="form-group">
                                <label>
                                    <span class="text-danger">*</span> Título
                                    <span data-placement="top" tabindex="0" data-toggle="tooltip" title="Título do livro">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                </label>
                                <input name="nome" type="text" class="form-control" placeholder="Título do livro" value="<?php
                                if (isset($_SESSION['dados']['nome'])) {
                                    echo $_SESSION['dados']['nome'];
                                } elseif (isset($row_edit_livro['nome'])) {
                                    echo $row_edit_livro['nome'];
                                }
                                ?>">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <?php
                                    $result_areas = "SELECT id, nome FROM adms_areas ORDER BY id ASC";
                                    $resultado_areas = mysqli_query($conn, $result_areas);
                                    ?>
                                    <label>
                                        <span class="text-danger">*</span> Área
                                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Selecionar a área do livro.">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                    </label>
                                    <select name="adms_areas_id" id="adms_areas_id" class="custom-select" required>
                                        <option value="">Selecione</option>
                                        <?php
                                        while ($row_areas = mysqli_fetch_assoc($resultado_areas)) {
                                            if (isset($_SESSION['dados']['adms_area_id']) AND ( $_SESSION['dados']['adms_area_id'] == $row_areas['id'])) {
                                                echo " <option selected value=" . $row_areas['id'] . ">" . $row_areas['nome'] . "</option>";
                                                //Preencher com informações do banco de dados caso não tenha nenhum valor salvo na sessão $_SESSION['dados']
                                            } elseif (!isset($_SESSION['dados']['adms_area_id']) AND ( isset($row_edit_livro['adms_area_id']) AND ( $row_edit_livro['adms_area_id'] == $row_areas['id']))) {
                                                echo "<option value='" . $row_areas['id'] . "' selected>" . $row_areas['nome'] . "</option>";
                                            } else {
                                                echo " <option value=" . $row_areas['id'] . ">" . $row_areas['nome'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <?php
                                    $result_sits = "SELECT id, nome FROM adms_sits ORDER BY id ASC";
                                    $resultado_sits = mysqli_query($conn, $result_sits);
                                    ?>
                                    <label>
                                        <span class="text-danger">*</span> Situação
                                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Selecionar a situação do livro.">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                    </label>
                                    <select name="adms_sits_id" id="adms_sits_id" class="custom-select" required>
                                        <option value="">Selecione</option>
                                        <?php
                                        while ($row_sits = mysqli_fetch_assoc($resultado_sits)) {
                                            if (isset($_SESSION['dados']['adms_sit_id']) AND ( $_SESSION['dados']['adms_sit_id'] == $row_sits['id'])) {
                                                echo " <option selected value=" . $row_sits['id'] . ">" . $row_sits['nome'] . "</option>";
                                                //Preencher com informações do banco de dados caso não tenha nenhum valor salvo na sessão $_SESSION['dados']
                                            } elseif (!isset($_SESSION['dados']['adms_sit_id']) AND ( isset($row_edit_livro['adms_sit_id']) AND ( $row_edit_livro['adms_sit_id'] == $row_sits['id']))) {
                                                echo "<option value='" . $row_sits['id'] . "' selected>" . $row_sits['nome'] . "</option>";
                                            } else {
                                                echo " <option value=" . $row_sits['id'] . ">" . $row_sits['nome'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>
                                        <span class="text-danger">*</span> Data da Publicação
                                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Informar a data de publicação do livro.">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                    </label>
                                    <input type="date" id="data_publicacao" name="data_publicacao" onkeypress="return dateMask(this, event);" class="form-control" required value="<?php
                                    if (isset($_SESSION['dados']['data_publicacao'])) {
                                        echo strftime('%Y-%m-%d', strtotime($_SESSION['dados']['data_publicacao']));
                                    } elseif (isset($row_edit_livro['data_publicacao'])) {
                                        echo strftime('%Y-%m-%d', strtotime($row_edit_livro['data_publicacao']));
                                    }
                                    ?>">
                                </div>
                            </div>

                            <p>
                                <span class="text-danger">* </span>Campo obrigatório
                            </p>
                            <input name="SendEditLivro" type="submit" class="btn btn-warning" value="Salvar">
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
        $_SESSION['msg'] = "<div class='alert alert-danger'>Nível de acesso não encontrado! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        $url_destino = pg . '/listar/list_livro';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Nível de acesso não encontrado! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    $url_destino = pg . '/listar/list_livro';
    header("Location: $url_destino");
}


