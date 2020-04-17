<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    $result_artigo_vis = "SELECT artigo.*,
            livro.nome nome_livro,
            area.nome nome_area,
            sitartigo.nome nome_sitartigo,
            cors.cor cor_cors
            FROM adms_artigos artigo
            LEFT JOIN adms_livros livro ON livro.id=artigo.adms_livro_id
            LEFT JOIN adms_areas area ON (area.id=livro.adms_area_id) OR (area.id=artigo.adms_area_id)             
            INNER JOIN adms_sits_artigos sitartigo ON sitartigo.id=artigo.adms_sit_artigo_id
            INNER JOIN adms_cors cors ON cors.id=sitartigo.adms_cor_id
            WHERE artigo.id=$id LIMIT 1";
    $resultado_artigo_vis = mysqli_query($conn, $result_artigo_vis);
    if (($resultado_artigo_vis) AND ( $resultado_artigo_vis->num_rows != 0)) {
        $row_artigo_vis = mysqli_fetch_assoc($resultado_artigo_vis);
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
                                <h2 class="display-4 titulo">Detalhes da Submissão</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/list_artigo', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/list_artigo' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_edit = carregar_btn('editar/edit_artigo', $conn);
                                    if ($btn_edit) {
                                        echo "<a href='" . pg . "/editar/edit_artigo?id=" . $row_user_vis['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/apagar_artigo', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/apagar_artigo?id=" . $row_user_vis['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                            echo "<a class='dropdown-item' href='" . pg . "/listar/list_artigo'>Listar</a>";
                                        }
                                        if ($btn_edit) {
                                            echo "<a class='dropdown-item' href='" . pg . "/editar/edit_artigo?id=" . $row_user_vis['id'] . "'>Editar</a>";
                                        }
                                        if ($btn_apagar) {
                                            echo "<a class='dropdown-item' href='" . pg . "/processa/apagar_artigo?id=" . $row_user_vis['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div><hr>
                        <dl class="row">                   
                            <?php
                            if ($row_artigo_vis['adms_tp_subms_id'] == 1) {
                                echo "<dt class = 'col-sm-3'>Código do Capítulo</dt>";
                            } else {
                                echo "<dt class = 'col-sm-3'>Código do Livro</dt>";
                            }
                            ?>
                            <dd class = "col-sm-9"><?php echo $row_artigo_vis['id'];
                            ?></dd>

                            <?php
                            if ($row_artigo_vis['adms_tp_subms_id'] == 1) {
                                echo "<dt class = 'col-sm-3'>Título do Capítulo</dt>";
                            } else {
                                echo "<dt class = 'col-sm-3'>Título do Livro</dt>";
                            }
                            ?>
                            <dd class="col-sm-9"><?php
                                if ($row_artigo_vis['adms_tp_subms_id'] == 1) {
                                    echo $row_artigo_vis['tituloArtigo'];
                                } else {
                                    echo $row_artigo_vis['tituloLivro'];
                                }
                                ?></dd>
                            <?php
                            if ($row_artigo_vis['adms_livro_id'] != 0) {
                                echo "<dt class = 'col-sm-3'>Titulo do Livro</dt>";
                                echo "<dd class = 'col-sm-9'>";
                                if ($row_artigo_vis['adms_livro_id'] == 1) {
                                    echo $row_artigo_vis['tituloLivro'];
                                } else {
                                    echo $row_artigo_vis['nome_livro'];
                                }
                                echo "</dd>";
                            }
                            ?>

                            <dt class="col-sm-3">Área de Conhecimento</dt>
                            <dd class="col-sm-9">
                                <?php
                                if ($row_artigo_vis['areaLivro'] != null) {
                                    echo $row_artigo_vis['areaLivro'];
                                } else {
                                    echo $row_artigo_vis['nome_area'];
                                }
                                ?>
                            </dd>

                            <?php
                            for ($index = 1; $index < 10; $index++) {
                                if (!empty($row_artigo_vis['nomeCoautor' . $index . ''])) {
                                    echo "<dt class='col-sm-3'>Nome Coautor $index</dt>";
                                    echo "<dd class='col-sm-9'>" . $row_artigo_vis['nomeCoautor' . $index . ''] . "</dd>";
                                }
                            }
                            ?>

                            <dt class="col-sm-3">Trabalho está nas Normas?</dt>
                            <?php
                            if ($row_artigo_vis['normas'] == 1) {
                                $normas_texto = "Sim";
                            } else {
                                $normas_texto = "Não. A empresa irá realizar a normatização";
                            }
                            ?>
                            <dd class="col-sm-9"><?php echo $normas_texto ?></dd>

                            <dt class="col-sm-3">Nota Fiscal será emitida em seu nome?</dt>
                            <?php
                            if ($row_artigo_vis['nota_outro_nome'] == 1) {
                                $nota_outro_nome_texto = "Sim";
                            } elseif ($row_artigo_vis['nota_outro_nome'] == 2) {
                                $nota_outro_nome_texto = "Não. A Nota Fiscal deverá ser no nome de outra pessoa.";
                            } else {
                                $nota_outro_nome_texto = "Não. A Nota Fiscal deverá ser no nome de uma instituição ou empresa.";
                            }
                            ?>
                            <dd class="col-sm-9"><?php echo $nota_outro_nome_texto ?></dd>

                            <?php if (!empty($row_artigo_vis['nome_nota'])) { ?>
                                <dt class="col-sm-3">Nota será emitida com os seguintes dados:<dt>
                                <dd class="col-sm-9">
                                    <?php
                                    echo $row_artigo_vis['nome_nota'];
                                    if (!empty($row_artigo_vis['cpf_nota'])) {
                                        echo " - CPF: " . $row_artigo_vis['cpf_nota'] . "";
                                    } else {
                                        echo " - CNPJ: " . $row_artigo_vis['cnpj_nota'] . "";
                                    }

                                    if (!empty($row_artigo_vis['email_nota'])) {
                                        echo " - E-mail: " . $row_artigo_vis['email_nota'] . "";
                                    }

                                    if (!empty($row_artigo_vis['telefone_nota'])) {
                                        echo " - Telefone: " . $row_artigo_vis['telefone_nota'] . "";
                                    }
                                    ?>
                                    <br/>
                                    <?php
                                    if (!empty($row_artigo_vis['endereco_nota'])) {
                                        echo "Endereço: " . $row_artigo_vis['endereco_nota'] . "";
                                    }
                                    ?>
                                </dd>
                                <?php
                            }
                            ?>

                            <dt class="col-sm-3">Data do Envio</dt>
                            <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($row_artigo_vis['created'])); ?></dd>

                            <?php if (!empty($row_artigo_vis['modified'])) { ?>
                                <dt class="col-sm-3 text-truncate">Data de Edição</dt>
                                <dd class="col-sm-9"><?php
                                    if (!empty($row_artigo_vis['modified'])) {
                                        echo date('d/m/Y H:i:s', strtotime($row_artigo_vis['modified']));
                                    }
                                    ?>
                                </dd>
                                <?php
                            }
                            ?>

                            <dt class="col-sm-3">Situação</dt>
                            <dd class="col-sm-9"><?php
                                echo "<span class='badge badge-" . $row_artigo_vis['cor_cors'] . "'>" . $row_artigo_vis['nome_sitartigo'] . "</span>";
                                ?></dd>

                            <?php if (!empty($row_artigo_vis['motivo_rejeicao'])) { ?>
                                <dt class="col-sm-3">Motivo da Rejeição:<dt>
                                <dd class="col-sm-9">
                                    <?php
                                    echo $row_artigo_vis['motivo_rejeicao'];
                                    ?>
                                </dd>
                                <?php
                            }
                            ?>

                            <?php if (!empty($row_artigo_vis['data_publicacao'])) { ?>
                                <dt class="col-sm-3">Data da Publicação:<dt>
                                <dd class="col-sm-9">
                                    <?php
                                    echo $row_artigo_vis['data_publicacao'];
                                    ?>
                                </dd>
                                <?php
                            }
                            ?>

                            <?php if (!empty($row_artigo_vis['valor_livro'])) { ?>
                                <dt class="col-sm-3">Valor do livro:<dt>
                                <dd class="col-sm-9">
                                    <?php
                                    //echo number_format($row_artigo_vis['valor_livro'], 2, '.', '');
                                    echo $row_artigo_vis['valor_livro'];
                                    ?>
                                </dd>
                                <?php
                            }
                            ?>

                            <?php if (!empty($row_artigo_vis['descri_valor_livro'])) { ?>
                                <dt class="col-sm-3">Descriminação do valor do livro:<dt>
                                <dd class="col-sm-9">
                                    <?php
                                    echo $row_artigo_vis['descri_valor_livro'];
                                    ?>
                                </dd>
                                <?php
                            }
                            ?>

                            <?php if (!empty($row_artigo_vis['url_livro'])) { ?>
                                <dt class="col-sm-3">Link do livro:<dt>
                                <dd class="col-sm-9">
                                    <?php
                                    echo $row_artigo_vis['url_livro'];
                                    ?>
                                </dd>
                                <?php
                            }
                            ?>

                            <dt class="col-sm-3">Arquivo</dt>
                            <dd class="col-sm-9">
                                <?php
                                echo "<a href = '" . pg . "/assets/artigosRecebidos/" . $row_artigo_vis['id'] . "/" . $row_artigo_vis['arquivo'] . "'>" . $row_artigo_vis["arquivo"] . "</a>";
                                ?>
                            </dd>
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
        $_SESSION['msg'] = "<div class='alert alert-danger'>Artigo não encontrado!</div>";
        $url_destino = pg . '/listar/list_artigo';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . ' / acesso / login';
    header("Location: $url_destino");
}    