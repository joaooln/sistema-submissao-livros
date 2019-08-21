<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
        $result_user = "SELECT id, imagem FROM adms_usuarios WHERE id='$id' LIMIT 1";
    } else {
        $result_user = "SELECT user.id, user.imagem
                FROM adms_usuarios user
                INNER JOIN adms_niveis_acessos niv_ac ON niv_ac.id=user.adms_niveis_acesso_id
                WHERE user.id='$id' AND niv_ac.ordem > '" . $_SESSION['ordem'] . "' LIMIT 1";
    }
    $resultado_user = mysqli_query($conn, $result_user);
    //Verificar se encontrou o usuário no banco de dados
    if (($resultado_user) AND ( $resultado_user->num_rows != 0)) {
        $row_user = mysqli_fetch_assoc($resultado_user);
        //Apagar o menu
        $result_user_del = "DELETE FROM adms_usuarios WHERE id='$id'";
        mysqli_query($conn, $result_user_del);
        if (mysqli_affected_rows($conn)) {
            //Apagar imagem
            if (!empty($row_user['imagem'])) {
                include_once 'lib/lib_upload.php';                
                $destino = "assets/imagens/usuario/" . $row_user['id'] . "/";
                $destino_apagar = $destino.$row_user['imagem'];
                apagarFoto($destino_apagar);
                apagarDiretorio($destino);
            }
            $_SESSION['msg'] = "<div class='alert alert-success'>Usuário apagado com sucesso!</div>";
            $url_destino = pg . '/listar/list_usuario';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O usuário não foi apagado!</div>";
            $url_destino = pg . '/listar/list_usuario';
            header("Location: $url_destino");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Usuário não encontrada!</div>";
        $url_destino = pg . '/listar/list_usuario';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

