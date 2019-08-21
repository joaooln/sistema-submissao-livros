<?php

if (!isset($seg)) {
    exit;
}
$SendEditTpsPgs = filter_input(INPUT_POST, 'SendEditTpsPgs', FILTER_SANITIZE_STRING);
if ($SendEditTpsPgs) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para editar o tipo de página!</div>";
    }

    //Houve erro em algum campo será redirecionado para o formulário editar tipo de página, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/editar/edit_tps_pgs?id='.$dados['id'];
        header("Location: $url_destino");
    } else {
                
        $result_tps_pgs_up = "UPDATE adms_tps_pgs SET
                tipo='".$dados_validos['tipo']."',
                nome='".$dados_validos['nome']."',
                obs='".$dados_validos['obs']."',
                modified=NOW() 
                WHERE id='".$dados_validos['id']."'";
        mysqli_query($conn, $result_tps_pgs_up);
        if (mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de página editado com sucesso! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $url_destino = pg . '/listar/list_tps_pgs';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao editar o tipo de página!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $url_destino = pg . '/editar/edit_tps_pgs?id='.$dados['id'];
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
