<?php

$chave = filter_input(INPUT_GET, 'chave', FILTER_SANITIZE_STRING);
if (!empty($chave)) {
    //Pesquisar qual usuário possui a chave
    $result_conf_email = "SELECT id FROM adms_usuarios WHERE conf_email='$chave' LIMIT 1";
    $resultado_conf_email = mysqli_query($conn, $result_conf_email);

    if (($resultado_conf_email) AND ( $resultado_conf_email->num_rows != 0)) {
        $row_conf_email = mysqli_fetch_assoc($resultado_conf_email);

        $result_up_conf_email = "UPDATE adms_usuarios SET
                conf_email = NULL,
                adms_sits_usuario_id = 1,
                modified = NOW()
                WHERE id='" . $row_conf_email['id'] . "'";
        mysqli_query($conn, $result_up_conf_email);

        if (mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'>E-mail validado com sucesso!</div>";
            $url_destino = pg . '/acesso/login';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Link inválido!</div>";
            $url_destino = pg . '/acesso/login';
            header("Location: $url_destino");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Link inválido!</div>";
        $url_destino = pg . '/acesso/login';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Link inválido!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}