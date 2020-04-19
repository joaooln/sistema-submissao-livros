<?php

include_once 'lib/lib_env_email.php';
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$SendSenhaAtual = filter_input(INPUT_POST, 'SendSenhaAtual', FILTER_SANITIZE_STRING);
//$motivo_rejeite = mysqli_real_escape_string($conn, $_POST['motivo_rejeicao']);
if ($SendSenhaAtual) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $result_user_conf = "SELECT user.id, user.senha
            FROM adms_usuarios user
            WHERE user.id=" . $dados['id'] . " LIMIT 1";
    $resultado_user_conf = mysqli_query($conn, $result_user_conf);

    //Retornou algum valor do banco de dados e acesso o IF, senão acessa o ELSe
    if (($resultado_user_conf) AND ( $resultado_user_conf->num_rows != 0)) {
        $row_user_conf = mysqli_fetch_assoc($resultado_user_conf);
        //Verificar se a senha esta correta
        if (password_verify($dados['senha_atual'], $row_user_conf['senha'])) {
            //Redirecionar o usuário
            $url_destino = pg . "/editar/troca_senha?id=" . $row_user_conf['id'] . "";
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Senha inválida!</div>";
            $url_destino = pg . "/visualizar/vis_perfil";
            header("Location: $url_destino");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Usuário não encontrado</div>";
        $url_destino = pg . "/visualizar/vis_perfil";
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
