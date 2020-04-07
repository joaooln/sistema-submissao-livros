<?php

if (!isset($seg)) {
    exit;
}
$SendCadArea = filter_input(INPUT_POST, 'SendCadArea', FILTER_SANITIZE_STRING);
if ($SendCadArea) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar a area!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
    }

    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $url_destino = pg . '/cadastrar/cad_area';
        header("Location: $url_destino");
    } else {
        $result_area = "INSERT INTO adms_areas (nome, created)
                VALUES (
                '" . $dados_validos['nome'] . "',
                NOW())";
        mysqli_query($conn, $result_area);
        if (mysqli_insert_id($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'>´Área cadastrada com sucesso!
                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button></div>";
            $url_destino = pg . '/listar/list_area';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao inserir a área!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
            $url_destino = pg . '/cadastrar/cad_area';
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
