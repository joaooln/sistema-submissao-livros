<?php

if (!isset($seg)) {
    exit;
}
$SendCadLivro = filter_input(INPUT_POST, 'SendCadLivro', FILTER_SANITIZE_STRING);
if ($SendCadLivro) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar o livro!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
    }

    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $url_destino = pg . '/cadastrar/cad_livro';
        header("Location: $url_destino");
    } else {
        $result_livro = "INSERT INTO adms_livros (nome, adms_area_id, adms_sit_id, data_publicacao, created)
                VALUES (
                '" . $dados_validos['nome'] . "',
                '" . $dados_validos['adms_area_id'] . "',
                '" . $dados_validos['adms_sit_id'] . "',
                '" . $dados_validos['data_publicacao'] . "',
                NOW())";
        mysqli_query($conn, $result_livro);
        if (mysqli_insert_id($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Livro cadastrado com sucesso!
                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button></div>";
            $url_destino = pg . '/listar/list_livro';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao inserir o livro!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
            $url_destino = pg . '/cadastrar/cad_livro';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
