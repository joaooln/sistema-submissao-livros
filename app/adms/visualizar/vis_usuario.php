<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
        $result_user_vis = "SELECT user.*,
            sit.nome nome_sit,
            cors.cor cor_cors,
            niv_ac.nome nome_niv_ac
            FROM adms_usuarios user
            INNER JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id
            INNER JOIN adms_cors cors ON cors.id=sit.adms_cor_id
            INNER JOIN adms_niveis_acessos niv_ac ON niv_ac.id=user.adms_niveis_acesso_id
            WHERE user.id=$id LIMIT 1";
    } else {
        $result_user_vis = "SELECT user.*,
            sit.nome nome_sit,
            cors.cor cor_cors,
            niv_ac.nome nome_niv_ac
            FROM adms_usuarios user
            INNER JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id
            INNER JOIN adms_cors cors ON cors.id=sit.adms_cor_id
            INNER JOIN adms_niveis_acessos niv_ac ON niv_ac.id=user.adms_niveis_acesso_id
            WHERE user.id=$id AND niv_ac.ordem > '" . $_SESSION['ordem'] . "' LIMIT 1";
    }
    $resultado_user_vis = mysqli_query($conn, $result_user_vis);
    if (($resultado_user_vis) AND ( $resultado_user_vis->num_rows != 0)) {
        $row_user_vis = mysqli_fetch_assoc($resultado_user_vis);
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
                                <h2 class="display-4 titulo">Detalhes do Usuário</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregar_btn('listar/list_usuario', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/list_usuario' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_edit = carregar_btn('editar/edit_usuario', $conn);
                                    if ($btn_edit) {
                                        echo "<a href='" . pg . "/editar/edit_usuario?id=" . $row_user_vis['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                                    }
                                    $btn_apagar = carregar_btn('processa/apagar_usuario', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/apagar_usuario?id=" . $row_user_vis['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                            echo "<a class='dropdown-item' href='" . pg . "/listar/list_usuario'>Listar</a>";
                                        }
                                        if ($btn_edit) {
                                            echo "<a class='dropdown-item' href='" . pg . "/editar/edit_usuario?id=" . $row_user_vis['id'] . "'>Editar</a>";
                                        }
                                        if ($btn_apagar) {
                                            echo "<a class='dropdown-item' href='" . pg . "/processa/apagar_usuario?id=" . $row_user_vis['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div><hr>
                        <dl class="row">                            
                            <dt class="col-sm-3">Imagem</dt>
                            <dd class="col-sm-9">
                                <?php
                                if (!empty($row_user_vis['imagem'])) {
                                    echo "<img src='" . pg . "/assets/imagens/usuario/" . $row_user_vis['id'] . "/" . $row_user_vis['imagem'] . "' width='200' height='200'>";
                                } else {
                                    echo "<img src='" . pg . "/assets/imagens/usuario/preview_img.png' width='200' height='200'>";
                                }
                                ?>
                            </dd>

                            <dt class="col-sm-3">ID</dt>
                            <dd class="col-sm-9"><?php echo $row_user_vis['id']; ?></dd>

                            <dt class="col-sm-3">Nome</dt>
                            <dd class="col-sm-9"><?php echo $row_user_vis['nome']; ?></dd>

                            <dt class="col-sm-3">CPF</dt>
                            <dd class="col-sm-9"><?php echo $row_user_vis['cpf']; ?></dd>
                            
                            <dt class="col-sm-3">Telefone</dt>
                            <dd class="col-sm-9"><?php echo $row_user_vis['telefone']; ?></dd>

                            <dt class="col-sm-3">E-mail</dt>
                            <dd class="col-sm-9"><?php echo $row_user_vis['email']; ?></dd>

                            <dt class="col-sm-3">Endereço</dt>
                            <dd class="col-sm-6"><?php echo $row_user_vis['rua']; ?></dd>
                            <dd class="col-sm-3">Nº <?php echo $row_user_vis['num_end']; ?></dd>
                            
                            <dt class="col-sm-3"></dt>
                            <dd class="col-sm-4">Bairro: <?php echo $row_user_vis['bairro']; ?></dd>
                            <dd class="col-sm-4">Complemento: <?php echo $row_user_vis['complemento']; ?></dd>
                            
                            <dt class="col-sm-3"></dt>
                            <dd class="col-sm-4">Cidade: <?php echo $row_user_vis['cidade']; ?></dd>
                            <dd class="col-sm-2">Estado: <?php echo $row_user_vis['complemento']; ?></dd>
                            <dd class="col-sm-3">CEP: <?php echo $row_user_vis['cep']; ?></dd>

                            <dt class="col-sm-3">Nível de Acesso</dt>
                            <dd class="col-sm-9"><?php echo $row_user_vis['nome_niv_ac']; ?></dd>

                            <dt class="col-sm-3">Situação</dt>
                            <dd class="col-sm-9"><?php
                                echo "<span class='badge badge-" . $row_user_vis['cor_cors'] . "'>" . $row_user_vis['nome_sit'] . "</span>";
                                ?></dd>

                            <dt class="col-sm-3 text-truncate">Data do Cadastro</dt>
                            <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($row_user_vis['created'])); ?></dd>

                            <dt class="col-sm-3 text-truncate">Data de Edição</dt>
                            <dd class="col-sm-9"><?php
                                if (!empty($row_user_vis['modified'])) {
                                    echo date('d/m/Y H:i:s', strtotime($row_user_vis['modified']));
                                }
                                ?></dd>

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
        $_SESSION['msg'] = "<div class='alert alert-danger'>Usuário não encontrado!</div>";
        $url_destino = pg . '/listar/list_usuario';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}