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
                        <h2 class="display-4 titulo">Minhas Submissões</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_cad = carregar_btn('cadastrar/cad_artigo', $conn);
                        if ($btn_cad) {
                            echo "<a href='" . pg . "/visualizar/escolhe_tp_subm' class='btn btn-outline-success btn-sm'>Nova Submissão</a>";
                        }
                        ?>
                    </div>
                </div>
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }

                $resul_artigo = "SELECT artigo.id, artigo.tituloArtigo, artigo.tituloLivro, artigo.arquivo, artigo.adms_livro_id, sitartigo.nome nome_sitartigo, cors.cor cor_cors, artigo.adms_sit_artigo_id, livro.nome nome_livro
                            FROM adms_artigos artigo
                            LEFT JOIN adms_livros livro ON livro.id=artigo.adms_livro_id
                            INNER JOIN adms_usuarios user ON user.id=artigo.adms_usuario_id
                            INNER JOIN adms_sits_artigos sitartigo ON sitartigo.id=artigo.adms_sit_artigo_id
                            INNER JOIN adms_cors cors ON cors.id=sitartigo.adms_cor_id";

                $resultado_artigo = mysqli_query($conn, $resul_artigo);
                if (($resultado_artigo) AND ( $resultado_artigo->num_rows != 0)) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered" id="tableArtigos" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Código</th>
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
                                                $btn_vis = carregar_btn('visualizar/vis_artigo', $conn);
                                                if ($btn_vis) {
                                                    echo "<a href='" . pg . "/visualizar/vis_artigo?id=" . $row_artigo['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                                }
                                                $btn_edit = carregar_btn('editar/edit_artigo', $conn);
                                                if ($btn_edit) {
                                                    echo "<a href='" . pg . "/editar/edit_artigo?id=" . $row_artigo['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                                                }
                                                $btn_pagar = carregar_btn('pagseguro/checkout', $conn);
                                                if (($btn_pagar) && ($row_artigo['adms_sit_artigo_id'] == 2)) {
                                                    echo "<a href='" . pg . "/pagseguro/checkout?id=" . $row_artigo['id'] . "' class='btn btn-outline-danger btn-sm'>Pagar</a> ";
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
                                                        echo "<a class='dropdown-item' href='" . pg . "/visualizar/vis_artigo?id=" . $row_artigo['id'] . "'>Visualizar</a>";
                                                    }
                                                    if ($btn_edit) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/editar/edit_artigo?id=" . $row_artigo['id'] . "'>Editar</a>";
                                                    }
                                                    if (($btn_pagar) && ($row_artigo['adms_sit_artigo_id'] == 2)) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/pagseguro/checkout?id=" . $row_artigo['id'] . "' class='btn btn-outline-danger btn-sm'>Pagar</a> ";
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
    <script>
        $(document).ready(function () {
            $('#tableArtigos').DataTable({
                "order": [[0, "desc"]],
                "language": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    },
                    "select": {
                        "rows": {
                            "_": "Selecionado %d linhas",
                            "0": "Nenhuma linha selecionada",
                            "1": "Selecionado 1 linha"
                        }
                    }
                }
            });
        });
    </script>
</body>


