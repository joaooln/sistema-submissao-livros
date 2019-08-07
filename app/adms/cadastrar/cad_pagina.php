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
                        <h2 class="display-4 titulo">Cadastrar Página</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_list = carregar_btn('listar/list_pagina', $conn);
                        if ($btn_list) {
                            echo "<a href='" . pg . "/listar/list_pagina' class='btn btn-outline-info btn-sm'>Listar</a> ";
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
                <form method="POST" action="<?php echo pg; ?>/processa/proc_cad_pagina">  
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label>
                                <span class="text-danger">*</span> Nome
                                <span data-placement="top" tabindex="0" data-toggle="tooltip" title="Nome da página a ser apresentado no menu ou listar páginas">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </label>
                            <input name="nome_pagina" type="text" class="form-control" id="nome" placeholder="Nome da Página" value="<?php
                            if (isset($_SESSION['dados']['nome_pagina'])) {
                                echo $_SESSION['dados']['nome_pagina'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label><span class="text-danger">*</span> Endereço</label>
                            <input name="endereco" type="text" class="form-control" id="email" placeholder="Endereço da página, ex: listar/list_pagina" value="<?php
                            if (isset($_SESSION['dados']['endereco'])) {
                                echo $_SESSION['dados']['endereco'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label> Ícone</label>
                            <span data-html="true" data-placement="top" tabindex="0" data-toggle="tooltip" title="Página de icone: <a href='https://fontawesome.com/icons?d=gallery' target='_blank'>Fontawesome</a>. Somente inserir o nome, Ex: fas fa-volume-up">
                                <i class="fas fa-question-circle"></i>
                            </span>
                            <input name="icone" type="text" class="form-control" id="email" placeholder="Ícone da página" value="<?php
                            if (isset($_SESSION['dados']['icone'])) {
                                echo $_SESSION['dados']['icone'];
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label> Observação</label>
                        <textarea name="obs" class="form-control"><?php
                            if (isset($_SESSION['dados']['obs'])) {
                                echo $_SESSION['dados']['obs'];
                            }
                            ?></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label>
                                <span class="text-danger">*</span> Palavra chave
                                <span data-placement="top" tabindex="0" data-toggle="tooltip" title="Principais palavras que indicam a função da página. Por exemplo a página login: Página de login, login. Máximo 180 letras.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </label>
                            <input name="keywords" type="text" class="form-control" id="nome" placeholder="Palavra chave" value="<?php
                            if (isset($_SESSION['dados']['keywords'])) {
                                echo $_SESSION['dados']['keywords'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                <span class="text-danger">*</span> Descrição
                                <span data-placement="top" tabindex="0" data-toggle="tooltip" title="Resumo do principal objetivo da página, máximo 180 letras..">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </label>
                            <input name="description" type="text" class="form-control" id="email" placeholder="Descrição da página" value="<?php
                            if (isset($_SESSION['dados']['description'])) {
                                echo $_SESSION['dados']['description'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>
                                <span class="text-danger">*</span> Autor
                                <span data-placement="top" tabindex="0" data-toggle="tooltip" title="Desenvolvedor responsável pela criação da página">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </label>
                            <input name="author" type="text" class="form-control" id="email" placeholder="Desenvolvedor" value="<?php
                            if (isset($_SESSION['dados']['author'])) {
                                echo $_SESSION['dados']['author'];
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <?php
                            $result_robots = "SELECT id, nome FROM adms_robots";
                            $resultado_robots = mysqli_query($conn, $result_robots);
                            ?>
                            <label>
                                <span class="text-danger">*</span> Indexar
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="A página deve ser indexada pelos buscadores.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </label>
                            <select name="adms_robot_id" id="adms_robot_id" class="custom-select" required>
                                <option value="">Selecione</option>
                                <?php
                                while ($row_robots = mysqli_fetch_assoc($resultado_robots)) {
                                    if (isset($_SESSION['dados']['adms_robot_id']) AND ( $_SESSION['dados']['adms_robot_id'] == $row_robots['id'])) {
                                        echo " <option selected value=" . $row_robots['id'] . ">" . $row_robots['nome'] . "</option>";
                                    } else {
                                        echo " <option value=" . $row_robots['id'] . ">" . $row_robots['nome'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                <span class="text-danger">*</span> Página pública
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Página pública significa que para acessar a página não é necessário fazer login ou estar logado no administrativo">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </label>
                            <select name="lib_pub" id="lib_pub" class="custom-select" required>
                                <?php
                                if (isset($_SESSION['dados']['lib_pub']) AND ( $_SESSION['dados']['lib_pub'] == 1)) {
                                    echo "<option value=''>Selecione</option>";
                                    echo "<option value='1' selected>Sim</option>";
                                    echo "<option value='2'>Não</option>";
                                } elseif (isset($_SESSION['dados']['lib_pub']) AND ( $_SESSION['dados']['lib_pub'] == 2)) {
                                    echo "<option value=''>Selecione</option>";
                                    echo "<option value='1'>Sim</option>";
                                    echo "<option value='2' selected>Não</option>";
                                } else {
                                    echo "<option value='' selected>Selecione</option>";
                                    echo "<option value='1'>Sim</option>";
                                    echo "<option value='2'>Não</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <?php
                            $result_depend_pg = "SELECT id, nome_pagina FROM adms_paginas ORDER BY nome_pagina ASC";
                            $resultado_depend_pg = mysqli_query($conn, $result_depend_pg);
                            ?>
                            <label>
                                <span class="text-danger">*</span> Página Dependente
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Quando a página é dependente, por exemplo 'processa/proc_cad_usuario' é dependente da página 'cadastrar/cad_usuario', ao liberar a página 'cadastrar/cad_usuario' é liberado automaticamente a página 'processa/proc_cad_usuario'.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </label>
                            <select name="depend_pg" id="depend_pg" class="custom-select" required>
                                <option value="">Selecione</option>
                                <?php
                                if (isset($_SESSION['dados']['depend_pg']) AND ( $_SESSION['dados']['depend_pg'] == 0)) {
                                    echo "<option selected value='0'>Não depende de outra página</option>";
                                } else {
                                    echo "<option value='0'>Não depende de outra página</option>";
                                }
                                while ($row_depend_pg = mysqli_fetch_assoc($resultado_depend_pg)) {
                                    if (isset($_SESSION['dados']['depend_pg']) AND ( $_SESSION['dados']['depend_pg'] == $row_depend_pg['id'])) {
                                        echo " <option selected value=" . $row_depend_pg['id'] . ">" . $row_depend_pg['nome_pagina'] . "</option>";
                                    } else {
                                        echo " <option value=" . $row_depend_pg['id'] . ">" . $row_depend_pg['nome_pagina'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <?php
                            $result_grupo = "SELECT id, nome FROM adms_grps_pgs ORDER BY id ASC";
                            $resultado_grupo = mysqli_query($conn, $result_grupo);
                            ?>
                            <label>
                                <span class="text-danger">*</span> Grupo
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Selecionar a qual grupo a página pertence.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </label>
                            <select name="adms_grps_pg_id" id="adms_grps_pg_id" class="custom-select" required>
                                <option value="">Selecione</option>
                                <?php
                                while ($row_grupo = mysqli_fetch_assoc($resultado_grupo)) {
                                    if (isset($_SESSION['dados']['adms_grps_pg_id']) AND ( $_SESSION['dados']['adms_grps_pg_id'] == $row_grupo['id'])) {
                                        echo " <option selected value=" . $row_grupo['id'] . ">" . $row_grupo['nome'] . "</option>";
                                    } else {
                                        echo " <option value=" . $row_grupo['id'] . ">" . $row_grupo['nome'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <?php
                            $result_tp_pg = "SELECT id, tipo, nome FROM adms_tps_pgs ORDER BY nome ASC";
                            $resultado_tp_pg = mysqli_query($conn, $result_tp_pg);
                            ?>
                            <label>
                                <span class="text-danger">*</span> Tipo
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Selecionar o tipo de arquivo, ao qual diretório pertence no projeto.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </label>
                            <select name="adms_tps_pg_id" id="adms_tps_pg_id" class="custom-select" required>
                                <option value="">Selecione</option>
                                <?php
                                while ($row_tp_pg = mysqli_fetch_assoc($resultado_tp_pg)) {
                                    if (isset($_SESSION['dados']['adms_tps_pg_id']) AND ( $_SESSION['dados']['adms_tps_pg_id'] == $row_tp_pg['id'])) {
                                        echo " <option selected value=" . $row_tp_pg['id'] . ">" . $row_tp_pg['tipo'] . " - " . $row_tp_pg['nome'] . "</option>";
                                    } else {
                                        echo " <option value=" . $row_tp_pg['id'] . ">" . $row_tp_pg['tipo'] . " - " . $row_tp_pg['nome'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <?php
                            $result_sit_pg = "SELECT id, nome FROM adms_sits_pgs ORDER BY id ASC";
                            $resultado_sit_pg = mysqli_query($conn, $result_sit_pg);
                            ?>
                            <label>
                                <span class="text-danger">*</span> Situação
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Selecionar a situação da página no projeto.">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                            </label>
                            <select name="adms_sits_pg_id" id="adms_sits_pg_id" class="custom-select" required>
                                <option value="">Selecione</option>
                                <?php
                                while ($row_sit_pg = mysqli_fetch_assoc($resultado_sit_pg)) {
                                    if (isset($_SESSION['dados']['adms_sits_pg_id']) AND ( $_SESSION['dados']['adms_sits_pg_id'] == $row_sit_pg['id'])) {
                                        echo " <option selected value=" . $row_sit_pg['id'] . ">" . $row_sit_pg['nome'] . "</option>";
                                    } else {
                                        echo " <option value=" . $row_sit_pg['id'] . ">" . $row_sit_pg['nome'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadPg" type="submit" class="btn btn-success" value="Cadastrar">
                </form>
            </div>    
        </div>
        <?php
        unset($_SESSION['dados']);
        include_once 'app/adms/include/rodape_lib.php';
        ?>

    </div>
</body>


