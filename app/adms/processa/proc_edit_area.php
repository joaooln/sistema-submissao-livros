<?php

if (!isset($seg)) {
    exit;
}
$SendEditArea = filter_input(INPUT_POST, 'SendEditArea', FILTER_SANITIZE_STRING);
if ($SendEditArea) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para editar a área!</div>";
    }

    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/editar/edit_area?id=' . $dados['id'];
        header("Location: $url_destino");
    } else {
        $result_pg_up = "UPDATE adms_areas SET
                nome='" . $dados_validos['nome'] . "', 
                modified=NOW() 
                WHERE id='" . $dados_validos['id'] . "'";

        mysqli_query($conn, $result_pg_up);

        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);
            $_SESSION['msg'] = "<div class='alert alert-success'>Área editada!</div>";
            $url_destino = pg . '/listar/list_area';
            header("Location: $url_destino");
        } else {
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Área não editada!</div>";
            $url_destino = pg . '/editar/edit_area?id=' . $dados['id'];
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
