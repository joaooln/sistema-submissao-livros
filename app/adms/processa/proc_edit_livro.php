<?php

if (!isset($seg)) {
    exit;
}
$SendEditLivro = filter_input(INPUT_POST, 'SendEditLivro', FILTER_SANITIZE_STRING);
if ($SendEditLivro) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para editar o menu!</div>";
    }

    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/editar/edit_livro?id=' . $dados['id'];
        header("Location: $url_destino");
    } else {
        $result_pg_up = "UPDATE adms_livros SET
                nome='" . $dados_validos['nome'] . "', 
                adms_area_id='" . $dados_validos['adms_areas_id'] . "', 
                adms_sit_id='" . $dados_validos['adms_sits_id'] . "',
                data_publicacao='" . $dados_validos['data_publicacao'] . "',
                modified=NOW() 
                WHERE id='" . $dados_validos['id'] . "'";

        mysqli_query($conn, $result_pg_up);

        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);
            $_SESSION['msg'] = "<div class='alert alert-success'>Livro editado!</div>";
            $url_destino = pg . '/listar/list_livro';
            header("Location: $url_destino");
        } else {
            $dados['obs'] = trim($dados_obs);
            $dados['icone'] = $dados_icone;
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Livro não editado!</div>";
            $url_destino = pg . '/editar/edit_livro?id=' . $dados['id'];
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
