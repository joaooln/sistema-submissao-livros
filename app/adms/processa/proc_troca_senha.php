<?php

if (!isset($seg)) {
    exit;
}
$SendTrocaSenha = filter_input(INPUT_POST, 'SendTrocaSenha', FILTER_SANITIZE_STRING);
if ($SendTrocaSenha) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para trocar a senha!</div>";
    }

    if (strcmp($dados_validos['nova_senha'], $dados_validos['nova_senha_conf']) != 0) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>As senhas não conferem!</div>";
    }
//validar senha
    elseif ((strlen($dados_validos['nova_senha'])) < 8) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>A senha deve ter no mínimo 8 caracteres!</div>";
    } elseif (stristr($dados_validos['nova_senha'], "'")) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Caracter ( ' ) utilizado na senha inválido!</div>";
    }

//Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/editar/troca_senha?id=' . $dados['id'];
        header("Location: $url_destino");
    } else {
        //Criptografar a senha
        $dados_validos['nova_senha'] = password_hash($dados_validos['nova_senha'], PASSWORD_DEFAULT);

        $result_senha_up = "UPDATE adms_usuarios SET
                senha='" . $dados_validos['nova_senha'] . "', 
                modified=NOW() 
                WHERE id='" . $dados['id'] . "'";

        mysqli_query($conn, $result_senha_up);

        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);
            $_SESSION['msg'] = "<div class='alert alert-success'>Senha atualizada com sucesso!</div>";
            $url_destino = pg . '/visualizar/vis_perfil';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao atualizar a senha!</div>";
            $url_destino = pg . '/visualizar/vis_perfil';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
