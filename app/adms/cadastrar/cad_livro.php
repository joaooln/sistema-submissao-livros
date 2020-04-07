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
        ?>
        <div class="content p-1">
            <div class="list-group-item">
                <div class="d-flex">
                    <div class="mr-auto p-2">
                        <h2 class="display-4 titulo">Cadastrar Livro</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_list = carregar_btn('listar/list_livro', $conn);
                        if ($btn_list) {
                            echo "<a href='" . pg . "/listar/list_livro' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        ?>
                    </div>
                </div><hr>
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
                <form method="POST" action="<?php echo pg; ?>/processa/proc_cad_livro">  
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
                                <span class="text-danger">*</span> Área de conhecimento
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Selecionar a área de conhecimento do livro.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </label>
                            <select name="adms_area_id" id="adms_area_id" class="custom-select" required>
                                <option value="">Selecione</option>
                                <?php
                                while ($row_areas = mysqli_fetch_assoc($resultado_areas)) {
                                    if (isset($_SESSION['dados']['adms_area_id']) AND ( $_SESSION['dados']['adms_area_id'] == $row_areas['id'])) {
                                        echo " <option selected value=" . $row_areas['id'] . ">" . $row_areas['nome'] . "</option>";
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
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Selecionar a situação do item do menu.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </label>
                            <select name="adms_sit_id" id="adms_sit_id" class="custom-select" required>
                                <option value="">Selecione</option>
                                <?php
                                while ($row_sits = mysqli_fetch_assoc($resultado_sits)) {
                                    if (isset($_SESSION['dados']['adms_sit_id']) AND ( $_SESSION['dados']['adms_sit_id'] == $row_sits['id'])) {
                                        echo " <option selected value=" . $row_sits['id'] . ">" . $row_sits['nome'] . "</option>";
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
                            <input type="date" id="data_publicacao" name="data_publicacao" class="form-control" required>
                        </div>
                    </div>

                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadLivro" type="submit" class="btn btn-success" value="Cadastrar">
                </form>
            </div>
        </div>
        <?php
        unset($_SESSION['dados']);
        include_once 'app/adms/include/rodape_lib.php';
        ?>

    </div>
</body>


