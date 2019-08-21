<?php

if (!isset($seg)) {
    exit;
}
$SendEditCadUser = filter_input(INPUT_POST, 'SendEditCadUser', FILTER_SANITIZE_STRING);
if ($SendEditCadUser) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para editar!</div>";
    } 

    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/editar/edit_cad_user_login';
        header("Location: $url_destino");
    } else {
        $result_pg_up = "UPDATE adms_cads_usuarios SET
                env_email_conf = '" . $dados_validos['env_email_conf'] . "', 
                adms_niveis_acesso_id='" . $dados_validos['adms_niveis_acesso_id'] . "', 
                adms_sits_usuario_id='" . $dados_validos['adms_sits_usuario_id'] . "',
                modified=NOW() 
                WHERE id='1'";
        
        mysqli_query($conn, $result_pg_up);
               
        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);            
            $_SESSION['msg'] = "<div class='alert alert-success'>Formulário cadastrar usuário editado com sucesso!</div>";
            $url_destino = pg . '/editar/edit_cad_user_login';
            header("Location: $url_destino");
        } else {
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Formulário cadastrar usuário não editado!</div>";
            $url_destino = pg . '/editar/edit_cad_user_login';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
