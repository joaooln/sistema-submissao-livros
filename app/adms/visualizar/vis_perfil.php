<?php
if (!isset($seg)) {
    exit;
}
$result_user_vis = "SELECT user.*,
            sit.nome nome_sit,
            cors.cor cor_cors,
            niv_ac.nome nome_niv_ac
            FROM adms_usuarios user
            INNER JOIN adms_sits_usuarios sit ON sit.id=user.adms_sits_usuario_id
            INNER JOIN adms_cors cors ON cors.id=sit.adms_cor_id
            INNER JOIN adms_niveis_acessos niv_ac ON niv_ac.id=user.adms_niveis_acesso_id
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
                                echo "<img src='" . pg . "/assets/imagens/usuario/" . $row_user_vis['id'] . "/" . $row_user_vis['imagem'] . "' width='150' height='150'>";
                            }
                            ?>
                        </dd>

                        <dt class="col-sm-3">ID</dt>
                        <dd class="col-sm-9"><?php echo $row_user_vis['id']; ?></dd>

                        <dt class="col-sm-3">Nome</dt>
                        <dd class="col-sm-9"><?php echo $row_user_vis['nome']; ?></dd>

                        <dt class="col-sm-3">Apelido</dt>
                        <dd class="col-sm-9"><?php echo $row_user_vis['apelido']; ?></dd>

                        <dt class="col-sm-3">E-mail</dt>
                        <dd class="col-sm-9"><?php echo $row_user_vis['email']; ?></dd>

                        <dt class="col-sm-3">Usuário</dt>
                        <dd class="col-sm-9"><?php echo $row_user_vis['usuario']; ?></dd>


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