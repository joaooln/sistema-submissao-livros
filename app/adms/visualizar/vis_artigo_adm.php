<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    $result_artigo_vis = "SELECT artigo.*,
            sitartigo.nome nome_sitartigo,
            cors.cor cor_cors,
            user.nome
            FROM adms_artigos artigo
            INNER JOIN adms_sits_artigos sitartigo ON sitartigo.id=artigo.adms_sit_artigo_id
            INNER JOIN adms_cors cors ON cors.id=sitartigo.adms_cor_id
            INNER JOIN adms_usuarios user ON user.id=artigo.adms_usuario_id
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
                                <h2 class="display-4 titulo">Detalhes do Artigo</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/list_artigo', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/list_artigo_adm' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_aceite = carregar_btn('processa/proc_aceite', $conn);
                                    if ($btn_aceite && $row_artigo_vis['adms_sit_artigo_id'] == 1) {
                                        echo "<a href='#' data-toggle='modal' data-target='#confirma_aceite' data-pg='" . pg . "' data-id='" . $row_artigo_vis['id'] . "' class='btn btn-outline-success btn-sm'>Aceitar</a> ";
                                    }
                                    $btn_rejeita = carregar_btn('processa/proc_rejeita', $conn);
                                    if ($btn_rejeita && $row_artigo_vis['adms_sit_artigo_id'] == 1) {
                                        echo "<a href='#' data-toggle='modal' data-target='#confirma_rejeita' data-pg='" . pg . "' data-id='" . $row_artigo_vis['id'] . "' class='btn btn-outline-danger btn-sm'>Rejeitar</a>";
                                    }
                                    $btn_publicado = carregar_btn('processa/proc_publicado', $conn);
                                    if ($btn_publicado && $row_artigo_vis['adms_sit_artigo_id'] == 3) {
                                        echo "<a href='#' data-toggle='modal' data-target='#confirma_publicacao' data-pg='" . pg . "' data-id='" . $row_artigo_vis['id'] . "' class='btn btn-info btn-sm'>Publicado</a> ";
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
                                            echo "<a class='dropdown-item' href='" . pg . "/listar/list_artigo_adm'>Listar</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div><hr>
                        <dl class="row">                            

                            <dt class="col-sm-3">Código do Artigo</dt>
                            <dd class="col-sm-9"><?php echo $row_artigo_vis['id']; ?></dd>

                            <dt class="col-sm-3">Titulo do Artigo</dt>
                            <dd class="col-sm-9"><?php echo $row_artigo_vis['tituloArtigo']; ?></dd>

                            <dt class="col-sm-3">Titulo do Livro</dt>
                            <dd class="col-sm-9"><?php echo $row_artigo_vis['tituloLivro']; ?></dd>

                            <dt class="col-sm-3">Nome do Autor</dt>
                            <dd class="col-sm-9"><?php echo $row_artigo_vis['nome']; ?></dd>

                            <dt class="col-sm-3">Nome Coautores:</dt>
                            <dd class="col-sm-9"><?php echo $row_artigo_vis['nomeCoautor1']; ?></dd>

                            <dt class="col-sm-3"></dt>
                            <dd class="col-sm-9"><?php echo $row_artigo_vis['nomeCoautor2']; ?></dd>

                            <dt class="col-sm-3"></dt>
                            <dd class="col-sm-9"><?php echo $row_artigo_vis['nomeCoautor3']; ?></dd>

                            <dt class="col-sm-3"></dt>
                            <dd class="col-sm-9"><?php echo $row_artigo_vis['nomeCoautor4']; ?></dd>

                            <dt class="col-sm-3"></dt>
                            <dd class="col-sm-9"><?php echo $row_artigo_vis['nomeCoautor5']; ?></dd>

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
                                    ?>
                                </dd>
                                <?php
                            }
                            ?>

                            <dt class="col-sm-3">Data do Envio</dt>
                            <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($row_artigo_vis['created'])); ?></dd>

                            <dt class="col-sm-3 text-truncate">Data de Edição</dt>
                            <dd class="col-sm-9"><?php
                                if (!empty($row_artigo_vis['modified'])) {
                                    echo date('d/m/Y H:i:s', strtotime($row_artigo_vis['modified']));
                                }
                                ?>
                            </dd>

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

            // Janela Modal Confirma Aceite
            <div class="modal fade" id="confirma_aceite" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p></p>
                        </div>
                        <div class="modal-footer">
                            <?php
                            echo "<a href='" . pg . "/processa/proc_aceite?id=" . $row_artigo_vis['id'] . "' type='button' class='btn btn-primary'>Sim</a>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            // Janela Modal Rejeita Artigo
            <div class="modal fade" id="confirma_rejeita" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p></p>
                            <form method="POST" action="<?php echo pg; ?>/processa/proc_rejeita">
                                <input type="hidden" name="id" id="id" value="<?php
                                echo $row_artigo_vis['id'];
                                ?>">
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Motivo da Rejeição:</label>
                                    <textarea id="motivo_rejeicao" name="motivo_rejeicao" type="text" class="form-control" required></textarea>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <input name="SendRejeicao" id="SendRejeicao" type="submit" class="btn btn-success" value="Sim">
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            // Janela Modal Publicacao
            <div class="modal fade" id="confirma_publicacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p></p>
                            <form method="POST" action="<?php echo pg; ?>/processa/proc_publicado">
                                <input type="hidden" name="id" id="id" value="<?php
                                echo $row_artigo_vis['id'];
                                ?>">
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Link do livro:</label>
                                    <textarea id="link_livro" name="link_livro" type="text" class="form-control" required></textarea>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <input name="SendPublicado" id="SendPublicado" type="submit" class="btn btn-success" value="Sim">
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>

                $('#confirma_publicacao').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget)
                    var id = button.data('id')
                    var pg = button.data('pg')
                    var modal = $(this)
                    modal.find('.modal-title').text('Confirmar Publicação')
                    modal.find('.modal-body p').text('Confirmar publicação do artigo número: ' + id + ' ?')
                    modal.find('#id').val(id)
                    modal.find('.modal-footer a').attr("href", pg + '/processa/proc_publicado?id=' + id)
                })

                $('#confirma_aceite').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget)
                    var id = button.data('id')
                    var pg = button.data('pg')
                    var modal = $(this)
                    modal.find('.modal-title').text('Confirmar Aceite')
                    modal.find('.modal-body p').text('Confirmar aceite do artigo número: ' + id + ' ?')
                    modal.find('.modal-footer a').attr("href", pg + '/processa/proc_aceite?id=' + id)
                })

                $('#confirma_rejeita').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget)
                    var id = button.data('id')
                    var pg = button.data('pg')
                    var modal = $(this)
                    modal.find('.modal-title').text('Confirmar Rejeição')
                    modal.find('.modal-body p').text('Confirmar rejeição do artigo número: ' + id + ' ?')
                    modal.find('#id').val(id)
                    modal.find('.modal-footer a').attr("href", pg + '/processa/proc_rejeita?id=' + id)
                })

            </script>
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