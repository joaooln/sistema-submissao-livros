<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$SendPublicado = filter_input(INPUT_POST, 'SendPublicado', FILTER_SANITIZE_STRING);
if ($SendPublicado) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $result_artigo_aceite = "SELECT artigo.id, artigo.adms_sit_artigo_id
            FROM adms_artigos artigo
            WHERE artigo.id='" . $dados['id'] . "' LIMIT 1";
    $resultado_artigo_aceite = mysqli_query($conn, $result_artigo_aceite);

    //Retornou algum valor do banco de dados e acesso o IF, senão acessa o ELSe
    if (($resultado_artigo_aceite) AND ( $resultado_artigo_aceite->num_rows != 0)) {
        $row_artigo_aceite = mysqli_fetch_assoc($resultado_artigo_aceite);
        //Verificar se o artigo está em status 1 - em avaliação
        $status = 5;
        //Atualiza o Status
        $result_artigo_aceite_up = "UPDATE adms_artigos SET
                data_publicacao = '" . $dados['data_publicacao'] . "',
                url_livro = '" . $dados['link_livro'] . "',
                adms_sit_artigo_id='$status',
                modified=NOW()
                WHERE id='" . $dados['id'] . "'";
        $resultado_artigo_aceite_up = mysqli_query($conn, $result_artigo_aceite_up);
        if (mysqli_affected_rows($conn)) {
            $alteracao = true;
        } else {
            $alteracao = false;
        }
        
        echo $result_artigo_aceite_up;
        
        //Redirecionar o usuário
        if ($alteracao) {
            //$_SESSION['msg'] = "<div class='alert alert-success'>Publicação efetuada em sucesso!</div>";
            //$url_destino = pg . "/listar/list_artigo_adm";
            //header("Location: $url_destino");
        } else {
            //$_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao efetuar a Publicação!</div>";
            //$url_destino = pg . "/listar/list_artigo_adm";
            //header("Location: $url_destino");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Artigo não encontrado</div>";
        $url_destino = pg . "/listar/list_artigo_adm";
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
