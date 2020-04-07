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
                        <h2 class="display-4 titulo">Capítulos Publicados</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_cad = carregar_btn('cadastrar/cad_artigo', $conn);
                        if ($btn_cad) {
                            echo "<a href='" . pg . "/cadastrar/cad_artigo' class='btn btn-outline-success btn-sm'>Novo Artigo</a>";
                        }
                        ?>
                    </div>
                </div>
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }

                //Receber o número da página
                $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
                $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

                //Setar a quantidade de itens por pagina
                $qnt_result_pg = 10;

                //Calcular o inicio visualização
                $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;

                $resul_artigo = "SELECT artigo.id, artigo.tituloArtigo, artigo.tituloLivro, artigo.arquivo, artigo.adms_livro_id, sitartigo.nome nome_sitartigo, cors.cor cor_cors, artigo.adms_sit_artigo_id, livro.nome nome_livro
                            FROM adms_artigos artigo
                            LEFT JOIN adms_livros livro ON livro.id=artigo.adms_livro_id
                            INNER JOIN adms_usuarios user ON user.id=artigo.adms_usuario_id
                            INNER JOIN adms_sits_artigos sitartigo ON sitartigo.id=artigo.adms_sit_artigo_id
                            INNER JOIN adms_cors cors ON cors.id=sitartigo.adms_cor_id
                            WHERE artigo.adms_sit_artigo_id = 5
                            ORDER BY artigo.id DESC LIMIT $inicio, $qnt_result_pg";


                $resultado_artigo = mysqli_query($conn, $resul_artigo);
                if (($resultado_artigo) AND ( $resultado_artigo->num_rows != 0)) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Tipo</th>
                                    <th>Título do Capítulo</th>
                                    <th class="d-none d-sm-table-cell">Título do Livro</th>
                                    <th class="d-none d-sm-table-cell">Status</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row_artigo = mysqli_fetch_assoc($resultado_artigo)) {
                                    ?>
                                    <tr>
                                        <th><?php echo $row_artigo['id']; ?></th>
                                        <td>
                                            <?php
                                            $resul_tipo = "SELECT tipo.nome
                                                           FROM adms_tps_subms tipo
                                                           WHERE tipo.id = '" . $row_artigo['adms_tp_subms_id'] . "'
                                                           LIMIT 1";
                                            $resultado_tipo = mysqli_query($conn, $resul_tipo);
                                            $row_tipo = mysqli_fetch_assoc($resultado_tipo);
                                            echo $row_tipo['nome'];
                                            ?>
                                        </td>
                                        <td><?php echo $row_artigo['tituloArtigo']; ?></td>
                                        <td class="d-none d-sm-table-cell">
                                            <?php
                                            if (($row_artigo['adms_livro_id'] == 1) OR ($row_artigo['adms_livro_id'] == 0)) {
                                                echo $row_artigo['tituloLivro'];
                                            } else {
                                                echo $row_artigo['nome_livro'];
                                            }
                                            ?>
                                        </td>
                                        <td class="d-none d-sm-table-cell"><?php
                                            echo "<span class='badge badge-" . $row_artigo['cor_cors'] . "'>" . $row_artigo['nome_sitartigo'] . "</span>";
                                            ?></td>
                                        <td class="text-center">
                                            <span class="d-none d-md-block">
                                                <?php
                                                if (isset($row_artigo['motivo_rejeicao'])) {
                                                    $row_artigo['motivo_rejeicao'] = "";
                                                }
                                                $row_artigo['motivo_rejeicao'] = "";
                                                $btn_vis = carregar_btn('visualizar/vis_artigo', $conn);
                                                if ($btn_vis) {
                                                    echo "<a href='" . pg . "/visualizar/vis_artigo_adm?id=" . $row_artigo['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                                }
                                                $btn_aceite = carregar_btn('processa/proc_aceite', $conn);
                                                if ($btn_aceite && $row_artigo['adms_sit_artigo_id'] == 1) {
                                                    echo "<a href='#' data-toggle='modal' data-target='#confirma_aceite' data-pg='" . pg . "' data-id='" . $row_artigo['id'] . "' class='btn btn-outline-success btn-sm'>Aceitar</a> ";
                                                }
                                                $btn_rejeita = carregar_btn('processa/proc_rejeita', $conn);
                                                if ($btn_rejeita && $row_artigo['adms_sit_artigo_id'] == 1) {
                                                    echo "<a href='#' data-toggle='modal' data-target='#confirma_rejeita' data-pg='" . pg . "' data-id='" . $row_artigo['id'] . "' class='btn btn-outline-danger btn-sm'>Rejeitar</a>";
                                                }
                                                $btn_publicado = carregar_btn('processa/proc_publicado', $conn);
                                                if ($btn_publicado && $row_artigo['adms_sit_artigo_id'] == 3) {
                                                    echo "<a href='#' data-toggle='modal' data-target='#confirma_publicacao' data-pg='" . pg . "' data-id='" . $row_artigo['id'] . "' class='btn btn-info btn-sm'>Publicado</a> ";
                                                }
                                                ?>

                                            </span>
                                            <div class="dropdown d-block d-md-none">
                                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Ações
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                                    <?php
                                                    if ($btn_vis) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/visualizar/vis_artigo_adm?id=" . $row_artigo['id'] . "'>Visualizar</a>";
                                                    }
                                                    if ($btn_aceite && $row_artigo['adms_sit_artigo_id'] == 1) {
                                                        echo "<a class='dropdown-item' href='#' data-toggle='modal' data-target='#confirma_aceite' data-pg='" . pg . "' data-id='" . $row_artigo['id'] . "' class='btn btn-outline-success btn-sm'>Aceitar</a> ";
                                                    }
                                                    if ($btn_rejeita && $row_artigo['adms_sit_artigo_id'] == 1) {
                                                        echo "<a class='dropdown-item' href='#' data-toggle='modal' data-target='#confirma_rejeita' data-pg='" . pg . "' data-id='" . $row_artigo['id'] . "' class='btn btn-outline-danger btn-sm'>Rejeitar</a>";
                                                    }
                                                    if ($btn_publicado && $row_artigo['adms_sit_artigo_id'] == 3) {
                                                        echo "<a class='dropdown-item' href='#' data-toggle='modal' data-target='#confirma_publicacao' data-pg='" . pg . "' data-id='" . $row_artigo['id'] . "' class='btn btn-info btn-sm'>Publicado</a> ";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        $result_pg = "SELECT COUNT(id) AS num_result FROM adms_artigos WHERE adms_usuario_id = '" . $_SESSION['id'] . "'";
                        $resultado_pg = mysqli_query($conn, $result_pg);
                        $row_pg = mysqli_fetch_assoc($resultado_pg);
                        //echo $row_pg['num_result'];
                        //Quantidade de pagina 
                        $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);
                        //Limitar os link antes depois
                        $max_links = 2;
                        echo "<nav aria-label='paginacao-blog'>";
                        echo "<ul class='pagination pagination-sm justify-content-center'>";
                        echo "<li class='page-item'>";
                        echo "<a class='page-link' href='" . pg . "/listar/list_artigo?pagina=1' tabindex='-1'>Primeira</a>";
                        echo "</li>";

                        for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                            if ($pag_ant >= 1) {
                                echo "<li class='page-item'><a class='page-link' href='" . pg . "/listar/list_artigo?pagina=$pag_ant'>$pag_ant</a></li>";
                            }
                        }

                        echo "<li class='page-item active'>";
                        echo "<a class='page-link' href='#'>$pagina</a>";
                        echo "</li>";

                        for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                            if ($pag_dep <= $quantidade_pg) {
                                echo "<li class='page-item'><a class='page-link' href='" . pg . "/listar/list_artigo?pagina=$pag_dep'>$pag_dep</a></li>";
                            }
                        }

                        echo "<li class='page-item'>";
                        echo "<a class='page-link' href='" . pg . "/listar/list_artigo?pagina=$quantidade_pg'>Última</a>";
                        echo "</li>";
                        echo "</ul>";
                        echo "</nav>";
                        ?>
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

    <!--Janela Modal Confirma Aceite-->
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
                    echo "<a href='" . pg . "/processa/proc_aceite?id=" . $row_artigo['id'] . "' type='button' class='btn btn-primary'>Sim</a>";
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!--Janela Modal Rejeita Artigo-->
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
                        echo $row_artigo['id'];
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

    <!--Janela Modal Publicacao-->
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
                        echo $row_artigo['id'];
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




