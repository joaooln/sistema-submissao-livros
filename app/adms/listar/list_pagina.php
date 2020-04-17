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
                        <h2 class="display-4 titulo">Listar Página</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_cad = carregar_btn('cadastrar/cad_pagina', $conn);
                        if ($btn_cad) {
                            echo "<a href='" . pg . "/cadastrar/cad_pagina' class='btn btn-outline-success btn-sm'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }

                if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                    $resul_pg = "SELECT pg.id, pg.nome_pagina, pg.endereco, 
                            tpg.tipo
                            FROM adms_paginas pg
                            INNER JOIN adms_tps_pgs tpg ON tpg.id=pg.adms_tps_pg_id";
                } else {
                    /* $resul_niv_aces = "SELECT * FROM adms_niveis_acessos WHERE ordem > '" . $_SESSION['ordem'] . "' ORDER BY ordem ASC LIMIT $inicio, $qnt_result_pg"; */
                }
                $resultado_pg = mysqli_query($conn, $resul_pg);
                if (($resultado_pg) AND ( $resultado_pg->num_rows != 0)) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered" id="tablePages" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th class="d-none d-sm-table-cell">Endereço</th>
                                    <th class="d-none d-sm-table-cell">Tipo Página</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row_pg = mysqli_fetch_assoc($resultado_pg)) {
                                    ?>
                                    <tr>
                                        <th><?php echo $row_pg['id']; ?></th>
                                        <td><?php echo $row_pg['nome_pagina']; ?></td>
                                        <td class="d-none d-sm-table-cell"><?php echo $row_pg['endereco']; ?></td>
                                        <td class="d-none d-sm-table-cell"><?php echo $row_pg['tipo']; ?></td>
                                        <td class="text-center">
                                            <span class="d-none d-md-block">
                                                <?php
                                                $btn_vis = carregar_btn('visualizar/vis_pagina', $conn);
                                                if ($btn_vis) {
                                                    echo "<a href='" . pg . "/visualizar/vis_pagina?id=" . $row_pg['id'] . "' class='btn btn-outline-primary btn-sm' data-toggle='tooltip' data-placement='top' title='Visualizar'><i class='fas fa-eye'></i></a> ";
                                                }
                                                $btn_edit = carregar_btn('editar/edit_pagina', $conn);
                                                if ($btn_edit) {
                                                    echo "<a href='" . pg . "/editar/edit_pagina?id=" . $row_pg['id'] . "' class='btn btn-outline-warning btn-sm'data-toggle='tooltip' data-placement='top' title='Editar Página'><i class='fas fa-edit'></i></a> ";
                                                }
                                                $btn_apagar = carregar_btn('processa/apagar_pagina', $conn);
                                                if ($btn_apagar) {
                                                    echo "<a href='" . pg . "/processa/apagar_pagina?id=" . $row_pg['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?' data-toggle='tooltip' data-placement='top' title='Apagar Página'><i class='fas fa-trash'></i></a> ";
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
                                                        echo "<a class='dropdown-item' href='" . pg . "/visualizar/vis_pagina?id=" . $row_pg['id'] . "'>Visualizar</a>";
                                                    }
                                                    if ($btn_edit) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/editar/edit_pagina?id=" . $row_pg['id'] . "'>Editar</a>";
                                                    }
                                                    if ($btn_apagar) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/processa/apagar_pagina?id=" . $row_pg['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
            $('#tablePages').DataTable({
                "order": [[1, "asc"]],
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


