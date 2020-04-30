<?php

include_once 'lib/lib_env_email.php';
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
if (!isset($seg)) {
    exit;
}
$SendArquivar = filter_input(INPUT_POST, 'SendArquivar', FILTER_SANITIZE_STRING);

if ($SendArquivar) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $result_artigo_arquivar = "SELECT artigo.id
            FROM adms_artigos artigo
            WHERE artigo.id=" . $dados['id'] . " LIMIT 1";
    $resultado_artigo_arquivar = mysqli_query($conn, $result_artigo_arquivar);

    //Retornou algum valor do banco de dados e acesso o IF, senão acessa o ELSe
    if (($resultado_artigo_arquivar) AND ( $resultado_artigo_arquivar->num_rows != 0)) {
        $row_artigo_arquivar = mysqli_fetch_assoc($resultado_artigo_arquivar);
        //Verificar se o artigo está em status 1 - em avaliação
        include_once 'lib/lib_valida.php';
        //Atualiza o Status
        $result_artigo_arquivar_up = "UPDATE adms_artigos SET
                adms_sit_artigo_id=7,
                modified=NOW()
                WHERE id=" . $dados['id'] . "";
        $resultado_artigo_arquivar_up = mysqli_query($conn, $result_artigo_arquivar_up);
        if (mysqli_affected_rows($conn)) {
            $alteracao = true;
        } else {
            $alteracao = false;
        }

        //Redirecionar o usuário
        if ($alteracao) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Submissão arquivado em sucesso!</div>";
            $url_destino = pg . "/listar/list_artigo_adm";
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro arquivar submissão!</div>";
            $url_destino = pg . "/listar/list_artigo_adm";
            header("Location: $url_destino");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Submissão não encontrada</div>";
        $url_destino = pg . "/listar/list_artigo_adm";
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/listar/list_artigo_adm';
    header("Location: $url_destino");
}
