<?php
if (!isset($seg)) {
    exit;
}
$result_user_vis = "SELECT user.*,
            sit.nome nome_sit,
            cors.cor cor_cors,
            niv_ac.nome nome_niv_ac,
            area.nome nome_area,
            titu.nome nome_titulo
            FROM adms_usuarios user
            INNER JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id
            INNER JOIN adms_cors cors ON cors.id=sit.adms_cor_id
            INNER JOIN adms_niveis_acessos niv_ac ON niv_ac.id=user.adms_niveis_acesso_id
            INNER JOIN adms_areas area ON area.id=user.adms_area_id
            INNER JOIN adms_titulacoes titu ON titu.id=user.adms_titulacao_id
            WHERE user.id=" . $_SESSION['id'] . " LIMIT 1";

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
                            <h2 class="display-4 titulo">Perfil</h2>
                        </div>
                        <div class="p-2">
                            <?php
                            $btn_edit = carregar_btn('editar/edit_perfil', $conn);
                            if ($btn_edit) {
                                echo "<a href='" . pg . "/editar/edit_perfil' class='btn btn-outline-warning btn-sm'>Editar </a> ";
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

                        <dt class="col-sm-3">Titulação</dt>
                        <dd class="col-sm-9"><?php echo $row_user_vis['nome_titulo']; ?></dd>

                        <dt class="col-sm-3">Área de Conhecimento</dt>
                        <dd class="col-sm-9"><?php echo $row_user_vis['nome_area']; ?></dd>

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
                        <dd class="col-sm-2">Estado: <?php echo $row_user_vis['estado']; ?></dd>
                        <dd class="col-sm-3">CEP: <?php echo $row_user_vis['cep']; ?></dd>

                        <dt class="col-sm-3">Recebe e-mail de chamadas?</dt>
                        <?php
                        if ($row_user_vis['recebe_email'] == 1) {
                            ?>
                            <dd class = "col-sm-9">Sim</dd>
                            <?php
                        }else {
                            ?>
                            <dd class = "col-sm-9">Não</dd>
                            <?php
                        }
                        ?>
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