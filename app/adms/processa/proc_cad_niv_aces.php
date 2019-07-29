<?php

if (!isset($seg)) {
    exit;
}
$SendCadNivAc = filter_input(INPUT_POST, 'SendCadNivAc', FILTER_SANITIZE_STRING);
if ($SendCadNivAc) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar nível de acesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
    }

    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $url_destino = pg . '/cadastrar/cad_niv_aces';
        header("Location: $url_destino");
    } else {
        // Pesquisar a última ordem do nível de acesso
        $result_niv_ordem = "SELECT ordem FROM adms_niveis_acessos ORDER BY ordem DESC LIMIT 1";
        $resultado_niv_ordem = mysqli_query($conn, $result_niv_ordem);
        $row_niv_ordem = mysqli_fetch_assoc($resultado_niv_ordem);
        $row_niv_ordem['ordem']++;
        
        $result_niv_ac = "INSERT INTO adms_niveis_acessos (nome, ordem, created) VALUES ('" . $dados_validos['nome'] . "', '" .  $row_niv_ordem['ordem'] . "' , NOW())";
        mysqli_query($conn, $result_niv_ac);
        if (mysqli_insert_id($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Nível de acesso cadastrado com sucesso!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
            $url_destino = pg . '/listar/list_niv_aces';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao inserir o nível de acesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button></div>";
            $url_destino = pg . '/cadastrar/cad_niv_aces';
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
