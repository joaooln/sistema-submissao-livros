<?php

include_once 'lib/lib_env_email.php';
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$SendCadSuporte = filter_input(INPUT_POST, 'SendCadSuporte', FILTER_SANITIZE_STRING);
if ($SendCadSuporte) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //Redirecionar o usuário
    $nome = explode(" ", $dados['nome']);
    $prim_nome = $nome[0];

    $assunto = "Solicitação de suporte";

    $mensagem = "Solicitação de suporte<br><br>"
            . "Nome: " . $dados['nome'] . "<br>"
            . "E-mail: " . $dados['email'] . "<br>"
            . "Telefone: " . $dados['fone'] . "<br>"
            . "Mensagem: <br>"
            . $dados['mensagem'];

    $mensagem_texto = "Solicitação de suporte "
            . "Nome: " . $dados['nome'] . " "
            . "E-mail: " . $dados['email'] . " "
            . "Telefone: " . $dados['fone'] . " "
            . "Mensagem: "
            . $dados['mensagem'];

    if (email_phpmailer_contato($assunto, $mensagem, $mensagem_texto, $prim_nome, $dados['email'], $conn)) {
        $_SESSION['msg'] = "<div class='alert alert-success'>Mensagem enviada com sucesso. Em breve retornaremos o contato!</div>";
        $url_destino = pg . "/cadastrar/cad_suporte_email";
        header("Location: $url_destino");
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao enviar a mensagem!</div>";
        $url_destino = pg . "/cadastrar/cad_suporte_email";
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
