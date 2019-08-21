<?php

if (!isset($seg)) {
    exit;
}
$SendEditCredEmail = filter_input(INPUT_POST, 'SendEditCredEmail', FILTER_SANITIZE_STRING);
if ($SendEditCredEmail) {
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
        $url_destino = pg . '/editar/edit_cred_email';
        header("Location: $url_destino");
    } else {
        $result_pg_up = "UPDATE adms_confs_emails SET
                nome = '" . $dados_validos['nome'] . "', 
                email='" . $dados_validos['email'] . "', 
                host='" . $dados_validos['host'] . "',
                usuario='" . $dados_validos['usuario'] . "',
                senha='" . $dados_validos['senha'] . "',
                smtpsecure='" . $dados_validos['smtpsecure'] . "',
                porta='" . $dados_validos['porta'] . "',
                modified=NOW() 
                WHERE id='1'";
        
        mysqli_query($conn, $result_pg_up);
               
        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);            
            $_SESSION['msg'] = "<div class='alert alert-success'>Credenciais do e-mail editado com sucesso!</div>";
            $url_destino = pg . '/editar/edit_cred_email';
            header("Location: $url_destino");
        } else {
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Credenciais do e-mail não editado!</div>";
            $url_destino = pg . '/editar/edit_cred_email';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
