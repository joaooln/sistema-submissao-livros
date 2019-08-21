<?php

if (!isset($seg)) {
    exit;
}
$SendCadMenu = filter_input(INPUT_POST, 'SendCadMenu', FILTER_SANITIZE_STRING);
if ($SendCadMenu) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar o menu!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
    }

    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $url_destino = pg . '/cadastrar/cad_menu';
        header("Location: $url_destino");
    } else {
        //Pesquisar o mario número da ordem na tabela adms_menus
        $result_maior_ordem = "SELECT ordem FROM adms_menus ORDER BY ordem DESC LIMIT 1";
        $resultado_maior_ordem = mysqli_query($conn, $result_maior_ordem);
        $row_maior_ordem = mysqli_fetch_assoc($resultado_maior_ordem);
        $ordem = $row_maior_ordem['ordem'] + 1;

        $result_menu = "INSERT INTO adms_menus (nome, icone, ordem, adms_sit_id, created)
                VALUES (
                '" . $dados_validos['nome'] . "',
                '" . $dados_validos['icone'] . "',
                '" . $ordem . "' ,
                '" . $dados_validos['adms_sit_id'] . "',
                NOW())";
        mysqli_query($conn, $result_menu);
        if (mysqli_insert_id($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Menu cadastrado com sucesso!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
            $url_destino = pg . '/listar/list_menu';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao inserir o menu!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
            $url_destino = pg . '/cadastrar/cad_menu';
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
