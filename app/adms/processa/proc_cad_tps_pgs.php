<?php

if (!isset($seg)) {
    exit;
}
$SendCadTpsPgs = filter_input(INPUT_POST, 'SendCadTpsPgs', FILTER_SANITIZE_STRING);
if ($SendCadTpsPgs) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar o tipo de página!</div>";
    }

    //Houve erro em algum campo será redirecionado para o cadastrar tipo de página, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/cadastrar/cad_tps_pgs';
        header("Location: $url_destino");
    } else {
        //Pesquisar a última ordem do tipo de página
        $result_niv_ordem = "SELECT ordem FROM adms_tps_pgs ORDER BY ordem DESC LIMIT 1";
        $resultado_niv_ordem = mysqli_query($conn, $result_niv_ordem);
        $row_niv_ordem = mysqli_fetch_assoc($resultado_niv_ordem);
        $row_niv_ordem['ordem'] ++;
        
        $result_tps_pgs = "INSERT INTO adms_tps_pgs (tipo, nome, obs, ordem, created) VALUES (
                '" . $dados_validos['tipo'] . "',
                '" . $dados_validos['nome'] . "',
                '" . $dados_validos['obs'] . "',
                '".$row_niv_ordem['ordem']."',
                NOW())";
        mysqli_query($conn, $result_tps_pgs);
        if (mysqli_insert_id($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de página inserido com sucesso! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $url_destino = pg . '/listar/list_tps_pgs';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao inserir o tipo de página!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $url_destino = pg . '/cadastrar/cad_tps_pgs';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
